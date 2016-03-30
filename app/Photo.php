<?php

namespace App;

use App\Traits\ImagableTrait;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $table = 'photos';

    protected $fillable = [
        'name',
        'image',
        'img_url',
        'order',
    ];

    public function photoable()
    {
        return $this->morphTo();
    }

}
