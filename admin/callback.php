<?php 
require_once '../config/application.php';
global $db;
// An example callback function
function my_callback_function() {
    echo 'hello world!';
}

// An example callback method
class MyClass {
    static function myCallbackMethod() {
        echo 'Hello World!';
    }
}

// Type 1: Simple callback
call_user_func('my_callback_function'); 

// Type 2: Static class method call
call_user_func(array('MyClass', 'myCallbackMethod')); 

// Type 3: Object method call
$obj = new MyClass();
call_user_func(array($obj, 'myCallbackMethod'));

// Type 4: Static class method call (As of PHP 5.2.3)
call_user_func('MyClass::myCallbackMethod');

// Type 5: Relative static class method call (As of PHP 5.3.0)
class A {
    public static function who() {
        echo "A\n";
    }
}

class B extends A {
    public static function who() {
        echo "B\n";
    }
}

//call_user_func(array('B', 'parent::who')); // A

 
//$mysqli = new mysqli("192.168.0.204", "alon", "qwerty", "dec");

$query=("CREATE TEMPORARY TABLE myCity LIKE City");

$rows=$db->execute_query($query);
//$mysqli->query("CREATE TEMPORARY TABLE myCity LIKE City");

$city = "'s Hertogenbosch";

/* this query will fail, cause we didn't escape $city */
if (!$db->execute ("INSERT into myCity (Name) VALUES ('$city')")) {
	$mysqli=$db->getMysqli();
    printf("Error: %s\n", $mysqli->sqlstate);
}

$city = $mysqli->real_escape_string($city);
$query=("INSERT into myCity (Name) VALUES ('$city')");
/* this query with escaped $city will work */
if ($db->execute($query)) {
    printf("%d Row inserted.\n", $mysqli->affected_rows);
}

$mysqli->close();
?>

 
