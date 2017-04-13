<?php

  session_start();
$config_dir = dirname( __FILE__);
$root_dir = str_replace("/config", "", $config_dir);//line for all time replace config with nothing
define('ROOT_DIR', $root_dir);
unset($root_dir, $config_dir);



require_once(ROOT_DIR.'/config/constants.php');


 
require_once(HTML_DIR.'/template_test.php');
//require_once(LIB_DIR.'/model/class.polls.php');
//require_once(LIB_DIR.'/model/JavaScript.php');
//require_once(LIB_DIR.'/model/Prototype.php');
//require_once(LIB_DIR.'/model/Scriptaculous.php');
//require_once(LIB_DIR.'/model/taskslist.class.php');
//require_once(LIB_DIR.'/model/class.polls.php');
 

 
// frequently used functions...
require_once (LIB_DIR."/html_functions.php");
require_once (LIB_DIR."/formfunctions.php");
require_once(ROOT_DIR.'/config/dbtreeview_config.php');

$dsn = "mysqli://alon:qwerty@192.168.0.204/dec"; 


  // $polls = DB_DataObject::factory('polls');
    //    if (PEAR::isError($polls)) {    die($polls->getMessage() . '<br />' . $polls->getDebugInfo());} 
     // $query= "SET NAMES 'utf8'" ; 
      //$conn->query($query);
      //$polls->query($query);
   
        

 


// Mysql...
require_once(LIB_DIR.'/mydb.php');
$db = new MyDb(); // Running on Windows or Linux/Unix?
$db->execute_query("SET NAMES 'utf8'");
 
//$projax= new Projax();
function isAjax() {
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}



 
 
 
 
 



?>