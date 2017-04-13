<?php
 require_once ("../config/application.php");
 global $db;
  $_SESSION['print_users']=1;
 if(!isAjax())
  html_header();
  
  
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
    
 ?>
<!-- ===========================================SCRIPT=================================================================  --> 
 <style type="text/css">
	 	
	  	 
 	label, input { display:block; }
 		input.text { margin-bottom:12px;  padding: .4em; } 
		fieldset { padding:0; border:1; margin-top:25px; }
		h1 { font-size: 1.2em; margin: .6em 0; }
		div#users-contain { width: 350px; margin: 20px 0; }
		div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
		div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; } 
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
	 	  
</style>
 
 <script>

 scriptAr = new Array(); 
 scriptAr_edit = new Array(); 
<?php 
 $sql = "SELECT uh.*,u.full_name,u.fname,u.lname,u.level,f.forum_decName FROM rel_user_forum_history uh				 
INNER JOIN users u ON(uh.userID=u.userID)
INNER JOIN forum_dec f ON(f.forum_decID=uh.forum_decID) ORDER BY u.fname"; 
 $i=0;
 if($rows=$db->queryObjectArray($sql)){
 
 	foreach($rows as $row){

 print "scriptAr.push(\"$row->full_name\",\"$row->userID\" );";
 print "scriptAr_edit.push(\"$row->full_name\",\"$row->userID\" );";
 	 $i++;
  }
 }	
 ?>
 
</script> 
 
 
<!-- <link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css' />	
   <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/bookstore.css"  />
    <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/input.css"  /> 
 -->
   
 
   <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/forms.css"  /> 
   <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/rotators.css"  />
   <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/input.css"  /> 



<link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/tables.css"  />
<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/tables.js"  type="text/javascript"></script> 
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/history_users.js"     type="text/javascript"></script> 


<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.betterTooltip.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi.js"             charset="utf-8"          type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi_user.js"         charset="utf-8"              type="text/javascript"></script>

<!-- ===========================================END_SCRIPT=================================================================  -->  
  
 
 
 
 
 
 
 

 
  <fieldset style="width:90%;overflow:auto;margin-bottom:30px;margin-right:55px;background: #94C5EB url(../images/background-grad.png) repeat-x;">
   
 <input type="hidden" name="Request_Tracking_Number_end_date" id="Request_Tracking_Number_end_date" value="" />
  
<div id="wrapper" > 

  <div id="my_error_message"  name="my_error_message" style="width:60%"></div> 


<div id="loading">
  <img src="../images/loading4.gif" border="0" />
</div> 
 <!-- ===========================================SEARCH_EDIT=================================================================  -->
 
   
<div id="sidebar">
	 	 
<form  id="search" name=test   accept-charset="utf-8" >
      <input name=arv type=hidden>
               <label for="search-text" style="color:yellow; font-weight :bold; font-size :15px;">חפש משתמש לצורך צפייה</label><br/>
               <input type="text" name="search-text" id="search-text" />
  </form>
  			 
</div>  
<div id="user_detail"></div>
<!-- ===========================================SEARCH_SHOW================================================================= -->
 
   
<div id="sidebar_edit">
	 	 
<form  id="search_edit" name="test_edit"   accept-charset="utf-8"  >
      <input name=arv type=hidden>
  <?php if($level){?>
               <label for="search_edit" class="ac_input"  style="color:yellow; font-weight :bold; font-size :15px;"> חפש משתמש לצורך עריכה</label><br/>
               <input type="text" name="search_editUser" id="search_editUser" />
  <?php }elseif(!$level){?>
       <label for="search_edit" class="ac_input"  style="color:yellow; font-weight :bold; font-size :15px;"> חפש משתמש לצורך צפייה בפרטים בחלון</label><br/>
       <input type="text" name="search_editUser" id="search_editUser" />       
  <?php }?> 
  </form>
  			 
</div>  



 <div id="user_detail1"></div>




 
 <?php if(!(ae_detect_ie())){?> 
<div id="users-message"    name="users-message"></div>    
<?php } ?>
<!-- ============================================CONTAINER_TABLE============================================== -->  	
  	<div id="container">
  			
  		<div id="content" >
  		


<!-- ---------ADD_USER----------------- -->
<?php  if($level){?>
<table style="float:left;margin-left:90px;"><tr><td>
 <div>
   <input type="button"  class="mybutton"  id="btnAddUser"  value="הוסף משתמש"/> 
 </div>
</td></tr></table>   
 <?php 

}
?>
<!-- ---------TABLE----------------- -->  		 
 
  <table class="sortable paginated" id="theList" border="0"  style="overflow:auto;margin-right:6px;margin-left:5px;"   >
<!-- ---------TABLE----------------- -->
        


  
         
         <?php if((ae_detect_ie())){?> 
			<div id="users-message"    name="users-message"></div>    
			<?php } ?>
			         
			<div id="loading">
			  <img src="../images/loading4.gif" border="0" />
			</div> 
 
    
          <thead>
          
            <tr>
             <?php if($level){?>   
              <th class="sort-alpha" >הסרה</th>  
              <?php }?>
                <th class="sort-numeric" style="color:yellow">משתמש&nbsp;זיהוי</th>
            <th class="sort-alpha" STYLE="color:yellow" >שם &nbsp;פרטי</th>
          <th class="sort-alpha" STYLE="color:yellow">שם &nbsp;מישפחה</th> 
              <th class="sort-alpha" STYLE="color:yellow;">שם &nbsp;מלא</th>
             
             
             
              <th class="sort-numeric" style="color:yellow">פורום&nbsp;זיהוי</th>
            <th class="sort-alpha" STYLE="color:yellow" >שם פורום</th>
             
              <th class="sort-date" STYLE="color:yellow">תאריך התחלה</th>
               <th class="sort-date" STYLE="color:yellow">תאריך סיום</th>
              <th class="sort-alpha" STYLE="color:yellow" >הרשאה</th>

            </tr>
          </thead>
          
          

          <tbody>
 
 
 <?php  
 mb_internal_encoding( 'UTF-8' );
 
// $sql="SET lc_time_names = 'he_IL'";
// $db->execute($sql);
 
$sql = "SELECT uh.*,DATE_FORMAT(uh.end_date,' %M  %e %Y ') AS format_end_date ,DATE_FORMAT(uh.start_date,' %M  %e %Y ') AS format_start_date 
,u.full_name,u.fname,u.lname,u.level,f.forum_decName FROM rel_user_forum_history uh				 
INNER JOIN users u ON(uh.userID=u.userID)
INNER JOIN forum_dec f ON(f.forum_decID=uh.forum_decID) ORDER BY u.fname"; 
//SELECT DATE_FORMAT(user_date,'%e %M %Y ') FROM users    
 if($rows=$db->queryObjectArray($sql)){
 
 	foreach($rows as $row){
 	$userID=$row->userID;	
 		$sql = "SELECT   r.forum_decID,f.forum_decName
				FROM  rel_user_forum  r
				 LEFT JOIN forum_dec f ON f.forum_decID=r.forum_decID 
				 LEFT JOIN users u ON u.userID=r.userID
				WHERE r.userID = $userID
				 ORDER BY  f.forum_decName";
               
     
                       
       $rows_userFrm=$db->queryObjectArray($sql); 
       
//       $sql = "SELECT   r.forum_decID,f.forum_decName
//				FROM  rel_user_forum_history   r
//				 LEFT JOIN forum_dec f ON f.forum_decID=r.forum_decID 
//				 LEFT JOIN users u ON u.userID=r.userID
//				WHERE r.userID = $userID
//				 ORDER BY  f.forum_decName";
//       $rows_userPastfrm=$db->queryObjectArray($sql);
       
       
       
       
        $sql_mgr=	"SELECT managerID FROM managers  where userID=$row->userID " ;
 		$rows_mgr=$db->queryObjectArray($sql_mgr);
//========================================================$level_DELETE======================================================= 		
 		?>  
 		
 		<tr id="user_<?php echo $row->userID; echo $row->forum_decID; ?>">
 		
 		 <?php if($level){?>
           <td style=" padding: 5px 2px;vertical-align: top;height:10px;">
            <input type="hidden"  id="user_id"  value="<?php echo $row->userID;?>" />
          
            <input type="button"  class="mybutton" lang="en-us"  id="btnDeleteUserfrm<?php  echo $row->userID; echo $row->forum_decID; ?>"  value="מחק משתמש" 
            onClick="return del_user_frm(<?php echo $row->userID;?>,<?php  echo $row->forum_decID; ?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>);this.blur();return false;" />
          
           </td> 
             <?php 
 		       }
//==============================================KEY+FNAME+LNAME===========================================================             
             ?> 
        
         
        <td id="usrFrm_key<?php  echo $row->userID; echo $row->forum_decID;  ?>"><span>
              <a href="#"  onClick="return editPastUser (<?php echo $row->userID;?> ,<?php echo $row->forum_decID;?> ,<?php echo " '".ROOT_WWW."/admin/' "; ?>); return false;" >
                 <b style="color:blue;"><?php echo $row->userID; ?></b>
             </a>  
              </span>
        </td>
        
        
         
          <td>
           <span>
              <a href="#"  onClick="return editUser4(<?php echo $row->userID;?> ,<?php echo " '".ROOT_WWW."/admin/' "; ?>); return false;" >
                 <b style="color:blue;"><?php echo $row->fname; ?></b>
             </a>  
              </span>
           </td>
             
          
          
    <?php if($rows_userFrm || $rows_mgr){?>      
          <td> 
          <span>
           <a href="javascript:void(0)"  onClick="return openmypage3(<?php echo " '".ROOT_WWW."/admin/find3.php?userID=$row->userID' "; ?>);this.blur();return false;" >
              <b style="color:brown;"><?php echo $row->lname; ?></b>
           </a>
   
          </span>  
           
         </td>
         
    <?php }else{?>
            <td class="error"> 
           
    
                <b style="color:green;"><?php echo $row->lname; ?></b>
           
         </td>
    <?php }?>        
 <?php 
 //=======================================HAVE_DEITAIL-BY FULL_NAME===================================================
 if($rows_userFrm){
 ?>         
          
          
          <td> 
         <a href="javascript:void(0)"  onClick="return openmypage3(<?php echo " '".ROOT_WWW."/admin/find3.php?userID=$row->userID' "; ?>);this.blur();return false;" >
              <b style="color:brown;"><?php echo $row->full_name; ?></b>
         </a>
              
          </td>
 <?php }else{?>          
         
         <td class="error"> 

             <b style="color:brown;"><?php echo $row->full_name; ?></b>
              
          </td>
         
         
         
<?php 
 }
//==============================================FORUM_DEC=========================================================== 
?>         
      
      
     
            
         <td><b style="color:black;"><?php echo $row->forum_decID; ?></b></td>      
             
          
          <td id="frmName<?php echo $row->userID;  echo $row->forum_decID; ?>">
           <a href="javascript:void(0)"  onClick="return openmypage3(<?php echo " '".ROOT_WWW."/admin/find3.php?forum_decID=$row->forum_decID' "; ?>);this.blur();return false;" >
           <b style="color:black;"><?php echo $row->forum_decName; ?></b></a>
          </td>
   
          
           
           <!--<td><b style="color:black;"><?php echo date_create( $row->start_date )->format( "l  M  Y\n" );  ?></b></td> -->
           <td><b style="color:black;"><?php echo $row->format_start_date;  ?></b></td>
          
          <!--<td><b style="color:black;"><?php echo date_create( $row->end_date )->format( "l d M Y\n" );  ?></b></td>-->
           <td><b style="color:black;"><?php echo $row->format_end_date ;  ?></b></td>
        
        
          
          
          
          
          
          
          
          
          
 <?php 
//=======================================================================================================
  if ($row->level=='admin' ){
  
   
                                       
   if ($rows_mgr){
   	$mgrID=$rows_mgr[0]->managerID;
   ?>	
  <td id="my_level_td<?php  echo $row->userID; echo $row->forum_decID; ?>"> 
   <a href="javascript:void(0)"  onClick="return openmypage3(<?php echo " '".ROOT_WWW."/admin/find3.php?managerID=$mgrID' "; ?>);this.blur();return false;" >
   <b style="color:red;"><?php echo $row->level; ?></b></a></td>
   <?php 
 	
   }
   
   else{
   	
   	?>	
   	<td class="error" id="my_level_td<?php echo $userID;?>"><b style="color:red;"><?php echo $row->level; ?></b></td>
   <?php 
   	
   }	
  	
//=======================================================================================================  
  }elseif ( $row->level=='user_admin' || $row->level=='suppervizer'){
  
  
  ?>
           <td id="my_level_td<?php echo $userID;?>"><b style="color:blue;"><?php echo $row->level; ?></b></td>
  <?php    
//=======================================================================================================  
  }else{
  ?>
           <td id="my_level_td<?php echo $userID;?>"><b style="color:black;"><?php echo $row->level; ?></b></td>
  <?php 
  
  }
//=======================================================================================================  
  ?>    
  
  
            
 </tr>
 		
 		
 		 
 	      	
 		<?php
 		
 		
 	}
 	
 	
 } 
 ?>
 
 
 
  
 
 
 </tbody>
 </table>

 
 
 <!-- ===========================================PAGE_USER_EDIT================================================================= -->
 
 
 
<div id="page_useredit" class="page_useredit" style="display:none;">
 
<h4 class="my_title" style="height:15px;"></h4>
<h3><?php __('edit_user');?></h3>

 <div class="content_2">


 
<form  onSubmit="return submitNewNormalUser(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>);"  name="edituser"   id="edituser" >
<input type="hidden" name="Request_Tracking_Number1" id="Request_Tracking_Number1" value="" />
<input type="hidden" name="id" value="" />





<div class="form-row">
  
    
    
     <span class="h"><?php __('active');?></span><?php form_empty_cell_no_td(4);?> 
    <SELECT name="active" id="active" class="mycontrol">
      <option value="2" selected>פעיל</option>
      <option value="1">לא פעיל</option>
      
    </SELECT>
    &nbsp; 
    
    
    
</div>



<div class="form-row">
 <span class="h"><?php __('level');?></span> <?php form_empty_cell_no_td(2);?>
 <SELECT name="level" id="level" class="mycontrol">  
    <option value="1">חבר</option>
    <option value="2"><?php __(admin) ?></option>
    <option value="3"><?php __(suppervizer) ?></option>
    <option value="4">מנהל+חבר</option>
    <option value="none" selected>(בחר אופציה)</option>
</SELECT>

</div> 


<div class="form-row"><span class="h">תאריך לידה</span><?php form_empty_cell_no_td(3); ?> 
  <input name="duedate4" id="duedate4" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>

<div class="form-row"><span class="h"><?php __('full_name');?></span> <?php form_empty_cell_no_td(5);?> 
  <input type="text" name="full_name" id="full_name" value="" class="in200" maxlength="50"   />
</div>

<div class="form-row"><span class="h">שם פרטי</span>  <?php form_empty_cell_no_td(6);?>
  <input type="text" name="fname" id="fname" value="" class="in200" maxlength="50"   />
</div>

<div class="form-row"><span class="h">שם משפחה</span> <?php form_empty_cell_no_td(3);?>
  <input type="text" name="lname" id="lname" value="" class="in200" maxlength="50"   />
</div>

<div class="form-row"><span class="h"><?php __('user');?></span> <?php form_empty_cell_no_td(2);?> 
  <input type="text" name="user" id="user" value="" class="in200" maxlength="50"   />
</div>

<div class="form-row"><span class="h"><?php __('upass');?></span> <?php form_empty_cell_no_td(9);?> 
 <input type="text" name="upass" id="upass"  value="" class="in200" maxlength="50" />
</div>

<div class="form-row"><span class="h"><?php __('email');?></span>  
 <input type="text" name="email"  id="email"    value="" class="in200" maxlength="50" />
</div>

<div class="form-row"><span class="h"><?php __('phone');?></span> <?php form_empty_cell_no_td(10);?>
  <input type="text" name="phone"  id="phone"    value="" class="in200" maxlength="50" />
</div>

<div class="form-row"><span class="h"><?php __('note');?></span><br>  
 <textarea name="note" id="note" class="in500"></textarea>
</div>

 <div class="form-row">
<?php if($level){?>
   <input type="submit" id="edit_usr" value="<?php __('save');?>" onClick="this.blur()" />
<?php }?>    
   <input type="button" value="<?php __('cancel');?>" onClick="canceluserEdit4();this.blur();return false" />
 </div>

</form>

 </div>   <!-- end div content_2  -->

</div> <!--  end of page_user_edit -->  
   


<!-- ===========================================PAGE_Past_USER_EDIT================================================================= -->
 
 
 
<div id="page_Pastuseredit" class="page_Pastuseredit" style="display:none;">
 
<h4 class="myPast_title" style="height:15px;"></h4>
<h3><?php __('edit_user');?></h3>

 <div class="contentPast_2">


 
<form  onSubmit="return submitNewPastNormalUser(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>);"  name="edit_Pastuser"   id="edit_Pastuser" >
<input type="hidden" name="Request_Tracking_Number_user" id="Request_Tracking_Number_user" value="" />
<input type="hidden" name="Request_Tracking_Number_forum" id="Request_Tracking_Number_forum" value="" />






<div class="form-row">
  
    
    
     <span class="h"><?php __('active');?></span><?php form_empty_cell_no_td(4);?> 
    <SELECT name="past_active" id="past_active" class="mycontrol">
      <option value="2" selected>פעיל</option>
      <option value="1">לא פעיל</option>
      
    </SELECT>
    &nbsp; 
    
    
    
</div>



<div class="form-row">
 <span class="h"><?php __('level');?></span> <?php form_empty_cell_no_td(2);?>
 <SELECT name="past_level" id="past_level" class="mycontrol">  
    <option value="1">חבר</option>
    <option value="2"><?php __(admin) ?></option>
    <option value="3"><?php __(suppervizer) ?></option>
    <option value="4">מנהל+חבר</option>
    <option value="none" selected>(בחר אופציה)</option>
</SELECT>

</div> 



<div class="form-row"><span class="h"><?php __('frmName');?></span> <?php form_empty_cell_no_td(9);?> 
 
<?php 
 
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats[$row->parentForumID][] = $row->forum_decID;
			$catNames[$row->forum_decID] = $row->forum_decName;
 
		
		}

$rows = build_category_array($subcats[NULL], $subcats, $catNames);
  		
		 form_list_find_notd ("past_frm_name", "past_frm_name",$rows , array_item($formdata, "past_frm_name") );	
      
        
?> 
 
<!--<input type="text" name="past_frm_name1" id="past_frm_name1"  value="" class="in200" maxlength="50" />-->
</div>





<div class="form-row"><span class="h">תאריך התחלה</span><?php form_empty_cell_no_td(3); ?> 
  <input name="past_duedate5" id="past_duedate5" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>



<div class="form-row"><span class="h">תאריך סיום</span><?php form_empty_cell_no_td(3); ?> 
  <input name="past_duedate6" id="past_duedate6" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>



<div class="form-row"><span class="h"><?php __('full_name');?></span> <?php form_empty_cell_no_td(5);?> 
  <input type="text" name="past_full_name" id="past_full_name" value="" class="in200" maxlength="50"   />
</div>

<div class="form-row"><span class="h">שם פרטי</span>  <?php form_empty_cell_no_td(6);?>
  <input type="text" name="past_fname" id="past_fname" value="" class="in200" maxlength="50"   />
</div>

<div class="form-row"><span class="h">שם משפחה</span> <?php form_empty_cell_no_td(3);?>
  <input type="text" name="past_lname" id="past_lname" value="" class="in200" maxlength="50"   />
</div>





<div class="form-row"><span class="h"><?php __('note');?></span><br>  
 <textarea name="past_note" id="past_note" class="in500"></textarea>
</div>

 <div class="form-row">
<?php if($level){?>
   <input type="submit" id="edit_Past_usr" value="<?php __('save');?>" onClick="this.blur()" />
<?php }?>    
   <input type="button" value="<?php __('cancel');?>" onClick="cancelPastuser();this.blur();return false" />
 </div>

</form>

 </div>   <!-- end div content_2  -->

</div> <!--  end of page_Pastuser_edit -->  
   















 
<!-- =========================================NEW_USER=================================================================== --> 
<div id="users-contain" class="ui-widget">
  	 
<div id="page_PastNewuser" class="page_PastNewuser" dir="rtl" style="width:600px;height:800px;">
 
 
<h3>הוסף משתמש</h3>


 
<form   name="edit_newPastuser"   id="edit_newPastuser" >
<p class="validateTips">כול השדות נחוצים.</p>



<div class="form-row">
  
    
    
     <span class="h"><?php __('active');?></span><?php form_empty_cell_no_td(4);?> 
    <SELECT name="active2" id="active2" class="text ui-widget-content ui-corner-all">
      <option value="1" selected>פעיל</option>
      <option value="0">לא פעיל</option>
      
    </SELECT>
    &nbsp; 
    
    
    
</div>



<div class="form-row">
 <span class="h"><?php __('level');?></span> <?php form_empty_cell_no_td(2);?>
 <SELECT name="level" id="level2" class="text ui-widget-content ui-corner-all">  
    <option value="1" selected>חבר</option>
    <option value="2"><?php __(admin) ?></option>
    <option value="3"><?php __(suppervizer) ?></option>
    <option value="4">מנהל+חבר</option>

</SELECT>

</div> 







<div class="form-row"><span class="h"><?php __('full_name');?></span> <?php form_empty_cell_no_td(5);?> 

<?php 

 $sql = "SELECT u.* FROM users u  ORDER BY u.full_name ";
//			LEFT JOIN rel_user_forum_history r   ON u.userID=r.userID
//			WHERE u.userID NOT IN(SELECT DISTINCT(userID) FROM rel_user_forum_history)
//			ORDER BY u.full_name ";
		if($rows2= $db->queryObjectArray($sql)){
		foreach($rows2 as $row){
		  $array[$row->userID] = $row->full_name;	
		   }
		}	

		
         form_list_idx_one("full_name2",$array, array_item($formdata, "full_name2"),'id=full_name2');          

 ?>


</div>



<div class="form-row"><span class="h"><?php __('frmName');?></span> <?php form_empty_cell_no_td(9);?> 
 
<?php 
 
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats[$row->parentForumID][] = $row->forum_decID;
			$catNames[$row->forum_decID] = $row->forum_decName;
 
		
		}

$rows = build_category_array($subcats[NULL], $subcats, $catNames);
  		
		 form_list_find_notd ("new_frm_name", "new_frm_name",$rows , array_item($formdata, "new_frm_name") );	
      
        
?> 
 

</div>


<div class="form-row"><span class="h">תאריך התחלה</span><?php form_empty_cell_no_td(3); ?> 
  <input name="user_date2" id="user_date2" value="" class="text ui-widget-content ui-corner-all" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>




<div class="form-row"><span class="h">תאריך סיום</span><?php form_empty_cell_no_td(3); ?> 
    <input name="user_date1" id="user_date1" value="" class="text ui-widget-content ui-corner-all" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>




<div class="form-row"><span class="h"><?php __('note');?></span><br>  
 <textarea name="note2" id="note2" class="text ui-widget-content ui-corner-all"></textarea>
</div>


  
 

</form>

 

</div> <!--  end of page_Newuser -->  
   
</div>
<!-- ============================================================================================================ --> 
  
   	 
   	  </div><!-- end content --> 
   	   </div>  <!-- end container -->
      </div>	</fieldset>  <!-- end wrapper -->
   	   
   	  



<?php html_footer(); ?>
 