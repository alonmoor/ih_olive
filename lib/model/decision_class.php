 
<?php
/*#####################################################################
 *  decision Class.
 * 
 * 7/8/2008
 #####################################################################*/
//(decID, decName, subdecision, status, userID, forum_decID, comment, a_datetime)

class decision {
	protected $decid;
	protected $decname;
	protected $sub;
	protected $userID;
	protected $forumID;
	protected $decDate;
	protected $active;
	
	function __construct($decid="", $decname="") {
		$this->setId($decid);
		$this->setName($decname);
		//$this->setSub($sub);
 		  
	}
  public function setId($decid) {
		    $this->decid = $decid;
    }
	
       function setName($decname) {
		 $this->decname = $decname;
	}     
     
        function setSub($sub) {
		   $this->sub = $sub;
	}
	
//======================================================================================	
	function getId() {
		return $this->decid;
	    }
	
	
	
	function getName() {
		return $this->decname;
	}
   
	function getSub() {
		return $this->sub;
	}
	
	
 	

	  
	function load_from_db() {
		global $db;
	
		$sql = "SELECT * FROM decisions  where decID = ".$this->getId();
	 
		if( $result = $db->execute_query($sql))
			if( $row = $result->fetch_object() ) {
				    $this->setId($row->decID);
			        $this->setName($row->decName); 
			}
				
	}
		 
	
	
	
	
	function insert_decision()
	{
	global $db;          
		         
		$sql = "insert into decisions SET
				 decName='".$this->getName() . "'";
		          $result= $db->execute($sql);
	              if ($result->num_rows >= 0) {
                      return $result;
                }

	 }    
 
 
    function delete(){
           	
           global $db;	
           $query = "set foreign_key_checks=0";
           if( $db->execute($query) )           	
              if( $db->execute("delete from  decisions where decID=".$this->getId())) 
              	  $db->execute("set foreign_key_checks=1"); 
              	 else
              	  $db->execute("set foreign_key_checks=1");
     }      
       
   
     
 function search()
     {
     	global $db;    

      $query = "SELECT *  FROM decisions WHERE
                decName='".$this->getName()."'" ; 
               $result = $db->execute_query($query);// ->query($query);
            return $result;
          
      }     
     
	
      
function update() {
		global $db;
		$sql = "UPDATE decisions SET
				 decName='".$this->getName() . "'
 				WHERE decID = ". $this->getId();
  
		if($sql) {
			 
		return $db->execute($sql);
		}
	else{	 
 		
	}
      
}     
      
	 function check(&$err_msg) {
		return 1;
		$err_msg = "";
		if( strlen($this->decName) < 1)
			$err_msg = "String too short";
			
				
		return $err_msg=="";
	}
	 
	 

	
}


?>
