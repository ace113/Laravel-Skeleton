<?php

namespace App\Http\Controllers\Api\V1;

use App\Mail\ActivationMail;
use Illuminate\Http\Request;
use App\Services\TwilioService;
use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Transformers\UserTransformer;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class GuestController extends ApiController
{
    use SendsPasswordResetEmails;
    use VerifiesEmails;
    use ResetsPasswords;

    
    protected $userRepository;
    protected $userTransformer;
    protected $pageRepository;
    protected $twilioService;

    public function __construct(
        UserRepository $userRepository,
        UserTransformer $userTransformer,
        PageRepository $pageRepository,
        TwilioService $twilioService
    ){
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
        $this->pageRepository = $pageRepository;
        // $this->middleware('signed')->only('verifyEmail');
        // $this->middleware('throttle:6,1')->only('verifyEmail', 'sendVerificationEmail');
        $this->twilioService = $twilioService;
    }

    /**
     * @OA\Post(
     *  path="/api/v1/guest/register",
     *  operationId="register",
     *  summary="Register New User",
     *  description="Registers new users",
     *  tags={"Guest"},
     *  @OA\RequestBody(
     *      @OA\JsonContent(ref="#/components/schemas/Register"),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Successful Operation",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Bad Request",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthenticated",
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *  ),
     * )
     */
    public function register(RegisterRequest $request)
    { 
        try {         
            $request->role_id = 3; // adding user role
            $request->email_verify_token = $this->generateVerificationToken();
            // return print_r(gettype($request));die();
           
            \DB::beginTransaction();
            
            /** HANDLING UNIQUE INDEX OF EMAIL */
            $user = $this->userRepository->findUserByEmail($request->email);
            if($user){
                if($user->email_verified_at){
                    $this->response['message'] = 'This email has already been taken.';
                    return $this->respondWithCustomCode($this->response, EXPECTATION_FAILED);
                }
                $userJson = $this->userTransformer->createJson($request);
                
                // update user
                $updateUser = $this->userRepository->updateUserById($user->id, $userJson);
              
            }else{
                $userJson = $this->userTransformer->createJson($request);

                $user = $this->userRepository->createUser($userJson);
            }

            // ** Send Verification message
            Mail::to($user->email)->send(new ActivationMail($user));
            \DB::commit();
           

            $this->response['message'] = 'User created successfully.';
            $this->response['data'] = $user;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            \DB::rollBack();
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/guest/login",
     *      operationId="Login",
     *      tags={"Guest"},
     *      summary="User Login",
     *      description="User login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Login"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userRepository->findUserByEmail($request->email);
            if(!$user)
            {
                $this->response['message'] = 'Invalid Credentials.';
                return $this->respondWithCustomCode($this->response, HTTP_UNAUTHORIZED);    
            }else if(!Hash::check($request->password, $user->password)){
                $this->response['message'] = 'Invalid Password.';
                return $this->respondWithCustomCode($this->response, HTTP_UNAUTHORIZED);
            }else if($user->role_id == 1){
                $this->response['message'] = 'Invalid Role.';
                return $this->respondWithCustomCode($this->response, HTTP_UNAUTHORIZED);
            }else if(!$user->email_verified_at){
                $this->response['message'] = 'Your email has not been verified. Please verify you email address.';
                return $this->respondWithCustomCode($this->response, HTTP_UNAUTHORIZED);
            }else if(!$user->status){
                $this->response['message'] = 'Your account has been disabled.';
                return $this->respondWithCustomCode($this->response, HTTP_UNAUTHORIZED);
            }   

            // create token
            $token = $user->createToken('Auth Token')
                        ->accessToken;

            $headers['access_token'] = 'Bearer '.$token;

            $user->access_token = 'Bearer '.$token;

            $data = $user->toArray();

            $this->response['message']= 'User logged in successfully.';
            $this->response['data'] = $data;
            return $this->respondWithHeaders($this->response, $headers);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/guest/register/verifyEmail",
     *      operationId="Verifies Email",
     *      tags={"Guest"},
     *      summary="Verifies Email",
     *      description="Verifies the email",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\JsonContent(
     *              required={"expires", "id", "hash", "signature"},
     *              @OA\Property(
     *                  property="expires",
     *                  type="string",
     *                  example="163877180"
     *              ),
     *              @OA\Property(
     *                  property="id",
     *                  type="string",
     *                  example="16"
     *              ),
     *              @OA\Property(
     *                  property="hash",
     *                  type="string",
     *                  example="a2675156297f4d2806e00f12d1aebe77b4492975"
     *              ),
     *              @OA\Property(
     *                  property="signature",
     *                  type="string",
     *                  example="fc559b82958efe6f9817161b63a9b0541f39e33f46701ede7b4b9d20d1247beb"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operation Successfull"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function verifyEmail(Request $request){
        try {
            // return response()->json($request->hasValidSignature());die();
            if(!$request->hasValidSignature()){
                $this->response['message'] = "This verification link has expired.";
                return $this->respondWithCustomCode($this->response, VERIFICATION_TOKEN_EXPIRED);
            }
            $user = $this->userRepository->getUserById($request->id);
            if(!$user){
                $this->response['message'] = "No account associated with this email was found.";
                return $this->respondWithError($this->response);
            }
            if($user->hasVerifiedEmail()){
                $this->response['message'] = "Email has already been verified.";
                return $this->respondWithCustomCode($this->response, EMAIL_ALREADY_VERIFIED);
            }
            if($request->hash !== $user->email_verify_token){
                $this->response['message'] = "The verification token doesn't match.";
                return $this->respondWithError($this->response);
            }
            if($user->markEmailAsVerified()){
                event(new Verified($user));
                $this->response['message'] = "Verification successfull";
                return $this->respondWithSuccess = $this->response;
            }

        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    public function verifyContact(Request $request)
    {}

    /**
     * @OA\Post(
     *      path="/api/v1/guest/sendVerificationEmail",
     *      operationId="Send Verification Email",
     *      tags={"Guest"},
     *      summary="Resend Verification Email",
     *      description="Resend verification email",
     *      @OA\RequestBody(
     *          required=true,
     *          description="required params",
     *          @OA\JsonContent(
     *              required={"email"},
     *              @OA\Property(
     *                  property="email",
     *                  format="email",
     *                  type="email",
     *                  example="user@mail.com",
     *              ), 
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operation Successful",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      )
     * )
     */
    public function sendVerificationEmail(Request $request){
        try {
            $user = $this->userRepository->findUserByEmail($request->email);
            if(!$user){
                $this->response['message'] = 'No account associated with this email was found.';
                return $this->respondWithError($this->response);
            }
            if($user->hasVerifiedEmail()){
                $this->response['message'] = "Email has already been verified.";
                return $this->respondWithCustomCode($this->response, EMAIL_ALREADY_VERIFIED);
            }
            Mail::to($user->email)->send(new ActivationMail($user));
            $this->response['message'] = 'Verification mail has been sent!';
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    public function sendPhoneVerificationToken(Request $request){}

    /**
     * @OA\Get(
     *      path="/api/v1/guest/pages/{slug}",
     *      operationId="getPages",
     *      summary="Get Page",
     *      description="Gets pages from slug",
     *      tags={"Guest"},
     *      @OA\Parameter(
     *          name="slug",
     *          description="Page Slug",
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      )
     * )
     */
    public function getPage($slug)
    {
        try {
            $page = $this->pageRepository->getPageBySlug($slug);
            if(!$page){
                $this->response['message'] = 'Page Not Found.';                
                return $this->respondWithError($this->response);
            }
          
            $this->response['data'] = $page;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/guest/password/email",
     *      operationId="resetLinkEmail",
     *      summary="send reset link",
     *      description="Send user reset password email",
     *      tags={"Guest"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="user@user.com",
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function resetLinkEmail(Request $request){
        try {
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = $this->userRepository->findUserByEmail($request->email);
            
            if(!$user){
                $this->response['message'] = "No account associated with this email was found.";
                return $this->respondWithError($this->response);
            }

            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );

            if($response == Password::RESET_LINK_SENT){
                $this->response['message'] = trans($response);
                return $this->respondWithSuccess($this->response);
            }
            else {
                $this->response['message'] = trans($response);
                return $this->respondWithError($this->response);    
            }
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/guest/password/reset",
     *      operationId="resetPassword",
     *      summary="Reset password",
     *      description="Reset password",
     *      tags={"Guest"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="user@user.com",
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="password",
     *                  example="password",
     *              ),
     *              @OA\Property(
     *                  property="token",
     *                  type="string",
     *                  example="sadfalskdjflaksjdfiasjfdioasdofjewruopweur",
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function reset(Request $request){
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            $response = $this->broker()->reset(
                $this->credentials($request), function($user, $password){
                    $this->resetPassword($user, $password);
                }
            );
    
            $this->response['message'] = $response;

            return $response == Password::PASSWORD_RESET 
                    ? $this->respondWithSuccess($this->response)
                    : $this->respondWithError($this->response);

        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    protected function generateVerificationToken(){
        return \Str::random(32);
    }

    public function testSms(Request $request){
        $data = new \StdClass();

        $data->code = "1234";

        return $this->twilioService->sendMessage($data);
    }
}
