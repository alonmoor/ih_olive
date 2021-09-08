<?php 
include_once("classes/Employee.php");
$emp = new Employee();
$emp->get('employee', '*', NULL, "", 'id DESC LIMIT 3');
$result = $emp->getResult();
?>
<table class="table table-responsive">
    <thead>
		<tr>
			<th>Name</th>
			<th>Age</th>
			<th>Salary</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php 
	foreach ($result as $key => $res) {
		echo "<tr>";
		echo "<td>".$res['employee_name']."</td>";
		echo "<td>".$res['employee_age']."</td>";
		echo "<td>".$res['employee_salary']."</td>";	
		echo "<td><a href=\"update.php?id=$res[id]\" class=\"btn btn-info\" role=\"button\">Edit</a>  <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\" class=\"btn btn-info\" role=\"button\">Delete</a></td>";		
	}
?>
	</tbody>
</table>

