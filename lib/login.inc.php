<?php 

// This is the login page for the site.
// It's included by index.php, which receives the login form data.
// This script is created in Chapter 4.

// Array for recording errors:
$login_errors = array();

// Validate the email address:
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$e = mysqli_real_escape_string ($dbc, $_POST['email']);
} else {
	$login_errors['email'] = 'הכנס כתובת דואר אלקטרוני חוקי!';
}

// Validate the password:
if (!empty($_POST['pass'])) {
	$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
} else {
	//$login_errors['pass'] = 'Please enter your password!';
	
	$login_errors['pass'] = 'הכנס סיסמה חוקית!';
	
}
	
if (empty($login_errors)) { // OK to proceed!

	// Query the database:
	$q = "SELECT userID, uname, level, IF(date_expires >= NOW(), true, false) FROM users
	  WHERE (email='$e' AND upass='$p')"; 
	     //  WHERE (email='$e' AND upass='"  .  get_password_hash($p) .  "')";		
	$r = mysqli_query ($dbc, $q);
	
	if (mysqli_num_rows($r) == 1) { // A match was made.
		
		// Get the data:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM); 
		
		// If the user is an administrator, create a new session ID to be safe:
		// This code is created at the end of Chapter 4:
		if ($row[2] == 'admin') {
			session_regenerate_id(true);
			$_SESSION['user_admin'] = true;
		}
		
		// Store the data in a session:
		$_SESSION['userID'] = $row[0];
		$_SESSION['uname'] = $row[1];
		$_SESSION['level'] = $row[2];
		
		// Only indicate if the user's account is not expired:
		if ($row[3] == 1) $_SESSION['user_not_expired'] = true;
			
	} else { // No match was made.
		$login_errors['login'] = 'דואר אלקטרוני וסיסמא לא תואמים.';
	}
	
} // End of $login_errors IF.

// Omit the closing PHP tag to avoid 'headers already sent' errors!