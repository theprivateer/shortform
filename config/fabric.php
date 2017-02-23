<?php

return [

    'admin-prefix' => '.fabric',

    'upload-prefix' => 'uploads',

    'backend-only'  => false,

    'fabric-homepage'  => false,

    'site' => \Privateer\Fabric\Sites\Site::class,

    'allow-null-site' => false,

    'sitemap' => '\Privateer\Fabric\Http\Controllers\SitemapController@show',

    'auth-middleware'   => 'auth', // default - use NullAuth to block backend

    //'database-connection' => 'fabric',

    'database-prefix'   => env('FABRIC_DB_PREFIX', 'fabric_'),

    'processor' => 'glide', // 'default

    'processors' => [ // 'drivers'
        'glide' => [
            'class'         => \Privateer\Fabric\Images\Processors\GlideProcessor::class,
            'filesystem'    => 'local', // default to whatever the default filesystem is
            'cache'         => 'local'
        ],
        'imgix' => [
            'class'             => \Privateer\Fabric\Images\Processors\ImgixProcessor::class,
            'source_server'     => '',
            'source_signature'  => '',
            'source_prefix'     => ''
        ]
    ],

    'preview-image-parameters' => [
        'w'     => 300,
        'h'     => 300,
        'fit'   => 'crop',
    ],
];