<?php

namespace App\Repositories;

use DataTables;
use App\Models\User;

class UserRepository
{
    public function getUserById($id)
    {
        return User::find($id);
    }

    public function findUserByEmail($email)
    {
        return User::where('email', $email)
            ->first();
    }

    public function createUser($data) {
        try {
            $result = User::create($data);
            return $result;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateUserById($id, $data) {
        try {
            DB::beginTransaction();
            $result = User::where(['id'=>$id])->update($data);
            DB::commit();
            return $result;
        } catch(Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function deleteUser($id)
    {
        $user = self::getUserById($id);

        $user->delete();

        return $user;
    }

    public function getAjaxData($request)
    {
        $query = User::orderBy('created_at')
            ->get();

        $datatables = Datatables::of($query)
            ->addColumn('full_name', function($query){
                return $query->full_name;
            })
            ->addColumn('email', function($query){
                return $query->email;
            })
            ->addColumn('phone', function($query){
                return $query->phone;
            })
            ->editColumn('status', function($query){
                if($query->status){
                    return '<button type="button" class="btn green btn-xs change-status" data-id='.$query->id.'>Active</button>';
                }
                else{ 
                    return '<button type="button" class="btn red btn-xs change-status" data-id='.$query->id.'>Inactive</button>'; 
                }
            })
            ->editColumn('action', function($query){
                // return ' <a href="'.route('admin.user.edit',[$query->id]).'" class="btn btn-info btn-sx" data-toggle="tooltip" name="Edit">
                // <i class="fa fa-edit"></i></a>&nbsp;
                // <button class="btn btn-danger btn-sx delete" data-id="'.$query->id.'" data-toggle="tooltip" name="Delete">
                //     <i class="fa fa-trash"></i>
                // </button>'; 
                return 'action';
            })
            ->addIndexColumn()
            ->startsWithSearch()
            ->rawColumns(['status', 'action']);

        return $datatables->make(true);
    }

    public function changeStatus($request)
    {
        $user = self::getUserById($request->id);

        if($user){
            if($user->status == 1){
                $user->status = 0;
            }else{
                $user->status = 1;
            }
            return $user->save();
        }
    }

}