<?php
/**********************************************************************************************/



	function build_form(&$formdata) {
		global $db;
        global $lang;    
		
        $count=$formdata['count'];
        if($count)
		if($count==1)
		echo "<p>  החלטה חדשה נוספה.</p>\n";
		else{
			echo "<p>$count החלטות חדשות נוספו.</p>\n";

		}
        
        
        
        
    if($_SERVER['SCRIPT_NAME'] == "/alon-web/olive/admin/mult_dec_ajx.php"){
    	
    	
    ?>
     
 <table class="myformtable1" align="center"> 
  <form action="dynamic_5b.php" method="post" onsubmit="prepSelObject(document.getElementById('dest_forums')) 
            ,prepSelObject(document.getElementById('dest_decisionsType'));" name="dec_form" id="dec_form">     
       
    
 
         <?php
 	
    	
    }else{		
		
		
		?>
     
          <table class="myformtable1" align="center"> 
                <form action="<?php echo $_SERVER['SCRIPT_NAME']?>" 
           method="post" onsubmit="prepSelObject(document.getElementById('dest_forums')) 
            ,prepSelObject(document.getElementById('dest_decisionsType'));" name="dec_form" id="dec_form">     
       
    
 
         <?php
         
    }         
             
//=======================================================================================
		// decision
			form_new_line();
		echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';	 
		 
		form_label_red("שם כותרת החלטה:", TRUE);
		form_textarea("subcategories", array_item($formdata, "subcategories"), 30,5 , 3);
		
	 
      
	     echo '<td class="myformtd">'; 
	     form_label1("תאריך החלטה:",true);
		//($name, $value="", $size=40, $maxlength=40, $colspan=1,$id="entry")
		 form_text3("dec_date", array_item($formdata, "dec_date"),  10,10, 1,'dec_date'); 
	     ?>
	    
<!--	     <input type="text" class="mycontrol" size=20  colspan=1   name="form[dec_date]" -->
<!--        value="<?php echo array_item($formdata, "dec_date");?>" id="dec_date">-->
        
        
	    <?php  
	    echo '</td class="myformtd">';
//////////////////////////////////////////////////////////////////////////////////////////////	    
 
 
    form_label("הזנת תאריכים לכמה החלטות:",true);
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
    
 
	  

		         list11_td("multi_year" ,$years , array_item($formdata, "multi_year"), " multiple size=6"  );
				
				 list11_td("multi_month" ,$months , array_item($formdata, "multi_month"), " multiple size=6"  );
									 
				 list11_td("multi_day" ,$days, array_item($formdata, "multi_day"), " multiple size=6"  );
/////////////////////////////////////////////////////////////////////////////////////////////	    
 
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
			form_end_line();
/*****************************************************************************************/
/************************************FORUMS*****************************************************/
		// forum_dec
		form_new_line();
		echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';	 
 
$sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
			$rows = $db->queryObjectArray($sql);
				
			foreach($rows as $row) {
				$forumType[$row->parentForumID][] = $row->forum_decID;
				$forumNames[$row->forum_decID] = $row->forum_decName; }

				$rows = build_category_array($forumType[NULL],$forumType,$forumNames);
				$rows2 = build_category_array($forumType[NULL], $forumType,$forumNames);
 
    
    form_label_red("הזנת  הפורומים:", TRUE); 
    echo '<td class="myformtd">';
    
   

    
    form_list111("src_forums" , $rows, array_item($formdata, "src_forums"),"multiple size=6 id='src_forums' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));\"");		      
 
    echo '</td>'; 
  
    
    
if($formdata['dest_forums'] && $formdata['dest_forums']!='none'){	 		
 

 
 $dest_forums= $formdata['dest_forums'];
  unset($staff_test);	
  unset($staff_testb);
foreach ($dest_forums as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select forum_decID, forum_decName from forum_dec where forum_decID in ($staffb)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_b[$row->forum_decID]=$row->forum_decName;
	}
      $name=array_merge($name,$name_b);
       unset($staff_testb);
}else{
$staff=implode(',',$formdata['dest_forums'])	;		
			
$sql2="select forum_decID, forum_decName from forum_dec where forum_decID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
			//$name[]=$row->catName;
			
  }
}  
  
?>

   <td class="myformtd"> 
 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forums'));">

 
 	</td>
  
 
<? 





form_list11("dest_forums" , $name, array_item($formdata, "dest_forums"),"multiple size=6 id='dest_forums' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forums'));\"");
   
 
 
  
}elseif($formdata['src_forums'] && $formdata['src_forums'][0]!=0 && !$formdata['dest_forums']){
	
$dest_forum_dec= $formdata['src_forums'];
 
  for($i=0; $i<count($dest_forum_dec); $i++){
				if($i==0){
					$userNames =$dest_forum_dec[$i];
				}
				else{
					$userNames .= "," . $dest_forum_dec[$i];

				}
				 
			}    
	
		
$name=explode("," ,$userNames);

$sql2="select forum_decID,forum_decName from forum_dec where forum_decID in ($userNames)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
			
  }	
		  

?>

 <td class="myformtd"> 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forums'));">	
</td>
  

<?  	
 form_list11("src_forums" , $name, array_item($formdata, "src_forums"),"multiple size=6 id='src_forums' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));\"");

 
 
}else{	

		 
?>
		 
  <td class="myformtd">
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));">
	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forums'));">
  </td>
		 
		 
		 
<td class="myformtd">
  <select class="mycontrol"  name='arr_dest_forums[]' dir=rtl id='dest_forums' ondblclick="remove_item_from_select_box(document.getElementById('dest_forums'));"  MULTIPLE SIZE=6 style='width:180px;' ></select>
</td>
		
<?	
}		
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats_a[$row->parentForumID][] = $row->forum_decID;
			$catNames_a[$row->forum_decID] = $row->forum_decName; }
			// build hierarchical list
			$rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
			$rows2 = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);

  

            form_label("שם פורום חדש",TRUE);
		    form_textarea("new_forum", array_item($formdata, "new_forum"),14,5, 1);
		 
 		    form_label("קשר לפורום:", TRUE);
			form_list1idx("insert_forum", $rows2 , array_item($formdata, "insert_forum") , " multiple size=6 width=1"  );
			
			 
	      	if($formdata['forum_decision'] && array_item($formdata,'forum_decision') )
	        $forum_decID=$formdata['forum_decision'];	
	         

	        form_url("dynamic_8.php?mode=read_data&editID=$forum_decID","ערוך פורום",1 );		
	      //  form_url("forum_category.php","ערוך פורומים",1 );
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
			form_end_line();
/*****************************************************************************************/		

/*************************************DECISIONS_TYPE*****************************************************************/  

form_new_line();
echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';
$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
			$rows = $db->queryObjectArray($sql);
				
			foreach($rows as $row) {
				$subcatsftype[$row->parentCatID][] = $row->catID;
				$catNamesftype[$row->catID] = $row->catName; }

				$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
				$rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
 
    
    form_label_red("הזנת  סוגי ההחלטה:", TRUE); 
    echo '<td class="myformtd">';
    
   

    
    form_list111("src_decisionsType" , $rows, array_item($formdata, "src_decisionsType"),"multiple size=6 id='src_decisionsType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));\"");		      
 
    echo '</td>'; 
  
    
    
if($formdata['dest_decisionsType'] && $formdata['dest_decisionsType']!='none'){	 		
 

 
 $dest_decisionsType= $formdata['dest_decisionsType'];
  unset($staff_test);	
  unset($staff_testb);
foreach ($dest_decisionsType as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select catID, catName from categories where catID in ($staffb)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_b[$row->catID]=$row->catName;
	}
      $name=array_merge($name,$name_b);
       unset($staff_testb);
}else{
$staff=implode(',',$formdata['dest_decisionsType'])	;		
			
$sql3="select catID, catName from categories where catID in ($staff)";
		if($rows=$db->queryObjectArray($sql3))
		foreach($rows as $row){
			
			$name_1[$row->catID]=$row->catName;
			//$name[]=$row->catName;
			
  }
}  
  
?>

   <td class="myformtd"> 
 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));">

 
 	</td>
  
 
<? 





	  form_list11("dest_decisionsType" , $name_1, array_item($formdata, "dest_decisionsType"),"multiple size=6 id='dest_decisionsType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_decisionsType'));\"");
   
 
 
  
}elseif($formdata['src_decisionsType'] && $formdata['src_decisionsType'][0]!=0 && !$formdata['dest_decisionsType']){
	
$dest_types= $formdata['src_decisionsType'];
 
  for($i=0; $i<count($dest_types); $i++){
				if($i==0){
					$userNames =$dest_types[$i];
				}
				else{
					$userNames .= "," . $dest_types[$i];

				}
				 
			}    
	
		
$name=explode("," ,$userNames);

$sql2="select catID,catName from categories where catID in ($userNames)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			
  }	
		  

?>

 <td class="myformtd"> 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));">	
</td>
  

<?  	
 form_list11("src_decisionsType" , $name, array_item($formdata, "src_decisionsType"),"multiple size=6 id='src_decisionsType' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));\"");

 
 
}else{	

		 
?>
		 
  <td class="myformtd">
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));">
	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));">
  </td>
		 
		 
		 
<td class="myformtd">
  <select class="mycontrol"  name='arr_dest_decisionsType[]' dir=rtl id='dest_decisionsType' ondblclick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));"  MULTIPLE SIZE=6 style='width:180px;' ></select>
</td>
		
<?	
		
	          
		 

}
	              form_label("סוג החלטה חדש",TRUE);
		          form_textarea("new_category", array_item($formdata, "new_category"),14, 5, 1); 
                  form_label("קשר לסוג החלטה",TRUE);
                  
                  if(array_item($formdata, "insert_forumType") ){
                  form_list1idx ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"),"multiple size=6");
                  }else
                  form_list1 ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"),"multiple size=6");
                 
						
					 
					  
  form_url("categories.php","ערוך סוגי החלטות",1 );	
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
				 				
/**************************************************************************************************/  
form_new_line();
echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';

/////////////////////////////////////////////////////////////////
  form_label("רמת תוצאות הצבעה(%)", TRUE);
  form_text("vote_level", array_item($formdata, "vote_level"),36,50  , 3 );	

 
 
//echo '<td align="right" class="myformtd">';	
//form_label1("%");
//form_empty_cell_no_td(1); 
//form_text1("vote_level", array_item($formdata, "vote_level"),33,50  , 3 );	
// 
//echo '</td>';
 


 
echo '<tr>';
form_label("רמת חשיבות החלטה: (1 עד 10)", TRUE);	
form_text("dec_level", array_item($formdata, "dec_level"),  36, 50 , 3);
echo '</tr>';


echo '<tr>'; 
 form_label("סטטוס החלטה: (1=פתוחה/0=סגורה)", TRUE);	
 form_text("dec_status", array_item($formdata, "dec_status"),  36 , 50 , 3);
echo '</tr>';  

//////////////////////////////////////////////////////////////// 
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
 
/*******************************************************************************************/
 if(array_item($formdata, "decID")){
 
    form_new_line();
		  
		  	echo '<td  class="myformtd">';
		  	form_button2("btnLink1",  "קשר להחלטה נוספת");
            form_hidden("decID", $formdata["decID"]);
	        
            form_button2("btnLink3",  "קשר להחלטה נוספת לפי חיפוש");
            form_hidden("decID", $formdata["decID"]);
             
 
		  
//		  	form_button2("btnLink4","בטל קישור לפי חיפוש");
//            form_hidden("decID", $formdata["decID"]);

 $sql="select parentDecID1 from decisions where decID= " . $db->sql_string($formdata['decID']) ;
  		   if($rows=$db->queryObjectArray($sql )){
  		   	  if( $rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)){ 
  		     form_button2("btnLink4","בטל קישור שני");
             form_hidden("decID", $formdata["decID"]);     	
  		  }      
  	}    
            
            
             form_button4("btnDelete", "מחק החלטה", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["decID"]."').value='delete'\";");
			 form_empty_cell_no_td(5);
		   //  form_button2("submitbutton", "שמור");
		     form_button2 ("submitbutton", "שמור","Submit", "OnClick=\"prepSelObject(document.getElementById('dest_forums'));
							prepSelObject(document.getElementById('dest_decisionsType'));
							\";"); 
		                      
		     
		     
			$tmp =(array_item($formdata, "decID") ) ? "update":"save" ;
			form_hidden3("mode", $tmp,0, "id=mode_".$formdata["decID"]);
            
            
            echo '</td>';
            
 
            
 	}else{
 	        form_new_line();	
 			echo '<td  class="myformtd">'; 		
           if(!array_item($formdata, "insertID")&& !array_item($formdata, "btnLink1")){	
// 			 form_button2("btnLink", "קשר לתת החלטה");
// 			   form_hidden("decID", $formdata["decID"]);
 			  form_button2("btnLink2", "קשר לתת החלטה לפי חיפוש");
 			  form_hidden("decID", $formdata["decID"]);
  			} 
 			form_button2 ("submitbutton", "שמור");
			$tmp =(array_item($formdata, "decID") ) ? "update":"save" ;
			form_hidden3("mode", $tmp,0, "id=mode_".$formdata["decID"]);
			form_hidden("decID", $formdata["decID"]);
			form_hidden("insertID", $formdata["insertID"]);
			
			form_empty_cell_no_td(3);
 			form_button4("btnClear", "הוסף החלטה/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["btnClear"]."').value='clear'\";");
 		  
			echo '</td>';
 			 
 			
  			
 		
  	}
  	 form_end_line();
/******************************************************************************************************/
	// form_end();
  echo '</form>';  
/************************************************************************************************************/ 
if(array_item($formdata, "decID"  )    ){ 
  
  
 $decID=$formdata['decID'];	
 
	if(array_item($formdata,'dest_forums') ){
	foreach($formdata['dest_forums'] as $key=>$val ){
		$formdata['forum_decID']=$val;
		
	}
	
}
 
  if(is_numeric($formdata['dest_forums']))
  $forum_decID=$formdata['dest_forums'];
  else
  $forum_decID=$formdata['forum_decID']?$formdata['forum_decID']:$formdata['forum_decision']; 	
	if(is_numeric($forum_decID)){	
$getUser_sql	=	"SELECT u.* FROM users u 
                     inner join rel_user_forum r  
                     on u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     ORDER BY u.full_name ASC";

if($getUser=$db->queryObjectArray($getUser_sql) ){	
	
	
	 form_new_line();
       
	 	 
 echo '<td  colspan="3" norwap class="myformtd"> ';

  
   
   ?>
    <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />
    <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
   <?php   

   
//  require_once(TASK_DIR.'/index.php');
   $lang ->build_task_form($decID,$forum_decID);
  // $lang->build_task_form2($decID,$forum_decID); 
 //	build_task_form($decID,$forum_decID);
// $dec=new  decisions();
 //$dec->build_task_form($decID,$forum_decID);
 echo '</td>';	
 
 
   form_end_line();
       }
	}
 }

/***********************************************************************************************************/
  // form_end();
   echo '</table>';
  }
/***************************************************************************************************************/
	// build form for title input/change
	// the form is formated using a table with 4 columns

//===============================================================================================
	// build form to ask, if d should be deleted
	function build_delete_form($formdata) {
		global $db;
		if($decID = array_item($formdata, "decID")) {
			$sql = "SELECT decName FROM decisions WHERE decID=$decID";
			if($rows = $db->queryObjectArray($sql)) {
				form_start2($_SERVER['SCRIPT_NAME'],$name="" );
				form_new_line();
				form_caption("בטוח שרוצה לימחוק החלטה " . $rows[0]->decName . "?", 2);
				form_end_line();

				form_new_line();
				
				ECHO '<td class="myformtd">';
				form_button2("btnReallyDelete", "כן, מחק החלטה");
				form_hidden3("mode","realy_delete",0,"id=mode");
				form_hidden("btnReallyDelete", $formdata["btnReallyDelete"]);
				
				form_button_no_td("btnClear", "לא, בטל", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["btnClear"]."').value='clear'\";");
                form_hidden("decID", $decID);
				//      form_hidden3("mode","clear",0,"id=mode");
				//      form_hidden("decID", $formdata["decID"]);
				echo '</td>';
				form_end_line();
				
				form_end();
				return TRUE;
			}
		}
		return FALSE;
	}

//********************************************************************************************************
	function build_delete_form1($deleteID) {
		global $db;
		
			$sql = "SELECT decName FROM decisions WHERE decID=$deleteID";
			if($rows = $db->queryObjectArray($sql)) {
				form_start2($_SERVER['SCRIPT_NAME'],$name="" );
				form_new_line();
				form_caption("בטוח שרוצה לימחוק החלטה " . $rows[0]->decName . "?", 2);
				form_end_line();

				form_new_line();
				ECHO '<td class="myformtd">';
				form_button2("btnReallyDelete", "כן, מחק החלטה");
				form_hidden3("mode","realy_delete",0,"id=mode");
				form_hidden("btnReallyDelete", $formdata["btnReallyDelete"]);
				// form_hidden3("mode","update",0, "id=mode");
				//form_button("btnClear", "לא, בטל");
				form_button_no_td("btnClear", "לא, בטל", "Submit", "OnClick=\"return document.getElementById('mode').value='clear'\";");
                form_hidden("decID", $deleteID);
			    echo '</td>'; 
				form_end_line();
				
				form_end();
				return TRUE;
			}
		
		return FALSE;
	}

/********************************************************************************************************



/**************************************************************************/

function build_form_dec_ajx(&$formdata) {
		global $db;
        global $lang;
       $decID=$formdata['decID'];
         ?>
 
 
<!--  <iframe name="ifrm" id="ifrm" src="" frameborder="1">Your browser doesn't support iframes.</iframe>    -->
 <div id="main">
 
 
  
   <fieldset style="background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">החלטות עין השופט</h1></legend>
   
    
  
     <table class="myformtable1" align="center" id=""myformtable1<?php echo $formdata['decID']?>"> 
 
   <form  method="post"  name="decision_<?php echo $formdata['decID']?>" id="decision_<?php echo $formdata['decID']?>" action="../admin/dynamic_5c.php" 
    onSubmit="prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID']?>')) ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID']?>'));" >
  
  
  
        
  
   <div id="divId"  name="divId"></div>
  
   
   
     <div id="decision_b_<?php echo $formdata['decID']?>"  name="decision_b_<?php echo $formdata['decID']?>"></div>      
    <div id="decision_a_<?php echo $formdata['decID']?>"  name="decision_a_<?php echo $formdata['decID']?>"></div>
  
  

    <ul id="menu_items_dec<?php echo $decID;?>"  name="menu_items_dec"  class="menu_items_dec<?php echo $formdata['decID'];?>">   
     
  
  
  
             
  
  
  
  <div id="decision0_<?php echo $formdata['decID']?>"  name="decision0_<?php echo $formdata['decID']?>"></div>
   <div id="decision1_<?php echo $formdata['decID']?>"  name="decision1_<?php echo $formdata['decID']?>"></div>
    <div id="decision2_<?php echo $formdata['decID']?>"  name="decision2_<?php echo $formdata['decID']?>"></div>
     
    
      <div id="decision4_<?php echo $formdata['decID']?>"  name="decision4_<?php echo $formdata['decID']?>"></div>
       <div id="decision5_<?php echo $formdata['decID']?>"  name="decision5_<?php echo $formdata['decID']?>"></div>
       <div id="decision6_<?php echo $formdata['decID']?>"  name="decision6_<?php echo $formdata['decID']?>"></div>
      <div id="decision7_<?php echo $formdata['decID']?>"  name="decision7_<?php echo $formdata['decID']?>"></div>
     
     
     <div id="decision3a_<?php echo $formdata['decID']?>"  name="decision3a_<?php echo $formdata['decID']?>"></div>
 
     
      <div id="decision8_<?php echo $formdata['decID']?>"  name="decision8_<?php echo $formdata['decID']?>"></div>
        <div id="decision9_<?php echo $formdata['decID']?>"  name="decision9_<?php echo $formdata['decID']?>"></div>
         <div id="decision10_<?php echo $formdata['decID']?>"  name="decision10_<?php echo $formdata['decID']?>"></div>
        <div id="decision11_<?php echo $formdata['decID']?>"  name="decision11_<?php echo $formdata['decID']?>"></div>
          <div id="decision12_<?php echo $formdata['decID']?>"  name="decision12_<?php echo $formdata['decID']?>"></div>
           <div id="decision13_<?php echo $formdata['decID']?>"  name="decision13_<?php echo $formdata['decID']?>"></div>
            <div id="decision14_<?php echo $formdata['decID']?>"  name="decision14_<?php echo $formdata['decID']?>"></div>
             <div id="decision15_<?php echo $formdata['decID']?>"  name="decision15_<?php echo $formdata['decID']?>"></div>
              <div id="decision16_<?php echo $formdata['decID']?>"  name="decision16_<?php echo $formdata['decID']?>"></div>
               <div id="decision17_<?php echo $formdata['decID']?>"  name="decision17_<?php echo $formdata['decID']?>"></div>
                <div id="decision18_<?php echo $formdata['decID']?>"  name="decision18_<?php echo $formdata['decID']?>"></div>
                 <div id="decision19_<?php echo $formdata['decID']?>"  name="decision19_<?php echo $formdata['decID']?>"></div>
                  <div id="decision20_<?php echo $formdata['decID']?>"  name="decision20_<?php echo $formdata['decID']?>"></div>
 
 
 
 
 
    <div id="decision_<?php echo $formdata['decID']?>-message" name="decision_<?php echo $formdata['decID']?>-message"></div> 
    <div id="decision-message<?php echo $formdata['decID']?>" name="decision-message<?php echo $formdata['decID']?>"></div>    
     <div id="decision6"  name="decision6"></div>
            
 
 
 
 
 </ul> 
  
 <div id="loading">
  <img src="../images/loading4.gif" border="0" />
   </div>
 
         <?php
         
 $decID=$formdata['decID'];         
//=======================================================================================
		// decision
	form_new_line();
		echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';	 
		 
		form_label_red("שם כותרת החלטה:", TRUE);
		form_textarea("subcategories", array_item($formdata, "subcategories"), 30,5 , 3,"my_text_erea$decID");
		
	 
      
	     //echo '<td class="myformtd" id="my_date$decID">';
	     ?><td class="myformtd" id="my_date<?php echo $decID;?>"><?php   
	     form_label1("תאריך החלטה:",true);
		 
		 form_text3("dec_date", array_item($formdata, "dec_date"),  10,10, 1,'dec_date'); 
	     ?>
	    
<!--	     <input type="text" class="mycontrol" size=20  colspan=1   name="form[dec_date]" -->
<!--        value="<?php echo array_item($formdata, "dec_date");?>" id="dec_date">-->
        
        
	    <?php  
	    echo '</td class="myformtd">';
//////////////////////////////////////////////////////////////////////////////////////////////	    
 
 
    form_label("הזנת תאריכים לכמה החלטות:",true);
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
    
 
	  

		         list11_td("multi_year" ,$years , array_item($formdata, "multi_year"), " multiple size=6"  );
				
				 list11_td("multi_month" ,$months , array_item($formdata, "multi_month"), " multiple size=6"  );
									 
				 list11_td("multi_day" ,$days, array_item($formdata, "multi_day"), " multiple size=6"  );
/////////////////////////////////////////////////////////////////////////////////////////////	    
 
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
			form_end_line();
/*****************************************************************************************/
/************************************FORUMS*****************************************************/
		// forum_dec
		form_new_line();
		echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';	 
 
$decID=$formdata['decID'];		
$formdata["dest_forums$decID"]=$formdata["dest_forums"];

		
$sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
			$rows = $db->queryObjectArray($sql);
				
			foreach($rows as $row) {
				$forumType[$row->parentForumID][] = $row->forum_decID;
				$forumNames[$row->forum_decID] = $row->forum_decName; }

				$rows = build_category_array($forumType[NULL],$forumType,$forumNames);
				$rows2 = build_category_array($forumType[NULL], $forumType,$forumNames);
 
    
    form_label_red("הזנת  הפורומים:", TRUE); 
    echo '<td class="myformtd">';
    
   

    
    form_list111("src_forums$decID" , $rows, array_item($formdata, "src_forums$decID"),"multiple size=6 id='src_forums$decID' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums$decID'), document.getElementById('dest_forums$decID'));\"");		      
 
    echo '</td>'; 
  
    
    
if($formdata["dest_forums$decID"] && $formdata["dest_forums$decID"]!='none'){	 		
 

 
 $dest_forums= $formdata["dest_forums$decID"];
  unset($staff_test);	
  unset($staff_testb);
foreach ($dest_forums as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select forum_decID, forum_decName from forum_dec where forum_decID in ($staffb)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_b[$row->forum_decID]=$row->forum_decName;
	}
      $name=array_merge($name,$name_b);
       unset($staff_testb);
}else{
$staff=implode(',',$formdata["dest_forums$decID"])	;		
			
$sql2="select forum_decID, forum_decName from forum_dec where forum_decID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
		 
  }
}  
  
?>

   <td class="myformtd"> 
 
	<input type=button name='add_to_list<?php echo $decID;?>' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID;?>'), document.getElementById('dest_forums<?php echo $decID;?>'));">

	<BR><BR><input type=button name='remove_from_list<?php echo $decID;?>();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID;?>'));">

 
 	</td>
  
 
<? 





form_list11("dest_forums$decID" , $name, array_item($formdata, "dest_forums$decID"),"multiple size=6 id='dest_forums$decID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forums$decID'));\"");
   
 
 
  
}elseif($formdata["src_forums$decID"] && $formdata["src_forums$decID"][0]!=0 && !$formdata["dest_forums$decID"]){
	
$dest_forum_dec= $formdata["src_forums$decID"];
 
  for($i=0; $i<count($dest_forum_dec); $i++){
				if($i==0){
					$userNames =$dest_forum_dec[$i];
				}
				else{
					$userNames .= "," . $dest_forum_dec[$i];

				}
				 
			}    
	
		
$name=explode("," ,$userNames);

$sql2="select forum_decID,forum_decName from forum_dec where forum_decID in ($userNames)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->forum_decID]=$row->forum_decName;
			
  }	
		  

?>

 <td class="myformtd"> 
	<input type=button name='add_to_list<?php echo $decID;?>' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID;?>'), document.getElementById('dest_forums<?php echo $decID;?>'));">

	<BR><BR><input type=button name='remove_from_list()<?php echo $decID;?>;' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID;?>'));">	
</td>
  

<?  	
 form_list11("src_forums$decID" , $name, array_item($formdata, "src_forums$decID"),"multiple size=6 id='src_forums$decID' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums$decID'), document.getElementById('dest_forums$decID'));\"");

 
 
}else{	

		 
?>
		 
  <td class="myformtd">
	<input type=button name='add_to_list<?php echo $decID;?>' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID;?>'), document.getElementById('dest_forums<?php echo $decID;?>'));">
	<BR><BR><input type=button name='remove_from_list()<?php echo $decID;?>;' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID;?>'));">
  </td>
		 
		 
		 
<td class="myformtd">
  <select class="mycontrol"  name='arr_dest_forums<?php echo $decID;?>[]' dir=rtl id='dest_forums<?php echo $decID;?>' ondblclick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID;?>'));"  MULTIPLE SIZE=6 style='width:180px;' ></select>
</td>


		
<?	
}		
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats_a[$row->parentForumID][] = $row->forum_decID;
			$catNames_a[$row->forum_decID] = $row->forum_decName; }
			// build hierarchical list
			$rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
			$rows2 = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);

  

            form_label("שם פורום חדש",TRUE);
		    form_textarea("new_forum", array_item($formdata, "new_forum"),14,5, 1);
		 
 		    form_label("קשר לפורום:", TRUE);
			form_list1idx("insert_forum", $rows2 , array_item($formdata, "insert_forum") , " multiple size=6 width=1"  );
			
			 
	      	if($formdata['forum_decision'] && array_item($formdata,'forum_decision') )
	        $forum_decID=$formdata['forum_decision'];	
	         

	        form_url("dynamic_10.php?mode=read_data&editID=$forum_decID","ערוך פורום",1 );		
	      //  form_url("forum_category.php","ערוך פורומים",1 );
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
			form_end_line();
/*****************************************************************************************/		

/*************************************DECISIONS_TYPE*****************************************************************/  

form_new_line();
$decID=$formdata['decID'];
$formdata["dest_decisionsType$decID"]=$formdata["dest_decisionsType"];
echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';
$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
			$rows = $db->queryObjectArray($sql);
				
			foreach($rows as $row) {
				$subcatsftype[$row->parentCatID][] = $row->catID;
				$catNamesftype[$row->catID] = $row->catName; }

				$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
				$rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
 
    
    form_label_red("הזנת  סוגי ההחלטה:", TRUE); 
    echo '<td class="myformtd">';
    
   

    
    form_list111("src_decisionsType$decID" , $rows, array_item($formdata, "src_decisionsType$decID"),"multiple size=6 id='src_decisionsType$decID' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType$decID'), document.getElementById('dest_decisionsType$decID'));\"");		      
 
    echo '</td>'; 
  
    
    
if($formdata["dest_decisionsType$decID"] && $formdata["dest_decisionsType$decID"]!='none'){	 		
 

 
 $dest_decisionsType= $formdata["dest_decisionsType$decID"];
  unset($staff_test);	
  unset($staff_testb);
foreach ($dest_decisionsType as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select catID, catName from categories where catID in ($staffb)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_b[$row->catID]=$row->catName;
	}
      $name=array_merge($name,$name_b);
       unset($staff_testb);
}else{
$staff=implode(',',$formdata["dest_decisionsType$decID"])	;		
			
$sql3="select catID, catName from categories where catID in ($staff)";
		if($rows=$db->queryObjectArray($sql3))
		foreach($rows as $row){
			
			$name_1[$row->catID]=$row->catName;
			//$name[]=$row->catName;
			
  }
}  
  
?>

   <td class="myformtd"> 
 
	<input type=button name='add_to_list<?php echo $decID;?>' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID;?>'), document.getElementById('dest_decisionsType<?php echo $decID;?>'));">

	<BR><BR><input type=button name='remove_from_list()<?php echo $decID;?>;' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID;?>'));">

 
 	</td>
  
 
<? 





	  form_list11("dest_decisionsType$decID" , $name_1, array_item($formdata, "dest_decisionsType$decID"),"multiple size=6 id='dest_decisionsType$decID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_decisionsType$decID'));\"");
   
 
 
  
}elseif($formdata["src_decisionsType$decID"] && $formdata["src_decisionsType$decID"][0]!=0 && !$formdata["dest_decisionsType$decID"]){
	
$dest_types= $formdata["src_decisionsType$decID"];
 
  for($i=0; $i<count($dest_types); $i++){
				if($i==0){
					$userNames =$dest_types[$i];
				}
				else{
					$userNames .= "," . $dest_types[$i];

				}
				 
			}    
	
		
$name=explode("," ,$userNames);

$sql2="select catID,catName from categories where catID in ($userNames)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			
  }	
		  

?>

<td class="myformtd"> 
	<input type=button name='add_to_list<?php echo $decID;?>' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID;?>'), document.getElementById('dest_decisionsType<?php echo $decID;?>'));">

	<BR><BR><input type=button name='remove_from_list()<?php echo $decID;?>;' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID;?>'));">	
</td>
  

<?  	
 form_list11("src_decisionsType$decID" , $name, array_item($formdata, "src_decisionsType$decID"),"multiple size=6 id='src_decisionsType$decID' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType$decID'), document.getElementById('dest_decisionsType$decID'));\"");

 
 
}else{	

		 
?>
		 
  <td class="myformtd">
	<input type=button name='add_to_list<?php echo $decID;?>' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID;?>'), document.getElementById('dest_decisionsType<?php echo $decID;?>'));">
	<BR><BR><input type=button name='remove_from_list()<?php echo $decID;?>;' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID;?>'));">
  </td>
		 
		 
		 
<td class="myformtd">
  <select class="mycontrol"  name='arr_dest_decisionsType<?php echo $decID;?>[]' dir=rtl id='dest_decisionsType<?php echo $decID;?>' ondblclick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID;?>'));"  MULTIPLE SIZE=6 style='width:180px;' ></select>
</td>
		
<?	
		
	          
		 

}
	              form_label("סוג החלטה חדש",TRUE);
		          form_textarea("new_category", array_item($formdata, "new_category"),14, 5, 1); 
                  form_label("קשר לסוג החלטה",TRUE);
                  
                  if(array_item($formdata, "insert_forumType") ){
                  form_list1idx ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"),"multiple size=6");
                  }else
                  form_list1 ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"),"multiple size=6");
                 
						
					 
					  
  form_url("categories.php","ערוך סוגי החלטות",1 );	
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
				 				
/**************************************************************************************************/  
form_new_line();
echo '<td   class="myformtd" >
    		<table class="myformtable">
    		<tr>';
 $decID=$formdata['decID'];   
/////////////////////////////////////////////////////////////////
  form_label("רמת תוצאות הצבעה(%)", TRUE);
  form_text("vote_level", array_item($formdata, "vote_level"),36,50  , 3,"my_vote_level$decID" );	

 
 
//echo '<td align="right" class="myformtd">';	
//form_label1("%");
//form_empty_cell_no_td(1); 
//form_text1("vote_level", array_item($formdata, "vote_level"),33,50  , 3 );	
// 
//echo '</td>';
 


 
echo '<tr>';
form_label("רמת חשיבות החלטה: (1 עד 10)", TRUE);	
form_text("dec_level", array_item($formdata, "dec_level"),  36, 50 , 3,"my_dec_level$decID");
echo '</tr>';


echo '<tr>'; 
 form_label("סטטוס החלטה: (1=פתוחה/0=סגורה)", TRUE);	
 //$name, $value, $size=40, $maxlength=40, $colspan=1,$id) {
 form_text("dec_status", array_item($formdata, "dec_status"),  36 , 50 , 3,"my_status$decID");
echo '</tr>';  

//////////////////////////////////////////////////////////////// 
 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
 
/*******************************************************************************************/
 form_new_line();
            
   ?><td  class="myformtd" ><table class="myformtable" id="conn_table<?php echo $decID;?>"><tr id="conn_tr<? echo $decID; ?>"><?php  
    		 
 
 if(array_item($formdata, "decID")){
 $decID=$formdata["decID"];
   


 
 
		  	//echo '<td  class="myformtd">';
		     ?><td  class="myformtd" id="my_td<?PHP echo $decID;?>"><?php     
		  	 form_button5("btnLink6_$decID",  "שנה קישור ריאשון","button","btnLink6_$decID");
		  	
		  	 form_button5("btnLink1_$decID",  "קשר להחלטה נוספת","button","btnLink1_$decID");
            form_hidden("decID", $formdata["decID"]);

            
            
    form_button5("btnLink3_$decID",  "קשר להחלטה נוספת לפי חיפוש","button","btnLink3_$decID");//, "OnClick=\"return document.getElementById('mode_".$formdata["decID"]."').value='link_second'\";");
   
    form_hidden("decID", $formdata["decID"]);
  
		  
 
         $sql="select parentDecID1 from decisions where decID= " . $db->sql_string($formdata['decID']) ;
  		   if($rows=$db->queryObjectArray($sql )){
  		   	  if( $rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)){ 
                form_button5("btnLink4_$decID",  "בטל קישור שני","button","btnLink4_$decID");
                     
  		  }      
  	}

  	
form_empty_cell_no_td(15);              
                               
?>
 <input class="submit" type="submit" value="Submit" ,name="submitbutton_<?php echo $formdata['decID'];?>"  id="submitbutton_<?php echo $formdata['decID'];?>"  
 onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID'];?>'))
 ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID'];?>'));" /> 


<input class="submit" type="button" value="פתח משימות" ,name="submitbutton1_<?php echo $formdata['decID'];?>"  id="submitbutton1_<?php echo $formdata['decID'];?>" />
 
<?php 	

 form_empty_cell_no_td(15);
form_button5("btnDelete_$decID", "מחק החלטה", "Submit","btnDelete_$decID");
			
		     



		     
			$tmp =(array_item($formdata, "decID") ) ? "update":"save" ;
			form_hidden3("mode", $tmp,0, "id=mode_".$formdata["decID"]);
            
            
            echo '</td>';
            
 
            
 	}else{
 	        form_new_line();	
 			echo '<td  class="myformtd">'; 	
 				
           if(!array_item($formdata, "insertID")&& !array_item($formdata, "btnLink1")){	
 
 			  form_button2("btnLink2", "קשר לתת החלטה לפי חיפוש");
 			  form_hidden("decID", $formdata["decID"]);
  			} 
 			 
  			
			$tmp =(array_item($formdata, "decID") ) ? "update":"save" ;
			form_hidden3("mode", $tmp,0, "id=mode_".$formdata["decID"]);
			form_hidden("decID", $formdata["decID"]);
			form_hidden("insertID", $formdata["insertID"]);
			?>
			<input class="submit" type="submit" value="Submit" ,name="submitbutton_<?php echo $formdata['decID'];?>"  id="submitbutton_<?php echo $formdata['decID'];?>"  
            onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID'];?>')),prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID'];?>'));"/>     
            
            
            
            
            <input class="submit" type="button" value="Submit" ,name="submitbutton1_<?php echo $formdata['decID'];?>"  id="submitbutton1_<?php echo $formdata['decID'];?>" />
     
             
			<?php  
			form_empty_cell_no_td(3);
 			form_button4("btnClear", "הוסף החלטה/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["btnClear"]."').value='clear'\";");
 		  
			echo '</td>';
 			 
 			
  			
 		
  	}
  	 echo ' 
  	</tr>
 	</table>
 	</td>'; 
 form_end_line();
/******************************************************************************************************/
	// form_end();
   
  echo '</form>';  
/************************************************************************************************************/ 
if(array_item($formdata, "decID"  )  && (is_numeric($formdata['decID']))  ){ 
  
	
 $decID=$formdata['decID'];
 
 
 
/*************************************************************************/ 
if(!($formdata['single_frm']==1 )  ){
?> <table id="my_dec<?php echo $decID; ?>" class="myformtable1" >  <?php  	
 if(array_item($formdata,"dest_forums$decID") ){
 $i=0;	
	foreach($formdata["dest_forums$decID"] as $key=>$val ){
		$formdata['forum_decID'][$i]=$val;
		$i++;
	}
	
}	
if(is_array($formdata['forum_decID']))
 foreach($formdata['forum_decID'] as $forum_decID){
if(is_numeric($forum_decID)){	
$getUser_sql	=	"SELECT u.* FROM users u 
                     inner join rel_user_forum r  
                     on u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     ORDER BY u.full_name ASC";

if($rows=$db->queryObjectArray($getUser_sql) ){


  ?>   <tr id="tr_<?php echo $decID;echo $forum_decID; ?>">   <?php  
       
	 	 
 echo '<td  colspan="3" norwap class="myformtd"> ';

 
   
   ?>
    <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />
    <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
     <input type=hidden name="formdata" id="formdata" value="<?php echo $formdata?>" />
   <?php   


    //  require_once(TASK_DIR.'/index_test2.php');

 //$lang->build_task_form2($decID,$forum_decID); 
 
 echo '</td>';	
 
 
       form_end_line();
      
		}
       }
    }
     
/********************************************************/    
 }else{
?> <table id=my_dec<?php echo $decID ?>">  <?php 	
 $forum_decID=$formdata['forum_decision'];	
 if(is_numeric($forum_decID)){	
$getUser_sql	=	"SELECT u.* FROM users u 
                     inner join rel_user_forum r  
                     on u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     ORDER BY u.full_name ASC";

if($rows=$db->queryObjectArray($getUser_sql) ){

  
  ?>   <tr id="tr_<?php echo $decID; ?>">   <?php  
       
	 	 
 echo '<td  colspan="3" norwap class="myformtd"> ';

 
   
   ?>
    <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />
    <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
   <?php   


   // require_once(TASK_DIR.'/index.php');
//require_once(TASK_DIR.'/index_test2.php');
	// $lang->build_task_form2($decID,$forum_decID); 
	 
	 echo '</td>';	
 
     form_end_line();
       
   }	
/**********************************************************/ 	
   }	

     	
 }
 echo '</table>';
}
/***********************************************************************************************************/
  // form_end();
  ?>
  <div id="loading">
  <img src="../images/loading4.gif" border="0" />
  </div>
   <?php 
   echo '</table>';
    
   echo '</fieldset></div>';

 ?>   
   

 <script>

//var decID =<?php echo $formdata['decID']; ?>; 
  var decID=document.getElementById('decID').value; 
var  countJson;
 
<?php 
$decID=$formdata['decID'];
 
$func_name="setupAjaxForm$decID";
 
 
?>
	 

	 function <?php echo $func_name; ?>(dec_id, form_validations){
		   
			var form = '#' + dec_id;
			var form_message = form + '-message';
			//var decID =<?php echo $formdata['decID']; ?>; 
		  
			// alert(form_message);
			// setup loading message
			$(form).ajaxSend(function(){
			   $("#form-message"+decID).removeClass().addClass('loading').html('Loading...').fadeIn();
		   });
          
 
				 
 
   var options = { 
		 
        beforeSubmit:  showRequest, 
	   
             // pre-submit callback 
         
        success:  processJson, 
        
        dataType: 'json'
    }; 
   
 
    // bind form using 'ajaxForm' 
    $('#decision_'+decID).ajaxForm(options); 
//    $('#decision_'+decID).ajaxForm(function() { 
//        alert("Thank you for your comment!"); 
//    });    
    
 	 

 
    
 function showRequest(formData, jqForm) { 
	 
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)
 
    return true;  
} 
 
/**********************************************************************************************/

// post-submit callback 
function processJson(data) {
	theme = {
			 
			newUserFlashColor: '#ffffaa',
			editUserFlashColor: '#bbffaa',
			errorFlashColor: '#ffffff'
		};  
	countJson = data;
	countJson1 = data;
	
	var decID =<?php echo $formdata['decID']; ?>; 
	  
    countJson = data;
	
    var countList = '';
    var decisionList = '';
    
    var managerList = '';
    var appointList = '';
    var countList1 = ''; 
	var countList2 = ''; 
	var countList3 = ''; 
	var countList4 = '';  
	var infoList='';
	var userList='';
    var categoryList='';
    var decision_typeList='';
    usrList= new Array();
    list_div= new Array();
    dest_forums_conv=new Array();
        


    if(data.type == 'success'){
//     alert("success");
      var decID =<?php echo $formdata['decID']; ?>;  
      
        
/************************************************************************************************************/

      
/************************************************************************************************************/    	 
      $(form_message).empty();     
       $("#decision-message"+decID).removeClass().addClass(data.type).html(data.message).fadeIn('slow').css({'background':'#ffdddd'}).css({'margin-right': '90px'});  

/***********************************************DECISION*********************************************************/	
      
      if(data.dateIDs){
    	  countList += '<li><a href="../admin/find3.php?decID='+data.decID+'"  class="declink" >'+data.subcategories+'>>'+data.dateIDs+'</a></li>';
    	}else{
    		 if(data.dec_date)
          countList += '<li><a href="../admin/find3.php?decID='+data.decID+'"  class="declink" >'+data.subcategories+'>>'+data.dec_date+'</a></li>';	    
    	}
    	
$('#decision1_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow'); 
        	  
$('#decision1_'+decID).html('<ul id="countList">שם החלטה'+countList+'</ul>').find('a.declink').each(function(i){		 
      
     		    var index = $('a.declink').index(this);
     		    var v = countJson.subcategories;
     		    var id=countJson.decID;
/*****************************************CLICK*****************************************************************/			   
     		   $(this).click(function(){
     		    $.get('../admin/find3.php?decID='+id+'', $(this).serialize(), function(data) {


     		    	 
     			       
     		   
     $('#decision0_'+decID) 
     .addClass('decision0_'+decID).css({'width' : '81%'})
     			.css({'height': '300px'})
     			.css({'margin-right': '90px'})
     			.css({'padding': '5px'})
     			.css({'overflow':'hidden'})
     			.css({'overflow':'scroll'})
     			.css({'background':'#2AAFDC'})
     			.css({'border':'3px solid #666'});


              $('#decision0_'+decID).html(data) ;
     		     
     		    						
     		    });
     		  
     		   
     		     return false;
     		    });
     		 
     });//end decision
/***********************************************FORUM_DEC*********************************************************/	

$.each(data.dest_forums, function(i){

	 dest_forums_conv[i]=data.dest_forums[i].forum_decID;
	 
	   var forum_decName=this.forum_decName;
	   var forum_id=countJson.dest_forums[i].forum_decID;
	    var url='/alon-web/olive/admin/';
	    var idx=i;
 
       
    
////	countList3 += '<li><a href="../admin/find3.php?userID='+this.userID+'"  class="usr" >'+this.full_name+'>>'+ data.member_date[i]+'</a></li>';
  countList1 += '<li><a href="../admin/find3.php?forum_decID='+forum_id+'"  class="forumlink" >'+this.forum_decName+'</a></li>';
	    
 

 });	
// var arv = dest_forums_conv.toString();
/**************************************************************************************************************/
   
$('#decision2_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow'); 

 

 
$('#decision2_'+decID).html('<ol id="countList1">שם הפורום/ים'+countList1+'</ol>').find('a.forumlink').each(function(i){		 
	
		    var index = $('a.forumlink').index(this);
		    var v = countJson.forum_decName;
		    var forum_id=countJson.dest_forums[i].forum_decID;
		    
/*****************************************CLICK************************************************************/			   
		   $(this).click(function(){
		    $.get('../admin/find3.php?forum_decID='+forum_id+'', $(this).serialize(), function(data) {


		    	 
			       
		   
$('#decision0_'+decID) 
.addClass('decision0_'+decID).css({'width' : '81%'})
			.css({'height': '300px'})
			.css({'margin-right': '90px'})
			.css({'padding': '5px'})
			.css({'overflow':'hidden'})
			.css({'overflow':'scroll'})
			.css({'background':'#C6EFF0'})
			.css({'border':'3px solid #666'});


         $('#decision0_'+decID).html(data) ;
		     
		    						
			      
		    });
		  
		   
		     return false;
		    });
		  
});//end forum_dec   		

/************************************************************DECISION_TYPE**********************************************************************/
$.each(data.dest_decisionsType, function(i){


 var catName=this.catName;
 var catID=countJson.dest_decisionsType[i].catID;
  var url='/alon-web/olive/admin/';
  var idx=i;

 


countList4 += '<li><a href="../admin/find3.php?catID='+catID+'"  class="typelink" >'+this.catName+'</a></li>';
  


});	

/**************************************************************************************************************/


$('#decision3a_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow'); 

$('#decision3a_'+decID).html('<ol id="countList4">סוג החלטה/ות'+countList4+'</ol>').find('a.typelink').each(function(i){		 

	    var index = $('a.typelink').index(this);
	    var v = countJson.catName;
	    var id=countJson.dest_decisionsType[i].catID;
/*****************************************CLICK***************************************************/			   
	   $(this).click(function(){
		     
	    $.get('../admin/find3.php?catID='+id+'', $(this).serialize(), function(data) {


	    	 
		       
	   
$('#decision0_'+decID) 
.addClass('decision0_'+decID).css({'width' : '81%'})
		.css({'height': '500px'})
 	 	.css({'margin-right': '90px'})
    	.css({'padding': '5px'})
		.css({'overflow':'hidden'})
		.css({'overflow':'scroll'})
		.css({'background':'#8EF6F8'})
		.css({'display':'block'})
		.css({'border':'3px solid #666'});


 





 $('#decision0_'+decID).html(data) ;
 
/**********************************************************/

 $('#decision0_'+decID).pager('li', {
	   navId: 'nav2',
	  height: '15em' 
	   
           
	 });
 $('#nav2').draggable();
//$('#nav2').draggable({position : 'absolute'});
 //$('#nav2').draggable({axis: 'y', containment: 'parent',position : 'relative'});
/********************************************************/
//$('#decision0_'+decID).pager('li').; 
//.li_page{
//display:inline;
//}
// $('#nav2').draggable({
//	    revert: 'invalid'
//	  }); 
 
 
// $('#first_li').css("display", "inline");
// .addClass('li_page').css("border", "3px solid red");//.css("display", "inline");
/***********************************/
 
var $clonedCopy = $('#my_resulttable_0').clone();
$('#first_li').css("display", "inline");
 

$('a.my_paging').not(document.getElementById('my_paging1')).bind('click', function() {
	   
	   $('#my_resulttable_0').html(' ');
	 });

 

	 $('#my_paging1').bind('click', function() {
		$('#first_li').css("display", "inline");
		$('#my_resulttable_0').html(' ');  
	      $('#my_resulttable_0').append ($clonedCopy);
	      
	    	 });//end#my_paging1

	  
	    });

	      
           	   
	     return false;
	    });

	       
});//end decision/type   

/***************************************MANAGER**********************************************/


//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(data.dest_managers, function(i,item){
/////////////////////////////////////////////////////////////////////////////////////////////
	  
			$.each(item, function(i){
	            var managerName=this.managerName;
	      	    var mng_id=item[i].managerID;
	      	    
	      	   managerList += '<li><a href="../admin/find3.php?managerID='+mng_id+'"  class="mgr" >'+managerName+'</a></li>';
             
			});//end each2 

		 });//end each2			               


/*********************************************************************************************************************************/
 $('#decision7_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});


  $('#decision7_'+decID).html('<ol id="managerList1">מרכז ועדה'+managerList+'</ol>').find('a.mgr').each(function(i){
///////////////////////////////////////////////////////////////////////////////////////////////	   
	      			  var index = $('a.mgr').index(this);
	      		 
	      	 	 
	      			    var mgr_id=data.dest_managers[i][0].managerID;
	      
/*****************************************CLICK****************************/		   
      		   $(this).click(function(){
      		   
      		    $.get('../admin/find3.php?managerID='+mgr_id+'', $(this).serialize(), function(data) {
      
      		    	$('#decision0_'+decID) 
      					.addClass('decision0_'+decID).css({'width' : '81%'})
      								.css({'height': '500px'})
      								.css({'margin-right': '90px'})
      								.css({'padding': '5px'})
      								.css({'overflow':'hidden'})
      								.css({'overflow':'scroll'})
      								.css({'background':'#B4D9D7'})
      								.css({'border':'3px solid #666'});
      					
      					
      		    	$('#decision0_'+decID).html(data) ;
      							     
      							    						
      								      
      							    });
      							  
      					  
      							     return false;
      							    });
      		 $('#decision0_'+decID).html(' ') ;
      		    
      		   });//end manager  end each3  

  
/***************************************USERS_FORUM**********************************************/

 
///////////////////////////////////////////////////////////////////////////		
		$.each(data.dest_users, function(j,item){
/////////////////////////////////////////////////////////////////////////////////////////////

	        
			$.each(item, function(i){
	            var full_name=this.full_name;
	      	    var usr_id=item[i].userID;
	      	  
	         userList += '<li><a href="../admin/find3.php?userID='+usr_id+'"  class="usr'+j+'" >'+full_name+'</a></li>';
	   
			});//end each2 
			usrList[j]=userList;
			userList='';
	 
		 });//end each2			               
/*********************************************************************************************************************************/
 
  count=new Array();

for(var j=0, mylen = countJson.dest_forums.length;j<=mylen;j++){
	 
	var num=8+j;
	list_div[j]=num;   
   $('#decision'+num+'_'+decID).removeClass().addClass(data.type).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});


   if(usrList[j]){
		   if(countJson.dest_forums.length<countJson.src_forums.length){
               
			   for(var k=0, mylen = (countJson.src_forums.length-countJson.dest_forums.length);k<mylen;k++){

			 
	                var num_del=(num+mylen)-k; 
	                    
				   $('#decision'+num_del+'_'+decID).empty();
				   }
		   }	 
	   	
   var count_user=0 ;
  $('#decision'+num+'_'+decID).html('<ol id="userList'+j+'">'+countJson.dest_forums[j].forum_decName +'- חברי ועדה'+usrList[j]+'</ol>').find('a.usr'+j+'').each(function(i){
   

		var index = $('a.usr'+j+'').index(this);
	      		 
	      	 	 
	      			    var usr_id=data.dest_users[j][count_user].userID;
       			 
       			 
/*****************************************CLICK*************************************************************/		   
      		   $(this).click(function(){
      			  
      		    $.get('../admin/find3.php?userID='+usr_id+'', $(this).serialize(), function(data) {
      
      		    	$('#decision0_'+decID) 
      					.addClass('decision0_'+decID).css({'width' : '81%'})
      								.css({'height': '500px'})
      								.css({'margin-right': '90px'})
      								.css({'padding': '5px'})
      								.css({'overflow':'hidden'})
      								.css({'overflow':'scroll'})
      								.css({'background':'#B4D9D7'})
      								.css({'border':'3px solid #666'});
      					
      					
      		    	$('#decision0_'+decID).html(data) ;
      							     
      		    							
      								      
      							    });
      							  
      		  
      							     return false;
      							    });
      		 
      		 $('#decision0_'+decID).html(' ') ;
      		 count_user++;
    		   });//end each3  
            
           }//end if usrList 
          
//          else {
//        	  if( (!usrList[j]) && (countJson.dest_forums[j].forum_decName) && (countJson.dest_forums[j].forum_decName=="undefined") ) {  
//        	  $('#decision'+num+'_'+decID).html('<ol id="userList'+j+'">'+countJson.dest_forums[j].forum_decName +'</ol>');  
//             }
//           }
          
     }//end for

     
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
    }//end success
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			else{
				 
	$.each(data  , function(i){ 			
		var  messageError="messageError_"+i;
		 
   	if(messageError=="messageError_message"){
		 countList2 +='';
        $("#decision-message").html(' ');
        
 		}else{	
		 countList2 +='<li class="error">'+  (eval("data.message[0]." + messageError))+'</li>';
 		}
       
	 });
 
	// $('#forum-message')
	 $(form_message).html('<ul id="countList1">'+countList2+'</ul>').css({'margin-right': '90px'});



   }
 
/************************************************************************************************/

 }//end proccess
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    
 $('input#submitbutton1_'+decID).click(function(){
  
	
   var arv = dest_forums_conv.toString();
   
 
  
     $.ajax({
		   type: "POST",
		   url: "../admin/make_task.php",
		 
		  data:  "rebuild="+ arv + "&decID=" + decID ,
 		  
		     

		   success: function(msg){
		 
		 
			 $('table#my_dec'+decID).html(' ').append('<p>'+msg+'</p>');

		 }  
		 
		}) ; 
	 
     return false;
});	
////////////////////////////////////////////CHANGE_CONN_FIRST_BY_SEARCH////////////////////////////////////////////////////////
$('#btnLink6_'+decID).click(function(){ 

	//$(form_message).removeClass().addClass('loading').html(' ').fadeOut( );


	 $('#conn_txt_first'+decID).remove();
	  $('#conn_submit_first'+decID).remove();
	  $('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'>\n"+ 	 
	          
	  "<input type='text' name='conn_txt_first"+decID+"' id='conn_txt_first"+decID+"'  class='mycontrol'  colspan='1'  />\n" + 
	  "<input type='button' name='conn_submit_first"+decID+"' id='conn_submit_first"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש'  />\n" + 
	    "<tr>\n" +
	    "<div id='targetDiv_change"+decID+"'></div>\n"   
	       )).css({'border' : 'solid #dddddd 5px'});
	 //$('#btnLink6_'+decID).unbind();
	 
		 $('input#conn_submit_first'+decID).click(function(){	
	 
		data_change=new Array();
		data_change[0]=($('#conn_txt_first'+decID).val()   );
		data_change[1]=decID;
		var data_b=decID; 
		
			$.ajax({
			   type: "POST",
			   url: "../admin/find3.php",
			   
			   data:  "change_conn_first="  + data_change,
			   success: function(msg){
			 
				   //$('div#my_entry_top').remove();
				// $('div#content_page'+decID).html(' ').append('<p>'+msg+'</p>'); 
				 $('div#targetDiv_change'+decID).html(' ').append('<p>'+msg+'</p>');	
/******************************************************************************************************/				  
$('td.td3head').append('<div id="div#decision_a_'+decID+'"></div>').find('a.change_conn'+decID).css('background-color', 'red').click(function(){
       
        var link = $(this).attr('href') ; 
         var decID=   $(this).attr('decID') ;
        var insertID=   $(this).attr('insertID') ;
        var parentDecID1=   $(this).attr('parentDecID1') ;
        
        
         var str= "change_insert_b";  
              $.ajax({
			   type: "GET",
			   url: "../admin/dynamic_5b.php",
		 
			   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  //"change_insert_b="  + insertID + "&decID=" + decID, 


           	   success: function(msg) {
           	  
           	   $('div#content_page'+decID).remove();
            
               
                   
                  
                    $('div#my_entry_top'+decID).remove();
                  
                   $('div#decision_a_'+decID).empty().append('<p>'+msg+'</p>');
                
              }
              
          });

           
return false;
});//end click              
/*******************************************************************************/					 
}//end success
/*********************************************************************************/				  
});//end ajax1
/**************************/			
return false;
});	//end conn_submit_first click
/***************************/
$('div#targetDiv_change'+decID).empty();
return false;
});//end btnLink6 
		 
/***************************CONN_SECOND_BY_SEARCH*************************************************************/
$('#btnLink3_'+decID).click(function(){ 
///////////////////////////////////////////////////////////////	   
	  $('#conn_txt'+decID).remove();
	  $('#conn_submit'+decID).remove();
	  $('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'>\n"+ 	 
	          
	  "<input type='text' name='conn_txt"+decID+"' id='conn_txt"+decID+"'  class='mycontrol'  colspan='1'  />\n" + 
	  "<input type='button' name='conn_submit"+decID+"' id='conn_submit"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור שני'  />\n" + 
	    "<tr>\n" +
	    "<div id='targetDiv_search2"+decID+"'></div>\n"   
	       )).css({'border' : 'solid #dddddd 5px'});
	  //$('#btnLink3_'+decID).unbind();
		 
		$('input#conn_submit'+decID).click(function(){	
		 
		data=new Array();
		data[0]=($('#conn_txt'+decID).val()   );
		data[1]=decID;
		 
		
	$.ajax({
	   type: "POST",
	   url: "../admin/find3.php",
	   data:  "conn_second="  + data,
	   success: function(msg){
	//$('div#targetDiv_search2'+decID).empty().append('<p>'+msg+'</p>');
 $('div#targetDiv_search2'+decID).html(' ').append('<p>'+msg+'</p>');
/******************************************************************************************************/				  

$('td.td3head').append('<div id="decision_b_'+decID+'"></div>').find('a.change_conn'+decID).css('background-color', 'red').click(function(){	

	        
	         var link = $(this).attr('href') ; 
	          var decID=   $(this).attr('decID') ;
	          var parentDecID1= $(this).attr('parentDecID1') ;
	     
	        
	          var insertID=   $(this).attr('insertID') ;
	          var str= "link_second";  
	               $.ajax({
				   type: "GET",
				   url: "../admin/dynamic_5b.php",
				 
				   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  //"change_insert_b="  + insertID + "&decID=" + decID, 


	            	   success: function(msg) {
	            	  
	            	    $('div#content_page'+decID).remove();
	            	   if(parentDecID1){
	            		  
		            	  
		            	   $('div#my_entry'+parentDecID1).empty();
	            		   $('div#decision_b_'+decID).empty().append('<p>'+msg+'</p>');
	            	    }      
	            	   else{



	              $('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'>\n"+ 	 
	        	          
	            		  "<input type='button' name='btnLink7_"+decID+"' id='btnLink7_"+decID+"'  class='mybutton'  colspan='1' value='בטל קישור שני' />\n"+ 
	            		    "<tr>\n" +
	            		    "<div id='targetDiv_cancel"+decID+"'></div>\n"   
	            		       )).css({'border' : 'solid #dddddd 5px'});

////////////////////////////////////////////CANCEL_CONN_SECOND2////////////////////////////////////////////////////////
	              $('input#btnLink7_'+decID).click(function(){ 
	              

	              $.getJSON('../admin/dynamic_5b.php?cancle&decID='+decID, function(json) {
	              
	             	
	             				   		$.each(json, function(i,item){
	              		   			 
	             				    	 	parentDecID1 =  json.parentDecID1 ;
	             	                        			     
	             				    	 	$('div#my_entry'+parentDecID1).remove();
	             				    	 	//  $('div#decision_b_'+decID).remove();				    		 		 
	             				    	 	 		 
	             				   		});

	             				    
	             				   	});
	  $('input#btnLink7_'+decID).remove();
  return false; 
/************************************************************************************/				
});//end btnLink7	 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	                                           



	   		       
	            		  //$('#btnLink4_'+decID).unbind();


                 


			            	 
	            		  // $('div#my_entry'+insertID).html(' ').append('<p>'+msg+'</p>');
	            		  //$('div#my_entry'+insertID).prependTo('div#my_entry_top'+decID);
	            		   $('div#decision_b_'+decID).html(' ').append('<p>'+msg+'</p>');
	            		   $('div#decision_b_'+decID).prependTo('div#my_entry_top'+decID);
	            	   }
	               }
	           });

	          
	      return false;
	 });//end click Link             		 
/************************************************************************************************/
	  }//end success ajx
/******************/			
	});//end ajax
/*****************************/
return false;			
});//end click conn_submit	
$('div#targetDiv_cancel').html(' ');
$('div#targetDiv_search2').html(' ');
return false;
});//end click btn3
/*********************************************************************************************************************/
////////////////////////////////////////////CANCEL_CONN_SECOND////////////////////////////////////////////////////////
$('#btnLink4_'+decID).click(function(){ 
//	 alert("aaaaaaaaaaaaa");
//	 $('div#btnLink4_'+decID).remove();  
$.getJSON('../admin/dynamic_5b.php?cancle&decID='+decID, function(json) {

		   		
				   		$.each(json, function(i,item){
		   			 
				    	 	parentDecID1 =  json.parentDecID1 ;
	                        			     
				    	 	$('div#my_entry'+parentDecID1).remove();
				    	 	//  $('div#decision_b_'+decID).remove();				    		 		 
				    	 	 		 
				   		});

				    
				   	});
$('input#btnLink4_'+decID).remove();
return false; 
/************************************************************************************/				
});//end btnLink4	 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*****************************************CONN_SECOND_BY_PAGING*****************************************************************/
//$('#btnLink1_'+decID).click(function(){ 
//	   
//	   
//	  $('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'>\n"+ 	
//	    "<div id='targetDiv"+decID+"'></div>\n"   
//	       )).css({'border' : 'solid #dddddd 5px'});
//
//	  var data=decID;
//		
//			$.ajax({
//			   type: "POST",
//			   url: "../admin/dynamic_5b.php",
//			   data:  "conn_second_by_paging="  + data,
//			   success: function(msg){
//			 $('div#targetDiv').empty().append('<p>'+msg+'</p>');
//		}
//	
//      
//  
//  });
////$('div#targetDiv').empty();
//return false; 	 
//});

////////////////////////////////////////////DELETE_DECISION////////////////////////////////////////////////////////
$('#btnDelete_'+decID).click(function(){
	

data=new Array();
	data[0]='realy_delete';
	data[1]=decID;
if(!confirm("האים בטוח שרוצה למחוק?")){
	 return false;
}

$('#btnDelete_'+decID).unbind();
$('#btnLink1_'+decID).unbind();
$('#btnLink3_'+decID).unbind();

	$('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'>\n"+ 	
		    "<div id='targetDiv2' ></div>\n"   
		       )).css({'border' : 'solid #dddddd 5px'});
	
	 $.getJSON('../admin/dynamic_5b.php?cancle&decID='+decID, function(json) {
	 	$.each(json, function(i,item){
	 	 	 
		 	 	parentDecID1 =  json.parentDecID1 ;
		 	 	alert(parentDecID1); 
		 	 	alert(item);
     	 	$('div#my_entry'+parentDecID1).remove();
	    	});
	   	});
	
	
			$.ajax({
			   type: "POST",
			   url: "../admin/dynamic_5b.php",
			   data:  "delete=" + data,
			   success: function(msg){
		   
	             $('#my_entry_top').empty()  ; 
	             $('#my_text_erea'+decID).html(' ')  ;
	             $('#my_date'+decID).find('input').val(' ');	
	             $('#dest_forums'+decID).html(' ')  ;
	             $('#dest_decisionsType'+decID).html(' ')  ;
	             $('#my_vote_level'+decID).val(' '); 
	             $('#my_dec_level'+decID).val(' ');
	             $('#my_status'+decID).val(' ');
	          
	             
	             $('#conn_table'+decID).html(' ')  ;
	             $('#conn_table'+decID).prepend("רשומה נימחקה!").css({'background':'#8EF6F8'});
	             $('.menu_items_dec'+decID).html(' '); 
	             $('#my_fieldset'+decID).prepend("רשומה נימחקה!").css({'background':'#C6EFF0'}); 
	
	                 
	             $('#li'+decID).fadeOut('slow', function(){ $(this).remove(); });

	             $('div#my_entry_top'+decID).remove();
	             $('div#my_entry'+decID).remove();
                $('div#decision_a_'+decID).remove();
                $('div#decision_b_'+decID).remove();


               
          

        }
			
	});
/**************************************************************************************/


/****************************************************************************************/			
	 
 return false; 
});//end btnDelete
	   
/************************************************************************************************/
}//end function
/************************************************************************************************/
 
 $(document).ready(function() { 

	var decID =<?php echo $formdata['decID']; ?>; 



	$('#modal').draggable({axis: 'y', containment: 'parent'});
	 if($.browser.msie){
		 $('#my_dec'+decID).css({'margin-right': '43px'});
	 }
	




	 $('#menu_items_dec'+decID).sortable({
			'stop':sl_recordChange 
		})
		.disableSelection();
	$('<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>')
		.prependTo($('#menu_items_dec'+decID+' > li'));



		
    
<?php 
  $func_name="setupAjaxForm$decID";
 ?>;
       
	   new  <?php echo $func_name ;?>('decision_'+decID);


	   




/************************************************************************************************/
	 $("#loading img").ajaxStart(function(){
	   $(this).show();
	 }).ajaxStop(function(){
	   $(this).hide();
	 });
 });

</script>

 



<?php  
/*************************************************************************************************/  
}//end build ajx_form 
/*************************************************************************************************/







 