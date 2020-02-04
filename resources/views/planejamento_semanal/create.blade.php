<?php
$title = "Planejamento Semanal";
$_anos = ['2020', '2021', '2022', '2023'];
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>{{ __($title) }}</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('planejamentossemanais') }}">{{ __($title) }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <form method="POST" action="{{ route('cadastrar_professor') }}">
                @csrf

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Cadastro') }}</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="ano" class="col-form-label">{{ __('* Ano') }}</label>

                                        <select id="ano" type="text" class="form-control @error('ano') is-invalid @enderror" name="ano" autocomplete="ano" required>
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
                                        <label for="turma_id" class="col-form-label">{{ __('* Turma') }}</label>

                                        <select id="turma_id" type="text" class="form-control @error('turma_id') is-invalid @enderror" name="turma_id" autocomplete="turma_id" required>
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
                                        <label for="professor_id" class="col-form-label">{{ __('* Professor(a)') }}</label>

                                        <select id="professor_id" type="text" class="form-control @error('professor_id') is-invalid @enderror" name="professor_id" autocomplete="professor_id" required>
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
                                    <div class="col-md-6">
                                        <label for="tema_do_projeto" class="col-form-label">{{ __('* Tema do Projeto') }}</label>
                                        <input id="tema_do_projeto" type="text" class="form-control @error('tema_do_projeto') is-invalid @enderror" name="tema_do_projeto" value="{{ old('tema_do_projeto', $planejamento->tema_do_projeto ?? '') }}" autocomplete="tema_do_projeto" required maxlength="254">

                                        @error('tema_do_projeto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="trimestre" class="col-form-label">{{ __('* Trimestre') }}</label>

                                        <select id="trimestre" type="text" class="form-control @error('trimestre') is-invalid @enderror" name="turma_id" autocomplete="turma_id" required>
                                            <option selected disabled>-- Selecione --</option>
                                            <option value="1" @if ( old('trimestre', $planejamento->trimestre ?? '' ) == '1' ) {{ 'selected' }} @endif>{{ __('1º - Primeiro') }}</option>
                                            <option value="2" @if ( old('trimestre', $planejamento->trimestre ?? '' ) == '2' ) {{ 'selected' }} @endif>{{ __('2º - Segundo') }}</option>
                                            <option value="3" @if ( old('trimestre', $planejamento->trimestre ?? '' ) == '3' ) {{ 'selected' }} @endif>{{ __('3º - Terceiro') }}</option>
                                            <option value="4" @if ( old('trimestre', $planejamento->trimestre ?? '' ) == '4' ) {{ 'selected' }} @endif>{{ __('4º - Quarto') }}</option>
                                        </select>

                                        @error('trimestre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="periodo_semana" class="col-form-label">{{ __('* Período/Semana') }}</label>
                                        <input id="periodo_semana" type="text" class="form-control @error('periodo_semana') is-invalid @enderror" name="periodo_semana" value="{{ old('periodo_semana', $planejamento->periodo_semana ?? '') }}" autocomplete="periodo_semana" required maxlength="25">

                                        @error('periodo_semana')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="idade_faixa_etaria" class="col-form-label">{{ __('* Idade/Faixa Etária') }}</label>

                                        <select id="idade_faixa_etaria" type="text" class="form-control @error('idade_faixa_etaria') is-invalid @enderror" name="idade_faixa_etaria" autocomplete="idade_faixa_etaria" required>
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
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">

                                        <label for="habilidades" class="col-form-label">{{ __('* Habilidades') }}</label>
                                        <textarea id="habilidades" class="summernote @error('habilidades') is-invalid @enderror" name="habilidades" value="{{ old('habilidades', $planejamento->habilidades ?? '') }}" autocomplete="habilidades" required></textarea>

                                        @error('habilidades')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="far fa-save"></i>
                    {{ __('Salvar') }}
                </button>

                <a href="{{ route('planejamentossemanais') }}" class="btn btn-warning">
                    <i class="far fa-times-circle"></i>
                    {{ __('Cancelar') }}
                </a>
            </div>
        </div>
        </form>
    </div>
</div>

</div>

@endsection

@section('javascript')
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
@endsection