<?php

namespace App;

class Project extends Model 
{
    protected $table = 'projects';
    protected $fillable = [
        'name', 'description', 'slug'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'users_projects');
    }

    public function issue()
    {
        return $this->hasMany(Issue::class);
    }
}