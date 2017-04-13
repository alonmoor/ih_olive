<?php
require_once ("header.php");
 
  global $iCursor, $iPerm,$db;	


/********************************************************************************/
 $sql="select * from FORUM    ORDER BY FORUM_NAME ASC, FORUM_ID ASC ";	
 $mysqli=$db->getMysqli();
 $result = $mysqli->query($sql);
 
 if ($total =mysqli_num_rows($result))
    {
    $start = (isset($_GET['cursor']) && ctype_digit($_GET['cursor']) && $_GET['cursor'] <= $total) ? $_GET['cursor'] : 0;
     mysqli_data_seek($result, $start);
    }
/**********************************************************************************/   		


 
?>
<br />

<form  style="width:95%;overflow:auto;" dir="rtl" action="<?php echo $_SERVER['SCRIPT_NAME']?>"  method="post"> 
<fieldset   style="width:95%;overflow:auto; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table >


     
        
         <span >
          <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=add_msgForum" style="float:right;" class="my_href_li">
            <img src="<?php echo IMAGES_DIR ?>/buttons/btn_additem.gif" width="80" height="30" alt="" border="0" />
            </a> 
        </span>
   
<?php  
$sql="select * from FORUM     ORDER BY FORUM_NAME ASC, FORUM_ID ASC ";		
if($rows=$db->queryObjectArray($sql)){	
 

 
  ?>

    <tr>
        <td width="100" ><div class="listrow" ><strong>הפעל/השהה</strong></div></td>
        <td   style="overflow:auto;" ><div class="listrow" style="overflow:auto;"><strong>שם הפורום</strong></div></td>
        <td width="170"><div class="listrow"><strong>תאריך</strong></div></td>
        <td width="90"><div class="listrow"><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
    </tr>
    
    
    <tr>
        <td class="dotrule" colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
                                        
    </tr>
    
   
   	<tr>
   	
   	</tr>  
    <?php
   
    $i = 0;
    
         $aState='';//(isset($aState))?$aState:NULL;
        
         
    	
    //count($aData)	
    while ($i < 5 && $aData= mysqli_fetch_assoc($result) ) {
       // !strcmp("FFFFFF", $bg) ? $bg = "F6F6F6" : $bg = "FFFFFF";
       $bg = "#F6F6F6";
        $aState = array("act_forum", "deact_forum");
      
      
    ?>
<tr>


    <td width="16" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData['status'] ?>" style="width:20px;">   
        
        
           		 
        <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=<?php print $aState[$aData['status']];?>&FORUM_ID=<?php print $aData['FORUM_ID'];?>" onclick="return verify();">
          <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData['status']; ?>.gif" width="16" height="10" alt="" border="0" />  
         <?php 
         if ($iPerm > 2) { 
         	echo '</a>'; 
         }
          else 
          echo '</a>'; 
         	?>
        
          </div>
     </td>
     
     
     
  <td width="332" bgcolor="<?php print $bg ?>">
  
          <div class="listrow<?php print $aData['status'] ?>"><?php print format($aData['FORUM_NAME']) ?></div>
  </td>
        
  <td width="170" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData['status'] ?>"><?php print  substr($aData['created_dt'],0,10); ?></div>
   </td>
        
        
 <td width="90" bgcolor="<?php print $bg ?>"><?php if ($iPerm !=1) { ?>
    <a  class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=editForum&FORUM_ID=<?php print $aData['FORUM_ID']  ?>"><b>ערוך</b></a>&nbsp;|&nbsp;
    <a class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=del_forums&FORUM_ID=<?php print $aData['FORUM_ID'] ?>" onclick="return verify();"><b>מחק</b> </a><?php } ?>
 </td>
    
    
</tr>
    
 
    
    <tr>
        <td class="dotrule" colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
 
   renderPaging_forum($start, $total);   
    ?>
 
</table>
</fieldset>
</form>

    
 
    
    <?php 
 

 }//if $aData 
 
 else {

 ?>

    <tr>
        <td colspan="2" class="error"> אין נתונים כרגע. </td> 
    </tr>
</table></fieldset></form>

<?php }
/**************/	
	
	
	
	
 


