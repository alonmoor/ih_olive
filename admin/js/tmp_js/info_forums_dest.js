/*******************************************************************************************/	 	 		
	 $(document).ready(function() {
		 $('#my_find_ol').css('list-style','none');	
		 	$('.my_accordion').hide(); 
		 
		 
 	    var options = { 
 	        
 	         beforeSubmit:  showRequest,  // pre-submit callback 
 	         
 	         success:  processJson,
 	         dataType: 'json'
 	     }; 
 	  
 	     
 	     $('#find_form_general_dest').ajaxForm(options); 
 	    
 	  function showRequest(formData, jqForm) { 
 	     
 	  var extra = [ { name: 'json', value: '1' }];
 	  $.merge( formData, extra);
 	   
 	     return true;  
 	 } 

 	  
 	 function processJson(data) {
 		removejscssfile("../admin/js/find2.js", "js");		 
 	 	 
 	 var countyList_general_dest = '';
 	 

 	      
 	  $.each(data, function(i){
 	 		 
 	 	  countList_general_dest += '<li><a href="../admin/find3.php?mode_js=no_find2&forum_decID='+data.forum_decision+'"  class="maplink" >'+data.forum_decName+'</a></li>';
 	 		
 	  });

 	  $('#targetDiv_general_dest').html('<ul id="countyList_general_dest">'+countyList_general_dest+'</ul>').find('a.maplink').click(function(){
 	 	 var index = $('a.maplink').index(this);
 	 	  
 	 	 return false;
 	 	  });

 	  



 	 }

 	 
 	 $('form#find_form_general_dest fieldset').find('select#forum_decision_general_dest').change(function(){
 	 $.ajax({
 	    type: "POST",
 	    url: "find3.php",
 	    data: "forum_decision_general_dest="+this.value,
 	    success: function(msg){
 	 $('div#targetDiv_general_dest').html(' ').append('<p>'+msg+'</p>');
 	    }
 	  });
 	 });
 	 
     
 /*********************************************************************************************/
         
   	  $("#loading_general_dest img").ajaxStart(function(){
  	    $(this).show();
  	  }).ajaxStop(function(){
  	    $(this).hide();
  	  });
 
         
    
})//end DCR  