<?php
  class DBObject3 {
 
// 	public $id;
//	public  $username;
//	public  $pass;
//	public  $firstname;
//	public  $lastname;
//	public  $fullname;
//	public  $level;
//	 
//	
//	function __construct($id, $username="",$firstname="",$lastname="",$pass="",$level="") {
//		$this->setId($id);
//		$this->setUname($username);
//		$this->setPass($pass);
//		$this->setFname($firstname);
//		$this->setLname($lastname);
//		$this->setLevel($level);
//	}
//    
//	function load_from_db() {
//		global $db;
//		
//		//$sql = "SELECT * FROM users where userID = ".$this->getId();
//		$sql = "SELECT * FROM users where userID =$this->id";
//		//echo $sql;
//		if( $result = $db->execute_query($sql))
//			if( $row = $result->fetch_object() ) {
//				$this->setUname($row->uname);
//				$this->setFname($row->fname);
//				$this->setLname($row->lname);
//				$this->setpass($row->upass);
//				$this->setLevel($row->level);
//			}
//				
//	}
//	function setId($id) {
//		$this->id = $id;
//	}
//    function setUname($username) {
//		$this->username = $username;
//	}
//	
//    function setPass($pass) {
//		$this->pass = $pass;
//	}
//    function setFname($firstname) {
//		$this->firstname = $firstname;
//	}
//	
//    function setLname($lastname) {
//		$this->lastname = $lastname;
//	}
//		
//    function setLevel($level){
//	$this->level = $level;
//    }	
//
//
//	function getId() {
//		return $this->id;
//	}
//	
//	function getUname() {
//		return $this->username;
//	}
//    
//	function getPass() {
//		return $this->pass;
//	}
//	
// function getFname() {
//		return $this->firstname;
//	}
//	
// function getLname() {
//		return $this->lastname;
//	}
//
//
//function getLevel() {
//		return $this->level;
//	}	
//	
///*******************************************************************************************/	
//	function update() {
//		global $db;
//		$sql = "UPDATE users SET
//				uname='".$this->getUname() . "'
//				,fname='".$this->getFname() . "'
//				,lname='".$this->getLname() . "'
//				,upass='".$this->getPass()."'
//				WHERE userID = ". $this->getId();
//		//echo $sql;
//		 return $db->execute_query($sql);
//				
//	}
//	
//	
//		//echo $sql;
//	
//	function insert_user()
//	{
//	global $db;
//		
//		$sql ="INSERT INTO users SET
//				  uname='".$this->getUname()."',
//		          upass='".$this->getPass()."',
//		          fname='".$this->getUname()."',
//		          lname='".$this->getLname()."',
//		          level='".$this->getLevel()."'";
//                  $result= $db->execute_query($sql);
//	              if ($result->num_rows >= 0) {
//                      return $result;
//                }
//
//	 }    
// 
//// 
////    function delete_user(){
////           global $db;	
////           $query="delete from  users where userID=".$this->getId(); 
////           
////           $result=$db->execute_query($query);
////     
////           if ($result->num_rows > 0) {
////               return $result;
////              } else {
////                 echo "  could not delete"; 	
////              }
////     }      
////       
//   
//       function delete_user(){
//           	
//           global $db;	
//           $query = "set foreign_key_checks=0";
//           if($db->execute($query) )           	
//              if( $db->execute("delete from  users where userID=".$this->getId())) 
//              	  $db->execute("set foreign_key_checks=1"); 
//              	 else
//              	  $db->execute("set foreign_key_checks=1");
//     }      
//       
//     
//     
//     function search()
//     {
//     	global $db;    
//
//      $query = "SELECT *  FROM users WHERE
//                uname='".$this->getUname()."'" ; 
//            $result = $db->execute_query($query);
//            return $result;
//      }     
//     
//	
//	 function check(&$err_msg) {
//		return 1;
//		$err_msg = "";
//		if( strlen($this->username) < 1)
//			$err_msg = "String too short";
//			
//				
//		return $err_msg=="";
//	}
//	 
//	
// }   
       
 
        public $id;
		public $searchCols;
		protected $userID;
		protected $idName;
		protected $tableName;
		protected $columns = array();
        protected $uname;
        protected $fname; 
        protected $lname;
        protected $full_name;
        protected $upass;
        protected $level;
        protected $last_login;        
		function __construct($table_name, $id_name, $columns, $id = '')
		{
			 
			//$this->setFormdata($formdata);
			$this->tableName = $table_name;
			$this->idName    = $id_name;

//			foreach($columns as $key){
//				$this->columns[$key]  =  $formdata[$key];
//			}       
			if($id != '')
			     if(!isset($_POST['submit'])){
				 $this->select($id);
			     }
				$this->id=$_REQUEST['id'];
				unset($key);
		}
  
		
//function set($Id,$Uname,$Fname,$Lname,$Upass,$Level){
	function set(){
	     $this->id=$_GET['id'];
//         $this->username=$_POST['username'];
//		 $this->firstname=$_POST['firstname'];
//		 $this->lastname=$_POST['lastname'];
//		 $this->password=$_POST['pass'];
		 $this->level=$_POST['level'];
		// $this->userID=$_GET['id'];
         $this->uname=$_POST['username'];
		 $this->fname=$_POST['firstname'];
		 $this->lname=$_POST['lastname'];
		 $this->upass=$_POST['pass'];
		  
	
}
  function load_from_db() {
		global $db;
		
		//$sql = "SELECT * FROM users where userID = ".$this->getId();
		$sql = "SELECT * FROM users where userID =$this->id";
		//echo $sql;
		if( $result = $db->execute_query($sql))
			if( $row = $result->fetch_object() ) {
				$this->full_name=$row->full_name;
				$this->level=$row->level;
				$this->userID=$row->userID;
				$this->uname=$row->uname;
				$this->fname=$row->fname;
				$this->lname=$row->lname;
				$this->upass=$row->upass;
				$this->last_login=$row->last_login;
			}
				
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
			
			if(substr($key, 0, 2) == '__'){
			return htmlspecialchars($this->columns[substr($key, 2)]);
			}else{
		    $this->columns[$key]=$this->$key;
			return $this->columns[$key];
			}	//return $this->$key;
		}

		
		function setFormdata(&$formdata){
		 $formdata['userID']=$_POST['id'];	
		 $formdata['uname']=$_POST['username'];
		 $formdata['fname']=$_POST['firstname']; 
		 $formdata['lname']=$_POST['lastname']; 
		 $formdata['upass']=$_POST['pass']; 
		 $formdata['full_name']=$_POST['full_name']; 
		 $formdata['level']=$_POST['level']; 
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
				$this->id =$id;// $rows[0]->userID ;
				foreach($rows as $key =>$val){
			    $this->columns[$key] = $val;
				}
//				foreach($rows as $key){
//				$this->columns[$key]  =  $rows[$key];
//			}         
				 		
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
			foreach($this->columns   as $key => $val)
				//$vals[$key] = $mysqli->quote($val);
				$vals[$key] = is_null($val) ? 'NULL' : "'$val'" ; 
			return $vals;
		}
	}

//	class TaggableDBObject extends DBObject2
//	{
//		private $tagCol;
//
//		function __construct($table_name, $id_name, $columns, $id = '')
//		{
//			parent::__construct($table_name, $id_name, $columns, $id);
//			$this->tagCol = get_class($this) . '_id';
//		}
//
//		function addTag($name)
//		{
//			global $db;
//
//			if($this->id == '') return false;
//			$t = new Tag($name);
//			$db->query("INSERT IGNORE {$this->tableName}2tags ({$this->tagCol}, tag_id) VALUES (?, ?)", $this->id, $t->id);
//		}
//
//		function removeTag($name)
//		{
//			global $db;
//			if($this->id == '') return false;
//			$t = new Tag($name);
//			$db->query("DELETE FROM {$this->tableName}2tags WHERE {$this->tagCol} = ? AND tag_id = ?", $this->id, $t->id);
//		}
//
//		function tags()
//		{
//			global $db;
//			if($this->id == '') return false;
//			$rows = $db->getRows("SELECT * FROM {$this->tableName}2tags a LEFT JOIN tags t ON a.tag_id = t.id WHERE a.{$this->tagCol} = '{$this->id}'");
//			return $rows;
//		}
//
//		// Glob by tag name
//		function tagged($tag_name, $sql = '')
//		{
//			global $db;
//
//			$tag = new Tag($tag_name);
//			$objs = array();
//			$rows = $db->getRows("SELECT b.* FROM {$this->tableName}2tags a LEFT JOIN {$this->tableName} b ON a.{$this->tagCol} = b.{$this->idName} WHERE a.tag_id = {$tag->id} $sql");
//			$class = get_class($this);
//			foreach($rows as $row)
//			{
//				$o = new $class;
//				$o->load($row);
//				$o->id = $row[$this->idName];
//				$objs[] = $o;
//			}
//			return $objs;
//		}
//		
//		
//
//		
//	}
	
class Users extends DBObject3
{
	function __construct($id = "")
	{
		parent::__construct('users', 'userID', array('uname','fname', 'lname', 'upass', 'level', 'user_date', 'email', 'full_name', 'last_login', 'phone_num'), $id);
	}
}          
     
?>