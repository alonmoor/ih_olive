<?php
require_once ("../config/application.php");
require_once ("../lib/model/DBobject3.php");
require_once(LIB_DIR.'/model/class.handler.php');
require_once (LIB_DIR.'/model/dbtreeview.php');
require_once HTML_DIR.'/edit_brand.php';
require_once (ADMIN_DIR.'/ajax2.php');


class Brand extends DBObject3{

private $table;
private $fields = array();

protected $brandID;
protected $brandName;
protected $numPage;
protected $catID;
protected $pdfID;
protected $status;
protected $active;
protected $deleted_dt;
protected $created_dt;
protected $parentCatID;
protected $brand_date;
protected $brand_allowed;

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
    parent::__construct('brand', 'brandID', array('brandName', 'pdfID', 'appointID', 'numPage', 'status', 'deleted_dt', 'created_dt', 'brand_date', 'brand_allowed'),$id,$formdata);
}

function load_from_db($formdata) {
    global $db;

    //$sql = "SELECT * FROM users where userID = ".$this->getId();
    $sql = "SELECT * FROM brands where brandID =$this->id";

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
//		$brandID=$formdata["forum_decision"];
//			$sql = "SELECT forum_decName  FROM forum_dec WHERE forum_decID = " .
//				$db->sql_string($$brandID);
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
public function setId($brandID) {
    $this->forum_decID = $brandID;
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
function __construct1($brandID = false)
{
    if(!$brandID) {
        return;
    }
    global $db;
    $query = "SELECT *
		FROM forum_dec
		WHERE $brandID =$brandID";
    $result =$db->getMysqli()->query($query);
    while ($data = $result->fetch_array(MYSQLI_ASSOC))
    {
        $this->$brandID = $formdata['$brandID'];
        $this->forum_decName = $formdata['forum_decName'];
        $this->forum_time = $formdata['forum_time'];

    }
}
//-------------------------------------------------------------------------------------
function save_publisher(&$formdata)
{
    global $db;
//        if ($formdata['dest_publishers'] == 'none' && !array_item($formdata, "dest_publishers")) {
    if (!array_item($formdata, "dest_publishers")) {
        unset ($formdata['dest_publishers']);
        $tmp = "";
    } elseif (($formdata['dest_publishers'] != 'none' && $formdata['dest_publishers'] != null
            && (array_item($formdata, "dest_publishers") && is_array(array_item($formdata, "dest_publishers"))))
        && (!array_item($formdata, "new_forum")
            || ($formdata["new_forum"] == 'none')
            || $formdata["new_forum"] == null)
    ) {
        $tmp = $formdata["dest_publishers"] ? $formdata["dest_publishers"] : $formdata["new_forum"];
        $dest_publishers = $formdata['dest_publishers'];
        foreach ($dest_publishers as $key => $val) {
            if (!is_numeric($val)) {
                $val = $db->sql_string($val);
                $staff_test[] = $val;
            } elseif (is_numeric($val)) {
                $staff_testb[] = $val;
            }
        }
        if (isset($staff_test) && is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
            $staff = implode(',', $staff_test);
            $sql2 = "select brandID, brandName from brand where brandName in ($staff)";
            if ($rows = $db->queryObjectArray($sql2))
                foreach ($rows as $row) {
                    $name[$row->brandID] = $row->brandName;
                }
        } elseif (isset($staff_test) && is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
            $staff = implode(',', $staff_test);
            $sql2 = "select brandID, brandName from brand where brandName in ($staff)";
            if ($rows = $db->queryObjectArray($sql2))
                foreach ($rows as $row) {
                    $name[$row->brandID] = $row->brandName;
                }
            $staffb = implode(',', $staff_testb);
            $sql2 = "select brandID, brandName from brand where brandID in ($staffb)";
            if ($rows = $db->queryObjectArray($sql2))
                foreach ($rows as $row) {
                    $name_b[$row->brandID] = $row->brandName;
                }
            $name = array_merge($name, $name_b);
            unset($staff_testb);
        }
        foreach ($formdata['dest_publishers'] as $row) {
            $publishersIDs [] = $row;
        }
    }
    return isset($publishersIDs) ? $publishersIDs : false;
}

//-------------------------------------------------------------------------------------
function save_pdf(&$formdata)
{
    global $db;
//        if ($formdata['dest_publishers'] == 'none' && !array_item($formdata, "dest_publishers")) {
    if (!array_item($formdata, "dest_pdfs")) {
        unset ($formdata['dest_pdfs']);
        $tmp = "";
    } elseif (($formdata['dest_pdfs'] != 'none' && $formdata['dest_pdfs'] != null
            && (array_item($formdata, "dest_pdfs") && is_array(array_item($formdata, "dest_pdfs"))))
        && (!array_item($formdata, "new_forum")
            || ($formdata["new_forum"] == 'none')
            || $formdata["new_forum"] == null)
    ) {
        $tmp = $formdata["dest_pdfs"] ? $formdata["dest_pdfs"] : $formdata["new_pdf"];
        $dest_pdfs = $formdata['dest_pdfs'];
        foreach ($dest_pdfs as $key => $val) {
            if (!is_numeric($val)) {
                $val = $db->sql_string($val);
                $staff_test[] = $val;
            } elseif (is_numeric($val)) {
                $staff_testb[] = $val;
            }
        }
        if (isset($staff_test) && is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
            $staff = implode(',', $staff_test);
            $sql2 = "select pdfID, pdfName from pdfs where pdfID in ($staff)";
            if ($rows = $db->queryObjectArray($sql2))
                foreach ($rows as $row) {
                    $name[$row->brandID] = $row->brandName;
                }
        } elseif (isset($staff_test) && is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
            $staff = implode(',', $staff_test);
            $sql2 = "select pdfID, pdfName from pdfs where pdfID in ($staff)";
            if ($rows = $db->queryObjectArray($sql2))
                foreach ($rows as $row) {
                    $name[$row->brandID] = $row->brandName;
                }
            $staffb = implode(',', $staff_testb);
            $sql2 = "select pdfID, pdfName from pdfs where pdfID in ($staffb)";
            if ($rows = $db->queryObjectArray($sql2))
                foreach ($rows as $row) {
                    $name_b[$row->brandID] = $row->brandName;
                }
            $name = array_merge($name, $name_b);
            unset($staff_testb);
        }
        foreach ($formdata['dest_pdfs'] as $row) {
            $pdfsIDs [] = $row;
        }
    }
    return isset($pdfsIDs) ? $pdfsIDs : false;
}


//----------------------------------------------------BRANDS-------------------------------------------------------------------------
function save_brand(&$formdata)
{
    global $db;
    if (isset($formdata['brand_select'][0]) && $formdata['brand_select'][0]) {
        $id = $formdata['brand_select'][0];
        $sql = "select brandID, brandName from brands where brandID in ($id)";
        if ($rows = $db->queryObjectArray($sql))
            foreach ($rows as $row) {
                $brandIDS[$row->brandID] = $row->brandName;
            }
        return $brandIDS;
    } else {
        return false;
    }
}

//-----------------------------------------------------------------------------------------------------------------------------
function convertPdfToImg(&$formdata){
 global $db;
$imgArray = $formdata['dest_pdfs'];
if(isset($imgArray) && is_array($imgArray)) {
    $imgNames = Array();
    $newPdfName = '';
    foreach ($imgArray as $id) {
        $query = "select  pdfName from pdfs where pdfID in ($id)";
        if ($rows = $db->queryObjectArray($query)) {
            $imgNames[] = $rows['0']->pdfName;
            $newPdfName = $rows['0']->pdfName;


            $file = '/home/alon/Desktop/PROJECT/4.4.17/' . $newPdfName;
            $file_name = explode('.', $newPdfName);
            $file_name = substr($file_name[0], -9);
            $newfile = CONVERT_PDF_TO_IMG_DIR . '/' . $file_name;
            $im = new imagick('/home/alon/Desktop/PROJECT/4.4.17/' . $newPdfName);

// convert to jpg
            $im->setImageColorspace(255);
            $im->setCompression(Imagick::COMPRESSION_JPEG);
            $im->setCompressionQuality(60);
            $im->setResolution(300, 300);
            $im->setImageFormat('jpeg');
//resize
            $im->resizeImage(290, 375, imagick::FILTER_LANCZOS, 1);
//write image on server
            $im->writeImage($newfile . '.jpg');
            $im->clear();
            $im->destroy();
        }
    }
}
return $imgNames;

}

//----------------------------------------------------------
function message_update_b($formdata,$brandID){

    $url="../admin/find3.php?forum_decID=$brandID";
    $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';

    $url2="../admin/find3.php?forum_decID=$brandID";
    $str2="<span><a onClick=openmypage3('".$url2."');   class=href_modal1  href='javascript:void(0)' >
                  <b style='color:brown;font-size:1.4em;'>$formdata[forum_decName]<b>
                 </a></span>";

    echo '<table style="width:300px;height:25px;overflow:hidden;">
         <tr><td><p  data-module="הפורום:'.$str2.'" >			      
          </p></td></tr>
         </table>';

    return TRUE;
}
//-----------------------------------------------------------------------
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


    if(isset($formdata['dynamic_9']) && $formdata['dynamic_9']==1){
        if(array_item($formdata,'forum_decID') || is_numeric($brandID)){
            $brandID=array_item($formdata,'forum_decID')?array_item($formdata,'forum_decID'):$brandID;
            $formdata["dest_users"]=$formdata["dest_users$brandID"];
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

//    $fields = array( 'year' => 'integer', 'mon' => 'integer','mday' => 'intger','full_date'=>'string');
//
//
//
//    foreach ($fields as $key => $type) {
//        $rows[$key] = $this-> safify($formdata[$key], $type);
//    }
//    $rows['full_date'] = "$rows[year]-$rows[mon]-$rows[mday]";
//    // $rows['full_date'] =$this-> safify($rows['full_date'] , $type);
//
//
//
//
//    return $rows;
}
/**************************************************************************************************/
function redirect($url = null)
{

    if(is_null($url)) $url =$_SERVER['SCRIPT_NAME'];
    header("Location: $url");
    exit();
}

//********************************************************************************************************

function  print_forum_paging($brandID="")
{
    global $db;
    echo "<h1>בחר פורום</h1>\n";
    echo "<p><b style='color:blue;'>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים נוספים בברנד.</b></p>\n";

    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    if ($rows = $db->queryObjectArray($sql)) {
        $parent = array();
        foreach ($rows as $row) {
            $subcats[$row->parentCatID][] = $row->catID;
            $catNames[$row->catID] = $row->catName;
            $parent[$row->catID][] = $row->parentCatID;
        }


//  echo '<tr><td class="myformtable">';
//  echo '<table>';
        echo '<fieldset class="my_pageCount">';
        echo '<ul class="paginated" style=left:100px;  >';
        if (!is_numeric($brandID))
            $this->print_categories_forum_paging($subcats[NULL], $subcats, $catNames, $parent);
        else
            $this->print_categories_forum_paging_link($subcats[NULL], $subcats, $catNames, $parent, $brandID);

        echo '</ul class="paginated"></fieldset>';
//  echo '</table>';
//  echo '</td></tr>';
        echo '<BR><BR>';
    }
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

function print_categories_forum_paging_link($catIDs, $subcats, $catNames,$parent,$brandID) {
    echo '<ul>';
    foreach($catIDs as $catID) {
        $url="../admin/find3.php?forum_decID=$catID";
        $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
        if($catID==11){
            printf("<li><b>%s (%s, %s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"));

        }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){

            printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים",$str));

        }elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
            printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים",$str));
        }else{
            printf("<li><b>%s (%s, %s, %s,%s,%s)</b>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("../admin/dynamic_8.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים",$str));
        }


        if(array_key_exists($catID, $subcats))
            $this->print_categories_forum_paging_link($subcats[$catID], $subcats, $catNames,$parent,$brandID);

    }
    echo "</li></ul>\n";
}
/***********************************************************************************************************/
function  print_forum_paging_b($brandID="") {
    /*************************************************************************************************************/

    global $db;
//  echo "<h1>בחר פורום</h1>\n";
//  echo "<p> <b style='color:blue;'>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים נוספים בפורום.</B></p>\n";

    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    $rows = $db->queryObjectArray($sql);
    $parent=array();
    foreach($rows as $row) {
        $subcats[$row->parentCatID][] = $row->catID;
        $catNames[$row->catID] = $row->catName;
        $parent[$row->catID][] = $row->parentCatID; }
    echo '<fieldset class="my_pageCount"  style="margin-right:32px;">';



    echo '<ul class="paginated" style=left:100px;  >';
    if(!is_numeric($brandID) )
        $this->print_categories_forum_paging_b($subcats[NULL], $subcats, $catNames,$parent);
    else
        $this->print_categories_forum_paging_link_b ($subcats[NULL], $subcats, $catNames,$parent,$brandID);

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

function print_categories_forum_paging_link_b($catIDs, $subcats, $catNames,$parent,$brandID) {
    echo '<ul>';
    foreach($catIDs as $catID) {
        $url="../admin/find3.php?forum_decID=$catID";
        $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 id="'.$catID.'" ';
        if($catID==11){
            printf("<li style='font-weight :bold;'>%s (%s, %s)</li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$catID", "עדכן שם"));

        }elseif($parent[$catID][0]=='11' && !(array_item($subcats,$catID)) ){


            printf("<li class='li_page'  style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)</li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים",$str));
        }elseif($parent[$catID][0]=='11' &&  array_item($subcats,$catID)  ){
            printf("<li class='li_page' style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים",$str));
        }else{
            printf("<li  style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("forum_demo_last8.php","mode=insert","&insertID=$catID&forum_decID=$brandID", "קשר אליי"),
                build_href2("../admin/dynamic_10.php" ,"mode=delete","&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                build_href2("../admin/dynamic_10.php" ,"mode=update","&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_10.php" ,"mode=read_data","&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "forum_decID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים",$str));
        }


        if(array_key_exists($catID, $subcats))
            $this->print_categories_forum_paging_link_b($subcats[$catID], $subcats, $catNames,$parent,$brandID);

    }
    echo "</li></ul>\n";
}

/*******************************************************************************/
function print_forum($brandIDs, $subcats, $forumNames) {
    /**************************************************************************/

    global $db;
    echo "<ul>";
    foreach($brandIDs as $brandID) {
        if($brandID==11){
            printf("<li><b>%s(%s,%s)</b></li>\n",
                htmlspecial_utf8($catNames[$brandID]),
                build_href2("dynamic_8.php","mode=insert","&insertID=$brandID", "הוסף"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$brandID", "עדכן"));
        }else{
            printf("<li><b>%s (%s, %s,  %s, %s, %s )</b></li>\n",

                htmlspecial_utf8($decNames[$brandID]),

                build_href2("dynamic_8.php","mode=insert","&insertID=$brandID", "הוסף"),
                build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$brandID", "מחק","OnClick='return verify();' class='href_modal1'"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$brandID", "עדכן"),
                build_href("find3.php" ,"&forum_decID=$brandID", "נתונים כלליים"),
                build_href2("dynamic_8.php" ,"mode=read_data","&editID=$brandID", "עידכון מורחב"));
        }

        if(array_key_exists($brandID, $subcats))
            $this->print_forum($subcats[$brandID], $subcats, $forumNames);
    }
    echo "</ul>\n";
}
//********************************************************************************************************


function  print_form1($brandID1) {
    global $db;



    $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    foreach($rows as $row) {
        $subcats[$row->parentForum_decID][] = $row->forum_decID;
        $forumNames[$row->forum_decID] = $row->forum_decName; }
    // build hierarchical list
    $this->print_forums1($subcats[NULL], $subcats, $forumNames,$brandID1);

    // link to input and search forms
    printf("<p><b><br />%s</b></p>\n",
        build_href("find3.php", "", "חפש פורומים/החלטות"));
    $insertID=$_GET['insertID'];
    return $insertID;
}

/*******************************************************************************/

function print_forum_dec($brandIDs, $subcats, $forumNames) {
    echo "<ul>";
    foreach($brandIDs as $brandID) {
        if($brandID==11){
            printf("<li><b>%s (%s, %s)</b></li>\n",
                htmlspecial_utf8($catNames[$brandID]),
                build_href2("dynamic_8.php","mode=insert","&insertID=$brandID", "הוסף"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$brandID", "עדכן"));
        }else{
            printf("<li><b>%s (%s, %s, %s, %s, %s )</b></li>\n",

                htmlspecial_utf8($decNames[$brandID]),

                build_href2("dynamic_8.php","mode=insert","&insertID=$brandID", "הוסף"),
                build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$brandID","OnClick= 'return verify();' class='href_modal1'"),
                build_href2("dynamic_8.php" ,"mode=update","&updateID=$brandID", "עדכן"),
                build_href("find3.php" ,"&forum_decID=$brandID", "נתונים כלליים"),
                build_href2("dynamic_8.php" ,"mode=read_data","&editID=$brandID", "עידכון מורחב"));

        }

        if(array_key_exists($brandID, $subcats)){

            $this->print_forums($subcats[$brandID], $subcats, $forumNames);

        }
    }
    echo "</ul>\n";
}
/*******************************************************************************/
function  print_form2($brandID1) {
    /*******************************************************************************/
    global $db;


    // query for all categories1
    $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    foreach($rows as $row) {
        $subcats[$row->parentforum_decID][] = $row->forum_decID;
        $forumNames[$row->forum_decID] = $row->forum_decName; }
    // build hierarchical list
    $this->print_forums1($subcats[NULL], $subcats, $forumNames,$brandID1);
    printf("<p><b><br />%s<b></p>\n",
        build_href("find3.php", "", "חפש פורומים/החלטות"));
}
/*******************************************************************************/
function print_forums1($brandIDs, $subcats, $forumNames,$brandID1) {
    /*******************************************************************************/
    echo "<ul>";
    foreach($brandIDs as $brandID) {
        printf("<li>%s (%s)</li>\n",
            htmlspecial_utf8($decNames[$brandID]),
            //build_href("dynamic_8.php","&insertID=$brandID", "קשר אליי"));
            build_href2("dynamic_8.php","mode=link","&insertID=$brandID&forum_decID=$brandID1", "קשר אליי"));
        if(array_key_exists($brandID, $subcats))
            $this->print_forums1($subcats[$brandID], $subcats, $forumNames,$brandID1);
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
$brandID = $updateID;
while($parents[$brandID]!=NULL) {
    $brandID = $parents[$brandID];
    $parentList[] = $brandID;


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
            foreach($subcats[$updateID] as $brandID) {
                $url="../admin/find3.php?forum_decID=$brandID";
                $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
                printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",

                    htmlspecial_utf8($forumNames[$brandID]),
                    build_href2("dynamic_8.php","mode=insert","&insertID=$brandID", "הוסף"),
                    build_href2("dynamic_8.php" ,"mode=delete","&deleteID=$brandID", "מחק","OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_8.php" ,"mode=update","&updateID=$brandID", "עדכן"),
                    build_href2("dynamic_8.php" ,"mode=read_data","&editID=$brandID", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים",$str));


            }

            echo "<ul>";
            $updateID=$brandID;
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
    $brandID = $updateID;
    while($parents[$brandID]!=NULL) {
        $brandID = $parents[$brandID];
        $parentList[] = $brandID;


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
                foreach($subcats[$updateID] as $brandID) {
                    $url="../admin/find3.php?forum_decID=$brandID";
                    $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
                    printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",

                        htmlspecial_utf8($forumNames[$brandID]),
                        build_href2("dynamic_8.php" ,"mode=read_data","&editID=$brandID", "מידע מורחב"),
                        build_href5("", "", "הראה נתונים",$str));


                }

                echo "<ul>";
                $updateID=$brandID;
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
                $brandID = $updateID;
                while($parents[$brandID]!=NULL) {
                    $brandID = $parents[$brandID];
                    $parentList[] = $brandID;
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
                        foreach($subcats[$updateID] as $brandID) {
                            $url="../admin/find3.php?forum_decID=$brandID";
                            $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
                            printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",

                                htmlspecial_utf8($forumNames[$brandID]),
                                build_href2("dynamic_10.php","mode=insert","&insertID=$brandID", "הוסף"),
                                build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$brandID", "מחק","OnClick='return verify();'class=href_modal1"),
                                build_href2("dynamic_10.php" ,"mode=update","&updateID=$brandID", "עדכן"),
                                build_href2("dynamic_10.php" ,"mode=read_data","&editID=$brandID", "עידכון מורחב"),
                                build_href5("", "", "הראה נתונים",$str));


                        }

                        echo "<ul>";
                        $updateID=$brandID;
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
                $brandID = $updateID;
                while($parents[$brandID]!=NULL) {
                    $brandID = $parents[$brandID];
                    $parentList[] = $brandID;
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
                        foreach($subcats[$updateID] as $brandID) {
                            $url="../admin/find3.php?forum_decID=$brandID";
                            $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
                            printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",

                                htmlspecial_utf8($forumNames[$brandID]),
                                build_href2("dynamic_10.php" ,"mode=read_data","&editID=$brandID", "מידע מורחב"),
                                build_href5("", "", "הראה נתונים",$str));


                        }

                        echo "<ul>";
                        $updateID=$brandID;
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
                $brandID = $updateID;
                while($parents[$brandID]!=NULL) {
                    $brandID = $parents[$brandID];
                    $parentList[] = $brandID;


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
                        foreach($subcats[$updateID] as $brandID) {
                            $url="../admin/find3.php?forum_decID=$brandID";
                            $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
                            printf("<li style='font-weight:bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",

                                htmlspecial_utf8($forumNames[$brandID]),
                                build_href2("dynamic_10.php","mode=insert","&insertID=$brandID", "הוסף"),
                                build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$brandID", "מחק","OnClick='return verify();' class='href_modal1'"),
                                build_href2("dynamic_10.php" ,"mode=update","&updateID=$brandID", "עדכן"),
                                build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "עידכון מורחב"),
                                build_href5("", "", "הראה נתונים",$str));


                        }

                        echo "<ul>";
                        $updateID=$brandID;
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
                $brandID = $updateID;
                while($parents[$brandID]!=NULL) {
                    $brandID = $parents[$brandID];
                    $parentList[] = $brandID;


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
                        foreach($subcats[$updateID] as $brandID) {
                            $url="../admin/find3.php?forum_decID=$brandID";
                            $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
                            printf("<li style='font-weight:bold;'> %s (%s, %s) </li>\n",

                                htmlspecial_utf8($forumNames[$brandID]),
                                build_href2("dynamic_10.php" ,"mode=read_data","&editID=$updateID", "מידע מורחב"),
                                build_href5("", "", "הראה נתונים",$str));


                        }

                        echo "<ul>";
                        $updateID=$brandID;
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
            $brandID = $updateID;
            while($parents[$brandID]!=NULL) {
                $brandID = $parents[$brandID];
                $parentList[] = $brandID;
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
                    foreach($subcats[$updateID] as $brandID) {
                        $url="../admin/find3.php?forum_decID=$brandID";
                        $str='onclick=\'openmypage3("'.$url.'"); return false;\'   class=href_modal1 ';
                        printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",

                            htmlspecial_utf8($forumNames[$brandID]),
                            build_href2("dynamic_10.php","mode=insert","&insertID=$brandID", "הוסף"),
                            build_href2("dynamic_10.php" ,"mode=delete","&deleteID=$brandID", "מחק","OnClick='return verify();' class='href_modal1'"),
                            build_href2("dynamic_10.php" ,"mode=update","&updateID=$brandID", "עדכן"),
                            build_href2("dynamic_10.php" ,"mode=read_data","&editID=$brandID", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים",$str));


                    }

                    echo "<ul>";
                    $updateID=$brandID;
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
        function read_forum_data($brandID) {

            global $db;

            $sql="select * from forum_dec WHERE forum_decID=$brandID  ";
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
                    " AND r.forum_decID = $brandID " .
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
                    " AND r.forum_decID = $brandID " .
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
			AND r.forum_decID =$brandID ORDER BY c.catName";
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
			AND r.forum_decID =$brandID ORDER BY m.managerTypeName";
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
        function read_forum_data1($brandID) {

            global $db;

            $sql="select f.* ,m.managerName from forum_dec f ,managers m 
        WHERE f.managerID=m.managerID 
        AND forum_decID=$brandID  ";
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
                    " AND r.forum_decID = $brandID " .
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
                    " AND r.forum_decID = $brandID " .
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
			AND r.forum_decID =$brandID ORDER BY c.catName";
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
			AND r.forum_decID =$brandID ORDER BY m.managerTypeName";
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
        function read_forum_data2($brandID) {

            global $db;

            $sql="select * from forum_dec WHERE forum_decID=$brandID  ";
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
             AND r.forum_decID = $brandID 
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
			AND r.forum_decID =$brandID ORDER BY c.catName";
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
        function read_forum_data3($brandID) {

            global $db;


            $sql = "SELECT u.userID FROM users u, rel_user_forum r " .
                " WHERE u.userID = r.userID " .
                " AND r.forum_decID = $brandID " .
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
            $brandID=$formdata['forum_decID'];
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

                $message_name['forum_decID']=$brandID;
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

