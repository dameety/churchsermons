<?php

namespace App\Repositories\Stagedsermon;

use Storage;
use App\Models\Stagedsermon;
use App\Repositories\Stagedsermon\StagedsermonRepository;

class EloquentStagedsermon implements StagedsermonRepository
{

    private $stagedsermon;

    public function __construct(Stagedsermon $stagedsermon)
    {
        $this->stagedsermon = $stagedsermon;
    }

    public function getAll()
    {
        return $this->stagedsermon->all();
    }

    public function get10Paginated()
    {
        return $this->stagedsermon->latest('created_at')->paginate(10);
    }

    public function getBySlug($slug)
    {
        return $this->stagedsermon->findBySlug($slug);
    }

    public function create($request)
    {
        $sermonFile = request()->file('file');
        foreach ($sermonFile as $file) {
            // $staging = new Stagedsermon;
            $staging = $this->stagedsermon;
            //get file properties
            $staging-> title = $file -> getClientOriginalName();
            $staging-> size = $file -> getClientsize();
            $staging-> type = $file -> getClientOriginalExtension();

            // Note: filename, is also the path
            $staging-> filename = $file ->store('sermons');
            $file ->store('sermons');
            $staging->save();
            return response()->json([
                'uploaded' => true
            ]);
        }
    }

    public function delete($slug, $filePath)
    {
        $this->getBySlug($slug)->delete();
        Storage::delete($filePath);
        // return true;
        return response()->json([
                'deleted' => true
            ]);
    }

    public function countAll()
    {
        return $this->stagedsermon->all()->count();
    }
}
