<?php
require_once '../config/application.php';
require_once (LIB_DIR.'/model/forum_class.php');
require_once ("../lib/model/DBobject3.php");
 
 /*************************************************************************************************************/
if(!isAjax() ){
  html_header();
 }
/*********************************************/
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
/*********************************************/ 

$frm= new forum_dec();
$frm->link_div();

$formdata['forum_demo_last8']=1;
 if( (array_item($_REQUEST,'insertID'))){ 
	  $insertID=$_REQUEST['insertID'];
	  $formdata['insertID']=$insertID;
     $formdata['forum_demo_last8']=1;
  
  $frm->print_forum_entry_form_b ($insertID);
 

	  build_form($formdata);
   
	 $frm->print_forum_paging_b();
  
	 }else{

	 	 
	 build_form($formdata);
	 
	 $frm->print_forum_paging_b();
	}
/*****************************************************************************************/		 
/*****************************************************************************************/
   
?> 

 

  
 
  
 