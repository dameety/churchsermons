<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Sermon\SermonRepository;

class SermonController extends Controller
{
    protected $sermon;

    public function __construct(SermonRepository $sermon)
    {
        $this->$sermon = $sermon;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
