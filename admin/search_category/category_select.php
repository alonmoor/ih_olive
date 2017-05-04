<?php
require_once '../config/application.php';
if(!isAjax())
html_header();
?>
<script type="text/javascript" src="ajax.lang.php"></script> 
<?php  
$yearList = '';
$forumList = '';
$formdata=array();
 
/****************************FORUM_CATEGORY****************************/
?>
<link href="formstyle.css" rel="stylesheet" type="text/css" />
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_forum_dest.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_forums_dest.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_dec.js_dest"  type="text/javascript"></script> 
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_mgr.js_dest"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_precent.js_dest"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_level.js_dest"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_frm_usr.js_dest"  type="text/javascript"></script> 
<div id="main">





<?php 

echo '<p><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</a></p>', "\n";
 echo "<p>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</p>\n";	    
?>
  

<div id="forum_decision1"></div> 
  <form name="find_cat" id="find_cat" method="post" action="results_forum9.php" >
  
   
    <fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">פורומים עין השופט</h1></legend>   
    
       <table class="myformtable" style="width:30%" >
     
  <?php 

global $db;
	form_new_line();
	form_label("קטגוריות של פורומים:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
	$rows = $db->queryObjectArray($sql);
 
	foreach($rows as $row) {
	$subcats [$row->parentCatID][] = $row->catID;
	$catNames [$row->catID] = $row->catName; }
 
	$rows = build_category_array($subcats [NULL], $subcats , $catNames );
	form_list_find("category1","category1", $rows , array_item($formdata, "category1"));

	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();

   
?>        
</table>

<div id="loading">	
<img src="loading4.gif" border="0" />
</div>

</fieldset>

</form>
<!-- ----------------------------------------DEC_CATEGORY------------------------------------------------- --> 
 
 

 
 
 <form name="find_cat_dec" id="find_cat_dec" method="post" action="results_forum9.php" >
  
   
    <fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">החלטות עין השופט</h1></legend>   
    
       <table class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("קטגוריות של החלטות:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
	$rows = $db->queryObjectArray($sql);
 
	foreach($rows as $row) {
	$subcats_a[$row->parentCatID][] = $row->catID;
	$catNames_a[$row->catID] = $row->catName; }
 
	$rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
	form_list_find("category_dec","category_dec", $rows , array_item($formdata, "category_dec"));

	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>


<div id="loading">	
<img src="loading4.gif" border="0" />
</div>


</fieldset>

</form>
 
 

  <div id="category_decision"></div>    
 
 
 
<!-- ----------------------------------------MANAGERS_CATEGORY------------------------------------------------- --> 
 
 

 
 
 <form name="find_cat_mgr" id="find_cat_mgr" method="post" action="results_forum9.php" >
  
   
    <fieldset id="find_cat_mgr_fieldset"  style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">מנהלים עין השופט</h1></legend>   
    
       <table class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("קטגוריות של מנהלים:",TRUE);
// get all categories
	$sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
	$rows = $db->queryObjectArray($sql);
 
	foreach($rows as $row) {
	$subcats1[$row->parentManagerTypeID][] = $row->managerTypeID;
	$catNames1[$row->managerTypeID] = $row->managerTypeName; }
 
	$rows = build_category_array($subcats1[NULL], $subcats1, $catNames1);
	form_list_find("category_mgr","category_mgr", $rows , array_item($formdata, "category_mgr"));

	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>

<div id="loading">	
<img src="loading4.gif" border="0" />
</div>

</fieldset>

</form>
 
 

<!-- <div id="cat_mgr"></div>   -->
<!-- ----------------------------------------PRECENT_CATEGORY------------------------------------------------- --> 
 
 <form name="find_cat_precent" id="find_cat_precent" method="post" action="results_forum9.php" >
  
   
    <fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">אחוזי הצבעה על החלטות</h1></legend>   
    
       <table class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("קטגוריות של אחוזי הצבעה:",TRUE);
	
	echo '<td class="myformtd">';
	echo "מ.. אחוז";
	for($x=50;$x<100;$x=$x+5):
	$growthList .= '<option value="'.$x.'"> '.$x.'% </option>
	';
	endfor;

?> 
  
      <select name="growth" id="growth" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList; ?>
    </select>
 	
<?php 
echo '</td class="myformtd">'; 


  	echo '<td class="myformtd">';
  	echo "עד אחוז";
	for($y=50;$y<=100;$y=$y+5):
	$growthList_dest .= '<option value="'.$y.'"> '.$y.'% </option>
	';
	endfor;

?> 
  
      <select name="growth_dest" id="growth_dest" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_dest; ?>
    </select>
  
  
<?php  

 echo '</td class="myformtd">'; 
	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>

<div id="loading">	
<img src="loading4.gif" border="0" />

</div>
</fieldset>

</form>
 
 

<!-- <div id="category_precent"></div>  -->
 
  
<!-- ----------------------------------------LEVEL_CATEGORY------------------------------------------------- --> 
 <form name="find_cat_level" id="find_cat_level" method="post" action="results_forum9.php" >
  
   
    <fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">רמת חשיבות ההחלטות</h1></legend>   
    
       <table class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("רמת חשיבות ההחלטות:",TRUE);
	
	echo '<td class="myformtd">';
	echo "רמת חשיבות";
	for($x=0;$x<=10;$x=$x+1):
	$growthList_level .= '<option value="'.$x.'"> '.$x.' </option>
	';
	endfor;

?> 
  
      <select name="growth_level" id="growth_level" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_level?>
    </select>
 	
<?php 
   echo '</td class="myformtd">'; 

   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>

<div id="loading">	
<img src="loading4.gif" border="0" />
</div>

</fieldset>

</form>
 
<!-- ----------------------------------------USER_FORUM------------------------------------------------- --> 
 
 

 
 
 <form name="find_frm_usr" id="find_frm_usr" method="post" action="results_forum9.php" >
  
   
    <fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">מספר חברים בפורומים</h1></legend>   
   
       <table class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("מספר חברים בפורום:",TRUE);
	
	echo '<td class="myformtd">';
	echo "מ..מספר חברים";
	for($x=0;$x<=50;$x=$x+1):
	$growthList_frm_usr .= '<option value="'.$x.'"> '.$x.' </option>
	';
	endfor;

?> 
  
      <select name="growth_frm_usr" id="growth_frm_usr" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_frm_usr?>
    </select>
 	
<?php 
   echo '</td class="myformtd">'; 
  echo '<td class="myformtd">';
  		echo "עד..מספר חברים";
  
	for($y=1;$y<=50;$y=$y+1):
	$growthList_frm_usr_dest .= '<option value="'.$y.'"> '.$y.' </option>
	';
	endfor;

?> 
  
      <select name="growth_frm_usr_dest" id="growth_frm_usr_dest" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_frm_usr_dest; ?>
    </select>
  
  
<?php  

 echo '</td class="myformtd">'; 
   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>

<div id="loading">	
<img src="loading4.gif" border="0" />
</div>

</fieldset>
</form>
 
 
 
 <!-- ----------------------------------------GENERAL_FORUM------------------------------------------------- --> 
 
 
 <form name="find_form_general" id="find_form_general" method="post" action="find3.php" >
  
   
    <fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend><h1 style="color:white">מידע כללי פורומים</h1></legend>   
     
       <table class="myformtable" style="width:30%" >
     
  <?php 
/*****************************************************************************************/

 form_new_line();
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats2[$row->parentForumID][] = $row->forum_decID;
			$catNames2[$row->forum_decID] = $row->forum_decName;
            
    	}

			$rows = build_category_array($subcats2[NULL], $subcats2, $catNames2);
				
		echo '<td   class="myformtd"  norwap >'; 
		 form_label_red1 ("שם הפורום:", TRUE); 		
		 
		  form_list_find_notd ("forum_decision_general", "forum_decision_general",$rows , array_item($formdata, "forum_decision_general") );	
	    echo '</td>';	
form_end_line(); 
  
/*****************************************************************************************/
   
        
 	       
  ?>
  
 
</table>

<div id="loading_general">	
<img src="loading4.gif" border="0" />
</div>

  <div id="targetDiv_general"></div> 	 

</fieldset>

</form>


 
 
 
 
 
 
<!--  ------------------------------------------------------------------------- -->  
 </div><!-- end div main --> 
  


<?php
        echo '<p><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</a></p>', "\n";
//	    echo "<p>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</p>\n";	
//		$url="../admin/forum_demo12.php";
//        $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
//        echo "<p>חזרה אל ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . ".</p>\n";
html_footer();

?>