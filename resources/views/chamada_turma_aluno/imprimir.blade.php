@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Chamada</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('chamadas') }}">Chamada</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Imprimir</li>
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
                <div class="card-header">{{ __('Turma: ') }} <strong>{{ __($turma->turma->nome) }}</strong> </div>
                <div class="card-body">
                    <div class="row">
                        <div class="justify-content-center">
                            <form class="form-inline" method="GET" action="{{ route('imprimir_pdf', [ 'id' => $turma->id])  }}" target="_blank">

                            <input type="hidden" name="idturma" id="idturma" value="" />

                            <div class="form-group mx-sm-3 mb-2">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
                                        </div>
                                        
                                        <select id="mes" type="text" class="form-control @error('mes') is-invalid @enderror" name="mes" required>
                                            <option selected disabled>-- Selecione --</option>
                                            
                                            <option value="1" @if ( old('mes', $mes ?? '' ) == '1' ) {{ 'selected' }} @endif>{{ __('Janeiro') }}</option>
                                            <option value="2" @if ( old('mes', $mes ?? '' ) == '2' ) {{ 'selected' }} @endif>{{ __('Fevereiro') }}</option>
                                            <option value="3" @if ( old('mes', $mes ?? '' ) == '3' ) {{ 'selected' }} @endif>{{ __('Março') }}</option>
                                            <option value="4" @if ( old('mes', $mes ?? '' ) == '4' ) {{ 'selected' }} @endif>{{ __('Abril') }}</option>

                                            <option value="5" @if ( old('mes', $mes ?? '' ) == '5' ) {{ 'selected' }} @endif>{{ __('Maio') }}</option>
                                            <option value="6" @if ( old('mes', $mes ?? '' ) == '6' ) {{ 'selected' }} @endif>{{ __('Junho') }}</option>
                                            <option value="7" @if ( old('mes', $mes ?? '' ) == '7' ) {{ 'selected' }} @endif>{{ __('Julho') }}</option>
                                            <option value="8" @if ( old('mes', $mes ?? '' ) == '8' ) {{ 'selected' }} @endif>{{ __('Agosto') }}</option>

                                            <option value="9" @if ( old('mes', $mes ?? '' ) == '9' ) {{ 'selected' }} @endif>{{ __('Setembro') }}</option>
                                            <option value="10" @if ( old('mes', $mes ?? '' ) == '10' ) {{ 'selected' }} @endif>{{ __('Outubro') }}</option>
                                            <option value="11" @if ( old('mes', $mes ?? '' ) == '11' ) {{ 'selected' }} @endif>{{ __('Novembro') }}</option>
                                            <option value="12" @if ( old('mes', $mes ?? '' ) == '12' ) {{ 'selected' }} @endif>{{ __('Dezembro') }}</option>

                                        </select>    
                                    </div>
                                    @error('mes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mx-sm-3 mb-2">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
                                        </div>

                                        <select id="ano" type="text" class="form-control @error('ano') is-invalid @enderror" name="ano" required>
                                            <option selected disabled>-- Selecione --</option>
                                            
                                            <option value="2019" @if ( old('ano', $ano ?? '' ) == '2019' ) {{ 'selected' }} @endif>{{ __('2019') }}</option>
                                            <option value="2020" @if ( old('ano', $ano ?? '' ) == '2020' ) {{ 'selected' }} @endif>{{ __('2020') }}</option>
                                            <option value="2021" @if ( old('ano', $ano ?? '' ) == '2021' ) {{ 'selected' }} @endif>{{ __('2021') }}</option>
                                            <option value="2022" @if ( old('ano', $ano ?? '' ) == '2022' ) {{ 'selected' }} @endif>{{ __('2022') }}</option>
                                            <option value="2023" @if ( old('ano', $ano ?? '' ) == '2023' ) {{ 'selected' }} @endif>{{ __('2023') }}</option>
                                            
                                        </select>

                                    </div>
                                    @error('ano')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-print"></i> &nbsp; Imprimir</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection
