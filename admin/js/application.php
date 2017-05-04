<?php
session_start();
$config_dir = dirname( __FILE__);
$root_dir = str_replace("/config", "", $config_dir);//line for all time replace config with nothing
define('ROOT_DIR', $root_dir);
unset($root_dir, $config_dir);


//$dir=dirname(__FILE__)."/";






require_once(ROOT_DIR.'/config/constants.php');


 
require_once(HTML_DIR.'/template.php');
 

 
// frequently used functions...
require_once (LIB_DIR."/html_functions.php");
require_once (LIB_DIR."/formfunctions.php");

require_once (LIB_DIR."/form_functions.inc.php");
require_once(ROOT_DIR.'/config/dbtreeview_config.php');


//$dsn = "mysqli://alon:qwerty@192.168.0.204/dec"; 

   
        

// Mysql...
require_once(LIB_DIR.'/mydb.php');
$db = new MyDb(); // Running on Windows or Linux/Unix?
$db->execute_query("SET NAMES 'utf8'");
 





 
function isAjax() {
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}



function ae_detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
} 


 require_once(LIB_DIR.'/model/en.php');
  $lang= new Lang();

  
 
function  __($s)
	{
		 
		  global $lang;
		echo $lang->get($s);
	 }
 


 


