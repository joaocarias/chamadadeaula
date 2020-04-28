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
}
