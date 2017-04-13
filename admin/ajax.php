<?php


require_once ("../config/application.php");
// require_once(LIB_DIR.'/model/class.default.php');
// require_once(LIB_DIR.'/model/en.php');
 set_error_handler('myErrorHandler');
 set_exception_handler('myExceptionHandler');
//$lang = new Lang();
 global $lang;
/***********************************************************************************************/

/******************************************************************************************************************/
 if(isset($_GET['loadTasks2user2']))
{
	 check_read_access();
	//stop_gpc($_GET);
	 
	
	if(_get('compl')==0)      $sqlWhere = ' AND compl=0';
	elseif(_get('compl')==1)  $sqlWhere = '';
	elseif(_get('compl')==2)  $sqlWhere = ' AND compl=1';
	
	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;
	
	if($_REQUEST['userID'])
	$userID=$_REQUEST['userID'];
	else $userID=$userID;
	
	if($_REQUEST['dest_userID'] && $_REQUEST['dest_userID']!='undefined')
	$dest_userID=$_REQUEST['dest_userID'];
	 
	
	
	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;
	
	$inner = '';	 
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_tag_id($tag);
		if(_get('compl')==3){
		$inner = "INNER JOIN tag2task ON t.taskID=tag2task.taskID";
		}else{
		$inner = "INNER JOIN tag2task ON todolist.taskID=tag2task.taskID";
		}
		$sqlWhere .= " AND tag2task.tagID=$tag_id ";
	}
	
	
	
	$s = trim(_get('s'));
	if($s != '') $sqlWhere .= " AND (title LIKE ". $db->quoteForLike("%%%s%%",$s). " OR note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";
	
	
	
	$sort = (int)_get('sort');
	if($sort == 1) $sqlSort = "ORDER BY prio DESC, ddn ASC, duedate ASC, ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY ddn ASC, duedate ASC, prio DESC, ow ASC";
	else $sqlSort = "ORDER BY ow ASC";
	
	
	
	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;
	
	
	
	$t = array();
	$t['total'] = 0;
	$t['list'] = array(); 
	$t['message'] = array();
	
	
	
 if($dest_userID && $dest_userID!='undefined'){
	
 $sql="SELECT t.* , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.dest_userID=$dest_userID 
                                  AND r.forum_decID=$forum_decID 
                                  $sqlSort "; 	
}	else{
     
$sql="SELECT t.* ,u.userID,u.full_name,rt.userID,rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.userID=$userID
                                  AND r.forum_decID=$forum_decID 
                                  $sqlSort "; 	
		 
}	 
	
	$q = $db->queryObjectArray($sql);
	
	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;
		 
		// $t['list'][] = prepareuserTaskRow($r, $tz);
		 
		 $t['list'][] =  prepareTask2userRow ($r, $tz);

	}		
	echo json_encode($t);
	exit;
}
/************************************************************************************************/
  
elseif($_REQUEST ['deleteMultiTask'] 	) 
//elseif(isset ($_GET  ['deleteMultiTask'] )	) 
{
$checbox=array();
$checkbox=$_REQUEST['checkbox'];	

$i=0;
for($i=0;$i<count($checkbox);$i++){
	
	 
if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	 
	check_write_access();
	$id = (int)$_REQUEST['checkbox'][$i];
	$tags = get_task_tags($id);
	$db->execute("BEGIN");
	if($tags && $tags[0] !=null) {
		$s = implode(',', $tags);
		$db->execute("DELETE FROM tag2task WHERE taskID=$id");
		$db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags
	}
	
	
	$sql="SELECT t.* , u.userID , rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  WHERE t.taskID=$id  
			            		  AND d.decID=$decID ";
     
	$r = $db->queryObjectArray($sql);
	$r=$r[0];
	$userID=$r->userID;
	
	
	
	$sql=("DELETE FROM rel_user_task WHERE taskID=$id AND userID=$userID");
	if(!$db->execute($sql) )
	return false;
	
	
	
	
	$sql=("DELETE FROM todolist WHERE taskID=$id AND decID=$decID");
	if($db->execute($sql) )
	$db->execute("COMMIT");
 
	$t = array();
	$t['total'] = $i;//$affected;
	$t['list'][] = array('id'=>$id);

}
	echo json_encode($t);
   
 	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['loadUsertask']))
{
	//check_read_access();
	 stop_gpc($_GET);
	 
	
	 
	
	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;
	
	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;
 
	if($_REQUEST['userID'])
	$userID=$_REQUEST['userID'];
	else $userID=$userID;
	
	
	 
	
	$sql="SELECT t.* ,u.userID,u.full_name,rt.userID FROM todolist t
                                 left JOIN decisions  d
			            		 ON d.decID=t.decID 
                                 left JOIN rel_user_task  rt
			            	      ON rt.taskID=t.taskID 
			            	       left JOIN users u
			            		  ON u.userID=rt.userID 
			            		 left JOIN rel_user_forum  r
			            		 ON r.userID=u.userID 
                     			 where t.compl in(0,1)
                                 AND t.decID=$decID 
                                 AND rt.userID=$userID
                                 AND r.forum_decID=$forum_decID 
                                 ORDER BY t.duedate ASC "; 
	
	
 
	
	 
	
	if($q = $db->queryObjectArray($sql))
	foreach($q as $r)
	{
		$t['total']++;
		if(_get('compl')==3)
		$t['list'][] = prepareuserTaskRow($r, $tz);
		else
		$t['list'][] = prepareTaskRow($r, $tz);
		

	}		
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
 elseif(isset($_GET['loadusertask']))
{

	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;
	
	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;
 
	if($_REQUEST['userID'])
	$userID=$_REQUEST['userID'];
	else $userID=$userID;
	
	
	 
	
	$sql="SELECT t.* ,distinct(u.userID),u.full_name , rt.dest_userID   FROM todolist t
                                 left JOIN decisions  d
			            		 ON d.decID=t.decID 
                                 left JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 left JOIN rel_user_forum  r
			            		 ON r.userID=u.userID 
                     			 where t.compl in(0,1)
                                 AND t.decID=$decID 
                                 AND rt.userID=$userID
                                 AND r.forum_decID=$forum_decID 
                                 ORDER BY t.duedate ASC "; 
	
	
 
	
	 
	
	if($q = $db->queryObjectArray($sql))
	foreach($q as $r)
	{
		$t['total']++;
		if(_get('compl')==3)
		$t['list'][] = prepareuserTaskRow($r, $tz);
		else
		$t['list'][] = prepareTaskRow($r, $tz);
		

	}		
	echo json_encode($t);
	exit;
}
	

/******************************************************************************************************************/ 
elseif(isset($_GET['loadtaskusers'])){
	
$sql	=	"SELECT t.*  ,u.full_name   ,distinct(u.userID) ,rt.dest_userID
                    FROM todolist 
                     left JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 WHERE t.compl in(0,1) 
			                    ORDER BY u.full_name ASC ";		
           $rows		=	$db->queryObjectArray($sql);
           $getTask_Total	=	count($rows);
           $currentUser	=	"none";
   	$t = array();
	$t['total'] = 0;
	$t['list'] = array();	
	

 
 if($rows && $rows!=null){
/******************************************************************************************************/  	
    foreach ($rows as $r) {
/******************************************************************************************************/
    	 $t['total']++;
		$t['list'][] = prepareuserTaskRow($r, $tz);
          
       
    }//end foreach
 }//end if





 
 echo json_encode($t); 
	exit;	
           
}
/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['loadTasks']))
{
	//check_read_access();
	//stop_gpc($_GET);
	 
	
	if(_get('compl')==0)      $sqlWhere = ' AND compl=0';
	elseif(_get('compl')==1)  $sqlWhere = '';
	elseif(_get('compl')==2)  $sqlWhere = ' AND compl=1';
	
	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;
	
	
//	if($_REQUEST['forum_decID'])
//	$forum_decID=$_REQUEST['forum_decID'];
//	else $forum_decID=$forum_decID;
	
	$inner = '';	 
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_tag_id($tag);
		if(_get('compl')==3){
		$inner = "INNER JOIN tag2task ON t.taskID=tag2task.taskID";
		}else{
		$inner = "INNER JOIN tag2task ON todolist.taskID=tag2task.taskID";
		}
		$sqlWhere .= " AND tag2task.tagID=$tag_id ";
	}
	
	
	
	$s = trim(_get('s'));
	if($s != '') $sqlWhere .= " AND (title LIKE ". $db->quoteForLike("%%%s%%",$s). " OR note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";
	
	
	
	$sort = (int)_get('sort');
	if($sort == 1) $sqlSort = "ORDER BY prio DESC, ddn ASC, duedate ASC, ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY ddn ASC, duedate ASC, prio DESC, ow ASC";
	else $sqlSort = "ORDER BY ow ASC";
	
	
	
	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;
	
	
	
	$t = array();
	$t['total'] = 0;
	$t['list'] = array(); 
	$t['message'] = array();
	
	
	
	if(_get('compl')==3)
	
	$sql="SELECT t.*,u.userID, u.full_name ,rt.dest_userID
                    FROM todolist t  
                                 LEFT JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID 
                                 $inner
			            		 where t.compl in(0,1)
                                 $sqlWhere  
                                 and t.decID=$decID 
                                 //ORDER BY u.full_name ASC
                                 $sort "; 
	
	

//    $sql	=	"SELECT t.taskID, t.decID, t.userID, t.task_date, t.compl, t.title, t.note, t.prio, t.ow, 
//                    t.tags, t.duedate, t.dest_userID, t.message,u.full_name 
//                    FROM todolist t left JOIN users u
//			            		 ON u.userID=t.userID 
//			            		 where t.compl=0 
//			                    ORDER BY u.full_name ASC ";	
	else
	$sql=("SELECT * , duedate IS NULL  AS ddn  FROM todolist $inner WHERE 1=1 $sqlWhere AND  decID=$decID  $sqlSort");
	

	
	$q = $db->queryObjectArray($sql);
	
	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;
		if(_get('compl')==3)
		$t['list'][] = prepareuserTaskRow($r, $tz);
		else
		$t['list'][] = prepareTaskRow($r, $tz);
		

	}		
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['loadUsers'])){
	global $db;



	//check_read_access();
	//stop_gpc($_GET);
 
	
	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;
	
	
	if(_get('compl')==0)      $sqlWhere = ' AND u.compl=0';
	elseif(_get('compl')==1)  $sqlWhere = '';
	elseif(_get('compl')==2)  $sqlWhere = ' AND u.compl=1';
		
	
	
	
	//$sqlWhere='';
	$inner = '';
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_taguser_id($tag);
		$inner = "INNER JOIN user_tags ut ON ut.tagID=r.tagID ";  	           
		$sqlWhere .= " AND r.tagID=$tag_id  ";
	}


	
	//	$s = trim(_get('s'));
	//if($s != '') $sqlWhere .= " AND (full_name LIKE ". $db->quoteForLike("%%%s%%",$s). " OR note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";
	
	
	$sort = (int)_get('sort');
     if($sort == 1) $sqlSort = "ORDER BY u.prio DESC, ddn ASC, u.duedate ASC, u.ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY ddn ASC, u.duedate ASC, u.prio DESC, u.ow ASC";
	 else $sqlSort = "ORDER BY u.ow ASC";
	 
	
	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0) 
	$tz = null;
	
	
	
	$t = array();
	$t['total'] = 0;
	$t['list'] = array();
	
	
//userID, fname, lname, upass, active, 
//authent, uname, level, dd, mm, yy, user_date, email, full_name, last_login, phone_num, compl)
//$sql="SELECT u.*,u.user_date IS NULL  AS ddn ,r.rel_date,r.forum_decID,r.tagID,r.tags FROM users u 
//             INNER join rel_user_forum r  
//             on u.userID = r.userID
//             $inner
//             WHERE 1=1 
//            $sqlWhere 
//             AND r.forum_decID = $forum_decID
//            $sqlSort";

$sql= "SELECT distinct(u.userID),u.*, duedate IS NULL  AS ddn ,r.forum_decID,r.tagID,r.tags   FROM users u 
                     LEFT  JOIN rel_user_forum r  
                     ON u.userID = r.userID
                      
                     WHERE  r.forum_decID = $forum_decID 
                         $sqlWhere  ";        
//                       if($compl != '')
//	                 $sql.=" AND r.tagID=$tag_id "; 
                     
//                     AND r.forum_decID = $forum_decID ";
//                     u.compl in(0,1)
	                 if($tag != '')
	                 $sql.=" AND r.tagID=$tag_id ";
	                 $sql.=" $sqlSort ";	
	  
	
	 
	//$sql1=("SELECT * , user_date IS NULL  AS ddn  FROM users  $inner WHERE 1=1 $sqlWhere $sqlSort");
	$getUser= $db->queryObjectArray($sql);
	
	if($getUser && $getUser!=0)
   $getUser_Total	=	count($getUser);

	
foreach ($getUser as $r  ) 

{
		$t['total']++;
		$t['list'][] = prepareUserRow($r);
}
echo json_encode($t); 
	exit;	
	
}	
/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['newTask']))
{
	//check_write_access();
	///stop_gpc($_POST);
	$t = array();
	$t['total'] = 0;
	$title = trim(_post('title'));
	$userID= trim(_post('user'));
	$decID= trim(_post('decID'));
	$forum_decID= trim(_post('forum_decID'));
	
	if( trim(_post('user_dest'))=='none')
	$dest_userID=$userID;
	ELSE
	$dest_userID= trim(_post('user_dest'));
	
	$prio = 0;
	$tags = '';
	
	
if(!isset($config['smartsyntax']) || $config['smartsyntax'] != 0)
	{
		$a = parse_smartsyntax($title);
		if($a === false) {
			echo json_encode($t);
			exit;
		}
		$title = $a['title'];
		$prio = $a['prio'];
		$tags = $a['tags'];
	}
	if($title == '') {
		echo json_encode($t);
		exit;
	}
	
	
	if(isset($config['autotag']) && $config['autotag']) 
	$tags .= ','._post('tag');
	
	
	$tz = (int)_post('tz');
	if( (isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0 ) 
	$d = strftime("%Y-%m-%d %H:%M:%S");
	else 
	$d = gmdate("Y-m-d H:i:s", time()+$tz*60);
	
	
	
	$sql=("SELECT full_name from users  where userID=$userID");
	    $full_name = $db->queryObjectArray($sql);
	    $full_name=$full_name[0]->full_name;
	     
        $sql=("SELECT full_name from users  where userID=$dest_userID");
	    $destfull_name = $db->queryObjectArray($sql);
		$destfull_name=$destfull_name[0]->full_name;
		
	    	
		
		
	
		$message = " ==> ניכתבה ע י  " . $full_name . " אל " . $destfull_name;
	
	
	
	$sql=("SELECT MAX(ow) FROM todolist");
	//$db->queryObjectArray($sql);
	$ow = 1 + (int)$db->queryObjectArray($sql);
	
	$sql=("BEGIN");
	$db->execute($sql);
	
	
	$now	=	date('Y-m-d H:i:s');
		
	
	
	 $sql = "UPDATE users  SET  " .
      	  "duedate="    .  $db->sql_string($now) . "  " .
	  "WHERE userID=$dest_userID";
	
	
	if(!$db->execute($sql) )
	   return false;
	
	
	
//(taskID, decID, userID, task_date, compl, title, note, prio, ow, tags, duedate, dest_userID, message)
//	
//	$sql='INSERT INTO todolist (title,decID,userID,dest_userID,message,task_date,ow,prio) VALUES (	"'. $title . '",
//	        "'. $decID . '",
//	        "'. $userID . '",
//	        "'. $dest_userID . '",
//	        "'. $message . '",
// 			"'. $now .'",
// 			"'. $ow .'",
// 		    "'. $prio .'"   )';
	
      
	   
	   $sql = "INSERT INTO todolist (title,decID ,forum_decID,message,task_date,ow,prio) VALUES ( " .
        $db->sql_string($title) . ", " . 
        $db->sql_string($decID) . ", " .
	    $db->sql_string($forum_decID) . ", " .
		//$db->sql_string($dest_userID) . ", " .
		$db->sql_string($message) . ", " .
		$db->sql_string($now) . ", " .
		$db->sql_string($ow) . ", " .
		$db->is_num($prio)  . " ) " ;
	   
	
	if(!$db->execute ($sql) )
	   return false;
	
	
	$taskID = $db->insertId() ;
	
	$sql="insert into rel_user_task (userID,forum_decID, taskID, dest_userID)VALUES ( " .
        $db->sql_string($userID) . ", " . 
        $db->sql_string($forum_decID) . ", " . 
        $db->sql_string($taskID) . ", " .
	    $db->sql_string($dest_userID) . ") " ;

	if(!$db->execute ($sql) )
	   return false;    
	
	if($tags)
	{
		$tag_ids = prepare_tags($tags);
		if($tag_ids) {
			update_task_tags($id, $tag_ids);
			//$sql= ("UPDATE todolist SET tags= ' .$db->sql_string($tags) . '  WHERE taskID=$taskID" );
		     $sql= "UPDATE todolist SET " .
                 "tags=".   $db->sql_string($tags) . " " .    
                  "WHERE taskID=$taskID " ;
                    		
			
			$db->execute($sql);
		}
	}
	
	$db->execute("COMMIT");
	
// 	$sql=("SELECT * FROM todolist WHERE taskID=$taskID and decID=$decID ");

	
	$sql="SELECT t.* , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  WHERE t.taskID=$taskID  
			            		  AND d.decID=$decID ";
     
	$r = $db->queryObjectArray($sql);
	$r=$r[0];
	
	$t['list'][] = prepareTaskRow($r);
	$t['total'] = 1;
	echo json_encode($t); 
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['deleteTask']))
{
if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	 
	check_write_access();
	$id = (int)$_GET['deleteTask'];
	$tags = get_task_tags($id);
	$db->execute("BEGIN");
	if($tags && $tags[0] !=null) {
		$s = implode(',', $tags);
		$db->execute("DELETE FROM tag2task WHERE taskID=$id");
		$db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags
	}
	
	
	$sql="SELECT t.* , u.userID , rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  WHERE t.taskID=$id  
			            		  AND d.decID=$decID ";
     
	$r = $db->queryObjectArray($sql);
	$r=$r[0];
	$userID=$r->userID;
	
	
	
	$sql=("DELETE FROM rel_user_task WHERE taskID=$id AND userID=$userID");
	if(!$db->execute($sql) )
	return false;
	
	
	
	
	$sql=("DELETE FROM todolist WHERE taskID=$id AND decID=$decID");
	if($db->execute($sql) )
	$db->execute("COMMIT");
	
	$t = array();
	$t['total'] = 1;//$affected;
	$t['list'][] = array('id'=>$id);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['deleteUser']))
{
	check_write_access();
	$id = (int)$_GET['deleteUser'];
    $forum_decID=(int)$_GET['forum_decID'];
	// $forum_ID= trim(_post('forum_decID'));
    //var_dump($forum_decID); die;
    
    
 	$tags = get_user_tags($id,$forum_decID);
	$db->execute("BEGIN");
if($tags && $tags[0] !=null) {
		$s = implode(',', $tags);
		//$db->execute("DELETE FROM tag2user WHERE userID=$id");
		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		$db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
	}
	
	
$sql="SELECT t.taskID    FROM todolist t
                               
                                 left JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 left JOIN rel_user_forum  r
			            		 ON r.userID=u.userID 
                     			 where t.compl in(0,1)
                                 AND rt.userID=$id
                                 AND r.forum_decID=$forum_decID 
                                 ORDER BY t.duedate ASC "; 
	     
	if($rows = $db->queryObjectArray($sql)){
//		for($i=0; $i<count($rows); $i++)
//		if($i==0)
//		$taskIDs = $rows[$i]->taskID;
//		else
//		$taskIDs .= "," . $rows[$i]->taskID;
          
	foreach($rows as $row){
				if(!$taskIDs)
				$taskIDs  = $row->taskID;
				else
				$taskIDs .= ";" . $row->taskID;

			}		
	
	$sql=("DELETE FROM rel_user_task WHERE userID=$id and taskID in($taskIDs)");
	 if(!$db->execute($sql) )
	    return FALSE;
	  $sql=("DELETE FROM todolist WHERE taskID IN ($taskIDs)"); 
	  if($db->execute($sql) )
	$db->execute("COMMIT"); 
	}
//	else{
//		$sql=("DELETE FROM rel_user_task WHERE userID=$id ");
//	
//	if($db->execute($sql) )
//	$db->execute("COMMIT");
//	}
	
	
	
	
	
	$sql=("DELETE FROM rel_user_forum WHERE userID=$id AND   forum_decID=$forum_decID");
	if($db->execute($sql) )
	$db->execute("COMMIT");
	
	$t = array();
	$t['total'] = 1;//$affected;
	$t['list'][] = array('id'=>$id);
	// $t['list'][] = array('id'=>$id,'forum_dec'=>$forum_decID);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['completeTask']))
{
	check_write_access();
	$id = (int)$_GET['completeTask'];
	$compl = _get('compl') ? 1 : 0;
	
	$sql=("UPDATE todolist SET compl= " .$db->sql_string($compl) . " WHERE taskID=$id");
	if(!$db->execute($sql ) )
	   return FALSE;
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'compl'=>$compl);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['completeUser']))
{
	check_write_access();
	$id = (int)$_GET['completeUser'];
	$compl = _get('compl') ? 1 : 0;
	
	$sql=("UPDATE users SET compl= " .$db->sql_string($compl) . " WHERE userID=$id");
	if(!$db->execute($sql ) )
	   return FALSE;
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'compl'=>$compl);
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['editNote']))
{
	check_write_access();
	$id = (int)$_GET['editNote'];
	stop_gpc($_POST);
	$note = str_replace("\r\n", "\n", trim(_post('note')));
	
	$sql=("UPDATE todolist SET note= " .$db->sql_string($note) . " WHERE taskID=$id" );
	if(!$db->execute($sql ) )
	   return FALSE;
	   
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'note'=>nl2br(htmlarray($note)), 'noteText'=>(string)$note);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['edituserNote']))
{
	check_write_access();
	$id = (int)$_GET['edituserNote'];
	stop_gpc($_POST);
	$note = str_replace("\r\n", "\n", trim(_post('note')));
	
	$sql=("UPDATE users SET note= " .$db->sql_string($note) . " WHERE userID=$id" );
	if(!$db->execute($sql ) )
	   return FALSE;
	   
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'note'=>nl2br(htmlarray($note)), 'noteText'=>(string)$note);
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['getTask']))
{
	check_read_access();
	$id = (int)$_GET['getTask'];
	$t = array();
	$t['total'] = 0;
//	$sql=("SELECT * FROM todolist WHERE taskID=$id");

	
	$sql="SELECT t.* ,distinct(u.userID), rt.dest_userID   FROM todolist t
                                 LEFT JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 WHERE t.compl in(0,1)
                                 AND t.taskID=$id"; 
	
	
	
	
	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareTaskRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t); 
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['getUser']))
{
	check_read_access();
	$id = (int)$_GET['getUser'];
	$t = array();
	$t['total'] = 0;
	$sql=("SELECT u.*,r.forum_decID,r.userID FROM users u 
	             LEFT JOIN  rel_user_forum r
	             ON r.userID=u.userID
	             WHERE u.userID=$id");
	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareUserRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t); 
	exit;
}
/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['changeOrder']))
{
	check_write_access();
	stop_gpc($_POST);

	$s = _post('order');
	parse_str($s, $order);
	
	$t = array();
	$t['total'] = 0;
	
	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$sql=("UPDATE todolist SET $set WHERE taskID IN (".implode(',',$ids).")");
			$db->execute($sql);
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}
	
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/

elseif(isset($_GET['changeuserOrder']))
{
	check_write_access();
	stop_gpc($_POST);
	
	
	$s = _post('order');
	parse_str($s, $order);
	
	
	$t = array();
	$t['total'] = 0;
	
	
	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$sql=("UPDATE users SET $set WHERE userID IN (".implode(',',$ids).")");
			$db->execute($sql);
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}
	
	
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['editTask']))
{
	check_write_access();
	$id = (int)$_GET['editTask'];
	 stop_gpc($_POST);
	
	 $title = trim(_post('title'));
	$note = str_replace("\r\n", "\n", trim(_post('note')));
	$prio = (int)_post('prio');

	
	
	$userID=(int)_post('userselect');
	if((int)_post('userselect1')=='none'  )
	$dest_userID=$userID;
	ELSE
	$dest_userID=(int)_post('userselect1');
	
	
	if($prio < -1) $prio = -1;
	elseif($prio > 3) $prio = 3;
	
	
	$duedate = parse_duedate(trim(_post('duedate')));
	
	$t = array();
	$t['total'] = 0;
	if($title == '') {
		echo json_encode($t);
		exit;
	}
	
	
	$tags = trim(_post('tags'));
	$db->execute("BEGIN");
	 
	
	
	//$tags=trim($tags);
    $tag_ids = prepare_tags($tags);
	//$tag_ids =$tag_ids [0];
	$cur_ids = get_task_tags($id);
	if($cur_ids) {
		$ids = implode(',', $cur_ids);
		$db->execute("DELETE FROM tag2task WHERE taskID=$id");
		$sql=("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($ids)");//dq
		$db->execute($sql);
	}
	if($tag_ids) {

		update_task_tags($id, $tag_ids);		
	}
	
	
	$tags =$_POST['tags'] ;
	$tags=trim($tags);
	if(is_null($duedate)) $duedate = 'NULL'; else $duedate = $db->sql_string($duedate);
    if(is_null($note)) $note = 'NULL'; else $note = str_replace("\r\n", "\n", trim($note ));// $note = $db->sql_string($note);
	if(is_null($tags) || $tags=="" ) $tags = 'NULL'; else $tags = $db->sql_string($tags);
	
	
	$sql=("SELECT full_name from users where userID=$userID");
	    $full_name = $db->queryObjectArray($sql);
	    $full_name=$full_name[0]->full_name;
	     
        $sql=("SELECT full_name from users where userID=$dest_userID");
	    $destfull_name = $db->queryObjectArray($sql);
		$destfull_name=$destfull_name[0]->full_name;
		
	    	
		
		
	
		$message = " ==> ניכתבה ע י  " . $full_name . " אל " . $destfull_name;
	
	$sql = "UPDATE rel_user_task SET  " .
	  "userID="     .  $db->sql_string($userID) . ", " .
	  "dest_userID="     .  $db->sql_string($dest_userID) . "  " .
	  "WHERE taskID=$id";
	
	if(!$db->execute($sql) )
	  return FALSE;
	
	$sql = "UPDATE todolist SET  " .
	"title="     .  $db->sql_string($title) . ", " .
	  "note="     .  $db->sql_string($note) . ", " .
	  "prio="     .  $db->sql_string($prio) . ", " .
	 // "userID="     .  $db->sql_string($userID) . ", " .
	  //"dest_userID="     .  $db->sql_string($dest_userID) . ", " .
	  "message="     .  $db->sql_string($message) . ", " .
	  "tags="     .  stripslashes($tags) . ", " .
	  "duedate="    .  stripslashes($duedate) . "  " .
	  "WHERE taskID=$id";
	
	if($db->execute($sql) )
	$db->execute("COMMIT");
	$sql=("SELECT * FROM todolist WHERE taskID=$id");
	$r = $db->queryObjectArray($sql);
	
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareTaskRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t); 
	exit;
}


/******************************************************************************************************************/

elseif(isset($_GET['editUser']))
{
	check_write_access();
	$id = (int)$_GET['editUser'];
	$forum_decID = trim(_post('forum_decID')); 
//	if($forum_decID){
//	phpinfo();die; 
//	}
	
	 stop_gpc($_POST);
	
	$full_name = trim(_post('full_name'));
	$note = str_replace("\r\n", "\n", trim(_post('note')));
	
	$prio = (int)_post('prio');
	if($prio < -1) $prio = -1;
	elseif($prio >3) $prio = 3;
	
	$level= trim(_post('level'));
	if($level=='1'){
	   $level='user';
	}	
	elseif($level=='2'){
	   $level='admin';
	   }
	   elseif($level=='3'){
	   $level='suppervizer';
	   }
	
	  
	$email = trim(_post('email'));
	$upass=trim(_post('upass'));
	$duedate = parse_duedate(trim(_post('duedate')));
	
	
	$t = array();
	$t['total'] = 0;
	if($full_name == '') {
		echo json_encode($t);
		exit;
	}
	
	
	
	$tags = trim(_post('tags'));
	$db->execute("BEGIN");
	 
	 //GET ID:if exist name=get the currentID if not exist get the insert_id
    $tag_ids = prepare_usertags($tags);
    $tagID= $tag_ids[0];//get_taguser_id($tag);
    //CHECK if it the currrentID 
   	$cur_ids = get_user_tags($id,$forum_decID);      
	if($cur_ids && $cur_ids[0]!=null) {
		$ids = implode(',', $cur_ids);
		$db->execute("UPDATE   rel_user_forum set tagID=NULL,tags=''  where tagID=$ids 
		              AND userID=$id AND forum_decID=$forum_decID");
		//$db->execute("DELETE FROM tag2user WHERE userID=$id");
		$sql=("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($ids)");//dq
		$db->execute($sql);
	}
	
	if($tag_ids) {

			update_user_tags($id, $tag_ids,$forum_decID,$tags);		
	
    }
	
	//$tags =$_POST['tags'] ;
	//$tags=trim($tags);
	if(is_null($duedate)) $duedate = 'NULL'; else $duedate = $db->sql_string($duedate);
    if(is_null($note)) $note = 'NULL'; else $note = str_replace("\r\n", "\n", trim($note ));// $note = $db->sql_string($note);
	//if(is_null($tags) || $tags=="" ) $tags = 'NULL'; else $tags = $db->sql_string($tags);
	
	

	$sql = "UPDATE users SET  " .
      "full_name="     .  $db->sql_string($full_name) . ", " .
	  "note="     .  $db->sql_string($note) . ", " .
	  "upass="     .  $db->sql_string($upass) . ", " .
	  "prio="     .  $db->sql_string($prio) . ", " .
	  "level="     .  $db->sql_string($level) . ", " .
	  "email="     .  $db->sql_string($email) . ", " .
	  //"tags="     .  stripslashes($tags) . ", " .
	  "duedate="    .  stripslashes($duedate) . "  " .
	  "WHERE userID=$id";
	
		if($db->execute($sql) ){
	      $db->execute("COMMIT");
	     }
	
 	
	          
	
	
	
	$sql= "SELECT u.* ,r.forum_decID,r.tagID,r.tags FROM users u 
                     LEFT  join rel_user_forum r  
                     ON u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     AND r.userID=$id ";
	                  if($tagID)
	                 $sql.=" AND r.tagID=$tagID";
	        
	                 
	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareUserRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t); 
	exit;
}

/******************************************************************************************************************/

/******************************************************************************************************************/
elseif(isset($_GET['changeOrder']))
{
	check_write_access();
	stop_gpc($_POST);
	
	$s = _post('order');
	parse_str($s, $order);
	
	$t = array();
	$t['total'] = 0;
	
	
	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$db->execute("UPDATE todolist SET $set WHERE taskID IN (".implode(',',$ids).")");
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}
	
	
	echo json_encode($t);
	exit;
}
/*******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['changeuserOrder']))
{
	check_write_access();
	stop_gpc($_POST);
	
	$s = _post('order');
	parse_str($s, $order);
	
	$t = array();
	$t['total'] = 0;
	
	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$db->execute("UPDATE users SET $set WHERE userID IN (".implode(',',$ids).")");
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['login']))
{
	$t = array('logged' => 0);
	
	if(!$needAuth) {
		$t['disabled'] = 1;
		echo json_encode($t);
		exit;
	}
	
	stop_gpc($_POST);
	
	$password = _post('password');
	if($password == $config['password']) {
		$t['logged'] = 1;
		session_regenerate_id(1);
		$_SESSION['logged'] = 1;
	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['logout']))
{
	$_SESSION = array();
	$t = array('logged' => 0);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['suggestTags']))
{
	//check_read_access();
	$begin = trim(_get('q'));
	$limit = (int)_get('limit');
	if($limit<1) $limit = 8;
	//$q = $db->dq("SELECT name,id FROM tags WHERE name LIKE " . $db->sql_string($begin) . " AND tags_count>0 ORDER BY name LIMIT $limit");
	
	
	$sql=("SELECT name,tagID FROM tags WHERE name LIKE " . $db->sql_string($begin) . " AND tags_count>0 ORDER BY name LIMIT $limit");
	$q=$db->queryObjectArray($sql);
	 
	$s = '';
//	while($r = $q->fetch_row()) {
//		$s .= "$r[0]|$r[1]\n";
//	}
if($q && $q!=null){
 foreach($q as $r){
 	
 	(string)$s .= "$r->0 |$r->1\n";
 	
 }
	echo $s;
}	
	exit; 
}
/******************************************************************************************************************/
elseif(isset($_GET['suggestuserTags']))
{
	//check_read_access();
	$begin = trim(_get('q'));
	$limit = (int)_get('limit');
	if($limit<1) $limit = 8;
	
	
	$sql=("SELECT name,tagID FROM user_tags WHERE name LIKE " . $db->sql_string($begin) . " AND tags_count>0 ORDER BY name LIMIT $limit");
	$q=$db->queryObjectArray($sql);
	 
	$s = '';
  if($q && $q!=null){
     foreach($q as $r){
 	
 	 $s .= "$r->name |$r->tagID\n";
 	
     }
	  echo $s;
   }	
	exit; 
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['setPrio']))
{
	check_write_access();
	$id = (int)$_GET['setPrio'];
	$prio = (int)_get('prio');
	
	if($prio < -1) $prio = -1;
	elseif($prio >3) $prio = 3;
	
	$sql=("UPDATE todolist SET prio=$prio WHERE taskID=$id");
	$db->execute($sql);
	
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'prio'=>$prio);
	
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['setuserPrio']))
{
	check_write_access();
	
	$id = (int)$_GET['setuserPrio'];
	
	$prio = (int)_get('prio');
	if($prio < -1) $prio = -1;
	elseif($prio >3) $prio = 3;
	
	$sql=("UPDATE users SET prio=$prio WHERE userID=$id");
	$db->execute($sql);
	
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'prio'=>$prio);
	
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['tagCloud']))
{
	$a = array();
	$sql=("SELECT name,tags_count FROM tags WHERE tags_count>0 ORDER BY tags_count ASC");
	$q = $db->queryObjectArray($sql);	

    if($q && $q !=null)	
	foreach($q as $r){
	$a[$r->name] = $r->name	 ;
	}
	
	
	$t = array();
	$t['total'] = 0;
	
	$count = sizeof($a);
	if(!$count) {
		echo json_encode($t);
		exit;
	}
	
	$qmax = max(array_values($a));
	$qmin = min(array_values($a));
	
	if($count >= 10) $grades = 10;
	else $grades = $count;
	
	$step = ($qmax - $qmin)/$grades;
	
	foreach($a as $tag=>$q) {
		$t['cloud'][] = array('tag'=>$tag, 'w'=> tag_size($qmin,$q,$step) );
	}
	
	$t['total'] = $count;
	
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['taguserCloud']))
{
	$a = array();
	$sql=("SELECT name,tags_count FROM user_tags WHERE tags_count>0 ORDER BY tags_count ASC");
	$q = $db->queryObjectArray($sql);	

	if($q && $q !=null)	
	foreach($q as $r){
	$a[$r->name] = $r->name	 ;
	}
	
	$t = array();
	$t['total'] = 0;
	$count = sizeof($a);
	if(!$count) {
		echo json_encode($t);
		exit;
	}
	$qmax = max(array_values($a));
	$qmin = min(array_values($a));
	if($count >= 10) $grades = 10;
	else $grades = $count;
	
	$step = ($qmax - $qmin)/$grades;
	foreach($a as $tag=>$q) {
		$t['cloud'][] = array('tag'=>$tag, 'w'=> tag_size($qmin,$q,$step) );
	}
	
	$t['total'] = $count;

	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
function prepareTaskRow($r, $tz=null)
{
	$dueA = prepare_duedate($r->duedate, $tz);
	return array(
		'taskID' => $r->taskID,
	    'decID' => $r->decID, 
	    'forum_decID' => $r->forum_decID,
	    'userID'=>$r->userID, 
	    'dest_userID'=>$r->dest_userID,  
		'title' => htmlarray($r->title),
		'date' => htmlarray($r->task_date),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		'tags' => htmlarray($r->tags),
	    'message'=> htmlarray($r->message),

	
	'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
			'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),
	);
}
/******************************************************************************************************************/
function prepareTask2userRow($r, $tz=null)
{
	$dueA = prepare_duedate($r->duedate, $tz);
	return array(
		'taskID' => $r->taskID,
	    'decID' => $r->decID, 
	    'userID'=>$r->userID, 
	    'dest_userID'=>$r->dest_userID,  
		'title' => htmlarray($r->title),
	    'full_name' => htmlarray($r->full_name),
		'date' => htmlarray($r->task_date),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		'tags' => htmlarray($r->tags),
	    'message'=> htmlarray($r->message),

	
	'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
			'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),
	);
}
/******************************************************************************************************************/
function prepareUserRow($r)
{
	$dueA = prepare_duedate($r->duedate, $tz);
	
		return array(
		'userID' => $r->userID,
		'dest_userID' => $r->dest_userID, 
		'forum_decID' => $r->forum_decID,
		'full_name' => htmlarray($r->full_name),
		'date' => htmlarray($r->user_date),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		//'tags' =>  $r->tags , 
	    'tags' => htmlarray($r->tags),
		'email' => htmlarray($r->email),
		'upass' =>(string) $r->upass,
		'level' =>(string) $r->level,
		
		
         		  
		
		
		
		'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
		'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),
		
	);
}

/******************************************************************************************************************/

function prepareuserTaskRow($r, $tz=null)
{
	$dueA = prepare_duedate($r->duedate, $tz);
	return array(
	    'full_name' => htmlarray($r->full_name),
		'taskID' => $r->taskID,
		'title' => htmlarray($r->title),
		'date' => htmlarray($r->task_date),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		'tags' => htmlarray($r->tags),
        'message'=> htmlarray($r->message), 
	
     	'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
	    'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),
	);
}
/******************************************************************************************************************/
/******************************************************************************************************************/
function check_read_access()
{
	if(canAllRead() || is_logged()) return;
	echo json_encode( array('total'=>0, 'list'=>array(), 'denied'=>1) );
	exit;
}

/******************************************************************************************************************/

function check_write_access()
{
	global $config;
	if(!isset($config['password']) || $config['password'] == '') return;
	if(is_logged()) return;
	echo json_encode( array('total'=>0, 'list'=>array(), 'denied'=>1) );
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
function prepare_tags($tags_str)
{
	$tag_ids = array();
	$tag_names = array();
	$tags = explode(',', $tags_str);
	foreach($tags as $v)
	{ 
		# remove duplicate tags?
		$tag = str_replace(array('"',"'"),array('',''),trim($v));
		if($tag == '') continue;
		list($tag_id,$tag_name) = get_or_create_tag($tag);
		if($tag_id && !in_array($tag_id, $tag_ids)) {
			$tag_ids[] = $tag_id;
			$tag_names[] = $tag_name;
		}
	}
	$tags_str = implode(',', $tag_names);
	return $tag_ids;
}

/******************************************************************************************************************/
function prepare_usertags($tags_str)
{
	$tag_ids = array();
	$tag_names = array();
	$tags = explode(',', $tags_str);
	foreach($tags as $v)
	{ 
		# remove duplicate tags?
		$tag = str_replace(array('"',"'"),array('',''),trim($v));
		if($tag == '') continue;
		list($tag_id,$tag_name) = get_or_create_usertag($tag);
		if($tag_id && !in_array($tag_id, $tag_ids)) {
			$tag_ids[] = $tag_id;
			$tag_names[] = $tag_name;
		}
	}
	$tags_str = implode(',', $tag_names);
	return $tag_ids;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
function get_or_create_tag($name)
{
	global $db;
	$sql=("SELECT tagID,name FROM tags WHERE name= " .$db->sql_string($name) . " " );
	$tag = $db->queryObjectArray($sql);
	

	 if($tag[0]->tagID && $tag[0]->tagID !=NULL && $tag[0]->name && $tag[0]->name !=NULL ) {
	 
	 $tag1[0]=$tag[0]->tagID;
	 $tag1[1]=$tag[0]->name;
	 
	 return $tag1;
	 }else// need to create tag
     $name=$db->sql_string($name);
     $sql="INSERT INTO tags (name) VALUES ( $name )"  ;
	if($db->execute($sql) )
	return array($db->insertId(), $name);
}

/******************************************************************************************************************/

function get_or_create_usertag($name)
{
	global $db;
	$sql=("SELECT tagID,name FROM user_tags WHERE name= " .$db->sql_string($name) . " " );
	$tag = $db->queryObjectArray($sql);
	
	 //if($tag[0]->tagID && $tag[0]->tagID !=NULL && $tag[0]->name && $tag[0]->name !=NULL ) {
	 if($tag = $db->queryObjectArray($sql)){
	 $tag1[0]=$tag[0]->tagID;
	 $tag1[1]=$tag[0]->name;
	 
	 return $tag1;
	 }else// need to create tag
     $name=$db->sql_string($name);
     $sql="INSERT INTO user_tags (name) VALUES ( $name )"  ;
	if($db->execute($sql) )
	return array($db->insertId(), $name);
}
/******************************************************************************************************************/
/******************************************************************************************************************/

function get_tag_id($tag)
{
	global $db;
	$tag=$db->sql_string($tag);
	$id = $db->queryObjectArray("SELECT tagID FROM tags WHERE name=$tag");
	return $id ? $id[0]->tagID : 0;
}


/******************************************************************************************************************/

function get_taguser_id($tag)
{
	global $db;
	$tag=$db->sql_string($tag);
	$id = $db->queryObjectArray("SELECT tagID FROM user_tags WHERE name=$tag");
	return $id ? $id[0]->tagID : 0;
}


/******************************************************************************************************************/
/******************************************************************************************************************/
function get_task_tags($id)
{
	global $db;
	$sql=("SELECT tagID FROM tag2task WHERE taskID=$id");
	
	$q = $db->queryObjectArray($sql);
	if($q && $q!=null){
	$a = array();
	foreach($q as $r) {
		$a[] = $r->tagID;
	}
 
	return $a;
	}
	return;
}

/******************************************************************************************************************/
function get_user_tags($id,$forum_decID)
{
	global $db;
 
	$sql=("SELECT tagID FROM rel_user_forum WHERE userID=$id  AND  forum_decID=$forum_decID");
 
	if($q = $db->queryObjectArray($sql) ){
	$a = array();
	foreach($q as $r) {
		$a[] = $r->tagID;
	}
 
	return $a;
	}
	return;
}
/******************************************************************************************************************/
/******************************************************************************************************************/

function update_task_tags($id, $tag_ids)
{
	global $db;
	foreach($tag_ids as $v) {
         //$id=$db->sql_string($id);
       // if(is_array($v) ) 
         // $v=$db->sql_string($v->id); 
       //else  
       //$v=$db->sql_string($v);		
		$sql=("INSERT INTO tag2task (taskID,tagID) VALUES ($id,$v)");
		$db->execute ($sql);
	}
//	 $tag_ids=$db->sql_string($tag_ids[0]);
    $tag_ids=$tag_ids[0];
	$sql=("UPDATE tags SET tags_count=tags_count+1 WHERE tagID IN  ($tag_ids) ");
	$db->execute($sql);
}


/******************************************************************************************************************/
function update_user_tags($userID, $tag_ids,$forum_decID,$tags)
{
	global $db;
	
	if(is_null($tags) || $tags=="" ) 
	$tags = 'NULL';
	 //else 
	// $tags = $db->sql_string($tags);
	
	
	foreach($tag_ids as $v) {
        $sql= "UPDATE rel_user_forum SET " .
        "tagID="  . $db->is_num($v) . ", " .
      " tags="     .  stripslashes($db->sql_string($tags)) . "  " .//  "tags= $tags "      . "  " .// "tags="     .  stripslashes($tags) . "  " .    
         "WHERE userID=$userID " . " ".
        "AND forum_decID=$forum_decID " ;		
		
		$db->execute ($sql);
	}

       
    $tag_ids=$tag_ids[0];
	$sql=("UPDATE user_tags SET tags_count=tags_count+1 WHERE tagID IN  ($tag_ids) ");
	$db->execute($sql);
}


/******************************************************************************************************************/
/******************************************************************************************************************/
function parse_smartsyntax($title)
{
	$a = array();
	if(!preg_match("|^(/([+-]{0,1}\d+)?/)?(.*?)(/([^/]*)/$)?$|", $title, $m)) return false;
	$a['prio'] = isset($m[2]) ? (int)$m[2] : 0;
	$a['title'] = isset($m[3]) ? trim($m[3]) : '';
	$a['tags'] = isset($m[5]) ? trim($m[5]) : '';
	if($a['prio'] < -1) $a['prio'] = -1;
	elseif($a['prio'] > 2) $a['prio'] = 2;
	return $a;
}

/******************************************************************************************************************/

function tag_size($qmin, $q, $step)
{
	if($step == 0) return 1;
	$v = ceil(($q - $qmin)/$step);
	if($v == 0) return 0;
	else return $v-1;

}

/******************************************************************************************************************/

function parse_duedate($s)
{
	$y = $m = $d = 0;
	if(preg_match("|^(\d+)-(\d+)-(\d+)\b|", $s, $ma)) {
		$y = (int)$ma[1]; $m = (int)$ma[2]; $d = (int)$ma[3];
	}
	elseif(preg_match("|^(\d+)\/(\d+)\/(\d+)\b|", $s, $ma)) {
		$m = (int)$ma[1]; $d = (int)$ma[2]; $y = (int)$ma[3];
	}
	elseif(preg_match("|^(\d+)\.(\d+)\.(\d+)\b|", $s, $ma)) {
		$d = (int)$ma[1]; $m = (int)$ma[2]; $y = (int)$ma[3];
	}
	elseif(preg_match("|^(\d+)\.(\d+)\b|", $s, $ma)) {
		$d = (int)$ma[1]; $m = (int)$ma[2]; 
		$a = explode(',', date('Y,m,d'));
		if( $m<(int)$a[1] || ($m==(int)$a[1] && $d<(int)$a[2]) ) $y = (int)$a[0]+1; 
		else $y = (int)$a[0];
	}
	elseif(preg_match("|^(\d+)\/(\d+)\b|", $s, $ma)) {
		$m = (int)$ma[1]; $d = (int)$ma[2];
		$a = explode(',', date('Y,m,d'));
		if( $m<(int)$a[1] || ($m==(int)$a[1] && $d<(int)$a[2]) ) $y = (int)$a[0]+1; 
		else $y = (int)$a[0];
	}
	else return null;
	if($y < 100) $y = 2000 + $y;
	elseif($y < 1000 || $y > 2099) $y = 2000 + (int)substr((string)$y, -2);
	if($m > 12) $m = 12;
	$maxdays = daysInMonth($m,$y);
	if($m < 10) $m = '0'.$m;
	if($d > $maxdays) $d = $maxdays;
	elseif($d < 10) $d = '0'.$d;
	return "$y-$m-$d";
}

/******************************************************************************************************************/

function prepare_duedate($duedate, $tz=null)
{
	global $lang, $config;

	$a = array( 'class'=>'', 'str'=>'', 'formatted'=>'' );
	if($duedate == '') {
		return $a;
	}
	if(is_null($tz)) {
		$ad = explode('-', $duedate);
		$at = explode('-', date('Y-m-d'));
	}
	else {
		$ad = explode('-', $duedate);
		$at = explode('-', gmdate('Y-m-d',time() + $tz*60));
	}
	$diff = mktime(0,0,0,$ad[1],$ad[2],$ad[0]) - mktime(0,0,0,$at[1],$at[2],$at[0]);

	if($diff < -604800 && $ad[0] == $at[0])	{ $a['class'] = 'past'; $a['str'] = $lang->formatMD((int)$ad[1], (int)$ad[2]); }
	elseif($diff < -604800)	{ $a['class'] = 'past'; $a['str'] = $lang->formatYMD((int)$ad[0], (int)$ad[1], (int)$ad[2]); }
	elseif($diff < -86400)		{ $a['class'] = 'past'; $a['str'] = sprintf($lang->get('daysago'),ceil(abs($diff)/86400)); }
	elseif($diff < 0)			{ $a['class'] = 'past'; $a['str'] = $lang->get('yesterday'); }
	elseif($diff < 86400)		{ $a['class'] = 'today'; $a['str'] = $lang->get('today'); }
	elseif($diff < 172800)		{ $a['class'] = 'today'; $a['str'] = $lang->get('tomorrow'); }
	elseif($diff < 691200)		{ $a['class'] = 'soon'; $a['str'] = sprintf($lang->get('indays'),ceil($diff/86400)); }
	elseif($ad[0] == $at[0])	{ $a['class'] = 'future'; $a['str'] = $lang->formatMD((int)$ad[1], (int)$ad[2]); }
	else						{ $a['class'] = 'future'; $a['str'] = $lang->formatYMD((int)$ad[0], (int)$ad[1], (int)$ad[2]); }

	if($config['duedateformat'] == 2) $a['formatted'] = (int)$ad[1].'/'.(int)$ad[2].'/'.$ad[0];
	elseif($config['duedateformat'] == 3) $a['formatted'] = $ad[2].'.'.$ad[1].'.'.$ad[0];
	else $a['formatted'] = $duedate;

	return $a;
}

/******************************************************************************************************************/

function date2int($d)
{
	if(!$d) return 33330000;
	$ad = explode('-', $d);
	$s = $ad[0];
	if(strlen($ad[1]) < 2) $s .= "0$ad[1]"; else $s .= $ad[1];
	if(strlen($ad[2]) < 2) $s .= "0$ad[2]"; else $s .= $ad[2];
	return (int)$s;
}

/******************************************************************************************************************/

function daysInMonth($m, $y=0)
{
	if($y == 0) $y = (int)date('Y');
	$a = array(1=>31,(($y-2000)%4?28:29),31,30,31,30,31,31,30,31,30,31);
	if(isset($a[$m])) return $a[$m]; else return 0;
}

/******************************************************************************************************************/

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
	if($errno==E_ERROR || $errno==E_CORE_ERROR || $errno==E_COMPILE_ERROR || $errno==E_USER_ERROR || $errno==E_PARSE) $error = 'Error';
	elseif($errno==E_WARNING || $errno==E_CORE_WARNING || $errno==E_COMPILE_WARNING || $errno==E_USER_WARNING || $errno==E_STRICT) {
		if(error_reporting() & $errno) $error = 'Warning'; else return;
	}
	elseif($errno==E_NOTICE || $errno==E_USER_NOTICE) {
		if(error_reporting() & $errno) $error = 'Notice'; else return;
	}
	elseif(defined('E_DEPRECATED') && ($errno==E_DEPRECATED || $errno==E_USER_DEPRECATED)) { # since 5.3.0
		if(error_reporting() & $errno) $error = 'Notice'; else return;
	}
	else $error = "Error ($errno)";	# here may be E_RECOVERABLE_ERROR
	throw new Exception("$error: '$errstr' in $errfile:$errline", -1);
}

/******************************************************************************************************************/

function myExceptionHandler($e)
{
	if(-1 == $e->getCode()) {
		echo $e->getMessage(); exit;
	}
	echo 'Exception: \''. $e->getMessage() .'\' in '. $e->getFile() .':'. $e->getLine();
	exit;
}
/***************************************************************************************************************/
function loadTask ($taskID){
//stop_gpc($_GET);
global $db;
	if(_get('compl')) $sqlWhere = '';
	else $sqlWhere = ' AND compl=0';
	$inner = '';
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_tag_id($tag);
		$inner = "INNER JOIN tag2task ON todolist.taskID=tag2task.taskID";
		$sqlWhere .= " AND tag2task.tagID=$tag_id ";
	}
	$s = trim(_get('s'));
	
	
	if($s != '') $sqlWhere .= " AND (title LIKE ". $db->quoteForLike("%%%s%%",$s). " OR note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";
	$sort = (int)_get('sort');
	if($sort == 1) $sqlSort = "ORDER BY prio DESC, ddn ASC, duedate ASC, ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY ddn ASC, duedate ASC, prio DESC, ow ASC";
	else $sqlSort = "ORDER BY ow ASC";
	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0) $tz = null;
	$t = array();
	$t['total'] = 0;
	$t['list'] = array();
	$sql=("SELECT * , duedate IS NULL  AS ddn  FROM todolist $inner WHERE 1=1  and  taskID=$taskID $sqlWhere $sqlSort ");
	$q = $db->queryObjectArray($sql);
	
	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;
		$t['list'][] = prepareuserTaskRow($r, $tz);
	}
	echo json_encode($t); 	
	
	
}

?>