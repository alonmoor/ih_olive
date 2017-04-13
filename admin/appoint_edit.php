<?php
 require_once ("../config/application.php");
 

//=============================================================================
 class category {
 
 	public  $managerid;
	public  $managername;
	public  $parentmanagerid;
	public  $insertID ; 
    public  $deleteID ; 
    public  $updateID ; 
    public  $submitbutton;  
    public  $subcategories; 
    public   $src_mgrID;
    public   $submitbutton_cancle; 
 
function __construct($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="",$src_mgrID="",$submitbutton_cancle="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		 $this->setsubcategories($subcategories);
		 $this->setupdateID($updateID);
		 $this->setsrc_mgrID($src_mgrID);
	 	$this->setsubmitbutton_cancle($submitbutton_cancle);
	}
    
 
 	function setdeleteID($deleteID) {
		$this->deleteID = $deleteID;
	}
	

 function setsrc_mgrID($src_mgrID) {
		$this->src_mgrID = $src_mgrID;
	}	
	
 function setinsertID($insertID) {
		$this->insertID = $insertID;
	}
	
 function setsubmitbutton($submitbutton) {
		$this->submitbutton = $submitbutton;
	}

function setsubmitbutton_cancle($submitbutton_cancle) {
		$this->submitbutton_cancle = $submitbutton_cancle;
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

function link_div(){
echo '<div>';	
echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
		echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
		$url="../admin/forum_demo12_2.php";
	        $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";
	        
	        
	  echo "<td><p><b> ",build_href2("appoint_edit.php", "","", "עריכת ממנים","class=my_decLink_root title='עריכת ממנים'") . " </b></p></td>\n";      
	        
       echo "<td><p><b> ",build_href2("../admin/appoint_tree.php", "","", "עץ ממני הפורומים","class=my_decLink_root title='עץ ממני הפורומים'") . " </b></p></td></tr></table>\n";
       	

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
	
	
	function update() {
		
		$sql = "UPDATE appoint_forum SET
				appointName='".$this->getName() . "'
				,parentAppointID='".$this->getParent()."'
				WHERE appointID = ". $this->getId();
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

 

/*******************************************************************************************************/
function del_category($deleteID){
 	global $db;   
              $sql = "SELECT COUNT(*) FROM appoint_forum WHERE appointID=$deleteID";
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
               echo "<p class='error'>ממנה נימחק.</p>\n";
            
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
  $sql = "SELECT appointID  FROM appoint_forum WHERE parentAppointID='$catID'";
  if($rows = $db->queryObjectArray($sql)) {
    $deletedRows = 0;
    foreach($rows as $row) {
      $result =$this->delete_category($row->appointID);
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
         echo "<br /><h2 class='error'>אי אפשר למחוק החלטות אב   .</h2>\n";
    return -1;
  }

/*******************************************************************/    		
		 $sql = "SELECT f.appointID,f.forum_decName,f.forum_decID,a.appointName FROM forum_dec f
          INNER JOIN appoint_forum a  ON a.appointID=f.appointID 
		   WHERE f.appointID=$catID";
		 if($rows2 = $db->queryObjectArray($sql)) {
  	  
  	
  	  $app_name =$rows2[0]->appointName;
  	 $n=count($rows2);	
  	 
    printf("<p><br /><b style='color:green;'>הממנה %s  ממנה  עדיין בתפקיד ב- %d   פורומים. " .
           "אי אפשר למחוק.</b></p>\n", $app_name, $n);
    
    
    

  	echo "<ol>";
 		
				
  	foreach ($rows2 as $row){
  		$url="../admin/find3.php?forum_decID=$row->appointID";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		 
				 printf("<li><h2 class='error'> %s  (%s, %s, %s, %s, %s )<h2> </li>\n",
		            
							htmlspecial_utf8($row->forum_decName),
							build_href2("dynamic_10.php","mode=insert","&insertID=$row->forum_decID", "הוסף"),
							build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$row->forum_decID", "מחק","OnClick='return verify();'"),
							build_href2("forum_category.php" ,"mode=update","&updateID=$row->forum_decID", "עדכן"),
						    build_href2("dynamic_10.php" ,"mode=read_data","&editID=$row->forum_decID", "עידכון מורחב"),
						    build_href5("", "", "הראה נתונים",$str)); 
						
							
						}
   echo "</ol>"; 
		    
   
    return -1;
  }
 	
/**********************************************************************/    

  // delete category
  $sql = "DELETE FROM appoint_forum WHERE appointID='$catID' LIMIT 1";
  if($db->execute($sql))
    return 1;
  else
    return -1;
     
}
   
/*******************************************************************************************************/
	
	
	
	// test if variable insertID was set to a valid value
function add_cat(){
	$mode='insert';	
	$insertID=$this->insertID;
	$submitbutton=$this->submitbutton; 
	$subcategories=$this->subcategories;
	global $db;
  	
  $sql = "SELECT COUNT(*) FROM appoint_forum WHERE appointID='$insertID'";
  $n = $db->querySingleItem($sql); 

// if url had valid insertID, show this category and
// an input form for new subcategories
if($insertID && $n==1) {
$this->link_div();	
 // echo "<h1>הוסף ממנה חדש</h1>\n";

  // if there is form data to process, insert new
  // subcategories into database
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->insert_new_categories($insertID, $subcategories,$mode))
      $db->execute("COMMIT");
    else
      $db->execute("ROLLBACK"); }

      
if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST['form'], 'submitbutton')=='הוסף')){  
 echo '<fieldset class="my_pageCount" >'; 	      
  $this->print_category_entry_form($insertID,$mode);
echo '</fieldset>';
}  
}
 
 $this->print_form();     
}     
/******************************************************************************************************/ 
// insert new subcategories to given category
function insert_new_categories($insertID, $subcategories,$mode) {
  global $db;
  //$subcatarray = explode(";", $subcategories);
  $count = 0;
  foreach($subcategories as $newcatname) {
    $result =$this->insert_new_category($insertID, trim($newcatname),$mode);
    if($result == -1) {
      echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
      return FALSE; }
    elseif($result)
      $count++;
  }
  if($count)
    if($count==1)
      echo "<p class='error'>ממנה חדש נוסף.</p>\n";
    else
      echo "<p class='error'>$count ממנים חדשים נוספו.</p>\n";
  return TRUE;
}
/*******************************************************************************************************/
function insert_new_category($insertID, $new_Usrapp,$mode='') {
  global $db;
  
 if($mode!='update_root'){  
  $query="select full_name from users where userID=$new_Usrapp";
 if($rows= $db->queryObjectArray($query) ){
 $newcatName=	$rows[0]->full_name;
 $newappName=	$rows[0]->full_name;
 }
}elseif($mode=='update_root'){  
	$newcatName= $new_Usrapp;
	
}   
  // test if newcatName is empty
  if(!$new_Usrapp) return 0;
  
 
$newcatName = $db->sql_string($newcatName); 
 
 
 
  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM appoint_forum " .
         "WHERE parentAppointID=$insertID " .
         "  AND appointName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo "<b class='error' style='color:yellow;' >כבר קיים ממנה בשם הזה</b>";
    return 0; 
  }
  
$query="select appointName from appoint_forum where appointID=$insertID";
 if($rows1= $db->queryObjectArray($query) ){
 	$name=$rows1[0]->appointName;
 	$name = $db->sql_string($name);
 	if($name == $newcatName){
 	show_error_msg("ממנה לא יכול למנות את עצמו");
 	return 0;
 	}
 } 
  
 
  
   // if(!($mode=='update') && !($mode=='update_root') ){
 if(($mode=='insert')){ 
  $sql = "INSERT INTO appoint_forum(appointName, parentAppointID,userID) " .
         "VALUES ($newcatName, $insertID,$new_Usrapp)";
    }elseif($mode=='update'){
	$sql = "update  appoint_forum set appointName=$newcatName,userID=$new_Usrapp where appointID=$insertID " ;
    
    }elseif ($mode=='update_root'){
	
	$sql = "update  appoint_forum set appointName=$newcatName where appointID=$insertID " ;
}
    
    
    
    
    
   if($db->execute($sql))
    return 1;
  else
    return -1;
}

/***************************************************************************************************/ 
 
function update_category_general(){ 
	$mode='update';	
	$updateID=$this->updateID;
	$submitbutton=$this->submitbutton; 
	$subcategories=$this->subcategories;
	 
	global $db;
  	
  $sql = "SELECT COUNT(*) FROM appoint_forum WHERE appointID='$updateID'";
  $n = $db->querySingleItem($sql); 

// if url had valid updateID, show this category and
// an input form for new subcategories
if($updateID && $n==1) {
	$this->link_div();
//  echo "<h1>עדכן ממנה</h1>\n";

  // if there is form data to process, update new
  // subcategories into database
 if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->update_categories($updateID, $subcategories,$mode))
      $db->execute("COMMIT");
    else
      $db->execute("ROLLBACK"); }

  $this->print_category_entry_form($updateID,$mode);
   
  }

      
}     
/*************************************************************************************************/


// update new subcategories to given category
function update_categories($updateID, $subcategories,$mode='') {
  global $db;
  // $subcatarray = explode(";", $subcategories);
   //$subcat=$subcategories;
  $count = 0;
  foreach($subcategories as $newcatname) {
    //$result =$this->update_new_category($updateID, trim($newcatname));
     $result =$this->insert_new_category($updateID, trim($newcatname),$mode);
    if($result == -1) {
       echo "<p class='error'>בעייה במערכת כלום לא נישמר.</p>\n";
      return FALSE; }
    elseif($result)
      $count++;
  }
  if($count)
    if($count==1)
      echo "<p class='error'>עודכנה כותרת ממנים</p>\n"; 
     
  return TRUE;
}
//===================================================================================
function update_new_category($updateID, $newcatName) {
  global $db;
  // test if newcatName is empty
  if(!$newcatName) return 0;
  $newcatName = $db->sql_string($newcatName);

  // test if newcatName already exists
  $sql = "SELECT COUNT(*) FROM appoint_forum " .
         "WHERE appointID=$updateID " .
         "  AND appointName=$newcatName";
  if($db->querySingleItem($sql)>0) {
  	echo "כבר קיים ממנה בשם הזה";
    return 0; 
  }

  // update category
  $sql = "update  appoint_forum set appointName=$newcatName where appointID=$updateID " ;
        // "VALUES ($newcatName, $insertID)";
  if($db->execute($sql))
    return 1;
  else
    return -1;
}
 
 


//////////////////////////////////////////////////////////////////////////////////////// 
function update_category_root_general(){ 
	$mode='update_root';	
	$updateID=$this->updateID;
	$submitbutton=$this->submitbutton; 
	$subcategories=$this->subcategories;
	$subcategories=explode(',', $subcategories);
	global $db;
  	
  $sql = "SELECT COUNT(*) FROM appoint_forum WHERE appointID='$updateID'";
  $n = $db->querySingleItem($sql); 
 
if($updateID && $n==1) {
	$this->link_div();
//  echo "<p>עדכן כותרת ממנים</p>\n";

 
  if($subcategories) {
    $db->execute("START TRANSACTION");
    if($this->update_categories($updateID, $subcategories,$mode)) 
      $db->execute("COMMIT");    
    else
      $db->execute("ROLLBACK"); }
if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST['form'], 'submitbutton')=='OK')){ 
	echo '<fieldset class="my_pageCount" >'; 	
  $this->print_category_entry_form ($updateID,$mode);
  echo '</fieldset>'; 	
   } 
  }

$this->print_form();   
   
  
      
}     
/*****************************************************************************/
	function change_link($mode=''){	
/***********************************************************************/ 
	
	$src_mgrID=$this->src_mgrID;
	$submitbutton=$this->submitbutton; 
	$submitbutton_cancle=$this->submitbutton_cancle; 
	$subcategories=$this->subcategories;
	global $db;
  	
	if($submitbutton_cancle && $src_mgrID){
		$sql  = "SELECT  parentAppointID1 " .
          " FROM appoint_forum WHERE appointID=$src_mgrID";
		if($rows=$db->queryObjectArray($sql)){
		$sql="UPDATE appoint_forum set parentAppointID1=NULL WHERE appointID=$src_mgrID ";
		      if(!$db->execute($sql))
		        return  FALSE;
              else 
               echo "<p class='error'>בוטל קישור שני.</p>\n";  
		        
		  $no_form=true;      
		   

		}
		
		
	}
	
	
	
	
  $sql = "SELECT COUNT(*) FROM appoint_forum WHERE appointID='$src_mgrID'";
  $n = $db->querySingleItem($sql); 

 
 if($src_mgrID && $n==1) {
 $this->link_div();
  
 if($subcategories) {
    $db->execute("START TRANSACTION");
   if (!(array_item($_POST, 'submitbutton')=='בטל קישור שני') ){ 
    if( !($this->check_root($src_mgrID, $subcategories,$mode)) ) {
      $db->execute("ROLLBACK");
    }elseif (!(array_item($_POST, 'submitbutton')=='בטל קישור שני') && !(array_item($_POST, 'submitbutton')=='שנה קישור שני') ){
    	 $db->execute("COMMIT");
         echo "<p class='error'>שונה קישור ריאשון.</p>\n";
    }elseif (array_item($_POST, 'submitbutton')=='שנה קישור שני'){
       $db->execute("COMMIT");	
       echo "<p class='error'>שונה קישור שני.</p>\n"; 
    	
      }	
    }elseif (!(array_item($_POST, 'submitbutton')=='בטל קישור שני') ){
    	
    	echo "<p class='error'>בוטל קישור שני.</p>\n";
    } 
   }
 
   
   
      
  if($mode=='get_link2'  &&  !($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST, 'submitbutton')=='שנה קישור שני') ){
  	echo '<fieldset class="my_pageCount" >'; 	
  	$sql  = "SELECT   parentAppointID1 " .
          " FROM appoint_forum WHERE appointID=$src_mgrID";
  
        if($rows=$db->queryObjectArray($sql)    ) 
        	if($rows[0]->parentAppointID1){
           $no_form=false;
            echo "<h2>קישור ריאשון</h2>\n";
            $mode1="get_link";
        	$this->print_category_entry_form($src_mgrID,"$mode1", $no_form);
        	
        	
        	
       
          $src_mgrID2=$rows[0]->parentAppointID1;
            echo "<h2>קישור שני</h2>\n";
            $no_form=true;
          
        	$this->print_category_entry_form($src_mgrID2, $mode, $no_form,$src_mgrID);
        	} else{
        	 $no_form=true;
        	$this->print_category_entry_form($src_mgrID,$mode, $no_form);
        }          
    echo '</fieldset>';
      
  
/************************************************/   
  } elseif($mode=='get_link' && !($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST['form'], 'submitbutton')=='שנה קישור ריאשון')){
		   	 echo '<fieldset class="my_pageCount" >'; 
		     $this->print_category_entry_form($src_mgrID,$mode);
		     echo '</fieldset>';
		      
  }      
/***********************************************/       
  }

$this->print_form();   
   
  
 
   
  
      
}     
/************************************************************************************/	
function check_root($src_mgrID, $subcategories,$mode){
/*****************************************************************************/
global $db;
$insertID =$subcategories;
 if($insertID=='none' || $insertID==0)
 return;
 
 
$sql="SELECT appointID, parentAppointID  FROM appoint_forum WHERE appointID=$src_mgrID";
if($rows=$db->queryObjectArray($sql)){
if($rows[0]->parentAppointID==$insertID){	
?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר ממנה לאותו אב!</h2><?php  
	return -1;	
  }
} 
/***************************************************************************/
$appointID=$src_mgrID;

if($insertID==$appointID){
		?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר ממנה לעצמו או לבניו!</h2><?php  
	return FALSE;
}
/*****************************************************************************/

		$sql  = "SELECT appointName, appointID, parentAppointID " .
          " FROM appoint_forum ORDER BY appointName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			 
			$parents[$row->appointID] = $row->parentAppointID;
			$parents_b[$row->appointID] = $row->parentAppointID;
			$subcats[$row->parentAppointID][] = $row->appointID;   }

			// build list of all parents for $insertID
			$mgr_ID = $insertID;
			while($parents[$mgr_ID]!=NULL) {
				$mgr_ID = $parents[$mgr_ID];
				$parentList[] = $mgr_ID; 
			}
			
			
            $mgrID = $insertID;
			while($parents_b[$mgrID]!=NULL && $parents_b[$mgrID]!=$appointID) {
				$mgrID = $parents_b[$mgrID];
				$parentList_b[] = $mgrID; 
			}
			
			
		if($subcats[$appointID]){	
			if(   in_array($insertID, $subcats[$appointID]) 
			||    in_array($parents[$insertID],$subcats[$appointID] ) 
			||    in_array($mgrID,$subcats[$appointID] )
			||    $parents[$insertID]== $appointID 
		   
			){
			 
			 ?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר ממנה לעצמו או לבניו!</h2><?php  
			return FALSE;
			}
		}elseif( $insertID==$appointID){
			
			 ?><h2 class='error' style="color:blue;width:30%; ">אי אפשר לקשר ממנה לעצמו או לבניו!</h2><?php  
			return FALSE;
			 
		}	

/*******************************************************************************/
 		 if($mode=='get_link')	
	    $sql="UPDATE appoint_forum set parentAppointID=$insertID WHERE appointID=$appointID "; 	
	     if($mode=='get_link2')	
	    $sql="UPDATE appoint_forum set parentAppointID1=$insertID WHERE appointID=$appointID ";
	    
	     if(!$db->execute($sql))
	    return FALSE; 
	
 	
	  return true;
}            
/**************************************************************************************************/

 
//if(!insertID&&!deleteID)
// otherwise show hierarchical list of all categories
 function  print_form() {
  	
	global $db;
 // echo "<h1>בחר ממנה</h1>\n";
 // echo "<p style='font-weight:bold;color:#3C23AB;'>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים על הממנים.</p>\n";
	
  
  $sql = "SELECT appointName, appointID, parentAppointID FROM appoint_forum ORDER BY appointName";
  $rows = $db->queryObjectArray($sql);
  
   $parent=array();
  foreach($rows as $row) {
    $subcats[$row->parentAppointID][] = $row->appointID;
    $catNames[$row->appointID] = $row->appointName; 
   $parent[$row->appointID][] = $row->parentAppointID; }
  // build hierarchical list
    echo '<ul class="paginated" style="left:100px;"  >';
    echo'<fieldset   style="margin-left:80px;margin-bottom:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">';

         
   $this->print_categories($subcats[NULL], $subcats, $catNames,$parent);
    echo'</fieldset>'; 
      echo '</ul class="paginated">';
    echo '<BR><BR>'; 
 
   
   }   

//===================================================================================   

function print_categories($catIDs, $subcats, $catNames,$parent) {
 global $db;	
  echo '<ul>';
 foreach($catIDs as $appointID) {
  $url="../admin/find3.php?appointID=$appointID";
  $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
  $str2='class=href_modal1';	
  	if($appointID==11){
  		    printf("<li id=li$appointID style='font-weight:bold;color:#9F0038;font-size:20px;cursor:pointer;' onMouseOver=\"$('#li'+$appointID).css('color','#F700F5').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$appointID).css('color','#9F0038').css('font-size', '18px')\"><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b>%s (%s, %s)</b></li>\n",
            htmlspecial_utf8($catNames[$appointID]),
            build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
            build_href2("appoint_edit.php" ,"mode=update_root","&updateID=$appointID", "עדכן"));
	       
			}
			
/****************************************************************************************************/		
	elseif($parent[$appointID][0]=='11' && !(array_item($subcats,$appointID)) ){
    $sql="SELECT a.appointID ,f.forum_decID FROM appoint_forum a
		     LEFT OUTER JOIN forum_dec f ON f.appointID=a.appointID
		      WHERE a.appointID=$appointID ";
		
	if($rows=$db->queryObjectArray($sql))
		 
		if ($rows[0]->forum_decID) {	
    
		    printf("<li id=li$appointID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$appointID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$appointID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
		      htmlspecial_utf8($catNames[$appointID]),
		      build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף",$str2),
		      build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק", "OnClick='return verify();'$str2"),
		      build_href2("appoint_edit.php","mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
		      build_href5("", "", "הראה נתונים",$str));
		   }else{
            printf("<li id=li$appointID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$appointID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$appointID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s)</b>\n",
		      htmlspecial_utf8($catNames[$appointID]),
		      build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף",$str2),
		      build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק", "OnClick='return verify();'$str2"),
		      build_href2("appoint_edit.php","mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2));
				
			}
/*********************************************************************************************************/      
  	}elseif($parent[$appointID][0]=='11' &&  array_item($subcats,$appointID)  ){
  	  	
  	 $sql="SELECT a.appointID ,f.forum_decID FROM appoint_forum a
		     LEFT OUTER JOIN forum_dec f ON f.appointID=a.appointID
		      WHERE a.appointID=$appointID ";
		
	if($rows=$db->queryObjectArray($sql))
			if(($rows[0]->forum_decID)){	
		  	  printf("<li id=li$appointID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$appointID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$appointID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
		      htmlspecial_utf8($catNames[$appointID]),
		      build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף",$str2),
		      build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק", "OnClick='return verify();'$str2" ),
		      build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
		      build_href5("", "", "הראה נתונים",$str));
			}else{
				
			 printf("<li id=li$appointID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$appointID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$appointID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s)</b>\n",
		      htmlspecial_utf8($catNames[$appointID]),
		      build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף",$str2),
		      build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק", "OnClick='return verify();'$str2" ),
		      build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2));
		     
				
			}
/**********************************************************************************************************/			
  	}else{
  	    $sql="SELECT a.appointID ,f.forum_decID FROM appoint_forum a
			     LEFT OUTER JOIN forum_dec f ON f.appointID=a.appointID
			      WHERE a.appointID=$appointID ";
		
	if($rows=$db->queryObjectArray($sql))	
			if(($rows[0]->forum_decID)){	
	
         printf("<li id=li$appointID   style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$appointID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$appointID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
		      htmlspecial_utf8($catNames[$appointID]),
		      build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף",$str2),
		      build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק", "OnClick='return verify();'$str2"),
		      build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
		      build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2),
		      build_href5("", "", "הראה נתונים",$str));
			}else{
			  printf("<li id=li$appointID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$appointID).css('color','brown').css('font-size', '18px')\"  onMouseOut=\"$('#li'+$appointID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s)</b>\n",
		      htmlspecial_utf8($catNames[$appointID]),
		      build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף",$str2),
		      build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק", "OnClick='return verify();'$str2"),
		      build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
		      build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2));
		      
			}      
  	}
  	
 
    if(array_key_exists($appointID, $subcats))
      $this->print_categories($subcats[$appointID], $subcats, $catNames,$parent);
  }
   echo "</li></ul>\n";
}

 
/*******************************************************************************/
/**************************************************************************/
function print_category_entry_form($updateID,$mode='',$no_form=true,$src_link='') {
		global $db;
$insertID=$updateID;		
 $str2='class=href_modal1';		
 $sql  = "SELECT appointName, appointID, parentAppointID " .
          "FROM appoint_forum ORDER BY appointName";
  $rows = $db->queryObjectArray($sql);

 
 	 foreach($rows as $row) {
 	$catNames[$row->appointID] = $row->appointName;
    $parents[$row->appointID] = $row->parentAppointID;
     $subcats[$row->parentAppointID][] = $row->appointID; 
 	 }
 if($mode=='get_link2'){
   
 $src=$src_link;
 $src=explode(',', $src_link); 
  if($subcats[$updateID] && $src[0] && $src[0]!=0){	
 $subcats[$updateID]= array_merge(($subcats[$updateID]), $src);
    }elseif($src_link && $src_link!=0){
    	$subcats[$updateID]=$src;
    	
    }
} 
 //$parentList[]=the level up
 
			$appointID = $updateID;
			while($parents[$appointID]!=NULL) {
				  $appointID = $parents[$appointID];
				  $parentList[] = $appointID; }
 
 
				  
				
////////////////////////////////////////////////////////////////////////////////////////				 
				 
if(isset($parentList)){
for($i=sizeof($parentList)-1; $i>=0; $i--){
		$url="../admin/find3.php?appointID=$parentList[$i]";
      	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
      	$appointID=$parentList[$i];
   

//----------------------------------------------------------------------------------------------------------		 
	  if( $parentList[$i] =='11'){
                printf("<ul><li><b> %s (%s, %s )</b> </li>\n",
	            htmlspecial_utf8($catNames[$parentList[$i]]),
	            build_href2("appoint_edit.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
		        build_href2("appoint_edit.php" ,"mode=update_root","&updateID=$parentList[$i]", "עדכן"));					
		}
		
//----------------------------------------------------------------------------------------------------------		
		else{
			
$sql = "SELECT DISTINCT(f.appointID),f.forum_decName,f.forum_decID,a.appointName FROM forum_dec f
          INNER JOIN appoint_forum a  ON a.appointID=f.appointID 
		   WHERE f.appointID=$appointID ";
		  if($rows = $db->queryObjectArray($sql)){			
			
				if(	(array_item($parents, $parentList[$i]))=='11' ){
		        printf("<ul><li><b> %s (%s, %s, %s, %s )<b> </li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$parentList[$i]", "שנה קישור"),
				build_href5("", "", "הראה נתונים",$str)); 
				}else{
				printf("<ul><li><b> %s (%s, %s, %s, %s, %s) </b></li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$parentList[$i]", "שנה קישור ריאשון",$str2),
                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$parentList[$i]", "שנה קישור שני",$str2),
				build_href5("", "", "הראה נתונים",$str));
					
					
				} 
		}
		
		else{
			
			if(	(array_item($parents, $parentList[$i]))=='11' ){
		        printf("<ul><li><b> %s (%s, %s, %s  )<b> </li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$parentList[$i]", "שנה קישור ריאשון")); 
				}else{
				printf("<ul><li><b> %s (%s, %s, %s, %s) </b></li>\n",
				htmlspecial_utf8($catNames[$parentList[$i]]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$parentList[$i]", "שנה קישור ריאשון",$str2),
                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$parentList[$i]", "שנה קישור שני",$str2));
					
					
				} 
			
		}            
 }//end else
//----------------------------------------------------------------------------------------------------------				
			}
	  }	
	 
 
//////////////////////////////////////////	  
	  // display choosen forum  * BOLD *
//////////////////////////////////////////	  
	 $url="find3.php?appointID=$updateID";
   	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
//----------------------------------------------------------------------------------------------------------
   		 	 if($insertID=='11'){
   		 	 	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=update_root","&updateID=$parentList[$i]", "עדכן"));
				
   		 	 }
   		 	 
//----------------------------------------------------------------------------------------------------------   		 	 
 elseif( (array_item($parents, $updateID))=='11' )
   		 	 {
			 	
   		 	 	$sql = "SELECT DISTINCT(f.appointID),f.forum_decName,f.forum_decID,a.appointName FROM forum_dec f
				          INNER JOIN appoint_forum a  ON a.appointID=f.appointID 
						   WHERE f.appointID=$updateID ";
			 if($rows = $db->queryObjectArray($sql)){	
   		 	 	
   		 	 	
   		 	 	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$updateID","מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$updateID", "שנה קישור ריאשון",$str2),
                build_href5("", "", "הראה נתונים",$str));
                
			  }else{
			  	printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$updateID","מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$updateID", "שנה קישור ריאשון",$str2));
			  	
			  }
                
                
  }//end elseif
//----------------------------------------------------------------------------------------------------------   		 	 
   	   else{
   	   	      	$sql = "SELECT DISTINCT(f.appointID),f.forum_decName,f.forum_decID,a.appointName FROM forum_dec f
				          INNER JOIN appoint_forum a  ON a.appointID=f.appointID 
						   WHERE f.appointID=$updateID ";
			 if($rows = $db->queryObjectArray($sql)){	
   		 	 	printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$updateID","מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$updateID", "שנה קישור ריאשון",$str2),
                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$updateID", "שנה קישור שני",$str2),
				build_href5("", "", "הראה נתונים",$str)); 
   	   	      }else{
   	   	      	printf("<ul><li><b style='color:red;'> %s ( %s, %s, %s, %s)</b> </li>\n",
				htmlspecial_utf8($catNames[$updateID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$updateID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$updateID","מחק","OnClick='return verify();' class=href_modal1"),
				build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$updateID", "שנה קישור ריאשון",$str2),
                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$updateID", "שנה קישור שני",$str2));
   	   	      }
				
   		}//end else		
//----------------------------------------------------------------------------------------------------------					
	//children of the choosen			 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
//----------------------------------------------------------------------------------------------------------			
		 if($mode=='get_link2'){ 
   	       	foreach($subcats[$updateID] as $appointID) {
			  $url="find3.php?appointID=$appointID";
   	          $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		

   	          
   	          $sql = "SELECT DISTINCT(f.appointID),f.forum_decName,f.forum_decID,a.appointName FROM forum_dec f
				          INNER JOIN appoint_forum a  ON a.appointID=f.appointID 
						   WHERE f.appointID=$appointID ";
			  $rows = $db->queryObjectArray($sql);
           	          
			  
 //if( (array_item($parents, $updateID))=='11' ){
	if( (array_item($parents, $appointID))=='11' ){     	
   	        if ($rows[0]->forum_decID) {
   	          	      	
   	          	      	
   	          	 if($appointID==$src_link){//bold
                    printf("<li><b style='color:red;'> %s (%s, %s, %s, %s )</b> </li>\n",
                     	htmlspecial_utf8($catNames[$appointID]),
						build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
						build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
						build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון"),
						build_href5("", "", "הראה נתונים",$str));
   	          	   }
   	          	   
          	   
   	          	   else{//unbold
   	               printf("<li> %s (%s, %s, %s, %s) </li>\n",
   	          			htmlspecial_utf8($catNames[$appointID]),
						build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
						build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();'class=href_modal1") ,
						build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון"),
						build_href5("", "", "הראה נתונים",$str));
   	              }
   	      
        
 
          }else{
         	
            	 if($appointID==$src_link){//bold
                    printf("<li><b style='color:red;'> %s (%s, %s, %s)</b> </li>\n",
                     	htmlspecial_utf8($catNames[$appointID]),
						build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
						build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
						build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון"));
   	          	   }
   	          	   
          	   
   	          	   else{//unbold
   	               printf("<li> %s (%s, %s, %s) </li>\n",
   	          			htmlspecial_utf8($catNames[$appointID]),
						build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
						build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();'class=href_modal1") ,
						build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון"));
   	              }
         	
         	
         	
         }
         
 }//end if
   	          
   	          
//----------------------------------------------------------------------------------------------------------  	          
  else{
   	          	
     	if ($rows[0]->forum_decID) {     	          	
   	          if($appointID==$src_link){//bold
   	          	  
   	            	printf("<li><b style='color:red;'> %s (%s, %s, %s, %s ,%s)</b> </li>\n",
   	          	    htmlspecial_utf8($catNames[$appointID]),
					build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
					build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
					build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
	                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2),	
					build_href5("", "", "הראה נתונים",$str));
                }
   	          	 
   	          	 
   	          	 
   	          	 else{//unbold
	   	          	printf("<li> %s (%s, %s, %s, %s, %s) </li>\n",
					htmlspecial_utf8($catNames[$appointID]),
					build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
					build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
					build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
	                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2),	
					build_href5("", "", "הראה נתונים",$str)); 
   	          	 }
   	          }
   	          
   	       else{
   	       if($appointID==$src_link){//bold
   	          	  
   	            	printf("<li><b style='color:red;'> %s (%s, %s, %s, %s )</b> </li>\n",
   	          	    htmlspecial_utf8($catNames[$appointID]),
					build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
					build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
					build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
	                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2));
                }
   	          	 
   	          	 
   	          	 
   	          	 else{//unbold
	   	          	printf("<li> %s (%s, %s, %s, %s) </li>\n",
					htmlspecial_utf8($catNames[$appointID]),
					build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
					build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
					build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
	                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2)); 
   	          	 }
   	       	
   	       	
   	       }   
   	         
}//end else				
//----------------------------------------------------------------------------------------------------------   	      
		}//end foreach 
	}//end if
//----------------------------------------------------------------------------------------------------------	
	
	
	
	
	
	
else{//$mode=get_link1
		foreach($subcats[$updateID] as $appointID) {
			  $url="find3.php?appointID=$appointID";
   	          $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
				
   	           
   	          $sql = "SELECT DISTINCT(f.appointID),f.forum_decName,f.forum_decID,a.appointName FROM forum_dec f
				          INNER JOIN appoint_forum a  ON a.appointID=f.appointID 
						   WHERE f.appointID=$appointID ";
			  $rows = $db->queryObjectArray($sql);
   	          
   	          
   	          
//----------------------------------------------------------------------------------------------------------   	          
 if( (array_item($parents, $updateID))=='11' ){
 	       if ($rows[0]->forum_decID) {   
   	            printf("<li> %s (%s, %s, %s, %s) </li>\n",
				htmlspecial_utf8($catNames[$appointID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
			    build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון"),
				build_href5("", "", "הראה נתונים",$str));
 	       }else{
 	       	   
 	       	    printf("<li> %s (%s, %s, %s) </li>\n",
				htmlspecial_utf8($catNames[$appointID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
			    build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון"));
 	       	
 	       	
 	       }	 
 }//end if
//---------------------------------------------------------------------------------------------------------- 
 else{
           if ($rows[0]->forum_decID) {     
 	           printf("<li> %s (%s, %s, %s, %s, %s) </li>\n",
				htmlspecial_utf8($catNames[$appointID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
			    build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2),	
				build_href5("", "", "הראה נתונים",$str));
           }else{
           	
           	
           	   printf("<li> %s (%s, %s, %s, %s) </li>\n",
				htmlspecial_utf8($catNames[$appointID]),
				build_href2("appoint_edit.php","mode=insert","&insertID=$appointID", "הוסף"),
				build_href2("appoint_edit.php" ,"mode=delete","&deleteID=$appointID", "מחק","OnClick='return verify();' class=href_modal1") ,
			    build_href2("appoint_edit.php" ,"mode=change_link","&src_mgrID=$appointID", "שנה קישור ריאשון",$str2),
                build_href2("appoint_edit.php" ,"mode=change_link2","&src_mgrID2=$appointID", "שנה קישור שני",$str2));
           	
           }	 
   	          	
   	         
}//end else

//----------------------------------------------------------------------------------------------------------   	          
		}//end foreach 
	}//end else	
//----------------------------------------------------------------------------------------------------------	
		echo "<ul>";
			   
		     $updateID=$appointID;
		     $i++;	  
		  }
		  
//end while		  
//----------------------------------------------------------------------------------------------------------		  
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }
		 
//----------------------------------------------------------------------------------------------------------		 
		 
		 
		 else{
		 		
		  echo "(עדיין אין תת-ממנים.)";
		}
				
		 
 echo "</ul>\n";
 
 	if(isset($parentList))
	echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

/***************************************************************************************/   
if($no_form){

	
if(($mode=='update')){
	?>    
 <form method="post" id="my_appoint"  action="appoint_edit.php?mode=update&updateID=<?php echo  $insertID ; ?> " >
        <table border=1 class="data_table" >
	 <tr><th colspan="3" align="center">עדכן מנהל </th></tr>
     
 <?php
 $sql = "SELECT u.* FROM users u
			LEFT JOIN appoint_forum a   ON u.userID=a.userID
			WHERE u.userID NOT IN(SELECT userID FROM appoint_forum)
			ORDER BY u.full_name ";
		$rows= $db->queryObjectArray($sql);
		foreach($rows as $row){
		  $array[$row->userID] = $row->full_name;	
		}
		
	     form_list11("subcategories" ,$array , array_item($formdata, "subcategories"),"multiple size=10");

?>
   <input type="submit" name="submitbutton" value="עדכן" /><br />
    </tr></table></form>
<?php
/*****************************************************************************************************************/  	     
}elseif(($mode=='get_link')){ 
 ?>
   <form method="post"  id="my_appoint"  action="appoint_edit.php?mode=change_link&src_mgrID=<?php echo  $insertID; ?> "  >
    <table border=1 class="data_table" id="data_table"><tr><td>
	  
	 
       
<?php
$sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
				$rows = $db->queryObjectArray($sql);
				
				
				foreach($rows as $row) {
			      $subcats6[$row->parentAppointID][] = $row->appointID;
			      $catNames6[$row->appointID] = $row->appointName; }
			      
			      $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			     
			      
			      
		          form_list_b("appoint_forum" , $rows, array_item($formdata, "appoint_forum") );
 			    
 ?>
 <input type="submit" name="submitbutton" value="שנה קישור ריאשון" /><br />
    </td></tr></table></form>
<?php
 			    
/**********************************************************************************************************************/ 			    
}elseif(($mode=='get_link2')){ 
 $src_link= $src_link? $src_link:$insertID;	
 ?>
   <form method="post"  id="my_appoint"  action="appoint_edit.php?mode=change_link2&src_mgrID2=<?php echo  $src_link; ?> "  >
    <table border=1 class="data_table" id="data_table"><tr><td>
  
<?php
/*************************************************************************/
$sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
				$rows = $db->queryObjectArray($sql);
				
				
				foreach($rows as $row) {
			      $subcats6[$row->parentAppointID][] = $row->appointID;
			      $catNames6[$row->appointID] = $row->appointName; }
			      
			      $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
			     
			      
			      
		          form_list_b("appoint_forum" , $rows, array_item($formdata, "appoint_forum") );
		         


/**************************************************************************/ 			    
 ?>
 <input type="submit" name="submitbutton" value="שנה קישור שני" />&nbsp 
   <input type="submit" name="submitbutton_cancle" value="בטל קישור שני" /><br />
    </td></tr></table></form>
<?php
 			    
/**********************************************************************************************************************/ 			    
}elseif ($mode=='insert'){ 
 ?>
 <form method="post" id="my_appoint"  action="appoint_edit.php?mode=insert&insertID=<?php echo  $insertID; ?> "  >
   <table border=1 class="data_table" id="data_table">
	 <tr><th colspan="3" align="center">הוסף ממנה </th></tr>
<?php 
$sql = "SELECT u.* FROM users u
			LEFT JOIN appoint_forum a ON u.userID=a.userID
			WHERE u.userID NOT IN(SELECT userID FROM appoint_forum)
			ORDER BY u.full_name ";
		if($rows= $db->queryObjectArray($sql)){
		foreach($rows as $row){
		  $array[$row->userID] = $row->full_name;	
		}
	}else{
		
	$sql = "SELECT userID,full_name FROM users ORDER BY full_name ";
		if($rows= $db->queryObjectArray($sql)){
		foreach($rows as $row){
		  $array[$row->userID] = $row->full_name;	
		}
	   }
		
	}	
	     form_list11("subcategories" ,$array , array_item($formdata, "subcategories"),"multiple size=10");	
?>
 </tr></table>
   <input type="submit" name="submitbutton" value="הוסף" /><br /> 
</form>  
<?php 
/*************************************************************************************************************************/ 
}elseif ($mode=='update_root'){
echo '<form method="post" action="appoint_edit.php?mode=update_root&updateID=',
     $insertID, '">', "\n",
    "<p>עדכן קטגוריה של ",
    "<b>$catNames[$insertID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";	
	
  }  
/*****************************************************************************************************/  
}//end no_form  
/***************************************************************************************************/
   }//end entry
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

$no_form=true;  
is_logged();      
 
switch ($_REQUEST['mode']) {
	 
	 
	case "update":
    
	     update_cat($_GET['updateID']);	
		
		break;
		
		case "update_root":
    
	     update_root($_GET['updateID']);	
		
		break;
		
  										
    case "delete":
               delete_cat($_GET['deleteID']);
		     
         
       
			
		       
 		break;
	  	
					
		 case "insert":
                       
                insert_cat($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['subcategories']);
                //else
                      
               
	  	break;
	  	
	  	
	  	case "change_link":
    
	     change_link_cat($_GET['src_mgrID'],$_POST['submitbutton'],$_POST['form']['appoint_forum']);	
		
		break;
		
		
		
	   case "change_link2":
    
	     change_link_cat2($_GET['src_mgrID'],$_POST['submitbutton'],$_POST['form']['appoint_forum']);	
		
		break;
		
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
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['subcategories']);
 	      	   $c->add_cat();
 	      	   //$c->print_form();
  }

  function update_cat($updateID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['subcategories'],$_POST['deleteID'],$_GET['updateID']);
 	      	   $c->update_category_general();
 	      	  // $c->print_form();
  }
  

  function update_root($updateID){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
 	      	   $c->update_category_root_general();
 	      	  // $c->print_form();
  }
 
  
  
 function change_link_cat($linkID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['appoint_forum'],"","",$_GET['src_mgrID']);
 	            $mode="get_link";
 	      	   $c->change_link("$mode");
 }   
 
 
 function change_link_cat2($linkID,$submitbutton,$subcategories){
 	           $c=new category($_GET['insertID'],$_POST['submitbutton'],$_POST['form']['appoint_forum'],"","",$_GET['src_mgrID2'],$_POST['submitbutton_cancle']);
              
 	           $mode="get_link2";
 	      	   $c->change_link("$mode");
 }   
 html_footer();
 
  
 
?>
 