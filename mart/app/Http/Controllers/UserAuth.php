<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use Auth;
use Validator;


class UserAuth extends Controller
{
    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email-username' => 'required|string|max:50',
            'password' => 'required|max:100',
        ]);
        if ($validator->fails()) {
            return back()->withErrors([
                'error_message' => 'Please use credentials to login',
            ])->onlyInput('email-username');
        }
        $result = Auth::attempt(['email' => $request->post('email-username'), 'password' =>  $request->post('password'), 'status' => 1]);
        if($result) {
            $request->session()->regenerate();
            return response()->redirectTo('backend');
        }
        return back()->withErrors([
            'error_message' => 'The provided credentials do not match our records.',
        ])->onlyInput('email-username');
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->redirectTo('auth-login');
    }
}
