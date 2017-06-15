<?php

namespace App\Repositories\Sermon;

use Storage;
use App\Models\Sermon;
use App\Models\Stagedsermon;
use App\Events\DownloadCountEvent;
use App\Events\LastDownloadByEvent;
use App\Events\LastDownloadTimeEvent;
use App\Repositories\Stagedsermon\StagedsermonRepository;

class EloquentSermon implements SermonRepository
{

    private $sermon;
    private $stagedsermon;

    public function __construct(Sermon $sermon, Stagedsermon $stagedsermon)
    {
        $this->sermon = $sermon;
        $this->stagedsermon = $stagedsermon;
    }

    public function getAll()
    {
        return $this->sermon->all();
    }

    public function get10Paginated()
    {
        return $this->sermon->latest('created_at')->paginate(10);
    }

    public function get30Paginated()
    {
        return $this->sermon->latest('created_at')->paginate(30);
    }

    public function getBySlug($slug)
    {
        return $this->sermon->findBySlug($slug);
    }

    public function getByIdAndPaginate($id)
    {
        return $this->sermon->whereId($id)->paginate(10);
    }

    public function createUseDefaultImage($request)
    {
        $sermon = $this->sermon;
        $stagedsermon = $this->stagedsermon->findBySlug($request->stagedsermonslug);
        $sermon -> title = $request-> title;
        $sermon -> preacher = $request-> preacher;
        $sermon -> service_id = (int)($request-> service_id);
        $sermon -> category_id = (int)($request-> category_id);
        $sermon -> datepreached = date('Y-m-d', strtotime($request-> datepreached));
        $sermon -> status = $request-> status;
        $sermon-> size = $stagedsermon ->size;
        $sermon-> type = $stagedsermon ->type;
        $sermon -> filename = $stagedsermon-> filename;
        $sermon->imageurl = '/uploads/default.jpg';
        $sermon -> save();
        $stagedsermon->delete();
        return true;
    }

    public function create($request)
    {
        $sermon = $this->sermon;
        $stagedsermon = $this->stagedsermon->findBySlug($request->stagedsermonslug);
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
        $sermon->addMediaToSermon($this->sermon->saveSermonImage($request));
        $sermon -> save();
        $stagedsermon->delete();
        $this->sermon->addImageUrlToSermon($sermon->slug);
        return true;
    }

    public function updateWithDefaultImage($slug, $request)
    {
        $sermon = $this->sermon->getBySlug($slug);
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
    }

    public function update($slug, $request)
    {
        $sermon = $this->sermon->getBySlug($slug);
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
        $sermon -> addMediaToSermon($this->sermon->saveSermonImage($request));
        $sermon -> save();
        $this->sermon->addImageUrlToUpdatedSermon($sermon->slug);
    }

    public function delete($slug, $filePath)
    {
        $this->getBySlug($slug)->delete();
        Storage::delete($filePath);
        return response()->json(['deleted' => true]);
    }

    public function countAll()
    {
        return $this->sermon->all()->count();
    }

    public function getDetails($slug)
    {
        return $this->getBySlug($slug);
    }

    public function getCategory($slug)
    {
        return $this->getBySlug($slug)->category;
    }

    public function getService($slug)
    {
        return $this->getBySlug($slug)->service;
    }

    public function download($slug)
    {
        $sermon = $this->getBySlug($slug);
        event(new DownloadCountEvent($sermon));
        event(new LastDownloadTimeEvent($sermon));
        event(new LastDownloadByEvent($sermon));

        $fname = $sermon->filename;
        $title = $sermon->title;
        $filePath = storage_path('app/'.$fname);

        return response()->download($filePath, $title);
    }

    public function favourite($slug)
    {
    }

    public function unFavourite($slug)
    {
    }

    public function getFavourite()
    {
    }

    public function downloadFavourite($slug)
    {
    }
}
