<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\LogSistema;
use App\Profissional;
use App\Relato;
use App\Turma;
use App\TurmaAluno;
use App\TurmaProfessor;
use App\ViewModel\RelatosTurmaViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

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

        return view('relato.index', ['turmasProfessor' => $turmasProfessor]);
    }

    public function create($id_turma, $id_aluno)
    {
        $turma = Turma::find($id_turma);
        $aluno = Aluno::find($id_aluno);

        $relatorio = new Relato();

        $anoAtual = date("Y");
        $relatorio->ano = $anoAtual;

        $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();

        $professor = Profissional::where('user_id', Auth::user()->id)
            ->where('tipo_profissional_id', '1')
            ->first();

        if (isset($professor) && !is_null($professor)) {
            $relatorio->professor_id = $professor->id;
        }

        return view('relato.create', [
            'turma' => $turma, 'aluno' => $aluno, 'professores' => $professores,  'relatorio' => $relatorio
        ]);
    }

    public function store(Request $request)
    {
        $obj = new Relato();
        $obj->trimestre = $request->input('trimestre');
        $obj->aluno_id = $request->input('aluno_id');
        $obj->turma_id = $request->input('turma_id');
        $obj->professor_id = $request->input('professor_id');
        $obj->relato = $request->input('relato');

        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();

        return redirect()->route('relatorios_de_turma', ['id' => $obj->turma_id])->withStatus(__('Cadastro Realizado com Sucesso!'));
    }

    public function turma($id)
    {
        $turma = Turma::find($id);
        $alunos = null;
        if (isset($turma)) {
            $alunos = TurmaAluno::where('turma_id', $turma->id)->get();
            $relatorios = Relato::where('turma_id', $turma->id)->orderby('trimestre', 'asc')->get();
        }

        return view('relato.relato_de_turma', ['turma' => $turma, 'alunos' => $alunos, 'relatorios' => $relatorios]);
    }

    public function edit($id)
    {
        $obj = Relato::find($id);
        if (isset($obj)) {
            $turma = Turma::find($obj->turma_id);
            $aluno = Aluno::find($obj->aluno_id);
            $professores = Profissional::where('tipo_profissional_id', '1')->orderBy('nome', 'ASC')->get();

            return view('relato.edit', [
                'turma' => $turma, 'aluno' => $aluno, 'professores' => $professores,  'relatorio' => $obj
            ]);
        }
        return view('relato.edit', [
            'turma' => null, 'aluno' => null, 'professores' => null,  'relatorio' => null
        ]);
    }

    public function update(Request $request, $id)
    {
        $obj = Relato::find($id);
        if (isset($obj)) {
            $stringLog = "";

            if ($obj->professor_id != $request->input('professor_id')) {
                $stringLog = $stringLog . " - professor_id: " . $obj->professor_id;
                $obj->professor_id = $request->input('professor_id');
            }

            if ($obj->relato != $request->input('relato')) {
                $stringLog = $stringLog . " - relato: " . $obj->relato;
                $obj->relato = $request->input('relato');
            }

            if ($obj->trimestre != $request->input('trimestre')) {
                $stringLog = $stringLog . " - trimestre: " . $obj->trimestre;
                $obj->trimestre = $request->input('trimestre');
            }

            $obj->save();
            if ($stringLog != "") {
                $log = new LogSistema();
                $log->tabela = "relatos";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }
            return redirect()->route('relatorios_de_turma', ['id' => $obj->turma_id])->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }

        return redirect()->route('relatorios_de_turma', ['id' => $obj->turma_id])->withStatus(__('Cadastro não Atualizado!'));
    }

    public function destroy($id)
    {
        $obj = Relato::find($id);
        $turma_id = $obj->turma_id;

        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "relatos";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();

            return redirect()->route('relatorios_de_turma', ['id' => $turma_id])->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
        return redirect()->route('relatorios_de_turma', ['id' => $turma_id])->withStatus(__('Cadastro Não Excluído!'));
    }

    public function imprimir($turma_id, $trimeste)
    {
        $trimestre_id = 1;
        if ($trimeste == 'II') {
            $trimestre_id = 2;
        } else if ($trimeste == 'III') {
            $trimestre_id = 3;
        } else {
            $trimestre_id = 1;
        }

        $turma = Turma::find($turma_id);
        $encoding = 'UTF-8';

        $alunos = TurmaAluno::join('alunos', 'aluno_id', '=', 'alunos.id')
            ->where('turma_id', $turma_id)
            ->where('turma_alunos.deleted_at', null)
            ->where('alunos.deleted_at', null)
            ->orderby('alunos.nome', 'asc')
            ->get();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_header' => 15,
            'margin_footer' => 15,
        ]);

        foreach ($alunos as $aluno) {
            $relatos = Relato::where('turma_id', $turma_id)
                ->where('trimestre', $trimestre_id)
                ->where('aluno_id', $aluno->id)
                ->get();

            foreach ($relatos as $relato) {

                $html = '

                        <html>
                        <head>
                        
                        </head>
                        <body style="font-family: times; font-size: 12pt; ">
                    ';

                $html = $html . '
                    <table width="100%" style="border: 1px solid black;">
                    <tr>
                        <td> <img src="/imgs/brasao.jpg" width="75"> </td>
                    
                        <td style="font-size: 10pt; text-align: justify;">
                        <span>   
                   
                            CMEI NOSSA SENHORA DE LOURDES    
                            <br /> RALATÓRIO INDIVIDUAL
                            <br /> <strong> ANO ' . $turma->ano . ' - ' . $trimeste . ' TRIMESTRE </STRONG>
                                       
                        </span>
                             <br />
                        <span>                                                                   
                            <br /> ALUNO(A): ' . mb_convert_case($aluno->nome, MB_CASE_UPPER, $encoding) . '

                            <br />

                            <br /> TURMA: ' . mb_convert_case($turma->nome, MB_CASE_UPPER, $encoding) . '
                            <br /> PROFESSOR: <strong> ' . mb_convert_case($relato->professor->nome, MB_CASE_UPPER, $encoding) . ' </strong>
                            <br />                        
                        </span>
                        </td>
                    </tr>
                    </table>
                    
                        <div style="text-align: justify;">
                    ' . $relato->relato . '
                    </div>

                    

            ';

                $html = $html . '
                    </body>
                    </html>';

                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }
        }

        $mpdf->Output();
    }
}
