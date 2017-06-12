 
var countJson_level_dest;

 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
 	$('.my_accordion').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_level_dest').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	//removejscssfile("/alon-web/olive_prj/admin/js/find2.js", "js");
	countJson_level_dest = data;
    var countList_level_dest = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_level_dest += '<li><a href="find3.php?mode_js=no_find2&decID='+this.decID+'"   class=href_modal3 >'+this.decName+'</a></li>';
  
  
 });


 $('#targetDiv_level_dest').html('<ul id="countList_level_dest">'+countList_level_dest+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_level_dest[i].decName;
    var id=countJson_level_dest[i].decID;
   
    $(this).click(function(){
  	  $.get('find3.php?mode_js=no_find2&decID='+id+'', $(this).serialize(), function(data) {
  	    $('#cat_level_dest').html(data);
  	  $('#nav2').remove();
  	  });     
  	   return false;
  	  });   
    
   });

 $('#cat_level_dest').html(' ');
 
}
/***************************************************/
//	   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  //"change_insert_b="  + insertID + "&decID=" + decID,
/************************************************************************************************/
$('form#find_cat_level_dest fieldset').append('<div id="targetDiv_level_dest"></div>').find('select#growth_level_dest').change(function(){
 
$.ajax({
   type: "POST",
   url: "ajax.php",
   data: "growth_level_dest="+this.value,
   success: function(msg){
  
$('div#targetDiv_level_dest').html(' ').append('<p>'+msg+'</p>');
   }


});

 
});


/*************************************************************/   
});//end DCR 
/************************************************************/ 
 $("#loading_level_dest img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });




 
