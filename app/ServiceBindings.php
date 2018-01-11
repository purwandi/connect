<?php

namespace App; 

trait ServiceBindings 
{
    protected $bindings = [

        App\Contracts\UserContract::class => App\User::class,
        App\Contracts\GroupContract::class => App\Contract::class,
        App\Contracts\ProjectContract::class => App\Project::class,

        App\Repositories\CommentRepository::class,
        App\Repositories\GroupRepository::class,
        App\Repositories\IssueRepository::class,
        App\Repositories\ProjectRepository::class,
        App\Repositories\TeamRepository::class,
    ];
}