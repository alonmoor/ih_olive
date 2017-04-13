<?php

  global $iCursor, $iPerm,$db;
  
/********************************************************************************/
  $sql="SELECT * FROM categories_file  ORDER BY catID ASC, catName ASC ";	
 
 $mysqli=$db->getMysqli();
 $result = $mysqli->query($sql);
 
 if ($total =mysqli_num_rows($result))
    {
    $start = (isset($_GET['cursor']) && ctype_digit($_GET['cursor']) && 

$_GET['cursor'] <= $total) ? $_GET['cursor'] : 0;
     mysqli_data_seek($result, $start);
    }
/**********************************************************************************/   	

	  
  
?>
<br />

<form  style="width:95%;overflow:auto;" dir="rtl" action="<?php echo $_SERVER['SCRIPT_NAME']?>"  method="post"> 
<fieldset   style="background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table >

     
        
         <span >
          <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=add_file_item" style="float:right;" class="my_href_li">
            <img src="<?php echo IMAGES_DIR ?>/buttons/btn_additem.gif" width="80" height="30" alt="" border="0" />
            </a> 
        </span>
   
<?php    
 if ($result) { ?>

    <tr>
        <td width="30" ><div class="listrow" ><strong>הפעל/השהה</strong></div></td>
        <td   style="overflow:auto;" ><div class="listrow" style="overflow:auto;"><strong>קטגוריה</strong></div></td>
        <td   style="overflow:auto;" ><div class="listrow" style="overflow:auto;"><strong>שם הקובץ</strong></div></td>
       <td width="100"><div class="listrow"><strong>קישור</strong></div></td> 
        <td width="90"><div class="listrow"><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
    </tr>
    
    
    <tr>
        <td class="dotrule" colspan="5"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
                                        
    </tr>
    
   
   	<tr>
   	
   	</tr>  
    <?php
   
    $i = 0;
    
         $aState='';//(isset($aState))?$aState:NULL;
        
         
    $sql = "SELECT catName, catID, parentCatID FROM categories_file ORDER BY catName";
			$rows = $db->queryObjectArray($sql);
			
			foreach($rows as $row) {
				$subcatsftype[$row->parentCatID][] = $row->catID;
				$catNamesftype[$row->catID] = $row->catName; }

				//$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
				$rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
    while ($i < 5 && $aData= mysqli_fetch_assoc($result)) {
       // !strcmp("FFFFFF", $bg) ? $bg = "F6F6F6" : $bg = "FFFFFF";
      // $bg = "F6F6F6";
      $bg = "#F6F6F6";
        $aState = array("act_file", "deact_file");
        $aData['ts'] = strtotime($aData['ts']);
        $parentCatID=$aData['parentCatID'];	
 
    ?>
<tr>


    <td width="16" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData ["status"] ?>" style="width:20px;">   
        
        
           		 
        <a href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=<?php print $aState[$aData["status"]] ?>&catID=<?php print $aData ["catID"] ?>" onclick="return verify();">
          <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData ["status"] ?>.gif" width="16" height="10" alt="" border="0" />  
        </a> 
        
     </div>
   </td>
     
     
     
  <td width="332" bgcolor="<?php print $bg ?>">
  
          <div class="listrow<?php print $aData ["status"] ?>"><?php print format($aData ["catName"]) ?></div>
  </td>
  
  
   <td width="332" bgcolor="<?php print $bg ?>">
  
          <div class="listrow<?php print $aData ["status"] ?>"><?php print format($aData ["fileName"]) ?></div>
  </td>
  
  
    
   
    <td bgcolor="<?php print $bg ?>"> 

<?php 
  //to try->form_list_b     
   form_list_b("fileType" , $rows2, $parentCatID,"id=fileType  style='width:140px;' ");		      
?>
    </td> 
  
  
  
 <!--        
  <td width="170" bgcolor="<?php print $bg ?>">
       <div class="listrow<?php print $aData["status"] ?>"><?php print date("Y-m-d H:i:s" , $aData["ts"]) ?></div>
  </td>
  -->       
        
 <td width="90" bgcolor="<?php print $bg ?>"> 
    <a class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=edit_file&catID=<?php print $aData ["catID"] ?>&parentCatID=<?php print $aData ["parentCatID"] ?>"><b>ערוך</b></a>&nbsp;|&nbsp;
    <a class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=del_file&catID=<?php print $aData ["catID"] ?>" onclick="return verify();"><b>מחק</b> </a> 
 </td>
    
    
</tr>
    
 
    
    <tr>
        <td class="dotrule" colspan="5"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
  

  renderPaging_files($start, $total); 
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
	
