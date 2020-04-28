<?php
$title = "Relatório";
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
                    <li class="breadcrumb-item"><a href="{{ route('relatorios') }}"> {{ __($title) }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Editar Relatório') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <form method="POST" action="{{ route('update_relatorio', [ 'id' => $relatorio->id ]) }}">
                @csrf
                @method('put')

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3">

                            <div class="card-header"> Turma: <strong>{{ __($turma->nome) }}</strong> </div>
                            <div class="card-body">

                                <div class="form-group row">

                                    <input type="hidden" value="{{ $aluno->id }}" id="aluno_id" name="aluno_id">
                                    <input type="hidden" value="{{ $turma->id }}" id="turma_id" name="turma_id">

                                    <div class="col-md-5">
                                        <label for="aluno_nome" class="col-form-label">{{ __('* Aluno(a)') }}</label>
                                        <input id="aluno_nome" type="text" class="form-control @error('aluno_nome') is-invalid @enderror" name="aluno_nome" value="{{ old('aluno_nome', $aluno->nome ?? '') }}" autocomplete="aluno_nome" maxlength="254" disabled>

                                        @error('aluno_nome')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="professor_id" class="col-form-label">{{ __('* Professor(a)') }}</label>

                                        <select id="professor_id" type="text" class="form-control @error('professor_id') is-invalid @enderror" name="professor_id" autocomplete="professor_id" required>
                                            <option selected disabled>-- Selecione --</option>

                                            @foreach($professores as $professor)
                                            <option value="{{ __($professor->id) }}" @if ( old('professor_id', $relatorio->professor_id ?? '' ) == $professor->id ) {{ 'selected' }} @endif>{{ __($professor->nome) }}</option>
                                            @endforeach

                                        </select>

                                        @error('professor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="trimestre" class="col-form-label">{{ __('* Trimestre') }}</label>

                                        <select id="trimestre" type="text" class="form-control @error('trimestre') is-invalid @enderror" name="trimestre" autocomplete="trimestre" required>
                                            <option selected disabled>-- Selecione --</option>
                                            <option value="1" @if ( old('trimestre', $relatorio->trimestre ?? '' ) == '1' ) {{ 'selected' }} @endif>{{ __('1º - Primeiro') }}</option>
                                            <option value="2" @if ( old('trimestre', $relatorio->trimestre ?? '' ) == '2' ) {{ 'selected' }} @endif>{{ __('2º - Segundo') }}</option>
                                            <option value="3" @if ( old('trimestre', $relatorio->trimestre ?? '' ) == '3' ) {{ 'selected' }} @endif>{{ __('3º - Terceiro') }}</option>
                                        </select>

                                        @error('trimestre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">

                                        <label for="relato" class="col-form-label">{{ __('* Relatorio') }}</label>
                                        <textarea id="relato" class="summernote @error('relato') is-invalid @enderror" name="relato" required>{{ old('relato', $relatorio->relato ?? '') }}</textarea>

                                        @error('relato')
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

                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="far fa-save"></i>
                            {{ __('Salvar') }}
                        </button>

                        <a href="{{ route('relatorios_de_turma', [ $turma->id ]) }}" class="btn btn-warning">
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