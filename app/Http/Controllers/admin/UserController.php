<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public $userServ;

    public function __construct(UserService $user)
    {
        $this->userServ = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()){

          $users = $this->userServ->ajaxUsers();

          return $users;
         
        }
        return view('admin.users.index');
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
          try{
         
             $this->userServ->createUser($request->all());

             Toastr()->success('added', 'User has been added !');

          }catch(Exception $e){
             toastr()->error('deleted',$e->getMessage());
          }

          return back();

    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $user = $this->userServ->findUser($id);
      return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user =  $this->userServ->findUser($id);
        $this->userServ->updateUser($request->all(),$user);

        toastr()->success('updated', 'Student has been updated');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try{

          $user =  $this->userServ->findUser($id);
          $this->userServ->deleteUser($user);

          toastr()->success('deleted', 'User has been deleted');

        }catch(Exception $e){

          Toastr()->error('deleted',$e->getMessage());
        }

        return back();
    }
}
