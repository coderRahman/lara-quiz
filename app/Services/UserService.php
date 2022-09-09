<?php
namespace App\Services;

use App\Models\QuizUser;
use App\Models\User;
use App\Utility\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserService{

    public function totalUsers() : int
    {
        $noUsers = User::all()->count();
        return $noUsers;
    }


    public function paidTotalUsers() : int
    {
        $paidUsers = QuizUser::select("user_id")->distinct()->get()->count();

        return $paidUsers;
    }

    public function ajaxUsers()
    {
        $users = User::where('role','!=' , Rule::ADMIN)->select('id','name','email','role');
        return DataTables::of($users)
        ->addIndexColumn()
        
        ->addColumn('name',function($row){
          return ucfirst($row->name);
        })
        ->addColumn('email',function($row){
          return $row->email;
        })
        
        ->addColumn('role',function($row){
            return $row->role == Rule::CUSTOMER ? 'Customer' : '-';
        })
      
        ->addColumn('action',function($row){
          $btn ='<div class="admin-table-action-block">
                  <a href="' . route('admin.users.edit', $row->id) . '" data-toggle="tooltip" data-original-title="Edit" class="btn btn-primary btn-floating"><i class="fa fa-pencil"></i></a>
                
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal' . $row->id . '"><i class="fa fa-trash"></i> </button></div>';

          $btn .= '<div id="deleteModal' . $row->id . '" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      <form method="POST" action="' . route("admin.users.destroy", $row->id) . '">
                        ' . method_field("DELETE") . '
                        ' . csrf_field() . '
                          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                          <button type="submit" class="btn btn-danger">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';

            return $btn;

        })
        ->rawColumns(['image','name','email','role','action'])
        ->make(true);
    }


    public function createUser(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->password = bcrypt($data['password']);
        $user->save();
    }

    public function findUser($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function updateUser(array $data, User $user)
    {
          $user->name = $data['name'];
          $user->email = $data['email'];
            if($data['password']){
                $user->password = bcrypt($data['password']);
            }

          $user->save();

    }

    public function deleteUser(User $user)
    {

    }

}