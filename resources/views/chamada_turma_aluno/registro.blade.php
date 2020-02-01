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
                <div class="card-header">Filtrar Chamada por Data</strong></div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <form class="form-inline" method="GET" action="{{ route('registro_chamada', ['id' => $turmaProfessor->id]) }}">

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
                                        // $presente = $chamadaTurmaAluno->where('aluno_id', $item->aluno_id)
                                        //                                 ->where('situacao', 'P')
                                        //                                 ->get();
                                        // if(count($presente) > 0){
                                        //     $_botaoPresenca = "btn-success";
                                        // }

                                        // $falta = $chamadaTurmaAluno->where('aluno_id', $item->aluno_id)
                                        //                                 ->where('situacao', 'F')
                                        //                                 ->get();
                                        // if(count($falta) > 0){
                                        //     $_botaoFalta = "btn-danger";;
                                        // }

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
                    <button type="button" class="btn btn-primary btn-confirmar-e-salvar-chamada"> <i class="far fa-save"></i>  Salvar Chamada</button>
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
        var data = "{{ $data }}";
        var id_turma = "{{ $turmaProfessor->turma_id }}";
             
        $(document).ready(function($) {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                endDate: '{{__(date("d/m/Y"))}}',
                todayBtn: 'linked',
                todayHighlight: true,
            });


            $('.btn-chamada').on('click', function() {
                event.preventDefault();

                var id_btn = $(this).attr('id-btn');                
                var id_aluno = $(this).attr('id-aluno');

                if ($(this).hasClass("btn-p")) {
                    $(this).removeClass("btn-outline-success").addClass("btn-success");
                    $('.btn-f-' + id_btn).removeClass("btn-danger").addClass("btn-outline-danger");

                    if (presentes.indexOf(id_aluno) < 0) {
                        presentes.push(id_aluno);
                    }

                    if (faltosos.indexOf(id_aluno) >= 0) {
                        faltosos.splice(faltosos.indexOf(id_aluno), 1);
                    }
                }

                if ($(this).hasClass("btn-f")) {
                    $(this).removeClass("btn-outline-danger").addClass("btn-danger");
                    $('.btn-p-' + id_btn).removeClass("btn-success").addClass("btn-outline-success");

                    if (faltosos.indexOf(id_aluno) < 0) {
                        faltosos.push(id_aluno);
                    }

                    if (presentes.indexOf(id_aluno) >= 0) {
                        presentes.splice(presentes.indexOf(id_aluno), 1);
                    }
                }
            });

            $('.btn-salvar-chamada').on('click', function(){
                 $('#modal-salvar').modal('show');
                 if(presentes.length <= 0 && faltosos <= 0){
                    $('#pergunta-salvar-chamada').addClass("d-none" );
                    $('#msg-chamada-nao-realizada').removeClass("d-none");
                    $('#error-registro').addClass("d-none");
                    $('#animacao-salvando-chamado').addClass("d-none");
                    $('.btn-confirmar-e-salvar-chamada').attr("disabled", true);                        
                 }else{
                    $('#animacao-salvando-chamado').addClass("d-none");
                    $('#msg-chamada-nao-realizada').addClass("d-none");
                    $('#pergunta-salvar-chamada').removeClass("d-none" );
                    $('#error-registro').addClass("d-none");
                    $('.btn-confirmar-e-salvar-chamada').attr("disabled", false);                        
                 }
            });

            $('.btn-confirmar-e-salvar-chamada').on('click', function(){
                $('#pergunta-salvar-chamada').addClass("d-none" );
                $('#msg-chamada-nao-realizada').addClass("d-none");
                $('#error-registro').addClass("d-none");
                $('#animacao-salvando-chamado').removeClass("d-none");
                $('.btn-confirmar-e-salvar-chamada').attr("disabled", true);
                
                    $.get("{{ route('presenca') }}", {
                        data: data,
                        id_turma: id_turma,
                        presentes: presentes,
                        faltosos: faltosos,
                        id_usuario: "{{ Auth::user()->id }}",
                    })
                    .done(function(data) {
                        $('#animacao-salvando-chamado').addClass("d-none");
                        $('#msg-chamada-nao-realizada').addClass("d-none");
                        $('#pergunta-salvar-chamada').removeClass("d-none" );
                        $('.btn-confirmar-e-salvar-chamada').attr("disabled", false);
                        $('#modal-salvar').modal('hide');
                        console.log(data);
                    })
                    .fail(function(data) {
                        $('#animacao-salvando-chamado').addClass("d-none");
                        $('#msg-chamada-nao-realizada').addClass("d-none");
                        $('#pergunta-salvar-chamada').addClass("d-none" );
                        $('#error-registro').removeClass("d-none");
                        $('.btn-confirmar-e-salvar-chamada').attr("disabled", true);
                        console.log(data);
                    });                    

            });
        });
    </script>
    @endsection