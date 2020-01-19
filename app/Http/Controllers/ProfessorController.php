<?php

namespace App\Http\Controllers;

use App\LogSistema;
use App\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{    
    public function index()
    {
        $list = Professor::orderBy('nome','ASC')->get();
        return view('professor.index', ['professores' => $list]); 
    }
    
    public function create()
    {
        return view('professor.create', ['professor' => null, 'user' => null]);
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
        $obj = new Professor();
        $obj->nome = $request->input('nome');        
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();
        
        return redirect()->route('professores')->withStatus(__('Cadastro Realizado com Sucesso!')); 
    }

    public function show($id)
    {
        $obj = Professor::find($id);
        return view('professor.show', ['professor' => $obj]);
    }
    
    public function edit($id)
    {
        $obj = Professor::find($id);
        return view('professor.edit', ['professor' => $obj]);
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
       
        $request->validate($regras, $messagens);

        $obj = Professor::find($id);
        if (isset($obj)) {
            $stringLog = "";
        
            if($obj->nome != $request->input('nome')){                
                $stringLog = $stringLog . " - nome: " . $obj->nome;
                $obj->nome = $request->input('nome');
            }
                        
            $obj->save();
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "professors";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }
            return redirect()->route('professores')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
       
        return redirect()->route('professores')->withStatus(__('Cadastro não Atualizado!'));
    }
   
    public function destroy($id)
    {
        $obj = Professor::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "professors";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            return redirect()->route('professores')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }

        return redirect()->route('professores')->withStatus(__('Cadastro Não Excluído!'));
    }
}
