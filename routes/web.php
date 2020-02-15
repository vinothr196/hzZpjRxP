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

Route::get('/', 'ServiceRequestsController@index')->name('home');
Route::get('/getModel/{make_id}', 'ServiceRequestsController@getModel');
Route::get('/create-ticket', 'ServiceRequestsController@createTicket')->name('createTicket');
Route::post('/create-ticket', 'ServiceRequestsController@store');
Route::get('{id}', 'ServiceRequestsController@edit')->name('edit');
Route::get('delete/{id}', 'ServiceRequestsController@delete')->name('delete');
