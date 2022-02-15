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
     *      path="/api/v1/guest/posts",
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
                return $this->respondWithCustomCode($this->response, HTTP_NO_CONTENT);
            }
          
            $this->response['data'] = $post;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }
    
    public function getLatestPostsList(Request $request)
    {
        try {
            $post = $this->postRepository->getLatestPostsList($request);
            if(!$post){
                $this->response['message'] = 'Not Found.';                
                return $this->respondWithCustomCode($this->response, HTTP_NO_CONTENT);
            }
          
            $this->response['data'] = $post;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
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
                return $this->respondWithCustomCode($this->response, HTTP_NO_CONTENT);
            }
          
            $this->response['data'] = $post;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }

   /**
     * @OA\Get(
     *      path="/api/v1/guest/posts/{slug}/comments",
     *      operationId="GetPostComment",
     *      summary="Get Post comment",
     *      description="gets comments of a post",
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
    public function getPostComments(Request $request, $slug)
    {
        try {
            $post = $this->postRepository->getPostBySlug($slug);
            if(!$post){
                $this->response['message'] = 'Post Not Found.';                
                return $this->respondWithError($this->response);
            }
            $comments = $post->comments;
            $this->response['message'] = 'Operation Successful';
            $this->response['data'] = $comments;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/guest/comments/{comment}",
     *     operationId="Get comment",
     *     summary="Get comment",
     *     description="Gets the comment",
     *     tags={"Post"},
     *     @OA\Parameter(
     *          name="comment",
     *          description="comment id",
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
    public function getComment(Request $request, $comment)
    {
        try {
            $comment = $this->commentRepository->getCommentById($comment);
            if(!$comment){
                $this->response['message'] = 'Comment not found!';
                return $this->respondWithError($this->response);
            }
            $this->response['data'] = $comment;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/guest/comments/create",
     *      operationId="Create comment",
     *      summary="Create comment",
     *      description="create comment",
     *      tags={"Post"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Comment"),
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
    public function addComment(Request $request)
    {
        try {
            $comment = $this->commentRepository->createComment($request);
            if(!$comment){
                $this->response['message'] = "Something went wrong!";
                return $this->respondWithError($this->response);
            }
            $this->response['data'] = $comment;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/guest/comments/{comment}",
     *      operationId="Update comment",
     *      summary="Update comment",
     *      description="Update comment",
     *      tags={"Post"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Comment"),
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
    public function updateComment(Request $request, $id)
    {
        try {
            $comment = $this->commentRepository->updateComment($request, $id);
            if(!$comment){
                $this->response['message'] = "Something went wrong!";
                return $this->respondWithError($this->response);
            }
            $this->response['data'] = $comment;
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/guest/comments/{comment}",
     *     operationId="Delete comment",
     *     summary="Delete comment",
     *     description="Delete the comment",
     *     tags={"Post"},
     *     @OA\Parameter(
     *          name="comment",
     *          description="comment id",
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
    public function deleteComment(Request $request, $id)
    {
        try {
            $comment = $this->commentRepository->deleteComment($id);
            if(!$comment){
                $this->response['message'] = 'Comment not found!';
                return $this->respondWithError($this->response);
            }
            $this->response['message'] = "Comment deleted!";
            return $this->respondWithSuccess($this->response);
        } catch (Exception $e) {
            $this->response['message'] = $e->getMessage();
            return $this->respondWithException($this->response);
        }
    }
}
