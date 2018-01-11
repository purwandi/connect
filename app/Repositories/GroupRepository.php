<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Group;
use App\User;

class GroupRepository 
{
    /**
     * Create group
     *
     * @param string $name
     * @param string $description
     * @return App\Group
     */
    public function create(User $user, string $name, string $description) 
    {
        if ($user->group()->where('slug', str_slug($name))->first()) {
            return null;
        }

        return DB::transaction(function() use($user, $name, $description) {
            $group = Group::create([
                'name' => $name,
                'slug' => str_slug($name),
                'description' => $description
            ]);
    
            $user->group()->attach($group, ['role' => Group::ROLE_OWNER]);

            return $group;
        });
    }

    /**
     * Find group by id
     *
     * @param integer $id
     * @return App\Group
     */
    public function findById(int $id)
    {
        return Group::where('id', $id)->first();
    }

    /**
     * Find group by slug
     *
     * @param string $slug
     * @return App\Group
     */
    public function findBySlug(string $slug) 
    {
        return Group::where('slug', $slug)->first();
    }
}