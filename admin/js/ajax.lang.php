<?php

require_once ("../config/application.php");
require_once(LIB_DIR.'/model/class.default.php');
require_once(LIB_DIR.'/model/en.php');
//$lang = new Lang();
global $lang;

//$l = new Lang();

//header('Content-type: text/javascript');
echo $lang->makeJS();

?>