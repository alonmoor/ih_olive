<?php
 ?>
<form  style="width:95%;overflow:auto;"  action="<?php print SELF ?>?mode=view_polls&cursor=<?php echo $iCursor;?>" method="post" name="wroxform" dir="rtl">
  
  <input type="hidden" name="pollid" value="<?php print $aPoll["Poll Id"] ?>">
 <fieldset dir="rtl"  style="margin-top:50px; background: #94C5EB url(../../images/background-grad.png) repeat-x;" > 
   <table style=" overflow:auto;" border="0" cellpadding="0" cellspacing="0" id="theList">
   
   
   <td class="label" >
     
     
   
   
   
    <?php if ($iCnt) { // check poll count value ?>
    <tr>
        <td><div class="section"><label for="section" style="font-weight:bold;" >שאלה :</label><?php print format($aPoll["Question"]) ?></div></td>
    </tr>
    
    <tr>
        <td class="dotrule"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    
    
    <tr>
        <td>        
        <table   border="0" cellpadding="0" cellspacing="0">
        <?php
        $i = 0;
        $sChecked = "checked";
        strcmp($_COOKIE["cPOLL"], $aPoll["Poll Id"]) ? $iVoted = false : $iVoted = true;
                
     while ($i < count($aPoll["Answers"])) { // loop poll answers
           
     	    if (!$iVoted && ($iCursor <1 || !($aPoll['Vote Count']))) { // poll vote check ?>
       
        <tr>
            <td width="25">
              <div class="copy"  style="float:right;">
                <input type="radio" name="vote" value="<?php print $aPoll["Answers"][$i]["Answer Id"] ?>"<?php print $sChecked ?>>
              </div>
            
            
            
             
              <div style="float:right;" class="copy"><?php print format($aPoll["Answers"][$i]["Answer"]) ?></div>
            </td>
            
        </tr>
       
        
        
        <tr>
            <td colspan="2" class="dotrule"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
        </tr>
       
        <?php
        
        } else { // display results
            
            // assign calculation defaults
            $iPerc = 0;
            $iWidth = 0;
            
            // if the poll total vote count is greater than 0
            if ($aPoll["Vote Count"]) {
                
                // find the percentage
                $iPerc = round($aPoll["Answers"][$i]["Answer Count"] / $aPoll["Vote Count"] * 100, 0);
            }
            
            // multiply the percentage by 5.9 to get a scaled image length
            $iWidth = round(($iPerc * 5.9) - 1, 0);
            
        ?>
        <tr>
            <td><div class="copy" style="float:bold;"><label for="copy" style="font-weight:bold;" >תשובה :</label>
            <?php print format($aPoll["Answers"][$i]["Answer"]) ; ?><?php echo "←$iPerc" ;?>%</div></td>
        </tr>
        
        
  
              
        <tr>
            <td>
                <img src="<?php echo IMAGES_DIR ?>/meter_right.gif" width="5" height="10" alt="" border="0"><img src="<?php echo IMAGES_DIR ?>/meter.gif" width="<?php print $iWidth ?>" height="10" alt="" border="0"><img src="<?php echo IMAGES_DIR ?>/meter_left.gif" width="5" height="10" alt="" border="0">
            </td>
        </tr>
        
    <!-- -------------------- -->    
        
        <tr>
            <td class="dotrule"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
        </tr>
        <?php } // end answers  display check ? 
        
            // check default state for radio buttons
            if (!strcmp("checked", $sChecked)) {
                
                $sChecked = "";
            }
            
            ++$i;
        } // end poll answers while loop
        ?>
       
       
         </table>
       </td>
    </tr>
            
 <?php if (!$iVoted && ($iCursor < 1  || !($aPoll['Vote Count'])  ) && !($_SERVER['REQUEST_METHOD'] == 'POST') ){ // poll vote check ?>
 
    <tr>
        <td align="right"  >
<!--        <input type="image" src="<?php echo IMAGES_DIR ?>/buttons/btn_submit.gif" width="80" height="35" alt="" border="0" onfocus="this.blur();" />-->
                 <button class="green90x24" type="submit" name="submitbutton"  id="submitbutton" >שלח</button> 
        </td>
    </tr>
 
 
    <tr>
        <td><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
 
 
 
 <? } else { // poll vote has been recorded, render totals ?>
 
    <tr>
        <td><div class="section">סה"כ הצבעות: <?php print $aPoll["Vote Count"] ?></div></td>
    </tr>
 
 
    <tr>
        <td><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php  
    } // end poll vote check 
 ?>
   
   
   
 <tr>
   <td>
 
   
   
   
   
   
   
   
   
   
   
   
    <?php if ($iCnt > 1 && ($iVoted || $iCursor > 0  ||    $aPoll['Vote Count'])      ) { // verify pagination display ?>
    <table  border="0" cellpadding="0" cellspacing="0">    
      <tr>
        <td align="right">
<!--           <div class="paging">-->
    
    
     <!---------------------------------------| paging |--------------------------------------------------------------->
                 
   
    
<!--                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width:5px"> -->
                        <?php if ($iCursor > 0) { ?>
                        
                        <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?mode=view_polls&cursor=<?php echo $iCursor - 1; ?>
                        <?php print $sVar ?>">
                        <img src="<?php echo IMAGES_DIR ?>/buttons/btn_next.gif" width="50" height="40" alt="" border="0" /><?php } 
                        
                        else { ?>
                           <img src="<?php echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="50" height="40" alt="" border="0" />
                        <?php
                         } 
                         ?>
                         </a>
                          
                         
                       
                        
                        <?php if ($iCursor + 1 < $iCnt) { ?>
                        <a href="<?php echo $_SERVER['SCRIPT_NAME'];?>?mode=view_polls&cursor=<?php echo $iCursor + 1; ?>
                        <?php print $sVar ?>"><img src="<?php echo IMAGES_DIR ?>/buttons/btn_prev.gif" width="50" height="40" alt="" border="0" /><?php } 
                        else { ?>
                           <img src="<?php echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="50" height="40" alt="" border="0" /><?php } ?></a>
                        
                        
               <!--            </td>
                        
                        
                        
                    </tr>
             </table>   -->
 
 
 
                
  <!---------------------------------------| paging |--------------------------------------------------------------->
                
                
<!--         </div>-->
         </td>
        </tr>
        </table>
        <br />
        <?php } // end pagination display verification ?>
        
        
        </td>
    </tr>
    
        
      <?php } else { // there are no polls ?>
   
   
    <tr>
        <td><div class="error">מצטערים אין כרגע שאלות.</div></td>
    </tr>
   
    <?php } // end poll count value check ?>
    
</table>
</fieldset>
</form>
<?php 
