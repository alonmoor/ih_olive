window.seconds = 10; 
window.onload = function()
{
    if (window.seconds != 0)
    {
   // if(document.getElementById('secondsDisplay').innerHTML!=undefined){ 	

    	if($('span#secondsDisplay').html()){ 
    	document.getElementById('secondsDisplay').innerHTML = '' +
            window.seconds + ' שניות' + ((window.seconds > 1) ? '' : ''); 
    	
    	
    	//$('span#secondsDisplay').html(  '' + window.seconds + ' שניות' + ((window.seconds > 1) ? '' : '')); 
    	
    	
        window.seconds--;
        setTimeout(window.onload, 1000);
    }
    }
    else
    {
//	var url='/alon-web/olive_prj/get_in_out2/html/';
//    	var url='../html/';
//    	var url='../../get_in_out2/html/';
        window.location = 'index.php?mode=conect';
        
    }
}
