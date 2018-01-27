<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Hash;
use Auth;
class UserController extends Controller
{
    public function getList() {
    	$user = User::select('id','username', 'level', 'team_id') -> get() -> toArray();
    	return view('admin.user.user_list', compact('user'));
    }

    public function getAdd() {
    	return view('admin.user.user_add');
    }

    public function postAdd(UserRequest $request) {
    	$user = new User();
    	$user -> username = $request -> txtUser;
    	$user -> email = $request -> txtEmail;
    	$user -> password = Hash::make($request -> txtPass);
    	$user -> level = $request -> rdoLevel;
    	$user -> team_id = $request -> team;
    	$user -> remember_token = $request -> _token;
    	$user -> save();
    	return redirect() -> route('admin.user.getList') -> with(['flash_level' => 'success', 'flash_messages' => 'Add user succses']);
    }

    public function getEdit($id) {
        $user = User::findOrFail($id);
        if ((Auth::user() -> id) != 1 && ($id == 1 || ($user["level"] == 1 && Auth::user() -> id != $id))) {
            return redirect() -> route('admin.user.getList') -> with(['flash_level' => 'danger', 'flash_messages' => 'Sorry! You can\'t access edit user']);
        }
    	return view('admin.user.user_edit', compact('user', 'id'));
    }

    public function postEdit($id, Request $request) {
        $user = User::findOrFail($id);
        if ($request -> input('txtRePass')) {
            $this -> validate($request, [
                'txtRePass' => 'same:txtPass'
            ], 
            [
                'txtRePass.same' => 'Two password don\'t match'
            ]);
            $pass = $request -> input('txtPass');
            $user -> password = Hash::make($pass);
        }
        $user -> email = $request -> input('txtEmail');
        $user -> level = $request -> input('rdoLevel');
        $user -> team_id = $request -> team;
        $user -> remember_token = $request -> input('_token');
        $user -> save();
        return redirect() -> route('admin.user.getList') -> with(['flash_level' => 'success', 'flash_messages' => 'Edit user succses']);
    } 

    public function getDelete($id) {
        $user_current_login_id = Auth::user() -> id;
    	$user = User::findOrFail($id);
    	if ($id == 1 || ($user_current_login_id != 1 && $user["level"] == 1)) {
            return redirect() -> route('admin.user.getList') -> with(['flash_level' => 'danger', 'flash_messages' => 'Sorry! You can\'t access delete user']);
        }
        else {
            $user -> delete($id);
            return redirect() -> route('admin.user.getList') -> with(['flash_level' => 'success', 'flash_messages' => 'Delete user succses']);
        }
    }
}
