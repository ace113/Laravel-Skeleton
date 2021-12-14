<?php

namespace App\Repositories;

use DataTables;
use App\Models\Post;
use App\Traits\SluggableTrait;

class PostRepository
{
    use SluggableTrait;
    
    public function getPostById($id)
    {
        return Post::find($id);
    }

    public function getPostsList(){
        return Post::where('status', 1)           
            ->paginate(5);
    }

    public function getUserPostById($id){
        $user_id = auth()->user()->id;
        return Post::where('user_id', $user_id)->find($id);
    }

    public function getPostBySlug($slug)
    {
        $Post = Post::where('status', 1)
        ->where('slug', $slug)
        ->first();

        if($Post){
            return $Post;
        }
        else{
            return false;
        }
    }

    public function createPost($request)
    {
        $Post = Post::create([
            'title' => ucwords($request->title),
            'slug' => $this->createSlug($request->title, 0, 'Post'),
            'summary' => $request->summary,
            'image' => $request->image,
            'body' => $request->body,
            'status' => $request->status == 1 ? true : false,
            'user_id' => auth()->user()->id,
        ]);

        return $Post;
    }

    public function updatePost($request, $id)
    {
        $Post = self::getUserPostById($id);

        $Post->update([
            'title' => ucwords($request->title),
            'slug' => $this->createSlug($request->slug, $id , 'Post'),
            'summary' => $request->summary,
            'image' => $request->image,
            'body' => $request->body,
            'status' => $request->status == 1 ? true : false,
        ]); 

        return $Post;
    }

    public function deletePost($id)
    {
        $Post = self::getUserPostById($id);
      
        $Post->delete();

        return $Post;
    }

    public function changeStatus($request)
    {
        $Post = self::getUserPostById($request->id);
        
        if($Post){
            if($Post->status == 1){
                $Post->status = 0;
            }else{
                $Post->status = 1;
            }
            return $Post->save();
        }
    }

    // list datatables
    public function getAjaxData($request)
    {
        $query = Post::where('user_id', auth()->user()->id)
            ->orderBy("created_at", 'DESC')            
            ->get();

        
        $datatables = Datatables::of($query)
            ->addColumn('title', function($query){
                return $query->title;
            })
            ->addColumn('slug', function($query){
                return $query->slug;
            })
            ->addColumn('body', function($query){
                return \Str::limit(strip_tags($query->body),20);
            })
            ->editColumn('status', function($query){
                if($query->status){
                    return '<button type="button" class="btn green btn-xs change-status" data-id='.$query->id.'>Active</button>';
                }
                else{ 
                    return '<button type="button" class="btn red btn-xs change-status" data-id='.$query->id.'>Inactive</button>'; 
                }
            })
            ->addColumn('action', function($query){
                if(\Gate::denies('page_delete')){
                    return '<a href="'.route('admin.post.edit',[$query->id]).'" class="btn btn-info btn-sx" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-edit"></i></a';
                }
                return ' <a href="'.route('admin.post.edit',[$query->id]).'" class="btn btn-info btn-sx" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit"></i></a>&nbsp;
                <button class="btn btn-danger btn-sx delete" data-id="'.$query->id.'" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>'; 
            })
            ->addIndexColumn()
            ->startsWithSearch()
            ->rawColumns(['status', 'action']);

           

        return $datatables->make(true);
    
    }
}
