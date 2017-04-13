 
var countJson;

// prepare the form when the DOM is ready 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
 	$('#find_cat_dest').hide();
 	
 	

   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	countJson = data;
    var countList = '';
    var forumList = '';
    // 'data' is the json object returned from the server 
   $.each(data, function(i){
	   countList += '<li><a href="find3.php?forum_decID='+this.forum_decID+'"  class="href_modal3" >'+this.forum_decName+'</a></li>';
 });


 $('#targetDiv').html('<ul id="countList">'+countList+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson[i].forum_decName;
    var id=countJson[i].forum_decID;
   

   });
$('a.href_modal3').css({'background':'#B4D9D7'}).bind('click', function() {
  	var link=$(this).attr('href') ;
   	 openmypage3(link); 
	return false;
});

 
}
/************************************************************************************************/
$('form#find_cat fieldset').append('<div id="targetDiv"></div>').find('select#category1').change(function(){
	$('#targetDiv_dest').hide();
$.ajax({
   type: "POST",
  
   url: "ajax2.php",
   data: "category1="+this.value,
   success: function(msg){
$('div#targetDiv').html(' ').append('<p>'+msg+'</p>');
   }

 });

 

});




/*************************************************************/   
});//end DCR 
/************************************************************/ 
 $("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });
 
