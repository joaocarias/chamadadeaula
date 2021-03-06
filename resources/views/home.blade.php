<?php

use App\Enum\Trimestres;

$permissoes = array();
if (isset(Auth::user()->regras)) {
    foreach (Auth::user()->regras as $regra) {
        array_push($permissoes, $regra->nome);
    }
}

?>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
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
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Turma</th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($turmas as $item)
                            <tr>
                                <td scope="row">{{ __($item->turma_id) }}</td>
                                <td>{{ __($item->ano) }}</td>
                                <td>{{ __($item->turma->nome) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('registro_chamada', [$item->id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="fas fa-book-reader"></i> &nbsp; Chamada</a>
                                    <a href="{{ route('imprimir_registro_chamada', [$item->id]) }}" class="btn btn-dark btn-sm"><i class="fas fa-print"></i> &nbsp; Imprimir</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    @else
                    <p>Não foi possível encontrar turma cadastrada!</p>
                    @endif

                    <hr >
                    <p><a href="{{ route('chamadas') }}" class="btn btn-dark">
                        <i class="fas fa-book-reader"></i> &nbsp; Ir para Chamadas<a>
                    </p>                 

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
                <div class="table-responsive">
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
                    <hr >
                    <p><a href="{{ route('alunos') }}" class="btn btn-dark">
                                    <i class="fas fa-user-graduate"></i> &nbsp; Ir para Alunos<a>
                    </p>   
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(isset($planejamentos))
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Últimos Planejamentos Cadastrados') }}</div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Ano</th>
                                <th scope="col">Trimestre</th>
                                <th scope="col">Tema do Projeto</th>
                                <th scope="col">turma</th>
                                <th scope="col">Professor</th>
                                <th scope="col">Período/Semana</th>
                                <th scope="col">Conteúdo/Tema</th>
                                <th scope="col">Revisão</th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($planejamentos as $item)
                            <tr>
                                <td>@if($item->tipo_documento == 'DIGITAL')
                                        <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Planejamento Importado"></i>
                                    @else
                                        <i class="far fa-file" data-toggle="tooltip" data-placement="top" title="Planejamento Cadastrado no Sistema"> </i>
                                    @endif                                    
                                </td>
                                <td>{{ __($item->ano) }}</td>
                                <td>{{ __(Trimestres::descricao($item->trimestre)) }}</td>
                                <td>{{ __($item->tema_do_projeto) }}</td>
                                <td>{{ __(isset($item->turma) ? $item->turma->nome : '' ) }}</td>
                                <td>{{ __(isset($item->professor) ? $item->professor->nome : '' ) }}</td>
                                <td>{{ __($item->periodo_semanal) }}</td>
                                <td>{{ __($item->conteudo_tema) }}</td>
                                <td> 
                                        @if($item->revisado)
                                            <span class="badge badge-success">Revisado</span>
                                        @else
                                            <span class="badge badge-danger">Não Revisado</span>
                                        @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('exibir_planejamento_semanal', [$item->id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr >
                <p><a href="{{ route('planejamentossemanais') }}" 
                        class="btn btn-dark"
                        > <i class="far fa-calendar-alt"></i> &nbsp; Ir para Planejamentos<a></p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(isset($relatorios))
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Últimos Relatórios Cadastrados') }}</div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>                               
                                <th scope="col">Ano</th>
                                <th scope="col">Trimestre</th>
                                <th scope="col">Turma</th>
                                <th scope="col">Professor</th>
                                <th scope="col">Aluno</th>
                                <th scope="col">Revisão</th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($relatorios as $item)
                            <tr>
                                <td>{{ __($item->turma->ano) }}</td>
                                <td>{{ __(Trimestres::descricao($item->trimestre)) }}</td>                               
                                <td>{{ __(isset($item->turma) ? $item->turma->nome : '' ) }}</td>
                                <td>{{ __(isset($item->professor) ? $item->professor->nome : '' ) }}</td>                                
                                <td>{{ __(isset($item->aluno) ? $item->aluno->nome : '' ) }}
                                <td>                                      
                                        @if($item->revisado)
                                            <span class="badge badge-success">Revisado</span>
                                        @else
                                            <span class="badge badge-danger">Não Revisado</span>
                                        @endif                                 
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorios_de_turma', [$item->turma_id]) }}" class="btn btn-vermelho-cmei btn-sm"><i class="far fa-folder-open"></i> &nbsp; Detalhes</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    <hr >
                    <p><a href="{{ route('relatorios') }}" class="btn btn-dark"> 
                            <i class="far fa-file-alt"></i> &nbsp;
                             Ir para Relatórios<a></p>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection