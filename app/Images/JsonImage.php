<?php

namespace App\Images;


class JsonImage
{
    public function __construct($json)
    {
        $this->setJson($json);
    }

    public function setJson($json)
    {
        $this->data = json_decode($json);
    }

    public function getPath($key)
    {
        if( empty($this->data->$key)) return;

        return $this->data->$key;
    }

    public function getTag($key, $attributes = [])
    {
        if( empty($this->data->$key)) return;

        $tag = '<img src="' . $this->getPath($key) . '"';

        foreach($attributes as $key => $value)
        {
            $tag .= ' ' . $key . '="' . $value . '"';
        }

        $tag .= ' />';

        return $tag;
    }
}