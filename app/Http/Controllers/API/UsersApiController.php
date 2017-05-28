<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


class UsersApiController extends Controller
{

    public function index() {
        return User::latest('created_at')->paginate(30);
    }

    public function count () {
        return User::all()->count();
    }

    public function userTypeFilter ($type) {
        return User::where('permission', $type)->all();
    }

    public function changePassword(Request $request, $slug) {

        if(Admin::adminPermission()) {
            $data = Input::all();
            $user = User::whereSlug($slug)->first();
            if($user->validate($data, 'passwordChange')) {
                $user-> password = Hash::make($request-> password);
                $user -> save();
                return response('success', 201);     
            } else {
                return response($user->getErrors(), 422);
            }
        } else {
            return response('Not a super admin', 422);
        }

    }

    public function saveNewUser(Request $request) {

        if(Admin::adminPermission()) {
            $data = Input::all();
            $user = new User;
            if($user->validate($data, 'newUser')) {
                $user -> name = $request-> name;
                $user -> email = $request-> email;
                $user -> permission = $request-> permission;
                $user-> password = Hash::make($request-> password);
                $user -> save();
                return response('success', 201);     
            } else {
                return response($user->getErrors(), 422);
            }
        } else {
            return response('Not a super admin', 422);
        }

    }

    
    public function deleteUser(User $user) {

        if(Admin::adminPermisson()) {
            $user->delete();
            return response('success', 200);
        } else {
            return response('Not a super admin', 422);
        }

    }

}
