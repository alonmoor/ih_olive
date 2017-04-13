//.css("border", "3px solid red");
 //$('a#my_tooltipID').attr("id",'tooltipID');
//  window.onload = makeRequest;
//window.onload = sendData;
//  var xmlHttp = false;



 // var xmlHttp = createXmlHttpRequestObject();

// creates an XMLHttpRequest instance
function createXmlHttpRequestObject() 
{
  // will store the reference to the XMLHttpRequest object
  var xmlHttp;
  // create the XMLHttpRequest object
  try
  {
    // assume IE7 or newer or other modern browsers
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    // assume IE6 or older
    try
    {
      xmlHttp = new ActiveXObject("Microsoft.XMLHttp");
    }
    catch(e) { }
  }
  // return the created object or display an error message
  if (!xmlHttp)
    alert("Error creating the XMLHttpRequest object.");
  else 
    return xmlHttp;
}

theme = {
	 
	newUserFlashColor: '#ffffaa',
	editUserFlashColor: '#bbffaa',
	errorFlashColor: '#ffffff'
};
theme=true;


//var xmlHttp = new XMLHttpRequest(); 
//xmlHttp=false;
var userList,userOrder,mgr_1,mgr_2;
//lang=new lang();
var filter = { compl:0, search:'', tag:'', due:'' };
var sortuserOrder; //save user order before dragging
var searchTimer;
var objPrio = {};
var item={};
var objDuedate = {};

var flag_level='';
var user_form='';

var selUser = 0;
  
var selTask = 0;
var sortBy =  0;
var flag = { needAuth:false, isLogged:false, canAllRead:true, tagsuserChanged:true,
		windowUserEditMoved:false, windowUsertaskEditMoved:false , windowUsertaskEditMoved_b:false ,usertask:false };
var tz = 0;
var img = {
	'note': ['images/page_white_text_add_bw.png','images/page_white_text_add.png'],
	'edit': ['images/page_white_edit_bw.png','images/page_white_edit.png','images/opened.gif','images/pie6.gif','images/icon.gif'],
    'show': ['images/Email_icons_009.gif','images/objects_066.gif' ],
	'showup': ['images/Email_icons_057.gif','images/icon_new.gif' ],
	'showforme': ['images/black_icons_164.gif','images/Email_icons_040.gif' ],
	'showformewin': ['images/Email_icons_084.gif','images/Email_icons_068.gif' ],
	'del': ['images/page_cross_bw.png','images/page_cross.png'] 
};


var usertaskCnt_b = { total_b:0, past1: 0, today1:0, soon1:0 };
var usertaskCnt = { total2:0, past1: 0, today1:0, soon1:0 };
var userCnt = { total1:0, past1: 0, today1:0, soon1:0 };
 
var tmp = {};
userList= new Array();















function prepareUserStr_tags(item,url,decID,forum_decID,mgr_userID,mgr)
{

    var flag_userID=$('#flag_userID').val();
	
	id = parseInt(item.userID);
	 
	id_dest = parseInt(item.dest_userID);
	 
    full_name=(item.full_name);
	   
	prio = parseInt(item.prio);
	
 
	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
	flag_level=$('#flag_level').val();
	
if(flag_level==1){	
if(id==mgr_userID){
 
	 
	
return  '<li style="height:40px;" >'+
			'<a class="my_forum_details" href="javascript:void(0)" onClick="return my_forum_details('+item.forum_decID+')">'+
			'<h1 style="text-align:center;margin-top:3px;margin-left:100px;"> '+item.forum_decName+'</h1>'+
			'</a>'+
		  
			'</li>'+
			 

'<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"    onDblClick="editReg_user('+id+',\''+url+'\')"  >'+

'<div class="task-actions_user">'+
		

   '<ul class="menu" onMouseOver="return hover_img();" >'+
	 
	  
		 
 	'<li>'+	
        '<a href="javascript:void(0)" onClick="return toggleUserNote('+id+')"   onMouseOver="return hover_img();" >'+
 		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1];" onMouseOut="this.src=img.note[0]"  >'+
 		 '</a>'+
 	     '<em>רשימות</em>'+      
 	  '</li>'+
 	  
 	      
 	      
 	      
 	    '<li>'+
 		 '<a href="javascript:void(0)"  onClick="return  editReg_user('+id+',\''+url+'\')"   >'+
 		     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]"  >'+
 		 '</a>'+
 		  '<em>עריכה</em>'+
 		'</li>'+
 		  
           
	  '</ul></div>'+

	  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

'<div     style="background:#13E72C"  id="user_'+id+'"  class="task-middle">'+
    prepareDuedate2(item.duedate, item.dueClass, item.dueStr)+
  
	       '<span class="nobr">'+
		        '<span class="task-through">'+
		        
		             '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+
		              
		            
	             
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
	return '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick="editReg_user('+id+',\''+url+'\')">'+
	     
	  '<div class="task-actions_user">'+
		
	  '<ul class="menu" onMouseOver="return hover_img();" >'+
	  

	

	'<li>'+
	      '<a href="#" onClick="return toggleUserNote('+id+')">'+
	        '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" >'+
	      '</a>'+
	      '<em>רשימות</em>'+
	'</li>'+
		
		  
	'<li>'+
	'<a href="#"  onClick="return editReg_user('+id+',\''+url+'\')" >'+
		     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה" >'+
		  '</a>'+
		  '<em>עריכה</em>'+
	'</li>'+
		  
	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		  
 
    
    
    
    
 	  '</ul></div>'+

 	  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 	  
 	  
			  
	  
	
 '<div  style="background:#23E3EA;font-weight:bold;"  id="user_'+id+'"  class="task-middle">'+//style color for users
 	'<span class="nobr">'+
		        '<span class="task-through">'+

		             '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+

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
////////////////////////////////
  }else if(flag_level==0){  /// 
///////////////////////////////	
	  if(id==mgr_userID){

	return '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick=" editReg_user('+id+',\''+url+'\')"  >'+
		    
			  '<div class="task-actions_user">'+
				
			  
			      '<a href="#" onClick="return toggleUserNote('+id+')">'+
			        '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
			      '</a>'+
				
				
				  '<a href="#"  onClick="return  editReg_user('+id+',\''+url+'\')">'+
				     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
				  '</a>'+
				
				  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  

		'<div     style="background:#13E72C"  id="user_'+id+'"  class="task-middle">'+
		   
 
			       '<span class="nobr">'+
				        '<span class="task-through">'+
				            
				             '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+
				              
				            
			            
				         '</span>'+
				     '</span>'+
				
			    
				
				'<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
					    

				
			             '<div id="usernote'+id+'" class="task-note">'+
					        '<span>'+prepareHtml(item.note)+'</span>'+
					     '</div>'+
				    	
					     
					     
					     '<div id="usernotearea'+id+'" class="task-note-area">'+
					          '<textarea id="usernotetext'+id+'"></textarea>'+
						      '<span class="task-note-actions">'+
						        '<a href="#" onClick="return cancelUserNote('+id+')">בטל</a>'+
						      '</span>'+
						 '</div>'+
						 
			 			 
			 '</div>'+
			    
			 
		"</div></li>\n";

		}else{ 	
	 user_form= '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick=" editReg_user('+id+',\''+url+'\')">'+
			     
			  '<div class="task-actions_user">'+
				

			  
			      '<a href="#" onClick="return toggleUserNote('+id+')">'+
			        '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
			      '</a>'+
				
				
				  '<a href="#"  onClick="return  editReg_user('+id+',\''+url+'\')">'+
				     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
				  '</a>';
				
				  
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 	  
		 	if(flag_userID==id)  
			 	  
			  
			
	user_form+= '<div  style="background:#23E3EA;font-weight:bold;"  id="user_'+id+'"  class="task-middle">'+//style color for users
		
			'<span class="nobr">'+
				        '<span class="task-through">'+
				           
				             '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+
				            
				            
				         '</span>'+
				     '</span>'+
				
			    
				
				'<div class="task-note-block'+(item.note==''?' hidden':'')+'">'+
					    

				
			             '<div id="usernote'+id+'" class="task-note">'+
					        '<span>'+prepareHtml(item.note)+'</span>'+
					     '</div>'+
				    	
					     
					     
					     '<div id="usernotearea'+id+'" class="task-note-area">'+
					          '<textarea id="usernotetext'+id+'"></textarea>'+
						      '<span class="task-note-actions">'+

						        '<a href="#" onClick="return cancelUserNote('+id+')">בטל</a>'+
						      '</span>'+
						 '</div>'+
						 
			 			 
			 '</div>'+
			    
			 
		"</div></li>\n";
			
		 }
	return user_form;  
 }

//////////////////////
}//end function   ///
//////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function makeRequest() {
	if (window.XMLHttpRequest) {
		xmlHttp = new XMLHttpRequest();
	}
}	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function loadUsers2(url,forum_decID,decID,mgr_userID,mgr)
{	  
	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	//if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	 var userIDD=66;
	 
 $.getJSON(url+'ajax2.php?loadUsers&compl='+filter.compl+'&forum_decID='+forum_decID+'&mgr='+mgr+'&mgr_userID='+mgr_userID+'&decID='+decID+'&sort1='+sortBy+tag+'&tz='+tz+nocache, function(json){
		 
	    resetAjaxErrorTrigger();
 		$('#total1'+decID+forum_decID).html(json.total);
 		
 		  mgr_1= new Array();
 		 
 		
 		  userOrder = new Array();
 		  		
 		userCnt.past1 = userCnt.today1 = userCnt.soon1 = 0;
 		userCnt.total = json.total;
 	 
 		var 	duedate='';
 		var date_user='';	
		var users = '';
		var mgr = '';
		var lastDate= '';
		//$(".my_user_title_"+decID+forum_decID).css("border", "3px solid red");
		


		  

	
/**************************************************************************************/		
		$.each(json.list, function(i,item){
/************************************************************************************/
	 
	
			var xmlHttp = false;
			var url2='';
			
	
 	 	users += prepareUserStr2(item,url,decID,forum_decID,mgr_userID,item.managerID);

 	  
 			userList[item.userID] = item;
 		 
 		     
 			userOrder.push(parseInt(item.userID));
 			
 			if(filter.compl==0 ||filter.compl==1   ){
			 	
 				changeUserCnt(item.dueClass);
 				}
 			  
 			

		});//end each
	
		
		if(filter.compl==0 ||filter.compl==1  ){
			refreshUserCnt2(decID,forum_decID);//what will show on the menue
			}
		
		 
   
		$('#userlist'+decID+forum_decID).html(users).removeClass().addClass('userlist') 
		    .css({'position': 'static'})
		    .css({'padding': '5px'})
			.css({'float':'right'})
			.css({'margin-left':'22px'})
			.css({'overflow':'auto'})
			 .css({'background':'#D0D150'})				
	        .css({'width':'99%'})
			.css({'border':'3px solid #666'});
			 

		$('li#userrow_'+mgr_userID).css({"border": "9px solid black"})
		                           .css({'color':'red'})
		                           //.css({'border':' 14px outset #338BA6'})
		                           .css({'border':' 14px outset'})
		                           .css({'font-weight':'bold'});
		
		
		
		
			
		
		
		
		
 	 	if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
 		else showhide($('#compl_show'),$('#compl_hide'));
 		if(json.denied) errorDenied();
 			
 	});//END JSON
 
 
 	  
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function loadUsers3(url,forum_decID,decID,mgr_userID,mgr)
{	  
	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	 var userIDD=66;
	 
 $.getJSON(url+'ajax2.php?loadUsers3&compl='+filter.compl+'&forum_decID='+forum_decID+'&mgr='+mgr+'&mgr_userID='+mgr_userID+'&decID='+decID+'&sort1='+sortBy+search+tag+'&tz='+tz+nocache, function(json){
		 
	    resetAjaxErrorTrigger();
 		$('#total1'+decID+forum_decID).html(json.total);
 		
 		  mgr_1= new Array();
 		 
 		
 		  userOrder = new Array();
 		  		
 		userCnt.past1 = userCnt.today1 = userCnt.soon1 = 0;
 		userCnt.total = json.total;
 	 
 		var 	duedate='';
 		var date_user='';	
		var users = '';
		var mgr = '';
		var lastDate= '';
/**************************************************************************************/		
		$.each(json.list, function(i,item){
/************************************************************************************/
	 
	
			var xmlHttp = false;
			var url2='';
			
	
 	 	users += prepareUserStr_tags(item,url,decID,forum_decID,mgr_userID,item.managerID);

 	  
 			userList[item.userID] = item;
 		 
 		     
 			userOrder.push(parseInt(item.userID));
 			
 			if(filter.compl==0 ||filter.compl==1   ){
			 	
 				changeUserCnt(item.dueClass);
 				}
 			  
 			

		});//end each
	
		
		if(filter.compl==0 ||filter.compl==1  ){
			refreshUserCnt2(decID,forum_decID);//what will show on the menue
			}
		
		 
   
		$('#userlist'+decID+forum_decID).html(users).removeClass().addClass('userlist') 
		    .css({'position': 'static'})
		    .css({'padding': '5px'})
			.css({'float':'right'})
			.css({'margin-left':'22px'})
			.css({'overflow':'auto'})
			 .css({'background':'#D0D150'})				
	        .css({'width':'99%'})
			.css({'border':'3px solid #666'});
			 

		$('li#userrow_'+mgr_userID).css({"border": "9px solid black"}).css({'color':'red'}).css({'font-weight':'bold'});
		
	
		
		
			
		
		
		
		
 	 	if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
 		else showhide($('#compl_show'),$('#compl_hide'));
 		if(json.denied) errorDenied();
 			
 	});//END JSON
 
 
 	  
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function hover_img(){
	
 //$(".task-actions_user a").css('border','3px solid red');
//	$(".userlist a").append("<em></em>");
//	$(".userlist a").hover(function() {
// 
//	$(this).find("em").animate({opacity: "show", top: "-85"}, "slow");//.css('position','relative');.css('margin-top','-500px').css('top','-500');//
//	var hoverText = $(this).attr("title");
//    $(this).find("em").text(hoverText);
//}, function() {
//	$(this).find("em").animate({opacity: "hide", top: "-65"}, "fast");
//		
//  });
	
	
	
	$(".userlist a").hover(function() {
		$(this).next("em").animate({opacity: "show", top: "-75"}, "slow");
	}, function() {
		$(this).next("em").animate({opacity: "hide", top: "-85"}, "fast");
	});	
	
	
	

}
/***************************************************************************************************/
function  my_forum_details(forum_decID){ 


		  	var link= '../admin/find3.php?&forum_decID='+forum_decID ;
		   	openmypage3(link); 
		  
		    return true;
 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function serverCall() {
    // ajax code

    setTimeout("serverCall()", 2000);
}
////////////////////////////////////////////////////////////////////////////////////
function sendData(url,userID,decID,forum_decID) {
	
	 
  	xmlHttp = new XMLHttpRequest();

  //	setTimeout("loadUsers(" + url + "," + forum_decID + "," +decID + " ," +userID + ")",7000);
	var params =  "setuserDuedate="+userID+"&forum_decID="+forum_decID+"&decID="+decID+nocache;
 
	  url2 = url+"ajax2.php?" + params;
	 
 

  if (xmlHttp)
  {
    // try to connect to the server
    try
    {
      // initiate reading a file from the server
      xmlHttp.open("GET", url2, true);
     xmlHttp.onreadystatechange = handleRequestStateChange;
   //  xmlHttp.onreadystatechange =processResult;
      xmlHttp.send(null);
    }

    catch (e)
    {
      alert("Can't connect to server:\n" + e.toString());
    }
  }
  
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
function handleRequestStateChange() 
{
//	var url='/alon-web/olive_prj/admin/';
	var url='../admin/';  
  if (xmlHttp.readyState == 4) 
  {

    if (xmlHttp.status == 200) 
    {
    	 
      try
      {
        // do something with the response from the server
        handleServerResponse();
       // responseJSON = JSON.parse(xmlHttp.responseText);
      }
      catch(e)
      {

        alert("Error reading the response: " + e.toString());
      }
    } 
    else
    {

      alert("There was a problem retrieving the data:\n" + 
            xmlHttp.statusText);
    }
  }
  setInterval("sendData(" + url + "," +userID+ "," +decID + " ," + forum_decID + ")",10000);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
function processResult() {
	   if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		   responseJSON = JSON.parse(xmlHttp.responseText);
	   }
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function handleServerResponse()
{
//	var url='/alon-web/olive_prj/admin/';
	var url='../admin/';
	
  responseJSON = JSON.parse(xmlHttp.responseText);


}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareUserStr2(item,url,decID,forum_decID,mgr_userID,mgr)
{

    var flag_userID=$('#flag_userID').val();
	
	id = parseInt(item.userID);
	 
	id_dest = parseInt(item.dest_userID);
	 
    full_name=(item.full_name);
	   
	prio = parseInt(item.prio);
	
 
	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
	flag_level=$('#flag_level').val();
	
if(flag_level==1){	
if(id==mgr_userID){
 
	//style="height:110px;overflow:scroll;"	
	
return  '<li style="height:40px;" >'+
			'<a class="my_forum_details" href="javascript:void(0)" onClick="return my_forum_details('+item.forum_decID+')">'+
			'<h1 style="text-align:center;margin-top:3px;margin-left:100px;"> '+item.forum_decName+'</h1>'+
			'</a>'+
		 	//'<em>צפה בפרטי הפורום</em>'+
			'</li>'+


'<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"    onDblClick="editUsermgr('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')"  >'+

'<div class="task-actions_user">'+
		

   '<ul class="menu" onMouseOver="return hover_img();" >'+
	 
	  
		  
		  '<li>'+
		    '<a href="javascript:void(0)" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+' )" >'+
		        '<img src="'+img.showup[0]+'" onMouseOver="this.src=img.showup[1]" onMouseOut="this.src=img.showup[0]"   >'+
		     '</a>'+
	       '<em>משימות שאני כתבתי בדף</em>'+
		  '</li>'+
		  
		  
		  
	     '<li>'+
	     '<a href="javascript:void(0)" onClick="return editUsertask_pop('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+')"  >'+
	     
		       '<img src="'+img.show[0]+'" onMouseOver="this.src=img.show[1]" onMouseOut="this.src=img.show[0]"  >'+
		  '</a>'+
		  '<em>משימות שאני כתבתי בחלון</em>'+ 
		 '</li>'+
		 
		 
		 
		 '<li>'+
		  '<a href="javascript:void(0)" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')" >'+
		    '<img src="'+img.showforme[0]+'" onMouseOver="this.src=img.showforme[1]" onMouseOut="this.src=img.showforme[0]"  >'+
	      '</a>'+
          '<em>משימות שכתבו אלי בדף</em>'+
         '</li>'+
	  
	  
        '<li>'+
        '<a href="javascript:void(0)" onClick="return editUsertask_pop4me('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')"  >'+
           '<img src="'+img.showformewin[0]+'" onMouseOver="this.src=img.showformewin[1]" onMouseOut="this.src=img.showformewin[0]" >'+
        '</a>'+
         '<em>משימות שכתבו אלי בחלון</em>'+
          '</li>'+
          
     
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 	'<li>'+	
        '<a href="javascript:void(0)" onClick="return toggleUserNote('+id+')"   onMouseOver="return hover_img();" >'+
 		    '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1];" onMouseOut="this.src=img.note[0]"  >'+
 		 '</a>'+
 	     '<em>רשימות</em>'+      
 	  '</li>'+
 	  
 	      
 	      
 	      
 	    '<li>'+
 		 '<a href="javascript:void(0)"  onClick="return editUsermgr('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')"   >'+
 		     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]"  >'+
 		 '</a>'+
 		  '<em>עריכה</em>'+
 		'</li>'+
 		  
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          
          
	  '</ul></div>'+

	  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	'<div id="content" >'+
	 	   prepareLinkBox(id,url,full_name,decID,forum_decID)+
	'</div>'+ 	
	 	  
	  
	  

'<div     style="background:#13E72C"  id="user_'+id+'"  class="task-middle">'+
    prepareDuedate2(item.duedate, item.dueClass, item.dueStr)+
   //  prepareDuedate2(item.duedate, item.dueClass, item.dueStr)+ 
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
	     
	  '<div class="task-actions_user">'+
		
	  '<ul class="menu" onMouseOver="return hover_img();" >'+
	  

	
	'<li>'+
	'<a href="#" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+' )">'+  
		       '<img src="'+img.showup[0]+'" onMouseOver="this.src=img.showup[1]" onMouseOut="this.src=img.showup[0]">'+
	     '</a>'+
	     '<em>משימות שאני כתבתי בדף</em>'+
	'</li>'+	  
		  
		  
		  
	'<li>'+  
	     '<a href="#" onClick="return editUsertask_pop('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+')">'+
		       '<img src="'+img.show[0]+'" onMouseOver="this.src=img.show[1]" onMouseOut="this.src=img.show[0]" >'+
		 '</a>'+
		 '<em>משימות שאני כתבתי בחלון</em>'+
	'</li>'+
		
		 
	
	'<li>'+
		  '<a href="#" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')">'+  
	       '<img src="'+img.showforme[0]+'" onMouseOver="this.src=img.showforme[1]" onMouseOut="this.src=img.showforme[0]" >'+
          '</a>'+
          '<em>משימות שכתבו אלי בדף</em>'+
    '</li>'+
	  
	  
	  
      
    '<li>'+
    '<a href="#" onClick="return editUsertask_pop4me('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')">'+
	       '<img src="'+img.showformewin[0]+'" onMouseOver="this.src=img.showformewin[1]" onMouseOut="this.src=img.showformewin[0]" >'+
	     '</a>'+
	     '<em>משימות שכתבו אלי בחלון</em>'+
    '</li>'+ 
		  

    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	'<li>'+
	      '<a href="#" onClick="return toggleUserNote('+id+')">'+
	        '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" >'+
	      '</a>'+
	      '<em>רשימות</em>'+
	'</li>'+
		
		  
	'<li>'+
	'<a href="#"  onClick="return editUser2('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')" >'+
		     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה" >'+
		  '</a>'+
		  '<em>עריכה</em>'+
	'</li>'+
		  
	
	
	'<li>'+
    '<a href="#" onClick="return deleteUser('+id+',\''+url+'\')">'+
      '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" >'+
    '</a>'+
    '<em>מחיקה</em>'+
  '</li>'+	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		  
 
    
    
    
    
 	  '</ul></div>'+

 	  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 	  
 	  
		
	  '<div class="task-left">'+
		'<input type="checkbox" '+(readOnly?'disabled':'')+' onClick="completeUser2('+id+',this,\''+url+'\','+decID+','+forum_decID+')" '+(item.compl?'checked':'')+'>'+
	  '</div>'+  
	  
	  
//	  '<div id="content" >'+
//      '<p>'+
//	 	  '<a id="fullcalendar-link" class="iframe" href="full_calendar/insert_ajx4.php">פתח יומן אישי</a>'+
//	 	'</p>'+
//	 '</div>'+ 	
  	 
	  
	 
	  
	'<div id="content" >'+
	 	   prepareLinkBox(id,url,full_name,decID,forum_decID) +
	'</div>'+ 	
	 	  
	  
	
 '<div  style="background:#23E3EA;font-weight:bold;"  id="user_'+id+'"  class="task-middle">'+//style color for users
 prepareDuedate2(item.duedate, item.dueClass, item.dueStr)+
 //prepareDuedate2(duedate, dueClass, dueStr)+ //in multi_ajx.php get the date of the last task in hebrew
	
 // 	prepareDuedate3(url,item.userID,decID, forum_decID)+ 	    
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
////////////////////////////////
  }else if(flag_level==0){  /// 
///////////////////////////////	
	  if(id==mgr_userID){

	return '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick="editUsermgr('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')"  >'+
		    
			  '<div class="task-actions_user">'+
				
			  
			      '<a href="#" onClick="return toggleUserNote('+id+')">'+
			        '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
			      '</a>'+
				
				
				  '<a href="#"  onClick="return editUsermgr('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')">'+
				     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
				  '</a>'+
				
				  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		  
				  
				 '<a href="#" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+' )">'+  
				       '<img src="'+img.showup[0]+'" onMouseOver="this.src=img.showup[1]" onMouseOut="this.src=img.showup[0]" title="הראה משימות שאני כתבתי בדף">'+
			     '</a>'+
				  
				  
				  
				  
		      
			     '<a href="#" onClick="return editUsertask_pop('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+')">'+
				       '<img src="'+img.show[0]+'" onMouseOver="this.src=img.show[1]" onMouseOut="this.src=img.show[0]" title="הראה משימות שאני כתבתי בחלון">'+
				 '</a>'+
			  
				
				 
				 
				  '<a href="#" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')">'+  
			       '<img src="'+img.showforme[0]+'" onMouseOver="this.src=img.showforme[1]" onMouseOut="this.src=img.showforme[0]" title="הראה משימות שכתבו אלי בדף">'+
		        '</a>'+
			  
			  
			  
			  
		      
		        '<a href="#" onClick="return editUsertask_pop4me('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')">'+
			       '<img src="'+img.showformewin[0]+'" onMouseOver="this.src=img.showformewin[1]" onMouseOut="this.src=img.showformewin[0]" title="הראה משימות שכתבו אלי בחלון">'+
			     '</a>'+
			  '</div>'+

			  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  

		'<div     style="background:#13E72C"  id="user_'+id+'"  class="task-middle">'+
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
						        '<a href="#" onClick="return cancelUserNote('+id+')">בטל</a>'+
						      '</span>'+
						 '</div>'+
						 
			 			 
			 '</div>'+
			    
			 
		"</div></li>\n";

		}else{ 	
	 user_form= '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick="editUser2('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')">'+
			     
			  '<div class="task-actions_user">'+
				

			  
			      '<a href="#" onClick="return toggleUserNote('+id+')">'+
			        '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
			      '</a>'+
				
				
				  '<a href="#"  onClick="return editUser2('+id+','+decID+','+forum_decID+',\''+url+'\','+mgr_userID+')">'+
				     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
				  '</a>'+
				
				  
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		  
				  
				 '<a href="#" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+' )">'+  
				       '<img src="'+img.showup[0]+'" onMouseOver="this.src=img.showup[1]" onMouseOut="this.src=img.showup[0]" title="הראה משימות שאני כתבתי בדף">'+
			     '</a>'+
				  
				  
				  
				  
		      
			     '<a href="#" onClick="return editUsertask_pop('+id+',\''+url+'\','+decID+','+forum_decID+','+id_dest+')">'+
				       '<img src="'+img.show[0]+'" onMouseOver="this.src=img.show[1]" onMouseOut="this.src=img.show[0]" title="הראה משימות שאני כתבתי בחלון">'+
				 '</a>'+
			  
				
				 
				  
				  '<a href="#" onClick="return loadTasks2user2('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')">'+  
			       '<img src="'+img.showforme[0]+'" onMouseOver="this.src=img.showforme[1]" onMouseOut="this.src=img.showforme[0]" title="הראה משימות שכתבו אלי בדף">'+
		          '</a>'+
			  
			  
			  
			  
		         // '<a href="#" onClick="return loadTasks2user('+id+',\''+url+'\')">'+  
		          '<a href="#" onClick="return editUsertask_pop4me('+id+',\''+url+'\','+decID+','+forum_decID+','+id+')">'+
			       '<img src="'+img.showformewin[0]+'" onMouseOver="this.src=img.showformewin[1]" onMouseOut="this.src=img.showformewin[0]" title="הראה משימות שכתבו אלי בחלון">'+
			     '</a>'+
		 	  '</div>';

		 	  
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 	  
		 	if(flag_userID==id)  
		 user_form+='<div id="content" >'+
			 	   prepareLinkBox(id,url,full_name,decID,forum_decID)+
			'</div>'; 	
		 	 	  
			  
			
	user_form+= '<div  style="background:#23E3EA;font-weight:bold;"  id="user_'+id+'"  class="task-middle">'+//style color for users
		 prepareDuedate2(item.duedate, item.dueClass, item.dueStr)+
		 //prepareDuedate2(duedate, dueClass, dueStr)+ //in multi_ajx.php get the date of the last task in hebrew
			
		 // 	prepareDuedate3(url,item.userID,decID, forum_decID)+ 	    
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

						        '<a href="#" onClick="return cancelUserNote('+id+')">בטל</a>'+
						      '</span>'+
						 '</div>'+
						 
			 			 
			 '</div>'+
			    
			 
		"</div></li>\n";
			
		 }
	return user_form;  
 }

//////////////////////
}//end function   ///
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareHtmlDate(date) { return 'added at '+date; }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function prepareDuedate2(duedate, c, s,item_decID,decID)
function prepareDuedate2(duedate, c, s)
{
	//prepareDuedate(item.duedate, item.dueClass, item.dueStr)
	//alert(item.duedate);
	// alert(item.dueClass);
	//alert(item.dueStr);
	if(!duedate ) return '';
	return '<span class="duedate" title="'+duedate+'"> מצב משימה אחרונה-'+s+'</span>';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareDuedate3(url,userID,forum_decID,decID)
{
//	objDuedate.forum_decID=forum_decID;
//	objDuedate.decID=decID;
//	objDuedate.userID=userID;
	nocache = '&rnd='+Math.random();
	tz = -1 * (new Date()).getTimezoneOffset();

//				resetAjaxErrorTrigger(decID,forum_decID);
//				$('#total1'+decID+forum_decID).html(json.total);
//alert("ddddddddddd");		 	 

$.getJSON(url+'ajax2.php?setuserDuedate='+userID+'&forum_decID='+forum_decID+'&decID='+decID+'&tz='+tz+nocache, function(json){	
		objDuedate.duedate=json.list1[0].duedate;
/**************************************************************************************/		
//				$.each(json.list1, function(i,item){
///************************************************************************************/
//		 
//		 		  
//		 			objDuedate.duedate=item.duedate;		 
//
//				});//end each
			
			
			});
	
//	  $.ajax({
//          type: "GET" ,
//                 url: url+"ajax2.php",
//                  dataType: 'json',
//                 data: "setuserDuedate="+userID+"&forum_decID="+forum_decID+"&decID="+decID+nocache,
//                 success: function(data) {
//                	 
//                	 objDuedate.duedate=data.list1[0].duedate;
//                 }
//	      });     
//	prepareDuedate4(url,userID,forum_decID,decID);	
 		if(!objDuedate.duedate ) return '';
	 		
  return '<span class="duedate" title="'+objDuedate.duedate+'"> מצב משימה אחרונה-'+objDuedate.duedate+'</span>';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareDuedate4(url,userID,forum_decID,decID)
{
	objDuedate.forum_decID=forum_decID;
	objDuedate.decID=decID;
	objDuedate.userID=userID;
	nocache = '&rnd='+Math.random();
	tz = -1 * (new Date()).getTimezoneOffset();




//$.getJSON(url+'ajax2.php?setuserDuedate='+userID+'&forum_decID='+forum_decID+'&decID='+decID+'&tz='+tz+nocache, function(json){
//	
//	if(json && json.list[0])
//	objDuedate.duedate=json.list[0].duedate;
	
///**************************************************************************************/		
//				$.each(json.list, function(i,item){
///************************************************************************************/
//		 
//		 		  
//		 			objDuedate.duedate=item.duedate;		 
//
//				});//end each
//			
//			
//			});
	
	$.ajax({
        type: "GET" ,
           url: url+"ajax2.php",
            dataType: 'json',
           data: "setuserDuedate="+userID+"&forum_decID="+forum_decID+"&decID="+decID+nocache,
           success: function(json) {
          	 
          	 objDuedate.duedate=json.list1[0].duedate;
           	  if(!objDuedate.duedate ) return '';
         	  return '<span class="duedate" title="'+objDuedate.duedate+'"> מצב משימה אחרונה-'+objDuedate.duedate+'</span>';
               }
	      });     			
//	  if(!objDuedate.duedate ) return '';
//		
     return '<span class="duedate" title="'+objDuedate.duedate+'"> מצב משימה אחרונה-'+objDuedate.duedate+'</span>';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function prepareuserPrio2(prio,id,decID,forum_decID)
{
	 
	cl = v = '';
	if(prio < 0) { cl = 'prio-neg'; v = '&minus;'+Math.abs(prio); }
	else if(prio > 0) { cl = 'prio-pos'; v = '+'+prio; }
	else { cl = 'prio-o'; v = '&plusmn;0'; }
	return '<span class="task-prio '+cl+'" onMouseOver="priouserPopup2(1,this,'+decID+' ,'+forum_decID+','+id+')" onMouseOut="priouserPopup2(0,this,'+decID+' ,'+forum_decID+')">'+v+'</span>';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function priouserPopup2(act, el,decID,forum_decID,id)
{
	 
 	if(act == 0) {
		clearTimeout(objPrio.timer);
		return;
	}
	offset = $(el).offset();
	
	
	 if( ($('#my_task_view').val()==undefined) ){
		 $('#userpriopopup'+decID+forum_decID).css({ position: 'absolute', top: offset.top + 1, left: offset.left + 1 });
			 }else{
				// $('#priopopup'+decID+forum_decID).css({ position: 'relative', top: offset.top-1 , left: offset.left + 1 });
//		 $('#userpriopopup'+decID+forum_decID).css({ position: 'absolute',  right:'200px', 'z-index': '3000','white-space': 'nowrap' ,overflow:'hidden', bottom:'300',height:'50',  'width': $(el).width()+120 });//.show();
				 //$('#userpriopopup'+decID+forum_decID).css({ position: 'absolute', top: offset.top - 295, left: offset.left + 1 })
				 $('#userpriopopup'+decID+forum_decID).css({ position: 'absolute', top: offset.top - 100, left: offset.left + 1 })
			 }
	
	
	
	
	objPrio.userID = id;
	objPrio.el = el;
	objPrio.timer = setTimeout("$('#userpriopopup"+decID+forum_decID+"').show()", 200);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function priouserClick2(prio, el,url,decID,forum_decID,mgr_userID){ 

	// if(this.parentNode == null)return;
		
		el.blur();
		prio = parseInt(prio);
		setAjaxErrorTrigger(url);
		nocache = '&rnd='+Math.random();
if(!(objPrio.userID==mgr_userID)){ 		
		$.getJSON(url+'ajax2.php?setuserPrio='+objPrio.userID+'&forum_decID='+forum_decID+'&prio='+prio+nocache, function(json){
			resetAjaxErrorTrigger(decID,forum_decID);
		});
}else{
	$.getJSON(url+'ajax2.php?setmgrPrio='+objPrio.userID+'&forum_decID='+forum_decID+'&prio='+prio+nocache, function(json){
		resetAjaxErrorTrigger(decID,forum_decID);
	});
	
}
		
		userList[objPrio.userID].prio = prio;
	 	
	 	$(objPrio.el).replaceWith(prepareuserPrio2(prio, objPrio.userID,decID,forum_decID));
	 	

	 $('#userpriopopup'+decID+forum_decID).hide();//fadeOut('fast'); //.
		if(sortBy != 0) changeTaskOrder(url,decID,forum_decID);
		$('#userrow_'+objPrio.userID).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
		
	}


//////////////////////////////////////////////////////////////////////////////////////////////
/*********************************************************************************************/
function prepareuserPrio(prio,id)
{
	 
	cl = v = '';
	if(prio < 0) { cl = 'prio-neg'; v = '&minus;'+Math.abs(prio); }
	else if(prio > 0) { cl = 'prio-pos'; v = '+'+prio; }
	else { cl = 'prio-o'; v = '&plusmn;0'; }
	return '<span class="task-prio '+cl+'" onMouseOver="priouserPopup(1,this,'+id+')" onMouseOut="priouserPopup(0,this)">'+v+'</span>';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/***********************************************************************************************/
function loadTasks2user2(userID,url,decID,forum_decID,dest_userID)//show tasks that i wrote in the web
{
	 
	tz = -1 * (new Date()).getTimezoneOffset();
 setAjaxErrorTrigger(url,decID,forum_decID);
	if(filter.search){
		search = '&s='+encodeURIComponent(filter.search);
		
		} else{ search = '';}
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	
	
	
//	 progList[0]=prog_bar;
//
//	   $('#progress'+decID+forum_decID).progressbar("option", "value",prog_bar);
//	  
//
//	   if(prog_bar>=100)
//	       $("#increase"+decID+forum_decID).attr("disabled", "disabled");
//	   if(prog_bar<100)
//			$("#increase"+decID+forum_decID).removeAttr('disabled');
//	 $("#progress"+decID+forum_decID+".ui-progressbar-value").animate({width: prog_bar+"%"}, 500);
	   
	
	
	
	
	nocache = '&rnd='+Math.random();
	
	$.getJSON(url+'ajax2.php?loadTasks2user2&compl='+filter.compl+'&sort='+sortBy+search+tag+'&forum_decID='+forum_decID+'&decID='+decID+'&userID='+userID+'&dest_userID='+dest_userID+'&tz='+tz+nocache, function(json){
	//	resetAjaxErrorTrigger();
				
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
			
			
			// editTask2task (item,decID,forum_decID);
			// edittask2user(item);
			/*CHNGE THE NAME OF THE FUNCTION*/
			tasks += prepareuserTaskStr2(item,url,decID,forum_decID);//function in ajx_multi.php prepareuserTaskStr2 !	prepareUserTaskStr2
			//alert(tasks);
			
		   
			 
			taskList[item.taskID] = item;
			
			 
		 	taskOrder.push(parseInt(item.taskID));

		 //if( !item.compl  )
			 changeTaskCnt(item.dueClass);
				
			 //loadTask2(url,forum_decID,decID);	 	

		});
	    //if(!filter.compl==1 ){
		refreshTaskCnt();
	   //}
		
	    $('#tasklist'+decID+forum_decID).html(tasks);
		if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
		else showhide($('#compl_show'),$('#compl_hide'));
		if(json.denied) errorDenied();
		
	});
	
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********/
function editUsertask_pop (id,url,decID,forum_decID,dest_userID)//show tasks that i wrote in a window
{

//  var forum_decID = document.getElementById('forum_decID').value;	      
//  var decID = document.getElementById('decID').value;
  tz = -1 * (new Date()).getTimezoneOffset();
	//setAjaxErrorTrigger(url,decID,forum_decID);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
 	 
	 $.getJSON(url+'ajax2.php?loadTasks2user2&userID='+id+'&forum_decID='+forum_decID+'&dest_userID='+dest_userID+'&decID='+decID+nocache, function(json){
 	 //  resetAjaxErrorTrigger(url,decID,forum_decID);
 	    if(!json || json.total==0){
 	    	 alert('!!אין משימות כרגע');	
 	    return ;
 	    }else $('#total2').html(json.total);
 		
 		usertaskList_b = new Array();
 		usertaskOrder_b = new Array();
 		// Listtask = new Array();
 		
 		
 		usertaskCnt_b.past = usertaskCnt_b.today = usertaskCnt_b.soon = 0; 
 		usertaskCnt_b.total = json.total;
        
 		if(!usertaskCnt_b.total)
 			return ;
 		  		 
 		var usertasks_b = '';
 		
 		
 	 

////////////////////////////////////////////////////////////////////////////		
  		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////// 			
  			
  	 	
  		 
  			
  			 
  		   
  			 
  		    usertasks_b +=prepareUsertaskStr2(item,url,decID,forum_decID);
  	 
            usertaskList_b[item.taskID] = item;
          //  alert(item);
		//    taskOrder.push(parseInt(item.taskID));
			
		    changeTaskCnt(item.dueClass);
			 
		    
		     $('#editusertask_b'+decID+forum_decID).html (usertasks_b);//print with the form  inputs
		 		 
	 	 
		 	  
  		
  		});
 
  	 	refreshTaskCnt();
  		
  		
  		
 	 $('#editusertask_b'+decID+forum_decID).html (usertasks_b);//print with the form  inputs
  	   
  		if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
		else showhide($('#compl_show'),$('#compl_hide'));
		if(json.denied) errorDenied();
  		
  		
  		
		w = $('#page_usertaskedit_b'+decID+forum_decID);
		
		if(!flag.windowUsertaskEditMoved_b)
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
		//w.fadeIn('fast').show().css('background','#EBCC42');
		w.fadeIn('fast')
		// .css('position','fix')
		.css('background','#EBCC42') 
	  	
	   .css({'z-iindex': '201'}) 
		
	  	 .css({'padding':'8px'})
	  	 .css({'left':'170px'})
	 
	       .css({'top':'-400px'}) 
	   
	 
	     .css({'float':'left'})			
	     .css({'width':'510px'})
	  	  .css({'border':'3px solid #666'}).show();
		   $(document).bind('keydown', cancelusertaskEdit_pop);	
		 
 	});		

	 
       return false;
  	  
	}
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editUsertask_pop4me (id,url,decID,forum_decID,dest_userID)//task outher people wrote 4 me in pop for me
{

 
  tz = -1 * (new Date()).getTimezoneOffset();
	//setAjaxErrorTrigger(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();1
	
 	 
	 $.getJSON(url+'ajax2.php?loadTasks2user2&userID='+id+' &forum_decID='+forum_decID+'&dest_userID='+dest_userID+'&decID='+decID+nocache, function(json){
 	    resetAjaxErrorTrigger();
 	    if(!json || json.total==0){
 	    	 alert('!!אין משימות כרגע');	
 	    return ;
 	    }else $('#total2').html(json.total);
 		
 		usertaskList = new Array();
 		usertaskOrder = new Array();
 		// Listtask = new Array();
 		
 		
 		usertaskCnt.past = usertaskCnt.today = usertaskCnt.soon = 0; 
 		usertaskCnt.total = json.total;
        
 		if(!usertaskCnt.total)
 			return ;
 		  		 
 		var usertasks = '';
 		
 		
 	 

////////////////////////////////////////////////////////////////////////////		
  		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////// 			
  			
  			
  		 
  			
  			 
  		  //  edittask2user(item);
  			// alert(item);
  		    usertasks +=prepareUsertaskStr2(item,url,decID,forum_decID);
  	 
            usertaskList[item.taskID] = item;
		 
		  //  taskOrder.push(parseInt(item.taskID));
			
		    changeTaskCnt(item.dueClass);
			 
		    
		     $('#editusertask'+decID+forum_decID).html (usertasks);//print with the form  inputs
		 		 
	 	 
		 	  
  		
  		});
 
  	//	refreshTaskCnt();
  		// $('#target_usertask').html (usertasks);//print with the form  inputs
  		 $('#editusertask'+decID+forum_decID).html (usertasks);//print with the form  inputs
 	  //    $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
  		 
 		   //$('<div id="overlay">'+usertasks+'</div>').appendTo('#usertaskedit') ;
 		//$('<li_ID>' + i + '</li>').appendTo('ul') ;
  		
  		if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
		else showhide($('#compl_show'),$('#compl_hide'));
		if(json.denied) errorDenied();
  		
  		
  		
		w = $('#page_usertaskedit'+decID+forum_decID);
		
		if(!flag.windowUsertaskEditMoved)
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
//		w.fadeIn('fast').show().css('background','#CFF0E5');
//		$(document).bind('keydown', cancelusertaskEdit);	
		w.fadeIn('fast')
	//	 .css('position','fix')
		.css('background','#CFF0E5') 
	  	
	   .css({'z-iindex': '201'}) 
		
	  	 .css({'padding':'8px'})
	  	 .css({'left':'170px'})
	 
	       .css({'top':'-200px'}) 
	   
	 
	     .css({'float':'left'})			
	     .css({'width':'510px'})
	  	  .css({'border':'3px solid #666'})
	  	
		 .show();
		 
		  $(document).bind('keydown', cancelusertaskEdit_pop4me);
	 
 	});		

	 
 return false;
  	  
	}
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editTask2task(id,decID,forum_decID)
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
function cancelusertaskEdit_pop(decID,forum_decID,e)//cancel tasks that i wrote in a window
{
 
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelusertaskEdit_pop);
	$('#page_usertaskedit_b'+decID+forum_decID).hide();
	$('#overlay').remove();
  
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cancelusertaskEdit_pop4me(decID,forum_decID,e)//cancel tasks people wrote 4 me in a window
{
 
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelusertaskEdit_pop4me);
	$('#page_usertaskedit'+decID+forum_decID).hide();
	$('#overlay').remove();
  
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function loadUsertask(userID,url)
{
	 // alert(url);
	var forum_decID = document.getElementById('forum_decID').value;
	var decID = document.getElementById('decID').value;
	 
	tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
	 $.getJSON(url+'ajax.php?loadUsertask&userID='+userID+' &forum_decID='+forum_decID+'&decID='+decID+nocache, function(json){

	    resetAjaxErrorTrigger();
 		$('#total').html(json.total);
 		
 		
 		usertaskList = new Array();
 		usertaskOrder = new Array();
       
 		
 		 
 		taskCnt.total = json.total;
 	 
 		
		var usertasks = '';
//////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////			 
 	 	usertasks +=  item.title ;
 		  
 			 
 			usertaskList[item.taskID] = item;
 			 
 		     
 			taskOrder.push(parseInt(item.taskID));
 			
 		 
 			 changeTaskCnt(item.dueClass);
 		 
 		      		 
		});

 
			refreshTaskCnt();
		    

 		//  $('#usertasklist').html(usertasks);

 	 	if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
 		else showhide($('#compl_show'),$('#compl_hide'));
 		if(json.denied) errorDenied();
 		//editUsertask(item); 
 		//return  usertaskList[item.taskID];
 	});
	 

	 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
function prepareUserDuedate(duedate, c, s,userID,url)
{
	
	var decID = document.getElementById('decID').value;
 	var forum_decID = document.getElementById('forum_decID').value; 
	$.post(url+'ajax.php?loadUsertask'+nocache, {user: user ,user_dest: user_dest,forum_decID:forum_decID ,decID:decID,userID:userID, tz:tz, tag:filter.tag }, function(json){		
		 
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return '';
	    }, 'json');
	if(!duedate) return '';
	return '<span class="duedate" title="'+duedate+'">'+s+'</span>';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
	
function prepareUserStr(item,url,mgr,decID,forum_decID)
{
	var url1='/alon-web/olive_prj/mytinytodo_a/';
	 
	id = parseInt(item.userID);
	id_dest = parseInt(item.dest_userID);
	//alert(item.dest_userID);
	var forum_decID = document.getElementById('forum_decID').value;
	  
    var decID = document.getElementById('decID').value;
	   
	prio = parseInt(item.prio);
	
	//alert(prio);
	// alert(item.dueClass);
	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
	 // alert(item.note);
	//style="background:#ffdddd"
	return '<li id="userrow_'+id+'"  class="'+(item.compl?'task-completed ':'')+item.dueClass+'"onDblClick="editUser('+id+')">'+
	     
	  '<div class="task-actions_user">'+
		

	  
	     '<a href="#" onClick="return deleteUser('+id+',\''+url+'\')">'+
	       '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="מחיקה">'+
	     '</a>'+
	  
	  
	  
	      '<a href="#" onClick="return toggleUserNote('+id+')">'+
	        '<img src="'+img.note[0]+'" onMouseOver="this.src=img.note[1]" onMouseOut="this.src=img.note[0]" title="רשימות">'+
	      '</a>'+
		
		
		  '<a href="#"  onClick="return editUser('+id+')">'+
		     '<img src="'+img.edit[0]+'" onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[0]" title="עריכה">'+
		  '</a>'+
		
		  
		  
		  
		  
		 '<a href="#" onClick="return loadTasks2user('+id+',\''+url+'\')">'+  
		       '<img src="'+img.showup[0]+'" onMouseOver="this.src=img.showup[1]" onMouseOut="this.src=img.showup[0]" title="הראה משימות שאני כתבתי בדף">'+
	     '</a>'+
		  
		  
		  
		  
       // '<a href="#" onClick="return loadTasks2user('+id+',\''+url+'\')">'+  
	     '<a href="#" onClick="return editUsertask_b('+id+',\''+url+'\')">'+
		       '<img src="'+img.show[0]+'" onMouseOver="this.src=img.show[1]" onMouseOut="this.src=img.show[0]" title="הראה משימות שאני כתבתי בחלון">'+
		 '</a>'+
	  
		
		 
		  
		  '<a href="#" onClick="return loadTasks2user('+id+',\''+url+'\','+id+')">'+  
	       '<img src="'+img.showforme[0]+'" onMouseOver="this.src=img.showforme[1]" onMouseOut="this.src=img.showforme[0]" title="הראה משימות שכתבו אלי בדף">'+
          '</a>'+
	  
	  
	  
	  
         // '<a href="#" onClick="return loadTasks2user('+id+',\''+url+'\')">'+  
          '<a href="#" onClick="return editUsertask('+id+',\''+url+'\','+id+')">'+
	       '<img src="'+img.showformewin[0]+'" onMouseOver="this.src=img.showformewin[1]" onMouseOut="this.src=img.showformewin[0]" title="הראה משימות שכתבו אלי בחלון">'+
	     '</a>'+
 	  '</div>'+

 	  
 
 	  
 	  
		
	  '<div class="task-left">'+
		'<input type="checkbox" '+(readOnly?'disabled':'')+' onClick="completeUser2('+id+',this,\''+url+'\','+decID+','+forum_decID+')" '+(item.compl?'checked':'')+'>'+
	  '</div>'+  
	  
	  
//	  '<div id="content" >'+
//      '<p>'+
//	 	  '<a id="fullcalendar-link" class="iframe" href="full_calendar/insert_ajx4.php">פתח יומן אישי</a>'+
//	 	'</p>'+
//	 '</div>'+ 	
  	 
	  
	 
	  
	'<div id="content" >'+
	 	   prepareLinkBox(id,url)+
	'</div>'+ 	
	 	  
	  
	  
	  
	  
	    
	  
  //   if(!mgr)
//    	 alert(mgr);
   //   +'<div     style="'+(mgr?'background,#ffdddd':'background ,')+'"    class="task-middle">'+
// else	
	  
//	  '<div  id="user_'+id+'"  class="task-middle">'+	  
 '<div     style="background:#ffdddd"  id="user_'+id+'"  class="task-middle">'+
 //'<div     style="background'+(item.managerID==''?'':'#ffdddd')+'"  id="user_'+id+'"  class="task-middle">'+
 
// class="task-note-block'+(item.note==''?' hidden':'')+'"
 
 // prepareUserDuedate(item.duedate, item.dueClass, item.dueStr,item.userID,url)+
	      
	       '<span class="nobr">'+
		        '<span class="task-through">'+
		              prepareuserPrio(prio,id)+
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareLinkBox(id,url,full_name,decID,forum_decID)	{ 
	 
return '<span class="my_task"><a id="fullcalendar-link'+id+'"  class="iframe_user"  onMouseOver="link_over('+id+')"  onClick="makeBox('+id+', \''+full_name+'\',\''+url+'\','+decID+','+forum_decID+' );" >'+


'<strong style="cursor:pointer">פתח יומן אישי</strong></a></span>';
} 

function link_over(id){
	 
	 
	$('#fullcalendar-link'+id).css({ cursor: 'pointer' });
	
}





function makeBox(id,full_name,url,decID,forum_decID){
		var link= '../admin/full_calendar/insert_ajx4.php?userID='+id+'&decID='+decID+'&forum_decID='+forum_decID+''; 

		opengoog(link,full_name);

 	
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function prepareUsertaskStr(item,url)
{
	id = parseInt(item.taskID);
 
	prio = parseInt(item.prio);
     
	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
	return '<li id="taskrow_'+id+'">'+
		
		 
		'<div class="task-middle">'+
		  prepareDuedate(item.duedate, item.dueClass, item.dueStr)+
		
		
		
		
		
		
		'<span class="nobr">'+
		   '<span class="task-through">'+
		    preparePrio1(prio,id)+
		        
		        '<span class="task-title">'+prepareHtml(item.title)+'</span>'+
		        '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
		      '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
		         
		    '</span>'+
	    '</span>'+
		
	    
	    
	     
	    
		
		
		"</div></li>\n";
 
	

	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareUsertaskStr2(item,url,decID,forum_decID)
{
	id = parseInt(item.taskID);
	//alert(item.date);
	prio = parseInt(item.prio);
    //alert(item.taskID);
	readOnly = (flag.needAuth && flag.canAllRead && !flag.isLogged) ? true : false;
	return '<li id="taskrow_'+id+'">'+
		
		 
		'<div class="task-middle">'+
		  prepareDuedate(item.duedate, item.dueClass, item.dueStr)+
		
		
		
		
		
		
		'<span class="nobr">'+
		   '<span class="task-through">'+
		    preparePrio2(prio,id,decID,forum_decID)+
		        
		        '<span class="task-title">'+prepareHtml(item.title)+'</span>'+
		        '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
		         '<span class="task-date">'+prepareHtmlDate(item.date)+'</span>'+
		         
		    '</span>'+
	    '</span>'+
		
	    
	    
	     
	    
		
		
		"</div></li>\n";
 
	

	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareUserfindStr(item,url)
{
	//lang=new lang();
	id = parseInt(item.taskID);
    
	prio = parseInt(item.prio);
    
    
	return '<li id="taskrow_'+id+'">'+
		
		 
		'<div class="task-middle">'+
		  prepareDuedate(item.duedate, item.dueClass, item.dueStr)+
		
		
		
		
		
		
		'<span class="nobr">'+
		   '<span class="task-through">'+
		      preparePrio1(prio,id)+
		        '<span class="task-title">'+prepareHtml(item.title)+'</span>'+
		        '<span class="task-title" display="none" float="left" >'+prepareHtml(item.message)+'</span>'+
 	      '<span class="task-date" float="right"  >'+prepareHtmlDate(item.date)+'</span>'+
		       
		    '</span>'+
	    '</span>'+
		
		
		
		
		"</div></li>\n";
 
	

	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareNormalUserStr(item,url)
{
	
	id = parseInt(item.userID);
	fname=item.fname;
    lname=item.lname;
    full_name=item.full_name;
    user_date=item.user_date;
    upass=item.upass;
    uname=item.uname;
    email=item.email;
    phone_num=item.phone_num;
    level=item.level;
    var row='';

	row+='<tr class="even highlight" id="user_'+id+'" >'+
	 
	  '<td>'+
        '<input class="mybutton" id="btnDeleteUser" value="מחק משתמש" onclick="return del_user('+id+',\''+url+'\' )"  type="button">'+
	  '</td>'+
	  
	  
	  '<td>'+ 
	  '<a href="#" onclick="return editUser4('+id+',\''+url+'\' )" >'+
      
          '<b>'+fname+'</b>'+
      '</a>'+  
    '</td>'+

	  
	  
	  
	  '<td>'+
	   	       '<b>'+lname+'</b'+
	  '</td>'+
	
	
	  
	  '<td>'+ 
	  '<a href="#" onclick="return editUser4('+id+',\''+url+'\' )" >'+
      
          '<b>'+full_name+'</b>'+
      '</a>'+  
      '</td>'+

	  
       '<td>'+
          '<b>'+uname+'</b>'+
       '</td>'+
	  
	

      '<td>'+
        '<b>'+item.userID+'</b>'+
       '</td>'+	 
      
       

'<td><b> '+upass+'</b></td>'+
       
       '<td><b>'+email+'</b></td>'+
       
       '<td><span class="sort-alpha" >'+phone_num+'</span></td>'+	
	  '<td><span class="sort-date" >'+user_date+'<span></td>';
	
	  
		 
	  
	 if(level=='admin'){  
	 row+= '<td class="error"><b style="color:red;">'+level+'</b></td>';
	 }else{ 
		  row+='<td><b>'+level+'<span></b>';
	 }	  
	  
	 row+='<td>'+
	'</td>'+
	  
	"</tr>\n";
 
return row;	

	
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function submitNewUser(form,url)
{
	//alert(url); 
	 if(form.user.value == '') return false;
	var tz = -1 * (new Date()).getTimezoneOffset();
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.post(url+'ajax2.php?newUser'+nocache, { title: form.user.value, tz:tz, tag:filter.tag }, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		$('#total').text( parseInt($('#total1').text()) + parseInt(json.total) );
		/////////////////////////////////////////////////////////////////////////
		form.user.value = '';
		var item = json.list[0];
		userList[item.id] = item;
		userOrder.push(parseInt(item.id));
		$('#usermanager').append(prepareUserStr(item, url));
		if(sortBy != 0) changeUserOrder();
		$('#userrow_'+item.id).effect("highlight", {color:theme.newUserFlashColor}, 2000);
	}, 'json');
	flag.tagsuserChanged = true;	
	return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function toggleUserNote(id)
{
	// alert(id);  
	aArea = '#usernotearea'+id;
	if($(aArea).css('display') == 'none')
	{
		$('#usernotetext'+id).val(userList[id].noteText);
		 
		$('#userrow_'+id+'>div>div.task-note-block').removeClass('hidden');
		$(aArea).css('display', 'block');
		$('#usernote'+id).css('display', 'none');
		$('#usernotetext'+id).focus();
	} else {
		cancelUserNote(id);
	}
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cancelUserNote(id)
{
	//alert(id);
	$('#usernotearea'+id).css('display', 'none');
	$('#usernote'+id).css('display', 'block');
	if($('#usernote'+id).text() == '') {
		$('#userrow_'+id+'>div>div.task-note-block').addClass('hidden');
	}
	return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function saveUserNote(id,url)
{
	 
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.post(url+'ajax.php?edituserNote='+id+nocache, {note: $('#usernotetext'+id).val()}, function(json){
		
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		var item = json.list[0];
		userList[id].note = item.note;
		userList[id].noteText = item.noteText;
		$('#usernote'+item.id+'>span').html(prepareHtml(item.note));
		cancelUserNote(item.id);
	}, 'json');
	 
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function canceluserEdit(e)
{
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', canceluserEdit);
	$('#page_useredit').hide();
	$('#overlay').remove();
	document.edituser.user.value = '';
	document.edituser.note.value = '';
	document.edituser.tags.value = '';
	document.edituser.duedate.value = '';
	document.edituser.upass.value = '';
    document.edituser.email.value = '';
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function canceluserEdit3(e)
{
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', canceluserEdit3);
	$('#page_useredit').hide();
	$('#overlay').remove();
//	document.edituser.user.value = '';
//	document.edituser.note.value = '';
//	document.edituser.tags.value = '';
//	document.edituser.duedate.value = '';
//	document.edituser.upass.value = '';
//    document.edituser.email.value = '';
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function canceluserEdit4(e)
{
	var userID=	document.getElementById('Request_Tracking_Number1').value;
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', canceluserEdit4);
	$('#page_useredit').hide();
	$('tr#user_'+userID).removeClass('border_print');
	$('#overlay').remove();
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function canceluserEdit5(decID,forum_decID,e)
{
	var userID=	document.getElementById('Request_Tracking_Number1').value;
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', canceluserEdit5);
	$('#page_useredit'+decID+forum_decID).hide();
	
	$('#overlay').remove();
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function canceluserEdit6(forum_decID,e)
{
	
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', canceluserEdit6);
	$('#page_useredit'+forum_decID).hide();
	
	$('#overlay').remove();
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cancelPastuser(e)
{
	var userID=	document.getElementById('Request_Tracking_Number_user').value;
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelPastuser);
	$('#page_Pastuseredit').hide();
	$('#overlay').remove();
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cancelDecuser(e)
{
	var userID=	document.getElementById('Request_Tracking_Number_user').value;
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelDecuser);
	$('#page_Decuseredit').hide();
	$('#overlay').remove();
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function editUser(id)
{
	
	var item = userList[id];
	
	//alert(item.duedate);  
	
	if(item.level=='user')
		item.level=1;
	  if(item.level=='admin')
	      item.level=2;
	 if(item.level=='suppervizer')
	      item.level=3;
	 
	 
	 
	 

	
 
	if(!item) return false;
	document.edituser.user.value = dehtml(item.full_name);
	document.edituser.note.value = item.noteText;
	document.edituser.id.value = item.userID;
	document.edituser.tags.value = item.tags.split(',').join(', ');
	document.edituser.duedate.value = item.duedate;
 	document.edituser.upass.value = item.upass;
    document.edituser.email.value = item.email;
     
  
	
	
	
	sel = document.edituser.prio;
	for(i=0; i<sel.length; i++) {
		if(sel.options[i].value == item.prio)
			 
			sel.options[i].selected = true;
	}
	
	
	
	
		
	 level = document.edituser.level;
	  //alert(item.level);	
	  
	 
		for(i=0; i<level.length; i++) {
			
			if(level.options[i].value == item.level){
				 level.options[i].selected = true;
				 
		    }
		}
		

	
	//	$('<div id="overlay"></div>').appendTo('#userlist');
	// $('<div id="overlay"></div>').appendTo('#usertaskedit');//.css('opacity', 0.5).show() ;
 	 $('<div id="overlay"></div>').appendTo('body') ;//.css('opacity', 0.5).show();
	w = $('#page_useredit');
	if(!flag.windowUserEditMoved)
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
	w.fadeIn('fast').css('background','#E9FAFA');	//.show();background: #e0e0ff;
	$(document).bind('keydown', canceluserEdit);
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function saveUser(form,url)
{
	var forum_decID = document.getElementById('forum_decID').value;
	 
	if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	
	$.post(url+'ajax.php2?editUser='+form.id.value+nocache, { full_name: form.user.value, note:form.note.value, 
		   prio:form.prio.value, tags:form.tags.value, duedate:form.duedate.value, upass:form.upass.value,
		   level:form.level.value, email:form.email.value ,forum_decID:forum_decID   }, function(json){
        		   
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		var item = json.list[0];
		
		if(!userList[item.userID].compl) changeUserCnt(userList[item.userID].dueClass, -1);
		userList[item.userID] = item;
		
		$('#userrow_'+item.userID).replaceWith(prepareUserStr(item, url));
		if(item.note == '') $('#userrow_'+item.userID+'>div.task-note-block').addClass('hidden');
		else $('#userrow_'+item.userID+'>div.task-note-block').removeClass('hidden');
		if(sortBy != 0) changeUserOrder(url);
		canceluserEdit();
		if(!userList[item.userID].compl) {
			changeUserCnt(item.dueClass, 1);
			refreshUserCnt();
		}
		  
		$('#userrow_'+item.userID).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
	}, 'json');
	$("#edittags1").flushCache();
	flag.tagsuserChanged = true;
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editUsermgr (id,decID,forum_decID,url,mgr_userID)
{
		
	
$(function(){  	
	
	
	nocache = '&rnd='+Math.random();
	var tz = -1 * (new Date()).getTimezoneOffset();
	  

 document.forms['edituser'+decID+forum_decID].elements['Request_Tracking_Number1'].value=id;	
 
 



/********************************************************************************************/
 function updateTips(t) {
		
		
	   var full_name = $("#full_name"+forum_decID),
	 
	   upass = $("#upass"+forum_decID),
	   uname = $("#uname"+forum_decID),
	   email = $("#email"+forum_decID),
	   phone_num = $("#phone_num"+forum_decID),
     date1 = $("#date1"+forum_decID),
		  //tags = $("#tags"+forum_decID),
			allFields = $([]).add(full_name).add(upass).add(uname).add(email).add(phone_num).add(date1) ,
			tips = $(".validateTips");	
	
	
	
	   if($.browser.msie==true){
			
			tips.text(t).addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');


		}else{
			tips.text(t).addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');
			setTimeout(function() {
				tips.removeClass('ui-state-highlight', 1500);
			}, 500).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
		}

 }	   
	   
	   
	   
	   
function checkLength(o,n,min,max) {

	if ( (o.val().length > max || o.val().length < min) || (o.val()=="null") ) {
		o.addClass('ui-state-error');
		updateTips("אורך של שדה: " + n + " -חייב להיות בין "+min+" לבין "+max+ " תווים.");
		return false;
	} else {
		return true;
	}

}

function checkRegexp(o,regexp,n) {

	if ( !( regexp.test( o.val() ) ) ) {
		o.addClass('ui-state-error');
		updateTips(n);
		return false;
	} else {
		return true;
	}

}

/*******************************************************************************************/	
 
 
		Listmgr =new Array();
		
	

		$.getJSON(url+'ajax2.php?pre_editMgr&userID='+id+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
 	//	$('.date').datepicker({'dateFormat':"yy-mm-dd",'yearRange': '-10:+50','buttonImage': "../../images/calendar.gif" ,'changeYear':true}); 		
// 		$("#duedate4").datepicker({dateFormat: 'dd.mm.yy', firstDay: 1, showOn: 'button', buttonImage:'../../../images/calendar.png', buttonImageOnly: true, 
// 			changeMonth:true, changeYear:true, constrainInput: false, duration:'', nextText:'&gt;', prevText:'&lt;', dayNamesMin:lang.daysMin, 
// 			monthNamesShort:lang.monthsShort });
 		
 		
 		
 	 item =json.list[0];
 	 flag_level=$('#flag_level').val();
 		
		$('<div id="manager_edit_entry_form'+decID+forum_decID+'" title="ערוך מנהל" dir="rtl">'+
				'<form id="edit_mgr'+decID+forum_decID+'">'+
				'<p class="validateTips">כול השדות נחוצים.</p>'+
				'<h3>המנהל:<input id="full_nameMgr'+decID+forum_decID+'" name="full_nameMgr'+decID+forum_decID+'" type="text" value="' + item.full_name + '" class="mycontrol"></h3>'+
				
				'<h3>שם משתמש:<input id="unameMgr'+decID+forum_decID+'" name="unameMgr'+decID+forum_decID+'" type="text" value="' + item.uname + '" class="mycontrol"></h3>'+	
				
				
				
				'<h3>'+
				'<span class="h">סיסמה:</span>'+
				'<input id="upassMgr'+decID+forum_decID+'" name="upassMgr'+decID+forum_decID+'" type="text" value="' + item.upass + '" class="mycontrol">'+
				'</h3>'+
				
				
				'<h3>'+
				  '<div class="form-row">'+
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    '&nbsp;'+
				  '<span class="h">עדיפות</span>'+ 
				    '<SELECT name="prioMgr'+decID+forum_decID+'" id="prioMgr'+decID+forum_decID+'" class="mycontrol">'+
				      '<option value="3">+3</option>'+
				      '<option value="2">+2</option>'+
				      '<option value="1">+1</option>'+
				      '<option value="0" selected>&plusmn;0</option>'+
				      '<option value="-1">&minus;1</option>'+
				     '</SELECT>'+
				    
				     //'<input name="duedate5" id="duedate5" value="" class="mycontrol"  title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />'+
				'</div>'+
	             '</h3>'+
	             
	             
	          '<h3>'+
				  '<div class="form-row">'+
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    
				    '<span class="h">תאריך השמה בפורום:</span>'+ 
				   '<input name="date2'+decID+forum_decID+'" id="date2'+decID+forum_decID+'" value="' + item.manager_date + '"  class="mycontrol" />'+
				   '</div>'+
				  
				   
				   '<div class="form-row">'+
				   '&nbsp;'+ 
				    '&nbsp;'+ 
				    '&nbsp;'+
				   '<span class="h">מצב משימה אחרונה:</span>'+ 
				   '<input name="date1'+decID+forum_decID+'" id="date1'+decID+forum_decID+'" value="' + item.duedate + '"  class="mycontrol" />'+
				   
				   
				   '</div>'+
		       '</h3>'+
		             
	             
				
	            
	  '<h3>'+
       ' <div class="form-row">'+  
       '&nbsp;'+ 
	    '&nbsp;'+ 
	    '&nbsp;'+
       '<span class="h">תוקף תפקיד:</span>'+
		  '<SELECT name="levelMgr'+decID+forum_decID+'"  id="levelMgr'+decID+forum_decID+'" class="mycontrol"  >'+
	      ' <option value="0" >חבר פורום </option>'+
	      '<option value="1" >מנהל </option>'+
	      '<option value="2" >מפקח</option>'+
	     '</SELECT> '+
	  '</div>'+ 	  
	  '</h3>'+ 	  
		  
		  
		// '</form> '+
 '<h3>דואר אלקטרוני:<input id="emailMgr'+decID+forum_decID+'"      name="emailMgr'+decID+forum_decID+'"     type="text" value="' + item.email + '"      class="mycontrol"></h3>'+	
         '<h3>טלפון:<input id="phone_numMgr'+decID+forum_decID+'"  name="phone_numMgr'+decID+forum_decID+'" type="text" value="' + item.phone_num + '"  class="mycontrol"></h3>'+
          '<h3>תגית:<input id="tagsMgr'+decID+forum_decID+'"       name="tagsMgr'+decID+forum_decID+'"      type="text" value="' + item.tags + '"       class="mycontrol"></h3>'+
	
		'הערות<br />'+
		 '<textarea style="width:400px;height:200px" id="noteMgr'+decID+forum_decID+'" >'+item.noteText+'</textarea></form></div>').appendTo($('body'));
			
			  	
			 	
			  	if(item.level=='user')
					item.level=1;
				 if(item.level=='admin')
				      item.level=2;
				 if(item.level=='suppervizer')
				      item.level=3;
			  	
				 document.getElementById("levelMgr"+decID+forum_decID).selectedIndex = item.level; 
			//	 alert(item.prio );
				 document.getElementById("prioMgr"+decID+forum_decID).value=item.prio;
				 //selectedIndex = item.prio; 
			
				 
	 if(flag_level==1){		 
				 
		$("#manager_edit_entry_form"+decID+forum_decID).dialog({
				 
				
				bgiframe: true,
				autoOpen: false,
				height: 600,
				width: 450,
				modal: true,
			 //	zindex: 1006 ,
				buttons: {

				
				'Save':  function() {
			
 var full_name = $("#full_nameMgr"+decID+forum_decID),
			 
			  
			 
			 
			   upass = $("#upassMgr"+decID+forum_decID),
			   uname = $("#unameMgr"+decID+forum_decID),
			   email = $("#emailMgr"+decID+forum_decID),
			   phone_num = $("#phone_numMgr"+decID+forum_decID),
				  date1 = $("#date1"+decID+forum_decID),
				  //tags = $("#tags"+forum_decID),
					allFields = $([]).add(full_name).add(upass).add(uname).add(email).add(phone_num).add(date1) ,
					tips = $(".validateTips");

			
				 
			var bValid = true;
			allFields.removeClass('ui-state-error');
			bValid = bValid && checkLength(full_name,"שם מלא",3,16);
			bValid = bValid && checkLength(phone_num,"טלפון",3,16);
			//bValid = bValid && checkLength(date1,"date1",10,20);
			bValid = bValid && checkLength(uname,"שם משתמש",3,16);
			bValid = bValid && checkLength(email,"דואר אלקטרוני",6,80);
			bValid = bValid && checkLength(upass,"סיסמה",4,16);

			 bValid = bValid && checkRegexp(full_name,/^[a-z]([0-9a-z_])+$/i,"Username may consist of a-z, 0-9, underscores, begin with a letter.");
			// || checkRegexp(full_name,/^[א-ת \'.-]{2,20}+$/i,"Username may consist of a-z, 0-9, underscores, begin with a letter.") ;;
			  //('/^[א-ת \'.-]{2,20}$/i', $_POST['first_name'])                                  
			// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
			bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");
			bValid = bValid && checkRegexp(upass,/^([0-9a-zA-Z])+$/,"סיסמה נכשלה מותר רק : a-z 0-9");
			
			if (bValid) { 	
	            var $this=$(this);   
	             full_name=$('#full_nameMgr'+decID+forum_decID).val();
	             uname=$('#unameMgr'+decID+forum_decID).val();
	             upass=$('#upassMgr'+decID+forum_decID).val();
	             prio=$('#prioMgr'+decID+forum_decID).val();
	             prio2 =document.forms['edit_mgr'+decID+forum_decID].elements['prioMgr'+decID+forum_decID].value;
	             duedate=$('#date1'+decID+forum_decID).val();
	             manager_date=$('#date2'+decID+forum_decID).val();
	             level=$('#levelMgr'+decID+forum_decID).val();
	             email=$('#emailMgr'+decID+forum_decID).val();
	             phone=$('#phone_numMgr'+decID+forum_decID).val();
	             note=$('#noteMgr'+decID+forum_decID).val();
	             tags=$('#tagsMgr'+decID+forum_decID).val();
	            
	             $.ajax({
	                  type: "POST",
/***************************************************************************************/
	                  //$.post(url+'ajax2.php?editUser='+form.Request_Tracking_Number1.value+nocache,{ 
	              		   	                  
/***************************************************************************************/	                  
	                       url: url+'ajax2.php?editUser='+item.userID,
	                       dataType: 'json',
	                       data: {
	            	        full_name:full_name,    uname:uname,     note:note, 
	              	        prio:prio,              tags:tags,      duedate:duedate,
	              		    upass:upass,            phone:phone,    manager_date:manager_date, 
	              		    level:level,            email:email ,   forum_decID:forum_decID
	                       },
	                       success: function(json) {
	                             
	                       
	                       $this.dialog('close');
	                       loadUsers2(url,forum_decID,decID,mgr_userID,item.managerID);
/******************************************************************************************/
 
/****************************************************************************************/                        
                   }//end success
	                
	              });//end ajx
			}
	     },//end function save 
	    
				
					Cancel: function() {
						$(this).dialog('close');
						$("#manager_edit_entry_form"+decID+forum_decID).remove();
						 
					} 
				
	/***************************************************************************************/		

	/******************************************************************************************/		
			
			},//end button

		     
				close: function() {
				 
				 
				$("#manager_edit_entry_form"+decID+forum_decID).remove();
			 
				}
				 
			});//end dialog
		
////////////////////////////////////////		
	 }else  if(flag_level==0){       //
//////////////////////////////////////		 
         
		 $("#manager_edit_entry_form"+decID+forum_decID).dialog({
			 
				
				bgiframe: true,
				autoOpen: false,
				height: 700,
				width: 450,
				modal: true,
			 //	zindex: 1006 ,
				buttons: {

			
				
					Cancel: function() {
						$(this).dialog('close');
						$("#manager_edit_entry_form"+decID+forum_decID).remove();
						 
					} 
				
	/***************************************************************************************/		

	/******************************************************************************************/		
			
			},//end button

		     
				close: function() {
				 
				 
				$("#manager_edit_entry_form"+decID+forum_decID).remove();
			 
				}
				 
			});//end dialog

		 
	 }		 
			$("#manager_edit_entry_form"+decID+forum_decID).dialog('open');
			//$("#ui-datepicker-div").addClass("promoteZ"); 
			 
			function updateDate(date) {
				  $("#date1"+decID+forum_decID).val(date);
				  
		       }
				
			function updateDate1(date) {
				  
				  $("#date2"+decID+forum_decID).val(date);
		       }
				//datepicker config
				var pickerOpts = {
				  beforeShow: function() {
				    $("#ui-datepicker-div").css("zIndex", 2006).next().css("zIndex", 1006);
				  },
					 dateFormat:'yy-mm-dd' ,
					 changeMonth: true,
	                   changeYear: true,
	                   showButtonPanel: true,
	                   buttonText: "Open date picker",
	                   altField: '#actualDate'
 
				};
	       				
				$("#date1"+decID+forum_decID).focus(function() {
				   $(this).datepicker("dialog", null, updateDate, pickerOpts);
				     return false;
			  		});
				
				$("#date2"+decID+forum_decID).focus(function() {
					   $(this).datepicker("dialog", null, updateDate1, pickerOpts);
					     return false;
				  		});
				
		    $("#date1"+decID+forum_decID).datepicker({ firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
		    $("#date2"+decID+forum_decID).datepicker({ firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
		    $("#tagsMgr"+decID+forum_decID).autocomplete('/alon-web/olive_prj/admin/ajax2.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
/*********************************************************************************************************/			
		});//end get_json
	return false;
       });
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editReg_user (id,url)
{
	nocache = '&rnd='+Math.random();
	var tz = -1 * (new Date()).getTimezoneOffset();
	  
	$.getJSON(url+'ajax2.php?pre_editUserPrint&userID='+id+'&tz='+tz+nocache, function(json){
 	 item =json.list[0];
 	 flag_level=$('#flag_level').val();	
 	 
 	 
 	 
		$('<div id="user_edit_entry_form" title="ערוך משתמש" dir="rtl">'+
				'<form id="edit_usr">'+
				'<p class="validateTips">כול השדות נחוצים.</p>'+
				'<h3>החבר:<input id="full_nameUsr" name="full_nameUsr" type="text" value="' + item.full_name + '" class="mycontrol"></h3>'+
				'<h3>שם פרטי:<input id="f_nameUsr" name="f_nameUsr" type="text" value="' + item.fname + '" class="mycontrol"></h3>'+
				'<h3>שם מישפחה:<input id="l_nameUsr" name="l_nameUsr" type="text" value="' + item.lname + '" class="mycontrol"></h3>'+
				'<h3>שם משתמש:<input id="unameUsr"  name="unameUsr" type="text" value="' + item.uname + '" class="mycontrol"></h3>'+	
				
				
				
				'<h3>'+
				'<span class="h">סיסמה:</span>'+
				'<input id="upassUsr" name="upassUsr" type="text" value="' + item.upass + '" class="mycontrol">'+
				'</h3>'+
				

	             
	             
	          '<h3>'+
				  '<div class="form-row">'+
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    
				    '<span class="h">תאריך לידה:</span>'+ 
				   '<input name="date1" id="date1" value="' + item.user_date + '"  class="mycontrol" />'+
				   '</div>'+
				   
		       '</h3>'+
		             
	             
				
	            
	  '<h3>'+
       ' <div class="form-row">'+  
       '&nbsp;'+ 
	    '&nbsp;'+ 
	    '&nbsp;'+
       '<span class="h">תוקף תפקיד:</span>'+
		  '<SELECT name="levelUsr"  id="levelUsr" class="mycontrol"  >'+
	      ' <option value="1" >חבר פורום </option>'+
	      '<option value="2" >מנהל </option>'+
	      '<option value="3" >מפקח</option>'+
	      '<option value="4">מנהל+חבר פורום</option>'+
	     '</SELECT> '+
	  '</div>'+ 	  
	  '</h3>'+ 	  
		  
		  
		// '</form> '+
 '<h3>דואר אלקטרוני:<input id="emailUsr"      name="emailUsr"     type="text" value="' + item.email + '"      class="mycontrol"></h3>'+	
         '<h3>טלפון:<input id="phone_numUsr"  name="phone_numUsr" type="text" value="' + item.phone_num + '"  class="mycontrol"></h3>'+
        //  '<h3>תגית:<input id="tagsUsr"       name="tagsUsr"      type="text" value="' + item.tags + '"       class="mycontrol"></h3>'+
	
		'הערות<br />'+
		 '<textarea style="width:400px;height:200px" id="noteUsr" >'+item.noteText+'</textarea></form></div>').appendTo($('body'));
			
			  	
			 	
			  	if(item.level=='user')
					item.level=1;
				 if(item.level=='admin')
				      item.level=2;
				 if(item.level=='suppervizer')
				      item.level=3;
				 if(item.level=='user_admin')
				      item.level=4;
			
				 document.getElementById("levelUsr").value = item.level;
			
			
				 
 if(flag_level==1){		 				 
				 
		$("#user_edit_entry_form").dialog({
				 
				
				bgiframe: true,
				autoOpen: false,
				height: 700,
				width: 450,
				modal: true,
			 //	zindex: 1006 ,
				buttons: {

				
				'Save':  function() {
			
 var full_name = $("#full_nameUsr"),
			   fname= $("#f_nameUsr"),
			   lname= $("#l_nameUsr"),
			   upass = $("#upassUsr"),
			   uname = $("#unameUsr"),
			   email = $("#emailUsr"),
			   phone_num = $("#phone_numUsr"),
			   date1 = $("#date1"),
				  //tags = $("#tags"+forum_decID),
					allFields = $([]).add(full_name).add(upass).add(uname).add(email).add(phone_num).add(date1) ,
					tips = $(".validateTips");

			
				 
			var bValid = true;
			allFields.removeClass('ui-state-error');
			bValid = bValid && checkLength2(full_name,"שם מלא",3,16);
			bValid = bValid && checkLength2(fname,"שם פרטי",3,16);
			bValid = bValid && checkLength2(lname,"שם מישפחה",3,16);
			bValid = bValid && checkLength2(phone_num,"טלפון",3,16);
			bValid = bValid && checkLength2(date1,"תאריך לידה",10,20);
			bValid = bValid && checkLength2(uname,"שם משתמש",3,16);
			bValid = bValid && checkLength2(email,"דואר אלקטרוני",6,80);
			bValid = bValid && checkLength2(upass,"סיסמה",4,16);
			bValid = bValid && checkRegexp2(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"דוגמה:alonmor@gmail.com");
			bValid = bValid && checkRegexp2(upass,/^([0-9a-zA-Z])+$/,"Password field only allow : a-z 0-9");
			
			if (bValid) { 	
	            var $this=$(this);   
	             full_name=$('#full_nameUsr').val();
	             fname= $("#f_nameUsr").val();
	             uname=$('#unameUsr').val();
	             lname= $("#l_nameUsr").val();
	             upass=$('#upassUsr').val();
//	             prio=$('#prioUsr').val();
//	             prio2 =document.forms['edit_usr'].elements['prioUsr'].value;
	             user_date=$('#date1').val();
	             //manager_date=$('#date2').val();
	             level=$('#levelUsr').val();
	             email=$('#emailUsr').val();
	             phone_num=$('#phone_numUsr').val(); 
	             note=$('#noteUsr').val();
	            // tags=$('#tagsUsr').val();
                 userID=id;	            
	             $.ajax({
	                  type: "POST",
/***************************************************************************************/
	                       url: url+'ajax2.php?newNormalUser='+item.userID,
	                       dataType: 'json',
	                       data: {
	            	        full_name:full_name,fname:fname,lname:lname,    uname:uname,     note:note, 
	              	        upass:upass,            phone_num:phone_num,   user_date:user_date, 
	              		    level:level,            userID:userID,   email:email  
	                       },
	                       success: function(json) {
	                             
	                       
	                       $this.dialog('close');
	                       
/******************************************************************************************/
                   }//end success
	                
	              });//end ajx
			}
	     },//end function save 
	    
				
					Cancel: function() {
						$(this).dialog('close');
						$("#user_edit_entry_form").remove();
						 
					} 
/******************************************************************************************/		
			
},//end button

		     
		close: function() {
		 
		 
		$("#user_edit_entry_form").remove();
	 
		}
		 
	});//end dialog
		
/////////////////////////////////		
 }else if(flag_level==0){    ///
////////////////////////////////	 
		$("#user_edit_entry_form").dialog({
			 
			
			bgiframe: true,
			autoOpen: false,
			height: 440,
			width: 450,
			modal: true,
		 //	zindex: 1006 ,
			buttons: {

			
				Cancel: function() {
					$(this).dialog('close');
					$("#user_edit_entry_form").remove();
					 
				} 
		
		
},//end button

	     
	close: function() {
	 
	 
	$("#user_edit_entry_form").remove();
 
	}
	 
});//end dialog
	 
 }	 
			$("#user_edit_entry_form").dialog('open');
 
			 

			function updateDate(date) {
				  $("#date1").val(date);
				  
		       }
				
//			function updateDate1(date) {
//				  
//				  $("#date2").val(date);
//		       }
				//datepicker config
				var pickerOpts = {
				  beforeShow: function() {
				    $("#ui-datepicker-div").css("zIndex", 2006).next().css("zIndex", 1006);
				  },
				 dateFormat:'yy-mm-dd' ,
				 changeMonth: true,
                   changeYear: true,
                   showButtonPanel: true,
                   buttonText: "Open date picker",
                   altField: '#actualDate'
				};
	       
				
				
				$("#date1").focus(function() {
				   $(this).datepicker("dialog", null, updateDate, pickerOpts);
				     return false;
			  		});
				
//				$("#date2").focus(function() {
//					   $(this).datepicker("dialog", null, updateDate1, pickerOpts);
//					     return false;
//				  		});
				
 	    $("#date1").datepicker({ firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});

		   // $("#date2").datepicker({ firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
		    $("#tagsUsr").autocomplete('/alon-web/olive_prj/admin/ajax2.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
/*********************************************************************************************************/			
		});//end get_json
	return false;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editUser4 (id,url)
{
/***********************************************************/	
//	tz = -1 * (new Date()).getTimezoneOffset();
// //	setAjaxErrorTrigger2(url);
//	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
//	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
	 $('tr#user_'+id).addClass('border_print');
	
	
/**********************************************************/	
	
 document.getElementById('Request_Tracking_Number1').value=id;

	$.getJSON(url+'ajax2.php?pre_editUserPrint&userID='+id+'&tz='+tz+nocache, function(json){
		
	 // resetAjaxErrorTrigger();
		 
		 
		
		 
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
			
		 	 
		 if(item.level=='user')
			item.level=1;
		 if(item.level=='admin')
		      item.level=2;
		 if(item.level=='suppervizer')
		      item.level=3;
		 if(item.level=='user_admin')
		      item.level=4;
		 

   		  
		 
		  document.getElementById('active').value =(item.active); 
		  document.getElementById('level').value =(item.level);
		  document.getElementById('duedate4').value =(item.user_date);
		  
		  
		  document.getElementById('full_name').value =(item.full_name);
		  document.getElementById('fname').value =(item.fname);
		  document.getElementById('lname').value =(item.lname);
		  document.getElementById('user').value =(item.uname);
		  document.getElementById('upass').value =(item.upass);
		  
 		   
 		  document.getElementById('note').value =(item.noteText);
 		  document.getElementById('phone').value =(item.phone_num);
 		  document.getElementById('email').value =(item.email);
 		  
 		  
 		  
    	  
 		  
 
		});
		
});
  
	$('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	w = $('#page_useredit');
	
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
	.css('position','relative')
	.css('background','blue') 
	
	 .css({'z-iindex': '201'}) 
	
	.css({'padding':'8px'})
	.css({'left':'200px'})
	
	.css({'top':'-550px'}) 
	.css({'bottom':'500px'})
	
	.css({'float':'left'})			
	.css({'width':'510px'})
	.css({'border':'3px solid #666'})
	
	.show();
	
	
	$('#page_useredit').draggable();
	
	$(document).bind('keydown', canceluserEdit4);
	return false;
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editUser5 (id,url)
{
/***********************************************************/	
	tz = -1 * (new Date()).getTimezoneOffset();
 //	setAjaxErrorTrigger2(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
	$('tr#user_'+id).addClass('border_print');
	
	
/**********************************************************/	
	
	 document.getElementById('Request_Tracking_Number1').value=id;
	 
  
	$.getJSON(url+'ajax2.php?pre_editUserPrint&userID='+id+'&tz='+tz+nocache, function(json){
		
	 // resetAjaxErrorTrigger();
		 
		 
		
		 
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
			
		 	 
		 if(item.level=='user')
			item.level=1;
		 if(item.level=='admin')
		      item.level=2;
		 if(item.level=='suppervizer')
		      item.level=3;
		 
   		  
		  document.getElementById('active2').value =(item.active); 
		  document.getElementById('level2').value =(item.level);
		  document.getElementById('duedate2').value =(item.user_date);
		  
		  
		  document.getElementById('full_name2').value =(item.full_name);
		  document.getElementById('fname2').value =(item.fname);
		  document.getElementById('lname2').value =(item.lname);
		  document.getElementById('user2').value =(item.uname);
		  document.getElementById('upass2').value =(item.upass);
		  
 		   
 		  document.getElementById('note2').value =(item.noteText);
 		 document.getElementById('phone2').value =(item.phone_num);
 		  document.getElementById('email2').value =(item.email);
 		  
 		  
 		  
    	  
 		  
 
		});
		
});
 
	 
	$('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	w = $('#page_useredit2');
	
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
	.css('position','relative')
	.css('background','#B4D9D7') 
	
	 .css({'z-iindex': '201'}) 
	
	.css({'padding':'8px'})
	.css({'left':'200px'})
	
	.css({'top':'-550px'}) 
	.css({'bottom':'500px'})
	
	.css({'float':'left'})			
	.css({'width':'510px'})
	.css({'border':'3px solid #666'})
	
	.show();
	
	
	$('#page_useredit2').draggable();
	
	$(document).bind('keydown', canceluserEdit4);
	return false;
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function submitNewNormalUser(form,url)//wrok with insert= pre_submitUser and update=edit_user4
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
{
 
	n_userList = new Array();
		
	var userID=document.getElementById('Request_Tracking_Number1').value;	
	
		 
	     
	 	if(document.getElementById('full_name').value == '')
		 
	 	{ 
	     alert("טעות");
	 	return false;
	 	}
	 	
	 	
	 	var level = document.getElementById('level').value;
		var active= document.getElementById('active').value;
		var user_date = document.getElementById('duedate4').value;
		var full_name=document.getElementById('full_name').value;
		var fname=document.getElementById('fname').value;
		var lname=document.getElementById('lname').value;
		var uname=document.getElementById('user').value;
		var upass=document.getElementById('upass').value;
		 
		 
		var email=document.getElementById('email').value;
		var phone_num=document.getElementById('phone').value;
		
		var note=document.getElementById('note').value;
	 
		var tz = -1 * (new Date()).getTimezoneOffset();
		 
		nocache = '&rnd='+Math.random();
		
		
		if(userID)	{//the hidden field Request_Tracking_Number1	
		$.post(url+'ajax2.php?newNormalUser', {userID:userID, level: level ,active: active ,user_date: user_date,full_name:full_name ,fname:fname,
			lname:lname,uname:uname,upass:upass,email:email,phone_num:phone_num,note:note,tz:tz }, function(json){	
				var item = json.list[0];
				$('tr#user_'+item.userID).removeClass('border_print');	
//	 		 $('#my_level_td'+userID).val(item.level);
	 		//document.getElementById('my_level_td'+userID).value=item.level;
	 		$('#my_level_td'+userID).html('').append(item.level).addClass('error');
		}, 'json');
	  
	}else{
		$.post(url+'ajax2.php?newNormalUser', { level: level ,active: active ,user_date: user_date,full_name:full_name ,fname:fname,
			lname:lname,uname:uname,upass:upass,email:email,phone_num:phone_num,note:note,tz:tz }, function(json){		
	 		 
			 
				
			
			 
			if(!parseInt(json.total))  return;
			$('#total').text( parseInt($('#total').text()) + parseInt(json.total) );
	 	 
			 
			
		 
			var item = json.list[0];
			 
			n_userList[item.id] = item;
			
			
			
			
			  prepareNormalUserStr(item, url);
			 
			  
			//  $('tr#user_'+item.userID).prependTo('#theList:first') ;
			 $('#theList:first').prepend(prepareNormalUserStr(item, url));
			//	$('#theList:first').append(prepareNormalUserStr(item, url));
			  
			 //$("p:last").prependTo("p:first");
		  	
			 
		}, 'json');
		
	}	 
		
		
		 
		
		return false;	
		
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editPastUser (id,forum_decID,url)
{
/***********************************************************/	
	nocache = '&rnd='+Math.random();
	
	// $('tr#user_'+id).addClass('border_print');
	
	
/**********************************************************/	
  
 document.getElementById('Request_Tracking_Number_user').value=id;
 document.getElementById('Request_Tracking_Number_forum').value=forum_decID;
//pre_editUserPrint
	$.getJSON(url+'ajax2.php?preEdit_past_user&userID='+id+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
		
	 // resetAjaxErrorTrigger();
		 
		 
		
		 
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
			
		 	 
		 if(item.level=='user')
			item.level=1;
		 if(item.level=='admin')
		      item.level=2;
		 if(item.level=='suppervizer')
		      item.level=3;
		 if(item.level=='user_admin')
		      item.level=4;
		 

   		  
		 
		  document.getElementById('past_active').value =(item.active); 
		  document.getElementById('past_level').value =(item.level);
		  document.getElementById('past_duedate5').value =(item.start_date);
		  document.getElementById('past_duedate6').value =(item.end_date);
		  
		  document.getElementById('past_full_name').value =(item.full_name);
		  document.getElementById('past_fname').value =(item.fname);
		  document.getElementById('past_lname').value =(item.lname);
		  document.getElementById('past_frm_name').value =(item.forum_decID);
		  //document.getElementById('past_frm_name1').value =(item.forum_decName); 
 		  document.getElementById('past_note').value =(item.noteText);
 		  
 
		});
		
});
  
	//$('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	w = $('#page_Pastuseredit');
	
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
	.css('position','relative')
	.css('background','#E01B4C') 
	
	 .css({'z-iindex': '201'}) 
	
	.css({'padding':'8px'})
	.css({'left':'200px'})
	
	.css({'top':'-550px'}) 
	.css({'bottom':'500px'})
	
	.css({'float':'left'})			
	.css({'width':'510px'})
	.css({'border':'3px solid #666'})
	
	.show();
	
	
	$('#page_Pastuseredit').draggable();
	
	$(document).bind('keydown',cancelPastuser);
	return false;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function submitNewPastNormalUser(form,url)//wrok with insert= pre_submitUser and update=edit_user4
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
{
		
	p_userList = new Array();
		
	
	
	var userID=document.getElementById('Request_Tracking_Number_user').value;
	var forumID_src=document.getElementById('Request_Tracking_Number_forum').value;	
		 
	     
	 	if(document.getElementById('past_full_name').value == '')
		 
	 	{ 
	     alert("טעות");
	 	return false;
	 	}
	 	
	 	
	 	var level = document.getElementById('past_level').value;
		var active= document.getElementById('past_active').value;
		
		var full_name=document.getElementById('past_full_name').value;
		var fname=document.getElementById('past_fname').value;
		var lname=document.getElementById('past_lname').value;
		
		var start_date = document.getElementById('past_duedate5').value;
		var end_date = document.getElementById('past_duedate6').value;
		
		var forum_decID=document.getElementById('past_frm_name').value;
		
		 
		 
		
		var note=document.getElementById('past_note').value;
	 
		var tz = -1 * (new Date()).getTimezoneOffset();
		 
		nocache = '&rnd='+Math.random();
		
		
		if(!(forum_decID==forumID_src))	{//the hidden field Request_Tracking_Number1	
		$.post(url+'ajax2.php?submit_PastNormalUser', {mode:'update',userID:userID,forum_decID:forum_decID,forumID_src:forumID_src, level: level ,active: active ,
		start_date: start_date,end_date: end_date,full_name:full_name ,fname:fname,lname:lname,note:note,tz:tz }, function(json){
			var forumID_src=document.getElementById('Request_Tracking_Number_forum').value;	
				var item = json.list[0];
				var row= preparePastNormalUserStr(item, url);		
                $('tr#user_'+userID+forumID_src).replaceWith(row).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
				
			//	$('tr#user_'+item.userID).removeClass('border_print');	
	 		//$('#my_level_td'+userID).html('').append(item.level).addClass('error');
		  //$('#userrow_'+item.userID).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
	 		
		}, 'json');
		}else if(userID &&  forum_decID==forumID_src){
			
			$.post(url+'ajax2.php?submit_PastNormalUser', {mode:'change_details',userID:userID,forum_decID:forum_decID,forumID_src:forumID_src, level: level ,active: active ,
				start_date: start_date,end_date: end_date,full_name:full_name ,fname:fname,lname:lname,note:note,tz:tz }, function(json){
					
						var item = json.list[0];
					
									
			
						
						
						
				
						
					//	$('tr#user_'+item.userID).removeClass('border_print');	
			 		//$('#my_level_td'+userID).html('').append(item.level).addClass('error');
				  //$('#userrow_'+item.userID).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
			 		
				}, 'json');	
			
			
			 
		}else{
		$.post(url+'ajax2.php?submit_PastNormalUser',{mode:'save',userID:userID,forum_decID:forum_decID, level: level ,active: active ,
		 start_date: start_date,end_date: end_date,full_name:full_name ,fname:fname,lname:lname,note:note,tz:tz }, function(json){		
	 		  
			if(!parseInt(json.total))  return;
			$('#total').text( parseInt($('#total').text()) + parseInt(json.total) );
	 	 
			 	var item = json.list[0];
			 
//		      p_userList[item.id] = item;
 		  prepareNormalUserStr(item, url);
//			 
//			 $('#theList:first').prepend(prepareNormalUserStr(item, url));
			}, 'json');
		
	}	 
		
		return false;	
		
}	 

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editUserDec_frm (id,forum_decID,decID,url)//work with print_Decuser_frm  edit key
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
{
	
	nocache = '&rnd='+Math.random();
	
	// $('tr#user_'+id).addClass('border_print');
	
	
/**********************************************************/	
  
 document.getElementById('Request_Tracking_Number_user').value=id;
 document.getElementById('Request_Tracking_Number_forum').value=forum_decID;
 document.getElementById('Request_Tracking_Number_dec').value=decID;
//pre_editUserPrint
	$.getJSON(url+'ajax2.php?edit_dec_frm_user&userID='+id+'&forum_decID='+forum_decID+'&decID='+decID+'&tz='+tz+nocache, function(json){
		
	 // resetAjaxErrorTrigger();
		  
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
			
		 	 
		 if(item.level=='user')
			item.level=1;
		 if(item.level=='admin')
		      item.level=2;
		 if(item.level=='suppervizer')
		      item.level=3;
		 if(item.level=='user_admin')
		      item.level=4;
		 

   		  
		 
		  document.getElementById('dec_usr_active').value =(item.active); 
		  document.getElementById('dec_usr_level').value =(item.level);
		  document.getElementById('dec_usr_duedate_start').value =(item.start_date);
		  document.getElementById('dec_usr_duedate_end').value =(item.end_date);
		  
		  document.getElementById('dec_usr_full_name').value =(item.full_name);
		  document.getElementById('dec_usr_fname').value =(item.fname);
		  document.getElementById('dec_usr_lname').value =(item.lname);
		  document.getElementById('decision_usr_name').value =(item.decName);
		  document.getElementById('dec_usr_frm_name').value =(item.forum_decID);
		  
 		  document.getElementById('dec_usr_note').value =(item.noteText);
 		  
 
		});
		
});
  
	//$('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	w = $('#page_Decuseredit');
	
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
	.css('position','relative')
	.css('background','#E01B4C') 
	
	 .css({'z-iindex': '201'}) 
	
	.css({'padding':'8px'})
	.css({'left':'200px'})
	
	.css({'top':'-550px'}) 
	.css({'bottom':'500px'})
	
	.css({'float':'left'})			
	.css({'width':'510px'})
	.css({'border':'3px solid #666'})
	
	.show();
	
	
	$('#page_Decuseredit').draggable();
	
	$(document).bind('keydown',cancelDecuser);
	return false;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function submitDecForumUser(form,url)//editUserDec_frm (id,forum_decID,url)//work with print_Decuser_frm  edit key
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
{
		
	p_userList = new Array();
		
	
	
	var userID=document.getElementById('Request_Tracking_Number_user').value;
	var forumID_src=document.getElementById('Request_Tracking_Number_forum').value;	
    var decID= document.getElementById('Request_Tracking_Number_dec').value;		 
	     
	 	if(document.getElementById('dec_usr_full_name').value == '')
		 
	 	{ 
	     alert("טעות");
	 	return false;
	 	}
	 	
	 	
	 	var level = document.getElementById('dec_usr_level').value;
		var active= document.getElementById('dec_usr_active').value;
		
		var full_name=document.getElementById('dec_usr_full_name').value;
		var fname=document.getElementById('dec_usr_fname').value;
		var lname=document.getElementById('dec_usr_lname').value;
		
		var HireDate = document.getElementById('dec_usr_duedate_start').value;
		var end_date = document.getElementById('dec_usr_duedate_end').value;
		
		var forum_decID=document.getElementById('dec_usr_frm_name').value;
		var note=document.getElementById('dec_usr_note').value;
			
		var tz = -1 * (new Date()).getTimezoneOffset();
		 
		nocache = '&rnd='+Math.random();
		
		
if(!(forum_decID==forumID_src))	{//the hidden field Request_Tracking_Number1	
$.post(url+'ajax2.php?submitDecForumUser', {mode:'update',userID:userID,forum_decID:forum_decID,decID:decID,forumID_src:forumID_src,
	level: level ,active: active ,HireDate: HireDate,end_date: end_date,full_name:full_name ,fname:fname,lname:lname,note:note,tz:tz }, function(json){
            
		var userID=document.getElementById('Request_Tracking_Number_user').value;
		var forumID_src=document.getElementById('Request_Tracking_Number_forum').value;	
	    var decID= document.getElementById('Request_Tracking_Number_dec').value;		 

		       
				var item = json.list[0];
				var row= prepareDecUserStr(item, url);		
                $('tr#user_'+userID+forumID_src+decID).replaceWith(row).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
		}, 'json');




}else if(userID &&  forum_decID==forumID_src){
	
	$.post(url+'ajax2.php?submitDecForumUser', {mode:'change_details',userID:userID,forum_decID:forum_decID,decID:decID,forumID_src:forumID_src,
		level: level ,active: active ,HireDate: HireDate,end_date: end_date,full_name:full_name ,fname:fname,lname:lname,note:note,tz:tz }, function(json){
					
						var item = json.list[0];			
				}, 'json');	 


}else{
		$.post(url+'ajax2.php?submitDecForumUser',{mode:'save',userID:userID,forum_decID:forum_decID,decID:decID, level: level ,active: active ,
			HireDate: HireDate,end_date: end_date,full_name:full_name ,fname:fname,lname:lname,note:note,tz:tz }, function(json){		
	 		  
			if(!parseInt(json.total))  return;
			$('#total').text( parseInt($('#total').text()) + parseInt(json.total) );

			var userID=document.getElementById('Request_Tracking_Number_user').value;
			var forumID_src=document.getElementById('Request_Tracking_Number_forum').value;	
		    var decID= document.getElementById('Request_Tracking_Number_dec').value;		 
			
			
			 	var item = json.list[0];
				var row= preparePastNormalUserStr(item, url);		
                $('tr#user_'+userID+forumID_src+decID).replaceWith(row).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
			}, 'json');
		
	}	 
		
		return false;	
		
}	 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function preparePastNormalUserStr(item,url)//for add user in print _user_forum_history
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
{	
	userID = parseInt(item.userID);
	fname=item.fname;
    lname=item.lname;
    full_name=item.full_name;
    start_date=item.start_date;
    end_date=item.end_date;
    forum_decID=item.forum_decID;
    forum_decName=item.forum_decName;
    level=item.level;
    var row='';
    var link='../admin/find3.php?userID='+userID+''; 
    var link_frm='../admin/find3.php?forum_decID='+forum_decID+''; 
   var tmp= start_date.toString("l M Y\n"); // "April 12th, 2008" 
   

    start_date_tmp=start_date.split('-');
    var year=    start_date_tmp[0];
    var month=    start_date_tmp[1];
    var day=    start_date_tmp[2];
    var y2k = new Date(year,month, day);
    start_date=y2k.toLocaleString();
    
    
    end_date_tmp=end_date.split('-');
    var year=    end_date_tmp[0];
    var month=    end_date_tmp[1];
    var day=    end_date_tmp[2];
    var y2k = new Date(year,month, day);
    end_date=y2k.toLocaleString();
    
    start_date=start_date.substr( 0,27);     
    end_date=end_date.substr(0,22);     
    
    
    
    
    
    
    
    
    
    
	row+='<tr class="even highlight" id="user_'+userID+forum_decID+'" >'+
	
	  '<td>'+
       '<input class="mybutton" id="btnDeleteUserfrm'+userID+forum_decID+'" value="מחק משתמש" onclick="return del_user_frm('+userID+','+forum_decID+',\''+url+'\' )"  type="button">'+
	  '</td>'+
	
	
	
	
	
	
	
 '<td id="usrFrm_key'+userID+forum_decID+'">'+
	'<span>'+
	'<a href="#"  onClick="return editPastUser ('+userID+','+forum_decID+',\''+url+'\' ); return false;" >'+
             '<b style="color:blue;">'+userID+'</b>'+
         '</a>'+
	'</span>'+
  '</td>'+				

	
	  
	  
	  '<td>'+ 
	  '<a href="#" onclick="return editUser4('+userID+',\''+url+'\' )" >'+
      
          '<b>'+fname+'</b>'+
      '</a>'+  
    '</td>'+

	  
	  
	  
	  '<td>'+
	   	       '<b>'+lname+'</b'+
	  '</td>'+
	
	
	  
	  '<td>'+ 
	  '<a href="javascript:void(0)"  onClick="return openmypage3(\''+link+'\' );this.blur();return false;" >'+
          '<b>'+full_name+'</b>'+
      '</a>'+  
      '</td>'+

      
	  
       '<td>'+
          '<b>'+forum_decID+'</b>'+
       '</td>'+
	  
	

      '<td>'+
      '<a href="javascript:void(0)"  onClick="return openmypage3(\''+link_frm+'\' );this.blur();return false;" >'+
      '<b>'+forum_decName+'</b>'+
     '</a>'+ 
       '</td>'+	       
//       dateFormat(fullDate); 
'<td><b>'+start_date+' </b></td>'+       
'<td><b>'+end_date+'</b></td>';

	  
	 if(level=='admin'){  
	 row+= '<td class="error"><b style="color:red;">'+level+'</b></td>';
	 }else{ 
		  row+='<td><b>'+level+'<span></b>';
	 }	  
	  
	 row+='<td>'+
	'</td>'+
	  
	"</tr>\n";
return row;		
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareDecUserStr(item,url)//for add user in print _user_forum_history
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
{
var row='';	
var userID = parseInt(item.userID);
var forum_decID=item.forum_decID;
var decID=item.decID;
var fname=item.fname;
var lname=item.lname;
var full_name=item.full_name;
var start_date=item.HireDate;
var end_date=item.end_date;
var forum_decName=item.forum_decName;
var decName=item.decName;
var level=item.level;
var row='';
var link='../admin/find3.php?userID='+userID+''; 
var link_frm='../admin/find3.php?forum_decID='+forum_decID+'';


var link_dec='../admin/find3.php?decID='+decID+'';
var tmp= start_date.toString("l M Y\n"); // "April 12th, 2008" 


var start_date_tmp=start_date.split('-');
var year=    start_date_tmp[0];
var month=    start_date_tmp[1];
var day=    start_date_tmp[2];
var y2k = new Date(year,month, day);
start_date=y2k.toLocaleString();


var end_date_tmp=end_date.split('-');
var year=    end_date_tmp[0];
var month=    end_date_tmp[1];
var day=    end_date_tmp[2];
var y2k = new Date(year,month, day);
end_date=y2k.toLocaleString();

start_date=start_date.substr( 0,27);     
end_date=end_date.substr(0,22);     











row+='<tr class="even highlight" id="user_'+userID+forum_decID+decID+'" >'+
//row+='<tr class="even highlight" id="user_'+userID+forum_decID+'" >'+
'<td>'+
'<input class="mybutton" id="btnDeleteUserfrm'+userID+forum_decID+'" value="מחק משתמש" onclick="return del_user_frm('+userID+','+forum_decID+','+decID+',\''+url+'\' )"  type="button">'+
'</td>'+







'<td id="usrFrm_key'+userID+forum_decID+decID+'">'+
'<span>'+
'<a href="#"  onClick="return editUserDec_frm ('+userID+','+forum_decID+','+decID+',\''+url+'\' ); return false;" >'+
'<b style="color:blue;">'+userID+'</b>'+
'</a>'+
'</span>'+
'</td>'+				




'<td>'+ 
'<a href="#" onclick="return editUser4('+userID+',\''+url+'\' )" >'+

'<b>'+fname+'</b>'+
'</a>'+  
'</td>'+




'<td>'+
'<b>'+lname+'</b'+
'</td>'+



'<td>'+ 
'<a href="javascript:void(0)"  onClick="return openmypage3(\''+link+'\' );this.blur();return false;" >'+
'<b>'+full_name+'</b>'+
'</a>'+  
'</td>'+

//DECISIONS

'<td id="decName'+userID+forum_decID+decID+'">'+
  '<a href="javascript:void(0)"  onClick="return openmypage3(\''+link_dec+'\' );this.blur();return false;" >'+
    '<b>'+decName+'</b>'+
  '</a>'+  
'</td>'+



//FORUM_DEC



'<td>'+
  '<b>'+forum_decID+'</b>'+
'</td>'+



'<td id="frmName'+userID+forum_decID+decID+'">'+
  '<a href="javascript:void(0)"  onClick="return openmypage3(\''+link_frm+'\' );this.blur();return false;" >'+
   '<b>'+forum_decName+'</b>'+
  '</a>'+ 
'</td>'+	 




'<td><b>'+start_date+' </b></td>'+       
'<td><b>'+end_date+'</b></td>';


if(level=='admin'){  
row+= '<td id="my_level_td'+userID+forum_decID+decID+'" class="error"><b style="color:red;">'+level+'</b></td>';
}else{ 
row+='<td><b>'+level+'<span></b>';
}	  

row+='<td>'+
'</td>'+

"</tr>\n";

return row;	



}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareDecUserStr(item,url)//for add user in print _user_forum_history
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
{	
	userID = parseInt(item.userID);
	fname=item.fname;
    lname=item.lname;
    full_name=item.full_name;
    start_date=item.HireDate;
    end_date=item.end_date;
    forum_decID=item.forum_decID;
    decID=item.decID;
    forum_decName=item.forum_decName;
    decName=item.decName;
    level=item.level;
    
    var row='';
    var url='../admin/';
    var link='../admin/find3.php?userID='+userID+''; 
    var link_frm='../admin/find3.php?forum_decID='+forum_decID+'';
    var link_dec='../admin/find3.php?decID='+decID+'';
   var tmp= start_date.toString("l M Y\n"); // "April 12th, 2008" 
   

    start_date_tmp=start_date.split('-');
    var year=    start_date_tmp[0];
    var month=    start_date_tmp[1];
    var day=    start_date_tmp[2];
    var y2k = new Date(year,month, day);
    start_date=y2k.toLocaleString();
    
    
    end_date_tmp=end_date.split('-');
    var year=    end_date_tmp[0];
    var month=    end_date_tmp[1];
    var day=    end_date_tmp[2];
    var y2k = new Date(year,month, day);
    end_date=y2k.toLocaleString();
    
    start_date=start_date.substr( 0,27);     
    end_date=end_date.substr(0,22);     
    
    
    
    
    
    
    
    
    
    
	row+='<tr class="even highlight" id="user_'+userID+forum_decID+decID+'" >'+
	
  '<td>'+
    '<input class="mybutton" id="btnDeleteUserfrm'+userID+forum_decID+decID+'" value="מחק משתמש" onclick="return del_Decuser_frm('+userID+','+forum_decID+','+decID+',\''+url+'\' )"  type="button">'+
  '</td>'+
	
	
	
	
	
	
	
 '<td id="usrFrm_key'+userID+forum_decID+decID+'">'+
	'<span>'+
	'<a href="#"  onClick="return editUserDec_frm ('+userID+','+forum_decID+','+decID+',\''+url+'\' ); return false;" >'+
             '<b style="color:blue;">'+userID+'</b>'+
         '</a>'+
	'</span>'+
  '</td>'+				

	
	  
	  
	  '<td>'+ 
	  '<a href="#" onclick="return editUser4('+userID+',\''+url+'\' )" >'+
      
          '<b>'+fname+'</b>'+
      '</a>'+  
    '</td>'+

	  
	  
	  
	  '<td>'+
	   	       '<b>'+lname+'</b'+
	  '</td>'+
	
	
	  
	  '<td>'+ 
	  '<a href="javascript:void(0)"  onClick="return openmypage3(\''+link+'\' );this.blur();return false;" >'+
          '<b>'+full_name+'</b>'+
      '</a>'+  
      '</td>'+

       
      
      '<td>'+
        '<b>'+decID+'</b>'+
     '</td>'+
  


  '<td>'+
    '<a href="javascript:void(0)"  onClick="return openmypage3(\''+link_dec+'\' );this.blur();return false;" >'+
       '<b>'+decName+'</b>'+
     '</a>'+ 
   '</td>'+	 

      
	  
   '<td>'+
      '<b>'+forum_decID+'</b>'+
   '</td>'+
	  
	

    '<td>'+
      '<a href="javascript:void(0)"  onClick="return openmypage3(\''+link_frm+'\' );this.blur();return false;" >'+
      '<b>'+forum_decName+'</b>'+
     '</a>'+ 
    '</td>'+	 
      
//       dateFormat(fullDate); 
	

'<td><b>'+start_date+' </b></td>'+       
'<td><b>'+end_date+'</b></td>';

	  
	 if(level=='admin'){  
	 row+= '<td class="error"><b style="color:red;">'+level+'</b></td>';
	 }else{ 
		  row+='<td><b>'+level+'<span></b>';
	 }	  
	  
	 row+='<td>'+
	'</td>'+
	  
	"</tr>\n";
 
return row;	

	
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function pre_submitUser(form,url)
{
	
	$.ajax({//for loading img  
		type: "GET",
		url: "dynamic_10.php",
		data: "",
		success: function(msg){
		
		}
});	
	
	document.getElementById('full_name').value ='';
	document.getElementById('fname').value ='';
	document.getElementById('lname').value ='';
	  document.getElementById('level').value ='';
	  document.getElementById('upass').value ='';
	  document.getElementById('user').value ='';
	  
	  document.getElementById('note').value ='';
	  document.getElementById('email').value ='';
	  document.getElementById('phone').value ='';
	  
	  document.getElementById('active').value ='';
	  
	  document.getElementById('duedate4').value ='';
	$('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	w = $('#page_useredit');
	
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
	//w.fadeIn('fast').show();
     w.fadeIn('fast')
 	// .css('position','relative')
 	.css('background','#DC5035') 
 	
 	 .css({'z-iindex': '201'}) 
 	
 	 .css({'padding':'12px'})
 	.css({'left':'200px'})
 	.css({'overflow':'hidden'})
 	.css({'top':'-550px'}) 
 	.css({'bottom':'500px'})
 
 	.css({'float':'left'})			
 	.css({'width':'510px'})
 	.css({'border':'3px solid #666'})
 	
 	.show();
	
	
	$('#page_useredit').draggable();
	
	$(document).bind('keydown', cancelEdit2);
	return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function deleteUser(id,url)
{
	 var forum_decID = document.getElementById('forum_decID').value;
	 // alert(forum_decID);
	if(!confirm("האים אתה בטוח?")) {
		return false;
	}
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	$.getJSON(url+'ajax.php?deleteUser='+id+'&forum_decID='+forum_decID+nocache, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		$('#total1').text( parseInt($('#total1').text()) - 1 );
		var item = json.list[0];
		 //alert(item.id);
		userOrder.splice($.inArray(id,userOrder), 1);
		
		$('#userrow_'+item.id).fadeOut('normal', function(){ $(this).remove(); });
		if(!userList[id].compl && changeUserCnt(userList[id].dueClass, -1)) refreshUserCnt();
		delete userList[id];

	});
	flag.tagsuserChanged = true;
	return false;
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editUser2 (id,decID,forum_decID,url,mgr_userID)
{
 
  document.forms['edituser'+decID+forum_decID].elements['Request_Tracking_Number1'].value=id;
/***********************************************************/
 
 	tz = -1 * (new Date()).getTimezoneOffset();
 	setAjaxErrorTrigger2(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	
 
//	var item = userList[userID];
//    
//	if(!item) { return false;}
	 
//	  document.getElementById('full_name'+decID+forum_decID).value ='';
//	  document.getElementById('level'+decID+forum_decID).value ='';
//	  document.getElementById('upass'+decID+forum_decID).value ='';
//	  document.getElementById('user'+decID+forum_decID).value ='';
//	  document.getElementById('prio'+decID+forum_decID).value ='';
//	  document.getElementById('note'+decID+forum_decID).value ='';
//	  document.getElementById('email'+decID+forum_decID).value ='';
//	  document.getElementById('phone'+decID+forum_decID).value ='';
//	  
//	 
//	  document.getElementById('edittags1'+decID+forum_decID).value =  '';
//	  document.getElementById('duedate3'+decID+forum_decID).value ='';
	
/**********************************************************/	

	
	 document.getElementById('Request_Tracking_Number1').value=id;
  
	$.getJSON(url+'ajax2.php?pre_editUser&userID='+id+'&decID='+decID+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
		
	  resetAjaxErrorTrigger();
		 
		 
		
		 
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
			
		 
		 if(item.level=='user')
			item.level=1;
		 if(item.level=='admin')
		      item.level=2;
		 if(item.level=='suppervizer')
		      item.level=3;
	
	
   		  
		 
		  document.getElementById('full_name'+decID+forum_decID).value =(item.full_name);
		  document.getElementById('level'+decID+forum_decID).value =(item.level);
		  document.getElementById('upass'+decID+forum_decID).value =(item.upass);
		  document.getElementById('user'+decID+forum_decID).value =(item.uname);
 		
		  //document.getElementById('prio'+decID+forum_decID).value =(item.prio);
		  document.forms['edituser'+decID+forum_decID].elements['prio'+decID+forum_decID].value=(item.prio);
 		  
 		  //document.getElementById('note'+decID+forum_decID).value =(item.note);
 		  document.forms['edituser'+decID+forum_decID].elements['note'+decID+forum_decID].value=(item.noteText);
 		  
 		  
 		  document.getElementById('email'+decID+forum_decID).value =(item.email);
 		  document.getElementById('phone'+decID+forum_decID).value =(item.phone_num);
 		  
 		 // document.getElementById('active').value =(item.active);
    	  document.getElementById('edittags1'+decID+forum_decID).value =  dehtml(item.tags.split(',').join(', '));
 		 
    	  document.getElementById('duedate_1'+forum_decID).value =(item.HireDate);
    	  document.getElementById('duedate2'+decID+forum_decID).value =(item.duedate);
 
		});
			
});
	loadTasks2(url,forum_decID,decID);	
	

/*********************************************************/	
	 $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	  w = $('#page_useredit'+decID+forum_decID);
	 
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
 	  

      .css({'top':'-400px'}) 
  
      .css({'float':'left'})			
    .css({'width':'510px'})
 	.css({'border':'3px solid #666'}).draggable()
 	
	.show();	
	
/******************************************************/	
	$(document).bind('keydown', cancelEdit2);
	return false;
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function saveUser2(form,url,decID,forum_decID,mgr_userID,mgr)
{ 
	  
	
	 
	 var ID=document.getElementById('Request_Tracking_Number1').value; 
 	
  
 	//if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
 
 	
 	
    
 	
 	
 	//setAjaxErrorTrigger(url);
 
// 	    var upass=$('#upass').val() ;
//		var full_name=$('#full_name').val();
	//var uname=$('#user').val();	
 	
 	
       
 	
 	    var upass = document.getElementById('upass'+decID+forum_decID).value;
		var full_name = document.getElementById('full_name'+decID+forum_decID).value;
		 
     
		 
		 
		 
		var email = document.getElementById('email'+decID+forum_decID).value;	
		var prio =document.forms['edituser'+decID+forum_decID].elements['prio'+decID+forum_decID].value
		
		 
		//var active = document.getElementById('active').value;
		var phone = document.getElementById('phone'+decID+forum_decID).value;
	    
		var level = document.getElementById('level'+decID+forum_decID).value;
		var uname = document.getElementById('user'+decID+forum_decID).value;
	//	var note = document.getElementById('note'+decID+forum_decID).value;
		var HireDate= document.getElementById('duedate_1'+forum_decID).value;
		var duedate= document.getElementById('duedate2'+decID+forum_decID).value;
		
	//	var tags= document.getElementById('edittags1'+decID+forum_decID).value; //problem with the form =>use document.forms['edituser'+decID+forum_decID].elements[
 
	
	//if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
	//setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
 
	
	$.post(url+'ajax2.php?editUser='+form.Request_Tracking_Number1.value+nocache,{ 
		full_name:full_name,    uname:uname,     note:document.forms['edituser'+decID+forum_decID].elements['note'+decID+forum_decID].value, 
	    prio:prio,tags:document.forms['edituser'+decID+forum_decID].elements['tags'+decID+forum_decID].value, duedate:duedate,
	    HireDate:HireDate, upass:upass,phone:phone, level:level,email:email ,   forum_decID:forum_decID,   decID:decID  }, 	   
	function(json){
//////////////////////////////////
		var item = json.list[0];//
//////////////////////////////////	
			
		if(item.note == '') {
			 
			$('#user_'+item.userID+'>div.task-note-block').addClass('hidden');
		}else{
			 
			$('#user_'+item.userID+'>div.task-note-block').removeClass('hidden');
		}			
			
			
			
	    	$('#user_'+item.userID).effect("highlight", {color:theme.editTaskFlashColor}, 'normal'); 	
	    	
	    	canceluserEdit5(decID,forum_decID);   
	//	resetAjaxErrorTrigger();
		if(!parseInt(json.total)){alert("טעות"); return;}
		var item = json.list[0];
		 loadUsers2(url,forum_decID,decID,mgr_userID,mgr );
    }, 'json');//end post
	 $("#edittags1"+decID+forum_decID).flushCache();
		
	flag.tagsuserChanged = true;
	
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editUser_frmID (id,forum_decID,url,num)
{ 
/***********************************************************/
	
	tz = -1 * (new Date()).getTimezoneOffset();
 //	setAjaxErrorTrigger2(url);
	
	
	nocache = '&rnd='+Math.random();
	

	
/**********************************************************/	
	
	document.getElementById('Request_Tracking_Number1').value=id;
	document.getElementById('Request_Tracking_Number2').value=forum_decID;
     document.getElementById('Request_Tracking_Number_1').value=num;
	$.getJSON(url+'ajax2.php?pre_editUser&userID='+id+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
		
	 // resetAjaxErrorTrigger();
		 
		 if (json.total==0){return;}
		
		 
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
			
		 	 
		 if(item.level=='user')
			item.level=1;
		 if(item.level=='admin')
		      item.level=2;
		 if(item.level=='suppervizer')
		      item.level=3;
	
		 
		  document.getElementById('full_name'+forum_decID).value =(item.full_name);
		  document.getElementById('level'+forum_decID).value =(item.level);
		  document.getElementById('upass'+forum_decID).value =(item.upass);
		  document.getElementById('user'+forum_decID).value =(item.uname);
 		  document.getElementById('prio'+forum_decID).value =(item.prio);
 		  document.getElementById('note'+forum_decID).value =(item.noteText);
 		 document.getElementById('active'+forum_decID).value =(item.active);
 		 
 		  document.getElementById('email'+forum_decID).value =(item.email);
 		  document.getElementById('phone'+forum_decID).value =(item.phone_num);
 		  
// 		  document.getElementById('active'+forum_decID).value =(item.active);
    	  document.getElementById('edittags1'+forum_decID).value =  dehtml(item.tags.split(',').join(', '));
 		  document.getElementById('duedate3'+forum_decID).value =(item.HireDate);
 
		});
		
});
 
	
	$('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	w = $('#page_useredit'+forum_decID);
	
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
    //.css('position','absolute') 
	.css('background','#458AF5') 
	.css('overflow','hidden') 
	 .css({'z-iindex': '2002'}) 
	
	.css({'padding':'8px'})
	.css({'left':'200px'})
	
 	 .css({'top':'-550px'}) 
 	.css({'bottom':'700px'})
	
	 .css({'float':'left'})			
	.css({'width':'510px'})
	.css({'border':'3px solid #666'})
	
	.show();
	
	

	$('#my_button_usrDetails'+forum_decID).css('border','3px solid red')
	var link_usr= '../admin/find3.php?&userID='+id ;
	   var usr_row='<input type="button"  id="my_button_usrDetails'+forum_decID+'"  onClick="return openmypage3(\''+link_usr+'\' );this.blur();return false;"   value="נתונים מורחבים על החבר" class="href_modal1" />';
	   $('#my_button_usrDetails'+forum_decID).replaceWith(usr_row);  
	
	$(document).bind('keydown', cancelEdit2);
	return false;
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function saveUser4forum(form,url,forum_decID)
{ 
	 
	 var forum_decID = document.getElementById('Request_Tracking_Number2').value;
	 
	 var ID=document.getElementById('Request_Tracking_Number1').value; 
	  var num=document.getElementById('Request_Tracking_Number_1').value; 
	  num=parseInt(num);  
  
       	
 	
 	    var upass = document.getElementById('upass'+forum_decID).value;
		var full_name = document.getElementById('full_name'+forum_decID).value;
		 
     
		 
		 
		 
		var email = document.getElementById('email'+forum_decID).value;	
		var prio = document.getElementById('prio'+forum_decID).value;
		 
 		var active = document.getElementById('active'+forum_decID).value;
		var phone = document.getElementById('phone'+forum_decID).value;
	    
		var level = document.getElementById('level'+forum_decID).value;
		var uname = document.getElementById('user'+forum_decID).value;
		var note = document.getElementById('note'+forum_decID).value;
	    var HireDate= document.getElementById('duedate3'+forum_decID).value;
        var duedate= document.getElementById('duedate3'+forum_decID).value;
	 //   var duedate= $('.duedate3').value;
		var tags= document.getElementById('edittags1'+forum_decID).value; 
 
	
	nocache = '&rnd='+Math.random();
	 
	
	
	$.post(url+'ajax2.php?editUser='+ID+nocache,{ 
		full_name:full_name,    uname:uname,     note:note, 
	    prio:prio,              tags:tags,      HireDate:HireDate,duedate:duedate,
		upass:upass,            phone:phone,    active:active,
		level:level,            email:email ,   forum_decID:forum_decID   }, 	   
    	function(json){
		 
		canceluserEdit6(forum_decID);   

		if(!parseInt(json.total)){alert("NO_JSON"); return;}
		var item = json.list[0];
		
	
    }, 'json');//end post	
	document.getElementById('member_date'+num).value=HireDate;
	flag.tagsuserChanged = true;
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editUser3 (id,forum_decID,url,num)
{ 
/***********************************************************/
	
	tz = -1 * (new Date()).getTimezoneOffset();
 //	setAjaxErrorTrigger2(url);
	if(filter.search) search = '&s='+encodeURIComponent(filter.search); else search = '';
	if(filter.tag) tag = '&t='+encodeURIComponent(filter.tag); else tag = '';
	nocache = '&rnd='+Math.random();
	

	
/**********************************************************/	
	
	document.getElementById('Request_Tracking_Number1').value=id;
	document.getElementById('Request_Tracking_Number2').value=forum_decID;
     document.getElementById('Request_Tracking_Number_1').value=num;
	$.getJSON(url+'ajax2.php?pre_editUser&userID='+id+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
		
	 // resetAjaxErrorTrigger();
		 
		 if (json.total==0){return;}
		
		 
//////////////////////////////////////////////////////////////////////////////////////////////		
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////////////////////////////////////////////////
          
		       
		 if(item.level=='user')
			item.level=1;
		 if(item.level=='admin')
		      item.level=2;
		 if(item.level=='suppervizer')
		      item.level=3;
	
	           	         
//		'<div class="task-actions_b">'+		
//		'<a href="#" onClick="return deleteTask('+id+',\''+url+'\')">'+
//			   '<img src="'+img.del[0]+'" onMouseOver="this.src=img.del[1]" onMouseOut="this.src=img.del[0]" title="מחיקה">'+
//			 '</a>'+
//			
//		'</div>';
		
		
		
		
		
		
		
		  document.getElementById('full_name').value =(item.full_name);
		  document.getElementById('level').value =(item.level);
		  document.getElementById('upass').value =(item.upass);
		  document.getElementById('user').value =(item.uname);
 		  document.getElementById('prio').value =(item.prio);
 		  document.getElementById('note').value =(item.noteText);
 		 
 		 
 		  document.getElementById('email').value =(item.email);
 		  document.getElementById('phone').value =(item.phone_num);
 		  
 		  document.getElementById('active').value =(item.active);
    	  document.getElementById('edittags1').value =  dehtml(item.tags.split(',').join(', '));
 		  document.getElementById('duedate3').value =(item.HireDate);
 
		});
		

		
});
 
	
	$('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
	w = $('#page_useredit');
	
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
//  .css('position','absolute') 
	.css('background','#458AF5') 
	.css('overflow','hidden') 
	 .css("zIndex", 2001)
	
	.css({'padding':'8px'})
	 .css({'margin-left':'-370px'})
	
 //	  .css({'top':'-1350px'})//upper	 
 .css({'top':'-700px'})
	
	 .css({'float':'left'})			
	.css({'width':'560px'})
	.css({'border':'3px solid #666'})
	
	.show();
	

	
	var link_usr= '../admin/find3.php?&userID='+id ;
	   var usr_row='<input type="button" style="background:#B4D9D7" id="my_button_usrDetails'+forum_decID+'"  onClick="return openmypage3(\''+link_usr+'\' );this.blur();return false;"   value="נתונים מורחבים על החבר" class="href_modal1" />';
	   $('#my_button_usrDetails').replaceWith(usr_row).css({'background':'#B4D9D7'});  
	
/***************************************************************************************************/
      
	
	
	$(document).bind('keydown', cancelEdit2);
	
	
	
//	$('#my_button_usrDetails').css({'background':'#B4D9D7'}).bind('click', function() {
//
//        var link= '../admin/find3.php?&userID='+id ;
//         openmypage3(link); 
//        
//          return false;
//       });
	
	
	
	return false;
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function saveUser3(form,url)
{ 
	
	//var forum_decID = document.getElementById('forum_decID').value;
	var forum_decID=document.getElementById('Request_Tracking_Number2').value; 
	
	
	
	 var ID=document.getElementById('Request_Tracking_Number1').value; 
	  var num=document.getElementById('Request_Tracking_Number_1').value; 
	  num=parseInt(num);  
  
 	
       	
 	
 	    var upass = document.getElementById('upass').value;
		var full_name = document.getElementById('full_name').value;
	 	var email = document.getElementById('email').value;	
		var prio = document.getElementById('prio').value;
		 
		var active = document.getElementById('active').value;
		var phone = document.getElementById('phone').value;
	    
		var level = document.getElementById('level').value;
		var uname = document.getElementById('user').value;
		var note = document.getElementById('note').value;
		
		
		 


		
		
		
	    var HireDate= document.getElementById('duedate3').value;
		var duedate= document.getElementById('duedate3').value;
		var tags= document.getElementById('edittags1').value; 
 
 
	//if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
	 setAjaxErrorTrigger2(url);
	nocache = '&rnd='+Math.random();
	 $.post(url+'ajax2.php?editUser='+ID+nocache,{
	// $.post('../admin/ajax2.php?editUser='+ID+nocache,{ 
    	full_name:full_name,    uname:uname,     note:note, 
	    prio:prio,              tags:tags,      HireDate:HireDate,duedate:duedate,
		upass:upass,            phone:phone,    active:active,
		level:level,            email:email ,   forum_decID:forum_decID   }, 	   
    	function(json){
	 var x=1;
	 	canceluserEdit3();   
	    //resetAjaxErrorTrigger();
		if(!parseInt(json.total)){alert("NO_JSON"); return;}
		var item = json.list[0];
		
		 $('#dateID').val(item.HireDate);
		 
    }, 'json');//end post	
	if(HireDate && !(HireDate==undefined))
 	$('#member_date'+num).val(HireDate);
	flag.tagsuserChanged = true;
 	return false;

 

/*	
 nocache = '&rnd='+Math.random();
		 $.ajax({
             type: 'POST',
             data: {full_name:full_name,    uname:uname,     note:note, 
			    prio:prio,              tags:tags,      HireDate:HireDate,duedate:duedate,
				upass:upass,            phone:phone,    active:active,
				level:level,            email:email ,   forum_decID:forum_decID }, 
           
            url: url+'ajax2.php?editUser='+ID+nocache, 
             dataType: 'json',
             //async: false,
            
             success: function(json){
					canceluserEdit3();   
				   
					if(!parseInt(json.total)){alert("NO_JSON"); return;}
					var item = json.list[0];
					
					 $('#dateID').val(item.HireDate);	    
                                             
             }
  });	
	 
			 flag.tagsuserChanged = true; 
	return false;	
		
*/		
		

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function stripHTML(){
	var re= /<\S[^><]*>/g;
	for (i=0; i<arguments.length; i++)
	arguments[i].value=arguments[i].value.replace(re, "")
	}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function saveUser4(form,url,forum_decID)
{ 
	 
	 var forum_decID = document.getElementById('Request_Tracking_Number2').value;
	 
	 var ID=document.getElementById('Request_Tracking_Number1').value; 
	  var num=document.getElementById('Request_Tracking_Number_1').value; 
	  num=parseInt(num);  
  
 	//if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
 
 	
 	
    
 	
 	
 	//setAjaxErrorTrigger(url);
 
// 	    var upass=$('#upass').val() ;
//		var full_name=$('#full_name').val();
	//var uname=$('#user').val();	
 	
 	
       	
 	
 	    var upass = document.getElementById('upass').value;
		var full_name = document.getElementById('full_name').value;
		 
     
		 
		 
		 
		var email = document.getElementById('email').value;	
		var prio = document.getElementById('prio').value;
		 
		var active = document.getElementById('active').value;
		var phone = document.getElementById('phone').value;
	    
		var level = document.getElementById('level').value;
		var uname = document.getElementById('user').value;
		var note = document.getElementById('note').value;
	    var HireDate= document.getElementById('duedate3').value;
		var duedate= document.getElementById('duedate3').value;
		var tags= document.getElementById('edittags1').value; 
 
	
	//if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
	//setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	 
	
	
	$.post(url+'ajax2.php?editUser='+form.Request_Tracking_Number1.value+nocache,{ 
		full_name:full_name,    uname:uname,     note:note, 
	    prio:prio,              tags:tags,      HireDate:HireDate,duedate:duedate,
		upass:upass,            phone:phone,    active:active,
		level:level,            email:email ,   forum_decID:forum_decID   }, 	   
    	function(json){
		//alert("fffffffff");
		canceluserEdit3();   
	    //resetAjaxErrorTrigger();
		if(!parseInt(json.total)){alert("NO_JSON"); return;}
		var item = json.list[0];
		
		//$('#dateID').val()=item.HireDate;	
    }, 'json');//end post	
	document.getElementById('member_date'+num).value=HireDate;
	//$('form#edittask'+decID+forum_decID).append('<div id="targetDiv"></div>').find('select#userselect'+decID+forum_decID).change(function(){
//$('form#forum').find('input#member_date'+num).replaceWith(HireDate);
//$('#member_date6').css({'border':'3px solid red'});
//$('#member_date'+num).css({'border':'3px solid red'}).val()=HireDate;//replaceWith(HireDate);
		//replaceWith(HireDate);
//$('input#member_date'+num).val()=HireDate;

	flag.tagsuserChanged = true;
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function edit_userForum (id,forum_decID,url,member_date)
{
	nocache = '&rnd='+Math.random();
	var tz = -1 * (new Date()).getTimezoneOffset();
/********************************************************************************************/
/*******************************************************************************************/	

$.getJSON(url+'ajax2.php?pre_editUser&userID='+id+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
//	 taskList = new Array();
/////////////////////////////////////////////////////			
//			$.each(json.list, function(i,item){
////////////////////////////////////////////////////				
//				
//				 
//			tasks += prepareuserTaskStr3(item,url,decID,forum_decID);//function in ajx_multi.php prepareuserTaskStr2 !	prepareUserTaskStr2
//				 
//			
//			taskList[item.taskID] = item;
//
//			});//end each
 	 item =json.list[0];
 		
		$('<div id="user_edit_form" title="ערוך משתמש" dir="rtl">'+
				'<form id="editUser">'+
				'<h3>המנהל:<input id="full_name_usr" name="full_name_usr" type="text" value="' + item.full_name + '" class="mycontrol"></h3>'+
				
				'<h3>שם משתמש:<input id="uname_usr" name="uname_usr" type="text" value="' + item.uname + '" class="mycontrol"></h3>'+	
				
				
				
				'<h3>'+
				'<span class="h">סיסמה:</span>'+
				'<input id="upass_usr" name="upass_usr" type="text" value="' + item.upass + '" class="mycontrol">'+
				'</h3>'+
				
				
				'<h3>'+
				  '<div class="form-row">'+
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    '&nbsp;'+
				  '<span class="h">עדיפות</span>'+ 
				    '<SELECT name="prio" id="prio_usr" class="mycontrol">'+
				      '<option value="3">+3</option>'+
				      '<option value="2">+2</option>'+
				      '<option value="1">+1</option>'+
				      '<option value="0" selected>&plusmn;0</option>'+
				      '<option value="-1">&minus;1</option>'+
				     '</SELECT>'+
				    

				'</div>'+
	             '</h3>'+
	             
	             
	          '<h3>'+
				  '<div class="form-row">'+
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    '&nbsp;'+ 
				    
				    '<span class="h">תאריך השמה בפורום:</span>'+ 
				   '<input name="date2" id="date2" value="' + item.HireDate + '"  class="mycontrol" />'+
				   '</div>'+
				  
				   
				   
		       '</h3>'+
		             
	             
				
	            
	  '<h3>'+
       ' <div class="form-row">'+  
       '&nbsp;'+ 
	    '&nbsp;'+ 
	    '&nbsp;'+
       '<span class="h">תוקף תפקיד:</span>'+
		  '<SELECT name="level_usr"  id="level_usr" class="mycontrol"  >'+
	      ' <option value="0" >חבר פורום </option>'+
	      '<option value="1" >מנהל </option>'+
	      '<option value="2" >מפקח</option>'+
	     '</SELECT> '+
	  '</div>'+ 	  
	  '</h3>'+ 	  
		  
		  
		// '</form> '+
 '<h3>דואר אלקטרוני:<input id="email_usr"      name="email_usr"     type="text" value="' + item.email + '"      class="mycontrol"></h3>'+	
         '<h3>טלפון:<input id="phone_num_usr"  name="phone_num_usr" type="text" value="' + item.phone_num + '"  class="mycontrol"></h3>'+
          '<h3>תגית:<input id="tags_usr"       name="tags_usr"      type="text" value="' + item.tags + '"       class="mycontrol"></h3>'+
	
		'הערות<br />'+
		 '<textarea style="width:400px;height:200px" id="note_usr" >'+item.noteText+'</textarea></form></div>').appendTo($('body'));
			
			  	
			 	
			  	if(item.level=='user')
					item.level=1;
				 if(item.level=='admin')
				      item.level=2;
				 if(item.level=='suppervizer')
				      item.level=3;
			  	
				 document.getElementById("level_usr").selectedIndex = item.level; 

				 document.getElementById("prio_usr").value=item.prio;

			
				 
				 
				 
		$("#user_edit_form").dialog({
				 
				
				bgiframe: true,
				autoOpen: false,
				height: 440,
				width: 450,
				modal: true,
			 //	zindex: 1006 ,
				buttons: {

				
				'Save':  function() {
			
 			   var $this=$(this);   
	             full_name=document.getElementById('full_name_usr').value;//$('#full_name').val();
	             uname=$('#uname_usr').val();
	             upass=$('#upass_usr').val();
	             prio=$('#prio_usr').val();
	             
	             duedate=$('#date2').val();
	             HireDate=$('#date2').val();
	             level=$('#level_usr').val();
	             email=$('#email_usr').val();
	             phone=$('#phone_num_usr').val();
	             note=$('#note_usr').val();
	             tags=$('#tags_usr').val();
	            
	             $.ajax({
	                  type: "POST",
	                       url: url+'ajax2.php?editUser='+item.userID,
	                       dataType: 'json',
	                       data: {
	            	        full_name:full_name,    uname:uname,     note:note, 
	              	        prio:prio,              tags:tags,      duedate:duedate,
	              		    upass:upass,            phone:phone,    HireDate:HireDate, 
	              		    level:level,            email:email ,   forum_decID:forum_decID
	                       },
	                       success: function(json) {
	                             
	                       
	                       $this.dialog('close');
	                      
/******************************************************************************************/
 
/****************************************************************************************/                        
                   }//end success
	                
	              });//end ajx
			 
	     },//end function save 
	    
				
					Cancel: function() {
						$(this).dialog('close');
						$("#user_edit_form").remove();
						 
					} 
				
	/***************************************************************************************/		

	/******************************************************************************************/		
			
			},//end button

		     
				close: function() {
				 
				 
				$("#user_edit_form").remove();
			 
				}
				 
			});//end dialog
			
			$("#user_edit_form").dialog('open');
 
			 

			 
				
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
				
		    $("#date1").datepicker({ firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
		    $("#date2").datepicker({ firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
		    $("#tags").autocomplete('/alon-web/olive_prj/admin/ajax2.php?suggestuserTags', {scroll: false, multiple: true, selectFirst:false, max:8});
/*********************************************************************************************************/			
		});//end get_json
	
/******************************************************************************************/

	return false;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cancelusertaskEdit_b(e)
{
 
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelusertaskEdit_b);
	$('#page_usertaskedit_b').hide();
	$('#overlay').remove();
  
	return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function saveUsertask(form,url)
{
	 var forum_decID = document.getElementById('forum_decID').value;
 
	if(flag.needAuth && !flag.isLogged && flag.canAllRead) return false;
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
	
 
				$.post(url+'ajax.php?editUsertask='+form.id.value+nocache, { title: form.task.value,userselect:form.userselect.value,
					userselect1:form.userselect1.value, note:form.note.value, prio:form.prio.value, tags:form.tags.value, 
					duedate:form.duedate.value, forum_decID:forum_decID  }, function(json){
					resetAjaxErrorTrigger();
					if(!parseInt(json.total)) return;
					var item = json.list[0];
					if(!taskList[item.taskID].compl) changeTaskCnt(taskList[item.taskID].dueClass, -1);
					taskList[item.taskID] = item;
					$('#userrow_'+item.taskID).replaceWith(prepareTaskStr(item, url));
					 
					if(sortBy != 0) changeTaskOrder(url);
					cancelEdit();
					if(!taskList[item.taskID].compl) {
						changeTaskCnt(item.dueClass, 1);
						refreshTaskCnt();
					}
					$('#userrow_'+item.taskID).effect("highlight", {color:theme.editTaskFlashColor}, 'normal');
				}  , 'json');
				$("#edittags").flushCache();
				flag.tagsChanged = true;
				return false;
//	}else{
		 // alert(url);	
	//alert('ddddddd');
		tz = -1 * (new Date()).getTimezoneOffset();
		setAjaxErrorTrigger(url);
		 
		nocache = '&rnd='+Math.random();
		$.getJSON(url+'ajax.php?loadtaskusers&compl='+filter.compl+'&sort='+sortBy+search+tag+'&tz='+tz+nocache, function(json){
			resetAjaxErrorTrigger();
			$('#total').html(json.total);
			//userList = new Array();
			usertaskList = new Array();
			usertaskOrder = new Array();
			taskCnt.past = taskCnt.today = taskCnt.soon = 0;
			taskCnt.total = json.total;
			 
			var tasks = '';
			$.each(json.list, function(i,item){
	            
				tasks += prepareuserTaskStr(item,url);
				taskList[item.taskID] = item;
				taskOrder.push(parseInt(item.taskID));
				if(!item.compl) changeTaskCnt(item.dueClass);
			});
			refreshTaskCnt();
			$('#tasklist').html(tasks);
			if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
			else showhide($('#compl_show'),$('#compl_hide'));
			if(json.denied) errorDenied();
		});
		
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editfind2user(id)
{
	
	var item = id; 
 
	if(!item) return false;
 
 
	document.edittask_find.usertaskfind.value = dehtml(item.title);	
	 	 
	document.edittask_find.duedate.value = item.duedate;
	
	
	sel = document.edittask_find.prio;
	
	for(i=0; i<sel.length; i++) {
		if(sel.options[i].value == item.prio) sel.options[i].selected = true;
	}
	
	
	sel1 = document.edittask_find.userselect;
	
	for(i=0; i<sel1.length; i++) {
		if(sel1.options[i].value == item.userID){
			sel1.options[i].selected = true;
			//alert(sel1.options[i].value);
		}
	}
	
	
	
   sel2 = document.edittask_find.userselect1;
	
	for(i=0; i<sel2.length; i++) {
		if(sel2.options[i].value == item.dest_userID){
			sel2.options[i].selected = true;
			//alert(sel2.options[i].value);
		}
	}
	
	
	
 
 return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function edituserFormResize(startstop, event)
{
	f = $('#page_useredit');
	if(startstop == 1) {
		tmp.editformdiff = f.height() - $('#page_useredit textarea').height();
	}
	else if(startstop == 2) {
		//to avoid bug http://dev.jqueryui.com/ticket/3628
		if(f.is('.ui-draggable')) {
			f.css('left',tmp.editformpos[0]).css('top',tmp.editformpos[1]).css('position', 'fixed');
		}
	}
	else  $('#page_usertaedit textarea').height(f.height() - tmp.editformdiff);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editusertaskFormResize(startstop, event)
{
	f = $('#page_usertaskedit');
	
 
	if(startstop == 1) {
		tmp.editformdiff = f.height() - $('#page_usertaskedit textarea').height();
	}
	else if(startstop == 2) {
		//to avoid bug http://dev.jqueryui.com/ticket/3628
		if(f.is('.ui-draggable')) {
			f.css('left',tmp.editformpos[0]).css('top',tmp.editformpos[1]).css('position', 'fixed');
		}
	}
	else { $('#page_usertaskedit textarea').height(f.height() - tmp.editformdiff);}
	
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function editusertaskFormResize_b(startstop, event)
{
	f = $('#page_usertaskedit_b');
	
 
	if(startstop == 1) {
		tmp.editformdiff = f.height() - $('#page_usertaskedit_b textarea').height();
	}
	else if(startstop == 2) {
		//to avoid bug http://dev.jqueryui.com/ticket/3628
		if(f.is('.ui-draggable')) {
			f.css('left',tmp.editformpos[0]).css('top',tmp.editformpos[1]).css('position', 'fixed');
		}
	}
	else { $('#page_usertaskedit_b textarea').height(f.height() - tmp.editformdiff);}
	
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function completeUser2(id,ch,url,decID,forum_decID)
{
	//alert(id);
	compl = 0;
	if(ch.checked) compl = 1;
	setAjaxErrorTrigger(url);
	$.getJSON(url+'ajax2.php?completeUser2='+id+'&compl='+compl+'&decID='+compl+'&forum_decID='+forum_decID+nocache, function(json){
		resetAjaxErrorTrigger();
		if(!parseInt(json.total)) return;
		var item = json.list[0];
		
		if(item.compl){ 
		   $('#userrow_'+id).addClass('task-completed');
		}else{
		  $('#userrow_'+id).removeClass('task-completed');
		}	
	
		if(changeUserCnt(userList[id].dueClass, item.compl?-1:1))  refreshUserCnt2(decID,forum_decID);
		 
		
		if(item.compl && !filter.compl) {
			delete userList[id];
			userOrder.splice($.inArray(id,userOrder), 1);
			$('#userrow_'+item.id).fadeOut('normal', function(){ $(this).remove(); });
			$('#total1'+decID+forum_decID).html( parseInt($('#total1'+decID+forum_decID).text())-1 );
		}
	});
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function setUserview2(v,url,decID,forum_decID,mgr_userID,mgr)
{
	
	if(v == 0)
	{ 
		if(filter.due == '' && filter.compl == 0) return;
		$('#userviewcontainer'+decID+forum_decID+'  .btnstr').text($('#view_users'+decID+forum_decID).text());//חברי פורום+מנהל
		if(filter.due != '') {
			$('#userlist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 0) $('#total1'+decID+forum_decID).text(userCnt.total);
		}
		if(filter.compl != 0) {
			filter.compl = 0;
			$('#total1'+decID+forum_decID).text('...');
			 
			 loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
		}
	
	}
	
	
	
	
	else if(v == 1)
	{
		if(filter.due == '' && filter.compl == 1) return;
		$('#userviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_compluser'+decID+forum_decID).text());//משתמשים פתוחים וסגורים 
		if(filter.due != '') {
			$('#userlist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 1) $('#total1'+decID+forum_decID).text(userCnt.total);
		
		}
		if(filter.compl != 1) {
			filter.compl = 1;
			$('#total1'+decID+forum_decID).text('...');
			 
			loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
		}
	}
	
	
	

	else if(v == 2)
	{
		if(filter.due == '' && filter.compl == 2) return;
		$('#userviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_compluser1'+decID+forum_decID).text());
		if(filter.due != '') {
			$('#userlist'+decID+forum_decID).removeClass('filter-'+filter.due);
			filter.due = '';
			if(filter.compl == 2) $('#total1'+decID+forum_decID).text(userCnt.total);
		}
		if(filter.compl != 2) {
			filter.compl = 2;
			$('#total1'+decID+forum_decID).text('...');
			loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
		}
	}	
	
	
	
	
	else if(v=='past1' || v=='today1' || v=='soon1')
	{

	
	
	if(filter.due == v) return;
	else if(filter.due != '') {
		$('#userlist'+decID+forum_decID).removeClass('filter-'+filter.due);
	}
	$('#userlist'+decID+forum_decID).addClass('filter-'+v);
	$('#userviewcontainer'+decID+forum_decID+' .btnstr').text($('#view_'+v+decID+forum_decID).text());//on the menu bar
	
	 
	$('#total1'+decID+forum_decID).text(userCnt[v]);
	filter.due = v;
	
	}
	
}
 

/****************************************************************************************/

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function showUserview2(el,url,decID,forum_decID,mgr_userID,mgr)
{
    	
//	$('#userview'+decID+forum_decID+':li').css("border", "3px solid red").hover(function() {
//
//		 $(this).addClass('containerHover','taskview');
//		      
//		});	
	
	
	
	//AddClass=.taskview .li:hover { background-color:#316AC5; } 
	w = $('#userview'+decID+forum_decID).css("background", "white").css("cursor", "pointer").addClass('taskview');
	if(w.css('display') == 'none')
	{
		offset = $(el).offset();
		

		offset = $(el).offset();
		//w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
		w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, left: offset.left , 'min-width': $(el).width() }).show();

		
		
		w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
		loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
		$(document).bind("click", userviewClose2);
	 }
	else {
		el.blur();
		userviewClose2(decID,forum_decID);
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function userviewClose2(decID,forum_decID,e)
{
	if(e) {
		//if(isParentId(e.target, ['userviewcontainer'+decID+forum_decID+'','userview'])) return;
	}
	$(document).unbind("click", userviewClose2);
	$('#userview'+decID+forum_decID).hide();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**************************************************************************************************************/
function showuserTagCloud2(el,url,decID,forum_decID,mgr_userID)
{
	
	flag.tagsuserChanged = true;

	w = $('#tagusercloud'+decID+forum_decID).addClass('tagcloud').css("border", "1px solid red");
 
	if(w.css('display') == 'none')
	{
		if(flag.tagsuserChanged)
		{
			$('#tagusercloudcontent'+decID+forum_decID).html('');
			$('#tagusercloudload'+decID+forum_decID).addClass('tagcloudload').css({'display':'none'}).show();
			$('#tagusercloudbtn'+decID+forum_decID).css({'cursor':'pointer'}) ;
/////////////////////////////////////////////
			
////////////////////////////////////////			
			
			offset = $(el).offset();
			//w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
		
			
			
			 if( ($('#my_task_view').val()==undefined) ){
				 w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
			}else{
				w.css({ position: 'relative', top: '40px', 'min-width': $(el).width() }).show();
			}
			
			
			
			
			
			
			setAjaxErrorTrigger(url);
			nocache = '&rnd='+Math.random();
			
			$.getJSON(url+'ajax2.php?taguserCloud&forum_decID='+forum_decID+nocache, function(json){
				resetAjaxErrorTrigger();
				$('#tagusercloudload'+decID+forum_decID).hide();
				
				if(!parseInt(json.total)) return;
				var cloud = '';
				
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				$.each(json.cloud, function(i,item){
				     	  
			  cloud += '<a href="#" onClick=\'adduserFilterTag2("'+item.tag+'","'+url+'","'+decID+'","'+forum_decID+'","'+mgr_userID+'");taguserCloudClose2("'+decID+'","'+forum_decID+'","'+el+'" );return false;\' class="tag w'+item.w+'" >'+item.tag+'</a>';
			});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				 
				$('#tagusercloudcontent'+decID+forum_decID).html(cloud);
				
				
				 $("a[class^=tag w]").css("border", "3px solid red").bind("click",function(){
					 
					 $('#tagusercloud'+decID+forum_decID).hide();
					 return false;
				 });
				
				
				flag.tagsuserChanged = false;
			});
		}
		else {
			offset = $(el).offset();
			l = Math.ceil(offset.left - w.outerWidth()/2 + $(el).outerWidth()/2);
			if(l<0) l=0;
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, left: l }).show();
		}
		$(document).bind("click", taguserCloudClose2);
	}
	else {
		el.blur();
		taguserCloudClose2(decID,forum_decID,e);
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function showuserTagCloud_all(el,url,decID,forum_decID,mgr_userID)
{
	
	flag.tagsuserChanged = true;

	w = $('#tagusercloud_all'+decID+forum_decID).addClass('tagcloud').css("border", "1px solid red");
 
	if(w.css('display') == 'none')
	{
		if(flag.tagsuserChanged)
		{
			$('#tagusercloudcontent_all'+decID+forum_decID).html('');
			$('#tagusercloudload_all'+decID+forum_decID).addClass('tagcloudload').css({'display':'none'}).show();
			$('#tagusercloudbtn_all'+decID+forum_decID).css({'cursor':'pointer'}) ;
/////////////////////////////////////////////
			
////////////////////////////////////////			
			
			offset = $(el).offset();
			//w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
		
			
			
			 if( ($('#my_task_view').val()==undefined) ){
				 w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, 'min-width': $(el).width() }).show();
				 //w.css({ position: 'relative', top: '40px', 'min-width': $(el).width() }).show();
			}else{
				w.css({ position: 'relative', top: '40px', 'min-width': $(el).width() }).show();
			}
			
			
			
			
			
			
			setAjaxErrorTrigger(url);
			nocache = '&rnd='+Math.random();
			
			$.getJSON(url+'ajax2.php?taguserCloud_all&forum_decID='+forum_decID+nocache, function(json){
				resetAjaxErrorTrigger();
				$('#tagusercloudload_all'+decID+forum_decID).hide();
				
				if(!parseInt(json.total)) return;
				var cloud = '';
				
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				$.each(json.cloud, function(i,item){
				     	  
cloud += '<a href="#" onClick=\'adduserFilterTag3("'+item.tag+'","'+url+'","'+decID+'","'+forum_decID+'","'+mgr_userID+'");taguserCloudClose3("'+decID+'","'+forum_decID+'","'+el+'" );return false;\' class="tag w'+item.w+'" >'+item.tag+'</a>';
			});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				 
				$('#tagusercloudcontent_all'+decID+forum_decID).html(cloud);
				
				
				 $("a[class^=tag w]").css("border", "3px solid brown").bind("click",function(){
					 
					 $('#tagusercloud_all'+decID+forum_decID).hide();
					 return false;
				 });
				
				
				flag.tagsuserChanged = false;
			});
		}
		else {
			offset = $(el).offset();
			l = Math.ceil(offset.left - w.outerWidth()/2 + $(el).outerWidth()/2);
			if(l<0) l=0;
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, left: l }).show();
		}
		$(document).bind("click", taguserCloudClose3);
	}
	else {
		el.blur();
		taguserCloudClose3(decID,forum_decID,e);
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function prepareuserTagsStr2(tags,url,decID,forum_decID,mgr_userID,mgr)
{
	 
   
	if(!tags || tags == '') return '';
	a = tags.split(',');
	if(!a.length) return '';
	for(i in a) {
		a[i] = '<a href="#" class="tag" onClick=\'adduserFilterTag2("'+a[i]+'", "'+url+'","'+decID+'","'+forum_decID+'","'+mgr_userID+'","'+mgr+'");return false\'>'+a[i]+'</a>';
		 
	}
	return '<span class="task-tags">'+a.join(', ')+'</span>';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function adduserFilterTag2(tag,url,decID,forum_decID,mgr_userID,mgr)
{
	 
	filter.tag = tag;
	filter.compl=1;
	loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
	filter.compl=0;
	$('#tagusercloudbtn'+decID+forum_decID+'>.btnstr').html('תגית:' + ' <span class="tag">'+tag+'</span>');
	
	   
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function adduserFilterTag3(tag,url,decID,forum_decID,mgr_userID,mgr)
{
	 
	filter.tag = tag;
	filter.compl=1;
	loadUsers3(url,forum_decID,decID,mgr_userID,mgr);
	filter.compl=0;
	$('#tagusercloudbtn_all'+decID+forum_decID+'>.btnstr').html('תגית:' + ' <span class="tag">'+tag+'</span>');
	
	   
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function canceluserTagFilter2(url,decID,forum_decID,mgr_userID,mgr)
{
	  
 $('#tagusercloudbtn'+decID+forum_decID+'>.btnstr').text($('#tagusercloudbtn'+decID+forum_decID).attr('title'));
	filter.tag = '';
	loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function canceluserTagFilter3(url,decID,forum_decID,mgr_userID,mgr)
{
	  
 $('#tagusercloudbtn_all'+decID+forum_decID+'>.btnstr').text($('#tagusercloudbtn_all'+decID+forum_decID).attr('title'));
	filter.tag = '';
	loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function taguserCloudClose2(decID,forum_decID,e)
{
	 
	if(e) {
	//	if(isParentId(e.target, ['tagusercloudbtn'+decID+form_decID+'','tagusercloud'+decID+form_decID+''])) return;
	}
	$(document).unbind("click", taguserCloudClose2);
	$('#tagusercloud'+decID+forum_decID).hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function taguserCloudClose3(decID,forum_decID,e)
{
	 
	if(e) {
	//	if(isParentId(e.target, ['tagusercloudbtn'+decID+form_decID+'','tagusercloud'+decID+form_decID+''])) return;
	}
	$(document).unbind("click", taguserCloudClose3);
	$('#tagusercloud_all'+decID+forum_decID).hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function canceluserTagFilter(url)
{
	 
	$('#tagusercloudbtn>.btnstr').text($('#tagusercloudbtn').attr('title'));
	filter.tag = '';
	loadUsers(url);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function prepareuserTagsStr(tags,url)
{
	 
   
	if(!tags || tags == '') return '';
	a = tags.split(',');
	if(!a.length) return '';
	for(i in a) {
		a[i] = '<a href="#" class="tag" onClick=\'adduserFilterTag("'+a[i]+'", "'+url+'");return false\'>'+a[i]+'</a>';
		 
	}
	return '<span class="task-tags">'+a.join(', ')+'</span>';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function adduserFilterTag(tag,url)
{
	 
	filter.tag = tag;
	loadUsers(url);
	$('#tagusercloudbtn>.btnstr').html('תגית:' + ' <span class="tag">'+tag+'</span>');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateuserAccessStatus(onInit)
{
	if(flag.needAuth && !flag.isLogged) $("#userlist").sortable('disable').addClass('readonly');
	else $("#userlist").sortable('enable').removeClass('readonly');

	if(!flag.canAllRead && !flag.isLogged) {
		$('#page_users > h3,#usercontainer').hide();
		$('#usertabs').hide();
	}
	else {
		$('#page_users > h3,#usercontainer').show();
		$('#usertabs').show();
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
		if(flag.isLogged) $("#usertabs").tabs('enable',0).tabs('enable',1).tabs('select',0);
		else if(flag.canAllRead) $("#usertabs").tabs('enable',1).tabs('select', 1).tabs('disable',0);
		else $("#usertabs").tabs('disable',0).tabs('disable',1);
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function sortuserStart(event,ui)
{
	// remember initial order before sorting
	sortuserOrder = $(this).sortable('toArray');
	var xx=0;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*********************************************************************************************/
function setuserSort2(v,decID,forum_decID, init)
{
//	var url='/alon-web/olive_prj/admin/';
	var url='../admin/';
	//alert(v);
	if(v == 0) $('#usersort'+decID+forum_decID+'>.btnstr').text($('#sortuserByHand'+decID+forum_decID).text());
	else if(v == 1) $('#usersort'+decID+forum_decID+'>.btnstr').text($('#sortuserByPrio'+decID+forum_decID).text());
	else if(v == 2) $('#usersort'+decID+forum_decID+'>.btnstr').text($('#sortuserByDueDate'+decID+forum_decID).text());
	 
	else return;
	
	if(sortBy != v) {
		sortBy = v;
		if(v==0) $("#userlist"+decID+forum_decID).sortable('enable');
		else $("#userlist"+decID+forum_decID).sortable('disable');
	
		if(!init) {
			changeUserOrder2(url,decID,forum_decID);
			exp = new Date();
			exp.setTime(exp.getTime() + 3650*86400*1000);	//+10 years
			//alert(sortBy);
			document.cookie = "usersort="+sortBy+'; expires='+exp.toUTCString();
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function showuserSort2(el,url,decID,forum_decID,mgr_userID,mgr)
{
	 
	w = $('#sortuserform'+decID+forum_decID).addClass('sortform');
	if(w.css('display') == 'none')
	{
		offset = $(el).offset();
		if($.browser.mozilla==true)  {
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-2, left: offset.left , 'min-width': $(el).width() }).show();
			}else
		    w.css({ position: 'absolute', top: offset.top+el.offsetHeight-2, left: offset.left     , 'min-width': $(el).width() }).show();
	
		loadUsers2(url,forum_decID,decID,mgr_userID,mgr);
		$(document).bind("click", sortuserClose2);
	}
	
	else {
		el.blur();
		sortuserClose2(decID,forum_decID);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function sortuserClose2(decID,forum_decID,e)
{
	if(e) {
		//if(isParentId(e.target, ['sortuserform','sort1'])) return;
	}
	$(document).unbind("click", sortuserClose2);
	$('#sortuserform'+decID+forum_decID).hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*********************************************************************************************/
function setuserSort(v, init)//old
{
//	var url='/alon-web/olive_prj/admin/';
	var url='../admin/';

	if(v == 0) $('#sort1>.btnstr').text($('#sortuserByHand').text());
	else if(v == 1) $('#sort1>.btnstr').text($('#sortuserByPrio').text());
	else if(v == 2) $('#sort1>.btnstr').text($('#sortuserByDueDate').text());
	 
	else return;
	
	if(sortBy != v) {
		sortBy = v;
		if(v==0) $("#userlist").sortable('enable');
		else $("#userlist").sortable('disable');
	
		if(!init) {
			changeUserOrder(url);
			exp = new Date();
			exp.setTime(exp.getTime() + 3650*86400*1000);	//+10 years
			//alert(sortBy);
			document.cookie = "sort1="+sortBy+'; expires='+exp.toUTCString();
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function showuserSort(el)
{
	 
	w = $('#sortuserform');
	if(w.css('display') == 'none')
	{
		offset = $(el).offset();
		if($.browser.mozilla==true)  {
			w.css({ position: 'absolute', top: offset.top+el.offsetHeight-2, left: offset.left , 'min-width': $(el).width() }).show();
			}else
		    w.css({ position: 'absolute', top: offset.top+el.offsetHeight-2, left: offset.left     , 'min-width': $(el).width() }).show();
		//w.css({ position: 'absolute',top: 200, left:800,'min-width':$(el).width()}).show();
		$(document).bind("click", sortuserClose);
	}
	
	else {
		el.blur();
		sortuserClose();
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function sortuserClose(e)
{
	if(e) {
		//if(isParentId(e.target, ['sortuserform','sort1'])) return;
	}
	$(document).unbind("click", sortuserClose);
	$('#sortuserform').hide();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function orderuserChanged(event,ui)//old
{
	 
	n = $(this).sortable('toArray');
	// remove possible empty id's
	for(i=0; i<sortuserOrder.length; i++) {
		if(sortuserOrder[i] == '') { sortuserOrder.splice(i,1); i--; }
	}
	
	if(n.toString() == sortuserOrder.toString()){ return;}
	
	// make assoc from array for easy index
	var h0 = new Array();
	for(j=0; j<sortuserOrder.length; j++) {
		h0[sortuserOrder[j]] = j;
	}
	var h1 = new Array();
	for(j=0; j<n.length; j++) {
		h1[n[j]] = j;
		userOrder[j] = n[j].split('_')[1];
	}
	// prepare param string 
	var s = '';
	for(j in h0)
	{
		diff = h1[j] - h0[j];
		if(diff != 0) {
			a = j.split('_');
			s += a[1] +'='+ diff+ '&';
			userList[a[1]].ow += diff;
		}
	}
//	var url='/alon-web/olive_prj/admin/';
	var url='../admin/';
	setAjaxErrorTrigger(url);
	
	nocache = '&rnd='+Math.random();
	
	$.post(url+'ajax.php?changeuserOrder'+nocache, { order: s }, function(json){
		resetAjaxErrorTrigger();
	},'json');  
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function orderuserChanged2(event,ui)//new
{
//	var forum_decID =document.getElementById('forum_decID').value;
	n = $(this).sortable('toArray');
	// remove possible empty id's
	for(i=0; i<sortuserOrder.length; i++) {
		if(sortuserOrder[i] == '') { sortuserOrder.splice(i,1); i--; }
	}
	
	if(n.toString() == sortuserOrder.toString()){ return;}
	
	// make assoc from array for easy index
	var h0 = new Array();
	for(j=0; j<sortuserOrder.length; j++) {
		h0[sortuserOrder[j]] = j;
	}
	var h1 = new Array();
	for(j=0; j<n.length; j++) {
		h1[n[j]] = j;
		userOrder[j] = n[j].split('_')[1];
	}
	// prepare param string 
	var s = '';
	for(j in h0)
	{
		diff = h1[j] - h0[j];
		if(diff != 0) {
			a = j.split('_');
			s += a[1] +'='+ diff+ '&';
			userList[a[1]].ow += diff;
		}
	}
//	var url='/alon-web/olive_prj/admin/';
	var url='../admin/';
	
	setAjaxErrorTrigger(url);
	
	nocache = '&rnd='+Math.random();
	
	$.post(url+'ajax2.php?changeuserOrder2'+nocache, { order: s,forum_decID:forum_decID }, function(json){
		resetAjaxErrorTrigger();
	},'json');  
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function changeUserOrder2(url,decID,forum_decID)//new
{ 
	//var url='/alon-web/olive_prj/admin/';
	// loadUsers(url);
	
	   if(userOrder.length < 2) return;
        	oldOrder = userOrder.slice();
	
	
	
		//alert(userList[b]);
	 //  alert(sortBy);
	if(sortBy == 0) userOrder.sort( function(a,b){ 
	    // alert(userList[a].ow);
		// alert(userList[id]);
			return userList[a].ow-userList[b].ow;
		});
	else if(sortBy == 1) userOrder.sort( function(a,b){
			if(userList[a].prio != userList[b].prio) return userList[b].prio-userList[a].prio;
			if(userList[a].dueInt != userList[b].dueInt) return userList[a].dueInt-userList[b].dueInt;
			return userList[a].ow-userList[b].ow; 
		});
	else if(sortBy == 2) userOrder.sort( function(a,b){
			if(userList[a].dueInt != userList[b].dueInt) return userList[a].dueInt-userList[b].dueInt;
			if(userList[a].prio != userList[b].prio) return userList[b].prio-userList[a].prio;
			return userList[a].ow-userList[b].ow; 
		});
	
			    //$.getScript('in-showTask.php');
		 
	//});
	else return;
	if(oldOrder.toString() == userOrder.toString()) return;
	o = $('#userlist'+decID+forum_decID);
	for(i in userOrder) {
		o.append($('#userrow_'+userOrder[i]));
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function changeUserOrder(url)//old
{ 
	//var url='/alon-web/olive_prj/admin/';
	// loadUsers(url);
	
	   if(userOrder.length < 2) return;
        	oldOrder = userOrder.slice();
	
	
	
		//alert(userList[b]);
	 //  alert(sortBy);
	if(sortBy == 0) userOrder.sort( function(a,b){ 
	    // alert(userList[a].ow);
		// alert(userList[id]);
			return userList[a].ow-userList[b].ow;
		});
	else if(sortBy == 1) userOrder.sort( function(a,b){
			if(userList[a].prio != userList[b].prio) return userList[b].prio-userList[a].prio;
			if(userList[a].dueInt != userList[b].dueInt) return userList[a].dueInt-userList[b].dueInt;
			return userList[a].ow-userList[b].ow; 
		});
	else if(sortBy == 2) userOrder.sort( function(a,b){
			if(userList[a].dueInt != userList[b].dueInt) return userList[a].dueInt-userList[b].dueInt;
			if(userList[a].prio != userList[b].prio) return userList[b].prio-userList[a].prio;
			return userList[a].ow-userList[b].ow; 
		});
	
			    //$.getScript('in-showTask.php');
		 
	//});
	else return;
	if(oldOrder.toString() == userOrder.toString()) return;
	o = $('#userlist');
	for(i in userOrder) {
		o.append($('#userrow_'+userOrder[i]));
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function changeUserCnt(cl, dir)//wich one is today1 or soon1 or past1
{
	// alert(dir);
	//  alert( userCnt.soon1);
	if(!dir) dir = 1;
	else if(dir > 0) dir = 1;
	else if(dir < 0) die = -1;
	if(cl == 'soon') { userCnt.soon1 += dir;  return true; }
	else if(cl == 'today') { userCnt.today1 += dir; return true; }
	else if(cl == 'past') { userCnt.past1+= dir; return true; }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function refreshUserCnt()
{
	$('#cnt_past1').text(userCnt.past1);
	$('#cnt_today1').text(userCnt.today1);
	$('#cnt_soon1').text(userCnt.soon1);
}
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function refreshUserCnt2(decID,forum_decID)
{ 
	$('#cnt_past1'+decID+forum_decID).text(userCnt.past1);
	$('#cnt_today1'+decID+forum_decID).text(userCnt.today1);
	$('#cnt_soon1'+decID+forum_decID).text(userCnt.soon1);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function userlistClick(e)
{
	 
	node = e.target.nodeName;
	 
	if(node=='SPAN' || node=='LI' || node=='DIV') {
		li = getRecursParent(e.target, 'LI', 10);
		 
		if(li) {
			if(selUser && li.id != selUser) $('#'+selUser).removeClass('clicked doubleclicked');
			selUser = li.id;
			
			if($(li).is('.clicked')) $(li).toggleClass('doubleclicked');
			else $(li).addClass('clicked');
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function priouserPopup(act, el, id)
{
	if(act == 0) {
		clearTimeout(objPrio.timer);
		return;
	}
	offset = $(el).offset();
	$('#userpriopopup').css({ position: 'absolute', top: offset.top + 1, left: offset.left + 1 });
	objPrio.userID = id;
	objPrio.el = el;
	objPrio.timer = setTimeout("$('#userpriopopup').show()", 300);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function priouserClick(prio, el,url)
{
	el.blur();
	prio = parseInt(prio);
	setAjaxErrorTrigger(url);
	nocache = '&rnd='+Math.random();
//	var url='/alon-web/olive_prj/admin/';

	$.getJSON(url+'ajax.php?setuserPrio='+objPrio.userID+'&prio='+prio+nocache, function(json){
		resetAjaxErrorTrigger();
	});
	userList[objPrio.userID].prio = prio;
	$(objPrio.el).replaceWith(prepareuserPrio(prio, objPrio.userID));
	$('#userpriopopup').fadeOut('fast'); //.hide();
	if(sortBy != 0) changeUserOrder(url);
	$('#userrow_'+objPrio.userID).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
}


	


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function setAjaxErrorTrigger2(url)
{
	resetAjaxErrorTrigger();
	$("#msg").ajaxError(function(event, request, settings){
		var errtxt;
		if(request.status == 0) errtxt = 'Bad connection';
		else if(request.status != 200) errtxt = 'HTTP (\''+url+'\'+ajax2.php): '+request.status+'/'+request.statusText;
		else errtxt = request.responseText;
		flashError("Some error occurred (click for details	)", errtxt);
	});
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function del_user(userID,url){
	
var countList='';	
	$('tr#user_'+userID).addClass('border_print');
	 
 	data=new Array();
 		data[0]='delete';
var str='delete';
		
	if(!confirm("האים בטוח שרוצה למחוק?")){
		$('tr#user_'+userID).removeClass('border_print');
		 return false;
	}
	
	
	
	var data1= data[0].toString();
	
	

	
	
	 
	tz = -1 * (new Date()).getTimezoneOffset();
	nocache = '&rnd='+Math.random();
	//NO_DC I AHAVE TO USE AJAX2.php 
 	$.getJSON(url+'ajax2.php?mode2='+str+'&id='+userID+'&tz='+tz+nocache, function(json){
		
 	    if(json.type == 'success' &&  !(json.type ==undefined)){ 
		
		var userID=json.userID;

			alert("רשומה נימחקה");
			   $('tr#user_'+userID).remove();
	}
		
/*********************************************most success******************************************************/		
else{
		var i=0;	 
			 var userID=json.userID;  
			 $.each(json  , function(i,item){ 			
					var  messageError= i;
				  
					 $("#forum-message").html(' ').fadeIn();
				 
					 if(messageError!='userID')
			    	 countList +='<li class="error">'+ item +'</li>';
				       
				 });	 
		 
			 $('#my_error_message').html('<ul id="countList_check">'+countList+'</ul>').css({'margin-right': '90px'});
			 $('#my_error_message').append($('<p ID="bgchange"   ><b style="color:blue;">הודעת שגיאה!!!!!</b></p>\n' ));
			
// 			 $('<input id="my_error_button"  type="button"  onClick="delClose()"  value="לחץ לאישור קבלת הבעייה" />').appendTo($('#my_error_message'));
			 $('<button id="my_error_button" class="green90x24"  type="button"  onClick="delClose()"  value="לחץ לאישור קבלת הבעייה" >  לחץ לאישור </button>').appendTo($('#my_error_message'));
			 $('#my_error_message').show();
			  turn_red(); 		
		}//end else	
 
 	
 	
 	
 	});//end first getjson	
			
	
 	// $(document).bind("click", delClose);
		 
   return false;
}//end del_user

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function del_user_frm(userID,forum_decID,url){
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var str='delete';
		
	if(!confirm("האים בטוח שרוצה למחוק?")){
		$('tr#user_'+userID+forum_decID).removeClass('border_print');
		 return false;
	}
	
		tz = -1 * (new Date()).getTimezoneOffset();
	nocache = '&rnd='+Math.random();
	//NO_DC I AHAVE TO USE AJAX2.php 
 	$.getJSON(url+'ajax2.php?mode_del='+str+'&id='+userID+'&forum_decID='+forum_decID+'&tz='+tz+nocache, function(json){
		
 	    if(json.type == 'success' &&  !(json.type ==undefined)){ 
		
		    var userID=json.userID;
			var forum_decID=json.forum_decID;
			alert("רשומה נימחקה");
			   $('tr#user_'+userID+forum_decID).remove();
	}
		
		
 	});		 
   return false;
}//end del_user

//////////////////////////////////////////////////////////////////////////////////////////////////
function del_Decuser_frm(userID,forum_decID,decID,url){
	
	
			
		if(!confirm("האים בטוח שרוצה למחוק?")){
			$('tr#user_'+userID+forum_decID+decID).removeClass('border_print');
			 return false;
		}
		var str='delete';
		tz = -1 * (new Date()).getTimezoneOffset();
		nocache = '&rnd='+Math.random();
		//NO_DC I AHAVE TO USE AJAX2.php  
	 	$.getJSON(url+'ajax2.php?mode_Dec_usrdel='+str+'&id='+userID+'&forum_decID='+forum_decID+'&decID='+decID+'&tz='+tz+nocache, function(json){
			
	 	    if(json.type == 'success' &&  !(json.type ==undefined)){ 
			
			    var userID=json.userID;
				var forum_decID=json.forum_decID;
				var decID=json.decID;
				alert("רשומה נימחקה");
				   $('tr#user_'+userID+forum_decID+decID).remove();
		}
			
			
	 	});		 
	   return false;
	}//end del_user

//////////////////////////////////////////////////////////////////////////////////////////////////

function delClose(){
 //	 $('input#my_error_button').bind('click',function(){
		
		$("div#my_error_message").hide();
		
	//  });	
	
}
//////////////////////////////////////////////////////////////////////////////////////////////
function setValue()
{
	 
var arv = scriptAr.toString();
$('#search-text').autocomplete(arv,{
	autoFill: true,
	selectFirst: true,
	width: '240px'
	    
	}); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////

function get_json(){
	  
	var def='read_users';
	tz = -1 * (new Date()).getTimezoneOffset();
	 nocache = '&rnd='+Math.random();
//	 var url='/alon-web/olive_prj/admin/';
	 var url='../admin/';
	  data_users=new Array();
	

	 $.getJSON(url+'ajax2.php?mode='+def, function(json){
		 
						 
		 
	
	 	     
	////////////////////////////////////////////////////////
	 $.each(json.list, function(i, item){
	////////////////////////////////////////////////////////
	 //alert("VVVVVVVVVVV");
		 
		 //alert(json.list[0].full_name);
		 //alert(item.full_name);     
	
		 data_users=item.full_name;
	   
	  });//end each
	 });//end json
}
///////////////////////////////////////////////////////////////////
function checkstringformat(userinput){
	//var dateformat = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/
	var stringformat = /(^-?\d\d*$)/;
	return stringformat.test(userinput); //returns true or false depending on userinput
}


/**********************************************************************************************/


//function updateTips(t) {
//	
//	
//	   var full_name = $("#full_name"+forum_decID),
//	 
//	 //  prio = $("#prio"+forum_decID),
//	 //  level = $("#level"+forum_decID),
//		//note = $("#note"+forum_decID),
//	   upass = $("#upass"+forum_decID),
//	   uname = $("#uname"+forum_decID),
//	   email = $("#email"+forum_decID),
//	   phone_num = $("#phone_num"+forum_decID),
//       date1 = $("#date1"+forum_decID),
//		  //tags = $("#tags"+forum_decID),
//			allFields = $([]).add(full_name).add(upass).add(uname).add(email).add(phone_num).add(date1) ,
//			tips = $(".validateTips");	
//	
//	
//	
//	tips
//		.text(t)
//		.addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');
//	setTimeout(function() {
//		tips.removeClass('ui-state-highlight', 1500);
//	}, 500).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
//}
//
//function checkLength(o,n,min,max) {
//
//	if ( (o.val().length > max || o.val().length < min) || (o.val()=="null") ) {
//		o.addClass('ui-state-error');
//		updateTips("אורך של שדה: " + n + " -חייב להיות בין "+min+" לבין "+max+ " תווים.");
//		return false;
//	} else {
//		return true;
//	}
//
//}
//
//function checkRegexp(o,regexp,n) {
//
//	if ( !( regexp.test( o.val() ) ) ) {
//		o.addClass('ui-state-error');
//		updateTips(n);
//		return false;
//	} else {
//		return true;
//	}
//
//}

		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function updateTips2(t) {
		
		 var full_name = $("#full_nameUsr"),
		   fname = $("#f_nameUsr"),
		   lname = $("#l_nameUsr"),
		   upass = $("#upassUsr"),
		   uname = $("#unameUsr"),
		   email = $("#emailUsr"),
		   phone_num = $("#phone_numUsr"),
			  date1 = $("#date1"),

				allFields = $([]).add(full_name).add(fname).add(lname).add(upass).add(uname).add(email).add(phone_num).add(date1) ,
				tips = $(".validateTips");
		
	
		if($.browser.msie==true){
			
			tips.text(t).addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');
//			setTimeout(function() {
//				tips.removeClass('ui-state-highlight', 1500);
//			}, 500);

		}else{
			tips.text(t).addClass('ui-state-highlight').effect("highlight", {color:theme.editUserFlashColor}, 'normal');
			setTimeout(function() {
				tips.removeClass('ui-state-highlight', 1500);
			}, 500).effect("highlight", {color:theme.editUserFlashColor}, 'normal');
		}
	
	
	
	
	}

	
	
	
	
		function checkLength2(o,n,min,max) {

			if ( (o.val().length > max || o.val().length < min) || (o.val()=="null") ) {
				o.addClass('ui-state-error');
				updateTips2("אורך של שדה: " + n + " -חייב להיות בין "+min+" לבין "+max+ " תווים.");
				return false;
			} else {
				return true;
			}
	   
		}

		function checkRegexp2(o,regexp,n) {

			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass('ui-state-error');
				updateTips2(n);
				return false;
			} else {
				return true;
			}

		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function edituserTasks2 (id,decID,forum_decID,url,prog_bar) 
		{    
			//if(item.task_allowed==)
			
		   document.forms['edittask_dlg'+decID+forum_decID].elements['Request_Tracking_Number_find'+decID+forum_decID].value=id; 
		  
		   
		   progList[0]=prog_bar;

		   $('#progress'+decID+forum_decID).progressbar("option", "value",prog_bar);
		  

		  
		   
		 $("#progress"+decID+forum_decID+".ui-progressbar-value").animate({width: prog_bar+"%"}, 500);
		 
		   
			var item = taskList[id];
		     
			if(!item) { return false;}
		 

			 document.forms['edittask_dlg'+decID+forum_decID].elements['task_name'+decID+forum_decID].value = dehtml(item.title);
			
		 
			 document.forms['edittask_dlg'+decID+forum_decID].elements['note'+decID+forum_decID].value= item.noteText; 

		 
			 document.forms['edittask_dlg'+decID+forum_decID].elements['tags'+decID+forum_decID].value= item.tags.split(',').join(', '); 
		     
			 document.forms['edittask_dlg'+decID+forum_decID].elements['duedate'+decID+forum_decID].value= item.duedate; 
			 
			 
			 
			 if(item.task_allowed=='public')
				 item.task_allowed=0;
			 else if(item.task_allowed=='private')
				 item.task_allowed=1;
			 
			 
			 document.forms['edittask_dlg'+decID+forum_decID].elements['catTask'+decID+forum_decID].value= item.task_allowed; 
		 
			
		 	 sel = document.forms['edittask_dlg'+decID+forum_decID].elements['prio'+decID+forum_decID] ;
		  
			for(i=0; i<sel.length; i++) {
				if(sel.options[i].value == item.prio) sel.options[i].selected = true;
			}
			
			
			sel1 = document.forms['edittask_dlg'+decID+forum_decID].elements['userselect'+decID+forum_decID] ; 
			for(i=0; i<sel1.length; i++) {
				if(sel1.options[i].value == item.userID){
					sel1.options[i].selected = true;
					 
				}
			}
			
			
			
		   sel2 = document.forms['edittask_dlg'+decID+forum_decID].elements['userselect1'+decID+forum_decID];
			
			for(i=0; i<sel2.length; i++) {
				if(sel2.options[i].value == item.dest_userID){
					sel2.options[i].selected = true;
					 
				}
			}
			
			
			 $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).show();
			  w = $('#page_taskedit_dlg'+decID+forum_decID);
			 
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function edituserTasks (userID,decID,forum_decID,url,dest_userID)
{
	nocache = '&rnd='+Math.random();
	var tz = -1 * (new Date()).getTimezoneOffset();
/********************************************************************************************/
$.getJSON(url+'ajax2.php?loadTasks2user2&compl='+filter.compl+'&sort='+sortBy+'&forum_decID='+forum_decID+'&decID='+decID+'&userID='+userID+'&dest_userID='+dest_userID+'&tz='+tz+nocache, function(json){
		
					
  if(!json.total){
    	 alert('!!אין משימות כרגע');	
    return ;
    }else $('#total2').html(json.total);
  //item =json.list[0];
//  taskList = new Array();
  taskOrder = new Array();

 var tasks = '';
/**********************************************************************/ 
///////////////////////////////////////////////////			
		$.each(json.list, function(i,item){
//////////////////////////////////////////////////			
			 
		tasks += prepareuserTaskStr3(item,url,decID,forum_decID);//function in ajx_multi.php prepareuserTaskStr2 !	prepareUserTaskStr2
		updateProgressBar(item.prog_bar,item.taskID) ;	 
		 $('#progress'+decID+forum_decID).progressbar("option", "value",item.prog_bar);
 	    taskList[item.taskID] = item;

		});//end each
/************************************************************************/ 
$('<div id="task_edit_entry_form'+decID+forum_decID+'" title="משימות ש'+json.list[0].full_name+' שלח -'+json.total+' "    dir="rtl"  style="float:right;">'+
		  '<form id="edit_tsk'+decID+forum_decID+'">'+
            '</form></div>')
           .appendTo($('body'));
	  
$("#task_edit_entry_form"+decID+forum_decID).html(tasks).dialog({
	 
 
	bgiframe: true,
	autoOpen: false,
	height: 400,
	width: 500,
	modal: true,
	zindex: -1,
    
buttons: {




Cancel: function() {
	$(this).dialog('close');
$("#task_edit_entry_form"+decID+forum_decID).remove();
	 
} 

/***************************************************************************************/		

/******************************************************************************************/		

},//end button

 
	close: function() {
	 
	 
	$("#task_edit_entry_form"+decID+forum_decID).remove();
 
	}
	 
});//end dialog

$("#task_edit_entry_form"+decID+forum_decID).dialog('open');

if(filter.compl) showhide($('#compl_hide'),$('#compl_show'));
	else showhide($('#compl_show'),$('#compl_hide'));
	if(json.denied) errorDenied();

});//end json

  return false;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function prepareuserTaskStr3(item,url,decID,forum_decID)//tasks for a spacific user
{ 
	  
 id = parseInt(item.taskID);
     
	 userID = parseInt(item.userID);
	 
	 full_name=item.full_name;
	 
	prio = parseInt(item.prio);
	var	 prog_bar = parseInt(item.prog_bar);
	var url2="../admin/";
//	edituserTasks2('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+');
return '<li id="taskrow_'+id+'" class="'+(item.compl?'task-completed ':'')+item.dueClass+'"  style="cursor:pointer;"  onDblClick="editTask2User('+id+','+decID+','+forum_decID+',\''+url+'\','+prog_bar+');cancel_tsk_dlg('+decID+','+forum_decID+');updateProg('+prog_bar+','+decID+','+forum_decID+') ;	">'+
       

       '<div class="task-actions_b">'+
           '<span class="task-title">'+prepareHtml(item.full_name)+'</span>'+  
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
		                 '<a href="#" onClick="return saveTaskNote('+id+',\''+url+'\')">שמור</a>'+
		                 ' | <a href="#" onClick="return cancelTaskNote('+id+')">בטל</a>'+
	                	'</span>'+
		          '</div>'+
		          
		          
	   '</div>'+
	   
 "</div></li>\n";
}	
/***************************************************************************************************/	
function cancel_tsk_dlg(decID,forum_decID){
	
	$("#task_edit_entry_form"+decID+forum_decID).remove();
}

function updateProg(prog_bar,decID,forum_decID){
	$('#progress'+decID+forum_decID).progressbar("option", "value",prog_bar);
}	
/************************************************************************************************/
function editTask2User (id,decID,forum_decID,url,prog_bar)
{    
	 
	 
   document.getElementById('Request_Tracking_Number_find'+decID+forum_decID).value=id; 
  // document.forms['edittask_dlg'+decID+forum_decID].elements['Request_Tracking_Number_find'+decID+forum_decID].value=id; 
   document.getElementById('prog_bar').value=prog_bar;
   
   progList[0]=prog_bar;

   
   
   
   
   
   
   
/////////////////////////////////////   
	var item = taskList[id];      //	
////////////////////////////////////     
	if(!item) { return false;}
	 
/*******************************************************************************************/	
	$('#my_button_win'+decID+forum_decID).css({'background':'#B4D9D7'}).bind('click', function() {

	  	var link= '../admin/find3.php?&decID='+decID ;
	   	openmypage(link); 
	  
	    return false;
});
/***************************************************************************************************/	 

	document.getElementById('task_name'+decID+forum_decID).value = dehtml(item.title);
	
 
	document.getElementById('note'+decID+forum_decID).value= item.noteText; 
 
	document.getElementById('edittags'+decID+forum_decID).value= item.tags.split(',').join(', '); 
     
	document.getElementById('duedate'+decID+forum_decID).value= item.duedate; 
	 
	 
	 
	 if(item.task_allowed=='public')
		 item.task_allowed=0;
	 else if(item.task_allowed=='private')
		 item.task_allowed=1;
	 
	 
	 document.getElementById('catTask'+decID+forum_decID).value= item.task_allowed; 
 
	  
 	
	 
 	 sel = document.getElementById('prio'+decID+forum_decID) ;
  
	for(i=0; i<sel.length; i++) {
		if(sel.options[i].value == item.prio) sel.options[i].selected = true;
	}
	
	
	sel1 = document.getElementById('userselect'+decID+forum_decID) ; 
	for(i=0; i<sel1.length; i++) {
		if(sel1.options[i].value == item.userID){
			sel1.options[i].selected = true;
			 
		}
	}
	
	
	
   sel2 = document.getElementById('userselect1'+decID+forum_decID);
	
	for(i=0; i<sel2.length; i++) {
		if(sel2.options[i].value == item.dest_userID){
			sel2.options[i].selected = true;
			 
		}
	}
	
	
	 progList[0]=prog_bar;

	 
	  
 	 $('#progress'+decID+forum_decID).progressbar("option", "value",prog_bar);
 	
 	   
 	   
 	   $("#progress"+decID+forum_decID).progressbar(progList[0]);
 	 
 		 
 		 
		$("#value"+decID+forum_decID).length=	progList[0];
		var val=progList[0];
		if(val <=100) {
	       //show new value
	       ($("#value"+decID+forum_decID).length === 0) ? $("<span>").text(val + "%")
	        .attr("id", "value"+decID+forum_decID)
	        .css({ float: "right", marginTop: -28, marginRight:10 })
	        .appendTo("#progress"+decID+forum_decID) : $("#value"+decID+forum_decID).text(val + "%");
	        
	     }  
		
	 $('<div id="overlay"></div>').appendTo('body').css('opacity', 0.5).css({'z-iindex': '6000'}) .show();
	  w = $('#page_taskedit_dlg'+decID+forum_decID).draggable();
	 
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
	

		//$(document).bind('keydown', cancelEdit2_dlg);
	 return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cancelEdit2_dlg (decID,forum_decID,url,e)
{
//	var oTasks = document.getElementsByName("task"+decID+forum_decID);
	
	if(e && e.keyCode != 27) return;
	$(document).unbind('keydown', cancelEdit2);
	$('#page_taskedit_dlg'+decID+forum_decID).hide();
	$('#page_taskedit_dlg'+decID+forum_decID).resetForm();
	 
	$('#overlay').remove();
		
	
	return false;
}

/***************************ADD_USER************************************************************************/  

function submit_new_user(url, allFields ){
	
	 
	  $(function() {        
		    
		  var full_name = $("#full_name2"),
	        fname = $("#fname2"),
	        lname = $("#lname2"),
	        upass = $("#upass2"),
	        user = $("#user2"),
	        note = $("#note2"),
			email = $("#email2"),
			phone = $("#phone2"),
			user_date = $("#user_date2"),
			allFields = $([]).add(full_name).add(fname).add(lname).add(upass).add(user).add(note).add(email).add(phone).add(user_date),
			tips = $(".validateTips");

		  
	       
	        
	        
	        function updateTips(t) {
				tips
					.text(t)
					.addClass('ui-state-highlight');
				setTimeout(function() {
					tips.removeClass('ui-state-highlight', 1500);
				}, 500);
			}

			function checkLength(o,n,min,max) {

				if (  o.val().length > max || o.val().length < min ) {
					o.addClass('ui-state-error');
					updateTips("אורך של שדה: " + n + " -חייב להיות בין "+min+" לבין "+max+ " תווים.");
					return false;
				} else {
					return true;
				}

			}

			function checkRegexp(o,regexp,n) {

				if ( !( regexp.test( o.val() ) ) ) {
					o.addClass('ui-state-error');
					updateTips(n);
					return false;
				} else {
					return true;
				}

			}

			
		$("#page_Newuser").dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				'צור משתמש חדש': function() {
			
			     
					var bValid = true;
					allFields.removeClass('ui-state-error');
				    bValid = bValid && checkLength(full_name,"שם מלא",3,16);
					bValid = bValid && checkLength(fname,"שם פרטי",3,16);
					bValid = bValid && checkLength(lname,"שם משפחה",3,16); 
					bValid = bValid && checkLength(phone,"טלפון",3,16);
					bValid = bValid && checkLength(user_date,"תאריך לידה",10,20);
					bValid = bValid && checkLength(user,"שם משתמש",3,16);
					bValid = bValid && checkLength(email,"דואר אלקטרוני",6,80);
					bValid = bValid && checkLength(upass,"סיסמה",5,16);

				
					bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"דוגמה: alon@gmail.com");
					bValid = bValid && checkRegexp(upass,/^([0-9a-zA-Z])+$/,"Password field only allow : a-z 0-9");
					
					if (bValid) {
						 var $this=$(this);   
			                full_name=  document.getElementById('full_name2').value ;
			            	fname=  document.getElementById('fname2').value ;
			            	 lname= document.getElementById('lname2').value ;
			            	 level= document.getElementById('level2').value;
			            	 uname=document.getElementById('user2').value ;
			            	  upass=document.getElementById('upass2').value ;
			            	 
			            	  
			            	 note= document.getElementById('note2').value ;
			            	 email= document.getElementById('email2').value ;
			            	  phone_num=document.getElementById('phone2').value ;
			            	  
			            	  active=document.getElementById('active2').value ;
			            	  
			            	  user_date=document.getElementById('user_date2').value ;
			            	  $(this).dialog('close'); 
			                                            
			              $.ajax({
			                 type: "POST",
			                        url: url+'ajax2.php?newNormalUser',
			                        dataType: 'json',
			                        data: {
			            	           level: level ,active: active ,user_date: user_date,full_name:full_name ,fname:fname,
			      		            	lname:lname,uname:uname,upass:upass,email:email,phone_num:phone_num,note:note,tz:tz
			                        },
			                        success: function(json) {
			                        	$('#page_Newuser').dialog('close');
			                        	$(this).dialog('close');
			                        	$(this).dialog("destroy");
			                         
			                        	var item = json.list[0];
	                         			new_userList[item.userID] = item;
			                			var my_row=  prepareNormalUserStr(item, url);
			                			$('#theList:first').prepend(my_row);
			                        }   
						       });
			            	  

						 
					}
					
				},
				Cancel: function() {
					$(this).dialog('close');
					$("#dialog").dialog("destroy");
					allFields.val('').removeClass('ui-state-error');
				}
			},
			close: function() {
				$("#dialog").dialog("destroy");
				allFields.val('').removeClass('ui-state-error');
			}
		});
		
		
		
		//$('#btnAddUser').bind('click',function() {
	    	
				$('#page_Newuser').dialog('open');
				

					function updateDate(date) {
						  $("#user_date2").val(date);
						  
				       }
						
						//datepicker config
						var pickerOpts = {
						  beforeShow: function() {
						    $("#ui-datepicker-div").css("zIndex", 2006).next().css("zIndex", 1006);
						  },
							 dateFormat:'yy-mm-dd' ,
							 changeMonth: true,
			                   changeYear: true,
			                   showButtonPanel: true,
			                   buttonText: "Open date picker",
			                   altField: '#actualDate'
		 
						};
			       				
						$("#user_date2").focus(function() {
						   $(this).datepicker("dialog", null, updateDate, pickerOpts);
						     return false;
					  		});
					
	/***********************************************************************/				
	   $("#user_date2").datepicker({   firstDay: 1, showOn: 'button', buttonImage:'../images/calendar.png', buttonImageOnly: true});
					
	   

	   
		
	  });		
	
	
	
	
}

/****************************************************************************************************************/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function edit_active (userID,forum_decID,url,active)
{ 
/***********************************************************/
	
	if(!confirm("האים אתה בטוח?")) {
		return false;
	}
	
	
	tz = -1 * (new Date()).getTimezoneOffset();

	nocache = '&rnd='+Math.random();
	
/**********************************************************/	
	$.getJSON(url+'ajax2.php?update_active&userID='+userID+'&forum_decID='+forum_decID+'&active='+active+'&tz='+tz+nocache, function(json){
		
	 
		 
		 if (json.total==0){return;}
var status=''
var active=json.list[0].active;

if (active ==2)
	status=1;
	else
	status=0;

var userID=json.list[0].userID;
var forum_decID=json.list[0].forum_decID;
var user_row='';

user_row+='<td width="16"  id="my_active'+userID+forum_decID+'">'+
'<a href="javascript:void(0)" onclick="edit_active('+userID+','+forum_decID+',\''+url+'\','+active+'); return false;">'+
'<img src="../images/icon_status_'+status+'.gif" width="16" height="10" alt="" border="0" />'+  
'</a>'+      
'</td>';
		 
	$('#my_active'+userID+forum_decID).replaceWith(user_row);	 
		 
		 
		 		
});
  return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function edit_frmName (frmID){ 
nocache = '&rnd='+Math.random();
	
	tz = -1 * (new Date()).getTimezoneOffset();
$.getJSON('../admin/ajax2.php?update_data_module&forum_decID='+frmID+'&tz='+tz+nocache, function(json){
			
		 
			 
if (json.total==0){return;}
		  	
	var forum_decName=json.list[0].forum_decName;
	var frm_row='';

	frm_row='<table class="myformtable1" id="tree_content2" data-module="הצג החלטות בחלון של פורום:'+forum_decName+'">';
			 
		$('#tree_content2').attr('data-module','הצג החלטות בחלון של פורום:'+forum_decName+'');


   });

}