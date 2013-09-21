<?php
/**
 * The development database settings.
 */

return array(
    'default' => array(
        'connection' => array(
            'dsn' => 'mysql:host=10.0.210.123;dbname=gesta3',
            'username' => 'gesta3',
            'password' => 'bonjour',
        ),
        'profiling' => true
    ),
    'Doctrine_dbal' => array(
        'connection' => array(
            'username' => 'gesta3',
            'password' => 'bonjour',
            'host' => '10.0.210.123',
            'dbname' => 'gesta3'
        ),
        'profiling' => true
    )
);
