
theme = {
	newTaskFlashColor: '#ffffaa',
	editTaskFlashColor: '#bbffaa',
	errorFlashColor: '#ffffff'
};
var flag_level='';
//Global vars
dest_forums_conv = new Array();
var  taskOrder;
var prio_arr;
//var  prog_bar='';
var ID='';
var  prog_barObj={};
var  my_prog_bar_html='';

taskList   = new Array();
progList   = new Array();
calendarList   = new Array();
noteList   = new Array();


var filter = { compl:0 , search:'', tag:'', due:'' };
var sortOrder; //save task order before dragging
var searchTimer;
var objPrio = {};
var objUser = {};
var selTask = 0;
 
var sortBy = 0;
var flag = { needAuth:false, isLogged:false, canAllRead:true, tagsChanged:true, windowTaskEditMoved:false };
var tz = 0;
var dest_userID=false;


var noteCnt='';
var noteObj={};
var notes='';
var cancelTimeout = false;
 
var img = {
	'note': ['images/page_white_text_add_bw.png','images/page_white_text_add.png'],
	'edit': ['images/page_white_edit_bw.png','images/page_white_edit.png'],
	 'del': ['images/page_cross_bw.png','images/page_cross.png'], 
	 'showformewin': ['images/Email_icons_084.gif','images/Email_icons_068.gif' ]
 	// 'dairy': ['images/Email_icons_084.gif','images/Email_icons_068.gif' ]
  //'remark': ['images/page_white_text_add_bw.png','images/page_white_text_add.png'] 
//'dairy': ['images/icon_clear.gif','images/icon_new.gif'] 
};

var taskCnt = { total:0, past: 0, today:0, soon:0 };

var tmp = {};
//var popup_window={}; 
taskList_arr   = new Array();
var item_id;
var item;
var	sel3='';


/*******************************************************************************************/	
function editDec_tree (decID,forum_decID,catID,url){
 
	nocache = '&rnd='+Math.random();
	
	$.ajax({   	
		type: "GET",
		url: url+"dec_entry.php",
		data: "read_decision_tree="+decID+nocache,
		success: function(msg){
		  
		$('#my_dec_tree'+decID+forum_decID+catID).html(' ').append(msg);	 
   }
 });
return false;	 
}
/********************************************************************************************/
function editDec (decID,forum_decID,catID,url)
{
	nocache = '&rnd='+Math.random();
	var tz = -1 * (new Date()).getTimezoneOffset();


$.getJSON(url+'ajax2.php?pre_editDec&decID='+decID+'&forum_decID='+forum_decID+'&catID='+catID+'&tz='+tz+nocache, function(json){
 	 item =json.list[0];
 ////////////////////////////		
		$('<div id="dec_edit_form" title="הצג נתונים" dir="rtl">'+
			'<form id="editDec">'+
				'<div class="form-row">'+ 
			     '<span class="h">כותרת ההחלטה:<input id="decName" name="decName" type="text" value="' + item.decName + '" class="mycontrol"></span>'+
                				
				
				
				'<h3>'+
				'<span class="h">פורום:</span>'+
				'<input id="frmDec" name="frmDec" type="text" value="' + item.forum_decName + '" class="mycontrol">'+
				'</h3>'+
				
				
				'<h3>'+
				'<span class="h">סוג החלטה:</span>'+
				'<input id="DecType" name="DecType" type="text" value="' + item.catName + '" class="mycontrol">'+
				'</h3>'+
				
	             
	             
	          '<h3>'+
				  '<div class="form-row">'+
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    
				   '<span class="h">תאריך החלטה:</span>'+ 
				   '<input name="date2" id="date2" value="' + item.dec_date + '"  class="mycontrol" />'+
				  '</div>'+
			 '</h3>'+
		             
	             
				
	  
		  
		// '</form> '+
			 '<div class="form-row">'+
		       '<h3><span class="h">תוצאת ההצבעה:<input id="vote" name="vote" type="text" value="' + item.vote_level + '" class="mycontrol"></span></h3>'+	
		       '<h3><span class="h">רמת חשיבות:<input id="dec_level" name="dec_level" type="text" value="' + item.dec_level + '" class="mycontrol"></span></h3>'+
				'<h3><span class="h">סטטוס:<input id="status" name="status" type="text" value="' + item.status + '" class="mycontrol"></span></h3>'+
				
				
				'<h3><span class="h"> רמת הרשאה'+
				 '<form name="editDecision" id="editDecision">'+

				  '<SELECT name="decAllowed"  id="decAllowed" class="mycontrol"  >'+
				      ' <option value="1" selected >ציבורי</option>'+
				      '<option value="2" >פרטי</option>'+
				      '<option value="3" >סודי</option>'+
				  '</SELECT> '+
				 '</form>'+
				'</span></h3>'+
			   ' <span class="h">תאור ההחלטה</span> '+
		'<br/>'+
		 '<textarea style="width:400px;height:200px" id="decNote" >'+item.note+'</textarea></div></div></form></div>').appendTo($('body'));
			
		if(item.dec_allowed=='public'){ 
			item.dec_allowed=1;
		}else if(item.dec_allowed=='private'){ 
		      item.dec_allowed=2;
		}else if(item.dec_allowed=='top_secret'){ 
		      item.dec_allowed=3;
         }
		 
		 
		// document.getElementById("decAllowed").selectedIndex = 1;		  	
		//document.getElementById("decAllowed").selectedIndex = item.dec_allowed; 
		document.getElementById("decAllowed").value = item.dec_allowed; 

				 

			
				 
				 
				 
		$("#dec_edit_form").dialog({
				 
				
				bgiframe: true,
				autoOpen: false,
				height: 440,
				width: 450,
				modal: true,
			 //	zindex: 1006 ,
				buttons: {

				
//				'Save':  function() {
//			
// 			   var $this=$(this);   
//	             decName=document.getElementById('decName').value;//$('#full_name').val();
//	             forum_decName=$('#frmDec').val();
//	             catName=$('#DecType').val();
//	             
//	             dec_date=$('#date2').val();
//	             
//	             dec_allowed=$('#decAllowed').val();
//	             vote_level=$('#vote').val();
//	             dec_level=$('#dec_level').val();
//	             note=$('#decNote').val();
//	             
//	            
//	             $.ajax({
//	                  type: "POST",
//	                       url: url+'ajax2.php?editDec='+item.decID,
//	                       dataType: 'json',
//	                       data: {
//        		            decName:decName,    forum_decName:forum_decName,     note:note, 
//	            	        dec_allowed:dec_allowed,              catName:catName,      dec_date:dec_date,
//	            	        vote_level:vote_level,            dec_level:dec_level     
//	                },
//	                       success: function(json) {
//	                             
//	                       
//	                       $this.dialog('close');
//	                      
///******************************************************************************************/
// 
///****************************************************************************************/                        
//                   }//end success
//	                
//	              });//end ajx
//			 
//	     },//end function save 
	    
				
					Cancel: function() {
						$(this).dialog('close');
						$("#dec_edit_form").remove();
						 
					} 
				
	/***************************************************************************************/		

	/******************************************************************************************/		
			
			},//end button

		     
				close: function() {
				 
				 
				$("#dec_edit_form").remove();
			 
				}
				 
			});//end dialog
			
			$("#dec_edit_form").dialog('open');
 
			 

			 
				
			function updateDate1(date) {
				  
				  $("#date2").val(date);
		       }
				 
				var pickerOpts = {
				  beforeShow: function() {
				    $("#ui-datepicker-div").css("zIndex", 2006).next().css("zIndex", 1006);
				  },
				 dateFormat:'yy-mm-dd' 
				};
	       
				
				 
				
				$("#date2").focus(function() {
					   $(this).datepicker("dialog", null, updateDate1, pickerOpts);
					     return false;
				  		});
				
		    
		    $("#date2").datepicker({ firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
		    
/*********************************************************************************************************/			
		});//end get_json
	
/******************************************************************************************/

	return false;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////MULTI_ACTION///////////////////////////////////////////////////////////////////////////////////
function loadUsers2send2(url,decID,forum_decID,mgr_userID,mgr)
{
	 
 	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url,decID,forum_decID);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	   
	 $.getJSON(url+'ajax2.php?loadUsers&compl='+filter.compl+'&forum_decID='+forum_decID+'&decID='+decID+'&mgr_userID='+mgr_userID+'&mgr='+mgr+'&sort1='+sortBy+search+tag+'&tz='+tz+nocache, function(json){
		
	    resetAjaxErrorTrigger(decID,forum_decID);
 		$('#total1'+decID+forum_decID).html(json.total);
 		
 		  mgr_1= new Array();
 		//userList = new Array();
 		userOrder = new Array();
 		  		
 		userCnt.past1 = userCnt.today1 = userCnt.soon1 = 0;
 		userCnt.total = json.total;
 	 
 		
		var users = '';
	//	var mgr = '';
		
/**************************************************************************************/		
		$.each(json.list, function(i,item){
/************************************************************************************/	
			 
 	 	users += prepareUserStr_Multi(item,url,decID,forum_decID,mgr_userID,mgr);

 			userList[item.userID] = item;
 		 
 		     
 			userOrder.push(parseInt(item.userID));
 			
 		 
 	
 			 

		});//end each
//////////////////////////////////////////////////////////////////// 		
		 $('#edittask2users_multi'+decID+forum_decID).html(users).removeClass().addClass('tasklist')  //CONTENT WINDOW  must have removeClass
		     .css({'position': 'static'})
	 		    .css({'padding': '5px'})
	 			.css({'float':'right'})
	 			.css({'margin-left':'22px'})
	 			.css({'overflow':'hidden'})
	 			.css({'background':'#C6EFF0'})				
	 	        .css({'width':'99%'})
	 			.css({'border':'3px solid #666'});
		 
		
		
		   
			 
		     
		  
		 w = $('#page_task2users_multi'+decID+forum_decID).addClass('page_task2users_multi') ; 
			
		 
		 $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
			if(!flag.windowTaskEditMoved)
			{
				var x,y;
				if(document.getElementById('viewport')) {
					x = Math.floor(Math.min($(window).width(),screen.width)/2 - w.outerWidth()/2);
					y = Math.floor(Math.min($(window).height(),screen.height)/2 - w.outerHeight()/2);
				}
				else {
					x = Math.floor($(window).width()/2 - w.outerWidth()/2);
					y = Math.floor($(window).height()/2 - w.outerHeight()/2);
				}
				if(x < 0) x = 0;
				if(y < 0) y = 0;
				w.css('left',x).css('top',y);
				tmp.editformpos = [x, y];
			}
		 
			w.fadeIn('fast')//rel wimdows
			.css('background','#4569F5') 
		  	.css({'z-iindex': '201'}) 
			.css({'padding':'8px'})
		  	.css({'left':'170px'})
		    .css({'top':'-300px'}) 
		    .css({'float':'left'})			
		    .css({'width':'510px'})
		  	.css({'border':'3px solid #666'}).show();
		$(document).bind('keydown', cancelEdit2);
		 
 	
			
	
			
			
	});//and json		

	
    return false;
  	  
	}
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function SubmitTask2users2 (form,decID,forum_decID ,url,mgr_userID,mgr)//send task for multi users
{
	arr  = new Array();
	arr=updateChecked();
   
	//taskList = new Array();
	
	taskOrder = new Array();
	//user_dest= new Array();
	 
 	if(document.getElementById('task2users'+decID+forum_decID).value == '')
	 
 	{ 
      alert("טעות");
 	  return false;
 	}
 	
 	if(document.getElementById('selectUsers'+decID+forum_decID).value =='' || document.getElementById('selectUsers'+decID+forum_decID).value =='none' )return false;
 	 
 
 	
	var task=document.getElementById('task2users'+decID+forum_decID).value;
	 
	var user = document.getElementById('selectUsers'+decID+forum_decID).value;
 
	var title = document.getElementById('task2users'+decID+forum_decID).value;
 
    var task_allowed	= document.getElementById('catTaskMulti'+decID+forum_decID).value;
    
	
for(var i=0;i<arr.length;i++){	
    var	user_dest= arr[i];
	var tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();	
	
     $.post(url+'ajax2.php?newTask',  { title: title ,user: user ,user_dest: user_dest,forum_decID:forum_decID ,decID:decID,task_allowed:task_allowed, tz:tz, tag:filter.tag }, function(json){		

    	resetAjaxErrorTrigger();
		if(!parseInt(json.total))  return;
		$('#total'+decID+forum_decID).text( parseInt($('#total'+decID+forum_decID).text()) + parseInt(json.total) );
 	 
		
		task.value = '';
		 	
	 
		 var item = json.list[0];
		 taskList[item.taskID] = item;
		 taskList[item.decID] = decID;
		 taskList[item.forum_decID] = forum_decID;
		
		 
		taskOrder.push(parseInt(item.taskID));
		$('#tasklist'+decID+forum_decID).append(prepareTaskStr2(item, url,decID,forum_decID));
		if(sortBy != 0) changeTaskOrder(url,decID,forum_decID);
		$('#taskrow_'+item.taskID).effect("highlight", {color:theme.newTaskFlashColor}, 2000);
		
		
 		  loadTasks2(url,forum_decID,decID);
 	   loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
	}, 'json');
    
     
   
     
 	
 		 
	
	 flag.tagsChanged = true;	
	//return false;       
   }//end for

//loadUsers2(url,forum_decID,decID,mgr_userID,mgr);

if( (arr) ){
	 var i=0;
		for(i=0;i<arr.length;i++){
			
			
			 	
			if($('#checkbox_'+arr[i]+forum_decID).is(':checked')) 
		    { 
				$('#checkbox_'+arr[i]+forum_decID).attr('checked', false); 
	//			arr.pop() ;
		    } 
			
	 
	 }
		
		while(arr.length>0){
			
		 
			arr.pop() ;
		  
	 }		
		
}

document.getElementById('task2users'+decID+forum_decID).value="";
 
   return false;
}	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareUserStr_Multi1(item,url,decID,forum_decID,mgr_userID,mgr)
{
	var url1='/alon-web/olive_prj/mytinytodo_a/';
	 
	id = parseInt(item.userID);
	id_dest = parseInt(item.dest_userID);

 
	   
	prio = parseInt(item.prio);
	
	return '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick="editUser('+id+')">'+
	     

		
		
	  '<div class="task-left" id="check_'+id+'">'+
	                                   
		'<input  id="checkbox_'+id+''+forum_decID+'"  value="'+id+'"   type="checkbox" '+(readOnly?'disabled':'')+' >'+
	  '</div>'+    
	  
  '<div     style="background:#ffdddd"  id="user_'+id+'"  class="task-middle">'+
 	      

  
  
         '<span class="nobr">'+
		        '<span class="task-through">'+
		              prepareuserPrio(prio,id,decID,forum_decID)+
		             '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+
		               prepareuserTagsStr(item.tags,url)+
 	             '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
		         '</span>'+
		     '</span>'+
		
	    
		
	  	'<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
			    
	             '<div id="usernote'+id+'" class="task-note">'+
			        '<span>'+prepareHtml(item.note)+'</span>'+
			     '</div>'+
		    	
			     
			     
			     '<div id="usernotearea'+id+'" class="task-note-area">'+
			          '<textarea id="usernotetext'+id+'"></textarea>'+
				      '<span class="task-note-actions">'+
				        '<a href="#" onClick="return saveUserNote('+id+',\''+url+'\')">שמור</a> |'+
				        '<a href="#" onClick="return cancelUserNote('+id+')">בטל</a>'+
				      '</span>'+
				 '</div>'+
				 
	 			 
	    '</div>'+
	    
	 
"</div></li>\n";
	
	

	
}
/*****************************************************************************************************************************************/
function prepareUserStr_Multi(item,url,decID,forum_decID,mgr_userID,mgr)
{
	id = parseInt(item.userID);
	 
	id_dest = parseInt(item.dest_userID);
	 
    full_name=(item.full_name);
	   
	prio = parseInt(item.prio);
	
 
	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
 
	
if(id==mgr_userID){

	return '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick="editUsermgr('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')">'+
    
	'<div class="task-left" id="check_'+id+'">'+
    
	'<input  id="checkbox_'+id+''+forum_decID+'"  value="'+id+'"   type="checkbox" '+(readOnly?'disabled':'')+' >'+
  '</div>'+    
  	  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  
 	    
	  

'<div     style="background:#ffdddd"  id="user_'+id+'"  class="task-middle">'+
         prepareDuedate2(item.duedate, item.dueClass, item.dueStr)+ 
	       '<span class="nobr">'+
		        '<span class="task-through">'+
		              prepareuserPrio2(prio,id,decID,forum_decID)+
		             '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+
		               prepareuserTagsStr2(item.tags,url,decID,forum_decID,mgr_userID,mgr)+
	             '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
		         '</span>'+
		     '</span>'+
		
	    
		
		'<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
			    

		
	             '<div id="usernote'+id+'" class="task-note">'+
			        '<span>'+prepareHtml(item.note)+'</span>'+
			     '</div>'+
		    	
			     
			     
			     '<div id="usernotearea'+id+'" class="task-note-area">'+
			          '<textarea id="usernotetext'+id+'"></textarea>'+
				      '<span class="task-note-actions">'+
				        '<a href="#" onClick="return saveUserNote('+id+',\''+url+'\')">שמור</a> |'+
				        '<a href="#" onClick="return cancelUserNote('+id+')">בטל</a>'+
				      '</span>'+
				 '</div>'+
				 
	 			 
	 '</div>'+
	    
	 
"</div></li>\n";

}else{ 	
	
	return '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick="editUser2('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')">'+
	     
	'<div class="task-left" id="check_'+id+'">'+
    	'<input  id="checkbox_'+id+''+forum_decID+'"  value="'+id+'"   type="checkbox" '+(readOnly?'disabled':'')+' >'+
     '</div>'+    
  	  
	  
	
 '<div  style="background:#ffdddd"  id="user_'+id+'"  class="task-middle">'+//style color for users
  
	prepareDuedate2(item.duedate, item.dueClass, item.dueStr)+ //in multi_ajx.php get the date of the last task in hebrew
 // prepareUserDuedate(item.duedate, item.dueClass, item.dueStr,item.userID,url)+
	      
	       '<span class="nobr">'+
		        '<span class="task-through">'+
		              prepareuserPrio2(prio,id,decID,forum_decID)+
		             '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+
		               prepareuserTagsStr2(item.tags,url,decID,forum_decID,mgr_userID,mgr)+
 	             '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
		         '</span>'+
		     '</span>'+
		
	    
		
		'<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
			    

		
	             '<div id="usernote'+id+'" class="task-note">'+
			        '<span>'+prepareHtml(item.note)+'</span>'+
			     '</div>'+
		    	
			     
			     
			     '<div id="usernotearea'+id+'" class="task-note-area">'+
			          '<textarea id="usernotetext'+id+'"></textarea>'+
				      '<span class="task-note-actions">'+
				        '<a href="#" onClick="return saveUserNote('+id+',\''+url+'\')">שמור</a> |'+
				        '<a href="#" onClick="return cancelUserNote('+id+')">בטל</a>'+
				      '</span>'+
				 '</div>'+
				 
	 			 
	 '</div>'+
	    
	 
"</div></li>\n";
	
 	  }

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function loadTasks2del2(url,decID,forum_decID)
{
/**************************************************************************************/	
 		
/*************************************************************************************/	 
	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
	$.getJSON(url+'ajax2.php?loadTasks&compl='+filter.compl+'&sort='+sortBy+search+tag+'&decID='+decID+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
		 
		 
		 resetAjaxErrorTrigger();
	   $('#total'+decID+forum_decID).html(json.total);
		  
	 //	   taskList   = new Array();
		 
		 
			taskOrder = new Array();

		 

			if(filter.compl==0 ||filter.compl==1   ){
				
			taskCnt.past = taskCnt.today = taskCnt.soon = 0;
			}
			
			taskCnt.total = json.total;
			 
			 
		
		if(!json || json.total==0){
 	    	 alert('!!אין משימות כרגע');	
 	    return ;
 	    }else{ $('#total'+decID+forum_decID).html(json.total);
 	    }
 	 
		
		var tasks = '';
		
		
/////////////////////////////////////////////////////////////////////		
 		$.each(json.list, function(i,item){                        //
/////////////////////////////////////////////////////////////////////
			
			
			
			tasks += prepareMultiTaskStr(item,url);
			
			
		
			 
			taskList [item.taskID] = item;
			 
		    
			taskOrder.push(parseInt(item.taskID));

			if(filter.compl==0 ||filter.compl==1   ){
			 	
				 changeTaskCnt(item.dueClass);
			}
			  
		
 	
			  	
			 
		
		});//END EACH
		 
////////////////////////////////////////////////////////////////////		
				 
 		if(filter.compl==0 ||filter.compl==1  ){
 		refreshTaskCnt(decID,forum_decID);
 	 }
 			
 			
 		    
 			
// 		    if(filter.compl==0 ||filter.compl==1   ){
// 		    if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
// 			else showhide($('#compl_show'),$('#compl_hide'));
// 		    }
 		 
 			if(json.denied) errorDenied();
 			
//////////////////////////////////////////////////////////////////// 		
		 $('#edittask_multi'+decID+forum_decID).html(tasks).removeClass().addClass('tasklist')  //CONTENT WINDOW  must have removeClass
		     .css({'position': 'static'})
	 		    .css({'padding': '5px'})
	 			.css({'float':'right'})
	 			.css({'margin-left':'22px'})
	 		 .css({'overflow':'hidden'})
	 			.css({'background':'#C6EFF0'})				
	 	        .css({'width':'99%'})
	 			.css({'border':'3px solid #666'});
		 
		
		
	 		   
			 
		     
		  
		 w = $('#page_taskedit_multi'+decID+forum_decID).removeClass().addClass('page_taskedit_multi') ; //to check whay its work with removeClass()
			
		 
		 $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
			if(!flag.windowTaskEditMoved)
			{
				var x,y;
				if(document.getElementById('viewport')) {
					x = Math.floor(Math.min($(window).width(),screen.width)/2 - w.outerWidth()/2);
					y = Math.floor(Math.min($(window).height(),screen.height)/2 - w.outerHeight()/2);
				}
				else {
					x = Math.floor($(window).width()/2 - w.outerWidth()/2);
					y = Math.floor($(window).height()/2 - w.outerHeight()/2);
				}
				if(x < 0) x = 0;
				if(y < 0) y = 0;
				w.css('left',x).css('top',y);
				tmp.editformpos = [x, y];
			}
			
			
			
			//w.fadeIn('fast').css('background','#DFEE54') ;	//.show();
			
			w.fadeIn('fast')//rel wimdows
			.css('background','#4569F5') 
		  	.css({'z-iindex': '2001'}) 
			.css({'padding':'8px'})
		  	.css({'left':'170px'})
		   // .css({'top':'-300px'}) 
		  //  .css({'float':'left'})			
		    .css({'width':'510px'})
		  	.css({'border':'3px solid #666'})
		  	.show();
			//$(document).bind('keydown', cancelEdit2);
		 
 	
			
	
			
			
	});//and json		

	
    return false;
  	  
	}
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function deleteMultiTask2(form,url,decID,forum_decID)
{	

   arr=updateChecked();
  
 	var item = taskList[id];	
 	if(!item) return false;
   
	 
		
	 
	if(!confirm("האים אתה בטוח?")) {
		return false;
	}

	
	
    for(i=0;i<arr.length;i++){
  	 var ids=arr[i];
      
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	
	$.getJSON(url+'ajax2.php?deleteTask='+ids+'&decID='+decID+'&forum_decID='+forum_decID+nocache, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		$('#total'+decID+forum_decID).text( parseInt($('#total'+decID+forum_decID).text()) - 1 );
		var item = json.list[0];
		 
		taskOrder.splice($.inArray(id,taskOrder), 1);
		$('#taskrow_'+item.id).fadeOut('normal', function(){ $(this).remove(); });
		
	 
		
		if(!(taskList[id]) || taskList[id]=='undefined'){
		
			 taskList[item.taskID] = item;
		 
		}
		 
		
		
		refreshTaskCnt(decID,forum_decID);
		delete taskList[id];
		loadTasks2(url,forum_decID,decID);	
    	});
	 
	}
    
	flag.tagsChanged = true;
	
	 
	 
	 if( (arr) ){
		 var i=0;
			for(i=0;i<arr.length;i++){
				
				
				 	
				if($('#checkbox1_'+arr[i] ).is(':checked')) 
			    { 
					$('#checkbox1_'+arr[i]).attr('checked', false); 
					$('li#taskrow_mult_'+arr[i]).fadeOut('normal', function(){ $(this).remove(); });
//					$('#taskrow_'+item.id).fadeOut('normal', function(){ $(this).remove(); });
			    } 
				
		 
		 }
			
			while(arr.length>0){
				
			 
				arr.pop() ;
			  
		 }		
			
	} 
	 
	 
	 
	 
	  return false;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareMultiTaskStr(item,url)
{

	id = parseInt(item.taskID);
    userID = parseInt(item.userID);
     prio = parseInt(item.prio);
	 readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
 	
	  
	 return '<li id="taskrow_mult_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'">'+ 	 
   	 
	 
	 
	        	'<div class="task-left">'+
		    
		            //'<input type="checkbox" class="options"  name="checkbox1" id="myCB"   value='+id+' />'+
		            '<input  id="checkbox1_'+id+'"  value="'+id+'"   type="checkbox" name="checkbox1_'+id+'" >'+
		            
		        '</div>'+
		         
 '<div class="task-middle">'+
		prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		
				 
		
		 '<span class="nobr">'+
	        '<span class="task-through">'+
	        
	             preparePrio2(prio,id,decID,forum_decID)+
	             
	             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+		           
	              prepareTagsStr2(item.tags,url,decID,forum_decID)+
	            '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
	            '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
	         
	         '</span>'+
      '</span>'+
		
		
		
		 
		  
		 
 	    
 "</div></li>\n";


}  
 
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function loadTasks2(url,forum_decID,decID)
{
	
 	tz = -1 * (new Date()).getTimezoneOffset();
 	setAjaxErrorTrigger(url,decID,forum_decID);
    if(filter.search){
    	search = '&s='+encodeURIComponent(filter.search);
    	 
    }else{
    search = '';
    }
 
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
    if(filter.tag){
       tag = '&t='+encodeURIComponent(filter.tag);
   
    }else{
       tag = '';
    }	
    
 	nocache = '&rnd='+Math.random();
	var globl = new Array();
	
 $.getJSON(url+'ajax2.php?loadTasks&compl='+filter.compl+'&sort='+sortBy+search+tag+'&decID='+decID+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
 
 
	 resetAjaxErrorTrigger(decID,forum_decID);
   $('#total'+decID+forum_decID).html(json.total);
	  
 //	   taskList   = new Array();
	 
	 
		taskOrder = new Array();
		 
	
		if(filter.compl==0 ||filter.compl==1   ){
			
		taskCnt.past = taskCnt.today = taskCnt.soon = 0;
		}
		
		taskCnt.total = json.total;
		 
		var tasks = '';
		 
		
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
/////////////////////////////////////////////////////////////////////////////////////////////
					 
			if(filter.compl==3 ){
				 
			tasks += prepareuserTaskStr2(item,url,decID,forum_decID);	
			 
			}else if(filter.compl==7){	
				   tasks += prepareuserTaskStr3(item,url,decID,forum_decID);  
			}else{
			tasks += prepareTaskStr2(item,url,decID,forum_decID);
			}
		
	
		  taskList[item.taskID] = item;

      cancelTimeout =false;
 	    updateProgressBar(item.prog_bar,item.taskID) ;
 	    
 	     
 	    	 
			taskOrder.push(parseInt(item.taskID));
 
		
			if(filter.compl==0 ||filter.compl==1   ){
				 	
			 changeTaskCnt(item.dueClass);
			}
		 
/****************************************/
		});//end each
/*****************************************/		
		
		
		if(filter.compl==0 || filter.compl==1  ){
		refreshTaskCnt(decID,forum_decID);
		}
		
		
	    $('#tasklist'+decID+forum_decID).html(tasks).removeClass().addClass('tasklist')  
	     .css({'position': 'static'})
	    .css({'padding': '5px'})
		.css({'float':'right'})
		.css({'margin-left':'22px'})
		.css({'overflow':'hidden'})
		.css({'background':'#C6EFF0'})				
        .css({'width':'99%'})
		.css({'border':'3px solid #666'});
	   
		
	    if(filter.compl==0 || filter.compl==1   ){
	    if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
		else showhide($('#compl_show'),$('#compl_hide'));
	    }
	 
		if(json.denied) errorDenied();
		
		
		
		
		
/****************************************************************************************/  
		$('.task-middle').hover(function() {

	 	 $(this).addClass('containerHover');


	 	}, function() {

	 	 $(this).removeClass('containerHover');


	 	}); 	

/****************************************************************************************/ 

   loadProgbar(decID,forum_decID);  
   
  	});//end get jason


}//end loadtask
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////////////////////////
function loadProgbar(decID,forum_decID){

	var read_prog='read_prog';
    tz = -1 * (new Date()).getTimezoneOffset();
    nocache = '&rnd='+Math.random();
    var url='../admin/';

    
  $.getJSON(url+'ajax2.php?read_prog='+read_prog+'&forum_decID='+forum_decID+'&decID='+decID+'&tz='+tz+nocache, function(json){
	  
	  var myProg_bar='';	
  ////////////////////////////////////////////////////////
  $.each(json.list, function(i, item){
  ////////////////////////////////////////////////////////
	  
		  if(item.avg ){ 
			  var myProg_bar=parseInt(item.avg);
		
		  }
/***********************************************************************************/	    
		    var progressOpts = {
			          change: function(e, ui) {
			  
			  
			          var val =$("#forumProgbar_"+decID+forum_decID).progressbar("option", "value");
			        
			          if(!(val) || val=='undefined' || val=='0.0000' ) 
			        	  val=0;
			          else 
			        	 val=parseInt(val);
			        	  
	
			          if(!($.browser.msie==true)){ 
			           $("<span>").css({'background':'#2AAFDC'}).text(val + "%").attr("id", "valueForum"+decID+forum_decID)
			            .css({ float: "right", marginTop: -28, marginRight:10 })
			        //    .css({ 'background': 'LightYellow' })
                  // .children("div").css({ 'background': '#3366CC' })
			             .appendTo("#forumProgbar_"+decID+forum_decID);// : $("#value"+decID+forum_decID).text(val + "%");
			          }
			          else{
			             $("#forumProgbar_"+decID+forum_decID).find("#valueForum"+decID+forum_decID).empty();
			        	  if(val<=90){
			        	  $("<span>").css({'background':'#2AAFDC'}).text(" ").text(val + "%").attr("id", "valueForum"+decID+forum_decID)
				        // .css({ marginTop: -18,Right:50 })
				         .css ( {'float': 'right' })
				        .css ( {'z-index': '99999' })
				             .appendTo("#forumProgbar_"+decID+forum_decID);
			          }else{
			           $("#forumProgbar_"+decID+forum_decID).find("#valueForum"+decID+forum_decID).empty();
			        	  $("<span>").css({'background':'#2AAFDC'}).text(val + "%").attr("id", "valueForum"+decID+forum_decID)
					         .css({ float: "left", marginTop: -18, marginRight:10 })
					        .css ( {'height': '30px' })
					         .css ( {'z-index': '99999' })
					             .appendTo("#forumProgbar_"+decID+forum_decID);
			        	  
			          }
			          
			          }
		    
		              }
			        };
	 		   
			        
			        
			        
//			        if(!($.browser.msie==true)){ 
//				           $("<span>").css({'background':'#2AAFDC'}).text(val + "%").attr("id", "valueForum"+decID+forum_decID)
//				            .css({ float: "right", marginTop: -28, marginRight:10 })
//				             .appendTo("#forumProgbar_"+decID+forum_decID);// : $("#value"+decID+forum_decID).text(val + "%");
//				          }else{
//				        	  
//				          }
//				          }
//				        };      
			        
			        
		    
    $("#forumProgbar_"+decID+forum_decID).css ( {'height': '22px' }).css ( {'margin-top': '25px' });	    
    $("#forumProgbar_"+decID+forum_decID).progressbar(progressOpts).css({'background':'red'}).css({'width':'40%'})  ;		  
    $("#forumProgbar_"+decID+forum_decID).progressbar('value', myProg_bar);
    $("#forumProgbar_"+decID+forum_decID).animate({width: 400}, 500).css({'background':'brown'});

  
   

   });//end each
  
 });//end json
 
}//end function progBar
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//SubmitTask2users
function submitNewTask_2 (form,decID,forum_decID ,url,mgr_userID,mgr)
{
  

	taskList = new Array();
	
	taskOrder = new Array();
    
	 
     
 	if(document.getElementById('task'+decID+forum_decID).value == '')
	 
 	{ 
     alert("טעות");
 	return false;
 	}
 	
 	if(document.getElementById('selectUser'+decID+forum_decID).value =='' || document.getElementById('selectUser'+decID+forum_decID).value =='none' )return false;
	
 	
 
	var task=document.getElementById('task'+decID+forum_decID).value;
	 
	var user = document.getElementById('selectUser'+decID+forum_decID).value;
 
	 
	var user_dest= document.getElementById('selectUser1'+decID+forum_decID).value;
	 
	 
	var title = document.getElementById('task'+decID+forum_decID).value;
	
	var task_allowed = document.getElementById('categoryTask'+decID+forum_decID).value;
	
 
	var tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.post(url+'ajax2.php?newTask', { title: title ,user: user ,task_allowed:task_allowed,user_dest: user_dest,forum_decID:forum_decID ,decID:decID,mgr_userID:mgr_userID, tz:tz, tag:filter.tag }, function(json){		
 		 
		
		
		
		resetAjaxErrorTrigger(decID,forum_decID);
		if(!parseInt(json.total))  return;
		$('#total'+decID+forum_decID).text( parseInt($('#total'+decID+forum_decID).text()) + parseInt(json.total) );
 	 
		 
		task.value = '';
	 
		var item = json.list[0];
	 
		
		 taskList[item.taskID] = item;
		 taskList[item.decID] = decID;
		 taskList[item.forum_decID] = forum_decID;
		 
		taskOrder.push(parseInt(item.taskID));
		$('#tasklist'+decID+forum_decID).append(prepareTaskStr2(item, url,decID,forum_decID));
		if(sortBy != 0) changeTaskOrder(url,decID,forum_decID);
		$('#taskrow_'+item.taskID).effect("highlight", {color:theme.newTaskFlashColor}, 2000);
	    
		// loadTasks2(url,forum_decID,decID);			
		 loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
		
		
	 		 	 
	}, 'json');
	 
 	
 
 	document.getElementById('task'+decID+forum_decID).value="";
 
	
	 flag.tagsChanged = true;	
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function deleteTask2(id,decID,forum_decID,url)
{
	//alert("dsdgsdfgsdfgsdfg");
	var decID = document.getElementById('decID').value;	
	// alert(taskList[id].dueClass);
	if(!confirm("האים אתה בטוח?")) {
		return false;
	}
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.getJSON(url+'ajax2.php?deleteTask='+id+'&decID='+decID+'&forum_decID='+forum_decID+nocache, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		$('#total').text( parseInt($('#total').text()) - 1 );
		var item = json.list[0];
	     //alert(item.id);
		taskOrder.splice($.inArray(id,taskOrder), 1);
		$('#taskrow_'+item.id).fadeOut('slow', function(){ $(this).remove(); });
		//$('#taskrow_'+item.id).hide();
		//alert(taskList);
		 // alert(taskList[id]);
				
		
		if(!taskList[id].compl && changeTaskCnt(taskList[id].dueClass, -1)) refreshTaskCnt(decID,forum_decID);
		delete taskList[id];

	});
	flag.tagsChanged = true;
	return false;
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function prepareTaskStr2(item,url,decID,forum_decID)
{
	  flag_level=$('#flag_level').val();
	
	id = parseInt(item.taskID);
  
	 userID = parseInt(item.userID);
	 
	prio = parseInt(item.prio);
	var	 prog_bar = parseInt(item.prog_bar);
	 
	 	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
	 	
 	 	var link= url+'/full_calendar/insert_ajx4.php';
	 //	var link= url+'/progress_a_ch10/source/public/';
 if(flag_level==1){	 	
 return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
    
    // '<input type="hidden" name="Request_Tracking_Number2_'+decID+forum_decID+'" id="Request_Tracking_Number2_'+decID+forum_decID+'" value="'+id+'" />'+
 
     
     
  '<div class="task-actions">'+
		 
          '<a href="#" onClick="return deleteTask2('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
	        '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="מחיקה">'+
	      '</a>'+
         
    
         '<a href="#" onClick="return toggleTaskNote('+id+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
		 '</a>'+
		 
		
		 '<a href="#" onClick="return editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
		    '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
		 '</a>'+
		 
		
   '</div>'+

   
   
   
   
'<div id="my_chk'+id+'" class="task-left">'+
	
        '<input type="checkbox" '+(readOnly?'disabled':'')+' onClick="completeTask('+id+',this,\''+url+'\')" '+(item.compl?'checked':'')+'>'+
       
'</div>'+
   
   
 '<div id="progress_'+id+'">'+      
     prepareProg_bar(id,prog_bar)+
     //updateProgressBar(item.prog_bar,item.taskID)+ 
  '</div>'+    
   
//  '<div id="progress_'+id+'" class="ui-progressbar ui-widget ui-widget-content ui-corner-all">'+
//  '<div class="ui-progressbar-value ui-widget-header ui-corner-left">'+
// '</div></div>'+
	  
	  
 '<div    style="background: #b0b0ff"   class="task-middle"  id="task_'+id+'">'+
		prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		 '<span class="nobr">'+
		        '<span class="task-through">'+
		        
		            preparePrio2(prio,id,decID,forum_decID)+
		             
		             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+		           
 		              prepareTagsStr2(item.tags,url,decID,forum_decID)+
 		            '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
 		            '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'=>'+(item.task_allowed)+'</span>'+
 		         
		         '</span>'+
	         '</span>'+
 
		 
	         
 	    '<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
 		          
 	              '<div id="tasknote'+id+'" class="task-note">'+
 		              '<span>'+prepareHtml(item.note)+'</span>'+
 		          '</div>'+
		          
 		          
 		          
 		          
 		          '<div id="tasknotearea'+id+'" class="task-note-area">'+
		              '<textarea id="notetext'+id+'"></textarea>'+
		               '<span class="task-note-actions">'+
		                 '<a href="#" onClick="return saveTaskNote('+id+',\''+url+'\')">שמור</a>'+
		                 ' | <a href="#" onClick="return cancelTaskNote('+id+')">בטל</a>'+
	                	'</span>'+
		          '</div>'+
		          
		          
		          
	    '</div>'+
 "</div></li>\n";
	  }else if(flag_level==0){
		  
		  return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
		    
		     
		  '<div class="task-actions">'+
			
		        '<a href="#" onClick="return toggleTaskNote('+id+')">'+
				    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
				 '</a>'+
				 
				
				 '<a href="#" onClick="return editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
				    '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
				 '</a>'+
				 
				
		   '</div>'+

		   
		   
		 '<div id="progress_'+id+'">'+      
		     prepareProg_bar(id,prog_bar)+
		  '</div>'+    
		   
			  
		 '<div    style="background: #b0b0ff"   class="task-middle"  id="task_'+id+'">'+
				prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
				 '<span class="nobr">'+
				        '<span class="task-through">'+
				        
				            preparePrio2(prio,id,decID,forum_decID)+
				             
				             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+		           
		 		              prepareTagsStr2(item.tags,url,decID,forum_decID)+
		 		            '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
		 		            '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'=>'+(item.task_allowed)+'</span>'+
		 		         
				         '</span>'+
			         '</span>'+
		 
				 
			         
		 	    '<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
		 		          
		 	              '<div id="tasknote'+id+'" class="task-note">'+
		 		              '<span>'+prepareHtml(item.note)+'</span>'+
		 		          '</div>'+
				          
		 		          
		 		          
		 		          
		 		          '<div id="tasknotearea'+id+'" class="task-note-area">'+
				              '<textarea id="notetext'+id+'"></textarea>'+
				               '<span class="task-note-actions">'+
				               ' | <a href="#" onClick="return cancelTaskNote('+id+')">בטל</a>'+
			                	'</span>'+
				          '</div>'+
				          
				          
				          
			    '</div>'+
		 "</div></li>\n";
		  
	  }
//////////////////////	  
 }//end function   //
//////////////////// 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/***************************************************************************************************/	 

function prepareuserTaskStr2(item,url,decID,forum_decID)//tasks for a spacific user
{ 
	 
 id = parseInt(item.taskID);
     
	 userID = parseInt(item.userID);
	 
	 full_name=item.full_name;
	 
	prio = parseInt(item.prio);
	var	 prog_bar = parseInt(item.prog_bar);
	  flag_level=$('#flag_level').val();	
 if(flag_level==1){ 
return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'"  onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
       

       '<div class="task-actions_b">'+
           '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+  
       '</div>'+

       
     
         '<div class="task-actions">'+
		  '<a href="#" onClick="return toggleTaskNote('+id+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
		  '</a>'+
		 
		 '<a href="#" onClick="return editTask2('+id+','+decID+','+forum_decID+')">'+
		    '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
		 '</a>'+
		 
		 '<a href="#" onClick="return deleteTask('+id+',\''+url+'\')">'+
		   '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="מחיקה">'+
		 '</a>'+
		
	'</div>'+
		
	
	'<div class="task-left">'+
		 //'<input type="checkbox" '+(readOnly?'disabled':'')+' onClick="completeTask('+id+',this,\''+url+'\')" '+(item.compl?'checked':'')+'>'+
		 '<input type="checkbox"  onClick="completeTask('+id+',this,\''+url+'\')" '+(item.compl?'checked':'')+'>'+
    '</div>'+
    
   
    
   '<div id="progress_'+id+'" >'+      
    
    prepareProg_bar(id,prog_bar)+
   
 
  '</div>'+    
     
 '<div class="task-middle">'+prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		
				 
		 
		     '<span class="nobr">'+
		        '<span class="task-through" >'+
		        
		             preparePrio2(prio,id,decID,forum_decID)+
		             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+
		           
		            
		             prepareTagsStr2(item.tags,url,decID,forum_decID)+
 		            '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
 		            '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
		         '</span>'+
	         '</span>'+
 
		
	         
 	    '<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
 		          
 	    
 	    
 	              '<div id="tasknote'+id+'" class="task-note">'+
 		              '<span>'+prepareHtml(item.note)+'</span>'+
 		          '</div>'+
		          
 		           	
 		          
 		          
 		          '<div id="tasknotearea'+id+'" class="task-note-area">'+
		              '<textarea id="notetext'+id+'"></textarea>'+
		               '<span class="task-note-actions">'+
		                 '<a href="#" onClick="return saveTaskNote('+id+',\''+url+'\')">שמור</a>'+
		                 ' | <a href="#" onClick="return cancelTaskNote('+id+')">בטל</a>'+
	                	'</span>'+
		          '</div>'+
		          
		          
	   '</div>'+
 "</div></li>\n";

 }else   if(flag_level==0){
	
	 return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'"  onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+')">'+
     

     '<div class="task-actions_b">'+
         '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+  
     '</div>'+

     
   
       '<div class="task-actions">'+
		  '<a href="#" onClick="return toggleTaskNote('+id+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
		  '</a>'+
		 
		 '<a href="#" onClick="return editTask2('+id+','+decID+','+forum_decID+')">'+
		    '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
		 '</a>'+
		
	'</div>'+
		
	
	
 
  
 '<div id="progress_'+id+'">'+      
  
  prepareProg_bar(id,prog_bar)+
 

'</div>'+    
   
'<div class="task-middle">'+prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		
				 
		 
		     '<span class="nobr">'+
		        '<span class="task-through" >'+
		        
		             preparePrio2(prio,id,decID,forum_decID)+
		             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+
		           
		            
		             prepareTagsStr2(item.tags,url,decID,forum_decID)+
		            '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
		            '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
		         '</span>'+
	         '</span>'+

		
	         
	    '<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
		          
	    
	    
	              '<div id="tasknote'+id+'" class="task-note">'+
		              '<span>'+prepareHtml(item.note)+'</span>'+
		          '</div>'+
		          
		           	
		          
		          
		          '<div id="tasknotearea'+id+'" class="task-note-area">'+
		              '<textarea id="notetext'+id+'"></textarea>'+
		               '<span class="task-note-actions">'+
		                 
		                 ' | <a href="#" onClick="return cancelTaskNote('+id+')">בטל</a>'+
	                	'</span>'+
		          '</div>'+
		          
		          
	   '</div>'+
"</div></li>\n";	 
	 
	 
 }
//////////////////// 
}//end func     ///
//////////////////
/*****************************************************************************************************/
function get_diary(id,url){

$('#diaryButton_'+id).css({'border':'3px solid red'}).bind('click', function() {
	 
			var link= '../admin/a_fullcalendar-1.4.7/selectable.php';
			   	openmypage(link); 
			  
			   // return false;
				 });
		
	
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareuserTaskStr3(item,url,decID,forum_decID)
{ 
	 
 id = parseInt(item.taskID);
     
	 userID = parseInt(item.userID);
	 
	 full_name=item.full_name;
	 
	prio = parseInt(item.prio);
 
return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'"  onDblClick="editTask3('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
       

       '<div class="task-actions_b">'+
           '<span class="task-title">'+prepareHtml(item.dest_name)+'</span>'+  
       '</div>'+

       
     
     '<div class="task-actions">'+
		 '<a href="#" onClick="return toggleTaskNote('+id+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
		 '</a>'+
		 
		 '<a href="#" onClick="return editTask2('+id+','+decID+','+forum_decID+')">'+
		    '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
		 '</a>'+
		 
		 '<a href="#" onClick="return deleteTask('+id+',\''+url+'\')">'+
		   '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="מחיקה">'+
		 '</a>'+
		
	'</div>'+
		
	
	'<div class="task-left">'+
		 '<input type="checkbox" '+(readOnly?'disabled':'')+' onClick="completeTask('+id+',this,\''+url+'\')" '+(item.compl?'checked':'')+'>'+
    '</div>'+
     
 '<div class="task-middle">'+prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		
				 
		 
		     '<span class="nobr">'+
		        '<span class="task-through" >'+
		        
		             preparePrio2(prio,id,decID,forum_decID)+
		             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+
		           
		            
		             prepareTagsStr2(item.tags,url,decID,forum_decID)+
 		            '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
 		            '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
		         '</span>'+
	         '</span>'+
 
		
	         
 	    '<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
 		          
 	    
 	    
 	              '<div id="tasknote'+id+'" class="task-note">'+
 		              '<span>'+prepareHtml(item.note)+'</span>'+
 		          '</div>'+
		          
 		          
 		          
 		          
 		          '<div id="tasknotearea'+id+'" class="task-note-area">'+
		              '<textarea id="notetext'+id+'"></textarea>'+
		               '<span class="task-note-actions">'+
		                 '<a href="#" onClick="return saveTaskNote('+id+',\''+url+'\')">שמור</a>'+
		                 ' | <a href="#" onClick="return cancelTaskNote('+id+')">בטל</a>'+
	                	'</span>'+
		          '</div>'+
		          
		          
	   '</div>'+
 "</div></li>\n";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function editTask3(id,decID,forum_decID,url )
{
	nocache = '&rnd='+Math.random();
	tz = -1 * (new Date()).getTimezoneOffset();
	document.forms['edittask'+decID+forum_decID].elements['Request_Tracking_Number1'+decID+forum_decID].value=id; 
     
	$.getJSON(url+'ajax2.php?loadTask&compl='+filter.compl+'&sort='+sortBy+search+tag+'&id='+id+'&decID='+decID+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
		
		    resetAjaxErrorTrigger();
			taskCnt.past = taskCnt.today = taskCnt.soon = 0;
			 
			 
			var tasks = '';
			
			
//////////////////////////////////////////////////////////////////////////////////////////////			
			$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
	          tasks += prepareuserTaskStr2(item,url,decID,forum_decID);
		
		      taskList[item.taskID] = item;
		    
			  document.getElementById('task_name'+decID+forum_decID ).value =   item.title ; 
			 
			  document.getElementById('note'+decID+forum_decID ).value =  dehtml(item.noteText);
			  
			  document.getElementById('prio'+decID+forum_decID ).value =(item.prio);
			  document.getElementById('edittags'+decID+forum_decID ).value =  dehtml(item.tags.split(',').join(', '));
			  document.getElementById('duedate'+decID+forum_decID ).value =(item.duedate);
			  document.getElementById('userselect'+decID+forum_decID ).value =(item.userID);
			  
			  document.getElementById('userselect1'+decID+forum_decID ).value =(item.dest_userID);
			 
			});
			
	});
	 
	 



 	 
	 $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.7).show();
	  w = $('#page_taskedit'+decID+forum_decID);
	 
	w.scrollTop(w);
	if(!flag.windowTaskEditMoved)
	{
		var x,y;
		if(document.getElementById('viewport')) {
			
			x = Math.floor(Math.min($(window).width(),screen.width)/2 - w.outerWidth()/2);
			y = Math.floor(Math.min($(window).height(),screen.height)/2 - w.outerHeight()/2);
		}
		else {
			 
			x = Math.floor($(window).width()/2 - w.outerWidth()/2);
			y = Math.floor($(window).height()/2 - w.outerHeight()/2);
		}
		if(x < 0) x = 0;
		if(y < 0) y = 0;
		w.css('left',x).css('top',y);
		tmp.editformpos = [x, y];
	}
	w.fadeIn('fast')
	//.addClass(form-row textarea.in500).css({'height':'130px'}).addClass(form-row .in500).css({'width':'99%'})  
	//.css({'position': 'fix'})
	 .css('background','#DC5035') 
  	
     .css({'z-iindex': '201'}) 
	
  	 .css({'padding':'8px'})
  	 .css({'left':'170px'})
// .css({'right':'-50px'}) 
// 	  .css({'margin-left':'22px'})
// 	  .css({'margin-right':'220px'})
  
    .css({'top':'-200px'}) 
    .css({'float':'left'})			
    .css({'width':'510px'})
  	.css({'border':'3px solid #666'})
  	// .form-row textarea.in500.css({'height':'130px'})
   // .form-row.in500.css({'width':'99%'})
	.show();
	
	
 	 

	
	
	
	
	$(document).bind('keydown', cancelEdit2);
	return false;
}

 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editTask2 (id,decID,forum_decID,url,prog_bar)
{    
	//if(item.task_allowed==)
	
   document.forms['edittask'+decID+forum_decID].elements['Request_Tracking_Number1'+decID+forum_decID].value=id; 
   //document.forms['edittask'+decID+forum_decID].elements['prog_bar'+decID+forum_decID].value=id; 
   
   progList[0]=prog_bar;

   $('#progress'+decID+forum_decID).progressbar("option", "value",prog_bar);
  

   if(prog_bar>=100)
       $("#increase"+decID+forum_decID).attr("disabled", "disabled");
   if(prog_bar<100)
		$("#increase"+decID+forum_decID).removeAttr('disabled');
   
 $("#progress"+decID+forum_decID+".ui-progressbar-value").animate({width: prog_bar+"%"}, 500);
 
   
	var item = taskList[id];
     
	if(!item) { return false;}
 

	 document.forms['edittask'+decID+forum_decID].elements['task_name'+decID+forum_decID].value = dehtml(item.title);
	
 
	 document.forms['edittask'+decID+forum_decID].elements['note'+decID+forum_decID].value= item.noteText; 

 
	 document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value= item.tags.split(',').join(', '); 
     
	 document.forms['edittask'+decID+forum_decID].elements['duedate'+decID+forum_decID].value= item.duedate; 
	 
	 
	 
	 if(item.task_allowed=='public')
		 item.task_allowed=0;
	 else if(item.task_allowed=='private')
		 item.task_allowed=1;
	 
	 
	 document.forms['edittask'+decID+forum_decID].elements['catTask'+decID+forum_decID].value= item.task_allowed; 
 
	
 	 sel = document.forms['edittask'+decID+forum_decID].elements['prio'+decID+forum_decID] ;
  
	for(i=0; i<sel.length; i++) {
		if(sel.options[i].value == item.prio) sel.options[i].selected = true;
	}
	
	
	sel1 = document.forms['edittask'+decID+forum_decID].elements['userselect'+decID+forum_decID] ; 
	for(i=0; i<sel1.length; i++) {
		if(sel1.options[i].value == item.userID){
			sel1.options[i].selected = true;
			 
		}
	}
	
	
	
   sel2 = document.forms['edittask'+decID+forum_decID].elements['userselect1'+decID+forum_decID];
	
	for(i=0; i<sel2.length; i++) {
		if(sel2.options[i].value == item.dest_userID){
			sel2.options[i].selected = true;
			 
		}
	}
	
	
	 $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	  w = $('#page_taskedit'+decID+forum_decID);
	 
	w.scrollTop(w);
	if(!flag.windowTaskEditMoved)
	{
		var x,y;
		if(document.getElementById('viewport')) {
			x = Math.floor(Math.min($(window).width(),screen.width)/2 - w.outerWidth()/2);
			y = Math.floor(Math.min($(window).height(),screen.height)/2 - w.outerHeight()/2);
		}
		else {
			x = Math.floor($(window).width()/2 - w.outerWidth()/2);
			y = Math.floor($(window).height()/2 - w.outerHeight()/2);
		}
		if(x < 0) x = 0;
		if(y < 0) y = 0;
		w.css('left',x).css('top',y);
		tmp.editformpos = [x, y];
	}
	 
	w.fadeIn('fast')
	 
	.css('background','#4569F5') 
  	
   .css({'z-iindex': '201'}) 
	
  	 .css({'padding':'8px'})
  	 .css({'left':'170px'})
 
       .css({'top':'-200px'}) 
   
 
  .css({'float':'left'})			
     .css({'width':'430px'})
      //.css({'height':'600px'})
  	.css({'border':'3px solid #666'})
  	
	.show();
	
	
	
	
	$(document).bind('keydown', cancelEdit2);
	return false;
}




/////////////////////////////////////////////////////////////////////////////////
function saveTask3(form,url,decID,forum_decID,mgr_userID,mgr)
{

	ID=($('#Request_Tracking_Number1'+decID+forum_decID).val() );
 	//$('#progresstaskID').attr('id',  id  ); 
var prog_bar=progList[0];// $('#prog_bar'+decID+forum_decID).val();

 
if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
setAjaxErrorTrigger(url);
nocache = '&rnd='+Math.random();

//addtask
var task=$('#task_name'+decID+forum_decID).val();
 
var user = $('#userselect'+decID+forum_decID).val() ;

 
var user_dest=$('#userselect1'+decID+forum_decID).val() ;
 
 
var title = document.getElementById('task_name'+decID+forum_decID).value;	

var prio = document.getElementById('prio'+decID+forum_decID).value;
 
var note = document.getElementById('note'+decID+forum_decID).value;


 
var duedate= document.getElementById('duedate'+decID+forum_decID).value;

var task_allowed=document.getElementById('catTask'+decID+forum_decID).value;
	 
	 
		
			$.ajax({
				
			   type: "POST",
			   
			   url: "../admin/ajax2.php?editTask="+ID+nocache,
			   dataType: 'json',

			   data:  "&title=" + title +"&decID=" + decID + "&forum_decID=" + forum_decID + "&userselect=" +user+ "&userselect1=" +user_dest+ "&prog_bar=" +prog_bar+ "&note=" +note+ "&prio=" +prio+ "&duedate=" +duedate+ "&task_allowed=" +task_allowed,
			  // timeout: 5000 ,
			   success: function(msg){
				
//////////////////////////////////
				var item = msg.list[0];//
//////////////////////////////////			   
				if(!taskList[item.taskID].compl){
					 
					changeTaskCnt(taskList[item.taskID].dueClass, -1);
					 
				}
				 
				taskList[item.taskID] = item;
				
				
	$('#taskrow_'+item.taskID).replaceWith(prepareTaskStr2(item,url,decID,forum_decID));
  				

	
	
	            $('#progress_'+ID).progressbar('destroy');			 
	            cancelTimeout =true;
			 	$('#progress_'+item.taskID) .progressbar("option","value",item.prog_bar);
			 	updateProgressBar2(item.prog_bar,item.taskID);
			     
				
				

	
	
				$('#progress_'+item.taskID).animate({
				    borderColor: "red"
				});
				loadProgbar(decID,forum_decID);
			 
			

 				cancelEdit2(decID,forum_decID,url);
				 
  }//end success ajx
			
});//end ajax1
						
			return false;
 

}
//////////////////////////////////////////////////////////////////////////////////////////////
function saveTask2(form,url,decID,forum_decID,mgr_userID,mgr)
{
		 
	ID=($('#Request_Tracking_Number1'+decID+forum_decID).val() );
	 	//$('#progresstaskID').attr('id',  id  ); 
	var prog_bar=progList[0];// $('#prog_bar'+decID+forum_decID).val();
	 
	 
	if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	
	//addtask
	var task=$('#task_name'+decID+forum_decID).val();
	 
	var user = $('#userselect'+decID+forum_decID).val() ;
 
	 
	var user_dest=$('#userselect1'+decID+forum_decID).val() ;
	 
	 
	var title = document.getElementById('task_name'+decID+forum_decID).value;	
	
	var prio = document.getElementById('prio'+decID+forum_decID).value;
	 
	var note = document.getElementById('note'+decID+forum_decID).value;
	
	
	 
	var duedate= document.getElementById('duedate'+decID+forum_decID).value;
	
	var task_allowed=document.getElementById('catTask'+decID+forum_decID).value;
		 
	
/*************************/	
	//var tags = document.getElementById('edittags'+decID+forum_decID).value;	 
    //var id= document.getElementById('id'+decID+forum_decID).value;
	// document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value
	//tags:form.tags.value
	//document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value
/*************************/	
	
 $.post(url+'ajax2.php?editTask='+ID+nocache, 
   { title: title,forum_decID:forum_decID,decID:decID,userselect:user,userselect1:user_dest,prog_bar:prog_bar, note:note, prio:prio, 
	 tags:document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value, duedate:duedate,task_allowed:task_allowed }, function(json){
		resetAjaxErrorTrigger(decID,forum_decID);
		if(!parseInt(json.total)){alert ("NO JSON"); return; }
//////////////////////////////////		
		var item = json.list[0];//
//////////////////////////////////	   
		if(!taskList[item.taskID].compl){
			 
			changeTaskCnt(taskList[item.taskID].dueClass, -1);
			 
		}
		 
		taskList[item.taskID] = item;
		 
		
		 $('#taskrow_'+item.taskID).replaceWith(prepareTaskStr2(item,url,decID,forum_decID));
		 $('#progress_'+ID).progressbar('destroy');			 
         cancelTimeout =true;
		 $('#progress_'+item.taskID) .progressbar("option","value",item.prog_bar);
		 updateProgressBar2(item.prog_bar,item.taskID);
		
		 
		 
		 
		 
		if(item.note == '') {
			 
			$('#taskrow_'+item.taskID+'>div.task-note-block').addClass('hidden');
		}else{
			 
			$('#taskrow_'+item.taskID+'>div.task-note-block').removeClass('hidden');
		}
		if(sortBy != 0){ 
			changeTaskOrder(url,decID,forum_decID);
		}
		
		
		
		loadProgbar(decID,forum_decID);
		cancelEdit2(decID,forum_decID,url);
		
		if(!taskList[item.taskID].compl) {
			changeTaskCnt(item.dueClass, 1);
			refreshTaskCnt(decID,forum_decID);
		}
		

		$('#taskrow_'+item.taskID).effect("highlight", {color:theme.editTaskFlashColor}, 'slow');
		
		 
		 
		
		

		
         
/****************************************************************************************/  
		$('.task-middle').hover(function() {

	 	 $(this).addClass('containerHover');


	 	}, function() {

	 	 $(this).removeClass('containerHover');


	 	}); 	

/****************************************************************************************/ 	
		filter.coml=3;
		 //loadTasks2(url,forum_decID,decID);
	
		 //loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
	   }  ,'json');//end post
	
  
 

 
 
 $("#edittags"+decID+forum_decID).flushCache();
	flag.tagsChanged = true;
 	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function cancelEdit2 (decID,forum_decID,url,e)
{
	var oTasks = document.getElementsByName("task"+decID+forum_decID);
	
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelEdit2);
	$('#page_taskedit'+decID+forum_decID).hide(); 
	$('#overlay').remove();
	//loadTasks2(url,forum_decID,decID);
	
//	 document.forms['edittask'+decID+forum_decID].elements['task_name'+decID+forum_decID].value = '';
//		
//	 
//	 document.forms['edittask'+decID+forum_decID].elements['note'+decID+forum_decID].value= ''; 
//	 document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value= ''; 
//     
//	 document.forms['edittask'+decID+forum_decID].elements['duedate'+decID+forum_decID].value= ''; 
	 
 
	
	
	
	
	
//	if( document.getElementById('task_name'+decID+forum_decID ).value )   	
//	  document.getElementById('task_name'+decID+forum_decID ).value =''; 
//	  document.getElementById('note'+decID+forum_decID ).value = '';
//	  
//	  document.getElementById('tags'+decID+forum_decID ).value = '';
//	  document.getElementById('duedate'+decID+forum_decID ).value ='';
//	  document.getElementById('userselect'+decID+forum_decID ).value ='';
//	  document.getElementById('userselect1'+decID+forum_decID ).value ='';
	
	
	
	
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
function open_google(link){
//	var googlewin=dhtmlwindow.open("googlebox", "iframe", "http://images.google.com/", "#1: Google Web site", "width=590px,height=350px,resize=1,scrolling=1,center=1", "recal")
	var googlewin=dhtmlwindow.open("googlebox", "iframe", link, "גרף התפלגות", "width=590px,height=350px,resize=1,scrolling=1,center=1", "recal");
	return false;
	googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
	return true;// window.confirm("Close window 1?");
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function opengoog(url,full_name){
	var googlewin=dhtmlwindow.open("googlebox", "iframe", url, full_name+" -יומן אישי", "width=950px,height=800px,left=100px,top=100px,resize=1,scrolling=1", "recal")
    return false;
	googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
	return true;
	}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function opengoog2(url,str_name){
	var googlewin=dhtmlwindow.open("googlebox", "iframe", url, str_name+" -גרף התפלגות", "width=950px,height=800px,left=100px,top=100px,resize=1,scrolling=1", "recal")
    return false; 
	googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
	return true;
	}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function openmypage(link){  
	
//	    ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", link, "נתונים מהמערכת", "width=1000px,height=600px,left=100px,top=100px,resize=1,scrolling=1","recal");
//	  ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", link, "נתונים מהמערכת", "width=1000px,height=600px,left=100px,top=100px,resize=1,scrolling=1");
//		 ajaxwin.onclose=function(){ //Run custom code when window is about to be closed
//			 
//		   return true;
//		
//	    } 
	



	if( (document.getElementById("search_type1").value)==1){ 
		
		 //   ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", link, "נתונים מהמערכת", "width=1000px,height=600px,left=100px,top=100px,resize=1,scrolling=1","recal");
		 ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", link, "נתונים מהמערכת", "width=1000px,height=600px,left=100px,top=100px,resize=1,scrolling=1");
			 ajaxwin.onclose=function(){ //Run custom code when window is about to be closed
				 
			   return true;
			 }
		}else{
//		document.getElementById("search_type").selectedIndex =document.getElementById("search_type").value;	
// 		$('#dhtmlwindowholder').remove();
 		   removeBBBB();	
 		// loadTasks2user();
 				  return   ; 
			 }  




}
/////////////////////////
function  XXXXXXXXX(){
	return;
	
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function openmypage3(link){  
  
	 ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", link, "נתונים מהמערכת", "width=1000px,height=600px,left=100px,top=100px,resize=1,scrolling=1");
	 ajaxwin.onclose=function(){ //Run custom code when window is about to be closed
	  return true;
	 
  } 
}

/*****************************************************************************************************/

function openWin(url){
    //'<a   onClick=" openWin(\''+link+'\')" >' 
	var myBars = 'directories=no,location=no,menubar=no,status=no';

	myBars += ',titlebar=yes,toolbar=no';
    var myOptions = 'scrollbars=yes,width=900,height=700,resizeable=yes';
    var myFeatures = myBars + ',' + myOptions;
    

    var newWin = open(url, 'my_menue', myFeatures);

   
    newWin.focus();

    
     
  }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function loadTasks2user(userID,url,dest_userID,decID,forum_decID)
{
	 
	var decID = document.getElementById('decID').value;
	var forum_decID = document.getElementById('forum_decID').value; 
	 
	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
	$.getJSON(url+'ajax.php?loadTasks2user&compl='+filter.compl+'&sort='+sortBy+search+tag+'&forum_decID='+forum_decID+'&decID='+decID+'&userID='+userID+'&dest_userID='+dest_userID+'&tz='+tz+nocache, function(json){
		resetAjaxErrorTrigger();
		
		  if(!json.total){
	 	    	 alert('!!אין משימות כרגע');	
	 	    return ;
	 	    }else $('#total2').html(json.total);
		
		  
		taskList = new Array();
		taskOrder = new Array();
		taskCnt.past = taskCnt.today = taskCnt.soon = 0;
		taskCnt.total = json.total;
	  
		var tasks = '';
		
		$.each(json.list, function(i,item){
			
			
			 editTask2task (item);
			// edittask2user(item);
			tasks += prepareuserTaskStr2(item,url,decID,forum_decID);	
			//alert(tasks);
			
		   
			 
			 
			
			 
			taskOrder.push(parseInt(item.taskID));

		 //if( !item.compl  )
			 changeTaskCnt(item.dueClass);
				
			 	

		});
	    //if(!filter.compl==1 ){
		refreshTaskCnt(decID,forum_decID);
	   //}
	    $('#tasklist'+decID+forum_decID).html(tasks);
		if(filter.compl) showhide($('#compl_hide'+decID+forum_decID),$('#compl_show'+decID+forum_decID));
		else showhide($('#compl_show'+decID+forum_decID),$('#compl_hide'+decID+forum_decID));
		if(json.denied) errorDenied();
		
	});
	
	return false;
}







/////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function chekBox(form)
{

			
			$("form").submit(
					function()
					{
						
						var checked = $("input[@id="+id+"]:checked").length;

						var query_string = '';
 
						 $("input[@type='checkbox'][@name='checkbox1']").each(
							function()
							{
								if(this.checked)
								{

									query_string += "&checkbox1[]=" + this.value;
								}
								
							});
						alert(query_string);

					});
	



}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateChecked(){
	 
	 var arr = new Array();
	 $('input:checkbox:checked').each( function() {
		 
	   arr.push($(this).val());
	 });
	 
return arr;
}	 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getCheckedNames(){
	 var arr = new Array();
	 var $checked = $('[@name=checkbox1]:checked');
	 $checked.each(function(){ 
	  arr.push($(this).val());
	 });
	 
	 return arr;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function loadtaskusers(url,decID,forum_decID)
{
	 // alert(url);
	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	$.getJSON(url+'ajax.php?loadtaskusers&compl='+filter.compl+'&sort='+sortBy+search+tag+'&tz='+tz+nocache, function(json){
		resetAjaxErrorTrigger();
		$('#total').html(json.total);
		//userList = new Array();
		taskList = new Array();
		taskOrder = new Array();
		taskCnt.past = taskCnt.today = taskCnt.soon = 0;
		taskCnt.total = json.total;
		 
		var tasks = '';
		$.each(json.list, function(i,item){
            
			tasks += prepareuserTaskStr2(item,url,decID,forum_decID);
//			if(item.full_name)
//              alert(item.full_name);				
			taskList[item.taskID] = item;
			taskOrder.push(parseInt(item.taskID));
			if(!item.compl) changeTaskCnt(item.dueClass);
		});
		refreshTaskCnt(decID,forum_decID);
		$('#tasklist').html(tasks);
		if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
		else showhide($('#compl_show'),$('#compl_hide'));
		if(json.denied) errorDenied();
	});
}

function cancelEdit_multi2(decID,forum_decID,e)
{
	 
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelEdit_multi2);
	$('#page_taskedit_multi'+decID+forum_decID).hide();
	$('#overlay').remove();
// 	document.edittask_multi.task.value = '';
//	document.edittask_multi.note.value = '';
//	document.edittask_multi.tags.value = '';
//	document.edittask_multi.duedate.value = '';
	
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cancelEdit_Tuser_multi2(decID,forum_decID,e)
{
	 
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelEdit_multi2);
	$('#page_task2users_multi'+decID+forum_decID).hide();
	$('#overlay').remove();
  
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function prepareHtml(s)
{
	// make URLs clickable
	s = s.replace(/(^|\s|>)(www\.([\w\#$%&~\/.\-\+;:=,\?\[\]@]+?))(,|\.|:|)?(?=\s|&quot;|&lt;|&gt;|\"|<|>|$)/gi, '$1<a href="http://$2" target="_blank">$2</a>$4');
	return s.replace(/(^|\s|>)((?:http|https|ftp):\/\/([\w\#$%&~\/.\-\+;:=,\?\[\]@]+?))(,|\.|:|)?(?=\s|&quot;|&lt;|&gt;|\"|<|>|$)/ig, '$1<a href="$2" target="_blank">$2</a>$4');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function stripHTML(){
var re = /(<([^>]+)>)/gi;
for (i=0; i < arguments.length; i++)
arguments[i].value=arguments[i].value.replace(re, "")
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

function preparePrio2(prio,id,decID,forum_decID)
{
	 
	 
	
	cl = v = '';
	if(prio < 0) { cl = 'prio-neg'; v = '&minus;'+Math.abs(prio); }
	else if(prio > 0) { cl = 'prio-pos'; v = '+'+prio; }
	else { cl = 'prio-o'; v = '&plusmn;0'; }
	 if( ($('#my_task_view').val()==undefined) ){
	return '<span class="task-prio '+cl+'"   style="color:yellow;display:inline;"     onMouseOver="prioPopup2(1,this,'+decID+' ,'+forum_decID+','+id+')" onMouseOut="prioPopup2(0,this,'+decID+','+forum_decID+')"   >'+v+'</span>';
	 }else{
		return '<span class="task-prio '+cl+'" onClick="prioPopup2(1,this,'+decID+' ,'+forum_decID+','+id+')"   onMouseOut="prioPopup2(0,this,'+decID+','+forum_decID+')"   style="color:yellow;display:inline-block;"  >'+v+'</span>';
// return '<span class="task-prio '+cl+'"   style="color:yellow;display:inline;"     onMouseOver="prioPopup2(1,this,'+decID+' ,'+forum_decID+','+id+')" onMouseOut="prioPopup2(0,this,'+decID+','+forum_decID+')"   >'+v+'</span>';
	 }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prioPopup2(act, el,decID,forum_decID,id)
{
	 
 	if(act == 0) {
		clearTimeout(objPrio.timer);
		return;
	}
	offset = $(el).offset();
	 if( ($('#my_task_view').val()==undefined) ){
	$('#priopopup'+decID+forum_decID).css({ position: 'absolute', top: offset.top + 1, left: offset.left + 1 });
	 }else{
		// $('#priopopup'+decID+forum_decID).css({ position: 'relative', top: offset.top-1 , left: offset.left + 1 });
		 //$('#priopopup'+decID+forum_decID).css({ position: 'absolute',  right:'200px', 'z-index': '3000','white-space': 'nowrap' ,overflow:'hidden', bottom:'300',height:'50',  'width': $(el).width()+120 });//.show();
		 $('#priopopup'+decID+forum_decID).css({ position: 'absolute', top: offset.top - 100, left: offset.left + 1 })
	 }
	objPrio.taskID = id;
	objPrio.el = el;
	objPrio.timer = setTimeout("$('#priopopup"+decID+forum_decID+"').show()", 300);
	
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
function prioClick2(prio, el,url,decID,forum_decID){ 

// if(this.parentNode == null)return;
	
	el.blur();
	prio = parseInt(prio);
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	//var forum_decID = document.getElementById('forum_decID').value;
	$.getJSON(url+'ajax2.php?setPrio='+objPrio.taskID+'&prio='+prio+nocache, function(json){
		resetAjaxErrorTrigger();
	});
	
//	
 	taskList[objPrio.taskID].prio = prio;
 	
 	$(objPrio.el).replaceWith(preparePrio2(prio, objPrio.taskID,decID,forum_decID));
 	
//	//alert(forum_decID);
 $('#priopopup'+decID+forum_decID).fadeOut('fast'); //.hide();
 	
 //	$('#priopopup'+decID+forum_decID).hide();
 	 
//	
//	
	if(sortBy != 0) changeTaskOrder(url,decID,forum_decID);
	$('#taskrow_'+objPrio.taskID).effect("highlight", {color:theme.editTaskFlashColor}, 'normal');
	
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 

function prepareDuedate(duedate, c, s)
{
	//prepareDuedate(item.duedate, item.dueClass, item.dueStr)
	//alert(item.duedate);
	// alert(item.dueClass);
	//alert(item.dueStr);
	if(!duedate) return '';
	return '<span class="duedate" title="'+duedate+'">'+s+'</span>';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareSel(userselect,userID)
{
	return '<span class="task-prio '+userID+'"  </span>';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function setAjaxErrorTrigger(url,decID,forum_decID)
{
	resetAjaxErrorTrigger(decID,forum_decID);
	$("#msg"+decID+forum_decID).css({'background-color':'#ff3333'})
	.css({'padding':'1px 4px'}).css({'display':'none'})
	.css({'font-weight':'bold'}).css({'cursor':'pointer'}).ajaxError(function(event, request, settings){
		var errtxt;
		if(request.status == 0) errtxt = 'Bad connection';
		else if(request.status != 200) errtxt = 'HTTP (\''+url+'\'+ajax2.php): '+request.status+'/'+request.statusText;
		else errtxt = request.responseText;
		flashError("Some error occurred (click for details	)", errtxt);
	});
}

function flashError(str, details)
{
	$("#msg"+decID+forum_decID).text(str).css('display','block');
	
	$("#msgdetails"+decID+forum_decID).text(details).css({'border':'1px solid #ff3333'})
	.css({'padding':'1px 4px'}).css({'display':'none'})
	.css({'max-width':'700px'}).css({' background-color':'#fff'});
	
	$("#loading"+decID+forum_decID).hide();
	
	
	$("#msg"+decID+forum_decID)
	.css({'background-color':'#ff3333'})
	.css({'padding':'1px 4px'})
	.css({'display':'none'})
	.css({'font-weight':'bold'})
	.css({'cursor':'pointer'})
	.effect("highlight", {color:theme.errorFlashColor}, 700);
}

function toggleMsgDetails()
{
////	#msg { background-color:#ff3333;  padding:1px 4px; display:none; font-weight:bold; cursor:pointer; }
//	#msgdetails { padding:1px 4px; border:1px solid #ff3333; background-color:#fff; display:none; max-width:700px;  }
	
	 el = $("#msgdetails"+decID+forum_decID).css({'border':'1px solid #ff3333'})
	.css({'padding':'1px 4px'}).css({'display':'none'})
	.css({'max-width':'700px'}).css({' background-color':'#fff'}); 
	if(!el) return;
	if(el.css('display') == 'none') el.show();
	else el.hide();
}

function resetAjaxErrorTrigger(decID,forum_decID)
{
	$("#msg"+decID+forum_decID).hide().unbind('ajaxError');
	
	$("#msgdetails"+decID+forum_decID).text('').css({'border':'1px solid #ff3333'})
	.css({'padding':'1px 4px'}).css({'display':'none'})
	.css({'max-width':'700px'}).css({' background-color':'#fff'}).hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function completeTask(id,ch,url,decID,forum_decID)
{
	//alert(id);
	compl = 0;
	if(ch.checked) compl = 1;
	setAjaxErrorTrigger(url);
	$.getJSON(url+'ajax.php?completeTask='+id+'&compl='+compl+nocache, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		var item = json.list[0];
		//alert(item.id);
		if(item.compl) $('#taskrow_'+id).addClass('task-completed');
		else $('#taskrow_'+id).removeClass('task-completed');
		if(changeTaskCnt(taskList[id].dueClass, item.compl?-1:1)) refreshTaskCnt(decID,forum_decID);
		if(item.compl && !filter.compl) {
			delete taskList[id];
			taskOrder.splice($.inArray(id,taskOrder), 1);
			$('#taskrow_'+item.id).fadeOut('normal', function(){ $(this).remove(); });
			$('#total').html( parseInt($('#total').text())-1 );
		}
	});
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function toggleTaskNote(id)
{ 
 //	alert(id);
	aArea = '#tasknotearea'+id;
	if($(aArea).css('display') == 'none')
	{
		$('#notetext'+id).val(taskList[id].noteText);
		$('#taskrow_'+id+'>div>div.task-note-block').removeClass('hidden');
		$(aArea).css('display', 'block');
		$('#tasknote'+id).css('display', 'none');
		$('#notetext'+id).focus();
	} else {
		cancelTaskNote(id);
	}
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function cancelTaskNote(id)
{
	$('#tasknotearea'+id).css('display', 'none');
	$('#tasknote'+id).css('display', 'block');
	if($('#tasknote'+id).text() == '') {
		$('#taskrow_'+id+'>div>div.task-note-block').addClass('hidden');
	}
	return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function saveTaskNote(id,url)
{
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.post(url+'ajax.php?editNote='+id+nocache, {note: $('#notetext'+id).val()}, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		var item = json.list[0];
		//alert(item.id);
		taskList[id].note = item.note;
		taskList[id].noteText = item.noteText;
		$('#tasknote'+item.id+'>span').html(prepareHtml(item.note));
		cancelTaskNote(item.id);
	}, 'json');
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function showhide(a,b)
{
	a.show();
	b.hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function sortStart(event,ui)
{
	// remember initial order before sorting
	sortOrder = $(this).sortable('toArray');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function orderChanged(event,ui)
{

	 
	// var taskList=new Array(); 
	n = $(this).sortable('toArray');
	
	// remove possible empty id's
	for(i=0; i<sortOrder.length; i++) {
		if(sortOrder[i] == '') { sortOrder.splice(i,1); i--; }
	}
	
	if(n.toString() == sortOrder.toString()){ return;}
	
	// make assoc from array for easy index
	var h0 = new Array();
	for(j=0; j<sortOrder.length; j++) {
		h0[sortOrder[j]] = j;
	}
	var h1 = new Array();
	
	for(j=0; j<n.length; j++) {
		h1[n[j]] = j;
		taskOrder[j] = n[j].split('_')[1];
		
	}
	// prepare param string 	
	var s = '';
	for(j in h0)
	{
		diff = h1[j] - h0[j];
		//alert (diff);
		if(diff != 0) {
			a = j.split('_');
			s += a[1] +'='+ diff+ '&';
			//alert(diff);
			taskList[a[1]].ow += diff;
		}
	}
//	var url='/alon-web/olive_prj/admin/';
	var url='../admin/';
	 
	setAjaxErrorTrigger(url);
	
	nocache = '&rnd='+Math.random();
	
	$.post(url+'ajax2.php?changeOrder'+nocache, { order: s }, function(json){
		resetAjaxErrorTrigger();
	},'json');  
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function timerSearch(url,decID,forum_decID)
{
	 
 	clearTimeout(searchTimer);
	searchTimer = setTimeout("searchTasks2('"+url+"','"+decID+"','"+forum_decID+"')", 500);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function searchTasks2(url,decID,forum_decID)
{
 	 
//	#task, #search { color:#444444; width:300px; }
//	.small-bar{ font-size:8pt; color:#999999; font-weight:normal;}
//	#searchbar { font-size:10pt; font-weight:normal; display:none;  margin-top:5px; }
//	#searchbarkeyword { font-weight:bold; }
  
	filter.search = $('#search'+decID+forum_decID).val();
	
	$('#searchbarkeyword'+decID+forum_decID).text(filter.search).css({'font-weight':'bold'});
	
	if(filter.search != '') $('#searchbar'+decID+forum_decID).css({'font-size':'10pt'})
	.css({'font-weight':'normal'}).css({'display':'none'}).css({'margin-top':'5px'}).fadeOut('fast');
	
	else $('#searchbar'+decID+forum_decID).css({'font-size':'10pt'})
	.css({'font-weight':'normal'}).css({'display':'none'}).css({'margin-top':'5px'}).fadeOut('fast');
	
	loadTasks2(url,forum_decID,decID);
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function tabSelected(event, ui)
{
	var decID = document.getElementById('decID').value;
	var forum_decID = document.getElementById('forum_decID').value; 
//	alert(decID);
	// reload tasks when we return to task tab (from search tab)
	if(ui.index == 0 && filter.search != '') {
		filter.search = '';
		$('#searchbarkeyword'+decID+forum_decID).addClass('searchbarkeyword').text('');
		$('#searchbar'+decID+forum_decID).addClass('searchbar').hide();
		url='/alon-web/olive_prj/admin/';
		loadTasks2(url,forum_decID,decID);
		 
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function dehtml(str)
{
	return str.replace(/&amp;/g,'&').replace(/&quot;/g,'"').replace(/&lt;/g,'<').replace(/&gt;/g,'>');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function errorDenied()
{
	flashError("Some error occurred (click for details	)");
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateAccessStatus(onInit)
{
	//alert('eeeeeeeeee');
	if(flag.needAuth && !flag.isLogged) $("#tasklist").sortable('disable').addClass('readonly');
	else $("#tasklist").sortable('enable').removeClass('readonly');

	if(!flag.canAllRead && !flag.isLogged) {
		$('#page_tasks > h3,#taskcontainer').hide();
		$('#tabs').hide();
	}
	else {
		$('#page_tasks > h3,#taskcontainer').show();
		$('#tabs').show();
	}
	if(flag.needAuth) {
		$('#bar_auth').show();
		showhide($("#bar_login"),$("#bar_logout"));
	}
	if(!flag.needAuth) {
		$("#authstr").text('').hide();
		$('#bar_auth').hide();
	}
	else if(flag.canAllRead && !flag.isLogged) $("#authstr").text(lang.readonly).addClass('attention').show();
	else if(flag.isLogged) showhide($("#bar_logout"),$("#bar_login"));
	else if(!flag.canAllRead) $("#authstr").text('').hide();

	if(onInit == null || !onInit)
	{
		if(flag.isLogged) $("#tabs").tabs('enable',0).tabs('enable',1).tabs('select',0);
		else if(flag.canAllRead) $("#tabs").tabs('enable',1).tabs('select', 1).tabs('disable',0);
		else $("#tabs").tabs('disable',0).tabs('disable',1);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function doAuth(form,url)
{
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.post(url+'ajax.php?login'+nocache, { password: form.password.value }, function(json){
		resetAjaxErrorTrigger();
		form.password.value = '';
		if(json.logged)
		{
			flag.isLogged = true;
			if(filter.search != '') {
				filter.search = '';
				$('#searchbarkeyword').text('');
				$('#searchbar').hide();
			}
			updateAccessStatus();
			loadTasks(url);
		}
		else {
			flashError(lang.invalidpass);
			$('#password').focus();
		}
	}, 'json');
	$('#authform').hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function logout(url)
{
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.getJSON(url+'ajax.php?logout'+nocache, function(json){
		resetAjaxErrorTrigger();
	});
	flag.isLogged = false;
	updateAccessStatus();
	if(flag.canAllRead) {
		loadTasks(url);
	}
	else {
		$('#total').html('0');
		$('#tasklist').html('');
	}
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getRecursParent(el, needle, level)
{
	if(el.nodeName == needle) return el;
	if(!el.parentNode) return null;
	level--;
	if(level <= 0) return false;
	return getRecursParent(el.parentNode, needle, level);
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function isParentId(el, id)
{
//	alert(el); 
	if(el.id && $.inArray(el.id, id) != -1) {alert("true");  return true;}
	if(!el.parentNode){ return null;}
	return isParentId(el.parentNode, id);
}



function showAuth(el)
{
	w = $('#authform');
	if(w.css('display') == 'none')
	{
		offset = $(el).offset();
		w.css({
			position: 'absolute',
			top: offset.top + el.offsetHeight + 3,
			left: offset.left + el.offsetWidth - w.outerWidth()
		}).show();
		$('#password').focus();
	}
	else {
		w.hide();
		el.blur();
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function preloadImg()
{
//	alert("preloadImg");
	for(i in img) {
		o = new Image();
		o.src = img[i][0];
		if(img[i][1] != img[i][0]) {
			o = new Image();
			o.src = img[i][1];
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//changeTaskCnt(item.dueClass);
function changeTaskCnt(cl, dir)
{
	if(!dir) dir = 1;
	else if(dir > 0) dir = 1;
	else if(dir < 0) dir = -1;
	 
	if(cl == 'soon') { taskCnt.soon += dir; return true; }
	else if(cl == 'today') { taskCnt.today += dir; return true; }
	else if(cl == 'past') { taskCnt.past+= dir; return true; }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function refreshTaskCnt(decID,forum_decID)
{
	$('#cnt_past'+decID+forum_decID).text(taskCnt.past);
	$('#cnt_today'+decID+forum_decID).text(taskCnt.today);
	$('#cnt_soon'+decID+forum_decID).text(taskCnt.soon);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function showTaskview2(el,decID,forum_decID,url)
{
$('#taskview'+decID+forum_decID+'.li').hover(function() {

 $(this).addClass('containerHover');

});
/****************************************************************************************/

w = $('#taskview'+decID+forum_decID).addClass('taskview');
		/* .css({'overflow':'hidden'})
		 .css("border", "3px solid red")
	 	 .css({'z-index':'103'})
	 	.css({' background-color':'#f9f9f9'})
	 	.css({'border':'border:1px solid #cccccc'})
	 	.css({'padding':'3px'}); */
	if(w.css('display') == 'none')
	{
		offset = $(el).offset();
		//w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
		w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, left: offset.left , 'min-width': $(el).width() }).show();
		 
	  	loadTasks2(url,forum_decID,decID);
		 $(document).bind("click", taskviewClose2);
	}
	else { 
		 
		el.blur();
		 taskviewClose2(decID,forum_decID,el);
	}
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function showTaskview3(el,decID,forum_decID,url)
{
$('#taskview'+decID+forum_decID+':li').hover(function() {

 $(this).addClass('containerHover');

});

w = $('#taskview'+decID+forum_decID).addClass('taskview');
	
	if(w.css('display') == 'none')
	{
 		offset = $(el).offset();
 		//w.css({ position: 'relative', top: offset.top+el.offsetHeight , left: offset.left-1  , 'min-width': $(el).width() }).show();
	//w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();	 
 		
	//	w.css({ position: 'fix', top: offset.top+el.offsetHeight-2, 'width': $(el).width()+50 }).show();
 		if($.browser.mozilla==true)  {
		w.css({ position: 'absolute', top: offset.top+el.offsetHeight-120, 'min-width': $(el).width() }).show();
 		}else{
 			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-100, 'min-width': $(el).width() }).show();
 			
 		}
	  	loadTasks2(url,forum_decID,decID);
		 $(document).bind("click", taskviewClose2);
	}
	else { 
		 
		el.blur();
		 taskviewClose2(decID,forum_decID,el);
	}
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function taskviewClose2(decID,forum_decID,el)
{
	
//	if(el) {
//	   if(isParentId(el.target, ['taskviewcontainer','taskview'])){ return;}
//	}
//	
//	$(document).unbind("click", taskviewClose2);
	$('#taskview'+decID+forum_decID).hide();

}

/////////////////////////////////////////////////TASK_VIEW////////////////////////////////////////////////////////////////



function setTaskview2(v,url,decID,forum_decID)
{
 
	if(v == 0)
	{
		if(filter.due == '' && filter.compl == 0) {
			return;
		}
		
		
		
		
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_tasks'+decID+forum_decID).text());
		
		
		if(filter.due != '') {
			$('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 0) $('#total'+decID+forum_decID).text(taskCnt.total);
		}
		if(filter.compl != 0) {
			filter.compl = 0;
			$('#total'+decID+forum_decID).text('...');
			//loadTasks2(url,forum_decID,decID );
		}
	}
	
	
	
	else if(v == 1)
	{
	
		if(filter.due == '' && filter.compl == 1) return;
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_compl'+decID+forum_decID).text());
		if(filter.due != '') {
			$('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 1) $('#total'+decID+forum_decID).text(taskCnt.total);
		}
		
		if(filter.compl != 1) {
			filter.compl = 1;
			$('#total'+decID+forum_decID).text('...');
			
			//loadTasks2(url,forum_decID,decID);
			
		}
	}
	
	
	
	else if(v == 2)
	{
		// alert(taskCnt.total);
		if(filter.due == '' && filter.compl == 2) return;
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_compl1'+decID+forum_decID).text());
		if(filter.due != '') {
			$('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 2) $('#total'+decID+forum_decID).text(taskCnt.total);
		}
		if(filter.compl != 2) {
			filter.compl = 2;
			$('#total'+decID+forum_decID).text('...');
			//loadTasks2(url,forum_decID,decID);
		}
	}
	
	
	
	
	
	else if(v == 3)
	{
		//loadtaskusers(url);
		if(filter.due == '' && filter.compl == 3) return;
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_compl2'+decID+forum_decID).text());
		if(filter.due != '') {
			$('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 3) $('#total'+decID+forum_decID).text(taskCnt.total);
		}
		if(filter.compl != 3) {
			filter.compl = 3;
			$('#total'+decID+forum_decID).text('...');
			//loadTasks2(url,forum_decID,decID);
		}
	}
	
	else if(v == 7)
	{
		//loadtaskusers(url);
		if(filter.due == '' && filter.compl == 7) return;
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_compl3'+decID+forum_decID).text());
		if(filter.due != '') {
			$('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 7) $('#total'+decID+forum_decID).text(taskCnt.total);
		}
		if(filter.compl != 7) {
			filter.compl = 7;
			$('#total'+decID+forum_decID).text('...');
			//loadTasks2(url,forum_decID,decID);
		}
	}	 
/****************************************************************************************************/	
	else if(v=='past'|| v=='today'  || v=='soon')
	{
 
		if(filter.due == v) return;
		else if(filter.due != '') {
			
			 $('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due) ;//.css("display", "block");
		}
	 
		 $('#tasklist'+decID+forum_decID).addClass('filter-'+v);// .css("display", "block") 	;

		 
		
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr')
		.css("border-bottom", "1px solid #bbb")
		.css("padding", "1px 2px") 
		.text($('#view_'+v+decID+forum_decID).text());
		

		$('#total'+decID+forum_decID).text(taskCnt[v]);
  		filter.due = v;
/**************************************************************************************/  		
		if(v=='today')
		filter.compl = 4;
		
		if(v=='past')
	    filter.compl = 5;
		
		if(v=='soon')
	    filter.compl = 6;
/**************************************************************************************/	
		$('#total'+decID+forum_decID).text(taskCnt[v]);
	
		filter.due = v;
		 refreshTaskCnt(decID,forum_decID);	
		  //loadTasks2(url,forum_decID,decID); 
/**************************************************************************************/		

 	
// 	$('#cnt_past'+decID+forum_decID).text(taskCnt.past);
//	$('#cnt_today'+decID+forum_decID).text(taskCnt.today);
//	$('#cnt_soon'+decID+forum_decID).text(taskCnt.soon);
 	
 	
 	
 	
 	// $('#cnt_past'+decID+forum_decID ).html(p);  
 	//document.getElementById('cnt_past'+decID+forum_decID ).value =p ;
//		document.getElementById('cnt_today'+decID+forum_decID ).value =taskCnt.today ;
		
		
		  //$('#total'+decID+forum_decID).text(taskCnt[v]);//taskCnt[v];
		 // loadTasks2(url,forum_decID,decID);
//		 $('#total'+decID+forum_decID).text(taskCnt.total);
//		 .text($('#view'+'_'+v+decID+forum_decID).text());
	}
/**********************************************************************************************/	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////TAG_CLOUD/////////////////////////////////////////////////////////////////////

function showTagCloud2(el,url,decID,forum_decID)
{
 
  
	 flag.tagsChanged=true;
		
	w = $('#tagcloud'+decID+forum_decID).addClass('tagcloud');
 	 
	if(w.css('display') == 'none')
	{
		
		if(flag.tagsChanged)
		{
		
		$('#tagcloudcontent'+decID+forum_decID).html('');
		$('#tagcloudload'+decID+forum_decID).addClass('tagcloudload').css({'display':'none'}).show();
		$('#tagcloudbtn'+decID+forum_decID)
		 .css		({'cursor':'pointer'}) ;
		
//   $("#tagcloudcontent"+decID+forum_decID).hover().css( { 'border-color':'#fdfdfd' });

			
			
			
			offset = $(el).offset();
			
			l = Math.ceil(offset.left - w.outerWidth()/2 + $(el).outerWidth()/2);
			if(l<0) l=0;
			
			
			 if( ($('#my_task_view').val()==undefined) ){
				 w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
			}else{
				w.css({ position: 'relative', top: '40px', 'min-width': $(el).width() }).show();
			}
			
			
			
			
			 
    
			setAjaxErrorTrigger(url,decID,forum_decID);
			nocache = '&rnd='+Math.random();
		 
			$.getJSON(url+'ajax2.php?tagCloud&forum_decID='+forum_decID+nocache, function(json){
					
				resetAjaxErrorTrigger();
				$('#tagcloudload'+decID+forum_decID).hide();
				
				
				if(!parseInt(json.total)) return;
				
				 
				var cloud = '';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
	$.each(json.cloud, function(i,item){
	     	  
  cloud += '<a href="#" onClick=\'addFilterTag2("'+item.tag+'","'+url+'","'+decID+'","'+forum_decID+'");tagCloudClose2("'+decID+'","'+forum_decID+'","'+el+'" );return false;\' class="tag w'+item.w+'" >'+item.tag+'</a>';
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('#tagcloudcontent'+decID+forum_decID).html(cloud);
				
			 
					  
	 $("a[class^=tag w]").css("border", "3px solid red").bind("click",function(){
		 
		 $('#tagcloud'+decID+forum_decID).hide();
		 return false;
	 });

 			
				
				flag.tagsChanged = false;
	});//end get json
			
}//end if(flag.tagsChanged)
		else {
		 
			offset = $(el).offset();
			l = Math.ceil(offset.left - w.outerWidth()/2 + $(el).outerWidth()/2);
			if(l<0) l=0;
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, left: l }).show();
 }
	
	//	$(document).bind("click", tagCloudClose2(decID,forum_decID,el));
	
	}//end if(w.css('display') == 'none')
	else {
		//el.blur();
	 //	tagCloudClose2(decID,forum_decID,el);
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function tagCloudClose2(decID,forum_decID,e)	
{
 	 // alert(e.target);
  //  alert(forum_decID);
  //	alert(e);
	if(e) {
		//isParentId(el, id)
		 if(isParentId(e.target, ['tagcloudbtn'+decID+forum_decID,'tagcloud'+decID+forum_decID])){ alert("have taeget"); return;}
	}
	
	$(document).unbind("click", tagCloudClose2(decID,forum_decID,e));
	
	 
	$('#tagcloud'+decID+forum_decID).hide();
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function addFilterTag2(tag,url,decID,forum_decID)
{ 
	filter.tag = tag;
    filter.compl=1;	 
 	loadTasks2(url,forum_decID,decID);
 	filter.compl=0;
	$('#tagcloudbtn'+decID+forum_decID+'>.btnstr').html('תגית:'  + '<span class="tag">'+tag+'</span>');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//cancelTagFilter();tagCloudClose();

function cancelTagFilter2(url,decID,forum_decID)//call by main
{
	  
 $('#tagcloudbtn'+decID+forum_decID+'>.btnstr').text($('#tagcloudbtn'+decID+forum_decID).attr('title'));
	filter.tag = '';
	loadTasks2(url,forum_decID,decID);
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareTagsStr2(tags,url,decID,forum_decID)
{   
	if(!tags || tags == '') return '';
	a = tags.split(',');
	 
	if(!a.length) return '';
	for(i in a) {
		 a[i] = '<a href="#" class="tag" onClick=\'addFilterTag2("'+a[i]+'", "'+url+'","'+decID+'","'+forum_decID+'");return false\'>'+a[i]+'</a>';
	
	}
 return '<span class="task-tags">'+a.join(', ')+'</span>';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function tasklistClick2(e)
{
//	alert(e );
//	var decID = document.getElementById('decID').value;
//	var forum_decID = document.getElementById('forum_decID').value;  
 	node = e.target.nodeName;
 	//alert(node);
	if(node=='SPAN' || node=='LI' || node=='DIV') {
		li = getRecursParent(e.target, 'LI', 10);
		 
		if(li) {
			//if(selTask && li.id != selTask) $('#'+selTask+decID+forum_decID).removeClass('clicked doubleclicked');
			if(selTask && li.id != selTask) $('#'+selTask).removeClass('clicked doubleclicked');
			selTask = li.id;
			
			if($(li).is('.clicked')) $(li).toggleClass('doubleclicked');
			else $(li).addClass('clicked');
		}
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function showSort2(el,decID,forum_decID,url)
{
//var url='/alon-web/olive_prj/admin/';
w = $('#sortform'+decID+forum_decID).addClass('sortform');//.addClass('sortform').addClass('sort').css("border", "3px solid red");
if(w.css('display') == 'none')
{
offset = $(el).offset();


w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, left: offset.left , 'min-width': $(el).width() }).show();
 loadTasks2(url,forum_decID,decID);

 $(document).bind("click", sortClose2);
}
else {
el.blur();
 sortClose2(decID,forum_decID,el);
}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function sortClose2(decID,forum_decID,e)
{
//	if(e) {
//		if(isParentId(e.target, ['sortform'+decID+forum_decID,'sort'+decID+forum_decID])) return;
//	}
//	$(document).unbind("click", sortClose2);
	$('#sortform'+decID+forum_decID).hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function setSort2(v,decID,forum_decID,init)
{
	if(v == 0) $('#sort'+decID+forum_decID+'>.btnstr').text($('#sortByHand'+decID+forum_decID).text());
	else if(v == 1) $('#sort'+decID+forum_decID+'>.btnstr').text($('#sortByPrio'+decID+forum_decID).text());
	else if(v == 2) $('#sort'+decID+forum_decID+'>.btnstr').text($('#sortByDueDate'+decID+forum_decID).text());
 
	else return;
	if(sortBy != v) {
		sortBy = v;
		if(v==0) $("#tasklist"+decID+forum_decID).sortable('enable');
		else $("#tasklist"+decID+forum_decID).sortable('disable');
		if(!init) {
			changeTaskOrder('/alon-web/olive_prj/admin/',decID,forum_decID);
			exp = new Date();
			exp.setTime(exp.getTime() + 3650*86400*1000);	//+10 years
			document.cookie = "sort="+sortBy+'; expires='+exp.toUTCString();
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function changeTaskOrder(url,decID,forum_decID)
{
	if(taskOrder.length < 2) return;
	oldOrder = taskOrder.slice();
	//alert(oldOrder);
	if(sortBy == 0) taskOrder.sort( function(a,b){ 
		  // alert(taskList[b].ow);
			return taskList[a].ow-taskList[b].ow;
		});
	else if(sortBy == 1) taskOrder.sort( function(a,b){
			if(taskList[a].prio != taskList[b].prio) return taskList[b].prio-taskList[a].prio;
			if(taskList[a].dueInt != taskList[b].dueInt) return taskList[a].dueInt-taskList[b].dueInt;
			return taskList[a].ow-taskList[b].ow; 
		});
	else if(sortBy == 2) taskOrder.sort( function(a,b){
			if(taskList[a].dueInt != taskList[b].dueInt) return taskList[a].dueInt-taskList[b].dueInt;
			if(taskList[a].prio != taskList[b].prio) return taskList[b].prio-taskList[a].prio;
			return taskList[a].ow-taskList[b].ow; 
		});
//	else if(sortBy == 3) taskOrder.sort( function(a,b){
//		loadtaskusers(url);
//		if(taskList[a].dueInt != taskList[b].dueInt) return taskList[a].dueInt-taskList[b].dueInt;
//		if(taskList[a].prio != taskList[b].prio) return taskList[b].prio-taskList[a].prio;
//		return taskList[a].ow-taskList[b].ow; 
		 
		 
			  //  $.getScript('in-showTask.php');
		 
	//});
	else return;
	if(oldOrder.toString() == taskOrder.toString()) return;
	o = $('#tasklist'+decID+forum_decID);
	for(i in taskOrder) {
		o.append($('#taskrow_'+taskOrder[i]));
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editFormResize2(decID,forum_decID,startstop, event)
{
//	 var resizeOpts = {
//			  ghost: true,
//	          animate: true,
//	          animateDuration: "fast"				
//	        };
//
//	        //make specified element resizable
//	        $("#page_taskedit"+decID+forum_decID).resizable(resizeOpts);
	
	
	f = $('#page_taskedit'+decID+forum_decID);
	 
	if(startstop == 1) {
		tmp.editformdiff = f.height() - $("'#page_taskedit"+decID+forum_decID+"  textarea").height();
	}
	else if(startstop == 2) {
		//to avoid bug http://dev.jqueryui.com/ticket/3628
		if(f.is('.ui-draggable')) {
			f.css('left',tmp.editformpos[0]).css('top',tmp.editformpos[1]).css('position', 'fixed');
		}
	}
	
	 else  $("'#page_taskedit"+decID+forum_decID+"   textarea").height(f.height() - tmp.editformdiff);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editFormResize(startstop, event)
{
	f = $('#page_taskedit');
	if(startstop == 1) {
		tmp.editformdiff = f.height() - $('#page_taskedit textarea').height();
	}
	else if(startstop == 2) {
		//to avoid bug http://dev.jqueryui.com/ticket/3628
		if(f.is('.ui-draggable')) {
			f.css('left',tmp.editformpos[0]).css('top',tmp.editformpos[1]).css('position', 'fixed');
		}
	}
	else  $('#page_taskedit textarea').height(f.height() - tmp.editformdiff);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editFormResize_multi(startstop, event)
{
	f = $('#page_taskedit_multi');
	if(startstop == 1) {
		tmp.editformdiff = f.height() - $('#page_taskedit_multi textarea').height();
	}
	else if(startstop == 2) {
		//to avoid bug http://dev.jqueryui.com/ticket/3628
		if(f.is('.ui-draggable')) {
			f.css('left',tmp.editformpos[0]).css('top',tmp.editformpos[1]).css('position', 'fixed');
		}
	}
	else  $('#page_taskedit_multi textarea').height(f.height() - tmp.editformdiff);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function getRecursParent(el, needle, level)
{
	if(el.nodeName == needle) return el;
	if(!el.parentNode) return null;
	level--;
	if(level <= 0) return false;
	return getRecursParent(el.parentNode, needle, level);
}


//////////////////////////////////////////////////////////////////////
function DoAction( insertID, decID ) 
{ 
//    $.ajax({ 
//         type: "POST", 
//         url: "dynamic_5b.php", 
//         data: "insertID=" + insertID + "&decID=" + decID, 
//         success: function(msg){ 
//                     alert( "Data Saved: " + msg ); 
//                  } 
//    }); 
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function setMultiview(v,url)
{
	 //alert(v);
	
	if(v == 0)
	{
		if(filter.due == '' && filter.compl == 0) return;
		$('#multicloudbtn .btnstr').text($('#view_multi').text());
		if(filter.due != '') {
			$('#tasklist').removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 0) $('#total').text(taskCnt.total);
		}
		if(filter.compl != 0) {
			filter.compl = 0;
			$('#total').text('...');
			loadTasks2(url);
		}
	}
	
	
	
	else if(v == 1)
	{
		if(filter.due == '' && filter.compl == 1) return;
		$('#multicloudbtn .btnstr').text($('#view_compl4').text());
		if(filter.due != '') {
			$('#tasklist').removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 1) $('#total').text(taskCnt.total);
		}
		
		if(filter.compl != 1) {
			filter.compl = 1;
			$('#total').text('...');
			
			loadTasks2(url);
			
		}
	}
	
	
	
	else if(v == 2)
	{
		if(filter.due == '' && filter.compl == 2) return;
		$('#taskviewcontainer .btnstr').text($('#view_compl4').text());
		if(filter.due != '') {
			$('#tasklist').removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 2) $('#total').text(taskCnt.total);
		}
		if(filter.compl != 2) {
			filter.compl = 2;
			$('#total').text('...');
			loadTasks2(url);
		}
	}
	
	
	
	
	
	else if(v == 3)
	{
		//loadtaskusers(url);
		if(filter.due == '' && filter.compl == 3) return;
		$('#multicloudbtn .btnstr').text($('#view_compl4').text());
		if(filter.due != '') {
			$('#tasklist').removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 3) $('#total').text(taskCnt.total);
		}
		if(filter.compl != 3) {
			filter.compl = 3;
			$('#total').text('...');
			loadTasks2(url);
		}
	}
	

	
	
	else if(v=='past' || v=='today' || v=='soon')
	{
	   	
		if(filter.due == v) return;
		else if(filter.due != '') {
			$('#tasklist').removeClass('filter-'+filter.due);
		}
		$('#tasklist').addClass('filter-'+v);
		$('#multicloudbtn .btnstr').text($('#view_'+v).text());
		$('#total').text(taskCnt[v]);
		filter.due = v;
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//for the menu popup
function showMulti_view2(el,decID,forum_decID)
{
	
	w = $('#multiview'+decID+forum_decID).addClass('multiview');//menu tub
	if(w.css('display') == 'none')
	{
 		offset = $(el).offset();
	
 		if($.browser.mozilla==true)  {
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-2, left: offset.left  , 'min-width': $(el).width() }).show();
			}else
		   w.css({ position: 'absolute', top: offset.top+el.offsetHeight, left: offset.left   , 'min-width': $(el).width() }).show();
 		
 		

		  $(document).bind("click", multiviewClose2);
	}
	
	
	
	else {
		
		 el.blur();
		  multiviewClose2(decID,forum_decID);
	}
	 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function multiviewClose2(decID,forum_decID,e)
{
// alert(e);
//	if(e) {
//		if(isParentId(e.target, ['multicloudbtn','multiview'])) return;
//	}
//	$(document).unbind("click", multiviewClose2);
//	 $('#multiview'+decID+forum_decID).hide();
	
	$('#multiview'+decID+forum_decID).hide();
	 
	 
//	$("#view_multi"+decID+forum_decID).bind('click',function(){
//		 
//		 $("#multiview"+decID+forum_decID).hide();
//		  return false;
//		});
	
	
	
	
	
}

  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareMultiTaskStr2(item,url)
{
 	var decID = document.getElementById('decID').value; 

		 
	//return  '<li  id="taskrow_'+id+'">'+ 
	//'<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" onDblClick="editTask2('+id+')">'+
	 
 	return '<li>'+  
    '<div class="alon">'+
	              
	             '<input type="hidden"  name="decID" id="decID"   value='+decID+' />'+
	           
	             
	            //onClick="return deleteTask2(this, \''+url+'\') ;this.blur();return false";
	             '<input id="delete" type="submit" class="button" name="deleteMultiTask" value="מחק" onClick="return deleteTask2(this, \''+url+'\')" />'  +  
	            
               //  '<input  type="button"   name="delete" id="delete1" value="בטל" onClick="return cancelEdit2();this.blur();return false" />'+
	            
             
  						 
    "</div></li>  \n";
 }
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function myClick(){
	
//$(this).parent().children("ol.tasklist").slideToggle();	

}


//function fnClick1() {
//	$(this).parent().children("div.taskcontainer").slideToggle('slow');
//	return false;
//}
//function fnClick2() {
//	$(this).parent().children("div.taskcontainer").slideDown(500) ;
//	return false;
//}
///////////////////////////////////////////////////////////////////////////////////////////////////////
function progress_bar_plus(decID,forum_decID,prog_bar){
	
	$("#increase_2"+decID+forum_decID).removeAttr('disabled');
	        
	
	

	 var currentval = progList[0];// $("#progress").progressbar("option", "value");
	 //alert(progList[0]);
	             newval = currentval + 10;
	          if(newval===100){
	        	  $("#increase"+decID+forum_decID).attr("disabled", "disabled");
	          }
	          //set new value
	          $("#progress"+decID+forum_decID).progressbar("option", "value", newval);
	          var  newvalue=newval;
	            progList[0]=newvalue;
	          document.forms['edittask'+decID+forum_decID].elements['prog_bar'+decID+forum_decID].value=newvalue;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
function progress_bar_minus(decID,forum_decID){
	
	$("#increase"+decID+forum_decID).removeAttr('disabled');
	          //get current value and increase
	           var currentval =  progList[0];//$("#progress").progressbar("option", "value"),
	            newval = currentval - 10;
	          if(newval===0){
	        	  $("#increase_2"+decID+forum_decID).attr("disabled", "disabled");
	          }
	          //set new value
	          $("#progress"+decID+forum_decID).progressbar("option", "value", newval);
	          var  newvalue=newval;
	            progList[0]=newvalue;
	          document.forms['edittask'+decID+forum_decID].elements['prog_bar'+decID+forum_decID].value=newval;
}
////////////////////////////////////////////////////////////////////////////////////////////////
 
	
//function prepareProg_bar(id,prog_bar)	{
//		return '<span class="task-through" '+ prog_bar +'"  onClick="progBar('+id+','+prog_bar+')" >'+prog_bar+'%</span>';
//} 


function prepareProg_bar(id,prog_bar)	{
	my_prog_bar_html='<span class="task-through" '+ prog_bar +'"  onMouseOver="progBar('+id+','+prog_bar+')" >'+prog_bar+'%</span>';
	 
	return my_prog_bar_html;	  
} 


function progBar(id,prog_bar){
	  
	$('#progress_'+id).progressbar();
 	$("#progress_"+id).animate({width: prog_bar+"%"}, 500).css({'background':'red'});
 	$("#progress_"+id).find('div.ui-progressbar-value ui-widget-header ui-corner-left').css({'background':'white'}).css({'overflow':'hidden'}).html(' ');
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

function updateProgressBar(prog_bar,taskID) {


	
//	setTimeout( 
//		    function(){
//		      if ( !cancelTimeout ) {
//		    	  updateProgressBar(prog_bar,taskID)
//		      }
//		      cancelTimeout = false;
//		    },
//		    2000
//		  );
	
	
	
      if (prog_bar >1 && !cancelTimeout) { 
    	 

           $('#progress_'+taskID).show();
           $('#progress_'+taskID).progressbar({ value : prog_bar }); 
          
           setTimeout(function() { updateProgressBar(prog_bar,taskID) }, 200);
           
      }
  
     
   }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateProgressBar2(prog_bar,taskID) {
 

    if (prog_bar >1) { 

      
          $('#progress_'+taskID).show();
          
          $('#progress_'+taskID).progressbar({ value : prog_bar }); 

     var    x= setTimeout(function() { updateProgressBar(prog_bar,taskID) },0);
        
    }
 
  
    
 }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function resetForm($dialogContent) {
    $dialogContent.find("input").val("");
    $dialogContent.find("textarea").val("");
}

/**************************************************STYLING FUNCTION***********************************************************/

function goLite(FRM,BTN)
{
   window.document.forms[FRM].elements[BTN].style.color = "#AA3300";
   window.document.forms[FRM].elements[BTN].style.backgroundImage = "url(back06b.gif)";
}

function goDim(FRM,BTN)
{
   window.document.forms[FRM].elements[BTN].style.color = "#775555";
   window.document.forms[FRM].elements[BTN].style.backgroundImage = "url(back06a.gif)";
}

/************************************************************************************************************************************/
function loadDecFrm_note_mult(url,decID)
{
	
	tz = -1 * (new Date()).getTimezoneOffset();
 	 
 	nocache = '&rnd='+Math.random();
	 
 $.getJSON(url+'ajax2.php?load_DecFrmNote&decID='+decID+'&tz='+tz+nocache, function(json){
 
 
	  
  
	  
   // noteList   = new Array();
		
		 
		
//////////////////////////////////////////////////////////////////////////////////////////////		
var i=0;		

			$.each(json.list, function(i,item){	
/////////////////////////////////////////////////////////////////////////////////////////////
			 var forum_decID=item.forum_decID;
			 noteObj.forum_decID=item.forum_decID;
			 notes = prepareNoteStr(item,url,decID,forum_decID);
			 
			 if(!(item.note))
	        	 item.note='';
			 noteList[item.forum_decID] = item;
             
			 $('<div id="notelist'+decID+noteObj.forum_decID+'" ></div>').appendTo($('#desc_table'+decID));
			 $('#notelist'+decID+noteObj.forum_decID).html(notes).removeClass().addClass('tasklist')   
	 			.css({'background':'#C6EFF0'})				
				.css({'border':'3px solid #666'}); 
	   	 
/****************************************/
		});//end each
/*****************************************/		
			
			if(json.denied) errorDenied();
			
   });//end json 
 noteObj.forum_decID='';
 //return false;
}//end loadnotes
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/***************************************************************************************************/	 

function prepareNoteStr(item,url,decID,forum_decID)//tasks for a spacific user
{ 
//	 if(!(document.getElementById(flag_level).value)=='undefined'){
//		var flag_level=document.getElementById(flag_level).value;
//	 }
	  flag_level=$('#flag_level').val();
	   item.forum_decName+='<li id="noterow_'+decID+forum_decID+'"  style="width:85%;overflow:hidden;" onDblClick="toggleDecFrmNote('+decID+','+forum_decID+')"  >'+
	    
	    
	 '<div class="task-actions">'+
  
		  '<a href="#" onClick="return toggleDecFrmNote('+decID+','+forum_decID+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="ההחלטה עצמה">'+
		  '</a>'+
		
      '</div>'+   
      
		  
		  
'<div    style="background: #b0b0ff"   class="task-middle"   >'+
			 
			         
    
     ' <div class="task-note-block'+(item.note==''?'hidden':'')+'">'+
		          
     
	    //display the massege on the form
//	          '<div id="decFrm_note'+decID+forum_decID+'" class="task-note">'+
//		            '<span>'+prepareHtml(item.note)+'</span>'+
//		      '</div>'+
		          
		          
		          
		          
		          '<div id="tasknotearea'+decID+forum_decID+'" class="task-note-area" style="overflow:hidden;">'+
		              '<textarea id="noteDecFrm_text'+decID+forum_decID+'"></textarea>'+
		               '<span class="task-note-actions" id="my_span_task">';
	                    if(flag_level==1){
	                item.forum_decName+= '<a href="#" onClick="return saveDecFrmNote('+decID+','+forum_decID+',\''+url+'\')">שמור</a>'+
		                 ' | <a href="#" onClick="return cancelDecFrmNote('+decID+','+forum_decID+')">בטל</a>'+
	                	'</span>'+
	                	
		          '</div>'+
		        
		          
		          			          
	   '</div>'+
 
	 
	 
"</div></li>\n";
	                      
	                      
	        } else{
	        	item.forum_decName+= '<a href="#" onClick="return cancelDecFrmNote('+decID+','+forum_decID+')">בטל</a>'+ 	
	    	
	                	'</span>'+
	                	
		          '</div>'+
	   '</div>'+
"</div></li>\n";
}	
	                    
	                    
	  return   item.forum_decName;                
	                    
	                    
	                    
	
}

/************************************************************************************************************************************/
function loadDecFrm_note(url,decID)
{
	
	tz = -1 * (new Date()).getTimezoneOffset();

    	
 	nocache = '&rnd='+Math.random();
// 	$.getJSON('../admin/ajax2.php?load_DecFrmNote&decID='+decID+'&tz='+tz+'&format=json&jsoncallback=?'+nocache,null,function(data) {
// 		  alert(data);
// 		});
 	
 	
// 	$.ajax({
//  	  dataType:'json',
//		   type: "GET",
//
//		   url: "../admin/ajax2.php",
//		   data: "load_DecFrmNote=" + decID ,   
//
//
//  	   success: function(json) {
// 		alert("gdfgdfgdf");
// 	}	
// });	

	 
 $.getJSON('../admin/ajax2.php?load_DecFrmNote&decID='+decID+'&tz='+tz+nocache, function(json){
 
 //    noteList   = new Array();
		
	  
		
//////////////////////////////////////////////////////////////////////////////////////////////
 	 
var i=0;		

			$.each(json.list, function(i,item){	
/////////////////////////////////////////////////////////////////////////////////////////////
			 var forum_decID=item.forum_decID;
			 noteObj.forum_decID=item.forum_decID;
			 notes = prepareNoteStr(item,url,decID,forum_decID);
	         if(!(item.note))
	        	 item.note='';
			 noteList[item.forum_decID] = item;
          
			 $('<div id="notelist'+decID+noteObj.forum_decID+'" ></div>').appendTo($('#desc_table'));
			 $('#notelist'+decID+noteObj.forum_decID).html(notes).removeClass().addClass('tasklist')   
	 			.css({'background':'#C6EFF0'})				
				.css({'border':'3px solid #666'}); 
	   	 
/****************************************/
		});//end each
/*****************************************/		
			
			if(json.denied) errorDenied();
			
   });//end json 
 noteObj.forum_decID='';
 
}//end loadnotes
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function toggleDecFrmNote(decID ,forum_decID)
{ 
 
	aArea = '#tasknotearea'+decID+forum_decID;
	if($(aArea).css('display') == 'none')
	{
 		$('#noteDecFrm_text'+decID+forum_decID).val(noteList[forum_decID].note);
		 
		$('#noterow_'+decID+forum_decID+'>div>div.task-note-block').removeClass('hidden');
		$(aArea).css('display', 'block');
		$('#decFrm_note'+decID+forum_decID).css('display', 'none');
		$('#noteDecFrm_text'+decID+forum_decID).focus();
		
		
		
		
		
//		$('#notetext'+id).val(taskList[id].noteText);
//		$('#taskrow_'+id+'>div>div.task-note-block').removeClass('hidden');
//		$(aArea).css('display', 'block');
//		$('#tasknote'+id).css('display', 'none');
//		$('#notetext'+id).focus();
		
		
		
		
	} else {
		cancelDecFrmNote(decID,forum_decID);
	}
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function saveDecFrmNote(decID,forum_decID,url)
{
	 setAjaxErrorTrigger(url,decID,forum_decID);
	nocache = '&rnd='+Math.random();
//	$.post(url+'ajax2.php?editDecFrmNote='+decID+nocache, {forum_decID:forum_decID,note: $('#noteDecFrm_text'+decID+forum_decID).val()}, function(json){
	$.post('../admin/ajax2.php?editDecFrmNote='+decID+nocache, {forum_decID:forum_decID,note: $('#noteDecFrm_text'+decID+forum_decID).val()}, function(json){	
			
	 	resetAjaxErrorTrigger(decID,forum_decID);
		if(!parseInt(json.total)) return;
		var item = json.list[0];
		//alert(item.id);
 		noteList[forum_decID].note = item.note;
 		noteList[forum_decID].noteText = item.noteText;
		$('#decFrm_note'+item.forum_decID+'>span').html(prepareHtml(item.note));
		cancelDecFrmNote(item.decID,item.forum_decID);
	}, 'json');
 	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cancelDecFrmNote(decID,forum_decID)
{
	$('#tasknotearea'+decID+forum_decID).css('display', 'none');
	$('#decFrm_note'+decID+forum_decID).css('display', 'block');
	if($('#decFrm_note'+decID+forum_decID).text() == '') {
	$('#noterow_'+decID+forum_decID+'>div>div.task-note-block').addClass('hidden');
	}
	return false;
}








/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function turn_red_task()
{
	$(".my_task").css("backgroundColor","#80ff80");
  greenTimer=setTimeout("turn_green_task()", 500);

}

function turn_green_task()
{
	$(".my_task").css("backgroundColor","#E8F19E");

 blueTimer=setTimeout("turn_blue_task()", 500);

}

function turn_blue_task()
{

		$(".my_task").css("backgroundColor","#ff8080");
  redTimer=setTimeout("turn_red_task()",500);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function turn_red_msg() 
//{   
//	$(".msg").css("backgroundColor","#80ff80");	
//   greenTimer=setTimeout("turn_green_msg()", 500);
//
//}
//
//function turn_green_msg() 
//{ 
//	$(".msg").css("backgroundColor","#E8F19E");	
//
//  blueTimer=setTimeout("turn_blue_msg()", 500);
// 
//}
//
//function turn_blue_msg() 
//{
//	
//		$(".msg").css("backgroundColor","#ff8080");		
//   redTimer=setTimeout("turn_red_msg()",500);
//
//}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function turn_red_error() 
//{   
//	$(".error").css("backgroundColor","#80ff80");	
//   greenTimer=setTimeout("turn_green_error()", 500);
//
//}
//
//function turn_green_error() 
//{ 
//	$(".error").css("backgroundColor","#E8F19E");	
//
//  blueTimer=setTimeout("turn_blue_error()", 500);
// 
//}
//
//function turn_blue_error() 
//{
//	
//		$(".error").css("backgroundColor","#ff8080");		
//   redTimer=setTimeout("turn_red_error()",500);
//
//}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//function turn_red_login() 
//{   
//	$(".bgchange_login").css("backgroundColor","#80ff80");	
//   greenTimer=setTimeout("turn_green_login()", 500);
//
//}
//
//function turn_green_login() 
//{ 
//	$(".bgchange_login").css("backgroundColor","#E8F19E");	
//
//  blueTimer=setTimeout("turn_blue_login()", 500);
// 
//}
//
//function turn_blue_login() 
//{
//	
//		$(".bgchange_login").css("backgroundColor","#ff8080");		
//   redTimer=setTimeout("turn_red_login()",500);
//
//}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function turn_red_tree() 
//{   
//	$(".bgchange_tree").css("background","#E8F19E");	
//   greenTimer=setTimeout("turn_green_tree()", 500);
//
//}
//
//function turn_green_tree() 
//{ 
//	$(".bgchange_tree").css("background","#DBC9AA");	
//
//  blueTimer=setTimeout("turn_blue_tree()", 500);
// 
//}
//
//function turn_blue_tree() 
//{
//	
//		$(".bgchange_tree").css("background","white");		
//   redTimer=setTimeout("turn_red_tree()",500);
//
//}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function turn_red() 
//{   
//	$("#bgchange").css("backgroundColor","#ff8080");	
//   greenTimer=setTimeout("turn_green()", 500);
//
//}
//
//function turn_green() 
//{ 
//	$("#bgchange").css("backgroundColor","#80ff80");	
////	document.getElementById("bgchange").style.backgroundColor="#80ff80"	
//  blueTimer=setTimeout("turn_blue()", 500);
// 
//}
//
//function turn_blue() 
//{
//	//document.getElementById("bgchange").style.backgroundColor="#8080ff"
//		$("#bgchange").css("backgroundColor","#8080ff");		
//   redTimer=setTimeout("turn_red()",500);
//
//}
/////////////////////////////////////////////////////////////////////
//function turn_red2(decID){
//	//document.getElementById("bgchange"+decID).style.backgroundColor="#ff8080"	
//		$("#bgchange"+decID).css("backgroundColor","#ff8080");
//		   greenTimer2=setTimeout("turn_green2("+decID+")", 500);
//
//		}
//
//		function turn_green2(decID) 
//		{ 
//		 
//			//document.getElementById("bgchange"+decID).style.backgroundColor="#80ff80"
//		$("#bgchange"+decID).css("backgroundColor","#80ff80");
//		  blueTimer2=setTimeout("turn_blue2("+decID+")", 500);
//		 
//		}
//
//		function turn_blue2(decID) 
//		{
//			//document.getElementById("bgchange"+decID).style.backgroundColor="#8080ff"
//		$("#bgchange"+decID).css("backgroundColor","#8080ff");
//		   redTimer2=setTimeout("turn_red2("+decID+")",500);
//
//		}	
/////////////////////////////////////////////////////////////
//		function turn_red3(forum_decID){
//			//document.getElementById("bgchange"+decID).style.backgroundColor="#ff8080"	
//				$("#bgchange"+forum_decID).css("backgroundColor","#ff8080");
//				   greenTimer3=setTimeout("turn_green3("+forum_decID+")", 500);
//
//				}
//
//				function turn_green3(forum_decID) 
//				{ 
//				 
//					//document.getElementById("bgchange"+decID).style.backgroundColor="#80ff80"
//				$("#bgchange"+forum_decID).css("backgroundColor","#80ff80");
//				  blueTimer3=setTimeout("turn_blue3("+forum_decID+")", 500);
//				 
//				}
//
			function turn_blue3(forum_decID)
				{
					//document.getElementById("bgchange"+decID).style.backgroundColor="#8080ff"
				$("#bgchange"+forum_decID).css("backgroundColor","#8080ff");
				   redTimer3=setTimeout("turn_red3("+forum_decID+")",500);

				}	
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
				
				
				
				
				
				
				
				
				
				
				
				
		
function blinkFont()
{
  document.getElementById("bgchange").style.color="blue"
  setTimeout("setblinkFont()",1000)
}

function setblinkFont()
{
  document.getElementById("bgchange").style.color="blue"
  setTimeout("setblinkColor()",1000)
}

function blinkColor()
{
  document.getElementById("bgchange").style.background="red"
  setTimeout("setblinkColor()",500)
}

function setblinkColor()
{
  document.getElementById("bgchange").style.background="green"
  setTimeout("blinkColor()",500)
}

////////////////////////////////////////////////////////////////////////////




function make_tab(decID,forum_decID){
	
	
	
	
	
	 $("#tabs"+decID+forum_decID ).tabs({
	  		ajaxOptions: {
	  			error: function(xhr, status, index, anchor) {
	  				$(anchor.hash).html("Failed to load this tab!");
	  			}
	  		}
	  	});
	
	
}


function make_Usertab(decID,forum_decID){
	
	
	
	
	
	 $("#usertabs"+decID+forum_decID ).tabs({
	  		ajaxOptions: {
	  			error: function(xhr, status, index, anchor) {
	  				$(anchor.hash).html("Failed to load this tab!");
	  			}
	  		}
	  	});
	
	
}


 

///***************************************************************************************/
//function removejscssfile(filename, filetype){
//	  var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none" //determine element type to create nodelist from
//	  var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" //determine corresponding attribute to test for
//	  var allsuspects=document.getElementsByTagName(targetelement)
//	  for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
//	   if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
//	    allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
//	  }
//	 }
///**********************************************************************************/ 
//function loadobjs(){
//	if (!document.getElementById)
//	return
//	for (i=0; i<arguments.length; i++){
//	var file=arguments[i]
//	var fileref=""
//	if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
//	if (file.indexOf(".js")!=-1){ //If object is a js file
//	fileref=document.createElement('script')
//	fileref.setAttribute("type","text/javascript");
//	fileref.setAttribute("src", file);
//	 }
//	}
//	if (fileref!=""){
// 
//  	 
//		 document.getElementsByTagName("head").item(0).appendChild(fileref);
//	 loadedobjects+=file+" " //Remember this object as being already added to page
//	}
//	
//	
//	
//	}
//  }	
///***************************************************************************************/	  







