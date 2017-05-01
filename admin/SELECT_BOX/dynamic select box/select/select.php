<html>
<head>
<link rel="stylesheet" type="text/css" href="select_style.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
function fetch_select(val)
{
 $.ajax({
 type: 'post',
 url: 'fetch_data.php',
 data: {
  get_option:val
 },
 success: function (response) {
  document.getElementById("new_select").innerHTML=response; 
 }
 });
}

</script>

</head>
<body>
<p id="heading">Dynamic Select Option Menu Using Ajax and PHP</p>
<center>
<div id="select_box">
 <select onchange="fetch_select(this.value);">
  <option>Select state</option>
  <?php





  // mysql_select_db('demo');

    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'alon');
    define('DB_PASSWORD','qwerty');
    define('DB_TBL_PREFIX', '');



//define('DB_DATABASE','dec_tests');
//define('DB_SCHEMA', 'dec_tests');


    define('DB_DATABASE','olive');
    define('DB_SCHEMA', 'olive');

    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    mysqli_set_charset($link, 'utf8');
    if (!$link) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }


  $select=_query("select state from places group by state");



  while($row=mysqli_fetch_array($select))
  {
   echo "<option>".$row['state']."</option>";
  }
 ?>
 </select>

 <select id="new_select">
 </select>
	  
</div>     
</center>
</body>
</html>
