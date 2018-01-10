<?php 

namespace App\Repositories;

use App\User;
use App\Project;
use App\Issue;
use Illuminate\Support\Facades\DB;

class IssueRepository
{
    /**
     * Create an issue
     *
     * @param User $user
     * @param Project $project
     * @param string $name
     * @param string $comment
     * @return void
     */
    public function create(User $user, Project $project, string $name, string $comment)
    {
        return DB::transaction(function() use($user, $project, $name, $comment) {
            $issue = $project->issue()->create([
                'sequence' => $this->generateId($project),
                'name' => $name,
                'user_id' => $user->id
            ]);

            $commentRepo = new CommentRepository;
            $commentRepo->create($issue, $user, $comment);

            return $issue->load(['user', 'comment']);
        });
    }


    private function generateId(Project $project)
    {
        return $project->issue->count() + 1;
    }
}