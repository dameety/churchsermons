<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminValidationRequest;
use App\Repositories\Admin\AdminRepository;

class AdminsApiController extends Controller
{
    protected $admin;

    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }

    public function currentAdmin()
    {
        return $this->admin->authAdmin();
    }

    public function index()
    {
        return $this->admin->get30Paginated();
    }

    public function count()
    {
        return $this->admin->countAll();
    }

    public function adminTypeFilter($type)
    {
        return $this->admin->typeFilter($type);
    }

    public function changePassword($slug, AdminValidationRequest $request)
    {
        if ($this->admin->checkAdminPermission()) {
            return $this->admin->changePassword($slug, $request);
        } else {
            return response()->json(['password changed' => false]);
        }
    }

    public function saveNewAdmin(AdminValidationRequest $request)
    {
        if ($this->admin->checkAdminPermission()) {
            return $this->admin->create($request);
        } else {
            return response()->json(['created' => false]);
        }
    }

    public function deleteAdmin($slug)
    {
        if ($this->admin->checkAdminPermission()) {
            return $this->admin->delete($slug);
        } else {
            return response()->json(['deleted' => false]);
        }
    }
}
