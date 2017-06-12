 
var countJson_frm_usr;

 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
	$('#find_frm_usr_dest').hide();

   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_frm_usr').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	countJson_frm_usr = data;
    var countList_frm_usr = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_frm_usr += '<li><a href="find3.php?forum_decID='+this.forum_decID+'"   class=href_modal3 >'+this.forum_decName+''+' '+'-מספר חברים'+(this.total)+'</a></li>';
  
  
 });


 $('#targetDiv_frm_usr').html('<ul id="countList_frm_usr">'+countList_frm_usr+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_frm_usr[i].forum_decName;
    var id=countJson_frm_usr[i].forum_decID;
   
 
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
$('form#find_frm_usr fieldset').append('<div id="targetDiv_frm_usr"></div>').find('select#growth_frm_usr_dest').change(function(){

	var num=$('#growth_frm_usr').val();	
	$.ajax({
	   type: "POST",
	 
	   url: "../admin/ajax.php",
	   data: "growth_frm_usr_dest="+this.value+ "&growth_frm_usr=" +num,
	   success: function(msg){
	  
	$('div#targetDiv_frm_usr').html(' ').append('<p>'+msg+'</p>');
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




 
