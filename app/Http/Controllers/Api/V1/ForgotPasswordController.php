<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends ApiController
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
     *      path="/api/v1/guest/password/forgot",
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

   
}
