<?php

namespace App\Repositories;

use DataTables;
use App\Models\Post;
use App\Models\Comment;

class CommentRepository
{
    public function getCommentById($id)
    {
        return Comment::find($id);
    }


    public function getCommentsList(){
        return Comment::where('status', 1)
            ->get();
    }

    public function createComment($request){
        $comment = Comment::create([
            'comment' => $request->comment,
            'email' => auth()->user()->email ?? $request->email,
            'name' => auth()->user()->fullName ?? $request->name,
            'parent_id'=> $request->parent_id ?? null,
            'user_id' => auth()->user()->id,
            'status' => 0
        ]);

        return $comment;
    }

    public function updateComment($request, $id)
    {
        $comment = self::getCommentById($id);

        if(!$comment){
            return false;
        }
        $comment->update([
            'comment' => $request->comment,
            'email' => auth()->user()->email ?? $request->email,
            'name' => auth()->user()->fullName ?? $request->name,
            'parent_id'=> $request->parent_id ?? null,
            'user_id' => auth()->user()->id ?? 0,
            'status' => 0
        ]);

        return $comment;
    }

    public function deleteComment($id)
    {
        $comment = self::getCommentById($id);

       if($comment){
            $comment->delete();
            return $comment;
       }

      return false;
    }

    public function changeStatus($request)
    {
        $comment = self::getCommentById($request->id);

        if($comment){
            $comment->status == 1 ? $comment->status = 0 : $comment->status = 1;
            return $comment->save();
        }
       return false;
    }

    public function getAjaxData($request)
    { 
        $query = Comment::whereHasMorph('commentable', [
                Post::class
            ], function($q) use($request){
                if($request->commentable_type){
                    $q->where('id', $request->commentable_id);
                }                
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    

        $datatables = Datatables::of($query)
            ->addColumn('comment', function($query){
                return \Str::limit(strip_tags($query->comment),20);
            })
            ->addColumn('user', function($query){
                return "<div>".$query->email ?? '' ." User Id: ".$query->user_id."</div>";
            })
            ->addColumn('model', function($query){
                return $query->commentable_type. '-' . $query->commentable->id;
            })
            ->addColumn('parent', function($query){
                return $query->parent_id ? $query->parent_id : ' - ';
            })
            ->addColumn('submitted_on', function($query){
                return $query->date;
            })  
            ->editColumn('status', function($query){
                if($query->status){
                    return '<button type="button" class="btn green btn-xs change-status" data-id='.$query->id.'>Approved</button>';
                }
                else{ 
                    return '<button type="button" class="btn red btn-xs change-status" data-id='.$query->id.'>Not Approved</button>'; 
                }
            })
            ->addColumn('action', function($query){
                // return '<a href="'.route('admin.comment.edit',[$query->id]).'" class="btn btn-info btn-sx" data-toggle="tooltip" title="Edit">
                // <i class="fa fa-edit"></i></a>&nbsp;
                return '<button class="btn btn-danger btn-sx delete" data-id="'.$query->id.'" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>';
            })
            ->addIndexColumn()
            ->startsWithSearch()
            ->rawColumns(['user', 'status', 'action']);

        return $datatables->make(true);
    }
}