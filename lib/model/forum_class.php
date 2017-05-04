<?php
require_once ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
require_once(LIB_DIR.'/model/class.handler.php');
require_once (LIB_DIR.'/model/dbtreeview.php');
require_once HTML_DIR.'/edit_forumdec.php'; 
require_once (ADMIN_DIR.'/ajax2.php');
 
 
class Forum_dec extends DBObject3{
	
	private $table;
	private $fields = array();

	protected $forum_decID; 
	protected $forum_decName;
	protected $newforum;
	protected $catID;
	protected $managerID;
	protected $appointID;
	protected $active;
	protected $editID;
	protected $parentForumID;
	protected $parentCatID;
	protected $forum_date;
	protected $appoint_date;
	protected $manager_date;
	protected $year_date=array();
	protected $month_date=array();
	protected $day_date=array();
	protected $multi_year=array();
	protected $multi_month=array();
	protected $multi_day=array();

	public  $insertID ; 
	public  $deleteID ;
	public  $updateID ;
	public  $submitbutton;
	public  $subcategories;
	public $pagesize = 10;
	public $subcats;
	 

	function __construct($id = "",$formdata="")
	{
		 parent::__construct('forum_dec', 'forum_decID', array('forum_decName', 'managerID', 'appointID', 'forum_date', 'active', 'parentForumID', 'manager_date', 'appoint_date', 'managerTypeID'),$id,$formdata);
	}


	

	function load_from_db($formdata) {
		global $db;
		
		//$sql = "SELECT * FROM users where userID = ".$this->getId();
		$sql = "SELECT * FROM forum_dec where forum_decID =$this->id";
	 
		if( $result = $db->execute_query($sql))
			if( $row = $result->fetch_object() ) {
		        if(!empty($row->forum_decID))
 				$this->forum_decID=$row->forum_decID;

                if(!empty($formdata['managerName']))
				$this->forum_decName=$row->forum_decName;

                if(!empty($formdata['managerName']))
				$this->managerName=$formdata['managerName'];

                if(!empty($formdata['appointName']))
				$this->appointName=$formdata['appointName'];

                if(!empty($formdata['managerID']))
				$this->managerID=$formdata['managerID'];

                if(!empty($formdata['appointID']))
				$this->appointID=$formdata['appointID'];

                if(!empty($row->forum_date))
				$this->forum_date=$row->forum_date;

                if(!empty($row->active))
				$this->active=$row->active;

                if(!empty($row->parentForumID))
				$this->parentForumID=$row->parentForumID;
			}
				
	}
	
/************************************s**************************************************************/
function setFormdata(&$formdata){
    global $db;
    if(!empty($_REQUEST['id']))
        $formdata['forum_decID']=$_REQUEST['id'];

    if(!empty($_POST['forum_decName']))
        $formdata['forum_decName']=$_POST['forum_decName'];

    if(!empty($_POST['form']['appointID']))
        $formdata['appointID']=$_POST['form']['appointID'] ;

    if(!empty($_POST['form']['appoint_date']))
        $formdata['appoint_date']=$_POST['form']['appoint_date'] ;

    if(!empty($_POST['form']['managerID']))
        $formdata['managerID']=$_POST['form']['managerID'] ;

    if(!empty($_POST['form']['manager_date']))
        $formdata['manager_date']=$_POST['form']['manager_date'] ;

    if(!empty($_POST['parentForumID']))
        $formdata['parentForumID']=$_POST['parentForumID'];

    if(!empty($_POST['active']))
        $formdata['active']=$_POST['active']  ;

    if(!empty($_POST['category']))
        $formdata['category']=$_POST['category']  ;

    if(!empty($_POST['type']))
        $formdata['type']=$_POST['type']  ;

    if(!empty($_POST['forum_date']))
        $formdata['forum_date']=$_POST['forum_date'];

    if(!empty($_POST['form']['year_date_forum']))
        $formdata['year_date_forum']=$_POST['form']['year_date_forum'];

    if(!empty($_POST['form']['month_date_forum']))
        $formdata['month_date_forum']=$_POST['form']['month_date_forum'];

    if(!empty($_POST['form']['day_date_forum']))
        $formdata['day_date_forum']=$_POST['form']['day_date_forum'];

    if(!empty($formdata['forum_decID']))
        $id=$formdata['forum_decID'];

    if(isset($id)){
        $sql="select parentForumID from forum_dec where forum_decID=$id";
        if($rows=$db->queryObjectArray($sql))
            $formdata['parentForumID']=$rows[0]->parentForumID;
    }

}


/****************************************************************************************/	
function setParent_forum(&$formdata){
 global $db;
	if($formdata['id']){
	$id=$formdata['id'];	 
 	$sql="select parentForumID from forum_dec where forum_decID=$id";
		 if($rows=$db->queryObjectArray($sql) && $rows[0]->parentForumID!=null)
		 $formdata['parentForumID']=$rows[0]->parentForumID;
		 else
		 $formdata['parentForumID']='11';
 }
}		
/*******************************************************************************************************/			
	
	function set ($insertID="",$submitbutton="",$subcategories="",$deleteID="",$updateID="") {
		$this->setdeleteID($deleteID);
		$this->setinsertID($insertID);
		$this->setsubmitbutton($submitbutton);
		$this->setsubcategories($subcategories);
		$this->setupdateID($updateID);
			
	}





	/**********************************************************************************************/
//	 
//	function setFormdata($formdata){
//		$this->active=$formdata['active'];
//		
//		
//		if($formdata['newforum']){
//		$this->forum_decName=$formdata['newforum'];
//		$subcategories=$formdata['newforum'];
//		}elseif($formdata['forum_decName']){
//		$forum_decID=$formdata["forum_decision"];
//			$sql = "SELECT forum_decName  FROM forum_dec WHERE forum_decID = " .
//				$db->sql_string($$forum_decID);
//				$rows = $db->queryObjectArray($sql);
//			if($rows)
//			// existing forum
//			$this->forum_decName=$rows[0]->forum_decName;
//			$subcategories=$rows[0]->forum_decName;
//		}
//		
//		
//		
//		
//		$this->forum_decID=$formdata['forum_decID'];
//		$this->managerID=$formdata['managerID'];
//		$this->appointID=$formdata['appointID'];
//		$this->parentForumID=$formdata['insertID'];
//		$this->year_date=$formdata['year_date'];
//		$this->month_date=$formdata['month_date'];
//		$this->day_date=$formdata['day_date'];
//		if(is_numeric ($formdata['multi_year'])&& is_numeric ($formdata['multi_month'])&& is_numeric ($formdata['multi_day'])){
//			$this->year_date=$formdata['multi_year'];
//			$this->month_date=$formdata['multi_month'];
//			$this->day_date=$formdata['multi_day'];
//		}
//		$this->catID=$formdata['category'];
//		//$this->forum_decID=$formdata['forum_decID'];
//		//$this->newforumName=$formdata['newforum'];
//	}
/************************************************************************************************/
	function array_item($ar, $key) {

		if(is_array($ar) && array_key_exists($key, $ar))
		return($ar[$key]);
		else
		return FALSE;
	}

	/**********************************************************************************************/
	public function setId($forum_decID) {
		$this->forum_decID = $forum_decID;
	}

	function setName($decname) {
		$this->forum_decName = $decname;
	}

	function setSubcats($subcats) {
		$this->subcats = $subcats;
	}
	//======================================================================================
	function getId() {
		return $this->forum_decID;
	}



	function getName() {
		return $this->forum_decName;
	}


	/**********************************************************************************************/
	function setdeleteID($deleteID) {
		$this->deleteID = $deleteID;
	}


	function setinsertID($insertID) {
		$this->insertID = $insertID;
	}

	function setsubmitbutton($submitbutton) {
		$this->submitbutton = $submitbutton;
	}

	function setsubcategories($subcategories) {
		$this->subcategories = $subcategories;
	}
	function setupdateID($updateID) {
		$this->updateID = $updateID;
	}


	function setParent($parentcatid) {
		$this->parentCatID = $parentcatid;
	}
	/*****************************************************************************************/
	function getdeleteID() {
		return $this->deleteID;
	}

	function getinsertID() {
		return $this->insertID;
	}
	function getsubmitbutton() {
		return $this->submitbutton;
	}
	function getsubcategories() {
		return $this->subcategories;
	}

	function getupdateID() {
		return $this->updateID;
	}

	function getParent() {
		return $this->parentCatID;
	}
	/**********************************************************************************/
	function __construct1($forum_decID = false)
	{
		if(!$forum_forum_decID) {
			return;
		}
		global $db;
		$query = "SELECT *
		FROM forum_dec
		WHERE forum_forum_decID =$forum_forum_decID";
		$result =$db->getMysqli()->query($query);
		while ($data = $result->fetch_array(MYSQLI_ASSOC))
		{
			$this->forum_forum_decID = $formdata['forum_forum_decID'];
			$this->forum_decName = $formdata['forum_decName'];
			$this->forum_time = $formdata['forum_time'];

		}
	}


/**********************************************************************************************/
function link_div(){
	
echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
		echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
		$url="../admin/forum_demo12_2.php";
	        $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";
	        
echo "<td><p><b> ",build_href2("../admin/database5.php", "","", "עץ הפורומים","class=my_decLink_root title='כול הפורומים במיבנה עץ'") . " </b></p></td></tr></table>\n";	

?>

<table style="width:50%;">
 <tr>
 <td >     
<?php form_label1('חתכי סוגי החלטות:',TRUE); ?>
     <a href='#' title='חתכי סוגי החלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>  
   </td>  
    
    
     <td>
    <?php form_label1('חתכי סוגי פורומים:',TRUE); ?>
     <a href='#' title='חתכי סוגי פורומים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>
    </td>  
     
     
     <td>
       <?php form_label1('חתכי סוגי מנהלים:',TRUE); ?>  
    
     <a href='#' title='חתכי סוגי מנהלים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJAX/default.php'"; ?> ,'סוגי המנהלים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>                                                               
                                                      
</td></tr></table>                
 

<?php 	        

echo '</div>';		
	
	
}	
	
	
/**********************************************************************************************/	
		function link(){

		printf("<p><b><br />%s</b></p>\n",
		build_href2("../admin/find3.php" ,"","", "חפש פורומים", "class=href_modal1"));


		
		printf("<p><b>%s</b></p>\n",
	//	build_href("forum_demo_last8.php", "", " הוסף/ערוך פורום " ));
     build_href2("../admin/forum_demo_last8.php" ,"","", "הוסף/ערוך פורום", "class=href_modal1"));  
		return true;
	}
/**************************************************************/
	
/***************************************************************************/
	function link_b(){

		printf("<p><b><br />%s</b></p>\n",
		//build_href("find3.php", "", "חפש פורומים"));
        build_href2("../admin/find3.php" ,"","", "חפש פורומים", "class=href_modal1"));
		
		printf("<p><b>%s</b></p>\n",
		build_href2("../admin/forum_demo_last8.php" ,"","", "הוסף/ערוך פורום", "class=href_modal1"));
		return true;
	}
/**************************************************************/
	
	function show_page_links($page, $pagesize, $results, $query) {

		if(($page==1 && $results<=$pagesize) || $results==0)
		// nothing to do
		return;
		echo "<p>Goto page: ";
		if($page>1) {
			for($i=1; $i<$page; $i++)
			echo build_href("dynamic_8.php", $query . "&page=$i", $i), " ";
			echo "$page "; }
			if($results>$pagesize) {
				$nextpage = $page + 1;
				echo build_href("dynamic_8.php", $query . "&page=$nextpage", $nextpage);
			}
			echo "</p>\n";
	}						// $results  .. no. of search results
/************************************************************************************************/
	function build_date(&$formdata){
		
		
if($formdata['dynamic_9']==1){		
	if(array_item($formdata,'forum_decID') || is_numeric($forum_decID)){
	$forum_decID=array_item($formdata,'forum_decID')?array_item($formdata,'forum_decID'):$forum_decID;		
    $formdata["dest_users"]=$formdata["dest_users$forum_decID"];
   }
}

		 if(  // array_item($formdata,'member')
	               array_item($formdata,'member_date0')
		        && array_item($formdata,'dest_users')
		        &&  count($formdata['dest_users'])>0
		        && !is_numeric($formdata['member'])
		        && (!array_item($formdata,'multi_month')||($formdata['multi_month'][0]=='none'))
		        && (!array_item($formdata,'multi_year') ||($formdata['multi_year'][0]=='none'))
		        && !is_numeric($formdata['multi_year'][0])  
		        && !is_numeric($formdata['multi_month'][0])  
		        && !is_numeric($formdata['multi_day'][0])  
		        && !array_item($formdata,'year_date') 
		        && !is_numeric($formdata['month_date']) 
		        &&  !is_numeric($formdata['day_date'])) {
		
        $i=0;
		     	
		foreach($formdata['dest_users'] as $row){
			$member_date="member_date$i"; 
			list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$formdata[$member_date]);
     	        if (strlen($year_date_the_date) < 3){
		           $formdata[$member_date]="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $formdata[$member_date]="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    } 
			$rows['full_date'][$i] =$formdata[$member_date];
			
		$i++;	
		}
		
		 
	
		
		
		
		$fields = array( 'year_date' => 'integer', 'month_date' => 'integer','day_date' => 'intger','full_date'=>'string');

       
	}elseif( array_item($formdata,'year_date') 
		   && is_numeric($formdata['month_date']) 
		   &&  is_numeric($formdata['day_date'])
		   &&  !array_item($formdata,'multi_year') 
		   && !is_numeric($formdata['multi_month'][0]) 
		   &&  !is_numeric($formdata['multi_day'][0]) ){
		   	
		   	
			foreach ($fields as $key => $type) {
				$rows[$key] = $this-> safify($formdata[$key], $type);
			}
			$rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
			$rows['full_date'] =$this-> safify($rows['full_date'] , $type);
			 

		}elseif(   array_item($formdata,'multi_day')
		        && array_item($formdata,'multi_month')
		        && array_item($formdata,'multi_year')
		        && is_numeric($formdata['multi_year'][0]) 
		        && is_numeric($formdata['multi_month'][0])
		        && is_numeric($formdata['multi_day'][0]) ) {
		 $fields = array( 'multi_year' => 'integer', 'multi_month' => 'integer','multi_day' => 'intger','full_date'=>'string');
			foreach ($fields as $key => $type) {
				for($i=0;$i<count($formdata['multi_day']);$i++){

					if(!$formdata[$key][$i])
					$formdata[$key][$i]=$formdata[$key][$i-1];
					$rows[$key][$i] =$this-> safify($formdata[$key][$i], $type);
					 
				}
			}


			for($i=0;$i<count($formdata['multi_day']);$i++){
				$multi_tmp_year=$rows[multi_year][$i];
				 
				$multi_tmp_month=$rows[multi_month][$i];
				$multi_tmp_day=$rows[multi_day][$i];
				$rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";
				 
				//unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
			//	 $rows['full_date'][$i] =$this-> safify($rows['full_date'][$i] , $type);

			}


		}else{
			$now	=	date('Y-m-d H:i:s');
			$dates = getdate();
            $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
            $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);
    
           $today= $this->build_date5($dates); 
          $rows['today']=$today['full_date'];
			
		}
		
//    	 var_dump($rows['full_date']);die;
		//return $rows['full_date'];
		return $rows;
      
	}
/**********************************************************************************************/
	function build_date_appoint(&$formdata){

	
		
		
		
		$fields = array( 'year_date' => 'integer', 'month_date' => 'integer','day_date' => 'intger','full_date'=>'string');

       
	if( array_item($formdata,'year_date') 
		   && is_numeric($formdata['month_date']) 
		   &&  is_numeric($formdata['day_date'])
		   &&  !array_item($formdata,'multi_year_appoint') 
		   && !is_numeric($formdata['multi_month_appoint'][0]) 
		   &&  !is_numeric($formdata['multi_day_appoint'][0]) ){
		   	
		   	
			foreach ($fields as $key => $type) {
				$rows[$key] = $this-> safify($formdata[$key], $type);
			}
			$rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
			$rows['full_date'] =$this-> safify($rows['full_date'] , $type);
			 

		}elseif(   array_item($formdata,'multi_day_appoint')
		        && array_item($formdata,'multi_month_appoint')
		        && array_item($formdata,'multi_year_appoint')
		        && is_numeric($formdata['multi_year_appoint'][0]) 
		        && is_numeric($formdata['multi_month_appoint'][0])
		        && is_numeric($formdata['multi_day_appoint'][0]) ) {
		 $fields = array( 'multi_year_appoint' => 'integer', 'multi_month_appoint' => 'integer','multi_day_appoint' => 'intger','full_date'=>'string');
			foreach ($fields as $key => $type) {
				for($i=0;$i<count($formdata['multi_day_appoint']);$i++){

					if(!$formdata[$key][$i])
					$formdata[$key][$i]=$formdata[$key][$i-1];
					$rows[$key][$i] =$this-> safify($formdata[$key][$i], $type);
				}
			}


			for($i=0;$i<count($formdata['multi_day_appoint']);$i++){
				$multi_tmp_year=$rows[multi_year_appoint][$i];
				 
				$multi_tmp_month=$rows[multi_month_appoint][$i];
				$multi_tmp_day=$rows[multi_day_appoint][$i];
				$rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";
				//unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
				//$rows['full_date'][$i] =$this-> safify($rows['full_date'][$i] , $type);

			}


		}
		//return $rows['full_date'];
		return $rows;
       
	}
/**********************************************************************************************/
	function build_date_manager(&$formdata){

	
		
		
		
		$fields = array( 'year_date' => 'integer', 'month_date' => 'integer','day_date' => 'intger','full_date'=>'string');

       
	if( array_item($formdata,'year_date') 
		   && is_numeric($formdata['month_date']) 
		   &&  is_numeric($formdata['day_date'])
		   &&  !array_item($formdata,'multi_year_manager') 
		   && !is_numeric($formdata['multi_month_manager'][0]) 
		   &&  !is_numeric($formdata['multi_day_manager'][0]) ){
		   	
		   	
			foreach ($fields as $key => $type) {
				$rows[$key] = $this-> safify($formdata[$key], $type);
			}
			$rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
			$rows['full_date'] =$this-> safify($rows['full_date'] , $type);
			 

		}elseif(   array_item($formdata,'multi_day_manager')
		        && array_item($formdata,'multi_month_manager')
		        && array_item($formdata,'multi_year_manager')
		        && is_numeric($formdata['multi_year_manager'][0]) 
		        && is_numeric($formdata['multi_month_manager'][0])
		        && is_numeric($formdata['multi_day_manager'][0]) ) {
		 $fields = array( 'multi_year_manager' => 'integer', 'multi_month_manager' => 'integer','multi_day_manager' => 'intger','full_date'=>'string');
			foreach ($fields as $key => $type) {
				for($i=0;$i<count($formdata['multi_day_manager']);$i++){

					if(!$formdata[$key][$i])
					$formdata[$key][$i]=$formdata[$key][$i-1];
					$rows[$key][$i] =$this-> safify($formdata[$key][$i], $type);
				}
			}


			for($i=0;$i<count($formdata['multi_day_manager']);$i++){
				$multi_tmp_year=$rows[multi_year_manager][$i];
				 
				$multi_tmp_month=$rows[multi_month_manager][$i];
				$multi_tmp_day=$rows[multi_day_manager][$i];
				$rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";
				//unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
				//$rows['full_date'][$i] =$this-> safify($rows['full_date'][$i] , $type);

			}


		}

		return $rows;
       
	}
/**********************************************************************************************/	
	

	function build_date3(&$formdata){	
if(array_item($formdata,'multi_day')
		        && array_item($formdata,'multi_month_2')
		        && array_item($formdata,'multi_year_2')
		        && is_numeric($formdata['multi_year_2'][0]) 
		        && is_numeric($formdata['multi_month_2'][0])
		        && is_numeric($formdata['multi_day_2'][0]) ) {
		 $fields = array( 'multi_year_2' => 'integer', 'multi_month_2' => 'integer','multi_day_2' => 'intger','full_date_2'=>'string');
			foreach ($fields as $key => $type) {
				for($i=0;$i<count($formdata['multi_day_2']);$i++){

					if(!$formdata[$key][$i])
					$formdata[$key][$i]=$formdata[$key][$i-1];
					$rows[$key][$i] =$this-> safify($formdata[$key][$i], $type);
				}
			}


			for($i=0;$i<count($formdata['multi_day_2']);$i++){
				$multi_tmp_year=$rows[multi_year_2][$i];
				 
				$multi_tmp_month=$rows[multi_month_2][$i];
				$multi_tmp_day=$rows[multi_day_2][$i];
				$rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";
				//unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
				$rows['full_date_2'][$i] =$this-> safify($rows['full_date_2'][$i] , $type);

			}


		}
			return $rows;

	}	
/****************************************************************************************************************************************/			
		
	function build_date1(&$formdata){

		$fields = array( 'year_date' => 'integer', 'month_date' => 'integer','day_date' => 'intger','full_date'=>'string');


		 
			foreach ($fields as $key => $type) {
				$rows[$key] = $this-> safify($formdata[$key], $type);
			}
			$rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
			$rows['full_date'] =$this-> safify($rows['full_date'] , $type);
			
		return $rows;

	}		

/**********************************************************************************************/
	function build_date2(&$formdata){
	
$fields = array( 'year_date_forum' => 'integer', 'month_date_forum' => 'integer','day_date_forum' => 'intger','full_date'=>'string');
      


   	    foreach ($fields as $key => $type) {
       $rows[$key] = $this-> safify($formdata[$key], $type);
   } 
        $rows['full_date'] = "$rows[year_date_forum]-$rows[month_date_forum]-$rows[day_date_forum]";
       // $rows['full_date'] =$this-> safify($rows['full_date'] , $type);
         
         
 
 	
return $rows;	
}			
/****************************************************************************************************/	
	function build_date_single_usr(&$formdata){

		$fields = array( 'year_date_usr' => 'integer', 'month_date_usr' => 'integer','day_date_usr' => 'intger','full_date_usr'=>'string');


		 
			foreach ($fields as $key => $type) {
				$rows[$key] = $this-> safify($formdata[$key], $type);
			}
			$rows['full_date_usr'] = "$rows[year_date_usr]-$rows[month_date_usr]-$rows[day_date_usr]";
			//$rows1['full_date_usr'] = "$formdata[year_date_usr]-$formdata[month_date_usr]-$formdata[day_date_usr]";
			$rows['full_date_usr'] =$this-> safify($rows['full_date_usr'] , $type);
			
		return $rows;

	}	
/***************************************************************************************************/
function build_date33(&$formdata){

		$fields = array( 'year_date_addusr' => 'integer', 'month_date_addusr' => 'integer','day_date_addusr' => 'intger','full_date_addusr'=>'string');


		 
			foreach ($fields as $key => $type) {
				$rows[$key] = $this-> safify($formdata[$key], $type);
			}
			$rows['full_date_addusr'] = "$rows[year_date_addusr]-$rows[month_date_addusr]-$rows[day_date_addusr]";
			$rows['full_date_addusr'] =$this-> safify($rows['full_date_addusr'] , $type);
			
		return $rows['full_date_addusr'];

	}
/*****************************************************************************************************/				
function build_date4(&$formdata){
	
  $fields = array( 'year_date_forum' => 'integer', 'month_date_forum' => 'integer','day_date_forum' => 'intger','full_date'=>'string');
      


   	    foreach ($fields as $key => $type) {
       $rows[$key] = $this-> safify($formdata[$key], $type);
   } 
        $rows['full_date'] = "$rows[year_date_forum]-$rows[month_date_forum]-$rows[day_date_forum]";
       // $rows['full_date'] =$this-> safify($rows['full_date'] , $type);
         
         
 
 	
return $rows;	
}		
/**************************************************************************************************/		
function build_date5(&$formdata){
	
  $fields = array( 'year' => 'integer', 'mon' => 'integer','mday' => 'intger','full_date'=>'string');
      


   	    foreach ($fields as $key => $type) {
       $rows[$key] = $this-> safify($formdata[$key], $type);
   } 
        $rows['full_date'] = "$rows[year]-$rows[mon]-$rows[mday]";
       // $rows['full_date'] =$this-> safify($rows['full_date'] , $type);
         
         
 
 	
return $rows;	
}		
/**************************************************************************************************/									
	function redirect($url = null)
	{
 
	 	if(is_null($url)) $url =$_SERVER['SCRIPT_NAME'];
       	header("Location: $url");
 		exit();
	}			

//********************************************************************************************************
 
 function  print_forum_paging($forum_decID="") {
	global $db;
  echo "<h1>בחר פורום</h1>\n";
  echo "<p><b style='color:blue;'>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים נוספים בפורום.</b></p>\n";
  
  $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
  $rows = $db->queryObjectArray($sql);
 $parent=array();
  foreach($rows as $row) {
    $subcats[$row->parentForumID][] = $row->forum_decID;
    $catNames[$row->forum_decID] = $row->forum_decName;
    $parent[$row->forum_decID][] = $row->parentForumID; }

    
  
//  echo '<tr><td class="myformtable">';
//  echo '<table>';   
echo '<fieldset class="my_pageCount">';
    echo '<ul class="paginated" style=left:100px;  >'; 
    if(!is_numeric($forum_decID) )
        $this->print_categories_forum_paging($subcats[NULL], $subcats, $catNames,$parent);
        else
       $this->print_categories_forum_paging_link ($subcats[NULL], $subcats, $catNames,$parent,$forum_decID);
       
    echo '</ul class="paginated"></fieldset>';
//  echo '</table>';
//  echo '</td></tr>';       
    echo '<BR><BR>'; 
   }
 

/*******************************************************************************/
  
 function print_categories_forum_paging($catIDs, $subcats, $catNames,$parent) {
  echo '<ul>';
  foreach($catIDs as $catID) {
  	$url="../admin/find3.php?forum_decID=$catID";
   	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
  	if($catID==11){
  		printf("<li><b>%s (%s, %s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"));
     
    }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){	 
    
    printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
     // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
       build_href5("", "", "הראה נתונים",$str));
      
  	}elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  		printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
    //  build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
     build_href5("", "", "הראה נתונים",$str));
      
     //  echo "</li>\n";
      
  	}else{ 
  	  printf("<li><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/dynamic_8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
     // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
       build_href5("", "", "הראה נתונים",$str));
     //  echo "</li>\n";
      
  	}
  	
 
    if(array_key_exists($catID, $subcats))
      $this->print_categories_forum_paging($subcats[$catID], $subcats, $catNames,$parent);
  }
   echo "</li></ul>\n";
}

 
/*******************************************************************************/
  
 function print_categories_forum_paging_link($catIDs, $subcats, $catNames,$parent,$forum_decID) {
  echo '<ul>';
  foreach($catIDs as $catID) {
  	$url="../admin/find3.php?forum_decID=$catID";
   	$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
  	if($catID==11){
  		printf("<li><b>%s (%s, %s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"));
     
    }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){	 
    
    printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      build_href5("", "", "הראה נתונים",$str));
      
  	}elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  		printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      build_href5("", "", "הראה נתונים",$str));
  	}else{ 
  	  printf("<li><b>%s (%s, %s, %s,%s,%s)</b>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      build_href5("", "", "הראה נתונים",$str));
  	}
  	
 
    if(array_key_exists($catID, $subcats))
      $this->print_categories_forum_paging_link($subcats[$catID], $subcats, $catNames,$parent,$forum_decID);

  }
   echo "</li></ul>\n";
}
/***********************************************************************************************************/
 function  print_forum_paging_b($forum_decID="") {
/*************************************************************************************************************/
 	
	global $db;
//  echo "<h1>בחר פורום</h1>\n";
//  echo "<p> <b style='color:blue;'>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים נוספים בפורום.</B></p>\n";
  
  $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
  $rows = $db->queryObjectArray($sql);
 $parent=array();
  foreach($rows as $row) {
    $subcats[$row->parentForumID][] = $row->forum_decID;
    $catNames[$row->forum_decID] = $row->forum_decName;
    $parent[$row->forum_decID][] = $row->parentForumID; }
    echo '<fieldset class="my_pageCount"  style="margin-right:32px;">';
    
   
    
    echo '<ul class="paginated" style=left:100px;  >'; 
    if(!is_numeric($forum_decID) )
        $this->print_categories_forum_paging_b($subcats[NULL], $subcats, $catNames,$parent);
        else
       $this->print_categories_forum_paging_link_b ($subcats[NULL], $subcats, $catNames,$parent,$forum_decID);
       
    echo '</ul class="paginated"></fieldset>';
    echo '<BR><BR>'; 
   }
 

/*********************************************************************************/  
 function print_categories_forum_paging_b($catIDs, $subcats, $catNames,$parent) {
/*********************************************************************************/ 

 	
 /*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
/*********************************************/ 	
 	
 if($level)	{
 	
 	
  echo '<ul>';
  foreach($catIDs as $catID) {
  	 $url="../admin/find3.php?forum_decID=$catID";
   	 $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$catID.'"   ';
  	if($catID==11){
  		printf("<li style='font-weight:bold;color:red;font-size:20px;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '15px')\">%s (%s, %s)</li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/forum_demo_last8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"));
     
    }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){	 
    
    printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s, %s,%s,%s)</li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/forum_demo_last8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
      build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      //build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
      build_href5("", "", "הראה נתונים",$str)); 
  	}elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  		printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s, %s,%s,%s)\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/forum_demo_last8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
      build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      //build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
      build_href5("", "", "הראה נתונים",$str)); 
     //  echo "</li>\n";
      
  	}else{ 
  	  printf("<li style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s, %s,%s,%s)\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("../admin/forum_demo_last8.php","mode=insert","&insertID=$catID", "הוסף"),
      build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
      build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
      build_href5("", "", "הראה נתונים",$str)); 
  	}
  	
 
    if(array_key_exists($catID, $subcats))
      $this->print_categories_forum_paging_b($subcats[$catID], $subcats, $catNames,$parent);
  }
   echo "</li></ul>\n";

/////////////////////// 
 }elseif(!($level)){//
///////////////////// 	
  echo '<ul>';
  foreach($catIDs as $catID) {
  	 $url="../admin/find3.php?forum_decID=$catID";
   	 $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$catID.'"   ';
  	if($catID==11){
  		printf("<li style='font-weight:bold;color:red;font-size:30px;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '15px')\">%s </li>\n",
      htmlspecial_utf8($catNames[$catID]));
     
    }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){	 
    
    printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s)</li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "מידע מורחב"),
      build_href5("", "", "הראה נתונים",$str)); 
  	}elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  		printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s)\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "מידע מורחב"),
      build_href5("", "", "הראה נתונים",$str)); 
     
      
  	}else{ 
  	  printf("<li style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s)\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "מידע מורחב"),
      build_href5("", "", "הראה נתונים",$str)); 
  	}
  	
 
    if(array_key_exists($catID, $subcats))
      $this->print_categories_forum_paging_b($subcats[$catID], $subcats, $catNames,$parent);
  }
   echo "</li></ul>\n";
 	
 
 
 
 
 
 }
 
//////////////// 
 }//end func///
//////////////
 
/*******************************************************************************/
  
 function print_categories_forum_paging_link_b($catIDs, $subcats, $catNames,$parent,$forum_decID) {
  echo '<ul>';
  foreach($catIDs as $catID) {
  	 $url="../admin/find3.php?forum_decID=$catID";
   	 $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$catID.'" ';
  	if($catID==11){
  		printf("<li style='font-weight :bold;'>%s (%s, %s)</li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"));
     
    }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){	 
  
 
    printf("<li class='li_page'  style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)</li>\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
      build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
     // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
        build_href5("", "", "הראה נתונים",$str)); 
  	}elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
  		printf("<li class='li_page' style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
      build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
     // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
        build_href5("", "", "הראה נתונים",$str)); 
  	}else{ 
  	  printf("<li  style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)\n",
      htmlspecial_utf8($catNames[$catID]),
      build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$forum_decID", "קשר אליי"),
      build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
      build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
      build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
     // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
        build_href5("", "", "הראה נתונים",$str)); 
  	}
  	
 
    if(array_key_exists($catID, $subcats))
      $this->print_categories_forum_paging_link_b($subcats[$catID], $subcats, $catNames,$parent,$forum_decID);

  }
   echo "</li></ul>\n";
}

/*******************************************************************************/
	function print_forum($forum_decIDs, $subcats, $forumNames) {
/**************************************************************************/
		
		global $db;
		echo "<ul>";
		foreach($forum_decIDs as $forum_decID) {
				if($forum_decID==11){
  		    printf("<li><b>%s(%s,%s)</b></li>\n",
            htmlspecial_utf8($catNames[$forum_decID]),
            build_href2("dynamic_8.php","mode=insert","&insertID=$forum_decID", "הוסף"),
	        build_href2("dynamic_8.php" ,"mode=update","&updateID=$forum_decID", "עדכן"));
			}else{  
			printf("<li><b>%s (%s, %s,  %s, %s, %s )</b></li>\n",
				
			htmlspecial_utf8($decNames[$forum_decID]),
				
			build_href2("dynamic_8.php","mode=insert","&insertID=$forum_decID", "הוסף"),
			build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$forum_decID", "מחק","OnClick='return verify();' class='href_modal1'"),
			build_href2("dynamic_8.php" ,"mode=update","&updateID=$forum_decID", "עדכן"),
			build_href("find3.php" ,"&forum_decID=$forum_decID", "נתונים כלליים"),
			build_href2("dynamic_8.php" ,"mode=read_data","&editID=$forum_decID", "עידכון מורחב"));
			} 
	        	  		
			if(array_key_exists($forum_decID, $subcats))
			$this->print_forum($subcats[$forum_decID], $subcats, $forumNames);
		}
		echo "</ul>\n";
	}
//********************************************************************************************************


	function  print_form1($forum_decID1) {
		global $db;
			

			
		$sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);
		foreach($rows as $row) {
			$subcats[$row->parentForum_decID][] = $row->forum_decID;
			$forumNames[$row->forum_decID] = $row->forum_decName; }
			// build hierarchical list
			$this->print_forums1($subcats[NULL], $subcats, $forumNames,$forum_decID1);

			// link to input and search forms
			printf("<p><b><br />%s</b></p>\n",
			build_href("find3.php", "", "חפש פורומים/החלטות"));
			$insertID=$_GET['insertID'];
			return $insertID;
	}

/*******************************************************************************/
	
	function print_forum_dec($forum_decIDs, $subcats, $forumNames) {
		echo "<ul>";
		foreach($forum_decIDs as $forum_decID) {
				if($forum_decID==11){
  		    printf("<li><b>%s (%s, %s)</b></li>\n",
            htmlspecial_utf8($catNames[$forum_decID]),
            build_href2("dynamic_8.php","mode=insert","&insertID=$forum_decID", "הוסף"),
	        build_href2("dynamic_8.php" ,"mode=update","&updateID=$forum_decID", "עדכן"));
			}else{
			printf("<li><b>%s (%s, %s, %s, %s, %s )</b></li>\n",
				
			htmlspecial_utf8($decNames[$forum_decID]),
				
			build_href2("dynamic_8.php","mode=insert","&insertID=$forum_decID", "הוסף"),
			build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$forum_decID","OnClick= 'return verify();' class='href_modal1'"),
			build_href2("dynamic_8.php" ,"mode=update","&updateID=$forum_decID", "עדכן"),
			build_href("find3.php" ,"&forum_decID=$forum_decID", "נתונים כלליים"),
			build_href2("dynamic_8.php" ,"mode=read_data","&editID=$forum_decID", "עידכון מורחב"));

			}

			if(array_key_exists($forum_decID, $subcats)){
					
				$this->print_forums($subcats[$forum_decID], $subcats, $forumNames);
					
			}
		}
		echo "</ul>\n";
	}
/*******************************************************************************/
	function  print_form2($forum_decID1) {
/*******************************************************************************/		
		global $db;
			

		// query for all categories1
		$sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);
		foreach($rows as $row) {
			$subcats[$row->parentforum_decID][] = $row->forum_decID;
			$forumNames[$row->forum_decID] = $row->forum_decName; }
			// build hierarchical list
			$this->print_forums1($subcats[NULL], $subcats, $forumNames,$forum_decID1);
			printf("<p><b><br />%s<b></p>\n",
			build_href("find3.php", "", "חפש פורומים/החלטות"));
	}
/*******************************************************************************/	
	function print_forums1($forum_decIDs, $subcats, $forumNames,$forum_decID1) {
/*******************************************************************************/		
		echo "<ul>";
		foreach($forum_decIDs as $forum_decID) {
			printf("<li>%s (%s)</li>\n",
			htmlspecial_utf8($decNames[$forum_decID]),
			//build_href("dynamic_8.php","&insertID=$forum_decID", "קשר אליי"));
			build_href2("dynamic_8.php","mode=link","&insertID=$forum_decID&forum_decID=$forum_decID1", "קשר אליי"));
			if(array_key_exists($forum_decID, $subcats))
			$this->print_forums1($subcats[$forum_decID], $subcats, $forumNames,$forum_decID1);
		}
		echo "</ul>\n";
	}

/******************************************************************************************************/
  		function print_forum_entry_form1($updateID,$mode='') {
/******************************************************************************************************/  			
 	    $insertID=$updateID;		
		global $db;
 /*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
/*********************************************/ 
if($level){
		$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$forumNames[$row->forum_decID] = $row->forum_decName;
			$parents[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }

			// build list of all parents for $insertID
			$forum_decID = $updateID;
			while($parents[$forum_decID]!=NULL) {
				$forum_decID = $parents[$forum_decID];
				$parentList[] = $forum_decID; 
            
			
			}				
				//display all exept the choozen
				if(isset($parentList)){
				for($i=sizeof($parentList)-1; $i>=0; $i--){
                 ?><div id="my_forum_entry_first<?PHP echo $updateID; ?>"><?php  
 		         $url="../admin/find3.php?forum_decID=$parentList[$i]";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
					
				if( $parentList[$i] =='11'){
				  printf("<ul id='my_ul_first'><li style='font-weight :bold;'> <img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s (%s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_8.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_8.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם")
					);	
					
				}else{
				
				printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_8.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();' class='href_modal1'"),
					build_href2("dynamic_8.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם"),
					build_href2("dynamic_8.php" ,"mode=read_data","&editID=$parentList[$i]", "עידכון מורחב"),
					build_href5("", "", "הראה נתונים",$str)); 
                      
				 
				
				}
				
			}
	  }		
	  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	 
	  // display choosen forum  * BOLD *
	  if($insertID=='11'){
	   	 	 	 printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_8.php","mode=insert","&insertID=$updateID", "הוסף"),
			    	build_href2("dynamic_8.php" ,"mode=update","&updateID=$updateID", "עדכן שם"));
			
	   	 }else{
	   	 	    $url="../admin/find3.php?forum_decID=$updateID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
			 	 printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_8.php","mode=insert","&insertID=$updateID", "הוסף"),
					build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$updateID", "מחק","OnClick='return verify();' class='href_modal1'"),
					build_href2("dynamic_8.php" ,"mode=update","&updateID=$updateID", "עדכן שם"),
					build_href2("dynamic_8.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
					build_href5("", "", "הראה נתונים",$str)); 
	   	 }			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
				
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $forum_decID) {
				$url="../admin/find3.php?forum_decID=$forum_decID";
      	        $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
				 printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
		             
							htmlspecial_utf8($forumNames[$forum_decID]),
							build_href2("dynamic_8.php","mode=insert","&insertID=$forum_decID", "הוסף"),
							build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$forum_decID", "מחק","OnClick='return verify();' class='href_modal1'"),
							build_href2("dynamic_8.php" ,"mode=update","&updateID=$forum_decID", "עדכן"),
							build_href2("dynamic_8.php" ,"mode=read_data","&editID=$forum_decID", "עידכון מורחב"),
							build_href5("", "", "הראה נתונים",$str)); 
						
							
						}
		
			  echo "<ul>"; 
		     $updateID=$forum_decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-פורומים.)";
		}
				
		 
 echo "</ul>\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				// close hierarchical category list
				if(isset($parentList))
				echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

 echo '</div>';				
/////////////////////////////				
      }elseif(!($level)){///
///////////////////////////      	
      	
      	$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$forumNames[$row->forum_decID] = $row->forum_decName;
			$parents[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }

			// build list of all parents for $insertID
			$forum_decID = $updateID;
			while($parents[$forum_decID]!=NULL) {
				$forum_decID = $parents[$forum_decID];
				$parentList[] = $forum_decID; 
            
			
			}				
				//display all exept the choozen
				if(isset($parentList)){
				for($i=sizeof($parentList)-1; $i>=0; $i--){
                 ?><div id="my_forum_entry_first<?PHP echo $updateID; ?>"><?php  
 		         $url="../admin/find3.php?forum_decID=$parentList[$i]";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
					
				if( $parentList[$i] =='11'){
				  printf("<ul id='my_ul_first'><li style='font-weight :bold;'> <img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s </b> </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]));	
				}else{
				
				printf("<ul><li style='font-weight :bold;'> %s (%s, %s ) </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_8.php" ,"mode=read_data","&editID=$parentList[$i]", "מידע מורחב"),
					build_href5("", "", "הראה נתונים",$str)); 
                      
				 
				
				}
				
			}
	  }		
	  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	 
	  // display choosen forum  * BOLD *
	  if($insertID=='11'){
	   	 	 	 printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_8.php","mode=insert","&insertID=$updateID", "הוסף"),
			    	build_href2("dynamic_8.php" ,"mode=update","&updateID=$updateID", "עדכן שם"));
			
	   	 }else{
	   	 	    $url="../admin/find3.php?forum_decID=$updateID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
			 	 printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_8.php" ,"mode=read_data","&editID=$updateID", "מידע מורחב"),
					build_href5("", "", "הראה נתונים",$str)); 
	   	 }			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
				
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $forum_decID) {
				$url="../admin/find3.php?forum_decID=$forum_decID";
      	        $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
				 printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",
		             
							htmlspecial_utf8($forumNames[$forum_decID]),
							build_href2("dynamic_8.php" ,"mode=read_data","&editID=$forum_decID", "מידע מורחב"),
							build_href5("", "", "הראה נתונים",$str)); 
						
							
						}
		
			  echo "<ul>"; 
		     $updateID=$forum_decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-פורומים.)";
		}
				
		 
 echo "</ul>\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				// close hierarchical category list
				if(isset($parentList))
				echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

 echo '</div>';				
      	
      }//end else
/////////////////////				
	} //end func //
//////////////////

/******************************************************************************************************/
 		function print_forum_entry_form_b($updateID,$mode='') {
/******************************************************************************************************/ 			
 		$insertID=$updateID;	
		global $db;
 
/*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
/*********************************************/ 
  if($level){
		$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$forumNames[$row->forum_decID] = $row->forum_decName;
			$parents[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }

			// build list of all parents for $insertID
			$forum_decID = $updateID;
			while($parents[$forum_decID]!=NULL) {
				$forum_decID = $parents[$forum_decID];
				$parentList[] = $forum_decID; 
			}

	echo '<div id="my_forum_entry_b">';			 
				
				//display all exept the choozen
				if(isset($parentList)){
				for($i=sizeof($parentList)-1; $i>=0; $i--){
				 $url="../admin/find3.php?forum_decID=$parentList[$i]";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				if( $parentList[$i] =='11'){
				  printf("<ul><li style='font-weight :bold;'> <img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s (%s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם")
					);	
					
				}else{
				
				printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();'class=href_modal1"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם"),
				    build_href2("dynamic_10.php" ,"mode=read_data","&editID=$parentList[$i]", "עידכון מורחב"),
				    build_href5("", "", "הראה נתונים",$str)); 
                      
				 
				
				}
				
			}
	  }		
	  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	 
	  // display choosen forum  * BOLD *
   		 	 //display the last on
	   	 if($insertID=='11'){
	   	 	 	 printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$updateID", "הוסף"),
			    	build_href2("dynamic_10.php" ,"mode=update","&updateID=$updateID", "עדכן שם"));
			
	   	 }else{
	   	 	 $url="../admin/find3.php?forum_decID=$updateID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
			 	 printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$updateID", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$updateID", "מחק","OnClick='return verify();'class=href_modal1"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$updateID", "עדכן שם"),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
					build_href5("", "", "הראה נתונים",$str));
	   	 }			 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $forum_decID) {
				 $url="../admin/find3.php?forum_decID=$forum_decID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				 printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
		             
							htmlspecial_utf8($forumNames[$forum_decID]),
							build_href2("dynamic_10.php","mode=insert","&insertID=$forum_decID", "הוסף"),
							build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$forum_decID", "מחק","OnClick='return verify();'class=href_modal1"),
							build_href2("dynamic_10.php" ,"mode=update","&updateID=$forum_decID", "עדכן"),
							build_href2("dynamic_10.php" ,"mode=read_data","&editID=$forum_decID", "עידכון מורחב"),
							 build_href5("", "", "הראה נתונים",$str)); 
						
							
						}
		
			  echo "<ul>"; 
		     $updateID=$forum_decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-פורומים.)";
		}
				
		 
 echo "</ul>\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				// close hierarchical category list
				if(isset($parentList))
				echo str_repeat("</ul>", sizeof($parentList)+1), "\n";
/****************************************************************************************/
			
 	
	 echo '</div>';
 

  }elseif(!($level)){
  			$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$forumNames[$row->forum_decID] = $row->forum_decName;
			$parents[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }

			// build list of all parents for $insertID
			$forum_decID = $updateID;
			while($parents[$forum_decID]!=NULL) {
				$forum_decID = $parents[$forum_decID];
				$parentList[] = $forum_decID; 
			}

	echo '<div id="my_forum_entry_b">';			 
				
				//display all exept the choozen
				if(isset($parentList)){
				for($i=sizeof($parentList)-1; $i>=0; $i--){
				 $url="../admin/find3.php?forum_decID=$parentList[$i]";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				if( $parentList[$i] =='11'){
				  printf("<ul><li style='font-weight :bold;'> <img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s </b> </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]));	
					
				}else{
				
				printf("<ul><li style='font-weight :bold;'> %s (%s, %s) </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$parentList[$i]", "מידע מורחב"),
				    build_href5("", "", "הראה נתונים",$str)); 
                      
				 
				
				}
				
			}
	  }		
	  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	 
	  // display choosen forum  * BOLD *
   		 	 //display the last on
	   	 if($insertID=='11'){
	   	 	 	 printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$updateID", "הוסף"),
			    	build_href2("dynamic_10.php" ,"mode=update","&updateID=$updateID", "עדכן שם"));
			
	   	 }else{
	   	 	 $url="../admin/find3.php?forum_decID=$updateID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
			 	 printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "מידע מורחב"),
					build_href5("", "", "הראה נתונים",$str));
	   	 }			 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $forum_decID) {
				 $url="../admin/find3.php?forum_decID=$forum_decID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				 printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",
		             
							htmlspecial_utf8($forumNames[$forum_decID]),
							build_href2("dynamic_10.php" ,"mode=read_data","&editID=$forum_decID", "מידע מורחב"),
							 build_href5("", "", "הראה נתונים",$str)); 
						
							
						}
		
			  echo "<ul>"; 
		     $updateID=$forum_decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-פורומים.)";
		}
				
		 
 echo "</ul>\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				// close hierarchical category list
				if(isset($parentList))
				echo str_repeat("</ul>", sizeof($parentList)+1), "\n";
/****************************************************************************************/
			
 	
	 echo '</div>';
 
  	
  } 
	 
///////////////	 
}//end func///
/////////////
/******************************************************************************************************/
 		function print_forum_entry_form_c($updateID,$mode='') {
/*****************************************************************************************************/ 	
 		$insertID=$updateID;			
		global $db;
/*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
/*********************************************/ 
  if($level){
  
		$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$forumNames[$row->forum_decID] = $row->forum_decName;
			$parents[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }

			// build list of all parents for $insertID
			$forum_decID = $updateID;
			while($parents[$forum_decID]!=NULL) {
				$forum_decID = $parents[$forum_decID];
				$parentList[] = $forum_decID; 
            
			
			}

	echo '<div id="my_forum_entry_c">';			 
				
				//display all exept the choozen
				if(isset($parentList)){
				for($i=sizeof($parentList)-1; $i>=0; $i--){
				  $url="../admin/find3.php?forum_decID=$parentList[$i]";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				if( $parentList[$i] =='11'){
				  printf("<ul><li style='font-weight :bold;'> <img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s (%s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם")
					);	
					
				}else{
				
				printf("<ul><li style='font-weight:bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();' class='href_modal1'"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם"),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
					build_href5("", "", "הראה נתונים",$str));
                      
				 
				
				}
				
			}
	  }		
	  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	 
	  // display choosen forum  * BOLD *
   		 	 //display the last on
	  if($insertID=='11'){
	   	 	 	 printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$updateID", "הוסף"),
			    	build_href2("dynamic_10.php" ,"mode=update","&updateID=$updateID", "עדכן שם"));
			
	   	 }else{
	   	 	     $url="../admin/find3.php?forum_decID=$updateID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
			 	 printf("<ul><li class='bgchange_tree' style='font-weight:bold;'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$updateID", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$updateID", "מחק","OnClick='return verify();' class='href_modal1'"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$updateID", "עדכן שם"),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
					build_href5("", "", "הראה נתונים",$str));
	   	 }			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $forum_decID) {
				 $url="../admin/find3.php?forum_decID=$forum_decID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				 printf("<li style='font-weight:bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
		              
							htmlspecial_utf8($forumNames[$forum_decID]),
							build_href2("dynamic_10.php","mode=insert","&insertID=$forum_decID", "הוסף"),
							build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$forum_decID", "מחק","OnClick='return verify();' class='href_modal1'"),
							build_href2("dynamic_10.php" ,"mode=update","&updateID=$forum_decID", "עדכן"),
							build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
				        	build_href5("", "", "הראה נתונים",$str));
						
							
						}
		
			  echo "<ul>"; 
		     $updateID=$forum_decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-פורומים.)";
		}
				
		 
 echo "</ul>\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				// close hierarchical category list
				if(isset($parentList))
				echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

				
				
				
	 echo '</div>';
  
//////////////////////////  
  }elseif(!($level)){/////
//////////////////////////  	
  	
  	
  		$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$forumNames[$row->forum_decID] = $row->forum_decName;
			$parents[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }

			// build list of all parents for $insertID
			$forum_decID = $updateID;
			while($parents[$forum_decID]!=NULL) {
				$forum_decID = $parents[$forum_decID];
				$parentList[] = $forum_decID; 
            
			
			}

	echo '<div id="my_forum_entry_c">';			 
				
				//display all exept the choozen
				if(isset($parentList)){
				for($i=sizeof($parentList)-1; $i>=0; $i--){
				  $url="../admin/find3.php?forum_decID=$parentList[$i]";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				if( $parentList[$i] =='11'){
				  printf("<ul><li style='font-weight :bold;'> <img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s </b> </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]));	
					
				}else{
				
				printf("<ul><li style='font-weight:bold;'> %s (%s, %s ) </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "מידע מורחב"),
					build_href5("", "", "הראה נתונים",$str));
                  
				}
				
			}
	  }		
	  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	 
	  // display choosen forum  * BOLD *
   		 	 //display the last on
	  if($insertID=='11'){
	   	 	 	 printf("<ul><li><b style='color:red;'> %s </b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]));

			
	   	 }else{
	   	 	     $url="../admin/find3.php?forum_decID=$updateID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
			 	 printf("<ul><li class='bgchange_tree' style='font-weight:bold;'><b style='color:red;'> %s (%s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "מידע מורחב"),
					build_href5("", "", "הראה נתונים",$str));
	   	 }			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $forum_decID) {
				 $url="../admin/find3.php?forum_decID=$forum_decID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				 printf("<li style='font-weight:bold;'> %s (%s, %s) </li>\n",
		              
							htmlspecial_utf8($forumNames[$forum_decID]),
							build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "מידע מורחב"),
				        	build_href5("", "", "הראה נתונים",$str));
						
							
						}
		
			  echo "<ul>"; 
		     $updateID=$forum_decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-פורומים.)";
		}
				
		 
 echo "</ul>\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				// close hierarchical category list
				if(isset($parentList))
				echo str_repeat("</ul>", sizeof($parentList)+1), "\n";

				
				
				
	 echo '</div>';
  
  	
  }
				
///////////////	 
}//end func///
/////////////

/*****************************************************************************************************/
		function print_forum_entry_form_d($updateID,$mode='') {
 		$insertID=$updateID;	
		global $db;
 

  
		$sql  = "SELECT forum_decName, forum_decID, parentForumID " .
          " FROM forum_dec ORDER BY forum_decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {
			$forumNames[$row->forum_decID] = $row->forum_decName;
			$parents[$row->forum_decID] = $row->parentForumID;
			$subcats[$row->parentForumID][] = $row->forum_decID;   }

			// build list of all parents for $insertID
			$forum_decID = $updateID;
			while($parents[$forum_decID]!=NULL) {
				$forum_decID = $parents[$forum_decID];
				$parentList[] = $forum_decID; 
			}

	echo '<div id="my_forum_entry_b">';			 
				
				//display all exept the choozen
				if(isset($parentList)){
				for($i=sizeof($parentList)-1; $i>=0; $i--){
				 $url="../admin/find3.php?forum_decID=$parentList[$i]";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				if( $parentList[$i] =='11'){
				  printf("<ul><li style='font-weight :bold;'> <img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b> %s (%s, %s )</b></li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם")
					);	
					
				}else{
				
				printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
					htmlspecial_utf8($forumNames[$parentList[$i]]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$parentList[$i]", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$parentList[$i]", "מחק","OnClick='return verify();' class='href_modal1'"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$parentList[$i]", "עדכן שם"),
				    build_href2("dynamic_10.php" ,"mode=read_data","&editID=$parentList[$i]", "עידכון מורחב"),
				    build_href5("", "", "הראה נתונים",$str)); 
                      
				 
				
				}
				
			}
	  }		
	  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
 	 
	  // display choosen forum  * BOLD *
   		 	 //display the last on
	   	 if($insertID=='11'){
	   	 	 	 printf("<ul><li style='font-weight :bold;'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$updateID", "הוסף"),
			    	build_href2("dynamic_10.php" ,"mode=update","&updateID=$updateID", "עדכן שם"));
			
	   	 }else{
	   	 	    $url="../admin/find3.php?forum_decID=$updateID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
			 	 printf("<ul><li class='bgchange_tree' style='font-weight :bold;'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
					htmlspecial_utf8($forumNames[$updateID]),
					build_href2("dynamic_10.php","mode=insert","&insertID=$updateID", "הוסף"),
					build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$updateID", "מחק","OnClick='return verify();' class='href_modal1'"),
					build_href2("dynamic_10.php" ,"mode=update","&updateID=$updateID", "עדכן שם"),
					build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
					build_href5("", "", "הראה נתונים",$str));
	   	 }			 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
				 
	echo "<ul>";
 		
				
		$i=0;				
		if(array_key_exists($updateID, $subcats)){
		while($subcats[$updateID]){
			foreach($subcats[$updateID] as $forum_decID) {
				 $url="../admin/find3.php?forum_decID=$forum_decID";
      	         $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';	
				 printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
		             
							htmlspecial_utf8($forumNames[$forum_decID]),
							build_href2("dynamic_10.php","mode=insert","&insertID=$forum_decID", "הוסף"),
							build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$forum_decID", "מחק","OnClick='return verify();' class='href_modal1'"),
							build_href2("dynamic_10.php" ,"mode=update","&updateID=$forum_decID", "עדכן"),
							build_href2("dynamic_10.php" ,"mode=read_data","&editID=$forum_decID", "עידכון מורחב"),
							 build_href5("", "", "הראה נתונים",$str)); 
						
							
						}
		
			  echo "<ul>"; 
		     $updateID=$forum_decID;
		     $i++;	  
		  }
		  // close hierarchical category list
		  echo str_repeat("</ul>", $i+1), "\n";
		 }else{
		 		
		  echo "(עדיין אין תת-פורומים.)";
		}
				
		 
 echo "</ul>\n";
				
				// close hierarchical category list
				if(isset($parentList))
				echo str_repeat("</ul>", sizeof($parentList)+1), "\n";
/****************************************************************************************/
	if(($mode=='update')){
		 
				
				
	 echo '<form method="post" action="dynamic_10.php?mode=update&updateID=',
     $insertID, '">', "\n",
    "<p>עדכן שם הפורום של ",
    "<b>$forumNames[$insertID]</b>. <br /> ",
   '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
    '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
    "</form>\n";			
				
				
	}		
 	
	 echo '</div>';
 
				
	}

/****************************************************************************************/	
	function read_form(){
/****************************************************************************************/

		$insertID      = array_item($_REQUEST, 'insertID');
		$deleteID      = array_item($_REQUEST, 'deleteID');
		$updateID      = array_item($_REQUEST, 'updateID');
		$submitbutton  = array_item($_POST, 'submitbutton');
		$subcategories = array_item($_POST, 'subcategories');
		// remove magic quotes
		if(get_magic_quotes_gpc())
		$subcategories = stripslashes($subcategories);
	}


/*******************************************************************************************/

	// read all data for a certain forum from database
	// and save it in an array; return this array
	function read_forum_data($forum_decID) {

		global $db;
 
        $sql="select * from forum_dec WHERE forum_decID=$forum_decID  ";
		$rows = $db->queryObjectArray($sql);
		$rows[0]->forum_date=substr($rows[0]->forum_date,0,10);
		list($year_date,$month_date, $day_date) = explode('-',$rows[0]->forum_date);
		if (strlen($year_date>3))
		$rows[0]->forum_date="$day_date-$month_date-$year_date";	
//		$day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;
//		$month_date= is_null($day_date) ? 'NULL' : "'$month_date'" ;
		 
//		$day_date=substr($day_date, 0,4);
//		$day_date=substr($day_date,1,2);
//		if($month_date['1'] == '1' )
//		$month_date=substr($month_date,1,2);
//		else{
//			$month_date=substr($month_date,1,2);
			//$month_date=substr($month_date,1,1);
//		}
		if(is_array($rows) && sizeof($rows)==1) {
			$row1 = $rows[0];
			$result["forum_decision"]= $row1->forum_decID;
			$result["forum_decID"]=    $row1->forum_decID;
			$result["parentForumID"]=  $row1->parentForumID;
			$result["insertID"]=  $row1->parentForumID;
			$result["forum_decName"]=  $row1->forum_decName;
			$result["forum_status"] =  $row1->active;
			//$result["managerType"]=  $row1->managerTypeID;
			//$result["forum_date"]  =substr(($row->forum_date) ,10,6);
			$result["forum_date"]=     $row1->forum_date;
			$result['day_date']=       $day_date;
			$result['month_date']=     $month_date;
			$result['year_date']=      $year_date;
			
			
			$result["appoint_forum"]   =  $row1->appointID;
			$result["manager_forum"]   =  $row1->managerID;
			
			$result["appoint_date"]   =  $row1->appoint_date;
			list($year_date,$month_date, $day_date) = explode('-',$result["appoint_date"]);
            if(strlen($year_date)>3 ){
            $result["appoint_date"]="$day_date-$month_date-$year_date";
            }	
			
            
            $result["manager_date"]   =  $row1->manager_date;
			list($year_date,$month_date, $day_date) = explode('-',$result["manager_date"]);
            if(strlen($year_date)>3 ){
            $result["manager_date"]="$day_date-$month_date-$year_date";	
             }
			
			$result["src_users"]   = ""; 
			$result["src_usersID"]   = ""; 
			$result["date_users"]   = "";

			$result["src_managersType"]="";
            $result["src_forumsType"]="";  
/********************************USER_FORUM_NAME*******************************************/			

			$sql = "SELECT u.userID, u.full_name,r.HireDate FROM users u, rel_user_forum r " .
           " WHERE u.userID = r.userID " .
           " AND r.forum_decID = $forum_decID " . 
           " ORDER BY u.full_name ";
			if($rows = $db->queryObjectArray($sql))
			foreach($rows as $row){
				if(!$result["src_users"]){
				$name1=$row->full_name;
				$name=is_null ($name1) ? 'NULL' : "'$name1'";
				$result["src_users"] = $name;
				
				$date1=$row->HireDate;
				$date1=substr($row->HireDate,0,10);
				$date=is_null ($date1) ? 'NULL' : "'$date1'";
				$result["date_users"] = $date;
				}else{
			    $name1=$row->full_name;
				$name=is_null ($name1) ? 'NULL' : "'$name1'";	
			    $result["src_users"] .= "," . $name;
			    
			    $date1=$row->HireDate;
			    $date1=substr($row->HireDate,0,10);
				$date=is_null ($date1) ? 'NULL' : "'$date1'";
				$result["date_users"] .= "," . $date;
		      }  
			}
/********************************USER_FORUM_ID*******************************************/			

			$sql = "SELECT u.userID  FROM users u, rel_user_forum r " .
           " WHERE u.userID = r.userID " .
           " AND r.forum_decID = $forum_decID " . 
           " ORDER BY u.full_name ";
			if($rows = $db->queryObjectArray($sql))
			foreach($rows as $row){
				if(!$result["src_usersID"]){
				$userID=$row->userID;
				$userID=is_null ($userID) ? 'NULL' : $userID;
				$result["src_usersID"] = $userID;
				
				}else{
			    $userID=$row->userID;
				$userID=is_null ($userID) ? 'NULL' : $userID;	
			    $result["src_usersID"] .= "," . $userID;
			    
		      }  
			}

			

/*******************************CATEGORY_FORUM********************************************/			 

			$sql="SELECT c.catID  FROM categories1 c, rel_cat_forum r
			WHERE c.catID = r.catID
			AND r.forum_decID =$forum_decID ORDER BY c.catName";
			if($rows = $db->queryObjectArray($sql)){
			foreach($rows as $row){
				if(!$result["src_forumsType"]){
				$result["src_forumsType"] = $row->catID;
				 
				}else{
				$result["src_forumsType"] .= "," . $row->catID;
			   }	
			}
			 
		}

/*******************************TYPE_MANAGER***********************************************************/

			$sql="SELECT m.managerTypeID  FROM manager_type m, rel_managerType_forum r
			WHERE m.managerTypeID = r.managerTypeID
			AND r.forum_decID =$forum_decID ORDER BY m.managerTypeName";
			if($rows = $db->queryObjectArray($sql)){
			foreach($rows as $row){
				if(!$result["src_managersType"])
				$result["src_managersType"] = $row->managerTypeID;
				else
				$result["src_managersType"] .= "," . $row->managerTypeID;
			}
			 
   }	

/******************************************************************************************/			
			
			
			
		}
		return $result;
	}
/*******************************************************************************************/
	

/*******************************************************************************************/

	// read all data for a certain forum from database
	// and save it in an array; return this array
	function read_forum_data1($forum_decID) {

		global $db;
 
        $sql="select f.* ,m.managerName from forum_dec f ,managers m 
        WHERE f.managerID=m.managerID 
        AND forum_decID=$forum_decID  ";
		if($rows = $db->queryObjectArray($sql)){
		$rows[0]->forum_date=substr($rows[0]->forum_date,0,10);
		list($year_date,$month_date, $day_date) = explode('-',$rows[0]->forum_date);
		if (strlen($year_date>3))
		$rows[0]->forum_date="$day_date-$month_date-$year_date";	
//		$day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;
//		$month_date= is_null($day_date) ? 'NULL' : "'$month_date'" ;
		 
//		$day_date=substr($day_date, 0,4);
//		$day_date=substr($day_date,1,2);
//		if($month_date['1'] == '1' )
//		$month_date=substr($month_date,1,2);
//		else{
//			$month_date=substr($month_date,1,2);
			//$month_date=substr($month_date,1,1);
//		}
		if(is_array($rows) && sizeof($rows)==1) {
            $row1 = $rows[0];
            $result["forum_decision"] = $row1->forum_decID;
            $result["forum_decID"] = $row1->forum_decID;
            $result["parentForumID"] = $row1->parentForumID;
            $result["insert_forum"] = $row1->parentForumID;
            $result["insertID"] = $row1->parentForumID;
            $result["forum_decName"] = $row1->forum_decName;
            $result["forum_status"] = $row1->active;
            $result["forum_allowed"] = $row1->forum_allowed;
            //$result["forum_date"]  =substr(($row->forum_date) ,10,6);
            $result["forum_date"] = $row1->forum_date;
            $result['day_date'] = $day_date;
            $result['month_date'] = $month_date;
            $result['year_date'] = $year_date;


            $result["appoint_forum"] = $row1->appointID;
            $result["manager_forum"] = $row1->managerID;
            $result["managerName"] = $row1->managerName;

            $result["appoint_date"] = $row1->appoint_date;
            list($year_date, $month_date, $day_date) = explode('-', $result["appoint_date"]);
            if (strlen($year_date) > 3) {
                $result["appoint_date"] = "$day_date-$month_date-$year_date";
            }


            $result["manager_date"] = $row1->manager_date;
            list($year_date, $month_date, $day_date) = explode('-', $result["manager_date"]);
            if (strlen($year_date) > 3) {
                $result["manager_date"] = "$day_date-$month_date-$year_date";
            }


            $result["src_users"] = "";
            $result["src_usersID"] = "";
            $result["date_users"] = "";

            $result["src_managersType"] = "";
            $result["src_forumsType"] = "";
        }
/********************************USER_FORUM_NAME*******************************************/			

			$sql = "SELECT u.userID, u.full_name,r.HireDate FROM users u, rel_user_forum r " .
           " WHERE u.userID = r.userID " .
           " AND r.forum_decID = $forum_decID " . 
           " ORDER BY u.full_name ";
			if($rows = $db->queryObjectArray($sql))
			foreach($rows as $row){
				if(!$result["src_users"]){
				$name1=$row->full_name;
				$name=is_null ($name1) ? 'NULL' : "$name1";
				$result["src_users"] = $name;
				
				$date1=$row->HireDate;
				$date1=substr($row->HireDate,0,10);
				$date=is_null ($date1) ? 'NULL' : "'$date1'";
				$result["date_users"] = $date;
				}else{
			    $name1=$row->full_name;
				$name=is_null ($name1) ? 'NULL' : "$name1";	
			    $result["src_users"] .= "," . $name;
			    
			    $date1=$row->HireDate;
			    $date1=substr($row->HireDate,0,10);
				$date=is_null ($date1) ? 'NULL' : "'$date1'";
				$result["date_users"] .= "," . $date;
		      }  
			}
/********************************USER_FORUM_ID*******************************************/			

			$sql = "SELECT u.userID  FROM users u, rel_user_forum r " .
           " WHERE u.userID = r.userID " .
           " AND r.forum_decID = $forum_decID " . 
           " ORDER BY u.full_name ";
			if($rows = $db->queryObjectArray($sql))
			foreach($rows as $row){
				if(!$result["src_usersID"]){
				$userID=$row->userID;
				$userID=is_null ($userID) ? 'NULL' : $userID;
				$result["src_usersID"] = $userID;
				
				}else{
			    $userID=$row->userID;
				$userID=is_null ($userID) ? 'NULL' : $userID;	
			    $result["src_usersID"] .= "," . $userID;
			    
		      }  
			}

			

/*******************************CATEGORY_FORUM********************************************/			 

			$sql="SELECT c.catID  FROM categories1 c, rel_cat_forum r
			WHERE c.catID = r.catID
			AND r.forum_decID =$forum_decID ORDER BY c.catName";
			if($rows = $db->queryObjectArray($sql)){
			$i=0;	
			foreach($rows as $row){
				 
				$result["dest_forumsType"][$i] = $row->catID;
				 
				
               $i++;			
			}
		  	 
		}
/*******************************TYPE_MANAGER***********************************************************/

			$sql="SELECT m.managerTypeID  FROM manager_type m, rel_managerType_forum r
			WHERE m.managerTypeID = r.managerTypeID
			AND r.forum_decID =$forum_decID ORDER BY m.managerTypeName";
			if($rows = $db->queryObjectArray($sql)){
			 $i=0;	
			foreach($rows as $row){
				 
				$result["dest_managersType"][$i] = $row->managerTypeID;
				$i++;
			}
			 
   }	

/******************************************************************************************/			
			
			
			
		}
        $result = isset($result) ? $result : false;
		return $result;
	}
/*******************************************************************************************/
	
	// read all data for a certain forum from database
	// and save it in an array; return this array
	function read_forum_data2($forum_decID) {

		global $db;

        $sql="select * from forum_dec WHERE forum_decID=$forum_decID  ";
		$rows = $db->queryObjectArray($sql);
		$rows[0]->forum_date=substr($rows[0]->forum_date,0,10);
		list($year_date,$month_date, $day_date) = explode('-',$rows[0]->forum_date);
		if (strlen($year_date>3))
		$rows[0]->forum_date="$day_date-$month_date-$year_date";	

		if(is_array($rows) && sizeof($rows)==1) {
			$row1 = $rows[0];
			$result["forum_decision"]= $row1->forum_decID;
			$result["forum_decID"]=    $row1->forum_decID;
			$result["parentForumID"]=  $row1->parentForumID;
			$result["forum_decName"]=  $row1->forum_decName;
			$result["forum_status"] =  $row1->active;
			$result["managerType"]=  $row1->managerTypeID;
			//$result["forum_date"]  =substr(($row->forum_date) ,10,6);
			$result["forum_date"]=     $row1->forum_date;
			$result['day_date']=       $day_date;
			$result['month_date']=     $month_date;
			$result['year_date']=      $year_date;
			
			
			$result["appointID"]   =  $row1->appointID;
			$result["managerID"]   =  $row1->managerID;
			
			$result["appoint_date"]   =  $row1->appoint_date;
			list($year_date,$month_date, $day_date) = explode('-',$result["appoint_date"]);
            if(strlen($year_date)>3 ){
            $result["appoint_date"]="$day_date-$month_date-$year_date";
            }	
			
            
            $result["manager_date"]   =  $row1->manager_date;
			list($year_date,$month_date, $day_date) = explode('-',$result["manager_date"]);
            if(strlen($year_date)>3 ){
            $result["manager_date"]="$day_date-$month_date-$year_date";	
             }
			
		    $result['multi_year']=$_SESSION['multi_year'] ;
			$result['multi_month'] = $_SESSION['multi_month'];
			$result['multi_day']= $_SESSION['multi_day'];
			

			
			//$result["user_forum"]   = "";
			 $result["usr_details"]   = "";
			$result["date_users"]   = "";
			$result["category"]="";
			//$result["managerType"]="";
			$result["add_user"]="";
			$result["del_user"]="";
   
/********************************USER_FORUM*******************************************/		
			$sql = "SELECT u.full_name,u.userID,r.HireDate FROM users u, rel_user_forum r  
             WHERE u.userID = r.userID    
             AND r.forum_decID = $forum_decID 
			 ORDER BY u.full_name";
			$rows = $db->queryObjectArray($sql);
			if($rows){
			  $result["usr_details"]=$rows;	
			foreach($rows as $row){
				if(!$result["usr_frm"])
				$result["usr_frm"] = $row->full_name;
				else
				$result["usr_frm"] .= ";" . $row->full_name;

			}
	    }
	    
	    
			

/*******************************CATEGORY_FORUM********************************************/			 

			$sql="SELECT c.catID  FROM categories1 c, rel_cat_forum r
			WHERE c.catID = r.catID
			AND r.forum_decID =$forum_decID ORDER BY c.catName";
			if($rows = $db->queryObjectArray($sql))
			foreach($rows as $row){
				if(!$result["category"])
				$result["category"] = $row->catID;
				else
				$result["category"] .= ";" . $row->catID;
			}
/*******************************CATEGORY_MANAGER***********************************************************/

			
			return $result;
		}
	}
/*******************************************************************************************/
 
		// read all data for a certain forum from database
	// read all data for a certain forum from database
	// and save it in an array; return this array
	function read_forum_data3($forum_decID) {

		global $db;
		

			$sql = "SELECT u.userID FROM users u, rel_user_forum r " .
           " WHERE u.userID = r.userID " .
           " AND r.forum_decID = $forum_decID " .
           " ORDER BY u.full_name ";
			if($rows = $db->queryObjectArray($sql))
			foreach($rows as $row){
				if(!$result["dest_users"])
				$result["dest_users"] = $row->userID;
				else
				$result["dest_users"] .= ";" . $row->userID;

			}
				
			
			return $result;
		 
	}
/***************************************************************************/

function validate_data_ajx(&$formdata="",&$dateIDs="",$frm_date="",$insertID="",$formselect="") {

global $db;
 $result = TRUE; 
$forum_decID=$formdata['forum_decID'];
$message = array();
$response['message'] = array();  
 
$frm =new forum_dec();
 

$j=0;
$i=0;

 $member_date=$frm->build_date($formdata);
if(!array_item($member_date,'today') ){
if(is_array($member_date)   
   && array_item($formdata,'member_date0')
   && array_item($formdata,'dest_users')
   &&  count($formdata['dest_users'])>0 ){
foreach($member_date['full_date']  as $date){
	$date_member="member_date$i";  
	IF(!$frm->check_date($formdata[$date_member])){
	   $member_date['full_date'][$i]=$formdata['today'];
	   	$formdata[$date_member]=$formdata['today'];
	   	}
	   	if(!$frm->check_date( $dateIDs[$i]) ){
	   	 $dateIDs[$i]	=$formdata['today'];	
	}
	$i++;
  }
}
}

/**********************************************************************************************/
//$newforumName=$formdata['newforum']?$formdata['newforum']:$formdata['forum_decName'];
//$newforumName=$db->sql_string($newforumName);
//    
//       $sql = "SELECT COUNT(*) FROM forum_dec " .
//         " WHERE parentForumID=$insertID " .
//         "  AND forum_decName=$newforumName";
//
// try {
//			 
// 	 if($db->querySingleItem($sql)>0) {
//	
//          $result = FALSE;  
//			throw new Exception("כבר קיים פורום בשם זה!");
//               	      
//		 }
//  	
//		} catch(Exception $e){
// 			$response['type'] = 'error';
//	         $message[]=$e->getMessage();
//	          $response[]['message']  =$message;
//	    }	    
         






/***************************************************************************************************/

list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$formdata['forum_date']);
   if( array_item($formdata, 'forum_date') 
   &&  !is_numeric($day_date_forum )
   && !is_numeric($month_date_forum) 
   && !is_numeric($year_date_forum)
 || ( !$frm->check_date($formdata['forum_date']))  ){ 
          $formdata['forum_date']="";        
        }       


 
 
     try {
			 
		if(  (trim($formdata["forum_date"])=="" || trim($formdata["forum_date"])=='none') ) {
	            $result = FALSE;   
			    throw new Exception("חייב לציין מתיי הוקם הפורום ");
	       }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
 
/***********************************************************************************************************/	
list( $day_date_appoint,$month_date_appoint,$year_date_appoint) = explode('-',$formdata['appoint_date1']);
   if( array_item($formdata, 'appoint_date1') 
   &&  !is_numeric($day_date_appoint )
   && !is_numeric($month_date_appoint) 
   && !is_numeric($year_date_appoint)
 || ( !$frm->check_date($formdata['appoint_date1']))  ){ 
          $formdata['appoint_date1']="";        
        }       


	
	
try {
			 
		if(  (trim($formdata["appoint_date1"])=="" || trim($formdata["appoint_date1"])=='none') ) {
	
             $result = FALSE;
			throw new Exception("חייב לציין מתיי התמנה הממנה ");
                	      
		 }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$formdata['manager_date']);
   if( array_item($formdata, 'manager_date') 
   &&  !is_numeric($day_date_manager )
   && !is_numeric($month_date_manager) 
   && !is_numeric($year_date_manager)
 || ( !$frm->check_date($formdata['manager_date']))  ){ 
          $formdata['manager_date']="";        
        }       

        
    try {
			 
    	if(  (trim($formdata["manager_date"])=="" || trim($formdata["manager_date"])=='none') ) {
	
          $result = FALSE;  
			throw new Exception("חייב לציין מתיי התמנה המנהל ");
               	      
		 }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
/********************************************קישורים**************************************************/ 
try{	    
if($formdata['dest_forumsType'] &&  is_array($formdata['dest_forumsType'])
   && $formdata['insert_forumType'] &&  is_array($formdata['insert_forumType']) 
   && $formdata['insert_forumType']!='none' && !(in_array (11,$formdata['insert_forumType'])  )  
   &&  !($formdata["new_forumType"]) ){
  
   foreach($formdata['dest_forumsType'] as $chk_parent){
   	if(in_array($chk_parent,$formdata['insert_forumType'])){
   		  $result = FALSE;  
			throw new Exception("אין לקשר לאותו סוג פורום!");
   		
   	}
   	
   }	
	
	
}	    
	    
}catch(Exception $e){    
         $response['type'] = 'error';
         $message[]=$e->getMessage();
         $response[]['message']  =$message;
	
}











try{	    
if($formdata['dest_managersType'] &&  is_array($formdata['dest_managersType'])
   && $formdata['insert_managerType'] &&  is_array($formdata['insert_managerType']) 
   && $formdata['insert_managerType']!='none' && !(in_array (11,$formdata['insert_managerType'])  )  ){
  
   foreach($formdata['dest_managersType'] as $chk_parentMgr){
   	if(in_array($chk_parentMgr,$formdata['insert_managerType'])){
   		  $result = FALSE;  
			throw new Exception("אין לקשר לאותו סוג מנהל!");
   		
   	}
   	
   }	
	
	
}	    
	    
}catch(Exception $e){    
         $response['type'] = 'error';
         $message[]=$e->getMessage();
         $response[]['message']  =$message;
	
}



/**************************************************************************************************************/ 
try {
			 
	if(  (trim($formdata["forum_decision"])=="" || trim($formdata["forum_decision"])=='none') 
	   && trim($formdata["newforum"])=="") {
          
	   	     $result = FALSE;  
			throw new Exception("חייב לשייך לפורום ");
              	      
		 }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	    
	 try {	    
         if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
             $result = FALSE; 
			throw new Exception("פורומים בעין השופט רשומת אב אין לשייך אותה ");
               	      
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	    
  

	
	
	
if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   &&  $formdata["forum_decision"] && is_numeric($formdata["forum_decision"]) ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
              if($db->querySingleItem($sql)>0) {
              	
              	
        try {	    
         if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
            $result = FALSE;
			throw new Exception("כבר קיימ פורום בשם הזה ");
                 	      
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	          	 
              }elseif(array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
              	unset($formdata['forum_decID']); 
              }	
}	


if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   && (!$formdata["forum_decision"] || $formdata["forum_decision"]==null)  ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
        try {	    
        	 if($db->querySingleItem($sql)>0) {
          $result = FALSE;  
			throw new Exception("כבר קיימ פורום בשם הזה ");
               	      
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	 
}	



if ($formdata['newforum'] && $formdata['newforum']!=null
    && array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
          unset($formdata['forum_decID']);      	
    }
/********************************FORUMTYPE*****************************************************/	
if(!($formdata['dynamic_9'])==1){	
	try {	    
        	 if((!(is_array($formdata["dest_forumsType"])) && !($formdata["dest_forumsType"])) 
	         && trim($formdata["new_forumType"])==""){
	   	       $field=dest_forumsType;
	   	       $result = FALSE;  
			  throw new Exception('חייב לשייך לקטגוריה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
   
}

else{
try {	    
        	 if( trim($formdata["dest_forumsType"]=='none') 
	         && trim($formdata["new_forumType"])==""){
	   	       $field=dest_forumsType;
	   	       $result = FALSE;  
			  throw new Exception('חייב לשייך לקטגוריה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
}  
   
   
	
	    
if(!($formdata['dynamic_9'])==1){	    
	try {	  
	 
        	 if($formdata['dest_forumsType'] && in_array(11,$formdata['dest_forumsType']) && trim($formdata["new_forumType"])==""){ 
 
	   	       $field=dest_forumsType;
	   	       $result = FALSE;  
			  throw new Exception('קטגוריות הפורומים רשומת אב אין לשייך אותה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	        
	
}else{

	try {	  
	 
        	 if($formdata['dest_forumsType'] && (array_item($formdata,'dest_forumsType')==11) && trim($formdata["new_forumType"])==""){ 
 
	   	       $field=dest_forumsType;
	   	       $result = FALSE;  
			  throw new Exception('קטגוריות הפורומים רשומת אב אין לשייך אותה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	        
	
	
	
	
	
}	 

	
	    
	
	    
	    
	    
	    
  if( trim($formdata["new_forumType"]!=null) && trim($formdata["new_forumType"]!=null) 
     &&  $formdata["dest_forumsType"]!="none" && is_array($formdata["dest_forumsType"]) ){	
	  $name=$db->sql_string($formdata["new_forumType"]);
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              
	   
	   try {	    
	   	 if($db->querySingleItem($sql)>0) {
 	   	       $result = FALSE;  
			  throw new Exception('כבר קיימ סוג פורומים בשם הזה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	      
	   
      }	
	
	
	
    if( trim($formdata["new_forumType"]!="none") && trim($formdata["new_forumType"]!=null) 
       &&  (!$formdata["dest_forumsType"] || $formdata["dest_forumsType"]==null || !is_array($formdata["dest_forumsType"]) )  ){
	
	$name=$db->sql_string($formdata["new_forumType"]);
	 $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
	 
	 
              if($db->querySingleItem($sql)>0) {
              	try {	    
	   	 if($db->querySingleItem($sql)>0) {
 	   	       $result = FALSE;  
			  throw new Exception('כבר קיימ סוג פורומים בשם הזה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	 
              
      }	
}
/***********************************************************************************/
if( trim($formdata["new_forumType"]!="none") && trim($formdata["new_forumType"]!=null) 
       &&  is_numeric($formdata["new_forumType"])    ){
	
	 
              	try {	    
	   	 
 	   	       $result = FALSE;  
			  throw new Exception('סוג פורומים לא חוקי:'); 
		 
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	 
              
      }	
 
/*************************************************************************************/	
/***************************************MANAGERS_TYPE*************************************************/	

try {	    
	if(  (!is_array($formdata["dest_managersType"]) && !($formdata["dest_managersType"]) ) 
	   && trim($formdata["new_managerType"])=="") {
	   	$result = FALSE;  
			  throw new Exception("חייב לשייך סוגי מנהלים!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }

try {	
if(   ($formdata["dest_managersType"]=='none')  
	   && trim($formdata["new_managerType"])=="") {
	   	$result = FALSE;  
			  throw new Exception("חייב לשייך סוגי מנהלים!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	
	 
if(!($formdata['dynamic_9'])==1){	 	
try {	    
	if( $formdata['dest_managersType'] && (in_array (11,$formdata["dest_managersType"])) && trim($formdata["new_managerType"])==""){ 
	    
	   	$result = FALSE;  
			  throw new Exception("סוגי מנהלים בעין השופט רשומת אב אין לשייך אותה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
}else{
try {	    
	if( $formdata['dest_managersType'] && (array_item($formdata,"dest_managersType")==11) && trim($formdata["new_managerType"])==""){ 
	    
	   	$result = FALSE;  
			  throw new Exception("סוגי מנהלים בעין השופט רשומת אב אין לשייך אותה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	
}	 


	    
	    
if( trim($formdata["new_managerType"]) && trim($formdata["new_managerType"]!=null) 
   && $formdata["dest_managersType"] && $formdata["dest_managersType"]!=null && is_array($formdata["dest_managersType"])  ){
	
	$name=$db->sql_string($formdata["new_managerType"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
	 
   try {	    
   	if($db->querySingleItem($sql)>0) { 
	    
	   	$result = FALSE;  
			  throw new Exception("כבר קיימ סוג מנהלים בשם הזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
             
}


if( trim($formdata["new_managerType"]) && trim($formdata["new_managerType"]!=null) 
   && (!$formdata["dest_managersType"] || !(is_array($formdata["dest_managersType"])) )  ){
	
	$name=$db->sql_string($formdata["new_managerType"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
   try {	    
   	if($db->querySingleItem($sql)>0) { 
	    
	   	$result = FALSE;  
			  throw new Exception("כבר קיימ סוג מנהלים בשם הזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
              
}	

/**************************************APPOINT_FORUM***************************************************/
 

	try {	    
		if(  (trim($formdata["appoint_forum"])=="" || trim($formdata["appoint_forum"]=='none')) 
	   && trim($formdata["new_appoint"])=="") {   
	   	$result = FALSE;  
			  throw new Exception('חייב לשייך ממנה פורום'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	 
	 
	
	    

	    try {	    
		if(  trim($formdata["appoint_forum"])=="11" && trim($formdata["new_appoint"])==""){  
	   
	   	$result = FALSE;  
			  throw new Exception('ממנים בעין השופט רשומת אב אין לשייך אותה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	    
	    
	
	 
		
	if( $formdata["appoint_forum"] && trim($formdata["new_appoint"]!=null)  ){
		
    $id=$formdata['new_appoint'];
    if($id!=null){  
	$sql="SELECT appointName  from appoint_forum where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	
	 try {	    
	 	if($rows[0]->appointName!=''){ 
	   
	   	$result = FALSE;  
			  throw new Exception("כבר קיים ממנה אם שם כזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	  
	}
}





//if( trim($formdata["new_appoint"] ) && trim ($formdata["new_appoint"]!=null) 
//   && (!$formdata["appoint_forum"] || $formdata["appoint_forum"]!=null)   ){
//		
//    $id=$formdata['new_appoint'];
//    if($id!=null){  
//	$sql="SELECT appointName  from appoint_forum where userID=$id";
//	if($rows=$db->queryObjectArray($sql))
//	try {	    
//	 	if($rows[0]->appointName!=''){ 
//	   
//	   	$result = FALSE;  
//			  throw new Exception("כבר קיים ממנה אם שם כזה!");
//					     
//		 }
//  	
//		}catch(Exception $e){
// 			$response['type'] = 'error';
//	         $message[]=$e->getMessage();
//	          $response[]['message']  =$message;
//	    }	
//	  
//	}
//}	
/****************************************************************************************/	
try {	    
	if(  (trim($formdata["manager_forum"])=="" || trim($formdata["manager_forum"]=='none')) 
	   && trim($formdata["new_manager"])=="") {
	   
	   	$result = FALSE;  
			  throw new Exception("חייב לשייך מרכז פורום!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	


	 
	
	
try {	    
	if(  trim($formdata["manager_forum"])=="11" && trim($formdata["new_manager"])==""){ 
	   
	   	$result = FALSE;  
			  throw new Exception("מנהלים בעין השופט רשומת אב אין לשייך אותה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	    
	    
	    
	 
	
if( $formdata["manager_forum"]  && trim($formdata["new_manager"]!=null) ){
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
    try {	    
    	if($rows[0]->managerName!=''){   
	   	$result = FALSE;  
			  throw new Exception("כבר קיים מנהל אם שם כזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
 
	}
}	


if( trim($formdata["new_manager"] ) && trim ($formdata["new_manager"]!=null) 
   && (!$formdata["manager_forum"] || $formdata["manager_forum"]==null)   ){
		
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
    try {	    
    	if($rows[0]->managerName!=''){   
	   	$result = FALSE;  
			  throw new Exception("כבר קיים מנהל אם שם כזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	 
	}
}	

/*******************************************************************************************/
 
 if($formdata['src_users']){
$src=explode(',',$formdata['src_users']);	
foreach($src as $row){
	
	 
		
	 try {	    
	 	if($row=='none'){ 
	    
	   	$result = FALSE;  
			  throw new Exception("בחר אופציה היא רשומת אב ולא שם משתמש!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	 
	
  }
}	


/********************************************************************************************/
if($formdata['dest_users']){
   foreach($formdata['dest_users'] as $key=>$val){ 
         	 
     if(  !(array_item($formdata['dest_users'] ,$formdata['deluser_Forum'])) 
     &&  $formdata['deluser_Forum']!='none' && $formdata['deluser_Forum']!=null){
	     $flag=true;
     } else 
	     $flag=false;  
    		
  }	
try {	    
	if($flag){ 
	    
	   	$result = FALSE;  
			  throw new Exception("מבקש למחוק חבר לא קיים!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
      
}	



try {	    
	if($flag){ 
	    
	   	$result = FALSE;  
			  throw new Exception("מבקש למחוק חבר לא קיים!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }

/********************************************************************************************/
//if(  !($formdata['src_users']) && !($formdata['dest_users'])
//      && ($formdata['src_users'][0]!='none')  && ($formdata['dest_users'][0]!='none') 
//      &&   $formdata['deluser_Forum']=='none' &&  $formdata['adduser_Forum']=='none' ){
//      	 show_error_msg("בחר אופציה היא רשומת אב ולא שם משתמש");
//       $result = FALSE;
//      }   	
      
/*********************************************************************************************/
  
//	if(!empty($formdata['forum_status']) && ((!is_numeric($formdata['forum_status'])) || $formdata['forum_status']>1 || $formdata['forum_status']<0)) {
//    show_error_msg("סטטוס החלטה חייבת להיות   1 או 0  (או ריק).");
//    $result = FALSE; 
//	}	

try {	    
		if(   trim($formdata["forum_status"])=="" || trim($formdata["forum_status"]=='none') ) 
	  {   
	   	$result = FALSE;  
			  throw new Exception('חייב להזין סטטוס פורום'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	 
	    
//try {	    
//	if(  (!empty($formdata['forum_status'])) && ($formdata['forum_status']>1 || $formdata['forum_status']<0   ||  ( trim($formdata["forum_status"])=="" )   )) {    
//	   	$result = FALSE;  
//			  throw new Exception("סטטוס פורום חייבת להיות 1 או 0!");
//					     
//		 }
//  	
//		}catch(Exception $e){
// 			$response['type'] = 'error';
//	         $message[]=$e->getMessage();
//	          $response[]['message']  =$message;
//	    }
	    
	    
	
/**************************************************************************************/
 $dst_usr=array();	
 $i=0;
 if(array_item($formdata,'forum_decID')   ){
$forumID=$formdata['forum_decID'];
 $sql="select * from rel_user_forum where forum_decID=$forumID";
 if($rows=$db->queryObjectArray($sql)){
 	foreach($rows as $row){
 		list($day_date_rel_date,$month_date_rel_date,$year_date_rel_date ) = explode('-',$row->HireDate);
     	        if (strlen($year_date_rel_date) < 3){
		           $row->HireDate="$year_date_rel_date-$month_date_rel_date-$day_date_rel_date";	
	    	    }else{
			       $row->HireDate="$day_date_rel_date-$month_date_rel_date-$year_date_rel_date";
	    	    }   
 		$forumUser_date[$row->HireDate] = $row->userID;
 		$forumUser_id[$row->userID] = $row->HireDate;
 	}
 	
 }
 
 }
 
 //for the name message
 if( (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
     // &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
    //  && (count($dateIDs)==count($formdata['dest_users'])  )
      && array_item($formdata,'member_date0')) {
	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}
	
 	
	 

$i=0;	
    foreach($dateIDs as $daycomp) {
    	try {	    
    		if(!$frm-> DateSort($daycomp,$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
    	    	
//    	if(!$frm-> DateSort($daycomp,$frm_date)){  	
//		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
//		         $result = false;
//		   	    }
		   	    $i++;
		      //} 
    }
      

      
      
      
      
      
 }elseif(is_array($dateIDs)   && (count($formdata['dest_users'])>0  )
 &&(! array_item($formdata,'member') && !array_item($formdata,'member_date0') ) ) {
$i=0;
 	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}

	
$i=0;
	foreach($dateIDs as $daycomp) {
    	   	    
	try {	    
    		if(!$frm-> DateSort($daycomp,$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
		
		
//		if(!$frm-> DateSort($daycomp,$frm_date)){  	
//		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
//		         $result = false;
//		   	    }
		   	    $i++;
	 
    }
 	
 
  
 
 
}elseif(  (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
             &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
             && array_item($formdata,'member_date0')
		     && array_item($formdata,'dest_users')
		     &&  count($formdata['dest_users'])>0
             ){
  	
  	//for($i=0; $i<count($formdata['dest_users']); $i++){
  	$i=0;	
    foreach($formdata['dest_users'] as $key=>$val){
  			
    	$dest_usr[$i]=$key;
    	
    	
  		$i++;	
  		}
  		$rel_dest=array_merge($formdata['src_usersID'],$dest_usr);
		 $rel_dest=array_unique($rel_dest);
  		
  		
  		
  	//}   
             	
             	
     $i=0;	
    foreach($dateIDs as $daycomp) {
     
    	
    try {	    
    		if(!$frm-> DateSort($daycomp,$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
    	
//		   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
//		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
//		         $result = false;
//		   	    }
		   	    $i++;
		      }          	
            	
  }		       
   	       
/***********************************************************************************************************/
if( array_item($formdata,'appoint_date1') && $frm->check_date($formdata['appoint_date1'])  ){
	
try {	    
	 if(!$frm-> DateSort($formdata['appoint_date1'],$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך ממנה  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	
  
}  

/****************************************************************************************/
if( array_item($formdata,'appoint_date1') && $frm->check_date($formdata['appoint_date1'])  
   &&   array_item($formselect,'appoint_date') && $frm->check_date($formselect['appoint_date'])  ){

/****************************************************************************************/
$start_date=$formselect['appoint_date'];
$end_date=$formdata['appoint_date1'];
/***************************************************************************/   	
   	
   	
try {	    
	    		if(!$frm->  DateSort($end_date,$start_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך ממנה חדש לפניי תאריך ממנה ישן !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	  
	  
	  
	

}
/*************************************************************************************/	
if( array_item($formdata,'manager_date') && $frm->check_date($formdata['manager_date'])  ){
	    

	   try {	    
	    		if(!$frm-> DateSort($formdata['manager_date'],$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך מנהל לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	    	
		         
} 	
 
/****************************************************************************************/
if( array_item($formdata,'manager_date') && $frm->check_date($formdata['manager_date'])  
   &&   array_item($formselect,'manager_date') && $frm->check_date($formselect['manager_date'])  ){

/****************************************************************************************/
$start_date=$formselect['manager_date'];
$end_date=$formdata['manager_date'];
/***************************************************************************/   	
   	
   	
try {	    
	    		if(!$frm-> DateSort($end_date,$start_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך מנהל חדש לפניי תאריך מנהל ישן !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	  
	  
	  
	

}


/***************************** now we are ready to turn this hash into JSON********************************************************/
if(!$result){
unset($response);
	$i=0;
	$j=0;
	foreach($message as $row)
	{ 
	  $key="messageError_$i";	
	 $message_name[$key]=$row ;
	 
	 if(!($j==(count($message)-1 ) && !$j=='0'   ) )
	  $response[$j]['type'] = 'error';
	 else{
	   $response[$j-1]['type'] = 'error';	
	 }
	  
 
	  $i++;
	  $j++;
	}
 	 $response['message'][0] = $message_name;
  
   $message_name['forum_decID']=$forum_decID;
 print json_encode($message_name);	
 	
 	
 	
		exit; 	
}
/*************************************************************************************/

 
  return   $result;
 }
 
/***************************************************************************/

function validate_data_ajx1(&$formdata="",&$dateIDs="",$frm_date="") {

global $db;
 $result = TRUE; 

$message = array();
$response['message'] = array();  
 
$frm =new forum_dec();
 

$j=0;
$i=0;

 $member_date=$frm->build_date($formdata);

if(is_array($member_date)   
   && array_item($formdata,'member_date0')
   && array_item($formdata,'dest_users')
   &&  count($formdata['dest_users'])>0 ){
foreach($member_date['full_date']  as $date){
	$date_member="member_date$i";  
	IF(!$frm->check_date($formdata[$date_member])){
	   $member_date['full_date'][$i]=$formdata['today'];
	   	$formdata[$date_member]=$formdata['today'];
	   	}
	   	if(!$frm->check_date( $dateIDs[$i]) ){
	   	 $dateIDs[$i]	=$formdata['today'];	
	}
	$i++;
  }
}




list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$formdata['forum_date']);
   if( array_item($formdata, 'forum_date') 
   &&  !is_numeric($day_date_forum )
   && !is_numeric($month_date_forum) 
   && !is_numeric($year_date_forum)
 || ( !$frm->check_date($formdata['forum_date']))  ){ 
          $formdata['forum_date']="";        
        }       


 
 
     try {
			 
		if(  (trim($formdata["forum_date"])=="" || trim($formdata["forum_date"])=='none') ) {
	            $result = FALSE;   
			    throw new Exception("חייב לציין מתיי הוקם הפורום ");
	       }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
 
/***********************************************************************************************************/	
list( $day_date_appoint,$month_date_appoint,$year_date_appoint) = explode('-',$formdata['appoint_date1']);
   if( array_item($formdata, 'appoint_date1') 
   &&  !is_numeric($day_date_appoint )
   && !is_numeric($month_date_appoint) 
   && !is_numeric($year_date_appoint)
 || ( !$frm->check_date($formdata['appoint_date1']))  ){ 
          $formdata['appoint_date1']="";        
        }       


	
	
try {
			 
		if(  (trim($formdata["appoint_date1"])=="" || trim($formdata["appoint_date1"])=='none') ) {
	
          
			throw new Exception("חייב לציין מתיי התמנה הממנה ");
              $result = FALSE;   	      
		 }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$formdata['manager_date']);
   if( array_item($formdata, 'manager_date') 
   &&  !is_numeric($day_date_manager )
   && !is_numeric($month_date_manager) 
   && !is_numeric($year_date_manager)
 || ( !$frm->check_date($formdata['manager_date']))  ){ 
          $formdata['manager_date']="";        
        }       

        
    try {
			 
    	if(  (trim($formdata["manager_date"])=="" || trim($formdata["manager_date"])=='none') ) {
	
          
			throw new Exception("חייב לציין מתיי התמנה המנהל ");
              $result = FALSE;   	      
		 }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
   
/**************************************************************************************************************/ 
try {
			 
	if(  (trim($formdata["forum_decision"])=="" || trim($formdata["forum_decision"])=='none') 
	   && trim($formdata["newforum"])=="") {
          
			throw new Exception("חייב לשייך לפורום ");
              $result = FALSE;   	      
		 }
  	
		} catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	    
	 try {	    
         if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
          
			throw new Exception("פורומים בעין השופט רשומת אב אין לשייך אותה ");
              $result = FALSE;   	      
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	    
  

	
	
	
if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   &&  $formdata["forum_decision"] && is_numeric($formdata["forum_decision"]) ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
              if($db->querySingleItem($sql)>0) {
              	
              	
        try {	    
         if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
          
			throw new Exception("כבר קיימ פורום בשם הזה ");
              $result = FALSE;   	      
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	          	 
              }elseif(array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
              	unset($formdata['forum_decID']); 
              }	
}	


if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   && (!$formdata["forum_decision"] || $formdata["forum_decision"]==null)  ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
        try {	    
        	 if($db->querySingleItem($sql)>0) {
          $result = FALSE;  
			throw new Exception("כבר קיימ פורום בשם הזה ");
               	      
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
	 
}	



if ($formdata['newforum'] && $formdata['newforum']!=null
    && array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
          unset($formdata['forum_decID']);      	
    }
/********************************FORUMTYPE*****************************************************/	
	
	try {	    
        	 if(  (!(is_array($formdata["dest_forumsType"])) || trim($formdata["dest_forumsType"]=='none')) 
	         && trim($formdata["new_category"])==""){
	   	       $field=dest_forumsType;
	   	       $result = FALSE;  
			  throw new Exception('חייב לשייך לקטגוריה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	    
   
   
   
   
	
	    
	    
	try {	  
	 
        	 if( in_array(11,$formdata['dest_forumsType']) && trim($formdata["new_category"])==""){ 
 
	   	       $field=dest_forumsType;
	   	       $result = FALSE;  
			  throw new Exception('קטגוריות הפורומים רשומת אב אין לשייך אותה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	        
	
	 

	
	    
	try {	    
        	 if( in_array(11,$formdata['dest_forumsType']) && trim($formdata["new_category"])==""){ 
 	   	       $result = FALSE;  
			  throw new Exception('קטגוריות הפורומים רשומת אב אין לשייך אותה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	      
	    
	    
	    
	    
  if( trim($formdata["new_category"]!=null) && trim($formdata["new_category"]!=null) 
     &&  $formdata["dest_forumsType"]!="none" && is_array($formdata["dest_forumsType"]) ){	
	  $name=$db->sql_string($formdata["new_category"]);
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              
	   
	   try {	    
	   	 if($db->querySingleItem($sql)>0) {
 	   	       $result = FALSE;  
			  throw new Exception('כבר קיימ סוג פורומים בשם הזה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	      
	   
      }	
	
	
	
    if( trim($formdata["new_category"]!="none") && trim($formdata["new_category"]!=null) 
       &&  (!$formdata["dest_forumsType"] || $formdata["dest_forumsType"]==null || !is_array($formdata["dest_forumsType"]) )  ){
	
	$name=$db->sql_string($formdata["new_category"]);
	 $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
	 
	 
              if($db->querySingleItem($sql)>0) {
              	try {	    
	   	 if($db->querySingleItem($sql)>0) {
 	   	       $result = FALSE;  
			  throw new Exception('כבר קיימ סוג פורומים בשם הזה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	 
              
      }	
}


/*************************************************************************************/	
/***************************************MANAGERS_TYPE*************************************************/	
try {	    
	if(  (!is_array($formdata["dest_managersType"]) ||  ($formdata["dest_managersType"]=='none') ) 
	   && trim($formdata["new_type"])=="") {
	   	$result = FALSE;  
			  throw new Exception("חייב לשייך סוגי מנהלים!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	 
	
try {	    
	if(  in_array(11,$formdata["dest_managersType"]) && trim($formdata["new_type"])==""){ 
	    
	   	$result = FALSE;  
			  throw new Exception("סוגי מנהלים בעין השופט רשומת אב אין לשייך אותה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	 


	    
	    
if( trim($formdata["new_type"]) && trim($formdata["new_type"]!=null) 
   && $formdata["dest_managersType"] && $formdata["dest_managersType"]!=null && is_array($formdata["dest_managersType"])  ){
	
	$name=$db->sql_string($formdata["new_type"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
	 
   try {	    
   	if($db->querySingleItem($sql)>0) { 
	    
	   	$result = FALSE;  
			  throw new Exception("כבר קיימ סוג מנהלים בשם הזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
             
}


if( trim($formdata["new_type"]) && trim($formdata["new_type"]!=null) 
   && (!$formdata["dest_managersType"] || !(is_array($formdata["dest_managersType"])) )  ){
	
	$name=$db->sql_string($formdata["new_type"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
   try {	    
   	if($db->querySingleItem($sql)>0) { 
	    
	   	$result = FALSE;  
			  throw new Exception("כבר קיימ סוג מנהלים בשם הזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
              
}	

/*****************************************************************************************/
 

/*************************************************************************************/	
	try {	    
		if(  (trim($formdata["appoint_forum"])=="" || trim($formdata["appoint_forum"]=='none')) 
	   && trim($formdata["new_appoint"])=="") {   
	   	$result = FALSE;  
			  throw new Exception('חייב לשייך ממנה פורום'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	 
	 
	
	    

	    try {	    
		if(  trim($formdata["appoint_forum"])=="11" && trim($formdata["new_appoint"])==""){  
	   
	   	$result = FALSE;  
			  throw new Exception('ממנים בעין השופט רשומת אב אין לשייך אותה'); 
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	    
	    
	
	 
		
	if( $formdata["appoint_forum"] && trim($formdata["new_appoint"]!=null)  ){
		
    $id=$formdata['new_appoint'];
    if($id!=null){  
	$sql="SELECT appointName  from appoint_forum where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	
	 try {	    
	 	if($rows[0]->appointName!=''){ 
	   
	   	$result = FALSE;  
			  throw new Exception("כבר קיים ממנה אם שם כזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	  
	}
}

if( trim($formdata["new_appoint"] ) && trim ($formdata["new_appoint"]!=null) 
   && (!$formdata["appoint_forum"] || $formdata["appoint_forum"]!=null)   ){
		
    $id=$formdata['new_appoint'];
    if($id!=null){  
	$sql="SELECT appointName  from appoint_forum where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	try {	    
	 	if($rows[0]->appointName!=''){ 
	   
	   	$result = FALSE;  
			  throw new Exception("כבר קיים ממנה אם שם כזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	  
	}
}	
/****************************************************************************************/	
try {	    
	if(  (trim($formdata["manager_forum"])=="" || trim($formdata["manager_forum"]=='none')) 
	   && trim($formdata["new_manager"])=="") {
	   
	   	$result = FALSE;  
			  throw new Exception("חייב לשייך מרכז פורום!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	


	 
	
	
try {	    
	if(  trim($formdata["manager_forum"])=="11" && trim($formdata["new_manager"])==""){ 
	   
	   	$result = FALSE;  
			  throw new Exception("מנהלים בעין השופט רשומת אב אין לשייך אותה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }	
	    
	    
	    
	 
	
if( $formdata["manager_forum"]  && trim($formdata["new_manager"]!=null) ){
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
    try {	    
    	if($rows[0]->managerName!=''){   
	   	$result = FALSE;  
			  throw new Exception("כבר קיים מנהל אם שם כזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
 
	}
}	


if( trim($formdata["new_manager"] ) && trim ($formdata["new_manager"]!=null) 
   && (!$formdata["manager_forum"] || $formdata["manager_forum"]==null)   ){
		
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
    try {	    
    	if($rows[0]->managerName!=''){   
	   	$result = FALSE;  
			  throw new Exception("כבר קיים מנהל אם שם כזה!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	 
	}
}	

/****************************************************************************************/	
/*******************************************************************************************/
 
 if($formdata['src_users']){
$src=explode(',',$formdata['src_users']);	
foreach($src as $row){
	
	 
		
	 try {	    
	 	if($row=='none'){ 
	    
	   	$result = FALSE;  
			  throw new Exception("בחר אופציה היא רשומת אב ולא שם משתמש!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	 
	
  }
}	


/********************************************************************************************/
if($formdata['dest_users']){
   foreach($formdata['dest_users'] as $key=>$val){ 
         	 
     if(  !(array_item($formdata['dest_users'] ,$formdata['deluser_Forum'])) 
     &&  $formdata['deluser_Forum']!='none' && $formdata['deluser_Forum']!=null){
	     $flag=true;
     } else 
	     $flag=false;  
    		
  }	
try {	    
	if($flag){ 
	    
	   	$result = FALSE;  
			  throw new Exception("מבקש למחוק חבר לא קיים!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
      
}	



try {	    
	if($flag){ 
	    
	   	$result = FALSE;  
			  throw new Exception("מבקש למחוק חבר לא קיים!");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }

/********************************************************************************************/
//if(  !($formdata['src_users']) && !($formdata['dest_users'])
//      && ($formdata['src_users'][0]!='none')  && ($formdata['dest_users'][0]!='none') 
//      &&   $formdata['deluser_Forum']=='none' &&  $formdata['adduser_Forum']=='none' ){
//      	 show_error_msg("בחר אופציה היא רשומת אב ולא שם משתמש");
//       $result = FALSE;
//      }   	
      
/*********************************************************************************************/
  
//	if(!empty($formdata['forum_status']) && ((!is_numeric($formdata['forum_status'])) || $formdata['forum_status']>1 || $formdata['forum_status']<0)) {
//    show_error_msg("סטטוס החלטה חייבת להיות   1 או 0  (או ריק).");
//    $result = FALSE; 
//	}	


	    
//try {	    
//	if(!empty($formdata['forum_status']) && ((!is_numeric($formdata['forum_status'])) 
//	   || $formdata['forum_status']>1 || $formdata['forum_status']<0)
//	   || (trim($formdata["forum_status"] )==""  )) {    
//	   	$result = FALSE;  
//			  throw new Exception("סטטוס פורום חייבת להיות 1 או 0!");
//					     
//		 }
//  	
//		}catch(Exception $e){
// 			$response['type'] = 'error';
//	         $message[]=$e->getMessage();
//	          $response[]['message']  =$message;
//	    }
	    
	    
	
/**************************************************************************************/
 $dst_usr=array();	
 $i=0;
 if(array_item($formdata,'forum_decID')   ){
$forumID=$formdata['forum_decID'];
 $sql="select * from rel_user_forum where forum_decID=$forumID";
 if($rows=$db->queryObjectArray($sql)){
 	foreach($rows as $row){
 		list($day_date_rel_date,$month_date_rel_date,$year_date_rel_date ) = explode('-',$row->HireDate);
     	        if (strlen($year_date_rel_date) < 3){
		           $row->HireDate="$year_date_rel_date-$month_date_rel_date-$day_date_rel_date";	
	    	    }else{
			       $row->HireDate="$day_date_rel_date-$month_date_rel_date-$year_date_rel_date";
	    	    }   
 		$forumUser_date[$row->HireDate] = $row->userID;
 		$forumUser_id[$row->userID] = $row->HireDate;
 	}
 	
 }
 
 }
 
 //for the name message
 if( (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
      &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
      && (count($dateIDs)==count($formdata['dest_users'])  )
      && array_item($formdata,'member_date0')) {
	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}
	
 	
	 

$i=0;	
    foreach($dateIDs as $daycomp) {
    	try {	    
    		if(!$frm-> DateSort($daycomp,$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
    	    	
//    	if(!$frm-> DateSort($daycomp,$frm_date)){  	
//		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
//		         $result = false;
//		   	    }
		   	    $i++;
		      //} 
    }
      

      
      
      
      
      
 }elseif(is_array($dateIDs)   && (count($formdata['dest_users'])>0  )
 &&(! array_item($formdata,'member') && !array_item($formdata,'member_date0') ) ) {
$i=0;
 	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}

	
$i=0;
	foreach($dateIDs as $daycomp) {
    	   	    
	try {	    
    		if(!$frm-> DateSort($daycomp,$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
		
		
//		if(!$frm-> DateSort($daycomp,$frm_date)){  	
//		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
//		         $result = false;
//		   	    }
		   	    $i++;
	 
    }
 	
 
  
 
 
}elseif(  (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
             &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
             && array_item($formdata,'member_date0')
		     && array_item($formdata,'dest_users')
		     &&  count($formdata['dest_users'])>0
             ){
  	
  	//for($i=0; $i<count($formdata['dest_users']); $i++){
  	$i=0;	
    foreach($formdata['dest_users'] as $key=>$val){
  			
    	$dest_usr[$i]=$key;
    	
    	
  		$i++;	
  		}
  		$rel_dest=array_merge($formdata['src_usersID'],$dest_usr);
		 $rel_dest=array_unique($rel_dest);
  		
  		
  		
  	//}   
             	
             	
     $i=0;	
    foreach($dateIDs as $daycomp) {
     
    	
    try {	    
    		if(!$frm-> DateSort($daycomp,$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
    	
//		   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
//		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
//		         $result = false;
//		   	    }
		   	    $i++;
		      }          	
            	
  }		       
   	       
/***********************************************************************************************************/
if( array_item($formdata,'appoint_date1') && $frm->check_date($formdata['appoint_date1'])  ){
	
try {	    
	 if(!$frm-> DateSort($formdata['appoint_date1'],$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך ממנה  לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	
  
}     		
/*************************************************************************************/	
if( array_item($formdata,'manager_date') && $frm->check_date($formdata['manager_date'])  ){
	    

	   try {	    
	    		if(!$frm-> DateSort($formdata['manager_date'],$frm_date)){
    			$result = FALSE;  
			  throw new Exception("אי אפשר להזין תאריך מנהל לפניי תאריך הקמת הפורום !");
					     
		 }
  	
		}catch(Exception $e){
 			$response['type'] = 'error';
	         $message[]=$e->getMessage();
	          $response[]['message']  =$message;
	    }
	    	
		         
} 	
 
/*************************************************************************************/
//if(!$result){
// 
//	$i=0;
//	// unset($response);
//	foreach($message as $row)
//	{
//	$results[] = array('message'=>$row ,'type'=>'error');	
//	  $key="messageError_$i";	
//	 $message_name[$key]=$row ;
//	  $i++;
//}
//  $response['message'][] = $message_name;  
// 		 print json_encode($response);
//	 		exit; 				
//
//}
/*************************************************************************************/
     	// now we are ready to turn this hash into JSON
if(!$result){

 unset($response);
	$i=0;
	$j=0;
	foreach($message as $row)
	{
	$results[] = array('message'=>$row ,'type'=>'error');	
	  $key="messageError_$i";	
	 $message_name[$key]=$row ;
	 $error_name[$i]='error';
	 //if($j==(count($message)-1)){
	if($j==(count($message))){
	  $j-=1;
	 }
	 $response[$j]['type']='error';
	  $i++;
	  
	  $j++;
	}
  $response['message'][] = $message_name;  
 		 print json_encode($response);
		exit; 				
 }else{

// foreach($rows as $row){
//        $results[] = array('forum_decName'=>$row->forum_decName,'forum_decID'=>$row->forum_decID);
//       }
//    echo json_encode($results);	
	
	
	
	
	//$response = array('type'=>'success', 'message'=>'Thank-You for submitting the form!');
//	$response = array('type'=>'', 'message'=>'');
//	$response['type'] = 'success';
//	$response['message'] = 'Thank-You for submitting the form!';
//    echo json_encode($response);
//    
// 	exit;	
 
  return true;
 }
}
 

/**********************************************************************************************/
/**********************************************************************************************/
	
function validate_forums($formdata="",$dateIDs="",$appointdateIDs="",$managerdateIDs="") {
/**********************************FUROMS+NEW_FORUMS************************************************************/	
$frm=new forum_dec();
global $db;
 $result = TRUE;   
if(  (trim($formdata["forum_decision"])=="" || trim($formdata["forum_decision"])=='none') 
	   && trim($formdata["newforum"])=="") {
    show_error_msg("חייב לשייך לפורום");
    $result = FALSE; 
	}
  
if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
 
    show_error_msg("פורומים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}

$new_forum=explode(';',$formdata["newforum"]);
if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   &&  $formdata["forum_decision"] && $formdata["forum_decision"]!=null ){	
	

foreach($new_forum as $forum){	
	$name=$db->sql_string($forum);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ פורום בשם $forum");
//              		UNSET($formdata['newforum']);
//              		UNSET($_POST['form']['newforum']);
              	 $result = FALSE;  
              
             }elseif(array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
              	unset($formdata['forum_decID']); 
              }
       }      	
}	


if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   && (!$formdata["forum_decision"] || $formdata["forum_decision"]==null)  ){	
	//$name=$db->sql_string($formdata["newforum"]);
	foreach($new_forum as $forum){	
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName ="      .  $db->sql_string($forum) . "  ";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיים  פורום בשם $forum");
//              		UNSET($_POST['form']['newforum']);
//              		UNSET($formdata['newforum']);
              	$result = FALSE;  
              }	
        }	
   }
if ($formdata['newforum'] && $formdata['newforum']!=null
    && array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
          unset($formdata['forum_decID']);      	
    }
/************************************************FORUMSTYPE**********************************/	

if(!is_array($formdata['dest_forumsType']) && trim($formdata["new_forumType"])==""  
	&&  !$formdata['dest_forumsType']  )  {
	$formdata['dest_forumsType']="";	
       
    }elseif(! is_array($formdata['dest_forumsType']) 
         && ($formdata['dest_forumsType']==null) || !$formdata["dest_forumsType"] || !array_item($formdata,'dest_forumsType')   
	      && !trim($formdata["new_forumType"])=="" ){
		
   $new_category=explode(';',$formdata["new_forumType"]);  
     foreach($new_category as $cat){		
	   
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName="      .  $db->sql_string($cat) . "  ";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם $cat");
//              		UNSET($formdata['new_category']);
//              		UNSET($_POST['form']['new_category']);
              	$result = FALSE;  
              }	
          }	
     
	
	      
	}elseif( $formdata["dest_forumsType"] && is_array($formdata["dest_forumsType"]) 
	         && count($formdata["dest_forumsType"])>0  && array_item($formdata,'dest_forumsType')
	         && (trim($formdata["new_forumType"]!=null) ) ){
	$new_category=explode(';',$formdata["new_forumType"]);  
     foreach($new_category as $cat){		
	   
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName="      .  $db->sql_string($cat) . "  ";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם $cat");
//              		UNSET($formdata['new_category']);
//              		UNSET($_POST['form']['new_category']);
              	$result = FALSE;  
              }	
          }	
         	
/************************************************************************************************************/	     	
  }elseif(  ($formdata["dest_forumsType"] && is_array($formdata["dest_forumsType"])  && count($formdata["dest_forumsType"])>0 )  
    && trim($formdata["new_forumType"]==null || trim($formdata["new_forumType"]=="")      ) ){	
        	
    	
    	
     $dest_forumsType= $formdata['dest_forumsType'];
     
foreach ($dest_forumsType as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select catID, catName from categories1 where catID in ($staffb)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name_b[$row->catID]=$row->catName;
	}
      $name=array_merge($name,$name_b);
      unset($staff_testb);
       
}else{
$staff=implode(',',$formdata['dest_forumsType'])	;		
			
$sql2="select catID, catName from categories1 where catID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			//$name[]=$row->catName;
			
  }
}  	
    	
    
    	
//    	$staff=implode(',',$formdata['dest_forumsType']);
//	$sql="select catID,catName from categories1 where catID in($staff)";
//		if(!$rows=$db->queryObjectArray($sql)){
//		$formdata['dest_forumsType']="";
//		}else{
//			foreach($rows as $row){
//	          $assocID[$row->catID]=$row->catName;			
//				
//			}
			if(array_item($name,'11')){
				show_error_msg("קטגוריות הפורומים רשומת אב אין לבחור בה");
                $result = FALSE;
			}
		}
/************************************************************************************************************/ 
    
	
	
	if(  (trim($formdata['dest_forumsType'])=="" || trim($formdata['dest_forumsType']=='none')) 
	   && trim($formdata["new_forumType"])=="") {
    show_error_msg("חייב לשייך לקטגוריה");
   $result = FALSE;  
	}
	

 
      

/************************************APPOINTS+NEWAPPOINTS*************************************************************************/	
  if(!is_array($formdata['dest_appoints']) && trim($formdata["new_appoints"])==""   
   &&  !$formdata['dest_appoints']){
	$formdata['dest_appoints']="";
	
       
     }elseif(!is_array($formdata['dest_appoints']) 
         && ($formdata['dest_appoints']==null) || !$formdata["dest_appoints"] || !array_item($formdata,'dest_appoints')   
	      && !trim($formdata["new_appoint"])=="" && array_item($formdata,'new_appoint')){
	      foreach($formdata["new_appoint"] as $appoint){
    	         
	      	    $sql="SELECT full_name  from users where userID=$appoint";
				if($rows=$db->queryObjectArray($sql)){
    	        $usr_fname=$rows[0]->full_name; 
	      	
				$sql="SELECT appointName  from appoint_forum where userID=$appoint";
				if($rows=$db->queryObjectArray($sql))
				 if($rows[0]->appointName!=''){
				 show_error_msg("כבר קיים ממנה  אם שם $usr_fname!");
				 $result = FALSE; 
				  }
				 }
	      }
	      
	}elseif( $formdata["dest_appoints"] && is_array($formdata["dest_appoints"]) 
	         && count($formdata["dest_appoints"])>0  && array_item($formdata,'dest_appoints')
	         && (trim($formdata["new_appoint"]!=null) ) ){
	         	
	         	
	       foreach($formdata["new_appoint"] as $appoint){
	       	
	       	$sql="SELECT full_name  from users where userID=$appoint";
				if($rows=$db->queryObjectArray($sql)){
    	        $usr_fname=$rows[0]->full_name;
				$sql="SELECT appointName  from appoint_forum where userID=$appoint";
					
				if($rows=$db->queryObjectArray($sql))
				 if($rows[0]->appointName!=''){
				 show_error_msg("כבר קיים ממנה  אם שם $usr_fname!");
				 $result = FALSE; 
				  }
				 }
	         }
/************************************************************************************************************/	     	
  }elseif(  ($formdata["dest_appoints"] && is_array($formdata["dest_appoints"])  && count($formdata["dest_appoints"])>0 )  
    && trim($formdata["new_appoint"]==null || trim($formdata["new_appoint"]=="")      ) ){	

    	
    $dest_appoints= $formdata['dest_appoints'];
unset($staff_test);	
unset($staff_testb);	
foreach ($dest_appoints as $key=>$val){
	
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
   
  }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
	
}			



if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			$name_appoint[$row->appointID]=$row->appointName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){

$staff=implode(',',$staff_test);

$sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			$name_appoint[$row->appointID]=$row->appointName;
			 
			
  }
	
	
  $staff_b=implode(',',$staff_testb);

$sql2="select appointID, appointName from appoint_forum where appointID in ($staff_b)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			$name_appoint_b[$row->appointID]=$row->appointName;
			 
			
  }
  
 $name_appoint=array_merge($name_appoint,$name_appoint_b); 
 unset($staff_testb);
}else{    


$staff=implode(',',$formdata['dest_appoints']);			
			
$sql2="select appointID, appointName from appoint_forum where appointID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			//$name_appoint[$row->appointID]=$row->appointName;
			$name_appoint[$row->appointID]=$row->appointName;
			
  }  	
 /************************************************************************************************************/   	
			if(array_item($name_appoint,'11')){
				show_error_msg("ממנים בעין השופט רשומת אב אין לבחור בה");
                $result = FALSE;
			}
		}
	}      	
   	
   	
	    
	if(  (trim($formdata["dest_appoints"])=="" || trim($formdata["dest_appoints"]=='none')) 
	   && trim($formdata["new_appoint"])=="") {
    show_error_msg("חייב לשייך ממנה פורום");
    $result = FALSE; 
	}
	
	
   	
// $j=0;
//if( trim($formdata["new_appoint"] ) && trim ($formdata["new_appoint"]!=null && $formdata["new_appoint"]!=0)    ){
//    foreach($formdata["new_appoint"] as $appoint){    	  
//	if(is_array($formdata['new_appoint']) )	
//    $id=$formdata['new_appoint'][$j];
//	 $sql = "SELECT COUNT(*) FROM appoint_forum " .
//                  " WHERE userID=$id";
//              if($db->querySingleItem($sql)>0) {
//              	$sql1="select full_name from users where userID=$id ";
//	             $rows=$db->queryObjectArray($sql1);
//	               $name=$rows[0]->full_name;
//              		 show_error_msg("כבר קיים ממנה  אם שם $name!");
//              	 
//               $result = FALSE; 
//        }	
//      $j++;  
//   	}	
// }	
 
 
 
/**********************************MANAGERS******************************************************/	
   if(!is_array($formdata['dest_managers']) && trim($formdata["new_manager"])=="" 
       &&  !$formdata['dest_managers'] ){
	$formdata['dest_managers']="";
	
       
     }elseif(!is_array($formdata['dest_managers'] )
         && ($formdata['dest_managers']==null) || !$formdata["dest_managers"] || !array_item($formdata,'dest_managers')  
	      && !trim($formdata["new_manager"])=="" && array_item($formdata,'new_manager')  ){
    foreach($formdata["new_manager"] as $manager){
    	
    	     $sql="SELECT full_name  from users where userID=$manager";
				if($rows=$db->queryObjectArray($sql)){
    	        $usr_fname=$rows[0]->full_name;
      
			$sql="SELECT managerName  from managers where userID=$manager";
			if($rows=$db->queryObjectArray($sql))
			 if($rows[0]->managerName!=''){
			show_error_msg("כבר קיים מנהל אם שם $usr_fname!");
			 $result = FALSE; 
			 }
			}
        }
	      
	}elseif( $formdata["dest_managers"] 
	        && is_array($formdata["dest_managers"]) 
	        && count($formdata["dest_managers"])>0  
	        && array_item($formdata,'dest_managers')
	        && (trim($formdata["new_manager"]!=null) 
	        && array_item($formdata,'new_manager') ) ){
	foreach($formdata["new_manager"] as $manager){
		
              $sql="SELECT full_name  from users where userID=$manager";
				if($rows=$db->queryObjectArray($sql)){ 
    	        $usr_fname=$rows[0]->full_name;
			$sql="SELECT managerName  from managers where userID=$manager";
			if($rows=$db->queryObjectArray($sql))
			 if($rows[0]->managerName!=''){
			show_error_msg("כבר קיים מנהל אם שם $usr_fname!");
			 $result = FALSE; 
			 }
		    }	
		}
/************************************************************************************************************/   	
    	
            
  }elseif(  ($formdata["dest_managers"] && is_array($formdata["dest_managers"])  && count($formdata["dest_managers"])>0 ) 
    && trim($formdata["new_manager"]==null || trim($formdata["new_manager"]=="")      ) ){	

    	
    	
    	
$dest_managers= $formdata['dest_managers'];
unset($staff_test);
unset($staff_testb);		
foreach ($dest_managers as $key=>$val){
	
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
     $staff_test[]=$val;
   
     }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
	
}			
			
 if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select managerID, managerName from managers where managerName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
                   
			
    }
 }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
  $staff=implode(',',$staff_test);
   $sql="select managerID, managerName from managers where managerName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
    }
    
    
    $staff_b=implode(',',$staff_testb);			
			
     $sql="select managerID, managerName from managers where managerID in ($staff_b)";
		if(!$rows=$db->queryObjectArray($sql))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers_b[$row->managerID]=$row->managerName;
                   
			
    }
    
    $name_managers=array_merge($name_managers,$name_managers_b);
    unset($staff_testb);
 	
 }else{
$staff=implode(',',$formdata['dest_managers']);			
			
$sql2="select managerID, managerName from managers where managerID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
                   
			
    }
      	
    	
 /************************************************************************************************************/   	
    	
     	
    	
    	
    	
//   $staff=implode(',',$formdata['dest_managers']);
//	$sql="select managerID,managerName from managers where managerID in($staff)";
//		if(!$rows=$db->queryObjectArray($sql)){
//		$formdata['dest_managers']="";
//		}else{
//			foreach($rows as $row){
//	          $assocmanagerID[$row->managerID]=$row->managerName;			
//				
//			}
			if(array_item($name_managers,'11')){
				show_error_msg("מנהלים בעין השופט רשומת אב אין לבחור בה");
                $result = FALSE;
			}
		}
	}      	
 
 if(  (trim($formdata["dest_managers"])=="" || trim($formdata["dest_managers"]=='none')) 
	   && trim($formdata["new_manager"])=="") {
    show_error_msg("חייב לשייך מרכז פורום");
    $result = FALSE; 	
	}
	
	
	
	


//$i=0;
//if( trim($formdata["new_manager"] ) && trim ($formdata["new_manager"]!=null) &&  $formdata["new_manager"]!=0){
//    foreach($formdata["new_manager"] as $manager){    	  
//	if(is_array($formdata['new_manager']) )	
//    $id=$formdata['new_manager'][$i];
//    	
//	 $sql = "SELECT COUNT(*) FROM managers " .
//                  " WHERE userID=$id";
//              if($db->querySingleItem($sql)>0) {
//              		 $sql1="select full_name from users where userID=$id ";
//	                   $rows=$db->queryObjectArray($sql1);
//	                   $name=$rows[0]->full_name;
//              		 show_error_msg("כבר קיים ממנה  אם שם $name!");
//              	 
//               $result = FALSE; 
//        }	
//        $i++;
//   	}	
// }	




/*******************************MANAGERTYPE*********************************************************/	

if(!is_array($formdata['dest_managersType']) && trim($formdata["new_managerType"])==""  
	&&  !$formdata['dest_managersType'] )  {
	$formdata['dest_managersType']="";	
       
     }elseif(!is_array($formdata['dest_managersType']) 
         && ($formdata['dest_managersType']==null) || !$formdata["dest_managersType"] || !array_item($formdata,'dest_managersType')  
	      && !trim($formdata["new_managerType"])=="" ){
		
   $manager_type=explode(';',$formdata['new_managerType']);	

    foreach($manager_type as $type){
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName="      .  $db->sql_string($type) . "  ";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג מנהלים בשם $type");
//              		UNSET($formdata['new_type']);
//              		UNSET($_POST['form']['new_type']);
              	 
                $result = FALSE; 
              }	
            } 
     
	
	      
	}elseif( $formdata["dest_managersType"] && is_array($formdata["dest_managersType"]) 
	         && count($formdata["dest_managersType"])>0  && array_item($formdata,'dest_managersType')
	         && (trim($formdata["new_managerType"]!=null) ) ){
	$manager_type=explode(';',$formdata['new_managerType']);	

    foreach($manager_type as $type){
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName="      .  $db->sql_string($type) . "  ";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג מנהלים בשם $type");
//              		UNSET($formdata['new_type']);
//              		UNSET($_POST['form']['new_type']);
              	 
                $result = FALSE; 
              }	
            } 
         	
/************************************************************************************************************/   	
    	     	
  }elseif(  ($formdata["dest_managersType"] && is_array($formdata["dest_managersType"])  && count($formdata["dest_managersType"])>0 ) 
    && trim($formdata["new_managerType"]==null || trim($formdata["new_managerType"]=="")      ) ){	

    $dest_managersType= $formdata['dest_managersType'];
	unset($staff_test);
    unset($staff_testb);	
foreach ($dest_managersType as $key=>$val){
	
if(!is_numeric($val)){
	$val=$db->sql_string($val);
     $staff_test[]=$val;
   
     }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
}			


if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
		
     if(!$rows=$db->queryObjectArray($sql))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }
}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
		
     if(!$rows=$db->queryObjectArray($sql))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }
    
 $staff_b=implode(',',$staff_testb);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff_b)";
		
     if(!$rows=$db->queryObjectArray($sql))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
       $name_managerType_b[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }    
    $name_managerType=array_merge($name_managerType,$name_managerType_b);
    unset($staff_testb);
}else{
//$staff=$result["dest_managersType"];
$staff=implode(',',$formdata['dest_managersType']);			
			
$sql2="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
			$name_managerType[$row->managerTypeID]=$row->managerTypeName;
			
			
  }	
    	
    	
//   $staff=implode(',',$formdata['dest_managersType']);
//	$sql="select managerTypeID,managerTypeName from manager_type where managerTypeID in($staff)";
//		if(!$rows=$db->queryObjectArray($sql)){
//		$formdata['dest_managersType']="";
//		}else{
//			foreach($rows as $row){
//	          $assocmanagerTypeID[$row->managerTypeID]=$row->managerTypeName;			
//				
//			}
			if(array_item($name_managerType,'none')){
				show_error_msg("סוגי מנהלים בעין השופט רשומת אב אין לשייך אותה");
                $result = FALSE;
			}
		}

    }

/************************************************************************************************************/   	
      
	if(  (trim($formdata["dest_managersType"])=="" || trim($formdata["dest_managersType"]=='none')) 
	   && trim($formdata["new_managerType"])=="") {
    show_error_msg("חייב לשייך סוגי מנהלים");
    $result = FALSE; 
	}
	

    
/*********************************************************************************************/
    
/******************************INSERT_Link****************************************************************/
  if(is_array($formdata['insert_forum'])){
  	foreach($formdata['insert_forum'] as $link ){
  		
  	    if($link=='11'){
  	    show_error_msg("פורומים בעין השופט רשומת אב אין לקשר אליו");
  	    $result = FALSE;
  	    } 
  	}
  	
  }

if(is_array($formdata['insert_forumType'])){
  	foreach($formdata['insert_forumType'] as $link ){
  		
  	    if($link=='11'){
  	    show_error_msg("קטגוריות הפורומים רשומת אב אין לקשר אליו");
  	    $result = FALSE;
  	    }
  	}
  	
  } 

  
  
if(is_array($formdata['insert_appoint'])){
  	foreach($formdata['insert_appoint'] as $link ){
  		
  	    if($link=='11'){
  	    show_error_msg("ממנים בעין השופט רשומת אב אין לקשר אליו");
  	    $result = FALSE;
  	    }
  	}
  	
  } 
  
if(is_array($formdata['insert_manager'])){
  	foreach($formdata['insert_manager'] as $link ){
  		
  	    if($link=='11'){
  	    show_error_msg("מנהלים בעין השופט רשומת אב אין לקשר אליו");
  	    $result = FALSE;
  	    }
  	}
  	
  } 
  

if(is_array($formdata['insert_managerType'])){
  	foreach($formdata['insert_managerType'] as $link ){
  		
  	    if($link=='11'){
  	    show_error_msg("סוגי מנהלים בעין השופט רשומת אב אין לקשר אליו");
  	    $result = FALSE;
  	    }
  	}
  	
  } 
/*******************************************************************************************************************/  
  
/*******************************************DATES*******************************************************************/
 if(is_array($dateIDs)){   

$i=0; 	
foreach($dateIDs as $forum_date){
list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$forum_date);
   if ( !is_numeric($day_date_forum )
     && !is_numeric($month_date_forum) 
     && !is_numeric($year_date_forum)
     || ( !$frm->check_date($forum_date))  ){ 
       $forum_date="";        
      
   }       
         
   $i++;
   }
 } 
if(  (trim($forum_date)=="" || $forum_date=='11') ) {
	
    show_error_msg("חייב לציין מתיי הוקם הפורום ");
    $result = FALSE; 
	}
  

/***********************************************************************************************************/	
if(is_array($appointdateIDs) ){
	foreach($appointdateIDs as $appoint_date){
list( $day_date_appoint,$month_date_appoint,$year_date_appoint) = explode('-',$appoint_date);
   if( !is_numeric($day_date_appoint )
    && !is_numeric($month_date_appoint) 
    && !is_numeric($year_date_appoint)
    || ( !$frm->check_date($appoint_date))  ){ 
          $$appoint_date="";        
        }       
   }        
}       
        
if(  (trim($appoint_date)=="" || trim($appoint_date)=='none') ) {
	
    show_error_msg("חייב לציין מתיי התמנה הממנה");
    $result = FALSE; 
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
if(is_array($managerdateIDs) ){
	foreach($managerdateIDs as $manager_date){
	

	
list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$manager_date);
   if( !is_numeric($day_date_manager)
    && !is_numeric($month_date_manager) 
    && !is_numeric($year_date_manager)
    || ( !$frm->check_date($manager_date))  ){ 
          $manager_date="";        
        }       
	}
}	
if(  (trim($manager_date)=="" || trim($manager_date)=='none') ) {
	
    show_error_msg("חייב לציין מתיי התמנה המנהל");
    $result = FALSE; 
	}	
	
	
	
/**************************************************************************************************************/ 
   
/**************************CHECK_FORUM_DATE************************************************************/

if(!is_array($dateIDs) ){
	$dateIDs="";
}else{
		   	foreach($dateIDs as $daycomp) {
		   			
		   		if( (!$frm->check_date($daycomp))){ 
		   		
		         show_error_msg("תאריך הקמת הפורום לא חוקי");
		         $result = false;
		         }  
		   	}
 }

// if($dateIDs==""){
// 	show_error_msg("חייב להזין תאריך הקמת פורום");
//		         $result = false;
// 	 }
 	 
/********************************APPOINT_DATE_BEFORE*****************************************************/

 	 if($appointdateIDs){
 	 if($name_appoint){
  	  $i=0;
	foreach($name_appoint as $key=>$val){
       	$names[$i]=$val;
        $i++;   	
       }    
	
  		
  $i=0; 
	foreach($appointdateIDs as $daycomp) {
    	        
    		    if(!$frm->check_date($daycomp)){
    		     show_error_msg("תאריך ממנה לא חוקי");
		         $result = false;
    		    }   
		   	    if(!$frm-> DateSort($daycomp,$dateIDs[$i])){  	
		         show_error_msg("אי אפשר להזין תאריך ממנה  " . $names[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      //} 
    }
}else{
$i=0; 
	foreach($appointdateIDs as $daycomp) {
    	        
    		    if(!$frm->check_date($daycomp)){
    		     show_error_msg("תאריך ממנה לא חוקי");
		         $result = false;
    		    }   
		   	    if(!$frm-> DateSort($daycomp,$dateIDs[$i])){  	
		         show_error_msg("אי אפשר להזין תאריך ממנה     לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      //} 
    }
	
  }   
} 
/****************************************MANAGER_DATE_BEFORE**************************************************************/

 	 if($managerdateIDs){
 	 if($name_managers){
  	  $i=0;
	foreach($name_managers as $key=>$val){
       	$namemanagers[$i]=$val;
        $i++;   	
       }    
	
  		
  $i=0; 
	foreach($managerdateIDs as $daycomp) {
    	        
    		    if(!$frm->check_date($daycomp)){
    		     show_error_msg("תאריך ממנה לא חוקי");
		         $result = false;
    		    }   
		   	    if(!$frm-> DateSort($daycomp,$dateIDs[$i])){  	
		         show_error_msg("אי אפשר להזין תאריך מנהל  " . $namemanagers[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      //} 
    }
}else{
$i=0; 
	foreach($managerdateIDs as $daycomp) {
    	        
    		    if(!$frm->check_date($daycomp)){
    		     show_error_msg("תאריך ממנה לא חוקי");
		         $result = false;
    		    }   
		   	    if(!$frm-> DateSort($daycomp,$dateIDs[$i])){  	
		         show_error_msg("אי אפשר להזין תאריך מנהל לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      //} 
    }
	
  }   
} 
/*************************************************************************************/
 //END DATES
/*************************************************************************************/ 	  	 			
			return $result;
	}
 
/**********************************************************************************************/
/**********************************************************************************************/
	
function validate_forums_ajx($formdata="",$dateIDs="",$appointdateIDs="",$managerdateIDs="") {
/**********************************FUROMS+NEW_FORUMS************************************************************/	
$frm=new forum_dec();
global $db;
 $result = TRUE;   
   	
	  try {
			 
	  if(  (trim($formdata["forum_decision"])=="" || trim($formdata["forum_decision"])=='none') 
	        && trim($formdata["newforum"])=="") {
	            $result = FALSE;   
			    throw new Exception("חייב לשייך לפורום! ");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    }
	   	
/****************************************************************************************************/
	 try {
			 
	  if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
	            $result = FALSE;   
			    throw new Exception("פורומים בעין השופט רשומת אב אין לשייך אותה! ");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    }
	   	 	   	
/*******************************************************************************************************/
$new_forum=explode(';',$formdata["newforum"]);
if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   &&  $formdata["forum_decision"] && $formdata["forum_decision"]!=null ){	
	

foreach($new_forum as $forum){	
	$name=$db->sql_string($forum);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
	 
	 
 try {
			 
     if($db->querySingleItem($sql)>0) {
  
	            $result = FALSE;   
			    throw new Exception("כבר קיימ פורום בשם $forum! ");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    }
if(array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
              	unset($formdata['forum_decID']); 
              }
       }      	
}	

/*******************************************************************************************************/
if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   && (!$formdata["forum_decision"] || $formdata["forum_decision"]==null)  ){	
	//$name=$db->sql_string($formdata["newforum"]);
	foreach($new_forum as $forum){	
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName ="      .  $db->sql_string($forum) . "  ";
	try {
			 
     if($db->querySingleItem($sql)>0) {
  
	            $result = FALSE;   
			    throw new Exception("כבר קיימ פורום בשם $forum! ");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    }
             
        }	
   }
if ($formdata['newforum'] && $formdata['newforum']!=null
    && array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
          unset($formdata['forum_decID']);      	
    }
/************************************************FORUMSTYPE**********************************/	

if(!is_array($formdata['dest_forumsType']) && trim($formdata["new_forumType"])==""  
	&&  !$formdata['dest_forumsType']  )  {
	$formdata['dest_forumsType']="";	
       
    }elseif(! is_array($formdata['dest_forumsType']) 
         && ($formdata['dest_forumsType']==null) || !$formdata["dest_forumsType"] || !array_item($formdata,'dest_forumsType')   
	      && !trim($formdata["new_forumType"])=="" ){
		
   $new_category=explode(';',$formdata["new_forumType"]);  
     foreach($new_category as $cat){		
	   
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName="      .  $db->sql_string($cat) . "  ";
	   
     try {
			 
     if($db->querySingleItem($sql)>0) {
  
	            $result = FALSE;   
			    throw new Exception("כבר קיימ סוג פורומים בשם  $cat! ");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    } 

   }	
     
	
	      
	}elseif( $formdata["dest_forumsType"] && is_array($formdata["dest_forumsType"]) 
	         && count($formdata["dest_forumsType"])>0  && array_item($formdata,'dest_forumsType')
	         && (trim($formdata["new_forumType"]!=null) ) ){
	$new_category=explode(';',$formdata["new_forumType"]);  
     foreach($new_category as $cat){		
	   
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName="      .  $db->sql_string($cat) . "  ";
              try {
			 
     if($db->querySingleItem($sql)>0) {
  
	            $result = FALSE;   
			    throw new Exception("כבר קיימ סוג פורומים בשם  $cat! ");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    } 
     }	
         	
/************************************************************************************************************/	     	
  }elseif(  ($formdata["dest_forumsType"] && is_array($formdata["dest_forumsType"])  && count($formdata["dest_forumsType"])>0 )  
    && trim($formdata["new_forumType"]==null || trim($formdata["new_forumType"]=="")      ) ){	
        	
    	
    	
     $dest_forumsType= $formdata['dest_forumsType'];
 
foreach ($dest_forumsType as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select catID, catName from categories1 where catID in ($staffb)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name_b[$row->catID]=$row->catName;
	}
      $name=array_merge($name,$name_b);
      unset($staff_testb);
       
}else{
$staff=implode(',',$formdata['dest_forumsType'])	;		
			
$sql2="select catID, catName from categories1 where catID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata['dest_forumsType']="";
		else
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			//$name[]=$row->catName;
			
  }
}  	
    	
    
    	
//    	$staff=implode(',',$formdata['dest_forumsType']);
//	$sql="select catID,catName from categories1 where catID in($staff)";
//		if(!$rows=$db->queryObjectArray($sql)){
//		$formdata['dest_forumsType']="";
//		}else{
//			foreach($rows as $row){
//	          $assocID[$row->catID]=$row->catName;			
//				
//			}


  try {
			 
  	if(array_item($name,'11')){
  
	            $result = FALSE;   
			    throw new Exception("קטגוריות הפורומים רשומת אב אין לבחור בה!");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    } 
			
}
/************************************************************************************************************/ 
    
	 try {
			 
	 	if(  (trim($formdata['dest_forumsType'])=="" || trim($formdata['dest_forumsType']=='none')) 
	   && trim($formdata["new_forumType"])=="") {
	            $result = FALSE;   
			    throw new Exception("חייב לשייך לקטגוריה!");
	       }
  	
		} catch(Exception $e){
 		 	         $message[]=$e->getMessage();
	    } 
	
	
/************************************APPOINTS+NEWAPPOINTS*************************************************************************/	
  if(!is_array($formdata['dest_appoints']) && trim($formdata["new_appoints"])==""   
   &&  !$formdata['dest_appoints']){
	$formdata['dest_appoints']="";
	
       
     }elseif(!is_array($formdata['dest_appoints']) 
         && ($formdata['dest_appoints']==null) || !$formdata["dest_appoints"] || !array_item($formdata,'dest_appoints')   
	      && !trim($formdata["new_appoint"])=="" && array_item($formdata,'new_appoint')){
	      foreach($formdata["new_appoint"] as $appoint){
    	         
	      	    $sql="SELECT full_name  from users where userID=$appoint";
				if($rows=$db->queryObjectArray($sql)){
    	        $usr_fname=$rows[0]->full_name; 
	      	
				$sql="SELECT appointName  from appoint_forum where userID=$appoint";
				if($rows=$db->queryObjectArray($sql))
				 
			 try {
			 
			 	if($rows[0]->appointName!=''){
  
	            $result = FALSE;   
			    throw new Exception("כבר קיים ממנה  אם שם $usr_fname!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 
								
	   }
   }
	      
	}elseif( $formdata["dest_appoints"] && is_array($formdata["dest_appoints"]) 
	         && count($formdata["dest_appoints"])>0  && array_item($formdata,'dest_appoints')
	         && (trim($formdata["new_appoint"]!=null) ) ){
	         	
	         	
	       foreach($formdata["new_appoint"] as $appoint){
	       	
	       	$sql="SELECT full_name  from users where userID=$appoint";
				if($rows=$db->queryObjectArray($sql)){
    	        $usr_fname=$rows[0]->full_name;
				$sql="SELECT appointName  from appoint_forum where userID=$appoint";
					
				if($rows=$db->queryObjectArray($sql))
				 
				try {
			 
			 	if($rows[0]->appointName!=''){
  
	            $result = FALSE;   
			    throw new Exception("כבר קיים ממנה  אם שם $usr_fname!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 
				
			 }
	  }
/************************************************************************************************************/	     	
  }elseif(  ($formdata["dest_appoints"] && is_array($formdata["dest_appoints"])  && count($formdata["dest_appoints"])>0 )  
    && trim($formdata["new_appoint"]==null || trim($formdata["new_appoint"]=="")      ) ){	

    	
    $dest_appoints= $formdata['dest_appoints'];
		
foreach ($dest_appoints as $key=>$val){
	
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
   
  }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
	
}			



if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			$name_appoint[$row->appointID]=$row->appointName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){

$staff=implode(',',$staff_test);

$sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			$name_appoint[$row->appointID]=$row->appointName;
			 
			
  }
	
	
  $staff_b=implode(',',$staff_testb);

$sql2="select appointID, appointName from appoint_forum where appointID in ($staff_b)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			$name_appoint_b[$row->appointID]=$row->appointName;
			 
			
  }
  
 $name_appoint=array_merge($name_appoint,$name_appoint_b); 
 unset($staff_testb);
}else{    


$staff=implode(',',$formdata['dest_appoints']);			
			
$sql2="select appointID, appointName from appoint_forum where appointID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_appoints"]="";
		else
		foreach($rows as $row){
			
			//$name_appoint[$row->appointID]=$row->appointName;
			$name_appoint[$row->appointID]=$row->appointName;
			
  }  	
 /************************************************************************************************************/   	
	try {
			 
		  if(array_item($name_appoint,'11')){
  
	            $result = FALSE;   
			    throw new Exception("ממנים בעין השופט רשומת אב אין לבחור בה!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 		
  
		}
	}      	
   	
   	
	    
	
	   	try {
			 
		 if(  (trim($formdata["dest_appoints"])=="" || trim($formdata["dest_appoints"]=='none')) 
	             && trim($formdata["new_appoint"])=="") {
	   	
  
	            $result = FALSE;   
			    throw new Exception("חייב לשייך ממנה פורום!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 		
  
	   	
	   	
     
	
	
   	
// $j=0;
//if( trim($formdata["new_appoint"] ) && trim ($formdata["new_appoint"]!=null && $formdata["new_appoint"]!=0)    ){
//    foreach($formdata["new_appoint"] as $appoint){    	  
//	if(is_array($formdata['new_appoint']) )	
//    $id=$formdata['new_appoint'][$j];
//	 $sql = "SELECT COUNT(*) FROM appoint_forum " .
//                  " WHERE userID=$id";
//              if($db->querySingleItem($sql)>0) {
//              	$sql1="select full_name from users where userID=$id ";
//	             $rows=$db->queryObjectArray($sql1);
//	               $name=$rows[0]->full_name;
//              		 show_error_msg("כבר קיים ממנה  אם שם $name!");
//              	 
//               $result = FALSE; 
//        }	
//      $j++;  
//   	}	
// }	
 
 
 
/**********************************MANAGERS******************************************************/	
   if(!is_array($formdata['dest_managers']) && trim($formdata["new_manager"])=="" 
       &&  !$formdata['dest_managers'] ){
	$formdata['dest_managers']="";
	
       
     }elseif(!is_array($formdata['dest_managers'] )
         && ($formdata['dest_managers']==null) || !$formdata["dest_managers"] || !array_item($formdata,'dest_managers')  
	      && !trim($formdata["new_manager"])=="" && array_item($formdata,'new_manager')  ){
    foreach($formdata["new_manager"] as $manager){
    	
    	     $sql="SELECT full_name  from users where userID=$manager";
				if($rows=$db->queryObjectArray($sql)){
    	        $usr_fname=$rows[0]->full_name;
      
			$sql="SELECT managerName  from managers where userID=$manager";
			if($rows=$db->queryObjectArray($sql))
			 
			try {
			 
				if($rows[0]->managerName!=''){
  
	            $result = FALSE;   
			    throw new Exception("כבר קיים מנהל אם שם  $usr_fname!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 	
									
			}
        }
	      
	}elseif( $formdata["dest_managers"] 
	        && is_array($formdata["dest_managers"]) 
	        && count($formdata["dest_managers"])>0  
	        && array_item($formdata,'dest_managers')
	        && (trim($formdata["new_manager"]!=null) 
	        && array_item($formdata,'new_manager') ) ){
	foreach($formdata["new_manager"] as $manager){
		
              $sql="SELECT full_name  from users where userID=$manager";
				if($rows=$db->queryObjectArray($sql)){ 
    	        $usr_fname=$rows[0]->full_name;
			$sql="SELECT managerName  from managers where userID=$manager";
			if($rows=$db->queryObjectArray($sql))
			try {
			 
				if($rows[0]->managerName!=''){
  
	            $result = FALSE;   
			    throw new Exception("כבר קיים מנהל אם שם  $usr_fname!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 	
		    }	
		}
/************************************************************************************************************/   	
    	
            
  }elseif(  ($formdata["dest_managers"] && is_array($formdata["dest_managers"])  && count($formdata["dest_managers"])>0 ) 
    && trim($formdata["new_manager"]==null || trim($formdata["new_manager"]=="")      ) ){	

    	
    	
    	
$dest_managers= $formdata['dest_managers'];
		
foreach ($dest_managers as $key=>$val){
	
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
     $staff_test[]=$val;
   
     }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
	
}			
			
 if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select managerID, managerName from managers where managerName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
                   
			
    }
 }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
  $staff=implode(',',$staff_test);
   $sql="select managerID, managerName from managers where managerName in ($staff)";
		if(!$rows=$db->queryObjectArray($sql))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
    }
    
    
    $staff_b=implode(',',$staff_testb);			
			
     $sql="select managerID, managerName from managers where managerID in ($staff_b)";
		if(!$rows=$db->queryObjectArray($sql))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers_b[$row->managerID]=$row->managerName;
                   
			
    }
    
    $name_managers=array_merge($name_managers,$name_managers_b);
    unset($staff_testb);
 	
 }else{
$staff=implode(',',$formdata['dest_managers']);			
			
$sql2="select managerID, managerName from managers where managerID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
		$formdata["dest_managers"]="";
		else
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
                   
			
    }
      	
    	
 /************************************************************************************************************/   	
    	
     	
    	
    	
    	
//   $staff=implode(',',$formdata['dest_managers']);
//	$sql="select managerID,managerName from managers where managerID in($staff)";
//		if(!$rows=$db->queryObjectArray($sql)){
//		$formdata['dest_managers']="";
//		}else{
//			foreach($rows as $row){
//	          $assocmanagerID[$row->managerID]=$row->managerName;			
//				
//			}

    
    try {
			 
    	if(array_item($name_managers,'11')){
  
	            $result = FALSE;   
			    throw new Exception("מנהלים בעין השופט רשומת אב אין לבחור בה!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 	
			
		}
	}      	
 
	
	
	
 try {
			 
 	 if(  (trim($formdata["dest_managers"])=="" || trim($formdata["dest_managers"]=='none')) 
	   && trim($formdata["new_manager"])=="") {
  
	            $result = FALSE;   
			    throw new Exception("חייב לשייך מרכז פורום!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 	
//$i=0;
//if( trim($formdata["new_manager"] ) && trim ($formdata["new_manager"]!=null) &&  $formdata["new_manager"]!=0){
//    foreach($formdata["new_manager"] as $manager){    	  
//	if(is_array($formdata['new_manager']) )	
//    $id=$formdata['new_manager'][$i];
//    	
//	 $sql = "SELECT COUNT(*) FROM managers " .
//                  " WHERE userID=$id";
//              if($db->querySingleItem($sql)>0) {
//              		 $sql1="select full_name from users where userID=$id ";
//	                   $rows=$db->queryObjectArray($sql1);
//	                   $name=$rows[0]->full_name;
//              		 show_error_msg("כבר קיים ממנה  אם שם $name!");
//              	 
//               $result = FALSE; 
//        }	
//        $i++;
//   	}	
// }	




/*******************************MANAGERTYPE*********************************************************/	

if(!is_array($formdata['dest_managersType']) && trim($formdata["new_managerType"])==""  
	&&  !$formdata['dest_managersType'] )  {
	$formdata['dest_managersType']="";	
       
     }elseif(!is_array($formdata['dest_managersType']) 
         && ($formdata['dest_managersType']==null) || !$formdata["dest_managersType"] || !array_item($formdata,'dest_managersType')  
	      && !trim($formdata["new_managerType"])=="" ){
		
   $manager_type=explode(';',$formdata['new_managerType']);	

    foreach($manager_type as $type){
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName="      .  $db->sql_string($type) . "  ";

	 
	 try {
			 
	 	if($db->querySingleItem($sql)>0) {
  
	            $result = FALSE;   
			    throw new Exception("כבר קיימ סוג מנהלים בשם $type!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 	
	 
	
    } 
     
	
	      
	}elseif( $formdata["dest_managersType"] && is_array($formdata["dest_managersType"]) 
	         && count($formdata["dest_managersType"])>0  && array_item($formdata,'dest_managersType')
	         && (trim($formdata["new_managerType"]!=null) ) ){
	$manager_type=explode(';',$formdata['new_managerType']);	

    foreach($manager_type as $type){
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName="      .  $db->sql_string($type) . "  ";
             try {
			 
	 	if($db->querySingleItem($sql)>0) {
  
	            $result = FALSE;   
			    throw new Exception("כבר קיימ סוג מנהלים בשם $type!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			   } 	
        } 
         	
/************************************************************************************************************/   	
    	     	
  }elseif(  ($formdata["dest_managersType"] && is_array($formdata["dest_managersType"])  && count($formdata["dest_managersType"])>0 ) 
    && trim($formdata["new_managerType"]==null || trim($formdata["new_managerType"]=="")      ) ){	

    $dest_managersType= $formdata['dest_managersType'];
		
foreach ($dest_managersType as $key=>$val){
	
if(!is_numeric($val)){
	$val=$db->sql_string($val);
     $staff_test[]=$val;
   
     }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
}			


if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
		
     if(!$rows=$db->queryObjectArray($sql))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }
}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
		
     if(!$rows=$db->queryObjectArray($sql))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }
    
 $staff_b=implode(',',$staff_testb);
 $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff_b)";
		
     if(!$rows=$db->queryObjectArray($sql))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
       $name_managerType_b[$row->managerTypeID]=$row->managerTypeName;
                   
			
    }    
    $name_managerType=array_merge($name_managerType,$name_managerType_b);
    unset($staff_testb);
}else{
//$staff=$result["dest_managersType"];
$staff=implode(',',$formdata['dest_managersType']);			
			
$sql2="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff)";
		if(!$rows=$db->queryObjectArray($sql2))
        $formdata["dest_managersType"]="";
        else
		foreach($rows as $row){
			
			$name_managerType[$row->managerTypeID]=$row->managerTypeName;
			
			
  }	
    	
    	
//   $staff=implode(',',$formdata['dest_managersType']);
//	$sql="select managerTypeID,managerTypeName from manager_type where managerTypeID in($staff)";
//		if(!$rows=$db->queryObjectArray($sql)){
//		$formdata['dest_managersType']="";
//		}else{
//			foreach($rows as $row){
//	          $assocmanagerTypeID[$row->managerTypeID]=$row->managerTypeName;			
//				
//			}

  
  try {
			 
	 	if(array_item($name_managerType,'none')){
		
	            $result = FALSE;   
			    throw new Exception("סוגי מנהלים בעין השופט רשומת אב אין לשייך אותה!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 	
			
		}

    }

/************************************************************************************************************/  
    try {
			 
    	if(  (trim($formdata["dest_managersType"])=="" || trim($formdata["dest_managersType"]=='none')) 
	         && trim($formdata["new_managerType"])=="") {
		
	            $result = FALSE;   
			    throw new Exception("חייב לשייך סוגי מנהלים!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    } 	 	
      
	   
/*********************************************************************************************/
    
/******************************INSERT_Link****************************************************************/
  if(is_array($formdata['insert_forum'])){
  	foreach($formdata['insert_forum'] as $link ){
  		
  	 try {
			 
  	 	 if($link=='11'){
		
	            $result = FALSE;   
			    throw new Exception("פורומים בעין השופט רשומת אב אין לקשר אליו!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }
  		
  	}
  	
  }

if(is_array($formdata['insert_forumType'])){
  	foreach($formdata['insert_forumType'] as $link ){
  	try {
			 
  	 	 if($link=='11'){
		
	            $result = FALSE;   
			    throw new Exception("קטגוריות הפורומים רשומת אב אין לקשר אליו!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }
  	
  	}
  	
  } 

  
  
if(is_array($formdata['insert_appoint'])){
  	foreach($formdata['insert_appoint'] as $link ){
  	try {
			 
  	 	 if($link=='11'){
		
	            $result = FALSE;   
			    throw new Exception("ממנים בעין השופט רשומת אב אין לקשר אליו!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }
  		
     	}
  	
  } 
  
if(is_array($formdata['insert_manager'])){
  	foreach($formdata['insert_manager'] as $link ){
  	try {
			 
  	 	 if($link=='11'){
		
	            $result = FALSE;   
			    throw new Exception("מנהלים בעין השופט רשומת אב אין לקשר אליו!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }
  	    
       	}
  	
  } 
  

if(is_array($formdata['insert_dest_managersType'])){
  	foreach($formdata['insert_managerType'] as $link ){
  	try {
			 
  	 	 if($link=='11'){
		
	            $result = FALSE;   
			    throw new Exception("סוגי מנהלים בעין השופט רשומת אב אין לקשר אליו!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }
  		
     	}
  	
  } 
/*******************************************************************************************************************/  
  
/*******************************************DATES*******************************************************************/
 if(is_array($dateIDs)){   

$i=0; 	
foreach($dateIDs as $forum_date){
list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$forum_date);
   if ( !is_numeric($day_date_forum )
     && !is_numeric($month_date_forum) 
     && !is_numeric($year_date_forum)
     || ( !$frm->check_date($forum_date))  ){ 
       $forum_date="";        
      
   }       
         
   $i++;
   }
 } 
 
 
 try {
			 
 	if(  (trim($forum_date)=="" || $forum_date=='11') ) {
		
	            $result = FALSE;   
			    throw new Exception("חייב לציין מתיי הוקם הפורום!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }
  		
/***********************************************************************************************************/	
if(is_array($appointdateIDs) ){
	foreach($appointdateIDs as $appoint_date){
list( $day_date_appoint,$month_date_appoint,$year_date_appoint) = explode('-',$appoint_date);
   if( !is_numeric($day_date_appoint )
    && !is_numeric($month_date_appoint) 
    && !is_numeric($year_date_appoint)
    || ( !$frm->check_date($appoint_date))  ){ 
          $$appoint_date="";        
        }       
   }        
}       

 try {
			 
 	if(  (trim($appoint_date)=="" || trim($appoint_date)=='none') ) {
		
	            $result = FALSE;   
			    throw new Exception("חייב לציין מתיי התמנה הממנה!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }


//////////////////////////////////////////////////////////////////////////////////////////////////////
if(is_array($managerdateIDs) ){
	foreach($managerdateIDs as $manager_date){
	

	
list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$manager_date);
   if( !is_numeric($day_date_manager)
    && !is_numeric($month_date_manager) 
    && !is_numeric($year_date_manager)
    || ( !$frm->check_date($manager_date))  ){ 
          $manager_date="";        
        }       
	}
}	

try {
	if(  (trim($manager_date)=="" || trim($manager_date)=='none') ) {
	           $result = FALSE;   
			    throw new Exception("חייב לציין מתיי התמנה המנהל!");
	             }
  	
				} catch(Exception $e){
		 		 	         $message[]=$e->getMessage();
			    }

/**************************************************************************************************************/ 
   
/**************************CHECK_FORUM_DATE************************************************************/

if(!is_array($dateIDs) ){
	$dateIDs="";
}else{
		   	foreach($dateIDs as $daycomp) {
				try {
					if( (!$frm->check_date($daycomp))){ 
					           $result = FALSE;   
							    throw new Exception("תאריך הקמת הפורום לא חוקי!");
					             }
				  	
								} catch(Exception $e){
						 		 	         $message[]=$e->getMessage();
							    }
			
		   	}
 }

 
 
 
//	try {
//		if($dateIDs==""){
//					           $result = FALSE;   
//							    throw new Exception("חייב להזין תאריך הקמת פורום!");
//					             }
//				  	
//								} catch(Exception $e){
//						 		 	         $message[]=$e->getMessage();
//							    }
  
/********************************APPOINT_DATE_BEFORE*****************************************************/

 	 if($appointdateIDs){
 	 if($name_appoint){
  	  $i=0;
	foreach($name_appoint as $key=>$val){
       	$names[$i]=$val;
        $i++;   	
       }    
	
  		
  $i=0; 
	foreach($appointdateIDs as $daycomp) {
    	      try {
    	      	 if(!$frm->check_date($daycomp)){
					           $result = FALSE;   
							    throw new Exception("תאריך ממנה לא חוקי!");
					             }
				  	
								} catch(Exception $e){
						 		 	         $message[]=$e->getMessage();
							    }
	           try {
    	      	  if(!$frm-> DateSort($daycomp,$dateIDs[$i])){ 
					           $result = FALSE;   
							    throw new Exception("אי אפשר להזין תאריך ממנה  " . $names[$i]. " לפניי תאריך הקמת הפורום!");
					             }
				  	
								} catch(Exception $e){
						 		 	         $message[]=$e->getMessage();
							    }
    		   
		   	    $i++;
		    }
}else{
$i=0; 
	foreach($appointdateIDs as $daycomp) {
	try {
		if(!$frm->check_date($daycomp)){
			$result = FALSE;   
			throw new Exception("תאריך ממנה לא חוקי!");
			 }
				  	
			} catch(Exception $e){
			 $message[]=$e->getMessage();
			}
    		     
    	try {
    		if(!$frm-> DateSort($daycomp,$dateIDs[$i])){
			$result = FALSE;   
			throw new Exception("אי אפשר להזין תאריך ממנה לפניי תאריך הקמת הפורום!");
			 }
				  	
			} catch(Exception $e){
			 $message[]=$e->getMessage();
			}
			
		   	    $i++;
	    }
	
  }   
} 
/****************************************MANAGER_DATE_BEFORE**************************************************************/

 	 if($managerdateIDs){
 	 if($name_managers){
  	  $i=0;
	foreach($name_managers as $key=>$val){
       	$namemanagers[$i]=$val;
        $i++;   	
       }    
	
  		
  $i=0; 
	foreach($managerdateIDs as $daycomp) {
	try {
		if(!$frm->check_date($daycomp)){
			$result = FALSE;   
			throw new Exception("תאריך מנהל לא חוקי!");
			 }
				  	
			} catch(Exception $e){
			 $message[]=$e->getMessage();
			}	        

			
	try {
		 if(!$frm-> DateSort($daycomp,$dateIDs[$i])){ 
			$result = FALSE;   
			throw new Exception("אי אפשר להזין תאריך מנהל  " . $namemanagers[$i]. "  לפניי תאריך הקמת הפורום! ");
			 }
				  	
			} catch(Exception $e){
			 $message[]=$e->getMessage();
			}		
		   	   
		 $i++;
    }
}else{
$i=0; 
	foreach($managerdateIDs as $daycomp) {
    try {
		if(!$frm->check_date($daycomp)){
			$result = FALSE;   
			throw new Exception("תאריך מנהל לא חוקי!");
			 }
				  	
			} catch(Exception $e){
			 $message[]=$e->getMessage();
			}	            
    		    

     try {
		if(!$frm-> DateSort($daycomp,$dateIDs[$i])){  	
			$result = FALSE;   
			throw new Exception("אי אפשר להזין תאריך מנהל  " . $namemanagers[$i]. "  לפניי תאריך הקמת הפורום! ");
			 }
				  	
			} catch(Exception $e){
			 $message[]=$e->getMessage();
			}	       			
			
		   	    $i++;
		 }
	  }   
} 
/*************************************************************************************/
 //END DATES
/*************************************************************************************/ 
//  if(!$result){
//
//  
//	$i=0;
//	$j=0;
//	foreach($message as $row)
//	{
//	$results[] = array('message'=>$row ,'type'=>'error');	
//	  $key="messageError_$i";	
//	 $message_name[$key]=$row ;
//	 $error_name[$i]='error';
//	 if($j==(count($message)-1))
//	  $j-=1;
//	 $response[$j]['type']='error';
//	  $i++;
//	  
//	  $j++;
//	}
//  $response['message'][] = $message_name;  
// 		 print json_encode($response);
//		exit; 	  
//    }
    
//////////////////////////////////////////////////////////////
if(!$result){
	$i=0;
	$j=0;
	foreach($message as $row)
	{ 
	  $key="messageError_$i";	
	 $message_name[$key]=$row ;
	 
	 if(!($j==(count($message)-1 ) && !$j=='0'   ) )
	  $response[$j]['type'] = 'error';
	 else{
	   $response[$j-1]['type'] = 'error';	
	 }
	  $i++;
	  $j++;
	}
	 $response['message'][] = $message_name;
 
 	print json_encode($response);
		exit; 	
}
    
    
			return $result;
	}
 
/**********************************************************************************************/
/**********************************************************************************************/

function validate_data(&$formdata="",&$dateIDs="",$frm_date="") {

global $db;
 $result = TRUE;  
$frm =new forum_dec();
$response = array('type'=>'', 'message'=>'');


$i=0;

 $member_date=$frm->build_date($formdata);
if(!array_item ($member_date,'today') ){
if(is_array($member_date)   
   && array_item($formdata,'member_date0')
   && array_item($formdata,'dest_users')
   &&  count($formdata['dest_users'])>0 ){
foreach($member_date['full_date']  as $date){
	$date_member="member_date$i";  
	IF(!$frm->check_date($formdata[$date_member])){
	   $member_date['full_date'][$i]=$formdata['today'];
	   	$formdata[$date_member]=$formdata['today'];
	   	}
	   	if(!$frm->check_date( $dateIDs[$i]) ){
	   	 $dateIDs[$i]	=$formdata['today'];	
	}
	$i++;
  }
}
}



list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$formdata['forum_date']);
   if( array_item($formdata, 'forum_date') 
   &&  !is_numeric($day_date_forum )
   && !is_numeric($month_date_forum) 
   && !is_numeric($year_date_forum)
 || ( !$frm->check_date($formdata['forum_date']))  ){ 
          $formdata['forum_date']="";        
        }       

if(  (trim($formdata["forum_date"])=="" || trim($formdata["forum_date"])=='none') ) {
	
    show_error_msg("חייב לציין מתיי הוקם הפורום ");
  //  $errors[]=show_error_msg("חייב לציין מתיי הוקם הפורום ");
    $result = FALSE; 
	}
  

/***********************************************************************************************************/	
list( $day_date_appoint,$month_date_appoint,$year_date_appoint) = explode('-',$formdata['appoint_date1']);
   if( array_item($formdata, 'appoint_date1') 
   &&  !is_numeric($day_date_appoint )
   && !is_numeric($month_date_appoint) 
   && !is_numeric($year_date_appoint)
 || ( !$frm->check_date($formdata['appoint_date1']))  ){ 
          $formdata['appoint_date1']="";        
        }       

if(  (trim($formdata["appoint_date1"])=="" || trim($formdata["appoint_date1"])=='none') ) {
	
    show_error_msg("חייב לציין מתיי התמנה הממנה");
    $result = FALSE; 
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$formdata['manager_date']);
   if( array_item($formdata, 'manager_date') 
   &&  !is_numeric($day_date_manager )
   && !is_numeric($month_date_manager) 
   && !is_numeric($year_date_manager)
 || ( !$frm->check_date($formdata['manager_date']))  ){ 
          $formdata['manager_date']="";        
        }       

if(  (trim($formdata["manager_date"])=="" || trim($formdata["manager_date"])=='none') ) {
	
    show_error_msg("חייב לציין מתיי התמנה המנהל");
    $result = FALSE; 
	}	
	
	
	
/*************************************FORUMS*************************************************************************/ 
if(  (trim($formdata["forum_decision"])=="" || trim($formdata["forum_decision"])=='none') 
	   && trim($formdata["newforum"])=="") {
	   	
    show_error_msg("חייב לשייך לפורום");
    $result = FALSE; 
	}
  

if(  trim($formdata["forum_decision"])=="11" && trim($formdata["newforum"])==""){ 
 
    show_error_msg("פורומים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}
	
if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   &&  $formdata["forum_decision"] && is_numeric($formdata["forum_decision"]) ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ פורום בשם הזה");
//              		UNSET($formdata['newforum']);
//              		UNSET($_POST['form']['newforum']);
              	 $result = FALSE;  
              }elseif(array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
              	unset($formdata['forum_decID']); 
              }	
}	


if( trim($formdata["newforum"]!="none") && trim($formdata["newforum"]!= null )  
   && (!$formdata["forum_decision"] || $formdata["forum_decision"]==null)  ){	
	$name=$db->sql_string($formdata["newforum"]);
	 $sql = "SELECT COUNT(*) FROM forum_dec " .
                  " WHERE forum_decName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ פורום בשם הזה");
//              		UNSET($_POST['form']['newforum']);
//              		UNSET($formdata['newforum']);
              	$result = FALSE;  
              }	
}	
if ($formdata['newforum'] && $formdata['newforum']!=null
    && array_item($formdata,'forum_decID')  &&  $formdata['forum_decID'] ){
          unset($formdata['forum_decID']);      	
    }
/*****************************************FORUMS_TYPE********************************************/	
	
	if(  (trim($formdata["dest_forumsType"])=="" || trim($formdata["dest_forumsType"]=='none')) 
	   && trim($formdata["new_forumType"])=="") {
    show_error_msg("חייב לשייך לקטגוריה");
   $result = FALSE;  
   
	
	}
	
 if(is_array($formdata["dest_forumsType"])){
     foreach($formdata["dest_forumsType"] as $frmType){
	if($frmType=="11" && trim($formdata["new_forumType"])==""){ 
 
    show_error_msg("קטגוריות הפורומים רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}	
   }
 }
 	
  if( trim($formdata["new_forumType"]!=null) && trim($formdata["new_forumType"]!=null) 
     &&  $formdata["dest_forumsType"][0]!="none" && $formdata["dest_forumsType"][0]!=null ){	
	  $name=$db->sql_string($formdata["new_forumType"]);
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
              		
              	$result = FALSE;  
              }	
      }	
	
	
	
    if(  ($formdata["new_forumType"]!="none") && trim($formdata["new_forumType"]!=null) 
       &&  (!$formdata["dest_forumsType"] || $formdata["dest_forumsType"]==null )  ){
	
	$name=$db->sql_string($formdata["new_forumType"]);
	 $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
              	 
               $result = FALSE; 
              }	
     }


     
if( ($formdata["new_dest_forumsType"]) && trim($formdata["new_forumType"]!=null) 
     &&  $formdata["dest_forumsType"]!="none" && $formdata["dest_forumsType"]!=null ){	
	  $name=$db->sql_string($formdata["new_forumType"]);
	   $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
              	$result = FALSE;  
              }	
      }	
	
	
	
    if( trim($formdata["new_forumType"] ) && trim($formdata["new_forumType"]!=null) 
        && (!$formdata['dest_forumsType'] || $formdata['dest_forumsType']==null ) ) {
	
	$name=$db->sql_string($formdata["new_forumType"]);
	 $sql = "SELECT COUNT(*) FROM categories1 " .
                  " WHERE catName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג פורומים בשם הזה");
              	 
               $result = FALSE; 
              }	
}




if( trim($formdata["new_forumType"]!="none") && trim($formdata["new_forumType"]!=null) 
       &&  is_numeric($formdata["new_forumType"])    ){
	  
			 show_error_msg('סוג פורומים לא חוקי:');
			    	       $result = FALSE; 
	  }	
/***************************************MANAGERS_TYPE****************************************************/
	
	if(  ( ($formdata["dest_managersType"])=="" ||  ($formdata["dest_managersType"]=='none')) 
	   && trim($formdata["new_managerType"])=="") {
    show_error_msg("חייב לשייך סוגי מנהלים");
    $result = FALSE; 
	}
	
 if(is_array($formdata["dest_managersType"])){
     foreach($formdata["dest_managersType"] as $managerType){
	if($managerType=="11" && trim($formdata["new_managerType"])==""){ 
 
    show_error_msg("קטגוריות המנהלים רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}	
   }
 }	
	
	
	
	if(  ($formdata["dest_managersType"])=="11" && trim($formdata["new_managerType"])==""){ 
 
    show_error_msg("סוגי מנהלים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}

	
if( trim($formdata["new_managerType"]) && trim($formdata["new_managerType"]!=null) 
   && $formdata["dest_managersType"] && $formdata["dest_managersType"]!=null  ){
	
	$name=$db->sql_string($formdata["new_managerType"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג מנהלים בשם הזה");
              	 
                $result = FALSE; 
              }	
}


if( trim($formdata["new_managerType"]) && trim($formdata["new_managerType"]!=null) 
   && (!$formdata["dest_managersType"] || $formdata["dest_managersType"]==null)  ){
	
	$name=$db->sql_string($formdata["new_managerType"]);
	 $sql = "SELECT COUNT(*) FROM manager_type " .
                  " WHERE managerTypeName=$name";
              if($db->querySingleItem($sql)>0) {
              		show_error_msg( "כבר קיימ סוג מנהלים בשם הזה");
              	 
                $result = FALSE; 
              }	
}	

/*****************************************************************************************/
/*************************************************************************************/	
	
	if(  (trim($formdata["appoint_forum"])=="" || trim($formdata["appoint_forum"]=='none')) 
	   && trim($formdata["new_appoint"])=="") {
    show_error_msg("חייב לשייך ממנה פורום");
    $result = FALSE; 
	}
	
	
	if(  trim($formdata["appoint_forum"])=="11" && trim($formdata["new_appoint"])==""){ 
 
    show_error_msg("ממנים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}
		
	if( $formdata["appoint_forum"] && trim($formdata["new_appoint"]!=null)  ){
		
    $id=$formdata['new_appoint'];
    if($id!=null){  
	$sql="SELECT appointName  from appoint_forum where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->appointName!=''){
//	 		UNSET($formdata['new_appoint']);
//            UNSET($_POST['form']['new_appoint']);
	   show_error_msg("כבר קיים ממנה אם שם כזה!");
	   $result = FALSE; 
	 }
	}
}

if( trim($formdata["new_appoint"] ) && trim ($formdata["new_appoint"]!=null) 
   && (!$formdata["appoint_forum"] || $formdata["appoint_forum"]!=null)   ){
		
    $id=$formdata['new_appoint'];
    if($id!=null){ 
	$sql="SELECT appointName  from appoint_forum where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->appointName!=''){
	 show_error_msg("כבר קיים ממנה אם שם כזה!");
	 $result = FALSE; 
	 }
	}
}	
/****************************************************************************************/	
	if(  (trim($formdata["manager_forum"])=="" || trim($formdata["manager_forum"]=='none')) 
	   && trim($formdata["new_manager"])=="") {
    show_error_msg("חייב לשייך מרכז פורום");
    $result = FALSE; 
	}
	
	
	if(  trim($formdata["manager_forum"])=="11" && trim($formdata["new_manager"])==""){ 
 
    show_error_msg("מנהלים בעין השופט רשומת אב אין לשייך אותה");
    $result = FALSE; 
	}	

	
if( $formdata["manager_forum"]  && trim($formdata["new_manager"]!=null) ){
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->managerName!=''){
//	 	    UNSET($formdata['new_manager']);
//            UNSET($_POST['form']['new_manager']);
	    show_error_msg("כבר קיים מנהל אם שם כזה!");
	 $result = FALSE; 
	 }
	}
}	


if( trim($formdata["new_manager"] ) && trim ($formdata["new_manager"]!=null) 
   && (!$formdata["manager_forum"] || $formdata["manager_forum"]==null)   ){
		
    $id=$formdata['new_manager'];
    if($id!=null){  
	$sql="SELECT managerName  from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql))
	 if($rows[0]->managerName!=''){
	show_error_msg("כבר קיים מנהל אם שם כזה!");
	 $result = FALSE; 
	 }
	}
}	

/****************************************************************************************/	


if($formdata['src_users']){
$src=explode(',',$formdata['src_users']);	
foreach($src as $row){
	
	if($row=='none'){
	    show_error_msg("בחר אופציה היא רשומת אב ולא שם משתמש");
       $result = FALSE;
		
	}
	
  }
}	


/********************************************************************************************/
if($formdata['dest_users']){
   foreach($formdata['dest_users'] as $key=>$val){ 
         	 
     if(  !(array_item($formdata['dest_users'] ,$formdata['deluser_Forum'])) 
     &&  $formdata['deluser_Forum']!='none' && $formdata['deluser_Forum']!=null){
	     $flag=true;
     } else 
	     $flag=false;  
    		
  }	
 if($flag){   
  show_error_msg("מבקש למחוק חבר לא קיים");
       $result = FALSE;
 }     
}	


    
if( !($formdata['dest_users']) && $formdata['deluser_Forum'] &&  $formdata['deluser_Forum']!='none' ){
	      show_error_msg("מבקש למחוק חבר לא קיים");
       $result = FALSE;
	
}	
/********************************************************************************************/
//if(  !($formdata['src_users']) && !($formdata['dest_users'])
//      && ($formdata['src_users'][0]!='none')  && ($formdata['dest_users'][0]!='none') 
//      &&   $formdata['deluser_Forum']=='none' &&  $formdata['adduser_Forum']=='none' ){
//      	 show_error_msg("בחר אופציה היא רשומת אב ולא שם משתמש");
//       $result = FALSE;
//      }   	
      
/*********************************************************************************************/
  
//	if(!empty($formdata['forum_status']) && ((!is_numeric($formdata['forum_status'])) || $formdata['forum_status']>1 || $formdata['forum_status']<0)) {
//    show_error_msg("סטטוס החלטה חייבת להיות   1 או 0  (או ריק).");
//    $result = FALSE; 
//	}	

   
//	if(!empty($formdata['forum_status']) && ((!is_numeric($formdata['forum_status'])) 
//	   || $formdata['forum_status']>1 || $formdata['forum_status']<0)
//	   || (trim($formdata["forum_status"] )==""  )) {
//    show_error_msg("סטטוס פורום חייבת להיות 1 או 0 ).");
//    $result = FALSE; 
//	}
/**************************************************************************************/
 $dst_usr=array();	
 $i=0;
 if(array_item($formdata,'forum_decID')   ){
$forumID=$formdata['forum_decID'];
 $sql="select * from rel_user_forum where forum_decID=$forumID";
 if($rows=$db->queryObjectArray($sql)){
 	foreach($rows as $row){
 		list($day_date_rel_date,$month_date_rel_date,$year_date_rel_date ) = explode('-',$row->HireDate);
     	        if (strlen($year_date_rel_date) < 3){
		           $row->HireDate="$year_date_rel_date-$month_date_rel_date-$day_date_rel_date";	
	    	    }else{
			       $row->HireDate="$day_date_rel_date-$month_date_rel_date-$year_date_rel_date";
	    	    }   
 		$forumUser_date[$row->HireDate] = $row->userID;
 		$forumUser_id[$row->userID] = $row->HireDate;
 	}
 	
 }
 
 }
 
 //for the name message
 if( (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
      &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
      && (count($dateIDs)==count($formdata['dest_users'])  )
      && array_item($formdata,'member_date0')) {
	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}
	
 	
	 

$i=0;	
    foreach($dateIDs as $daycomp) {
    	//if(array_item($forumUser_date, $daycomp)){
    		      
		   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      //} 
    }
      

      
      
      
      
      
 }elseif(is_array($dateIDs)   && (count($formdata['dest_users'])>0  )
 &&(! array_item($formdata,'member') && !array_item($formdata,'member_date0') ) ) {
$i=0;
 	foreach($formdata['dest_users'] as $key=>$val) {
     $dst_usr[$i]=$val;
     $i++;		   	
	}

	
$i=0;
	foreach($dateIDs as $daycomp) {
    	   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
	 
    }
 	
 
  
 
 
}elseif(  (is_array($dateIDs))  && (count($formdata['dest_users']>0 )) 
             &&( array_item($formdata,'member') && !is_numeric($formdata['member']) ) 
             && array_item($formdata,'member_date0')
		     && array_item($formdata,'dest_users')
		     &&  count($formdata['dest_users'])>0
             ){
  	
 if($formdata['src_usersID'] && $formdata['src_usersID']!=null ){
  	$i=0;	
    foreach($formdata['dest_users'] as $key=>$val){
  			
    	$dest_usr[$i]=$key;
    	
    	
  		$i++;	
  		}
  		$rel_dest=array_merge($formdata['src_usersID'],$dest_usr);
		 $rel_dest=array_unique($rel_dest);
  		
  		
  		
  }   
             	
/*************************************************************************************/             	
//$i=0;
// foreach($formdata['dest_users'] as $key=>$val){
// $member_date="member_date$i";	
// if(array_item($formdata , $member_date ) )
//   $usr_date[]=$formdata[$member_date];	
//  $i++;
// }
 //$usr_date=array_unique($usr_date);
 //if( count($usr_date) != count($formdata['dest_users']) &&   ) 
 
 
  $i=0;	
    foreach($dateIDs as $daycomp) {
     
		   	    if(!$frm-> DateSort($daycomp,$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך משתמש  " . $dst_usr[$i]. "  לפניי תאריך הקמת הפורום ");
		         $result = false;
		   	    }
		   	    $i++;
		      }          	
        }         	
  		       
   	       
/***********************************************************************************************************/
if( array_item($formdata,'appoint_date1') && $frm->check_date($formdata['appoint_date1'])  ){
  if(!$frm-> DateSort($formdata['appoint_date1'],$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך ממנה  לפניי תאריך הקמת הפורום ");
		         $result = FALSE;  
	    }
}     		
/*************************************************************************************/	
if( array_item($formdata,'manager_date') && $frm->check_date($formdata['manager_date'])  ){
	    if(!$frm-> DateSort($formdata['manager_date'],$frm_date)){  	
		         show_error_msg("אי אפשר להזין תאריך מנהל לפניי תאריך הקמת הפורום "); 
		         $result = FALSE; 
	    } 
} 		
/*************************************************************************************/
     	// now we are ready to turn this hash into JSON
     	
//		print json_encode($response);
//		exit; 				
			return $result;
	}
 
/**********************************************************************************************/
/**********************************************************************************************/
	
function update_forum1(&$formdata,$formselect,$appointsIDs,$managersIDs){
global $db;



/**********************************************************************************/
		     $forum_allowed = $formdata['forum_allowed'];
		     
		     if($formdata['forum_allowed']==1)
				$forum_allowed= 'public';
				elseif($formdata['forum_allowed']==2 )
				$forum_allowed= 'private';
				elseif($formdata['forum_allowed']==3 )
				$forum_allowed= 'top_secret';
				
			//  $forum_allowed=$db->sql_string($forum_allowed);
/**********************************************************************************/	



$dates = getdate();
  $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
  $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);
    
  $today= $this->build_date5($dates); 
  $formdata['today']=$today['full_date'];
  
   
  
   list($day_date_appoint,$month_date_appoint,$year_date_appoint ) = explode('-',$formdata['appoint_date1']);
   if( array_item($formdata, 'appoint_date1') 
   &&  !($this->check_date($formdata['appoint_date1']))  ){ 
          $formdata['appoint_date1']=$today['full_date'];
            
        }
  

   
  list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$formdata['manager_date']);
   if( array_item($formdata, 'manager_date') &&    !$this->check_date($formdata['manager_date'])){ 
          $formdata['manager_date']=$today['full_date'];
          
        }
        
  
   
 list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$formdata['forum_date']);
	 if (strlen($year_date_appoint) > 3){
		$forum_date="$year_date_forum-$month_date_forum-$day_date_forum";	
		}else{
			$forum_date="$day_date_forum-$month_date_forum-$year_date_forum";
			//to check
			$formdata['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";
		} 
     
        
  list($day_date_appoint,$month_date_appoint,$year_date_appoint ) = explode('-',$formdata['appoint_date1']);
	 if (strlen($year_date_appoint) > 3){
		$appoint_date="$year_date_appoint-$month_date_appoint-$day_date_appoint";	
		}else{
			$appoint_date="$day_date_appoint-$month_date_appoint-$year_date_appoint";
			//to check
			$formdata['appoint_date1']="$year_date_appoint-$month_date_appoint-$day_date_appoint";
		}
					
	list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$formdata['manager_date']);
     if (strlen($year_date_manager) > 3){
		$manager_date="$year_date_manager-$month_date_manager-$day_date_manager";
		}else{
			$manager_date="$day_date_manager-$month_date_manager-$year_date_manager";
			//to check
			$formdata['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";
		}	

   if($forum_decID = array_item($formdata, "forum_decID")) {
    $manager_formdata=$formdata['manager_forum'];
    $manager_formselect=$formselect['manager_forum'];
    $appoint_formdata=$formdata['appoint_forum'];
    $appoint_formselect=$formselect['appoint_forum'];
    
    
    
    
    if(array_item($formdata,'insertID') && (is_numeric(array_item($formdata,'insertID')))
   && array_item($formdata,'insert_forum') && (is_numeric(array_item($formdata,'insert_forum')))  ){
   	$formdata['insertID']=$formdata['insert_forum'];
   	unset($formdata['insert_forum']);
  }
  
//--------------------------------------------------------------------------------
  	  
  if($manager_formdata!=$manager_formselect && $mID){
  	$mID=$manager_formselect;
  	$sql="SELECT manager_date FROM forum_dec WHERE managerID=$mID  AND forum_decID=$forum_decID  ";
  	if($rows=$db->queryObjectArray($sql)){
  	$mDate=$rows[0]->manager_date;
  	
  	list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$mDate);
     if (strlen($year_date_manager) < 3){
			$mDate="$year_date_manager-$month_date_manager-$day_date_manager";
		}else{
				$mDate="$day_date_manager-$month_date_manager-$year_date_manager";
			
		}	
	//	if(!$this->  DateSort($formdata['manager_date'],$mDate)){
  if($formdata['manager_date']== $mDate ){
  		$formdata['manager_date']=$formdata['today'];
  	
  	}
  	
  	
list( $day_date_manager,$month_date_manager,$year_date_manager) = explode('-',$formdata['manager_date']);
     if (strlen($year_date_manager) > 3){
		$manager_date="$year_date_manager-$month_date_manager-$day_date_manager";
		}else{
			$manager_date="$day_date_manager-$month_date_manager-$year_date_manager";
			//to check
			$formdata['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";
		}	

  }
 }  
//--------------------------------------------------------------------------------   
    $sql = "UPDATE forum_dec SET " .
       " forum_decName="     .  $db->sql_string($formdata["forum_decName"]) . ", " .
       " active="      .  $db->sql_string($formdata["forum_status"]) . " , " .
       " forum_allowed="      .  $db->sql_string($forum_allowed) . " , "  .
       " forum_date="    .  $db->sql_string($forum_date) . " , " .
       " appoint_date="      .  $db->sql_string($appoint_date) . " , " .
       " manager_date="      .  $db->sql_string($manager_date) . " , " ;
       
//---------------------------------------------------------------------------------------------------    
    if ( ($manager_formdata!=$manager_formselect || $appoint_formdata!=$appoint_formselect) )   
      $sql.=  " parentForumID=" .  $this->num_or_NULL($formdata["insertID"]) . ", " ;
     else 
      $sql.=  " parentForumID=" .  $this->num_or_NULL($formdata["insertID"]) . "  " ;
     
//---------------------------------------------------------------------------------------------------    
      if ($manager_formdata!=$manager_formselect &&  $appoint_formdata!=$appoint_formselect){ 
         
        if($manager_formselect!=null )	
        $this->config_beforeMgr_update($formdata,$formselect);
        
        
       if($formdata["manager_forum"] && $formdata["manager_forum"]!='none')
          $sql.=  " managerID=" .  $this->num_or_NULL($formdata["manager_forum"]) . " , "  ;
       else
          $sql.=  " managerID=" .  $this->num_or_NULL($managersIDs) . " , " ;
       
//---------------------------------------------------------------------------------------------------       
   }elseif ($manager_formdata!=$manager_formselect &&  $appoint_formdata==$appoint_formselect){ 
          
   	      if($manager_formselect!=null)
   	      $this->config_beforeMgr_update($formdata,$formselect);
   	      
       if($formdata["manager_forum"] && $formdata["manager_forum"]!='none')
          $sql.=  " managerID=" .  $this->num_or_NULL($formdata["manager_forum"]) . "   "  ;
       else
          $sql.=  " managerID=" .  $this->num_or_NULL($managersIDs) . "   " ;}   

//---------------------------------------------------------------------------------------------------       
       
   if ($appoint_formdata!=$appoint_formselect ){
   	
        if($appoint_formselect!=null)   	
        $this->config_beforeAppoint_update($formdata,$formselect);
        
        
       if($formdata["appoint_forum"] && $formdata["appoint_forum"]!='none')
          $sql.=  " appointID=" .  $this->num_or_NULL($formdata["appoint_forum"]) . "  "  ;
       else
          $sql.=  " appointID=" .  $this->num_or_NULL($appointsIDs) . "  " ;
   }   
//---------------------------------------------------------------------------------------------------   
 $sql.=  " WHERE forum_decID=$forum_decID";
 if(!$db->execute($sql))
       RETURN FALSE;
       
       
       
/************************************************************************/       
if($manager_formselect)
$this-> delmgr_taskOrtag($manager_formdata,$manager_formselect,$forum_decID);



      
       
       
/***********************************************************************************************/   
 /*
$query = "set foreign_key_checks=0";
$query1 = "set foreign_key_checks=1";
 if(   $db->execute($query) ){     
       if(!$db->execute($sql)){
			
		 $db->execute($query1);
		 return FALSE;
       }
      	 $db->execute($query1); 	
 }   */		
/********************************SRC_USERS*******************************************************/	    
$this-> del_taskOrtag($forum_decID,$formdata,$formselect);
	
 
 
 
 if($formdata['src_usersID'] && array_item($formdata,'src_usersID')) {
		if(is_array($formdata['src_usersID'])) {
		$stuff= implode(',', $formdata['src_usersID'] );
		$sql="select userID,full_name from users where userID in($stuff)";
		}
 
		
		
		 if($rows1=$db->queryObjectArray($sql)){

		 $i=0;
		 	foreach($rows1 as  $row1){
		     $src[$row1->userID]=$row1->full_name;
		     $id_usr[$i]=$row1->userID;
		     $i++;
		}
		 $formdata['src_users1']=$src;
		 $formdata['src_users2']=$src;//stay origianly assoc
		 $id_usr=implode(',',$id_usr);
	}
	
	$sql="select r.userID,r.HireDate from rel_user_forum r
           where r.userID in($id_usr)
            and r.forum_decID=$forum_decID	";
     if($rows=$db->queryObjectArray($sql)){
          foreach($rows as $row){
          	
          	$usr_id_date[$row->userID]=$row->HireDate;
          	
          }	
         $formdata['usr_id_date']=$usr_id_date; 
     }	
    	
  }

/****************************DELLTE_SRC*************************************************************/
/*  $forum_decID=$forum_decID?$forum_decID:$formdata['forum_decision'];
  if( !array_item($formdata,"dest_users$forum_decID")  ){		 
	 if    ( (array_item($formdata,'src_users1')) 
	    && ! (array_item($formdata,'dest_users')) ){
           
	    	
	    foreach($formdata['src_users1'] as $key=>$val)	{
	    	$tags = get_user_tags($key,$forum_decID);
	      
              if($tags && $tags[0] !=null) {
	         	$s = implode(',', $tags);
	         	if($s && $s!=null){
        		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
	         	}
		        $db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
	          }  

	           $sql="select * from rel_user_task where userID=$key  AND forum_decID=$forum_decID";
	              if($rows=$db->queryObjectArray($sql)){
	    	         $sql = "DELETE FROM rel_user_task WHERE userID=$key 
		   	          AND forum_decID=$forum_decID";
		       $db->execute($sql);
	    	
	         }      
	    }
		 if( $db->execute("set foreign_key_checks=0") )  {
		    foreach($formdata['src_users1'] as $key=>$val){   
		 	$sql = "DELETE FROM rel_user_forum WHERE userID=$key
		 	        AND forum_decID=$forum_decID ";
		    $db->execute($sql);
		    }	
           if(!$db->execute("set foreign_key_checks=1"))
               RETURN FALSE;
               
            
               
		}   
	}elseif(array_item($formdata,'src_users1') && (array_item($formdata,'dest_users')) ){
	     foreach($formdata['dest_users'] as $key=>$val){ 
		    if(array_item($formdata['src_users1'],$key)){
		     unset($formdata['src_users1'][$key]);	
		    }
	     } 
	     
	   //found new user  
	if(is_array($formdata['src_users1']) && count($formdata['src_users1'])>0 ){    
       foreach($formdata['src_users1'] as $key=>$val){ 	    
	    if( $db->execute("set foreign_key_checks=0") )  {
	    	$tags = get_user_tags($key,$forum_decID);
	 
              if($tags && $tags[0] !=null) {
	         	$s = implode(',', $tags);
        		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		        $db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
	          }

	    $sql="select * from rel_user_task where userID=$key  AND forum_decID=$forum_decID";
	    if($rows=$db->queryObjectArray($sql)){
	    	$sql = "DELETE FROM rel_user_task WHERE userID=$key 
		   	          AND forum_decID=$forum_decID";
		    $db->execute($sql);
	    	
	    }      
		   	$sql = "DELETE FROM rel_user_forum WHERE userID=$key 
		   	          AND forum_decID=$forum_decID";
		    $db->execute($sql);
		    }	
		    
if($rows){ 
		  foreach($rows as $row){
		  	$taskID=$row->taskID;
		  	$sql = "DELETE FROM todolist WHERE taskID=$taskID"; 
		   	          
		    $db->execute($sql);
		  	
		  	
		  }  
}		    
		    
		    
        	if(!$db->execute("set foreign_key_checks=1"))
               RETURN FALSE;

                      
               
		}   
	  } 
		
	}
  }else{
  	
   if    ( (array_item($formdata,'src_users1')) 
	    && ! (array_item($formdata,"dest_users$forum_decID")) ){
           
	    	
	    foreach($formdata['src_users1'] as $key=>$val)	{
	    	$tags = get_user_tags($key,$forum_decID);
	      
              if($tags && $tags[0] !=null) {
	         	$s = implode(',', $tags);
	         	if($s && $s!=null){
        		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
	         	}
		        $db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
	          }  

	           $sql="select * from rel_user_task where userID=$key  AND forum_decID=$forum_decID";
	              if($rows=$db->queryObjectArray($sql)){
	    	         $sql = "DELETE FROM rel_user_task WHERE userID=$key 
		   	          AND forum_decID=$forum_decID";
		       $db->execute($sql);
	    	
	         }      
	    }
		 if( $db->execute("set foreign_key_checks=0") )  {
		    foreach($formdata['src_users1'] as $key=>$val){   
		 	$sql = "DELETE FROM rel_user_forum WHERE userID=$key
		 	        AND forum_decID=$forum_decID ";
		    $db->execute($sql);
		    }	
           if(!$db->execute("set foreign_key_checks=1"))
               RETURN FALSE;
               
            
               
		}   
	}elseif(array_item($formdata,'src_users1') && (array_item($formdata,"dest_users$forum_decID")) ){
	     foreach($formdata["dest_users$forum_decID"] as $key=>$val){ 
		    if(array_item($formdata['src_users1'],$key)){
		     unset($formdata['src_users1'][$key]);	
		    }
	     } 
	     
	   //found new user  
	if(is_array($formdata['src_users1']) && count($formdata['src_users1'])>0 ){    
       foreach($formdata['src_users1'] as $key=>$val){ 	    
	    if( $db->execute("set foreign_key_checks=0") )  {
	    	$tags = get_user_tags($key,$forum_decID);
	 
              if($tags && $tags[0] !=null) {
	         	$s = implode(',', $tags);
        		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		        $db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
	          }

	    $sql="select * from rel_user_task where userID=$key  AND forum_decID=$forum_decID";
	    if($rows=$db->queryObjectArray($sql)){
	    	$sql = "DELETE FROM rel_user_task WHERE userID=$key 
		   	          AND forum_decID=$forum_decID";
		    $db->execute($sql);
	    	
	    }      
		   	$sql = "DELETE FROM rel_user_forum WHERE userID=$key 
		   	          AND forum_decID=$forum_decID";
		    $db->execute($sql);
		    }	
        	if(!$db->execute("set foreign_key_checks=1"))
               RETURN FALSE;

          
               
		}   
	  } 
		
	}
  	
  }	
  */
  
  
/*****************************/
  }//end if $forum_decID    /*
/*****************************/  
  
/*****************************FORUMS_TYPE*****************************************************/   
	$forum_decID=$forum_decID?$forum_decID:$formdata['forum_decision'];	    
	 if($formdata['src_forumsType']){
	 	$cat=$formdata['src_forumsType'];
	 	if(is_array($cat) && is_numeric($cat[0]) ){
	 		foreach($cat as $key=>$val){
		$sql = "DELETE FROM rel_cat_forum WHERE forum_decID=$forum_decID  AND catID=$val ";
		if(!$db->execute($sql))
		return FALSE;
	 	}
	 } 
}
/*****************************MANAGERS_TYPE*****************************************************/   
	$forum_decID=$forum_decID?$forum_decID:$formdata['forum_decision'];	    
	 if($formdata['src_managersType']){
	 	$cat=$formdata['src_managersType'];
	 	if(is_array($cat) && is_numeric($cat[0])){
	 		foreach($cat as $key=>$val){
		$sql = "DELETE FROM rel_managerType_forum WHERE forum_decID=$forum_decID  AND managerTypeID=$val ";
		if(!$db->execute($sql))
		return FALSE;
	 	}
	 }  
}
/************************************************************************************/		

		
		
		return $formdata['forum_decID'];
}


/***************************************************************************************************/
	//update a new category in the categories table
	//======================================================
	// returns -1, if error
	//         1,  if category could be saved
	//         0,  if category could not be saved
	function update_forum_general(){
		$mode='update';
		$updateID=$this->updateID;
		$submitbutton=$this->submitbutton;
		$subcategories=$this->subcategories;
		global $db;
			
		$sql = "SELECT COUNT(*) FROM forum_dec WHERE forum_decID='$updateID'";
		$n = $db->querySingleItem($sql);

		// if url had valid updateID, show this category and
		// an input form for new subcategories
		if($updateID && $n==1) {
			
          $this->link_div(); 
			// if there is form data to process, update new
			// subcategories into database
	 echo '<fieldset class="my_pageCount" >';				
			if($subcategories) {
				$db->execute("START TRANSACTION");
				if($this->update_forums($updateID, $subcategories,$mode))
				$db->execute("COMMIT");
				else
				$db->execute("ROLLBACK"); 
			}

			
	if(array_item($_POST, 'submitbutton'))
			$str=array_item($_POST, 'submitbutton');
			else 
			$str='שמור';	
          if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST, 'submitbutton')==$str)){
          	echo "<h1>עדכן שם פורום</h1>\n";       		
			$this->print_forum_entry_form_d ($updateID,$mode);
          }   
		  echo '</fieldset>';
//		  $formdata=FAlSE;
//           build_form($formdata);
//	       $this->print_form_paging_b();
		   				
		}


	}
//===================================================================================
	function update_forums($updateID, $subcategories,$mode='') {
//===================================================================================		
		global $db;
		$subcatarray = explode(";", $subcategories);
		//$subcat=$subcategories;
		$count = 0;
		foreach($subcatarray as $newdecname) {
			$result =$this->update_new_forum($updateID, trim($newdecname));
			if($result == -1) {
				echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
				return FALSE; }
				elseif($result)
				$count++;
		}
		if($count)
		if($count==1)
		echo "<p class='error'>פורום עודכן.</p>\n";
?>     
<script type="text/javascript">

turn_red_error();
</script>  
<?php
			
		return TRUE;
	}
//===================================================================================
	function update_new_forum($updateID, $newdecName) {
//===================================================================================
		global $db;
		// test if newcatName is empty
		if(!$newdecName) return 0;
		$newdecName = $db->sql_string($newdecName);

		//  // test if newcatName already exists
		//  $sql = "SELECT COUNT(*) FROM forums " .
		//         "WHERE forum_decID=$updateID " .
		//         "  AND decName=$newdecName";
		//  if($db->querySingleItem($sql)>0) {
		//  	echo " כבר קיימת החלטה בשם הזה";
		//    return 0;
		//  }

		// update category
		$sql = "update  forum_dec set forum_decName=$newdecName where forum_decID=$updateID " ;
		// "VALUES ($newcatName, $insertID)";
		if($db->execute($sql))
		return 1;
		else
		return -1;
	}
//===================================================================================	
	function update_parent($insertID, $forum_decID) {
//===================================================================================		
		global $db;
	    $sql="UPDATE forum_dec set parentForumID=$insertID WHERE forum_decID=$forum_decID "; 	
	    if(!$db->execute($sql))
	    return FALSE; 
	    return TRUE; 
	}	
//===================================================================================
	function update_parent_b($insertID, $forum_decID) {
//===================================================================================		
		global $db;
	    $sql="UPDATE forum_dec set parentForumID=$insertID WHERE forum_decID=$forum_decID "; 	
	    if(!$db->execute($sql))
	    return FALSE; 
	  
 	    $this->print_forum_entry_form_c($forum_decID);
	   
	    exit;
	    
	}	
//===================================================================================
	function insert_forum($formdata)
//===================================================================================	
	{
		$dec= explode(";", $formdata["newforum"]);
		global $db;
		// insert new forum
		//==============================================================
		$sql = "INSERT INTO forum_dec ( forum_decName,parentForumID " .
         "active,forum_date) VALUES (" .
		$db->sql_string($formdata["forum_decName"]) . ", " .
		$db->ID_or_NULL($formdata["parentForumID"]) . ", " .
		$this->num_or_NULL($formdata["active"]) . "," .
		$this->num_or_NULL($formdata["forum_date"]) . " ) " ;

		if(!$db->execute($sql))
			
		return FALSE;

		return  $db->insertId();
	
	}
/************************************************************************************************/	               
function add_forum(&$formdata="",&$appointsIDs="",&$managersIDs="",&$catIDs="",&$catTypeIDs="",
                   &$dateIDs="",&$appointdateIDs="",&$managerdateIDs=""){
/************************************************************************************************/		
	    global $db;	
		 
		if ($formdata['insertID'] && !$formdata['insert_forum'] && !is_numeric($formdata['insert_forum']) && !is_array($formdata['insert_forum']) )
		$insertID=$formdata['insertID'];
		
		elseif($_GET['insertID'] && !$formdata['insert_forum'] && !is_numeric($formdata['insert_forum']) && !is_array($formdata['insert_forum']))
		$insertID=$this->insertID;
		
		elseif($formdata['insert_forum'] && (is_numeric($formdata['insert_forum'][0])) &&  is_array($formdata['insert_forum'])  ){
		$insertID=$formdata['insert_forum'];	
		
		}elseif(array_item ($formdata,'insert_forum') && (is_numeric($formdata['insert_forum'])) 
		       &&  !is_array($formdata['insert_forum']) && array_item ($formdata,'insertID') && (is_numeric($formdata['insertID'])) ){
		$insertID=$formdata['insert_forum'];	
		unset($formdata['insertID']);
		}elseif(array_item ($formdata,'insert_forum') && (is_numeric($formdata['insert_forum'])) &&  !is_array($formdata['insert_forum'])  ){
		$insertID=$formdata['insert_forum'];	
		
		}elseif(!is_array($formdata['insert_forum'])){
		$insertID='11';
		$formdata['insertID']='11';
		}
		
		
		if($formdata['forum_decision']!='11' && !($formdata['newforum']) ){
		$this->forum_decID=$formdata['forum_decision'];
		$formdata['forum_decID']=$formdata['forum_decision'];
		}
		if($formdata['submitbutton'])
		$submitbutton=$formdata['submitbutton'];
		else
		$submitbutton=$this->submitbutton;
		
        
		
		if($formdata['newforum']  && $formdata['newforum']!='none'){
		$subcategories=$formdata['newforum'];
		}elseif($formdata['forum_decision'] && is_array($formdata['forum_decision']) ){	
	        foreach($formdata['forum_decision'] as $forum)	{	
 			$sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID = " .
 				$db->sql_string($forum);
         			if($rows = $db->queryObjectArray($sql) )
 		        	$subcategories[]=$rows[0]->forum_decName;
	        	}
		}elseif($formdata['forum_decision'] && !is_array($formdata['forum_decision']) ){	
	        $forum=$formdata['forum_decision'];	
 			$sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID =$forum " ;
 			
 			if($rows = $db->queryObjectArray($sql))
 			$subcategories[]=$rows[0]->forum_decName;
	         
		}
		//if(!($formdata['dynamic_12']) &&  !($formdata['dynamic_ajx']) ){
			if(!($formdata['dynamic_ajx']) ){	
			 echo "<h1>הוסף/עדכן פורום חדש</h1>\n";
		}
			// if there is form data to process, insert new
			// subcategories into database
			if($subcategories) {
				$db->execute("START TRANSACTION");
     		       if($formdata['dynamic_6']==1){

  //for dynamic_6       
      if($this->insert_new_forums1($formdata ,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,$dateIDs,$appointdateIDs,$managerdateIDs)){
				  
					$db->execute("COMMIT");
				}else{
					$db->execute("ROLLBACK");
                     return FALSE; 
				}

	  }elseif($formdata['dynamic_8']==1  || ($formdata['dynamic_9']==1
	           || $formdata['dynamic_10']==1 || $formdata['dynamic_12']==1  
	    
	    && array_item($formdata,'dest_users') && is_array($formdata['dest_users']))){ 
                if($this->insert_new_forums($insertID, $subcategories,$formdata ,$appointsIDs,$managersIDs,
				    $catIDs,$catTypeIDs,$dateIDs)){

					$db->execute("COMMIT");
				}else{
					$db->execute("ROLLBACK");
                     return FALSE; 
				}
				
			}elseif($formdata['dynamic_8']==1  || ($formdata['dynamic_9']==1
	           || $formdata['dynamic_10']==1 || $formdata['dynamic_12']==1  )){ 
                if($this->insert_new_forums($insertID, $subcategories,$formdata ,$appointsIDs,$managersIDs,
				    $catIDs,$catTypeIDs,$dateIDs)){

					$db->execute("COMMIT");
				}else{
					$db->execute("ROLLBACK");
                     return FALSE; 
				}
				
			}else{//for dynamic_6b
			 if($this->insert_new_forums2($formdata ,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,$dateIDs,$appointdateIDs,$managerdateIDs,$form)){
                   $this->print_forum_paging_b();
					$db->execute("COMMIT");
				}else{
					$db->execute("ROLLBACK");
                     return FALSE; 
				}
			}
	   }  

		return  true;
			
	}
/*************************************UPDATE AREA**********************************************/


	// insert new subcategories to given category
	
	function insert_new_forums($insertID, $subcategories,&$formdata,&$appointsIDs="",&$managersIDs="",&$catIDs="",&$catTypeIDs="",$dateIDs=""){
		global $db;
         $frm=new forum_dec(); 
		$size_of_array_date = count($dateIDs['full_date']);
        $size_of_array_users = count($usersIDs); 
        $size_of_dest_users = count($formdata['dest_users']);
       
	
         $dates = getdate();
         $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
         $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);
    
         $today= $this->build_date5($dates); 
	   	
/**********************************************************************************/
		     $status      =  $formdata['forum_status'];
/**********************************************************************************/
		     $forum_allowed = $formdata['forum_allowed'];
		     
		     if($formdata['forum_allowed']==1)
				$forum_allowed= 'public';
				elseif($formdata['forum_allowed']==2 )
				$forum_allowed= 'private';
				elseif($formdata['forum_allowed']==3 )
				$forum_allowed= 'top_secret';
				
			  $forum_allowed=$db->sql_string($forum_allowed);
/**********************************************************************************/		     
             
		     $forumType=$catIDs;
/*********************************************************************************/					 	 
		     $appoint=$appointsIDs; 
/************************************************************************************/
			 $manager=$managersIDs;
/***********************************************************************************/		     
			 $managerType=$catTypeIDs;			
/**********************************************************************************/
			 
$formdata['insert_forum']=$insertID;
			 
if(!$this->check_date($formdata['forum_date']))
 $formdata['forum_date']=$tooday;
 
list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$formdata['forum_date']);
	
	 if (strlen($year_date_forum) < 3){
		$formdata['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
		}elseif(strlen($day_date_manager)==4){
     $formdata['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";	
    }	
$forum_date=$db->sql_string($formdata['forum_date']);			 
		     



/************************************************************************************/		     		     


if(!$this->check_date($formdata['appoint_date1']))
 $formdata['appoint_date1']=$tooday;
 
list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$formdata['appoint_date1']);
	
	 if (strlen($year_date_appoint) < 3){
		$formdata['appoint_date1']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
		}elseif(strlen($day_date_manager)==4){
     $formdata['appoint_date1']="$day_date_appoint-$month_date_appoint-$year_date_appoint";	
    }	
$appoint_date=$db->sql_string($formdata['appoint_date1']);			 



/**********************************************************************************/						 

if(!$this->check_date($formdata['manager_date']))
 $formdata['manager_date']=$tooday;			 
list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$formdata['manager_date']);
	
	 if (strlen($year_date_manager) < 3){
		$formdata['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
		}elseif(strlen($day_date_manager)==4){
     $formdata['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";	
    }	
$manager_date=$db->sql_string($formdata['manager_date']);			 
/**********************************************************************************/
             
            if($formdata['forum_decID']) 
            $forum_decID=$formdata['forum_decID']; 	
           
		
			$result =$this->insert_new_forum($insertID,trim($subcategories),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$managerType,$status,$forum_allowed,$formdata);
			
			if($result == -1) {
				echo "<p>טעות - שים לב כלום לא נישמר!.</p>\n";
				return FALSE;
			}elseif ($result){
/********************************************************************************************/
				if(!$forum_decID){
				 $forum_decID=$db->insertId();
				}
				

/*******************************CONN AREA***************************************************/
		 
					$this->conn_cat_forum($forum_decID,$catIDs,$formdata);
/**********************************************************************************/
			
			 
		$this->conn_type_manager($forum_decID,$catTypeIDs);		
		//if($type_manager_idx==$size_of_array_cat_manager) $type_manager_idx=$size_of_array_cat_manager-1;
			// $managerType=$catTypeIDs [$type_manager_idx];  
			
/**********************************************************************************/				
					

	if(array_item($formdata,'dest_users') && count($formdata['dest_users'])>0 ){				
           
		$usersIDs=$formdata['dest_users'];   
		 
		$this->conn_user_forum_test($forum_decID,$usersIDs,$dateIDs,$formdata['today'],$formdata);				
	}
/***********************************************************************************/					
	//if(!($formdata['dynamic_12']) &&  !($formdata['dynamic_ajx']) ){
	if(!($formdata['dynamic_ajx']) ){		
	         $this->message_save_c(trim($subcategories),$forum_decID);
	}		
				$formdata['subcategories']=trim($subcategories);
				$form=$formdata;
				 
				if(  ($formdata['newforum'] && $formdata['newforum']!='none')
				   || ($formdata['new_name'] &&  $formdata['forum_decID']  )  ) {
//                $frm_name=$db->sql_string($formdata['newforum']) ;
//				$sql="UPDATE forum_dec set forum_decName=$frm_name  where forum_decIDID=$forum_decID ";
//				if(!$db->execute($sql) ){return False; }   	
				$form['forum_decision']=$forum_decID;//$formdata['forum_decID'];
				$form['forum_decID']=$forum_decID;
	            $formdata['forum_decID']=$forum_decID;  
			    }
				else{
				$form['forum_decision']=$formdata['forum_decision'];
				$formdata['forum_decID']=$forum_decID;
				}
/******************************************************************************************/
				$form['manager_forum']=$manager;
		 
/******************************************************************************************/
				$form['appoint_forum']=$appoint;
		    
/******************************************************************************************/
				$form['dest_managersType']=$managerType ;
					
/********************************************************************************************/
				 
				$form['dest_forumsType']=$forumType ;
					
/********************************************************************************************/
				$form['forum_status']=$status  ;
/********************************************************************************************/
				$formdata['new_name']=$formdata['newforum'];
/********************************************************************************************/	
list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$form['forum_date']);
	
	 if (strlen($year_date_forum) > 3){
		$form['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
		}elseif(strlen($day_date_appoint)==4){
     $form['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";	
    }	
/***********************************************************************************/						
list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$form['appoint_date1']);
	
	 if (strlen($year_date_appoint) > 3){
		$form['appoint_date1']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
		}elseif(strlen($day_date_appoint)==4){
     $form['appoint_date1']="$year_date_appoint-$month_date_appoint-$day_date_appoint";	
    }	
/***********************************************************************************/
list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$form['manager_date']);
	
	 if (strlen($year_date_manager) > 3){
		$form['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
		}elseif(strlen($day_date_manager)==4){
     $form['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";	
    }	
/************************************************************************************************/
				 
				unset($form['newforum']);
				unset($form['new_forumType']);
				unset($form['new_appoint']);
				unset($form['new_manager']);
				unset($form['new_managerType']);
/***********************************************************************************************/
							if($form['multi_day']  ){
							    unset($form['multi_day']);
							}
							if($form['multi_month']  ){
							   unset($form['multi_month']);
							}
							if($form['multi_year']  ){
								unset($form['multi_year']);
							 }	  
							 
					
/***********************************************************************************************/									  
	
				unset($_SESSION['forum_decID']);
				$_SESSION['forum_decID']=$form['forum_decID'];
				 
//				if(!($formdata['dynamic_ajx']) ){	
//				$this->print_forum_entry_form1($forum_decID);
//				}
				if($formdata[dynamic_8])
				build_form($form);

				
if($formdata[dynamic_9]){
		   
                	
                	
               //   $form['forum_decName'] = $form['subcategories'];	
//                 $form['type'] = 'success';
// 	             $form['message'] = 'עודכן בהצלחה!';
 	             
 	            if(!($form['dynamic_ajx']==1)){ 
                  build_form_ajx7($form);
                $frm->print_forum_paging_b();
 	            }else{
/***************************DYNAMIC_9_TO_AJAX*****************************************************/
/******************************************************************************************/				
$i=0; 	
		if($form['dest_users'] && is_array($form['dest_users']) && is_array($dest_users)){
			
		foreach($dest_users as $key=>$val){
		if(is_numeric($val)){	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 

     
		     $form["dest_user"]=$results; 
 }elseif($form['dest_users'] && is_array($form['dest_users']) && !(is_array($form['dest_users'][0]))  ){
			 
		foreach($form['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select userID,full_name  from users where userID=$key";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		   } 
		    
		       
        }
		 
		     $form["dest_user"]=$results; 
 } elseif($form['dest_users'] && is_array($form['dest_users'][0])  ){
 	$form["dest_user"]=$form["dest_users"];
 	$form['add_frmID']=1;
 }
		   		          	
/**********************************************************************************************************************/
//for check the length
	 $i=0; 	
		if($form['src_usersID'] && is_array($form['src_usersID'])   ){
			 
		foreach($form['src_usersID'] as $key=>$val){
	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		       
        }
		 

     }
		     $form["src_user"]=$results1; 
 }else{
 	$form["src_user"]=$form["dest_user"];
 }
/***********************************************************************/		   		          			 
/***********************FORUMSTYPE**********************************************/
if(!(is_array($form['dest_forumsType'])))
$form['dest_forumsType']=explode(',', $form['dest_forumsType']);
 
 $i=0; 	
		if($form['dest_forumsType'] && is_array($form['dest_forumsType'])  ){
			
		foreach($form['dest_forumsType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select catID,catName  from categories1 where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$form['dest_forumsType']=$results_cat_frm;
}
/*************************************MANAGER_TYPE*****************************************************************/
if(!(is_array($form['dest_managersType'])))
$form['dest_managersType']=explode(',', $form['dest_managersType']);
  $i=0; 	
		if($form['dest_managersType'] && is_array($form['dest_managersType'])  ){
			
		foreach($form['dest_managersType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$form['dest_managersType']=$results_cat_mgr;
}
/******************************************************************************************************/


$manageID=$form['manager_forum'];
$sql="select managerName from managers where managerID=$manageID";
if($rows=$db->queryObjectArray($sql)){
	$form['managerName']=$rows[0]->managerName;
}		 
/**********************************************************************/ 		   		          	
$appID=$form['appoint_forum'];
$sql="select appointName from appoint_forum where appointID=$appID";
if($rows=$db->queryObjectArray($sql)){
	$form['appointName']=$rows[0]->appointName;
}		 
/**********************************************************************/ 
 $sql="select forum_decName  from forum_dec where forum_decID=$forum_decID  ";
		if($rows=$db->queryObjectArray($sql)){
		$form['forum_decName']=$rows[0]->forum_decName; 
		}
	$db->execute("COMMIT");
	
 
    $form['type'] = 'success';
	$form['message'] = 'עודכן בהצלחה!';
     echo json_encode($form);
 	  exit;	
			 
 	            	
/**********************************************************************************/ 	            	
 	  }//end else
}//end if dynamic_9
/***************************************************************************/                
if($formdata[dynamic_10]){
                	
                
		 
		 $i=0; 	
		if($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
		foreach($formdata['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select userID,full_name  from users where userID=$key  ";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		  }
		  
	  }
   }
  $form["dest_user"]=$results;
  
  
$i=0;
foreach($formdata['dest_users'] as $key=>$val){
	$sql="select active  from rel_user_forum where userID=$key and forum_decID=$forum_decID ";
if($rows=$db->queryObjectArray($sql)){
	
	$form['active'][$key]=$rows[0]->active;
	$i++;
  }
 }
  
		     
 }
		   
                	
                	
                	
                 $form['type'] = 'success';
 	             $form['message'] = 'עודכן בהצלחה!';
 	             
 	            if(!($form['dynamic_ajx']==1)){ 
                  build_form_ajx7($form);
                $frm->print_forum_paging_b();
 	            }else{
 	            	
/***************************DYNAMIC_9_TO_AJAX*****************************************************/
/******************************************************************************************/				
$i=0; 	
		if($form['dest_users'] && is_array($form['dest_users']) && is_array($dest_users)){
			
		foreach($dest_users as $key=>$val){
		if(is_numeric($val)){	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
		 

     
		     $form["dest_user"]=$results; 
 }elseif($form['dest_users'] && is_array($form['dest_users']) && !(is_array($form['dest_users'][0]))  ){
			 
		foreach($form['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select userID,full_name  from users where userID=$key";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		     }
		   } 
		    
		       
        }
		 
		     $form["dest_user"]=$results; 
 } elseif($form['dest_users'] && is_array($form['dest_users'][0])  ){
 	$form["dest_user"]=$form["dest_users"];
 	$form['add_frmID']=1;
 }
		   		          	
/**********************************************************************************************************************/
//for check the length
	 $i=0; 	
		if($form['src_usersID'] && is_array($form['src_usersID'])   ){
			 
		foreach($form['src_usersID'] as $key=>$val){
	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		       
        }
		 

     }
		     $form["src_user"]=$results1; 
 }else{
 	$form["src_user"]=$form["dest_user"];
 }
/***********************************************************************/		   		          			 
/***********************FORUMSTYPE**********************************************/
if(!(is_array($form['dest_forumsType'])))
$form['dest_forumsType']=explode(',', $form['dest_forumsType']);
 
 $i=0; 	
		if($form['dest_forumsType'] && is_array($form['dest_forumsType'])  ){
			
		foreach($form['dest_forumsType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select catID,catName  from categories1 where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$form['dest_forumsType']=$results_cat_frm;
}
/*************************************MANAGER_TYPE*****************************************************************/
if(!(is_array($form['dest_managersType'])))
$form['dest_managersType']=explode(',', $form['dest_managersType']);
  $i=0; 	
		if($form['dest_managersType'] && is_array($form['dest_managersType'])  ){
			
		foreach($form['dest_managersType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$form['dest_managersType']=$results_cat_mgr;
}
/******************************************************************************************************/


$manageID=$form['manager_forum'];
$sql="select managerName from managers where managerID=$manageID";
if($rows=$db->queryObjectArray($sql)){
	$form['managerName']=$rows[0]->managerName;
}		 
/**********************************************************************/ 		   		          	
$appID=$form['appoint_forum'];
$sql="select appointName from appoint_forum where appointID=$appID";
if($rows=$db->queryObjectArray($sql)){
	$form['appointName']=$rows[0]->appointName;
}		 
/**********************************************************************/ 
 $sql="select forum_decName  from forum_dec where forum_decID=$forum_decID  ";
		if($rows=$db->queryObjectArray($sql)){
		$form['forum_decName']=$rows[0]->forum_decName; 
		}
 	            	
                       echo json_encode($form);
 	                   $db->execute("COMMIT");
 	                  exit;
 	            }
 	            
/********************************************************************************************/ 	            
     }//end if($formdata[dynamic_10]){
/********************************************************************************************/
/********************************************************************************************/                
				if($formdata[dynamic_12] || $formdata['dynamic_ajx'] ){
					
                
		 $i=0; 	
		if($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
		foreach($formdata['dest_users'] as $key=>$val){
		if(is_numeric($key)){	
		$sql="select userID,full_name  from users where userID=$key  ";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		    
		  }
		  
		    
		       }
		 
		     }
		     $form["dest_user"]=$results;
		     
		   }
/**************************************************************************************/ 
//for check the length

	 $i=0; 	
		if($form['src_usersID'] && is_array($form['src_usersID'])   ){
			 
		foreach($form['src_usersID'] as $key=>$val){
	
		$sql="select userID,full_name  from users where userID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
			 
		    
		      $i++;
		       
        }
		 

     }
		     $form["src_user"]=$results1; 
 }else{
 	$form["src_user"]=$form["dest_user"];
 }
/***********************************************************************/		   		          			                 	
	$sql="select forum_decName  from forum_dec where forum_decID=$forum_decID  ";
		if($rows=$db->queryObjectArray($sql)){
		$form['forum_decName']=$rows[0]->forum_decName; 
		}
/*********************************************************************************************/
//	$sql="select forum_decID, forum_decName  from forum_dec";
//		if($rows=$db->queryArray($sql)){
//		$form['forum_dec']=$rows; 
//		}	
/***********************************************************************/		   		          	
$manageID=$form['manager_forum'];
$sql="select managerName from managers where managerID=$manageID";
if($rows=$db->queryObjectArray($sql)){
	$form['managerName']=$rows[0]->managerName;
}		 
/**********************************************************************/ 		   		          	
$appID=$form['appoint_forum'];
$sql="select appointName from appoint_forum where appointID=$appID";
if($rows=$db->queryObjectArray($sql)){
	$form['appointName']=$rows[0]->appointName;
}		 

 
/***********************FORUMSTYPE**********************************************/
  $i=0; 	
		if($form['dest_forumsType'] && is_array($form['dest_forumsType'])  ){
			
		foreach($form['dest_forumsType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select catID,catName  from categories1 where catID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$form['dest_forumsType']=$results_cat_frm;
}
/*************************************MANAGER_TYPE*****************************************************************/

  $i=0; 	
		if($form['dest_managersType'] && is_array($form['dest_managersType'])  ){
			
		foreach($form['dest_managersType'] as $key=>$val){
		if(is_numeric($val)){	
		$sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
		if($rows=$db->queryObjectArray($sql)){
		 
			 $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);
			 
		    
		      $i++;
		    
		     }
		  } 
		    
		       
        }
	$form['dest_managersType']=$results_cat_mgr;
}
/******************************************************************************************************/

unset($_POST['form']['multi_year']);
unset($_POST['form']['multi_month']);
unset($_POST['form']['multi_day']);
unset($form['multi_year']);
unset($form['multi_month']);
unset($form['multi_day']);
$form['multi_year'][0]='none';
 $form['multi_month'][0]='none';
 $form['multi_day'][0]='none';
		
/**********************************************************************************************/		
		    $form['type'] = 'success';
 	       $form['message'] = 'נישמר בהצלחה!';
/*******************************************************************************************/

 	       
/*******************************************************************************************/ 	       
                echo json_encode($form); 
                // echo json_encode($results);  
                  $db->execute("COMMIT");
                   // $this->message_save($newforumname,$forum_decID);
                    //$this->print_forum_entry_form1($forum_decID);
                exit;
               }
/********************************************************************************************/
                
			
 		 
		//echo "<p>פורום עודכן/ נוסף.</p>\n";
		$this->link();
				return TRUE;
	}
}	
/*******************************************************************************************************/
/*******************************************************************************************************/
  	
function insert_new_forum($insertID,$newforumName,$appointID,$managerID,$forum_date,$appoint_date="",$manager_date="" ,$managerType,$status,$forum_allowed,$formdata,$forum_decID="") {
//($insertID,($newforumname),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$managerType,$status,$formdata);	
//  ($insertID,$subcategories,$appoint,$manager,$forum_date,$appoint_date,$manager_date,$status,$formdata);                      	
	global $db;
		// test if newcatName is empty
		
		if(!$newforumName) return 0;
		$newforumName = $db->sql_string($newforumName);

		// test if newcatName already exists

		$now	=	date('Y-m-d');
 	    if(!$manager_date)
 	    $manager_date=$now;

 	    
 	    if(!$appoint_date)
 	    $appoint_date=$now;
		if(!$forum_date)
 	    $forum_date=$now; 	
 if( (  $formdata['forum_decision']!=null  && $formdata['forum_decision']!='none' 
        && count($formdata['forum_decision'])>0)

        && array_item ($formdata,'forum_decID')  
 	    && is_numeric($formdata['forum_decID'])  
 	    
 	    
 	    && array_item ($formdata,'forum') &&  $formdata['forum']!='none' 
 	    && !is_numeric($formdata['forum'])
 	    
 	    ){
         
 	    
 	    	
		$db->execute("set foreign_key_checks=0");	
    	$sql = "UPDATE forum_dec SET  
           appointID=$appointID,
           managerID=$managerID, 
           active=   $status ,
           forum_allowed=$forum_allowed,
	       forum_date=  $forum_date ,
	        appoint_date=  $appoint_date ,
	         manager_date=  $manager_date ,
	       parentForumID=$insertID ,
	     
            WHERE forum_decID=$forum_decID";
		   if(!$db->execute($sql)){
		   	$db->execute("set foreign_key_checks=1");		   
		   return -1; 
		  
		}else 
	     $db->execute("set foreign_key_checks=1");
	      return 1;	 
     }elseif( ($formdata['newforum'] && $formdata['newforum']!='none')){ 
      
       
       $sql = "SELECT COUNT(*) FROM forum_dec " .
         " WHERE parentForumID=$insertID " .
         "  AND forum_decName=$newforumName";

         if($db->querySingleItem($sql)>0) {
		  	show_error_msg('כבר קיים פורום אם שם כזה'); 
		  	return -1;
		  }else	
 	 
$sql = "INSERT INTO forum_dec ( forum_decName, managerID, appointID, forum_date, active, parentForumID, manager_date, appoint_date,forum_allowed) " .
                      "VALUES ( $newforumName,$managerID,$appointID,$forum_date, $status, $insertID,   $manager_date,$appoint_date,$forum_allowed)";

 	 if($db->execute($sql)) 
 
		     	
		    return 1;
		    else
		   return -1;
		 }  
	 

	}

/**********************************************************************************************/


	// insert new subcategories to given category
	
	function insert_new_forums1(&$formdata,&$appointsIDs="",&$managersIDs="" ,&$catIDs="",&$catTypeIDs="",&$dateIDs="",&$date_appointIDs="",&$date_managerIDs=""){
		global $db;

        if ($formdata['newforum'] && $formdata['newforum']!='none'
            && $formdata['forum_decision'][0] && $formdata['forum_decision'][0]!='none' ){
        unset($formdata['forum_decision']);
            $subcategories =explode(";",$subcategories); 
        }elseif($formdata['newforum'] && $formdata['newforum']!='none'){
        	 $subcategories =explode(";",$formdata['newforum']); 
        }
	    //$status1      = explode(";" , $formdata['forum_status']);	
		$count = 0;
		$nameArray=0;
        $size_of_array = count($subcategories);
		
		$size_of_array_date = count($dateIDs);
		$size_of_array_date_appoint = count($date_appointIDs);
		$size_of_array_date_manager = count($date_managerIDs);
		
        $size_of_array_manager = count($managersIDs); 
        $size_of_array_appoint = count($appointsIDs);
        $size_of_array_cat_forum = count($catIDs);
		$size_of_array_cat_manager = count($catTypeIDs);
		 
		$size_of_status	 =count($status1);
		
		$size_of_array_insert_forum	 =count($formdata['insert_forum']);
//		$size_of_array_insert_forumType	 =count($formdata['insert_forumType']);
//		$size_of_array_insert_appoint	 =count($formdata['insert_appoint']);
//		$size_of_array_insert_manager	 =count($formdata['insert_manager']);
//		$size_of_arrayinsert_managerType	 =count($formdata['insert_managerType']);
		
		
		
		$i=0;
		$j=0;
		$k=0;
		$l=0;
		$m=0;
		$n=0;
		$x=0;
		$y=0;
		$z=0;
		
		
		$manager_idx=0;
		$appoint_idx=0;
		
		$forum_dt_idx=0;
		$appoint_dt_idx=0;
		$manager_dt_idx=0;
		
		$appoint_date=0;
		$manager_date=0;
		
		
		$type_manager_idx=0;
		$type_forum_idx=0;
		
		
		
		 
		$insert_forum_idx=0;
		
		

		
		
		
//		$insert_forumType_idx=0;
//		$insert_appoint_idx=0;
//		$insert_manager_idx=0;
//		$insert_managerType_idx=0; 

		foreach($subcategories as $newforumname) {
			 

$status=2;
/**********************************************************************************/
 $forum_allowed = $formdata['forum_allowed'];
		     
		     if($formdata['forum_allowed']==1)
				$forum_allowed= 'public';
				elseif($formdata['forum_allowed']==2 )
				$forum_allowed= 'private';
				elseif($formdata['forum_allowed']==3 )
				$forum_allowed= 'top_secret';
				
			  $forum_allowed=$db->sql_string($forum_allowed);
/**************************************************************************************/
			
			 if($appoint_idx==$size_of_array_appoint) $appoint_idx=$size_of_array_appoint-1;
			 $appoint=$appointsIDs[$appoint_idx]; 

/**********************************************************************************/
			
			 if($manager_idx==$size_of_array_manager) $manager_idx=$size_of_array_manager-1;
			 $manager=$managersIDs[$manager_idx]; 
/**********************************************************************************/
			
			 if($type_forum_idx==$size_of_array_cat_forum) $type_forum_idx=$size_of_array_cat_forum-1;
			 $forumType=$catIDs [$type_forum_idx]; 




/****************************FORUM_DATE******************************************************/			
		 if($forum_dt_idx==$size_of_array_date) $forum_dt_idx=$size_of_array_date-1;
		 

 $forum_date=$dateIDs[$forum_dt_idx++];
 $forum_date=$db->sql_string($forum_date);



/*********************************APPOINT_DATE*************************************************/
		if($appoint_dt_idx==$size_of_array_date_appoint) $appoint_dt_idx=$size_of_array_date_appoint-1;
			
$appoint_date=$date_appointIDs[$appoint_dt_idx++];
$appoint_date=$db->sql_string($appoint_date);



/*************************************MANAGER_DATE*********************************************/
		if($manager_dt_idx==$size_of_array_date_manager) $manager_dt_idx=$size_of_array_date_manager-1;

			
$manager_date=$date_managerIDs[$manager_dt_idx++];
$manager_date=$db->sql_string($manager_date);


/*********************************************INSERT_FORUMID******************************************************************/
		if($insert_forum_idx==$size_of_array_insert_forum) $insert_forum_idx=$size_of_array_insert_forum-1;

if(array_item($formdata,'insert_forum') && is_array($formdata['insert_forum']) && is_numeric($formdata['insert_forum'][0]) ){   
if($insert_forum_idx==$size_of_array_insert_forum) {$insert_forum_idx=$size_of_array_insert_forum-1;}
$insertID=$formdata['insert_forum'][$insert_forum_idx++];
}else{
$insertID=11;
}			
/************************************************************************************************************************/


 $result =$this->insert_new_forum($insertID,trim($newforumname),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$status,$forum_allowed,$formdata);


			if($result == -1) {
				echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
				return FALSE;
			}elseif ($result){
/********************************************************************************************/
			
				
				$count++; 
				 
				 $forum_decID=$db->insertId();
			 
/*********************************************************************************/
			        $this->conn_cat_forum1($forum_decID,$catIDs[$type_forum_idx]);
				 	
					if($type_forum_idx==$size_of_array_cat_forum){
						$type_forum_idx=$size_of_array_cat_forum-1;
					}
/**********************************************************************************/
			
			 
		$this->conn_manager_forum1($forum_decID,$catTypeIDs[$type_manager_idx]);		
		if($type_manager_idx==$size_of_array_cat_manager) $type_manager_idx=$size_of_array_cat_manager-1;
			// $managerType=$catTypeIDs [$type_manager_idx];  
			
/**********************************************************************************/
              
				$this->message_save($newforumname,$forum_decID);
				
				$formdata['subcategories']=$newforumname;
				$form=$formdata;

				$form['forum_decision']=$forum_decID;	

/******************************************************************************************/
				$form['manager_forum']=$manager;
				  $manager_idx++ ; 
/******************************************************************************************/
				$form['appoint_forum']=$appoint;
				 $appoint_idx++ ; 
/******************************************************************************************/
				
//				if($type_manager_idx==$size_of_array_cat_manager){
//					$type_manager_idx=$size_of_array_cat_manager-1;
//				}
				$form['managerType']=$catTypeIDs[$type_manager_idx++];
					
/********************************************************************************************/
//				if($type_forum_idx==$size_of_array_cat_forum){
//					$type_forum_idx=$size_of_array_cat_forum-1;
//				}
				$form['category']=$catIDs[$type_forum_idx++];
					
/********************************************************************************************/					
				$form['forum_status']=$status ;
/****************************************************************************************/	

                 $form['index']=$nameArray;
                // $form['submitbutton']=$formdata['']
/****************************************************************************************/								
				
$form['appoint_date']=substr($appoint_date,1,10);
list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$form['appoint_date']);
	
	 if (strlen($year_date_appoint) > 3){
		$form['appoint_date']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
		}elseif(strlen($day_date_appoint)==4){
     $form['appoint_date']="$year_date_appoint-$month_date_appoint-$day_date_appoint";	
    }	
/***********************************************************************************/
    $form['manager_date']=substr($manager_date,1,10);
list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$form['manager_date']);
	
	 if (strlen($year_date_manager) > 3){
		$form['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
		}elseif(strlen($day_date_manager)==4){
     $form['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";	
    }	
/********************************************************************************************/
    $form['forum_date']=substr($forum_date,1,10);
    list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$form['forum_date']);
	
	 if (strlen($year_date_forum) > 3){
		$form['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
		}elseif(strlen($day_date_forum)==4){
     $form['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";	
    }	
/********************************************************************************************/
				$formdata['new_name']=$formdata['newforum'];
				//unset($formdata['newforum']);
				unset($form['newforum']);
				unset($form['new_category']);
				unset($form['new_appoint']);
				unset($form['new_manager']);
				unset($form['new_type']);
				$_SESSION['forum_decID']=$form['forum_decision'];
				 $this->print_forum_entry_form1($form['forum_decision']);
				 build_form($form);
				 
//				$form['type'] = 'success';
//				$form['message'] = 'עודכן בהצלחה!';
//			     echo json_encode($form);
//			 	exit;
				$nameArray++;

/********************************************************************************************/

			}
		}
		
		
		if($count)
		if($count==1)
		echo "<p>פורום  עודכן/נוסף.</p>\n";
		else{
			echo "<p>$count פורומים חדשים נוספו.</p>\n";

		}
		return TRUE;
	}
/*******************************************************************************************************/
/*********************************************************************************************************/	
 

	// insert new subcategories to given category
	
	function insert_new_forums2(&$formdata,&$appointsIDs="",&$managersIDs="" ,&$catIDs="",&$catTypeIDs="",&$dateIDs="",&$date_appointIDs="",&$date_managerIDs="",$form1=""){
		global $db;

        if ($formdata['newforum'] && $formdata['newforum']!='none'
            && $formdata['forum_decision'][0] && $formdata['forum_decision'][0]!='none' ){
        unset($formdata['forum_decision']);
            $subcategories =explode(";",$subcategories); 
        }elseif($formdata['newforum'] && $formdata['newforum']!='none'){
        	 $subcategories =explode(";",$formdata['newforum']); 
        }
	   
    		$count = 0;
		$nameArray=0;
        $size_of_array = count($subcategories);
		
		$size_of_array_date = count($dateIDs);
		$size_of_array_date_appoint = count($date_appointIDs);
		$size_of_array_date_manager = count($date_managerIDs);
		
        $size_of_array_manager = count($managersIDs); 
        $size_of_array_appoint = count($appointsIDs);
        $size_of_array_cat_forum = count($catIDs);
		$size_of_array_cat_manager = count($catTypeIDs);
		 
		$size_of_status	 =count($status1);
		
		$size_of_array_insert_forum	 =count($formdata['insert_forum']);

		
		
		
		$i=0;
		$j=0;
		$k=0;
		$l=0;
		$m=0;
		$n=0;
		$x=0;
		$y=0;
		$z=0;
		
		
		$manager_idx=0;
		$appoint_idx=0;
		
		$forum_dt_idx=0;
		$appoint_dt_idx=0;
		$manager_dt_idx=0;
		
		$appoint_date=0;
		$manager_date=0;
		
		
		$type_manager_idx=0;
		$type_forum_idx=0;
		
		
		
		 
		$insert_forum_idx=0;
		
	

		foreach($subcategories as $newforumname) {
			 
/************************************************************************/
$status=$formdata['forum_status'];			      
$forum_allowed = $formdata['forum_allowed'];
		     
		     if($formdata['forum_allowed']==1)
				$forum_allowed= 'public';
				elseif($formdata['forum_allowed']==2 )
				$forum_allowed= 'private';
				elseif($formdata['forum_allowed']==3 )
				$forum_allowed= 'top_secret';
				
			  $forum_allowed=$db->sql_string($forum_allowed);			
/**************************************************************************/      
			 if($appoint_idx==$size_of_array_appoint) $appoint_idx=$size_of_array_appoint-1;
			 $appoint=$appointsIDs[$appoint_idx]; 

/**********************************************************************************/
			
			 if($manager_idx==$size_of_array_manager) $manager_idx=$size_of_array_manager-1;
			 $manager=$managersIDs[$manager_idx]; 
/**********************************************************************************/
			
			 if($type_forum_idx==$size_of_array_cat_forum) $type_forum_idx=$size_of_array_cat_forum-1;
			 $forumType=$catIDs [$type_forum_idx]; 


/**********************************************************************************/
			if($type_manager_idx==$size_of_array_cat_manager) $type_manager_idx=$size_of_array_cat_manager-1;
			 $managerType=$catTypeIDs [$type_manager_idx];  
			

/****************************FORUM_DATE******************************************************/			
		   if($forum_dt_idx==$size_of_array_date) $forum_dt_idx=$size_of_array_date-1;
		 

				 $forum_date=$dateIDs[$forum_dt_idx++];
				 $forum_date=$db->sql_string($forum_date);



/*********************************APPOINT_DATE*************************************************/
		   if($appoint_dt_idx==$size_of_array_date_appoint) $appoint_dt_idx=$size_of_array_date_appoint-1;
			
				$appoint_date=$date_appointIDs[$appoint_dt_idx++];
				$appoint_date=$db->sql_string($appoint_date);



/*************************************MANAGER_DATE*********************************************/
		 if($manager_dt_idx==$size_of_array_date_manager) $manager_dt_idx=$size_of_array_date_manager-1;

			
				$manager_date=$date_managerIDs[$manager_dt_idx++];
				$manager_date=$db->sql_string($manager_date);


/*********************************************INSERT_FORUMID******************************************************************/
		if($insert_forum_idx==$size_of_array_insert_forum) $insert_forum_idx=$size_of_array_insert_forum-1;

if(array_item($formdata,'insert_forum') && is_array($formdata['insert_forum']) && is_numeric($formdata['insert_forum'][0]) ){   
if($insert_forum_idx==$size_of_array_insert_forum) {$insert_forum_idx=$size_of_array_insert_forum-1;}
$insertID=$formdata['insert_forum'][$insert_forum_idx++];
}else{
$insertID=11;
}			
/************************************************************************************************************************/


 $result =$this->insert_new_forum($insertID,trim($newforumname),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$managerType,$status,$forum_allowed,$formdata);


			if($result == -1) {
				echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
				return FALSE;
			}elseif ($result){
/********************************************************************************************/
			 
				
				$count++; 
				 
				 $forum_decID=$db->insertId();
			     
					
		
$now	=	date('Y-m-d');
  	    if(!$usr_date)
 	    $usr_date=$now;$usr_date=$db->sql_string($usr_date);
  $frmID=$forum_decID;

/*********************************************************************************/
 $this->conn_cat_forum1($forum_decID,$catIDs[$type_forum_idx],$formdata);
$this->conn_manager_forum1($forum_decID,$catTypeIDs [$type_manager_idx] );	

 

/**********************************************************************************/
              
			 
				
				$formdata['subcategories']=$newforumname;
				
				
			 	
			 	
		 
                 
			   
				$form['forum_decision']=$forum_decID;	
                $form['forum_decID']=$forum_decID;
/******************************************************************************************/
				$form['manager_forum']=$manager;
				  $manager_idx++ ; 
/******************************************************************************************/
				$form['appoint_forum']=$appoint;
				 $appoint_idx++ ; 
/******************************************************************************************/

				
			if($formdata['dynamic_6b']){ 
			$form['dest_managersType']=$catTypeIDs[$type_manager_idx++];
				}else{
				$form['managerType']=$catTypeIDs[$type_manager_idx++];
				}
					
/********************************************************************************************/

				
			if($formdata['dynamic_6b']){ 
			$form['dest_forumsType']=$catIDs[$type_forum_idx++];
				}else{
				$form['category']=$catIDs[$type_forum_idx++];
				}
					
/********************************************************************************************/					
				$form['forum_status']=$status ;
/****************************************************************************************/
				$form['forum_allowed']=$formdata['forum_allowed'] ;
/****************************************************************************************/	

                 $form['index']=$nameArray;
                 $form['form_index']=$count;
/****************************************************************************************/								
				
$form['appoint_date']=substr($appoint_date,1,10);
list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$form['appoint_date']);
	
	 if (strlen($year_date_appoint) > 3){
		$form['appoint_date']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
		}elseif(strlen($day_date_appoint)==4){
     $form['appoint_date1']="$year_date_appoint-$month_date_appoint-$day_date_appoint";	
    }	
/***********************************************************************************/
    $form['manager_date']=substr($manager_date,1,10);
list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$form['manager_date']);
	
	 if (strlen($year_date_manager) > 3){
		$form['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
		}elseif(strlen($day_date_manager)==4){
     $form['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";	
    }	
/********************************************************************************************/
    $form['forum_date']=substr($forum_date,1,10);
    list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$form['forum_date']);
	
	 if (strlen($year_date_forum) > 3){
		$form['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
		}elseif(strlen($day_date_forum)==4){
     $form['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";	
    }	

/********************************************************************************************/
    
				$formdata['new_name']=$formdata['newforum'];

				$form['forum_decName']=$newforumname;
				$form['insert_forum']=$formdata['insert_forum'][0];
			   
				 
			    
				$submit="submitbutton_$forum_decID";
				 
				
				unset($form['newforum']);
				unset($form['new_category']);
				unset($form['new_managerType']);
				unset($form['new_forumType']);
				unset($form['new_appoint']);
				unset($form['new_manager']);
				unset($form['new_type']);
				$_SESSION['forum_decID']=$form['forum_decision'];
 				
				
				if($formdata['dynamic_6b']){ 
				$form['dest_forumsType']=explode(',',$form['dest_forumsType']);
				$form['dest_managersType']=explode(',',$form['dest_managersType']);	
				build_form_ajx4($form);
				}else{
				build_form($form);
				}
				$nameArray++;

/********************************************************************************************/

			}
		}
		
		
		if($count)
		if($count==1)
		echo "<p class='error'>פורום  עודכן/נוסף.</p>\n";
		else{
			echo "<p class='error'>$count פורומים חדשים נוספו.</p>\n";

		}
		return TRUE;
	}
/*******************************************************************************************************/ 
 
/************************************************************************************************************/ 
/*********************************************************************************************************/
	
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

/**********************************************************************************/

	/* createSetStatement: convert an array into a string of the form col_name='value'", sutable for an "INSERT INTO tbl_name SET" query */
	function createSetStatement($row) {
		// Oh! for efficient anonymous function support in PHP.
		 
		foreach ($row as $col => $val) {
			$tmp[] = "$col='$val'";
		}
		return implode(', ', $tmp);
	}


/**********************************************************************************************/
	function delete1(){



		global $db;
		$query = "set foreign_key_checks=0";
		if( $db->execute($query) )
		if( $db->execute("delete from  forum_dec where forum_decID=".$this->getId()))
		$db->execute("set foreign_key_checks=1");
		else
		$db->execute("set foreign_key_checks=1");
	}

	function check(&$err_msg) {
		return 1;
		$err_msg = "";
		if( strlen($this->decName) < 1)
		//$err_msg = "String too short";
		$err_msg =show_error_msg("String too short");
			

		return $err_msg=="";
	}
/****************************************************************************************/
/********************************************************************************************/	
	function del_forum($deleteID){
		global $db;
		$sql = "SELECT COUNT(*) FROM forum_dec WHERE forum_decID=$deleteID";
		if($db->querySingleItem($sql)==1) {
			 
           
			
			$db->execute("START TRANSACTION");
			$query = "set foreign_key_checks=0";
			$db->execute($query);
			if($this->delete_forum_sub($deleteID)==-1){
				$db->execute("ROLLBACK");
				$db->execute("set foreign_key_checks=1");
			}else{
				$db->execute("COMMIT");
				$db->execute("set foreign_key_checks=1");

			}
		}

	}
/****************************************************************************************/

	// delete a category
	// return  1, if category and its subcategories could be deleted
	// returns 0, if the category could not be deleted
	// return -1 if an error happens

	function delete_forum_sub($forum_decID) {
		// find subcategories to catID and delete them
		// by calling delete_category recursively
		global $db;
		$sql = "SELECT forum_decID FROM forum_dec " .
         "WHERE parentForumID='$forum_decID'";
		if($rows = $db->queryObjectArray($sql)) {
			$deletedRows = 0;
			foreach($rows as $row) {
			
				$result =$this->delete_forum_sub($row->forum_decID);
				
				if($result==-1)
				return -1;
				else
				$deletedRows++;
			}
			// if any subcategories could not be deleted,
			// don't delete this category as well
			if($deletedRows != count($rows))
			return 0;
		}

		 
		if($forum_decID==11) {
			//echo "<br />אי אפשר למחוק שורש הפורומים   .\n";
			show_error_msg("<br />אי אפשר למחוק שורש הפורומים   .\n");
			return 0;
		}

/***********************************************************************************************/		
	                      
		 $sql1 = "SELECT decID  FROM rel_forum_dec WHERE forum_decID=$forum_decID";
                 if($rows1=$db->queryObjectArray($sql1)  ){
                 foreach($rows1 as $row){
                 	$dec_arr[$row->decID]=$row->decID;
                 }
               
                 if($dec_arr && $dec_arr!=null){
                 $this->del_decision($dec_arr);	
                }
              }  
/***************************************************************************************************/                 
		// delete category
		$sql =  "DELETE FROM forum_dec WHERE forum_decID='$forum_decID' LIMIT 1";
		$sql1 = "DELETE FROM rel_cat_forum WHERE forum_decID='$forum_decID' LIMIT 1 ";
		$sql2 = "DELETE FROM rel_forum_dec WHERE forum_decID='$forum_decID' LIMIT 1 ";
		$sql3 = "DELETE FROM rel_user_forum WHERE forum_decID='$forum_decID' ";
		
/**************************************************************************************************/		
		
		
		//if( ($db->execute($sql) && $db->execute($sql1) && $db->execute($sql2) ) || 
		 if(   ($db->execute($sql) && $db->execute($sql1) && $db->execute($sql2)&& $db->execute($sql3) ) )
		return 1;
		else
		return -1;
			
	}



	
/****************************************************************************************/
	function del_decision_copy_from_dec($deleteID){
		global $db;
		$sql = "SELECT COUNT(*) FROM decisions WHERE decID=$deleteID";
		if($db->querySingleItem($sql)==1) {
			$db->execute("START TRANSACTION");
			$query = "set foreign_key_checks=0";
			$db->execute($query);
			if($this->delete_decision_sub($deleteID)==-1){
				$db->execute("ROLLBACK");
				$db->execute("set foreign_key_checks=1");
			}else{
				$db->execute("COMMIT");
				$db->execute("set foreign_key_checks=1");
                 return true;
			}
		}

	}

/***************************************************************************************************/	
	// delete a category
	// return  1, if category and its subcategories could be deleted
	// returns 0, if the category could not be deleted
	// return -1 if an error happens

	function delete_decision_sub($decID) {
		// find subcategories to catID and delete them
		// by calling delete_category recursively
		global $db;
		$sql = "SELECT decID FROM decisions " .
         "WHERE parentdecID='$decID'";
		if($rows = $db->queryObjectArray($sql)) {
			$deletedRows = 0;
			foreach($rows as $row) {
				$result =$this->delete_decision_sub($row->decID);
				if($result==-1)
				return -1;
				else
				$deletedRows++;
			}
			// if any subcategories could not be deleted,
			// don't delete this category as well
			if($deletedRows != count($rows))
			return 0;
		}

		// delete catID
		// don't delete catIDs<=11
		if($decID==11) {
			echo "<br />אי אפשר למחוק שורש ההחלטות   .\n";
			return 0;
		}
            
		$task_sql="select taskID from todolist where decID='$decID' ";
		if($rows_task=$db->queryObjectArray($task_sql) ){
          
			
			
		for($i=0; $i<count($rows_task); $i++){	
				if($i==0){
					$taskIDs = $rows_task[$i]->taskID;
				}
				else{
					$taskIDs .= "," . $rows_task[$i]->taskID;

				}
		
			}	

		  
	    $sql4 = "DELETE FROM todolist WHERE decID='$decID'  ";
     	if(!$db->execute($sql4))
   	    return -1; 
   	    
   	    
 
   	     
//   	    $tag_sql="select * from tag2task where taskID = any (SELECT taskID from todolist where taskID in($taskIDs))";
        $tag_sql="select * from tag2task where taskID in($taskIDs)";
   	    if($rows=$db->queryObjectArray  ($tag_sql)) {

   	    for($i=0; $i<count($rows); $i++){	
				if($i==0){
					$tag_taskIDs = $rows[$i]->tagID;
				}
				else{
					$tag_taskIDs .= "," . $rows[$i]->tagID;

				}
		
			}
   	    $tag_taskIDs=array_unique($tag_taskIDs);	
        $db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($tag_taskIDs)");
		$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags   			 
		
	
   	    
   	    
  }  
   	
   	
   	
/////////////////////////////////////////////////////////////////////////////////////////
// $tag_task_sql="select taskID from tag2task where taskID = any (SELECT taskID from todolist where taskID in ($taskIDs))";
  $tag_task_sql="select taskID  from tag2task where taskID in ($taskIDs) ";
   	    if($rows_tag2task=$db->queryObjectArray($tag_task_sql) ){

   	    	
   	    	
   	    for($i=0; $i<count($rows_tag2task); $i++){	
				if($i==0){
					$ta2taskIDs = $rows_tag2task[$i]->taskID;
				}
				else{
					$tag2taskIDs .= "," . $rows_tag2task[$i]->taskID;

				}
		
			}
   	    	

			
			 
		$sql6="delete from tag2task where where taskID in($tag2taskIDs)";
		
		if(!$db->execute($sql5))
   	    return -1; 
		
		}
	
}		
		
		
		// delete category
		$sql = "DELETE FROM decisions WHERE decID='$decID' LIMIT 1";
		$sql1 = "DELETE FROM rel_cat_dec WHERE decID='$decID'  ";
		//$sql2 = "DELETE FROM rel_forum_dec WHERE decID='$decID'  ";
		
		
		if($db->execute($sql) && $db->execute($sql1) /*&& $db->execute($sql2)*/ )
		return 1;
		else
		return -1;
			
	}


/*******************************************************************************************************/
		
/***************************************************************************************************/
function del_decision(&$arr_del){
		global $db;
		//$arr_del = array();
        foreach ($arr_del as $key=>$val){		
		$sql = "SELECT COUNT(*) FROM decisions WHERE decID=$key";
		if($db->querySingleItem($sql)==1) {
			if($arr_del[$val]!=1){
			$db->execute("START TRANSACTION");
			$query = "set foreign_key_checks=0";
			$db->execute($query);
			
			if($this->delete_decision_sub($key, $arr_del)==-1 ){
				$db->execute("ROLLBACK");
				$db->execute("set foreign_key_checks=1");
			}else{
				$db->execute("COMMIT");
				$db->execute("set foreign_key_checks=1");
					
				}
			   }	

		}		
      }
      return true;
	}

/***************************************************************************************************/	
	 
	function delete_decision_sub_waiting($decID, &$arr_deleted_dec) {
		// find subcategories to catID and delete them
		// by calling delete_category recursively
		global $db;
		$sql = "SELECT decID FROM decisions " .
         "WHERE parentdecID='$decID'";
		if($rows = $db->queryObjectArray($sql)) {
			$deletedRows = 0;
			foreach($rows as $row) {
				$result =$this->delete_decision_sub($row->decID, $arr_deleted_dec);
				if($result==-1)
				return -1;
				else
				$deletedRows++;
			}
			// if any subcategories could not be deleted,
			// don't delete this category as well
			if($deletedRows != count($rows))
			return 0;
		}

		// delete catID
		// don't delete catIDs<=11
		if($decID==11) {
			echo "<br />אי אפשר למחוק שורש ההחלטות   .\n";
			return 0;
		}

		// delete category
		//$query="SELECT d.decID ,c."
		$sql = "DELETE FROM decisions WHERE decID='$decID' LIMIT 1";
		$sql1 = "DELETE FROM rel_cat_dec WHERE decID='$decID' LIMIT 1 ";
		//$sql2 = "DELETE FROM rel_forum_dec WHERE decID='$decID' LIMIT 1 ";
		
		if($db->execute($sql) && $db->execute($sql1) ) {
			$arr_deleted_dec[$decID] = 1; 
			return 1;
		} else
			return -1;
			
	}


/*******************************************************************************************************/
	// delete one forum
	//=======================================
	function delete_forum($formdata) {
		global $db;

		if((!$forum_decID = array_item($formdata, "forum_decID")) || !is_numeric($forum_decID))
		return FALSE;

		$sql = "set foreign_key_checks=0";
		if( $db->execute($sql) )  {
			$sql = "DELETE FROM forum_dec WHERE forum_decID=$forum_decID LIMIT 1";
			if(!$db->execute($sql)){
				$db->execute("set foreign_key_checks=1");
				return FALSE;
			}else{
				$db->execute("set foreign_key_checks=1");

			}
		}
/**************************************************************************/
		$sql = "set foreign_key_checks=0";
		if( $db->execute($sql) )  {

			$sql = "DELETE FROM rel_forum_dec  WHERE  forum_decID = $forum_decID  LIMIT 1";
			if(!$db->execute($sql)){
				$db->execute("set foreign_key_checks=1");
				return FALSE;
			}else{
				$db->execute("set foreign_key_checks=1");

			}
		}
/****************************************************************************/
		echo "<p>.פורום אחד נימחק</p>\n";
		echo "<p><b>   חזרה אל",
		build_href("dynamic_8.php", "", "רשימת החלטות") . " </b> </p>.\n";
		$formdata=false;
		//  build_form($formdata);
		return true;
	}
/*******************************************************************************************************/
	
	function save_user($formdata) {


		global $db;
		$i=0;
		 
        $tmp =($formdata["dest_users"]) ? $formdata["dest_users"] : $forums=explode(";", $formdata["new_user"] );
        if((is_array($tmp)) && $tmp[0]!='none'){
		foreach( $tmp as $user) {

			$user=trim($user);
			 
				$sql = "SELECT full_name,userID FROM users WHERE userID = " .
				$db->sql_string($user);
			 

			$rows = $db->queryObjectArray($sql);
			if($rows)
			// existing forum
			$usersIDs[] = $rows[0]->userID;

		}
       }else{
       	if($tmp!='none'){
       $sql = "SELECT full_name,userID FROM users WHERE userID = " .
				$db->sql_string($tmp);
       	$rows = $db->queryObjectArray($sql); 
       	if($rows)
			// existing forum
			$usersIDs[] = $rows[0]->userID;
       	}
       }
		return $usersIDs;
	}
	
/*******************************************************************************************************************/
/*************************************************SAVE_APPOINT1*********************************************************************************/  
	function save_appoint1(&$formdata) {


		global $db;
		 
		if ($formdata['dest_appoints']=='none' && !array_item ($formdata,"new_appoint")) {  
		 unset ($formdata['dest_appoints']);	 
		$tmp="";
/************************************************************************************************************/

}elseif ( ($formdata['dest_appoints']!='none' &&  $formdata['dest_appoints']!=null
   &&( array_item ($formdata,"dest_appoints") &&  is_array(array_item ($formdata,"dest_appoints"))   ) )
   && !array_item ($formdata,"new_appoint")
   && !count($formdata['new_appoint'])>0 )    { 
   	
 $tmp= $formdata["dest_appoints"]  ? $formdata["dest_appoints"] :  $formdata["new_appoint"]  ;
 
 $dest_appoints= $formdata['dest_appoints'];
		
foreach ($dest_appoints as $key=>$val){
	
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
   
  }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
	
}			



if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_appoint[$row->appointID]=$row->appointName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){

$staff=implode(',',$staff_test);

$sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_appoint[$row->appointID]=$row->appointName;
			 
			
  }
	
	
  $staff_b=implode(',',$staff_testb);

$sql2="select appointID, appointName from appoint_forum where appointID in ($staff_b)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_appoint_b[$row->appointID]=$row->appointName;
			 
			
  }
  
 $name_appoint=array_merge($name_appoint,$name_appoint_b); 
 unset($staff_testb);
}else{    


$staff=implode(',',$formdata['dest_appoints']);			
			
$sql2="select appointID, appointName from appoint_forum where appointID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			//$name_appoint[$row->appointID]=$row->appointName;
			$name_appoint[$row->appointID]=$row->appointName;
			
  }
  
} 
 
 
// $staff=implode(',',$formdata["dest_appoints"]); 
//  $sql = "SELECT appointName,appointID FROM appoint_forum WHERE appointID in ($staff) " ;
				
				//if($rows = $db->queryObjectArray($sql))
				     foreach($name_appoint as $key=>$val)
			 			$appointsIDs[] = $key;
  
/*************************************************************************************************************/
	 
}elseif ($formdata['dest_appoints']!='none' && $formdata['new_appoint']!='none' 
   && array_item ($formdata,"new_appoint")
   && count($formdata['new_appoint'])>0
   && array_item ($formdata,"dest_appoints") 
   && is_array(array_item ($formdata,"dest_appoints"))    )   { 
   
  $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["dest_appoints"]  ;
 // $usrID=$tmp;
 $i=0; 
        foreach($tmp as $usrID){		
           
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
				// new manager
			if(!array_item($formdata ,'insert_appoint') && !is_array ($formdata ['insert_appoint']) 
		    && !is_numeric ($formdata ['insert_appoint'][0]) ){

		    	$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
			  }else{
                $parent=$formdata['insert_appoint'][$i]; 
				$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
			} 
				if(!$db->execute($sql))
				return FALSE;
				$appointsIDs[] = $db->insertId();
				
				
				$formdata['dest_appoints']=$formdata['new_appoint'];
				unset($formdata['new_appoint']);
              $i++;
        } 
/*************************************************************************************************************/  
  }elseif( ($formdata['dest_appoints']=='none'
   ||( !array_item ($formdata,"dest_appoints") &&  !is_array(array_item ($formdata,"dest_appoints"))   ) )    
   && $formdata['new_appoint']!='none' 
   && array_item ($formdata,"new_appoint")
   && count($formdata['new_appoint'])>0 )   { 
   
  $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["dest_appoints"]  ;
  $i=0; 
        foreach($tmp as $usrID){		
           
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
				// new manager
			if(!array_item($formdata ,'insert_appoint') && !is_array ($formdata ['insert_appoint']) 
		    && !is_numeric ($formdata ['insert_appoint'][0]) ){

		    	$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
			  }else{
                $parent=$formdata['insert_appoint'][$i]; 
				$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
			} 
				if(!$db->execute($sql))
				return FALSE;
				$appointsIDs[] = $db->insertId();
				
				$formdata['dest_appoints']=$formdata['new_appoint'];
				unset($formdata['new_appoint']);
  
				$i++;
        } 
   }   
 		return $appointsIDs;
	}
  
/*********************************************SAVE_APPOINT**********************************************************/	
	function save_appoint(&$formdata) {


		global $db;
		 
		if ($formdata['appoint_forum']=='none' && !array_item ($formdata,"new_appoint")) {  
		 unset ($formdata['appoint_forum']);	 
		$tmp="";
/************************************************************************************************************/
  
}elseif ( ($formdata['appoint_forum']!='none' 
   ||( array_item ($formdata,"appoint_forum") &&  is_numeric(array_item ($formdata,"appoint_forum"))   ) )
   && !array_item ($formdata,"new_appoint")
   && !is_numeric(array_item ($formdata,"new_appoint"))  )   { 
   
 $tmp= $formdata["appoint_forum"]  ? $formdata["appoint_forum"] :  $formdata["new_appoint"]  ; 
  $sql = "SELECT appointName,appointID FROM appoint_forum WHERE appointID = " .
				$db->sql_string($tmp);
				if($rows = $db->queryObjectArray($sql))
			 			$appointsIDs = $rows[0]->appointID;	
  
/*************************************************************************************************************/
	 
}elseif ($formdata['appoint_forum']!='none' && $formdata['new_appoint']!='none' 
   && array_item ($formdata,"new_appoint")
   && is_numeric(array_item ($formdata,"new_appoint"))
   && array_item ($formdata,"appoint_forum") 
   && is_numeric(array_item ($formdata,"appoint_forum"))    )   { 
   
  $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["appoint_forum"]  ;
  $usrID=$tmp; 		
           
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
				// new manager
			if(!array_item($formdata ,'insert_appoint') && !is_numeric ($formdata ['insert_appoint']) ){
				$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
			  }else{
                $parent=$formdata['insert_appoint']; 
				$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
			} 
				if(!$db->execute($sql))
				return FALSE;
				$appointsIDs = $db->insertId();
                
				$formdata['appoint_forum']=$formdata['new_appoint'];
				unset($formdata['new_appoint']);
   
/*************************************************************************************************************/  
  }elseif( ($formdata['appoint_forum']=='none'||( !array_item ($formdata,"appoint_forum") &&  !is_numeric(array_item ($formdata,"appoint_forum"))   )  )    
   && $formdata['new_appoint']!='none' 
   && array_item ($formdata,"new_appoint")
   && is_numeric(array_item ($formdata,"new_appoint")))   { 
   
  $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["appoint_forum"]  ;
  $usrID=$tmp; 		
          
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
				// new appoint
				if(!array_item($formdata ,'insert_appoint') && !is_numeric ($formdata ['insert_appoint']) ){
				$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
			  }else{
                $parent=$formdata['insert_appoint']; 
				$sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
			  } 
               
				if(!$db->execute($sql))
				return FALSE;
				$appointsIDs = $db->insertId();
  	             
				$formdata['appoint_forum']=$formdata['new_appoint'];
				unset($formdata['new_appoint']);
        }
 		return $appointsIDs;
	}

  
/*******************************************************************************************************/
/*************************************************SAVE_MANAGER1*********************************************************************************/  
	function save_manager1(&$formdata) {


		global $db;
		 
		if ($formdata['dest_managers']=='none' && !array_item ($formdata,"new_manager")) {  
		 unset ($formdata['dest_managers']);	 
		$tmp="";
/************************************************************************************************************/
  
}elseif ( ($formdata['dest_managers']!='none' &&  $formdata['dest_managers']!=null
   && ( array_item ($formdata,"dest_managers") &&  is_array(array_item ($formdata,"dest_managers"))   ) )
   && !array_item ($formdata,"new_manager")
   && !count($formdata['new_manager'])>0  )   { 
   
 $tmp= $formdata["dest_managers"]  ? $formdata["dest_managers"] :  $formdata["new_manager"]  ;
 
$dest_managers= $formdata['dest_managers'];
		
foreach ($dest_managers as $key=>$val){
	
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
     $staff_test[]=$val;
   
     }elseif(is_numeric($val)){
  	$staff_testb[]=$val;
  	
    }	
	
}			
			
 if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
 $staff=implode(',',$staff_test);
 $sql="select managerID, managerName from managers where managerName in ($staff)";
		if($rows=$db->queryObjectArray($sql))
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
                   
			
    }
 }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
  $staff=implode(',',$staff_test);
   $sql="select managerID, managerName from managers where managerName in ($staff)";
		if($rows=$db->queryObjectArray($sql))
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
    }
    
    
    $staff_b=implode(',',$staff_testb);			
			
     $sql="select managerID, managerName from managers where managerID in ($staff_b)";
		if($rows=$db->queryObjectArray($sql))
		foreach($rows as $row){
			
       $name_managers_b[$row->managerID]=$row->managerName;
                   
			
    }
    
    $name_managers=array_merge($name_managers,$name_managers_b);
    unset($staff_testb);
 	
 }else{
$staff=implode(',',$formdata['dest_managers']);			
			
$sql2="select managerID, managerName from managers where managerID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
       $name_managers[$row->managerID]=$row->managerName;
                   
			
    }
  
 }   
// $staff=implode(',',$formdata["dest_managers"]); 
//  $sql = "SELECT managerName,managerID FROM managers WHERE managerID in ($staff) " ;
			
				 
				     foreach($name_managers as $key=>$val)
			 			$managersIDs[] = $key;
  
/*************************************************************************************************************/
	 
}elseif ($formdata['dest_managers']!='none' && $formdata['new_manager']!='none' 
   && array_item ($formdata,"new_manager")
   && count($formdata['new_manager'])>0
   && array_item ($formdata,"dest_managers") 
   && is_array(array_item ($formdata,"dest_managers"))    )   { 
   
  $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["dest_managers"]  ;
 // $usrID=$tmp;
 $i=0; 
        foreach($tmp as $usrID){		
           
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
				// new manager
			if(!array_item($formdata ,'insert_manager') && !is_array ($formdata ['insert_managers']) 
		    && !is_numeric ($formdata ['insert_manager'][0]) ){

		    	$sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
			  }else{
                $parent=$formdata['insert_manager'][$i]; 
				$sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
			} 
				if(!$db->execute($sql))
				return FALSE;
				$managersIDs[] = $db->insertId();
				
				$formdata['dest_managers']=$formdata['new_manager'];
				unset($formdata['new_manager']);
				
				$i++;
  
        } 
/*************************************************************************************************************/  
  }elseif( ($formdata['dest_managers']=='none'
  ||( !array_item ($formdata,"dest_managers") &&  !is_array(array_item ($formdata,"dest_managers"))   ))
    && $formdata['new_manager']!='none' 
   && array_item ($formdata,"new_manager")
   && count($formdata['new_manager'])>0 )   { 
   
  $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["dest_managers"]  ;
  $i=0; 
        foreach($tmp as $usrID){		
           
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
				// new manager
			if(!array_item($formdata ,'insert_manager') && !is_array ($formdata ['insert_manager']) 
		    && !is_numeric ($formdata ['insert_manager'][0]) ){

		    	$sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
			  }else{
                $parent=$formdata['insert_manager'][$i]; 
				$sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
			} 
				if(!$db->execute($sql))
				return FALSE;
				$managersIDs[] = $db->insertId();
                
				$formdata['dest_managers']=$formdata['new_manager'];
				unset($formdata['new_manager']);
				
				$i++;
        } 
   }   
 		return $managersIDs;
	}
  
/**************************************SAVE MANAGER*****************************************************************/	
	
function save_manager(&$formdata) {


		global $db;

		
if ($formdata['manager_forum']=='none' && !array_item ($formdata,"new_manager") 
   && !is_numeric(array_item ($formdata,"new_manager"))    )   { 
    unset ($formdata['manager_forum']);
    
  $tmp="";//$formdata["manager_forum"]  ? $formdata["manager_forum"] :  $formdata["new_manager"]  ;    
/*************************************************************************************************************/
 
			 			   
   }elseif ( ($formdata['manager_forum']!='none' 
   ||( array_item ($formdata,"manager_forum") &&  is_numeric(array_item ($formdata,"manager_forum"))   ) )
   && !array_item ($formdata,"new_manager")
   && !is_numeric(array_item ($formdata,"new_manager"))  )   { 
   
  $tmp= $formdata["manager_forum"]  ?$formdata["manager_forum"]: $formdata["new_manager"] ;
	     	$sql = "SELECT managerName,managerID FROM managers WHERE managerID = " .
				$db->sql_string($tmp);
				if($rows = $db->queryObjectArray($sql))
			 			$managersIDs = $rows[0]->managerID;

/*************************************************************************************************************/			 
}elseif ($formdata['manager_forum']!='none' && $formdata['new_manager']!='none' 
   && array_item ($formdata,"new_manager")
   && is_numeric(array_item ($formdata,"new_manager"))
   && array_item ($formdata,"manager_forum") 
   && is_numeric(array_item ($formdata,"manager_forum"))    )   { 
   
  $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["manager_forum"]  ;
  $usrID=$tmp; 		
           
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
				// new manager
  if(!array_item($formdata ,'insert_manager') && !is_numeric ($formdata ['insert_manager']) ){				
			$sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
  }else{
  	
     $parent=$formdata['insert_manager'];     
  	
  	
  	 $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " , $parent ,$usrID )";
  	
       }        
				if(!$db->execute($sql))
				return FALSE;
				
				$managersIDs = $db->insertId();
   
				$formdata['manager_forum']=$formdata['new_manager'];
				unset($formdata['new_manager']);
/*************************************************************************************************************/  
   }elseif( ($formdata['manager_forum']=='none'||( !array_item ($formdata,"manager_forum") &&  !is_numeric(array_item ($formdata,"manager_forum"))   )  )    
   && $formdata['new_manager']!='none' 
   && array_item ($formdata,"new_manager")
   && is_numeric(array_item ($formdata,"new_manager")))   { 
   
  $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["manager_forum"]  ;
	$usrID=$tmp;	
          
               $sql="SELECT full_name from users WHERE userID =$usrID";
                  if($rows=$db->queryObjectArray($sql))
                 $name=$rows[0]->full_name; 
	// new manager
if(!array_item($formdata ,'insert_manager') && !is_numeric ($formdata ['insert_manager']) ){				
		$sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
          }else{
  	
        $parent=$formdata['insert_manager'];     
  	
  	
  	     $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                 "VALUES (" . $db->sql_string($name) .   " , $parent ,$usrID )";
  	
       }        
               
				if(!$db->execute($sql))
				return FALSE;
				
				$managersIDs = $db->insertId();
				
				
				$formdata['manager_forum']=$formdata['new_manager'];
				unset($formdata['new_manager']);
         }
 		 
		return $managersIDs;
	}

/***************************SAVE CATEGORY1****************************************************************************/
 /*******************************************************************************************************/
 
	function save_category1(&$formdata) {


		global $db;
	
		
		if ($formdata['dest_forumsType']=='none' && !array_item ($formdata,"dest_forumsType") ){   
		 unset ($formdata['dest_forumsType']);
		$tmp= "";
	
/******************************************************************************************************/	
 
}elseif ( ($formdata['dest_forumsType']!='none' &&  $formdata['dest_forumsType']!=null
   && ( array_item ($formdata,"dest_forumsType") &&  is_array(array_item ($formdata,"dest_forumsType"))   ) )
   && (!array_item ($formdata,"new_category")  
			   ||  ($formdata["new_category"]=='none' )
			   ||  $formdata["new_category"]==null )  )   { 
   
   	
 $tmp= $formdata["dest_forumsType"]  ? $formdata["dest_forumsType"] :  $formdata["new_category"]  ; 


 $dest_forumsType= $formdata['dest_forumsType'];
 
foreach ($dest_forumsType as $key=>$val){
	if(!is_numeric($val)){
	$val=$db->sql_string($val);
   $staff_test[]=$val;
  }elseif(is_numeric($val) ){
  	 $staff_testb[]=$val;
  }			
}			
if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }

}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
$staff=implode(',',$staff_test);

$sql2="select catID, catName from categories1 where catName in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			 
			
  }	
$staffb=implode(',',$staff_testb);

$sql2="select catID, catName from categories1 where catID in ($staffb)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name_b[$row->catID]=$row->catName;
	}
      $name=array_merge($name,$name_b);
       unset($staff_testb);
}else{
$staff=implode(',',$formdata['dest_forumsType'])	;		
			
$sql2="select catID, catName from categories1 where catID in ($staff)";
		if($rows=$db->queryObjectArray($sql2))
		foreach($rows as $row){
			
			$name[$row->catID]=$row->catName;
			//$name[]=$row->catName;
			
  }
}  
 
 
// $staff=implode(',',$tmp);
//			  $sql = "SELECT  catName,catID,parentCatID FROM categories1 WHERE catID in ($staff)  " ;
				 
				 
				 foreach($name as $key=>$val)
			 	   $catsIDs []= $key;
  
/*************************************************************************************************************/	 
}elseif ($formdata['dest_forumsType']!='none'  &&  $formdata['dest_forumsType']!=null && trim($formdata['new_category']!='none') 
   && array_item ($formdata,"new_category")
   && count($formdata['new_category'])>0
   && array_item ($formdata,"dest_forumsType"))   { 
   
  $tmp= $formdata["new_category"]  ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
  $catNames=explode(';',$tmp);

                     
 
     $i=0;	
     	foreach($catNames as $catName){
          if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category'][0]) ){	
        		$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($catName) . " , '11')";
        		
             }else{
             	$parent=$formdata['insert_category'][$i];
             	$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($catName) . " , $parent)";
             }	
				 
       	
        		if(!$db->execute($sql))
				return FALSE;
				$catsIDs[] = $db->insertId();  
				
				
				
				$i++;
     }
     $formdata['dest_forumsType']=$catsIDs;
	 unset($formdata['new_category']);
/*************************************************************************************************************/	 
   }elseif( ($formdata['dest_forumsType']=='none' || $formdata['dest_forumsType']==null
   ||( !array_item ($formdata,"dest_forumsType") &&  !is_numeric(array_item ($formdata,"dest_forumsType"))   )  )    
   && $formdata['new_category']!='none'
   && $formdata['new_category']!=null 
   && count($formdata['new_category'])>0
   && array_item ($formdata,"new_category"))   { 
   
   	
   	
  $tmp= $formdata["new_category"]  ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
$catNames=explode(';',$tmp);

                     
 
     $i=0;	
     	foreach($catNames as $catName){
          if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category'][0]) ){	
        		$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($catName) . " , '11')";
        		
             }else{
             	$parent=$formdata['insert_category'][$i];
             	$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($catName) . " , $parent)";
             }	
				 
       	
        		if(!$db->execute($sql))
				return FALSE;
				$catsIDs[] = $db->insertId();  
				
				$formdata['dest_forumsType']=$formdata['new_category'];
				unset($formdata['new_category']);
				
				$i++;
        }
          		 
        $formdata['dest_forumsType']=$catsIDs;
		unset($formdata['new_category']);	
        	
              
        }
	   return $catsIDs;
   }
    		 
 
/**************************************************save_category_ajx**********************************************************/
	function save_category_ajx(&$formdata) {


		global $db;
	
		
if ( ($formdata['dest_forumsType']!='none' 
   ||( array_item ($formdata,"dest_forumsType") &&  is_array($formdata['dest_forumsType'] )   ) )
   && !array_item ($formdata,"new_forumType")
   && !is_numeric(array_item ($formdata,"new_forumType"))  )   { 
   
   	
 $tmp= $formdata["dest_forumsType"]  ;
 foreach($tmp as $key=>$val){
 
 	  $catsIDs[]=$val;
 } 

 
 
 if(is_array($formdata['insert_forumType']) && is_numeric($formdata['insert_forumType'][0]) && $formdata['insert_forumType']!='none' ){
   $i=0;
  $count_insert=count($formdata['insert_forumType']); 	
  foreach($catsIDs as $id){
              $parent=$formdata['insert_forumType'][$i];
               $sql = "update categories1 set  parentCatID=$parent WHERE catID=$id"  ;
             
        		if(!$db->execute($sql))
				return FALSE;
				$i++;
				
                     if($i==$count_insert){
						$i=$count_insert-1;
					}
       }
 
 }
 
 
 
 
 
 $formdata['dest_forumsType']=$catsIDs; 
/*************************************************************************************************************/	 
}elseif (is_array($formdata['dest_forumsType'])  && trim($formdata['new_forumType']!='none') 
   && array_item ($formdata,"new_forumType")
   && !is_numeric(array_item ($formdata,"new_forumType"))
   && array_item ($formdata,"dest_forumsType")    )   { 
   
    $tmp= $formdata["new_forumType"] ;// ? $formdata["new_forumType"]:$formdata["dest_forumsType"]  ;
    
  
$catForumNames=explode(';',$tmp);

                     
 
 $i=0;	
  foreach($catForumNames as $catName){

     	if(!array_item($formdata ,'insert_forumType') && !is_numeric ($formdata ['insert_forumType']) ){	
        		$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($tmp) . " , '11')";
        		
             }else{
             	$count_insert=count($formdata['insert_forumType']); 
             	$parent=$formdata['insert_forumType'][$i];
             	$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($catName) . " , $parent)";
             }	
        		if(!$db->execute($sql))
				return FALSE;
				$catsIDs []= $db->insertId();
				
				if($formdata['dest_forumsType'])
				unset($formdata['dest_forumsType']);
				
				$formdata['dest_forumsType'][0]=$catsIDs;
			 	
            $i++;
            
                   if($count_insert && $i==$count_insert){
						$i=$count_insert-1;
					}
           }
   	
				
$formdata['dest_forumsType']=$catsIDs; 
unset($formdata['new_forumType']);   
/*************************************************************************************************************/	 
   }elseif( ( !is_array($formdata['dest_forumsType']) || ( !array_item ($formdata,"dest_forumsType")    )  )    
   && $formdata['new_forumType']!='none' 
   && array_item ($formdata,"new_forumType")
   && !is_numeric(array_item ($formdata,"new_forumType")))   { 
   
   	
   	
  $tmp= $formdata["new_forumType"] ;// ? $formdata["new_forumType"]:$formdata["dest_forumsType"]  ;
    
  
$catForumNames=explode(';',$tmp);

                     
 
 $i=0;	
  foreach($catForumNames as $catName){

     	if(!array_item($formdata ,'insert_forumType') && !is_numeric ($formdata ['insert_forumType']) ){	
        		$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($tmp) . " , '11')";
        		
             }else{
             	$count_insert=count($formdata['insert_forumType']); 
             	$parent=$formdata['insert_forumType'][$i];
             	$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($catName) . " , $parent)";
             }	
        		if(!$db->execute($sql))
				return FALSE;
				$catsIDs[] = $db->insertId();
				
				if($formdata['dest_forumsType'])
				unset($formdata['dest_forumsType']);
				
				$formdata['dest_forumsType'][0]=$catsIDs;
				 
            $i++;
            
               if($count_insert && $i==$count_insert){
				    $i=$count_insert-1;
			     }
            
           }

   
      $formdata['dest_forumsType']=$catsIDs; 
      unset($formdata['new_forumType']);   
   
   }
        

        
        
	   return $catsIDs;
   }
   
 
/***************************SAVE MANAGERTYPE_ajx****************************************************************************/
 
 
	function save_managerType_ajx(&$formdata) {


		global $db;
	

		
if ( ($formdata['dest_managersType']!='none' 
   ||( array_item ($formdata,"dest_managersType") &&  is_array($formdata['dest_managersType'] )   ) )
   && !array_item ($formdata,"new_managerType")
   && !is_numeric(array_item ($formdata,"new_managerType"))  )   { 
   
   	
 $tmp= $formdata["dest_managersType"]  ;
 foreach($tmp as $key=>$val){
 	
 	
 	  $catTypeIDs[]=$val;
 } 

 
 
   if(is_array($formdata['insert_managerType']) && is_numeric($formdata['insert_managerType'][0]) &&  $formdata['insert_managerType']!='none' ){
   $i=0;	
   $count_insertMgr=count($formdata['insert_managerType']);
  foreach($catTypeIDs as $id){
              $parent=$formdata['insert_managerType'][$i];
  
             	$sql = "update manager_type set  parentManagerTypeID=$parent  WHERE managerTypeID=$id"  ;
             
        		if(!$db->execute($sql))
				return FALSE;
				
				$i++;
				
				if($i==$count_insertMgr){
				  $i=$count_insertMgr-1;
              }
 
          }
 
      }
 
 
 
 $formdata['dest_managersType']=$catTypeIDs; 		
//////////////////////////////////////////////////////////////////////////////////////		
		
//	if ($formdata['dest_managersType']!='none' &&  $formdata['dest_managersType']!=null
//			   && array_item ($formdata,"dest_managersType")
//			   && is_array(array_item ($formdata,"dest_managersType"))
//			   
//			   && (!array_item ($formdata,"new_managerType")
//			   && !count($formdata['new_managerType'])>0  
//			   ||  ($formdata["new_managerType"]=='none' )
//			   ||  $formdata["new_managerType"]==null ) )    { 
//			   
//			  $tmp= $formdata["dest_managersType"]  ; 
//			  
//			 $dest_managersType= $formdata['dest_managersType'];
//		
//			foreach ($dest_managersType as $key=>$val){
//				
//			if(!is_numeric($val)){
//				$val=$db->sql_string($val);
//			     $staff_test[]=$val;
//			   
//			     }elseif(is_numeric($val)){
//			  	$staff_testb[]=$val;
//			  	
//			    }	
//			}			
//
//
//if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
// $staff=implode(',',$staff_test);
// $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
//		
//     if($rows=$db->queryObjectArray($sql))
//		foreach($rows as $row){
//			
//       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
//                   
//			
//    }
//}elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
// $staff=implode(',',$staff_test);
// $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";
//		
//     if($rows=$db->queryObjectArray($sql))
//		foreach($rows as $row){
//			
//       $name_managerType[$row->managerTypeID]=$row->managerTypeName;
//                   
//			
//    }
//    
// $staff_b=implode(',',$staff_testb);
// $sql="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff_b)";
//		
//     if($rows=$db->queryObjectArray($sql))
//		foreach($rows as $row){
//			
//       $name_managerType_b[$row->managerTypeID]=$row->managerTypeName;
//                   
//			
//    }    
//    $name_managerType=array_merge($name_managerType,$name_managerType_b);
//    unset($staff_testb);
//    
//}else{
//$staff=implode(',',$formdata['dest_managersType']);			
//			
//$sql2="select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff)";
//		if($rows=$db->queryObjectArray($sql2))
//		foreach($rows as $row){
//			
//			$name_managerType[$row->managerTypeID]=$row->managerTypeName;
//			
//			
//  }
//  
//}  
//				 foreach($name_managerType as $key=>$val){
//			 	   $catTypeIDs []= $row->managerTypeID;
//				 }

/*************************************************************************************************************/	
}elseif ($formdata['dest_managersType']!='none' && trim($formdata['new_managerType']!='none') 
   && array_item ($formdata,"new_managerType")
   && count($formdata['new_managerType'])>0
   && !is_numeric($formdata["new_managerType"])
   && array_item ($formdata,"dest_managersType") ){ 
   
  $tmp= $formdata["new_managerType"]  ? $formdata["new_managerType"]:$formdata["dest_managersType"]  ;
  $catNames=explode(';',$tmp);

                     
 
     $i=0;	
     	foreach($catNames as $catName){
          if(!array_item($formdata ,'insert_managerType') && !is_numeric ($formdata ['insert_managerType'][0]) ){	
        		$sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                 "VALUES (" . $db->sql_string($catName) . " , '11')";
        		
             }else{
              $count_insertMgr=count($formdata['insert_managerType']);
             	$parent=$formdata['insert_managerType'][$i];
             	$sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                 "VALUES (" . $db->sql_string($catName) . " , $parent)";
             }	
				 
             
          
       	
        		if(!$db->execute($sql))
				return FALSE;
				$catTypeIDs[] = $db->insertId();  
				
				
				$i++;
				
     	    if($count_insertMgr &&  $i==$count_insertMgr){
				  $i=$count_insertMgr-1;
              }
				
     }
     
     
    $formdata['dest_managersType']=$catTypeIDs;
	unset($formdata['new_managerType']); 
/*************************************************************************************************************/	 
   }elseif( ($formdata['dest_managersType']=='none'||( !array_item ($formdata,"dest_managersType") &&  !is_numeric(array_item ($formdata,"dest_managersType"))   )  )    
   && $formdata['new_managerType']!='none'
   && count($formdata['new_managerType'])>0 
   && array_item ($formdata,"new_managerType"))   { 
   
   	
   	
  $tmp= $formdata["new_managerType"]  ? $formdata["new_managerType"]:$formdata["dest_managersType"]  ;
$catNames=explode(';',$tmp);

                     
 
     $i=0;	
     	foreach($catNames as $catName){
          if(!array_item($formdata ,'insert_managerType') && !is_numeric ($formdata ['insert_managerType'][0]) ){	
        		$sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                 "VALUES (" . $db->sql_string($catName) . " , '11')";
        		
             }else{
             	$count_insertMgr=count($formdata['insert_managerType']);
             	$parent=$formdata['insert_managerType'][$i];
             	$sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                 "VALUES (" . $db->sql_string($catName) . " , $parent)";
             }	
				 
       	
        		if(!$db->execute($sql))
				return FALSE;
				$catTypeIDs[] = $db->insertId();  
				
				 
				$i++;
				
     	    if($count_insertMgr &&  $i==$count_insertMgr){
				  $i=$count_insertMgr-1;
              }
				
        }
          		 
         $formdata['dest_managersType']=$catTypeIDs;
	     unset($formdata['new_managerType']); 	
        	
              
        }
	   return $catTypeIDs;
   }
    		 
 

/************************************************************************************************************/
   
   
   function save_category(&$formdata) {


		global $db;
	
		
		if ($formdata['dest_forumsType']=='none' && !array_item ($formdata,"dest_forumsType") ){   
		 unset ($formdata['dest_forumsType']);
		$tmp= "";
	
/******************************************************************************************************/	 
}elseif ( (   ($formdata['dest_forumsType']!='none' && $formdata['dest_forumsType'])
    
   ||( array_item ($formdata,"dest_forumsType") &&  is_array($formdata['dest_forumsType'] )   ) )
   && !array_item ($formdata,"new_category")
   && !is_numeric(array_item ($formdata,"new_category"))  )   { 
   
   	
 $tmp= $formdata["dest_forumsType"]  ;

 
 if(!(is_array($tmp)))
 $tmp=explode(',', $tmp);
 
 
 foreach($tmp as $key=>$val){
 	
 	//$catsIDs[]=$key;
 	  $catsIDs[]=$val;
 } 

  
/*************************************************************************************************************/	 
}elseif (is_array($formdata['dest_forumsType'])  && trim($formdata['new_category']!='none') 
   && array_item ($formdata,"new_category")
   && !is_numeric(array_item ($formdata,"new_category"))
   && array_item ($formdata,"dest_forumsType")    )   { 
   
  $tmp= $formdata["new_category"] ;// ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
     
         if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category']) ){	
        		$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($tmp) . " , '11')";
        		
             }else{
             	$parent=$formdata['insert_category'];
             	$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($tmp) . " , $parent)";
             }	
				if(!$db->execute($sql))
				return FALSE;
				$catsIDs = $db->insertId();
				
				$formdata['dest_forumsType'][0]=$catsIDs;
				unset($formdata['new_category']);
				
    
/*************************************************************************************************************/	 
   }elseif( ( !is_array($formdata['dest_forumsType']) || ( !array_item ($formdata,"dest_forumsType")    )  )    
   && $formdata['new_category']!='none' 
   && array_item ($formdata,"new_category")
   && !is_numeric(array_item ($formdata,"new_category")))   { 
   
   	
   	
  $tmp= $formdata["new_category"] ;// ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
    

     	if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category']) ){	
        		$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($tmp) . " , '11')";
        		
             }else{
             	$parent=$formdata['insert_category'];
             	$sql = "INSERT INTO categories1 (catName,parentCatID) " .
                 "VALUES (" . $db->sql_string($tmp) . " , $parent)";
             }	
        		if(!$db->execute($sql))
				return FALSE;
				$catsIDs = $db->insertId();
				
				$formdata['dest_forumsType'][0]=$catsIDs;
				unset($formdata['new_category']);  	
            
        }
	   return $catsIDs;
   }
    		 
 
/******************************************************************************************************/

	function save_managerType(&$formdata) {
     global $db;
		
     
     if ($formdata['dest_managersType']=='none' && !array_item ($formdata,"dest_managersType") ) {  
      unset ($formdata['dest_managersType']);
	    $tmp= $formdata["dest_managersType"]  ? $formdata["dest_managersType"] :  $formdata["new_type"]  ;
     	
/*************************************************************************************************************/	 		

			 	   		
}elseif ( ($formdata['dest_managersType']!='none'  
        ||(  array_item ($formdata,"dest_managersType") &&  is_numeric(array_item ($formdata,"dest_managersType"))   ) )
        && !array_item ($formdata,"new_type") 
        && !is_numeric(array_item ($formdata,"new_type"))  )   { 
   
   	
   
	$tmp= $formdata["dest_managersType"]  ? $formdata["dest_managersType"] :  $formdata["new_type"]  ; 
	
	
$tmp= $formdata["dest_managersType"]  ;

 if(!(is_array($tmp)))
 $tmp=explode(',', $tmp);
 
    foreach($tmp as $key=>$val){ 	
 	//$catTypesIDs[]=$key;
 	$catTypesIDs[]=$val;
 } 

//			$sql = "SELECT  managerTypeName,managerTypeID,parentManagerTypeID FROM manager_type WHERE managerTypeID =$tmp " ;
//				if($rows = $db->queryObjectArray($sql))
//			 	   $catTypesIDs= $rows[0]->managerTypeID;
   
  		
/*************************************************************************************************************/	 
}elseif ($formdata['dest_managersType']!='none'  && trim($formdata["new_type"]!='none') 
		   && array_item ($formdata,"new_type")
		   && !is_numeric(array_item ($formdata,"new_type"))
		   && array_item ($formdata,"dest_managersType") 
		   && is_numeric(array_item ($formdata,"dest_managersType"))    )   { 
   
$tmp= $formdata["new_type"]  ? $formdata["new_type"]  :$formdata["dest_managersType"]  ; 
			
 $tmp=$db->sql_string($tmp);

                if(!array_item($formdata ,'insert_managerType') && !is_numeric ($formdata ['insert_managerType']) ){	
	                  $sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                    "VALUES ($tmp , '11')";
		    		
	             }else{
	             	$parent=$formdata['insert_managerType'];
	             	$sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                    "VALUES ( $tmp  ,  $parent )";
	             }	
					if(!$db->execute($sql))
					return FALSE;
					$catTypesIDs = $db->insertId();
					
					$formdata['managerType']=$catTypesIDs;
				     unset($formdata['new_type']);
         
/*************************************************************************************************************/	 
 }	elseif( ($formdata['dest_managersType']=='none'||( !array_item ($formdata,"dest_managersType")  &&  !is_numeric(array_item ($formdata,"dest_managersType") )   )  )    
   && $formdata["new_type"]!='none' 
   && array_item ($formdata,"new_type")
   && !is_numeric(array_item ($formdata,"new_type")))   { 
   
   	
   	
  $tmp= $formdata["new_type"]  ? $formdata["new_type"]  :$formdata["dest_managersType"]  ;
   $tmp=$db->sql_string($tmp);
     
              if(!array_item($formdata ,'insert_managerType') && !is_numeric ($formdata ['insert_managerType']) ){	
	                  $sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                    "VALUES ($tmp) , 11)";
		    		
	             }else{
	             	$parent=$formdata['insert_managerType'];
	             	$sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
                    "VALUES ( $tmp    ,  $parent )";
	             }	
					if(!$db->execute($sql))
					return FALSE;
					$catTypesIDs = $db->insertId();
					
					$formdata['dest_managersType']=$catTypesIDs;
				     unset($formdata['new_type']);
        
   }   
/*************************************************************************************************************/	
  return $catTypesIDs;        
  }    
/***************************************************************************************************/
 
	function conn_user_forum($forum_decID,&$usersIDs,&$formdata="",$dateIDs="",$date_usr="")
	{
		global $db;

//$formdata['src_users2'] for connection	
		
foreach($usersIDs as $key=>$val){
     if(!$result["users"])
			 $result["users"] = $key;
			else
			 $result["users"] .= "," . $key;
		 }
	$staff=$result["users"];  
				  
     $formdata['usr']= $usersIDs;    
         
/***********************************************************************************/
 /***************************************************/
//foreach($formdata['dest_users'] as $key=>$val){
///**************************************************/
//$member_date="member_date$i"  ;
//	
//
//$num= $db->sql_string($formdata['forum_decID']) ;	
//$sql="select rel_date ,userID from rel_user_forum where userID=$key and forum_decID=$num  ";
//$rows1=$db->queryObjectArray($sql);	
//
// 
//  if( !(array_item($formdata[src_users2],$key)) ){
//  	list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->rel_date);
//   $rows1[0]->rel_date="$day_date-$month_date-$year_date";	
// 
//  
//} elseif($formdata[$member_date]!=null && $rows1[0]->rel_date!=0){
//   list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->rel_date);
//   $rows1[0]->rel_date="$day_date-$month_date-$year_date";	
///*****************************************************************************************/   
//$frm=new forum_dec();
//   $formdata1[$member_date][$rows1[0]->userID]=$formdata[$member_date];
//    if(!$frm->check_date($formdata1[$member_date][$rows1[0]->userID]) )	
//       $formdata1[$member_date][$rows1[0]->userID]=$rows1[0]->rel_date;
//   $formdata[$member_date]=$rows1[0]->rel_date;
//   
//   
//   
//   list($ayear,$amonth,$aday) = explode('-',$formdata1 [$member_date][$rows1[0]->userID]);
//  
//	 if (strlen($ayear) > 3){
//		$a = $ayear . $amonth . $aday; 
//		}elseif(strlen($aday)==4){
//     $a =$aday . $ayear . $amonth ;	
//    }	
//            
//    
//list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->rel_date);
//    if(strlen($day_date)==4 ){
//    $rows1[0]->rel_date="$year_date-$month_date-$day_date";
//    }elseif(strlen($year_date)==4){
//     $rows1[0]->rel_date="$day_date-$month_date-$year_date"; 
/**********************************************************************************/     
if($formdata['src_users2'] && $formdata['src_users2']!='none'){
	 $sql = "SELECT userID,full_name FROM users  " .
           " WHERE userID in($staff) " ;
$i=0;  
$j=0; 	
if($rows = $db->queryObjectArray($sql)){
     foreach($rows as $row){
	if(array_item($formdata['src_users2'] ,$row->userID  )){
		        
		         unset ($formdata['usr'][$row->userID]);
		         $j++;
	           }else{
		 	 			$i++;
		 			}	
		 }	
	}
 }		 
	

//add new with multi date reset the $i $dateIDs==left of $formdata['usr'] have users already
 if( (array_item($formdata,'usr') && count($formdata['usr'])>0  )   
      &&(count($dateIDs) == count($formdata['usr']) )   ){

      	
    $i=0;	 	 
     foreach($formdata['usr'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       

		    
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$i];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
     $sql="select userID from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!$rows=$db->queryObjectArray($sql)){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		       	$sql = "UPDATE rel_user_forum SET  
           HireDate=   $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
		    $i++;
		  }
//dont have src_users only new users $dateIDs==null	     
}elseif((array_item($formdata,'usr') && count($formdata['usr'])>0) && $dateIDs==null ){

//$i=0;	
// $member_date="member_date$i"  ;
  foreach($formdata['usr'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       

		    
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$i];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
     $sql="select userID from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!$rows=$db->queryObjectArray($sql)){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		       	$sql = "UPDATE rel_user_forum SET  
           HireDate=   $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
		    $i++;
		  }
	
	
	
}elseif( (array_item($formdata,'usr') && count($formdata['usr'])>0  )   
      &&(count($dateIDs) > count($formdata['usr']) )   ){
	$i=0;	 	 
     foreach($formdata['usr'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       
		   
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$j];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
     $sql="select userID from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!$rows=$db->queryObjectArray($sql)){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		       	$sql = "UPDATE rel_user_forum SET  
           HireDate=   $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
		    $i++;
		  }
//dont have src_users only new users $dateIDs==null	     
}elseif((array_item($formdata,'usr') && count($formdata['usr'])>0) && $dateIDs==null ){
  foreach($formdata['usr'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       
		   
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$i];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
     $sql="select userID from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!$rows=$db->queryObjectArray($sql)){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		       	$sql = "UPDATE rel_user_forum SET  
           HireDate=   $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
		    $i++;
		  }
	
	
	
}elseif(array_item($formdata,'dest_users') && count($formdata['dest_users'])>0   ){
/////////////
//$i=0;
//$member_date="member_date$i"  ;	
////////////
     foreach($formdata['dest_users'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       
		   
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$i];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
      $sql="select userID from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		   if(!$db->queryObjectArray($sql)){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date)";
 
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		   }else{
		       	$sql = "UPDATE rel_user_forum SET  
           HireDate=   $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			}
	  	
		   	
		   	
		   
		    
		    $i++;
		  }	
	
      }
/*******************************************************************************************/      
$i=0;
if( is_array($formdata['usr_id_date'])   
   && array_item($formdata,'member_date0')
   && array_item($formdata,'dest_users')
   &&  count($formdata['dest_users'])>0 ){
$today=$db->sql_string($formdata['today']);
 
foreach($formdata['usr_id_date'] as $key=>$val  ){
//	$member_date="member_date$i";
	if(!$this->check_date($val)  ){
	$sql = "UPDATE rel_user_forum SET  
           HireDate=   $today
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
	if(!$db->execute($sql))
	return FALSE;
		
    	}
//if(!$this->check_date($formdata[$member_date])  ){
//	$sql = "UPDATE rel_user_forum SET  
//           rel_date=   $today
//	       WHERE userID=$key
//	       AND forum_decID =$forum_decID";
//	if(!$db->execute($sql))
//	return FALSE;
//		
//	}
	
	
    }
	
 }



//foreach($formdata['dest_users'] as $row){
//			$member_date="member_date$i"; 
//			list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$formdata[$member_date]);
//     	        if (strlen($year_date_the_date) < 3){
//		           $formdata[$member_date]="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
//	    	    }else{
//			       $formdata[$member_date]="$day_date_the_date-$month_date_the_date-$year_date_the_date";
//	    	    } 
//			$rows['full_date'][$i] =$formdata[$member_date];
//			
//		$i++;	
//		}
		




//elseif(array_item($formdat,'member') && array_item($formdat,'date_src_users') && count($formdat['date_src_users'])>0 ){
//  $i=0;
//		     	
//		foreach($formdata['dest_users'] as $row){
//			$member_date="member_date$i"; 
//			
//			 list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$formdata[$member_date]);
//     	        if (strlen($year_date_the_date) > 3){
//		           $formdata[$member_date]="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
//	    	    }else{
//			       $formdata[$member_date]="$day_date_the_date-$month_date_the_date-$year_date_the_date";
//	    	    }  
//			
//			
//			
//			$rows['full_date'][$i] =$formdata[$member_date];
//			
//		$i++;	
//		}
//      			
//	
//} 

 
       return TRUE; 	   	
	}
/**********************************************************************/
/***********************************************************************************/

function conn_user_forum_test($forum_decID,$usersIDs,$dateIDs,$date_usr,&$formdata){
		global $db;

if($formdata['dynamic_9']==1){		
	if(array_item($formdata,'forum_decID') || is_numeric($forum_decID)){
			
	$forum_decID=array_item($formdata,'forum_decID')?array_item($formdata,'forum_decID'):$forum_decID;		
	$formdata["dest_users"]=$formdata["dest_users$forum_decID"];
	}
}
//$formdata['src_users2'] for connection	
		
  foreach($usersIDs as $key=>$val){
     if(!$result["users"])
			 $result["users"] = $key;
			else
			 $result["users"] .= "," . $key;
		 }
	$staff=$result["users"];  
				  
     $formdata['usr']= $usersIDs;    
         
/***********************************************************************************/
if($formdata['src_users2'] && $formdata['src_users2']!='none'){
	 $sql = "SELECT userID,full_name FROM users  " .
           " WHERE userID in($staff) " ;
$i=0;  
$j=0; 	
if($rows = $db->queryObjectArray($sql)){
     foreach($rows as $row){
	if(array_item($formdata['src_users2'] ,$row->userID  )){
		        
		         unset ($formdata['usr'][$row->userID]);
		         $j++;
	           }else{
		 	 			$i++;
		 			}	
		 }	
	}
 }		 
	

//add new with multi date reset the $i $dateIDs==left of $formdata['usr'] have users already
 if( (array_item($formdata,'usr') && count($formdata['usr'])>0  )   
      &&(count($dateIDs) <= count($formdata['usr']) )   ){

      	
    $i=0;
    	 	 
     foreach($formdata['usr'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       

		    
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
		      
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$i];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
     $sql="select userID,active from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!($rows=$db->queryObjectArray($sql)) ){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,rel_date,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		  $active=$rows[0]->active;	
		 $sql = "UPDATE rel_user_forum SET
		  active=$active,    
           rel_date=   $the_date,
           HireDate=$the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
	    $i++;
		  }
//dont have src_users only new users $dateIDs==null	     
}elseif((array_item($formdata,'usr') && count($formdata['usr'])>0) && $dateIDs==null ){

//$i=0;	
// $member_date="member_date$i"  ;
  foreach($formdata['usr'] as $key=>$val){
       
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
		      
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$i];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
     $sql="select userID from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!($rows=$db->queryObjectArray($sql))  ){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,rel_date,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		  $active=$rows[0]->active;
		  $sql = "UPDATE rel_user_forum SET
		   active=$active,    
           rel_date=   $the_date,
           HireDate= $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
		    $i++;
		  }
	
	
	
}elseif( (array_item($formdata,'usr') && count($formdata['usr'])>0  )   
      &&(count($dateIDs) > count($formdata['usr']) )    ){
	$i=0;
	$j=0;	 	 
     foreach($formdata['usr'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       
		   
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
		      
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$j];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
     $sql="select userID,active from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!$rows=$db->queryObjectArray($sql)){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,rel_date,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		  	$active=$rows[0]->active;
		   $sql = "UPDATE rel_user_forum SET  
		   active=$active,  
           rel_date=   $the_date,
           HireDate  = $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
		    $i++;
		    $j++;
		  }
//dont have src_users only new users $dateIDs==null	     
}elseif((array_item($formdata,'usr') && count($formdata['usr'])>0) && $dateIDs==null ){
  foreach($formdata['usr'] as $key=>$val){
        
 
		      $the_date=$date_usr;//$dateIDs;
		      
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
 


		    
     $sql="select userID,active from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		    if(!($rows=$db->queryObjectArray($sql)) ){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,rel_date,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date,$the_date)";
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		  }else{
		  $active=$rows[0]->active;	
   $sql = "UPDATE rel_user_forum SET  
	       active=$active,  
           rel_date=   $the_date,
           HireDate=  $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			} 
		    
		    $i++;
		  }
	
	
	
}elseif(array_item($formdata,'dest_users') && count($formdata['dest_users'])>0   ){
     foreach($formdata['dest_users'] as $key=>$val){
        if (is_array($dateIDs) && count($dateIDs)>0)           
		    if(count($dateIDs)==$i )
		    $i-=1;	       
		   
if(!is_array($dateIDs))	{
		      $the_date=$date_usr;//$dateIDs;
		      
/******************************************/		      
		       list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }
/******************************************/	    	      
		       $the_date=$db->sql_string($the_date);
  }else{
             $the_date=$dateIDs[$i];
             
/******************************************/             
             list($day_date_the_date,$month_date_the_date,$year_date_the_date ) = explode('-',$the_date);
     	        if (strlen($year_date_the_date) > 3){
		           $the_date="$year_date_the_date-$month_date_the_date-$day_date_the_date";	
	    	    }else{
			       $the_date="$day_date_the_date-$month_date_the_date-$year_date_the_date";
	    	    }  
/******************************************/             
              $the_date=$db->sql_string($the_date); 	
		    }  	

		    
      $sql="select userID,active from rel_user_forum where userID=$key and forum_decID=$forum_decID";		    
		   if(!($rows_frm=$db->queryObjectArray($sql)) ){
		    $sql = "INSERT INTO rel_user_forum (forum_decID,userID,rel_date,HireDate) " .
             "VALUES ($forum_decID, $key,$the_date,$the_date)";
 
           
		 	if(!$db->execute($sql)){
		 		return FALSE;
		      
		    }
		   }else{
		  $active=$rows_frm[0]->active; 	
   $sql = "UPDATE rel_user_forum SET
		   active=$active,  
           rel_date=   $the_date,
           HireDate=   $the_date
	       WHERE userID=$key
	       AND forum_decID =$forum_decID";
			if(!$db->execute($sql))
			return FALSE;
				
			}
	  	
		   	
		   	
		   
		    
		    $i++;
		  }	
	
      }
/*******************************************************************************************/   
//if($formdata[src_users] && $formdata['src_usersID'] 
//&& is_array($formdata['src_usersID']) && is_array($formdata['src_users']) ){
// 		$i=0;//count($formdata['src_users'])-1;
//		$frmID=$formdata['forum_decID'] ? $formdata['forum_decID']:$forum_decID;	
//		if($usersIDs && is_array($usersIDs)   ){
//		foreach($usersIDs as $key=>$val){
//		//$member="member_date$i";	
//		if(is_numeric($key)){	
//		$sql="select rel_date  from rel_user_forum where userID=$key and forum_decID=$frmID  ";
//		if($rows1=$db->queryObjectArray($sql)){
//			
//			$rows1[0]->rel_date=substr($rows1[0]->rel_date,0,10);
//			
//			list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->rel_date);
//		    if(strlen($year_date)==4 ){
//		    $rows1[0]->rel_date="$day_date-$month_date-$year_date";
//		    }elseif(strlen($day_date)==4){
//		     $rows1[0]->rel_date="$year_date-$month_date-$day_date"; 
//		    } 
//		     
//		    
//		    $member_date="member_date$i"  ;
//		    $formdata[$member_date]=$rows1[0]->rel_date;  
//		   // $formdata["dest_users$frmID"][$i]=$key;       
//		}	
//			$i++;
//		    }
//			
//		  }
//		
//		}
//   }else{
   $i=0;
		$frmID=$formdata['forum_decID'] ? $formdata['forum_decID']:$forum_decID;	
		if($usersIDs && is_array($usersIDs)   ){
		foreach($usersIDs as $key=>$val){
		//$member="member_date$i";	
		if(is_numeric($key)){	
		$sql="select HireDate  from rel_user_forum where userID=$key and forum_decID=$frmID  ";
		if($rows1=$db->queryObjectArray($sql)){
			
			$rows1[0]->HireDate=substr($rows1[0]->HireDate,0,10);
			
			list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->HireDate);
		    if(strlen($year_date)==4 ){
		    $rows1[0]->HireDate="$day_date-$month_date-$year_date";
		    }elseif(strlen($day_date)==4){
		     $rows1[0]->HireDate="$year_date-$month_date-$day_date"; 
		    } 
		     
		    
		    $member_date="member_date$i"  ;
		    $formdata[$member_date]=$rows1[0]->HireDate; 
		     $formdata['member_date'][$i]=$rows1[0]->HireDate;  
		    
		    
		       
		 }	
			$i++;
			 
	    }
		
	  }
	 
	}
   	
  //}		
/********************************************************************************************/
// $i=0;
//if( is_array($formdata['usr_id_date'])   
//   && array_item($formdata,'member_date0')
//   && array_item($formdata,'dest_users')
//   &&  count($formdata['dest_users'])>0 ){
//$today=$db->sql_string($formdata['today']);
// 
//foreach($formdata['usr_id_date'] as $key=>$val  ){
////	$member_date="member_date$i";
//	if(!$this->check_date($val)  ){
//	$sql = "UPDATE rel_user_forum SET  
//           rel_date=   $today
//	       WHERE userID=$key
//	       AND forum_decID =$forum_decID";
//	if(!$db->execute($sql))
//	return FALSE;
//		
//    	}
//    	
//    	
//
//	
//    }
//	
// }
/***************************************************************************/
if($formdata['dynamic_9']){
$formdata["dest_users_tmp"]=$formdata["dest_users"]; 	
 $i=0; 	
if($usersIDs && is_array($usersIDs)   ){
foreach($usersIDs as $key=>$val){
if(is_numeric($key)){	
$sql="select userID,full_name  from users where userID=$key  ";
if($rows=$db->queryObjectArray($sql)){
 
	 $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
	 
    
      $i++;
    
  }
  $formdata["dest_users$frmID"]=$results;
  
   $formdata["dest_users"]=$results; 
       }
 
     } 
   }

   
  } 
       return TRUE; 	   	
 }
/**********************************************************************/
/***********************************************************************************/	
	
	
function conn_user_forum1($forum_decID,$usersIDs,$dateIDs)
	{
		global $db;
    $sql = "INSERT INTO rel_user_forum(forum_decID,userID,HireDate) " .
      "VALUES ($forum_decID, $usersIDs,$dateIDs[0])";
		if(!$db->execute($sql))
		return FALSE;
		return true;
	}
/**********************************************************************************************/
function del_usr_frm($usrID,$frmID){
	global $db;

$tags = get_user_tags($usrID,$frmID);
	      
              if($tags && $tags[0] !=null) {
	         	$s = implode(',', $tags);
	         	if($s && $s!=null){
        		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
	         	}
		        $db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
	          }  

	           $sql="select * from rel_user_task where userID=$usrID  AND forum_decID=$frmID";
	              if($rows=$db->queryObjectArray($sql)){
	    	         $sql = "DELETE FROM rel_user_task WHERE userID=$usrID
		   	          AND forum_decID=$frmID";
		       $db->execute($sql);
	    	
	         }      
	
	
	
	
	
$sql="DELETE from rel_user_forum WHERE  userID=$usrID AND forum_decID=$frmID";
if(!$db->execute($sql)){
  show_error_msg("חבר לא קיים");	
 } else
 return true;	
} 		 
 /*******************************************************************************************************/
	function conn_manager_forum($forum_decID,$managersIDs)
	{
		global $db;
		// connect forum and forum
		foreach($managersIDs as $managerID) {

		$sql = "INSERT INTO rel_managerType_forum(forum_decID,managerID) " .
         "VALUES ($forum_decID, $managerID)";
		if(!$db->execute($sql)){
		$sql = "select full_name from users where userID =$managerID  " ;
         $rows=$db->queryObjectArray($sql);
         $full_name=$rows[0]->full_name;     
         echo "<p> כבר קיים מנהל בפורום בשם $full_name.</p>\n";			
          return FALSE;
		 }
		}
		return true;
	}
/**********************************************************************/
	
function conn_user_manager($usersIDs,$managersIDs,$formdata)
	{
	$managerID=$formdata['manager_forum'];
		global $db;
		// connect forum and forum
		foreach($usersIDs as $userID) {

		$sql = "INSERT INTO rel_user_manager(userID,managerID) " .
         "VALUES ($userID, $managerID)";
		if(!$db->execute($sql)){
		  echo "haven't done a validatione yet";			
         // return FALSE;
		 }
		}
		return true;
	}
/**********************************************************************/
	
function conn_manager_appoint($managersIDs,$appointsIDs,$formdata)
	{
	$appointID=$formdata['appoint_forum'];
		global $db;
		// connect forum and forum
		foreach($managersIDs as $managerID) {

		$sql = "INSERT INTO rel_manager_appoint(managerID,appointID) " .
         "VALUES ($managerID,$appointID)";
		if(!$db->execute($sql)){
					
          return FALSE;
		 }
		}
		return true;
	}
/**********************************************************************/

	function conn_manager_user($userID,$managersIDs)
	{
		global $db;
		// connect forum and forum
		foreach($managersIDs as $managerID) {

		$sql = "INSERT INTO rel_manager_user(managerID,userID) " .
         "VALUES ($managerID, $userID)";
		if(!$db->execute($sql)){
		$sql = "select full_name from users where userID =$userID  " ;
         $rows=$db->queryObjectArray($sql);
         $full_name=$rows[0]->full_name;     
          echo "<p> כבר קיים משתמש בשם תחת מנהל זה $full_name.</p>\n";			
          return FALSE;
		 }
		}
		return true;
	}
/**********************************************************************/
	function conn_manger_user($userID,$managersIDs)
	{
		global $db;
    $sql = "INSERT INTO rel_manager_user(userID,managerID) " .
      "VALUES ($userID, $managersIDs)";
		if(!$db->execute($sql))
		return FALSE;
		return true;
	}
/*******************************************************************************************************/	 
/*******************************************************************************************************/	
function conn_manager_forum1($forum_decID,$managersIDs)
	{
		global $db;
    $sql = "INSERT INTO rel_managerType_forum(forum_decID,managerTypeID) " .
      "VALUES ($forum_decID, $managersIDs)";
		if(!$db->execute($sql))
		return FALSE;
		return true;
	}
/*******************************************************************************************************/
		
	function conn_cat_forum1($forum_decID,$catID)
	{
		global $db;
	$sql = "INSERT INTO rel_cat_forum (forum_decID,catID) " .
      "VALUES ($forum_decID,$catID)";

		if(!$db->execute($sql))
		return FALSE;
		return true;
	}

/**********************************************************************/
/*******************************************************************************************************/
	function conn_cat_forum($forum_decID,$catIDs,$formdata="")
	{
		global $db;

		 
	foreach($catIDs as $frm_cat){	

$sql="select forum_decID,catID from rel_cat_forum
	   WHERE forum_decID=$forum_decID AND catID=$frm_cat";

if(!$rows=$db->queryObjectArray($sql)){	
		
	$sql = "INSERT INTO rel_cat_forum (forum_decID,catID) " .
      "VALUES ($forum_decID,$frm_cat)";
	 if(!$db->execute($sql)){
		 return FALSE;
		}
     } 
	} 
		return true;
	}
	
/**********************************************************************/

	function conn_type_manager($forum_decID,$catTypeIDs,$formdata="")
	{
		global $db;


	 	 
    foreach($catTypeIDs as $mng_cat){
$sql="select forum_decID,managerTypeID from rel_managerType_forum
	   WHERE forum_decID=$forum_decID AND managerTypeID=$mng_cat";

if(!$rows=$db->queryObjectArray($sql)){
    
$sql = "INSERT INTO rel_managerType_forum (forum_decID,managerTypeID) " .
      "VALUES ($forum_decID,$mng_cat)";
			if(!$db->execute($sql)){
				return FALSE;
			}
       
		}
      }		
		 
		return true;
	}
/**********************************************************************/	
/**********************************************************************/	
	function message_save( &$subcatarray ,$forum_decID){
			

		// message
		echo "<p>.נישמר/עודכן  הפורום  ",
		build_href2("dynamic_10.php","mode=read_data", "&editID=$forum_decID", $subcatarray),
	    " </p>\n";
		return TRUE;
	}
/**********************************************************************/
	function message_update($formdata,$forum_decID){
		 
// echo "<p><b>עודכן הפורום . ",build_href2("dynamic_8.php","mode=read_data", "&editID=$forum_decID", $formdata['forum_decName'],"id=msg_update")," </b></p>\n";
$url="../admin/find3.php?forum_decID=$forum_decID";
$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
echo "<p><b>עודכן הפורום . ",build_href5("", "", $formdata['forum_decName'],$str)," </b></p>\n";
	 
		return TRUE;
	}
	
/**********************************************************************/
/**********************************************************************/	
	function message_save_b( &$subcatarray ,$forum_decID){
		$url="../admin/find3.php?forum_decID=$forum_decID";
		$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
		echo "<p><b>עודכן הפורום . ",build_href5("", "", $formdata['forum_decName'],$str)," </b></p>\n";
		
		return TRUE;
	}
	
/**********************************************************************/
	function message_save_c( &$subcatarray ,$forum_decID){
		$url="../admin/find3.php?forum_decID=$forum_decID";
		$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
		echo "<p><b>עודכן הפורום . ",build_href5("", "", $subcatarray,$str)," </b></p>\n";
		
		return TRUE;
	}
	
/**********************************************************************/
	
	function message_update_b($formdata,$forum_decID){

//		echo "<p><b>עודכן הפורום . ",
//        build_href4("#","", "", $formdata['forum_decName'],"id=msg_update class=href_info"),"  
//		</b></p>\n";
		
		$url="../admin/find3.php?forum_decID=$forum_decID";
		$str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';		
		// echo "<p><b>עודכן הפורום . ",build_href5("", "", $formdata['forum_decName'],$str)," </b></p>\n";	

	$url2="../admin/find3.php?forum_decID=$forum_decID";
$str2="<span><a onClick=openmypage3('".$url2."');   class=href_modal1  href='javascript:void(0)' >
                  <b style='color:brown;font-size:1.4em;'>$formdata[forum_decName]<b>
                 </a></span>";	
 

echo '<table style="width:300px;height:25px;overflow:hidden;">
         <tr><td><p  data-module="הפורום:'.$str2.'" >			      
          </p></td></tr>
         </table>'; 	
		 
		
		
		return TRUE;
	}
	
/**********************************************************************/
	
	function ID_or_NULL($id) {
		if($id=="none")
		return 'NULL';
		else
		return $id;
	}
 
	function num_or_NULL($n) {
		if(is_numeric($n))
		return $n;
		else
		return 'NULL';
	}
/******************************************************************************************************/
function config_date(&$formdata){
/************************************FORUM_DATE***************************************************/	
//   $formdata['month_date']  = str_pad($formdata['month_date'] , 2, "0", STR_PAD_LEFT);
//   $formdata['day_date']  = str_pad($formdata['day_date'] , 2, "0", STR_PAD_LEFT);
//   	
// 
//    $formdata['month_date']  = str_pad($formdata['month_date'] , 2, "0", STR_PAD_LEFT);
//    $formdata['day_date']  = str_pad($formdata['day_date'] , 2, "0", STR_PAD_LEFT);	 
//    
//  
//	 $formdata['forum_date']="$formdata[day_date]-$formdata[month_date]-$formdata[year_date]";
/********************************************************************************************/
				
	list( $day_date_today,$month_date_today,$year_date_today) = explode('-',$formdata['today']);
	     if (strlen($year_date_today) > 3){
	       $month_date_today = str_pad($month_date_today, 2, "0", STR_PAD_LEFT);
           $day_date_today= str_pad($day_date_today, 2, "0", STR_PAD_LEFT); 
		$formdata['today']="$day_date_today-$month_date_today-$year_date_today";
		}else{
			 $month_date_today = str_pad($month_date_today, 2, "0", STR_PAD_LEFT);
              $day_date_today= str_pad($day_date_today, 2, "0", STR_PAD_LEFT);
			//to check
			$formdata['today']="$year_date_today-$month_date_today-$day_date_today";
		}			
		
/********************************************************************************************************/		  
	if($formdata['forum_date']){
				
	list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$formdata['forum_date']);
     if (strlen($year_date_forum) > 3){
		$forum_date="$day_date_forum-$month_date_forum-$year_date_forum";
		$formdata['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
		}else{
			$forum_date="$year_date_forum-$month_date_forum-$day_date_forum";
			//to check
			$formdata['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";
		}			
}		
/********************************************************************************************************/		  
 if($formdata['appoint_date1']){	
	list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$formdata['appoint_date1']);
	 if (strlen($year_date_appoint) > 3){
		$formdata['appoint_date1']="$day_date_appoint-$month_date_appoint-$year_date_appoint";	
		}
					
	list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$formdata['manager_date']);
		$year_date_manager1="'$year_date_manager'";
	 if (strlen($year_date_manager) > 3){
		$formdata['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
		}	
 }		
/***************************************************************************************************/    
 if($formdata['multi_year'] && $formdata['multi_month'] &&  $formdata['multi_day'] )  {
	       unset ($_SESSION['multi_year']) ;
           unset ($_SESSION['multi_month']) ;
           unset ($_SESSION['multi_day'])  ;
  	   	
	   	  $i=0;
	   	  foreach($formdata['multi_month'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_month'][$i]=$dt;
	   	  $i++;
	   	  }
	   $i=0;
	   	  foreach($formdata['multi_day'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_day'][$i]=$dt;
	   	  $i++;
	   	  }
//store date in a session
          $_SESSION['multi_year']=$formdata['multi_year'];
          $_SESSION['multi_month']=$formdata['multi_month'];
          $_SESSION['multi_day'] =$formdata['multi_day'];
     }    
/***********************************************************************************************/   
/******************************************************************************************************/
  if(array_item($formdata,'dynamic_6') || array_item($formdata,'dynamic_6b')  ){ 
 if($formdata['multi_year'] && $formdata['multi_month'] &&  $formdata['multi_day'] )  {
	       unset ($_SESSION['multi_year']) ;
           unset ($_SESSION['multi_month']) ;
           unset ($_SESSION['multi_day'])  ;
  	   	
	   	  $i=0;
	   	  foreach($formdata['multi_month'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_month'][$i]=$dt;
	   	  $i++;
	   	  }
	   $i=0;
	   	  foreach($formdata['multi_day'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_day'][$i]=$dt;
	   	  $i++;
	   	  }
//store date in a session
          $_SESSION['multi_year']=$formdata['multi_year'];
          $_SESSION['multi_month']=$formdata['multi_month'];
          $_SESSION['multi_day'] =$formdata['multi_day'];
     }    
   
/*************************************************************************************************************/  
  if($formdata['multi_year_appoint'] && $formdata['multi_month_appoint'] &&  $formdata['multi_day_appoint'] )  {
	       unset ($_SESSION['multi_year_appoint']) ;
           unset ($_SESSION['multi_month_appoint']) ;
           unset ($_SESSION['multi_day_appoint'])  ;
  	   	
	   	  $i=0;
	   	  foreach($formdata['multi_month_appoint'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_month_appoint'][$i]=$dt;
	   	  $i++;
	   	  }
	   $i=0;
	   	  foreach($formdata['multi_day_appoint'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_day_appoint'][$i]=$dt;
	   	  $i++;
	   	  }
//store date in a session
          $_SESSION['multi_year_appoint']=$formdata['multi_year_appoint'];
          $_SESSION['multi_month_appoint']=$formdata['multi_month_appoint'];
          $_SESSION['multi_day_appoint'] =$formdata['multi_day_appoint'];
     }   
/******************************************************************************************************/
  if($formdata['multi_year_manager'] && $formdata['multi_month_manager'] &&  $formdata['multi_day_manager'] )  {
	       unset ($_SESSION['multi_year_manager']) ;
           unset ($_SESSION['multi_month_manager']) ;
           unset ($_SESSION['multi_day_manager'])  ;
  	   	
	   	  $i=0;
	   	  foreach($formdata['multi_month_manager'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_month_manager'][$i]=$dt;
	   	  $i++;
	   	  }
	   $i=0;
	   	  foreach($formdata['multi_day_manager'] as $dt){
	   	  $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
	   	  $formdata['multi_day_manager'][$i]=$dt;
	   	  $i++;
	   	  }
//store date in a session
          $_SESSION['multi_year_manager']=$formdata['multi_year_manager'];
          $_SESSION['multi_month_manager']=$formdata['multi_month_manager'];
          $_SESSION['multi_day_manager'] =$formdata['multi_day_manager'];
     }

     
  }    
/********************************************************************************************************/     
}  
/***************************************************************************/
	function make_calendar_pulldown_a(&$formdata) {


			form_new_line();
			form_label2("תאריך הקמת הפורום:");
             
			
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
	if((!is_numeric($formdata ["year_date_forum"])) && (!is_numeric($formdata ['month_date_forum'])) && (!is_numeric($formdata["day_date_forum"]))    ){ 
	echo '<td>';	
//	 form_list33("year_date_forum" ,$years, array_item($formdata, "year_date_forum") );
// 
//            form_list33("month_date_forum" ,$months, array_item($formdata, "month_date_forum") );
//           
//            form_list33("day_date_forum" ,$days, array_item($formdata, "day_date_forum") );
            form_list3("year_date_forum" ,$years,$dates['year'], array_item($formdata, "year_date_forum") );
 
            form_list3("month_date_forum" ,$months,$dates['mon'], array_item($formdata, "month_date_forum") );
           
            form_list3("day_date_forum" ,$days, $dates['mday'], array_item($formdata, "day_date_forum") );
    echo '</td>', "\n";
			 
	}else{
		echo '<td>';	
            form_list3("year_date_forum" ,$years,$formdata ["year_date_forum"], array_item($formdata, "year_date_forum") );
 
            form_list3("month_date_forum" ,$months,$formdata ['month_date_forum'], array_item($formdata, "month_date_forum") );
           
            form_list3("day_date_forum" ,$days, $formdata["day_date_forum"], array_item($formdata, "day_date_forum") );
    echo '</td>', "\n";
		
		
		
	}     	  
			 
			 
			form_end_line();
			
			
}  
		
/***************************************************************************/
	function make_calendar_pulldown() {


			form_new_line();
			form_label2("תאריך הוספת חבר לפורום:");
             
			
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
            form_list3("year_date_addusr" ,$years,$dates['year'], array_item($formdata, "year_date_addusr") );
 
            form_list3("month_date_addusr" ,$months,$dates['mon'], array_item($formdata, "month_date_addusr") );
           
            form_list3("day_date_addusr" ,$days, $dates['mday'], array_item($formdata, "day_date_addusr") );
    echo '</td>', "\n";
			 
	     	  
			 
			 
			form_end_line();
			
			
}  
/*****************************************************************************/	

function make_calendar_pulldown1() {


			form_new_line();
			form_label2("תאריך הקמת הפורום:");
             
			
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
            form_list3("year_date_delusr" ,$years,$dates['year'], array_item($formdata, "year_date_delusr") );
 
            form_list3("month_date_delusr" ,$months,$dates['month'], array_item($formdata, "month_date_delusr") );
           
            form_list3("day_date_delusr" ,$days, $dates['mday'], array_item($formdata, "day_date_delusr") );
    echo '</td>', "\n";
			 
	     	  
			 
			 
			form_end_line();
			
			
}  
 
/******************************************************************************************************/
	function make_calendar_pulldown2() {


			form_new_line();
			form_label2("תאריך הקמת הפורום:");
             
			
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
            form_list3("year_date_forum" ,$years,$dates['year'], array_item($formdata, "year_date_forum") );
 
            form_list3("month_date_forum" ,$months,$dates['month'], array_item($formdata, "month_date_forum") );
           
            form_list3("day_date_forum" ,$days, $dates['mday'], array_item($formdata, "day_date_forum") );
    echo '</td>', "\n";
			 
	     	  
			 
			 
			form_end_line();
			
			
    } 

/********************************CONFIG APPOINT BEFORE UPDATE LIKE A TRIGGER*******************************/
function config_beforeAppoint_update($formdata,$formselect){
	global $db;
$forum_decID=($formdata['forum_decID']) ? $formdata["forum_decID"] : $formdata["id"];



$appointdata =($formdata["appoint_forum"]) ? $formdata["appoint_forum"] : $formdata["appointID"];
$appointselect =($formselect["appoint_forum"]) ? $formselect["appoint_forum"] : $formselect["appointID"];

if(is_numeric($this->columns['appointID']) ){	    	
if($appointdata==$appointselect){
UNSET($this->columns['appointID']);
 }
}


if($appointdata!=$appointselect){
$appID=$db->sql_string($appointselect);
$frmid=$db->sql_string($forum_decID);

/***************************************************************************/
list($day_date_appSel,$month_date_appSel,$year_date_appSel ) = explode('-',$formselect['appoint_date']);
	 if (strlen($year_date_appSel) > 3){
		$formselect['appoint_date']="$year_date_appSel-$month_date_appSel-$day_date_appSel";	
		}else{
			$formselect['appoint_date']="$day_date_appSel-$month_date_appSel-$year_date_appSel";
	  }

/************************************************************************************/
list($day_date_rel_appSel,$month_date_rel_appSel,$year_date_rel_appSel ) = explode('-',$formdata['appoint_date1']);
	 if (strlen($year_date_rel_appSel) > 3){
		$formdata['appoint_date1']="$year_date_rel_appSel-$month_date_rel_appSel-$day_date_rel_appSel";	
		}else{
		 $formdata['appoint_date1']="$day_date_rel_appSel-$month_date_rel_appSel-$year_date_rel_appSel";
	  }

/************************************************************************************/	  
$start_date=$db->sql_string($formselect['appoint_date']);
$end_date=$db->sql_string($formdata['appoint_date1']);
$change_date=$db->sql_string($formdata['today']);

if($start_date==$end_date)
$end_date=$change_date;
else
$end_date=$db->sql_string($formdata['appoint_date1']);

$sql="INSERT into appoint_forum_history 
	  (appointID, forum_decID, start_date, end_date)
	values
	  ($appID, $frmid, $start_date, $end_date)";
     if(!$db->execute($sql)){
 		return FALSE;
 	}	
  }
  
} 








/***********************************************************************************************/
/***********************************************************************************************/
/********************************CONFIG MANAGER BEFORE UPDATE LIKE A TRIGGER*******************************/
function config_beforeMgr_update($formdata,$formselect){
	global $db;
$forum_decID=($formdata['forum_decID']) ? $formdata["forum_decID"] : $formdata["id"];
$managerdata =($formdata["manager_forum"]) ? $formdata["manager_forum"] : $formdata["managerID"];
$managerselect =($formselect["manager_forum"]) ? $formselect["manager_forum"] : $formselect["managerID"];

if(is_numeric($this->columns['managerID']) ){	    	
if($managerdata==$managerselect){
UNSET($this->columns['managerID']);
 }
}


if($managerdata!=$managerselect){
$mgrID=$db->sql_string($managerselect);
$frmid=$db->sql_string($forum_decID);


$sql="SELECT managerName FROM managers WHERE managerID=$mgrID ";
if($rows=$db->queryObjectArray($sql)){
	
  $managerName=$rows[0]->managerName;
  $managerName=$db->sql_string($managerName);	
}

/***************************************************************************/
list($day_date_mgrSel,$month_date_mgrSel,$year_date_mgrSel ) = explode('-',$formselect['manager_date']);
	 if (strlen($year_date_mgrSel) > 3){
		$formselect['manager_date']="$year_date_mgrSel-$month_date_mgrSel-$day_date_mgrSel";	
		}else{
		$formselect['manager_date']="$day_date_mgrSel-$month_date_mgrSel-$year_date_mgrSel";
	  }

/************************************************************************************/
	 list($day_date_rel_mgrSel,$month_date_rel_mgrSel,$year_date_rel_mgrSel ) = explode('-',$formdata['manager_date']);
	 if (strlen($year_date_rel_mgrSel) > 3){
		$formdata['manager_date']="$year_date_rel_mgrSel-$month_date_rel_mgrSel-$day_date_rel_mgrSel";	
		}else{
		$formdata['manager_date']="$day_date_rel_mgrSel-$month_date_rel_mgrSel-$year_date_rel_mgrSel";
	  }

/************************************************************************************/ 
$start_date=$db->sql_string($formselect['manager_date']);
$end_date=$db->sql_string($formdata['manager_date']);
$change_date=$db->sql_string($formdata['today']);



if($start_date==$end_date){
$end_date=$change_date;
}else{
$end_date=$db->sql_string($formdata['manager_date']);
}

/**************************************************************************/
//if($this-> DateSort($end_date,$start_date)){


/*************************************************************************/
$sql="INSERT into manager_forum_history 
	  (managerID, forum_decID, start_date, end_date,managerName)
	values
	  ($mgrID, $frmid, $start_date, $end_date,$managerName)";
     if(!$db->execute($sql)){
 		return FALSE;
 	}	

 	
 	
 	
 	
 	

    }//if($managerdata!=$managerselect) 
    
 }//end function
/***********************************************************************************************/
/***********************************************************************************************/






function get_errors($form_data,$rules){
	// returns an array of errors
	$errors=array();
	foreach($form_data as $name=>$value){
		if(!isset($rules[$name]))continue;
		$hname=htmlspecialchars($name);
		$rule=$rules[$name];
		if(isset($rule['required']) && $rule['required'] && !$value)
			$errors[]='Field '.$hname.' is required.';
		if(isset($rule['minlength']) && strlen($value)<$rule['minlength'])
			$errors[]=$hname.' should be at least '.$rule['minlength'].' characters in length.';
		 
		$rules[$name]['found']=true;
	}
	foreach($rules as $name=>$values){
		if(!isset($values['found']) && isset($values['required']) && $values['required'])
			$errors[]='Field '.htmlspecialchars($name).' is required.';
	}
	return $errors;
}
/*************************************************************************************************/
function restore_tree($frmID){
/*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
 
global $db;
   
   
 
	$sql = "SELECT d.decName,d.decID,d.parentDecID,f.forum_decName 
				FROM decisions d,forum_dec f, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID =f.forum_decID
			     AND r.forum_decID = $frmID
		         ORDER BY  d.decName ";

				
	if($rows = $db->queryObjectArray($sql)){			

    $forum_decName=$rows[0]->forum_decName;

 treedisplayDown($rows,$formdata);
    $rootAttributes = array("decID"=>"11" ); 
   
    $treeID = "treev1";
     $tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
       $str="ערוך החלטות"	;
         $tv->setRootHTMLText($str);
  
  $tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
    $tv->printTreeViewScript();

 
	

     
    
    
    
    
    
 }//end if
	
	
}
 
/**********************************************/
function restore_tree_2($frmID){
/*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
/*********************************************/ 	
global $db;
   $formdata=FALSE;
      
   
 
	$sql = "SELECT d.decName,d.decID,d.parentDecID,f.forum_decName 
				FROM decisions d,forum_dec f, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID =f.forum_decID
			     AND r.forum_decID = $frmID
		         ORDER BY  d.decName ";

				
	if($rows = $db->queryObjectArray($sql)){			

    $forum_decName=$rows[0]->forum_decName;
     
 treedisplayDown($rows,$formdata);
   $rootAttributes = array("decID"=>"11","flag_print"=>"1");
    $treeID = "treev2";
     $tv1 = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
      $str="ערוך את ההחלטות"	;
     
     $tv1->setRootHTMLText($str);
    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
  
    $tv1->printTreeViewScript();

 

 }//end if
	
	
}
/*************************************************************************************************/

function restore_tree2($frmID,$count_form=""){
	
	global $db;
   $formdata=FALSE;
      
   
 
	  $sql = "SELECT d.decName,d.decID,d.parentDecID 
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
			     AND r.forum_decID = $frmID
		         ORDER BY  d.decName ";

				
	if($rows = $db->queryObjectArray($sql)){			
		if(!(ae_detect_ie())){
/******************************************************************/		
treedisplayDown($rows,$formdata);
    $rootAttributes = array("decID"=>"11" ); 
   
    $treeID = "treev1$frmID";
    $treeID_frm = $frmID;
    $count_file=$count_form;
    $tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID,$treeID_frm,$count_file);
       $string="ערוך את ההחלטות"	;
     $tv->setRootHTMLText($string);
  
  $tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
  
    $tv->printTreeViewScript();

 
/*********************************************************************************************/	

// treedisplayDown($rows,$formdata);
// 
//   $rootAttributes = array("decID"=>"11","flag_print"=>"1");
//    $treeID = "treev2$frmID";
//     $treeID_frm2 = $frmID;
//     $tv1 = DBTreeView::createTreeView(
//		$rootAttributes,
//		TREEVIEW_LIB_PATH, 
//		$treeID,$treeID_frm2);
//      $str="צפה בהחלטות"	;
//     $tv1->setRootHTMLText($str);
//    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
//  
//    $tv1->printTreeViewScript();
/********************************************************/
		}else{
/********************************************************/			
//			treedisplayDown($rows,$formdata);
//    $rootAttributes = array("decID"=>"11" ); 
//   
//    $treeID = "treev1";
//    
//    $tv = DBTreeView::createTreeView(
//		$rootAttributes,
//		TREEVIEW_LIB_PATH, 
//		$treeID);
//       $string="ערוך את ההחלטות"	;
//     $tv->setRootHTMLText($string);
//  
//  $tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
//  
//    $tv->printTreeViewScript();
/**************************test***********************************************/
 treedisplayDown($rows,$formdata);
    $rootAttributes = array("decID"=>"11" ); 
   
    $treeID = "treev1$frmID";
    $treeID_frm = $frmID;
    $count_file=$count_form;
    $tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID,$treeID_frm,$count_file);
       $string="ערוך את ההחלטות"	;
     $tv->setRootHTMLText($string);
  
  $tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
  
    $tv->printTreeViewScript();
/*********************************************************************************************/	

// treedisplayDown($rows,$formdata);
// 
//   $rootAttributes = array("decID"=>"11","flag_print"=>"1");
//    $treeID = "treev2";
//   
//     $tv1 = DBTreeView::createTreeView(
//		$rootAttributes,
//		TREEVIEW_LIB_PATH, 
//		$treeID);
//      $str="צפה בהחלטות"	;
//     $tv1->setRootHTMLText($str);
//    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
//  
//    $tv1->printTreeViewScript();
	}
 }//end if
}	
/***************************************************************************************************/
/**********************************************/
function restore_tree_win($frmID,$count_form){
/*********************************************/
   if(array_item($_SESSION, 'level')=='user'){
   	 $flag_level=0;
   	 $level=false;
	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php       
   }else{
   	$level=true;
   	$flag_level=1;
   	
   	?>
	<input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" /> 
	<?php
   	
   }     
/*********************************************/ 	
global $db;
   $formdata=FALSE;
      
   
 
	$sql = "SELECT d.decName,d.decID,d.parentDecID,f.forum_decName 
				FROM decisions d,forum_dec f, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID =f.forum_decID
			     AND r.forum_decID = $frmID
		         ORDER BY  d.decName ";

				
	if($rows = $db->queryObjectArray($sql)){			

    $forum_decName=$rows[0]->forum_decName;
     
 treedisplayDown($rows,$formdata);
 
   $rootAttributes = array("decID"=>"11","flag_print"=>"1");
   
   
   $treeID = "treev2$frmID";
    $treeID_frm = $frmID;
    $count_file=$count_form;

    $tv1 = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID,$treeID_frm,$count_file);
   
   
   
     $str="צפה בהחלטות"	;
     
     $tv1->setRootHTMLText($str);
    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
  
    $tv1->printTreeViewScript();

    
    

 }//end if
	
	
}
/*************************************************************************************************/

function del_taskOrtag( $forum_decID,&$formdata="",$formselect="")
{
	global  $db;
 
$usrNames_dest=Array();
$usrNames_src=Array();		

//------------------------------------------------------------------------------------------
             //$formdata["dest_forums"]
//------------------------------------------------------------------------------------------	
$i=0;
if($forum_decID){
if( $formdata["dest_users2$forum_decID"] && $formdata["dest_users2$forum_decID"]!='none'  && is_array($formdata["dest_users2$forum_decID"])){ 
foreach ($formdata["dest_users2$forum_decID"] as $usr){
		if($i==0)
		$usr_dest = $usr;
		else
		$usr_dest .= "," . $usr;
		$i++;
 }
}

if( $formdata["src_users2$forum_decID"] && $formdata["src_users2$forum_decID"]!='none'  && is_array($formdata["src_users2$forum_decID"])){
$i=0;
foreach ($formdata["src_users2$forum_decID"] as $usr){
		if($i==0)
		$usr_src = $usr;
		else
		$usr_src .= "," . $usr;
		$i++;
   }
 }

}

 
if( $formdata["dest_users2"] && $formdata["dest_users2"]!='none'  && is_array($formdata["dest_users2"])){
	$i=0; 
foreach ($formdata["dest_users2"] as $usr ){
		if($i==0)
		$usr_dest = $usr ;
		else
		$usr_dest .= "," . $usr ;
		$i++;
   }
 }
 
 if( $formdata["src_users2"] && $formdata["src_users2"]!='none'  && is_array($formdata["src_users2"])){
 $i=0;	
foreach ($formdata["src_users2"] as $usr ){
		if($i==0)
		$usr_src = $usr ;
		else
		$usr_src .= "," . $usr ;
		$i++;
 }
}
//------------------------------------------------------------------------------------------
                         //$formdata["dest_users$decID"]
//------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------
                           //make assosc
//-------------------------------------ASSOC-----------------------------------------------------
if($usr_dest){
$sql1="SELECT userID,full_name FROM users WHERE userID in($usr_dest)";
if($rows=$db->queryObjectArray($sql1)){
foreach($rows as $row){
	
	$usrNames_dest[$row->userID]=$row->full_name;
   }		
  }
}
//--------------------------------------ASSOC----------------------------------------------------
if($usr_src){
$sql2="SELECT userID,full_name FROM users WHERE userID in($usr_src)";
if($rows=$db->queryObjectArray($sql2)){
foreach($rows as $row){
	
	$usrNames_src[$row->userID]=$row->full_name;
  }
 }	
}
//------------------------------------------------------------------------------------------
                        //UNSET
//------------------------------------------------------------------------------------------

$i=0;
if(   $usrNames_src 
      && $usrNames_src!='none'  
      && is_array($usrNames_src)
      && (count($usrNames_src)>0)
      && $usrNames_dest 
      && $usrNames_dest!='none'  
      && is_array($usrNames_dest)
      &&  (count($usrNames_dest)>0) 
      && (count($usrNames_dest))>=(count($usrNames_src))   ){

 foreach($usrNames_dest as $key=>$val){

 	if(in_array($val, $usrNames_src)){
    
       unset($usrNames_dest[$key]);
       unset($usrNames_src[$key]);//delete only users_forums  added or take out from rel_user_Decforum
 	} 
 	
 	$i++;
 }
}elseif( $usrNames_src 
      && $usrNames_src!='none'  
      && is_array($usrNames_src)
      &&  count($usrNames_src)>0 
      && $usrNames_dest 
      && $usrNames_dest!='none'  
      && is_array($usrNames_dest)
      &&  (count($usrNames_dest)>0) 
      && (count($usrNames_dest))<(count($usrNames_src))   ){

 foreach($usrNames_src as $key=>$val){
 	
 	if(array_item( $usrNames_dest,$key)){
    
       unset($usrNames_src[$key]);
       unset($usrNames_dest[$key]);//delete only users_forums  added or take out from rel_user_Decforum
 	} 
 	
 	$i++;
 }
	
	
}
	
//------------------------------------------------------------------------------------------
                       //delete all the chain
//TRUNCATE TABLE  tag2task
//TRUNCATE TABLE  tags
//TRUNCATE TABLE rel_user_task 
//TRUNCATE TABLE todolist                       
//------------------------------------------------------------------------------------------	
if(is_array($usrNames_src) && (count($usrNames_src)>0) ){ 
 	
foreach($usrNames_src as $key=>$val){
  	
///////////////////////////////////////////////DELETE FROM TODOLIST////////////////////////////////////////////
 $task_sql="SELECT taskID FROM rel_user_task WHERE forum_decID=$forum_decID AND  userID=$key  || dest_userID=$key ";
		if($rows_task=$db->queryObjectArray($task_sql) ){
		//	if($rows_task[0]->taskID)
		for($i=0; $i<count($rows_task); $i++){	
				if($i==0){
					$taskIDs = $rows_task[$i]->taskID;
				}else{
					$taskIDs .= "," . $rows_task[$i]->taskID;

		       }		
	      }	

	      
	      
 $tag_sql="select tagID from tag2task where taskID in($taskIDs)";
   	    if($rows=$db->queryObjectArray  ($tag_sql)) {

   	    for($i=0; $i<count($rows); $i++){	
				if($i==0){
					$tag_taskIDs = $rows[$i]->tagID;
				}
				else{
					$tag_taskIDs .= "," . $rows[$i]->tagID;

				}
		
			}      
	      
	      
			
$sql = "DELETE FROM tag2task WHERE  taskID in($taskIDs)";
  if(!($db->execute($sql)))
  return FALSE;			
			
 $sql = "DELETE FROM rel_user_task WHERE forum_decID=$forum_decID and userID=$key ";
  if(!($db->execute($sql)))
  return FALSE;			
			
			
			
			
		
			
		$tag_taskIDs=explode(',',$tag_taskIDs);	
   	    $tag_taskIDs=array_unique($tag_taskIDs);
   	    $tag_taskIDs=implode(',',$tag_taskIDs);	
        $db->execute("UPDATE tags  SET tags_count=tags_count-1 WHERE tagID IN ($tag_taskIDs)");
	    $db->execute("DELETE FROM  tags WHERE tags_count < 1");	# slow on large amount of tags  

	    $sql4 = "DELETE FROM todolist WHERE   taskID in($taskIDs)  ";
     	if(!$db->execute($sql4))
   	    return FALSE; 
	
      }//end if tags	

  }//end if tasks 
/////////////////////////////////////////////DELETE FROM REL_USER_FORUM+USER_TAGS//////////////////////////////////////////// 
   	     
 
  $tag_sql="SELECT tagID FROM rel_user_forum WHERE forum_decID=$forum_decID and userID=$key ";
   	    if($rows=$db->queryObjectArray  ($tag_sql) ) {
           if($rows[0]->tagID){
   	    	$tag_userIDs = $rows[0]->tagID;
			
   	    	
$sql = "DELETE FROM rel_user_forum WHERE forum_decID=$forum_decID and userID=$key ";
  if(!($db->execute($sql)))
  return FALSE;		

 	
    $db->execute("UPDATE user_tags  SET tags_count=tags_count-1 WHERE tagID = $tag_userIDs ");
    $db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
    
     }else{
		 	$sql = "DELETE FROM rel_user_forum WHERE forum_decID=$forum_decID and userID=$key ";
		  if(!($db->execute($sql)))
		  return FALSE;		
		 }     			 

   }//end if rows in rel_user_forum_tags
//------------------------------------------------------------------------------------------     
 else{
 	$sql = "DELETE FROM rel_user_forum WHERE forum_decID=$forum_decID and userID=$key ";
  if(!($db->execute($sql)))
  return FALSE;		
 }  
//------------------------------------------------------------------------------------------   
//    }//end foreach		
//------------------------------------------------------------------------------------------
    
////////////////////////////////////////////DELETE EVENT FROM EVENT////////////////////////////////////////////  
  $event_sql="SELECT id FROM rel_user_event WHERE forum_decID=$forum_decID AND  userID=$key ";
//$event_sql="SELECT id,forum_decID FROM rel_user_event WHERE AND  userID=$key ";        

  if($rows=$db->queryObjectArray($event_sql)){
  	
        
  	
  for($i=0; $i<count($rows); $i++){	
				if($i==0){
					$eventIDs = $rows[$i]->id;
				}
				else{
					$eventIDs .= "," . $rows[$i]->id;

				}
		
			}
    $sql4 = "DELETE FROM rel_user_event WHERE forum_decID=$forum_decID  AND userID=$key ";
		
		if(!$db->execute($sql4))
		 return FALSE;

		 
        $event_sqlDel = "DELETE FROM event WHERE id in($eventIDs)  ";
     	if(!$db->execute($event_sqlDel))
   	    return FALSE; 
	  
  } 	

//------------------------------------------------------------------------------------------   
    }//end foreach		
//------------------------------------------------------------------------------------------  
 }//end src
//------------------------------------------------------------------------------------------ 
 return true;
}//end func
//------------------------------------------------------------------------------------------


















function delmgr_taskOrtag($managerdata,$managerselect,$forum_decID){
global $db;	

 if($managerdata!=$managerselect){

$new_mgrID=$managerdata;	
$mgrID=$managerselect;	
//-------------------------------------ASSOC-----------------------------------------------------
	
	 
	
$sql="SELECT userID FROM managers WHERE managerID=$mgrID ";
if($rows=$db->queryObjectArray($sql)){
	
  $key=$rows[0]->userID;
  	
}
	
if($key){//if(userID)	
///////////////////////////////////////////////DELETE FROM TODOLIST////////////////////////////////////////////
$task_sql="SELECT taskID FROM rel_user_task WHERE forum_decID=$forum_decID AND  userID=$key  || dest_userID=$key ";
		if($rows_task=$db->queryObjectArray($task_sql) ){
			
		for($i=0; $i<count($rows_task); $i++){	
				if($i==0){
					$taskIDs = $rows_task[$i]->taskID;
				}else{
					$taskIDs .= "," . $rows_task[$i]->taskID;

		       }		
	      }	

	      
	      
		$tag_sql="select tagID from tag2task where taskID in($taskIDs)";
   	    if($rows=$db->queryObjectArray  ($tag_sql)) {

   	    for($i=0; $i<count($rows); $i++){	
				if($i==0){
					$tag_taskIDs = $rows[$i]->tagID;
				}
				else{
					$tag_taskIDs .= "," . $rows[$i]->tagID;

				}
		
			}      
	      
	      
			
$sql = "DELETE FROM tag2task WHERE  taskID in($taskIDs)";
  if(!($db->execute($sql)))
  return FALSE;			
			
 $sql = "DELETE FROM rel_user_task WHERE forum_decID=$forum_decID and userID=$key ";
  if(!($db->execute($sql)))
  return FALSE;			
			
			
			
			
		
			
		$tag_taskIDs=explode(',',$tag_taskIDs);	
   	    $tag_taskIDs=array_unique($tag_taskIDs);
   	    $tag_taskIDs=implode(',',$tag_taskIDs);	
        $db->execute("UPDATE tags  SET tags_count=tags_count-1 WHERE tagID IN ($tag_taskIDs)");
	    $db->execute("DELETE FROM  tags WHERE tags_count < 1");	# slow on large amount of tags  

	    $sql4 = "DELETE FROM todolist WHERE   taskID in($taskIDs)  ";
     	if(!$db->execute($sql4))
   	    return FALSE; 
	
      }//end if tags	

  }//end if tasks 
/////////////////////////////////////////////DELETE FROM forum_dec+TAGS//////////////////////////////////////////// 
   	     
 $tag_sql="select tagID from forum_dec WHERE forum_decID=$forum_decID AND  managerID=$new_mgrID ";
       
   	    if($rows=$db->queryObjectArray  ($tag_sql)) {

   	    	$tag_mgrIDs = $rows[0]->tagID;
		if($tag_mgrIDs)	{
   	    $sql = "UPDATE forum_dec SET  
           duedate=NULL,
           tagID=NULL,
           tags=''
           WHERE forum_decID=$forum_decID and managerID=$mgrID ";
		      	    	
//$sql = "UPDATE forum_dec set (duedaet,tagID) WHERE forum_decID=$forum_decID and managerID=$mgrID ";
  if(!($db->execute($sql)))
  return FALSE;		

 	
    $db->execute("UPDATE user_tags  SET tags_count=tags_count-1 WHERE tagID = $tag_mgrIDs ");
    $db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
   }       			 
//------------------------------------------------------------------------------------------
 }//end if rows in rel_user_forum_tags
//------------------------------------------------------------------------------------------     
		 else{
		 	$sql = "UPDATE forum_dec SET  
           duedate=NULL,
          tags=''
           WHERE forum_decID=$forum_decID and managerID=$new_mgrID ";
		 	
		 if(!($db->execute($sql)))
           return FALSE;		
		 }  
//------------------------------------------------------------------------------------------   
////////////////////////////////////////////DELETE EVENT FROM EVENT////////////////////////////////////////////  
  $event_sql="SELECT id FROM rel_user_event WHERE forum_decID=$forum_decID AND  userID=$key ";        

  if($rows=$db->queryObjectArray($event_sql)){
  	
  for($i=0; $i<count($rows); $i++){	
				if($i==0){
					$eventIDs = $rows[$i]->id;
				}
				else{
					$eventIDs .= "," . $rows[$i]->id;

				}
		
			}
    $sql4 = "DELETE FROM rel_user_event WHERE forum_decID=$forum_decID  AND userID=$key ";
		
		if(!$db->execute($sql4))
		 return FALSE;

		 
        $event_sqlDel = "DELETE FROM event WHERE id in($eventIDs)  ";
     	if(!$db->execute($event_sqlDel))
   	    return FALSE; 
	}  
//---------------------------------------------------------------------------------------------------
    }//end if($key) 
//---------------------------------------------------------------------------------------------------
  }	//end if
}//end func
        function html_footer(){
            ?>
            </td>

            </tr>

            </table>


            </body>
            </html>

            <?php
        }
}//end class forum
/******************************************************************************************************/


?>
 
