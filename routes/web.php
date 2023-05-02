<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web']], function(){

    Route::name('web.index')->get('/', 'WebController@index');
    Route::name('web.privacy')->get('/privacy.html', 'WebController@privacy');

});

// Route::get('/clear_cache', function () {

//     \Artisan::call('config:cache');
//     \Artisan::call('cache:clear');
//     \Artisan::call('view:cache');
//     \Artisan::call('optimize');
//     \Artisan::call('optimize:clear');
//     dd("Cache is cleared");

// });
