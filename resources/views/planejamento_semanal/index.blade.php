<?php
    use App\Enum\Trimestres;
    
    $title = "Planejamento Semanal";

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
                </div>
            </div>
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
                                <th scope="col">#</th>  
                                <th scope="col">Ano</th> 
                                <th scope="col">Trimestre</th>
                                <th scope="col">Tema</th>    
                                <th scope="col">turma</th> 
                                <th scope="col">Período/Semana</th>                              
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($planejamentos as $item)
                            <tr>                                                              
                                <td scope="row">{{ __($item->id) }}</td>   
                                <td>{{ __($item->ano) }}</td>                
                                <td>{{ __(Trimestres::descricao($item->trimestre)) }}</td>                
                                <td>{{ __($item->tema_do_projeto) }}</td>    
                                <td>{{ __($item->turma->nome) }}</td>   
                                <td>{{ __($item->periodo_semanal) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('exibir_planejamento_semanal', [$item->id]) }}" class="btn btn-dark btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
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