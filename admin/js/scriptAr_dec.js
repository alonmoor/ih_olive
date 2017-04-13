$(document).ready(function() { 
	 

tz = -1 * (new Date()).getTimezoneOffset();
nocache = '&rnd='+Math.random();
 $.getJSON('../admin/ajax2.php?usrArr_dec=get_arr_dec&tz='+tz+nocache, function(json){
var url='../admin';

scriptAr_dec = new Array(); 
     var scriptAr_dec=json;
     $('#search_dec_template').autocomplete(scriptAr_dec,{
    	    autoFill: true,
    	    selectFirst: true,
    	    width: '240px' 
    	     
    	  }).result(function(event, item) {
    		   
    		  var name_edit=item.toString();
    		    
    		  var myArray = name_edit.split(','); 

    		  var decID=myArray[1];

    	openmypage3("../admin/find3.php?decID="+decID+"");    		 
    	  
    });//end resultsearch
 });
  
}); 