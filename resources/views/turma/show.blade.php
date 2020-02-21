@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Turma</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('turmas') }}">Turmas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
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
        </div>
    </div>

    @if(isset($turma) && ($turma->id > 0) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Detalhes') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Nome: <strong>{{ __($turma->nome)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            CPF: <strong>{{ __($turma->ano)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            Tipo: <strong>@if(isset($turma->turno_id))
                                {{ __($turma->turno->nome)  }}
                                @else
                                {{ __("Não Informado!")  }}
                                @endif
                            </strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('editar_turma', ['id' => $turma->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                            <a href="#" class="btn btn-danger btn-sm btn-excluir" id-turma="{{ $turma->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Professores') }}</div>

                <div class="card-body">
                    <div class="row">
                        @if(count($turmaProfessor) > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Professor</th>
                                    <th scope="col"></th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach ($turmaProfessor as $item)
                                <tr>
                                    <td scope="row">{{ __($item->professor_id) }}</td>
                                    <td>{{ __(isset($item->professor->nome) ? $item->professor->nome : '') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('removerturmaprofessor', [$item->id]) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> &nbsp; Remover</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="col-md-12">
                            <p>Nenhum Professor Cadastrado para a Turma!</p>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="btn btn-dark btn-sm btn-inserir-professor"> <i class="far fa-edit"></i> Inserir Professor </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Alunos') }}</div>

                <div class="card-body">
                    <div class="row">
                        @if(count($turmaAluno) > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Aluno</th>
                                    <th scope="col"></th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach ($turmaAluno as $item)
                                <tr>
                                    <td scope="row">{{ __($item->aluno_id) }}</td>
                                    <td>{{ __((isset($item->aluno->nome)) ? $item->aluno->nome : '' ) }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('removerturmaaluno', [$item->id]) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> &nbsp; Remover</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="col-md-12">
                            <p>Nenhum Aluno Cadastrado na Turma!</p>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="btn btn-dark btn-sm btn-inserir-aluno"> <i class="far fa-edit"></i> Inserir Aluno </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

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

<!-- Modal Associar Professor -->
<div class="modal fade" id="ModalAssociarProfessor" tabindex="-1" role="dialog" aria-labelledby="TituloModalAssociarProfessor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalAssociarProfessor"><i class="fas fa-exclamation-circle"></i> Associar Professor!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('associarturmaprofessor') }}" class="form-associa-professor">
                    @csrf

                    <input type="hidden" name="turma_id_associa_professor" id="turma_id_associa_professor" value="{{ __($turma->id) }}">
                    <select id="professor_id_associa_professor" type="text" class="form-control @error('professor_id_associa_professor') is-invalid @enderror" name="professor_id_associa_professor" autocomplete="professor_id_associa_professor" required>
                        <option selected disabled>-- Selecione --</option>

                        @foreach($professores as $professor)
                        <option value="{{ __($professor->id) }}">{{ __($professor->nome) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary url-modal-submit-form"> <i class="far fa-trash-alt"></i> Associar Professor</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Associar Aluno -->
<div class="modal fade" id="ModalAssociarAluno" tabindex="-1" role="dialog" aria-labelledby="TituloModalAssociarAluno" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalAssociarAluno"><i class="fas fa-exclamation-circle"></i> Associar Aluno!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('associarturmaaluno') }}" class="form-associa-aluno">
                    @csrf

                    <input type="hidden" name="turma_id_associa_aluno" id="turma_id_associa_aluno" value="{{ __($turma->id) }}">
                    <select id="aluno_id_associa_aluno" type="text" class="select2 form-control @error('aluno_id_associa_aluno') is-invalid @enderror" name="aluno_id_associa_aluno" autocomplete="aluno_id_associa_aluno" required>
                        <option selected disabled>-- Selecione --</option>

                        @foreach($alunos as $aluno)
                        <option value="{{ __($aluno->id) }}">{{ __($aluno->nome) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary url-modal-submit-form-aluno"> <i class="far fa-trash-alt"></i> Associar Aluno</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $('#aluno_id_associa_aluno').select2({
        dropdownParent: $('#ModalAssociarAluno')
    });

    $('.btn-excluir').on('click', function() {
        var id = $(this).attr('id-turma');
        $('#url-modal-excluir').attr('href', '/turmas/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });

    $('.btn-inserir-professor').on('click', function() {
        var id = $(this).attr('id-turma');
        $('#ModalAssociarProfessor').modal('show');
    });

    $('.url-modal-submit-form').on('click', function() {
        $('.form-associa-professor').submit();
    });

    $('.btn-inserir-aluno').on('click', function() {
        var id = $(this).attr('id-turma');
        $('#ModalAssociarAluno').modal('show');
    });

    $('.url-modal-submit-form-aluno').on('click', function() {
        $('.form-associa-aluno').submit();
    });
</script>
@endsection