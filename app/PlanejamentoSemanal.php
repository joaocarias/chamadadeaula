<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanejamentoSemanal extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function turma()
    {
        return $this->belongsTo('App\Turma', 'turma_id', 'id');
    }

    public function professor()
    {
        return $this->belongsTo('App\Profissional', 'professor_id', 'id');
    }
}
