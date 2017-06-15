<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Service\ServiceRepository;

class ServicesController extends Controller
{

    protected $service;

    public function __construct(ServiceRepository $service)
    {
        $this->service = $service;
    }

    public function servicesPage()
    {
        return view('admin.services.services');
    }
}
