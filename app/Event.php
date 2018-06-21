<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description','dayStart', 'dayEnd', 'timeStart', 'timeEnd', 'image'];

    public function participants() {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }

}