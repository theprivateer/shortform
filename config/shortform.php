<?php

return [

    /*
     * Does each user have their own timeline, or do all users
     * contribute to a single per-installation timeline
     */
    'user-timelines' => env('USER_TIMELINES', false),

    'user-registration' => env('ALLOW_REGISTRATIONS', true),

    'upload-prefix' => 'uploads',

    'processor' => 'glide', // 'default

    'processors' => [ // 'drivers'
        'glide' => [
            'class'         => \App\Images\Processors\GlideProcessor::class,
            'filesystem'    => 'local', // default to whatever the default filesystem is
            'cache'         => 'local'
        ],
        'imgix' => [
            'class'             => \App\Images\Processors\ImgixProcessor::class,
            'source_server'     => '',
            'source_signature'  => '',
            'source_prefix'     => ''
        ]
    ],
];