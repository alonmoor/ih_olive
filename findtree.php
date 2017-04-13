<?php

//require_once 'mydb.php';
//require_once 'mylibraryfunctions.php';
//require_once 'formfunctions.php';
//
//// connect to MySQL
//$db = new MyDb();
//$db->execute("SET NAMES 'utf8'");
require_once ("config/application1.php");
require_once (LIB_DIR . "/formfunctions.php");

html_header();

$pagesize = 10;

// URL data
// show_array($_REQUEST);
$decID      = array_item($_REQUEST, 'decID');
$forum_decID       = array_item($_REQUEST, 'forum_decID');
$catID        = array_item($_REQUEST, 'catID');
$datePattern  = urldecode(array_item($_REQUEST, 'datePattern'));
$datePattern1  = urldecode(array_item($_REQUEST, 'datePattern1'));
$forumPattern  = urldecode(array_item($_REQUEST, 'forumPattern'));
$forumPattern1  = urldecode(array_item($_REQUEST, 'forumPattern'));
$decPattern = urldecode(array_item($_REQUEST, 'decPattern'));
$page         = array_item($_REQUEST, 'page');


//==========================================================================================
// validity
if(!$page || $page<1 || !is_numeric($page))
$page=1;
elseif($page>100)
$page=100;
if(!is_numeric($catID))
$catID = FALSE;
if(!is_numeric($forum_decID))
$forum_decID = FALSE;
if(!is_numeric($decID))
$decID = FALSE;

//===========================================================================================
// form data
$formdata = array_item($_POST, "form");
if(is_array($formdata))
{
	global $db;
	// get rid of magic quotes
	if(get_magic_quotes_gpc())
	while($i = each($formdata))
	$formdata[$i[0]] = stripslashes($i[1]);
	//show_array($formdata);

//if($formdata['forum_decision']!='none'){
//    $forum_ID=$formdata['forum_decision'];
//	$sql="select forum_decName from forums_dec where forum_decID=$forum_ID   " ;
//	 
//	 $rows=$db->queryObjectArray($sql); 
//	   if($rows){
//       foreach($rows as $row) {
//		$formdata['forum_decision']= $row->forum_decName;
//         }
//	   }
//    }  
    $datePattern  = (array_item($formdata, 'source_year') && is_numeric($formdata['source_year']) &&  $formdata['source_year']!=='none');
    $datePattern1  = (array_item($formdata, 'dest_year') && is_numeric($formdata['dest_year'])  && $formdata['dest_year']!=='none');
	$forumPattern  = array_item($formdata, "forum_decision");
	$forumPattern1  = array_item($formdata, "forum") . "%";
	if(array_item($formdata, "btnTitle")) {
		$catID        = array_item($formdata, "category");
		 if($formdata['decision'])
		 $decPattern = array_item($formdata, "decision") . "%"; 
	
	
		 
		/**********************************************************************************************/	
if($datePattern){
 if(array_item($formdata,'source_year') && is_numeric($formdata['source_year'])  && ! (is_numeric($formdata['dest_year']))){

$fields = array( 'source_year' => 'integer', 'source_month' => 'integer','source_day' => 'intger','full_source'=>'string');	
	
foreach ($fields as $key => $type) {
       $date[$key] = safify($formdata[$key], $type);
   } 

        $date['full_source'] = "$date[source_year]-$date[source_month]-$date[source_day]";
        $date['full_source'] =safify($date['full_source'] , $type);
        unset($date['source_year']); unset($date['source_month']);   unset($date['source_day']);
        $date=$date['full_source'];
        $datePattern=$date;
        $formdata['source_year']=$datePattern;
 }
 else{
 	$fields = array( 'source_year' => 'integer', 'source_month' => 'integer','source_day' => 'intger','full_source'=>'string');
 	foreach ($fields as $key => $type) {
       $date[$key] = safify($formdata[$key], $type);
   } 

        $date['full_source'] = "$date[source_year]-$date[source_month]-$date[source_day]";
        $date['full_source'] =safify($date['full_source'] , $type);
        unset($date['source_year']); unset($date['source_month']);   unset($date['source_day']);
        $date=$date['full_source'];
        $datePattern=$date;
        $formdata['source_year']=$datePattern;
 	
 	
//============================================================ 	

     $fields2 = array( 'dest_year' => 'integer', 'dest_month' => 'integer','dest_day' => 'intger','dest'=>'string');
     foreach ($fields2 as $key => $type) {
       $date1[$key] = safify($formdata[$key], $type);
       } 
       $date1['full_dest'] = "$date1[dest_year]-$date1[dest_month]-$date1[dest_day]";
       $date1['full_dest'] =safify($date1['full_dest'] , $type);
       unset($date1['dest_year']); unset($date1['dest_month']);   unset($date1['dest_day']); 
       $date1=$date1['full_dest'];
       $datePattern1=$date1;
       $formdata['dest_year']=$datePattern1;
      }
   }

/***************************************************************************************/ 
		}
		
		
}
/**********************************************************************************************/
function safify($value, $type='') {
    // we're handling our own quoting, so we don't need magic quotes
    if(get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
   // settype($value, $type);
    switch ($type) {
    case 'int': case 'float': case 'double':
        // the settype() above is all we need to do for numbers
        break;
    case 'boolean': /* processing of booleans depends on where $value is coming
     * from.  This section will probably need to be customized on a
     * per-form basis.
     */
        $vals[$key] = is_null($vals) ? 'NULL' : "'$vals'" ;
		return $vals;
        break;
    case 'string':
    	if(is_array($value)){
    	 $value =(trim($value));	
    	 $value[$key] = is_null($value) ? 'NULL' : "'$value'" ;
    	}else{
    	$value= is_null($value) ? 'NULL' : "'$value'" ;
    	}
		return $value;
		break;
     default:
     	if(is_array($value)){
     	$value[$key] = is_null($value) ? 'NULL' : "'$value'" ;
     	}
     	else{
        $value =(trim($value));// mysql_real_escape_string(trim($value));
        //$value = is_null($value) ? 'NULL' : "'$value'" ;
     	}
		return $value;
        break;
    }
    return $value;
}



/**********************************************************************************************/

if($decPattern || $decID || ($catID && $catID!='none')||$datePattern  || $datePattern1) {

	//echo "DsdsDS <BR><BR><BR>";
	$sql = build_decision_query($decPattern, $decID, $catID,  $page, $pagesize,$date,$date1);
	// echo $sql ."<br/>";
	$rows = $db->queryObjectArray($sql);
     if(!$rows){
     echo "<h1>תוצאות חיפוש</h1>\n";
		echo "<p>מצטערים לא נמצא מידע   .</p>\n";
		
		echo '<p><a href="findtree.php">חזרה לטופס החיפוש</a></p>', "\n";
	    echo "<p>חזרה אל ",
		build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n";
	
		return; 
  }else{
        $mysqli=$db->getMysqli();
     if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		            exit ();
        } else {
		      printf("Connect succeeded\n");
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
/*************************************************************************************/
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

        //clear the other result(s) from buffer
        //loop through each result using the next_result() method
         while ($mysqli->next_result()) {
            //free each result.
                $result = $mysqli->use_result();
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
//$sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName) " .
//         " VALUES (" .
//        $mysqli->escape_string($data["level"]) . "," . 
//		$mysqli->escape_string($data["decID"]) . ", " .
//		$mysqli->escape_string($data["parentDecID"]) . ", " .
//	    $mysqli->escape_string($data['decName']) . " ) " ;     
         $result3=$mysqli->query($sql3);
        if ($mysqli->errno) {
         die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
    }
    
 }
/**************************************************************************************/    
      ?>  
       <meta HTTP-EQUIV="REFRESH" content="0; url=treefind_desc.php"> 
 <?  
 }	
   die;  
     show_decisions($rows, $pagesize, $catID);
	//decPattern and forumPattern must be coded within the URL so that any special characters that might
	//be present will not cause any problems. This encoding is decoded with urldecode.
	$query = "&datePattern=$datePattern&datePattern1=$datePattern1&catID=$catID&decID=$decID&decPattern=" .

	 urlencode($decPattern);
	 urlencode($datePattern);
	 urlencode($datePattern1);

	show_page_links($page, $pagesize, sizeof($rows), $query);
	echo '<p><a href="findtree.php">חזרה לטופס החיפוש</a></p>', "\n";
	echo "<p>חזרה אל ",
	build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n";

}

elseif($forumPattern || $forum_decID || $forumPattern1 ) {
	if($formdata['forum_decision'])
	$forum_decID=$formdata['forum_decision'];
	$sql = build_forum_query($forumPattern, $forum_decID, $page, $pagesize);
	$rows = $db->queryObjectArray($sql);
     if(!$rows){
     echo "<h1>תוצאות חיפוש</h1>\n";
		echo "<p>.מצטערים לא נמצא מידע על פורומים</p>\n";
		echo '<p><a href="findtree.php">חזרה לטופס החיפוש</a></p>', "\n";
	    echo "<p>חזרה אל ",
		build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n";
		return; 
     }else{
        $mysqli=$db->getMysqli();
     if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		            exit ();
        } else {
		      printf("Connect succeeded\n");
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
/*************************************************************************************/
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

        //clear the other result(s) from buffer
        //loop through each result using the next_result() method
         while ($mysqli->next_result()) {
            //free each result.
                $result = $mysqli->use_result();
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
//$sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName) " .
//         " VALUES (" .
//        $mysqli->escape_string($data["level"]) . "," . 
//		$mysqli->escape_string($data["decID"]) . ", " .
//		$mysqli->escape_string($data["parentDecID"]) . ", " .
//	    $mysqli->escape_string($data['decName']) . " ) " ;     
         $result3=$mysqli->query($sql3);
        if ($mysqli->errno) {
         die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
    }
    
 }
/**************************************************************************************/    
      ?>  
       <meta HTTP-EQUIV="REFRESH" content="0; url=treefind_desc.php"> 
 <?  
 }	
     
     

     
die;     
	show_forums($rows, $pagesize,$formdata,$forum_decID);

	$query = "forum_decID=$forum_decID&forumPattern=" . urlencode($forumPattern);

	//$query = "forum_decID=$forum_decID&decPattern=" . urlencode($decPattern);
	show_page_links($page, $pagesize, sizeof($rows), $query);
	echo '<p><a href="findtree.php">חזרה לטופס החיפוש</a></p>', "\n";
	echo "<p>חזרה אל ",
	build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n";

}
else {
	// nothing to do, show query forums
	//====================================================
	echo "<h1 dir=rtl>חפש החלטות/פורומים</h1>\n";
	build_form();
	// link to input and category forms
	printf("<p><br />%s </p>\n",
	build_href("dynamic_5.php", "", "חזרה אל רשימת החלטות"));
	//  build_href("categories.php", "", " ערוך קטגוריות"));
}
 
 
 

// functions
//==================================================================================================


// show decisions form
function build_form($formdata=FALSE) {
	global $db;

	// decision form
	form_start("findtree.php");

	form_new_line();

	form_label("החלטה שמתחילה ב ..",true);
	
	form_text("decision", array_item($formdata, "decision"), 30,100 );
	form_label("");
	form_label("");
	form_label("");
	form_end_line();
	 
/****************************************************************************************/
	// forums_dec
	form_new_line();
	
	form_label("גוף מחליט:", TRUE);
	$sql = "SELECT forum_decName,forum_decID FROM forums_dec ORDER BY forum_decName";
	form_list("forum_decision" , $db->queryArray($sql), array_item($formdata, "forum_decision"));
	form_end_line();
/*****************************************************************************************/
	 // authors form
	  
    form_new_line();
    
    form_label("שם גוף מחליט שמתחיל ב..",TRUE);
    
    form_text("forum", array_item($formdata, "forum"), 30,100  );
    form_label("");
    form_label(""); 
     form_label("");
    form_end_line();
	// category
	form_new_line();
	form_label("קטגוריה:",TRUE);
	// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
	$rows = $db->queryObjectArray($sql);
	// build two arrays:
	//   subcats[catID] contains an array with all sub-catIDs
	//   catNames[catID] contains the catName for catID
	foreach($rows as $row) {
		$subcats[$row->parentCatID][] = $row->catID;
		$catNames[$row->catID] = $row->catName; }
		// build hierarchical list
		$rows = build_category_array($subcats[NULL], $subcats, $catNames);
		form_list("category", $rows , array_item($formdata, "category"));

		form_url("categories.php"	,"ערוך קטגוריות",2 );
		form_end_line();

/**********************************************************************************************/
 
//**********************************************************************************************/
// publishing date

			form_new_line();
			form_label("מתאריך:",true);
            // $days= array (1 => '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
	
			
	for($i=1;$i<=31;$i++){
		$days[$i]= $i;
  
		}
            $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            //$years = array (1 => '2007', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019','2020', '2008');
             
            
            $dates = getdate();
             
	if (!isset($year)) {
		$year = date('Y');	
	}
	$end = $year + 10;
	$start=$year - 10;
	for($start;$start<=$end;$start++) {
		$years[$start]=$start;
		
	}

 
	echo '<td class="myformtd">';	
            form_list001 ("source_year" ,$years , array_item($formdata, "source_year") );
 
            form_list001("source_month" ,$months, array_item($formdata, "source_month") );
           
            form_list001("source_day" ,$days, array_item($formdata, "source_day") );
            echo '</td>', "\n";
			 form_label("");
			 
			 form_label("עד תאריך:",true);
			 echo '<td class="myformtd">';	
            form_list001("dest_year" ,$years,array_item($formdata, "dest_year") );
 
            form_list001("dest_month" ,$months,  array_item($formdata, "dest_month") );
           
            form_list001("dest_day" ,$days, array_item($formdata, "dest_day") );
            echo '</td>', "\n";
 
			form_end_line();
			
/**********************************************************************************************************/
form_new_line();
form_label("  כותרת ההחלטה/ההחלטות :(אם תת סעיפים)", TRUE);	
form_text("all_dec", array_item($formdata, "all_dec"), 50  ,200  , 3 );
//form_label("");
//form_label("");
 form_label("");
form_end_line();			
				
 	 
/**********************************************************************************************************/
form_new_line();
form_label("רמת חשיבות החלטה: (1 עד 10)", TRUE);	
form_text("level_dec", array_item($formdata, "level_dec"),  3 , 5 , 3);
form_label("");
form_end_line();			
				
/****************************************************************************************/
form_new_line();
form_label("סטטוס החלטה: (1=פתוחה/0=סגורה)", TRUE);	
form_text("status", array_item($formdata, "status"),  3 , 5 , 3);
form_label("");		
form_end_line();			
/****************************************************************************************/
	 
		form_new_line();
		
		form_label("");

		form_button("btnTitle", "חפש");
		
   
       // form_button("btnTitleRoot", "הראה תצוגת עץ החלטות ");

	 form_end_line();
		form_end();
}
/****************************************************************************************/
 
/**********************************************************************************************************/
// build SQL string to query for decisions
//===============================================
 
function build_decision_query($pattern, $decID, $catID, $page, $size,$date,$date1) {
	global $db;


	//$sql = "SELECT decID, decName FROM decisions";
	$sql="SELECT distinct(d.decID), d.decName,d.dec_time,d.parentDecID,r.catID
	       FROM decisions d
	       left join rel_cat_dec r on d.decID=r.decID
	       left join categories c on c.catID=r.catID";
	// we are already done
	//=============================
	if($decID)
	 
	return $sql . " WHERE d.decID=$decID ORDER BY d.decName";
	 
	// add conditions for category search and pattern search
	//===============================================
	
	
	if($catID && $catID!="none") {

		$catsql="select  c.catID,c.parentCatID
             from  rel_cat_dec r,categories c
             where c.catID=r.catID";
		$rows = $db->queryObjectArray($catsql);
		foreach($rows as $row)
		$subcats[$row->parentCatID][] = $row->catID;
		$cond1 = "c.catID IN (" . subcategory_list($subcats, $catID) . ") "; }

		else

		$cond1 = "TRUE";
/*********************************************************/         
        //if($pattern && $pattern!=='%')
		if($pattern)
		
		$cond2 = "d.decName LIKE " . $db->sql_string($pattern) . " ";


		else
		$cond2 = "TRUE";
		
/*********************************************************/
				
		if($date && !$date1)
		$cond3 = "d.dec_time = " .   $date  . " ";
		else
		$cond3 = "TRUE";
		 
/*********************************************************/
        if($date && $date1)
		 $cond4 = "d.dec_time BETWEEN " .   $date  .  " AND " .   $date1  .  " ";
		else
		 $cond4 = "TRUE";		
				
/*********************************************************/		
		$sql .= " WHERE " . $cond1 . " AND " . $cond2 ." AND " . $cond3 . " AND " . $cond4 .

        " ORDER BY   decName ";
         //if(rows[full])
		// add limit clause
		//$sql .= "LIMIT " . (($page-1) * $size) . "," . ($size + 1);
		 
		return $sql;
		
/*******************************************************************/
 
}

// returns comma-separated list including $catID and all subcategories
//=====================================================================
function subcategory_list($subcats, $catID) {
	$lst = $catID;
	if(array_key_exists($catID, $subcats))
	foreach($subcats[$catID] as $subCatID)
	$lst .= ", " . subcategory_list($subcats, $subCatID);
	return $lst;
}
// build SQL string to query for forums
//==========================================================================================
function build_forum_query($pattern,$forum_decID, $page, $size) {
	 
	global $db;

	//$sql = "SELECT forum_decID, forum_decName FROM forums_dec";
	
	$sql="SELECT distinct(d.decID),f.forum_decID,f.forum_decName,d.decName,
	       c.catID,c.catName,c.parentCatID
	       FROM decisions d
	       left join rel_cat_dec r on d.decID=r.decID
	       left join categories c on c.catID=r.catID 
               left join rel_forum_dec rf on d.decID=rf.decID
	       left join forums_dec f on f.forum_decID=rf.forum_decID"; 
     
	

	if($forum_decID)
	// we are done
 	return $sql . " WHERE f.forum_decID = $forum_decID";
 	else
	return $sql ." WHERE f.forum_decName LIKE " . $db->sql_string($pattern) .
      " ORDER BY f.forum_decNAME " .
      "LIMIT " . (($page-1) * $size) . "," . ($size + 1);
 
}

/**********************************************************************************************************/

// $decisions is an object array;each object has an catId and an catName item
//============================================================================
function show_decisions($decisions, $pagesize,$catID) {
/**********************************************************************************************************/	 
	global $db;

	echo "<h1>תוצאות החיפוש</h1>\n";
	echo '<p><a href="findtree.php">חזרה לטופס החיפוש</a></p>', "\n";
	    echo "<p>חזרה אל ",
		build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n";
	if(!$decisions) {
		echo "<p> מצטערים,לא נימצאו החלטות </p>\n";
//        echo '<p><a href="findtree.php">חזרה לטופס החיפוש</a></p>', "\n";
//	    echo "<p>חזרה אל ",
//		build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n"; 
	
		return; 
	
	}
	if(($decisions[0]->decID)=='11'){
	 	echo "<p>.מצטערים לא נמצא מידע על פורומים</p>\n";
	 	echo "<p>  כול ההחלטות היא רשומת אב.</p>\n";
	 	return;
	 } 

		// build comma-separated string with decIDs
		//===============================================
		$items = min($pagesize, sizeof($decisions));
		for($i=0; $i<$items; $i++)
		if($i==0)
		$decisionIDs = $decisions[$i]->decID;
		else
		$decisionIDs .= "," . $decisions[$i]->decID;

		// get all decision data (no forums)
		// =====================================================

//		$sql = "SELECT decID, decName, parentDecID,parentDecID1, status, 
//		FROM decisions
//		WHERE decID IN ($decisionIDs)
//		ORDER BY decName";
        $sql="SELECT d.decID, d.decName, d.parentDecID,d.parentDecID1, d.status,d.dec_time,r.catID
		FROM decisions d  
		left join rel_cat_dec r
        on (d.decID=r.decID)
		WHERE d.decID IN ($decisionIDs)
		ORDER BY d.decName";
		$decisionrows = $db->queryObjectArray($sql);

		// get the forums for these decisions
	   //===============================================
		 
		if(!$decisionIDs){
		$sql =
               "SELECT f.forum_decName, r.forum_decID, r.decID 
                 FROM forums_dec f, rel_forum_dec r 
                  WHERE f.forum_decID = r.forum_decID 
                   ORDER BY f.forum_decName ";
		$rows = $db->queryObjectArray($sql);
		
		}else{$sql =
               "SELECT f.forum_decName, r.forum_decID, r.decID 
                 FROM forums_dec f, rel_forum_dec r 
                  WHERE f.forum_decID = r.forum_decID 
                   AND r.decID IN ($decisionIDs) 
                     ORDER BY f.forum_decName ";
		$rows = $db->queryObjectArray($sql);
		}
		// build assoc. array for fast access to forums
		//===================================================
		foreach($rows as $forum)
		$forums[$forum->decID][]=array($forum->forum_decName, $forum->forum_decID);

		  
			//============================================================================
			// get all decisions to show decisions
			//====================================================================
			$sql = "SELECT decName, decID, parentDecID, parentDecID1   FROM decisions";
			$rows = $db->queryObjectArray($sql);
			// build assoc. array for fast access to decisions names and parent dec
			foreach($rows as $dec) {
				$decNames[$dec->decID] = $dec->decName;
				$decParents[$dec->decID] = $dec->parentDecID;
			 }
	    	//============================================================================
			// get all categories to show categories
			//====================================================================
	
          $sql = "SELECT catName, catID, parentCatID FROM categories";
		   $rows = $db->queryObjectArray($sql);
		// build assoc. array for fast access to category names and parent cats	
            foreach($rows as $cat) {
			 $catNames[$cat->catID] = $cat->catName;
			 $catParents[$cat->catID] = $cat->parentCatID; }
					 

				// show all decisions in a table
				//===============================================

				echo '<table class="resulttable">', "\n";
				foreach($decisionrows as $decision) {

					echo td1("החלטה:", "td1head");
					$html = htmlspecial_utf8($decision->decName) . " " .
					build_href1("dynamic_5.php","mode=update", "&updateID=$decision->decID", "(עדכן)");
 					echo td2asis($html, "td2head");
					 

					// show all forums for this decision
					//================================================================
					if(array_key_exists($decision->decID, $forums)) {
						$my_forum=0;
						foreach($forums[$decision->decID] as $forum) {
							if($my_forum==0) 
								//echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
								echo td1(" הפורום/ים:");
							 else 
								echo td1("");								
								//echo td3asis( " &darr; "    );
								//echo td1("");
			                
							echo td2url($forum[0], "findtree.php?forum_decID=$forum[1]");

							
							$my_forum++;
						}
					}
					//===============================================


					 
					// if available, show more decision information
					//==========================================================================================

					
                    //$i=0; 
					//if(!$decID){
					 $decID=$decision->decID;
 					//}					
					if($dec){
					//echo td1("");
					echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
					echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");

					echo td1("מסלול קבלת ההחלטה:"),
					td2asis(build_dec_string($decNames, $decParents, $decID));
					}
//==========================================================================================
				
				//	$decID=decisionrows[$i++]->
//					 if(!$catID || $catID=='none'){
//					  $sql="select catID from rel_cat_dec where decID=$decID";
//					  $rows=$db->queryObjectArray($sql);
//                       
//					  foreach($rows  as $catfind){
//					  $catID=$catfind->catID ;
//					  }
//					 }
                  if( $decision->catID) {
                  	$catID=$decision->catID;
					if($cat){
					//echo td1("");
					echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
					echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
					echo td1("מסלול הקטגוריות:"), 
					td2asis(build_cat_string($catNames, $catParents, $catID));
					}
                  }	
					//==========================================================================================

 				    if($decision->parentDecID){
 				    $sql="select decName from decisions where decID=$decision->parentDecID";
 				    $row=$db->queryObjectArray($sql);
 				     echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");	
 					echo td1("מקושרת להחלטה:"),
 					td2url($row[0]->decName, "findtree.php?decID=$decision->parentDecID"); 
 					// td2($decision->parentDecID);
 				    }
					if($decision->parentDecID1){
					$sql="select decName from decisions where decID=$decision->parentDecID1";
 				    $row=$db->queryObjectArray($sql);
 				    echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
					echo td1("מקושרת להחלטה נוספת:"),
					td2url($row[0]->decName, "findtree.php?decID=$decision->parentDecID1"); 
					 //td2($decision->parentDecID1);
					} 
					if($decision->status)
					echo td1("סטטוס:"), td2($decision->status);
					if($decision->dec_time)
					echo td1("תאריך:"), td2($decision->dec_time);

					// show empty line before next
					//===============================================
					echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
				}
				echo "</table>\n";
}

/**********************************************************************************************************/
function show_forums($forums, $pagesize ,$formdata,$forum_decID) {

	global $db;
 
			
	echo "<h1>תוצאות חיפוש</h1>\n";
	if(!$forums) {
		echo "<p>.מצטערים לא נמצא מידע על פורומים</p>\n";
		echo '<p><a href="findtree.php">חזרה לטופס החיפוש</a></p>', "\n";
	    echo "<p>חזרה אל ",
		build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n";
		return; }

		// build comma-separated string with authIDs
		$items = min($pagesize, sizeof($forums));
		$i=0;
    $decisions=0;     
		for($i=0; $i<$items; $i++){
		if($i==0){
			$forumIDs = $forums[$i]->forum_decID;
		}
		else{
			$forumIDs .= "," . $forums[$i]->forum_decID;
		 	
		}
	$decisions++;
	}	
	
	
	if($decisions==1)
		echo "<p>החלטה אחת נימצאה.</p>\n";
		else
        echo "<p> $decisions  החלטות  נימצאו .</p>\n";				
		// get all decisions these forums have decided

//=========================================================================
if($formdata['forum_decision'] || $forums[$i=0]->forum_decID ==$forums[$i+1]->forum_decID ){
        
        $sql = "SELECT d.decName,r.decID, r.forum_decID
		FROM decisions d, rel_forum_dec r
		WHERE d.decID = r.decID
		AND r.forum_decID IN ($forum_decID)
		ORDER BY  d.decName";
		 
		$rows = $db->queryObjectArray($sql);
		 


		// process all forums, show all decisions for each forum
		//=======================================================================
		echo '<table class="resulttable">', "\n";
		    $items=1;
			$decisions=0;
		 for($i=0; $i<$items; $i++) {
			
			echo td1("גוף מחליט:", "td1head"),
			td2($forums[$i]->forum_decName, "td2head");
			
			foreach($rows as $row) 
			 if($forums[$i]->forum_decID == $row->forum_decID)  {
				if($decisions==0){
				echo td1("החלטה:");
     			//echo td2("");
     			
				}
				else
				echo td1("");
				echo td2url($row->decName, "findtree.php?decID=$row->decID");
				 echo td1("", "tdinvisible"), td2("", "tdinvisible"); 
				 echo td1("", "tdinvisible"),td2("", "tdinvisible");// td2("&nbsp;", "tdinvisible");
			  }
			  $decisions++;
			// show empty line before next title
		echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");	 
	 }
	 echo td1("", "tdinvisible"),td2("", "tdinvisible");
	// ECHO	td2("");
}
else{
	
	 $sql = "SELECT d.decName,r.decID, r.forum_decID
		FROM decisions d, rel_forum_dec r
		WHERE d.decID = r.decID
		AND r.forum_decID IN ($forumIDs)
		ORDER BY  d.decName";
		 
		$rows = $db->queryObjectArray($sql);
		 


		// process all forums, show all decisions for each forum
		//=======================================================================
		echo '<table class="resulttable">', "\n";
		   $items=min($pagesize,sizeof($forums)); 
			$decisions=0;
		 for($i=0; $i<$items; $i++) {
			if($i==0)
			//$forumsIDs
			echo td1("גוף מחליט:", "td1head"),
			td2($forums[$i]->forum_decName, "td2head");
			
			foreach($rows as $row) 
			 if($forums[$i]->forum_decID == $row->forum_decID)  {
				if($decisions==0){
     			echo td1("החלטה:","td1head");
     			echo td2("","td2head");
				}
				else{
				echo td1("");
				echo td2url($row->decName, "findtree.php?decID=$row->decID");
				}
			  }
			  $decisions++;
			// show empty line before next title
			 echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
		 }
	
}
//*********************************************************************************************************/
 
					if($forums){
					//echo td2("");
						
					 echo td1("החלטות פורום זה נימצאות בקטגוריה/יות:", "td1head")  ,td2("", "td2head");//,td2("&nbsp;", "tdinvisible");
					
				     //echo td1(""),td2("");
					
                    //echo td2("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible");
					foreach($forums as $cat) {
			         $catNames[$cat->catID] = $cat->catName;
			         $catParents[$cat->catID] = $cat->parentCatID; 
                     $catName[$cat->catID][]=array($cat->catName,$cat->catID);
					}
 
					
					
					
               foreach($catName   as $catname ){ 
 						//echo td1("", "tdinvisible"), td2asis("&nbsp;", "tdinvisible"); 
 	                    $cID=$catname[0][1];
 	                     echo td1(""),
                         td2url($catname [0][0]  , "findtree.php?catID=$cID"); 
                      // echo td1("", "tdinvisible"), td2("", "tdinvisible"); 
					 }
     
 									
 
 					
  		}
 				echo '<table class="resulttable">', "\n";
 				    if($decision->parentDecID)
 					echo td1("מקושרת להחלטה:"),
                    td2url($decision->decName, "findtree.php?decID=$decision->parentDecID"); 
 				    td2($decision->parentDecID);
					if($decision->parentDecID1)
					echo td1("מקושרת להחלטה נוספת:"), td2($decision->parentDecID1);
					if($decision->status)
					echo td1("סטטוס:"), td2($decision->status);
					if($decision->dec_time)
					echo td1("תאריך:"), td2($decision->dec_time);
  		
		       echo "</table>\n";		
				
				
 
				
// show empty line before next
//===============================================
					//echo td1("", "tdinvisible") ,td2asis("&nbsp;", "tdinvisible");
			 	
		
 	
		
		
		
		echo "</table>\n";
}
/**********************************************************************************************************/

//echo "<p>חזרה אל ",
//	build_href("dynamic_5.php", "", "רשימת החלטות") . ".\n";


/*******************************************************************************************/
// returns a string with URLs to $catID an all
//===============================================
// higher level categories
function build_cat_string($catNames, $catParents, $catID) {
	$tmp = build_href("findtree.php", "catID=$catID", $catNames[$catID]);
	while($catParents[$catID] != NULL) {
		$catID = $catParents[$catID];
		$tmp = build_href("findtree.php", "catID=$catID", $catNames[$catID]) .
      " &larr; " . $tmp; }
		return $tmp;
}
function build_forum_string( $forum,$forum_decID) {
	//var_dump($forumNames);die;
	$tmp = build_href("findtree.php", "forum_decID=$forum_decID", $forum[$forum_decID]);
	while($forum[ forum_decID] != NULL) {
		$forum_decID = $forum[forum_decID];
		$tmp = build_href("findtree.php",  "forum_decID=$forum_decID", $forum[forum_decID]) .
      " &darr; " . $tmp; }
		return $tmp;
}
function build_dec_string($decNames, $decParents, $decID) {
	$tmp = build_href("findtree.php", "decID=$decID", $decNames[$decID]);
	while($decParents[$decID] != NULL) {
		$decID = $decParents[$decID];
		//function build_href($url, $query, $txt) 
		$tmp = build_href("findtree.php", "decID=$decID", $decNames[$decID]) .
         " &larr; " . $tmp; }
		return $tmp;
}
// $forums is an object array;
// each object has an forum_decId and an forum_decName item
//==========================================================================================


// help building result table
//===============================================
function td1($txt, $class="td1") {
	echo "<tr><td class=\"$class\">",
	htmlspecial_utf8($txt), "</td>\n"; }

/*******************************************************************************/		

	function td2($txt, $class="td2") {
		echo "<td class=\"$class\">",
		htmlspecial_utf8($txt), "</td></tr>\n"; }
		
/*******************************************************************************/		
		function td2asis($txt, $class="td2") {
			echo "<td class=\"$class\">$txt</td></tr>\n"; }
/*******************************************************************************/		
			function td3asis($txt, $class="td2") {
				echo "<td  class=\"$class\">$txt</td></tr>\n"; }

/*******************************************************************************/		
//($forum[0], "findtree.php?forum_decID=$forum[1]");
				function td2url($txt, $url, $class="td2") {
					echo "<td class=\"$class\">",
//build_href1("dynamic_5.php","mode=update", "&updateID=$decision->decID", "(עדכן)");
 				
					build_href($url, "", $txt), "</td></tr>\n" ; }
/*******************************************************************************/							
					function td2txturl($txt, $urltxt, $url, $class="td2") {
						echo "<td class=\"$class\">",
						htmlspecial_utf8($txt), " ",
						build_href($url, "", $urltxt), "</td></tr>\n"; }
/*******************************************************************************/
/*******************************************************************************/										
						//show_page_links($page, $pagesize, sizeof($rows), $query);
						// show links to previos/next page
						//===============================================
						// $page     .. current page no.
						// $pagesize .. max. no. of items per page
						// $results  .. no. of search results
						
						function show_page_links($page, $pagesize, $results, $query) {

							if(($page==1 && $results<=$pagesize) || $results==0)
							// nothing to do
							return;
							echo "<p>Goto page: ";
							if($page>1) {
								for($i=1; $i<$page; $i++)
								echo build_href("findtree.php", $query . "&page=$i", $i), " ";
								echo "$page "; }
								if($results>$pagesize) {
									$nextpage = $page + 1;
									echo build_href("findtree.php", $query . "&page=$nextpage", $nextpage);
								}
								echo "</p>\n";
						}
                         html_footer();
						?>
