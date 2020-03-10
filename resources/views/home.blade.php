<?php
$permissoes = array();
if (isset(Auth::user()->regras)) {
    foreach (Auth::user()->regras as $regra) {
        array_push($permissoes, $regra->nome);
    }
}
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
            <div class="card">
                <div class="card-header">Alerta</div>
                <div class="card-body">

                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>

                </div>
            </div>
            @endif
        </div>
    </div>

    @if(isset(Auth::user()->profissional->tipoProfissional->id) && Auth::user()->profissional->tipoProfissional->id == 1)
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Turmas') }}</div>
                <div class="card-body">
                    @if(isset($turmas) && count($turmas) > 0)

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>                                                        
                                <th scope="col">Turma</th>                               
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($turmas as $item)
                            <tr>
                                <td scope="row">{{ __($item->turma_id) }}</td>                                                              
                                <td>{{ __($item->turma->nome) }}</td>                                
                                <td class="text-right">
                                    <a href="{{ route('registro_chamada', [$item->id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="fas fa-book-reader"></i> &nbsp; Chamada</a>
                                    <a href="{{ route('imprimir_registro_chamada', [$item->id]) }}" class="btn btn-dark btn-sm"><i class="fas fa-print"></i> &nbsp; Imprimir</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                        <p>Não foi possível encontrar turma cadastrada!</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @endif

    @if(isset($alunos) && !is_null($alunos) && count($alunos) > 0 && in_array("ADMINISTRADOR", $permissoes))
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Últimos Alunos Cadastrados') }}</div>
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
                                    <a href="{{ route('exibir_aluno', [$item->id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection