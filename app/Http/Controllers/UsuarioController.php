<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::OrderBy('name', 'ASC')->get();
        return view('usuario.index', ['usuarios' => $usuarios]);     
    }

}
