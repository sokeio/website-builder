<?php

namespace Sokeio\Builder\Models;

use Sokeio\Model;
use Sokeio\Models\User;

class BuilderTemplate extends Model
{
    protected $fillable = ['name', 'description', 'content', 'author_id', 'status', 'js', 'css', 'topic', 'category', 'only_me', 'thumbnail', 'email'];
    protected $casts = [
        'only_me' => 'boolean'
    ];
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
