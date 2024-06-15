<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function Role() {
        return $this->hasOne(Role::class, 'id', 'role');
    }
    public static function hasAccess($key, $slag = false) {
        $logedIn_user = Auth::getUser();
        $role_permissions = Role::find($logedIn_user->role)->access_and_pemissions;
        if(!$role_permissions) {
            abort('403', "You do have not permission to access the page.");
        }
        $accessList = array_keys(json_decode($role_permissions, true));
        if($slag) {
            if(in_array($key, $accessList)) {
                return true;
            }
        } else {
            $access_request = DB::table('role_permission')->where('name', $key)->first();
            if($access_request) {
                if(in_array($access_request->slag, $accessList)) {
                    return true;
                }
            }
        }
        return false;
    }
}
