<?php

namespace App\Images\Processors;


use Imgix\UrlBuilder;
use App\Images\ProcessorContract;

class ImgixProcessor implements ProcessorContract
{

    public function getUrl($file_name, $parameters)
    {
        $urlBuilder = new UrlBuilder(config('fabric.processors.imgix.source_server'));

        if($signKey = config('fabric.processors.imgix.source_signature')) $urlBuilder->setSignKey($signKey);

        return $urlBuilder->createURL(config('fabric.processors.imgix.source_prefix') . $file_name, $parameters);
    }
    
}