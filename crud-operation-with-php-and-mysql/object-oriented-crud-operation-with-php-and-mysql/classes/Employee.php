<?php
class Employee {
	private $databaseHost = "localhost";
	private $databaseUser = "root";
	private $databasePass = "";
	private $databaseName = "phpzag_demos";	
	private $connection = false;
	private $result = array();
    private $myQuery = "";
    private $numResults = "";	
	public function __construct() {
		self::connect();
	}
	private function connect(){
		if(!$this->connection){
			$connected = @mysql_connect($this->databaseHost,$this->databaseUser,$this->databasePass);
            @mysql_set_charset('utf8', $connected);
            if($connected){
            	$seldb = @mysql_select_db($this->databaseName,$connected);
                if($seldb){
                	$this->connection = true;
                    return true;
                }else{
                	array_push($this->result,mysql_error()); 
                    return false; 
                }  
            }else{
            	array_push($this->result,mysql_error());
                return false; 
            }  
        }else{  
            return true;
        }  	
	}		
	public function get($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){
		$selectQuery = 'SELECT '.$rows.' FROM '.$table;
		if($join != null){
			$selectQuery .= ' JOIN '.$join;
		}
        if($where != null){
        	$selectQuery .= ' WHERE '.$where;
		}
        if($order != null){
            $selectQuery .= ' ORDER BY '.$order;
		}
        if($limit != null){
            $selectQuery .= ' LIMIT '.$limit;
        }
        $this->myQuery = $selectQuery;
		if($this->checkTable($table)){
        	$query = @mysql_query($selectQuery);
			if($query){
				$this->numResults = mysql_num_rows($query);
				for($row = 0; $row < $this->numResults; $row++){
					$result = mysql_fetch_array($query);
                	$keys = array_keys($result);
                	for($key = 0; $key < count($keys); $key++){
                		if(!is_int($keys[$key])){
                    		if(mysql_num_rows($query) >= 1){
                    			$this->result[$row][$keys[$key]] = $result[$keys[$key]];
							}else{
								$this->result = null;
							}
						}
					}
				}
				return true;
			}else{
				array_push($this->result,mysql_error());
				return false;
			}
      	}else{
      		return false;
    	}
    }	
	public function insert($table,$params=array()){
    	if($this->checkTable($table)){
    	 	$sqlQuery='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
            $this->myQuery = $sqlQuery;
            if($ins = @mysql_query($sqlQuery)){
            	array_push($this->result,mysql_insert_id());
                return true;
            }else{
            	array_push($this->result,mysql_error());
                return false;
            }
        } else {
        	return false;
        }
    }	
	public function update($table,$params=array(),$where){
    	if($this->checkTable($table)){
    		$args=array();
			foreach($params as $field=>$value){
				$args[]=$field.'="'.$value.'"';
			}
			$sqlQuery='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
			$this->myQuery = $sqlQuery;
            if($query = @mysql_query($sqlQuery)){
            	array_push($this->result,mysql_affected_rows());
            	return true;
            }else{
            	array_push($this->result,mysql_error());
                return false;
            }
        }else{
            return false;
        }
    }
	public function delete($table,$where = null){
    	if($this->checkTable($table)){
    	 	if($where == null){
                $deleteQuery = 'DROP TABLE '.$table;
            }else{
                $deleteQuery = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            if($del = @mysql_query($deleteQuery)){
            	array_push($this->result,mysql_affected_rows());
                $this->myQuery = $deleteQuery; 
                return true;
            }else{
            	array_push($this->result,mysql_error());
               	return false; 
            }
        }else{
            return false;
        }
    }
	private function checkTable($table){
		$tableExist = @mysql_query('SHOW TABLES FROM '.$this->databaseName.' LIKE "'.$table.'"');
        if($tableExist){
        	if(mysql_num_rows($tableExist)==1){
                return true;
            }else{
            	array_push($this->result,$table." does not exist in this database");
                return false;
            }
        }
    }
    public function getResult(){
        $value = $this->result;
        $this->result = array();
        return $value;
    }    
    public function escapeString($data){
        return mysql_real_escape_string($data);
    }
	public function check_empty($data, $fields) {
		$msg = null;
		foreach ($fields as $value) {
			if (empty($data[$value])) {
				$msg .= "$value field empty <br />";
			}
		} 
		return $msg;
	}
} 
