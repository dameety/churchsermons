<?php

namespace App\Http\Controllers\API;

use App\Sermon;
use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;



class CategoriesApiController extends Controller
{

    public function index () {
        return Category::latest('created_at')->paginate(30);
    }

    public function all() {
        return Category::latest('created_at')->get();
    }

    public function count () {
        return Category::all()->count();
    }

    public function fetchCategories () {
        return Category::all();
    }

    public function newCategory(Request $request) {
        $data = Input::all();
        $category = new Category;

        if($category->validate($data)) {
            $category -> name = $request->name;
            $category -> description = $request->description;
            $category ->save();
            return response('success', 201); 
        } else {
            $errors = $category->getErrors();
            return response($errors, 422);
        }

    }

    public function categoryUpdate(Request $request, $slug) {

        $data = Input::all();
        $category = Category::whereSlug($slug)->first();

        if($category->validate($data, $key = "update")) {
            $category -> name = $request-> name;
            $category -> description = $request-> description;
            $category -> save();  
            return response('success', 201);
        } else {
            $errors = $category->getErrors();
            return response($errors, 422);
        }

    }

    
    public function sermonCategoryFilter(Category $category) {
        return $category->sermons;
    }

    public function deleteCategory(Category $category){
        $category->delete();
    }

}
