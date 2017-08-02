<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EloquentUser implements UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function get30Paginated()
    {
        return $this->user->latest('created_at')->paginate(30);
    }

    public function getBySlug($slug)
    {
        return $this->user->findBySlug($slug);
    }

    public function create($request)
    {
        $user = $this->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->permission = $request->permission;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['success' => 201]);
    }

    public function authUser()
    {
        return Auth::user();
    }

    public function checkPersmision($status)
    {
        return $this->user->checkPersmision($status);
    }

    public function authCheck()
    {
        if(Auth::check()) {
            return "true";
        } else {
            return "false";
        }
    }

    public function attachFavourite($id)
    {
        return $this->authUser()->favourites()->attach($id);
    }

    public function detachFavourite($id)
    {
        return $this->authUser()->favourites()->detach($id);
    }

    public function allUserFavourites()
    {
        return $this->authUser()->favourites;
    }

    public function allUserFavouritesCount()
    {
        return $this->authUser()->favourites()->count();
    }

    public function update($request)
    {
        $user = $this->authUser();
        $user->name = $request->name;
        $user->email = $this->authUser()->email;

        return $user->save();
    }

    public function updateWithPassword($request)
    {
        $user = $this->authUser();
        $user->name = $request->name;
        $user->email = $this->authUser()->email;
        $user->password = bcrypt($request->password);

        return $user->save();
    }

    public function changePassword($slug, $request)
    {
        $user = $this->user->getBySlug($slug);
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['password change' => true]);
    }

    public function delete($slug)
    {
        $this->getBySlug($slug)->delete();

        return response()->json(['deleted' => true]);
    }

    public function countAll()
    {
        return $this->user->all()->count();
    }

    public function typeFilter($type)
    {
        return $this->user->where('permission', $type)->all();
    }
}
