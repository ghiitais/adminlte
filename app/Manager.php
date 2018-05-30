<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = ['user_id', 'demande_id', 'manager_id'];
    public $table = "demande_manager";

    public function demandes(){
        return $this->belongsToMany('\App\Demande', 'demande_manager', 'user_id', 'demande_id');
    }



}
