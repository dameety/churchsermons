<?php

namespace App\Http\Controllers;

use Redirect;
use App\Favourite;
use Illuminate\Http\Request;
use App\Events\DownloadCountEvent;
use App\Events\LastDownloadByEvent;
use Illuminate\Support\Facades\Auth;
use App\Events\LastDownloadTimeEvent;
use App\Http\Requests\SavesermonRequest;
use App\Repositories\Sermon\SermonRepository;
use App\Repositories\Service\ServiceRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Stagedsermon\StagedsermonRepository;

class SermonsController extends Controller
{
    private $sermon;
    private $service;
    private $category;
    private $stagedsermon;

    public function __construct(
        SermonRepository $sermon,
        ServiceRepository $service,
        CategoryRepository $category,
        StagedsermonRepository $stagedsermon
    ) {
        $this->sermon = $sermon;
        $this->service = $service;
        $this->category = $category;
        $this->stagedsermon = $stagedsermon;
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
        $title = str_replace("-mp3", "", $slug);
        return view('admin.sermons.newsermon', compact('slug', 'title'));
    }

    public function saveNewSermon(SavesermonRequest $request)
    {
        if (!request()->file('sermonImage')) {
            $this->sermon->createUseDefaultImage($request);
        } else {
            $this->sermon->create($request);
        }
        $this->category->increaseSermonCount($request->category_id);
        $this->service->increaseSermonCount($request->category_id);
        return redirect('uploadPage')->with('status', 'Sermon has been saved successfully');
    }

    public function editSermonPage($slug)
    {
        $sermon = $this->sermon->getBySlug($slug);
        return view('admin.sermons.edit', compact('sermon'));
    }

    public function updateSermon($slug, SavesermonRequest $request)
    {
        if (request()->file('sermonImage')) {
            $this->sermon->update($slug, $request);
        } else {
            $this->sermon->updateWithDefaultImage($slug, $request);
        }
        flash('Update operation successful.')->success();
        return back();
    }

    public function allSermons()
    {
        $sermons = $this->sermon->get10Paginated();
        return view('frontend.home', compact('sermons'));
    }

    public function getCategory($slug)
    {
        $sermonCount = $this->sermon->countAll();
        $category = $this->category->getBySlug($slug);
        $sermons = $this->sermon->getByIdAndPaginate($id);
        $key = "category";
        return view('frontend.sermons', compact('sermons', 'sermonCount', 'key', 'slug'));
    }

    public function getService($slug)
    {
        $sermonCount = $this->sermon->countAll();
        $service = $this->service->getBySlug($slug);
        $sermons = $this->sermon->getByIdAndPaginate($id);
        $key = "service";
        return view('frontend.sermons', compact('sermons', 'sermonCount', 'key', 'slug'));
    }

    public function downloadSermon($slug)
    {
        $sermonStatus = $this->sermon->getBySlug($slug)->status;
        $user = $this->user->checkPersmision($sermonStatus);
        if ($user) {
            return $this->sermon->download($slug);
        } else {
            flash('Please upgrade your account to be able to download this sermon. Thank You')->error()->important();
            return back();
        }
    }

    public function favouriteSermon2($slug)
    {
        $sermon = $this->sermon->getBySlug($slug);
        Auth::user()->favourites()->attach($sermon->id);
        flash('Successful Operation. The sermon has been added to your favourites list.')->success()->important();
        return back();
    }


    public function favouriteRemove($slug)
    {
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
        $sermonStatus = $this->sermon->getBySlug($slug)->status;
        $user = $this->user->checkPersmision($sermonStatus);
        if ($user) {
            return $this->sermon->download($slug);
        } else {
            flash('Please upgrade your account to be able to download this sermon. Thank You')->error()->important();
            return back();
        }
    }
}
