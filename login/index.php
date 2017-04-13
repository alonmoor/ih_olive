<?PHP
 //unset session_set_save_handler in class dbsession func register
require '../includes/master.inc.php';
  session_start();
	// Kick out user if already logged in
if($auth->ok()) {
redirect(WEB_ROOT);
}
//	if($auth->ok())
//		redirect("../");

	// Try to log in...
	$alert = "";
	if(!empty($_POST['username']))
	{
		$auth->login($_POST['username'], $_POST['password']);
		if($auth->ok()){
			//redirect("../");
			redirect(WEB_ROOT);
		}else{
			$alert = "<div class='alert'>מצטערים סיסמא או שם משתמש לא נכונים</div>";
			echo $alert;
        }
	}

	$username = isset($_POST['username']) ? $_POST['username'] : "";
	$username = htmlspecialchars($username);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html dir=rtl xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>index</title>

	<link rel="stylesheet" href="<?PHP WEBROOT();?>/html/css/table.css" type="text/css" media="screen" title="Screen" charset="utf-8" />
</head>

<body>

	<form action="<?php echo $_SERVER['SCRIPT_NAME']?>"  method="post">
		<?PHP echo '<table class="table">', "\n";   echo $alert;?>
		<p><label for="username">שם משתמש:</label> <input type="text" name="username" value="<?PHP echo $username;?>" id="username" /></p>
		<p><label for="password">סיסמא:    </label> <input type="password" name="password" value="" id="password" /></p>
		<p><input type="submit" name="btnlogin" value="לחץ לרישום" id="btnlogin" /></p>
		<?php  echo '</table>' ?>
	</form>

</body>

</html>