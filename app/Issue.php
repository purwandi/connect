<?php

namespace App;

class Issue extends Model 
{
    protected $table = 'issues';
    protected $fillable = ['sequence', 'name', 'user_id'];

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}