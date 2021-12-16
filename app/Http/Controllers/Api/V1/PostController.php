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
     *      tags={"Post"},
     *      @OA\Parameter(
     *          name="page",
     *          description="page",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          description="per page",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
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
     *          response=403,
     *          description="Forbidden",
     *      )
     * )
     */
    public function getPostsList(Request $request)
    {
        try {
            $post = $this->postRepository->getPostsList($request);
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
     *      tags={"Post"},
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

    public function addComment(Request $request)
    {
        try {
            //code...
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    public function updateComment(Request $request)
    {
        try {
            //code...
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }

    public function deleteComment(Request $request)
    {
        try {
            //code...
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithError($this->response);
        }
    }
}
