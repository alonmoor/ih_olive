<?PHP  
function  build_task_form_find($decID,$forum_decID,$mgr ){
 ini_set('display_errors', 'On');
  

 global $lang;
 
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
 $tabDisabled = '';

$sort = 0;
 

$sort1 = 0;
 
$task_id=$_GET['id'];
 echo $task_id;
 
if($config['duedateformat'] == 2) $duedateformat = 'm/d/yy';
elseif($config['duedateformat'] == 3) $duedateformat = 'dd.mm.yy';
else $duedateformat = 'yy-mm-dd';

?> 
<link rel="stylesheet" type="text/css" media="screen"    href="<?php echo CSS_DIR ?>/style_test.css" />
 <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/progressbar.css"  /> 
 <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/fancybox/jquery.fancybox-1.2.6.css" />


 <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />
 <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $forum_decID?>" />
 <input type=hidden name="my_task_view" id="my_task_view" value="<?php echo $decID;echo $forum_decID;?>" />
<?php 
global $db;
 



$getTask_sql="SELECT t.* ,f.forum_decName,m.managerName FROM todolist t
                    LEFT JOIN decisions  d
			            		 ON d.decID=t.decID 
			        LEFT JOIN forum_dec  f
			                     ON f.forum_decID=$forum_decID
			         LEFT JOIN managers m
			                         ON m.managerID=f.managerID                                   		 
                     LEFT JOIN rel_user_task  rt
			            	      ON rt.taskID=t.taskID 
			         LEFT JOIN users u
			            		  ON u.userID=rt.userID 
			         WHERE t.compl IN(0,1) 
			         AND t.decID=$decID
			         AND t.forum_decID=$forum_decID 
                     ORDER BY t.taskID DESC";
                        
if($getTask= $db->queryObjectArray($getTask_sql)  ){
$frm_Name=$getTask[0]->forum_decName;
$mgr_Name=$getTask[0]->managerName;	
$getTask_Total	=	count($getTask);
}else{
$sql="SELECT  f.forum_decName,m.managerName FROM forum_dec f
                    INNER JOIN rel_forum_dec  r
			            		 ON r.forum_decID=f.forum_decID
                    INNER JOIN decisions  d
			            		 ON r.decID=d.decID 
			            		 
			        
			         INNER JOIN managers m
			                         ON m.managerID=f.managerID                                   		 
                     
			        WHERE d.decID=$decID
			        AND f.forum_decID=$forum_decID";
	
 if($rows=$db->queryObjectArray($sql)){
 	
	$frm_Name=$rows[0]->forum_decName;
	$mgr_Name=$rows[0]->managerName;	
 	
 }
	
$getTask_Total	=0;	
}


/**************************************************************************************/
  $sql="                 
    SELECT u.userID  FROM users u          
                     WHERE u.userID=(SELECT m.userID FROM managers m
                     WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";                     

     if($rows=$db->queryObjectArray($sql )){
     	$mgr_userID=$rows[0]->userID;
     }
  
  
                       
 $sql=" SELECT  u.userID   FROM users u	                 
 	                 
	
                     INNER JOIN rel_user_forum r  
                     ON u.userID = r.userID     
                     
                     INNER JOIN  forum_dec f  
                     ON f.forum_decID = r.forum_decID  
                              
                                             
                              
                     WHERE r.forum_decID =$forum_decID     ";
                       
                       
      if($rows=$db->queryObjectArray($sql )){
	
 
for($i=0; $i<count($rows); $i++){	
				if($i==0){
					$userIDs = $rows[$i]->userID;
				}
				else{
					$userIDs .= "," . $rows[$i]->userID;

				}
			
			}
 	
}	                 
 

  $sql="  SELECT     u.*, f.forum_decID,f.tagID,f.tags,f.duedate,f.prio,f.manager_date,m.managerID  FROM forum_dec f
        
                     
                     LEFT JOIN managers m 
                     ON f.managerID = m.managerID
                      
                      INNER   JOIN users u  
                     ON u.userID = m.userID  
                      
                     WHERE f.managerID IN ($mgr)
                     AND f.forum_decID=$forum_decID
                     UNION  

                     SELECT   u.*,  r.forum_decID,r.tagID,r.tags,r.duedate,r.prio,r.HireDate,m.managerID  FROM users u 
                     
                     LEFT JOIN rel_user_forum r  
                     ON u.userID = r.userID
                      
                     INNER JOIN forum_dec f  
                     ON f.forum_decID = r.forum_decID
                     
                     INNER   JOIN managers m  
                     ON f.managerID = m.managerID       
                      
                     WHERE u.userID IN ($userIDs)
                     
                     AND r.forum_decID=$forum_decID"; 
    
if($getUser		=	$db->queryObjectArray($sql) ) {
$getUser_Total	=	count($getUser);


/*******************************************************************************/
$get_mgr="SELECT managerID from forum_dec WHERE forum_decID=$forum_decID";
if($rows=$db->queryObjectArray($get_mgr)){
$mgr=$rows[0]->managerID;	
 }
} 
/*****************************************************************************/
$sql="select decName from decisions where decID=$decID" ;
if($row_dec=$db->queryObjectArray($sql)){
$decName1=$row_dec[0]->decName;	
}

?>
 



<h3 class="my_dec_eh_title_table_<?php echo $forum_decID?>" style="height:15px;cursor:pointer;"></h3> 



 <fieldset id="task_fieldset_<?php echo $forum_decID;?>"   style="width:92%; background: #94C5EB url(../images/background-grad.png) repeat-x;" >
   <div id="forumProgbar_<?php echo $decID; echo $forum_decID;?>"></div> 
   
   
   <div id="loading">
      <img src="../images/loading4.gif" border="0" />
   </div> 



  
<div id="wrapper<?php echo $decID;echo $forum_decID;?>"    class="wrapper" >
<div id="container<?php echo $decID;echo $forum_decID;?>"  class=container"">
<div id="body<?php echo $decID;echo $forum_decID;?>"  class="body" >


<br clear="all"  />

 
<h1 style="color:white"><?php __('ניהול משימות');?><?php echo ' -  '; echo $frm_Name; ?>  </h1>                                                                                                  
<h3 style="color:#106665"><?php __('החלטה');?><?php echo ' -  '; echo $decName1; ?>  </h3>   
<h2 style="color:red"><?php __('מרכז ועדה');?><?php echo ' -  '; echo $mgr_Name;echo ':  '; ?>
<?php if ($level){?>
<a id="fullcalendar-link_<?php echo $forum_decID; ?>" class="iframe" href= <?php echo " '".ROOT_WWW."/admin/full_calendar/insert_ajx4.php?userID=$mgr_userID&decID=$decID&forum_decID=$forum_decID' "; ?>> יומן מנהל</a> 
<?php }?>
</h2>
 
<!-- ============================================================================================================ -->
<div id="page_tasks<?php echo $decID;echo $forum_decID;?>"  class="page_tasks">
 <!-- ============================================================================================================ -->
<div id="tabs<?php echo $decID;echo $forum_decID;?>" class="tabs ul">
 
  <ul class="tabs ul" >
	<li class="tabs"><a href="#newtask<?php echo $decID;echo $forum_decID;?>"><strong>משימות</strong></a></li>
	<li class="tabs"><a href="#searchtask<?php echo $decID;echo $forum_decID;?>"><strong><?php __('tab_search');?></strong></a></li>
	<!--<li class="tabs"><a href="#usermanager<?php echo $decID;echo $forum_decID;?>"><?php __('tab_users');?></a></li>
  --></ul>
  
  <br clear="all" class="all" />
<!-- ------------------------------------------------------------------------------------------------- -->   
 <?php  if ($level){?>  
  <div class="tab-content"   id="newtask<?php echo $decID;echo $forum_decID;?>"> 
  
 
 
  <form   action=""  name="addtask<?php echo $decID;echo $forum_decID;?>"  id="addtask<?php echo $decID;echo $forum_decID;?>"  value="<?php echo $decID;echo $forum_decID;?>"  class="addtask">
       <input type="text" name="task<?php echo $decID;echo $forum_decID;?>" value=""   maxlength="250"   id="task<?php echo $decID;echo $forum_decID;?>" class="task" /> 
	       <input type="hidden" name="id<?php echo $decID;echo $forum_decID;?>"  value="<?php echo $decID;echo $forum_decID;?>" />
&nbsp;
<span class="red2"><?php __('sendBY') ?></span>
 
<select name="select<?php echo $decID;echo $forum_decID;?>" id="selectUser<?php echo $decID;echo $forum_decID;?>" class="mycontrol"  style="width:110px;" width=5 >
	 <option value="none">(בחר אופציה)</option>
           <?php
           
          /******************************************************************************************************/ 
           foreach($getUser as $row) {
          /******************************************************************************************************/     	
           ?>
          <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
          <?php 
          } 
         ?>
</select> 
     
 
<span class="red2"><?php __('too_a') ?></span>
    <select name="selectUser1<?php echo $decID;echo $forum_decID;?>" id="selectUser1<?php echo $decID;echo $forum_decID;?>" class="mycontrol" style="width:110px;"  width="8">
    <option value="none">(בחר אופציה)</option>
           <?php
          /******************************************************************************************************/ 
           foreach($getUser as $row) {
          /******************************************************************************************************/     	
           ?>
          <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
          <?php 
          } 
         ?>
   </select>
   
   
   <span class="red2">קטגוריה</span>
    <SELECT name="categoryTask" class="mycontrol"  style="width:60px;" id="categoryTask<?php echo $decID;echo $forum_decID;?>">
       <option value="1">פרטי</option>
       <option value="0" selected>  ציבורי</option>
    </SELECT> 

  
  
  <input type="hidden" id="button_action" name="button_action" />
  <input type="button"  name="<?php __('btn_add');echo $decID;echo $forum_decID;?>"  
    id="<?php __('btn_add'); echo $decID;echo $forum_decID;?>"  value="<?php __('btn_add');?>"   
   class="mybutton"  onclick="submitNewTask_2(this,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);"  /> 
 	</form>
 
  </div>   

<?php }?>	 
 <!-- ---------------------------------------SEARCH---------------------------------------------------------- -->
 	
 
  <div class="tab-content" id="searchtask<?php echo $decID;echo $forum_decID;?>">
	
	<form onSubmit="return searchTasks2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>)";>
	 
	 <input type="text" name="search<?php echo $decID;echo $forum_decID;?>"  value=""  maxlength="250" id="search<?php echo $decID;echo $forum_decID;?>"
	  onKeyUp="timerSearch(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>)";   autocomplete="off" />
	 
	 <input type="submit" value="<?php __('btn_search');?>" />
	</form>
	
	<div id="searchbar<?php echo $decID;echo $forum_decID;?>">
	 <?php __('searching');?> 
	 <span id="searchbarkeyword"<?php echo $decID;echo $forum_decID;?>></span>
   </div>
 </div>
 
 
 
<!-- ------------------------------------------------------------------------------------------------- -->  
  
 <!--  
     <div  class="tab-content"  id="usermanager<?php echo $decID;echo $forum_decID;?>" >
        <form onSubmit="return submitNewUser(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>)">
	       
	       <a href="javascript:loadUsers(<?php echo " '".ROOT_WWW."/admin/' "; ?>);">הראה משתמשים</a> | 
	  
           <a href="javascript:showhide('addUser');">הוסף משתמש חדש</a> |
          
        
            
           <span id="tagusercloudbtn1<?php echo $decID;echo $forum_decID;?>" onClick="showuserTagCloud(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>);" title="<?php __('usertags');?>">
             <span class="btnstr"><?php __('usertags');?></span> 
               <img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif"></span>
               
            
	     </form>
      </div> 
  -->    
        
</div>  
 

 
<!-- =========================end div tub===========================MENUE_H3_DEFAULT======================================================== --> 
 <div id="tagcloud<?php echo $decID;echo $forum_decID;?>" style="display:none">
 <div id="tagcloudcancel<?php echo $decID;echo $forum_decID;?>" onClick="cancelTagFilter2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);"><?php __('tagfilter_cancel');?></div>
 <div id="tagcloudload<?php echo $decID;echo $forum_decID;?>"><img src="<?php echo TASK_IMAGES_DIR ?>/loading1_24.gif"></div>
 <div id="tagcloudcontent<?php echo $decID;echo $forum_decID;?>"></div>
</div>
<h3 class="my_title_b"> 
 

 

<ul id="qm0" class="qmmc" style="float:right;-moz-border-radius: 5px;">



	
<?php  if ($level){?> 
	<li><a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;"   
onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"     href="javascript:void(0)">פעולות כפולות</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0)"    onClick="loadTasks2del2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);multiviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">מחק כמה משימות</a></li>
		<li><a href="javascript:void(0)"    onClick="loadUsers2send2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);multiviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);" >שלח משימה אחת לכמה אנשים</a></li>
		</ul>
	</li>
<?php }?>		
		
<li><a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;"   
onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"     href="javascript:void(0)">מיון ידני</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0)"     onClick="setSort2(0,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">מיון ידני</a></li>
		<li><a href="javascript:void(0)"     onClick="setSort2(1,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">מיון לפי עדיפויות</a></li>
		<li><a href="javascript:void(0)"     onClick="setSort2(2,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">מיון לפי תאריכים</a></li>
		</ul>
</li>		
		
		
		
		
		
		

	<li>
	     <a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;"   
onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"     href="javascript:void(0)">סינון לפי תגיות</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0);"   onClick="showTagCloud2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>);" title="<?php __('tags');?>">בטל/אפשר סינון לפי תגיות</a></li>
		</ul>
  </li>

	<li> <a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;" 
	
	onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"  href="javascript:void(0);">נתוני משימות</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0);"    onClick="setTaskview2(0,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);" onfocus="if (this.blur) this.blur();">משימות</a></li>
		<li><a href="javascript:void(0);"    onClick="setTaskview2(1,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);" onfocus="if (this.blur) this.blur();">משימות+משימות שבוצעו</a></li>
		<li><a href="javascript:void(0);"    onClick="setTaskview2(2,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);" onfocus="if (this.blur) this.blur();">משימות שבוצעו</a></li>
		<li><a href="javascript:void(0);"    onClick="setTaskview2(3,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);" onfocus="if (this.blur) this.blur();">קבוץ משימות לפי שולחים</a></li>
		<li><a href="javascript:void(0);"    onClick="setTaskview2(7,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);" onfocus="if (this.blur) this.blur();">קבוץ משימות לפי מקבלים</a></li>
		<li><a href="javascript:void(0);"    onClick="setTaskview2('past',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">מתעכבות</a></li>
		<li><a href="javascript:void(0);"    onClick="setTaskview2('today',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">היום ומחר</a></li>
		<li><a href="javascript:void(0);"    onClick="setTaskview2('soon',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">בקרוב</a></li>
		</ul></li>

<li class="qmclear">&nbsp;</li>

</ul>


	 
<!-- ----------------------------------------------------------------------------- -->  	  
</h3>


 <div  id="taskcontainer<?php echo $decID;echo $forum_decID;?>"  class="taskcontainer">
  <h4 class="my_title_<?php echo $decID;echo $forum_decID;?>" style="height:15px"></h4>
     <ol id="tasklist<?php echo $decID;echo $forum_decID;?>" class="sortable"></ol>
 </div>



</div>   <!-- end of page_tasks -->
<!-- ============================================================================================================ -->


<div id="page_taskedit<?php echo $decID;echo $forum_decID;?>" style="display:none">

<h3><?php __('edit_task');?></h3>


<div id="progress<?php echo $decID;echo $forum_decID;?>" style="height : 10px; background:#2CE921;color:#8EF6F8 ;" ></div>

<div style="height:15px;"></div>
<?php  if ($level){?> 
 <button id="increase<?php echo $decID;echo $forum_decID;?>" onClick="progress_bar_plus(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false;">עלייה ב- 10%</button>
 <button id="increase_2<?php echo $decID;echo $forum_decID;?>" onClick="progress_bar_minus(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false;">ירידה ב- 10%</button>
<?php }?>



 
<form onSubmit="return saveTask2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);" name="edittask<?php echo $decID;echo $forum_decID;?>" id="edittask<?php echo $decID;echo $forum_decID;?>">

 

<input type="hidden" name="Request_Tracking_Number1<?php echo $decID;echo $forum_decID;?>" id="Request_Tracking_Number1<?php echo $decID;echo $forum_decID;?>" value="" />

 <input type="hidden" name="prog_bar<?php echo $decID;echo $forum_decID;?>" id="prog_bar<?php echo $decID;echo $forum_decID;?>" value="" /> 
 
&nbsp;

<div class="form-row"><span class="h"><?php __('sendBY');?> </span>

 
<select name="userselect<?php echo $decID;echo $forum_decID;?>" id="userselect<?php echo $decID;echo $forum_decID;?>" class="mycontrol">
           <?php foreach($getUser as $row) {  ?>
                    <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
              <?php 
             } 
         ?>
</select>&nbsp; <span class="h"><?php __('too_a');?> </span>


<select name="userselect1<?php echo $decID;echo $forum_decID;?>" id="userselect1<?php echo $decID;echo $forum_decID;?>" class="mycontrol">
           <?php foreach($getUser as $row) {  ?>
                    <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
              <?php 
             } 
         ?>
</select>
 
</div>
 
 
 
  <div class="form-row"><span class="h"><?php __('priority');?></span>
    <SELECT name="prio" class="mycontrol" id="prio<?php echo $decID;echo $forum_decID;?>">
       <option value="3">+3</option>
       <option value="2">+2</option>
       <option value="1">+1</option>
       <option value="0" selected>&plusmn;0</option>
       <option value="-1">&minus;1</option>
    </SELECT> 
 &nbsp; <span class="h"><?php __('due');?> </span> <input name="duedate"  class="mycontrol" id="duedate<?php echo $decID;echo $forum_decID;?>" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
 </div>
 
 <div class="form-row"><span class="h">קטגוריה</span>
    <SELECT name="catTask" class="mycontrol" id="catTask<?php echo $decID;echo $forum_decID;?>">
       <option value="1">פרטי</option>
       <option value="0" selected>ציבורי</option>
    </SELECT> 

 </div>
 
 



 
 
 
<div class="form-row"><span class="h"><?php __('task');?></span><br /> 
 <input type="text" name="task_name<?php echo $decID;echo $forum_decID;?>" id="task_name<?php echo $decID;echo $forum_decID;?>" value="" class="in500" maxlength="250" />
</div>

<div class="form-row"><span class="h"><?php __('note');?></span><br /> 
 <textarea name="note<?php echo $decID;echo $forum_decID;?>" id="note<?php echo $decID;echo $forum_decID;?>" class="in500"></textarea>
</div>

<div class="form-row"><span class="h"><?php __('tags');?></span><br /> 
 <input type="text" name="tags<?php echo $decID;echo $forum_decID;?>"  id="edittags<?php echo $decID;echo $forum_decID;?>"  value="" class="in500" maxlength="250" />
</div>

<div class="form-row">

<?php  if ($level){?> 
   <input type="submit" value="<?php __('save');?>" onClick="this.blur()" /> 
<?php }?>   
   <input type="button"  id="my_button_win<?php echo $decID;echo $forum_decID;?>"  value="<?php __('forum_details');?>" class="href_modal1" />
  <input type="hidden" name="calendar_link<?php echo $decID;echo $forum_decID;?>" id="calendar_link<?php echo $decID;echo $forum_decID;?>" value="" />




   <input type="button" value="<?php __('cancel');?>" onClick="cancelEdit2(<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>);this.blur();return false;" />
</div>
</form>

</div> <!--  end of page_task_edit  -->


<!-- ============================================================================================================ -->
 
<?php  if ($level){?> 
 <div id="priopopup<?php echo $decID;echo $forum_decID;?>" style="display:none">
 <span class="prio-neg" onClick="prioClick2(-1,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo decID; ?>,<?php echo $forum_decID; ?>)">&minus;1</span> 
 <span class="prio-o" onClick="prioClick2(0,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID; ?>,<?php echo $forum_decID; ?>)">&plusmn;0</span>
 <span class="prio-pos" onClick="prioClick2(1,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID; ?>,<?php echo $forum_decID; ?>)">+1</span> 
 <span class="prio-pos" onClick="prioClick2(2,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID; ?>,<?php echo $forum_decID; ?>)">+2</span>
 <span class="prio-pos" onClick="prioClick2(3,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID; ?>,<?php echo $forum_decID; ?>)">+3</span>
</div>
<?php }?>

<!-- ==================================================SET_TASK_VIEW========================================================== -->
<div id="taskview<?php echo $decID;echo $forum_decID;?>"  style="display:none;">
  
 <div class="li" onClick="setTaskview2(0,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
  <span id="view_tasks<?php echo $decID;echo $forum_decID;?>"><?php __('tasks');?></span>
 </div>
 
 
 
 <div class="li" onClick="setTaskview2(1,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
 <span id="view_compl<?php echo $decID;echo $forum_decID;?>"><?php __('tasks_and_compl');?></span>
 </div>
 
 
 
 
 
 <div class="li" onClick="setTaskview2(2,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
  <span id="view_compl1<?php echo $decID;echo $forum_decID;?>"><?php __('tasks_compl');?></span>
 </div>
 
 
 
 
 <div class="li" onClick="setTaskview2(3,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
  <span id="view_compl2<?php echo $decID;echo $forum_decID;?>"><?php __('sortBygroupBy');?></span>
 </div>
  


<div class="li" onClick="setTaskview2(7,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
   <span id="view_compl3<?php echo $decID;echo $forum_decID;?>"><?php __('sortgroupBy');?></span>
</div>
  
  
 
 <div class="li" onClick="setTaskview2('past',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
  <span id="view_past<?php echo $decID;echo $forum_decID;?>"><?php __('f_past');?></span> (<span id="cnt_past<?php echo $decID;echo $forum_decID;?>">0</span>)
 </div>
 
 <div class="li" onClick="setTaskview2('today',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
 <span id="view_today<?php echo $decID;echo $forum_decID;?>"><?php __('f_today');?></span> (<span id="cnt_today<?php echo $decID;echo $forum_decID;?>">0</span>)
 </div>
  
  <div class="li" onClick="setTaskview2('soon',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);taskviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
  <span id="view_soon<?php echo $decID;echo $forum_decID;?>"><?php __('f_soon');?></span> (<span id="cnt_soon<?php echo $decID;echo $forum_decID;?>">0</span>)
 </div>
</div>
 
 
 
 
<!-- ============================================================================================================ -->


<div id="sortform<?php echo $decID;echo $forum_decID;?>" style="display:none">
  <div id="sortByHand<?php echo $decID;echo $forum_decID;?>" class="li" onClick="setSort2(0,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);"><?php __('sortByHand');?></div>
  <div id="sortByPrio<?php echo $decID;echo $forum_decID;?>" class="li" onClick="setSort2(1,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);"><?php __('sortByPriority');?></div>
  <div id="sortByDueDate<?php echo $decID;echo $forum_decID;?>"  class="li" onClick="setSort2(2,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);"><?php __('sortByDueDate');?></div>
</div>
  

<!--<div id="tagcloud<?php echo $decID;echo $forum_decID;?>" style="display:none">
 <div id="tagcloudcancel<?php echo $decID;echo $forum_decID;?>" onClick="cancelTagFilter2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);"><?php __('tagfilter_cancel');?></div>
 <div id="tagcloudload<?php echo $decID;echo $forum_decID;?>"><img src="<?php echo TASK_IMAGES_DIR ?>/loading1_24.gif"></div>
 <div id="tagcloudcontent<?php echo $decID;echo $forum_decID;?>"></div>
</div>




--><!-- =============================================multiview_TUB=============================================================== -->



<div id="multiview<?php echo $decID;echo $forum_decID;?>" style="display:none">
  
 
 <div class="li" onClick="loadTasks2del2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);multiviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
 <span id="view_multi<?php echo $decID;echo $forum_decID;?>"><?php __('del_tasks');?></span>
 </div>
 
 <!-- ajx_multi_users.js -->
 <div class="li" onClick="loadUsers2send2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);multiviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
  <span id="view_multi_send<?php echo $decID;echo $forum_decID;?>"><?php __('send_tasks');?></span>
 </div>
 
  
</div>

<!-- =====================================================page_Del_taskedit_multi======================================================= -->
 
<div id="page_taskedit_multi<?php echo $decID;echo $forum_decID;?>" style="display:none">

<h3><?php __('del_tasks');?></h3>

<form   action=""  name="delMultiTasks<?php echo $decID;echo $forum_decID;?>"  id="delMultiTasks<?php echo $decID;echo $forum_decID;?>"  value=""  class="deltask">






<div class="form-row">
    <input id="delete<?php echo $decID;echo $forum_decID;?>" type="submit" class="button" name="deleteMultiTask<?php echo $decID;echo $forum_decID;?>" value="מחק" onClick="return deleteMultiTask2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false" />
  
   <input type="button" value="חזור" onClick="cancelEdit_multi2(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false" />
</div> 

</form>
<div   name="edittask_multi<?php echo $decID;echo $forum_decID;?>" id="edittask_multi<?php echo $decID;echo $forum_decID;?>" ></div>
</div> <!--  end of page_taskedit_multi  --> 


<!-- ----------------------------------------------SubmitTask2users2--------------------------------------------------- --> 
<div id="page_task2users_multi<?php echo $decID;echo $forum_decID;?>" style="display:none">
<h2><?php __('send_tasks');?></h2> 
<h3>  

<form   action=""  name="addtask2users<?php echo $decID;echo $forum_decID;?>"  id="addtask2users<?php echo $decID;echo $forum_decID;?>"  value=""  class="addtask">
 
      <input type="text" name="task2users<?php echo $decID;echo $forum_decID;?>" value=""   maxlength="500"   id="task2users<?php echo $decID;echo $forum_decID;?>" class="task"  style="width:490px"/> 
	       <input type="hidden" name="id<?php echo $decID;echo $forum_decID;?>"  value="<?php echo $decID;echo $forum_decID;?>" />
	 &nbsp;
	 
	 <span class="red2">קטגוריה</span>
    <SELECT name="catTaskMulti" class="mycontrol" id="catTaskMulti<?php echo $decID;echo $forum_decID;?>">
       <option value="1">פרטי</option>
       <option value="0" selected>ציבורי</option>
    </SELECT>
    
     &nbsp; 
<span class="red2"><?php __('sendBY') ?></span>
 
	 <select name="select<?php echo $decID;echo $forum_decID;?>" id="selectUsers<?php echo $decID;echo $forum_decID;?>" class="mycontrol" width=5  height=10 size=1>
	 <option value="none">(בחר אופציה)</option>
           <?php
           
          /****************************************************************************************** ************/ 
           foreach($getUser as $row) {
          /******************************************************************************************************/     	
           ?>
          <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
          <?php 
          } 
         ?>
   </select>
   <span class="red2"><?php __('too_a') ?></span> 	   
   
     
</form> 
</h3>




<div   name="edittask2users_multi<?php echo $decID;echo $forum_decID;?>" id="edittask2users_multi<?php echo $decID;echo $forum_decID;?>" ></div>


<div class="form-row">
     <input id="send<?php echo $decID;echo $forum_decID;?>" type="submit" class="button" name="sendMultiTask2users<?php echo $decID;echo $forum_decID;?>" value="שלח משימה" onClick="return SubmitTask2users2(this,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);this.blur();return false" />
     <input type="button" value="חזור" onClick="cancelEdit_Tuser_multi2(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false" />
</div> 



</div> <!--  end of page_task2users_multi  --> 

<!-- ----------------------------------------------SHOW_USER_VIEW--------------------------------------------------- -->

  
 
  <h5 style="height:180px;"></h5>
  <div id="tagusercloud<?php echo $decID;echo $forum_decID;?>" style="display:none"><!-- divs for data -->
 <div id="tagusercloudcancel<?php echo $decID;echo $forum_decID;?>" onClick="canceluserTagFilter2(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);taguserCloudClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);"><?php __('tagfilter_cancel');?></div>
 <div id="tagusercloudload<?php echo $decID;echo $forum_decID;?>"><img src="<?php echo TASK_IMAGES_DIR ?>/loading1_24.gif"></div>
 <div id="tagusercloudcontent<?php echo $decID;echo $forum_decID;?>"></div>
</div> 
 
 
 
 <div id="tagusercloud_all<?php echo $decID;echo $forum_decID;?>" style="display:none"><!-- divs for data -->
   <div id="tagusercloudcancel_all<?php echo $decID;echo $forum_decID;?>" onClick="canceluserTagFilter3(<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);taguserCloudClose3(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);"><?php __('tagfilter_cancel');?></div>
   <div id="tagusercloudload_all<?php echo $decID;echo $forum_decID;?>"><img src="<?php echo TASK_IMAGES_DIR ?>/loading1_24.gif"></div>
   <div id="tagusercloudcontent_all<?php echo $decID;echo $forum_decID;?>"></div>
</div>   
 <!-- 
   <span id="userviewcontainer<?php echo $decID;echo $forum_decID;?>" 
       onClick="showUserview2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>,<?php echo $mgr_userID;?>,<?php echo $mgr; ?>);">
 
     <span class="btnstr"><?php form_empty_cell_no_td(2);   __('users');?></span> 
     (<span id="total1<?php echo $decID;echo $forum_decID;?>">0</span>) &nbsp;<img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif">
    
   </span>
   
   
   
 <span id="tagusercloudbtn<?php echo $decID;echo $forum_decID;?>" 
     onClick="showuserTagCloud2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>,<?php echo $mgr_userID; ?>);" title="<?php __('tags');?>">
      <span class="btnstr"><?php form_empty_cell_no_td(3);  __('tags');?></span> 
     <img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif">
 </span>



 <span id="usersort<?php echo $decID;echo $forum_decID;?>" 
         onClick="showuserSort2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>,<?php echo $mgr_userID;?>,<?php echo $mgr; ?>);"  title="<?php __('sortByHand');?>">
      
          <span class="btnstr"><?php form_empty_cell_no_td(3);  __('sortByHand');?></span> 
          <img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif" alt="עשה איתי משהו" title="" />
 </span>       
 -->
 <ul id="qm0" class="qmmc" style="float:right;-moz-border-radius: 5px;">



	

<li><a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;"   
onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"     href="javascript:void(0)">מיון ידני</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0)"     onClick="setuserSort2(0,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortuserClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);">מיון ידני</a></li>
		<li><a href="javascript:void(0)"    onClick="setuserSort2(1,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortuserClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);">מיון לפי עדיפויות</a></li>
		<li><a href="javascript:void(0)"    onClick="setuserSort2(2,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortuserClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);">מיון לפי תאריכים</a></li>
		</ul>
</li>		
		
		
		
		
		
		

	<li>
	     <a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;"   
onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"     href="javascript:void(0)">סינון לפי תגיות</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0);"    onClick="showuserTagCloud2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>,<?php echo $mgr_userID; ?>);" title="<?php __('tags');?>">בטל/אפשר סינון לפי תגיות</a></li>
		</ul>
  </li>





	<li>
	     <a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;"   
onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"     href="javascript:void(0)">סנון כול המשתמשים לפי תגיות</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0);"    onClick="showuserTagCloud_all(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>,<?php echo $mgr_userID; ?>);" title="<?php __('tags');?>">בטל/אפשר סנון כול המשתמשים לפי תגיות</a></li>
		</ul>
  </li>





	<li> <a class="qmparent" style="float:right; font-weight :bold;font-size:15px;color:white;" 
	
	onmouseover="this.style.color='#7CDF2D'"    onmouseout="this.style.color='white'"  href="javascript:void(0);">מנהל+חברי פורום</a>

		<ul style="-moz-border-radius: 5px;">
		<li><a href="javascript:void(0);"    onClick="setUserview2(0,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">מנהל+חברי פורום</a></li>
		<li><a href="javascript:void(0);"    onClick="setUserview2(1,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">חברי פורום פתוחים+סגורים</a></li>
		<li><a href="javascript:void(0);"    onClick="setUserview2(2,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">חברי פורום סגורים</a></li>
		<li><a href="javascript:void(0);"    onClick="setUserview2('past1',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">מתעכבים במשימה אחרונה</a></li>
		<li><a href="javascript:void(0);"    onClick="setUserview2('today1',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">משימות להיום או מחר</a></li>
		<li><a href="javascript:void(0);"    onClick="setUserview2('soon1',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">משימות לזמן הקרוב</a></li>
		</ul></li>

<li class="qmclear">&nbsp;</li>

</ul>


	 
<!-- ----------------------------------------------------------------------------- -->  	  
   
      	  



 

<div id="usercontainer<?php echo $decID;echo $forum_decID;?>">
   <h4 class="my_usertitle_<?php echo $decID;echo $forum_decID;?>" style="height:15px; "></h4>
   <ol id="userlist<?php echo $decID;echo $forum_decID;?>" class="sortable"></ol>
</div>
 

<!-- </div> -->
 
 
 
<!-- ============================================================================================================ -->

<div id="page_useredit<?php echo $decID;echo $forum_decID;?>" style="display:none">

<h3><?php __('edit_user');?></h3>


<form onSubmit="return saveUser2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>)" name="edituser" id="edituser<?php echo $decID;echo $forum_decID;?>">
<input type="hidden" name="id<?php echo $decID;echo $forum_decID;?>" value="" />
<input type="hidden" name="Request_Tracking_Number1" id="Request_Tracking_Number1" value="" />
<div class="form-row">
  <span class="h"><?php __('priority');?></span> 
    <SELECT name="prio" id="prio<?php echo $decID;echo $forum_decID;?>" class="mycontrol">
      <option value="3">+3</option>
      <option value="2">+2</option>
      <option value="1">+1</option>
      <option value="0" selected>&plusmn;0</option>
      <option value="-1">&minus;1</option>
     </SELECT>
</div>

<div class="form-row">
     <span class="h"><?php __('dueForum');?> </span> 
     <input name="duedate_1<?php echo $forum_decID;?>" id="duedate_1<?php echo $forum_decID;?>" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
   
     <span class="h"><?php __('dueLast');?> </span>
     <input name="duedate2<?php echo $decID;echo $forum_decID;?>" id="duedate2<?php echo $decID;echo $forum_decID;?>" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>


<div class="form-row">
 <span class="h"><?php __('level');?></span> 
 <SELECT name="level" id="level<?php echo $decID;echo $forum_decID;?>" class="mycontrol">  
  <option value="1"><?php __(forum_user) ?></option>
  <option value="2"><?php __(admin) ?></option>
  <option value="3"><?php __(suppervizer) ?></option>
  <option value="none" selected>(בחר אופציה)</option>
</SELECT>

</div> 


<div class="form-row"><span class="h"><?php __('full_name');?></span><br /> <input type="text" name="full_name" id="full_name<?php echo $decID;echo $forum_decID;?>" value="" class="in200" maxlength="50"   /></div>
 
 <div class="form-row"><span class="h"><?php __('user');?></span><br /> <input type="text" name="user" id="user<?php echo $decID;echo $forum_decID;?>" value="" class="in200" maxlength="50"   /></div>
 
 <div class="form-row"><span class="h"><?php __('upass');?></span><br /> <input type="text" name="upass" id="upass<?php echo $decID;echo $forum_decID;?>"  value="" class="in200" maxlength="50" /></div>
 <div class="form-row"><span class="h"><?php __('email');?></span><br /> <input type="text" name="email"  id="email<?php echo $decID;echo $forum_decID;?>"    value="" class="in200" maxlength="50" /></div>
 <div class="form-row"><span class="h"><?php __('phone');?></span><br /> <input type="text" name="phone"  id="phone<?php echo $decID;echo $forum_decID;?>"    value="" class="in200" maxlength="50" /></div>
 <div class="form-row"><span class="h"><?php __('note');?></span><br />  <textarea name="note<?php echo $decID;echo $forum_decID;?>" id="note<?php echo $decID;echo $forum_decID;?>" class="in500"></textarea></div>
 <div class="form-row"><span class="h"><?php __('tags');?></span><br />  <input 	type="text" name="tags<?php echo $decID;echo $forum_decID;?>" id="edittags1<?php echo $decID;echo $forum_decID;?>" value="" class="in500" maxlength="250" /></div>


 <div class="form-row">
 <?php  if ($level){?> 
   <input type="submit" value="<?php __('save');?>" onClick="this.blur()" />
 <?php }?>  
    <input type="button"  id="my_button_win1<?php echo $decID;echo $forum_decID;?>"  value="<?php __('dec_details');?>" class="href_modal1" /> 
   <input type="button" value="<?php __('cancel');?>" onClick="canceluserEdit5(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false" />
 </div>
</form>



</div>  <!-- end of page_user_edit -->  



 
<!-- ===============================================SET_USER_VIEW2============================================================= -->

 
<div id="userview<?php echo $decID;echo $forum_decID;?>" style="display:none">
  
  <div class="li" onClick="setUserview2(0,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
   <span id="view_users<?php echo $decID;echo $forum_decID;?>"><?php __('users');?></span>
  </div>
 
  <div class="li" onClick="setUserview2(1,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
   <span id="view_compluser<?php echo $decID;echo $forum_decID;?>"><?php __('users_and_compl');?></span>
  </div>
  
  <div class="li" onClick="setUserview2(2,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
   <span id="view_compluser1<?php echo $decID;echo $forum_decID;?>"><?php __('users_compl');?></span>
  </div>
 
  <div class="li" onClick="setUserview2('past1',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
   <span id="view_past1<?php echo $decID;echo $forum_decID;?>"><?php __('f_past1');?></span>
    (<span id="cnt_past1<?php echo $decID;echo $forum_decID;?>">0</span>)
  </div>
 
  <div class="li" onClick="setUserview2('today1',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
   <span id="view_today1<?php echo $decID;echo $forum_decID;?>"><?php __('f_today');?></span> 
   (<span id="cnt_today1<?php echo $decID;echo $forum_decID;?>">0</span>)
  </div>
  
  <div class="li" onClick="setUserview2('soon1',<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>,<?php echo $mgr;?>);userviewClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>);">
   <span id="view_soon1<?php echo $decID;echo $forum_decID;?>"><?php __('f_soon');?></span> 
          (<span id="cnt_soon1<?php echo $decID;echo $forum_decID;?>">0</span>)
  </div>
</div>




<?php  if ($level){?> 
<div id="userpriopopup<?php echo $decID;echo $forum_decID;?>" style="display:none"><!-- divs for data -->
 <span class="prio-neg" onClick="priouserClick2(-1,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>)">&minus;1</span> 
 <span class="prio-o" onClick="priouserClick2(0,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>)">&plusmn;0</span>
 <span class="prio-pos" onClick="priouserClick2(1,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>)">+1</span> 
 <span class="prio-pos" onClick="priouserClick2(2,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>)">+2</span>
 <span class="prio-pos" onClick="priouserClick2(3,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo $mgr_userID;?>)">+3</span>
</div>
<?php }?> 


<div id="sortuserform<?php echo $decID;echo $forum_decID;?>" style="display:none" position="absulote"><!-- divs for data -->
 <div id="sortuserByHand<?php echo $decID;echo $forum_decID;?>" class="li" onClick="setuserSort2(0,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortuserClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);"><?php __('sortByHand');?></div>
 <div id="sortuserByPrio<?php echo $decID;echo $forum_decID;?>" class="li" onClick="setuserSort2(1,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortuserClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);"><?php __('sortByPriority');?></div>
 <div id="sortuserByDueDate<?php echo $decID;echo $forum_decID;?>"  class="li" onClick="setuserSort2(2,<?php echo $decID;?>,<?php echo $forum_decID;?>);sortuserClose2(<?php echo $decID;?>,<?php echo $forum_decID;?>,this);"><?php __('sortByDueDate');?></div>
</div>

 
 

 
 
  
 
 
<!-- =============================================TASKS4ME=============================================================== --> 

 
<div id="page_usertaskedit<?php echo $decID;echo $forum_decID;?>" style="display:none">

<h3><?php  __('tasks2me');// task written for me?></h3>

     

<span id="usertaskviewcontainer<?php echo $decID;echo $forum_decID;?>" onClick="showUserview(this);">
     <span class="btnstr"><?php __('tasks');?></span> 
     (<span id="total2<?php echo $decID;echo $forum_decID;?>">0</span>) &nbsp;<img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif">
</span>

   
 
          
<form   name="editusertask<?php echo $decID;echo $forum_decID;?>" id="editusertask<?php echo $decID;echo $forum_decID;?>">

 

<input type="hidden" name="id" value="" />
&nbsp;
	
<div class="form-row">
  
  <span class="h"><?php __('sendBY1');?> </span>

 
   <select name="userselect<?php echo $decID;echo $forum_decID;?>" id="userselect<?php echo $decID;echo $forum_decID;?>">
           <?php foreach($getUser as $row) {  ?>
                    <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
              <?php 
             } //usertaskedit=target
         ?>
  </select>&nbsp; 
    <span class="h"><?php __('too_a1');?> </span>


  <select name="userselect1" id="userselect1<?php echo $decID;echo $forum_decID;?>">
           <?php foreach($getUser as $row) {  ?>
                    <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
              <?php 
             } 
         ?>
  </select>
<div class="form-row">
  <span class="h"><?php __('priority');?></span> 
    <SELECT name="prio">
      <option value="3">+3</option>
      <option value="2">+2</option>
      <option value="1">+1</option>
      <option value="0" selected>&plusmn;0</option>
      <option value="-1">&minus;1</option>
     </SELECT>
    &nbsp; 
    <span class="h"><?php __('due');?> </span> 
    <input name="duedate" id="duedate2<?php echo $decID;echo $forum_decID;?>" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>


</div>
 
<div class="form-row"><span class="h"><?php __('task');?></span><br /> <input type="text" name="usertask"  id="usertask<?php echo $decID;echo $forum_decID;?>"  value="" class="in500" maxlength="250" /></div>
</form>
  
 <div class="form-row"> 
   <input type="button" value="<?php __('cancel');?>" onClick="cancelusertaskEdit_pop4me(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false" />
 </div>

 
 
</div> <!--  end page_usertaskedit -->


<!-- ============================================================================================================ -->
<div id="page_usertaskedit_b<?php echo $decID;echo $forum_decID;?>" style="display:none">

<h3><?php  __('send2tasks');// task written for me?></h3>
 

<span id="usertaskviewcontainer_b<?php echo $decID;echo $forum_decID;?>" onClick="showUserview(this);">
     <span class="btnstr"><?php __('tasks');?></span> 
     (<span id="total2<?php echo $decID;echo $forum_decID;?>">0</span>) &nbsp;<img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif">
</span>

   
 
          
<form   name="editusertask_b<?php echo $decID;echo $forum_decID;?>" id="editusertask_b<?php echo $decID;echo $forum_decID;?>">

 

<input type="hidden" name="my_id" value="" />
&nbsp;
	
<div class="form-row">
   
  <span class="h"><?php __('sendBY1');?> </span>

 
   <select name="userselect" id="userselect_b<?php echo $decID;echo $forum_decID;?>">
           <?php foreach($getUser as $row) {  ?>
                    <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
              <?php 
             } //usertaskedit=target
         ?>
  </select>&nbsp; 
    <span class="h"><?php __('too_a1');?> </span>


  <select name="userselect2" id="userselect2<?php echo $decID;echo $forum_decID;?>">
           <?php foreach($getUser as $row) {  ?>
                    <option value="<?php echo $row->userID; ?>"><?php echo $row->full_name; ?></option>
              <?php 
             } 
         ?>
  </select>
<div class="form-row">
  <span class="h"><?php __('priority');?></span> 
    <SELECT name="prio">
      <option value="3">+3</option>
      <option value="2">+2</option>
      <option value="1">+1</option>
      <option value="0" selected>&plusmn;0</option>
      <option value="-1">&minus;1</option>
     </SELECT>
    &nbsp; 
    <span class="h"><?php __('due');?> </span> 
    <input name="duedate3" id="duedate3<?php echo $decID;echo $forum_decID;?>" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
</div>

 

</div>
 
 

 
<div class="form-row"><span class="h"><?php __('task');?></span><br /> <input type="text" name="usertask_b"  id="usertask_b<?php echo $decID;echo $forum_decID;?>"  value="" class="in500" maxlength="250" /></div>
</form>
  
 <div class="form-row"> 
   <input type="button" value="<?php __('cancel');?>" onClick="cancelusertaskEdit_pop(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false" />
 </div>

 
 
</div>



<!-- ============================================================================================================ -->
<div id="target_usertask<?php echo $decID;echo $forum_decID;?>"></div>
 
 


</div><!-- end body -->



<div id="space<?php echo $decID;echo $forum_decID;?>"></div>



</div><!-- end container -->



</div><!-- end wrapper -->


  </fieldset>
 


 
 
 
 <?php return true; }