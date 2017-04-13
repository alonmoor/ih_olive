
$(document).ready(function() { 
	$('form#my_real_form').show();
	 $('form#my_win_form').hide();
	 //$("h6[class^=my_usr_frm_2]").hide();
	 
	  showhide($("h6[class^=my_usr_frm_2]"),$("h5[class^=my_usr_frm]"));
	// showhide($("#my_usr_frm_content_2"),$("#my_usr_frm_content"));
	 
	 //my_decfrm_content2502
 // $('my_tmp_div').remove();
///******************************************************************************/
//	$("a[class^=href_modal2]").bind('click',function(){
//		$('#nav2').remove();	
// 
//		var id=$(this) .attr('id') ;
//
//		 var url='../admin/';
//		 $.ajax({
//			   type: "POST",
//			   url: url+"ajax2.php",
//			   dataType: 'json',
//			   data: "rowCount="+id,
//			   success: function(data){
//
///************************************************************************/	 
//			 if(data.total>1){
//				$('#nav2').html(' '); 
// 				 $('#ajaxbox.dhtmlwindow').pager('li', {
//					   navId: 'nav2',
//					  height: '15em' 
//					 });
//				$('#nav2').draggable();
//				
//				 
//
//				var $clonedCopy = $('#my_resulttable_0').clone();
//				$('#first_li').css("display", "inline");
//				 
//
//				$('a.my_paging').not(document.getElementById('my_paging1')).bind('click', function() {
//					   
//					   $('#my_resulttable_0').css({'position':'relative','overflow':'hidden'}).html(' ');
//					 });
//
//				 
//
//					 $('#my_paging1').bind('click', function() {
//						$('#first_li').css("display", "inline");
//						$('#my_resulttable_0').html(' ');  
//					      $('#my_resulttable_0').append ($clonedCopy);
//				      });//end#my_paging1
//			     }//end if total 
//		  
//		    }//end success
//		 
//		}); 
//		 $('#nav2').html(' ');
//		 return false;
//	});//end click	
///*******************************************************************************************/	
//	 $('.page-number').not($('#page_0')).bind('click', function() {
//		   
//		   $('#my_resulttable_0').hide();
//		  
//		 });				 
//	 
//	 
//
//$('#page_0').bind('click', function() {
//	   
//	   $('#my_resulttable_0').show();
//	  // $('#first_li').hide();	
//	 });				
/****************************END NAV2********************************************************/		 	 
$('form#edit_search1').find('select#search_type1').change(function(){
	var editID=( $('#search_type1').val());  
 
	 
	$.ajax({  
	   type: "POST",
	   url: "find3.php",
	   data: "search_type="+editID,
	   success: function(msg){
		//alert(document.getElementById("search_type2").value); 		 		 
	     
	   	document.getElementById("search_type2").value=document.getElementById("search_type1").value;
	   }
	 });
	
	
	
});	 
 
/****************************TOOLTIP2************************************************************************/
$("body").append("<div id='ToolTipDiv'></div>");
$("#ToolTipDiv").css({'z-index': '101'});
$("a[title_dec]").each(function() {
  $(this).hover(function(e) {
	  
    $().mousemove(function(e) {
      var tipY = e.pageY + 16;
      var tipX = e.pageX - 856;
      $("#ToolTipDiv").css({'top': tipY, 'right': tipX});
    });
    $("#ToolTipDiv").stop(true, true).slideToggle();
 
    $("#ToolTipDiv")
      .html($(this).attr('title_dec'))
      .fadeIn("fast");
    $(this).removeAttr('title_dec');
  }, function() {
    $("#ToolTipDiv").stop(true, true).slideToggle();
 
    $("#ToolTipDiv").fadeOut("fast");
    $(this).attr('title_dec', $("#ToolTipDiv").html());
  });
});

/************************************************************************************************/		  
//	 $('a.href_modal1').css({'background':'#B4D9D7'}).bind('click', function() {
//		var link=$(this).attr('href') ;	 
//     	var	popup_window = openmypage(link); 
//     	
//		 //openmypage(link);
//		 //openWin(link);
//		
//				
//       return false;
//	 });
/******************************************************************************************/	  
	
//      $('#my_closeButton').bind('click',function(){
//      alert("dddddddddd");
//	  
//		 delobjs('/alon-web/olive_prj/admin/js/find.js') ;
//			
//     
//
//     function delobjs(){
//     	 
//     	
//     	 
//     	if (x.fileref!=""){
//     		
//     	document.getElementsByTagName("head").item(0).removeChild(x.fileref)
//     	 
//     	}
//     	}
//    	  function removeA()
//    	  {
//    		var parentEl = document.getElementById('my_header');
//    	  	parentEl.removeChild(parentEl.childNodes[163] );
//    	  }
//
//    	  removeA();

// 	 	 });  	 
/*********************************************************************************************/
// $('a.href_modal3').css({'background':'#B4D9D7'}).bind('click', function() {
//	 
// 		  	var link=$(this).attr('href') ;
// 		   	 openmypage3(link); 
//			return false;
//  });



//$('.my_find_history h3').addClass('link').click(function() {
//	 
//$(this).parent().find('div#history_content').slideToggle();
//$(this).parent().find('.history_content').slideToggle();   
//});


/*********************************DATEPICKER*********************************************************/
                      
    $('#date1').datepicker( $.extend({}, {showOn: 'button',
         buttonImage:'../images/calendar.gif', buttonImageOnly: true,
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         buttonText: "Open date picker",
         dateFormat: 'yy-mm-dd',
         altField: '#actualDate'}, $.datepicker.regional['he']));   
    
    
/*****************************TOGGLE_DECISION_CARD****************************************************/    
    
    
    if( ($("#count_info1").val() ) ){
    	 
    	for(var i=0;i<$("#count_info1").val();i++){
    		//$("h5.my_main_dec"+i).hide();
       	 
          	 $(".my_main_dec_2"+i).addClass('link'); 
          	 $(".my_main_dec_2"+i).toggle( 
          	  function(){ 
          	  
          	     
          	    $(this).addClass('hover');
          	      $("#first_li"+i).slideToggle();
          	  },  
          	  function(){ 
          	    $(this).removeClass('hover'); 
          	   $("#first_li"+i).slideToggle();
          	  } 
          	 );   	    
    			 
    		
    		  }
    		 }
     
     
    
 
/*****************************TOGGLE_DECISION_FOR_USERS****************************************************/
 
 if( ($("#count").val() ) )
{
     //var forum_decID='';
for(var i=0;i<$("#count").val();i++){
	var  forum_decID =$("#frmID"+i).val();// document.getElementById('frmID').value;
create_toggle(forum_decID); 

   }
  }
 
function create_toggle(forum_decID){
	//if( ($('#my_closeButton').bind('click',function(){) )){
       
	//}else{
//	$('.my_decision'+forum_decID+' h3').click(function() {
//	    $(this).parent().find(".my_decision_content"+forum_decID).slideToggle();
//	  });	
	 $(".my_decision"+forum_decID).css({'cursor':'pointer'}).addClass('link'); 
	 $(".my_decision"+forum_decID).toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#my_decision_content"+forum_decID).slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#my_decision_content"+forum_decID).slideToggle();
	  } 
	 );   	   
	//}

	 	
}
/*****************************TOGGLE_DECISION_FOR_MANY_FORUMS****************************************************/
if( ($("#count").val() ) ){
   
for(var i=0;i<$("#count").val();i++){
	var  frm_decID1 =$("#my_Forum_decision"+i).val();// document.getElementById('frmID').value;
create_ManyForumToggle(frm_decID1); 

  }
 }

function create_ManyForumToggle(forum_decID){
	
	 $(".my_Forum_decision_2"+forum_decID).css({'cursor':'pointer'}).addClass('link');
	  $(".my_Forum_decision"+forum_decID).hide();
	 $(".my_Forum_decision_2"+forum_decID).toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#my_Forum_decision_content_2"+forum_decID).slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#my_Forum_decision_content_2"+forum_decID).slideToggle();
	  } 
	 );   	   		 	
}

/*****************************TOGGLE_DECISION_FOR_rel_Decuser_forum****************************************************/

if( ($("#count").val() ) )
{
   
for(var i=0;i<$("#count").val();i++){
	var  frm_decID_dec =$("#my_Dec_user_frm"+i).val();// document.getElementById('frmID').value;
create_Decuser_frmToggle(frm_decID_dec); 

  }
 }

function create_Decuser_frmToggle(frm_dec){
	
	 $(".my_Dec_user_2"+frm_dec).css({'cursor':'pointer'}).addClass('link');
	  $(".my_Dec_user"+frm_dec).hide();
	 $(".my_Dec_user_2"+frm_dec).toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#my_Dec_user_frm_content_2"+frm_dec).slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#my_Dec_user_frm_content_2"+frm_dec).slideToggle();
	  } 
	 );   	   
		 	
}

/********************************************TOGGLE_FORUM_DECISION*************************************************/

 
var  frm_decID2 =$("#frm_decID").val();
create_Frmtoggle(frm_decID2); 

 

function create_Frmtoggle(forum_decID){

	 $(".my_decfrm_2"+forum_decID).css({'cursor':'pointer'}).addClass('link'); 
	 $(".my_decfrm"+forum_decID).hide();
	 $(".my_decfrm_2"+forum_decID).toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#my_decfrm_content_2"+forum_decID).slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#my_decfrm_content_2"+forum_decID).slideToggle();
	  } 
	 );   	   
	
}
/********************************************TOGGLE_SINGLE_FORUM_DECISION*************************************************/
$(".my_dec_frm").hide();
$(".my_dec_frm_2").css({'cursor':'pointer'}).addClass('link'); 
 $(".my_dec_frm_2").toggle( 
  function(){ 
  
     
    $(this).addClass('hover');
     $("#my_dec_frm_content_2").slideToggle();
  },  
  function(){ 
    $(this).removeClass('hover'); 
   $("#my_dec_frm_content_2").slideToggle();
  } 
 );  
 /********************************************TOGGLE_USERS_from_SINGLE_CHOOSE_ FORUM*************************************************/
 $(".my_usr_frm_2").css({'cursor':'pointer'}).addClass('link'); 
 $(".my_usr_frm_2").toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#my_usr_frm_content_2").slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#my_usr_frm_content_2").slideToggle();
	  } 
	 );   	   
	
 
 
/********************************************TOGGLE_USERS_MANY_FORUM*************************************************/

   
	if( ($("#count_forum").val() ) ){
	    
	for(var i=0;i<$("#count_forum").val();i++){
		var  forum_decID =$("#my_usr_frm"+i).val();//$("input[id^=past_usr_frm]").val();// document.getElementById('frmID').value;
		$(".my_usr_frm"+forum_decID).hide();
	    create_Forumtoggle(forum_decID); 
	
	  }
	 }
 

	
	
/*
 if( ($("#count_forum").val() ) &&   !($("#count_forum").val() )=== 'single'){
     
 for(var i=0;i<$("#count_forum").val();i++){
 	var  forum_decID =$("#my_usr_frm"+i).val();//$("input[id^=past_usr_frm]").val();// document.getElementById('frmID').value;

 	
 	$(".my_usr_frm_2"+forum_decID).hide();
     create_Forumtoggle(forum_decID); 
    
   }
  
  } else if( ($("#count_forum").val() )==='single' ){
 	 $(".my_usr_frm_2").hide();
 	 var str='';
 	 create_Forumtoggle(str); 
 	 
  }
	
*/	
	
	
	
	

	   function create_Forumtoggle(forum_decID){
	   	 $(".my_usr_frm_2"+forum_decID).css({'cursor':'pointer'}).addClass('link'); 	
	   		
	      $(".my_usr_frm_2"+forum_decID).toggle( 
	   	  function(){ 
	   	  
	   	     
	   	    $(this).addClass('hover');
	   	     $("#my_usr_frm_content_2"+forum_decID).slideToggle();
	   	  },  
	   	  function(){ 
	   	    $(this).removeClass('hover'); 
	   	   $("#my_usr_frm_content_2"+forum_decID).slideToggle();
	   	  } 
	   	 
	   	 );   	   
	      return false;
	   }

	   
	   

	   
/********************************************TOGGLE_PAST_USERS_FORUM_DECISION*************************************************/
	   if( ($("#count_info").val() ) ){
			for(var i=0;i<$("#count_info").val();i++){
				if( ($("#cntFrm").val() ) ){
				    
				for(var j=0;j<$("#cntFrm").val();j++){
					var  forum_decID =$("#past_usr_frm"+i+j).val();//$("input[id^=past_usr_frm]").val();// document.getElementById('frmID').value;
				
				    create_Dectoggle(forum_decID); 
				
				  }
				 }
		 
		     }
		  }	
	   
	   
	   
//	   var i=0;
//	   var j=0;
//	   var k=0;
//var decID=	   document.getElementById('decID').value;
//if( ($("#count_info").val() ) ){
//	for( i;i<$("#count_info").val();i++){
//		if( ($("#cntFrm"+decID+i).val() ) ){
//		    
//		for(j;j<$("#cntFrm"+i).val();j++){
//			var  forum_decID =$("#past_usr_frm"+i+j).val();//$("input[id^=past_usr_frm]").val();// document.getElementById('frmID').value;
//		
//		    create_Dectoggle(forum_decID); 
//		
//		  }
//		 }
// 
//     }
// }
 
    

   function create_Dectoggle(forum_decID){
	  
	$("h5.my_Past_usr_frm"+forum_decID).hide();
	 
   	 $(".my_Past_usr_frm_2"+forum_decID).addClass('link'); 
   	 $(".my_Past_usr_frm_2"+forum_decID).toggle( 
   	  function(){ 
   	  
   	     
   	    $(this).addClass('hover');
   	      $("#my_Past_usr_frm_content_2"+forum_decID).slideToggle();
   	  },  
   	  function(){ 
   	    $(this).removeClass('hover'); 
   	   $("#my_Past_usr_frm_content_2"+forum_decID).slideToggle();
   	  } 
   	 );   	   
	   
     
   	
   }

/********************************************TOGGLE_USERS_FORUM_AFTER_SEARCH_DECISION*************************************************/
   $(".my_usr_frmDec").hide();
   $(".my_usr_frmDec_2").css({'cursor':'pointer'}).addClass('link'); 
   $(".my_usr_frmDec_2").toggle( 
    function(){ 
    
       
      $(this).addClass('hover');
       $("#my_usr_frmDec_content_2").slideToggle();
    },  
    function(){ 
      $(this).removeClass('hover'); 
     $("#my_usr_frmDec_content_2").slideToggle();
    } 
   );   
   
   
   
/***************************************************************************************************************/   
/***************************************************************************************************************/   
 if(!( ($('#appoint_history_hidden_app').val() ) || ($('#appoint_history_hidden_mgr').val() ) || ($('#appoint_history_hidden_usr').val() ) ) ){
	$('#my_history_fieldset_app').hide(); 
 }  
/****************************TOGGLE_APPOINT_HISTORY***************************************************/
	 
	$(".my_appoint_find_history").hide();
	$(".my_appoint_find_history_2").css({'cursor':'pointer'}).addClass('link'); 
	 $(".my_appoint_find_history_2").toggle(
					 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#appoint_history_content_2").slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#appoint_history_content_2").slideToggle();
	  } 
	 );
	 
	 
	 
	 
/***************************************************************************************************************/	 
/***************************************************************************************************************/   
	 if( !(($('#manager_history_hidden_app').val() ) || ($('#manager_history_hidden_mgr').val() ) || ($('#manager_history_hidden_usr').val() ) )){
		$('#my_history_fieldset_mgr').hide(); 
	 }  	 
/****************************TOGGLE_MANAGER_HISTORY***************************************************/
	 $(".my_mgr_find_history").hide();
	 $(".my_mgr_find_history_2").css({'cursor':'pointer'}).addClass('link'); 
	 $(".my_mgr_find_history_2").toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#mgr_history_content_2").slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#mgr_history_content_2").slideToggle();
	  } 
	 );
	 
 	
/***************************************************************************************************************/	 
/***************************************************************************************************************/   
 if( !( ($('#user_history_hidden_app').val() ) || ($('#user_history_hidden_mgr').val() ) || ($('#user_history_hidden_usr').val() )) ){
      $('#my_history_fieldset_usr').hide(); 
 }  	 	 
/****************************TOGGLE_USER_HISTORY***************************************************/
	 $(".my_user_find_history").hide();
	 $(".my_user_find_history_2").css({'cursor':'pointer'}).addClass('link'); 
	 $(".my_user_find_history_2").toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#user_history_content_2").slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#user_history_content_2").slideToggle();
	  } 
	 );   	   
 
/********************************************************************************************************/   


   
///////////////////////////////////////////////////////////

// $(".my_decision3").addClass('link'); 
// $(".my_decision3").toggle( 
//  function(){ 
//  
//     
//    $(this).addClass('hover');
//     $("#my_decision_content3").slideToggle();
//  },  
//  function(){ 
//    $(this).removeClass('hover'); 
//   $("#my_decision_content3").slideToggle();
//  } 
// );  


/*********************************************************/	  
//	  $(".my_decision").addClass('link'); 
//	 $(".my_decision").toggle( 
//	  function(){ 
//	  
//	     
//	    $(this).addClass('hover');
//	     $("#my_decision_content").slideToggle();
//	  },  
//	  function(){ 
//	    $(this).removeClass('hover'); 
//	   $("#my_decision_content").slideToggle();
//	  } 
//	 );   	   

/*****************************load task to find engin****************************************************/
if(!($('#decID').val()==undefined))
var decID= document.getElementById('decID').value;
if(!($('#forum_decID').val()==undefined))
var forum_decID= document.getElementById('forum_decID').value;
if(!($('#prog_bar').val()==undefined))
var prog_bar= document.getElementById('prog_bar').value; 

 $("#page_taskedit_dlg"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
//$('#page_taskedit_dlg'+decID+forum_decID).draggable();
//$('#my_dlgtd').draggable();



//var val =prog_bar;//$(this).progressbar("option", "value");
//
//  if(val <=100) {
//    //show new value
//    ($("#value").length === 0) ? $("<span>").text(val + "%").attr("id", "value")
//     .css({ float: "right", marginTop: -28, marginRight:10 })
//     .appendTo("#progress"+decID+forum_decID) : $("#value").text(val + "%");
//     
//  } 


// var progressOpts = {
//         change: function(e, ui) {
//            
//   	
// 
//         var val =prog_bar;//$(this).progressbar("option", "value");
//       
//           if(val <=100) {
//             //show new value
//             ($("#value").length === 0) ? $("<span>").text(val + "%").attr("id", "value")
//              .css({ float: "right", marginTop: -28, marginRight:10 })
//              .appendTo("#progress"+decID+forum_decID) : $("#value").text(val + "%");
//              
//           } 
//       	
//         }
//       };
//    
//      // $("#progress"+decID+forum_decID).progressbar(progressOpts);
//        $('#progress'+decID+forum_decID).progressbar("option", "value",prog_bar);
/*******************************************************************************************/	 	 		
	 	 
 	    var options = { 
 	        
 	         beforeSubmit:  showRequest,  // pre-submit callback 
 	         
 	         success:  processJson,
 	         dataType: 'json'
 	     }; 
 	  
 	     
 	     $('#find_form').ajaxForm(options); 
 	    
 	  function showRequest(formData, jqForm) { 
 	     
 	  var extra = [ { name: 'json', value: '1' }];
 	  $.merge( formData, extra);
 	   
 	     return true;  
 	 } 

 	  
 	 function processJson(data) {
 	 	 
 	 var countyList = '';
 	 

 	      
 	  $.each(data, function(i){
 	 		 
 	 	  countList += '<li><a href="../admin/find3.php?forum_decID='+data.forum_decision+'"  class="maplink" >'+data.forum_decName+'</a></li>';
 	 		
 	  });

 	  $('#targetDiv').html('<ul id="countyList">'+countyList+'</ul>').find('a.maplink').click(function(){
 	 	 var index = $('a.maplink').index(this);
 	
 	 	 return false;
 	 	  });
 	 }//end proc

 	 
 	 $('form#find_form fieldset').find('select#forum_decision').change(function(){
 	 $.ajax({
 	    type: "POST",
 	    url: "find3.php",
 	    data: "forum_decision="+this.value,
 	    success: function(msg){
 	 $('div#targetDiv').html(' ').append('<p>'+msg+'</p>');
 	    }
 	  });
 	 });
///************************************************************************************************/ 
 	 
 	 $('.td_color1').css('width','20%');
 	 turn_red_task();	
 	 
/**************************************TOOLTIP2***********************************************************/  
$(".'menu2 a.my_decLink' ").append("<em></em>");



if($('.table_num').val()==0){
	 $('#my_resulttable_0').find('.my_decLink').find('em').remove();//.css('border','3px solid red');//remove();
// $('#my_resulttable_0').find('.my_decLink').removeClass('my_decLink').addClass('tooltip_find');
//	 $('<span > <em> </em></span>').appendTo($('.tooltip_find'));
	
		$('#my_resulttable_0').find('.my_decLink').removeClass('my_decLink').addClass('tTip');
	
} 

 $('.tTip').betterTooltip({speed: 150, delay: 300});




//echo "
//<a class='tooltip_find' href='#'>
//		 ?<span class='custom critical'>
//		 
//		 
//		 <em>?</em>החלטות שקשורות להחלטות שבאו בעקבותיהם!
//		  
//		 </span>
//	</a> ";	






$(".menu2 a").hover(function() {

	$(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
		var hoverText = $(this).attr("title");
	    $(this).find("em").text(hoverText);
    	}, function() {
	$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");

});



 

// $(".menu3 a").append("<em></em>");
//$(".menu3 a").hover(function() {
//   	
//	$(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
//		var hoverText = $(this).attr("title");
//	    $(this).find("em").text(hoverText);
//    	}, function() {
//	$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");
//	
//});


 


$(".menu4 a.my_decLink_root").append("<em></em>");

$(".menu4 a").hover(function() {

$(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
	var hoverText = $(this).attr("title");
    $(this).find("em").text(hoverText);
	}, function() {
$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");

});







//$("#my_resulttable_0 a.my_decLink").css('border', '3px solid red');
//	$(".menu2 a").hover(function() {
//		$(this).find("em").css('border', '3px solid red');//.animate({opacity: "show", top: "-75"}, "slow");
//		var hoverText = $(this).attr("title");
//	    $(this).find("em").text(hoverText);
//	}, function() {
//		$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");
//	});

	
 //$("#my_resulttable_0 a.my_decLink").append("<em></em>");	
//	$("#my_resulttable_0 a").hover(function() {
//		$(this).find("em").show();//.animate({opacity: "show", bottom: "-75"}, "slow");
//		var hoverText = $(this).attr("title");
//	    $(this).find("em").text(hoverText);
//	}, function() {
//		$(this).find("em").hide();//.animate({opacity: "hide", bottom: "-85"}, "fast");
//	});	
	
//$('li').prepend("#my_resulttable_0");//.prepend('li');
//$(".menu2").find('table#').append("<em></em>");	
//	
//$(".menu2 a").hover(function() {
//$(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
//var hoverText = $(this).attr("title");
//$(this).find("em").text(hoverText);
//}, function() {
//$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");
//});
	
	
	
	
	// my_resulttable_0
	
/*	
	
$(".my_Find_tr a").append("<em></em>");
	
	$(".my_Find_tr a").hover(function() {
		$(this).find("em").css('display', 'block').css('overflow', 'hidden').animate({opacity: "show", top: "-75"}, "slow");
		var hoverText = $(this).attr("title");
	    $(this).find("em").text(hoverText);
	}, function() {
		$(this).find("em").css('display', 'block').animate({opacity: "hide", top: "-85"}, "fast");
	});
*/	
	
	
	
	
// 	function prepareLinkBox(id,url,full_name)	{ 
// 		 
// 		return '<span><a id="fullcalendar-link'+id+'"  class="iframe_user"  onMouseOver="link_over('+id+')"  onClick="makeBox('+id+', \''+full_name+'\',\''+url+'\' );" >פתח יומן אישי</a></span>';
// 		} 
//
// 		 
//
//
//
//
//
// 			function makeBox(id,full_name,url){
// 				 
// 
//
// 				var link= '../admin/full_calendar/insert_ajx4.php?userID='+id+''; 
// 				// openmypage(link);
// 				opengoog(link,full_name);
//
// 		 	
// 			}
// 		//////////////////////////////////////////////////
// 		function opengoog(url,full_name){
// 			var googlewin=dhtmlwindow.open("googlebox", "iframe", url, full_name+" -יומן אישי", "width=950px,height=800px,left=100px,top=100px,resize=1,scrolling=1", "recal")
//
// 			googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
// 			return true;
// 			}
//
// 		}
// 		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 
 /*********************************************************************************************/
         
   	  $("#loading img").ajaxStart(function(){
  	    $(this).show();
  	  }).ajaxStop(function(){
  	    $(this).hide();
  	  });
 
         
         
});//end DCR  

 
  

