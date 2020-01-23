<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurmaAluno extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function turma()
    {
        return $this->belongsToMany('App\Turma', 'turma_id', 'id');
    }

    public function aluno()
    {
        return $this->belongsTo('App\Aluno', 'aluno_id', 'id');
    }
}
