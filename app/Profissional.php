<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profissional extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function tipoProfissional()
    {
        return $this->hasOne('App\TipoProfissional', 'id', 'tipo_profissional_id');
    }

    public function profissional(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
