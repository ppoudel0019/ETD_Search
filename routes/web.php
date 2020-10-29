<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/profile/show', function () {
    return view('profile/show');
})->name('user/profile');


  

Route::any('/search', [ImageController::class,'search']);

Route::any('/advsearch', [ImageController::class,'advsearch']);

Route::any('/advSERP', [ImageController::class,'advSERP']);