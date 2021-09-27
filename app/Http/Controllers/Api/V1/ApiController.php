<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="My Ecommerce API Documentation",
     *      description="All API Documentations",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * @OA\SecurityScheme(
     *      securityScheme="Bearer",
     *      in="header",
     *      name="Authorization",
     *      type="apiKey"
     * )
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     */

    //  function to response with exception 
    public function respondWithException(array $response)
    {
        return response()->json(
            [
                'status' => HTTP_EXCEPTION_ERROR,
                'message' => $response['message'],
                'data' => $response['data'] ? : new \stdClass(), //The stdClass is the empty class in PHP which is used to cast other types to object.
            ], HTTP_EXCEPTION_ERROR
        );
    }

    /**
     * @param array $response
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithCustomCode(array $response, $code)
    {
        return response()->json([
            'status' => $code,
            'message' => $response['message'],
            'data' => isset($response['data']) ? $response['data'] : new \stdClass(),
        ],$code );
    }

    /**
     * @param array $response
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithHeaders(array $response, array $header)
    {
        return response()->json([
            'status' => HTTP_OK,
            'message' => $response['message'],
            'data' => isset($response['data']) ? $response['data'] : new \stdClass(),
        ], HTTP_OK)->withHeaders($header);

    }

    /**
     * format HTTP success response
     *
     * @param array $response
     * @return Response
     */
    public function respondWithSuccess(array $response)
    {
        $message = !empty($response['message']) ?$response['message']: 'Operation successful';

        return response()->json([
            'status'  => HTTP_OK,
            'message' => $message,
            'data'    => isset($response['data']) ? $response['data'] : new \stdClass(),
        ], HTTP_OK);
    }

    
    /**
     * format HTTP error response
     *
     * @param array $response
     * @return Response
     */
    public function respondWithError(array $response)
    {
        return response()->json([
            'status' => HTTP_API_ERROR,
            'message' => $response['message'],
            'data' => isset($response['data']) ? $response['data'] : new \stdClass(),
        ], HTTP_BAD_REQUEST);

    }

}
