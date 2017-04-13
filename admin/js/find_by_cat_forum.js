 
 
$(document).ready(function() { 
	 
		
	 
   var options = { 
       
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    
    $('#find_form').ajaxForm(options); 
   
 function showRequest(formData, jqForm) { 
    
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra);
  
    return true;  
} 

 
function processJson(data) {
	 
var countyList = '';
     
 $.each(data, function(i){
		 
	  countList += '<li><a href="../admin/find3.php?forum_decID='+data.forum_decision+'"  class="maplink" >'+data.forum_decName+'</a></li>';
		
 });

 $('#targetDiv').html('<ul id="countyList">'+countyList+'</ul>').find('a.maplink').click(function(){
	 var index = $('a.maplink').index(this);
	 alert(index);
	 return false;
	  });
}

$('form#find_form fieldset').find('select#forum_decision').change(function(){
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




