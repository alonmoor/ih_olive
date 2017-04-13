<?PHP
// session_start();
	require 'includes/master.inc.php';
	require_once 'config/application_no_session.php';
 //session_start();
	 global $db;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html dir=rtl xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>index</title>
   <link rel="stylesheet" href="html/css/table.css" type="text/css" media="screen" title="Screen" charset="utf-8" />
</head>

<body>
    <table>
	<h1>מערכת ניהול - pdf </h1>

	<?PHP echo '<table class="table">', "\n"; if($auth->ok()) : ?>
	<?PHP if (($auth->level)=='admin'){
		unset($_SESSION['level']);
		unset($_SESSION['uname']);
	$_SESSION['level']=$auth->level;
	$_SESSION['userID']=$auth->user_id;
	$_SESSION['uname']=$auth->username;
	$sql="select managerID from managers where userID=$auth->user_id";
	if($rows=$db->queryObjectArray($sql)){
		$managerID=$rows[0]->managerID;
	}

	?>
 	<tr><td>  היתחברת כ- מנהל אם שם משתמש   <?php  echo " $auth->username";  ?>

<!-- 	<a href='admin/get_intoSystem.php?managerID=<?php echo $managerID; ?>&level=<?php echo $auth->level;?>'>להיכנס למערכת לחץ כאן</a></td></tr>-->
     <a href='admin/get_intoSystem.php?managerID=<?php echo $managerID; ?>'>להיכנס למערכת לחץ כאן</a></td></tr>


	<?php }elseif(($auth->level)=='user'){
		unset($_SESSION['level']);
		unset($_SESSION['uname']);
		unset($_SESSION['admin']);
        $_SESSION['level']=$auth->level;
        $_SESSION['userID']=$auth->user_id;
        $_SESSION['uname']=$auth->username;
	?>
<tr>
  <td> היתחברת כ- משתמש אם שם משתמש     <?php  echo  "$auth->username";  ?>
<!-- 	<a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>&level=<?php echo $auth->level;?>'> להיכנס למערכת לחץ כאן</a>-->
      <a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>'> להיכנס למערכת לחץ כאן</a>
  </td>
</tr>

	<?php }elseif(($auth->level)=='suppervizer'){
		unset($_SESSION['level']);
		unset($_SESSION['uname']);
		unset($_SESSION['admin']);
	    $_SESSION['level']=$auth->level;
	    $_SESSION['userID']=$auth->user_id;
	    $_SESSION['uname']=$auth->username;
	?>
<tr>
   <td>  היתחברת כ- מפקח אם שם משתמש  . <?  echo "  $auth->username;"   ?>
<!-- 	<a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>&level=<?php echo $auth->level;?>'>להיכנס למערכת לחץ כאן</a>-->
     <a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>'>להיכנס למערכת לחץ כאן</a>
  </td>
</tr>



 <?php }
    elseif(($auth->level)=='user_admin'){
        unset($_SESSION['level']);
		unset($_SESSION['uname']);
		unset($_SESSION['admin']);
	    $_SESSION['level']=$auth->level;
	    $_SESSION['userID']=$auth->user_id;
	    $_SESSION['uname']=$auth->username;

   ?>
<tr>
 <td>  היתחברת כ-מנהל+משתמש אם שם משתמש   <?  echo " $auth->username;"   ?>
<!-- 	<a href='<?PHP WEBROOT();?>get_intoSystem.php?user=<?php echo $auth->user_id; ?>&level=<?phpphpphpphpphp echo $auth->level;?>'>להיכנס למערכת לחץ כאן</a>-->
   <a href='<?PHP WEBROOT();?>get_intoSystem.php?user=<?php echo $auth->user_id; ?>'>להיכנס למערכת לחץ כאן</a>
 </td>
</tr>

	<?PHP } ?>


	<a href='logout/index.php'>התנתק</a>

	<?PHP
	else :
	?>

	<p> <a href='login/index.php'>התחבר</a>.</p>
	<?PHP   echo "</table>\n";  endif; ?>
</table>




</body>
</html>