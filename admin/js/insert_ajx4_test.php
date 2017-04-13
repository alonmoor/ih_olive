<?php 
//require_once '../../config/application.php';

//  html_header();
  
?> 
 

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
 
<link rel='stylesheet' type='text/css' href='fullcalendar.css' />
<script type='text/javascript' src='jquery.js'></script>
<script type='text/javascript' src='jquery-ui-custom.js'></script>
<script type='text/javascript' src='fullcalendar.js' charset="utf-8"></script>
 

  
<!--<link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/fullcalendar.css"  />-->

 


<!-- 
<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-1.3.2.min.js"           type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/fullcalendar.js"  type="text/javascript"></script>

<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-ui-1.7.1.custom.min.js" type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
 <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/ui.resizable.js" type="text/javascript"></script>
       
     <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/my_dialog.js"                type="text/javascript"></script>       
       <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/ui.core.js" type="text/javascript"></script>  
        


       <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/ui.dialog.js" type="text/javascript"></script>
       <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/ui.draggable.js" type="text/javascript"></script>
        


      <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi.js"       type="text/javascript"></script>
      <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi_user.js"   type="text/javascript"></script>

 
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/resulttable.css" />
	 
   <link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css' />
   

    <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/fullcalendar.css"  />  
      
	
    <link rel="stylesheet" type="text/css" media="all"    href="<?php echo CSS_DIR ?>/style_test.css" />
 
 -->

  
<!--<script type='text/javascript' src='jquery.js'></script>-->
<!--<script type='text/javascript' src='jquery-ui-custom.js'></script>-->



<script type='text/javascript'>
 
$(document).ready(function() {
	
	 
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
	  
		 
 
 
var calendar = $('#calendar').fullCalendar({
 

theme: true,
allDayText: "יום שלם",

     		 
	header: {
	left: 'nextYear,next,prev,prevYear , today ',
	center: 'title',
	right: 'month,agendaWeek,agendaDay'
	},
	
	  selectable: true,
	  selectHelper: true,
	  isRTL: true,
	 editable: true,
	 


weekends: true,
weekMode: 'variable',	        
allDaySlot: true,
 slotMinutes: 30,
 // firstHour: 10,
 timeslotsPerHour : 4,
 allowCalEventOverlap : true,
businessHours :{start: 8, end: 18, limitDisplay: true },
allDaySlot :true,
 defaultEventMinutes:120,
/***************************************************************************************************************/

select: function(start, end, allDay,calEvent) {
			//	alert( timeFormat( start, 'HH:mm' ) );		
						
 calendar_new_entry1 (calendar,start, end, allDay,calEvent);
 $('#calendar').fullCalendar('render');
 $('#calendar').fullCalendar('refetchEvents');
	//init();


 function renderAgenda(c, colFormat, fetchEvents) { 
	 colCnt = c; 
	  alert(colCnt); 
	  
	 // update option-derived variables 
	 tm = options.theme ? 'ui' : 'fc'; 
	 nwe = options.weekends ? 0 : 1; 

	  
	  dis = 1; 
	 dit = 0; 
	 } 









	},
	
/****************************************************************************************************************/
eventClick: function(event, element,calEvent, allDay) {

    $(this).css('border-color', 'red');

  calendar_edit_entry1(event,element,calEvent,calendar, allDay);
  $('#calendar').fullCalendar('refetchEvents');
 },
/*********************************************************************************************************************/
eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {

calendar_move_entry(event, dayDelta,minuteDelta, allDay);

if (view.name=='month'){ 
	$('#calendar').fullCalendar( 'renderEvent', event    );
	$('#calendar').fullCalendar('refetchEvents'); 
  
}

},

/*********************************************************************************************************************/
eventResize: function(event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view,allDay) {
	 
		 calendar_move_entry(event, dayDelta, minuteDelta);
//				console.log('RESIZE!! ' + event.title);
//				console.log(dayDelta + ' days');
//				console.log(minuteDelta + ' minutes');
				//setTimeout(function() {
				//	revertFunc();
				//}, 2000);
				//console.log(jsEvent);
				//console.log(ui);
				//console.log(view.title);
				//console.log(this);
			},	

/****************************************************************************/

/********************************************************************************/
//	slot15: function(){
//				options['slotMinutes'] = 15;
//				$(window).unbind('resize', windowResize);
//				if (header) {
//					header.remove();
//				}
//				content.remove();
//				$.removeData(_element, 'fullCalendar');
//				
//				//reinit??
//			},
//			slot30: function(){
//				options['slotMinutes'] = 30;
//				$(window).unbind('resize', windowResize);
//				if (header) {
//					header.remove();
//				}
//				content.remove();
//				$.removeData(_element, 'fullCalendar');
//
//				//reinit??	
//			},
//			slot60: function(){
//				options['slotMinutes'] = 60;
//				$(window).unbind('resize', windowResize);
//				if (header) {
//					header.remove();
//				}
//				content.remove();
//				$.removeData(_element, 'fullCalendar');
//
//				//reinit??	
//			},


		


					
/*******************************************************************************/
 events: "json-events2.php",
 
/**************************************************************************************************************/ 
//eventMouseover: function(event, jsEvent, view) {
				//console.log('MOUSEOVER ' + event.title);
				//console.log(jsEvent);
				//console.log(view);
				//console.log(this);
		//	},
		//	eventMouseout: function(event, jsEvent, view) {
				//console.log('MOUSEOUT ' + event.title);
				//console.log(jsEvent);
				//console.log(view);
				//console.log(this);
		//	},
			
			
		
//			eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
//				console.log('DROP ' + event.title);
//				console.log(dayDelta + ' days');
//				console.log(minuteDelta + ' minutes');
//				console.log('allday: ' + allDay);
				//setTimeout(function() {
				//	revertFunc();
				//}, 2000);
				//console.log(jsEvent);
				//console.log(ui);
				//console.log(view.title);
				//console.log(this);
//			},
			
//			eventResizeStart: function(event, jsEvent, ui, view) {
//				//console.log('RESIZE START ' + event.title);
//				//console.log(this);
//			},
//			eventResizeStop: function(event, jsEvent, ui, view) {
//				//console.log('RESIZE STOP ' + event.title);
//				//console.log(this);
//			},
//			eventResize: function(event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
// 
//				console.log('RESIZE!! ' + event.title);
//				console.log(dayDelta + ' days');
//				console.log(minuteDelta + ' minutes');
				//setTimeout(function() {
				//	revertFunc();
				//}, 2000);
				//console.log(jsEvent);
				//console.log(ui);
				//console.log(view.title);
				//console.log(this);
//			},
			
/********************************************************************************************************/
 //	viewDisplay: function(view) {
//				// Deselect all events when changing the calendar timespan.
// 				var events = $("#calendar").fullCalendar('clientEvents');
//				jQuery.each(events, function(i, val) {
//					val.selected = false;
//				});
 				//$("#calendar").fullCalendar('refetchEvents');
//console.log('viewDisplay');
//				console.log(view.start + ' - ' + view.end);
//				console.log(view.visStart + ' - ' + view.visEnd);
				//console.log(view);
				//console.log(this);

 		//}, 	 
/*************************************************************************************************************/
			

/*************************************************************************************************************/
       
	 	 
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			}
			
			

			});

/************************************************************************************************/
           
       // $('#calendar').fullCalendar('option', 'aspectRatio', 1.8); 
       //$('#calendar').fullCalendar( 'addEventSource',calEvent );//after event	 
		//$('a.my_button').css("border", "3px solid yellow").css("width", "20px");
		$('#mySpan_button0').css("font-size", "20px");
		$('#mySpan_button1').css("font-size", "20px");
		$('#mySpan_button2').css("font-size", "20px"); 
		
		$('h2').css("border", "3px solid yellow").css("width", "220px"); 
	    $('.fc-day-number').css("color", "green");
	    //$('.my_button').css('background', "white");
	    //$('.fc-button-today').css("background", "white");
		if(!($.browser.mozilla==true))  {
			$('#calendar').css({'margin-right':'140px'});			   
		}
		//$('#calendar').fullCalendar( 'select',startDate,endDate, allDay );
		$('span#my_event_title').css({'background':'#B4D9D7'});
/******************************************************************************************************/
 
 
  						
/************************************************************************************************/		 
	});//end DC_READY

	
		
	
	 $("#loading img").ajaxStart(function(){
		   $(this).show();
		 }).ajaxStop(function(){
		   $(this).hide();
		 });	
/*********************************************************************/
</script>

<style type='text/css'>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
</head>
<body>
<div id='calendar'></div>
</body>
 
</html>

  
 