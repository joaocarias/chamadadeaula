<?php

namespace App\Http\Controllers;

use App\ChamadaTurmaAluno;
use App\Lib\Auxiliar;
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

        return view('chamada_turma_aluno.index', ['turmas' => $turmas]);
    }

    public function registro(Request $request, $id){
        $data = $request->input('data');
        if(!isset($data)){
            $data = date("d/m/Y");
        }         
        $turmaProfessor = TurmaProfessor::find($id);
        $turmaAlunos = TurmaAluno::where('turma_id', $turmaProfessor->turma_id)->get();
        $chamadaTurmaAluno = ChamadaTurmaAluno::where('turma_id', $turmaProfessor->turma_id)
                            ->where('data_da_aula', Auxiliar::converterDataParaUSA($data))   
                            ->get();   
      
        return view('chamada_turma_aluno.registro', 
            ['turmaProfessor' => $turmaProfessor, 'turmaAlunos' => $turmaAlunos
            , 'data' => $data, 'chamadaTurmaAluno' => $chamadaTurmaAluno ]);
    }
    
    public function store(Request $request)
    {       
        $data_da_aula = Auxiliar::converterDataParaUSA($request->input("data"));
        $turma_id = $request->input("id_turma");
        $presentes = $request->input("presentes");
        $faltosos = $request->input("faltosos");
        $usuario_cadastro = $request->input("id_usuario");

        if(isset($presentes) && !is_null($presentes)){
            foreach($presentes as $aluno_id){
                $this->registrarChamadaBD($data_da_aula, $turma_id, $aluno_id, "P", $usuario_cadastro);
            }
        }

        if(isset($faltosos) && !is_null($faltosos)){
            foreach($faltosos as $aluno_id){
                $this->registrarChamadaBD($data_da_aula, $turma_id, $aluno_id, 'F', $usuario_cadastro);
            }
        }
        
        return http_response_code(200);
    }

    private function registrarChamadaBD($data_da_aula, $turma_id, $aluno_id, $situacao, $usuario_cadastro ){
        ChamadaTurmaAluno::where("data_da_aula", $data_da_aula)
                                ->where("turma_id", $turma_id)
                                ->where("aluno_id", $aluno_id)
                                ->delete();
            
            $obj = new ChamadaTurmaAluno();
            $obj->situacao = $situacao;
            $obj->data_da_aula = $data_da_aula;
            $obj->turma_id = $turma_id;
            $obj->aluno_id = $aluno_id;
            $obj->usuario_cadastro = $usuario_cadastro;
            $obj->save();
    }
}
