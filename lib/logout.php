<?php
require_once '../config/application.php';


// unset all the session variables
session_unset();

// destroy the session
session_destroy();




// redirect...
header("Location: decisions.php?mode=list");
?>