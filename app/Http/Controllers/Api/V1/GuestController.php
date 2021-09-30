<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\ApiController;

class GuestController extends ApiController
{
    /**
     * @OA\Post(
     *  path="/register",
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
    public function register(Request $request){

    }

    public function login(Request $request)
    {

    }

    public function verifyContact(Request $request)
    {}

    public function sendVerificationEmail(Request $request){}

    public function sendPhoneVerificationToken(Request $request){}

    public function getPage(Request $request, $slug){}

    public function forgotPassword(Request $request){}
}
