<?php  
/****************************************************************************************************************************************/			
		
function build_form(&$formdata) {
		global $db;

        if($formdata['dynamic_6']==1)
        form_start( "dynamic_8.php" ,$name="" );
        else
		 form_start($_SERVER['SCRIPT_NAME'],$forum_name="forum" );
        ?>
     
<!--    <table class="myformtable1" align="center">     -->
<!--     <form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">      -->
       
    
 
    <?php
		$dates = getdate();


/****************************************************************************************/
form_new_line();
	   
/***************************************************************************************/

	   
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats_a[$row->parentForumID][] = $row->forum_decID;
			$catNames_a[$row->forum_decID] = $row->forum_decName;
            
//			$subcats_b[$row->parentForumID][] = $row->forum_decID;
//			$catNames_b[$row->forum_decID] = $row->forum_decName;  
		
		
		}

			$rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
			//$rows1 = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
		
		echo '<td   class="myformtd"  norwap >'; 
		 form_label_red1 ("שם הפורום:", TRUE); 		
		 form_list_b  ("forum_decision", $rows , array_item($formdata, "forum_decision") );
		// form_list_find_notd ("forum_decision", "forum_decision",$rows , array_item($formdata, "forum_decision") );

		//echo '<td  class="contextual_help newforum">';
		// form_empty_cell_no_td(1); 
		 form_label1("שם פורום חדש",TRUE);
		 form_text_a("newforum", array_item($formdata, "newforum"),  20, 50, 1);
		// form_empty_cell_no_td(10); 
		 form_label1("קשר לפורום",TRUE);
		 form_list_b  ("insert_forum", $rows , array_item($formdata, "insert_forum") );
/***************************************************************************************/
	?> 
       
        
          <script  language="JavaScript" type="text/javascript">
//                $(document).ready(function(){
//	           	$('#forum_date').datepicker( $.extend({}, {showOn: 'button',
//		                               buttonImage: '<?php echo IMAGES_DIR ;?>/calendar.gif', buttonImageOnly: true,
//		                               changeMonth: true,
//				                       changeYear: true,
//				                       dateFormat: 'yy-mm-dd'}, $.datepicker.regional['he'])); 
//                 	});

            </script>
        <?php  		     	     
/*****************************************************************************************/	  
		 form_label_red1("תאריך הקמה:",true);
         form_text3("forum_date", array_item($formdata, "forum_date"),  10,10, 1,'forum_date');
         form_url2("forum_category.php","ערוך פורומים",2 );
	    echo '</td>';	
	    
	      
	    
	    
	    
	    

	     
	     	
		 form_end_line();
/******************************************************************************************************/		 
//			// category
//			form_new_line();
//			
//				
//			$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
//			$rows = $db->queryObjectArray($sql);
//				
//			foreach($rows as $row) {
//				$subcats1[$row->parentCatID][] = $row->catID;
//				$catNames1[$row->catID] = $row->catName; }
//
//				$rows = build_category_array($subcats1[NULL], $subcats1, $catNames1);
//
//				
//				echo '<td   class="myformtd"   norwap>'; 
//		         form_label_red1("סוג הפורום:",TRUE);
//		         form_list_b("category", $rows , array_item($formdata, "category"));
//                 form_empty_cell_no_td(9);     
//		         form_label1("סוג חדש",TRUE);
//		         form_text_a("new_category", array_item($formdata, "new_category"),  20, 50, 1);
//		         form_empty_cell_no_td(7); 
//		         
//		          form_label1("קשר לקטגוריה",TRUE);
//		         form_list_b("insert_category", $rows , array_item($formdata, "insert_category"));
//		         form_url2("categories1.php","ערוך קטגוריות",2 );
//		         echo '</td>';
//		         
//				 
//                 
//                
//				form_end_line();
/*****************************************************************************************/
		 
				
		// forum_dec
		form_new_line();
		
		$sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
	    $rows = $db->queryObjectArray($sql);
	    
  		foreach($rows as $row) {
	    $subcats22[$row->parentAppointID][] = $row->appointID;
	    $catNames22[$row->appointID] = $row->appointName; }

	// build hierarchical list
	    $rows = build_category_array($subcats22[NULL], $subcats22, $catNames22);
	    $rows1 = build_category_array($subcats22[NULL], $subcats22, $catNames22);
		  echo '<td  norwap class="myformtd">'; 
           form_label_red1("ממנה פורום:", TRUE);		  
		   form_list_b("appoint_forum" ,$rows, array_item($formdata,"appoint_forum"));      
		        
 		
          


		$sql = "SELECT full_name,userID FROM users ORDER BY full_name";
		$rows= $db->queryArray($sql);
	    form_empty_cell_no_td(23);
         form_label1("גוף ממנה חדש",TRUE);
         form_list_b ("new_appoint",$rows, array_item($formdata, "new_appoint"));         
       
		form_empty_cell_no_td(8);
         form_label1("קשר לממנה:", TRUE);		  
		 form_list_b("insert_appoint" ,$rows1, array_item($formdata,"insert_appoint"));
		
		 if($formdata['appoint_date'])
		 $formdata['appoint_date1']=$formdata['appoint_date'];
		form_empty_cell_no_td(22);
		form_label_red1("תאריך ממנה",TRUE); 
	    form_text3("appoint_date1", array_item($formdata, "appoint_date1"),  20, 50, 1,'appoint_date1'); 
	    form_url2("appoint_edit.php","ערוך ממני פורום",2 );      
		echo '</td>';        
        
	    
	    
	    
	   
	    
            
		form_end_line();

				// forums_dec
				form_new_line();
				
				$sql = "SELECT managerName,managerID,parentManagerID FROM managers ORDER BY managerName";
				$rows = $db->queryObjectArray($sql);
				
				
				foreach($rows as $row) {
			      $subcats6[$row->parentManagerID][] = $row->managerID;
			      $catNames6[$row->managerID] = $row->managerName; }
			       // build hierarchical list
			      $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			      $rows1 = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			      
			      echo '<td  nowrap class="myformtd" >'; 
			      form_label_red1("מנהל פורום:", TRUE);
		          form_list_b("manager_forum" , $rows, array_item($formdata, "manager_forum"));
		         
				 
				
/***********************************************************************************************/		
			
/**********************************************************************************************/

        $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
		$rows= $db->queryArray($sql);
		
		 form_empty_cell_no_td(22);
		
         form_label1("שם מנהל חדש",TRUE);
         form_list_b ("new_manager",$rows, array_item($formdata, "new_manager"));         
         form_empty_cell_no_td(9); 
        form_label1("קשר למנהל:", TRUE);
		form_list_b("insert_manager" , $rows1, array_item($formdata, "insert_manager"));
		         
         
       form_empty_cell_no_td(20);
        form_label_red1("תאריך מינוי מנהל",TRUE);
        form_text3("manager_date", array_item($formdata, "manager_date"),  20, 50, 1,'manager_date');  
        form_url2("manager.php","ערוך מנהלים",2 );   
        echo '</td>';
        
  
  form_end_line();
  /**********************************************************************************************/
  
		
//                // category
//			form_new_line();
//			
//				
//			$sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
//			$rows = $db->queryObjectArray($sql);
//				
//			foreach($rows as $row) {
//				$subcats4[$row->parentManagerTypeID][] = $row->managerTypeID;
//				$catNames4[$row->managerTypeID] = $row->managerTypeName; }
//
//				$rows = build_category_array($subcats4[NULL], $subcats4, $catNames4);
//				echo '<td  nowrap class="myformtd">';  
//				 form_label_red1("סוגי מנהלים:",TRUE);
//		         form_list_b("managerType", $rows , array_item($formdata, "managerType"));
//		         
//				form_empty_cell_no_td(7);			         
//		        form_label1("סוג מנהל חדש",TRUE);
//				form_text_a("new_type", array_item($formdata, "new_type"),  20, 50, 1);
//				 form_empty_cell_no_td(1);	
//				form_label1("קשר למנהל:",TRUE);
//		         form_list_b("insert_managerType", $rows , array_item($formdata, "insert_managerType"));
//				form_url2("manager_category.php","ערוך סוגי מנהלים",2 );
//		         
//			 
//				  
//                //form_label("");   
//				form_end_line();
 
/******************************************************************************************************************************/
 form_new_line();
  echo '<td class="myformtd"  >';
  form_label_red1("סטטוס פורום: (1=פתוח /0=סגור )", TRUE);
  form_text_a("forum_status", array_item($formdata, "forum_status"), 5 , 50 , 1);
  echo '</td>';				 
 
 		
 form_end_line();

/************************************************************************************************/
 /*************************************FORUMF_TYPE*****************************************************************/  

form_new_line();

$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
			$rows = $db->queryObjectArray($sql);
				
			foreach($rows as $row) {
				$subcatsftype[$row->parentCatID][] = $row->catID;
				$catNamesftype[$row->catID] = $row->catName; }

				$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
				$rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
 
    echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';
    form_label_red("הזנת  סוגי הפורום:", TRUE); 
    echo '<td class="myformtd">';
    
   

    
    form_list111("src_forumsType" , $rows, array_item($formdata, "src_forumsType"),"multiple size=6 id='src_forumsType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");		      
 
    echo '</td>'; 
  
    
    
if($formdata['dest_forumsType'] && $formdata['dest_forumsType']!='none'){	 		
 

 
 $dest_forumsType= $formdata['dest_forumsType'];
 
foreach ($dest_forumsType as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select catID, catName from categories1 where catID in ($staffb)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_b[$row->catID]=$row->catName;
	}
      $name=array_merge($name,$name_b);
       unset($staff_testb);
}else{
$staff=implode(',',$formdata['dest_forumsType'])	;		
			
$sql2="select catID, catName from categories1 where catID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			//$name[]=$row->catName;
			
  }
}  
  
?>

   <td class="myformtd"> 
 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));">

 
 	</td>
  
 
<? 





	  form_list11("dest_forumsType" , $name, array_item($formdata, "dest_forumsType"),"multiple size=6 id='dest_forumsType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forumsType'));\"");
   
 
 
  
}elseif($formdata['src_forumsType'] && $formdata['src_forumsType'][0]!=0 && !$formdata['dest_forumsType']){
	
$dest_types= $formdata['src_forumsType'];
 
  for($i=0; $i<count($dest_types); $i++){
				if($i==0){
					$userNames =$dest_types[$i];
				}
				else{
					$userNames .= "," . $dest_types[$i];

				}
				 
			}    
	
		
$name=explode("," ,$userNames);

$sql2="select catID,catName from categories1 where catID in ($userNames)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			
  }	
		  

?>

 <td class="myformtd"> 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));">	
</td>
  

<?  	
 form_list11("src_forumsType" , $name, array_item($formdata, "src_forumsType"),"multiple size=6 id='src_forumsType' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");

 
 
}else{	

		 
?>
		 
  <td class="myformtd">
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));">
	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));">
  </td>
		 
		 
		 
<td class="myformtd">
  <select class="mycontrol"  name='arr_dest_forumsType[]' dir=rtl id='dest_forumsType' ondblclick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"  MULTIPLE SIZE=6 style='width:180px;' ></select>
</td>
		
<?	
		
	          
		 

}
	              form_label("סוג פורום חדש",TRUE);
		          form_textarea("new_forumType", array_item($formdata, "new_forumType"),14, 5, 1); 
                  form_label("קשר לסוג פורום",TRUE);
                  
                  if(array_item($formdata, "insert_forumType") ){
                  form_list1idx ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"),"multiple size=6");
                  }else
                  form_list1 ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"),"multiple size=6");
                 
						
					 
					  
  form_url("categories1.php","ערוך סוגי פורומים",1 );	
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
				 				
  
/******************************************************************************************************/  
 
/******************************************************************************************************/  

form_new_line();

$sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
			$rows = $db->queryObjectArray($sql);
				
			foreach($rows as $row) {
				$subcatsmtype[$row->parentManagerTypeID][] = $row->managerTypeID;
				$catNamesmtype[$row->managerTypeID] = $row->managerTypeName; }

				$rows = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);
	  	        $rows2 = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype); 
 
    echo '<td   class="myformtd"    align="right">
    		<table class="myformtable">
    		<tr>';
    form_label_red("הזנת  סוגי המנהלים:", TRUE); 
    echo '<td class="myformtd">';
    
   

    
     form_list111("src_managersType" , $rows, array_item($formdata, "src_managersType"),"multiple size=6 id='src_managersType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));\"");		      
 
    echo '</td>'; 
  
    
    
if($formdata['dest_managersType'] && $formdata['dest_managersType']!='none'){	 		
 $dest_managersType= $formdata['dest_managersType'];
		
foreach ($dest_managersType as $key=>$val){
	
if(!is_numeric($val)){
	$val=$db->sql_string($val);
     $staff_test[]=$val;
   
     }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
}			


if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
		
     if($rows=$db->queryObjectArray($sql))
		foreach($rows as $row){
			
       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }
}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
		
     if($rows=$db->queryObjectArray($sql))
		foreach($rows as $row){
			
       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }
    
 $staff_b=implode(',',$staff_testb);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff_b)";
		
     if($rows=$db->queryObjectArray($sql))
		foreach($rows as $row){
			
       $name_managerType_b[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }    
    $name_managerType=array_merge($name_managerType,$name_managerType_b);
    unset($staff_testb);
    
}else{
//$staff=$result["dest_managersType"];
$staff=implode(',',$formdata['dest_managersType']);			
			
$sql2="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_managerType[$row->managerTypeID]=$row->managerTypeName;
			
			
  }
  
}  
?>

   <td class="myformtd"> 
 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));">

 
 	</td>
  
 
<? 





  form_list11("dest_managersType" , $name_managerType, array_item($formdata, "dest_managersType"),"multiple size=6 id='dest_managersType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_managersType'));\"");
  
   
 
 
  
}elseif($formdata['src_managersType'] && $formdata['src_managersType'][0]!=0 && !$formdata['dest_managersType']){
	
$dest_users= $formdata['src_managersType'];
 
  for($i=0; $i<count($dest_managersType); $i++){
				if($i==0){
					$userNames =$dest_managersType[$i];
				}
				else{
					$userNames .= "," . $dest_managersType[$i];

				}
				 
			}    
	
		
$name_managerType=explode("," ,$userNames);

		
		  

?>

 <td class="myformtd"> 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));">	
</td>
  

<?  	
 form_list11("src_managersType" , $name_managerType, array_item($formdata, "src_managersType"),"multiple size=6 id='src_managersType' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));\"");

 
 
}else{	

		 
?>
		 
  <td class="myformtd">
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));">
	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));">
  </td>
		 
		 
		 
<td class="myformtd">
  <select class="mycontrol"  name='arr_dest_managersType[]' dir=rtl id='dest_managersType' MULTIPLE SIZE=6  ondblclick="remove_item_from_select_box(document.getElementById('dest_managersType'));"  style='width:180px;' ></select>
</td>
		
<?	
		
	          
		 

}
	              form_label("סוג מנהל חדש",TRUE);
		          form_textarea("new_managerType", array_item($formdata, "new_managerType"),14, 5, 1); 
                  form_label("קשר לסוג למנהל",TRUE);
                  if(array_item($formdata, "insert_managerType") )
                  form_list1idx ("insert_managerType" , $rows2, array_item($formdata, "insert_managerType"),"multiple size=6");
                  else
                  form_list1 ("insert_managerType" , $rows2, array_item($formdata, "insert_managerType"),"multiple size=6");
                  
                 
						
					 
					  
  form_url("manager_category.php","ערוך סוגי מנהלים",1 );	
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
				 				
  
/******************************************************************************************************/ 
 
/******************************************************************************************************************************/
form_new_line();

    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
	$rows = $db->queryArray($sql);	 
	  	
//<table class="myformtable">
    echo '<td   class="myformtd">
    		<table class="myformtable">
   		<tr>';
    form_label("הזנת  חברי פורום:", TRUE); 
    echo '<td class="myformtd">';
    
    form_list111("src_users" , $rows, array_item($formdata, "src_users"),"multiple size=6 id='src_users' style='width:200px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));\"");		      
    echo '</td>'; 
  
    
    
if($formdata['dest_users'] && $formdata['dest_users']!='none' && count($formdata['dest_users'])>0    ){	 		
 $dest_users= $formdata['dest_users'];
/*******************************************************************************/
//
// foreach ($dest_users as $row){
//	
//	if(!$result["dest_users"])
//				$result["dest_users"] = $row[userID] ;
//				else
//				$result["dest_users"] .= "," . $row[userID] ;
//	
//}			
 /***************************************************************************/
foreach ($dest_users as $key=>$val){
	
	if(!$result["dest_users"])
				$result["dest_users"] = $key;
				else
				$result["dest_users"] .= "," . $key;
	
}			



$staff=$result["dest_users"];			
			
$sql2="select userID, full_name from users where userID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->userID]=$row->full_name;
			
  }
  
$i=0;  
?>

   <td class="myformtd"> 
 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_users'));">

 
 	</td>
  
 
<? 





	  form_list11("dest_users" , $name, array_item($formdata, "dest_users"),"multiple size=6 id='dest_users' style='width:200px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_users'));\"");
    
 
 
  
}elseif($formdata['src_users'] && $formdata['src_users'][0]!=0 && !$formdata['dest_users']){
	
$dest_users= $formdata['src_users'];
 
  for($i=0; $i<count($dest_users); $i++){
				if($i==0){
					$userNames =$dest_users[$i];
				}
				else{
					$userNames .= "," . $dest_users[$i];

				}
				 
			}    
	
		
$name=explode("," ,$userNames);

		
		  

?>

 <td class="myformtd"> 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_users'));">	
</td>
  

<?  	
 form_list11("src_users" , $name, array_item($formdata, "src_users"),"multiple size=6 id='src_users' ondblclick=\"add_item_to_select_box(document.getElementById('src_users'), document.getElementById('src_users'));\"");

 
 
}else{	

		 
?>
		 
  <td class="myformtd">
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));">
	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_users'));">
  </td>
		 
		 
		 
<td class="myformtd">
  <select class="mycontrol"  name='arr_dest_users[]' dir=rtl id='dest_users' MULTIPLE SIZE=6 style='width:200px;' ondblclick="remove_item_from_select_box(document.getElementById('dest_users'));" ></select>
</td>
		
<?	
		
	          
		 

}
		
  form_url("users.php","ערוך משתמשים",1 );	
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
				
				
/******************************************************************************************************/  
 
				/******************************************************************************************************/  
 
/*********************************************************************************************************/
if( ($formdata['forum_decID']) &&  ($formdata['forum_decID'])!='none' ){
if(array_item($formdata,'dest_users' ) && $formdata['dest_users']!='none'  ){

$i=0;
if(!$formdata['fail']){
/***************************************************/
foreach($formdata['dest_users'] as $key=>$val){
/**************************************************/
$member_date="member_date$i"  ;
//	
//
//$num= $db->sql_string($formdata['forum_decID']) ;	
//$sql="select rel_date ,userID from rel_user_forum where userID=$key and forum_decID=$num  ";
//$rows1=$db->queryObjectArray($sql);	
//
////if(is_array($formdata[src_users2])){
//  if( !(array_item($formdata[src_users2],$key)) ){
//  	list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->rel_date);
//   $rows1[0]->rel_date="$day_date-$month_date-$year_date";	
// 
//  
//} elseif($formdata[$member_date]!=null && $rows1[0]->rel_date!=0){
//   list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->rel_date);
//   $rows1[0]->rel_date="$day_date-$month_date-$year_date";	
///*****************************************************************************************/   
//$frm=new forum_dec();
//   $formdata1[$member_date][$rows1[0]->userID]=$formdata[$member_date];
//    if(!$frm->check_date($formdata1[$member_date][$rows1[0]->userID]) )	
//       $formdata1[$member_date][$rows1[0]->userID]=$rows1[0]->rel_date;
//   $formdata[$member_date]=$rows1[0]->rel_date;
//   
//   
//   
//   list($ayear,$amonth,$aday) = explode('-',$formdata1 [$member_date][$rows1[0]->userID]);
//  
//	 if (strlen($ayear) > 3){
//		$a = $ayear . $amonth . $aday; 
//		}elseif(strlen($aday)==4){
//     $a =$aday . $ayear . $amonth ;	
//    }	
//        
//
//   list($byear,$bmonth,$bday ) = explode('-',$formdata[$member_date]);
//    if (strlen($byear) > 3){
//		$b = $byear . $bmonth . $bday; 
//		}elseif(strlen($bday)==4){
//     $b =$bday . $byear . $bmonth ;	
//    }
//         
// if($a && $a!=0){
//  if($b && $b!=0)  
//   if($a!=$b){
///*********************************$rel_date*********************************************************/
//    if(count ($formdata['dest_users'])== count ($formdata['src_users2']) )	{
//   $rel_date= $formdata1[$member_date][$rows1[0]->userID] ;
//    }else{
//   $rel_date=$formdata[$member_date] ;
//    } 
//   list($year_date,$month_date, $day_date) = explode('-',$rel_date);
//    if(strlen($day_date)<3 ){
//    $rel_date="$year_date-$month_date-$day_date";
//    }elseif(strlen($day_date)==4){
//     $rel_date="$day_date-$month_date-$year_date";	
//    }
//    $rel_date=$db->sql_string($rel_date);
///**********************************$rel_date1************************************************/   
//  if(count ($formdata['dest_users'])>= count ($formdata['src_users2']) ){	
//      list($year_date,$month_date, $day_date) = explode('-',$formdata1 [$member_date][$rows1[0]->userID]);
//      if(strlen($year_date)>3 ){
//      $rel_date1="$day_date-$month_date-$year_date";	
//     }else
//      $rel_date1=substr($rel_date,1,10);
//  	
//  }else{
//    list($year_date,$month_date, $day_date) = explode('-',$formdata [$member_date]);
//      if(strlen($year_date)>3 ){
//      $rel_date1="$day_date-$month_date-$year_date";	
//     }else
//      $rel_date1=substr($rel_date,1,10);
//  }     
//    
//
//   $formdata[$member_date]=$rel_date1;
//   $id= $rows1[0]->userID  ;
// 
//   $sql="UPDATE rel_user_forum set rel_date=$rel_date WHERE userID=$key AND forum_decID=$num";
//   
//   if($rows=$db->execute($sql)){  
//   // $rows1[0]->rel_date=$rel_date;
//    
//    $rows1[0]->rel_date=$rel_date1;//"$day_date-$month_date-$year_date";	 
//   
//    }	
//   }
//  } 
// 
//}else{
//	list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->rel_date);
//    if(strlen($day_date)==4 ){
//    $rows1[0]->rel_date="$year_date-$month_date-$day_date";
//    }elseif(strlen($year_date)==4){
//     $rows1[0]->rel_date="$day_date-$month_date-$year_date";	
//    }
//   // $rel_date=$db->sql_string($rel_date);
//}
/**************************************************************************************/   
 form_new_line();
 
 echo '<td   class="myformtd">'; 
 form_label1("חבר פורום:");
 form_text_a("member", $val ,  20, 50, 1);
 ?> 

     <a href="<?php echo ROOT_WWW ;?>/admin/users.php?mode=update&id=<?php echo $key;?>"  >[ערוך מישתמש]</a>
     <a href="<?php echo ROOT_WWW; ?>/admin/dynamic_8.php?mode=del_usrFrm&userID=<?php echo $key;?>&forum_decID=<?php echo $formdata['forum_decID']; ?>" OnClick='return verify();' >[מחק מישתמש]</a>  

 <?PHP
// echo '</td>';
 
 /***************************************************************************************/
	?> 
          <script  language="JavaScript" type="text/javascript">
                $(document).ready(function(){
	           	$("#<?php echo  $member_date; ?>").datepicker( $.extend({}, {showOn: 'button',
		                               buttonImage: '<?php echo IMAGES_DIR ;?>/calendar.gif', buttonImageOnly: true,
		                               changeMonth: true,
				                       changeYear: true,
				                       showButtonPanel: true,
				                       buttonText: "Open date picker",
				                       dateFormat: 'yy-mm-dd',
				                       altField: '#actualDate'}, $.datepicker.regional['he'])); 
                 	});
            </script>
        <?php  

/*****************************************************************************************/	

    form_label1("תאריך צרוף לפורום:");
// form_text3 ("$member_date",$rows1[0]->rel_date,  10, 50, 1,$member_date );
    form_text3 ("$member_date",$formdata[$member_date],  10, 50, 1,$member_date );
 echo '</td>';

   form_end_line();
   
   
   
   $i++;
  }
  }else{
  	    $i=0;
    	/***************************************************/
		foreach($formdata['dest_users'] as $key=>$val){
		/**************************************************/
		$member_date="member_date$i"  ;
		 form_new_line();
 
          echo '<td   class="myformtd">'; 
	 form_label1("חבר פורום:");
	 form_text_a("member", $val ,  20, 50, 1);
	 ?> 

     <a href="<?php echo ROOT_WWW ;?>/admin/users.php?mode=update&id=<?php echo $key;?>"  >[ערוך מישתמש]</a>
     <a href="<?php echo ROOT_WWW; ?>/admin/dynamic_8.php?mode=del_usrFrm&userID=<?php echo $key;?>&forum_decID=<?php echo $formdata['forum_decID']; ?>" OnClick='return verify();' >[מחק מישתמש]</a>  

	 <?PHP
// echo '</td>';
 
 /***************************************************************************************/
	?> 
          <script  language="JavaScript" type="text/javascript">
                $(document).ready(function(){
	           	$("#<?php echo $member_date; ?>").datepicker( $.extend({}, {showOn: 'button',
		                               buttonImage: '<?php echo IMAGES_DIR ;?>/calendar.gif', buttonImageOnly: true,
		                               changeMonth: true,
				                       changeYear: true,
				                       showButtonPanel: true,
				                       buttonText: "Open date picker",
				                       dateFormat: 'yy-mm-dd',
				                       altField: '#actualDate'}, $.datepicker.regional['he'])); 
                 	});
            </script>
        <?php  

/*****************************************************************************************/	
    list($year_date,$month_date, $day_date) = explode('-',$formdata[$member_date]);
    if(strlen($day_date)==4 ){
    $formdata[$member_date]="$year_date-$month_date-$day_date";
    }elseif(strlen($year_date)==4){
     $formdata[$member_date]="$day_date-$month_date-$year_date";	
    }   
  
 form_label1("תאריך צרוף לפורום:");
 form_text3 ("$member_date",$formdata[$member_date],  10, 50, 1,$member_date );
 echo '</td>';

 form_end_line();
   
   $i++; 	
  	     
	}
  }
 }
 
}
 
/***********************************************************************************************************/
for($i=1;$i<=31;$i++){
$days[$i]= $i;
}
 $months = array ('1'=>'January','2'=> 'February','3'=> 'March','4'=> 'April','5'=> 'May','6'=> 'June','7'=> 'July','8'=> 'August','9'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December');
 $dates = getdate();
				 
 $year = date('Y');

 $end = $year;
 $start=$year - 15;
 
for($start;$start<=$end;$start++) {
 $years[$start]=$start;
} 
/************************************************************************************************/

/*******************************************************************************************************************/

if( !($formdata['multi_year'] && $formdata['multi_year']!='none')
&&  !( $formdata['multi_month'] && $formdata['multi_month']!='none')
&&  !( $formdata['multi_day'] && $formdata['multi_day']!='none') 
&& !($formdata) 
||  ($formdata && !(array_item($formdata,'dest_users') ))
){ 
form_new_line();

 

 echo '<td class="myformtd"  >';
form_label1("הזנת תאריכים לכמה משתמשים:",true);

list11("multi_year" ,$years , array_item($formdata, "multi_year"), " multiple size=6  ,id='multi_year' ondblclick=\"add_item_to_select_box(document.getElementById('multi_year'), document.getElementById('multi_year'));\"");
 
list11("multi_month" ,$months , array_item($formdata, "multi_month"), " multiple size=6,id='multi_month' ondblclick=\"add_item_to_select_box(document.getElementById('multi_month'), document.getElementById('multi_month'));\"");
 				 
list11("multi_day" ,$days, array_item($formdata, "multi_day"), " multiple size=6,id='multi_day' ondblclick=\"add_item_to_select_box(document.getElementById('multi_day'), document.getElementById('multi_day'));\"");
 
 
  echo '</td>', "\n";
   
form_end_line();	
}

/*******************************************************************************************/

 if($formdata && (array_item($formdata,'dest_users'))  ){  
 form_new_line();		

echo '<td nowrap class="myformtd"  >';
form_label1("הזנת תאריכים למשתמשים חדשים:",true);
 list11("multi_year" ,$years , array_item($formdata, "multi_year"), " multiple size=6"  );

 list11("multi_month" ,$months , array_item($formdata, "multi_month"), " multiple size=6"  );
					 
 list11("multi_day" ,$days, array_item($formdata, "multi_day"), " multiple size=6"  );

 
echo '</td>', "\n";	
 
 form_end_line(); 		
					
}
 
/********************************************************************************************/

			
				// buttons
form_new_line();


					
echo'<td class="myformtd">';				 
//form_button_no_td ("submitbutton", "שמור","Submit", "OnClick=\"return prepSelObject(document.getElementById('dest_users'));\"");

?> 
<input class="submit" type="submit" value="שמור" ,name="submitbutton"  id="submitbutton"  onclick="return  prepSelObject(document.getElementById('dest_users'));"  >
<?php 

 if(array_item($formdata,'dynamic_6') ){
 	$x=$formdata['index'];
 	$formdata["forum_decID"]=$formdata["forum_decID"][$x];			
$tmp =(array_item($formdata, "forum_decID") ) ? "update":"save" ;
	   form_hidden3("mode", $tmp,0, "id=mode_".$formdata["forum_decID"]);
	   form_hidden("forum_decID", $formdata["forum_decID"]);
	   form_hidden("insertID", $formdata["insertID"]);
 }else
 $tmp =(array_item($formdata, "forum_decID") ) ? "update":"save" ;
	   form_hidden3("mode", $tmp,0, "id=mode_".$formdata["forum_decID"]);
	   form_hidden("forum_decID", $formdata["forum_decID"]);
	   form_hidden("insertID", $formdata["insertID"]);
 
 
 
 
 
if(array_item($formdata, "forum_decID") && !$formdata['fail'] ){
	

     form_button2("btnLink1", "קשר לתת פורום");
     form_hidden("forum_decID", $formdata["forum_decID"]);


// form_button1("btnDelete", "מחק פורום", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["forum_decID"]."').value='delete'\";");
   form_empty_cell_no_td(20);
   form_button_no_td("btnDelete", "מחק פורום", "Submit","OnClick='return shalom(\"".$formdata[forum_decID]."\")'");
        
	 
   						
					
}else{
    	
     form_empty_cell_no_td(10);
     
	 form_button_no_td("btnClear","הכנס נתונים לפורום/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["btnClear"]."').value='clear'\";");
 
     
    	
	 
	 
	 
}
unset($formdata['fail']);
echo '</td>';	
// form_label("");
// form_label("");			
 form_end_line();
 

 
/************************************************************************************************/ 
 
 if(array_item($formdata, "forum_decID" )    ){ 
	
 
	  $sql = "SELECT d.decName,d.decID,d.parentDecID 
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
			     AND r.forum_decID = " . $db->sql_string($formdata['forum_decision']) .
		        " ORDER BY  d.decName ";

				
	if($rows = $db->queryObjectArray($sql)){			
	form_new_line();
     echo '<td   class="myformtd">';
      form_label1("ערוך החלטות",true);
   
     display_tree ($rows,$formdata);
    $rootAttributes = array("decID"=>"11" ); 
   
    $treeID = "treev1";
     $tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
       $string="כול ההחלטות"	;
     $tv->setRootHTMLText($string);
  
  $tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/btn_update.gif");
    $tv->printTreeViewScript();

 
	
	  echo '</td>';
 	 
     form_end_line();	
	}
} 

/****************************************************************************************************************************/
 if(array_item($formdata, "forum_decID" )    ){ 
	 
     
	  $sql = "SELECT d.decName,d.decID,d.parentDecID 
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
			     AND r.forum_decID = " . $db->sql_string($formdata['forum_decision']) .
		        " ORDER BY  d.decName ";

				
	if($rows = $db->queryObjectArray($sql)){			
	form_new_line();
     echo '<td   class="myformtd">';
     form_label1("הראה נתונים",true);
    display_tree ($rows,$formdata);
 
   $rootAttributes = array("decID"=>"11","flag_print"=>"1");
    $treeID = "treev2";
     $tv1 = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
      $str="כול ההחלטות"	;
     $tv1->setRootHTMLText($str);
    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
  
    $tv1->printTreeViewScript();

 
	
	  echo '</td>';
 	 
     form_end_line();	
	}
} 
/***************************************************************************************************************************/
form_end();
}

/**********************************************************************************************/
/****************************************************************************************************/
function display_tree ($rows,$formdata){
	 
		global $db;
	 
			$mysqli=$db->getMysqli();
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit ();
			} else {
				//printf("Connect succeeded\n");
			}
/********************************************************/
			$sql="set @@max_sp_recursion_depth=55";
			$result = $mysqli->query($sql);
			if ($mysqli->errno) {
				die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
			}

/********************************************************/
			$sql="truncate table tmp_dec";
			$result = $mysqli->query($sql);
			if ($mysqli->errno) {
				die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
			}
/************************************************************/
			for($i=0;$i<=count($rows);$i++){
				$decid=$rows[$i]->decID;

				$query = $mysqli->multi_query("CALL get_parent_dec($decid)"); // automatically buffers resultsets and assigns true or false on fail to $query
				// OR $mysqli->real_query() - remember the main point of this is NOT to execute multple queries, but to acquire buffered results.

				//check if the query was successful
				if ($query) {

					//asign the first result set for use
					$result = $mysqli->use_result();

					//use the data in the resultset
					$data = $result->fetch_array(MYSQLI_ASSOC) ;//fetch_assoc();

					//free the resultset
					$result->free();

				 
					while ($mysqli->next_result()) {
						//free each result.
						$result = $mysqli->store_result();//use_result();
						if ($result instanceof mysqli_result) {
							$result->free();
						}
					}
				}
				$sql5="select * from __parent_decs";
				$result5=$mysqli->query($sql5);
				if ($mysqli->errno) {
					die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
				}
				$sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName)(select * from __parent_decs)"; //" .
				$result3=$mysqli->query($sql3);
				if ($mysqli->errno) {
					die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
				}

			}

	 
		 
	}
	 





/*************************************************************************************************************/		
function display_tree1  ($rows,$formdata){
		global $db;
		   
			$mysqli=$db->getMysqli();
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit ();
			} else {
				 
			}
/********************************************************/
			$sql="set @@max_sp_recursion_depth=55";
			 
			$result = $mysqli->query($sql);
			if ($mysqli->errno) {
				die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
			}
			$sql="truncate table tmp_dec1";
			$result = $mysqli->query($sql);
			if ($mysqli->errno) {
				die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
			}
		if($rows){	
			for($i=0;$i<sizeof($rows);$i++){
				$decid=$rows[$i]->decID;
				$sql1 = "call get_subdec($decid,@res)";
				$results = $mysqli->query($sql1);//"exec call get_subdec(5,@res)"
				if ($mysqli->errno) {
					die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
				}
				$sql2="insert into tmp_dec1 (rank, level, decID, decName, parentDecID)(select * from __subdecs)";
				$result1=$mysqli->query($sql2);
				if ($mysqli->errno) {
					die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
				}
			}
		}	
			
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>