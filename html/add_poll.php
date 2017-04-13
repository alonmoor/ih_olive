<?php

require_once 'header.php';


global $db;

 $oPolls = new polls;
$op = (isset($_GET['mode'])) ? (string)$_GET['mode'] : 0;
$id = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;
$iCursor = (isset($_GET['cursor'])) ? (int)$_GET['cursor'] : 0;
$sQuestion = (isset( $sQuestion)  ) ?(string)$sQuestion :'';


 






if($id   && !(array_item($_GET, 'mode')=='del_polls') ){
?>
<form action="<?php print SELF ?>?mode=<?php print $op ?>&id=<?php print $id ?>" method="post" name="wroxform"  dir="rtl">
<?php }else{?>
<form action="<?php print SELF ?>?mode=<?php print $op ?>" method="post" name="wroxform"  dir="rtl">
<?php }?>
<fieldset dir="rtl"  style="margin-top:50px; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table border="0" cellpadding="0" cellspacing="0" id="theList">
   
   
    <tr>
        <td colspan="2" style="width:55px;" > שאלה:<input size="70"  type="text" name="question" value="<?php print clean($sQuestion) ?>" class="textfield" /></td>
    </tr>
   <?php
   
  
/********************************************************/

   
    if (!strcmp("add_polls_item", $op)) {
    	 $aAnswers=(isset($aAnswers))?$aAnswers:NULL;	
    for ($i = 0; $i < 6; ++$i) {
    ?>
    
    <tr>
        <td colspan="2">תשובה <?php print $i + 1 ?>:
           <input size="30" type="text" id="<?php print $i + 1; ?>" name="answer[<?php print $aAnswers[$i]["Answer Id"] ?>]" value="<?php print clean($aAnswers[$i]["Answer"]) ?>" class="textfield" />
        </td>
    </tr>
    <?php } ?>
    <?php
/***************************************************/    

    
    
    
    } elseif (!strcmp("edit_polls", $op)) {
    $i = 0;
    while ($i < count($aAnswers)) {
    ?>
    <tr>
       <td colspan="2">תשובה <?php print $i + 1 ?>: 
         <input size="30" type="text" name="answer[<?php print $aAnswers[$i]["Answer Id"] ?>]" value="<?php print clean($aAnswers[$i]["Answer"]) ?>" class="textfield" />
       </td>
    </tr>
    <?php
        ++$i;
    }
    ?>
    <?php } ?>
    <tr>
        <td class="dotrule" colspan="2"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <tr>
        <td align="right" colspan="2">
      <button class="green90x24" type="submit" name="submitbutton"  id="submitbutton" >שלח</button>  
<!--        <input type="image" src="<?php echo IMAGES_DIR ?>/buttons/btn_submit.gif" width="58" height="15" alt="" border="0" onfocus="this.blur();" />-->
        </td>
    </tr>
</table>
</fieldset>
</form>
	
<?php	
 