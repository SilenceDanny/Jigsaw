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
	if(Auth::check())
		return view('index');
	else
    	return view('indexunlog');
});

Route::post('/uploadimg','Corp\CorpController@Corp')->middleware('auth');

Route::post('/playExists','PlayExistsController@Play')->middleware('auth');

Route::post('/saveRank','SaveRankController@SaveRank')->middleware('auth');

Route::get('/puzzle', function(){
	return view('puzzle');
});

Route::post('/createGame','CollaController@CreateGame')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/server', function(){
	return view('serverlist');
});

Route::post('/joinGame','CollaController@JoinGame')->middleware('auth');