<?php

use App\Enum\Trimestres;

$title = "Planejamento Semanal";

$_anos = ['2020', '2021', '2022', '2023'];

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
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
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

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('novo_planejamento_semanal') }}" class="btn btn-primary">
                        <i class="far fa-file-alt"></i> &nbsp;
                        Cadastrar
                    </a>

                    <a href="{{ route('upload_planejamento_semanal') }}" class="btn btn-success">
                        <i class="fas fa-file-upload"></i> &nbsp;
                        Importar Arquivo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Turmas') }}</div>
                <div class="card-body">
                    @if(isset($turmas))

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Turno</th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($turmas as $item)
                            <tr>
                                <td scope="row">{{ __($item->id) }}</td>
                                <td>{{ __($item->nome) }}</td>
                                <td>{{ __($item->ano) }}</td>
                                <td>{{ __($item->turno->nome) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('planejamento_semanal_de_turma', [$item->id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                    <p>Nenhuma turma encontrada para o usuário.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form method="GET" action="{{ route('planejamentossemanais') }}">
                
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Filtro de Planejamento') }}</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="ano" class="col-form-label">{{ __('Ano') }}</label>

                                        <select id="ano" type="text" class="form-control @error('ano') is-invalid @enderror" name="ano" autocomplete="ano">
                                            <option selected disabled>-- Selecione --</option>

                                            @foreach($_anos as $_ano)
                                            <option value="{{ __($_ano) }}" @if ( old('ano', $planejamento->ano ?? '' ) == $_ano ) {{ 'selected' }} @endif>{{ __($_ano) }}</option>
                                            @endforeach

                                        </select>

                                        @error('ano')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="turma_id" class="col-form-label">{{ __('Turma') }}</label>

                                        <select id="turma_id" type="text" class="form-control @error('turma_id') is-invalid @enderror" name="turma_id" autocomplete="turma_id">
                                            <option selected disabled>-- Selecione --</option>

                                            @foreach($turmas as $turma)
                                            <option value="{{ __($turma->id) }}" @if ( old('turma_id', $planejamento->turma_id ?? '' ) == $turma->id ) {{ 'selected' }} @endif>{{ __($turma->nome) }}</option>
                                            @endforeach

                                        </select>

                                        @error('turma_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="professor_id" class="col-form-label">{{ __('Professor(a)') }}</label>

                                        <select id="professor_id" type="text" class="form-control @error('professor_id') is-invalid @enderror" name="professor_id" autocomplete="professor_id">
                                            <option selected disabled>-- Selecione --</option>

                                            @foreach($professores as $professor)
                                            <option value="{{ __($professor->id) }}" @if ( old('professor_id', $planejamento->professor_id ?? '' ) == $professor->id ) {{ 'selected' }} @endif>{{ __($professor->nome) }}</option>
                                            @endforeach

                                        </select>

                                        @error('professor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-3">
                                        <label for="trimestre" class="col-form-label">{{ __('Trimestre') }}</label>

                                        <select id="trimestre" type="text" class="form-control @error('trimestre') is-invalid @enderror" name="trimestre" autocomplete="trimestre">
                                            <option selected disabled>-- Selecione --</option>
                                            <option value="1" @if ( old('trimestre', $planejamento->trimestre ?? '' ) == '1' ) {{ 'selected' }} @endif>{{ __('1º - Primeiro') }}</option>
                                            <option value="2" @if ( old('trimestre', $planejamento->trimestre ?? '' ) == '2' ) {{ 'selected' }} @endif>{{ __('2º - Segundo') }}</option>
                                            <option value="3" @if ( old('trimestre', $planejamento->trimestre ?? '' ) == '3' ) {{ 'selected' }} @endif>{{ __('3º - Terceiro') }}</option>
                                        </select>

                                        @error('trimestre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="idade_faixa_etaria" class="col-form-label">{{ __('Idade/Faixa Etária') }}</label>

                                        <select id="idade_faixa_etaria" type="text" class="form-control @error('idade_faixa_etaria') is-invalid @enderror" name="idade_faixa_etaria" autocomplete="idade_faixa_etaria">
                                            <option selected disabled>-- Selecione --</option>
                                            <option value="1" @if ( old('idade_faixa_etaria', $planejamento->idade_faixa_etaria ?? '' ) == '1' ) {{ 'selected' }} @endif>{{ __('Bebês (de zero a um ano e seis meses)') }}</option>
                                            <option value="2" @if ( old('idade_faixa_etaria', $planejamento->idade_faixa_etaria ?? '' ) == '2' ) {{ 'selected' }} @endif>{{ __('Crianças bem pequenas (um ano e sete meses a três anos e onze meses)') }}</option>
                                        </select>

                                        @error('idade_faixa_etaria')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 d-flex ">
                                        <button type="submit" class="btn btn-primary mt-auto btn-block">
                                            <i class="fas fa-search"></i>
                                            {{ __('Filtrar') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Planejamentos') }}</div>
                <div class="card-body">
                    @if(isset($planejamentos))
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Ano</th>
                                <th scope="col">Trimestre</th>
                                <th scope="col">Tema do Projeto</th>
                                <th scope="col">Turma</th>
                                <th scope="col">Professor</th>
                                <th scope="col">Período/Semana</th>
                                <th scope="col">Conteúdo/Tema</th>
                                <td scope="col">Revisão</th>
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
                                <td>{{ __(isset($item->turma) ? $item->turma->nome : '' ) }}</td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Usuário não possui planejamentos!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>


@endsection