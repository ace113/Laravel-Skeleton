<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class GuestController extends ApiController
{
    use SendsPasswordResetEmails;
    
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    ){
        $this->userRepository = $userRepository;
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
            \DB::beginTransaction();
            $request->role_id = 3; // adding user role
            /** HANDLING UNIQUE INDEX OF EMAIL */
            $user = $this->userRepository->findUserByEmail($request->email);
            if($user){
                if($user->email_verified_at){
                    $this->response['message'] = 'This email has aleardy been taken.';
                    return $this->respondWithCustomCode($this->response, EXPECATION_FAILED);
                }
            }

            $result = $this->userRepository->createUser($user);
            if(!$result){
                $this->response['message'] = $e->getMessage();
                return $this->respondWithError($this->response);
            }
            \DB::commit();
            // ** Send Verification message
            $this->response['message'] = 'User created successfully.';
            $this->response['data'] = $results;
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
            }else if($user->role_id != 3){
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

    public function getPage(Request $request, $slug){}

    public function forgotPassword(Request $request){}
}
