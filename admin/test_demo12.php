<?php
require_once '../config/application.php';
if(!isAjax())
html_header();
 ?>
<!--<script type="text/javascript" src="ajax.lang.php"></script> -->
<?php 
$yearList = '';
$forumList = '';
$formdata=array();
 
/****************************FORUM_CATEGORY****************************/
?>
	 
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_forum.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_forums.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_dec.js"  type="text/javascript"></script> 
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_mgr.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_precent.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_level.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_frm_usr.js"  type="text/javascript"></script> 



<!-- ------------------------------------------------------------------------------------------------------------- -->

<script type="text/javascript">
$(document).ready(function(){
	//$('.my_accordion_dest').hi  de();
	 
 


var accOpts = {
	 	//header: ".header",
 	 	fillSpace: true,
 		autoHeight: true,
 		autoWidth: true,
//        navigation: true,
//        
//		   active: false,
//		  header: 'h4',
//		 
//	  
//		  collapsible: true,
 		  clearStyle: true,




		  active: false,
		  collapsible: true
  
		};

//$('#main_accordion').accordion();
  
//$('#main_accordion').accordion(accOpts);
/*****************************************************/ 
$( '#main_accordion > div' ).hide();
  
  
  $('#main_accordion h4').click(function() {
    $(this).next().animate( 
	    {'height':'toggle'}, 'slow', 'easeOutBounce'
    );
  });
/****************************************************/
});
</script>

<?php 

echo '<div>';
		         echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	
		
				$url="../admin/forum_demo12_2.php";
			    $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
			    echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";
     echo '</div>';
		
?>
<!-- ------------------------------------------------------------------------------------------------------------- -->
<div id="main_accordion" class="ui-widget ui-helper-reset">


<!-- ----------------------------------CAT_FORUM1------------------------------------------- -->
 

<h4 class="ui-widget-header ui-corner-all" style="font-color:red;width:82%;" >קטגוריות של פורומים</h4>
<div class="ui-widget-content" style="width:82%;">

    <form class="myformcategory" name="find_cat" id="find_cat" method="post" action="results_forum9.php" >
  
    <fieldset class="my_fieldset_src"><legend><h1>פורומים עין השופט</h1></legend>   

       <table id="cat_forum" class="myformtable" style="width:30%" >
        
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
<img src="../loading4.gif" border="0" />
</div>
<div id="forum_decision1"></div> 
</fieldset>

</form>
</div> 
<!-- ----------------------------------------DEC_CATEGORY1------------------------------------------------- --> 
 
 
 <h4 class="ui-widget-header ui-corner-all" style="width:82%;" >קטגוריות של החלטות</h4>
 <div class="ui-widget-content" style="width:82%;">
 <form class="myformcategory" name="find_cat_dec" id="find_cat_dec" method="post" action="results_forum9.php" >
  
   
    <fieldset class="my_fieldset_src"><h1>החלטות עין השופט</h1></legend>   
    
       <table id="cat_dec_dest1" class="myformtable" style="width:30%" >


     
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
<img src="../loading4.gif" border="0" />
</div>


</fieldset>

</form>
</div> 

  
 
<!-- ----------------------------------------MANAGERS_CATEGORY1------------------------------------------------- --> 
  <h4 class="ui-widget-header ui-corner-all" style="width:82%;">קטגוריות של מנהלים</h4>
 <div class="ui-widget-content" style="width:82%;">  
 <form class="myformcategory" name="find_cat_mgr" id="find_cat_mgr" method="post" action="results_forum9.php" >
  
   
    <fieldset class="my_fieldset_src"><legend><h1>מנהלים עין השופט</h1></legend>   
    
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
<img src="../loading4.gif" border="0" />
</div>

</fieldset>

</form>

</div>
<!-- ----------------------------------------PRECENT_CATEGORY1------------------------------------------------- --> 
 <h4 class="ui-widget-header ui-corner-all" style="width:82%;">קטגוריות של אחוזי הצבעה</h4>
  <div class="ui-widget-content" style="width:82%;">
 <form  class="myformcategory" name="find_cat_precent" id="find_cat_precent" method="post" action="results_forum9.php" >
  
    
    <fieldset class="my_fieldset_src"><legend><h1>אחוזי הצבעה על החלטות</h1></legend>   
    
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
		
	  <?PHP echo $growthList; ?>
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
		
	  <?PHP echo $growthList_dest; ?>
    </select>
  
  
<?php  

 echo '</td class="myformtd">'; 
	
		       
    form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>

<div id="loading">	
<img src="../loading4.gif" border="0" />

</div>
</fieldset>

</form>
</div> 
 
  
<!-- ----------------------------------------LEVEL_CATEGORY1------------------------------------------------- --> 
  <h4 class="ui-widget-header ui-corner-all" style="width:82%;">קטגוריות של רמת חשיבות ההחלטות</h4>
  <div class="ui-widget-content" style="width:82%;">
 <form  class="myformcategory" name="find_cat_level" id="find_cat_level" method="post" action="results_forum9.php" >
  
     
   
    <fieldset class="my_fieldset_src"><legend><h1>רמת חשיבות ההחלטות</h1></legend>   
    
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
		
	  <?PHP echo $growthList_level; ?>
    </select>
 	
<?php 
   echo '</td class="myformtd">'; 

   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>

<div id="loading">	
<img src="../loading4.gif" border="0" />
</div>

</fieldset>

</form>
</div>
<!-- ----------------------------------------USER_FORUM1------------------------------------------------- --> 
 <h4 class="ui-widget-header ui-corner-all" style="width:82%;">קטגוריות של מספר חברים בפורום</h4>
 <div class="ui-widget-content" style="width:82%;">
 <form class="myformcategory"  name="find_frm_usr" id="find_frm_usr" method="post" action="results_forum9.php" >
  
   
    <fieldset class="my_fieldset_src"><legend><h1>מספר חברים בפורומים</h1></legend>   
   
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
		
	  <?PHP echo $growthList_frm_usr;?>
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
		
	  <?PHP echo $growthList_frm_usr_dest;?>
    </select>
  
  
<?php  

 echo '</td class="myformtd">'; 
   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>

<div id="loading">	
<img src="../loading4.gif" border="0" />
</div>

</fieldset>
</form>
</div> 
 
 <!-- ----------------------------------------GENERAL_FORUM1------------------------------------------------- --> 
  <h4 class="ui-widget-header ui-corner-all" style="width:82%;">מידע כללי פורומים</h4>
  <div class="ui-widget-content" style="width:82%;">
 <form  class="myformcategory" name="find_form_general" id="find_form_general" method="post" action="find3.php" >
   
    <fieldset class="my_fieldset_src"><legend><h1>מידע כללי פורומים</h1></legend>   
     
       <table class="myformtable" style="width:30%" >
         <tr>
  <?php  
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
	    echo '</td></tr>';	
 
  
  ?>
  
 
</table>

<div id="loading_general">	
<img src="../loading4.gif" border="0" />
</div>

  <div id="targetDiv_general"></div> 	 

</fieldset>

</form>
</div>
<!--  ------------------------------------------------------------------------- -->  
 </div><!-- end div main --> 
  


<?php
      
html_footer();

?>