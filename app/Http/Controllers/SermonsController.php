<?php

namespace App\Http\Controllers;

use DB;
use File;
use Session;
use Storage;
use Redirect;
use App\Sermon;
use App\Setting;
use App\Service;
use App\Category;
use App\Favourite;
use Carbon\Carbon;
use App\Stagedsermon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Events\DownloadCountEvent;
use App\Events\LastDownloadByEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\LastDownloadTimeEvent;



class SermonsController extends Controller 
{

    protected $categories;
    protected $services;

    public function __construct () {
        $this->categories = Category::latest('created_at')->get();
        $this->services = Service::latest('created_at')->get();
    }

    public function allSermonsPage() {
        return view('admin.sermons.allsermons');
    }
    
    public function uploadPage () {
        return view('admin.sermons.newupload');
    }

    public function newSermonForm ($slug) {

        $categories = $this->categories;
        $services = $this->services;
        $title = str_replace("-mp3", "", $slug);
        return view('admin.sermons.newsermon', compact('slug', 'title', 'categories', 'services'));

    }

    public function saveNewSermon (Request $request) {
        $data = Input::all();
        $sermon = new Sermon;

        if($sermon->validate($data)) {

            if(!Input::hasFile('sermonImage')) {
                $sermon->imageurl = '/uploads/default.jpg';
            }
            $stagedsermon = Stagedsermon::whereSlug($request->stagedsermonslug)->first();
            $sermon -> title = $request-> title;
            $sermon -> preacher = $request-> preacher;
            $sermon -> service_id = (int)($request-> service_id);
            $sermon -> category_id = (int)($request-> category_id);
            $sermon -> datepreached = date('Y-m-d', strtotime($request-> datepreached));
            $sermon -> status = $request-> status;
            $sermon-> size = $stagedsermon ->size;
            $sermon-> type = $stagedsermon ->type;
            $sermon -> filename = $stagedsermon-> filename;
            //save the image to the sermon
            $sermon->addMediaToSermon(Sermon::saveSermonImage($request));
            $sermon -> save();
            $stagedsermon->delete();
            Sermon::addImageUrlToSermon($sermon->slug);            
            Category::countUp($request->category_id);
            Service::countUp($request->service_id);
            return redirect('/admin/sermon/upload');
        } else {
            $errors = $sermon->getErrors();
            return back()->withErrors($errors)->withInput();
        }

    }

    public function editSermonPage ( $slug ) {

        $categories = $this->categories;
        $services = $this->services;
        $sermon = Sermon::whereSlug($slug)->first();
        return view('admin.sermons.edit', compact('sermon', 'categories', 'services'));

    }

    public function updateSermon (Request $request, $slug) {

        $data = Input::all();
        $sermon = Sermon::whereSlug($slug)->first();

        if($sermon->validate($data)) {

            if(Input::hasFile('sermonImage')) {

                $sermon -> title = $request-> title;
                $sermon -> preacher = $request-> preacher;
                $sermon -> service_id = (int)($request -> service_id);
                $sermon -> category_id = (int)($request -> category_id);
                $sermon -> datepreached = date('Y-m-d', strtotime($request-> datepreached));
                $sermon -> status = $request-> status;
                $sermon -> size = $request -> size;
                $sermon -> type = $request -> type;
                $sermon -> filename = $request -> filename;
                $sermon -> removeMediaFromSermon();
                $sermon -> addMediaToSermon(Sermon::saveSermonImage($request));
                $sermon -> save();
                Sermon::addImageUrlToUpdatedSermon();
                flash('Update operation successful.')->success();
                return back();
                
            } else {
                $sermon -> title = $request-> title;
                $sermon -> preacher = $request-> preacher;
                $sermon -> service_id = (int)($request -> service_id);
                $sermon -> category_id = (int)($request -> category_id);
                $sermon -> datepreached = date('Y-m-d', strtotime($request-> datepreached));
                $sermon -> status = $request-> status;
                $sermon -> size = $request -> size;
                $sermon -> type = $request -> type;
                $sermon -> filename = $request -> filename;
                $sermon -> removeMediaFromSermon();
                $sermon -> imageurl = '/uploads/default.jpg'; 
                $sermon -> save();
                flash('Update operation successful.')->success();
                return back();
            }

        } else {
            $errors = $sermon->getErrors();
            return back()->withErrors($errors)->withInput();
        }

    }

    public function allSermons () {

        $sermons = Sermon::latest('created_at')->paginate(10);
        return view('frontend.home', compact('sermons'));

    }

    public function getCategory ($slug) {

        $category = Category::whereSlug($slug)->first();
    	$sermons = Sermon::whereId($category->id)->paginate(10);
    	$sermonCount = $sermons->count();
    	$key = "category";
        return view('frontend.sermons', compact('sermons', 'sermonCount', 'key', 'slug'));

    }

    public function getService ( $slug ) {

    	// $categories = $this->categories;
     //    $services = $this->services;
        $service = Service::whereSlug($slug)->first();
    	$sermons = Sermon::whereId($service->id)->paginate(10);
    	$sermonCount = $sermons->count();
    	$key = "service";

        return view('frontend.sermons', compact('sermons', 'sermonCount', 'key', 'slug'));
    }

    public function downloadSermon ( $slug ) {
        $sermon = Sermon::whereSlug($slug)->first();
        $user = Auth::user();
        $setting = Setting::first();
        
        if ($user ->permission === $setting->plan_name) {

            event(new DownloadCountEvent($sermon));
            event(new LastDownloadTimeEvent($sermon));
            event(new LastDownloadByEvent($sermon));
            $fname = $sermon->filename;
            $title = $sermon->title;
            $filePath = storage_path('app/'.$fname);
            return response()->download($filePath, $title);

        }
        else if ($user->permission === "Standard" && $sermon->status === "free") {

            event(new DownloadCountEvent($sermon));
            event(new LastDownloadTimeEvent($sermon));
            event(new LastDownloadByEvent($sermon));
            $fname = $sermon->filename;
            $title = $sermon->title;
            $filePath = storage_path('app/'.$fname);
            return response()->download($filePath, $title);

        }
        else {
            flash('Please upgrade your account to be able to download this sermon. Thank You')->error()->important();
            return back();
        }

    }


    public function favouriteSermon2 ( $slug ) {

        $sermon = Sermon::whereSlug($slug)->first();
        Auth::user()->favourites()->attach($sermon->id);
        flash('Successful Operation. The sermon has been added to your favourites list.')->success()->important();
        return back();

    }


    public function favouriteRemove ( $slug ) {

        $sermon = Sermon::whereSlug($slug)->first();
        Auth::user()->favourites()->detach($sermon->id);
        flash('Successful Operation. The sermon has been removed from your favourites list.')->success()->important();
        return back();

    }


    public function viewFavourites ( ) {
        
        // $categories = $this->categories;
        // $services = $this->services;
        $sermons = Auth::user()->favourites;
        $favCount= Auth::user()->favourites()->count();
        return view('frontend.favourites', compact('sermons', 'favCount'));

    }

    public function favouriteDownload ( $slug ) {

        $user = Auth::user();
        $setting = Setting::first();
        $sermon = Sermon::whereSlug($slug)->first();
        
        if ( $user ->permission === $setting->plan_name ) {

            event(new DownloadCountEvent($sermon));
            event(new LastDownloadTimeEvent($sermon));
            event(new LastDownloadByEvent($sermon));

            $fname = $sermon->filename;
            $title = $sermon->title;
            $filePath = storage_path('app/'.$fname);
            return response()->download($filePath, $title);

        }
        else if ($user->permission === "Standard" && $sermon->status === "free") {

            event(new DownloadCountEvent($sermon));
            event(new LastDownloadTimeEvent($sermon));
            event(new LastDownloadByEvent($sermon));

            $fname = $sermon->filename;
            $title = $sermon->title;
            $filePath = storage_path('app/'.$fname);

            return response()->download($filePath, $title);

        }
        else {
            flash('Please upgrade your account to be able to download this sermon. Thank You')->error()->important();
            return back();
        }

    }



}
