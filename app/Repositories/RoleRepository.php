<?php

namespace App\Repositories;

use DataTables;
use App\Models\Role;

class RoleRepository
{
    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function createRole($request)
    {
        $role = Role::create([
            'name' => ucwords($request->name),
            'slug' => \Str::slug($request->slug),           
            'status' => $request->status == 1 ? true : false
        ]);
        $role->permissions()->sync($request->input('permission', []));

        return $role;
    }

    public function updateRole($request, $id)
    {
        $role = self::getRoleById($id);

        $role->update([
            'name' => ucwords($request->name),
            'slug' => \Str::slug($request->slug),         
            'status' => $request->status == 1 ? true : false
        ]); 

        $role->permissions()->sync($request->input('permission', []));

        return $role;
    }

    public function deleteRole($id)
    {
        $role = self::getRoleById($id);

        $role->delete();

        return $role;
    }

    public function changeStatus($request)
    {
        $role = self::getRoleById($request->id);

        if($role){
            if($role->status == 1){
                $role->status = 0;
            }else{
                $role->status = 1;
            }
            return $role->save();
        }
    }

    // list datatables
    public function getAjaxData($request)
    {
        $query = Role::orderBy("created_at", 'DESC')            
            ->get();

        
        $datatables = Datatables::of($query)
            ->addColumn('name', function($query){
                return $query->name;
            })
            ->addColumn('slug', function($query){
                return $query->slug;
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
                return ' <a href="'.route('admin.role.edit',[$query->id]).'" class="btn btn-info btn-sx" data-toggle="tooltip" name="Edit">
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

    public function getRolePermissions($id){
        $role = Role::find($id);

        return $role->permissions;
    }
    
}