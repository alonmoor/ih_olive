<?php
require_once ("../config/application.php");
require_once ("../lib/model/forum_class.php");
require_once ("../lib/model/DBobject3.php");
$showform=TRUE;

 
html_header();
$forum_decID = array_item($_REQUEST, 'id');
is_logged();


/*******************************************************************************/

if( trim($_POST['form']["newforum"]!="none") && trim($_POST['form']["newforum"]!=null)
&&  $_POST['form']["forum_decision"]!="none" && $_POST['form']["forum_decision"]!=null ){
	$name=$_POST['form']["newforum"];
	$name=$db->sql_string($name);
	$sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
	if($db->querySingleItem($sql)>0) {
		show_error_msg( "כבר קיימ פורום בשם הזה");
		UNSET($_POST['form']['newforum']);
		return FALSE;
	}else{
		unset($_POST['form']['forum_decision']);
		$_REQUEST['mode']=='save' ;
	}

}




if( ($_POST['form']['forum_decision'] && $_POST['form']['forum_decision']!='none')
     && !($_POST['form']['newforum'] && !$_POST['form']['newforum']!='none') 
     && ($_REQUEST['mode']=='save')   ){
	  $_POST['mode']="update";
	$_REQUEST['mode']="update";
}

/**********************************************************************************/
if(array_item($_POST,'form') && is_numeric($_POST['form']['forum_decision'])
&& $_REQUEST['mode']=='insert'  ){
	$_SESSION['forum_decision']=$_POST['formsession_start();']['forum_decision'];

}
if($_POST['form']['btnLink1'] ) {
	$_POST['mode']="list";
	$_REQUEST['mode']="list";
}

 


switch ($_REQUEST['mode'] ) {
	case "insert":
		if(is_numeric($_SESSION['forum_decID']) ){

			update_to_parent($_SESSION['forum_decID'],$_GET['insertID']);
			unset($_SESSION['forum_decID']);
		}else {
			insert_forum($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
		}

		break;

		/******************************************/
		
	case  "link":
		//		if (isset($_REQUEST['form'])){
		//			read_befor_link($_POST['form']);
		//		}else{
		//			$formdata['forum_decID']=$_GET['forum_decID'];
		//			$formdata['insertID']=$_GET['insertID'];
		//			read_link($formdata);
		//		}
		$formdata=$_POST;
		read_befor_link($formdata);
		if (isset($_REQUEST['form']['btnLink1'])){
			//show_edit_dec($_GET['decID'], $_REQUEST['mode']);
			require_once 'forum_category.php';
		}
			
		break;

		/******************************************/
	case  "read_data":
		$tmp=$_GET['editID'] ? $_GET['editID'] :$_GET['forum_decID'];

		$formdata =read_forum($tmp) ;
		break;

		/******************************************/

	case "update":
		if($_GET['updateID']) {
			update_Forum1($_GET['updateID']);
		}else{
			global $db;
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
					$sql="SELECT  userID FROM users where full_name in($stuff) ORDER BY userID";
					$rows=$db->queryObjectArray($sql);
					$dest_users="";
				 foreach($rows as $row){
				 	$dest_users[]=$row->userID;//=$row->full_name;
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
			if($_POST['form']['adduser_Forum'] ){
				$formdata['dest_users']=$_POST['form']['adduser_Forum'];
				unset($formdata['adduser_Forum']);
			}
				
			/****************************************************************************************/
			$db->execute("START TRANSACTION");
			if(!$formdata=update_forum($formdata)){
				$db->execute("ROLLBACK");
				if(is_array($_POST['form']['forum_decision']) || is_array($_POST['form']['category'])
				|| is_array($_POST['form']['appoint_forum'])  || is_array($_POST['form']['manager_forum'])
				||  is_array($_POST['form']['managerType']) ){
					$formdata['forum_decision']=$_POST['form'][forum_decision][0] ;
					$formdata['appoint_forum']=$_POST[form][appoint_forum][0] ;
					$formdata['appoint_date']=$_POST[form][appoint_date] ;
					$formdata['manager_forum']=$_POST['form'][manager_forum][0] ;
					$formdata['managerType']=$_POST['form'][managerType][0] ;
					$formdata['manager_date']=$_POST['form'][manager_date] ;

					$formdata['forum_status']=$_POST['forum_status']  ;
					$formdata['category']=$_POST['form']['category'][0]  ;
					$formdata['type']=$_POST['type']  ;
					$formdata['forum_date']=$_POST['forum_date'];
					$formdata['year_date_forum']=$_POST['form']['year_date'];
					$formdata['month_date_forum']=$_POST['form']['month_date'];
					$formdata['day_date_forum']=$_POST['form']['day_date'];
					 
					 
					show_list($formdata);
				}
				return;
			}elseif(!$formdata['dynamic_6'] && !(array_item($formdata,dynamic_6) )){
				$formdata['category']=$formdata['category'][0];
				$formdata['forum_decision']=$formdata['forum_decision'][0];
				$formdata['managerType']=$formdata['managerType'][0];
				if($formdata['forum_decision']&& $formdata['newforum'])
				$formdata['forum_decision']=" ";
				$db->execute("COMMIT");
				show_list($formdata);
					
			}else{show_list($_POST['form']);}
		}
		break;

		/******************************************/

	case "save":
		global $db;
        	

		 
			

			if($_POST['arr_dest_forumsType'][0]== 'none')
			unset($_POST['arr_dest_forumsType'][0] );

			if($_POST['arr_dest_appoints'][0]== 'none')
			unset($_POST['arr_dest_appoints'][0] ); 
			
			if($_POST['arr_dest_managers'][0]== 'none')
			unset($_POST['arr_dest_managers'][0] );
			
			if($_POST['arr_dest_managersType'][0]== 'none')
			unset($_POST['arr_dest_managersType'][0] );
			
			
			
			if($_POST['form']['dest_forumsType'][0]== 'none')
			unset($_POST['form']['dest_forumsType'][0] );
			
		    if($_POST['form']['dest_appoints'][0]== 'none')
			unset($_POST['form']['dest_appoints'][0] );

			if($_POST['form']['dest_managers'][0]== 'none')
			unset($_POST['form']['dest_managers'][0] );

			if($_POST['form']['dest_managersType'][0]== 'none')
			unset($_POST['form']['dest_managersType'][0] );

		
			
			if($_POST['form']['new_forum'][0]== 'none')
			unset($_POST['form']['new_forum'][0] );
			
			if($_POST['form']['new_forumType'][0]== 'none')
			unset($_POST['form']['new_forumsType'][0] );
			
		    if($_POST['form']['new_appoint'][0]== 'none')
			unset($_POST['form']['new_appoint'][0] );

			if($_POST['form']['new_manager'][0]== 'none')
			unset($_POST['form']['new_manager'][0] );

			if($_POST['form']['new_managerType'][0]== 'none')
			unset($_POST['form']['new_managerType'][0] );
/**********************************************************************************/			
		    $formdata= $_POST['form'];
            
			if(array_item ($_POST,'arr_dest_forumsType') )
			 $formdata['dest_forumsType']=$_POST['arr_dest_forumsType'];
			
			 if(array_item ($_POST,'arr_dest_appoints') ) 
			$formdata['dest_appoints']=$_POST['arr_dest_appoints'];
			
			if(array_item ($_POST,'arr_dest_managers') )
			$formdata['dest_managers']=$_POST['arr_dest_managers'];
			
			if(array_item ($_POST,'arr_dest_managersType') )
			$formdata['dest_managersType']=$_POST['arr_dest_managersType'];
/**************************************************************************************/			
			
			if(!validate($formdata)){
            
			echo "נכשל בשמירה!!!!!";

			$formdata=$_POST['form'];

			if(array_item ($_POST,'arr_dest_forumsType') )
			 $formdata['dest_forumsType']=$_POST['arr_dest_forumsType'];
			
			 if(array_item ($_POST,'arr_dest_appoints') ) 
			$formdata['dest_appoints']=$_POST['arr_dest_appoints'];
			
			if(array_item ($_POST,'arr_dest_managers') )
			$formdata['dest_managers']=$_POST['arr_dest_managers'];
			
			if(array_item ($_POST,'arr_dest_managersType') )
			$formdata['dest_managersType']=$_POST['arr_dest_managersType'];

			
			
//			$formdata['forum_decision']=$_POST['form']['forum_decision'][0];
//			$formdata['category']=$_POST['form']['category'][0];
//			$formdata['appoint_forum']=$_POST['form']['appoint_forum'][0];
//			$formdata['manager_forum']=$_POST['form']['manager_forum'][0];
//			$formdata['managerType']=$_POST['form']['managerType'][0];
//			$formdata['managerType']=$_POST['form']['managerType'][0];
			show_list($formdata);
				
				
		}else{
			//show_list($_POST['form']);
		}
		break;


		/******************************************/
	case "realy_delete":
			
		real_del($_POST['form']);
		$showform=FALSE;


		break;


		/******************************************/
	case "clear":
			

		link1();
		break;
	  
		/******************************************/


	case "delete":
		if (($_GET['deleteID'])){
			delete_forum($_GET['deleteID']);//subcategories
		}else{
			delete_forum($_POST['form']);
		}

		break;

		/******************************************/

	default:
	case "list":
		global $db;
		$frm =new forum_dec();

			if($showform && !($_POST['form']['btnLink1'])) {
				
			$formdata = array_item($_POST, "form");
				
			if(array_item($formdata, "forum_decID"))
			echo "<h1>ערוך פורום</h1>";
			else
			echo "<h1>הזן נתונים לפורום  </h1>";

		 $frm->print_forum_paging() ;
		 show_list($formdata);

		}else{

			$frm->print_form6();
		}
}


/************************************************************************************************/
function delete_forum($deleteID){
	$frm=new forum_dec();
	$frm->del_forum($deleteID);
	$frm->print_form6();
}
/************************************************************************************************/
function insert_forum($insertID,$submitbutton,$subcategories){
	$frm=new forum_dec();
	$frm->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
	$insertID=$_GET['insertID'];
	//$frm->add_forum($formdata,$catIDs,$dateIDs);
	$formdata['insertID']=$insertID  ;
	$frm->link();

	build_form2($formdata);


	$frm->link();
}


/************************************************************************************************/
function  show_list($formdata){
	$frm=new forum_dec();
	//$frm->link();
	build_form2($formdata);
	 
	$frm->link();
}
/****************************************************************************/
function read_forum($editID){
	global $db;
	$frm=new forum_dec();
	$_REQUEST['editID']=$_REQUEST['editID']?$_REQUEST['editID']:$_REQUEST['forum_decID'];
	if(($editID = $frm->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
		$formdata =$frm->read_forum_data($editID);
		
		if($formdata['src_users']){
			$stuff = $formdata['src_users'];
			$sql="SELECT  userID,full_name FROM users where full_name in($stuff) ORDER BY userID";
			$rows=$db->queryObjectArray($sql);
			 
			foreach($rows as $row)
			$dst[$row->userID]=$row->full_name;

			$formdata['dest_users']=$dst;
		}

	}
	$frm->link();
	$frm->print_forum_entry_form1($formdata['forum_decID']);
	$forum_decID=$formdata['forum_decID'];
	$frm->message_update($formdata,$forum_decID);
	$formdata['forum_decision']=$forum_decID;
	$_SESSION['forum_decID']=$forum_decID;
	build_form2($formdata);

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
//function read_befor_link($formdata){
//	global $db;
//	$dec=new forum();
//	//if(array_item($formdata, "btnLink"))
//	$dec->link();
//	$dec->print_form2($formdata['forum_decID'] );
//
//
//
//	return true;
//}

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

function update_Forum1($updateID){
	$frm=new forum_dec();
	$frm->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
	$frm->link();
	$frm->update_forum_general();

	$frm->link();
}

/******************************************************************************/
function update_forum($formdata){
	global $db;
	$frm=new forum_dec($formdata['forum_decision'][0],$formdata);
	$formdata['dynamic_6']=1;
		$dates = getdate();
   $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
   $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);
    
   $today= $frm->build_date5($dates); 
   $formdata['today']=$today['full_date'];
  //$date_usr[full_date_usr];
	$dateIDs=$frm->build_date($formdata) ;
	$dateIDs=$dateIDs['full_date'];
    
	$frm->config_date($formdata,$dateIDs);
	$frm_date=$formdata['forum_date'];
	$date_usr = $formdata['today'];
	
	
	if($frm->validate_forums($formdata)){
		 

		/********************************************************************************************/
		/*******************************************************************************************/
		if ($formdata['newforum'] && $formdata['newforum']!='none'
		&& $formdata['forum_decision'][0] && $formdata['forum_decision'][0]!='none' ){
			unset($formdata['forum_decision']);
			unset($formdata['forum_decID']);
		}

		if ($formdata['newforum'] && $formdata['newforum']!='none'
		&& array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
			unset($formdata['forum_decID']);
		}

		/*****************************************************************************************/
		if ($formdata['new_appoint'] && $formdata['new_appoint']!='none'
		&& $formdata['appoint_forum'][0] && $formdata['appoint_forum'][0]!='none' ){
			unset($formdata['appoint_forum']);

		}
		/*********************************************************************************************/
		if ($formdata['new_manager'] && $formdata['new_manager']!='none'
		&& $formdata['manager_forum'][0] && $formdata['manager_forum'][0]!='none' ){
			unset($formdata['manager_forum']);

		}
		/*********************************************************************************************/

		if ($formdata['new_category'] && $formdata['new_category']!='none'
		&& $formdata['category'][0] && $formdata['category'][0]!='none' ){
			unset($formdata['category']);

		}
		/*********************************************************************************************/
		if ($formdata['new_type'] && $formdata['new_type']!='none'
		&& $formdata['managerType'][0] && $formdata['managerType'][0]!='none' ){
			unset($formdata['managerType']);
			 
		}
		/*********************************************************************************************/
		/*****************************************************************************/
		 
		if($appointsIDs=$frm->save_appoint1($formdata)){
			if($managersIDs=$frm->save_manager1($formdata)){
				if($catIDs=$frm->save_category1($formdata)){
					if($catTypeIDs=$frm->save_managerType1($formdata)){
						 
						$frm->config_date($formdata);

	   	 $dateIDs=$frm->build_date($formdata) ;
	   	 // $dateIDs=$dateIDs[full_date];
	   	 $formdata['forum_date']=$dateIDs;

	   	 $date_appointIDs=$frm->build_date_appoint($formdata) ;
	   	 // $date_appointIDs=$date_appointIDs['full_date'];
	   	 $formdata['appoint_date']=$date_appointIDs;

	   	 $date_managerIDs=$frm->build_date_manager($formdata) ;
	   	 // $date_managerIDs=$date_managerIDs['full_date'];
	   	 $formdata['manager_date']=$date_managerIDs;

	   	 	
	   	 if($forum_decID=$frm->add_forum ($formdata,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,$dateIDs,$date_appointIDs,$date_managerIDs)) {

	   	 	//				$formdata['manager_forum']=	$managersIDs[0];
	   	 	//				$formdata['appoint_forum']=	$appointsIDs[0];
	   	 		
	   	 		
	   	 		
	   	 	// $frm->conn_manager_appoint($managersIDs,$appointsIDs,$formdata);
	   	 	//					if($frm->conn_cat_forum($forum_decID,$catIDs,$formdata)){
	   	 	//						if($frm->conn_type_manager($managersIDs,$catTypeIDs,$formdata)){
	   	 	//						$frm->link();
	   	 	//						$frm->print_forum_entry_form1($formdata['forum_decID']);
	   	 	//						$frm->message_update($formdata,$forum_decID);

	   	 	return $formdata;

	   	 	// }
	   	 }
					}
				}
			}
		}
	}
	return false;
}


/*********************************************************************************/

function validate($formdata){

	global $db;


	$frm=new forum_dec();
	 
	$formdata['dynamic_6']=1;
	
	$dates = getdate();
  
    
  $today= $frm->build_date5($dates); 
  $formdata['today']=$today['full_date'];
   
	
	
	$frm->config_date($formdata);
	$dateIDs=$frm->build_date($formdata) ;
	$dateIDs=$dateIDs['full_date'];
    
	$appointdateIDs=$frm->build_date_appoint($formdata);
	$appointdateIDs=$appointdateIDs['full_date'];
	
	
	$managerdateIDs=$frm->build_date_manager($formdata);
	$managerdateIDs=$managerdateIDs['full_date'];
	
	$date_usr = $formdata['today'];
	
	if($frm->validate_forums($formdata ,$dateIDs,$appointdateIDs,$managerdateIDs) ){






		/********************************************************************************************/
		/*******************************************************************************************/
		if ($formdata['newforum'] && $formdata['newforum']!='none'
		&& $formdata['forum_decision'][0] && $formdata['forum_decision'][0]!='none' ){
			unset($formdata['forum_decision']);
			unset($formdata['forum_decID']);
		}

		if ($formdata['newforum'] && $formdata['newforum']!='none'
		&& array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
			unset($formdata['forum_decID']);
		}

		/*****************************************************************************************/
		if ($formdata['new_appoint'] && $formdata['new_appoint']!='none'
		&& $formdata['appoint_forum'][0] && $formdata['appoint_forum'][0]!='none' ){
			unset($formdata['appoint_forum']);

		}
		/*********************************************************************************************/
		if ($formdata['new_manager'] && $formdata['new_manager']!='none'
		&& $formdata['manager_forum'][0] && $formdata['manager_forum'][0]!='none' ){
			unset($formdata['manager_forum']);

		}
		/*********************************************************************************************/

		if ($formdata['new_category'] && $formdata['new_category']!='none'
		&& $formdata['category'][0] && $formdata['category'][0]!='none' ){
			unset($formdata['category']);

		}
		/*********************************************************************************************/
		if ($formdata['new_type'] && $formdata['new_type']!='none'
		&& $formdata['managerType'][0] && $formdata['managerType'][0]!='none' ){
			unset($formdata['managerType']);
			 
		}
		/*********************************************************************************************/
		/*****************************************************************************/
		if($appointsIDs =$frm->save_appoint1($formdata)){
			if($managersIDs =$frm->save_manager1($formdata)){
				if($catIDs =$frm->save_category1($formdata)){
					if($catTypeIDs =$frm->save_managerType1($formdata)){
						 
						/**************************************************************************************************/
							
//						if($formdata['multi_year'][0]
//						&& $formdata['multi_month'][0]
//						&& $formdata['multi_day'][0] ){
//							unset ($_SESSION['multi_year']) ;
//							unset ($_SESSION['multi_month']) ;
//							unset ($_SESSION['multi_day'])  ;
//							 
//							$i=0;
//							foreach($formdata['multi_month'] as $dt){
//								$dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//								$formdata['multi_month'][$i]=$dt;
//								$i++;
//							}
//							$i=0;
//							foreach($formdata['multi_day'] as $dt){
//								$dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//								$formdata['multi_day'][$i]=$dt;
//								$i++;
//							}
//
//							$_SESSION['multi_year']=$formdata['multi_year'];
//							$_SESSION['multi_month']=$formdata['multi_month'];
//							$_SESSION['multi_day'] =$formdata['multi_day'];
//						}else{
//							 
//							$formdata['month_date']= str_pad($formdata['month_date'], 2, "0", STR_PAD_LEFT);
//							$formdata['day_date'][$i]=str_pad($formdata['day_date'], 2, "0", STR_PAD_LEFT);
//						}
//
//						if($dateIDs=$frm->build_date($formdata)) {

							if ($frm->add_forum($formdata,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,$dateIDs,$appointdateIDs,$managerdateIDs)) {
								$forum_decID=$formdata['forum_decID'];
								$frm->link();
				    
								return true;
							//}
						}
					}
		  }
			}
		}
	}else{
		 
		$formdata = FALSE;
		return false;
	}


}

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
	$frm->print_forum_paging();
	build_form2($formdata);

	return true;
}
/************************************************************************/
function read_befor_link($formdata){
	global $db;
	$frm=new forum_dec();
	//if(array_item($formdata, "btnLink"))
	$frm->link();
	//$dec->print_form_dec($formdata['decID'] );
	$forum_decID=$formdata['forum_decID'];
	require_once 'forum_category.php';
	//  $dec->redirect(‪ROOT_DIR.'/admin/find3.php'‬);

	//	      $dec->print_decision_entry_form1($decID);
	//	      $dec->print_form2($formdata['decID'] );
	//require_once 'dec_edit.php';
	//print_form();
	//$dec->print_form();

	 
	 
	return  true ;
}
/*********************************************************************/
function update_to_parent($forum_decID ,$insertID){
	$frm=new forum_dec;
	$frm->update_parent($insertID,$forum_decID);
}
/*********************************************************************************************/
html_footer();

?>