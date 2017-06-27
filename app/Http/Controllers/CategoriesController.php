<?php

namespace App\Http\Controllers;

class CategoriesController extends Controller
{
    public function categoriesPage()
    {
        return view('admin.categories.categories');
    }
}
