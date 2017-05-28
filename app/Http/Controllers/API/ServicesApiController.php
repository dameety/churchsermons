<?php

namespace App\Http\Controllers\API;

use App\Service;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ServicesApiController extends Controller
{

    public function index () {
        return Service::latest('created_at')->paginate(30);
    }

    public function all() {
        return Service::latest('created_at')->get();
    }

    public function count () {
        return Service::all()->count();
    }

    public function fetchServices () {
        return  Service::all();
    }

    public function newServiceData(Request $request) {
        $data = Input::all();
        $service = new Service;
        if($service->validate($data)) {

            $service -> name = $request->name;
            $service -> description = $request->description;
            $service-> save();
            return response('success', 201); 

        } else {
            return response($service->getErrors(), 422);
        }

    }

    public function serviceUpdate(Request $request, $slug) {
        $data = Input::all();
        $service = Service::whereSlug($slug)->first();

        if($service->validate($data, $key = "update")) {

            $service -> name = $request-> name;
            $service -> description = $request-> description;
            $service -> save();
            return response('success', 201); 

        } else {
            return response($service->getErrors(), 422);
        }

    }

    public function sermonServiceFilter(Service $service) {
        return $service->sermons;
    }

    public function deleteService(Service $service) {
        $service->delete();
    }
    
}
