 
var countJson_precent;

// prepare the form when the DOM is ready 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
	$('#find_cat_precent_dest').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_precent').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	countJson_precent = data;
    var countList_precent = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_precent += '<li><a href="find3.php?decID='+this.decID+'"   class=href_modal3 >'+this.decName+'</a></li>';
  
  
 });


 $('#targetDiv_precent').html('<ul id="countList_precent">'+countList_precent+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_precent[i].decName;
    var id=countJson_precent[i].decID;
   
 
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
$('form#find_cat_precent fieldset').append('<div id="targetDiv_precent"></div>').find('select#growth_dest').change(function(){
var precent=$('#growth').val();	
$.ajax({
   type: "POST",
//   url: "../admin/dec_count.php",
   url: "../admin/ajax2.php",
   data: "growth_dest="+this.value+ "&growth=" +precent,
   success: function(msg){
  
$('div#targetDiv_precent').html(' ').append('<p>'+msg+'</p>');
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




 
