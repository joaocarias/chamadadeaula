<?php

namespace App\Http\Controllers;

use App\LogSistema;
use App\Profissional;
use App\TipoProfissional;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfissionalController extends Controller
{
    public function index()
    {
        $list = Profissional::orderBy('nome','ASC')->get();
        return view('profissional.index', ['profissionais' => $list]); 
    }
    
    public function create()
    {
        $tiposProfissionais = TipoProfissional::OrderBy('nome', 'ASC')->get();
        return view('profissional.create', ['profissional' => null, 'user' => null, 'tiposProfissionais' => $tiposProfissionais]);
    }

    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|min:3|max:254',
            'cpf' => 'required|min:14|max:20',
            'tipo_profissional_id' => 'required',
        ];
       
        $messagens = [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
            'cpf.required' => 'Campo Obrigatório!',
            'cpf.min' => 'É necessário no mínimo 14 caracteres!',
            'tipo_profissional_id.required' => 'Campo Obrigatório!',          
        ];
       
        $request->validate($regras, $messagens);
        $obj = new Profissional();
        $obj->nome = $request->input('nome');
        $obj->cpf = $request->input('cpf');   
        $obj->tipo_profissional_id = $request->input('tipo_profissional_id');        
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();
        
        if(isset($obj->id)){           
            $usuario = new User();
            $usuario->name = $obj->nome;
            $usuario->username = $obj->cpf;
            $usuario->email = "email".$obj->id."@email.com";
            $usuario->password = Hash::make($usuario->passwordDefault());            
            $usuario->save();

            if($usuario->id){
                $obj->user_id = $usuario->id;
                $obj->save();
            }
        }

        return redirect()->route('profissionais')->withStatus(__('Cadastro Realizado com Sucesso!')); 
    }

    public function show($id)
    {
        $obj = Profissional::find($id);
        $usuario = null;
        
        if(isset($obj)){
             $usuario = User::find($obj->user_id);
        }
        
         return view('profissional.show', ['profissional' => $obj , 'usuario' => $usuario]);
    }

    public function edit($id)
    {
        $obj = Profissional::find($id);
        $tiposProfissionais = TipoProfissional::OrderBy('nome', 'ASC')->get();
        return view('profissional.edit', ['profissional' => $obj,  'user' => null, 'tiposProfissionais' => $tiposProfissionais]);
    }
   
    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|min:3|max:254',
            'cpf' => 'required|min:14|max:20',
            'tipo_profissional_id' => 'required',
        ];
       
        $messagens = [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
            'cpf.required' => 'Campo Obrigatório!',
            'cpf.min' => 'É necessário no mínimo 14 caracteres!',
            'tipo_profissional_id.required' => 'Campo Obrigatório!',          
        ];
       
        $request->validate($regras, $messagens);
        $obj = Profissional::find($id);
        if (isset($obj)) {
            $stringLog = "";
            $atualizarNome = false;
            $atualizarCpf = false;
                         
            if($obj->nome != $request->input('nome')){                
                $stringLog = $stringLog . " - nome: " . $obj->nome;
                $obj->nome = $request->input('nome');
                $atualizarNome = true;
            }

            if($obj->cpf != $request->input('cpf')){                
                $stringLog = $stringLog . " - cpf: " . $obj->cpf;
                $obj->cpf = $request->input('cpf');
                $atualizarCpf = true;
            }

            if($obj->tipo_profissional_id != $request->input('tipo_profissional_id')){                
                $stringLog = $stringLog . " - tipo_profissional_id: " . $obj->tipo_profissional_id;
                $obj->tipo_profissional_id = $request->input('tipo_profissional_id');
            }
            
            $obj->save();
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "profissional";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }

            if($atualizarCpf || $atualizarNome){
                $usuario = User::find($obj->user_id);
                if(isset($usuario)){
                    $stringLogUsuario = "";
                    
                    if($atualizarNome){
                        $stringLogUsuario = $stringLogUsuario . " - name: " . $usuario->name;
                        $usuario->name = $request->input('nome');                        
                    }

                    if($atualizarCpf){
                        $stringLogUsuario = $stringLogUsuario . " - username: " . $usuario->username;
                        $usuario->username = $request->input('cpf');                      
                    }

                    $usuario->save();
                    if($stringLogUsuario != ""){
                        $log = new LogSistema();
                        $log->tabela = "users";
                        $log->tabela_id = $usuario->id;
                        $log->acao = "EDICAO";
                        $log->descricao = $stringLogUsuario;
                        $log->usuario_id = Auth::user()->id;
                        $log->save();
                    }
                }                
            }

            return redirect()->route('profissionais')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
        return redirect()->route('profissionais')->withStatus(__('Cadastro Não Atualizado!'));
    }
  
    public function destroy($id)
    {
        $obj = Profissional::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "profissionals";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            $usuario = User::find($obj->user_id);
            if(isset($usuario)){
                $usuario->delete();
               // $usuario->save();
                $log = new LogSistema();
                $log->tabela = "users";
                $log->tabela_id = $usuario->id;
                $log->acao = "EXCLUSAO";
                $log->descricao = "EXCLUSAO";
                $log->usuario_id = Auth::user()->id;
                $log->save();                
            }

            return redirect()->route('profissionais')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }

        return redirect()->route('profissionais')->withStatus(__('Cadastro Não Excluído!'));
    }

    public function resetPassword($id){
        $msg = 'Cadastro não Atualizado!';
        $obj = Profissional::find($id);
        if(isset($obj->user_id)){
            $usuario = User::find($obj->user_id);
            $usuario->password = Hash::make($usuario->passwordDefault());
            $usuario->save();

            $log = new LogSistema();
                $log->tabela = "users";
                $log->tabela_id = $usuario->id;
                $log->acao = "EDICAO";
                $log->descricao = "Resete de Senha";
                $log->usuario_id = Auth::user()->id;
                $log->save();

            $msg = 'Cadastro Atualizado com Sucesso!';
        } 

        return redirect()->route('exibir_profissional', ['id' => $id])->withStatus(__($msg));
    }

    public function createUser($id){
        $msg = 'Cadastro não Atualizado!';
        $obj = Profissional::find($id);
        
        if(isset($obj->id)){           
            $usuario = new User();
            $usuario->name = $obj->nome;
            $usuario->username = $obj->cpf;
            $usuario->email = "email".$obj->id."@email.com";
            $usuario->password = Hash::make($usuario->passwordDefault());            
            $usuario->save();

            if($usuario->id){
                $obj->user_id = $usuario->id;
                $obj->save();
            }
            $msg = 'Cadastro Atualizado com Sucesso!';
        }

        return redirect()->route('exibir_profissional', ['id' => $id])->withStatus(__($msg));
    }
}
