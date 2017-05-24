<?php 
session_start();


require_once ("../config/application.php");
if( array_item($_REQUEST, 'user') && is_numeric($_GET['user'] ) && !(empty($_GET['user']  )) ){
//$_SESSION['uname']=isset($_COOKIE['auth_username']) ? $_COOKIE['auth_username'] : '';

/*************USER_PAGE_PLACE***********************/
//$_SESSION['level']=isset($_GET['level']) ? $_GET['level'] : '' ;


 $_SESSION['flag_down']=true;
 html_header();
 /***********ADMIN_PAGE_PLACE********************/
 }else{
// $_SESSION['uname'] = isset($_COOKIE['auth_username']) ? $_COOKIE['auth_username'] : '' ;
 //$_SESSION['dec_level']=10;
$_SESSION['flag_down']=true;
 }
 $_SESSION['auth_username'] = isset($_COOKIE['auth_username']) ? $_COOKIE['auth_username'] : '';
$_SESSION['flag_down']=true;
html_header();
//require_once ("find3.php");
?>