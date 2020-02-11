<?php

namespace App\ViewModel;

class RelatosTurmaViewModel 
{
    private $turmaProfessor;
    private $alunos;

    public function __construct($turmaProfessor = null, $alunos = null)
    {
        $this->turmaProfessor = $turmaProfessor;
        $this->alunos = $alunos;
    }

    public function getTurmaProfessor(){
        return $this->turmaProfessor;   
    }

    public function getAlunos(){
        return $this->alunos;
    }

    public function setTurmaProfessor($turmaProfessor){
        $this->turmaProfessor = $turmaProfessor;
    }

    public function setAlunos($alunos){
        $this->alunos = $alunos;
    }

}