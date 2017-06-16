<?php

namespace App\Repositories\Admin;

use Auth;
use App\Models\Admin;
use App\Repositories\Admin\AdminRepository;

class EloquentAdmin implements AdminRepository
{
    private $admin;
    private $auth;

    public function __construct(Admin $admin, Auth $auth)
    {
        $this->admin = $admin;
        $this->auth = $auth;
    }

    public function getAll()
    {
        return $this->admin->all();
    }

    public function get30Paginated()
    {
        return $this->admin->latest('created_at')->paginate(30);
    }

    public function getBySlug($slug)
    {
        return $this->admin->findBySlug($slug);
    }

    public function create($request)
    {
        $admin = $this->admin;
        $admin -> name = $request-> name;
        $admin -> email = $request-> email;
        $admin -> permission = $request-> permission;
        $admin-> password = bcrypt($request-> password);
        $admin -> save();
        return response()->json(['success' => 201]);
    }

    public function authAdmin()
    {
        $admin = $this->admin->current();
        return $admin->permission;
    }

    public function update($slug, $request)
    {
    }

    public function changePassword($slug, $request)
    {
        $admin = $this->admin->getBySlug($slug);
        $admin -> password = bcrypt($request->password);
        $admin -> save();
        return response()->json(['password change' => true]);
    }

    public function delete($slug)
    {
        $this->getBySlug($slug)->delete();
        return response()->json(['deleted' => true]);
    }

    public function countAll()
    {
        return $this->admin->all()->count();
    }

    public function typeFilter($type)
    {
        return $this->admin->where('permission', $type)->all();
    }
}
