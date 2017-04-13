<?php
 require_once ("../config/application.php");
 //session_start();

//=============================================================================
 class category {
 
 	public  $catid;
	public  $catname;
	public  $parentcatid;
	public  $insertID ; 
    public  $deleteID ; 
    public  $updateID ; 
    public  $submitbutton;  
    public  $subcategories; 
    public  $src_frmID;
    
 
function __construct($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		 $this->setsubcategories($subcategories);
		 $this->setupdateID($updateID);
		  $this->setsrc_frmID($updateID);
	 	
	}
    
 
	function setsrc_frmID($src_frmID) {
		$this->src_frmID = $src_frmID;
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
function check_root($src_frmID, $subcategories,$mode){
/*****************************************************************************/
global $db;
$insertID =$subcategories;
 if($insertID=='none' || $insertID==0)
 return;
 

$catID=$src_frmID;

if($insertID==$catID){
		?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר קטגורייה לעצמה או לבניה!</h2><?php  
	return FALSE;
}
/*****************************************************************************/

		$sql  = "SELECT catName, catID, parentCatID " .
          " FROM categories1 ORDER BY catName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			 
			$parents[$row->catID] = $row->parentCatID;
			$parents_b[$row->catID] = $row->parentCatID;
			$subcats[$row->parentCatID][] = $row->catID;   }

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
	    $sql="UPDATE categories1 set parentCatID=$insertID WHERE catID=$catID "; 	
	     
	     if(!$db->execute($sql))
	    return FALSE; 
	
 	
	  return true;
}            
	
 	
 	
 
/*******************************************************************************/	
	 
/*****************************************************************************/
	function change_link($mode=''){	
 
	
	$src_frmID=$this->src_frmID;
	$submitbutton=$this->submitbutton; 
	$submitbutton_cancle=$this->submitbutton_cancle; 
	$subcategories=$this->subcategories;
	global $db;
  	
	
	
	
	
  $sql = "SELECT COUNT(*) FROM categories1 WHERE catID='$src_frmID'";
  $n = $db->querySingleItem($sql); 

 
 if($src_frmID && $n==1) {
 
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if( !($this->check_root($src_frmID, $subcategories,$mode)) ){
      $db->execute("ROLLBACK");
    }else{	
      $db->execute("COMMIT");
      echo "<p class='error'>שונה קישור.</p>\n";
    }
    
   }

if($mode=='get_link' && !($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST['form'], 'submitbutton')=='שנה קישור')){
		   	 echo '<fieldset class="my_pageCount" >'; 
		     $this->print_category_entry_form($src_frmID,$mode);
		     echo '</fieldset>';
		      
		   }
  	
  
  }

$this->print_form();   
      
}     
/************************************************************************************/	
	
//==================================================================================== 
function link_div(){
echo '<div>';		
echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
		echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
		$url="../admin/forum_demo12_2.php";
	        $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";
	        
	        
	  echo "<td><p><b> ",build_href2("../admin/categories1.php", "","", "עריכת פורומים","class=my_decLink_root title='עריכת פורומים'") . " </b></p></td>\n";      
	        
       echo "<td><p><b> ",build_href2("../admin/forum_tree.php", "","", "עץ סוגי הפורומים","class=my_decLink_root title='עץ סוגי הפורומים'") . " </b></p></td></tr></table>\n";
  ?>
<table style="width:50%;">
 <tr>
 <td >     
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
//===================================================================================	
	
	
	function update() {
		
		$sql = "UPDATE categories1 SET
				catName='".$this->getName() . "'
				,ParentCatID='".$this->getParent()."'
				WHERE catID = ". $this->getId();
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
              $sql = "SELECT COUNT(*) FROM categories1 WHERE catID=$deleteID";
            if($db->querySingleItem($sql)==1) {
              $db->execute("START TRANSACTION");
              $query = "set foreign_key_checks=0";
              $db->execute($query);
            if($this->delete_category($deleteID)==-1){
              $db->execute("ROLLBACK");
              $db->execute("set foreign_key_checks=1");
            }else{
              $db->execute("COMMIT");
              $db->execute("set foreign_key_checks=1");
              echo "<p class='error'>קטגוריה  נימחקה.</p>\n";
            }
      }    
 	
    }
/***************************************************************************************************/     
    
// delete a category
// return  1, if category and its subcategories could be deleted
// returns 0, if the category could not be deleted
// return -1 if an error happens
   
 function delete_category($catID) {
  // find subcategories to catID and delete them
  // by calling delete_category recursively
  global $db;
  $sql = "SELECT catID FROM categories1 " .
         "WHERE parentCatID='$catID'";
  if($rows = $db->queryObjectArray($sql)) {
    $deletedRows = 0;
    foreach($rows as $row) {
      $result =$this->delete_category($row->catID);
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

  // delete catID
  // don't delete catIDs<=11
  if($catID==11) {
    echo "<br /><h2 class='error'>אי אפשר למחוק קטגןריית אב.</h2>\n";
    return -1;
  }
/*******************************************************************/    		
	$sql = "SELECT c.catID as cat_forumID,c.catName,f.forum_decID,f.forum_decName  FROM categories1 c  
			INNER JOIN rel_cat_forum r ON 	c.catID = r.catID		
			INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.catID=$catID";
		 
		 
		 
		  
		 
		 if($rows2 = $db->queryObjectArray($sql)) {
  	  
  	
  	 $catName =$rows2[0]->catName;
  	 $n=count($rows2);	
  	 
    printf("<h2><br /><b style='color:green;'>  סוגי פורומים %s עדיין קיימים ב- %d החלטות. " .
           "אי אפשר למחוק.</b></h2>\n", $catName, $n);
    
    
    

  	echo "<ol>";
 		
				
  	foreach ($rows2 as $row){
  		 if($row->forum_decName != NULL){
  		$url="../admin/find3.php?cat_forumID=$row->cat_forumID";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		 
				 printf("<li><h2  class='error'> %s (%s, %s, %s, %s, %s )</h2> </li>\n",
		            
							htmlspecial_utf8($row->forum_decName),
							build_href2("dynamic_10.php","mode=insert","&insertID=$row->forum_decID", "הוסף"),
							build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$row->forum_decID", "מחק","OnClick='return verify();'class=href_modal1"),
							build_href2("dynamic_10.php" ,"mode=update","&updateID=$row->forum_decID", "עדכן"),
						    build_href2("dynamic_10.php" ,"mode=read_data","&editID=$row->forum_decID", "עידכון מורחב"),
						    build_href5("", "", "הראה נתונים",$str)); 
						
							
  	        	 }
  			}
   echo "</ol>"; 
		    
   
    return -1;
  }
 	
/**********************************************************************/  
  

  // delete category
  $sql = "DELETE FROM categories1 WHERE catID='$catID' LIMIT 1";
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
  	
  $sql = "SELECT COUNT(*) FROM categories1 WHERE catID='$insertID'";
  $n = $db->querySingleItem($sql); 

// if url had valid insertID, show this category and
// an input form for new subcategories
if($insertID && $n==1) {
	$this->link_div();
//  echo "<h1>הוסף קטגוריה חדשה</h1>\n";

  // if there is form data to process, insert new
  // subcategories into database
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->insert_new_categories($insertID, $subcategories))
      $db->execute("COMMIT");
    else
      $db->execute("ROLLBACK"); }

  if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST['form'], 'submitbutton')=='הוסף')){  
 echo '<fieldset class="my_pageCount" >'; 	
  $this->print_category_entry_form($insertID);
 echo '</fieldset>'; 
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
       echo "<h2 class='error'>קטגוריה נוספה.</h2>\n";
    else
      echo "<h2 class='error'>$count קטגוריות חדשות נוספו.</h2>\n";
  return TRUE;
}

/*******************************************************************************************************/
function insert_new_category($insertID, $newcatName,$mode='') {
/*******************************************************************************************************/	
  global $db;
  // test if newcatName is empty
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM categories1 " .
         "WHERE parentCatID=$insertID " .
         "  AND catName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	//echo " כבר קיימת קטגוריה בשם הזה";
  	show_error_msg(" כבר קיימת קטגוריה בשם הזה");
    return 0; 
  }
////////////////////////////////////////////////////////////////////////////////////

if(!($mode=='update')){
  
 $sql = "INSERT INTO categories1 (catName, parentCatID) " .
         "VALUES ($newcatName, $insertID)";
}else{
	$sql = "update  categories1 set catName=$newcatName where catID=$insertID " ;
    
}
  if($db->execute($sql))
    return 1;
  else
    return -1;
}  
  
 
 
/***************************************************************************************************/     
function update_category_general(){ 
/*************************************************************************************************/
	$mode='update';	
	$updateID=$this->updateID;
	$submitbutton=$this->submitbutton; 
	$subcategories=$this->subcategories;
	global $db;
  	
  $sql = "SELECT COUNT(*) FROM categories1 WHERE catID='$updateID'";
  $n = $db->querySingleItem($sql); 

 
if($updateID && $n==1) {
	 $this->link_div();	
	
	 
//  echo "<h1>עדכן קטגוריה</h1>\n";

 
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
function update_categories($updateID, $subcategories,$mode='') {
/*************************************************************************************************/	
  global $db;
   $subcatarray = explode(";", $subcategories);
   //$subcat=$subcategories;
  $count = 0;
  foreach($subcatarray as $newcatname) {
    //$result =$this->update_new_category($updateID, trim($newcatname));
    $result =$this->insert_new_category($updateID, trim($newcatname),$mode);
    if($result == -1) {
      echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
      return FALSE; }
    elseif($result)
      $count++;
  }
  if($count)
    if($count==1)
      echo "<h2 class='error'>קטגוריה עודכנה.</h2>\n";
     
  return TRUE;
}
 /*************************************************************************************************/

function update_new_category($updateID, $newcatName) {
  global $db;
  // test if newcatName is empty
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM categories1 " .
         "WHERE catID=$updateID " .
         "  AND catName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo " כבר קיימת קטגוריה בשם הזה";
    return 0; 
  }

  // update category
  $sql = "update  categories1 set catName=$newcatName where catID=$updateID " ;
        // "VALUES ($newcatName, $insertID)";
  if($db->execute($sql))
    return 1;
  else
    return -1;
}
 
 

//===================================================================================   
 function  print_form() {
	global $db;
 
	
//echo "<h1>בחר קטגוריה</h1>\n";
//  echo "<p style='font-weight:bold;color:#3C23AB;'>לחץ להוסיף/למחוק/לעדכן  או לראות פורומים בקטגוריה.</p>\n";

   
  $sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
  if($rows = $db->queryObjectArray($sql) ){
   
  foreach($rows as $row) {
    $subcats[$row->parentCatID][] = $row->catID;
    $catNames[$row->catID] = $row->catName; 
   $parent[$row->catID][] = $row->parentCatID; }
   
  echo '<ul class="paginated" style=left:100px;  >';
  echo'<fieldset   style="margin-left:90px;margin-bottom:50px;background: #94C5EB url(../images/background-grad.png) repeat-x">';
/******************************************************/
  
    ?> 
 <!--     
    <label for="chart"><strong style="font-weight:bold;color:white;">גרף סוגי הפורומים:</strong></label>
     <a href='#' title='גרף סוגי הפורומים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>
  -->                                                      
    <?php

	 	  
  
/***********************************************************/  
  $this->print_categories($subcats[NULL], $subcats, $catNames,$parent);
  
	  echo'</fieldset>';   
	  echo '</ul class="paginated">';
    } 
  
   }
/*******************************************************************************/
 function print_categories($catIDs, $subcats, $catNames,$parent) {

 	global $db; 
 	echo '<ul>';
 foreach($catIDs as $catID) {
 	
 	
 $sql = "SELECT c.catID as cat_forumID,c.catName,f.forum_decID,f.forum_decName  FROM categories1 c  
			LEFT JOIN rel_cat_forum r ON 	c.catID = r.catID		
			LEFT JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.catID=$catID";
		 $rows = $db->queryObjectArray($sql);
  		
 	
 	
  $url="../admin/find3.php?cat_forumID=$catID";
  $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$catID.'" ';	
  	if($catID==11){
     printf("<li id=li$catID style='font-weight:bold;color:white;font-size:20px;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','#F700F5').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$catID).css('color','#9F0038').css('font-size', '18px')\"><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b>%s (%s, %s)</b></li>\n",
            htmlspecial_utf8($catNames[$catID]),
            build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף"),
        build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן"));
	}
/******************************************************************************************************/
				
elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){

	
	if ($rows[0]->forum_decID) {
      printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"),
      build_href5("", "", "הראה נתונים",$str));
	  }else{
	  printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"));
	  	
	}  
      
  	}
/******************************************************************************************************/
  	  	
  	elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  		
  if ($rows[0]->forum_decID) {	
    printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s(%s, %s, %s,%s,%s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"),
      build_href5("", "", "הראה נתונים",$str));
    }else{
      printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s(%s, %s, %s,%s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"));
    	
    	
    }
      
 }
/******************************************************************************************************/
  	  	
  	else{

if ($rows[0]->forum_decID) {	  		
  	  printf("<li id=li$catID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"),
      build_href5("", "", "הראה נתונים",$str));
     }else{
    printf("<li id=li$catID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"));
     }
  }
/******************************************************************************************************/  	
 
    if(array_key_exists($catID, $subcats))
      $this->print_categories($subcats[$catID], $subcats, $catNames,$parent);
  }
   echo "</li></ul>\n";
}
  

/******************************************************************************************************/
   function print_category_entry_form($updateID,$mode='') {
/*****************************************************************************************************/   	
		global $db;
$insertID=$updateID;		
		
    $sql  = "SELECT catName, catID, parentCatID " .
          "FROM categories1 ORDER BY catName";
if($rows = $db->queryObjectArray($sql)){

  // build assoc. arrays for name, parent and subcats
  foreach($rows as $row) {
  $catNames[$row->catID] = $row->catName;
    $parents[$row->catID] = $row->parentCatID;
    $subcats[$row->parentCatID][] = $row->catID;   }
}		

			// build list of all parents for $updateID
			$catID = $updateID;
			while($parents[$catID]!=NULL) {
				  $catID = $parents[$catID];
				  $parentList[] = $catID; }

 
				  
				
////////////////////////////////////////////////////////////////////////////////////////				 
				 
if(isset($parentList)){
for($i=sizeof($parentList)-1; $i>=0; $i--){
		$url="../admin/find3.php?cat_forumID=$parentList[$i]";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$parentList[$i].'" ';
      	$catID=	$parentList[$i];	 
if( $parentList[$i] =='11'){
                printf("<ul><li><b> %s (%s, %s ) <b></li>\n",
	            htmlspecial_utf8($catNames[$parentList[$i]]),
	            build_href2("categories1.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
		        build_href2("categories1.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"));					
}
//----------------------------------------------------------------------------------------------------------
else{
	$sql = "SELECT DISTINCT(c.catID) as cat_forumID,c.catName,f.forum_decID,f.forum_decName  FROM categories1 c  
			INNER JOIN rel_cat_forum r ON 	c.catID = r.catID		
			INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.catID=$catID";
	if($rows = $db->queryObjectArray($sql)){
		        printf("<ul><li><b> %s (%s, %s, %s, %s,%s )</b> </li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("categories1.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("categories1.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("categories1.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"),
				build_href2("categories1.php","mode=change_link","&src_frmID=$parentList[$i]", "שנה קישור","class=href_modal1"),
				build_href5("", "", "הראה נתונים",$str));
	}else{
	   	
	   	        printf("<ul><li><b> %s (%s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("categories1.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("categories1.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("categories1.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"),
				build_href2("categories1.php","mode=change_link","&src_frmID=$parentList[$i]", "שנה קישור","class=href_modal1"));
	   	
	   }			 
				                 
}
//----------------------------------------------------------------------------------------------------------				
}
}	
	 
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	$url="find3.php?cat_forumID=$updateID";
   	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$updateID.'" ';		
	  // display choosen forum  * BOLD *
//----------------------------------------------------------------------------------------------------------
if($insertID=='11'){
   		 	 	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("categories1.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("categories1.php","mode=update","&updateID=$updateID", "עדכן")); 
//----------------------------------------------------------------------------------------------------------				
}else{
	
	    $sql = "SELECT DISTINCT(c.catID) as cat_forumID,c.catName,f.forum_decID,f.forum_decName  FROM categories1 c  
			INNER JOIN rel_cat_forum r ON 	c.catID = r.catID		
			INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
			WHERE  r.catID=$updateID";
	    if($rows = $db->queryObjectArray($sql)){
			 	printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s,%s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("categories1.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("categories1.php" ,"mode=delete","&deleteID=$updateID", "מחק", "OnClick='return verify();'class=href_modal1"),
				build_href2("categories1.php" ,"mode=update","&updateID=$updateID", "עדכן"),
				build_href2("categories1.php","mode=change_link","&src_frmID=$updateID", "שנה קישור","class=href_modal1"),
				build_href5("", "", "הראה נתונים",$str));
	    }else{
	    	
	    	    printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("categories1.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("categories1.php" ,"mode=delete","&deleteID=$updateID", "מחק", "OnClick='return verify();'class=href_modal1"),
				build_href2("categories1.php" ,"mode=update","&updateID=$updateID", "עדכן"),
				build_href2("categories1.php","mode=change_link","&src_frmID=$updateID", "שנה קישור","class=href_modal1"));
	    	
	    }		 
}		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $catID) {
			  $url="find3.php?cat_forumID=$catID";
   	          $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$catID.'" ';
               
   	          $sql = "SELECT DISTINCT(c.catID) as cat_forumID,c.catName,f.forum_decID,f.forum_decName  FROM categories1 c  
						INNER JOIN rel_cat_forum r ON 	c.catID = r.catID		
						INNER JOIN forum_dec f ON 	f.forum_decID = r.forum_decID 
						WHERE  r.catID=$catID";
//----------------------------------------------------------------------------------------------------------
   	          if($rows = $db->queryObjectArray($sql)){   	          
				printf("<li><b> %s (%s, %s, %s, %s,%s)</b> </li>\n",
				htmlspecial_utf8($catNames[$catID]),
				build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף"),
				build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
				build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן"),
				build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"),
			    build_href5("", "", "הראה נתונים",$str));
   	          }else{
   	          	printf("<li><b> %s (%s, %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$catID]),
				build_href2("categories1.php","mode=insert","&insertID=$catID", "הוסף"),
				build_href2("categories1.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
				build_href2("categories1.php" ,"mode=update","&updateID=$catID", "עדכן"),
				build_href2("categories1.php","mode=change_link","&src_frmID=$catID", "שנה קישור","class=href_modal1"));
   	          	
   	          } 			
//----------------------------------------------------------------------------------------------------------			    
		}
		echo "<ul>";
			   
		     $updateID=$catID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-מנהלים.)";
		}
				
		 
 echo "</ul>\n";
 
 	if(isset($parentList))
	echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

/***************************************************************************************/    
/***************************************************************************************/    
if(($mode=='get_link')){ 
 ?>
   <form method="post"  id="my_category"  action="categories1.php?mode=change_link&src_frmID=<?php echo  $insertID; ?> "  >
    <table  class="data_table" id="data_table"><tr><td>
	  
	 
       
<?php
$sql = "SELECT catName,catID,parentCatID FROM categories1 ORDER BY catName";
				$rows = $db->queryObjectArray($sql);
foreach($rows as $row) {
			      $subcats6[$row->parentCatID][] = $row->catID;
			      $catNames6[$row->catID] = $row->catName; }
			  
			      $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			      $rows1 = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			      
			      
		        form_list_b("category_frm" , $rows, array_item($formdata, "category_frm") );
 			    
 ?>
 <input type="submit" name="submitbutton" value="שנה קישור" /><br /> 
    </td></tr></table>
   
   </form>
<?php
 			    
/**********************************************************************************************************************/ 			    
}elseif(!($mode=='update')){
     
 echo '<form method="post" action="categories1.php?mode=insert&insertID=',
    $insertID, '">', "\n",
    "<p>הוסף תת קטגוריה אל ",
    "<b>$catNames[$insertID]</b>. <br />אפשר להוסיף כמה",
    " תת-קטגוריות בפעם אחת. <br />השתמש בנקודה פסיק(;) ",
    "להפריד ביניהם.</p>\n".
    '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" name="submitbutton" value="ok"  /></p>', "\n",
      
    "</form>\n";
 
}else{
   echo '<form method="post" action="categories1.php?mode=update&updateID=',
     $insertID, '">', "\n",
    "<p>עדכן קטגוריה של ",
    "<b>$catNames[$insertID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";
}

    
//$this->print_form();   
   
  
//  echo "<p>חזרה אל ",
//    build_href("categories1.php", "", "רשימת הקטגוריות") . ".\n";
   
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
    
	     change_link_cat($_GET['src_frmID'],$_POST['submitbutton'],$_POST['form']['category_frm']);	
		
		break;
		
	default:
	case "list":
 		
    $c=new category();
    $c->link_div();																																																																																																																																																																																																																																																																																																																																																																																																																																																																																										
    $c->print_form();
} 
 
  function delete_cat($deleteID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID']);
               $c->link_div();	
 	           $c->del_category($deleteID);
 	           $c->print_form();
              
  }     
 
  function insert_cat($insertID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
 	      	   $c->add_cat();
 	      	   
  }

  function update_cat($updateID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
 	      	   $c->update_category_general();
 	      	  // $c->print_form();
  }

  
  function change_link_cat($linkID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['category_frm'],"",$_GET['src_frmID']);
 	            $mode="get_link";
 	             $c->link_div();	
 	      	   $c->change_link("$mode");
      }
  
  
 html_footer();
 
  
 
?>
