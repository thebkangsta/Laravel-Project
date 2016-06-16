<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user() {
        return $this->belongsToMany(User::class);
    }

    protected $fillable = [
        'user_id','name','comment_text',
    ];

    public function scopeAllComments($query) {
        return $query->select(\DB::raw('name,
        comment_text,
        created_at'))->get();
    }
}