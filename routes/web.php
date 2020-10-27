<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

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


Route::any('/search',function(){
    {
       // if (Route::input('q'))
    
     return view('search/SERP');
    }
 });