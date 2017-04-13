<?php
//require_once 'DBobject3.php';
//require_once(ROOT_DIR.'/config/application.php');





require_once ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
 require_once(LIB_DIR.'/model/class.handler.php');
require_once (LIB_DIR.'/model/dbtreeview.php');
//require_once HTML_DIR.'/edit_forumdec.php'; 
require_once (ADMIN_DIR.'/ajax2.php');



class Users extends DBObject3
{
	    public $id;
		public $searchCols;
		protected $userID;
		protected $idName;
		protected $tableName;
		public $columns = array();
        protected $uname;
        protected $fname; 
        protected $lname;
        protected $full_name;
        protected $upass;
        protected $level;
        protected $last_login;     
	
 function __construct($id = "")
	{
		parent::__construct('users', 'userID', array('uname','fname', 'lname', 'upass', 'level', 'user_date', 'email', 'full_name', 'last_login', 'phone_num'), $id);
	}
  

 function load_from_db() {
		global $db;
		
		//$sql = "SELECT * FROM users where userID = ".$this->getId();
		$sql = "SELECT * FROM users where userID =$this->id";
		//echo $sql;
		if( $result = $db->execute_query($sql))
			if( $row = $result->fetch_object() ) {
				$this->full_name=$row->full_name;
				$this->level=$row->level;
				$this->userID=$row->userID;
				$this->uname=$row->uname;
				$this->fname=$row->fname;
				$this->lname=$row->lname;
				$this->upass=$row->upass;
				$this->last_login=$row->last_login;
			}
 }	
	
		function setFormdata(&$formdata){
		 $formdata['userID']=$_POST['id'];	
		 $formdata['uname']=$_POST['username'];
		 $formdata['fname']=$_POST['firstname']; 
		 $formdata['lname']=$_POST['lastname']; 
		 $formdata['upass']=$_POST['pass']; 
		 $formdata['full_name']=$_POST['full_name']; 
		 $formdata['level']=$_POST['level']; 
	}
	
/***********************************************************************************************************/
function validate_delUsr($userID) {
	
global $db;	
$sql="SELECT forum_decID  from rel_user_forum  WHERE userID=$userID";	
	
$result=true;	
		
try {
			 
	if($rows=$db->queryObjectArray($sql)){
	$frmName='';
	$i=0;	
		foreach($rows as $forum_decID){
		$sql="SELECT forum_decID ,forum_decName from rel_user_forum  WHERE forum_decID=$forum_decID";
		     if($rows_frm=$db->queryObjectArray($sql)){
		     	$forum_decName=$rows_frm[0]->forum_decName;
		     
	    	}
	    	
	       if($i==0)
	    	$frmName = $forum_decName;
		else
		   $frmName .= "," . $forum_decName;
	    	
	            $result = FALSE;   
			    throw new Exception("משתמש נימצא מתפקד  בפורום/ים $frmName אנא מחוק אותו משם ");
			    $i++;
	       }
	}




} catch(Exception $e){
 			 
	         $message[]=$e->getMessage();
	         
	    }
 
		
 		
		
		
/****************************************************/
	    		
$sql="SELECT forum_decID  from rel_user_Decforum  WHERE userID=$userID";	
	
	
		
try {
			 
	if($rows=$db->queryObjectArray($sql)){
	$frmName='';
	$i=0;	
		foreach($rows as $frm){
		$sql="SELECT forum_decID ,forum_decName from forum_dec  WHERE forum_decID=$frm->forum_decID";
		     if($rows_frm=$db->queryObjectArray($sql)){
		     	$forum_decName=$rows_frm[0]->forum_decName;
		     
	    	}
	    	
	       if($i==0)
	    	$frmName = $forum_decName;
		else
		   $frmName .= "," . $forum_decName;
	    	
	            $result = FALSE;   
			    throw new Exception("משתמש  תפקד בעבר בפורום/ים $frmName אנא מחוק אותו משם ");
			    $i++;
	       }
	}




} catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();
	          
	    }
	    
/*******************************************************/		
if(!$result){
 
	$i=0;
 
	foreach($message as $row){
		 
	  $key="messageError_$i";	
	 $message_name[$key]=$row ;
	 $i++;
	}
 	 
  
   $message_name['userID']=$userID;
   
   return $message_name;
 }
/*************************************************************************************/

 
  return   true;
 
		
/*********************/	
}//end functiom	
/******************************************************************************************************************/

function  deleteUser($id)
{
	$formadta=array();
	global $db; 
	

//$sql="SELECT forum_decID from rel_user_forum  WHERE userID=$id";	
//	if($rows=$db->queryObjectArray($sql)){
//	
//	
//		
//		
//	$forum_decID=$rows[0]->forum_decID;
//	 
//    
// 	$tags = get_user_tags($id,$forum_decID);
//	$db->execute("BEGIN");
//
//if($tags && $tags[0] !=null) {
//		$s = implode(',', $tags);
//		//$db->execute("DELETE FROM tag2user WHERE userID=$id");
//		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
//		$db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
//	}
//	
//	
//$sql="SELECT t.taskID    FROM todolist t
//                               
//                                 left JOIN rel_user_task  rt
//			            		 ON rt.taskID=t.taskID
//			            		 LEFT JOIN users u
//			            		 ON rt.userID=u.userID  
//			            		 left JOIN rel_user_forum  r
//			            		 ON r.userID=u.userID 
//                     			 where t.compl in(0,1)
//                                 AND rt.userID=$id
//                                 AND r.forum_decID=$forum_decID 
//                                 ORDER BY t.duedate ASC "; 
//	     
//	if($rows = $db->queryObjectArray($sql)){
//
//		
//	foreach($rows as $row){
//				if(!$taskIDs)
//				$taskIDs  = $row->taskID;
//				else
//				$taskIDs .= ";" . $row->taskID;
//
//			}		
//	
//	$sql=("DELETE FROM rel_user_task WHERE userID=$id and taskID in($taskIDs)");
//	 if(!$db->execute($sql) )
//	    return FALSE;
//	  $sql=("DELETE FROM todolist WHERE taskID IN ($taskIDs)"); 
//	  if($db->execute($sql) )
//	$db->execute("COMMIT"); 
//	}
///*****************************/	
//	
//	
//	$sql=("DELETE FROM rel_user_forum WHERE userID=$id AND   forum_decID=$forum_decID");
//	if($db->execute($sql) )
//	$db->execute("COMMIT");
//  }
///***************************/  

	
	
	
	
$sql= "DELETE FROM users WHERE userID=$id";
    if (!($db->execute($sql))){
 $str= "בעיות במערכת אנחנו מיתנצלים";	  	 
 $message[]= $str;	
	echo json_encode($message);
	exit;
	  	
   } else{
   	
   	 $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
	$formdata['userID'] =$userID;
   	echo json_encode($formdata);
	exit;
   }          
           
}

 
	
/***********************************************************************************************************/	
}
?>