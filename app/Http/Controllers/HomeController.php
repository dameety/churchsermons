<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Sermon;
use App\Service;
use App\Setting;
use App\Category;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    
    public function accounts () {
        $setting = Setting::first();
        return view('auth.accounts', compact('setting'));   
    }


    public function index() {

        $setting = Setting::first();
        $sermons = Sermon::latest('created_at')->paginate(4);

        return view('frontend.home', compact('setting', 'sermons'));

    }

    public function welcome() {

        $settings = Setting::first();
        $images = $settings->getMedia('home_images');
        
        $allImageUrls = array();
        foreach($images as $file) {

            // get each file url
            $getFileUrl = $file->getUrl();
            // save it to  an array
            array_push($allImageUrls , $getFileUrl);
                
        }
        $urls = collect($allImageUrls);
        
        return view('frontend.welcome', compact('urls'));
    }
    

    public function debug () {

        dd(Auth::user());

    }


}
