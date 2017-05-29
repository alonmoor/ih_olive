<?php

function build_form(&$formdata)
{
    global $db;
    global $lang;

    if (!empty($formdata['count'])) {
        $count = $formdata['count'];
        if ($count)
            if ($count == 1)
                echo "<p>pdf נוסף.</p>\n";
            else {
                echo "<p>$count pdf נוספו.</p>\n";
            }
    }
    ?>
    <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/decision.js" type="text/javascript"></script>

    <?PHP
    if (array_item($formdata, 'pdfID')) {
        $pdfID = array_item($formdata, 'pdfID');
        ?>
        <input type="hidden" id="pdfID" name="pdfID" value="<?php echo $pdfID; ?>"/>
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
        <?php
    }
    global $dbc;

// Include the header file:
    $page_title = ' PDF -הוסף קבצי';
// For storing errors:
    $add_pdf_errors = array();
    /*** maximum filesize allowed in bytes ***/
    $max_file_size = 512000;
    /*** the maximum filesize from php.ini ***/
    $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
    $upload_max = $ini_max * 1024;
    require_once(LIB_DIR . "/form_functions.inc.php");
    ?><h3> PDF  -הוסף   </h3>

    <form enctype="multipart/form-data" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>?mode=add_pdf" method="post"
          accept-charset="utf-8" dir="rtl"    onsubmit="prepSelObject(document.getElementById('dest_publishers'));" >

        <script type="text/javascript" src="https://rawgithub.com/mozilla/pdf.js/gh-pages/build/pdf.js"></script>
<!--        <input type="hidden" name="MAX_FILE_SIZE" value="512000"/>-->
        <div style="color:#000000; background: #94C5EB url(../../images/background-grad.png) repeat-x;">
            <legend> מלא את הטופס להוספת קובץ PDF :</legend>
           <?php  echo '<div class="myformtable1" style="overflow:hidden;width:40%;"  data-module="הזן PDF:">'; ?>
            <p style="margin-right: 30px;">
                <label for="title" ><strong>כותרת</strong></label><br/><?php create_form_input('title', 'text', $add_pdf_errors); ?>
            </p>
            <p style="margin-right: 30px;">
                <label for="description"   sttyle="margin-right: 30px;"><strong>תאור</strong></label><br/><?php create_form_input('description', 'textarea', $add_pdf_errors); ?>
            </p>


            <canvas id="the-canvas" style="border:1px solid black"></canvas>
            <p><label for="pdf"><strong>PDF</strong></label><br/>
                <!-- <input type="file" name="pdf[]" id="pdf"  multiple="multiple" ';// name="upload[]" type="file" multiple="multiple"-->
                <?php
                echo '<input type="file" name="pdf[]" id="pdf"  multiple="multiple" ';// name="upload[]" type="file" multiple="multiple"
                //echo '<input type="file" name="pdf" id="pdf"';
                //    echo '<input type="file" name="pdf[]" id="pdf" multiple="multiple"  ';
                // Check for an error:
//-----------------------------------------------
                if (array_key_exists('pdf', $add_pdf_errors)) {
                    echo ' class="error" /> <span class="error">' . array2ul($formdata['error']) . '</span>';
                } else { // No error.
                    echo ' />';
// If the file exists (from a previous form submission but there were other errors),
// store the file info in a session and note its existence:
//                    if (isset($_SESSION['pdf']) && isset($_SESSION['pdf']['file_name'])) {
//                        echo " Currently '{$_SESSION['pdf']['file_name']}'";
//                    }
                } // end of errors IF-ELSE.
//------------------------------------------------



                ?>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>"/>
<!--                <script language="JavaScript" src="--><?php //print JS_ADMIN_WWW ?><!--/my_pdf.js" charset="utf-8" type="text/javascript"></script>-->
                <style id="jsbin-css">
                </style>
                <small>גבול מותר 2MB</small>
            </p></div>

            <?PHP
            $arr = array();
            $arr[0][0] = "סגורה";
            $arr[0][1] = "1";
            $arr[1][0] = "פתוחה";
            $arr[1][1] = "2";
            $selected = array_item($formdata, 'pdf_status') ? array_item($formdata, 'pdf_status') : $arr[1][1];


            echo '<div class="myformtable1" style="overflow:hidden;width:40%;"  data-module="הזן STATUS:">';
            form_list_find_notd_no_choose('pdf_status', 'pdf_status', $arr, $selected);
            echo '</div>', "\n";
//---------------------------------PUBLISHER-----------------------------------------------
            echo '<div class="myformtable1" style="overflow:hidden;width:40%;"  data-module="הזן PUBLISHER:">';
            $sql = "SELECT pubName, pubID FROM publishers ORDER BY pubID";
            $rows = $db->queryArray($sql);
            ?>
            <div class="myformtd" style="margin-top: 10px;">
                <?PHP
                form_list111("src_publishers", $rows, array_item($formdata, "src_publishers"), "multiple size=6 id='src_publishers' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_publishers'), document.getElementById('dest_publishers'));\"");
                ?>
            </div>
            <?PHP
            if (isset($formdata['dest_publishers']) && $formdata['dest_publishers'] != 'none') {
                $dest_publishers = $formdata['dest_publishers'];
//                unset($staff_test);
//                unset($staff_testb);
//                foreach ($dest_publishers as $key => $val) {
//                    if (!is_numeric($val)) {
//                        $val = $db->sql_string($val);
//                        $staff_test[] = $val;
//                    } elseif (is_numeric($val)) {
//                        $staff_testb[] = $val;
//                    }
//                }

//-------------------------------------------------------------


                $pubIds = '';
                $i = 0;
                foreach($dest_publishers as $key => $val){
                    if ($i == 0) {
                        $pubIds = $val;
                    } else {
                        $pubIds .= "," . $val;
                    }
                    $i++;
            }

            $query = "SELECT pubName, pubID FROM publishers  where pubID in ($pubIds)";
            if ($rows = $db->queryObjectArray($query)){
                foreach ($rows as $value) {

                    $value->pubName  = $db->sql_string($value->pubName);
                    $staff_test[] = $value->pubName;

                    $staff_testb[] = $value->pubID;
                }
            }


//-------------------------------------------------------
                if (isset($staff_test) && is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                    $staff = implode(',', $staff_test);

                    $sql2 = "SELECT pubName, pubID FROM publishers  where pubName in ($staff)";
                    if ($rows = $db->queryObjectArray($sql2))
                        foreach ($rows as $row) {
                            $name[$row->pubID] = $row->pubName;
                        }
                } elseif (isset($staff_test) &&  is_array($staff_test)  && is_array($staff_testb) && $staff_testb) {
                    $staff = implode(',', $staff_test);
                    $sql2 = "SELECT pubName, pubID FROM publishers  where pubName in ($staff)";
                    if ($rows = $db->queryObjectArray($sql2))
                        foreach ($rows as $row) {
                            $name[$row->pubID] = $row->pubName;
                        }
                }

//                else {
//
//                    foreach ($formdata['dest_publishers'] as $pubID) {
//                        $sql2 = "SELECT pubName, pubID FROM publishers  where pubID in ($pubID)";
//                        if ($rows = $db->queryObjectArray($sql2))
//                            $name_1[$rows[0]->pubID] = $rows[0]->pubName;
//                    }
//                }
                ?>
                <div class="myformtd test0" style="width:180px;margin-right: 200px">
                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                           OnClick="add_item_to_select_box(document.getElementById('src_publishers'), document.getElementById('dest_publishers'));"/>
                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                   OnClick="remove_item_from_select_box(document.getElementById('dest_publishers'));"/>
                </div>
                <?PHP
                if(isset($name)){
                echo '<div style="width:30%;" class="test">';
                form_list11("dest_publishers", $name, array_item($formdata, "dest_publishers"), "multiple size=6 id='dest_publishers' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_publishers'));\"");
                echo '</div>';
                }
            } elseif (isset($formdata['src_publishers']) && isset($formdata['src_publishers'[0]]) && $formdata['src_publishers'][0] != 0 && !$formdata['dest_publishers']) {
                $dest_types = $formdata['src_publishers'];
                $pubNames = '';
                for ($i = 0; $i < count($dest_types); $i++) {
                    if ($i == 0) {
                        $pubNames = $dest_types[$i];
                    } else {
                        $pubNames .= "," . $dest_types[$i];
                    }
                }
                $name = explode(",", $pubNames);
                $sql2 = "SELECT pubName, pubID FROM publishers  where pubName in ($pubNames)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {
                        $name[$row->pubID] = $row->pubName;
                    }
                ?>
                <div class="myformtd test3" style="width:30%;">
                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                           OnClick="add_item_to_select_box(document.getElementById('src_publishers'), document.getElementById('dest_publishers'));"/>

                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                   OnClick="remove_item_from_select_box(document.getElementById('dest_publishers'));"/>
                </div>

                <?PHP
                echo '<div style="width:30%;"  class="test2">';
                form_list11("src_publishers", $name, array_item($formdata, "src_publishers"), "multiple size=6 id='src_publishers' ondblclick=\"add_item_to_select_box(document.getElementById('src_publishers'), document.getElementById('dest_publishers'));\"");
                echo '</div>';
            } else {
                $x=1;
                ?>
                <div class="myformtd test4" style="width:180px;float: left;margin-top: -100px;margin-left: 195px;">
                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                           OnClick="add_item_to_select_box(document.getElementById('src_publishers'), document.getElementById('dest_publishers'));"/>
                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                   OnClick="remove_item_from_select_box(document.getElementById('dest_publishers'));"/>
                </div>
                <div class="myformtd test 5" style="width: 180px;float: left;margin-top: -100px;">
                    <select class="mycontrol" name='arr_dest_publishers[]' dir=rtl id='dest_publishers'
                            ondblclick="remove_item_from_select_box(document.getElementById('dest_publishers'));"
                            MULTIPLE SIZE=6 style='width:180px;'></select>
                </div>


                <?php
            }
            echo '</div>';
//-------------------------BRANDS-----------------------------------------------  -->
            //BRANDS
            echo '<div class="myformtable1" style="overflow:hidden;width:40%;"  data-module="הזן BRANDS:">';
            $sql = "SELECT brandName, brandID FROM brands ORDER BY brandID";
            if($rows = $db->queryArray($sql)) {
                ?>
                <div class="myformtd" style="width:18%;height: auto;">
                    <?PHP
                    form_list13('brand_select', $rows, $selected = -1, $str = "")
                    ?>
                </div>
                <?PHP

            }
             echo '</div>';
//-------------------------------------------USERS-----------------------------------------------------------------------------------
            $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
            $rows = $db->queryArray($sql);
            echo '<tr>
<td   class="myformtd">
<div style="overflow:hidden;" data-module="הזנת  חברי פורום:">
<table class="myformtable1" >
<tr>';
            //   form_label("הזנת  חברי פורום:", TRUE);
            echo '<td class="myformtd" style="width:10px;overflow:hidden;">';
            form_list111("src_users", $rows, array_item($formdata, "src_users"), "multiple size=6 id='src_users' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));\"");
            echo '</td>';
//-------------------------------------------
            if (isset($formdata['dest_users']) && $formdata['dest_users'] && $formdata['dest_users'] != 'none' && count($formdata['dest_users']) > 0) {
                $dest_users = isset($formdata['dest_users']) ? $formdata['dest_users'] : '';
                    if(isset($formdata['dest_users'])) {
                        foreach ($dest_users as $key => $val) {
                            if (!$result["dest_users"])
                                $result["dest_users"] = $key;
                            else
                                $result["dest_users"] .= "," . $key;
                        }
                        $staff = isset($result["dest_users"]) ? $result["dest_users"] : '';
                        $formdata['dest_users1'] = explode(',', $staff);
                        $sql2 = "select userID, full_name from users where userID in ($staff)";
                        if ($rows = $db->queryObjectArray($sql2))
                            foreach ($rows as $row) {
                                $name[$row->userID] = $row->full_name;
                            }
                    }
                $i = 0;
                ?>
                <td class="myformtd" style='width:10px;overflow:hidden;'>
                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                           OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));"/>
                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                   OnClick="remove_item_from_select_box(document.getElementById('dest_users'));"/>
                </td>
                <?php
                form_list11("dest_users", $name, array_item($formdata, "dest_users1"), "multiple size=6 id='dest_users' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_users'));\"");
            } elseif (isset($formdata['src_users']) && isset($formdata['src_users'][0]) && $formdata['src_users'][0] != 0 && !$formdata['dest_users']) {
                $dest_users = $formdata['src_users'];
                for ($i = 0; $i < count($dest_users); $i++) {
                    if ($i == 0) {
                        $userNames = $dest_users[$i];
                    } else {
                        $userNames .= "," . $dest_users[$i];
                    }
                }
                $name = explode(",", $userNames);
                ?>
                <td class="myformtd" style='width:10px;overflow:hidden;'>
                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                           OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));"/>
                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                   OnClick="remove_item_from_select_box(document.getElementById('dest_users'));"/>
                </td>
                <?php
                form_list11("src_users", $name, array_item($formdata, "src_users"), "multiple size=6 id='src_users' ondblclick=\"add_item_to_select_box(document.getElementById('src_users'), document.getElementById('src_users'));\"");
            } else {
                ?>
                <td class="myformtd" style='width:10px;overflow:hidden;'>
                    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                           OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));"/>
                    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                   OnClick="remove_item_from_select_box(document.getElementById('dest_users'));"/>
                </td>
                <td class="myformtd">
                    <select class="mycontrol" name='arr_dest_users[]' dir=rtl id='dest_users' MULTIPLE SIZE=6
                            style='width:180px;'
                            ondblclick="remove_item_from_select_box(document.getElementById('dest_users'));"></select>
                </td>
                <?php
            }
            if ($level) {
                form_url("print_users.php", "ערוך משתמשים", 1);
            }
            echo ' 
                    </tr>
                    </table></div>
                    </td>
                    </tr>';
            if (array_item($formdata, 'dest_users') && $formdata['dest_users'] != 'none'){
            $i = 0;
            echo '<tr>';
            echo '<td   class="myformtd">';
            echo '<div id="my_users_panel" class="my_users_panel">';
            echo '<h3 class="my_title_users" style=" height:15px"></h3>';
            echo '<div id="content_users" class="content_users">';
            echo '<table class="myformtable1" id="my_table" style="width:70%;overflow:hidden" align="right">';
            /***************************************************/
            foreach ($formdata['dest_users'] as $key => $val){
            /**************************************************/
            $tr_id = "my_tr$i";
            $member_date = "member_date$i";
            if ($formdata["active"][$key] == 2)
                $gif_num = 1;
            else
                $gif_num = 0;
            ?>
            <tr class="my_tr" id="<?php echo $tr_id ?>">
                <td width="16" id="my_active<?php echo $key;
                echo $formdata['forum_decision']; ?>">
                    <a href="javascript:void(0)"
                       onclick="edit_active(<?php echo $key; ?>,<?php echo $formdata['forum_decision']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo $formdata["active"][$key]; ?>); return false;">
                        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php echo $gif_num; //print $formdata["active"][$key]
                        ?>.gif" width="16" height="10" alt="" border="0"/>
                    </a>
                </td>
                <td class="myformtd" id="myformtd">
                    <?php
                    form_label1("חבר פורום:");
                    form_text_a("member", $val, 20, 50, 1);
                    ?>
                    <input type="button" class="mybutton" id="my_button_<?php echo $key; ?>" value="ערוך משתמש"
                           onClick="return editUser3(<?php echo $key; ?>,<?php echo $formdata['forum_decision']; ?>,
                           <?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>);"; <?php return false; ?>/>
                    <script language="JavaScript" type="text/javascript">
//-------------------------------------------------------------------------------
                        $(document).ready(function () {
                            $("#<?php echo $member_date; ?>").datepicker($.extend({}, {
                                showOn: 'button',
                                buttonImage: '<?php echo IMAGES_DIR;?>/calendar.gif', buttonImageOnly: true,
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
//-------------------------------------------------------------------------------
                    list($year_date, $month_date, $day_date) = explode('-', $formdata[$member_date]);
                    if (strlen($day_date) == 4) {
                        $formdata[$member_date] = "$year_date-$month_date-$day_date";
                    } elseif (strlen($year_date) == 4) {
                        $formdata[$member_date] = "$day_date-$month_date-$year_date";
                    }
                    form_label1("תאריך צרוף לפורום:");
                    form_text3("$member_date", $formdata[$member_date], 10, 50, 1, $member_date);
                    echo '</td>';
                    echo '</tr>';
                    $i++;
                    }
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';//end panel
                    echo '</td>';
                    echo '</tr>';
                    }
                    ?>
                    <!-- ----------------------------------------------------------------------  -->
                    <p><input type="submit" name="submit_add_pdf" value="הוסף את ה-PDF" id="submit_add_pdf"
                              class="formbutton"/></p>
        </fieldset>
    </form>




    <div class="" id="display">
        <!-- Records will be displayed here -->
    </div>
    <?php
}//end build ajx_formMult

