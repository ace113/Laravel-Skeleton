<?php

namespace App\Http\Controllers\Api\V1;

use App\Mail\ActivationMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Transformers\UserTransformer;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class GuestController extends ApiController
{
    use SendsPasswordResetEmails;
    
    protected $userRepository;
    protected $userTransformer;
    protected $pageRepository;

    public function __construct(
        UserRepository $userRepository,
        UserTransformer $userTransformer,
        PageRepository $pageRepository
    ){
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
        $this->pageRepository = $pageRepository;
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
            $request->email_verification_token = $this->generateVerificationToken();
            // return print_r(gettype($request));die();
            \DB::beginTransaction();
            
            /** HANDLING UNIQUE INDEX OF EMAIL */
            $user = $this->userRepository->findUserByEmail($request->email);
            if($user){
                if(!$user->email_verified_at){
                    $this->response['message'] = 'This email has already been taken.';
                    return $this->respondWithCustomCode($this->response, EXPECTATION_FAILED);
                }
            }

            $userJson = $this->userTransformer->createJson($request);

            $new_user = $this->userRepository->createUser($userJson);
            
            \DB::commit();
            // ** Send Verification message
            Mail::to($new_user->email)->send(new ActivationMail($new_user));

            $this->response['message'] = 'User created successfully.';
            $this->response['data'] = $new_user;
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
                $this->response['message'] = 'Your previous signup did not complete. Please sign up again.';
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



    public function verifyContact(Request $request)
    {}

    public function sendVerificationEmail(Request $request){}

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

    protected function generateVerificationToken(){
        return \Str::random(32);
    }
}
