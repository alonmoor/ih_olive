<?php
require_once ("../config/application.php");
require_once HTML_DIR.'/edit_task.php';

// require_once ("../lib/model/DBobject3.php");
// require_once ("../lib/model/decisions_class.php");

 global $lang;
  global $db;


 if(!isAjax()) 
html_header();
 $decID=$_REQUEST['decID'];
 $forum_decID=$_REQUEST['forum_decID'];
 
 
 
/*************************************************************************/ 

   
  
if(is_numeric($forum_decID)){	
$getUser_sql	=	"SELECT u.* FROM users u 
                     inner join rel_user_forum r  
                     on u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     ORDER BY u.full_name ASC";

if($rows=$db->queryObjectArray($getUser_sql) ){

/*******************************************************************************/
$get_mgrID="SELECT managerID from forum_dec WHERE forum_decID=$forum_decID";
		if($rows=$db->queryObjectArray($get_mgrID)){
		$mgrID=$rows[0]->managerID;
		}

//$get_mgr="SELECT userID from managers WHERE managerID=$mgrID";
//		if($rows=$db->queryObjectArray($get_mgr)){
//		    $mgr_userID=$rows[0]->userID;
//		}
/*********************************************************************************/  
$sql="SELECT  f.forum_decName,m.managerName FROM forum_dec f
                    INNER JOIN rel_forum_dec  r
			            		 ON r.forum_decID=f.forum_decID
                    INNER JOIN decisions  d
			            		 ON r.decID=d.decID 
			            		 
			        
			         INNER JOIN managers m
			                         ON m.managerID=f.managerID                                   		 
                     
			        WHERE d.decID=$decID
			        AND f.forum_decID=$forum_decID";
	
 if($rows=$db->queryObjectArray($sql)){
  $sql="                 
    SELECT u.userID  FROM users u          
                     WHERE u.userID=(SELECT m.userID FROM managers m
                     WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";                     

     if($rows=$db->queryObjectArray($sql )){
     	$mgr_userID=$rows[0]->userID;
     } 
 }    
/*******************************************************************************/
   ?>
   
<!--   <script type="text/javascript" src="<?php print JS_ADMIN_WWW ?>/ajax.lang.php"></script> -->
  <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi.js"    type="text/javascript"></script>‬
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi_user.js"    type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/my_task.js"    type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="screen"    href="<?php echo CSS_DIR ?>/style_test.css" />
<link rel="stylesheet" type="text/css" media="screen"    href="<?php echo CSS_DIR ?>/style_popup.css" />
 
    <table id="my_general_table_<?php echo $forum_decID; ?>" style="width:100%;" dir="rtl"><tr><td>
    <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />
    <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
    <input type=hidden name="mgr" id="mgr" value="<?php echo $mgrID?>" />
     <input type=hidden name="mgr_userID" id="mgr_userID" value="<?php echo $mgr_userID?>" />
   <?php   
  //$lang->build_task_form2($decID,$forum_decID,$mgrID); 
  build_task_form_find($decID,$forum_decID,$mgr_userID,$mgrID);
 
 echo '</td></tr></table>';	
		}
       }
 
    
     
 
