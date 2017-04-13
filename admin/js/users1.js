 

$(document).ready(function() { 

 
//	$('<input id="my_error_button"  type="button" value="לחץ לאישור קבלת הבעייה" />').appendTo($('#my_error_message'));	
	//$('input[type="submit"]').hide();	

	//$('#my_error_message').hide();
	
	data_users=new Array();
	var tz = -1 * (new Date()).getTimezoneOffset();
	nocache = '&rnd='+Math.random(); 
	 var url='../admin/';
   
	 new_userList = new Array();



   $("#user_date2").datepicker( $.extend({}, {showOn: 'button',
       buttonImage: '../images/calendar.gif', buttonImageOnly: true,
       changeMonth: true,
       changeYear: true,
       showButtonPanel: true,
       buttonText: "Open date picker",
       dateFormat: 'yy-mm-dd', 
        altField: '#actualDate'
       

       }, $.datepicker.regional['he'])); 			
			 	 
	 
	 
	$("#loading img").ajaxStart(function(){
		   $(this).show();
		 }).ajaxStop(function(){
		  $(this).hide();
		 });
	
/****************************AUTO*********************************************/
	
theme = {
newUserFlashColor: '#ffffaa',
editUserFlashColor: '#bbffaa',
errorFlashColor: '#ffffff'
};   
/*************************************************SEARCH_SHOW********************************************************/	 
$scriptAr=scriptAr;

$('#search-text').autocomplete(scriptAr,{
    autoFill: true,
    selectFirst: true,
    width: '240px'
        
  }).result(function(event, item) {
	 
	  var name=item.toString();
	 
if($.browser.mozilla==true){ 	  
 	 var idx=scriptAr.indexOf( (name))+1 ;
}else{
	 var idx=$.inArray($('#search-text').val(), $scriptAr)+1;
}	  
	if(  checkstringformat( $('#search-text').val())){ 
		 var userID=$('#search-text').val();
 	 } else{ 
		 var userID=scriptAr[idx];
	 } 
	 
/************************************************************************/
	  $.get('../admin/find3.php?userID='+userID+'', $(this).serialize(), function(data) {
	  
	  	    	 		  				$('#user_detail') 
	  	    	 		  					.addClass('user_detail').css({'width' : '79%'})
	  	    	 		  								.css({'height': '400px'})
	  	    	 		  								.css({'margin-right': '60px'})
	  	    	 		  								.css({'padding': '5px'})
	  	    	 		  								.css({'overflow':'hidden'})
	  	    	 		  								.css({'overflow':'scroll'})
	  	    	 		  								.css({'background':'#2CE921'})
	  	    	 		  								.css({'border':'3px solid #666'});
	  	    	 		  					
	  	    	 		  					
	  	    	 		  					         $('#user_detail').html(data) ;
	  	    	 		  							     
	  	    	 		  							    						
	  	    	 		  					            return false;    
	  	    	 		  							   
	  	    	 	
 });//end get	  
/************************************************************************/	  
});//end resultsearch
	  

	 
 
/*************************************************SEARCH_EDIT********************************************************/
  
 $('#search_editUser').autocomplete(scriptAr_edit,{
    autoFill: true,
    selectFirst: true,
    width: '240px'
        
  }).result(function(event, item) {
	  var name_edit=item.toString();
	 
	  
  if(!($.browser.msie==true)){ 	  
	 var idx_edit=scriptAr_edit.indexOf(name_edit)+1 ; 
	  }else{
		   
		  var idx_edit=$.inArray($('#search_editUser').val(), $scriptAr)+1;
	  }
	 if(  checkstringformat( $('#search_editUser').val())){ 
		 var userID=$('#search_editUser').val();
	 } else{ 
		 var userID=scriptAr_edit[idx_edit];
	 } 
	 
	 
	 
/************************************************************************/
 editUser4(userID ,url); 
/************************************************************************/	  
});//end resultsearch
	  

	 
  

/**********************************************************************************************************************/	
	  var resizeOpts = {
		      autoHide: true,
			  minHeight: 170,
			  minWidth: 400
		    };
	
	$('#page_useredit').resizable( resizeOpts );  
  	$('#page_useredit').css({'margin-right': '120px'}).draggable();
/*********************************************************************/
 
  		$('#btnAddUser').css({'position':'relative'}).css({'background':'#8EF6F8'}).css({'top':'20px'});
/*********************************************************************/	

        $("#theList tr").hover(
            function() {
                $(this).toggleClass("highlight");
            },
            function() {
                $(this).toggleClass("highlight");
            }
         );



//**************************************************************************/

     //   $('.page_useredit .content_2').hide();
          
         

        $('.page_useredit h4').click(function() {
            $(this).parent().find('.content_2').slideToggle();
          });


        $(".my_title").addClass('link'); 
          $(".my_title").toggle( 
            function(){ 
            
               
              $(this).addClass('hover');
             
            },  
            function(){ 
              $(this).removeClass('hover'); 
              
            } 
          );  
/***********************************************************/
  
        $('.page_useredit2 .content_2').hide();
          
         

        $('.page_useredit2 h4').click(function() {
            $(this).parent().find('.content_2').slideToggle();
          });


        $(".my_title").addClass('link'); 
          $(".my_title").toggle( 
            function(){ 
            
               
              $(this).addClass('hover');
             
            },  
            function(){ 
              $(this).removeClass('hover'); 
              
            } 
          );  
  
/*************************************************************/  

  		$('#btnAddUser').bind('click',function() {
  			
  	     submit_new_user(url);

  	   });//end btnAdd
/**********************************************************************/
});//end ready
/**************************************************************/
 