<?php

namespace App;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Spatie\Tags\Tag as Model;

class Tag extends Model
{
    use AlgoliaEloquentTrait;

}
