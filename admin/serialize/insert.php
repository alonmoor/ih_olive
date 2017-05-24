<?php
/**
 * Created by PhpStorm.
 * User: alon
 * Date: 03/05/17
 * Time: 18:49
 */
$connect = mysqli_connect("127.0.0.1", "alon", "qwerty", "olive");
if(isset($_POST["name"]))
{
    $name = mysqli_real_escape_string($connect, $_POST["name"]);
    $message = mysqli_real_escape_string($connect, $_POST["message"]);
    $query = "INSERT INTO tbl_form(name, message) VALUES ('".$name."', '".$message."')";
    if(mysqli_query($connect, $query))
    {
        echo '<p>You have entered</p>';
        echo '<p>Name:'.$name.'</p>';
        echo '<p>Message : '.$message.'</p>';
    }
}