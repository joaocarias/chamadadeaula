<?php
    $title = "Relatórios";
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
       
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Turmas') }}</div>
                <div class="card-body">
                    @if(isset($turmasProfessor))

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
                            @foreach ($turmasProfessor as $item)
                            <tr>
                                <td scope="row">{{ __($item->turma->id) }}</td>                                                              
                                <td>{{ __($item->turma->nome) }}</td>
                                <td>{{ __($item->turma->ano) }}</td>
                                <td>{{ __($item->turma->turno->nome) }}</td>                                
                                <td class="text-right">
                                    <a href="{{ route('relatorios_de_turma', [$item->turma->id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
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

</div>

@endsection