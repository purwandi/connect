<?php

namespace App;

class Group extends Model 
{
    const ROLE_OWNER = 'owner';
    const ROLE_COLLABORATOR = 'collaborator';

    protected $table = 'groups';
    protected $fillable = [
        'name', 'description', 'slug'
    ];

    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function team()
    {
        return $this->hasMany(Team::class);
    }
}