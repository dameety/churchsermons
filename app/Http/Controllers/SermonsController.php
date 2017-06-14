<?php

namespace App\Http\Controllers;

use DB;
use File;
use Session;
use Storage;
use Redirect;
// use App\Models\Sermon;
// use App\Sermon;
use App\Setting;
use App\Service;
use App\Category;
use App\Favourite;
use Carbon\Carbon;
// use App\Models\Stagedsermon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Events\DownloadCountEvent;
use App\Events\LastDownloadByEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\LastDownloadTimeEvent;
use App\Http\Requests\SavesermonRequest;
use App\Repositories\Sermon\SermonRepository;
use App\Repositories\Stagedsermon\StagedsermonRepository;

class SermonsController extends Controller
{
    private $sermon;
    private $services;
    private $categories;
    private $stagedsermon;

    public function __construct(SermonRepository $sermon, StagedsermonRepository $stagedsermon)
    {
        $this->sermon = $sermon;
        $this->stagedsermon = $stagedsermon;
        $this->services = Service::latest('created_at')->get();
        $this->categories = Category::latest('created_at')->get();
    }

    public function allSermonsPage()
    {
        return view('admin.sermons.allsermons');
    }

    public function uploadPage()
    {
        return view('admin.sermons.newupload');
    }

    public function newSermonForm($slug)
    {
        $services = $this->services;
        $categories = $this->categories;
        $title = str_replace("-mp3", "", $slug);
        return view('admin.sermons.newsermon', compact('slug', 'title', 'categories', 'services'));
    }

    public function saveNewSermon(SavesermonRequest $request)
    {

        if (!request()->file('sermonImage')) {
            $this->sermon->createUseDefaultImage($request);
        } else {
            $this->sermon->create($request);
        }
        // Category::countUp($request->category_id);
        // Service::countUp($request->service_id);
        // riderect to another page
    }

    public function editSermonPage($slug)
    {
        $categories = $this->categories;
        $services = $this->services;
        $sermon = $this->sermon->getBySlug($slug);
        // Sermon::whereSlug($slug)->first();
        return view('admin.sermons.edit', compact('sermon', 'categories', 'services'));
    }

    public function updateSermon($slug, Request $request)
    {

        $data = Input::all();
        // $sermon = Sermon::whereSlug($slug)->first();
        $sermon = $this->sermon->getBySlug($slug);

        if ($sermon->validate($data)) {
            if (Input::hasFile('sermonImage')) {
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
                $this->sermon->addImageUrlToUpdatedSermon($sermon->slug);
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
            // $errors = $sermon->getErrors();
            $errors = $sermon->getErrors();
            return back()->withErrors($errors)->withInput();
        }
    }

    public function allSermons()
    {
        $sermons = $this->sermon->get10Paginated();
        // $sermons = Sermon::latest('created_at')->paginate(10);
        return view('frontend.home', compact('sermons'));
    }

    public function getCategory($slug)
    {

        $category = Category::whereSlug($slug)->first();
        $sermons = Sermon::whereId($category->id)->paginate(10); //
        $sermonCount = $this->sermon->countAll();
        $key = "category";
        return view('frontend.sermons', compact('sermons', 'sermonCount', 'key', 'slug'));
    }

    public function getService($slug)
    {
        $service = Service::whereSlug($slug)->first();
        $sermons = Sermon::whereId($service->id)->paginate(10); //
        $sermonCount = $this->sermon->countAll();
        $key = "service";

        return view('frontend.sermons', compact('sermons', 'sermonCount', 'key', 'slug'));
    }

    public function downloadSermon($slug)
    {
        //new code
        // $user = $this->user->checkPersmision($slug);
        // if($user) {
        //     $this->sermon->download($slug);
        // }

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
        } elseif ($user->permission === "Standard" && $sermon->status === "free") {
            event(new DownloadCountEvent($sermon));
            event(new LastDownloadTimeEvent($sermon));
            event(new LastDownloadByEvent($sermon));
            $fname = $sermon->filename;
            $title = $sermon->title;
            $filePath = storage_path('app/'.$fname);
            return response()->download($filePath, $title);
        } else {
            flash('Please upgrade your account to be able to download this sermon. Thank You')->error()->important();
            return back();
        }
    }

    public function favouriteSermon2($slug)
    {

        $sermon = Sermon::whereSlug($slug)->first();
        Auth::user()->favourites()->attach($sermon->id);
        flash('Successful Operation. The sermon has been added to your favourites list.')->success()->important();
        return back();
    }


    public function favouriteRemove($slug)
    {

        // $sermon = Sermon::whereSlug($slug)->first();
        $sermon = $this->sermon->getBySlug($slug);
        Auth::user()->favourites()->detach($sermon->id);
        flash('Successful Operation. The sermon has been removed from your favourites list.')->success()->important();
        return back();
    }

    public function viewFavourites()
    {
        $sermons = Auth::user()->favourites;
        $favCount= Auth::user()->favourites()->count();
        return view('frontend.favourites', compact('sermons', 'favCount'));
    }

    public function favouriteDownload($slug)
    {
        //new code
        // $user = $this->user->checkPersmision($slug);
        // if($user) {
        //     $this->sermon->download($slug);
        // }

        $user = Auth::user();
        $setting = Setting::first();
        $sermon = Sermon::whereSlug($slug)->first();

        if ($user ->permission === $setting->plan_name) {
            event(new DownloadCountEvent($sermon));
            event(new LastDownloadTimeEvent($sermon));
            event(new LastDownloadByEvent($sermon));

            $fname = $sermon->filename;
            $title = $sermon->title;
            $filePath = storage_path('app/'.$fname);
            return response()->download($filePath, $title);
        } elseif ($user->permission === "Standard" && $sermon->status === "free") {
            event(new DownloadCountEvent($sermon));
            event(new LastDownloadTimeEvent($sermon));
            event(new LastDownloadByEvent($sermon));

            $fname = $sermon->filename;
            $title = $sermon->title;
            $filePath = storage_path('app/'.$fname);

            return response()->download($filePath, $title);
        } else {
            flash('Please upgrade your account to be able to download this sermon. Thank You')->error()->important();
            return back();
        }
    }
}
