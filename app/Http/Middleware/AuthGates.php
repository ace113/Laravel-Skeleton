<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if($user){
            $roles = Role::with('permissions')->get();

            $permissionArray = [];

            foreach($roles as $role){
                foreach($role->permissions as $permission){
                    $permissionArray[$permissions->title][] = $role->id;
                }
            }

            foreach($permissionArray as $title => $roles)
            {
                Gate::define($title, function(User $role) use ($roles){
                    return count(array_intersect($user->role->pluck('id')->toArray(), $roles)) > 0;
                });
            }
        }
        return $next($request);
    }
    
}
