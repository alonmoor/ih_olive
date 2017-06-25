<?php
require_once '../config/application.php';
require_once (LIB_DIR.'/model/Brand.php');
require_once (LIB_DIR."/model/DBobject3.php");
require_once (LIB_DIR."/model/digiBook.php");
if(!isAjax() ){
  html_header();
}
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
$formdata['brand_plan']=1;
 if( (array_item($_REQUEST,'insertID'))){ 
	  $insertID=$_REQUEST['insertID'];
	  $formdata['insertID']=$insertID;
     $formdata['forum_demo_last8']=1;
  
  //$brand->print_forum_entry_form_c ($insertID);


	  build_form($formdata);
   
	// $brand->print_forum_paging_b();
  
	 }else{

	 	 
	 build_form($formdata);
	 
	 $brand->print_brand_paging();
	}

?> 

 

  
 
  
 