@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>{{ __($turmaProfessor->turma->nome) }}</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('chamadas') }}">Chamada</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Turma</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">

            @if (session('status'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">Filtrar Chamada por Data</div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <form class="form-inline" method="GET" action="{{ route('registro_chamada', ['id' => $turmaProfessor->turma_id]) }}">

                            <div class="form-group mx-sm-3 mb-2">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
                                    </div>
                                    <input id="data" type="text" class="form-control @error('data') is-invalid @enderror datepicker" name="data" value="{{ old('data', $data ?? '') }}" autocomplete="off" required>
                                </div>
                                @error('data')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-laptop-code"></i> Definir Dia de Aula</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($justificativaTurma) && !is_null($justificativaTurma) && count($justificativaTurma) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">Chamada de Aula para a data <strong>{{ $data }}</strong></div>
                <div class="card-body">   
                        <table class="table table-hover">
                        <thead>
                            <tr>                                                                                        
                                <th scope="col">Justificativa</th>                               
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($justificativaTurma as $item)
                            <tr>                                            
                                <td>{{ __($item->justificativa) }}</td>                                
                                <td class="text-right">
                                   <a href="#" class="btn btn-danger btn-sm btn-excluir" id-turma="{{ $turmaProfessor->id }}" id-justificativa="{{ $item->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    @else
               
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">Chamada de Aula para a data <strong>{{ $data }}</strong></div>
                <div class="card-body">
                    <div class="row justify-content-center">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col"></th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach ($turmaAlunos as $item)
                                <tr>
                                    <td>{{ __($item->aluno_id) }}</td>
                                    <td>{{ __($item->aluno->nome) }}</td>
                                    <td class="text-right">
                                        <?php
                                        $_botaoPresenca = "btn-outline-success";
                                        $_botaoFalta = "btn-outline-danger";

                                        foreach ($chamadaTurmaAluno as $chamada) {
                                            if ($item->aluno_id == $chamada->aluno_id && $chamada->situacao == 'P') {
                                                $_botaoPresenca = "btn-success";
                                            }

                                            if ($item->aluno_id == $chamada->aluno_id && $chamada->situacao == 'F') {
                                                $_botaoFalta = "btn-danger";
                                            }
                                        }

                                        ?>
                                        <a href="#" class="btn btn-sm {{ __($_botaoPresenca) }} btn-chamada btn-p btn-p-{{__($item->id)}}" id-btn="{{__($item->id)}}" situacao="P" data="{{ $data }}" id-turma="{{__($item->turma_id)}}" id-aluno="{{__($item->aluno_id)}}"><i class="fas fa-check-square"></i></a>
                                        <a href="#" class="btn btn-sm {{ __($_botaoFalta) }} btn-chamada btn-f btn-f-{{__($item->id)}}" id-btn="{{__($item->id)}}" situacao="F" data="{{ $data }}" id-turma="{{__($item->turma_id)}}" id-aluno="{{__($item->aluno_id)}}"><i class="fas fa-exclamation-circle"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Botão para acionar modal -->
                        <button type="button" class="btn btn-primary btn-salvar-chamada">
                            <i class="far fa-save"></i> Salvar Chamada
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header"><strong>Realizar Justificativa de não realização de aula.</strong></div>
                <div class="card-body">
                    <div class="row">

                    <div class="col-md-12">
                            <!-- Botão para acionar modal -->
                            <a class="btn btn-danger" data-toggle="collapse" href="#collapseJustificar" role="button" aria-expanded="false" aria-controls="collapseJustificar">
                                <i class="far fa-save"></i> Realizar Justificativa
                            </a>
                        </div>

                        <div class="collapse col-md-12" id="collapseJustificar">
                            <form method="GET" action="{{ route('justificar', ['id' => $turmaProfessor->id]) }}">
                                <div class="form-group">
                                  
                                        <input type="hidden" id="data_justificativa" name="data_justificativa" value="{{ old('data', $data ?? '') }}">
                                        <label for="justificativa" class="col-form-label text-md-right">{{ __('* Justificativa') }}</label>
                                        <textarea id="justificativa" class="form-control @error('justificativa') is-invalid @enderror" name="justificativa" required maxlength="1000" rows="3"></textarea>

                                        @error('justificativa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-laptop-code"></i> Salvar Justificativa</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

    <!-- Modal -->
    <div class="modal fade" id="modal-salvar" tabindex="-1" role="dialog" aria-labelledby="salvarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salvarModalLabel">Salvar Chamada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="pergunta-salvar-chamada" class="">
                        <h4><i class="fas fa-check-double"></i> Confirmar e Salvar Chamada?</h4>
                    </div>
                    <div id="msg-chamada-nao-realizada" class="">
                        <h4><i class="fas fa-exclamation-triangle text-danger"></i> Não foi registrado nenhuma chamada!</h4>
                    </div>
                    <div id="error-registro" class="">
                        <h4><i class="fas fa-exclamation-triangle text-danger"></i> Não foi possível registrar a chamada de aula!</h4>
                    </div>
                    <div id="animacao-salvando-chamado" class="d-none">
                        <h4><i class="fas fa-spinner fa-pulse"></i> Salvando ...</h4>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-confirmar-e-salvar-chamada"> <i class="far fa-save"></i> Salvar Chamada</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Excluir -->
<div class="modal fade" id="ModalExcluir" tabindex="-1" role="dialog" aria-labelledby="TituloModalExcluir" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalExcluir"><i class="fas fa-exclamation-circle"></i> Excluir!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja Excluir o Cadastro?</p>
            </div>
            <div class="modal-footer">
                <a id="url-modal-excluir" href="#" class="btn btn-danger"> <i class="far fa-trash-alt"></i> Confirmar e Excluir</a>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
    @endsection

    @section('javascript')
    <script type="text/javascript">
        var presentes = [];
        var faltosos = [];
        var removerPresentes = [];
        var removerFaltosos = [];
        var data = "{{ $data }}";
        var id_turma = "{{ $turmaProfessor->turma_id }}";

        $(document).ready(function($) {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
               // endDate: '{{__(date("d/m/Y"))}}',
                todayBtn: 'linked',
                todayHighlight: true,
            });

            $('.btn-chamada').on('click', function() {
                event.preventDefault();

                var id_btn = $(this).attr('id-btn');
                var id_aluno = $(this).attr('id-aluno');

                if ($(this).hasClass("btn-p")) {
                    console.log("btn-p");
                    if($(this).hasClass("btn-outline-success")){
                        $(this).removeClass("btn-outline-success").addClass("btn-success");
                    
                        $('.btn-f-' + id_btn).removeClass("btn-danger").addClass("btn-outline-danger");

                        if (presentes.indexOf(id_aluno) < 0) {
                            presentes.push(id_aluno);
                        }

                        if (faltosos.indexOf(id_aluno) >= 0) {
                            faltosos.splice(faltosos.indexOf(id_aluno), 1);
                        }         

                        if (removerPresentes.indexOf(id_aluno) >= 0) {
                            removerPresentes.splice(removerPresentes.indexOf(id_aluno), 1);
                        }           
                    }else if($(this).hasClass("btn-success")){
                        $(this).removeClass("btn-success").addClass("btn-outline-success");
                    
                        if (presentes.indexOf(id_aluno) >= 0) {
                            presentes.splice(presentes.indexOf(id_aluno), 1);
                        } 

                        if (removerPresentes.indexOf(id_aluno) < 0) {
                            removerPresentes.push(id_aluno);
                        }
                    }
                    console.log(presentes);
                    console.log(faltosos);
                    console.log(removerPresentes);
                    console.log(removerFaltosos);                    
                }

                if ($(this).hasClass("btn-f")) {                   

                    if($(this).hasClass("btn-outline-danger")){
                        $(this).removeClass("btn-outline-danger").addClass("btn-danger");
                        $('.btn-p-' + id_btn).removeClass("btn-success").addClass("btn-outline-success");

                        if (faltosos.indexOf(id_aluno) < 0) {
                            faltosos.push(id_aluno);
                        }

                        if (presentes.indexOf(id_aluno) >= 0) {
                            presentes.splice(presentes.indexOf(id_aluno), 1);
                        }

                        if (removerFaltosos.indexOf(id_aluno) >= 0) {
                            removerFaltosos.splice(removerFaltosos.indexOf(id_aluno), 1);
                        }
                    }else if($(this).hasClass("btn-danger")){
                        $(this).removeClass("btn-danger").addClass("btn-outline-danger");
                    
                        if (faltosos.indexOf(id_aluno) >= 0) {
                            faltosos.splice(faltosos.indexOf(id_aluno), 1);
                        }

                        if (removerFaltosos.indexOf(id_aluno) < 0) {
                            removerFaltosos.push(id_aluno);
                        }                         
                    }
                    console.log(presentes);
                    console.log(faltosos);
                    console.log(removerPresentes);
                    console.log(removerFaltosos);
                }
            });

            $('.btn-salvar-chamada').on('click', function() {
                $('#modal-salvar').modal('show');
                if (presentes.length <= 0 && faltosos.length <= 0 && removerPresentes.length <= 0 && removerFaltosos.length <= 0) {
                    $('#pergunta-salvar-chamada').addClass("d-none");
                    $('#msg-chamada-nao-realizada').removeClass("d-none");
                    $('#error-registro').addClass("d-none");
                    $('#animacao-salvando-chamado').addClass("d-none");
                    $('.btn-confirmar-e-salvar-chamada').attr("disabled", true);
                } else {
                    $('#animacao-salvando-chamado').addClass("d-none");
                    $('#msg-chamada-nao-realizada').addClass("d-none");
                    $('#pergunta-salvar-chamada').removeClass("d-none");
                    $('#error-registro').addClass("d-none");
                    $('.btn-confirmar-e-salvar-chamada').attr("disabled", false);
                }
            });

            $('.btn-confirmar-e-salvar-chamada').on('click', function() {
                $('#pergunta-salvar-chamada').addClass("d-none");
                $('#msg-chamada-nao-realizada').addClass("d-none");
                $('#error-registro').addClass("d-none");
                $('#animacao-salvando-chamado').removeClass("d-none");
                $('.btn-confirmar-e-salvar-chamada').attr("disabled", true);

                $.get("{{ route('presenca') }}", {
                        data: data,
                        id_turma: id_turma,
                        presentes: presentes,
                        remover_presentes: removerPresentes,
                        faltosos: faltosos,
                        remover_faltosos: removerFaltosos,
                        id_usuario: "{{ Auth::user()->id }}",
                    })
                    .done(function(data) {
                        $('#animacao-salvando-chamado').addClass("d-none");
                        $('#msg-chamada-nao-realizada').addClass("d-none");
                        $('#pergunta-salvar-chamada').removeClass("d-none");
                        $('.btn-confirmar-e-salvar-chamada').attr("disabled", false);
                        $('#modal-salvar').modal('hide');
                        console.log(data);
                    })
                    .fail(function(data) {
                        $('#animacao-salvando-chamado').addClass("d-none");
                        $('#msg-chamada-nao-realizada').addClass("d-none");
                        $('#pergunta-salvar-chamada').addClass("d-none");
                        $('#error-registro').removeClass("d-none");
                        $('.btn-confirmar-e-salvar-chamada').attr("disabled", true);
                        console.log(data);
                    });

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function($) {
            $('.summernote').summernote({
                tabsize: 2,
                height: 100,
                lang: 'pt-BR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

<script type="text/javascript">
    $('.btn-excluir').on('click', function() {
        var id = $(this).attr('id-justificativa');
        var idturma = $(this).attr('id-turma');
        $('#url-modal-excluir').attr('href', '/chamadas/excluirjustificativa/' + id + "?idturma=" + idturma );
        $('#ModalExcluir').modal('show');
    });
</script>
    @endsection