<?php

namespace App;

class Team extends Model 
{
    protected $table = 'teams';
    protected $fillable = ['name'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'users_teams');
    }
}