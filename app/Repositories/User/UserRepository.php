<?php

namespace App\Repositories\User;

interface UserRepository
{
    public function getAll();

    public function countAll();

    public function authUser();

    public function getBySlug($slug);

    public function get30Paginated();

    public function create($request);

    public function typeFilter($type);

    public function update($request);

    public function updateWithPassword($request);

    public function delete($slug);

    public function changePassword($slug, $request);

    public function attachFavourite($id);

    public function detachFavourite($id);

    public function allUserFavourites();

    public function allUserFavouriteCount();
}
