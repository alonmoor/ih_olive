<?php
require_once ("../config/application.php");
require_once (LIB_DIR.'/model/Brand.php');
require_once ("../lib/model/DBobject3.php");
require_once(LIB_DIR.'/model/class.handler.php');
//require_once(LIB_DIR.'/model/class.uploader.php');

//require_once ("getproducts.php");
$showform=TRUE;
global $db;
$_POST['form']['dynamic_ajx']=FALSE;
if(  !(isAjax())){
    html_header();
}
if( array_item($_POST, 'brandID') && count($_POST)==1 && !$_GET ){
    $_REQUEST['mode']="read_data";
}

//----------------------------------------------------------------------------------------------------------
$_POST['brandID']=	isset($_POST['brandID']) ? $_POST['brandID'] : '';
if(isset($_POST['brandID']) &&  isset($_POST['form']) &&  ( $_POST['brandID']!=$_POST['brandID'] && $_POST['brandID']!='none' && $_POST['brandID']) ) {
    $_POST['form']['brandID']=	$_POST['brandID'];
}
//---------------------------------------------------------------------------------
if( array_item($_REQUEST, 'id'))
    $brandID = array_item($_REQUEST, 'id');
else
    $brandID = isset($_REQUEST['brandID']) ?  $_REQUEST['brandID'] : '' ;//array_item($_REQUEST, 'brandID') : '';
//---------------------------------------------------------------------------------
if(isset($_POST['form']['brandID']) && array_item($_POST,'form') && is_numeric($_POST['form']['brandID'])
    && $_REQUEST['mode']=='insert'  ){
    $_SESSION['brandID']=$_POST['form']['brandID'];
}
//---------------------------------------------------------------------------------

if(isset($_POST['brandID']) &&   isset($_POST['form']['newbrand ']) && isset($_POST['form']) &&  ( ($_POST['form']['brandID']  &&  isset($_POST['form']['brandID'])  && !empty($_POST['form']['brandID']) && $_POST['form']['brandID']!='none')
        && !($_POST['form']['newbrand '] && !$_POST['form']['newbrand ']!='none') )
    && ($_REQUEST['mode']=='save')   ){
    $_POST['mode']="update";
    $_REQUEST['mode']="update";
}




function getFileMimeType($file) {
    if (function_exists('finfo_file')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $type = finfo_file($finfo, $file);
        finfo_close($finfo);
    } else {
        require_once 'upgradephp/ext/mime.php';
        $type = mime_content_type($file);
    }

    if (!$type || in_array($type, array('application/octet-stream', 'text/plain'))) {
        $secondOpinion = exec('file -b --mime-type ' . escapeshellarg($file), $foo, $returnCode);
        if ($returnCode === 0 && $secondOpinion) {
            $type = $secondOpinion;
        }
    }

    if (!$type || in_array($type, array('application/octet-stream', 'text/plain'))) {
        require_once 'upgradephp/ext/mime.php';
        $exifImageType = exif_imagetype($file);
        if ($exifImageType !== false) {
            $type = image_type_to_mime_type($exifImageType);
        }
    }

    return $type;
}

function expert_toDate($str, $format = 'm/d/Y H:i')
{
    $time = explode(' ', $str);
    $time[0] = explode('/', $time[0]);
    return date('m/d/Y H:i:s', strtotime($time[0][1] . '/' . $time[0][0] . '/' . $time[0][2] . ' ' . $time[1]));
}
//---------------------------------------------------------------------------------
$_REQUEST['mode']  = isset( $_REQUEST['mode'] ) ? $_REQUEST['mode'] : 'default';
//---------------------------------------------------------------------------------
?>
    <script type="text/javascript">
     //   turn_red_error();
    </script>
<?php
switch ($_REQUEST['mode'] ) {
//sdfasfasgsdgsdfgsdg
    case "copy_files":
        global $db;
        $log ='';
        $pdf_file= PDF_DIR; //PDF FILE LOCATION
        $jpgloc=PDF_DIR."page.jpg";// LOCATION TO PLACE EXTRACTED JPG FILES
        $brand=new brand();
        $src = "/home/alon/Desktop/PROJECT/4.4.17";
        $dst = PDF_DIR;
        $brand-> recurse_copy($src,$dst);
        $files = new RecursiveDirectoryIterator(PDF_DIR);
        $files->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($files);
        $name = '';

        foreach ($files as $file) {
            if(pathinfo($file, PATHINFO_EXTENSION) == 'pdf'){
                $name = $file->getFilename();
                if($file->getFilename() == 'ayom2p001.pdf' || $file->getFilename() == 'ayom2p001_new.pdf' ||  $file->getFilename() == 'ayom2p003.pdf' || $file->getFilename() == 'issh1p007.pdf' || $file->getFilename() == 'issh1p005_new.pdf'){
                    $x =1;
                }
                $file_name = explode('.',$name);
                $file_name = $file_name[0];
//------------------------------------------NEW--------------------------------------------------------------------
//ayom2p001_new
                $file_name1 = explode('_new',$file_name);
                $tmp_file = $file_name1;
                if (count($file_name1) > 1) {
                    $file_name1 = $file_name1[0];
                    $newname = $file_name1 . ".pdf";
//file original+new exist check if origional exist
                    $sql = "SELECT COUNT(*) FROM pdfs " .
                        "WHERE pdfName='$newname'";
                    if ($db->querySingleItem($sql) > 0) {
//get the ID+modify
                        $sql = "SELECT * FROM pdfs " .
                            "WHERE pdfName='$newname'";

                        $modify = '';
                        if ($rows = $db->queryObjectArray($sql)) {
                            $pdfID = $rows[0]->pdfID;
                            $modify = $rows[0]->modify_date;
                        }
                        if (count($tmp_file) > 1 && isset($modify) && $file->getCTime() > strtotime($modify) ) {
                            $sql = "DELETE FROM  pdfs  WHERE  pdfID = $pdfID  ";
                            if (!$db->execute($sql)) {
                                return FALSE;
                            } else {
                                unset($tmp_file);
                            }
                            $mime = "application/pdf";
                            $mime = $file->getExtension();
                            $mime = getFileMimeType($file);
                            $data = file_get_contents(PDF_DIR . $name);
                            $size = $file->getSize();
                            // $pdf_date = date("F d Y H:i:s.", filemtime($file));
                            $pdf_date = date("Y-m-d H:i:s");
                            $modify_date = $file->getMTime();
                            $modify_date = date('Y-m-d H:i:s', $file->getMTime());

                            $path = $file->getRealPath();
                            if (file_exists($path)) {
                            }
                            $sql = "SELECT COUNT(*) FROM pdfs " .
                                "WHERE pdfName='$name'";
                            if ( !($db->querySingleItem($sql) > 0) ) {
                                $sql = "INSERT INTO pdfs (`pdfName`,`data`,`size`,`pdf_date`,`modify_date`,`mime`)VALUES ( " .
                                    $db->sql_string($name) . ", " .
                                    $db->sql_string($data) . ", " .
                                    $db->sql_string($size) . ", " .
                                    $db->sql_string($pdf_date) . ", " .
                                    $db->sql_string($modify_date) . ", " .
                                    $db->sql_string($mime) . " ) ";

                                if (!$db->execute($sql)) {
                                    show_error_msg('כבר קיים PDF בשם הזה' . $name);
                                    $log = "כבר קיים PDF בשם הזה :" . ' - ' . date("F j, Y, g:i a") . PHP_EOL . print_r($name, true) . PHP_EOL;
                                    $log .= "---------------------------------------------------------------------------------------------------------------------------------------------------------" . PHP_EOL;
                                    file_put_contents('/tmp/olive_log_last_' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
                                }else{
                                    ?>
                                    <script type="javascript">
                                        $('.my_task').css('width', '20%');
                                        turn_red_task();
                                    </script>
                                    <?php
                                }
                            }
                            $jpgloc2 = CONVERT_PDF_TO_IMG_DIR . "$file_name.jpg";
                            if (!file_exists($jpgloc2)) {
                                $brand->convertPDF2JPG($file->getRealPath(), $jpgloc2);
                            }
                        }
                    }
                }
//---------------------------------------------------------------------------------------------------------------------------------
                elseif(!(count($tmp_file) > 1) ) {
                    $jpgloc2 = CONVERT_PDF_TO_IMG_DIR . "$file_name.jpg";
                    if (!file_exists($jpgloc2)) {
                        $brand->convertPDF2JPG($file->getRealPath(), $jpgloc2);
                    }
//check if file exist
                    $sql_count = "SELECT COUNT(*) FROM pdfs " .
                        "WHERE pdfName='$name'";

                    $sql = "SELECT * FROM pdfs " .
                        "WHERE pdfName='$name'";

                    $modify = '';
                    if ($rows = $db->queryObjectArray($sql)) {
                        $pdfID = $rows[0]->pdfID;
                        $modify = $rows[0]->modify_date ;



                        if($file->getCTime() > strtotime($modify)){
                            $mime = $file->getExtension();
                            $mime = getFileMimeType($file);
                            $data = file_get_contents(PDF_DIR . $name);
                            $size = $file->getSize();

                            $pdf_date = date("Y-m-d H:i:s", time());;
                            $modify_date = $file->getMTime();
                            $modify_date =  date('Y-m-d H:i:s',$file->getMTime());
                            $modify_change_date =  date('Y-m-d H:i:s',$file->getCTime());
                            $isChange = 'change';


                            $sql =  "UPDATE pdfs SET " .
                                    "modify_date=" . $db->sql_string($modify_change_date) . " , " .
                                    "ischange=" . $db->sql_string($isChange) . "  " .
                                    "WHERE pdfID =  " . $db->sql_string($pdfID) . " ";

                            if (!$db->execute($sql)) {
                                return false;
                            }else{
                                $x=1;
                            }
                        }
                    }else if ($db->querySingleItem($sql) > 0) {
                        show_error_msg('כבר קיים PDF בשם הזה' . $name);
                        $log  = "כבר קיים PDF בשם הזה :" . ' - ' . date("F j, Y, g:i a") .  PHP_EOL  . print_r($name, true) . PHP_EOL;
                        $log .= "---------------------------------------------------------------------------------------------------------------------------------------------------------" . PHP_EOL ;
                        file_put_contents('/tmp/olive_log_last_' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
                    }
//---------------------------------------------------------------------------------------------------
                    else{
                        $new_name = explode('.pdf',$name);
                        $new_name =  $new_name[0];
                        $new_name = $new_name.'_new.pdf';

                        $sql_count = "SELECT COUNT(*) FROM pdfs " .
                            "WHERE pdfName='$new_name'";
//check if i dont have a file
                        if ( !($db->querySingleItem($sql) > 0) ) {


                            $mime = $file->getExtension();
                            $mime = getFileMimeType($file);
                            $data = file_get_contents(PDF_DIR . $name);
                            $size = $file->getSize();

                            $pdf_date = date("Y-m-d H:i:s", time());;
                            $modify_date = $file->getMTime();
                            $modify_date = date('Y-m-d H:i:s', $file->getMTime());

                            $sql = "INSERT INTO pdfs (`pdfName`,`data`,`size`,`pdf_date`,`modify_date`,`mime`)VALUES ( " .
                                $db->sql_string($name) . ", " .
                                $db->sql_string($data) . ", " .
                                $db->sql_string($size) . ", " .
                                $db->sql_string($pdf_date) . ", " .
                                $db->sql_string($modify_date) . ", " .
                                $db->sql_string($mime) . " ) ";

                            if (!$db->execute($sql)) {
                                return false;
                            }
                        }
                    }
                }//end else
            }//end pdf files
        }//end foreach
        break;
//---------------------------------------------------------------------------------
    case "view_pdfs":
        if( ! isAjax() ){
            global $dbc;
            $valid = false;
// Validate the PDF ID:
            if (isset($_GET['id']) && (strlen($_GET['id']) == 40) && (substr($_GET['id'], 0, 1) != '.') ) {
                // Identify the file:
                $file = PDF_DIR . $_GET['id'];
                // Check that the PDF exists and is a file:
                if (file_exists($file) && (is_file($file))) {
                    // Get the info:
                    $q = 'SELECT * FROM pdfs WHERE tmpName="' . mysqli_real_escape_string($dbc, $_GET['id']) . '"';
                    $r = mysqli_query($dbc, $q);
                    if (mysqli_num_rows($r) == 1) { // Ok!
                        // Fetch the info:
                        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
                        // Indicate that the file reference is fine:
                        $valid = true;
                        $GLOBALS['TEMPLATE']['content'] = ob_get_contents();
                        ob_end_clean();
                        ob_start();
                        // Send the content information:
                        header('Content-type:application/pdf');
                        header('Content-Disposition:inline;filename="' . $row['pdfName'] . '"');
                        $fs = filesize($file);
                        header("Content-Length:$fs\n");
                        // Send the file:
                        readfile($file);
                        exit();
                        $GLOBALS['TEMPLATE']['content'] = ob_get_contents();
                        ob_end_clean();
                        ob_end_flush();
                    }
                }
            }
        }
        break;

//-------------------------------------------------------------------------------

    case "save":
        global $db;
        if(isset($_POST['form']) && $_POST['form']){
            foreach($_POST['form'] as $key=>$val){
                if ($val=='none'  ||( $val == ""   ) ){
                    unset ($_POST['form'][$key]);
                }else {
                    $_POST['form'][$key]=$_POST['form'][$key];
                }
            }
        }


        $brand=new brand();
        $formdata['dynamic_10']=1;
        $formdata=$_POST['form'];
        $db->execute("START TRANSACTION");
        $result = true;
        if ($result = $brand->add_brand($formdata)) {
            $db->execute("COMMIT");
            return true;
        }
        $db->execute("ROLLBACK");
        $formdata['fail'] = true;
        $formdata['dynamic_10'] = 1;
        show_list($formdata);
        return;
        break;
//---------------------------------------------------------------------------------
    case "insert":
        if(isset($_GET['brandID']) && is_numeric($_GET['brandID']) ){
            update_to_parent($_GET['brandID'],$_GET['insertID']);
            unset($_SESSION['brandID']);
        }else{

            $insertID      = array_item($_REQUEST, 'insertID');
            $deleteID      = array_item($_REQUEST, 'deleteID');
            $updateID      = array_item($_REQUEST, 'updateID');
            $submitbutton  = array_item($_POST, 'submitbutton');
            $subcategories = array_item($_POST, 'subcategories');

            insert_forum($_GET['insertID'],$submitbutton,$subcategories);
        }
        break;
//---------------------------------------------------------------------------------
    case  "link":
        if (isset($_REQUEST['form'])){
            read_befor_link($_POST['form']);
        }else{
            $formdata['brandID']=$_GET['brandID'];
            $formdata['insertID']=$_GET['insertID'];
            read_link($formdata);
        }
        break;
//---------------------------------------------------------------------------------
    case  "read_data":
        if( array_item($_POST, 'brandID') && count($_POST)==1 && !$_GET){
            $_REQUEST['editID']= array_item($_POST, 'brandID');
        }
        if($_REQUEST['editID']){
            $formdata =read_brand($_GET['editID']);
        }else{
            $formdata =read_brand($_GET['brandID']);
        }
        break;

//---------------------------------------------------------------------------------
    case "update":
        global $db;
        if(isset($_GET['updateID']) && $_GET['updateID']) {
            update_forum1($_GET['updateID']);

        }else{
//------------------------------------------------------------------------------------			
            if($_POST['form']){
                foreach($_POST['form']  as $key=>$val){
                    if ($val=='none' || $val== "" )
                        unset ($_POST['form'][$key]);
                }
            }
//------------------------------------------------------------------------------------
            $brandID= isset($_POST['form']['brandID']) ? $_POST['form']['brandID']: '' ;
//-----------------------------------------------------------------------
//

            $formdata = isset($_POST['form']) ? $_POST['form'] : false;
            $formdata['brandID'] = $brandID;
            if(isset($formdata['brand_date2'])) {
                list($year_date, $month_date, $day_date) = explode('-', $formdata['brand_date2']);
                if (strlen($year_date) > 3) {
                    $formdata['brand_date'] = "$year_date-$month_date-$day_date";
                }
            }
//----------------------------------------------------------------------
            $db->execute("START TRANSACTION");
            if(!$formdata=update_brand($formdata)){
                $db->execute("ROLLBACK");
                return false;
            } else{
                $db->execute("COMMIT");
                $formdata['type'] = 'success';
                $formdata['message'] = 'עודכן בהצלחה!';
                show_list($formdata);
                return true;
//----------------------------------------------------------------------
            }
        }
        break;
    case "realy_delete":
        real_del($_POST['form']);
        $showform=FALSE;
        break;
//------------------------------------------------------------------------------------
    case "delete":
        if (($_GET['deleteID'])){
            $formdata['forum_demo_last8']=1;
            delete_forum($_GET['deleteID'],$formdata);//subcategories
        }else{
            $formdata['forum_demo_last8']=1;
            delete_forum($_POST['form']['brandID'],$formdata);
        }

        break;
    //------------------------------------------------------------------------------------------------------

    default:
    case "list":

        $brand =new brand();




        if(isset($showform) &&  $showform && !empty($_POST['form']['btnLink1'])  && !($_POST['form']['btnLink1'])) {

            $formdata = array_item($_POST, "form");

            if(array_item($formdata, "brandID"))
                echo "<h1>ערוך פורום</h1>";
            else
                echo "<h1>הזן נתונים לפורום  </h1>";

            $brand->print_forum_paging_b();

            show_list($formdata);

        }else{
            if(isset($_POST['form']['brandID'])) {
                $brandID = $_POST['form']['brandID'];
                if (is_numeric($brandID))
                    $brand->print_forum_entry_form1($brandID);
                $brand->print_forum_paging_b($brandID);
            }
        }
}
//-----------------------------------------------------------------
/**
 * @param $formdata
 * @return bool
 */
function update_brand($formdata){
    global $db;
    $brand=new brand();//($formdata);
    $formdata['dynamic_10']=1;
    $formdata['brandID'] = isset($formdata['brandID']) ? $formdata['brandID'] : '';
    if(!empty($formdata['brandID'] ) && is_numeric($formdata['brandID']) ) {
        $formselect = $brand->read_brand_data($formdata['brandID']);
        if (isset($formselect['src_pdfsID']) && isset($formselect['src_pdfs']) && $formselect['src_pdfs'] && $formselect['src_pdfs'] != null
            && $formselect['src_pdfsID'] && $formselect['src_pdfsID'] != null
        ) {
            $formdata['src_pdfs'] = explode(',', $formselect['src_pdfs']);
            $formdata['src_pdfsID'] = explode(',', $formselect['src_pdfsID']);
            $formdata['src_pdfs2'] = isset($formdata['src_pdfsID']) ? $formdata['src_pdfsID'] : '';
            $formdata['date_src_pdfs'] = explode(',', $formselect['date_users']);
        } else {
            unset($formdata['src_pdfs']);
            unset($formdata['src_pdfsID']);
        }
        $brandID = $formdata['brandID'];

        if(!isset($formdata['pages']) ) {
            $formdata['pages'] = $formselect['pages'];
        }




        if(array_item($formselect,'brand_date2') && !(array_item($formdata,'brand_date2')) ){
            $brand_date = isset($formselect['brand_date2']) ? $formselect['brand_date2'] : '';
            $formdata['brand_date2'] = $formselect['brand_date2'];
        }elseif(array_item($formdata,'brand_date2')){
            $brand_date = isset($formdata['brand_date2']) ? $formdata['brand_date2'] : '';
        }else{
            echo "need to suply date!!!";
            return false;
        }
//--------------------------------------------------------------------------
        if(array_item($formselect,'brandPrefix') && !(array_item($formdata,'brandPrefix')) ) {
            $formdata['brandPrefix'] = isset( $formselect['brandPrefix']) ?  $formselect['brandPrefix'] :'';
        }elseif (array_item($formdata,'brandPrefix')){
            $formdata['brandPrefix'] = isset( $formdata['brandPrefix']) ?  $formdata['brandPrefix'] :'';
        }
        if(isset($formselect['brandName'])){
            $formdata['brandName'] = $formselect['brandName'];
            $formdata['newbrandName'] = $formselect['brandName'];
        }else{
            echo 'need to supply name!!!!';
            return false;
        }
//-------------------------------------------------------------------------
        if (array_item($formdata, "dest_pdfs")) {
            $pdfIDS = $formdata["dest_pdfs"];
        }
        if (array_item($formdata, "dest_publishers")) {
            $pubIDs = $formdata["dest_publishers"];
        }
        // if ($brand->validate_data_ajx($formdata, $pdfIDS, $brand_date, $insertID = "", $formselect)) {
        if ($result = $brand->update_brand1($formdata, $formselect)) {
            if ($result == -1) {
                echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
                return FALSE;
            }
            if(array_item($formdata,'dest_pdfs'))
                $brand->conn_brand_pdf($pdfIDS ,$brandID);
            if(array_item($formdata,'dest_publishers'))
                $brand->conn_brand_pub($pubIDs ,$brandID);
            if(isset($formdata['brandID']) && is_numeric($formdata['brandID'])) {
                $id = $formdata['brandID'];
                if (isset($formdata['brandID']) && isset($formdata['newbrand ']) && isset($brandID) ) {
                    $formdata['brandID'] = $brandID;
                    unset($formdata['newbrand']);
                }
            }

            return $formdata;
        } else{
            echo "נכשל בעדכון";
            return false;
        }
//----------------------------------------------------------
    }
    //  }
    return false;
}
//-----------------------------------------------------------------
function validate($formdata){
    global $db;

    $brand=new brand();
    $formdata['dynamic_10']=1;
    $db->execute("START TRANSACTION");
    if ($publishersIDs = $brand->fetch_publisher($formdata)) {
        if ($pdfIDS = $brand->fetch_pdf($formdata)) {
            if($imgNams = $brand->convertPdfToImg($formdata) ){
                //if ($brandIDS = $brand->update_brand($formdata)) {
                if ($brand->add_brand($formdata,$publishersIDs,$pdfIDS,$imgNams)) {
                    $db->execute("COMMIT");
                    return true;
                }
            }
        }
    }else{
        $db->execute("ROLLBACK");
        $formdata = FALSE;
        return false;
    }
}//end function validate
//---------------------------------------------------
function delete_forum($deleteID,$formdata=''){
    $brand=new brand();
    $brand->del_brand1($deleteID);
    show_list($formdata);
}
//---------------------------------------------------
function insert_forum($insertID,$submitbutton,$subcategories){
    $brand=new brand();
    $brand->set($insertID,$submitbutton,$subcategories);
    $insertID=$_GET['insertID'];
    $brandID= isset($_GET['brandID']) ? $_GET['brandID'] : '';
    if(is_numeric($brandID)){
        $formdata=$brand->read_forum_data($brandID);
    }else{
        $formdata['insertID']=$insertID  ;
        $formdata['forum_demo_last8']=1;
    }
    $brand->print_forum_entry_form_c($insertID);
    build_form($formdata);
    $brand->print_forum_paging_b();
    $brand->link();
}

/**
 * @param string $formdata
 */
function  show_list($formdata=""){
    $brand=new brand();
    $brand->print_brand_paging();
    build_form($formdata);
}
//---------------------------------------------------
function  show_list_fail($formdata=""){
    $brand=new brand();
    build_form($formdata);
    $brand->print_forum_paging_b();
}
//---------------------------------------------------
function read_brand($editID){
    global $db;
    $brand=new brand();
    if($_REQUEST['editID']){
        if(($editID = $brand->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
            $formdata =$brand->read_brand_data($editID);//i took off the merchaot from full_name if will be problem to check
        }
    }else{
        if(($editID =$brand->array_item($_REQUEST, 'brandID')) && is_numeric($brandID)){
            $formdata = $brand->read_brand_data($brandID);
        }
    }
    $brandID=$formdata['brandID'];
    //  $brand->message_update_b($formdata,$brandID);
    $formdata['brandID'] = $brandID;
    $brand->print_brand_paging();
//    build_form_ajx7($formdata);
    build_form($formdata);
    return  TRUE;
}
//---------------------------------------------------
function update_forum1($updateID){
    $brand=new brand();
    $insertID      = array_item($_REQUEST, 'insertID');
    $deleteID      = array_item($_REQUEST, 'deleteID');
    $updateID      = array_item($_REQUEST, 'updateID');
    $submitbutton  = array_item($_POST, 'submitbutton');
    $subcategories = array_item($_POST, 'subcategories');

    $brand->set($insertID,$submitbutton,$subcategories,$deleteID,$updateID);
    //$brand->link_div();
    $brand->update_brand_general();
    build_form($formdata);
    $brand->print_forum_paging_b();
    return  TRUE;
}
//---------------------------------------------------
function  real_del($formdata){
    $brand=new brand();
    global $db;

    if(array_item($formdata,'brandID')){
        $formdata=$brand->read_brand_data($formdata['brandID']);
        $db->execute("START TRANSACTION");
        if($brand->delete_brand($formdata))
            $db->execute("COMMIT");
        else
            $db->execute("ROLLBACK");
        $formdata = FALSE;}
    return $formdata;
}
//---------------------------------------------------
function link1(){
    $brand=new brand();
    $brand->print_form();
    return true;
}
//---------------------------------------------------
function update_to_parent($brandID ,$insertID){
    $brand=new brand();
    $brand->update_parent($insertID,$brandID);
}
//---------------------------------------------------
function delete_user_forum($usrID,$brandID){
    $brand=new brand;
    $brand->del_usr_frm($usrID,$brandID);
    return true;
}
$brand=new brand;
$brand ->html_footer();
//----------------------------------------------------------------------------



?>