<?php

// File Location: /_lib/_classes/class.polls.php

 
 

class polls { // open the class definition
    
    /** 
     * unique identifier for a poll
     *
     * @var integer
     * @access private
     * @see setPollId()
     */
    var $_iPollId;
    
    /** 
     * unique identifier for a poll answer
     *
     * @var integer
     * @access private
     * @see setAnswerId()
     */
    var $_iAnswerId;
    
    /** 
     * PEAR db object
     *
     * @var object
     * @access private
     */
    var $_oConn;
    
    // CONSTRUCTOR ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /** 
     * class constructor
     *
     * @param integer $iPollId [optional] poll id
     * @access public
     */
    function polls($iPollId = '') {
  
  
// set unique identifier
        if (is_int($iPollId)) {
              
  
            $this->setPollId($iPollId);
        }
        
           
    }
    
    // PUBLIC METHODS :::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /**
     * set the _iPollId variable for the class
     *
     * @param integer $iPollId unique poll identifier
     * @access public
     */
    function setPollId($iPollId) {
        
        if (is_int($iPollId)) {
            
            $this->_iPollId = $iPollId;
        }
    }
    
    /**
     * set the _iAnswerId variable for the class
     *
     * @param integer $iAnswerId unique answer identifier
     * @access public
     */
    function setAnswerId($iAnswerId) {
        
        if (is_int($iAnswerId)) {
            
            $this->_iAnswerId = $iAnswerId;
        }
    }
    
    // SELECT METHODS :::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /** 
     * get polls count for paging
     *
     * @param boolean $iStatus status of poll
     * @return boolean
     * @access private
     */
    function getPollsCount($iStatus=false) {
        global $db;
        $sFilter=(isset($sFilter))?$sFilter:'';
        
        // set sql filter
        $iStatus ? $sFilter .= " AND status=1" : $sFilter .= "";
        
        $sql = "SELECT 
                    count(poll_id) AS poll_cnt 
                FROM 
                    ".PREFIX."_polls 
                WHERE deleted=0".$sFilter;
        
           if($rows=$db->queryObjectArray($sql))
           $iCnt=$rows[0]->poll_cnt;
        
        return $iCnt;
    }
    
    /** 
     * get polls list
     *
     * @param string $sSort sort key
     * @param integer $iPage [optional] cursor
     * @return array poll data
     * @access public
     */
    function getPolls($sSort, $iPage=0) {
        global $db;
//        $sql = "SELECT 
//                    poll_id, 
//                    poll_vote_cnt, 
//                    poll_question, 
//                    status, 
//                    created_dt, 
//                    modified_dt 
//                FROM 
//                    ".PREFIX."_polls 
//                WHERE 
//                    deleted=0 
//                ORDER BY 
//                    ".$sSort." 
//                LIMIT ".$iPage.", ".ROWCOUNT;
        
   $sql = "SELECT 
                    poll_id, 
                    poll_vote_cnt, 
                    poll_question, 
                    STATUS, 
                    created_dt, 
                    modified_dt 
                FROM 
                    wrox_polls 
                WHERE 
                    deleted=0 
                ORDER BY 
                    created_dt DESC " ;     
        
        
        
        $return=array();
         if($rows=$db->queryObjectArray($sql)){
        $i = 0;
        
        foreach ($rows as $row){
            
            $return[$i]["Poll Id"] = $row->poll_id;
            $return[$i]["Vote Count"] = $row->poll_vote_cnt;
            $return[$i]["Question"] =$row->poll_question;
                                     
            $return[$i]["Status"] = $row->STATUS;
            $return[$i]["Created Date"] = strtotime($row->created_dt);
            $return[$i]["Modified Date"] = strtotime($row->modified_dt);
            ++$i;
        }
        
       
       
        return $return;
         }   
        
    }
    /** 
     * get active polls list
     *
     * @param integer $iPage [optional] cursor
     * @return array active poll data
     * @access public
     */
    function getActivePolls($iPage=0) {
        global $db;
        $sql = "SELECT 
                    poll_id, 
                    poll_vote_cnt, 
                    poll_question 
                FROM 
                    ".PREFIX."_polls 
                WHERE 
                    status=1 
                    AND deleted=0 
                ORDER BY 
                    created_dt desc 
                LIMIT ".$iPage.", 1";
        
        if($rows=$db->queryObjectArray($sql)){
        $i = 0;
        foreach ($rows as $row){
            
            $return["Poll Id"] = $row->poll_id;
            $return["Vote Count"] = $row->poll_vote_cnt;
            $return["Question"] = $row->poll_question;
            $return["Answers"] = $this->getPollAnswers($row->poll_id);
            return $return;     
        }   
      }
    } 
    /** 
     * get a single poll
     *
     * @return array
     * @access public
     */
    function getPoll() {
        global $db;
        $sql = "SELECT 
                    poll_id, 
                    poll_vote_cnt, 
                    poll_question, 
                    status, 
                    created_dt, 
                    modified_dt 
                FROM 
                    ".PREFIX."_polls 
                WHERE 
                    poll_id=".$this->_iPollId;
        
         if($rows=$db->queryObjectArray($sql)){
        $i = 0;
        foreach ($rows as $row){
        // build return array
        $return["Poll Id"] = $row->poll_id;
        $return["Vote Count"] = $row->poll_vote_cnt;
        $return["Question"] = $row->poll_question;
        $return["Answers"] = $this->getPollAnswers($row->poll_id);
        $return["Status"] = $row->status;
        $return["Created Date"] = strtotime($row->created_dt);
        $return["Modified Date"] = strtotime($row->modified_dt);
        return $return;
    }
   }
 }   
    /** 
     * get poll answers or options
     *
     * @param integer $iPollId poll id
     * @return array
     * @access public
     */
     function getPollAnswers($iPollId) {
        global $db;
        $sql = "SELECT 
                    poll_answer_id, 
                    poll_answer, 
                    poll_answer_cnt 
                FROM 
                    ".PREFIX."_polls_answers 
                WHERE 
                    poll_id=".$iPollId;
        if($rows=$db->queryObjectArray($sql)){
        $i = 0;
        foreach ($rows as $row){
            
            $return[$i]["Answer Id"] = $row->poll_answer_id;
            $return[$i]["Answer"] = $row->poll_answer;
            $return[$i]["Answer Count"] = $row->poll_answer_cnt;
            ++$i;
        }
        return $return;
     }
  }    
    // INSERT METHODS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /** 
     * add a poll record
     *
     * @param array $aArgs poll data
     * @return boolean
     * @access public
     */
    function addPoll_HP($aArgs="") {
        global $db;
      
        // lock tables to capture unique identifier
        $sql = "LOCK TABLES ".PREFIX."_polls WRITE";
        
        if (!($db->execute($sql))){
            return false;
        }
        
        
        // add new record
        $sql = "INSERT INTO ".PREFIX."_polls (
                    poll_question, 
                    status, 
                    created_dt, 
                    modified_dt
                ) values (
                    '".$aArgs["Question"]."', 
                    1,
                    (NOW()), 
                    (NOW())
                )";
        
        if (!($db->execute($sql))){
            return false;
        }
        
        // get last unique identifier from entry
        $sql = "SELECT MAX(poll_id) FROM ".PREFIX."_polls";
        $iPollId=$db->querySingleItem($sql);
         
        $sql = "UNLOCK TABLES";
        
     if (!($db->execute($sql))){
            return false;
        }
        
        // set unique identifier member variable
        settype($iPollId, "integer");
        $this->setPollId($iPollId);
        
        // loop through answers and add records
        $i = 0;
        while (list($key, $val) = each($aArgs["Answers"])) {
            
            if (strcmp("", $val)) {
                
                // add records
                $sql = "INSERT INTO ".PREFIX."_polls_answers (
                            poll_id, 
                            poll_answer
                        ) values (
                            ".$this->_iPollId.", 
                            '".$aArgs["Answers"][$i]."'
                        )";
                        
            if (!($db->execute($sql))){
            return false;
            }
        
           }
            ++$i;
        }
        
        return true;
    }
    
    // UPDATE METHODS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /** 
     * edit a poll record
     *
     * @param array $aArgs poll data
     * @return boolean
     * @access public
     */
    function editPoll($aArgs) {
        global $db; 
    	
        $sql = "UPDATE ".PREFIX."_polls SET 
                    poll_question='".$aArgs["Question"]."', 
                    modified_dt=(NOW())                
                WHERE 
                    poll_id=".$this->_iPollId;
        
      if (!($db->execute($sql))){
            return false;
        }
        
        // loop through answers and update records
        $i = 0;
        while (list($key, $val) = each($aArgs["Answers"])) {
            
            if (strcmp("", $val)) {
                
                $sql = "UPDATE ".PREFIX."_polls_answers SET 
                            poll_answer='".$val."' 
                        WHERE 
                            poll_answer_id=".$key;
                        
              if (!($db->execute($sql))){
              return false;
             }
            }
        }
        return true;
    }
   
/******************************************************************************************************/
 function delPoll($aArgs) {
        
 	  global $db; 
        $sql = "DELETE FROM ".PREFIX."_polls   
                WHERE 
                    poll_id=".$this->_iPollId;
        
            if (!($db->execute($sql))){
            return false;
        }
        
// foreach($aArgs["Answers"] as $row){
//    $x+=1;
//    }  
            // loop through answers and update records
        $i = 0;
       if($aArgs["Answers"]){ 
        while (list($key, $val) = each($aArgs["Answers"])) {
            
            if (strcmp("",(string) $val)) {
                
                $sql = "DELETE FROM  ".PREFIX."_polls_answers  
                        WHERE 
                            poll_answer_id=".$key;
                        
              if (!($db->execute($sql))){
            return false;
                }
            }
        }
      } 
        return true;
    }
    
/*******************************************************************************************************/    

    /** 
     * add a poll vote
     *
     * @return boolean
     * @access public
     */
    function addVote() {
      global $db;  
        // increment poll count
        $sql = "UPDATE ".PREFIX."_polls SET 
                    poll_vote_cnt=poll_vote_cnt+1 
                WHERE 
                    poll_id=".$this->_iPollId;
        
     if (!($db->execute($sql))){
            return false;
        }
        
        // increment poll answer count
        $sql = "UPDATE ".PREFIX."_polls_answers SET 
                    poll_answer_cnt=poll_answer_cnt+1 
                WHERE 
                    poll_answer_id=".$this->_iAnswerId;
        
     if (!($db->execute($sql))){
            return false;
        }
        
        // set poll vote cookie
    setcookie("cPOLL", $this->_iPollId, time()+3600*24*56, "/", "", "");
    }
    
    /** 
     * delete a poll record
     *
     * @return boolean
     * @access public
     */
    function deletePoll() {
      global $db;  
        $sql = "UPDATE ".PREFIX."_polls SET 
                    deleted=1, 
                    deleted_dt=(NOW()) 
                WHERE 
                    poll_id=".$this->_iPollId;
        
     if (!($db->execute($sql))){
            return false;
        }
        
        $this->deactivatePoll();
        return true;
    }
    
    /** 
     * activate a poll record
     *
     * @return boolean
     * @access public
     */
    function activatePoll() {
        global $db;
        $sql = "UPDATE ".PREFIX."_polls SET 
                    status=1 
                WHERE 
                    poll_id=".$this->_iPollId;
        
     if (!($db->execute($sql))){
            return false;
        }
    }
    
    /** 
     * deactivate a poll record
     *
     * @return boolean
     * @access public
     */
    function deactivatePoll() {
        global $db;
        $sql = "UPDATE ".PREFIX."_polls SET 
                    status=0 
                WHERE 
                    poll_id=".$this->_iPollId;
        
     if (!($db->execute($sql))){
            return false;
        }
    }
    
} // close the class definition

?>