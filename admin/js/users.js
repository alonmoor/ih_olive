 

$(document).ready(function() { 

 turn_red_error();

	
	data_users=new Array();
	var tz = -1 * (new Date()).getTimezoneOffset();
	nocache = '&rnd='+Math.random(); 
	 var url='../admin/';
   
	 new_userList = new Array();

		
	 theme = {
	 newUserFlashColor: '#ffffaa',
	 editUserFlashColor: '#bbffaa',
	 errorFlashColor: '#ffffff'
	 };   
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
			 	 
	
/*************************************************AUTO_SEARCH_SHOW********************************************************/	 
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
/*****************************TOGGLE_HILIGHT*******************************************/	  

	 
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
        fname = $("#fname2"),
        lname = $("#lname2"),
        upass = $("#upass2"),
        user = $("#user2"),
        note = $("#note2"),
		email = $("#email2"),
		phone = $("#phone2"),
		user_date = $("#user_date2"),
		allFields = $([]).add(full_name).add(fname).add(lname).add(upass).add(user).add(note).add(email).add(phone).add(user_date),
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

		
	$("#page_Newuser").dialog({
		autoOpen: false,
		height: 600,
		width: 500,
		modal: true,
		buttons: {
			'צור משתמש חדש': function() {
				var bValid = true;
				allFields.removeClass('ui-state-error');
			    bValid = bValid && checkLength(full_name,"שם מלא",3,16);
				bValid = bValid && checkLength(fname,"שם פרטי",3,16);
				bValid = bValid && checkLength(lname,"שם משפחה",3,16); 
				bValid = bValid && checkLength(phone,"טלפון",3,16);
				bValid = bValid && checkLength(user_date,"תאריך לידה",10,20);
				bValid = bValid && checkLength(user,"שם משתמש",3,16);
				bValid = bValid && checkLength(email,"דואר אלקטרוני",6,80);
				bValid = bValid && checkLength(upass,"סיסמה",5,16);

			
				bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"דוגמה: alon@gmail.com");
				bValid = bValid && checkRegexp(upass,/^([0-9a-zA-Z])+$/,"סיסמה נכשלה מותר רק : a-z 0-9");
				
				if (bValid) {
					 var $this=$(this);   
//		                full_name=  document.getElementById('full_name2').value ;
//		            	fname=  document.getElementById('fname2').value ;
//		            	 lname= document.getElementById('lname2').value ;
 		            	 level= document.getElementById('level2').value;
//		            	 uname=document.getElementById('user2').value ;
//		            	  upass=document.getElementById('upass2').value ;
//		            	 
//		            	  
 		            	 note= document.getElementById('note2').value ;
//		            	 email= document.getElementById('email2').value ;
//		            	  phone_num=document.getElementById('phone2').value ;
//		            	  
 		            	  active=document.getElementById('active2').value ;
//		            	  
//		            	  user_date=document.getElementById('user_date2').value ;
//		            	       
//		                                            
		              $.ajax({
		                 type: "POST",
		                        url: url+'ajax.php?newNormalUser',
		                        dataType: 'json',
		                        data: {
		            	            level: level ,active: active ,user_date: $('#user_date2').val(),
		            	            full_name:$('#full_name2').val() ,fname:$('#fname2').val(),
		      		            	lname:$('#lname2').val(),uname:$('#user2').val(),upass:$('#upass2').val(),
		      		            	email:$('#email2').val(),phone_num:$('#phone2').val(),note:note,tz:tz
		                        },
		                        success: function(json) {
		                        	$('#page_Newuser').dialog('close');
		                        	$(this).dialog('close');
		                        	var item = json.list[0];
                         			new_userList[item.userID] = item;
		                			var my_row=  prepareNormalUserStr(item, url);
		                			$('#theList:first').prepend(my_row);
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
    	
			$('#page_Newuser').dialog('open');
			

				function updateDate(date) {
					  $("#user_date2").val(date);
					  
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
/**********************************************************************/  
  
	$("#loading img").ajaxStart(function(){
		   $(this).show();
		 }).ajaxStop(function(){
		  $(this).hide();
		 });
  
////////////////////////////
});//end ready        /////
////////////////////////// 
 