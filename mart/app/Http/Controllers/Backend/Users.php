<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

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
        try {
            $newUser = User::find($request->get('user_id'));
            $newUser->name = $request->get('userFullname');
            $newUser->mobile = $request->get('userMobile');
            $newUser->email = $request->get('userEmail');
            $newUser->role = $request->get('userRole');
            $newUser->status = $request->get('userStatus');
            $newUser->save();
            return back()->with('success', "User saved successfully");
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function getEditUserForm(Request $request, $user_id) {
        $user_data = User::find($user_id);
        $roles = Role::where('id', '!=', 1)->get();
        try{
            if(!$user_data) {
                throw new Exception("User Details not found");
            }
            $render_htnl = '<form action="'.url('backend/user/edit').'" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewUserForm" novalidate="validate" method="post">
                '.csrf_field().'
                <input type="hidden" name="user_id" value="'.$user_id.'" />
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-fullname">Full Name</label>
                    <input type="text" class="form-control" id="add-user-fullname" value="'.$user_data->name.'" placeholder="Enter Name" name="userFullname" aria-label="Enter Name">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-email">Email</label>
                    <input type="text" id="add-user-email" class="form-control" value="'.$user_data->email.'" placeholder="Enter Email" aria-label="Enter Email" name="userEmail">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="add-user-contact">Mobile</label>
                        <input type="text" id="add-user-contact" class="form-control phone-mask" value="'.$user_data->mobile.'" placeholder="Enter Mobile" aria-label="Enter Mobile" name="userMobile">
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="user-role">User Role</label>
                        <select id="user-role" name="userRole" class="form-select">';
                            if($user_data->id == 1) {
                                $render_htnl .= '<option value="1" selected>Super Admin</option>';
                            } else {
                                foreach ($roles as $role) {
                                    if($role->id == $user_data->role) {
                                        $render_htnl .= '<option value="'.$role->id.'" selected>'.$role->name.'</option>';
                                    } else {
                                        $render_htnl .= '<option value="'.$role->id.'">'.$role->name.'</option>';
                                    }                                
                                }
                            }
                        $render_htnl .= '</select>
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-address">Addree</label>
                    <textarea type="text" id="add-user-address" class="form-control"
                        placeholder="Enter Address" aria-label="Enter Address" name="userAddress" rows=3></textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="user-plan">Select Status</label>
                        <select id="user-plan" name="userStatus" class="form-select">';
                            if($user_data->id == 1) {
                                $render_htnl .= '<option value="1" selected>Active</option>';
                            } else {
                                if($user_data->status == 0) {
                                    $render_htnl .= '<option value="0" selected>Inactive</option>
                                    <option value="1">Active</option>';
                                } else {
                                    $render_htnl .= '<option value="0">Inactive</option>
                                    <option value="1" selected>Active</option>';
                                }  
                            }
                        $render_htnl .= '</select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </form>';
        } catch(Exception $e) {
            $render_htnl  = $e->getMessage();
        }
        return $render_htnl;
    }
    public function delete_user(Request $request, $id) {
        $user = User::find($id);
        if(!$user) {
            return back()->with('warning', "Something went wrong");
        }
        if($user && $user->role == 1) {
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
