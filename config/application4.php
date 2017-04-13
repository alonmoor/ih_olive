<?php
session_start();
$config_dir = dirname( __FILE__);
$root_dir = str_replace("/config", "", $config_dir);//line for all time replace config with nothing
define('ROOT_DIR', $root_dir);
unset($root_dir, $config_dir);



//========================
require_once(ROOT_DIR.'/config/constants.php');



require_once(HTML_DIR.'/template2.php');


require_once (LIB_DIR."/html_functions.php");
require_once (LIB_DIR."/formfunctions.php");
  

// Mysql...
require_once(LIB_DIR.'/mydb.php');
$db = new MyDb(); // Running on Windows or Linux/Unix?
$db->execute_query("SET NAMES 'utf8'");
 



?>