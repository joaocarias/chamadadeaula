<?php

use App\Enum\Trimestres;

$title = "Planejamento Semanal";

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
                    <li class="breadcrumb-item"><a href="{{ route('planejamentossemanais') }}"> Planejamento Semanal </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Turma') }}</li>
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
                <div class="card-header">Turma: {{ __($turma->nome) }}</div>
                <div class="card-body">
                    @if(isset($planejamentos) and count($planejamentos) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Ano</th>
                                <th scope="col">Trimestre</th>
                                <th scope="col">Tema do Projeto</th>
                                <th scope="col">Professor</th>
                                <th scope="col">Período/Semana</th>
                                <th scope="col">Conteúdo/Tema</th>
                                <th scope="col">Revisão</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($planejamentos as $item)
                            <tr>
                                <td>@if($item->tipo_documento == 'DIGITAL')
                                    <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Planejamento Importado"></i>
                                    @else
                                    <i class="far fa-file" data-toggle="tooltip" data-placement="top" title="Planejamento Cadastrado no Sistema"> </i>
                                    @endif
                                </td>
                                <td>{{ __($item->ano) }}</td>
                                <td>{{ __(Trimestres::descricao($item->trimestre)) }}</td>
                                <td>{{ __($item->tema_do_projeto) }}</td>
                                <td>{{ __(isset($item->professor) ? $item->professor->nome : '' ) }}</td>
                                <td>{{ __($item->periodo_semanal) }}</td>
                                <td>{{ __($item->conteudo_tema) }}</td>
                                <td>
                                    @if($item->revisado)
                                    <span class="badge badge-success">Revisado</span>
                                    @else
                                    <span class="badge badge-danger">Não Revisado</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('exibir_planejamento_semanal', [$item->id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
                                </td>
                                <td class="text-right">
                                @if($item->revisado)
                                    <a href="{{ route('copiar_planejamento_semanal', [$item->id]) }}" class="btn btn-dark btn-sm"><i class="far fa-copy"></i> &nbsp; Copiar</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-warning" role="alert">
                        Nenhum registro encontrado!
                    </div>  
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>


@endsection