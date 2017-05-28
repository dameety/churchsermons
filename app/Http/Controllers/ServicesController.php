<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;



class ServicesController extends Controller
{
    public function servicesPage() {
        return view('admin.services.services');
    }
}
