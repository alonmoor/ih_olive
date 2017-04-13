<?php
require_once '../config/application.php';
require_once (LIB_DIR.'/model/forum_class.php');
require_once ("../lib/model/DBobject3.php");
 
 html_header();

 

?>
 <link href="formstyle.css" rel="stylesheet" type="text/css" />
<?php 
/*****************************************************************************************/
/*****************************************************************************************/  
?>
 <div id="main">

 
    
     <form name="forum" id="forum" method="post" action="../admin/dynamic_10.php" >
 
   <fieldset><legend>פורומים עין השופט</legend>
 
       <div id="forum-message"></div>
       <table class="myformtable" >	
	
	
<?php	
	
	global $db;

      
	


/****************************************************************************************/
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
/******************************************************************************************************/
/************************************************************************************************/
 ?>
 </table>
 </fieldset></form>
 
</div>
  
 

 

<script>

 

////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() { 
/************************************************************************************************/
  var url='/alon-web/olive/admin/';
$('form#forum fieldset').append('<div id="targetDiv"></div>').find('select#forum_decision').change(function(){
	$.ajax({
	   type: "POST",
	   //url: url+'dynamic_9.php',
	   url: url+'find3.php',
	   data: "forum_decision="+this.value,
	   success: function(msg){
	$('div#targetDiv').html(' ').append('<p>'+msg+'</p>');
	   }
	 }); 	 
	$('#forum_decision2').html(' ');
 
	});


/*************************************************************/   

});



  
 
	 $("#loading img").ajaxStart(function(){
	   $(this).show();
	 }).ajaxStop(function(){
	   $(this).hide();
	 });


</script>



 
