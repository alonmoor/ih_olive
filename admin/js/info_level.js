 
var countJson_level;

 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
	$('#find_cat_level_dest').hide();

   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_level').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	countJson_level = data;
    var countList_level = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_level += '<li><a href="find3.php?decID='+this.decID+'"   class=href_modal3 >'+this.decName+'</a></li>';
  
  
 });


 $('#targetDiv_level_dest').html('<ul id="countList_level">'+countList_level+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_level[i].decName;
    var id=countJson_level[i].decID;
  });

 $('a.href_modal3').css({'background':'#B4D9D7'}).bind('click', function() {
	 
	  	var link=$(this).attr('href') ;
	   	 openmypage3(link); 
		return false;
   });

 
}
/***************************************************/
//	   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  //"change_insert_b="  + insertID + "&decID=" + decID,
/************************************************************************************************/
$('form#find_cat_level fieldset').append('<div id="targetDiv_level_dest"></div>').find('select#growth_level').change(function(){

$.ajax({
   type: "POST",
   url: "ajax.php",
   data: "growth_level="+this.value,
   success: function(msg){
  
$('div#targetDiv_level_dest').html(' ').append('<p>'+msg+'</p>');
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




 
