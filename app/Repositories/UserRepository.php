<?php

namespace App\Repositories;

use Exception;
use DataTables;
use App\Models\User;
use App\Models\OAuthProvider;
use App\Models\UserDeviceInfo;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function getUserById($id)
    {
        return User::with('role')->find($id);
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
                return '<a href="'.route('admin.user.show',[$query->id]).'" class="btn btn-info btn-sx" data-toggle="tooltip" name="View Profile">
                    <i class="fa fa-eye"></i></a>';
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

    // update or create device info
    public function updateOrCreateDeviceInfo($request)
    {
        $deviceInfo = UserDeviceInfo::updateOrCreate([
            'device_id' => $request->device_id
        ], [
            'device_token' => $request->device_token,
            'device_type' => $request->device_type,
            'user_id' => $request->user()->id
        ]);

        return $deviceInfo;
    }

    /**
     * @param $provider 
     * @param $sUser
     * 
     * @return $user model
     */
    public function findOrCreateUser($provider, $sUser)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $sUser->getId())
            ->first();

        if($oauthProvider){
            $oauthProvider->update([
                'access_token' => $sUser->token,
                'refresh_token' => $sUser->refreshToken,
            ]);

            return $oauthProvider->user;
        }

        // if(User::where('email', $sUser->getEmail())->exists()){
        //     throw new Exception('This email already exists');
        // }

        return $this->updateOrCreateUserFromProvider($provider, $sUser);
    }

    /**
     * @param $provider
     * @param $sUser
     * 
     * @return /App/Models/User as user
     */
    protected function updateOrCreateUserFromProvider($provider, $sUser)
    {
        $user = self::findUserByEmail($sUser->getEmail());

        if(!$user){
            $user = User::create([
                'first_name' => ucwords($sUser->user['given_name']),
                'last_name' => ucwords($sUser->user['family_name']),
                'email' => $sUser->getEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt(mt_rand(5,15)), 
                'role_id' => 3
            ]);
        }

        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $sUser->getId(),
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }
}