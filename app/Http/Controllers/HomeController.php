<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\PlanejamentoSemanal;
use App\Profissional;
use App\Relato;
use App\TurmaProfessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index()
    {
        $alunos = Aluno::orderBy('created_at', 'desc')->take(5)->get();
        $relatorios = null; 

        $profissional = Profissional::where('user_id', Auth::user()->id)->first();
        $turmas = null;
        if (isset($profissional)) {
            $turmas = TurmaProfessor::join('turmas', 'turma_professors.turma_id', '=', 'turmas.id')
                                    ->where('professor_id', $profissional->id)
                                    ->where('turmas.deleted_at',null)
                                    ->orderby('turmas.nome', 'ASC')
                                    ->get();
        }

        $permissoes = Array();        
        if(isset(Auth::user()->regras)){
            foreach(Auth::user()->regras as $regra){
                array_push($permissoes, $regra->nome);
            }        
        }

        if(in_array("ADMINISTRADOR", $permissoes)){
            $planejamentos = PlanejamentoSemanal::orderBy('created_at', 'DESC')->take(5)->get();
            $relatorios = Relato::orderBy('created_at', 'DESC')->take(5)->get();
        }else if (isset($profissional)){            
            $planejamentos = (isset($profissional)) ? PlanejamentoSemanal::where('professor_id', $profissional->id)
                ->orderBy('created_at', 'DESC')->take(5)->get()
                : null;

            $relatorios = Relato::where('professor_id', $profissional->id)->orderBy('created_at', 'DESC')->take(5)->get();
        }else{
            $planejamentos = null;
        }

        return view('home', ['alunos' => $alunos, 'turmas' => $turmas, 'planejamentos' => $planejamentos
                , 'relatorios' => $relatorios 
            ]);
    }
}
