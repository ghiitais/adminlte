<?php

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
    return view('auth/login');
});

Auth::routes();


Route::get('home', 'HomeController@home')->name('home');
Route::resource('articles', 'ArticlesController');
Route::get('actualites', 'ArticlesController@home');

Route::resource('vue-collaborateurs', 'CollaborateurController');
Route::get('collaborateurs', 'CollaborateurController@home');

Route::resource('vue-services', 'ServiceController');
Route::get('services', 'ServiceController@home');
/*Route::get('/test', function () {
    return \App\Collaborateur::with(['service', 'manager'])->orderBy('created_at', 'DESC')->get();

}); */