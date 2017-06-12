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





     $(function() {
         $.datepicker.regional['he'] = {
             closeText: 'סגור',
             prevText: '&#x3c;הקודם',
             nextText: 'הבא&#x3e;',
             currentText: 'היום',
             monthNames: ['ינואר','פברואר','מרץ','אפריל','מאי','יוני',
                 'יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר'],
             monthNamesShort: ['1','2','3','4','5','6',
                 '7','8','9','10','11','12'],
             dayNames: ['ראשון','שני','שלישי','רביעי','חמישי','שישי','שבת'],
             dayNamesShort: ['א\'','ב\'','ג\'','ד\'','ה\'','ו\'','ש\''],
             dayNamesMin: ['א\'','ב\'','ג\'','ד\'','ה\'','ו\'','ש\''],
             weekHeader: 'Wk',
             dateFormat: 'dd/mm/yy',
             firstDay: 0,
             isRTL: true,
             showMonthAfterYear: false,
             yearSuffix: ''
         };
         $.datepicker.setDefaults($.datepicker.regional['he']);

         $('#brand_date2').datepicker();
     });

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


