<?php

// This script displays the login form.
// This script is included by footer.html, if the user isn't logged in.
// This script is created in Chapter 4.

// Create an empty error array if it doesn't already exist:
if (!isset($login_errors)) $login_errors = array();

// Need the form functions script, which defines create_form_input():
// The file may already have been included (e.g., if this is register.php or forgot_password.php).
//include ('login_form.inc.php'); //(LIB_DIR.'/login_form.inc.php'); 
require_once (LIB_DIR.'/form_functions.inc.php');
?><div class="title">
	<h4>היתחבר</h4>
</div>
<form action="index.php" method="post" accept-charset="utf-8">
<p><?php 
    if (array_key_exists('login', $login_errors)) {
	echo '<span class="error">' . $login_errors['login'] . '</span><br />';
	}
	?>
	<label for="email"><strong style="font-weight:bold;color:brown;">דואר אלקטרוני</strong></label><br />
	<?php 
	create_form_input('email', 'text', $login_errors); 
	?>
	<br /><label for="pass"><strong style="font-weight:bold;color:brown;">סיסמה</strong></label><br />
	<?php
	 create_form_input('pass', 'password', $login_errors); 
	 ?> 
	 <br /><label for="username"><strong style="font-weight:bold;color:brown;">שם משתמש</strong></label><br />
	<?php
	 create_form_input('username', 'text', $login_errors); 
	 ?> 
	 
	 
	 
	 <a href="index.php?mode=forgot"><strong style="font-weight:bold;color:brown;">לא זוכר/ת</strong></a><br /><br />
	 <input type="submit" id="conect" name="conect" value="&larr;היתבר " style="font-weight:bold;color:brown;">
</p>
</form>