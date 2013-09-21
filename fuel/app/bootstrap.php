<?php

// Load in the Autoloader
require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';



Autoloader::add_classes(array(
    'Twig_Fuel_Extension' => APPPATH.'classes/twig/fuel/extension.php',  // Twig Extension Custom
    'Database_Query_Builder_Delete' => APPPATH.'classes/database/query/builder/delete.php'
));

Autoloader::add_namespace('Maitrepylos',APPPATH.'vendor/maitrepylos/');
Autoloader::add_namespace('Excel',APPPATH.'vendor/excel/',true);
Autoloader::add_namespace('Cranberry',APPPATH.'vendor/Cranberry/',true);
Autoloader::add_namespace('Doctrine',APPPATH.'vendor/Doctrine/',true);


// Register the autoloader
Autoloader::register();


/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGE
 * Fuel::PRODUCTION
 */
Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);

// Initialize the framework with the config file.
Fuel::init('config.php');
