<?php
  require_once ("../config/application.php");
 if(!$_REQUEST['mode']=='link')
 html_header(); 
   
//=============================================================================
 class category {
 
 	public  $decid;
	public  $decname;
	public  $parentdecid;
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
		
		$sql = "UPDATE decisions SET
				decName='".$this->getName() . "'
				,ParentDecID='".$this->getParent()."'
				WHERE decID = ". $this->getId();
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
              $sql = "SELECT COUNT(*) FROM decisions WHERE decID=$deleteID";
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
  $sql = "SELECT decID FROM decisions " .
         "WHERE parentDecID='$catID'";
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

  // if category is in use, don't delete it!
  $sql = "SELECT COUNT(*) FROM  decisions WHERE decID='$catID'";
  if($n = $db->querySingleItem($sql)>0) {
    $sql = "SELECT decName FROM decisions WHERE decID='$catID'";
    $catname = $db->querySingleItem($sql);
    printf("<br />החלטות %s קטגוריה בשימוש. " .
           "לא כדאי למחוק.\n", $catname, $n);
    return 0;
  }

  // delete category
  $sql = "DELETE FROM decisions WHERE decID='$catID' LIMIT 1";
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
  	
  $sql = "SELECT COUNT(*) FROM decisions WHERE decID='$insertID'";
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
//  $sql = "SELECT COUNT(*) FROM decisions " .
//         "WHERE parentDecID=$insertID " .
//         "  AND decName=$newcatName";
//  if($db->querySingleItem($sql)>0) {
//  	echo " כבר קיימת החלטה בשם הזה";
//    return 0; 
//  }

  // insert new category
  $sql = "INSERT INTO decisions (decName, parentDecID) " .
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
  	
  $sql = "SELECT COUNT(*) FROM decisions WHERE decID='$updateID'";
  $n = $db->querySingleItem($sql); 

// if url had valid updateID, show this category and
// an input form for new subcategories
if($updateID && $n==1) {
  echo "<h2>עדכן קטגוריה</h2>\n";

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
//  $sql = "SELECT COUNT(*) FROM categories " .
//         "WHERE catID=$updateID " .
//         "  AND catName=$newcatName";
//  if($db->querySingleItem($sql)>0) {
//  	echo " כבר קיימת קטגוריה בשם הזה";
//    return 0; 
//  }

  // update category
  $sql = "update  decisions set decName=$newcatName where decID=$updateID " ;
        // "VALUES ($newcatName, $insertID)";
  if($db->execute($sql))
    return 1;
  else
    return -1;
}
 
 

//===================================================================================   

//if(!insertID&&!deleteID)
// otherwise show hierarchical list of all categories
 function  print_form() {
	global $db;
  echo "<h2>בחר קטגוריה</h2>\n";
  echo "<p>לחץ להוסיף/למחוק/לעדכן  או לראות החלטות בקטגוריה.</p>\n";

  // query for all categories
  $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName";
 if($rows = $db->queryObjectArray($sql)){
  // build two arrays:
  //   subcats[catID] contains an array with all sub-catIDs
  //   catNames[catID] contains the catName for catID
  foreach($rows as $row) {
    $subcats[$row->parentDecID][] = $row->decID;
    $catNames[$row->decID] = $row->decName; }
  // build hierarchical list
  $this->print_categories($subcats[NULL], $subcats, $catNames);

  // link to input and search forms
  printf("<p><br />%s<br />%s</p>\n",
    build_href("../admin/dynamic_5.php", "", "הוסף החלטה חדשה"),
    build_href("../admin/find3.php", "", "חפש החלטות"));
   }
 }
 

/*******************************************************************************/
 // searches for $rows[n]->parentCatID=$parentCatID
// and prints $rows[n]->catName; then calls itself
// recursively
 
 function print_categories($catIDs, $subcats, $catNames) {
  echo "<ul>";
  foreach($catIDs as $catID) {
  	if($catID==11){
  		printf("<li><b>%s (%s, %s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href1("../admin/dynamic_5.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href1("dec_edit.php" ,"mode=update","&updateID=$catID", "עדכן"));
    }else{
    printf("<li><b>%s (%s, %s, %s, %s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href1("../admin/dynamic_5.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href1("../admin/dynamic_5.php" ,"mode=delete","&deleteID=$catID", "מחק"),
       build_href1("dec_edit.php" ,"mode=update","&updateID=$catID", "עדכן"),
      build_href("../admin/find3.php", "decID=$catID", "הראה נתונים"));
  	}
    if(array_key_exists($catID, $subcats))
      $this->print_categories($subcats[$catID], $subcats, $catNames);
  }
  echo "</ul>\n";
}


/**************************************************************************/
// show current category, all higher level categories,
// all subcategories (one level only) and a form
// to enter new subcategories
function print_category_entry_form($insertID) {
  global $db;

  // query for all categories
  $sql  = "SELECT decName, decID, parentDecID " .
          "FROM decisions ORDER BY decName";
  $rows = $db->queryObjectArray($sql);

  // build assoc. arrays for name, parent and subcats
  foreach($rows as $row) {
   $catNames[$row->decID] = $row->decName;
    $parents[$row->decID] = $row->parentDecID;
    $subcats[$row->parentDecID][] = $row->decID;   }

  // build list of all parents for $insertID
  $catID = $insertID;
  while($parents[$catID]!=NULL) {
    $catID = $parents[$catID];
    $parentList[] = $catID;   }

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
    foreach($subcats[$insertID] as $catID)
      printf("<li>%s (%s)</li>\n",
        htmlspecial_utf8($catNames[$catID]),
         build_href1("dec_edit.php","mode=delete",
          "&deleteID=$catID", "מחק"));
  else
    echo "(עדיין אין תת-קטגוריות.)";
  echo "</ul>\n";

  // close hierarchical category list
  if(isset($parentList))
    echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

  echo '<form method="post" action="dec_edit.php?mode=insert&insertID=',
    $insertID, '">', "\n",
    "<p>הוסף תת קטגוריה אל ",
    "<b>$catNames[$insertID]</b>. <br />אפשר להוסיף כמה",
    " תת-קטגוריות בפעם אחת. <br />השתמש בנקודה פסיק(;) ",
    "להפריד ביניהם.</p>\n".
    '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" name="submitbutton" value="ok"  /></p>', "\n",
      
    "</form>\n";
     
     $this->print_form();
   
  echo "<p>חזרה אל ",
    build_href("dec_edit.php", "", "רשימת ההחלטות") . ".\n";
   
   }
   
/******************************************************************************************************/
      
 function print_category_entry_form1($updateID) {
  global $db;

  // query for all categories
  $sql  = "SELECT decName, decID, parentDecID " .
          "FROM decisions ORDER BY decName";
  $rows = $db->queryObjectArray($sql);

  // build assoc. arrays for name, parent and subcats
  foreach($rows as $row) {
   $catNames[$row->decID] = $row->decName;
    $parents[$row->decID] = $row->parentDecID;
    $subcats[$row->parentDecID][] = $row->decID;   }

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
         build_href1("dec_edit.php","mode=delete",
          "&deleteID=$catID", "מחק"));
  else
    echo "(עדיין אין תת-קטגוריות.)";
  echo "</ul>\n";

  // close hierarchical category list
  if(isset($parentList))
    echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

  echo '<form method="post" action="dec_edit.php?mode=update&updateID=',
    $updateID, '">', "\n",
    "<p>עדכן תת קטגוריה של ",
    "<b>$catNames[$updateID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";
    build_href1("dec_edit.php","mode=update","&updateID=$updateID", "עדכן");

  // link back to categories
  echo "<p>חזרה אל ",
    build_href("dec_edit.php", "", "רשימת ההחלטות") . ".\n";
   }
   
/*****************************************************************************************************/  
 }	
  
 	
/******************************************************************************************/ 
 
 
  
  
       
 
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

 if(!$_REQUEST['mode']=='link')
 html_footer(); 
 
?>
