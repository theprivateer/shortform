<?php

namespace App\Images\Processors;

use League\Glide\Urls\UrlBuilder;
use App\Images\ProcessorContract;

class GlideProcessor implements ProcessorContract
{
    public function getUrl($file_name, $parameters)
    {
        $urlBuilder = new UrlBuilder(url('/image'));
        
        return $urlBuilder->getUrl($file_name, $parameters);
    }
    
}