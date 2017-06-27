<?php

namespace App\Http\Controllers;

class AdminsController extends Controller
{
    public function adminsPage()
    {
        return view('admin.admins.admins');
    }

    public function home()
    {
        return view('admin.home');
    }
}
