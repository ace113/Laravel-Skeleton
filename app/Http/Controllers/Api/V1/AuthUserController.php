<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Transformers\UserTransformer;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\UserDeviceInfoRequest;

class AuthUserController extends ApiController
{
    use UploadTrait;
    
    protected $userRepository;
    protected $userTransformer;

    public function __construct(
        UserRepository $userRepository,
        UserTransformer $userTransformer
    ){
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/auth/profile",
     *      operationId="get profile Details",
     *      description="Gets authenticated user's profile detail",
     *      summary="gets profile details",
     *      security = {{"Bearer": {}}},
     *      tags={"Auth"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation"
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
    public function getUserProfile(Request $request)
    {
        try {
            // return print_r(auth()->user());die;
            $user = $this->userRepository->getUserById(request()->user()->id);

            $this->response['message'] = 'Profile Details.';
            $this->response['data'] = $user;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/auth/profile",
     *      operationId="updateProfile",
     *      summary="update user profile",
     *      description="Updates authenticated user's profile",
     *      tags={"Auth"},
     *      security = {{"Bearer": {}}},
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/UpdateProfile"),
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
     *          response=401,
     *          description="Unauthenticate",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     * )
     */
    public function updateProfile(Request $request)
    {
        try {
            $updateJson = $this->userTransformer->updateJson($request);

            $updateUser = $this->userRepository->updateUserById($request->user()->id, $updateJson);

            if($updateUser){
                $this->response['message'] = 'Profile update successful.';
                return $this->respondWithSuccess($this->response);
            }
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/auth/change_password",
     *      operationId="ChangePassword",
     *      summary="Change password",
     *      description="Change authenticated user's password",
     *      tags={"Auth"},
     *      security = {{"Bearer": {}}},
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/ChangePassword"),
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
     *          response=401,
     *          description="Unauthenticate",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     * )
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            if(!Hash::check($request->current_password, auth()->user()->password))
            {
                $this->response['message'] = 'Invalid Password. Your current password value is invalid.';
                return $this->respondWithCustomCode($this->response, HTTP_NON_AUTHORITATIVE_INFORMATION);
            }

            // update user with new password
            $user = auth()->user();
            // revoke auth tokens
            $user->token()->revoke();

            $user->password = bcrypt($request->password);
            $user->save();

            if(!$user){
                $this->response['message'] = trans('Something went wrong.');
                return $this->respondWithError($this->response);
            }
            $this->response['message'] = trans('Password changed successful.');
            return $this->respondWithSuccess($this->response);

        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/auth/logout/{device_id}",
     *      operationId="logoutDevice",
     *      summary="logout device",
     *      description="Logs user out from a device",
     *      tags={"Auth"},
     *      security={{"Bearer" : {}}},
     *      @OA\Parameter(
     *          name="device_id",
     *          description="Device Id",
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
     *          response=401,
     *          description="Unauthenticate",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     * )
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
           
            // revoke token
            $user->token()->revoke();

            // *delete device info

            $this->response['message'] = 'Logout Successful';
            return $this->respondWithSuccess($this->response);

        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

     /**
     * @OA\Post(
     *      path="/api/v1/auth/addUpdateDeviceInfo",
     *      operationId="DeviceInfo",
     *      summary="Add/Update Device Info",
     *      description="Update or create new device info",
     *      tags={"Auth"},
     *      security = {{"Bearer": {}}},
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/DeviceInfo"),
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
     *          response=401,
     *          description="Unauthenticate",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     * )                                        
     */
    public function addUpdateDeviceInfo(UserDeviceInfoRequest $request)
    {
        try {
            $deviceInfo = $this->userRepository->updateOrCreateDeviceInfo($request);

            $this->response['message'] = trans('Device Info added successfully.');
            $this->response['data'] = $deviceInfo;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/auth/profile/upload_image",
     *      operationId="Upload profile image",
     *      tags={"Auth"},
     *      summary="Upload profile image",
     *      description="Upload profile image",
     *      security = {{"Bearer": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UploadImage"),
     *          ),
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
     *          response=401,
     *          description="Unauthenticate",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     * )
     */
    public function uploadImage(Request $request){
        return response()->json($request);die;
        try {
            $request->validate([
                'image' => 'image|nullable'
            ]);
            $uploadedImage = $this->uploadImage($request, 'image', 'user');
            $request->image = $uploadedImage;           

            $updateUser = $this->userRepository->updateUserById($request->user()->id, $request);

            if($updateUser){
                $this->response['message'] = 'Image uploaded successfully';
                return $this->respondWithSuccess($this->response);
            }
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    public function faceookLogin(Request $request){
        try {
            return Socialite::driver('github')->redirect();
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }
    public function faceookLoginCallback(Request $request){
        try {
            //code...
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }
    public function googleLogin(Request $request){
        try {
            //code...
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }
    public function googleLoginCallback(Request $request){
        try {
            //code...
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }
}
