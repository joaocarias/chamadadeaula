<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\Profissional;
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

        $profissional = Profissional::where('user_id', Auth::user()->id)->first();
        $turmas = null;
        if (isset($profissional)) {
            $turmas = TurmaProfessor::join('turmas', 'turma_professors.turma_id', '=', 'turmas.id')
                                    ->where('professor_id', $profissional->id)
                                    ->orderby('turmas.nome', 'ASC')
                                    ->get();
        }

        return view('home', ['alunos' => $alunos, 'turmas' => $turmas]);
    }
}
