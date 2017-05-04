 
var countJson_dec;

// prepare the form when the DOM is ready 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
	$('#find_cat_dec_dest').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_dec').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	countJson_dec = data;
    var countList_dec_1 = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_dec_1 += '<li><a href="find3.php?decID='+this.decID+'"   class=href_modal3 >'+this.decName+'</a></li>';
  
  
 });


 $('#targetDiv_dec1').html('<ul id="countList_dec">'+countList_dec_1+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_dec[i].decName;
    var id=countJson_dec[i].decID;
   
 
   });

 $('a.href_modal3').css({'background':'#B4D9D7'}).bind('click', function() {
	 
	  	var link=$(this).attr('href') ;
	   	 openmypage3(link); 
		return false;
   });

 
}
/************************************************************************************************/
$('form#find_cat_dec fieldset').append('<div id="targetDiv_dec1"></div>').find('select#category_dec').change(function(){
$.ajax({
   type: "POST",
//   url: "../admin/dec_count.php",
   url: "../admin/ajax2.php",
   data: "category_dec="+this.value,
   success: function(msg){
  
$('div#targetDiv_dec1').html(' ').append('<p>'+msg+'</p>');


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




 