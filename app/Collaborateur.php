<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Collaborateur extends Model
{
    protected $fillable = ['nom', 'prenom', 'image', 'date_naissance', 'post', 'email', 'telephone', 'adresse', 'service_id', 'is_manager', 'manager_id'];

    protected $appends = ['fullName'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function manager()
    {
        return $this->belongsTo(Collaborateur::class);
    }


    public function getFullNameAttribute()
    {
        return $this->attributes['nom'].' '.$this->attributes['prenom'];
    }


/*
    public function setIsManagerAttribute()
    {
     $this->attributes['is_manager'] = true;
    }
*/
}
