@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>{{ __($turmaProfessor->turma->nome) }}</h1>
        </div>
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('chamadas') }}">Chamada</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Turma</li>
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
                <div class="card-header">{{ __('Alunos') }}</div>
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
                            @foreach ($turmaAlunos as $item)
                            <tr>                                                              
                                <td>{{ __($item->aluno_id) }}</td>
                                <td>{{ __($item->aluno->nome) }}</td>                                
                                <td class="text-right">
                                    <a href="#" class="btn btn-sm btn-circle btn-outline-success btn-chamada btn-p btn-p-{{__($item->id)}}" id-btn="{{__($item->id)}}" situacao="P" data="2020-01-27" id-turma="{{__($item->turma_id)}}" id-aluno="{{__($item->aluno_id)}}"><i class="far fa-folder-open"></i></a>
                                    <a href="#" class="btn btn-sm btn-circle btn-outline-danger btn-chamada btn-f btn-f-{{__($item->id)}}" id-btn="{{__($item->id)}}" situacao="F" data="2020-01-27" id-turma="{{__($item->turma_id)}}" id-aluno="{{__($item->aluno_id)}}"><i class="far fa-folder-open"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function($) {
        $('.btn-chamada').on('click', function(){
            var id_btn = $(this).attr('id-btn');
            event.preventDefault();
            if($(this).hasClass("btn-p")){
                $(this).removeClass( "btn-outline-success" ).addClass("btn-success");  
                $('.btn-f-'+id_btn).removeClass("btn-danger").addClass("btn-outline-danger");      
            }
            
            if($(this).hasClass("btn-f")){
                $(this).removeClass( "btn-outline-danger" ).addClass("btn-danger");        
                $('.btn-p-'+id_btn).removeClass("btn-success").addClass("btn-outline-success");
            }
            
        });
    });
</script>
@endsection