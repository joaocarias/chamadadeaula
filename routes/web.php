<?php

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('inicio');
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
    Route::get('/alunos/editar/{id}', 'AlunoController@edit')->name('editar_aluno');
    Route::put('/alunos/update/{id}', 'AlunoController@update')->name('update_aluno');

    /* Professores */
    Route::get('/professores', 'ProfessorController@index')->name('professores');
    Route::get('/professores/novo', 'ProfessorController@create')->name('novo_professor');    
    Route::post('/professores/store', 'ProfessorController@store')->name('cadastrar_professor');
    Route::get('/professores/exibir/{id}', 'ProfessorController@show')->name('exibir_professor');
    Route::get('/professores/editar/{id}', 'ProfessorController@edit')->name('editar_professor');
    Route::put('/professores/update/{id}', 'ProfessorController@update')->name('update_professor');
    Route::get('/professores/excluir/{id}', 'ProfessorController@destroy')->name('excluir_professor');

    /* User */
    Route::get('/usuarios/atualizarsenha', 'Auth\\UserController@atualizarSenha')->name('atualizar_senha');
    Route::put('/usuarios/updatepassword/{id}', 'Auth\\UserController@updatePassword')->name('update_password');
    
});