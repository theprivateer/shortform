<?php

namespace App\Images;


interface ProcessorContract
{
    public function getUrl($file_name, $parameters);

}