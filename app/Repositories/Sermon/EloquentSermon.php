<?php

namespace App\Repositories\Sermon;

use Storage;
use App\Models\Sermon;
use App\Events\DownloadCountEvent;
use App\Events\LastDownloadByEvent;
use App\Events\LastDownloadTimeEvent;
use App\Repositories\Sermon\SermonRepository;

class EloquentSermon implements SermonRepository
{

    private $sermon;

    public function __construct(Sermon $sermon)
    {
        $this->sermon = $sermon;
    }

    public function getAll()
    {
        return $this->sermon->all();
    }

    public function get30Paginated()
    {
        return $this->sermon->latest('created_at')->paginate(30);
    }

    public function get10Paginated()
    {
        return $this->sermon->latest('created_at')->paginate(10);
    }

    public function getBySlug($slug)
    {
        return $this->sermon->findBySlug($slug);
    }

    public function create($request)
    {
    }

    public function createErrors()
    {
        return $this->sermon->getErrors();
    }

    public function update($slug, $request)
    {
    }

    public function delete($slug, $filePath)
    {
        $this->getBySlug($slug)->delete();
        Storage::delete($filePath);
        return true;
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
