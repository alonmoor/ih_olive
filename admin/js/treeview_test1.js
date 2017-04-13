
/**To avoid name collision with others scripts, all variables and functions
are in the DBTreeView namespace*/
var DBTreeView = {};
var count=0;
DBTreeView.ATTRIBUTE_TAG = "Attribute";
DBTreeView.ATTRIBUTE_NAME_ATTR = "name";
DBTreeView.ATTRIBUTE_VALUE_ATTR = "value";

/************************************************ 
XMLChildrenRequest 
Children request XML data object
*/

/* Construtor*/
DBTreeView.XMLChildrenRequest = function(attributes){
	this.attributes = attributes; //associative array
}

/* Constants */
DBTreeView.XMLChildrenRequest.prototype.version = 1;
DBTreeView.XMLChildrenRequest.prototype.TAG = "ChildrenRequest";
DBTreeView.XMLChildrenRequest.prototype.VERSION_ATTR = "version";

/* ToElement returns DOM element. 
   'doc' is a DOM document.
*/
DBTreeView.XMLChildrenRequest.prototype.toElement = function(doc){
	 
	var elem = doc.createElement(this.TAG);
	elem.setAttribute(this.VERSION_ATTR, this.version);
	for(var key in this.attributes){
		 
		var attrElem = doc.createElement(DBTreeView.ATTRIBUTE_TAG);
		attrElem.setAttribute(DBTreeView.ATTRIBUTE_NAME_ATTR, key);
		attrElem.setAttribute(DBTreeView.ATTRIBUTE_VALUE_ATTR, this.attributes[key]);
		elem.appendChild(attrElem);
	}
	return elem;
}

/************************************************ 
/** XMLChildrenResponse constructor
attributes :
- version
- nodes (xmlnodes)
*/
DBTreeView.XMLChildrenResponse = function(){
	
}

/** XMLChildrenResponse constants*/
DBTreeView.XMLChildrenResponse.prototype.TAG = "ChildrenResponse";
DBTreeView.XMLChildrenResponse.prototype.VERSION = "version";

/** Parses a DOM element as XMLChildrenResponse.*/
DBTreeView.XMLChildrenResponse.getInstance = function(elem){
	
	var response = new DBTreeView.XMLChildrenResponse();
	
	if(elem.getAttribute(DBTreeView.XMLChildrenResponse.prototype.VERSION) != 1){
		throw "invalid version";
	}
	response.version = elem.getAttribute(DBTreeView.XMLChildrenResponse.prototype.VERSION)
	response.version = 1;
	response.nodes = new Array();//array of xmltreenode
	for(var i=0; i< elem.childNodes.length; i++){
	    var node = elem.childNodes[i];
	    
	    if(node.nodeType == 1){
			response.nodes.push(DBTreeView.XMLTreeNode.getInstance(node));
		}
	}
	return response;
}

/************************************************ 
/** XMLTreeNode constructor.
attributes
- text
- attributes
- imageOpen
- imageClosed
- URL
- URLTargetFrame
- hasChildren
- defaultOpen
- children
*/
DBTreeView.XMLTreeNode = function(text, attributes){
	this.text = text;
	this.attributes = attributes;
}

/** TreeNode constants.*/
DBTreeView.XMLTreeNode.prototype.TAG = "Node";
DBTreeView.XMLTreeNode.prototype.TEXT = "text";
DBTreeView.XMLTreeNode.prototype.IMAGE_OPEN = "openIcon";
DBTreeView.XMLTreeNode.prototype.IMAGE_CLOSED = "closedIcon";
DBTreeView.XMLTreeNode.prototype.URL = "URL";
DBTreeView.XMLTreeNode.prototype.URL_TARGET_FRAME = "URLTargetFrame";
DBTreeView.XMLTreeNode.prototype.HAS_CHILDREN = "hasChildren";
DBTreeView.XMLTreeNode.prototype.DEFAULT_OPEN = "isOpenByDefault";

/** Parses a DOM element and creates a XMLTreeNode object.*/
DBTreeView.XMLTreeNode.getInstance = function(elem){
	var XMLTreeNode = DBTreeView.XMLTreeNode;
	if(elem.nodeType != 1){
	  throw "Invalid <TreeNode>";
	}
    var xmlNode = new DBTreeView.XMLTreeNode();
	var attributes = new Array();
	var xmlChildren = new Array();
	
	var child = elem.firstChild;
	while(child!=null){
	  if(child.nodeName == DBTreeView.ATTRIBUTE_TAG){
		attributes[child.getAttribute(DBTreeView.ATTRIBUTE_NAME_ATTR)]= 
		         child.getAttribute(DBTreeView.ATTRIBUTE_VALUE_ATTR);
	  }else if(child.nodeName == this.prototype.TAG){
	    xmlChildren.push(DBTreeView.XMLTreeNode.getInstance(child));
	  }else{
	  	throw "Invalid node";
	  }
	  child = DBTreeView.nextSiblingElement(child);
	 }
	 
	 xmlNode.text = elem.getAttribute(XMLTreeNode.prototype.TEXT);
	 xmlNode.imageOpen = elem.getAttribute(XMLTreeNode.prototype.IMAGE_OPEN);
	 xmlNode.imageClosed = elem.getAttribute(XMLTreeNode.prototype.IMAGE_CLOSED);
	 xmlNode.URL = elem.getAttribute(XMLTreeNode.prototype.URL);
	 xmlNode.URLTargetFrame = elem.getAttribute(XMLTreeNode.prototype.URL_TARGET_FRAME);
	 xmlNode.hasChildren = (elem.getAttribute(XMLTreeNode.prototype.HAS_CHILDREN)=="false") ? false : true; 
     xmlNode.defaultOpen = (elem.getAttribute(XMLTreeNode.prototype.DEFAULT_OPEN)=="false") ? false : true;
	 xmlNode.attributes = attributes;
	 xmlNode.children = xmlChildren;  
	 return xmlNode;

}

/**********************************************/

DBTreeView.Listener = function(){
};

DBTreeView.Listener.openNode = function(){
	this.node.openNode();
}
DBTreeView.Listener.closeNode = function(){
	this.node.closeNode();
}
/************************************************ 
TreeNode constructor. elem is the <div> HTML element.
Properties: 
- treeView : the treeview object
- elem : the <div> element of the node
- hasChildren
- children (new): the TreeNode objects 
- isExpanded
- expImgElem (expand <img> element)
- iconImgElem
- attributes
- text
- imageOpen
- imageClosed
- URL
- URLTargetFrame
- hasChildren
- defaultOpen
- isExpanded
- isRoot (boolean)

methods :
getImageOpen()
getImageClosed()

*/
DBTreeView.TreeNode = function(treeView, elem){
	this.treeView = treeView;
	this.elem = elem; //<div> element.
	this.isRoot = false;                                                
}
/******************************************************************************************************************************************************/
DBTreeView.TreeNode.prototype.getImageOpen = function(){
   return (this.imageOpen !=null) ? this.imageOpen : this.treeView.defaultImageOpen;
}
/******************************************************************************************************************************************************/
DBTreeView.TreeNode.prototype.getImageClosed = function(){
   return (this.imageClosed !=null) ? this.imageClosed : this.treeView.defaultImageClosed;
}
/******************************************************************************************************************************************************/
DBTreeView.TreeNode.prototype.openNode = function(){
	//check if node
	var node = this;
	if(!this.hasChildren){
		alert("Bug: has no children (openNode)");
		//to do : remove + symbol
		return;
	}
	if(this.children == null){
		this.isExpanded=true; //require
	    this.expImgElem.src = this.treeView.waitImgSrc;
	    
		//retrieves nodes (may be empty)
		var attributes = this.attributes;
		
		//prepare callback
		var callback = function(response){
			if(response.nodes.length>0){
				node.displayChildren(response.nodes);
				node.isExpanded=true;
				node.expImgElem.src=node.treeView.minusImgSrc;
				node.expImgElem.onclick=DBTreeView.Listener.closeNode;
				node.iconImgElem.src=node.getImageOpen();
				node.iconImgElem.onclick=DBTreeView.Listener.closeNode;
			}else{
			 //hide expander
			 node.expImgElem.src=this.treeView.emptyImgSrc;
			 node.expImgElem.onclick=null;
			 node.expImgElem.style.cursor = "";
			 node.iconImgElem.onclick=null;
			 node.iconImgElem.style.cursor = "";
			}
		}
		DBTreeView.query(attributes, this.treeView.script, callback);
	}
	else{
		//display nodes
		for(var i in this.children){
			this.children[i].elem.style.display="block";
		}
		this.isExpanded=true;
		this.expImgElem.src=this.treeView.minusImgSrc;
		this.expImgElem.onclick=DBTreeView.Listener.closeNode;
		this.iconImgElem.src=this.getImageOpen();
		this.iconImgElem.onclick=DBTreeView.Listener.closeNode;
	}
}
/******************************************************************************************************************************************************/
DBTreeView.Listener.closeNode = function(){
	var node = this.node;
	if(!node.hasChildren){
		//to do : remove + symbol
		return;
	}
	if(node.children == null){
	   alert("node.children=null ??");
	}
	else{
		for(var i in node.children){
			var nodeElem = node.children[i].elem;
			nodeElem.style.display="none";
		}
		node.isExpanded=false;
		node.expImgElem.src=node.treeView.plusImgSrc;
		node.expImgElem.onclick=DBTreeView.Listener.openNode;
		node.iconImgElem.src=node.getImageClosed();
		node.iconImgElem.onclick=DBTreeView.Listener.openNode;
	}
	
}
/************************************************************************************************************/
/*************************************DISPLAY DATA***********************************************************/
DBTreeView.TreeNode.prototype.displayChildren = function(xmlnodes){
 	var parentNode = this;
 	var treeView = this.treeView;
 	for(var j=0; j<xmlnodes.length;j++){
		var xmlnode = xmlnodes[j];
		var nodeElem = document.createElement("div");
		var node = new DBTreeView.TreeNode(treeView, nodeElem);
		if(!this.isExpanded){
			nodeElem.style.display = "none";
		}
		if(parentNode.isRoot){ 
			nodeElem.className = "primaryNode";
		}else{
			nodeElem.className = "subNode";
		}
		
		//if hasChildren and nodes don't match => nodes has priority
		
		node.parentNode = parentNode;
		node.treeView = parentNode.treeView;
		node.text = xmlnode.text;
		
		
		//alert( xmlnode.URL);
	 	// node.text =  '<a href="/alon-web/olive_prj/admin/find3.php?mode=search_dec&decID=1"  class="href_modal1"> '+xmlnode.text+' </a>';
	   // node.text =  '<a  '+node.URL+'  class="href_modal1"> '+xmlnode.text+' </a>';
	//	node.text =  '<a  '+xmlnode.URL+'  class="href_modal1"> '+xmlnode.text+' ';
		
		
		node.imageOpen = xmlnode.imageOpen;
		node.imageClosed = xmlnode.imageClosed;
		node.URL = xmlnode.URL;
		node.URLTargetFrame = xmlnode.URLTargetFrame;
		//by default, a node has children.
		node.hasChildren = (xmlnode.hasChildren != null && xmlnode.children.length < 1) ? xmlnode.hasChildren : true ;
		node.defaultOpen = xmlnode.defaultOpen;
		node.attributes = xmlnode.attributes;
		//not expanded if no information on nodes are send by server
		node.isExpanded = (xmlnode.children.length > 0 && node.defaultOpen);
		
		node.children = null; //content all the TreeNode children

		//update parent node
		if(parentNode.children == null){
		 	parentNode.children = new Array();
		}
		parentNode.children.push(node);
		
		//node table
		var tableElem = document.createElement("table");
		tableElem.className = "tvNodeTable";
		
		//tableElem.cellPadding = 0;
		tableElem.cellSpacing = 0;

		
		//bug IE 7
		//var rowElem = document.createElement("tr");
		//tableElem.appendChild(rowElem); 
		var rowElem = tableElem.insertRow(0);
		rowElem.vAlign="top";
		rowElem.className = "page_tr";
		
		//expander image
		var expCellElem = document.createElement("td");
		var expImgElem = document.createElement("img");
		expImgElem.className="tvExpander";
		expImgElem.style.cursor = "pointer";
		var expImgSrc;
		if(!node.hasChildren){
			expImgSrc = treeView.emptyImgSrc;
			expImgElem.style.cursor = "";
			
	    }else if(node.isExpanded){
	        expImgSrc = treeView.minusImgSrc;
	        expImgElem.onclick = DBTreeView.Listener.closeNode;
		}else{
		    expImgSrc = treeView.plusImgSrc;
		    expImgElem.onclick = DBTreeView.Listener.openNode;
		}
		expImgElem.node = node;
		expImgElem.src = expImgSrc;
		
		
		expCellElem.appendChild(expImgElem);
		rowElem.appendChild(expCellElem);
		node.expImgElem = expImgElem;
		
		//image (icon) : 
		var iconCellElem = document.createElement("td");
		var iconImgElem = document.createElement("img");
		iconImgElem.className="tvIcon";
		if(node.hasChildren){
		iconImgElem.style.cursor = "pointer";
		}
		var iconImgSrc;
		if(!node.hasChildren){
	       //closed not clicable
			iconImgSrc = node.getImageClosed();
			//iconImgElem.onclick = "";		
		}else if(node.isExpanded){
			//open
			iconImgSrc = node.getImageOpen();
			iconImgElem.onclick = DBTreeView.Listener.closeNode;
	    }else{
	       //closed
			iconImgSrc = node.getImageClosed();
			iconImgElem.onclick = DBTreeView.Listener.openNode;
		}
		iconImgElem.node = node;
		iconImgElem.src = iconImgSrc;

		iconCellElem.appendChild(iconImgElem);

		node.iconImgElem = iconImgElem;
	    rowElem.appendChild(iconCellElem);
	
/****************************DEALING WITH IFREAMS*****************************************************/	
/*****************************************************************************************************/	    
		//text :
	    var textCellElem = document.createElement("td");
		textCellElem.className = "nodeText";
/******************************************************************************************************/		
	//	if(!(this.elem.baseURI=="http://alon-dev.eh/alon-web/olive_prj/admin/subject_tree.php#")){
	 	if(!(this.treeView.id=="treev_subject")){
		
		
		if(node.URL !=null){
			var aElem = document.createElement('a');
			
		 	
	  	
			aElem.setAttribute('href', '#'); 
		     if(node.attributes.catID){
		    	var treeID=node.attributes.catID ;
		    	//aElem.setAttribute('class', 'href_modal_cat_forum');
		    	aElem.className = "href_modal_cat_forum";
		     }
		     else if(node.attributes.decID){
		    	var treeID=node.attributes.decID ;
		   //  aElem.setAttribute('class',  'href_modal_dec');
		    	aElem.className = "href_modal_dec";	
		   
		     
		     }
		     
		     else if(node.attributes.forum_decID){
		    	var treeID=node.attributes.forum_decID ;
		    	 //aElem.setAttribute('class', 'href_modal_forum_dec');
		    	 aElem.className = "href_modal_forum_dec";
		    	// aElem.setAttribute('style','color: #00cc00')
		     }else if(node.attributes.managerID){
			    	var treeID=node.attributes.managerID ;
			    	//aElem.setAttribute('class', 'href_modal_manager');
			    	aElem.className = "href_modal_manager";
			 }else if(node.attributes.managerTypeID){
			    	var treeID=node.attributes.managerTypeID ;
			    	//aElem.setAttribute('class', 'href_modal_managerType');
			    	aElem.className = "href_modal_managerType";
			 }else if(node.attributes.appointID){
			    	var treeID=node.attributes.appointID ;
			    	//aElem.setAttribute('class', 'href_modal_appoint');
			    	aElem.className = "href_modal_appoint";
			 }else{
			
		    	// aElem.setAttribute('class', 'href_modal2');
		    	 aElem.className = "href_modal2";
		     }
		 
		     
		     
		     
		     aElem.setAttribute('id',  treeID ); 
		     
			  //aElem.setAttribute('onClick', 'openmypage2("' + node.URL+ '");return false;');
		     if (document.implementation && document.implementation.createDocument)
		 	{
		    	 aElem.setAttribute('onClick', 'openmypage2("' + node.URL+ '");return false;');
		 	}
		 	else if (window.ActiveXObject)
		 	{
		 		// aElem.setAttribute('onclick', function() { openmypage2(  node.URL  );return false; });
		 		aElem.href = "javascript:openmypage2('" + node.URL+ "');";
		 	}
		  	else
		 	{
		 		alert('Your browser can\'t handle this script');
		 		return;
		 	}
			 
			
		
			if(node.URLTargetFrame !=null){
				aElem.target = node.URLTargetFrame;
			}
			aElem.innerHTML = node.text;
			
			textCellElem.appendChild(aElem);
		}else{
			textCellElem.innerHTML = node.text;
		}
	
		
		
		
		
		
}else{
	if(node.URL !=null){
		var aElem = document.createElement("a");
		var treeID=node.attributes.catID ;
    	aElem.setAttribute('class', 'href_modal_cat_forum');
		aElem.href = node.URL;
		if(node.URLTargetFrame !=null){
			aElem.target = node.URLTargetFrame;
		}
		aElem.innerHTML = node.text;
		textCellElem.appendChild(aElem);
	}else{
		textCellElem.innerHTML = node.text;
	}
	
	
	
}		
		
		
		
		
		rowElem.appendChild(textCellElem);

		nodeElem.appendChild(tableElem);
		if(xmlnode.children != null){
		   node.displayChildren(xmlnode.children);
		}		
		//nodeElem.appendChild(textNode);//print one node on the screen
		parentNode.elem.appendChild(nodeElem);
	}
}
/****************************************************************************************************/
/****************************************************************************************************/
function debugXML(elem){
    alert(xmlContent(elem));
}

/******************************************************************************************************************************************************/
/**
 * Tree View object
 attributes: 
 - loadingMessage
 - waitImgSrc
 - minusImgSrc
 - plusImgSrc
 - emptyImgSrc
 - id
 - attributes
 - script
 - rootNode (virtual root node)
 - defaultImageOpen
 - defaultImageClosed
 */
DBTreeView.TreeView = function(params){
	
	treeView = this;
	
	//params reading
	treeView.id = params.id;
	treeView.loadingMessage = (params.loadingMessage != null) ? params.loadingMessage : "<img src=\""+params.waitImgSrc +"\" /> Loading...";
	treeView.root = params.root; //object with text, icon, URL, URLTargetFrame
	treeView.defaultImageOpen = params.defaultImageOpen;
	treeView.defaultImageClosed = params.defaultImageClosed;
	treeView.minusImgSrc = params.minusImgSrc;
	treeView.waitImgSrc = params.waitImgSrc;
	treeView.plusImgSrc = params.plusImgSrc;
	treeView.emptyImgSrc = params.emptyImgSrc;

	var rootAttributes = params.attributes;
	treeView.script = params.script;	
	
/************************************/	
	//process                       */
/************************************/	
		  
 document.write("<div class=\"treeView\" id=\""+treeView.id+"\">"+treeView.loadingMessage+"</div>");
    var tvElem = document.getElementById(treeView.id);
	//prepare callback
	var callback = function(response){
		tvElem.innerHTML=""; //delete loading

		//display the root elem if asked
		if(treeView.root !=null && treeView.root.text !=null){
				
			//node table
			var tableElem = document.createElement("table");
			tableElem.className = "tvNodeTable";
			tableElem.cellSpacing = 0;
			var rowElem = tableElem.insertRow(0);
			rowElem.vAlign="top";
			rowElem.className = "page_tr";
		
			//image (icon) : 
			var iconCellElem = document.createElement("td");
			var iconImgElem = document.createElement("img");
			iconImgElem.className="tvIcon";
			iconImgElem.src = (treeView.root.icon != null) ? treeView.root.icon : treeView.defaultImageOpen;
			
			iconCellElem.appendChild(iconImgElem);
		    rowElem.appendChild(iconCellElem);
		
			//text :
			var textCellElem = document.createElement("td");
			textCellElem.className = "nodeText";
			if(treeView.root.URL !=null){
				var aElem = document.createElement("a");
				aElem.href = this.root.URL;
				if(treeView.root.URLTargetFrame !=null){
					aElem.target = treeView.root.URLTargetFrame;
				}
				aElem.innerHTML = treeView.root.text;
				textCellElem.appendChild(aElem);
			}else{
				textCellElem.innerHTML = treeView.root.text;
// 				textCellElem.style.setProperty('background-color', 'yellow', '');
//				textCellElem.style.setProperty('color', 'purple', '');
//				textCellElem.style.setProperty('font-weight', 'bold', '');
//				textCellElem.style.setProperty('font-size', '20px', '');
				textCellElem.style.cssText = 'font-size:20px; color:purple;';
				
			}
			rowElem.appendChild(textCellElem);
				
			tvElem.appendChild(tableElem);

		}
		
		var rootNode = new DBTreeView.TreeNode(treeView, tvElem);
		rootNode.isRoot = true;
		rootNode.isExpanded = true;
		//rootNode.hasChildren = true;
		treeView.rootNode = rootNode;
		rootNode.displayChildren(response.nodes);
	}
	
	//query
	DBTreeView.query(rootAttributes, treeView.script, callback);
}
/********************************************************SEND REQUEST*************************************************************************************/
/**Asynchronous query. 
  *Return without value. 
  *Call callback with reponse element
  *if script is null, the same page is called.
  */
DBTreeView.query = function(attributes, script, callback){
	//prepare request
	var request = new DBTreeView.XMLChildrenRequest(attributes);
	var doc = DBTreeView.newDoc();
	var elem = request.toElement(doc);
	doc.appendChild(elem);

	 
	//send request
	var xmlhttp = DBTreeView.getHTTPObject();

		

	
	xmlhttp.onreadystatechange = function (){
		
		if(xmlhttp.readyState == 4){
			
   			if(xmlhttp.status!=200){
   				alert("Problem retrieving XML data");
   			}
   		try{
			var responseElem = xmlhttp.responseXML.documentElement;
			//alert(xmlhttp.responseXML.documentElement);
			var response = DBTreeView.XMLChildrenResponse.getInstance(responseElem);
			callback(response);
			}catch(e){
				var text = xmlhttp.responseText;
				 alert("Error:\n bad server response: "+e+"\nData:"+text);
	         }
		if(count==0)	
			pagging();
		count++;
		}
	}
	
	
	
	
	if(script!=null){
		xmlhttp.open("POST", script, true);
	}else{
		xmlhttp.open("POST", location.href, true);
	}
	//alert("Server send: "+DBTreeView.xmlContent(doc));

	xmlhttp.send(doc);

}

/******************************************************************************************************************************************************/

//---------
//DOM TOOLS
//---------

/** Returns the next sibling element of a given node.*/
DBTreeView.nextSiblingElement = function(node){

	var next = node.nextSibling;
	while(next!=null && next.nodeType!=1){
	   next = next.nextSibling;
	}
	return next;
}

/******************************************************************************************************************************************************/
/** Returns a new DOM document (works in IE and Firefox).*/
DBTreeView.newDoc = function(){
	if (document.implementation && document.implementation.createDocument)
	{
		return document.implementation.createDocument("", "", null);
	}
	else if (window.ActiveXObject)
	{
		return new ActiveXObject("Microsoft.XMLDOM");
	}
 	else
	{
		alert('Your browser can\'t handle this script');
		return;
	}
}
	
/******************************************************************************************************************************************************/	
/** Returns the XML HTTP Request object (works in IE and Firefox).*/
DBTreeView.getHTTPObject = function() {
  var xmlhttp;

    if(window.XMLHttpRequest) { //pour ffox et mozilla
	    	try {
				xmlhttp = new XMLHttpRequest();
	        } catch(e) {
				xmlhttp = false;
	        }
	   
    } else if(window.ActiveXObject) { //pour ie
       	try {
        	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
      	} catch(e) {
        	try {
          		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        	} catch(e) {
          		xmlhttp = false;
        	}
		}
    }
	return xmlhttp;
}
	
/******************************************************************************************************************************************************/				
/** Serializes an XML DOM object into a string.*/
DBTreeView.xmlContent = function(xmlObj) {
	if(xmlObj.xml){
		return 	xmlObj.xml;
	}
	else {
		var serializer = new XMLSerializer();
		return serializer.serializeToString(xmlObj);
	}
}

/******************************************************************************************************************************************************/
function openmypage2(link){  
	 
	 ajaxwin=dhtmlwindow.open("ajaxbox", "ajax", link, "נתונים מהמערכת", "width=1000px,height=600px,left=100px,top=100px,resize=1,scrolling=1");
	 ajaxwin.onclose=function(){ //Run custom code when window is about to be closed
	  return true;
	 
  } 
}
/******************************************************************************************************************************************************/
function pagging(){
	
	
	/******************************************************************************************************************************************************/
	// $('form.paginated').each(function() {
	//
	// 	//SET PAGER VARS
	// 	var currentPage = 0;
	// 	var numPerPage = 10;
	// 	//STORE EVENT CONTEXT, $ul
	// 	var $form = $(this);
	//
	// 	//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
	// 	$form.bind('repaginate', function() {
	// 		$form.find('div.primaryNode').show()
	// 			.slice(0, currentPage * numPerPage)
	// 				.hide()
	// 			.end()
	// 			.slice((currentPage + 1) * numPerPage)
	// 				.hide()
	// 			.end();
	// 	});
	// 	//CALCULATE NUMBER OF PAGES, numRows / numPerPage
	// 	var numRows = $form.find('div.primaryNode').length;
	// 	var numPages = Math.ceil(numRows / numPerPage);
	// 	//CREATE PAGE NUMBERS, THEN insertAfter($ul)
	// 	var $pager = $('<div class="pager"></div>');
	// 	for (var page = 0; page < numPages; page++) {
	// 		$('<span class="page-number">' + (page + 1) + '</span>')
	// 		.bind('click', {'newPage': page}, function(event) {
	// 			currentPage = event.data['newPage'];
	// 			$form.trigger('repaginate');
	// 			$(this).addClass('active').siblings().removeClass('active');
	// 			$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : '#0063DC'}).removeClass('hover') ;
	// 		})
	// 		.appendTo($pager).addClass('clickable').css({'border' : 'solid #C81ED2 3px'})
	// 		.css({'float' : 'right'})
	// 		.css({'color' : 'red'})
	// 		;
	// 	}
	// 	$pager.find('span.page-number:first').addClass('active').css({'border' : 'solid #C81ED2 3px'})
	// 	 .css({'margin-right' : '30px'})
    	// .css({'top' : '200px'}) ;
	// 	$pager.insertAfter($form);
	// 	//TRIGGER EVENT
	// 	$form.trigger('repaginate');
	// });
/******************************************************************************************************************************************************/		
	
	
	
}