 

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
//$('<h4 class="my_dialog"  style="height:15px;"></h4>').appendTo($('body'));
 //$('<div id="my_dialogContent" >').appendTo($('body'));
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
			tips.text(t)
			
			 if($.browser.msie==true){
					
					tips.text(t).addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');


				}else{
					tips.text(t).addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');
					setTimeout(function() {
						tips.removeClass('ui-state-highlight', 1500);
					}, 500).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
				}
				
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

		
var $dialog=$("#page_DecNewUser").dialog({
		autoOpen: false,
		height: 600,
		width:500,
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
 		            	 decID=document.getElementById('Request_Tracking_Number_dec').value ;
 		            	 
 		            	// $('#Request_Tracking_Number_dec').val
  $.ajax({
     type: "POST",
            url: url+'ajax2.php?submit_DecUser',
            dataType: 'json',
            data: {
	            decID:decID,level: level ,active: active ,start_date: $('#user_date2').val(),end_date: $('#user_date1').val(),
	            userID:$('#full_name2').val() ,forum_decID:$('#new_frm_name').val(),note:note,tz:tz
            	
            },
            success: function(json) {
            	
           if(json.type == 'success' &&  !(json.type ==undefined)){   	
            	$('#page_DecNewUser').dialog('close');
            	$(this).dialog('close');
            	var item = json.list[0];
     			new_userList[item.userID] = item;
    		    var my_row= prepareDecUserStr(item, url);	
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
  $(".my_title_DecNewUsr").remove();
 $(this).dialog('close');
	}
},
Cancel: function() {
	$(".my_title_DecNewUsr").remove();
	$(this).dialog('close');
	}
},

close: function() {
	$(".my_title_DecNewUsr").remove();
	$("#dialog").dialog("destroy");
	allFields.val('').removeClass('ui-state-error');
	}
});
	
	
	
	$('#btnAddUser').bind('click',function() {
		//$('#detailsFirst_fieldset').remove();
		//$('#decision_usr_name').val(' ');
		$('#conn_txtFirst').val(' ');
		
		$('#page_DecNewUser').dialog('open');

		
		
		
		
		  
$('<h4 class="my_title_DecNewUsr"  style="height:15px;float:left;width:15px;cursor:pointer;overflow:auto;"></h4>')
		 .addClass('link').insertAfter($("#ui-dialog-title-page_DecNewUser") );	




$('#ui-dialog-title-page_DecNewUser h4').click(function() { 
    $(this).parent().find($(dialog)).slideToggle();
  });

 

$(".my_title_DecNewUsr").css({'cursor':'pointer'}).addClass('link'); //for chang plus and minus
  $(".my_title_DecNewUsr").toggle( 
    function(){ 
      $(this).addClass('hover');
      $dialog.slideToggle();
     // $('.ui-dialog-buttonpane').css('overflow','auto');
    },  
    function(){ 
     $(this).removeClass('hover');
     $dialog.slideToggle();
     //$('.ui-dialog-buttonpane').css('overflow','auto');
    } 
  );  
  


			
				function updateDate(date) {
					 $("#user_date2").val(date);
					 				  
			       }
					
				
				function updateDate1(date) {
					 $("#user_date1").val(date);
					 				  
			       }
					//datepicker config
					var pickerOpts = {
					  beforeShow: function() {
					    $("#ui-datepicker-div").css("zIndex", 10000).next().css("zIndex", 10000);
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
  	  
$('#edit_Dec_usr').bind('click',function(){
    $("#page_Decuseredit").hide();
 });



////////////////////////////////////////////CHANGE_CONN_FIRST_BY_SEARCH-POPUP////////////////////////////////////////////////////////
$('#my_conn_dec').bind('click',function(){ 

	 if( ($.browser.msie==true )){	  
	  $('#conn_txtFirst').remove();
	  $('#conn_submitFirst').remove();
	  
	  $('#decision_usrFrm_name').append($("<tr><td class='myformtd'>\n"+ 	 
	  "<input type='text' name='conn_txtFirst' id='conn_txtFirst'  class='mycontrol'  colspan='1'  />\n" + 
	  "<input type='button' name='conn_submitFirst' id='conn_submitFirst'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש החלטה בחלון'  />\n" +
	   "</td></tr>\n" +
	  "<div id='targetDiv_changeFirst'></div>\n"   
	   )).css({'border' : 'solid #dddddd 5px'});
	 }else {  
	  	  	
 		  $('#decision_usrFrm_name').append($("<fieldset id='detailsFirst_fieldset'><legend>חפש החלטות</legend>\n"+ 	 
 				  "<form id='detailsFirst'>"+
 				 "<input type='text' name='conn_txtFirst' id='conn_txtFirst'  class='mycontrol'  colspan='1'  />\n" + 
 				  "<input type='button' name='conn_submitFirst' id='conn_submitFirst'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש החלטה בחלון'  />\n" +
 				   "</form></fieldset>\n" +
 				  "<div id='targetDiv_searchFirst' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n"  )).css({'border' : 'solid #dddddd 5px'}); 
 	  } 		 
	 
	 
	 
	   
		 $('input#conn_submitFirst').bind('click', function() {	
	
			 $('.ui-dialog').css('z-index','1');
			 $('.conn_txtFirst').css('z-index','10000');
			 
	var txt=$('#conn_txtFirst').attr('value');
	 
	if( ($.browser.msie==true )){	  
	    var txt = $('#conn_txtFirst').serialize();
	  }else {  
		  var  txt=$('#conn_txtFirst').attr('value');	
	  }	 
		
	    var  queryString = '?find_decUser=' + txt ;
	
	
		var link= '../admin/find3.php'+queryString  ;
 
	  	openmypage3(link);
//	  	$("#page_Decuser").css('height','100px');
//	  	$("#page_Decuser").dialog({ height: 50 });
	  	$(".ui-widget-overlay").css({ zIndex: 1 });
	  	//$('#page_Decuser').css('z-index','1');
	   return false;

		 });//end conn_submit
		 
}); 


$('#my_conn_dec').bind("click", (function() {
    $('#my_conn_dec').unbind("click");
}));	


//$('</div>').appendTo($('body')); 


/*****************************************************************************/

$('#btnAddUser1').bind('click',function() {
	
	
	//$('#diagMenu').dialog('open');
});		




var $dialog = $("<div>").html("I'm busy.").dialog({autoOpen: false,
    // other options
    // ...
    title: 'Status'});

// Initially have the table hidden.
$("#SECTION_1").hide();

// Setup the toggle for the show and hide
$('#SECTION_1_collapse').toggle(function(){

// Show the "loading..." dialog box
$dialog.dialog("open"); 

// Show the table... this might take a while
$("#SECTION_1").show();

// Close the dialog box after a while... experiment w the timing
//setTimeout(function() { $dialog.dialog("close"); }, 2500);

}, function() {

// No need for fancy dialog boxes when we hide the big table
$("#SECTION_1").hide();

});



/************************************************************/
$("#loading img").ajaxStart(function(){
	   $(this).show();
	 }).ajaxStop(function(){
	  $(this).hide();
	 });
  
////////////////////////////
});//end ready        /////
////////////////////////// 
