<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Repositories\User\UserRepository;

class UsersApiController extends Controller
{

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return $this->user->get30Paginated();
    }

    public function count()
    {
        return $this->user->countAll();
    }

    public function userTypeFilter($type)
    {
        return $this->user->typeFilter();
    }

    public function changePassword($slug, UserValidationRequest $request)
    {
        if (Admin::adminPermission()) {
            return $this->user->changePassword($slug, $request);
        } else {
            return response('password change', false);
        }
    }

    public function saveNewUser(UserValidationRequest $request)
    {
        if (Admin::adminPermission()) {
            return $this->user->create($request);
        } else {
            return response()->json('updated' => false);
        }

        // if (Admin::adminPermission()) {
        //     $data = Input::all();
        //     $user = new User;
        //     if ($user->validate($data, 'newUser')) {
        //         $user -> name = $request-> name;
        //         $user -> email = $request-> email;
        //         $user -> permission = $request-> permission;
        //         $user-> password = Hash::make($request-> password);
        //         $user -> save();
        //         return response('success', 201);
        //     } else {
        //         return response($user->getErrors(), 422);
        //     }
        // } else {
        //     return response('Not a super admin', 422);
        // }
    }


    public function deleteUser(User $user)
    {
        if (Admin::adminPermisson()) {
            return $this->user->delete();
        } else {
            return response('deleted' => false);
        }
    }
}
