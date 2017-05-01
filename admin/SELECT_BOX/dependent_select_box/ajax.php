<?php 
require_once('database.php');

//Ajax call for state where values are going to be fetch by country_id
if(isset($_POST['country_id'])&&!empty($_POST['country_id'])){
//echo $_POST['country_id'];exit;
 
$query = $db->query("SELECT * FROM states WHERE country_id = ".$_POST['country_id']." AND status = 1 ORDER BY state_name ASC");
$rowCount= $query->num_rows;

if($rowCount>0){
echo '<option value="">Select State</option>';
while($row=$query->fetch_assoc()){

echo '<option value="'.$row['state_id'].'">'.$row['state_name'].'</option>';


}

}
else{

echo '<option value"">State Not Available</option>';

}
}



//Ajax call for city where values are going to be fetch by state_id
if(isset($_POST['state_id'])&&!empty($_POST['state_id'])){

$query=$db->query("SELECT * FROM cities WHERE state_id=".$_POST['state_id']." AND status= 1 ORDER BY city_name ASC");
$rowCount=$query->num_rows;

if($rowCount>0){
echo '<option value="">Select City</option>';
while($row=$query->fetch_assoc()){

echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';


}

}
else{

echo '<option value"">City Not Available</option>';

}
}
?>











?>