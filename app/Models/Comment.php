<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];
    // Disable auto-incrementing of the ID
    public $incrementing = false;

    // Set the primary key type to string (UUIDs are strings)
    protected $keyType = 'string';

    // Automatically generate UUIDs when creating a new Post
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if (empty($comment->id)) {
                $post->id = (string) Str::uuid(); // Generate a UUID
            }
        });
    }
}
