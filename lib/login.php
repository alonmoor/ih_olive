<?php
require_once '../config/application.php';
 
$_SESSION["userID"] = 2;
@header("Location: users.php?mode=list");

//unset($_SESSION['username']);	
//$_SESSION['username']=alon;	 
//session_start();
//// Has a session been initiated previously?
//if (! isset($_SESSION['username'])) {
//// If no previous session, has the user submitted the form?
//if (isset($_POST['username']))
//{
//$username = mysqli_real_escape_string($_POST['username']);
//$pswd = mysqli_real_escape_string($_POST['pswd']);
//// Connect to the MySQL server and select the database
//include 'lib/mysql_setup.php';
//// Look for the user in the users table.
//$query = "SELECT username FROM users
//WHERE username='$username' AND pswd='$pswd'";
//$result = mysql_query($query);
//// Has the user been located?
//if (mysql_numrows($result) == 1)
//{
//$_SESSION['username'] = mysql_result($result,0,"username");
//echo "You've successfully logged in. ";
//}
//// If the user has not previously logged in, show the login form
//} else {
//include "login.html";
//}
//// The user has returned. Offer a welcoming note.
//} else {
//printf("Welcome back, %s!", $_SESSION['username']);
//}
?>