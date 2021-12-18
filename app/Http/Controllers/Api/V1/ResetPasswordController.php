<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends ApiController
{
    use ResetsPasswords;


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

            // return response()->json($request->all());

            $response = $this->broker()->reset(
                $this->credentials($request), function($user, $password){
                    $this->resetPassword($user, $password);
                }
            );

            if($response == Password::PASSWORD_RESET){
                $this->response['message'] = trans($response);
                return $this->respondWithSuccess($this->response);
            }
            else {
                $this->response['message'] = "The token has been expired.";
                return $this->respondWithError($this->response);    
            }

        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }
}
