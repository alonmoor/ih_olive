
 function setupAjaxForm(dec_id, form_validations){
		 var decID=$('#decID').val();
			 //document.getElementById('decID').value; 		   
		   
			var form = '#' + dec_id;
			var form_message = form + '-message';
			
			$(form).ajaxSend(function(){
			   $("#form-message"+decID).removeClass().addClass('loading').html('Loading...').fadeIn();
		   });
   var options = { 
		 
        beforeSubmit:  showRequest, 
	   
             // pre-submit callback 
         
        success:  processJson, 
        
        dataType: 'json'
    }; 
   
 
 //  count=	document.getElementById('count_decID').value;
    $('#decision_'+decID).ajaxForm(options); 
 	 

 
    
 function showRequest(formData, jqForm) { 
	 
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)
 
    return true;  
} 
 
/**********************************************************************************************/

// post-submit callback 
function processJson(data) {
	theme = {
			 
			newUserFlashColor: '#ffffaa',
			editUserFlashColor: '#bbffaa',
			errorFlashColor: '#ffffff'
		};  
	countJson = data;
	countJson1 = data;
	
	 
	  
    countJson = data;
	
    var countList = '';
    var decisionList = '';
    
    var managerList = '';
    var appointList = '';
    var countList1 = ''; 
	var countList2 = ''; 
	var countList3 = ''; 
	var countList4 = '';  
	var infoList='';
	var userList='';
    var categoryList='';
    var decision_typeList='';
   
    forum_progBar=new Array();
    usrList= new Array();
    list_div= new Array();
    dest_forums_conv=new Array();
   
    
///////////////////////////////////////////////    
    if(data.type == 'success'){              //
///////////////////////////////////////////////
    	var decID=document.getElementById('decID').value;  
    	//var url='/alon-web/olive_prj/admin/';
    	var url='../admin/';
    	$('#menu_items_dec'+decID).show();
    	$('#my_error_message'+decID).hide();
    	 $('#desc_table').html(' ');
         loadDecFrm_note(url,decID);
         
         
     
      
/************************************************************************************************************/
/*********************************RESET_DEC_DATE*************************************************************/
    	document.getElementById('dec_date').value=data.dec_date;
    	document.getElementById('mult_yearID').value="none";
    	document.getElementById('mult_monthID').value="none";
    	document.getElementById('mult_dayID').value="none";   	 

    	
/************************************************************************************************************/    	 
      $(form_message).empty();     
       $("#decision-message"+decID).removeClass().addClass(data.type).html(data.message).fadeIn('slow').css({'background':'#ffdddd'}).css({'margin-right': '90px'});  

/***********************************************DECISION*********************************************************/	
      
      if(data.dateIDs){
    	  countList += '<li><a href="../admin/find3.php?decID='+data.decID+'"  class="declink" >'+data.subcategories+'>>'+data.dateIDs+'</a></li>';
    	}else{
    		 if(data.dec_date)
          countList += '<li><a href="../admin/find3.php?decID='+data.decID+'"  class="declink" >'+data.subcategories+'>>'+data.dec_date+'</a></li>';	    
    	}
    	
$('#decision1_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow'); 
        	  
$('#decision1_'+decID).html('<ul id="countList"><b style="color:brown;">שם החלטה'+countList+'</b></ul>').find('a.declink').each(function(i){		 
      
     		    var index = $('a.declink').index(this);
     		    var v = countJson.subcategories;
     		    var id=countJson.decID;
/*****************************************CLICK*****************************************************************/			   
     		   $(this).click(function(){
     			  $('#targetDecdiv').show();
     			// $('#decision0_'+decID).resizable();
     		    $.get('../admin/find3.php?decID='+id+'', $(this).serialize(), function(data) {


     		    	 
     			       
     		   
     $('#decision0_'+decID) 
     .addClass('decision0_'+decID)
                .css({'width' : '90%'})
     			 .css({'height': '500px'})
     			 .css({'margin-right': '50px'})
     			.css({'padding': '5px'})
     		 	.css({'overflow':'auto'})
     			.css({'background':'#2AAFDC'})
     			.css({'border':'3px solid #666'});


              $('#decision0_'+decID).html(data) ;
     		     
     		    						
     		    });
     		  
     		   
     		     return false;
     		    });
     		 
     });//end decision
 










/************************************************NEW_DECISION_TYPE********************************************/
if($('#new_decisionType'+decID).val() && !($('#new_decisionType'+decID).val() =='none')  ){
	   var newItem =$('#new_decisionType'+decID).val();
	   $('#src_decisionsType'+decID).append('<option value='+data.dest_decisionsType[0].catID+'>'+newItem+'</option>').attr("selected",true);    	  		   

      $('#dest_decisionsType'+decID).html(' ');
      $('#dest_decisionsType'+decID).append('<option value='+data.dest_decisionsType[0].catID+'>'+newItem+'</option>').attr("selected",true);

      $('#new_decisionType'+decID).val('') ;
	    
 

  	   
  $('#src_decisionsType'+decID).empty().append('<select name="src_decisionsType'+decID+'" id="src_decisionsType'+decID+'" >\n'); 

				
////////////////////////////////////////////////////////////////////////////
	$.each(data.decType, function(i,item){
////////////////////////////////////////////////////////////////////////////
		    	   
		var listentry =listentry?listentry:item[0];	
		  listentry= listentry.replace(/^[ \t]+/gm, function(x){ return new Array(x.length + 1).join('&nbsp;') });		  
	
		  $('#src_decisionsType'+decID).append("<OPTION   value="+item[1]+" "    + (item[0]==newItem ? "Selected" : "")+     ">" +listentry+ "</option>\n");				  
			   
			 });
				$('#src_decisionsType'+decID).append($('</select>'));


				if($('#insert_decisionType'+decID).val() && !($('#insert_decisionType'+decID).val()=='none')  ){
					var val_insert=$('#insert_decisionType'+decID).val();  
					$('#insert_decisionType'+decID).append('<option value='+data.dest_decisionsType[0].catID+'>'+newItem+'</option>').attr("selected",true);
				}
							
  }		
/************************************NEW_FORUM*********************************************************/
 

  
  if($('#new_forum'+decID).val() && !($('#new_forum'+decID).val() =='none')  ){
	   var newItem =$('#new_forum'+decID).val();
	   $('#src_forums'+decID).append('<option value='+data.dest_forums[0].forum_decID+'>'+newItem+'</option>').attr("selected",true);    	  		   

      $('#dest_forums'+decID).html(' ');
      $('#dest_forums'+decID).append('<option value='+data.dest_forums[0].forum_decID+'>'+newItem+'</option>').attr("selected",true);

      $('#new_forum'+decID).val('') ;
	    
	   
  $('#src_forums'+decID).empty().append('<select name="src_forums'+decID+'" id="src_forums'+decID+'" >\n'); 

				
////////////////////////////////////////////////////////////////////////////
	$.each(data.dec_frm, function(i,item){
////////////////////////////////////////////////////////////////////////////
		    	   
		var listentry =listentry?listentry:item[0];	
		  listentry= listentry.replace(/^[ \t]+/gm, function(x){ return new Array(x.length + 1).join('&nbsp;') });		  
	
		  $('#src_forums'+decID).append("<OPTION   value="+item[1]+" "    + (item[0]==newItem ? "Selected" : "")+     ">" +listentry+ "</option>\n");				  
			   
			 });
				$('#src_forums'+decID).append($('</select>'));


				if($('#insert_forumType'+decID).val() && !($('#insert_forumType'+decID).val()=='none')  ){
					var val_insert=$('#insert_forumType'+decID).val();  
					$('#insert_forumType'+decID).append('<option value='+data.dest_forums[0].forum_decID+'>'+newItem+'</option>').attr("selected",true);
				}
							
  }		
/***********************************************FORUM_DEC*********************************************************/

  if(!($.browser.mozilla==true ))
   $("#my_dec"+decID).css("float", "left"); 
/**************************************************************************************************************************/		
	

///////////////////////////////////////////////////////////////////////////////
$.each(data.dest_forums, function(i){                                        //  
///////////////////////////////////////////////////////////////////////////////	
	 dest_forums_conv[i]=data.dest_forums[i].forum_decID;
	 
	   var forum_decName=this.forum_decName;
	   var forum_id=countJson.dest_forums[i].forum_decID;
	   var forum_decID=countJson.dest_forums[i].forum_decID;
	   var mgr=data.dest_managers[i].managerID;
	   // var url='/alon-web/olive_prj/admin/';
	   var url='../admin/';
	    var idx=i;


	    
  countList1 += '<li><a href="../admin/find3.php?forum_decID='+forum_id+'"  class="forumlink" >'+this.forum_decName+'</a></li>';
 });// end var arv = dest_forums_conv.toString();
/**************************************************************************************************************/
$('#decision2_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow'); 

 

 
$('#decision2_'+decID).html('<ol id="countList1"><b style="color:brown;">שם הפורום/ים'+countList1+'</b></ol>').find('a.forumlink').each(function(i){		 
	
		    var index = $('a.forumlink').index(this);
		    var v = countJson.forum_decName;
		    var forum_id=countJson.dest_forums[i].forum_decID;
		    
/*****************************************CLICK************************************************************/			   
		   $(this).click(function(){
			   $('#targetDecdiv').show();
		    $.get('../admin/find3.php?forum_decID='+forum_id+'', $(this).serialize(), function(data) {


		    	 
			       
		   
$('#decision0_'+decID) 
.addClass('decision0_'+decID).css({'width' : '81%'})
			.css({'height': '300px'})
			.css({'margin-right': '90px'})
			.css({'padding': '5px'})
			.css({'overflow':'auto'})
			.css({'background':'#C6EFF0'})
			.css({'border':'3px solid #666'});


         $('#decision0_'+decID).html(data) ;
		     
		    						
			      
		    });
		  
		   
		     return false;
		    });
		  
});//end forum_dec   		


/************************************************************DECISION_TYPE**********************************************************************/
 
$.each(data.dest_decisionsType, function(i){


 var catName=this.catName;
 var catID=countJson.dest_decisionsType[i].catID;
 // var url='/alon-web/olive_prj/admin/';
 var url='../admin/';
  var idx=i;

countList4 += '<li><a href="../admin/find3.php?catID='+catID+'"  class="typelink" >'+this.catName+'</a></li>';
  

});	

 

$('#decision3a_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow'); 

$('#decision3a_'+decID).html('<ol id="countList4"><b style="color:brown;">סוגי החלטה/ות'+countList4+'</b></ol>').find('a.typelink').each(function(i){	


	    var index = $('a.typelink').index(this);
	    var v = countJson.catName;
	    var id=countJson.dest_decisionsType[i].catID;
/*****************************************CLICK***************************************************/			   
	   $(this).append('<div id="targetDiv_dec"></div>').click(function(){
		   
	    $.get('../admin/find3.php?catID='+id+'', $(this).serialize(), function(data) {


	    	 
		       
	   
$('#decision0_'+decID) 
.addClass('decision0_'+decID).css({'width' : '81%'})
		.css({'height': '500px'})
 	 	.css({'margin-right': '90px'})
    	.css({'padding': '5px'})
		.css({'overflow':'auto'})
		.css({'background':'#8EF6F8'})
		.css({'border':'3px solid #666'});


 





 $('#decision0_'+decID).html(data) ;
 
 
/************************************************************************/	 
	  
		 $('#decision0_'+decID).css({'display':'inline'}).pager('li', {
			   navId: 'nav2',
			  height: '15em' 
			 });
		 

		 $('#nav2').draggable();


		 $('#first_li').hide();				 
		 		 
			 $('a.my_paging').not($('#my_paging1')).bind('click', function() {
				   
				   $('#my_resulttable_0').hide();
				   $('#first_li').hide();	
				 });				 
			 
			 
		
		$('a#my_paging1').bind('click', function() {
			   
			   $('#my_resulttable_0').show();
			   $('#first_li').hide();	
			 });				
    });
  return false;
});

	       
});//end decision/type   

/***************************************MANAGER**********************************************/
if(data.dest_managers[0][0].managerID ){ 

//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(data.dest_managers, function(i,item){
/////////////////////////////////////////////////////////////////////////////////////////////
	  
			$.each(item, function(i){
	            var managerName=this.managerName;
	      	    var mng_id=item[i].managerID;
	      	    
	      	   managerList += '<li><a href="../admin/find3.php?managerID='+mng_id+'"  class="mgr" >'+managerName+'</a></li>';
             
			});//end each2 

		 });//end each2			               



 $('#decision7_'+decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});


  $('#decision7_'+decID).html('<ol id="managerList1"><b style="color:brown;">מרכז ועדה'+managerList+'</b></ol>').find('a.mgr').each(function(i){
///////////////////////////////////////////////////////////////////////////////////////////////	   
	      			  var index = $('a.mgr').index(this);
	      		 
	      	 	 
	      			    var mgr_id=data.dest_managers[i][0].managerID;
	      
/*****************************************CLICK****************************/		   
      		   $(this).click(function(){
      			 $('#targetDecdiv').show();
      		    $.get('../admin/find3.php?managerID='+mgr_id+'', $(this).serialize(), function(data) {
      
      		    	$('#decision0_'+decID) 
      					.addClass('decision0_'+decID).css({'width' : '81%'})
      								.css({'height': '500px'})
      								.css({'margin-right': '90px'})
      								.css({'padding': '5px'})
      								.css({'overflow':'hidden'})
      								.css({'overflow':'auto'})
      								.css({'background':'#B4D9D7'})
      								.css({'border':'3px solid #666'});
      					
      					
      		    	$('#decision0_'+decID).html(data) ;
      							     
      							    						
      								      
      							    });
      							  
      					  
      							     return false;
      							    });
      		 $('#decision0_'+decID).html(' ') ;
      		    
      		   });//end manager  end each3  

} 
/***************************************USERS_FORUM**********************************************/
if(data.dest_users && data.dest_users!='undefined'){ 
 var i=0;
 var j=0;
///////////////////////////////////////////////////////////////////////////		
		$.each(data.dest_users, function(j,item){
/////////////////////////////////////////////////////////////////////////////////////////////

	        
			$.each(item, function(i){
	            var full_name=this.full_name;
	      	    var usr_id=item[i].userID;
	      	  
	         userList += '<li class="my_user_li"><a href="../admin/find3.php?userID='+usr_id+'"  class="usr'+j+'" >'+full_name+'</a></li>';
	   
			});//end each2 
			usrList[j]=userList;
			userList='';
	 
		 });//end each2			               
/*********************************************************************************************************************************/
 
  count=new Array();

for(var j=0, mylen = countJson.dest_forums.length;j<=mylen;j++){
	 
	var num=10+j;
	list_div[j]=num;   
   $('#decision'+num+'_'+decID).removeClass().addClass(data.type).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});


   if(usrList[j]){
	   if(countJson.src_forums.length!=null){ 
		   if(countJson.dest_forums.length<countJson.src_forums.length){
               
			   for(var k=0, mylen = (countJson.src_forums.length-countJson.dest_forums.length);k<mylen;k++){

			 
	                var num_del=(num+mylen)-k; 
	                    
				   $('#decision'+num_del+'_'+decID).empty();
				   }
		   }	 
	   }	
   var count_user=0 ;
  $('#decision'+num+'_'+decID).html('<ol class="my_users_ol" id="userList'+j+'"><b style="color:brown;">'+countJson.dest_forums[j].forum_decName +'- חברי ועדה'+usrList[j]+'</b></ol>').find('a.usr'+j+'').each(function(i){
   

		var index = $('a.usr'+j+'').index(this);
	      		 
	      	 	 
	      			    var usr_id=data.dest_users[j][count_user].userID;
       			 
       			 
/*****************************************CLICK*************************************************************/		   
   $(this).click(function(){
	   $('#targetDecdiv').show();  
    $.get('../admin/find3.php?userID='+usr_id+'', $(this).serialize(), function(data) {
  
  		    	$('#decision0_'+decID) 
.addClass('decision0_'+decID).css({'width' : '81%'})
.css({'height': '500px'})
.css({'margin-right': '90px'})
.css({'padding': '5px'})
.css({'overflow':'auto'})
.css({'background':'#B4D9D7'})
.css({'border':'3px solid #666'});
	
	
$('#decision0_'+decID).html(data) ;
					     
    							
						      
					    });
					  
  
					     return false;
					    });
 
 $('#decision0_'+decID).html(' ') ;
 count_user++;
   });//end each3  
     
   }//end if usrList 
          
//          else {
//        	  if( (!usrList[j]) && (countJson.dest_forums[j].forum_decName) && (countJson.dest_forums[j].forum_decName==="undefined") ) {  
//        	  $('#decision'+num+'_'+decID).html('<ol id="userList'+j+'">'+countJson.dest_forums[j].forum_decName +'</ol>');  
//             }
//           }
          
     }//end for
}
     
/********************************GENERAL_INFORMATION*******************************************/   	
$('#decision9_'+decID).removeClass().addClass(data.type).effect("highlight", {color:theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});
 infoList += '<li><a href="../admin/forum_demo12.php"  class="my_msg" ><b style="color:brown;">מידע כללי </b></a></li>';
 
 $('#decision9_'+decID).html('<ul id="infoList1">'+infoList+'</ul>').find('a.my_msg').each(function(i){
 		    var index = $('a.my_msg').index(this);
/*****************************************CLICK****************************/		   
  $(this).click(function(){
	  $('#targetDecdiv').show(); 
	   $.get('../admin/forum_demo12.php', $(this).serialize(), function(data) {
  
			 $('#decision0_'+decID) 
			.addClass('decision0_'+decID).css({'width' : '85%'})
			.css({'height': '400px'})
			.css({'margin-right': '90px'})
			.css({'padding': '5px'})
			.css({'overflow':'auto'})
			.css({'background':'#AE77BE'})
			.css({'border':'3px solid #666'});
			
			 
			$('#decision0_'+decID).html(data) ;
					     
		    						
			      
		    });
		  
 
		     return false;
		    });//end click
  $('#decision0_'+decID).html(' ');
  
 });//end general info 		   	  
  

/********************************************************************************************************/

 if( (data.dest_forums.length>0) ){
 $('#my_table').empty() ; 
	 
 	for(var i=0;i<data.dest_forums.length;i++){ 	 
 	var forum_decID=data.dest_forums[i].forum_decID;
 	var forum_decName=data.dest_forums[i].forum_decName;

 	$('#my_table').append($("  <tr>\n"+	
 	"<td   class='myformtd' id='myformtd' colspan='4'>"+
	"<ul id='my_ul"+forum_decID+"'>"+
	"<div id='my_div"+forum_decID+"' class='form-row'>"+ 
   "<span class='h'>חברי פורום בעת קבלת ההחלטה:<input id="+forum_decID+" name="+forum_decName+" type='text' value=\'"+forum_decName+"\' class='mycontrol'></span>"+ 
    "<br/></div>\n")); 
 	
/************************************************************************************/ 	
 var j=0;
 if(data.dest_users_Decfrm && data.dest_users_Decfrm.length){ 
 /**************************************************************************************/		
 	 	$.each(data.dest_users_Decfrm[i], function(j,item){
 
 
 			//var url='/alon-web/olive_prj/admin/';
 	 		var url='../admin/';
 			var member_date="member_date"+forum_decID+item.userID+""; 
 			
 		 if(item!=''){ 
	    	$('#my_div'+forum_decID).append($('<li id="my_li'+forum_decID+item.userID+'">\n'+ 	
	    			'<input type="hidden" class="userID" id="'+item.userID+forum_decID+'"  value="'+item.userID+'" >'+    
	    			'<input type="hidden" class="forum_decID" id="'+forum_decID+item.userID+'"  value="'+forum_decID+'" >'+
	    			"חבר פורום: <input type='text'  name='member'  class='mycontrol'  value=\'"+item.full_name+"\'  />\n" +   
        '<input type="button"  class="mybutton"  id="my_button_'+forum_decID+item.userID+'"  value="ערוך משתמש" onClick="return editReg_user('+item.userID+',\''+url+'\' ); return false;"   >'+
        "תאריך צרוף לפורום:<input type='text' name='form[member_date"+forum_decID+item.userID+"]'  id='member_date"+forum_decID+item.userID+"'  class='mycontrol dp'   size='10'  value="+item.HireDate+"  />\n" +
        '<br/></li>\n'));
		    
	    	 
	    	$(function() { 
	       	    $('.dp').datepicker( $.extend({}, {showOn: 'button',
	       	            		                               buttonImage: '../images/calendar.gif', buttonImageOnly: true,
	       	            		                               changeMonth: true,
	       	            				                       changeYear: true,
	       	            				                       showButtonPanel: true,
	       	            				                       buttonText: "Open date picker",
	       	            				                       dateFormat: 'dd-mm-yy',
	       	            				                       altField: '#actualDate'}, $.datepicker.regional['he'])); 
	       		});  	
	    	
 		 	
	    	
 		 
 			$('#my_table').append($('</li>\n'));
 		    }else{
 		    	$('#my_table').append($('<li></li>\n'));
 		    }
	      });//end each_1  
 }//end if(data.dest_users_Decfrm) 	
 	  $('#my_table').append($('</ul></td></tr>\n')); 
 	 	 	 	  
 	}//end for 
 }
/*************************************************************************************************************/ 
}//end success

    else{
    	 
  	var decID=document.getElementById('decID').value;  
   	 $.each(data  , function(i,item){ 			
   			var  messageError= i;
   		  
   			 $("#decision-message").html(' ').fadeIn();
   			 if(messageError!='decID')
   	    	 countList2 +='<li class="error">'+ item +'</li>';
   		       
   		 });	 
    
   	 $('#my_error_message'+decID).html('<ul id="countList_check">'+countList2+'</ul>').css({'margin-right': '90px'});
   	 $('#my_error_message'+decID).append($('<p ID="bgchange"   ><b style="color:blue;">הודעת שגיאה!!!!!</b></p>\n' ));
   	
   	  if($('#menu_items_dec_hidden'+decID).val())
   		  $('#menu_items_dec'+decID).hide();
   	  $('#my_error_message'+decID).show();
      turn_red(); 
   	//  blinkFont()
    } 
/***************/
 }//end proccess
/***************/
////////////////////////////////////////////CHANGE_CONN_FIRST_BY_SEARCH=on the file////////////////////////////////////////////////////////
$('#btnLink6_'+decID).click(function(){ //conn first on the file

	 $(form_message).removeClass().addClass('loading').html(' ').fadeOut( ); 

	
	  $('#conn_txt_first'+decID).remove();
	  $('#conn_submit_first'+decID).remove();
	  $('#conn_table'+decID).append($("<tr><td class='myformtd'>\n"+ 	 
	  "<input type='text' name='conn_txt_first"+decID+"' id='conn_txt_first"+decID+"'  class='mycontrol'  colspan='1'  />\n" + 
	  "<input type='button' name='conn_submit_first"+decID+"' id='conn_submit_first"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור ריאשון בטופס'  />\n" +
	  "<h4 class='my_title_button' style='height:15px;cursor:pointer;'></h4>"+
	  "<div id='targetDiv_change"+decID+"'></div>\n"+  
	  
	  "</td></tr>\n" 
	  
	   )).css({'border' : 'solid #dddddd 5px'});
	
	  toggle_me();
		 $('input#conn_submit_first'+decID).click(function(){	
	 var txt=$('#conn_txt_first'+decID).attr('value');
	 
		data_change=new Array();
		data_change[0]=($('#conn_txt_first'+decID).val()   );
		data_change[1]=decID;
		var data_b=decID; 
		
			$.ajax({
			   type: "POST",
			   url: "../admin/find3.php",
			   
			   data:  "change_conn_first="  + data_change,
			   success: function(msg){
				 $('div#targetDiv_change'+decID).html(' ').append('<p>'+msg+'</p>');	
				
/****************************************************************************/				 
				 $('div#targetDiv_change'+decID).css({'display':'inline'}).pager('li', {
		  			   navId: 'nav2',
		  			  height: '15em' 
		  			 });
		  		 

		  		 $('#nav2').draggable();


		  		 $('#first_li').hide();				 
		  			 
		  			 $('a.my_paging').not($('#my_paging1')).bind('click', function() {
		  				   
		  				   $('#my_resulttable_0').hide();
		  				
		  				 });				 
		  			 
		  			 
		  		
		  		$('a#my_paging1').bind('click', function() {
		  			   
		  			   $('#my_resulttable_0').show();
		  			   $('#first_li').hide();	
		  			 });				
/****************************************************************************/

 $('td.td3head').find('a.change_conn'+decID).css('background-color', 'red').click(function(){
       
        var link = $(this).attr('href') ; 
        var decID=   $(this).attr('decID') ;
        var insertID=   $(this).attr('insertID') ;
        var parentDecID1=   $(this).attr('parentDecID1') ;
        
        var str_a= "chack_insert";
        $.ajax({
        	  dataType:'json',
    		   type: "GET",
//    		   url: "../admin/dynamic_5b.php",
    		   url: "../admin/ajax2.php",
    		   data: "insertID=" + insertID + "&decID=" + decID + "&vlidInsert=" + str_a ,   


        	   success: function(json) {
        	
        	  if(json.list[0]=='fail'){ 
        		  alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
        		  return;   
        	  
        	  }else{
        		  var insertID =json.list.insertID;
        	  }
 /**************************************/    	  
        	  var str= "change_insert_b";  
           $.ajax({
    		   type: "GET",
    		   url: "../admin/dynamic_5b.php",
    	 
    		   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,   


           success: function(msg) {
           	  
           	   
           	$('div#my_entry_top'+decID).empty().append('<p>'+msg+'</p>');
           
                
              }
              
          });              	  
        	  
        	  
 /*************************************/    	  
           }
           
       });              	
    	
    	
    
              
              
          
      return false;
      
     });//end click              
					 
   }//end success ajx

 });//end ajax1
 		
return false;
});	//end conn_submit_first click

	
		 
		 
/*************************/
$('div#targetDiv_change'+decID).empty();
return false;
});//end btnLink6 

$( '#btnLink6_'+decID).bind("click", (function() {
    $('#btnLink6_'+decID).unbind("click");
}));	


function toggle_me(){
	$(".my_title_button").addClass('link'); 
	$(".my_title_button").toggle( 
	  function(){ 
	   
	    $(this).addClass('hover');
	    $("#targetDiv_change"+decID).slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	    $("#targetDiv_change"+decID).slideToggle();
	  }); 
	
}		 
/***************************CONN_SECOND_BY_SEARCH*************************************************************/
$('#btnLink3_'+decID).click(function(){ 

	 //$('fieldset#details_fieldset'+decID+'').remove();
	  $('#conn_txt'+decID).remove();
	  $('#conn_submit'+decID).remove();
	  $('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'><td class='myformtd'>\n"+ 	 
	  "<input type='text' name='conn_txt"+decID+"' id='conn_txt"+decID+"'  class='mycontrol'  colspan='1' />\n" + 
	  "<input type='button' name='conn_submit"+decID+"' id='conn_submit"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור שני בטופס'  />\n" +
	  "<h3 class='my_title_button2'  style='height:15px;cursor:pointer;'></h3>"+
	  "</td></tr>\n" +
	  "<div id='targetDiv_search2"+decID+"' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n"   
	   )).css({'border' : 'solid #dddddd 5px'});
	  
	  toggle_me_secound(); 
		$('input#conn_submit'+decID).bind('click',function(){	
		 
		data=new Array();
		data[0]=($('#conn_txt'+decID).val()   );
		data[1]=decID;
		 
		
	$.ajax({
	   type: "POST",
	   url: "../admin/find3.php",
	   data:  "conn_second="  + data,
	   success: function(msg){

 $('div#targetDiv_search2'+decID).html(' ').append( msg );
 
/******************************NAV**********************************************/ 
 $('div#targetDiv_search2'+decID).css({'display':'block'}).pager('li', {
	   navId: 'nav2',
	  height: '15em' 
	  
	 });
 

 $('#nav2').draggable();


 $('#first_li').hide();				 
	 
	 $('a.my_paging').not($('#my_paging1')).bind('click', function() {
		   
		   $('#my_resulttable_0').hide();
		
		 });				 
	 
$('a#my_paging1').bind('click', function() {
	   
	   $('#my_resulttable_0').show();
	   $('#first_li').hide();	
	 });				
 
/****************************************************************************/ 

 $('td.td3head').append('<div id="div#decision_a_'+decID+'"></div>').find('a.change_conn').css('background-color', 'red').click(function(){
	        
	         var link = $(this).attr('href') ; 
	          var decID=   $(this).attr('decID') ;
	          var parentDecID1_src= $(this).attr('parentDecID1') ;
	          var insertID=   $(this).attr('insertID') ;
	          var str_a= "chack_insert";
	         	  
/**************************************************************************************/    	          
	           
	          $.ajax({
	          	  dataType:'json',
	      		   type: "GET",
	      		   url: "../admin/dynamic_5b.php",
	      	 
	      		   data: "insertID=" + insertID + "&decID=" + decID + "&vlidInsert=" + str_a ,   


	          	   success: function(json) {
	          	
	          	  if(json.list[0]=='fail'){ 
	          		  alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
	          		  return;   
	          	  
	          	  }else{
	          		  var parentDecID1_dest =json.list.insertID;
	          	  }
	           	  
	             var str= "link_second";  
	               $.ajax({
				   type: "GET",
				   url: "../admin/dynamic_5b.php",
				 
				   data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str ,  
	            	   success: function(msg) {
	            	   if(($('#hidden_entry'+parentDecID1_src).val())===undefined){ 
	            		   $('div#decision_a_'+decID).empty().append('<p>'+msg+'</p>');
	            	   }else{ 
	            		   $('div#my_entry'+parentDecID1_src).remove(); 
	            		   $('div#decision_a_'+decID).empty().append('<p>'+msg+'</p>');
	            	      //$('div#my_entry'+parentDecID1_src).empty().append('<p>'+msg+'</p>');
	            	   }       
	            	    
	            		   if(!($('#btnLink7_'+decID)).val()){ 
	            		   $('#conn_table'+decID).append($("<tr><td class='myformtd'>\n"+ 	 
	        	          
	            		  "<input type='button' name='btnLink7_"+decID+"' id='btnLink7_"+decID+"'  class='mybutton'  colspan='1' value='בטל קישור שני' />\n"+ 
	            		    "</td></tr>\n" +
	            		    "<div id='targetDiv_cancel"+decID+"'></div>\n")).css({'border' : 'solid #dddddd 5px'});
	            		   }
////////////////////////////////////////////CANCEL_CONN_SECOND2////////////////////////////////////////////////////////
	              $('input#btnLink7_'+decID).click(function(){ 
	              

	              $.getJSON('../admin/dynamic_5b.php?cancle&decID='+decID, function(json) {
	              
	             	
	             				   		$.each(json, function(i,item){
	              		   			 
	             				    	 	parentDecID1 =  json.parentDecID1 ;
	             	                        			     
	             				    	 	//$('div#my_entry'+parentDecID1_dest).remove();
	             				    	 	$('div#decision_a_'+decID).remove();
	             				    	    		 		 
	             				    	 	 		 
	             				   		});

	             				    
	             				   	});
	  $('input#btnLink7_'+decID).remove();
return false; 
				
});//end btnLink7	 


	               }
	           });	          	  
	  
	             }
	             
	         });              	
/**************************************************************************************/    	      		          

	          
	      return false;
	 });//end click Link             		 
 
	  }//end success ajx
 	
	});//end ajax
 
return false;			
});//end click conn_submit	
		
		
 	
	
		
$('div#targetDiv_cancel').html(' ');
$('div#targetDiv_search2').html(' ');
return false;
});//end click btn3

$( '#btnLink3_'+decID).bind("click", (function() {
    $('#btnLink3_'+decID).unbind("click");
}));	
/*********************************************************************************************************************/
function toggle_me_secound(){
	$(".my_title_button2").addClass('link'); 
	$(".my_title_button2").toggle( 
	  function(){ 
	   
	    $(this).addClass('hover');
	    $('div#targetDiv_search2'+decID).slideToggle();
	  },  
	  function(){ 
	    $(this).removeClass('hover'); 
	    $('div#targetDiv_search2'+decID).slideToggle();
	  }); 
	
}		 
////////////////////////////////////////////CANCEL_CONN_SECOND////////////////////////////////////////////////////////
$('#btnLink4_'+decID).click(function(){ 
//	 alert("aaaaaaaaaaaaa");
//	 $('div#btnLink4_'+decID).remove();  
$.getJSON('../admin/dynamic_5b.php?cancle&decID='+decID, function(json) {

		   		
				   		$.each(json, function(i,item){
		   			 
				    	 	parentDecID1 =  json.parentDecID1 ;
	                        			     
				    	 	$('div#my_entry'+parentDecID1).remove();
				    	 	//  $('div#decision_b_'+decID).remove();				    		 		 
				    	 	 		 
				   		});

				    
				   	});
$('input#btnLink4_'+decID).remove();
return false; 
/************************************************************************************/				
});//end btnLink4	 
/*****************************************CONN_ROOT**************************************/
//btnLink0_$decID
$('#btnLink0_'+decID).click(function(){ 
	   

	  var data=decID;
		
			$.ajax({
			   type: "POST",
			   url: "../admin/dynamic_5b.php",
			   data:  "conn_root="  + data,
			   success: function(msg){
				$('div#my_entry_top'+decID).empty().append('<p>'+msg+'</p>');
              
              
		}
	
    

});

return false; 	 
});

/*****************************************CONN_SECOND_BY_PAGING**************************/
$('#btnLink1_'+decID).click(function(){ 
	   
	   
	  $('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'>\n"+ 	
	    "<div id='targetDiv"+decID+"'></div>\n"   
	       )).css({'border' : 'solid #dddddd 5px'});

	  var data=decID;
		
			$.ajax({
			   type: "POST",
			   url: "../admin/dynamic_5b.php",
			   data:  "conn_second_by_paging="  + data,
			   success: function(msg){
			 $('div#targetDiv').empty().append('<p>'+msg+'</p>');
		}
	
      
  
  });

return false; 	 
});

//////////////////////////////////////////////TESTING/////////////////////////////////////////////////////////////////////
/***************************CONN_SECOND_BY_SEARCH*************************************************************/
$('#btnLinkWin_'+decID).click(function(){ 

	  $('#conn_txt'+decID).remove();
	  $('#conn_submit'+decID).remove();
	  
	  
	  if(!($.browser.mozilla==true )){	  
  		  $('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'><td class='myformtd'>\n"+ 	 
  				  "<input type='text' name='conn_txt2"+decID+"' id='conn_txt2"+decID+"'  class='mycontrol'  colspan='1' />\n" + 
  				  "<input type='button' name='conn_submit22"+decID+"' id='conn_submit22"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור שני בחלון'  />\n" +
  				   "</td></tr>\n" +
  				  "<div id='targetDiv_search22"+decID+"' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n"   
  				   )).css({'border' : 'solid #dddddd 5px'});
  	  
  	     
  	  }else {  
  	  	
  		  $('#conn_table'+decID).append($("<fieldset id='details_fieldset"+decID+"'><legend>חפש קישורים</legend>\n"+ 	 
  				  "<form id='details"+decID+"'><input type='text' name='conn_txt2"+decID+"' id='conn_txt2"+decID+"'  class='mycontrol'  colspan='1' />\n" + 
  				  "<input type='button' name='conn_submit22"+decID+"' id='conn_submit22"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור שני בחלון'  />\n" +
  				   "</form></fieldset>\n" +
  				  "<div id='targetDiv_search22"+decID+"' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n"  )).css({'border' : 'solid #dddddd 5px'}); 
  	  } 		 

  $('input#conn_submit22'+decID).css({'background':'#B4D9D7'}).bind('click', function() {
  		
  if(!($.browser.mozilla==true )){	  
	 
  
    var txt = $('#conn_txt2'+decID).serialize();
  }else {  
  	  
	  
	  var  txt=$('#conn_txt2'+decID).attr('value'); 
 		
  }
       var  queryString = '?conn_secound_test=' + txt + '&decID=' + decID ;


		var link= '../admin/find3.php'+queryString  ;

		  	openmypage3(link); 
	 
		   return false;
		 
			 });	
	
});          		 



$( '#btnLinkWin_'+decID).bind("click", (function() {
    $('#btnLinkWin_'+decID).unbind("click");
}));	
///////////////////////////////////////////////TESTING/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////CHANGE_CONN_FIRST_BY_SEARCH////////////////////////////////////////////////////////
$('#btnLinkWinFirst'+decID).click(function(){ 

	 if(!($.browser.mozilla==true )){	  
	  $('#conn_txtFirst'+decID).remove();
	  $('#conn_submitFirst'+decID).remove();
	  $('#conn_table'+decID).append($("<tr><td class='myformtd'>\n"+ 	 
	  "<input type='text' name='conn_txtFirst"+decID+"' id='conn_txtFirst"+decID+"'  class='mycontrol'  colspan='1'  />\n" + 
	  "<input type='button' name='conn_submitFirst"+decID+"' id='conn_submitFirst"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור ריאשון בחלון'  />\n" +
	   "</td></tr>\n" +
	  "<div id='targetDiv_changeFirst"+decID+"'></div>\n"   
	   )).css({'border' : 'solid #dddddd 5px'});
	 }else {  
	  	  	
 		  $('#conn_table'+decID).append($("<fieldset id='detailsFirst_fieldset"+decID+"'><legend>חפש קישורים</legend>\n"+ 	 
 				  "<form id='detailsFirst"+decID+"'>"+
 				 "<input type='text' name='conn_txtFirst"+decID+"' id='conn_txtFirst"+decID+"'  class='mycontrol'  colspan='1'  />\n" + 
 				  "<input type='button' name='conn_submitFirst"+decID+"' id='conn_submitFirst"+decID+"'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור ריאשון בחלון'  />\n" +
 				   "</form></fieldset>\n" +
 				  "<div id='targetDiv_searchFirst"+decID+"' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n"  )).css({'border' : 'solid #dddddd 5px'}); 
 	  } 		 
	 
	 
	 
	   
		 $('input#conn_submitFirst'+decID).bind('click', function() {	
	
			 
	var txt=$('#conn_txtFirst'+decID).attr('value');
	 
	if(!($.browser.mozilla==true )){	  
	    var txt = $('#conn_txtFirst'+decID).serialize();
	  }else {  
		  var  txt=$('#conn_txtFirst'+decID).attr('value');	
	  }	 
		
	    var  queryString = '?conn_first_test=' + txt + '&decID=' + decID ;
	
	
		var link= '../admin/find3.php'+queryString  ;

	  	openmypage3(link); 
 
	   return false;

		 });//end conn_submit
		 
}); 


$('#btnLinkWinFirst'+decID).bind("click", (function() {
    $('#btnLinkWinFirst'+decID).unbind("click");
}));	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////DELETE_DECISION////////////////////////////////////////////////////////
$('#btnDelete_'+decID).click(function(){
	

data=new Array();
	data[0]='realy_delete';
	data[1]=decID;
if(!confirm("האים בטוח שרוצה למחוק?")){
	 return false;
}

$('#btnDelete_'+decID).unbind();
$('#btnLink1_'+decID).unbind();
$('#btnLink3_'+decID).unbind();

	$('#conn_table'+decID).append($("  <tr id='conn_tr"+decID+"'>\n"+ 	
		    "<div id='targetDiv2' ></div>\n"   
		       )).css({'border' : 'solid #dddddd 5px'});
	
	 $.getJSON('../admin/dynamic_5b.php?cancle&decID='+decID, function(json) {
	 	$.each(json, function(i,item){
	 	 	 
		 	 	parentDecID1 =  json.parentDecID1 ;
//		 	 	alert(parentDecID1); 
//		 	 	alert(item);
     	 	$('div#my_entry'+parentDecID1).remove();
	    	});
	   
	 
	 
	 
	 	$.ajax({
			   type: "POST",
			   url: "../admin/dynamic_5b.php",
			   data:  "delete=" + data,
			   success: function(msg){
		   
// 	             $('#my_entry_top').html( ' ');//.append("רשומה נימחקה!").css({'background':'#8EF6F8'});  ; 
//	             $('#my_text_erea'+decID).html(' ')  ;
//	             $('#my_date'+decID).find('input').val(' ');	
//	             $('#dest_forums'+decID).html(' ')  ;
//	             $('#dest_decisionsType'+decID).html(' ')  ;
//	             $('#my_vote_level'+decID).val(' '); 
//	             $('#my_dec_level'+decID).val(' ');
//	             $('#my_status'+decID).val(' ');
//	            
//	             
//	            // $('#conn_table'+decID).html(' ')  ;
//	             $('#conn_table'+decID).prepend("רשומה נימחקה!").css({'background':'#8EF6F8'});
//	             $('.menu_items_dec'+decID).html(' '); 
//	             $('#my_fieldset'+decID).prepend("רשומה נימחקה!").css({'background':'#C6EFF0'}); 
//	             $('<input  type=hidden id="hidden_for_save" name="hidden_for_save" value="save"  />').appendTo($('#main_table'));
//	           
//	                 
//	             $('#li'+decID).fadeOut('slow', function(){ $(this).remove(); });
//
             
//	             $('div#my_entry'+decID).remove();
//             $('div#decision_a_'+decID).remove();
//             $('div#decision_b_'+decID).remove();
//
//             $('#my_table').remove(); 
//             $('#desc_table').remove(); 

 	            $('div#my_entry_top'+decID).remove();
 	            $('#menu_items_dec'+decID).remove();
 	         //$('#my_dec'+decID).remove();
 	        $('#content_my_dec'+decID).remove();
 	        
	 $('#main_table').html(' ').append("רשומה נימחקה!").css({'background':'#8EF6F8'});		
	 		
	 		
             
//            $('#main_fieldset'+decID).remove();
//            $('# decision_'+decID).remove();
            
       

     }
			
	});
	 
	 
	 
/////////////////////////////	 
	 });//end getjson///////
///////////////////////////	
	

	 
 return false; 
});//end btnDelete

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#submitbutton1_'+decID).click(function(){

 
	// $('#myAlltask').empty();

	
 var arv = dest_forums_conv.toString();
 


   $.ajax({
		   type: "POST",
		   url: "../admin/make_task.php",
		 
		  data:  "rebuild="+ arv + "&decID=" + decID ,
		  
		     

		   success: function(msg){
		 
      
 
  	  $('#my_dec'+decID).html(' ').append('<p>'+msg+'</p>');
            
       }  
 
	}) ; //end ajax

 return false;
	  
});//end buttonsubmit1	
/****************************************************************************************************************/   



/************************************************************************************************/
}//end function
/************************************************************************************************/
 
 $(document).ready(function() { 
	
/*****************************************************/			
	 $('#submitbutton_').bind('click',function(){
	 	
	 	//alert('aaaaaaaaaaa');
	 });			    

/****************************************************************************************/				 
	 

	 
	if($('#decID').val())
	 var decID=document.getElementById('decID').value;
	 new  setupAjaxForm ('decision_'+decID);
	  
	 
 	//  var url='/alon-web/olive_prj/admin/';
	 var url='';
  	loadDecFrm_note(url,decID);
/********************************************UN_DRAG DIV WHEN SCROLL****************************/	 

	 if($.browser.mozilla==true){ 
	 $(function() {
	        $("#menu_items_dec"+decID).sortable();
	        $('#decision0_'+decID).bind("mousedown", function() {return false;});
	    });
	 }else{
		   $("#menu_items_dec"+decID).sortable(); 
		 
	 }
/*******************TOGGLE_USERS_DEC***********************************/
	   $(".my_title_users_dec").css({'cursor':'pointer'}).addClass('link'); 
	   $(".my_title_users_dec").toggle( 
	    function(){ 
	    	//content_users
	       
	      $(this).addClass('hover');
	      
	      if(!($.browser.msie==true))
	      $('#my_table').slideToggle();
	      else
	      $('#content_users_dec').slideToggle();
	      
	    },  
	    function(){ 
	      $(this).removeClass('hover');
	      
	      if(!($.browser.msie==true))
		      $('#my_table').slideToggle();
		      else
		      $('#content_users_dec').slideToggle();  
	    } 
	    
	  );  	   
	   

/*******************************TOGGLE_MAIN_FIELDSET*******************************************/

  	$(".my_main_fieldset"+decID).addClass('link'); 
  	$(".my_main_fieldset"+decID).toggle( 
  	  function(){ 
  	  
  	     
  	    $(this).addClass('hover');
  	    $("#main_fieldset"+decID).slideToggle('slow');
  	  },  
  	  function(){ 
  	    $(this).removeClass('hover'); 
  	    $("#main_fieldset"+decID).slideToggle('slow');
  	  } 
  	);  
  	/*******************************TOGGLE_MENU_ITEM*******************************************/

  	$(".my_menu_items_dec_title").addClass('link'); 
  	$(".my_menu_items_dec_title").toggle( 
  	  function(){ 
  	  
  	     
  	    $(this).addClass('hover');
  	    $("ul#menu_items_dec"+decID).slideToggle('slow');
  	  },  
  	  function(){ 
  	    $(this).removeClass('hover'); 
  	    $("ul#menu_items_dec"+decID).slideToggle('slow');
  	  } 
  	);    

  	/******************************TOGGLE_TASK_TABLE*******************************************/

//  	$(".my_dec_title_table_"+decID).addClass('link'); 
//  	$(".my_dec_title_table_"+decID).toggle(
//
//  	function(){ 
//
//
//  	$(this).addClass('hover');
//  	$("#content_my_dec"+decID).slideToggle('slow');
//
//  	},  
//  	function(){ 
//  	$(this).removeClass('hover'); 
//  	$("#content_my_dec"+decID).slideToggle('slow');
//  	} 
//  	);    

//  	$(".my_dec_title_table_"+decID).addClass('link'); 
//  	$(".my_dec_title_table_"+decID).toggle(
//
//  	function(){ 
//
//
//  	$(this).addClass('hover');
//  	$("#task_fieldset_"+forum_decID).slideToggle('slow');
//
//  	},  
//  	function(){ 
//  	$(this).removeClass('hover'); 
//  	$("#task_fieldset_"+forum_decID).slideToggle('slow');
//  	} 
//  	);    	    
  	$(".my_dec_title_table_"+decID).addClass('link'); 
  	$(".my_dec_title_table_"+decID).toggle(

  	function(){ 


  	$(this).addClass('hover');
  	$("#task_fieldset_"+forum_decID).slideToggle('slow');

  	},  
  	function(){ 
  	$(this).removeClass('hover'); 
  	$("#task_fieldset_"+decID).slideToggle('slow');
  	} 
  	);    	    

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
		$('form#decision_'+decID+' fieldset') .find('select.change_user').change(function(){
 
		var src_userID=this.value;	 	
		 var userID= $(this).parent().find('.userID:hidden').val();
		 var forum_decID=$(this).parent().find('.forum_decID:hidden').val();
		 
		 
	 
		 if (  $('ul#my_ul'+forum_decID).find('li#my_li'+forum_decID+src_userID).is( "li#my_li"+forum_decID+userID ) ){
			 

		 
			 $('ul#my_ul'+forum_decID).find('li#my_li'+forum_decID+src_userID).css('background-color', 'red');
			 return false;

			}

 		 
		 $.ajax({
			
		   type: "POST",
		   url:url+ "ajax2.php",
		   dataType: 'json',
		   data: "src="+ this.value + "&dest=" + $(this).parent().find(':first').val() + "&forum_decID=" + forum_decID + "&decID=" + decID ,
		   success: function(json){
			     if(json.list==="fail") {
			    	 alert("כבר קיים משתמש בשם זה:");
			    	 
			     }else{ 
			    
			 $('input#member'+forum_decID+userID).attr("value",json.list.full_name);
			 
			 $('input#my_button_'+forum_decID+userID).attr('Onclick', 'editReg_user('+src_userID+' ,\''+url+'\')');
			 $('input#my_button_'+forum_decID+userID).attr("id",'my_button_'+forum_decID+src_userID);
			  }
		   }//end success

		 });

			

		});
		
		$('form#decision_'+decID+' fieldset') .find('input.mycontrol hasDatepicker').change(function(){
			var src_userID=this.value;	 	
			 var userID= $(this).parent().find('.userID:hidden').val();
			 var forum_decID=$(this).parent().find('.forum_decID:hidden').val();
			 alert("fffffffffff");
			
		});	
/*************************************************************************************************/	 
		

	$('#modal').draggable({axis: 'y', containment: 'parent'});
	 if($.browser.msie){
		 $('#my_dec'+decID).css({'margin-right': '43px'});
	 }
	

	


	 $('#menu_items_dec'+decID).sortable({
			'stop':sl_recordChange 
		})
		.disableSelection();
	$('<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>')
		.prependTo($('#menu_items_dec'+decID+' > li'));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
$('#submitbutton2_'+decID).bind('click',function(){
	
	var dest_forums_conv=$('#dest_forums'+decID).val();	
    var arv = dest_forums_conv.toString();
 
    var dest_managers= $('#dest_managers'+decID).val();
     dest_managers=eval( dest_managers);
    
    var dest_userIDs= $('#dest_userIDs'+decID).val();
   //  var dest_userIDs=dest_userIDs.toString();
     dest_userIDs =  eval(dest_userIDs);

 
 
  	
   $.ajax({
   type: "POST",
   url: "../admin/make_task.php",
   data:  "rebuild="+ arv + "&decID=" + decID + "&rebuild_mgr=" + dest_managers + "&rebuild_User_mgr=" +dest_userIDs ,
  
     

   success: function(msg){
	 //  $('#my_dec'+decID).html('<p>'+msg+'</p>');
	//  $('#my_dec'+decID).html(' ').append('<p>'+msg+'</p>');
	   $('#content_my_dec'+decID) .append('<p>'+msg+'</p>');
	   
 $.each( dest_forums_conv, function(i,item){
		 
	
   var forum_decID =dest_forums_conv[i];// document.getElementById('forum_decID').value;
   
   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////   
 
   
   

$("#tasklist"+decID+forum_decID).sortable({cancel:'span,input,a,textarea', delay: 100, update:orderChanged, start:sortStart});
$("#tasklist"+decID+forum_decID).bind("click", tasklistClick2);



$("#edittags"+decID+forum_decID).autocomplete('../admin/ajax2.php?suggestTags', {scroll: false, multiple: true, selectFirst:false, max:8});
$("#priopopup"+decID+forum_decID).mouseleave(function(){$(this).hide();});




$("#page_taskedit_multi"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit_multi"+decID+forum_decID).width(), minHeight:$("#page_taskedit_multi"+decID+forum_decID).height(), start:function(ui,e){editFormResize_multi(1)}, resize:function(ui,e){editFormResize_multi(0,e)}, stop:function(ui,e){editFormResize_multi(2,e)} });
$("#page_taskedit_multi"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } });




$("#page_task2users_multi"+decID+forum_decID).resizable({ minWidth:$("#page_taskedit_multi"+decID+forum_decID).width(), minHeight:$("#page_taskedit_multi"+decID+forum_decID).height(), start:function(ui,e){editFormResize_multi(1)}, resize:function(ui,e){editFormResize_multi(0,e)}, stop:function(ui,e){editFormResize_multi(2,e)} });
$("#page_task2users_multi"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } });




$("#page_taskedit"+decID+forum_decID).draggable({ stop: function(e,ui){ flag.windowTaskEditMoved=true; tmp.editformpos=[$(this).css('left'),$(this).css('top')]; } }); 
$("#page_taskedit"+decID+forum_decID).resizable(  ); 


make_tab(decID,forum_decID);



loadTasks2('../admin/',forum_decID,decID);





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
	   

/******************************PROGRESS_BAR********************************************************/

var progressOpts = {
          change: function(e, ui) {
             
    	
  
          var val =$(this).progressbar("option", "value");
    
        if(val <=100 && $.browser.msie==true) {
          //show new value
          ($("#value"+decID+forum_decID).length === 0) ? $("<span>").text(val + "%").attr("id", "value"+decID+forum_decID)
           //.css({ float: "right", marginTop: -28, marginRight:10 })
           .appendTo("#progress"+decID+forum_decID) : $("#value"+decID+forum_decID).text(val + "%");
           
        } else if(val <=100){($("#value"+decID+forum_decID).length === 0) ? $("<span>").text(val + "%").attr("id", "value"+decID+forum_decID)
                .css({ float: "right", marginTop: -28, marginRight:10 })
                .appendTo("#progress"+decID+forum_decID) : $("#value"+decID+forum_decID).text(val + "%");}
   
        
        else    {
           $("#increase"+decID+forum_decID).attr("disabled", "disabled");
        }
    	
      }
    };

     $("#progress"+decID+forum_decID).progressbar(progressOpts);



/***********************************HIDE_MENU*****************************************************/
// $('#taskview'+decID+forum_decID).bind("click", function(evt) {
//    	   
//    	    $('#taskview'+decID+forum_decID).hide();
//    	    
//});

     
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

$('#tagcloudbtn'+decID+forum_decID)//.css("border", "1px solid red") 	
.hover(function() {
	
$(this).addClass('containerHover');


}, function() {

$(this).removeClass('containerHover');


});
/****************************************************************************************/
 $('#tagcloudbtn'+decID+forum_decID+'.btnstr')//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});

/******************************************************************************************/	
 $('#tagcloudcancel'+decID+forum_decID+'.btnstr')//.css("border", "2px solid #cccccc") 	
.hover(function() {

$(this).addClass('containerHover');


}, function() {

$(this).removeClass('containerHover');


});
/****************************************************************************************/
$('#taskviewcontainer'+decID+forum_decID )//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover')	;		 
 
    		   }, function() {

 $(this).removeClass('containerHover');


});

/****************************************************************************************/
	
	
$('#multicloudbtn'+decID+forum_decID)//.css("border", "1px solid red") //multi action	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});


/****************************************************************************************/
$('#sort'+decID+forum_decID )//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});
/****************************************************************************************/
$('#priopopup'+decID+forum_decID+'.btnstr') 	
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

$('#duedate'+decID+forum_decID).datepicker( $.extend({}, {showOn: 'button',
                   buttonImage:'../images/calendar.gif', buttonImageOnly: true,
                   changeMonth: true,
                   changeYear: true,
                   showButtonPanel: true,
                   buttonText: "Open date picker",
                   dateFormat: 'yy-mm-dd',
                   altField: '#actualDate'}, $.datepicker.regional['he'])); 






















/*********************************USERS*******************************************************************************/			

$("#usertabs"+decID+forum_decID).tabs({});
$("#userlist"+decID+forum_decID).sortable({cancel:'span,input,a,textarea', delay: 150, update:orderuserChanged2 , start:sortuserStart});
$("#userlist"+decID+forum_decID).bind("click", userlistClick);
$("#edittags1"+decID+forum_decID).autocomplete('../admin/ajax2.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
$("#tags"+forum_decID).autocomplete('../admin/ajax2.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
$("#userpriopopup"+decID+forum_decID).mouseleave(function(){$(this).hide()});



	
/***************************************************************************************************************************************/	  
	 
  $('#userview'+decID+forum_decID).bind("click", function(evt) {
   
    $('#userview'+decID+forum_decID).hide();
    
});


$('#userview'+decID+forum_decID).bind("mouseleave", getout_user);
$('#sortuserform'+decID+forum_decID).bind("mouseleave", getout_user);


function getout_user(evt) {
 $('#userview'+decID+forum_decID).hide();
 $('#sortuserform'+decID+forum_decID).hide();
}

/****************************************************************************************/ 		  
	  
$('#tagusercloud'+decID+forum_decID).draggable();		  	  
	  
$('#tagusercloudcontent'+decID+forum_decID)//.css("border", "1px solid red") 	
.hover(function() {

$(this).addClass('containerHover');


}, function() {

$(this).removeClass('containerHover');


});
/****************************************************************************************/
 $('#tagusercloudbtn'+decID+forum_decID)//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});

/******************************************************************************************/
 $('#tagusercloudbtn_all'+decID+forum_decID)//.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


}, function() {

 $(this).removeClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


});

/******************************************************************************************/		
 $('#tagusercloudcancel'+decID+forum_decID)//.css("border", "2px solid #cccccc") 	
.hover(function() {

$(this).addClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


}, function() {

$(this).removeClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


});
/****************************************************************************************/
 		
 $('#tagusercloudcancel_all'+decID+forum_decID) 
.hover(function() {

$(this).addClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


}, function() {

$(this).removeClass('containerHover').effect("highlight", {color:theme.newTaskFlashColor}, 2000);


});
/****************************************************************************************/
$('#userviewcontainer'+decID+forum_decID)//.css("border", "1px solid red") 	
	.hover(function() {

$(this).addClass('containerHover')	;		 
 
    		   }, function() {

$(this).removeClass('containerHover');


});

 
/****************************************************************************************/
$('#usersort'+decID+forum_decID) //.css("border", "1px solid red") 	
	.hover(function() {

 $(this).addClass('containerHover');


}, function() {

 $(this).removeClass('containerHover');


});





$('#sortuserform'+decID+forum_decID).bind("click", function(evt) {
   
    $('#sortuserform'+decID+forum_decID).hide();
    
});




/****************************************************************************************/
$('#userpriopopup'+decID+forum_decID)//.css("border", "1px solid red") 	
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
 	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
loadUsers2('../admin/',forum_decID,decID,dest_userIDs[i],dest_managers[i]); 


/***************************************************************************************************/


















           }) ;//end each
			  	
         }  
 
	}) ; //end ajax

 return false;
     
});//end buttonsubmit2
/****************************************************************************************************************/   
	
	
	
	 
	 
	 
	 
	 
	 
$('#submitbuttont_'+decID).bind('click',function(){


	//$(document).ready(function(){
		var percent='';
		var decID =document.getElementById('decID').value; 
	 	var forum_decID = document.getElementById('forum_decID').value; 
	    

	 
	
	// $("#tabs"+decID+forum_decID).tabs({ select: tabSelected <?php echo $tabDisabled; ?>});
	 	
	 
//	   $("#tabs"+decID+forum_decID).tabs({
//			ajaxOptions: {
//				eror: function(xhr, status, index, anchor) {
//					$(anchor.hash).html("Failed to load this tab!");
//				}
//			}
//		});
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
//	$('#userview'+decID+forum_decID).bind("click", function(evt) {
//	   
//	    $('#userview'+decID+forum_decID).hide();
//	    
//	});
//
//
//	$('#userview'+decID+forum_decID).bind("mouseleave", getout);
//	$('#sortuserform'+decID+forum_decID).bind("mouseleave", getout);
//
//
//	function getout(evt) {
//	 $('#userview'+decID+forum_decID).hide();
//	 $('#sortuserform'+decID+forum_decID).hide();
//	}

	/***********************************HIDE_MENU*****************************************************/
//	 $('#taskview'+decID+forum_decID).bind("mouseleave", getout);
//	 $('#sortform'+decID+forum_decID).bind("mouseleave", getout);
//	 $('#multiview'+decID+forum_decID).bind("mouseleave", getout);
//	 
//
//	function getout(evt) {
//	 $('#taskview'+decID+forum_decID).hide();
//	 $('#sortform'+decID+forum_decID).hide();
//	 $('#multiview'+decID+forum_decID).hide();
//	}

	/****************************************************************************************/ 	
	
	
	
	
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
	  $("#usercontainer"+decID+forum_decID).css("border", "3px solid red");//.find(h4).css('border-color','3px solid red');	 	
 //usercontainer
	  
/*****************************************************************************/

	//$(".menu2 a").append("<em></em>");
	//	
//		$(".menu2 a").hover(function() {
//			$(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
//			var hoverText = $(this).attr("title");
//		    $(this).find("em").text(hoverText);
//		}, function() {
//			$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");
	//});
	$('#content').css('border','3px solid red');
	 $('ol.task-actions_user').find('div.task-actions_user').find("a.menu2").css('border','3px solid red');

	 $(".menu2").click(function() {
		 alert("sdfsdfsdf");
	 });	 
	// $(".menu2 a").hover(function() {
//			$(this).next("em").animate({opacity: "show", top: "-75"}, "slow");
//		}, function() {
//			$(this).next("em").animate({opacity: "hide", top: "-85"}, "fast");

	//alert("ssssss");
//		});


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
	   






});	 
	


$('#submitbutton22_'+decID).bind('click',function(){

	var dest_forums_conv=$('#dest_forums'+decID).val();
	
	
 var arv = dest_forums_conv.toString();
 $.post(url+'make_task.php?rebuild', { arv: arv ,decID:decID}, function(msg){		
 		 
		var str='dddddddddddd';
		
	 $('#my_dec'+decID) .append('<p>'+str+'</p>');	
		
	 //$('.my_pageCount') .append('<p>'+str+'</p>');
		
	 		 	 
	}, 'json');
	 
 	
 
 	
	return false;
});







//$('.bgchange_tree').css('width','80%');
	turn_red_tree();


$("#loading img").ajaxStart(function(){
$(this).show();
}).ajaxStop(function(){
$(this).hide();

});	 
	 
/***********************************************************************************************/


	 
/////////////////////////	 
 });//end DC          //
///////////////////////
 
 
/*************************************************************************************/
 
//$('#descButton_'+decID).click(function(){
//	 var options = {};
// $.collectOptions(options);
//	 options.to = '#descButton_'+decID; 
//	$('#commandDisplay').html(
//         "$('.testSubject').effect('" + effectName + "',"+$.forDisplay(options)+","+$.forDisplay(speed)+");"
//       );
//       //
//       // Apply effect
//       //
//$('.testSubject').effect(effectName,options,speed,function(){ var subject = this; setTimeout(restoreTestSubjects,2000); });
	 
	 
// arr=$('#dest_forums'+decID).val();
//	  	var url='/alon-web/olive_prj/admin/';
//		loadDecFrm_note(url,arr,decID);
//loadDecFrm_note(url,decID);	 
	 

	 
	 
	 
	 
// var arr=new Array();
//arr=$('#dest_forums'+decID).val();
//alert(arr);
//$.each(arr, function(i){	 
//var forum_decID=arr[i];
//$('#desc_table_'+decID).append($("  <tr>\n"+
//		 "<td   class='myformtd' >"+
//		 "<div  data-module=''>"+
//		 "<table class='myformtable' >"+
//	      
//	      "<tr>"+
//	      "<td   class='myformtd'>"+
//	     "<input type='texterea' name='mySubtitle_texterea"+forum_decID+"' id='mySubtitle_texterea"+forum_decID+"'  class='mycontrol'   />\n"+
//	     
//	     "</td></tr></table></div></td></tr>\n")).css({'border' : 'solid #dddddd 5px'});
//	 }); 
// $("#mySubtitle_texterea"+forum_decID).autoGrow ();
	 
//})	;

// $("#mySubtitle_texterea"+decID).autoGrow ();		
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//	$('form#decision_'+decID+' fieldset') .find('input#member_date'+forum_decID+userID).change(function(){
//    $('#a1').datepicker ({
//
//        showOn: 'focus',
//
//        buttonText: 'clickme'
//
//    }).change (function () {
//
//        $('#a2').text ($(this).val ());
//
//    })
//
//    
//
//    $('#b1').change (function () {
//
//        $('#b2').text ($(this).val ());
//
//    })



 
 
 
 
