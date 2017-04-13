<?php
function edit_forums1(){
global $db;

$FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
$op = (isset($_GET['mode'])) ? (string)$_GET['mode'] : 0;
if (($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_GET, 'mode')=='del_forums')  ){
	$FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
	$FORUM_NAME=(isset($_POST['FORUM_NAME']))?(string)$_POST['FORUM_NAME']:'stam';
	$DESCRIPTION=(isset($_POST['DESCRIPTION']))?(string)$_POST['DESCRIPTION']:'stam';
    $created_dt=(isset($_POST['created_dt']))?(string)$_POST['created_dt']:'stam';
	
	
 
	
 $sql = "UPDATE FORUM SET " .
       " FORUM_NAME="     .  $db->sql_string($FORUM_NAME) . ", " .
       " DESCRIPTION="      .  $db->sql_string($DESCRIPTION) . " , " .	
	   " created_dt="     .  $db->sql_string($created_dt) . "  " .
	   " WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
}




if (array_item($_GET, 'mode')=='del_forums') {
	
if ($FORUM_ID ){	
    $FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
    // assign News id
  $sql="DELETE FROM FORUM WHERE FORUM_ID= $FORUM_ID";
    if(!$db->execute($sql))
	return false;
   }
}


elseif (array_item($_REQUEST,'mode')=='act_forum'){
	
$FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
if($FORUM_ID){	
	$sql="update FORUM SET status=1 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
 

}elseif (array_item($_REQUEST,'mode')=='deact_forum'){
	 
	if($FORUM_ID){   	
	$sql="update FORUM SET status=0 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
}   
    
    elseif (!strcmp($op, "act_forum")) {
   if($FORUM_ID){	
	$sql="update FORUM SET status=1 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
        
    } elseif (!strcmp($op, "deact_forum")) {
     if($FORUM_ID){   	
	$sql="update FORUM SET status=0 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
	
    }
 


	
//$sql="select * from FORUM   order by FORUM_NAME  LIMIT 5 ";
$sql="select * from FORUM     ORDER BY FORUM_NAME ASC, FORUM_ID ASC ";		
if($rows=$db->queryObjectArray($sql)){	
$aData=$rows;
$iCnt=count($rows);	
include ('./includes/header.php');
 
 
  global $iCursor, $iPerm;	
//for($k=0;$k<5;$k++){ 
?>
<br />

<form  style="width:95%;overflow:auto;" dir="rtl" action="<?php echo $_SERVER['SCRIPT_NAME']?>"  method="post"> 
<fieldset   style="width:95%;overflow:auto; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table >


     
        
         <span >
          <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=add_msgForum" style="float:right;" class="my_href_li">
            <img src="<?php echo IMAGES_DIR ?>/buttons/btn_additem.gif" width="80" height="30" alt="" border="0" />
            </a> 
        </span>
   
<?php   $aData=(isset($aData))?$aData:NULL;	
 if (is_array($aData)) { ?>

    <tr>
        <td width="100" ><div class="listrow" ><strong>הפעל/השהה</strong></div></td>
        <td   style="overflow:auto;" ><div class="listrow" style="overflow:auto;"><strong>שם הפורום</strong></div></td>
        <td width="170"><div class="listrow"><strong>תאריך</strong></div></td>
        <td width="90"><div class="listrow"><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
    </tr>
    
    
    <tr>
        <td class="dotrule" colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
                                        
    </tr>
    
   
   	<tr>
   	
   	</tr>  
    <?php
   
    $i = 0;
    
         $aState='';//(isset($aState))?$aState:NULL;
        
         
    if($aData){

    	
  
 /********************************************************************************/
 $sql="select * from FORUM    ORDER BY FORUM_NAME ASC, FORUM_ID ASC ";	
 $mysqli=$db->getMysqli();
 $result = $mysqli->query($sql);
  $start = (isset($_GET['cursor']) && ctype_digit($_GET['cursor']) && $_GET['cursor'] <= count($rows)) ? $_GET['cursor'] : 0;

         // move the data pointer to the appropriate starting record
mysqli_data_seek($result, $start);
/**********************************************************************************/   	
    	
    	
    	
    //count($aData)	
    while ($i < 5 && $row = mysqli_fetch_assoc($result)) {
       // !strcmp("FFFFFF", $bg) ? $bg = "F6F6F6" : $bg = "FFFFFF";
       $bg = "F6F6F6";
        $aState = array("act_forum", "deact_forum");
      
      
    ?>
<tr>


    <td width="16" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData[$i]->status ?>">   
        
        
           		 
        <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=<?php print $aState[$aData[$i] ->status] ?>&FORUM_ID=<?php print $aData[$i]->FORUM_ID ?>" onclick="return verify();">
          <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]->status ?>.gif" width="16" height="10" alt="" border="0" />  
         <?php 
         if ($iPerm > 2) { 
         	echo '</a>'; 
         }
          else 
          echo '</a>'; 
         	?>
        
          </div>
     </td>
     
     
     
  <td width="332" bgcolor="<?php print $bg ?>">
  
          <div class="listrow<?php print $aData[$i]->status ?>"><?php print format($aData[$i]->FORUM_NAME) ?></div>
  </td>
        
  <td width="170" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData[$i]->status ?>"><?php print  substr($aData[$i]->created_dt,0,10); ?></div>
   </td>
        
        
 <td width="90" bgcolor="<?php print $bg ?>"><?php if ($iPerm !=1) { ?>
    <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=editForum&FORUM_ID=<?php print $aData[$i]->FORUM_ID ?>"><b>ערוך</b></a>&nbsp;|&nbsp;
    <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=del_forums&FORUM_ID=<?php print $aData[$i]->FORUM_ID ?>" onclick="return verify();"><b>מחק</b> </a><?php } ?>
 </td>
    
    
</tr>
    
 
    
    <tr>
        <td class="dotrule" colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
  }//if $aData 
    ?>
    
</table>
</fieldset>
</form>

    
 
    
    <?php 
 
renderPaging_forum($iCursor, $iCnt); 
 }
 
 
 
}else {

 ?>

    <tr>
        <td colspan="2" class="error"> אין נתונים כרגע. </td> 
    </tr>
</table></fieldset></form>

<?php }

/**************/	
	
	
	
	
}

/************************************************************************************************************/
 /*******************************************************************************/
form_new_line();
      form_label("הזנת חברי פורום:", TRUE); 
		 
		$sql = "SELECT full_name,userID FROM users ORDER BY full_name";
				$rows= $db->queryObjectArray($sql);
				foreach($rows as $row){
				  $array[$row->userID] = $row->full_name;	
				}
				
 			    form_list11("src_users" ,$array , array_item($formdata, "src_users"),"multiple size=6");	
 	           
	
	
          ?>
		<td>
			<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));">
			<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_users'));">

		</td>
		<td><select name='arr_dest_users[]' dir=rtl id='dest_users' MULTIPLE SIZE=6 style='width:200px;' >
			</select>
		</td>
	<?
	
	
	
	
 foreach($formdata['src_users'] as $user ){
				
				
				 
				 if($_GET['mode']=='read_data'){
				 	
				 ?>
                     <tr>
                       <td class="myformtd" bgcolor="#FFFFFF" width="30%"><?form_label1("חבר פורום:", TRUE); ?></td>
                       <td   bgcolor="#FFFFFF" width="70%">
                       <input type="text" class="mycontrol" name="user_forum" 
                          value="<?php echo $user; ?>">
                       </td>
                    </tr>
  
                   <?$i++;	
				 	
				 }else{
				  $user=(trim($user));
				  $sql="select full_name from users where userID=$user";
				 
				  $rows=$db->queryObjectArray($sql);
                 
                ?>
                     <tr>
                       <td  class="myformtd"  bgcolor="#FFFFFF" width="30%"><?form_label1("חבר פורום:", TRUE); ?></td>
                       <td   bgcolor="#FFFFFF" width="70%">
                       <input type="text" class="mycontrol" name="user_forum" 
                          value="<?php echo $rows[0]->full_name; ?>">
                       </td>
                    </tr>
  
                   <?$i++; } 
                   
                     }
	 form_label("");			
	 form_url("users.php","ערוך משתמשים",2 );
	
form_end_line();



/****************************************************************************************************************************************/

 
				if($formdata['src_users']  &&  $formdata['src_users'] !='none'){
 
			 
                form_new_line();
				form_label("הזנת חברי פורום:", TRUE);
				$sql = "SELECT full_name,userID FROM users ORDER BY full_name";
				$rows= $db->queryObjectArray($sql);
				foreach($rows as $row){
				  $array[$row->userID] = $row->full_name;	
				}
	            form_list11("src_users" ,$array , array_item($formdata, "src_users"),"multiple size=6");
 				
				form_label("משתמש חדש",TRUE);
				form_text("new_user", array_item($formdata, "new_user"),  30, 50, 3);
				form_url("users.php","ערוך משתמשים",2 );
				form_end_line();
				
                foreach($formdata['src_users'] as $user ){
				
				
				 
				 if($_GET['mode']=='read_data'){
				 	
				 ?>
                     <tr>
                       <td class="myformtd" bgcolor="#FFFFFF" width="30%"><?form_label1("חבר פורום:", TRUE); ?></td>
                       <td   bgcolor="#FFFFFF" width="70%">
                       <input type="text" class="mycontrol" name="user_forum" 
                          value="<?php echo $user; ?>">
                       </td>
                    </tr>
  
                   <?$i++;	
				 	
				 }else{
				  $user=(trim($user));
				  $sql="select full_name from users where userID=$user";
				 
				  $rows=$db->queryObjectArray($sql);
                 
                ?>
                     <tr>
                       <td  class="myformtd"  bgcolor="#FFFFFF" width="30%"><?form_label1("חבר פורום:", TRUE); ?></td>
                       <td   bgcolor="#FFFFFF" width="70%">
                       <input type="text" class="mycontrol" name="user_forum" 
                          value="<?php echo $rows[0]->full_name; ?>">
                       </td>
                    </tr>
  
                   <?$i++; } 
                   
                     }
				
				}else{ 					
				
/*****************************************************************************************/
/*******************************************************************************************/
?>
	<tr>
	<td>שם מרכז פורום</td>
   
    <td align="right">
      <?php 
	$query = 'SELECT managerID, managerName  FROM managers ORDER BY managerName';
	     if(! $rows=$db->queryObjectArray($query))
     return false;
         foreach($rows as $row) {
	     $managerNames[$row->managerID]  = $row->managerName; }  
       
     $managerName=$formdata['managerName'];
 // echo "<select  name='managerName'>\n";
 	echo '<select  class="mycontrol" ',
     html_attribute("name", 'managerName'), '>', "\n";
  echo '<option value="none">( בחר שם מרכז פורום ) </option>';				
	 
	foreach($rows as $row)
	{
		$managername = $row->managerName  ;
		 if ($managerName == $managername) {
          $selected = " selected";
           } else {
            $selected = "";
           }  
		echo "<option value='$managername'>$managername\n";
	}
	echo "</select>"
      ?>
    </td>
  </tr>
		
/***********************************************************************************************/

//WORKING
//========


<tr>
<td>שם ממנה פורום</td>
   
 <td>
 <?php 
// require_once '../config/application.php';
 global $db;     
	$query = 'SELECT  appointName  FROM appoint_forum ORDER BY appointName';
  if(!$rows=$db->queryArray($query))
     return false;
$appoint_Name=$frm->appointName;
 	echo '<select class="mycontrol" id="yahel"> ';
 
  echo '<option value="none">( בחר שם ממנה פורום)</option>';				
	 
	foreach($rows as $row)
	{
	$appoint_name = $row['appointName'] ;
	 if ($appoint_Name == $appoint_name) {
	 		
          $selected = "selected";
           } else {
            $selected = "";
           }
		 
		echo "<option value='$appoint_name' $selected>$appoint_name</option>\n";
		 
	}
	echo "</select>"
      ?>
    </td>
  </tr>

	


<tr>
<td>שם ממנה פורום</td>
   
 <td>
<?php 
/*******************************************************************************************/

 global $db;     
	$query = 'SELECT  appointName,appointID  FROM appoint_forum ORDER BY appointName';
  if(!$rows=$db->queryObjectArray($query))
     return false;
     foreach($rows as $row){
     	//$parent_appoint[$row->parentAppointID][]=$row->appointID;
     	$arr[$row->appointID]=$row->appointName;
     }
 $selected=$frm->columns[0]->appointID ;
 echo '<select class="mycontrol"> ';
   echo '<option value="none">( בחר שם ממנה פורום)</option>';				
	 
//	foreach($rows as $row)
//	{
//		if($selected==$row->appointID) {
//          $selected = "selected";
//     }  
//     echo "<option value='$row->appointName'>$row->appointName\n";
//	}
  foreach($arr as $index=>$value) {
  	//$sel = (in_array($index, $selected)) ? "selected":"";
  	$sel =  ($index==$selected) ?  "selected":"";
  	 
    echo "<option $sel>$value</option>\n"; 
    
  }
   
	 echo '</select></td></tr>', "\n";
 	 

/**********************************************************************************/
<tr>
	<td>הוסף משתמש לפורום</td>
   
    <td>
      <?php 
	$query = 'SELECT DISTINCT full_name  FROM users ORDER BY full_name';
	     if(! $rows=$db->queryArray($query))
     return false;
      // echo "<select  name='managerName'>\n";
 	echo '<select  class="mycontrol" ',
     html_attribute("name", 'add_user'), '>', "\n";
  echo '<option value="none">(הוסף משתמש לפורום)</option>';				
	 
	foreach($rows as $row)
	{
		$full_name = $row[full_name] ;
		 if ($full_Name == $full_name) {
          $selected = " selected";
           } else {
            $selected = "";
           }  
		echo "<option value='$full_name'>$full_name\n";
	}
	echo "</select>"
      ?>
    </td>
  </tr>
	 
/**********************************************************************************************/
<tr>
	<td>מחק משתמש בפורום</td>
   
    <td>
      <?php 
	$query = 'SELECT DISTINCT full_name  FROM users ORDER BY full_name';
	     if(! $rows=$db->queryArray($query))
     return false;
      
  
 	echo '<select  class="mycontrol" ',
     html_attribute("name", 'del_user'), '>', "\n";
  echo '<option value="none">(מחק משתמש בפורום)</option>';				
	 
	foreach($rows as $row)
	{
		$full_name = $row[full_name] ;
		 if ($full_Name == $full_name) {
          $selected = "selected";
           } else {
            $selected = "";
           }  
		echo "<option value='$full_name'>$full_name\n";
	}
	echo "</select>"
      ?>
    </td>
  </tr>
  /***************************************************************************************/
<tr>
<td>שם ממנה פורום</td>
   
    <td>
 <?php 
 require_once '../config/application.php';
 global $db;     
	$query = 'SELECT DISTINCT appointName  FROM appoint_forum ORDER BY appointName';
	 
     if(! $rows=$db->queryObjectArray($query))
     return false;
  echo "<select name='appointName'>\n";
  echo '<option value="none">(בחר שם ממנה פורום)</option>';				
	 
	foreach($rows as $row)
	{
		$appoint_name = $row->appointName ;
		 
		echo "<option value='$appoint_name'>$appoint_name\n";
	}
	echo "</select>"
      ?>
    </td>
  </tr>





	<tr>
	<td>שם מרכז פורום</td>
   
    <td>
      <?php 
	$query = 'SELECT DISTINCT managerName  FROM managers ORDER BY managerName';
	     if(!$rows=$db->queryObjectArray($query))
     return false;
  echo "<select name='managerName'>\n";
  echo '<option value="none">(בחר שם מרכז פורום)</option>';				
	 
	foreach($rows as $row)
	{
		$manager_name = $row->managerName ;
		 
		echo "<option value='$manager_name'>$manager_name\n";
	}
	echo "</select>"
      ?>
    </td>
  </tr>

/*********************************************************************************************************************/
 form_button1("btnClear", "הכנס נתונים לפורום/נקה טופס", "Submit", "OnClick='return shalom(\"a".$formdata["btnClear"]."\")';");
	 ?>
		<script type="text/javascript">
		function shalom(bar) {
			document.getElementById('mode_'+ bar).value='clear';
			alert('a');
		}
		</script>
		
		<?php 	

	
/***************************************************************************************************/	
//   $res = array_multisort($staff["surname"],SORT_STRING,SORT_ASC,
//                          $staff["givenname"],SORT_STRING,SORT_ASC);
//			
//			// publishing date
//
//			form_new_line();
//			form_label("תאריך החלטה:",true);
//			$name=array(1=>'day','month','year');
//            
//                foreach($name as $data){ 
//			     if($data=='day'){
//			     for($i=0;$i<count($days);$i++){
//			     	$name_date=$data;
//			     	$day_tmp=$days[$i];
//			        $date_array[$name_date][$i]=$day_tmp; 
//			     	}
//			     }   
// 			  elseif($data=='month'){
// 			  	
// 			  for($i=0;$i<count($months);$i++){
//			     	$name_date=$data;
//			     	$month_tmp=$months[$i];
//			        $date_array[$name_date][$i]=$month_tmp; 
//			     	}
// 			  	
// 			  }
// 			else{
// 			for($i=0;$i<count($years);$i++){
//			     	$name_date=$data;
//			     	$year_tmp=$years[$i];
//			        $date_array[$name_date][$i]=$year_tmp; 
//			     	}
// 			 }    
//          }
//            form_list4($name ,$date_array, array_item($formdata, $name[1]) );
// 			
// 			
////            form_list3("day" ,$days, array_item($formdata, "day") );
////            form_list3("month" ,$months, array_item($formdata, "month") );
////            form_list3("year" ,$years, array_item($formdata, "year") );
//			  //make_calendar_pulldown ("thisyear", $dates['month'], $dates['mday'], $dates['year'],array_item($formdata, "thisyear"));
////			make_calendar_pulldown ($dates['month'], $dates['mday'], $dates['year']);
//			    form_label("");
//			    form_label("");
//			   form_end_line();
//			

/************************************************************************************************/	
		<!-- 
<b><center><big>To Do List</big><center></b>

<hr><br>


<table width=100%>

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin

ListToDoItems();

//  End -->
</SCRIPT>

</table>

<br><hr>
<small><center>
<a href="javascript:AddItem()">Add Item</a>

<br><br>

 

</center>

 -->			
 
/************************************************************************************************/ 
 if(array_item($formdata, "decID") || ((array_item($formdata, "task")&& $formdata['task']=='reset' ))  ){
	

  form_new_line();

/**************************************************************************************************/
 
 
global $projax;

 
/*******************************************************************************************************/
 ?>
<td  class="myformtd"> 
		 
<div id="todolisthead"> 
<a onmouseover="" onmouseout="" 
<a style="cursor: pointer;" onclick="<?=$projax->visual_effect("toggle_blind","add_entry");?>;">
<img src="<?php echo IMAGES_DIR; ?>/add.gif" border="1" title="הוסף משימה" /></a> 
&nbsp;&nbsp;&nbsp;<?=$projax->link_to_remote('<img src="'.IMAGES_DIR.'/refresh.gif" border="0" title="אפס משימות" />',array('url'=>'dynamic_5.php?mode=todo_list&task=reset'), " $('todo_item').value='';");?>

</div>

<div id="add_entry" style="display:none"> 
<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">
<?=$projax->form_remote_tag(array('url'=>'dynamic_5.php?mode=todo_list&task=add'), " $('todo_item').value='';");?>
  <br />	
  <input type="text"   class="mycontrol" name="todo_item" id="todo_item" value="" />
    <input type=hidden name=mode value='todo_list'/>
     <input type=hidden name=task value='add'/>
      <input type="submit" class="mybutton" name="Submit" value="הוסף משימה"  />
       
     <?php // echo '<input type="button"  class="mybutton" name="Sub"  onclick="ajx_reqwest()" value="הוסף משימה" "/>'; ?> 
       
     
  	
  	
</form>
</div>
<br />




<strong>משימות לביצוע</strong>
<ol id="todolist">

<?php
 
      if($_SESSION['todo']) { 
      	foreach($_SESSION['todo'] as $num=>$text){ 
       echo show_item($num,$text); 
        } 
   }
?>

</ol>
 
<br />
<strong>משימות שבוצעו</strong>
<ol id="donelist">


<?php 

//$formdata['done'][$id]
    if($_SESSION['done']) {
    	foreach($_SESSION['done'] as $num=>$text){ 
    		    echo "<li>".$text."</li>"; 
    	} 
    }
?>

  </ol>

</td>
<?php  
  form_end_line();  
 }  
 
/***************************************************************************************************/
 function form_remote_tag($options,$str="")
	{
		//could be olso onclick instead of onsubmit
		$options['form'] = true;
		//return '<form action="'.$options['url'].'" onsubmit="'.$this->remote_function($options).'; return false;" method="'.(isset($options['method'])?$options['method']:'post').'"  >';
		 $href='<form action="'.$options['url'].'" onsubmit="'.$this->remote_function($options).';'. $str .'return false;" method="'.(isset($options['method'])?$options['method']:'post').'"  >';			
	 return $href;
	}
/*****************************************************************************************************************/	 
 <?php
    // loop through data and conditionally display functionality and content
    $i = 0;
    
    while ($i < count($aData)) {
        !strcmp("FFFFFF", $bg) ? $bg = "F6F6F6" : $bg = "FFFFFF";
        $aState = array("act", "deact");
    ?>
    <tr>
        <td width="16" bgcolor="#<?php print $bg ?>">
        	<div class="listrow<?php print $aData[$i]["Status"] ?>">      		 
        		<a href="index.php?op=<?php print $aState[$aData[$i]["Status"]] ?>&id=<?php print $aData[$i]["Id"] ?>" onclick="return verify();">
        		 
        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]["Status"] ?>.gif" width="16" height="10" alt="" border="0" /><?php /*if ($iPerm > 2)*/ { 
        ?></a><?php } ?></div></td>
        <td width="332" bgcolor="#<?php print $bg ?>"><div class="listrow<?php print $aData[$i]["Status"] ?>"><?php print format($aData[$i]["Name"]) 
        ?></div></td>
        <td width="170" bgcolor="#<?php print $bg ?>"><div class="listrow<?php print $aData[$i]["Status"] ?>">
        <?php print date("Y-m-d H:i:s" , $aData[$i]["Created"]) ?></div></td>
        <td width="90" bgcolor="#<?php print $bg ?>"><?php if ($iPerm !=1) { ?><a href="form.php?op=edit&id=
        <?php print $aData[$i]["Id"] ?>"><b>ערוך</b></a>&nbsp;|&nbsp;<a href="form.php?op=del&id=
        <?php print $aData[$i]["Id"] ?>" onclick="return verify();"><b>מחק</b> </a><?php } ?></td>
    </tr>
    
    
            
        
        
    
    
    
    
    
    <tr>
        <td class="dotrule" colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
    ?> 
 /****************************************************************************************************************************/
/***************************************************************************************************/

// renders a paginated list for the site admin
function renderList2($iCnt=0, $aData='') {
    
    global $iCursor, $iPerm;
?>
<br />
 
<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
       
        
        <td width="90"><div id="d1"><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
        <td width="170"><div id="d1"><strong>תאריך</strong></div></td>
    </tr>
    
    
    <tr>
        <td class="dotrule" colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
                                        
    </tr>
    
   
   	<tr></tr>  
    
    <tr>
       <td width="16" bgcolor="#<?php print $bg ?>">
        <div id="d1"<?php print $aData->status  ?>">      		 
        <a href="dynamic_5.php?op=<?php print $aState[$aData->status] ?>&id=<?php print $aData->id ?>" onclick="return verify();">
        		 
         <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData ->status?>.gif" width="16" height="10" alt="" border="0" />
       </a> 
      </div>
     </td>
        <td width="332" bgcolor="<?php print $bg ?>"><div  <?php print $aData->status ?>"><?php print format($aData->description ) ?>
        
        </div>
        
        </td>
        
        <td width="90" bgcolor="#<?php print $bg ?>"> <a href="taskslist.class.php?op=edit&id=
        <?php print $aData->id  ?>"><b>ערוך</b></a>&nbsp;|&nbsp;<a href="taskslist.class.php?op=del&id=
        <?php print $aData->id  ?>" onclick="return verify();"><b>מחק</b> </a> </td>
        <td width="170" bgcolor="#<?php print $bg ?>"><div  <?php print $aData->status ?>">
        <?php print date("d-m-Y H:i:s" , strtotime($aData->created_dt) ) ?></div></td>
    </tr>
    
    
            
        
        
    
    
    
    
    
    <tr>
        <td class="dotrule" colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
     
    
</table>
</form>
<?php renderPaging($iCursor, $iCnt) ?>

 

 
<?php } // end function ?>
<?php
/************************************************************************************/
/***************************************************************************************************************************************************************/

// renders a paginated list for the site admin
function renderList3($iCnt=0, $aData='') {
    
    global $iCursor, $iPerm;
?>
<br />
<?php   if (is_array($aData)) { ?>
 
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
    <tr>
        <td width="100" class="myformtd" align="right"><div><strong>סטטוס</strong></div></td>
        <td class="myformtd" align="right"><div><strong>משימות</strong></div></td>
        
        <td class="myformtd"><div><strong>פעולות לביצוע</strong></div></td>
        <td class="myformtd"><div><strong>תאריך</strong></div></td>
    </tr>
    
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
    <tr>
        <td   colspan="5"><img src="<? echo IMAGES_DIR ?>/spc.gif"  alt="" border="0" /></td>
                                        
    </tr>
    
   
   	<tr>
   	
   	</tr>  
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->   	
    <?php
    // loop through data and conditionally display functionality and content
    $i = 0;
    
    while ($i < count($aData)) {
        !strcmp("FFFFFF", $bg) ? $bg = "F6F6F6" : $bg = "FFFFFF";
        $aState = array("act", "deact");
    ?>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
<!-- <tr id="tr_<?php echo  $aData[$i]->id?>"> -->
 
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
    <td width="16" bgcolor="#<?php print $bg ?>">
     <div<?php print $aData[$i]->status  ?>">  
        
        <a href="dynamic_5.php?action=<?php print $aState[$aData[$i]->status] ?>&id=<?php print $aData[$i]->id ?>" onclick="return verify();">
        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]->status?>.gif" width="16" height="10" alt="" border="0" /> </a> 
        
      </div>
    </td>
 <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
        <td width="100" >
        
          <div  
          <?php print $aData[$i]->status ?>"><?php print format($aData[$i]->description ) ?>
          </div>
        </td>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->        
        <td width="100" > 
        
          <a href="drag-and-drop.php?action=updateList&id=<?php print $aData[$i]->id?>" ><b>ערוך</b></a>&nbsp;|&nbsp;
          <!-- href="drag-and-drop.php?action=delTask&id=<?php print $aData[$i]->id?>" -->
          <a  href="void" onclick="return verify() && delete_task(<?php echo $aData[$i]->id?>) && 0 ;return false; "><b>מחק</b> </a>
           
        </td>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->       
        <td width="100">
          <div  <?php print $aData[$i]->status ?>"><?php print date("d-m-Y" , strtotime($aData[$i]->created_dt) ) ?>
          </div>
        </td>
     
    <tr>
        <td  width="100"><img src="<?php echo IMAGES_DIR ?>/spc.gif"  /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
    ?>
    
 
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<script type="text/javascript">
function delete_task(task_id) {
	//alert(task_id);
	// ajax.
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id: task_id, action: 'delTask'},
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	       alert("Success! \n\n" + response);
	       $('tr_'+task_id).remove();
	       $('li_'+task_id).remove();
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	
	
	return false;
}
</script>
 <?php  renderPaging($iCursor, $iCnt) ?>
<?php } else { ?>
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>אין נתונים כרגע.</td>
    </tr>
</table>

<?php } // end condition ?>
<?php } // end function ?>
 
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<?php  
/*************************************************************************************************************************************************************************/
<script language="javascript" type="text/javascript">  
   
      
    function setjs_Value()  
   {  
     var decID = document.getElementById("decID").value;  
    
     alert("Value is " + document.getElementById("decID").innerHTML); 
     var testvar = "<? print $decID; ?>";
      alert("Your   ID is:" + testvar.value);
       alert("Your   ID is:" + jsvalue.value);
       
    
     document.classic_form.jsvalue.value = <?=$decID?>;  
     document.form1.decID.value="<?php echo $decID; ?>";
     document.form1.submit();
     
    document.getElementById('decID').value ;
   return true;		
     
     
   }  
     
    </script>  
    
    
 



/************************************************************************************/

<script language="javascript" type="text/javascript">  
   
      
    function setjs_Value()  
   {  
     
     alert("Value is " + document.getElementById("decID").value;); 
     alert("Value is " + document.getElementById("decID").innerHTML); 
     
       
     
    var decID=document.getElementById('decID').value ;
   return decID;		
   // return true; 
     
   }  
     
    </script>   
    
    
/*******************************************************************************************/
<!-- 
  <script type="text/javascript"  type="text/javascript">
   document.observe("dom:loaded", function() {
	     
		    startup();
		   
     });
 
   </script>

  -->    
   <head>
    <title>Draggable demo</title>
    
    <style type="text/css" media="screen">
      body {
        font-family: 'Trebuchet MS', sans-serif;
      }
    
      #container {
        width: 200px;
        list-style-type: none;
        margin-left: 0;
        padding-left: 0;
      }
      
        #container li, .foo {
          background-color: #f9f9f9;
          border: 1px solid #ccc;
          padding: 3px 5px;
          padding-left: 0;
          margin: 10px 0;
        }
        
        #container li .handle {
          background-color: #090;
          color: #fff;
          font-weight: bold;
          padding: 3px;
        }
        
      #container, #drop_zone {
        width: 200px;
        height: 300px;
        list-style-type: none;
        margin-left: 0;
        margin-right: 20px;
        float: left;
        padding: 0;
        border: 2px dashed #999;
      }        
        
    </style>
    
    <script src="../js/prototype.js" type="text/javascript" charset="utf-8"></script>
    <script src="../js/scriptaculous.js" type="text/javascript" charset="utf-8"></script>
    
    <script type="text/javascript">
    document.observe("dom:loaded", function() {
      Sortable.create('container', { scroll: window });
    });
    </script>

  </head>
  <body>
    
  <ul id="container">
    <li class="foo" id="item_1">Lorem</li>
    <li class="foo" id="item_2">Ipsum</li>
    <li class="foo" id="item_3">Dolor</li>
    <li class="foo" id="item_4">Sit</li>

    <li class="foo" id="item_5">Amet</li>
  </ul>

  </body>
</html>  
/***********************************************************************************************/
 foreach($rows as $row){
     
     	$myList .= '<span style="color: black;"></span>';
     
     	$myList .= '<div id="'.htmlspecialchars($row->id).'">'.
     	           htmlspecialchars($row->description) . ' </div>';
     	           
     	      
		$myList.= "<script >
			   		new Draggable('".htmlspecialchars($row->id)."');
			   		</script> ";
			   
     	           
         
     }
/******************************************************************************************/
               ?><script >
			   new Draggable('<?php echo htmlspecialchars($row->id)?>');
			   </script>
			   <?php      
/******************************************************************************************/
   foreach($rows as $row){
     
     	$myList .= '<span style="color: black;"></span>';
     
     	$myList .= '<div id="'.htmlspecialchars($row->id).'">'.
     	           htmlspecialchars($row->description) . ' </div>';
     	           
         
     }	   
/******************************************************************************************/
   foreach($rows as $row){
     
     	$myList .= '<span style="color: black;"></span><ul>';
     
     	$myList .= '<li id="'.htmlspecialchars($row->id).'">'.
     	           htmlspecialchars($row->description) . ' </li>';
         
     }
/******************************************************************************************/
 <!-- href="drag-and-drop.php?action=delTask&id=<?php print $aData[$i]->id?>" -->
          <!--  <a  href="void" onclick="return verify() && update_task(<?php echo $aData[$i]->id?>) && delete_task(<?php echo $aData[$i]->id?>) && 0 ;return false; "><b>מחק</b> </a> -->
            
/******************************************************************************************/
<!-- 
<script type="text/javascript">
function update_task(task_id) {
	//alert(task_id);
	// ajax.
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id: task_id, action: 'updateList'},
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	        //alert("Success! \n\n" + response);
	       //$('tr_'+task_id).remove();
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	
	
	return false;
}
</script>

 
<script type="text/javascript">
function sendRequest() {
				new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
					{ 
					method: 'post', 
					postBody:  'name='+ $F('name') ,
					onComplete: showResponse 
					});
				}

			function showResponse(req){
				$('show').innerHTML= req.responseText;
			}
</script>
  -->          
          
/******************************************************************************************/
  function renderList4($iCnt=0, $aData='') {
    
    global $iCursor, $iPerm;
?>
<br />
<?php   if (is_array($aData)) { ?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">

<table width="608" border="0" cellpadding="0" cellspacing="0">
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
    <tr>
        <td width="348" colspan="2"><div><strong>משימות</strong></div></td>
        
        <td width="90"><div><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
        <td width="170"><div><strong>תאריך</strong></div></td>
    </tr>
    
    
    <tr>
        <td  colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
                                        
    </tr>
    
   
   
   	
    <?php
    // loop through data and conditionally display functionality and content
    $i = 0;
    
    while ($i < count($aData)) {
        
        $aState = array("act", "deact");
    ?>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
<tr id="tr_<?php echo  $aData[$i]->id_task_pk ?>">
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
 
    <td width="16" >
     <div<?php print $aData[$i]->status  ?>">  
        
       <a href="dynamic_5.php?action=<?php print $aState[$aData[$i]->status] ?>&id_task_pk=<?php print $aData[$i]->id_task_pk ?>" onclick="return verify();">    
       <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]->status?>.gif" width="16" height="10" alt="" border="0" /> </a> 
        
      </div>
    </td>
 
 
     
        <td width="332" >
        
          <div>   
         
          <?php print format($aData[$i]->task_description )?> 
          </div>
        </td>
        
      
     

  
<script type="text/javascript">
function delete_task(task_id) {
	//alert(task_id);
     var decID = document.getElementById("decID").value;
      
    var li = document.getElementById('li_'+task_id).value ;
    // alert(li);
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id_task_pk: task_id ,decID:decID,action: 'delTask'},
	    
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	       // alert("Success! \n\n" + response);
	         
	       $('tr_'+task_id).remove();
	      
	       $('li_'+task_id).remove();
	       alert(liItem); 
	    },
	
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	
	
	return false;
}
</script>

 



</form>

  
<?php } else { ?>
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
       <?php show_error_msg("אין משימות כרגע."); ?> 
    </tr>
</table>

<?php } // end condition ?>
<?php } // end function ?>
<?php
/************************************************************************************/

 if(array_item($formdata, "decID" )    ){ 
 	
 $decID = array_item($formdata, "decID");
  form_new_line();
?>
<td  class="myformtd">


  <h1>הוסף משימות</h1>
   <p>
        <a href="#" onclick="Effect.BlindDown('d1'); return false;"><img src="<?php echo IMAGES_DIR; ?>/icon_new.gif" border="0" title="הוסף משימה" /></a> 
        <a href="#" onclick="Effect.BlindUp('d1'); return false;"><img src="<?php echo IMAGES_DIR; ?>/icon_clear.gif" border="0" title="קפל תיבה" /></a> 
  </p>   

 
 

 
  <div id="d1" style="display:none;">
      
      <input class="mycontrol" type="text" id="txtNewTask" name="txtNewTask" 
             size="30" maxlength="100" onkeydown="handleKey(event)"/>
      <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />  
      <input class="mybutton" type="button" name="submit" value="הוסף משימה" 
       onclick="process('txtNewTask', 'addNewTask','<?php echo $decID?>');" /> 
     
     
     <!--   onclick="process('txtNewTask', 'addNewTask') ; setjs_Value() " ; /> -->
      
     
 </div>
    

  <br />
 

 <ul id="tasksList" class="sortableList" 
        onmouseup="process('tasksList', 'updateList','<?php echo $decID?>')">
 
  <?php 
        $myTasksList = new TODOLIST($formdata['decID'] );
        echo $myTasksList->BuildTasksList($formdata);
   ?> 
    
 </ul>
 
<br /><br />
   

<div id="trash">
      גרור לפה למחיקה 
   <br /><br />
</div>
 
   </td>  
 <?php
 
  
  form_label("");
  form_label("");
  form_label("");
  form_end_line();
 }

 




/************************************************************************************/
 
  if(array_item($formdata, "decID" )    ){ 
 	
 $decID = array_item($formdata, "decID");
  form_new_line();
?>
<td  class="myformtd">


  <h1>הוסף משימות</h1>
   <p>
        <a href="#" onclick="Effect.BlindDown('d1'); return false;"><img src="<?php echo IMAGES_DIR; ?>/icon_new.gif" border="0" title="הוסף משימה" /></a> 
        <a href="#" onclick="Effect.BlindUp('d1'); return false;"><img src="<?php echo IMAGES_DIR; ?>/icon_clear.gif" border="0" title="קפל תיבה" /></a> 
  </p>   

 
 

 
  <div id="d1" style="display:none;">
      
      <input class="mycontrol" type="text" id="txtNewTask" name="txtNewTask" 
             size="30" maxlength="100" onkeydown="handleKey(event)"/>
      <input type=hidden name="decID" id="decID" value="<?php echo $decID?>" />  
      <input class="mybutton" type="button" name="submit" value="הוסף משימה" 
       onclick="process('txtNewTask', 'addNewTask','<?php echo $decID?>');" /> 
     
     
     <!--   onclick="process('txtNewTask', 'addNewTask') ; setjs_Value() " ; /> -->
      
     
 </div>
    

  <br />
 

 <ul id="tasksList" class="sortableList" 
        onmouseup="process('tasksList', 'updateList','<?php echo $decID?>')">
 
  <?php 
        $myTasksList = new TODOLIST($formdata['decID'] );
        echo $myTasksList->BuildTasksList($formdata);
   ?> 
    
 </ul>
 
<br /><br />
   

<div id="trash">
      גרור לפה למחיקה 
   <br /><br />
</div>
 
   </td>  
 <?php
 
  
  form_label("");
  form_label("");
  form_label("");
  form_end_line();
 } 
 
/******************************************************************************************/
  //$sql="select userID,fname, lname from users ";
// $rows=$db->queryObjectArray($sql);
// foreach ($rows as $row){
// 	$full_name=$row->fname . " " .$row->lname;
// 	$sql="update users set full_name='$full_name' where userID=$row->userID ";
// 	
// 	if(!$db->execute($sql) )
// 	exit;
// 	
// }
/******************************************************************************************/
  
 
 <script type="text/javascript">
 function createXMLHttp() {
	 if (typeof XMLHttpRequest != 'undefined')
	 return new XMLHttpRequest();
	 else if (window.ActiveXObject) {
	 var avers = ["Microsoft.XmlHttp", "MSXML2.XmlHttp",
	 "MSXML2.XmlHttp.3.0", "MSXML2.XmlHttp.4.0",
	 "MSXML2.XmlHttp.5.0"];
	 for (var i = avers.length -1; i >= 0; i--) {
	 try {
	 httpObj = new ActiveXObject(avers[i]);
	 return httpObj;
	 } catch(e) {}
	 }
	 }
	 throw new Error('XMLHttp (AJAX) not supported');
	 }

	 var ajaxObj = createXMLHttp(); </script> 
 
  
 
 <script>


 var url= "/alon-web/olive/show_decForum/display_tree.php" ;
 ajaxObj.open("GET", url, true);  
/******************************************************************************************/
 //demo 10
 	    <div id="loading">
       <img src="loading4.gif" border="0" />
        </div>
	     
<!--        <div id="targetDiv"></div>-->
</div>
 
<script>
// prepare the form when the DOM is ready 
$(document).ready(function() { 

   var options = { 
        //target:        '#targetDiv',   // target element to update 
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_form').ajaxForm(options); 
   
 function showRequest(formData, jqForm) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra);

    return true;  
} 

// post-submit callback 
function processJson(data) {
	 alert("sdfgsdfgsdfgdsf"); 
var countyList = '';
    // 'data' is the json object returned from the server 
 $.each(data, function(i){
	 countyList += '<li><a href="http://maps.google.com/maps?f=q&hl=en&geocode=&q='+this.decName+this.forum_decName+''+this.managerName+',+florida" target="_blank"  class="maplink">'+this.decName+'</a></li>';	 
  
 });
 //$('#targetDiv').html('<ul id="countyList">'+countyList+'</ul>');
 $('#targetDiv').html('<ul id="countyList">'+countyList+'</ul>').find('a.maplink').click(function(){
	 var index = $('a.maplink').index(this);
	 alert(index);
	 return false;
	  });
}

$('form#find_form fieldset').append('<div id="targetDiv"></div>').find('select#forum_decision').change(function(){
$.ajax({
   type: "POST",
   url: "find3.php",
   data: "forum_decision="+this.value,
   success: function(msg){
$('div#targetDiv').html(' ').append('<p>'+msg+'</p>');
   }
 });
});

   
}); 
 
 $("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });


</script>
 
/******************************************************************************************/
function print_categories3($catIDs, $subcats, $catNames,$parent) {
  echo '<ul>';
  $i=0;
  foreach($catIDs as $catID) {
  if($catID==11){
  		printf("<li><b>%s (%s, %s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href1("../admin/dynamic_5.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href1("dec_edit.php" ,"mode=update","&updateID=$catID", "עדכן"));
    }else{
   
         if($parent[$catID][0]=='11'){	
                printf("<li class='li_page'> %s </li>\n",
                      htmlspecial_utf8($catNames[$catID]));
         }else{
            	printf("<li> %s </li>\n",
                htmlspecial_utf8($catNames[$catID]));
         }
   
  	}
    if(array_key_exists($catID, $subcats))
      $this->print_categories2($subcats[$catID], $subcats, $catNames,$parent);
   $i++;
  }
  echo "</ul>\n";
}

 
/**************************************************************************/

/**************************************************************************/
function print_categories2($catIDs, $subcats, $catNames,$parent) {
  echo '<ul>';
  $i=0;
  foreach($catIDs as $catID) {
  	if($catID==11){
  		printf("<li> %s </li>\n",
      htmlspecial_utf8($catNames[$catID]));
      
    }else{
   
         if($parent[$catID][0]=='11'){	
                printf("<li class='li_page'> %s </li>\n",
                      htmlspecial_utf8($catNames[$catID]));
         }else{
            	printf("<li> %s </li>\n",
                htmlspecial_utf8($catNames[$catID]));
         }
   
  	}
    if(array_key_exists($catID, $subcats))
      $this->print_categories2($subcats[$catID], $subcats, $catNames,$parent);
   $i++;
  }
  echo "</ul>\n";
}

 
/******************************************************************************************/
function print_categories2($catIDs, $subcats, $catNames,$parent) {
  echo '<ul>';
  $i=0;
  foreach($catIDs as $catID) {
  	if($catID==11){
  		printf("<li> %s </li>\n",
      htmlspecial_utf8($catNames[$catID]));
         
    }elseif($parent[$catID][0]=='11'  && !array_item($subcats,$catID) ){	
         	      //  echo '<ul>';
                printf("<li class='li_page'> %s </li>\n",
                      htmlspecial_utf8($catNames[$catID]));
                    //  echo '</ul>';
         }elseif($parent[$catID][0]=='11'  &&  array_item($subcats,$catID) ){	
         	      //  echo '<ul>';
                printf("<li class='li_page'> %s \n",
                      htmlspecial_utf8($catNames[$catID]));
                    //  echo '</ul>';
         }else{
         	
         	//echo '<ul>';
            	printf("<li> %s\n",
                htmlspecial_utf8($catNames[$catID]));
            //echo '</ul>';    
                 
         }
   
   
    if(array_key_exists($catID, $subcats))
      $this->print_categories2($subcats[$catID], $subcats, $catNames,$parent);
   //$i++;
  }
  echo " </li></ul>\n";
}

/******************************************************************************************/
//	function  print_form($page="",$decID="",$subcats="") {
//		global $db;
////		 $sql="drop table t1";
////		 $row=$db->execute($sql); 
//		printf("<p><br />%s</p>\n",
//		build_href("find3.php", "", "חפש החלטות"));
//		echo "<h2>בחר החלטה</h2>\n";
//		echo "<p>לחץ להוסיף/למחוק/לעדכן.</p>\n";
//		
//		
//     if(!$decID){
//		 $sql="drop table t1";
//          $rows2 = $db->execute($sql);	   
//          //$sql="create table tmp_10 as select decName, decID, parentDecID FROM decisions ORDER BY decName  "	;
//         
//          $sql="create  table t1 as select decName, decID, parentDecID FROM decisions ORDER BY decName  "	;
//          $rows1 = $db->execute($sql);
//           $sql="truncate  table t1   "	;
//          $rows1 = $db->execute($sql);
//         
// 	    $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName  ";
//	 
//		$rows = $db->queryObjectArray($sql);
//		 
//		
//		foreach($rows as $row) {
//			$subcats[$row->parentDecID][] = $row->decID;
//			$subcats1[$row->parentDecID][] = array($row->decID,$row->decName);
//			$decNames[$row->decID] = $row->decName; }
//			$i=0;
//			$this->print_decisions_a($subcats[NULL], $subcats, $decNames,$page,$i);
//       }else{
//            $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName  ";
//	 		$rows = $db->queryObjectArray($sql);
//       	
//       	foreach($rows as $row) {
//			$decNames[$row->decID] = $row->decName; }
//       	      
//       	
//     	       $sql="select parentDecID from decisions where decID='$decID'";
// 		       $row1=$db->queryObjectArray($sql);
// 			   $row= $row1[0]->parentDecID;
// 			 
// 			   $name=$decNames[$decID];
// 			   $name="'$name'";
// 			  
// 			   $sql = "INSERT INTO t1 (decName, decID, parentDecID) " .
//                       "VALUES ($name,$decID,$row)";	
//               $rows  = $db->execute($sql);
// 			   
//     	 //$sql="delete from  tmp_10 where decID='$decID'";
//         //$rows  = $db->execute($sql);
//        //     	 $sql = "SELECT decName, decID, parentDecID FROM decisions  
//        //     	         minus
//        //     	         SELECT decName, decID, parentDecID FROM t1 
//        //     	         ORDER BY decName";
//		 $sql = "SELECT decName, decID, parentDecID FROM decisions  
//     	         where decID not in(SELECT   decID FROM t1 )
//     	         ORDER BY decName";
//		$rows = $db->queryObjectArray($sql);
//		if(!$rows){return;}
//     foreach($rows as $row) {
//			$subcats[$row->parentDecID][] = $row->decID;
//			$decNames[$row->decID] = $row->decName; }
//			$subcats[NULL][0]='11';
//	 
//			$i=0;
//			
//			$this->print_decisions_a($subcats[NULL], $subcats, $decNames,$page,$i);
//     	
//     }
//
//			
//
//			printf("<p><br />%s</p>\n",
//			build_href("find3.php", "", "חפש החלטות"));
//	}
//	
//	
//	
//
/******************************************************************************************/
form_new_line();

    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
	$rows = $db->queryArray($sql);	 
	  	

    echo '<td colspan="2" class="myformtd">
    		<table>
    		<tr>';
    
    echo '<td class=""myformtd>';
    form_label1("הזנת  חברי פורום:", TRUE); 
    form_list111("src_users" , $rows, array_item($formdata, "src_users"),"multiple size=6 id='src_users' ondblclick=\"add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));\"");		      
    echo '</td>'; 
  
    
    
if($formdata['dest_users'] && $formdata['dest_users']!='none'){	 		
 $dest_users= $formdata['dest_users'];
		
foreach ($dest_users as $key=>$val){
	
	if(!$result["dest_users"])
				$result["dest_users"] = $key;
				else
				$result["dest_users"] .= "," . $key;
	
}			
			
$staff=$result["dest_users"];			
			
$sql2="select full_name from users where userID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[]=$row->full_name;
			
  }
  
  
?>

   <td class=""myformtd> 
 
	<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;' OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));">

	<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה' OnClick="remove_item_from_select_box(document.getElementById('dest_users'));">

 
 	</td>
  
 
<? 





	  form_list11("dest_users" , $name, array_item($formdata, "dest_users"),"multiple size=6 id='dest_users' ondblclick=\"add_item_to_select_box(document.getElementById('dest_users'), document.getElementById('dest_users'));\"");
//list11_ctrl2("dest_users" , $name, array_item($formdata, "dest_users"),"multiple size=6 id='dest_users' ondblclick=\"add_item_to_select_box(document.getElementById('dest_users'), document.getElementById('dest_users'));\"");  
   
 echo ' 
  	</tr>
 	</table>
 	</td>';
 
  
}elseif(
/******************************************************************************************/
/*****************************************************************************************/
 
/********************************************************************************************************************/
form_new_line();
					
form_label("תאריך הקמת הפורום:",true);
				 
					
for($i=1;$i<=31;$i++){
$days[$i]= $i;
}
 $months = array ('1'=>'January','2'=> 'February','3'=> 'March','4'=> 'April','5'=> 'May','6'=> 'June','7'=> 'July','8'=> 'August','9'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December');
				 

 $dates = getdate();
				 
 $year = date('Y');

 $end = $year;
 $start=$year - 15;
for($start;$start<=$end;$start++) {
 $years[$start]=$start;
 

}

if( !is_numeric($formdata ["year_date"])       &&  !is_numeric($formdata ['month_date']      ) 
&&  !is_numeric($formdata["multi_month"][0])   &&  !is_numeric($formdata ["multi_year"][0])  ){

	echo '<td class="myformtd"  style= dispaly:none;   style= "width:200px;" >';


	form_list3("year_date" ,$years,$dates['year'], array_item($formdata, "year_date") );

	form_list3("month_date" ,$months,$dates['month'], array_item($formdata, "month_date") );
					 
	form_list3("day_date" ,$days, $dates['mday'], array_item($formdata, "day_date") );
	

    echo '</td>', "\n";
						
					 
						
   form_label("");
   form_label("");
   form_label("");
  // form_label(""); 
  // form_label("");
//   form_label("");
   form_end_line();

/******************************************************************************************************/
form_new_line();

 form_label("הזנת תאריכים לכמה פורומים:",true);

 echo '<td class="myformtd">';

 form_list01("multi_year" ,$years , array_item($formdata, "multi_year"), " multiple size=6"  );

 form_list01("multi_month" ,$months , array_item($formdata, "multi_month"), " multiple size=6"  );
					 
 form_list01("multi_day" ,$days, array_item($formdata, "multi_day"), " multiple size=6"  );
					
  echo '</td>', "\n";

}else{
 
 echo '<td class="myformtd">';
					 
 form_list3("year_date" ,$years,$formdata['year_date'], array_item($formdata, "year_date") );

 form_list3("month_date" ,$months,$months[$formdata['month_date']], array_item($formdata, "month_date") );
					 
 form_list3("day_date" ,$days, $formdata['day_date'], array_item($formdata, "day_date") );

 echo '</td>', "\n";
						

}  
// form_label("");
// form_label("");
// form_label("");
//  form_label("");
				 
 form_end_line();
 
/*************************************************************************************************************/ 
 
 <script language="javascript">

scriptAr = new Array(); // initializing the javascript array
<?php
 
 // read file values as array in php
$count = count($formdata); //this gives the count of array

//In the below lines we get the values of the php array one by one and update it in the script array.
foreach ($formdata as $key => $val)
{
print "scriptAr.push(\"$val\" );"; // This line updates the script array with new entry
}


?>
var arv = scriptAr.toString();
//alert(arv);

</script>
 
 
 
 
 
 
/*********************************************************************************************************/
!DOCTYPE html>

<html>
<head>
<script type="text/javascript">
var arrayFromPHP = <?php echo json_encode($viewFields) ?>;

$.each(arrayFromPHP, function (i, elem) {
    // do your stuff
});
</script>
</head>
<body>

</body>
</html>
 
/******************************************************************************************************/		 
//		       $now	=	date('Y-m-d H:i:s');
/******************************************************************************************/
<!--function processData() {-->
<!--	var data = new Array();-->
<!--	for(var c=0; c<document.forms.length; c++) {-->
<!--		data[c] = new Array();-->
<!--		data[c][0] = document.forms[c].elements['caption'].value;-->
<!--		data[c][1] = document.forms[c].elements['source'].value;-->
<!--		data[c][2] = document.forms[c].elements['info'].value;-->
<!--	}-->
<!--	alert(data.join('++'));-->
<!--}-->
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

 ////$('#result').load('make_task.php', { 'formdata[]': ["<?php echo $formdata['dest_forums']; ?>", "<?php echo $formdata['decID']; ?>"] });
 	




/******************************************************************************************/
while($rowset = mysql_fetch_array($result)) 
    { 
    $idTT1++;  
    $editTT='b'.$idTT1; 
    $hidTextTT='t'.$idTT1; $hidSubIdTT='s'.$idTT1; 
    echo "<tr><td>".$rowset[1]." ".$rowset[2]."</td><td> &nbsp; </td>  
    <td class='table_label'> 
    <div id='".$idTT1."' onclick='editView($idTT1,$editTT)' >".$rowset[3]."</div>"; 
 
    echo "<div id='".$editTT."' style='display:none;'>             
        <input id='".$hidSubIdTT."' name='box1' type='hidden' value='".$row['dDegreeName']."'> 
        <input id='".$hidTextTT."' name='box2' type='text' value=''  /> 
        <input type='submit' value='Update' name='submit'  
        onclick='updateSubject($hidSubIdTT,$hidTextTT)'/> 
        <input type='button' value='Cancel' name='Cancel' onclick='setEditView($idTT1,$editTT)'/> 
    </div></td></tr>"; 
    } 
//setEditView(\"$idTT1\",\"$editTT\") 

/******************************************************************************************/

//	$('form#edittask'+decID+forum_decID).append('<div id="targetDiv"></div>').find('select#userselect'+decID+forum_decID).change(function(){
//	alert("sdfdsfffs");
//});



/*********************************build_forum*********************************************************/
 
/******************************************************************************************/
<div id="progress" style="width:80% ;height :  50px"></div>
/******************************************************************************************/
function del_user(userID,url){
	$('tr#user_'+userID).css({'border' : 'solid green 5px'});
	 
 	data=new Array();
 		data[0]='delete';

		
	if(!confirm("האים בטוח שרוצה למחוק?")){
		 return false;
	}
	
	$('tr#user_'+userID).hide();
	$('#btnDeleteUser').unbind();
	


var data1= data[0].toString();
				$.ajax({
				   type: "get",
				   url:url+ "users.php",

			          data:  "mode="+ data1+ "&id=" +userID ,
			         
				   success: function(msg){
			   alert("רשומה נימחקה");


	        }
				
		});
		 
    return false;
};//end del_user

/******************************************************************************************/
  var def='read_users';
  tz = -1 * (new Date()).getTimezoneOffset();
  nocache = '&rnd='+Math.random();
  var url='/alon-web/olive/admin/';
$.getJSON(url+'ajax2.php?mode='+def, function(json){

				 


 
////////////////////////////////////////////////////////
$.each(json.list, function(i, item){
////////////////////////////////////////////////////////
//alert("xxxxxx");
data_users[i]=item.full_name;

});//end each
});//end json

/******************************************************************************************/
 return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
    (shlomo == "lahat" ? "1" : "3") + "dffdsfdss" + (shlomo == "cohen" ? "dfdsf" : "dsdsd") +
    '<div class="task-actions">';
 if(ffff){
	retstr += '<a>';
 }else{
	 retstr += '<b>'; 
 }
 	retstr +=  '<a href="#" onClick="return deleteTask2('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
	        '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="'+lang.actionDelete+'">'+
	      '</a>'+
         
    
         '<a href="#" onClick="return toggleTaskNote('+id+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="'+lang.actionNote+'">'+
		 '</a>'+
		 


/******************************************************************************************/
 	not so shure
 	var restr = '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
    
    // '<input type="hidden" name="Request_Tracking_Number2_'+decID+forum_decID+'" id="Request_Tracking_Number2_'+decID+forum_decID+'" value="'+id+'" />'+
 
     
     return (shlomo == "lahat" ? "1" : "3") + "dffdsfdss" + (shlomo == "cohen" ? "dfdsf" : "dsdsd") ;
  '<div class="task-actions">';
 if(ffff){
	retstr += '<a>';
 }else{
	 retstr += '<b>'; 
 }
 	retstr +=  '<a href="#" onClick="return deleteTask2('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
	        '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="'+lang.actionDelete+'">'+
	      '</a>'+
         
 	
 	
 	
/******************************************************************************************/
 good

 var restr = '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
    
    // '<input type="hidden" name="Request_Tracking_Number2_'+decID+forum_decID+'" id="Request_Tracking_Number2_'+decID+forum_decID+'" value="'+id+'" />'+
 
     
     
  '<div class="task-actions">';
 if(ffff){
	retstr += '<a>';
 }else{
	 retstr += '<b>'; 
 }
 	retstr += 
          '<a href="#" onClick="return deleteTask2('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
	        '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="'+lang.actionDelete+'">'+
	      '</a>'+
 	
 	
/******************************************************************************************/
 	
     
  // event worker object constructor
function EventWorker(){
 this.addHandler = EventWorker.addHandler;
}
 
// event worker static method
EventWorker.addHandler =
 function (eventRef, func) {
  var eventHandlers = eval(eventRef);
  if (typeof eventHandlers == 'function') { // not first handler
   eval(eventRef + " = function(event) {eventHandlers(event); func(event);}");  
  } else { // first handler
   eval(eventRef + " = func;");
  }
 }
 
 
 
Usage:
EventWorker.addHandler("window.onload", function1);
EventWorker.addHandler("window.onload", function2); 
     
 
 	
/******************************************************************************************/
//  $('#calendar').fullCalendar('removeEvents', function(event) {
//	   return event.id == event.id;
//	});
/******************************************************************************************/
//$sql="SELECT u.*,u.user_date IS NULL  AS ddn ,r.rel_date,r.forum_decID,r.tagID,r.tags FROM users u 
//             INNER join rel_user_forum r  
//             on u.userID = r.userID
//             $inner
//             WHERE 1=1 
//            $sqlWhere 
//             AND r.forum_decID = $forum_decID
//            $sqlSort";


// $sql1= "SELECT  u.userID   FROM users u	                 
// 	                 
//	
//                     INNER JOIN rel_user_forum r  
//                     ON u.userID = r.userID     
//                     
//                     INNER JOIN  forum_dec f  
//                     ON f.forum_decID = r.forum_decID  
//                              
//                     INNER JOIN  managers m  
//                     ON m.managerID = f.managerID                               
//                              
//                     WHERE r.forum_decID = $forum_decID
//                     UNION    
//                       SELECT u.userID  FROM users u          
//                     WHERE u.userID=(SELECT m.userID FROM managers m
//                     WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";	                 
//	                 
//if($rows=$db->queryObjectArray($sql1)){
//	
// 
//for($i=0; $i<count($rows); $i++){	
//				if($i==0){
//					$userIDs = $rows[$i]->userID;
//				}
//				else{
//					$userIDs .= "," . $rows[$i]->userID;
//
//				}
//			
//			}
// 	
//}	

 
 
//$sql= "SELECT distinct u.*, duedate IS NULL  AS ddn ,r.forum_decID,r.tagID,r.tags,m.managerID  FROM users u 
//                     
//                     LEFT JOIN rel_user_forum r  
//                     ON u.userID = r.userID
//                      
//                      LEFT OUTER JOIN managers m  
//                     ON u.userID = m.userID    
//                      
//                     WHERE u.userID in ($userIDs)   
//                                  
//                         $sqlWhere  ";        
////                       if($compl != '')
////	                 $sql.=" AND r.tagID=$tag_id "; 
//                     
////                     AND r.forum_decID = $forum_decID ";
////                     u.compl in(0,1)
//	                 if($tag != '')
//	                 $sql.=" AND r.tagID=$tag_id ";
//	                 //$sql.=" $sqlSort ";	
//                       $sql.="ORDER BY r.userID ";				
  
/******************************************************************************************************/  
// while($result = mysql_fetch_array($sql))
//   {
//       $mydata = '<tbody id="tbody1">
// <tr class="highlight">
//<td  width="30" id="bullet" align="center">
//<a href="#" class="nohighlight">&#8226;</a></td>
//<td width="30px" align="center" id="replyImg"><input type="image" src="css/images/reply_arrow.png" onClick="reply()"></input></td>
//<td width="70" align="Left" id="time">'.$result["Date_Time"].'</td>
//<td width="200" align="Left" id="from">'.$result["User_name"].'</td>
//<td width="200" align="Left" id="to">'.$result[""].'</td>
//    <td id="showMsg">'.$result["Msg_body"].'</td>
//    <td width="200" align="left" id="group">'.$result["Grp_abr"].'</td>         
//  </tr>
//  </tbody>';
//
//}
//
//        echo $mydata;
  

/******************************************************************************************/
 $html .= " <a OnClick='return editDec( $decision->decID, $decision->forum_decID,  \"".ROOT_WWW."/admin/\") '>
 <img src=' ".IMAGES_DIR." /icon-folder.gif'   onMouseOver='this.src=img.edit[1]' onMouseOut='this.src=img.edit[2]'   title='הצג נתונים' />
 </a>";
/******************************************************************************************************/
  <? echo " <a href='".ROOT_WWW."/logout' style='float:right;height:50px'>[יציאה]</a> "?>
  
  IF(  $_SERVER['SCRIPT_NAME']==ROOT_WWW.'/admin/dynamic_5c.php'){
 /******************************************************************************************************/
 $.stringBuilder = function() {
    this.buffer = [];
};

$.stringBuilder.prototype = {

    cat: function(what) {
        this.buffer.push(what);
        return this;
    },

    string: function() {
        return this.buffer.join('');
    }
};
var html = new $.stringBuilder();
for (var i in 5)
    html.cat("<tr><td>").cat(i).cat("</td><td></tr>");

$('#element').append(html.string());
 /******************************************************************************************************/
	   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  //"change_insert_b="  + insertID + "&decID=" + decID, 
 /******************************************************************************************************/
 //	$('.my_Forum_decision_find'+forum_decID).removeClass().addClass('my_Forum_decision'+forum_decID);
//	$('#my_Forum_decision_content_find'+forum_decID).attr("id",'my_Forum_decision_content'+forum_decID);	 	
 
 /******************************************************************************************************/
 
echo '<li><a href="javascript:void(0)"   OnClick= "return  openmypage3(\''.ROOT_WWW.'/admin/find3.php?catID=$id\');this.blur();return false;">' . $category . '</a></li>';  
 

 
 /******************************************************************************************************/
 
 <table style="width: 100%;"> 
	    <tr>        
	      
<td id="ctl00_MainContent_Pager1_PageControls" align="left">    
	               <!-- No onclick event! Why? -->     
	        <input type="submit" name="ctl00$MainContent$Pager1$btnPrevPage" value="←" id="ctl00_MainContent_Pager1_btnPrevPage" /> 
Page       <select name="ctl00$MainContent$Pager1$ddlPage" onchange="javascript:setTimeout('__doPostBack(\'ctl00$MainContent$Pager1$ddlPage\',\'\')', 0)" 
                id="ctl00_MainContent_Pager1_ddlPage">                 
                <option value="1">1</option>                
                 <option selected="selected" value="2">2</option>                 
                 <option value="3">3</option>                
                  <option value="4">4</option>                
                   <option value="5">5</option>                 
                   <option value="6">6</option>             
           </select>             
           
 of <span id="ctl00_MainContent_Pager1_lblTotalPages">6</span>             
 <!-- No onclick event! Why? -->             
 <input type="submit" name="ctl00$MainContent$Pager1$btnNextPage" value="→" id="ctl00_MainContent_Pager1_btnNextPage" />         
 </td>         
 
 <td id="ctl00_MainContent_Pager1_itemsPerPageControls" align="right">             
 Sessions/Page:            
  <select name="ctl00$MainContent$Pager1$ddlItemsPerPage" onchange="javascript:setTimeout('__doPostBack(\'ctl00$MainContent$Pager1$ddlItemsPerPage\',\'\')', 0)"  
                 id="ctl00_MainContent_Pager1_ddlItemsPerPage">                 
                 <option value="10">10</option>                 
                 <option selected="selected" value="25">25</option>                 
                 <option value="50">50</option>                 
                 <option value="100">100</option>             
  </select>         
                 </td>     
                 </tr> 
   </table> 
 
 /******************************************************************************************************/
 // if category is in use, don't delete it!
  $sql = "SELECT COUNT(*) FROM rel_cat_dec WHERE catID='$catID'";
  if($n = $db->querySingleItem($sql)>0) {
    $sql = "SELECT catName FROM categories_subject WHERE catID='$catID'";
    $catname = $db->querySingleItem($sql);
    printf("<br />החלטות %s קטגוריה בשימוש. " .
           "לא כדאי למחוק.\n", $catname, $n);
    return 0;
  }
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/
 /******************************************************************************************************/

   
 */