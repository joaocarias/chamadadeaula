<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\LogSistema;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function atualizarSenha(){
        return view('auth.passwords.atualizar_senha');
    }

    public function updatePassword(Request $request, $id){
        $regras = [
            'senha_atual' => 'required|min:6|max:12',
            'password' => 'required|min:6|max:12|confirmed',
        ];
       
        $messagens = [
            'required' => 'Campo Obrigatório!',
            'senha_atual.required' => 'Campo Obrigatório!',
            'senha_atual.min' => 'É necessário no mínimo 6 caracteres!',
            'senha_atual.max' => 'É necessário no máximo 12 caracteres!',

            'password.required' => 'Campo Obrigatório!',
            'password.min' => 'É necessário no mínimo 6 caracteres!',
            'password.max' => 'É necessário no máximo 12 caracteres!',
            'password.confirmed' => 'É necessário confirmar a senha!',
        ];
       
        $request->validate($regras, $messagens);

        $usuario = User::find($id);
        if($usuario){
            if (!(Hash::check($request->get('senha_atual'), Auth::user()->password))) {
                return redirect()->route('atualizar_senha')->withStatus(__("Senha atual informada não é válida. Por favor, tente novamente!"));
            }

            $usuario->password = Hash::make($request->input('password'));
            $usuario->save();

            $log = new LogSistema();
            $log->tabela = "users";
            $log->tabela_id = $usuario->id;
            $log->acao = "EDICAO";
            $log->descricao = "Troca de senha";
            $log->usuario_id = Auth::user()->id;
            $log->save();

            return redirect()->route('atualizar_senha')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }else{            
            return redirect()->route('atualizar_senha')->withStatus(__('Não foi possível realizar a atualização de senha. Por favor, tente novamente!')); 
        }
    }
}
