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
    @endif

</div>

@endsection