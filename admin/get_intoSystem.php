<?php 
session_start();


require_once ("../config/application.php");
if( array_item($_REQUEST, 'user') && is_numeric($_GET['user'] ) && !(empty($_GET['user']  )) ){
//$_SESSION['uname']=$_COOKIE['auth_username'];

/*************USER_PAGE_PLACE***********************/
//$_SESSION['level']=$_GET['level'];	


$_SESSION['dec_level']=10;
 $_SESSION['flag_down']=true;
 html_header();
 /***********ADMIN_PAGE_PLACE********************/
 }else{
 //$_SESSION['uname']=$_COOKIE['auth_username'];	
 $_SESSION['dec_level']=10;
$_SESSION['flag_down']=true;
 }
 //$_SESSION['auth_username']=$_COOKIE['auth_username'];
require_once ("find3.php");
?>