<?php
function renderList3($iCnt=0, $aData='') {
    
    global $iCursor, $iPerm;
?>
<br />
<?php   if (is_array($aData)) { ?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">

<table width="608" border="0" cellpadding="0" cellspacing="0">
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
    <tr>
        <td width="348" colspan="2"><div><strong>משימות</strong></div></td>
        
        <td width="90"><div><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
        <td width="170"><div><strong>תאריך</strong></div></td>
    </tr>
    
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
    <tr>
        <td  colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
                                        
    </tr>
    
   
   	<tr>
   	
   	</tr>  
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->   	
    <?php
    // loop through data and conditionally display functionality and content
    $i = 0;
    
    while ($i < count($aData)) {
        
        $aState = array("act", "deact");
    ?>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
<tr id="tr_<?php echo  $aData[$i]->id ?>">
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
    <td width="16" >
     <div<?php print $aData[$i]->status  ?>">  
      <!--<a href="dynamic_5.php?action=<?php print $aState[$aData[$i]->status] ?>&id=<?php print $aData[$i]->id ?>" onclick="return verify();">  -->  
        
        <a  href="void" onclick="return verify() && activation_task(<?php echo $aData[$i]->id;?>,'<?php echo $aState[$aData[$i]->status] ;?>') && 0 ;return false; ">
        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]->status?>.gif" width="16" height="10" alt="" border="0" /> </a> 
        
      </div>
    </td>
 <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->    
        <td width="332" >
        
          <div>   
         
          <input type="text" class="mycontrol" size=20 name="description" 
             value="<?php print format($aData[$i]->description )?>">  
          </div>
        </td>
        
        
     
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
 <td width="90">        
<!--    <a href="drag-and-drop.php?m=updateTask&id=<?php print $aData[$i]->id?>" >
        <b>ערוך</b>
        </a>&nbsp;|&nbsp;
        <a href="void" onclick="sendRequest(<?php echo $aData[$i]->id?>)" >
        <a href="drag-and-drop.php?action=updateTask&id=<?php print $aData[$i]->id?>" >
        <b>ערוך</b>
        </a>&nbsp;|&nbsp;   -->
          
          
      <a href="drag-and-drop.php?action=updateTask&id=<?php print $aData[$i]->id?>" onclick="sendRequest(<?php echo $aData[$i]->id?>)" >
        <b>ערוך</b>
      </a>&nbsp;|&nbsp; 
          
 <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->         
         
        <a  href="void" onclick="return verify() && delete_task(<?php echo $aData[$i]->id?>) && 0 ;return false; ">
        <b>מחק</b> 
        </a>
           
     </td>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->       
        <td width="170" >
          <div  <?php print $aData[$i]->status ?>"><?php print date("d-m-Y H:i:s" , strtotime($aData[$i]->created_dt) ) ?>
          </div>
        </td>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->        
</tr>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
    
    <tr>
        <td  colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
    ?>
    
</table>
<!--------------------------------------------------------------------------------------------------------  -->
<script type="text/javascript">
function deactivation_task(task_id) {
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id: task_id ,action: 'eact'},
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	    },
	
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	
	
	return false;
} 

</script>
<!-- ------------------------------------------------------------------------------------------------------ -->
<script type="text/javascript">
function activation_task(task_id,aState) {
	//alert(aState);
	var decID = document.getElementById("decID").value;
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
		  
	    method:'get',
	    parameters: {id: task_id ,decID:decID,action:  aState },
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	    },
	
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	
	
	return false;
} 

</script>
<!-- --------------------------------------------------------------------------------------------------- -->
<script type="text/javascript">
		        
        function requestCustomerInfo() {
            var sId = document.getElementById("txtCustomerId").value;
            var oOptions = {
                method: "get",
                parameters: "id=" + sId,
                onFailure: function (oXHR, oJson) {
                    alert("An error occurred: " + oXHR.status);
                }
            };
            var oRequest = new Ajax.Updater({ 
                success: "divCustomerInfo"
            }, "GetCustomerData.php", oOptions);
        }
		     
    </script>
    
<!-- --------------------------------------------------------------------------------------------------- -->    
<script type="text/javascript">

        function sendRequest(task_id) {
        	var decID = document.getElementById("decID").value;
            var oOptions = {
                method: "get",
                parameters:{ id: task_id ,decID:decID,action:'updateTask'},
                onSuccess: function (oXHR, oJson) {
                    saveResult(oXHR.responseText);
                },
                onFailure: function (oXHR, oJson) {
                    saveResult("An error occurred: " + oXHR.statusText);
                }
            };
                    
            var oRequest = new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php', oOptions);      
        }
                
        function saveResult(sMessage) {
            var divStatus = document.getElementById("divStatus");
            divStatus.innerHTML = "Request completed: " + sMessage;            
        }
    </script>
<!-- --------------------------------------------------------------------------------------------------- -->



<script type="text/javascript">
function delete_task(task_id) {
	//alert(task_id);
     var decID = document.getElementById("decID").value;
      
    var li = document.getElementById('li_'+task_id).value ;
    // alert(li);
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id: task_id ,decID:decID,action: 'delTask'},
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	       // alert("Success! \n\n" + response);
	       $('tr_'+task_id).remove();
	       
	       $('li_'+task_id).remove();
	       alert(liItem); 
	    },
	
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	
	
	return false;
}
</script>

<!-- --------------------------------------------------------------------------------------------------- -->

<!--<script type="text/javascript">-->
<!--function update_task(task_id) {-->
<!--	//alert(task_id);-->
<!--     var decID = document.getElementById("decID").value;-->
<!--     alert(decID);-->
<!--	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',-->
<!--	  {-->
<!--	    method:'get',-->
<!--	    parameters: {id: task_id ,decID:decID,action: 'updateList'},-->
<!--	    onSuccess: function(transport){-->
<!--	        var response = transport.responseText || "no response text";-->
<!--	       // alert("Success! \n\n" + response);-->
<!--	      // $('tr_'+task_id).remove();-->
<!--	       -->
<!--	    },-->
<!--	-->
<!--	    onFailure: function(){ alert('Something went wrong...') }-->
<!--	  });-->
<!--	-->
<!--	-->
<!--	return false;-->
<!--}-->
<!--</script>-->




</form>


<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->

 
<?php } else { ?>
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
       <?php show_error_msg("אין משימות כרגע."); ?> 
    </tr>
</table>

<?php } // end condition ?>
<?php } // end function ?>
$(document).ready(function(){
 
	$('#date_picker').datepicker( $.extend({}, {
				showMonthAfterYear: false,
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd'
				
				}, $.datepicker.regional['he']));
 });
 
 
 
  $(document).ready(function(){
	           	$('#appoint_date').datepicker( $.extend({}, {showOn: 'button',
		                               buttonImage: '/images/calendar.gif', buttonImageOnly: true,
		                               changeMonth: true,
				                       changeYear: true,
				                       dateFormat: 'yy-mm-dd'}, $.datepicker.regional['he'])); 
                 	});

 
 	?> 
