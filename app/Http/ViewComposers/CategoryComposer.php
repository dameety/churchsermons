<?php

namespace App\Http\ViewComposers;

use App\Repositories\Category\CategoryRepository;
use Illuminate\View\View;

class CategoryComposer
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function compose(View $view)
    {
        $view->with('categories', $this->category->getAllOrderByLatest());
    }

    public function filter(View $view)
    {
        // $view->with('categories', $this->category->sermonCategoryFilters());
    }
}
