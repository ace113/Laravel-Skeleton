<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(
        PostRepository $postRepository
    ){
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->postRepository->getAjaxData($request);
        }
        return view('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $post = $this->postRepository->createPost($request);
            if(!$post){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.post.index")
                ->withSuccess('Post created successfully');
        } catch (Exception $e) {
            return back()
                    ->withInput()
                    ->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->getPostById($id);
        if($post->user_id !== auth()->user()->id){
            return redirect()
                ->route('admin.post.index')
                ->withError('You don\'t have permission to access this resource');
        }
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $post = $this->postRepository->updatePost($request, $id);
            if(!$post){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.post.index")
                ->withSuccess('Post updated successfully');
        } catch (Exception $e) {
            return back()
                    ->withInput()
                    ->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = new \stdClass();
        try {
            $is_deleted = $this->postRepository->deletePost($id);
            if($is_deleted){
                $data->status = 1;
            }else{
                $data->status = 2;
            }
        } catch (Exception $e) {
            $data->status = 2;
        }

        return response()->json($data);
    }

    
    /**
     * Change/Toggle status of specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $data = new \stdClass();

        try {
            $is_changed = $this->postRepository->changeStatus($request);
            if($is_changed){
                $data->status = 1;
            }else{
                $data->status = 2;
            }
        } catch (Exception $e) {
            $data->status = 2;
        }

        return response()->json($data);
    }

    public function postComments(Request $request, $id)
    {
        
    }
}
