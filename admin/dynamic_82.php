<?php
require_once ("../config/application.php");
//session_start();
//require_once ("../lib/model/forum_class.php");
require_once (LIB_DIR.'/model/forum_class.php');
require_once ("../lib/model/DBobject3.php");
$showform=TRUE;



//if(!isAjax() ){
html_header();

 
if( array_item($_REQUEST, 'id'))
$forum_decID = array_item($_REQUEST, 'id');
else
$forum_decID = array_item($_REQUEST, 'forum_decID');
is_logged();
$page          = array_item($_REQUEST, 'page');
if(!$page || $page<1 || !is_numeric($page))
$page=1;
elseif($page>100)
$page=100; 	

/*******************************************************************************/
if(array_item($_POST,'form') && is_numeric($_POST['form']['forum_decID'])
&& $_REQUEST['mode']=='insert'  ){
	$_SESSION['forum_decID']=$_POST['form']['forum_decID'];

}

/*******************************************************************************/

if( trim($_POST['form']["newforum"]!="none") && trim($_POST['form']["newforum"]!=null)
&&  $_POST['form']["forum_decision"]!="none" && $_POST['form']["forum_decision"]!=null ){
	$name=$db->sql_string($_POST['form']["newforum"]);
	$sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
	if($db->querySingleItem($sql)>0) {
		show_error_msg("כבר קיים פורום בשם הזה");
		UNSET($_POST['form']['newforum']);
		return FALSE;
	}else{
		unset($_POST['form']['forum_decision']);
		$_REQUEST['mode']=='save' ;
	}
	 
}

 
 
 
if($_POST['form']['forum_decision'] && $_POST['form']['forum_decision']!='none'
&& $_REQUEST['mode']=='save' ){
	$_POST['mode']="update";
	$_REQUEST['mode']="update";
}

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
		if($_REQUEST['editID'])
		$formdata =read_forum($_GET['editID']);
		else
		$formdata =read_forum($_GET['forum_decID']);
		break;
		/***************************************************************************************************/
		/***************************************************************************************************/
	case "update":
		if($_GET['updateID']) {
			update_dec($_GET['updateID']);
		}else{
			if($_POST['form']){
				foreach($_POST['form']  as $key=>$val){
					if ($val=='none' || $val== "" )
					unset ($_POST['form'][$key]);
						
				}
					
			}
			global $db;
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
				$formdata['dest_users']=$_POST['arr_dest_users'];
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
				$formdata['dest_users']=$destNames;
			}
			/*****************************************************************************************/

			$db->execute("START TRANSACTION");
			if(!$formdata=update_forum($formdata)){
				$db->execute("ROLLBACK");
				echo "נכשל בעדכון!!!!!";
				$formdata=$_POST['form'];
				$formdata['forum_decision']=$_POST['form']['forum_decision'];
				$formdata['category']=$_POST['form']['category'];
				$formdata['appoint_forum']=$_POST['form']['appoint_forum'];
				$formdata['manager_forum']=$_POST['form']['manager_forum'];
				$formdata['managerType']=$_POST['form']['managerType'];

				$formdata['forum_date']=substr($_POST['form']['forum_date'],1,10);
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
				if(strlen($year_date>3) )
				$formdata['forum_date']="$day_date-$month_date-$year_date";
					
					
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
			$formdata['forum_decision']=$_POST['form']['forum_decision'];
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
			$formdata[forum_date]= substr($formdata[forum_date],1,10 );
			list($year_date,$month_date, $day_date) = explode('-',$formdata['forum_date']);
			$formdata['forum_date']="$day_date-$month_date-$year_date";
				
			list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$formdata['appoint_date']);
			if (strlen($year_date_appoint) > 3){
				$formdata['appoint_date']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
			}
				
			list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$formdata['manager_date']);
			$year_date_manager1="'$year_date_manager'";
			if (strlen($year_date_manager) > 3){
				$formdata['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
			}
			/***************************************************************************************************/
			//show_list($formdata);


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

			$frm->print_form();
			show_list($formdata);

		}else{
			$forum_decID=$_POST['form']['forum_decID'];
			if(is_numeric($forum_decID) )
			$frm->print_forum_entry_form1($forum_decID);
			$frm->print_form($forum_decID);
				
		}
}

/**********************************************************************************************/
function update_forum($formdata){
	global $db;
	$frm=new forum_dec();//($formdata);


	$formselect=$frm->read_forum_data($formdata['forum_decision']);
	if($formselect['src_users'] && $formselect['src_users']!=null){

		$formdata['src_users']=$formselect['src_users'];
		$formdata['date_src_users']= $formselect['date_src_users'];
		$formdata['date_src_users']= explode(',',$formdata['date_src_users']);
	}else{
		unset($formdata[src_users]);
	}
	/******************************************************************************************/
	$formdata['forum_decID']= $formdata['forum_decision'];

	$formdata['insertID']=$formselect['parentForumID'];
	$formdata['forum_decName']=$formselect['forum_decName'];
	/*****************************************************************************************/

	$frm->config_date($formdata);
	/***************************************************************************************************/
	if(array_item($formdata,'dest_users')){
		// $usersIDs=$frm->save_user($formdata);
		$usersIDs=$formdata['dest_users'];
		 
		$dateIDs=$frm->build_date($formdata) ;
		$dateIDs=$dateIDs[full_date];//forum_date
		 
			
		$date_usr =$frm->build_date_single_usr($formdata) ;
		$date_usr =$date_usr[full_date_usr];//today

		$forum_date=$frm->build_date1($formdata);
		$date_frm = substr($forum_date['full_date'],1,10);//forum_date

	}else{
		$formdata['month_date']  = str_pad($formdata['month_date'] , 2, "0", STR_PAD_LEFT);
		$formdata['day_date']  = str_pad($formdata['day_date'] , 2, "0", STR_PAD_LEFT);
		$forum_date=$frm->build_date1($formdata);
		$date_frm = substr($forum_date['full_date'],1,10);
		// $forum_date=$forum_date['full_date'];
		//$formdata['forum_date']=$date_frm;//$forum_date;
	}

	/******************************************************************************************/
	if($frm->validate_data($formdata,$dateIDs,$date_frm) ){
		/*******************************************************************************************/
		 
		if($appointsIDs=$frm->save_appoint($formdata)){
			if($managersIDs=$frm->save_manager($formdata)){
				if($catIDs=$frm->save_category($formdata)){
					if($catTypeIDs=$frm->save_managerType($formdata)){
						/*********************************************************************************************/
						/*********************************************************************************************/
						//	   	if ($frm->add_forum($formdata,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,
						//				     $dateIDs,$date_usr,$date_frm,$usersIDs)) {

				
						if($forum_decID=$frm->update_forum1($formdata,$formselect,$appointsIDs,$managersIDs)) {
						
						if(array_item($formdata,'dest_users'))
							$frm->conn_user_forum($forum_decID,$usersIDs,$dateIDs,$date_usr,$formdata);
								

							if($frm->conn_cat_forum($forum_decID,$catIDs,$formdata)){
								//if($frm->conn_type_manager($managersIDs,$catTypeIDs,$formdata)){
									$frm->link();
									$id=$formdata['forum_decision'];
									$frm->print_forum_entry_form1($id);//($formdata['insertID']);//($formdata['forum_decID']);
									$frm->message_update($formdata,$forum_decID);

									/***********************************************************************************************/
									if(!$formdata['forum_decision']  ){
										$formdata['forum_decision']=$forum_decID;
										unset($formdata['newforum']);
									}


									if(!$formdata['category'] ){
										$formdata['category']=$catIDs;
										unset($formdata['new_category']);
									}


									if(!$formdata['appoint_forum'] ){
										$formdata['appoint_forum']=$appointsIDs;
										unset($formdata['new_appoint']);
									}


									if(!$formdata['manager_forum']  ){
										$formdata['manager_forum']=$managersIDs;
										unset($formdata['new_manager']);
									}

									if(!$formdata['managerType']){
										$formdata['managerType']=$catTypeIDs;
										unset($formdata['new_type']);
									}

									return $formdata;
								//}
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
	if(array_item($formdata,'dest_users')){
		// $usersIDs=$frm->save_user($formdata);
	 $usersIDs=$formdata['dest_users'];
	 $frm->config_date($formdata);


	 $dateIDs=$frm->build_date ($formdata) ;
	 $dateIDs=$dateIDs[full_date];
		 
		 
	 $date_usr =$frm->build_date_single_usr($formdata) ;
	 $date_usr =$date_usr[full_date_usr];

	 $forum_date=$frm->build_date1($formdata);

	  
	  
	 $date_frm =$forum_date['full_date'];


	}
if($frm->validate_data($formdata,$dateIDs,$date_frm)){
	/*******************************************************************************************/
		if ($formdata['newforum'] && $formdata['newforum']!='none'
		&& $formdata['forum_decision'] && $formdata['forum_decision']!='none' ){
			unset($formdata['forum_decision']);
			unset($formdata['forum_decID']);
		}

		if ($formdata['newforum'] && $formdata['newforum']!='none'
		&& array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
			unset($formdata['forum_decID']);
		}

		/*****************************************************************************************/
		if ($formdata['new_appoint'] && $formdata['new_appoint']!='none'
		&& $formdata['appoint_forum'] && $formdata['appoint_forum']!='none' ){
			unset($formdata['appoint_forum']);

		}
		/*********************************************************************************************/
		if ($formdata['new_manager'] && $formdata['new_manager']!='none'
		&& $formdata['manager_forum'] && $formdata['manager_forum']!='none' ){
			unset($formdata['manager_forum']);

		}
		/*********************************************************************************************/

		if ($formdata['new_category'] && $formdata['new_category']!='none'
		&& $formdata['category'] && $formdata['category']!='none' ){
			unset($formdata['category']);

		}
		/*********************************************************************************************/
		if ($formdata['new_type'] && $formdata['new_type']!='none'
		&& $formdata['managerType'] && $formdata['managerType']!='none' ){
			unset($formdata['managerType']);
			 
		}
		/*********************************************************************************************/
		if($appointsIDs=$frm->save_appoint($formdata)){
			if($managersIDs=$frm->save_manager($formdata)){
				if($catIDs=$frm->save_category($formdata)){
					if($catTypeIDs=$frm->save_managerType($formdata)){
						/*********************************************************************************************/
						/*********************************************************************************************/
						$frm->link();
						//$frm->print_forum_entry_form1($_SESSION['forum_decID']);
						if ($forum_decID=$frm->add_forum($formdata,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,
						$dateIDs,$date_usr,$date_frm,$usersIDs)) {

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
	$frm->print_form();
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
	$frm->build_form($formdata);
	 
	$frm->link();
}


/************************************************************************************************/
function  show_list($formdata){
	$frm=new forum_dec();
	 $frm->link();
	$frm->build_form($formdata);
	$frm->link();
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


	$frm->link();
	$frm->print_forum_entry_form1($formdata['forum_decID']);
	$forum_decID=$formdata['forum_decID'];
	$frm->message_update($formdata,$forum_decID);
	$formdata['forum_decision']=$forum_decID;
	$frm->build_form($formdata);

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
	$d->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
	$d->link();
	$d->update_forum_general();

	$d->link();
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