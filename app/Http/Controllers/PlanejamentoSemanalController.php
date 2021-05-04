<?php

namespace App\Http\Controllers;

use App\LogSistema;
use App\PlanejamentoSemanal;
use App\Profissional;
use App\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Plugin\PluginNotFoundException;
use Mpdf\Mpdf;
use App\Enum\Trimestres;
use App\Lib\Auxiliar;
use App\TurmaProfessor;
use Facade\FlareClient\Http\Response;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Storage;
//ALTER TABLE planejamento_semanals
//MODIFY COLUMN trimestre INT NULL;
//ALTER TABLE planejamento_semanals
//MODIFY COLUMN periodo_semanal VARChAR(255) NULL;
class PlanejamentoSemanalController extends Controller
{
    public function index(Request $request)
    {
        $filtro_ano = $request->input('ano');
        if (!isset($filtro_ano) or is_null($filtro_ano))
            $filtro_ano = date('Y');
       
        $filtro = array(
            'ano' => $filtro_ano
        );

        $turmas = null;
        $permissoes = array();
        if (isset(Auth::user()->regras)) {
            foreach (Auth::user()->regras as $regra) {
                array_push($permissoes, $regra->nome);
            }
        }

        if (in_array("ADMINISTRADOR", $permissoes)) {
            // $list = PlanejamentoSemanal::orderBy('created_at', 'DESC')->get();
            //$list = DB::table('planejamento_semanals')
            $list = PlanejamentoSemanal::
                when($filtro_ano, function ($query, $filtro) {
                    return $query->where('ano', $filtro);
                })
                ->orderBy('created_at', 'DESC')
                ->get();

            $turmas = Turma::when($filtro_ano, function ($query, $filtro) {
                return $query->where('ano', $filtro);
            })->orderby('nome', 'asc')->get();
        } else {
            $professor = Profissional::where('tipo_profissional_id', '1')
                ->where('user_id', Auth::user()->id)
                ->first();

            $list = (isset($professor)) ?
                 PlanejamentoSemanal::when($filtro_ano, function ($query, $filtro) {
                    return $query->where('ano', $filtro);
                })
                ->where('professor_id', $professor->id)
                ->orderBy('created_at', 'DESC')
                ->get()
                : null;

            if (isset($professor) && !is_null($professor)) {
                $turmasProfessorIds = TurmaProfessor::where('professor_id', $professor->id)->select('turma_id')->distinct()->get();
                $turmas = Turma::when($filtro_ano, function ($query, $filtro) {
                        return $query->where('ano', $filtro);
                    })->whereIn('id', $turmasProfessorIds)->orderby('nome', 'asc')->get();
            }
        }

        return view(
            'planejamento_semanal.index',
            [
                'planejamentos' => $list, 'turmas' => $turmas, 'filtro' => $filtro, '_anos' => Auxiliar::obterAnos()
            ]
        );
    }

    public function create()
    {
        $turmas = Turma::orderBy('nome', 'ASC')->get();
        $anoAtual = date("Y");

        $planejamento = new PlanejamentoSemanal();
        $planejamento->ano = $anoAtual;

        $professor = Profissional::where('user_id', Auth::user()->id)
            ->where('tipo_profissional_id', '1')
            ->first();

        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();

        if (isset($professor) && !is_null($professor)) {
            $planejamento->professor_id = $professor->id;
        }

        return view('planejamento_semanal.create', [
            'planejamento' => $planejamento, 'turmas' => $turmas,
            'professores' => $professores
        ]);
    }

    public function uploadarquivo()
    {
        $turmas = Turma::orderBy('nome', 'ASC')->get();
        $anoAtual = date("Y");

        $planejamento = new PlanejamentoSemanal();
        $planejamento->ano = $anoAtual;

        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();

        $professor = Profissional::where('user_id', Auth::user()->id)
            ->where('tipo_profissional_id', '1')
            ->first();

        if (isset($professor) && !is_null($professor)) {
            $planejamento->professor_id = $professor->id;
        }

        return view('planejamento_semanal.upload_arquivo', [
            'planejamento' => $planejamento, 'turmas' => $turmas,
            'professores' => $professores
        ]);
    }

    public function store(Request $request)
    {
        //$this->validacao($request);

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
        $obj->eu_o_outro_e_o_nos = !is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0;

        $obj->corpo_gestos_e_movimentos = !is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0;
        $obj->tracos_sons_cores_e_formas = !is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0;
        $obj->escuta_fala_pensamento_e_imaginacao =  !is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0;

        $obj->espaco_tempo_qunatidades_relacoes_e_transformacoes = !is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0;
        $obj->metodologia = $request->input('metodologia');
        $obj->recursos_didaticos = $request->input('recursos_didaticos');

        $obj->como_sera_a_avaliacao = $request->input('como_sera_a_avaliacao');

        $obj->conteudo_eu_o_outro_e_o_nos = $request->input('conteudo_eu_o_outro_e_o_nos');
        $obj->conteudo_corpo_gestos_e_movimentos = $request->input('conteudo_corpo_gestos_e_movimentos');
        $obj->conteudo_tracos_sons_cores_e_formas = $request->input('conteudo_tracos_sons_cores_e_formas');
        $obj->conteudo_escuta_fala_pensamento_e_imaginacao = $request->input('conteudo_escuta_fala_pensamento_e_imaginacao');
        $obj->conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes = $request->input('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes');

        $obj->usuario_cadastro = Auth::user()->id;

        $obj->save();
        return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Realizado com Sucesso!'));
    }

    public function store_upload(Request $request)
    {
        // $regras = [
        //     'ano' => 'required',
        //     'turma_id' => 'required',
        //     'tema_do_projeto' => 'required|min:3|max:254',

        //     'arquivo' => 'required',
        // ];

        // $messagens = [
        //     'required' => 'Campo Obrigatório!',
        //     'ano.required' => 'Campo Obrigatório!',
        //     'turma_id' => 'Campo Obrigatório!',
        //     'tema_do_projeto.required' => 'Campo Obrigatório!',
        //     'tema_do_projeto.min' => 'É necessário no mínimo 3 caracteres!',

        //     'arquivo.required' => 'Campo Obrigatório',
        // ];

        // $request->validate($regras, $messagens);

        $obj = new PlanejamentoSemanal();
        $obj->ano = $request->input('ano');
        $obj->turma_id = $request->input('turma_id');
        $obj->tema_do_projeto = $request->input('tema_do_projeto');
        $obj->professor_id = $request->input('professor_id');

        $obj->trimestre = $request->input('trimestre');
        $obj->periodo_semanal = $request->input('periodo_semanal');
        $obj->idade_faixa_etaria = $request->input('idade_faixa_etaria');

        $obj->conteudo_tema = $request->input('conteudo_tema');

        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            $obj->arquivo = $request->file('arquivo')->store('planejamento_semanal');
            $name = basename($obj->arquivo);
            move_uploaded_file($request->file('arquivo'), 'armazenamento/planejamento_semanal/' . $name);
        }

        $obj->tipo_documento = 'DIGITAL';

        $obj->usuario_cadastro = Auth::user()->id;

        $obj->save();
        return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Realizado com Sucesso!'));
    }

    public function imprimir($id)
    {
        $obj = PlanejamentoSemanal::find($id);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
        ]);

        $html = '

        <html>
        <head>
        
        </head>
        <body style="font-family: serif; font-size: 11pt;">
        <table width="100%">
            <tr>
               <td width="15%" style="text-align:left"> <img src="/imgs/cmei.jfif" width="100"> </td>
               <td width="85%" style="text-align:center">
                    <strong> PREFEITURA MUNICIPAL DO NATAL
                    <br />SECRETARIA MUNICIPAL DE EDUCAÇÃO
                    <br />CMEI NOSSA SENHORA DE LOURDES </strong>               
               </td>
            </tr>
        </table>
        
        <div style="text-align:center; margin-top: 20px">
            <u>PLANEJAMENTO SEMANAL</u>
        </div>

        <div style="margin-top: 20px">
            <table width="100%">
                <tr>
                    <td width="15%">ANO: ' . $obj->ano . ' </td>
                    <td width="30%">TURMA: ';

        $nomeTurma = isset($obj->turma) ? $obj->turma->nome : ' ';

        $html = $html . $nomeTurma . ' </td>
                    <td >PROFESSOR(A): ' . $obj->professor->nome . ' </td>
                </tr>
                <tr>
                    <td colspan="3">TEMA DO PROJETO: ' . $obj->tema_do_projeto . '</td>
                </tr>                
            </table>
            
            <table width="100%">
                <tr>
                    <td width="40%">' . Trimestres::descricao($obj->trimestre) . ' </td>
                   
                    <td >PERÍODO/SEMANA: ' . $obj->periodo_semanal . ' </td>
                </tr>                              
            </table>            
            
            <table width="100%" style="margin-top: 15px;">
                <tr>
                    <td width="100%" style="text-align:justify">
                    <u>DIREITOS DE APRENDIZAGEM E DESENVOLVIMENTO</u>: Conviver; Brincar; Participar; Explorar; Expressar e Conhecer-se.
                    </td>
                </tr>                          
            </table>  

            <table width="100%" style="margin-top: 15px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    <u>IDADE/FAIXA ETÁRIA:</u> ';

        $faixaEtaria = ($obj->idade_faixa_etaria == 1)
            ? " ( X ) Bebês (de zero a um ano e seis meses);
                            &emsp;
                            ( &nbsp; ) Crianças bem pequenas (um ano e sete meses a três anos e onze meses)."
            :
            "( &nbsp; ) Bebês (de zero a um ano e seis meses);
                            &emsp;
                            ( X ) Crianças bem pequenas (um ano e sete meses a três anos e onze meses).";

        $html = $html . $faixaEtaria
            . '
                </td>
            </tr>                          
        </table>  

        <table width="100%" style="margin-top: 15px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    <u>HABILIDADES</u> correspondentes a todos os campos de experiências a serem trabalhados durante o período (objetivos procedimentais/específicos)
                </td>
            </tr>
            <tr>
                <td style="text-align:justify">
                    ' . $obj->habilidades . '
                </td>
            </tr>                          
        </table>  

        <table width="100%" style="margin-top: 15px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    <u>CONTEÚDOS/TEMA:</u> ' . $obj->conteudo_tema . '
                </td>
            </tr>                                     
        </table> 

        <table width="100%" style="margin-top: 15px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    ';
        $eu_o_outro_e_o_nos = ($obj->eu_o_outro_e_o_nos == 1)
            ? ' ( X ) ' : '( &nbsp; )';
        $html = $html . $eu_o_outro_e_o_nos . '
                    <u>EU, O OUTRO E O NÓS:</u> ' . $obj->conteudo_eu_o_outro_e_o_nos . '
                </td>
            </tr>
            <tr>
                <td width="100%" style="text-align:justify">
                    ';
        $corpo_gestos_e_movimentos = ($obj->corpo_gestos_e_movimentos == 1)
            ? ' ( X ) ' : '( &nbsp; )';
        $html = $html . $corpo_gestos_e_movimentos . '
                    <u>CORPO, GESTOS E MOVIMENTOS:</u> ' . $obj->conteudo_corpo_gestos_e_movimentos . '
                </td>
            </tr>
            <tr>
                <td width="100%" style="text-align:justify">
                    ';
        $tracos_sons_cores_e_formas = ($obj->tracos_sons_cores_e_formas == 1)
            ? ' ( X ) ' : '( &nbsp; )';
        $html = $html . $tracos_sons_cores_e_formas . '
                    <u>TRAÇOS, SONS, CORES E FORMAS:</u> ' . $obj->conteudo_tracos_sons_cores_e_formas . '
                </td>
            </tr>
            <tr>
                <td width="100%" style="text-align:justify">
                    ';
        $escuta_fala_pensamento_e_imaginacao = ($obj->escuta_fala_pensamento_e_imaginacao == 1)
            ? ' ( X ) ' : '( &nbsp; )';
        $html = $html . $escuta_fala_pensamento_e_imaginacao . '
                    <u>ESCUTA, FALA, PENSAMENTO E IMAGINAÇÃO:</u> ' . $obj->conteudo_escuta_fala_pensamento_e_imaginacao . '
                </td>
            </tr>
            <tr>
                <td width="100%" style="text-align:justify">
                    ';
        $espaco_tempo_qunatidades_relacoes_e_transformacoes = ($obj->espaco_tempo_qunatidades_relacoes_e_transformacoes == 1)
            ? ' ( X ) ' : '( &nbsp; )';
        $html = $html . $espaco_tempo_qunatidades_relacoes_e_transformacoes . '
                    <u>ESPAÇO, TEMPO, QUANTIDADES, RELAÇÕES E TRANSFORMAÇÕES:</u> ' . $obj->conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes . '
                </td>
            </tr>                                     
        </table> 

        <table width="100%" style="margin-top: 15px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    <u>METODOLOGIA</u> (procedimentos/atividade) 
                </td>
            </tr>
            <tr>
                <td style="text-align:justify">
                    ' . $obj->metodologia . '
                </td>
            </tr>                          
        </table>  

        <table width="100%" style="margin-top: 15px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    <u>RECURSOS DIDÁTICOS</u> 
                </td>
            </tr>
            <tr>
                <td style="text-align:justify">
                    ' . $obj->recursos_didaticos . '
                </td>
            </tr>                          
        </table>  

        <table width="100%" style="margin-top: 15px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    <u>COMO SERÁ A AVALIAÇÃO</u>
                </td>
            </tr>
            <tr>
                <td style="text-align:justify">
                    ' . $obj->como_sera_a_avaliacao . '
                </td>
            </tr>                          
        </table> 
        
        <table width="100%" style="margin-top: 30px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    Coordenação Pedagógica: 
                </td>
            </tr>                                    
        </table> 
        
        <table width="100%" style="margin-top: 30px;">
            <tr>
                <td width="100%" style="text-align:justify">
                    Data do recebimento:  &emsp;  /  &emsp; /
                </td>
            </tr>                                    
        </table> 
           
            
        </div>

        </body>
        </html>';

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function show($id)
    {
        $obj = PlanejamentoSemanal::find($id);
        if (isset($obj)) {
            if ($obj->tipo_documento == 'DIGITAL') {
                $obj->url_arquivo = Storage::url($obj->arquivo);
            }
        }

        if (isset($obj) && !is_null($obj) && isset($obj->data_da_revisao) && !is_null($obj->data_da_revisao)) {
            $obj->data_da_revisao = Auxiliar::converterDataTimeBR($obj->data_da_revisao);
        }

        return view('planejamento_semanal.show', ['planejamento' => $obj]);
    }

    public function edit($id)
    {
        $turmas = Turma::orderBy('nome', 'ASC')->get();

        $planejamento = PlanejamentoSemanal::find($id);
        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();

        return view('planejamento_semanal.edit', [
            'planejamento' => $planejamento, 'turmas' => $turmas,
            'professores' => $professores
        ]);
    }

    public function edit_revisar($id)
    {
        $turmas = Turma::orderBy('nome', 'ASC')->get();

        $planejamento = PlanejamentoSemanal::find($id);
        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();

        return view('planejamento_semanal.edit_revisar', [
            'planejamento' => $planejamento, 'turmas' => $turmas,
            'professores' => $professores
        ]);
    }

    public function edit_upload($id)
    {
        $turmas = Turma::orderBy('nome', 'ASC')->get();

        $planejamento = PlanejamentoSemanal::find($id);
        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();

        return view('planejamento_semanal.edit_upload_arquivo', [
            'planejamento' => $planejamento, 'turmas' => $turmas,
            'professores' => $professores
        ]);
    }

    public function update_upload_arquivo(Request $request, $id)
    {
        // $regras = [
        //     'ano' => 'required',
        //     'turma_id' => 'required',
        //     'tema_do_projeto' => 'required|min:3|max:254',
        //     'conteudo_tema' => 'required|min:3',
        // ];

        // $messagens = [
        //     'required' => 'Campo Obrigatório!',
        //     'ano.required' => 'Campo Obrigatório!',
        //     'turma_id' => 'Campo Obrigatório!',
        //     'tema_do_projeto.required' => 'Campo Obrigatório!',
        //     'tema_do_projeto.min' => 'É necessário no mínimo 3 caracteres!',
        //     'conteudo_tema' => 'Campo Obrigatório!',
        //     'conteudo_tema.min' => 'É necessário no mínimo 3 caracteres!',
        // ];

        // $request->validate($regras, $messagens);

        $planejamento = PlanejamentoSemanal::find($id);
        if (isset($planejamento)) {
            $stringLog = "";

            if ($planejamento->ano != $request->input('ano')) {
                $stringLog = $stringLog . " - ano: " . $planejamento->ano;
                $planejamento->ano = $request->input('ano');
            }

            if ($planejamento->turma_id != $request->input('turma_id')) {
                $stringLog = $stringLog . " - turma_id: " . $planejamento->turma_id;
                $planejamento->turma_id = $request->input('turma_id');
            }

            if ($planejamento->tema_do_projeto != $request->input('tema_do_projeto')) {
                $stringLog = $stringLog . " - tema_do_projeto: " . $planejamento->tema_do_projeto;
                $planejamento->tema_do_projeto = $request->input('tema_do_projeto');
            }

            if ($planejamento->professor_id != $request->input('professor_id')) {
                $stringLog = $stringLog . " - professor_id: " . $planejamento->professor_id;
                $planejamento->professor_id = $request->input('professor_id');
            }

            if ($planejamento->trimestre != $request->input('trimestre')) {
                $stringLog = $stringLog . " - trimestre: " . $planejamento->trimestre;
                $planejamento->trimestre = $request->input('trimestre');
            }

            if ($planejamento->periodo_semanal != $request->input('periodo_semanal')) {
                $stringLog = $stringLog . " - periodo_semanal: " . $planejamento->periodo_semanal;
                $planejamento->periodo_semanal = $request->input('periodo_semanal');
            }

            if ($planejamento->idade_faixa_etaria != $request->input('idade_faixa_etaria')) {
                $stringLog = $stringLog . " - idade_faixa_etaria: " . $planejamento->idade_faixa_etaria;
                $planejamento->idade_faixa_etaria = $request->input('idade_faixa_etaria');
            }

            if ($planejamento->conteudo_tema != $request->input('conteudo_tema')) {
                $stringLog = $stringLog . " - conteudo_tema: " . $planejamento->conteudo_tema;
                $planejamento->conteudo_tema = $request->input('conteudo_tema');
            }

            $planejamento->save();
            if ($stringLog != "") {
                $log = new LogSistema();
                $log->tabela = "planejamento_semanals";
                $log->tabela_id = $planejamento->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }
            return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
        return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Não Atualizado!'));
    }

    public function update_revisar(Request $request, $id)
    {
        $this->validacao($request);
        $planejamento = PlanejamentoSemanal::find($id);
        if (isset($planejamento)) {
            $stringLog = "";

            if ($planejamento->ano != $request->input('ano')) {
                $stringLog = $stringLog . " - ano: " . $planejamento->ano;
                $planejamento->ano = $request->input('ano');
            }

            if ($planejamento->turma_id != $request->input('turma_id')) {
                $stringLog = $stringLog . " - turma_id: " . $planejamento->turma_id;
                $planejamento->turma_id = $request->input('turma_id');
            }

            if ($planejamento->tema_do_projeto != $request->input('tema_do_projeto')) {
                $stringLog = $stringLog . " - tema_do_projeto: " . $planejamento->tema_do_projeto;
                $planejamento->tema_do_projeto = $request->input('tema_do_projeto');
            }

            if ($planejamento->professor_id != $request->input('professor_id')) {
                $stringLog = $stringLog . " - professor_id: " . $planejamento->professor_id;
                $planejamento->professor_id = $request->input('professor_id');
            }

            if ($planejamento->trimestre != $request->input('trimestre')) {
                $stringLog = $stringLog . " - trimestre: " . $planejamento->trimestre;
                $planejamento->trimestre = $request->input('trimestre');
            }

            if ($planejamento->periodo_semanal != $request->input('periodo_semanal')) {
                $stringLog = $stringLog . " - periodo_semanal: " . $planejamento->periodo_semanal;
                $planejamento->periodo_semanal = $request->input('periodo_semanal');
            }

            if ($planejamento->idade_faixa_etaria != $request->input('idade_faixa_etaria')) {
                $stringLog = $stringLog . " - idade_faixa_etaria: " . $planejamento->idade_faixa_etaria;
                $planejamento->idade_faixa_etaria = $request->input('idade_faixa_etaria');
            }

            if ($planejamento->conteudo_tema != $request->input('conteudo_tema')) {
                $stringLog = $stringLog . " - conteudo_tema: " . $planejamento->conteudo_tema;
                $planejamento->conteudo_tema = $request->input('conteudo_tema');
            }

            if ($planejamento->habilidades != $request->input('habilidades')) {
                $stringLog = $stringLog . " - habilidades: " . $planejamento->habilidades;
                $planejamento->habilidades = $request->input('habilidades');
            }

            if ($planejamento->periodo_semanal != $request->input('periodo_semanal')) {
                $stringLog = $stringLog . " - periodo_semanal: " . $planejamento->periodo_semanal;
                $planejamento->periodo_semanal = $request->input('periodo_semanal');
            }

            if ($planejamento->eu_o_outro_e_o_nos != (!is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0)) {
                $stringLog = $stringLog . " - eu_o_outro_e_o_nos: " . !is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0;
                $planejamento->eu_o_outro_e_o_nos = !is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0;
            }

            if ($planejamento->corpo_gestos_e_movimentos != (!is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0)) {
                $stringLog = $stringLog . " - corpo_gestos_e_movimentos: " . !is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0;
                $planejamento->corpo_gestos_e_movimentos = !is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0;
            }

            if ($planejamento->tracos_sons_cores_e_formas != (!is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0)) {
                $stringLog = $stringLog . " - tracos_sons_cores_e_formas: " . !is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0;
                $planejamento->tracos_sons_cores_e_formas = !is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0;
            }

            if ($planejamento->escuta_fala_pensamento_e_imaginacao != (!is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0)) {
                $stringLog = $stringLog . " - escuta_fala_pensamento_e_imaginacao: " . !is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0;
                $planejamento->escuta_fala_pensamento_e_imaginacao = !is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0;
            }

            if ($planejamento->espaco_tempo_qunatidades_relacoes_e_transformacoes != (!is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0)) {
                $stringLog = $stringLog . " - espaco_tempo_qunatidades_relacoes_e_transformacoes: " . !is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0;
                $planejamento->espaco_tempo_qunatidades_relacoes_e_transformacoes = !is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0;
            }

            if ($planejamento->conteudo_eu_o_outro_e_o_nos != $request->input('conteudo_eu_o_outro_e_o_nos')) {
                $stringLog = $stringLog . " - conteudo_eu_o_outro_e_o_nos: " . $request->input('conteudo_eu_o_outro_e_o_nos');
                $planejamento->conteudo_eu_o_outro_e_o_nos = $request->input('conteudo_eu_o_outro_e_o_nos');
            }

            if ($planejamento->conteudo_corpo_gestos_e_movimentos != $request->input('conteudo_corpo_gestos_e_movimentos')) {
                $stringLog = $stringLog . " - conteudo_corpo_gestos_e_movimentos: " . $request->input('conteudo_corpo_gestos_e_movimentos');
                $planejamento->conteudo_corpo_gestos_e_movimentos = $request->input('conteudo_corpo_gestos_e_movimentos');
            }

            if ($planejamento->conteudo_tracos_sons_cores_e_formas != $request->input('conteudo_tracos_sons_cores_e_formas')) {
                $stringLog = $stringLog . " - conteudo_tracos_sons_cores_e_formas: " . $request->input('conteudo_tracos_sons_cores_e_formas');
                $planejamento->conteudo_tracos_sons_cores_e_formas = $request->input('conteudo_tracos_sons_cores_e_formas');
            }

            if ($planejamento->conteudo_escuta_fala_pensamento_e_imaginacao != $request->input('conteudo_escuta_fala_pensamento_e_imaginacao')) {
                $stringLog = $stringLog . " - conteudo_escuta_fala_pensamento_e_imaginacao: " . $request->input('conteudo_escuta_fala_pensamento_e_imaginacao');
                $planejamento->conteudo_escuta_fala_pensamento_e_imaginacao = $request->input('conteudo_escuta_fala_pensamento_e_imaginacao');
            }

            if ($planejamento->conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes != $request->input('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes')) {
                $stringLog = $stringLog . " - conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes: " . $request->input('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes');
                $planejamento->conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes = $request->input('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes');
            }

            if ($planejamento->metodologia != $request->input('metodologia')) {
                $stringLog = $stringLog . " - metodologia: " . $planejamento->metodologia;
                $planejamento->metodologia = $request->input('metodologia');
            }

            if ($planejamento->recursos_didaticos != $request->input('recursos_didaticos')) {
                $stringLog = $stringLog . " - recursos_didaticos: " . $planejamento->recursos_didaticos;
                $planejamento->recursos_didaticos = $request->input('recursos_didaticos');
            }

            if ($planejamento->como_sera_a_avaliacao != $request->input('como_sera_a_avaliacao')) {
                $stringLog = $stringLog . " - como_sera_a_avaliacao: " . $planejamento->como_sera_a_avaliacao;
                $planejamento->como_sera_a_avaliacao = $request->input('como_sera_a_avaliacao');
            }

            $planejamento->usuario_revisor = Auth::user()->id;
            $planejamento->data_da_revisao = date('Y-m-d H:i:s');
            $planejamento->revisado = true;

            $planejamento->save();
            if ($stringLog != "") {
                $log = new LogSistema();
                $log->tabela = "planejamento_semanals";
                $log->tabela_id = $planejamento->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }
            return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
        return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Não Atualizado!'));
    }

    public function update(Request $request, $id)
    {
    //    $this->validacao($request);
        $planejamento = PlanejamentoSemanal::find($id);
        if (isset($planejamento)) {
            $stringLog = "";

            if ($planejamento->ano != $request->input('ano')) {
                $stringLog = $stringLog . " - ano: " . $planejamento->ano;
                $planejamento->ano = $request->input('ano');
            }

            if ($planejamento->turma_id != $request->input('turma_id')) {
                $stringLog = $stringLog . " - turma_id: " . $planejamento->turma_id;
                $planejamento->turma_id = $request->input('turma_id');
            }

            if ($planejamento->tema_do_projeto != $request->input('tema_do_projeto')) {
                $stringLog = $stringLog . " - tema_do_projeto: " . $planejamento->tema_do_projeto;
                $planejamento->tema_do_projeto = $request->input('tema_do_projeto');
            }

            if ($planejamento->professor_id != $request->input('professor_id')) {
                $stringLog = $stringLog . " - professor_id: " . $planejamento->professor_id;
                $planejamento->professor_id = $request->input('professor_id');
            }

            if ($planejamento->trimestre != $request->input('trimestre')) {
                $stringLog = $stringLog . " - trimestre: " . $planejamento->trimestre;
                $planejamento->trimestre = $request->input('trimestre');
            }

            if ($planejamento->periodo_semanal != $request->input('periodo_semanal')) {
                $stringLog = $stringLog . " - periodo_semanal: " . $planejamento->periodo_semanal;
                $planejamento->periodo_semanal = $request->input('periodo_semanal');
            }

            if ($planejamento->idade_faixa_etaria != $request->input('idade_faixa_etaria')) {
                $stringLog = $stringLog . " - idade_faixa_etaria: " . $planejamento->idade_faixa_etaria;
                $planejamento->idade_faixa_etaria = $request->input('idade_faixa_etaria');
            }

            if ($planejamento->habilidades != $request->input('habilidades')) {
                $stringLog = $stringLog . " - habilidades: " . $planejamento->habilidades;
                $planejamento->habilidades = $request->input('habilidades');
            }

            if ($planejamento->conteudo_tema != $request->input('conteudo_tema')) {
                $stringLog = $stringLog . " - conteudo_tema: " . $planejamento->conteudo_tema;
                $planejamento->conteudo_tema = $request->input('conteudo_tema');
            }

            if ($planejamento->periodo_semanal != $request->input('periodo_semanal')) {
                $stringLog = $stringLog . " - periodo_semanal: " . $planejamento->periodo_semanal;
                $planejamento->periodo_semanal = $request->input('periodo_semanal');
            }

            if ($planejamento->eu_o_outro_e_o_nos != (!is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0)) {
                $stringLog = $stringLog . " - eu_o_outro_e_o_nos: " . !is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0;
                $planejamento->eu_o_outro_e_o_nos = !is_null($request->input('eu_o_outro_e_o_nos')) ? $request->input('eu_o_outro_e_o_nos') : 0;
            }

            if ($planejamento->corpo_gestos_e_movimentos != (!is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0)) {
                $stringLog = $stringLog . " - corpo_gestos_e_movimentos: " . !is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0;
                $planejamento->corpo_gestos_e_movimentos = !is_null($request->input('corpo_gestos_e_movimentos')) ? $request->input('corpo_gestos_e_movimentos') : 0;
            }

            if ($planejamento->tracos_sons_cores_e_formas != (!is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0)) {
                $stringLog = $stringLog . " - tracos_sons_cores_e_formas: " . !is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0;
                $planejamento->tracos_sons_cores_e_formas = !is_null($request->input('tracos_sons_cores_e_formas')) ? $request->input('tracos_sons_cores_e_formas') : 0;
            }

            if ($planejamento->escuta_fala_pensamento_e_imaginacao != (!is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0)) {
                $stringLog = $stringLog . " - escuta_fala_pensamento_e_imaginacao: " . !is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0;
                $planejamento->escuta_fala_pensamento_e_imaginacao = !is_null($request->input('escuta_fala_pensamento_e_imaginacao')) ? $request->input('escuta_fala_pensamento_e_imaginacao') : 0;
            }

            if ($planejamento->espaco_tempo_qunatidades_relacoes_e_transformacoes != (!is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0)) {
                $stringLog = $stringLog . " - espaco_tempo_qunatidades_relacoes_e_transformacoes: " . !is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0;
                $planejamento->espaco_tempo_qunatidades_relacoes_e_transformacoes = !is_null($request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes')) ? $request->input('espaco_tempo_qunatidades_relacoes_e_transformacoes') : 0;
            }

            if ($planejamento->conteudo_eu_o_outro_e_o_nos != $request->input('conteudo_eu_o_outro_e_o_nos')) {
                $stringLog = $stringLog . " - conteudo_eu_o_outro_e_o_nos: " . $request->input('conteudo_eu_o_outro_e_o_nos');
                $planejamento->conteudo_eu_o_outro_e_o_nos = $request->input('conteudo_eu_o_outro_e_o_nos');
            }

            if ($planejamento->conteudo_corpo_gestos_e_movimentos != $request->input('conteudo_corpo_gestos_e_movimentos')) {
                $stringLog = $stringLog . " - conteudo_corpo_gestos_e_movimentos: " . $request->input('conteudo_corpo_gestos_e_movimentos');
                $planejamento->conteudo_corpo_gestos_e_movimentos = $request->input('conteudo_corpo_gestos_e_movimentos');
            }

            if ($planejamento->conteudo_tracos_sons_cores_e_formas != $request->input('conteudo_tracos_sons_cores_e_formas')) {
                $stringLog = $stringLog . " - conteudo_tracos_sons_cores_e_formas: " . $request->input('conteudo_tracos_sons_cores_e_formas');
                $planejamento->conteudo_tracos_sons_cores_e_formas = $request->input('conteudo_tracos_sons_cores_e_formas');
            }

            if ($planejamento->conteudo_escuta_fala_pensamento_e_imaginacao != $request->input('conteudo_escuta_fala_pensamento_e_imaginacao')) {
                $stringLog = $stringLog . " - conteudo_escuta_fala_pensamento_e_imaginacao: " . $request->input('conteudo_escuta_fala_pensamento_e_imaginacao');
                $planejamento->conteudo_escuta_fala_pensamento_e_imaginacao = $request->input('conteudo_escuta_fala_pensamento_e_imaginacao');
            }

            if ($planejamento->conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes != $request->input('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes')) {
                $stringLog = $stringLog . " - conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes: " . $request->input('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes');
                $planejamento->conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes = $request->input('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes');
            }

            if ($planejamento->metodologia != $request->input('metodologia')) {
                $stringLog = $stringLog . " - metodologia: " . $planejamento->metodologia;
                $planejamento->metodologia = $request->input('metodologia');
            }

            if ($planejamento->recursos_didaticos != $request->input('recursos_didaticos')) {
                $stringLog = $stringLog . " - recursos_didaticos: " . $planejamento->recursos_didaticos;
                $planejamento->recursos_didaticos = $request->input('recursos_didaticos');
            }

            if ($planejamento->como_sera_a_avaliacao != $request->input('como_sera_a_avaliacao')) {
                $stringLog = $stringLog . " - como_sera_a_avaliacao: " . $planejamento->como_sera_a_avaliacao;
                $planejamento->como_sera_a_avaliacao = $request->input('como_sera_a_avaliacao');
            }

            $planejamento->save();
            if ($stringLog != "") {
                $log = new LogSistema();
                $log->tabela = "planejamento_semanals";
                $log->tabela_id = $planejamento->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }
            return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
        return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Não Atualizado!'));
    }

    public function destroy($id)
    {
        $obj = PlanejamentoSemanal::find($id);

        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "planejamento_semanals";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();

            return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
        return redirect()->route('planejamentossemanais')->withStatus(__('Cadastro Não Excluído!'));
    }

    private function validacao(Request $request)
    {
        $regras = [
            'ano' => 'required',
            'turma_id' => 'required',
            'tema_do_projeto' => 'required|min:3|max:254',

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

    public function turma($id)
    {
        $turma = Turma::find($id);

        $permissoes = array();
        if (isset(Auth::user()->regras)) {
            foreach (Auth::user()->regras as $regra) {
                array_push($permissoes, $regra->nome);
            }
        }

        if (in_array("ADMINISTRADOR", $permissoes)) {
            $list = PlanejamentoSemanal::where('turma_id', $turma->id)->orderBy('created_at', 'DESC')->get();
        } else {
            $professor = Profissional::where('tipo_profissional_id', '1')
                ->where('user_id', Auth::user()->id)
                ->first();

            $list = (isset($professor)) ? PlanejamentoSemanal::where('professor_id', $professor->id)
                ->where('turma_id', $turma->id)
                ->orderBy('created_at', 'DESC')->get()
                : null;
        }

        return view('planejamento_semanal.index_turma', ['planejamentos' => $list, 'turma' => $turma]);
    }
}
