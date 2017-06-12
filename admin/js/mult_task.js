 
$(document).ready(function(){
// 	var decID=document.getElementById('decID').value; 
  	var forum_decID=document.getElementById('forum_decID').value;
 alert("THIS IS-"+ forum_decID);
// 	 document.getElementById('mgr').value;  
 
 

/*******************************TOGGLE_MAIN_FIELDSET*******************************************/

$(".my_main_fieldset").addClass('link'); 
$(".my_main_fieldset").toggle( 
  function(){ 
  
     
    $(this).addClass('hover');
$("#main_fieldset").slideToggle('slow');
  },  
  function(){ 
    $(this).removeClass('hover'); 
$("#main_fieldset").slideToggle('slow');
  } 
);  
/*******************************TOGGLE_MENU_ITEM*******************************************/

$(".my_menu_items_dec_title").addClass('link'); 
$(".my_menu_items_dec_title").toggle( 
  function(){ 
  
     
    $(this).addClass('hover');
$("#menu_items_dec"+decID).slideToggle('slow');
  },  
  function(){ 
    $(this).removeClass('hover'); 
$("#menu_items_dec"+decID).slideToggle('slow');
  } 
);    

/******************************TOGGLE_TASK_TABLE*******************************************/
//$('.category h2').click(function() {
//	    $(this).parent().find('.content').slideToggle();
//  });
//$(".my_dec_title_table_"+decID).addClass('link').click(function() {
//  $(this).parent().find('#content_my_dec').slideToggle();
//		  });


  
 
$(".my_dec_title_table_"+decID).addClass('link'); 
$(".my_dec_title_table_"+decID).toggle(

function(){ 


$(this).addClass('hover');
$("#content_my_dec").slideToggle('slow');

},  
function(){ 
$(this).removeClass('hover'); 
$("#content_my_dec").slideToggle('slow');
} 
);    

/***********************************************FORUM_DEC*********************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



 
var url='../admin/';
 

//
//	
// var arv = dest_forums_conv.toString();
// 
//
//
//   $.ajax({
//			   type: "POST",
//			   url: "../admin/make_task.php",
//			 
//			  data:  "rebuild="+ arv + "&decID=" + decID ,
//			  
//			     
//
//			   success: function(msg){
//			 
//			console.log(msg);     
//		  //$('table#my_dec'+decID).html(' ').append('<p>'+msg+'</p>');
//	  	  $('#target_task').html(' ').append('<p>'+msg+'</p>');
//			//	$.getScript(); 
///**********************************************************************************************************/			 
///*****************************************************************************************************/
//			 }  
//			 
//			}) ; 
//		 
//   return false;
/*************************************TASKS*******************************************************/
  $("#my_dec"+decID).removeClass();
  $("#task_fieldset_"+forum_decID).removeClass();
  if(!($.browser.mozilla==true ))
   $("#my_dec"+decID).css("float", "left"); 

/**************************************TOGGLE_TASK_FORM*****************************************************/ 
	 
$(".my_title_"+decID+forum_decID).addClass('link'); 
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
/***************************************TOGGLE_USERS_FORM*************************************************************/	 
 
  	 
	$(".my_usertitle_"+decID+forum_decID).addClass('link'); 
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
 
/******************************PROGRESS_BAR********************************************************/


 

var progressOpts = {
          change: function(e, ui) {
             
    	
  
          var val =$(this).progressbar("option", "value");

if(val <=100) {
  //show new value
  ($("#value"+decID+forum_decID).length === 0) ? $("<span>").css({'background':'#2AAFDC'}).text(val + "%").attr("id", "value"+decID+forum_decID)
   .css({ float: "right", marginTop: -28, marginRight:10 })
   .appendTo("#progress"+decID+forum_decID) : $("#value"+decID+forum_decID).text(val + "%");
   
} else    {
   $("#increase"+decID+forum_decID).attr("disabled", "disabled");
    }
	
  }
};

 $("#progress"+decID+forum_decID).progressbar(progressOpts).css({'background':'#2AAFDC'});
 //$("#progress"+decID+forum_decID)//.rermoveClass().addClass('ui-progressbar-value ui-widget-header ui-corner-left');  

/****************************************************************************************/ 	
 $('#tagcloud'+decID+forum_decID).draggable();	
 
 

/*******************************************************************************************/ 


$('div#tagcloudcancel'+decID+forum_decID+'').click(function(){
 $('#tagcloud'+decID+forum_decID).hide();

 });
 
/*************************************************************************************************/  
 
$('#tagcloudcontent'+decID+forum_decID+':btnstr').css("border", "1px solid red") 	
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
$('#tagcloudbtn'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});

/******************************************************************************************/	


$('#multicloudbtn'+decID+forum_decID+':btnstr')//.css("border", "1px solid red") 	
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
 
$('#tagcloudcancel'+decID+forum_decID+':btnstr').css("border", "2px solid #cccccc") 	
.hover(function() {

$(this).addClass('containerHover');


}, function() {

$(this).removeClass('containerHover');


});
/****************************************************************************************/
 $('#my_button_win'+decID+forum_decID).css({'background':'#B4D9D7'}).bind('click', function() {
 
		  	var link= '../admin/find3.php?&forum_decID='+forum_decID ;
   	openmypage(link); 
  
    return false;
	 });
/***************************************************************************************************/	  
 
 $('#delete'+decID+forum_decID).bind('click',function(){
 
 $('#delete'+decID+forum_decID).unbind(); 
		 
	 });
 
/************************************************************************************************/ 	
 $("#tabs"+decID+forum_decID).tabs({ select: tabSelected });
$("#tasklist"+decID+forum_decID).sortable({cancel:'span,input,a,textarea', delay: 100, update:orderChanged, start:sortStart});
$("#tasklist"+decID+forum_decID).bind("click", tasklistClick2);
$("#edittags"+decID+forum_decID).autocomplete('/alon-web/olive_prj/admin/ajax.php?suggestTags', {scroll: false, multiple: true, selectFirst:false, max:8});
$("#priopopup"+decID+forum_decID).mouseleave(function(){$(this).hide();});
	 
   setSort2( 0 , decID , forum_decID  ,1);
/**************************************************************************************/	   
   
   
   
 	 loadTasks2(url,forum_decID,decID);
	 
 	 
 	 
 	 
/**************************************************************************************/	 	 
 
 preloadImg();
$("#duedate"+decID+forum_decID).datepicker({dateFormat: 'yy-mm-dd' , firstDay: 1, showOn: 'button', buttonImage: '../images/calendar.png', buttonImageOnly: true, 
changeMonth:true, changeYear:true, constrainInput: false, duration:'', nextText:'&gt;', prevText:'&lt;', dayNamesMin:lang.daysMin, 
	monthNamesShort:lang.monthsShort });

		
$("#page_taskedit"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 

 
/**********************************************************************************/
	 
    var resizeOpts = {
      autoHide: true,
	  minHeight: 170,
	  minWidth: 400
    };
			
   
   $("#page_taskedit"+decID+forum_decID).resizable(  ); 
 





/*********************************************************************************/
//				$("#page_taskedit"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit"+decID+forum_decID).width(), minHeight:$("#page_taskedit"+decID+forum_decID).height(),start:function(ui,e){editFormResize2(decID,forum_decID,1)}, resize:function(ui,e){editFormResize2(decID,forum_decID,0,e)}, stop:function(ui,e){editFormResize2(decID,forum_decID,2,e)} });

 
 //$("#edit_task"+decID+forum_decID).resizable({ minWidth:$("#edit_task"+decID+forum_decID).width(), minHeight:$("#edit_task"+decID+forum_decID).height(),start:function(ui,e){editFormResize2(decID,forum_decID,1)}, resize:function(ui,e){editFormResize2(decID,forum_decID,0,e)}, stop:function(ui,e){editFormResize2(decID,forum_decID,2,e)} });


//$("#page_taskedit_multi"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit_multi"+decID+forum_decID).width(), minHeight:$("#page_taskedit_multi"+decID+forum_decID).height(), start:function(ui,e){editFormResize_multi(1)}, resize:function(ui,e){editFormResize_multi(0,e)}, stop:function(ui,e){editFormResize_multi(2,e)} });
//$("#page_taskedit_multi"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } });
//
//
//$("#page_task2users_multi"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit_multi"+decID+forum_decID).width(), minHeight:$("#page_taskedit_multi"+decID+forum_decID).height(), start:function(ui,e){editFormResize_multi(1)}, resize:function(ui,e){editFormResize_multi(0,e)}, stop:function(ui,e){editFormResize_multi(2,e)} });
//$("#page_task2users_multi"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } });
//
//
//
//
///***************************************USERS_INTERFACE**********************************************************************/		
////$("#usertabs"+decID+forum_decID).tabs({ select: tabSelected });
//$("#userlist"+decID+forum_decID).sortable({cancel:'span,input,a,textarea', delay: 150, update:orderuserChanged, start:sortuserStart});
//$("#userlist"+decID+forum_decID).bind("click", userlistClick);
// $("#edittags1"+decID+forum_decID).autocomplete('/alon-web/olive_prj/admin/ajax.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
// $("#userpriopopup"+decID+forum_decID).mouseleave(function(){$(this).hide()});
// 
// setuserSort(0,1);
// 
//		 
//loadUsers2(url, forum_decID,decID, mgr);
//		 
// 		
// preloadImg();
// $("#duedate1"+decID+forum_decID).datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true, 
//changeMonth:true, changeYear:true, constrainInput: false, duration:'', nextText:'&gt;', prevText:'&lt;', dayNamesMin:lang.daysMin, 
//			monthNamesShort:lang.monthsShort });
     
   
	
/*****************************************until here**********************************************************************/     			
	
//				$("#page_useredit"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowUserEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
//				$("#page_useredit"+decID+forum_decID).resizable({ minWidth:$("#page_useredit"+decID+forum_decID).width(), minHeight:$("#page_useredit"+decID+forum_decID).height(), start:function(ui,e){edituserFormResize(1)}, resize:function(ui,e){edituserFormResize(0,e)}, stop:function(ui,e){edituserFormResize(2,e)} });




//$("#page_userfindedit").draggable({ stop: function(e,ui){ flag.windowUserEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
//$("#page_userfindedit").resizable({ minWidth:$("#page_userfindedit").width(), minHeight:$("#page_userfindedit").height(), start:function(ui,e){edituserFormResize(1)}, resize:function(ui,e){edituserFormResize(0,e)}, stop:function(ui,e){edituserFormResize(2,e)} });	



 // $("ol#userlist"+decID+forum_decID).find("#userrow_"+mgr).css("border", "3px solid red");	 
   //$("#userlist"+decID+forum_decID).css("border", "3px solid red");












/**************************************************************************************************************************/		
			
 
	  
});	


