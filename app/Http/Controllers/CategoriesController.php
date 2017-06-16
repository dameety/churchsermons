<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function categoriesPage()
    {
        return view('admin.categories.categories');
    }
}
