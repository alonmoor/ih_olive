<?php
global $db;


ob_start();
if($element!=""){
	echo $element;
}

if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD))
{
    die('Error: Unable to connect to database server.');
}
if (!mysql_select_db(DB_SCHEMA, $GLOBALS['DB']))
{
    mysql_close($GLOBALS['DB']);
    die('Error: Unable to select database schema.');
}

if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}
			
	
?>
  
<!--<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>-->
<script type="text/javascript">
	tinyMCE.init({

 //  mode : "textareas", theme : "advanced", width : "800",dir:"rtl" ,  


 
	  
 
 	// General options
		// mode : "exact",
    	 mode : "textareas",
		elements : "content",
		theme : "advanced",
		width :600,
		height : 400,//autoresize,->this plugin make problem
		 plugins : "advlink,advlist,autosave,contextmenu,fullscreen,iespell,inlinepopups,media,paste,preview,safari,searchreplace,visualchars,wordcount,xhtmlxtras",

		// Theme options
 		theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,removeformat,|,search,replace,|,cleanup,help,code,preview,visualaid,fullscreen",
 		theme_advanced_buttons2 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,|,bullist,numlist,|,outdent,indent,blockquote,|,sub,sup,cite,abbr",
 		theme_advanced_buttons3 : "hr,|,link,unlink,anchor,image,|,charmap,emotions,iespell,media",
 		theme_advanced_toolbar_location : "top",
    	theme_advanced_toolbar_align : "right",

	//	theme_advanced_resizing : true

		// Example content CSS (should be your site CSS)
		 //content_css : "<?php echo ROOT_WWW; ?>/html/css/log_inout.css"
		 content_css : "/css/in_out_style.css"
         
	});
	
</script>
 
 
 

<?php

$GLOBALS['TEMPLATE']['extra_head'] = ob_get_contents();
ob_clean();
//style="width:100%"
// Generate entry form
?>
<form action="<?php echo $_SERVER['SCRIPT_NAME'];?>?mode=post_admin" method="post" dir="rtl" >
 <fieldset   style="background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>הוסף/ערוך דף בלוג</legend> 	

	 
 <div id="form_select">
  <table >
   <tr>
    <td class="label" >
     
     <label for="post_id" style="float:right;color:yellow;font-weight:bold;" >צור בלוג :</label>

<select name="post_id" id="post_id" style="float:right;">
      <option value="select">בחר אופצייה</option>
      <option value="new">הוסף בלוג חדש</option>
<?php


 $blog_date=(isset($_POST['post_date']))?substr($blog_date, 0,10) :'';

// retrieve list of post titles
//$query = sprintf('SELECT POST_ID, POST_TITLE, UNIX_TIMESTAMP(POST_DATE) ' .
//    'AS POST_DATE FROM %sBLOG_POST ORDER BY POST_DATE DESC, POST_TITLE ASC',
//    DB_TBL_PREFIX);
    
    $query = sprintf('SELECT POST_ID, POST_TITLE,POST_DATE ' .
    ' FROM %sBLOG_POST ORDER BY POST_DATE DESC, POST_TITLE ASC',
    DB_TBL_PREFIX);

$result = mysql_query($query, $GLOBALS['DB']);

while ($record = mysql_fetch_assoc($result))
{
    echo '<option value="' . $record['POST_ID'] . '">';
    echo '(' .   substr($record['POST_DATE'], 0,10)   . ') ' .
    
        $record['POST_TITLE'];
    echo '</option>';
}



mysql_free_result($result);
?>
</select></td>




     
   </tr>
  </table>
 </div>
 
 
 
 <div id="form_fields" style="display:none;">
 <table>
 
 
<tr>
    <td class="label"  style="color:yellow;font-weight:bold;"><label for="post_title">כותרת :</label> 
 
    <input type="text" name="post_title" id="post_title"/></td>
</tr>
   
 
<tr>
 
    <td class="label"  style="color:yellow;font-weight:bold;">
       <label for="post_date">תאריך :</label>
     
     
   
 
<input type="text" name="post_date" id="post_date" maxlength="10" size="10" value="<?php echo $blog_date; ?>"/>

     
  </td>
 </tr>
   
   
   <tr>
    <td class="label" style="color:yellow;font-weight:bold;"><label for=news_content">תוכן :</label></td></tr><tr> 
   <td>
     <textarea id="post_text" name="post_text" rows="15" cols="60"></textarea>
    </td>
   </tr>
   
   
   
   <tr id="delete_field">
     
    <td style="text-align: right;">
      <input type="checkbox" id="delete" name="delete"/>
     <label for="delete" style="color:yellow;font-weight:bold;">מחק כניסה :</label></td>
   </tr>
   
   
   <tr>
   
    <td>
      <input type="submit" value="שלח" id="form_submit" class="button"/>
      <input type="reset" value="בטל" id="form_reset" class="button"/>
    </td>
   </tr>
  
  
  </table>
 </div>
 
 
 
 
 
 </fieldset> 
</form>










<br />

<form id="my_blgMessage"  style="overflow:auto;"  dir="rtl" action="<?php echo $_SERVER['SCRIPT_NAME']?>"  method="post"> 
<fieldset   style="overflow:auto; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table >


<?php 
/********************************************************************************/
 $sql="SELECT * FROM BLOG_COMMENT  ORDER BY COMMENT_DATE ASC, PERSON_NAME ASC ";	
 $mysqli=$db->getMysqli();
 $result = $mysqli->query($sql);
 $start=0;
 if ($total =mysqli_num_rows($result))
    {
    $start = (isset($_GET['cursor']) && ctype_digit($_GET['cursor']) && $_GET['cursor'] <= $total) ? $_GET['cursor'] : 0;
    
    mysqli_data_seek($result, $start);
    }
/**********************************************************************************/   	

	

	
if($result){	
  
  ?>

    <tr>
        <td width="50"><div class="listrow" ><strong>הפעל/השהה</strong></div></td>
        <td  width="50"><div class="listrow" ><strong>שם השולח</strong></div></td>
        <td width="100"><div class="listrow"><strong>תאריך</strong></div></td>
        <td width="170"><div class="listrow"><strong>הודעה</strong></div></td>
        <td width="90"><div class="listrow"><strong>פעולות לביצוע</strong></div></td>

    </tr>
    
    
    <tr>
        <td class="dotrule" colspan="5"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
                                        
    </tr>
    
   
   	<tr>
   	
   	</tr>  
    <?php
   
    $i = 0;
    
         $aState='';
       //count($aData)	
    while ($i < 5 && $aData= mysqli_fetch_assoc($result) ) {
    
       $bg = "#F6F6F6";
        $aState = array("act_blog", "deact_blog");
      
      
    ?>
<tr>


  <td width="16" bgcolor="<?php print $bg ?>">
     <div class="listrow<?php print $aData['status'] ?>" style="width:20px;" >   
        
        
           		 
        <a class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=<?php print $aState[$aData['status']];?>&POST_ID=<?php print $aData['POST_ID'];?>&POST_COMMENT=<?php print $aData['POST_COMMENT'];?>" onclick="return verify();">
          <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData['status']; ?>.gif" width="16" height="10" alt="" border="0" />  
        </a>
     
         	
    </div>
  </td>
     
     
     
  <td width="100" bgcolor="<?php print $bg ?>">
  
          <div class="listrow<?php print $aData['status'] ?>"><?php print format($aData['PERSON_NAME']); ?></div>
  </td>
        
  
  <td width="170" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData['status'] ?>"><?php print  substr($aData['COMMENT_DATE'],0,10); ?></div>
  </td>
        
    
    
    
  <td width="170" bgcolor="<?php print $bg ?>">
        <div class="listrow<?php print $aData['status'] ?>"><?php print  format($aData['POST_COMMENT']); ?></div>
  </td>   
    
    
        
 <td width="90" bgcolor="<?php print $bg ?>">
    
    <a class="my_href_li1" href="<?php echo $_SERVER['SCRIPT_NAME']?>?mode=del_Msgblog&POST_ID=<?php print $aData['POST_ID'] ?>&POST_COMMENT=<?php print $aData['POST_COMMENT'];?>" onclick="return verify();"><b>מחק</b> </a>
 </td>
    
    
</tr>
    
 
 
 
 
 
    
 <tr>
    <td class="dotrule" colspan="5"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
  } // end loop
 
   renderPaging_Msgblog($start, $total);   
 ?>
 
</table>
</fieldset>
</form>

    
 
    
    <?php 
 

 }//if $aData 
 




$GLOBALS['TEMPLATE']['content'] = ob_get_clean();

require_once (LIB_DIR ."/template-page.php");
mysql_close($GLOBALS['DB']);
