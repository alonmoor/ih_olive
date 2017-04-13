/**************************************************************************************/
function ajaxBUEvents(calendar,start, end){
//	var url='/alon-web/olive_prj/admin/full_calendar/';
	var url='../admin/full_calendar/';
    //Loop through the selected checked calendars
    $(selectBUCalendars()).each(function(i, cal){
        $.ajax({
                type: 'POST',
                data: {'startDate': start, 'endDate': end, 'buCals[]': cal}, 
               // url: '<?= site_url('AJAX/calendar_ajax/get_cal_events'); ?>',
               url: url+"json-events3.php", 
                dataType: 'json',
                async: false,
                beforeSend: function(){
                        $('#loading-dialog').dialog({minHeight: 100, width: 250}).dialog('open');
                        $('#loading-dialog p').text('Loading '+cal+' Calendar Events');
                }, 
                success: function(calevents){
                        $.each(calevents, function(i, calevent){
                                $('#calendar').fullCalendar('renderEvent', calevent, true); 
                        }); 

//                        success: function(calevents){
//                            $('#calendar').fullCalendar('addEventSource', calevents); 
//                        }
                                                
                }
        });
    }); 
    $('#loading-dialog').dialog('close');
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function setupStartAndEndTimeFields($startTimeField, $endTimeField,  start,end ,getTimeslotTimes,calendar) {
//	defaultEventMinutes.length=30;
	var subEnd= new Date(start.getFullYear() ,start.getMonth(), start.getDate(),start.getHours()+1,start.getMinutes(),00,00);
	//var start = ( start) ? $.fullCalendar.formatDate(  start, 'dd-MM-yyyy' ) : '';
	var startTime = (start) ? $.fullCalendar.formatDate( start, 'HH:mm' ) : '';
	var end = (end) ? $.fullCalendar.formatDate( end, 'dd-MM-yyyy' ) : $.fullCalendar.formatDate( subEnd, 'dd-MM-yyyy' );
	var endTime = (end)? $.fullCalendar.formatDate( end, 'HH:mm') : $.fullCalendar.formatDate( subEnd, 'HH:mm');
    for(var i=0; i<20; i++) {
         var startTime = start; 
         var endTime = end;
         var startSelected = "";
         if(startTime.getTime() === start.getTime()) {
             startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if(endTime.getTime() === end.getTime()) {
             endSelected = "selected=\"selected\"";
         }
//         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
//         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + start + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + end + "</option>");
     }
     $endTimeOptions = $endTimeField.find("option"); 
     $startTimeField.trigger("change");
 }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function setupStartAndEndTimeFields2($startTimeField, $endTimeField, calEvent, timeslotTimes) {
	alert(timeslotTimes.length);
   for(var i=0; i<timeslotTimes.length; i++) {
        var startTime = timeslotTimes[i].start; 
        var endTime = timeslotTimes[i].end;
        var startSelected = "";
        if(startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
        }
        var endSelected = "";
        if(endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
        }
        $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
        $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");
   
    }
    $endTimeOptions = $endTimeField.find("option"); 
    $startTimeField.trigger("change");
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function getTimeslotTimes (date) {
    var options = this.options;
    var firstHourDisplayed = options.businessHours.limitDisplay ? options.businessHours.start : 0;
    var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), firstHourDisplayed);
    
    var times = []
    var startMillis = startDate.getTime();
    for(var i=0; i < options.timeslotsPerDay; i++) {
        var endMillis = startMillis + options.millisPerTimeslot;
        times[i] = {
            start: new Date(startMillis),
            startFormatted: this._formatDate(new Date(startMillis), options.timeFormat),
            end: new Date(endMillis),
            endFormatted: this._formatDate(new Date(endMillis), options.timeFormat)
         };
        startMillis = endMillis;
    }
    return times;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function calendar_new_entry1(calendar,start, end, allDay,calEvent,userID,decID,forum_decID,calendar_new_entry1) {
	  
//	var url='/alon-web/olive_prj/admin/full_calendar/';
	var url='../full_calendar/';
	nocache = '&rnd='+Math.random();

	var ds=start, df=end;
	            $('<div id="calendar_new_entry_form" title="הוסף ארוע חדש" style="text-align:center;"><br />'+
	            				  		
	            '<input value="Event" style="width:100%;" id="calendar_new_entry_form_title" type="text" /><br />'+
	         
	            '<h3>כול היום</h3><input id="" type="checkbox"  checked="check"	/>'+
	            '<h3>תאור הארוע</h3> '+
	            '<div id="event_edit_container">'+
	       	 
	            
	            '<form id="dateForm">'+
	            '<span>תאריך: </span>'+
	       		'<span class="date_holder"></span>'+ 
	       		'<h3> : שעת התחלה</h3>'+
	       		'<select name="start"><option value="">בחר שעת התחלה</option></select>'+
	       		'<h3>:שעת סיום </h3>'+
	       		'<select name="end"><option value="">בחר שעת סיום</option></select>'+
	        	'</div>'+	
	        	'</form>'+
	        	
	        	
	        	'<h3>הערות</h3><br />'+	
	            '<textarea style="width:400px;height:200px" id="calendar_new_entry_form_body">event description</textarea></div>').appendTo($('body'));
	           // console.log(allDay);  
	           
	           // resetForm $("#calendar_new_entry_form") ;
	            var startField = $("#calendar_new_entry_form").find("select[name='start']").val( start);
	            var endField =  $("#calendar_new_entry_form").find("select[name='end']").val(end); 
	            
	            $("#calendar_new_entry_form").dialog({
	            bgiframe: true,
	            autoOpen: false,
	            height: 440,
	            width: 450,
	            modal: true,
//	            calendar:$calendar,
//                
//                calevent:calEvent,
//                timeslottimes:$calendar.fullCalendar("getTimeslotTimes", calEvent.start),
	            buttons: {
	            
	            'Save':  function() {
	            	 
	            	 //alert(start.getMonth()+1);
	            	$('#calendar_new_entry_form').find(':checkbox').each(function(){ 
	          		  if($(this).is(':checked')) 
	          		  { 
	          		   allDay=true; 
	          		  } else{
	          			  allDay=false;
	          		  }
	          		 });   
	            	//alert(allDay);
	             var $this=$(this);   
	              title=$('#calendar_new_entry_form_title').val();
	              body=$('#calendar_new_entry_form_body').val();
	              calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                 //	var x=$('#calendar').fullCalendar("getTimeslotTimes", start);                            
	              $.ajax({
	                 type: "POST",
	                        url: url+"json-events3.php",
	                        dataType: 'json',
	                        data: {
	                            // our hypothetical feed requires UNIX timestamps
	                            action:'save',
	                            title:title,
	                            body:body,
	                            start: Math.round(start.getTime() / 1000),
	                           
	                            end: Math.round(end.getTime() / 1000),
	                            allDay:allDay,
	                            userID:userID,
	                            decID:decID,
	                            forum_decID:forum_decID
	                        },
	                        success: function(json) {
	                                 var  id=json[0].id;
	                                 var  body=json[0].description;
	                                 
			                if (json[0].title) {
			                calendar.fullCalendar('renderEvent',
			                	{
			                	   id:id,	
			                	   userID:userID,
			                	   decID:decID,
			                	   forum_decID:forum_decID,
			                	   title: title,
			                	   description:body,
			                	   start: start,
			                	   end: end,
			                	   allDay: allDay,
			                	   height: 650
			                	} 
	                	//true // make the event "stick" make problem with dropable
	                 );
	              } 
	                
	               
	                calendar.fullCalendar('unselect');
	        
	               
	                        $this.dialog('close');
	                        $('#calendar').fullCalendar('refresh');
	                         $("#calendar_new_entry_form").remove();
	                         
	                         $("#loading img").ajaxStart(function(){
	                     		   $(this).show();
	                     		 }).ajaxStop(function(){
	                     		   $(this).hide();
	                     		 });    
	                    }

	               });
	              },
	             
	            
	     
	           
	             

	     
	            Cancel: function() {
	            //$event.remove();
	            $(this).dialog('close');
	            $("#calendar_new_entry_form").remove();
	            }
	             	       
	            },
	            

	             close: function() {
	            $('#calendar').fullCalendar('removeUnsavedEvents');
	            $("#calendar_new_entry_form").remove();
	            }
	            });//end dialog
/*************************************************************************************************/	            
	            $("#calendar_new_entry_form").dialog('open');
	            $("#calendar_new_entry_form").find(".date_holder").text(start.getFullYear() + "-" + (start.getMonth()+1) + "-" + start.getDate());
	           // setupStartAndEndTimeFields2(startField, endField, start,end ,  $('#calendar').fullCalendar( start),calendar);
	           $(window).resize(); //fixes a bug in modal overlay size ??
/**********************************************************/
	           var $endTimeField = $("select[name='end']"); 
	           var $endTimeOptions = $endTimeField.find("option"); 
	            
	           //reduces the end time options to be only after the start time options.
	           $("select[name='start']").change(function(){
	                var startTime = $(this).find(":selected").val();
	                var currentEndTime = $endTimeField.find("option:selected").val();
	                $endTimeField.html(
	                    $endTimeOptions.filter(function(){
	                        return startTime < $(this).val();
	                    })
	                );
	                
	                var endTimeSelected = false;
	                $endTimeField.find("option").each(function() {
	                    if($(this).val() === currentEndTime) {
	                        $(this).attr("selected", "selected");
	                        endTimeSelected = true;
	                        return false;
	                    }
	                });
	                
	                if(!endTimeSelected) {
	                   //automatically select an end date 2 slots away. 
	                   $endTimeField.find("option:eq(1)").attr("selected", "selected");
	                }
	                
	            }); 	           
/********************************************************/	           
	            }//end function new entry 
/*******************************************************/
function getToday()
{
// Generate today's date.
this.now = new Date();
this.year = this.now.getFullYear() ; // Returned year XXXX
this.month = this.now.getMonth();
this.day = this.now.getDate();
}

/************************************************************************************************************/
function calendar_edit_entry1(event,element,calEvent,calendar, allDay,userID){
	  
   var title=event.title;
   var description=event.description ;
   var start=event.start;
    var end = event.end;
    var id=event.id;
   
//	var url='/alon-web/olive_prj/admin/full_calendar/';
    var url='../full_calendar/';
	if(!event.id)return;
	var ds=calEvent.start, df=calEvent.end;
	var allDay=event.allDay;

/******************************************************/
	 var $dialogContent = $("#event_edit_container");
     resetForm($dialogContent);
      var startField = $dialogContent.find("select[name='start']").val(event.start);
      var endField =  $dialogContent.find("select[name='end']").val(event.end);	
	
     $dialogContent.find(".date_holder").text(event.start.getFullYear() + "-" + event.start.getMonth() + "-" + event.start.getDate());
    
	    $(window).resize(); //fixes a bug in modal overlay size ??

/*********************************************************************************************/
		    
		nocache = '&rnd='+Math.random();

	
	
$.getJSON(url+'json-events3.php?action=get_event&id='+event.id + nocache,function(event){
	$('<div id="calendar_edit_entry_form" title="ערוך ארוע"><h3>הארוע</h3><br />'+
	'<input id="calendar_edit_entry_form_title" value="'+title+'" type="text"  style="width:100%;" dir="rtl" />'+
 	'<h3> סטטוס'+
	 '<form name="editevent" id="editevent">'+

	  '<SELECT name="my_sel"  id="my_sel" class="info_sel"  >'+
	      ' <option value="0" >יום חלקי</option>'+
	      '<option value="1" >כל היום</option>'+
	  '</SELECT> '+
	  '<br />'+
	  '<input type="button" id="part_time_button" class="mybutton"  value="שנה חלק יום"/>'+
	  '</form></h3>'+
 
 
   '<div id="event_edit_container"></div>'+	
	'<h3>הערות</h3><br />'+
	'<textarea style="width:400px;height:200px" id="calendar_edit_entry_form_body" dir="rtl">'+description+'</textarea></div>').appendTo($('body'));	    
/********************************************************************************************/	    
	
	    
/*********************************************************************************************/	    
	document.getElementById("my_sel").selectedIndex = allDay; 
				 	
 	
		$("#calendar_edit_entry_form").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 440,
			width: 450,
			modal: true,
			
			
			buttons: {

			
			'Save':  function() {
		
			 allDay=$('#my_sel').val(); 
			
        	                       
            var $this=$(this);   
             title=$('#calendar_edit_entry_form_title').val();
             body=$('#calendar_edit_entry_form_body').val();
            var hour_start=$('#my_cal_select').val();
            var hour_end=$('#my_cal_end_select').val();
             var userID=document.getElementById("userID").value;
      
             end=end?end:start;
           
             $.ajax({
                  type: "POST",
                       url: url+"json-events3.php",
                       dataType: 'json',
                       data: {
            	 
                          // our hypothetical feed requires UNIX timestamps
                           action:'save',
                           userID:userID,
                           id:id,
                           title:title,
                           hour_start:hour_start,
                           hour_end:hour_end,
                           body:body,
                           description:description,
                           allDay: allDay,
                           start: Math.round(start.getTime() / 1000),
                           
                           end: Math.round(end.getTime() / 1000)
                       },
                       success: function(json) {
                              var  id=json[0].id;
                              var  userID=json[0].userID;
                              var title=json[0].title;
                              
                              event.start =start;
                              event.end =end;
                              event.title = title;
                              event.body = body;
                              event. allDay= allDay;
                              if(event. allDay==1)
                            	  event. allDay=true;
                              else
                            	  event. allDay=false;
                             
                             
              	               
              	               
                              
                              
                                          
                $('#calendar').fullCalendar('updateEvent', event);      
                       
                       $this.dialog('close');
                       $('#calendar').fullCalendar('refresh');
                     $('#calendar').fullCalendar('refetchEvents');
/******************************************************************************************/
//                       $('#calendar').fullCalendar('removeEvents', function(event) {
//                    	   return event.id == id;
//                    	});
/*****************************************************************************************/                       
                        $("#calendar_edit_entry_form").remove();
                          
/****************************************************************************************/                        
                   }//end success
                
              });//end ajx
            
             },//end function save 
    
			
				Cancel: function() {
					$(this).dialog('close');
					$("#calendar_edit_entry_form").remove();
					 
				}, 
			
/***************************************************************************************/		
         	מחק: function() {
					if(confirm('בטוח שרוצה למחוק?')){
						$('#calendar_edit_entry_form').remove();
						 var userID=document.getElementById("userID").value;
						 $.getJSON(url+'json-events3.php?action=delete_event&id='+id+'&userID='+userID ,function(ret){
							$('#calendar').fullCalendar('refresh');
							$('#calendar').fullCalendar('removeEvents', function(event) {
		                    	   return event.id == id;
		                    	});
						});
						 $('#calendar').fullCalendar('removeEvents', function(event) {
	                    	   return event.id == id;
	                    	});
					}
				   
				}

/******************************************************************************************/		
		
		},//end button
			close: function() {
			$dialogContent.dialog("destroy");
            $dialogContent.hide();	
			$('#calendar').fullCalendar('removeUnsavedEvents');
			$("#calendar_edit_entry_form").remove();
			}
			 
		});//end dialog
		$("#calendar_edit_entry_form").dialog('open');
		
		$("#calendar_edit_entry_form").find(".date_holder").text(start.getFullYear() + "-" + (start.getMonth()+1 )+ "-" + start.getDate());
		
		
/******************************************************************/
		
//		$('form#editevent').find('select#my_sel').bind('change',function(){
		$('form#editevent').find('input#part_time_button').bind('click',function(){
		 
			$('#event_edit_container').append('<h3>:שעת התחלה  </h3>'+
			
			  '<select name="start" id="my_cal_select"><option value=""> בחר שעת התחלה  </option>\n'); 

						var i=8;
						var j=1;
						var str_am='am';
						var str_fm='pm';
						var str='0';
						var str1=':';
						var str2='00';
						var str3='30';
					for (var intLoop = 0; intLoop < 20; intLoop++){
						
						if((intLoop%2)==1){
							
							if(i<10 && i>0 ){ 
							var my_hour=str+i+str1+str2+str_am;
							//i++;
							}else if(i>=10 && i<=12 ){
							var my_hour=i+str1+str2+str_am;
							//i++;
							}
							else if(i>12){
							 var my_hour=i+str1+str2+str_fm;
						 }
						   
						
						}else{
							 
							 if(i<10 && i>0){ 
								var my_hour=str+i+str1+str3+str_am;
								i++;
								}else if(i>=10 && i<=12 ){
							    var my_hour=i+str1+str3+str_am;
							    i++;
								}
								else if(i>12){
 								 var my_hour=i+str1+str3+str_fm;
//								 j++;
								 i++;
							    } 
						
						}
						
						
						
					$('#my_cal_select').append("<OPTION " + (my_hour=='08:30am' ? "Selected" : "") + ">" + my_hour);
					
				 }


					
				
		$('#event_edit_container').append(
				$('</select><h3>:שעת סיום </h3><select name="end" id="my_cal_end_select" ><option value=""> בחר שעת סיום</option>\n'));// .appendTo($('body')); 
				     
				var i=8;
				var j=1;
				var str_am='am';
				var str_fm='pm';
				var str='0';
				var str1=':';
				var str2='00';
				var str3='30';
				for (var intLoop = 0; intLoop < 20; intLoop++){

				if((intLoop%2)==1){
				if(i<10 && i>0 ){ 
				var my_hour=str+i+str1+str2+str_am;
				//i++;
				}else if(i>=10 && i<=12 ){
				var my_hour=i+str1+str2+str_am;
				//i++;
				}
 				else if(i>12){
// 				 var my_hour=str+j+str1+str2+str_fm;
 					var my_hour=i+str1+str2+str_fm;	
 			 
 				}


				}else{
				 
				 if(i<10 && i>0){ 
					var my_hour=str+i+str1+str3+str_am;
					i++;
					}else if(i>=10 && i<=12 ){
				    var my_hour=i+str1+str3+str_am;
				    i++;
					}
					else if(i>12){
//					 var my_hour=str+j+str1+str3+str_fm;
						 var my_hour=i+str1+str3+str_fm;	
//					 j++;
					i++;	
				 } 

				}



				$('#my_cal_end_select').append("<OPTION " + (my_hour=='18:00pm' ? "Selected" : "") + ">" + my_hour);
				}
				    
				   
				$('#event_edit_container').append($('</select>'));
		  
			
		});             
       $("#part_time_button").bind("click", (function() {
        $("#part_time_button").unbind("click");

        }));
/****************************************************************************************************************************/    
			
		
		
    
          $(window).resize(); //fixes a bug in modal overlay size ??	 
	});//end get_json
	 
	

	
}//end function

/*******************************************************************************************************************/
function calendar_move_entry1(event, delta, minuteDelta, allDay){ 
/***************************************************************************************************************/
 
//	var url='/alon-web/olive_prj/admin/full_calendar/';
	var url='../full_calendar/';
	 event.end=event.end?event.end:event.start;
	 
	$.getJSON(url+'json-events3.php?action=move',{'title':event.title,'id':event.id,'start':event.start.getTime()/1000,'end':event.end.getTime()/1000,'delta':delta,'minuteDelta': minuteDelta,'allDay':allDay},null);
	
}
/*************************************************************************************************/
function init(slotMinutes) { // slotMinutes is an optional parameter
	   $('#calendar').fullCalendar({
	       slotMinutes: slotMinutes
	       // other options
	   });
	}

	function changeSlotMinutes(v) {
	   $('#calendar').fullCalendar('destroy');
	   init(v);
	}

/*****************************************************************************************************/
function new_event (start, end, allDay,calEvent,calendar){
	
	  var timestamp=start.getTime()/1000;
      var calEvent={
          id:Math.floor(100000+Math.random()*10000),
          title:'New Event',
          start: timestamp,
          end:timestamp+3600,
          isMain:true,
          frequency:0
      };
  //   $('#calendar').fullCalendar('renderEvent',calEvent,true);
      var $dialogContent = $("#event_edit_container");
      var dialogParams={
       //   calendar:$calendar,
         // list:calendars_list_data,
          calevent:calEvent,
          timeslottimes: $('#calendar').fullCalendar("getTimeslotTimes", calEvent.start)
      }
      $dialogContent.dialog({
      	bgiframe: true,
      	autoOpen: true, 
          height: 440,
          width: 450,
          modal: true,
          action:'create',
          params:dialogParams,
          buttons: {
	            
	            'Save':  function() {
	            	 //alert(start.getMonth()+1);
	            	$('#calendar_new_entry_form').find(':checkbox').each(function(){ 
	          		  if($(this).is(':checked')) 
	          		  { 
	          		   allDay=true; 
	          		  } else{
	          			  allDay=false;
	          		  }
	          		 });   
	            	//alert(allDay);
	             var $this=$(this);   
	              title=$('#calendar_new_entry_form_title').val();
	              body=$('#calendar_new_entry_form_body').val();
	              calEvent.start = new Date(startField.val());
                calEvent.end = new Date(endField.val());
               //	var x=$('#calendar').fullCalendar("getTimeslotTimes", start);                            
	              $.ajax({
	                 type: "POST",
	                        url: url+"json-events3.php",
	                        dataType: 'json',
	                        data: {
	                            // our hypothetical feed requires UNIX timestamps
	                            action:'save',
	                            title:title,
	                            body:body,
	                            start: Math.round(start.getTime() / 1000),
	                            end: Math.round(end.getTime() / 1000),
	                            allDay:allDay
	                        },
	                        success: function(json) {
	                                 var  id=json[0].id;
	                                 var  body=json[0].description;
	                                 
	                        
	         
	                if (json[0].title) {
	                calendar.fullCalendar('renderEvent',
	                	{
	                	   id:id,	
	                	   title: title,
	                	    description:body,
	                		start: start,
	                		end: end,
	                		allDay: allDay,
	                		 height: 650
	                	} //},
	                	//true // make the event "stick" make problem with dropable
	                 );
	              } 
	                
	               
	                calendar.fullCalendar('unselect');
	        
	               
	                        $this.dialog('close');
	                        $('#calendar').fullCalendar('refresh');
	                         $("#calendar_new_entry_form").remove();
	                         
	                         $("#loading img").ajaxStart(function(){
	                     		   $(this).show();
	                     		 }).ajaxStop(function(){
	                     		   $(this).hide();
	                     		 });    
	                    }

	               });
	              },
	             
	            
	             

	     
	            Cancel: function() {
	            //$event.remove();
	            $(this).dialog('close');
	            $dialogContent.remove();
	            }
	             	       
	            },
	            

	             close: function() {
	            $('#calendar').fullCalendar('removeUnsavedEvents');
	            $("#calendar_new_entry_form").remove();
	            }
      }).show();

	return false;
	
}	

/*******************************************************************************/
//function my_export(){
	
 function make_icsFile (){
/************************************************************************************************************/
	 
	 var userID=document.getElementById("userID").value; 
	   
	     
//	 	var url='/alon-web/olive_prj/admin/full_calendar/';
	 var url='../full_calendar/';
	 	 

	 	nocache = '&rnd='+Math.random();
	 	
	 	data=new Array();
 		data[0]='export';


var data1= data[0].toString();	 	
	 	
	 	
//document.location = url+"export.php";
document.location = url+"json-events3.php?action=export&userID=\'"+userID+"\'";
//document.location = url+"export.php?action=export&userID=\'"+userID+"\'";

	 	
	 	
//	 	$.ajax({//for loading img  
//			type: "GET",
//			url:url+'export.php',
//		  data:  "action="+ data1+ "&userID=" +userID ,
//			success: function(msg){
//			alert("aaaaaaaaa");
//			}
//	});	 	
	 	  
	 	
	 	
	 }//end function

	
/*******************************************************************************/
/****************************************************************************************/
/*********************************************************************************************/ 
/***********************************************************************************************/
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 function calendar_new_entry(calendar,start, end, allDay,calEvent) {
 	     
// 	var url='/alon-web/olive_prj/admin/full_calendar/';
	 var url='../full_calendar/';
 	nocache = '&rnd='+Math.random();

 	var ds=start, df=end;
 	            $('<div id="calendar_new_entry_form" title="הוסף ארוע חדש" style="text-align:center;"><br />'+
 	            				  		
 	            '<input value="Event" style="width:100%;" id="calendar_new_entry_form_title" type="text" /><br />'+
 	          //  '<input type="checkbox"  id="pizza" name="pizza" value="checked"  class="infobox" checked="check" ><br />כול היום<br />'+
 	            '<h3>כול היום</h3><input id="" type="checkbox"  checked="check"	/>'+
 	            '<h3>תאור הארוע</h3> '+
 	           
 	            '<textarea style="width:400px;height:200px" id="calendar_new_entry_form_body">event description</textarea></div>').appendTo($('body'));
 	           // console.log(allDay);  
 	           
 	            $("#calendar_new_entry_form").dialog({
 	            bgiframe: true,
 	            autoOpen: false,
 	            height: 440,
 	            width: 450,
 	            modal: true,
 	            buttons: {
 	            
 	            'Save':  function() {
 	            	 
 	            	$('#calendar_new_entry_form').find(':checkbox').each(function(){ 
 	          		  if($(this).is(':checked')) 
 	          		  { 
 	          		   allDay=true; 
 	          		  } else{
 	          			  allDay=false;
 	          		  }
 	          		 });   
 	            	//alert(allDay);
 	             var $this=$(this);   
 	              title=$('#calendar_new_entry_form_title').val();
 	              body=$('#calendar_new_entry_form_body').val();
 	             
 	                            
 	              $.ajax({
 	                 type: "POST",
 	                        url: url+"json-events3.php",
 	                        dataType: 'json',
 	                        data: {
 	                            // our hypothetical feed requires UNIX timestamps
 	                            action:'save',
 	                            title:title,
 	                            body:body,
 	                            start: Math.round(start.getTime() / 1000),
 	                            end: Math.round(end.getTime() / 1000),
 	                            allDay:allDay
 	                        },
 	                        success: function(json) {
 	                                 var  id=json[0].id;
 	                                 var  body=json[0].description;
 	                                 
 	                        
 	         
 	                if (json[0].title) {
 	                calendar.fullCalendar('renderEvent',
 	                	{
 	                	   id:id,	
 	                	   title: title,
 	                	    description:body,
 	                		start: start,
 	                		end: end,
 	                		allDay: allDay,
 	                		 height: 650
 	                	},
 	                	true // make the event "stick"
 	                 );
 	              } 
 	                
 	               
 	                calendar.fullCalendar('unselect');
 	        
 	               
 	                        $this.dialog('close');
 	                        $('#calendar').fullCalendar('refresh');
 	                         $("#calendar_new_entry_form").remove();
 	                         
 	                         $("#loading img").ajaxStart(function(){
 	                     		   $(this).show();
 	                     		 }).ajaxStop(function(){
 	                     		   $(this).hide();
 	                     		 });    
 	                    }

 	               });
 	              },
 	             
 	            
 	     
 	           
 	             

 	     
 	            Cancel: function() {
 	            //$event.remove();
 	            $(this).dialog('close');
 	            $("#calendar_new_entry_form").remove();
 	            }
 	             	       
 	            },
 	            

 	             close: function() {
 	            $('#calendar').fullCalendar('removeUnsavedEvents');
 	            $("#calendar_new_entry_form").remove();
 	            }
 	            });
 	            $("#calendar_new_entry_form").dialog('open');
 	            // events: url+"json-events3.php";
 	            } 

 /************************************************************************************************************/
 function calendar_edit_entry(event,element,calEvent,calendar, allDay){
    var title=event.title;
    var description=event.description ;
    var start=event.start;
     var end= event.end;
     var id=event.id;
// 	var url='/alon-web/olive_prj/admin/full_calendar/';
     var url='../full_calendar/';
 	if(!event.id)return;
 	var ds=calEvent.start, df=calEvent.end;
 	var allDay=event.allDay;

 	
 	
 /******************************************************/
 	 var $dialogContent = $("#event_edit_container");
      resetForm($dialogContent);
       var startField = $dialogContent.find("select[name='start']").val(event.start);
       var endField =  $dialogContent.find("select[name='end']").val(event.end);	
 	
       $dialogContent.find(".date_holder").text(event.start.getFullYear() + "-" + event.start.getMonth() + "-" + event.start.getDate());
      // setupStartAndEndTimeFields(startField, endField, event, $('#calendar').fullCalendar("getTimeslotTimes", event.start));
 	    $(window).resize(); //fixes a bug in modal overlay size ??
 /******************************************************/	
 	
 	
 	


 	
 	nocache = '&rnd='+Math.random();

 	
 	//$.getJSON(url+'ajax.php?deleteUser='+id+'&forum_decID='+forum_decID+nocache, function(json){
 	$.getJSON(url+'json-events3.php?action=get_event&id='+event.id+nocache,function(event){
 	
 		
 		$('<div id="calendar_edit_entry_form" title="ערוך ארוע"><h3>הארוע</h3><br />'+
 		'<input id="calendar_edit_entry_form_title" value="'+title+'" type="text"  style="width:100%;" />'+
 	 
 		 '<h3>כול היום'+
 		 
     '<form name="editevent" id="editevent">'+
//     '<form name="editevent" id="editevent'+ nocache  +'">'+
 	  '<SELECT name="my_sel"  id="my_sel" class="info_sel"  >'+
 	      ' <option value="0" >יום חלקי</option>'+
 	      '<option value="1" >כל היום</option>'+
 	    
 	  '</SELECT> '+
 	  
 		
 	
 	   
 	 '</form></h3>'+
    '<div id="event_edit_container">'+
 	 '<span>Date: </span>'+
 		'<span class="date_holder"></span>'+ 
 		'<h3>Start Time: </h3>'+
 		'<select name="start"><option value="">Select Start Time</option></select>'+
 		'<h3>End Time: </h3>'+
 		'<select name="end"><option value="">Select End Time</option></select>'+
 	'</div>'+	
 	'<textarea style="width:400px;height:200px" id="calendar_edit_entry_form_body">'+description+'</textarea></div>').appendTo($('body'));
 		
 		 	document.getElementById("my_sel").selectedIndex = allDay;// == true ? 1:0);
 		 	
 	 		
 		$("#calendar_edit_entry_form").dialog({
 			bgiframe: true,
 			autoOpen: false,
 			height: 440,
 			width: 450,
 			modal: true,
 			buttons: {

 			
 			'Save':  function() {
 		
 			 allDay=$('#my_sel').val(); 
 			
         	                       
             var $this=$(this);   
              title=$('#calendar_edit_entry_form_title').val();
              body=$('#calendar_edit_entry_form_body').val();
              end=end?end:start;
//              event.start = new Date(startField.val());
//              event.end = new Date(endField.val());
                            
              $.ajax({
                   type: "POST",
                        url: url+"json-events3.php",
                        dataType: 'json',
                        data: {
             	 
                            // our hypothetical feed requires UNIX timestamps
                            action:'save',
                            id:id,
                            title:title,
                            body:body,
                            description:description,
                            allDay: allDay,
                            start: Math.round(start.getTime() / 1000),
                            
                            end: Math.round(end.getTime() / 1000)
                        },
                        success: function(json) {
                               var  id=json[0].id;
                               var title=json[0].title;
                               
                               event.start =start;
                               event.end =end;
                               event.title = title;
                               event.body = body;
                               event. allDay= allDay;
                             
                               
                               
                               
                               if(event. allDay==1)
                             	  event. allDay=true;
                               else
                             	  event. allDay=false;
                              
                              
               	               
               	               
                               
                               
                                           
                 $('#calendar').fullCalendar('updateEvent', event);      
                        
                        $this.dialog('close');
                        $('#calendar').fullCalendar('refresh');
                      $('#calendar').fullCalendar('refetchEvents');
 /******************************************************************************************/
//                        $('#calendar').fullCalendar('removeEvents', function(event) {
//                     	   return event.id == id;
//                     	});
 /*****************************************************************************************/                       
                         $("#calendar_edit_entry_form").remove();
                           
 /****************************************************************************************/                        
                    }//end success
                 
               });//end ajx
             
              },//end function save 
     
 			
 				Cancel: function() {
 					$(this).dialog('close');
 					$("#calendar_edit_entry_form").remove();
 					 
 				}, 
 			
 /***************************************************************************************/		
          	מחק: function() {
 					if(confirm('בטוח שרוצה למחוק?')){
 						$('#calendar_edit_entry_form').remove();
 						$.getJSON(url+'json-events3.php?action=delete_event&id='+id,function(ret){
 							$('#calendar').fullCalendar('refresh');
 							$('#calendar').fullCalendar('removeEvents', function(event) {
 		                    	   return event.id == id;
 		                    	});
 						});
 					}
 				
 				}

 /******************************************************************************************/		
 		
 		},//end button
 			close: function() {
 			$dialogContent.dialog("destroy");
             $dialogContent.hide();	
 			$('#calendar').fullCalendar('removeUnsavedEvents');
 			$("#calendar_edit_entry_form").remove();
 			}
 			 
 		});//end dialog
 		$("#calendar_edit_entry_form").dialog('open');
 		
 			 
 	});//end get_json
 	 
 	
 	  
 	
 	
 }//end function

 /*******************************************************************************************************************/
 function calendar_move_entry(event, delta, minuteDelta, allDay){ 
 /***************************************************************************************************************/
// 	var url='/alon-web/olive_prj/admin/full_calendar/';
	 var url='../full_calendar/';
 	 event.end=event.end?event.end:event.start;
 	 
// 	 $.getJSON(url+'json-events3.php?action=move',
 //   {'title':event.title,'id':event.id,'start':event.start.getTime()/1000,'end':event.end.getTime()/1000,'delta':delta,'minuteDelta': minuteDelta,'allDay':event.allDay},null);
 	 nocache = '&rnd='+Math.random();
 		
 	 $.post(url+'json-events3.php?action=move'+nocache , {'title':event.title,'id':event.id,'start':event.start.getTime()/1000,'end':event.end.getTime()/1000,'delta':delta,'minuteDelta': minuteDelta,'allDay':event.allDay}, function(json){
 	}  , 'json');

 }

 
 
 
 
 
 
 
