<?php
 require_once ("../config/application.php");
 
//require_once ("../lib/model/forum_class.php");
require_once (LIB_DIR.'/model/forum_class.php');
require_once ("../lib/model/DBobject3.php");
//require_once ("form.libs.php"); 
$showform=TRUE;


 if(!isAjax() ){
  html_header();
 }
is_logged();

if( array_item($_POST, 'forum_decision') && count($_POST)==1 && !$_GET ){
	
$_REQUEST['mode']="read_data";	
}
 
 
if( array_item($_REQUEST, 'id'))
$forum_decID = array_item($_REQUEST, 'id');
else
$forum_decID = array_item($_REQUEST, 'forum_decID');
/*******************************************************************************/
if(array_item($_POST,'form') && is_numeric($_POST['form']['forum_decID'])
&& $_REQUEST['mode']=='insert'  ){
	$_SESSION['forum_decID']=$_POST['form']['forum_decID'];

}
/*******************************************************************************/

if( ($_POST['form']['forum_decision'] && $_POST['form']['forum_decision']!='none')
     && !($_POST['form']['newforum'] && !$_POST['form']['newforum']!='none') 
     && ($_REQUEST['mode']=='save')   ){
	  $_POST['mode']="update";
	$_REQUEST['mode']="update";
}


/**********************************************************************************/
/**********************************************************************************/
if( ($_POST['forum_decision'] && $_POST['forum_decision']!='none')
     &&  ( is_array($_POST['form']) && is_numeric($_POST['forum_decision'] ) )
     && ($_REQUEST['mode']=='save')   ){
	  $_POST['mode']="update";
	$_REQUEST['mode']="update";
}

/**********************************************************************************/
/**********************************************************************************/
if($_POST['form']['btnLink1'] ) {
	$_POST['mode']="list";
	$_REQUEST['mode']="list";
}
 

/****************************************/
switch ($_REQUEST['mode'] ) {
/***************************************************************************************************/
/***************************************************************************************************/
	case "insert":
		if(is_numeric($_GET['forum_decID']) ){

			update_to_parent($_GET['forum_decID'],$_GET['insertID']);
			unset($_SESSION['forum_decID']);
		}else{
			
			insert_forum($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
		}

		break;
/***************************************************************************************************/
/***************************************************************************************************/
	case  "link":
		if (isset($_REQUEST['form'])){
			read_befor_link($_POST['form']);
		}else{
			$formdata['forum_decID']=$_GET['forum_decID'];
			$formdata['insertID']=$_GET['insertID'];
			read_link($formdata);
		}
		break;
/***************************************************************************************************/
/***************************************************************************************************/
	case  "read_data":
		if( array_item($_POST, 'forum_decision') && count($_POST)==1 && !$_GET){
		$_REQUEST['editID']= array_item($_POST, 'forum_decision');
		}
		if($_REQUEST['editID'])
		$formdata =read_forum($_GET['editID']);
		else
		$formdata =read_forum($_GET['forum_decID']);
		break;
/***************************************************************************************************/
/***************************************************************************************************/
	case "update":
		if($_GET['updateID']) {
			update_forum1($_GET['updateID']);
		}else{
			if($_POST['form']){
				foreach($_POST['form']  as $key=>$val){
					if ($val=='none' || $val== "" )
					unset ($_POST['form'][$key]);
						
				}
					
			}
			global $db;
			$frmID= $_POST['form']['forum_decision'] ; 
				 
/*********************************************************************************/
			if($_POST['form']['dest_users'][0]== 'none')
			unset($_POST['form']['dest_users'][0] );

			if(count($_POST['form']['dest_users'])==0  )
			unset($_POST['form']['dest_users'] );

			if($_POST['form']['src_users'][0]== 'none')
			unset($_POST['form']['src_users'][0] );

			if(count($_POST['form']['src_users'])==0  )
			unset($_POST['form']['src_users'] );


			if($_POST['arr_dest_users'][0]== 'none')
			unset($_POST['arr_dest_users'][0] );

			if(count($_POST['arr_dest_users'])==0  )
			unset($_POST['arr_dest_users'] );
			 
/*********************************************************************************/
			if(!$_POST['form']['dest_users'] && $_POST['arr_dest_users']){
				$formdata=$_POST['form'];
				 
			$staff=implode(',',$_POST['arr_dest_users']);	
			$sql="SELECT userID,full_name FROM users WHERE userID in($staff)";

			if($rows=$db->queryObjectArray($sql)){
				foreach($rows as $row){
				 $formdata["dest_users$frmID"][$row->userID]=$row->full_name;	
				}
				unset($formdata['arr_dest_users']);
			  }	
				
			}elseif($_POST['form']['dest_users'] && is_numeric($_POST['form']['dest_users'][0])){
					
				$formdata=$_POST['form'];
/**********************************************************************************/
			}elseif( !is_numeric($_POST['form']['dest_users'][0])
			&& ($_POST['form']['dest_users'])
			&&  ($_POST['form']['dest_users'][1])){
				 

				$dest_users= $_POST['form']['dest_users'];
				$i=0;
				foreach($dest_users as $key => $val){
					if(is_numeric($val)){
						$array_num[]=$val ;
					}elseif(!is_numeric($val) && $val=='none'){
						unset($dest_users[$i]);
					}else
					$vals[$key] = "'$val'" ;
					$i++;
				}


/*************************************************************************************/
				if($vals){
					$stuff = implode(", ", $vals);
					//$sql="select userID from users where full_name in($stuff)";
					$sql="SELECT  userID,full_name FROM users where full_name in($stuff) ORDER BY userID";
					$rows=$db->queryObjectArray($sql);
					$dest_users="";
				 foreach($rows as $row){
				 	$dest_users[]=$row->userID;//=$row->full_name;
				 	//$dest_users[$row->userID]=$row->userID;
				 }
				 	
				}
				$formdata=$_POST['form'];

				if($array_num && !$dest_users){
					$formdata['dest_user']=$array_num;
	     
				}elseif(!$array_num && $dest_users){
					$formdata['dest_users']=$dest_users;
				 $size_dest=count($formdata['dest_users']);
				}
				elseif($array_num && $dest_users){
					$dest=array_merge($array_num,$dest_users);
					$dest=array_unique($dest);
					$formdata['dest_users'] = $dest;
				}
/***************************************************************************************/
			}elseif(array_item($_POST['form'],'src_users') &&  $_POST['form']['src_users'][0]!=0){
				$formdata=$_POST['form'];
				$formdata['dest_users']=$_POST['form']['src_users'];
				 

				$i=0;
				foreach($formdata['dest_users'] as $key => $val){
					if(is_numeric($val)){
						$array_num[]=$val ;
					}elseif(!is_numeric($val) && $val=='none'){
						unset($dest_users[$i]);
					}else
					$vals[$key] = "'$val'" ;
					$i++;
				}
				 

				if($vals){
					$stuff = implode(", ", $vals);
					//$sql="select userID from users where full_name in($stuff)";
					$sql="SELECT  userID FROM users where full_name in($stuff) ORDER BY userID";
					$rows=$db->queryObjectArray($sql);
					$dest_users="";
				 foreach($rows as $row){
				 	$dest_users[]=$row->userID;//=$row->full_name;
				 }
				 	
				}
				 
				$dest=array_merge($array_num,$dest_users);
				$formdata['dest_users'] = $dest;
					
			}else{
				$formdata=$_POST['form'];
			}
			
/********************************************************************************************/
			if($_POST['form']['adduser_Forum'] && $_POST['form']['adduser_Forum']!='none'
			&& !$_POST['form']['src_users'] && !$_POST['arr_dest_users']
			&& !$_POST['form']['dest_users'] && !is_array($_POST['form']['dest_users']) ){
				 
				$formdata['dest_users']=$_POST['form']['adduser_Forum'];
				unset($formdata['adduser_Forum']);
			}elseif($_POST['form']['adduser_Forum'] && $_POST['form']['adduser_Forum']!='none'
			&& $_POST['form']['dest_users'] ){
				$add_user[]=$_POST['form']['adduser_Forum'] ;

				$formdata['dest_users']=array_merge($formdata['dest_users'], $add_user);
				unset ($add_user);
			}
/*************************************************************************************/
			if($formdata['dest_users'][0] && is_numeric($formdata['dest_users'][0]) && is_array($formdata['dest_users'] )   ){
				foreach($formdata['dest_users'] as $key=>$value){
					if ($value=='none')
					unset($formdata['dest_users'][$key]);
				}
			}
/****************************************************************************************/
			//delete all users in the box and add one user from a list
			if($formdata['dest_users'][0] && is_numeric($formdata['dest_users'][0]) && is_array($formdata['dest_users']) ){
				$destID=implode(',',$formdata['dest_users']);
				$sql="SELECT  userID,full_name FROM users where userID in($destID) ORDER BY userID";
				$rows=$db->queryObjectArray($sql);
				foreach($rows as $row){
					$destNames[$row->userID]=$row->full_name;
				}
				$formdata['dest_users']=$destNames;
			}elseif($formdata['dest_users'] && is_numeric($formdata['dest_users'])  ){
				$destID=$formdata['dest_users'] ;
				$sql="SELECT  userID,full_name FROM users where userID in($destID) ORDER BY userID";
				$rows=$db->queryObjectArray($sql);
				foreach($rows as $row){
					$destNames[$row->userID]=$row->full_name;
				}
				
				$frmID= $_POST['form']['forum_decision'] ; 
				$formdata['dest_users']=$formdata["dest_users$frmID"];
				$formdata['dest_users']=$destNames;
				
			}
			//$formdata["dest_users$frmID"]=$formdata['dest_users'];
			//unset($formdata['dest_users']);
/*****************************************************************************************/

			$db->execute("START TRANSACTION");
			if(!$formdata=update_forum($formdata,$form_rules)){
				$db->execute("ROLLBACK");
				echo "נכשל בעדכון!!!!!";
				
				$formdata=$_POST['form'];
				
				$formdata['forum_decision']=$_POST['form']['forum_decision'];
				$formdata['category']=$_POST['form']['category'];
				$formdata['appoint_forum']=$_POST['form']['appoint_forum'];
				$formdata['manager_forum']=$_POST['form']['manager_forum'];
				$formdata['managerType']=$_POST['form']['managerType'];
                //$formdata['appoint_date1']=$_POST['form']['appoint_date1'];
				//$formdata['manager_date']=$_POST['form']['manager_date'];  
				
				
				
				$formdata['appoint_date1']= $_POST['form']['appoint_date1']  ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['appoint_date1']);
				if(strlen($year_date)>3 ){
				$formdata['appoint_date1']="$day_date-$month_date-$year_date";	
				}
				
				$formdata['manager_date']= $_POST['form']['manager_date'] ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['manager_date']);
				if(strlen($year_date)>3){
				$formdata['manager_date']="$day_date-$month_date-$year_date";
				}
				
				$formdata['forum_date']=$_POST['form']['forum_date'];
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
				if(strlen($year_date)>3 ){
				$formdata['forum_date']="$day_date-$month_date-$year_date";
				} 	
				
//				$formdata['forum_date']=substr($_POST['form']['forum_date'],1,10);
//				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
//				if(strlen($year_date>3) )
//				$formdata['forum_date']="$day_date-$month_date-$year_date";
				

				
if($formdata['dest_users']){				
	    $i=0;
	   foreach($formdata['dest_users'] as $row){
			$member_date="member_date$i"; 
			$rows['full_date'][$i] =$formdata[$member_date];
	       	
		    $i++;	
		}

		  
		
		$i=0;
		foreach($rows['full_date'] as $row){
			
		        $member_date="member_date$i"; 
				list($year_date,$month_date, $day_date) = explode('-',$row);
				if(strlen($year_date)>3 ){
				$formdata[$member_date]="$day_date-$month_date-$year_date";
				}

				$i++;
		}
		      
	$formdata['fail']=true;	
}		
		
					
				if(!$_POST['form']['dest_users'] && $_POST['arr_dest_users']){
					$formdata['dest_users']=$_POST['arr_dest_users'];
				}
					
				if($formdata['src_users'] && $_POST['arr_dest_users'] ){
						
					$i=0;
					foreach ($_POST['arr_dest_users'] as $dst){
						if($dst=='none')
						unset ($_POST['arr_dest_users'][$i]);
						$i++;

					}
						
					$arr=implode(',',$_POST['arr_dest_users'] );
						
					$sql="select userID,full_name from users where userID in($arr)";
					$rows=$db->queryObjectArray($sql);
					foreach ($rows as $row){
						$dest[$row->userID]=$row->full_name;
					}
						
					$formdata['dest_users']=$dest;//$_POST['arr_dest_users'];
						
						
				}elseif($formdata['dest_users']){// && $formdata['dest_users'][0]!='none' && is_numeric($formdata['dest_users'][0]) ){



					$dest_users = $dest_users ? $dest_users:$formdata['dest_users'];
					$i=0;
					foreach ($dest_users as $dst){
						if($dst=='none')
						unset ($dest_users[$i]);
						$i++;

					}


					$arr=implode(',',$dest_users  );
						
					$sql="select userID,full_name from users where userID in($arr)";
					$rows=$db->queryObjectArray($sql);
					foreach ($rows as $row){
						$dest[$row->userID]=$row->full_name;
					}
					$formdata['dest_users']=$dest;

				}
				if($formdata['forum_decision']&& $formdata['newforum'])
				unset( $formdata['forum_decision']);
				
				//if(!$formdata['fail'])
				$formdata['fail']=true;
				show_list($formdata);


				return;

			}else{
				//			  $formdata[forum_date]= substr($formdata[forum_date],1,10 );
				//			   list($year_date,$month_date, $day_date) = explode('-',$formdata['forum_date']);
				//					$formdata['forum_date']="$day_date-$month_date-$year_date";
				//
				//					list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$formdata['appoint_date']);
				//					if (strlen($year_date_appoint) > 3){
				//					$formdata['appoint_date']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
				//					}
				//
				//					list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$formdata['manager_date']);
				//					$year_date_manager1="'$year_date_manager'";
				//				 if (strlen($year_date_manager) > 3){
				//					$formdata['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
				//				 }
				$db->execute("COMMIT");
	
  // show_list($formdata);
    $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
     echo json_encode($formdata);
 	exit;
	
				show_list($formdata);

					
			}
		}
		break;
/***************************************************************************************************/
/***************************************************************************************************/
	case "save":

		if($_POST['form']){
			foreach($_POST['form'] as $key=>$val){
				if ($val=='none'  ||( $val == ""   ) ){
					unset ($_POST['form'][$key]);
				}else {
					$_POST['form'][$key]=$_POST['form'][$key];
				}
			}
				
		}

		global $db;
		if($_POST['form']['dest_users'][0]== 'none')
		unset($_POST['form']['dest_users'][0] );

		if(count($_POST['form']['dest_users'])==0  )
		unset($_POST['form']['dest_users'] );

		if($_POST['form']['src_users'][0]== 'none')
		unset($_POST['form']['src_users'][0] );

		if(count($_POST['form']['src_users'])==0  )
		unset($_POST['form']['src_users'] );


		if($_POST['arr_dest_users'][0]== 'none')
		unset($_POST['arr_dest_users'][0] );

		if(count($_POST['arr_dest_users'])==0  )
		unset($_POST['arr_dest_users'] );
/*********************************************************************************/
		if(!$_POST['form']['dest_users'] && $_POST['arr_dest_users']){
			$formdata=$_POST['form'];
			$formdata['dest_users']=$_POST['arr_dest_users'];
		}elseif($_POST['form']['dest_users'] && is_numeric($_POST['form']['dest_users'][0])){
				
			$formdata=$_POST['form'];
/**********************************************************************************/
		}elseif(!is_numeric($_POST['form']['dest_users'][0]
		&& ($_POST['form']['dest_users'][0]=='none'))
		&& ($_POST['form']['dest_users'])
		&&  ($_POST['form']['dest_users'][1])){
			 

			$dest_users= $_POST['form']['dest_users'];
			$i=0;
			foreach($dest_users as $key => $val){
				if(is_numeric($val)){
					$array_num[]=$val ;
				}elseif(!is_numeric($val) && $val=='none'){
					unset($dest_users[$i]);
				}else
				$vals[$key] = "'$val'" ;
				$i++;
			}


/*************************************************************************************/
			if($vals){
				$stuff = implode(", ", $vals);
				//$sql="select userID from users where full_name in($stuff)";
				$sql="SELECT  userID,full_name FROM users where full_name in($stuff) ORDER BY userID";
				$rows=$db->queryObjectArray($sql);
				$dest_users="";
				foreach($rows as $row){
				 $dest_users[]=$row->userID;//=$row->full_name;
				 $dest_users[$row->userID]==$row->full_name;
				}
			}
			$formdata=$_POST['form'];

			if($array_num && !$dest_users){
				$formdata['dest_user']=$array_num;
				 
			}elseif(!$array_num && $dest_users){
				$formdata['dest_users']=$dest_users;
				$size_dest=count($formdata['dest_users']);
			}
			elseif($array_num && $dest_users){
				$dest=array_merge($array_num,$dest_users);
				$dest=array_unique($dest);
				$formdata['dest_users'] = $dest;
			}
/***************************************************************************************/
		}elseif($_POST['form']['dest_users'][0]=='none'){
			$formdata=$_POST['form'];
			unset($formdata['dest_users']);
		}elseif(array_item($_POST['form'],'src_users') &&  $_POST['form']['src_users'][0]!=0){
			$formdata=$_POST['form'];
			$formdata['dest_users']=$_POST['form']['src_users'];
				
				

			$i=0;
			foreach($formdata['dest_users'] as $key => $val){
				if(is_numeric($val)){
					$array_num[]=$val ;
				}elseif(!is_numeric($val) && $val=='none'){
					unset($dest_users[$i]);
				}else
				$vals[$key] = "'$val'" ;
				$i++;
			}
			 

			if($vals){
				$stuff = implode(", ", $vals);
				//$sql="select userID from users where full_name in($stuff)";
				$sql="SELECT  userID FROM users where full_name in($stuff) ORDER BY userID";
				$rows=$db->queryObjectArray($sql);
				$dest_users="";
				foreach($rows as $row){
				 $dest_users[]=$row->userID;//=$row->full_name;
				}
					
			}
			 
			$dest=array_merge($array_num,$dest_users);
			$formdata['dest_users'] = $dest;
/********************************************************************************************/
		}else{
			$formdata=$_POST['form'];
		}
		if($_POST['form']['adduser_Forum'] && $_POST['form']['adduser_Forum']!='none'){
			$formdata['dest_users']=$_POST['form']['adduser_Forum'];
			unset($formdata['adduser_Forum']);
		}
			
/****************************************************************************************/
		if($formdata['dest_users'][0] && is_numeric($formdata['dest_users'][0])  ){
			$destID=implode(',',$formdata['dest_users']);
			$sql="SELECT  userID,full_name FROM users where userID in($destID) ORDER BY userID";
			$rows=$db->queryObjectArray($sql);
			foreach($rows as $row){
				$destNames[$row->userID]=$row->full_name;
			}
			$formdata['dest_users']=$destNames;
		}

/****************************************************************************************/
		$db->execute("START TRANSACTION");
		if(!validate($formdata )){

			show_error_msg(" נכשל בשמירה!!!!! ");
			//echo " נכשל בשמירה!!!!! ";
			$formdata=$_POST['form'];
			$formdata['forum_decision']=$_POST['form']['forum_decision']?$_POST['form']['forum_decision']:$formdata['newforum'];
			$formdata['category']=$_POST['form']['category'];
			$formdata['appoint_forum']=$_POST['form']['appoint_forum'];
			$formdata['manager_forum']=$_POST['form']['manager_forum'];
			$formdata['managerType']=$_POST['form']['managerType'];
				
				
			if(!$_POST['form']['dest_users'] && $_POST['arr_dest_users']){
				$formdata['dest_users']=$_POST['arr_dest_users'];
			}
				
			if($formdata['src_users'] && $_POST['arr_dest_users'] ){
					
				$i=0;
				foreach ($_POST['arr_dest_users'] as $dst){
					if($dst=='none')
					unset ($_POST['arr_dest_users'][$i]);
					$i++;

				}
					
				$arr=implode(',',$_POST['arr_dest_users'] );
					
				$sql="select userID,full_name from users where userID in($arr)";
				$rows=$db->queryObjectArray($sql);
				foreach ($rows as $row){
					$dest[$row->userID]=$row->full_name;
				}
					
				$formdata['dest_users']=$dest;//$_POST['arr_dest_users'];
					
					
			}elseif($formdata['dest_users']){



				$dest_users = $dest_users ? $dest_users:$formdata['dest_users'];
				$i=0;
				foreach ($dest_users as $dst){
					if($dst=='none')
					unset ($dest_users[$i]);
					$i++;

				}


				$arr=implode(',',$dest_users  );
					
				$sql="select userID,full_name from users where userID in($arr)";
				$rows=$db->queryObjectArray($sql);
				foreach ($rows as $row){
					$dest[$row->userID]=$row->full_name;
				}
				$formdata['dest_users']=$dest;

			}
			if($formdata['forum_decision']&& $formdata['newforum'])
			unset( $formdata['forum_decision']);
				
				
			$formdata['forum_status']=($_POST['form']['forum_status']);
/*********************************************************************************************************/
			$formdata['appoint_date1']= $_POST['form']['appoint_date1']  ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['appoint_date1']);
				if(strlen($year_date)>3 ){
				$formdata['appoint_date1']="$day_date-$month_date-$year_date";	
				}
				
				$formdata['manager_date']= $_POST['form']['manager_date'] ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['manager_date']);
				if(strlen($year_date)>3){
				$formdata['manager_date']="$day_date-$month_date-$year_date";
				}
				
				$formdata['forum_date']=$_POST['form']['forum_date'];
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
				if(strlen($year_date)>3 ){
				$formdata['forum_date']="$day_date-$month_date-$year_date";
				} 	
				$formdata['fail']=true;
/***************************************************************************************************/
			 show_list($formdata);


			return;

		}else{
			//show_list($_POST['form']);
		}
		break;
/**********************************************************************************************/
/**********************************************************************************************/
	case "realy_delete":
			
		real_del($_POST['form']);
		$showform=FALSE;


		break;
/**********************************************************************************************/
/*********************************************************************************************/
	case "clear":
			
         $frm =new forum_dec();

			echo "<h1>הזן נתונים לפורום  </h1>";

			$frm->print_form();
			show_list($formdata);
		//link1();
		break;
/**********************************************************************************************/
/********************************************************************************************/
	case "delete":
		if (($_GET['deleteID'])){
			delete_forum($_GET['deleteID']);//subcategories
		}else{
			delete_forum($_POST['form']['forum_decision']);
		}

		break;
/**********************************************************************************************/
/**********************************************************************************************/
	case "del_usrFrm":
		if (($_GET['userID']) &&  ($_GET['forum_decID']) )
		if(!delete_user_forum($_GET['userID'],$_GET['forum_decID']) ){
			show_error_msg("אין מספיק נתונים למחיקה");
		}else{
			read_forum($_GET['forum_decID']);
		}

		break;
/**********************************************************************************************/
 
	default:
	case "list":

		$frm =new forum_dec();



		//		if($formdata){
		if($showform && !($_POST['form']['btnLink1'])) {
				
			$formdata = array_item($_POST, "form");
				
			if(array_item($formdata, "forum_decID"))
			echo "<h1>ערוך פורום</h1>";
			else
			echo "<h1>הזן נתונים לפורום  </h1>";

			$frm->print_forum_paging();
			//$frm->print_form();
			show_list($formdata);

		}else{
			$forum_decID=$_POST['form']['forum_decID'];
			if(is_numeric($forum_decID) )
			$frm->print_forum_entry_form1($forum_decID);
			$frm->print_forum_paging($forum_decID);
				
		}
}

/**********************************************************************************************/
function update_forum($formdata,$form_rules){
	global $db;
	$frm=new forum_dec();//($formdata);


	$formselect=$frm->read_forum_data($formdata['forum_decision']);
	if($formselect['src_users'] && $formselect['src_users']!=null
	   && $formselect['src_usersID'] && $formselect['src_usersID']!=null  ){

		//$formdata['src_users']=$formselect['src_users'];
		
		$formdata['src_users']= explode(',',$formselect['src_users']);
		 
		$formdata['src_usersID']= explode(',',$formselect['src_usersID']);
		 
		$formdata['date_src_users']= explode(',',$formselect['date_users']);
	}else{
		unset($formdata[src_users]);
		unset($formdata[src_usersID]);
	}
/******************************************************************************************/
	$formdata['forum_decID']= $formdata['forum_decision'];
    $frmID=$formdata['forum_decision'];
	$formdata['insertID']=$formselect['parentForumID'];
	$formdata['forum_decName']=$formselect['forum_decName'];
/*****************************************************************************************/
	$dates = getdate();
  $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
  $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);
    
   $today= $frm->build_date5($dates); 
    $formdata['today']=$today['full_date'];
    
	$frm->config_date($formdata);
	
	$dateIDs=$frm->build_date($formdata) ;//users_date=>multi
	$dateIDs=$dateIDs['full_date'];
	
	$frm_date=$formdata['forum_date'];
	$date_usr = $formdata['today'];
    
/***************************************************************************************************/
	if(array_item($formdata,"dest_users$frmID")){
		 
		$usersIDs=$formdata["dest_users$frmID"];
	}	 


/******************************************************************************************/

	
	 if($frm->validate_data_ajx($formdata,$dateIDs,$frm_date,$insertID="",$formselect) ){
/*******************************************************************************************/
		 
		if($appointsIDs=$frm->save_appoint($formdata)){
			if($managersIDs=$frm->save_manager($formdata)){
				if($catIDs=$frm->save_category($formdata)){
					if($catTypeIDs=$frm->save_managerType($formdata)){
/*********************************************************************************************/
/*********************************************************************************************/
if($forum_decID=$frm->update_forum1($formdata,$formselect,$appointsIDs,$managersIDs)) {
						
	if(array_item($formdata,"dest_users$frmID"))$frm->conn_user_forum_test($forum_decID,$usersIDs,$dateIDs,$date_usr,$formdata);
								
		 if($frm->conn_cat_forum($forum_decID,$catIDs,$formdata)){
											 
						
								//if($frm->conn_type_manager($managersIDs,$catTypeIDs,$formdata)){
									//$frm->link();
									$id=$formdata['forum_decision'];

								//	$frm->print_forum_entry_form1($id);//($formdata['insertID']);//($formdata['forum_decID']);
								//	$frm->message_update($formdata,$forum_decID);
/***********************************************************************************************/
									if(!$formdata['forum_decision']  ){
										$formdata['forum_decision']=$forum_decID;
										unset($formdata['newforum']);
									}
							        if($formdata['forum_decision'] && $formdata['newforum'] ){
										$formdata['forum_decision']=$forum_decID;
										unset($formdata['newforum']);
									} 

							         if($formdata['insert_forum']  ){
									    unset($formdata['insert_forum']);
									}
									
/***********************************************************************************************/									
									
									if(!$formdata['category'] ){
										$formdata['category']=$catIDs;
										unset($formdata['new_category']);
									}
							         if($formdata['category'] && $formdata['new_category'] ){
										$formdata['category']=$catIDs;
										unset($formdata['new_category']);
									}
									 if($formdata['insert_category']  ){
									    unset($formdata['insert_category']);
									  }
/***********************************************************************************************/									
									
									if(!$formdata['appoint_forum'] ){
										$formdata['appoint_forum']=$appointsIDs;
										unset($formdata['new_appoint']);
									}
						        	if($formdata['appoint_forum'] && $formdata['new_appoint'] ){
										$formdata['appoint_forum']=$appointsIDs;
										unset($formdata['new_appoint']);
									}
							        if($formdata['insert_appoint']  ){
									    unset($formdata['insert_appoint']);
									  }
									
									
/***********************************************************************************************/									
									
									if(!$formdata['manager_forum']  ){
										$formdata['manager_forum']=$managersIDs;
										unset($formdata['new_manager']);
									}
                                    if($formdata['manager_forum'] && $formdata['new_manager'] ){
							  			$formdata['manager_forum']=$managersIDs;
										unset($formdata['new_manager']);
									}
							        if($formdata['insert_manager']  ){
									    unset($formdata['insert_manager']);
									  }
									
									
/***********************************************************************************************/									
									
									
									if(!$formdata['managerType']){
										$formdata['managerType']=$catTypeIDs;
										unset($formdata['new_type']);
									}
							        if($formdata['managerType'] && $formdata['new_type'] ){
										$formdata['managerType']=$catTypeIDs;
										unset($formdata['new_type']);
									}
							        if($formdata['insert_managerType']  ){
									    unset($formdata['insert_managerType']);
									  }
/***********************************************************************************************/
							if($formdata['multi_day']  ){
							    unset($formdata['multi_day']);
							}
							if($formdata['multi_month']  ){
							   unset($formdata['multi_month']);
							}
							if($formdata['multi_year']  ){
								unset($formdata['multi_year']);
							 }	  
							 
							 if($dateIDs){
								unset($dateIDs);
							 }	  
/***********************************************************************************************/									  
									return $formdata;
								 
							}
						}
					}
				}
			}
		}
	 }
	return false;
}

/*********************************************************************************************************************/
function validate($formdata){
	global $db;

	$frm=new forum_dec();
	//$frm->link();
	//$frm->setFormdata($formdata);

		
	// try to validate and save date
	$db->execute("START TRANSACTION");
	/*****************************************************************************************/
//	if(array_item($formdata,'dest_users')){
//		 
//	 $usersIDs=$formdata['dest_users'];
//	 $frm->config_date($formdata);
//
//
//	 $dateIDs=$frm->build_date ($formdata) ;
//	 $dateIDs=$dateIDs[full_date];
//		 
//		 
//	 $date_usr =$frm->build_date_single_usr($formdata) ;
//	 $date_usr =$date_usr[full_date_usr];
//
//	 $forum_date=$frm->build_date1($formdata);
//
//	  
//	  
//	 $date_frm =$forum_date['full_date'];
//
//	 
//
//	}
/***********************************************************************/
$dates = getdate();
  $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
  $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);
    
  $today= $frm->build_date5($dates); 
  $formdata['today']=$today['full_date'];
  //$date_usr[full_date_usr];
	
    
	$frm->config_date($formdata);
	
	$dateIDs=$frm->build_date($formdata) ;
	$dateIDs=$dateIDs['full_date'];
	
	$frm_date=$formdata['forum_date'];
	$date_usr = $formdata['today'];

/***************************************************************************************************/
	if(array_item($formdata,'dest_users')){
		// $usersIDs=$frm->save_user($formdata);
		$usersIDs=$formdata['dest_users'];
	
	}	
/*************************************************************************/      
if($frm->validate_data($formdata,$dateIDs,$date_frm)){
	/*******************************************************************************************/
//		if ($formdata['newforum'] && $formdata['newforum']!='none'
//		&& $formdata['forum_decision'] && $formdata['forum_decision']!='none' ){
//			unset($formdata['forum_decision']);
//			unset($formdata['forum_decID']);
//		}
//
//		if ($formdata['newforum'] && $formdata['newforum']!='none'
//		&& array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
//			unset($formdata['forum_decID']);
//		}
//
//		/*****************************************************************************************/
//		if ($formdata['new_appoint'] && $formdata['new_appoint']!='none'
//		&& $formdata['appoint_forum'] && $formdata['appoint_forum']!='none' ){
//			unset($formdata['appoint_forum']);
//
//		}
//		/*********************************************************************************************/
//		if ($formdata['new_manager'] && $formdata['new_manager']!='none'
//		&& $formdata['manager_forum'] && $formdata['manager_forum']!='none' ){
//			unset($formdata['manager_forum']);
//
//		}
//		/*********************************************************************************************/
//
//		if ($formdata['new_category'] && $formdata['new_category']!='none'
//		&& $formdata['category'] && $formdata['category']!='none' ){
//			unset($formdata['category']);
//
//		}
//		/*********************************************************************************************/
//		if ($formdata['new_type'] && $formdata['new_type']!='none'
//		&& $formdata['managerType'] && $formdata['managerType']!='none' ){
//			unset($formdata['managerType']);
//			 
//		}
//		/*********************************************************************************************/
		if($appointsIDs=$frm->save_appoint($formdata)){
			if($managersIDs=$frm->save_manager($formdata)){
				if($catIDs=$frm->save_category($formdata)){
					if($catTypeIDs=$frm->save_managerType($formdata)){
						/*********************************************************************************************/
						/*********************************************************************************************/
						$frm->link();
						//$frm->print_forum_entry_form1($_SESSION['forum_decID']);
						if ($forum_decID=$frm->add_forum($formdata,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,
						$dateIDs,$date_usr,$frm_date,$usersIDs)) {

							//$forum_decID=$formdata['forum_decID'];
								
							$db->execute("COMMIT");
								
							return true;
						}
					}
				}
			}
		}
		 
	}else{
		$db->execute("ROLLBACK");
		$formdata = FALSE;
		return false;
	}

}

/************************************************************************************************/
function delete_forum($deleteID){
	$frm=new forum_dec();
	$frm->del_forum($deleteID);
	$frm->print_forum_paging();
			 
			show_list($formdata);
}
/************************************************************************************************/
function insert_forum($insertID,$submitbutton,$subcategories){
	$frm=new forum_dec();
	$frm->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
	$insertID=$_GET['insertID'];
	$forum_decID=$_GET['forum_decID'];
	if(is_numeric($forum_decID)){
		$formdata=$frm->read_forum_data($forum_decID);
	}else{
		//$frm->add_forum($formdata,$userIDs,$catIDs,$dateIDs);
		$formdata['insertID']=$insertID  ;

		$formdata['year_date']=  $_SESSION['year_date'];
		$formdata['month_date']= $_SESSION['month_date'];
		$formdata['day_date']=   $_SESSION['day_date'];
	 $dates = getdate();
	 $formdata['year_date']=$dates['year'];
	 $formdata['month_date']=$dates['mon'];
	 $formdata['day_date']=$dates['mday'];
	}
	$frm->print_forum_entry_form1($insertID);
	 build_form_ajx5($formdata);
	 
	$frm->link();
}


/************************************************************************************************/
function  show_list($formdata=""){
	$frm=new forum_dec();
	// $frm->link();
	 build_form_ajx5($formdata);
	$frm->link();
//	$response = array('type'=>'', 'message'=>'');
//	$response['type'] = 'success';
//	$response['message'] = 'Thank-You for submitting the form!';
//    echo json_encode($response);
//    
// 	exit;
}
/****************************************************************************/
function read_forum($editID){
	global $db;
	$frm=new forum_dec();

	if($_REQUEST['editID']){
		if(($editID =$frm->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
			$formdata =$frm->read_forum_data($editID);
		}
	}else{
		if(($editID =$frm->array_item($_REQUEST, 'forum_decID')) && is_numeric($editID)){
			$formdata =$frm->read_forum_data($editID);
		}
	}
	if($formdata['src_users']){
		$stuff = $formdata['src_users'];
		$sql="SELECT  userID,full_name FROM users where full_name in($stuff) ORDER BY userID";
		$rows=$db->queryObjectArray($sql);
	  
		foreach($rows as $row)
		$dst[$row->userID]=$row->full_name;

		$formdata['dest_users']=$dst;
	}

/*******************************************************************************************/   
$i=0;
$num=$editID ;	
if($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
foreach($formdata['dest_users'] as $key=>$val){
if(is_numeric($key)){	
$sql="select HireDate  from rel_user_forum where userID=$key and forum_decID=$editID ";
if($rows1=$db->queryObjectArray($sql)){
	
	$rows1[0]->HireDate=substr($rows1[0]->HireDate,0,10);
	
	list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->HireDate);
    if(strlen($year_date)==4 ){
    $rows1[0]->HireDate="$day_date-$month_date-$year_date";
    }elseif(strlen($day_date)==4){
     $rows1[0]->HireDate="$year_date-$month_date-$day_date"; 
    } 
     
    
    $member_date="member_date$i"  ;
    $formdata[$member_date]=$rows1[0]->HireDate;         
}	
	$i++;
    }
	
  }

}
/********************************************************************************************/
	
	//$frm->link();
	$frm->print_forum_entry_form1($formdata['forum_decID']);
	$forum_decID=$formdata['forum_decID'];
	$frm->message_update($formdata,$forum_decID);
	$formdata['forum_decision']=$forum_decID;
	 build_form_ajx5($formdata);

	$frm->link();
	return  TRUE;


}

/******************************************************************************/

function read_forum2($editID){
	global $db;
	$frm=new forum_dec();

	if(is_numeric($editID)){
		$formselect =$frm->read_forum_data2($editID);
		$dest_users=$formselect['dest_users'];
		$dest_users=explode(";",$dest_users);
		$formdata['dest_users']=$dest_users;
	}

	return  $dest_users;
}

/******************************************************************************/
function read_befor_link($formdata){
	global $db;
	$dec=new forum();
	//if(array_item($formdata, "btnLink"))
	$dec->link();
	$dec->print_form2($formdata['forum_decID'] );



	return true;
}

/******************************************************************************/
function read_link($formdata){
	global $db;
	$frm=new forum_dec();
	$formdata=$frm->read_forum_data3($formdata['forum_decID'],$formdata['insertID']);

	//$dec->conn_Parent_second($formdata);
	$frm->link();
	//$frm->print_forum_entry_form3  ($formdata['parentforum_decID1'] );
	//$frm->print_forum_entry_form3  ($formdata['forum_decID'] );


	return $formdata;

}


/************************************************************************************************/

function update_forum1($updateID){
	$frm=new forum_dec();
	$frm->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
	$frm->link();
	$frm->update_forum_general();

	$frm->link();
}

/******************************************************************************/

/***********************************************************************/
function  delete_dec_form ($formdata){
	$dec=new forum_dec();
	//$formdata = array_item($_POST, "form");
	// what to do?
	if(array_item($formdata, "btnClear"))
	// clear form
	$formdata = FALSE;

	elseif(array_item($formdata, "btnDelete")) {
		// ask, if really delete
		if($dec->build_delete_form($formdata))
		$showform=FALSE; }

		return true;
}
/***********************************************************************/
function  real_del($formdata){
	$frm=new forum_dec();
	global $db;
	// if(array_item($formdata, "btnReallyDelete")) {
	// delete forum
	if(array_item($formdata,'forum_decID')){
		$formdata=$frm->read_forum_data($formdata['forum_decID']);
		$db->execute("START TRANSACTION");
		if($frm->delete_forum($formdata))
		$db->execute("COMMIT");
		else
		$db->execute("ROLLBACK");
		$formdata = FALSE;}
		return $formdata;
}
/***********************************************************************/
function link1(){
	$frm=new forum_dec();
	$frm->print_form();
    
	return true;
}
/****************************************************************************/

function update_to_parent($forum_decID ,$insertID){
	$frm=new forum_dec;
	$frm->update_parent($insertID,$forum_decID);
}
/***************************************************************************/
function delete_user_forum($usrID,$frmID){
	$frm=new forum_dec;
	$frm->del_usr_frm($usrID,$frmID);
	return true;
}

html_footer();

?>