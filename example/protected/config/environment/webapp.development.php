<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    //settings for environment class
    'YII_PATH' => '/framework/yii.php',
    'YIIC_PATH' => '/framework/yiic.php',
    'YII_DEBUG' => TRUE,
    'YII_TRACE_LEVEL' => 3,
    'name' => 'Development',
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=test',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ),
        'log' => array(
            'routes' => array(
                array(
                    'class' => 'CWebLogRoute',
                    'showInFireBug' => true,
                    'levels' => 'info',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
    ),
);