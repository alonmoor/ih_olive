/* 
#	SelectObjectMethods.js
#	handle select boxes with the arrows...
#
#	yahel 18/4/07
# based on Einav code..
###########################################################*/

function add_item_to_select_box(src_cmb, dest_cmb_obj) {
		for (j=0 ; j<src_cmb.length;j++){
			if (src_cmb.options[j].selected == true) {
				if(!itemsInSelect(src_cmb.options[j].value, dest_cmb_obj)){
					new_item = dest_cmb_obj.length;
					dest_cmb_obj.options[new_item] = new Option(src_cmb.options[j].text,src_cmb.options[j].value);
					//src_cmb.options[j] = null;
				} else{
				    alert('פריט כבר קיים');
					return;
				}
	        }
		}
	}			


/****************************************************************************************/
function remove_item_from_select_box(cmb_obj) {
 
	for (j=cmb_obj.length-1; j>=0; j--){
		if (cmb_obj.options[j].selected == true) {						
			cmb_obj.options[j] = null;
		}
	}
}
/**************************************************************************************/

function clear_select_box(cmb_obj) {
	for (j=cmb_obj.length-1; j>=0; j--)
		cmb_obj.options[j] = null;
}
/**************************************************************************************/
				
function itemsInSelect(check_me, cmb_obj){		
	for ( i=0; i<cmb_obj.length ; i++){
		if (cmb_obj.options[i].value == check_me ) 
			return true;	            
	}
	return false;
}
/**************************************************************************************/

function prepSelObject(oSel){
	   //alert(oSel);
	for (j=oSel.length-1; j>=0; j--){		
		oSel.options[j].selected = true;		
	}
}			
/**************************************************************************************/


function add_element_to_select_box(select_box_obj, item_txt, item_value) {
	var new_item = dest_cmb_obj.length;
	select_box_obj.options[new_item] = new Option(item_txt, item_value);
}
 
//function add2list(sourceID,targetID){
//	  source=document.getElementById(sourceID);
//	 
//	  target=document.getElementById(targetID);
//	//  alert(target);
//	  numberOfItems=source.options.length;
//	  insertPt=target.options.length; // insert at end
//	  if(target.options[0].text===""){insertPt=0;} // null option fix
//	  for(i=0;i<numberOfItems;i++){
//	    if(source.options[i].selected===true){
//	    msg=source.options[i].text;
//	    for(j=0;j<target.options.length;j++){
//	      if(msg===target.options[j].text){j=99;}}
//	    if(j<99){    
//	      target.options[insertPt]=new Option(msg);
//	      insertPt=target.options.length;}
//	    }}
//	}
//
//function add2list1(sourceID,targetID){
//	  source=document.getElementById(sourceID);
//	 
//	  target=document.getElementById(targetID);
//	//  alert(target);
//	  numberOfItems=source.options.length;
//	  insertPt=target.options.length; // insert at end
//	  if(target.options[0].text===""){insertPt=0;} // null option fix
//	  for(i=0;i<numberOfItems;i++){
//	    if(source.options[i].selected===true){
//	    msg=source.options[i].text;
//	    for(j=0;j<target.options.length;j++){
//	      if(msg===target.options[j].text){j=99;}}
//	    if(j<99){    
//	      target.options[insertPt]=new Option(msg);
//	      insertPt=target.options.length;}
//	    }}
//	}
//
//
//	function takefromlist(targetID){
//	  target=document.getElementById(targetID);
//	  if(target.options.length<0){return;}
//	  for(var i=(target.options.length-1);i>=0;i--){
//	    if(target.options[i].selected){
//	      target.options[i]=null;
//	      if(target.options.length===0){target.options[0]=new Option("");}
//	    }}
//	}

