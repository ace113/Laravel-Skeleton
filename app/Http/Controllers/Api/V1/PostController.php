<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\CommentRepository;
use App\Http\Controllers\Api\V1\ApiController;

class PostController extends ApiController
{
    protected $postRepository;

    public function __construct(
        PostRepository $postRepository,
        CommentRepository $commentRepository
    ){
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

   /**
     * @OA\Get(
     *      path="/api/v1/guest/posts/",
     *      operationId="getPosts",
     *      summary="Get Post",
     *      description="Gets posts",
     *      tags={"Guest"},
     *      @OA\Parameter(
     *          name="slug",
     *          description="length",
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
    public function getPostsList()
    {
        try {
            $post = $this->postRepository->getPostsList();
            if(!$post){
                $this->response['message'] = 'Not Found.';                
                return $this->respondWithError($this->response);
            }
          
            $this->response['data'] = $post;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/guest/posts/{slug}",
     *      operationId="getPost",
     *      summary="Get Post",
     *      description="Gets posts from slug",
     *      tags={"Guest"},
     *      @OA\Parameter(
     *          name="slug",
     *          description="Post Slug",
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
    public function getPost($slug)
    {
        try {
            $post = $this->postRepository->getPostBySlug($slug);
            if(!$post){
                $this->response['message'] = 'Post Not Found.';                
                return $this->respondWithError($this->response);
            }
          
            $this->response['data'] = $post;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    public function getPostComments(Request $request)
    {
        try {
            //code...
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }
}
