<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Users extends Controller
{
    public function index(Request $request) {
        if($request->has('search_key')) {
            $users = User::with('Role')->orWhere('name', 'LIKE', '%'.$request->get('search_key').'%')
                ->orWhere('mobile', 'LIKE', '%'.$request->get('search_key').'%')
                ->orWhere('email', 'LIKE', '%'.$request->get('search_key').'%')
                ->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        $roles = Role::where('id', '!=', 1)->get();
        return view('backend.user.list', compact('users', 'roles'));
    }
    public function add_user(Request $request) {
        $validator = Validator::make($request->all(), [
            'userFullname' => 'required|string|max:50',
            'userEmail' => 'required|string|max:50',
            'userMobile' => 'required',
            'userRole' => 'required',
            'userAddress' => 'required',
            'userStatus' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->with([
                'error' => 'Please fill the required field',
            ])->withInput();
        }
        $newUser = new User();
        $newUser->name = $request->get('userFullname');
        $newUser->mobile = $request->get('userMobile');
        $newUser->email = $request->get('userEmail');
        $newUser->role = $request->get('userRole');
        $newUser->password = Hash::make('test123456');
        $newUser->status = $request->get('userStatus');
        $newUser->remember_token = Str::random(10);
        $newUser->save();
        return back()->with('success', "User saved successfully");
    }
    public function edit_user(Request $request) {
        $validator = Validator::make($request->all(), [
            'userFullname' => 'required|string|max:50',
            'userEmail' => 'required|string|max:50',
            'userMobile' => 'required',
            'userRole' => 'required',
            'userAddress' => 'required',
            'userStatus' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->with([
                'error' => 'Please fill the required field',
            ])->withInput();
        }
        $newUser = User::find($request->get('user_id'));
        $newUser->name = $request->get('userFullname');
        $newUser->mobile = $request->get('userMobile');
        $newUser->email = $request->get('userEmail');
        $newUser->role = $request->get('userRole');
        $newUser->password = Hash::make('test123456');
        $newUser->status = $request->get('userStatus');
        $newUser->remember_token = Str::random(10);
        return back()->with('success', "User saved successfully");
    }
    public function delete_user(Request $request, $id) {
        $user = User::find($id);
        if($user->role == 1) {
            return back()->with('warning', "Super Admin could not be deleted");
        }
        $user->delete();
        return back()->with('success', "User deleted successfully");
    }
    public function roles(Request $request) {
        $role_access_permissions = Role::getAccessAndPermissions();
        if($request->has('search_key')) {
            $roles = Role::where('name', 'LIKE', '%'.$request->get('search_key').'%')->paginate(10);
        } else {
            $roles = Role::paginate(10);
        }
        return view('backend.user.roles', compact('roles', 'role_access_permissions'));
    }
    public function add_role(Request $request) {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:50',
            'role_code' => 'required|string|max:50',
            'role_access_permissions' => 'required',
            'role_status' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->with([
                'error' => 'Please fill the required field',
            ])->withInput();
        }
        $newRole = new Role();
        $newRole->name = $request->role_name;
        $newRole->code = $request->role_code;
        $newRole->access_and_pemissions = str_replace('\\','',json_encode($request->role_access_permissions));
        $newRole->status = $request->role_status;
        $newRole->save();
        return back()->with('success', "Role saved successfully");
    }
    public function edit_role(Request $request) {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|string|max:50',
            'role_name' => 'required|string|max:50',
            'role_code' => 'required|string|max:50',
            'role_access_permissions' => 'required',
            'role_status' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->with([
                'error' => 'Please fill the required field',
            ])->withInput();
        }
        $newRole = Role::find($request->role_id);
        $newRole->access_and_pemissions = str_replace('\\','',json_encode($request->role_access_permissions));
        if($request->role_id != 1) {
            $newRole->name = $request->role_name;
            $newRole->code = $request->role_code;
            $newRole->status = $request->role_status;
        }
        $newRole->save();
        return back()->with('success', "Role updated successfully");
    }
}
