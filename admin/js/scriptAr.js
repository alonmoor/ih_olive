 
$(document).ready(function() { 
	 

tz = -1 * (new Date()).getTimezoneOffset();
nocache = '&rnd='+Math.random();
 $.getJSON('../admin/ajax.php?usrArr=get_arr&tz='+tz+nocache, function(json){
var url='../admin';
$('.ac_results').css('background-color','blue');
scriptAr_template = new Array(); 
     var scriptAr_template=json;//scriptAr_template;
     $('#search_editUser_template').autocomplete(scriptAr_template,{
    	    autoFill: true,
    	    selectFirst: true,
    	    width: '240px' 
    	     
    	  }).result(function(event, item) {
    		   
    		  var name_edit=item.toString();
    		    
    		  var myArray = name_edit.split(','); 

    		  var userID=myArray[1];

    	openmypage3("../admin/find3.php?userID="+userID+"");    		 
    	  
    });//end resultsearch
 });
  
}); 