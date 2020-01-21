<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turma extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function turno()
    {
        return $this->hasOne('App\Turno', 'id', 'turno_id');
    }
}
