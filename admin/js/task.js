
//$(document).ready(function(){
	var percent='';
	var decID =document.getElementById('decID').value; 
 	var forum_decID = document.getElementById('forum_decID').value; 
    

 
/**************************************TOGGLE*****************************************************/ 
  
 
 
 
$(".my_title_"+decID+forum_decID).css('cursor','pointer').addClass('link'); 
	  $(".my_title_"+decID+forum_decID).toggle( 
	    function(){ 
	    
	       
	      $(this).addClass('hover');
	      $("#tasklist"+decID+forum_decID).slideToggle();
	    },  
	    function(){ 
	      $(this).removeClass('hover'); 
	      $("#tasklist"+decID+forum_decID).slideToggle();
	    } 
	  );  
 
/**************************************TOGGLE_TASKS*****************************************************/ 
	  
	  
	  
	  $(".my_task_title_"+decID+forum_decID).css('cursor','pointer').addClass('link'); 
	  	  $(".my_task_title_"+decID+forum_decID).toggle( 
	  	    function(){ 
	  	    
	  	       
	  	      $(this).addClass('hover');
	  	      $("#tasklist"+decID+forum_decID).slideToggle();
	  	    },  
	  	    function(){ 
	  	      $(this).removeClass('hover'); 
	  	      $("#tasklist"+decID+forum_decID).slideToggle();
	  	    } 
	  	  );  
	   

/******************************TOGGLE_TASK_EH_TABLE*******************************************/


  $(".my_dec_eh_title_table_"+decID+forum_decID ).addClass('link'); 
  $(".my_dec_eh_title_table_"+decID+forum_decID).toggle(

  function(){ 


  $(this).addClass('hover');
  $("#task_fieldset_"+forum_decID).slideToggle('slow');

  },  
  function(){ 
  $(this).removeClass('hover'); 
  $("#task_fieldset_"+forum_decID).slideToggle('slow');
  } 
  );    
	   
/********************************************************************************************/ 

// $("#taskviewcontainer"+decID+forum_decID).bind('click',function(){
//	  //$("#tasklist"+decID+forum_decID).slideToggle();
//	  $(this).parent().find("div#taskcontainer"+decID+forum_decID).slideToggle('slow');		
//	 return false;
//	 });








// $('#page_taskedit_multi'+decID+forum_decID).draggable();
//$("#view_multi"+decID+forum_decID).bind("click",function(){
//		 
//		 $('#multiview'+decID+forum_decID).hide();
//		 return false;
//	 });
/******************************PROGRESS_BAR********************************************************/

var progressOpts = {
          change: function(e, ui) {
             
    	
  
          var val =$(this).progressbar("option", "value");
        
            if(val <=100) {
              //show new value
              ($("#value"+decID+forum_decID).length === 0) ? $("<span>").text(val + "%").attr("id", "value"+decID+forum_decID)
               .css({ float: "right", marginTop: -28, marginRight:10 })
               .appendTo("#progress"+decID+forum_decID) : $("#value"+decID+forum_decID).text(val + "%");
               
            } else    {
               $("#increase"+decID+forum_decID).attr("disabled", "disabled");
            }
        	
          }
        };
    
         $("#progress"+decID+forum_decID).progressbar(progressOpts);



/****************************************************************************************/

         $("#tabs"+decID+forum_decID).tabs({
      		ajaxOptions: {
      			eror: function(xhr, status, index, anchor) {
      				$(anchor.hash).html("Failed to load this tab!");
      			}
      		}
      	});
//
//     	$('#tabs'+decID+forum_decID+' div.ui-tabs-panel').height(function() {
//     		return $('#tabs-container'+decID+forum_decID).height()
//     			    - $('#tabs-container'+decID+forum_decID+' #tabs'+decID+forum_decID+' ul.ui-tabs-nav').outerHeight(true)
//     			   - ($('#tabs'+decID+forum_decID).outerHeight(true) - $('#tabs'+decID+forum_decID).height())
//                                 // visible is important here, sine height of an invisible panel is 0
//     			   - ($('#tabs'+decID+forum_decID+' div.ui-tabs-panel:visible').outerHeight(true)  
//     				  - $('#tabs'+decID+forum_decID+' div.ui-tabs-panel:visible').height());
//     	});
      
      	
      	
/***********************************HIDE_MENU*****************************************************/
 $('#taskview'+decID+forum_decID).bind("mouseleave", getout);
 $('#sortform'+decID+forum_decID).bind("mouseleave", getout);
 $('#multiview'+decID+forum_decID).bind("mouseleave", getout);
 

function getout(evt) {
 $('#taskview'+decID+forum_decID).hide();
 $('#sortform'+decID+forum_decID).hide();
 $('#multiview'+decID+forum_decID).hide();
}

/****************************************************************************************/ 	
 $('#tagcloud'+decID+forum_decID).draggable();	
 
 

/*******************************************************************************************/ 


$('div#tagcloudcancel'+decID+forum_decID+'').click(function(){
	 $('#tagcloud'+decID+forum_decID).hide();

 });
 
/*******************************************HOVER******************************************************/  
 
$('#tagcloudcontent'+decID+forum_decID+':btnstr').css("border", "1px solid red") 	
.hover(function() {

$(this).addClass('containerHover');


}, function() {

$(this).removeClass('containerHover');


});
/****************************************************************************************/
 $('#tagcloudbtn'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});

/******************************************************************************************/	
 $('#tagcloudcancel'+decID+forum_decID+':btnstr').css("border", "2px solid #cccccc") 	
.hover(function() {

$(this).addClass('containerHover');


}, function() {

$(this).removeClass('containerHover');


});
/****************************************************************************************/
	$('#taskviewcontainer'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover')	;		 
 
    		   }, function() {

 $(this).removeClass('containerHover');


});

/****************************************************************************************/
	
	
$('#multicloudbtn'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") //multi action	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});


/****************************************************************************************/
$('#sort'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});
/****************************************************************************************/
$('#priopopup'+decID+forum_decID+':btnstr').css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});
/****************************************************************************************/  
	$('#page_taskedit'+decID+forum_decID).hover(function() {

 	 $(this).addClass('containerHover');


 	}, function() {

 	 $(this).removeClass('containerHover');


 	}); 	

/****************************************************************************************/ 	
 
 $('#my_button_win_task'+decID+forum_decID).css({'background':'#B4D9D7'}).bind('click', function() {

		  	var link= '../admin/find3.php?&forum_decID='+forum_decID ;
		   	openmypage3(link); 
		  
		    return false;
			 });
/***************************************************************************************************/	  
 $('#my_diary_win'+decID+forum_decID).css({'background':'#B4D9D7'}).bind('click', function() {
		  	var link= '../admin/full_calendar/insert_ajx4.php‬' ;
		   	openmypage3(link); 
		  
		    return false;
			 });
/*************************************************************************************************/ 

 $('#delete'+decID+forum_decID).bind('click',function(){
	 
	 $('#delete'+decID+forum_decID).unbind(); 
	 
 });
/***************************************************************************************************/ 
 //	 $("#tabs"+decID+forum_decID).tabs({ select: tabSelected <?php echo $tabDisabled; ?>});
 	
 
//   $("#tabs"+decID+forum_decID).tabs({
//		ajaxOptions: {
//			eror: function(xhr, status, index, anchor) {
//				$(anchor.hash).html("Failed to load this tab!");
//			}
//		}
//	});
/************************************************************************************************/ 	
 	
 	$("#tasklist"+decID+forum_decID).sortable({cancel:'span,input,a,textarea', delay: 100, update:orderChanged, start:sortStart});
 	$("#tasklist"+decID+forum_decID).bind("click", tasklistClick2);
 	$("#edittags"+decID+forum_decID).autocomplete('../admin/ajax2.php?suggestTags', {scroll: false, multiple: true, selectFirst:false, max:8});
  	$("#priopopup"+decID+forum_decID).mouseleave(function(){$(this).hide();});

	 
 	 

  
	 
  loadTasks2('../admin/',forum_decID,decID);
 


/***************************************************************************************************************/
                        
              	           	$('#duedate'+decID+forum_decID).datepicker( $.extend({}, {showOn: 'button',
              		                               buttonImage:'../images/calendar.gif', buttonImageOnly: true,
              		                               changeMonth: true,
              				                       changeYear: true,
              				                       showButtonPanel: true,
              				                       buttonText: "Open date picker",
              				                       dateFormat: 'yy-mm-dd',
              				                       altField: '#actualDate'}, $.datepicker.regional['he'])); 
                                
/****************************************************************************************************************/			

	$("#page_taskedit"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 


/**********************************************************************************/
	//var tabs = $("#page_taskedit"+decID+forum_decID).tabs();
	
    //define config object for resizeable
    var resizeOpts = {
      autoHide: true,
	  minHeight: 170,
	  minWidth: 400
    };
			
  
   $("#page_taskedit"+decID+forum_decID).resizable(  ); 
  





/*********************************************************************************/

	$("#page_taskedit_multi"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit_multi"+decID+forum_decID).width(), minHeight:$("#page_taskedit_multi"+decID+forum_decID).height(), start:function(ui,e){editFormResize_multi(1)}, resize:function(ui,e){editFormResize_multi(0,e)}, stop:function(ui,e){editFormResize_multi(2,e)} });
	$("#page_taskedit_multi"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } });


	$("#page_task2users_multi"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit_multi"+decID+forum_decID).width(), minHeight:$("#page_taskedit_multi"+decID+forum_decID).height(), start:function(ui,e){editFormResize_multi(1)}, resize:function(ui,e){editFormResize_multi(0,e)}, stop:function(ui,e){editFormResize_multi(2,e)} });
	$("#page_task2users_multi"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } });
    

	



 
 
	//var forum_decID = document.getElementById('forum_decID').value; 
	var mgr=document.getElementById('mgr').value;
	 
	var  mgr_userID = document.getElementById('mgr_userID').value;
    
 
	

/********************************************TOGGLE USERS***********************************************************************/
$('#userview'+decID+forum_decID).bind("click", function(evt) {
   
    $('#userview'+decID+forum_decID).hide();
    
});


$('#userview'+decID+forum_decID).bind("mouseleave", getout);
$('#sortuserform'+decID+forum_decID).bind("mouseleave", getout);


function getout(evt) {
 $('#userview'+decID+forum_decID).hide();
 $('#sortuserform'+decID+forum_decID).hide();
}

 /****************************************************************************************/ 	
 $('#tagusercloud'+decID+forum_decID).draggable();	
 
 

/*******************************************************************************************/ 


$('div#tagusercloudcancel'+decID+forum_decID+'').click(function(){
	 $('#tagusercloud'+decID+forum_decID).hide();

 });
 
/*******************************************HOVER******************************************************/  
 
$('#tagusercloudcontent'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
.hover(function() {

$(this).addClass('containerHover');


}, function() {

$(this).removeClass('containerHover');


});
/****************************************************************************************/
 $('#tagusercloudbtn'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});

/******************************************************************************************/
 $('#tagusercloudbtn_all'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


}, function() {

 $(this).removeClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


});

/******************************************************************************************/		
 $('#tagusercloudcancel'+decID+forum_decID+':btnstr')//.css("border", "2px solid #cccccc") 	
.hover(function() {

$(this).addClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


}, function() {

$(this).removeClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


});
/****************************************************************************************/
 		
 $('#tagusercloudcancel_all'+decID+forum_decID+':btnstr') 
.hover(function() {

$(this).addClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


}, function() {

$(this).removeClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


});
/****************************************************************************************/
$('#userviewcontainer'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

$(this).addClass('containerHover')	;		 
 
    		   }, function() {

$(this).removeClass('containerHover');


});

 
/****************************************************************************************/
$('#usersort'+decID+forum_decID+':btnstr') //.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});





$('#sortuserform'+decID+forum_decID).bind("click", function(evt) {
   
    $('#sortuserform'+decID+forum_decID).hide();
    
});




/****************************************************************************************/
$('#userpriopopup'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});
/****************************************************************************************/  
$('#page_useredit'+decID+forum_decID).hover(function() {

 	 $(this).addClass('containerHover');
    	}, function() {
   	 $(this).removeClass('containerHover');
 	}); 	
/****************************************************************************************/ 	
$('#fullcalendar_link'+forum_decID).fancybox({
				frameWidth: 1100,
				frameHeight: 800
			});
/*****************************************************************************************************/
$('#my_button_win_user'+decID+forum_decID).css({'background':'#B4D9D7'}).bind('click', function() {

		  	var link= '../admin/find3.php?&decID='+decID ;
		   	openmypage3(link); 
		  
		    return false;
			 });

/***************************************TOGGLE_USERS_FORM*************************************************************/
	$(".my_usertitle_"+decID+forum_decID).css('cursor','pointer').addClass('link'); 
  $(".my_usertitle_"+decID+forum_decID).toggle( 
    function(){ 
    
       
      $(this).addClass('hover');
      $("#userlist"+decID+forum_decID).slideToggle();
    },  
    function(){ 
      $(this).removeClass('hover'); 
      $("#userlist"+decID+forum_decID).slideToggle();
	    } 
	);  	 

/*********************************************************************************************************************/
/***************************************TOGGLE_USERS_FORM*************************************************************/
	$(".my_user_title_"+decID+forum_decID).css('cursor','pointer').addClass('link'); 
  $(".my_user_title_"+decID+forum_decID).toggle( 
    function(){ 
    
       
      $(this).addClass('hover');
      $("#userlist"+decID+forum_decID).slideToggle();
    },  
    function(){ 
      $(this).removeClass('hover'); 
      $("#userlist"+decID+forum_decID).slideToggle();
	    } 
	);  	 

/*********************************************************************************************************************/
	 	
	$("#usertabs"+decID+forum_decID).tabs({});
	$("#userlist"+decID+forum_decID).sortable({cancel:'span,input,a,textarea', delay: 150, update:orderuserChanged2 , start:sortuserStart});
	$("#userlist"+decID+forum_decID).bind("click", userlistClick);
     $("#edittags1"+decID+forum_decID).autocomplete('../admin/ajax2.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
     $("#tags"+forum_decID).autocomplete('../admin/ajax2.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
	 $("#userpriopopup"+decID+forum_decID).mouseleave(function(){$(this).hide()});
	 
			 
loadUsers2('../admin/',forum_decID,decID,mgr_userID,mgr); 
			     // echo "\tloadTasks2('".ROOT_WWW."/admin/',$forum_decID,$decID);\n";

	 

/*****************************************************************************/

//$(".menu2 a").append("<em></em>");
//	
//	$(".menu2 a").hover(function() {
//		$(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
//		var hoverText = $(this).attr("title");
//	    $(this).find("em").text(hoverText);
//	}, function() {
//		$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");
//});
$('#content').css('border','3px solid red');
 $('ol.task-actions_user').find('div.task-actions_user').find("a.menu2").css('border','3px solid red');

 $(".menu2").click(function() {
	 alert("sdfsdfsdf");
 });	 
// $(".menu2 a").hover(function() {
//		$(this).next("em").animate({opacity: "show", top: "-75"}, "slow");
//	}, function() {
//		$(this).next("em").animate({opacity: "hide", top: "-85"}, "fast");

//alert("ssssss");
//	});


/***************************************************************************/

	
	//if(flag_level==0){
		 $('.my_task').css('width','20%');
		 turn_red_task();	 
	//}
/***************************************************************************************************************/
     
      	$('#duedate_1'+forum_decID).datepicker( $.extend({}, {showOn: 'button',	
                              buttonImage:'../images/calendar.gif', buttonImageOnly: true,
                              changeMonth: true,
		                       changeYear: true,
		                       showButtonPanel: true,
		                       buttonText: "Open date picker",
		                       dateFormat: 'yy-mm-dd',
		                       altField: '#actualDate'}, $.datepicker.regional['he'])); 
         
		
/***************************************************************************************************************/
                        
       $('#duedate2'+decID+forum_decID).datepicker( $.extend({}, {showOn: 'button',
                               buttonImage:'../images/calendar.gif', buttonImageOnly: true,
                               changeMonth: true,
                               changeYear: true,
                               showButtonPanel: true,
                               buttonText: "Open date picker",
                               dateFormat: 'yy-mm-dd',
                               altField: '#actualDate'}, $.datepicker.regional['he'])); 
                                
/****************************************************************************************************************/			

	 
 	$("#page_useredit"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowUserEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
 	$("#page_useredit"+decID+forum_decID).resizable({ minWidth:$("#page_useredit"+decID+forum_decID).width(), minHeight:$("#page_useredit"+decID+forum_decID).height(), start:function(ui,e){edituserFormResize(1)}, resize:function(ui,e){edituserFormResize(0,e)}, stop:function(ui,e){edituserFormResize(2,e)} });

 	$('#page_usertaskedit_b'+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowUserEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
 	$('#page_usertaskedit_b'+decID+forum_decID).resizable({ minWidth:$("#page_usertaskedit_b"+decID+forum_decID).width(), minHeight:$("#page_usertaskedit_b"+decID+forum_decID).height(), start:function(ui,e){edituserFormResize(1)}, resize:function(ui,e){edituserFormResize(0,e)}, stop:function(ui,e){edituserFormResize(2,e)} });
     
 	$('#page_usertaskedit'+decID+forum_decID).draggable();//({ stop: function(e,ui){ flag.windowUserEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
 	$('#page_usertaskedit'+decID+forum_decID).resizable();//({ minWidth:$("#page_usertaskedit"+decID+forum_decID).width(), minHeight:$("#page_usertaskedit"+decID+forum_decID).height(), start:function(ui,e){edituserFormResize(1)}, resize:function(ui,e){edituserFormResize(0,e)}, stop:function(ui,e){edituserFormResize(2,e)} });
     
    

	 $('#fullcalendar-link_'+forum_decID).fancybox({
			frameWidth: 1100,
			frameHeight: 800
	}); 
/*********************************************************************************/
 //});//end ready

 
 //$('#userrow_'+mgr).css({"border": "3px solid red"});	
 $().ajaxSend( function(r,s) {$("#loading"+decID+forum_decID).show();} );
 $().ajaxStop( function(r,s) {$("#loading"+decID+forum_decID).fadeOut();} );
   
