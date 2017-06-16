<?php

namespace App\Repositories\User;

use Auth;
use App\Models\User;
use App\Repositories\User\UserRepository;

class EloquentUser implements UserRepository
{
    private $user;
    private $auth;

    public function __construct(User $user, Auth $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function get30Paginated()
    {
        return $this->user->latest('created_at')->paginate(30);
    }

    public function getBySlug($slug)
    {
        return $this->user->findBySlug($slug);
    }

    public function create($request)
    {
        $user = $this->user;
        $user -> name = $request-> name;
        $user -> email = $request-> email;
        $user -> permission = $request-> permission;
        $user-> password = bcrypt($request-> password);
        $user -> save();
        return response()->json(['success' => 201]);
    }

    public function authUser()
    {
        return $this->auth->user;
    }

    public function update($slug, $request)
    {
    }

    public function changePassword($slug, $request)
    {
        $user = $this->user->getBySlug($slug);
        $user -> password = bcrypt($request->password);
        $user -> save();
        return response()->json(['password change' => true]);
    }

    public function delete($slug)
    {
        $this->getBySlug($slug)->delete();
        return response()->json(['deleted' => true]);
    }

    public function countAll()
    {
        return $this->user->all()->count();
    }

    public function typeFilter($type)
    {
        return $this->user->where('permission', $type)->all();
    }
}
