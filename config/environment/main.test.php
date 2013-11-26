<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'YII_PATH' =>'{frameworkpath}/framework/yiilite.php',
    'YIIC_PATH' =>'{frameworkpath}/framework/yiic.php',
    'modules' => array(),
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