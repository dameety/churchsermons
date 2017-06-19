<?php



Route::get('/', 'HomeController@welcome');


Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


// admin auth routes
Route::group(['prefix' => 'admin'], function () {

    Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::get('/logout', 'AdminAuth\LoginController@logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

});

Route::get('/admin', function () {
    return redirect('/admin/login');
});


Route::group(['middleware' => 'auth'], function () {

    // get sermons by category
    Route::name('category')->get('/category/{slug}', 'SermonsController@getCategory');



    Route::name('profileUpdate')->post('/user/profile/update', 'UsersController@profileUpdate');
    Route::name('profile')->get('/user/profile', 'UsersController@profile');
    Route::name('userCards')->get('/user/cards', 'UsersController@getUserCards');
    Route::name('userSubscription')->get('/user/subscription', 'UsersController@getSubscription');




    Route::name('service')->get('/service/{slug}', 'SermonsController@getService');
    Route::name('allSermons')->get('/sermons', 'SermonsController@allSermons');
    Route::name('download')->post('/download/{slug}', 'SermonsController@downloadSermon');



    Route::name('favourite')->post('/favourite/{slug}', 'SermonsController@favouriteSermon2');
    Route::name('viewFavourite')->get('/sermons/favourites', 'SermonsController@viewFavourites');
    Route::name('favouriteRemove')->post('/myfavourites/remove/{slug}', 'SermonsController@favouriteRemove');
    Route::name('favouriteDownload')->post('/myfavourites/download/{slug}', 'SermonsController@favouriteDownload');
    Route::name('upgradeAccount')->get('/user/upgrade', 'UsersController@upgradeAccount');
    Route::name('upgradeAction')->post('/user/upgrade/action', 'UsersController@upgradeAction');


    Route::name('cancelSubscription')->post('/subscription/cancel', 'UsersController@cancelSubscription');
    Route::name('reactivateSubscription')->post('/user/subscription/reactivate', 'UsersController@reactivateSubscription');
    Route::name('updateCard')->post('/user/card/update/{id}', 'UsersController@updateCard');
    Route::name('deleteCard')->post('/user/card/delete/{id}', 'UsersController@deleteCard');
    Route::name('newCard')->post('/user/card/new', 'UsersController@newCard');
});
