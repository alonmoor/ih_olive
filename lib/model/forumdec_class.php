 
<?php
/*#####################################################################
 *  decision Class.
 * 
 * 7/8/2008
 #####################################################################*/
//(decID, decName, subdecision, status, userID, forum_decID, comment, a_datetime)
require_once 'DBobject3.php';
require_once '../../config/application.php';
class Forum_dec extends DBObject3
{
     	public $id;
		public $searchCols;
		protected $forum_decID;
		protected $idName;
		protected $tableName;
		protected $columns = array();
        protected $forum_decName;
        protected $managerName; 
        protected $appointName;
        protected $forum_date;
        protected $voteID	; 	
        protected $level;
	
	function __construct($id = "")
	{
		parent::__construct('forums_dec', 'forum_decID', array('forum_decName', 'managerID', 'appointID', 'forum_date', 'authent', 'voteID'), $id);
	}
	
 
	
	function load_from_db() {
		global $db;
		
		//$sql = "SELECT * FROM users where userID = ".$this->getId();
		$sql = "SELECT * FROM forums_dec where forum_decID =$this->id";
	 
		if( $result = $db->execute_query($sql))
			if( $row = $result->fetch_object() ) {
 				$this->forum_decID=$row->forum_decID;
				$this->forum_decName=$row->forum_decName;
				$this->managerName=$row->managerName;
				$this->appointName=$row->appointName;
				$this->forum_date=$row->forum_date;
				 
			}
				
	}
	
	
        
         function getNewsTypes() {
         global $db;       
        $sql = "select forum_decID,forum_decName from forums_dec";
        
       $rows=$db->queryObjectArray($sql);
        // build return array
        $i = 0;
       // while ($rows=$db->queryObjectArray($sql)) {
         foreach($rows as $row){
            
            $return[$i]["forum_decID"] = $row->forum_decID;
            $return[$i]["forum_decName"] = $row->forum_decName;
            ++$i;
        }
        return $return;
    }      

/*******************************************************************************************************/
    
   function save_usr_frm($formdata) {
       global $db;
       $sql="select userID from users ". 
       "WHERE full_name= " ;
         $sql.=$db->sql_string($formdata['full_name']) ;
       $rows=$db->queryObjectArray($sql);

       $userIDs= $rows[0]->userID;
		  
		return $userIDs;
	}

/*******************************************************************************************************/
	function conn_usr_frm($forum_decID,$usrIDs,$level_manag)
	{
		global $db;
		// connect forum and decision


		$sql = "INSERT INTO rel_users_forums (userID,forum_decID,level_manag) " .
         "VALUES ($usrIDs,$forum_decID, " . $db->sql_string($level_manag) . ")";
		
		
		

		if(!$db->execute($sql)){
		echo "";	
		return FALSE;
		}
			
		return true;
	}
/**********************************************************************************************/

	function set ($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		$this->setsubcategories($subcategories);
		$this->setupdateID($updateID);
			
	}
	
/**********************************************************************************************/
	    
	function setFormdata(&$formdata){
		 $formdata['forum_decID']=$_POST['id'];	
		 $formdata['forum_decName']=$_POST['forumname'];
		 $formdata['managerName']=$_POST['managerName']; 
		 $formdata['appointName']=$_POST['appointName']; 
		 $formdata['forum_date']=$_POST['forum_date']; 
		 //$formdata['level']=$_POST['level']; 
	     //$formdata['insertID']=$_POST['username'];;
//		$this->year_date=$formdata['year_date'];
//		$this->month_date=$formdata['month_date'];
//		$this->day_date=$formdata['day_date'];

//		$this->catID=$formdata['category'];
//		$this->forum_decID=$formdata['forum_decision'];
//	    $this->newforumName=$formdata['newforum'];
	}
	
	
	
		
	
	
/*******************************************************************************************************/	
	function conn_forum_dec($decID,$forumIDs)
	{
		global $db;
		// connect forum and decision
		foreach($forumIDs as $forum_decID) {

			$sql = "INSERT INTO rel_forum_dec (decID,forum_decID) " .
      "VALUES ($decID, $forum_decID)";

			//echo $sql; die;
			if(!$db->execute($sql))
			return FALSE;

		}
		return true;
	}
/**********************************************************************/
	function conn_forum_dec1($decID,$forumIDs)
	{
		global $db;
		// connect forum and decision


		$sql = "INSERT INTO rel_forum_dec (decID,forum_decID) " .
      "VALUES ($decID, $forumIDs)";

		//echo $sql; die;
		if(!$db->execute($sql))
		return FALSE;

			
		return true;
	}

/*******************************************************************************************/

	// read all data for a certain decision from database
	// and save it in an array; return this array
	function read_forum_data($forum_decID) {

		global $db;
		$sql = "SELECT forum_decID, forum_decName,forum_date,managerID,appointID " .
         "FROM forums_dec WHERE forum_decID=$forum_decID";
		$rows = $db->queryObjectArray($sql);
		list($year_date,$month_date, $day_date) = explode('-',$rows[0]->forum_date);
           $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;
           $month_date= is_null($day_date) ? 'NULL' : "'$month_date'" ;
     
		   $day_date=substr($day_date, 0,4);
		   $day_date=substr($day_date,1,2);
	       if($month_date['1'] == '1' )
		   $month_date=substr($month_date,1,2);
		   else{
		    $month_date=substr($month_date,1,2);
		   	$month_date=substr($month_date,1,1);
		   }
		if(is_array($rows) && sizeof($rows)==1) {
			$row = $rows[0];
			$result["forum_decID"]   = $row->forum_decID;
			$result["forum_decName"]     = $row->forum_decName;
			//$result["managerID"]  = $row->managerID;
			$result["forum_date"]  =substr(($row->forum_date) ,0,10);
			$result["forum_date"]  = ($row->forum_date) ;
            $result['day_date']=$day_date;
			$result['month_date']=$month_date;
			$result['year_date']=$year_date;
			$result["usr_frm"]   = "";
			$result["managerID"]   = "";
			$result["managerName"]   = "";
			$result["type_manager"]="";

			//if ($result["decision_forum"])

			$sql = "SELECT u.full_name,u.userID FROM users u, rel_users_forums r  
             WHERE u.userID = r.userID    
             AND r.forum_decID = $forum_decID 
			 ORDER BY u.full_name";
			$rows = $db->queryObjectArray($sql);
			if($rows){
			foreach($rows as $row){
				if(!$result["usr_frm"])
				$result["usr_frm"] = $row->full_name;
				else
				$result["usr_frm"] .= ";" . $row->full_name;

			}
	    }
			//        $sql = "SELECT userID FROM users  " .
			//           "WHERE full_name= " ;
			//        $sql.=$db->sql_string($result['usr_frm']);
			//
			//    $rows = $db->queryObjectArray($sql);
			//    foreach ($rows as $row){
			//     $result[forum_decision]=$row->forum_decID;
			//    }

	     
//	    	$sql = "SELECT f.forum_decName,f.forum_decID,f.managerID ,u.userID,u.full_name, r.level_manag FROM forums_dec f         
//                   left join rel_users_forums r on f.forum_decID=r.forum_decID
//                   left join users u on u.userID=r.userID   
//                   WHERE f.managerID = r.managerID  
//                   AND r.forum_decID = $forum_decID
//                   ORDER BY f.forum_decName";
             $sql="select distinct managerID from rel_users_forums  where  forum_decID=$forum_decID";
	         $row=$db->queryObjectArray($sql);
	         if(!row)
	         echo "no manager yet";
	         $id=$row[0]->managerID;
	         $sql = "select full_name from users   
                     where  userID=$id";
                    //(select distinct managerID from rel_users_forums  where  forum_decID=$forum_decID)";  
	         
	    
	    	
			$rows = $db->queryObjectArray($sql);
			if($rows){	
			foreach($rows as $row){
				if((!$result["managerName"])){
				 
				$result["managerName"] = $row->full_name;
				  
				
				}	
			}
	    }
	           
	    
	     $sql="select distinct appointID from rel_users_forums  where  forum_decID=$forum_decID";
	         $row=$db->queryObjectArray($sql);
	         if(!row)
	         echo "no appoint yet";
	         $id=$row[0]->managerID;
	            $sql = "select full_name from users   
                     where  userID=$id";
                    //(select distinct appointID from rel_users_forums  where  forum_decID=$forum_decID)";  
				$rows = $db->queryObjectArray($sql);
			if($rows){	
			foreach($rows as $row){
				if( !$result["type_manager"] ){
				 
				$result["type_manager"] = $row->full_name;
				}else{
				$result["type_manager"] .= ";" . $row->full_name;
				}	
			}
	    }
	    
	    
			return $result;
		}
	}
/*******************************************************************************************/
/*******************************************************************************************/
function read_user_data($userID) {

		global $db;
		$sql = "SELECT userID, userName, managerID,  " .
         "status, dec_time ,vote_level ,dec_level " .
         "FROM   decisions WHERE decID=$decID";
		$rows = $db->queryObjectArray($sql);
		list($year_date,$month_date, $day_date) = explode('-',$rows[0]->dec_time);
           $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;
           $month_date= is_null($day_date) ? 'NULL' : "'$month_date'" ;
     
		   $day_date=substr($day_date, 0,4);
		   $day_date=substr($day_date,1,2);
	       if($month_date['1'] == '1' )
		   $month_date=substr($month_date,1,2);
		   else{
		    $month_date=substr($month_date,1,2);
		   	$month_date=substr($month_date,1,1);
		   }
		if(is_array($rows) && sizeof($rows)==1) {
			$row = $rows[0];
			$result["decID"]   = $row->decID;
			$result["subcategories"]     = $row->decName;
			$result["parentDecID"]  = $row->parentDecID;
			$result["parentDecID1"]  = $row->parentDecID1;
			$result["dec_status"] = $row->status;
            $result["dec_time"]  =substr(($row->dec_time) ,10,6);
            $result["vote_level"] = $row->vote_level;
            $result["dec_level"] = $row->dec_level;
			$result['day_date']=$day_date;
			$result['month_date']=$month_date;
			$result['year_date']=$year_date;
			$result["forum_decision"]   = "";
			$result["category"]="";

			//if ($result["decision_forum"])

			$sql = "SELECT forum_decName FROM forums_dec, rel_forum_dec " .
           "WHERE forums_dec.forum_decID = rel_forum_dec.forum_decID " .
           "AND rel_forum_dec.decID = $decID " .
           "ORDER BY forum_decName";
			$rows = $db->queryObjectArray($sql);
			foreach($rows as $row){
				if(!$result["forum_decision"])
				$result["forum_decision"] = $row->forum_decName;
				else
				$result["forum_decision"] .= ";" . $row->forum_decName;

			}
			//        $sql = "SELECT forum_decID FROM forums_dec  " .
			//           "WHERE forum_decName= " ;
			//        $sql.=$db->sql_string($result['forum_decision']);
			//
			//    $rows = $db->queryObjectArray($sql);
			//    foreach ($rows as $row){
			//     $result[forum_decision]=$row->forum_decID;
			//    }

			$sql="SELECT c.catID  FROM categories c, rel_cat_dec r
			WHERE c.catID = r.catID
			AND r.decID =$decID ORDER BY c.catName";
			$rows = $db->queryObjectArray($sql);
			foreach($rows as $row){
				if(!$result["category"])
				$result["category"] = $row->catID;
				else
				$result["category"] .= ";" . $row->catID;
			}

			return $result;
		}
	}		
/***************************************************************************/
	function make_calendar_pulldown() {


			form_new_line();
			form_label2("תאריך הוספת משתמש לפורום:");
             
			
	for($i=1;$i<=31;$i++){
		$days[$i]= $i;
		}
            $months = array ('1'=>'January','2'=> 'February','3'=> 'March','4'=> 'April','5'=> 'May','6'=> 'June','7'=> 'July','8'=> 'August','9'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December');
             
            
            $dates = getdate();
             
	$year = date('Y');	   
	 
	$end = $year;
	$start=$year - 15;
	for($start;$start<=$end;$start++) {
		$years[$start]=$start;
		
	}
 	 
	echo '<td>';	
            form_list3("year_date" ,$years,$dates['year'], array_item($formdata, "year_date") );
 
            form_list3("month_date" ,$months,$dates['month'], array_item($formdata, "month_date") );
           
            form_list3("day_date" ,$days, $dates['mday'], array_item($formdata, "day_date") );
    echo '</td>', "\n";
			 
	     	  
			 
			 
			form_end_line();
			
			
}  
/*****************************************************************************/	
	
}



?>
 
<?php
/*#####################################################################
 *  decision Class.
 * 
 * 7/8/2008
 #####################################################################*/
//(decID, decName, subdecision, status, userID, forum_decID, comment, a_datetime)
require_once 'DBobject3.php';
require_once '../../config/application.php';
class Forum_dec extends DBObject3
{
     	public $id;
		public $searchCols;
		protected $forum_decID;
		protected $idName;
		protected $tableName;
		protected $columns = array();
        protected $forum_decName;
        protected $managerName; 
        protected $appointName;
        protected $forum_date;
        protected $voteID	; 	
        protected $level;
	
 
 function __construct($id = "")
	{
		parent::__construct('forum_dec', 'forum_decID', array('forum_decName', 'managerID', 'appointID', 'forum_date', 'authent', 'voteID', 'active', 'level_manag', 'parentForumID'), $id);
	}
 


        
	
 
	
	function load_from_db() {
		global $db;
		
		//$sql = "SELECT * FROM users where userID = ".$this->getId();
		$sql = "SELECT * FROM forums_dec where forum_decID =$this->id";
	 
		if( $result = $db->execute_query($sql))
			if( $row = $result->fetch_object() ) {
 				$this->forum_decID=$row->forum_decID;
				$this->forum_decName=$row->forum_decName;
				$this->managerName=$row->managerName;
				$this->appointName=$row->appointName;
				$this->forum_date=$row->forum_date;
				 
			}
				
	}
	
	
        
         function getNewsTypes() {
         global $db;       
        $sql = "select forum_decID,forum_decName from forums_dec";
        
       $rows=$db->queryObjectArray($sql);
        // build return array
        $i = 0;
       // while ($rows=$db->queryObjectArray($sql)) {
         foreach($rows as $row){
            
            $return[$i]["forum_decID"] = $row->forum_decID;
            $return[$i]["forum_decName"] = $row->forum_decName;
            ++$i;
        }
        return $return;
    }      

/*******************************************************************************************************/
    
   function save_usr_frm($formdata) {
       global $db;
       $sql="select userID from users ". 
       "WHERE full_name= " ;
         $sql.=$db->sql_string($formdata['full_name']) ;
       $rows=$db->queryObjectArray($sql);

       $userIDs= $rows[0]->userID;
		  
		return $userIDs;
	}

/*******************************************************************************************************/
	function conn_usr_frm($forum_decID,$usrIDs,$level_manag)
	{
		global $db;
		// connect forum and decision


		$sql = "INSERT INTO rel_users_forums (userID,forum_decID,level_manag) " .
         "VALUES ($usrIDs,$forum_decID, " . $db->sql_string($level_manag) . ")";
		
		
		

		if(!$db->execute($sql)){
		echo "";	
		return FALSE;
		}
			
		return true;
	}
/**********************************************************************************************/

	function set ($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		$this->setsubcategories($subcategories);
		$this->setupdateID($updateID);
			
	}
	
/**********************************************************************************************/
	    
	function setFormdata(&$formdata){
		 $formdata['forum_decID']=$_POST['id'];	
		 $formdata['forum_decName']=$_POST['forumname'];
		 $formdata['managerName']=$_POST['managerName']; 
		 $formdata['appointName']=$_POST['appointName']; 
		 $formdata['forum_date']=$_POST['forum_date']; 
		 //$formdata['level']=$_POST['level']; 
	     //$formdata['insertID']=$_POST['username'];;
//		$this->year_date=$formdata['year_date'];
//		$this->month_date=$formdata['month_date'];
//		$this->day_date=$formdata['day_date'];

//		$this->catID=$formdata['category'];
//		$this->forum_decID=$formdata['forum_decision'];
//	    $this->newforumName=$formdata['newforum'];
	}
	
	
	
		
	
	
/*******************************************************************************************************/	
	function conn_forum_dec($decID,$forumIDs)
	{
		global $db;
		// connect forum and decision
		foreach($forumIDs as $forum_decID) {

			$sql = "INSERT INTO rel_forum_dec (decID,forum_decID) " .
      "VALUES ($decID, $forum_decID)";

			//echo $sql; die;
			if(!$db->execute($sql))
			return FALSE;

		}
		return true;
	}
/**********************************************************************/
	function conn_forum_dec1($decID,$forumIDs)
	{
		global $db;
		// connect forum and decision


		$sql = "INSERT INTO rel_forum_dec (decID,forum_decID) " .
      "VALUES ($decID, $forumIDs)";

		//echo $sql; die;
		if(!$db->execute($sql))
		return FALSE;

			
		return true;
	}

/*******************************************************************************************/

	// read all data for a certain decision from database
	// and save it in an array; return this array
	function read_forum_data($forum_decID) {

		global $db;
		$sql = "SELECT forum_decID, forum_decName,forum_date,managerID,appointID " .
         "FROM forums_dec WHERE forum_decID=$forum_decID";
		$rows = $db->queryObjectArray($sql);
		list($year_date,$month_date, $day_date) = explode('-',$rows[0]->forum_date);
           $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;
           $month_date= is_null($day_date) ? 'NULL' : "'$month_date'" ;
     
		   $day_date=substr($day_date, 0,4);
		   $day_date=substr($day_date,1,2);
	       if($month_date['1'] == '1' )
		   $month_date=substr($month_date,1,2);
		   else{
		    $month_date=substr($month_date,1,2);
		   	$month_date=substr($month_date,1,1);
		   }
		if(is_array($rows) && sizeof($rows)==1) {
			$row = $rows[0];
			$result["forum_decID"]   = $row->forum_decID;
			$result["forum_decName"]     = $row->forum_decName;
			//$result["managerID"]  = $row->managerID;
			$result["forum_date"]  =substr(($row->forum_date) ,0,10);
			$result["forum_date"]  = ($row->forum_date) ;
            $result['day_date']=$day_date;
			$result['month_date']=$month_date;
			$result['year_date']=$year_date;
			$result["usr_frm"]   = "";
			$result["managerID"]   = "";
			$result["managerName"]   = "";
			$result["type_manager"]="";

			//if ($result["decision_forum"])

			$sql = "SELECT u.full_name,u.userID FROM users u, rel_users_forums r  
             WHERE u.userID = r.userID    
             AND r.forum_decID = $forum_decID 
			 ORDER BY u.full_name";
			$rows = $db->queryObjectArray($sql);
			if($rows){
			foreach($rows as $row){
				if(!$result["usr_frm"])
				$result["usr_frm"] = $row->full_name;
				else
				$result["usr_frm"] .= ";" . $row->full_name;

			}
	    }
			//        $sql = "SELECT userID FROM users  " .
			//           "WHERE full_name= " ;
			//        $sql.=$db->sql_string($result['usr_frm']);
			//
			//    $rows = $db->queryObjectArray($sql);
			//    foreach ($rows as $row){
			//     $result[forum_decision]=$row->forum_decID;
			//    }

	     
//	    	$sql = "SELECT f.forum_decName,f.forum_decID,f.managerID ,u.userID,u.full_name, r.level_manag FROM forums_dec f         
//                   left join rel_users_forums r on f.forum_decID=r.forum_decID
//                   left join users u on u.userID=r.userID   
//                   WHERE f.managerID = r.managerID  
//                   AND r.forum_decID = $forum_decID
//                   ORDER BY f.forum_decName";
             $sql="select distinct managerID from rel_users_forums  where  forum_decID=$forum_decID";
	         $row=$db->queryObjectArray($sql);
	         if(!row)
	         echo "no manager yet";
	         $id=$row[0]->managerID;
	         $sql = "select full_name from users   
                     where  userID=$id";
                    //(select distinct managerID from rel_users_forums  where  forum_decID=$forum_decID)";  
	         
	    
	    	
			$rows = $db->queryObjectArray($sql);
			if($rows){	
			foreach($rows as $row){
				if((!$result["managerName"])){
				 
				$result["managerName"] = $row->full_name;
				  
				
				}	
			}
	    }
	           
	    
	     $sql="select distinct appointID from rel_users_forums  where  forum_decID=$forum_decID";
	         $row=$db->queryObjectArray($sql);
	         if(!row)
	         echo "no appoint yet";
	         $id=$row[0]->managerID;
	            $sql = "select full_name from users   
                     where  userID=$id";
                    //(select distinct appointID from rel_users_forums  where  forum_decID=$forum_decID)";  
				$rows = $db->queryObjectArray($sql);
			if($rows){	
			foreach($rows as $row){
				if( !$result["type_manager"] ){
				 
				$result["type_manager"] = $row->full_name;
				}else{
				$result["type_manager"] .= ";" . $row->full_name;
				}	
			}
	    }
	    
	    
			return $result;
		}
	}
/*******************************************************************************************/
/*******************************************************************************************/
function read_user_data($userID) {

		global $db;
		$sql = "SELECT userID, userName, managerID,  " .
         "status, dec_time ,vote_level ,dec_level " .
         "FROM   decisions WHERE decID=$decID";
		$rows = $db->queryObjectArray($sql);
		list($year_date,$month_date, $day_date) = explode('-',$rows[0]->dec_time);
           $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;
           $month_date= is_null($day_date) ? 'NULL' : "'$month_date'" ;
     
		   $day_date=substr($day_date, 0,4);
		   $day_date=substr($day_date,1,2);
	       if($month_date['1'] == '1' )
		   $month_date=substr($month_date,1,2);
		   else{
		    $month_date=substr($month_date,1,2);
		   	$month_date=substr($month_date,1,1);
		   }
		if(is_array($rows) && sizeof($rows)==1) {
			$row = $rows[0];
			$result["decID"]   = $row->decID;
			$result["subcategories"]     = $row->decName;
			$result["parentDecID"]  = $row->parentDecID;
			$result["parentDecID1"]  = $row->parentDecID1;
			$result["dec_status"] = $row->status;
            $result["dec_time"]  =substr(($row->dec_time) ,10,6);
            $result["vote_level"] = $row->vote_level;
            $result["dec_level"] = $row->dec_level;
			$result['day_date']=$day_date;
			$result['month_date']=$month_date;
			$result['year_date']=$year_date;
			$result["forum_decision"]   = "";
			$result["category"]="";

			//if ($result["decision_forum"])

			$sql = "SELECT forum_decName FROM forums_dec, rel_forum_dec " .
           "WHERE forums_dec.forum_decID = rel_forum_dec.forum_decID " .
           "AND rel_forum_dec.decID = $decID " .
           "ORDER BY forum_decName";
			$rows = $db->queryObjectArray($sql);
			foreach($rows as $row){
				if(!$result["forum_decision"])
				$result["forum_decision"] = $row->forum_decName;
				else
				$result["forum_decision"] .= ";" . $row->forum_decName;

			}
			//        $sql = "SELECT forum_decID FROM forums_dec  " .
			//           "WHERE forum_decName= " ;
			//        $sql.=$db->sql_string($result['forum_decision']);
			//
			//    $rows = $db->queryObjectArray($sql);
			//    foreach ($rows as $row){
			//     $result[forum_decision]=$row->forum_decID;
			//    }

			$sql="SELECT c.catID  FROM categories c, rel_cat_dec r
			WHERE c.catID = r.catID
			AND r.decID =$decID ORDER BY c.catName";
			$rows = $db->queryObjectArray($sql);
			foreach($rows as $row){
				if(!$result["category"])
				$result["category"] = $row->catID;
				else
				$result["category"] .= ";" . $row->catID;
			}

			return $result;
		}
	}		
/***************************************************************************/
	function make_calendar_pulldown() {


			form_new_line();
			form_label2("תאריך הוספת משתמש לפורום:");
             
			
	for($i=1;$i<=31;$i++){
		$days[$i]= $i;
		}
            $months = array ('1'=>'January','2'=> 'February','3'=> 'March','4'=> 'April','5'=> 'May','6'=> 'June','7'=> 'July','8'=> 'August','9'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December');
             
            
            $dates = getdate();
             
	$year = date('Y');	   
	 
	$end = $year;
	$start=$year - 15;
	for($start;$start<=$end;$start++) {
		$years[$start]=$start;
		
	}
 	 
	echo '<td>';	
            form_list3("year_date" ,$years,$dates['year'], array_item($formdata, "year_date") );
 
            form_list3("month_date" ,$months,$dates['month'], array_item($formdata, "month_date") );
           
            form_list3("day_date" ,$days, $dates['mday'], array_item($formdata, "day_date") );
    echo '</td>', "\n";
			 
	     	  
			 
			 
			form_end_line();
			
			
}  
/*****************************************************************************/	
	
}



?>
