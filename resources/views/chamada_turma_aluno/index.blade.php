@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Chamada</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">                    
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chamada</li>
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

</div>

@endsection