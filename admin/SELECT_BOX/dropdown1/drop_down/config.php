<?Php
$dbHost='127.0.0.1';
$dbUsername='alon';
$dbPassword='qwerty';
$dbName='olive';



$db=new mysqli($dbHost,$dbUsername,$dbPassword,$dbName)

//////// Do not Edit below /////////
try {
$dbo = new PDO('mysql:host='.$dbhost_name.';dbname='.$database, $username, $password);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
?> 