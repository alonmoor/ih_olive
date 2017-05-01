<?Php
/////// Update your database login details here /////
$host_name='127.0.0.1';
$username='alon';
$password='qwerty';
$database='olive';



//define('DB_HOST', '192.168.0.204');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'alon');
define('DB_PASSWORD','qwerty');
define('DB_TBL_PREFIX', '');



//define('DB_DATABASE','dec_tests');
//define('DB_SCHEMA', 'dec_tests');


define('DB_DATABASE','pdf');
define('DB_SCHEMA', 'pdf');

//////// End of database details of your server //////

//////// Do not Edit below /////////
$connection = mysqli_connect($host_name, $username, $password, $database);

if (!$connection) {
    echo "Error: Unable to connect to MySQL.<br>";
    echo "<br>Debugging errno: " . mysqli_connect_errno();
    echo "<br>Debugging error: " . mysqli_connect_error();
    exit;
}
?> 