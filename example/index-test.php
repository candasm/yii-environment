<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

include_once dirname(__FILE__) . '/../Environment.php';
$environment = new Environment('test');
$yii = $environment->getYiiPath();
$config = $environment->getConfig();
require_once($yii);
Yii::createWebApplication($config)->run();
