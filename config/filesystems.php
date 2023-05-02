<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'post_gallery' => [
            'driver' => 'local',
            'root' => storage_path('app/public/post/gallery'),
            'url' => '/storage/post/gallery',
            'visibility' => 'public',
        ],

        'post_thumb' => [
            'driver' => 'local',
            'root' => storage_path('app/public/post/thumb'),
            'url' => '/storage/post/thumb',
            'visibility' => 'public',
        ],

        'page_gallery' => [
            'driver' => 'local',
            'root' => storage_path('app/public/page/gallery'),
            'url' => '/storage/page/gallery',
            'visibility' => 'public',
        ],

        'page_thumb' => [
            'driver' => 'local',
            'root' => storage_path('app/public/page/thumb'),
            'url' => '/storage/page/thumb',
            'visibility' => 'public',
        ],

        'topic_gallery' => [
            'driver' => 'local',
            'root' => storage_path('app/public/topic/gallery'),
            'url' => '/storage/topic/gallery',
            'visibility' => 'public',
        ],

        'topic_thumb' => [
            'driver' => 'local',
            'root' => storage_path('app/public/topic/thumb'),
            'url' => '/storage/topic/thumb',
            'visibility' => 'public',
        ],

        'resource_gallery' => [
            'driver' => 'local',
            'root' => storage_path('app/public/resource/gallery'),
            'url' => '/storage/resource/gallery',
            'visibility' => 'public',
        ],

        'resource_thumb' => [
            'driver' => 'local',
            'root' => storage_path('app/public/resource/thumb'),
            'url' => '/storage/resource/thumb',
            'visibility' => 'public',
        ],

        'question_gallery' => [
            'driver' => 'local',
            'root' => storage_path('app/public/question/gallery'),
            'url' => '/storage/question/gallery',
            'visibility' => 'public',
        ],

        'question_thumb' => [
            'driver' => 'local',
            'root' => storage_path('app/public/question/thumb'),
            'url' => '/storage/question/thumb',
            'visibility' => 'public',
        ],

        'main_logo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/main'),
            'url' => '/storage/main',
            'visibility' => 'public',
        ],


        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],

];
