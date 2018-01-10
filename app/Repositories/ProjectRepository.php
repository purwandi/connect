<?php

namespace App\Repositories;

use App\User;
use App\Group;
use App\Project;
use App\Exceptions\InvalidErrorPermissionException;
use Illuminate\Support\Facades\DB;

class ProjectRepository 
{
    /**
     * Create project
     *
     * @param User $user
     * @param Group $group
     * @param string $name
     * @param string $description
     * @return void
     */
    public function create(User $user, Group $group, string $name, string $description)
    {
        if ($user->isUserInGroup($group) === false) {
            throw new InvalidErrorPermissionException;
        }

        return DB::transaction(function() use($user, $group, $name, $description) {
            $project = $group->project()->create([
                'name' => $name,
                'slug' => str_slug($name),
                'description' => $description
            ]);
    
            $user->project()->attach($project);
    
            return $project;
        });
    }

    /**
     * Find project by given user_id and project_id
     *
     * @param User $user
     * @param integer $id
     * @return App\Project
     */
    public function findById(User $user, int $id)
    {  
        return $user->project()->where('project_id', $id)->first();
    }

    /**
     * Find project by given user_id and slug
     *
     * @param User $user
     * @param integer $id
     * @return App\Project
     */
    public function findBySlug(User $user, string $slug)
    {  
        return $user->project()->where('slug', $slug)->first();
    }
}