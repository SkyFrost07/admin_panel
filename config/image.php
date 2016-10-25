<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'upload_dir' => 'uploads/',
    'image_sizes' => [
        'thumbnail' => [
            'width' => 80,
            'height' => 80,
            'crop' => true
        ],
        'medium' => [
            'width' => 360,
            'height' => 240,
            'crop' => true
        ],
        'large' => [
            'width' => 1368,
            'height' => null,
            'crop' => false
        ]
    ]

);
