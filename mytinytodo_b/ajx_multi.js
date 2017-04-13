
theme = {
	newTaskFlashColor: '#ffffaa',
	editTaskFlashColor: '#bbffaa',
	errorFlashColor: '#ffffff'
};

//Global vars
dest_forums_conv = new Array();
var  taskOrder;
var prio_arr;
taskList   = new Array();

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
var img = {
	'note': ['images/page_white_text_add_bw.png','images/page_white_text_add.png'],
	'edit': ['images/page_white_edit_bw.png','images/page_white_edit.png'],
	'del': ['images/page_cross_bw.png','images/page_cross.png'] 
	 
};

var taskCnt = { total:0, past: 0, today:0, soon:0 };

var tmp = {};

taskList_arr   = new Array();
var item_id;
var item;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function loadTasks2send(url)
{
	
	var decID = document.getElementById('decID').value;
	 
	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
	$.getJSON(url+'ajax.php?loadTasks&compl='+filter.compl+'&sort='+sortBy+search+tag+'&decID='+decID+'&tz='+tz+nocache, function(json){
		resetAjaxErrorTrigger();
		
		
		
		$('#total').html(json.total);
		taskList  = new Array();
		taskOrder = new Array();
		 
		taskCnt.past = taskCnt.today = taskCnt.soon = 0;
		taskCnt.total = json.total;
		
		if(!json || json.total==0){
 	    	 alert('!!אין משימות כרגע');	
 	    return ;
 	    }else{ $('#total').html(json.total);
 	    }
 	 
		
		var tasks = '';
		
		
/////////////////////////////////////////////////////////////////////		
 		$.each(json.list, function(i,item){                        //
/////////////////////////////////////////////////////////////////////
			
			
			
			tasks += prepareMultiTaskStr(item,url);
			
			
			if(i==json.list.length-1)
				//  tasks += prepareMultiTaskStr2(tasks,url);
		 
			 
			taskList [item.taskID] = item;
			 
		    
			taskOrder.push(parseInt(item.taskID));

		 
			 changeTaskCnt(item.dueClass);
		
 	
			  	
			 
			 $('#edittask_multi').html (tasks);
		});
		 
		
				 
	 
		 $('#edittask_multi').html (tasks);
		 
		
		
		   $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
			 
		     
		  
		 w = $('#page_taskedit_multi');
			
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
			w.fadeIn('fast').css('background','#DFEE54') ;	//.show();
			$(document).bind('keydown', cancelEdit);
		 
 	});		

	 
    return false;
  	  
	}
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function loadTasks2(url,forum_decID,decID)
{
	// alert("dsgfsdfg");
 	tz = -1 * (new Date()).getTimezoneOffset();
 	setAjaxErrorTrigger(url);
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
 
 
	 resetAjaxErrorTrigger();
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
					 
			if(filter.compl==3 || filter.compl==7){
				 
			tasks += prepareuserTaskStr2(item,url,decID,forum_decID);	
			 
			}else{
			tasks += prepareTaskStr2(item,url,decID,forum_decID);
			}
			
		  taskList[item.taskID] = item;
		  
		 
		 
	 
			 
			taskOrder.push(parseInt(item.taskID));
 
		
			if(filter.compl==0 ||filter.compl==1   ){
				 	
			 changeTaskCnt(item.dueClass);
			}
		 

		});//end each
	//	globl.push(taskList);
	//	alert(globl);
		
		
		if(filter.compl==0 ||filter.compl==1  ){
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
	   
		
	    if(filter.compl==0 ||filter.compl==1   ){
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

		  
    	 
  	});//end get jason
  
  //loadUsers2(url,forum_decID);
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 
// $('.task-middle' ).bind('click',function(){
//		var ID=($('#Request_Tracking_Number2_'+decID+forum_decID).val() );
//	 	 alert(ID);
	
//   var arv = dest_forums_conv.toString();
//   
// 
//  
//     $.ajax({
//		   type: "POST",
//		   url: "../admin/make_task.php",
//		 
//		  data:  "rebuild="+ arv + "&decID=" + decID ,
// 		  
//		     
//
//		   success: function(msg){
//		 
//		 
//			 $('table#my_dec'+decID).html(' ').append('<p>'+msg+'</p>');
//
//		 }  
//		 
//		}) ; 
	 
//     return false;
//});	 	 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function submitNewTask_2 (form,decID,forum_decID ,url)
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
 
	var tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.post(url+'ajax2.php?newTask', { title: title ,user: user ,user_dest: user_dest,forum_decID:forum_decID ,decID:decID, tz:tz, tag:filter.tag }, function(json){		
 		 
		
		
		
		resetAjaxErrorTrigger();
		if(!parseInt(json.total))  return;
		$('#total'+decID+forum_decID).text( parseInt($('#total'+decID+forum_decID).text()) + parseInt(json.total) );
 	 
		 
		task.value = '';
	 
		var item = json.list[0];
		//alert(item);
//		taskList[decID+forum_decID,item.taskID] = item;
//		 taskList[decID+forum_decID,item.decID] = decID;
//		 taskList[decID+forum_decID,item.forum_decID] = forum_decID;
//		 taskList[decID+forum_decID,item.userID] = user;
		
		
		 taskList[item.taskID] = item;
		 taskList[item.decID] = decID;
		 taskList[item.forum_decID] = forum_decID;
		// taskList[item.userID] = user;
		
		 
		taskOrder.push(parseInt(item.taskID));
		$('#tasklist'+decID+forum_decID).append(prepareTaskStr2(item, url,decID,forum_decID));
		if(sortBy != 0) changeTaskOrder(url,decID,forum_decID);
		$('#taskrow_'+item.taskID).effect("highlight", {color:theme.newTaskFlashColor}, 2000);
	     loadTasks2(url,forum_decID,decID);
	 	//loadUsers(url);
	 	 //editUsertask(url,user );
	}, 'json');
  
	 
 	document.getElementById('task'+decID+forum_decID).value="";
 
	
	 flag.tagsChanged = true;	
	return false;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareTaskStr2(item,url,decID,forum_decID)
{
 	 
	id = parseInt(item.taskID);
  
	 userID = parseInt(item.userID);
	 
	prio = parseInt(item.prio);
 
	 	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
	 
 return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" onDblClick="editTask2('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
    
    // '<input type="hidden" name="Request_Tracking_Number2_'+decID+forum_decID+'" id="Request_Tracking_Number2_'+decID+forum_decID+'" value="'+id+'" />'+
 
     
     
  '<div class="task-actions">'+
		 
          '<a href="#" onClick="return deleteTask('+id+',\''+url+'\')">'+
	        '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="'+lang.actionDelete+'">'+
	      '</a>'+
         
    
         '<a href="#" onClick="return toggleTaskNote('+id+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="'+lang.actionNote+'">'+
		 '</a>'+
		 
		
		 '<a href="#" onClick="return editTask2('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
		    '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="'+lang.actionEdit+'">'+
		 '</a>'+
		 
		 
	
      '</div>'+
		
		'<div class="task-left">'+
		'<input type="checkbox" '+(readOnly?'disabled':'')+' onClick="completeTask('+id+',this,\''+url+'\')" '+(item.compl?'checked':'')+'>'+
		 
	  '</div>'+
       
	  
	  
	  
	  
 '<div    style="background: #b0b0ff"   class="task-middle"  id="task_'+id+'">'+
		prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		
				 
		 
		     '<span class="nobr">'+
		        '<span class="task-through">'+
		        
		             preparePrio2(prio,id,decID,forum_decID)+
		             
		             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+		           
 		              prepareTagsStr2(item.tags,url,decID,forum_decID)+
 		            '<span class="task-date">'+lang.taskDate(item.date)+'</span>'+
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
		                 '<a href="#" onClick="return saveTaskNote('+id+',\''+url+'\')">'+lang.actionNoteSave+'</a>'+
		                 ' | <a href="#" onClick="return cancelTaskNote('+id+')">'+lang.actionNoteCancel+'</a>'+
	                	'</span>'+
		          '</div>'+
		          
		          
		          
	    '</div>'+
 "</div></li>\n";
 }
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareuserTaskStr2(item,url,decID,forum_decID)
{ 
	 
 id = parseInt(item.taskID);
     
	 userID = parseInt(item.userID);
	 
	 full_name=item.full_name;
	 
	prio = parseInt(item.prio);
 
return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'"  onDblClick="editTask3('+id+','+decID+','+forum_decID+',\''+url+'\')">'+
       

       '<div class="task-actions_b">'+
           '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+  
       '</div>'+

       
     
     '<div class="task-actions">'+
		 '<a href="#" onClick="return toggleTaskNote('+id+')">'+
		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="'+lang.actionNote+'">'+
		 '</a>'+
		 
		 '<a href="#" onClick="return editTask2('+id+','+decID+','+forum_decID+')">'+
		    '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="'+lang.actionEdit+'">'+
		 '</a>'+
		 
		 '<a href="#" onClick="return deleteTask('+id+',\''+url+'\')">'+
		   '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="'+lang.actionDelete+'">'+
		 '</a>'+
		
	'</div>'+
		
	
	'<div class="task-left">'+
		 '<input type="checkbox" '+(readOnly?'disabled':'')+' onClick="completeTask('+id+',this,\''+url+'\')" '+(item.compl?'checked':'')+'>'+
    '</div>'+
     
 '<div class="task-middle">'+prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		
				 
		 
		     '<span class="nobr">'+
		        '<span class="task-through">'+
		        
		             preparePrio2(prio,id,decID,forum_decID)+
		             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+
		           
		            
		             prepareTagsStr2(item.tags,url,decID,forum_decID)+
 		            '<span class="task-date">'+lang.taskDate(item.date)+'</span>'+
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
		                 '<a href="#" onClick="return saveTaskNote('+id+',\''+url+'\')">'+lang.actionNoteSave+'</a>'+
		                 ' | <a href="#" onClick="return cancelTaskNote('+id+')">'+lang.actionNoteCancel+'</a>'+
	                	'</span>'+
		          '</div>'+
		          
		          
	   '</div>'+
 "</div></li>\n";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function editTask3(id,decID,forum_decID,url)
{
 
	
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
//	 
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
function editTask2 (id,decID,forum_decID,url)
{
   document.forms['edittask'+decID+forum_decID].elements['Request_Tracking_Number1'+decID+forum_decID].value=id; 
 
	var item = taskList[id];
     
	if(!item) { return false;}
  
	 
	 document.forms['edittask'+decID+forum_decID].elements['task_name'+decID+forum_decID].value = dehtml(item.title);
	
 
	 document.forms['edittask'+decID+forum_decID].elements['note'+decID+forum_decID].value= item.noteText; 

	 
	 //	document.forms['edittask'+decID+forum_decID].id.value = item.taskID;
	 //document.forms['edittask'+decID+forum_decID].elements['id'+decID+forum_decID].value 
 
	 document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value= item.tags.split(',').join(', '); 
     
	 document.forms['edittask'+decID+forum_decID].elements['duedate'+decID+forum_decID].value= item.duedate; 
	 
 
 
	
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
	// w.fadeIn('fast').css('background','#DC5035');	//.show();
	
	
	 
	w.fadeIn('fast')
	 
	.css('background','#DC5035') 
  	
   .css({'z-iindex': '201'}) 
	
  	 .css({'padding':'8px'})
  	 .css({'left':'170px'})
 
       .css({'top':'-200px'}) 
   
 
  .css({'float':'left'})			
     .css({'width':'510px'})
  	.css({'border':'3px solid #666'})
  	
	.show();
	
	
	
	
	$(document).bind('keydown', cancelEdit2);
	return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function saveTask2(form,url,decID,forum_decID)
{
	 
 	var ID=($('#Request_Tracking_Number1'+decID+forum_decID).val() );
	
	 
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
	
	
	
/*************************/	
	//var tags = document.getElementById('edittags'+decID+forum_decID).value;	 
    //var id= document.getElementById('id'+decID+forum_decID).value;
	// document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value
	//tags:form.tags.value
	//document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value
/*************************/	
	
 $.post(url+'ajax2.php?editTask='+ID+nocache, 
   { title: title,userselect:user,userselect1:user_dest, note:note, prio:prio, tags:document.forms['edittask'+decID+forum_decID].elements['tags'+decID+forum_decID].value, duedate:duedate }, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)){alert ("NO JSON"); return; }
		
		var item = json.list[0];
	   
		if(!taskList[item.taskID].compl){
			 
			changeTaskCnt(taskList[item.taskID].dueClass, -1);
			 
		}
		 
		taskList[item.taskID] = item;
 
		$('#taskrow_'+item.taskID).replaceWith(prepareTaskStr2(item,url,decID,forum_decID));
		 
		if(item.note == '') {
			 
			$('#taskrow_'+item.taskID+'>div.task-note-block').addClass('hidden');
		}else{
			 
			$('#taskrow_'+item.taskID+'>div.task-note-block').removeClass('hidden');
		}
		if(sortBy != 0){ 
			changeTaskOrder(url,decID,forum_decID);
		}
		cancelEdit2(decID,forum_decID);
		
		if(!taskList[item.taskID].compl) {
			changeTaskCnt(item.dueClass, 1);
			refreshTaskCnt(decID,forum_decID);
		}
		
		
		$('#taskrow_'+item.taskID).effect("highlight", {color:theme.editTaskFlashColor}, 'normal');
		

		
/****************************************************************************************/  
		$('.task-middle').hover(function() {

	 	 $(this).addClass('containerHover');


	 	}, function() {

	 	 $(this).removeClass('containerHover');


	 	}); 	

/****************************************************************************************/ 	
		filter.coml=3;
		loadTasks2(url,forum_decID,decID);
		
	   }  , 'json');//end post
	
 
 $("#edittags"+decID+forum_decID).flushCache();
	flag.tagsChanged = true;
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function cancelEdit2 (decID,forum_decID,e)
{
	var oTasks = document.getElementsByName("task"+decID+forum_decID);
	
	//alert(oTasks.value );  //outputs “red”
	/// alert(document.edittask+decID+forum_decID.task+decID+forum_decID.value);
	//if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelEdit2);
	$('#page_taskedit'+decID+forum_decID).hide(); 
	$('#overlay').remove();
	
	
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function openpage(url,decID,forum_decID){
//	 $(this).bind('click', function() {
//		 
//	  	 
//		  	var link=url+'find3.php?&forum_decID='+forum_decID ;
//		  	 
//		   	openmypage(link); 
//		  
//		    return false;
//			 });
//	
//	
//}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function openmypage(link){ //Define arbitrary function to run desired DHTML Window widget codes
		 ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", link, "נתונים מהמערכת", "width=1000px,height=600px,left=100px,top=100px,resize=1,scrolling=1");
		 ajaxwin.onclose=function(){ //Run custom code when window is about to be closed
		  return true;
		// window.confirm("Close this window?");
	    } 
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



function deleteTask2(form,url,decID,forum_decID)
{	 
	
   
   arr=updateChecked();
   // alert(arr);
 
 	var item = taskList[id];	
 	if(!item) return false;
   
	 
	var decID = document.getElementById('decID').value;	
	 
	if(!confirm(lang.confirmDelete)) {
		return false;
	}

	
	
    for(i=0;i<=arr.length;i++){
  	 var ids=arr[i];
   
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	
	$.getJSON(url+'ajax.php?deleteTask='+ids+'&decID='+decID+nocache, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		$('#total').text( parseInt($('#total').text()) - 1 );
		var item = json.list[0];
		 
		taskOrder.splice($.inArray(id,taskOrder), 1);
		$('#taskrow_'+item.id).fadeOut('normal', function(){ $(this).remove(); });
		
	 
		
		if(!(taskList[id]) || taskList[id]=='undefined'){
			//  taskList = new Array();
			 taskList[item.taskID] = item;
		  //alert("zxvzxcvzxcv");
		 //	alert(taskList2[id]);
		}
		 
		
		//if(!taskList2[id].compl && changeTaskCnt(taskList2[id].dueClass	, -1)) refreshTaskCnt();
		refreshTaskCnt(decID,forum_decID);
		delete taskList[id];
		
    	});
	 
	}
    
	flag.tagsChanged = true;
	 loadTasks2(url);	
	  return false;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function chekBox(form)
{

//	alert('alonmordeltete');
	
	//$("#delete").click(
			
			$("form").submit(
					function()
					{
						
						var checked = $("input[@id="+id+"]:checked").length;
						//alert(checked);
						var query_string = '';
					//	$("input:checkbox:checked").each() 
						 $("input[@type='checkbox'][@name='checkbox1']").each(
							function()
							{
								//alert('alonmordeltete');
								if(this.checked)
								{
//									alert('alonmordeltete');
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editTask2task(id)
{
	
	var item = taskList[id];

	if(!item) return false;
	document.edittask.task.value = dehtml(item.title);
	//document.edittask.note.value = item.noteText;
	 document.edittask.id.value = item.taskID;
	//document.edittask.tags.value = item.tags.split(',').join(', ');
	document.edittask.duedate.value = item.duedate;
	 
 
	
	
	sel = document.edittask.prio;
	
	for(i=0; i<sel.length; i++) {
		if(sel.options[i].value == item.prio) sel.options[i].selected = true;
	}
	
	
	sel1 = document.edittask.userselect;
	
	for(i=0; i<sel1.length; i++) {
		if(sel1.options[i].value == item.userID){
			sel1.options[i].selected = true;
			//alert(sel1.options[i].value);
		}
	}
	
	
	
   sel2 = document.edittask.userselect1;
	
	for(i=0; i<sel2.length; i++) {
		if(sel2.options[i].value == item.dest_userID){
			sel2.options[i].selected = true;
			//alert(sel2.options[i].value);
		}
	}
	
	
	 
	 return false;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cancelEdit_multi(e)
{
	//alert("dddddddddddddd");
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelEdit);
	$('#page_taskedit_multi').hide();
	$('#overlay').remove();
// 	document.edittask_multi.task.value = '';
//	document.edittask_multi.note.value = '';
//	document.edittask_multi.tags.value = '';
//	document.edittask_multi.duedate.value = '';
	
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

function preparePrio2(prio,id,decID,forum_decID)
{
 
	
	cl = v = '';
	if(prio < 0) { cl = 'prio-neg'; v = '&minus;'+Math.abs(prio); }
	else if(prio > 0) { cl = 'prio-pos'; v = '+'+prio; }
	else { cl = 'prio-o'; v = '&plusmn;0'; }
	return '<span class="task-prio '+cl+'"  onMouseOver="prioPopup2(1,this,'+decID+' ,'+forum_decID+','+id+')" onMouseOut="prioPopup2(0,this,'+decID+','+forum_decID+')">'+v+'</span>';
	//return '<span class="task-prio '+cl+'" onMouseOver="prioPopup(1,this,'+id+')" onMouseOut="prioPopup(0,this)">'+v+'</span>';

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prioPopup2(act, el,decID,forum_decID,id)
{
//alert(forum_decID);	
//prioPopup2(1,this,decID,forum_decID,id)	
//	var decID = document.getElementById('decID').value;
//	var forum_decID = document.getElementById('forum_decID').value;  
	 
 	if(act == 0) {
		clearTimeout(objPrio.timer);
		return;
	}
	offset = $(el).offset();
	$('#priopopup'+decID+forum_decID).css({ position: 'absolute', top: offset.top + 1, left: offset.left + 1 });
	objPrio.taskID = id;
	objPrio.el = el;
	objPrio.timer = setTimeout("$('#priopopup"+decID+forum_decID+"').show()", 300);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function prioClick2(prio, el,url,decID,forum_decID)
{
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

function setAjaxErrorTrigger(url)
{
	resetAjaxErrorTrigger();
	$("#msg"+decID+forum_decID).css({'background-color':'#ff3333'})
	.css({'padding':'1px 4px'}).css({'display':'none'})
	.css({'font-weight':'bold'}).css({'cursor':'pointer'}).ajaxError(function(event, request, settings){
		var errtxt;
		if(request.status == 0) errtxt = 'Bad connection';
		else if(request.status != 200) errtxt = 'HTTP (\''+url+'\'+ajax.php2): '+request.status+'/'+request.statusText;
		else errtxt = request.responseText;
		flashError(lang.error, errtxt);
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

function resetAjaxErrorTrigger()
{
	$("#msg"+decID+forum_decID).hide().unbind('ajaxError');
	
	$("#msgdetails"+decID+forum_decID).text('').css({'border':'1px solid #ff3333'})
	.css({'padding':'1px 4px'}).css({'display':'none'})
	.css({'max-width':'700px'}).css({' background-color':'#fff'}).hide();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function deleteTask(id,url,decID,forum_decID)
{
	//alert("dsdgsdfgsdfgsdfg");
	var decID = document.getElementById('decID').value;	
	// alert(taskList[id].dueClass);
	if(!confirm(lang.confirmDelete)) {
		return false;
	}
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.getJSON(url+'ajax.php?deleteTask='+id+'&decID='+decID+nocache, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		$('#total').text( parseInt($('#total').text()) - 1 );
		var item = json.list[0];
	     //alert(item.id);
		taskOrder.splice($.inArray(id,taskOrder), 1);
		$('#taskrow_'+item.id).fadeOut('normal', function(){ $(this).remove(); });
		
		//alert(taskList);
		 // alert(taskList[id]);
				
		
		if(!taskList[id].compl && changeTaskCnt(taskList[id].dueClass, -1)) refreshTaskCnt(decID,forum_decID);
		delete taskList[id];

	});
	flag.tagsChanged = true;
	return false;
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
	var url='/alon-web/olive_prj/admin/';
	 
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
	flashError(lang.denied);
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
	 
	// alert("dddddddddd");
	
	if(!dir) dir = 1;
	else if(dir > 0) dir = 1;
	else if(dir < 0) dir = -1;
	 
	
	// alert(taskCnt.soon);
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
$('#taskview'+decID+forum_decID+':li').css("border", "3px solid red").hover(function() {

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
		//$(document).bind("click", taskviewClose2);
	}
	else {
		 
		el.blur();
		//taskviewClose2(decID,forum_decID,el);
	}
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function taskviewClose2(decID,forum_decID,el)
{
	
	if(el) {
	   if(isParentId(el.target, ['taskviewcontainer','taskview'])){ return;}
	}
	
	$(document).unbind("click", taskviewClose2);
	$('#taskview'+decID+forum_decID).hide();

}

/////////////////////////////////////////////////TASK_VIEW////////////////////////////////////////////////////////////////



function setTaskview2(v,url,decID,forum_decID)
{
 
	
	if(v == 0)
	{
	
		if(filter.due == '' && filter.compl == 0) {return;}
		
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_tasks'+decID+forum_decID).text());
		if(filter.due != '') {
			$('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 0) $('#total'+decID+forum_decID).text(taskCnt.total);
		}
		if(filter.compl != 0) {
			filter.compl = 0;
			$('#total'+decID+forum_decID).text('...');
			loadTasks2(url,forum_decID,decID );
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
			
			loadTasks2(url,forum_decID,decID);
			
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
			loadTasks2(url,forum_decID,decID);
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
			loadTasks2(url,forum_decID,decID);
		}
	}
	
	else if(v == 7)
	{alert("sdfgdsfg");
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
			loadTasks2(url,forum_decID,decID);
		}
	}	 
/****************************************************************************************************/	
//	.tasklist li.task-completed .duedate { color:#777777; border-color:#777777; }
//	
//	.tasklist.filter-past li,
//	#tasklist.filter-today li, 
//	#tasklist.filter-soon li { display:none; }
//	
//	.tasklist.filter-past li.past,
//	#tasklist.filter-today li.today, 
//	#tasklist.filter-soon li.soon { display:block; }
//	
//	.tasklist.filter-past li.task-completed,
//	#tasklist.filter-today li.task-completed, 
//	#tasklist.filter-soon li.task-completed { display:none; }

	
/****************************************************************************************/	
//	else if(v=='past' || v=='today' || v=='soon')
//	{
//		if(filter.due == v) return;
//		else if(filter.due != '') {
//			$('#tasklist').removeClass('filter-'+filter.due);
//		}
//		$('#tasklist').addClass('filter-'+v);
//		$('#taskviewcontainer .btnstr').text($('#view_'+v).text());
//		$('#total').text(taskCnt[v]);
//		filter.due = v;
//	}
 
/******************************************************************************************/
	
	
	
	else if(v=='past'|| v=='today'  || v=='soon')
	{
 
		if(filter.due == v) return;
		else if(filter.due != '') {
			
//			$('#tasklist'+decID+forum_decID).removeClass('filter-'+v+''+li).css("display", "none") 	;
//			$('#tasklist'+decID+forum_decID).removeClass('filter-'+v+''+li+v).css("display", "block") 	;
//			$('#tasklist'+decID+forum_decID).removeClass('filter-'+v+''+li.task-completed).css("display", "none") 	;
			//$('#taskview'+decID+forum_decID+':li').css("border", "3px solid red").
			
			
			 $('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due) ;//.css("display", "block");
			
			//$('#tasklist'+decID+forum_decID).removeClass('filter-'+filter.due+':li.'+filter.due+'' ) .css("display", "block");
		}
	 
		 $('#tasklist'+decID+forum_decID).addClass('filter-'+v);// .css("display", "block") 	;
		//$('#tasklist'+decID+forum_decID).addClass('filter-'+v+':li.'+v+'' ).css("display", "block");
		 
		
		$('#taskviewcontainer'+decID+forum_decID+' .btnstr')
		.css("border-bottom", "1px solid #bbb")
		.css("padding", "1px 2px") 
		.text($('#view_'+v+decID+forum_decID).text());
		

		$('#total'+decID+forum_decID).text(taskCnt[v]);
  		filter.due = v;
/**************************************************************************************/  		
/****************************/		
		if(v=='today')
		filter.compl = 4;
		
		if(v=='past')
	    filter.compl = 5;
		
		if(v=='soon')
	    filter.compl = 6;
		//var p=	  $('#cnt_past'+decID+forum_decID ).html()    ;
	 
	
/*****************************/	
		$('#total'+decID+forum_decID).text(taskCnt[v]);
	
		filter.due = v;
		 refreshTaskCnt(decID,forum_decID);	
		  loadTasks2(url,forum_decID,decID); 
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
		
	w = $('#tagcloud'+decID+forum_decID).addClass('tagcloud').css("border", "3px solid red");
 	 
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
			
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
			
			 
    
			setAjaxErrorTrigger(url);
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
	$('#tagcloudbtn'+decID+forum_decID+'>.btnstr').html(lang.tagfilter + '<span class="tag">'+tag+'</span>');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//cancelTagFilter();tagCloudClose();

function cancelTagFilter2(url,decID,forum_decID)
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
w = $('#sortform'+decID+forum_decID).addClass('sortform').addClass('sort').css("border", "3px solid red");
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
	if(e) {
		if(isParentId(e.target, ['sortform'+decID+forum_decID,'sort'+decID+forum_decID])) return;
	}
	$(document).unbind("click", sortClose2);
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

function multiviewClose(e)
{
	if(e) {
		if(isParentId(e.target, ['multicloudbtn','multiview'])) return;
	}
	$(document).unbind("click", multiviewClose);
	$('#multiview').hide();
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function showMulti_view(el)
{
	//alert(el);
	w = $('#multiview');
	if(w.css('display') == 'none')
	{
 		offset = $(el).offset();
	
 		if($.browser.mozilla==true)  {
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-2, left: offset.left  , 'min-width': $(el).width() }).show();
			}else
		   w.css({ position: 'absolute', top: offset.top+el.offsetHeight, left: offset.left   , 'min-width': $(el).width() }).show();
 		
		$(document).bind("click", multiviewClose);
	}
	
	
	
	else {
		el.blur();
		multiviewClose();
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editTaskMulti2(item)
{
	
	 var item = taskList[id];
 	//alert(item.userID);
	if(!item) return false;
	document.edittask_multi.task.value = dehtml(item.title);
	document.edittask_multi.note.value = item.noteText;
	document.edittask_multi.id.value = item.taskID;
	document.edittask_multi.tags.value = item.tags.split(',').join(', ');
	document.edittask_multi.duedate.value = item.duedate;
	 
 
	
	
	sel = document.edittask_multi.prio;
	
	for(i=0; i<sel.length; i++) {
		if(sel.options[i].value == item.prio) sel.options[i].selected = true;
	}
	
	
	sel1 = document.edittask_multi.userselect;
    //alert(item.userID);
	for(i=0; i<sel1.length; i++) {
		if(sel1.options[i].value == item.userID){
			sel1.options[i].selected = true;
			//alert(sel1.options[i].value);
		}
	}
	
	
	
   sel2 = document.edittask_multi.userselect1;
	
	for(i=0; i<sel2.length; i++) {
		if(sel2.options[i].value == item.dest_userID){
			sel2.options[i].selected = true;
			//alert(sel2.options[i].value);
		}
	}
}	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareMultiTaskStr(item,url)
{

	id = parseInt(item.taskID);
    userID = parseInt(item.userID);
     prio = parseInt(item.prio);
	 readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
 	
	// '<form  id="my_form"  action=""  method="post"   onSubmit="return deleteTask2(this , \''+url+'\')"; >'+
	 return  '<li id="taskrow_'+id+'" >'+
	 //'<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'" >'+    
	 
   	 
	 
	 
	        	'<div class="task-left">'+
		    
		            '<input type="checkbox" class="options"  name="checkbox1" id="myCB"   value='+id+' />'+
		            
		        '</div>'+
		         
 '<div class="task-middle">'+
		prepareDuedate(item.duedate, item.dueClass, item.dueStr)+ 
		
				 
		 
		     '<span class="nobr">'+
		        '<span class="task-through">'+
		        
		          
		             
		             '<span class="task-title">'+prepareHtml(item.title)+'</span>'+		           
 		           
 		            '<span class="task-date">'+lang.taskDate(item.date)+'</span>'+
 		            '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
 		         
		         '</span>'+
	         '</span>'+
 
		 
 	    
 "</div></li>\n";


}  
 
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 
