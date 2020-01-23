<?php

namespace App\Http\Controllers;

use App\LogSistema;
use App\Profissional;
use App\Turma;
use App\TurmaProfessor;
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
        $professores = Profissional::where('tipo_profissional_id', 1)->orderBy('nome', 'asc')->get();  
        $turmaProfessor = TurmaProfessor::where('turma_id', $id)->get();
      
        return view('turma.show', ['turma' => $turma, 'professores' => $professores, 'turmaProfessor' => $turmaProfessor]);
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

    public function associarprofessor(Request $request){
        $regras = [
            'professor_id_associa_professor' => 'required',
        ];

        $messagens = [
            'required' => 'Campo Obrigatório!',
            'professor_id_associa_professor.required' => 'Campo Obrigatório!',          
        ];
       
        $request->validate($regras, $messagens);

        $obj = new TurmaProfessor();
        $obj->turma_id = $request->input('turma_id_associa_professor');
        $obj->professor_id = $request->input('professor_id_associa_professor');           
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();

        return redirect()->route('exibir_turma', ['id' =>  $obj->turma_id ])->withStatus(__('Cadastro Realizado com Sucesso!'));
    }

    public function removerprofessor($id){
        $obj = TurmaProfessor::find($id);
        
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "turmaProfessors";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            return redirect()->route('exibir_turma', ['id' =>  $obj->turma_id ])->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
        return redirect()->route('exibir_turma', ['id' =>  $obj->turma_id ])->withStatus(__('Cadastro Não Excluído!'));
    }
}
