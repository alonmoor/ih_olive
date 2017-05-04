<?php
require_once '../config/application.php';
if(!isAjax())
html_header();
 ?>
 
<!-- 
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/find.js"  type="text/javascript"></script> 
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_forum_dest.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_forums_dest.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_dec_dest.js"  type="text/javascript"></script> 
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_mgr_dest.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_precent_dest.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_level_dest.js"  type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/tmp_js/info_frm_usr_dest.js"  type="text/javascript"></script>
 --> 
<script type="text/javascript">
$(document).ready(function(){
	$('#my_find_ol').css('list-style','none');	 
//	if($.browser.mozilla==true)  {
//     $("#main_accordion2").css({'margin-left':'50px'});
//	}

var accOpts = {
		header: ".header",
		fillSpace: true,
		
        navigation: true,
		
		//  event: "mouseover",
		  active: false,
		  header: 'h2',
		 
	     clearStyle: true,
		//  animated: "bounceslide",
		 // animated: "easeOutBounce",
		  collapsible: true  
		};


 
  $('#main_accordion2').accordion(accOpts);
 
/*******************************************************************************************************************/	
	
	 $('#first_li').hide();	
	
$('#nav2').remove();

if($('#count_my_decID').val()){ 
var count_decID=$('#count_my_decID').val();
}
if($('#count_my_forum_decID').val()){
var  count_forum_decID=$('#count_my_forum_decID').val(); 
}

if(count_forum_decID && count_decID){
if(count_forum_decID > count_decID)
	var count=count_forum_decID;
if(count_forum_decID < count_decID)	
		var count=count_decID;
if(count_forum_decID == count_decID)	
		var count=count_decID;
} else	

var count=count_forum_decID?count_forum_decID:count_decID;	

if(count)  { 		 

		 if(count>1){
			
				 $('#ajaxbox.dhtmlwindow').pager('li', {
				      navId: 'nav2',
					  height: '15em' 
					 });
				$('#nav2').draggable();
		         
				 
			 
				// $('div[id^=my_dec_tree]').hide();
				 $('#first_li').hide();				 
					 
					 $('a.my_paging').not($('#my_paging1')).bind('click', function() {
               
						 
						 if(!($('input[id^=my_entry_ajx_hidden]').val())) { 
							 $('#my_resulttable_0').hide();
						 }		 
                      $('div[id^=my_entry_ajx]').remove();
						   
						   
						   if($('a.my_paging').attr('rel') == 'prev'  &&  keep_i.num===0) {
							 
							   if(!($('input[id^=my_entry_ajx_hidden]').val()))
								 $('#my_resulttable_0').show();
							 
								   $('#first_li').hide();	
								   keep_i.num='';
							}
						   
						   var zIndexvalue =zIndexvalue_obj.zindex;// $('#ToolTipDiv_find').css("z-index");
						    zIndexvalue++;
						   zIndexvalue_obj.zindex=zIndexvalue;
						  $('#ToolTipDiv_find').css('z-index',   zIndexvalue_obj.zindex);
						   
						   
						 });				 
					 
					 
				
				$('a#my_paging1').bind('click', function() {//press the first page
					
					 
					   $('#my_resulttable_0').show();
					   
					   $('#first_li').hide();	
					   
					   var zIndexvalue =zIndexvalue_obj.zindex;// $('#ToolTipDiv_find').css("z-index");
					    zIndexvalue++;
					   zIndexvalue_obj.zindex=zIndexvalue;
					  $('#ToolTipDiv_find').css('z-index',   zIndexvalue_obj.zindex);
					   
					 });				
				
				
				
				
				
			     }//end if count 

}		 
	 			  
/****************************************************/
});
</script>
<!-- ------------------------------------------------------------------------------------------------------------- -->
<div id="main_accordion2" class="accordion4">


  
<!-- ----------------------------------CAT_FORUM2------------------------------------------- -->
<h2 class="my_accordion_dest" style="width:100%;">קטגוריות של פורומים</h2>
<div class="ui-widget-content">


<div id="loading_dest">	
<img src="loading4.gif" border="0" />
</div>


 <div id="forum_decision2"></div> 
 
 
 
 
  <form name="find_cat_dest" id="find_cat_dest" method="post" class="myformcategory_2" action="results_forum9.php" >
  
    
    <fieldset class="my_fieldset_dest"> <legend style="color:brown;"> פורומים עין השופט </legend>   
   
     <table id="cat_forum_dest" class="myformtable" style="width:30%" >
        
  <?php 

global $db;
	form_new_line();
	form_label("קטגוריות של פורומים:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
	$rows = $db->queryObjectArray($sql);
 
	foreach($rows as $row) {
	$subcats_dest [$row->parentCatID][] = $row->catID;
	$catNames_dest [$row->catID] = $row->catName; }
 
	$rows = build_category_array($subcats_dest [NULL], $subcats_dest , $catNames_dest );
	form_list_find("category1_dest","category1_dest", $rows , array_item($formdata, "category1_dest"));

	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();

   
?>        
</table>



</fieldset>

</form>
</div>
 

<!-- ----------------------------------------DEC_CATEGORY2------------------------------------------------- --> 
     <h2 class="my_accordion_dest" style="width:100%;">קטגוריות של החלטות</h2>
 <div class="ui-widget-content">
 
 
 <div id="loading_dec_dest">	
<img src="loading4.gif" border="0" />
</div>




<div id="category_decision_dest"></div>   
 
 
 
 
 <form name="find_cat_dec_dest" id="find_cat_dec_dest" method="post" class="myformcategory_2" action="results_forum9.php"  >
  
   
    <fieldset class="my_fieldset_dest"><legend   style="color:brown;">החלטות עין השופט</legend>   
    
       <table id="cat_dec_dest2" class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("קטגוריות של החלטות:",TRUE);
// get all categories
	$sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
	$rows = $db->queryObjectArray($sql);
 
	foreach($rows as $row) {
	$subcats_dec_dest[$row->parentCatID][] = $row->catID;
	$catNames_dec_dest[$row->catID] = $row->catName; }
 
	$rows = build_category_array($subcats_dec_dest[NULL], $subcats_dec_dest, $catNames_dec_dest);
	form_list_find("category_dec_dest","category_dec_dest", $rows , array_item($formdata, "category_dec_dest"));

	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>



</fieldset>

</form>
 
</div> 

   
 <!-- ----------------------------------------MANAGERS_CATEGORY2------------------------------------------------- --> 
    <h2 class="my_accordion_dest" style="width:100%;">קטגוריות של מנהלים</h2>
<div class="ui-widget-content">


<div id="loading_mgr_dest">	
<img src="loading4.gif" border="0" />
</div>


 <div id="cat_mgr_dest"></div>   


 <form name="find_cat_mgr_dest" id="find_cat_mgr_dest" method="post" class="myformcategory_2" action="results_forum9.php" >
   
    <fieldset class="my_fieldset_dest"><legend style="color:brown;">מנהלים עין השופט</legend>   
    
       <table id="find_cat_mgr_table_dest" class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("קטגוריות של מנהלים:",TRUE);
// get all categories
	$sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
	$rows = $db->queryObjectArray($sql);
 
	foreach($rows as $row) {
	$subcats1_dest[$row->parentManagerTypeID][] = $row->managerTypeID;
	$catNames1_dest[$row->managerTypeID] = $row->managerTypeName; }
 
	$rows = build_category_array($subcats1_dest[NULL], $subcats1_dest, $catNames1_dest);
	form_list_find("category_mgr_dest","category_mgr_dest", $rows , array_item($formdata, "category_mgr_dest"));

	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>


</fieldset>

</form>
</div> 
 

 
<!-- ----------------------------------------PRECENT_CATEGORY2------------------------------------------------- --> 
  <h2 class="my_accordion_dest" style="width:100%;">קטגוריות של אחוזי הצבעה</h2>
 <div class="ui-widget-content">


<div id="loading_precent_dest">	
<img src="loading4.gif" border="0" />

</div>


<div id="category_precent_dest"></div>  


 <form name="find_cat_precent_dest" id="find_cat_precent_dest" method="post" class="myformcategory_2" action="results_forum9.php" >
  
      
   
    <fieldset class="my_fieldset_dest"><legend  style="color:brown;">אחוזי הצבעה על החלטות</legend>   
    
       <table class="myformtable" style="width:30%" >
     
 
  <?php 
 
global $db;
	form_new_line();
	form_label("קטגוריות של אחוזי הצבעה:",TRUE);
	
	echo '<td class="myformtd">';
	echo "מ.. אחוז";
	for($x=50;$x<100;$x=$x+5):
	$growthList_precent .= '<option value="'.$x.'"> '.$x.'% </option>
	';
	endfor;

?> 
  
      <select name="growth_precent" id="growth_precent" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_precent?>
    </select>
 	
<?php 
echo '</td class="myformtd">'; 


  	echo '<td class="myformtd">';
  	echo "עד אחוז";
	for($y=50;$y<=100;$y=$y+5):
	$growthList_precent_dest .= '<option value="'.$y.'"> '.$y.'% </option>';
	endfor;

?> 
  
      <select name="growth_precent_dest" id="growth_precent_dest" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_precent_dest?>
    </select>
  
  
<?php  

 echo '</td class="myformtd">'; 
	
		       
                   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>



 


</fieldset>

</form>
</div> 
<!-- ----------------------------------------LEVEL_CATEGORY2------------------------------------------------- --> 
<h2 class="my_accordion_dest" style="width:100%;">קטגוריות של רמת חשיבות ההחלטות</h2>
 <div class="ui-widget-content">
 
 <div id="loading_level_dest">	
<img src="loading4.gif" border="0" />
</div>



<div id="cat_level_dest"></div>
 
 
 <form name="find_cat_level_dest" id="find_cat_level_dest" method="post" class="myformcategory_2" action="results_forum9.php" >
 
    <fieldset class="my_fieldset_dest"><legend  style="color:brown;">רמת חשיבות ההחלטות</legend>   
           <table  id="find_level_table_dest" class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("רמת חשיבות ההחלטות:",TRUE);
	
	echo '<td class="myformtd">';
	echo "רמת חשיבות";
	for($x=0;$x<=10;$x=$x+1):
	$growthList_level_dest .= '<option value="'.$x.'"> '.$x.' </option>
	';
	endfor;

?> 
  
      <select name="growth_level_dest" id="growth_level_dest" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_level_dest?>
    </select>
 	
<?php 
   echo '</td class="myformtd">'; 

   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>


</fieldset>

</form> 
</div> 
<!-- ----------------------------------------USER_FORUM2------------------------------------------------- --> 
   <h2 class="my_accordion_dest" style="width:100%;">קטגוריות של מספר חברים בפורום</h2>
 <div class="ui-widget-content">
 <div id="loading">	
<img src="loading4.gif" border="0" />
</div>
<div id="my_user_forum"></div>
 <form name="find_frm_usr_dest" id="find_frm_usr_dest" method="post" class="myformcategory_2" action="results_forum9.php" >
   
  
   
    <fieldset class="my_fieldset_dest"><legend  style="color:brown;">מספר חברים בפורומים</legend>   
   
       <table class="myformtable" style="width:30%" >
     
  <?php 
 
global $db;
	form_new_line();
	form_label("מספר חברים בפורום:",TRUE);
	
	echo '<td class="myformtd">';
	echo "מ..מספר חברים";
	for($x=0;$x<=50;$x=$x+1):
	$growthList_frm_usr_src .= '<option value="'.$x.'"> '.$x.' </option>';
	endfor;

?> 
  
      <select name="growth_frm_usr_src" id="growth_frm_usr_src" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_frm_usr_src?>
    </select>
 	
<?php 
   echo '</td class="myformtd">'; 
  echo '<td class="myformtd">';
  		echo "עד..מספר חברים";
  
	for($y=1;$y<=50;$y=$y+1):
	$growthList_frm_usr_dest_num .= '<option value="'.$y.'"> '.$y.' </option>
	';
	endfor;

?> 
  
      <select name="growth_frm_usr_dest_num" id="growth_frm_usr_dest_num" class="mycontrol">
        <option value="">Choose one</option>
		
	  <?=$growthList_frm_usr_dest_num?>
    </select>
  
  
<?php  

 echo '</td class="myformtd">'; 
   form_button ("btnTitle", "הראה נתונים");
 	form_end_line();
 
   
?>        
</table>


</fieldset>
</form> 
</div>
<!-- ----------------------------------------GENERAL_FORUM2------------------------------------------------- --> 
 
  <h2 class="my_accordion_dest" style="width:100%;">מידע כללי פורומים</h2>
 <div class="ui-widget-content">
 <form name="find_form_general_dest" id="find_form_general_dest" class="myformcategory_2" method="post" action="find3.php" >
       
  
   
    <fieldset class="my_fieldset_dest"><legend  style="color:brown;">מידע כללי פורומים</legend>   
     
       <table class="myformtable" style="width:30%" >
         <tr>
  <?php 
		$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		foreach($rows as $row) {
			$subcats2_dest[$row->parentForumID][] = $row->forum_decID;
			$catNames2_dest[$row->forum_decID] = $row->forum_decName;
            
    	}

			$rows = build_category_array($subcats2_dest[NULL], $subcats2_dest, $catNames2_dest);
				
		echo '<td   class="myformtd"  norwap >'; 
		 form_label_red1 ("שם הפורום:", TRUE); 		
		 
		  form_list_find_notd ("forum_decision_general_dest", "forum_decision_general_dest",$rows , array_item($formdata, "forum_decision_general_dest") );	
	     
 	       
  ?>
  
 
</td></tr></table>

<div id="loading_general_dest">	
<img src="loading4.gif" border="0" />
</div>

  <div id="targetDiv_general_dest"></div> 	 

</fieldset>

</form>
</div>

 
 
 
 
 
 
<!--  ------------------------------------------------------------------------- -->  
 </div><!-- end div main --> 
  


<?php
html_footer();

?>