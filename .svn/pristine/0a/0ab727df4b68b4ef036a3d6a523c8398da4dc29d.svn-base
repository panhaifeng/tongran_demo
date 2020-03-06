<?php
define('APP_DIR','Lib/App');
define('DEPLOY_MODE', true);//定义为发布模式，不写日志
require('Lib/FLEA/FLEA.php');
FLEA::loadAppInf("Config/config.inc.php");
FLEA::import('Lib/App');
FLEA::runMVC();
?>