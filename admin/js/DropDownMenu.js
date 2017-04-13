var objNavMenu = null;
var prevObjNavMenu = null;
var prevObjDropMenu = null;
var numDropMenu = 6;
////// link styles
var bgLinkColor = '#000';
var bgLinkHover = '#f00';
var bgLinkActive = '#900';
var linkColor = '#fff';
var linkHover = '#fff';
var linkActive = '#fff';

var isIE = null;
if (navigator.appName.indexOf('Microsoft Internet Explorer') != -1) isIE=1;

function initDropMenu () {
	document.onclick = hideDropMenu;
	for (i=1; i<=numDropMenu; i++) {
		menuName = 'dropMenu' + i;
		navName = 'navMenu' + i;
		objDropMenu = document.getElementById(menuName);
		objNavMenu = document.getElementById(navName);
		objDropMenu.style.visibility = 'hidden';
		objNavMenu.onmouseover =  showDropMenu;
		objNavMenu.onmouseout = menuOut;
		objNavMenu.onclick = showDropMenu;
	}
	objNavMenu = null;
	return;
}


function menuOut (e) {
	document.onclick = hideDropMenu;
	outObjNavMenu = document.getElementById(this.id);
	if (outObjNavMenu != objNavMenu) {
		outObjNavMenu.style.color = linkColor;
		outObjNavMenu.style.backgroundColor = bgLinkColor;
	}
}

function showDropMenu(e) {
	menuName = 'drop' + this.id.substring(3,this.id.length);
	objDropMenu = document.getElementById(menuName);
	if (prevObjDropMenu == objDropMenu) {
			hideDropMenu();
		return;
	}
	if (prevObjDropMenu != null) hideDropMenu();
	objNavMenu = document.getElementById(this.id);
	if ((prevObjNavMenu != objNavMenu ) || (prevObjDropMenu == null)) {
		objNavMenu.style.color = linkActive;
		objNavMenu.style.backgroundColor = bgLinkActive;
	}
	//if (objDropMenu || !(objNavMenu.offsetParent) || objNavMenu.offsetParent==null) {
	if (objDropMenu) {
		//w.css({ position: 'absolute', top: offset.top+el.offsetHeight-1, left: offset.left , 'min-width': $(el).width() }).show();
			 
		xPos = objNavMenu.offsetParent.offsetLeft + objNavMenu.offsetLeft;
		yPos = objNavMenu.offsetParent.offsetTop + objNavMenu.offsetParent.offsetHeight;
		if (isIE) {
			yPos -= 1;
			xPos -= 6;
		}
//		objDropMenu.style.left = xPos + 'px';
		objDropMenu.style.left = xPos + 'px';
	//	objDropMenu.style.right = xPos + 'px';
		objDropMenu.style.top = yPos + 'px';
	 	objDropMenu.style.visibility = 'visible';
		//objDropMenu.style.display = 'block';
		prevObjDropMenu = objDropMenu;
		prevObjNavMenu = objNavMenu;
	}

}

function hideDropMenu() {
	document.onclick = null;
	if (prevObjDropMenu) {
		prevObjDropMenu.style.visibility = 'hidden';
		prevObjDropMenu = null;
		prevObjNavMenu.style.color = linkColor;
		prevObjNavMenu.style.backgroundColor = bgLinkColor;
	}
	objNavMenu = null;
}

 // window.onload=initDropMenu;
