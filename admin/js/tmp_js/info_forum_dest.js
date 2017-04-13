 
var countJson;

// prepare the form when the DOM is ready 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
 	$('.my_accordion').hide();
   
	$('#popup_frm').bind('click', function() {

		$('#find_cat').hide	();
	});	 
   
	   
   
   var options = { 
         
        beforeSubmit:  showRequest,  // pre-submit callback 
        
        success:  processJson,
        dataType: 'json'
    }; 
 
    // bind form using 'ajaxForm' 
    $('#find_cat_dest').ajaxForm(options); 

		 function showRequest(formData, jqForm) { 
		     
		 var extra = [ { name: 'json', value: '1' }];
		 $.merge( formData, extra)
		
		    return true;  
		} 

 
/********************************************************************************************/
// post-submit callback 
function processJson(data) {
	//removejscssfile("/alon-web/olive_prj/admin/js/find2.js", "js");
	countJson_destfrm = data;
    var countList_destfrm = '';
    var forumList = '';
    // 'data' is the json object returned from the server 
$.each(data, function(i){
  countList_destfrm += '<li><a href="find3.php?mode_js=no_find2&forum_decID='+this.forum_decID+'"  class="maplink" >'+this.forum_decName+'</a></li>';
 });


 $('#targetDiv_dest').html('<ul id="countList_destfrm">'+countList_destfrm+'</ul>').find('a.maplink').each(function(i){
    var index = $('a.maplink').index(this);
    var v = countJson_destfrm[i].forum_decName;
    var id=countJson_destfrm[i].forum_decID;
     
   $(this).click(function(){
		  
    $.get('find3.php?mode_js=no_find2&forum_decID='+id+'', $(this).serialize(), function(data) {
      $('#forum_decision2').html(data);
      $('#nav2').remove();
    });
  
   
     return false;
    });
   
   });

 $('#forum_decision2').html(' ');
 
}
/************************************************************************************************/
$('form#find_cat_dest fieldset').append('<div id="targetDiv_dest"></div>').find('select#category1_dest').change(function(){
	
	 $('#forum_decision2').html(' ');	
$.ajax({
   type: "POST",
   //url: "forum_count.php",
   url: "ajax2.php",
   data: "category1_dest="+this.value,
   success: function(msg){
$('div#targetDiv_dest').html(' ').append('<p>'+msg+'</p>');
  }

 });

//$('#forum_decision1').html(' ');
	
});


 

/*************************************************************/   
});//end DCR 
/************************************************************/ 
 $("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });
 
