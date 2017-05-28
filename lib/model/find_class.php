<?php

require_once (HTML_DIR.'/edit_find.php');

global $lang;
class find {
    private $decPattern;
    private $forumPattern;
    private $forumPattern1;
    private $datePattern;
    private $datePattern1;
    private $letterPattern;
    private $treePatternDown;
    private $treePatternUp;
    private $catID;
    private $cat_forumID;
    private $userID;
    private $managerID;
    private $managerTypeID;
    private $user_forum;
    private $appoint_forum;
    private $appointID;
    private $decID;
    protected $forum_decID;
    protected $active;
    protected $editID;
    protected $vote_level;
    protected  $dec_level;
    protected  $status;
    public  $submitbutton;
    public  $formdata = array();
    public $pagesize = 10;
    /*****************************************************************************************************/
    function set ($decPattern="",$forumPattern="",$forumPattern1="",$datePattern="",$datePattern1="",$letterPattern="",$treePatternDown="",$treePatternUp="") {
        $this->setdecPattern($decPattern);
        $this->setforumPattern($forumPattern);
        $this->setforumPattern1($forumPattern1);
        $this->setdatePattern($datePattern);
        $this->setdatePattern1($datePattern1);
        $this->setletterPattern($letterPattern);
        $this->settreePatternDown($treePatternDown);
        $this->settreePatternUp($treePatternUp);
    }
    /**********************************************************************************************/
    function setdecPattern($decPattern) {
        $this->decPattern = $decPattern;
    }
    function getdecPattern() {
        return $this->decPattern;
    }
    /**********************************************************************************************/
    function setforumPattern($forumPattern) {
        $this->forumPattern = $forumPattern;
    }
    function getforumPattern() {
        return $this->forumPattern;
    }
    /**********************************************************************************/
    function setforumPattern1($forumPattern1) {
        $this->forumPattern1 = $forumPattern1;
    }
    function getforumPattern1() {
        return $this->forumPattern1;
    }
    /**********************************************************************************/
    function setdatePattern ($datePattern) {
        $this->datePattern = $datePattern;
    }
    function getdatePattern () {
        return $this->datePattern;
    }
    /**********************************************************************************/
    function setdatePattern1 ($datePattern1) {
        $this->datePattern1 = $datePattern1;
    }
    function getdatePattern1 () {
        return $this->datePattern1;
    }
    /**********************************************************************************/
    function setletterPattern ($letterPattern) {
        $this->letterPattern = $letterPattern;
    }

    function getletterPattern () {
        return $this->letterPattern;
    }
    /*****************************************************************************************/
    function settreePatternDown ($treePatternDown) {
        $this->treePatternDown = $treePatternDown;
    }

    function gettreePatternDown () {
        return $this->treePatternDown;
    }


    /*****************************************************************************************/
    function settreePatternUp ($treePatternUp) {
        $this->treePatternUp = $treePatternUp;
    }

    function gettreePatternUp () {
        return $this->treePatternUp;
    }
    /*****************************************************************************************/
    // 	function __get( $key )
    //	{
    //		return $this->fields[ $key ];
    //	}
    //
    //	function __set( $key, $value )
    //	{
    //		if ( array_key_exists( $key, $this->fields ) )
    //		{
    //			$this->fields[ $key ] = $value;
    //			return true;
    //		}
    //		return false;
    //	}
    /**********************************************************************************************/
    function __isset($name){
        return isset($this->formdata [$name]);
    }
    /***************************************************************************/
    function getDeclaredVariable(){
        return $this->declaredvar;
    }
    /**********************************************************************************************/


    function read_form(){



        return $formdata;
    }

    /**************************************************************************************************/
    function setPattern(&$formdata,$Pattern){
        global $db;

        if(is_array($formdata)){


            if(get_magic_quotes_gpc())
                while($i = each($formdata))
                    $formdata[$i[0]] = stripslashes($i[1]);

            if(array_item($formdata, "forum_decision"))
                $formdata['forum_decision']=trim($formdata['forum_decision']);

            if(array_item($formdata, "forum"))
                $formdata['forum']=trim($formdata['forum']);

            $this->datePattern  = (array_item($formdata, 'source_year') && is_numeric($formdata['source_year']) &&  $formdata['source_year']!=='none');
            $this->datePattern1  = (array_item($formdata, 'dest_year') && is_numeric($formdata['dest_year'])  && $formdata['dest_year']!=='none');
            $formdata['forum_decision']=trim($formdata['forum_decision']);
            $this->forumPattern  = array_item($formdata, "forum_decision");
            $this->forumPattern1  = "%" . array_item($formdata, "forum") . "%";


            if(array_item($formdata, "btnTitle")||array_item($formdata, "btnTitleRoot")||array_item($formdata, "btnTitleRootUp")||
                (array_item($formdata,'btnTitleLetter')) ||  (array_item($formdata,'btnTitleLetter1')))  {

                $this->catID= array_item($formdata, "category");
                $this->vote_level= array_item($formdata, "vote_level");
                $this->dec_level= array_item($formdata, "dec_level");
                $this->status= array_item($formdata, "status");


            }


            if($formdata['decision'] /*&&  (array_item($formdata,'btnTitleLetter'))*/){
                $formdata['decision']=trim($formdata['decision']);
                $this->decPattern =  "%"  .array_item($formdata, "decision") . "%";
            }


            if($this->datePattern){
                if(array_item($formdata,'source_year') && is_numeric($formdata['source_year'])  && ! (is_numeric($formdata['dest_year']))){

                    $fields = array( 'source_year' => 'integer', 'source_month' => 'integer','source_day' => 'intger','full_source'=>'string');

                    foreach ($fields as $key => $type) {
                        $date[$key] = $this->safify($formdata[$key], $type);
                    }

                    $date['full_source'] = "$date[source_year]-$date[source_month]-$date[source_day]";
                    $date['full_source'] =$this->safify($date['full_source'] , $type);
                    unset($date['source_year']); unset($date['source_month']);   unset($date['source_day']);
                    $date=$date['full_source'];
                    $this->datePattern=$date;
                    $formdata['source_year']=$this->datePattern;
                }
                else{
                    $fields = array( 'source_year' => 'integer', 'source_month' => 'integer','source_day' => 'intger','full_source'=>'string');
                    foreach ($fields as $key => $type) {
                        $date[$key] = $this->safify($formdata[$key], $type);
                    }

                    $date['full_source'] = "$date[source_year]-$date[source_month]-$date[source_day]";
                    $date['full_source'] =$this->safify($date['full_source'] , $type);
                    unset($date['source_year']); unset($date['source_month']);   unset($date['source_day']);
                    $date=$date['full_source'];
                    $this->datePattern=$date;
                    $formdata['source_year']=$this->datePattern;


//============================================================

                    $fields2 = array( 'dest_year' => 'integer', 'dest_month' => 'integer','dest_day' => 'intger','dest'=>'string');
                    foreach ($fields2 as $key => $type) {
                        $date1[$key] = $this->safify($formdata[$key], $type);
                    }
                    $date1['full_dest'] = "$date1[dest_year]-$date1[dest_month]-$date1[dest_day]";
                    $date1['full_dest'] =$this->safify($date1['full_dest'] , $type);
                    unset($date1['dest_year']); unset($date1['dest_month']);   unset($date1['dest_day']);
                    $date1=$date1['full_dest'];
                    $this->datePattern1=$date1;
                    $formdata['dest_year']=$this->datePattern1;
                }

            }

        }else{
            return $Pattern;
        }


    }
    /********************************************************************************************************/
    function set_category($forums){
        if($forums){
            /*****************************DECISIONS CATEGORY********************************************************/
//$frm_arr_cat_dec=array();
//
//	 foreach ($forums as $frm){
//	 	if($frm->decID){
//
//	 		if(!(in_array( $frm->decID,$frm_arr_cat_dec))){
//				foreach($forums as $cat) {
//					$catNames[$cat->catID] = $cat->catName;
//					$catParents[$cat->catID] = $cat->parentCatID;
//					$catName[$cat->catID][]=array($cat->catName,$cat->catID);
//				}
//
//
//
//
//          	$my_cat=0;
//			echo '<tr>';
//              foreach($catName as $catname ){
//					 if($my_cat==0){
//						 echo '<td><table><tr><td><span class="td5head" > קטגוריה/יות החלטות: </span></td><td>';
//					 }else{
//					echo '<td>';
//					 }
//					$cID=$catname[0][1];
//
//					$this->tdurl($catname [0][0]  , "find3.php?catID=$cID",$cID);
//
//				  $my_cat++;
//
//              }
//
//
//              echo '</tr></table></td></tr>';
//
//
//			$frm_arr_cat_dec[]=$frm->decID;
//
//			echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
//	       }//end if
//	    }
//	 }


            foreach($forums as $cat) {
                if($cat->decID){
                    $catNames[$cat->catID] = $cat->catName;
                    $catParents[$cat->catID] = $cat->parentCatID;
                    $catName[$cat->catID][]=array($cat->catName,$cat->catID);
                }
            }




            $my_cat=0;
            if($catName){
                echo '<tr>';
                foreach($catName as $catname ){
                    if($my_cat==0){
                        echo '<td><table><tr><td><span class="td5head" > קטגוריה/יות החלטות: </span></td><td>';
                    }else
                        echo '<td class="td3head">';
                    $cID=$catname[0][1];

                    $this->tdurl($catname [0][0]  , "find3.php?catID=$cID",$cID);

                    $my_cat++;
                }
                echo '</tr></table></td></tr>';
            }
            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
            // }//end if

            /***********************************FORUM_CATEGORY********************************/

            foreach($forums as $cat) {
                $catNames1[$cat->cat_forumID] = $cat->cat_forumName;
                $catParents1[$cat->cat_forumID] = $cat->parent_Cat_forumID;
                $catName1[$cat->cat_forumID][]=array($cat->cat_forumName,$cat->cat_forumID);
            }

            /**********************************************************************************************************/
            $my_cat_frm=0;
            echo '<tr>';


            foreach($catName1 as $catname1 ){
                if($my_cat_frm==0){
                    echo '<td><table><tr><td><span class="td5head" >  קטגוריה/יות פורומים: </span></td><td>';
                }else{
                    echo '<td>';
                }
                $cID=$catname1[0][1];

                $this->tdurl($catname1 [0][0]  , "find3.php?cat_forumID=$cID",$cID);

                $my_cat_frm++;

            }


            echo '</tr></table></td></tr>';







            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
            /*********************************MANAGER_CATEGORY*************************************************************/

            foreach($forums as $cat) {
                $catNames2[$cat->managerTypeID] = $cat->managerTypeName;
                $catParents2[$cat->managerTypeID] = $cat->parentManagerTypeID;
                $catName2[$cat->managerTypeID][]=array($cat->managerTypeName,$cat->managerTypeID);
            }


            /****************************************MANAGER_CATEGORY******************************************************/
            $my_cat_mgr=0;
            echo '<tr>';
//				foreach($catName2 as $catname2 ){
//					 if($my_cat_mgr==0){
//						 echo '<td class="td5head"> קטגוריה/יות מנהלים: </td>';
//					 }else
//					echo '<td class="td3head">';
//					$cID=$catname2[0][1];
//
//					$this->tdurl($catname2 [0][0]  , "find3.php?managerTypeID=$cID",$cID);
//
//				  $my_cat_mgr++;
//				}
//			echo '</tr>';




            foreach($catName2 as $catname2 ){
                if($my_cat_mgr==0){
                    echo '<td><table><tr><td><span class="td5head" >  קטגוריה/יות מנהלים: </span></td><td>';
                }else{
                    echo '<td>';
                }
                $cID=$catname2[0][1];

                $this->tdurl($catname2 [0][0]  , "find3.php?managerTypeID=$cID",$cID);

                $my_cat_mgr++;

            }


            echo '</tr></table></td></tr>';





            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
            /**********************************************************************************************/

        }//end if

    }//end function
    /**********************************************************************************************/
    function array_item($ar, $key) {

        if(is_array($ar) && array_key_exists($key, $ar))
            return($ar[$key]);
        else
            return FALSE;
    }

    /**********************************************************************************************/
    function setParent($parentcatid) {
        $this->parentcatid = $parentcatid;
    }
    /*****************************************************************************************/
    function getParent() {
        return $this->parentcatid;
    }

    /**********************************************************************************************/
    function link(){
        echo '<p><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</a></p>', "\n";
        echo "<p>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</p>\n";
        $url="../admin/forum_demo12.php";
        $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
        echo "<p>חזרה אל ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . ".</p>\n";
        return true;
    }


    /************************************************************************/
    function link1(){

        echo '<p><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</a></p>', "\n";
        echo "<p>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</p>\n";
        $url="../admin/forum_demo12.php";
        $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
        echo "<p>חזרה אל ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . ".</p>\n";
        return true;
    }


    /************************************************************************/


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
//-------------------------------------------------------------------------------------------------------------------------------------------------

    function build_brand_query($formdata,$pattern,$Pattern1,$brandID ,$page) {
        global $db;

        if(!$pattern)
            $pattern=$Pattern1;
        //$sql = "SELECT decID, decName  FROM decisions";
//        $sql="SELECT b.*,r.pubID,p.pdfID
//                       FROM brands b
//                       LEFT JOIN rel_brand_pub r ON b.brandID=r.brandID
//                       LEFT JOIN pdfs p ON p.brandID=b.brandID ";
        $sql = "SELECT * FROM brands ";

        // we are already done

        if($brandID)

            return $sql . " WHERE b.brandID=$brandID ORDER BY b.brandName";

        // add conditions for category search and pattern search



        if(isset($pubID) && $pubID!="none") {

            $pubsql="select  p.pubID,
             from  rel_brand_pub r,publishers p 
             where p.pubID=r.pubID";
            if($rows = $db->queryObjectArray($catsql)){
                foreach($rows as $row)
                    $subcats[$row->parentCatID][] = $row->catID;
                      $cond1 = "p.pubID IN ($pubID)";
            }//(" . $this->subcategory_list($subcats, $catID) . ") "; }
        }
        else

            $cond1 = "TRUE";


        if($pattern){
            $pattern=trim($pattern);
            $cond2 = "b.brandName LIKE " . $db->sql_string($pattern) . " ";
        }else
            $cond2 = "TRUE";



        if  ($date && !$date1)
            $cond3 = "b.brand_date = " .   $date  . " ";
        else
            $cond3 = "TRUE";


        if($date && $date1)
            $cond4 = "b.brand_date BETWEEN " .   $date  .  " AND " .   $date1  .  " ";
        else
            $cond4 = "TRUE";


        if($status || $this->status)
            $cond5 = "b.status = " . $this->status . " ";
        else
            $cond5 = "TRUE";


        if($brandID && $brandID!="none") {


            $forumsql="select  p.pdfID
	                    from  pdfs p,brands b
                        where p.brandID = b.brandID";
                        $rows = $db->queryObjectArray($forumsql);
            $cond6 = "p.brandID in($brandID)";
        }
        else

            $cond6  = "TRUE";

        $sql .= " WHERE " . $cond1 . " AND " . $cond2 ." AND " . $cond3 . " AND " . $cond4 . " AND " . $cond5 . " AND " . $cond6 . " AND " .  " ORDER BY   d.decName ";
        return $sql;
    }


//-----------------------------------------------------------------------------------------------------------------------------------------------





    function build_decision_query($formdata,$pattern,$Pattern1, $decID, $catID, $page,$size,$date,$date1,
                                  $forum_decID,$vote_level,$dec_level,$status) {
        global $db;

        if(!$pattern)
            $pattern=$Pattern1;
        //$sql = "SELECT decID, decName  FROM decisions";
        $sql="SELECT d.*,v.grade_level,
	       r.catID,c.catName,rf.forum_decID,rf.note,rf.dec_managerID,f.forum_decName,m.managerID,m.managerName
	       FROM decisions d 
	       LEFT JOIN  vote_grade v ON  d.vote_level BETWEEN v.low_vote AND v.high_vote 
	       LEFT JOIN rel_cat_dec r ON d.decID=r.decID
	       LEFT JOIN categories c ON c.catID=r.catID
	       LEFT JOIN rel_forum_dec rf ON d.decID=rf.decID
	       LEFT JOIN forum_dec f ON f.forum_decID=rf.forum_decID
	       LEFT JOIN managers m ON m.managerID=f.managerID ";

        // we are already done
//========================================================
        if($decID)

            return $sql . " WHERE d.decID=$decID ORDER BY d.decName";

        // add conditions for category search and pattern search
//===========================================================


        if($catID && $catID!="none") {

            $catsql="select  c.catID,c.parentCatID
             from  rel_cat_dec r,categories c
             where c.catID=r.catID";
            if($rows = $db->queryObjectArray($catsql)){
                foreach($rows as $row)
                    $subcats[$row->parentCatID][] = $row->catID;
                $cond1 = "c.catID IN ($catID)";
            }//(" . $this->subcategory_list($subcats, $catID) . ") "; }
        }
        else

            $cond1 = "TRUE";
        /*********************************************************/

        if($pattern){
            $pattern=trim($pattern);
            $cond2 = "d.decName LIKE " . $db->sql_string($pattern) . " ";
        }else
            $cond2 = "TRUE";

        /*********************************************************/

        if($date && !$date1)
            $cond3 = "d.dec_date = " .   $date  . " ";
        else
            $cond3 = "TRUE";

        /*********************************************************/
        if($date && $date1)
            $cond4 = "d.dec_date BETWEEN " .   $date  .  " AND " .   $date1  .  " ";
        else
            $cond4 = "TRUE";

        /*****************************************************************************************/
        if($dec_level || $this->dec_level)
            $cond5 = "d.dec_level = " .   $this->dec_level  . " ";
        else
            $cond5 = "TRUE";
        /*********************************************************/
        if($status || $this->status)
            $cond6 = "d.status = " . $this->status . " ";
        else
            $cond6 = "TRUE";
        /*********************************************************/
        if($forum_decID && $forum_decID!="none") {


            $forumsql="select  f.forum_decID
	             from  forum_dec f,rel_forum_dec rf
             where f.forum_decID=rf.forum_decID";
            $rows = $db->queryObjectArray($forumsql);
            $cond7 = "f.forum_decID in($forum_decID)";
        }
        else

            $cond7  = "TRUE";
        /*********************************************************/
        if(($vote_level && $vote_level="none") || $this->vote_level) {




            $cond8 = "v.grade_level=$this->vote_level";
        }
        else

            $cond8  = "TRUE";
        /*********************************************************/
        $sql .= " WHERE " . $cond1 . " AND " . $cond2 ." AND " . $cond3 . " AND " . $cond4 . " AND " . $cond5 . " AND " . $cond6 . " AND " . $cond7 . " AND " . $cond8 .

            " ORDER BY   d.decName ";
        //if(rows[full])
        // add limit clause
//		 if($formdata['btnTitleRoot']||$formdata['btnTitleRootUp']){
//		 	return $sql;
//		 }
//		 else
//		 $sql .= "LIMIT " . (($page-1) * $size) . "," . ($size + 1);

        return $sql;
    }

    /****************************************************************************************/

    function build_forum_query($formdata,$pattern,$forum_decID, $page, $size,$cat_forumID="",$managerID="",$managerTypeID="",$appointID="") {

        global $db;

//$sql = "SELECT forum_decID, forum_decName FROM forum_dec";




        $sql = "select f.*, 
	     c.catID as 'cat_forumID',c.catName as 'cat_forumName',c.parentCatID as 'parent_Cat_forumID',
	     c1.catID,c1.catName,c1.parentCatID,
         m.managerID,m.managerName,
         a.appointID,a.appointName,
         mt.managerTypeName,mt.managerTypeID,
         d.decID,d.decName FROM forum_dec f
           
           LEFT JOIN rel_cat_forum rc ON f.forum_decID=rc.forum_decID
           LEFT JOIN rel_managerType_forum rm ON f.forum_decID=rm.forum_decID
           
           LEFT JOIN categories1 c ON c.catID = rc.catID
           
           LEFT JOIN managers m ON m.managerID=f.managerID
           
           LEFT JOIN manager_type mt ON mt.managerTypeID=rm.managerTypeID
           
           
           LEFT JOIN appoint_forum a ON a.appointID=f.appointID
           
           LEFT JOIN rel_forum_dec rf ON f.forum_decID=rf.forum_decID
           LEFT JOIN decisions d ON d.decID=rf.decID
           
           LEFT JOIN rel_cat_dec r ON d.decID=r.decID
           LEFT JOIN categories  c1 ON c1.catID=r.catID";

        /****************************************************************************************/
        if($cat_forumID && $cat_forumID!="none") {

            $catsql="select  c.catID,c.parentCatID
             from  rel_cat_forum r,categories1 c
             where c.catID=r.catID";
            if($rows = $db->queryObjectArray($catsql)){
                foreach($rows as $row)
                    $subcats[$row->parentCatID][] = $row->catID;
                $cond1 = " c.catID IN ($cat_forumID)";
            }//(" . $this->subcategory_list($subcats, $catID) . ") "; }
        }
        else

            $cond1 = "TRUE";


        /******************************************************************************************/
        if($managerID &&  $managerID!='none') {


            $cond2 = "f.managerID in($managerID)";
        }else
            $cond2  = "TRUE";


        /******************************************************************************************/
        if($managerTypeID &&  $managerTypeID!='none') {


            $cond3 = "mt.managerTypeID in($managerTypeID)";
        }else
            $cond3  = "TRUE";


        /******************************************************************************************/

        if($appointID &&  $appointID!='none') {


            $cond4 = "f.appointID in($appointID)";
        }else
            $cond4  = "TRUE";

        /********************************************************************************************/
        if($forum_decID   &&  $forum_decID!='none' ){
            // we are done
            $sql .= " WHERE f.forum_decID = $forum_decID ORDER BY f.forum_decNAME " ;
        }elseif($pattern && $pattern !='none'){
            $sql .=" WHERE f.forum_decName LIKE " . $db->sql_string($pattern) .  " AND " . $cond1 .  " AND " . $cond2 .  " AND " . $cond3 .  " AND " . $cond4 .
                " ORDER BY f.forum_decNAME " ;
        }elseif($formdata['btnTitleRoot']||$formdata['btnTitleRootUp']){
            return $sql;
        }else{
            $sql .= " WHERE " . $cond1 . " AND " . $cond2 . " AND " . $cond3 .  " AND " . $cond4 ;//" LIMIT " . (($page-1) * $size) . "," . ($size + 1);
            $sql .=   "  ORDER BY f.forum_decNAME desc ";
        }


        return $sql;


    }

    /****************************************************************************************/
    function build_forum_query1($formdata,$pattern,$forum_decID, $page, $size,$cat_forumID="",$managerID="",$managerTypeID="",$userID="",$appointID="") {

        global $db;






        $sql = "select distinct(f.forum_decID),f.forum_decName ,u.full_name,u.userID,
c.catID as 'cat_forumID',c.catName as 'cat_forumName',c.parentCatID as 'parent_Cat_forumID',
m.managerName,m.managerID,a.appointName,a.appointID,mt.managerTypeName,mt.managerTypeID 
            
           from  forum_dec f
           
           LEFT JOIN rel_user_forum ruf ON f.forum_decID=ruf.forum_decID
           LEFT JOIN users u ON u.userID=ruf.userID
           
           LEFT JOIN rel_cat_forum rc ON f.forum_decID=rc.forum_decID
           LEFT JOIN rel_managerType_forum rm ON f.forum_decID=rm.forum_decID
           
           LEFT JOIN categories1 c ON c.catID = rc.catID
           
           LEFT JOIN managers m ON m.managerID=f.managerID
           
           LEFT JOIN manager_type mt ON mt.managerTypeID=rm.managerTypeID
           
           
           LEFT JOIN appoint_forum a ON a.appointID=f.appointID
           
           LEFT JOIN rel_forum_dec rf ON f.forum_decID=rf.forum_decID
           LEFT JOIN decisions d ON d.decID=rf.decID
           
           LEFT JOIN rel_cat_dec r ON d.decID=r.decID
           LEFT JOIN categories  c1 ON c1.catID=r.catID";






        /****************************************************************************************/
        if($cat_forumID && $cat_forumID!="none") {

            $catsql="select  c.catID,c.parentCatID
             from  rel_cat_dec r,categories1 c
             where c.catID=r.catID";
            if($rows = $db->queryObjectArray($catsql)){
                foreach($rows as $row)
                    $subcats[$row->parentCatID][] = $row->catID;
                $cond1 = " c.catID IN ($cat_forumID)";
            }//(" . $this->subcategory_list($subcats, $catID) . ") "; }
        }
        else

            $cond1 = "TRUE";


        /******************************************************************************************/
        if($managerID &&  $managerID!='none') {


            $cond2 = "f.managerID in($managerID)";
        }else
            $cond2  = "TRUE";


        /******************************************************************************************/
        if($managerTypeID &&  $managerTypeID!='none') {


            $cond3 = "mt.managerTypeID in($managerTypeID)";
        }else
            $cond3  = "TRUE";


        /******************************************************************************************/
        if($userID &&  $userID!='none' && array_item($formdata,'managerID') && array_item($formdata,'managerID')!='none'  ) {
            $mgr_sql="SELECT forum_decID FROM forum_dec f WHERE f.managerID =(SELECT managerID FROM managers WHERE userID=$userID)";
            if($rows = $db->queryObjectArray($mgr_sql)){

                $cond3 = "u.userID in($userID) || f.managerID =(SELECT managerID FROM managers WHERE userID=$userID)";
            }else{
                $cond3  = "TRUE";
            }

        }

//-------------------------------------------------------------------------------------------------
        elseif($userID &&  $userID!='none' && array_item($formdata,'appointID') && array_item($formdata,'appointID')!='none'  ) {
            $app_sql="SELECT forum_decID FROM forum_dec f WHERE f.appointID =(SELECT appontID FROM appoint_forum WHERE userID=$userID)";
            if($rows = $db->queryObjectArray($app_sql)){

                $cond3 = "u.userID in($userID) || f.appointID =(SELECT appointID FROM appoint_forum WHERE userID=$userID)";


            }else{
                $cond3  = "TRUE";
            }
//-------------------------------------------------------------------------------------------------
        }elseif($userID &&  $userID!='none') {


            $cond3 = "u.userID in($userID)";

        }else
            $cond3  = "TRUE";


        /******************************************************************************************/
        if($appointID &&  $appointID!='none') {


            $cond4 = "a.appointID in($appointID)";
        }else
            $cond4  = "TRUE";


        /******************************************************************************************/


        if($forum_decID   &&  $forum_decID!='none' ){
            // we are done
            $sql .= " WHERE f.forum_decID = $forum_decID ORDER BY f.forum_decNAME " ;
        }elseif($pattern && $pattern !='none'){
            $sql .=" WHERE f.forum_decName LIKE " . $db->sql_string($pattern) .  " AND " . $cond1 .  " AND " . $cond2 .  " AND " . $cond3 .  " AND " . $cond4 .
                " ORDER BY f.forum_decNAME " ;
        }elseif($formdata['btnTitleRoot']||$formdata['btnTitleRootUp']){
            return $sql;
        }else{
            $sql .= " WHERE " . $cond1 . " AND " . $cond2 . " AND " . $cond3 .  " AND " .  $cond4  . " LIMIT " . (($page-1) * $size) . "," . ($size + 1);
        }

        return $sql;


    }

    /****************************************************************************************/
    function checkDec_Pattern1($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status){
        global $db;

        if($this->decPattern ||$decID || ($this->catID) || $this->datePattern  || $this->datePattern1)

            if(!$this->decID)
                $this->decID=$decID;
        if(!$this->catID)
            $this->catID=$catID;
        if(!$this->vote_level)
            $this->vote_level=$vote_level;
        if(!$this->dec_level)
            $this->dec_level=$dec_level;
        if(!$this->status)
            $this->status=$status;



        if($formdata)
            $this->forum_decID=$formdata['forum_decision'];

        $sql = $this->build_decision_query($formdata,$this->decPattern,$Pattern, $this->decID, $this->catID,  $page, $this->pagesize,$this->datePattern,$this->datePattern1,$this->forum_decID,$vote_level,$dec_level,$status);
        // echo $sql ."<br/>";
        $rows = $db->queryObjectArray($sql);
        if(!$rows){
            echo "<h1>תוצאות החיפוש</h1>\n";
            echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

            echo '<div>';
            echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
            echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
            $url="../admin/forum_demo12_2.php";
            $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
            echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";
            echo '</div>';

            return;
        }

        foreach ($rows as $row){
            if (!get_magic_quotes_gpc()){
                $foundarr[] = stripslashes ($row-> decName  );
            } else {
                $foundarr[] = $row->decName;
            }
        }


        //If we have any matches, then we can go through and display them.

        ?>
        <div
                style="background: #CCCCCC; border-style: solid; border-width: 1px; border-color: #000000;">
            <?php
            for ($i = 0; $i < count ($foundarr); $i++){
                ?>
                <div style="padding: 4px; height: 14px;"
                     onmouseover="this.style.background = '#EEEEEE'"
                     onmouseout="this.style.background = '#CCCCCC'"
                     onclick="setvalue ('<?php echo $foundarr[$i]; ?>')"><?php echo $foundarr[$i]; ?></div>
                <?php
            }
            ?>
        </div>
        <?php


    }
    /****************************************************************************************/


    function checkDec_Pattern($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status){
        global $db;

        if($this->decPattern ||$decID || ($this->catID) || $this->datePattern  || $this->datePattern1)
            if(!$this->decID)
                $this->decID=$decID;
        if(!$this->catID)
            $this->catID=$catID;
        if(!$this->vote_level)
            $this->vote_level=$vote_level;
        if(!$this->dec_level)
            $this->dec_level=$dec_level;
        if(!$this->status)
            $this->status=$status;


        if($formdata){
            $this->forum_decID=$formdata['forum_decision'];
        }
        $sql = $this->build_decision_query($formdata,$this->decPattern,$Pattern, $this->decID, $this->catID,
            $page, $this->pagesize,$this->datePattern,$this->datePattern1,
            $this->forum_decID,$this->vote_level,$this->dec_level,$this->status);
        // echo $sql ."<br/>";
        $rows = $db->queryObjectArray($sql);

        if(!$rows){
            //echo "<h1>תוצאות החיפוש</h1>\n";
            echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";
            echo '<div id="my_link_message">';
            echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
            echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
            $url="../admin/forum_demo12_2.php";
            $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
            echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";
            echo '</div>';
            return;
        }


        /****************************************************************************************/
//	echo '<fieldset  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px; margin-bottom:50px;margin-right:-35px;overflow:hidden; background: #94C5EB url('.ROOT_WWW.'/images/background-grad.png) repeat-x;width:95%; ">';
        $this->show_decisions($rows,$this->pagesize, $this->catID,$this->forum_decID,$flag,$formdata);
//    echo '</fieldset>';




// 	 	 echo '<table dir="rtl" ><tr><td style="height:25px;" dir="rtl">';
//
//	 	 echo "<p style='color:red;' align='right'>חזרה אל ",build_href2("find3.php", "","", "טופס החיפוש","class=href_modal1") . "</p>\n";
//
//		  echo "<p style='color:red;' align='right'>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . "</p>\n";
//			$url="../admin/forum_demo12_2.php";
//	        $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 id=popup_frm ';
//	        echo "<p style='color:red;' align='right'>חזרה אל ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . "</p></td></tr></table>\n";




//echo '<p><b><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</b></a></p>', "\n";
//		    echo "<p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</b></p>\n";
//			$url="../admin/forum_demo12_2.php";
//	        $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 id=popup_frm ';
//	        echo "<p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . ".</b></p>\n";



    }

    function checkReguser($userID){
        global $db;
        $sql = "SELECT * FROM users WHERE userID=$userID";
        if($rows=$db->queryObjectArray($sql)){
            $this->show_Reguser($rows,$userID);
        }
    }


    function checkForum_Pattern($formdata="",$page="",$forum_decID="",$cat_forumID="",$managerID="",$managerTypeID="",$userID="",$appointID="",$brandID="")
    {

        global $db;

        if (array_item($_REQUEST, 'brandID')) {
            $brandID = array_item($_REQUEST, 'brandID');
            if (!empty($brandID) && is_numeric($brandID) ) {
//-----------------------------------------------------------------------
     $sql = $this->build_brand_query($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->userID, $this->appointID);
                if ($sql) {

                    if (!$rows = $db->queryObjectArray($sql)) {

                        echo "<h1>תוצאות החיפוש</h1>\n";
                        echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

                        echo '<div>';
                        echo "<table><tr class='menu4'><td><p><b> ", build_href2("find3.php", "", "", "חזרה לטופס החיפוש", "class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
                        echo "<td><p><b> ", build_href2("forum_demo12.php", "", "", "חיפוש קטגוריות בדף", "class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
                        $url = "../admin/forum_demo12_2.php";
                        $str = 'onclick=\'openmypage2("' . $url . '"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
                        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . " </b></p></td></tr></table>\n";
                        echo '</div>';


                        if (array_item($formdata, 'user_forum') && !(array_item($formdata, 'user_forum') == 'none') || ($this->userID && !($this->userID == 'none'))) {
                            echo '<fieldset id="my_history_fieldset_usr"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
                            $this->user_history();
                            echo '</fieldset>';


                        } elseif (array_item($formdata, 'manager_forum') && !(array_item($formdata, 'manager_forum') == 'none') || ($this->managerID && !($this->managerID == 'none'))) {

                            echo '<fieldset id="my_history_fieldset_mgr"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
                            $this->manager_history();
                            echo '</fieldset>';


                        } elseif (array_item($formdata, 'appoint_forum') && !(array_item($formdata, 'appoint_forum') == 'none') || ($this->appointID && !($this->appointID == 'none'))) {

                            echo '<fieldset id="my_history_fieldset_app"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
                            $this->appoint_history();
                            echo '</fieldset>';


                        } else {
                            echo "<h1>תוצאות החיפוש</h1>\n";
                            echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

                            echo '<div>';
                            echo "<table><tr class='menu4'><td><p><b> ", build_href2("find3.php", "", "", "חזרה לטופס החיפוש", "class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
                            echo "<td><p><b> ", build_href2("forum_demo12.php", "", "", "חיפוש קטגוריות בדף", "class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
                            $url = "../admin/forum_demo12_2.php";
                            $str = 'onclick=\'openmypage2("' . $url . '"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
                            echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . " </b></p></td></tr></table>\n";
                            echo '</div>';

                        }
                        return;
                    }
                }
                /****************************************************************************************/

                $this->show_forums($rows, $this->pagesize, $formdata, $this->forum_decID, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->userID, $this->appointID);

                if ($formdata['forum_decision'] && $formdata['forum_decision'] != 'none') {
                    $sql1 = "select forum_decName from forum_dec where forum_decID=$this->forum_decID";
                    $row = $db->querySingleItem($sql1);
                    $row = is_null($row) ? 'NULL' : "'$row'";
                    $this->forumPattern = $row;
                    $query = "forum_decID=$this->forum_decID&catID=$this->catID&decID=$this->decID&forumPattern=" . urlencode($this->forumPattern);

                } elseif ($this->forumPattern)
                    $query = "forum_decID=$this->forum_decID&catID=$this->catID&cat_forumID=$this->cat_forumID&managerTypeID=$this->managerTypeID&managerID=$this->managerID&appointID=$this->appointID&userID=$this->userID&decID=$this->decID&forumPattern=" . urlencode($this->forumPattern);

                else
                    $query = "forum_decID=$this->forum_decID&catID=$this->catID&cat_forumID=$this->cat_forumID&managerTypeID=$this->managerTypeID&managerID=$this->managerID&appointID=$this->appointID&userID=$this->userID&decID=$this->decID&forumPattern=" . urlencode($this->forumPattern1);







//-----------------------------------------------------------------------
            }
        }else {
        if ($forum_decID)
            $this->forum_decID = $forum_decID;
            if ($brandID)
                $this->brandID = $forum_decID;
        if ($formdata['forum_decision'])
            $this->forum_decID = $formdata['$brandID'];

        if ($cat_forumID)
            $this->cat_forumID = $cat_forumID;
        if ($formdata['category1'])
            $this->cat_forumID = $formdata['category1'];

        if ($appointID)
            $this->appointID = $appointID;
        if ($formdata['appoint_forum'])
            $this->appointID = $formdata['appoint_forum'];

        if ($managerID)
            $this->managerID = $managerID;
        if ($formdata['manager_forum'])
            $this->managerID = $formdata['manager_forum'];

        if ($userID)
            $this->userID = $userID;
        if ($formdata['user_forum'])
            $this->userID = $formdata['user_forum'];

        if ($managerTypeID)
            $this->managerTypeID = $managerTypeID;
        if ($formdata['managerType'])
            $this->managerTypeID = $formdata['managerType'];


//		if($_GET['managerID'])
//		$this->managerID=$_GET['managerID'];
//---------------------------------------------------------------------------------------------------------------------------
        if (($this->forumPattern && $this->forumPattern != 'none') || $this->forum_decID || $this->cat_forumID || $this->managerID || $this->managerTypeID || $this->userID || $this->appointID) {

            if ($formdata['forum_decision'] && $formdata['forum_decision'] != 'none') {
                $this->forum_decID = $formdata['forum_decision'];
                $sql = $this->build_forum_query($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->appointID);
//---------------------------------------------------------------------------------------------------------------------------
            } elseif ($this->forumPattern && $this->forumPattern != 'none') {
                $sql = "select forum_decID from forum_dec where forum_decName=$this->forumPattern ";
                $rows = $db->queryObjectArray($sql);
                $this->forum_decID = $rows[0]->forum_decID;
                $sql = $this->build_forum_query($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->appointID);
//---------------------------------------------------------------------------------------------------------------------------
            } elseif ($this->forum_decID && $this->forum_decID != 'none') {
                $sql = $this->build_forum_query($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->appointID);
//---------------------------------------------------------------------------------------------------------------------------
            } elseif ($this->cat_forumID && $this->cat_forumID != 'none') {
                $sql = $this->build_forum_query($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->appointID);
//---------------------------------------------------------------------------------------------------------------------------
            } elseif ($this->managerID && $this->managerID != 'none' || ($this->managerTypeID && $this->managerTypeID != 'none')) {
                $sql = $this->build_forum_query($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->appointID);
//---------------------------------------------------------------------------------------------------------------------------
            } elseif ($this->appointID && $this->appointID != 'none') {
                $sql = $this->build_forum_query($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->appointID);
            } //---------------------------------------------------------------------------------------------------------------------------
            elseif (($this->userID && $this->userID != 'none')) {
                $sql = $this->build_forum_query1($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->userID, $this->appointID);

                if (!$rows = $db->queryObjectArray($sql)) {
                    $mgr_sql = "SELECT  managerID FROM managers WHERE userID=$this->userID  ";

                    if ($rows = $db->queryObjectArray($mgr_sql)) {
                        $mgrID = $rows[0]->managerID;
                        $formdata['managerID'] = $mgrID;
                        $sql = $this->build_forum_query1($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->userID, $this->appointID);
                    } else {
                        $app_sql = "SELECT  appointID FROM appoint_forum WHERE appointID=$this->userID  ";
                        if ($rows = $db->queryObjectArray($mgr_sql)) {
                            $appID = $rows[0]->managerID;
                            $formdata['appointID'] = $appID;
                            $sql = $this->build_forum_query1($formdata, $this->forumPattern, $this->forum_decID, $page, $this->pagesize, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->userID, $this->appointID);
                        }
                    }

                }

            }//end elseif
//---------------------------------------------------------------------------------------------------------------------------
            if ($sql) {

                if (!$rows = $db->queryObjectArray($sql)) {

                    echo "<h1>תוצאות החיפוש</h1>\n";
                    echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

                    echo '<div>';
                    echo "<table><tr class='menu4'><td><p><b> ", build_href2("find3.php", "", "", "חזרה לטופס החיפוש", "class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
                    echo "<td><p><b> ", build_href2("forum_demo12.php", "", "", "חיפוש קטגוריות בדף", "class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
                    $url = "../admin/forum_demo12_2.php";
                    $str = 'onclick=\'openmypage2("' . $url . '"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
                    echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . " </b></p></td></tr></table>\n";
                    echo '</div>';


                    if (array_item($formdata, 'user_forum') && !(array_item($formdata, 'user_forum') == 'none') || ($this->userID && !($this->userID == 'none'))) {
                        echo '<fieldset id="my_history_fieldset_usr"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
                        $this->user_history();
                        echo '</fieldset>';


                    } elseif (array_item($formdata, 'manager_forum') && !(array_item($formdata, 'manager_forum') == 'none') || ($this->managerID && !($this->managerID == 'none'))) {

                        echo '<fieldset id="my_history_fieldset_mgr"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
                        $this->manager_history();
                        echo '</fieldset>';


                    } elseif (array_item($formdata, 'appoint_forum') && !(array_item($formdata, 'appoint_forum') == 'none') || ($this->appointID && !($this->appointID == 'none'))) {

                        echo '<fieldset id="my_history_fieldset_app"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
                        $this->appoint_history();
                        echo '</fieldset>';


                    } else {
                        echo "<h1>תוצאות החיפוש</h1>\n";
                        echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

                        echo '<div>';
                        echo "<table><tr class='menu4'><td><p><b> ", build_href2("find3.php", "", "", "חזרה לטופס החיפוש", "class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
                        echo "<td><p><b> ", build_href2("forum_demo12.php", "", "", "חיפוש קטגוריות בדף", "class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
                        $url = "../admin/forum_demo12_2.php";
                        $str = 'onclick=\'openmypage2("' . $url . '"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
                        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . " </b></p></td></tr></table>\n";
                        echo '</div>';
                    }
                    return;
                }
            }
            /****************************************************************************************/

            $this->show_forums($rows, $this->pagesize, $formdata, $this->forum_decID, $this->cat_forumID, $this->managerID, $this->managerTypeID, $this->userID, $this->appointID);

            if ($formdata['forum_decision'] && $formdata['forum_decision'] != 'none') {
                $sql1 = "select forum_decName from forum_dec where forum_decID=$this->forum_decID";
                $row = $db->querySingleItem($sql1);
                $row = is_null($row) ? 'NULL' : "'$row'";
                $this->forumPattern = $row;
                $query = "forum_decID=$this->forum_decID&catID=$this->catID&decID=$this->decID&forumPattern=" . urlencode($this->forumPattern);

            } elseif ($this->forumPattern)
                $query = "forum_decID=$this->forum_decID&catID=$this->catID&cat_forumID=$this->cat_forumID&managerTypeID=$this->managerTypeID&managerID=$this->managerID&appointID=$this->appointID&userID=$this->userID&decID=$this->decID&forumPattern=" . urlencode($this->forumPattern);
            else
                $query = "forum_decID=$this->forum_decID&catID=$this->catID&cat_forumID=$this->cat_forumID&managerTypeID=$this->managerTypeID&managerID=$this->managerID&appointID=$this->appointID&userID=$this->userID&decID=$this->decID&forumPattern=" . urlencode($this->forumPattern1);
//			echo '<p><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</a></p>', "\n";
//		    echo "<p>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</p>\n";
//			$url="../admin/forum_demo12.php";
//	        $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
//	        echo "<p>חזרה אל ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . ".</p>\n";

        }
    }
///////////////////////
        }//end function  //
//////////////////////



    function checkForum_Pattern1($formdata,$page,$forum_decID){
        global $db;
        $this->forum_decID=$forum_decID;
        if(($this->forumPattern1 && $this->forumPattern1!='none') || $this->forum_decID) {

            if($formdata['forum']&& $formdata['forum']!='none' ){
                // $forum_decID=$formdata['forum'];
                $sql =$this-> build_forum_query($formdata,$this->forumPattern1, $this->forum_decID, $page, $this->pagesize);    }

            elseif($this->forumPattern1)
                $sql =$this->build_forum_query($formdata,$this->forumPattern1, $this->forum_decID, $page, $this->pagesize);
            if(!$rows = $db->queryObjectArray($sql) ){

                echo "<h1>תוצאות החיפוש</h1>\n";
                echo "<h1>תוצאות החיפוש</h1>\n";
                echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

                echo '<div>';
                echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
                echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
                $url="../admin/forum_demo12_2.php";
                $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
                echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";
                echo '</div>';

                return ;

                return;
            }

            //($forums, $pagesize ,$formdata,$forum_decID,$cat_forumID,$managerID,$managerTypeID,$userID,$appointID) {

            $this->show_forums($rows, $this->pagesize,$formdata,$forum_decID);

            if($this->forumPattern1)
                $query = "forum_decID=$forum_decID&forumPattern1=" . urlencode($this->forumPattern1);
            // $this->show_page_links($page, $pagesize, sizeof($rows), $query);
            echo '<p><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</a></p>', "\n";
            echo "<p>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</p>\n";
            $url="../admin/forum_demo12.php";
            $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
            echo "<p>חזרה אל ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . ".</p>\n";
        }else {
// nothing to do, show query forums
//====================================================
            echo '<p><a href="find3.php" class="href_modal1">חזרה לטופס החיפוש</a></p>', "\n";
            echo "<p>חזרה אל ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=href_modal1") . ".</p>\n";
            $url="../admin/forum_demo12.php";
            $str='onclick=\'openmypage2("'.$url.'"); return false;\'   class=href_modal1 ';
            echo "<p>חזרה אל ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . ".</p>\n";
        }
    }
    /************************************************************************************************/

    function checktreedec_Down($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status){
        global $db;

        if($this->decPattern ||$decID || ($catID && $catID!='none')||$this->datePattern  || $this->datePattern1)

            if(!$this->decID)
                $this->decID=$decID;
        if(!$this->catID)
            $this->catID=$catID;
        if(!$this->vote_level)
            $this->vote_level=$vote_level;
        if(!$this->dec_level)
            $this->dec_level=$dec_level;
        if(!$this->status)
            $this->status=$status;

        if($formdata)
            $this->forum_decID=$formdata['forum_decision'];
        $sql = $this->build_decision_query($formdata,$this->decPattern,$Pattern, $this->decID, $this->catID,  $page, $this->pagesize,$this->datePattern,$this->datePattern1,$this->forum_decID,$vote_level,$this->dec_level,$status);
        // echo $sql ."<br/>";
        $rows = $db->queryObjectArray($sql);
        if($rows  && $rows==false){
            echo "<h1>תוצאות החיפוש</h1>\n";
            echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

            echo '<div>';
            echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
            echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
            $url="../admin/forum_demo12_2.php";
            $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
            echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";
            echo '</div>';

            return ;

            //$this->treedisplayDown($rows);
            return;
        }else{
            $this->treedisplayDown($rows,$formdata);
        }
    }
//==================================================================================================
    function checktreedec_Up($formdata,$page,$decID,$catID,$vote_level,$dec_level,$status){
        global $db;

        if($this->decPattern ||$decID || ($catID && $catID!='none')||$this->datePattern  || $this->datePattern1)

            if(!$this->decID)
                $this->decID=$decID;
        if(!$this->catID)
            $this->catID=$catID;
        if(!$this->vote_level)
            $this->vote_level=$vote_level;
        if(!$this->dec_level)
            $this->dec_level=$dec_level;
        if(!$this->status)
            $this->status=$status;


        if($formdata)
            $this->forum_decID=$formdata['forum_decision'];

        $sql = $this->build_decision_query($formdata,$this->decPattern,$Pattern, $this->decID, $this->catID,  $page, $this->pagesize,$this->datePattern,$this->datePattern1,$this->forum_decID,$vote_level,$dec_level,$status);
        // echo $sql ."<br/>";
        $rows = $db->queryObjectArray($sql);
        if(!$rows){
            echo "<h1>תוצאות החיפוש</h1>\n";
            echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

            echo '<div>';
            echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
            echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
            $url="../admin/forum_demo12_2.php";
            $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
            echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";
            echo '</div>';

            return ;
        }
        $this->treedisplayUp($rows,$formdata);
    }
//==================================================================================================
    function checktreeforum_Down($formdata,$page,$forum_decID){
        $this->forum_decID=$forum_decID;
        global $db;
        if(($this->forumPattern && $this->forumPattern!='none') ||$this->forum_decID) {

            if($formdata['forum_decision']&& $formdata['forum_decision']!='none' ){
                $this->forum_decID=$formdata['forum_decision'];
                $sql =$this-> build_forum_query($formdata,$this->forumPattern, $this->forum_decID, $page, $this->pagesize);

            }elseif($this->forumPattern){
                $sql="select forum_decID from forum_dec where forum_decName=$this->forumPattern " ;
                $rows=$db->queryObjectArray($sql);
                $this->forum_decID=$rows[0]->forum_decID;
                $sql =$this-> build_forum_query($formdata,$this->forumPattern,$this->forum_decID, $page, $this->pagesize);

            }elseif($this->forum_decID){
                $sql =$this-> build_forum_query($formdata,$this->forumPattern, $this->forum_decID, $page, $this->pagesize);
            }

            $rows = $db->queryObjectArray($sql);

            if(!$rows){
                echo "<h1>תוצאות החיפוש</h1>\n";
                echo "<p class='my_task' style='font-weight:bold;color:black;'>מצטערים לא נמצא מידע   .</p>\n";

                echo '<div>';
                echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";
                echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";
                $url="../admin/forum_demo12_2.php";
                $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
                echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";
                echo '</div>';
                return;
            }

        }
        $this->treedisplayDown($rows,$formdata);
    }



    function treedisplayUp($rows,$formdata){
        global $db;
        if(($formdata['btnTitleRootUp'])&& array_item($formdata,'btnTitleRootUp')){
            $mysqli=$db->getMysqli();
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit ();
            } else {
                printf("Connect succeeded\n");
            }
            /********************************************************/
            $sql="set @@max_sp_recursion_depth=55";
            $result = $mysqli->query($sql);
            if ($mysqli->errno) {
                die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
            }

            /********************************************************/
            $sql="truncate table tmp_dec";
            $result = $mysqli->query($sql);
            if ($mysqli->errno) {
                die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
            }
            /*************************************************************************************/
            for($i=0;$i<=count($rows);$i++){
                $decid=$rows[$i]->decID;

                $query = $mysqli->multi_query("CALL get_parent_dec($decid)"); // automatically buffers resultsets and assigns true or false on fail to $query
                // OR $mysqli->real_query() - remember the main point of this is NOT to execute multple queries, but to acquire buffered results.

                //check if the query was successful
                if ($query) {

                    //asign the first result set for use
                    $result = $mysqli->use_result();

                    //use the data in the resultset
                    $data = $result->fetch_array(MYSQLI_ASSOC) ;//fetch_assoc();

                    //free the resultset
                    $result->free();

                    //clear the other result(s) from buffer
                    //loop through each result using the next_result() method
                    while ($mysqli->next_result()) {
                        //free each result.
                        $result = $mysqli->use_result();
                        if ($result instanceof mysqli_result) {
                            $result->free();
                        }
                    }
                }
                $sql5="select * from __parent_decs";
                $result5=$mysqli->query($sql5);
                if ($mysqli->errno) {
                    die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
                }
                $sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName)(select * from __parent_decs)"; //" .
                $result3=$mysqli->query($sql3);
                if ($mysqli->errno) {
                    die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
                }

            }

            ?>
            <meta
                    HTTP-EQUIV="REFRESH" content="0; url=treefind_desc.php">
            <?php
            die;
        }
    }


    function show_decisions($decisions, $pagesize,$catID,$forum_decID,$flag="",$formdata="") {
        /**********************************************************************************************************/
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



// echo ' <ol class="menu2" id="my_find_ol"  >';
        if(!(ae_detect_ie()) ){
            echo '<fieldset  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px; margin-bottom:50px;margin-right:-10px;overflow:hidden; background: #94C5EB url('.ROOT_WWW.'/images/background-grad.png) repeat-x;width:100%; ">';
        }else{
            echo '<fieldset  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px; margin-bottom:50px;margin-right:25px;overflow:hidden; background: #94C5EB url('.ROOT_WWW.'/images/background-grad.png) repeat-x;width:100%; ">';
        }
        echo '<div id="content_page" class="menu2" >';
        echo ' <ol class="paginated" id="my_find_ol" >';
        ?>
        <div id="loading">
            <img src="loading4.gif" border="0" />
        </div>
        <?php

        if(!$decisions) {
            echo "<p class='my_task' style='font-weight:bold;color:black;'> מצטערים,לא נימצאו החלטות </p>\n";
            return;
        }
        elseif(($decisions[0]->decID)=='11' && (count($decisions)==1)){
            echo "<p class='my_task' style='font-weight:bold;color:black;'> .מצטערים לא נמצא מידע על פורומים</p>\n";
            echo "<p>  כול ההחלטות היא רשומת אב.</p>\n";
            return;
        }else{

            echo "<h1>תוצאות החיפוש</h1>\n";


// build comma-separated string with decIDs
//===============================================
            //$items = min($pagesize, sizeof($decisions));
            $items = sizeof($decisions);
            for($i=0; $i<$items; $i++)
                if($i==0)
                    $decisionIDs = $decisions[$i]->decID;
                else
                    $decisionIDs .= "," . $decisions[$i]->decID;


            $count=sizeof($decisions);

            if($count==1)
                echo "<p class='my_task' style='font-weight:bold;color:black;'>החלטה אחת נימצאה.</p>\n";
            else
                echo "<p class='my_task' style='font-weight:bold;color:black;'> ($count)  החלטות  נימצאו .</p>\n";

            echo '<input type="hidden"  id="count_my_decID" value="'. $count . '" >';

            echo '<div id="find_message">';




            echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";


            echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";


            $url="../admin/forum_demo12_2.php";
            $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
            echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr></table>\n";


            echo '</div>';



// get all decision data (no forums)
// =====================================================

            $sql="SELECT d.*,r.catID
		FROM decisions d
		left join rel_cat_dec r
		on (d.decID=r.decID)
		WHERE d.decID IN ($decisionIDs)";
            if($catID && $catID!='none')
                $sql.=" AND r.catID=$catID ORDER BY d.decName";
            else
                $sql.="ORDER BY d.decName";
            $decisionrows = $db->queryObjectArray($sql);

// get the forums for these decisions
//===============================================

            if(!$decisionIDs){
                $sql =
                    "SELECT f.forum_decName, r.forum_decID, r.decID 
                 FROM forum_dec f, rel_forum_dec r 
                  WHERE f.forum_decID = r.forum_decID 
                   ORDER BY f.forum_decName ";
                $rows = $db->queryObjectArray($sql);

            }else{$sql =
                "SELECT f.forum_decName,m.managerID,m.managerName, r.forum_decID, r.decID,r.dec_managerID 
		        FROM forum_dec f, rel_forum_dec r,managers m
		        WHERE f.forum_decID = r.forum_decID
		        AND f.managerID=m.managerID
		        AND r.decID IN ($decisionIDs) ";
                if($forum_decID && $forum_decID!='none')
                    $sql.="and f.forum_decID=$forum_decID
		         ORDER BY f.forum_decName" ;
                else
                    $sql.="ORDER BY f.forum_decName" ;

                $rows  = $db->queryObjectArray($sql);
            }
// build assoc. array for fast access to forums
//===================================================
            if($rows){
                foreach($rows as $forum)
                    $forums[$forum->decID][]=array($forum->forum_decName, $forum->forum_decID,$forum->managerName, $forum->managerID, $forum->dec_managerID);
            }
//============================================================================
// get all categories to show categories
//====================================================================

            $sql = "SELECT catName, catID, parentCatID FROM categories";
            $rows2 = $db->queryObjectArray($sql);
            // build assoc. array for fast access to category names and parent cats
            foreach($rows2 as $cat) {
                $catNames[$cat->catID] = $cat->catName;
                $catParents[$cat->catID] = $cat->parentCatID; }


            // show all decisions in a table
//=====================================================================================
// get all forums to show forums
//====================================================================

            $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec";
            if($rows3 = $db->queryObjectArray($sql))



                // build assoc. array for fast access to category names and parent cats
                foreach($rows3  as $forum) {
                    $forumNames[$forum->forum_decID] = $forum->forum_decName;
                    $forumParents[$forum->forum_decID] = $forum->parentForumID; }



            // show all decisions in a table
//==========================RESULT_TABLE===========================================================

            $count_info=count($decisions);
            $count_info1=count($decisions);
            ?>
            <input type=hidden name="count_info" id="count_info"  value="<?php echo $count_info;?>" />
            <table class="resulttable" id="resulttable"  ><tr><td>

            <?php

//=====================================================================================
            if(($catID && $catID!='none' && $catID!=''  )){

                $sql="SELECT catName from categories WHERE catID=$catID";
                if($get_cat=$db->queryObjectArray($sql)){


                    $catName_dec=$get_cat[0]->catName;
                }

                echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");



                echo '<td class="td3head">';
                form_label1('סוגי החלטות:');
                form_label1($catName_dec);

                ?>

                <a class="tTip" href='#' title="גרף סוגיי ההחלטות" class="my_decLink" OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי החלטות');this.blur();return false;";  >
                    <img src='<?php echo ROOT_WWW;?>/images/pie6.gif'     onMouseOver="src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'"  onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie6.gif'"    title='הצג נתונים' />
                </a>
                <?php

                echo '</td class="td3head">';

            }



            echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
            $i=0;
            $count_forums=0;
            /*********************************************************/
            foreach($decisions as $decision) {
                /*********************************************************/


                if($decision->decID!='11'){
                    if($i==0){
                        echo '<li class="li_page" id="first_li" >';
                    }else{
                        echo '<li class="li_page"  id="first_li'.$i.'" >';
                    }



                    ?>

                    <table class="resulttable" id="my_resulttable_<?PHP echo $i; ?>" ><!-- for pagination -->

                    <input type=hidden name="decID" id="decID" value="<?php echo  $decision->decID;?>" />

                    <input type=hidden name="table_num" class="table_num" value="<?php echo  $i;?>" />

                    <?php





                    $url='/php-prj/alon-web/dec/admin/';

                    $sql="select managerName, managerID from managers ";
                    if($rowsSel = $db->queryObjectArray($sql))
                        $rowSel=$rowsSel[0];


                    $dec_title=$decision->note;
                    $decision->note=explode( '.',  $decision->note);
                    $subtitle='';


                    foreach($decision->note as $note){
                        $subtitle.=$note.'\n';
                    }



                    $filename = ROOT_WWW.'/admin/js/find.js';

                    $dec_title1=$db->sql_string ($decision->note[0]) ;
                    if($i==0){

                    }
//class='menu2'
                    $html = "<tr><td class='td3head' style='cursor:pointer;' ><a class='my_decLink' href='javascript:void(0)'  title_dec='$dec_title'  title='הצג את ההחלטה עצמה'    mode='$dec_title'   mode_1='$dec_title' >  $decision->decName  </a>";
                    /*******************************************************************************/
                    $url='/php-prj/alon-web/dec/admin/';
                    $str_cat="רמת חשיבות החלטה";
                    $dec_id=$decision->decID;
                    $frm_id=$decision->forum_decID;
                    $str_task="משימות של ההחלטה";

                    /*************************************************************************************************************************************/
                    if(!array_item($_REQUEST,'find_decUser')  ){
                        $html .=" <a href='javascript:void(0)' class='my_decLink'  OnClick='return editDec( \"$dec_id\" ,\"$frm_id\" ,\"$decision->catID\" ,\"".ROOT_WWW."/admin/\"  )'  title='הצג נתוני החלטה בחלון' >
            <img src='".ROOT_WWW."/images/icon-folder.gif'     onMouseOver='src=\"".ROOT_WWW."/images/opened.gif\"' onMouseOut='src=\"".ROOT_WWW."/images/icon-folder.gif\"'   />
          </a>";



                        $html.="<a href='javascript:void(0)'  class='my_decLink'  OnClick='return  opengoog2(\"".ROOT_WWW."/admin/PHP/AJX_CAT_LEVEL/Default.php?forum_decID=$frm_id\",\"$str_cat\");this.blur();return false;'; title='הצג גרף נתוני  החלטות בפורום הנוכחי' >
         <img src='".ROOT_WWW."/images/pie-chart-icon.png'   onMouseOver='src=\"".ROOT_WWW."/images/pie6.gif\"' onMouseOut='src=\"".ROOT_WWW."/images/pie-chart-icon.png\"'/>
       </a>" ;


//$html.="<img src='".ROOT_WWW."/images/house.gif'  OnClick= 'return  openmypage3(\"".ROOT_WWW."/admin/make_task_find.php?decID=$decision->decID&forum_decID=$frm_id\");this.blur();return false;'   onMouseOver='src=\"".ROOT_WWW."/images/doc.gif\"' onMouseOut='src=\"".ROOT_WWW."/images/house.gif\"'  class='my_task_img'  title='הצג את המשימות של ההחלטה' />";

                        $html.="<a href='javascript:void(0)'  class='my_decLink' OnClick= 'return  openmypage3(\"".ROOT_WWW."/admin/make_task_find.php?decID=$decision->decID&forum_decID=$frm_id\");this.blur();return false;' title='הצג משימות'> 
        <img src='".ROOT_WWW."/images/house.gif'     onMouseOver='src=\"".ROOT_WWW."/images/doc.gif\"' onMouseOut='src=\"".ROOT_WWW."/images/house.gif\"'  class='my_task_img'  title='הצג את המשימות של ההחלטה' />
       </a>";

                    }

                    /***************************************************************************************************************************************/

                    if($level){

                        if(!$_SESSION['decID'] && !$_SESSION['mult_dec_ajx']
                            && !array_item($_POST,'conn_second')
                            && !array_item($_POST,'change_conn_first')
                            && !array_item($_REQUEST,'conn_secound_test')
                            && !array_item($_REQUEST,'conn_first_test')
                            && !array_item($_REQUEST,'find_decUser')  ){


                            $html.= build_href2("dynamic_5b.php","mode=insert","&insertID=$decision->decID", "(קישור ראשון)","style='color:blue' class='my_decLink' title='קשר החלטה להחלטה קיימת'") . " " .
                                build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink' title='עדכן את שם כותרת ההחלטה בלבד'"). " " .
                                build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                        }


                        if(!$_SESSION['decID'] && $_SESSION['mult_dec_ajx']){
                            $html.=build_href2("mult_dec_ajx.php","mode=insert","&insertID=$decision->decID", "(קישור ראשון)","style='color:blue' class='my_decLink' title='קשר החלטה להחלטה קיימת'") . " " .
                                build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink' title='עדכן את שם כותרת ההחלטה בלבד' "). " " .
                                build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                            unset($_SESSION['mult_dec_ajx']);
                        }


                        if($_SESSION['decID']){
                            $html.= build_href2("dynamic_5b.php","mode=link_second","&insertID=$decision->decID", "(קישור שני)","style='color:blue' class='my_decLink' title='קשור לשתי החלטות' ") . " " .
                                build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink' title='עדכן את שם כותרת ההחלטה בלבד' "). " " .
                                build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                        }

                        if( array_item($_POST,'conn_second')   && array_item($_POST,'conn_second')!=null  ){
                            $id=$formdata['decID'];
                            $sql="SELECT parentDecID1 from decisions where decID=$id";
                            if($rows=$db->queryObjectArray($sql)){
                                $parentDecID1=$rows[0]->parentDecID1;
                            }
                            $html.= build_href4("dynamic_5b.php","mode=link_second","&insertID=$decision->decID&decID=$id", "(קישור שני)","class=change_conn insertID=$decision->decID  decID=$id  parentDecID1=$parentDecID1 title=קשור לשתי החלטות ") . " " .
                                build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink' title='עדכן את שם כותרת ההחלטה בלבד' "). " " .
                                build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                        }


                    }//$level
//////////////////////////
                    elseif(!$level){    ///
////////////////////////
                        $html.= build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(מידע מורחב)","style='color:blue' class='my_decLink' title=' צפייה במידע קיים ובמבנה ההחלטה'");
                    }
                    /*********************POPUP_RESULT*******************************/
                    if( array_item($_REQUEST,'conn_secound_test')   && array_item($_REQUEST,'conn_secound_test')!=null  ){
                        $id=$formdata['decID'];
                        $sql="SELECT parentDecID1 from decisions where decID=$id";
                        if($rows=$db->queryObjectArray($sql)){
                            $parentDecID1=$rows[0]->parentDecID1;
                        }
                        $html.= build_href4("dynamic_5b.php","mode=link_second","&insertID=$decision->decID&decID=$id", "(קישור שני)","class=change_conn insertID=$decision->decID  decID=$id   parentDecID1=$parentDecID1  title=קשור לשתי החלטות ") . " " .
                            build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink'"). " " .
                            build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                    }
                    /****************************************************************/
                    if(  array_item($_REQUEST,'conn_first_test') && array_item($_REQUEST,'conn_first_test')!=null   ){
                        //|| (array_item($_REQUEST,'find_decUser')   && array_item($_REQUEST,'find_decUser')!=null)

                        $id=$formdata['decID'];

                        $sql="SELECT parentDecID1 from decisions where decID=$id";
                        if($rows=$db->queryObjectArray($sql)){
                            $parentDecID1=$rows[0]->parentDecID1;
                        }


                        $html.= build_href4("dynamic_5b.php","mode=change_insert_b","&insertID=$decision->decID&decID=$id", "(שנה קישור ריאשון)","class=change_conn_first insertID=$decision->decID  decID=$id $formdata[decID]=$id parentDecID1=$parentDecID1 title='קשר החלטה להחלטה קיימת'") . " " .

                            build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink' title='עדכן את שם כותרת ההחלטה בלבד' "). " " .
                            build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                    }
                    /****************************************************************/
                    if(  array_item($_REQUEST,'find_decUser') && array_item($_REQUEST,'find_decUser')!=null   ){

                        $html.= build_href4("dynamic_5b.php","mode=change_insert_b","&insertID=$decision->decID", "(בחר החלטה)",
                            "class=choose_dec insertID=$decision->decID  decID=$decision->decID $formdata[decID]=$decision->decID");// . " " .

//	 	   build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink' title='עדכן את שם כותרת ההחלטה בלבד' "). " " .
//	       build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                    }
                    /****************************************************************/




                    if( array_item($_POST,'change_conn_first')  && array_item($_POST,'change_conn_first')!=null  ){
                        $id=$formdata['decID'];

                        $sql="SELECT parentDecID1 from decisions where decID=$id";
                        if($rows=$db->queryObjectArray($sql)){
                            $parentDecID1=$rows[0]->parentDecID1;
                        }


                        $html.= build_href4("dynamic_5b.php","mode=change_insert_b","&insertID=$decision->decID&decID=$id", "(שנה קישור ריאשון)","class=change_conn$id insertID=$decision->decID  decID=$id $formdata[decID]=$id parentDecID1=$parentDecID1") . " " .

                            build_href2("dynamic_5b.php","mode=update", "&updateID=$decision->decID", "(עדכן שם)","style='color:blue' class='my_decLink' title='עדכן את שם כותרת ההחלטה בלבד'  "). " " .
                            build_href2("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "(עידכון מורחב)","style='color:blue' class='my_decLink' title='עריכת החלטה וצפייה במידע קיים' ");
                    }
                    /**********************/

                    echo $this->td5asis($html, "td3head");

                    /*********************/

// echo "
//					 <a class='tooltip_find' href='#'>
//							 Critical<span class='custom critical'>
//							 <img src='".ROOT_WWW."/images/tooltip/Critical.png' alt='Error' height='48' width='48' />
//
//							 <em>Critical</em>This is just an example of what you can do using a CSS tooltip, feel free to get creative and produce your own!
//
//							 </span>
//						</a> ";




//=====================================================================================================================================

//echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
//
//     echo '<tr>
//             <div id="my_find_tree">';
//           	echo '<td class="td5head">עץ ההחלטות</td>';
//
//           	echo '<td class="td5head">';
//          echo	" <a href='#' OnClick='return editDec_tree( \"$decision->decID\",\"$decision->forum_decID\",\"$decision->catID\",  \"".ROOT_WWW."/admin/\"  )' >
//
//
//              <img src='".ROOT_WWW."/images/Tree-03-icon.png' title='הצג קישורים' class='my_tree_img'  id=my_pic_".$decision->decID .$decision->forum_decID .$decision->catID." />
//
//
//
//              </a>";
//          echo "<div id=my_dec_tree".$decision->decID."".$decision->forum_decID."".$decision->catID.">
//
//
//          </div>";
//         echo '</td>';
//
//
// echo '</div>
//    </tr>';

                    // show all forums for this decision
//=====================================================================================================================================

//=====================================================================================================================================

                    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");//secound black line

                    echo '<div id="my_find_tree"><tr>';
                    echo '<td><span class="td5head">עץ ההחלטות:</span>';

                    //	echo '<td class="td5head">';
                    echo	" <a href='#' OnClick='return editDec_tree( \"$decision->decID\",\"$decision->forum_decID\",\"$decision->catID\",  \"".ROOT_WWW."/admin/\"  )' >
              <img src='".ROOT_WWW."/images/Tree-03-icon.png' title='הצג קישורים' class='my_tree_img'  id=my_pic_".$decision->decID .$decision->forum_decID .$decision->catID." /></a>";
                    echo '<div id=my_dec_tree'.$decision->decID.''.$decision->forum_decID.''.$decision->catID.'></div>';
                    echo '</td>';




                    echo '</tr></div>';

                    // show all forums for this decision
//=====================================================================================================================================
                    if( $count_forums==(count($forums[$decision->decID]) )  )
                        $count_forums=0;

                    if($decision->forum_decID ){

                        $fID=$decision->forum_decID;
                        $fName=$decision->forum_decName;

                        echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");

                        echo '<tr>';


                        echo '<td><span class="td5head"> הפורום/ים: </span> ';

                        //echo '<td class="td3head">';
                        echo $this->tdurl($fName, "find3.php?forum_decID=$fID",$fID  );

                        echo '</tr>';


                        /******************************************/
// echo $this->td3(" הפורום/ים:");
//$this->td_url ($fName, "find3.php?forum_decID=$fID","");


                        /********************************************/




                        echo '<tr>';
                        if($decision->managerID ){
                            $mID=$decision->managerID;
                            $mName=$decision->managerName;
                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");

                            echo '<td><span class="td5head"> המנהל: </span> ';
//						 echo '<td class="td5head"> המנהל : </td>';
//						 echo '<td class="td3head">';
                            echo $this->tdurl($mName, "find3.php?managerID=$mID",$mID  );

                            echo '</tr>';
                        }
                    }



//============================================================================
// get rel manager
//====================================================================
                    if   ($decision->dec_managerID
                        && ! ($decision->dec_managerID==0)
                        &&  !($decision->dec_managerID==$decision->managerID)  ){

                        $mID2=$decision->dec_managerID;
                        $sql="select managerID,managerName from managers where managerID=$mID2 ";
                        if($get_relMgr=$db->queryObjectArray($sql)){

                            $managerName=$get_relMgr[0]->managerName;



                            echo '<tr>';

                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");

                            echo '<td><span class="td5head">המנהל בעת קבלת ההחלטה: </span> ';

                            echo $this->tdurl($managerName, "find3.php?managerID=$mID2",$mID2  );



                            echo '</tr>';






                        }
                        /********************************************************/
                    }//end if $get_relMgr
                    /****************************USERS***************************************************/

                    $checkDec=explode(",", $decisionIDs);
                    $checkDec=array_unique($checkDec);

                    if($decision->forum_decID){
                        $j=0;
                        $count_frm=count($forums[$decision->decID]);

                        $sql2 = "SELECT u.full_name,u.userID, r.forum_decID 
				FROM users u, rel_user_Decforum  r 
				WHERE u.userID = r.userID
				AND r.forum_decID = $decision->forum_decID
                AND r.decID =$decision->decID 
		        ORDER BY  u.full_name ";

                        if( $rows2 = $db->queryObjectArray($sql2)){
                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                            echo '<tr><td   class="myformtd">';

                            ?>


                            <input type=hidden name="past_usr_frm<?php echo $i;echo $j;?>" id="past_usr_frm<?php echo $i;echo $j;?>"  value="<?php echo $i;echo $j;?>" />
                            <input type=hidden name="cntFrm" id="cntFrm"  value="<?php echo $count_frm;?>" />
                            <h5 class="my_Past_usr_frm<?php echo $i;echo $j;?>" style=" height:15px"></h5>
                            <h6 class="my_Past_usr_frm_2<?php echo $i;echo $j;?>" style=" height:15px;cursor:pointer;"></h6>
                            <div id="my_Past_usr_frm_content<?php echo $i;echo $j;?>" class="my_Past_usr_frm_content" >
                            <div id="my_Past_usr_frm_content_2<?php echo $i;echo $j;?>" class="my_Past_usr_frm_content" >
                            <table id="my_Past_usr_tbl<?php echo $i;echo $j;?>" class="resulttable">
                            <?php

                            $frmName=$decision->forum_decName;//$forum[0];

                            $str_dec_mem="בעת קבלת ההחלטה:";
                            $str_dec_mem1="חברי פורום";

                            $this->td_dec_mem ($str_dec_mem1,$frmName, "find3.php?forum_decID=$fID",$str_dec_mem);

                            foreach ($rows2 as $row){

                                echo '<tr><td class="td3head"><span class="td5head"> חבר פורום: </span> ',
                                $this->td3url ($row->full_name, "find3.php?userID=$row->userID");
                            }

                            echo '</table></div></div></td></tr>';
                        }

                    }



                    /************************************************************************************/
                    // if available, show more decision information
//==============================================מסלול החלטות============================================

                    $sql = "SELECT decName, decID, parentDecID  FROM decisions";
                    $rows1 = $db->queryObjectArray($sql);

                    foreach($rows1 as $dec) {
                        $decNames[$dec->decID] = $dec->decName;
                        $decParents[$dec->decID] = $dec->parentDecID;
                    }

                    /*********************************************מסלול קטגוריה************************************************/

                    $sql1 = "SELECT d.decName, d.decID, d.parentDecID ,	c.catName,c.catID  FROM decisions d
        left join rel_cat_dec r on d.decID=r.decID 
        left join categories c on c.catID=r.catID";
                    $rows5 = $db->queryObjectArray($sql1);


                    foreach($rows5  as $cat) {
                        $decNames5[$cat->decID] = $cat->catName;
                        $decCatID[$cat->decID] = $cat->catID;
                        $decParents5[$cat->decID] = $cat->parentDecID; }

                    /*******************************************מסלול פורומים*************************************************/
                    $sql = "SELECT d.decName, d.decID, d.parentDecID ,f.forum_decName,f.forum_decID  FROM decisions d
        left join rel_forum_dec r on d.decID=r.decID 
        left join forum_dec f on f.forum_decID=r.forum_decID";
                    $rows4 = $db->queryObjectArray($sql);


                    foreach($rows4  as $dec) {
                        $decNames4[$dec->decID] = $dec->forum_decName;
                        $decForumID  [$dec->decID] = $dec->forum_decID;
                        $decParents4[$dec->decID] = $dec->parentDecID; }
                    /**********************************************************************************************************/
                    if(!$flag_aa){
                        $decID=$decision->decID;
                        if($dec){

//==============================================מסלול החלטות============================================
                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                            //			echo $this->td3("מסלול קבלת ההחלטה:"),
                            echo '<tr><td class="td3head"><span class="td5head"> מסלול קבלת ההחלטה: </span> ',
                            $this->tdTrackasis($this->build_dec_string($decNames, $decParents, $decID,$decIDs4));

                            /*******************************************מסלול פורומים*************************************************/
                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                            echo '<tr><td class="td3head"><span class="td5head"> מסלול הפורומים: </span> ',
                                //echo $this->td3("מסלול הפורומים:"),
                            $this->tdTrackasis($this->build_dec_string1($decNames4,$decParents4,$decID,$decForumID,$decision->forum_decID,$decision->forum_decName ));

                            /*********************************************מסלול קטגוריה************************************************/

                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                            //echo $this->td3("מסלול הקטגוריות:"),
                            echo '<tr><td class="td3head"><span class="td5head"> מסלול הקטגוריות: </span> ',
                            $this->tdTrackasis($this->build_dec_string2($decNames5, $decParents5, $decID,$decCatID ,$decision->catID,$decision->catName) );

                        }
                    }else{
//==========================================================================================
                        $decID=$decision->decID;
                        if($dec){

                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");

                            echo $this->td3("מסלול קבלת ההחלטה:"),
                            $this->tdTrackasis($this->build_dec_string($decNames, $decParents, $decID,$decIDs4));
                        }


                        if( $decision->forum_decID) {
                            $forum_decID=$decision->forum_decID;
                            if($forum_decID){

                                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                                echo $this->td3("מסלול הפורומים:"),
                                $this->tdTrackasis($this->build_forum_string($forumNames, $forumParents, $forum_decID));
                            }
                        }


                        if( $decision->catID) {
                            $catID=$decision->catID;
                            if($cat){

                                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                                echo $this->td3("מסלול הקטגוריות:"),
                                $this->tdTrackasis($this->build_cat_string($catNames, $catParents, $catID));
                            }
                        }
                    }
//==========================================================================================
                    echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");
                    if($decision->parentDecID!='11'){


                        $sql="select decName from decisions where decID=$decision->parentDecID";
                        if($row=$db->queryObjectArray($sql) ){


//					     echo $this->td3("מקושרת להחלטה:"),
//					     $this->td3_url($row[0]->decName, "find3.php?decID=$decision->parentDecID");

                            echo '<tr>';



                            $decID2=$decision->parentDecID;
                            echo '<td><span class="td5head">מקושרת להחלטה: </span> ';
                            echo $this->tdurl($row[0]->decName, "find3.php?decID=$decision->parentDecID",$decID2  );



                            echo '</tr>';



                        }
                        echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");



                    }




                    if($decision->parentDecID1){
                        $sql="select decName from decisions where decID=$decision->parentDecID1";
                        $row_parent=$db->queryObjectArray($sql);

//					echo $this->td3("מקושרת להחלטה נוספת:"),
//					$this->td3_url($row[0]->decName, "find3.php?decID=$decision->parentDecID1");
                        echo '<tr>';



                        $dec_parent=$decision->parentDecID;
                        echo '<td><span class="td5head">מקושרת להחלטה נוספת: </span> ';
                        echo $this->tdurl($row_parent[0]->decName, "find3.php?decID=$decision->parentDecID1",$dec_parent  );



                        echo '</tr>';



                        echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");
                    }
                    if($decision->status){
                        if($decision->status=='2')
                            $decision->status="החלטה פתוחה";
                        else
                            $decision->status="החלטה סגורה";

                        //  echo $this->td1_d("סטטוס:",$decision->status, "td5head");


                        echo '<tr>';

                        echo '<td><span class="td5head">סטטוס: </span> ';
                        echo $this->td_no_link($decision->status, "td3head"  );

                        echo '</tr>';




                        echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");
                    }
                    if($decision->vote_level){


                        //echo $this->td1_d("אחוז הצבעה:",$decision->vote_level."%", "td5head");
                        echo '<tr>';

                        echo '<td><span class="td5head">אחוז הצבעה: </span> ';
                        echo $this->td_no_link($decision->vote_level."%", "td3head"  );

                        echo '</tr>';

                        echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");
                    }
                    if($decision->dec_level){

                        //echo $this->td1_d("דרגת חשיבות החלטה:",$decision->dec_level, "td5head");

                        echo '<tr>';

                        echo '<td><span class="td5head">דרגת חשיבות החלטה: </span> ';
                        echo $this->td_no_link($decision->dec_level, "td3head"  );

                        echo '</tr>';

                        echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");
                    }
                    if($decision->dec_date){
                        list($year_date,$month_date, $day_date) = explode('-',$decision->dec_date);
                        $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;


                        $day_date=substr($day_date, 0,4);
                        $day_date=substr($day_date,1,2);
                        $decision_date="$day_date-$month_date-$year_date";

                        //	echo $this->td1_d("תאריך החלטה:",$decision_date, "td5head");

                        echo '<tr>';

                        echo '<td><span class="td5head">תאריך החלטה: </span> ';
                        echo $this->td_no_link($decision_date, "td3head"  );

                        echo '</tr>';


                        echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                    }



                    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");

                    echo "</table></li>\n";



                    $i++;
                    $count_forums++;
                }
            }//end foreach


//		 echo"</td></tr></table></fieldset></ol></div>\n";
            echo"</td></tr></table></ol></div></fieldset>\n";
//			 echo"</td></tr></table></ol></div>\n";

        }//end else

    }

    /**************************************************************************************************************************************/
function show_Reguser($rows,$userID){
    echo "<h1>תוצאות החיפוש</h1>\n";

    ?>
    <fieldset  class="my_fieldset" style="background: #94C5EB url(../images/background-grad.png) repeat-x;margin-bottom:50px;margin-left: 40px;margin-right:0px;width:95%;">
    <?php
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
    echo '<div id="content_page">';
    echo '<table class="resulttable" colspan=3>', "\n";

    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
    echo $this->td7("שם החבר:");
    $this->td3url($rows[0]->full_name,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");


    /****************************fname**********************************************************/
    echo $this->td7("שם פרטי:");
    $this->td3url($rows[0]->fname,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");

    /******************************lname*****************************************/
    echo $this->td7("שם מישפחה:");
    $this->td3url($rows[0]->lname,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    /**************************************************************************************/
    echo $this->td7("תאריך לידה:");
    $this->td3url($rows[0]->user_date,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");

    /****************************uname***************************************************/
    echo $this->td7("שם משתמש:");
    $this->td3url($rows[0]->uname,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");


    /**********************************upass**************************************************/
    echo $this->td7("סיסמה:");
    $this->td3url($rows[0]->upass,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");


    /*****************************level********************************************************/
    echo $this->td7("רמת הרשאה:");
    $this->td3url($rows[0]->level,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    /*****************************EMAIL*******************************************************/
    echo $this->td7("דואר אלקטרוני:");
    $this->td3url($rows[0]->email,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
//===========================================PHONE==============================================
    echo $this->td7("מספר טלפון:");
    $this->td3url($rows[0]->phone_num,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    /****************************LAST_LOGIN**********************************************************/
    echo $this->td7("כניסה אחרונה לאתר:");
    $this->td3url($rows[0]->last_login,  "find3.php?userID=$userID");
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    /****************************appoint**********************************************************/
//---------------------------------------------------------------------------------------------------------
    $sql="select f.appointID,f.forum_decID,f.forum_decName,u.userID ,u.full_name  from forum_dec f
     left join appoint_forum a on f.appointID=a.appointID 
     left join users u on u.userID=a.userID
      where u.userID= $userID " ;
    if($rows_appoint = $db->queryObjectArray($sql)){
        echo $this->td7("האים ממנה פורום:");
        foreach ($rows_appoint as $row)	{
            echo $this->td4("ממנה פורום:");
            $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");
            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        }

    }else{

        echo $this->td1_a("האים ממנה פורום:", "td2head"), $this->td2_a("   לא ממנה אף פורום.", "td2head");
    }


    /****************************appoint**********************************************************/
    $sql="SELECT ap.appointID,f.forum_decID,f.forum_decName FROM forum_dec f
     LEFT JOIN appoint_forum_history ap ON ap.forum_decID=f.forum_decID
      WHERE ap.appointID= (SELECT a.appointID FROM appoint_forum a
                     WHERE a.userID=$userID)" ;
    if($rows_appoint = $db->queryObjectArray($sql)){
        echo $this->td7("האים היה ממנה פורום:");
        foreach ($rows_appoint as $row)	{
            echo $this->td4("ממנה היה פורום:");
            $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");
            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        }

    }else{

        echo $this->td1_a("האים היה ממנה פורום:", "td2head"), $this->td2_a("לא ממנה היה אף פורום.", "td2head");
    }
//---------------------------------------------------------------------------------------------------------
    /****************************MANAGER**********************************************************/
    $sql="select f.managerID,f.forum_decID,f.forum_decName,u.userID ,u.full_name  from forum_dec f
     left join managers m on f.managerID=m.managerID 
     left join users u on u.userID=m.userID
      where u.userID= $userID " ;
    if($rows_manager = $db->queryObjectArray($sql)){
        echo $this->td7("האים מרכז פורום:");
        foreach ($rows_manager as $row)	{
            echo $this->td4("מרכז פורום:");
            $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");
            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        }

    }else{

        echo $this->td1_a("האים מרכז פורום:", "td2head"), $this->td2_a(" לא מרכז אף פורום.", "td2head");
    }

    /****************************PAST_MANAGER**********************************************************/
    $sql="SELECT rm.managerID,rm.managerName,f.forum_decID,f.forum_decName FROM forum_dec f
     LEFT JOIN manager_forum_history rm ON f.forum_decID=rm.forum_decID 
      WHERE rm.managerID= (SELECT m.managerID FROM managers m
                     WHERE m.userID=$userID) ";



    if($rows_manager = $db->queryObjectArray($sql)){
        echo $this->td7("האים היה מרכז פורום:");
        foreach ($rows_manager as $row)	{
            echo $this->td4("היה מרכז פורום:");
            $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");
            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        }

    }else{

        echo $this->td1_a("האים היה מרכז פורום:", "td2head"), $this->td2_a(" לא היה מרכז אף פורום.", "td2head");
    }








//---------------------------------------------------------------------------------------------------------
    /****************************FORUM_USER**********************************************************/
    $sql = "SELECT   r.forum_decID,f.forum_decName
				FROM  rel_user_forum  r
				 LEFT JOIN forum_dec f ON f.forum_decID=r.forum_decID 
				 LEFT JOIN users u ON u.userID=r.userID
				WHERE r.userID = $userID
				 ORDER BY  f.forum_decName";


    if($rows_user = $db->queryObjectArray($sql)){
        echo $this->td7("האים חבר בפורום:");
        foreach ($rows_user as $row)	{
            echo $this->td4("חבר בפורום:");
            $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");
            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        }

    }else{

        echo $this->td1_a("האים חבר בפורום:", "td2head"), $this->td2_a(" לא חבר באף פורום.", "td2head");
    }

    /**********************************PAST_USER****************************************************/
    $sql = "SELECT   r.forum_decID,f.forum_decName
				FROM  rel_user_forum_history   r
				 LEFT JOIN forum_dec f ON f.forum_decID=r.forum_decID 
				 LEFT JOIN users u ON u.userID=r.userID
				WHERE r.userID = $userID
				 ORDER BY  f.forum_decName";


    if($rows_user = $db->queryObjectArray($sql)){
        echo $this->td7("האים היה חבר בפורום:");
        foreach ($rows_user as $row)	{
            echo $this->td4("היה חבר בפורום:");
            $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");
            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        }

    }else{

        echo $this->td1_a("האים היה חבר בפורום:", "td2head"), $this->td2_a(" לא היה חבר באף פורום.", "td2head");
    }




//---------------------------------------------------------------------------------------------------------
    /****************************USERS**************************************************/
    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
    echo "</table></div></fieldset>\n";





    /*****************************/
}//end function show_Reguser
    /******************************************************************************************************************************************/

function show_forums($forums, $pagesize ,$formdata,$forum_decID,$cat_forumID="",$managerID="",$managerTypeID="",$userID="",$appointID="") {




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




    echo '<div>';
    echo "<table  align='center'><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";


    echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";


    $url="../admin/forum_demo12_2.php";
    $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
    echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td></tr>";

    echo '</table>';
    echo '</div>';

    echo "<h1>תוצאות החיפוש</h1>\n";


if(!$forums) {
    echo "<p class='my_task' style='font-weight:bold;color:blue;'>.מצטערים לא נמצא מידע על פורומים</p>\n";


    return;
}else{


    for($i=0; $i<count($forums); $i++){
        if($i==0){
            $forumIDs = $forums[$i]->forum_decID;
        }
        else{
            $forumIDs .= "," . $forums[$i]->forum_decID;

        }
        $decisions++;
    }


    //distinct the forumIDs
    $forum = explode(",", $forumIDs);
    $forum=array_unique($forum);
    $size_of_forum=count($forum);



    foreach($forum as $frm){
        $subForum []=$frm;
    }



    foreach($subForum as $key=>$val ){
        if(!$result["$forum_id"])
            $result["$forum_id"] = $val;
        else
            $result["$forum_id"] .= "," . $val;
    }
    $staff=$result["$forum_id"];



    /*******************************************************************************************************************/
    for($i=0; $i<count($forums); $i++){
        if($i==0 && $forums[$i]->decID){
            $decisionIDs = $forums[$i]->decID;
        }else{
            if($forums[$i]->decID  && ($forums[$i]->forum_decID)!='NULL')
                $decisionIDs .= "," . $forums[$i]->decID;
        }
    }

    //distinct the decisionIDs
    $dec_array = explode(",", $decisionIDs);
    $dec_array=array_unique($dec_array);


    $size_of_dec=count($dec_array);
    for($i=0; $i<$size_of_dec; $i++){
        if ($dec_array[$i]==0)
            unset($dec_array[$i]);

    }

    $decisionIDs= implode(",", $dec_array);


    /*******************************************************************************************************************/

//echo '<li>';
//style="width:95%;margin-left:00px;"
    ?>
    <div id="loading">
        <img src="loading4.gif" border="0" />
    </div>
    <?php


    if($forums[0]->forum_decID ){

        $sql="select distinct forum_decID, forum_decName, managerID, appointID, forum_date, active, parentForumID, manager_date, 
        appoint_date  from forum_dec where forum_decID in($staff)";




        /**********************************************************************/
        $rows3=$db->queryObjectArray($sql) ;                      /*
/**********************************************************************/

        $frm_id=$rows3[0]->forum_decID;


        if($decisionIDs){
            $sql1="select decName from decisions where decID in($decisionIDs)";
            $rows4=$db->queryObjectArray($sql1);
        }


        $a=count($rows3);
        if($a==1){
            echo "<p class='my_task' style='font-weight:bold;color:black;' id='my_forumID'>אותר פורום אחד .</p>\n";
        }else{
            echo "<p class='my_task' style='font-weight:bold;color:black;' id='my_forumID'>   $a  פורומים  אותרו .</p>\n";
        }
    }else{
        $name=$forums[0]->full_name;
        echo "<p>החבר $name לא חבר/מנהל/מרכז בפורום  </p>\n";
    }

    echo '<input type="hidden"  id="count_my_forum_decID" value="'.$a.'" >';

    /****************************************STRUCTURE****************************************************************************/

    // get all decisions these forums have decid
    echo '<form><fieldset id="fieldset_frm"   style="border: 2px solid; -moz-border-radius: 10px;background: #94C5EB url(../images/background-grad.png) repeat-x;margin-bottom:50px;">';
    echo '<div id="content_page" class="menu2">';
    //echo '<table class="resulttable"  align="center">';
    echo '<table class="paginated"  id="my_find_ol"   align="center">';
    //	echo '<tr><td  style=" width:100%;">', "\n";
    /************************************************************************************/
    if(($formdata['forum_decision'] && $formdata['forum_decision']!='none')&& $forums[$i=0]->forum_decID ==$forums[$i+1]->forum_decID ){
    /************************************************************************************/


    //echo ' <ol class="paginated" style=" width:85%;"  id="my_find_ol" >';
    //echo '<li>', "\n";

    if($decisionIDs){
        echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
        $sql = "SELECT d.decName,d.decID,d.dec_date,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND d.decID in($decisionIDs)
				AND r.forum_decID = " . $db->sql_string($formdata['forum_decision']) .
            " ORDER BY  d.decName ";

        $rows = $db->queryObjectArray($sql);
    }else{
        echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
    }



    $id=$_GET['forum_decID'] ? $_GET['forum_decID']:$forums[$i]->forum_decID;
    $strName=$forums[$i]->forum_decName;

    $html = "<tr><td class='td3head' style='cursor:pointer;'>
	<a class='tTip'  title='לינק יפעל רק במצב אופן הצפייה בנתונים: בחלון' OnClick='return openmypage(\"".ROOT_WWW."/admin/find3.php?forum_decID=$id\"); return false;' > 
	 $strName 
	 </a> ";


    $html.="<a href='javascript:void(0)' class='tTip' 
          OnClick= 'return  opengoog2(\"".ROOT_WWW."/admin/PHP/AJX_FORUM/Default.php?forum_decID=$id\",\"$str_cat\");this.blur();return false;';>
         <img src='".ROOT_WWW."/images/pie-chart-icon.png'     onMouseOver='this.src=img.edit[4]' onMouseOut='src=\"".ROOT_WWW."/images/pie-chart-icon.png\"'    title='הצג נתוני רמת החלטה' />
       </a>" ;

    if($level){
        $html.=	  build_href2("dynamic_10_test.php","mode=update", "&updateID=$id", "(עדכן שם)","style='color:blue' class='tTip' "). " " .
            build_href2("dynamic_10_test.php","mode=read_data", "&editID=$id", "( עידכון מורחב)","style='color:blue' class='tTip' ");
    }elseif(!($level)){

        $html.= build_href2("dynamic_10_test.php","mode=read_data", "&editID=$id", "( מידע מורחב)","style='color:blue' class='tTip' ");


    }
    echo $this->td5asis($html, "tdhead");
    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");



    /****************************APPOINT**********************************************************/
    $formdata['appointID']=	$rows3[0]->appointID;



    $sql1 = "SELECT  appointName,appointID from appoint_forum where 
				 appointID=  " . $db->sql_string($formdata['appointID'])   ;
    $rows1 = $db->queryObjectArray($sql1);
    if($rows1)

        $appoint_date=$rows3[0]->appoint_date;
    list($year_date,$month_date, $day_date) = explode('-',$appoint_date);
    $appoint_date="$day_date-$month_date-$year_date";
    $appoint_date=" (תאריך צרוף)$appoint_date   ";


    $row1=$rows1[0];

    echo '<tr>';
    echo '<td><span class="td5head"> ממנה פורום: </span> ';
    $this->td_url ($row1->appointName, "find3.php?appointID=$row1->appointID",$appoint_date);
    echo '</tr>';







    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
    /******************************manager*****************************************/
    $formdata['managerID']=	$forums[$i]->managerID;








    $sql1 = "SELECT  managerName,managerID from managers where 
			     managerID=  " . $db->sql_string($formdata['managerID'])   ;
    $rows1 = $db->queryObjectArray($sql1);

    if($rows1)

        $manager_date=$rows3[0]->manager_date;
    list($year_date,$month_date, $day_date) = explode('-',$manager_date);
    $manager_date="$day_date-$month_date-$year_date";
    $manager_date=" (תאריך צרוף)$manager_date   ";





    $row1=$rows1[0];
    echo '<tr>';
    echo '<td><span class="td5head"> מרכז פורום: </span> ';
    $this->td_url ($row1->managerName, "find3.php?managerID=$row1->managerID",$manager_date);
    echo '</tr>';

    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");

    /****************************users***************************************************/
    $sql2 = "SELECT u.full_name,u.userID, r.forum_decID,r.HireDate
				FROM users u, rel_user_forum  r
				WHERE u.userID = r.userID
			    AND r.forum_decID = " . $db->sql_string($formdata['forum_decision']) .
        " ORDER BY  u.full_name ";

    if($rows2 = $db->queryObjectArray($sql2)){


    echo '<tr>';
    echo '<td><span class="td5head"> חברי הפורום: </span> ';
    $this->td_url ($rows3[0]->forum_decName, "find3.php?forum_decID=$frm_id[0]->forum_decID","");
    echo '</tr>';
    echo '<tr>';
    echo '<td   class="myformtd">';
    ?>
    <h3 class="my_usr_frm" style=" height:15px"></h3>
    <div id="my_usr_frm_content" class="my_usr_frm_content" >
    <table id="my_usr_frm_table" class="resulttable">
    <?php

    foreach ($rows2 as $row){
        $row->HireDate=substr($row->HireDate,0,10);
        list($year_date,$month_date, $day_date) = explode('-',$row->HireDate);
        $user_date="$day_date-$month_date-$year_date";
        $user_date=" (תאריך צרוף)$user_date   ";


        echo '<tr>';
        echo '<td><span class="td5head"> חבר פורום: </span> ';
        $this->td_url ($row->full_name, "find3.php?userID=$row->userID",$user_date);
        echo '</tr>';





        echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    }
    echo '</table></div></td></tr>';


    }

    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");



    /************************************************************************************/
    if($rows){
    $count_frm=count($rows);
    echo '<tr>';
    echo '<td><span class="td5head"> החלטות פורום: </span> ';
    $this->td_url ($rows3[0]->forum_decName, "find3.php?forum_decID=$frm_id[0]->forum_decID","");
    echo '</tr>';
    ?>

    <input type=hidden name="frm_decID" id="frm_decID" value="<?php echo $rows[0]->forum_decID;?>" />
    <input type=hidden name="count" id="count" value="<?php echo $count;?>" />
    <input type=hidden name="frm_decID<?php echo $count_dec;?>"  id="frm_decID<?php echo $count_dec;?>"  value="<?php echo $row->forum_decID;?>" />


    <tr>
    <td>

    <h5 class="my_decfrm<?php echo $rows[0]->forum_decID;?>" style=" height:15px"></h5>
    <h6 class="my_decfrm_2<?php echo $rows[0]->forum_decID;?>" style=" height:15px"></h6>
    <div id="my_decfrm_content<?php echo$rows[0]->forum_decID;?>" class="my_decfrm" >
    <div id="my_decfrm_content_2<?php echo$rows[0]->forum_decID;?>" class="my_decfrm" >
    <table id="my_frmRes_table<?php echo $rows[0]->forum_decID;?>" class="resulttable">
    <?php
    $count_dec=0;

    foreach ($rows as $row){
        $row->dec_date=substr($row->dec_date,0,10);
        $dec_date=$row->dec_date;
        list($year_date,$month_date, $day_date) = explode('-',$dec_date);
        $dec_date="$day_date-$month_date-$year_date";
        $dec_date=" (תאריך קבלת ההחלטה)$dec_date   ";


        //	$row=$rows[0];

        echo '<tr>';
        echo '<td><span class="td5head"> החלטה: </span> ';
        $this->td_url ($row->decName, "find3.php?decID=$row->decID",$dec_date);
        echo '</tr>';

        echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        $count_dec++;
    }

    echo '</table></div></div></td></tr>';

    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
    }
    /*****************************DECISIONS CATEGORY********************************************************/

    $this->set_category($forums);

    /**************************************SUB_FORUM************************************/
    $sql="select distinct forum_decID,parentForumID,managerID,forum_decName from forum_dec where forum_decID in($forumIDs)";
    $rows5=$db->queryObjectArray($sql);

    if($rows5[0]->parentForumID!=11 && $rows5[0]){
        $sql4="select forum_decName from forum_dec where forum_decID= " . $db->sql_string($rows5[0]->parentForumID);
        $row4=$db->queryObjectArray($sql4);
        //echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");
        $forumid=$rows5[0]->parentForumID;
        $find_forumName="select forum_decName from forum_dec where forum_decID=$forumid";
        $fname=$db->queryObjectArray($find_forumName);

// 					echo $this->td3("מקושר לפורום:"),
// 					$this->td3url($fname[0]->forum_decName, "find3.php?forum_decID=$forumid");


        echo '<tr>';
        echo '<td><span class="td5head"> מקושר לפורום: </span> ';
        $this->td_url ($fname[0]->forum_decName, "find3.php?forum_decID=$forumid","");
        echo '</tr>';

        echo $this->td1("", "tdinvisible"),$this-> td2asis("&nbsp;", "tdinvisible");
    }
    /*******************************FORUM_DATE********************************************************************/
    if($forums[$i]->forum_date){
        list($year_date,$month_date, $day_date) = explode('-',$forums[$i]->forum_date);
        $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;


        $day_date=substr($day_date, 0,4);
        $day_date=substr($day_date,1,2);
        $forum_date="$day_date-$month_date-$year_date";


//                    echo $this->td1_d("תאריך הקמת הפורום:",$forum_date, "td5head");
        $row=$rows[0];
        echo '<tr>';
        echo '<td><span class="td5head">תאריך הקמת הפורום: </span> ';
        echo "<b style='color:blue;'>$forum_date</b></td><td class='href_modal1' ></td></tr>\n" ;
        echo '</tr>';




        echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
    }
    //  echo "</td></tr></table></div></fieldset></form>\n";
    //echo "</td></tr></table></li>\n";
    //echo '</table>';
    /************************************************************************************/
    }elseif($forum_decID && $forum_decID!='none'){
    if($decisionIDs){
        $sql = "SELECT d.decName,d.dec_date,d.decID,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND d.decID in($decisionIDs)
				AND r.forum_decID = " . $db->sql_string($forum_decID) .
            " ORDER BY  d.decName ";



        $rows = $db->queryObjectArray($sql);
    }
    // process all forums, show all decisions for each forum
    //=======================================================================
    $id=$_GET['forum_decID'] ? $_GET['forum_decID']:$forums[$i]->forum_decID;

    $decisions=0;

    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");





    $strName=$forums[$i]->forum_decName ? $forums[$i]->forum_decName:$rows3[0]->forum_decName;

    $html = "<tr><td class='td3head' style='cursor:pointer;'><a class='tTip'  title='לינק יפעל רק במצב אופן הצפייה בנתונים: בחלון' OnClick='return openmypage(  \"".ROOT_WWW."/admin/find3.php?forum_decID=$id\"  ); return false;' >  $strName  </a> ";
    $html.="<a href='#' class='tTip' title='גרף ההחלטות בפורום'  OnClick= 'return  opengoog2(\"".ROOT_WWW."/admin/PHP/AJX_FORUM/Default.php?forum_decID=$id\",\"$str_cat\");this.blur();return false;';>
            <img src='".ROOT_WWW."/images/pie-chart-icon.png'     onMouseOver='this.src=img.edit[4]' onMouseOut='src=\"".ROOT_WWW."/images/pie-chart-icon.png\"'    title='הצג נתוני רמת החלטה' />
            </a>" ;
    if($level){
        $html.=	  build_href2("dynamic_10_test.php","mode=update", "&updateID=$id", "(עדכן שם)","style='color:blue' class='tTip' title='עדכן שם פורום בלבד'"). " " .
            build_href2("dynamic_10_test.php","mode=read_data", "&editID=$id", "( עידכון מורחב)","style='color:blue' class='tTip' title='ערוך פורום וצפה בנתונים' ");
    }elseif(!($level)){

        $html.=	  build_href2("dynamic_10_test.php","mode=read_data", "&editID=$id", "( מידע מורחב)","style='color:blue' class='tTip' title='צפה במיבנה הפורום ובנתונים נוספים'  ");
    }
    echo $this->td5asis($html, "tdhead");
    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");

    for($i=0; $i<1; $i++) {


    /****************************APPOINT**********************************************************/
    $formdata['appointID']=	$rows3[0]->appointID;
    $sql1 = "SELECT  appointName,appointID from appoint_forum where 
				 appointID=  " . $db->sql_string($formdata['appointID'])   ;
    $rows1 = $db->queryObjectArray($sql1);
    if($rows1)

        /*******************************************************/
        echo '<tr>';

    $appID=$rows1[0]->appointID;
    foreach ($rows1 as $row1){
        echo '<td><span class="td5head"> ממנה פורום: </span> ';
        echo $this->tdurl($row1->appointName, "find3.php?appointID=$row1->appointID",$appID  );
    }
    echo '</tr>';
    /*********************************************************/
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
    /****************************MANAGER**********************************************************/
    $formdata['managerID']=	$forums[$i]->managerID;





    $sql1 = "SELECT  managerName,managerID from managers where 
				 managerID=  " . $db->sql_string($formdata['managerID'])   ;

    if($rows1=$db->queryObjectArray($sql1)){

        $manager_date=$rows3[0]->manager_date;
        list($year_date,$month_date, $day_date) = explode('-',$manager_date);
        $manager_date="$day_date-$month_date-$year_date";
        $manager_date=" (תאריך צרוף)$manager_date   ";



        echo '<tr>';

        $mgrID=$rows1[0]->managerID;
        foreach ($rows1 as $row1){
            echo '<td><span class="td5head"> מרכז הפורום: </span> ';
            $this->td_url ($row1->managerName, "find3.php?managerID=$row1->managerID",$manager_date);
        }




        echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
        echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
    }
    /****************************USERS**************************************************/

    $sql2 = "SELECT u.full_name,u.userID, r.forum_decID,r.HireDate
				FROM users u, rel_user_forum  r
				WHERE u.userID = r.userID
			    AND r.forum_decID = " . $db->sql_string($forum_decID) .
        " ORDER BY  u.full_name ";


    if($rows2 = $db->queryObjectArray($sql2)){


    echo '<tr>';
    echo '<td   class="myformtd">';
    ?>
    <h5 class="my_usr_frmDec" style=" height:15px"></h5>
    <h6 class="my_usr_frmDec_2" style=" height:15px"></h6>
    <div id="my_usr_frmDec_content" class="my_usr_frmDec_content" >
    <div id="my_usr_frmDec_content_2" class="my_usr_frmDec_content" >
    <table id="my_usr_frmDec_table" class="resulttable"><tr>
    <?php
    foreach ($rows2 as $row){
        $row->HireDate=substr($row->HireDate,0,10);
        list($year_date,$month_date, $day_date) = explode('-',$row->HireDate);
        $user_date="$day_date-$month_date-$year_date";
        $user_date=" (תאריך צרוף)$user_date   ";



        echo '<tr>';
        $usrID=$rows2[0]->userID;
        echo '<td><span class="td5head"> חבר פורום: </span> ';
        $this->td_url ($row->full_name, "find3.php?userID=$row->userID",$user_date);


        echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    }
    echo '</tr></table></div></div></td></tr>';
    }




    /************************************************************************************/
    //DECISION
    /************************************************************************************/
    if($rows){
    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");

    echo '<tr>';
    echo '<td   class="myformtd">';
    ?>
    <input type=hidden name="my_dec_frm" id="my_dec_frm" value="<?php echo $forum_decID;?>">
    <h5 class="my_dec_frm" style=" height:15px"></h5>
    <h6 class="my_dec_frm_2" style=" height:15px"></h6>
    <div id="my_dec_frm_content" class="my_decision_frm_content" >
    <div id="my_dec_frm_content_2" class="my_decision_frm_content" >
    <table id="my_dec_frm_table" class="resulttable"><tr>
    <?php
    foreach($rows as $row)
        if($rows[$i]->forum_decID == $row->forum_decID)  {

            $row->dec_date=substr($row->dec_date,0,10);
            $dec_date=$row->dec_date;
            list($year_date,$month_date, $day_date) = explode('-',$dec_date);
            $dec_date="$day_date-$month_date-$year_date";
            $dec_date=" (תאריך קבלת ההחלטה)$dec_date   ";



            // $row=$rows[0];
            echo '<tr>';
            echo '<td><span class="td5head"> החלטה: </span> ';
            $this->td_url ($row->decName, "find3.php?decID=$row->decID",$dec_date);
            echo '</tr>';



        }
    $decisions++;
    echo '</tr></table></div></div></td></tr>';
    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
}


}//end for try to delelte
    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
    $this->set_category($forums);
    /**************************************SUB_FORUM************************************/
    $child_forumid=$_GET['forum_decID']?$_GET['forum_decID']:$rows3[0]->forum_decID;

    $sql="select distinct forum_decID,parentForumID,managerID,forum_decName from forum_dec where forum_decID=$child_forumid";
    $rows5=$db->queryObjectArray($sql);

    if($rows5[0]->parentForumID!=11 && $rows5[0]->parentForumID){

        $forumid=$rows5[0]->parentForumID;
        $find_forumName="select forum_decName from forum_dec where forum_decID=$forumid";
        $fname=$db->queryObjectArray($find_forumName);



        echo '<tr>';
        echo '<td><span class="td5head"> מקושר לפורום: </span> ';
        $this->td_url ($fname[0]->forum_decName, "find3.php?forum_decID=$forumid","");
        echo '</tr>';


    }
    /************************************FORUM_DATE**********************************************************/
    if($rows3[0]->forum_date){
        list($year_date,$month_date, $day_date) = explode('-',$rows3[0]->forum_date);
        $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;


        $day_date=substr($day_date, 0,4);
        $day_date=substr($day_date,1,2);
        $forum_date="$day_date-$month_date-$year_date";


        echo '<tr>';
        echo '<td><span class="td5head">תאריך הקמת הפורום: </span> ';
        echo "<b style='color:blue;'>$forum_date</b></td><td class='href_modal1' ></td></tr>\n" ;
        echo '</tr>';

    }

    /***********************************************************************************/
    echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");

    //  echo "</td></tr></table></div></fieldset></form>\n";

    /************************************************************************************/
}elseif(($formdata['forum'] && $formdata['forum']!='none')){
    $this->forum_info($rows3,$forums);

    /************************************************************************************/
}elseif(($cat_forumID && $cat_forumID!='none') ){
    echo '<input type="hidden" name="my_catForumID"  id="my_catForumID" value="'.$cat_forumID.'">';
    $this->forum_info($rows3,$forums,'','',$cat_forumID);

    /**********************************************************************************************/
}elseif( $managerTypeID && $managerTypeID!='none'){
    $this->forum_info($rows3,$forums,'','','',$managerTypeID);

    /********************************************************************************************/
}elseif(($managerID && $managerID!='none' )){
    $this->forum_info($rows3,$forums,$managerID);

    if(!($managerTypeID) || $managerTypeID=='none'  ){
        echo '<fieldset id="my_history_fieldset_mgr"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
        $this->manager_history($rows7);
        echo '</fieldset>';

    }
    /*******************************************************************************************************************************/
}elseif($appointID && $appointID!='none'){
    $this->forum_info($rows3,$forums,'',$appointID);

    echo '<fieldset id="my_history_fieldset_app"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
    $this->appoint_history();
    echo '</fieldset>';
    /***********************************SEARCH_SPECIFIC_USER*************************************************/
}elseif($userID && $userID!='none'){
//=====================================================================================

    if($rows3){

        echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");

        $userID=$_GET['userID']?$_GET['userID']:$userID;

        $sql_user = "SELECT  full_name, userID   
				        FROM users  
				       WHERE userID=$userID";




        if($rows_user=$db->queryObjectArray($sql_user) ){
            $row_user=$rows_user[0];

            echo $this->td5("החבר:");

            $url=   ROOT_WWW."/admin/"  ;
            $title='פרטים אישיים של החבר';
            $this->td4url($row_user->full_name,$url,'',$row_user->userID,$title);
        }


        $this->forum_info($rows3,$forums);

        echo '<fieldset id="my_history_fieldset_usr"  class="my_fieldset" style="border: 2px solid; -moz-border-radius: 10px;margin-bottom:50px;margin-left:40px;overflow:auto; background: #94C5EB url(../images/background-grad.png) repeat-x;width:95%;margin-right:0px;margin-left: 0px">';
        $this->user_history();
        echo '</fieldset>';

        /********************************************************************************************/
    }else{
        /********************************************************************************************/
        echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "");
        echo $this->td5("החבר:", "td2head");
        $str=$forums[0]->full_name;
        $id=$forums[0]->userID;
        $html = htmlspecial_utf8($str) . " " .
            build_href2("print_users.php","mode=update", "&id=$id", "(צפה בפרטי החבר)","style='color:blue'");
        //build_href1("dynamic_5b.php","mode=read_data", "&editID=$decision->decID", "( עידכון מורחב)");
        echo $this->td2asis($html, "td2head");

    }
    /************************************************************************************/
}//end if userID




}//end else if forum exist

// 	       echo "</li></ol></td></tr></table></div></fieldset></form>\n";
    echo "</table></div></fieldset></form>\n";
}

//**************************************DEC_CATEGORY****************************************************/
//=====================================================================
    function subcategory_list($subcats, $catID) {
        $lst = $catID;
        if(array_key_exists($catID, $subcats))
            foreach($subcats[$catID]	 as $subCatID)
                $lst .= ", " .$this->subcategory_list($subcats, $subCatID);
        return $lst;
    }

//=======================================================================================

    function message_save( &$subcatarray ,$decID){


        // message
        echo "<p>.נישמרה ההחלטה  ",
        build_href2("dynamic_5b.php","mode=read_data", "&editID=$decID", $subcatarray,"style='color:blue'"),
        " </p>\n";
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
    /*****************************************************************************************/
    /*******************************************************************************************/
    // returns a string with URLs to $catID an all
//===============================================
    // higher level categories
    function build_cat_string($catNames, $catParents, $catID) {
        $tmp = build_href("find3.php", "catID=$catID", $catNames[$catID]);
        while($catParents[$catID] != NULL) {
            $catID = $catParents[$catID];

            if($catID=='11')
                break;

            $tmp = build_href("find3.php", "catID=$catID", $catNames[$catID]) .
                "<span class=show_arr> &larr; </span> " . $tmp; }
        return $tmp;
    }
    /**********************************************************************************************/
    function build_forum_string( $forumNames,$forumParents,$forum_decID) {

        $tmp = build_href("find3.php", "forum_decID=$forum_decID", $forumNames[$forum_decID]);
        while($forumParents[$forum_decID] != NULL) {
            $forum_decID = $forumParents[$forum_decID];

            if($forum_decID=='11')
                break;

            $tmp = build_href("find3.php",  "forum_decID=$forum_decID", $forumNames[$forum_decID]) .
                "<span class=show_arr> &larr; </span> " . $tmp; }
        return $tmp;
    }
    /**************************************************************************************************************/


    function build_dec_string($decNames, $decParents, $decID,$id="") {
        if(is_numeric($decNames[$decID]))
            $decNames[$decID]=(string)$decNames[$decID];

        $str='onclick=\'openmypage("find3.php?decID='.$decID.'"); return false;\'   class=href_modal1 ';
        $tmp = build_href5("find3.php", "decID=$decID", $decNames[$decID],$str);
        while($decParents[$decID] != NULL) {
            $decID = $decParents[$decID];

            if($decID=='11')
                break;

            $str1='onclick=\'openmypage("find3.php?decID='.$decID.'"); return false;\'   class=href_modal1 ';

            if(is_numeric($decNames[$decID]))
                $decNames[$decID]=(string)$decNames[$decID];

            $tmp = build_href5("find3.php", "decID=$decID", $decNames[$decID],$str1) .
                "<span class=show_arr> &larr; </span> " . $tmp;
        }

        return $tmp;
    }

    /***************************************************************************************/




    function build_dec_string1($decNames, $decParents, $decID,$id="",$forum_decID,$forum_decName) {

        if(is_numeric($decNames[$decID]))
            $decNames[$decID]=(string)$decNames[$decID];

        $str='onclick=\'openmypage("find3.php?forum_decID='.$forum_decID.'"); return false;\'   class=href_modal1 ';
        $tmp = build_href5("find3.php", "forum_decID=$forum_decID", $forum_decName,$str);
        while($decParents[$decID] != NULL) {
            $decID = $decParents[$decID];

            if($decID=='11')
                break;

            if(is_numeric($decNames[$decID]))
                $decNames[$decID]=(string)$decNames[$decID];

            $str1='onclick=\'openmypage("find3.php?forum_decID='.$id[$decID].'"); return false;\'   class=href_modal1 ';
            $tmp = build_href5("find3.php", "forum_decID=$id[$decID]", $decNames[$decID],$str1) .
                "<span class=show_arr> &larr; </span> " . $tmp;


        }

        return $tmp;
    }

//==========================================================================================
    function build_dec_string2($decNames, $decParents, $decID,$id="",$catID,$catName) {

        if(is_numeric($decNames[$decID]))
            $decNames[$decID]=(string)$decNames[$decID];


        $str='onclick=\'openmypage("find3.php?catID='.$catID.'"); return false;\'    class=href_modal1  id='.$catID.'  ';
        $tmp = build_href5("find3.php", "catID=$catID", $catName,$str);
        while($decParents[$decID] != NULL) {
            $decID = $decParents[$decID];

            if($decID=='11')
                break;

            if(is_numeric($decNames[$decID]))
                $decNames[$decID]=(string)$decNames[$decID];

            $str1='onclick=\'openmypage("find3.php?catID='.$id[$decID].'"); return false;\'    class=href_modal1   ';
            $tmp = build_href5("find3.php", "catID=$id[$decID]", $decNames[$decID],$str1) .

                "<span class=show_arr> &larr; </span>"  . $tmp;

        }

        return $tmp;
    }

//==========================================================================================

    function build_dec_string_test($decNames, $decParents, $decID,$id="") {
        $i=0;
        unset($decParents_b);
        $decParents_b=array();
        while($decParents[$decID] != NULL) {

            $decParents_b[$i]=$decID;
            $decID = $decParents[$decID];
            if($decID=='11')
                break;
            $i++;
        }
        $decParents_b=	array_reverse($decParents_b);



        for($i=0;$i<(count($decParents_b));$i++ ){

            $decID = $decParents_b[$i];

            if($i!=(0) ){
                $tmp = build_href("find3.php", "decID=$decID", $decNames[$decID]) .
                    " &larr;, " . $tmp;
            }else{
                $tmp = build_href("find3.php", "decID=$decID", $decNames[$decID]) .
                    "" . $tmp;
            }
        }



        $tmp_a=explode(',',$tmp);
        $tmp_a=array_reverse($tmp_a);
        for($i=0; $i<count($tmp_a); $i++){
            if($i==0){
                $tmp_b =  $tmp_a[$i]. "&larr;"  ;
            }
            else{
                $tmp_b .= " " . $tmp_a[$i];

            }

        }

        return $tmp_b;
    }

    /***************************************************************************************/
    function build_cat_test_string($catNames, $catParents, $catID) {
        $tmp = build_href("find.php", "catID=$catID", $catNames[$catID]);
        while($catParents[$catID] != NULL) {
            $catID = $catParents[$catID];
            $tmp = build_href("find.php", "catID=$catID", $catNames[$catID]) .
                " &rarr; " . $tmp; }
        return $tmp;
    }

//.html
    /*******************************************************************************/



    function td2asis($txt, $class="td2") {
        echo "<td class=\"$class\">$txt</td></tr>\n"; }



    function td2asisb($txt, $class="td2") {
        echo "<td class=\"$class\">$txt</td><td class=\"$class\"></td></tr>\n"; }
    // help building result table

    function td3asis($txt, $class="td3") {
        echo "<td  class=\"$class\">$txt</td></tr>\n"; }


    function td4asis($txt, $class="td3") {
        echo "<td  class=\"$class\">$txt</td></td></tr>\n"; }


    function td5asis($txt, $class="td3") {
        echo "$txt </td class=\"$class\"><td class=\"$class\"></td></tr>\n"; }


    function td6asis($txt, $class="td3") {
        echo "$txt </span class=\"$class\"><span class=\"$class\"></span></div></td>\n"; }

    /*******************************************************************************/



    function tdTrackasis($txt, $class="td3",$class2="td3head") {
//	echo "</td class=\"$class\"><td class=\"$class2\">$txt</td></tr>\n"; }
        echo "$txt</td></tr>\n"; }




//status
    /*************************************/
    function tda($txt, $class="td1") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt), "\n"; }


    function tdb($txt, $class="td2") {
        echo  htmlspecial_utf8($txt), "</td  class=\"$class\"><td  class=\"$class\"></td></tr>\n"; }
    /***************************************/


    function td1_b($txt,$txt1, $class="td1") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt),htmlspecial_utf8($txt1),"</td><td class=\"$class\"></td></tr>\n"; }

    function td1_c($txt,$txt1, $class="td1") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt),htmlspecial_utf8($txt1),"</td></tr>\n"; }

    function td1_d($txt,$txt1, $class="td1") {
// echo "<tr><td class=\"$class\">$txt</td><td class='td3head'> $txt1 </td></tr>\n"; }
        echo "<tr><td class=\"$class\" ><span> $txt</span><span ><b style='color:blue;'>$txt1</b></span> </td></tr>\n"; }
//================================================

    function td1_dec_mem($txt,$txt1,$txt2, $class="td1") {
        echo "<tr><td class=\"$class\">$txt <b style='color:blue;'> $txt1 </b>  $txt2  </td></tr>\n"; }
// echo "<tr><td class=\"$class\" ><span> $txt</span></td></tr>\n"; }


//===============================================
    function td_dec($txt, $class="td1") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt), "</td></tr>\n"; }
//=============================================================================

    function tdh($class,$txt) {
        echo "<div><tr><td><h3 class=\"$class\"></h3><div id=\"$txt\">\n"; }
    //htmlspecial_utf8($txt), "</h3><div id=\"$txt\">\n"; }

    function tdivOpen($txt) {
        echo "<div id=\"$txt\">\n"; }

    function tdivClose() {
        echo "</div></td></tr></div>\n"; }


//===============================================================================

    function td_color1($txt, $class="my_task") {
        echo "<tr><td  class=\"$class\">",
        htmlspecial_utf8($txt), "</td>\n"; }
//================================================================================
    function td1($txt, $class="td1") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt), "</td>\n"; }


    function td1_a($txt, $class="td1") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt), "\n"; }


    /*******************************************************************************/
    function td2($txt, $class="td2") {
        echo "<td class=\"$class\">",
        htmlspecial_utf8($txt), "</td></tr>\n"; }



    function td2_a($txt, $class="td2") {

        echo htmlspecial_utf8($txt)."<td class=\"$class\"></td></td class=\"$class\"></tr>\n";


    }
    /*******************************************************************************/

    function td3($txt, $class="td5head") {
        echo "<tr><td class=\"$class\">" ,
        htmlspecial_utf8($txt); }


    function td3_a($txt, $class="td3") {

        echo "</td class=\"$class\"><td  class=\"$class\"></td><tr>\n",
        htmlspecial_utf8($txt);
    }

//===============================================================================


    function td4($txt, $class="td4") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt) ; }

    /*******************************************************************************/
    function td5($txt, $class="td5") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt) ; }

    /*******************************************************************************/
    function td6($txt, $class="td6") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt) ; }

    /*******************************************************************************/
    function td7($txt, $class="td7" ) {
        echo "<tr><td class=\"$class\"   id='my_dlgtd'>",
        htmlspecial_utf8($txt) ; }

    function td7a($txt, $class="td7" ) {
        echo "</td class=\"$class\"></tr>" ; }
    /*******************************************************************************/
    function td8($txt, $class="td8") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt), "</td></tr>\n"; }

    /*******************************************************************************/
    function td9($txt, $class="td9") {
        echo "<tr><td class=\"$class\">",
        htmlspecial_utf8($txt), "</td>\n"; }
//================================================================================================================================================================

//IFRAME

//	function td3url($txt, $url ,$free_text="",$str='onclick=" return changeIframeSrc(  \'ifrm\' , this.href)"' ,$class="td2") {
//	 echo   build_href5($url, "", $txt,$str);
//     echo "$free_text</td><td class=\"$class\"></td></tr>\n" ;
//	}

//================================================================================================================================================================

//DIALOG


//function td3url($txt, $url ,$free_text="",$str="onclick='return showDialog();return false;' target=_parent  class=modal_href",$class="td2") {
//		//function td3url($txt, $url ,$free_text="",$str="",$class="td2") {
//
//	 echo   build_href5($url, "", $txt,$str);
//     echo "$free_text</td><td class=\"$class\"></td></tr>\n" ;
//	}

//================================================================================================================================================================

//WINDOW1


// function td3url($txt, $url ,$free_text="",$str='onclick="openMyModal( \'../../dec/admin/find3.php\' ); return false; target=_blank;"' ,$class="td2") {
//		function td3url($txt, $url ,$free_text="",$str='onclick="openMyModal( \'../../dec/admin/find3.php\' ); return false; target=_blank;"' ,$class="td2") {
//	 echo   build_href5($url, "", $txt,$str);
//     echo "$free_text</td><td class=\"$class\"></td></tr>\n" ;
//	}

//================================================================================================================================================================


//WINDOW2
//function td3url($txt, $url ,$free_text="",$str="onclick='$(this).modal({width:1100, height:600 }).open()  ;
//  $(this).parent.modal.hide(); return false;'   class=modal_href",$class="td2") {


//good
    //function td3url($txt, $url ,$free_text="",$str="onclick='$(this).modal({width:1100, height:600 }).open(); return false;'  class=modal_href",$class="td2") {


//	 echo   build_href5($url, "", $txt,$str);
//     echo "$free_text</td><td class=\"$class\"></td></tr>\n" ;
//	}
//================================================================================================================================================================
//AJAX



//<a href="'. $scripturl . '?action=tpadmin;blockon=', $lblock['id'] ,';sesc='.$context['session_id'].'">
//<img "id="blockonbutton' .$lblock['id']. '" title="activate" border="0" src="images/TP' , $lblock['off']=='0' ? 'green' : 'red' , '.gif" alt="activate"  />
//</a>';






    /**************************************************************************************************/

//function td3url($txt, $url ,$free_text="",$class="td2",$str='onclick="openmypage(); return false" class=href_modal1' ,$class="td2" ) {
//
//	 echo   build_href5($url, "", $txt,$str);
//     echo "$free_text</td><td class=\"$class\"></td></tr>\n" ;
//	}
    /*******************************************************************************/
    function tdburl($txt, $url, $class="td2") {
        echo   build_href($url, "", $txt), "</td  class=\"$class\"></tr>\n" ;
    }
    /*******************************************************************************/


    function td2url($txt, $url, $class="td2") {
        echo "<td class=\"$class\">",
        build_href($url, "", $txt), "</td></tr>\n" ;
    }

    /*******************************************************************************/
    function td2txturl($txt, $urltxt, $url, $class="td2") {
        echo "<td class=\"$class\">",
        htmlspecial_utf8($txt), " ",
        build_href($url, "", $urltxt), "</td></tr>\n"; }
    /*******************************************************************************/
    /*************************************************************************************/
    function tdurl($txt, $url ,$free_text=""){

        $str='onclick=\'openmypage("'.$url.'"); return false;\'   class=href_modal1  id="'.$free_text.'"    ';
//$str='class=href_modal1 ';
        $this->td_no_tr_url($txt, $url ,$free_text,$str);
    }


    function td_no_tr_url($txt, $url ,$free_text="",$str,$class="td3head"){

        $strUrl=    build_href5($url, "", $txt,$str);


        //echo "$free_text</td><td class=\"$class\">$strUrl</td>\n" ;
        echo " <span class=\"$class\"> $strUrl</span></td>\n" ;
        //echo " $strUrl</td>\n" ;

    }

    /**************************************************************************************/
    function td_no_link($txt,$class="td3head"){


        echo " <span class=\"$class\"> $txt</span></td>\n" ;


    }
    /**************************************************************************************/
    function td_url($txt, $url ,$free_text=""){

        $str='onclick=\'openmypage("'.$url.'"); return false;\'   class=href_modal1 ';

        $this->td1_url($txt, $url ,$free_text,$str);
    }



    function td1_url($txt, $url ,$free_text="",$str,$class=""){

        $strUrl=    build_href5($url, "", $txt,$str);
        echo "$strUrl <b style='color:blue;'>$free_text</b></td><td class=\"$class\"></td></tr>\n" ;


    }
    /************************************2_LINK_OPEN_WINDOWS********************************************************************/

    function td_url2link($txt,$text1, $url ,$url1,$free_text=""){

        $str='onclick=\'openmypage("'.$url.'"); return false;\'   class=href_modal1 ';
        $str1='onclick=\'openmypage("'.$url1.'"); return false;\'   class=href_modal1 ';
        $this->td_2link($txt,$text1, $url ,$url1,$free_text,$str,$str1);
    }



    function td_2link($txt,$txt1, $url ,$url1,$free_text="",$str,$str1,$class=""){

        $strUrl=    build_href5($url, "", $txt,$str);
        $strUrl1=    build_href5($url1, "", $txt1,$str1);
        echo "$strUrl $free_text $strUrl1</td><td class=\"$class\"></td></tr>\n" ;


    }





    /*************************spacial function for-מקושרת להחלטה*************************************************************/
    function td3_url($txt, $url ,$free_text=""){

        $str='onclick=\'openmypage("'.$url.'"); return false;\'   class=href_modal1 ';

        $this->td_wurl($txt, $url ,$free_text,$str);
    }



    function td_wurl($txt, $url ,$free_text="",$str,$class="td3head"){

        $strUrl=    build_href5($url, "", $txt,$str);
//     echo "$free_text</td><td class=\"$class\">$strUrl</td></tr>\n" ;
        echo "$free_text $strUrl</td></tr>\n" ;

    }
    /**************************************************************************************/
    function td3url($txt, $url ,$free_text=""){

        $str='onclick=\'openmypage("'.$url.'"); return false;\'   class=href_modal1 ';

        $this->tdwurl($txt, $url ,$free_text,$str);
    }



    function tdwurl($txt, $url ,$free_text="",$str,$class="td2"){

        $strUrl=    build_href5($url, "", $txt,$str);
        echo "$free_text $strUrl</td></tr>\n" ;


    }
    /***************************************************************************/
    //   $this->td_dec_mem ($str_dec_mem1,$frmName, "find3.php?forum_decID=$row->forum_decID,$str_dec_mem");

    function td_dec_mem($txt,$txt1, $url ,$free_text=""){

        $str='onclick=\'openmypage("'.$url.'"); return false;\'   class=href_modal1 ';

        $this->tdurl_dec_mem($txt,$txt1, $url ,$free_text,$str);
    }



    function tdurl_dec_mem($txt,$txt1, $url ,$free_text="",$str,$class="td5head"){

        $strUrl=    build_href5($url, "", $txt1,$str);
        echo "<tr><td ><span class=\"$class\"> $txt $strUrl $free_text</span> </td></tr>\n" ;


    }
//======================================SEARCH_SPECIFIC_USER==========================================================================================================================
    function td4url($txt, $url ,$free_text="",$id,$title=""){

        $str='onclick=\'editReg_user("'.$id.'","'.$url.'"); return false;\' class=tTip title="'.$title.'" ';

        $this->tdwurl4($txt, $url ,$free_text,$str,$id);
    }



    function tdwurl4($txt, $url ,$free_text="",$str,$id,$class="td2"){
        $url2=ROOT_WWW."/admin/find3.php?userID=$id"  ;
        echo   build_href5($url2, "", $txt,$str);
        echo "$free_text</td><td class=\"$class\"></td></tr>\n" ;


    }


    /*******************************************************************************/
    function td5url($txt, $url,$str ,$free_text="",$class="td2") {
        echo   build_href5($url, "", $txt,$str);
        echo "$free_text</td><td class=\"$class\"></td></tr>\n" ;
    }

    /*******************************************************************************************/
    function td6url($txt, $url ,$free_text=""){

        $str='onclick=\'openmypage("'.$url.'"); return false;\'   class=href_modal1 ';

        $this->tdwurl6($txt, $url ,$free_text,$str);
    }

    function tdwurl6($txt, $url ,$free_text="",$str,$class="td2"){

        echo   build_href5($url, "", $txt,$str);
        echo "$free_text</td></tr>\n" ;


    }

    /*******************************************************************************/
    /*******************************************************************************************/
    function td7url($txt, $url="" ,$free_text=""){
        $url="http://alon-dev.eh/php-prj/alon-web/dec/admin/PHP/DB_dataURL/Default.php";
// $str='onclick=\'opengoog2 ("'.$url.'","'.$text.'"); \'';
        $str='onclick=\'open_google("'.$url.'"); \'';

        $this->tdwurl7($txt, $url ,$free_text,$str);
    }

    function tdwurl7($txt, $url ,$free_text="",$str="",$class="td2"){

        echo   build_href5("#", "", $txt,$str);
        echo "$free_text</td></tr>\n" ;


    }

    /*******************************************************************************/
//show_page_links($page, $pagesize, sizeof($rows), $query);
// show links to previos/next page
//===============================================
// $page     .. current page no.
    // $pagesize .. max. no. of items per page
    function show_page_links($page, $pagesize, $results, $query) {

        if(($page==1 && $results<=$pagesize) || $results==0)
// nothing to do
            return;
        echo "<p>Goto page: ";
        if($page>1) {
            for($i=1; $i<$page; $i++)
                echo build_href("find3.php", $query . "&page=$i", $i), " ";
            echo "$page "; }
        if($results>$pagesize) {
            $nextpage = $page + 1;
            echo build_href("find3.php", $query . "&page=$nextpage", $nextpage);
        }
        echo "</p>\n";
    }						// $results  .. no. of search results


    /**********************************************************************************/
    function show_page_links2($sql,$rows) {
        $_GET['sql']=$sql;
        $per_page = 22;


        $count = count($rows);
        $pages = ceil($count/$per_page);
        ?>

        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/paging.css" />


        <div id="loading1" ></div>
        <div id="content1" ></div>
        <ul id="pagination1" >
            <?php

            //Pagination Numbers
            for($i=1; $i<=$pages; $i++)
            {
                echo '<li id="'.$i.'" >'.$i.'</li>';
            }
            ?>
        </ul>
        <?php
    }
    /***************************************************************************/
    function prepareRow($r)
    {

        return array(
            'forum_decID' => $r->forum_decID,
            'forum_decName' =>htmlarray($r->forum_decName) ,
            'forum_date' => $r->forum_date,
            'managerID' => $r->managerID,
            'appointID' => $r->appointID,
            'cat_forumID' => $r->cat_forumID,
            'cat_forumName' => htmlarray($r->cat_forumName),
            'cat_Name' => htmlarray($r->cat_Name),
            'managerName' => htmlarray($r->managerName),
            'appointName' => htmlarray($r->appointName),
            'managerTypeName' => htmlarray($r->managerTypeName),
            'managerTypeID' => $r->managerTypeID,
            'decID' => $r->decID,
            'decName' => htmlarray($r->decName),

        );
    }





//========================================================================================================
    function forum_info(&$rows3,$forums,$managerID='',$appointID='',$cat_forumID='',$managerTypeID=''){
        global $db;


//echo '<form >';
// echo '<fieldset id="fieldset_frm"   style="border: 2px solid; -moz-border-radius: 10px;background: #94C5EB url(../images/background-grad.png) repeat-x;margin-bottom:50px;">';
// echo '<div id="content_page" class="menu2">';
//echo '<tr class="paginated" style=" width:85%;"  id="my_find_ol" ><td>';
//  echo '<table class="paginated"  id="my_find_ol"   align="center">';
// echo '<tr><td class="paginated">', "\n";
        //echo '<ol class="paginated" style=" width:85%;"  id="my_find_ol" >';
//echo '<li>', "\n";

        $mem_job="החבר:";
        $mor_forum="חבר גם בפורום/ים";

        mb_internal_encoding( 'UTF-8' );
        $sql="SET lc_time_names = 'he_IL'";
        $db->execute($sql);
//========================================================================================================

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





        if(($managerID && $managerID!='none' && $managerID!=''  )){

            $sql="SELECT userID,managerName from managers WHERE managerID=$managerID";
            if($getmgr=$db->queryObjectArray($sql)){

                $mgrusrID=$getmgr[0]->userID;
                $mgrusrName=$getmgr[0]->managerName;
            }

            echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
            echo $this->td5("המנהל/ת:");

            $url=   ROOT_WWW."/admin/"  ;
            $title='פרטים אישיים של המנהל';
            $this->td4url($mgrusrName,$url,'',$mgrusrID,$title);
        }
//=====================================================================================
        if(($appointID && $appointID!='none' && $appointID!=''  )){

            $sql="SELECT userID,appointName from appoint_forum WHERE appointID=$appointID";
            if($get_app=$db->queryObjectArray($sql)){

                $app_usrID=$get_app[0]->userID;
                $app_usrName=$get_app[0]->appointName;
            }

            echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
            echo $this->td5("הממנה:");

            $url=   ROOT_WWW."/admin/"  ;
            $title='פרטים אישיים של הממנה';
            $this->td4url($app_usrName,$url,'',$app_usrID,$title);
        }
//=====================================================================================
//=====================================================================================

        if(($cat_forumID && $cat_forumID!='none' && $cat_forumID!=''  )){
            $name="סוגי פורומים";
            $sql="SELECT catName from categories1 WHERE catID=$cat_forumID";
            if($get_cat=$db->queryObjectArray($sql)){


                $catName_frm=$get_cat[0]->catName;
            }

            echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");

            echo '<td class="td3head">';

            form_label1('סוגי פורומים:');
            form_label1($catName_frm);
            //echo $this->td1_d("סוגי פורומים:",$catName_frm, "td5head");
            ?>

            <a href='#' title='גרף סוגי בפורומים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
                <img src='<?php echo ROOT_WWW;?>/images/pie6.gif'     onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[3]"   title='הצג נתונים' />
            </a>


            <?php

            echo '</td class="td3head">';


        }

//=====================================================================================
        if(($managerTypeID && $managerTypeID!='none' && $managerTypeID!=''  )){

            $sql="SELECT managerTypeName from manager_type WHERE managerTypeID=$managerTypeID";
            if($get_catMgr=$db->queryObjectArray($sql)){


                $catName_mgr=$get_catMgr[0]->managerTypeName ;
            }

            echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");



            echo '<td class="td3head">';
            form_label1('סוגי מנהלים:');
            form_label1($catName_mgr);

            ?>
            <a href='#' title='גרף סוגי מנהלים'  class="tTip"  OnClick="return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJAX/default.php'"; ?>,'סוגי מנהלים')"  >
                <img src='<?php echo ROOT_WWW;?>/images/pie6.gif'     onMouseOver="this.src=img.edit[1]" onMouseOut="this.src=img.edit[3]"   title='הצג נתונים' />
            </a>
            <?php

            echo '</td class="td3head">';

        }
//=====================================================================================

        echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
        $decisions=0;
        $i=0;
        $count_forum=count($rows3);

        $str_cat="נתוני הפורום";


        /***************************************/
        foreach($rows3 as $row){          /*
***************************************/


            if($row->forum_decID!='11'){

//		 	if($i==0)
//				echo '<li class="li_page" id="first_li" >';
//				else
//    			echo '<li class="li_page"  id="first_li'.$i.'"  >';
                if($i==0){
                    echo '<tr class="page_tr" id="first_li" >';
                }else{
                    echo '<tr class="page_tr"  id="first_li'.$i.'" >';
                }




                $frm_id=$row->forum_decID;

//echo '<li   id="first_li'.$i.'"  >';


                ?>
                <td>
            <table  id="my_resulttable_<?PHP echo $i; ?>" style="width:110%;">
                <!--                  <tr><td>   -->
                <input type=hidden name="table_num" class="table_num" value="<?php echo  $i;?>" />

                <?php
                $strName=$row->forum_decName;

                $html = "<tr><td class='td3head' style='cursor:pointer;'>
   <a   class='my_decLink'  title='לינק יפעל רק במצב אופן הצפייה בנתונים: בחלון' OnClick='return openmypage(  \"".ROOT_WWW."/admin/find3.php?forum_decID=$row->forum_decID\"  ); return false;' >  $strName  </a> ";


                $html.="<a href='javascript:void(0)' title='גרף החלטות בפורומים' class='my_decLink'   OnClick= 'return  opengoog2(\"".ROOT_WWW."/admin/PHP/AJX_FORUM/Default.php?forum_decID=$frm_id\",\"$str_cat\");this.blur();return false;';>
         <img src='".ROOT_WWW."/images/pie-chart-icon.png'     onMouseOver='this.src=img.edit[4]' onMouseOut='src=\"".ROOT_WWW."/images/pie-chart-icon.png\"'    title='הצג נתוני רמת החלטה' />
       </a>" ;

                if($level){
                    $html.= build_href2("dynamic_10_test.php","mode=update", "&updateID=$row->forum_decID", "(עדכן שם)","class='my_decLink'  style='color:blue' title='עדכן שם פורום בלבד'"). " " .
                        build_href2("dynamic_10_test.php","mode=read_data", "&editID=$row->forum_decID", "( עידכון מורחב)","class='my_decLink'  style='color:blue' title='ערוך פורום וצפה בנתונים'");
                }elseif(!($level)){
                    $html.=	build_href2("dynamic_10_test.php","mode=read_data", "&editID=$row->forum_decID", "( מידע מורחב)","class='my_decLink' style='color:blue' title='צפה במבנה הפורום ובנתונים נוספים'");
                }
                echo $this->td5asis($html, "tdhead");
                echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");



                /****************************APPOINT**********************************************************/
                $formdata['appointID']=	$row->appointID;


                $appoint_date=$rows3[$i]->appoint_date;
                list($year_date,$month_date, $day_date) = explode('-',$appoint_date);
                $appoint_date="$day_date-$month_date-$year_date";
                $appoint_date=" (תאריך מינוי)$appoint_date   ";


                $sql1 = "SELECT  appointName,appointID from appoint_forum where 
				 appointID=  " . $db->sql_string($formdata['appointID'])   ;
                $rows1 = $db->queryObjectArray($sql1);
                if($rows1){
                    foreach ($rows1 as $row1)

                        /**********************************************************/
                        echo '<tr>';
                    echo '<td><span class="td5head"> ממנה פורום: </span> ';
                    $this->td_url ($row1->appointName, "find3.php?appointID=$row1->appointID",$appoint_date);
                    echo '</tr>';
                    /************************************************************/

                    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                }

                /****************************MANAGER**********************************************************/
                $formdata['managerID']=	$row->managerID;


                $manager_date=$rows3[$i]->manager_date;
                list($year_date,$month_date, $day_date) = explode('-',$manager_date);
                $manager_date="$day_date-$month_date-$year_date";
                $manager_date=" (תאריך מינוי)$manager_date   ";



                $sql1 = "SELECT  managerName,managerID ,userID from managers where 
				 managerID=  " . $db->sql_string($formdata['managerID'])   ;
                $rows1 = $db->queryObjectArray($sql1);
                if($rows1){
                    $mgr_userID=$rows1[0]->userID;
                    foreach ($rows1 as $row1)
                        /**********************************************************/
                        echo '<tr>';
                    echo '<td><span class="td5head"> מרכז פורום: </span> ';
                    $this->td_url ($row1->managerName, "find3.php?managerID=$row1->managerID",$manager_date);
                    echo '</tr>';
                    /************************************************************/

                    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                }


                /****************************USERS**************************************************/
                $forum_decID=$row->forum_decID;
                $sql2 = "SELECT u.full_name,u.userID, r.forum_decID,r.HireDate
				FROM users u, rel_user_forum  r
				WHERE u.userID = r.userID
			    AND r.forum_decID = " . $db->sql_string($forum_decID) .
                    " ORDER BY  u.full_name ";

            if($rows2 = $db->queryObjectArray($sql2)){


                echo '<tr>';
                echo '<td><span class="td5head"> חברי פורום: </span> ';
                $this->td_url ($strName, "find3.php?forum_decID=$forum_decID","");

                echo '</tr>';

                echo '<tr>';
                echo '<td   class="myformtd">';
                ?>
                <input type=hidden name="my_usr_frm<?php  echo $i;?>" id="my_usr_frm<?php  echo $i;?>"  value="<?php echo $i?>" />
                <input type=hidden name="count_forum" id="count_forum"  value="<?php echo $count_forum;?>" />
                <h5 class="my_usr_frm<?php echo $i?>" style=" height:15px"></h5>
                <h6 class="my_usr_frm_2<?php echo $i?>" style=" height:15px"></h6>

                <div id="my_usr_frm_content<?php echo $i;?>" >
                <div id="my_usr_frm_content_2<?php echo $i;?>" >
                <table  class="resulttable">

                <?php

                foreach ($rows2 as $row2){

                    $row2->HireDate=substr($row2->HireDate,0,10);
                    list($year_date,$month_date, $day_date) = explode('-',$row2->HireDate);
                    $user_date="$day_date-$month_date-$year_date";
                    $user_date=" (תאריך צרוף)$user_date   ";


                    /**********************************************************/
                    echo '<tr>';
                    echo '<td><span class="td5head"> חבר פורום: </span> ';
                    $this->td_url ($row2->full_name, "find3.php?userID=$row2->userID",$user_date);
                    echo '</tr>';
                    /************************************************************/
                }
                echo '</table></div></div></td></tr>';

                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
            }



                /**************************DECISIONS**********************************************************/

                $sql = "SELECT d.decName,d.dec_date,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				ORDER BY  d.decName";




                $usr_id=$_GET['userID'] ?(int)$_GET['userID']:$userID;
                if(!($usr_id)){
                    if(!($usr_id) && (!($this->userID) || ($this->userID=='none')) && $mgr_userID ){
                        $usr_id=$mgr_userID;
                        $this->userID=$mgr_userID;
                    }else{
                        $usr_id=$this->userID;
                    }
                }
                /************************************************/
            if($rows = $db->queryObjectArray($sql) ) {     /*
/***********************************************/

                echo '<tr>';
                echo '<td><span class="td5head"> החלטות הפורום: </span> ';
                $this->td_url ($strName, "find3.php?forum_decID=$forum_decID","");
                echo '</tr>';







                echo '<tr>';
                echo '<td   class="myformtd">';
                ?>

                <input type=hidden name="my_Forum_decision<?php echo $i;?>" id="my_Forum_decision<?php echo $i;?>" value="<?php echo $i;?>" />
                <input type=hidden name="count" id="count" value="<?php echo $count_forum;?>" />
                <h5 class="my_Forum_decision<?php echo $i;?>" style=" height:15px"></h5>
                <h6 class="my_Forum_decision_2<?php echo $i;?>" style=" height:15px"></h6>
                <div id="my_Forum_decision_content<?php echo $i;?>"  >
                <div id="my_Forum_decision_content_2<?php echo $i;?>"  >
                <table id="my_Forum_decision_tbl<?php echo $i;?>" class="resulttable">

                <?php


                /**********************************************/
                foreach($rows as $row2){
                    /*********************************************/
                    $row2->dec_date=substr($row2->dec_date,0,10);
                    $dec_date=$row2->dec_date;
                    list($year_date,$month_date, $day_date) = explode('-',$dec_date);
                    $dec_date="$day_date-$month_date-$year_date";
                    $dec_date=" (תאריך קבלת ההחלטה)$dec_date   ";

                    if($usr_id && $usr_id !='none'){
                        $sendTask_sql="SELECT  DISTINCT  t.*  ,u.userID,u.full_name,rt.userID,rt.dest_userID FROM todolist t
                                  
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 

			            		  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID

			            		  left JOIN users u
			            		  ON u.userID=rt.userID 

			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$row2->decID 
                                  AND rt.userID=$usr_id 
                                  AND t.forum_decID=$row2->forum_decID 
                                  ORDER BY t.taskID DESC";



                        $getTask  = $db->queryObjectArray($sendTask_sql);





                        $getTask_sql="SELECT   DISTINCT t.*  , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  
                                  LEFT JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  
			            		  LEFT JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  
			            		  LEFT JOIN users u
			            		  ON u.userID=rt.userID 

			            		  LEFT JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  WHERE t.compl IN(0,1)
                     			 
                                  AND t.decID=$row2->decID 
                                  AND rt.dest_userID=$usr_id 
                                  AND t.forum_decID=$row2->forum_decID 
                                   ORDER BY t.taskID DESC";




                        $getTaskForMe  = $db->queryObjectArray($getTask_sql);
                    }
                    $decID=$row2->decID;
                    $forum_decID=$row2->forum_decID;
                    $userID=$usr_id;
                    $flag=false;
                    if( !$getTask && !$getTaskForMe && $row2->decID){

                        echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                        echo '<tr>';
                        echo '<td><span class="td5head"> החלטה: </span> ';
                        echo $this->td_url($row2->decName, "find3.php?decID=$row2->decID",$dec_date);
                        echo '</tr>';




                    }

                    /*******************************build the form task that i wrote****************************/

                    if($getTask){

                        task_server($decID,$forum_decID,$this->userID,$row2);

                    }



                    /************************************** build the form of task have been wreeten for me*******************************/
                    if( $getTaskForMe 	){
                        $flag=true;
                        task_server($decID,$forum_decID,$this->userID,$row2,$flag);
                    }
                }//end foreach
                echo '</table></div></div></td></tr>';

            }//end if $rows


                /****************************MANAGER/APPOINT_OLSO_A_USER**************************************************/
                if( ($_GET['managerID'] && $_GET['managerID']!='none') || ($_POST['form']['manager_forum'] && $_POST['form']['manager_forum']!='none'
                        && is_numeric ($_POST['form']['manager_forum']))  ){
                    /************************************************************************************************************/



                    $sql2 = "select  m.userID ,u.full_name,u.userID, r.forum_decID,f.forum_decName from  managers  m
         left join users u on u.userID=m.userID
         left join rel_user_forum r on r.userID=u.userID 
         left join forum_dec f on r.forum_decID=f.forum_decID 
         WHERE  m.managerID=  " . $db->sql_string($formdata['managerID'])   ;



                    if($rows_usr = $db->queryObjectArray($sql2) ){
                        $name=$rows_usr[0]->full_name;

                        if($rows_usr[0]->forum_decID){

                            /**************************************************************/

                            $user=$rows_usr[0]->userID;
                            $user_mgrName='המנהל';
                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                            echo $this->td1("", ""), $this->td2asis("&nbsp;", "");

                            $this->td_dec_mem ($user_mgrName,$name, "find3.php?userID=$user",$mor_forum);


                            foreach ($rows_usr as $usr){
                                echo '<tr>';
                                echo '<td><span class="td5head"> חבר פורום: </span> ';
                                $this->td_url ($usr->forum_decName, "find3.php?forum_decID=$usr->forum_decID");
                                echo '</tr>';

                            }
                        }

                    }

                    /************************************************************************************************************/
                }elseif($_GET['appointID'] || ($_POST['form']['appoint_forum'] && $_POST['form']['appoint_forum']!='none'
                        && is_numeric ($_POST['form']['appoint_forum']))  ){
                    /************************************************************************************************************/



                    $sql2 = "select  a.userID ,u.full_name,u.userID, r.forum_decID,f.forum_decName from  appoint_forum  a
         left join users u on u.userID=a.userID
         left join rel_user_forum r on r.userID=u.userID 
         left join forum_dec f on r.forum_decID=f.forum_decID 
         WHERE  a.appointID=  " . $db->sql_string($formdata['appointID'])   ;

                    if($rows_usr = $db->queryObjectArray($sql2) ){
                        $name=$rows_usr[0]->full_name;
                        $user= $rows_usr[0]->userID;
                        $user_appName='הממנה';
                        echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                        echo $this->td1("", ""), $this->td2asis("&nbsp;", "");
                        if($rows_usr[0]->forum_decID){

                            $this->td_dec_mem ($user_appName,$name, "find3.php?userID=$user",$mor_forum);


                            foreach ($rows_usr as $usr){
                                echo '<tr>';
                                echo '<td><span class="td5head"> חבר פורום: </span> ';
                                $this->td_url ($usr->forum_decName, "find3.php?forum_decID=$usr->forum_decID");
                                echo '</tr>';
                            }
                        }
                    }
                }



                /****************************MANAGER/APPOINT+APPOINT/MANAGER**************************************************/
                if($_GET['managerID'] && $_GET['managerID']!='none' || ($_POST['form']['manager_forum'] && $_POST['form']['manager_forum']!='none'
                        && is_numeric ($_POST['form']['manager_forum']))  ){
                    /************************************************************************************************************/

                    $manager_id=$_GET['managerID'] ?$_GET['managerID'] :$_POST['form']['manager_forum'] ;

                    $manager_id=$db->sql_string($manager_id);
                    $sql2 =" select a.appointID,a.appointName from appoint_forum a  WHERE a.userID=
 	         (select m.userID from managers m where m.managerID=$manager_id)  " ;
                    if($rows=$db->queryObjectArray($sql2) ){
                        $appointname= $rows[0]->appointName ;
                        $appoint=$rows[0]->appointID;

                        $sql2 = "    select forum_decName,forum_decID from forum_dec f          
                 WHERE f.forum_decID in 
                 (select f.forum_decID from forum_dec f) 
                  AND f.appointID=(select a.appointID from appoint_forum a  WHERE a.appointID=$appoint)";

                        if($rows_mgrFrm=$db->queryObjectArray($sql2)  ){

                            echo $this->td1("", ""), $this->td2asis("&nbsp;", "");



                            $mor_app="ממנה גם בפורום/ים";


                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                            echo $this->td1("", ""), $this->td2asis("&nbsp;", "");

                            $this->td_dec_mem ($mem_job,$appointname, "find3.php?appointID=$appoint",$mor_app);


                            foreach ($rows_mgrFrm as $row_mgrFrm){

                                echo '<tr>';
                                echo '<td><span class="td5head"> ממנה גם פורום: </span> ';
                                $this->td_url ($row_mgrFrm->forum_decName, "find3.php?forum_decID=$row_mgrFrm->forum_decID");
                                echo '</tr>';

                            }

                            echo $this->td1("", ""), $this->td2asis("&nbsp;", "");
                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                        }

                    }



                    /************************************************************************************************************/
                }elseif( ($_GET['appointID'] && $_GET['appointID']!='none')
                    || ($_POST['form']['appoint_forum'] &&  $_POST['form']['appoint_forum']!='none') ){
                    /************************************************************************************************************/
                    $appoint=$_GET['appointID']?$_GET['appointID']:$_POST['form']['appoint_forum'];


                    $appoint=$db->sql_string($appoint);
                    $sql2 =" select m.managerID,m.managerName from managers m  WHERE m.userID=
 	         (select a.userID from appoint_forum a where a.appointID=$appoint)  " ;
                    if($rows=$db->queryObjectArray($sql2) ){
                        $managername= $rows[0]->managerName ;
                        $manager=$rows[0]->managerID;

                        $sql2 = "    select forum_decName,forum_decID from forum_dec f          
                 WHERE f.forum_decID in 
                 (select f.forum_decID from forum_dec f) 
                  AND f.managerID=(select m.managerID from managers m  WHERE m.managerID=$manager)";

                        if($rows_mgr2Frm=$db->queryObjectArray($sql2)  ){

                            echo $this->td1("החבר $managername מרכז גם בפורום/ים :", "td5head")  ,$this->td2("", "");

                            foreach ($rows_mgr2Frm as $row_usrFrm){
                                echo $this->td3("מרכז גם פורום:");
                                $this->td3url ($row_usrFrm->forum_decName, "find3.php?forum_decID=$row_usrFrm->forum_decID");
                            }
                            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                        }

                    }



                    /*******************************************SEARCH_SPECIFIC_USER*****************************************************************/
                }elseif($_GET['userID'] &&  $_GET['userID']!='none' || $_GET['user'] &&  $_GET['user']!='none'  || $this->userID &&  $this->userID!='none' ){


                    $userID= $_GET['userID'] ?$_GET['userID']:$_GET['user'] ;
                    if(!$userID ){
                        $userID=$this->userID;
                    }
                    /****************************USER_OLSO_AN_APPOINT**************************************************/
                    $sql="select f.appointID,f.forum_decID,f.forum_decName,u.userID ,u.full_name  from forum_dec f
     left join appoint_forum a on f.appointID=a.appointID 
     left join users u on u.userID=a.userID
      where u.userID= $userID " ;
                    $rows_appoint = $db->queryObjectArray($sql);
                    $name=$rows_appoint[0]->full_name;

                    if($rows_appoint[0]->forum_decID){
                        echo $this->td3("החבר $name ממנה גם פורום/ים :", "td5head")  ,$this->td2("", "td1head");

                        foreach ($rows_appoint as $appoint){
                            echo $this->td3("$name ממנה פורום:");

                            $this->td_url ($appoint->forum_decName, "find3.php?forum_decID=$appoint->forum_decID");
                        }
                    }
                    /****************************USER_OLSO_A_MANAGER*************************************************************/

                    $sql="select f.managerID,f.forum_decID,f.forum_decName,u.userID ,u.full_name  from forum_dec f
       left join managers m on f.managerID=m.managerID 
       left join users u on u.userID=m.userID
        where u.userID= $userID ";
                    $rows_mgr = $db->queryObjectArray($sql);
                    $name=$rows_mgr[0]->full_name;

                    if($rows_mgr[0]->forum_decID){
                        echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                        echo $this->td1("החבר $name מרכז/ת גם פורום/ים :", "td5head")  ,$this->td2("", "td3head");

                        echo $this->td1("", "td3head"),$this->td2("", "td3head");
                        foreach ($rows_mgr as $mgr){
                            echo $this->td3("$name מרכז/ת פורום:");

                            $this->td_url ($mgr->forum_decName, "find3.php?forum_decID=$mgr->forum_decID");

                        }
                    }
                    /**************************************HAVE DECISION IN THE PAST OR PRESENT*****************************/
                    /**************************DECISIONS**********************************************************/

                    $sql_dec = " SELECT ud.*,DATE_FORMAT(ud.HireDate,' %M  %e %Y ') AS format_hire_date 
			,u.full_name,u.fname,u.lname,u.level,f.forum_decName,f.forum_decID,d.decID,COUNT(*),DATE_FORMAT(d.dec_date,'%e  %M  %Y') AS dec_date, 
			IF(CHAR_LENGTH(d.decName)>14, CONCAT(LEFT(d.decName,7), ' ... ', RIGHT(d.decName, 7)), d.decName) AS decName  FROM rel_user_Decforum ud				 
			INNER JOIN users u ON(ud.userID=u.userID)
			INNER JOIN forum_dec f ON(f.forum_decID=ud.forum_decID) 
			INNER JOIN decisions d ON(d.decID=ud.decID) 
			WHERE ud.userID=$userID
			GROUP BY ud.decID 
			ORDER BY d.dec_date,f.forum_decName ";


                    /************************************************/
                    if($rows_dec = $db->queryObjectArray($sql_dec) ) {
                        /***********************************************/




                        echo $this->td8("החלטות שהחבר שותף להם בפורומים בעבר ובהווה: ", "td5head");

                        echo '<tr>';
                        echo '<td   class="myformtd">';
                        ?>

                        <input type=hidden name="my_Dec_user_frm<?php echo $i;?>" id="my_Dec_user_frm<?php echo $i;?>" value="<?php echo $i;?>" />
                        <!--  <input type=hidden name="count" id="count" value="<?php echo $count_forum;?>" />   -->
                        <h5 class="my_Dec_user<?php echo $i;?>" style=" height:15px"></h5>
                        <h6 class="my_Dec_user_2<?php echo $i;?>" style=" height:15px"></h6>
                    <div id="my_Dec_user_frm_content<?php echo $i;?>"  >
                    <div id="my_Dec_user_frm_content_2<?php echo $i;?>"  >
                    <table id="my_Dec_user_frm_tbl<?php echo $i;?>" class="resulttable">

                        <?php

                        /**********************************************/
                        foreach($rows_dec as $row_dec){
                            /*********************************************/
                            $row_dec->dec_date=substr($row_dec->dec_date,0,22);
                            $dec_date=$row_dec->dec_date;

                            $dec_date=" (תאריך קבלת ההחלטה)$dec_date   ";

                            if($userID && $userID !='none'){
                                $sendTask_sql="SELECT  DISTINCT  t.*  ,u.userID,u.full_name,rt.userID,rt.dest_userID FROM todolist t
                                  
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 

			            		  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID

			            		  left JOIN users u
			            		  ON u.userID=rt.userID 

			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$row_dec->decID 
                                  AND rt.userID=$userID 
                                  AND t.forum_decID=$row_dec->forum_decID 
                                  ORDER BY t.taskID DESC";



                                $getTask  = $db->queryObjectArray($sendTask_sql);





                                $getTask_sql="SELECT   DISTINCT t.*  , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  
                                  LEFT JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  
			            		  LEFT JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  
			            		  LEFT JOIN users u
			            		  ON u.userID=rt.userID 

			            		  LEFT JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  WHERE t.compl IN(0,1)
                     			 
                                  AND t.decID=$row_dec->decID 
                                  AND rt.dest_userID=$userID 
                                  AND t.forum_decID=$row_dec->forum_decID 
                                   ORDER BY t.taskID DESC";




                                $getTaskForMe  = $db->queryObjectArray($getTask_sql);
                            }
                            $decID=$row_dec->decID;
                            $forum_decID=$row_dec->forum_decID;
                            $forum_decName=$row_dec->forum_decName;
                            $flag=false;
                            if( !$getTask && !$getTaskForMe && $row_dec->decID){




                                echo $this->td3("החלטה:");
                                echo $this->td_url2link($row_dec->decName,$row_dec->forum_decName, "find3.php?decID=$row_dec->decID", "find3.php?forum_decID=$row_dec->forum_decID",$dec_date);
                            }

                            if($getTask){

                                /*******************************build the form task that i wrote****************************/

                                echo $this->td7("");

                                task_server($decID,$forum_decID,$this->userID);

                                echo $this->td3url($row_dec->decName, "find3.php?decID=$row_dec->decID");
                                echo $this->td_color1("שלחתי משימות", "my_task"), $this->td2asis("&nbsp;", "tdinvisible");

                            }
                            if( $getTaskForMe 	){

                                /************************************** build the form of task have been wreeten for me*******************************/
                                echo $this->td7("");
                                $flag=true;
                                task_server($decID,$forum_decID,$this->userID,$flag);
                                echo $this->td3url($row_dec->decName, "find3.php?decID=$row_dec->decID");
                                echo $this->td_color1("שלחו לי משימות", "my_task"), $this->td2asis("&nbsp;", "tdinvisible");

                            }


                        }//end foreach


                        echo $this->td1("", ""), $this->td2asis("&nbsp;", "");
                        echo '</table></div></div></td></tr>';

                        echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                    }//end if $rows

                }//end  specific user

                /******************************************CATEGORIES******************************************************************/

                $arr_forum="";
                for($idx=0;$idx<count($forums);$idx++){
                    if($forums[$idx]->forum_decID==$row->forum_decID){
                        $arr_forum[$idx]=$forums[$idx];
                    }

                }


                $this->set_category($arr_forum);
                /**************************************SUB_FORUM************************************/
                $child_forumid=$row->forum_decID;
                $sql="select distinct forum_decID,parentForumID,managerID,forum_decName from forum_dec where forum_decID=$child_forumid";
                $rows5=$db->queryObjectArray($sql);

                if($rows5[0]->parentForumID!=11 && $rows5[0]->parentForumID){
                    echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
                    $forumid=$rows5[0]->parentForumID;
                    $find_forumName="select forum_decName from forum_dec where forum_decID=$forumid";
                    $fname=$db->queryObjectArray($find_forumName);

                    echo '<tr>';
                    echo '<td><span class="td5head"> מקושר לפורום: </span> ';
                    $this->td_url ($fname[0]->forum_decName, "find3.php?forum_decID=$forumid");
                    echo '</tr>';

                }
                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                /*******************************************forum_date*******************************************************************/
                if(!$row->forum_date){
                    $sql="select forum_date from forum_dec where forum_decID=$row->forum_decID";
                    if($frm_date=$db->queryObjectArray($sql))
                        $row->forum_date=$frm_date[0]->forum_date;
                }

                if($row->forum_date){
                    list($year_date,$month_date, $day_date) = explode('-',$row->forum_date);
                    $day_date = is_null($day_date) ? 'NULL' : "'$day_date'" ;


                    $day_date=substr($day_date, 0,4);
                    $day_date=substr($day_date,1,2);
                    $forum_date="$day_date-$month_date-$year_date";
                    //echo $this->td1_d("תאריך הקמת הפורום:",$forum_date,"td5head");// $this->td2_b($forum_date, "td1head");



                    echo '<tr>';
                    echo '<td><span class="td5head">תאריך הקמת הפורום: </span> ';
                    echo "<b style='color:blue;'>$forum_date</b></td><td class='href_modal1' ></td></tr>\n" ;
                    echo '</tr>';




                }

                // echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "");
                echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
                /***********************************************************************************/


                echo "</table></td></tr>\n";
                // echo "</li>\n";
                //        echo "</table></li>\n";
                $i++;

            }//end if $id!=11
        }//end foreach
//echo "</ol></td></tr></table></div></fieldset>\n";
        //echo "</div></table></div></fieldset>\n";
//echo "</td></tr></table></div></fieldset>\n";
// echo "</tr></td>";
//echo "</table>";
    }

    /**************************************************************************************************************/
    function appoint_history(){
        /*****************************HISTORY_MANAGER_DATA*****************************************************************************/

        echo '<div>';

        echo '<h5 class="my_appoint_find_history" style=" height:15px"></h5>';
        echo '<h6 class="my_appoint_find_history_2" style=" height:15px"></h6>';
        echo '<div id="appoint_history_content" class="history_content" >';
        echo '<div id="appoint_history_content_2" class="history_content" >';
        echo '<table class="resulttable">';
        echo '<tr>';
        echo '<td   class="myformtd">';

        global $db;

        $id=$_GET['appointID'] ? $_GET['appointID']:$appointID;

        if(!$id)
            $id=$_POST['form']['appoint_forum'];


        $sql="select ah.appointID,f.forum_decID,f.forum_decName,a.appointName,
          DATE_FORMAT(ah.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(ah.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(ah.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(ah.end_date,'%Y-%m-%d') as end_date1
           from appoint_forum_history ah,forum_dec f,appoint_forum a
          where ah.appointID=a.appointID
          and   ah.forum_decID=f.forum_decID
         and ah.appointID=$id";

        if($rows8=$db->queryObjectArray($sql)){

            echo '<input type=hidden name="appoint_history_hidden_app" id="appoint_history_hidden_app" value="appoint_history_hidden_app">';
            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
            echo $this->td1("היסטוריית ממנה הפורום:", "td5head"),$this->td2( $rows8[0]->appointName ,  "td3head");
            echo $this->td1("", "tdinvisible4"),$this->td2("", "");



            foreach($rows8 as $row){
                echo $this->td3("$row->appointName היה ממנה בפורום:");
                $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");

                echo $this->td1_d("בין התאריך:",$row->start_date, "td5head");
                echo $this->td1_d("לבין התאריך:",$row->end_date, "td5head");



                $start_date1 = $row->start_date1 ;
                $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                $end_date1 = $row->end_date1 ;
                $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                if($rows8=$db->queryObjectArray($sql3)){

                    echo $this->td1("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                    foreach($rows8 as $row1){
                        echo $this->td3("החלטה:");
                        echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                        echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");

                    }
                }
                echo $this->td1("", "tdinvisible4"),$this->td2("", "");
            }

        }
        /***********************************************************************************************************************************/
        /*****************************HISTORY_APPOINT_MANAGER_DATA*****************************************************************************/


        $sql2 =" select m.managerID,m.managerName from managers m  WHERE m.userID=
 	         (select a.userID from appoint_forum a where a.appointID=$id)  " ;
        if($rows=$db->queryObjectArray($sql2) ){

            $managername= $rows[0]->managerName ;
            $manager_id=$rows[0]->managerID;

            // $id=$_GET['managerID'] ? $_GET['managerID']:$row->managerID;
            $sql="select mh.managerID,f.forum_decID,f.forum_decName,m.managerName,
          DATE_FORMAT(mh.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(mh.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(mh.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(mh.end_date,'%Y-%m-%d') as end_date1
          from manager_forum_history mh,forum_dec f,managers m
          where mh.managerID=m.managerID
          and   mh.forum_decID=f.forum_decID
          and mh.managerID=$manager_id";

            if($rows7=$db->queryObjectArray($sql)){

                echo '<input type=hidden name="appoint_history_hidden_mgr" id="appoint_history_hidden_mgr" value="appoint_history_hidden_mgr">';


                echo $this->td1("", "tdinvisible3"),$this->td2("", "tdinvisible3");
                echo $this->td1("היסטוריית מנהל הפורום:", "td5head"),$this->td2( $rows7[0]->managerName ,  "td3head");
                echo $this->td3("", "tdinvisible4"),$this->td2("", "tdinvisible4");
                echo $this->td3("", "tdinvisible3"),$this->td2("", "tdinvisible3");
                foreach($rows7 as $row){
                    echo $this->td3("$row->managerName היה מנהל בפורום:");


                    $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");

                    echo $this->td1_a("בין התאריך:", "td2head"), $this->td2_a($row->start_date, "td2head");
                    echo $this->td1_a("לבין התאריך:", "td2head"), $this->td2_a	($row->end_date, "td1head");

                    echo $this->td3("", "tdinvisible4"),$this->td2("", "tdinvisible4");
                    echo $this->td3("", "tdinvisible3"),$this->td2("", "tdinvisible3");

                    $start_date1 = $row->start_date1 ;
                    $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                    $end_date1 = $row->end_date1 ;
                    $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                    $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                    if($rows7=$db->queryObjectArray($sql3)){

                        echo $this->td1("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                        foreach($rows7 as $row1){
                            echo $this->td3("החלטה:");
                            echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");

                        }
                    }
                    echo $this->td1("", "tdinvisible3"),$this->td2("", "tdinvisible3");

                }

            }


        }
        /*****************************HISTORY_APPOINT_USER_DATA*****************************************************************************/
//$id=$_GET['appointID'] ? $_GET['appointID']:$appointID;

        $sql="select appointName, userID from appoint_forum where appointID=$id";
        if($rows=$db->queryObjectArray($sql)){

            $usrID=$rows[0]->userID;
            $usrName=$rows[0]->appointName;



            $sql="select r.userID,r.forum_decID,u.full_name,f.forum_decName,
          DATE_FORMAT(r.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(r.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(r.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(r.end_date,'%Y-%m-%d') as end_date1
          from rel_user_forum_history r,users u,forum_dec f
                                    where r.userID=u.userID
                                    and   r.forum_decID=f.forum_decID
                                    and r.userID=$usrID";

            if($rows6=$db->queryObjectArray($sql)){

                echo '<input type=hidden name="appoint_history_hidden_usr" id="appoint_history_hidden_usr" value="appoint_history_hidden_usr">';


                echo $this->td1("היסטוריית חבר הפורום:", "td5head"),$this->td2( $rows6[0]->full_name ,  "td3head");
                echo $this->td1("", "tdinvisible4"),$this->td2("", "tdinvisible4");
                echo $this->td1("", "tdinvisible3"),$this->td2("", "tdinvisible3");



                foreach($rows6 as $row){
                    echo $this->td5("$row->full_name היה חבר בפורום:");// ,$this->td1("", "");
                    $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");

                    echo $this->td1_a("בין התאריך:", "td2head"), $this->td2_a($row->start_date, "td2head");
                    echo $this->td1_a("לבין התאריך:", "td2head"), $this->td2_a	($row->end_date, "td2head");



                    $start_date1 = $row->start_date1 ;
                    $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                    $end_date1 = $row->end_date1 ;
                    $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                    $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                    if($rows7=$db->queryObjectArray($sql3)){

                        echo $this->td1("החלטות בפורום באותה תקופה:", "td3head"),$this->td2("", "td3head");
                        foreach($rows7 as $row1){
                            echo $this->td3("החלטה:");
                            echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                            echo $this->td1("", "tdinvisible");

                        }
                    }
                    echo $this->td1("", "tdinvisible4"),$this->td2("", "tdinvisible4");
                }

            }//end if rows6
            echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");
        }
// echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "");
        echo "</td></tr></table></div></div></div>\n"  ;
    }
    /*****************************HISTORY_MANAGER_DATA*****************************************************************************/
    function manager_history(){

        echo '<div>';
        echo '<h5 class="my_mgr_find_history" style=" height:15px"></h5>';
        echo '<h6 class="my_mgr_find_history_2" style=" height:15px"></h6>';
        echo '<div id="mgr_history_content" class="history_content" >';
        echo '<div id="mgr_history_content_2" class="history_content" >';
        echo '<table class="resulttable">';
        echo '<tr>';
        echo '<td   class="myformtd">';
        global $db;
        $id=$_GET['managerID'] ? $_GET['managerID']:$row->managerID;
        /*********************************MANAGER_APPOINT_HISTORY**********************************************************************/
        if(!$id)
            $id=$_POST['form']['manager_forum'];
        if($id){
            $sql =" select a.appointID,a.appointName from appoint_forum  a  WHERE a.userID=
 	         (select m.userID from managers m where m.managerID=$id)  " ;
            if($rows=$db->queryObjectArray($sql) ){
                $appID=$rows[0]->appointID;


                $sql="select ah.appointID,f.forum_decID,f.forum_decName,a.appointName,
          DATE_FORMAT(ah.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(ah.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(ah.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(ah.end_date,'%Y-%m-%d') as end_date1
           from appoint_forum_history ah,forum_dec f,appoint_forum a
          where ah.appointID=a.appointID
          and   ah.forum_decID=f.forum_decID
         and ah.appointID=$appID";

                if($rows8=$db->queryObjectArray($sql)){

                    echo '<input type=hidden name="manager_history_hidden_app" id="manager_history_hidden_app" value="manager_history_hidden_app">';




                    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                    echo $this->td1("היסטוריית ממנה הפורום:", "td5head"),$this->td2( $rows8[0]->appointName ,  "td3head");
                    echo $this->td1("", "tdinvisible4"),$this->td2("", "");


                    foreach($rows8 as $row){
                        echo $this->td3("$row->appointName היה ממנה בפורום:");// ,$this->td1("", "");
                        $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");

                        echo $this->td1_d("בין התאריך:",$row->start_date, "td5head");
                        echo $this->td1_d("לבין התאריך:",$row->end_date, "td5head");



                        $start_date1 = $row->start_date1 ;
                        $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                        $end_date1 = $row->end_date1 ;
                        $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                        $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                        if($rows8=$db->queryObjectArray($sql3)){

                            echo $this->td1("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                            foreach($rows8 as $row1){
                                echo $this->td3("החלטה:");
                                echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                                echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
                            }
                        }
                        echo $this->td1("", "tdinvisible4"),$this->td2("", "");
                    }

                }
            }
            /*************************************HISTORY_MANAGER_DATA***************************************************************************************/

            $sql="select mh.managerID,f.forum_decID,f.forum_decName,m.managerName,
          DATE_FORMAT(mh.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(mh.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(mh.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(mh.end_date,'%Y-%m-%d') as end_date1
          from manager_forum_history mh,forum_dec f,managers m
          where mh.managerID=m.managerID
          and   mh.forum_decID=f.forum_decID
          and mh.managerID=$id";

            if($rows7=$db->queryObjectArray($sql)){

                echo '<input type=hidden name="manager_history_hidden_mgr" id="manager_history_hidden_mgr" value="manager_history_hidden_mgr" >';


                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                echo $this->td1("היסטוריית מנהל הפורום:", "td5head"),$this->td2( $rows7[0]->managerName ,  "td3head");
                echo $this->td1("", "tdinvisible4"),$this->td2("", "");
                foreach($rows7 as $row){
                    echo $this->td3("$row->managerName היה מנהל בפורום:");


                    $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");


                    echo $this->td1_d("בין התאריך:",$row->start_date, "td5head");
                    echo $this->td1_d("לבין התאריך:",$row->end_date, "td5head");


                    $start_date1 = $row->start_date1 ;
                    $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                    $end_date1 = $row->end_date1 ;
                    $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                    $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                    if($rows7=$db->queryObjectArray($sql3)){

                        echo $this->td6("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                        foreach($rows7 as $row1){
                            echo $this->td3("החלטה:");
                            echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                            echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
                        }
                    }
                    echo $this->td1("", "tdinvisible4"),$this->td2("", "");

                }

            }
            /*****************************HISTORY_MANAGER_USER_DATA*************************************************************/


            $sql="select managerName, userID from managers where managerID=$id";
            if($rows=$db->queryObjectArray($sql)){

                $usrID=$rows[0]->userID;
                $usrName=$rows[0]->appointName;



                $sql="select r.userID,r.forum_decID,u.full_name,f.forum_decName,
          DATE_FORMAT(r.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(r.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(r.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(r.end_date,'%Y-%m-%d') as end_date1
          from rel_user_forum_history r,users u,forum_dec f
                                    where r.userID=u.userID
                                    and   r.forum_decID=f.forum_decID
                                    and r.userID=$usrID";

                if($rows6=$db->queryObjectArray($sql)){

                    echo '<input type=hidden name="manager_history_hidden_usr" id="manager_history_hidden_usr" value="manager_history_hidden_usr">';

                    echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                    echo $this->td1("היסטוריית חבר הפורום:", "td5head"),$this->td2( $rows6[0]->full_name ,  "td3head");
                    echo $this->td1("", "tdinvisible4"),$this->td2("", "");
                    foreach($rows6 as $row){
                        echo $this->td3("$row->full_name היה חבר בפורום:");// ,$this->td1("", "");
                        $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");

                        echo $this->td1_d("בין התאריך:",$row->start_date, "td5head");
                        echo $this->td1_d("לבין התאריך:",$row->end_date, "td5head");




                        $start_date1 = $row->start_date1 ;
                        $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                        $end_date1 = $row->end_date1 ;
                        $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                        $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                        if($rows7=$db->queryObjectArray($sql3)){

                            echo $this->td1("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                            foreach($rows7 as $row1){
                                echo $this->td3("החלטה:");
                                echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                                echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");
                            }
                        }
                        echo $this->td1("", "tdinvisible4"),$this->td2("", "");
                    }

                }
            }


        }

        echo "</td></tr></table></div></div></div>\n"  ;

        /*********************************/
    }
    /*****************************HISTORY_USER_DATA*****************************************************************************/
    function user_history(){
        /**************************************************************************************************************************/

        echo '<div>';

        echo '<h5 class="my_user_find_history" style=" height:15px"></h5>';
        echo '<h6 class="my_user_find_history_2" style=" height:15px"></h6>';
        echo '<div id="user_history_content" class="history_content" >';
        echo '<div id="user_history_content_2" class="history_content" >';

        echo '<table class="resulttable">';
        echo '<tr>';
        echo '<td   class="myformtd">';

        global $db;

        $id=$_GET['userID'] ? $_GET['userID']:$userID;

        if(!$id)
            $id=$this->userID;

        /***********************************USER_APPOINT_HISTORY***************************************************************************/
        $sql="select appointName, appointID from appoint_forum where userID=$id";
        if($rows=$db->queryObjectArray($sql)){

            $appID=$rows[0]->appointID;
            $appName=$rows[0]->appointName;
            $sql="select ah.appointID,f.forum_decID,f.forum_decName,a.appointName,
          DATE_FORMAT(ah.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(ah.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(ah.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(ah.end_date,'%Y-%m-%d') as end_date1
           from appoint_forum_history ah,forum_dec f,appoint_forum a
          where ah.appointID=a.appointID
          and   ah.forum_decID=f.forum_decID
         and ah.appointID=$appID";

            if($rows8=$db->queryObjectArray($sql)){

                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                echo $this->td1("היסטוריית ממנה הפורום:", "td5head"),$this->td2( $rows8[0]->appointName ,  "td3head");
                echo $this->td1("", "tdinvisible4"),$this->td2("", "");
                foreach($rows8 as $row){

                    echo '<input type=hidden name="user_history_hidden_app" id="user_history_hidden_app" value="user_history_hidden_app">';


                    echo $this->td3("$row->appointName היה ממנה בפורום:");


                    $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");


                    echo $this->td1_d("בין התאריך:",$row->start_date, "td5head");
                    echo $this->td1_d("לבין התאריך:",$row->end_date, "td5head");


                    $start_date1 = $row->start_date1 ;
                    $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                    $end_date1 = $row->end_date1 ;
                    $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                    $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                    if($rows8=$db->queryObjectArray($sql3)){

                        echo $this->td6("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                        if($rows7){
                            foreach($rows7 as $row1){
                                echo $this->td3("החלטה:");
                                echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                                echo $this->td1("", "tdinvisible");

                            }
                        }
                    }
                    echo $this->td1("", "tdinvisible4"),$this->td2("", "");
                }

            }

        }
        /*****************************HISTORY_USER_MANAGER_DATA*****************************************************************************/

        $sql="select managerName, managerID from managers where userID=$id";
        if($rows=$db->queryObjectArray($sql)){

            $mngID=$rows[0]->managerID;
            $mngName=$rows[0]->managerName;


            $id=$_GET['managerID'] ? $_GET['managerID']:$row->managerID;
            $sql="select mh.managerID,f.forum_decID,f.forum_decName,m.managerName,
          DATE_FORMAT(mh.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(mh.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(mh.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(mh.end_date,'%Y-%m-%d') as end_date1
          from manager_forum_history mh,forum_dec f,managers m
          where mh.managerID=m.managerID
          and   mh.forum_decID=f.forum_decID
          and mh.managerID=$mngID";

            if($rows7=$db->queryObjectArray($sql)){

                echo '<input type=hidden name="user_history_hidden_mgr" id="user_history_hidden_mgr" value="user_history_hidden_mgr">';


                echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
                echo $this->td1("היסטוריית מנהל הפורום:", "td5head"),$this->td2( $rows7[0]->managerName ,  "td3head");
                echo $this->td1("", "tdinvisible4"),$this->td2("", "");

                foreach($rows7 as $row){
                    echo $this->td3("$row->managerName היה מנהל בפורום:");


                    $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");

                    echo $this->td1_d("בין התאריך:",$row->start_date, "td5head");
                    echo $this->td1_d("לבין התאריך:",$row->end_date, "td5head");



                    $start_date1 = $row->start_date1 ;
                    $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                    $end_date1 = $row->end_date1 ;
                    $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                    $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                    if($rows7=$db->queryObjectArray($sql3)){

                        echo $this->td6("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                        foreach($rows7 as $row1){
                            echo $this->td3("החלטה:");
                            echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                            echo $this->td1("", "tdinvisible");
                        }
                    }
                    echo $this->td1("", "tdinvisible4"),$this->td2("", "");

                }
                // echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");

            }

//  echo $this->td1("", "tdinvisible3"),$this->td2("", "tdinvisible3");




        }
        /*****************************HISTORY_USER_DATA************************************************/
        $id=$_GET['userID'] ? $_GET['userID']:$userID;

        if(!$id)
            $id=$this->userID;

        $sql="select r.userID,r.forum_decID,u.full_name,f.forum_decName,
          DATE_FORMAT(r.start_date, '%T  %d-%m-%Y') AS start_date ,DATE_FORMAT(r.start_date, '%Y-%m-%d') AS start_date1 ,
          DATE_FORMAT(r.end_date, '%T  %d-%m-%Y') as end_date ,DATE_FORMAT(r.end_date,'%Y-%m-%d') as end_date1
          from rel_user_forum_history r,users u,forum_dec f
                                    where r.userID=u.userID
                                    and   r.forum_decID=f.forum_decID
                                    and r.userID=$id";

        if($rows6=$db->queryObjectArray($sql)){

            echo '<input type=hidden name="user_history_hidden_usr" id="user_history_hidden_usr" value="user_history_hidden_usr">';


            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
            echo $this->td1("היסטוריית חבר הפורום:", "td5head"),$this->td2( $rows6[0]->full_name ,  "td3head");
            echo $this->td1("", "tdinvisible4"),$this->td2("", "");

            foreach($rows6 as $row){
                echo $this->td3("$row->full_name היה חבר בפורום:");// ,$this->td1("", "");
                $this->td3url ($row->forum_decName, "find3.php?forum_decID=$row->forum_decID");




                echo $this->td1_d("בין התאריך:",$row->start_date, "td5head");
                echo $this->td1_d("לבין התאריך:",$row->end_date, "td5head");






                $start_date1 = $row->start_date1 ;
                $start_date1 = is_null($start_date1) ? 'NULL' : "'$start_date1'" ;
                $end_date1 = $row->end_date1 ;
                $end_date1 = is_null($end_date1) ? 'NULL' : "'$end_date1'" ;
                $sql3 = "SELECT d.decName,r.decID, r.forum_decID
				FROM decisions d, rel_forum_dec r
				WHERE d.decID = r.decID
				AND r.forum_decID=$row->forum_decID 
				AND  d.dec_date between $start_date1 and $end_date1
				ORDER BY  d.decName";
                if($rows7=$db->queryObjectArray($sql3)){

                    echo $this->td1("החלטות בפורום באותה תקופה:", "td2head"),$this->td2("", "td2head");
                    foreach($rows7 as $row1){
                        echo $this->td3("החלטה:");
                        echo $this->td3url($row1->decName, "find3.php?decID=$row1->decID");
                        echo $this->td1("", "tdinvisible"),$this->td2("", "tdinvisible");

                    }

                }
                echo $this->td1("", "tdinvisible4"),$this->td2("", "");

            }
            echo $this->td1("", "tdinvisible"), $this->td2asis("&nbsp;", "tdinvisible");
            echo $this->td1("", "tdinvisible1"), $this->td2asis("&nbsp;", "tdinvisible1");

        }
//          echo "</table></tr></td></div></div></div>\n"  ;
        echo "</td></tr></table></div></div></div>\n"  ;
    }
    /*****************************************************************/













    /**************************************************************/
}//end class find

/**************************************************************/


?>