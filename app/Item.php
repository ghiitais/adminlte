<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'price', 'details', 'user_id'];

    public function itemDetails() {
        return $this->hasMany(ItemDetails::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
