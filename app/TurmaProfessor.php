<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurmaProfessor extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function turma()
    {
        return $this->belongsToMany('App\Turma', 'id', 'turma_id');
    }

    public function professor()
    {
        return $this->belongsToMany('App\Profissional', 'id', 'professor_id');
    }
}
