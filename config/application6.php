<?php

session_start(); 
$config_dir = dirname( __FILE__);
$root_dir = str_replace("/config", "", $config_dir);//line for all time replace config with nothing
define('ROOT_DIR', $root_dir);
unset($root_dir, $config_dir);



require_once(ROOT_DIR.'/config/constants.php');

require_once 'PEAR.php';
require_once("DB.php");
require_once 'DB/DataObject.php';


require_once(HTML_DIR.'/template.php');
require_once(LIB_DIR.'/model/class.polls.php');

 

 
// frequently used functions...
require_once (LIB_DIR."/html_functions.php");
require_once (LIB_DIR."/formfunctions.php");
 


$dsn = "mysqli://alon:qwerty@localhost/dec";
$conn =& DB::connect ($dsn);
  if (DB::isError ($conn))
  die ("Cannot connect: " . $conn->getMessage () . "\n");
$do = DB_DataObject::factory('polls');
$do->Query('SET NAMES "utf8"');     
 

$conn =& DB::connect ($dsn);
  if (DB::isError ($conn))
  die ("Cannot connect: " . $conn->getMessage () . "\n");



// Mysql...
require_once(LIB_DIR.'/mydb.php');
$db = new MyDb(); // Running on Windows or Linux/Unix?
$db->execute_query("SET NAMES 'utf8'");
 



?>