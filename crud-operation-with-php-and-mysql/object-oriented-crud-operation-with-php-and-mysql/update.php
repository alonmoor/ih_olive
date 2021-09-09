<?php 
include('header.php');
include_once("classes/Employee.php");
$emp = new Employee();
$id = $emp->escapeString($_GET['id']);
// Get employee details
$emp->get('employee', '*', NULL, "id='$id'");
$result = $emp->getResult();
foreach ($result as $res) {
	$name = $res['employee_name'];
	$age = $res['employee_age'];
	$salary = $res['employee_salary'];
}
// Update employee details
if(isset($_POST['update'])) {	
	$id = $emp->escapeString($_POST['id']);	
	$name = $emp->escapeString($_POST['name']);
	$age = $emp->escapeString($_POST['age']);
	$salary = $emp->escapeString($_POST['salary']);	
	$emptyInput = $emp->check_empty($_POST, array('name', 'age', 'salary'));
	if(!$emptyInput) {
		$array = array( 
			"employee_name" => $name, 
			"employee_age" => $age, 
			"employee_salary" => $salary		
		); 
		$emp->update('employee',$array,"id='$id'"); 
		if($emp->getResult()){
			header("Location: index.php");
		}	
	}
} 
?>
<title>phpzag.com : Demo Object Oriented CRUD Operation with PHP and MySQL</title>
<?php include('container.php');?>
<div class="container">
	<h3>Edit Employee Details</h3>	
	<form name="form1" method="post">
		<table class="table-condensed" width="25%" border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name" value="<?php echo $name;?>"></td>
			</tr>
			<tr> 
				<td>Age</td>
				<td><input type="text" name="age" value="<?php echo $age;?>"></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="text" name="salary" value="<?php echo $salary;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update" class="btn btn-info"></td>
			</tr>
		</table>
	</form>		
</div>
<?php include('footer.php');?>
