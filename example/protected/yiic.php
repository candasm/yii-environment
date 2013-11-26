<?php

include_once dirname(__FILE__) . '/../../Environment.php';
$environment = new Environment('console');
$environment->setConfigFolder(dirname(__FILE__).'/config/');
$environment->load();
$yiic = $environment->getYiicPath();
$config = $environment->getConfig();
require_once($yiic);
