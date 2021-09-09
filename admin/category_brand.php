<?php
require_once ("../config/application.php");
require_once (LIB_DIR.'/model/Categories.class.php');
require_once (LIB_DIR.'/model/DBobject3.php');
require_once(LIB_DIR.'/model/class.handler.php');

$showform=TRUE;
global $db;

if(  !(isAjax())){
    html_header();
}

$_REQUEST['mode']  = isset( $_REQUEST['mode'] ) ? $_REQUEST['mode'] : 'default';
//---------------------------------------------------------------------------------
switch ($_REQUEST['mode'] ) {
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
        $cat=new category();
        $formdata['dynamic_10']=1;
        $formdata=$_POST['form'];
        $db->execute("START TRANSACTION");
        $result = true;
                    if ($result = $cat->add_category($formdata)) {
                        $db->execute("COMMIT");
                        return true;
        }
        $db->execute("ROLLBACK");

        $formdata['newcatName'] = '';
        $formdata['catPrefix'] = '';

        show_list($formdata);
        return;
        break;
//---------------------------------------------------------------------------------
    case "insert":
        if(isset($_GET['catID']) && is_numeric($_GET['catID']) ){
            update_to_parent($_GET['catID'],$_GET['insertID']);
            unset($_SESSION['catID']);
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

    case  "read_data":
        if( array_item($_POST, 'catID') && count($_POST)==1 && !$_GET){
            $_REQUEST['editID']= array_item($_POST, 'catID');
        }
        if($_REQUEST['editID']){
            $formdata = read_cat($_GET['editID']);
        }else{
            $formdata = read_cat($_GET['catID']);
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
            $catID= isset($_POST['form']['catID']) ? $_POST['form']['catID']: '' ;


            $formdata = isset($_POST['form']) ? $_POST['form'] : false;


            if(!empty($_POST['insert_forum']) && is_numeric($_POST['insert_forum']) && !($_POST['insert_forum'] == 11)){
                $formdata['insert_forum'] = $_POST['insert_forum'];
                $formdata['insertID'] = $_POST['insert_forum'];
            }
//----------------------------------------------------------------------
            $db->execute("START TRANSACTION");

            if(!$formdata=update_category($formdata)){
                $db->execute("ROLLBACK");

              return false;
            } else{
                $db->execute("COMMIT");
                $formdata['type'] = 'success';
                $formdata['message'] = 'עודכן בהצלחה!';
//                echo json_encode($formdata);
//                exit;
                //build_form($formdata);
                show_list($formdata);
                return true;
//----------------------------------------------------------------------
            }
        }
break;
    case "realy_delete":
if(isset($_POST['form'])){
        real_del($_POST['form']);
        $showform=FALSE;
}
        break;
//----------------------------------------------------------------------
    case "delete":
        if (($_GET['deleteID'])){
            $formdata['forum_demo_last8']=1;
            delete_forum($_GET['deleteID'],$formdata);//subcategories
        }else{
            $formdata['forum_demo_last8']=1;
            delete_forum($_POST['form']['catID'],$formdata);
        }

        break;
//----------------------------------------------------------------------
    default:
    case "list":

        $cat =new category();




        if(isset($showform) &&  $showform && !empty($_POST['form']['btnLink1'])  && !($_POST['form']['btnLink1'])) {

            $formdata = array_item($_POST, "form");

            if(array_item($formdata, "catID"))
                echo "<h1>ערוך פורום</h1>";
            else
                echo "<h1>הזן נתונים לפורום  </h1>";

            $cat->print_forum_paging_b();

            show_list($formdata);

        }else{
            if(isset($_POST['form']['catID'])) {
                $catID = $_POST['form']['catID'];
                if (is_numeric($catID))
                    $cat->print_forum_entry_form1($catID);
                $cat->print_forum_paging_b($catID);
            }
        }
}

//-----------------------------------------------------------------
function validate($formdata){
    global $db;

    $cat=new category();
    $formdata['dynamic_10']=1;
    $db->execute("START TRANSACTION");
    if ($publishersIDs = $cat->fetch_publisher($formdata)) {
            if ($pdfIDS = $cat->fetch_pdf($formdata)) {
                if($imgNams = $cat->convertPdfToImg($formdata) ){
                    if ($forum_decID=$cat->add_cat($formdata,$publishersIDs,$pdfIDS,$imgNams)) {
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
//----------------------------------------------------------------------
function delete_forum($deleteID,$formdata=''){
    $cat=new category();
    $cat->del_cat($deleteID);
    show_list($formdata);
}
//----------------------------------------------------------------------------
function insert_forum($insertID,$submitbutton,$subcategories){
    $cat=new category();

    $cat->set($insertID,$submitbutton,$subcategories);
    $insertID=$_GET['insertID'];
    $catID= isset($_GET['catID']) ? $_GET['catID'] : '';
    if(is_numeric($catID)){
        $formdata=$cat->read_forum_data($catID);
    }else{
        //$cat->add_forum($formdata,$userIDs,$catIDs,$dateIDs);
        $formdata['insertID']=$insertID  ;


        $formdata['forum_demo_last8']=1;
    }
    //$cat->print_forum_entry_form1_b($insertID);
    $cat->print_forum_entry_form_c($insertID);
    build_form($formdata);
    $cat->print_forum_paging_b();

    $cat->link();
}

/**
 * @param string $formdata
 */
function  show_list($formdata=""){
    $cat=new category();
//	$cat->link_div();
    $cat->print_forum_paging_b();
    build_form($formdata);
}
//----------------------------------------------------------------------------
function  show_list_fail($formdata=""){
    $cat=new category();

    build_form($formdata);
    $cat->print_forum_paging_b();

}
//----------------------------------------------------------------------------

function read_cat($editID){
    global $db;
    $cat=new category();

    if($_REQUEST['editID']){
        if(($editID = $cat->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
            $formdata =$cat->read_cat_data($editID);//i took off the merchaot from full_name if will be problem to check
        }
    }else{
        if(($editID =$cat->array_item($_REQUEST, 'catID')) && is_numeric($catID)){
            $formdata = $cat->read_cat_data($catID);
        }
    }
    $catID=$formdata['catID'];
  //  $cat->message_update_b($formdata,$catID);
    $formdata['catID'] = $catID;
    $cat->print_forum_paging_b();
//    build_form_ajx7($formdata);
    build_form($formdata);
    return  TRUE;
}
//----------------------------------------------------------------------

function update_forum1($updateID){
    $cat=new category();

    $insertID      = array_item($_REQUEST, 'insertID');
    $deleteID      = array_item($_REQUEST, 'deleteID');
    $updateID      = array_item($_REQUEST, 'updateID');
    $submitbutton  = array_item($_POST, 'submitbutton');
    $subcategories = array_item($_POST, 'subcategories');


    $cat->set($insertID,$submitbutton,$subcategories,$deleteID,$updateID);
    $cat->update_cat_general();
    build_form($formdata);
    $cat->print_forum_paging_b();
    return  TRUE;
}
function  delete_dec_form ($formdata){
    $dec=new category();

    if(array_item($formdata, "btnClear"))
        // clear form
        $formdata = FALSE;

    elseif(array_item($formdata, "btnDelete")) {
        // ask, if really delete
        if($dec->build_delete_form($formdata))
            $showform=FALSE; }

    return true;
}
//----------------------------------------------------------------------------
function  real_del($formdata){
    $cat=new category();
    global $db;

    if(array_item($formdata,'catID')){
        $formdata=$cat->read_cat_data($formdata['catID']);
        $db->execute("START TRANSACTION");
        if($cat->delete_cat($formdata))
            $db->execute("COMMIT");
        else
            $db->execute("ROLLBACK");
        $formdata = FALSE;}
    return $formdata;
}
//----------------------------------------------------------------------------
function link1(){
    $cat=new category();
    $cat->print_form();
    return true;
}
//----------------------------------------------------------------------------
function update_to_parent($catID ,$insertID){
    $cat=new category();
    $cat->update_parent($insertID,$catID);
}
//----------------------------------------------------------------------------
function delete_user_forum($usrID,$catID){
    $cat=new category;
    $cat->del_usr_frm($usrID,$catID);
    return true;
}
$cat=new category;
$cat ->html_footer();
//----------------------------------------------------------------------------
function update_category($formdata){
    global $db;
    $category=new category();//($formdata);
    
    $formdata['catID'] = isset($formdata['catID']) ? $formdata['catID'] : '';
    if(!empty($formdata['catID'] ) && is_numeric($formdata['catID']) ) {
        $formselect = $category->read_cat_data($formdata['catID']);

        $catID = $formdata['catID'];

        if(isset($formdata['insert_forum']) && !is_numeric($formdata['insert_forum'])){
            $formdata['insertID'] = isset($formselect['parentcatID']) ? $formselect['parentcatID'] : '11';
        }elseif(isset($formdata['insert_forum']) && is_numeric($formdata['insert_forum'])){
            $formdata['insertID'] = $formdata['insert_forum'];
        }else{
            $formdata['insertID'] = '11';
        }

//--------------------------------------------------------------------------
        if(array_item($formselect,'catPrefix') && !(array_item($formdata,'catPrefix')) ) {
            $formdata['catPrefix'] = isset( $formselect['catPrefix']) ?  $formselect['catPrefix'] :'';
        }elseif (array_item($formdata,'catPrefix')){
            $formdata['catPrefix'] = isset( $formdata['catPrefix']) ?  $formdata['catPrefix'] :'';
        }
        if(isset($formselect['catName'])){
            $formdata['catName'] = $formselect['catName'];
            $formdata['newcategoryName'] = $formselect['catName'];
        }else{
            echo 'need to supply name!!!!';
            return false;
        }
//-------------------------------------------------------------------------

        //if ($category->validate_data_ajx($formdata, $pdfIDS, $category_date, $insertID = "", $formselect)) {

//-----------------------------------------------------------
//                        if ($result = $category->update_category1($formdata, $formselect, $pdfIDS, $pubIDs)) {
            if ($result = $category->update_cat1($formdata, $formselect)) {
                if ($result == -1) {
                    echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
                    return FALSE;
                }
                if(array_item($formdata,'dest_pdfs'))
                    $category->conn_category_pdf($pdfIDS ,$catID);
                if(array_item($formdata,'dest_publishers'))
                    $category->conn_category_pub($pubIDs ,$catID);
                if(isset($formdata['catID']) && is_numeric($formdata['catID'])) {
                    $id = $formdata['catID'];
                    if (isset($formdata['catID']) && isset($formdata['newcategory ']) && isset($catID) ) {
                        $formdata['catID'] = $catID;
                        unset($formdata['newcategory']);
                    }
                }

                return $formdata;
            } else{
                //  $db->execute("ROLLBACK");
                echo "נכשל בעדכון";
                return false;
            }
//----------------------------------------------------------
       // }//end validate
    }
    //  }
//
//        }
//    }
    return false;
}
//-----------------------------------------------------------------





?>