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

use App\Http\Controllers\DetailsController;

Route::get('/start', 'StartController@getStart');
Route::any('/products', 'MahlzeitenController@getMahlzeiten');
Route::get('/details/{id}', function ($id) {
    //(new App\Http\Controllers\LoginController())->login();
    return (new App\Http\Controllers\DetailsController)->getDetails($id);
});
Route::post('/details/{id}', function ($id) {
    (new App\Http\Controllers\LoginController())->login();
    return (new App\Http\Controllers\DetailsController)->getDetails($id);
});
Route::post('/comment/{id}', function ($id) {
    (new App\Http\Controllers\CommentController())->addComment($id);
    return redirect('/details/'.$id);
});
Route::get('/impressum', 'StartController@getStart');
Route::any('/login', 'LoginController@login');
Route::get('/register', 'RegistrationController@getRegister');
Route::post('/register', 'RegistrationController@getRegister');
Route::get('/ingredients', 'IngredientsController@getIngView');
