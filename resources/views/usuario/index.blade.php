<?php

use Illuminate\Support\Facades\Auth;

$title = "Usuários";
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
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
                <div class="card-header">{{ __($title) }}</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>       
                                <th scope="col">#</th>                                                  
                                <th scope="col">Nome</th> 
                                <th scope="col">UserName</th>
                                <th scope="col">Tipo Profissional</th>
                                <th scope="col">Permissões</th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $item)
                            <tr>                           
                                <td scope="row">{{ __($item->id) }}</td>                                                                   
                                <td>{{ __($item->name) }}</td>                                
                                <td>{{ __($item->username) }}</td>   
                                <td>{{ __(isset($item->profissional) && isset($item->profissional->tipoProfissional) ? $item->profissional->tipoProfissional->nome : '' ) }}                            
                                <td>
                                    <?php
                                        foreach($item->regras as $regra){
                                            echo $regra->nome;
                                        }
                                    ?>
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

