<?php
 require_once ("../config/application.php");
 

//=============================================================================
 class category {
 
 	public  $managerid;
	public  $managertypename;
	public  $parentmanagerid;
	public  $insertID ; 
    public  $deleteID ; 
    public  $updateID ; 
    public  $submitbutton;  
    public  $subcategories; 
    public   $src_mgrTypeID;
    
 
function __construct($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		 $this->setsubcategories($subcategories);
		 $this->setupdateID($updateID);
	 	 $this->setsrc_mgrTypeID($updateID);
	}
    
 function setsrc_mgrTypeID($src_mgrTypeID) {
		$this->src_mgrTypeID = $src_mgrTypeID;
	}	
	
	
 	function setdeleteID($deleteID) {
		$this->deleteID = $deleteID;
	}
	
	
 function setinsertID($insertID) {
		$this->insertID = $insertID;
	}
	
 function setsubmitbutton($submitbutton) {
		$this->submitbutton = $submitbutton;
	}
	
  function setsubcategories($subcategories) {
		$this->subcategories = $subcategories;
	}
 function setupdateID($updateID) {
		$this->updateID = $updateID;
	}
	
/*****************************************************************************************/	 
function getdeleteID() {
		return $this->deleteID;
	}
	
function getinsertID() {
		return $this->insertID;
	}
 function getsubmitbutton() {
		return $this->submitbutton;
	}
	function getsubcategories() {
		return $this->subcategories;
	}
	
 function getupdateID() {
		return $this->updateID;
	}
	
	
/**********************************************************************************/	
	 
	function setId($catid) {
		$this->id = $catid;
	}
	
	
 function setName($catname) {
		$this->catname = $catname;
	}
	
 function setParent($parentcatid) {
		$this->parentcatid = $parentcatid;
	}
/************************************************************************************/	
	
function getId() {
		return $this->catid;
	}
	
	function getName() {
		return $this->catName;
	}
    
	function getParent() {
		return $this->parentcatid;
	}

/************************************************************************************/
   
     	 function check(&$err_msg) {
		return 1;
		$err_msg = "";
		if( strlen($this->catName) < 1)
			$err_msg = "String too short";
			
				
		return $err_msg=="";
	}
	 
/************************************************************************************/	
function check_root($src_mgrTypeID, $subcategories,$mode){
/*****************************************************************************/
global $db;
$insertID =$subcategories;
 if($insertID=='none' || $insertID==0)
 return;
 

$catID=$src_mgrTypeID;//the node to connect to $inserID

if($insertID==$catID){
		?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר קטגורייה לעצמה או לבניה!</h2><?php  
	return FALSE;
}
/*****************************************************************************/

		$sql  = "SELECT 	managerTypeID, 
				managerTypeName, 
				parentManagerTypeID, 
				managerTypeDate
				 
				FROM 
				manager_type ORDER BY managerTypeName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			 
			$parents[$row->managerTypeID] = $row->parentManagerTypeID;
			$parents_b[$row->managerTypeID] = $row->parentManagerTypeID;
			$subcats[$row->parentManagerTypeID][] = $row->managerTypeID;   }

			// build list of all parents for $insertID
			$cat_ID = $insertID;
			while($parents[$cat_ID]!=NULL) {
				$cat_ID = $parents[$cat_ID];
				$parentList[] = $cat_ID; 
			}
			
			
            $categoryID = $insertID;
			while($parents_b[$categoryID]!=NULL && $parents_b[$categoryID]!=$categoryID) {
				$categoryID = $parents_b[$categoryID];
				$parentList_b[] = $categoryID; 
			}
			
			
		if($subcats[$catID]){	
			if(   in_array($insertID, $subcats[$catID]) 
			||    in_array($parents[$insertID],$subcats[$catID] ) 
			||    in_array($categoryID,$subcats[$catID] )
			||    $parents[$insertID]== $catID 
		   
			){
			 
			 ?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר קטגורייה לעצמה או לבניה!</h2><?php  
			return FALSE;
			}
		}elseif( $insertID==$catID){
			
			 ?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר קטגורייה לעצמה או לבניה!</h2><?php  
			return FALSE;
			 
		}	

		

/*******************************************************************************/

		

 		 if($mode=='get_link')	
	    $sql="UPDATE manager_type set parentManagerTypeID=$insertID WHERE managerTypeID=$src_mgrTypeID "; 	
	     
	     if(!$db->execute($sql))
	    return FALSE; 
	
 	
	  return true;
}            
	
 	
 	
 
/*******************************************************************************/	
	 
/*****************************************************************************/
	function change_link($mode=''){	
 
	
	$src_mgrTypeID=$this->src_mgrTypeID;
	$submitbutton=$this->submitbutton; 
	$submitbutton_cancle=$this->submitbutton_cancle; 
	$subcategories=$this->subcategories;
	global $db;
  	
	
	
	
	
  $sql = "SELECT COUNT(*) FROM manager_type WHERE managerTypeID='$src_mgrTypeID'";
  $n = $db->querySingleItem($sql); 

 
 if($src_mgrTypeID && $n==1) {
 
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if(  !($this->check_root($src_mgrTypeID, $subcategories,$mode))){
      $db->execute("ROLLBACK");
    }else{ 
    	$db->execute("COMMIT");
      echo "<p class='error'>שונה קישור.</p>\n";
    }
    
   }

if($mode=='get_link' && !($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST['form'], 'submitbutton')=='שנה קישור')){
		   	 echo '<fieldset class="my_pageCount" >'; 
		     $this->print_category_entry_form($src_mgrTypeID,$mode);
		     echo '</fieldset>';
		      
		   }
  	
  
  }

$this->print_form();   
      
}     
/************************************************************************************/		
//==================================================================================== 
	
	
	
	function update() {
		
		$sql = "UPDATE manager_type SET
				managerTypeName='".$this->getName() . "'
				,ParentManagerID='".$this->getParent()."'
				WHERE managerID = ". $this->getId();
		//echo $sql;
		 return execute_query($sql);
				
	}
	
	
	 

/*********************************************************************/	 
function read_form(){
	     
	 
     	 $insertID      = array_item($_REQUEST, 'insertID');
         $deleteID      = array_item($_REQUEST, 'deleteID');
         $updateID      = array_item($_REQUEST, 'updateID');
         $submitbutton  = array_item($_POST, 'submitbutton');
         $subcategories = array_item($_POST, 'subcategories');
        // remove magic quotes
        if(get_magic_quotes_gpc())
        $subcategories = stripslashes($subcategories);
}

 
/*******************************************************************************************/
function del_category($deleteID){
 	global $db;   
              $sql = "SELECT COUNT(*) FROM manager_type WHERE managerTypeID=$deleteID";
            if($db->querySingleItem($sql)==1) {
              $db->execute("START TRANSACTION");
              $query = "set foreign_key_checks=0";
              $db->execute($query);
            if($this->delete_cat_sub($deleteID)==-1){
              $db->execute("ROLLBACK");
              $db->execute("set foreign_key_checks=1");
            }else{
              $db->execute("COMMIT");
              $db->execute("set foreign_key_checks=1");
                echo "<p class='error'>קטגוריה  נימחקה.</p>\n";
            
            }
      }    
 	
    }
/**********************************************************************************/
	// delete a category
	// return  1, if category and its subcategories could be deleted
	// returns 0, if the category could not be deleted
	// return -1 if an error happens

	function delete_cat_sub($managerID) {
		// find subcategories to catID and delete them
		// by calling delete_category recursively
		global $db;
		$sql = "SELECT managerTypeID,parentManagerTypeID FROM manager_type " .
         "WHERE parentManagerTypeID='$managerID'";
		if($rows = $db->queryObjectArray($sql)) {
			$deletedRows = 0;
			foreach($rows as $row) {
					
				$result =$this->delete_cat_sub($row->managerTypeID);
				if($result==-1)
				return -1;
				else
				$deletedRows++;
			}
			// if any subcategories could not be deleted,
			// don't delete this category as well
			if($deletedRows != count($rows))
			return 0;
		}

	if($managerID==11) {
			echo "<br /><h2 class='error'>אי אפשר למחוק החלטות אב   .</h2>\n";
			return -1;
		}
/*******************************************************************/    		
	$sql = "SELECT m.managerTypeID,m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			INNER JOIN rel_managerType_forum r ON 	m.managerTypeID = r.managerTypeID		
			INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.managerTypeID=$managerID";
		 
		 
		 
		  
		 
		 if($rows2 = $db->queryObjectArray($sql)) {
  	  
  	
  	 $mgr_Catname =$rows2[0]->managerTypeName;
  	 $n=count($rows2);	
  	 
    printf("<h2><br /><b style='color:green;'>  סוגי מנהלים %s עדיין קיימים ב- %d פורומים. " .
           "אי אפשר למחוק.</b></h2>\n", $mgr_Catname, $n);
    
    
    

  	echo "<ol>";
 		
				
  	foreach ($rows2 as $row){
  		 if($row->forum_decName != NULL){
  		$url="../admin/find3.php?forum_decID=$row->managerTypeID";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		 
				 printf("<li><h2 class='error'> %s (%s, %s, %s, %s, %s )<h2></li>\n",
		            
							htmlspecial_utf8($row->forum_decName),
							build_href2("dynamic_10.php","mode=insert","&insertID=$row->forum_decID", "הוסף"),
							build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$row->forum_decID", "מחק","OnClick='return verify();'"),
							build_href2("forum_category.php" ,"mode=update","&updateID=$row->forum_decID", "עדכן"),
						    build_href2("dynamic_10.php" ,"mode=read_data","&editID=$row->forum_decID", "עידכון מורחב"),
						    build_href5("", "", "הראה נתונים",$str)); 
						
							
  	        	 }
  			}
   echo "</ol>"; 
		    
   
    return -1;
  }
 	
/**********************************************************************/  
		// delete category
		$sql = "DELETE FROM manager_type WHERE managerTypeID='$managerID' LIMIT 1";
		if($db->execute($sql))
		return 1;
		else
		return -1;
			
	}
 		
  
  
	
/*******************************************************************************************************/
	 // test if variable insertID was set to a valid value
function add_cat(){
	
	$insertID=$this->insertID;
	$submitbutton=$this->submitbutton; 
	$subcategories=$this->subcategories;
	global $db;
  	
  $sql = "SELECT COUNT(*) FROM manager_type WHERE managerTypeID='$insertID'";
  $n = $db->querySingleItem($sql); 

// if url had valid insertID, show this category and
// an input form for new subcategories
if($insertID && $n==1) {
  echo "<h1>הוסף/עדכן סוג מנהל חדש</h1>\n";

  // if there is form data to process, insert new
  // subcategories into database
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->insert_new_categories($insertID, $subcategories))
      $db->execute("COMMIT");
    else
      $db->execute("ROLLBACK"); }
      
      
if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST, 'submitbutton')=='OK')){  	      
echo '<fieldset class="my_pageCount" >'; 
  $this->print_category_entry_form($insertID);
echo '</fieldset class="my_pageCount" >';    
  }
}  
$this->print_form();
      
}     
/******************************************************************************************************/ 
// insert new subcategories to given category
function insert_new_categories($insertID, $subcategories) {
  global $db;
  $subcatarray = explode(";", $subcategories);
  $count = 0;
  foreach($subcatarray as $newcatname) {
    $result =$this->insert_new_category($insertID, trim($newcatname));
    if($result == -1) {
      echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
      return FALSE; }
    elseif($result) 
      $count++;
  }
  if($count)
    if($count==1)
      echo "<p class='error'>קטגוריה חדשה נוספה.</p>\n";
    else
      echo "<p class='error'>$count קטגוריות חדשות נוספו.</p>\n";
  return TRUE;
}
/*******************************************************************************************************/
function insert_new_category($insertID, $newcatName,$mode='') {
  global $db;
  // test if newcatName is empty
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM manager_type " .
         "WHERE parentManagerTypeID=$insertID " .
         "  AND managerTypeName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo " כבר קיים מנהל בשם הזה";
  	//show_error_msg("מנהל לא יכול לנהל את עצמו");
    return 0; 
  }
////////////////////////////////////////////////////////////////////////////////////

if(!($mode=='update')){
  
 $sql = "INSERT INTO manager_type(managerTypeName, parentManagerTypeID) " .
         "VALUES ($newcatName, $insertID)";//$new_Usrmgr)";
}else{
	 $sql = "update  manager_type set managerTypeName=$newcatName where managerTypeID=$insertID " ;  
    
}
  if($db->execute($sql))
    return 1;
  else
    return -1;
}  
  
/***************************************************************************************************/ 

/***************************************************************************************************/       
//update a new category in the categories table
//======================================================
// returns -1, if error
//         1,  if category could be saved
//         0,  if category could not be saved
function update_category_general(){ 
	
 	
	$mode='update';	
	$updateID=$this->updateID;
	$submitbutton=$this->submitbutton; 
	$subcategories=$this->subcategories;
	global $db;
  	
  $sql = "SELECT COUNT(*) FROM manager_type WHERE managerTypeID='$updateID'";
  $n = $db->querySingleItem($sql); 

// if url had valid updateID, show this category and
// an input form for new subcategories
if($updateID && $n==1) {
//echo '<fieldset class="my_pageCount" >'; 	
//  echo "<h1>עדכן סוג מנהל</h1>\n";

  // if there is form data to process, update new
  // subcategories into database
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->update_categories($updateID, $subcategories,$mode))
      $db->execute("COMMIT");
    else
      $db->execute("ROLLBACK"); }
 if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST, 'submitbutton')=='OK')){ 
 echo '<fieldset class="my_pageCount" >'; 	
  $this->print_category_entry_form($updateID,$mode);
   echo '</fieldset>'; 
 }
   $this->print_form();
  }
  
  
 }     
     
/*************************************************************************************************/

// update new subcategories to given category
function update_categories($updateID, $subcategories,$mode) {
  global $db;
   $subcatarray = explode(";", $subcategories);
   //$subcat=$subcategories;
  $count = 0;
  foreach($subcatarray as $newcatname) {
    //$result =$this->update_new_category($updateID, trim($newcatname));
    $result =$this->insert_new_category($updateID, trim($newcatname),$mode);
    if($result == -1) {
      echo "<p class='error'>בעייה במערכת כלום לא נשמר!</p>\n";
      return FALSE; }
    elseif($result)
      $count++;
  }
  if($count)
    if($count==1)
        echo "<p class='error'>קטגוריה  עודכנה.</p>\n";
     
  return TRUE;
}
//===================================================================================

 function print_categories($catIDs, $subcats, $catNames,$parent) {
 	
 global $db; 	
 	
  echo '<ul>';
 foreach($catIDs as $managerID) {
  $url="../admin/find3.php?managerTypeID=$managerID";
  $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
  $sql = "SELECT DISTINCT( m.managerTypeID),m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			LEFT JOIN rel_managerType_forum r ON 	m.managerTypeID = r.managerTypeID		
			LEFT JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.managerTypeID=$managerID ";		
 $rows=$db->queryObjectArray($sql) ;
  
  	if($managerID==11){
  		    printf("<li id=li$managerID style='font-weight:bold;color:#9F0038;font-size:18px;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','#F700F5').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','#9F0038').css('font-size', '18px')\"><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b>%s (%s, %s)</b></li>\n",
            htmlspecial_utf8($catNames[$managerID]),
            build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
	        build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"));
			}
/**********************************************************************************************************************************/			
		elseif($parent[$managerID][0]=='11' && !(array_item($subcats,$managerID)) ){	 

	$sql = "SELECT DISTINCT( m.managerTypeID),m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			LEFT JOIN rel_managerType_forum r ON 	m.managerTypeID = r.managerTypeID		
			LEFT JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.managerTypeID=$managerID ";		
if( $rows[0]->forum_decID){		
 
      printf("<li id=li$managerID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s,%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$managerID]),
      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
      build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור"),
      build_href5("", "", "הראה נתונים",$str));
	}else{
	  printf("<li id=li$managerID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$managerID]),
      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
      build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור"));
		
		
	  }  
      
  	}
  	
  	
/************************************************************************************************************************************/  	
  	
  	
  	elseif($parent[$managerID][0]=='11' &&  array_item($subcats,$managerID)  ){
  		
  	$sql = "SELECT DISTINCT( m.managerTypeID),m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			LEFT  JOIN rel_managerType_forum r ON 	m.managerTypeID = r.managerTypeID		
			LEFT  JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.managerTypeID=$managerID ";		
 	if(  $rows[0]->forum_decID){		
//	if($rows[0]->forum_decID && $rows[0]->forum_decID!=null){		
  		
  		
  		
  	printf("<li id=li$managerID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s,%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$managerID]),
      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
       build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור"),
      build_href5("", "", "הראה נתונים",$str));
      
  	  }else{
  	  printf("<li id=li$managerID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$managerID]),
      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
      build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור"));   	
  	     	
  	     	
  	     }
  	}  	
/************************************************************************************************************************************/  	
  	else{ 
  		
  	$sql = "SELECT DISTINCT( m.managerTypeID),m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			LEFT JOIN rel_managerType_forum r ON 	(m.managerTypeID = r.managerTypeID)		
			LEFT JOIN forum_dec f ON (f.forum_decID = r.forum_decID )
			WHERE  m.managerTypeID=$managerID ";
  	
//	if($rows=$db->queryObjectArray($sql))	
// 
//	if($rows[0]->forum_decID){		
  if( $rows[0]->forum_decID){			
  		
  	printf("<li id=li$managerID   style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s,%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$managerID]),
      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
      build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור"),
      build_href5("", "", "הראה נתונים",$str));
	  }else{
	  	
	  printf("<li id=li$managerID   style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$managerID]),
      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
      build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור"));
	  	
	  }
      
  	}
  	
/**************************************************************************************************************************************/ 
    if(array_key_exists($managerID, $subcats)) 
      $this->print_categories($subcats[$managerID], $subcats, $catNames,$parent);
    }
  
   echo "</li></ul>\n";
}

 //===================================================================================

// function print_categories($catIDs, $subcats, $catNames,$parent) {
//  echo '<ul>';
// foreach($catIDs as $managerID) {
//  $url="../admin/find3.php?managerTypeID=$managerID";
//  $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
//  	if($managerID==11){
//  		    printf("<li id=li$managerID style='font-weight:bold;color:#9F0038;font-size:18px;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','#F700F5').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','#9F0038').css('font-size', '18px')\"><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b>%s (%s, %s)</b></li>\n",
//            htmlspecial_utf8($catNames[$managerID]),
//            build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
//	        build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"));
//			}
//			
//		elseif($parent[$managerID][0]=='11' && !(array_item($subcats,$managerID)) ){	 
//    
//    printf("<li id=li$managerID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
//      htmlspecial_utf8($catNames[$managerID]),
//      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
//      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
//      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
//      build_href5("", "", "הראה נתונים",$str));
//     
//      
//  	}elseif($parent[$managerID][0]=='11' &&  array_item($subcats,$managerID)  ){
//  	printf("<li id=li$managerID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
//      htmlspecial_utf8($catNames[$managerID]),
//      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
//      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
//      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
//      build_href5("", "", "הראה נתונים",$str));
//      
//  	}else{ 
//  	printf("<li id=li$managerID   style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$managerID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$managerID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
//      htmlspecial_utf8($catNames[$managerID]),
//      build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
//      build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();' class='href_modal1'"),
//      build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
//      build_href5("", "", "הראה נתונים",$str));
//      
//  	}
//  	
// 
//    if(array_key_exists($managerID, $subcats))
//      $this->print_categories($subcats[$managerID], $subcats, $catNames,$parent);
//  }
//   echo "</li></ul>\n";
//}

 
/*******************************************************************************/

/*******************************************************************************/
function link_div(){
echo  '<div>';	
echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
		echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
		$url="../admin/forum_demo12_2.php";
	        $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";

	   echo "<td><p><b> ",build_href2("manager_category.php", "","", "עריכת סוגי מנהלים","class=my_decLink_root title='סוגי מנהלים'") . " </b></p></td>\n";     
	        
	        
       echo "<td><p><b> ",build_href2("../admin/database6.php", "","", "עץ סוגי מנהלים","class=my_decLink_root title='עץ סוגי המנהלים'") . " </b></p></td></tr></table>\n";	

       
?>

<table style="width:50%;">
<tr>
<td>     
    <?php form_label1('חתכי סוגי החלטות:',TRUE); ?>
     <a href='#' title='חתכי סוגי החלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>  
</td>

<td> 
<?php form_label1('חתכי סוגי פורומים:',TRUE); ?>
         <a href='#' title='חתכי סוגי פורומים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>
</td>     
  
  
  
<td> 
 <?php form_label1('חתכי סוגי מנהלים:',TRUE); ?>    
     <a href='#' title='חתכי סוגי מנהלים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJAX/default.php'"; ?> ,'סוגי המנהלים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>                                                               
                                                      
</td></tr></table>                
 <?php  	             	      	
       
echo '</div>';	
}	
///////////////////////////////////////////////////////////////////////////////////////////////////////

 function  print_form() {
 	
 	
	global $db;
 
// echo "<h1>בחר סוג מנהל</h1>\n";
//  echo "<p style='font-weight:bold;color:#3C23AB;'>לחץ להוסיף/למחוק/לעדכן או לראות נתונים על סוגי מנהלים.</p>\n";


  // query for all categories
  $sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
  $rows = $db->queryObjectArray($sql);
  // build two arrays:
  //   subcats[catID] contains an array with all sub-catIDs
  //   catNames[catID] contains the catName for catID
  foreach($rows as $row) {
    $subcats[$row->parentManagerTypeID][] = $row->managerTypeID;
    $catNames[$row->managerTypeID] = $row->managerTypeName; 
    $parent[$row->managerTypeID][] = $row->parentManagerTypeID; }

    
    echo '<ul class="paginated" style=left:100px;  >';
    echo'<fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">'; 
    
   $this->print_categories($subcats[NULL], $subcats, $catNames,$parent);
    echo'</fieldset>'; 
      echo '</ul class="paginated">';
    echo '<BR><BR>'; 
    
  
   }
   
   
   
/******************************************************************************************************/

   function print_category_entry_form($updateID,$mode='') {
		global $db;
$insertID=$updateID;		
		
    $sql  = "SELECT managerTypeName, managerTypeID, parentManagerTypeID " .
          "FROM manager_type ORDER BY managerTypeName";
  $rows = $db->queryObjectArray($sql);

  // build assoc. arrays for name, parent and subcats
  foreach($rows as $row) {
   $catNames[$row->managerTypeID] = $row->managerTypeName;
    $parents[$row->managerTypeID] = $row->parentManagerTypeID;
    $subcats[$row->parentManagerTypeID][] = $row->managerTypeID;   }
		

			// build list of all parents for $updateID
			$managerID = $updateID;
			while($parents[$managerID]!=NULL) {
				  $managerID = $parents[$managerID];
				  $parentList[] = $managerID; }

 
				  
				
////////////////////////////////////////////////////////////////////////////////////////				 
				 
if(isset($parentList)){
for($i=sizeof($parentList)-1; $i>=0; $i--){
	$managerTypeID=$parentList[$i];	 
		$url="../admin/find3.php?managerTypeID=$managerTypeID ";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
      	
	  if( $parentList[$i] =='11'){
                printf("<ul><li><b> %s (%s, %s )</b> </li>\n",
	            htmlspecial_utf8($catNames[$parentList[$i]]),
	            build_href2("manager_category.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
		        build_href2("manager_category.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"));					
		}
/**********************************************************************************************************/		
		else{
				
			$sql = "SELECT DISTINCT( m.managerTypeID),m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			INNER JOIN rel_managerType_forum r ON 	m.managerTypeID = r.managerTypeID		
			INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.managerTypeID='$managerTypeID'";
		
 	if($rows=$db->queryObjectArray($sql))	{ 
     if ($rows[0]->forum_decID) {
			
		        printf("<ul><li><b> %s (%s, %s, %s, %s,%s )</b> </li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("manager_category.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("manager_category.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("manager_category.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"),
				build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$parentList[$i]", "שנה קישור","class=href_modal1"),
				build_href5("", "", "הראה נתונים",$str)); 
				                 
	 	}
	   }else{
	   	
	      	    printf("<ul><li><b> %s (%s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("manager_category.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("manager_category.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("manager_category.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"),
				build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$parentList[$i]", "שנה קישור","class=href_modal1")); 
	   	
	   	
	   }	
	}  
/************************************************************************************************************/				
  }//end for
/********************/  
}	
	 
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	$url="find3.php?managerTypeID=$updateID";
   	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
	  // display choosen forum  * BOLD *
   		 	 if($insertID=='11'){
   		 	 	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("manager_category.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("manager_category.php","mode=update","&updateID=$updateID", "עדכן")); 
				
   		 	 }
   		 	 
/*******************************************************************************************************/   		 	 
   		 	 else{
   		 	 	
   		 	 		
			$sql = "SELECT DISTINCT( m.managerTypeID),m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			INNER JOIN rel_managerType_forum r ON 	m.managerTypeID = r.managerTypeID		
			INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.managerTypeID='$updateID' ";
		
			if($rows=$db->queryObjectArray($sql)){ 
		            if ($rows[0]->forum_decID) {
		   		 	 	    
   		 	 	
			 	printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("manager_category.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("manager_category.php" ,"mode=delete","&deleteID=$updateID", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("manager_category.php" ,"mode=update","&updateID=$updateID", "עדכן"),
				build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$updateID", "שנה קישור","class=href_modal1"),
				build_href5("", "", "הראה נתונים",$str)); 
		            }
			}else{
				printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("manager_category.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("manager_category.php" ,"mode=delete","&deleteID=$updateID", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("manager_category.php" ,"mode=update","&updateID=$updateID", "עדכן"),
				build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$updateID", "שנה קישור","class=href_modal1"));
				
				
			}
   	}		
/*************************************************************************************************************************/
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $managerID) {
			  $url="find3.php?managerTypeID=$managerID";
   	          $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';

   	          $sql = "SELECT DISTINCT( m.managerTypeID),m.managerTypeName,f.forum_decID,f.forum_decName  FROM manager_type m  
			  INNER JOIN rel_managerType_forum r ON 	m.managerTypeID = r.managerTypeID		
			  INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			  WHERE  r.managerTypeID='$managerID' ";
		
 			if($rows=$db->queryObjectArray($sql)  ) 
 		            if ($rows[0]->forum_decID) {
   	          
				printf("<li><b> %s (%s,%s, %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$managerID]),
				build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
				build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
			    build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור","class=href_modal1"),
			 	build_href5("", "", "הראה נתונים",$str));
//		            }
			}else{
				printf("<li><b> %s (%s, %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$managerID]),
				build_href2("manager_category.php","mode=insert","&insertID=$managerID", "הוסף"),
				build_href2("manager_category.php" ,"mode=delete","&deleteID=$managerID", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("manager_category.php" ,"mode=update","&updateID=$managerID", "עדכן"),
			    build_href2("manager_category.php","mode=change_link","&src_mgrTypeID=$managerID", "שנה קישור","class=href_modal1"));
				
			}      			
		}
/*************************************************************************************************************************/		
		echo "<ul>";
			   
		     $updateID=$managerID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-סוגי מנהלים.)";
		}
				
		 
 echo "</ul>\n";
 
 	if(isset($parentList))
	echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

/***************************************************************************************/    
if(($mode=='get_link')){ 
 ?>
   <form method="post"  id="my_category"  action="manager_category.php?mode=change_link&src_mgrTypeID=<?php echo  $insertID; ?> "  >
    <table  class="data_table" id="data_table"><tr><td>
	  
	 
       
<?php
$sql = "SELECT managerTypeName,managerTypeID,parentManagerTypeID FROM manager_type ORDER BY managerTypeName ";
				$rows = $db->queryObjectArray($sql);
foreach($rows as $row) {
			      $subcats6[$row->parentManagerTypeID][] = $row->managerTypeID;
			      $catNames6[$row->managerTypeID] = $row->managerTypeName; }
			  
			      $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			      
			      
			      
		        form_list_b("mgrType" , $rows, array_item($formdata, "mgrType") );
 			    
 ?>
 
    </td></tr></table>
   <input type="submit" name="submitbutton" value="שנה קישור" /><br /> 
   </form>
<?php
 			    
/**********************************************************************************************************************/ 			    
}elseif(!($mode=='update')){
     
echo '<form method="post" action="manager_category.php?mode=insert&insertID=',$insertID, '">', "\n",
    "<p>הוסף תת קטגוריה אל ",
    "<b>$catNames[$insertID]</b>. <br />אפשר להוסיף כמה",
    " תת-קטגוריות בפעם אחת. <br />השתמש בנקודה פסיק(;) ",
    "להפריד ביניהם.</p>\n".
    '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" name="submitbutton" value="ok"  /></p>', "\n",
      
    "</form>\n"; 
 
}else{
   echo '<form method="post" action="manager_category.php?mode=update&updateID=',
     $insertID, '">', "\n",
    "<p>עדכן קטגוריה של ",
    "<b>$catNames[$insertID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";
}

    
//$this->print_form();   
//   
//  
//  echo "<p>חזרה אל ",
//    build_href("manager_category.php", "", "רשימת הקטגוריות") . ".\n";
   
   }

/*****************************************************************************************************/  
 }	
/******************************************************************************************/ 
 
 
 html_header();
  ?>
<script type="text/javascript" src="ajax.lang.php"></script> 
<script type="text/javascript">

turn_red_error();
</script> 
<?php  
//is_logged();      
 
switch ($_REQUEST['mode']) {
	 
	 
	case "update":
    
	     update_cat($_GET['updateID']);	
		
		break;
		
  										
    case "delete":
               delete_cat($_GET['deleteID']);
		     
         
       
			
		       
 		break;
	  	
					
		 case "insert":
                       
                insert_cat($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
                //else
                      
               
	  	break;
		
	  	
	  	
	  	case "change_link":
    
	      change_link_cat($_GET['src_mgrTypeID'],$_POST['submitbutton'],$_POST['form']['mgrType']);	
		
		break;

		function change_link_cat($linkID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['mgrType'],"",$_GET['src_mgrTypeID']);
 	            $mode="get_link";
 	             $c->link_div();	
 	      	   $c->change_link("$mode");
      }   
 
	default:
	case "list":
 		
    $c=new category();
    $c->link_div();
    $c->print_form();
} 
 
  function delete_cat($deleteID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_GET['deleteID']);
 	           $c->del_category($deleteID);
 	            $c->link_div();	
 	           $c->print_form();
              
  }     
 
  function insert_cat($insertID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
 	            $c->link_div();	
 	      	   $c->add_cat();
 	      	   //$c->print_form();
  }

  function update_cat($updateID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
 	            $c->link_div();	
 	      	   $c->update_category_general();
 	      	  // $c->print_form();
  }

  function change_link_cat($linkID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['mgrType'],"",$_GET['src_mgrTypeID']);
 	            $mode="get_link";
 	             $c->link_div();	
 	      	   $c->change_link("$mode");
 }   
  
  
 html_footer();
 
  
 
?>
