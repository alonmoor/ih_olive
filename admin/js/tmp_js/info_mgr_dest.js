 
var countJson_mgr_dest;

// prepare the form when the DOM is ready 
$(document).ready(function() {
	$('#my_find_ol').css('list-style','none');
	$('#content_page').css('list-style','none');
	
 	$('.my_accordion').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_mgr_dest').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	//removejscssfile("/alon-web/olive_prj/admin/js/find2.js", "js");
	countJson_mgr_dest = data;
    var countList_mgr_dest = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_mgr_dest += '<li><a href="find3.php?mode_js=no_find2&managerID='+this.managerID+'"   class=href_modal3 >'+this.managerName+'</a></li>';
  
  
 });


 $('#targetDiv_mgr_dest').html('<ul id="countList_mgr_dest">'+countList_mgr_dest+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_mgr_dest[i].managerName;
    var id=countJson_mgr_dest[i].managerID;
   
    $(this).click(function(){
    	
    	  $.get('find3.php?mode_js=no_find2&managerID='+id+'', $(this).serialize(), function(data) {
    	    $('#cat_mgr_dest').html(data);
    	    $('#nav2').remove();
    	  });     
    	   return false;
    	  });   
    	 
 
   });

 
 $('#cat_mgr_dest').html(' ');
 
}
/************************************************************************************************/
$('form#find_cat_mgr_dest fieldset').append('<div id="targetDiv_mgr_dest"></div>').find('select#category_mgr_dest').change(function(){
 
	$.ajax({
   type: "POST",
//   url: "../admin/mgr_count.php",
   url: "ajax.php",
   data: "category_mgr_dest="+this.value,
   success: function(msg){
  
$('div#targetDiv_mgr_dest').html(' ').append('<p>'+msg+'</p>');
   }


});
	//$('div#targetDiv_mgr_dest').html(' ');
});


/*************************************************************/   
});//end DCR 
/************************************************************/ 
 $("#loading_mgr_dest img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });




 
