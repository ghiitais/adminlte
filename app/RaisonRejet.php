<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaisonRejet extends Model
{
    protected $fillable = ['demande_id', 'message'];

    public function demande(){
        $this->belongsTo(Demande::class);
    }
}
