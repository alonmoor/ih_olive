 
var countJson_frm_usr_dest;

 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
 	$('.my_accordion').hide();
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_frm_usr_dest').ajaxForm(options); 

 function showRequest(formData, jqForm) { 
     
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)

    return true;  
} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	//removejscssfile("/alon-web/olive_prj/admin/js/find2.js", "js");
	countJson_frm_usr_dest = data;
    var countList_frm_usr_dest = '';
    
    // 'data' is the json object returned from the server 
   $.each(data, function(i){

 countList_frm_usr_dest += '<li><a href="find3.php?mode_js=no_find2&forum_decID='+this.forum_decID+'"   class=href_modal3 >'+this.forum_decName+''+' '+'-מספר חברים'+(this.total)+'</a></li>';
  
  
 });


 $('#targetDiv_frm_usr_dest').html('<ul id="countList_frm_usr_dest">'+countList_frm_usr_dest+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_frm_usr_dest[i].forum_decName;
    var id=countJson_frm_usr_dest[i].forum_decID;
   
    $(this).click(function(){
  	  $.get('find3.php?mode_js=no_find2&forum_decID='+id+'', $(this).serialize(), function(data) {
  	    $('#my_user_forum').html(data);
  	  $('#nav2').remove();
  	  });     
  	   return false;
  	  });   
 
   });

 
 $('#my_user_forum').html(' ');
 
}
/***************************************************/
//	   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  //"change_insert_b="  + insertID + "&decID=" + decID,
/************************************************************************************************/
$('form#find_frm_usr_dest fieldset').append('<div id="targetDiv_frm_usr_dest"></div>').find('select#growth_frm_usr_dest_num').change(function(){

	var num=$('#growth_frm_usr_src').val();	
	$.ajax({
	   type: "POST",
	 
	   url: "../admin/ajax2.php",
	   data: "growth_frm_usr_dest_num="+this.value+ "&growth_frm_usr_src=" +num,
	   success: function(msg){
	  
	$('div#targetDiv_frm_usr_dest').html(' ').append('<p>'+msg+'</p>');
	   }


	});

 
});


/*************************************************************/   
});//end DCR 
/************************************************************/ 
 $("#loading_frm_usr_dest img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });




 
