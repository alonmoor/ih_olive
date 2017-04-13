<?php
function validate_data(&$formdata="",&$dateIDs="",$frm_date="") {

global $db;
 $result = TRUE;  
$frm =new forum_dec();


$i=0;

 $member_date=$frm->build_date($formdata);

if(is_array($member_date)   
   && array_item($formdata,'member_date0')
   && array_item($formdata,'dest_users')
   &&  count($formdata['dest_users'])>0 ){
foreach($member_date['full_date']  as $date){
	$date_member="member_date$i";  
	IF(!$frm->check_date($formdata[$date_member])){
	   $member_date['full_date'][$i]=$formdata['today'];
	   	$formdata[$date_member]=$formdata['today'];
	   	}
	   	if(!$frm->check_date( $dateIDs[$i]) ){
	   	 $dateIDs[$i]	=$formdata['today'];	
	}
	$i++;
  }
}




list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$formdata['forum_date']);
   if( array_item($formdata, 'forum_date') 
   &&  !is_numeric($day_date_forum )
   && !is_numeric($month_date_forum) 
   && !is_numeric($year_date_forum)
 || ( !$frm->check_date($formdata['forum_date']))  ){ 
          $formdata['forum_date']="";        
        }       

if(  (trim($formdata["forum_date"])=="" || trim($formdata["forum_date"])=='none') ) {
	
    show_error_msg("חייב לציין מתיי הוקם הפורום ");
    $errors[]=show_error_msg("חייב לציין מתיי הוקם הפורום ");
    $result = FALSE; 
	}
  

/***********************************************************************************************************/	
list( $day_date_appoint,$month_date_appoint,$year_date_appoint) = explode('-',$formdata['appoint_date1']);
   if( array_item($formdata, 'appoint_date1') 
   &&  !is_numeric($day_date_appoint )
   && !is_numeric($month_date_appoint) 
   && !is_numeric($year_date_appoint)
 || ( !$frm->check_date($formdata['appoint_date1']))  ){ 
          $formdata['appoint_date1']="";        
        }       

if(  (trim($formdata["appoint_date1"])=="" || trim($formdata["appoint_date1"])=='none') ) {
	
    show_error_msg("חייב לציין מתיי התמנה הממנה");
    $result = FALSE; 
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$formdata['manager_date']);
   if( array_item($formdata, 'manager_date') 
   &&  !is_numeric($day_date_manager )
   && !is_numeric($month_date_manager) 
   && !is_numeric($year_date_manager)
 || ( !$frm->check_date($formdata['manager_date']))  ){ 
          $formdata['manager_date']="";        
        }       

if(  (trim($formdata["manager_date"])=="" || trim($formdata["manager_date"])=='none') ) {
	
    show_error_msg("חייב לציין מתיי התמנה המנהל");
    $result = FALSE; 
	}	
	
	
	
/**************************************************************************************************************/ 
if(  (trim($formdata["forum_decision"])=="" || trim($formdata["forum_decision"])=='none') 
	   && trim($formdata["newforum"])=="") {
    show_error_msg("חייב לשייך לפורום");
    $result = FALSE; 
	}
  

if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
 
    show_error_msg("פורומים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}
	
if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   &&  $formdata["forum_decision"] && is_numeric($formdata["forum_decision"]) ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ פורום בשם הזה");
//              		UNSET($formdata['newforum']);
//              		UNSET($_POST['form']['newforum']);
              	 $result = FALSE;  
              }elseif(array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
              	unset($formdata['forum_decID']); 
              }	
}	


if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   && (!$formdata["forum_decision"] || $formdata["forum_decision"]==null)  ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ פורום בשם הזה");
//              		UNSET($_POST['form']['newforum']);
//              		UNSET($formdata['newforum']);
              	$result = FALSE;  
              }	
}	
if ($formdata['newforum'] && $formdata['newforum']!=null
    && array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
          unset($formdata['forum_decID']);      	
    }
/*************************************************************************************/	
	
	if(  (trim($formdata["category"])=="" || trim($formdata["category"]=='none')) 
	   && trim($formdata["new_category"])=="") {
    show_error_msg("חייב לשייך לקטגוריה");
   $result = FALSE;  
	}
	
	
	if(  trim($formdata["category"])=="11" && trim($formdata["new_category"])==""){ 
 
    show_error_msg("קטגוריות הפורומים רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}	

	
  if( trim($formdata["new_category"]!=null) && trim($formdata["new_category"]!=null) 
     &&  $formdata["category"]!="none" && $formdata["category"]!=null ){	
	  $name=$db->sql_string($formdata["new_category"]);
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
              		
              	$result = FALSE;  
              }	
      }	
	
	
	
    if( trim($formdata["new_category"]!="none") && trim($formdata["new_category"]!=null) 
       &&  (!$formdata["category"] || $formdata["category"]==null )  ){
	
	$name=$db->sql_string($formdata["new_category"]);
	 $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
              	 
               $result = FALSE; 
              }	
}


/*************************************************************************************/	
	
	if(  (trim($formdata["appoint_forum"])=="" || trim($formdata["appoint_forum"]=='none')) 
	   && trim($formdata["new_appoint"])=="") {
    show_error_msg("חייב לשייך ממנה פורום");
    $result = FALSE; 
	}
	
	
	if(  trim($formdata["appoint_forum"])=="11" && trim($formdata["new_appoint"])==""){ 
 
    show_error_msg("ממנים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}
		
	if( $formdata["appoint_forum"] && trim($formdata["new_appoint"]!=null)  ){
		
    $id=$formdata['new_appoint'];
    if($id!=null){  
	$sql="SELECT appointName  from appoint_forum where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->appointName!=''){
//	 		UNSET($formdata['new_appoint']);
//            UNSET($_POST['form']['new_appoint']);
	   show_error_msg("כבר קיים ממנה אם שם כזה!");
	   $result = FALSE; 
	 }
	}
}

if( trim($formdata["new_appoint"] ) && trim ($formdata["new_appoint"]!=null) 
   && (!$formdata["appoint_forum"] || $formdata["appoint_forum"]!=null)   ){
		
    $id=$formdata['new_appoint'];
    if($id!=null){  
	$sql="SELECT appointName  from appoint_forum where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->appointName!=''){
	 show_error_msg("כבר קיים ממנה אם שם כזה!");
	 $result = FALSE; 
	 }
	}
}	
/****************************************************************************************/	
	if(  (trim($formdata["manager_forum"])=="" || trim($formdata["manager_forum"]=='none')) 
	   && trim($formdata["new_manager"])=="") {
    show_error_msg("חייב לשייך מרכז פורום");
    $result = FALSE; 
	}
	
	
	if(  trim($formdata["manager_forum"])=="11" && trim($formdata["new_manager"])==""){ 
 
    show_error_msg("מנהלים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}	

	
if( $formdata["manager_forum"]  && trim($formdata["new_manager"]!=null) ){
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->managerName!=''){
//	 	    UNSET($formdata['new_manager']);
//            UNSET($_POST['form']['new_manager']);
	    show_error_msg("כבר קיים מנהל אם שם כזה!");
	 $result = FALSE; 
	 }
	}
}	


if( trim($formdata["new_manager"] ) && trim ($formdata["new_manager"]!=null) 
   && (!$formdata["manager_forum"] || $formdata["manager_forum"]==null)   ){
		
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->managerName!=''){
	show_error_msg("כבר קיים מנהל אם שם כזה!");
	 $result = FALSE; 
	 }
	}
}	

/****************************************************************************************/	
	
	if(  (trim($formdata["managerType"])=="" || trim($formdata["managerType"]=='none')) 
	   && trim($formdata["new_type"])=="") {
    show_error_msg("חייב לשייך סוגי מנהלים");
    $result = FALSE; 
	}
	
	
	if(  trim($formdata["managerType"])=="11" && trim($formdata["new_type"])==""){ 
 
    show_error_msg("סוגי מנהלים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}

	
if( trim($formdata["new_type"]) && trim($formdata["new_type"]!=null) 
   && $formdata["managerType"] && $formdata["managerType"]!=null  ){
	
	$name=$db->sql_string($formdata["new_type"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג מנהלים בשם הזה");
//              		UNSET($formdata['new_type']);
//              		UNSET($_POST['form']['new_type']);
              	 
                $result = FALSE; 
              }	
}


if( trim($formdata["new_type"]) && trim($formdata["new_type"]!=null) 
   && (!$formdata["managerType"] || $formdata["managerType"]==null)  ){
	
	$name=$db->sql_string($formdata["new_type"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג מנהלים בשם הזה");
//              		UNSET($formdata['new_type']);
//              		UNSET($_POST['form']['new_type']);
              	 
                $result = FALSE; 
              }	
}	

/*****************************************************************************************/
 if( trim($formdata["new_category"]) && trim($formdata["new_category"]!=null) 
     &&  $formdata["category"]!="none" && $formdata["category"]!=null ){	
	  $name=$db->sql_string($formdata["new_category"]);
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
//              		UNSET($formdata['newforum']);
//              		UNSET($_POST['form']['newforum']);
              	$result = FALSE;  
              }	
      }	
	
	
	
    if( trim($formdata["new_category"] ) && trim($formdata["new_category"]!=null) 
        && (!$formdata['category'] || $formdata['category']==null ) ) {
	
	$name=$db->sql_string($formdata["new_category"]);
	 $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
              	 
               $result = FALSE; 
              }	
}

/*******************************************************************************************/
if($formdata['src_users']){
$src=explode(',',$formdata['src_users']);	
foreach($src as $row){
	
	if($row=='none'){
	    show_error_msg("בחר אופציה היא רשומת אב ולא שם משתמש");
       $result = FALSE;
		
	}
	
  }
}	


/********************************************************************************************/
if($formdata['dest_users']){
   foreach($formdata['dest_users'] as $key=>$val){ 
         	 
     if(  !(array_item($formdata['dest_users'] ,$formdata['deluser_Forum'])) 
     &&  $formdata['deluser_Forum']!='none' && $formdata['deluser_Forum']!=null){
	     $flag=true;
     } else 
	     $flag=false;  
    		
  }	
 if($flag){   
  show_error_msg("מבקש למחוק חבר לא קיים");
       $result = FALSE;
 }     
}	


    
if( !($formdata['dest_users']) && $formdata['deluser_Forum'] &&  $formdata['deluser_Forum']!='none' ){
	      show_error_msg("מבקש למחוק חבר לא קיים");
       $result = FALSE;
	
}	
/********************************************************************************************/
//if(  !($formdata['src_users']) && !($formdata['dest_users'])
//      && ($formdata['src_users'][0]!='none')  && ($formdata['dest_users'][0]!='none') 
//      &&   $formdata['deluser_Forum']=='none' &&  $formdata['adduser_Forum']=='none' ){
//      	 show_error_msg("בחר אופציה היא רשומת אב ולא שם משתמש");
//       $result = FALSE;
//      }   	
      
/*********************************************************************************************/
  
//	if(!empty($formdata['forum_status']) && ((!is_numeric($formdata['forum_status'])) || $formdata['forum_status']>1 || $formdata['forum_status']<0)) {
//    show_error_msg("סטטוס החלטה חייבת להיות   1 או 0  (או ריק).");
//    $result = FALSE; 
//	}	

   
	if(!empty($formdata['forum_status']) && ((!is_numeric($formdata['forum_status'])) 
	   || $formdata['forum_status']>1 || $formdata['forum_status']<0)
	   || (trim($formdata["forum_status"] )==""  )) {
    show_error_msg("סטטוס פורום חייבת להיות 1 או 0 ).");
    $result = FALSE; 
	}
/**************************************************************************************/
 $dst_usr=array();	
 $i=0;
 if(array_item($formdata,'forum_decID')   ){
$forumID=$formdata['forum_decID'];
 $sql="select * from rel_user_forum where forum_decID=$forumID";
 if($rows=$db->queryObjectArray($sql)){
 	foreach($rows as $row){
 		list($day_date_rel_date,$month_date_rel_date,$year_date_rel_date ) = explode('-',$row->rel_date);
     	        if (strlen($year_date_rel_date) < 3){
		           $row->rel_date="$year_date_rel_date-$month_date_rel_date-$day_date_rel_date";	
	    	    }else{
			       $row->rel_date="$day_date_rel_date-$month_date_rel_date-$year_date_rel_date";
	    	    }   
 		$forumUser_date[$row->rel_date] = $row->userID;
 		$forumUser_id[$row->userID] = $row->rel_date;
 	}
 	
 }
 
 }
 
 //for the name message
 if( (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
      &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
      && (count($dateIDs)==count($formdata['dest_users'])  )
      && array_item($formdata,'member_date0')) {
	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}
	
 	
	 

$i=0;	
    foreach($dateIDs as $daycomp) {
    	//if(array_item($forumUser_date, $daycomp)){
    		      
		   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      //} 
    }
      

      
      
      
      
      
 }elseif(is_array($dateIDs)   && (count($formdata['dest_users'])>0  )
 &&(! array_item($formdata,'member') && !array_item($formdata,'member_date0') ) ) {
$i=0;
 	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}

	
$i=0;
	foreach($dateIDs as $daycomp) {
    	   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
	 
    }
 	
 
  
 
 
}elseif(  (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
             &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
             && array_item($formdata,'member_date0')
		     && array_item($formdata,'dest_users')
		     &&  count($formdata['dest_users'])>0
             ){
  	
  	//for($i=0; $i<count($formdata['dest_users']); $i++){
  	$i=0;	
    foreach($formdata['dest_users'] as $key=>$val){
  			
    	$dest_usr[$i]=$key;
    	
    	
  		$i++;	
  		}
  		$rel_dest=array_merge($formdata['src_usersID'],$dest_usr);
		 $rel_dest=array_unique($rel_dest);
  		
  		
  		
  	//}   
             	
             	
     $i=0;	
    foreach($dateIDs as $daycomp) {
     
		   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      }          	
            	
  }		       
   	       
/***********************************************************************************************************/
if( array_item($formdata,'appoint_date1') && $frm->check_date($formdata['appoint_date1'])  ){
  if(!$frm-> DateSort($formdata['appoint_date1'],$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך ממנה  לפניי תאריך הקמת הפורום ");
		         $result = FALSE;  
	    }
}     		
/*************************************************************************************/	
if( array_item($formdata,'manager_date') && $frm->check_date($formdata['manager_date'])  ){
	    if(!$frm-> DateSort($formdata['manager_date'],$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך מנהל לפניי תאריך הקמת הפורום "); 
		         $result = FALSE; 
	    } 
} 		
/*************************************************************************************/
           echo json_encode($result); 				
			return $result;
	}
 
/**********************************************************************************************/
