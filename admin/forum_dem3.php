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

 build_form_ajx1($formdata);
 
/**************************************************************************	***************/		 
/*****************************************************************************************/
   
?> 


 

<script>

 
var mapstraction,countJson;

// prepare the form when the DOM is ready 

	 function setupAjaxForm(form_id, form_validations){
			var form = '#' + form_id;
			var form_message = form + '-message';
			
			
			// setup loading message
			$(form).ajaxSend(function(){
				$(form_message).removeClass().addClass('loading').html('Loading...').fadeIn();
				 
			});
				 
	 
   var options = { 
		 
        beforeSubmit: function(){
		
			 showRequest 
		},  
             // pre-submit callback 
         
        success:  processJson, 
                 
        dataType: 'json'
    }; 
   

    // bind form using 'ajaxForm' 
    $('#forum').ajaxForm(options); 




    
 function showRequest(formData, jqForm) { 
	 
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)
 
    return true;  
} 


 

 
/********************************************************************************************/
 
/**********************************************************************************************/

// post-submit callback 
function processJson(data) {
	 
	countJson = data;
 
    var countList = '';
    var forumList = '';
    var countList1 = ''; 
	var countList2 = ''; 
	var countList3 = '';  
  
   
    var	j= 0 ;


    if(data.type == 'success'){
    	forumList+=	$(form_message).removeClass().addClass(data.type).html(data.message).fadeIn('slow');
		
    	$('#forum-message').html('<ul id="countList1">'+forumList+'</ul>');
		 countList += '<li><a href="../admin/find3.php?forum_decID='+data.forum_decision+'"  class="maplink" >'+data.forum_decName+'</a></li>';
		 
		// alert(countList);

	 $('#forum-message').html('<ul id="countList1">'+countList+'</ul>').find('a.maplink').each(function(i){
		    var index = $('a.maplink').index(this);
		    var v = countJson.forum_decName;
		    var id=countJson.forum_decID;
		   
		   $(this).click(function(){
		    $.get('../admin/dynamic_10.php?forum_decID='+id+'', $(this).serialize(), function(data) {
		      $('#forum-message').html(data);
		    });
		  
		   
		     return false;
		    });
		   
		   });  		
	 
}
	
 


	    

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			else{
	$.each(data  , function(i){ 			
		var  messageError="messageError_"+j;
	 
	    //	countList1 += '<li>'+$(form_message).removeClass().addClass(data.type).html(eval("data.message[0]." + messageError)).fadeIn('slow');+'</li>';
			 countList2 +='<li class="error">'+  (eval("data.message[0]." + messageError))+'</li>';
	        
				 j++;
		    		 
		 });

      
	 
 
	 $('#forum-message').html('<ul id="countList1">'+countList2+'</ul>');



   }
	 
}


/////////////////////////////////////////////////////////////////////////////////////////
}
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

/////////////////////////////////////////////////////////////////
//$('form#forum fieldset').append('<div id="targetDiv"></div>').find('select#category1').change(function(){
//$.ajax({
//   type: "POST",
//   url: "forum_count.php",
//   data: "category1="+this.value,
//   success: function(msg){
//$('div#targetDiv').html(' ').append('<p>'+msg+'</p>');
//   }
// });
// 
//$('#forum_decision1').html(' ');
//});




/*************************************************************/   
	// new setupAjaxForm('forum');
});






 

/*************************************************************/   
//}); 
/************************************************************/ 
// $('form#forum fieldset').ajaxSend(function(){
// 		$('form#forum fieldset').removeClass().addClass('loading').html('Loading...').fadeIn();	 
// 	});
 	
// 	.ajaxStop(function(){
// 		$(this).html('Loading...').hide();
//	 }); 	
 
 
	 $("#loading img").ajaxStart(function(){
	   $(this).show();
	 }).ajaxStop(function(){
	   $(this).hide();
	 });


</script>



 
<?php html_footer();?>