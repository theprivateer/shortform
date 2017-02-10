<?php
/**
 * Created by PhpStorm.
 * User: philstephens
 * Date: 10/2/17
 * Time: 3:15 PM
 */

namespace App;


class TagQueue
{
    private $tags = [];

    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }
}