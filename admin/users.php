<?php
//require_once ("../config/application.php");
//require_once 'DBobject3.php';
//require_once ("../lib/model/user_class.php");
require_once ("../config/application.php");
require_once ("../lib/model/user_class.php");
//require_once ("../lib/model/DBobject3.php"); 




$_SERVER['PHP_SELF']='users.php';
  html_header();
  global $db;
?> 
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>-->
<script type="text/javascript">
    $(function() {
        $("#my_resulttable2 tr:even").addClass("stripe1");//.css("color", "red").css("background-color", "#0f0") ;
        $("#my_resulttable2 tr:odd").addClass("stripe2");//.css("color", "green").css("background-color", "#afa") ;
        $("#my_resulttable2 tr").hover(
            function() {
                $(this).toggleClass("highlight");//.css("color", "yellow");
            },
            function() {
                $(this).toggleClass("highlight");//.css("color", "yellow");
            }
        );
    });
 </script>
 
 
 
<style type="text/css">
 
tr {
	border: 1px solid gray;
}

th {
	background-color:#D2E0E8;
	color:#003366
}
table {
     
}
.clickable {
	 cursor:pointer; 
}
.stripe1 {
    background-color:#0f0;
}
.stripe2 {
    background-color:#afa;
}
.highlight {
    background-color: #ffcc00;
    font-weight:bold;
}
 
</style>
 
<?PHP



/***********************************************************************************************************/


 if(isset($_GET['mode2222']  ))  {

 $userID=$_REQUEST['id'];	
 	
 	
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

	 	
	echo json_encode($message_name);
	exit;
	  	
   }     
   
 
  return   true;
 
		
/*********************/	
}//end functiom	  
   
   
/*************************************************************************************/






is_logged();
 
switch ($_REQUEST['mode']) {
	 
	 
	case "update":
		if( !isset($_POST['submit']) ) {
			// show edit form.
			show_edit_user($_GET['id'], $_REQUEST['mode']);
		   }
  else     {
			 
			if ( !update_user() ) {
				echo "dsdsdsdsdsdsdasda fallil fiaf laifal f";	
			} 
	   else {
				show_user_list();
			}
		}
		
		break;
	 
		
		 case "search":
		 if( !isset($_POST['submit']) ) 
		 	   {
 	
                 	show_edit_user1($_GET['id'],$_REQUEST['mode']);
	
               } 
               elseif(!search_user())
               {
                       	echo "can't search";
                       	
               }	
               else
               {
              	show_user_list();
               }       
                     
               
	  	break;
  										
	  	  case "delete":
		 if( !isset($_GET['id']) ) 
		 	 {
			// show edit form.
			 show_edit_user2($_GET['id'], $_REQUEST['mode']);
		     } 
else{
	       if  ( !delete_user() )
		    {
				echo "dsdsdsdsdsdsdasda fallil fiaf laifal f";	
		   	}
	   else 
	   	    {
				show_user_list();
	        }
   	}   
		break;
	  	
					
		 case "add":
		 if( !isset($_POST['submit']) ) 
		 	   {
 	
                 	show_edit_user3($_GET['id'],$_REQUEST['mode']);
	
               } 
               elseif(!add_user())
               {
                       	echo "can't add user";
                       	
               }	
               else
               {
              	show_user_list();
               }       
                     
               
	  	break;
		
	  	
	  	
	  	 case "read_users":
                //  get_json();
                global $db;
		$t['list'] = array(); 
	 	  
	     $sql = "SELECT full_name ,userID FROM users order by full_name";
	      if($rows=$db->queryObjectArray($sql)){
 

foreach($rows as $row)
	{
		 
		 
		 $t['list'][] =  $row;

	}		
	echo json_encode($t);
	exit;
	  	
       
    
   }     	 
	  	

	    break;
	  	
	default:
	    case "list":
		show_user_list();
		break;
}
 
html_footer();
function show_user_list() {	
	global $db;
	$query = "SELECT * FROM users order by full_name/*WHERE id=$eid*/";
	$result =$db-> execute_query($query);
	print_user_list($result);
	
}
function update_user() {
	//die($_POST["id"]);
	$usr = new users($_POST["id"], $_POST["username"],$_POST["firstname"],$_POST["lastname"],$_POST['full_name'],$_POST["pass"],$_POST['level'],$formdata);
//	if( $usr->check($stam_error) ) 
		return $usr->update();
	return 0;
}


function search_user(){
	$usr = new users($_GET["id"],$_POST["username"], $_GET["pass"]);
	//if( $usr->check($stam_error) ) 
		 $result=$usr->search();
	 	  print_user_list($result);
       return 1;
	return 0;
}


function delete_user(){
	$usr = new users($_GET['id'] );
	
	// if( $usr->check($stam_error) ){ 
		  $result=$usr->deleteUser($_GET['id']);
	    //  print_list($result);     	  
		return 1;
	  return 0;
	 //}
}

function add_user(){
	
	$usr= new users($_POST['id'],$_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['pass'],$_POST['level'],$formdata) ;
	//$usr->setFrmdata($formdata);
  //  $usr->set($_POST['id'],$_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['pass'],$_POST['level']) ; 
	//if( $usr->check($stam_error) ) 
		return $usr->insert();
	return 0;
}

function set_user(){
	     $this->id=$_GET['id'];
//         $this->username=$_POST['username'];
//		 $this->firstname=$_POST['firstname'];
//		 $this->lastname=$_POST['lastname'];
//		 $this->password=$_POST['pass'];
		 $this->level=$_POST['level'];
		// $this->userID=$_GET['id'];
         $this->uname=$_POST['username'];
		 $this->fname=$_POST['firstname'];
		 $this->lname=$_POST['lastname'];
		 $this->upass=$_POST['pass'];
		  
	
}	
function get_json(){
	global $db;
		$t['list'] = array(); 
	 	  
	     $sql = "SELECT full_name ,userID FROM users order by full_name";
	  if($rows=$db->queryObjectArray($sql)){
 
//	  foreach($rows as $row1){
//        $results[] = array('full_name'=>$row1->full_name,'userID'=>$row1->userID);
//       }
       
       
       
	 	 
  
foreach($rows as $row)
	{
		 
		 
		 $t['list'][] =  $row;

	}		
	echo json_encode($t);
	exit;
	  	
       
    
   }     	 
} 

?>