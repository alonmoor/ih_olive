<?php
 class category {
 
 	public $catid;
	public  $catname;
	public  $parentcatid;
	 
	
	function __construct($catid, $catname="",$parentcatid="") {
		$this->setId($catid);
		$this->setName($catname);
		$this->setParent($parentcatid);
		
	}
    
	function load_from_db() {
		global $mysqli;
		
		$sql = "SELECT * FROM categories where catID = ".$this->getId();
		//echo $sql;
		if( $result = $mysqli->query($sql))
			if( $row = $result->fetch_object() ) {
				$this->setUname($row->catName);
			}
				
	}
	
    
	 
	function setId($catid) {
		$this->id = $catid;
	}
	
	
 function setName($catname) {
		$this->catname = $catname;
	}
	
 function setParent($parentcatid) {
		$this->parentcatid = $parentcatid;
	}

//======================================================================================		
	
	function getId() {
		return $this->catid;
	}
	
	function getName() {
		return $this->catName;
	}
    
	function getParent() {
		return $this->parentcatid;
	}
	function update() {
		
		$sql = "UPDATE categories SET
				catName='".$this->getName() . "'
				,ParentCatID='".$this->getParent()."'
				WHERE catID = ". $this->getId();
		//echo $sql;
		 return execute_query($sql);
				
	}
	
	
		//echo $sql;
	
	function insert_category()
	{
	global $mysqli;
		
		$sql ="INSERT INTO categories SET
				  catID=".$this->getId().", 
		          catName='".$this->getName()."',
		          ParentCatID='".$this->getParent()."'";
		          //var_dump($this);	 
                  echo $sql ; 
                  
		          $result= $mysqli->query($sql);
	              if ($result->num_rows >= 0) {
                      return $result;
                }

	 }    
 
 
    function delete_user(){
           global $mysqli;	
           $query="delete from  categories where catID=".$this->getId(); 
           //   echo $query; //die;
           $result=$mysqli->query($query);
     
           if ($result->num_rows > 0) {
               return $result;
              } else {
                 echo "  could not delete"; 	
              }
     }      
       
   
     function search()
     {
     	global $mysqli;    

      $query = "SELECT *  FROM categories WHERE
                catName='".$this->getName()."'" ; 
                echo $query; 
       
               $result = $mysqli->query($query);
            return $result;
      }     
     
	
	 function check(&$err_msg) {
		return 1;
		$err_msg = "";
		if( strlen($this->catName) < 1)
			$err_msg = "String too short";
			
				
		return $err_msg=="";
	}
	 
	
 }   
       
       
          
     
?>