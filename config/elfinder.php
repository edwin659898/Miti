<?php

return array(

    /*
|--------------------------------------------------------------------------
| Upload dir
|--------------------------------------------------------------------------
|
| The dir where to store the images (relative from public)
|
*/
    'dir' => ['files'],

    /*
|--------------------------------------------------------------------------
| Filesystem disks (Flysytem)
|--------------------------------------------------------------------------
|
| Define an array of Filesystem disks, which use Flysystem.
| You can set extra options, example:
|
| 'my-disk' => [
|        'URL' => url('to/disk'),
|        'alias' => 'Local storage',
|    ]
*/
    'disks' => [],

    /*
|--------------------------------------------------------------------------
| Routes group config
|--------------------------------------------------------------------------
|
| The default group settings for the elFinder routes.
|
*/

    'route' => [
        'prefix' => 'elfinder',
        'middleware' => ['web', 'auth'], //Set to null to disable middleware filter
    ],

    /*
|--------------------------------------------------------------------------
| Access filter
|--------------------------------------------------------------------------
|
| Filter callback to check the files
|
*/

    'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',

    /*
|--------------------------------------------------------------------------
| Roots
|--------------------------------------------------------------------------
|
| By default, the roots file is LocalFileSystem, with the above public dir.
| If you want custom options, you can set your own roots below.
|
*/

    'roots' => [
        [
            'driver' => 'LocalFileSystem',
            'path'   => public_path() . '/files/',
            'URL'    => '/files/',
            'uploadAllow'   => ['image/png', 'image/jpeg', 'image/pjpeg', 'image/gif', 'application/pdf',],
            'uploadDeny'    => ['all'],
            'uploadOrder'   => ['deny', 'allow'],
            'attributes' => [
                [
                    'pattern' => '/.quarantine|.tmb/',
                    'hidden' => true,
                ],
            ],
        ],
    ],

    /*
|--------------------------------------------------------------------------
| Options
|--------------------------------------------------------------------------
|
| These options are merged, together with 'roots' and passed to the Connector.
| See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
|
*/

    'options' => [],

    /*
|--------------------------------------------------------------------------
| Root Options
|--------------------------------------------------------------------------
|
| These options are merged, together with every root by default.
| See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1#root-options
|
*/
    'root_options' => [],

);
