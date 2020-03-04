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
                    <li class="breadcrumb-item active" aria-current="page">Chamada</li>
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
                <div class="card-header">{{ __('Turmas') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="justify-content-center">
                            <form class="form-inline" method="GET" action="{{ route('imprimir_pdf', [ 'id' => $turma->id])  }}" target="_blank">

                                <div class="form-group mx-sm-3 mb-2">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
                                        </div>
                                        <input id="de" type="text" class="form-control @error('de') is-invalid @enderror datepicker" name="de" value="{{ old('de', $de ?? '') }}" autocomplete="off" required>
                                    </div>
                                    @error('data')
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
                                        <input id="ate" type="text" class="form-control @error('ate') is-invalid @enderror datepicker" name="ate" value="{{ old('ate', $ate ?? '') }}" autocomplete="off" required>
                                    </div>
                                    @error('data')
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

@section('javascript')
<script type="text/javascript">
    $(document).ready(function($) {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',           
            todayBtn: 'linked',
            todayHighlight: true,
        });
    });
</script>
@endsection