<?php
 require_once ("../config/application.php");
 

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
    public  $src_fileID;
    
 
function __construct($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		 $this->setsubcategories($subcategories);
		 $this->setupdateID($updateID);
	 	 $this->set_fileID($updateID);
	}
    
 
  function set_fileID($src_fileID) {
		$this->src_fileID = $src_fileID;
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
	 
	
//==================================================================================== 
/************************************************************************************/	
function check_root($src_decID, $subcategories,$mode){
/*****************************************************************************/
global $db;
$insertID =$subcategories;
 if($insertID=='none' || $insertID==0)
 return;
 

$catID=$src_decID;

if($insertID==$catID){
		?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר קטגורייה לעצמה או לבניה!</h2><?php  
	return FALSE;
}
/*****************************************************************************/

		$sql  = "SELECT catName, catID, parentCatID " .
          " FROM categories_subject ORDER BY catName";
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
	    $sql="UPDATE categories_subject set parentCatID=$insertID WHERE catID=$catID "; 	
	     
	     if(!$db->execute($sql))
	    return FALSE; 
	
 	
	  return true;
}            
	
 	
 	
 
/*******************************************************************************/	
	 
/*****************************************************************************/
	function change_link($mode=''){	
 
	
	$src_fileID=$this->src_fileID;
	$submitbutton=$this->submitbutton; 
	$submitbutton_cancle=$this->submitbutton_cancle; 
	$subcategories=$this->subcategories;
	global $db;
  	
	
	
	
	
  $sql = "SELECT COUNT(*) FROM categories_subject WHERE catID='$src_fileID'";
  $n = $db->querySingleItem($sql); 

 
 if($src_fileID && $n==1) {
 
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if ( !($this->check_root($src_fileID, $subcategories,$mode)) ){
       $db->execute("ROLLBACK");
    }else{	
      $db->execute("COMMIT");
      echo "<p class='error'>שונה קישור.</p>\n";
    }
    
      
   }

   
   
   
   
if($mode=='get_link' && !($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST, 'submitbutton')=='שנה קישור')){
		   	 echo '<fieldset class="my_pageCount" >'; 
		     $this->print_category_entry_form($src_fileID,$mode);
		     echo '</fieldset>';
		      
		   }
  	
  
  }

$this->print_form();   
      
}     
/************************************************************************************/	
	
//==================================================================================== 
function link_div(){
	
echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
		echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
		$url="../admin/forum_demo12_2.php";
	        $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";
	        
	        
	  echo "<td><p><b> ",build_href2("edit_category.php", "","", "עריכת קבצים","class=my_decLink_root title='עריכת קבצים'") . " </b></p></td>\n";      
	        
       echo "<td><p><b> ",build_href2("../admin/subject_tree.php", "","", "עץ הנושאים","class=my_decLink_root title='עץ הנושאים'") . " </b></p></td></tr></table>\n";
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
		
		$sql = "UPDATE categories_subject  SET
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
               $sql = "SELECT COUNT(*) FROM categories_subject WHERE catID=$deleteID";
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
  $sql = "SELECT catID FROM categories_subject " .
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
  if($catID<=11) {
    echo "<br />אי אפשר למחוק קטגןריית אב   .\n";
    return 0;
  }

 

  // delete category
  $sql = "DELETE FROM categories_subject WHERE catID='$catID' LIMIT 1";
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
  	
  $sql = "SELECT COUNT(*) FROM categories_subject WHERE catID='$insertID'";
  $n = $db->querySingleItem($sql); 

 
if($insertID && $n==1) {
	$this->link_div();
  
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

/******************************************************************************************************/ 
// insert new subcategories to given category
function insert_new_categories($insertID, $subcategories) {
  global $db;
  $subcatarray = explode(";", $subcategories);
  $count = 0;
  foreach($subcatarray as $newcatname) {
    $result =$this->insert_new_category($insertID, trim($newcatname));
    if($result == -1) {
      echo "<p class='error'>בעייה במערכת כלום לא נשמר.</p>\n";
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
function insert_new_category($insertID, $newcatName) {
  global $db;
  // test if newcatName is empty
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM categories_subject " .
         "WHERE parentCatID=$insertID " .
         "  AND catName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo " כבר קיימת קטגוריה בשם הזה";
    return 0; 
  }

  // insert new category
  $sql = "INSERT INTO categories_subject (catName, parentCatID) " .
         "VALUES ($newcatName, $insertID)";
  if($db->execute($sql))
    return 1;
  else
    return -1;
}
 

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
  	
  $sql = "SELECT COUNT(*) FROM categories_subject WHERE catID='$updateID'";
  $n = $db->querySingleItem($sql); 

 
if($updateID && $n==1) {
	 $this->link_div();	
 	
 
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
/*************************************************************************************************/


// update new subcategories to given category
function update_categories($updateID, $subcategories) {
  global $db;
   $subcatarray = explode(";", $subcategories);
   //$subcat=$subcategories;
  $count = 0;
  foreach($subcatarray as $newcatname) {
    $result =$this->update_new_category($updateID, trim($newcatname));
    if($result == -1) {
      echo "<p class='error'>בעיית מערכת כלום לא נישמר</p>\n";
      return FALSE; }
    elseif($result)
      $count++;
  }
  if($count)
    if($count==1)
     echo "<p class='error'>קטגוריה עודכנה.</p>\n";
     
  return TRUE;
}
//===================================================================================
function update_new_category($updateID, $newcatName) {
  global $db;
   
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  
  $sql = "SELECT COUNT(*) FROM categories_subject " .
         "WHERE catID=$updateID " .
         "  AND catName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo " כבר קיימת קטגוריה בשם הזה";
    return 0; 
  }

  
  $sql = "update  categories_subject set catName=$newcatName where catID=$updateID " ;
         
  if($db->execute($sql))
    return 1;
  else
    return -1;
}
 
 



//function print_category_entry_form($insertID) {
//  global $db;
//
//   
//  $sql  = "SELECT catName, catID, parentCatID " .
//          "FROM categories_subject ORDER BY catName";
//  $rows = $db->queryObjectArray($sql);
//
//  
//  foreach($rows as $row) {
//   $catNames[$row->catID] = $row->catName;
//    $parents[$row->catID] = $row->parentCatID;
//    $subcats[$row->parentCatID][] = $row->catID;   }
//
//   
//  $catID = $insertID;
//  while($parents[$catID]!=NULL) {
//    $catID = $parents[$catID];
//    $parentList[] = $catID;   }
//
//  // display all parent categories (root category first)
//  if(isset($parentList))
//    for($i=sizeof($parentList)-1; $i>=0; $i--)
//      printf("<ul><li>%s</li>\n", htmlspecial_utf8($catNames[$parentList[$i]]));
//
//  // display choosen category bold
//  printf("<ul><li><b>%s</b></li>\n", htmlspecial_utf8($catNames[$insertID]));
//
//  // display existing subcategories (only one level) for choosen category
//  // with delete link; we still use the results of the last SELECT query
//  echo "<ul>";
//  $subcat=0;
//  if(array_key_exists($insertID, $subcats))
//    foreach($subcats[$insertID] as $catID)
//      printf("<li>%s (%s)</li>\n",
//        htmlspecial_utf8($catNames[$catID]),
//         build_href1("edit_category.php","mode=delete",
//          "&deleteID=$catID", "מחק"));
////         build_href1("edit_category.php","mode=delete",
////          "insertID=$insertID&deleteID=$catID", "מחק"));
//  else
//    echo "(עדיין אין תת-קטגוריות.)";
//  echo "</ul>\n";
//
//  // close hierarchical category list
//  if(isset($parentList))
//    echo str_repeat("</ul>", sizeof($parentList)+1), "\n";
//
//  echo '<form method="post" action="edit_category.php?mode=insert&insertID=',
//    $insertID, '">', "\n",
//    "<p>הוסף תת קטגוריה אל ",
//    "<b>$catNames[$insertID]</b>. <br />אפשר להוסיף כמה",
//    " תת-קטגוריות בפעם אחת. <br />השתמש בנקודה פסיק(;) ",
//    "להפריד ביניהם.</p>\n".
//    '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
//    '<input type="submit" name="submitbutton" value="ok"  /></p>', "\n",
//      
//    "</form>\n";
//     
//     $this->print_form();
//   
//    //build_href1("edit_category.php","mode=insert","&insertID=$insertID", "insert");
//    // build_href("edit_category.php","&insertID=$insertID", "insert");
//  // link back to categories
//  echo "<p>חזרה אל ",
//    build_href("edit_category.php", "", "רשימת הקטגוריות") . ".\n";
//   
//   }
   
/******************************************************************************************************/
      
 function print_category_entry_form1($updateID) {
  global $db;

  // query for all categories
  $sql  = "SELECT catName, catID, parentCatID " .
          "FROM categories_subject ORDER BY catName";
  $rows = $db->queryObjectArray($sql);

  // build assoc. arrays for name, parent and subcats
  foreach($rows as $row) {
   $catNames[$row->catID] = $row->catName;
    $parents[$row->catID] = $row->parentCatID;
    $subcats[$row->parentCatID][] = $row->catID;   }

  // build list of all parents for $updateID
  $catID = $updateID;
  while($parents[$catID]!=NULL) {
    $catID = $parents[$catID];
    $parentList[] = $catID;   }

  // display all parent categories (root category first)
  if(isset($parentList))
    for($i=sizeof($parentList)-1; $i>=0; $i--)
      printf("<ul><li>%s</li>\n", htmlspecial_utf8($catNames[$parentList[$i]]));

  // display choosen category bold
  printf("<ul><li><b>%s</b></li>\n", htmlspecial_utf8($catNames[$updateID]));

  // display existing subcategories (only one level) for choosen category
  // with delete link; we still use the results of the last SELECT query
  echo "<ul>";
  $subcat=0;
  if(array_key_exists($updateID, $subcats))
    foreach($subcats[$updateID] as $catID)
      printf("<li>%s (%s)</li>\n",
        htmlspecial_utf8($catNames[$catID]),
         build_href1("edit_category.php","mode=delete",
          "&deleteID=$catID", "מחק"));
//         build_href1("edit_category.php","mode=delete",
//          "insertID=$insertID&deleteID=$catID", "מחק"));
  else
    echo "(עדיין אין תת-קטגוריות.)";
  echo "</ul>\n";

  // close hierarchical category list
  if(isset($parentList))
    echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

  echo '<form method="post" action="edit_category.php?mode=update&updateID=',
    $updateID, '">', "\n",
    "<p>עדכן תת קטגוריה של ",
    "<b>$catNames[$updateID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";
    build_href1("edit_category.php","mode=update","&updateID=$updateID", "עדכן");

  // link back to categories
  echo "<p>חזרה אל ",
    build_href("edit_category.php", "", "רשימת הקטגוריות") . ".\n";
   }

   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
 

   

//===================================================================================   
 
// function  print_form() {
//	global $db;
//   
//echo'<fieldset  style="background: #94C5EB url(../images/background-grad.png) repeat-x;margin-left:60px;">'; 
//echo "<p style='font-weight:bold;color:#3C23AB;'>לחץ להוסיף/למחוק/לעדכן או לראות נתונים על קטגוריות.</p>\n";
//
// 
//  $sql = "SELECT catName, catID, parentCatID FROM categories_subject ORDER BY catName";
//  $rows = $db->queryObjectArray($sql);
//  
//  foreach($rows as $row) {
//    $subcats[$row->parentCatID][] = $row->catID;
//    $catNames[$row->catID] = $row->catName;
//    $parent[$row->catID][] = $row->parentCatID; }
//  
//   echo '<ul class="paginated" style=left:100px;  >'; 
//  $this->print_categories($subcats[NULL], $subcats, $catNames,$parent);
//    echo '</ul class="paginated">';
//    echo '<BR><BR>'; 
//   
//   
//    echo'</fieldset>';  
//   }
   
//  function print_categories($catIDs, $subcats, $catNames) {
//  echo "<ul>";
//  foreach($catIDs as $catID) {   
//  	if($catID==11){
//  		$url="../admin/find3.php?managerID=$catID";
//  		$str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
//  		$str2='class=href_modal1';	
//  		   printf("<li id=li$catID style='font-weight:bold;color:#9F0038;font-size:20px;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','#F700F5').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','#9F0038').css('font-size', '20px')\"><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b>%s (%s, %s)</b></li>\n",
//            htmlspecial_utf8($catNames[$catID]),
//            build_href2("edit_category.php","mode=insert","&insertID=$$catID", "הוסף"),
//	        build_href2("edit_category.php" ,"mode=update","&updateID=$$catID", "עדכן"));
//			}else{
//$str2='class=href_modal1';				
// printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID)
// .css('color','brown')
// .css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID)
// .css('color','black').css('font-size', '15px')\">
// <b>%s (%s, %s, %s )</b>\n",htmlspecial_utf8($catNames[$catID]),				
// 
//      build_href2("edit_category.php","mode=insert","&insertID=$catID", "הוסף"),
//      build_href2("edit_category.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'$str2"),
//       build_href2("edit_category.php" ,"mode=update","&updateID=$catID", "עדכן"));
//     
//	}
//    if(array_key_exists($catID, $subcats))
//      $this->print_categories($subcats[$catID], $subcats, $catNames);
//  }
//  echo "</ul>\n";
//}  
/**********************************************************************************************/  
   
   //===================================================================================   
 
 function  print_form() {
	global $db;
 
  $sql = "SELECT catName, catID, parentCatID FROM categories_subject ORDER BY catName";
  $rows = $db->queryObjectArray($sql);
   
  foreach($rows as $row) {
    $subcats[$row->parentCatID][] = $row->catID;
    $catNames[$row->catID] = $row->catName; 
   $parent[$row->catID][] = $row->parentCatID; }

   

  echo '<ul class="paginated" style=left:100px;  >';
  echo'<fieldset   style="margin-left:80px;margin-bottom:50px;background: #94C5EB url(../images/background-grad.png) repeat-x">';   
  $this->print_categories($subcats[NULL], $subcats, $catNames,$parent);
   echo'</fieldset>';
  echo '</ul class="paginated">';
    echo '<BR><BR>';
   

     
   }
   
   
   
   
   
   
 
/**************************************************************************************/ 
 function print_categories($catIDs, $subcats, $catNames,$parent) {
 global $db;	
  echo '<ul>';
 foreach($catIDs as $catID) {
  $url="../admin/find3.php?catID=$catID";
  $str='onclick=\'openmypage3("'.$url.'"); return false;\' id="'.$catID.'"  class=href_modal1 ';	
  
   
/**************************************************************************************/  
  	if($catID==11){
    printf("<li id=li$catID style='font-weight:bold;color:#9F0038;font-size:20px;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','#F700F5').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','#9F0038').css('font-size', '20px')\"><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b>%s (%s, %s)</b></li>\n",
            htmlspecial_utf8($catNames[$catID]),
            build_href2("edit_category.php","mode=insert","&insertID=$catID", "הוסף"),
        build_href2("edit_category.php" ,"mode=update","&updateID=$catID", "עדכן"));
	}
/**************************************************************************************/			
	elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){	 
 
		 printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("edit_category.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("edit_category.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("edit_category.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("edit_category.php","mode=change_link","&src_fileID=$catID", "שנה קישור","class=href_modal1"));
		
		
	}
	
	
    
/**************************************************************************************/      
  	elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  
	printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s( %s, %s,%s,%s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("edit_category.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("edit_category.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("edit_category.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("edit_category.php","mode=change_link","&src_fileID=$catID", "שנה קישור","class=href_modal1"));
		
	 
      
}      
/**************************************************************************************/      
  	 else{ 
  	 	
  	
	  printf("<li id=li$catID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("edit_category.php","mode=insert","&insertID=$catID", "הוסף","class=href_modal1"),
      build_href2("edit_category.php" ,"mode=delete","&deleteID=$catID", "מחק","OnClick='return verify();' class='href_modal1'"),
      build_href2("edit_category.php" ,"mode=update","&updateID=$catID", "עדכן","class=href_modal1"),
      build_href2("edit_category.php","mode=change_link","&src_fileID=$catID", "שנה קישור","class=href_modal1"));
		
		
	 
  	}
/**************************************************************************************/  	
    if(array_key_exists($catID, $subcats))
      $this->print_categories($subcats[$catID], $subcats, $catNames,$parent);
  }
   echo "</li></ul>\n";
}
/********************************************************************************************************/

/******************************************************************************************************/

   function print_category_entry_form($updateID,$mode='') {
		global $db;
$insertID=$updateID;		
		
    $sql  = "SELECT catName, catID, parentCatID " .
          "FROM categories_subject ORDER BY catName";
if(   $rows = $db->queryObjectArray($sql)){

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
		$url="../admin/find3.php?catID=$parentList[$i]";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		 
	  if( $parentList[$i] =='11'){
                printf("<ul><li><b> %s (%s, %s ) </b></li>\n",
	            htmlspecial_utf8($catNames[$parentList[$i]]),
	            build_href2("edit_category.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
		        build_href2("edit_category.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"));					
		}else{
				
		        printf("<ul><li><b> %s (%s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("edit_category.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("edit_category.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();'class=href_modal1"),
				build_href2("edit_category.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן"),
				build_href5("", "", "הראה נתונים",$str)); 
				                 
				}
				
			}
	  }	
	 
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	$url="find3.php?catID=$updateID";
   	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
	  // display choosen forum  * BOLD *
   		 	 if($insertID=='11'){
   		 	 	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("edit_category.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("edit_category.php","mode=update","&updateID=$updateID", "עדכן")); 
				
   		 	 }else{
			 	printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("edit_category.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("edit_category.php" ,"mode=delete","&deleteID=$updateID", "מחק", "OnClick='return verify();'class=href_modal1"),
				build_href2("edit_category.php" ,"mode=update","&updateID=$updateID", "עדכן"),
				build_href5("", "", "הראה נתונים",$str)); 
   		 	 }		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $catID) {
			  $url="find3.php?catID=$catID";
   	          $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal2 ';		
				printf("<li><b> %s (%s, %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$catID]),
				build_href2("edit_category.php","mode=insert","&insertID=$catID", "הוסף"),
				build_href2("edit_category.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
				build_href2("edit_category.php" ,"mode=update","&updateID=$catID", "עדכן"),
			 
				//build_href2("find3.php" ,"mode=search_dec","&managerID=$catID", "צפה בנתונים"));
				 build_href5("", "", "הראה נתונים",$str)); 			
		}
		echo "<ul>";
			   
		     $updateID=$catID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-נושאים.)";
		}
				
		 
 echo "</ul>\n";
 
 	if(isset($parentList))
	echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

/***************************************************************************************/    
if(($mode=='get_link')){ 
 ?>
   <form method="post"  id="my_category"  action="edit_category.php?mode=change_link&src_fileID=<?php echo  $insertID; ?> "  >
    <table  class="data_table" id="data_table"><tr><td>
	  
	 
       
<?php
$sql = "SELECT catName,catID,parentCatID FROM categories_subject ORDER BY catName";
				$rows = $db->queryObjectArray($sql);
foreach($rows as $row) {
			      $subcats6[$row->parentCatID][] = $row->catID;
			      $catNames6[$row->catID] = $row->catName; }
			  
			      $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			      $rows1 = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			      
			      
		        form_list_b("category" , $rows, array_item($formdata, "category") );
 			    
 ?>
 <input type="submit" name="submitbutton" value="שנה קישור" /><br /> 
    </td></tr></table>
   
   </form>
<?php
 			    
/**********************************************************************************************************************/ 			    
}elseif(!($mode=='update')){
     
echo '<form method="post" action="edit_category.php?mode=insert&insertID=',$insertID, '">', "\n",
    "<p>הוסף תת קטגוריה אל ",
    "<b>$catNames[$insertID]</b>. <br />אפשר להוסיף כמה",
    " תת-קטגוריות בפעם אחת. <br />השתמש בנקודה פסיק(;) ",
    "להפריד ביניהם.</p>\n".
    '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" name="submitbutton" value="ok"  /></p>', "\n",
      
    "</form>\n"; 
 
}else{
   echo '<form method="post" action="edit_category.php?mode=update&updateID=',
     $insertID, '">', "\n",
    "<p>עדכן קטגוריה של ",
    "<b>$catNames[$insertID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";
    }
   
 }
   

 
 
 
 
 
 
 
/*****************************************************************************************************/  
 }//end class	 	
/******************************************************************************************/ 
 
 html_header();
?>
<script type="text/javascript" src="ajax.lang.php"></script> 
<script type="text/javascript">

turn_red_error();
</script> 
<?php     
 
switch ($_REQUEST['mode']) {
	 
	 
	case "update":
    
	     update_cat($_GET['updateID']);	

		
		break;
		
  										
    case "delete":
               delete_cat($_GET['deleteID']);
		     
         
       
			
		       
 		break;
	  	
					
		 case "insert":
                       
                insert_cat($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
               
	  	break;
	  	
	  	 case "change_link":
    
	     change_link_cat($_GET['src_fileID'],$_POST['submitbutton'],$_POST['form']['category']);	
		
		break;
		
	default:
	case "list":
 		
    $c=new category();
    $c->print_form();
} 
 
  function delete_cat($deleteID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID']);
 	           $c->del_category($deleteID);
 	           $c->print_form();
              
  }     
 
  function insert_cat($insertID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
 	      	   $c->add_cat();
 	      	   //$c->print_form();
  }

  function update_cat($updateID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
 	      	   $c->update_category_general();
 	      	  // $c->print_form();
  }

  
  function change_link_cat($linkID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['category'],"",$_GET['src_fileID']);
 	            $mode="get_link";
 	             $c->link_div();	
 	      	   $c->change_link("$mode");
      }
      
      
  
 html_footer();
 
  
 
?>
