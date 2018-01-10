<?php

namespace App; 

trait ServiceBindings 
{
    protected $bindings = [
        App\Repositories\CommentRepository::class,
        App\Repositories\GroupRepository::class,
        App\Repositories\IssueRepository::class,
        App\Repositories\ProjectRepository::class,
        App\Repositories\TeamRepository::class,
    ];
}