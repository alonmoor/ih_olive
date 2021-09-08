<?php
include_once("classes/Employee.php");
$emp = new Employee();
$id = $emp->escapeString($_GET['id']);
$emp->delete('employee',"id='$id'");
if($emp->getResult()) {
	header("Location:index.php");
}
?>