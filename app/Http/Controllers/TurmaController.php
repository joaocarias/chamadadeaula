<?php

namespace App\Http\Controllers;

use App\LogSistema;
use App\Turma;
use App\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::OrderBy('nome', 'ASC')->get();
        return view('turma.index', ['turmas' => $turmas]); 
    }

    public function create()
    {
        $turnos = Turno::all();
        return view('turma.create', ['turma' => null, 'turnos' => $turnos]);
    }

    public function store(Request $request)
    {
        $this->validacao($request);

        $obj = new Turma();
        $obj->nome = $request->input('nome');
        $obj->ano = $request->input('ano');   
        $obj->turno_id = $request->input('turno_id');        
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();

        return redirect()->route('turmas')->withStatus(__('Cadastro Realizado com Sucesso!'));
    }

    public function show($id)
    {
        $turma = turma::find($id);
        return view('turma.show', ['turma' => $turma]);
    }

    public function edit($id)
    {
        $obj = Turma::find($id);
        $turnos = Turno::all();
        
        return view('turma.edit', ['turma' => $obj, 'turnos' => $turnos]);
    }

    public function update(Request $request, $id)
    {
        $this->validacao($request);

        $obj = Turma::find($id);
        if (isset($obj)) {
            $stringLog = "";
        
            if($obj->nome != $request->input('nome')){                
                $stringLog = $stringLog . " - nome: " . $obj->nome;
                $obj->nome = $request->input('nome');
            }

            if($obj->ano != $request->input('ano')){                
                $stringLog = $stringLog . " - ano: " . $obj->ano;
                $obj->ano = $request->input('ano');
            }

            if($obj->turno_id != $request->input('turno_id')){                
                $stringLog = $stringLog . " - turno_id: " . $obj->turno_id;
                $obj->turno_id = $request->input('turno_id');
            }
                        
            $obj->save();
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "turmas";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }
            return redirect()->route('turmas')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
       
        return redirect()->route('turmas')->withStatus(__('Cadastro não Atualizado!'));   
    }

    public function destroy($id)
    {
        $obj = Turma::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "turmas";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            return redirect()->route('turmas')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
        return redirect()->route('turmas')->withStatus(__('Cadastro Não Excluído!'));
    }

    private function validacao(Request $request){
        $regras = [
            'nome' => 'required|min:3|max:254',
            'ano' => 'required|min:4|max:10',
            'turno_id' => 'required',
        ];

        $messagens = [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
            'ano.required' => 'Campo Obrigatório!',
            'ano.min' => 'É necessário no mínimo 4 caracteres!',
            'turno_id.required' => 'Campo Obrigatório!',          
        ];
       
        $request->validate($regras, $messagens);
    }
}
