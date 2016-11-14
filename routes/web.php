<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/**
 * Setup Routes
**/

Route::post( '/setup/database', [ 'uses' => 'setupController@postDatabaseDetails', 'as' => 'setup.database' ] );

Route::post( '/setup/app', [ 'uses' => 'setupController@postAppDetails', 'as' => 'setup.app' ] );

Route::get( '/setup/{page_id?}', [ 'uses' => 'setupController@getPages', 'as' => 'setup' ] )->where( 'page_id', '[1-3]+' );

/**
 * Login Route
**/

Route::get( '/login', [ 'uses' =>   'loginController@getLogin', 'as' => 'login.index' ] );

Route::post( '/login/log-user', [ 'uses' =>   'loginController@postLogin', 'as' => 'login.post' ] );

/**
 * Dashboard Route
**/

Route::get( '/dashboard', [ 'uses' =>   'dashboardController@home', 'as'    =>  'dashboard.index' ] );

/**
 * Module Route
**/

Route::get( '/dashboard/modules', [ 'uses' =>   'dashboardController@modules', 'as'    =>  'dashboard.modules.index' ] );

Route::get( '/dashboard/modules/store', [ 'uses' =>   'dashboardController@modulesStore', 'as'    =>  'dashboard.modules.store' ] );

Route::post( '/dashboard/modules/upload', [ 'uses' =>   'dashboardController@modulesUploadPost', 'as'    =>  'dashboard.modules.upload.send' ] );

Route::post( '/dashboard/modules/upload', [ 'uses' =>   'dashboardController@modulesUpload', 'as'    =>  'dashboard.modules.upload.index' ] );

/**
 * Users Ressources
**/

Route::resource( '/dashboard/users', 'UsersController');

/**
 * Roles Ressources
**/

Route::resource( '/dashboard/roles', 'RolesController');

/**
 * Permissions Ressources
**/

Route::resource( '/dashboard/permissions', 'PermissionsController' );

/**
 * Roles Permissions Resources
**/

Route::resource( '/dashboard/relation', 'rolesPermissionsController' );
