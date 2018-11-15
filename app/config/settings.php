<?php
//loading priv file for db
$priv_file = __DIR__ . '/.priv_data';
if(file_exists($priv_file)){
    $priv_data = explode(',',file_get_contents($priv_file));
} else {
    var_dump('.priv_data file in /config folder not found. This file must contain: "user,password" ');
    die();
}

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,

        'db' => [
            'driver'        => 'mysql',
            'host'          => 'frost.dedi.melbourne.co.uk',
            'port'          => '3308',
            'database'      => 'toy',
            'username'      => $priv_data[0],
            'password'      => $priv_data[1],
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