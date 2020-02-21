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

  /* Profissionais */
  Route::get('/profissionais', 'ProfissionalController@index')->name('profissionais');
  Route::get('/profissionais/novo', 'ProfissionalController@create')->name('novo_profissional');
  Route::post('/profissionais/store', 'ProfissionalController@store')->name('cadastrar_profissional');
  Route::get('/profissionais/exibir/{id}', 'ProfissionalController@show')->name('exibir_profissional');
  Route::get('/profissionais/editar/{id}', 'ProfissionalController@edit')->name('editar_profissional');
  Route::put('/profissionais/update/{id}', 'ProfissionalController@update')->name('update_profissional');
  Route::get('/profissionais/excluir/{id}', 'ProfissionalController@destroy')->name('excluir_profissional');
  Route::get('/profissionais/resentarsenha/{id}', 'ProfissionalController@resetPassword')->name('resetar_senha_profissional');
  Route::get('/profissionais/criarusuario/{id}', 'ProfissionalController@createUser')->name('criar_usuario_profissional');

  /* Turma */
  Route::get('/turmas', 'TurmaController@index')->name('turmas');
  Route::get('/turmas/novo', 'TurmaController@create')->name('nova_turma');
  Route::get('/turmas/exibir/{id}', 'TurmaController@show')->name('exibir_turma');
  Route::post('/turmas/store', 'TurmaController@store')->name('cadastrar_turma');
  Route::get('/turmas/editar/{id}', 'TurmaController@edit')->name('editar_turma');
  Route::put('/turmas/update/{id}', 'TurmaController@update')->name('update_turma');
  Route::post('/turmas/associarprofessor', 'TurmaController@associarprofessor')->name('associarturmaprofessor');
  Route::get('/turmas/removerprofessor/{id}', 'TurmaController@removerprofessor')->name('removerturmaprofessor');
  Route::post('/turmas/associaraluno', 'TurmaController@associaraluno')->name('associarturmaaluno');
  Route::get('/turmas/removeraluno/{id}', 'TurmaController@removeraluno')->name('removerturmaaluno');
  Route::get('/turmas/excluir/{id}', 'TurmaController@destroy')->name('excluir_turma');
  
  
  /* Chamada Turma Aluno */
  Route::get('/chamadas', 'ChamadaTurmaAlunoController@index')->name('chamadas');
  Route::get('/chamadas/registro/{id}', 'ChamadaTurmaAlunoController@registro')->name('registro_chamada'); 
  Route::get('/chamadas/imprimir/{id}', 'ChamadaTurmaAlunoController@imprimir')->name('imprimir_registro_chamada'); 
  Route::get('/chamadas/imprimirpdf', 'ChamadaTurmaAlunoController@imprimirpdf')->name('imprimir_pdf');
  

  /* Planejamento Semanal */
  Route::get('/planejamentossemanais', 'PlanejamentoSemanalController@index')->name('planejamentossemanais');
  Route::get('/planejamentossemanais/novo', 'PlanejamentoSemanalController@create')->name('novo_planejamento_semanal');
  Route::post('/planejamentossemanais/store', 'PlanejamentoSemanalController@store')->name('cadastrar_planejamento_semanal');
  Route::get('/planejamentossemanais/exibir/{id}', 'PlanejamentoSemanalController@show')->name('exibir_planejamento_semanal');
  Route::get('/planejamentossemanais/excluir/{id}', 'PlanejamentoSemanalController@destroy')->name('excluir_planejamento_semanal');
  Route::get('/planejamentossemanais/editar/{id}', 'PlanejamentoSemanalController@edit')->name('editar_planejamento_semanal');
  Route::put('/planejamentossemanais/update/{id}', 'PlanejamentoSemanalController@update')->name('update_planejamento_semanal');
  Route::get('/planejamentossemanais/imprimir/{id}', 'PlanejamentoSemanalController@imprimir')->name('imprimir_planejamento_semanal');
  Route::get('/planejamentossemanais/upload', 'PlanejamentoSemanalController@uploadarquivo')->name('upload_planejamento_semanal');
  Route::post('/planejamentossemanais/storeupload', 'PlanejamentoSemanalController@store_upload')->name('cadastrar_upload_planejamento_semanal');
  

  /* Relatos */
  Route::get('/relatos', 'RelatoController@index')->name('relatos');
  Route::get('/relatos/turma/{id}', 'RelatoController@turma')->name('relatos_de_turma');
  
  Route::get('/usuarios', 'UsuarioController@index')->name('usuarios');

});
