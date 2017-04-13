 <?php

 

if( is_numeric($id)) {
	 
	// edit mode...
	$title = "ערוך החלטה";
	$submit_val = "..לחץ לעידכון";
	
       $dec = new decision ($id);
 	$dec->load_from_db();
} else { 
 	 	$title = "update decision";
       $submit_val = "Press to update decision";
 	    $dec = new decision($_GET['decID'],$_POST['decName'],$_POST['subdecision']);
  	
// 	$dec->load_from_db();
 }

   ?>  
<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">
	<input type=hidden name=mode value=<?php echo $mode ?>>
	<input type=hidden name=id value=<?php echo $dec->getId() ?>> 
  <table>
  	<tr><th><?php echo $title ?></th></tr>
  	<tr>
  		<td>שם החלטה</td>
  		<td><input type="text" name="decName" size=50 value="<?php echo $dec->getName() ?>" /></td>
  		 
  		
  	</tr>
   <tr>
  		<td></td>
  		<td></td>		
   </tr>
   <tr>
   		<td colspan=2 align=center>
   			<input type="submit" name="submit" value="<?php echo $submit_val ?>" />
   		</td>
   	</tr>	
   </table>
</form>



 