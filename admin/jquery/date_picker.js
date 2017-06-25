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


     // $(document).ready(function () {
     //     $('#brand_date2').datepicker({
     //         format: "dd/mm/yyyy"
     //     });
     // });
//------------------------------------------------------------------------------------























































         // $('#brand_date2').datepicker( $.extend({}, {showOn: 'button',
         //     buttonImage: '../images/calendar.gif', buttonImageOnly: true,
         //     changeMonth: true,
         //     changeYear: true,
         //     showButtonPanel: true,
         //     buttonText: "Open date picker",
         //     dateFormat: 'yy-mm-dd',
         //     altField: '#actualDate'
         // }, $.datepicker.regional['he']));


     // $('#brand_date2').datetimepicker({
     //
     //     format : "dd/MM/yyyy hh:mm",
     //
     // });


  //   $('#datepicker3').datepicker();



     var date = new Date();
     var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
     var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());

     $('#datepicker1').datepicker({
         format: "mm/dd/yyyy",
         todayHighlight: true,
         startDate: today,
         endDate: end,
         autoclose: true
     });
     $('#datepicker2').datepicker({
         format: "mm/dd/yyyy",
         todayHighlight: true,
         startDate: today,
         endDate: end,
         autoclose: true
     });

     $('#datepicker1,#datepicker2').datepicker('setDate', today);



     $('#date').datetimepicker({
         pickTime: false,
         icons: {
             time: "fa fa-clock-o",
             date: "fa fa-calendar",
             up: "fa fa-arrow-up",
             down: "fa fa-arrow-down"
         },
         minDate: moment()
     });







    /*
     $('#datetimepicker1').datetimepicker();

     $('#brand_date2').datepicker({
     format: "yyyy/mm/dd",
     startDate: "2012-01-01",
     endDate: "2015-01-01",
     todayBtn: "linked",
     autoclose: true,
     todayHighlight: true
     });

     ------------------------------------------------------------------------------------
     $( "#brand_date2" ).datepicker( "setDate", new Date());
     $("#brand_date2").datepicker({ defaultDate: new Date() });
     */





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


