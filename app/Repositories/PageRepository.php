<?php

namespace App\Repositories;

use DataTables;
use App\Models\Page;

class PageRepository
{
    public function getPageById($id)
    {
        return Page::find($id);
    }

    public function createPage($request)
    {
        $page = Page::create([
            'title' => ucwords($request->title),
            'slug' => \Str::slug($request->slug),
            'body' => $request->body,
            'status' => $request->status == 1 ? true : false
        ]);

        return $page;
    }

    public function updatePage($request, $id)
    {
        $page = self::getPageById($id);

        $page->update([
            'title' => ucwords($request->title),
            'slug' => \Str::slug($request->slug),
            'body' => $request->body,
            'status' => $request->status == 1 ? true : false
        ]); 

        return $page;
    }

    public function deletePage($id)
    {
        $page = self::getPageById($id);

        $page->delete();

        return $page;
    }

    public function changeStatus($request)
    {
        $page = self::getPageById($request->id);

        if($page){
            if($page->status == 1){
                $page->status = 0;
            }else{
                $page->status = 1;
            }
            return $page->save();
        }
    }

    // list datatables
    public function getAjaxData($request)
    {
        $query = Page::orderBy('created_at', 'DESC')
            ->get();

        $datatables = Datatables::of($query)
            ->addColumn('title', function(){
                return $query->title;
            })
            ->addColumn('slug', function(){
                return $query->slug;
            })
            ->addColumn('body', function(){
                return \Str::limit(strip_tags($query->body), 20);
            })
            ->editColumn('status', function(){
                if($query->status){
                    return '<button type="button" class="btn green btn-xs change-status" data-id='.$query->id.'>Active</button>';
                }
                else{ 
                    return '<button type="button" class="btn red btn-xs change-status" data-id='.$query->id.'>Inactive</button>'; 
                }
            })
            ->addColumn('action', function(){
                return ' <a href="'.route('admin.page.edit',[$query->id]).'" class="btn btn-sm btn-outline btn-info">
                <i class="fa fa-edit"></i></a>&nbsp;
                <button class="btn btn-danger btn-sx delete" data-id="'.$query->id.'">
                    <i class="fa fa-trash"></i>
                </button>'; 
            })
            ->addIndexColumn()
            ->startsWithSearch()
            ->rawColumns(['status', 'action']);
        
        return $datatables->make(true);
    }
}