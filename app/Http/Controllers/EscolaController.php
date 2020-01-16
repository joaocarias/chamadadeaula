<?php

namespace App\Http\Controllers;

use App\Endereco;
use App\Escola;
use Illuminate\Http\Request;
use App\LogSistema;
use Illuminate\Support\Facades\Auth;

class EscolaController extends Controller
{    
    public function index()
    {
        $escola = Escola::First();
        if(isset($escola)){
            $endereco = Endereco::Find($escola->endereco_id);
            return view('escola.index', ['escola' => $escola, 'endereco' => $endereco]);
        }
        return view('escola.index', ['escola' => $escola]); 
    }

    public function edit($id)
    {
        $escola = Escola::find($id);
        if (isset($escola)) {            
            $endereco = Endereco::Find($escola->endereco_id);            
        } 

        return view('escola.edit', ['escola' => $escola, 'endereco' => $endereco]);
    }

    public function update(Request $request, $id)
    {
        $regras = [
            'escola' => 'required|min:3|max:254',
            'prefeitura' => 'required|min:3|max:254',
            'secretaria' => 'required|min:3|max:254',
            
            'logradouro' => 'required|min:3|max:254',
            'cidade' => 'required|min:3|max:254',
            'uf' => 'required',
        ];
        
        $messagens = [
            'required' => 'Campo Obrigatório!',
            'escola.required' => 'Campo Obrigatório!',
            'escola.min' => 'É necessário no mínimo 3 caracteres!',
            'prefeitura.required' => 'Campo Obrigatório!',
            'prefeitura.min' => 'É necessário no mínimo 3 caracteres!',
            'secretaria.required' => 'Campo Obrigatório!',
            'secretaria.min' => 'É necessário no mínimo 3 caracteres!',
            
            'logradouro.required' => 'Campo Obrigatório!',
            'logradouro.min' => 'É necessário no mínimo 3 caracteres!',
            'cidade.required' => 'Campo Obrigatório!',
            'cidade.min' => 'É necessário no mínimo 3 caracteres!',
            'uf.required' => 'Campo Obrigatório!',
        ];
        
        $request->validate($regras, $messagens);

        $escola = Escola::find($id);
        if (isset($escola)) {            
            $stringLog = "";
            
            if($escola->escola != $request->input('escola')){
                $stringLog = $stringLog . " - escola: " . $escola->escola;
                $escola->escola = $request->input('escola');                
            }
            
            if($escola->prefeitura != $request->input('prefeitura')){                
                $stringLog = $stringLog . " - prefeitura: " . $escola->prefeitura;
                $escola->prefeitura = $request->input('prefeitura');
            }

            if($escola->secretaria != $request->input('secretaria')){                
                $stringLog = $stringLog . " - secretaria: " . $escola->secretaria;
                $escola->secretaria = $request->input('secretaria');
            }
                       
            if($escola->email != $request->input('email')){
                $stringLog = $stringLog . " - email: " . $escola->email;
                $escola->email = $request->input('email');
            }

            if($escola->telefone != $request->input('telefone')){
                $stringLog = $stringLog . " - telefone: " . $escola->telefone;
                $escola->telefone = $request->input('telefone');
            }
                       
            $escola->save();
            
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "escolas";
                $log->tabela_id = $escola->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }

            $endereco = Endereco::Find($escola->endereco_id);
            if (isset($endereco)) {                
                $stringLog = "";

                if($endereco->cep != $request->input('cep')){
                    $stringLog = $stringLog . " - cep: " . $endereco->cep;
                    $endereco->cep = $request->input('cep');
                }

                if($endereco->logradouro != $request->input('logradouro')){
                    $stringLog = $stringLog . " - logradouro: " . $endereco->logradouro;
                    $endereco->logradouro = $request->input('logradouro');
                }

                if($endereco->numero != $request->input('numero')){
                    $stringLog = $stringLog . " - numero: " . $endereco->numero;
                    $endereco->numero = $request->input('numero');
                }

                if($endereco->bairro != $request->input('bairro')){
                    $stringLog = $stringLog . " - bairro: " . $endereco->bairro;
                    $endereco->bairro = $request->input('bairro');
                }

                if($endereco->complemento != $request->input('complemento')){
                    $stringLog = $stringLog . " - complemento: " . $endereco->complemento;
                    $endereco->complemento = $request->input('complemento');
                }

                if($endereco->cidade != $request->input('cidade')){
                    $stringLog = $stringLog . " - cidade: " . $endereco->cidade;
                    $endereco->cidade = $request->input('cidade');
                }

                if($endereco->uf != $request->input('uf')){
                    $stringLog = $stringLog . " - uf: " . $endereco->uf;
                    $endereco->uf = $request->input('uf');
                }

                $endereco->save();
                
                if($stringLog != ""){
                    $log = new LogSistema();
                    $log->tabela = "enderecos";
                    $log->tabela_id = $endereco->id;
                    $log->acao = "EDICAO";
                    $log->descricao = $stringLog;
                    $log->usuario_id = Auth::user()->id;
                    $log->save();
                }

                return view('escola.index', ['escola' => $escola, 'endereco' => $endereco]);
            }
        }
    }
}
