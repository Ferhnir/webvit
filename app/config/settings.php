<?php
return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,

        'db' => [
            'driver'        => 'mysql',
            'host'          => 'localhost',
            // 'port'          => '3308',
            'database'      => 'toy',
            'username'      => 'root',
            'password'      => '',
            'charset'       => 'utf8',
            'collation'     => 'utf8_unicode_ci',
            'prefix'        => ''
        ],        
        'token' => [
            'secret' => 'emailresetkey',
            'validation' => 1
        ],
    ],
];
?>