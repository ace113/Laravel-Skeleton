<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    ){
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return $this->userRepository->getAjaxData($request);
        }
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
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
            $user = $this->userRepository->createUser($request);
            if(!$user){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.user.index")
                ->withSuccess('user created successfully');
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
        $user = $this->userRepository->getUserById($id);
        return view('admin.user.edit', compact('user'));
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
            $user = $this->userRepository->updateUser($request, $id);
            if(!$user){
               return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Something went wrong');
            }
            return redirect()
                ->route("admin.user.index")
                ->withSuccess('User updated successfully');
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
            $is_deleted = $this->userRepository->deleteUser($id);
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
            $is_changed = $this->userRepository->changeStatus($request);
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
