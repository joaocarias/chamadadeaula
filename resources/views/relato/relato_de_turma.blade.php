<?php
$title = "Relatório";
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
                    <li class="breadcrumb-item"><a href="{{ route('relatorios') }}"> {{ __($title) }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Cadastrar Relatório') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
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

            <div class="card">
                <div class="card-header"> Turma: {{ __($turma->nome) }} </div>
                <div class="card-body">
                    @if(isset($alunos))
                    <?php
                    $i = 0;
                    ?>
                    @foreach ($alunos as $item)
                    <?php
                    $i++;
                    ?>

                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <h5 class="text-center">{{ __($item->aluno->nome) }}</h5>
                            <hr />

                            <?php
                            $relatoriosDoAluno = array();
                            foreach ($relatorios as $relatorio) {
                                if ($relatorio->aluno_id == $item->aluno->id) {
                                    array_push($relatoriosDoAluno, $relatorio);
                                }
                            }
                            ?>

                            @if(isset($relatoriosDoAluno) && !is_null($relatoriosDoAluno) && !empty($relatoriosDoAluno))

                            @foreach($relatoriosDoAluno as $relatorio)
                            <div class="row">
                                <div class="col-md-2">
                                    <strong>Data do Cadastro</strong><br />
                                    {{ __($relatorio->created_at->format('d/m/Y H:i:s')) }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Trimestre</strong><br />
                                    {{ __($relatorio->trimestre) }}º Trimestre
                                </div>
                                <div class="col-md-4">
                                    <strong>Professor</strong><br />
                                    {{ __($relatorio->professor->nome) }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Status</strong><br />
                                    <span class="badge badge-danger">Não Revisado</span>
                                </div>
                                <div class="col-md-2">
                                    <strong>Relato</strong><br />
                                    <a href="{{ route('editar_relatorio',  [ 'id' => $relatorio->id ] ) }}" >
                                        Editar</a>,
                                    <a href="#" class="btn-excluir-relatorio" id-relatorio="{{  __($relatorio->id) }}">
                                        Excluir
                                    </a>
                                </div>

                                <div class="col-md-12">
                                    {!! $relatorio->relato !!}
                                    <hr />
                                </div>
                            </div>
                            @endforeach

                            @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info" role="alert">
                                        O aluno não possuí relatório cadastrado nessa turma!
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <hr />
                                    <a href="{{ route('relatorio_novo', [$turma->id, $item->aluno->id] ) }}" class="btn btn-vermelho-cmei btn-sm btn-cadastro-relatorio" id-turma="{{  __($turma->id) }}" id-aluno="{{ __($item->aluno->id) }}"><i class="far fa-file-alt"></i> Cadastrar Relatório</a>
                                </div>
                            </div>

                        </li>

                    </ul>

                    @endforeach

                    @else
                    <p>Turma sem alunos cadastrados!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card mt-3">
                <div class="card-header"> <i class="fas fa-print"></i> {{ __('Impressão de Relatórios') }} </div>
                <div class="card-body text-center">
                    <a href="{{ route('imprimir_relatorio', ['turma_id' => $turma->id, 'trimestre' => 'I' ]) }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-print"></i> Imprimir 1º Trimestre</a>
                    <a href="{{ route('imprimir_relatorio', ['turma_id' => $turma->id, 'trimestre' => 'II' ]) }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-print"></i> Imprimir 2º Trimestre</a>
                    <a href="{{ route('imprimir_relatorio', ['turma_id' => $turma->id, 'trimestre' => 'III' ]) }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-print"></i> Imprimir 3º Trimestre</a>  
                </div>
            </div>
        
        </div>
    </div>

</div>

<!-- Modal Excluir -->
<div class="modal fade" id="ModalExcluir" tabindex="-1" role="dialog" aria-labelledby="TituloModalExcluir" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalExcluir"><i class="fas fa-exclamation-circle"></i> Excluir!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja Excluir o Cadastro?</p>
            </div>
            <div class="modal-footer">
                <a id="url-modal-excluir" href="#" class="btn btn-danger"> <i class="far fa-trash-alt"></i> Confirmar e Excluir</a>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $('.btn-excluir-relatorio').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('id-relatorio');
        $('#url-modal-excluir').attr('href', '/relatorios/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });
</script>
@endsection