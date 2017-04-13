<?php
//require_once ("../config/application5.php"); 


$name=isset($_GET['file_name'])?trim((string)$_GET['file_name']):''; 
$desc=isset($_GET['desc'])?trim((string)$_GET['desc']):''; 
$parentCatID=isset($_GET['parentCatID'])?(int)$_GET['parentCatID']:NULL;


if($name && $name!='' && $parentCatID!='11' &&  $parentCatID) { 
require_once "$name";
}elseif($parentCatID=='11' && $parentCatID){ 
require_once ("../config/application5.php");	
html_header();
 echo "<p class='error'><b> הקובץ-$desc הוא הנושא היתייחס לנושאים תחתיו! </b></p>";
html_footer();
}else{  
require_once ("../config/application5.php");	
html_header();	
echo "<p class='error'><b> עדיין אין נושא! </b></p>";
html_footer();
}
?>
 <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/treeview1.js"        charset="utf-8"           type="text/javascript"></script>
<script>
$('.error').css('width','40%');
turn_red_error();	
</script>
<?php  