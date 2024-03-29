@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Alunos</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">                    
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Alunos</li>
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
                    <a href="{{ route('novo_aluno') }}" class="btn btn-primary">
                    <i class="far fa-file-alt"></i> &nbsp;
                        Cadastrar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">Filtrar Nome</div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <form method="GET" class="form-inline" action="{{ route('alunos') }}">
                        <div class="form-group mx-sm-3 mb-2">
                            <div class="input-group mb-2">
                                
                                <label for="nome" class="col-form-label text-md-right">{{ __('Nome do Aluno: ') }}</label>
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $filtro['nome'] ?? '') }}" autocomplete="nome" required maxlength="255">
                                
                            </div>
                            @error('ano')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-dark mb-3">
                            <i class="fas fa-search"></i>
                            {{ __('Buscar Aluno') }}
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Alunos') }}</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>             
                                <th scope="col">#</th>                                           
                                <th scope="col">Nome</th>                               
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($alunos as $item)
                            <tr>              
                                <td scope="row">{{ __($item->id) }}</td>                                                
                                <td>{{ __($item->nome) }}</td>                                
                                <td class="text-right">
                                    <a href="{{ route('exibir_aluno', [$item->id]) }}" class="btn btn-dark btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>


@endsection