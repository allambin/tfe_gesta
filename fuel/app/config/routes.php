<?php
return array(
    //'_root_'  => 'welcome/index',  // The default route
    '_root_' => 'pontaury/index',
    'login' => 'users/login',
    '_404_' => 'welcome/404', // The main 404 route

    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),

    'test'   => 'welcome/test',
);