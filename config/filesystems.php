<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Default Filesystem Disk
  |--------------------------------------------------------------------------
  |
  | Here you may specify the default filesystem disk that should be used
  | by the framework. A "local" driver, as well as a variety of cloud
  | based drivers are available for your choosing. Just store away!
  |
  | Supported: "local", "ftp", "s3", "rackspace"
  |
  */

  'default' => 'local',

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

  'cloud' => 'webdav',

  /*
  |--------------------------------------------------------------------------
  | Filesystem Disks
  |--------------------------------------------------------------------------
  |
  | Here you may configure as many filesystem "disks" as you wish, and you
  | may even configure multiple disks of the same driver. Defaults have
  | been setup for each driver as an example of the required options.
  |
  */

  'disks' => [

    'local' => [
      'driver' => 'local',
      'root' => storage_path('app'),
    ],

    'log' => [
      'driver' => 'local',
      'root' => storage_path('logs'),
    ],

    'public' => [
      'driver' => 'local',
      'root' => storage_path('app/public'),
      'visibility' => 'public',
      'url' => env('APP_URL').'/storage',
    ],

    'webdav' => [
      'driver'     => 'webdav',
      'baseUri'    => env('WEBDAV_URL'),
      'userName'   => env('WEBDAV_USERNAME'),
      'password'   => env('WEBDAV_PASSWORD'),
      'pathPrefix' => '', // optional
    ],
    'modelli_certificazioni' => [
        'driver' => 'local',
        'root' => storage_path('app/public/modelli_certificazioni'),
        'url' => env('APP_URL').'/storage/modelli_certificazioni',
        'visibility' => 'public',
    ],
    'modelli_ricevute' => [
        'driver' => 'local',
        'root' => storage_path('app/public/modelli_ricevute'),
        'url' => env('APP_URL').'/storage/modelli_ricevute',
        'visibility' => 'public',
    ],
    'certificazioni' => [
        'driver' => 'local',
        'root' => storage_path('app/public/certificazioni'),
        'url' => env('APP_URL').'/storage/certificazioni',
        'visibility' => 'public',
    ],
    'ricevute' => [
        'driver' => 'local',
        'root' => storage_path('app/public/ricevute'),
        'url' => env('APP_URL').'/storage/ricevute',
        'visibility' => 'public',
    ],

    'dropbox' => [
      'driver' => 'dropbox',
      'authorization_token' => '',
    ],

  ],

];
