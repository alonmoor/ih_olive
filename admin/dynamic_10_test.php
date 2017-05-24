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
if( array_key_exists('read_data2',$_GET)  &&  ($_GET['read_data2'])==0  && (is_numeric($_GET['editID']))  ){
    $_POST['mode']="read_data2";
    $_REQUEST['mode']="read_data2";
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
//---------------------------------------------------------------------------------/
if(isset($_POST['brandID']) &&  isset($_POST['form']) &&  (($_POST['brandID'] && $_POST['brandID']!='none')
        &&  ( is_array($_POST['form']) && is_numeric($_POST['brandID'] ) ))
    && ($_REQUEST['mode']=='save')
    && !$_POST['form']['newbrand ']){
    $_POST['mode']="update";
    $_REQUEST['mode']="update";
}
//--------------------------------------------------------------------------------
if(isset($_POST['brandID']) &&  isset($_POST['form']) && isset($_POST['form']['newbrand']) &&  ( ($_POST['brandID'] && $_POST['brandID']!='none')
        &&  ( is_array($_POST['form']) && is_numeric($_POST['brandID'] ) ))
    && ($_REQUEST['mode']=='save')
    && $_POST['form']['newbrand ']){
    $_POST['mode']="save";
    $_REQUEST['mode']="save";
}

//---------------------------------------------------------------------------------
if( isset($_POST['brandID']) &&   isset($_POST['form']['newbrand ']) && isset($_POST['form']) &&  ( ($_POST['form']['brandID']  &&  isset($_POST['form']['brandID'])  && !empty($_POST['form']['brandID']) && $_POST['form']['brandID']!='none')
        &&  ( is_array($_POST['form']) && is_numeric($_POST['form']['brandID'] ) ))
    && ($_REQUEST['mode']=='update')
    && $_POST['form']['newbrand ']){
    $_POST['mode']="save";
    $_REQUEST['mode']="save";
}
//---------------------------------------------------------------------------------
if(isset($_POST['brandID']) &&  isset($_POST['form']) &&  ($_POST['brandID'] && $_POST['brandID']!='none')
    &&  ( is_array($_POST['form']) && is_numeric($_POST['brandID'] ) )
    && ($_REQUEST['mode']=='update')
    && $_POST['form']['newbrand ']){

    /*	if($_POST['insert_forum']&& is_numeric($_POST['insert_forum']) ){
        unset($_POST['form']['insertID']);
        }*/
    if($_POST['brandID']){
        unset($_POST['brandID']);
    }
    unset($_POST['brandID']);
    unset($_POST['form']['brandID']);
    $_POST['form']['dynamic_ajx']=1;
    $_POST['mode']="save";
    $_REQUEST['mode']="save";
}

//---------------------------------------------------------------------------------
if(isset($_POST['brandID']) &&   ($_POST['brandID'] && $_POST['brandID']=='none')
    &&  ( is_array($_POST['form']) )
    &&  $_POST['brandID']==0
    && ($_REQUEST['mode']=='save')
    && $_POST['form']['newbrand ']){

    /*	if($_POST['insert_forum']&& is_numeric($_POST['insert_forum']) ){
        unset($_POST['form']['insertID']);
        }*/
    if($_POST['brandID'] || $_POST['brandID']==0){
        unset($_POST['brandID']);
    }
    if($_POST['form']['brandID']=='none'){
        unset($_POST['form']['brandID']);
    }
    unset($_POST['brandID']);
    unset($_POST['form']['brandID']);
    $_POST['form']['dynamic_ajx']=1;
    $_POST['mode']="save";
    $_REQUEST['mode']="save";
}

if(!empty($_POST['brandID']))  {
    $brandID=$_POST['brandID'];
    if(isset ($_POST["submitbutton3_$brandID"]))  {
        $_POST['mode']='take_data';
        unset($_REQUEST['mode']);
        $_REQUEST['mode']=$_POST['mode'];
    }
}
$_REQUEST['mode']  = isset( $_REQUEST['mode'] ) ? $_REQUEST['mode'] : 'default';
//---------------------------------------------------------------------------------
switch ($_REQUEST['mode'] ) {

    case "copy_files":

        global $db;
        $pdf_file= PDF_DIR; //PDF FILE LOCATION
        $jpgloc=PDF_DIR."page.jpg";// LOCATION TO PLACE EXTRACTED JPG FILES
        $brand=new brand();


        $src = "/home/alon/Desktop/PROJECT/4.4.17";
        $dst = PDF_DIR;
        $brand-> recurse_copy($src,$dst);

        $files = new RecursiveDirectoryIterator(PDF_DIR);
        $files->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($files);
        foreach ($files as $file) {


       if(pathinfo($file, PATHINFO_EXTENSION) == 'pdf'){


           $name = $file->getFilename();
           $file_name = explode('.',$name);
           $file_name = $file_name[0];
           $jpgloc2=CONVERT_PDF_TO_IMG_DIR."$file_name.jpg";
           if(!file_exists($jpgloc2)){
               $brand->convertPDF2JPG($file->getRealPath(), $jpgloc2);
           }

           $mime = "application/pdf";
           $data = file_get_contents(PDF_DIR.$name);
           $size = $file->getSize();


           $sql = "SELECT COUNT(*) FROM pdfs " .
               "WHERE pdfName='$name'";
           if ($db->querySingleItem($sql) > 0) {
               show_error_msg('כבר קיים PDF בשם הזה'.$name);
               ?>
               <script>
                 var name = <?php echo $name; ?>
                   $('#brand_error').append($('<p ID="bgchange" ><b style="color:blue;">'name +  כבר קיים PDF בשם הזה'!!!!!</b></p>\n' ));
                   $('#brand_error').append($('<p ID="bgchange" ><b style="color:blue;">'.$name.'</b></p>\n' ));
                   turn_red();
               </script>
               <?php
               //return -1;
           }else{
           $sql = "INSERT INTO pdfs (`pdfName` , `data`,`size`)VALUES ( " .
               $db->sql_string($name) . ", " .
               $db->sql_string($data) . ", " .
               $db->sql_string($size) . " ) " ;

               if(!$db->execute ($sql) ){
                   return false;
                }
               }
            }//end pdf files
        }
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

//-----------------------------------------------------------------------------



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
//        if ($publishersIDs = $brand->fetch_publisher($formdata)) {
//            if ($pdfIDS = $brand->fetch_pdf($formdata)) {
               // if($imgNams = $brand->convertPdfToImg($formdata) ){
                    //if ($brandIDS = $brand->update_brand($formdata)) {
                    if ($result = $brand->add_brand($formdata,$publishersIDs,$pdfIDS,$imgNams)) {
                        $db->execute("COMMIT");
                        return true;
//                    }
//                }
//            }
        }
        $db->execute("ROLLBACK");
        $formdata['fail'] = true;
        $formdata['dynamic_10'] = 1;
        show_list($formdata);
        return;
        break;
//-------------------------------------------------------------------------------
    case "read_decisions":
        if(is_numeric($_GET['read_decisions']) ){

            get_dec($_GET['read_decisions']);
        }
        break;
//---------------------------------------------------------------------------------
    case "read_decisions2":
        if(is_numeric($_GET['read_decisions2']) ){

            get_dec2($_GET['read_decisions2']);
        }
        break;
//---------------------------------------------------------------------------------
    case "read_decisions_multi":
        if(is_numeric($_GET['read_decisions_multi']) ){

            get_dec_multi($_GET['read_decisions_multi'],$_GET['count_form']);
        }
        break;
//---------------------------------------------------------------------------------
    case "read_decisions_multi2":
        if(is_numeric($_GET['read_decisions_multi2']) ){

            get_dec_multi2($_GET['read_decisions_multi2'],$_GET['count_form']);
        }
        break;
//---------------------------------------------------------------------------------
    case "read_users":
        if(is_numeric($_GET['read_users']) ){

            get_users($_GET['read_users']);
        }
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

    case  "read_data2":
        if( array_item($_POST, 'brandID') && count($_POST)==1 && !$_GET){
            $_REQUEST['editID']= array_item($_POST, 'brandID');
        }
        if($_REQUEST['editID']){
            $formdata =read_forum_ajx($_GET['editID']);
        }else{
            $formdata =read_forum_ajx($_GET['brandID']);
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

            if(isset($_POST['form']['dest_publisher'][0]) &&  $_POST['form']['dest_publisher'][0]== 'none')
                unset($_POST['form']['dest_publisher'][0] );

            if(isset($_POST['form']['dest_publisher']) &&  count($_POST['form']['dest_publisher'])==0  )
                unset($_POST['form']['dest_publisher'] );

            if(isset($_POST['form']['dest_publisher'][0]) &&  $_POST['form']['dest_publisher'][0]== 'none')
                unset($_POST['form']['dest_publisher'][0] );

            if(isset($_POST['form']['src_brandsType']) &&  count($_POST['form']['src_brandsType'])==0  )
                unset($_POST['form']['src_brandsType'] );


            if(isset($_POST['arr_dest_brandsType'][0]) && $_POST['arr_dest_brandsType'][0]== 'none')
                unset($_POST['arr_dest_brandsType'][0] );

            if(isset($_POST['arr_dest_brandsType']) &&  count($_POST['arr_dest_brandsType'])==0  )
                unset($_POST['arr_dest_brandsType'] );

//-----------------------------------------------------------------------
            if(isset($_POST['form']['dest_pdfs']) && $_POST['form']['dest_pdfs'][0]== 'none')
                unset($_POST['form']['dest_pdfs'][0] );

            if(!empty($_POST['form']['dest_pdfs']) && count($_POST['form']['dest_pdfs'])== 0  )
                unset($_POST['form']['dest_pdfs'] );

            if(!empty($_POST['form']['src_pdfs'][0]) &&  $_POST['form']['src_pdfs'][0]== 'none')
                unset($_POST['form']['src_pdfs'][0] );

            if(!empty($_POST['form']['src_pdfs']) && count($_POST['form']['src_pdfs'])==0  )
                unset($_POST['form']['src_pdfs'] );


            if(!empty($_POST['arr_dest_pdfs'][0]) && $_POST['arr_dest_pdfs'][0]== 'none')
                unset($_POST['arr_dest_pdfs'][0] );

            if(!empty($_POST['arr_dest_pdfs']) && count($_POST['arr_dest_pdfs'])==0  )
                unset($_POST['arr_dest_pdfs'] );
//-----------------------------------------------------------------------
            if(isset($_POST['form']['dest_pdfs']) && !$_POST['form']['dest_pdfs'] && $_POST['arr_dest_pdfs']){
                $formdata= isset($_POST['form']) ? $_POST['form'] : '';
                $formdata['dest_pdfs']= isset($_POST['arr_dest_pdfs']) ? $_POST['arr_dest_pdfs'] : '';
            }elseif(isset($_POST['form']['dest_pdfs']) &&  isset($_POST['form']['dest_pdfs'][0]) && $_POST['form']['dest_pdfs'] && is_numeric($_POST['form']['dest_pdfs'][0])){
//-----------------------------------------------------------------------
            }elseif(isset($_POST['form']['dest_pdfs']) && !is_numeric($_POST['form']['dest_pdfs'][0]
                    && ($_POST['form']['dest_pdfs'][0]=='none'))
                && ($_POST['form']['dest_pdfs'])
                &&  ($_POST['form']['dest_pdfs'][1])) {
                $dest_pdfs = isset($_POST['form']['dest_pdfs']) ? $_POST['form']['dest_pdfs'] : '';
                $i = 0;
                foreach ($dest_pdfs as $key => $val) {
                    if (is_numeric($val)) {
                        $array_num[] = $val;
                    } elseif (!is_numeric($val) && $val == 'none') {
                        unset($dest_pdfs[$i]);
                    } else
                        $vals[$key] = "'$val'";
                    $i++;
                }
            }
            $formdata = isset($_POST['form']) ? $_POST['form'] : false;


            if (array_item($_POST, 'arr_dest_pdfs'))
                $formdata['dest_pdfs'] = isset($_POST['arr_dest_pdfs']) ? $_POST['arr_dest_pdfs'] : '';
            if(array_item ($_POST,'arr_dest_publishers') )
                $formdata['dest_publishers'] = isset($_POST['arr_dest_publishers']) ? $_POST['arr_dest_publishers'] : '';
           if(isset($formdata['brand_date2'])) {
               list($year_date, $month_date, $day_date) = explode('-', $formdata['brand_date2']);
               if (strlen($year_date) > 3) {
                   $formdata['brand_date'] = "$year_date-$month_date-$day_date";
               }
           }
            if(!empty($_POST['insert_forum']) && is_numeric($_POST['insert_forum']) && !($_POST['insert_forum'] == 11)){
                $formdata['insert_forum'] = $_POST['insert_forum'];
                $formdata['insertID'] = $_POST['insert_forum'];
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
//                echo json_encode($formdata);
//                exit;
                //build_form($formdata);
                show_list($formdata);
                return true;
//----------------------------------------------------------------------
            }
        }

    case "realy_delete":

        real_del($_POST['form']);
        $showform=FALSE;


        break;
    /**********************************************************************************************/
    /*********************************************************************************************/
    case "clear":

        $brand =new brand();

        echo "<h1>הזן נתונים לפורום  </h1>";
        $brand->print_forum_paging();
        $formdata = isset($formdata) ? $formdata : '';
        show_list($formdata);
        //link1();
        break;
    /**********************************************************************************************/
    /********************************************************************************************/
    case "delete":
        if (($_GET['deleteID'])){
            $formdata['forum_demo_last8']=1;
            delete_forum($_GET['deleteID'],$formdata);//subcategories
        }else{
            $formdata['forum_demo_last8']=1;
            delete_forum($_POST['form']['brandID'],$formdata);
        }

        break;
    /**********************************************************************************************/
    /**********************************************************************************************/
    case "del_usrFrm":
        if (($_GET['userID']) &&  ($_GET['brandID']) )
            if(!delete_user_forum($_GET['userID'],$_GET['brandID']) ){
                show_error_msg("אין מספיק נתונים למחיקה");
            }else{
                read_forum($_GET['brandID']);
            }

        break;
    /**********************************************************************************************/

    case "take_data":

        if($_POST['form']){
            foreach($_POST['form']  as $key=>$val){
                if ($val=='none' || $val== "" )
                    unset ($_POST['form'][$key]);

            }

        }
        global $db;
        $brandID= $_POST['form']['brandID']?$_POST['form']['brandID']:$_POST['form'] ;

        /*********************************************************************************/
        if($_POST['form']["dest_pdfs$brandID"][0]== 'none')
            unset($_POST['form']["dest_pdfs$brandID"][0] );
        /********************************dest_pdfs*************************************************/
        if($_POST['form']['dest_pdfs'][0]== 'none')
            unset($_POST['form']['dest_pdfs'][0] );

        if(count($_POST['form']['dest_pdfs'])==0  )
            unset($_POST['form']['dest_pdfs'] );

        if($_POST['form']['src_pdfs'][0]== 'none')
            unset($_POST['form']['src_pdfs'][0] );

        if(count($_POST['form']['src_pdfs'])==0  )
            unset($_POST['form']['src_pdfs'] );


        if($_POST['arr_dest_pdfs'][0]== 'none')
            unset($_POST['arr_dest_pdfs'][0] );

        if(count($_POST['arr_dest_pdfs'])==0  )
            unset($_POST['arr_dest_pdfs'] );
        /********************************DEST_brandsTYPE*************************************************/
        if($_POST['form']['dest_brandsType'][0]== 'none')
            unset($_POST['form']['dest_brandsType'][0] );

        if(count($_POST['form']['dest_brandsType'])==0  )
            unset($_POST['form']['dest_brandsType'] );

        if($_POST['form']['src_brandsType'][0]== 'none')
            unset($_POST['form']['src_brandsType'][0] );

        if(count($_POST['form']['src_brandsType'])==0  )
            unset($_POST['form']['src_brandsType'] );


        if($_POST['arr_dest_brandsType'][0]== 'none')
            unset($_POST['arr_dest_brandsType'][0] );

        if(count($_POST['arr_dest_brandsType'])==0  )
            unset($_POST['arr_dest_brandsType'] );
        /********************************DEST_MANAGERSTYPE*************************************************/
        if($_POST['form']['dest_managersType'][0]== 'none')
            unset($_POST['form']['dest_managersType'][0] );

        if(count($_POST['form']['dest_managersType'])==0  )
            unset($_POST['form']['dest_managersType'] );

        if($_POST['form']['src_managersType'][0]== 'none')
            unset($_POST['form']['src_managersType'][0] );

        if(count($_POST['form']['src_managersType'])==0  )
            unset($_POST['form']['src_managersType'] );


        if($_POST['arr_dest_managersType'][0]== 'none')
            unset($_POST['arr_dest_managersType'][0] );

        if(count($_POST['arr_dest_managersType'])==0  )
            unset($_POST['arr_dest_managersType'] );
        /*********************************************************************************/

        /*********************************************************************************/
        if(!$_POST['form']['dest_pdfs'] && $_POST['arr_dest_pdfs']){
            $formdata=$_POST['form'];

            $staff=implode(',',$_POST['arr_dest_pdfs']);
            $sql="SELECT userID,full_name FROM users WHERE userID in($staff)";

            if($rows=$db->queryObjectArray($sql)){
                foreach($rows as $row){

                    $formdata["dest_pdfs"][$row->userID]=$row->full_name;
                }
                unset($formdata['arr_dest_pdfs']);
            }

        }elseif($_POST['form']['dest_pdfs'] && is_numeric($_POST['form']['dest_pdfs'][0])){

            $formdata=$_POST['form'];
            /**********************************************************************************/
        }elseif( !is_numeric($_POST['form']['dest_pdfs'][0])
            && ($_POST['form']['dest_pdfs'])
            &&  ($_POST['form']['dest_pdfs'][1])
            &&  (is_numeric($_POST['form']['dest_pdfs'][1]))  ){


            $dest_pdfs= $_POST['form']['dest_pdfs'];
            $i=0;
            foreach($dest_pdfs as $key => $val){
                if(is_numeric($val)){
                    $array_num[]=$val ;
                }elseif(!is_numeric($val) && $val=='none'){
                    unset($dest_pdfs[$i]);
                }else
                    $vals[$key] = "'$val'" ;
                $i++;
            }


            /*************************************************************************************/
            if($vals){
                $stuff = implode(", ", $vals);

                $sql="SELECT  userID,full_name FROM users where full_name in($stuff)";
                $rows=$db->queryObjectArray($sql);
                $dest_pdfs="";
                foreach($rows as $row){
                    $dest_pdfs[]=$row->userID;

                }



            }
            $formdata=$_POST['form'];

            if($array_num && !$dest_pdfs){
                $formdata['dest_user']=$array_num;

            }elseif(!$array_num && $dest_pdfs){
                $formdata['dest_pdfs']=$dest_pdfs;
                $size_dest=count($formdata['dest_pdfs']);
            }
            elseif($array_num && $dest_pdfs){
                $dest=array_merge($array_num,$dest_pdfs);
                $dest=array_unique($dest);
                $formdata['dest_pdfs'] = $dest;
            }

            /***************************************************************************************/
        }
        /*******************************************************************************************************/
        else{
            $formdata=$_POST['form'];
        }
        /********************************************************************************************/

        if($formdata['dest_pdfs'][0] && is_numeric($formdata['dest_pdfs'][0]) && is_array($formdata['dest_pdfs']) ){
            foreach($formdata['dest_pdfs'] as $key=>$val){

                $sql="SELECT full_name FROM users where userID =$val";
                if($rows=$db->queryObjectArray($sql))

                    $destNames[$val]=$rows[0]->full_name;

            }
            $formdata['dest_pdfs']=$destNames;
        }elseif($formdata['dest_pdfs'] && is_numeric($formdata['dest_pdfs'])  ){
            $destID=$formdata['dest_pdfs'] ;

            $sql="SELECT  userID,full_name FROM users where userID in($destID)";
            $rows=$db->queryObjectArray($sql);
            foreach($rows as $row){
                $destNames[$row->userID]=$row->full_name;
            }

            $brandID= $_POST['form']['brandID'] ;
            $formdata['dest_pdfs']=$formdata["dest_pdfs$brandID"];
            $formdata['dest_pdfs']=$destNames;

        }




        if(!array_item($formdata,'brandID') && array_item($_POST,'brandID')  && $_POST['brandID']!=null){
            $formdata['brandID']=array_item($_POST,'brandID');
        }


        if(!$_POST['form']['dest_brandsType'] && $_POST['arr_dest_brandsType']){

            $formdata['dest_brandsType']=$_POST['arr_dest_brandsType'];
        }

        if($_POST['form']['dest_brandsType'] && !$_POST['arr_dest_brandsType']){

            $formdata['dest_brandsType']=$_POST['form']['dest_brandsType'];
        }

        /*************************************MANAGERSTYPE****************************************************/
        if(!$_POST['form']['dest_managersType'] && $_POST['arr_dest_managersType']){

            $formdata['dest_managersType']=$_POST['arr_dest_managersType'];
        }

        if($_POST['form']['dest_managersType'] && !$_POST['arr_dest_managersType']){

            $formdata['dest_managersType']=$_POST['form']['dest_managersType'];
        }
        /******************************************************************************************/
        if($_POST['insert_forum'] && (is_numeric($_POST['insert_forum']) ) ){

            $formdata['insert_forum']=$_POST['insert_forum'];
        }else{
            $brandID=$formdata['brandID'];
            $sql="select parentForumID from brand where brandID=$brandID";
            if($rows=$db->queryObjectArray($sql) ){

                $formdata['insert_forum']=$rows[0]->parentForumID;
            }

        }
        /*****************************************************************************************/

        $db->execute("START TRANSACTION");
        /******************************************************/
        if(!$formdata=take_forum_data($formdata)){
            /*****************************************************/
            $db->execute("ROLLBACK");


            $formdata=$_POST['form'];
            /**********************************************************************************************************/
            if($formdata['src_managersType'] &&  is_array($formdata['src_managersType']) && (is_numeric ($formdata['src_managersType'][0])) ){
                unset($formdata['src_managersType']);
            }

            if($formdata['src_brandsType'] &&  is_array($formdata['src_brandsType']) && (is_numeric($formdata['src_brandsType'][0])) ){
                unset($formdata['src_brandsType']);
            }

            if($formdata['src_pdfs'] &&  is_array($formdata['src_pdfs']) && (is_numeric($formdata['src_pdfs'][0])) ){
                unset($formdata['src_pdfs']);
            }
            /**********************************************************************************************************/


            $formdata['brandID']=$_POST['form']['brandID'];
            $formdata['category']=$_POST['form']['category'];
            $formdata['appoint_forum']=$_POST['form']['appoint_forum'];
            $formdata['manager_forum']=$_POST['form']['manager_forum'];
            $formdata['managerType']=$_POST['form']['managerType'];
            //$formdata['appoint_date1']=$_POST['form']['appoint_date1'];
            //$formdata['manager_date']=$_POST['form']['manager_date'];



            if($_POST['form']['appoint_date1'] ){
                $formdata['appoint_date1']= $_POST['form']['appoint_date1']  ;
                list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['appoint_date1']);
                if(strlen($year_date)>3 ){
                    $formdata['appoint_date1']="$day_date-$month_date-$year_date";
                }
            }

            if($_POST['form']['manager_date']){
                $formdata['manager_date']= $_POST['form']['manager_date'] ;
                list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['manager_date']);
                if(strlen($year_date)>3){
                    $formdata['manager_date']="$day_date-$month_date-$year_date";
                }
            }


            if($_POST['form']['forum_date']){
                $formdata['forum_date']=$_POST['form']['forum_date'];
                list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
                if(strlen($year_date)>3 ){
                    $formdata['forum_date']="$day_date-$month_date-$year_date";
                }
            }



            if($_POST['arr_dest_brands']){
                $formdata['dest_brands']=$_POST['arr_dest_brandsType'];
            }

            if($_POST['arr_dest_managersType']){
                $formdata['dest_managersType']=$_POST['arr_dest_managersType'];
            }



//				$formdata['forum_date']=substr($_POST['form']['forum_date'],1,10);
//				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
//				if(strlen($year_date>3) )
//				$formdata['forum_date']="$day_date-$month_date-$year_date";



            if($formdata['dest_pdfs']){
                $i=0;
                foreach($formdata['dest_pdfs'] as $row){
                    $member_date="member_date$i";
                    $rows['full_date'][$i] =$formdata[$member_date];

                    $i++;
                }



                $i=0;
                foreach($rows['full_date'] as $row){

                    $member_date="member_date$i";
                    list($year_date,$month_date, $day_date) = explode('-',$row);
                    if(strlen($year_date)>3 ){
                        $formdata[$member_date]="$day_date-$month_date-$year_date";
                    }

                    $i++;
                }

                $formdata['fail']=true;
            }


            if(!$_POST['form']['dest_pdfs'] && $_POST['arr_dest_pdfs']){
                $formdata['dest_pdfs']=$_POST['arr_dest_pdfs'];
            }

            if($formdata['src_pdfs'] && $_POST['arr_dest_pdfs'] ){

                $i=0;
                foreach ($_POST['arr_dest_pdfs'] as $dst){
                    if($dst=='none')
                        unset ($_POST['arr_dest_pdfs'][$i]);
                    $i++;

                }

                $arr=implode(',',$_POST['arr_dest_pdfs'] );

                $sql="select userID,full_name from users where userID in($arr)";
                $rows=$db->queryObjectArray($sql);
                foreach ($rows as $row){
                    $dest[$row->userID]=$row->full_name;
                }

                $formdata['dest_pdfs']=$dest;//$_POST['arr_dest_pdfs'];


            }elseif($formdata['dest_pdfs']){// && $formdata['dest_pdfs'][0]!='none' && is_numeric($formdata['dest_pdfs'][0]) ){



                $dest_pdfs = $dest_pdfs ? $dest_pdfs:$formdata['dest_pdfs'];
                $i=0;
                foreach ($dest_pdfs as $dst){
                    if($dst=='none')
                        unset ($dest_pdfs[$i]);
                    $i++;

                }


                $arr=implode(',',$dest_pdfs  );

                $sql="select userID,full_name from users where userID in($arr)";
                $rows=$db->queryObjectArray($sql);
                foreach ($rows as $row){
                    $dest[$row->userID]=$row->full_name;
                }
                $formdata['dest_pdfs']=$dest;

            }
            if($formdata['brandID']&& $formdata['newbrand '])
                unset( $formdata['brandID']);

            //if(!$formdata['fail'])
            $formdata['fail']=true;
            $formdata['dynamic_10']=1;
            show_list($formdata);


            return;

        }
        /*************************************TO_AJAX**********************************************/
        else{
            /**********************************GET_DECISION************************************************/
            if($formdata['take_data']==1){

                $i=0;
                $brandID=$formdata['brandID'] ? $formdata['brandID']:$formdata['brandID'];


                if($formdata['dest_pdfs'] && is_array($formdata['dest_pdfs'])   ){

                    foreach($formdata['dest_pdfs'] as $key=>$val){
                        if(is_numeric($key)){
                            $sql="select HireDate  from rel_user_forum where userID=$key and brandID=$brandID  ";
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
            }
            /**********************************************************************************************/
            $brandID=$formdata['brandID'];
            $sql="SELECT d.decID,d.decName 
	         FROM decisions d 
	         left join rel_brand rf on d.decID=rf.decID
	         WHERE rf.brandID=$brandID";
            if($rows  = $db->queryObjectArray($sql) ){

                $formdata["decision"]=$rows;
            }
            /******************************************************************************************/
            $i=0;
            if($formdata['dest_pdfs'] && is_array($formdata['dest_pdfs']) && is_array($dest_pdfs)){

                foreach($dest_pdfs as $key=>$val){
                    if(is_numeric($val)){
                        $sql="select userID,full_name  from users where userID=$val";
                        if($rows=$db->queryObjectArray($sql)){

                            $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                            $i++;

                        }
                    }


                }



                $formdata["dest_user"]=$results;
            }elseif($formdata['dest_pdfs'] && is_array($formdata['dest_pdfs'])   ){

                foreach($formdata['dest_pdfs'] as $key=>$val){
                    if(is_numeric($key)){
                        $sql="select userID,full_name  from users where userID=$key";
                        if($rows=$db->queryObjectArray($sql)){

                            $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                            $i++;

                        }
                    }


                }

                $formdata["dest_user"]=$results;
            }

            /**********************************************************************************************************************/
//for check the length
            $i=0;
            if($formdata['src_pdfsID'] && is_array($formdata['src_pdfsID'])   ){

                foreach($formdata['src_pdfsID'] as $key=>$val){

                    $sql="select userID,full_name  from users where userID=$val";
                    if($rows=$db->queryObjectArray($sql)){

                        $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                        $i++;

                    }


                }
                $formdata["src_user"]=$results1;
            }else{
                $formdata["src_user"]=$formdata["dest_user"];
            }
            /***********************************************************************/
            /***********************brandsTYPE**********************************************/
            $i=0;
            if($formdata['dest_brandsType'] && is_array($formdata['dest_brandsType'])  ){

                foreach($formdata['dest_brandsType'] as $key=>$val){
                    if(is_numeric($val)){
                        $sql="select catID,catName  from categories1 where catID=$val";
                        if($rows=$db->queryObjectArray($sql)){

                            $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);


                            $i++;

                        }
                    }


                }
                $formdata['dest_brandsType']=$results_cat_frm;
            }
            /*************************************MANAGER_TYPE*****************************************************************/

            $i=0;
            if($formdata['dest_managersType'] && is_array($formdata['dest_managersType'])  ){

                foreach($formdata['dest_managersType'] as $key=>$val){
                    if(is_numeric($val)){
                        $sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
                        if($rows=$db->queryObjectArray($sql)){

                            $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);


                            $i++;

                        }
                    }


                }
                $formdata['dest_managersType']=$results_cat_mgr;
            }
            /******************************************************************************************************/


            $manageID=$formdata['manager_forum'];
            $sql="select managerName from managers where managerID=$manageID";
            if($rows=$db->queryObjectArray($sql)){
                $formdata['managerName']=$rows[0]->managerName;
            }
            /**********************************************************************/
            $appID=$formdata['appoint_forum'];
            $sql="select appointName from appoint_forum where appointID=$appID";
            if($rows=$db->queryObjectArray($sql)){
                $formdata['appointName']=$rows[0]->appointName;
            }
            /**********************************************************************/
            unset($_POST['form']['multi_year']);
            unset($_POST['form']['multi_month']);
            unset($_POST['form']['multi_day']);
            unset($formdata['multi_year']);
            unset($formdata['multi_month']);
            unset($formdata['multi_day']);
            $formdata['multi_year'][0]='none';
            $formdata['multi_month'][0]='none';
            $formdata['multi_day'][0]='none';

            /******************************************************/
            $sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
            if( 	$rows = $db->queryObjectArray($sql)){

                foreach($rows as $row) {
                    $subcatsftype[$row->parentCatID][] = $row->catID;
                    $catNamesftype[$row->catID] = $row->catName; }

                $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);

                $formdata['frmType']=$rows;
            }


            /*****************************************************/
            $db->execute("COMMIT");


            $formdata['type'] = 'success';
            $formdata['message'] = 'עודכן בהצלחה!';
            echo json_encode($formdata);
            exit;


        }

        break;
    /***************************************************************************************************/

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

/***************************************GET_DEC_FOR_THE_TREE_VIEW*******************************************************/
function   get_dec($brandID){
    $brand=new brand();
    $brand->restore_tree($brandID);
}
/***************************************GET_DEC2_FOR_THE_TREE_VIEW*******************************************************/
function   get_dec2($brandID){
    $brand=new brand();
    $brand->restore_tree_2($brandID);
}


/***************************************GET_DEC_FOR_THE_TREE_VIEW_MULTI*******************************************************/
function   get_dec_multi($brandID,$count_form=""){
    $brand=new brand();
    $brand->restore_tree2($brandID,$count_form);
}
/*********************************************************************************************/
function   get_dec_multi2($brandID,$count_form=""){
    $brand=new brand();
    $brand->restore_tree_win($brandID,$count_form);
}
/*********************************************************************************************/




function get_users($brandID){
    global $db;


    if(array_item($_SESSION, 'level')=='user'){
        $flag_level=0;
        $level=false;
        ?>
        <div style="float:left"><span id="msg" onClick="toggleMsgDetails()"></span><div id="msgdetails"></div></div>
        <input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" />
        <?php
    }else{
        $level=true;
        $flag_level=1;

        ?>
        <input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level;?>" />
        <?php

    }




    $getUser_sql	=	"SELECT u.userID,u.full_name,r.HireDate FROM users u 
                     inner join rel_user_forum r  
                     on u.userID = r.userID              
                     WHERE r.brandID = $brandID
                     ORDER BY u.full_name ASC";

    if($rows=$db->queryObjectArray($getUser_sql) ){

        $formdata=Array();

        $i=0;
        foreach($rows as $row){
            $sql="select active,userID  from rel_user_forum where userID=$row->userID and brandID=$brandID ";
            if($rows_active=$db->queryObjectArray($sql)){

                $formdata['active'][$row->userID]=$rows_active[0]->active;

            }
            $i++;
        }





        $i=0;


        echo '<table  id="my_table" style="overflow:auto;width:80%;">';




        /***************************************************/
        foreach($rows as $row){
            /**************************************************/
            $li_id="my_li$i";
            $tr_id="my_tr$i$row->userID $row->brandID;";
            $member_date="member_date$i"  ;

            $gif_num='';



            if( $formdata["active"][$row->userID] && ($formdata["active"][$row->userID]==2) )
                $gif_num=1;
            else
                $gif_num=0;
            ?>

        <tr class="my_tr"  id="<?php echo $tr_id ?>">


            <td width="16"  id="my_active<?php echo $row->userID; echo $brandID;?>">
                <a href="javascript:void(0)" onclick="edit_active(<?php echo $row->userID;?>,<?php echo $brandID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo $formdata["active"][$row->userID] ;?>); return false;">
                    <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php echo $gif_num; ?>.gif" width="16" height="10" alt="" border="0" />
                </a>
            </td>




            <td>

            <?php


            $name=$row->full_name;
            form_label1("חבר פורום:");
            form_text_a("member", $name ,  20, 50, 1);

            if(($level)){
                ?>
                <!-- <input type="button"  class="mybutton"  id="my_button_<?php echo $row->userID;?>"  value="ערוך משתמש" onClick="return editUser_frmID(<?php echo $row->userID;;?>,<?php echo $brandID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo "' $i '";?>);" ; return false; />-->
                <input type="button"  class="mybutton"  id="my_button_<?php echo $row->userID;?>"  value="ערוך מישתמש"  onClick="return editUser3(<?php echo $row->userID;?>,<?php echo $brandID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo "' $i '";?>);" return false; />
            <?php }elseif(!($level)){?>
                <input type="button"  class="mybutton"  id="my_button_<?php echo $row->userID;?>"  value="צפה בפרטי המישתמש"  onClick="return editUser3(<?php echo $row->userID;?>,<?php echo $brandID;?>,<?php echo " '".ROOT_WWW."/admin/' "; ?>,<?php echo "' $i '";?>);" return false; />
            <?php }?>


            <script  language="JavaScript" type="text/javascript">

                $(document).ready(function(){
                    $("#<?php echo $member_date; ?>").datepicker( $.extend({}, {showOn: 'button',
                        buttonImage: '<?php echo IMAGES_DIR ;?>/calendar.gif', buttonImageOnly: true,
                        changeMonth: true,
                        changeYear: true,
                        showButtonPanel: true,
                        buttonText: "Open date picker",
                        dateFormat: 'yy-mm-dd',
                        altField: '#actualDate'}, $.datepicker.regional['he']));
                });
            </script>
            <?php



            list($year_date,$month_date, $day_date) = explode('-',$formdata[$member_date]);
            if(strlen($day_date)==4 ){
                $formdata[$member_date]="$year_date-$month_date-$day_date";
            }elseif(strlen($year_date)==4){
                $formdata[$member_date]="$day_date-$month_date-$year_date";
            }

            form_label1("תאריך צרוף לפורום:");
            form_text3 ("$member_date",$row->HireDate  ,  10, 50, 1,$member_date );

            echo '</td>';
            echo '</tr>';

            $i++;

        }//end foreach

        echo '</table>';
    }
    return true;
}//end get_users
//-----------------------------------------------------------------
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

        if(isset($formdata['insert_forum']) && !is_numeric($formdata['insert_forum'])){
        $formdata['insertID'] = isset($formselect['parentBrandID']) ? $formselect['parentBrandID'] : '11';
        }elseif(isset($formdata['insert_forum']) && is_numeric($formdata['insert_forum'])){
            $formdata['insertID'] = $formdata['insert_forum'];
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
       /// $formdata['pages'] = isset( $formselect['pages']) ?  $formselect['pages'] :'';




        if (array_item($formdata, "dest_pdfs")) {
            $pdfIDS = $formdata["dest_pdfs"];
        }
        if (array_item($formdata, "dest_publishers")) {
            $pubIDs = $formdata["dest_publishers"];
        }
        if ($brand->validate_data_ajx($formdata, $pdfIDS, $brand_date, $insertID = "", $formselect)) {

          //  $db->execute("START TRANSACTION");
//          if(empty($pubIDs)) {
//              $pubIDs = $brand->fetch_publisher($formdata);
//          }
//          if(empty($pdfIDS)){
//            if ($pdfIDS = $brand->fetch_pdf($formdata)) ;
//          }
 //         if!empty($pdfIDS) && !empty($pubIDs) ){
//                    if ($imgNames = $brand->convertPdfToImg($formdata)) {
//-----------------------------------------------------------
//                        if ($result = $brand->update_brand1($formdata, $formselect, $pdfIDS, $pubIDs)) {
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
                          //  $db->execute("ROLLBACK");
                            echo "נכשל בעדכון";
                            return false;
                        }
//----------------------------------------------------------
                    }
               }
         //  }
//
//        }
//    }
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
                    if ($forum_decID=$brand->add_brand($formdata,$publishersIDs,$pdfIDS,$imgNams)) {
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
//---------------------------------------------------------------------------------------------------------
function take_forum_data($formdata){

    global $db;
    $brand=new brand();//($formdata);
    $formdata['dynamic_10']=1;
    $formdata['take_data']=1;
    $formselect=$brand->read_forum_data($formdata['brandID']);
    if($formselect['src_pdfs'] && $formselect['src_pdfs']!=null
        && $formselect['src_pdfsID'] && $formselect['src_pdfsID']!=null  ){


        $formdata['src_pdfs']= explode(',',$formselect['src_pdfs']);

        $formdata['src_pdfsID']= explode(',',$formselect['src_pdfsID']);

        $formdata['date_src_pdfs']= explode(',',$formselect['date_users']);
    }else{
        unset($formdata[src_pdfs]);
        unset($formdata[src_pdfsID]);
    }

    /********************************************************************************************/
    $formdata['src_brandsType']= explode(',',$formselect['src_brandsType']);

    $formdata['src_managersType']= explode(',',$formselect['src_managersType']);

    /******************************************************************************************/
    $formdata['brandID']= $formdata['brandID'];
    $brandID=$formdata['brandID'];
    $formdata['insertID']=$formselect['parentForumID'];
    $formdata['brandName']=$formselect['brandName'];
    /*****************************************************************************************/
    $dates = getdate();
    $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
    $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);

    $today= $brand->build_date5($dates);
    $formdata['today']=$today['full_date'];

    $brand->config_date($formdata);

    $dateIDs=$brand->build_date($formdata) ;//users_date=>multi
    $dateIDs=$dateIDs['full_date'];

    $brand_date=$formdata['forum_date'];
    $date_usr = $formdata['today'];

    /***************************************************************************************************/
    if(array_item($formdata,"dest_pdfs")){

        $usersIDs=$formdata["dest_pdfs"];
    }
    /******************************************************************************************/
    if(array_item($formdata,"dest_pdfs")){
        $i=0;
        foreach($formdata['dest_pdfs'] as $key=>$val){
            $sql="select active  from rel_user_forum where userID=$key and brandID=$brandID ";
            if($rows=$db->queryObjectArray($sql)){

                $formdata['active'][$key]=$rows[0]->active;
                $i++;
            }
        }
    }

    /**************************************************************************************/
    if($brand->validate_data_ajx($formdata,$dateIDs,$brand_date) ){
        return $formdata;

    }

    return false;
}

/*********************************************************************************************************************/

function delete_forum($deleteID,$formdata=''){
    $brand=new brand();
    $brand->del_brand($deleteID);
//	$brand->print_forum_paging();

    show_list($formdata);
}
/************************************************************************************************/
function insert_forum($insertID,$submitbutton,$subcategories){
    $brand=new brand();

    $brand->set($insertID,$submitbutton,$subcategories);
    $insertID=$_GET['insertID'];
    $brandID= isset($_GET['brandID']) ? $_GET['brandID'] : '';
    if(is_numeric($brandID)){
        $formdata=$brand->read_forum_data($brandID);
    }else{
        //$brand->add_forum($formdata,$userIDs,$catIDs,$dateIDs);
        $formdata['insertID']=$insertID  ;



//        $formdata['year_date']=  $_SESSION['year_date'];
//        $formdata['month_date']= $_SESSION['month_date'];
//        $formdata['day_date']=   $_SESSION['day_date'];
//        $dates = getdate();
//        $formdata['year_date']=$dates['year'];
//        $formdata['month_date']=$dates['mon'];
//        $formdata['day_date']=$dates['mday'];
        $formdata['forum_demo_last8']=1;
    }
    //$brand->print_forum_entry_form1_b($insertID);
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
//	$brand->link_div();
    $brand->print_forum_paging_b();
    build_form($formdata);



}
/****************************************************************************/
function  show_list_fail($formdata=""){
    $brand=new brand();

    build_form($formdata);
    $brand->print_forum_paging_b();

}
/****************************************************************************/

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
//    if(isset($formdata['src_pdfs'])){
//        $stuff = $formdata['src_pdfs'];
//        //$stuff_a = $formdata['src_pdfs'];
//        $stuff_a ='';
//        $stuff_b=explode(',',$formdata['src_pdfs']);
//        $i=0;
//
//        foreach($stuff_b as $pdfName){
//            if($i==0){
//                $stuff_a = "  '" . $db->getMysqli()->real_escape_string($pdfName). "'";
//            }else{
//                $stuff_a .= "," .  "  '" . $db->getMysqli()->real_escape_string($pdfName). "'";
//            }
//            $i++;
//        }
//        $sql="SELECT * FROM pdfs where pdfName in  ($stuff_a) ORDER BY pdfID";
//        if($rows=$db->queryObjectArray ($sql) ){
//            foreach($rows as $row)
//                $dst[$row->pdfID]=$row->pdfName;
//
//            $formdata['dest_pdfs']=$dst;
//        }
//    }
    /*******************************************************************************************/
//    $i=0;
//    $num=$editID ;
//    if(isset($formdata['dest_pdfs']) && isset($formdata['src_pdfs']) && $formdata['dest_pdfs'] && is_array($formdata['dest_pdfs'])   ){
//        foreach($formdata['dest_pdfs'] as $key=>$val){
//            if(is_numeric($key)){
//                $sql="select HireDate  from rel_user_forum where userID=$key and brandID=$editID ";
//                if($rows1=$db->queryObjectArray($sql)){
//
//                    $rows1[0]->HireDate=substr($rows1[0]->HireDate,0,10);
//
//                    list($year_date,$month_date, $day_date) = explode('-',$rows1[0]->HireDate);
//                    if(strlen($year_date)==4 ){
//                        $rows1[0]->HireDate="$day_date-$month_date-$year_date";
//                    }elseif(strlen($day_date)==4){
//                        $rows1[0]->HireDate="$year_date-$month_date-$day_date";
//                    }
//
//
//                    $member_date="member_date$i"  ;
//                    $formdata[$member_date]=$rows1[0]->HireDate;
//
//                }
//                $i++;
//            }
//
//        }
//        $i=0;
//        foreach($formdata['dest_pdfs'] as $key=>$val){
//            $sql="select active  from rel_user_forum where userID=$key and brandID=$editID ";
//            if($rows=$db->queryObjectArray($sql)){
//
//                $formdata['active'][$key]=$rows[0]->active;
//                $i++;
//            }
//        }
//    }
    /********************************************************************************************/

    //$brand->link_div();

    $brandID=$formdata['brandID'];
  //  $brand->message_update_b($formdata,$brandID);
    $formdata['brandID'] = $brandID;

    $brand->print_forum_paging_b();
//    build_form_ajx7($formdata);
    build_form($formdata);


    return  TRUE;

}

/******************************************************************************/


function read_forum_ajx($editID){
    global $db;
    $brand=new brand();

    if($_REQUEST['editID']){
        if(($editID =$brand->array_item($_REQUEST, 'editID')) && is_numeric($editID)){
            $formdata =$brand->read_forum_data1($editID);
        }
    }else{
        if(($editID =$brand->array_item($_REQUEST, 'brandID')) && is_numeric($editID)){
            $formdata =$brand->read_forum_data1($editID);
        }
    }
    if($formdata['src_pdfs']){
        $stuff = $formdata['src_pdfs'];

        /*****************************************************************/
        $stuff_b=explode(',',$formdata['src_pdfs']);
        $i=0;

        foreach($stuff_b as $usr_name){
            if($i==0){
                $stuff_a = "  '" . $db->getMysqli()->real_escape_string($usr_name). "'";
            }else{
                $stuff_a .= "," .  "  '" . $db->getMysqli()->real_escape_string($usr_name). "'";
            }
            $i++;
        }

        /*******************************************************************/



        $sql="SELECT  userID,full_name FROM users where full_name in($stuff_a) ORDER BY userID";
        $rows=$db->queryObjectArray($sql);

        foreach($rows as $row)
            $dst[$row->userID]=$row->full_name;

        $formdata['dest_pdfs']=$dst;
    }

    /*******************************************************************************************/

    $i=0;
    $num=$editID ;
    if($formdata['dest_pdfs'] && is_array($formdata['dest_pdfs'])   ){
        foreach($formdata['dest_pdfs'] as $key=>$val){
            if(is_numeric($key)){
                $sql="select HireDate  from rel_user_forum where userID=$key and brandID=$editID ";
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
                }
                $i++;
            }

        }

    }


    /**********************************GET_DECISION************************************************/
    $brandID=$formdata['brandID'];
    $sql="SELECT d.decID,d.decName 
	         FROM decisions d 
	       left join rel_brand rf on d.decID=rf.decID
	       WHERE rf.brandID=$brandID";
    // left join brand f on f.brandID


    if($rows  = $db->queryObjectArray($sql) ){

        $formdata["decision"]=$rows;
    }
    /******************************************************************************************/
    $i=0;
    if($formdata['dest_pdfs'] && is_array($formdata['dest_pdfs']) && is_array($dest_pdfs)){

        foreach($dest_pdfs as $key=>$val){
            if(is_numeric($val)){
                $sql="select userID,full_name  from users where userID=$val";
                if($rows=$db->queryObjectArray($sql)){

                    $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                    $i++;

                }
            }


        }



        $formdata["dest_user"]=$results;
    }elseif($formdata['dest_pdfs'] && is_array($formdata['dest_pdfs'])   ){

        foreach($formdata['dest_pdfs'] as $key=>$val){
            if(is_numeric($key)){
                $sql="select userID,full_name  from users where userID=$key";
                if($rows=$db->queryObjectArray($sql)){

                    $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                    $i++;

                }
            }


        }

        $formdata["dest_user"]=$results;
        $formdata["dest_pdfs"]=$results;
    }

    /**********************************************************************************************************************/
//for check the length
    $i=0;
    if($formdata['src_pdfsID'] && is_array($formdata['src_pdfsID'])   ){

        foreach($formdata['src_pdfsID'] as $key=>$val){

            $sql="select userID,full_name  from users where userID=$val";
            if($rows=$db->queryObjectArray($sql)){

                $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                $i++;

            }


        }
        $formdata["src_user"]=$results1;
    }else{
        $formdata["src_user"]=$formdata["dest_user"];
    }
    /***********************************************************************/
    /***********************brandsTYPE**********************************************/
    $i=0;
    if($formdata['dest_brandsType'] && is_array($formdata['dest_brandsType'])  ){

        foreach($formdata['dest_brandsType'] as $key=>$val){
            if(is_numeric($val)){
                $sql="select catID,catName  from categories1 where catID=$val";
                if($rows=$db->queryObjectArray($sql)){

                    $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);


                    $i++;

                }
            }


        }
        $formdata['dest_brandsType']=$results_cat_frm;
    }
    /*************************************MANAGER_TYPE*****************************************************************/

    $i=0;
    if($formdata['dest_managersType'] && is_array($formdata['dest_managersType'])  ){

        foreach($formdata['dest_managersType'] as $key=>$val){
            if(is_numeric($val)){
                $sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
                if($rows=$db->queryObjectArray($sql)){

                    $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);


                    $i++;

                }
            }


        }
        $formdata['dest_managersType']=$results_cat_mgr;
    }
    /******************************************************************************************************/


    $manageID=$formdata['manager_forum'];
    $sql="select managerName from managers where managerID=$manageID";
    if($rows=$db->queryObjectArray($sql)){
        $formdata['managerName']=$rows[0]->managerName;
    }
    /**********************************************************************/
    $appID=$formdata['appoint_forum'];
    $sql="select appointName from appoint_forum where appointID=$appID";
    if($rows=$db->queryObjectArray($sql)){
        $formdata['appointName']=$rows[0]->appointName;
    }
    /**********************************************************************/

    unset($formdata['multi_year']);
    unset($formdata['multi_month']);
    unset($formdata['multi_day']);
    $formdata['multi_year'][0]='none';
    $formdata['multi_month'][0]='none';
    $formdata['multi_day'][0]='none';

    $t = array();
    $t['formdata'][]=$formdata;


    $formdata['type'] = 'success';
    $formdata['message'] = 'עודכן בהצלחה!';
//     echo json_encode($formdata);
    echo json_encode($t);
    exit;


}


/******************************************************************************/

function read_forum2($editID){
    global $db;
    $brand=new brand();

    if(is_numeric($editID)){
        $formselect =$brand->read_forum_data2($editID);
        $dest_pdfs=$formselect['dest_pdfs'];
        $dest_pdfs=explode(";",$dest_pdfs);
        $formdata['dest_pdfs']=$dest_pdfs;
    }

    return  $dest_pdfs;
}

/******************************************************************************/
function read_befor_link($formdata){
    global $db;
    $dec=new forum();

    $dec->link();
    $dec->print_form2($formdata['brandID'] );



    return true;
}

/******************************************************************************/
function read_link($formdata){
    global $db;
    $brand=new brand();
    $formdata=$brand->read_forum_data3($formdata['brandID'],$formdata['insertID']);


    $brand->link();

    return $formdata;

}


/************************************************************************************************/

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
    //  show_list();
    //$brand->print_forum_paging_b();


//	$brand->link_div();

//	$brandID=$formdata['brandID'];
//	
//	$formdata['brandID']=$brandID;


    build_form($formdata);

    $brand->print_forum_paging_b();
    return  TRUE;




}

/******************************************************************************/

/***********************************************************************/
function  delete_dec_form ($formdata){
    $dec=new brand();

    if(array_item($formdata, "btnClear"))
        // clear form
        $formdata = FALSE;

    elseif(array_item($formdata, "btnDelete")) {
        // ask, if really delete
        if($dec->build_delete_form($formdata))
            $showform=FALSE; }

    return true;
}
/***********************************************************************/
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
/***********************************************************************/
function link1(){
    $brand=new brand();
    $brand->print_form();

    return true;
}
/****************************************************************************/

function update_to_parent($brandID ,$insertID){
    $brand=new brand();
    $brand->update_parent($insertID,$brandID);
}
/***************************************************************************/
function delete_user_forum($usrID,$brandID){
    $brand=new brand;
    $brand->del_usr_frm($usrID,$brandID);
    return true;
}
$brand=new brand;
$brand ->html_footer();
//----------------------------------------------------------------------------









?>