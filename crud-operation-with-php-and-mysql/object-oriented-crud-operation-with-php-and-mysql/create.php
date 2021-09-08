<?php 
include('header.php');
include_once("classes/Employee.php");
$emp = new Employee();
$inserted = 0;
if(isset($_POST['Submit'])) {
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
		$emp->insert('employee',$array);  
		$inserted = $emp->getResult(); 		
	}
}
?>
<title>phpzag.com : Demo Object Oriented CRUD Operation with PHP and MySQL</title>
<?php include('container.php');?>
<div class="container">
	<h3>Add Employee Details</h3>		
	<form method="post" name="form1" >
	    <table class="table-condensed" width="25%" border="0">
		    <tr> 
				<td>&nbsp;</td>
				<td><?php	
					if($inserted) {
						echo "<font color='green'>Employee records inserted successfully.";		
					}
					echo "<a href='index.php'>View Employee</a>";
					?>
				</td>
			</tr>
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr> 
				<td>Age</td>
				<td><input type="number" name="age"></td>
			</tr>
			<tr> 
				<td>Salary</td>
				<td><input type="number" name="salary"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit" value="Save" class="btn btn-info"></td>
			</tr>
		</table>
	</form>		
</div>
<?php include('footer.php');?>
