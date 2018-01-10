<?php

namespace App;

class Comment extends Model 
{
    protected $table = 'issues_comments';
    protected $fillable = ['id', 'name', 'issue_id', 'user_id'];
    public $incrementing = false;

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}