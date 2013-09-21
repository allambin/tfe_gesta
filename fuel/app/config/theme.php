<?php
// has nothing to do with twig // only for assets, no views

//return array(
//    'active' => 'default',
//    'fallback' => 'default',
//    'paths' => array(
//        DOCROOT.'themes',
//    ),
//    'assets_folder' => 'assets',
//    'view_ext' => '.twig',
//    'info_file_name' => 'theme.info',
//    'require_info_file' => false,
//    'info_file_type' => 'twig',
//    'use_modules' => true,
//);

return array(
    'active' => 'default',
    'fallback' => 'default',
    'paths' => array(
        APPPATH.'themes',
        DOCROOT.'themes',
    ),
    'assets_folder' => 'assets',
    'view_ext' => '.twig',
    'info_file_name' => 'theme.info',
    'require_info_file' => false,
    'info_file_type' => 'twig',
    'use_modules' => true,
);