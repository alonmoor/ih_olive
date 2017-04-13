<?php

require_once ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
require_once ("../lib/model/decisions_class.php");
global $lang;   

$showform=TRUE;

/*************************************************************************************************/  
 //REAL JOB FOR UPDATE -DYNAMIC_5C
/*************************************************************************************************/
 
 if(array_item($_REQUEST,'mode')== 'change_insert_b'){		 
			 
            

            
        $insertID =$_REQUEST['insertID'];
		$decID =$_REQUEST['decID'];
 

		$sql  = "SELECT  decName,  decID, parentDecID " .
          " FROM  decisions ORDER BY  decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			 
			$parents[$row-> decID] = $row->parentDecID;
			$parents_b[$row-> decID] = $row->parentDecID;
			$subcats[$row->parentDecID][] = $row->decID;   }
       if($subcats[$decID]){	
			// build list of all parents for $insertID
			$dec_ID = $insertID;
			while($parents[$dec_ID]!=NULL) {
				$dec_ID = $parents[$dec_ID];
				$parentList[] = $dec_ID; 
			}
			
			
            $decisionID = $insertID;
			while($parents_b[$decisionID]!=NULL && $parents_b[$decisionID]!=$decID) {
				$decisionID = $parents_b[$decisionID];
				$parentList_b[] = $decisionID; 
			}
			
			
			
			if(   in_array($insertID, $subcats[$decID]) 
			||    in_array($parents[$insertID],$subcats[$decID] ) 
			||    in_array($decisionID,$subcats[$decID] )
			||    $parents[$insertID]== $decID 
			
			){
			 
			 ?>
			 <script>
			    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
			    fail.error=true;
			 </script>
 
			 <?php 
			 exit;
			}
		}elseif($insertID==$decID){
			?>
			 <script>
			    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
			    fail.error=true;
			 </script>
 
			 <?php 
			 exit;
		}	

        $dec=new decisions();
       $dec->update_dec_parent($insertID, $decID);  
        //$dec->print_decision_entry_form1_b($decID);
 	      
       $formdata=$dec->read_decision_data($decID);
       //build_form_dec_ajx($formdata);
       //$dec->print_form_paging_b();
 /******************************************************************************************/      
 /***********************************DEST_FORUMS**********************************************************/				
 $decID=$formdata['decID'];
				
  $i=0;
	
	  	
		if($formdata["dest_forums"] && is_array($formdata["dest_forums"])  ){
		$formdata["dest_forums$decID"]=	$formdata["dest_forums"];
		foreach($formdata["dest_forums$decID"] as $key=>$val){
	   if(is_numeric($val)){
		$sql="select forum_decID,forum_decName  from forum_dec where forum_decID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array("forum_decName"=>$rows[0]->forum_decName,"forum_decID"=>$rows[0]->forum_decID);
			 
		    
		      $i++;
		    }
	
		  } 
		}   
		       
     }  
		 

     
		     $formdata["dest_forums$decID"]=$results; 
/***********************************DEST_FORUMSTYPE**********************************************************/				
$decID=$formdata["decID"];
				
  $i=0;
	
	  	
		if($formdata["dest_decisionsType"] && is_array($formdata["dest_decisionsType"])  ){
			$formdata["dest_decisionsType$decID"]=$formdata["dest_decisionsType"];
		foreach($formdata["dest_decisionsType$decID"] as $ky=>$val){
	    if(is_numeric($val) ){
		$sql="select catID,catName  from categories where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array("catName"=>$rows[0]->catName,"catID"=>$rows[0]->catID);
			 
		    
		      $i++;
		     }
	
		  } 
		}   
		       
     }  
		 

     
		     $formdata["dest_decisionsType$decID"]=$results1; 
/*********************************************************************************/	
//$formdata['parent']		     	   		          	
 $formdata["dest_decisionsType"] = $formdata["dest_decisionsType$decID"] ;
 $formdata["dest_forums"] = $formdata["dest_forums$decID"] ;
  //  $formdata['type'] = 'success';
//	$formdata['message'] = 'עודכן בהצלחה!';
     echo json_encode($formdata);
   exit;		      
       
       
       
       
       
/*********************************************************************************************/       
//      echo json_encode($formdata);
//       exit;  
   }          
/******************************************************************************************************/


            if( !empty($_POST['form']['btnLink1']) && $_POST['form']['btnLink1'] ) {
            $_POST['mode']="link_second";
            $_REQUEST['mode']="link_second";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }      
            
            
            if(!empty($_POST['form']['btnLink2']) && $_POST['form']['btnLink2'] ) {
            $_POST['mode']="find";
            $_REQUEST['mode']="find";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }     

            if(!empty($_POST['form']['btnLink3']) && $_POST['form']['btnLink3'] ) {
            $_POST['mode']="link_second";
            $_REQUEST['mode']="link_second";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }    

            if(!empty($_POST['form']['btnLink4']) &&  $_POST['form']['btnLink4'] ) {
            $_POST['mode']="cancel";
            $_REQUEST['mode']="cancel";
            }      
            	
         
            if(!empty($_POST['form']['submitbutton']) && $_POST['form']['submitbutton'] ) {
            $_POST['mode']=$tmp =(array_item($_POST['form'], "decID") ) ? "update":"save" ;
            $_REQUEST['mode']=$_POST['mode'] ;
            }      
  
    if(isset ($_POST['form']['decID']))  {
 	$decisionID=$_POST['form']['decID'];
 	if(isset ($_POST["submitbutton3_$decisionID"]))  {
 		$_POST['mode']='take_data';
 		unset($_REQUEST['mode']);
 		$_REQUEST['mode']=$_POST['mode'];
 		
 	}
 }                 
            
            
            
            
if( ! isAjax() )
  html_header();      
  
  if(isset ($_REQUEST['id']) &&  array_item($_REQUEST, 'id')  )  { 
      $decID  = array_item($_REQUEST, 'id');
  }

is_logged();
 
 
if(array_key_exists('hidden_for_save', $_POST)=='save'){
	
$_REQUEST['mode']='save';
	
}
/********************************************************************************/
switch ($_REQUEST['mode'] ) {
	case "insert":

 	
   
		insert_dec($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
		break;

  	
  	case  "link_second":
global $db;
  		if(!$_SESSION['decID']){
  		$_SESSION['decID']=$_REQUEST['form']['decID'];
  		}
  		if(isset($_REQUEST['form']['btnLink3'])){
  			if (isset($_REQUEST['form'])){
  			  read_befor_link2($_POST['form']);
  			}
  		}elseif (isset($_REQUEST['form'])){
  		  read_befor_link($_POST['form']);
        }else{
          if(!$decID)	 
          $formdata['decID']=$_GET['decID'];
          if(!$formdata['decID'])
           $formdata['decID']=$_SESSION['decID'];
  		  $sql="select parentDecID1 from decisions where decID= " . $db->sql_string($formdata['decID']) ;
  		  $rows=$db->queryObjectArray($sql);
  		  
  		  
  		  if($rows[0]->parentDecID1){ 
  		  	$sql="update decisions set parentDecID1=null where decID= " . $db->sql_string($formdata['decID']) ;
  		  	$rows=$db->execute($sql);
  		  }
  		 
  		  
  		  $formdata['insertID']=$_GET['insertID'];
  		  unset($_SESSION['decID']);
  		  
  		  read_link($formdata);
          }
  	break;
  	
  	case "cancel":
  		   global $db;    
  		
 
  		$decID=$_POST['form']['decID'];
  		  $sql="select parentDecID1 from decisions where decID= $decID"  ;
  		   if($rows=$db->queryObjectArray($sql )){
  		   	if($rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)){ 
  		  	$sql="update decisions set parentDecID1=null where decID= $decID"   ;
  		  	if(!$db->execute($sql))
  		  	return FALSE;
  		  }
  	   }
  		  read_after_cancle($_POST['form']);
		break;
     case  "read_data":
     			$formdata =read_decision($_GET['editID']);
	break;
	case "update":
		if($_GET['updateID']) {
				update_dec($_GET['updateID']);
		}else{
        
/*********************************************************************************/
            $decID=$_POST['form']['decID'];
			if($_POST['form']['dest_forums'][0]== 'none')
			unset($_POST['form']['dest_forums'][0] );

			if(count($_POST['form']['dest_forums'])==0  )
			unset($_POST['form']['dest_forums'] );

			if($_POST['arr_dest_forums'][0]== 'none')
			unset($_POST['arr_dest_forums'][0] );

			if(count($_POST['arr_dest_forums'])==0  )
			unset($_POST['arr_dest_forums'] );
			 
/*********************************************************************************/
			
			
			if($_POST["form"]["dest_forums$decID"][0]== "none"){
			unset($_POST["form"]["dest_forums$decID"][0]);
			}

			if(count($_POST["form"]["dest_forums$decID"])==0  )
			unset($_POST["form"]["dest_forums$decID"] );

			if($_POST["arr_dest_forums$decID"][0]== "none")
			unset($_POST["arr_dest_forums$decID"][0] );

			if(count($_POST["arr_dest_forums$decID"])==0  )
			unset($_POST["arr_dest_forums$decID"] );
			
			
			
/*********************************************************************************/
			if($_POST['form']['dest_decisionsType'][0]== 'none')
			unset($_POST['form']['dest_decisionsType'][0] );

			if(count($_POST['form']['dest_decisionsType'])==0  )
			unset($_POST['form']['dest_decisionsType'] );

			if($_POST['form']['dest_decisionsType'][0]== 'none')
			unset($_POST['form']['dest_decisionsType'][0] );

			if(count($_POST['form']['dest_decisionsType'])==0  )
			unset($_POST['form']['dest_decisionsType'] );


			if($_POST['arr_dest_decisionsType'][0]== 'none')
			unset($_POST['arr_dest_decisionsType'][0] );

			if(count($_POST['arr_dest_decisionsType'])==0  )
			unset($_POST['arr_dest_decisionsType'] );
			 
/*********************************************************************************/ 
if($_POST["form"]["dest_decisionsType$decID"][0]== "none")
			unset($_POST["form"]["dest_decisionsType$decID"][0] );

			if(count($_POST["form"]["dest_decisionsType$decID"])==0  )
			unset($_POST["form"]["dest_decisionsType$decID"] );

			if($_POST["form"]["dest_decisionsType$decID"][0]== "none")
			unset($_POST["form"]["dest_decisionsType$decID"][0] );

			if(count($_POST["form"]["dest_decisionsType$decID"])==0  )
			unset($_POST["form"]["dest_decisionsType$decID"] );


			if($_POST["arr_dest_decisionsType$decID"][0]== "none")
			unset($_POST["arr_dest_decisionsType$decID"][0] );

			if(count($_POST["arr_dest_decisionsType$decID"])==0  )
			unset($_POST["arr_dest_decisionsType$decID"] );
/*********************************************************************************/			
		$formdata=$_POST['form'];
		if(array_item($_POST,"arr_dest_forums") && (is_array($_POST["arr_dest_forums"])  )  ){
		  $formdata["dest_forums"]=$_POST["arr_dest_forums"];	
		}	
		if(array_item($_POST,"arr_dest_forums$decID") &&
		 (is_array($_POST["arr_dest_forums$decID"])  )  ){
		  $formdata["dest_forums$decID"]=$_POST["arr_dest_forums$decID"];	
		}	
/**********************************************************************************/
if(array_item($_POST,"arr_dest_decisionsType") && (is_array($_POST["arr_dest_decisionsType"])  )  ){
		  $formdata["dest_decisionsType"]=$_POST["arr_dest_decisionsType"];	
		}	

	
		if(array_item($_POST,"arr_dest_decisionsType$decID") &&
		 (is_array($_POST["arr_dest_decisionsType$decID"])) ){
		  $formdata["dest_decisionsType$decID"]=$_POST["arr_dest_decisionsType$decID"];	
		}					
/*********************************************************************************/			
			
/******************************************************************************/
		 $formdata1 =$_POST['form'];
	 
		 $formdata['dec_Allowed']=array_item ($_POST,'dec_allowed');
		 $formdata['dec_status']=array_item ($_POST,'dec_status');
		 
if($formdata["dest_forums$decID"] && $formdata["dest_forums$decID"]!='none' 
  && is_array($formdata["dest_forums$decID"])  && (count($formdata["dest_forums$decID"])>0)   ){		 
$i=0;	 
 		 foreach($formdata["dest_forums$decID"] as $forum){
 		 	
 		 	$formdata['dest_forums_test'][$i]=$forum;
 		 	$i++;
 		 }
 		 $formdata["dest_forums$decID"]= $formdata['dest_forums_test'];
 		 unset($formdata['dest_forums_test']);		 
  }		 
		 
/***************************************************************/		 
			if(!$formdata=update_decision($formdata)){         /*
/***************************************************************/				 
				
				
			if($_POST['form']['dec_date']){	
				$formdata1['dec_date']=$_POST['form']['dec_date'];
				$formdata1['fail']=1;
				
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['dec_date']);
				if(strlen($year_date)>3 ){
				$formdata1['dec_date']="$day_date-$month_date-$year_date";
				}
			}	
				
			if($_POST['arr_dest_forums']){
			  $formdata1['dest_forums']=$_POST['arr_dest_forums'];	
			}
			
			if($_POST['arr_dest_decisionsType']){
			  $formdata1['dest_decisionsType']=$_POST['arr_dest_decisionsType'];	
			}
				show_list($formdata1);
				return;
			}else{


/**********************************TO_AJX*******************************************************/				
//$formdata=$_POST['form'];	
$dec=new decisions(); 



/***********************************DEST_FORUMS**********************************************************/				
 $decID=$formdata['decID'];
	$dest_forum_tmp=$formdata["dest_forums$decID"];			
  $i=0;
		  	
		if($formdata["dest_forums$decID"] && is_array($formdata["dest_forums$decID"])  ){
			
		foreach($formdata["dest_forums$decID"] as $key=>$val){
	   if(is_numeric($val)){
		$sql="select forum_decID,forum_decName  from forum_dec where forum_decID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array("forum_decName"=>$rows[0]->forum_decName,"forum_decID"=>$rows[0]->forum_decID);
			 
		    
		      $i++;
		    }
	
		  } 
		}   
		       
     }  
		 

     
		     $formdata["dest_forums$decID"]=$results; 
/***********************************DEST_USERFORUM**********************************************************/				
 $decID=$formdata['decID'];
				
  $i=0;
  $j=0;
  $k=0;
	  	

  	
		if($dest_forum_tmp && is_array($dest_forum_tmp)  ){
			
		foreach($dest_forum_tmp as $key=>$val){
	   if(is_numeric($val)){
		$sql="select forum_decID,forum_decName  from forum_dec where forum_decID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array("forum_decName"=>$rows[0]->forum_decName,"forum_decID"=>$rows[0]->forum_decID);
			 
		    
		     
		    }
	
		  } 
		  
		  $getUser_sql	=	"SELECT u.userID,u.full_name ,m.managerID,m.managerID,m.managerName FROM users u 
		                     inner join rel_user_forum r  
		                     on u.userID = r.userID 
		                     
		                     inner join forum_dec f  
		                     on f.forum_decID = r.forum_decID
		
		                     inner join managers m
		                     on m.managerID=f.managerID
		                     
		                     WHERE f.forum_decID = $val
		                     ORDER BY u.full_name ASC";
		  if($rows=$db->queryObjectArray($getUser_sql)){
		  	 $j=0;
		  	foreach($rows as $row){
		  		 
		  		 $results_user[$i][$j] = array("full_name"=>$row->full_name,"userID"=>$row->userID);
                
                  
		  		$j++;	
		  	}//end foreach2
		  	
		  }
		   $results_manager[$i][0] = array("managerName"=>$row->managerName,"managerID"=>$row->managerID);
		   $i++;
		}//end foreach1   
		       
     }  
		 
     
		     $formdata["dest_users"]=$results_user; 
		     $formdata["dest_managers"]=$results_manager;	
/***********************************USERFORUM_DECISIONS_ECCEPT**********************************************************/				
 
				
  $i=0;
  $j=0;
  $k=0;
	  	

  	
  if($dest_forum_tmp && is_array($dest_forum_tmp)  ){
			
		foreach($dest_forum_tmp as $key=>$val){
	   if(is_numeric($val)){
		$sql="select forum_decID,forum_decName  from forum_dec where forum_decID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array("forum_decName"=>$rows[0]->forum_decName,"forum_decID"=>$rows[0]->forum_decID);
			 
		    
		     
		    }
	
		  } 
		  
		  $getUser_sql	=	"SELECT u.userID,u.full_name ,m.managerID,m.managerName,f.forum_decID,f.forum_decName,r.HireDate FROM users u 
		                     INNER join rel_user_Decforum r  
		                     on u.userID = r.userID 
		                     
		                     INNER JOIN decisions  d
			                 ON d.decID=r.decID 
		                     
		                     INNER join forum_dec f  
		                     on f.forum_decID = r.forum_decID
		
		                     INNER join managers m
		                     on m.managerID=f.managerID
		                     
		                     WHERE f.forum_decID = $val
		                     AND d.decID=$decID
		                     ORDER BY u.full_name ASC";
		  
		  
		  
		  if($rows=$db->queryObjectArray($getUser_sql)){
		  	 $j=0;
		  	foreach($rows as $row){
		  		 
		  		 $results_user_Decfrm[$i][$j] = array("full_name"=>$row->full_name,"userID"=>$row->userID,"forum_decID"=>$row->forum_decID,
		  		                "HireDate"=>$row->HireDate, "forum_decName"=>$row->forum_decName, "managerName"=>$row->managerName,"managerID"=>$row->managerID);
                
                  
		  		$j++;	
		  	}//end foreach2
		  	
		  }else{
		  	$results_user_Decfrm[$i][$j]="";
		  }
		   $results_manager_Decfrm[$i][0] = array("managerName"=>$row->managerName,"managerID"=>$row->managerID);
		   $i++;
		}//end foreach1   
		       
     }  
		 
     
     $formdata["dest_users_Decfrm"]=$results_user_Decfrm; 
     $formdata["dest_managers_Decfrm"]=$results_manager_Decfrm;	

     
     
     
     
/***********************************************************************************************************************/		     
/***********************************DEST_FORUMSTYPE**********************************************************/				
$decID=$formdata["decID"];
				
  $i=0;
	
	  	
		if($formdata["dest_decisionsType$decID"] && is_array($formdata["dest_decisionsType$decID"])  ){
			
		foreach($formdata["dest_decisionsType$decID"] as $ky=>$val){
	    if(is_numeric($val) ){
		$sql="select catID,catName  from categories where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array("catName"=>$rows[0]->catName,"catID"=>$rows[0]->catID);
			 
		    
		      $i++;
		     }
	
		  } 
		}   
		       
     }  
		 

     
		     $formdata["dest_decisionsType$decID"]=$results1; 
/*********************************************************************************/		   		          	
 $formdata["dest_decisionsType"] = $formdata["dest_decisionsType$decID"] ;
 $formdata["dest_forums"] = $formdata["dest_forums$decID"] ;
 $formdata["src_forums"] = $formdata["src_forums$decID"] ;
 
 if($formdata["dec_date$decID"] && $dec->check_date($formdata["dec_date$decID"] ))
 $formdata["dec_date"] = $formdata["dec_date$decID"] ;
 
    $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
/**********************************************************************************/
/******************************************************/
$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
		if( $rows = $db->queryObjectArray($sql)){
				
			foreach($rows as $row) {
				$subcats_dec[$row->parentCatID][] = $row->catID;
				$catNames_dec[$row->catID] = $row->catName; }

				$rows = build_category_array($subcats_dec[NULL], $subcats_dec, $catNames_dec);
if($rows && is_array($rows))
 $formdata['decType']=$rows; 
}
 
 
/**********************************************************************************/
/******************************************************/
$sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
		if( $rows = $db->queryObjectArray($sql)){
				
			foreach($rows as $row) {
				$subcats_frm[$row->parentForumID][] = $row->forum_decID;
				$catNames_frm[$row->forum_decID] = $row->forum_decName; }

				$rows = build_category_array($subcats_frm[NULL], $subcats_frm, $catNames_frm);
if($rows && is_array($rows))
 $formdata['dec_frm']=$rows; 
}
 
 
/*****************************************************/ 	
/**********************************************************************************/	
	
     echo json_encode($formdata);
    
   exit;		
				
/*********************************************************************************************/				
			}
			
			
		        $formdata['dec_date']=$_POST['form']['dec_date'];
						list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['dec_date']);
						if(strlen($year_date)>3 ){
						$formdata['dec_date']="$day_date-$month_date-$year_date";			 
			}		
		show_list($formdata);	
			
			
		}
    break;
	case "save":
/*****************************************************************************************/
            if($_POST['arr_dest_forums'][0]== 'none')
			unset($_POST['arr_dest_forums'][0] );
		
		    if($_POST['arr_dest_decisionsType'][0]== 'none')
			unset($_POST['arr_dest_decisionsType'][0] );

///////////////////			
			
		    if($_POST['form']['dest_forums'][0]== 'none')
			unset($_POST['form']['dest_forums'][0] );
			
			if($_POST['form']['dest_decisionsType'][0]== 'none')
			unset($_POST['form']['dest_decisionsType'][0] );
/////////////////		
			
			if($_POST['form']['new_category'][0]== 'none')
			unset($_POST['form']['new_forum'][0] );
			
			if($_POST['form']['new_category'][0]== 'none')
			unset($_POST['form']['new_category'][0] );
			
/**********************************************************************************/			
		    $formdata= $_POST['form'];
              
            if(array_item ($_POST,'arr_dest_forums') )
			 $formdata['dest_forums']=$_POST['arr_dest_forums'];
			
             if(array_item ($_POST,'arr_dest_decisionsType') )
			 $formdata['dest_decisionsType']=$_POST['arr_dest_decisionsType'];
			 
			 
			 if(!array_item ($_POST,'arr_dest_decisionsType') 
			   &&  ($_POST['form']['src_decisionsType'][0]   )
			   && is_array($_POST['form']['src_decisionsType']))
			 $formdata['dest_decisionsType']=$_POST['form']['src_decisionsType'];
			 
			 
			 
			 if(!array_item ($_POST,'arr_dest_forums') 
			   &&  ($_POST['form']['src_forums'][0]   )
			   && is_array($_POST['form']['src_forums']))
			 $formdata['dest_forums']=$_POST['form']['src_forums'];
			 
 		 
/****************************************************************************************/		
		
if(is_array($formdata['dest_forums']) && !($formdata['dest_forums'][0]) ){
$i=0;     
			foreach ($formdata["dest_forums"] as $frm ){
			     	$form["dest_forums"][$i]=$frm ;
			     	$i++;
			     }
			
$formdata["dest_forums"]=$form["dest_forums"];			
}
/***********************************************************************************/			
if(is_array($formdata['dest_decisionsType']) && !($formdata['dest_decisionsType'][0]) ){
$i=0; $form='';    
			foreach ($formdata["dest_decisionsType"] as $frm ){
			     	 $form["dest_decisionsType"][$i]=$frm ;
			     	$i++;
			     }
	
$formdata["dest_decisionsType"]=$form["dest_decisionsType"];
}	 					
		
/**********************************************************************************************/


$formdata['dec_Allowed']=array_item ($_POST,'dec_allowed');
$formdata['dec_status']=array_item ($_POST,'dec_status');



/*******************************************************/
		if(!validate($formdata )){                    /*
/*******************************************************/			

			
			
			$formdata=$_POST['form'];
			$formdata['fail']=1;

			if(array_item ($_POST,'arr_dest_forums') )
			 $formdata['dest_forums']=$_POST['arr_dest_forums'];
			
			  if(!array_item ($_POST,'arr_dest_forums') 
			   &&  ($_POST['form']['src_forums'][0]   )
			   && is_array($_POST['form']['src_forums']))
			 $formdata['dest_forums']=$_POST['form']['src_forums'];
			 
///////////////////////	///////////////////////		 
             if(array_item ($_POST,'arr_dest_decisionsType') )
			 $formdata['dest_decisionsType']=$_POST['arr_dest_decisionsType'];
			
			  if(!array_item ($_POST,'arr_dest_decisionsType') 
			   &&  ($_POST['form']['src_decisionsType'][0]   )
			   && is_array($_POST['form']['src_decisionsType']))
			 $formdata['dest_decisionsType']=$_POST['form']['src_decisionsType'];
			 
//////////////////////////////////////////////////////////////////////////////////
$formdata['dec_date']=$_POST['form']['dec_date'];
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['dec_date']);
				if(strlen($year_date)>3 ){
				$formdata['dec_date']="$day_date-$month_date-$year_date";			 
	}			 
			 
		show_list($formdata);
		}else{
		   $dec=new decisions();
			$dec->print_form_paging_b(); 	 
		}		
	break;
	case "realy_delete":
			
		if(isset($_REQUEST['delete'])){  
   	   
  	  $formdata['decID']=$_REQUEST['decID'];
  			  
  			  real_del($_POST['form']);
  		 }else{	
		if (!(real_del($_POST['form'])))
		  $formdata=FALSE;
		 show_list($formdata);
  		 }		
         

    break;
	case "clear":
			
		 
		link1();
	break;
	case "delete":
		if (($_GET['deleteID'])){
			delete_dec($_GET['deleteID']);//subcategories
		}else{
			delete_dec_form($_POST['form']);
		}

	break; 
	
	case "edit_dec":
		$d =new decisions();
		$decID=$_REQUEST['decID'];
		$d->print_form($page,$decID);
        
	break; 
	
	
	
	
	case "find":
		require_once 'find3.php';
        
	break; 
	
/************************************************************************/	
	case "take_data":
		 
        
/*********************************************************************************/
            $decID=$_POST['form']['decID'];
			if($_POST['form']['dest_forums'][0]== 'none')
			unset($_POST['form']['dest_forums'][0] );

			if(count($_POST['form']['dest_forums'])==0  )
			unset($_POST['form']['dest_forums'] );

			if($_POST['arr_dest_forums'][0]== 'none')
			unset($_POST['arr_dest_forums'][0] );

			if(count($_POST['arr_dest_forums'])==0  )
			unset($_POST['arr_dest_forums'] );
			 
/*********************************************************************************/
			
			
			if($_POST["form"]["dest_forums$decID"][0]== "none"){
			unset($_POST["form"]["dest_forums$decID"][0]);
			}

			if(count($_POST["form"]["dest_forums$decID"])==0  )
			unset($_POST["form"]["dest_forums$decID"] );

			if($_POST["arr_dest_forums$decID"][0]== "none")
			unset($_POST["arr_dest_forums$decID"][0] );

			if(count($_POST["arr_dest_forums$decID"])==0  )
			unset($_POST["arr_dest_forums$decID"] );
			
			
			
/*********************************************************************************/
			if($_POST['form']['dest_decisionsType'][0]== 'none')
			unset($_POST['form']['dest_decisionsType'][0] );

			if(count($_POST['form']['dest_decisionsType'])==0  )
			unset($_POST['form']['dest_decisionsType'] );

			if($_POST['form']['dest_decisionsType'][0]== 'none')
			unset($_POST['form']['dest_decisionsType'][0] );

			if(count($_POST['form']['dest_decisionsType'])==0  )
			unset($_POST['form']['dest_decisionsType'] );


			if($_POST['arr_dest_decisionsType'][0]== 'none')
			unset($_POST['arr_dest_decisionsType'][0] );

			if(count($_POST['arr_dest_decisionsType'])==0  )
			unset($_POST['arr_dest_decisionsType'] );
			 
/*********************************************************************************/ 
if($_POST["form"]["dest_decisionsType$decID"][0]== "none")
			unset($_POST["form"]["dest_decisionsType$decID"][0] );

			if(count($_POST["form"]["dest_decisionsType$decID"])==0  )
			unset($_POST["form"]["dest_decisionsType$decID"] );

			if($_POST["form"]["dest_decisionsType$decID"][0]== "none")
			unset($_POST["form"]["dest_decisionsType$decID"][0] );

			if(count($_POST["form"]["dest_decisionsType$decID"])==0  )
			unset($_POST["form"]["dest_decisionsType$decID"] );


			if($_POST["arr_dest_decisionsType$decID"][0]== "none")
			unset($_POST["arr_dest_decisionsType$decID"][0] );

			if(count($_POST["arr_dest_decisionsType$decID"])==0  )
			unset($_POST["arr_dest_decisionsType$decID"] );
/*********************************************************************************/			
		$formdata=$_POST['form'];
		if(array_item($_POST,"arr_dest_forums") && (is_array($_POST["arr_dest_forums"])  )  ){
		  $formdata["dest_forums"]=$_POST["arr_dest_forums"];	
		}	
		if(array_item($_POST,"arr_dest_forums$decID") &&
		 (is_array($_POST["arr_dest_forums$decID"])  )  ){
		  $formdata["dest_forums$decID"]=$_POST["arr_dest_forums$decID"];	
		}	
/**********************************************************************************/
if(array_item($_POST,"arr_dest_decisionsType") && (is_array($_POST["arr_dest_decisionsType"])  )  ){
		  $formdata["dest_decisionsType"]=$_POST["arr_dest_decisionsType"];	
		}	

	
		if(array_item($_POST,"arr_dest_decisionsType$decID") &&
		 (is_array($_POST["arr_dest_decisionsType$decID"])) ){
		  $formdata["dest_decisionsType$decID"]=$_POST["arr_dest_decisionsType$decID"];	
		}					
/*********************************************************************************/			
			
/******************************************************************************/
		 $formdata1 =$_POST['form'];
	 
		 $formdata['dec_Allowed']=array_item ($_POST,'dec_allowed');
		 $formdata['dec_status']=array_item ($_POST,'dec_status');
		 
if($formdata["dest_forums$decID"] && $formdata["dest_forums$decID"]!='none' 
  && is_array($formdata["dest_forums$decID"])  && (count($formdata["dest_forums$decID"])>0)   ){		 
$i=0;	 
 		 foreach($formdata["dest_forums$decID"] as $forum){
 		 	
 		 	$formdata['dest_forums_test'][$i]=$forum;
 		 	$i++;
 		 }
 		 $formdata["dest_forums$decID"]= $formdata['dest_forums_test'];
 		 unset($formdata['dest_forums_test']);		 
  }		 
		 
/***************************************************************/		 
			if(!$formdata=take_data_decision($formdata)){         /*
/***************************************************************/				 
				
				
			if($_POST['form']['dec_date']){	
				$formdata1['dec_date']=$_POST['form']['dec_date'];
				$formdata1['fail']=1;
				
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['dec_date']);
				if(strlen($year_date)>3 ){
				$formdata1['dec_date']="$day_date-$month_date-$year_date";
				}
			}	
				
			if($_POST['arr_dest_forums']){
			  $formdata1['dest_forums']=$_POST['arr_dest_forums'];	
			}
			
			if($_POST['arr_dest_decisionsType']){
			  $formdata1['dest_decisionsType']=$_POST['arr_dest_decisionsType'];	
			}
				show_list($formdata1);
				return;
			}else{


/**********************************TO_AJX*******************************************************/				
//$formdata=$_POST['form'];	
$dec=new decisions(); 



/***********************************DEST_FORUMS**********************************************************/				
 $decID=$formdata['decID'];
	$dest_forum_tmp=$formdata["dest_forums$decID"];			
  $i=0;
		  	
		if($formdata["dest_forums$decID"] && is_array($formdata["dest_forums$decID"])  ){
			
		foreach($formdata["dest_forums$decID"] as $key=>$val){
	   if(is_numeric($val)){
		$sql="select forum_decID,forum_decName  from forum_dec where forum_decID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array("forum_decName"=>$rows[0]->forum_decName,"forum_decID"=>$rows[0]->forum_decID);
			 
		    
		      $i++;
		    }
	
		  } 
		}   
		       
     }  
		 

     
		     $formdata["dest_forums$decID"]=$results; 
/***********************************DEST_USERFORUM**********************************************************/				
 $decID=$formdata['decID'];
				
  $i=0;
  $j=0;
  $k=0;
	  	

  	
		if($dest_forum_tmp && is_array($dest_forum_tmp)  ){
			
		foreach($dest_forum_tmp as $key=>$val){
	   if(is_numeric($val)){
		$sql="select forum_decID,forum_decName  from forum_dec where forum_decID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array("forum_decName"=>$rows[0]->forum_decName,"forum_decID"=>$rows[0]->forum_decID);
			 
		    
		     
		    }
	
		  } 
		  
		  $getUser_sql	=	"SELECT u.userID,u.full_name ,m.managerID,m.managerID,m.managerName FROM users u 
		                     inner join rel_user_forum r  
		                     on u.userID = r.userID 
		                     
		                     inner join forum_dec f  
		                     on f.forum_decID = r.forum_decID
		
		                     inner join managers m
		                     on m.managerID=f.managerID
		                     
		                     WHERE f.forum_decID = $val
		                     ORDER BY u.full_name ASC";
		  if($rows=$db->queryObjectArray($getUser_sql)){
		  	 $j=0;
		  	foreach($rows as $row){
		  		 
		  		 $results_user[$i][$j] = array("full_name"=>$row->full_name,"userID"=>$row->userID);
                
                  
		  		$j++;	
		  	}//end foreach2
		  	
		  }
		   $results_manager[$i][0] = array("managerName"=>$row->managerName,"managerID"=>$row->managerID);
		   $i++;
		}//end foreach1   
		       
     }  
		 
     
		     $formdata["dest_users"]=$results_user; 
		     $formdata["dest_managers"]=$results_manager;	
/***********************************USERFORUM_DECISIONS_ECCEPT**********************************************************/				
 
				
  $i=0;
  $j=0;
  $k=0;
	  	

  	
  if($dest_forum_tmp && is_array($dest_forum_tmp)  ){
			
		foreach($dest_forum_tmp as $key=>$val){
	   if(is_numeric($val)){
		$sql="select forum_decID,forum_decName  from forum_dec where forum_decID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array("forum_decName"=>$rows[0]->forum_decName,"forum_decID"=>$rows[0]->forum_decID);
			 
		    
		     
		    }
	
		  } 
		  
		  $getUser_sql	=	"SELECT u.userID,u.full_name ,m.managerID,m.managerName,f.forum_decID,f.forum_decName,r.HireDate FROM users u 
		                     INNER join rel_user_Decforum r  
		                     on u.userID = r.userID 
		                     
		                     INNER JOIN decisions  d
			                 ON d.decID=r.decID 
		                     
		                     INNER join forum_dec f  
		                     on f.forum_decID = r.forum_decID
		
		                     INNER join managers m
		                     on m.managerID=f.managerID
		                     
		                     WHERE f.forum_decID = $val
		                     AND d.decID=$decID
		                     ORDER BY u.full_name ASC";
		  
		  
		  
		  if($rows=$db->queryObjectArray($getUser_sql)){
		  	 $j=0;
		  	foreach($rows as $row){
		  		 
		  		 $results_user_Decfrm[$i][$j] = array("full_name"=>$row->full_name,"userID"=>$row->userID,"forum_decID"=>$row->forum_decID,
		  		                "HireDate"=>$row->HireDate, "forum_decName"=>$row->forum_decName, "managerName"=>$row->managerName,"managerID"=>$row->managerID);
                
                  
		  		$j++;	
		  	}//end foreach2
		  	
		  }else{
		  	$results_user_Decfrm[$i][$j]="";
		  }
		   $results_manager_Decfrm[$i][0] = array("managerName"=>$row->managerName,"managerID"=>$row->managerID);
		   $i++;
		}//end foreach1   
		       
     }  
		 
     
     $formdata["dest_users_Decfrm"]=$results_user_Decfrm; 
     $formdata["dest_managers_Decfrm"]=$results_manager_Decfrm;	

     
     
     
     
/***********************************************************************************************************************/		     
/***********************************DEST_FORUMSTYPE**********************************************************/				
$decID=$formdata["decID"];
				
  $i=0;
	
	  	
		if($formdata["dest_decisionsType$decID"] && is_array($formdata["dest_decisionsType$decID"])  ){
			
		foreach($formdata["dest_decisionsType$decID"] as $ky=>$val){
	    if(is_numeric($val) ){
		$sql="select catID,catName  from categories where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array("catName"=>$rows[0]->catName,"catID"=>$rows[0]->catID);
			 
		    
		      $i++;
		     }
	
		  } 
		}   
		       
     }  
		 

     
		     $formdata["dest_decisionsType$decID"]=$results1; 
/*********************************************************************************/		   		          	
 $formdata["dest_decisionsType"] = $formdata["dest_decisionsType$decID"] ;
 $formdata["dest_forums"] = $formdata["dest_forums$decID"] ;
 $formdata["src_forums"] = $formdata["src_forums$decID"] ;
 
 if($formdata["dec_date$decID"] && $dec->check_date($formdata["dec_date$decID"] ))
 $formdata["dec_date"] = $formdata["dec_date$decID"] ;
 
    $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
	
	
     echo json_encode($formdata);
    
   exit;		
				
/*********************************************************************************************/				
			}
			
			
		        $formdata['dec_date']=$_POST['form']['dec_date'];
						list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['dec_date']);
						if(strlen($year_date)>3 ){
						$formdata['dec_date']="$day_date-$month_date-$year_date";			 
			}		
		show_list($formdata);	
			
			
		
    break;
	
/*************************************************************************/	
	default:
	case "list":
			if($showform && !($_POST['form']['btnLink1'])&& $page<=1) {
				$dec=new decisions();
				$formdata = array_item($_POST, "form");
				// input new or edit existing data?
				if(array_item($formdata, "decID")){
				echo "<h1>ערוך החלטה</h1>";
				}else{
				echo "<h1>הכנס החלטה חדשה</h1>";
				}  
				// show form to input / edit data
				show_list($formdata);
		}elseif($_POST['form']['btnLink1']&& $_POST['form']){
		     $dec->print_form2($_POST['form']['decID']) ;
		}else{
			$decID=$_REQUEST['decID'];
			$dec->print_form();
		}
}


/************************************************************************************************/

function delete_dec($deleteID){
	global $db;

	$d=new decisions();
$sql="select parentDecID from decisions where decID=$deleteID";
$rows=$db->queryObjectArray($sql);
$parent=$rows[0]->parentDecID;	
 
$d->print_decision_entry_form1($deleteID);
 
if(build_delete_form1($deleteID)){
   $showform=FALSE; }
 
}
/************************************************************************************************/
function  delete_dec_form ($formdata){
		global $db;

	$dec=new decisions();
    $sql="select parentDecID from decisions where decID= " . $db->sql_string($formdata['decID']) ; 
    $rows=$db->queryObjectArray($sql);
    $parent=$rows[0]->parentDecID;
    $decID=$formdata['decID'];	
 
    $dec->print_decision_entry_form1($formdata['decID']);	
 
	if(array_item($formdata, "btnClear"))
	// clear form
	$formdata = FALSE;

	elseif(array_item($formdata, "btnDelete")) {
		// ask, if really delete
		if(build_delete_form($formdata))
		$showform=FALSE; }

		return true;
}
/***********************************************************************/
function  real_del($formdata){
	$dec=new decisions();
	global $db;
	 
	if(array_item($formdata,'decID')){
		$formdata=$dec->read_decision_data($formdata['decID']);
		$db->execute("START TRANSACTION");
		 
		if($dec->del_decision($formdata['decID'])){
		$db->execute("COMMIT");
		 
		show_list($formdata);
		}
		else{
		$db->execute("ROLLBACK");
		$formdata = FALSE;
		return FALSE;
		}
	}
		return $formdata;
}
/***********************************************************************/
function insert_dec($insertID,$submitbutton,$subcategories){
	$d=new decisions();
	$d->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
	
	
	if(!$insertID && is_numeric($insertID))
	$insertID=$_GET['insertID'];
	
	
	 
	$formdata['insertID']=$insertID  ;
	$d->link_b();
	 $d->print_decision_entry_form1_c($insertID);
	 build_form_dec_ajx($formdata);
	$d->link_b();
}


/************************************************************************************************/
function  show_list($formdata){
	$dec=new decisions();
	
	$dec->link_div();
	
	build_form($formdata);
	$dec->print_form_paging_b();
	
}
/****************************************************************************/
function read_decision($editID){
	global $db;
	$dec=new decisions();
    if($editID==11) {
			echo "<br />רשומת אב אין פרטים ספציפיים   .\n";
			$dec->link();
			return 0;
		}
	if(($editID =$dec->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
		$formdata =$dec->read_decision_data($editID);
		$sql="select forum_decID from rel_forum_dec where decID=$editID";
		$rows=$db->queryObjectArray($sql);
		if($rows)
		$formdata['forum_decision'] = $rows[0]->forum_decID;

	}
	$dec->link();
     
	
$sql="select parentDecID1 from decisions where decID=$editID";
  if($rows=$db->queryObjectArray($sql)  ){
  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
  $parent=	$rows[0]->parentDecID1;
  	$dec->print_decision_entry_form1_b($parent);
  	}
  }
	
     $dec->print_decision_entry_form1_c($editID);
 
	 build_form($formdata);
	$dec->link();
	return  TRUE;


}

/******************************************************************************/
function read_befor_link($formdata){
	global $db;
	$dec=new decisions();
		 
		  $dec->link_b();
	      
	      $decID=$formdata['decID'];
	      $dec->print_decision_entry_form1_c($decID);
	       $dec->print_form_paging_b($decID);
	      
	      
	   
	     
	       
	      
	  
		return true;
}

/******************************************************************************/
function read_befor_link2($formdata){
	global $db;
	$dec=new decisions();
		 
		  $dec->link_b();
	      
	      $decID=$formdata['decID'];
	      
	      
	      $bar='link2';
          $query_string =    'flag=' . urlencode($bar);
        
	 ?>
    <input type=hidden name="decID" id="decID" value="<?php echo $formdata['decID']?>" />
   
    <?php   
	
	       require_once 'find3.php' ;
	
	      
	  
		return  true ;
}

/******************************************************************************/
function read_link($formdata){
   
    global $db;
	$dec=new decisions();
	$formdata=$dec->read_decision_data3($formdata['decID'],$formdata['insertID']);	
	
    $dec->conn_Parent_second($formdata); 
    $dec->link_b();	
 
  
	$dec->print_decision_entry_form1_b  ($formdata['parentDecID1'] );
 	$dec->print_decision_entry_form1_c  ($formdata['decID'] );
 	?>
    <input type=hidden name="decID" id="decID" value="<?php echo $formdata['decID']?>" />
   
    <?php   
    $formdata=$dec->read_decision_data($formdata['decID']);
    build_form_dec_ajx($formdata);
    $dec->print_form_paging_b();
 
	return true;	
	
	
}


/************************************************************************************************/
function read_after_cancle($formdata){
	global $db;
	$dec=new decisions();

		  $dec->link_b();

	      $decID=$formdata['decID'];
 	      $dec->print_decision_entry_form1_c($decID);
	      $formdata=$dec->read_decision_data($decID);
	      build_form($formdata);
	       $dec->print_form_paging_b();
		return true;
}

/******************************************************************************/


function update_dec($updateID){
	$d=new decisions();
	$d->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
	$d->link_div();
	$d->update_decision_general();
 
	//$d->link();
}
 
/******************************************************************************/
function update_decision($formdata){
	global $db;
    $formdata['dynamic_5c']=1;
     $mode='update';
    
	$dec=new decisions();
	 $decID=$formdata['decID'];
     $formselect=$dec->read_decision_data2($formdata['decID']);
  
     $formdata['parentDecID']=$formselect['parentDecID'];
     
     if($formselect['parentDecID1'])
     $formdata['parentDecID1']=$formselect['parentDecID1'];
     
     
     if($formselect["src_forums$decID"]){
     $formdata["src_forums$decID"]=explode(";",$formselect["src_forums$decID"]);
     }else{unset($formdata["src_forums$decID"]);}    
     
     if($formselect["src_decisionsType$decID"]){
     $formdata["src_decisionsType$decID"]=explode(';',$formselect["src_decisionsType$decID"]);
     }else{unset($formdata["src_decisionsType$decID"]);} 

/**********************************************************************/
   $DecFrm_note= $dec->save_note($decID); 
/**********************************************************************/   
    $dec->config_date($formdata);
    $dateIDs=$dec->build_date($formdata);	
    $dateIDs=$dateIDs['full_date'];
    $date_UsrfrmIDs=$dec->build_usr_frm_date2($formdata);

    
/***********************CONFIG FOR VALIDATION******************************************************/
/***************************FORUMS***********************************************************/

if($formdata["new_forum$decID"])
$formdata["new_forum"]=$formdata["new_forum$decID"];



if($formdata["insert_forum$decID"])
$formdata["insert_forum"]=$formdata["insert_forum$decID"];


/******************************************************************************************/    
    
/***************************DECISION_TYPE***********************************************************/

if($formdata["new_decisionType$decID"])
$formdata["new_decisionType"]=$formdata["new_decisionType$decID"];



if($formdata["insert_decisionType$decID"])
$formdata["insert_decisionType"]=$formdata["insert_decisionType$decID"];


/******************************************************************************************/    
    
/*********************************************************************/	
 if($dec->validate_data_ajx($formdata,$dateIDs)){
/*********************************************************************/     
     
    if($forumsIDs=$dec->save_forum_ajx($formdata)){
    	//$formdata['dest_forums']=$forumsIDs;
	 	if($catIDs=$dec->save_category_ajx($formdata)){

			if($decID=$dec->update_dec1($formdata)) {
				
			 if(array_item($formdata,"dest_forums$decID"))
			 $dec->conn_user_Decforum($decID,$date_UsrfrmIDs,$formdata);//$frmNames_dest= conn rel_user_Decforum new forum to update
		 					
				if($dec->conn_forum_dec($decID,$forumsIDs,$mode,$DecFrm_note,$formdata)){
					if($dec->conn_cat_dec($decID,$catIDs)){
						 
						unset($formdata['multi_year']);
						unset($formdata['multi_month']);
						unset($formdata['multi_day']);

						$formdata['dateIDs']=$dateIDs;
						return $formdata;
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
	 
	$formdata['dynamic_5b']=1;
	global $db;
	$dec=new decisions();
 
    
    $dec->config_date($formdata);
    $dateIDs=$dec->build_date($formdata);	
    $dateIDs=$dateIDs['full_date'];
    
	 
    
    
 	if($dec->validate_data($formdata,$dateIDs)){
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
		
		if ($formdata['new_category'] && $formdata['new_category']!='none'
		&& $formdata['category'][0] && $formdata['category'][0]!='none' ){
			unset($formdata['category']);

		}
/*********************************************************************************************/
				
			
			
		// try to validate and save date
		$db->execute("START TRANSACTION");
		if($forumsIDs=$dec->save_forum($formdata)){
			if($catsIDs=$dec->save_category($formdata)){
			  $dec->link();
				if ($dec->add_decision($formdata,$forumsIDs,$catsIDs,$dateIDs)) {
					$decID=$formdata['decID'];
					
					 
					$db->execute("COMMIT");
					
					return true;
				}
			 
		 }
		}	
	}else{
		$db->execute("ROLLBACK");
		 $formdata = FALSE;
		return false;
	}


}

/***********************************************************************/
/******************************************************************************/
function take_data_decision($formdata){
 
	global $db;
    $formdata['dynamic_5c']=1;
     $mode='update';
    
	$dec=new decisions();
	 $decID=$formdata['decID'];
     $formselect=$dec->read_decision_data2($formdata['decID']);
  
     $formdata['parentDecID']=$formselect['parentDecID'];
     
     if($formselect['parentDecID1'])
     $formdata['parentDecID1']=$formselect['parentDecID1'];
     
     
     if($formselect["src_forums$decID"]){
     $formdata["src_forums$decID"]=explode(";",$formselect["src_forums$decID"]);
     }else{unset($formdata["src_forums$decID"]);}    
     
     if($formselect["src_decisionsType$decID"]){
     $formdata["src_decisionsType$decID"]=explode(';',$formselect["src_decisionsType$decID"]);
     }else{unset($formdata["src_decisionsType$decID"]);} 

/**********************************************************************/
   $DecFrm_note= $dec->save_note($decID); 
/**********************************************************************/   
    $dec->config_date($formdata);
    $dateIDs=$dec->build_date($formdata);	
    $dateIDs=$dateIDs['full_date'];
    $date_UsrfrmIDs=$dec->build_usr_frm_date2($formdata);
/*********************************************************************/	
 if($dec->validate_data_ajx($formdata,$dateIDs)){
/*********************************************************************/     
     
//    if($forumsIDs=$dec->save_forum_ajx($formdata)){
//	 	if($catIDs=$dec->save_category_ajx($formdata)){
//
//			if($decID=$dec->update_dec1($formdata)) {
//				
//			 if(array_item($formdata,"dest_forums$decID"))
//			 $dec->conn_user_Decforum($decID,$date_UsrfrmIDs,$formdata);//$frmNames_dest= conn rel_user_Decforum new forum to update
//		 					
//				if($dec->conn_forum_dec($decID,$forumsIDs,$mode,$DecFrm_note,$formdata)){
//					if($dec->conn_cat_dec($decID,$catIDs)){
						 
						unset($formdata['multi_year']);
						unset($formdata['multi_month']);
						unset($formdata['multi_day']);

						$formdata['dateIDs']=$dateIDs;
						return $formdata;
					  // }		
					// }
				//}
			// }
		//}
	}
	return false;
}


/*********************************************************************************/









function cancel_session(){
	$dec=new decisions();
	unset($_SESSION['decID']);
	$dec->link();
}
function link1(){
	$dec=new decisions();
	$dec->link_b();
	 build_form_dec_ajx($formdata); 
	 $dec->print_form_paging_b();
	return true;
}


html_footer();
 
?>