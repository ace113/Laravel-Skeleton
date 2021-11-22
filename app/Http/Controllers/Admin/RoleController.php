<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Gate;
use App\Repositories\PermissionRepository;
use Symfony\Component\HttpFoundation\Response;


class RoleController extends Controller
{ 
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    ){
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        // abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($request->ajax()){
            return $this->roleRepository->getAjaxData($request);
        }

        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionRepository->getAllPermissions();    
        $selectedPermissions = [];   
        return view('admin.role.create', compact('permissions', 'selectedPermissions'));
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
            $role = $this->roleRepository->createRole($request);           
            if(!$role){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.role.index")
                ->withSuccess('role created successfully');
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
        $permissions = $this->permissionRepository->getAllPermissions();

        $selectedPermissions = [];
        if($permissions){
            foreach($this->roleRepository->getRolePermissions($id) as $selectedPermission){
                array_push($selectedPermissions, $selectedPermission->id);
            }
        };
       

        $role = $this->roleRepository->getRoleById($id);
        return view('admin.role.edit', compact('role', 'permissions', 'selectedPermissions'));
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
            $role = $this->roleRepository->updateRole($request, $id);
            if(!$role){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.role.index")
                ->withSuccess('role updated successfully');
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
            $is_deleted = $this->roleRepository->deleteRole($id);
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
            $is_changed = $this->roleRepository->changeStatus($request);
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
