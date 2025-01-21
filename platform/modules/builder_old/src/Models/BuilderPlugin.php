<?php

namespace Sokeio\Builder\Models;

use Sokeio\Model;

class BuilderPlugin extends Model
{
    protected $fillable = ['name', 'js', 'css', 'options', 'is_active'];
    protected $casts = [
        'is_active' => 'boolean'
    ];
}
