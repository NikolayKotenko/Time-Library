<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('home');
});
Route::get('/edit', function () {
    return view('form_edit');
});

//Route::get('/articles', function () {
//    return view('articles');
//});
//Route::get('/books', function () {
//    return view('books');
//});
//Route::get('/audio-books', function () {
//    return view('audio-books');
//});
//Route::get('/podcasts', function () {
//    return view('podcasts');
//});
//Route::get('/films', function () {
//    return view('film');
//});
//Route::get('/video-self-dev', function () {
//    return view('video-self-dev');
//});
//Route::get('/anime', function () {
//    return view('anime');
//});


//Route::get('/cruds', function () {
//    return view('/cruds/cruds');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
