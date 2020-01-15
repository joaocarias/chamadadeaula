@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Escola</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Escola</li>
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

    @if(isset($escola) && ($escola->id > 0) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Detalhes') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Escola: <strong>{{ __($escola->escola)  }}</strong>
                        </div>

                        <div class="col-md-6">
                            Prefeitura: <strong>{{ __($escola->prefeitura)  }}</strong>
                        </div>
                    </div>
                    
                    <div class="row">  
                        <div class="col-md-6">
                            Secretaria: <strong>{{ __($escola->secretaria)  }}</strong>
                        </div>
                        <div class="col-md-6">                            
                            E-Mail: <strong>{{ __($escola->email)  }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            Telefone: <strong>{{ __($escola->telefone)  }}</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    @if(isset($endereco) && ($endereco->id > 0) )

                    <div class="row">
                        <div class="col-md-12">
                            Endereço:
                            <strong>
                                {{ __($endereco->logradouro) }}
                                {{ __(', ' . $endereco->numero) }}
                                {{ __(', ' . $endereco->complemento) }}
                                {{ __(' - ' . $endereco->bairro) }}
                                {{ __(' - ' . $endereco->cidade) }}
                                {{ __(' - ' . $endereco->uf) }}
                            </strong>
                        </div>
                    </div>

                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('editar_escola', ['id' => $escola->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

</div>


@endsection