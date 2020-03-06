<?php
define('APP_DIR','Lib/App');
require('Lib/FLEA/FLEA.php');
FLEA::loadAppInf("Config/config.inc.php");
FLEA::import('Lib/App');
FLEA::runMVC();
?>