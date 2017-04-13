 

$(document).ready(function() { 

 turn_red_error();

	
	data_users=new Array();
	var tz = -1 * (new Date()).getTimezoneOffset();
	nocache = '&rnd='+Math.random(); 
	 var url='../admin/';
   
	 new_userList = new Array();


/******************************DATE_PICKER***********************************************/
  
	 
  $("#user_date2").datepicker( $.extend({}, {showOn: 'button',
       buttonImage: '../images/calendar.gif', buttonImageOnly: true,
       changeMonth: true,
       changeYear: true,
       showButtonPanel: true,
       buttonText: "Open date picker",
       dateFormat: 'yy-mm-dd', 
        altField: '#actualDate'
       

       }, $.datepicker.regional['he'])); 			
	
   
   
   $("#user_date1").datepicker( $.extend({}, {showOn: 'button',
       buttonImage: '../images/calendar.gif', buttonImageOnly: true,
       changeMonth: true,
       changeYear: true,
       showButtonPanel: true,
       buttonText: "Open date picker",
       dateFormat: 'yy-mm-dd', 
        altField: '#actualDate'
       

       }, $.datepicker.regional['he'])); 	
   
   
   
   

	
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
	 
	 
	 
 
 editUser4(userID ,url); 

});//end resultsearch
 /************************************************************************/	  	  

	 
  	  var resizeOpts = {
		      autoHide: true,
			  minHeight: 170,
			  minWidth: 400
		    };
	
	$('#page_useredit').resizable( resizeOpts );  
  	$('#page_useredit').css({'margin-right': '120px'}).draggable();

  	
  	
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
  
  
/***************************ADD_USER************************************************************************/  
  $(function() { 
	  allFields=new Array;
        var full_name = $("#full_name2"),
        frmName = $("#new_frm_name"),
        note = $("#note2"),
        start_date = $("#user_date2"),
        end_date = $("#user_date1"),
		allFields = $([]).add(full_name).add(frmName).add(start_date).add(end_date),
		tips = $(".validateTips");

        
        
        function updateTips(t) {
			tips
				.text(t)
				.addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');
			setTimeout(function() {
				tips.removeClass('ui-state-highlight', 1500);
			}, 500).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
		}

		function checkLength(o,n,min,max) {

			if (  o.val().length > max || o.val().length < min ) {
				o.addClass('ui-state-error');
				updateTips("אורך של שדה: " + n + " -חייב להיות בין "+min+" לבין "+max+ " תווים.");
				return false;
			} else {
				return true;
			}

		}

		function checkRegexp(o,regexp,n) {

			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass('ui-state-error');
				updateTips(n);
				return false;
			} else {
				return true;
			}

		}

		
	$("#page_PastNewuser").dialog({
		autoOpen: false,
		height: 600,
		width: 500,
		modal: true,
		buttons: {
			'צור משתמש חדש': function() {
				var bValid = true;
				allFields.removeClass('ui-state-error');
				bValid = bValid && checkRegexp(full_name,/^([0-9])+$/,"חייב להזין שם משתמש : ");
				bValid = bValid && checkRegexp(frmName,/^([0-9])+$/,"חייב להזין שם פורום : ");
	 			bValid = bValid && checkLength(start_date,"תאריך התחלה",10,20);
	 			bValid = bValid && checkLength(end_date,"תאריך סיום",10,20);
	 			
				if (bValid) {
					 var $this=$(this);   
		                
 		            	  level= document.getElementById('level2').value;
 		            	  note= document.getElementById('note2').value ;
 		            	  active=document.getElementById('active2').value ;
		            	
  $.ajax({
     type: "POST",
            url: url+'ajax2.php?submit_PastNormalUser',
            dataType: 'json',
            data: {
	            level: level ,active: active ,start_date: $('#user_date2').val(),end_date: $('#user_date1').val(),
	            userID:$('#full_name2').val() ,forum_decID:$('#new_frm_name').val(),note:note,tz:tz
            	
            },
            success: function(json) {
            	
           if(json.type == 'success' &&  !(json.type ==undefined)){   	
            	$('#page_PastNewuser').dialog('close');
            	$(this).dialog('close');
            	var item = json.list[0];
     			new_userList[item.userID] = item;
    		    var my_row= preparePastNormalUserStr(item, url);	
    			$('#theList:first').prepend(my_row);
           }else{
//---------------------------------------------------------------------------------------------------------------------


	 
		var i=0;	 
			 var userID=json.userID; 
			 var countList='';
			 $.each(json  , function(i,item){ 			
					var  messageError= i;
				  
					 $("#forum-message").html(' ').fadeIn();
	 
		 if(messageError!='userID')
	 countList +='<li class="error">'+ item +'</li>';
			       
			 });	 
	 
	 $('#my_error_message').html('<ul id="countList_check">'+countList+'</ul>').css({'margin-right': '90px'});
	 $('#my_error_message').append($('<p ID="bgchange"   ><b style="color:blue;">הודעת שגיאה!!!!!</b></p>\n' ));

	 $('<button id="my_error_button" class="green90x24"  type="button"  onClick="delClose()"  value="לחץ לאישור קבלת הבעייה" >  לחץ לאישור </button>').appendTo($('#my_error_message'));
	 $('#my_error_message').show();
	 turn_red(); 		
        	    

//---------------------------------------------------------------------------------------------------------------------			      		            

        	   
        	   
           }	
         }
       });
 $(this).dialog('close');
	}
},
Cancel: function() {
	$(this).dialog('close');
	}
},
close: function() {
	$("#dialog").dialog("destroy");
	allFields.val('').removeClass('ui-state-error');
	}
});
	
	
	
	$('#btnAddUser').bind('click',function() {
    	
			$('#page_PastNewuser').dialog('open');
			

				function updateDate(date) {
					 $("#user_date2").val(date);
					 				  
			       }
					
				
				function updateDate1(date) {
					 $("#user_date1").val(date);
					 				  
			       }
					//datepicker config
					var pickerOpts = {
					  beforeShow: function() {
					    $("#ui-datepicker-div").css("zIndex", 2006).next().css("zIndex", 1006);
					  },
						 dateFormat:'yy-mm-dd' ,
						 changeMonth: true,
		                   changeYear: true,
		                   showButtonPanel: true,
		                   buttonText: "Open date picker",
		                   altField: '#actualDate'
	 
					};
		       				
					$("#user_date2").focus(function() {
					   $(this).datepicker("dialog", null, updateDate, pickerOpts);
					     return false;
				  		});
					
					
					$("#user_date1").focus(function() {
						   $(this).datepicker("dialog", null, updateDate1, pickerOpts);
						     return false;
					  		});
					 $("#user_date2").datepicker({  firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
					 $("#user_date1").datepicker({  firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});

   });//end btnAdd
	
  });//end $function	
  
/**********************************************************************/	
//	$('#edit_usr').bind('click',function(){
//		 $.ajax({
//			   type: "GET",
//			   url: "../admin/print_users.php",
//		 
//			  // data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,   
//	
//	
//	success: function(msg) {
//		  
//	   
//		$('div#wrapper').html(' ').append('<p>'+msg+'</p>');
//		$('#my_title link').remove();
//		//$('#page_useredit').hide();
//	   
//	 }
//	});
// 		 return false;
////		 alert("aaaaaaaa");
//});	
  
  
  
  
/**********************TOOGLE************************************************/
   
  $('.page_Pastuseredit h4').click(function() {//for toggle
	    $(this).parent().find('.contentPast_2').slideToggle();
	  });

	
	$(".myPast_title").css({'cursor':'pointer'}).addClass('link'); //for chang plus and minus
	  $(".myPast_title").toggle( 
	    function(){ 
	    
	       
	      $(this).addClass('hover');
//	       $("#contentPast_2").slideToggle();
	    },  
	    function(){ 
	      $(this).removeClass('hover'); 
	//       $("#contentPast_2").slideToggle();
	    } 
	  );  

$('#edit_Past_usr').bind('click',function(){

    $("#page_Pastuseredit").hide();



 });

/*****************************************************************************/

$("#loading img").ajaxStart(function(){
	   $(this).show();
	 }).ajaxStop(function(){
	  $(this).hide();
	 });
  
////////////////////////////
});//end ready        /////
////////////////////////// 
