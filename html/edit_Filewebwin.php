<?php
global $db;

$sql="SELECT * FROM categories_subject WHERE catID=$catID ";
if($rows=$db->queryObjectArray($sql)){
$row=$rows[0];

if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_GET, 'mode')=='del_file_win')  ){


 if ($catID   && !(array_item($_GET, 'mode')=='del_file_win') ){
 	 include ('./includes/header.php');
 	 
 	 
/*********************************************************************/ 	 

 	 
?>
<form action="<?php print SELF ?>?mode=edit_web_win&catID=<?php print $catID ?>" method="post"    dir="rtl">
 
 
 
<fieldset dir="rtl"  style="margin-top:50px; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table border="0" cellpadding="0" cellspacing="0" id="theList">
   
   
    <tr>
        <td colspan="2" style="width:55px;" > שם הקטגוריה:<input size="70"  type="text" name="catName" value="<?php print clean($row->catName) ?>" class="textfield" /></td>
    </tr>
  
    
    <tr>
         <td colspan="2" style="width:55px;" > שם הקובץ:<input size="70"  type="text" name="fileName" value="<?php print clean($row->fileName) ?>" class="textfield" /></td>
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
    echo '<td>';
    
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
  }else return;	
}else return;	
}else return;