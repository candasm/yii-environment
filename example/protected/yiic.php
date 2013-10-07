<?php

include_once dirname(__FILE__) . '/../../Environment.php';
$environment = new Environment('console');
$yiic = $environment->getYiicPath();
$config = $environment->getConfig();
require_once($yiic);
