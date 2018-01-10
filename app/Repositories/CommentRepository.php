<?php 

namespace App\Repositories;

use App\User;
use App\Issue;
use App\Comment;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class CommentRepository
{
    public function create(Issue $issue, User $user, string $name)
    {
        return $issue->comment()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => $name,
            'user_id' => $user->id
        ]);
    }
}