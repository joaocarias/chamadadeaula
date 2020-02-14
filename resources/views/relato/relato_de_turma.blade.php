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
                    <table class="table table-responsive table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Aluno</th>
                                <th scope="col">Relato</th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($alunos as $item)
                            <tr>
                                <td scope="row">{{ __($item->aluno->id) }}</td>
                                <td>{{ __($item->aluno->nome) }}</td>
                                <td>
                                    <P>
                                        <strong>1º Trimestre</strong>
                                        <br /> <span> Diante da aprendizagem realizada ao longo do III trimestre, Ana Alice evoluiu e permanece em contínuo processo de desenvolvimento. Ela destacou-se na capacidade de se relacionar bem com o espaço em torno e com o ambiente, sendo capaz de perceber distância e ponto de referência. Controlou e utilizou seu corpo como expressão nas atividades que envolveram música e movimento, expressando informações e aprendizagens. Expressou-se com vocabulário coerente e de maneira compreensível. Ana relacionou-se bem com os colegas, estagiárias e professora, demonstrando ser uma criança feliz.
                                            Estamos felizes por termos contribuído no desenvolvimento, crescimento e avanços significativos de Alice, respeitando assim, o tempo de aprendizagem em sua jornada escolar, que dará continuidade nas próximas etapas.
                                        </span>
                                    </P>

                                    <p>
                                        <strong>2º Trimestre</strong>
                                        <br /> <span> Diante da aprendizagem realizada ao longo do III trimestre, Ana Alice evoluiu e permanece em contínuo processo de desenvolvimento. Ela destacou-se na capacidade de se relacionar bem com o espaço em torno e com o ambiente, sendo capaz de perceber distância e ponto de referência. Controlou e utilizou seu corpo como expressão nas atividades que envolveram música e movimento, expressando informações e aprendizagens. Expressou-se com vocabulário coerente e de maneira compreensível. Ana relacionou-se bem com os colegas, estagiárias e professora, demonstrando ser uma criança feliz.
                                            Estamos felizes por termos contribuído no desenvolvimento, crescimento e avanços significativos de Alice, respeitando assim, o tempo de aprendizagem em sua jornada escolar, que dará continuidade nas próximas etapas.
                                        </span>
                                    </p>

                                    <p>
                                        <strong>3º Trimestre</strong>
                                        <br /> <span> Diante da aprendizagem realizada ao longo do III trimestre, Ana Alice evoluiu e permanece em contínuo processo de desenvolvimento. Ela destacou-se na capacidade de se relacionar bem com o espaço em torno e com o ambiente, sendo capaz de perceber distância e ponto de referência. Controlou e utilizou seu corpo como expressão nas atividades que envolveram música e movimento, expressando informações e aprendizagens. Expressou-se com vocabulário coerente e de maneira compreensível. Ana relacionou-se bem com os colegas, estagiárias e professora, demonstrando ser uma criança feliz.
                                            Estamos felizes por termos contribuído no desenvolvimento, crescimento e avanços significativos de Alice, respeitando assim, o tempo de aprendizagem em sua jornada escolar, que dará continuidade nas próximas etapas.
                                        </span>
                                    </p>
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