<?php
 
require_once '../config/application.php';
require_once(LIB_DIR.'/model/class.default.php');
  require_once(LIB_DIR.'/model/en.php'); 
 html_header();
global $lang ;
if(!$needAuth) $tabDisabled = '';
elseif(!is_logged() && canAllRead()) $tabDisabled = ', selected:1, disabled: [0]';
elseif(!is_logged()) $tabDisabled = ', disabled: [0,1]';
else $tabDisabled = '';

$sort = 0;
if(isset($_COOKIE['sort']) && $_COOKIE['sort'] != '') $sort = (int)$_COOKIE['sort'];

if($config['duedateformat'] == 2) $duedateformat = 'm/d/yy';
elseif($config['duedateformat'] == 3) $duedateformat = 'dd.mm.yy';
else $duedateformat = 'yy-mm-dd';

 
$decID=1;
$forum_decID=1;
?>
   
 
<?php if(isset($_GET['pda'])): ?>
<meta name="viewport" id="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="pda.css" media="all">
<?php else: ?>
<link rel="stylesheet" type="text/css" href="print.css" media="print">
<?php endif; ?>
 
 
<script type="text/javascript" src="ajax.lang.php"></script> 
 




<script type="text/javascript">
$().ready(function(){
	
	var decID =<?php echo $decID; ?>; 
 	var forum_decID = <?php echo $forum_decID; ?>; 

 	$("#tabs"+decID+forum_decID).tabs({ select: tabSelected <?php echo $tabDisabled; ?>});
 	$("#tasklist"+decID+forum_decID).sortable({cancel:'span,input,a,textarea', delay: 150, update:orderChanged, start:sortStart});
 	$("#tasklist"+decID+forum_decID).bind("click", tasklistClick2);
 	$("#edittags"+decID+forum_decID).autocomplete('/alon-web/olive/admin/ajax.php?suggestTags', {scroll: false, multiple: true, selectFirst:false, max:8});
  	$("#priopopup"+decID+forum_decID).mouseleave(function(){$(this).hide();});
	 
 	 setSort(<?php echo $sort;?>,1);
	 
<?php

  
	 
    echo "\tloadTasks2('".ROOT_WWW."/admin/',$forum_decID,$decID);\n";
	 
?>
	 preloadImg();
	$("#duedate"+decID+forum_decID).datepicker({dateFormat: '<?php echo $duedateformat; ?>', firstDay: 1, showOn: 'button', buttonImage: '<?php echo TASK_IMAGES_DIR ?>//calendar.png', buttonImageOnly: true, 
		changeMonth:true, changeYear:true, constrainInput: false, duration:'', nextText:'&gt;', prevText:'&lt;', dayNamesMin:lang.daysMin, 
		monthNamesShort:lang.monthsShort });




			
<?php 
  if(!isset($_GET['pda'])):
 ?>
	$("#page_taskedit"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
	$("#page_taskedit"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit"+decID+forum_decID).width(), minHeight:$("#page_taskedit"+decID+forum_decID).height(), start:function(ui,e){editFormResize(1)}, resize:function(ui,e){editFormResize(0,e)}, stop:function(ui,e){editFormResize(2,e)} });
	$("#page_taskedit_multi"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
	$("#page_taskedit_multi"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit_multi"+decID+forum_decID).width(), minHeight:$("#page_taskedit_multi"+decID+forum_decID).height(), start:function(ui,e){editFormResize_multi(1)}, resize:function(ui,e){editFormResize_multi(0,e)}, stop:function(ui,e){editFormResize_multi(2,e)} });

	
<?php
  endif; 
 
 ?>

});

var decID =<?php echo $decID; ?>;
var forum_decID = <?php echo $forum_decID; ?>; 
 //alert(forum_decID);
 
 
$().ajaxSend( function(r,s) {$("#loading"+decID+forum_decID).show();} );
$().ajaxStop( function(r,s) {$("#loading"+decID+forum_decID).fadeOut();} );

 
</script>
 





 


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

 


// GET ALL USER 
$getUser_sql	=	"SELECT u.* FROM users u 
                     inner join rel_user_forum r  
                     on u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     ORDER BY u.full_name ASC";

$getUser		=	$db->queryObjectArray($getUser_sql);
$getUser_Total	=	count($getUser);

?>

 



  
<div id="wrapper<?php echo $decID;echo $forum_decID;?>"    class="wrapper" >
<div id="container<?php echo $decID;echo $forum_decID;?>"  class=container"">
<div id="body<?php echo $decID;echo $forum_decID;?>"  class="body">


<h2><?php __('ניהול משימות');echo ' -  '; echo $frm_Name; ?>  </h2>
  
<h2><?php __('מרכז ועדה');echo ' -  '; echo $mgr_Name; ?>  </h2>
<br clear="all" >
<!-- ============================================================================================================ -->
<div id="page_tasks<?php echo $decID;echo $forum_decID;?>" >
 <!-- ============================================================================================================ -->
<div id="tabs<?php echo $decID;echo $forum_decID;?>" class="tabs ul">
 
  <ul class="tabs ul" >
	<li><a href="#newtask<?php echo $decID;echo $forum_decID;?>"><?php __('tab_newtask');?></a></li>
	<li><a href="#searchtask<?php echo $decID;echo $forum_decID;?>"><?php __('tab_search');?></a></li>
	<li><a href="#usermanager<?php echo $decID;echo $forum_decID;?>"><?php __('tab_users');?></a></li>
  </ul>
  
  <br clear="all" class="all">
<!-- ------------------------------------------------------------------------------------------------- -->   
  <div class="tab-content"   id="newtask<?php echo $decID;echo $forum_decID;?>"> 
  
 
  
  <form   action=""  name="<?php echo $decID;echo $forum_decID;?>"  id="addtask<?php echo $decID;echo $forum_decID;?>"  value="<?php echo $decID;echo $forum_decID;?>"  class="addtask">
 
      <input type="text" name="task<?php echo $decID;echo $forum_decID;?>" value=""   maxlength="250"   id="task<?php echo $decID;echo $forum_decID;?>" class="task" /> 
	       <input type="hidden" name="id<?php echo $decID;echo $forum_decID;?>"  value="<?php echo $decID;echo $forum_decID;?>" />
	     
 
	




 

 
&nbsp;
<span class="red2"><?php __('sendBY') ?></span>
 
	 <select name="select<?php echo $decID;echo $forum_decID;?>" id="selectUser<?php echo $decID;echo $forum_decID;?>" class="mycontrol" width=5  height=10 size=1>
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
    <select name="selectUser1<?php echo $decID;echo $forum_decID;?>" id="selectUser1<?php echo $decID;echo $forum_decID;?>" class="mycontrol"  width="5">
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
  <input type="hidden" id="button_action" name="button_action" />
  <input type="button"  name="<?php __('btn_add');echo $decID;echo $forum_decID;?>"  
    id="<?php __('btn_add'); echo $decID;echo $forum_decID;?>"  value="<?php __('btn_add');?>"   
   class="buttonClass"  onclick="submitNewTask_2(this,<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>);"  /> 

	</form>
  </div>   

 
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
  
  
     <div  class="tab-content"  id="usermanager<?php echo $decID;echo $forum_decID;?>" >
        <form onSubmit="return submitNewUser(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>)">
	       
	       <a href="javascript:loadUsers(<?php echo " '".ROOT_WWW."/admin/' "; ?>);">הראה משתמשים</a> | 
	  
           <a href="javascript:showhide('addUser');">הוסף משתמש חדש</a> |
          
        
            
            <span id="tagusercloudbtn<?php echo $decID;echo $forum_decID;?>" onClick="showuserTagCloud(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>);" title="<?php __('usertags');?>">
             <span class="btnstr"><?php __('usertags');?></span> 
               <img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif"></span>
               
               
	     </form>
      </div> 
      
        
</div>  
 
<!-- =========================end div tub===========================MENUE_H3======================================================== --> 
 
<h3>
 
 <span id="taskviewcontainer<?php echo $decID;echo $forum_decID;?>" onClick="showTaskview2(this,<?php echo $decID;?>,<?php echo $forum_decID; ?>);">
    <span class="btnstr"><?php __('tasks');?></span> 
   (<span id="total<?php echo $decID;echo $forum_decID;?>">0</span>) &nbsp;<img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif">
 </span>

  
  
  
  <span id="tagcloudbtn<?php echo $decID;echo $forum_decID;?>" onClick="showTagCloud2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID; ?>);" title="<?php __('tags');?>">
    <span class="btnstr"><?php __('tags');?></span> 
    <img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif">
  </span>

    
     <span id="sort<?php echo $decID;echo $forum_decID;?>" onClick="showSort2(this,<?php echo $decID;?>,<?php echo $forum_decID; ?>);"  title="<?php __('sortByHand');?>">
          <span class="btnstr"><?php __('sortByHand');?></span> 
          <img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif" " title="" />
    </span>       
 
  	  
  	 <span id="multicloudbtn<?php echo $decID;echo $forum_decID;?>"  onclick="showMulti_view2(this,<?php echo $decID;?>,<?php echo $forum_decID; ?>);" title="<?php __('multiAction');?>">
          <span class="btnstr"><?php __('multiAction');?></span> 
          <img src="<?php echo TASK_IMAGES_DIR ?>/arrdown.gif" alt="עשה איתי משהו" title="" />
    </span>     
  	     
  	  
</h3>


 <div  id="taskcontainer<?php echo $decID;echo $forum_decID;?>">
     <ol id="tasklist<?php echo $decID;echo $forum_decID;?>" class="sortable"></ol>
 </div>

</div>   
  
 

<div id="page_taskedit<?php echo $decID;echo $forum_decID;?>" style="display:none">

<h3><?php __('edit_task');?></h3>




<form onSubmit="return saveTask2(this,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $decID;?>,<?php echo $forum_decID;?>)"; name="edittask<?php echo $decID;echo $forum_decID;?>" id="edittask<?php echo $decID;echo $forum_decID;?>">

 
<input type="hidden" name="Request_Tracking_Number" id="Request_Tracking_Number,<?php echo $decID;?>,<?php echo $forum_decID;?>" value="" />
<input type="hidden" name="id<?php echo $decID;echo $forum_decID;?>" value="<?php echo $id; ?>" id="id<?php echo $decID;echo $forum_decID;?>" />
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
 
 
 
 
<div class="form-row"><span class="h"><?php __('task');?></span><br> <input type="text" name="task_name<?php echo $decID;echo $forum_decID;?>" id="task_name<?php echo $decID;echo $forum_decID;?>" value="" class="in500" maxlength="250" /></div>
<div class="form-row"><span class="h"><?php __('note');?></span><br> <textarea name="note<?php echo $decID;echo $forum_decID;?>" id="note<?php echo $decID;echo $forum_decID;?>" class="in500"></textarea></div>
<div class="form-row"><span class="h"><?php __('tags');?></span><br> <input type="text" name="tags<?php echo $decID;echo $forum_decID;?>" id="tags<?php echo $decID;echo $forum_decID;?>" value="" class="in500" maxlength="250" /></div>
<div class="form-row"><input type="submit" value="<?php __('save');?>" onClick="this.blur()" > <input type="button" value="<?php __('cancel');?>" onClick="cancelEdit2(<?php echo $decID;?>,<?php echo $forum_decID;?>);this.blur();return false" /></div>
</form>

</div> <!--  end of page_task_edit  -->


 

  

<div id="priopopup<?php echo $decID;echo $forum_decID;?>" style="display:none">
 <span class="prio-neg" onClick="prioClick(-1,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>)">&minus;1</span> 
 <span class="prio-o" onClick="prioClick(0,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>)">&plusmn;0</span>
 <span class="prio-pos" onClick="prioClick(1,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>)">+1</span> 
 <span class="prio-pos" onClick="prioClick(2,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>)">+2</span>
 <span class="prio-pos" onClick="prioClick(3,this,<?php echo " '".ROOT_WWW."/admin/' "; ?>)">+3</span>
</div>



  

 

<!-- ============================================================================================================ -->
 
 


</div><!-- end body -->



<div id="space<?php echo $decID;echo $forum_decID;?>"></div>



</div><!-- end container -->



</div><!-- end wrapper -->

 
 
 
 
	<?php html_footer(); ?>
 

 