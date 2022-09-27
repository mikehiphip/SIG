<?php


// Route::get('', function () {
    // return redirect('backend/index');
// });

// Route::get('/clear-cache', function() {
    // Artisan::call('cache:clear');
    // return "Cache is cleared";
// });
Route::get('/clc', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    // Artisan::call('optimize');
    // Artisan::call('clear-compiled');
        // Artisan::call('view:clear');
        // session()->forget('key');
    return "Cleared!";

});

/*
|--------------------------------------------------------------------------------------------------------------------------
| Web frontend
|--------------------------------------------------------------------------------------------------------------------------
*/
require_once('web-frontend.php');

/*
|--------------------------------------------------------------------------------------------------------------------------
| Web backend
|--------------------------------------------------------------------------------------------------------------------------
*/
require_once('web-backend.php');

