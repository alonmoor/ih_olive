<?php


require_once '../config/application.php';
global $db;
 
 
if(isset($_GET['read_decision_tree']) && $_GET['read_decision_tree'] != ''){
/****************/
//$safeCat = (int)$_POST['category1'];
//	function print_decision_entry_form1_b($updateID,$mode='') {
		global $db;
		
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
		
	
		
		
$updateID=(int)$_GET['read_decision_tree'];		
$insertID=(int)$_GET['read_decision_tree'];			
//echo "------------------------------------------------------------------------";      
?>
<div id="my_entry_ajx<?PHP echo $updateID;?>"  name="my_entry<?PHP echo $updateID;?>">
<input type="hidden" id="my_entry_ajx_hidden<?PHP echo $updateID;?>" name="my_entry_ajx_hidden<?PHP echo $updateID;?>" value="<?PHP echo $updateID;?>"/>
<?php  
		
		$sql  = "SELECT decName, decID, parentDecID " .
          "FROM decisions ORDER BY decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
 			$decNames[$row->decID] = $row->decName;
			$parents[$row->decID] = $row->parentDecID;
			$subcats[$row->parentDecID][] = $row->decID;   }
			
     			
			// build list of all parents for $updateID
			$decID = $updateID;
			while($parents[$decID]!=NULL) {
				  $decID = $parents[$decID];
				  $parentList[] = $decID; }
echo "
					 <a class='tooltip_find' href='#'>
							 ?<span class='custom critical'>
							 
							 
							 <em>?</em>החלטות שקשורות להחלטות שבאו בעקבותיהם!
							  
							 </span>
						</a> ";	
 
				  
if($level){					
////////////////////////////////////////////////////////////////////////////////////////				 
				 
if(isset($parentList)){
for($i=sizeof($parentList)-1; $i>=0; $i--){
		 $url="../admin/find3.php?decID=$parentList[$i]";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';				 
	  if( $parentList[$i] =='11'){
                printf("<ul><li style='font-weight :bold;'><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s (%s, %s )</b> </li>\n",
	            htmlspecial_utf8($decNames[$parentList[$i]]),
	            build_href2("dynamic_5b.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
		        build_href2("dynamic_5b.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"));					
		}else{
				
		        printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
				htmlspecial_utf8($decNames[$parentList[$i]]),
				build_href2("dynamic_5b.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("dynamic_5b.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק"),
				build_href2("dynamic_5b.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"),
				build_href2("dynamic_5b.php" ,"mode=read_data","&editID=$parentList[$i]", "עידכון מורחב"),
				build_href5("", "", "הראה נתונים",$str)); 
                      
				 
				
				}
				
			}
	  }		
				 
				 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 		
	  // display choosen forum  * BOLD *
   		 	  if($insertID=='11'){
   		 	 	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
				htmlspecial_utf8($decNames[$updateID]),
				build_href2("dynamic_5b.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("dynamic_5b.php","mode=update","&updateID=$updateID", "עדכן")); 
				
   		 	 }else{
   		 	 	$url="../admin/find3.php?decID=$updateID";
      	        $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
			 	printf("<ul><li><b style='color:brown;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($decNames[$updateID]),
				build_href2("dynamic_5b.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("dynamic_5b.php" ,"mode=delete","&deleteID=$updateID", "מחק"),
				build_href2("dynamic_5b.php" ,"mode=update","&updateID=$updateID", "עדכן"),
				build_href2("dynamic_5b.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
				build_href5("", "", "הראה נתונים",$str)); 
   		 	 }	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $decID) {
			  $url="find3.php?decID=$decID";
   	          $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
				printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
				htmlspecial_utf8($decNames[$decID]),
				build_href2("dynamic_5b.php","mode=insert","&insertID=$decID", "הוסף"),
				build_href2("dynamic_5b.php" ,"mode=delete","&deleteID=$decID", "מחק"),
				build_href2("dynamic_5b.php" ,"mode=update","&updateID=$decID", "עדכן"),
				build_href2("dynamic_5b.php" ,"mode=read_data","&editID=$decID", "עידכון מורחב"),
				build_href5("", "", "הראה נתונים",$str)); 
							
		}
		echo "<ul>";
			   
		     $updateID=$decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-החלטות.)";
		}
				
		 
 echo "</ul>\n";
 
 	if(isset($parentList))
	echo str_repeat("</ul>", sizeof($parentList)+1), "\n";


////////////////////////	
}elseif(!($level)){ ///  
//////////////////////     
     if(isset($parentList)){
for($i=sizeof($parentList)-1; $i>=0; $i--){
		 $url="../admin/find3.php?decID=$parentList[$i]";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';				 
	  if( $parentList[$i] =='11'){
                printf("<ul><li style='font-weight :bold;'><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s </b> </li>\n",
	            htmlspecial_utf8($decNames[$parentList[$i]]));					
		}else{
				
		        printf("<ul><li style='font-weight :bold;'> %s (%s, %s) </li>\n",
				htmlspecial_utf8($decNames[$parentList[$i]]),
				build_href2("dynamic_5b.php" ,"mode=read_data","&editID=$parentList[$i]", "מידע  מורחב"),
				build_href5("", "", "הראה נתונים",$str)); 
                      
				 
				
				}
				
			}
	  }		
				 
				 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 		
	  // display choosen forum  * BOLD *
   		 	  if($insertID=='11'){
   		 	 	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
				htmlspecial_utf8($decNames[$updateID])); 
				
   		 	 }else{
   		 	 	$url="../admin/find3.php?decID=$updateID";
      	        $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
			 	printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
				htmlspecial_utf8($decNames[$updateID]),
				build_href2("dynamic_5b.php" ,"mode=read_data","&editID=$updateID", "מידע  מורחב"),
				build_href5("", "", "הראה נתונים",$str)); 
   		 	 }	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $decID) {
			  $url="find3.php?decID=$decID";
   	          $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
				printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",
				htmlspecial_utf8($decNames[$decID]),
				build_href2("dynamic_5b.php" ,"mode=read_data","&editID=$decID", "מידע  מורחב"),
				build_href5("", "", "הראה נתונים",$str)); 
							
		}
		echo "<ul>";
			   
		     $updateID=$decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-החלטות.)";
		}
				
		 
 echo "</ul>\n";
 
 	if(isset($parentList))
	echo str_repeat("</ul>", sizeof($parentList)+1), "\n";
        
       }
/*****************************************************************************************************/
	}//end func
/*****************************************************************************************************/