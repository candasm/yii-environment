<?php

include_once dirname(__FILE__) . '/protected/vendors/yiiext/environment/Environment.php';
$environment = new Environment();
$environment->setConfigFolder(dirname(__FILE__)."/protected/config/");
$yii = $environment->getYiiPath();
$config = $environment->getConfig();
require_once($yii);
Yii::createWebApplication($config)->run();