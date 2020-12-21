<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
            'user_id', 'title', 'content'
        ];

    public function author(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
