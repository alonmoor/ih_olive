<?php
 require_once ("../config/application.php");
 

//=============================================================================
 class category {
 
 	public  $forumid;
	public  $forumname;
	public  $parentcatid;
	public  $insertID ; 
    public  $deleteID ; 
    public  $updateID ; 
    public  $submitbutton;  
    public  $subcategories; 

    
 
function __construct($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		 $this->setsubcategories($subcategories);
		 $this->setupdateID($updateID);
	 	
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
	
	
	
	function update() {
		
		$sql = "UPDATE forum_dec SET
				forum_decName='".$this->getName() . "'
				,ParentForumID='".$this->getParent()."'
				WHERE forum_decID = ". $this->getId();
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
              $sql = "SELECT COUNT(*) FROM forum_dec WHERE forum_decID=$deleteID";
            if($db->querySingleItem($sql)==1) {
              $db->execute("START TRANSACTION");
              $query = "set foreign_key_checks=0";
              $db->execute($query);
            if($this->delete_forum_sub($deleteID)==-1){
              $db->execute("ROLLBACK");
              $db->execute("set foreign_key_checks=1");
            }else{
              $db->execute("COMMIT");
              $db->execute("set foreign_key_checks=1");
            
            }
      }    
 	
    }
/**********************************************************************************/
	// delete a category
	// return  1, if category and its subcategories could be deleted
	// returns 0, if the category could not be deleted
	// return -1 if an error happens

	function delete_forum_sub($forum_decID) {
		// find subcategories to catID and delete them
		// by calling delete_category recursively
		global $db;
		$sql = "SELECT forum_decID FROM forum_dec " .
         "WHERE parentForumID='$forum_decID'";
		if($rows = $db->queryObjectArray($sql)) {
			$deletedRows = 0;
			foreach($rows as $row) {
				$forum_decID_sub= $row->forum_decID ;	
				$sql = "set foreign_key_checks=0";
				if( $db->execute($sql) )  {
                    $sql="select * from rel_forum_dec where forum_decID=$forum_decID_sub"; 
					if($rows1=$db->queryObjectArray($sql)){ 
					$sql = "DELETE FROM rel_forum_dec  WHERE  forum_decID = $forum_decID  LIMIT 1";
					if(!$db->execute($sql)){
						$db->execute("set foreign_key_checks=1");
						//return FALSE;
						echo "not insert to the many to many";
					}else{
						$db->execute("set foreign_key_checks=1");

					}
				  }
				}
/****************************************************************************/
				$sql = "set foreign_key_checks=0";
				if( $db->execute($sql) )  {
                  $forum_decID_sub= $row->forum_decID ;
                    $sql="select * from rel_user_forum where forum_decID=$forum_decID_sub"; 
					if($rows1=$db->queryObjectArray($sql)){ 
					$sql = "DELETE FROM rel_user_forum  WHERE  forum_decID = $forum_decID  LIMIT 1";
					if(!$db->execute($sql)){
						$db->execute("set foreign_key_checks=1");
						//return FALSE;
						echo "not insert to the many to many";
					}else{
						$db->execute("set foreign_key_checks=1");

					}
				  }	
				}
/****************************************************************************/
					
					
					
					
				$result =$this->delete_forum_sub($row->forum_decID);
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
		if($forum_decID<=11) {
			echo "<br />אי אפשר למחוק החלטות אב   .\n";
			return 0;
		}

		// delete category
		$sql = "DELETE FROM forum_dec WHERE forum_decID='$forum_decID' LIMIT 1";
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
  	
  $sql = "SELECT COUNT(*) FROM forum_dec WHERE forum_decID='$insertID'";
  $n = $db->querySingleItem($sql); 

// if url had valid insertID, show this category and
// an input form for new subcategories
if($insertID && $n==1) {
  echo "<h2>הוסף קטגוריה חדשה</h2>\n";

  // if there is form data to process, insert new
  // subcategories into database
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->insert_new_categories($insertID, $subcategories))
      $db->execute("COMMIT");
    else
      $db->execute("ROLLBACK"); }

  $this->print_category_entry_form($insertID);
   
  }

      
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
      echo "<p>קטגוריה חדשה נוספה.</p>\n";
    else
      echo "<p>$count קטגוריות חדשות נוספו.</p>\n";
  return TRUE;
}
/*******************************************************************************************************/
function insert_new_category($insertID, $newcatName) {
  global $db;
  // test if newcatName is empty
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM forum_dec " .
         "WHERE parentForumID=$insertID " .
         "  AND forum_decName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo " כבר קיימת קטגוריה בשם הזה";
    return 0; 
  }

  // insert new category
  $sql = "INSERT INTO forum_dec(forum_decName, parentForumID) " .
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
	$updateID=$this->updateID;
	$submitbutton=$this->submitbutton; 
	$subcategories=$this->subcategories;
	global $db;
  	
  $sql = "SELECT COUNT(*) FROM forum_dec WHERE forum_decID='$updateID'";
  $n = $db->querySingleItem($sql); 

// if url had valid updateID, show this category and
// an input form for new subcategories
if($updateID && $n==1) {
  echo "<h1>עדכן קטגוריה</h1>\n";

  // if there is form data to process, update new
  // subcategories into database
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->update_categories($updateID, $subcategories))
      $db->execute("COMMIT");
    else
      $db->execute("ROLLBACK"); }

  $this->print_category_entry_form1($updateID);
   
  }

      
}     
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
      echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
      return FALSE; }
    elseif($result)
      $count++;
  }
  if($count)
    if($count==1)
      echo "<p>קטגוריה עודכנה.</p>\n";
     
  return TRUE;
}
//===================================================================================
function update_new_category($updateID, $newcatName) {
  global $db;
  // test if newcatName is empty
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM forum_dec " .
         "WHERE forum_decID=$updateID " .
         "  AND forum_decName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo " כבר קיימת קטגוריה בשם הזה";
    return 0; 
  }

  // update category
  $sql = "update  forum_dec set forum_decName=$newcatName where forum_decID=$updateID " ;
        // "VALUES ($newcatName, $insertID)";
  if($db->execute($sql))
    return 1;
  else
    return -1;
}
 
 

//===================================================================================   

//********************************************************************************************************
 
 function  print_form($forum_decID="") {
	global $db;
  echo "<h1>בחר פורום</h1>\n";
  echo "<p>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים נוספים בפורום.</p>\n";
  
  $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
  $rows = $db->queryObjectArray($sql);
 $parent=array();
  foreach($rows as $row) {
    $subcats[$row->parentForumID][] = $row->forum_decID;
    $catNames[$row->forum_decID] = $row->forum_decName;
    $parent[$row->forum_decID][] = $row->parentForumID; }

    
    echo '<ul class="paginated">'; 
        $this->print_categories_forum_paging($subcats[NULL], $subcats, $catNames,$parent);
    echo '</ul class="paginated">'; 
   }
 
 

/*******************************************************************************/
/******************************************************************************/
/*******************************************************************************/
  
 function print_categories_forum_paging($catIDs, $subcats, $catNames,$parent) {
  echo '<ul>';
  foreach($catIDs as $catID) {
  	if($catID==11){
  		printf("<li><b>%s (%s, %s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href1("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href1("forum_category.php" ,"mode=update","&updateID=$catID", "עדכן שם"));
     
    }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){	 
    
    printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href1("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href1("forum_category.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href1("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
      
  	}elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  		printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href1("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href1("forum_category.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href1("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
  	}else{ 
  	  printf("<li><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href1("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href1("forum_category.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href1("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
  	}
  	
 
    if(array_key_exists($catID, $subcats))
      $this->print_categories_forum_paging($subcats[$catID], $subcats, $catNames,$parent);
  }
   echo "</li></ul>\n";
}

/**************************************************************************/

/**************************************************************************************************************/
////if(!insertID&&!deleteID)
//// otherwise show hierarchical list of all categories
// function  print_form() {
//	global $db;
//  $this->link();	
//  echo "<h2>בחר פורום</h2>\n";
//  echo "<p>לחץ להוסיף/למחוק/לעדכן  או לראות החלטות בפורום.</p>\n";
//
//  // query for all categories
//  $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
//  $rows = $db->queryObjectArray($sql);
//  // build two arrays:
//  //   subcats[catID] contains an array with all sub-catIDs
//  //   catNames[catID] contains the catName for catID
//  foreach($rows as $row) {
//    $subcats[$row->parentForumID][] = $row->forum_decID;
//    $catNames[$row->forum_decID] = $row->forum_decName; }
//   
//    $this->print_categories($subcats[NULL], $subcats, $catNames);
//
//  // link to input and search forms
//  printf("<p><b><br />%s<br /><br />%s<br /><br />%s<br />%s<b></p>\n",
//    build_href("forum_category.php", "", "רשימת פורומים"),
//    build_href("dynamic_8.php", "", "ערוך/הוסף פורום + משתמשים "),
//    build_href("dynamic_6.php", "", "ערוך/הוסף כמה פורומים"),
//    build_href("find3.php", "", "חפש החלטות"));
//   }
// 
// 

/*******************************************************************************/
 // searches for $rows[n]->parentCatID=$parentCatID
// and prints $rows[n]->catName; then calls itself
// recursively
 
// function print_categories($catIDs, $subcats, $catNames) {
//  echo "<ul>";
//  foreach($catIDs as $forum_decID) {
//  	 if($forum_decID==11){
//  		    printf("<li><b>%s (%s, %s)</b></li>\n",
//            htmlspecial_utf8($catNames[$forum_decID]),
//            build_href2("dynamic_8.php","mode=insert","&insertID=$forum_decID", "הוסף"),
//	        build_href2("forum_category.php" ,"mode=update","&updateID=$forum_decID", "עדכן"));
//			}else{
// 
//      printf("<li><b>%s (%s, %s, %s, %s,%s)</b></li>\n",
//      htmlspecial_utf8($catNames[$forum_decID]),
//      build_href2("dynamic_8.php","mode=insert","&insertID=$forum_decID", "הוסף"),
//      build_href2("forum_category.php" ,"mode=delete","&deleteID=$forum_decID","מחק","OnClick='return verify();'"),
//
//
// 
// 
// 
//       build_href2("forum_category.php" ,"mode=update","&updateID=$forum_decID", "עדכן"),
//       	build_href2("dynamic_8.php","mode=read_data", "&editID=$forum_decID", "עידכון מורחב"),
//      build_href("find3.php", "forum_decID=$forum_decID", "הראה נתונים"));
//	} 
//    if(array_key_exists($forum_decID, $subcats))
//      $this->print_categories($subcats[$forum_decID], $subcats, $catNames);
//  }
//  echo "</ul>\n";
//}

/***************************************************************************/
function build_href3($query,$num ) {
  if($query)
return '<a href=/admin/forum_category.php?mode=delete&deleteID=" .$num ."\"   onclick="return verify();"><b>מחק</b> </a>' ;
 
} 

//"<a href=\"example.5-8.php?qty=1&amp;wineId=" .
//           $row["wine_id"] ."\">Add a bottle to the shopping cart</a>" .  
//           "</td>\n</tr>";  
/**************************************************************************/
// show current category, all higher level categories,
// all subcategories (one level only) and a form
// to enter new subcategories
function print_category_entry_form($insertID) {
  global $db;

  // query for all categories
  $sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          "FROM forum_dec ORDER BY forum_decName";
  $rows = $db->queryObjectArray($sql);

  // build assoc. arrays for name, parent and subcats
  foreach($rows as $row) {
   $catNames[$row->forum_decID] = $row->forum_decName;
    $parents[$row->forum_decID] = $row->parentForumID;
    $subcats[$row->parentForumID][] = $row->forum_decID;   }

  // build list of all parents for $insertID
  $forum_decID = $insertID;
  while($parents[$forum_decID]!=NULL) {
    $forum_decID = $parents[$forum_decID];
    $parentList[] = $forum_decID;   }

  // display all parent categories (root category first)
  if(isset($parentList))
    for($i=sizeof($parentList)-1; $i>=0; $i--)
      printf("<ul><li>%s</li>\n", htmlspecial_utf8($catNames[$parentList[$i]]));

  // display choosen category bold
  printf("<ul><li><b>%s</b></li>\n", htmlspecial_utf8($catNames[$insertID]));

  // display existing subcategories (only one level) for choosen category
  // with delete link; we still use the results of the last SELECT query
  echo "<ul>";
  $subcat=0;
  if(array_key_exists($insertID, $subcats))
    foreach($subcats[$insertID] as $forum_decID)
      printf("<li>%s (%s)</li>\n",
        htmlspecial_utf8($catNames[$forum_decID]),
         build_href2("forum_category.php","mode=delete",
          "&deleteID=$forum_decID", "מחק","OnClick='return verify();'"));
//         build_href2("categories.php","mode=delete",
//          "insertID=$insertID&deleteID=$catID", "מחק"));
  else
    echo "(עדיין אין תת-קטגוריות.)";
  echo "</ul>\n";

  // close hierarchical category list
  if(isset($parentList))
    echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

  echo '<form method="post" action="forum_category.php?mode=insert&insertID=',
    $insertID, '">', "\n",
    "<p>הוסף תת קטגוריה אל ",
    "<b>$catNames[$insertID]</b>. <br />אפשר להוסיף כמה",
    " תת-קטגוריות בפעם אחת. <br />השתמש בנקודה פסיק(;) ",
    "להפריד ביניהם.</p>\n".
    '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" name="submitbutton" value="ok"  /></p>', "\n",
      
    "</form>\n";
     
     $this->print_form();
   
    //build_href2("categories.php","mode=insert","&insertID=$insertID", "insert");
    // build_href("categories.php","&insertID=$insertID", "insert");
  // link back to categories
  echo "<p>חזרה אל ",
    build_href("forum_category.php", "", "רשימת הקטגוריות") . ".\n";
   
   }
   
/******************************************************************************************************/
      
 function print_category_entry_form1($updateID) {
  global $db;

  // query for all categories
  $sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          "FROM forum_dec ORDER BY forum_decName";
  $rows = $db->queryObjectArray($sql);

  // build assoc. arrays for name, parent and subcats
  foreach($rows as $row) {
   $catNames[$row->forum_decID] = $row->forum_decName;
    $parents[$row->forum_decID] = $row->parentForumID;
    $subcats[$row->parentForumID][] = $row->forum_decID;   }

  // build list of all parents for $updateID
  $forum_decID = $updateID;
  while($parents[$forum_decID]!=NULL) {
    $forum_decID = $parents[$forum_decID];
    $parentList[] = $forum_decID;   }

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
    foreach($subcats[$updateID] as $forum_decID)
      printf("<li>%s (%s)</li>\n",
        htmlspecial_utf8($catNames[$forum_decID]),
         build_href2("forum_category.php","mode=delete",
          "&deleteID=$forum_decID", "מחק","OnClick='return verify();'"));
//         build_href2("categories.php","mode=delete",
//          "insertID=$insertID&deleteID=$catID", "מחק"));
  else
    echo "(עדיין אין תת-קטגוריות.)";
  echo "</ul>\n";

  // close hierarchical category list
  if(isset($parentList))
    echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

  echo '<form method="post" action="forum_category.php?mode=update&updateID=',
    $updateID, '">', "\n",
    "<p>עדכן תת קטגוריה של ",
    "<b>$catNames[$updateID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";
    build_href2("forum_category.php","mode=update","&updateID=$updateID", "עדכן");

  // link back to categories
   
		printf("<p><b>%s</b></p>\n",
		build_href("forum_category.php", "", "רשימת פורומים" ));// . ".\n";
   }
 function link(){
  // link to input and search forms
  printf("<p><b><br />%s<br /><br />%s<br /><br />%s<b></p>\n",
    build_href("forum_category.php", "", "רשימת פורומים"),
    build_href("dynamic_8.php", "", "ערוך/הוסף פורום"),
    build_href("find3.php", "", "חפש החלטות"));	
 	
 }  
/*****************************************************************************************************/  
 }	
  
 	
/******************************************************************************************/ 
if(!isAjax())
 html_header();
  ?>
<script type="text/javascript" src="ajax.lang.php"></script> 
<?php  
is_logged();      
 
switch ($_REQUEST['mode']) {
	 
	 
	case "update":
    
	     update_cat($_GET['updateID']);	
//		if( !isset($_POST['submit']) ) {
//			// show edit form.
//			show_edit_form($_GET['id'], $_REQUEST['mode']);
//		   }
//  else     {
//			// do the update....
//			if ( !update_product() ) {
//				echo "dsdsdsdsdsdsdasda fallil fiaf laifal f";	
//			} 
//	   else {
//				show_list();
//			}
//		}
		
		break;
		
  										
    case "delete":
               delete_cat($_GET['deleteID']);
		     
         
       
			
		       
 		break;
	  	
					
		 case "insert":
                       
                insert_cat($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
                //else
                      
               
	  	break;
		
	default:
	case "list":
 		
    $c=new category();
    $c->print_form();
} 
 
  function delete_cat($deleteID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_GET['deleteID']);
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

 html_footer();
 
  
 
?>
