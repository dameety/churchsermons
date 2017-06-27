<?php

namespace App\Http\Controllers;

class ServicesController extends Controller
{
    public function servicesPage()
    {
        return view('admin.services.services');
    }
}
