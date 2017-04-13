 
//        function showDialog(){  
//             $("#divId").html('<iframe id="modalIframeId" width="100%" height="100%"     marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto" />').dialog("open"); 
//               $("#modalIframeId").attr("src","../admin/find3.php"); 
//                 return false;
//                 }
//        $(document).ready(function() { 
//              $("#divId").dialog({     
//                        autoOpen: false,        
//                           modal: true,      
//                                height: 500,       
//                                    width: 1000   
//                  });
//              });  
           
// dom0 frames referencing 
function loadIframe(iframeName, url) {
    if ( window.frames[iframeName] ) {
        window.frames[iframeName].location = url;   
        return false;
    }
    return true;
}

// assign new url to iframe element's src property
function changeIframeSrc(id, url) {
	  
    if (!document.getElementById) return;
    var el = document.getElementById(id);
 
    if (el && el.src) {
        el.src = url;
        return false;
    }
    return true;
}



//function openmypage(link){ //Define arbitrary function to run desired DHTML Window widget codes
//	 alert(link);
//	 ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", "../"+link, "Ajax Window Title", "width=1000px,height=600px,left=300px,top=100px,resize=1,scrolling=1");
//	 ajaxwin.onclose=function(){ //Run custom code when window is about to be closed
//	 return window.confirm("Close this window?");
//	} 
//}