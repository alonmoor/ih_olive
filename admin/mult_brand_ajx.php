<?php
 require_once ("../config/application.php");
 require_once ("../lib/model/DBobject3.php");
 require_once ("../lib/model/brands_class.php");
 require_once (LIB_DIR.'/model/find_class.php');
 global $lang;

 $showform=TRUE;
 if(!isAjax())
 html_header();

  global $db;

 $brand = new brands();

 if( (array_item($_REQUEST,'insertID'))){
  $insertID=$_REQUEST['insertID'];
  $formdata['insertID'] = $insertID;

  $sql="select parentDecID1 from decisions where decID=$insertID ";
  if($rows=$db->queryObjectArray($sql)  ){
  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
  $parent=$rows[0]->parentDecID1;
  	$brand->print_decision_entry_form1_b($parent);
  	}
  }
  echo '<fieldset class="my_pageCount" >';
  $brand->print_decision_entry_form1_b($insertID);
   echo '</fieldset class="my_pageCount" >';
  build_form($formdata);
   $brand->print_form_paging_b();
 }else{
if(!empty($formdata))
 	build_form($formdata);
else{
    $formdata =array();
    build_form($formdata);
}
 	// $brand->print_form_paging_b();
 	 $formdata=false;

 }

?> 

       
 
  
