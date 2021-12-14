<?php

namespace App\Repositories;

use DataTables;
use App\Models\Permission;
use App\Traits\SluggableTrait;

class PermissionRepository
{
    use SluggableTrait;
    
    public function getPermissionById($id)
    {
        return Permission::find($id);
    }

    public function createPermission($request)
    {
        $permission = Permission::create([
            'title' => ucwords($request->title),
            'slug' => $this->createSlug($request->title, 0, 'Permission'),           
            'status' => $request->status == 1 ? true : false
        ]);

        return $permission;
    }

    public function updatePermission($request, $id)
    {
        $permission = self::getPermissionById($id);

        $permission->update([
            'title' => ucwords($request->title),
            'slug' => $this->createSlug($request->title, $id, 'Permission'),         
            'status' => $request->status == 1 ? true : false
        ]); 

        return $permission;
    }

    public function deletePermission($id)
    {
        $permission = self::getPermissionById($id);

        $permission->delete();

        return $permission;
    }

    public function changeStatus($request)
    {
        $permission = self::getPermissionById($request->id);

        if($permission){
            if($permission->status == 1){
                $permission->status = 0;
            }else{
                $permission->status = 1;
            }
            return $permission->save();
        }
    }

    // list datatables
    public function getAjaxData($request)
    {
        $query = Permission::orderBy("created_at", 'DESC')            
            ->get();

        
        $datatables = Datatables::of($query)
            ->addColumn('title', function($query){
                return ucwords($query->title);
            })     
            ->addColumn('slug', function($query){
                return $query->slug;
            })   
            ->addColumn('action', function($query){
                return ' <a href="'.route('admin.permission.edit',[$query->id]).'" class="btn btn-info btn-sx" data-toggle="tooltip" name="Edit">
                <i class="fa fa-edit"></i></a>&nbsp;
                <button class="btn btn-danger btn-sx delete" data-id="'.$query->id.'" data-toggle="tooltip" name="Delete">
                    <i class="fa fa-trash"></i>
                </button>'; 
            })
            ->addIndexColumn()
            ->startsWithSearch()
            ->rawColumns(['status', 'action']);

           

        return $datatables->make(true);
    
    }

    public function getAllPermissions()
    {
        return Permission::get();
    }
}