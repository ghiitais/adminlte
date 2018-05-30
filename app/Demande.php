<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Demande extends Model
{
    protected $fillable = ['user_id', 'demande_id', 'status', 'type', 'priority', 'manager_id', 'firstDay', 'lastDay', 'arriveOn', 'totalDays', 'congeType'] ;


    public function user(){
       return $this->belongsTo(User::class);
    }

    public function raison_rejet() {
        return $this->hasMany(RaisonRejet::class);
}

public function manager(){
    return $this->belongsTo(User::class)->where('is_manager', '=', 1);
}

    public function managers(){
        return $this->belongsToMany(User::class, 'demande_manager', 'demande_id', 'user_id');
    }
}
