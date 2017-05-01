<?php
//phpinfo();

//define('DB_HOST', '192.168.0.204');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'alon');
define('DB_PASSWORD','qwerty');
define('DB_TBL_PREFIX', '');



//define('DB_DATABASE','dec_tests');
//define('DB_SCHEMA', 'dec_tests');


define('DB_DATABASE','pdf');
define('DB_SCHEMA', 'pdf');
?>

<html><body>
<form enctype="multipart/form-data" method="post" accept-charset="utf-8" dir="rtl">
<br />

  <input type="file" name="image"  />
	<br /><br />


<input type="submit" name="submit_add_pdf" value=" הוסף את ה-PDF" id="submit_add_pdf" class="formbutton" />

<?PHP

if (isset($_POST['submit_add_pdf'])){
    if(getimagesize($_FILES['image']['tmp_name'])==FALSE){
        echo "Please select an image.";
    }else{
        $image = addslashes($_FILES['image']['tmp_name']);
        $name = addslashes($_FILES['image']['name']);
        $image = file_get_contents($image);
        $image = base64_encode($image);
        saveimage($name,$image);
	}

}
displayimage();
function saveimage($name,$image){

    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    mysqli_set_charset($link, 'utf8');
    if (!$mysqli) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }



    $sql = "INSERT INTO olive_pdf (name,image)values('$name','$image')";
    $result =$mysqli->query($sql);
//$sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName) " .
//         " VALUES (" .
//        $mysqli->escape_string($data["level"]) . "," .
//		$mysqli->escape_string($data["decID"]) . ", " .
//		$mysqli->escape_string($data["parentDecID"]) . ", " .
//	    $mysqli->escape_string($data['decName']) . " ) " ;

    if ($mysqli->errno) {
        die("Execution failed image not upload: ".$mysqli->errno.": ".$mysqli->error);
    }else{
        echo "image upload";
    }
    mysqli_close($mysqli);

}

function displayimage(){

    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    mysqli_set_charset($link, 'utf8');
    if (!$mysqli) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
$query = "SELECT * FROM olive_pdf WHERE ";
$result = mysqli_query($mysqli, $query) or die("Query failed");

$nodes=array();


while ($row = mysqli_fetch_array($result)) {

    echo '<image height="300" width="300" src="data:image;base64,' .$row[2]. ' ">';

}
    mysqli_close($mysqli);
}


?>
</body></html>