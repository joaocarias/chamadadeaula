<?php

namespace App\Http\Controllers;

use App\Profissional;
use App\TurmaAluno;
use App\TurmaProfessor;
use App\ViewModel\RelatosTurmaViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelatoController extends Controller
{
    public function index()
    {
        $professor = Profissional::where('tipo_profissional_id', '1')
                    ->where('user_id', Auth::user()->id)
                    ->first();

        $turmasProfessor = null;
        if (isset($professor) && !is_null($professor)) {
            $turmasProfessor = TurmaProfessor::where('professor_id', $professor->id)->get();
        }
        
        return view('relato.index', [ 'turmasProfessor' => $turmasProfessor]); 
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function turma($id)
    {
        $turmaProfessor = TurmaProfessor::find($id);
        $alunos = null;
        if(isset($turmaProfessor)){
            $alunos = TurmaAluno::where('turma_id', $turmaProfessor->turma->id)->get();
        }
                
        return view('relato.relato_de_turma', [ 'turmaProfessor' => $turmaProfessor, 'alunos' => $alunos]);
    }

    public function show($id)
    {
       
    }

    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
