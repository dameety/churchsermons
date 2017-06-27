<?php

namespace App\Repositories\Service;

use App\Models\Service;

class EloquentService implements ServiceRepository
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getAll()
    {
        return $this->service->all();
    }

    public function getAllOrderByLatest()
    {
        return $this->service->latest('created_at')->get();
    }

    public function get30Paginated()
    {
        return $this->service->latest('created_at')->paginate(30);
    }

    public function getBySlug($slug)
    {
        return $this->service->findBySlug($slug);
    }

    public function create($request)
    {
        $service = $this->service;
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();

        return response()->json(['created' => true]);
    }

    public function update($slug, $request)
    {
        $service = $this->getBySlug($slug);
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();

        return response()->json(['updated' => true]);
    }

    public function delete($slug)
    {
        $this->getBySlug($slug)->delete();

        return response()->json(['deleted' => true]);
    }

    public function countAll()
    {
        return $this->service->all()->count();
    }

    public function increaseSermonCount($id)
    {
        return $this->service->countUp($id);
    }
}
