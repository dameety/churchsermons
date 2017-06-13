<?php

namespace App\Repositories\Stagedsermon;

interface StagedsermonRepository
{
    public function getAll();

    public function get10Paginated();

    public function getBySlug($slug);

    public function create($request);

    public function delete($slug, $filePath);

    public function countAll();
}
