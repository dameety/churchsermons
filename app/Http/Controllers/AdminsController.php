<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\User;
use App\Service;
use App\Sermon;
use App\Category;
use App\Sermonrequest;


class AdminsController extends Controller
{

	// load the page that contains the admins vue component
    public function adminsPage()
    {
        return view('admin.admins.admins');

    }

    public function home () {

    	return view('admin.home');

    }
    
    
}
