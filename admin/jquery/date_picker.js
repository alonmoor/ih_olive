 $(document).ready(function(){
	 
	           	$('#forum_date').datepicker( $.extend({}, {showOn: 'button',
		                               buttonImage: '../images/calendar.gif', buttonImageOnly: true,
		                               changeMonth: true,
				                       changeYear: true,
				                       showButtonPanel: true,
				                       buttonText: "Open date picker",
				                       dateFormat: 'yy-mm-dd', 
				                        altField: '#actualDate'


                                       }, $.datepicker.regional['he']));

//------------------------------------------------------------------------------
									 $('#brand_date').datepicker( $.extend({}, {showOn: 'button',
										 buttonImage: '../images/calendar.gif', buttonImageOnly: true,
										 changeMonth: true,
										 changeYear: true,
										 showButtonPanel: true,
										 buttonText: "Open date picker",
										 dateFormat: 'yy-mm-dd',
										 altField: '#actualDate'
									 }, $.datepicker.regional['he']));
                                      $( "#brand_date" ).datepicker( "setDate", new Date());
                                      $("#brand_date").datepicker({ defaultDate: new Date() });


         $('#brand_date2').datepicker( $.extend({}, {showOn: 'button',
             buttonImage: '../images/calendar.gif', buttonImageOnly: true,
             changeMonth: true,
             changeYear: true,
             showButtonPanel: true,
             buttonText: "Open date picker",
             dateFormat: 'yy-mm-dd',
             altField: '#actualDate'


         }, $.datepicker.regional['he']));
     // $( "#brand_date2" ).datepicker( "setDate", new Date());
     // $("#brand_date2").datepicker({ defaultDate: new Date() });

//------------------------------------------------------------------------------

     $('#dec_date').datepicker( $.extend({}, {showOn: 'button',
         buttonImage: '../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'


     }, $.datepicker.regional['he']));




//------------------------------------------------------------------------------

 $('#pdf_date').datepicker( $.extend({}, {showOn: 'button',
     buttonImage: '../images/calendar.gif', buttonImageOnly: true,
     changeMonth: true,
     changeYear: true,
     showButtonPanel: true,
     buttonText: "Open date picker",
     dateFormat: 'yy-mm-dd',
     altField: '#actualDate'


 }, $.datepicker.regional['he']));




//------------------------------------------------------------------------------
     $('#appoint_date1').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd' ,
         altField: '#actualDate'
     }, $.datepicker.regional['he']));






//------------------------------------------------------------------------------

     $('#manager_date').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));




//------------------------------------------------------------------------------

     $('#duedate3').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));





//------------------------------------------------------------------------------

     $('#past_duedate5').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));





//------------------------------------------------------------------------------

     $('#past_duedate6').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));




//------------------------------------------------------------------------------
     $('#duedate4').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));

//-------------------------------------------------------------------------------
     $('#dec_usr_duedate_start').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));
//------------------------------------------------------------------------------
     $('#dec_usr_duedate_end').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));

//----------------------------------------------------------------------------

 });//end jquery


