<?PHP

//https://www.programmersought.com/article/1614626903/



function array_uniq($my_array, $value)
{
    $count = 0;

    foreach($my_array as $array_key => $array_value)
    {
        if ( ($count > 0) && ($array_value == $value) )
        {
            unset($my_array[$array_key]);
        }

        if ($array_value == $value) $count++;
    }

    return array_filter($my_array);
}
$numbers = array(4, 5, 6, 7, 4, 7, 8);

print_r(array_uniq($numbers, 7));




function list_cmp($a, $b)
{
  global $order;

  foreach($order as $key => $value)
    {
      if($a==$value)
        {
          return 0;
          break;
        }

      if($b==$value)
        {
          return 1;
          break;
        }
    }
}

$order[0] = 1;
$order[1] = 3;
$order[2] = 4;
$order[3] = 2;

$array[0] = 2;
$array[1] = 1;
$array[2] = 3;
$array[3] = 4;
$array[4] = 2;
$array[5] = 1;
$array[6] = 2;

usort($array, "list_cmp");

print_r($array);


function sort_subnets ($x, $y) {
    $x_arr = explode('.', $x);
    $y_arr = explode('.', $y);
    foreach (range(0,3) as $i) {
        if ( $x_arr[$i] < $y_arr[$i] ) {
            return -1;
        }
        elseif ( $x_arr[$i] > $y_arr[$i] ) {
            return 1;
        }
    }
    return -1;
}

$subnet_list =
array('192.169.12',
'192.167.11',
'192.169.14',
'192.168.13',
'192.167.12',
'122.169.15',
'192.167.16'
);
usort($subnet_list, 'sort_subnets');
print_r($subnet_list);






function checkRepeat($arr)
{
	$len = count($arr);
	$i = 0;
	$pos = 0;
	$maxStrLen = 0;
	$set = [];
	while ($i<$len){
		if(array_key_exists($arr[$i],$set)){
			$pos = max($pos,$set[$arr[$i]]);

		}
		$maxStrLen = max($maxStrLen,$i-$pos+1);
		$set[$arr[$i]]=$i+1;
		$i++;
	}
	return $arr;
}

$str = "abcabcbbd";
$str2 = "abcabddaecbbbbaa";
$str3 = "abcabddacbbccabaaddcc";
$a = checkRepeat($str);
print_r($a);
$a2 = checkRepeat($str2);
print_r($a2);
$a3 = checkRepeat($str3);
print_r($a3);

function odd($var)
{
    // returns whether the input integer is odd
    return $var & 1;
}

function even($var)
{
    // returns whether the input integer is even
    return !($var & 1);
}

$array1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
$array2 = [6, 7, 8, 9, 10, 11, 12];

echo "Odd :\n";
print_r(array_filter($array1, "odd"));
echo "Even:\n";
print_r(array_filter($array2, "even"));



// function checkRepeat($str) {
//     $length = strlen($str);
//     if($length<=1){
//         return $length;
//     }
//     $tmp_arr= [];//subStrlen



//     for($i=0;$i<$length;$i++){

//       $arr= implode(',',$str);
//       foreach($arr as $key => $val)
//         $tmp_arr1 = [];//$subStrArr
//         tmp_arr1[] = $val;
//         for($j=$i+1;$j<$count($arr);$j++){
//             $tmp_arr1 [] = $arr[$j];
//             if(count(array_unique($subSttmp_arr1rArr))!=count($tmp_arr1)){
//                 tmp_arr1[] = val;

//                 break;
//             }

//         }
//         $subStrlen = count($subStrArr)>count($subStrlen)?$subStrArr:$subStrlen;
//     }
//     return count($subStrlen);
// }






//-------------------------------------------------------------------------------------
// session_start();
	require 'includes/master.inc.php';
	require_once 'config/application_no_session.php';
 session_start();
	 global $db;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html dir=rtl xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>index</title>
   <link rel="stylesheet" href="html/css/table.css" type="text/css" media="screen" title="Screen" charset="utf-8" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/bootstrap.min.css" />

</head>

<body class="container">
    <table>
	<h1>מערכת ניהול - pdf </h1>
	<?PHP echo '<table class="table">', "\n"; if($auth->ok()) : ?>
	<?PHP if (($auth->level)=='admin'){
		unset($_SESSION['level']);
		unset($_SESSION['uname']);
	$_SESSION['level']=$auth->level;
	$_SESSION['userID']=$auth->user_id;
	$_SESSION['uname']=$auth->username;
	$sql="select managerID from managers where userID=$auth->user_id";
	if($rows=$db->queryObjectArray($sql)){
		$managerID=$rows[0]->managerID;
	}

	?>
 	<tr><td>  היתחברת כ- מנהל אם שם משתמש   <?php  echo " $auth->username";  ?>

<!-- 	<a href='admin/get_intoSystem.php?managerID=<?php echo $managerID; ?>&level=<?php echo $auth->level;?>'>להיכנס למערכת לחץ כאן</a></td></tr>-->
     <a href='admin/get_intoSystem.php?managerID=<?php echo $managerID; ?>'>להיכנס למערכת לחץ כאן</a></td></tr>


	<?php }elseif(($auth->level)=='user'){
		unset($_SESSION['level']);
		unset($_SESSION['uname']);
		unset($_SESSION['admin']);
        $_SESSION['level']=$auth->level;
        $_SESSION['userID']=$auth->user_id;
        $_SESSION['uname']=$auth->username;
	?>
<tr>
  <td> היתחברת כ- משתמש אם שם משתמש     <?php  echo  "$auth->username";  ?>
<!-- 	<a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>&level=<?php echo $auth->level;?>'> להיכנס למערכת לחץ כאן</a>-->
      <a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>'> להיכנס למערכת לחץ כאן</a>
  </td>
</tr>

	<?php }elseif(($auth->level)=='suppervizer'){
		unset($_SESSION['level']);
		unset($_SESSION['uname']);
		unset($_SESSION['admin']);
	    $_SESSION['level']=$auth->level;
	    $_SESSION['userID']=$auth->user_id;
	    $_SESSION['uname']=$auth->username;
	?>
<tr>
   <td>  היתחברת כ- מפקח אם שם משתמש  . <?  echo "  $auth->username;"   ?>
<!-- 	<a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>&level=<?php echo $auth->level;?>'>להיכנס למערכת לחץ כאן</a>-->
     <a href='admin/get_intoSystem.php?user=<?php echo $auth->user_id; ?>'>להיכנס למערכת לחץ כאן</a>
  </td>
</tr>



 <?php }
    elseif(($auth->level)=='user_admin'){
        unset($_SESSION['level']);
		unset($_SESSION['uname']);
		unset($_SESSION['admin']);
	    $_SESSION['level']=$auth->level;
	    $_SESSION['userID']=$auth->user_id;
	    $_SESSION['uname']=$auth->username;

   ?>
<tr>
 <td>  היתחברת כ-מנהל+משתמש אם שם משתמש   <?  echo " $auth->username;"   ?>
<!-- 	<a href='<?PHP WEBROOT();?>get_intoSystem.php?user=<?php echo $auth->user_id; ?>&level=<?php echo $auth->level;?>'>להיכנס למערכת לחץ כאן</a>-->
   <a href='<?PHP WEBROOT();?>get_intoSystem.php?user=<?php echo $auth->user_id; ?>'>להיכנס למערכת לחץ כאן</a>
 </td>
</tr>

	<?PHP } ?>


	<a href='logout/index.php'>התנתק</a>

	<?PHP
	else :
	?>

	<p> <a href='login/index.php'>התחבר</a>.</p>
	<?PHP   echo "</table>\n";  endif; ?>
</table>

</body>
</html>
