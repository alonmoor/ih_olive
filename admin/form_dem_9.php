<?php
require_once '../config/application.php';
require_once (LIB_DIR.'/model/forum_class.php');
require_once ("../lib/model/DBobject3.php");
 
if(!isAjax())
 html_header();
 
 
?>
 
<!--<script type="text/javascript" src="ajax.lang.php"></script> -->
 
<!--<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/edit_forumdec.js"    type="text/javascript"></script>-->
<?php   
 
$formdata=FALSE;
/*****************************************************************************************/
/*****************************************************************************************/ 
$formdata['save_new']=1; 
$frm= new forum_dec();
build_form_ajx7($formdata);
$frm->print_forum_paging_b();
/*****************************************************************************************/		 
/*****************************************************************************************/

html_footer();
