<?php

function build_form(&$formdata)
{
    global $db;
       if (array_item($formdata, 'catID')) {
            $catID = array_item($formdata, 'catID');
            ?>
            <input type="hidden" id="catID" name="catID" value="<?php echo $catID; ?>"/>
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
        <div id="cat_error" name="cat_error"></div>
        <?php
    }
    ?>
<!--    <script language="javascript" src="--><?php //print JS_ADMIN_WWW ?><!--/treeview_forum.js" type="text/javascript"></script>-->
<!--    <script language="JavaScript" src="--><?php //print JS_ADMIN_WWW ?><!--/info_cat.js" type="text/javascript"></script>-->


    <div id="main">
        <form style="width:95%;" name="cat_org" id="cat_org" method="post" action="../admin/category_brand.php"
              onsubmit="prepSelObject(document.getElementById('dest_pdfs'));
                        prepSelObject(document.getElementById('dest_publishers'));
                        prepSelObject(document.getElementById('dest_categoriesType'));
                        prepSelObject(document.getElementById('dest_managersType'));" >
                <fieldset style="margin-right:4%;width:90%;color:#000000; background: #94C5EB url(../../images/background-grad.png) repeat-x;"  >
                    <legend> מלא את הטופס להוספת סוג ברנד:</legend>
                    <div class="wrapper_cat" style="width:100%">
                    <?PHP
                    $page_input = isset($formdata['pages']) ? $formdata['pages'] : '';
                    ?>
                    <input type="hidden" name="pdf_page_num"  id="pdf_page_num" value="<?PHP echo $page_input; ?>">
                    <?php
                    if (array_item($formdata, 'catID')) {
                        $cat = new category();
                        $cat->print_forum_entry_form_c($formdata['catID']);
                    }
                    $dates = getdate();
//-----------------------------------------------------------
   $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    if($rows = $db->queryObjectArray($sql)){
    foreach ($rows as $row) {
    $subcategoriesftype[$row->parentCatID][] = $row->catID;
    $catNamesftype[$row->catID] = $row->catName;
    }
    $rows = build_category_array($subcategoriesftype[NULL], $subcategoriesftype, $catNamesftype);
    }
                    echo '<div class="myformtable1" style="width:60%;height: auto;"  data-module="שם הברנד:">';
//---------------------------------UPDATE------------------------------------------
                    if (array_item($formdata, 'catID')) {
   if($level) {

                        echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("שם סוג הברנד:", true);
                        form_list_b("cat_brand", $rows, array_item($formdata, "catID"),"id = cat_brand");
                        form_empty_cell_no_td(10);
                        echo '</div>';

                         echo '<div class="myformtd 1" style="width:60%;margin-top: 15px;">';
                                 $connect = array_item($formdata, "insertID") ? array_item($formdata, "insertID") : '11';
                                 form_label1("קשר לברנד:", TRUE);
                                 form_list_find_notd("insert_forum", "insert_forum", $rows, $connect);
                                 form_empty_cell_no_td(5);
                         echo '</div>';

                          echo '<div class="myformtd 1" style="width:60%;">';
                          form_label_red1("קידומת:", TRUE);
                          form_text_a("catPrefix", array_item($formdata, "catPrefix"), 45, 45, 1, "catPrefix");
                          form_empty_cell_no_td(5);
                          echo '</div>';

                        echo '<div class="myformtd 1" style="width:60%;">';
                            form_url2("create_brand.php", "ערוך ברנדים", 2);
                        echo '</div>';
                      }

                      else{
                             echo '<div class="myformtd 1" style="width:60%;">';
                                    form_label_red1("שם הברנד:", true);
                                    form_list_b("cat_brand", $rows, array_item($formdata, "catID"),"id = cat_brand");
                                    form_empty_cell_no_td(10);
                             echo '</div>';


                             $date_val = array_item($formdata, "cat_date2");
                              echo '<input type="hidden" id="cat_date3" value='.$date_val.'" >';


                              $prefix_val = array_item($formdata, "catPrefix");
                              echo '<input type="hidden" id="catPrefix" value='.$prefix_val.'" >';
                      }
                    }
//-----------------------SAVE--------------------------------------------
                    else{
                     if($level) {

                     echo '<div class="myformtd 1" style="width:60%;margin-top: 15px;">';
                        form_label1("שם ברנד:", TRUE);
                        form_text_a("newcatName", array_item($formdata, "tmpName"), 20, 50, 1);
                        form_empty_cell_no_td(5);
                     echo '</div>';


//                    echo '<div class="myformtd 1" style="width:60%;margin-top: 15px;">';
//                     $connect = array_item($formdata, "insertID") ? array_item($formdata, "insertID") : '11';
//                     form_label1("קשר לברנד:", TRUE);
//                     form_list_find_notd("insert_forum", "insert_forum", $rows, $connect);
//                     form_empty_cell_no_td(5);
//                      echo '</div>';

                        echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("קידומת:", TRUE);
                        //form_list_find_notd_no_choose2('cat_prefix', $arr_show, $selected_show, "id=cat_prefix");
                        form_text_a("catPrefix", array_item($formdata, "catPrefix"), 20, 50, 1);
                        form_empty_cell_no_td(5);
                        echo '</div>';


                     }

else{
                             echo '<div class="myformtd 1" style="width:60%;">';
                                    form_label_red1("שם הברנד::", true);
                                    form_list_b("cat_brand", $rows, array_item($formdata, "catID"),"id = cat_brand");
                                   //form_text_a("cat_brand", array_item($formdata, "catName"), 15, 15, 1);
                                    form_empty_cell_no_td(10);
                             echo '</div>';

                             $date_val = array_item($formdata, "cat_date2");
                              echo '<input type="hidden" id="cat_date3" value='.$date_val.'" >';


                              $prefix_val = array_item($formdata, "catPrefix");
                              echo '<input type="hidden" id="catPrefix" value='.$prefix_val.'" >';
                      }
 }
                    echo '</div>';

//---------------------------BUTTON-------------------------------------------
           // if ($level) {
                echo '<div class="myformtd">';
                form_button_no_td2("submitbutton", "שמור", "Submit", "OnClick=\"
                                            prepSelObject(document.getElementById('dest_categoriesType'));
                                            prepSelObject(document.getElementById('dest_managersType'));
                                            prepSelObject(document.getElementById('dest_pdfs'));
                                            \";");
                echo '</div>';
                if (array_item($formdata, 'dynamic_6')) {
                    $x = $formdata['index'];
                    $formdata["catID"] = $formdata["catID"][$x];
                    $tmp = (array_item($formdata, "catID")) ? "update" : "save";
                    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["catID"]);
                    echo '<div class="myformtd" style="width:60%;">';
                    form_hidden("catID", $formdata["catID"]);
                    form_hidden("insertID", $formdata["insertID"]);
                    echo '</div>';
                } else
                    $tmp = (array_item($formdata, "catID")) ? "update" : "save";
                $formdata["catID"] = isset($formdata["catID"]) ? $formdata["catID"] : '';
                $formdata["insertID"] = isset($formdata["insertID"]) ? $formdata["insertID"] : '';
                echo '<div class="myformtd" style="width:60%;">';
                form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["catID"]);
                form_hidden("catID", $formdata["catID"]);
                form_hidden("insertID", $formdata["insertID"]);
                echo '</div>';
                if (!empty($formdata['fail']) && array_item($formdata, "catID") && !$formdata['fail']) {
                    echo '<div class="myformtd" style="width:60%;">';
                    form_button_no_td2("btnLink1", "קשר לברנד");
                    form_hidden("catID", $formdata["catID"]);
                    form_button1("btnDelete", "מחק ברנד", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["catID"]."').value='delete'\";");
                    form_empty_cell_no_td(20);
                    form_button_no_td2("btnDelete", "מחק ברנד", "Submit", "OnClick='return shalom(\"" . $formdata[catID] . "\")'");
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
             echo '</div></fielset></form></div>';
}//end build_form


