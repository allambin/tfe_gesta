<?php

/**
 * The production database settings.
 */
return array(
    'default' => array(
        'connection' => array(
            'dsn' => 'mysql:host=localhost;dbname=gesta8',
            'username' => 'root',
            'password' => 'mysql',
        ),
        'profiling' => true
    ),
    'Doctrine_dbal' => array(
        'connection' => array(
            'username' => 'root',
            'password' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'gesta8'
        ),
        'profiling' => true
    ),
//    'default' => array(
//        'type' => 'pdo',
//        'connection' => array(
//            'dsn' => 'pgsql:host=localhost;dbname=gesta6',
//            'username' => 'postgres',
//            'password' => 'psql',
//            'host' => 'localhost',
//            'dbname' => 'gesta6',
//            'persistent' => false,
//            'compress' => false,
//        ),
//        'identifier' => '"',
//        'table_prefix' => '',
//        'charset' => 'utf8',
//        'enable_cache' => true,
//        'profiling' => false,
//    ),
        'pdo' =>array(
            'connection' => array(
                'username'  => 'root',
                'password'  => 'mysql',
                'host'      => 'localhost',
                'dbname'    => 'gesta7'
            ),
            'profiling' => true
        )
);
