<?php 

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectRepository extends TestCase 
{
    use RefreshDatabase;
    
    public function test_can_create_project()
    {
        $user = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');

        $project = new \App\Repositories\ProjectRepository;
        $project = $project->create($user, $group, 'Project', 'Example description');

        $this->assertDatabaseHas('projects', [
            'group_id' => $group->id,
            'name' => 'Project',
            'description' => 'Example description'
        ]);

        $this->assertDatabaseHas('users_projects', [
            'project_id' => $project->id,
            'user_id' => $user->id
        ]);
    }

    /**
     * @expectedException \App\Exceptions\InvalidErrorPermissionException
     */
    public function test_can_not_create_project_for_non_collaborator_user()
    {
        $user1 = factory(\App\User::class)->create();
        $user2 = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user1, 'Example group', 'About example group');

        $project = new \App\Repositories\ProjectRepository;
        $project = $project->create($user2, $group, 'Project', 'Example description');
    }

    public function test_find_project_by_given_id()
    {
        $user = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');

        $project = new \App\Repositories\ProjectRepository;
        $data = $project->create($user, $group, 'Project', 'Example description');
        $repo = $project->findById($user, $data->id);

        $this->assertEquals($data->id, $repo->id);
    }

    public function test_find_project_by_given_slug()
    {
        $user = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');

        $project = new \App\Repositories\ProjectRepository;
        $data = $project->create($user, $group, 'Project', 'Example description');
        $repo = $project->findBySlug($user, 'project');

        $this->assertEquals($data->id, $repo->id);
    }
}