<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserValidationRequest;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\User\UserRepository;

class UsersApiController extends Controller
{
    protected $user;
    protected $admin;

    public function __construct(UserRepository $user, AdminRepository $admin)
    {
        $this->user = $user;
        $this->admin = $admin;
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
        if ($this->admin->adminPermisson()) {
            return $this->user->changePassword($slug, $request);
        } else {
            return response()->json(['passwor changed' => false]);
        }
    }

    public function saveNewUser(UserValidationRequest $request)
    {
        if ($this->admin->adminPermisson()) {
            return $this->user->create($request);
        } else {
            return response()->json(['created' => false]);
        }
    }

    public function deleteUser(User $user)
    {
        if ($this->admin->adminPermisson()) {
            return $this->user->delete();
        } else {
            return response()->json(['deleted' => false]);
        }
    }
}
