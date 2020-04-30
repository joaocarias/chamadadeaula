<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relato extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function professor()
    {
        return $this->hasOne('App\Profissional', 'id', 'professor_id');
    }

    public function turma()
    {
        return $this->hasOne('App\Turma', 'id', 'turma_id');
    }

    public function aluno()
    {
        return $this->hasOne('App\Aluno', 'id', 'aluno_id');
    }

    public function revisor()
    {
        return $this->belongsTo('App\User', 'usuario_revisor', 'id');
    }
}
