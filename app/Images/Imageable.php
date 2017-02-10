<?php

namespace App\Images;


trait Imageable
{
    public function getPath($parameters)
    {
        if( empty($this->getFilePath())) return;

        $class = config('shortform.processors.' . config('shortform.processor') . '.class');

        return (new $class)->getUrl($this->getFilePath(), $parameters);
    }

    public function getTag($parameters, $attributes = [])
    {
        if( empty($this->getFilePath())) return;

        $tag = '<img src="' . $this->getPath($parameters) . '"';

        if(empty($attributes['alt'])) $attributes['alt'] = $this->getAltText();

        foreach($attributes as $key => $value)
        {
            $tag .= ' ' . $key . '="' . $value . '"';
        }

        $tag .= ' />';

        return $tag;
    }

    public function getFilePath()
    {
        $attribute = property_exists($this, 'filePathAttribute') ? $this->filePathAttribute : 'file_name';

        $prefix = property_exists($this, 'filePathPrefix') ? $this->filePathPrefix : '';

        $path = [];

        if(is_array($attribute))
        {
            foreach($attribute as $a)
            {
                $path[] = $this->getAttribute($a);
            }
        } else
        {
            $path[] = $this->getAttribute($attribute);
        }

        return $prefix . implode('/', $path);

    }

    public function getAltText()
    {
        $attribute = property_exists($this, 'altTextAttribute') ? $this->altTextAttribute : 'original_name';

        return $this->getAttribute($attribute);
    }
}