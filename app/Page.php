<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'pages';

    protected $fillable = ['name', 'slug', 'text', 'title', 'keywords', 'description'];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];
}
