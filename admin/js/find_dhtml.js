 var keep_i={};
 var zIndexvalue_obj={}; 
 zIndexvalue_obj.zindex= 5000;  
$(document).ready(function() { 
	$('#first_li').hide();	
  
	$('#my_find_ol').css('list-style','none');	
		
	$('.my_task_img').bind('click',function(){
 		var url='401.php';

 		$(location).attr('href',url); 
	 }); 
			
	
	
	$('.my_tree_img').bind('click',function(){
 		var url='401.php';

 		$(location).attr('href',url); 
	 }); 
/*******************************************************************************************************************/	
	
		 $('#first_li').hide();	
		
	  $('#nav2').remove();
 
 	if($('#count_my_decID').val()){ 
      var count_decID=$('#count_my_decID').val();
 	}
 	if($('#count_my_forum_decID').val()){
      var  count_forum_decID=$('#count_my_forum_decID').val(); 
 	}
 	
if(count_forum_decID && count_decID){
	if(count_forum_decID > count_decID)
		var count=count_forum_decID;
	 if(count_forum_decID < count_decID)	
			var count=count_decID;
	 if(count_forum_decID == count_decID)	
			var count=count_decID;
} else	
 	
 	 var count=count_forum_decID?count_forum_decID:count_decID;	

  if(count)  { 		 
	 
 		 if(count>1 && ($('#my_task_view').val()==undefined) ){
	 
	 				 $('#ajaxbox.dhtmlwindow').pager('li', {
					      navId: 'nav2',
						  height: '15em' 
						 });
					$('#nav2').draggable();
			         
					 
				 
					// $('div[id^=my_dec_tree]').hide();
					 $('#first_li0').hide();				 
						 
						 $('a.my_paging').not($('#my_paging1')).bind('click', function() {
                      
							 
							 if(!($('input[id^=my_entry_ajx_hidden]').val())) { 
								 $('#my_resulttable_0').hide();
							 }		 
                             $('div[id^=my_entry_ajx]').remove();
							   
							   
							   if($('a.my_paging').attr('rel') == 'prev'  &&  keep_i.num===0) {
								 
								   if(!($('input[id^=my_entry_ajx_hidden]').val()))
									 $('#my_resulttable_0').show();
								 
									   $('#first_li').hide();	
									   keep_i.num='';
								}
							   
							   var zIndexvalue =zIndexvalue_obj.zindex;// $('#ToolTipDiv_find').css("z-index");
							    zIndexvalue++;
							   zIndexvalue_obj.zindex=zIndexvalue;
							 $('#ToolTipDiv_find').css('z-index',   zIndexvalue_obj.zindex);
							   
							   
							 });				 
						 
						 
					
					$('a#my_paging1').bind('click', function() {//press the first page
						
						 
						   $('#my_resulttable_0').show();
						   
						   $('#first_li').hide();	
						   
						   var zIndexvalue =zIndexvalue_obj.zindex;// $('#ToolTipDiv_find').css("z-index");
						    zIndexvalue++;
						   zIndexvalue_obj.zindex=zIndexvalue;
					 $('#ToolTipDiv_find').css('z-index',   zIndexvalue_obj.zindex);
						   
						 });				
					
					
					
					
					
				     }//end if count 

 }		 
		 			
/***********************************************END_DEALING_HREF****************************************************************/	  
 	 
		 $('form#edit_search1').find('select#search_type1').change(function(){//for page_workimg set  
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
		 $("body").append("<div id='ToolTipDiv_find' class='location'></div>");
		 $("a[mode]").each(function() {
		   $(this).hover(function(e) {
		     $().mousemove(function(e) {
		       var tipY = e.pageY + 16;
		       var tipX = e.pageX - 16;
		       $("#ToolTipDiv_find").css({'top': tipY, 'right': tipX});
		     });
		     $("#ToolTipDiv_find").stop(true, true).slideToggle();
		     $("#ToolTipDiv_find")
		       .html($(this).attr('mode'))
		       .fadeIn("fast");
		     $(this).removeAttr('mode');
		   }, function() {
		     $("#ToolTipDiv_find").stop(true, true).slideToggle();
		     $("#ToolTipDiv_find").fadeOut("fast");
		     $(this).attr('mode', $("#ToolTipDiv_find").html());
		   });
		 });

/************************************************************************************************/
		 $('#ToolTipDiv_find')  .css('position',   'absolute')
		   .css('top', '100px')
		  .css('left',  '100px')
		   .css('height', '400px')
		  // .css('border',   '2px solid #FF0000')
		   .css('border',   '1px solid black')
		   .css('background-color',   '#FF9999')
		   .css('width',   '60%')
		   .css('display',   'none')
		   .css('padding',   '3px')
		   .css('text-align',  'right')
		   .css('z-index',   zIndexvalue_obj.zindex)
		  
 
		   .css('filter',' progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135)'); 
			
			 

			 
/*****************************TOGGLE_DECISION_FOR_USERS****************************************************/
 
 if( ($("#count").val() ) )
{

for(var i=0;i<$("#count").val();i++){
	var  forum_decID =$("#frmID"+i).val();
create_toggle(forum_decID); 

   }
  }
 
function create_toggle(forum_decID){
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
	

	 	
}
/*****************************TOGGLE_DECISION_FOR_MANY_FORUMS****************************************************/

if( ($("#count").val() ) )
{
   
for(var i=0;i<$("#count").val();i++){
	var  frm_decID1 =$("#my_Forum_decision"+i).val();
	 $(".my_Forum_decision_2"+frm_decID1).hide();
   create_ManyDecForumToggle(frm_decID1);
 
  }

 }


function create_ManyDecForumToggle(forum_decID){
	
//   $('.my_Forum_decision'+forum_decID).removeClass().addClass('my_Forum_decision_find'+forum_decID);
//	$('#my_Forum_decision_content'+forum_decID).attr("id",'my_Forum_decision_content_find'+forum_decID);		
	
	 $(".my_Forum_decision"+forum_decID).addClass('link').css({'cursor':'pointer'}); 
	
	 $(".my_Forum_decision"+forum_decID).toggle( 
	  function(){
		 
		  
	    $(this).addClass('hover');
	     $("#my_Forum_decision_content"+forum_decID).slideToggle();
		 
	  },  
	  function(){
		 
		 
	    $(this).removeClass('hover'); 
	   $("#my_Forum_decision_content"+forum_decID).slideToggle();
	   
	  } 
	 );   	   
	 return false;
}
/********************************************TOGGLE_USERS_MANY_FORUM*************************************************/


if( ($("#count_forum").val() ) ){
    
for(var i=0;i<$("#count_forum").val();i++){
	var  forum_decID =$("#my_usr_frm"+i).val();//$("input[id^=past_usr_frm]").val();// document.getElementById('frmID').value;

	
	$(".my_usr_frm_2"+forum_decID).hide();
    create_Forumtoggle(forum_decID); 
   
  }
 
 }

 
  

   function create_Forumtoggle(forum_decID){
//	   $('.my_usr_frm'+forum_decID).removeClass().addClass('my_usr_frm_find'+forum_decID);
//	    $('#my_usr_frm_content'+forum_decID).attr("id",'my_usr_frm_content_find'+forum_decID); 
	   

   	 $(".my_usr_frm"+forum_decID).css({'cursor':'pointer'}).addClass('link'); 
      $(".my_usr_frm"+forum_decID).toggle( 
   	  function(){ 
   	  
   	     
   	    $(this).addClass('hover');
   	     $("#my_usr_frm_content"+forum_decID).slideToggle();
   	  },  
   	  function(){ 
   	    $(this).removeClass('hover'); 
   	   $("#my_usr_frm_content"+forum_decID).slideToggle();
   	  } 
   	 
   	 );   	   
      return false;
   }
/********************************************TOGGLE_FORUM_DECISION*************************************************/

 
var  frm_decID2 =$("#frm_decID").val();
create_Frmtoggle(frm_decID2); 

 

function create_Frmtoggle(forum_decID){
	 $(".my_decfrm"+forum_decID).css({'cursor':'pointer'}).addClass('link');
	 $(".my_decfrm"+forum_decID).hide();
	 $(".my_decfrm"+forum_decID).toggle( 
	  function(){ 
	  
	     
	    $(this).addClass('hover');
	     $("#my_decfrm_content"+forum_decID).slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	   $("#my_decfrm_content"+forum_decID).slideToggle();
	  } 
	 );   	   
	
}
/********************************************TOGGLE_SINGLE_FORUM_DECISION*************************************************/
$(".my_dec_frm_2").hide();
$(".my_dec_frm").css({'cursor':'pointer'}).css({'cursor':'pointer'}).addClass('link'); 
 $(".my_dec_frm").toggle( 
  function(){ 
  
     
    $(this).addClass('hover');
     $("#my_dec_frm_content").slideToggle();
  },  
  function(){ 
    $(this).removeClass('hover'); 
   $("#my_dec_frm_content").slideToggle();
  } 
 );  
 /********************************************TOGGLE_USERS_from_SINGLE_CHOOSE_ FORUM*************************************************/
// $(".my_usr_frm_find").addClass('link'); 
// $(".my_usr_frm_find").toggle( 
//	  function(){ 
//	  
//	     
//	    $(this).addClass('hover');
//	     $("#my_usr_frm_content_find").slideToggle();
//	  },  
//	  function(){ 
//	    $(this).removeClass('hover'); 
//	   $("#my_usr_frm_content_find").slideToggle();
//	  } 
//	 );   	   
	
 
 


/********************************************TOGGLE_PAST_USERS_FORUM_DECISION*************************************************/ 
if( ($("#count_info").val() ) ){
	for(var i=0;i<$("#count_info").val();i++){
		if( ($("#cntFrm").val() ) ){
		    
		for(var j=0;j<$("#cntFrm").val();j++){
			var  forum_decID =$("#past_usr_frm"+i+j).val();//$("input[id^=past_usr_frm]").val();// document.getElementById('frmID').value;
			$(".my_Past_usr_frm_2"+forum_decID).hide(); 
		    create_Dectoggle(forum_decID); 
		
		  }
		 }
 
     }
  }
 
   





   function create_Dectoggle(forum_decID){
	 $("h6.my_Past_usr_frm"+forum_decID).hide(); 
   	 $(".my_Past_usr_frm"+forum_decID).css({'cursor':'pointer'}).addClass('link'); 
   	 $(".my_Past_usr_frm"+forum_decID).toggle( 
   	  function(){ 
   	  
   	     
   	    $(this).addClass('hover');
   	      $("#my_Past_usr_frm_content"+forum_decID).slideToggle();
   	  },  
   	  function(){ 
   	    $(this).removeClass('hover'); 
   	   $("#my_Past_usr_frm_content"+forum_decID).slideToggle();
   	  } 
   	 );   	   
	   
     
  
  }


/********************************************TOGGLE_USERS_FORUM_AFTER_SEARCH_DECISION*************************************************/
   $(".my_usr_frmDec_2").hide();
  $(".my_usr_frmDec").css({'cursor':'pointer'}).addClass('link'); 
  $(".my_usr_frmDec").toggle( 
   function(){ 
   
      
     $(this).addClass('hover');
      $("#my_usr_frmDec_content").slideToggle();
   },  
   function(){ 
     $(this).removeClass('hover'); 
    $("#my_usr_frmDec_content").slideToggle();
   } 
  );
  
  
  
  

/*********************************************************************************/


 var progressOpts = {
         change: function(e, ui) {
            
   	
 
         var val =$(this).progressbar("option", "value");
       
           if(val <=100) {
             //show new value
             ($("#value").length === 0) ? $("<span>").text(val + "%").attr("id", "value")
              .css({ float: "right", marginTop: -28, marginRight:10 })
              .appendTo("#progress") : $("#value").text(val + "%");
              
           } else    {
              $("#increase").attr("disabled", "disabled");
           }
       	
         }
       };
   
        $("#progress").progressbar(progressOpts);

	 
 	   
/*************************COLOR****************************************/
 	 $('.td_color1').css('width','20%');
	 turn_red_task();	 
     
 /*********************************************************************************************/

   	  $("#loading img").ajaxStart(function(){
  	    $(this).show();
  	  }).ajaxStop(function(){
  	    $(this).hide();
  	  });
 
      
   	  
         
});//end DCR  

 
  

