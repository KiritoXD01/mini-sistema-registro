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

Auth::routes([
    'register' => false,
    'reset' => false
]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'user'], function(){
    //GET: Get all users
    Route::get('/', 'UserController@index')->middleware('auth')->name('user.index');
    //GET: Create a new user view
    Route::get('/create', 'UserController@create')->middleware('auth')->name('user.create');
    //GET: Edit an user view
    Route::get('/{user}', 'UserController@edit')->middleware('auth')->name('user.edit');
    //POST: Create a new user
    Route::post('/', 'UserController@store')->middleware('auth')->name('user.store');
    //PATCH: Update an existing user
    Route::patch('/{user}', 'UserController@update')->middleware('auth')->name('user.update');
    //DELETE: Deletes and user
    Route::delete('/{user}', 'UserController@destroy')->middleware('auth')->name('user.destroy');
});

Route::group(['prefix' => 'role'], function(){
    //GET: Get all user roles
    Route::get('/', 'RoleController@index')->middleware('auth')->name('role.index');
    //GET: Create a new user view
    Route::get('/create', 'RoleController@create')->middleware('auth')->name('role.create');
    //GET: Edit an user view
    Route::get('/{role}', 'RoleController@edit')->middleware('auth')->name('role.edit');
    //POST: Create a new user
    Route::post('/', 'RoleController@store')->middleware('auth')->name('role.store');
    //PATCH: Update an existing user
    Route::patch('/{role}', 'RoleController@update')->middleware('auth')->name('role.update');
    //DELETE: Deletes and user
    Route::delete('/{role}', 'RoleController@destroy')->middleware('auth')->name('role.destroy');
});
