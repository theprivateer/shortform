<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function secondaryInfo()
    {
        return trim( str_replace($this->name . ',', '', $this->value) );
    }
}
