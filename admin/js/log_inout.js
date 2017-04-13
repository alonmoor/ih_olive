$(document).ready(function() { 
/*********************************************************************/
//    document.getElementById('form_select').style.display = '';
//    document.getElementById('form_fields').style.display = 'none';
//    document.getElementById('post_id').onchange = show_form;
//    document.getElementById('form_submit').onclick = submit_form;
//    document.getElementById('form_reset').onclick = reset_form;
//    document.getElementById('delete').onclick = submit_warning;

 
$('#form_select').css('dispaly','""');
$('#form_fields').css('dispaly','none');

$('#form_submit').bind('click',function(){
	submit_form();
});
$('#form_reset').bind('click',function(){
	reset_form();
});	
	
$('#delete').bind('click',function(){
	submit_warning();
});


/************************************************************************/	
  //$('.content').css('width','60%');
//   if($.browser.mozilla==true){
//    $('div#my_home_content') .css({"background": "#f0f0f0 url( ../../images/in_out/content-bg1.jpg ) no-repeat scroll top center"});
//  }
	
   
   $('div#middle_div').css('width','95%')
   .css('position','relative')
   .css('height','600px')
   .css('margin-right','25px')
   .css('overflow','auto') ;
 // $('div#my_home_content').css('overflow','scroll');
  
   
   
   
  //$('.listrow').css('color','yellow');
 // $('.listrow1').css('color','white');
  $('.listrow').css('background','blue').css('color','white');
  $('.listrow1').css('background','#af0000').css('color','white');
//} 
/*************************************************************************/	 
  if(!($('#flag_level_usr').val()) && !($('#flag_level_usr').val()=='user') ||  ($('#flag_level_usr').val()=='not_login') )
	  $("#div_content").hide();
	//$('a.my_href_li').css("background",'#b0b0ff url(../../../images/in_out/bullet.jpg) right center no-repeat');	
	$(".my_h5_content").addClass('link'); 
	 $(".my_h5_content").toggle(
			 	 
	  function(){ 
	
	    $(this).addClass('hover');
	     $("#div_content").slideToggle().show();;
	  },  
	  function(){ 
		  
	    $(this).removeClass('hover'); 
	   $("#div_content").slideToggle().show();;
	  } 
	 );   	   

/***************************************************************************/
	  $("#div_content2").hide();
		//$('a.my_href_li').css("background",'#b0b0ff url(../../../images/in_out/bullet.jpg) right center no-repeat');	
		$(".my_h5_content2").addClass('link'); 
		 $(".my_h5_content2").toggle(
				 	 
		  function(){ 
		
		    $(this).addClass('hover');
		     $("#div_content2").slideToggle().show();;
		  },  
		  function(){ 
			  
		    $(this).removeClass('hover'); 
		   $("#div_content2").slideToggle().show();;
		  } 
		 );	 
	 
	 
/************************************************************************/
	 $('.bgchange_login').css('width','40%');
	 turn_red_login();	
	 
	 
	 $('.error').css('width','40%');
	 turn_red_error();	
	 
	 
	 
	 $('.selected').bind('click',function(){
	
	 });
/**************************************************************/
		$("#user_date").datepicker( $.extend({}, {showOn: 'button',
            buttonImage: '../../images/calendar.gif', buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            buttonText: "Open date picker",
            dateFormat: 'yy-mm-dd',
            altField: '#actualDate'}, $.datepicker.regional['he'])); 
 

		
		
		
		$("#post_date").datepicker( $.extend({}, {showOn: 'button',
            buttonImage: '../../images/calendar.gif', buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            buttonText: "Open date picker",
            dateFormat: 'yy-mm-dd',
            
            altField: '#actualDate'}, $.datepicker.regional['he'])); 
		
		
		
		
		
		
		$("#FORUM_DT").datepicker( $.extend({}, {showOn: 'button',
            buttonImage: '../../images/calendar.gif', buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            buttonText: "Open date picker",
            dateFormat: 'yy-mm-dd',
            
            altField: '#actualDate'}, $.datepicker.regional['he'])); 
		
/****************************STRIP*****************************************/
		 $("#theList tr:even").addClass("stripe1");
	        $("#theList tr:odd").addClass("stripe2");

	        $("#theList tr").hover(
	            function() {
	                $(this).toggleClass("highlight");
	            },
	            function() {
	                $(this).toggleClass("highlight");
	            }
	        );		
		
		
/*****************************PDFS**************************************/		
	    
	        $("div#my_pdfs").find("a.my_href_li").css('color','blue').after("<img src='../../images/in_out/small_pdf_icon.gif' align='absbottom' />");
	        $("div#my_favorites_div").find("a.my_href_li").css('color','blue').after("<img src='../../images/in_out/icon-file.gif' align='absbottom' />");
	       
/**************************************************BLOGS***************************************************************/	        
//	        document.getElementById('form_select').style.display = '';
//	        document.getElementById('form_fields').style.display = 'none';
//            document.getElementById('post_id').onchange = show_form;
//	        document.getElementById('form_submit').onclick = submit_form;
//	        document.getElementById('form_reset').onclick = reset_form;
//	        document.getElementById('delete').onclick = submit_warning;
   
/********************************************************************************************************/
	        $('select#post_id').change(function(){
	         
	        	
	       show_form();
	        	
	        
	        	var select = document.getElementById('post_id') ;
		           
		            if (select.options[select.selectedIndex].value == 'new') 
		            {
		                return;
		            }
	        	
	        	
	        	
	        	 var url = 'fetch_admin.php?post_id=' +
                 select.options[select.selectedIndex].value + "&nocache=" +(new Date()).getTime();
                 var data=select.options[select.selectedIndex].value + "&nocache=" +(new Date()).getTime();
	        	 	
                 $.ajax({
               	  dataType:'json',
           		   type: "GET",
           		   url: url,
           	 

           		data:"data="+data,


               	   success: function(json) {
                 
               		   
               		   
               		 document.getElementById('post_title').value =(json.post_title); 
           		  document.getElementById('post_date').value =(json.post_date);
           		document.getElementById('post_text').value   =(json.post_text);
           		
           		tinyMCE.activeEditor.load(document.getElementById('post_text'));

          
	        		   
	        		   }


	        		});

             
               
           

	         
	        });



	        
	        
	        
	        
	        

});//END READY
	