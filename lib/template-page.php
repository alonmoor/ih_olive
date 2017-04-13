
<?php
require_once ("../../config/application.php");
require_once (HTML_DIR ."/header.php");
 

echo '<title>';
 if (!empty($GLOBALS['TEMPLATE']['title']))
{
    echo $GLOBALS['TEMPLATE']['title'];
}
?>
</title>
  <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/in_out_style.css" />
<?php
if (!empty($GLOBALS['TEMPLATE']['extra_head']))
{
    echo $GLOBALS['TEMPLATE']['extra_head'];
}
?>
 
  <div id="header">
<?php
if (!empty($GLOBALS['TEMPLATE']['title']))
{
    echo $GLOBALS['TEMPLATE']['title'];
}
?>
  </div>

<?php
 echo ' <div id="middle_div"  >';
if (!empty($GLOBALS['TEMPLATE']['content']))
{
    echo $GLOBALS['TEMPLATE']['content'];
}

 echo '</div>';


if(!(isset($_SESSION['error_page'])))
$_SESSION['error_page']=FALSE;
if($_SESSION['error_page']==true){
     //include ('./includes/footer.php');
     unset($_SESSION['error_page']);
}

require_once (HTML_DIR ."/footer.php");
 exit();
 
 
