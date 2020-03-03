@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Profissional</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profissionais') }}">Profissionais</a></li>
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

    @if(isset($profissional) && ($profissional->id > 0) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Detalhes') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Nome: <strong>{{ __($profissional->nome)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            CPF: <strong>{{ __($profissional->cpf)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            Tipo: <strong>@if(isset($profissional->tipo_profissional_id))
                                {{ __($profissional->tipoProfissional->nome)  }}
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
                            <a href="{{ route('editar_profissional', ['id' => $profissional->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                            <a href="#" class="btn btn-danger btn-sm btn-excluir" id-profissional="{{ $profissional->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Usuário') }}</div>
                <div class="card-body">
                    @if(isset($usuario) && ($usuario->id > 0) )
                    <div class="row">
                        <div class="col-md-6">
                            Nome: <strong>{{ __($usuario->name)  }}</strong>
                        </div>
                        <div class="col-md-6">
                            UserName: <strong>{{ __($usuario->username)  }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('resetar_senha_profissional', ['id' => $profissional->id ]) }}" class="btn btn-dark btn-sm"><i class="far fa-edit"></i> Resetar Senha Para Padrão </a>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-12">
                            <strong>O Profissional não possui Usuário cadastrado!</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('criar_usuario_profissional', ['id' => $profissional->id ]) }}" class="btn btn-success btn-sm"><i class="far fa-edit"></i> Criar Usuário </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(isset($usuario) && ($usuario->id > 0) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Permissões de Acesso') }}</div>
                <div class="card-body">
                    @if(!is_null($permissoes))
                    <table class="table table-hover">
                        <thead>
                            <tr>       
                                <th scope="col">#</th>                                                  
                                <th scope="col">Permissão</th>                                                                
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                        @foreach($permissoes as $p)
                            <tr>
                                <td scope="row">{{ __($p->regra_id) }}</td>
                                <td>{{ __((isset($p->nome)) ? $p->nome : '' ) }}</td>
                                    <td class="text-right">
                                    <a href="{{ route('remover_regra_user', [ 'idregra' => $p->id, 'iduser' => $p->user_id]) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> &nbsp; Remover</a>
                                    </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Usuário sem permissões cadastradas.</p>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="btn btn-dark btn-sm btn-inserir-permissao"> <i class="far fa-edit"></i> Inserir Permissão </a>                            
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

<!-- Modal Associar Permissao -->
<div class="modal fade" id="ModalInserirPermissao" tabindex="-1" role="dialog" aria-labelledby="TituloModalInserirPermissao" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalInserirPermissao"><i class="fas fa-exclamation-circle"></i> Inserir Permissão!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('inserir_regra_usuario') }}" class="form-inserir-permissao">
                    @csrf

                    <input type="hidden" name="profissional_id" id="profissional_id" value="{{ __($profissional->id) }}">
                    
                    <input type="hidden" name="user_id" id="user_id" value="{{ __($profissional->user_id) }}">
                    <select id="regra_id" type="text" class="select2 form-control @error('regra_id') is-invalid @enderror" name="regra_id" required>
                        <option selected disabled>-- Selecione --</option>

                        @foreach($regras as $regra)
                        <option value="{{ __($regra->id) }}">{{ __($regra->nome) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary url-modal-submit-form-permisao"> <i class="far fa-save"></i> Inserir Permissão</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $('.btn-excluir').on('click', function() {
        var id = $(this).attr('id-profissional');
        $('#url-modal-excluir').attr('href', '/profissionais/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });

    $('.btn-inserir-permissao').on('click', function() {
        $('#ModalInserirPermissao').modal('show');
    });

    $('.url-modal-submit-form-permisao').on('click', function() {
        $('.form-inserir-permissao').submit();
    });
</script>
@endsection