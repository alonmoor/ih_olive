<?php

function build_form(&$formdata)
{
    global $db;
       if (array_item($formdata, 'brandID')) {
            $brandID = array_item($formdata, 'brandID');
            ?>
            <input type="hidden" id="brandID" name="brandID" value="<?php echo $brandID; ?>"/>
            <?php
        }
    if (array_item($_SESSION, 'level') == 'user') {
        $flag_level = 0;
        $level = false;
        ?>
        <input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level; ?>"/>
        <?php
    } else {
        $level = true;
        $flag_level = 1;
        ?>
        <input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level; ?>"/>
        <?php
    }
    if (array_item($_SESSION, 'userID') && !(array_item($_SESSION, 'userID') == '') && !(array_item($_SESSION, 'userID') == 'none')) {
        $flag_userID = array_item($_SESSION, 'userID');
        ?>
        <input type="hidden" id="flag_userID" name="flag_userID" value="<?php echo $flag_userID; ?>"/>
        <div id="brand_error" name="brand_error"></div>
        <?php
    }
    ?>
<!--    <script language="javascript" src="--><?php //print JS_ADMIN_WWW ?><!--/treeview_forum.js" type="text/javascript"></script>-->
    <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_brand.js" type="text/javascript"></script>


    <div id="main">

        <?php
//-----------------------UPDATE---------------------------------------
          if (array_item($formdata, 'brandID')) {
        ?>

        <form style="width:95%;" name="brand_org" id="brand_org" method="post" action="../admin/dynamic_10_test.php"
              onsubmit="prepSelObject(document.getElementById('dest_pdfs'));
                        prepSelObject(document.getElementById('dest_publishers'));
                        prepSelObject(document.getElementById('dest_brandsType'));
                        prepSelObject(document.getElementById('dest_managersType'));" >
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_brand.js"  type="text/javascript"></script>
          <?php

           }
//-----------------------SAVE---------------------------------------
           else{
          ?>
        <form style="width:95%;" name="brand_org" id="brand_org" method="post" action="../admin/dynamic_10_test.php"
                      onsubmit="prepSelObject(document.getElementById('dest_pdfs'));
                                prepSelObject(document.getElementById('dest_publishers'));
                                prepSelObject(document.getElementById('dest_brandsType'));
                                prepSelObject(document.getElementById('dest_managersType'));" >
          <?php
          }
          ?>
                <fieldset style="margin-right:4%;width:90%;color:#000000; background: #94C5EB url(../../images/background-grad.png) repeat-x;"  >
                    <legend> מלא את הטופס להוספת  BRAND :</legend>
                    <div class="wrapper_brand" style="width:100%">
                    <?PHP
                    $page_input = isset($formdata['pages']) ? $formdata['pages'] : '';
                    ?>
                    <input type="hidden" name="pdf_page_num"  id="pdf_page_num" value="<?PHP echo $page_input; ?>">
                    <?php
                    if (array_item($formdata, 'brandID')) {
                        $brand = new brand();
                        $brand->print_forum_entry_form_c($formdata['brandID']);
                    }
                    $dates = getdate();
//-----------------------------------------------------------
   $sql = "SELECT brandName, brandID, parentBrandID FROM brands ORDER BY brandName";
    $rows = $db->queryObjectArray($sql);

    foreach ($rows as $row) {
    $subcatsftype[$row->parentBrandID][] = $row->brandID;
    $catNamesftype[$row->brandID] = $row->brandName;
    }
    $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
//--------------------------------------------------------
                    $arr_show = array();
                    $arr_show[0][0] = "ציבורי";
                    $arr_show[0][1] = "1";
                    $arr_show[1][0] = "פרטי";
                    $arr_show[1][1] = "2";
                    $arr_show[2][0] = "סודי";
                    $arr_show[2][1] = "3";

                    $selected_show = array_item($formdata, 'brand_Allowed') ? array_item($formdata, 'brand_Allowed') : $arr_show[0][1];

                    $arr = array();
                    $arr[0][0] = "לא פעיל";
                    $arr[0][1] = "1";
                    $arr[1][0] = "פעיל";
                    $arr[1][1] = "2";

                    for ($i = 1; $i <= 150; $i++) {
                            $pages[] = $i;
                        }

                    $selected = array_item($formdata, 'brand_status') ? array_item($formdata, 'brand_status') : $arr[1][1];
                    $tmp_insertID = '11';

                    echo '<div class="myformtable1" style="width:60%;height: auto;"  data-module="שם הברנד:">';
//---------------------------------UPDATE------------------------------------------
                    if (array_item($formdata, 'brandID')) {
   if($level) {
                        echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("תאריך הפצה:", true);
                        form_text3("brand_date2", array_item($formdata, "brand_date2"), 15, 15, 1, 'brand_date2');
                        form_empty_cell_no_td(10);
                        echo '</div>';


                        echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("שם הברנד::", true);
                        form_list_b("brand_pdf", $rows, array_item($formdata, "brandID"),"id = brand_pdf");
                       //form_text_a("brand_pdf", array_item($formdata, "brandName"), 15, 15, 1);
                        form_empty_cell_no_td(10);
                        echo '</div>';

                         echo '<div class="myformtd 1" style="width:60%;margin-top: 15px;">';
                                 $connect = array_item($formdata, "insertID") ? array_item($formdata, "insertID") : '11';
                                 form_label1("קשר לברנד:", TRUE);
                                 form_list_find_notd("insert_forum", "insert_forum", $rows, $connect);
                                 form_empty_cell_no_td(5);
                         echo '</div>';

                        echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("סטטוס ברנד:", TRUE);
                        form_list_find_notd_no_choose2('brand_status', $arr, $selected, $str = "");
                        form_empty_cell_no_td(5);
                        echo '</div>';



                          echo '<div class="myformtd 1" style="width:60%;">';
                          form_label_red1("קידומת:", TRUE);
                          form_text_a("brandPrefix", array_item($formdata, "brandPrefix"), 45, 45, 1, "brandPrefix");
                          form_empty_cell_no_td(5);
                          echo '</div>';


                          echo '<div class="myformtd 1"   id="num_page">';
                            form_label_red1("מספר עמודים:", TRUE);
                            form_list_demo("pages", $pages, array_item($formdata, "pages"),"id=pdf_page_num");
                            echo  '</div>';




                        echo '<div class="myformtd 1" style="width:60%;">';
                            form_url2("forum_demo_last8.php", "ערוך ברנדים", 2);
                        echo '</div>';
                      }

                      else{
                             echo '<div class="myformtd 1" style="width:60%;">';
                                    form_label_red1("שם הברנד::", true);
                                    form_list_b("brand_pdf", $rows, array_item($formdata, "brandID"),"id = brand_pdf");
                                   //form_text_a("brand_pdf", array_item($formdata, "brandName"), 15, 15, 1);
                                    form_empty_cell_no_td(10);
                             echo '</div>';


                             $date_val = array_item($formdata, "brand_date2");
                              echo '<input type="hidden" id="brand_date3" value='.$date_val.'" >';


                              $prefix_val = array_item($formdata, "brandPrefix");
                              echo '<input type="hidden" id="brandPrefix" value='.$prefix_val.'" >';
                      }
                    }
//-----------------------SAVE--------------------------------------------
                    else{
                     if($level) {


                     echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("תאריך הפצה:", true);
                        form_text3("brand_date2", array_item($formdata, "brand_date2"), 15, 15, 1, 'brand_date2');
                        form_empty_cell_no_td(10);
                    echo '</div>';



                     echo '<div class="myformtd 1" style="width:60%;margin-top: 15px;">';
                        form_label1("שם ברנד:", TRUE);
                        form_text_a("newbrandName", array_item($formdata, "tmpName"), 20, 50, 1);
                        form_empty_cell_no_td(5);
                     echo '</div>';





                    echo '<div class="myformtd 1" style="width:60%;margin-top: 15px;">';
                     $connect = array_item($formdata, "insertID") ? array_item($formdata, "insertID") : '11';
                     form_label1("קשר לברנד:", TRUE);
                     form_list_find_notd("insert_forum", "insert_forum", $rows, $connect);
                     form_empty_cell_no_td(5);
                      echo '</div>';
                     echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("סטטוס ברנד:", TRUE);
                        form_list_find_notd_no_choose2('brand_status', $arr, $selected, $str = "");
                        form_empty_cell_no_td(5);
                      echo '</div>';

                        echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("קידומת:", TRUE);
                        //form_list_find_notd_no_choose2('brand_prefix', $arr_show, $selected_show, "id=brand_prefix");
                        form_text_a("brandPrefix", array_item($formdata, "brandPrefix"), 20, 50, 1);
                        form_empty_cell_no_td(5);
                        echo '</div>';


                         echo '<div class="myformtd 1"   id="num_page">';
                        form_label_red1("מספר עמודים:", TRUE);
                        form_list_demo("pages", $pages, array_item($formdata, "pages"),"id=pdf_page_num");
                        echo  '</div>';

                     }

else{
                             echo '<div class="myformtd 1" style="width:60%;">';
                                    form_label_red1("שם הברנד::", true);
                                    form_list_b("brand_pdf", $rows, array_item($formdata, "brandID"),"id = brand_pdf");
                                   //form_text_a("brand_pdf", array_item($formdata, "brandName"), 15, 15, 1);
                                    form_empty_cell_no_td(10);
                             echo '</div>';

                             $date_val = array_item($formdata, "brand_date2");
                              echo '<input type="hidden" id="brand_date3" value='.$date_val.'" >';


                              $prefix_val = array_item($formdata, "brandPrefix");
                              echo '<input type="hidden" id="brandPrefix" value='.$prefix_val.'" >';
                      }
 }
                    echo '</div>';

//---------------------------BUTTON-------------------------------------------
           // if ($level) {
                echo '<div class="myformtd">';
                form_button_no_td2("submitbutton", "שמור", "Submit", "OnClick=\"
                                            prepSelObject(document.getElementById('dest_brandsType'));
                                            prepSelObject(document.getElementById('dest_managersType'));
                                            prepSelObject(document.getElementById('dest_pdfs'));
                                            \";");
                echo '</div>';
                if (array_item($formdata, 'dynamic_6')) {
                    $x = $formdata['index'];
                    $formdata["brandID"] = $formdata["brandID"][$x];
                    $tmp = (array_item($formdata, "brandID")) ? "update" : "save";
                    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["brandID"]);
                    echo '<div class="myformtd" style="width:60%;">';
                    form_hidden("brandID", $formdata["brandID"]);
                    form_hidden("insertID", $formdata["insertID"]);
                    echo '</div>';
                } else
                    $tmp = (array_item($formdata, "brandID")) ? "update" : "save";
                $formdata["brandID"] = isset($formdata["brandID"]) ? $formdata["brandID"] : '';
                $formdata["insertID"] = isset($formdata["insertID"]) ? $formdata["insertID"] : '';
                echo '<div class="myformtd" style="width:60%;">';
                form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["brandID"]);
                form_hidden("brandID", $formdata["brandID"]);
                form_hidden("insertID", $formdata["insertID"]);
                echo '</div>';
                if (!empty($formdata['fail']) && array_item($formdata, "brandID") && !$formdata['fail']) {
                    echo '<div class="myformtd" style="width:60%;">';
                    form_button_no_td2("btnLink1", "קשר לברנד");
                    form_hidden("brandID", $formdata["brandID"]);
                    form_button1("btnDelete", "מחק ברנד", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["brandID"]."').value='delete'\";");
                    form_empty_cell_no_td(20);
                    form_button_no_td2("btnDelete", "מחק ברנד", "Submit", "OnClick='return shalom(\"" . $formdata[brandID] . "\")'");
                    echo '</div>';
                }
                $formdata["fail"] = isset($formdata["fail"]) ? $formdata["fail"] : '';
                if ($formdata['fail'])
                    unset($formdata['fail']);

                ?>
                     <div id="loading">
                        <img src="loading4.gif" border="0" />
                    </div>
                    <div id="display_div" class="image_block"> </div>
                <?php
 if (array_item($formdata, 'brandID')) {
global $dbc,$db;
//------------------------------------------------------------------------------
$sql = "SELECT * FROM pdfs ORDER BY date_created DESC";
    if( $rows = $db->queryObjectArray($sql)) {
        $pdf_names = array();
        foreach($rows as $row){
             $pdf_names[] = $row-> pdfName;;
        }
     }
//---------------------------------------------------------------------------------
if( isset($formdata['brand_date2']) ){
    $dayOfWeek = date("l", strtotime($formdata['brand_date2']));
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
        if($dayOfWeek == "7" || $dayOfWeek == "1" || $dayOfWeek == "2" || $dayOfWeek == "3" || $dayOfWeek == "4"  ) {
           $page_num =      isset($formdata['pages']) ? $formdata['pages'] : '';
           $brandPrefix =   $formdata['brandPrefix'];
           $brandPrefix =   str_replace("{{date}}", $dayOfWeek , $brandPrefix);
           $brandPrefixArr = array();
            $html = '';
           $html .= '<div class="" id="display_div" >';

        for($i = 0; $i<$page_num ; $i++){
            $m = $i +1;
               if($i<10){
               $brandPrefixArr[$i] = $brandPrefix."p00".$m.".pdf";
               }elseif ($i<100 && $i>=10 ){
                $brandPrefixArr[$i] = $brandPrefix."p0".$m.".pdf";
               }elseif ($i>=100){
                $brandPrefixArr[$i] = $brandPrefix."p".$m.".pdf";
               }
//------------------------------------------------------------------------------
               if( empty($pdf_names) ||  !(in_array($brandPrefixArr[$i],$pdf_names))  ){
                            $html .= '<div class="col-xs-3" id=""  style="margin-top: 50px;" >';
                                    $html .=  "<div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;background: grey;\">
                                                    <div id='my_pdfs_$i'>
                                                        <h4>
                                                             <a class='my_href_li' href=\"#\">
                                                             </a>
                                                         </h4>
                                                      </div>
                                                      
                                                      </div>\n";
                                    $html .=  '<br/></div>';
               }
//------------------------------------------------------------------------------
               else{
                foreach($rows as $row){
                    if($brandPrefixArr[$i] == $row->pdfName){
                     $pdf_names[] = $row-> pdfName;
                    $file_name = explode('.',$row->pdfName);
                        $file_name =  $file_name[0];
                        $tmp_name  =  $file_name;
                        $file_name = $file_name.'.jpg';
                         $html .=   '<div class="col-xs-3">';
                         $html .=   "({$row->size}kb) <p  style='font-weight:bold;color:brown;'>{$row->pdfName}</p><div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;\">
                                        
                                           <div  style='margin-right: 224px;'>
                                                <input type='checkbox' id=$tmp_name>
                                            </div>
                                      <div >    
                                           <div id='my_pdfs{$row->pdfName}'>
                                            <a class='my_href_li' href= '".PDF_WWW_DIR."{$row->pdfName}' >
                                           <!--  <a class='my_href_li' href=\"dynamic_5_demo.php?mode=view_pdfs&id={$row->pdfName}\" style=''>  -->
                                                    <img src ='".CONVERT_PDF_TO_IMG_WWW_DIR."/{$file_name}' style='box-sizing: border-box;widht:100%; height: 300px;margin-top:-16px;' >
                                                </a> 
                                           </div>
                                      </div>  
                                    </div>\n";
                         $html .=   '<br/>
                                   </div>';
                  }
                }
             }
//------------------------------------------------------------------------------
       }//end for
     echo $html;
    }
  }
}
//---------------------------------------------------------------------------------
             echo '</div></fielset></form></div>';
}//end build_form

function build_form_ajx7(&$formdata)
{
    $level = '';
    if (array_item($_SESSION, 'level') == 'user') {
        $flag_level = 0;
        $level = false;
        ?>
        <input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level; ?>"/>
        <?php
    } else {
        $level = true;
        $flag_level = 1;

        ?>
        <input type="hidden" id="flag_level" name="flag_level" value="<?php echo $flag_level; ?>"/>
        <?php

    }
    /*********************************************/


    if (!(ae_detect_ie())) {
        ?>
        <style>
            input {
                width: 120px;
                border: 2px solid;
                overflow: hidden;
                padding-left: 5px;

            }
        </style>
    <?php } ?>


    <div id="main">
        <?php
//------------------------------------------------------------------------------
//        $formdata['manager_brand'] = isset ($formdata['manager_brand']) ? $formdata['manager_brand'] : '';
//        $formdata['managerName'] = isset ($formdata['managerName']) ? $formdata['managerName'] : '';
//        $url_mgr = "../admin/find3.php?managerID=" . $formdata['manager_brand'];
//        $link_frm_mgr = "<span><a onClick=openmypage3('" . $url_mgr . "');   class=href_modal1  href='javascript:void(0)' ><b style='color:brown;font-size:1.4em;'>'" . $formdata['managerName'] . "'<b></a></span>";
//        echo '<table style="width:300px;height:25px;"><tr><td><p  data-module="מנהל ברנד:' . $link_frm_mgr . '"  id="my_manager_td"></p></td></tr></table>';
//---------------------------------------------------------------------------------

        ?>


        <div id="loading">
            <img src="../images/loading4.gif" border="0"/>
        </div>


        <?php
        if (isset($formdata['save_new']) && !($formdata['save_new'] == 1)){
        ?>

        <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/edit_furomdec.js" charset="utf-8"
                type="text/javascript"></script>
        ‬
        <script language="javascript" src="<?php print JS_ADMIN_WWW ?>/treeview_forum.js" charset="utf-8"
                type="text/javascript"></script>


        <h4 class="my_main_fieldset<?php echo $formdata['brandID'] ?>" style="height:15px;cursor:pointer;"></h4>
        <form name="brand" id="brand" method="post" action="../admin/dynamic_10_test.php">

            <?php
            }else{
            ?>
            <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/edit_branddec.js"
                    type="text/javascript"></script>
        ‬
            <script language="javascript" src="<?php print JS_ADMIN_WWW ?>/treeview_brand_dem_9.js"
                    type="text/javascript"></script>
            <form style="width:95%;" name="brand" id="brand" method="post" action="../admin/dynamic_12.php">
                <?php
                }
                ?>
                <fieldset id="main_fieldset<?php echo $formdata['brandID'] ?>"
                          style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden"
                          ;>
                    <legend style="color:brown;">ברנד - ישראל היום</legend>
                    <input type=hidden name="brandID" id="brandID"
                           value="<?php echo $formdata['brandID'] ?>"/>

                    <div id="my_error_message" name="my_error_message"></div>


                    <div id="brandID_tree" name="brandID_tree"></div>

                    <?php if (ae_detect_ie()){ ?>
                    <table style="margin-right:25px;width:95%;">
                        <?php }else{ ?>
                        <table style="margin-right:25px; width:95%;">
                            <?php
                            }


                            if (array_item($formdata, 'brandID')) {
                                $brand = new brand();
                                $brand->print_brand_entry_form_b($formdata['brandID']);
                            }
                            global $db;


                            $dates = getdate();


                            $sql = "SELECT brandName,brandID,parentBrandID FROM brands ORDER BY brandName";
                           if( $rows = $db->queryObjectArray($sql)){

                            foreach ($rows as $row) {
                                $subcats_a[$row->parentbrandID][] = $row->brandID;
                                $catNames_a[$row->brandID] = $row->brandName;
                            }
                            $rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
                            $arr = array();
                            $arr[0][0] = "לא פעיל";
                            $arr[0][1] = "1";
                            $arr[1][0] = "פעיל";
                            $arr[1][1] = "2";
                            $selected = array_item($formdata, 'brand_status') ? array_item($formdata, 'brand_status') : $arr[1][1];


                            $arr_show = array();
                            $arr_show[0][0] = "ציבורי";
                            $arr_show[0][1] = "1";
                            $arr_show[1][0] = "פרטי";
                            $arr_show[1][1] = "2";
                            $arr_show[2][0] = "סודי";
                            $arr_show[2][1] = "3";


                            $selected_show = array_item($formdata, 'brand_allowed') ? array_item($formdata, 'brand_allowed') : $arr_show[0][1];

                            if ($selected_show == 'public') $selected_show = 1;
                            elseif ($selected_show == 'private') $selected_show = 2;
                            elseif ($selected_show == 'top_secret') $selected_show = 3;
                            echo '<tr>
                                    <td> 
                                    <div style="" data-module="שם הברנד:">
                                    <table class="myformtable1" style="height:100px;width:98%;">';

                            echo '<tr><td colspan="4" style="">';

                            form_label_red1("שם הברנד:", TRUE);
                            form_list_find_notd("brandID", "brandID_link", $rows, array_item($formdata, "brandID"));
                            form_empty_cell_no_td(5);


                            form_label_red1("שם ברנד חדש:", TRUE);
                            form_text_a("newbrand:", array_item($formdata, "newbrand"), 20, 50, 1, "newbrand");
                            form_empty_cell_no_td(5);


                            form_label_red1("קשר לברנד:", TRUE);
                            form_list_find_notd("insert_brand", "insert_brand", $rows, array_item($formdata, "insert_brand"));
                            //form_empty_cell_no_td(10);

                            echo '</td>';

                            if ($level) {
                                form_url_noformtd("categories.php", "ערוך פורומים", 1);
                            }
                            ECHO '</tr>';


                            echo '<tr><td>';

                            form_label_red1("תאריך הקמה:", true);
                            form_text_a("brand_date", array_item($formdata, "brand_date"), 10, 10, 1, 'brand_date');
                            form_empty_cell_no_td(10);
                            form_label_red1("סטטוס ברנד:", TRUE);
                            form_list_find_notd_no_choose2('brand_status', $arr, $selected, $str = "");

                            form_empty_cell_no_td(10);
                            form_label_red1("סיווג ברנד:", TRUE);

                            form_list_find_notd_no_choose2('brand_allowed', $arr_show, $selected_show, "id=brand_allowed");
                            echo '</td></tr>';


                            echo '</table></div></td></tr>';
                            }
//---------------------------------------------------------------------------------------------------------------------------
                            $sql = "SELECT managerName,managerID,parentManagerID FROM managers ORDER BY managerName";
                           if($rows = $db->queryObjectArray($sql)) {

                            foreach ($rows as $row) {
                                $subcats6[$row->parentManagerID][] = $row->managerID;
                                $catNames6[$row->managerID] = $row->managerName;
                            }

                            $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
                            $rows1 = build_category_array($subcats6[NULL], $subcats6, $catNames6);
                            }

                            $sql = "SELECT u.* FROM brands u
                                        LEFT JOIN managers m ON u.userID=m.userID
                                        WHERE u.userID NOT IN(SELECT userID FROM managers)
                                        ORDER BY u.full_name ";
                            if ($rows2 = $db->queryObjectArray($sql)) {

                                foreach ($rows2 as $row) {
                                    $array[$row->userID] = $row->full_name;
                                }
                            }
//---------------------------------------------------------------------------------------------------------------------------
                            $managerName = $formdata['managerName'] ? $formdata['managerName'] : '';
                            $manager_brand = $formdata['manager_brand'] ? $formdata['manager_brand'] : '';
                            $url = "../admin/find3.php?managerID=$manager_brand";
                            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                            $link_frm = "<a onClick=openmypage3('" . $url . "');   class=href_modal1  href='javascript:void(0)' >
                            <b style='color:brown;font-size:1.4em;'>$managerName<b></a>";
//---------------------------------------------------------------------------------------------------------------------------


                            echo '<tr><td id="my_manager_td">
<div style=""  data-module="מנהל ברנד:' . $link_frm . '">
<table class="myformtable1" style="height:100px;width:98%;"><tr><td>';


                            form_label_red1("מנהל ברנד:", TRUE);
                            form_list_b("manager_brand", $rows, array_item($formdata, "manager_brand"), "id=my_manager");
                            form_empty_cell_no_td(5);

                            form_label1("שם מנהל חדש:", TRUE);
                            form_list_idx_one("new_manager", $array, array_item($formdata, "new_manager"), "id=my_newManager");
                            form_empty_cell_no_td(5);

                            form_label1("קשר למנהל:", TRUE);
                            form_list_b("insert_manager", $rows1, array_item($formdata, "insert_manager"), "id=insert_manager");
                            form_empty_cell_no_td(4);

                            echo '</td>';
                            if ($level) {
                                form_url_noformtd("manager.php", "ערוך מנהלים", 1);
                            }
                            echo '</tr>';

                            echo '<tr><td>';
                            form_label_red1("תאריך מינוי מנהל:", TRUE);
                            form_text3("manager_date", array_item($formdata, "manager_date"), 20, 50, 1, 'manager_date');
                            form_empty_cell_no_td(10);


                            echo '</td></tr>';


                            echo '</table></div></td></tr>';


                            /*************************************brandF_TYPE*****************************************************************/


                            $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
                            $rows = $db->queryObjectArray($sql);

                            foreach ($rows as $row) {
                                $subcatsftype[$row->parentCatID][] = $row->catID;
                                $catNamesftype[$row->catID] = $row->catName;
                            }

                            $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
                            $rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);


                            echo '<tr>
<td>
<div  style=""  data-module="הזנת  סוגי הברנד:">
<table class="myformtable1" style="width:98%;"><tr>';


                            echo '<td style="width:40px;">';
                            form_list111("src_brandsType", $rows, array_item($formdata, "src_brandsType"), "multiple size=6 id='src_brandsType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_brandsType'), document.getElementById('dest_brandsType'));\"");
                            echo '</td>';


                            if (isset($formdata['dest_brandsType']) && $formdata['dest_brandsType'] && $formdata['dest_brandsType'] != 'none') {


                                $dest_brandsType = $formdata['dest_brandsType'];

                                foreach ($dest_brandsType as $key => $val) {
                                    if (!is_numeric($val)) {
                                        $val = $db->sql_string($val);
                                        $staff_test[] = $val;
                                    } elseif (is_numeric($val)) {
                                        $staff_testb[] = $val;
                                    }
                                }
                                if (is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                                    $staff = implode(',', $staff_test);

                                    $sql2 = "select catID, catName from categories where catName in ($staff)";
                                    if ($rows = $db->queryObjectArray($sql2))
                                        foreach ($rows as $row) {
                                            $name_frmType[$row->catID] = $row->catName;
                                        }
                                } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                                    $staff = implode(',', $staff_test);

                                    $sql2 = "select catID, catName from categories where catName in ($staff)";
                                    if ($rows = $db->queryObjectArray($sql2))
                                        foreach ($rows as $row) {

                                            $name_frmType[$row->catID] = $row->catName;


                                        }
                                    $staffb = implode(',', $staff_testb);

                                    $sql2 = "select catID, catName from categories where catID in ($staffb)";
                                    if ($rows = $db->queryObjectArray($sql2))
                                        foreach ($rows as $row) {

                                            $name_b[$row->catID] = $row->catName;
                                        }
                                    $name_frmType = array_merge($name, $name_b);
                                    unset($staff_testb);
                                } else {
                                    $staff = implode(',', $formdata['dest_brandsType']);

                                    $sql2 = "select catID, catName from categories where catID in ($staff)";
                                    if ($rows = $db->queryObjectArray($sql2))
                                        foreach ($rows as $row) {

                                            $name_frmType[$row->catID] = $row->catName;
//$name[]=$row->catName;

                                        }
                                }

                                ?>

                                <td style="width:40px;">

                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_brandsType'), document.getElementById('dest_brandsType'));"/>

                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_brandsType'));"/>


                                </td>


                                <?php


                                form_list_no_formtd("dest_brandsType", $name_frmType, array_item($formdata, "dest_brandsType"), "multiple size=6 id='dest_brandsType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_brandsType'));\"");


                            } elseif (isset($formdata['src_brandsType']) && $formdata['src_brandsType'] && $formdata['src_brandsType'][0] != 0 && !$formdata['dest_brandsType']) {

                                $dest_types = $formdata['src_brandsType'];

                                for ($i = 0; $i < count($dest_types); $i++) {
                                    if ($i == 0) {
                                        $userNames = $dest_types[$i];
                                    } else {
                                        $userNames .= "," . $dest_types[$i];

                                    }

                                }


                                $name_frmType = explode(",", $userNames);

                                $sql2 = "select catID,catName from categories where catID in ($userNames)";
                                if ($rows = $db->queryObjectArray($sql2))
                                    foreach ($rows as $row) {

                                        $name_frmType[$row->catID] = $row->catName;

                                    }


                                ?>

                                <td style="width:40px;">
                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_brandsType'), document.getElementById('dest_brandsType'));"/>

                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_brandsType'));"/>
                                </td>


                                <?php
                                form_list_no_formtd("src_brandsType", $name_frmType, array_item($formdata, "src_brandsType"), "multiple size=6 id='src_brandsType' ondblclick=\"add_item_to_select_box(document.getElementById('src_brandsType'), document.getElementById('dest_brandsType'));\"");
                            } else {
                                ?>

                                <td style="width:40px;">
                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_brandsType'), document.getElementById('dest_brandsType'));"/>
                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_brandsType'));"/>
                                </td>


                                <td>
                                    <select class="mycontrol" name='arr_dest_brandsType[]' dir=rtl id='dest_brandsType'
                                            ondblclick="remove_item_from_select_box(document.getElementById('dest_brandsType'));"
                                            MULTIPLE SIZE=6 style='width:180px;'></select>
                                </td>

                                <?php
                            }
                            /*********************************************************************************/

                            //            form_label_short("סוג ברנד חדש",TRUE);
                            //		          form_textarea("new_brandType", array_item($formdata, "new_brandType"),14, 5, 1,"textarea_$formdata[brandID]");
                            //                  form_label_short("קשר לסוג ברנד",TRUE);
                            //              form_list1idx ("insert_brandType" , $rows2, array_item($formdata, "insert_brandType"), 'id=insert_brandType  multiple size=6 ');

                            //  form_empty_cell_noformtd(5);
                            //   form_label_short2("סוג ברנד חדש",TRUE);
                            //   form_textarea_noformtd("new_brandType", array_item($formdata, "new_brandType"),14, 5, 1,"textarea_frmType$formdata[brandID]");
                            //                  form_label_short2("קשר לסוג ברנד",TRUE);
                            //  echo '<td>';
                            //        form_list111 ("insert_brandType" , $rows2, array_item($formdata, "insert_brandType"), 'id=insert_brandType  multiple size=6 ');
                            //
                            //  echo '</td>';
                            //  if($level){
                            //  form_url_noformtd("categories.php","ערוך סוגי פורומים",1 );
                            $formdata["brandID"] = isset($formdata["brandID"]) ? $formdata["brandID"] : '';
                            form_label("סוג ברנד חדש", TRUE);
                            form_textarea("new_brandType", array_item($formdata, "new_brandType"), 14, 5, 1, "textarea_$formdata[brandID]");
                            form_label("קשר לסוג ברנד", TRUE);
                            form_list1idx("insert_brandType", $rows2, array_item($formdata, "insert_brandType"), 'id=insert_brandType  multiple size=6 ');


                            echo '</tr>';

                            if ($level) {
                                echo '<tr><td >';
                                form_url2("categories.php", "ערוך סוגי פורומים", 1);
                                echo "</td></tr>";


                                /***************************************************************************************/
                            }
                            echo ' 
</tr>
</table></div>
</td></tr>';


                            /******************************************************************************************************/

                            /*************************************MANAGER_TYPE*****************************************************************/


                            $sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
                            $rows = $db->queryObjectArray($sql);

                            foreach ($rows as $row) {
                                $subcatsmtype[$row->parentManagerTypeID][] = $row->managerTypeID;
                                $catNamesmtype[$row->managerTypeID] = $row->managerTypeName;
                            }

                            $rows = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);
                            $rows2 = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);

                            echo '<tr><td   align="right"><div style=""  data-module="הזנת  סוגי המנהלים:">
<table class="myformtable1" style="width:98%;" >
<tr>';
                            //  form_label_red("הזנת  סוגי המנהלים:", TRUE);
                            echo '<td style="width:30px;">';


                            form_list111("src_managersType", $rows, array_item($formdata, "src_managersType"), "multiple size=6 id='src_managersType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));\"");

                            echo '</td>';


                            if (isset($formdata['dest_managersType']) && $formdata['dest_managersType'] && $formdata['dest_managersType'] != 'none') {
                                $dest_managersType = $formdata['dest_managersType'];

                                foreach ($dest_managersType as $key => $val) {

                                    if (!is_numeric($val)) {
                                        $val = $db->sql_string($val);
                                        $staff_test[] = $val;

                                    } elseif (is_numeric($val)) {
                                        $staff_testb[] = $val;

                                    }
                                }


                                if (is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                                    $staff = implode(',', $staff_test);
                                    $sql = "select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";

                                    if ($rows = $db->queryObjectArray($sql))
                                        foreach ($rows as $row) {

                                            $name_managerType[$row->managerTypeID] = $row->managerTypeName;


                                        }
                                } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                                    $staff = implode(',', $staff_test);
                                    $sql = "select  managerTypeID, managerTypeName from manager_type where managerTypeName in ($staff)";

                                    if ($rows = $db->queryObjectArray($sql))
                                        foreach ($rows as $row) {

                                            $name_managerType[$row->managerTypeID] = $row->managerTypeName;


                                        }

                                    $staff_b = implode(',', $staff_testb);
                                    $sql = "select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff_b)";

                                    if ($rows = $db->queryObjectArray($sql))
                                        foreach ($rows as $row) {

                                            $name_managerType_b[$row->managerTypeID] = $row->managerTypeName;


                                        }
                                    $name_managerType = array_merge($name_managerType, $name_managerType_b);
                                    unset($staff_testb);

                                } else {
//$staff=$result["dest_managersType"];
                                    $staff = implode(',', $formdata['dest_managersType']);

                                    $sql2 = "select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff)";
                                    if ($rows = $db->queryObjectArray($sql2))
                                        foreach ($rows as $row) {

                                            $name_managerType[$row->managerTypeID] = $row->managerTypeName;


                                        }

                                }
                                ?>

                                <td style="width:40px;">

                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));"/>

                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));"/>


                                </td>


                                <?php


                                form_list_no_formtd("dest_managersType", $name_managerType, array_item($formdata, "dest_managersType"), "multiple size=6 id='dest_managersType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_managersType'));\"");


                            } elseif (isset($formdata['src_managersType']) && isset($formdata['src_managersType'][0]) && $formdata['src_managersType'] && $formdata['src_managersType'][0] != 0 && !$formdata['dest_managersType']) {

                                $dest_managersType = $formdata['src_managersType'];

                                for ($i = 0; $i < count($dest_managersType); $i++) {
                                    if ($i == 0) {
                                        $userNames = $dest_managersType[$i];
                                    } else {
                                        $userNames .= "," . $dest_managersType[$i];

                                    }

                                }


                                $name_managerType = explode(",", $userNames);


                                ?>

                                <td style="width:40px;">
                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));"/>

                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));"/>
                                </td>


                                <?php
                                form_list_no_formtd("src_managersType", $name_managerType, array_item($formdata, "src_managersType"), "multiple size=6 id='src_managersType' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));\"");


                            } else {


                                ?>

                                <td style="width:40px;">
                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));"/>
                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));"/>
                                </td>


                                <td>
                                    <select class="mycontrol" name='arr_dest_managersType[]' dir=rtl
                                            id='dest_managersType' MULTIPLE SIZE=6
                                            ondblclick="remove_item_from_select_box(document.getElementById('dest_managersType'));"
                                            style='width:180px;'></select>
                                </td>

                                <?php


                            }
                            //form_empty_cell_noformtd(5);
                            // form_label_short2("סוג מנהל חדש",TRUE);
                            //echo '<td>';
                            //
                            //		          form_textarea1("new_managerType", array_item($formdata, "new_managerType"),14, 5, 1,"textarea_mgrType_$formdata[brandID]");
                            // echo '</td>';
                            //		          form_label_short2("קשר לסוג מנהל",TRUE);
                            //
                            //echo '<td>';
                            //		          if(array_item($formdata, "insert_managerType") )
                            //                  //form_list1idx ("insert_managerType" , $rows2, array_item($formdata, "insert_managerType"), "id=insert_managerType  multiple size=6");
                            //                  form_list111 ("insert_managerType" , $rows2, array_item($formdata, "insert_managerType"), "id=insert_managerType  multiple size=6");
                            //
                            //                  else
                            //                  form_list111 ("insert_managerType" , $rows2, array_item($formdata, "insert_managerType"),"id=insert_managerType  multiple size=6");
                            //
                            //  echo '</td>';
                            //  if($level){
                            //   form_url_noformtd("manager_category.php","ערוך סוגי מנהלים",1 );

                            form_label("סוג מנהל חדש", TRUE);
                            form_textarea("new_managerType", array_item($formdata, "new_managerType"), 14, 5, 1, "textarea_mgrType_$formdata[brandID]");
                            form_label("קשר לסוג למנהל", TRUE);
                            if (array_item($formdata, "insert_managerType"))
                                form_list1idx("insert_managerType", $rows2, array_item($formdata, "insert_managerType"), "id=insert_managerType  multiple size=6");
                            else
                                form_list1("insert_managerType", $rows2, array_item($formdata, "insert_managerType"), "id=insert_managerType multiple size=6");


                            echo '</tr>';

                            if ($level) {
                                echo '<tr><td >';
                                form_url2("manager_category.php", "ערוך סוגי מנהלים", 1);
                                echo "</td></tr>";


                            }
                            echo ' 
</tr>
</table></div>
</td></tr>';


                            /**********************************************brands********************************************************************************/


                            $sql = "SELECT full_name,userID FROM brands ORDER BY full_name";
                            $rows = $db->queryArray($sql);


                            echo '<tr>
<td   class="myformtd">
<div style="" data-module="הזנת  חברי ברנד:">
<table class="myformtable1" style="width:60%;">
<tr>';


                            //   form_label("הזנת  חברי ברנד:", TRUE);
                            echo '<td style="width:20px;">';
                            form_list111("src_pdfs", $rows, array_item($formdata, "src_pdfs"), "multiple size=6 id='src_pdfs' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_pdfs'), document.getElementById('dest_pdfs'));\"");
                            echo '</td>';


                            /****************************************************************************************************/
                            if (isset($formdata['dest_pdfs']) && $formdata['dest_pdfs'] && $formdata['dest_pdfs'] != 'none' && count($formdata['dest_pdfs']) > 0) {
                                $dest_pdfs = $formdata['dest_pdfs'];


                                foreach ($dest_pdfs as $key => $val) {

                                    if (!$result["dest_pdfs"])
                                        $result["dest_pdfs"] = $key;
                                    else
                                        $result["dest_pdfs"] .= "," . $key;

                                }


                                $staff = $result["dest_pdfs"];
                                $formdata['dest_pdfs1'] = explode(',', $staff);
                                $sql2 = "select userID, full_name from brands where userID in ($staff)";
                                if ($rows = $db->queryObjectArray($sql2))
                                    foreach ($rows as $row) {

                                        $name[$row->userID] = $row->full_name;

                                    }

                                $i = 0;
                                ?>

                                <td style="width:40px;">

                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_pdfs'), document.getElementById('dest_pdfs'));"/>

                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_pdfs'));"/>


                                </td>


                                <?php
                                form_list_noformtd("dest_pdfs", $name, array_item($formdata, "dest_pdfs1"), "multiple size=6 id='dest_pdfs' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_pdfs'));\"");

                                /**********************************************************************************************/
                            } elseif (isset($formdata['src_pdfs']) && $formdata['src_pdfs'] && $formdata['src_pdfs'][0] != 0 && !$formdata['dest_pdfs']) {

                                $dest_pdfs = $formdata['src_pdfs'];

                                for ($i = 0; $i < count($dest_pdfs); $i++) {
                                    if ($i == 0) {
                                        $userNames = $dest_pdfs[$i];
                                    } else {
                                        $userNames .= "," . $dest_pdfs[$i];

                                    }

                                }


                                $name = explode(",", $userNames);


                                ?>

                                <td style="width:40px;">
                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_pdfs'), document.getElementById('dest_pdfs'));"/>

                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_pdfs'));"/>
                                </td>


                                <?php
                                form_list_noformtd("src_pdfs", $name, array_item($formdata, "src_pdfs"), "multiple size=6 id='src_pdfs' ondblclick=\"add_item_to_select_box(document.getElementById('src_pdfs'), document.getElementById('src_pdfs'));\"");


                            } else {


                                ?>

                                <td style="width:40px;">
                                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                           OnClick="add_item_to_select_box(document.getElementById('src_pdfs'), document.getElementById('dest_pdfs'));"/>
                                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                                   OnClick="remove_item_from_select_box(document.getElementById('dest_pdfs'));"/>
                                </td>


                                <td>
                                    <select class="mycontrol" name='arr_dest_pdfs[]' dir=rtl id='dest_pdfs' MULTIPLE
                                            SIZE=6 style='width:180px;'
                                            ondblclick="remove_item_from_select_box(document.getElementById('dest_pdfs'));"></select>

                                </td>

                                <?php


                            }
                            if ($level) {

                                form_url_noformtd("print_brands.php", "ערוך משתמשים", 1);

                            } elseif ((!$level)) {
                                echo '<td></td>';
                            }
                            echo '</tr>
</table>
</div>
</td>
</tr>';


                            /******************************************************************************************************/
                            /********************************************************************************************************************/


                            for ($i = 1; $i <= 31; $i++) {
                                $days[$i] = $i;
                            }
                            $months = array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
                            $dates = getdate();

                            $year = date('Y');

                            $end = $year;
                            $start = $year - 15;

                            for ($start; $start <= $end; $start++) {
                                $years[$start] = $start;
                            }
                            /************************************************************************************************/

                            /*******************************************************************************************************************/
                            $formdata['multi_year'] = isset($formdata['multi_year']) ? $formdata['multi_year'] : '';
                            $formdata['multi_month'] = isset($formdata['multi_month']) ? $formdata['multi_month'] : '';
                            $formdata['multi_day'] = isset($formdata['multi_day']) ? $formdata['multi_day'] : '';
                            if (!($formdata['multi_year'] && $formdata['multi_year'] != 'none')
                                && !($formdata['multi_month'] && $formdata['multi_month'] != 'none')
                                && !($formdata['multi_day'] && $formdata['multi_day'] != 'none')
                                && !($formdata)
                                || ($formdata && !(array_item($formdata, 'dest_pdfs')))
                            ) {


                                echo '<tr>
<td><div style=""   data-module="הזנת תאריכים לכמה משתמשים:">
<table class="myformtable1" id="my_date_table" style="width:60%">
<tr>';


                                echo '<td>';
//  form_label1("הזנת תאריכים לכמה משתמשים:",true);

                                list11("multi_year", $years, array_item($formdata, "multi_year"), " multiple size=6    id='multi_year' ");

                                list11("multi_month", $months, array_item($formdata, "multi_month"), " multiple size=6 id='multi_month' ");

                                list11("multi_day", $days, array_item($formdata, "multi_day"), " multiple size=6        id='multi_day' ");

                                echo '</td>';


                                echo '</tr>
</table></div>
</td>
</tr>';

                            }

                            /*******************************************************************************************/
                            if ($formdata && (array_item($formdata, 'dest_pdfs'))) {
                                echo '<tr>
<td>
<div style=""   data-module="הזנת תאריכים למשתמשים חדשים:">
<table class="myformtable1" id="my_date_table" style="width:60%">
<tr>
<td>';


                                list11("multi_year", $years, array_item($formdata, "multi_year"), " multiple size=6    id='new_multi_year' ");

                                list11("multi_month", $months, array_item($formdata, "multi_month"), " multiple size=6    id='new_multi_month' ");

                                list11("multi_day", $days, array_item($formdata, "multi_day"), " multiple size=6    id='new_multi_day' ");


                                echo ' 
</td>
</tr>
</table></div>
</td>
<tr>';


                            }
                            /*********************************************************************************************************/
                            if (array_item($formdata, 'dest_pdfs') && $formdata['dest_pdfs'] != 'none'){
                            $brandName = $formdata['brandName'] ? $formdata['brandName'] : '';
                            $brandID = $formdata['brandID'] ? $formdata['brandID'] : '';
                            $i = 0;
                            echo '<tr>';
                            echo '<td   class="myformtd" id="my_Frm_brands_td">';
                            /////////////////////////////////////////////////////////////////////
                            $link = "../admin/find3.php?brandID=$brandID";
                            $url = "../admin/find3.php?brandID=$brandID";
                            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';


                            $link_frm = "<a onClick=openmypage3('" . $url . "');   class=href_modal1  href='javascript:void(0)' >
<b style='color:brown;font-size:1.4em;'>$brandName<b></a>";


                            ////////////////////////////////////////////////////////////////////////////
                            // echo '<fieldset data-module="חברי הברנד:'.$brandName.'"  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  id="brands_fieldset" >';
                            echo '<fieldset data-module="חברי הברנד:' . $link_frm . '"  class="myformtable1"  style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  id="brands_fieldset" >';

                            echo '<div  id="content_brands" class="content_brands" style="">';
                            echo '<h4 class="my_title_brands" style=" height:15px"></h4>';
                            echo '<div   id="my_div_table" style="overflow:auto;">';
                            echo '<table  id="my_table" >';

                            /***************************************************/
                            foreach ($formdata['dest_pdfs'] as $key => $val){
                            /**************************************************/
                            $gif_num = '';

                            $tr_id = "my_tr$i";
                            $member_date = "member_date$i";

                            if ($formdata["active"][$key] == 2)
                                $gif_num = 1;
                            else
                                $gif_num = 0;
                            ?>
                            <tr>


                                <td width="16" id="my_active<?php echo $key;
                                echo $formdata['brandID']; ?>">
                                    <a href="javascript:void(0)"
                                       onclick="edit_active(<?php echo $key; ?>,<?php echo $formdata['brandID']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo $formdata["active"][$key]; ?>); return false;">
                                        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php echo $gif_num; //print $formdata["active"][$key]
                                        ?>.gif" width="16" height="10" alt="" border="0"/>
                                    </a>
                                </td>


                                <td>

                                    <?php

                                    form_label1("חבר ברנד:");
                                    form_text_a("member", $val, 20, 50, 1);


                                    if ($level) {


                                        ?>


                                        <input type="button" class="mybutton" id="my_button_<?php echo $key; ?>"
                                               value="ערוך משתמש"
                                               onClick="return editUser3(<?php echo $key; ?>,<?php echo $formdata['brandID']; ?>,
                                               <?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>); return false;"/>


                                        <!--<input type="button"  class="mybutton"  id="my_button_<?php echo $key; ?>"  value="ערוך משתמש" onClick="return editUser_frmID(<?php echo $key; ?>,<?php echo $formdata['brandID']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>);" ; return false; />-->

                                        <?php
                                    } elseif (!($level)) {

                                        ?>
                                        <input type="button" class="mybutton" id="my_button_<?php echo $key; ?>"
                                               value="צפה בפרטי המשתמש"
                                               onClick="return editUser3(<?php echo $key; ?>,<?php echo $formdata['brandID']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>);"
                                               ; return false;/>
                                        <?php

                                    }

                                    /***************************************************************************************/
                                    ?>
                                    <script language="JavaScript" type="text/javascript">

                                        $(document).ready(function () {
                                            $("#<?php echo $member_date; ?>").datepicker($.extend({}, {
                                                showOn: 'button',
                                                buttonImage: '<?php echo IMAGES_DIR;?>/calendar.gif',
                                                buttonImageOnly: true,
                                                changeMonth: true,
                                                changeYear: true,
                                                showButtonPanel: true,
                                                buttonText: "Open date picker",
                                                dateFormat: 'yy-mm-dd',
                                                altField: '#actualDate'
                                            }, $.datepicker.regional['he']));
                                        });
                                    </script>
                                    <?php

                                    /*****************************************************************************************/

                                    list($year_date, $month_date, $day_date) = explode('-', $formdata[$member_date]);
                                    if (strlen($day_date) == 4) {
                                        $formdata[$member_date] = "$year_date-$month_date-$day_date";
                                    } elseif (strlen($year_date) == 4) {
                                        $formdata[$member_date] = "$day_date-$month_date-$year_date";
                                    }

                                    form_label1("תאריך צרוף לברנד:");
                                    form_text3("$member_date", $formdata[$member_date], 20, 50, 1, $member_date);

                                    echo '</td>';


                                    echo '</tr>';

                                    $i++;

                                    }


                                    echo '</table>';

                                    echo '</div>';
                                    echo '</div>';
                                    echo '</fieldset>';
                                    echo '</td>';
                                    echo '</tr>';


                                    }

                                    else {


                                        echo '<tr>';
                                        echo '<td   class="myformtd" id="my_Frm_brands_td">';

                                        echo '<fieldset data-module="חברי הברנד:' . $link_frm . '"  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  id="brands_fieldset" >';
                                        echo '<div  id="content_brands" class="content_brands" style="">';
                                        echo '<h4 class="my_title_brands" style=" height:15px"></h4>';
                                        echo '<div   id="my_div_table" style="overflow:auto;width:80%;">';
                                        echo '<table  id="my_table" >';


                                        echo '</table>';

                                        echo '</div>';
                                        echo '</div>';
                                        echo '</fieldset>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    /*********************************************************************************************************/
                                    //DEALING WITH TREE VIEW
                                    /*********************************************************************************************************/

                                    if (array_item($formdata, "brandID")) {


                                        $sql = "SELECT d.decName,d.decID,d.parentDecID,f.brandName 
FROM decisions d,brand f, rel_brand r
WHERE d.decID = r.decID
AND r.brandID =f.brandID
AND r.brandID = " . $db->sql_string($formdata['brandID']) .
                                            " ORDER BY  d.decName ";


                                        if ($rows = $db->queryObjectArray($sql)) {

                                            $brandName = $rows[0]->brandName;


                                            echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

                                            echo '<tr>';
                                            echo '<td id="my_tree_td">';
                                            echo '<fieldset data-module="ערוך החלטות של ברנד:' . $link_frm . '"  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"   id="my_form">';
                                            echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
                                            echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';


                                            if ($level) {
                                                echo '<table   id="tree_content1" ><tr>';

                                            } elseif (!($level)) {
                                                echo '<table  id="tree_content1" ><tr>';
                                            }
                                            echo '<td>';
                                            echo '<div id="tree_content_ajx" class="tree_content"  >';
                                            treedisplayDown($rows, $formdata);
                                            $rootAttributes = array("decID" => "11");

                                            $treeID = "treev1";
                                            $tv = DBTreeView::createTreeView(
                                                $rootAttributes,
                                                TREEVIEW_LIB_PATH,
                                                $treeID);
// $str=""	;
                                            $str = "ערוך את ההחלטות";
// $str="צפייה בהחלטות"	;
                                            $tv->setRootHTMLText($str);

                                            $tv->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");
                                            $tv->printTreeViewScript();
                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';

                                            echo '</table>';


                                            echo '</fieldset>';
                                            echo '</td>';
                                            echo '</tr>';


                                            echo '</div>';


//--------------------------------------------------------------------------------


                                            echo '<div id="tree_content_target2" >';

                                            echo '<tr>';
                                            echo '<td id="my_tree_td2">';
                                            echo '<fieldset  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  data-module="הצג החלטות בחלון של ברנד:' . $link_frm . '"  id="my_form2">';
                                            echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
                                            echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';


                                            echo '<table  id="tree_content2" ><tr>';
                                            echo '<td>';
                                            echo '<div id="tree_content_ajx2" class="tree_content" >';
                                            treedisplayDown($rows, $formdata);
                                            $rootAttributes = array("decID" => "11", "flag_print" => "1");
                                            $treeID = "treev2";
                                            $tv1 = DBTreeView::createTreeView(
                                                $rootAttributes,
                                                TREEVIEW_LIB_PATH,
                                                $treeID);
                                            $str = "צפייה בהחלטות";


                                            $tv1->setRootHTMLText($str);
                                            $tv1->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");

                                            $tv1->printTreeViewScript();

                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                            echo '</table>';


                                            echo '</fieldset>';


                                            echo '</td>';
                                            echo '</tr>';

                                            echo '</div>';

                                            /*************************/
                                        }//end if $rows     */
                                        /***********************/

                                        /**************************************************************************************************************************************/
                                        elseif (!(ae_detect_ie())) {//FOR $ROWS=FALSE

                                            $brandName = $formdata['brandName'];

                                            echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

                                            echo '<tr>';
                                            echo '<td id="my_tree_td">';
                                            echo '<fieldset data-module="ערוך החלטות של ברנד:' . $link_frm . '"  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"   id="my_form">';
                                            echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
                                            echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';


                                            if ($level) {
                                                echo '<table   id="tree_content1" ><tr>';

                                            } elseif (!($level)) {
                                                echo '<table  id="tree_content1" ><tr>';
                                            }
                                            echo '<td>';
                                            echo '<div id="tree_content_ajx" class="tree_content"  >';


                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                            echo '</table>';


                                            echo '</fieldset>';
                                            echo '</td>';
                                            echo '</tr>';


                                            echo '</div>';


//--------------------------------------------------------------------------------

                                            echo '<div id="tree_content_target2" >';

                                            echo '<tr>';
                                            echo '<td id="my_tree_td2">';
                                            echo '<fieldset  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  data-module="הצג החלטות בחלון של ברנד:' . $link_frm . '"  id="my_form2">';
                                            echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
                                            echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';


                                            echo '<table  id="tree_content2" ><tr>';
                                            echo '<td>';
                                            echo '<div id="tree_content_ajx2" class="tree_content" >';


                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                            echo '</table>';


                                            echo '</fieldset>';


                                            echo '</td>';
                                            echo '</tr>';

                                            echo '</div>';
//-------------------------------------------EXPLORER-------------------------------------------------------------
                                        } else {

                                            $sql = "SELECT decName,decID,parentDecID 
FROM decisions 
WHERE decID = '1962' ";


                                            if ($rows = $db->queryObjectArray($sql)) {

                                                $brandName = $rows[0]->brandName;


                                                echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

                                                echo '<tr>';
                                                echo '<td id="my_tree_td">';
                                                echo '<fieldset data-module="ערוך החלטות של ברנד:' . $link_frm . '"  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"   id="my_form">';
                                                echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
                                                echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';


                                                if ($level) {
                                                    echo '<table   id="tree_content1" ><tr>';

                                                } elseif (!($level)) {
                                                    echo '<table  id="tree_content1" ><tr>';
                                                }
                                                echo '<td>';
                                                echo '<div id="tree_content_ajx" class="tree_content"  >';
                                                treedisplayDown($rows, $formdata);
                                                $rootAttributes = array("decID" => "11");

                                                $treeID = "treev1";
                                                $tv = DBTreeView::createTreeView(
                                                    $rootAttributes,
                                                    TREEVIEW_LIB_PATH,
                                                    $treeID);
                                                $str = "ערוך החלטות";
                                                $tv->setRootHTMLText($str);

                                                $tv->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");
                                                $tv->printTreeViewScript();
                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';

                                                echo '</table>';


                                                echo '</fieldset>';
                                                echo '</td>';
                                                echo '</tr>';


                                                echo '</div>';


//---------------------------------------------------------------------------------------------------------


                                                echo '<div id="tree_content_target2" >';

                                                echo '<tr>';
                                                echo '<td id="my_tree_td2">';
                                                echo '<fieldset  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  data-module="הצג החלטות בחלון של ברנד:' . $link_frm . '"  id="my_form2">';
                                                echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
                                                echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';


                                                echo '<table  id="tree_content2" ><tr>';
                                                echo '<td>';
                                                echo '<div id="tree_content_ajx2" class="tree_content" >';
                                                treedisplayDown($rows, $formdata);
                                                $rootAttributes = array("decID" => "11", "flag_print" => "1");
                                                $treeID = "treev2";
                                                $tv1 = DBTreeView::createTreeView(
                                                    $rootAttributes,
                                                    TREEVIEW_LIB_PATH,
                                                    $treeID);
                                                $str = "צפייה בהחלטות";

                                                $tv1->setRootHTMLText($str);
                                                $tv1->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");

                                                $tv1->printTreeViewScript();

                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';
                                                echo '</table>';


                                                echo '</fieldset>';


                                                echo '</td>';
                                                echo '</tr>';

                                                echo '</div>';


                                            }
                                        }
//-------------------------------------------END  EXPLORER---------------------------------------------------------


                                        /************************/
                                    }//end if brandID */
                                    /*********************/
//-----------------------------------------------FORM_DEM_9.PHP dynamic-select---------------------------------------------------------------
                                    elseif (!(array_item($formdata, 'brandID'))) {


                                        if (!(ae_detect_ie())) {//FOR $ROWS=FALSE

                                            $brandName = isset($formdata['brandName']) ? $formdata['brandName'] : '';

                                            echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

                                            echo '<tr>';
                                            echo '<td id="my_tree_td">';
                                            echo '<fieldset data-module="ערוך החלטות של ברנד:' . $link_frm . '"  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"   id="my_form">';
                                            echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
                                            echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';


                                            if ($level) {
                                                echo '<table   id="tree_content1" ><tr>';

                                            } elseif (!($level)) {
                                                echo '<table  id="tree_content1" ><tr>';
                                            }
                                            echo '<td>';
                                            echo '<div id="tree_content_ajx" class="tree_content"  >';


                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                            echo '</table>';


                                            echo '</fieldset>';
                                            echo '</td>';
                                            echo '</tr>';


                                            echo '</div>';


//--------------------------------------------------------------------------------

                                            echo '<div id="tree_content_target2" >';

                                            echo '<tr>';
                                            echo '<td id="my_tree_td2">';
                                            echo '<fieldset  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  data-module="הצג החלטות בחלון של ברנד:' . $link_frm . '"  id="my_form2">';
                                            echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
                                            echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';


                                            echo '<table  id="tree_content2" ><tr>';
                                            echo '<td>';
                                            echo '<div id="tree_content_ajx2" class="tree_content" >';


                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                            echo '</table>';


                                            echo '</fieldset>';


                                            echo '</td>';
                                            echo '</tr>';

                                            echo '</div>';
//-------------------------------------------EXPLORER-------------------------------------------------------------
                                        } else {

                                            $sql = "SELECT decName,decID,parentDecID 
FROM decisions 
WHERE decID = '841' ";


                                            if ($rows = $db->queryObjectArray($sql)) {

                                                $brandName = $rows[0]->brandName;


                                                echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

                                                echo '<tr>';
                                                echo '<td id="my_tree_td">';
                                                echo '<fieldset data-module="ערוך החלטות של ברנד:' . $link_frm . '"  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"   id="my_form">';
                                                echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
                                                echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';


                                                if ($level) {
                                                    echo '<table   id="tree_content1" ><tr>';

                                                } elseif (!($level)) {
                                                    echo '<table  id="tree_content1" ><tr>';
                                                }
                                                echo '<td>';
                                                echo '<div id="tree_content_ajx" class="tree_content"  >';
                                                treedisplayDown($rows, $formdata);
                                                $rootAttributes = array("decID" => "11");

                                                $treeID = "treev1";
                                                $tv = DBTreeView::createTreeView(
                                                    $rootAttributes,
                                                    TREEVIEW_LIB_PATH,
                                                    $treeID);
                                                $str = "ערוך החלטות";
                                                $tv->setRootHTMLText($str);

                                                $tv->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");
                                                $tv->printTreeViewScript();
                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';

                                                echo '</table>';


                                                echo '</fieldset>';
                                                echo '</td>';
                                                echo '</tr>';


                                                echo '</div>';


//---------------------------------------------------------------------------------------------------------


                                                echo '<div id="tree_content_target2" >';

                                                echo '<tr>';
                                                echo '<td id="my_tree_td2">';
                                                echo '<fieldset  class="myformtable1" style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;"  data-module="הצג החלטות בחלון של ברנד:' . $link_frm . '"  id="my_form2">';
                                                echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
                                                echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';


                                                echo '<table  id="tree_content2" ><tr>';
                                                echo '<td>';
                                                echo '<div id="tree_content_ajx2" class="tree_content" >';
                                                treedisplayDown($rows, $formdata);
                                                $rootAttributes = array("decID" => "11", "flag_print" => "1");
                                                $treeID = "treev2";
                                                $tv1 = DBTreeView::createTreeView(
                                                    $rootAttributes,
                                                    TREEVIEW_LIB_PATH,
                                                    $treeID);
                                                $str = "צפייה בהחלטות";

                                                $tv1->setRootHTMLText($str);
                                                $tv1->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");

                                                $tv1->printTreeViewScript();

                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';
                                                echo '</table>';


                                                echo '</fieldset>';


                                                echo '</td>';
                                                echo '</tr>';

                                                echo '</div>';


                                            }
                                        }
//-------------------------------------------END  EXPLORER---------------------------------------------------------

                                    }




                                    // buttons


                                    echo '<tr>
<td><table class="myformtable1"><tr><td>';

                                    $button_id = $formdata['brandID'];
                                    $brandID = $formdata['brandID'];


                                    if ($level) {

                                        form_button_no_td2("submitbutton", "שמור", "Submit", "OnClick=\"
prepSelObject(document.getElementById('dest_brandsType'));
prepSelObject(document.getElementById('dest_managersType'));
prepSelObject(document.getElementById('dest_pdfs'));
\";");

// onclick="return  document.getElementById('mode_').value='take_data';"  >העלה מידע</button>
                                        ?>
                                        <button class="green90x24" type="submit"
                                                name="submitbutton3_<?php echo $formdata['brandID']; ?>"
                                                id="submitbutton3_<?php echo $formdata['brandID']; ?>"
                                                onclick="return  prepSelObject(document.getElementById('dest_brandsType'))
, prepSelObject(document.getElementById('dest_managersType'))
,prepSelObject(document.getElementById('dest_pdfs'));">העלה מידע
                                        </button>

                                        <?php

                                        if (array_item($formdata, 'dynamic_6')) {
                                            $x = $formdata['index'];
                                            $formdata["brandID"] = $formdata["brandID"][$x];
                                            $tmp = (array_item($formdata, "brandID")) ? "update" : "save";
                                            form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["brandID"]);
                                            form_hidden("brandID", $formdata["brandID"]);
                                            form_hidden("insertID", $formdata["insertID"]);
                                        } else
                                            $tmp = (array_item($formdata, "brandID")) ? "update" : "save";
                                        $formdata["brandID"] = isset($formdata["brandID"]) ? $formdata["brandID"] : '';
                                        $formdata["insertID"] = isset($formdata["insertID"]) ? $formdata["insertID"] : '';
                                        form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["brandID"]);
                                        form_hidden("brandID", $formdata["brandID"]);
                                        form_hidden("insertID", $formdata["insertID"]);


                                        if (array_item($formdata, "brandID") && !$formdata['fail']) {


//     form_button_no_td2("btnLink1", "קשר לברנד","Submit");
//     form_hidden("brandID", $formdata["brandID"]);


// form_button1("btnDelete", "מחק ברנד", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["brandID"]."').value='delete'\";");
                                            form_empty_cell_no_td(20);
                                            form_button_no_td2("btnDelete", "מחק ברנד", "Submit", "OnClick='return shalom(\"" . $formdata[brandID] . "\")'");


                                        } else {

                                            form_empty_cell_no_td(10);

// form_button_no_td("btnClear","הכנס נתונים לברנד/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["btnClear"]."').value='clear'\"; id='reset'");
                                            form_button_no_td("btnClear", "הכנס נתונים לברנד/נקה טופס", "Submit", "id=reset");


                                        }
//////////////////////////
                                    } elseif (!($level)) {   ///
/////////////////////////
                                        form_hidden("brandID", $formdata["brandID"]);
                                        form_hidden("insertID", $formdata["insertID"]);
                                        $tmp = (array_item($formdata, "brandID")) ? "update" : "save";
                                        form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["brandID"]);
                                        form_hidden("brandID", $formdata["brandID"]);
                                        form_hidden("insertID", $formdata["insertID"]);
                                        ?>
                                        <button class="green90x24" type="submit"
                                                name="submitbutton3_<?php echo $formdata['brandID']; ?>"
                                                id="submitbutton3_<?php echo $formdata['brandID']; ?>"
                                                onclick="return  prepSelObject(document.getElementById('dest_brandsType'))
, prepSelObject(document.getElementById('dest_managersType'))
,prepSelObject(document.getElementById('dest_pdfs'));">העלה מידע
                                        </button>

                                        <?php
                                    }


                                    unset($formdata['fail']);


                                    echo '</td>
</tr></table></td></tr>';


                                    /************************************************************************************************/

                                    ?>


                        </table>

                        <div id="loading" class="loading1">
                            <img src="../images/loading4.gif" border="0"/>
                        </div>


                        <?php
                        if (isset($formdata["save_new"]) && !($formdata["save_new"])) {
                            ?>
                            <!--      <h4 class="my_menu_items_brand_title" style="height:15px;cursor:pointer;display:none;"></h4>-->
                            <?php
                        }
                        ?>

                        <h4 class="my_menu_items_brand_title" style="height:15px;cursor:pointer;display:none;"></h4>

                        <ul id="menu_items_brand_8" name="menu_items_brand_8" class="ui-sortable"
                            style="overflow: auto;direction:right;" dir="rtl">
                            <input type=hidden name="menu_items_brand" id="menu_items_brand"
                                   value="<?php echo $formdata['brandID'] ?>"/>

                            <div id="brandID" name="brandID" class="my_div"></div>
                            <div id="brandID_a" name="brandID_a"></div>
                            <div id="brandID_b" name="brandID_b"></div>
                            <div id="brandID_c" name="brandID_c"></div>
                            <div id="brandID_d" name="brandID_d"></div>
                            <div id="brandID_e" name="brandID_e"></div>
                            <div id="brandID3" name="brandID3"></div>
                            <div id="brandID4" name="brandID4"></div>
                            <div id="brandID5" name="brandID5"></div>
                            <div id="brandID6" name="brandID6"></div>
                            <div id="brand-message" name="brand-message"></div>

                        </ul>


                </fieldset>

            </form>
            <!-- ============================================================================================================ -->

            <?php
            //$brandID=(isset($brandID) )?(int)$brandID:1;
            ?>
            <div id="page_useredit" class="page_useredit" style="display:none">

                <h3 class="my_title" style=" height:15px"></h3>
                <h3><?php __('edit_user'); ?></h3>

                <div class="content">


                    <form onSubmit="return saveUser3(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>);"
                          name="edituser" id="edituser" dir="rtl">
                        <input type="hidden" name="Request_Tracking_Number_1" id="Request_Tracking_Number_1" value=""/>
                        <input type="hidden" name="Request_Tracking_Number1" id="Request_Tracking_Number1" value=""/>
                        <input type="hidden" name="Request_Tracking_Number2" id="Request_Tracking_Number2" value=""/>
                        <input type="hidden" name="id" value=""/>


                        <div class="form-row">
                            <span class="h"><?php __('priority'); ?></span>
                            <SELECT name="prio" id="prio" class="mycontrol">
                                <option value="3">+3</option>
                                <option value="2">+2</option>
                                <option value="1">+1</option>
                                <option value="0" selected>&plusmn;0</option>
                                <option value="-1">&minus;1</option>
                            </SELECT>
                            &nbsp;


                            <span class="h"><?php __('active'); ?></span>
                            <SELECT name="active" id="active" class="mycontrol">
                                <option value="1" selected>1</option>
                                <option value="0">0</option>

                            </SELECT>
                            &nbsp;


                            <span class="h"><?php __('due'); ?> </span>
                            <input name="duedate3" id="duedate3" value="" class="in100"
                                   title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off"/>
                        </div>


                        <div class="form-row">
                            <span class="h"><?php __('level'); ?></span>
                            <SELECT name="level" id="level" class="mycontrol">
                                <option value="1"><?php __(brand_user) ?></option>
                                <option value="2"><?php __(admin) ?></option>
                                <option value="3"><?php __(suppervizer) ?></option>
                                <option value="none" selected>(בחר אופציה)</option>
                            </SELECT>

                        </div>


                        <div class="form-row"><span class="h"><?php __('full_name'); ?></span><br> <input type="text"
                                                                                                          name="full_name"
                                                                                                          id="full_name"
                                                                                                          value=""
                                                                                                          class="in200"
                                                                                                          maxlength="50"/>
                        </div>
                        <div class="form-row"><span class="h"><?php __('user'); ?></span><br> <input type="text"
                                                                                                     name="user"
                                                                                                     id="user" value=""
                                                                                                     class="in200"
                                                                                                     maxlength="50"/>
                        </div>
                        <div class="form-row"><span class="h"><?php __('upass'); ?></span><br> <input type="text"
                                                                                                      name="upass"
                                                                                                      id="upass"
                                                                                                      value=""
                                                                                                      class="in200"
                                                                                                      maxlength="50"/>
                        </div>
                        <div class="form-row"><span class="h"><?php __('email'); ?></span><br> <input type="text"
                                                                                                      name="email"
                                                                                                      id="email"
                                                                                                      value=""
                                                                                                      class="in200"
                                                                                                      maxlength="50"/>
                        </div>
                        <div class="form-row"><span class="h"><?php __('phone'); ?></span><br> <input type="text"
                                                                                                      name="phone"
                                                                                                      id="phone"
                                                                                                      value=""
                                                                                                      class="in200"
                                                                                                      maxlength="50"/>
                        </div>
                        <div class="form-row"><span class="h"><?php __('note'); ?></span><br> <textarea name="note"
                                                                                                        id="note"
                                                                                                        class="in500"></textarea>
                        </div>
                        <div class="form-row"><span class="h"><?php __('tags'); ?></span><br> <input type="text"
                                                                                                     name="tags"
                                                                                                     id="edittags1"
                                                                                                     value=""
                                                                                                     class="in500"
                                                                                                     maxlength="250"/>
                        </div>
                        <div class="form-row">

                            <?php if ($level) { ?>
                                <input type="submit" id="edit_usr" value="<?php __('save'); ?>" onClick="this.blur()"/>
                            <?php } ?>
                            <input type="button" id="my_button_usrDetails" value="<?php __('usr_details'); ?>"
                                   class="href_modal1"/>
                            <input type="button" value="<?php __('cancel'); ?>"
                                   onClick="canceluserEdit3();this.blur();return false"/>

                        </div>
                    </form>

                </div> <!--  end div content -->

            </div> <!--  end of page_user_edit -->

            <!-- ============================================================================================================ -->
            <?php
            $brandID = (isset($brandID)) ? (int)$brandID : 1;
            ?>
            <div id="page_useredit<?php echo $brandID; ?>" style="display:none">

                <h3><?php __('edit_user'); ?></h3>


                <form onSubmit="return saveUser4brand(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo $brandID; ?>);"
                      name="edituser<?php echo $brandID; ?>" id="edituser<?php echo $brandID; ?>" dir="rtl">


                    <input type="hidden" name="id<?php echo $brandID; ?>" value=""/>
                    <input type="hidden" name="Request_Tracking_Number_1" id="Request_Tracking_Number_1" value=""/>
                    <input type="hidden" name="Request_Tracking_Number1" id="Request_Tracking_Number1" value=""/>
                    <input type="hidden" name="Request_Tracking_Number2" id="Request_Tracking_Number2" value=""/>


                    <div class="form-row">
                        <span class="h"><?php __('priority'); ?></span>
                        <SELECT name="prio" id="prio<?php echo $brandID; ?>" class="mycontrol">
                            <option value="3">+3</option>
                            <option value="2">+2</option>
                            <option value="1">+1</option>
                            <option value="0" selected>&plusmn;0</option>
                            <option value="-1">&minus;1</option>
                        </SELECT>
                    </div>


                    <div class="form-row">
                        <span class="h"><?php __('active'); ?></span>
                        <SELECT name="active<?php echo $brandID; ?>" id="active<?php echo $brandID; ?>"
                                class="mycontrol">
                            <option value="2" selected>פעיל</option>
                            <option value="1">לא פעיל</option>

                        </SELECT>
                    </div>
                    &nbsp;


                    <div class="form-row">
                        <span class="h"><?php __('due'); ?> </span>
                        <input name="duedate3<?php echo $brandID; ?>" id="duedate3<?php echo $brandID; ?>"
                               value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off"/>

                    </div>


                    <div class="form-row">
                        <span class="h"><?php __('level'); ?></span>
                        <SELECT name="level" id="level<?php echo $brandID; ?>" class="mycontrol">
                            <option value="1"><?php __(brand_user) ?></option>
                            <option value="2"><?php __(admin) ?></option>
                            <option value="3"><?php __(suppervizer) ?></option>
                            <option value="none" selected>(בחר אופציה)</option>
                        </SELECT>

                    </div>


                    <div class="form-row"><span class="h"><?php __('full_name'); ?></span><br> <input type="text"
                                                                                                      name="full_name"
                                                                                                      id="full_name<?php echo $brandID; ?>"
                                                                                                      value=""
                                                                                                      class="in200"
                                                                                                      maxlength="50"/>
                    </div>

                    <div class="form-row"><span class="h"><?php __('user'); ?></span><br> <input type="text" name="user"
                                                                                                 id="user<?php echo $brandID; ?>"
                                                                                                 value="" class="in200"
                                                                                                 maxlength="50"/></div>

                    <div class="form-row"><span class="h"><?php __('upass'); ?></span><br> <input type="text"
                                                                                                  name="upass"
                                                                                                  id="upass<?php echo $brandID; ?>"
                                                                                                  value="" class="in200"
                                                                                                  maxlength="50"/></div>
                    <div class="form-row"><span class="h"><?php __('email'); ?></span><br> <input type="text"
                                                                                                  name="email"
                                                                                                  id="email<?php echo $brandID; ?>"
                                                                                                  value="" class="in200"
                                                                                                  maxlength="50"/></div>
                    <div class="form-row"><span class="h"><?php __('phone'); ?></span><br> <input type="text"
                                                                                                  name="phone"
                                                                                                  id="phone<?php echo $brandID; ?>"
                                                                                                  value="" class="in200"
                                                                                                  maxlength="50"/></div>
                    <div class="form-row"><span class="h"><?php __('note'); ?></span><br> <textarea
                                name="note<?php echo $brandID; ?>" id="note<?php echo $brandID; ?>"
                                class="in500"></textarea></div>
                    <div class="form-row"><span class="h"><?php __('tags'); ?></span><br> <input type="text"
                                                                                                 name="tags<?php echo $brandID; ?>"
                                                                                                 id="edittags1<?php echo $brandID; ?>"
                                                                                                 value="" class="in500"
                                                                                                 maxlength="250"/></div>


                    <div class="form-row">
                        <?php if ($level) { ?>
                            <input type="submit" value="<?php __('save'); ?>" onClick="this.blur()"/>
                        <?php } ?>
                        <input type="button" id="my_button_win1<?php echo $brandID; ?>"
                               value="<?php __('brand_details'); ?>" class="href_modal1"/>
                        <input type="button" value="<?php __('cancel'); ?>"
                               onClick="canceluserEdit6(<?php echo $brandID; ?>);this.blur();return false"/>
                    </div>
                </form>


            </div>  <!-- end of page_user_edit+brandID -->

    </div>   <!--  end div main  -->


    <?php
    /**************************************************************************************************/
}//end build_ajxform7
/**************************************************************************************************/
