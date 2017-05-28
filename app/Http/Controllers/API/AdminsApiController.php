<?php

namespace App\Http\Controllers\API;

use DB;
use App\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class AdminsApiController extends Controller
{

    public function currentAdmin () {
        $admin = Auth::guard('admin')->user();
        return $admin->permission;
    }

    public function index() {
        return Admin::latest('created_at')->paginate(30);
    }

    public function count () {
        return Admin::all()->count();
    }

    public function adminTypeFilter ($type) {
        $admin = Admin::where('permission', $type)->all();
    }

    public function changePassword(Request $request, $slug) {
        
        if(Admin::adminPermission()) {
            $data = Input::all();
            $admin = Admin::whereSlug($slug)->first();
            if($admin->validate($data, 'passwordChange')) {
                $admin-> password = Hash::make($request-> password);
                $admin -> save();
                return response('success', 201);     
            } else {
                return response($user->getErrors(), 422);
            }
        } else {
            return response('Not a super admin', 422);
        }

    }

    public function saveNewAdmin(Request $request) {
        if(Admin::adminPermission()) {
            $data = Input::all();
            $admin = new Admin;
            if($admin->validate($data, 'newAdmin')) {
                $admin -> name = $request-> name;
                $admin -> email = $request-> email;
                $admin -> permission = $request-> permission;
                $admin-> password = Hash::make($request-> password);
                $admin -> save();
                return response('success', 201);     
            } else {
                return response($user->getErrors(), 422);
            }
        } else {
            return response('Not a super admin', 422);
        }

    }


    public function deleteAdmin(Admin $admin) {
        if(Admin::adminPermission()) {
            $admin->delete();
            return response('success', 200);
        } else {
            return response('Not a super admin', 422);
        }
    }

}
