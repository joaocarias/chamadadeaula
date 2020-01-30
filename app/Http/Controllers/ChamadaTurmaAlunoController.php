<?php

namespace App\Http\Controllers;

use App\Profissional;
use App\Turma;
use App\TurmaAluno;
use App\TurmaProfessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadaTurmaAlunoController extends Controller
{
    public function index()
    {       
        $profissional = Profissional::where('user_id', Auth::user()->id)->first();
        $turmas = null;
        if(isset($profissional)){
            $turmas = TurmaProfessor::where('professor_id', $profissional->id)->get();
        }
       // $turmas = TurmaProfessor::where('professor_id', $profissional->id)->get();
        // if(isset($turmas) && $turmas->count() == 0){
        //     return view('chamada_turma_aluno.index', ['turmas', $turmas]);
        // }else if(isset($turmas) && $turmas->count() == 1 ){
        //     return view('chamada_turma_aluno.show', ['turma', $turmas]);
        // }

        
        return view('chamada_turma_aluno.index', ['turmas' => $turmas]);
    }

    public function registro(Request $request, $id){
        $data = $request->input('data');
        if(!isset($data)){
            $data = date("d/m/Y");
        }         
        $turmaProfessor = TurmaProfessor::find($id);
        $turmaAlunos = TurmaAluno::where('turma_id', $turmaProfessor->turma_id)->get();
              
        return view('chamada_turma_aluno.registro', 
            ['turmaProfessor' => $turmaProfessor, 'turmaAlunos' => $turmaAlunos
            , 'data' => $data]);
    }
    
    public function presenca(Request $request){
        $situacao = $request->input("situacao");
        $data = $request->input("data");
        $id_turma = $request->input("id_turma");
        $id_aluno = $request->input("id_aluno");
        $array = [$situacao, $data, $id_turma, $id_aluno];
        return json_encode($array);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
