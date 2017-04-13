<?php
require_once ("header.php");
  global $iCursor, $iPerm,$db;
  
/********************************************************************************/
// $sql="SELECT * FROM BLOG_COMMENT  ORDER BY COMMENT_DATE ASC, PERSON_NAME ASC ";	
$sql = "SELECT 
                    poll_id, 
                    poll_vote_cnt, 
                    poll_question, 
                    STATUS, 
                    created_dt, 
                    modified_dt 
                FROM 
                    wrox_polls 
                WHERE 
                    deleted=0 
                ORDER BY 
                    created_dt DESC " ;
 $mysqli=$db->getMysqli();
 $result = $mysqli->query($sql);
 $start=0;
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
          <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=add_polls_item" style="float:right;" class="my_href_li">
            <img src="<?php echo IMAGES_DIR ?>/buttons/btn_additem.gif" width="80" height="30" alt="" border="0" />
            </a> 
        </span>
   
<?php    
 if ($result) { ?>

    <tr>
        <td width="100" ><div class="listrow" ><strong>הפעל/השהה</strong></div></td>
        <td   style="overflow:auto;" ><div class="listrow" style="overflow:auto;"><strong>שאלות</strong></div></td>
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
        
         
     
    while ($i < 5 && $aData= mysqli_fetch_assoc($result)) {
       // !strcmp("FFFFFF", $bg) ? $bg = "F6F6F6" : $bg = "FFFFFF";
       $bg = "#F6F6F6";
        $aState = array("act", "deact");
        $aData['created_dt'] = strtotime($aData['created_dt']);
        $aData['modified_dt'] = strtotime($aData['modified_dt']);
 
    ?>
<tr>


    <td width="16" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData ["STATUS"] ?>" style="width:20px;">   
        
        
           		 
        <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=<?php print $aState[$aData["STATUS"]] ?>&id=<?php print $aData ["poll_id"] ?>" onclick="return verify();">
          <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData ["STATUS"] ?>.gif" width="16" height="10" alt="" border="0" />  
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
  
          <div class="listrow<?php print $aData ["STATUS"] ?>"><?php print format($aData ["poll_question"]) ?></div>
  </td>
        
  <td width="170" bgcolor="<?php print $bg ?>">
       <div class="listrow<?php print $aData["STATUS"] ?>"><?php print date("Y-m-d H:i:s" , $aData["created_dt"]) ?></div>
  </td>
        
        
 <td width="90" bgcolor="<?php print $bg ?>"><?php if ($iPerm !=1) { ?>
    <a class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=edit_polls&id=<?php print $aData ["poll_id"] ?>"><b>ערוך</b></a>&nbsp;|&nbsp;
    <a class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=del_polls&id=<?php print $aData ["poll_id"] ?>" onclick="return verify();"><b>מחק</b> </a><?php } ?>
 </td>
    
    
</tr>
    
 
    
    <tr>
        <td class="dotrule" colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
   

  renderPaging_Polls($start, $total); 
  ?>
    
</table>
</fieldset>
</form>

    
 
    
    <?php 



 }else {

 ?>

    <tr>
        <td colspan="2" class="error"> אין נתונים כרגע. </td> 
    </tr>
</table></fieldset></form>

<?php }

/**************/