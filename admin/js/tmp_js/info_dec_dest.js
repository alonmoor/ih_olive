 
var countJson_dec_dest;

// prepare the form when the DOM is ready 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');		
	
/*****************************************************************************/	
 	$('.my_accordion').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 

  
   
   
    // bind form using 'ajaxForm' 
    $('#find_cat_dec_dest').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	 
	countJson_dec_dest = data;
    var countList_dec_dest = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_dec_dest += '<li><a href="find3.php?mode_js=no_find2&decID='+this.decID+'"   class="maplink" >'+this.decName+'</a></li>';
  
  
 });


 $('#targetDiv_dec_dest').html('<ul id="countList_dec_dest">'+countList_dec_dest+'</ul>').find('a.maplink').each(function(i){
    var index = $('a.maplink').index(this);
    var v = countJson_dec_dest[i].decName;
    var id=countJson_dec_dest[i].decID;
  $(this).click(function(){
  $.get('find3.php?mode_js=no_find2&decID='+id+'', $(this).serialize(), function(data) {
    $('#category_decision_dest').html(data);
    $('#nav2').remove();
  });     
   return false;
  });   
 
   });


 
}
/************************************************************************************************/
$('form#find_cat_dec_dest fieldset').append('<div id="targetDiv_dec_dest"></div>').find('select#category_dec_dest').change(function(){
$.ajax({
   type: "POST",
    url: "../admin/ajax2.php",
   data: "category_dec_dest="+this.value,
   success: function(msg){
  
$('div#targetDiv_dec_dest').html(' ').append('<p>'+msg+'</p>');
   }


});

 
});


/*************************************************************/   
});//end DCR 
/************************************************************/ 
// $("#loading_dec_dest img").ajaxStart(function(){
//   $(this).show();
// }).ajaxStop(function(){
//   $(this).hide();
// });

 $("#loading img").ajaxStart(function(){
	   $(this).show();
	 }).ajaxStop(function(){
	   $(this).hide();
	 });


 
