<?php
// return a string of random text of a desired length
function random_text($count, $rm_similar = true)
{
$text='';	
    $chars = array_flip(array_merge(range(0, 9), range('A', 'Z')));

    // remove similar looking characters
    if ($rm_similar)
    {
        unset($chars[0], $chars[1], $chars[2], $chars[5], $chars[8],
            $chars['B'], $chars['I'], $chars['O'], $chars['Q'],
            $chars['S'], $chars['U'], $chars['V'], $chars['Z']);
    }

    for ($i = 0; $i < $count; $i++)
    {
        $text .= array_rand($chars);
    }
    return $text; 

}

/************************************************************************************/
// sets a generic pagination element
function renderPaging_forum($iCursor=0, $iCnt=0, $sVar='') {

?>
    <?php if ($iCnt > ROWCOUNT) { ?>
 
    <tr>
        <td align="right"> 
      
        
         
          
      <?php
      if ($iCursor > 0) { 
                ?>
                 <a href="<?php print SELF ?>?mode=edit_forums&cursor=<?php print $iCursor - ROWCOUNT ?><?php print $sVar ?>">
                  <img src="<? echo IMAGES_DIR ?>/buttons/btn_next.gif" width="30" height="30" alt="" border="0" /><?php 
                }
                
                else { 
                ?>
                <img src="<? echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="30" height="30" alt="" border="0" /><?php 
                } 
             ?>
                </a>
      
        
        
        
        <?php
            
            
               if ($iCursor + ROWCOUNT < $iCnt) { 
      ?>
         <a href="<?php print SELF ?>?mode=edit_forums&cursor=<?php print $iCursor + ROWCOUNT ?><?php print $sVar ?>">
          <img src="<?php echo IMAGES_DIR?>/buttons/btn_prev.gif" width="30" height="30" alt="" border="0" /><?php 
         } 

         else {
         ?>
         <img src="<? echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="30" height="30" alt="" border="0" />
         <?php 
        } 
        ?>
        </a>
            
        
        
        
        
        
        
        
      
         </td>
    </tr>
 
<br />
    <?php } // end condition ?>
<?php

} // end function
/*********************************************************************************************************/
 function renderPaging_Msgforum($iCursor=0, $iCnt=0, $sVar='') {

?>
    <?php if ($iCnt > ROWCOUNT) { ?>
 
    <tr>
        <td align="right"> 
        
        
         
 <?php
            
            
           if ($iCursor > 0) { 
                ?>
                 <a href="<?php print SELF ?>?mode=view_forums&cursor=<?php print $iCursor - ROWCOUNT ?><?php print $sVar ?>">
                  <img src="<? echo IMAGES_DIR ?>/buttons/btn_next.gif" width="30" height="30" alt="" border="0" /><?php 
                }
                
                else { 
                ?>
                <img src="<? echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="30" height="30" alt="" border="0" /><?php 
                } 
             ?>
                </a>
      
     
     
       <?php
     
     
               if ($iCursor + ROWCOUNT < $iCnt) { 
      ?>
         <a href="<?php print SELF ?>?mode=view_forums&cursor=<?php print $iCursor + ROWCOUNT ?><?php print $sVar ?>">
          <img src="<?php echo IMAGES_DIR?>/buttons/btn_prev.gif" width="30" height="30" alt="" border="0" /><?php 
         } 

         else {
         ?>
         <img src="<? echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="30" height="30" alt="" border="0" />
         <?php 
        } 
        ?>
        </a>
            
            
            
    
     

         </td>
    </tr>
 
<br />
    <?php } // end condition ?>
<?php

} // end function
/*********************************************************************************************************/ 
/*********************************************************************************************************/
 function renderPaging_Msgblog($iCursor=0, $iCnt=0, $sVar='') {

?>
    <?php if ($iCnt > ROWCOUNT) { ?>
 
    <tr>
        <td align="right"> 
        
        
         
 <?php
            
            
           if ($iCursor > 0) { 
                ?>
                 <a href="<?php print SELF ?>?mode=add_blog&cursor=<?php print $iCursor - ROWCOUNT ?><?php print $sVar ?>">
                  <img src="<? echo IMAGES_DIR ?>/buttons/btn_next.gif" width="30" height="30" alt="" border="0" /><?php 
                }
                
                else { 
                ?>
                <img src="<? echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="30" height="30" alt="" border="0" /><?php 
                } 
             ?>
                </a>
      
     
     
       <?php
     
     
               if ($iCursor + ROWCOUNT < $iCnt) { 
      ?>
         <a href="<?php print SELF ?>?mode=add_blog&cursor=<?php print $iCursor + ROWCOUNT ?><?php print $sVar ?>">
          <img src="<?php echo IMAGES_DIR?>/buttons/btn_prev.gif" width="30" height="30" alt="" border="0" /><?php 
         } 

         else {
         ?>
         <img src="<? echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="30" height="30" alt="" border="0" />
         <?php 
        } 
        ?>
        </a>
            
            
            
    
     

         </td>
    </tr>
 
<br />
    <?php } // end condition ?>
<?php

} // end function
/*********************************************************************************************************/ 
/************************************************************************************/
// sets a generic pagination element
function renderPaging_Polls($iCursor=0, $iCnt=0, $sVar='') {

?>
    <?php if ($iCnt > ROWCOUNT) { ?>
  
    <tr>
        <td align="right">  
            
              <?php    
                if ($iCursor > 0) { 
                ?>
                 <a href="<?php print SELF ?>?mode=add_polls&cursor=<?php print $iCursor - ROWCOUNT ?><?php print $sVar ?>">
                  <img src="<? echo IMAGES_DIR ?>/buttons/btn_next.gif" width="30" height="30" alt="" border="0" /><?php 
                }
                
                else { 
                ?>
                <img src="<? echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="30" height="30" alt="" border="0" /><?php 
                } 
             ?>
                </a>
                
   <?php
   if ($iCursor + ROWCOUNT < $iCnt) { 
      ?>
         <a href="<?php print SELF ?>?mode=add_polls&cursor=<?php print $iCursor + ROWCOUNT ?><?php print $sVar ?>">
          <img src="<?php echo IMAGES_DIR?>/buttons/btn_prev.gif" width="30" height="30" alt="" border="0" /><?php 
         } 

         else {
         ?>
         <img src="<? echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="30" height="30" alt="" border="0" />
         <?php 
        } 
        ?>
        </a>
        
        
        
             </td>
    </tr>
 
<br />
    <?php } // end condition ?>
<?php

} // end function
/*********************************************************************************************************/
/************************************************************************************/
// sets a generic pagination element
function renderPaging_files($iCursor=0, $iCnt=0, $sVar='') {

?>
    <?php if ($iCnt > ROWCOUNT) { ?>
  
    <tr>
        <td align="right">  
            
              <?php    
                if ($iCursor > 0) { 
                ?>
                 <a href="<?php print SELF ?>?mode=edit_web&cursor=<?php print $iCursor - ROWCOUNT ?><?php print $sVar ?>">
                  <img src="<? echo IMAGES_DIR ?>/buttons/btn_next.gif" width="30" height="30" alt="" border="0" /><?php 
                }
                
                else { 
                ?>
                <img src="<? echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="30" height="30" alt="" border="0" /><?php 
                } 
             ?>
                </a>
                
   <?php
   if ($iCursor + ROWCOUNT < $iCnt) { 
      ?>
         <a href="<?php print SELF ?>?mode=edit_web&cursor=<?php print $iCursor + ROWCOUNT ?><?php print $sVar ?>">
          <img src="<?php echo IMAGES_DIR?>/buttons/btn_prev.gif" width="30" height="30" alt="" border="0" /><?php 
         } 

         else {
         ?>
         <img src="<? echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="30" height="30" alt="" border="0" />
         <?php 
        } 
        ?>
        </a>
        
        
        
             </td>
    </tr>
 
<br />
    <?php } // end condition ?>
<?php

} // end function
/*********************************************************************************************************/
/*********************************************************************************************************/
/************************************************************************************/
// sets a generic pagination element
function renderPaging_files_win($iCursor=0, $iCnt=0, $sVar='') {

?>
    <?php if ($iCnt > ROWCOUNT) { ?>
  
    <tr>
        <td align="right">  
            <div>
              <?php    
                if ($iCursor > 0) { 
                ?>
                 <a href="<?php print SELF ?>?mode=edit_web_win&cursor=<?php print $iCursor - ROWCOUNT ?><?php print $sVar ?>">
                  <img src="<? echo IMAGES_DIR ?>/buttons/btn_next.gif" width="30" height="30" alt="" border="0" /><?php 
                }
                
                else { 
                ?>
                <img src="<? echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="30" height="30" alt="" border="0" /><?php 
                } 
             ?>
                </a>
                
   <?php
   if ($iCursor + ROWCOUNT < $iCnt) { 
      ?>
         <a href="<?php print SELF ?>?mode=edit_web_win&cursor=<?php print $iCursor + ROWCOUNT ?><?php print $sVar ?>">
          <img src="<?php echo IMAGES_DIR?>/buttons/btn_prev.gif" width="30" height="30" alt="" border="0" /><?php 
         } 

         else {
         ?>
         <img src="<? echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="30" height="30" alt="" border="0" />
         <?php 
        } 
        ?>
        </a>
        
        <div>
        
             </td>
    </tr>
 
<br />
    <?php } // end condition ?>
<?php

} // end function
/*********************************************************************************************************/ 
 
 
 
 
 
 