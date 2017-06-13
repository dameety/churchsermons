<?php

namespace App\Http\Controllers\API;

use File;
use Redirect;
use App\Sermon;
use App\Service;
use App\Category;
use App\Stagedsermon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SermonsApiController extends Controller
{

    private $sermon;

    public function __construct(SermonRepository $sermon)
    {

        $this->sermon = $sermon;
    }

    // get all sermons
    public function index()
    {
        $this->sermon->get30Paginated();
        // return Sermon::latest('created_at')->paginate(30);
    }

    // get amount of sermons
    public function count()
    {
        $this->sermon->countAll()
        // return Sermon::all()->count();
    }

    //get count of all stagedSermons
    public function stagedsermonCount()
    {
        return Stagedsermon::all()->count();
    }

    // get a sermon detail
    public function getSermonDetails($slug)
    {
        return $this->sermon->getDetails($slug);
        // $sermon = Sermon::whereSlug($slug)->first();
        // return $sermon;
    }

    // this is used to get the category for a sermon
    // in detail view
    public function sermonCategory($slug)
    {
        return $this->getCategory($slug);
        // $sermon = Sermon::whereSlug($slug)->first();
        // return $sermon->category;
    }

    // this is used to get the service for a sermon
    // in detail view
    public function sermonService($slug)
    {
        return $this->getService($slug);
        // $sermon = Sermon::whereSlug($slug)->first();
        // return $sermon->service;
    }

    // delete sermon
    public function deleteSermon(Sermon $sermon)
    {
        $this->sermon->delete($sermon->slug, $sermon->filename);
        return response('success', 200);
    }

    // download sermon
    public function downloadSermon($slug)
    {

        return $this->sermon->download($slug);

        // $sermon = Sermon::whereSlug($slug)->first();
        // event(new DownloadCountEvent($sermon));
        // event(new LastDownloadTimeEvent($sermon));
        // event(new LastDownloadByEvent($sermon));

        // $fname = $sermon->filename;
        // $title = $sermon->title;
        // $filePath = storage_path('app/'.$fname);

        // return response()->download($filePath, $title);
    }

    // get all staged sermons
    public function stagedsermon()
    {
        return Stagedsermon::latest('created_at')->paginate(10);
    }

    // delete the staged sermon file
    public function deleteStagedesermon(Stagedsermon $stagedsermon)
    {
        $filePath = $stagedsermon->filename;
        Storage::delete($filePath);
        $stagedsermon->delete();
    }

    // upload sermon
    public function upload(Request $request)
    {
        $sermonFile = request()->file('file');
        foreach ($sermonFile as $file) {

            $staging = new Stagedsermon;
            //get file properties
            $staging-> title = $file -> getClientOriginalName();
            $staging-> size = $file -> getClientsize();
            $staging-> type = $file -> getClientOriginalExtension();

            // filename, is also the path
            $staging-> filename = $file ->store('sermons');
            $file ->store('sermons');
            $staging->save();

            return response('success', 200);
        }
    }
}
