<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_create_issue()
    {
        $user = factory(\App\User::class)->create();
        $group = (new \App\Repositories\GroupRepository)->create($user, 'Example group', 'About example group');
        $project = (new \App\Repositories\ProjectRepository)->create($user, $group, 'Project', 'Example description');

        $issue = new \App\Repositories\IssueRepository;
        $issue->create($user, $project, 'First issue', 'We should take care about this issue');
        
        $this->assertDatabaseHas('issues', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'name' => 'First issue'
        ]);
    }
}