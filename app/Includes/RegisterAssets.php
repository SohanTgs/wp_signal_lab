<?php

namespace Viserlab\Includes;


class RegisterAssets{
    public static $styles = [
        'admin'=>[
            'overwrite.css',
            'vendor/bootstrap-toggle.min.css',
            'vendor/select2.min.css',
            'viser_admin.css',
        ],
        'global'=>[
            'bootstrap.min.css',
            'all.min.css',
            'line-awesome.min.css',
        ],
        'public'=>[
            'viser_public.css',
            'viser_activation.css',
            'bootstrap.css',
            'lib/animate.css',
            'viser_main.css',
            'viser_custom.css',
        ]
    ];
    public static $scripts = [
        'admin'=>[
            'vendor/bootstrap-toggle.min.js',
            'vendor/jquery.slimscroll.min.js',
            'nicEdit.js',
            'vendor/select2.min.js',
            'viser_admin.js',
        ],
        'global'=>[
            'bootstrap.bundle.min.js',
        ],
        'public'=>[
            'viser_main.js'
        ]
    ];
}