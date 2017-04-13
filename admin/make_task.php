<?php
include  ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
require_once ("../lib/model/decisions_class.php");
  


 global $lang;
  global $db;
if(isset($_POST['rebuild'])&& ($_POST['rebuild']!=0) ){

 $formdata=explode(',',$_POST['rebuild']); 

/////////////////////////////////////////////////////////////////////////////
 //$dest_managers=htmlspecialchars( $_POST[rebuild_mgr] );
$dest_managers= explode(',',strip_tags($_POST[rebuild_mgr]));
 
 $dest_managers = json_decode($_POST[rebuild_mgr]);

///////////////////////////////////////////////////////////////////////////// 
// $dest_userIDs= explode(',',strip_tags($_POST[rebuild_User_mgr]));
 
// $dest_userIDs = json_decode(strip_tags($_POST[rebuild_User_mgr]));
 
 
 
////////////////////////////////////////////////////////////////////////////// 
 if( (count ($formdata)==1) )
 $formdata['single_frm']=1;	
 
 $decID=$_POST['decID'];
 
 
 
 
/*************************************************************************/ 
if(!($formdata['single_frm']==1)  ){
 $i=0;  
 foreach($formdata  as $forum_decID){
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

$get_mgr="SELECT userID from managers WHERE managerID=$mgrID";
		if($rows=$db->queryObjectArray($get_mgr)){
		    $mgr_userID=$rows[0]->userID;
		}
  
 
/*******************************************************************************/

/*******************************************************************************/
 
   
   ?>
   

<!--    <table id="my_general_table_<?php echo $forum_decID; ?>" ><tr><td>-->
    <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />
    <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
    <input type=hidden name="mgr" id="mgr" value="<?php echo $mgrID?>" />
    <input type=hidden name="mgr_userID" id="mgr_userID" value="<?php echo $mgr_userID?>" />

   <?php   


   
//  build_task_form2($decID,$forum_decID,$mgr);
  $lang->build_task_form3($decID,$forum_decID,$mgrID,$mgr_userID);

   
   ?>
<!--<body style="font-size: 10px;">-->
<!--        <button id="my_button">Click Me</button>-->
<!--    </body>-->

<?php 
   
  // require_once HTML_DIR.'/edit_ajx_task.php'; 
// echo '</td></tr></table>';	
		}
       }
 
    }
     
/********************************************************/    
 }else{
 	
 $formdata=explode(',',$_POST['rebuild']);
  $forum_decID=$formdata[0];
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

$get_mgr="SELECT userID from managers WHERE managerID=$mgrID";
		if($rows=$db->queryObjectArray($get_mgr)){
		    $mgr_userID=$rows[0]->userID;
		}
  
		
		
		
		
		
  /*******************************************************************************/ 	 
// echo '<td  colspan="3" norwap class="myformtd"> ';

 
   
   ?>
   

<!--    <table id="my_general_table_<?php echo $forum_decID; ?>" ><tr><td>-->
    <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />
    <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
   <input type=hidden name="mgr" id="mgr" value="<?php echo $mgrID?>" />
    <input type=hidden name="mgr_userID" id="mgr_userID" value="<?php echo $mgr_userID?>" />


   <?php   
//include  HTML_DIR.'/edit_ajx_task.php'; 
//  $lang->build_task_form2($decID,$forum_decID,$mgrID);
 $lang->build_task_form3($decID,$forum_decID,$mgrID,$mgr_userID); 
 
// echo '</td></tr></table>';	
       
   }	
/**********************************************************/ 	
   

     	
 }
 
}
/***********************************************************************************************************/

