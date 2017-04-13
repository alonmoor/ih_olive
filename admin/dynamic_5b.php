<?php

require_once ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
require_once ("../lib/model/decisions_class.php"); 
 
global $lang;   

$showform=TRUE;
           
 if( ! isAjax() )
  html_header();  

?>  
  
<script type="text/javascript">

turn_red_error();
</script>  
<?php



if( isset($_GET['vlidInsert']) && ( array_item($_REQUEST,'vlidInsert')== 'chack_insert')   ){		   
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
			||    $parents[$insertID]== $decID ){
			 
			 
				$t['list'] = array();		
				 
					$t['list'][0]  = 'fail';
					
				echo json_encode($t);
				exit;
				
			}
			
		} 
		
		
		if($insertID==$decID){

		
			$t['list'] = array();		
			
				$t['list'][0] = 'fail';
				
		
					
			echo json_encode($t);
			exit;
		
		
		} 
		
		
		
				$t['list'][0] = 'succeeded';
				$t['list']['insertID']=$insertID;
				echo json_encode($t);
				exit;
			 	
	
	 
 	
}
/*************************************************************************************************/
     
 elseif(array_item($_REQUEST,'mode')== 'change_insert_b'){		 
			 

            
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
			 $(document).ready(function() { 
			    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
			    fail.error=true;
			    return FALSE;
			 });
			 </script>
 
			 <?php 
			 
			 
			 exit;
			}
			
		} 
		
		
		if($insertID==$decID){
			?>
			 <script>
			 $(document).ready(function() { 
			    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
			    fail.error=true;
			    return FALSE;
			 });
			 </script>
 
			 <?php 
			
			 exit;
		   }	
/************************************************************************************************/
        $dec=new decisions();
       $dec->update_dec_parent($insertID, $decID);  
    //    $dec->print_decision_entry_form1_b($decID);
 	      
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
 $formdata["dest_decisionsType"] = $formdata["dest_decisionsType$decID"] ;
 $formdata["dest_forums"] = $formdata["dest_forums$decID"] ;
    $formdata['type'] = 'success';
	$formdata['message'] = 'עודכן בהצלחה!';
       $dec->print_decision_entry_form1_b($decID); 
	echo json_encode($formdata);
      
 	
   exit;		      
       
       
       
       
       
/*********************************************************************************************/       
//      echo json_encode($formdata);
//       exit;  
   }          
/******************************************************************************************************/

elseif( (isset($_GET['cancle'])) && array_item($_GET,'decID')!=null ){
		//	$cancel['mode']=explode(',',array_item($_POST,'mode'));
			$_REQUEST['mode']='cancel';//$cancel['mode'][0];
			 		
            }   






if(array_item($_POST,'mode') && array_item($_POST,'mode')!=null ){
			$cancel['mode']=explode(',',array_item($_POST,'mode'));
			$_REQUEST['mode']=$cancel['mode'][0];
			 		
            }   

            if(array_item($_POST,'delete') && array_item($_POST,'delete')!=null ){
			$del['mode']=explode(',',array_item($_POST,'delete'));
			$_POST['mode']=$del['mode'][0];
			$_REQUEST['mode']=$del['mode'][0];
			$_POST['decID']=$del['mode'][1];
			$_REQUEST['decID']=$del['mode'][1];
			 		
            }   
            if($_POST['conn_second_by_paging'] ) {
            $_POST['mode']="link_second";
            $_REQUEST['mode']="link_second";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }      
            
            
            if($_POST['conn_root'] ) {
            $_POST['mode']="conn_root";
            $_REQUEST['mode']="conn_root";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }      
            
            if($_POST['form']['btnLink1'] ) {
            $_POST['mode']="link_second";
            $_REQUEST['mode']="link_second";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }      
            
            
            if($_POST['form']['btnLink2'] ) {
            $_POST['mode']="find";
            $_REQUEST['mode']="find";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }     

            if($_POST['form']['btnLink3'] ) {
            $_POST['mode']="link_second";
            $_REQUEST['mode']="link_second";
            unset($_SESSION['decID']);
            unset($_SESSION['mult_dec_ajx']);
            }    

            if($_POST['form']['btnLink4'] ) {
            $_POST['mode']="cancel";
            $_REQUEST['mode']="cancel";
            }      
            	
            if($_POST['form']['btnTodo'] ) {
            $_POST['mode']="todo_list";
            $_REQUEST['mode']="todo_list";
            }   

            if($_POST['form']['submitbutton'] ) {
            $_POST['mode']=$tmp =(array_item($_POST['form'], "decID") ) ? "update":"save" ;
            $_REQUEST['mode']=$_POST['mode'] ;
            }      
  
            
            
            
            
            
$decID         = array_item($_REQUEST, 'id');
is_logged();
 

//$page          = array_item($_REQUEST, 'page');
//if(!$page || $page<1 || !is_numeric($page))
//$page=1;
//elseif($page>100)
//$page=100;

/********************************************************************************/
switch ($_REQUEST['mode'] ) {
	 
 
	case "insert":
		
		insert_dec($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
		break;

	case "change_insert_b":
		 
      global $db;   
		 
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
			 $(document).ready(function() { 
				    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
				    fail.error=true;
				    return FALSE;
				 });
			 </script>

			 <?php  
			
			 exit;
			}
		}
		if($insertID==$decID){
			?>
			 <script>
			 $(document).ready(function() { 
				    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
				    fail.error=true;
				    return FALSE;
				 });
			 </script>

			 <?php   
			
			 exit;
		}	

$dec=new decisions();
$dec->update_dec_parent($insertID, $decID);
$dec->print_decision_entry_form1_c($decID);
   exit;        
		   
		break;
/******************************************************************************/
 	case  "conn_root":
  		global $db;
  		$dec=new decisions();
  		$decID =$_REQUEST['conn_root'];
  		$sql="update decisions set parentDecID='11' where decID=$decID ";
  	if($db->execute($sql)){	
  	$dec->print_decision_entry_form1_b  ($decID );
  	}else{
  		return FALSE;
  	}			
		
	break;		
/******************************************************************************/	
  	case  "link_second":
  		global $db;
  		
 		$dec=new decisions();
  		
  $insertID =$_REQUEST['insertID'];
		$decID =$_REQUEST['decID'];
 
		
if($decID==$insertID){
 ?>
			 <script>
			 $(document).ready(function() { 
				    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
				    fail.error=true;
				    return FALSE;
				 });
			 </script>

			 <?php
			
			 exit;	
}

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
			 $(document).ready(function() { 
				    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
				    fail.error=true;
				    return FALSE;
				 });
			 </script>

			 <?php
			
			 exit;
			}
		}elseif($insertID==$decID){
			?>
			 <script>
			 $(document).ready(function() { 
				    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
				    fail.error=true;
				    return FALSE;
				 });
			 </script>
          
			<?php
		
			 exit;
		}			
  		
  		
  		
  		
  		
  		
  		
  		
/***************************************************************************/  		
  		$formdata['decID']=$_REQUEST['decID'];
		
		
		if(!$_SESSION['decID']){
  		$_SESSION['decID']=$_REQUEST['form']['decID']?$_REQUEST['form']['decID']:$formdata['decID'];
  		}
  		if(isset($_REQUEST['form']['btnLink3'])){
  			if (isset($_REQUEST['form'])){
  			  read_befor_link2($_POST['form']);
  			}
  		}elseif(isset($_REQUEST['conn_second_by_paging'])){  		 
  			 
  			 $formdata['decID']=array_item($_POST ,'conn_second_by_paging' );
  			  read_befor_link($formdata);
  		 }elseif (isset($_REQUEST['form'])){
  		  read_befor_link($_POST['form']);
        }else{
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
  		
  		//$cancel['mode']=explode(',',array_item($_POST,'mode'));
		$decID=$_GET['decID'];//$cancel['mode'][1];
  		  $sql="select parentDecID1 from decisions where decID= $decID"  ;
  		   if($rows=$db->queryObjectArray($sql )){
  		   	if($rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)){ 
  		  	$sql="update decisions set parentDecID1=null where decID= $decID"   ;
  		  	if(!$db->execute($sql))
  		  	return FALSE;
  		  }
  	   }
  	  $formdata['parentDecID1']=$rows[0]->parentDecID1;
  	  echo json_encode($formdata); 
  	//   $formdata['decID']=$decID;
  		 // read_after_cancle($formdata);
  		 exit;
		break;
     case  "read_data":
     			$formdata =read_decision($_GET['editID']);
	break;
	case "update":
		if($_GET['updateID']) {
				update_dec($_GET['updateID']);
		}else{
 //------------------------------------------------------------------------------------			
			if($_POST['form']){
				foreach($_POST['form']  as $key=>$val){
					if ($val=='none' || $val== "" )
					unset ($_POST['form'][$key]);
						
				}
					
			}
//------------------------------------------------------------------------------------		
/*********************************************************************************/
			if($_POST['form']['dest_forums'][0]== 'none')
			unset($_POST['form']['dest_forums'][0] );

			if(count($_POST['form']['dest_forums'])==0  )
			unset($_POST['form']['dest_forums'] );

			if($_POST['form']['dest_forums'][0]== 'none')
			unset($_POST['form']['dest_forums'][0] );

			if(count($_POST['form']['dest_forums'])==0  )
			unset($_POST['form']['dest_forums'] );


			if($_POST['arr_dest_forums'][0]== 'none')
			unset($_POST['arr_dest_forums'][0] );

			if(count($_POST['arr_dest_forums'])==0  )
			unset($_POST['arr_dest_forums'] );
			 
/*********************************************************************************/
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
		$formdata=$_POST['form'];
		if(array_item($_POST,'arr_dest_forums') && (is_array($_POST['arr_dest_forums'])  )  ){
		  $formdata['dest_forums']=$_POST['arr_dest_forums'];	
		}	
/*********************************************************************************/			
			$dec=new decisions();  
			$formdata1 =$dec->read_decision_data($_POST['form']['decID']);

			
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
			
			
			$formdata['dec_Allowed']=array_item($_POST,'dec_allowed');
			$formdata['dec_status']=array_item ($_POST,'dec_status');
			
			
			
			
/**********************************************************/			
			if(!$formdata=update_decision($formdata)){    /*
/**********************************************************/				
				echo "נכשל בעדכון";
				
				$formdata['dec_date']=$_POST['form']['dec_date'];
				$formdata['fail']=1;
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['dec_date']);
				if(strlen($year_date)>3 ){
				$formdata['dec_date']="$day_date-$month_date-$year_date";
				}
				
				
				show_list($formdata1);
				return;
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
		
//------------------------------------------------------------------------------------			
			if($_POST['form']){
				foreach($_POST['form']  as $key=>$val){
					if ($val=='none' || $val== "" )
					unset ($_POST['form'][$key]);
						
				}
					
			}
//------------------------------------------------------------------------------------				
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
			 
/*********************************************************************************/			 
			 
if($formdata["dest_forums"] && $formdata["dest_forums"]!='none' 
  && is_array($formdata["dest_forums"])  && (count($formdata["dest_forums"])>0)   ){		 
			 
		$i=0;	 
 		 foreach($formdata['dest_forums'] as $forum){
 		 	
 		 	$formdata['dest_forums_test'][$i]=$forum;
 		 	$i++;
 		 }
 		 $formdata['dest_forums']= $formdata['dest_forums_test'];
 		 unset($formdata['dest_forums_test']);
  }	 
/****************************************************************************************/		
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
		
/*****************************************************/		
		if(!validate($formdata )){                   /*
/*****************************************************/			
			echo "נכשל בשמירה!!!!!";
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
			$formdata['mult_dec_ajx']=1; 
		show_list($formdata);
		}else{
//	 $dec=new decisions();		
//	build_form_dec_ajx($formdata);
//	$dec->print_form_paging_b();
			 $dec=new decisions();
			$dec->print_form_paging_b(); 
		}		
	break;
	
//------------------------------------------------------------------------------------------------	
	case "realy_delete":
   if(isset($_REQUEST['delete'])){  
   	   
  	  $formdata['decID']=$_REQUEST['decID'];
  			  real_del($formdata);
  		 }else{	
		if (!(real_del($_POST['form'])))
		  $formdata=FALSE;
		 show_list($formdata);
  		 }		
		
		//$showform=FALSE;
         

    break;
//------------------------------------------------------------------------------------------------    
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
//------------------------------------------------------------------------------------------------	
	case "edit_dec":
		$d =new decisions();
		$decID=$_REQUEST['decID'];
		$d->print_form($page,$decID);
        
	break; 
	
//------------------------------------------------------------------------------------------------	
	
	
	case "find":
		$_SESSION['mult_dec_ajx']=1;
		require_once 'find3.php';
        
	break; 
//------------------------------------------------------------------------------------------------	
	case  "read_subtitle":
     			$formdata =read_subtitle($_GET['editID']);
	break;
//------------------------------------------------------------------------------------------------	
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
function read_subtitle($editID){
	global $db;
	$dec=new decisions();
    if($editID==11) {
			echo "<br />רשומת אב אין פרטים ספציפיים   .\n";
			$dec->link();
			return 0;
		}
	if(($editID =$dec->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
		
		$sql="select note from decisions where decID=$editID";
		$rows=$db->queryObjectArray($sql);
		if($rows)
		$formdata['subtitle'] = $rows[0]->note;

	}

?>
<!-- <fieldset style="background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white;width:95%;">החלטות עין השופט</h1></legend>-->
   
       
 
 
    <?php 
    
//    $formdata['subtitle']=explode('.',$formdata['subtitle']);
//    foreach ( $formdata['subtitle'] as $title){
//    	echo '<p>';
//    	echo  $title;
//    	echo '</p>';
//    	  
//    }
     echo  $formdata['subtitle'];
    //echo '</p>'; 
// echo '<table id="table_window"   align="center" style="width:20%;"> <table id="table_window"   align="center" style="width:20%;"> <tr><td class="myformtd">';      
//   form_textarea("subtitle", array_item($formdata, "subtitle"), 40,10 , 1);
// echo '</td></tr></table>';
     
 
	 return  TRUE;


}
function delete_dec($deleteID){
	global $db;

	$d=new decisions();
$sql="select parentDecID from decisions where decID=$deleteID";
$rows=$db->queryObjectArray($sql);
$parent=$rows[0]->parentDecID;	
 
$d->print_decision_entry_form1($deleteID);
build_delete_form1($deleteID) ;
//if(build_delete_form1($deleteID)){
//   $showform=FALSE; }
 
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
		//$formdata=$dec->read_decision_data($formdata['decID']);
		$db->execute("START TRANSACTION");
		 
		if($dec->del_decision($formdata['decID'])){
		$db->execute("COMMIT");
		 $formdata=false;
		 
		 
		//build_form_dec_ajx($formdata);
		$dec->link_div();
		build_form($formdata);
		$dec->print_form_paging_b();
		//exit;
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
	$formdata['mult_dec_ajx']=1;
	$d->link_div();
	echo '<fieldset class="my_pageCount" >'; 
	 $d->print_decision_entry_form1_c($insertID);
	 echo '</fieldset class="my_pageCount" >'; 
	// build_form_dec_ajx($formdata);
	 build_form($formdata);
	$d->print_form_paging_b();
}


/************************************************************************************************/
function  show_list($formdata){
	$dec=new decisions();
	$dec->link_div();
	
	echo '<br/><br/>',"\n";
	
	build_form($formdata);
	//build_form_dec_ajx($formdata);
	$dec->print_form_paging_b();
}
/****************************************************************************/
function read_decision($editID){
	global $db;
	$dec=new decisions();
    if($editID==11) {
			echo "</br>רשומת אב אין פרטים ספציפיים   .\n";
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
	$dec->link_div();
 
$sql="select parentDecID1 from decisions where decID=$editID";
  if($rows=$db->queryObjectArray($sql)  ){
  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
  $parent=	$rows[0]->parentDecID1;
  //$dec->print_decision_entry_form1_b($parent);
  $dec->print_decision_entry_form1_b($parent);
  	}
  }
	
   //  $dec->print_decision_entry_form1_c($editID);
 ?>
    <input type=hidden name="decID" id="decID" value="<?php echo $formdata['decID']?>" />
  <?php   
 if($formdata['dest_forums']) {
  
 foreach($formdata['dest_forums']  as $forum_decID){
  ?>
     <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
   <?php
   
   
   
   
   
   
   
   $sql="select managerID from forum_dec where forum_decID=$forum_decID";
   if($rows=$db->queryObjectArray($sql)){
   	$mgr=$rows[0]->managerID;
   	?>
     <input type=hidden name="mgr" id="mgr" value="<?php echo $mgr?>" />
   <?php
  
   }else $mgr=0;
// build_task_form2($formdata['decID'], $forum_decID, $mgr);
  
  }  
 }  

 
 
 
 
 
 
 
 
	build_form_dec_ajx($formdata);
	$dec->print_form_paging_b();
	return  TRUE;


}

/******************************************************************************/
function read_befor_link($formdata){
	global $db;
	$dec=new decisions();
		 
		  $dec->link_b();
	        //$userID=$_GET['userID']?$_GET['userID']:$userID; 
	      $decID=$formdata['decID'];//?$formdata['decID']:$formdata['second'];
	      $dec->print_decision_entry_form1_c($decID);
	       $dec->print_form_paging_b($formdata['decID']);
	      
	   
		return true;
}

/******************************************************************************/
function read_after_cancle($formdata){
	global $db;
	$dec=new decisions();

		  $dec->link_b();

	      $decID=$formdata['decID'];
 	      $dec->print_decision_entry_form1_c($decID);
	      $formdata=$dec->read_decision_data($decID);
	      build_form_dec_ajx($formdata);
	       $dec->print_form_paging_b();
		return true;
}

/******************************************************************************/

function read_befor_link2($formdata){
	global $db;
	$dec=new decisions();
		 
		  $dec->link_b();
	      
	      $decID=$formdata['decID'];
	      $_SESSION['flag_link2']=true;
	      
	      $bar='link2';
          $query_string =    'flag=' . urlencode($bar);
        
	      
	       require_once 'find3.php' ;
	
	      
	  
		return  true ;
}

/******************************************************************************/
function read_link($formdata){
     
   
   
	
	
    global $db;
	$dec=new decisions();
	$formdata=$dec->read_decision_data3($formdata['decID'],$formdata['insertID']);	
	
    $dec->conn_Parent_second($formdata); 
 
    
    
 
	$dec->print_decision_entry_form1_b  ($formdata['parentDecID1'] );
 
 	exit();
 	?>
    <input type=hidden name="decID" id="decID" value="<?php echo $formdata['decID']?>" />
   
    <?php   
    $formdata=$dec->read_decision_data($formdata['decID']);
    build_form_dec_ajx($formdata);
    $dec->print_form_paging_b();
 
	return true;	
	
	 
}


/************************************************************************************************/

function update_dec($updateID){
	$d=new decisions();
	$d->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories'],$_POST['deleteID'],$_GET['updateID']);
	$d->link_div();
	$d->update_decision_general();
 
	//$d->link_div();
}
 
/******************************************************************************/
function update_decision($formdata){
	global $db;
    $formdata['dynamic_5b']=1;
     $mode='update';
	$dec=new decisions();
	 
     $formselect=$dec->read_decision_data2($formdata['decID']);
     $formdata['parentDecID']=$formselect['parentDecID'];
     $formdata['parentDecID1']=$formselect['parentDecID1'];
     $formdata['src_forums']=$formselect['src_forums'];  
     $formdata1['src_decisionsType']=$formselect['src_decisionsType'];
     
/**********************************************************************/
     $DecFrm_note= $dec->save_note($decID); 
      $dec->config_date($formdata);
    $dateIDs=$dec->build_date($formdata);	
    $dateIDs=$dateIDs['full_date'];
    $date_UsrfrmIDs=$dec->build_usr_frm_date2($formdata);
	
 if($dec->validate_data ($formdata,$dateIDs)){
/*********************************************************************/     
     
     if($forumsIDs=$dec->save_forum($formdata)){
		if($catIDs=$dec->save_category($formdata)){

			if($decID=$dec->update_dec1($formdata)) {
 
//	 if(array_item($formdata,"dest_forums$decID")&& (count($frmNames_dest))>0)
//			 $dec->conn_user_Decforum($decID,$date_UsrfrmIDs,$formdata,$frmNames_dest,$frmNames_src);
             if(array_item($formdata,"dest_forums$decID"))
			 $dec->conn_user_Decforum($decID,$date_UsrfrmIDs,$formdata);

 
				if($dec->conn_forum_dec($decID,$forumsIDs,$mode,$DecFrm_note)){
					if($dec->conn_cat_dec($decID,$catIDs,$formdata)){
						 
						$dec->link_b();
		   $sql="select parentDecID1 from decisions where decID=$decID";
				  if($rows=$db->queryObjectArray($sql)  ){
				  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
				        $parent=	$rows[0]->parentDecID1;
				     	$dec->print_decision_entry_form1($parent);
				  	}
				  }
						$dec->print_decision_entry_form1_c($formdata['decID']);	
						$dec->message_update_b($formdata,$decID);
												
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
    
 $formdata['dec_level']=explode(';',$formdata['dec_level']);
 $formdata['vote_level']=explode(';',$formdata['vote_level']);
    
    
 	if($dec->validate_data($formdata,$dateIDs)){

 	$db->execute("START TRANSACTION");
		if($forumsIDs=$dec->save_forum($formdata)){
			if($catsIDs=$dec->save_category($formdata)){
			   $dec->link_div();
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
function cancel_session(){
	$dec=new decisions();
	$dec->link();
	$formdata=false;
	build_form($formdata);
	$dec->print_form_paging_b();
}
function link1(){
	$dec=new decisions();
	$dec->link_b();
	 build_form($formdata); 
	 $dec->print_form_paging_b(); 
	return true;
}


html_footer();
 
?>

