<?php

namespace App\Repositories\Stagedsermon;

use App\Models\Stagedsermon;
use Storage;

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
        $file = request()->file('file');
        $staging = $this->stagedsermon;
        $staging->title = $file->getClientOriginalName();
        $staging->size = $file->getClientsize();
        $staging->type = $file->getClientOriginalExtension();
        $staging->filename = $file->store('sermons');
        $staging->save();

        return response()->json(['uploaded' => true]);
    }

    public function delete($slug, $filePath)
    {
        Storage::delete($filePath);
        $this->getBySlug($slug)->delete();

        return response()->json(['deleted' => true]);
    }

    public function countAll()
    {
        return $this->stagedsermon->all()->count();
    }
}
