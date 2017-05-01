<?php

include ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
//require_once ("../lib/model/decisions_class.php");
require_once ("../lib/model/pdfs_class.php");
require_once ("../lib/model/UploadException.php");
require_once ("getproducts.php");
global $lang;   

$showform=TRUE;
            if(!empty($_POST['form']['btnLink1']) && $_POST['form']['btnLink1'] ) {
            $_POST['mode']="link_second";
            $_REQUEST['mode']="link_second";
            unset($_SESSION['pdfID']);
            unset($_SESSION['mult_dec_ajx']);
            }      
            if(!empty($_POST['form']['btnLink2']) && $_POST['form']['btnLink2'] ) {
            $_POST['mode']="find";
            $_REQUEST['mode']="find";
            unset($_SESSION['pdfID']);
            unset($_SESSION['mult_dec_ajx']);
            }     

            if(!empty($_POST['form']['btnLink3']) && $_POST['form']['btnLink3'] ) {
            $_POST['mode']="link_second";
            $_REQUEST['mode']="link_second";
            unset($_SESSION['pdfID']);
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
            $_POST['mode']=$tmp =(array_item($_POST['form'], "pdfID") ) ? "update":"save" ;
            $_REQUEST['mode']=$_POST['mode'] ;
            }


            if(!empty($_POST['form']['btnClear']) && $_POST['form']['btnClear'] ) {
                $_POST['mode']=$tmp =(array_item($_POST['form'], "pdfID") ) ? "update":"save" ;
                $_REQUEST['mode']=$_POST['mode'] ;
            }

if(!empty($_GET['mode']) && $_GET['mode'] && ($_GET['mode'] ==  'update' || $_GET['mode'] ==  'save') ) {
    $_GET['mode'] = $tmp =(array_item($_GET['mode'], "pdfID") ) ? "update":"save" ;
    $_REQUEST['mode']= $_GET['mode'] ;
}

if( ! isAjax() )
  html_header();
?>     
<script type="text/javascript">
//turn_red_msg() ;
turn_red_error();
</script>  
<?php
$pdfID         = array_item($_REQUEST, 'id');
is_logged();
 

$page          = array_item($_REQUEST, 'page');
if(!$page || $page<1 || !is_numeric($page))
$page=1;
elseif($page>100)
$page=100;

$_REQUEST['mode']  = isset( $_REQUEST['mode'] ) ? $_REQUEST['mode'] : 'default';
/********************************************************************************/
switch ($_REQUEST['mode'] ) {
    case "view_pdfs": // http://olive/admin/index.php?mode=view_pdfs&id=72da54f314fe325a1b5abc7287e8c372ec4c7dd6
//        if (isset($_GET['id']) && (strlen($_GET['id']) == 40) && (substr($_GET['id'], 0, 1) != '.') ) {
//            // Identify the file:
//            $file = PDF_DIR . $_GET['id'];
//            // Check that the PDF exists and is a file:
//            if (file_exists($file) && (is_file($file))) {
//                $pdf = new pdfs();
//                $pdf->view_pdfs($file);
//            } else {
//                $pdf = new pdfs();
//                $formdata = isset($_POST['form']) ? $_POST['form'] : false;
//                build_form($formdata);
//                $pdf->print_form_paging();
//                //show_list($_POST['form']);
//            }
//        }

//--------------------------------------------------------------------
        if( ! isAjax() ){
       global $dbc;
        $valid = false;
// Validate the PDF ID:
        if (isset($_GET['id']) && (strlen($_GET['id']) == 40) && (substr($_GET['id'], 0, 1) != '.') ) {

            // Identify the file:
            $file = PDF_DIR . $_GET['id'];

            // Check that the PDF exists and is a file:
            if (file_exists($file) && (is_file($file))) {

                // Get the info:
                $q = 'SELECT * FROM pdfs WHERE tmpName="' . mysqli_real_escape_string($dbc, $_GET['id']) . '"';
                $r = mysqli_query($dbc, $q);
                if (mysqli_num_rows($r) == 1) { // Ok!

                    // Fetch the info:
                    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

                    // Indicate that the file reference is fine:
                    $valid = true;

                    $GLOBALS['TEMPLATE']['content'] = ob_get_contents();
                    ob_end_clean();
                    ob_start();

                    // Send the content information:
                        header('Content-type:application/pdf');
                        header('Content-Disposition:inline;filename="' . $row['pdfName'] . '"');
                        $fs = filesize($file);
                        header("Content-Length:$fs\n");

                        // Send the file:
                        readfile($file);

                        exit();
                    $GLOBALS['TEMPLATE']['content'] = ob_get_contents();
                    ob_end_clean();
                    ob_end_flush();
                    }
                }
            }
        }

//---------------------------------------------------------------
        break;
//------------------------------------------------------------
    case "save":
        global $db;
        $formdata = isset($_POST['form']) ? $_POST['form'] : false;

        $files = isset($_FILES['pdf']) ? $_FILES['pdf'] : false;


        if(isset($_FILES['pdf'])){
            $i=0;
            foreach($_FILES['pdf']['type']  as $value){
                if ($value=='none' || $value== "" ) {
                    unset ($_FILES['pdf']['name'][$i]);
                    unset ($_FILES['pdf']['type'][$i]);
                    unset ($_FILES['pdf']['tmp_name'][$i]);
                    unset ($_FILES['pdf']['error'][$i]);
                    unset ($_FILES['pdf']['size'][$i]);
                }
                $i++;
            }



        foreach($_FILES['pdf'] as $key => $value){
            $i = 0;
            foreach($value as $val ){
                $formdata['files'][$key][$i] = $val;
                $i++;
            }
        }
    }
        if(isset($formdata['files']))
            $_FILES['pdf'] = $formdata['files'];

//-------------------all ready exist------------------------------------------

        $i=0;
        foreach($_FILES['pdf']['name']  as $value) {
            $sql = "SELECT COUNT(*) FROM pdfs " .
                "WHERE pdfName='$value'";
            if ($db->querySingleItem($sql) > 0) {
                unset ($_FILES['pdf']['name'][$i]);
                unset ($_FILES['pdf']['type'][$i]);
                unset ($_FILES['pdf']['tmp_name'][$i]);
                unset ($_FILES['pdf']['error'][$i]);
                unset ($_FILES['pdf']['size'][$i]);
            }
            $i++;
        }
        if(isset($formdata['files']) )  {
            $tmp_formdata = $formdata['files'];
            $formdata['files'] = '';
            if(sizeof($_FILES['pdf']['name']) >0) {

                foreach ($_FILES['pdf'] as $key => $value) {
                    $i = 0;
                    foreach ($value as $val) {
                        $formdata['files'][$key][$i] = $val;
                        $i++;
                    }
                }


                $_FILES['pdf'] = $formdata['files'];
            }
        }else{
            echo "NO AVAILABLE FILES";
            return ;
        }
//---------------------------------------------------------------------

        $formdata['form'] = isset($_POST['form']) ? $_POST['form'] : false;



        // $formdata['files'] =   $files;
        if(array_item ($_POST,'arr_dest_publishers') )
            $formdata['dest_publishers'] = isset($_POST['arr_dest_publishers']) ? $_POST['arr_dest_publishers'] : '';

        if(array_item ($_POST,'arr_dest_decisionsType') )
            $formdata['dest_decisionsType'] = $_POST['arr_dest_decisionsType'];


        if(!array_item ($_POST,'arr_dest_decisionsType')
            &&  isset($_POST['form']['src_decisionsType'][0]) && isset($_POST['form']['src_decisionsType']) &&   ($_POST['form']['src_decisionsType'][0]   )
            && is_array($_POST['form']['src_decisionsType']))
            $formdata['dest_decisionsType'] =  $_POST['form']['src_decisionsType'];



        if(isset($_POST['form']['src_forums'][0]) && isset($_POST['form']['src_forums']) && !array_item ($_POST,'arr_dest_publishers')
            &&  ($_POST['form']['src_forums'][0]   )
            && is_array($_POST['form']['src_forums']))
            $formdata['dest_publishers']=$_POST['form']['src_forums'];



        if(!validate($formdata )){
            echo " כניראה שהקובץ כבר קיים נכשל בשמירה!!!!!";
            $formdata=$_POST;
            $formdata['fail']=1;


            $formdata['dfp_Allowed']=  array_item ($_POST,'dfp_Allowed');
            $formdata['dfp_status']= array_item ($_POST,'dfp_status');


            show_list($formdata);
        }else{
            $pdf = new pdfs();
            build_form($formdata);
            $pdf->print_form_paging();
            //show_list($_POST['form']);
        }
        break;
    //------------------------------------------------------------
    case "insert":
        $insertID = (isset($_GET['insertID']) && $_GET['insertID']) ? $_GET['insertID'] : '';
        $submitbutton = (isset($_POST['submitbutton'])) && $_POST['submitbutton'] ? $_POST['submitbutton'] : '';
        $subcategories =   (isset($_POST['subcategories'])) && $_POST['subcategories'] ? $_POST['subcategories'] : '';


        insert_dec($insertID,$submitbutton,$subcategories);
		break;

  	
  	case "cancel":
         global $db;    
  		$pdfID=$_POST['form']['pdfID'];
  		  $sql="select parentDecID1 from decisions where pdfID= $pdfID"  ;
  		   if($rows=$db->queryObjectArray($sql )){
  		   	if($rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)){ 
  		  	$sql="update decisions set parentDecID1=null where pdfID= $pdfID"   ;
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

		if(isset($_GET['updateID']) && $_GET['updateID']) {

            update_dec($_GET['updateID']);

        } elseif(isset($_GET['pdfID']) && $_GET['pdfID']   ) {
                $pdfID = $_GET['pdfID'];
                update_dec($pdfID);

            }else if( (isset($_POST['pdfID']) && $_POST['pdfID'] ) ){
                $pdfID = $_POST['pdfID'];
                update_dec($pdfID);
		}else{

//------------------------------------------------------------------------------------
			if(isset($_POST['form']) && $_POST['form']){
				foreach($_POST['form']  as $key=>$val){
					if ($val=='none' || $val== "" )
					unset ($_POST['form'][$key]);

				}

			}
//------------------------------------------------------------------------------------		
			if(!empty($_POST['form']['dest_publishers'][0]) && $_POST['form']['dest_publishers'][0]== 'none')
			unset($_POST['form']['dest_publishers'][0] );

			if(!empty($_POST['form']['dest_publishers']) && count($_POST['form']['dest_publishers'])==0  )
			unset($_POST['form']['dest_publishers'] );

			if(!empty($_POST['form']['dest_publishers'][0]) && $_POST['form']['dest_publishers'][0]== 'none')
			unset($_POST['form']['dest_publishers'][0] );

			if(!empty( $_POST['form']['dest_publishers']) &&  count( $_POST['form']['dest_publishers'])==0  )
			unset($_POST['form']['dest_publishers'] );


			if(!empty($_POST['arr_dest_publishers'][0]) && $_POST['arr_dest_publishers'][0]== 'none')
			unset($_POST['arr_dest_publishers'][0] );

			if(!empty($_POST['arr_dest_publishers']) && count($_POST['arr_dest_publishers'])==0  )
			unset($_POST['arr_dest_publishers'] );
			 
/*********************************************************************************/
/*********************************************************************************/
			if(!empty($_POST['form']['dest_decisionsType'][0]) && $_POST['form']['dest_decisionsType'][0] == 'none')
			unset($_POST['form']['dest_decisionsType'][0] );

			if(!empty($_POST['form']['dest_decisionsType']) && count($_POST['form']['dest_decisionsType'])==0  )
			unset($_POST['form']['dest_decisionsType'] );

			if(!empty($_POST['form']['dest_decisionsType'][0]) && $_POST['form']['dest_decisionsType'][0] == 'none')
			unset($_POST['form']['dest_decisionsType'][0] );

			if(!empty($_POST['form']['dest_decisionsType']) && count($_POST['form']['dest_decisionsType'])==0  )
			unset($_POST['form']['dest_decisionsType'] );


			if(!empty($_POST['arr_dest_decisionsType'][0]) && $_POST['arr_dest_decisionsType'][0]== 'none')
			unset($_POST['arr_dest_decisionsType'][0] );

			if(!empty($_POST['arr_dest_decisionsType']) && count($_POST['arr_dest_decisionsType'])==0  )
			unset($_POST['arr_dest_decisionsType'] );
			 
/*********************************************************************************/    			
		$formdata=!empty($_POST['form']) ? $_POST['form'] : '';
		if(array_item($_POST,'arr_dest_publishers') && (is_array($_POST['arr_dest_publishers'])  )  ){
		  $formdata['dest_publishers']=$_POST['arr_dest_publishers'];	
		}	
		
		if(array_item($_POST,'arr_dest_decisionsType') && (is_array($_POST['arr_dest_decisionsType'])  )  ){
		  $formdata['dest_decisionsType']=$_POST['arr_dest_decisionsType'];	
		}	
/*********************************************************************************/			
			$pdf = new pdfs();  

            $formdata1 = isset($_POST['form']) ? $_POST['form'] : '';
            
            
/****************************************************************************************/		
		
if(isset($formdata['dest_publishers']) && is_array($formdata['dest_publishers']) &&   isset($formdata['dest_publishers']['0']) &&  !($formdata['dest_publishers'][0]) ){
$i=0;     
			foreach ($formdata["dest_publishers"] as $frm ){
			     	$form["dest_publishers"][$i]=$frm ;
			     	$i++;
			     }
			
$formdata["dest_publishers"]=$form["dest_publishers"];			
}
/***********************************************************************************/			
if(isset($formdata['dest_decisionsType']) && is_array($formdata['dest_decisionsType']) && !($formdata['dest_decisionsType'][0]) ){
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
				
				
			if(isset($_POST['form']['dec_date']) &&  $_POST['form']['dec_date']){
				$formdata1['dec_date']=$_POST['form']['dec_date'];
				$formdata1['fail']=1;
				
				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['dec_date']);
				if(strlen($year_date)>3 ){
				$formdata1['dec_date']="$day_date-$month_date-$year_date";
				}
			}	
				
			if(isset($_POST['arr_dest_publishers']) &&  $_POST['arr_dest_publishers']){
			  $formdata1['dest_publishers']=$_POST['arr_dest_publishers'];	
			}
			
			if(isset($_POST['arr_dest_decisionsType']) &&  $_POST['arr_dest_decisionsType']){
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

//---------------------------------------------------------------------------------	
	case "realy_delete":
			
//		real_del($_POST['form']);
//		$showform=FALSE;

		
		if(isset($_REQUEST['delete'])){  
   	   
  	  $formdata['pdfID']=$_REQUEST['pdfID'];
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
		$pdfID=$_REQUEST['pdfID'];
		$d->print_form($page,$pdfID);
        
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
//			if($showform && isset($_POST['form']['btnLink1']) && !($_POST['form']['btnLink1']) && $page<=1) {
    if($showform ) {
				$pdf= new pdfs();
				$formdata = array_item($_POST, "form");
				// input new or edit existing data?
				if(array_item($formdata, "pdfID")){
				echo "<h1>ערוך PDF</h1>";
				}else{
				echo "<h1>PDF הכנס   </h1>";
				}  
				// show form to input / edit data
				show_list($formdata);
		}elseif(isset($_POST['form']['btnLink1']) && $_POST['form']['btnLink1']  && $_POST['form']){
		   //  $pdf->print_form2($_POST['form']['pdfID']) ;
		}else{
           $pdf = new pdfs();
			$pdfID=isset($_REQUEST['pdfID']) ? $_REQUEST['pdfID'] : '';
			//$pdf->print_form();
		}
}


/************************************************************************************************/

function delete_dec($deleteID){
	global $db;

	$d=new decisions();
//$sql="select parentDecID from decisions where pdfID=$deleteID";
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

	$pdf = new pdfs();
    $sql="select parentDecID from decisions where pdfID= " . $db->sql_string($formdata['pdfID']) ; 
    $rows=$db->queryObjectArray($sql);
    $parent=$rows[0]->parentDecID;
    $pdfID=$formdata['pdfID'];	
//    if($parent=='11'){
//    $pdf->print_decision_entry_form1($parent);
//    }else{
    $pdf->print_decision_entry_form1($formdata['pdfID']);	
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
	$pdf = new pdfs();
	global $db;
	// if(array_item($formdata, "btnReallyDelete")) {
	// delete decision
	if(array_item($formdata,'pdfID')){
		$formdata=$pdf->read_decision_data($formdata['pdfID']);
		$db->execute("START TRANSACTION");
		//if($pdf->delete_decision($formdata))
		if($pdf->del_decision($formdata['pdfID'])){
		$db->execute("COMMIT");
		//$pdf->link();
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
	//$d->set($_GET['insertID'],$_POST['submitbutton'],$_POST['subcategories']);

    $insertID = (isset($_GET['insertID']) && $_GET['insertID']) ? $_GET['insertID'] : '';
    $submitbutton = (isset($_POST['submitbutton'])) && $_POST['submitbutton'] ? $_POST['submitbutton'] : '';
    $subcategories =   (isset($_POST['subcategories'])) && $_POST['subcategories'] ? $_POST['subcategories'] : '';



    $d->set($insertID,$submitbutton,$subcategories);

	
	if(!$insertID && is_numeric($insertID))
	$insertID=$_GET['insertID'];
	
	
	//$d->add_decision($formdata,$forumIDs,$catIDs,$dateIDs);
	$formdata['insertID']=$insertID  ;
	$d->link_div();

	
$sql="select parentDecID1 from decisions where pdfID=$insertID";
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

function  show_list($formdata){
	$pdf = new pdfs();
	//if(!(array_item($_POST,'mode' )=='update') ){
	
	
	//$pdf->print_decision_entry_form1($formdata['pdfID']);	
//	}
	$pdf->link_div();
	build_form($formdata);
	$pdf->print_form_paging();
	echo '<br/><br/>',"\n";
//	$pdf->link();
}
/****************************************************************************/
function read_decision($editID){
	global $db;
	$pdf = new pdfs();
    if($editID==11) {
			echo "<br />רשומת אב אין פרטים ספציפיים   .\n";
			$pdf->link_div();
			return 0;
		}
	if(($editID =$pdf->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
		$formdata =$pdf->read_decision_data($editID);
		$sql="select forum_pdfID from rel_forum_dec where pdfID=$editID";
		$rows=$db->queryObjectArray($sql);
		if($rows)
		$formdata['forum_decision'] = $rows[0]->forum_pdfID;

	}
	$pdf->link_div();
//	if($formdata['parentDecID']=='11')

$sql="select parentDecID1 from decisions where pdfID=$editID";
  if($rows=$db->queryObjectArray($sql)  ){
  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
  $parent=	$rows[0]->parentDecID1;
  	$pdf->print_decision_entry_form1($parent);
  	}
  }
	
//     $pdf->print_decision_entry_form1($editID);
//    else
//    $pdf->print_decision_entry_form1($formdata['parentDecID']);
    
//$qwerty=urlencode($formdata); 
	 build_form($formdata);
	// $pdf->link();
	$pdf->print_form_paging();
	return  TRUE;


}

/******************************************************************************/
function read_subtitle($editID){
	global $db;
	$pdf = new pdfs();
    if($editID==11) {
			echo "<br />רשומת אב אין פרטים ספציפיים   .\n";
			$pdf->link();
			return 0;
		}
	if(($editID =$pdf->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
		
		$sql="select note from decisions where pdfID=$editID";
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
	$pdf = new pdfs();
		//if(array_item($formdata, "btnLink"))
		  $pdf->link();
	      //$pdf->print_form_dec($formdata['pdfID'] );
	      $pdfID=$formdata['pdfID'];
	      $pdf->print_decision_entry_form1($pdfID);
	       $pdf->print_form_paging($formdata['pdfID']);
	      
	      
	      //$pdf->print_form2($formdata['pdfID'] );
	     
	       
	      
	  
		return true;
}

/******************************************************************************/
function read_after_cancle($formdata){
	global $db;
	$pdf = new pdfs();
		 
		  $pdf->link();
	       
	      $pdfID=$formdata['pdfID'];
 	     // $pdf->print_decision_entry_form1($pdfID);
	      $formdata=$pdf->read_decision_data($pdfID);
	      build_form($formdata);
	       $pdf->print_form_paging();
		return true;
}

/******************************************************************************/
function read_befor_link2($formdata){
	global $db;
	$pdf = new pdfs();
		//if(array_item($formdata, "btnLink"))
		  $pdf->link();
	      //$pdf->print_form_dec($formdata['pdfID'] );
	      $pdfID=$formdata['pdfID'];
	      $_SESSION['flag_link2']=true;
	      
	      $bar='link2';
          $query_string =    'flag=' . urlencode($bar);
         //  echo '<a href="find3.php?' . htmlentities($query_string) . '">';
	       require_once 'find3.php' ;
	   //  $pdf->redirect(‪ROOT_DIR.'/admin/find3.php'‬);
	     
//	      $pdf->print_decision_entry_form1($pdfID);
//	      $pdf->print_form2($formdata['pdfID'] );
	     //require_once 'dec_edit.php';
	     //print_form();
	     //$pdf->print_form();
	       
	      
	  
		return  true ;
}

/******************************************************************************/
function read_link($formdata){
     global $db;
	$pdf = new pdfs();
	$formdata=$pdf->read_decision_data3($formdata['pdfID'],$formdata['insertID']);	
	
    $pdf->conn_Parent_second($formdata); 
    $pdf->link();	
//    $pdf->print_decision_entry_form3  ($formdata['parentDecID1'] );
//	$pdf->print_decision_entry_form3  ($formdata['pdfID'] );
  
	$pdf->print_decision_entry_form1  ($formdata['parentDecID1'] );
 //	$pdf->print_decision_entry_form1  ($formdata['pdfID'] );
 	?>
    <input type=hidden name="pdfID" id="pdfID" value="<?php echo $formdata['pdfID'];?>" />
   
    <?php   
    $formdata=$pdf->read_decision_data($formdata['pdfID']);
    build_form($formdata);
    $pdf->print_form_paging();
	//return $formdata;
	return true;
	
}


/************************************************************************************************/

function update_dec($updateID){
	$d=new decisions();


    $insertID = (isset($_GET['insertID']) && $_GET['insertID']) ? $_GET['insertID'] : '';
    $submitbutton = (isset($_POST['submitbutton'])) && $_POST['submitbutton'] ? $_POST['submitbutton'] : '';
    $subcategories =   (isset($_POST['subcategories'])) && $_POST['subcategories'] ? $_POST['subcategories'] : '';
    $deleteID =  (isset($_POST['deleteID'])) && $_POST['deleteID'] ?  $_POST['deleteID'] : '';
   // $updateID =(isset($_GET['updateID']) && $_GET['updateID'])  ? $_GET['updateID'] : '';


    $d->set($insertID,$submitbutton,$subcategories,$deleteID,$updateID);


	$d->link_div();
	$d->update_decision_general();
    
	//$d->link();
}
 
/******************************************************************************/
function update_decision($formdata){
	global $db;

	$pdf = new pdfs();
	 $formdata['dynamic_5']=1;
	 $mode='update';
	 $pdfID= isset($formdata['pdfID']) ? $formdata['pdfID'] : '';
	 if(isset($formdata['pdfID']))
     $formselect=$pdf->read_decision_data2($formdata['pdfID']);
    if(isset($formselect)){
     $formdata['parentDecID']=$formselect['parentDecID'];
     if(isset($formselect['parentDecID1']) && $formselect['parentDecID1'])
     $formdata['parentDecID1']=$formselect['parentDecID1'];
    }
     $formselect['src_forums']= isset($formselect['src_forums']) ? $formselect['src_forums']: '';
     if($formselect['src_forums']){
     $formdata['src_forums']=explode(';',$formselect['src_forums']);
     }
     if(isset($formselect['src_decisionsType']) && $formselect['src_decisionsType']) {
     $formdata['src_decisionsType']=explode(';',$formselect['src_decisionsType']);
     }
/**********************************************************************/
 $DecFrm_note= $pdf->save_note($pdfID);      
/**********************************************************************/     
      $pdf->config_date($formdata);
      $dateIDs =  $pdf->build_date($formdata);
      $dateIDs =  isset($dateIDs['full_date']) && $dateIDs['full_date'];
      $date_UsrfrmIDs=$pdf->build_usr_frm_date($formdata);
      

	
 if($pdf->validate_data($formdata,$dateIDs)){
/*********************************************************************/     
     
     if($forumsIDs=$pdf->save_forum($formdata)){
		if($catIDs=$pdf->save_category($formdata)){

if($pdfID=$pdf->update_dec1($formdata)) {

 if(array_item($formdata,'dest_publishers'))$pdf->conn_user_Decforum($pdfID,$date_UsrfrmIDs,$formdata);
	
	if($pdf->conn_forum_dec($pdfID,$forumsIDs,$mode,$DecFrm_note,$formdata)){
		if($pdf->conn_cat_dec($pdfID,$catIDs,$formdata)){
			 
	//	$pdf->link_div();
			$sql="select parentDecID1 from decisions where pdfID=$pdfID";
				  if($rows=$db->queryObjectArray($sql)  ){
				  	if($rows[0]->parentDecID1 && (is_numeric($rows[0]->parentDecID1)) ){
				        $parent=$rows[0]->parentDecID1;
				     	$pdf->print_decision_entry_form1($parent);
				  	}
				  }
				  
					// 	$pdf->print_decision_entry_form1($formdata['pdfID']);	
						$pdf->message_update($formdata,$pdfID);
												
						return $formdata;
					   }		
					}
				}
			}
		}
	}
	return false;
}




function validate($formdata){
	//$formdata = array_item($_POST, "form");
	global $db;
	$pdf = new pdfs();
//	$pdf->link();
    $pdf->setFormdata($formdata);
//---------------------------------------------------------------
    // try to validate and save date
            $db->execute("START TRANSACTION");
            if ($publishersIDs = $pdf->save_publisher($formdata)) {
                if ($brandIDS = $pdf->save_brand($formdata)) {
                    $pdf->link();
                    if ($pdf->insert_pdf($formdata, $publishersIDs, $brandIDS)) {
                        $pdfID = $formdata['pdfID'];
                        $db->execute("COMMIT");
                        return true;
                }else {
                        $db->execute("ROLLBACK");
                       // $formdata = FALSE;
                        return false;
                    }
            }
        }
}

/***********************************************************************/
function cancel_session(){
	$pdf = new pdfs();
	unset($_SESSION['pdfID']);
	$pdf->link();
	$formdata=false;
	build_form($formdata);
	$pdf->print_form_paging();
}
function link1(){
	$pdf = new pdfs();
	$pdf->link();
	 build_form($formdata); 
	 $pdf->print_form_paging(); 
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
	$projax->link_to_remote('<img src="'.IMAGES_DIR.'/delete.gif" border="0" title="מ" />',array('url'=>'dynamic_5?mode=todo_list&task=delete&id='.$num))."</span></li>";
}


//$pdf = new pdfs();
////if(!isAjax())
//$pdf -> html_footer();

