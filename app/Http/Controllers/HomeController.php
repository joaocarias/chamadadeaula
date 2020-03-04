<?php

namespace App\Http\Controllers;

use App\Aluno;
use Illuminate\Http\Request;

class HomeController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index()
    {
        $alunos = Aluno::orderBy('created_at', 'desc')->take(5)->get();
        return view('home', ['alunos' => $alunos]);
    }
}
