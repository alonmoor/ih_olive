<?php 
require_once '../config/application.php';

html_header();
?> 
 
<fieldset id="diary_fieldset"   style="background: #94C5EB url(../images/background-grad.png) repeat-x;" >
<table>
<link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/fullcalendar.css"  />
<script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/fullcalendar.js"  type="text/javascript"></script>

     



<script type='text/javascript'>

$(document).ready(function() {
	
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		editable: true,
		events: [
			{
				title: 'All Day Event',
				start: new Date(y, m, 1)
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2)
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: new Date(y, m, d-3, 16, 0),
				allDay: false
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: new Date(y, m, d+4, 16, 0),
				allDay: false
			},
			{
				title: 'Meeting',
				start: new Date(y, m, d, 10, 30),
				allDay: false
			},
			{
				title: 'Lunch',
				start: new Date(y, m, d, 12, 0),
				end: new Date(y, m, d, 14, 0),
				allDay: false
			},
			{
				title: 'Birthday Party',
				start: new Date(y, m, d+1, 19, 0),
				end: new Date(y, m, d+1, 22, 30),
				allDay: false
			},
			{
				title: 'Click for Google',
				start: new Date(y, m, 28),
				end: new Date(y, m, 29),
				url: 'http://google.com/'
			}
		]
	});
	
});

	function calendar_new_entry(calEvent,$event){
		var ds=calEvent.start, df=calEvent.end;
		$('<div id="calendar_new_entry_form" title="New Calendar Entry">event name<br /><input value="ארוע חדש" id="calendar_new_entry_form_title" /><br />body text<br /><textarea style="width:400px;height:200px" id="calendar_new_entry_form_body">event description</textarea></div>').appendTo($('body'));
		$("#calendar").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 440,
			width: 450,
			modal: true,
			buttons: {
				'Save': function() {
					var $this=$(this);
					$.getJSON('./calendar1.php?action=save&id=0&start='+ds.getTime()/1000+'&end='+df.getTime()/1000,{
							'body':$('#calendar_new_entry_form_body').val(),
							'title':$('#calendar_new_entry_form_title').val()
						},
						function(ret){
							$this.dialog('close');
							$('#calendar_wrapper').weekCalendar('refresh');  
							$("#calendar_new_entry_form").remove();
						}
					);
				},
				Cancel: function() {
					$event.remove();
					$(this).dialog('close');
					$("#calendar_new_entry_form").remove();
				}
			},
			close: function() {
				$('#calendar').weekCalendar('removeUnsavedEvents');
				$("#calendar_new_entry_form").remove();
			}
		});
		$("#calendar_new_entry_form").dialog('open');
	}
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
 
<div id='calendar'></div>


</table>
</fieldset>  
<?php
 
html_footer();
?>
 