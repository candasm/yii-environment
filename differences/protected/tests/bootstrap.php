<?php

include_once __DIR__ . '/../vendors/yiiext/environment/Environment.php';
$environment = new Environment('test');
$environment->setConfigFolder(__DIR__.'/../config/');
$environment->load();
$yiit = $environment->getYiitPath();
$config = $environment->getConfig();
require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');
Yii::createWebApplication($config);