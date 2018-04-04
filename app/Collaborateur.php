<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaborateur extends Model
{
    protected $fillable = ['nom', 'prenom','image', 'date_naissance', 'post', 'email', 'telephone', 'adresse', 'nom_service'];


}
