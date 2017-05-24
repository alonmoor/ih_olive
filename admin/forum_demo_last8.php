<?php
//phpinfo();
require_once '../config/application.php';
require_once (LIB_DIR.'/model/Brand.php');
require_once (LIB_DIR."/model/DBobject3.php");
require_once (LIB_DIR."/model/digiBook.php");
//include "cron.php";
if(!isAjax() ){
  html_header();
}

//$srv1 = PHP_BINDIR;//s$_SERVER['PHP_BINDIR'];
//var_dump($srv1);
$phpbin = preg_replace("@/lib(64)?/.*$@", "/bin/php", ini_get("extension_dir"));


$ctx = stream_context_create(array(
        'http' => array(
            'timeout' => 1
        )
    )
);
//$result = file_get_contents("/home/alon/Desktop/4.4.17/*.pdf;", 0, $ctx);
//$x=1;

///////////////////////////////


var_dump($phpbin);
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }

$brand = new brand();
//$brand->link_div();

$formdata['forum_demo_last8']=1;
 if( (array_item($_REQUEST,'insertID'))){ 
	  $insertID=$_REQUEST['insertID'];
	  $formdata['insertID']=$insertID;
     $formdata['forum_demo_last8']=1;
  
  $brand->print_forum_entry_form_c ($insertID);
 

	  build_form($formdata);
   
	 $brand->print_forum_paging_b();
  
	 }else{

	 	 
	 build_form($formdata);
	 
	 $brand->print_forum_paging_b();
	}

?> 

 

  
 
  
 