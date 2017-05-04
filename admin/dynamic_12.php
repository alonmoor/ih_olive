<?php
require_once ("../config/application.php");
require_once (LIB_DIR.'/model/forum_class.php');
require_once ("../lib/model/DBobject3.php");
 require_once(LIB_DIR.'/model/class.handler.php');
$showform=TRUE;
global $db;
 $_POST['form']['dynamic_ajx']=FALSE;
 if(  !(isAjax())){
  html_header();
 }
if( array_item($_POST, 'forum_decision') && count($_POST)==1 && !$_GET ){
$_REQUEST['mode']="read_data";
}
if( array_key_exists('read_users',$_GET)  &&   is_numeric($_GET['read_users'])    ){
	$_POST['mode']="read_users";
	$_REQUEST['mode']="read_users";
}
if( array_key_exists('read_decisions',$_GET)  &&   is_numeric($_GET['read_decisions'])    ){
	$_POST['mode']="read_decisions";
	$_REQUEST['mode']="read_decisions";
}
if( array_key_exists('read_data2',$_GET)  &&  ($_GET['read_data2'])==0  && (is_numeric($_GET['editID']))  ){
	$_POST['mode']="read_data2";
	$_REQUEST['mode']="read_data2";
}
/*****************************************************************************/
if(  array_item($_POST,'entry') && !empty($_POST['entry'])  ){
$entry=explode(',',$_POST['entry']);
$insertID =$entry[0];
 if($insertID=='none' || $insertID==0)
 return;
//|$insertID='11';
$forum_decID =$entry[1];
/*****************************************************************************/
if($insertID==$forum_decID){
	?>
	<script>
	$('#forum_decision_tree').append($('<p ID="bgchange"   ><b style="color:blue;">אי אפשר לקשר פורום לעצמו או לבניו!!!!!</b></p>\n' ));
    turn_red();
	</script>
	<?php  
 exit;
}
		$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);
		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$parents[$row->forum_decID] = $row->parentForumID;
			$parents_b[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }
			// build list of all parents for $insertID
			$forum_ID = $insertID;
			while($parents[$forum_ID]!=NULL) {
				$forum_ID = $parents[$forum_ID];
				$parentList[] = $forum_ID; 
			}
            $forumID = $insertID;
			while($parents_b[$forumID]!=NULL && $parents_b[$forumID]!=$forum_decID) {
				$forumID = $parents_b[$forumID];
				$parentList_b[] = $forumID; 
			}
		if($subcats[$forum_decID]){
			if(   in_array($insertID, $subcats[$forum_decID]) 
			||    in_array($parents[$insertID],$subcats[$forum_decID] ) 
			||    in_array($forumID,$subcats[$forum_decID] )
			||    $parents[$insertID]== $forum_decID){
			 ?>
			 <script>
	         $('#forum_decision_tree').append($('<p ID="bgchange"   ><b style="color:blue;">אי אפשר לקשר פורום לעצמו או לבניו!!!!!</b></p>\n' ));
             turn_red();
	        </script>
			 <?php
			 exit;
			}
		}elseif( $insertID==$forum_decID){
			 ?>
			  <script>
	         $('#forum_decision_tree').append($('<p ID="bgchange"   ><b style="color:blue;">אי אפשר לקשר פורום לעצמו או לבניו!!!!!</b></p>\n' ));
             turn_red();
	        </script>
			 <?php
			 exit;
		}
//----------------------------------------------
$frm=new forum_dec();
$frm->update_parent_b($insertID, $forum_decID);
//$frm->print_forum_entry_form_c($forum_decID);
}
//----------------------------------------------
if($_POST['forum_decision']!=$_POST['forum_decID'] && $_POST['forum_decision']!='none' && $_POST['forum_decID']){
	$_POST['forum_decID']=	$_POST['forum_decision'];
	$_POST['form']['forum_decID']=	$_POST['forum_decision'];
}
//----------------------------------------------
if( array_item($_REQUEST, 'id'))
$forum_decID = array_item($_REQUEST, 'id');
else
$forum_decID = array_item($_REQUEST, 'forum_decID');
//----------------------------------------------
if(array_item($_POST,'form') && is_numeric($_POST['form']['forum_decID'])
&& $_REQUEST['mode']=='insert'  ){
	$_SESSION['forum_decID']=$_POST['form']['forum_decID'];
}
//----------------------------------------------

if( ($_POST['form']['forum_decision'] && $_POST['form']['forum_decision']!='none')
     && !($_POST['form']['newforum'] && !$_POST['form']['newforum']!='none') 
     && ($_REQUEST['mode']=='save')   ){
	  $_POST['mode']="update";
	$_REQUEST['mode']="update";
}
//----------------------------------------------
if( ($_POST['forum_decision'] && $_POST['forum_decision']!='none')
     &&  ( is_array($_POST['form']) && is_numeric($_POST['forum_decision'] ) )
     && ($_REQUEST['mode']=='save') 
     && !$_POST['form']['newforum']){
	  $_POST['mode']="update";
	$_REQUEST['mode']="update";
}

//----------------------------------------------
if( ($_POST['forum_decision'] && $_POST['forum_decision']!='none')
     &&  ( is_array($_POST['form']) && is_numeric($_POST['forum_decision'] ) )
     && ($_REQUEST['mode']=='save') 
     && $_POST['form']['newforum']){
	  $_POST['mode']="save";
	$_REQUEST['mode']="save";
}


/**********************************************************************************/
if( ($_POST['form']['forum_decision'] && $_POST['form']['forum_decision']!='none')
     &&  ( is_array($_POST['form']) && is_numeric($_POST['form']['forum_decision'] ) )
     && ($_REQUEST['mode']=='update') 
     && $_POST['form']['newforum']){
	  $_POST['mode']="save";
	$_REQUEST['mode']="save";
}

/***********************************************************************************/

if( ($_POST['forum_decision'] && $_POST['forum_decision']!='none')
     &&  ( is_array($_POST['form']) && is_numeric($_POST['forum_decision'] ) )
     && ($_REQUEST['mode']=='update') 
     && $_POST['form']['newforum']){
        
     /*	if($_POST['insert_forum']&& is_numeric($_POST['insert_forum']) ){
     	unset($_POST['form']['insertID']);
     	}*/
     if($_POST['forum_decID']){
     	unset($_POST['forum_decID']);
     }		
     unset($_POST['forum_decision']);
     unset($_POST['form']['forum_decID']);
     $_POST['form']['dynamic_ajx']=1;	
	  $_POST['mode']="save";
	$_REQUEST['mode']="save";
}


/**********************************************************************************/
if( ($_POST['forum_decision'] && $_POST['forum_decision']=='none')
     &&  ( is_array($_POST['form']) )
     &&  $_POST['forum_decID']==0
     && ($_REQUEST['mode']=='save') 
     && $_POST['form']['newforum']){
        
     /*	if($_POST['insert_forum']&& is_numeric($_POST['insert_forum']) ){
     	unset($_POST['form']['insertID']);
     	}*/
     if($_POST['forum_decID'] || $_POST['forum_decID']==0){
     	unset($_POST['forum_decID']);
     }	
     if($_POST['form']['forum_decision']=='none'){
     	unset($_POST['form']['forum_decision']);
     }			
     unset($_POST['forum_decision']);
     unset($_POST['form']['forum_decID']);
     $_POST['form']['dynamic_ajx']=1;	
	  $_POST['mode']="save";
	$_REQUEST['mode']="save";
}





   if(isset ($_POST['forum_decision']))  {
 	$frm_decID=$_POST['forum_decision'];
 	if(isset ($_POST["submitbutton3_$frm_decID"]))  {
 		$_POST['mode']='take_data';
 		unset($_REQUEST['mode']);
 		$_REQUEST['mode']=$_POST['mode'];
 		
 	}
 }   


/**********************************************************************************/
//if($_POST['form']['btnLink1'] ) {
//	$_POST['mode']="list";
//	$_REQUEST['mode']="list";
//}
 

/****************************************/
switch ($_REQUEST['mode'] ) {
/***************************************************************************************************/
/***************************************************************************************************/
	case "read_decisions":
		if(is_numeric($_GET['read_decisions']) ){
		
          get_dec($_GET['read_decisions']);
		} 
		break;
/***************************************************************************************************/
case "read_users":
		if(is_numeric($_GET['read_users']) ){
		
          get_users($_GET['read_users']);
		} 
		break;
		
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
		if($_REQUEST['editID']){
		$formdata =read_forum($_GET['editID']);
		}else{
		$formdata =read_forum($_GET['forum_decID']);
		}
		break;
		
		case  "read_data2":
		if( array_item($_POST, 'forum_decision') && count($_POST)==1 && !$_GET){
		$_REQUEST['editID']= array_item($_POST, 'forum_decision');
		}
		if($_REQUEST['editID']){
		$formdata =read_forum_ajx($_GET['editID']);
		}else{
		$formdata =read_forum_ajx($_GET['forum_decID']);
		}
		break;
/***************************************************************************************************/
/***************************************************************************************************/
	case "update":
		if($_GET['updateID']) {
			update_forum1($_GET['updateID']);
			 
		}else{
//------------------------------------------------------------------------------------			
			if($_POST['form']){
				foreach($_POST['form']  as $key=>$val){
					if ($val=='none' || $val== "" )
					unset ($_POST['form'][$key]);
						
				}
					
			}
//------------------------------------------------------------------------------------			
			global $db;
			$frmID= $_POST['form']['forum_decision']?$_POST['form']['forum_decision']:$_POST['form'] ; 
				 
/*********************************************************************************/
			if($_POST['form']["dest_users$frmID"][0]== 'none')
			unset($_POST['form']["dest_users$frmID"][0] );
/********************************DEST_USERS*************************************************/
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
/********************************DEST_FORUMSTYPE*************************************************/
			if($_POST['form']['dest_forumsType'][0]== 'none')
			unset($_POST['form']['dest_forumsType'][0] );

			if(count($_POST['form']['dest_forumsType'])==0  )
			unset($_POST['form']['dest_forumsType'] );

			if($_POST['form']['src_forumsType'][0]== 'none')
			unset($_POST['form']['src_forumsType'][0] );

			if(count($_POST['form']['src_forumsType'])==0  )
			unset($_POST['form']['src_forumsType'] );


			if($_POST['arr_dest_forumsType'][0]== 'none')
			unset($_POST['arr_dest_forumsType'][0] );

			if(count($_POST['arr_dest_forumsType'])==0  )
			unset($_POST['arr_dest_forumsType'] );	
/********************************DEST_MANAGERSTYPE*************************************************/
			if($_POST['form']['dest_managersType'][0]== 'none')
			unset($_POST['form']['dest_managersType'][0] );

			if(count($_POST['form']['dest_managersType'])==0  )
			unset($_POST['form']['dest_managersType'] );

			if($_POST['form']['src_managersType'][0]== 'none')
			unset($_POST['form']['src_managersType'][0] );

			if(count($_POST['form']['src_managersType'])==0  )
			unset($_POST['form']['src_managersType'] );


			if($_POST['arr_dest_managersType'][0]== 'none')
			unset($_POST['arr_dest_managersType'][0] );

			if(count($_POST['arr_dest_managersType'])==0  )
			unset($_POST['arr_dest_managersType'] );						 
/*********************************************************************************/
			 
/*********************************************************************************/
			if(!$_POST['form']['dest_users'] && $_POST['arr_dest_users']){
				$formdata=$_POST['form'];
				 
			$staff=implode(',',$_POST['arr_dest_users']);	
			$sql="SELECT userID,full_name FROM users WHERE userID in($staff)";

			if($rows=$db->queryObjectArray($sql)){
				foreach($rows as $row){
				 
				 $formdata["dest_users"][$row->userID]=$row->full_name;		
				}
				unset($formdata['arr_dest_users']);
			  }	
				
			}elseif($_POST['form']['dest_users'] && is_numeric($_POST['form']['dest_users'][0])){
					
				$formdata=$_POST['form'];
/**********************************************************************************/
			}elseif( !is_numeric($_POST['form']['dest_users'][0])
			&& ($_POST['form']['dest_users'])
			&&  ($_POST['form']['dest_users'][1])
			&&  (is_numeric($_POST['form']['dest_users'][1]))  ){
				 

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
				
					$sql="SELECT  userID,full_name FROM users where full_name in($stuff)";
					$rows=$db->queryObjectArray($sql);
					$dest_users="";
				 foreach($rows as $row){
				 	$dest_users[]=$row->userID; 
				 	 
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
			}
/*******************************************************************************************************/			

			
/**********************************************************************************************************/			
			else{
				$formdata=$_POST['form'];
			}
/********************************************************************************************/
if($_POST['form']['dest_users'] && !($_POST['arr_dest_users']) ){			
	$formdata['dest_users2']  = $formdata['dest_users'] ;

}	
			if($formdata['dest_users'][0] && is_numeric($formdata['dest_users'][0]) && is_array($formdata['dest_users']) ){
				foreach($formdata['dest_users'] as $key=>$val){
					
		        $sql="SELECT full_name FROM users where userID =$val";
				if($rows=$db->queryObjectArray($sql))
					
					$destNames[$val]=$rows[0]->full_name;
				
				}
				$formdata['dest_users']=$destNames;
			}elseif($formdata['dest_users'] && is_numeric($formdata['dest_users'])  ){
				$destID=$formdata['dest_users'] ;
			
				$sql="SELECT  userID,full_name FROM users where userID in($destID)";
				$rows=$db->queryObjectArray($sql);
				foreach($rows as $row){
					$destNames[$row->userID]=$row->full_name;
				}
				
				$frmID= $_POST['form']['forum_decision'] ; 
				$formdata['dest_users']=$formdata["dest_users$frmID"];
				$formdata['dest_users']=$destNames;
				
			}
			
			
			
			
		if(!array_item($formdata,'forum_decision') && array_item($_POST,'forum_decision')  && $_POST['forum_decision']!=null){
 				$formdata['forum_decision']=array_item($_POST,'forum_decision');
 			}
 			
 			
 		if(!$_POST['form']['dest_forumsType'] && $_POST['arr_dest_forumsType']){
				 
				$formdata['dest_forumsType']=$_POST['arr_dest_forumsType'];
			}

		if($_POST['form']['dest_forumsType'] && !$_POST['arr_dest_forumsType']){
				 
				$formdata['dest_forumsType']=$_POST['form']['dest_forumsType'];
			}	
//		if(!$_POST['form']['dest_forumsType'] && !$_POST['arr_dest_forumsType'] && $_POST['form']['src_forumsType']){
//				 
//				$formdata['dest_forumsType']=$_POST['form']['src_forumsType'];
//			}		
/*************************************MANAGERSTYPE****************************************************/
		if(!$_POST['form']['dest_managersType'] && $_POST['arr_dest_managersType']){
				 
				$formdata['dest_managersType']=$_POST['arr_dest_managersType'];
			}

		if($_POST['form']['dest_managersType'] && !$_POST['arr_dest_managersType']){
				 
				$formdata['dest_managersType']=$_POST['form']['dest_managersType'];
			}	
//		if(!$_POST['form']['dest_managersType'] && !$_POST['arr_dest_managersType'] && $_POST['form']['src_managersType']){
//				 
//				$formdata['dest_managersType']=$_POST['form']['src_managersType'];
//			}		
			
/******************************************************************************************/
if($_POST['insert_forum'] && (is_numeric($_POST['insert_forum']) ) ){
	
$formdata['insert_forum']=$_POST['insert_forum'];
}else{
$frmID=$formdata['forum_decision'];	
$sql="select parentForumID from forum_dec where forum_decID=$frmID";
if($rows=$db->queryObjectArray($sql) ){
	 
	$formdata['insert_forum']=$rows[0]->parentForumID;
  }	
	
}							
/*****************************************************************************************/

			$db->execute("START TRANSACTION");
/******************************************************/			
			if(!$formdata=update_forum($formdata)){
/*****************************************************/				
				$db->execute("ROLLBACK");
			
				
				$formdata=$_POST['form'];
/**********************************************************************************************************/			
if($formdata['src_managersType'] &&  is_array($formdata['src_managersType']) && (is_numeric ($formdata['src_managersType'][0])) ){
unset($formdata['src_managersType']);
}

if($formdata['src_forumsType'] &&  is_array($formdata['src_forumsType']) && (is_numeric($formdata['src_forumsType'][0])) ){
	unset($formdata['src_forumsType']);
}

if($formdata['src_users'] &&  is_array($formdata['src_users']) && (is_numeric($formdata['src_users'][0])) ){
	unset($formdata['src_users']);
}		
/**********************************************************************************************************/			
							
				
				$formdata['forum_decision']=$_POST['form']['forum_decision'];
				$formdata['category']=$_POST['form']['category'];
				$formdata['appoint_forum']=$_POST['form']['appoint_forum'];
				$formdata['manager_forum']=$_POST['form']['manager_forum'];
				$formdata['managerType']=$_POST['form']['managerType'];
                //$formdata['appoint_date1']=$_POST['form']['appoint_date1'];
				//$formdata['manager_date']=$_POST['form']['manager_date'];  
				
				
				
			if($_POST['form']['appoint_date1'] ){
				$formdata['appoint_date1']= $_POST['form']['appoint_date1']  ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['appoint_date1']);
				if(strlen($year_date)>3 ){
				$formdata['appoint_date1']="$day_date-$month_date-$year_date";	
				 }
				}
				
				if($_POST['form']['manager_date']){
				$formdata['manager_date']= $_POST['form']['manager_date'] ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['manager_date']);
				if(strlen($year_date)>3){
				$formdata['manager_date']="$day_date-$month_date-$year_date";
				 } 
				}	
				
				
				if($_POST['form']['forum_date']){
				$formdata['forum_date']=$_POST['form']['forum_date'];
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
				if(strlen($year_date)>3 ){
				$formdata['forum_date']="$day_date-$month_date-$year_date";
				  } 	
				}
				
				
				
			if($_POST['arr_dest_forums']){
			  $formdata['dest_forums']=$_POST['arr_dest_forumsType'];	
			}
			
			if($_POST['arr_dest_managersType']){
			  $formdata['dest_managersType']=$_POST['arr_dest_managersType'];	
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
				$formdata['dynamic_10']=1;
				show_list($formdata);


				return;

			}else{

/*************************************TO_AJAX**********************************************/		   

/**********************************GET_DECISION************************************************/				
$forum_decID=$formdata['forum_decID'];	
	$sql="SELECT d.decID,d.decName 
	         FROM decisions d 
	       left join rel_forum_dec rf on d.decID=rf.decID
	       WHERE rf.forum_decID=$forum_decID";
	      // left join forum_dec f on f.forum_decID
				

		    if($rows  = $db->queryObjectArray($sql) ){
               		    	
		     $formdata["decision"]=$rows; 
	}			
/******************************************************************************************/				
$i=0; 	
		if($formdata['dest_users'] && is_array($formdata['dest_users']) && is_array($dest_users)){
			
		foreach($dest_users as $key=>$val){
		if(is_numeric($val)){	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 

     
		     $formdata["dest_user"]=$results; 
		     
		     
/********************************************************************************************************/
$i=0;
foreach($formdata['dest_users'] as $key=>$val){
$sql="select active  from rel_user_forum where userID=$key and forum_decID=$forum_decID ";
if($rows=$db->queryObjectArray($sql)){
	
	$formdata['active'][$key]=$rows[0]->active;
	$i++;
  }
 } 
		   		          	
/**********************************************************************************************************************/	     
		     
		     
		     
 }elseif($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
			 
		foreach($formdata['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select userID,full_name  from users where userID=$key";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 
		     $formdata["dest_user"]=$results; 
/********************************************************************************************************/
$i=0;
foreach($formdata['dest_users'] as $key=>$val){
$sql="select active  from rel_user_forum where userID=$key and forum_decID=$forum_decID ";
if($rows=$db->queryObjectArray($sql)){
	
	$formdata['active'][$key]=$rows[0]->active;
	$i++;
  }
 } 
		   		          	
/**********************************************************************************************************/	     
		     
		     
 }

/**********************************************************************************************************************/
//for check the length
	 $i=0; 	
		if($formdata['src_usersID'] && is_array($formdata['src_usersID'])   ){
			 
		foreach($formdata['src_usersID'] as $key=>$val){
	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		       
        }
		 

     }
		     $formdata["src_user"]=$results1; 
 }else{
 	$formdata["src_user"]=$formdata["dest_user"];
 }
/***********************************************************************/		   		          			 
/***********************FORUMSTYPE**********************************************/
  $i=0; 	
		if($formdata['dest_forumsType'] && is_array($formdata['dest_forumsType'])  ){
			
		foreach($formdata['dest_forumsType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select catID,catName  from categories1 where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$formdata['dest_forumsType']=$results_cat_frm;
}
/*************************************MANAGER_TYPE*****************************************************************/

  $i=0; 	
		if($formdata['dest_managersType'] && is_array($formdata['dest_managersType'])  ){
			
		foreach($formdata['dest_managersType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$formdata['dest_managersType']=$results_cat_mgr;
}
/******************************************************************************************************/


$manageID=$formdata['manager_forum'];
$sql="select managerName from managers where managerID=$manageID";
if($rows=$db->queryObjectArray($sql)){
	$formdata['managerName']=$rows[0]->managerName;
}		 
/**********************************************************************/ 		   		          	
$appID=$formdata['appoint_forum'];
$sql="select appointName from appoint_forum where appointID=$appID";
if($rows=$db->queryObjectArray($sql)){
	$formdata['appointName']=$rows[0]->appointName;
}		 
/**********************************************************************/ 
unset($_POST['form']['multi_year']);
unset($_POST['form']['multi_month']);
unset($_POST['form']['multi_day']);
unset($formdata['multi_year']);
unset($formdata['multi_month']);
unset($formdata['multi_day']);
$formdata['multi_year'][0]='none';
 $formdata['multi_month'][0]='none';
 $formdata['multi_day'][0]='none';

/******************************************************/
$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
		if( 	$rows = $db->queryObjectArray($sql)){
				
			foreach($rows as $row) {
				$subcatsftype[$row->parentCatID][] = $row->catID;
				$catNamesftype[$row->catID] = $row->catName; }

				$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
if($rows && is_array($rows))
 $formdata['frmType']=$rows; 
}
 
 
/*****************************************************/ 
	$db->execute("COMMIT");
	
 
    $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
     echo json_encode($formdata);
 	  exit;
	
			 	
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
/*****************************CLEANING SECTION*************************************************/
/********************************DEST_FORUMSTYPE*************************************************/
			if($_POST['form']['dest_forumsType'][0]== 'none')
			unset($_POST['form']['dest_forumsType'][0] );

			if(count($_POST['form']['dest_forumsType'])==0  )
			unset($_POST['form']['dest_forumsType'] );

			if($_POST['form']['src_forumsType'][0]== 'none')
			unset($_POST['form']['src_forumsType'][0] );

			if(count($_POST['form']['src_forumsType'])==0  )
			unset($_POST['form']['src_forumsType'] );


			if($_POST['arr_dest_forumsType'][0]== 'none')
			unset($_POST['arr_dest_forumsType'][0] );

			if(count($_POST['arr_dest_forumsType'])==0  )
			unset($_POST['arr_dest_forumsType'] );	
/********************************DEST_MANAGERSTYPE*************************************************/
			if($_POST['form']['dest_managersType'][0]== 'none')
			unset($_POST['form']['dest_managersType'][0] );

			if(count($_POST['form']['dest_managersType'])==0  )
			unset($_POST['form']['dest_managersType'] );

			if($_POST['form']['src_managersType'][0]== 'none')
			unset($_POST['form']['src_managersType'][0] );

			if(count($_POST['form']['src_managersType'])==0  )
			unset($_POST['form']['src_managersType'] );


			if($_POST['arr_dest_managersType'][0]== 'none')
			unset($_POST['arr_dest_managersType'][0] );

			if(count($_POST['arr_dest_managersType'])==0  )
			unset($_POST['arr_dest_managersType'] );						 
/*********************************************************************************/	
	
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
			if($array_num && $dest_users && is_array($array_num) && is_array ($dest_users) ){ 
			$dest=array_merge($array_num,$dest_users);
			$formdata['dest_users'] = $dest;
			}
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
if($_POST['arr_dest_forumsType'] && (is_array($_POST['arr_dest_forumsType']) ) ){
	
	$formdata['dest_forumsType']=$_POST['arr_dest_forumsType'];
}

if($_POST['arr_dest_managersType'] && (is_array($_POST['arr_dest_managersType']) ) ){
	
	$formdata['dest_managersType']=$_POST['arr_dest_managersType'];
}		
/***************************************************************************************/		
if($_POST['insert_forum'] && (is_numeric($_POST['insert_forum']) ) ){
	
	$formdata['insert_forum']=$_POST['insert_forum'];
}elseif($formdata['forum_decision']){
$frmID=$formdata['forum_decision'];	
$sql="select parentForumID from forum_dec where forum_decID=$frmID";
if($rows=$db->queryObjectArray($sql) ){
	 
	$formdata['insert_forum']=$rows[0]->parentForumID;
  }	
	
}	

//$formdata['dynamic_ajx']=1;

		
		$db->execute("START TRANSACTION");
/***********************************************/		
		if(!validate($formdata )){             /*
/***********************************************/          
	 
			 show_error_msg(" נכשל בשמירה!!!!! ");
		 		  
			$formdata=$_POST['form'];

/**********************************************************************************************************/			
if($formdata['src_managersType'] &&  is_array($formdata['src_managersType']) && (is_numeric ($formdata['src_managersType'][0])) ){
unset($formdata['src_managersType']);
}

if($formdata['src_forumsType'] &&  is_array($formdata['src_forumsType']) && (is_numeric($formdata['src_forumsType'][0])) ){
	unset($formdata['src_forumsType']);
}

if($formdata['src_users'] &&  is_array($formdata['src_users']) && (is_numeric($formdata['src_users'][0])) ){
	unset($formdata['src_users']);
}		
/**********************************************************************************************************/			
			
				
				
		if(!$_POST['form']['dest_users'] && $_POST['arr_dest_users']){
			$formdata['dest_users']=$_POST['arr_dest_users'];
		}
				
		if(!$_POST['form']['dest_forumsType'] && $_POST['arr_dest_forumsType']){
				$formdata['dest_forumsType']=$_POST['arr_dest_forumsType'];
			}
			
		if(!$_POST['form']['dest_managers'] && $_POST['arr_dest_managersType']){
				$formdata['dest_managersType']=$_POST['arr_dest_managersType'];
			}
			
			
			
/*********************************************************************************************/			
			
			
			
			if($formdata['src_users'] && $_POST['arr_dest_users'] ){
					
				$i=0;
				foreach ($_POST['arr_dest_users'] as $dst){
					if($dst=='none')
					unset ($_POST['arr_dest_users'][$i]);
					$i++;

				}
					
				$arr=implode(',',$_POST['arr_dest_users'] );
					
				$sql="select userID,full_name from users where userID in($arr)";
				if($rows=$db->queryObjectArray($sql) ){
				foreach ($rows as $row){
					$dest[$row->userID]=$row->full_name;
				}
					
				$formdata['dest_users']=$dest;//$_POST['arr_dest_users'];
				}	
					
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
				if($rows=$db->queryObjectArray($sql)){
				 unset($dest);	
				foreach ($rows as $row){
					$dest[$row->userID]=$row->full_name;
				}
				unset($formdata['dest_users']);
				//$formdata['dest_users']=$dest;
			  }
			}
			
/***************************************************************************************************/			
			if($formdata['forum_decision']&& $formdata['newforum'])
			unset( $formdata['forum_decision']);
			unset($formdata['src_users']);	
/*****************************************************************************************************/				
		//	$formdata['forum_status']=($_POST['form']['forum_status']);
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
				$formdata['forum_demo_last8']=1;
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
             $frm->print_forum_paging();
			show_list($formdata);
		//link1();
		break;
/**********************************************************************************************/
/********************************************************************************************/
	case "delete":
		if (($_GET['deleteID'])){
			$formdata['forum_demo_last8']=1;
			delete_forum($_GET['deleteID'],$formdata);//subcategories
		}else{
			$formdata['forum_demo_last8']=1;
			delete_forum($_POST['form']['forum_decision'],$formdata);
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
 
case "take_data":
		 
			if($_POST['form']){
				foreach($_POST['form']  as $key=>$val){
					if ($val=='none' || $val== "" )
					unset ($_POST['form'][$key]);
						
				}
					
			}
			global $db;
			$frmID= $_POST['form']['forum_decision']?$_POST['form']['forum_decision']:$_POST['form'] ; 
				 
/*********************************************************************************/
			if($_POST['form']["dest_users$frmID"][0]== 'none')
			unset($_POST['form']["dest_users$frmID"][0] );
/********************************DEST_USERS*************************************************/
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
/********************************DEST_FORUMSTYPE*************************************************/
			if($_POST['form']['dest_forumsType'][0]== 'none')
			unset($_POST['form']['dest_forumsType'][0] );

			if(count($_POST['form']['dest_forumsType'])==0  )
			unset($_POST['form']['dest_forumsType'] );

			if($_POST['form']['src_forumsType'][0]== 'none')
			unset($_POST['form']['src_forumsType'][0] );

			if(count($_POST['form']['src_forumsType'])==0  )
			unset($_POST['form']['src_forumsType'] );


			if($_POST['arr_dest_forumsType'][0]== 'none')
			unset($_POST['arr_dest_forumsType'][0] );

			if(count($_POST['arr_dest_forumsType'])==0  )
			unset($_POST['arr_dest_forumsType'] );	
/********************************DEST_MANAGERSTYPE*************************************************/
			if($_POST['form']['dest_managersType'][0]== 'none')
			unset($_POST['form']['dest_managersType'][0] );

			if(count($_POST['form']['dest_managersType'])==0  )
			unset($_POST['form']['dest_managersType'] );

			if($_POST['form']['src_managersType'][0]== 'none')
			unset($_POST['form']['src_managersType'][0] );

			if(count($_POST['form']['src_managersType'])==0  )
			unset($_POST['form']['src_managersType'] );


			if($_POST['arr_dest_managersType'][0]== 'none')
			unset($_POST['arr_dest_managersType'][0] );

			if(count($_POST['arr_dest_managersType'])==0  )
			unset($_POST['arr_dest_managersType'] );						 
/*********************************************************************************/
			 
/*********************************************************************************/
			if(!$_POST['form']['dest_users'] && $_POST['arr_dest_users']){
				$formdata=$_POST['form'];
				 
			$staff=implode(',',$_POST['arr_dest_users']);	
			$sql="SELECT userID,full_name FROM users WHERE userID in($staff)";

			if($rows=$db->queryObjectArray($sql)){
				foreach($rows as $row){
				 
				 $formdata["dest_users"][$row->userID]=$row->full_name;		
				}
				unset($formdata['arr_dest_users']);
			  }	
				
			}elseif($_POST['form']['dest_users'] && is_numeric($_POST['form']['dest_users'][0])){
					
				$formdata=$_POST['form'];
/**********************************************************************************/
			}elseif( !is_numeric($_POST['form']['dest_users'][0])
			&& ($_POST['form']['dest_users'])
			&&  ($_POST['form']['dest_users'][1])
			&&  (is_numeric($_POST['form']['dest_users'][1]))  ){
				 

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
				
					$sql="SELECT  userID,full_name FROM users where full_name in($stuff)";
					$rows=$db->queryObjectArray($sql);
					$dest_users="";
				 foreach($rows as $row){
				 	$dest_users[]=$row->userID; 
				 	 
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
			}
/*******************************************************************************************************/			
			else{
				$formdata=$_POST['form'];
			}
/********************************************************************************************/
			 
			if($formdata['dest_users'][0] && is_numeric($formdata['dest_users'][0]) && is_array($formdata['dest_users']) ){
				foreach($formdata['dest_users'] as $key=>$val){
					
		        $sql="SELECT full_name FROM users where userID =$val";
				if($rows=$db->queryObjectArray($sql))
					
					$destNames[$val]=$rows[0]->full_name;
				
				}
				$formdata['dest_users']=$destNames;
			}elseif($formdata['dest_users'] && is_numeric($formdata['dest_users'])  ){
				$destID=$formdata['dest_users'] ;
			
				$sql="SELECT  userID,full_name FROM users where userID in($destID)";
				$rows=$db->queryObjectArray($sql);
				foreach($rows as $row){
					$destNames[$row->userID]=$row->full_name;
				}
				
				$frmID= $_POST['form']['forum_decision'] ; 
				$formdata['dest_users']=$formdata["dest_users$frmID"];
				$formdata['dest_users']=$destNames;
				
			}
			
			
			
			
		if(!array_item($formdata,'forum_decision') && array_item($_POST,'forum_decision')  && $_POST['forum_decision']!=null){
 				$formdata['forum_decision']=array_item($_POST,'forum_decision');
 			}
 			
 			
 		if(!$_POST['form']['dest_forumsType'] && $_POST['arr_dest_forumsType']){
				 
				$formdata['dest_forumsType']=$_POST['arr_dest_forumsType'];
			}

		if($_POST['form']['dest_forumsType'] && !$_POST['arr_dest_forumsType']){
				 
				$formdata['dest_forumsType']=$_POST['form']['dest_forumsType'];
			}	
	
/*************************************MANAGERSTYPE****************************************************/
		if(!$_POST['form']['dest_managersType'] && $_POST['arr_dest_managersType']){
				 
				$formdata['dest_managersType']=$_POST['arr_dest_managersType'];
			}

		if($_POST['form']['dest_managersType'] && !$_POST['arr_dest_managersType']){
				 
				$formdata['dest_managersType']=$_POST['form']['dest_managersType'];
			}	
/******************************************************************************************/
if($_POST['insert_forum'] && (is_numeric($_POST['insert_forum']) ) ){
	
$formdata['insert_forum']=$_POST['insert_forum'];
}else{
$frmID=$formdata['forum_decision'];	
$sql="select parentForumID from forum_dec where forum_decID=$frmID";
if($rows=$db->queryObjectArray($sql) ){
	 
	$formdata['insert_forum']=$rows[0]->parentForumID;
  }	
	
}							
/*****************************************************************************************/

			$db->execute("START TRANSACTION");
/******************************************************/			
			if(!$formdata=take_forum_data($formdata)){
/*****************************************************/				
				$db->execute("ROLLBACK");
			
				
				$formdata=$_POST['form'];
/**********************************************************************************************************/			
if($formdata['src_managersType'] &&  is_array($formdata['src_managersType']) && (is_numeric ($formdata['src_managersType'][0])) ){
unset($formdata['src_managersType']);
}

if($formdata['src_forumsType'] &&  is_array($formdata['src_forumsType']) && (is_numeric($formdata['src_forumsType'][0])) ){
	unset($formdata['src_forumsType']);
}

if($formdata['src_users'] &&  is_array($formdata['src_users']) && (is_numeric($formdata['src_users'][0])) ){
	unset($formdata['src_users']);
}		
/**********************************************************************************************************/			
							
				
				$formdata['forum_decision']=$_POST['form']['forum_decision'];
				$formdata['category']=$_POST['form']['category'];
				$formdata['appoint_forum']=$_POST['form']['appoint_forum'];
				$formdata['manager_forum']=$_POST['form']['manager_forum'];
				$formdata['managerType']=$_POST['form']['managerType'];
                //$formdata['appoint_date1']=$_POST['form']['appoint_date1'];
				//$formdata['manager_date']=$_POST['form']['manager_date'];  
				
				
				
			if($_POST['form']['appoint_date1'] ){
				$formdata['appoint_date1']= $_POST['form']['appoint_date1']  ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['appoint_date1']);
				if(strlen($year_date)>3 ){
				$formdata['appoint_date1']="$day_date-$month_date-$year_date";	
				 }
				}
				
				if($_POST['form']['manager_date']){
				$formdata['manager_date']= $_POST['form']['manager_date'] ;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['manager_date']);
				if(strlen($year_date)>3){
				$formdata['manager_date']="$day_date-$month_date-$year_date";
				 } 
				}	
				
				
				if($_POST['form']['forum_date']){
				$formdata['forum_date']=$_POST['form']['forum_date'];
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
				if(strlen($year_date)>3 ){
				$formdata['forum_date']="$day_date-$month_date-$year_date";
				  } 	
				}
				
				
				
			if($_POST['arr_dest_forums']){
			  $formdata['dest_forums']=$_POST['arr_dest_forumsType'];	
			}
			
			if($_POST['arr_dest_managersType']){
			  $formdata['dest_managersType']=$_POST['arr_dest_managersType'];	
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
				$formdata['dynamic_10']=1;
				show_list($formdata);


				return;

			}
/*************************************TO_AJAX**********************************************/		   
	else{
/**********************************GET_DECISION************************************************/
if($formdata['take_data']==1){
	
$i=0;
		$frmID=$formdata['forum_decID'] ? $formdata['forum_decID']:$formdata['forum_decision'];	
		

 if($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
			 
		foreach($formdata['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select HireDate  from rel_user_forum where userID=$key and forum_decID=$frmID  ";
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
		     $formdata['member_date'][$i]=$rows1[0]->HireDate;  
		    
		    
		       
		 }	
			$i++;
			 
	    }
		
	  }
	 
	}	
	
	
	
}
		
/**********************************************************************************************/		
$forum_decID=$formdata['forum_decID'];	
	$sql="SELECT d.decID,d.decName 
	         FROM decisions d 
	       left join rel_forum_dec rf on d.decID=rf.decID
	       WHERE rf.forum_decID=$forum_decID";
				

		    if($rows  = $db->queryObjectArray($sql) ){
               		    	
		     $formdata["decision"]=$rows; 
	}			
/******************************************************************************************/				
$i=0; 	
		if($formdata['dest_users'] && is_array($formdata['dest_users']) && is_array($dest_users)){
			
		foreach($dest_users as $key=>$val){
		if(is_numeric($val)){	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 

     
		     $formdata["dest_user"]=$results; 
 }elseif($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
			 
		foreach($formdata['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select userID,full_name  from users where userID=$key";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 
		     $formdata["dest_user"]=$results; 
 }
		   		          	
/**********************************************************************************************************************/
//for check the length
	 $i=0; 	
		if($formdata['src_usersID'] && is_array($formdata['src_usersID'])   ){
			 
		foreach($formdata['src_usersID'] as $key=>$val){
	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		       
        }
		 

     }
		     $formdata["src_user"]=$results1; 
 }else{
 	$formdata["src_user"]=$formdata["dest_user"];
 }
/***********************************************************************/		   		          			 
/***********************FORUMSTYPE**********************************************/
  $i=0; 	
		if($formdata['dest_forumsType'] && is_array($formdata['dest_forumsType'])  ){
			
		foreach($formdata['dest_forumsType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select catID,catName  from categories1 where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$formdata['dest_forumsType']=$results_cat_frm;
}
/*************************************MANAGER_TYPE*****************************************************************/

  $i=0; 	
		if($formdata['dest_managersType'] && is_array($formdata['dest_managersType'])  ){
			
		foreach($formdata['dest_managersType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$formdata['dest_managersType']=$results_cat_mgr;
}
/******************************************************************************************************/


$manageID=$formdata['manager_forum'];
$sql="select managerName from managers where managerID=$manageID";
if($rows=$db->queryObjectArray($sql)){
	$formdata['managerName']=$rows[0]->managerName;
}		 
/**********************************************************************/ 		   		          	
$appID=$formdata['appoint_forum'];
$sql="select appointName from appoint_forum where appointID=$appID";
if($rows=$db->queryObjectArray($sql)){
	$formdata['appointName']=$rows[0]->appointName;
}		 
/**********************************************************************/ 
unset($_POST['form']['multi_year']);
unset($_POST['form']['multi_month']);
unset($_POST['form']['multi_day']);
unset($formdata['multi_year']);
unset($formdata['multi_month']);
unset($formdata['multi_day']);
$formdata['multi_year'][0]='none';
 $formdata['multi_month'][0]='none';
 $formdata['multi_day'][0]='none';

/******************************************************/
$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
		if( 	$rows = $db->queryObjectArray($sql)){
				
			foreach($rows as $row) {
				$subcatsftype[$row->parentCatID][] = $row->catID;
				$catNamesftype[$row->catID] = $row->catName; }

				$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);

 $formdata['frmType']=$rows; 
}
 
 
/*****************************************************/ 
	$db->execute("COMMIT");
	
 
    $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
     echo json_encode($formdata);
 	  exit;
	
			 	
}
		
		break;
/***************************************************************************************************/
		
	default:
	case "list":

		$frm =new forum_dec();



	 
		if($showform && !($_POST['form']['btnLink1'])) {
				
			$formdata = array_item($_POST, "form");
				
			if(array_item($formdata, "forum_decID"))
			echo "<h1>ערוך פורום</h1>";
			else
			echo "<h1>הזן נתונים לפורום  </h1>";

			$frm->print_forum_paging_b();
			
			show_list($formdata);

		}else{
			$forum_decID=$_POST['form']['forum_decID'];
			if(is_numeric($forum_decID) )
			$frm->print_forum_entry_form1($forum_decID);
			$frm->print_forum_paging_b($forum_decID);
				
		}
}

/***************************************GET_DEC_FOR_THE_TREE_VIEW*******************************************************/
 function   get_dec($frmID){
$frm=new forum_dec();
$frm->restore_tree($frmID);
 	
/***************************************************************************************************************************/			
}//end function get_dec       	
/*********************************************************************************************/
function get_users($frmID){
	global $db;
 $getUser_sql	=	"SELECT u.userID,u.full_name,r.HireDate FROM users u 
                     inner join rel_user_forum r  
                     on u.userID = r.userID              
                     WHERE r.forum_decID = $frmID
                     ORDER BY u.full_name ASC";

if($rows=$db->queryObjectArray($getUser_sql) ){

$formdata=Array();	
	
$i=0;
foreach($rows as $row){
	$sql="select active,userID  from rel_user_forum where userID=$row->userID and forum_decID=$frmID ";
if($rows_active=$db->queryObjectArray($sql)){
	
	$formdata['active'][$row->userID]=$rows_active[0]->active;
	
  }
  $i++;
 }
	
	

 
 
$i=0;
   
//    echo '<tr> 
//          <td  class="myformtd">';  
    echo '<table class="myformtable1" id="my_table" style="overflow:hidden;width:70%;">';
    	/***************************************************/
		foreach($rows as $row){
		/**************************************************/
        $li_id="my_li$i";
        $tr_id="my_tr$i$row->userID $row->forum_decID;";   
		$member_date="member_date$i"  ;
 
$gif_num='';   
if( $formdata["active"][$row->userID] && ($formdata["active"][$row->userID]==2) )
    $gif_num=1;
     else 
    $gif_num=0;
?>
<!-- <li class="my_li"  id="<?php echo $li_id ?>">-->
     <tr class="my_tr"  id="<?php echo $tr_id ?>">
       
       
     <td width="16"  id="my_active<?php echo $row->userID; echo $frmID;?>">
	        <a href="javascript:void(0)" onclick="edit_active(<?php echo $row->userID;?>,<?php echo $frmID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $formdata["active"][$row->userID] ;?>); return false;">
	          <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php echo $gif_num; ?>.gif" width="16" height="10" alt="" border="0" />  
	        </a>      
	 </td>
       
       
       <td>

<?php  

//echo '<li>';

     $name=$row->full_name;
	 form_label1("חבר פורום:");
	 form_text_a("member", $name ,  20, 50, 1);

if(($level)){	 
?> 
 
 <input type="button"  class="mybutton"  id="my_button_<?php echo $row->userID;?>"  value="ערוך מישתמש"  onClick="return editUser3(<?php echo $row->userID;?>,<?php echo $frmID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>);" return false; />     
<?php }elseif(!($level)){?>
 <input type="button"  class="mybutton"  id="my_button_<?php echo $row->userID;?>"  value="צפה בפרטי המישתמש"  onClick="return editUser3(<?php echo $row->userID;?>,<?php echo $frmID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>);" return false; />
<?php }?>


          <script  language="JavaScript" type="text/javascript">
           
                $(document).ready(function(){
	           	$("#<?php echo $member_date; ?>").datepicker( $.extend({}, {showOn: 'button',
		                               buttonImage: '<?php echo IMAGES_DIR ;?>/calendar.gif', buttonImageOnly: true,
		                               changeMonth: true,
				                       changeYear: true,
				                       showButtonPanel: true,
				                       buttonText: "Open date picker",
				                       dateFormat: 'yy-mm-dd',
				                       altField: '#actualDate'}, $.datepicker.regional['he'])); 
                 	});
            </script>
        <?php  

/*****************************************************************************************/	
     
    list($year_date,$month_date, $day_date) = explode('-',$formdata[$member_date]);
    if(strlen($day_date)==4 ){
    $formdata[$member_date]="$year_date-$month_date-$day_date";
    }elseif(strlen($year_date)==4){
     $formdata[$member_date]="$day_date-$month_date-$year_date";	
    }   
  
 form_label1("תאריך צרוף לפורום:");
 form_text3 ("$member_date",$row->HireDate  ,  10, 50, 1,$member_date );
 
  echo '</td>';
  echo '</tr>';
 // echo '</li>';   
   $i++; 	
 	     
	}//end foreach
//  echo '</td></tr>';//</div>';
 echo '</table>';
  }	
  return true;
}//end get_users
/************************************************************************************************/
function update_forum($formdata){
	
	global $db;
	$frm=new forum_dec();//($formdata);
     $formdata['dynamic_10']=1;

	$formselect=$frm->read_forum_data($formdata['forum_decision']);
	if($formselect['src_users'] && $formselect['src_users']!=null
	   && $formselect['src_usersID'] && $formselect['src_usersID']!=null  ){

		 		
		$formdata['src_users']= explode(',',$formselect['src_users']);
		 
		$formdata['src_usersID']= explode(',',$formselect['src_usersID']);
		 
		$formdata['src_users2']=$formdata['src_usersID']; 
				 
		$formdata['date_src_users']= explode(',',$formselect['date_users']);
	}else{
		unset($formdata[src_users]);
		unset($formdata[src_usersID]);
	}
	
/********************************************************************************************/	
$formdata['src_forumsType']= explode(',',$formselect['src_forumsType']);
		 
$formdata['src_managersType']= explode(',',$formselect['src_managersType']);	

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
	if(array_item($formdata,"dest_users")){
		 
		$usersIDs=$formdata["dest_users"];
	}	 
/******************************************************************************************/
	
	  if($frm->validate_data_ajx($formdata,$dateIDs,$frm_date,$insertID="",$formselect) ){
/*******************************************************************************************/
	$db->execute("START TRANSACTION");	 
		if($appointsIDs=$frm->save_appoint($formdata)){
			if($managersIDs=$frm->save_manager($formdata)){
					$formdata['appoint_forum']=$appointsIDs;
					$formdata['manager_forum']=$managersIDs;
				
				 if($catIDs=$frm->save_category_ajx($formdata)){
					 if($catTypeIDs=$frm->save_managerType_ajx($formdata)){
	$db->execute("COMMIT");				 	
/*********************************************************************************************/
/*********************************************************************************************/
if($forum_decID=$frm->update_forum1($formdata,$formselect,$appointsIDs,$managersIDs)) {
						
	if(array_item($formdata,'dest_users'))$frm->conn_user_forum_test($forum_decID,$usersIDs,$dateIDs,$date_usr,$formdata);
								
		 if($frm->conn_cat_forum($forum_decID,$catIDs,$formdata)){
		 	if($frm->conn_type_manager($forum_decID,$catTypeIDs,$formdata)){								 
						
									$id=$formdata['forum_decision'];
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
									 //   unset($formdata['insert_forum']);
									}
									
/***********************************************************************************************/									
									
									if(!$formdata['dest_forumsType'] ){
										$formdata['dest_forumsType']=$catIDs;
										unset($formdata['new_forumType']);
									}
							         if($formdata['dest_forumsType'] && $formdata['new_forumType'] ){
										$formdata['dest_forumsType']=$catIDs;
										unset($formdata['new_forumType']);
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
									
									
									if(!$formdata['dest_managersType']){
										$formdata['dest_managersType']=$catTypeIDs;
										unset($formdata['new_type']);
									}
							        if($formdata['dest_managersType'] && $formdata['new_type'] ){
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
 	}
	 
	return false;
}

/*********************************************************************************************************************/
function validate($formdata){
	global $db;

	$frm=new forum_dec();
    $formdata['dynamic_10']=1;	 
    $date_frm='';
    
    
	

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

		$usersIDs=$formdata['dest_users'];
	
	}	
/*************************************************************************/
 	if($formdata['dynamic_ajx']&& $formdata['dynamic_ajx']==1) {     
 
	 if($frm->validate_data_ajx($formdata,$dateIDs,$date_frm)){

	 	$db->execute("START TRANSACTION");
/*******************************************************************************************/
		if($appointsIDs=$frm->save_appoint($formdata)){
			if($managersIDs=$frm->save_manager($formdata)){
				if($catIDs=$frm->save_category_ajx($formdata)){
					 if($catTypeIDs=$frm->save_managerType_ajx($formdata)){
								
/*********************************************************************************************/
/*********************************************************************************************/
						if ($forum_decID=$frm->add_forum($formdata,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,
						$dateIDs,$date_usr,$frm_date,$usersIDs)) {

							 
								
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
	
 }//end	$formdata['dynamic_ajx']==1
/************************************************************************************************/
 else{	
 if($frm->validate_data($formdata,$dateIDs,$date_frm)){

	 	$db->execute("START TRANSACTION");
/*******************************************************************************************/
		if($appointsIDs=$frm->save_appoint($formdata)){
			if($managersIDs=$frm->save_manager($formdata)){
//				if($catIDs=$frm->save_category($formdata)){
//					if($catTypeIDs=$frm->save_managerType($formdata)){
				if($catIDs=$frm->save_category_ajx($formdata)){
					 if($catTypeIDs=$frm->save_managerType_ajx($formdata)){
				
				
/*********************************************************************************************/
/*********************************************************************************************/
						if ($forum_decID=$frm->add_forum($formdata,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,
						$dateIDs,$date_usr,$frm_date,$usersIDs)) {

							 
								
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
/*************************************************************************************************/
}//end function validate

/************************************************************************************************/
/************************************************************************************************/
function take_forum_data($formdata){
	
	global $db;
	$frm=new forum_dec();//($formdata);
     $formdata['dynamic_10']=1;
     $formdata['take_data']=1;
	$formselect=$frm->read_forum_data($formdata['forum_decision']);
	if($formselect['src_users'] && $formselect['src_users']!=null
	   && $formselect['src_usersID'] && $formselect['src_usersID']!=null  ){

		 		
		$formdata['src_users']= explode(',',$formselect['src_users']);
		 
		$formdata['src_usersID']= explode(',',$formselect['src_usersID']);
		 
		$formdata['date_src_users']= explode(',',$formselect['date_users']);
	}else{
		unset($formdata[src_users]);
		unset($formdata[src_usersID]);
	}
	
/********************************************************************************************/	
$formdata['src_forumsType']= explode(',',$formselect['src_forumsType']);
		 
$formdata['src_managersType']= explode(',',$formselect['src_managersType']);	

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
	if(array_item($formdata,"dest_users")){
		 
		$usersIDs=$formdata["dest_users"];
	}	 
/******************************************************************************************/
if(array_item($formdata,"dest_users")){
$i=0;
foreach($formdata['dest_users'] as $key=>$val){
	$sql="select active  from rel_user_forum where userID=$key and forum_decID=$frmID ";
if($rows=$db->queryObjectArray($sql)){
	
	$formdata['active'][$key]=$rows[0]->active;
	$i++;
  }
 }	
}	
	
/**************************************************************************************/	
	  if($frm->validate_data_ajx($formdata,$dateIDs,$frm_date) ){
		return $formdata;
								 
 	}
	 
	return false;
}

/*********************************************************************************************************************/

function delete_forum($deleteID,$formdata=''){
	$frm=new forum_dec();
	$frm->del_forum($deleteID);
//	$frm->print_forum_paging();
			 
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
	 $formdata['forum_demo_last8']=1;
	}
	//$frm->print_forum_entry_form1_b($insertID);
	$frm->print_forum_entry_form_b($insertID); 
	 build_form($formdata);
	  $frm->print_forum_paging_b();
	 
	$frm->link();
}


/************************************************************************************************/
function  show_list($formdata=""){
	$frm=new forum_dec();

	$frm->link_div();
	$formdata=FALSE;
	build_form($formdata);
	$frm->print_forum_paging_b();


}
/****************************************************************************/
function  show_list_fail($formdata=""){
	$frm=new forum_dec();

    build_form($formdata);
	$frm->print_forum_paging_b();
	
}
/****************************************************************************/

function read_forum($editID){
	global $db;
	$frm=new forum_dec();

	if($_REQUEST['editID']){
		if(($editID =$frm->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
			$formdata =$frm->read_forum_data1($editID);//i took off the merchaot from full_name if will be problem to check
		}
	}else{
		if(($editID =$frm->array_item($_REQUEST, 'forum_decID')) && is_numeric($editID)){
			$formdata =$frm->read_forum_data1($editID);
		}
	}
	if($formdata['src_users']){
		$stuff = $formdata['src_users'];
		//$stuff_a = $formdata['src_users'];
		$stuff_b=explode(',',$formdata['src_users']);
	$i=0;

	foreach($stuff_b as $usr_name){
		if($i==0){
        $stuff_a = "  '" . $db->getMysqli()->real_escape_string($usr_name). "'";
		}else{
		$stuff_a .= "," .  "  '" . $db->getMysqli()->real_escape_string($usr_name). "'";
		}
		$i++;
	}	

/*******************************************************************/	
	$sql="SELECT  userID,full_name FROM users where full_name in  ($stuff_a) ORDER BY userID";

		if($rows=$db->queryObjectArray ($sql) ){
	  
		foreach($rows as $row)
		$dst[$row->userID]=$row->full_name;

		$formdata['dest_users']=$dst;
	}
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
$i=0;
foreach($formdata['dest_users'] as $key=>$val){
	$sql="select active  from rel_user_forum where userID=$key and forum_decID=$editID ";
if($rows=$db->queryObjectArray($sql)){
	
	$formdata['active'][$key]=$rows[0]->active;
	$i++;
  }
 }
}
/********************************************************************************************/
 	
	$frm->link_div();
	
	$forum_decID=$formdata['forum_decID'];
	$frm->message_update_b($formdata,$forum_decID);
	$formdata['forum_decision']=$forum_decID;

	
	 build_form_ajx7($formdata);
    
	 $frm->print_forum_paging_b();
	return  TRUE;

}

/******************************************************************************/


function read_forum_ajx($editID){
	global $db;
	$frm=new forum_dec();

	if($_REQUEST['editID']){
		if(($editID =$frm->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
			$formdata =$frm->read_forum_data1($editID);
		}
	}else{
		if(($editID =$frm->array_item($_REQUEST, 'forum_decID')) && is_numeric($editID)){
			$formdata =$frm->read_forum_data1($editID);
		}
	}
	if($formdata['src_users']){
		$stuff = $formdata['src_users'];
		
/*****************************************************************/	
		$stuff_b=explode(',',$formdata['src_users']);
	$i=0;

	foreach($stuff_b as $usr_name){
		if($i==0){
        $stuff_a = "  '" . $db->getMysqli()->real_escape_string($usr_name). "'";
		}else{
		$stuff_a .= "," .  "  '" . $db->getMysqli()->real_escape_string($usr_name). "'";
		}
		$i++;
	}	

/*******************************************************************/	
		
		
		
		$sql="SELECT  userID,full_name FROM users where full_name in($stuff_a) ORDER BY userID";
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
 

/**********************************GET_DECISION************************************************/				
$forum_decID=$formdata['forum_decID'];	
	$sql="SELECT d.decID,d.decName 
	         FROM decisions d 
	       left join rel_forum_dec rf on d.decID=rf.decID
	       WHERE rf.forum_decID=$forum_decID";
	      // left join forum_dec f on f.forum_decID
				

		    if($rows  = $db->queryObjectArray($sql) ){
               		    	
		     $formdata["decision"]=$rows; 
	}			
/******************************************************************************************/				
$i=0; 	
		if($formdata['dest_users'] && is_array($formdata['dest_users']) && is_array($dest_users)){
			
		foreach($dest_users as $key=>$val){
		if(is_numeric($val)){	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 

     
		     $formdata["dest_user"]=$results; 
 }elseif($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
			 
		foreach($formdata['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select userID,full_name  from users where userID=$key";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 
		     $formdata["dest_user"]=$results; 
		     $formdata["dest_users"]=$results; 
 }
		   		          	
/**********************************************************************************************************************/
//for check the length
	 $i=0; 	
		if($formdata['src_usersID'] && is_array($formdata['src_usersID'])   ){
			 
		foreach($formdata['src_usersID'] as $key=>$val){
	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		       
        }
		 

     }
		     $formdata["src_user"]=$results1; 
 }else{
 	$formdata["src_user"]=$formdata["dest_user"];
 }
/***********************************************************************/		   		          			 
/***********************FORUMSTYPE**********************************************/
  $i=0; 	
		if($formdata['dest_forumsType'] && is_array($formdata['dest_forumsType'])  ){
			
		foreach($formdata['dest_forumsType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select catID,catName  from categories1 where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$formdata['dest_forumsType']=$results_cat_frm;
}
/*************************************MANAGER_TYPE*****************************************************************/

  $i=0; 	
		if($formdata['dest_managersType'] && is_array($formdata['dest_managersType'])  ){
			
		foreach($formdata['dest_managersType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$formdata['dest_managersType']=$results_cat_mgr;
}
/******************************************************************************************************/


$manageID=$formdata['manager_forum'];
$sql="select managerName from managers where managerID=$manageID";
if($rows=$db->queryObjectArray($sql)){
	$formdata['managerName']=$rows[0]->managerName;
}		 
/**********************************************************************/ 		   		          	
$appID=$formdata['appoint_forum'];
$sql="select appointName from appoint_forum where appointID=$appID";
if($rows=$db->queryObjectArray($sql)){
	$formdata['appointName']=$rows[0]->appointName;
}		 
/**********************************************************************/ 

unset($formdata['multi_year']);
unset($formdata['multi_month']);
unset($formdata['multi_day']);
$formdata['multi_year'][0]='none';
 $formdata['multi_month'][0]='none';
 $formdata['multi_day'][0]='none';

$t = array();
$t['formdata'][]=$formdata;
	 
 
    $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
//     echo json_encode($formdata);
echo json_encode($t);
 	  exit;
	
			 	
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
	
	$dec->link();
	$dec->print_form2($formdata['forum_decID'] );



	return true;
}

/******************************************************************************/
function read_link($formdata){
	global $db;
	$frm=new forum_dec();
	$formdata=$frm->read_forum_data3($formdata['forum_decID'],$formdata['insertID']);

	
	$frm->link();
	
	return $formdata;

}


/************************************************************************************************/

function update_forum1($updateID){
	$frm=new forum_dec();
	$frm->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
	//$frm->link_div();
	$frm->update_forum_general();
  //  show_list();
	//$frm->print_forum_paging_b();
	
	
//	$frm->link_div();
	
//	$forum_decID=$formdata['forum_decID'];
//	
//	$formdata['forum_decision']=$forum_decID;

	
	 build_form($formdata);
    
	 $frm->print_forum_paging_b();
	return  TRUE;
	
	
	
	
}

/******************************************************************************/

/***********************************************************************/
function  delete_dec_form ($formdata){
	$dec=new forum_dec();
	
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