<?php

use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\UserCollection as UserCollection;
use App\Http\Resources\ArticleCollection as ArticleCollection;

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

Route::get('/profile', 'UserController@profile')->name('user.profile');
Route::post('/profile', 'UserController@update_profile')->name('user.profile.update');
Route::get('/wordpressapi', 'WpController@getWpData');

/*Route::get('/test', function () {
    return \App\Collaborateur::with(['service', 'manager'])->orderBy('created_at', 'DESC')->get();

}); */

Route::get('new_ticket', 'TicketsController@create');
Route::post('new_ticket', 'TicketsController@store');
Route::get('my_tickets', 'TicketsController@userTickets');
Route::get('tickets/{ticket_id}', 'TicketsController@show');
Route::post('comment', 'CommentsController@postComment');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

    Route::post('close_ticket/{ticket_id}', 'TicketsController@close');
});
Route::get('ticketsShow', 'TicketsController@showAll');
Route::post('addTicket','TicketsController@addTicket');

//Json response
Route::get('tickets', 'TicketsController@index');



//Demande
Route::get('creer_demande', 'DemandeController@create');
Route::post('new_demande', 'DemandeController@store');
// Les demandes affichées aux utilisateurs
Route::get('mes_demandes', 'DemandeController@afficherDemandes');
Route::post('delete/{id}', 'DemandeController@deleteDemande');
//cliquer sur btn rejeter -> show -> faire entrer la raison du rejet
Route::get('demandes/{demande_id}', 'DemandeController@show');
Route::get('demandeDetails/{demande_id}', 'DemandeController@demandeDetails');

//ADMIN

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('demandes', 'DemandeController@afficherDemandesAdmin');
    Route::post('accepter/{demande_id}', 'DemandeController@accepterDemande');
    Route::post('encours/{demande_id}', 'DemandeController@enCours');
    Route::post('rejeter/{demande_id}', 'RaisonController@postRejet');
    Route::post('rejeterDef/{demande_id}', 'DemandeController@Rejeter');
});

// Middleware assistante
Route::group(['prefix' => 'assistante', 'middleware' => 'assistante'], function() {
    Route::get('demandes_active', 'DemandeController@afficherDemandesAssistanteActive');
    Route::get('demandes_inactive', 'DemandeController@afficherDemandesAssistanteInactive');
    Route::post('forward/{demande_id}', 'DemandeController@forwardToManager');
});




// Middleware managers

Route::group(['prefix' => 'manager', 'middleware' => 'manager'], function() {
    Route::get('demandes', 'DemandeController@afficherDemandesManager');
    Route::post('accepter/{demande_id}', 'DemandeController@accepterDemande');
    Route::post('encours/{demande_id}', 'DemandeController@enCours');
    // Route::post('rejeter/{demande_id}', 'DemandeController@rejeterDemande');
    Route::post('rejeter/{demande_id}', 'RaisonController@postRejet');
});

Route::get('ajouter_managers', 'UserController@addManagers');
Route::post('ajouter_manager/{id}', 'UserController@addManagersFunc');
Route::post('remove_manager/{id}', 'UserController@removeManager');


// COLLAB LOGIN


Route::post('userlogin', 'CollaborateurController@userLogin');
Route::get('findUserByEmail/{email}', 'CollaborateurController@findUserByEmail');
Route::post('editProfile/{email}', 'CollaborateurController@editProfile');


// USER LOGIN

Route::post('loginUser', 'UserController@userLogin');
Route::get('findByEmail/{email}', 'UserController@findUserByEmail');
Route::post('edit/{email}', 'UserController@editProfile');

// Demandes mobile

Route::get('mes_demandes/{id}', 'DemandeController@afficherDemandesJson');
Route::post('post_comment/{ticket_id}', 'CommentsController@addComment');
Route::post('add_demande', 'DemandeController@addDemande');

// files

Route::get('file','FileController@create');
Route::post('file','FileController@store');
Route::get('all_files', 'FileController@showFiles');
Route::get('filesJson', 'FileController@showFilesJson');
Route::post('deleteFile/{id}', 'FileController@deleteFile');

// Marketplace



Route::get('/multiuploads', 'MarketController@uploadForm');

Route::resource('itemsview', 'MarketController');

Route::get('/itemsview/delete/{id}', 'MarketController@delete');
Route::get('/itemsview/{id}/view', 'MarketController@show');

Route::get('/datatable', 'MarketController@getdatatable')->name('datatable');
Route::post('/multiuploads', 'MarketController@uploadSubmit');

// Marketplace mobile
Route::get('/showMarket', 'MarketController@showMarket');
Route::post('uploadImages', 'MarketController@uploadImages');

// Close ticket mobile
Route::post('closeTicket/{id}', 'TicketsController@closeTicket');