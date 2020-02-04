<?php

namespace App\Http\Controllers;

use App\PlanejamentoSemanal;
use App\Profissional;
use App\Turma;
use Illuminate\Http\Request;

class PlanejamentoSemanalController extends Controller
{
    public function index()
    {
        $list = PlanejamentoSemanal::orderBy('created_at','DESC')->get();
        
        return view('planejamento_semanal.index', ['planejamentos' => $list]); 
    }

    public function create()
    {
        $turmas = Turma::orderBy('nome', 'ASC')->get();
        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();
        return view('planejamento_semanal.create', ['planejamento' => null, 'turmas' => $turmas, 
                    'professores' => $professores ]);
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
