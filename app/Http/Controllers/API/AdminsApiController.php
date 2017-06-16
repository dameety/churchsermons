<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminRepository;
use App\Http\Requests\AdminValidationRequest;

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
        if ($this->admin->adminPermisson()) {
            return $this->admin->changePassword($slug, $request);
        } else {
            return response()->json(['password changed' => false]);
        }
    }

    public function saveNewAdmin(Request $request)
    {
        if ($this->admin->adminPermisson()) {
            return $this->admin->create($request);
        } else {
            return response()->json(['created' => false]);
        }
    }

    public function deleteAdmin(Admin $admin)
    {
        if ($this->admin->adminPermisson()) {
            return $this->admin->delete();
        } else {
            return response()->json(['deleted' => false]);
        }
    }
}
