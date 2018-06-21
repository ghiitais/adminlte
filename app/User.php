<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','is_manager', 'is_admin', 'manager_id', 'is_assistante', 'post', 'adresse', 'date_naissance', 'service_id', 'avatar', 'telephone'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function articles() {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function demandes() {
        return $this->hasMany(Demande::class);
    }
// Manager belongs To many demandes
    public function demandesAssignees() {
        return $this->belongsToMany(Demande::class, 'demande_manager', 'user_id', 'demande_id');
    }

    public function manager() {
       return $this->belongsTo(User::class);
    }

    // 1 user belongsToMany Managers
    public function managers(){
        return $this->belongsToMany(User::class, 'user_manager', 'user_id', 'manager_id');
    }

    public function events(){
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id');
    }

}
