<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(
        CommentRepository $commentRepository
    ){
        $this->commentRepository = $commentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->commentRepository->getAjaxData($request);
        }
       
        $params =[
            'model' => $request->commentable_type,
            'id' => $request->commentable_id
        ];

        return view('admin.comment.index', compact('params'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.comment.create');
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
            $comment = $this->commentRepository->createComment($request);
            if(!$comment){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.comment.index")
                ->withSuccess('Comment created successfully');
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
        $comment = $this->commentRepository->getCommentById($id);
        if(!$comment){
            return back()
                ->withError('Comment not found');
        }
        if($comment->user_id !== auth()->user()->id){
            return redirect()
                ->route('admin.comment.index')
                ->withError('You don\'t have permission to access this resource');
        }
        return view('admin.comment.edit', compact('comment'));
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
            $comment = $this->commentRepository->updateComment($request, $id);
            if(!$comment){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.comment.index")
                ->withSuccess('Comment updated successfully');
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
            $is_deleted = $this->commentRepository->deleteComment($id);
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
            $is_changed = $this->commentRepository->changeStatus($request);
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
}
