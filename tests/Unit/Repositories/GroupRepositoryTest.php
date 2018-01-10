<?php

namespace Tests\Unit\Repositories;

use App\Repositories\GroupRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_group()
    {
        $user = factory(\App\User::class)->create();
        $repo = new GroupRepository;

        $group = $repo->create($user, 'Example group', 'About example group');

        $this->assertDatabaseHas('groups', [
            'name' => 'Example group',
            'slug' => 'example-group'
        ]);

        $this->assertDatabaseHas('users_groups', [
            'user_id' => $user->id,
            'group_id' => $group->id,
            'role' => \App\Group::ROLE_OWNER,
        ]);
    }

    public function test_find_group_by_id()
    {
        $user = factory(\App\User::class)->create();
        $repo = new GroupRepository;
        $data = $repo->create($user, 'Example group', 'About example group');

        $group = $repo->findById($data->id);

        $this->assertEquals($data->id, $group->id);
    }

    public function test_find_group_by_slug()
    {
        $user = factory(\App\User::class)->create();
        $repo = new GroupRepository;
        $data = $repo->create($user, 'Example group', 'About example group');

        $group = $repo->findBySlug('example-group');

        $this->assertEquals($data->id, $group->id);
    }
}