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


Route::get('/',function () {
    return redirect('/login');
});

Route::post('/connexion','Auth\LoginController@connexion');

// no permission route
Route::get('/no-permission','HomeController@noPermission');
// ROUTE D'ADMINISTRATION

Route::middleware(['auth','state','admin'])->group(function () {

    Route::get('admin/dashboard','AdminController@dashboard');
    Route::get('admin/add-gerant','AdminController@addGerant');
    Route::get('admin/list-gerant','AdminController@listGerant');
    Route::post('admin/add-gerant','AdminController@addGerantToDb');
    Route::get('admin/add-boutique','AdminController@addBoutique');
    Route::post('admin/add-boutique','AdminController@addBoutiqueToDb');
    Route::get('admin/add-item','AdminController@addItem');
    Route::post('admin/add-item','ProduitController@addItemToDb');
    Route::get('admin/list-item','AdminController@listItem');
    Route::post('admin/list-item','ProduitController@getListItem');
    Route::get('admin/list-command','AdminController@listCommand');
    Route::post('admin/list-command','AdminController@getListCommand');
    Route::post('admin/list-command/filter','AdminController@getCommandByFilter');
    Route::get('admin/item/{id}','AdminController@detailsItem');
    Route::get('admin/profile','AdminController@profile');
    Route::post('admin/profile','AdminController@changePassword');
    Route::get('admin/command/{code}','AdminController@detailsCommand');
    // recherche inauthstantanee
    Route::post('admin/list-item/search-item','ProduitController@searchItem');
    // FILTRAGE PAR DATE
    Route::post('admin/list-command/filter-by-date','AdminController@filterByDate');

    Route::get('admin/bilan','AdminController@bilan');
    Route::post('admin/bilan','AdminController@bilanByBoutique');
    Route::post('/admin/bilan/by-date','AdminController@filtrerByDate');

    Route::get('admin/entree','AdminController@listEntree');
    Route::post('admin/entree','AdminController@getListEntree');
    Route::get('admin/edit-item/{id}','AdminController@editItem');
    Route::post('admin/edit-item/{id}','AdminController@makeEditItem');
    // simplify
    Route::post('admin/add-item/simplify','AdminController@simplify');
    // blocked unblocked user
    Route::post("admin/list-gerant/block-user",'AdminController@actionStateUser');
    Route::post('/admin/list-gerant/unblock-user','AdminController@actionStateUser');

});

// /////==========================
// ROUTE DE GERANT


// //=====================

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth','state','gerant'])->group(function () {

	Route::get('gerant/dashboard','GerantController@dashboard');
    Route::get('gerant/command/add','GerantController@addCommande');
    Route::get('gerant/command/list','GerantController@listCommand');
    Route::post('gerant/command/add','GerantController@getListItem');
    Route::post('gerant/dashboard/list-item','GerantController@getListItem');
    Route::post('gerant/command/new-command','GerantController@newCommand');
    Route::post('gerant/command/add-item','GerantController@addItemToCommand');
    Route::post('gerant/add-item','GerantController@addItemToCommand');
    // recuperation du contenu du panier
    Route::post('gerant/dashboard/get-panier','GerantController@getPanierContent');
    Route::post('gerant/command/add/get-panier','GerantController@getPanierContent');
    Route::post('gerant/command/list/get-panier','GerantController@getPanierContent');
    Route::post('gerant/profile/get-panier','GerantController@getPanierContent');
    Route::post('gerant/item/{id}/get-panier','GerantController@getPanierContent');
    Route::post('gerant/command/{code}/get-panier','GerantController@getPanierContent');
    // Route::post('gerant/{item}/{id?}/{code?}','GerantController@getPanierContent');
    //
    Route::post('gerant/dashboard/','GerantController@getPanierDetails');
    Route::post('gerant/command/add/get-details','GerantController@getPanierDetails');
    Route::post('gerant/command/list/get-details','GerantController@getPanierDetails');
    Route::post('gerant/profile/get-details','GerantController@getPanierDetails');
    Route::post('gerant/item/details/get-details','GerantController@getPanierDetails');
    Route::post('gerant/item/{id}/get-details','GerantController@getPanierDetails');
    Route::post('gerant/command/{code}/get-details','GerantController@getPanierDetails');

    // finalisation de la commande
    Route::post('gerant/command/finalise','GerantController@confirmCommand');
    Route::post('gerant/item/finalise','GerantController@confirmCommand');
    Route::post('gerant/command/list','GerantController@getListCommand');
    // command par date
    Route::post('/gerant/command/list/by-date','GerantController@getListCommandByDate');
    //LE PROFIL
    Route::get('gerant/profile/','GerantController@getProfile');
    Route::post('gerant/profile','GerantController@changePassword');

    // DETAILS PRODUIT
    Route::get('gerant/item/{id}','GerantController@detailsItem');
    // DETAILS COMMANDE
    Route::get('gerant/command/{code}','GerantController@detailsCommande');
});
