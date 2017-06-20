<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SavesermonRequest;
use App\Repositories\User\UserRepository;
use App\Repositories\Sermon\SermonRepository;
use App\Repositories\Service\ServiceRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Stagedsermon\StagedsermonRepository;

class SermonsController extends Controller
{

    protected $user;
    protected $sermon;
    protected $service;
    protected $category;
    protected $stagedsermon;

    public function __construct(
        UserRepository $user,
        SermonRepository $sermon,
        ServiceRepository $service,
        CategoryRepository $category,
        StagedsermonRepository $stagedsermon
    ) {
        $this->user = $user;
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
        $this->service->increaseSermonCount($request->service_id);
        return redirect('/admin/sermon/upload');
    }

    public function editSermonPage($slug)
    {
        return view('admin.sermons.edit', [
            'sermon' => $this->sermon->getBySlug($slug)
        ]);
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
        return view('frontend.home', [
            'sermons' => $this->sermon->get10Paginated()
        ]);
    }

    public function getCategory($slug)
    {
        $category = $this->category->getBySlug($slug);
        return view('frontend.sermons', [
            'sermons' => $this->sermon->getByIdAndPaginate($category->id),
            'sermonCount' => $this->sermon->countAll(),
            'key' => "category",
            'slug' => "slug"
        ]);
    }

    public function getService($slug)
    {
        $service = $this->service->getBySlug($slug);
        return view('frontend.sermons', [
            'sermons' => $this->sermon->getByIdAndPaginate($service->id),
            'sermonCount' => $this->sermon->countAll(),
            'key' => "service",
            'slug' => "slug"
        ]);
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
        $this->user->attachFavourite($sermon->id);
        flash('Successful Operation. The sermon has been added to your favourites list.')->success()->important();
        return back();
    }


    public function favouriteRemove($slug)
    {
        $sermon = $this->sermon->getBySlug($slug);
        $this->user->detachFavourite($sermon->id);
        flash('Successful Operation. The sermon has been removed from your favourites list.')->success()->important();
        return back();
    }

    public function viewFavourites()
    {
        return view('frontend.favourites', [
            'sermons' => $this->user->allUserFavourites(),
            'favCount' => $this->user->allUserFavouriteCount()
        ]);
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
