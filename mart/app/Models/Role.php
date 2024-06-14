<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_roles';
    public static function getRole($id) {
        return self::find($id);
    }
    public static function rolePermissions() {
        $logedIn_user = Auth::getUser();
        $role_permissions = self::find($logedIn_user->role)->access_and_pemissions;

        session()->put('active_menu', 'backend');
        $slg = str_replace(url('')."/", '', url()->current());
        $getSlag = DB::table('role_permission')->where('slag', $slg)->first();
        if($getSlag) {
            session()->put('active_menu', $getSlag->slag);
        }
        return array_keys(json_decode($role_permissions, true));
    }
    public static function getMenus() {
        $parent_menu = DB::table('role_permission')->whereNull('parent_id')->where('is_visible', 1)->get();
        foreach($parent_menu as $level1) {
            $menu = array();
            $menu = array_merge($menu, (array)$level1);
            //check its child element
            $sub_menus = DB::table('role_permission')->where('parent_id', $level1->id)->where('is_visible', 1)->get();
            $sun_menu['child'] = array();
            if($sub_menus->isNotEmpty()) {
                foreach($sub_menus as $level2) {
                    $sun_menu['child'][$level2->id] = (array)$level2;
                    //check its child element
                    $sub_menu2 = DB::table('role_permission')->where('parent_id', $level2->id)->where('is_visible', 1)->get();
                    if($sub_menu2->isNotEmpty()) {
                        foreach($sub_menu2 as $level3) {
                            $sun_menu['child'][$level2->id]['child'][$level3->id] = (array)$level3;
                        }
                    }
                }
                $menu = array_merge($menu, $sun_menu);
            }
            $menus[$level1->id] = $menu;
        }
        return $menus;
    }
    public static function getAccessAndPermissions() {
        $parent_menu = DB::table('role_permission')->whereNull('parent_id')->get();
        foreach($parent_menu as $level1) {
            $menu = array();
            $menu = array_merge($menu, (array)$level1);
            //check its child element
            $sub_menus = DB::table('role_permission')->where('parent_id', $level1->id)->get();
            $sun_menu['child'] = array();
            if($sub_menus->isNotEmpty()) {
                foreach($sub_menus as $level2) {
                    $sun_menu['child'][$level2->id] = (array)$level2;
                    //check its child element
                    $sub_menu2 = DB::table('role_permission')->where('parent_id', $level2->id)->get();
                    if($sub_menu2->isNotEmpty()) {
                        foreach($sub_menu2 as $level3) {
                            $sun_menu['child'][$level2->id]['child'][$level3->id] = (array)$level3;
                        }
                    }
                }
                $menu = array_merge($menu, $sun_menu);
            }
            $menus[$level1->id] = $menu;
        }
        return $menus;
    }

}
