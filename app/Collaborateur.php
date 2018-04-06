<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaborateur extends Model
{
    protected $fillable = ['nom', 'prenom','image', 'date_naissance', 'post', 'email', 'telephone', 'adresse', 'service_id'];

    public function service() {
        return $this->belongsTo(Service::class);
    }
}
