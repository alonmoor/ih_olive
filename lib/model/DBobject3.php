<?php
//require_once '../config/application.php';
//require_once (LIB_DIR . "/formfunctions.php");
	class DBObject3
	{
		public    $id;
		public    $searchCols;
		protected $idName;
		protected $tableName;
		//protected $columns = array();
		public $columns = array();

		
 	 
	function __construct($table_name, $id_name, $columns, $id = '',&$formdata="")
		{
// 			if($table_name=='TODOLIST'){
// 			$this->tableName=$table_name;
//			$formdata=$this->select2($id,'decID');
//		    } 
//		    else{
		    	
			if(!$formdata && $formdata==0) {
		    $this->setFormdata($formdata);
			}elseif($table_name=='Forum_dec'){	
		    $this->setParent_forum($formdata);
			}
			$this->tableName = $table_name;
			$this->idName    = $id_name;
			
			if($formdata!=null  ){

            foreach($columns as $key=>$val){
				$this->columns[$val]  =  $formdata[$val];
				UNSET ($this->columns[$key]);
			}   
 
            
            if($id != '')
			     if(!isset($_POST['submit'])){
			     	 
			         $this->select($id);
			     }
				$this->id=$_REQUEST['id'];
				unset($key);
		}
	//}//end else
 } 
/*************************************************************************************************/		
		
function select($id, $column = '')
		{
			global $db;
			if($column == '') $column = $this->idName;

			$id =$db-> escape ($id);
			$column =$db->escape ($column);

			 $sql=("SELECT * FROM " . $this->tableName . " WHERE `$column` = '$id'");
			 $rows=$db->queryObjectArray($sql);
			if(!$rows)
				return false;
			else
			{
				//$row = mysql_fetch_array($db->result, MYSQL_ASSOC);
				//$this->id = $rows[$this->idName];
				$this->id =$id;// $rows[0]->userID ;
				foreach($rows[0] as $key =>$val){
			    $this->columns[$key] = $val;
				}
				 		
		}
		
	}
/*************************************************************************/
	function select2($id, $column = '')
		{
			global $db;
			if($column == '') $column = $this->idName;

			$id =$db-> escape ($id);
			$column =$db->escape ($column);

			 //$sql=("SELECT * FROM " . $this->tableName . " WHERE `$column` = '$id'");
			 
			 
			 $sql=" SELECT * FROM " . $this->tableName . "  inner join decisions     ON decisions.decID=TODOLIST.decID  
                                            left outer JOIN USER      ON  USER.id_user_pk=TODOLIST.id_user  
                                               where " . $this->tableName . ".decID='$id'
					                     ORDER BY id_task_pk DESC";
			 
			 
			 $rows=$db->queryObjectArray($sql);
			if(!$rows)
				return false;
			else
			{
				//$row = mysql_fetch_array($db->result, MYSQL_ASSOC);
				//$this->id = $rows[$this->idName];
				$this->id =$id;// $rows[0]->userID ;
				foreach($rows[0] as $key =>$val){
			    $this->columns[$key] = $val;
				}
			}
			return $rows;
		}
/*************************************************************************/	
		
		//  function __construct( $table, $fields )
//  {
//    $this->table = $table;
//    foreach( $fields as $key )
//      $this->fields[ $key ] = null;
//  }
		

/**********************************************************************************************/
/**********************************************************************************************/		
		function __get($key)
		{
			if(substr($key, 0, 2) == '__')
				return htmlspecialchars($this->columns[substr($key, 2)]);
			else
			   $this->columns[$key]=$this->$key;
				return $this->columns[$key];
		}

		function __set($key, $value)
		{
			if(array_key_exists($key, $this->columns))
			{
				$this->columns[$key] = $value;
				return true;
			}
			return false;
		}
/**************************************************************************************************/			
	function insert4()
	{
		global $db;

		$fields = $this->table."_id, ";
		$fields .= join( ", ", array_keys( $this->fields ) );

		$inspoints = array( "0" );
		foreach( array_keys( $this->fields ) as $field )
		$inspoints []= "?";
		$inspt = join( ", ", $inspoints );

		$sql = "INSERT INTO ".$this->table.
         " ( $fields ) VALUES ( $inspt )";

		$values = array();
		foreach( array_keys( $this->fields ) as $field )
		$values []= $this->fields[ $field ];

		$sth = $db->prepare( $sql );
		$db->execute( $sth, $values );

		$res = $db->query( "SELECT last_insert_id()" );
		$res->fetchInto( $row );
		$this->id = $row[0];
		return $row[0];
	}

/**********************************************************************************************/
	function insert0()
	{
		global $db;
		//$db->getMysqli();
		$fields = $this->table."_id, ";
		$fields .= join( ", ", array_keys( $this->fields ) );
		//$this->fields=$fields;
		$inspoints = array("0");
		foreach( array_keys( $this->fields ) as $field )
		$inspoints []=$this->fields[ $field ];// "?";
		$this->fields=$inspoints;
		//$inspt=$fields;
		$inspt = join( ", ", $inspoints );
		$inspt  = join(",", $this->quoteColumnVals());
		$sql = "INSERT INTO ".$this->table.
      " ( $fields ) VALUES ( $inspt)";

		$db->queryArray($sql);
		// return $row[0];
		return $db->insertId();
			
	}
/**********************************************************************************************/
	function insert2()
	{
		global $db;

		$fields = $this->table."_id, ";
		$fields .= join( ", ", array_keys( $this->fields ) );

		$inspoints = array( "0" );
		foreach( array_keys( $this->fields ) as $field )
		$inspoints []= "?";
		$inspt = join( ", ", $inspoints );

		$sql = "INSERT INTO ".$this->table.
         " ( $fields ) VALUES ( $inspt )";

		$values = array();
		foreach( array_keys( $this->fields ) as $field ){
			$values []= $this->fields[ $field ];
			$val.= $this->fields[ $field ].",";

		}
		//    $sth = $db->getMysqli()->prepare( $sql );
		//    $db->execute( $sth, $values );
		$stmt =$db->getMysqli()->stmt_init();
		//var_dump($stmt);
		$row=$stmt->prepare($sql);
		//$row=$stmt->bind_param("s",$values);
		$x=$stmt->bind_param('sss',$values[sizeof]);//, $values[1], $values[2]);
		printf("%d Row inserted.\n", $stmt->affected_rows);
		$stmt->execute();
		//$stmt->bind_result($values);
		//$stmt->fetch();
		// $res = $db->getMysqli()->insert_id;//query( "SELECT last_insert_id()" );
		//$res->fetchInto( $row );
		//$res=$db->getMysqli()->fetch_row();
		//    $this->id = $row[0];
		//    return $row[0];
		//printf ("New Record has id %d.\n", mysqli_insert_id($link));

		return $stmt->insert_id;
	}

/**********************************************************************************************/

		function replace()
		{
			return $this->insert('REPLACE INTO');
		}


		function insert($cmd = 'INSERT INTO')
		{
			global $db;

			if(count($this->columns) > 0)
			{
				unset($this->columns[$this->idName]);

				$columns = "`" . join("`, `", array_keys($this->columns)) . "`";
				$values  = join(",", $this->quoteColumnVals());
                $query=("$cmd " . $this->tableName . " ($columns) VALUES ($values)");
				$row=$db->execute($query);

				$this->id = $db->insertId();
				return $this->id;
			}
		}

		function update()
		{
			global $db;
            //$this->userID=$_POST['id'];
            $id=$_REQUEST['id'];
			$arrStuff = array();
			unset($this->columns[$this->idName]);
			foreach($this->quoteColumnVals() as $key => $val)
				$arrStuff[] = "`$key` = $val";
			$stuff = implode(", ", $arrStuff);

			$id = $db->escape($this->id);
            $query=('UPDATE ' . $this->tableName . " SET $stuff WHERE " . $this->idName . " = '" . $id . "'"); 
			if($db->execute($query))
			//$mysqli=$db-> getMysqli();
			//return mysql_affected_rows($db->db); // Not always correct due to mysql update bug/feature
			return true;
			return false;
		}

		
/**********************************************************************************************/
  function delete_all()
  {
    global $db;
    //$db->getMysqli();
    $query=( 'DELETE FROM '.$this->tableName );
    //$sth = $db->getMysqli()->prepare( 'DELETE FROM '.$this->table );
    //$db->execute( $sth );
    $db->execute( $query );
  }
	 
/**********************************************************************************************/	
		
 function search()
     {
     	global $db;    

      $query = "SELECT *  FROM users WHERE
                uname='".$this->columns['uname']  ."'" ; 
            $result = $db->execute_query($query);
            return $result;
     }     		
		
		
		function delete()
		{
			global $db;
            $id = $db->escape ($this->id);
			$query=('DELETE FROM ' . $this->tableName . " WHERE `" . $this->idName . "` = '" . $id . "'");
			if($db->execute($query))
			 return true;
			 return false;
			//return mysql_affected_rows($db->db);
		}
/**************************************************************************************************/		
function safify($value, $type='') {
    // we're handling our own quoting, so we don't need magic quotes
    if(get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
   // settype($value, $type);
    switch ($type) {
    case 'int': case 'float': case 'double':
        // the settype() above is all we need to do for numbers
        break;
    case 'boolean': /* processing of booleans depends on where $value is coming
     * from.  This section will probably need to be customized on a
     * per-form basis.
     */
        $vals[$key] = is_null($vals) ? 'NULL' : "'$vals'" ;
		return $vals;
        break;
    case 'string':
    	if(is_array($value)){
    	 $value =(trim($value));	
    	 $value[$key] = is_null($value) ? 'NULL' : "'$value'" ;
    	}else{
    	$value= is_null($value) ? 'NULL' : "'$value'" ;
    	}
		return $value;
		break;
     default:
     	if(is_array($value)){
     	$value[$key] = is_null($value) ? 'NULL' : "'$value'" ;
     	}
     	else{
        $value =(trim($value));// mysql_real_escape_string(trim($value));
        //$value = is_null($value) ? 'NULL' : "'$value'" ;
     	}
		return $value;
        break;
    }
    return $value;
}

/**************************************************************************************************/
		// Grab a large block of instantiated objects from the database using only one query.
		function glob($sql = '')
		{
			global $db;

			$objs = array();
			$rows = $db->getRows("SELECT * FROM {$this->tableName} $sql");
			$class = get_class($this);
			foreach($rows as $row)
			{
				$o = new $class;
				$o->load($row);
				$o->id = $row[$this->idName];
				$objs[$o->id] = $o;
			}
			return $objs;
		}

		function postLoad() { $this->load($_POST); }
		function getLoad()  { $this->load($_GET); }
		function load($arr)
		{
			if(is_array($arr))
			{
				foreach($arr as $key => $val)
					if(array_key_exists($key, $this->columns) && $key != $this->idName)
						$this->columns[$key] = $val;
				return true;
			}

			return false;
	 	}

		function quoteColumnVals()
		{
			global $db;
            //$mysqli=$db->getMysqli();
			$vals = array();
			foreach($this->columns  as $key => $val)
				//$vals[$key] = $mysqli->quote($val);
				$vals[$key] = is_null($val) ? 'NULL' : "'$val'" ; 
			return $vals;
		}
/*********************************************************************************************/	
function DateSort($a, $b) {

	list($day_date ,$month_date ,$year_date ) = explode('-',$a);
     	        if (strlen($year_date) < 3){
		           $a="$year_date-$month_date-$day_date";	
	    	    }else{
			       $a="$day_date-$month_date-$year_date";
	    	    }   
	
list($day_date_b ,$month_date_b ,$year_date_b ) = explode('-',$b);
     	        if (strlen($year_date_b) < 3){
		           $b="$year_date_b-$month_date_b-$day_date_b";	
	    	    }else{
			       $b="$day_date_b-$month_date_b-$year_date_b";
	    	    }  	    
	
    // If the dates are equal, do nothing.
    if($a == $b) return true;
    
    // Dissassemble dates
    list( $aday,$amonth,$ayear) = explode('-',$a);
    list($bday,$bmonth, $byear) = explode('-',$b);

    // Pad the month with a leading zero if leading number not present
    $amonth = str_pad($amonth, 2, "0", STR_PAD_LEFT);
    $bmonth = str_pad($bmonth, 2, "0", STR_PAD_LEFT);

    // Pad the day with a leading zero if leading number not present
    $aday = str_pad($aday, 2, "0", STR_PAD_LEFT);
    $bday = str_pad($bday, 2, "0", STR_PAD_LEFT);

    // Reassemble dates
    $a = $ayear . $amonth . $aday;
    $b = $byear . $bmonth . $bday;

    // Determine whether date $a > $date b
    //return ($a > $b) ? 1 : -1;
  //  var_dump($a); var_dump($b);die;
    return ($a >= $b) ? true : false;
}
/*****************************************************************************************/
/*************************************************************************************************/
function check_date($date) {
    if(strlen($date) == 10) {
        $pattern = '/\.|\/|-/i';    // . or / or -
        preg_match($pattern, $date, $char);
        
        $array = preg_split($pattern, $date, -1, PREG_SPLIT_NO_EMPTY); 
        
        if(strlen($array[2]) == 4) {
            // dd.mm.yyyy || dd-mm-yyyy
            if($char[0] == "."|| $char[0] == "-") {
                $month = $array[1];
                $day = $array[0];
                $year = $array[2];
            }
            // mm/dd/yyyy    # Common U.S. writing
            if($char[0] == "/") {
                $month = $array[0];
                $day = $array[1];
                $year = $array[2];
            }
        }
        // yyyy-mm-dd    # iso 8601
        if(strlen($array[0]) == 4 && $char[0] == "-") {
            $month = $array[1];
            $day = $array[2];
            $year = $array[0];
        }
        if(checkdate($month, $day, $year)) {    //Validate Gregorian date
            return TRUE;
        
        } else {
            return FALSE;
        }
    }else {
        return FALSE;    // more or less 10 chars
    }
  }    	
/***************************************************************************************/	
	
 }//end class dbobject
/*************************************************************************************/
	class TaggableDBObject extends DBObject3
	{
		private $tagCol;

		function __construct($table_name, $id_name, $columns, $id = '')
		{
			parent::__construct($table_name, $id_name, $columns, $id);
			$this->tagCol = get_class($this) . '_id';
		}

		function addTag($name)
		{
			global $db;

			if($this->id == '') return false;
			$t = new Tag($name);
			$db->query("INSERT IGNORE {$this->tableName}2tags ({$this->tagCol}, tag_id) VALUES (?, ?)", $this->id, $t->id);
		}

		function removeTag($name)
		{
			global $db;
			if($this->id == '') return false;
			$t = new Tag($name);
			$db->query("DELETE FROM {$this->tableName}2tags WHERE {$this->tagCol} = ? AND tag_id = ?", $this->id, $t->id);
		}

		function tags()
		{
			global $db;
			if($this->id == '') return false;
			$rows = $db->getRows("SELECT * FROM {$this->tableName}2tags a LEFT JOIN tags t ON a.tag_id = t.id WHERE a.{$this->tagCol} = '{$this->id}'");
			return $rows;
		}

		// Glob by tag name
		function tagged($tag_name, $sql = '')
		{
			global $db;

			$tag = new Tag($tag_name);
			$objs = array();
			$rows = $db->getRows("SELECT b.* FROM {$this->tableName}2tags a LEFT JOIN {$this->tableName} b ON a.{$this->tagCol} = b.{$this->idName} WHERE a.tag_id = {$tag->id} $sql");
			$class = get_class($this);
			foreach($rows as $row)
			{
				$o = new $class;
				$o->load($row);
				$o->id = $row[$this->idName];
				$objs[] = $o;
			}
			return $objs;
		}

		
		
		

		
	}
	

?>