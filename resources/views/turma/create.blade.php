@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Turma</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('turmas') }}">Turmas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <form method="POST" action="{{ route('cadastrar_turma') }}">
                @csrf

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Cadastro') }}</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="nome" class="col-form-label text-md-right">{{ __('* Nome') }}</label>
                                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $turma->nome ?? '') }}" autocomplete="nome" required maxlength="255">

                                        @error('nome')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="ano" class="col-form-label text-md-right">{{ __('* Ano') }}</label>
                                        <input id="ano" type="text" class="mask_cpf form-control @error('ano') is-invalid @enderror" name="ano" value="{{ old('ano', $turma->ano ?? '') }}" autocomplete="ano" required maxlength="10">

                                        @error('ano')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="turno_id" class="col-form-label">{{ __('* Turno') }}</label>

                                        <select id="turno_id" type="text" class="form-control @error('turno_id') is-invalid @enderror" name="turno_id" autocomplete="turno_id" required>
                                            <option selected disabled>-- Selecione --</option>

                                            @foreach($turnos as $turno)
                                                <option value="{{ __($turno->id) }}" @if ( old('turno_id', $turma->turno_id  ?? '' ) == $turno->id ) {{ 'selected' }} @endif>{{ __($turno->nome) }}</option>
                                            @endforeach
                                        </select>

                                        @error('turno_id')
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

                        <a href="{{ route('turmas') }}" class="btn btn-warning">
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
