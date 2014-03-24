<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
/**
 * Environment ortamlarında ortak kullanılacak olan ayarlar 
 * environment config dosyaları üzerine birleştirleceğinden 
 * alanlar tekrarlandığında environment config dosya bilgisi 
 * baz alınır.
 */
return array(
    "YII_PATH" => "{frameworkpath}/framework/yii.php",
    "YIIC_PATH" =>"{frameworkpath}/framework/yiic.php",        
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '',    
    // preloading 'log' component
    'preload' => array('log'),
    // application components
    'components' => array(
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
);