<?php

//css+images+js==document_root
// root www.
 
define('ROOT_WWW','');
 //define('ROOT_WWW','/alon-web/olive');
 


//$root_www = str_replace('/config', '',  dirname(__FILE__));
//  define('ROOT_WWW', $root_www);



//echo dirname(__FILE__) . '<br/> '.  $_SERVER['DOCUMENT_ROOT'];

//$root_dir_tmp =   str_replace('/config', '',  dirname(__FILE__));
//$root_www =  str_replace($_SERVER['DOCUMENT_ROOT'], '', $root_dir_tmp) ;
//define('ROOT_WWW',$root_www); 
 
  

define('SITE_DIR',ROOT_DIR . "/site");
define('SITE_WWW_DIR',ROOT_WWW . "/site");



define('POLLS_DIR', ROOT_DIR . "/polls");
define('POLLS_WWW_DIR', ROOT_WWW . "/core/polls"); 
 
// lib dir -
define('LIB_DIR', ROOT_DIR . "/lib");
define('LIB_WWW_DIR', ROOT_WWW . "/lib");


define('TASK_DIR', ROOT_DIR . "/mytinytodo_a");
define('TASK_WWW_DIR', ROOT_WWW . "/mytinytodo_a");


define('TASK2_DIR', ROOT_DIR . "/mytinytodo_b");
define('TASK2_WWW_DIR', ROOT_WWW . "/mytinytodo_b");
 
define('FORUMDEC_DIR', ROOT_DIR . "/show_decForum");
define('FORUMDEC_WWW_DIR', ROOT_WWW . "/show_decForum");

define('PROTO_DIR', ROOT_DIR . "/PrototypeExamples");
define('PROTO_WWW_DIR', ROOT_WWW . "/PrototypeExamples");


define('TASK_DIR1', ROOT_DIR . "/mytinytodo_1");
define('TASK_WWW_DIR1', ROOT_WWW . "/mytinytodo_1");


// images dir - placed all the images
define('IMAGES_DIR', ROOT_WWW . "/images");
define("TREEVIEW_LIB_PATH",ROOT_WWW . "/lib/model");


define('TAMPLATE_IMAGES_DIR', ROOT_WWW . "/images/tamplate");
define('TAMPLATE_BUTTONS_DIR', ROOT_WWW . "/images/buttons");
define('TASK_IMAGES_DIR', ROOT_WWW . "/images/taskImages");
/*************************************************************/
 //define("DEFAULT_ADD_ICON", TAMPLATE_IMAGES_DIR."/add.gif");
  
// html dir - placed all the html form etc..
define('HTML_DIR', ROOT_DIR . "/html");
define('HTML_WWW_DIR', ROOT_WWW . "/html");


define ('CSS_DIR',HTML_WWW_DIR . "/css"); 
define ('CSS_WWW_DIR',HTML_WWW_DIR . "/css");


define("ADMIN_DIR",ROOT_DIR . "/admin");
define("ADMIN_WWW_DIR",ROOT_WWW . "/admin");



define ('PDF_DIR',HTML_DIR . "/pdfs/");
define ('PDF_WWW_DIR',HTML_WWW_DIR . "/pdfs/");




define ('CONVERT_PDF_TO_IMG_DIR', ROOT_DIR .'/images/convertPdfToImg');
define('CONVERT_PDF_TO_IMG_WWW_DIR', ROOT_WWW ."/images/convertPdfToImg");






define("TS2_ADMIN_WWW",ADMIN_WWW_DIR . "/tasklist2");


 define("JS_ADMIN_WWW",ADMIN_WWW_DIR . "/js");
 
  define("XSL_ADMIN_WWW",ADMIN_WWW_DIR . "/xsl");
 
define("JQ_ADMIN_WWW",ADMIN_WWW_DIR . "/jquery");


define("INCLUDES_DIR",ROOT_DIR . "/");
define("INCLUDES_WWW_DIR",ROOT_WWW . "/includes");

define("USER_DIR",ROOT_DIR . "/");
define("USER_WWW_DIR",ROOT_WWW . "/");

define("WORD_COUNT_MASK", "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u");
 /* set version number */
define("VERSION", "1.0");                              // apps version

/* assign php configuration variables */
ini_set("track_errors", "1");                          // error tracking

/* assign base system constants */
define("SITE_URL", "http://olive");     // base site url
//define("SITE_URL", "מערכת השאלות");

//define("SITE_DIR", "/");                               // base site directory
define("BASE_DIR", $_SERVER["DOCUMENT_ROOT"]);         // base file directory
define("SELF", $_SERVER["PHP_SELF"]);                  // self file directive
define("FILEMAX", 1500000);                             // file size max

/* assign base database constants */
define("PREFIX", "wrox");                              // database table prefix
define("TIMEOUT", 3600);                               // timeout (seconds)
define("ROWCOUNT", 5);                                // rows to show per page
define("DSN", "mysql://alon:qwerty@127.0.0.1/olive"); // DSN for PEAR usage

/* assign base mail constants */
define("SMTP_HOST", "127.0.0.1");                      // SMTP hostname
define("SMTP_PORT","25");                              // SMTP port default=25
define("FROM_NAME","DVD Life");                        // newsletter from name
define("FROM_EMAIL","info@eh.co.il");      // newsletter from email

/* assign base entity constants */
define("TITLE", "olive");                        // base page title
define("ENTITY", "מערכת סקר שאלות");                          // entity name
define("EMAIL", "alonmor2@gmail.com");               // admin email

/* assign instance variables */
$EXCEPTS = array();                                    // exceptions array
$ERRORS = array();                                     // errors array
$FILES = array("jpg", "gif", "png");                   // file types array
$FORMOK = true;                                       // form status


define('ROWS_PER_VIEW', 10);


//set_magic_quotes_runtime(1);                           // magic quotes on


# Language pack
$config['lang'] = "en";

$config = array();

 

define ('BASE_URI',ROOT_WWW. '/get_in_out2/'); 
define ('BASE_URL', '127.0.0.1');  
define ('PDFS_DIR', ROOT_DIR . '/get_in_out2/pdfs/');  


//define('DB_HOST', '192.168.0.204');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'alon');
 define('DB_PASSWORD','qwerty');
 define('DB_TBL_PREFIX', '');

 
 
//define('DB_DATABASE','dec_tests');
//define('DB_SCHEMA', 'dec_tests');


 define('DB_DATABASE','pdf');
 define('DB_SCHEMA', 'pdf');



//define('DB_DATABASE','dec_test');
//define('DB_SCHEMA', 'dec_test');

 
 //define('DB_DATABASE','');
//define('DB_SCHEMA', 'dec');
 


//define('TAMPLATE_PAGE_DIR', ROOT_DIR . "/get_in_out2");

//define('INCLUDES_DIR', TAMPLATE_PAGE_DIR.'/html/includes');

//define ('PDFS_DIR', BASE_URI . 'pdfs/');
//define ('MYSQL', ROOT_DIR . "/mysql.inc.php");
//define ('MYSQL', BASE_URI . "mysql.inc.php");

 

# Specify password here to protect your tasks from modification,
#  or leave empty that everyone could read/write todolist
//$config['password'] = "1";

# Restrict access for the others when password above is set:
#  "no" - No access, "read" - Read only
//$config['allow'] = "no";

# To disable smart syntax uncomment the line below
#$config['smartsyntax'] = 0;

# To disable auto detecting user time zone uncomment the line below
#$config['autotz'] = 0;

# To disable auto adding selected tag  comment out the line below or set value to 0
//$config['autotag'] = 1;

# duedate calendar format: 1 => y-m-d (default), 2 => m/d/y, 3 => d.m.y
//$config['duedateformat'] = 1;

# select session handling mechanism: files or default (php default)
//$config['session'] = 'files';

//$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';

?>
