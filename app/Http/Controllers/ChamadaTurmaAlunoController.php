<?php

namespace App\Http\Controllers;

use App\ChamadaTurmaAluno;
use App\Escola;
use App\Justificativa;
use App\Lib\Auxiliar;
use App\LogSistema;
use App\Profissional;
use App\Turma;
use App\TurmaAluno;
use App\TurmaProfessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use App\Lib\Meses;

class ChamadaTurmaAlunoController extends Controller
{
    public function index(Request $request)
    {
        $filtro_ano = $request->input('ano');
        if (!isset($filtro_ano) or is_null($filtro_ano))
            $filtro_ano = date('Y');
       
        $filtro = array(
            'ano' => $filtro_ano
        );

        $profissional = Profissional::where('user_id', Auth::user()->id)->first();
        $turmas = null;
        
        $permissoes = Array();        
        if(isset(Auth::user()->regras)){
            foreach(Auth::user()->regras as $regra){
                array_push($permissoes, $regra->nome);
            }        
        }

        if(in_array("ADMINISTRADOR", $permissoes)){
            $turmas = Turma::join('turma_professors', 'turmas.id', '=', 'turma_professors.turma_id')                                    
                                ->where('turma_professors.deleted_at', null)
                                ->when($filtro_ano, function ($query, $filtro) {
                                    return $query->where('turmas.ano', $filtro);
                                })
                                ->distinct()
                                ->orderby('turmas.nome', 'ASC')
                                ->get('turmas.*');
        }else if (isset($profissional)) {
            $turmas = Turma::join('turma_professors', 'turmas.id', '=', 'turma_professors.turma_id')
                                ->where('turma_professors.professor_id', $profissional->id)
                                ->where('turma_professors.deleted_at', null)
                                ->when($filtro_ano, function ($query, $filtro) {
                                    return $query->where('turmas.ano', $filtro);
                                })
                                ->distinct()
                                ->orderby('turmas.nome', 'ASC')
                                ->get('turmas.*');
        }

        return view('chamada_turma_aluno.index', 
                    [
                        'turmas' => $turmas
                        , 'filtro' => $filtro
                        , '_anos' => Auxiliar::obterAnos()]);
    }

    public function registro(Request $request, $id)
    {
        $data = $request->input('data');
        if (!isset($data)) {
            $data = date("d/m/Y");
        }

        $turmaProfessor = TurmaProfessor::where('turma_id', $id)->first();
        $turmaAlunos = TurmaAluno::join('alunos', 'turma_alunos.aluno_id', '=', 'alunos.id')
                                    ->where('turma_id', $turmaProfessor->turma_id)
                                    ->where('alunos.deleted_at', null)
                                    ->orderby('alunos.nome')->get();

        $chamadaTurmaAluno = ChamadaTurmaAluno::where('turma_id', $turmaProfessor->turma_id)
                                    ->where('data_da_aula', Auxiliar::converterDataParaUSA($data))
                                    ->get();

        $justificativaTurma = Justificativa::where('turma_id', $turmaProfessor->turma_id)
                                    ->where('data_da_aula', Auxiliar::converterDataParaUSA($data))
                                    ->get();

        return view(
            'chamada_turma_aluno.registro',
            [
                'turmaProfessor' => $turmaProfessor
                , 'turmaAlunos' => $turmaAlunos
                , 'data' => $data
                , 'chamadaTurmaAluno' => $chamadaTurmaAluno,
                'justificativaTurma' => $justificativaTurma
            ]
        );
    }

    public function excluirjustificativa(Request $request, $id)
    {
        $justicativa = Justificativa::find($id);
        if ($justicativa) {
            $justicativa->delete();
            $log = new LogSistema();
            $log->tabela = "justificativa";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
        }

        return redirect()->route('registro_chamada', ['id' => $request->input('idturma')])->withStatus(__('Cadastro Excluído com Sucesso!'));
    }

    public function store(Request $request)
    {
        $data_da_aula = Auxiliar::converterDataParaUSA($request->input("data"));
        $turma_id = $request->input("id_turma");
        $presentes = $request->input("presentes");
        $removerPresentes = $request->input("remover_presentes");
        $faltosos = $request->input("faltosos");
        $removerFaltosos = $request->input("remover_faltosos");
        $usuario_cadastro = $request->input("id_usuario");

        if(isset($removerPresentes) && !is_null($removerPresentes)){
            foreach($removerPresentes as $aluno_id){
                $this->removerChamdaBD($data_da_aula, $turma_id, $aluno_id);
            }
        }

        if(isset($removerFaltosos) && !is_null($removerFaltosos)){
            foreach($removerFaltosos as $aluno_id){
                $this->removerChamdaBD($data_da_aula, $turma_id, $aluno_id);
            }
        }

        if (isset($presentes) && !is_null($presentes)) {
            foreach ($presentes as $aluno_id) {
                $this->registrarChamadaBD($data_da_aula, $turma_id, $aluno_id, "P", $usuario_cadastro);
            }
        }

        if (isset($faltosos) && !is_null($faltosos)) {
            foreach ($faltosos as $aluno_id) {
                $this->registrarChamadaBD($data_da_aula, $turma_id, $aluno_id, 'F', $usuario_cadastro);
            }
        }

        return http_response_code(200);
    }

    private function removerChamdaBD($data_da_aula, $turma_id, $aluno_id){
        ChamadaTurmaAluno::where("data_da_aula", $data_da_aula)
                            ->where("turma_id", $turma_id)
                            ->where("aluno_id", $aluno_id)
                            ->delete();
    }

    private function registrarChamadaBD($data_da_aula, $turma_id, $aluno_id, $situacao, $usuario_cadastro)
    {
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

    public function justificar(Request $request, $id)
    {
        $turmaProfessor = TurmaProfessor::find($id);
        $obj = new Justificativa();
        $obj->justificativa = $request->input("justificativa");
        $obj->data_da_aula = Auxiliar::converterDataParaUSA($request->input("data_justificativa"));
        $obj->turma_id = $turmaProfessor->turma_id;
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();

        return redirect()->route('registro_chamada', ['id' => $turmaProfessor->id])->withStatus(__('Cadastro realizado com Sucesso!'));
    }

    public function imprimir($id)
    {
        $turmaProfessor = TurmaProfessor::where('turma_id', $id)->first();
        $turmaAluno = TurmaAluno::where('turma_id', $turmaProfessor->turma_id)->first();
        $mes = date('m');
        $ano =  date('Y');

        return view('chamada_turma_aluno.imprimir', ['turma' => $turmaAluno, 'mes' => $mes, 'ano' => $ano]);
    }

    public function imprimirpdf(Request $request, $id)
    {
        $corBranca = "#FFFFFF";
        $corCinza = "#848484";
        $turmaAluno = TurmaAluno::find($id);
                
        $mes = $request->input('mes');
        $ano = $request->input('ano');
        $escola = Escola::first();

        if (isset($turmaAluno)) {
            $primeiroDia = 1;

            $data_incio = mktime(0, 0, 0, $mes , 1 , $ano);
            $ultimoDia = date('t',$data_incio);
            $data_final = mktime(0, 0, 0, $mes , $ultimoDia , $ano);
  
            $turma = Turma::find($turmaAluno->turma_id);
            $turmaAlunos = TurmaAluno::join('alunos', 'turma_alunos.aluno_id', '=', 'alunos.id')->where('turma_id', $turma->id)->where('alunos.deleted_at', null)->orderby('alunos.nome', 'asc')->get();
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'orientation' => 'L'
            ]);

            $cabecalhoTabela = 
                '<th class="bordasimples">Nº</th>
                <th class="bordasimples">Aluno</th>';
            
            for($j = $primeiroDia; $j <= $ultimoDia; $j++){
                $dia = mktime(0, 0, 0, $mes , $j , $ano);
                $diaDaSemana = date('w', $dia);
                $corCelula = $corBranca;
                if($diaDaSemana == 0 || $diaDaSemana == 6)
                    $corCelula = $corCinza;

                $cabecalhoTabela = $cabecalhoTabela 
                    . '<th class="bordasimples" style="background-color:'.$corCelula.'">'. $j .'</th>';
            }

            $cabecalhoTabela = $cabecalhoTabela 
                    . '<th class="bordasimples">T.F.</th>';
            
            $i = 1;
            $corpoTabela = "";
            foreach($turmaAlunos as $t){
                $totalDeFaltas = 0;
                $corpoLinha = '';
                for($j = $primeiroDia; $j <= $ultimoDia; $j++){
                    $dia = mktime(0, 0, 0, $mes , $j , $ano);
                    $diaDaSemana = date('w', $dia);
                    $corCelula = $corBranca;
                    if($diaDaSemana == 0 || $diaDaSemana == 6)
                        $corCelula = $corCinza;
                        
                    $dataDaAula = "$ano-$mes-$j";

                    $justificativa = Justificativa::
                                where('turma_id', $turmaAluno->turma_id)
                                ->where('data_da_aula', $dataDaAula )                                
                                ->first();
                               
                    $presenca = "";
                    if(!isset($justificativa)){
                        $chamada = ChamadaTurmaAluno::
                            where('turma_id', $turmaAluno->turma_id)
                            ->where('aluno_id', $t->aluno_id)
                            ->where('data_da_aula', $dataDaAula )                                
                            ->first();
                        
                        if(isset($chamada)){
                            if($chamada->situacao == "F"){
                                $totalDeFaltas++;
                                $presenca = "X";
                            }else if($chamada->situacao == "P"){
                                $presenca = "P";
                            }   
                        }  
                    }else{
                        $presenca = " | ";
                    }

                    $corpoLinha = $corpoLinha 
                        . '<td class="bordasimples" style="background-color:'.$corCelula.'; text-align:center;" > '. $presenca .' </td>';
                            
                }

                $corpoTabela = $corpoTabela
                    .'<tr class="bordasimples">
                        <td class="bordasimples">' .$i.'</td>
                        <td class="bordasimples">' . $t->aluno->nome . '</td>
                        '.$corpoLinha.
                        '<td class="bordasimples" style="text-align:center;" > '.$totalDeFaltas.'</td>';  
                    '</tr>';
                
                $i++;
            }
            
            $justificativas = Justificativa::where('turma_id', $turmaAluno->turma_id)
                                ->whereBetween('data_da_aula', [date('Y-m-d', $data_incio), date('Y-m-d', $data_final)])
                                ->orderby('data_da_aula')->get();

            $textoJustificativas = "";
            foreach($justificativas as $item){
                $textoJustificativas = $textoJustificativas 
                    . Auxiliar::converterDataParaBR($item->data_da_aula) . " - " . $item->justificativa . '<br />';
            }

            $html = '

        <html>
        <head>
        
        <style>
            .bordasimples {
                border: 1px solid black;
                border-collapse: collapse;
            }   
        </style>

        </head>
        <body style="font-family: serif; font-size: 10pt;">
        <table width="100%">
            <tr>
                <td width="15%" style="text-align:left"> <img src="/imgs/brasao.jpg" width="110"> </td>
               <td width="70%" style="text-align:center">
               ' . mb_strtoupper($escola->prefeitura, "utf-8") . '
                    <br /> ' . mb_strtoupper($escola->secretaria, "utf-8") . '
                    <br /> <b>' . mb_strtoupper($escola->escola, "utf-8") . '</b>
                    <br /> ' . $escola->endereco->logradouro . ', ' . $escola->endereco->numero . ', ' . $escola->endereco->bairro . ', CEP ' . $escola->endereco->cep . ' – ' . $escola->endereco->cidade . ', ' . $escola->endereco->uf . ' – Telefone: ' . $escola->telefone . '
                    <br /> FREQUÊNCIA DO MÊS DE <b>' . mb_strtoupper(Meses::getMes($mes), "utf-8") . ' – ' . $ano . '</b>
                    <br /> <b>TURMA: ' . mb_strtoupper( $turma->nome , "utf-8") . '</b>                
               </td>
               <td width="15%" style="text-align:right"> <img src="/imgs/cmei.jfif" width="110"> </td>
            </tr>
        </table>
        
        <table width="100%" class="bordasimples" style="font-family: serif; font-size: 10pt;">
            <tr class="bordasimples">
                '.$cabecalhoTabela.'
            </tr>       
            '.$corpoTabela.'     
        </table>

        <table width="100%" style="font-family: serif; font-size: 9pt; text-align:right ">
            <tr>
                <td>"X" = FALTAS DAS CRIANÇAS</td>
            </tr>
            <tr>
                <td>"P" = PRESENÇAS DAS CRIANÇAS </td>
            </tr>
        </table>

        '.$textoJustificativas.' 
        
        <br />
       
        <table width="100%" style="font-family: serif; font-size: 10pt; text-align:right ">
            <tr>
                <td>PROFESSOR(A): _____________________________________________________________________ </td>
            </tr>            
        </table>

        </body>
        </html>';

            $mpdf->WriteHTML($html);

            $mpdf->Output();
        }
    }
}
