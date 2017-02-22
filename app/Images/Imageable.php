<?php

namespace App\Images;


trait Imageable
{
    public function getPath($parameters)
    {
        if( empty($this->getFilePathAttribute())) return;

        if( ! is_array($parameters)) $parameters = config('shortform.presets.' . $parameters);

        $class = config('shortform.processors.' . config('shortform.processor') . '.class');

        return (new $class)->getUrl($this->getFilePathAttribute(), $parameters);
    }

    public function getTag($parameters, $attributes = [])
    {
        if( empty($this->getFilePathAttribute())) return;

        $tag = '<img src="' . $this->getPath($parameters) . '"';

        if(empty($attributes['alt'])) $attributes['alt'] = $this->getAltTextAttribute();

        foreach($attributes as $key => $value)
        {
            $tag .= ' ' . $key . '="' . $value . '"';
        }

        $tag .= ' />';

        return $tag;
    }

    public function getFilePathAttribute()
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

    public function getAltTextAttribute()
    {
        $attribute = property_exists($this, 'altTextAttribute') ? $this->altTextAttribute : 'original_name';

        return $this->getAttribute($attribute);
    }
}