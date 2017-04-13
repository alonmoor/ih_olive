<?php

include ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
require_once ("../lib/model/decisions_class.php");
global $lang;   

$showform=TRUE;

 

//            if($_POST['form']['btnLink'] ) {
//            $_POST['mode']="link";
//            $_REQUEST['mode']="link";
//            }

            
            if(!empty($_POST['form']['btnLink1']) && $_POST['form']['btnLink1'] ) {
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

            if(!empty($_POST['form']['btnLink4']) && $_POST['form']['btnLink4'] ) {
            $_POST['mode']="cancel";
            $_REQUEST['mode']="cancel";
            }      
            	
            if(!empty($_POST['form']['btnTodo']) && $_POST['form']['btnTodo'] ) {
            $_POST['mode']="todo_list";
            $_REQUEST['mode']="todo_list";
            }   

            if(!empty($_POST['form']['submitbutton']) && $_POST['form']['submitbutton'] ) {
            $_POST['mode']=$tmp =(array_item($_POST['form'], "decID") ) ? "update":"save" ;
            $_REQUEST['mode']=$_POST['mode'] ;
            }      
  
if( ! isAjax() )
  html_header();
?>     
<script type="text/javascript">
//turn_red_msg() ;
turn_red_error();
</script>  
<?php
$decID         = array_item($_REQUEST, 'id');
is_logged();
 

$page          = array_item($_REQUEST, 'page');
if(!$page || $page<1 || !is_numeric($page))
$page=1;
elseif($page>100)
$page=100;

/********************************************************************************/
switch ($_REQUEST['mode'] ) {
	case "insert":

 	
   
		insert_dec($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
		break;

  	
  	case  "link_second":
  		global $db;
  		if(!$_SESSION['decID'] ){
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
  		  
  		  
  		  if($rows[0]->parentDecID1 && $rows[0]->parentDecID1!=null ){ 
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
	
	
	 case  "read_subtitle":
     			$formdata =read_subtitle($_GET['editID']);
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
		
		if(array_item($_POST,'arr_dest_decisionsType') && (is_array($_POST['arr_dest_decisionsType'])  )  ){
		  $formdata['dest_decisionsType']=$_POST['arr_dest_decisionsType'];	
		}	
/*********************************************************************************/			
			$dec=new decisions();  

            $formdata1 =$_POST['form'];
            
            
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

/**************************************************************/            
            if(!$formdata=update_decision($formdata)){        /*
/**************************************************************/            	
				echo "נכשל בעדכון";
				
				
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
			//$formdata['dec_date']=$_POST['form']['dec_date'];
						list($year_date,$month_date, $day_date) = explode('-',$formdata['dec_date']);
						if(strlen($year_date)>3 ){
						$formdata['dec_date']="$day_date-$month_date-$year_date";			 
			}		
		 show_list($formdata);	
		}
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
/*******************************************************************/		
		if(!validate($formdata )){                                 /*
/*******************************************************************/
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
			 
		show_list($formdata);
		}else{
			$dec=new decisions();
			$dec->print_form_paging(); 
			//show_list($_POST['form']);
		}		
	break;
	
//---------------------------------------------------------------------------------	
	case "realy_delete":
			
//		real_del($_POST['form']);
//		$showform=FALSE;

		
		if(isset($_REQUEST['delete'])){  
   	   
  	  $formdata['decID']=$_REQUEST['decID'];
  			  //real_del($formdata);
  			  real_del($_POST['form']);
  		 }else{	
		if (!(real_del($_POST['form'])))
		  $formdata=FALSE;
		 show_list($formdata);
  		 }		
		

    break;
    
//---------------------------------------------------------------------------------    
	case "clear":
			
		//show_list($formdata);
		link1();
	break;
	case "delete":
		if (($_GET['deleteID'])){
			delete_dec($_GET['deleteID']);//subcategories
		}else{
			delete_dec_form($_POST['form']);
		}

	break; 
//---------------------------------------------------------------------------------	
	case "edit_dec":
		$d =new decisions();
		$decID=$_REQUEST['decID'];
		$d->print_form($page,$decID);
        
	break; 
	case "find":
		require_once 'find3.php';
        
	break; 
//---------------------------------------------------------------------------------	
	case "todo_list":

			$formdata=$_POST['form'];
			$formdata['mode']=$_POST['mode'];
			$formdata['todo_item']=$_POST['todo_item'];
			$formdata['task']=$_REQUEST['task'];
			$formdata['Submit']=$_POST['Submit'];
			$formdata['forum_decision']=$formdata['forum_decision'][0];
			$formdata['category']=$formdata['category'][0];
          
            
            if(!isset($_SESSION['todo']))
               {
            	// default to do 
	            $todo=array();
	            $done=array();
	           
	            
	            $_SESSION['todo']=$todo;
	            $_SESSION['done']=$done;
	            
	          
              } else {
	           $todo=$_SESSION['todo'];
	           $done=$_SESSION['done'];
	        }

//our controlling variable
$task=isset($_REQUEST['task'])?$_REQUEST['task']:'view';
			
  switch ($task ) { 
	case "add": {
		$id = end(array_keys($todo)) + 1;
		$_SESSION['id']=$id;
		$_SESSION['todo'][$id]=$_POST['todo_item'];
		//header("Content-type: text/javascript;");
		 $Z =$projax->escape(show_item($id,$_POST['todo_item'])); 
		 $X= $projax->insert_html('bottom','todolist',$Z/*$projax->escape(show_item($id,$_POST['todo_item']))*/)."\n";
		 $Y=$projax->visual_effect('highlight','todo_'.$id);
	     show_list($formdata);
	     return;
		}
		
	case "delete": {
		unset($_SESSION['todo'][$_GET['id']]);
		//header("Content-type: text/javascript;");
		echo $projax->remove('todo_'.$_GET['id']);
		show_list($formdata);
		return;
		}	
		
	case "reset": {
		session_destroy();
//		UNSET($_SESSION['todo']);
//		UNSET($_SESSION['done']);
	    // header("Content-type: text/javascript;");
		 $projax->replace_html('todolist','')."\n";
		 $projax->replace_html('donelist','');
	  // show_list($formdata);
	   return;
		}		
//---------------------------------------------------------------------------------		
	case "done": {
		$id = end(array_keys($done)) + 1;
		$_SESSION['done'][$id]=$_SESSION['todo'][$_GET['id']];
		unset($_SESSION['todo'][$_GET['id']]);
		//header("Content-type: text/javascript;");
		echo $projax->remove('todo_'.$_GET['id'])."\n";
		echo $projax->insert_html('bottom','donelist',"<li id=\"done_$id\">".$_SESSION['done'][$id]."</li>")."\n";
		echo $projax->visual_effect('highlight','done_'.$id);
		show_list($formdata);
		return;
		}		
       }

  	

	
		break;
//---------------------------------------------------------------------------------	
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
			//if()
			
			//$dec->subcats  =unserialize( urldecode(array_item($_REQUEST, 'subcats')));
			$decID=$_REQUEST['decID'];
			$dec->print_form();
		}
}


/************************************************************************************************/

function delete_dec($deleteID){
	global $db;

	$d=new decisions();
//$sql="select parentDecID from decisions where decID=$deleteID";
//$rows=$db->queryObjectArray($sql);
//$parent=$rows[0]->parentDecID;	
//if($parent=='11')
//$d->print_decision_entry_form1($deleteID);
//else
//$d->print_decision_entry_form1($parent);	
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
//    if($parent=='11'){
//    $dec->print_decision_entry_form1($parent);
//    }else{
    $dec->print_decision_entry_form1($formdata['decID']);	
//    }
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
	// if(array_item($formdata, "btnReallyDelete")) {
	// delete decision
	if(array_item($formdata,'decID')){
		$formdata=$dec->read_decision_data($formdata['decID']);
		$db->execute("START TRANSACTION");
		//if($dec->delete_decision($formdata))
		if($dec->del_decision($formdata['decID'])){
		$db->execute("COMMIT");
		//$dec->link();
		$formdata=false;
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
	global $db;
	$d=new decisions();
	$d->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);
	
	
	if(!$insertID && is_numeric($insertID))
	$insertID=$_GET['insertID'];
	
	
	//$d->add_decision($formdata,$forumIDs,$catIDs,$dateIDs);
	$formdata['insertID']=$insertID  ;
	$d->link_div();

	
$sql="select parentDecID1 from decisions where decID=$insertID";
  if($rows=$db->queryObjectArray($sql)  ){
  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
  $parent=	$rows[0]->parentDecID1;
  	$d->print_decision_entry_form1($parent);
  	}
  }

  
  $d->print_decision_entry_form1($insertID);
  
	 build_form($formdata);
	$d->print_form_paging() ;
}


/************************************************************************************************/
function insert_multi_dec($insertID,$submitbutton,$subcategories){
	 
}


/************************************************************************************************/
function  show_list($formdata){
	$dec=new decisions();
	//if(!(array_item($_POST,'mode' )=='update') ){
	
	
	//$dec->print_decision_entry_form1($formdata['decID']);	
//	}
	$dec->link_div();
	build_form($formdata);
	$dec->print_form_paging();
	echo '<br/><br/>',"\n";
//	$dec->link();
}
/****************************************************************************/
function read_decision($editID){
	global $db;
	$dec=new decisions();
    if($editID==11) {
			echo "<br />רשומת אב אין פרטים ספציפיים   .\n";
			$dec->link_div();
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
//	if($formdata['parentDecID']=='11')

$sql="select parentDecID1 from decisions where decID=$editID";
  if($rows=$db->queryObjectArray($sql)  ){
  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
  $parent=	$rows[0]->parentDecID1;
  	$dec->print_decision_entry_form1($parent);
  	}
  }
	
//     $dec->print_decision_entry_form1($editID);
//    else
//    $dec->print_decision_entry_form1($formdata['parentDecID']);
    
//$qwerty=urlencode($formdata); 
	 build_form($formdata);
	// $dec->link();
	$dec->print_form_paging();
	return  TRUE;


}

/******************************************************************************/
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
  <form  id="dec_form_tip">     
       
    <table id="table_window"   align="center" style="width:20%;">    
 
    <?php 
    
    
  echo '<tr><td class="myformtd">'; 
	     form_label1("תאור ההחלטה:",true);
       form_textarea("subtitle", array_item($formdata, "subtitle"), 40,10 , 1);
 echo '</td></tr>';
    ?>   
 
    </table>
    </form>
    <?php  
exit();
	//return  TRUE;


}

/******************************************************************************/
function read_befor_link($formdata){
	global $db;
	$dec=new decisions();
		//if(array_item($formdata, "btnLink"))
		  $dec->link();
	      //$dec->print_form_dec($formdata['decID'] );
	      $decID=$formdata['decID'];
	      $dec->print_decision_entry_form1($decID);
	       $dec->print_form_paging($formdata['decID']);
	      
	      
	      //$dec->print_form2($formdata['decID'] );
	     
	       
	      
	  
		return true;
}

/******************************************************************************/
function read_after_cancle($formdata){
	global $db;
	$dec=new decisions();
		 
		  $dec->link();
	       
	      $decID=$formdata['decID'];
 	     // $dec->print_decision_entry_form1($decID);
	      $formdata=$dec->read_decision_data($decID);
	      build_form($formdata);
	       $dec->print_form_paging();
		return true;
}

/******************************************************************************/
function read_befor_link2($formdata){
	global $db;
	$dec=new decisions();
		//if(array_item($formdata, "btnLink"))
		  $dec->link();
	      //$dec->print_form_dec($formdata['decID'] );
	      $decID=$formdata['decID'];
	      $_SESSION['flag_link2']=true;
	      
	      $bar='link2';
          $query_string =    'flag=' . urlencode($bar);
         //  echo '<a href="find3.php?' . htmlentities($query_string) . '">';
	       require_once 'find3.php' ;
	   //  $dec->redirect(‪ROOT_DIR.'/admin/find3.php'‬);
	     
//	      $dec->print_decision_entry_form1($decID);
//	      $dec->print_form2($formdata['decID'] );
	     //require_once 'dec_edit.php';
	     //print_form();
	     //$dec->print_form();
	       
	      
	  
		return  true ;
}

/******************************************************************************/
function read_link($formdata){
     global $db;
	$dec=new decisions();
	$formdata=$dec->read_decision_data3($formdata['decID'],$formdata['insertID']);	
	
    $dec->conn_Parent_second($formdata); 
    $dec->link();	
//    $dec->print_decision_entry_form3  ($formdata['parentDecID1'] );
//	$dec->print_decision_entry_form3  ($formdata['decID'] );
  
	$dec->print_decision_entry_form1  ($formdata['parentDecID1'] );
 //	$dec->print_decision_entry_form1  ($formdata['decID'] );
 	?>
    <input type=hidden name="decID" id="decID" value="<?php echo $formdata['decID']?>" />
   
    <?php   
    $formdata=$dec->read_decision_data($formdata['decID']);
    build_form($formdata);
    $dec->print_form_paging();
	//return $formdata;
	return true;
	
}


/************************************************************************************************/

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

	$dec=new decisions();
	 $formdata['dynamic_5']=1;
	 $mode='update';
	 $decID=$formdata['decID'];
	 
     $formselect=$dec->read_decision_data2($formdata['decID']);
     $formdata['parentDecID']=$formselect['parentDecID'];
     if($formselect['parentDecID1'])
     $formdata['parentDecID1']=$formselect['parentDecID1'];
     
     $formselect['src_forums']=$formselect['src_forums']?$formselect['src_forums']:$formselect["src_forums$decID"];
     if($formselect['src_forums']){
     $formdata['src_forums']=explode(';',$formselect['src_forums']);
     }
     if($formselect['src_decisionsType']) { 
     $formdata['src_decisionsType']=explode(';',$formselect['src_decisionsType']);
     }
/**********************************************************************/
 $DecFrm_note= $dec->save_note($decID);      
/**********************************************************************/     
      $dec->config_date($formdata);
      $dateIDs=$dec->build_date($formdata);	
      $dateIDs=$dateIDs['full_date'];
      $date_UsrfrmIDs=$dec->build_usr_frm_date($formdata);
      

	
 if($dec->validate_data($formdata,$dateIDs)){
/*********************************************************************/     
     
     if($forumsIDs=$dec->save_forum($formdata)){
		if($catIDs=$dec->save_category($formdata)){

if($decID=$dec->update_dec1($formdata)) {

 if(array_item($formdata,'dest_forums'))$dec->conn_user_Decforum($decID,$date_UsrfrmIDs,$formdata);
	
	if($dec->conn_forum_dec($decID,$forumsIDs,$mode,$DecFrm_note,$formdata)){
		if($dec->conn_cat_dec($decID,$catIDs,$formdata)){
			 
	//	$dec->link_div();
			$sql="select parentDecID1 from decisions where decID=$decID";
				  if($rows=$db->queryObjectArray($sql)  ){
				  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
				        $parent=$rows[0]->parentDecID1;
				     	$dec->print_decision_entry_form1($parent);
				  	}
				  }
				  
					// 	$dec->print_decision_entry_form1($formdata['decID']);	
						$dec->message_update($formdata,$decID);
												
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
	//if(($editID =$dec->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
	//$formdata = array_item($_POST, "form");
	global $db;
	$dec=new decisions();
//	$dec->link();
//$dec->setFormdata($formdata);
    
    $dec->config_date($formdata);
    $dateIDs=$dec->build_date($formdata);	
    $dateIDs=$dateIDs['full_date'];
    
	 //$dateIDs= $dateIDs? !is_null($dateIDs) : $formdata['dec_date'] ; 
    $formdata['dec_level']=explode(';',$formdata['dec_level']);
    $formdata['vote_level']=explode(';',$formdata['vote_level']);
    
    
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
						
					 
					//$db->execute("COMMIT");
					
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
	unset($_SESSION['decID']);
	$dec->link();
	$formdata=false;
	build_form($formdata);
	$dec->print_form_paging();
}
function link1(){
	$dec=new decisions();
	$dec->link();
	 build_form($formdata); 
	 $dec->print_form_paging(); 
	return true;
}

function show_item($num,$text){
	global $projax;
	return "<li id=\"todo_$num\"
	onmouseover=\"".$projax->show("actions_".$num)."\" 
	onmouseout=\"".$projax->hide("actions_".$num)."\">
	$text	
	<span id=\"actions_$num\" style=\"display:none\">".
	$projax->link_to_remote('<img src="'.IMAGES_DIR.'/done.gif" border="0" title="משימה שבוצעה" />',array('url'=>'dynamic_5?mode=todo_list&task=done&id='.$num)).
	$projax->link_to_remote('<img src="'.IMAGES_DIR.'/delete.gif" border="0" title="מ" />',array('url'=>'dynamic_5?mode=todo_list&task=delete&id='.$num)).
	
	"</span>
	</li>";
}
/********************************************************************************************/
function show_todo($formdata){
 //$todo=new TODOLIST($formdata);
 // $todo->show_task_list($formdata);	
	
//$lang=new Lang();s
//$lang->show_task_list1();
 
}
/**********************************************************************************************/

//if(!isAjax())
html_footer();
 
?>