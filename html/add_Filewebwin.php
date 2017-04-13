 
<form action="<?php print SELF ?>?mode=add_file_item_win&catID=<?php print $catID; ?>&parentCatID=<?php print $parentCatID; ?>" method="post"    dir="rtl">
 
 
 
<fieldset dir="rtl"  style="margin-top:50px; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table border="0" cellpadding="0" cellspacing="0" id="theList">
   
   
    <tr>
        <td colspan="2" style="width:55px;" > שם הקטגוריה:<input size="20"  type="text" name="catName" value="<?php print clean($catName) ?>" class="textfield" /></td>
    </tr>
  
    <tr>
        <td class="dotrule" colspan="2"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
  
    <tr>
         <td colspan="2" style="width:55px;" > שם הקובץ:<input size="20"  type="text" name="fileName" value="<?php print clean($fileName) ?>" class="textfield" /></td>
    </tr>
    
   <tr>
        <td class="dotrule" colspan="2"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
 
    <tr>
   <?php 
$sql = "SELECT catName, catID, parentCatID FROM categories_subject ORDER BY catName";
			$rows = $db->queryObjectArray($sql);
				
			foreach($rows as $row) {
				$subcatsftype[$row->parentCatID][] = $row->catID;
				$catNamesftype[$row->catID] = $row->catName; }

				$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
				$rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
 
  
    //form_label_red("הזנת  סוגי ההחלטה:", TRUE); 
    echo '<td colspan="2">';
    
   echo '  <label for="fileType">קישור:</label>';

                  //($name, $rows, $selected=-1, $str="")
    form_list_b("fileType" , $rows, $parentCatID,"id=fileType  style='width:140px;' ");		      
?>
    </td> 
  
    
    </tr>
 
 
    <tr>
        <td class="dotrule" colspan="2"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <tr>
        <td align="right" colspan="2">
           <button class="green90x24" type="submit" name="submitbutton"  id="submitbutton" >שלח</button>  
       </td>
    </tr>
</table>
</fieldset>
</form>
<?php 
 