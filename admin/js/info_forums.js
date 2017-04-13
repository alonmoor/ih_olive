/*******************************************************************************************/	 	 		
	 $(document).ready(function() { 
		 $('#my_find_ol').css('list-style','none');	
		 $('#find_form_general_dest').hide(); 
		 
 	    var options = { 
 	    		
 	         beforeSubmit:  showRequest,  // pre-submit callback 
 	         
 	         success:  processJson,
 	         dataType: 'json'
 	     }; 
 	  
 	     
 	     $('#find_form_general').ajaxForm(options); 
 	    
 	  function showRequest(formData, jqForm) { 
 	     
 	  var extra = [ { name: 'json', value: '1' }];
 	  $.merge( formData, extra);
 	   
 	     return true;  
 	 } 

 	  
 	 function processJson(data) {
 	 	 
 	 var countyList_general = '';
 	 

 	      
 	  $.each(data, function(i){
 	 		 
 	 	  countList_general += '<li><a href="../admin/find3.php?forum_decID='+data.forum_decision+'"  class="maplink" >'+data.forum_decName+'</a></li>';
 	 		
 	  });

 	  $('#targetDiv_general').html('<ul id="countyList_general">'+countyList_general+'</ul>').find('a.maplink').click(function(){
 	 	 var index = $('a.maplink').index(this);
 	 	  
 	 	 return false;
 	 	  });

 	  



 	 }

 	 
 	 $('form#find_form_general fieldset').find('select#forum_decision_general').change(function(){
 	 $.ajax({
 	    type: "POST",
 	    url: "find3.php",
 	    data: "forum_decision_general="+this.value,
 	    success: function(msg){
 	 $('div#targetDiv_general').html(' ').append('<p>'+msg+'</p>');
 	    }
 	  });
 	 });
 	 
     
 /*********************************************************************************************/
         
   	  $("#loading_general img").ajaxStart(function(){
  	    $(this).show();
  	  }).ajaxStop(function(){
  	    $(this).hide();
  	  });
 
         
         
})//end DCR  