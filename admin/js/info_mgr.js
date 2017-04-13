 
var countJson;

// prepare the form when the DOM is ready 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
	$('#find_cat_mgr_dest').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_mgr').ajaxForm(options); 

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
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList += '<li><a href="find3.php?managerID='+this.managerID+'"   class=href_modal3 >'+this.managerName+'</a></li>';
  
  
 });


 $('#targetDiv_mgr').html('<ul id="countList">'+countList+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson[i].managerName;
    var id=countJson[i].managerID;
   
 
   });

 $('a.href_modal3').css({'background':'#B4D9D7'}).bind('click', function() {
	 
	  	var link=$(this).attr('href') ;
	   	 openmypage3(link); 
		return false;
   });

 
}
/************************************************************************************************/
$('form#find_cat_mgr fieldset').append('<div id="targetDiv_mgr"></div>').find('select#category_mgr').change(function(){
$.ajax({
   type: "POST",
//   url: "../admin/mgr_count.php",
   url: "ajax2.php",
   data: "category_mgr="+this.value,
   success: function(msg){
  
$('div#targetDiv_mgr').html(' ').append('<p>'+msg+'</p>');
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




 
