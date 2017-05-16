<?php

//if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD))
//{
//    die('Error: Unable to connect to database server.');
//}
//
//if (!mysql_select_db(DB_SCHEMA, $GLOBALS['DB']))
//{
//    mysql_close($GLOBALS['DB']);
//    die('Error: Unable to select database schema.');
//}
//
//if(!mysql_query("SET CHARACTER SET utf8")){
//			throw new Exception('Could not set character set UTF-8.');
//}




$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($link, 'utf8');
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}




$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


// Set the character set:
mysqli_set_charset($dbc, 'utf8');
function escape_data ($data) { 

	global $dbc; // Database connection.
	

	if (get_magic_quotes_gpc()) $data = stripslashes($data);
	

	return mysqli_real_escape_string (trim ($data), $dbc);
	
} 
// This function returns the hashed version of a password.
// It takes the user's password as its one argument.
// It returns a binary version of the password, already escaped to use in a query.
function get_password_hash($password) {
	
	// Need the database connection:
	global $dbc;
	
	// Return the escaped password:
	return mysqli_real_escape_string ($dbc, hash_hmac('sha256', $password, 'c#haRl891', true));
	
} // End of get_password_hash() function.

/*************************************************************************************************/

class MyDb {
  protected $mysqli;
  protected $showerror = TRUE;   // set FALSE if you don't want to see error messages
  protected $showsql  =False;//TRUE;  // set TRUE if you want to see all SQL queries for debugging purposes
  protected $sqlcounter = 0;     // counter for SQL commands
  protected $rowcounter = 0;     // counter for returned SELECT rows
  protected $dbtime     = 0;     // counter for time needed to execute queries
  protected $starttime;

  // constructor
  function __construct() {
  	
   // require_once 'password.php' ;
   
    //$this->mysqli = @new mysqli($mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb);
   $this->mysqli = @new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);            
    
    
    // testen, ob Verbindung OK
    if(mysqli_connect_errno()) {
      $this->printerror("Sorry, no connection! (" . mysqli_connect_error() . ")");
      // you might add output for HTML code to close the page
      // here (</body></html> etc.)
      $this->mysqli = FALSE;
      exit();
    }
    $this->starttime = $this->microtime_float();
  }  
/*********************************************************************************************/
   //destructor
  function __destruct() {
        $this->close();
   }
/*********************************************************************************************/
  // explicit close
  function close() {
    if($this->mysqli){
      $this->mysqli->close();
      $this->mysqli = FALSE;
    }
  }
  
  
/*********************************************************************************************/
  function getMysqli() {
    return $this->mysqli; }
/*********************************************************************************************/
  // execute SELECT query, return array
  function queryObjectArray($sql) {
    $this->sqlcounter++;
    $this->printsql($sql);
    $time1  = $this->microtime_float();
    //$this->getMysqli()->real_escape_string($usr_name)
    $result = $this->mysqli->query(($sql));
    $time2  = $this->microtime_float();
    $this->dbtime += ($time2 - $time1);
    
    if($result) {
      if($result->num_rows) {
        while($row = $result->fetch_object())
          $result_array[] = $row;
        $this->rowcounter += sizeof($result_array);
        return $result_array; }
      else
        return FALSE;
    } else {
      $this->printerror($this->mysqli->error);
      return FALSE;
    }
  }
  
/*********************************************************************************************/ 
  
   // execute SELECT query, return array
  function queryArray($sql) {
    $this->sqlcounter++;
    $this->printsql($sql);
    $time1  = $this->microtime_float();
    $result = $this->mysqli->query($sql);
    $time2  = $this->microtime_float();
    $this->dbtime += ($time2 - $time1);
    if($result) {
      if($result->num_rows) {
        while($row = $result->fetch_array())
          $result_array[] = $row;
        $this->rowcounter += sizeof($result_array);
        return $result_array; }
      else
        return FALSE;
    } else {
      $this->printerror($this->mysqli->error);
      return FALSE;
    }
  }
  
  
  
/*********************************************************************************************/  
  
  function execute_query($sql) {
	 $result = $this->mysqli->query($sql);
	return $result; 
}
 
        

/*********************************************************************************************/ 

  // execute a SELECT query which returns only a single
  // item (i.e. SELECT COUNT(*) FROM table); return
  // this item
  // beware: this method return -1 for errors (not 0)!
  function querySingleItem($sql) {
    $this->sqlcounter++;
    $this->printsql($sql);
    $time1  = $this->microtime_float();
    $result = $this->mysqli->query($sql);
    $time2  = $this->microtime_float();
    $this->dbtime += ($time2 - $time1);
    if($result) {
      if ($row=$result->fetch_array()) {
        $result->close();
        $this->rowcounter++;
        return $row[0];
      } else {
        // query returned no data
        return -1;
      }
    } else {
    	$this->printerror($this->mysqli->error);
      return -1;
    }
  }


/*********************************************************************************************/ 
  
  
  // execute a SQL command without results (no query)
  function execute($sql) {
    $this->sqlcounter++;
     $this->printsql($sql);
    $time1  = $this->microtime_float();
    $result = $this->mysqli->real_query($sql);
    $time2  = $this->microtime_float();
    $this->dbtime += ($time2 - $time1);
    if($result)
      return TRUE;
    else {
      $this->printerror($this->mysqli->error);
      return FALSE;
    }
  }
/*********************************************************************************************/
// execute multi SQL commands, for TRIGGERS, PROCEDURES, FUNCTIONS, etc...
	function multiExecute($sql) {
	 	 $this->printsql($sql);
		if($this->mysqli->multi_query($sql))
			return TRUE;
		else {
			$this->printerror($this->mysqli->error);
			return FALSE;
		}
	}
  
  
  // get insert_id after an INSERT command
  function insertId() {
    return $this->mysqli->insert_id; }

  // insert \ before ', " etc.
  function escape($txt) {
    return trim($this->mysqli->escape_string($txt)); }

  // return 'NULL' or '<quoted string>'
  function sql_string($txt) {
    if(!$txt || trim($txt)=="")
      return 'NULL';
    else
      return "'" . $this->escape(trim($txt)) . "'";  }
      
/*********************************************************************************************/      
function is_num ($n) {
		if(is_numeric($n))
		return $n;
		else
		return 'NULL';
	}
      
/*********************************************************************************************/
  function error() {
    return $this->mysqli->error; }
/*********************************************************************************************/
  private function printsql($sql) {
    if($this->showsql)
      printf("<p class='error'><font color=\"#0000ff\">%s</font></p>\n",
        htmlspecialchars($sql, ENT_COMPAT, "UTF-8"));    }
/*********************************************************************************************/
  private function printerror($txt) {
    if($this->showerror)
      printf("<p class='error'><font color=\"#ff0000\">%s</font></p>\n",
        htmlspecialchars($txt, ENT_COMPAT, "UTF-8")); }
/*********************************************************************************************/
  function showStatistics() {
    $totalTime = $this->microtime_float() - $this->starttime;
    printf("<p><font color=\"#0000ff\">SQL commands: %d\n",
      $this->sqlcounter);
    printf("<br />Sum of returned rows: %d\n",
      $this->rowcounter);
    printf("<br />Sum of query time (MySQL): %f\n",
      $this->dbtime);
    printf("<br />Processing time (PHP): %f\n",
      $totalTime - $this->dbtime);
    printf("<br />Total time since MyDB creation / last reset: %f</font></p>\n",
      $totalTime);    }
/*********************************************************************************************/
  function resetStatistics() {
    $this->sqlcounter = 0;
    $this->rowcounter = 0;
    $this->dbtime     = 0;
    $this->starttime = $this->microtime_float();  }
/*********************************************************************************************/
  private function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec); }

/*********************************************************************************************/

function quote($s)
	{
		return '\''. addslashes($s). '\'';
	}
/*********************************************************************************************/
	
function quoteForLike($format, $s)
	{
		$s = str_replace(array('%','_'), array('\%','\_'), addslashes($s));
		return '\''. sprintf($format, $s). '\'';
	}
/*********************************************************************************************/
    



/********************************************************************************/
}
       
  