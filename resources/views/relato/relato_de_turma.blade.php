<?php
    $title = "Relatos";
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
                    <li class="breadcrumb-item"><a href="{{ route('relatos') }}"> {{ __($title) }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Cadastrar Relatos') }}</li>
                </ol>
            </nav>
        </div>
    </div>
       
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header"> Turma: {{ __($turmaProfessor->turma->nome) }} </div>
                <div class="card-body">
                    @if(isset($alunos))
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>                                                        
                                <th scope="col">Aluno</th>
                                <th scope="col">Relato</th>             
                                                                                       
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($alunos as $item)
                            <tr>
                                <td scope="row">{{ __($item->aluno->id) }}</td>                                                              
                                <td>{{ __($item->aluno->nome) }}</td>
                                <td>{{ __('Relato não cadastrado!') }}</td>
                                                                
                                <td class="text-right">
                                    <a href="{{ route('relatos_de_turma', [$item->id]) }}" class="btn btn-dark btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <p>Turma sem alunos cadastrados!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection