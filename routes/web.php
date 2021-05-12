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
  Route::post('/profissionais/inserirregra', 'ProfissionalController@inserirregrauser')->name('inserir_regra_usuario');
  Route::get('/profissionais/removerregrauser', 'ProfissionalController@removerregrauser')->name('remover_regra_user');
  
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
  Route::get('/chamadas/imprimirpdf/{id}', 'ChamadaTurmaAlunoController@imprimirpdf')->name('imprimir_pdf');
  Route::get('/chamadas/justificar/{id}', 'ChamadaTurmaAlunoController@justificar')->name('justificar'); 
  Route::get('/chamadas/excluirjustificativa/{id}', 'ChamadaTurmaAlunoController@excluirjustificativa')->name('excluirjustificativa'); 
  
  
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
  Route::put('/planejamentossemanais/updateuploadarquivo/{id}', 'PlanejamentoSemanalController@update_upload_arquivo')->name('update_upload_arquivo');
  Route::get('/planejamentossemanais/editarupload/{id}', 'PlanejamentoSemanalController@edit_upload')->name('editar_upload_planejamento_semanal');
  Route::get('/planejamentossemanais/revisar/{id}', 'PlanejamentoSemanalController@edit_revisar')->name('editar_revisar_planejamento_semanal');
  Route::put('/planejamentossemanais/update_revisar/{id}', 'PlanejamentoSemanalController@update_revisar')->name('revisar_planejamento_semanal');
  Route::get('/planejamentossemanais/turma/{id}', 'PlanejamentoSemanalController@turma')->name('planejamento_semanal_de_turma');
  Route::get('/planejamentossemanais/copiar/{id}', 'PlanejamentoSemanalController@copiar')->name('copiar_planejamento_semanal');
  

  /* Relatos */
  Route::get('/relatorios', 'RelatoController@index')->name('relatorios');
  Route::get('/relatorios/turma/{id}', 'RelatoController@turma')->name('relatorios_de_turma');
  Route::get('/relatorios/novo/{id_turma}/{id_aluno}', 'RelatoController@create')->name('relatorio_novo');
  Route::post('/relatorios/store', 'RelatoController@store')->name('cadastrar_relatorio');
  Route::get('/relatorios/excluir/{id}', 'RelatoController@destroy')->name('excluir_relatorio');
  Route::get('/relatorios/editar/{id}', 'RelatoController@edit')->name('editar_relatorio');
  Route::put('/relatorios/update/{id}', 'RelatoController@update')->name('update_relatorio');
  Route::get('/relatorios/imprimir/{turma_id}/{trimestre}', 'RelatoController@imprimir')->name('imprimir_relatorio');
  Route::get('/relatorios/revisar/{id}', 'RelatoController@edit_revisar')->name('editar_revisar_relatorio');
  Route::put('/relatorios/update_revisar/{id}', 'RelatoController@update_revisar')->name('revisar_relatorio');
  
  Route::get('/usuarios', 'UsuarioController@index')->name('usuarios');

});
