<?php 
$dbHost='127.0.0.1';
$dbUsername='alon';
$dbPassword='qwerty';
$dbName='olive';



$db=new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

if($db->connect_error){
die("conection failed:".$db->connect_error);



}

?>