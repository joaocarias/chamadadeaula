@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Profissionais</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">                    
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profissionais</li>
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
                    <a href="{{ route('novo_profissional') }}" class="btn btn-primary">
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
                <div class="card-header">{{ __('Profissionais') }}</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>       
                                <th scope="col">#</th>                                                  
                                <th scope="col">Nome</th> 
                                <th scope="col">CPF</th>
                                <th scope="col">Tipo</th>                                
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($profissionais as $item)
                            <tr>                           
                                <td scope="row">{{ __($item->id) }}</td>                                                                   
                                <td>{{ __($item->nome) }}</td>                                
                                <td>{{ __($item->cpf) }}</td>
                                <td>{{ __($item->tipoProfissional->nome) }}</td>                                
                                <td class="text-right">
                                    <a href="{{ route('exibir_profissional', [$item->id]) }}" class="btn btn-dark btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
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

