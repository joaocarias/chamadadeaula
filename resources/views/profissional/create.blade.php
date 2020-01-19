@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Profissional</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profissionais') }}">Profissionais</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <form method="POST" action="{{ route('cadastrar_profissional') }}">
                @csrf

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Cadastro') }}</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="nome" class="col-form-label text-md-right">{{ __('* Nome') }}</label>
                                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $profissional->nome ?? '') }}" autocomplete="nome" required maxlength="255">

                                        @error('nome')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cpf" class="col-form-label text-md-right">{{ __('* CPF') }}</label>
                                        <input id="cpf" type="text" class="mask_cpf form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf', $profissional->nome ?? '') }}" autocomplete="cpf" required maxlength="14">

                                        @error('cpf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="tipo_profissional_id" class="col-form-label">{{ __('* Tipo Profissional') }}</label>

                                        <select id="tipo_profissional_id" type="text" class="form-control @error('tipo_profissional_id') is-invalid @enderror" name="tipo_profissional_id" autocomplete="tipo_profissional_id" required>
                                            <option selected disabled>-- Selecione --</option>

                                            @foreach($tiposProfissionais as $tipo)
                                                <option value="{{ __($tipo->id) }}" @if ( old('tipo_profissional_id', $profissional->tipo_profissional_id  ?? '' ) == $tipo->id ) {{ 'selected' }} @endif>{{ __($tipo->nome) }}</option>
                                            @endforeach

                                        </select>

                                        @error('genero')
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

                        <a href="{{ route('profissionais') }}" class="btn btn-warning">
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
        $('.mask_cpf').mask('000.000.000-00');
    });
</script>
@endsection