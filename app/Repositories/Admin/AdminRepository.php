<?php

namespace App\Repositories\Admin;

interface AdminRepository
{
    public function getAll();

    public function countAll();

    public function authAdmin();

    public function getBySlug($slug);

    public function get30Paginated();

    public function create($request);

    public function typeFilter($type);

    public function update($slug, $request);

    public function delete($slug);

    public function changePassword($slug, $request);
}
