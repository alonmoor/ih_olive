<?php
require("config/application1.php");
html_header();

$_SESSION['userID']=$_REQUEST['user'];
$_SESSION['flag_down']=true;

require_once (ADMIN_DIR.'/find3.php');

html_footer();
?>


