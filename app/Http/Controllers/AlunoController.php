<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\LogSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::orderBy('nome','ASC')->get();
        return view('aluno.index', ['alunos' => $alunos]); 
    }

    public function create()
    {
        return view('aluno.create', ['aluno' => null]);
    }
    
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|min:3|max:254',
        ];
       
        $messagens = [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
        ];
       
        $request->validate($regras, $messagens);
        $obj = new Aluno();
        $obj->nome = $request->input('nome');        
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();
        
        return redirect()->route('alunos')->withStatus(__('Cadastro Realizado com Sucesso!')); 
    }

    public function show($id)
    {
        $aluno = Aluno::find($id);
        return view('aluno.show', ['aluno' => $aluno]);
    }

    public function edit($id)
    {
        $obj = Aluno::find($id);
        return view('aluno.edit', ['aluno' => $obj]);
    }

    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|min:3|max:254',
        ];
       
        $messagens = [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
        ];
       
        $obj = Aluno::find($id);
        if (isset($obj)) {
            $stringLog = "";
        
            if($obj->nome != $request->input('nome')){                
                $stringLog = $stringLog . " - nome: " . $obj->nome;
                $obj->nome = $request->input('nome');
            }
                        
            $obj->save();
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "alunos";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }
            return redirect()->route('alunos')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
       
        return redirect()->route('alunos')->withStatus(__('Cadastro não Atualizado!'));
   
    }
  
    public function destroy($id)
    {
        $obj = Aluno::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "alunos";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            return redirect()->route('alunos')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
        return redirect()->route('alunos')->withStatus(__('Cadastro Não Excluído!'));
    }
}
