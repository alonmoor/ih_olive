<?php
//require_once '../config/application.php';
//require_once (LIB_DIR . "/formfunctions.php");
	class DBObject2
	{
		public $id;
		public $searchCols;
		protected $idName;
		protected $tableName;
		protected $columns = array();

		function __construct($table_name, $id_name, $columns, $id = '')
		{
			$this->tableName = $table_name;
			$this->idName    = $id_name;

			foreach($columns as $key)
				$this->columns[$key] = null;

			if($id != '')
				$this->select($id);
		}
  
		
/**********************************************************************************************/	  
//  function __construct( $table, $fields )
//  {
//    $this->table = $table;
//    foreach( $fields as $key )
//      $this->fields[ $key ] = null;
//  }
/**********************************************************************************************/
//	class Book extends DBObject 
//{
//  function __construct()
//  {
//  parent::__construct( 'book' 
//    array( 'author', 'title', 'publisher' ) );
//  }
//}		
/**********************************************************************************************/  
//  
//  function __get( $key )
//  {
//    return $this->columns[ $key ];
//  }

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
				$this->id = $rows[0]-> forum_decID ;
				foreach($rows as $key => $val)
					$this->columns[$key] = $val;
			}
		}

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
	}

	class TaggableDBObject extends DBObject2
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
	
class Users extends DBObject2
{
	function __construct($id = "")
	{
		parent::__construct('users', 'userID', array('fname', 'lname', 'upass', 'forum_decID', 'forumDate', 'active', 'authent', 'uname', 'level', 'dd', 'mm', 'yy', 'user_date', 'email', 'full_name', 'last_login', 'phone_num'), $id);
	}
}


//class Forums_dec extends DBObject2
//{
//	function __construct($id = "")
//	{
//		parent::__construct('forums_dec', 'forum_decID', array('forum_decName', 'managerID', 'appointID', 'forum_date', 'authent', 'voteID', 'managerName', 'appointName'), $id);
//	}
//}
?>