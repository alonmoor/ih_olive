$(document).ready(function() { 
	 

tz = -1 * (new Date()).getTimezoneOffset();
nocache = '&rnd='+Math.random();
 $.getJSON('../admin/ajax2.php?usrArr_frm=get_arr_frm&tz='+tz+nocache, function(json){
 

scriptAr_frm = new Array(); 
     var scriptAr_frm=json;
     $('#search_frm_template').autocomplete(scriptAr_frm,{
    	    autoFill: true,
    	    selectFirst: true,
    	    width: '240px' 
    	     
    	  }).result(function(event, item) {
    		   
    		  var name_edit=item.toString();
    		    
    		  var myArray = name_edit.split(','); 

    		  var forum_decID=myArray[1];

    	openmypage3("../admin/find3.php?forum_decID="+forum_decID+"");    		 
    	  
    });//end resultsearch
 });
  
}); 