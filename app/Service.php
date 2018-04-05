<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = [
        'nom',
        'description'
    ];


public function collaborateurs() {
    return $this->hasMany('App\Collaborateur');
}


}
