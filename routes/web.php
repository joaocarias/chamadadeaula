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
    Route::put('/escolas/update/{id}', 'EscolaController@update')->name('update_escola');

    /* Aluno */
    Route::get('/alunos', 'AlunoController@index')->name('alunos');
    Route::get('/alunos/exibir/{id}', 'AlunoController@show')->name('exibir_aluno');
    Route::get('/alunos/novo', 'AlunoController@create')->name('novo_aluno');
    Route::post('/alunos/store', 'AlunoController@store')->name('cadastrar_aluno');
    Route::get('/alunos/excluir/{id}', 'AlunoController@destroy')->name('excluir_aluno');
 
});