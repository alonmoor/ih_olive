//window.onload = initAll;
var xhr = false;
var xPos, yPos;
//var decID=document.getElementById('decID').value  ;
function initAll() {
 //	var allLinks = document.getElementsByTagName("a");
 
	//var allLinks = document.getElementByClassName("my_dec_tooltip");
	//var allLinks = [document|tagRef].getElementsByClass("my_dec_tooltip");
	document.getElementsByClass = cstmGetElementsByClassName;
	var allLinks = document.getElementsByClass("my_dec_tooltip");
	
	for (var i=0; i< allLinks.length; i++) {
		allLinks[i].onmouseover = showPreview;
	}
}

function showPreview(evt) {
	if (evt) {
		var url = evt.target;
	}
	else {
		evt = window.event;
		var url = evt.srcElement;
	}
	xPos = evt.clientX;
	yPos = evt.clientY;
	
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
		
	}
	else {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) { }
		}
	}

	if (xhr) {
		xhr.onreadystatechange = showContents;
		xhr.open("GET", url, true);
		xhr.send(null);
	}
	else {
		alert("Sorry, but I couldn't create an XMLHttpRequest");
	}
	return false;
}

function showContents() {
	if (xhr.readyState == 4) {
		if (xhr.status == 200) {
			var outMsg = xhr.responseText;
			
		}
		else {
			var outMsg = "There was a problem with the request " + xhr.status;
		}

		var prevWin = document.getElementById("previewWin");
		prevWin.innerHTML = outMsg;
		prevWin.style.top = parseInt(yPos)+2 + "px";
		prevWin.style.left = parseInt(xPos)+2 + "px";
		prevWin.style.visibility = "visible";
		prevWin.onmouseout = function() {
		document.getElementById("previewWin").style.visibility = "hidden";
		}
	$('#previewWin').find('#my_header').html(' ');
	$('#previewWin').find("#grey_welcome").html(' ');
	$('#previewWin').find("#template_fieldset").remove();//html(' ');
	
	}
}
/*********************************************************************/

//document.getElementsByClassName = function(class_name) {
//    var docList = this.all || this.getElementsByTagName('*');
//    var matchArray = new Array();
//
//    /*Create a regular expression object for class*/
//    var re = new RegExp("(?:^|\\s)"+class_name+"(?:\\s|$)");
//    for (var i = 0; i < docList.length; i++) {
//        if (re.test(docList[i].className) ) {
//            matchArray[matchArray.length] = docList[i];
//        }
//    }
//
//	return matchArray;
//}//eof annonymous function

//Using a function:
	function cstmGetElementsByClassName(class_name) {
    var docList = this.all || this.getElementsByTagName('*');
    var matchArray = new Array();

	/*Create a regular expression object for class*/
    var re1 = new RegExp("(?:^|\\s)"+class_name+"(?:\\s|$)");
    for (var i = 0; i < docList.length; i++) {
        if (re1.test(docList[i].className) ) {
            matchArray[matchArray.length] = docList[i];
        }
	}

    return matchArray;
}//eof cstmGetElementsByClassName


