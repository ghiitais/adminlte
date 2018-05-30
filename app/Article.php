<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
   protected $fillable = ['titre', 'contenu','image','author_id'];

public function author() {
    return $this->belongsTo(Auth::user());
}
}
