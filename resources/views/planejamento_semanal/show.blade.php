<?php

use App\Enum\Trimestres;

$title = "Planejamento Semanal";

$permissoes = array();
if (isset(Auth::user()->regras)) {
    foreach (Auth::user()->regras as $regra) {
        array_push($permissoes, $regra->nome);
    }
}

?>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>{{ __($title) }}</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('planejamentossemanais') }}">{{ __($title) }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
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

    @if(isset($planejamento) && ($planejamento->id > 0) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Detalhes') }}</div>

                <div class="card-body">
                    @if($planejamento->tipo_documento == 'DIGITAL')
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Informação!</strong> Esse planejamento foi cadastrado através de importação de arquivo.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-2">
                            Ano: <strong>{{ __($planejamento->ano)  }}</strong>
                        </div>

                        <div class="col-md-4">
                            Turma: <strong>{{ __(isset($planejamento->turma) ? $planejamento->turma->nome : '' )  }}</strong>
                        </div>

                        <div class="col-md-6">
                            Professor (a): <strong>{{ __($planejamento->professor->nome)  }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            Tema do Projeto: <strong>{{ __($planejamento->tema_do_projeto)  }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            Trimestre: <strong>{{ __(Trimestres::descricao($planejamento->trimestre))  }}</strong>
                        </div>

                        <div class="col-md-6">
                            Período/Semana: <strong>{{ __($planejamento->periodo_semanal)  }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            Conteúdo/Tema: <strong>{{ __($planejamento->conteudo_tema)  }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if($planejamento->revisado)
                            <div class="row">
                                <div class="col-md-6">
                                    Reviado Por: <strong>{{ __($planejamento->revisor->name)  }}</strong>
                                </div>

                                <div class="col-md-6">
                                    Data da Revisão: <strong>{{ __($planejamento->data_da_revisao)  }}</strong>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>Planejamento Semanal não Revisado.</strong>
                                @if(in_array("ADMINISTRADOR", $permissoes))
                                <a href="{{ route('editar_revisar_planejamento_semanal', ['id' => $planejamento->id ]) }}" >Clique aqui para realizar a revisão.</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if($planejamento->tipo_documento == 'DIGITAL')
                            <a href="{{ __('../../armazenamento/'.$planejamento->arquivo) }}" class="btn btn-dark btn-sm" target="_blank"><i class="fas fa-print"></i> Visualizar </a>
                            <a href="{{ route('editar_upload_planejamento_semanal', ['id' => $planejamento->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                            @else
                            <a href="{{ route('imprimir_planejamento_semanal', ['id' => $planejamento->id ]) }}" class="btn btn-dark btn-sm" target="_blank"><i class="fas fa-print"></i> Visualizar </a>
                            <a href="{{ route('editar_planejamento_semanal', ['id' => $planejamento->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                            @endif

                            <a href="#" class="btn btn-danger btn-sm btn-excluir" id-planejamento="{{ $planejamento->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

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
    $('.btn-excluir').on('click', function() {
        var id = $(this).attr('id-planejamento');
        $('#url-modal-excluir').attr('href', '/planejamentossemanais/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });
</script>
@endsection