<?php
session_start();
  require_once ("../config/application.php");
  require_once(LIB_DIR.'/model/class.default.php');
  require_once(LIB_DIR.'/model/en.php');
  require_once(LIB_DIR.'/model/digiBook.php');
  set_error_handler('myErrorHandler');
  set_exception_handler('myExceptionHandler');
  global $lang;
  global $db;


if(isset($_GET['flag_level'] )){
    $level = $_GET['flag_level'];
}

    if(isset($_GET['brandName'] ) && !($_GET['brandName'] == 'none') ) {
    $brandID = $_GET['brandName'];
    $sql = "SELECT * FROM brands WHERE brandID = $brandID";
    if( $rows = $db->queryObjectArray($sql)) {
        $brandPrefix = $rows[0]->brandPrefix;
        $brandID =    $rows[0]->brandID ;
        $brand_date = $rows[0]->brand_date;
        $page_num =  $rows[0]->numPage ;
//-----------------------------------------------------------------
        $sql = "SELECT * FROM pdfs ORDER BY date_created DESC";
        if( $rows = $db->queryObjectArray($sql)) {
            $pdf_names = array();
            foreach($rows as $row){
                $pdf_names[] = $row-> pdfName;;
            }
        }

        $brand_sql = "SELECT b.*,c.* FROM brands b
                        inner join categories c  
                        on b.catID = c.catID              
                        WHERE b.brandID = $brandID
                        ORDER BY b.brandName ASC";
        $rows3 = $db->queryObjectArray($brand_sql);
//---------------------------------------------------------------------------------
        //  hayom{{date}}p{{page}}.
        $dayOfWeek = date("l", strtotime($brand_date));
//---------------------------------------------------------------------------------
        switch ($dayOfWeek ) {
            case "Sunday":
                $dayOfWeek = "7";
                break;
            case "Monday":
                $dayOfWeek = "1";
                break;

            case "Tuesday":
                $dayOfWeek = "2";
                break;
            case "Wednesday":
                $dayOfWeek = "3";
                break;
            case "Thursday":
                $dayOfWeek = "4";
                break;
            case "Friday":
                $dayOfWeek = "5";
                break;
            case "Saturday":
                $dayOfWeek = "6";
                break;
            default:
            case "":
                break;
        }




        if(isset($brandPrefix))
        $tmpPrefix = $brandPrefix;
        if(isset($rows3[0]->catName))
        if($rows3[0]->catName == "חדשות"){
            $brandPrefix =  str_replace("{{date}}", $dayOfWeek , $brandPrefix);
        }
        $brandPrefixArr = array();
        $html = '';
       // $html .= '<div class="" id="display_div" >';
        $html .= '<input type="hidden" name="my_brand_date"  id="my_brand_date"  value=' . $brand_date . ' >';
        $html .= '<input type="hidden" name="my_pageNum"  id="my_pageNum"  value=' . $page_num . ' >';
        if(isset($page_num) && is_numeric($page_num)) {
            for ($k = 0, $i = 0; $i < $page_num; $i++) {
                $m = $i + 1;
                if ($m < 10) {
                    $brandPrefixArr[$i] = $brandPrefix . "p00" . $m . ".pdf";
                } elseif ($m < 100 && $m >= 10) {
                    $brandPrefixArr[$i] = $brandPrefix . "p0" . $m . ".pdf";
                } elseif ($m >= 100) {
                    $brandPrefixArr[$i] = $brandPrefix . "p" . $m . ".pdf";
                }
//------------------------------------------------------------------------------

                $new_name = explode('.pdf', $brandPrefixArr[$i]);
                $new_name = $new_name[0];
                $new_name = $new_name . '_new.pdf';

                if ($tmpPrefix == "ayom{{date}}") {

                    if (empty($pdf_names) || (!(in_array($brandPrefixArr[$i], $pdf_names)) && !(in_array($new_name, $pdf_names)))) {
                        $html .= '<div class="col-xs-3"   style="margin-top: 50px;" >';
                        $html .= "<div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;background: grey;\">
                                                    <div id='my_pdfs_$i'>
                                                        <h4>
                                                             <a class='my_href_li' href=\"#\">
                                                             </a>
                                                         </h4>
                                                      </div>
                                                      
                                                      </div>\n";
                        $html .= '<br/></div>';
                    } else {
                        foreach ($rows as $row) {
                            if ($brandPrefixArr[$i] == $row->pdfName || $new_name == $row->pdfName) {

                                $file_name = explode('.', $row->pdfName);
                                $file_name = $file_name[0];
                                $tmp_name = $file_name;
                                $file_name = $file_name . '.jpg';
                                $html .= '<div class="col-xs-3">';
                                $html .= "({$row->size}kb) <p  style='font-weight:bold;color:brown;'>{$row->pdfName}</p><div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;\">";

                                if ($level) {
                                    if ($row->isChange == 'unchange') {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled checked >
                                                          </div>";
                                        $k++;
                                    } else {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled  >
                                                          </div>";
                                    }
                                } else {
                                    if ($row->isChange == 'unchange') {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' checked >
                                                        </div>";
                                        $k++;
                                    } else {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;'  >
                                                        </div>";
                                    }
                                }
                                $pdf_name = explode('.pdf', $row->pdfName);
                                $pdf_name = $pdf_name[0];

                                $html .= "<div >
                                                <div  id='my_pdfs{$pdf_name}'>
                                                <a class='my_href_li' href= '" . PDF_WWW_DIR . "{$row->pdfName}' >
                                                    <img src ='" . CONVERT_PDF_TO_IMG_WWW_DIR . "/{$file_name}' style='box-sizing: border-box;widht:100%; height: 297px;margin-top:-28px;' >
                                                </a>
                                           </div>
                                      </div>
                                    </div>\n";
                                $html .= '<br/>
                                   </div>';
                                //change status will be highlighting
                                if (($new_name == $row->pdfName && !($row->isChange == 'unchange')) || ($brandPrefixArr[$i] == $row->pdfName && !($row->isChange == 'unchange'))) {
                                    ?>
                                    <input type="hidden" name="modify_elem" class="modify_elem" value="modify">
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var brand_name = '<?php echo $pdf_name; ?>';
                                            $('#my_pdfs' + brand_name).addClass('my_task change_elem');
                                            turn_red_task();
                                        });
                                    </script>
                                    <?PHP
                                }
                                break;
                            }
                        }//end foreach
                    }
                } //-----------------------------------------------------------------------------------
                elseif ($brandPrefix == "ispo1" || $brandPrefix == "issh1") {
                    if (empty($pdf_names) || (!(in_array($brandPrefixArr[$i], $pdf_names)) && !(in_array($new_name, $pdf_names)))) {
                        $html .= '<div class="col-xs-3" id=""  style="margin-top: 50px;" >';
                        $html .= "<div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;background: grey;\">
                                                    <div id='my_pdfs_$i'>
                                                        <h4>
                                                             <a class='my_href_li' href=\"#\">
                                                             </a>
                                                         </h4>
                                                      </div>

                                                      </div>\n";
                        $html .= '<br/></div>';
                    } //------------------------------------------------------------------------------
                    else {
                        foreach ($rows as $row) {
                            if ($brandPrefixArr[$i] == $row->pdfName || $new_name == $row->pdfName) {
                                $file_name = explode('.', $row->pdfName);
                                $file_name = $file_name[0];
                                $tmp_name = $file_name;
                                $file_name = $file_name . '.jpg';
                                $html .= '<div class="col-xs-3">';
                                $html .= "({$row->size}kb) <p  style='font-weight:bold;color:brown;'>{$row->pdfName}</p><div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;\">";

                                if ($level) {
                                    if ($row->isChange == 'unchange') {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled checked >
                                                          </div>";
                                        $k++;
                                    } else {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled  >
                                                          </div>";
                                    }
                                } else {
                                    if ($row->isChange == 'unchange') {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' checked >
                                                        </div>";
                                        $k++;
                                    } else {
                                        $html .= "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;'  >
                                                        </div>";
                                    }
                                }
                                $pdf_name = explode('.pdf', $row->pdfName);
                                $pdf_name = $pdf_name[0];
                                $html .= "<div >
                                                <div   id='my_pdfs{$pdf_name}'>
                                                <a class='my_href_li' href= '" . PDF_WWW_DIR . "{$row->pdfName}' >
                                                    <img src ='" . CONVERT_PDF_TO_IMG_WWW_DIR . "/{$file_name}' style='box-sizing: border-box;widht:100%; height: 297px;margin-top:-28px;' >
                                                </a>
                                           </div>
                                      </div>
                                    </div>\n";
                                $html .= '<br/>
                                   </div>';
                                $pdf_name = explode('.pdf', $row->pdfName);
                                $pdf_name = $pdf_name[0];
                                if ($new_name == $row->pdfName && $row->isChange == 'change' || ($brandPrefixArr[$i] == $row->pdfName && !($row->isChange == 'unchange'))) {
                                    ?>
                                    <input type="hidden" name="modify_elem" class="modify_elem" value="modify">
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var brand_name = '<?php echo $pdf_name; ?>';
                                            $('#my_pdfs' + brand_name).addClass('my_task change_elem');
                                            turn_red_task();
                                        });
                                    </script>
                                    <?PHP
                                }
                                break;
                            }
                        }//end foreach
                    }//end else
                }
            }//end for
            if ($k == $page_num) {

                $html .= "<div>
                                  <button type='submit' class='btn btn-primary'    id='send_pdf'  name=form['submitpdf']  style='margin: 10px 30px 20px 0;height: 38px;' >  SEND PDF TO FTP  </button>     
                                  <br/>     
                               </div>\n";
            }


            echo $html;
            exit;
        }
        }
}elseif(isset($_GET['check_for_files']) && $_GET['check_for_files'] == true){

//    $num_files = count(glob( '/home/alon/Desktop/4.4.17/REG/*'));
//    // integer starts at 0 before counting
//    $i = 0;
//    $dir = '/home/alon/Desktop/4.4.17/REG';
//    if ($handle = opendir($dir)) {
//        while (($file = readdir($handle)) !== false){
//            if (!in_array($file, array('.', '..')) && !is_dir($dir.$file))
//                $i++;
//        }
//    }
//    // prints out how many were in the directory
//    //  echo "There were $i files";
//    $sql = "SELECT * FROM pdfs ORDER BY pdfName";
//    if( $rows = $db->queryObjectArray($sql)) {
//
//        if((count($rows) < $i) ){
//            $t['list'] = array();
//
//            $t['list'][0]  = 'fail';
//
//            echo json_encode($t);
//            exit;
//
//        }
//
//    }
}elseif(isset($_POST['category_pdf']) &&  isset($_POST['page_num']) && is_numeric($_POST['page_num'])) {

        $page_num = isset($_REQUEST['page_num']) ? $_REQUEST['page_num'] : false;
        if(isset($page_num) && is_numeric($page_num) ){

            for ($i = 0; $i < $page_num ; $i++) {
                // Display each record:

                echo '<div class="col-xs-3" >';
                echo "<div style=\"border-radius:3px; border:#cdcdcd solid 1px; padding:22px;background-color:gray; \"> 
                            <div id='my_pdfs_$i'>
                                <h4>
                                     <a class='my_href_li' href=\"#\">
                                     </a> 
                                 </h4>
                              </div>
                                <input type='checkbox' class='olive_cbx' id= improve_$i>
                              </div>\n";
                echo '<br/></div>';
            } // End of WHILE loop.
        }
    }



//    else if(! isset($_GET['page_num'])){
//    echo '<h1> "need to input number of pdfs!!"</h1>';
//}

elseif( isset($_GET['isChange']) && ( array_item($_GET,'isChange')== 'checked') && isset($_GET['pdf_name'])  ) {

    $name = ($_GET['pdf_name']).'.pdf';

    $sql = "SELECT * FROM pdfs " .
        "WHERE pdfName='$name'";

    $modify = '';
    if ($rows = $db->queryObjectArray($sql)) {
        $pdfID =    $rows[0]->pdfID;
//        $modify =   $rows[0]->modify_date;
//        $isChange = $rows[0]->isChange;
    }

if ($rows[0]->isChange == 'change'){
    $isChange ='unchange';
}
elseif ($rows[0]->isChange == 'unchange') {
    $isChange = 'change';
}

    $sql = "UPDATE pdfs SET " .
        "ischange=" . $db->sql_string($isChange) . "  " .
        "WHERE pdfID =  " . $db->sql_string($pdfID) . " ";

    if (!$db->execute($sql)) {
        return false;
    }


    echo "change status has been update!";
    exit;


}elseif( isset($_GET['vlidInsert']) && ( array_item($_REQUEST,'vlidInsert')== 'chack_insert')   ){	//בדיקת חוקיות קישורים של החלטות
	$insertID =$_REQUEST['insertID'];
		$decID =$_REQUEST['decID'];

 		$sql  = "SELECT  decName,  decID, parentDecID " .
          " FROM  decisions ORDER BY  decName";
		$rows = $db->queryObjectArray($sql);

		// build assoc. arrays for name, parent and subcats
		foreach($rows as $row) {

			$parents[$row-> decID] = $row->parentDecID;
			$parents_b[$row-> decID] = $row->parentDecID;
			$subcats[$row->parentDecID][] = $row->decID;   }
       if($subcats[$decID]){
			// build list of all parents for $insertID
			$dec_ID = $insertID;
			while($parents[$dec_ID]!=NULL) {
				$dec_ID = $parents[$dec_ID];
				$parentList[] = $dec_ID;
			}

            $decisionID = $insertID;
			while($parents_b[$decisionID]!=NULL && $parents_b[$decisionID]!=$decID) {
				$decisionID = $parents_b[$decisionID];
				$parentList_b[] = $decisionID;
			}



			if(   in_array($insertID, $subcats[$decID])
			||    in_array($parents[$insertID],$subcats[$decID] )
			||    in_array($decisionID,$subcats[$decID] )
			||    $parents[$insertID]== $decID ){


				$t['list'] = array();

					$t['list'][0]  = 'fail';

				echo json_encode($t);
				exit;

			}

		}


		if($insertID==$decID){


			$t['list'] = array();

				$t['list'][0] = 'fail';



			echo json_encode($t);
			exit;


		}



				$t['list'][0] = 'succeeded';
				$t['list']['insertID']=$insertID;
				echo json_encode($t);
				exit;




}
/*************************************************************************************************/
elseif(isset($_GET['find_the_dec']  ))  {//משתמשים בעת קבלת ההחלטה קובץ ניהול הוספת משתמש חדש
     global $db;
   $decID=$_REQUEST['decID'];

//	$t['total'] = 0;
//	$t['list'] = array();


//$sql="SELECT decName,decID FROM decisions WHERE decID=$decID ";


$sql="SELECT decID,IF(CHAR_LENGTH(decName)>9, CONCAT(LEFT(decName,7), ' ... ', RIGHT(decName, 3)), decName) AS decName
FROM decisions 
WHERE decID=$decID ";
	 if($rows=$db->queryObjectArray($sql)){

    foreach($rows as $row)
        {


             $t['list'][] =  $row;

        }
	echo json_encode($t);
	 exit;
}


   }

/**********************************************AUTO_COMPLETE_FORUMS*************************************************************/
elseif(isset($_GET['usrArr_frm']  ))  {
     global $db;

$formdata=Array();
$sql="SELECT forum_decID,forum_decName  FROM forum_dec ORDER BY forum_decName";
	if($rows=$db->queryObjectArray($sql)){

	$i=0;
		foreach($rows as $row){


			 $results[$i] = array($row->forum_decName,$row->forum_decID);
		      $i++;


		  }

	}
	echo json_encode($results);

	exit;


   }

/**********************************************AUTO_COMPLETE_DECISIONS*************************************************************/
elseif(isset($_GET['usrArr_dec']  ))  {
     global $db;

	$formdata=Array();
$sql="SELECT decID,decName  FROM decisions ORDER BY decName";	//getthe forums
	if($rows=$db->queryObjectArray($sql)){

	$i=0;
		foreach($rows as $row){


			 $results[$i] = array($row->decName,$row->decID);
		      $i++;


		  }

	}
	echo json_encode($results);

	exit;


   }
/**********************************************AUTO_COMPLETE_USERS*************************************************************/

elseif(isset($_GET['usrArr']  ))  {
     global $db;

	$formdata=Array();
$sql="SELECT userID,full_name FROM users ORDER BY full_name";	//getthe forums
	if($rows=$db->queryObjectArray($sql)){

	$i=0;
		foreach($rows as $row){


			 $results[$i] = array($row->full_name,$row->userID);
		      $i++;


		  }

	}
	echo json_encode($results);

	exit;


   }
 /**********************************************FOR DELETE USERS IN PRINT_USERS.PHP*************************************************************/
elseif(isset($_GET['mode2']  ))  {/******************************************************/
/**************************************************************************************************/
 $userID=$_REQUEST['id'];

 $formdata = array();
global $db;

$result=true;

$sql="SELECT forum_decID  from rel_user_forum  WHERE userID=$userID";	//getthe forums



/***************************************************/

	if($rows=$db->queryObjectArray($sql)){
	$frmName='';
	$i=0;
		foreach($rows as $frm){
		$sql="SELECT DISTINCT(f.forum_decID) ,f.forum_decName ,u.full_name FROM forum_dec  f 
		LEFT JOIN rel_user_forum r
         ON r.forum_decID=f.forum_decID

         LEFT JOIN users u
         ON u.userID=r.userID
		WHERE f.forum_decID=$frm->forum_decID
		AND u.userID=$userID";

		     if($rows_frm=$db->queryObjectArray($sql)){
		     	$forum_decName=$rows_frm[0]->forum_decName;
		        $full_name=$rows_frm[0]->full_name;
	    	}

	    	try {
	            $result = FALSE;
			    throw new Exception("משתמש $full_name מתפקד בפורום $forum_decName אנא מחוק אותו משם ");
	    	} catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();

	        }
			    $i++;
 }//end foreach


}



/****************************************************/

$sql="SELECT forum_decID  from rel_user_Decforum  WHERE userID=$userID";





	if($rows=$db->queryObjectArray($sql)){
	$frmName='';
	$i=0;
		foreach($rows as $frm){
		$sql="SELECT DISTINCT(f.forum_decID) ,f.forum_decName ,u.full_name FROM forum_dec  f 
		LEFT JOIN rel_user_Decforum r
         ON r.forum_decID=f.forum_decID

         LEFT JOIN users u
         ON u.userID=r.userID
		WHERE f.forum_decID=$frm->forum_decID
		AND u.userID=$userID";

     if($rows_frm=$db->queryObjectArray($sql)){
		     	$forum_decName=$rows_frm[0]->forum_decName;
		        $full_name=$rows_frm[0]->full_name;
	    	}

	   try {
	            $result = FALSE;
			    throw new Exception("משתמש $full_name תיפקד בעבר בפורום/ים $forum_decName אנא מחוק אותו משם ");
	    	  }catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();

	    }


	    	   $i++;
	       }


}

/********************************************************************************************/

$sql="SELECT DISTINCT(a.appointID) ,u.full_name FROM appoint_forum a 
		LEFT JOIN users u 
		ON u.userID=a.userID 
		 
		WHERE a.userID=$userID";





	if($rows=$db->queryObjectArray($sql)){// he is appoint
	 $full_name=$rows[0]->full_name;
     $appointID=$rows[0]->appointID;
	 $sql="SELECT DISTINCT(f.forum_decID) ,f.forum_decName ,a.appointName,a.appointID FROM forum_dec  f ,appoint_forum a
	    WHERE a.appointID=f.appointID
            AND a.appointID=$appointID  ";
	  if($rows_app=$db->queryObjectArray($sql)){
	 $i=0;
		foreach($rows_app as $app){
			try {


		     	$forum_decName=$app->forum_decName;




	            $result = FALSE;
			    throw new Exception("משתמש $full_name ממנה בפורום $forum_decName אנא מחוק אותו משם ");
			}catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();

	    }
			    $i++;
	   }
     }//end if  $rows_app
}



/*******************************************************/

$sql="SELECT DISTINCT(m.managerID) ,u.full_name FROM managers m 
		LEFT JOIN users u 
		ON u.userID=m.userID 
		 
		WHERE m.userID=$userID";





	if($rows=$db->queryObjectArray($sql)){// he is appoint
	 $full_name=$rows[0]->full_name;
     $managerID=$rows[0]->managerID;
	 $sql="SELECT DISTINCT(f.forum_decID) ,f.forum_decName ,m.managerName,m.managerID FROM forum_dec  f ,managers m
	    WHERE m.managerID=f.managerID
            AND m.managerID=$managerID  ";
	  if($rows_mgr=$db->queryObjectArray($sql)){
	 $i=0;
		foreach($rows_mgr as $mgr){
			try {


		     	$forum_decName=$mgr->forum_decName;




	            $result = FALSE;
			    throw new Exception("משתמש $full_name מנהל בפורום $forum_decName אנא מחוק אותו משם ");
			}catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();

	    }
			    $i++;
	   }
     }//end if  $rows_app
}



/*******************************************************/






if(!$result){

	$i=0;

	foreach($message as $row){

	  $key="messageError_$i";
	 $message_name[$key]=$row ;
	 $i++;
	}


   $message_name['userID']=$userID;



	echo json_encode($message_name);
	exit;

   } else{



   $sql= "DELETE FROM users WHERE userID=$userID";

/***********************************************************************************************/

$query = "set foreign_key_checks=0";
$query1 = "set foreign_key_checks=1";
 if(   $db->execute($query) ){
/***********************************/
       if(!$db->execute($sql)){
/**********************************/
$str= "בעיות במערכת אנחנו מיתנצלים";
 $message[]= $str;
	$i=0;

	foreach($message as $row){

	  $key="messageError_$i";
	 $message_name[$key]=$row ;
	 $i++;
	}


   $message_name['userID']=$userID;
    $db->execute($query1);


	echo json_encode($message_name);
	exit;
/**********************************/
       }else{
      	 $db->execute($query1);
      	 $formdata['type'] = 'success';
	     $formdata['message'] = 'עודכן בהצלחה!';
	     $formdata['userID'] =$userID;
   	     echo json_encode($formdata);
	     exit;
        }
/*************/
      } // if(   $db->execute($query) )
/**********/
   }
/********/
}//end functiom	  
/*************************************************************************************/




/**********************************************FOR DELETE USERS IN PRINT_USERS_HISTORY.PHP*************************************************************/
elseif(isset($_GET['mode_del']  ))  {

 $userID=$_REQUEST['id'];
$forum_decID=$_REQUEST['forum_decID'];
 $formdata = array();
global $db;

$result=true;

$sql="DELETE FROM  rel_user_forum_history  WHERE userID=$userID AND  forum_decID=$forum_decID ";	//get the forums
if(!$db->execute($sql))
return FALSE;


      	 $formdata['type'] = 'success';
	     $formdata['message'] = 'עודכן בהצלחה!';
	     $formdata['userID'] =$userID;
	     $formdata['forum_decID'] =$forum_decID;
   	     echo json_encode($formdata);
	     exit;
}//end functiom
/**********************************************FOR DELETE USERS IN PRINT_Decuser_frm.PHP*************************************************************/
elseif(isset($_GET['mode_Dec_usrdel']  ))  {

 $userID=$_REQUEST['id'];
$forum_decID=$_REQUEST['forum_decID'];
$decID=$_REQUEST['decID'];
 $formdata = array();
global $db;

$result=true;

$sql="DELETE FROM  rel_user_Decforum  WHERE userID=$userID AND  forum_decID=$forum_decID AND decID=$decID ";	//get the forums
if(!$db->execute($sql))
return FALSE;


      	 $formdata['type'] = 'success';
	     $formdata['message'] = 'עודכן בהצלחה!';
	     $formdata['userID'] =$userID;
	     $formdata['forum_decID'] =$forum_decID;
	     $formdata['decID'] =$decID;
   	     echo json_encode($formdata);
	     exit;
}//end functiom	  

/*************************************************************************************/




















/************************************FORUM_CAT1********************************************************/
elseif(isset($_POST['category1']) && $_POST['category1'] != ''){
/****************
Sanitize the data
***************/
$safeCat = (int)$_POST['category1'];
/****************/

$sql= "select distinct(f.forum_decID),f.forum_decName,f.forum_date,f.managerID,f.appointID, 
	     c.catID as 'cat_forumID',c.catName as 'cat_forumName',c.parentCatID as 'parent_Cat_forumID' 
               FROM forum_dec f
              left join rel_cat_forum rc on f.forum_decID=rc.forum_decID
             left join categories1 c on c.catID = rc.catID
           
           
 
               WHERE c.catID = '$safeCat'";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותר אף פורום חפש קטגוריה אחרת.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו פורומים '. count($rows)  .'</h1>';

       }//endif;//rows == 1




}
/*********************************FORUM_CAT2***********************************************************/
elseif(isset($_POST['category1_dest']) && $_POST['category1_dest'] != ''){
/****************
Sanitize the data
***************/
$safeCat = (int)$_POST['category1_dest'];
/****************/

$sql= "select distinct(f.forum_decID),f.forum_decName,f.forum_date,f.managerID,f.appointID, 
	     c.catID as 'cat_forumID',c.catName as 'cat_forumName',c.parentCatID as 'parent_Cat_forumID' 
               FROM forum_dec f
              left join rel_cat_forum rc on f.forum_decID=rc.forum_decID
             left join categories1 c on c.catID = rc.catID
           
           
 
               WHERE c.catID = '$safeCat'";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותר אף פורום חפש קטגוריה אחרת.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו פורומים '. count($rows)  .'</h1>';

       }//endif;//rows == 1




}
//-------------------------------------------CAT DEC------------------------------------------------------------------
elseif(isset($_POST['category_dec']) && $_POST['category_dec'] != ''){
/****************
Sanitize the data
***************/
$safeCat = (int)$_POST['category_dec'];
$sql= "select d.*, c.* 
             FROM decisions d
             left join rel_cat_dec rc on d.decID=rc.decID
             left join categories c on c.catID = rc.catID
             WHERE c.catID = '$safeCat'";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותרו קבצים בקטגוריה.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו החלטות '. count($rows)  .'</h1>';
       }//endif;//rows == 1
}

/******************************************CATEGORY_DEC2******************************************************/
elseif(isset($_POST['category_dec_dest']) && $_POST['category_dec_dest'] != ''){
/****************
Sanitize the data
***************/
$safeCat = (int)$_POST['category_dec_dest'];
/****************/


$sql= "select d.*, c.* 
             FROM decisions d
             left join rel_cat_dec rc on d.decID=rc.decID
             left join categories c on c.catID = rc.catID
             WHERE c.catID = '$safeCat'";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1 id="my_cat_decH1" value="my_cat_decH1">לא אותרה אף החלטה חפש קטגוריה אחרת.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1 id="my_cat_decH1" value="my_cat_decH1"> נמצאו החלטות '. count($rows)  .'</h1>';

       }//endif;//rows == 1




}

/****************************************PRECENT1*********************************************************/

elseif(isset($_POST['growth_dest']) && $_POST['growth_dest'] != ''){


$safeCat_dest = (int)$_POST['growth_dest'];

if(isset($_POST['growth']) && $_POST['growth'] != ''){
$safeCat = (int)$_POST['growth'];
}else{
	$safeCat = (int)5;
}

if($safeCat_dest<$safeCat){
  echo '<h2>אי אפשר לבצע חיפוש כשאחוז המקור גדול מהיעד.</h2>';
  return;

}

$sql= "select d.* 
             FROM decisions d
             
             WHERE d.vote_level between  $safeCat   and  $safeCat_dest  ";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותרה אף החלטה חפש רף אחר.</h1>';
              }else{

              echo '<h1> נמצאו החלטות '. count($rows)  .'</h1>';

       }//endif;//rows == 1


}
/****************************************PRECENT2*********************************************************/
elseif(isset($_POST['growth_precent_dest']) && $_POST['growth_precent_dest'] != ''){


$safeCat_dest = (int)$_POST['growth_precent_dest'];

if(isset($_POST['growth_precent']) && $_POST['growth_precent'] != ''){
$safeCat = (int)$_POST['growth_precent'];
}else{
	$safeCat = (int)5;
}

if($safeCat_dest<$safeCat){
  echo '<h2>אי אפשר לבצע חיפוש כשאחוז המקור גדול מהיעד.</h2>';
  return;

}

$sql= "select d.* 
             FROM decisions d
             
             WHERE d.vote_level between  $safeCat   and  $safeCat_dest  ";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותרה אף החלטה חפש רף אחר.</h1>';
              }else{

              echo '<h1> נמצאו החלטות '. count($rows)  .'</h1>';

       }//endif;//rows == 1


/******************************************FORUM_USER1**************************************************/
}elseif(isset($_POST['growth_frm_usr_dest']) && $_POST['growth_frm_usr_dest'] != ''){


$safeCat_frm_usr_dest= (int)$_POST['growth_frm_usr_dest'];

if(isset($_POST['growth_frm_usr']) && $_POST['growth_frm_usr'] != ''){
$safeCat_frm_usr = (int)$_POST['growth_frm_usr'];
}else{
	$safeCat_frm_usr = (int)1;
}

if($safeCat_frm_usr_dest<$safeCat_frm_usr){
  echo '<h2>אי אפשר לבצע חיפוש כשמספר חברי פורום המקור גדול מהיעד.</h2>';
  return;

}

$sql= "SELECT f.forum_decName,f.forum_decID , COUNT(u.full_name) AS nrOfusers
FROM forum_dec f 
LEFT JOIN rel_user_forum r ON r.forum_decID = f.forum_decID
LEFT JOIN users u ON r.userID = u.userID
GROUP BY forum_decName
HAVING nrOfusers between  $safeCat_frm_usr   and  $safeCat_frm_usr_dest 
ORDER BY nrOfusers DESC";


          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותר אף פורום חפש רף אחר.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו פורומים '. count($rows)  .'</h1>';

       }//endif;//rows == 1
/******************************************FORUM_USER2**************************************************/
}elseif(isset($_POST['growth_frm_usr_dest_num']) && $_POST['growth_frm_usr_dest_num'] != ''){


$safeCat_frm_usr_dest= (int)$_POST['growth_frm_usr_dest_num'];

if(isset($_POST['growth_frm_usr_src']) && $_POST['growth_frm_usr_src'] != ''){
$safeCat_frm_usr_src = (int)$_POST['growth_frm_usr_src'];
}else{
	$safeCat_frm_usr_src = (int)1;
}

if($safeCat_frm_usr_dest<$safeCat_frm_usr_src){
  echo '<h2>אי אפשר לבצע חיפוש כשמספר חברי פורום המקור גדול מהיעד.</h2>';
  return;

}

$sql= "SELECT f.forum_decName,f.forum_decID , COUNT(u.full_name) AS nrOfusers
FROM forum_dec f 
LEFT JOIN rel_user_forum r ON r.forum_decID = f.forum_decID
LEFT JOIN users u ON r.userID = u.userID
GROUP BY forum_decName
HAVING nrOfusers between  $safeCat_frm_usr_src   and  $safeCat_frm_usr_dest 
ORDER BY nrOfusers DESC";


          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותר אף פורום חפש רף אחר.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו פורומים '. count($rows)  .'</h1>';

       }//endif;//rows == 1
/**********************************LEVEL1**********************************************************/
}elseif(isset($_POST['growth_level']) && $_POST['growth_level'] != ''){


$safeCat_level = (int)$_POST['growth_level'];



$sql= "select d.* 
             FROM decisions d
             
             WHERE d.dec_level =  '$safeCat_level' ";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותרה אף החלטה חפש רף אחר.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו החלטות '. count($rows)  .'</h1>';

       }//endif;//rows == 1




}
/**********************************LEVEL2**********************************************************/
elseif(isset($_POST['growth_level_dest']) && $_POST['growth_level_dest'] != ''){


$safeCat_level = (int)$_POST['growth_level_dest'];



$sql= "select d.* 
             FROM decisions d
             
             WHERE d.dec_level =  '$safeCat_level' ";
          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותרה אף החלטה חפש רף אחר.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו החלטות '. count($rows)  .'</h1>';

       }//endif;//rows == 1




}
/***********************************CATEGORY_MGR1*********************************************************/
 elseif(isset($_POST['category_mgr']) && $_POST['category_mgr'] != ''){


$safeCat = (int)$_POST['category_mgr'];



$sql= "SELECT DISTINCT(m.managerID), m.*, mt.* 
             FROM managers m
             
             LEFT JOIN forum_dec f ON f.managerID=m.managerID
                         
             
             LEFT JOIN rel_managerType_forum rm ON f.forum_decID=rm.forum_decID
           
                      
           LEFT JOIN manager_type mt ON mt.managerTypeID=rm.managerTypeID
             
             WHERE mt.managerTypeID = '$safeCat'";

          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותר אף מנהל חפש קטגוריה אחרת.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו מנהלים '. count($rows)  .'</h1>';

       }//endif;//rows == 1


/***********************************CATEGORY_MGR2*********************************************************/

} elseif(isset($_POST['category_mgr_dest']) && $_POST['category_mgr_dest'] != ''){


$safeCat = (int)$_POST['category_mgr_dest'];



$sql= "SELECT DISTINCT(m.managerID), m.*, mt.* 
             FROM managers m
             
             LEFT JOIN forum_dec f ON f.managerID=m.managerID
                         
             
             LEFT JOIN rel_managerType_forum rm ON f.forum_decID=rm.forum_decID
           
                      
           LEFT JOIN manager_type mt ON mt.managerTypeID=rm.managerTypeID
             
             WHERE mt.managerTypeID = '$safeCat'";

          $rows = $db->queryObjectArray($sql);
            if( (!$rows) ){
               echo '<h1>לא אותר אף מנהל חפש קטגוריה אחרת.</h1>';
              }else{
              	//$row=$rows[0];
              echo '<h1> נמצאו מנהלים '. count($rows)  .'</h1>';

       }//endif;//rows == 1

}


/********************************************************************************************/
//END CATEGORIES  
/**********************************DECISIONS_CATEGORY**********************************************************/

elseif(isset($_POST['rowCount']) && $_POST['rowCount'] != ''){

$safeCat = (int)$_POST['rowCount'];




$sql= "select distinct(d.decID), c.catID  
               FROM decisions d
              left join rel_cat_dec rc on d.decID=rc.decID
              left join categories c on c.catID = rc.catID
              WHERE c.catID = '$safeCat'";


$t = array();
	$t['total'] = 0;
	$t['list'] = array();

	 $rows = $db->queryObjectArray($sql);


		$t['total']=count($rows);

		// $t['list'][] = prepareuserTaskRow($r, $tz);

	echo json_encode($t);
	exit;


}
/**********************************FORUMS_CATEGORY**********************************************************/

elseif(isset($_POST['forumCount']) && $_POST['forumCount'] != ''){

$safeCat = (int)$_POST['forumCount'];




$sql= "select f.forum_decID , c.catID  
               FROM forum_dec f
              left join rel_cat_forum rc on f.forum_decID=rc.forum_decID
              left join categories1 c on c.catID = rc.catID
              WHERE c.catID = '$safeCat'";

$sql1="select f.*, 
	     c.catID as 'cat_forumID',c.catName as 'cat_forumName',c.parentCatID as 'parent_Cat_forumID',
	     c1.catID,c1.catName,c1.parentCatID,
             m.managerID,m.managerName,a.appointID,a.appointName,mt.managerTypeName,mt.managerTypeID,d.decID,d.decName FROM forum_dec f
           
           LEFT JOIN rel_cat_forum rc ON f.forum_decID=rc.forum_decID
           LEFT JOIN rel_managerType_forum rm ON f.forum_decID=rm.forum_decID
           
           LEFT JOIN categories1 c ON c.catID = rc.catID
           
           LEFT JOIN managers m ON m.managerID=f.managerID
           
           LEFT JOIN manager_type mt ON mt.managerTypeID=rm.managerTypeID
           
           
           LEFT JOIN appoint_forum a ON a.appointID=f.appointID
           
           LEFT JOIN rel_forum_dec rf ON f.forum_decID=rf.forum_decID
           LEFT JOIN decisions d ON d.decID=rf.decID
           
           LEFT JOIN rel_cat_dec r ON d.decID=r.decID
           LEFT JOIN categories  c1 ON c1.catID=r.catID WHERE  c.catID IN (77)   ORDER BY f.forum_decNAME desc ";
$t = array();
	$t['total'] = 0;
	$t['list'] = array();

	 $rows = $db->queryObjectArray($sql);


		$t['total']=count($rows);

		// $t['list'][] = prepareuserTaskRow($r, $tz);

	echo json_encode($t);
	exit;


}

/**********************************CONTROL_FORUM_USERS+HISTORY_FORUM_USERS_FOR DECISIONS**********************************************************/

elseif(isset($_POST['src']) && $_POST['src'] != ''){
global $db;
$src = (int)$_POST['src'];
$dest = (int)$_POST['dest'];
$decID = (int)$_POST['decID'];
$forum_decID = (int)$_POST['forum_decID'];

    $t = array();
	$t['total'] = 0;
	$t['list'] = array();



$sql="select userID from rel_user_Decforum WHERE decID=$decID AND forum_decID=$forum_decID";
IF($rows=$db->queryObjectArray($sql)){
foreach ($rows as $row){
	if($src== $row->userID){

$t['list'] ='fail';


		$t['total']=0;

	echo json_encode($t);
	exit;
	   }

	}
}



$sql= "UPDATE rel_user_Decforum  set userID=$src WHERE userID = '$dest' AND decID=$decID   AND forum_decID='$forum_decID'";
if(!$db->execute($sql))
return FALSE;

$arr_usr='';
$sql1="select userID from  rel_user_Decforum WHERE decID=$decID AND forum_decID=$forum_decID";
if($rows=$db->queryObjectArray($sql1))
{
$arr_usr=$rows ;
}


$sql="select full_name,userID from users  WHERE userID=$src ";
if($rows=$db->queryObjectArray($sql)){



	$rows[0]->forum_decID="$forum_decID";
	$rows[0]->arr_usr=$arr_usr;
	$t['list'] =$rows[0];
	$t['total']=1;
$sql="select full_name,userID from users  WHERE userID=$src ";


}
	echo json_encode($t);
	exit;


}
/***********************************************************************************************************/
/*********************************************************************************************/
elseif(isset($_GET['start']  )){
	global $db;
	$sql =" SELECT * FROM event";// where id=6";



	  if($rows=$db->queryObjectArray($sql)){

	  	foreach($rows as $row)
	{


		 $t['list'][] =  $row;

	}
	echo json_encode($t);
	 exit;
}

}
/***********************************************************************************************/
elseif(isset($_GET['mode']  )){
	global $db;
	$full_name=trim(_get('mode'));//$_GET[mode];
	$name=$db->sql_string($full_name);
	$t['list'] = array();
	 	 $i=0;
	 $sql = "SELECT userID FROM users  WHERE full_name=$name";
	  if($rows=$db->queryObjectArray($sql)){

foreach($rows as $row)
	{


		 $t['list'][] =  $row;

	}
	echo json_encode($t);
	exit;

   }

 }
/******************************************************************************************************************/
 elseif(isset($_GET['mode']  )){
	global $db;
	$full_name=trim(_get('mode'));//$_GET[mode];
	$name=$db->sql_string($full_name);
	$t['list'] = array();
	 	 $i=0;
	 $sql = "SELECT userID FROM users  WHERE full_name=$name";
	  if($rows=$db->queryObjectArray($sql)){
   foreach($rows as $row)
	{


		 $t['list'][] =  $row;

	}
	echo json_encode($t);
	exit;

   }

 }
/******************************************************************************************************************/

elseif(isset($_GET['read_prog']  )){
	global $db;
	$forum_decID=trim(_get('forum_decID'));
	$decID=trim(_get('decID'));
	$t['list'] = array();

		$sql="SELECT ROUND(AVG(prog_bar)) as avg FROM todolist WHERE forum_decID=$forum_decID  AND decID=$decID ";
		if($rows=$db->queryObjectArray($sql)  ){





foreach($rows as $r)
	{


		 $t['list'][] =  ($r);

	}



   }
   echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['find_frmID']  )){
	global $db;
	$forum_decName=$db->sql_string(trim(_get('forum_decName')) );
	$insertID=trim(_get('insertID')) ;
	$t['list'] = array();

		$sql="SELECT forum_decID FROM forum_dec WHERE forum_decName=$forum_decName  AND parentForumID=$insertID ";

if($rows=$db->queryObjectArray($sql) ){
  foreach($rows as $r)
	{


		 $t['list'][] =  ($r);

	}
	echo json_encode($t);
	exit;

   }
}
/******************************************************************************************************************/
elseif(isset($_GET['get_decNote']  )){
	global $db;
	$decID=(int)$_GET['decID'];

	$t['list'] = array();

		$sql="SELECT note FROM decisions WHERE decID=$decID  ";


if($rows=$db->queryObjectArray($sql) ){
 foreach($rows as $r)
	{


		 $t['list'][] =  ($r);

	}
	echo json_encode($t);
	exit;

   }
}
/******************************************************************************************************************/

 elseif(isset($_GET['loadTasks2user2']))//show tasks that i wrote in the web
{
	//check_read_access();
	//stop_gpc($_GET);


	if(_get('compl')==0)      $sqlWhere = ' AND compl=0';
	elseif(_get('compl')==1)  $sqlWhere = '';
	elseif(_get('compl')==2)  $sqlWhere = ' AND compl=1';

	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;

	if($_REQUEST['userID'])
	$userID=$_REQUEST['userID'];
	else $userID=$userID;

	if($_REQUEST['dest_userID'] && $_REQUEST['dest_userID']!='undefined'  && $_REQUEST['dest_userID']!='NaN')
	$dest_userID=$_REQUEST['dest_userID'];



	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	$inner = '';
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_tag_id($tag);
		if(_get('compl')==3){
		$inner = "INNER JOIN tag2task ON t.taskID=tag2task.taskID";
		}else{
		$inner = "INNER JOIN tag2task ON todolist.taskID=tag2task.taskID";
		}
		$sqlWhere .= " AND tag2task.tagID=$tag_id ";
	}



	$s = trim(_get('s'));
	if($s != '') $sqlWhere .= " AND (title LIKE ". $db->quoteForLike("%%%s%%",$s). " OR note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";



	$sort = (int)_get('sort');
	if($sort == 1) $sqlSort = "ORDER BY prio DESC, ddn ASC, duedate ASC, ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY ddn ASC, duedate ASC, prio DESC, ow ASC";
	else $sqlSort = "ORDER BY ow ASC";



	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;



	$t = array();
	$t['total'] = 0;
	$t['list'] = array();
	$t['message'] = array();

	$sql="                 
    SELECT u.userID  FROM users u          
                     WHERE u.userID=(SELECT m.userID FROM managers m
                     WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";



	if($rows=$db->queryObjectArray($sql)){
		$userID_mgr=$rows[0]->userID;
	}


	if($userID==$userID_mgr ){
		 if($dest_userID && $dest_userID!='undefined'){

 $sql="SELECT t.* , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.dest_userID=$dest_userID 
                                   AND r.forum_decID=$forum_decID 
                                  $sqlSort ";
}	else{

                $sql="SELECT t.* ,u.userID,u.full_name,rt.userID,rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.userID= $userID
                                  AND t.forum_decID=$forum_decID
                                  $sqlSort ";

       }


}



 if($dest_userID && $dest_userID!='undefined' && $userID!=$userID_mgr){

 $sql="SELECT   DISTINCT t.*  , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  
			            		  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 

			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.dest_userID=$dest_userID 
                                  AND t.forum_decID=$forum_decID 
                                  $sqlSort ";
}	elseif(  (!($dest_userID) || $dest_userID=='undefined') && $userID!=$userID_mgr){

$sql="SELECT  DISTINCT  t.*  ,u.userID,u.full_name,rt.userID,rt.dest_userID FROM todolist t
                                  
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 

			            		  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID

			            		  left JOIN users u
			            		  ON u.userID=rt.userID 

			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.userID=$userID
                                  AND t.forum_decID=$forum_decID 
                                  $sqlSort ";

}

	$q = $db->queryObjectArray($sql);

	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;
		 $t['list'][] =  prepareTask2userRow ($r, $tz);
    }
	echo json_encode($t);
	exit;
}
/************************************************************************************************/
elseif (isset($_GET['setuserDuedate'])){
//    $dest_userID = (int)$_GET['setuserDuedate']; 
//	$decID=$_REQUEST['decID']; 
//	$forum_decID=$_REQUEST['forum_decID'];


$dest_userID = (int)$_REQUEST['setuserDuedate'];
	$decID=$_REQUEST['decID'];
	$forum_decID=$_REQUEST['forum_decID'];

	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;



	$t1 = array();
	$t1['total'] = 0;
	$t1['list1'] = array();


 if($dest_userID && $dest_userID!='undefined'){




  $sql ="SELECT   MIN(t.duedate) AS duedate   , rt.dest_userID FROM todolist t
                                  
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  
			            		  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 

			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.dest_userID=$dest_userID 
                                  AND t.forum_decID=$forum_decID 
                                  group by t.forum_decID ";
    }


    $q = $db->queryObjectArray($sql);

	if($q && $q!=0)
	foreach($q as $r)
	{
		$t1['total']++;

	     $t1['list1'][] =  prepareTask2userRow ($r, $tz);
	     //$t['list'][] =  prepareuserDuedateRow ($r, $tz);

	}
	  echo json_encode($t1);
//$year = date('Y');
//	$month = date('m');
//
//	echo json_encode(array(
//	
//		array(
//			 'id' => '111',
//			'title' => "Event1",
//			'start' => "$year-$month-10",
//			 'url' => "http://yahoo.com/"
//		),
//		
//		array(
//			 'id' => '222',
//			'title' => "Event2",
//			'start' => "$year-$month-20",
//			 'end' => "$year-$month-22",
//			//'url' => "http://yahoo.com/"
//		)
//	
//	)
//);
	exit;

}
/**************************************************************************************************/
elseif(isset($_GET['loadTasks2user']))
{



	if(_get('compl')==0)      $sqlWhere = ' AND compl=0';
	elseif(_get('compl')==1)  $sqlWhere = '';
	elseif(_get('compl')==2)  $sqlWhere = ' AND compl=1';

	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;

	if($_REQUEST['userID'])
	$userID=$_REQUEST['userID'];
	else $userID=$userID;

	if($_REQUEST['dest_userID'] && $_REQUEST['dest_userID']!='undefined')
	$dest_userID=$_REQUEST['dest_userID'];



	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	$inner = '';
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_tag_id($tag);
		if(_get('compl')==3){
		$inner = "INNER JOIN tag2task ON t.taskID=tag2task.taskID";
		}else{
		$inner = "INNER JOIN tag2task ON todolist.taskID=tag2task.taskID";
		}
		$sqlWhere .= " AND tag2task.tagID=$tag_id ";
	}



	$s = trim(_get('s'));
	if($s != '') $sqlWhere .= " AND (title LIKE ". $db->quoteForLike("%%%s%%",$s). " OR note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";



	$sort = (int)_get('sort');
	if($sort == 1) $sqlSort = "ORDER BY prio DESC, ddn ASC, duedate ASC, ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY ddn ASC, duedate ASC, prio DESC, ow ASC";
	else $sqlSort = "ORDER BY ow ASC";



	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;



	$t = array();
	$t['total'] = 0;
	$t['list'] = array();
	$t['message'] = array();



 if($dest_userID && $dest_userID!='undefined'){

 $sql="SELECT t.* , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.dest_userID=$dest_userID 
                                  AND r.forum_decID=$forum_decID 
                                  $sqlSort ";
}	else{

$sql="SELECT t.* ,u.userID,u.full_name,rt.userID,rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.userID=$userID
                                  AND r.forum_decID=$forum_decID 
                                  $sqlSort ";

}

	$q = $db->queryObjectArray($sql);

	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;

		// $t['list'][] = prepareuserTaskRow($r, $tz);

		 $t['list'][] =  prepareTask2userRow ($r, $tz);

	}
	echo json_encode($t);
	exit;
}
/************************************************************************************************/

/*************************************************************************************************/

elseif(isset($_GET['loadUsertask']))
{
	//check_read_access();
	 stop_gpc($_GET);




	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;

	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	if($_REQUEST['userID'])
	$userID=$_REQUEST['userID'];
	else $userID=$userID;




	$sql="SELECT t.* ,u.userID,u.full_name,rt.userID FROM todolist t
                                 left JOIN decisions  d
			            		 ON d.decID=t.decID 
                                 left JOIN rel_user_task  rt
			            	      ON rt.taskID=t.taskID 
			            	       left JOIN users u
			            		  ON u.userID=rt.userID 
			            		 left JOIN rel_user_forum  r
			            		 ON r.userID=u.userID 
                     			 where t.compl in(0,1)
                                 AND t.decID=$decID 
                                 AND rt.userID=$userID
                                 AND r.forum_decID=$forum_decID 
                                 ORDER BY t.duedate ASC ";






	if($q = $db->queryObjectArray($sql))
	foreach($q as $r)
	{
		$t['total']++;
		if(_get('compl')==3)
		$t['list'][] = prepareuserTaskRow($r, $tz);
		else
		$t['list'][] = prepareTaskRow($r, $tz);


	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
 elseif(isset($_GET['loadusertask']))
{

	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;

	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	if($_REQUEST['userID'])
	$userID=$_REQUEST['userID'];
	else $userID=$userID;




	$sql="SELECT t.* ,distinct(u.userID),u.full_name , rt.dest_userID   FROM todolist t
                                 left JOIN decisions  d
			            		 ON d.decID=t.decID 
                                 left JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 left JOIN rel_user_forum  r
			            		 ON r.userID=u.userID 
                     			 where t.compl in(0,1)
                                 AND t.decID=$decID 
                                 AND rt.userID=$userID
                                 AND r.forum_decID=$forum_decID 
                                 ORDER BY t.duedate ASC ";






	if($q = $db->queryObjectArray($sql))
	foreach($q as $r)
	{
		$t['total']++;
		if(_get('compl')==3)
		$t['list'][] = prepareuserTaskRow($r, $tz);
		else
		$t['list'][] = prepareTaskRow($r, $tz);


	}
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/
elseif(isset($_GET['loadtaskusers'])){

$sql	=	"SELECT t.*  ,u.full_name   ,distinct(u.userID) ,rt.dest_userID
                    FROM todolist 
                     left JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 WHERE t.compl in(0,1) 
			                    ORDER BY u.full_name ASC ";
           $rows		=	$db->queryObjectArray($sql);
           $getTask_Total	=	count($rows);
           $currentUser	=	"none";
   	$t = array();
	$t['total'] = 0;
	$t['list'] = array();



 if($rows && $rows!=null){
/******************************************************************************************************/
    foreach ($rows as $r) {
/******************************************************************************************************/
    	 $t['total']++;
		$t['list'][] = prepareuserTaskRow($r, $tz);


    }//end foreach
 }//end if






 echo json_encode($t);
	exit;

}
/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['loadTasks']))
{

$orderBy=false;
$orderBy_recive=false;


 	if(_get('compl')==0)      $sqlWhere = ' AND t.compl=0';
	elseif(_get('compl')==1)  $sqlWhere = '';
	elseif(_get('compl')==2)  $sqlWhere = ' AND t.compl=1';
	elseif(_get('compl')==3){ $orderBy  =  true;}
    elseif(_get('compl')==7){ $orderBy_recive  =  true;}
	elseif(_get('compl')==4)  $sqlWhere = ' AND t.compl<>1  AND (t.duedate=CURRENT_DATE || t.duedate=DATE_ADD(CURRENT_DATE,INTERVAL 1 DAY ) )'  ;
	elseif(_get('compl')==5)  $sqlWhere = ' AND t.compl<>1  AND (t.duedate<CURRENT_DATE)'  ;
	elseif(_get('compl')==6)  $sqlWhere = ' AND t.compl<>1  AND  t.duedate>DATE_ADD(CURRENT_DATE,INTERVAL 1 DAY )  
	 AND  t.duedate<DATE_ADD(CURRENT_DATE,INTERVAL 8 DAY )';

	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;


	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	$inner = '';
	$tag = trim(_get('t'));

	if($tag != '') {
		$tag_id = get_tag_id($tag);
 		$inner = "INNER JOIN  tag2task t2t ON t.taskID=t2t.taskID";
		$sqlWhere .= " AND t2t.tagID=$tag_id ";
	}



	$s = trim(_get('s'));
	if($s != '') $sqlWhere .= " AND (t.title LIKE ". $db->quoteForLike("%%%s%%",$s). " OR t.note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";


 if(!($orderBy) && !($orderBy_recive) ){
	$sort = (int)_get('sort');
	if($sort == 1) $sqlSort = "ORDER BY t.prio DESC,  ddn ASC, t.duedate ASC, t.ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY t.ddn ASC, t.duedate ASC, t.prio DESC, t.ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY t.ddn ASC, t.duedate ASC, t.prio DESC, t.ow ASC";
	else $sqlSort = "ORDER BY t.ow ASC";
 }elseif($orderBy){
 	$sqlSort = "ORDER BY u.userID ASC";
}elseif($orderBy_recive){
 	$sqlSort = "ORDER BY rt.dest_userID ASC";
}


	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;



	$t = array();
	$t['total'] = 0;
	$t['list'] = array();
	$t['message'] = array();



	$sql ="SELECT t.*,t.forum_decID, t.duedate IS NULL  AS ddn ,u.userID, u.full_name ,rt.dest_userID,rt.dest_name
                    FROM todolist t  
                                 
                                 $inner 

                                 LEFT JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID

			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID

			            		  
                                 WHERE 1=1
                                 $sqlWhere 
			            		 
                                  
                                 AND t.decID=$decID 
                                 AND t.forum_decID=$forum_decID 
                                 $sqlSort ";



	$q = $db->queryObjectArray($sql);

	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;

		$t['list'][] = prepareTaskRow($r, $tz);


	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/


elseif(isset($_GET['newTask']))
{
	//check_write_access();
	///stop_gpc($_POST);
	$t = array();
	$t['total'] = 0;
	$title = trim(_post('title'));
	$userID= trim(_post('user'));
	$decID= trim(_post('decID'));
	$forum_decID= trim(_post('forum_decID'));

	if( trim(_post('user_dest'))=='none')
	$dest_userID=$userID;
	ELSE
	$dest_userID= trim(_post('user_dest'));


	if(trim(_post('task_allowed'))==0)
	$task_allowed= 'public';
	elseif(trim(_post(task_allowed))==1 )
	 $task_allowed= 'private';
	elseif(trim(_post('task_allowed'))==2 )
	 $task_allowed= 'top_secret';






	$prio = 0;
	$tags = '';


if(!isset($config['smartsyntax']) || $config['smartsyntax'] != 0)
	{
		$a = parse_smartsyntax($title);
		if($a === false) {
			echo json_encode($t);
			exit;
		}
		$title = $a['title'];
		$prio = $a['prio'];
		$tags = $a['tags'];
	}
	if($title == '') {
		echo json_encode($t);
		exit;
	}


	if(isset($config['autotag']) && $config['autotag'])
	$tags .= ','._post('tag');


	$tz = (int)_post('tz');
	if( (isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0 )
	$d = strftime("%Y-%m-%d %H:%M:%S");
	else
	$d = gmdate("Y-m-d H:i:s", time()+$tz*60);



	$sql=("SELECT full_name from users  where userID=$userID");
	    $full_name = $db->queryObjectArray($sql);
	    $full_name=$full_name[0]->full_name;

        $sql=("SELECT full_name from users  where userID=$dest_userID");
	    $destfull_name = $db->queryObjectArray($sql);
		$destfull_name=$destfull_name[0]->full_name;


		$message = " ==> ניכתבה ע י  " . $full_name . " אל " . $destfull_name;

	$sql=("SELECT MAX(ow) FROM todolist");
	//$db->queryObjectArray($sql);
	$ow = 1 + (int)$db->queryObjectArray($sql);

	$sql=("BEGIN");
	$db->execute($sql);


/***********************************CHECK IF DEST_USERID IS MaNaGar************************************/
$now	=	date('Y-m-d H:i:s');

$sql="                 
    SELECT u.userID  FROM users u          
    WHERE u.userID=(SELECT m.userID FROM managers m
    WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";

if($rows=$db->queryObjectArray($sql)){
	$mgr_userID=$rows[0]->userID;
}
/**********************************/
if($dest_userID==$mgr_userID){
/*********************************/
/******************************************************/
	  $sql = "UPDATE forum_dec SET  " .
      	  "duedate="    .  $db->sql_string($now) . "  " .
	  "WHERE  forum_decID=$forum_decID";

	  if(!$db->execute($sql) )
	   return false;
/*****************************************************/
    }else{
	     $sql = "UPDATE rel_user_forum  SET  " .
      	  "duedate="    .  $db->sql_string($now) . "  " .
	  "WHERE userID=$dest_userID     AND forum_decID=$forum_decID";
	 if(!$db->execute($sql) )
	   return false;
}

/**********************************************************************/

	   $sql = "INSERT INTO todolist (title,decID,forum_decID,message,task_date,duedate,ow,task_allowed,prio) VALUES ( " .
        $db->sql_string($title) . ", " .
        $db->sql_string($decID) . ", " .
		$db->sql_string($forum_decID) . ", " .
		//$db->sql_string($dest_userID) . ", " .
		$db->sql_string($message) . ", " .
		$db->sql_string($now) . ", " .
		$db->sql_string($now) . ", " .
		$db->sql_string($ow) . ", " .
		$db->sql_string($task_allowed) . ", " .

		$db->is_num($prio)  . " ) " ;


	if(!$db->execute ($sql) )
	   return false;


	$taskID = $db->insertId() ;

	$sql="insert into rel_user_task (userID,forum_decID, taskID,dest_name,decID,duedate, dest_userID)VALUES ( " .
        $db->sql_string($userID) . ", " .
        $db->sql_string($forum_decID) . ", " .
        $db->sql_string($taskID) . ", " .
        $db->sql_string($destfull_name) . ", " .
        $db->sql_string($decID) . ", " .
        $db->sql_string($now) . ", " .
	    $db->sql_string($dest_userID) . ") " ;



	if(!$db->execute ($sql) )
	   return false;

	if($tags)
	{
		$tag_ids = prepare_tags($tags);
		if($tag_ids) {
			update_task_tags($id, $tag_ids);
			//$sql= ("UPDATE todolist SET tags= ' .$db->sql_string($tags) . '  WHERE taskID=$taskID" );
		     $sql= "UPDATE todolist SET " .
                 "tags=".   $db->sql_string($tags) . " " .
                  "WHERE taskID=$taskID " ;


			$db->execute($sql);
		}
	}

	$db->execute("COMMIT");

	$sql="SELECT t.* , u.userID ,u.full_name, rt.dest_userID FROM todolist t
                                  
	                              left JOIN decisions  d
			            		  ON d.decID=t.decID 

			            		  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  
			            		  WHERE t.taskID=$taskID  
			            		  AND d.decID=$decID ";

	$r = $db->queryObjectArray($sql);
	$r=$r[0];

	$t['list'][] = prepareTaskRow($r);
	$t['total'] = 1;
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
elseif(isset($_GET['editTask']))
{
	check_write_access();
	$id = (int)$_GET['editTask'];
	 stop_gpc($_POST);
	$forum_decID= trim(_post('forum_decID'));
	$decID= trim(_post('decID'));
	$prog_bar = trim(_post('prog_bar'));
	$title = trim(_post('title'));
	$note = str_replace("\r\n", "\n", trim(_post('note')));
	$prio = (int)_post('prio');



	$userID=(int)_post('userselect');
	if((int)_post('userselect1')=='none'  )
	$dest_userID=$userID;
	ELSE
	$dest_userID=(int)_post('userselect1');


	if($prio < -1) $prio = -1;
	elseif($prio > 3) $prio = 3;


	$duedate = parse_duedate(trim(_post('duedate')));


	if(trim(_post('task_allowed'))==0)
	$task_allowed= 'public';
	elseif(trim(_post('task_allowed'))==1 )
	 $task_allowed= 'private';
	elseif(trim(_post('task_allowed'))==2 )
	 $task_allowed= 'top_secret';



	$t = array();
	$t['total'] = 0;
	if($title == '') {
		echo json_encode($t);
		exit;
	}


	$tags = trim(_post('tags'));
	$db->execute("BEGIN");



	//$tags=trim($tags);
    $tag_ids = prepare_tags($tags);
	//$tag_ids =$tag_ids [0];
	$cur_ids = get_task_tags($id);
	if($cur_ids) {
		$ids = implode(',', $cur_ids);
		$db->execute("DELETE FROM tag2task WHERE taskID=$id");
		$sql=("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($ids)");//dq
		$db->execute($sql);
	}
	if($tag_ids) {

		update_task_tags($id, $tag_ids);
	}


	$tags =$_POST['tags'] ;
	$tags=trim($tags);
	if(is_null($duedate)) $duedate = 'NULL'; else $duedate = $db->sql_string($duedate);
    if(is_null($note)) $note = 'NULL'; else $note = str_replace("\r\n", "\n", trim($note ));// $note = $db->sql_string($note);
	if(is_null($tags) || $tags=="" ) $tags = 'NULL'; else $tags = $db->sql_string($tags);


	$sql=("SELECT full_name from users where userID=$userID");
	    $full_name = $db->queryObjectArray($sql);
	    $full_name=$full_name[0]->full_name;

        $sql=("SELECT full_name from users where userID=$dest_userID");
	    $destfull_name = $db->queryObjectArray($sql);
		$destfull_name=$destfull_name[0]->full_name;





		$message = " ==> ניכתבה ע י  " . $full_name . " אל " . $destfull_name;

	$sql = "UPDATE rel_user_task SET  " .
	  "userID="     .  $db->sql_string($userID) . ", " .
	  "dest_userID="     .  $db->sql_string($dest_userID) . "  " .
	  "WHERE taskID=$id";

	if(!$db->execute($sql) )
	  return FALSE;


/***********************************************************************/
$sql="                 
    SELECT u.userID  FROM users u          
    WHERE u.userID=(SELECT m.userID FROM managers m
    WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";

if($rows=$db->queryObjectArray($sql)){
	$mgr_userID=$rows[0]->userID;
}
/********************************************/
if($dest_userID==$mgr_userID){//IF MANAGER
/********************************************/


	$sql = "UPDATE forum_dec SET  " .
      	  "duedate="    .   $duedate  . "  " .
	  "WHERE  forum_decID=$forum_decID  ";


/********************************************/
    }else{//IF USER
/********************************************/
    	if($duedate && $duedate!=NULL){
       $sql = "UPDATE rel_user_forum  SET  " .
      	  "duedate="    .   $duedate  . "  " .
	  "WHERE userID=$dest_userID  AND forum_decID=$forum_decID";
    	}
    }

if(!$db->execute($sql) )
	   return false;
/**********************************************************************/


	$sql = "UPDATE todolist SET  " .
	"title="     .  $db->sql_string($title) . ", " .
	  "note="     .  $db->sql_string($note) . ", " .
	//  "prio="     .  $db->sql_string($prio) . ", " .
	  "prog_bar="     .  $db->sql_string($prog_bar) . ", " .
	  //"dest_userID="     .  $db->sql_string($dest_userID) . ", " .
	  "message="     .  $db->sql_string($message) . ", " .
	 // "tags="     .  stripslashes($tags) . ", " .
	  "duedate="    .  stripslashes($duedate) . " , " .
	 "task_allowed="    .  stripslashes($db->sql_string($task_allowed)) . "  " .
	  "WHERE taskID=$id";

	if(!$db->execute($sql) ){
	   return FALSE;

	}else{
	$db->execute("COMMIT");
	}


	$sql="SELECT t.*,r.userID,r.dest_userID  FROM todolist t
			 LEFT JOIN rel_user_task r
			 ON (r.taskID=t.taskID)
			 WHERE t.taskID=$id";
	$r = $db->queryObjectArray($sql);

	if($r) {
		$r=$r[0];
		$t['list'][] = prepareTaskRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/

/******************************************************************************************************************/

elseif(isset($_GET['loadUsers'])){
	global $db;





	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	if($forum_decID && !($forum_decID=='undefined')){

	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];



	if($_REQUEST['mgr'])
	$mgr=$_REQUEST['mgr'];

	if(_get('compl')==0)      $sqlWhere = ' AND r.compl=0';
	elseif(_get('compl')==1)  $sqlWhere = '';
	elseif(_get('compl')==2)  $sqlWhere = ' AND r.compl=1';


	elseif(_get('compl')==4)  $sqlWhere = ' AND r.compl<>1  AND (r.duedate=CURRENT_DATE || r.duedate=CURRENT_DATE+1)'  ;
	elseif(_get('compl')==5)  $sqlWhere = ' AND r.compl<>1  AND (r.duedate<CURRENT_DATE)'  ;
	elseif(_get('compl')==6)  $sqlWhere = ' AND r.compl<>1  AND (r.duedate>CURRENT_DATE+1 && r.duedate<CURRENT_DATE+8)'  ;





	$inner = '';
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_taguser_id($tag);
		$sqlWhere .= " AND r.tagID=$tag_id  ";
	}




	$sort = (int)_get('sort');
     if($sort == 1) $sqlSort = "ORDER BY r.prio DESC,  r.duedate ASC, u.ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY  r.duedate ASC, r.prio DESC, u.ow ASC";
	 else $sqlSort = "ORDER BY u.ow ASC";


	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;



	$t = array();
	$t['total'] = 0;
	$t['list'] = array();




/**************************************************************************************/
if( (_get('compl')==1) || (_get('compl')==2) || (_get('compl')==4)  || (_get('compl')==5) || (_get('compl')==6)  || trim(_get('t'))  ){

	 $sql="SELECT   u.*,   r.forum_decID,r.tagID,r.tags,r.duedate,r.prio,r.compl,r.HireDate,f.managerID  FROM users u 
                     
                     LEFT JOIN rel_user_forum r  
                     ON u.userID = r.userID
                      
                      INNER JOIN forum_dec f  
                     ON f.forum_decID = r.forum_decID
                    
                      WHERE 1=1
                      $sqlWhere
                     AND r.forum_decID=$forum_decID ";

/************************************************************************/
}else{




 $sql=" SELECT  u.userID   FROM users u	                 
 	                 
	
                     INNER JOIN rel_user_forum r  
                     ON u.userID = r.userID     
                     
                     INNER JOIN  forum_dec f  
                     ON f.forum_decID = r.forum_decID  
                              
                                             
                              
                     WHERE r.forum_decID =$forum_decID  ";


      if($rows=$db->queryObjectArray($sql )){


for($i=0; $i<count($rows); $i++){
				if($i==0){
					$userIDs = $rows[$i]->userID;
				}
				else{
					$userIDs .= "," . $rows[$i]->userID;

				}

			}



  foreach ($rows as $row ){

     $sql_test ="SELECT   MIN(t.duedate) AS duedate   , rt.dest_userID FROM todolist t
                                  
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  
			            		  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 

			            		  left JOIN rel_user_forum  r
			            		  ON r.userID=u.userID 
			            		  
                     			  where t.compl in(0,1)
                     			 
                                  AND t.decID=$decID 
                                  AND rt.dest_userID=$row->userID 
                                  AND t.forum_decID=$forum_decID 
                                  group by t.forum_decID ";

                if($find_min=$db->queryObjectArray($sql_test)){
     	          $min_date=$find_min[0]->duedate;
     	         $sql= "UPDATE rel_user_forum SET " .
                 "duedate=".   $db->sql_string($min_date) . " " .
                  "WHERE userID=$row->userID  AND  forum_decID=$forum_decID; " ;

     	         if(!($db->execute($sql)))
     	         return false;

          }
          else{
          	     $sql= "UPDATE rel_user_forum SET " .
                  "duedate=  NULL   " .
                  "WHERE userID=$row->userID  AND  forum_decID=$forum_decID; " ;

     	         if(!($db->execute($sql)))
     	         return false;

          }

    }

  }//end if($rows=$db->queryObjectArray($sql )){




$sql=" SELECT   u.*, f.duedate,f.forum_decName,f.forum_decID,f.tagID,f.tags, f.prio,f.manager_date, m.managerID  FROM forum_dec f
        
                     LEFT JOIN managers m 
                     ON f.managerID = m.managerID
                      

                     INNER   JOIN users u  
                     ON u.userID = m.userID

                     LEFT JOIN rel_user_forum r  
                     ON u.userID = r.userID
                     
                    
                      
                     WHERE f.managerID IN ($mgr)
                     AND f.forum_decID=$forum_decID
                    
                     
                     
                     UNION  

                     
                     
                     SELECT   u.*, r.duedate, f.forum_decName, r.forum_decID,r.tagID,r.tags, r.prio,r.HireDate, m.managerID  FROM users u 
                     
                     
                     LEFT JOIN rel_user_forum r  
                     ON u.userID = r.userID
                      
                     
                     INNER JOIN forum_dec f  
                     ON f.forum_decID = r.forum_decID
                     
                     
                     INNER   JOIN managers m  
                     ON f.managerID = m.managerID       
                      
                     
                     WHERE f.forum_decID=$forum_decID 
                     $sqlWhere ";



     }



	$getUser= $db->queryObjectArray($sql);

	if($getUser && $getUser!=0){
   $getUser_Total	=	count($getUser);


	foreach ($getUser as $r  )

	{
			$t['total']++;
			$t['list'][] = prepareUserRow($r);
	}
 }
echo json_encode($t);
	exit;
	}
}
/******************************************************************************************************************/

elseif(isset($_GET['loadUsers3'])){
	global $db;



$tag = trim(_get('t'));
	if($tag != '') {

$tag=$db->sql_string($tag);



	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;



	$t = array();
	$t['total'] = 0;
	$t['list'] = array();






	 $sql="SELECT   u.*,   r.forum_decID,r.tagID,r.tags,r.duedate,r.prio,r.compl,r.HireDate,f.managerID  FROM users u 
                     
                     LEFT JOIN rel_user_forum r  
                     ON u.userID = r.userID
                      
                      INNER JOIN forum_dec f  
                     ON f.forum_decID = r.forum_decID
                    
                      WHERE r.tags=$tag ";

/************************************************************************/
 	$getUser= $db->queryObjectArray($sql);

	if($getUser && $getUser!=0)
   $getUser_Total	=	count($getUser);


foreach ($getUser as $r  )

{
		$t['total']++;
		$t['list'][] = prepareUserRow($r);
}
echo json_encode($t);
	exit;

  }
}
/******************************************************************************************************************/

elseif(isset($_GET['loadUsersDec'])){  //get the users in time thay decided the decision from rel_user_Decforum
	global $db;


	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];

	if(!$forum_decID)
	$forum_decID=$_GET['loadUsersDec'];


	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];




	$tz = (int)_get('tz');



	$t = array();
	$t['total'] = 0;
	$t['list'] = array();






 $sql1="SELECT u.userID,u.full_name ,m.managerID,m.managerID,m.managerName FROM users u 
		                     INNER join rel_user_Decforum r  
		                     on u.userID = r.userID 
		                     
		                     INNER JOIN decisions  d
			                 ON d.decID=r.decID 
		                     
		                     INNER join forum_dec f  
		                     on f.forum_decID = r.forum_decID
		
		                     INNER join managers m
		                     on m.managerID=f.managerID
		                     
		                     WHERE f.forum_decID = $forum_decID
		                     AND d.decID=$decID
		                     ORDER BY u.full_name ASC";


 $sql="SELECT u.userID,u.full_name ,r.HireDate FROM users u 
		                     INNER join rel_user_Decforum r  
		                     on u.userID = r.userID 
		                     
		                     INNER JOIN decisions  d
			                 ON d.decID=r.decID 
		                     
		                     INNER join forum_dec f  
		                     on f.forum_decID = r.forum_decID
		
		                    
		                     
		                     WHERE f.forum_decID = $forum_decID
		                     AND d.decID=$decID
		                     ORDER BY u.full_name ASC";


//for($i=0; $i<count($rows); $i++){	
//				if($i==0){
//					$userIDs = $rows[$i]->userID;
//				}
//				else{
//					$userIDs .= "," . $rows[$i]->userID;
//
//				}
//			
//			}





   if($rows=$db->queryObjectArray($sql )){

foreach ($rows as $row  )

   {
		$t['total']++;
		$t['list'][] =prepareUserRow($row) ;
   }
 }
echo json_encode($t);
	exit;

}
/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['pre_editUser']))
{
	//check_write_access();
	//$id = (int)$_GET['editUser'];
	$id = (int)$_GET['userID'];
	$forum_decID = (int)$_GET['forum_decID'];
	$decID = (int)$_GET['decID'];


	$sql="                 
    SELECT u.userID  FROM users u          
                     WHERE u.userID=(SELECT m.userID FROM managers m
                     WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";



	if($rows=$db->queryObjectArray($sql)){
		$userID=$rows[0]->userID;
	}
/*************************************/
	 if($userID==$id){//manager update
/**************************************/

       $sql="SELECT tagID FROM rel_user_forum  	          
	        WHERE u.userID=(SELECT m.userID FROM managers m
            WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";

           if($rows=$db->queryObjectArray($sql)){
	          $tagID=$rows[0]->tagID;
                }else
	               $tagID=null;

	          $t = array();
	          $t['total'] = 0;
/*****************************************************/
$sql="SELECT u.* , r.forum_decID,r.tagID,r.tags,r.duedate,r.prio,r.HireDate FROM users u 
                     LEFT  JOIN rel_user_forum r  
                     ON r.userID = u.userID              
                      WHERE u.userID=(SELECT m.userID FROM managers m
                     WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID) ) ";
	                    if($tagID)
	                 $sql.=" AND r.tagID=$tagID";
/*********************************************************/
	          $r = $db->queryObjectArray($sql);
					if($r) {
						$r=$r[0];

						$t['list'][] = prepareUserRow($r);
						$t['total'] = 1;
					 }
				echo json_encode($t);
				exit;
/**************************************FORUM USERS*****************************************************/
}else{

$sql="SELECT tagID FROM rel_user_forum  	          
      WHERE  forum_decID = $forum_decID
       AND  userID=$id ";
if($rows=$db->queryObjectArray($sql)){
	$tagID=$rows[0]->tagID;
}else{
	$tagID=null;
}


	$t = array();
	$t['total'] = 0;

	$sql= "SELECT u.* , r.forum_decID,r.tagID,r.tags,r.duedate,r.prio,r.HireDate  FROM users u 
                     LEFT  join rel_user_forum r  
                     ON u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     AND r.userID=$id  ";

	                  if($tagID)
	                 $sql.=" AND r.tagID=$tagID";



	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareUserRow($r);

		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
   }
}


/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['update_active']))
{

  global  $db;
	$userID = (int)$_GET['userID'];
	$forum_decID = (int)$_GET['forum_decID'];
	$active = (int)$_GET['active'];
	$status='';
	if($active==2)
	$status=1;
	else
	$status=2;


	 $t = array();
	 $t['total'] = 0;




$sql="UPDATE rel_user_forum set active='$status' WHERE forum_decID = $forum_decID AND userID=$userID  ";
if(!$db->execute($sql))
  return FALSE;


$sql= "SELECT  userID,forum_decID,active  FROM rel_user_forum
                     WHERE forum_decID = $forum_decID
                     AND  userID=$userID  ";



	if($r = $db->queryObjectArray($sql)){
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareUserRow($r);

		$t['total'] = 1;
	}
}


	echo json_encode($t);
	exit;
   }


/******************************************************************************************************************/
elseif(isset($_GET['update_data_module'])){
	global  $db;

	$forum_decID = (int)$_GET['forum_decID'];

	 $t = array();
	 $t['total'] = 0;







$sql= "SELECT  forum_decName  FROM forum_dec
                     WHERE forum_decID = $forum_decID";



	if($r = $db->queryObjectArray($sql)){
	if($r) {
		$r=$r[0];
		$t['list'][] = $r;

		$t['total'] = 1;
	}
}


	echo json_encode($t);
	exit;


}
/********************************************************************************************************************/

elseif(isset($_GET['editUser']))
{
	check_write_access();
	$id = (int)$_GET['editUser'];
	$forum_decID = trim(_post('forum_decID'));
	$decID = trim(_post('decID'));
//	if($forum_decID){
//	phpinfo();die; 
//	}

	 stop_gpc($_POST);

	$full_name = trim(_post('full_name'));
	$note = str_replace("\r\n", "\n", trim(_post('note')));

	$prio = (int)_post('prio');
	if($prio < -1) $prio = -1;
	elseif($prio >3) $prio = 3;

	$level= trim(_post('level'));
	if($level=='1'){
	   $level='user';
	}
	elseif($level=='2'){
	   $level='admin';
	   }
	   elseif($level=='3'){
	   $level='suppervizer';
	   }


	$email = trim(_post('email'));
	$upass=trim(_post('upass'));
	$uname=trim(_post('uname'));
	$phone=trim(_post('phone'));
	$active=trim(_post('active'));

	$duedate = parse_duedate(trim(_post('duedate')));
    $HireDate = parse_duedate(trim(_post('HireDate')));
    $manager_date = parse_duedate(trim(_post('manager_date')));

	$t = array();
	$t['total'] = 0;
	if($full_name == '') {
		echo json_encode($t);
		exit;
	}


/*************************************************************************************/
	$sql="SELECT managerID FROM forum_dec  WHERE forum_decID=$forum_decID";
         if($rows=$db->queryObjectArray($sql)){
		      $mgr=$rows[0]->managerID;
	     }


	$sql="                 
    SELECT u.userID  FROM users u          
                     WHERE u.userID=(SELECT m.userID FROM managers m
                     WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";



	if($rows=$db->queryObjectArray($sql)){
		$userID=$rows[0]->userID;
	}
/******************************************MANAGER_UPDATE***************************************************/
  if($userID==$id){
/********************************************************************************************/
    $tags = trim(_post('tags'));
	$db->execute("BEGIN");


    $tag_ids = prepare_usertags($tags);
    $tagID= $tag_ids[0];//get_taguser_id($tag);

    //CHECK if it the currrentID
   	$cur_ids = get_user_tagsMgr($id,$forum_decID,$mgr);
	if($cur_ids && $cur_ids[0]!=null) {
		$ids = implode(',', $cur_ids);
		$db->execute("UPDATE   forum_dec set tagID=NULL,tags=''  where tagID=$ids 
		              AND forum_decID=$forum_decID AND managerID=$mgr");

		$sql=("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($ids)");//dq
		$db->execute($sql);
	}

	if($tag_ids) {

			update_user_tagsMgr($id, $tag_ids,$forum_decID,$tags,$mgr);

    }
/**********************************************************************************************************/
if(is_null($duedate)) $duedate = 'NULL'; else $duedate = $db->sql_string($duedate);
if(is_null($manager_date)) $manager_date = 'NULL'; else $manager_date = $db->sql_string($manager_date);
if(is_null($note)) $note = 'NULL'; else $note = str_replace("\r\n", "\n", trim($note ));// $note = $db->sql_string($note);

if($manager_date){
	 $sql = "UPDATE forum_dec SET  " .
      "manager_date="     .  $manager_date . " , " .
	  "duedate="     .  $duedate . " , " .
	  "prio="     .  $db->sql_string($prio) . "  " .
	  "WHERE forum_decID=$forum_decID";
	 	if(!($db->execute($sql)) ){
	       return FALSE;
	     }

	 }




	$sql = "UPDATE users SET  " .
      "full_name="     .  $db->sql_string($full_name) . ", " .
	  "note="     .  $db->sql_string($note) . ", " .
	  "upass="     .  $db->sql_string($upass) . ", " .
	  "level="     .  $db->sql_string($level) . ", " .
	  "email="     .  $db->sql_string($email) . ", " .
	  "uname="     .  $db->sql_string($uname) . ", " .
	  "phone_num="     .  $db->sql_string($phone) . ", " .
	  "active="     .  $db->sql_string($active) . "  " .

	  "WHERE userID=$id";

		if($db->execute($sql) ){
	      $db->execute("COMMIT");
	     }

	$sql= "SELECT u.* ,f.forum_decID,f.tagID,f.tags,f.manager_date,f.duedate,f.prio FROM users u 
	   
	                 INNER  join rel_user_forum r  
                     ON u.userID = r.userID
                     
                     INNER join forum_dec f  
                     
                     ON f.forum_decID = r.forum_decID
                     
                     WHERE f.forum_decID = $forum_decID
                     AND u.userID=$id ";
	                  if($tagID)
	                 $sql.=" AND f.tagID=$tagID";


	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareUserRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;

/**********************************************************************************************************/
} else{
/***************************************USER UPDATE****************************************************************/

	$tags = trim(_post('tags'));
	$db->execute("BEGIN");


    $tag_ids = prepare_usertags($tags);
    $tagID= $tag_ids[0];//get_taguser_id($tag);

    //CHECK if it the currrentID
   	$cur_ids = get_user_tags($id,$forum_decID);
	if($cur_ids && $cur_ids[0]!=null) {
		$ids = implode(',', $cur_ids);
		$db->execute("UPDATE   rel_user_forum set tagID=NULL,tags=''  where tagID=$ids 
		              AND userID=$id  AND forum_decID=$forum_decID");
		//$db->execute("DELETE FROM tag2user WHERE userID=$id");
		$sql=("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($ids)");//dq
		$db->execute($sql);
	}

	if($tag_ids) {

			update_user_tags($id, $tag_ids,$forum_decID,$tags);

    }

}//end else
/**************************************/

	if(is_null($duedate)) $duedate = 'NULL'; else $duedate = $db->sql_string($duedate);
	if(is_null($HireDate)) $HireDate = 'NULL'; else $HireDate = $db->sql_string($HireDate);
    if(is_null($note)) $note = 'NULL'; else $note = str_replace("\r\n", "\n", trim($note ));// $note = $db->sql_string($note);




	$sql = "UPDATE users SET  " .
      "full_name="     .  $db->sql_string($full_name) . ", " .
	  "note="     .  $db->sql_string($note) . ", " .
	  "upass="     .  $db->sql_string($upass) . ", " .
	  "level="     .  $db->sql_string($level) . ", " .
	  "email="     .  $db->sql_string($email) . ", " .
	  "uname="     .  $db->sql_string($uname) . ", " .
	  "phone_num="     .  $db->sql_string($phone) . ", " .
	  "active="     .  $db->sql_string($active) . "  " .

	  "WHERE userID=$id";

		if(!($db->execute($sql)) ){
	      	      return false;
	     }
$sql = "UPDATE rel_user_forum SET  " .
      	  "duedate="    .  stripslashes($duedate) . " , " .
          "HireDate="    .  stripslashes($HireDate) . " , " .
          "prio="     .  $db->sql_string($prio) . "  " .
	  	  "WHERE userID=$id  AND  forum_decID=$forum_decID";



if(!($db->execute($sql)) ){
	       return false;
	     }else{
	     	$db->execute("COMMIT");
	     }


	$sql= "SELECT u.* , r.forum_decID,r.tagID,r.tags,r.duedate,r.prio,r.HireDate  FROM users u 
                     LEFT  join rel_user_forum r  
                     ON u.userID = r.userID              
                     WHERE r.forum_decID = $forum_decID
                     
                     AND r.userID=$id ";

	                  if($tagID)
	                 $sql.=" AND r.tagID=$tagID";


	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareUserRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['pre_editDec']))
{
	//check_write_access();
	//$id = (int)$_GET['editUser'];

	$forum_decID = (int)$_GET['forum_decID'];
	$decID = (int)$_GET['decID'];
	$catID = (int)$_GET['catID'];





	$t = array();
	$t['total'] = 0;

	$sql="SELECT d.*,v.grade_level,
	       r.catID,c.catName,rf.forum_decID,rf.note,f.forum_decName
	       FROM decisions d 
	       LEFT JOIN  vote_grade v ON  d.vote_level BETWEEN v.low_vote AND v.high_vote 
	       LEFT JOIN rel_cat_dec r ON d.decID=r.decID
	       LEFT JOIN categories c ON c.catID=r.catID
	       LEFT JOIN rel_forum_dec rf ON d.decID=rf.decID
	       LEFT JOIN forum_dec f ON f.forum_decID=rf.forum_decID 
	       WHERE d.decID=$decID
	       AND rf.forum_decID=$forum_decID
               AND r.catID=$catID ";


	$r = $db->queryObjectArray($sql);
	if($r) {
		  $r=$r[0];
		$t['list'][] =$r;
		//prepareDecRow($r);

		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
   }


/******************************************************************************************************************/

elseif(isset($_GET['pre_editMgr']))
{
	$userID = (int)$_GET['userID'];
	$forum_decID = (int)$_GET['forum_decID'];



       $sql="SELECT f.tagID FROM forum_dec  f	          
             WHERE f.forum_decID=$forum_decID";
// 	        WHERE f.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)


           if($rows=$db->queryObjectArray($sql)){
	          $tagID=$rows[0]->tagID;
                }else
	               $tagID=null;

	          $t = array();
	          $t['total'] = 0;
/*****************************************************/
$sql="SELECT m.managerID,f.forum_decID,f.tagID,f.tags,f.manager_date,f.prio,f.duedate,u.*   FROM managers m
                 
                    LEFT  JOIN users  u  
                     ON m.userID = u.userID   

                    LEFT  JOIN rel_user_forum r  
                     ON r.userID = u.userID   

                     LEFT  JOIN  forum_dec f  
                     ON f.forum_decID = $forum_decID
                     
                      WHERE m.userID= $userID";
	          if($tagID)
	                 $sql.=" AND f.tagID=$tagID";

/*********************************************************/
	          $r = $db->queryObjectArray($sql);
					if($r) {
			$row=$r[0];

			 $t['list'][] = prepareUserRow($row);
			 $t['total'] = 1;
		           $results[] = array('id'=>$row->userID,'forum_decID'=>$row->forum_decID,'full_name'=>$row->full_name,'manager_date'=>$row->manager_date,
		                 'managerID'=>$row->managerID,'date'=>$row->date,'prio'=>$row->prio,'note'=>$row->note,'uname'=>$row->uname,
		                 'email'=>$row->email,'level'=>$row->level,'phone_num'=>$row->phone_num,'tags'=>$row->tags,'upass'=>$row->upass);
					}
			 echo json_encode($t);
				exit;


}

/******************************************************************************************************************/
elseif(isset($_GET['newNormalUser']))
{
	$t = array();
	$t['total'] = 0;

	$userID = trim(_post('userID'));
	$active =trim(_post('active'));
	$level = trim(_post('level'));
	$user_date = trim(_post('user_date'));
	$full_name= trim(_post('full_name'));
	$fname= trim(_post('fname'));
	$lname= trim(_post('lname'));
	$uname= trim(_post('uname'));
	$upass= trim(_post('upass'));
	$phone_num= trim(_post('phone_num'));
	$email= trim(_post('email'));
	$note= trim(_post('note'));
	$user_date=substr($user_date, 0,10);


	$level= trim(_post('level'));
	IF($level=='1'){
	   $level='user';
	}
	ELSEIF($level=='2'){
	   $level='admin';
	   }
    ELSEIF($level=='3'){
	   $level='suppervizer';
	   }
    ELSEIF($level=='4'){
	   $level='user_admin';
	   }

	$tz = (int)_post('tz');
	if( (isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0 )
	$d = strftime("%Y-%m-%d %H:%M:%S");
	else
	$d = gmdate("Y-m-d H:i:s", time()+$tz*60);





	$sql=("SELECT MAX(ow) FROM users");
	//$db->queryObjectArray($sql);
	$ow = 1 + (int)$db->queryObjectArray($sql);

	$sql=("BEGIN");
	$db->execute($sql);

	$now	=	date('Y-m-d H:i:s');

/********************************************************************/

/********************************************************************/



if($userID  ){

$sql = "UPDATE users SET  " .
	"active="     .  $db->sql_string($active) . ", " .
	  "level="     . $db->sql_string($level) . ", " .
	  "user_date=" . $db->sql_string($user_date) . ", " .
	  "full_name=" . $db->sql_string($full_name) . ", " .
	  "fname="    .  $db->sql_string($fname) . ", " .
	  "lname="    .  $db->sql_string($lname) . ", " .
	  "uname="    .  $db->sql_string($uname) . ", " .
	"upass="     .   $db->sql_string($upass) . ", " .
	"phone_num="  .  $db->sql_string($phone_num) . ", " .
	"note="     .    $db->sql_string($note) . ", " .
	  "email="    .  $db->sql_string($email)  . "  " .
	  "WHERE userID=$userID";

	if(!$db->execute ($sql) )
	   return false;

}else{
$sql = "INSERT INTO users (active,level,user_date, full_name, fname, lname, uname, upass, phone_num, note, email,ow )VALUES ( " .
        $db->sql_string($active) . ", " .
        $db->sql_string($level) . ", " .
		$db->sql_string($user_date) . ", " .
		$db->sql_string($full_name) . ", " .
		$db->sql_string($fname) . ", " .
		$db->sql_string($lname) . ", " .
		$db->sql_string($uname) . ", " .
		$db->sql_string($upass) . ", " .
		$db->sql_string($phone_num) . ", " .
		$db->sql_string($note) . ", " .
		$db->sql_string($email) . ", " .
		$db->sql_string($ow) . " ) " ;

		if(!$db->execute ($sql) )
	   return false;

	   $userID = $db->insertId() ;
}





	$db->execute("COMMIT");

	$sql="SELECT *  FROM users WHERE userID=$userID  ";

	$r = $db->queryObjectArray($sql);
	$r=$r[0];

	$t['list'][] = prepareNormalUserRow($r);
	$t['total'] = 1;
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/




/******************************************************************************************************************/
//elseif(isset($_GET['newPastUser']))
//{ 
//	$t = array();
//	$t['total'] = 0;
//	
//	$userID = trim(_post('userID'));
//	$forum_decID = trim(_post('forum_decID'));
//	$active =trim(_post('active'));
//	$level = trim(_post('level'));
//	$start_date = trim(_post('start_date'));
//	$end_date = trim(_post('end_date'));
//	$note= trim(_post('note'));
//
//
//	
//	$level= trim(_post('level'));
//	IF($level=='1'){
//	   $level='user';
//	}	
//	ELSEIF($level=='2'){
//	   $level='admin';
//	   }
//    ELSEIF($level=='3'){
//	   $level='suppervizer';
//	   }
//    ELSEIF($level=='4'){
//	   $level='user_admin';
//	   }
//	   
//	$tz = (int)_post('tz');
//	
//	
//	$db->execute("START TRANSACTION");
//	
//	 
//	
//	
//$sql = "INSERT INTO rel_user_forum_history (active,start_date,end_date, forum_decID,userID )VALUES ( " .
//        $db->sql_string($active) . ", " . 
//		$db->sql_string($start_date) . ", " .
//		$db->sql_string($end_date) . ", " .
//	    $db->sql_string($forum_decID) . ", " .
//	    $db->sql_string($userID) . " ) " ; 
//		
//		if(!$db->execute ($sql) )
//	   return false;
//	
//	
//	
//	
//	
//	$db->execute("COMMIT");
//
//$t = array();
//	$t['total'] = 0;
//	
//	$sql = "SELECT uh.*,u.full_name,u.fname,u.lname,u.level,u.note,f.forum_decName,f.forum_decID FROM rel_user_forum_history uh				 
//			INNER JOIN users u ON(uh.userID=u.userID)
//			INNER JOIN forum_dec f ON(f.forum_decID=uh.forum_decID) 
//			WHERE uh.userID=$userID AND f.forum_decID=$forum_decID
//            ORDER BY u.fname"; 
//	                      
//	                 
//	$r = $db->queryObjectArray($sql);
//	if($r) {
//		$r=$r[0];
//		$t['list'][] = preparePastUserRow($r);
//		$t['total'] = 1;
//	}
//	echo json_encode($t); 
//	exit;
//}

/******************************************************************************************************************/


elseif(isset($_GET['pre_editUserPrint']))
{
	$id = (int)$_GET['userID'];
	$t = array();
	$t['total'] = 0;

	$sql= "SELECT * from users where userID=$id ";


	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareNormalUserRow($r);
		//$t['list'][] =$r;
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['preEdit_past_user']))
{
	$userID = (int)$_GET['userID'];
	$forum_decID= (int)$_GET['forum_decID'];
	$t = array();
	$t['total'] = 0;

	$sql = "SELECT uh.*,u.full_name,u.fname,u.lname,u.level,u.note,f.forum_decName,f.forum_decID FROM rel_user_forum_history uh				 
			INNER JOIN users u ON(uh.userID=u.userID)
			INNER JOIN forum_dec f ON(f.forum_decID=uh.forum_decID) 
			WHERE uh.userID=$userID AND f.forum_decID=$forum_decID
            ORDER BY u.fname";


	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = preparePastUserRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
elseif(isset($_GET['submit_PastNormalUser']))
{
	$t = array();
	$t['total'] = 0;
	$result=true;



	$userID = trim(_post('userID'));
	$forumID_src = trim(_post('forumID_src'));
	$forum_decID = trim(_post('forum_decID'));
	$active =trim(_post('active'));
	$level = trim(_post('level'));
	$start_date = trim(_post('start_date'));
	$end_date = trim(_post('end_date'));
	$full_name= trim(_post('full_name'));
	$fname= trim(_post('fname'));
	$lname= trim(_post('lname'));

	$mode= trim(_post('mode'));



	$level= trim(_post('level'));
	IF($level=='1'){
	   $level='user';
	}
	ELSEIF($level=='2'){
	   $level='admin';
	   }
    ELSEIF($level=='3'){
	   $level='suppervizer';
	   }
    ELSEIF($level=='4'){
	   $level='user_admin';
	   }

	$tz = (int)_post('tz');


	$db->execute("START TRANSACTION");




if($mode=='update' ){


$sql="DELETE FROM  rel_user_forum_history WHERE userID=$userID AND forum_decID=$forumID_src";
if(!$db->execute($sql))
return FALSE;


$sql = "INSERT INTO rel_user_forum_history (active,start_date,end_date, forum_decID,userID )VALUES ( " .
        $db->sql_string($active) . ", " .
		$db->sql_string($start_date) . ", " .
		$db->sql_string($end_date) . ", " .
	    $db->sql_string($forum_decID) . ", " .
	    $db->sql_string($userID) . " ) " ;

		if(!$db->execute ($sql) )
	   return false;







}elseif($mode=='change_details'){

$sql = "UPDATE rel_user_forum_history SET  " .
	  "active="     .  $db->sql_string($active) . ", " .
	  "start_date=" . $db->sql_string($start_date) . ", " .
      "end_date=" . $db->sql_string($end_date) . "  " .

	  "WHERE userID=$userID AND forum_decID=$forum_decID";

	if(!$db->execute ($sql) )
	   return false;


}
else{

/****************************FAILURE****************************************/


$sql="SELECT forum_decID ,userID FROM rel_user_forum_history  WHERE userID=$userID AND  forum_decID=$forum_decID";	//getthe forums

  if($db->querySingleItem($sql)>0) {
  	$sql="SELECT u.full_name ,f.forum_decName FROM  rel_user_forum_history r 
  LEFT JOIN users u ON u.userID=r.userID
    LEFT JOIN forum_dec f ON  f.forum_decID=r.forum_decID
  	       WHERE r.userID=$userID
  	       AND   r.forum_decID=$forum_decID";

  	if($rows=$db->queryObjectArray($sql)){
  	       $forum_decName=$rows[0]->forum_decName;
		        $full_name=$rows[0]->full_name;
  	        }


	    	try {
	            $result = FALSE;
			    throw new Exception("משתמש $full_name כבר קיים בפורום $forum_decName ");
	    	} catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();

	        }
   }

if(!$result){

	$i=0;

	foreach($message as $row){

	  $key="messageError_$i";
	 $message_name[$key]=$row ;
	 $i++;
	}


   $message_name['userID']=$userID;



	echo json_encode($message_name);
	exit;

   }







/********************************************************************/







$sql = "INSERT INTO rel_user_forum_history (active,start_date,end_date,forum_decID,userID)VALUES ( " .
        $db->sql_string($active) . ", " .
		$db->sql_string($start_date) . ", " .
		$db->sql_string($end_date) . ", " .
	    $db->sql_string($forum_decID) . ", " .
	   	$db->sql_string($userID) . " ) " ;

		if(!$db->execute ($sql) )
	   return false;


}





	$db->execute("COMMIT");


	$sql = "SELECT uh.*,u.full_name,u.fname,u.lname,u.level,u.note,f.forum_decName,f.forum_decID FROM rel_user_forum_history uh				 
			INNER JOIN users u ON(uh.userID=u.userID)
			INNER JOIN forum_dec f ON(f.forum_decID=uh.forum_decID) 
			WHERE uh.userID=$userID AND f.forum_decID=$forum_decID
            ORDER BY u.fname";

	if($r = $db->queryObjectArray($sql)){
	$r=$r[0];

	$t['list'][] = preparePastUserRow($r);
	$t['total'] = 1;

	$t['type'] = 'success';
	$t['message'] = 'עודכן בהצלחה!';
	}
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/






elseif(isset($_GET['submit_DecUser']))
{
	$t = array();
	$t['total'] = 0;
	$result=true;



	$userID = trim(_post('userID'));
	$forumID_src = trim(_post('forumID_src'));
	$forum_decID = trim(_post('forum_decID'));
	$decID = trim(_post('decID'));
	$active =trim(_post('active'));
	$level = trim(_post('level'));
	$start_date = trim(_post('start_date'));
	$end_date = trim(_post('end_date'));
//	$full_name= trim(_post('full_name'));
//	$fname= trim(_post('fname'));
//	$lname= trim(_post('lname'));

	//$mode= trim(_post('mode'));



	$level= trim(_post('level'));
	IF($level=='1'){
	   $level='user';
	}
	ELSEIF($level=='2'){
	   $level='admin';
	   }
    ELSEIF($level=='3'){
	   $level='suppervizer';
	   }
    ELSEIF($level=='4'){
	   $level='user_admin';
	   }

	$tz = (int)_post('tz');


	$db->execute("START TRANSACTION");




if($mode=='update' ){


$sql="DELETE FROM  rel_user_Decforum WHERE userID=$userID AND forum_decID=$forum_decID AND decID=$decID ";
if(!$db->execute($sql))
return FALSE;

 $sql = "INSERT INTO rel_user_Decforum (active,HireDate,end_date,decID, forum_decID,userID )VALUES ( " .
        $db->sql_string($active) . ", " .
		$db->sql_string($start_date) . ", " .
		$db->sql_string($end_date) . ", " .
		$db->sql_string($decID) . ", " .
	    $db->sql_string($forum_decID) . ", " .
	    $db->sql_string($userID) . " ) " ;

		if(!$db->execute ($sql) )
	   return false;




}elseif($mode=='change_details'){

$sql = "UPDATE rel_user_Decforum SET  " .
	  "active="     .  $db->sql_string($active) . ", " .
	  "start_date=" . $db->sql_string($start_date) . ", " .
      "end_date=" . $db->sql_string($end_date) . "  " .

	  "WHERE userID=$userID AND forum_decID=$forum_decID  AND decID=$decID ";

	if(!$db->execute ($sql) )
	   return false;


}
else{

/****************************FAILURE****************************************/


$sql="SELECT  decID ,forum_decID ,userID FROM rel_user_Decforum  WHERE userID=$userID AND  forum_decID=$forum_decID  AND  decID=$decID ";

  if($db->querySingleItem($sql)>0) {
  $sql="SELECT u.full_name ,f.forum_decName,
IF(CHAR_LENGTH(d.decName)>11, CONCAT(LEFT(d.decName,9), ' ... ', RIGHT(d.decName, 4)), d.decName) AS decName
  FROM  rel_user_Decforum r 
   LEFT JOIN users u ON u.userID=r.userID
   LEFT JOIN forum_dec f ON  f.forum_decID=r.forum_decID
   LEFT JOIN decisions d ON  d.decID=r.decID 
  	       WHERE r.userID=$userID
  	       AND   r.forum_decID=$forum_decID
  	       AND   r.decID=$decID";


  	if($rows=$db->queryObjectArray($sql)){
  	       $forum_decName=$rows[0]->forum_decName;
		        $full_name=$rows[0]->full_name;
		        $decName=$rows[0]->decName;

  	        }



	    	try {
	            $result = FALSE;
			    throw new Exception("משתמש $full_name שהיה שותף להחלטה $decName  כבר קיים בפורום $forum_decName ");
	    	} catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();

	        }
   }


if(!$result){

	$i=0;

	foreach($message as $row){

	  $key="messageError_$i";
	 $message_name[$key]=$row ;
	 $i++;
	}


   $message_name['userID']=$userID;



	echo json_encode($message_name);
	exit;

   }







/********************************************************************/

$sql = "INSERT INTO rel_user_Decforum (active,HireDate,end_date,decID, forum_decID,userID )VALUES ( " .
        $db->sql_string($active) . ", " .
		$db->sql_string($start_date) . ", " .
		$db->sql_string($end_date) . ", " .
		$db->sql_string($decID) . ", " .
	    $db->sql_string($forum_decID) . ", " .
	    $db->sql_string($userID) . " ) " ;

		if(!$db->execute ($sql) )
	   return false;


}





	$db->execute("COMMIT");


	$sql = "SELECT r.*,u.full_name,u.fname,u.lname,u.level,u.note,f.forum_decName,f.forum_decID,d.decID,
	         IF(CHAR_LENGTH(d.decName)>11, CONCAT(LEFT(d.decName,9), ' ... ', RIGHT(d.decName, 4)), d.decName) AS decName 
	        FROM rel_user_Decforum r				 
			INNER JOIN users u ON(r.userID=u.userID)
			INNER JOIN forum_dec f ON(r.forum_decID=f.forum_decID)
			INNER JOIN decisions d ON(r.decID=d.decID) 
			WHERE r.userID=$userID AND f.forum_decID=$forum_decID AND d.decID=$decID
            ORDER BY u.fname";


	if($r = $db->queryObjectArray($sql)){
	$r=$r[0];

	$t['list'][] = prepareDecUserRow($r);
	$t['total'] = 1;

	$t['type'] = 'success';
	$t['message'] = 'עודכן בהצלחה!';
	}
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/












/******************************************************************************************************************/

elseif(isset($_GET['edit_dec_frm_user']))
{
	$userID = (int)$_GET['userID'];
	$forum_decID= (int)$_GET['forum_decID'];
	$decID= (int)$_GET['decID'];
	$t = array();
	$t['total'] = 0;

	$sql = "SELECT ud.*,ud.HireDate AS start_date, u.full_name,u.fname,u.lname,u.level,u.note,
	        f.forum_decName,f.forum_decID,d.decID,IF(CHAR_LENGTH(d.decName)>14, CONCAT(LEFT(d.decName,9), ' ... ', RIGHT(d.decName, 6)), d.decName) AS decName 
	         FROM rel_user_Decforum ud				 
			INNER JOIN users u ON(ud.userID=u.userID)
			INNER JOIN forum_dec f ON(f.forum_decID=ud.forum_decID)
			INNER JOIN decisions d ON(d.decID=ud.decID) 
			WHERE ud.userID=$userID AND ud.forum_decID=$forum_decID AND ud.decID=$decID
            ORDER BY u.fname";


	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareDecUserRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
elseif(isset($_GET['submitDecForumUser']))
{
	$t = array();
	$t['total'] = 0;
	$result=true;



	$userID = trim(_post('userID'));
	$forumID_src = trim(_post('forumID_src'));
	$forum_decID = trim(_post('forum_decID'));
	$decID = trim(_post('decID'));
	$active =trim(_post('active'));
	$level = trim(_post('level'));
	$HireDate = trim(_post('HireDate'));
	$end_date = trim(_post('end_date'));
	$full_name= trim(_post('full_name'));
	$fname= trim(_post('fname'));
	$lname= trim(_post('lname'));

	$mode= trim(_post('mode'));



	$level= trim(_post('level'));
	IF($level=='1'){
	   $level='user';
	}
	ELSEIF($level=='2'){
	   $level='admin';
	   }
    ELSEIF($level=='3'){
	   $level='suppervizer';
	   }
    ELSEIF($level=='4'){
	   $level='user_admin';
	   }

	$tz = (int)_post('tz');


	$db->execute("START TRANSACTION");




if($mode=='update' ){


$sql="DELETE FROM  rel_user_Decforum WHERE userID=$userID AND forum_decID=$forumID_src AND decID=$decID";
if(!$db->execute($sql))
return FALSE;


$sql = "INSERT INTO rel_user_Decforum (active,HireDate,end_date, forum_decID,decID,userID )VALUES ( " .
        $db->sql_string($active) . ", " .
		$db->sql_string($HireDate) . ", " .
		$db->sql_string($end_date) . ", " .
	    $db->sql_string($forum_decID) . ", " .
	    $db->sql_string($decID) . ", " .
	    $db->sql_string($userID) . " ) " ;

		if(!$db->execute ($sql) )
	   return false;


}elseif($mode=='change_details'){

$sql = "UPDATE rel_user_Decforum SET  " .
	  "active="     .  $db->sql_string($active) . ", " .
	  "HireDate=" . $db->sql_string($HireDate) . ", " .
      "end_date=" . $db->sql_string($end_date) . "  " .

	  "WHERE userID=$userID AND forum_decID=$forum_decID AND decID=$decID";

	if(!$db->execute ($sql) )
	   return false;


}else{

/****************************FAILURE****************************************/


$sql="SELECT forum_decID ,userID ,decID FROM rel_user_Decforum  WHERE userID=$userID AND  forum_decID=$forum_decID AND decID=$decID";	//getthe forums

  if($db->querySingleItem($sql)>0) {
  $sql="SELECT u.full_name ,f.forum_decName,IF(CHAR_LENGTH(d.decName)>14, CONCAT(LEFT(d.decName,9), ' ... ', RIGHT(d.decName, 6)), d.decName)
        FROM  rel_user_Decforum r 
        LEFT JOIN users u ON u.userID=r.userID
        LEFT JOIN forum_dec f ON  f.forum_decID=r.forum_decID
        LEFT JOIN decisions d ON  d.decID=r.decID
  	    WHERE r.userID=$userID
  	    AND   r.forum_decID=$forum_decID
  	    AND   d.decID=$decID";

  	if($rows=$db->queryObjectArray($sql)){
  	       $forum_decName=$rows[0]->forum_decName;
		   $full_name=$rows[0]->full_name;
  	        }


	    	try {
	            $result = FALSE;
			    throw new Exception("משתמש $full_name כבר קיים בפורום $forum_decName ");
	    	} catch(Exception $e){
 			 $result=FALSE;
	         $message[]=$e->getMessage();

	        }
   }


if(!$result){

	$i=0;

	foreach($message as $row){

	  $key="messageError_$i";
	 $message_name[$key]=$row ;
	 $i++;
	}


   $message_name['userID']=$userID;



	echo json_encode($message_name);
	exit;

   }

/********************************************************************/
$sql = "INSERT INTO rel_user_Decforum (active,HireDate,end_date,forum_decID,decID,userID)VALUES ( " .
        $db->sql_string($active) . ", " .
		$db->sql_string($HireDate) . ", " .
		$db->sql_string($end_date) . ", " .
	    $db->sql_string($forum_decID) . ", " .
	    $db->sql_string($decID) . ", " .
	   	$db->sql_string($userID) . " ) " ;

		if(!$db->execute ($sql) )
	   return false;
}



	$db->execute("COMMIT");

    $sql = "SELECT r.*,r.HireDate AS start_date,u.full_name,u.fname,u.lname,u.level,u.note,f.forum_decName,f.forum_decID,
    IF(CHAR_LENGTH(d.decName)>14, CONCAT(LEFT(d.decName,9), ' ... ', RIGHT(d.decName, 6)), d.decName) AS decName
     FROM rel_user_Decforum r				 
			INNER JOIN users u ON(r.userID=u.userID)
			INNER JOIN forum_dec f ON(f.forum_decID=r.forum_decID) 
			INNER JOIN decisions d ON  d.decID=r.decID
	  	    WHERE r.userID=$userID
	  	    AND   r.forum_decID=$forum_decID
	  	    AND   d.decID=$decID 
            ORDER BY u.fname";

	if( $r = $db->queryObjectArray($sql) ){
	$r=$r[0];

	$t['list'][] = prepareDecUserRow($r);
	$t['total'] = 1;

	$t['type'] = 'success';
	$t['message'] = 'עודכן בהצלחה!';
	}
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/















else if( !empty($_REQUEST['deleteMultiTask']))
//elseif(isset ($_GET  ['deleteMultiTask'] )	) 
{
$checbox=array();
$checkbox=$_REQUEST['checkbox'];

$i=0;
for($i=0;$i<count($checkbox);$i++){


if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];

	check_write_access();
	$id = (int)$_REQUEST['checkbox'][$i];
	$tags = get_task_tags($id);
	$db->execute("BEGIN");
	if($tags && $tags[0] !=null) {
		$s = implode(',', $tags);
		$db->execute("DELETE FROM tag2task WHERE taskID=$id");
		$db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags
	}


	$sql="SELECT t.* , u.userID , rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  WHERE t.taskID=$id  
			            		  AND d.decID=$decID ";

	$r = $db->queryObjectArray($sql);
	$r=$r[0];
	$userID=$r->userID;



	$sql=("DELETE FROM rel_user_task WHERE taskID=$id AND userID=$userID");
	if(!$db->execute($sql) )
	return false;




	$sql=("DELETE FROM todolist WHERE taskID=$id AND decID=$decID");
	if($db->execute($sql) )
	$db->execute("COMMIT");

	$t = array();
	$t['total'] = $i;//$affected;
	$t['list'][] = array('id'=>$id);

}
	echo json_encode($t);

 	exit;
}
/******************************************************************************************************************/


elseif(isset($_GET['deleteTask']))
{
    if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];


	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];

	check_write_access();
	$id = (int)$_GET['deleteTask'];
	$tags = get_task_tags($id);
	$db->execute("BEGIN");
	if($tags && $tags[0] !=null) {
		$s = implode(',', $tags);
		$db->execute("DELETE FROM tag2task WHERE taskID=$id");
		$db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags
	}


/***********************************CHECK IF DEST_USERID IS MaNaGar************************************/
    	$sql="                 
         SELECT dest_userID from rel_user_task WHERE taskID=$id   AND forum_decID=$forum_decID";
    	if($rows=$db->queryObjectArray($sql)){
    		$dest_userID=$rows[0]->dest_userID;
    	}

$sql="                 
    SELECT u.userID  FROM users u          
    WHERE u.userID=(SELECT m.userID FROM managers m
    WHERE m.managerID=(SELECT f.managerID FROM forum_dec f WHERE f.forum_decID=$forum_decID)) ";

if($rows=$db->queryObjectArray($sql)){
	$mgr_userID=$rows[0]->userID;
if($dest_userID==$mgr_userID){
	  $sql = "UPDATE forum_dec SET  " .
      	  "duedate=  NULL   " .
	  "WHERE  forum_decID=$forum_decID";
    }else{

       $sql = "UPDATE rel_user_forum  SET  " .
      	  "duedate= NULL   " .
	  "WHERE userID=$dest_userID and forum_decID=$forum_decID";
/***************************************************/
    }
}

if(!$db->execute($sql) )
	   return false;
/**********************************************************************/



	$sql="SELECT t.* , u.userID , rt.dest_userID FROM todolist t
                                  left JOIN decisions  d
			            		  ON d.decID=t.decID 
                                  left JOIN rel_user_task  rt
			            		  ON rt.taskID=t.taskID
			            		  left JOIN users u
			            		  ON u.userID=rt.userID 
			            		  WHERE t.taskID=$id  
			            		  AND d.decID=$decID ";

	$r = $db->queryObjectArray($sql);
	$r=$r[0];
	$userID=$r->userID;



	$sql=("DELETE FROM rel_user_task WHERE taskID=$id AND userID=$userID");
	if(!$db->execute($sql) )
	return false;




	$sql=("DELETE FROM todolist WHERE taskID=$id AND decID=$decID");
	if($db->execute($sql) )
	$db->execute("COMMIT");




	$t = array();
	$t['total'] = 1;//$affected;
	$t['list'][] = array('id'=>$id);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['deleteUser']))
{
	check_write_access();
	$id = (int)$_GET['deleteUser'];
    $forum_decID=(int)$_GET['forum_decID'];
	// $forum_ID= trim(_post('forum_decID'));
    //var_dump($forum_decID); die;


 	$tags = get_user_tags($id,$forum_decID);
	$db->execute("BEGIN");
if($tags && $tags[0] !=null) {
		$s = implode(',', $tags);
		//$db->execute("DELETE FROM tag2user WHERE userID=$id");
		$db->execute("UPDATE user_tags SET tags_count=tags_count-1 WHERE tagID IN ($s)");
		$db->execute("DELETE FROM user_tags WHERE tags_count < 1");	# slow on large amount of tags
	}


$sql="SELECT t.taskID    FROM todolist t
                               
                                 left JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 left JOIN rel_user_forum  r
			            		 ON r.userID=u.userID 
                     			 where t.compl in(0,1)
                                 AND rt.userID=$id
                                 AND r.forum_decID=$forum_decID 
                                 ORDER BY t.duedate ASC ";

	if($rows = $db->queryObjectArray($sql)){
//		for($i=0; $i<count($rows); $i++)
//		if($i==0)
//		$taskIDs = $rows[$i]->taskID;
//		else
//		$taskIDs .= "," . $rows[$i]->taskID;

	foreach($rows as $row){
				if(!$taskIDs)
				$taskIDs  = $row->taskID;
				else
				$taskIDs .= ";" . $row->taskID;

			}

	$sql=("DELETE FROM rel_user_task WHERE userID=$id and taskID in($taskIDs)");
	 if(!$db->execute($sql) )
	    return FALSE;
	  $sql=("DELETE FROM todolist WHERE taskID IN ($taskIDs)");
	  if($db->execute($sql) )
	$db->execute("COMMIT");
	}
//	else{
//		$sql=("DELETE FROM rel_user_task WHERE userID=$id ");
//	
//	if($db->execute($sql) )
//	$db->execute("COMMIT");
//	}





	$sql=("DELETE FROM rel_user_forum WHERE userID=$id AND   forum_decID=$forum_decID");
	if($db->execute($sql) )
	$db->execute("COMMIT");

	$t = array();
	$t['total'] = 1;//$affected;
	$t['list'][] = array('id'=>$id);
	// $t['list'][] = array('id'=>$id,'forum_dec'=>$forum_decID);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['completeTask']))
{
	check_write_access();
	$id = (int)$_GET['completeTask'];
	$compl = _get('compl') ? 1 : 0;

	$sql=("UPDATE todolist SET compl= " .$db->sql_string($compl) . " WHERE taskID=$id");
	if(!$db->execute($sql ) )
	   return FALSE;
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'compl'=>$compl);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['completeUser2']))//new
{
	//check_write_access();
	$id = (int)$_GET['completeUser2'];
	$forum_decID = (int)$_GET['forum_decID'];
	$compl = _get('compl') ? 1 : 0;

	$sql=("UPDATE rel_user_forum SET compl= " .$db->sql_string($compl) . " WHERE userID=$id AND forum_decID=$forum_decID ");
	if(!$db->execute($sql ) )
	   return FALSE;
	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'compl'=>$compl,'forum_decID'=>$forum_decID);
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['editNote']))
{
	check_write_access();
	$id = (int)$_GET['editNote'];
	stop_gpc($_POST);
	$note = str_replace("\r\n", "\n", trim(_post('note')));

	$sql=("UPDATE todolist SET note= " .$db->sql_string($note) . " WHERE taskID=$id" );
	if(!$db->execute($sql ) )
	   return FALSE;

	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'note'=>nl2br(htmlarray($note)), 'noteText'=>(string)$note);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['edituserNote']))
{
	check_write_access();
	$id = (int)$_GET['edituserNote'];
	stop_gpc($_POST);
	$note = str_replace("\r\n", "\n", trim(_post('note')));

	$sql=("UPDATE users SET note= " .$db->sql_string($note) . " WHERE userID=$id" );
	if(!$db->execute($sql ) )
	   return FALSE;

	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'note'=>nl2br(htmlarray($note)), 'noteText'=>(string)$note);
	echo json_encode($t);
	exit;
}


/******************************************************************************************************************/
elseif(isset($_GET['editDecFrmNote']))
{
	//check_write_access();
	$decID = (int)$_GET['editDecFrmNote'];
	$forum_decID = (int)$_POST['forum_decID'];
	stop_gpc($_POST);
	$note = str_replace("\r\n", "\n", trim(_post('note')));

	$sql=("UPDATE rel_forum_dec SET note= " .$db->sql_string($note) . " WHERE decID=$decID  AND forum_decID=$forum_decID" );
	if(!$db->execute($sql ) )
	   return FALSE;

	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('decID'=>$decID, 'forum_decID'=>$forum_decID, 'note'=>nl2br(htmlarray($note)), 'noteText'=>(string)$note);
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['loadTask']))
{

   $taskID=$_REQUEST['id'];


	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	else $decID=$decID;





	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	$inner = '';
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_tag_id($tag);
		if(_get('compl')==3){
		$inner = "INNER JOIN tag2task ON t.taskID=tag2task.taskID";
		}else{
		$inner = "INNER JOIN tag2task ON todolist.taskID=tag2task.taskID";
		}
		$sqlWhere .= " AND tag2task.tagID=$tag_id ";
	}





	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0)
	$tz = null;



	$t = array();
	$t['total'] = 0;
	$t['list'] = array();
	$t['message'] = array();





	$sql="SELECT t.*,u.userID, u.full_name ,rt.dest_userID,t.forum_decID
                    FROM todolist t  
                                 LEFT JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID

			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID

			            		 LEFT JOIN rel_user_forum  rf 
			            		 ON u.userID=rf.userID
			            		 
			            		  
			            		
                                 $inner
			            		 WHERE t.compl in(0,1)
                                  
                                 AND t.decID=$decID 
                                 AND t.forum_decID=$forum_decID 
                                 AND t.taskID=$taskID ";



	$q = $db->queryObjectArray($sql);

	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;

		$t['list'][] = prepareTaskRow($r, $tz);


	}
	echo json_encode($t);
	exit;
}

/*********************************************************************************************************************/

elseif(isset($_GET['getTask']))
{
	check_read_access();
	$id = (int)$_GET['getTask'];
	$t = array();
	$t['total'] = 0;
//	$sql=("SELECT * FROM todolist WHERE taskID=$id");


	$sql="SELECT t.* ,distinct(u.userID), rt.dest_userID   FROM todolist t
                                 LEFT JOIN rel_user_task  rt
			            		 ON rt.taskID=t.taskID
			            		 LEFT JOIN users u
			            		 ON rt.userID=u.userID  
			            		 WHERE t.compl in(0,1)
                                 AND t.taskID=$id";




	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareTaskRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['getUser']))
{
	check_read_access();
	$id = (int)$_GET['getUser'];
	$t = array();
	$t['total'] = 0;
	$sql=("SELECT u.*,r.forum_decID,r.userID FROM users u 
	             LEFT JOIN  rel_user_forum r
	             ON r.userID=u.userID
	             WHERE u.userID=$id");
	$r = $db->queryObjectArray($sql);
	if($r) {
		$r=$r[0];
		$t['list'][] = prepareUserRow($r);
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
/******************************************************************************************************************/

elseif(isset($_GET['changeOrder']))
{
	check_write_access();
	stop_gpc($_POST);

	$s = _post('order');
	parse_str($s, $order);

	$t = array();
	$t['total'] = 0;

	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$sql=("UPDATE todolist SET $set WHERE taskID IN (".implode(',',$ids).")");
			$db->execute($sql);
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}

	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/

elseif(isset($_GET['changeuserOrder']))
{
	check_write_access();
	stop_gpc($_POST);


	$s = _post('order');
	parse_str($s, $order);


	$t = array();
	$t['total'] = 0;


	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$sql=("UPDATE users SET $set WHERE userID IN (".implode(',',$ids).")");
			$db->execute($sql);
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}


	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/

elseif(isset($_GET['changeuserOrder2']))
{
	check_write_access();
	stop_gpc($_POST);

	$forum_decID = _post('$forum_decID');
	$s = _post('order');
	parse_str($s, $order);


	$t = array();
	$t['total'] = 0;


	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$sql=("UPDATE users SET $set WHERE userID IN (".implode(',',$ids).") AND forum_decID=$forum_decID");
			$db->execute($sql);
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}


	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/


elseif(isset($_GET['changeOrder']))
{
	check_write_access();
	stop_gpc($_POST);

	$s = _post('order');
	parse_str($s, $order);

	$t = array();
	$t['total'] = 0;


	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$db->execute("UPDATE todolist SET $set WHERE taskID IN (".implode(',',$ids).")");
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}


	echo json_encode($t);
	exit;
}
/*******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['changeuserOrder']))
{
	check_write_access();
	stop_gpc($_POST);

	$s = _post('order');
	parse_str($s, $order);

	$t = array();
	$t['total'] = 0;

	if($order)
	{
		$ad = array();
		foreach($order as $id=>$diff) {
			$ad[(int)$diff][] = (int)$id;
		}
		$db->execute("BEGIN");
		foreach($ad as $diff=>$ids) {
			if($diff >=0) $set = "ow=ow+".$diff;
			else $set = "ow=ow-".abs($diff);
			$db->execute("UPDATE users SET $set WHERE userID IN (".implode(',',$ids).")");
		}
		$db->execute("COMMIT");
		$t['total'] = 1;
	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['login']))
{
	$t = array('logged' => 0);

	if(!$needAuth) {
		$t['disabled'] = 1;
		echo json_encode($t);
		exit;
	}

	stop_gpc($_POST);

	$password = _post('password');
	if($password == $config['password']) {
		$t['logged'] = 1;
		session_regenerate_id(1);
		$_SESSION['logged'] = 1;
	}
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/

elseif(isset($_GET['

logout']))
{
	$_SESSION = array();
	$t = array('logged' => 0);
	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['suggestTags']))
{
	//check_read_access();
	$begin = trim(_get('q'));
	$limit = (int)_get('limit');
	if($limit<1) $limit = 8;


	$sql=("SELECT name,tagID FROM tags WHERE name LIKE " . $db->sql_string($begin) . " AND tags_count>0 ORDER BY name LIMIT $limit");
	$q=$db->queryObjectArray($sql);

	$s = '';

if($q && $q!=null){
 foreach($q as $r){

    $s .= "$r->name |$r->tagID\n";

 }
	echo $s;
}
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['suggestuserTags']))
{
	//check_read_access();
	$begin = trim(_get('q'));
	$limit = (int)_get('limit');
	if($limit<1) $limit = 8;
	//$q = $db->dq("SELECT name,id FROM tags WHERE name LIKE " . $db->sql_string($begin) . " AND tags_count>0 ORDER BY name LIMIT $limit");


	$sql=("SELECT name,tagID FROM user_tags WHERE name LIKE " . $db->sql_string($begin) . " AND tags_count>0 ORDER BY name LIMIT $limit");
	$q=$db->queryObjectArray($sql);

	$s = '';
  if($q && $q!=null){
     foreach($q as $r){

 	 (string)$s .= "$r->name |$r->tagID\n";

     }
	  echo $s;
   }
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['setPrio']))
{
	check_write_access();
	$id = (int)$_GET['setPrio'];
	$prio = (int)_get('prio');

	if($prio < -1) $prio = -1;
	elseif($prio >3) $prio = 3;

	$sql=("UPDATE todolist SET prio=$prio WHERE taskID=$id");
	$db->execute($sql);

	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'prio'=>$prio);

	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['setuserPrio']))
{
	check_write_access();

	$id = (int)$_GET['setuserPrio'];
	$forum_decID = (int)$_GET['forum_decID'];
	$prio = (int)_get('prio');
	if($prio < -1) $prio = -1;
	elseif($prio >3) $prio = 3;

	$sql=("UPDATE rel_user_forum SET prio=$prio WHERE userID=$id and forum_decID=$forum_decID");
	$db->execute($sql);

	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('id'=>$id, 'prio'=>$prio);

	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['setmgrPrio']))
{
	check_write_access();

	$id = (int)$_GET['setuserPrio'];
	$forum_decID = (int)$_GET['forum_decID'];
	$prio = (int)_get('prio');
	if($prio < -1) $prio = -1;
	elseif($prio >3) $prio = 3;

	$sql=("UPDATE forum_dec SET prio=$prio WHERE  forum_decID=$forum_decID");
	$db->execute($sql);

	$t = array();
	$t['total'] = 1;
	$t['list'][] = array('forum_decID'=>$forum_decID, 'prio'=>$prio);

	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
/******************************************************************************************************************/
elseif(isset($_GET['tagCloud']))
{
	if($_REQUEST['forum_decID'])
	$forum_decID=$_REQUEST['forum_decID'];
	else $forum_decID=$forum_decID;

	if($_REQUEST['decID'])
	$decID=$_REQUEST['decID'];
	//AND t.decID=$decID
	$a = array();
	//$sql=("SELECT name,tags_count FROM tags WHERE tags_count>0 ORDER BY tags_count ASC");
	$sql=("SELECT t.taskID ,tg.name,tg.tags_count  FROM todolist t
             INNER JOIN tag2task t2t ON t2t.taskID=t.taskID 
             INNER JOIN tags tg ON tg.tagID=t2t.tagID
             WHERE tg.tags_count>0 
             AND t.forum_decID=$forum_decID
             ORDER BY tg.tags_count ASC");
	$q = $db->queryObjectArray($sql);

    if($q && $q !=null)
	foreach($q as $r){
	$a[$r->name] = $r->name	 ;
	}


	$t = array();
	$t['total'] = 0;

	$count = sizeof($a);
	if(!$count) {
		echo json_encode($t);
		exit;
	}

	$qmax = max(array_values($a));
	$qmin = min(array_values($a));

	if($count >= 10) $grades = 10;
	else $grades = $count;

	$step = ($qmax - $qmin)/$grades;

	foreach($a as $tag=>$q) {
		$t['cloud'][] = array('tag'=>$tag, 'w'=> tag_size($qmin,$q,$step) );
	}

	$t['total'] = $count;

	echo json_encode($t);
	exit;
}
/******************************************************************************************************************/
elseif(isset($_GET['taguserCloud']))
{
	$forum_decID=$_REQUEST['forum_decID'];
	$a = array();
	$sql=("SELECT u.userID ,ut.name,ut.tags_count  FROM users u
             INNER JOIN rel_user_forum r ON u.userID=r.userID 
             INNER JOIN user_tags ut ON ut.tagID=r.tagID
             WHERE ut.tags_count>0 
             AND r.forum_decID=$forum_decID
             ORDER BY ut.tags_count ASC");
	$q = $db->queryObjectArray($sql);

	if($q && $q !=null)
	foreach($q as $r){
	$a[$r->name] = $r->name	 ;
	}

	$t = array();
	$t['total'] = 0;
	$count = sizeof($a);
	if(!$count) {
		echo json_encode($t);
		exit;
	}
	$qmax = max(array_values($a));
	$qmin = min(array_values($a));
	if($count >= 10) $grades = 10;
	else $grades = $count;

	$step = ($qmax - $qmin)/$grades;
	foreach($a as $tag=>$q) {
		$t['cloud'][] = array('tag'=>$tag, 'w'=> tag_size($qmin,$q,$step) );
	}

	$t['total'] = $count;

	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
elseif(isset($_GET['taguserCloud_all']))
{
	$forum_decID=$_REQUEST['forum_decID'];
	$a = array();
	$sql=("SELECT u.userID ,ut.name,ut.tags_count  FROM users u
             INNER JOIN rel_user_forum r ON u.userID=r.userID 
             INNER JOIN user_tags ut ON ut.tagID=r.tagID
             WHERE ut.tags_count>0 
             
             ORDER BY ut.tags_count ASC");
	//AND r.forum_decID=$forum_decID
	$q = $db->queryObjectArray($sql);

	if($q && $q !=null)
	foreach($q as $r){
	$a[$r->name] = $r->name	 ;
	}

	$t = array();
	$t['total'] = 0;
	$count = sizeof($a);
	if(!$count) {
		echo json_encode($t);
		exit;
	}
	$qmax = max(array_values($a));
	$qmin = min(array_values($a));
	if($count >= 10) $grades = 10;
	else $grades = $count;

	$step = ($qmax - $qmin)/$grades;
	foreach($a as $tag=>$q) {
		$t['cloud'][] = array('tag'=>$tag, 'w'=> tag_size($qmin,$q,$step) );
	}

	$t['total'] = $count;

	echo json_encode($t);
	exit;
}

/******************************************************************************************************************/
elseif(isset($_GET['load_DecFrmNote']))
{
	 global $db;
   $decID=$_REQUEST['decID'];


	$t = array();
	$t['total'] = 0;
	$t['list'] = array();






	$sql="SELECT d.decName,d.decID, 
	       rf.forum_decID,rf.note,f.forum_decName
	       FROM decisions d 
	       LEFT JOIN rel_forum_dec rf ON d.decID=rf.decID
	       LEFT JOIN forum_dec f ON f.forum_decID=rf.forum_decID 
	       WHERE d.decID=$decID";



	$q = $db->queryObjectArray($sql);

	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;

		$t['list'][] =  $r;
	}
	echo json_encode($t);
	exit;
}



elseif(isset($action)) {
    if ($action == "showAll") {



    }
}
/******************************************************************************************************************/







































function prepareTaskRow($r, $tz=null)
{
 	$dueA = prepare_duedate($r->duedate, $tz);
	return array(
		'taskID' => $r->taskID,
	    'decID' => $r->decID,
	    'forum_decID' => $r->forum_decID,
	    'userID'=>$r->userID,
	    'dest_userID'=>$r->dest_userID,
	    'full_name' => htmlarray($r->full_name),
	    'dest_name' => htmlarray($r->dest_name),
		'title' => htmlarray($r->title),
		'date' => htmlarray($r->task_date),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		'tags' => htmlarray($r->tags),
	    'message'=> htmlarray($r->message),
	    'prog_bar' => (int)$r->prog_bar,
        'task_allowed' => htmlarray ($r->task_allowed),


	  'duedate' => $dueA['formatted'],
	  'dueClass' => $dueA['class'],
	  'dueStr' => $dueA['str'],
	  'dueInt' => date2int($r->duedate),
	);
}
/******************************************************************************************************************/
function prepareAvgRow($r){
	return array(
	'avg'=>(int)$r->avg,

   );
}
/****************************************************************/
function prepareuserDuedateRow($r, $tz=null)
{
	$dueA = prepare_duedate($r->duedate, $tz);
	return array(


	'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
			'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),
	);
}
/******************************************************************************************************************/

function prepareTask2userRow($r, $tz=null)
{
	$dueA = prepare_duedate($r->duedate, $tz);
	return array(
		'taskID' => $r->taskID,
	    'decID' => $r->decID,
	    'userID'=>$r->userID,
	    'dest_userID'=>$r->dest_userID,
		'title' => htmlarray($r->title),
	    'full_name' => htmlarray($r->full_name),
		'date' => htmlarray($r->task_date),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		'tags' => htmlarray($r->tags),
	    'message'=> htmlarray($r->message),
        'prog_bar' => (int)$r->prog_bar,

	'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
			'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),
	);
}
/******************************************************************************************************************/
function prepareUserRow($r)
{

	$dueA = prepare_duedate($r->duedate, $tz);
	//$r->note = str_replace("\r\n", "\n", trim($r->note));
		return array(
		'userID' => $r->userID,
		//'dest_userID' => $r->dest_userID,
		'forum_decID' => $r->forum_decID,
		'forum_decName' =>htmlarray($r->forum_decName),
		'full_name' => htmlarray($r->full_name),
		'managerID' => $r->managerID,
		'manager_date' => htmlarray($r->manager_date),
		'user_date' => htmlarray($r->user_date),
		'date' => htmlarray($r->user_date),
		'HireDate' => htmlarray($r->HireDate),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
 		'note' => nl2br(htmlarray($r->note) ),
        'note' => nl2br($r->note ),

		//'note' =>(string) $r->note,
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		'uname' =>  $r->uname ,
	    'tags' => htmlarray($r->tags),
		'email' => htmlarray($r->email),
		'upass' =>(string) $r->upass,
		'level' =>(string) $r->level,
		'phone_num' =>(string) $r->phone_num,
		'active' =>  $r->active,


//		return array(
//		'userID' => $r->userID,
//		'dest_userID' => $r->dest_userID, 
//		'forum_decID' => $r->forum_decID,
//		'full_name' => htmlarray($r->full_name),
//		'managerID' => $r->managerID,
//		'date' => htmlarray($r->user_date),
//		'compl' => (int)$r->compl ,
//		'prio' => $r->prio,
//		'note' => nl2br(htmlarray($r->note) ),
//		'noteText' =>(string) $r->note,
//		'ow' => (int)$r->ow,
//		'uname' =>  htmlarray($r->uname) , 
//	    'upass' =>htmlarray($r->upass),
//		'tags' => htmlarray($r->tags),
//		'email' => htmlarray($r->email),
//		
//		'level' =>htmlarray($r->level),
//		'phone_num' =>htmlarray($r->phone_num),
//		'active' =>  $r->active,


		'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
		'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),

	);
}

/******************************************************************************************************************/
function prepareNormalUserRow($r)
{
		return array(
		'userID' => $r->userID,
		'active' => $r->active,
	    'level' =>(string) $r->level,
		'user_date' => htmlarray($r->user_date),
		'full_name' => htmlarray($r->full_name),
		'fname' => htmlarray($r->fname),
		'lname' => htmlarray($r->lname),
		'uname' => htmlarray($r->uname),
		'upass' =>(string) $r->upass,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'phone_num' =>(string) $r->phone_num,
		'email' => htmlarray($r->email),
		'ow' => (int)$r->ow,

	);
}

/******************************************************************************************************************/
function preparePastUserRow($r)
{
		return array(
		'userID' => (int)$r->userID,
		'forum_decID' =>(int) $r->forum_decID,
		'forum_decName' => htmlarray($r->forum_decName),
		'active' => $r->active,
	    'level' =>(string) $r->level,
		'start_date' => substr(htmlarray($r->start_date),0,10),
		'end_date' =>   substr(htmlarray($r->end_date),0,10),
     	'full_name' => htmlarray($r->full_name),
 		'fname' => htmlarray($r->fname),
 		'lname' => htmlarray($r->lname),
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,



	);
}

/******************************************************************************************************************/
function prepareDecUserRow($r)
{
		return array(
		'userID' => (int)$r->userID,
		'forum_decID' =>(int) $r->forum_decID,
		'decID' =>(int) $r->decID,
		'forum_decName' => htmlarray($r->forum_decName),
		'decName' => htmlarray($r->decName),
		'active' => $r->active,
	    'level' =>(string) $r->level,
		'start_date' => substr(htmlarray($r->start_date),0,10),
		'HireDate' => substr(htmlarray($r->HireDate),0,10),
		'end_date' =>   substr(htmlarray($r->end_date),0,10),
     	'full_name' => htmlarray($r->full_name),
 		'fname' => htmlarray($r->fname),
 		'lname' => htmlarray($r->lname),
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,



	);
}

/******************************************************************************************************************/

function prepareuserTaskRow($r, $tz=null)
{
	$dueA = prepare_duedate($r->duedate, $tz);
	return array(
	    'full_name' => htmlarray($r->full_name),
		'taskID' => $r->taskID,
		'title' => htmlarray($r->title),
		'date' => htmlarray($r->task_date),
		'compl' => (int)$r->compl ,
		'prio' => $r->prio,
		'note' => nl2br(htmlarray($r->note) ),
		'noteText' =>(string) $r->note,
		'ow' => (int)$r->ow,
		'tags' => htmlarray($r->tags),
        'message'=> htmlarray($r->message),
	    'prog_bar' => (int)$r->prog_bar,

     	'duedate' => $dueA['formatted'],
		'dueClass' => $dueA['class'],
	    'dueStr' => $dueA['str'],
		'dueInt' => date2int($r->duedate),
	);
}
/******************************************************************************************************************/
/******************************************************************************************************************/
function check_read_access()
{
	if(canAllRead() || is_logged()) return;
	echo json_encode( array('total'=>0, 'list'=>array(), 'denied'=>1) );
	exit;
}

/******************************************************************************************************************/

function check_write_access()
{
	global $config;
	if(!isset($config['password']) || $config['password'] == '') return;
	if(is_logged()) return;
	echo json_encode( array('total'=>0, 'list'=>array(), 'denied'=>1) );
	exit;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
function prepare_tags($tags_str)
{
	$tag_ids = array();
	$tag_names = array();
	$tags = explode(',', $tags_str);
	foreach($tags as $v)
	{
		# remove duplicate tags?
		$tag = str_replace(array('"',"'"),array('',''),trim($v));
		if($tag == '') continue;
		list($tag_id,$tag_name) = get_or_create_tag($tag);
		if($tag_id && !in_array($tag_id, $tag_ids)) {
			$tag_ids[] = $tag_id;
			$tag_names[] = $tag_name;
		}
	}
	$tags_str = implode(',', $tag_names);
	return $tag_ids;
}

/******************************************************************************************************************/
function prepare_usertags($tags_str)
{
	$tag_ids = array();
	$tag_names = array();
	$tags = explode(',', $tags_str);
	foreach($tags as $v)
	{
		# remove duplicate tags?
		$tag = str_replace(array('"',"'"),array('',''),trim($v));
		if($tag == '') continue;
		list($tag_id,$tag_name) = get_or_create_usertag($tag);
		if($tag_id && !in_array($tag_id, $tag_ids)) {
			$tag_ids[] = $tag_id;
			$tag_names[] = $tag_name;
		}
	}
	$tags_str = implode(',', $tag_names);
	return $tag_ids;
}

/******************************************************************************************************************/
/******************************************************************************************************************/
function get_or_create_tag($name)
{
	global $db;
	$sql=("SELECT tagID,name FROM tags WHERE name= " .$db->sql_string($name) . " " );
	$tag = $db->queryObjectArray($sql);


	 if($tag[0]->tagID && $tag[0]->tagID !=NULL && $tag[0]->name && $tag[0]->name !=NULL ) {

	 $tag1[0]=$tag[0]->tagID;
	 $tag1[1]=$tag[0]->name;

	 return $tag1;
	 }else// need to create tag
     $name=$db->sql_string($name);
     $sql="INSERT INTO tags (name) VALUES ( $name )"  ;
	if($db->execute($sql) )
	return array($db->insertId(), $name);
}

/******************************************************************************************************************/

function get_or_create_usertag($name)
{
	global $db;
	$sql=("SELECT tagID,name FROM user_tags WHERE name= " .$db->sql_string($name) . " " );
	$tag = $db->queryObjectArray($sql);

	 //if($tag[0]->tagID && $tag[0]->tagID !=NULL && $tag[0]->name && $tag[0]->name !=NULL ) {
	 if($tag = $db->queryObjectArray($sql)){
	 $tag1[0]=$tag[0]->tagID;
	 $tag1[1]=$tag[0]->name;

	 return $tag1;
	 }else// need to create tag
     $name=$db->sql_string($name);
     $sql="INSERT INTO user_tags (name) VALUES ( $name )"  ;
	if($db->execute($sql) )
	return array($db->insertId(), $name);
}
/******************************************************************************************************************/
/******************************************************************************************************************/

function get_tag_id($tag)
{
	global $db;
	$tag=$db->sql_string($tag);
	$id = $db->queryObjectArray("SELECT tagID FROM tags WHERE name=$tag");
	return $id ? $id[0]->tagID : 0;
}


/******************************************************************************************************************/

function get_taguser_id($tag)
{
	global $db;
	$tag=$db->sql_string($tag);
	$id = $db->queryObjectArray("SELECT tagID FROM user_tags WHERE name=$tag");
	return $id ? $id[0]->tagID : 0;
}


/******************************************************************************************************************/
/******************************************************************************************************************/
function get_task_tags($id)
{
	global $db;
	$sql=("SELECT tagID FROM tag2task WHERE taskID=$id");

	$q = $db->queryObjectArray($sql);
	if($q && $q!=null){
	$a = array();
	foreach($q as $r) {
		$a[] = $r->tagID;
	}

	return $a;
	}
	return;
}

/******************************************************************************************************************/
function get_user_tags($id,$forum_decID)
{
	global $db;

	$sql=("SELECT tagID FROM rel_user_forum WHERE userID=$id    AND  forum_decID=$forum_decID");

	if($q = $db->queryObjectArray($sql) ){
	$a = array();
	foreach($q as $r) {
		$a[] = $r->tagID;
	}

	return $a;
	}
	return;
}
/******************************************************************************************************************/
function get_user_tagsMgr($id,$forum_decID,$mgr)
{
	global $db;

	$sql=("SELECT tagID FROM forum_dec WHERE  forum_decID=$forum_decID AND managerID=$mgr");

	if($q = $db->queryObjectArray($sql) ){
	$a = array();
	foreach($q as $r) {
		$a[] = $r->tagID;
	}

	return $a;
	}
	return;
}

/******************************************************************************************************************/

function update_task_tags($id, $tag_ids)
{
	global $db;
	foreach($tag_ids as $v) {
         //$id=$db->sql_string($id);
       // if(is_array($v) )
         // $v=$db->sql_string($v->id);
       //else
       //$v=$db->sql_string($v);
		$sql=("INSERT INTO tag2task (taskID,tagID) VALUES ($id,$v)");
		$db->execute ($sql);
	}
//	 $tag_ids=$db->sql_string($tag_ids[0]);
    $tag_ids=$tag_ids[0];
	$sql=("UPDATE tags SET tags_count=tags_count+1 WHERE tagID IN  ($tag_ids) ");
	$db->execute($sql);
}


/******************************************************************************************************************/
function update_user_tags($userID, $tag_ids,$forum_decID,$tags)
{
	global $db;

	if(is_null($tags) || $tags=="" )
	$tags = 'NULL';
	 //else
	// $tags = $db->sql_string($tags);


	foreach($tag_ids as $v) {
        $sql= "UPDATE rel_user_forum SET " .
        "tagID="  . $db->is_num($v) . ", " .
      " tags="     .  stripslashes($db->sql_string($tags)) . "  " .//  "tags= $tags "      . "  " .// "tags="     .  stripslashes($tags) . "  " .
         "WHERE userID=$userID " . " ".
        "AND forum_decID=$forum_decID " ;

		$db->execute ($sql);
	}


    $tag_ids=$tag_ids[0];
	$sql=("UPDATE user_tags SET tags_count=tags_count+1 WHERE tagID IN  ($tag_ids) ");
	$db->execute($sql);
}



/******************************************************************************************************************/
function update_user_tagsMgr($userID, $tag_ids,$forum_decID,$tags,$mgr)
{
	global $db;

	if(is_null($tags) || $tags=="" )
	$tags = 'NULL';


	foreach($tag_ids as $v) {

     $sql = "UPDATE forum_dec SET " .
       "tagID="  . $db->is_num($v) . ", " .
       "tags="     .  stripslashes($db->sql_string($tags)) . "  " .

       " where managerID="    .  $db->sql_string($mgr) . "  " .

       " AND forum_decID="      .  $db->sql_string($forum_decID) . "  " ;

		$db->execute ($sql);
	}


    $tag_ids=$tag_ids[0];
	$sql=("UPDATE user_tags SET tags_count=tags_count+1 WHERE tagID IN  ($tag_ids) ");
	$db->execute($sql);
}

/******************************************************************************************************************/
function parse_smartsyntax($title)
{
	$a = array();
	if(!preg_match("|^(/([+-]{0,1}\d+)?/)?(.*?)(/([^/]*)/$)?$|", $title, $m)) return false;
	$a['prio'] = isset($m[2]) ? (int)$m[2] : 0;
	$a['title'] = isset($m[3]) ? trim($m[3]) : '';
	$a['tags'] = isset($m[5]) ? trim($m[5]) : '';
	if($a['prio'] < -1) $a['prio'] = -1;
	elseif($a['prio'] > 2) $a['prio'] = 2;
	return $a;
}

/******************************************************************************************************************/

function tag_size($qmin, $q, $step)
{
	if($step == 0) return 1;
	$v = ceil(($q - $qmin)/$step);
	if($v == 0) return 0;
	else return $v-1;

}

/******************************************************************************************************************/

function parse_duedate($s)
{
	$y = $m = $d = 0;
	if(preg_match("|^(\d+)-(\d+)-(\d+)\b|", $s, $ma)) {
		$y = (int)$ma[1]; $m = (int)$ma[2]; $d = (int)$ma[3];
	}
	elseif(preg_match("|^(\d+)\/(\d+)\/(\d+)\b|", $s, $ma)) {
		$m = (int)$ma[1]; $d = (int)$ma[2]; $y = (int)$ma[3];
	}
	elseif(preg_match("|^(\d+)\.(\d+)\.(\d+)\b|", $s, $ma)) {
		$d = (int)$ma[1]; $m = (int)$ma[2]; $y = (int)$ma[3];
	}
	elseif(preg_match("|^(\d+)\.(\d+)\b|", $s, $ma)) {
		$d = (int)$ma[1]; $m = (int)$ma[2];
		$a = explode(',', date('Y,m,d'));
		if( $m<(int)$a[1] || ($m==(int)$a[1] && $d<(int)$a[2]) ) $y = (int)$a[0]+1;
		else $y = (int)$a[0];
	}
	elseif(preg_match("|^(\d+)\/(\d+)\b|", $s, $ma)) {
		$m = (int)$ma[1]; $d = (int)$ma[2];
		$a = explode(',', date('Y,m,d'));
		if( $m<(int)$a[1] || ($m==(int)$a[1] && $d<(int)$a[2]) ) $y = (int)$a[0]+1;
		else $y = (int)$a[0];
	}
	else return null;
	if($y < 100) $y = 2000 + $y;
	elseif($y < 1000 || $y > 2099) $y = 2000 + (int)substr((string)$y, -2);
	if($m > 12) $m = 12;
	$maxdays = daysInMonth($m,$y);
	if($m < 10) $m = '0'.$m;
	if($d > $maxdays) $d = $maxdays;
	elseif($d < 10) $d = '0'.$d;
	return "$y-$m-$d";
}

/******************************************************************************************************************/

function prepare_duedate($duedate, $tz=null)
{
	global $lang, $config;

	$a = array( 'class'=>'', 'str'=>'', 'formatted'=>'' );
	if($duedate == '') {
		return $a;
	}
	if(is_null($tz)) {
		$ad = explode('-', $duedate);
		$at = explode('-', date('Y-m-d'));
	}
	else {
		$ad = explode('-', $duedate);
		$at = explode('-', gmdate('Y-m-d',time() + $tz*60));
	}
	$diff = mktime(0,0,0,$ad[1],$ad[2],$ad[0]) - mktime(0,0,0,$at[1],$at[2],$at[0]);

	if($diff < -604800 && $ad[0] == $at[0])	{ $a['class'] = 'past'; $a['str'] = $lang->formatMD((int)$ad[1], (int)$ad[2]); }
	elseif($diff < -604800)	{ $a['class'] = 'past'; $a['str'] = $lang->formatYMD((int)$ad[0], (int)$ad[1], (int)$ad[2]); }
	elseif($diff < -86400)		{ $a['class'] = 'past'; $a['str'] = sprintf($lang->get('daysago'),ceil(abs($diff)/86400)); }
	elseif($diff < 0)			{ $a['class'] = 'past'; $a['str'] = $lang->get('yesterday'); }
	elseif($diff < 86400)		{ $a['class'] = 'today'; $a['str'] = $lang->get('today'); }
	elseif($diff < 172800)		{ $a['class'] = 'today'; $a['str'] = $lang->get('tomorrow'); }
	elseif($diff < 691200)		{ $a['class'] = 'soon'; $a['str'] = sprintf($lang->get('indays'),ceil($diff/86400)); }
	elseif($ad[0] == $at[0])	{ $a['class'] = 'future'; $a['str'] = $lang->formatMD((int)$ad[1], (int)$ad[2]); }
	else						{ $a['class'] = 'future'; $a['str'] = $lang->formatYMD((int)$ad[0], (int)$ad[1], (int)$ad[2]); }

	if($config['duedateformat'] == 2) $a['formatted'] = (int)$ad[1].'/'.(int)$ad[2].'/'.$ad[0];
	elseif($config['duedateformat'] == 3) $a['formatted'] = $ad[2].'.'.$ad[1].'.'.$ad[0];
	else $a['formatted'] = $duedate;

	return $a;
}

/******************************************************************************************************************/

function date2int($d)
{
	if(!$d) return 33330000;
	$ad = explode('-', $d);
	$s = $ad[0];
	if(strlen($ad[1]) < 2) $s .= "0$ad[1]"; else $s .= $ad[1];
	if(strlen($ad[2]) < 2) $s .= "0$ad[2]"; else $s .= $ad[2];
	return (int)$s;
}

/******************************************************************************************************************/

function daysInMonth($m, $y=0)
{
	if($y == 0) $y = (int)date('Y');
	$a = array(1=>31,(($y-2000)%4?28:29),31,30,31,30,31,31,30,31,30,31);
	if(isset($a[$m])) return $a[$m]; else return 0;
}

/******************************************************************************************************************/

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
	if($errno==E_ERROR || $errno==E_CORE_ERROR || $errno==E_COMPILE_ERROR || $errno==E_USER_ERROR || $errno==E_PARSE) $error = 'Error';
	elseif($errno==E_WARNING || $errno==E_CORE_WARNING || $errno==E_COMPILE_WARNING || $errno==E_USER_WARNING || $errno==E_STRICT) {
		if(error_reporting() & $errno) $error = 'Warning'; else return;
	}
	elseif($errno==E_NOTICE || $errno==E_USER_NOTICE) {
		if(error_reporting() & $errno) $error = 'Notice'; else return;
	}
	elseif(defined('E_DEPRECATED') && ($errno==E_DEPRECATED || $errno==E_USER_DEPRECATED)) { # since 5.3.0
		if(error_reporting() & $errno) $error = 'Notice'; else return;
	}
	else $error = "Error ($errno)";	# here may be E_RECOVERABLE_ERROR
	throw new Exception("$error: '$errstr' in $errfile:$errline", -1);
}

/******************************************************************************************************************/

function myExceptionHandler($e)
{
	if(-1 == $e->getCode()) {
		echo $e->getMessage(); exit;
	}


echo '<p class="error">';
	echo 'Exception: \''. $e->getMessage() .'\' in '. $e->getFile() .':'. $e->getLine();
echo '</p>';
	exit;
}
/***************************************************************************************************************/
function loadTask ($taskID){
//stop_gpc($_GET);
global $db;
	if(_get('compl')) $sqlWhere = '';
	else $sqlWhere = ' AND compl=0';
	$inner = '';
	$tag = trim(_get('t'));
	if($tag != '') {
		$tag_id = get_tag_id($tag);
		$inner = "INNER JOIN tag2task ON todolist.taskID=tag2task.taskID";
		$sqlWhere .= " AND tag2task.tagID=$tag_id ";
	}
	$s = trim(_get('s'));


	if($s != '') $sqlWhere .= " AND (title LIKE ". $db->quoteForLike("%%%s%%",$s). " OR note LIKE ". $db->quoteForLike("%%%s%%",$s). ")";
	$sort = (int)_get('sort');
	if($sort == 1) $sqlSort = "ORDER BY prio DESC, ddn ASC, duedate ASC, ow ASC";
	elseif($sort == 2) $sqlSort = "ORDER BY ddn ASC, duedate ASC, prio DESC, ow ASC";
	else $sqlSort = "ORDER BY ow ASC";
	$tz = (int)_get('tz');
	if((isset($config['autotz']) && $config['autotz']==0) || $tz<-720 || $tz>720 || $tz%30!=0) $tz = null;
	$t = array();
	$t['total'] = 0;
	$t['list'] = array();
	$sql=("SELECT * , duedate IS NULL  AS ddn  FROM todolist $inner WHERE 1=1  and  taskID=$taskID $sqlWhere $sqlSort ");
	$q = $db->queryObjectArray($sql);

	if($q && $q!=0)
	foreach($q as $r)
	{
		$t['total']++;
		$t['list'][] = prepareuserTaskRow($r, $tz);
	}
	echo json_encode($t);


}











?>