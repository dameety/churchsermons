<?php

namespace App\Repositories\Sermon;

interface SermonRepository
{
    public function getAll();

    public function get30Paginated();

    public function get10Paginated();

    public function getBySlug($slug);

    public function create($request);

    public function update($slug, $request);

    public function delete($slug, $filePath);

    public function countAll();

    public function getCategory($slug);

    public function getService($slug);

    public function download($slug);

    public function favourite($slug);

    public function unFavourite($slug);

    public function getFavourite();

    public function downloadFavourite($slug);
}
