<?php

include_once dirname(__FILE__) . '/../Environment.php';
$environment = new Environment();
$yii = $environment->getYiiPath();
$config = $environment->getConfig();
require_once($yii);
Yii::createWebApplication($config)->run();
