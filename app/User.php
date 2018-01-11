<?php

namespace App;

use App\Group;
use App\Project;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function group()
    {
        return $this->belongsToMany(Group::class, 'users_groups');
    }

    public function project()
    {
        return $this->belongsToMany(Project::class, 'users_projects');
    }

    public function team()
    {
        return $this->belongsToMany(Team::class, 'users_teams');
    }

    /**
     * Check if the current user in a group
     *
     * @param Group $group
     * @return boolean
     */
    public function isUserInGroup(Group $group)
    {
        return $this->group()->where('group_id', $group->id)->first() !== null;
    }

    /**
     * Check if the current is user is member of team in project
     *
     * @param Project $project
     * @return boolean
     */
    public function isUserInProject(Project $project)
    {
        return $this->project()->where('project_id', $project->id)->first() !== null;
    }
}
