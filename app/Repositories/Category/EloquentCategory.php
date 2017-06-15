<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;

class EloquentCategory implements CategoryRepository
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->category->all();
    }

    public function getAllOrderByLatest()
    {
        return $this->category->latest('created_at')->get();
    }

    public function get30Paginated()
    {
        return $this->category->latest('created_at')->paginate(30);
    }

    public function getBySlug($slug)
    {
        return $this->category->findBySlug($slug);
    }

    public function create($request)
    {
        $category = $this->category;
        $category -> name = $request->name;
        $category -> description = $request->description;
        $category ->save();
        return response()->json(['created' => true]);
    }

    public function update($slug, $request)
    {
        $category = $this->getBySlug($slug);
        $category -> name = $request-> name;
        $category -> description = $request-> description;
        $category -> save();
        return response()->json(['updated' => true]);
    }

    public function delete($slug)
    {
        $this->getBySlug($slug)->delete();
        return response()->json(['deleted' => true]);
    }

    public function countAll()
    {
        return $this->category->all()->count();
    }

    public function increaseSermonCount($id)
    {
        return $this->category->countUp($id);
    }
}
