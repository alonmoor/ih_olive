<?PHP
 
if(!($_POST['mode']=='find' ) && !($_POST['mode']=='link_second' ) && !($_GET['user'] )    ){
require_once ("../config/application.php");
if(!isAjax()) 
html_header();



}elseif(array_item($_REQUEST['form'], 'btnLink3')){
$link_secound="flag_secound";	
}


require_once (LIB_DIR.'/model/find_class.php');
require_once (LIB_DIR.'/formfunctions.php');
//form_list_find_notd_no_choose('search_type1' ,'search_type1', $arr, $selected);
?>
<script type="text/javascript" src="ajax.lang.php"></script> 
 
<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.betterTooltip.js"  type="text/javascript"></script> 

<link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/tooltip.css" />
<?php


/*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
/*********************************************/   






if($_REQUEST['mode_js']){
$str=$_REQUEST['mode_js'];

  if( !($_REQUEST['mode_js']==no_find2) ){ 

		?>
		<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/form_pagination.js"  type="text/javascript"></script>
		<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/find2.js"  type="text/javascript"></script>
		<?php  
 	}else{//show categories with accordion on a popup olso for toggeling location at files in tmp_js
 ?>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/find1.js"  type="text/javascript"></script>
<?php  
 }
 
}else {
?>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/form_pagination.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/find2.js"  type="text/javascript"></script>
<?php  
	
	
}



echo '<form name="edit_search1" id="edit_search1" method="post">
       <div class="form-row" style="text-color:white">';
        
    
 
   $arr = array();
   $arr[1][0] = "צפייה בחלון";
   $arr[1][1] = "1";
   $arr[2][0] = "צפייה בדפים";
   $arr[2][1] = "2";
   
 $_SESSION['search_type1']=$_POST['search_type']?$_POST['search_type']:$_SESSION['search_type1']; 
$selected= $_SESSION['search_type1']? $_SESSION['search_type1']:$arr[1][1];
 

 echo '<span class="h">אופן הצפייה בנתונים:</span>';
  
form_list_find_notd_no_choose('search_type1' ,'search_type1', $arr, $selected);

echo '</div></form><br/>', "\n";

 

echo '<input type="hidden" name="search_type2" id="search_type2"  value="">';

   

 global $lang;

//is_logged();
 

if(  !($_REQUEST['conn_secound_test'])  && !($_REQUEST['conn_first_test']) ){//for linking decision from a winPOPUP
 
$decID         = array_item($_REQUEST, 'decID');
}
$forum_decID   = array_item($_REQUEST, 'forum_decID');
$brandID   = array_item($_REQUEST, 'brandID');
//if(!empty($brandID) && is_numeric($brandID)){
//    $forum_decID  = $brandID;
//}


$pdfID         = array_item($_REQUEST, 'pdfID');
$pubID         = array_item($_REQUEST, 'pubID');

$catID         = array_item($_REQUEST, 'catID');

$cat_forumID         = array_item($_REQUEST, 'cat_forumID');
$vote_level         = array_item($_REQUEST, 'vote_level');
if(($_SESSION['dec_level'])&& !(array_item($_REQUEST, 'dec_level'))){
$dec_level=$_SESSION['dec_level'];
unset ($_SESSION['dec_level']);
}
else
$dec_level         = array_item($_REQUEST, 'dec_level');
$status         = array_item($_REQUEST, 'status');
$userID         = array_item($_REQUEST, 'userID');
if(!$userID && array_item($_REQUEST, 'user'))
$userID  = array_item($_REQUEST, 'user'); 


$managerID         =  array_item($_REQUEST, 'managerID') ;
$appointID         =  array_item($_REQUEST, 'appointID') ;
$managerTypeID         =  array_item($_REQUEST, 'managerTypeID') ;
if($userID && array_item($_REQUEST, 'user'))
$userID         =  array_item($_REQUEST, 'user') ;
else
$userID         =  array_item($_REQUEST, 'userID') ;


$datePattern   = array_item($_REQUEST, 'datePattern') ;
$datePattern1  = array_item($_REQUEST, 'datePattern1') ;
$forumPattern  = array_item($_REQUEST, 'forumPattern') ;
$forumPattern1 = array_item($_REQUEST, 'forumPattern1') ;
$decPattern    = array_item($_REQUEST, 'decPattern') ;
$brandPattern    = array_item($_REQUEST, 'brandPattern') ;
//$letterPattern = urldecode(array_item($_REQUEST, 'decPattern'));
$page          = array_item($_REQUEST, 'page');
if(!$page || $page<1 || !is_numeric($page))
$page=1;
elseif($page>100)
$page=100;

if(!is_numeric($catID))
$catID = FALSE;

if(!is_numeric($cat_forumID))
$cat_forumID = FALSE;

if(!is_numeric($userID))
$userID = FALSE;

if(!is_numeric($appointID))
$appointID = FALSE;

if(!is_numeric($managerID))
$managerID = FALSE;

if(!is_numeric($vote_level))
$vote_level = FALSE;

if(!is_numeric($dec_level))
$dec_level = FALSE;

if(!is_numeric($status))
$status = FALSE;

if(!is_numeric($forum_decID))
$forum_decID = FALSE;

if(!is_numeric($decID))
$decID = FALSE;

$formdata = array_item($_POST, "form");

$formdata=$_POST['form'];
if($formdata){

	
 
if(array_item($formdata, "btnTitle") 
	&& (($formdata["forum_decision"] && $formdata["forum_decision"]!='none')
	||($formdata['category1'] &&  $formdata['category1']!='none')
	||($formdata['manager_forum'] && $formdata['manager_forum']!='none'  )
	||($formdata['appoint_forum'] && $formdata['appoint_forum']!='none' ) 
	|| ($formdata['managerType']  && $formdata['managerType']!='none' )

    ||($formdata['pdfs']    && $formdata['pdfs']!='none' )
    ||($formdata['publisher']    && $formdata['publisher']!='none' )

	||($formdata['user_forum']    && $formdata['user_forum']!='none' ) )
	&& !($formdata["decision"]       && $formdata["decision"]!='none')
	&& !($formdata["vote_level"]     && $formdata["vote_level"]!='none')
	&& !($formdata["dec_level"]      && $formdata["dec_level"]!='none')
	&& !($formdata["status"]         && $formdata["status"]!='none')
	&& !($formdata["category"]       && $formdata["category"]!='none')){
		$tmp="forumPattern";
	}
	elseif((array_item($formdata, "btnTitle") &&($formdata["forum"]&& $formdata["forum"]!='none')) ){
		$tmp="forumPattern1";
	}
	elseif(array_item($formdata, "btnTitleRoot" )){
		$tmp="treePatternDown";
		
	}
	elseif(array_item($formdata, "btnTitleRootUp" )){
		$tmp="treePatternUp";
	}
	elseif(array_item($formdata, "btnTitleLetter")){
		$tmp="letterPattern";
	}
	elseif(array_item($formdata, "btnTitleLetter1")){
		$tmp="letterPattern1";
	}
    elseif(array_item($formdata, "btnLink3")){
		$tmp="list";
	}
	else {

		$tmp="decPattern";
	}
}

if(!$formdata){
	if($forumPattern || $forum_decID || $brandID || $pubID || $pdfID || $cat_forumID || $managerID || $managerTypeID || $userID || $appointID ){
		$tmp='forumPattern';
	}
	elseif($forumPattern1){
		$tmp='forumPattern1';
//	}elseif(($decPattern  || $datePattern || $datePattern1 ||$catID || $decID || $vote_level || $dec_level || $status) &&  !($_SESSION['flag_down']) ){
		}elseif(($decPattern  || $datePattern || $datePattern1 ||$catID || $decID || $vote_level || $dec_level || $status) ){
		$tmp='decPattern';
	}elseif($dec_level && $_SESSION['flag_down']){
        $tmp='treePatternDown';
        unset($_SESSION['flag_down']); 
	}

}


/************************************AJAX_FORM**************************************************************/

if($_POST['forum_decision'] &&  (is_numeric(array_item($_POST,'forum_decision')))   ){
$formdata['forum_decision']=array_item($_POST,'forum_decision');
	$tmp='forumPattern';
}

if($_POST['forum_decision_general'] &&  (is_numeric(array_item($_POST,'forum_decision_general')))   ){
$formdata['forum_decision']=array_item($_POST,'forum_decision_general');
	$tmp='forumPattern';
}

if($_POST['forum_decision_general_dest'] &&  (is_numeric(array_item($_POST,'forum_decision_general_dest')))   ){
$formdata['forum_decision']=array_item($_POST,'forum_decision_general_dest');
	$tmp='forumPattern';
}
if($_POST['brandID'] &&  (is_numeric(array_item($_POST,'brandID')))   ){
    $formdata['brandID']=array_item($_POST,'brandID');
    $tmp='forumPattern';
}
/**************************************************************************************************/


if($_POST['mode']=='find' ) {
           $tmp="list";
}            
 





/*************************************LINK_FIST_DECISION FROM A POPUP*************************/

if(array_item($_POST,'change_conn_first') && array_item($_POST,'change_conn_first')!=null ){
$conn_dec['conn']=explode(',',array_item($_POST,'change_conn_first'));
$formdata['decision']=$conn_dec['conn'][0];
 
$formdata['decID']=$conn_dec['conn'][1];
  $tmp="decPattern";	
  unset($_SESSION['decID']);
}
/*********************************************************************************************/
if(array_item($_REQUEST,'conn_first_test') && array_item($_REQUEST,'conn_first_test')!=null ){
if(ae_detect_ie()){
$formdata['decID']=$_REQUEST['decID'];
$id=$formdata['decID'];
$str=$_REQUEST['conn_first_test'];
$str = str_replace("conn_txtFirst$id=","",$str); 
 $formdata['decision']= $str;  


  $tmp="decPattern";	
  unset($_SESSION['decID']);
	
	
}else{ 
$formdata['decision']=$_REQUEST['conn_first_test'];
 // $formdata['decision']= htmlspecial_utf8($formdata['decision']);  

$formdata['decID']=$_REQUEST['decID'];
  $tmp="decPattern";	
  unset($_SESSION['decID']);
  }
}           

/**************************************LINK_SECOUND_DECISION FROM A POPUP*********************/
if(array_item($_REQUEST,'conn_secound_test') && array_item($_REQUEST,'conn_secound_test')!=null ){
if(ae_detect_ie()){
$formdata['decID']=$_REQUEST['decID'];
$id=$formdata['decID'];
$str=$_REQUEST['conn_secound_test'];
$str = str_replace("conn_txt2$id=","",$str); 
 $formdata['decision']= $str;  


  $tmp="decPattern";	
  unset($_SESSION['decID']);
	
	
}else{ 
$formdata['decision']=$_REQUEST['conn_secound_test'];
 

$formdata['decID']=$_REQUEST['decID'];
  $tmp="decPattern";	
  unset($_SESSION['decID']);
  }
}           


/*********************************************************************************************/

if(array_item($_POST,'conn_second') && array_item($_POST,'conn_second')!=null ){
$conn_dec['conn']=explode(',',array_item($_POST,'conn_second'));
$formdata['decision']=$conn_dec['conn'][0];
 
$formdata['decID']=$conn_dec['conn'][1];
  $tmp="decPattern";	
  unset($_SESSION['decID']);
}           


/*********************************************************************************************/





if(  $_GET['search-text'] && $_GET['userID'] && (is_numeric($_GET['userID'])) ){
	$tmp="regUser";
}
if(array_item($_REQUEST['mode'],'changeFirst') && array_item($_REQUEST['mode'],'changeFirst')!=null ){
 
$formdata['decision']=(string)$_REQUEST['txt'];
 
$formdata['decID']=$_REQUEST['decID'];
  $tmp="decPattern";	
  unset($_SESSION['decID']);
}           

/**************************************************************************************************/

if(array_item($_REQUEST,'find_decUser') && array_item($_REQUEST,'find_decUser')!=null ){
	if(ae_detect_ie()){
$str=$_REQUEST['find_decUser'];
$str = str_replace("conn_txtFirst=","",$str); 
 $formdata['decision']= $str;  


  $tmp="decPattern";	
  
}else{	
	
	
$formdata['decision']=$_REQUEST['find_decUser'];
  $tmp="decPattern";
 }	
}           
/*************************************************************************************************/
$_REQUEST['mode']=$tmp;

switch ($_REQUEST['mode'] ) {
	
	
	case 'regUser':
	 
		search_Reguser($userID);
	break;
	

	case "decPattern":
		search_dec($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status);
		break;

	case 'forumPattern':

         		search_forum($formdata,$page,$forumPattern,$forum_decID,$cat_forumID,$managerID,$managerTypeID,$userID,$appointID,$brandID , $pubID , $pdfID);
		break;

	case  'forumPattern1':
		search_forum1($formdata,$page,$forumPattern1,$forum_decID);
		break;
			
	case 'treePatternDown':

		if(array_item($formdata,'forum_decision')&& ($formdata['forum_decision'])&& (($formdata['forum_decision'])!='none')
		&& !($formdata["decision"]   && $formdata["decision"]!='none')
		&& !($formdata["category"]   && $formdata["category"]!='none')
		&& !($formdata["vote_level"] && $formdata["vote_level"]!='none')
		&& !($formdata["dec_level"]  && $formdata["dec_level"]!='none')
		&& !($formdata["status"]     && $formdata["status"]!='none'))

		search_treeDownForum($formdata,$page,$forumPattern,$forum_decID);

		elseif(array_item($formdata,'forum')&& (($formdata['forum'])&& ($formdata['forum'])!='none')
		&& !($formdata["decision"] && $formdata["decision"]!='none')
		&& !($formdata["category"] && $formdata["category"]!='none')
		&& !($formdata["vote_level"] && $formdata["vote_level"]!='none')
		&& !($formdata["dec_level"]  && $formdata["dec_level"]!='none')
		&& !($formdata["status"]     && $formdata["status"]!='none'))

		search_treeDownForum1($formdata,$page,$forumPattern1,$forum_decID);

		else
		search_treeDownDec($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status);
		break;

			
			
	case 'treePatternUp':
		if(array_item($formdata,'forum_decision')&& ($formdata['forum_decision'])&& (($formdata['forum_decision'])!='none')
		&& !($formdata["decision"] && $formdata["decision"]!='none')
		&& !($formdata["category"] && $formdata["category"]!='none')
		&& !($formdata["vote_level"] && $formdata["vote_level"]!='none')
		&& !($formdata["dec_level"]  && $formdata["dec_level"]!='none')
		&& !($formdata["status"]     && $formdata["status"]!='none'))
		 
		search_treeUpForum($formdata,$page,$forumPattern,$forum_decID);

		elseif(array_item($formdata,'forum')&& (($formdata['forum'])&& ($formdata['forum'])!='none')
		&& !($formdata["decision"] && $formdata["decision"]!='none')
		&& !($formdata["category"] && $formdata["category"]!='none')
		&& !($formdata["vote_level"] && $formdata["vote_level"]!='none')
		&& !($formdata["dec_level"]  && $formdata["dec_level"]!='none')
		&& !($formdata["status"]     && $formdata["status"]!='none'))

		search_treeUpForum1($formdata,$page,$forumPattern1,$forum_decID);

		else
		search_treeUpDec($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status);

		break;
			
	case 'letterPattern':
		search_byLetter($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status);
		break;
			

	case 'letterPattern1':
		search_byLetter1($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status);
		break;
	default:
	case "list":

	 
find_build_form();

}


/************************************************************************************************/
function search_Reguser($userID){
	$f=new find();
 	$f->checkReguser($userID);
}
/****************************************************************************/
function search_dec($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$decPattern,$datePattern,$datePattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checkDec_Pattern($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status);
	 
}


/************************************************************************************************/
function search_forum($formdata,$page,$forumPattern,$forum_decID,$cat_forumID,$managerID,$managerTypeID,$userID,$appointID,$brandID , $pubID , $pdfID){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp ,$brandID , $pubID , $pdfID );
	$f->setPattern($formdata,$forumPattern);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
 	$f->checkForum_Pattern($formdata,$page,$forum_decID,$cat_forumID,$managerID,$managerTypeID,$userID,$appointID,$brandID);
}
/****************************************************************************/
function search_forum1($formdata,$page,$forumPattern1,$forum_decID){
	$f=new find();
 	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$forumPattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checkForum_Pattern1($formdata,$page,$forum_decID);
}
/****************************************************************************/
function search_treeDownDec($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$decPattern,$datePattern,$datePattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checktreedec_Down($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status);
	 
}
/****************************************************************************/
function search_treeUpDec($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$decPattern,$datePattern,$datePattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checktreedec_Up($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status);
	 
}
/****************************************************************************/
function search_treeDownForum($formdata,$page,$forumPattern,$forum_decID){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 ,$treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$forumPattern);
	$f->checktreeforum_Down($formdata,$page,$forum_decID);
	 
}
/****************************************************************************/
function search_treeUpForum($formdata,$page,$forumPattern1,$forum_decID){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$forumPattern);
	$f->checktreeforum_Up($formdata,$page,$forum_decID);
	 
}
/****************************************************************************/
function search_treeDownForum1($formdata,$page,$forumPattern1,$forum_decID){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$forumPattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checktreeforum1_Down($formdata,$page,$forum_decID);
}
/****************************************************************************/
function search_treeUpForum1($formdata,$page,$forumPattern1,$forum_decID){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 , $treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$forumPattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checktreeforum1_Up($formdata,$page,$forum_decID);
}
/****************************************************************************/
function search_byLetter($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 ,$treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$decPattern,$datePattern,$datePattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checkDec_Pattern($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status);

}

/************************************************************************************************/
function search_byLetter1($formdata,$page,$decPattern,$datePattern,$datePattern1,$decID,$catID,$vote_level,$dec_level,$status){
	$f=new find();
	$f->set( $decPattern , $forumPattern , $forumPattern1 , $datePattern , $datePattern1 ,$treePatternDown , $treePatternUp  );
	$f->setPattern($formdata,$decPattern,$datePattern,$datePattern1);//($formdata['decision'],$formdata['forum_decision'],$formdata['forum'],$datePattern,$datePattern1,$letterPattern,$treePatternDown,$treePatternUp);
	$f->checkDec_Pattern1($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status);
	$f->link();
}

/************************************************************************************************/
 
//html_footer();
?>  
</td>

</tr>

</table>
<!--
<div style="height:50px;">
			<p><a href="javascript:void(0)" title="">קיבוץ עין השופט</a> | <a href="javascript:void(0)" title="">כללים</a> &nbsp; - &nbsp; &copy;  &nbsp; - &nbsp; עוצב ע"י <a href="javascript:void(0)">אלון מור</a></p> 
</div>-->	
</body>
</html>

<?php  


 