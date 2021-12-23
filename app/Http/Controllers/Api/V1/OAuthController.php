<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OAuthProvider;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\V1\ApiController;

class OAuthController extends ApiController
{
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    ){
        $this->userRepository = $userRepository;
    }
    
    /**
     * @OA\Get(
     *      path="/api/v1/guest/login/{provider}",
     *      operationId="oauthLogin",
     *      summary="OauthLogin",
     *      description="Oauth login",
     *      tags={"Guest"},
     *      @OA\Parameter(
     *          name="provider",
     *          description="Provider name like google, facebook etc",
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
    public function loginRedirect(Request $request, $provider)
    {
        try {
            $provider = strtolower($provider);
            $googleUser = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
            if($googleUser){
                $this->response['data'] = $googleUser;
                return $this->respondWithSuccess($this->response);
            }
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithExcepiton($this->response);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/guest/login/{provider}/callback",
     *      operationId="oauthLogin callback",
     *      summary="OauthLogin callback",
     *      description="Oauth login callback",
     *      tags={"Guest"},
     *      @OA\Parameter(
     *          name="provider",
     *          description="Provider name like google, facebook etc",
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
    public function loginCallback(Request $request, $provider){
        try {
            $provider = strtolower($provider);          
            $sUser = Socialite::driver($provider)->stateless()->user();
           
            $user = $this->userRepository->findOrCreateUser($provider, $sUser);

            $token = $user->createToken('Auth Token')
                    ->accessToken;
            $headers['access_token'] = 'Bearer '.$token;
            $user->access_token = 'Bearer '.$token;
            $data = $user->toArray();

            if($user){
                $this->response['data'] = $data;
                return $this->respondWithSuccess($this->response);
            }
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }


   
}
