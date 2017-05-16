<?php
//require_once '../config/application.php';

global $db;


/*****************************************************************************************/

	function   find_build_form($formdata=FALSE) {
	global $db;


?>
<table>
 <tr>
 <td>
<?php form_label1('חתכי סוגי החלטות:',TRUE); ?>


     <a href='#' title='חתכי סוגי החלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />
     </a>

   </td>


     <td>
    <?php form_label1('חתכי סוגי פורומים:',TRUE); ?>
     <a href='#' title='חתכי סוגי פורומים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>
    </td>


     <td>
       <?php form_label1('חתכי סוגי מנהלים:',TRUE); ?>

     <a href='#' title='חתכי סוגי מנהלים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJAX/default.php'"; ?> ,'סוגי המנהלים');this.blur();return false;";  >
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>

</td></tr></table>

 <form action="../admin/find3.php" method="post"  id="my_find">
<fieldset  class="my_find_fieldset" style="float:right;width:80%; background: #94C5EB url(../images/background-grad.png) repeat-x;  ">



<table class="myformtable1" id="my_resulttable"  style="border:0px;bottom:50px;align:center;">



    <?php


	form_new_line();
      echo '<td class="myformtd" colspan=4 >';
	form_label1("החלטה שמתחילה ב ..",true);

	form_text_a("decision", array_item($formdata, "decision"), 30,100 );

 	         form_button_no_td2("btnTitleRoot", "עץ יורד", "Submit");
	         form_button_no_td2("btnTitleRootUp", "עץ עולה", "Submit");
//	         form_button2 ("btnTitleRoot", " עץ יורד");
//	         form_button2 ("btnTitleRootUp", " עץ עולה  ");
	  echo '</td>';



	form_end_line();

/****************************************************************************************/
// forums form

    form_new_line();

    form_label("שם גוף מחליט שמתחיל ב..",TRUE);

    form_text("forum", array_item($formdata, "forum"), 30,100  );
	form_label("");
	form_label("");

	form_end_line();
/*****************************************************************************************/

		form_new_line();
		form_label("גוף מחליט:", TRUE);
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);



		foreach($rows as $row) {
			$subcats4[$row->parentForumID][] = $row->forum_decID;
			$catNames4[$row->forum_decID] = $row->forum_decName; }
			// build hierarchical list
			$rows = build_category_array($subcats4[NULL], $subcats4, $catNames4);



//		   form_list_find("forum_decision","forum_decision" , $rows , array_item($formdata, "forum_decision"));
           echo '<td class="myformtd">';
		   form_list_b("forum_decision" , $rows , array_item($formdata, "forum_decision"));
 	       form_url2("forum_category.php","ערוך פורומים",2 );
           echo '</td>';
           form_label("");
           form_label("");
 	form_end_line();
/*****************************************************************************************/
		// forum_dec
		form_new_line();
		form_label("ממנה פורום:", TRUE);
		$sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
	    $rows = $db->queryObjectArray($sql);

  		foreach($rows as $row) {
	    $subcats22[$row->parentAppointID][] = $row->appointID;
	    $catNames22[$row->appointID] = $row->appointName; }

	// build hierarchical list
	    $rows = build_category_array($subcats22[NULL], $subcats22, $catNames22);

	    echo '<td class="myformtd">';
 		form_list_b("appoint_forum" ,$rows, array_item($formdata,"appoint_forum"));
 		form_url2("appoint_edit.php","ערוך ממני פורום",2 );
 		echo '</td>';
 		form_label("");
        form_label("");
		form_end_line();


/**********************************************************************************************/
 		// forum_dec
  		form_new_line();
  	form_label("מרכז פורום:", TRUE);
 		$sql = "SELECT managerName,managerID ,parentManagerID FROM managers ORDER BY managerName";
 		$rows = $db->queryObjectArray($sql);
  		foreach($rows as $row) {
	    $subcats11[$row->parentManagerID][] = $row->managerID;
	    $catNames11[$row->managerID] = $row->managerName; }

	// build hierarchical list
	    $rows = build_category_array($subcats11[NULL], $subcats11, $catNames11);
	    echo '<td class="myformtd">';
 		form_list_b("manager_forum" , $rows, array_item($formdata, "manager_forum"));
 		form_url2("manager.php","ערוך מנהלים",2 );
 		echo '</td>';
 		form_label("");
        form_label("");
   		form_end_line();




/**********************************************************************************************/
		// users
		form_new_line();
		form_label("משתמשים:", TRUE);
		$sql = "SELECT full_name,userID FROM users ORDER BY full_name";
		echo '<td class="myformtd">';
		form_list_b("user_forum" , $db->queryArray($sql), array_item($formdata, "user_forum"));
	    form_url2("print_users.php","ערוך משתמשים",2 );
	    echo '</td>';
	    form_label("");
        form_label("");
		form_end_line();

/*****************************************************************************************/
// category
	form_new_line();
	form_label("קטגוריות של החלטות:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
	$rows = $db->queryObjectArray($sql);

	foreach($rows as $row) {
	$subcats[$row->parentCatID][] = $row->catID;
	$catNames[$row->catID] = $row->catName; }

	// build hierarchical list
	$rows = build_category_array($subcats[NULL], $subcats, $catNames);
	echo '<td class="myformtd">';
	form_list_b("category", $rows , array_item($formdata, "category"));
	form_url2("categories.php"	,"ערוך קטגוריות החלטות",2 );
	echo '</td>';
	form_label("");
    form_label("");
	form_end_line();

//**********************************************************************************************/
/*****************************************************************************************/
// category
	form_new_line();
	form_label("קטגוריות של פורומים:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
	$rows = $db->queryObjectArray($sql);

	foreach($rows as $row) {
	$subcats1[$row->parentCatID][] = $row->catID;
	$catNames1[$row->catID] = $row->catName; }

	$rows = build_category_array($subcats1[NULL], $subcats1, $catNames1);
	 echo '<td class="myformtd">';
	form_list_b("category1", $rows , array_item($formdata, "category1"));
	form_url2("categories1.php" ,"ערוך קטגוריות הפורומים",2 );
	 echo '</td>';

	 form_label("");
     form_label("");
	form_end_line();


//**********************************************************************************************/
	        form_new_line();
			form_label("קטגוריות של מנהלים/מרכזי פורומים:",TRUE);

			$sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
			$rows = $db->queryObjectArray($sql);

			foreach($rows as $row) {
				$subcats0[$row->parentManagerTypeID][] = $row->managerTypeID;
				$catNames0[$row->managerTypeID] = $row->managerTypeName; }

				$rows = build_category_array($subcats0[NULL], $subcats0, $catNames0);
				 echo '<td class="myformtd">';
				form_list_b("managerType", $rows , array_item($formdata, "managerType"));
				form_url2 ("manager_category.php","ערוך קטגוריות מנהלים",2 );
                  echo '</td>';
                form_label("");
                form_label("");
				form_end_line();

/*****************************************************************************************/
// publishing date





	for($i=1;$i<=31;$i++){
		$days[$i]= $i;

		}
		$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

		$dates = getdate();

		if (!isset($year)) {
			$year = date('Y');
			}

			$end = $year ;
			$start=$year - 10;
			for($start;$start<=$end;$start++) {
			$years[$start]=$start;

			}

          echo '<tr>', "\n";

	form_label("מתאריך:",true);
	         echo '<td class="myformtd">';
	           form_list001 ("source_year" ,$years , array_item($formdata, "source_year") );

	           form_list001("source_month" ,$months, array_item($formdata, "source_month") );

	           form_list001("source_day" ,$days, array_item($formdata, "source_day") );

	         echo '</td></tr>', "\n";



             echo '<tr>', "\n";

	form_label("עד תאריך:",true);
	         echo '<td class="myformtd">';

	         form_list001("dest_year" ,$years,array_item($formdata, "dest_year") );

	         form_list001("dest_month" ,$months,  array_item($formdata, "dest_month") );

	         form_list001("dest_day" ,$days, array_item($formdata, "dest_day") );
	         echo '</td></tr>', "\n";


 /**********************************************************************************************************/
	         form_new_line();

	         form_label("דרגת תוצאות הצבעה 1 עד 5 ", TRUE);
	         form_text("vote_level", array_item($formdata, "vote_level"),3,5,3);
             //form_empty_cell(7);
	         form_end_line();
/************************************************************************************************/
	         form_new_line();
	         form_label("דרגת חשיבות החלטה: (1 עד 10)", TRUE);
	         form_text("dec_level", array_item($formdata, "dec_level"), 3 , 5 , 3);
	         //form_label("");
	         form_end_line();

/****************************************************************************************/
	         form_new_line();
	         form_label("סטטוס החלטה: (1=פתוחה/0=סגורה)", TRUE);
	         form_text("status", array_item($formdata, "status"),  3 , 5 , 3);
	         //form_label("");
	         form_end_line();
/****************************************************************************************/

	         form_new_line();



	         if(array_item($formdata, "btnTitle")){
	         	$tmp=((array_item($formdata, "btnTitle") &&($formdata["forum_decision"]))|| (array_item($formdata, "btnTitle") && $formdata["forum"] )) ? "forumPattern":"decPattern";
	         	 echo '<td class="myformtd"  >';
	         	   form_button_no_td2("btnTitle", "חפש", "Submit");
	             echo '</td>';
	         	form_hidden3("mode", $tmp,0, "id=mode" );
	         }
	         else{
	         	 echo '<td class="myformtd"  >';
	         	         	  form_button_no_td2("btnTitle", "חפש", "Submit");
	             echo '</td>';
	         }
	         //echo '<td class="myformtd">',
//	         echo '<td class="myformtd" colspan=4 >',
//	         form_button2 ("btnTitleRoot", "הראה עץ יורד של החלטה ");
//	         form_button2 ("btnTitleRootUp", "הראה עץ עולה של החלטה ");
////	         form_button2("btnTitleLetter", "הראה מופעי אותיות ");
////	         form_button2 ("btnTitleLetter1", "מופעי אותיות ללא קישורים  ");
//	         echo '</td>', "\n";

            form_label("");
	         form_label("");
	         form_label("");
	         form_end_line();

/*************************************************************/
	         form_new_line();

	       form_label("");

	         form_url("database7.php"	,"חזרה לטופס ההחלטות",2 );

 	         form_label("");
	         form_end_line();


	     echo '</table></fieldset></form>';


}//end find_build_form

/*******************************************************************************/
function task_server($decID,$forum_decID,$userID,$row2,$flag=false){
	global $db;
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



$get_mgr="SELECT managerID from forum_dec WHERE forum_decID=$forum_decID";
if($rows=$db->queryObjectArray($get_mgr)){
$mgr=$rows[0]->managerID;
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
/*******************************************************************************/
 if($getUser		=	$db->queryObjectArray($sql) ) {
$getUser_Total	=	count($getUser);
 }
/*******************************************************************************/
 ?>
<!-- ----------------------------GET TASKS------------------------------------------------ -->
<div id="page_taskedit_dlg<?php echo $decID;echo $forum_decID;?>" style="display:none">

<h3 STYLE="color:red">נתוני משימה</h3>

<form  style="width:400px;"  id="edittask_dlg<?php echo $decID;echo $forum_decID;?>">
<div id="progress<?php echo $decID;echo $forum_decID;?>" style="height : 10px; background:#2CE921;color:#8EF6F8 ;" ></div>

<input type="hidden" name="Request_Tracking_Number_find<?php echo $decID.$forum_decID;?>" id="Request_Tracking_Number_find<?php echo $decID;echo $forum_decID;?>" value="" />

 <input type="hidden" name="prog_bar" id="prog_bar" value="" />
 <input type="hidden" name="decID" id="decID" value="<?php echo $decID;?>" />
 <input type="hidden" name="forum_decID" id="forum_decID" value="<?php echo $forum_decID;?>" />

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








<div class="form-row"><span class="h"><?php __('task');?></span><br>
 <input type="text" name="task_name<?php echo $decID;echo $forum_decID;?>" id="task_name<?php echo $decID;echo $forum_decID;?>" value="" class="in500" maxlength="250" />
</div>

<div class="form-row"><span class="h"><?php __('note');?></span><br>
 <textarea name="note<?php echo $decID;echo $forum_decID;?>" id="note<?php echo $decID;echo $forum_decID;?>" class="in500"></textarea>
</div>

<div class="form-row"><span class="h"><?php __('tags');?></span><br>
 <input type="text" name="tags<?php echo $decID;echo $forum_decID;?>"  id="edittags<?php echo $decID;echo $forum_decID;?>"  value="" class="in500" maxlength="250" />
</div>

<div class="form-row">
  <!--
  <input type="button"  id="my_button_win<?php echo $decID;  echo $forum_decID;?>"  value="<?php __('dec_details');?>" class="href_modal1"  onClick="openmypage3(<?php echo " '".ROOT_WWW."/admin/find3.php?decID=$decID' "; ?>);this.blur();return false;" />
  not work with 1 echo $decID
   -->
   <input type="button"  id="my_button_win<?php echo $decID; echo $decID;echo $forum_decID;?>"  value="<?php __('dec_details');?>" class="href_modal1"  onClick="openmypage3(<?php echo " '".ROOT_WWW."/admin/find3.php?decID=$decID' "; ?>);this.blur();return false;" />

   <input type="button" value="<?php __('cancel');?>" onClick="cancelEdit2_dlg(<?php echo $decID;?>,<?php echo $forum_decID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>);this.blur();return false;" />
</div>
</form>

</div> <!--  end of page_task_edit_dlg  -->

<?php

$fnd=new find();

/******************************************************************************************************************/



   if(!($flag)){

?>
<tr><td class="my_task"><span class="td5head"> שלחתי משימות: </span>
 <span>
   <a href="javascript:void()" class="tTip" title="משימות שאני שלחתי"  onClick="return edituserTasks (<?php echo $userID;?>,<?php echo $decID ;?>,<?php echo $forum_decID ;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>);return false;" >
     <img src="<?php echo IMAGES_DIR ?>/icon18_email.gif"  onMouseOver="this.src=img.show[1]"       onMouseOut="src='<?php echo ROOT_WWW; ?>/images/icon18_email.gif'"   />
   </a>
</span>
<?php

   }else{

 ?>
 <tr><td class="my_task"><span class="td5head"> שלחו לי משימות: </span>
 <span>
  <a href="javascript:void()" class="tTip" title="משימות ששלחו אליי" onClick="return edituserTasks (<?php echo $userID;?>,<?php echo $decID ;?>,<?php echo $forum_decID ;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $userID;?>);return false;" >
  <img src="<?php echo IMAGES_DIR ?>/icon18_email.gif"  onMouseOver="this.src=img.show[1]"  onMouseOut="src='<?php echo ROOT_WWW; ?>/images/icon18_email.gif'"  />
   </a>
 </span>
<?php
 }




 echo $fnd->td_url($row2->decName, "find3.php?decID=$row2->decID",$dec_date);//<b style='color:blue;'>$free_text</b></td><td class=\"$class\"></td></tr>
//  echo $fnd->td1("", "tdinvisible"), $fnd->td2asis("&nbsp;", "tdinvisible");

/****************/
}//end function
/***************/





/*****************************************************************************************/

	function   find_form($formdata=FALSE ) {
	global $db;


	?>

    <table class="myformtable" id="my_resulttable" align="center">

     <form action="../admin/find3.php" method="post" style="display:none" >

      <fieldset  class="my_fieldset" style="background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">פורומים עין השופט</h1></legend>


    <?php

   // form_start("find3.php","find_form");
	form_new_line();

	form_label("החלטה שמתחילה ב ..",true);

	form_text("decision", array_item($formdata, "decision"), 30,100 );
	form_label("");
	form_label("");


//form_label("");
	form_end_line();

/****************************************************************************************/
// forums form

    form_new_line();

    form_label("שם גוף מחליט שמתחיל ב..",TRUE);

    form_text("forum", array_item($formdata, "forum"), 30,100  );
	form_label("");
	form_label("");

	form_end_line();
/*****************************************************************************************/

		form_new_line();
		form_label("גוף מחליט:", TRUE);
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);



		foreach($rows as $row) {
			$subcats4[$row->parentForumID][] = $row->forum_decID;
			$catNames4[$row->forum_decID] = $row->forum_decName; }
			// build hierarchical list
			$rows = build_category_array($subcats4[NULL], $subcats4, $catNames4);



//		   form_list_find("forum_decision","forum_decision" , $rows , array_item($formdata, "forum_decision"));
           echo '<td class="myformtd">';
		   form_list_b("forum_decision" , $rows , array_item($formdata, "forum_decision"));
 	       form_url2("forum_category.php","ערוך פורומים",2 );
           echo '</td>';
           form_label("");
           form_label("");
 	form_end_line();
/*****************************************************************************************/
		// forum_dec
		form_new_line();
		form_label("ממנה פורום:", TRUE);
		$sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
	    $rows = $db->queryObjectArray($sql);

  		foreach($rows as $row) {
	    $subcats22[$row->parentAppointID][] = $row->appointID;
	    $catNames22[$row->appointID] = $row->appointName; }

	// build hierarchical list
	    $rows = build_category_array($subcats22[NULL], $subcats22, $catNames22);

	    echo '<td class="myformtd">';
 		form_list_b("appoint_forum" ,$rows, array_item($formdata,"appoint_forum"));
 		form_url2("appoints.php","ערוך ממני פורום",2 );
 		echo '</td>';
 		form_label("");
        form_label("");
		form_end_line();


/**********************************************************************************************/
 		// forum_dec
  		form_new_line();
  	form_label("מרכז פורום:", TRUE);
 		$sql = "SELECT managerName,managerID ,parentManagerID FROM managers ORDER BY managerName";
 		$rows = $db->queryObjectArray($sql);
  		foreach($rows as $row) {
	    $subcats11[$row->parentManagerID][] = $row->managerID;
	    $catNames11[$row->managerID] = $row->managerName; }

	// build hierarchical list
	    $rows = build_category_array($subcats11[NULL], $subcats11, $catNames11);
	    echo '<td class="myformtd">';
 		form_list_b("manager_forum" , $rows, array_item($formdata, "manager_forum"));
 		form_url2("manager.php","ערוך מנהלים",2 );
 		echo '</td>';
 		form_label("");
        form_label("");
   		form_end_line();




/**********************************************************************************************/
		// users
		form_new_line();
		form_label("משתמשים:", TRUE);
		$sql = "SELECT full_name,userID FROM users ORDER BY full_name";
		echo '<td class="myformtd">';
		form_list_b("user_forum" , $db->queryArray($sql), array_item($formdata, "user_forum"));
	    form_url2("users.php","ערוך משתמשים",2 );
	    echo '</td>';
	    form_label("");
        form_label("");
		form_end_line();

/*****************************************************************************************/
// category
	form_new_line();
	form_label("קטגוריות של החלטות:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
	$rows = $db->queryObjectArray($sql);

	foreach($rows as $row) {
	$subcats[$row->parentCatID][] = $row->catID;
	$catNames[$row->catID] = $row->catName; }

	// build hierarchical list
	$rows = build_category_array($subcats[NULL], $subcats, $catNames);
	echo '<td class="myformtd">';
	form_list_b("category", $rows , array_item($formdata, "category"));
	form_url2("categories.php"	,"ערוך קטגוריות החלטות",2 );
	echo '</td>';
	form_label("");
    form_label("");
	form_end_line();

//**********************************************************************************************/
/*****************************************************************************************/
// category
	form_new_line();
	form_label("קטגוריות של פורומים:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
	$rows = $db->queryObjectArray($sql);

	foreach($rows as $row) {
	$subcats1[$row->parentCatID][] = $row->catID;
	$catNames1[$row->catID] = $row->catName; }

	$rows = build_category_array($subcats1[NULL], $subcats1, $catNames1);
	 echo '<td class="myformtd">';
	form_list_b("category1", $rows , array_item($formdata, "category1"));
	form_url2("categories1.php" ,"ערוך קטגוריות הפורומים",2 );
	 echo '</td>';

	 form_label("");
     form_label("");
	form_end_line();


//**********************************************************************************************/
	        form_new_line();
			form_label("קטגוריות של מנהלים/מרכזי פורומים:",TRUE);

			$sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
			$rows = $db->queryObjectArray($sql);

			foreach($rows as $row) {
				$subcats0[$row->parentManagerTypeID][] = $row->managerTypeID;
				$catNames0[$row->managerTypeID] = $row->managerTypeName; }

				$rows = build_category_array($subcats0[NULL], $subcats0, $catNames0);
				 echo '<td class="myformtd">';
				form_list_b("managerType", $rows , array_item($formdata, "managerType"));
				form_url2 ("manager_category.php","ערוך קטגוריות מנהלים",2 );
                  echo '</td>';
                form_label("");
                form_label("");
				form_end_line();

/*****************************************************************************************/
// publishing date

	form_new_line();

	form_label("מתאריך:",true);
	// $days= array (1 => '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');


	for($i=1;$i<=31;$i++){
		$days[$i]= $i;

		}
		$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
//$years = array (1 => '2007', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019','2020', '2008');


		$dates = getdate();

		if (!isset($year)) {
			$year = date('Y');
			}
			$end = $year + 10;
			$start=$year - 10;
			for($start;$start<=$end;$start++) {
			$years[$start]=$start;

			}


	         echo '<td class="myformtd">';
	           form_list001 ("source_year" ,$years , array_item($formdata, "source_year") );

	           form_list001("source_month" ,$months, array_item($formdata, "source_month") );

	           form_list001("source_day" ,$days, array_item($formdata, "source_day") );
	           form_label1("עד תאריך:",true);
	         form_list001("dest_year" ,$years,array_item($formdata, "dest_year") );

	         form_list001("dest_month" ,$months,  array_item($formdata, "dest_month") );

	         form_list001("dest_day" ,$days, array_item($formdata, "dest_day") );
	         echo '</td>', "\n";





//	         echo '<td class="myformtd">';
//	         form_label1("עד תאריך:",true);
//	         form_list001("dest_year" ,$years,array_item($formdata, "dest_year") );
//
//	         form_list001("dest_month" ,$months,  array_item($formdata, "dest_month") );
//
//	         form_list001("dest_day" ,$days, array_item($formdata, "dest_day") );
//	         echo '</td>', "\n";
             form_label("");
             form_label("");
	         form_end_line();

 /**********************************************************************************************************/
	         form_new_line();

	         form_label("דרגת תוצאות הצבעה 1 עד 5 ", TRUE);
	         form_text("vote_level", array_item($formdata, "vote_level"),3,5,3);
             //form_empty_cell(7);
//	         form_label("");
//	         form_label("");
//	          form_label("");
	         form_end_line();
/************************************************************************************************/
	         form_new_line();
	         form_label("דרגת חשיבות החלטה: (1 עד 10)", TRUE);
	         form_text("dec_level", array_item($formdata, "dec_level"), 3 , 5 , 3);
	         //form_label("");
	         form_end_line();

/****************************************************************************************/
	         form_new_line();
	         form_label("סטטוס החלטה: (b=פתוחה/a=סגורה)", TRUE);
	         form_text("status", array_item($formdata, "status"),  3 , 5 , 3);
	         //form_label("");
	         form_end_line();
/****************************************************************************************/

	         form_new_line();

	        // form_label("");

	         if(array_item($formdata, "btnTitle")){
	         	$tmp=((array_item($formdata, "btnTitle") &&($formdata["forum_decision"]))|| (array_item($formdata, "btnTitle") && $formdata["forum"] )) ? "forumPattern":"decPattern";
	         	form_button ("btnTitle", "חפש");
	         	form_hidden3("mode", $tmp,0, "id=mode" );
	         }
	         else{
	         	form_button ("btnTitle", "חפש");
	         }
	         //echo '<td class="myformtd">',
	         echo '<td class="contextual_help btnTitleRoot" colspan=4 >',
	         form_button2 ("btnTitleRoot", "הראה עץ יורד ");
	         form_button2 ("btnTitleRootUp", "הראה עץ עולה ");
//	         form_button2("btnTitleLetter", "הראה מופעי אותיות ");
//	         form_button2 ("btnTitleLetter1", "מופעי אותיות ללא קישורים  ");
	         echo '</td>', "\n";

	        // form_label("");

	         form_end_line();

/*************************************************************/
	         form_new_line();
	         form_label("");


	         form_url("dynamic_5.php"	,"חזרה לטופס ההחלטות",2 );
	         form_label("");
	         form_end_line();
	         ?>
	       </fieldset></form></table>
	         <?php
/***************************************************************************/
?>
<script type="text/javascript">
    $(function() {
        $("#my_resulttable tr:even").addClass("stripe1");
        $("#my_resulttable tr:odd").addClass("stripe2");

        $("#my_resulttable tr").hover(
            function() {
                $(this).toggleClass("highlight");
            },
            function() {
                $(this).toggleClass("highlight");
            }
        );
    });



</script>



<?php


}//end find_form
/****************************************************************************/
 function  general_forum_info(){
 ?>
 <form name="find_form" id="find_form" method="post" action="find3.php" >

      <fieldset  style="background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">פורומים עין השופט</h1></legend>
     <div id="main" class="my_main">
     <table class="my_tbl">
  <?php
/*****************************************************************************************/

 form_new_line();
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats_a[$row->parentForumID][] = $row->forum_decID;
			$catNames_a[$row->forum_decID] = $row->forum_decName;

    	}

			$rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
			//$rows1 = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);

		echo '<td   class="myformtd"  norwap >';
		 form_label_red1 ("שם הפורום:", TRUE);

		  form_list_find_notd ("forum_decision", "forum_decision",$rows , array_item($formdata, "forum_decision") );
	    echo '</td>';
form_end_line();

/*****************************************************************************************/



  ?>


</table>



<div id="loading">
<img src="loading4.gif" border="0" />
</div>

<div id="targetDiv"></div></div></fieldset> </form>

<?php

 }

