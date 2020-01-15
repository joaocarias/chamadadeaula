<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    /* Escola */
    Route::get('/escolas', 'EscolaController@index')->name('escolas');
    Route::get('/escolas/editar/{id}', 'EscolaController@edit')->name('editar_escola');
});