<?php

//
//Step 3.Connect to the database and Send data
//We make a PHP file save it with a name fetch_data.php which is used to connect and fetch data and then send data to select.php file on ajax request.
//define('DB_HOST', '192.168.0.204');



if(isset($_POST['get_option']))
{
// $host = 'localhost';
// $user = 'root';
// $pass = '';
// mysql_connect($host, $user, $pass);




    $state = $_POST['get_option'];
 $find=mysqli_query("select city from places where state='$state'");
 while($row=mysqli_fetch_array($find))
 {
  echo "<option>".$row['city']."</option>";
 }
 exit;
}
?>
