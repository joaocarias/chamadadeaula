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
        $tipo_profissional = null;
        $usuario = null;
        
        if(isset($obj)){
            $tipo_profissional = TipoProfissional::find($obj->tipo_profissional_id);
            $usuario = User::find($obj->user_id);
        }
        
         return view('profissional.show', ['profissional' => $obj, 'tipo_profissional' => $tipo_profissional
                                             , 'usuario' => $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
