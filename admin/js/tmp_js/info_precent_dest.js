 
var countJson_precent_dest;

// prepare the form when the DOM is ready 
$(document).ready(function() {
	$('#my_find_ol').css('list-style','none');	
 	$('.my_accordion').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_precent_dest').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	//removejscssfile("/alon-web/olive_prj/admin/js/find2.js", "js");
	countJson_precent_dest = data;
    var countList_precent_dest = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_precent_dest += '<li><a href="find3.php?mode_js=no_find2&decID='+this.decID+'"   class=href_modal3 >'+this.decName+'</a></li>';
  
  
 });


 $('#targetDiv_precent_dest').html('<ul id="countList_precent_dest">'+countList_precent_dest+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_precent_dest[i].decName;
    var id=countJson_precent_dest[i].decID;
   
    $(this).click(function(){
    	  $.get('find3.php?mode_js=no_find2&decID='+id+'', $(this).serialize(), function(data) {
    	    $('#category_precent_dest').html(data);
    	    $('#nav2').remove();
    	  });     
    	   return false;
    	  });   
     
    
   });

 $('#category_precent_dest').html(' ');
 
}
/***************************************************/
//	   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  //"change_insert_b="  + insertID + "&decID=" + decID,
/************************************************************************************************/
$('form#find_cat_precent_dest fieldset').append('<div id="targetDiv_precent_dest"></div>').find('select#growth_precent_dest').change(function(){
var precent=$('#growth_precent').val();	
$.ajax({
   type: "POST",
//   url: "../admin/dec_count.php",
   url: "../admin/ajax.php",
   data: "growth_precent_dest="+this.value+ "&growth_precent=" +precent,
   success: function(msg){
  
$('div#targetDiv_precent_dest').html(' ').append('<p>'+msg+'</p>');
   }


});

 
});

 
/*************************************************************/   
});//end DCR 
/************************************************************/ 
// $("#loading img").ajaxStart(function(){
//   $(this).show();
// }).ajaxStop(function(){
//   $(this).hide();
// });




 
