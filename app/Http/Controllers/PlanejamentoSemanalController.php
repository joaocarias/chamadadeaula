<?php

namespace App\Http\Controllers;

use App\PlanejamentoSemanal;
use App\Profissional;
use App\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Plugin\PluginNotFoundException;

class PlanejamentoSemanalController extends Controller
{
    public function index()
    {
        $professor = Profissional::where('tipo_profissional_id', '1')
                                    ->where('user_id', Auth::user()->id)
                                    ->first();
        
        $list = (isset($professor)) ? PlanejamentoSemanal::where('professor_id', $professor->id)
                                            ->orderBy('created_at','DESC')->get()
                                    : null;
        
        return view('planejamento_semanal.index', ['planejamentos' => $list]); 
    }

    public function create()
    {
        $turmas = Turma::orderBy('nome', 'ASC')->get();
        $anoAtual = date("Y");
        
        $planejamento = new PlanejamentoSemanal();
        $planejamento->ano = $anoAtual;

        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();
       
        $professor = Profissional::where('user_id', Auth::user()->id)
                                    ->where('tipo_profissional_id', '1')
                                    ->first();
                                    
        if(isset($professor) && !is_null($professor) ){
            $planejamento->professor_id = $professor->id;
            
        }
    
        return view('planejamento_semanal.create', ['planejamento' => $planejamento, 'turmas' => $turmas, 
                    'professores' => $professores ]);
    }

    public function store(Request $request)
    {
        $this->validacao($request);

        $obj = new PlanejamentoSemanal();
        $obj->ano = $request->input('ano');
        $obj->turma_id = $request->input('turma_id');
        $obj->tema_do_projeto = $request->input('tema_do_projeto');
        $obj->professor_id = $request->input('professor_id');

        $obj->trimestre = $request->input('trimestre');
        $obj->periodo_semanal = $request->input('periodo_semanal');
        $obj->idade_faixa_etaria = $request->input('idade_faixa_etaria');
        
        $obj->habilidades = $request->input('habilidades');
        $obj->conteudo_tema = $request->input('conteudo_tema');
        $obj->eu_o_outro_e_o_nos = !is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0 ;
        
        $obj->corpo_gestos_e_movimentos = !is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0;
        $obj->tracos_sons_cores_e_formas = !is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0;
        $obj->escuta_fala_pensamento_e_imaginacao =  !is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0;
        
        $obj->espaco_tempo_qunatidades_relacoes_e_transformacoes = !is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0;
        $obj->metodologia = $request->input('metodologia');
        $obj->recursos_didaticos = $request->input('recursos_didaticos');
        
        $obj->como_sera_a_avaliacao = $request->input('como_sera_a_avaliacao');
        
        $obj->usuario_cadastro = Auth::user()->id;

        $obj->save();
        return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Realizado com Sucesso!'));
    
    }

    public function show($id)
    {
        $obj = PlanejamentoSemanal::find($id);
        return view('planejamento_semanal.show', ['planejamento' => $obj]);
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

    private function validacao(Request $request){
        $regras = [
            'ano' => 'required',
            'turma_id' => 'required',
            'tema_do_projeto' => 'required|min:3|max:254',
            'periodo_semanal' => 'required',
            'habilidades' => 'required|min:3',
            'conteudo_tema' => 'required|min:3',
            'metodologia' => 'required|min:3',
            'recursos_didaticos' => 'required|min:3',
           'como_sera_a_avaliacao' => 'required|min:3',
        ];

        $messagens = [
            'required' => 'Campo Obrigatório!',
            'ano.required' => 'Campo Obrigatório!',  
            'turma_id' => 'Campo Obrigatório!',
            'tema_do_projeto.required' => 'Campo Obrigatório!',
            'tema_do_projeto.min' => 'É necessário no mínimo 3 caracteres!',
            'periodo_semanal.required' => 'Campo Obrigatório!',
            'habilidades' => 'Campo Obrigatório!',
            'habilidades.min' => 'É necessário no mínimo 3 caracteres!',
            'conteudo_tema' => 'Campo Obrigatório!',
            'conteudo_tema.min' => 'É necessário no mínimo 3 caracteres!',
            'metodologia' => 'Campo Obrigatório!',
            'metodologia.min' => 'É necessário no mínimo 3 caracteres!',
            'recursos_didaticos' => 'Campo Obrigatório!',
            'recursos_didaticos.min' => 'É necessário no mínimo 3 caracteres!',
            'como_sera_a_avaliacao' => 'Campo Obrigatório!',
            'como_sera_a_avaliacao.min' => 'É necessário no mínimo 3 caracteres!',
        ];
       
        $request->validate($regras, $messagens);

       
    }
}
