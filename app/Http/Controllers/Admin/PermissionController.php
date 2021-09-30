<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Repositories\PermissionRepository;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(
        PermissionRepository $permissionRepository
    ){
        $this->permissionRepository = $permissionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($request->ajax()){
            return $this->permissionRepository->getAjaxData($request);
        }

        return view('admin.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.create');
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
            $permission = $this->permissionRepository->createPermission($request);
            if(!$permission){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.permission.index")
                ->withSuccess('Permission created successfully');
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
        $permission = $this->permissionRepository->getPermissionById($id);
        return view('admin.permission.edit', compact('permission'));
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
            $permission = $this->permissionRepository->updatePermission($request, $id);
            if(!$permission){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.permission.index")
                ->withSuccess('Permission updated successfully');
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
            $is_deleted = $this->permissionRepository->deletePermission($id);
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
            $is_changed = $this->permissionRepository->changeStatus($request);
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
