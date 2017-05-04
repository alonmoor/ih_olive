<?php
function build_form(&$formdata)
{
    global $db;
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
    ?>
    <script language="javascript" src="<?php print JS_ADMIN_WWW ?>/treeview_forum.js" type="text/javascript"></script>
    <script>
        $('.bgchange_tree').css('width', '50%');
        turn_red_tree();

    </script>


    <div id="main">
        <form style="width:95%;" name="forum_org" id="forum_org" method="post" action="../admin/dynamic_10.php"
              onsubmit="prepSelObject(document.getElementById('dest_users'));prepSelObject(document.getElementById('dest_forumsType'));
prepSelObject(document.getElementById('dest_managersType'));">
            <fieldset>
                style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png)
                repeat-x">
                <legend style="color:brown;">פורומים עין השופט</legend>
                <table>
                    <?php
                    if (array_item($formdata, 'forum_decID')) {
                        $frm = new forum_dec();
                        $frm->print_forum_entry_form1($formdata['forum_decID']);
                    }
                    $dates = getdate();
                    $sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcats_a[$row->parentForumID][] = $row->forum_decID;
                        $catNames_a[$row->forum_decID] = $row->forum_decName;
                    }

                    $rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);

                    $arr_show = array();
                    $arr_show[0][0] = "ציבורי";
                    $arr_show[0][1] = "1";
                    $arr_show[1][0] = "פרטי";
                    $arr_show[1][1] = "2";
                    $arr_show[2][0] = "סודי";
                    $arr_show[2][1] = "3";

                    $selected_show = array_item($formdata, 'forum_Allowed') ? array_item($formdata, 'forum_Allowed') : $arr_show[0][1];

                    $arr = array();
                    $arr[0][0] = "לא פעיל";
                    $arr[0][1] = "1";
                    $arr[1][0] = "פעיל";
                    $arr[1][1] = "2";


                    $selected = array_item($formdata, 'forum_status') ? array_item($formdata, 'forum_status') : $arr[1][1];

                    echo '	<tr>
<td   class="myformtd" ><div style="overflow:hidden;" data-module="שם הפורום:">
<table class="myformtable1"  style="height:100px;overflow:hidden;">
<tr>
<td class="myformtd"  >';
                    if (array_item($formdata, 'forum_decID')) {

                        form_list_b("forum_decision", $rows, array_item($formdata, "forum_decision"));
                        form_empty_cell_no_td(10);
                    }
                    form_label1("שם פורום חדש:", TRUE);
                    form_text_a("newforum", array_item($formdata, "newforum"), 20, 50, 1);
                    form_empty_cell_no_td(5);

                    form_label1("קשר לפורום", TRUE);
                    form_list_find_notd("insert_forum", "insert_forum", $rows, array_item($formdata, "insert_forum"));
                    form_empty_cell_no_td(5);

                    form_label_red1("סטטוס פורום:", TRUE);
                    form_list_find_notd_no_choose2('forum_status', $arr, $selected, $str = "");
                    form_empty_cell_no_td(5);

                    /*****************************************/
                    form_label_red1("סיווג פורום:", TRUE);
                    form_list_find_notd_no_choose2('forum_allowed', $arr_show, $selected_show, "id=forum_allowed");
                    form_empty_cell_no_td(5);

                    /*****************************************/

                    if ($level) {
                        form_url2("categories1.php", "ערוך פורומים", 2);
                    }

                    echo '<tr><td class="myformtd" >';
                    form_label_red1("תאריך הקמה:", true);
                    form_text3("forum_date", array_item($formdata, "forum_date"), 15, 15, 1, 'forum_date');
                    form_empty_cell_no_td(10);

                    echo '</td></tr>';
                    echo ' 
</td>
</tr>
</table></div>
</td>
<tr>';
                    $sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
                    $rows = $db->queryObjectArray($sql);
                    $array = '';
                    foreach ($rows as $row) {
                        $subcats22[$row->parentAppointID][] = $row->appointID;
                        $catNames22[$row->appointID] = $row->appointName;
                    }

                    $rows = build_category_array($subcats22[NULL], $subcats22, $catNames22);
                    $rows1 = build_category_array($subcats22[NULL], $subcats22, $catNames22);


                    $sql = "SELECT u.* FROM users u
LEFT JOIN appoint_forum a   ON u.userID=a.userID
WHERE u.userID NOT IN(SELECT userID FROM appoint_forum)
ORDER BY u.full_name ";
                    if ($rows2 = $db->queryObjectArray($sql)) {
                        foreach ($rows2 as $row) {
                            $array[$row->userID] = $row->full_name;
                        }
                    }


                    echo '	<tr>
<td   class="myformtd" ><div style="overflow:hidden;" data-module="ממנה פורום:">
<table class="myformtable1" style="height:100px;  overflow:hidden;">
<tr>
<td class="myformtd"  >';
                    form_label1("גוף ממנה", TRUE);
                    form_list_b("appoint_forum", $rows, array_item($formdata, "appoint_forum"));
                    form_empty_cell_no_td(10);


                    form_label1("גוף ממנה חדש", TRUE);
                    // form_list_b ("new_appoint",$array, array_item($formdata, "new_appoint"));
                    form_list_idx_one("new_appoint", $array, array_item($formdata, "new_appoint"));
                    form_empty_cell_no_td(10);


                    if ($array && $array != '') {
                        form_label1("קשר לממנה:", TRUE);
                        form_list_b("insert_appoint", $rows1, array_item($formdata, "insert_appoint"));
                    }


                    if ($level) {
                        form_empty_cell_no_td(10);
                        form_url2("appoint_edit.php", "ערוך ממני פורום", 2);
                    }
                    if (isset($formdata['appoint_date']) && $formdata['appoint_date'])
                        $formdata['appoint_date1'] = $formdata['appoint_date'];


                    echo '<tr><td class="myformtd" >';
                    form_label_red1("תאריך ממנה", TRUE);
                    form_text3("appoint_date1", array_item($formdata, "appoint_date1"), 15, 15, 1, 'appoint_date1');
                    form_empty_cell_no_td(10);


                    echo '</td></tr>';


                    echo ' 
</td>
</tr>
</table></div>
</td>
<tr>';
                    /*******************************************************************************************************/

                    $sql = "SELECT managerName,managerID,parentManagerID FROM managers ORDER BY managerName";
                    $rows = $db->queryObjectArray($sql);


                    foreach ($rows as $row) {
                        $subcats6[$row->parentManagerID][] = $row->managerID;
                        $catNames6[$row->managerID] = $row->managerName;
                    }
                    // build hierarchical list
                    $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
                    $rows1 = build_category_array($subcats6[NULL], $subcats6, $catNames6);

                    $sql = "SELECT u.* FROM users u
LEFT JOIN managers m ON u.userID=m.userID
WHERE u.userID NOT IN(SELECT userID FROM managers)
ORDER BY u.full_name ";
                    if ($rows2 = $db->queryObjectArray($sql)) {

                        foreach ($rows2 as $row) {
                            $array[$row->userID] = $row->full_name;
                        }
                    }
                    echo '	<tr>
<td   class="myformtd" >
<div style="overflow:hidden;" data-module="מנהל פורום:">
<table class="myformtable1" style="height:100px;  overflow:hidden;">
<tr>
<td class="myformtd"  >';


                    form_label1("מנהל פורום:", TRUE);
                    form_list_b("manager_forum", $rows, array_item($formdata, "manager_forum"));
                    form_empty_cell_no_td(10);

                    form_label1("שם מנהל חדש", TRUE);
                    form_list_idx_one("new_manager", $array, array_item($formdata, "new_manager"));
                    form_empty_cell_no_td(10);


                    form_label1("קשר למנהל:", TRUE);
                    form_list_b("insert_manager", $rows1, array_item($formdata, "insert_manager"));
                    if ($level) {
                        form_empty_cell_no_td(10);
                        form_url2("manager.php", "ערוך מנהלים", 2);
                    }
                    echo '<tr><td class="myformtd">';
                    form_label_red1("תאריך מינוי מנהל", TRUE);
                    form_text3("manager_date", array_item($formdata, "manager_date"), 15, 15, 1, 'manager_date');
                    form_empty_cell_no_td(10);


                    echo '</td></tr>';


                    echo ' 
</td>
</tr>
</table></div>
</td>
<tr>';
                    /*************************************FORUMF_TYPE*****************************************************************/
                    $sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcatsftype[$row->parentCatID][] = $row->catID;
                        $catNamesftype[$row->catID] = $row->catName;
                    }

                    $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
                    $rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);

                    echo '<tr>
<td   class="myformtd" >
<div style="overflow:hidden;" data-module="הזנת  סוגי הפורום:">
<table class="myformtable1" style="height:100px;  overflow:hidden;"><tr>';

                    echo '<td class="myformtd">';
                    form_list111("src_forumsType", $rows, array_item($formdata, "src_forumsType"), "multiple size=6 id='src_forumsType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");
                    echo '</td>';
                    if (isset($formdata['dest_forumsType']) && $formdata['dest_forumsType'] && $formdata['dest_forumsType'] != 'none') {
                        $dest_forumsType = $formdata['dest_forumsType'];
                        foreach ($dest_forumsType as $key => $val) {
                            if (!is_numeric($val)) {
                                $val = $db->sql_string($val);
                                $staff_test[] = $val;
                            } elseif (is_numeric($val)) {
                                $staff_testb[] = $val;
                            }
                        }
                        if (is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                            $staff = implode(',', $staff_test);

                            $sql2 = "select catID, catName from categories1 where catName in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {
                                    $name_frmType[$row->catID] = $row->catName;
                                }
                        } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                            $staff = implode(',', $staff_test);
                            $sql2 = "select catID, catName from categories1 where catName in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {
                                    $name_frmType[$row->catID] = $row->catName;
                                }
                            $staffb = implode(',', $staff_testb);

                            $sql2 = "select catID, catName from categories1 where catID in ($staffb)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {
                                    $name_b[$row->catID] = $row->catName;
                                }
                            $name_frmType = array_merge($name, $name_b);
                            unset($staff_testb);
                        } else {
                            $staff = implode(',', $formdata['dest_forumsType']);

                            $sql2 = "select catID, catName from categories1 where catID in ($staff)  ORDER BY FIND_IN_SET(catID, '$staff')";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {
                                    $name_frmType[$row->catID] = $row->catName;
//$name[]=$row->catName;
                                }
                        }
                        ?>
                        <td class="myformtd">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>
                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>
                        </td>
                        <?php
                        form_list11("dest_forumsType", $name_frmType, array_item($formdata, "dest_forumsType"), "multiple size=6 id='dest_forumsType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forumsType'));\"");
                    } elseif (isset($formdata['src_forumsType']) && $formdata['src_forumsType'] && $formdata['src_forumsType'][0] != 0 && !$formdata['dest_forumsType']) {
                        $dest_types = $formdata['src_forumsType'];
                        for ($i = 0; $i < count($dest_types); $i++) {
                            if ($i == 0) {
                                $userNames = $dest_types[$i];
                            } else {
                                $userNames .= "," . $dest_types[$i];
                            }
                        }
                        $name_frmType = explode(",", $userNames);

                        $sql2 = "select catID,catName from categories1 where catID in ($userNames)";
                        if ($rows = $db->queryObjectArray($sql2))
                            foreach ($rows as $row) {
                                $name_frmType[$row->catID] = $row->catName;
                            }
                        ?>
                        <td class="myformtd">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>
                        </td>
                        <?php
                        form_list11("src_forumsType", $name_frmType, array_item($formdata, "src_forumsType"), "multiple size=6 id='src_forumsType' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");
                    } else {
                        ?>
                        <td class="myformtd">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>
                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>
                        </td>
                        <td class="myformtd">
                            <select class="mycontrol" name='arr_dest_forumsType[]' dir=rtl id='dest_forumsType'
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"
                                    MULTIPLE SIZE=6 style='width:180px;'></select>
                        </td>
                        <?php
                    }
                    form_label("סוג פורום חדש", TRUE);
                    form_textarea("new_forumType", array_item($formdata, "new_forumType"), 14, 5, 1);
                    form_label("קשר לסוג פורום", TRUE);

                    if (array_item($formdata, "insert_forumType")) {
                        form_list1idx("insert_forumType", $rows2, array_item($formdata, "insert_forumType"), "multiple size=6");
                    } else
                        form_list1("insert_forumType", $rows2, array_item($formdata, "insert_forumType"), "multiple size=6");
                    echo '</tr>';
                    if ($level) {
                        echo '<tr><td >';
                        form_url2("categories1.php", "ערוך סוגי פורומים", 1);
                        echo "</td></tr>";
                    }
                    echo '</table></div></td></tr>';

                    /*************************************MANAGER_TYPE*****************************************************************/


                    $sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcatsmtype[$row->parentManagerTypeID][] = $row->managerTypeID;
                        $catNamesmtype[$row->managerTypeID] = $row->managerTypeName;
                    }

                    $rows = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);
                    $rows2 = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);

                    echo '	<tr>
<td   class="myformtd" ><div style="overflow:hidden;" data-module="הזנת  סוגי המנהלים:">
<table class="myformtable1" style="height:100px;  overflow:hidden;"><tr>';


                    echo '<td class="myformtd">';
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

                            $sql2 = "select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff) ORDER BY FIND_IN_SET(managerTypeID, '$staff') ";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name_managerType[$row->managerTypeID] = $row->managerTypeName;


                                }

                        }
                        ?>

                        <td class="myformtd">

                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));"/>


                        </td>


                        <?php


                        form_list11("dest_managersType", $name_managerType, array_item($formdata, "dest_managersType"), "multiple size=6 id='dest_managersType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_managersType'));\"");


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

                        <td class="myformtd">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));"/>
                        </td>


                        <?php


                        form_list11("src_managersType", $name_managerType, array_item($formdata, "src_managersType"), "multiple size=6 id='src_managersType' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));\"");


                    } else {


                        ?>

                        <td class="myformtd">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));"/>
                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));"/>
                        </td>


                        <td class="myformtd">
                            <select class="mycontrol" name='arr_dest_managersType[]' dir=rtl id='dest_managersType'
                                    MULTIPLE SIZE=6
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_managersType'));"
                                    style='width:180px;'></select>
                        </td>

                        <?php


                    }
                    form_label("סוג מנהל חדש", TRUE);
                    form_textarea("new_managerType", array_item($formdata, "new_managerType"), 14, 5, 1);
                    form_label("קשר לסוג למנהל", TRUE);
                    if (array_item($formdata, "insert_managerType"))
                        form_list1idx("insert_managerType", $rows2, array_item($formdata, "insert_managerType"), "multiple size=6");
                    else
                        form_list1("insert_managerType", $rows2, array_item($formdata, "insert_managerType"), "multiple size=6");


                    echo '</tr>';

                    if ($level) {
                        echo '<tr><td >';
                        form_url2("manager_category.php", "ערוך סוגי מנהלים", 1);
                        echo "</td></tr>";


                    }
                    echo '</table></div></td></tr>';


                    /******************************************************************************************************/

                    /***************************************************USERS***************************************************************************/


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


                    /****************************************************************************************************/
                    if (isset($formdata['dest_users']) && $formdata['dest_users'] && $formdata['dest_users'] != 'none' && count($formdata['dest_users']) > 0) {
                        $dest_users = $formdata['dest_users'];


                        foreach ($dest_users as $key => $val) {

                            if (!$result["dest_users"])
                                $result["dest_users"] = $key;
                            else
                                $result["dest_users"] .= "," . $key;

                        }


                        $staff = $result["dest_users"];
                        $formdata['dest_users1'] = explode(',', $staff);
                        $sql2 = "select userID, full_name from users where userID in ($staff)";
                        if ($rows = $db->queryObjectArray($sql2))
                            foreach ($rows as $row) {

                                $name[$row->userID] = $row->full_name;

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

                        /**********************************************************************************************/
                    } elseif (isset($formdata['src_users']) && isset($formdata['src_users'][0]) && $formdata['src_users'] && $formdata['src_users'][0] != 0 && !$formdata['dest_users']) {

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


                    /********************************************************************************************/
                    /*********************************************************************************************************/
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
                                   onClick="return editUser3(<?php echo $key; ?>,<?php echo $formdata['forum_decision']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>);"
                                   ; return false;/>

                            <?php


                            /***************************************************************************************/
                            ?>
                            <script language="JavaScript" type="text/javascript">

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

                            /*****************************************************************************************/

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
                            //else{
                            //
                            //
                            // echo '
                            //       <tr>
                            //       <td   class="myformtd">
                            //       <div id="my_users_panel" class="my_users_panel">
                            //       <div id="content_users" class="content_users">
                            //       <table   id="my_table" style="width:70%;overflow:hidden" >';
                            //
                            //
                            // echo  '</table>
                            //        </div id="content_users" class="content_users">
                            //        </div>
                            //        </td>
                            //        </tr> ';
                            //
                            //}

                            /*********************************************************************************************************/


                            /***********************************************************************************************************/
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
                                || ($formdata && !(array_item($formdata, 'dest_users')))
                            ) {


                                echo '<tr>
<td   class="myformtd"><div data-module="הזנת תאריכים לכמה משתמשים:">
<table class="myformtable1" id="my_date_table" style="width:50%"><tr>';


                                echo '<td class="myformtd">';
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
                            if ($formdata && (array_item($formdata, 'dest_users'))) {
                                echo '<tr>
<td   class="myformtd" ><div data-module="ההזנת תאריכים למשתמשים חדשים:">
<table class="myformtable1" id="my_date_table2" style="width:50%" style="display:none">
<tr>
<td class="myformtd"  >';

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

                            /****************************************************DEALING WITH TREE_VIEW*****************************************************/

                            /**************************************************************************************************************************/
                            if (array_item($formdata, "forum_decID")) {


                                $sql = "SELECT d.decName,d.decID,d.parentDecID 
FROM decisions d, rel_forum_dec r
WHERE d.decID = r.decID
AND r.forum_decID = " . $db->sql_string($formdata['forum_decision']) .
                                    " ORDER BY  d.decName ";


                                if ($rows = $db->queryObjectArray($sql)) {

// echo '<div id="tree_content_target">';


                                    echo '<tr>';
                                    echo '<td   class="myformtd">';
                                    echo '<table class="myformtable1"  id="tree_content_target">';


                                    echo '<tr>';
                                    echo '<td class="myformtd">';

                                    echo '<h5 class="my_title_trees" style=" height:15px"></h5>';
                                    echo '<div id="tree_content" class="tree_content" >';

                                    form_label1("ערוך החלטות", true);
                                    display_tree($rows, $formdata);

                                    $rootAttributes = array("decID" => "11");

                                    $treeID = "treev1";
                                    $tv = DBTreeView::createTreeView(
                                        $rootAttributes,
                                        TREEVIEW_LIB_PATH,
                                        $treeID);
                                    $string = "כול ההחלטות";
                                    $tv->setRootHTMLText($string);

                                    $tv->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");
                                    $tv->printTreeViewScript();


                                    echo '</div>
</td>
</tr>';


//echo '<div>';
                                    echo '<tr>';
                                    echo '<td   class="myformtd">';
                                    echo '<h5 class="my_title_trees2" style=" height:15px"></h5>';
                                    echo '<div id="tree_content2" class="tree_content" >';

                                    form_label1("הראה נתונים", true);
                                    display_tree($rows, $formdata);

                                    $rootAttributes = array("decID" => "11", "flag_print" => "1");
                                    $treeID = "treev2";
                                    $tv1 = DBTreeView::createTreeView(
                                        $rootAttributes,
                                        TREEVIEW_LIB_PATH,
                                        $treeID);
                                    $str = "כול ההחלטות";
                                    $tv1->setRootHTMLText($str);
                                    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR . "/star.gif");

                                    $tv1->printTreeViewScript();


                                    echo '</div>
</td>
</tr>

</table></td></tr>';

                                }
                            }


                            /**************************************************************************************************************************************/
                            //elseif(!(ae_detect_ie())){//FOR form_dem_9.php
                            //
                            //
                            //		echo '<div id="tree_content_target">'; //for pushing the data
                            //	 	 echo '<table style="width:80%;">';
                            //		echo '<tr>';
                            //        echo '<td>';
                            //         echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
                            //         echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';
                            //     if($level){
                            //        echo '<table class="myformtable1"   style="width:50%;"   id="tree_content1" data-module="ערוך החלטות"><tr>';
                            //     }elseif(!($level)){
                            //    	echo '<table class="myformtable1"   style="width:50%;" id="tree_content1" data-module="הצג החלטות בדף"><tr>';
                            //     }
                            //        echo '<td>';
                            //        echo '<div id="tree_content_ajx" class="tree_content" >';
                            //
                            //
                            //
                            //     echo '<table style="width:50%;">';
                            //	echo '</table>';
                            //
                            //
                            //
                            // 	  echo '</div>
                            //            </td></tr>
                            // 	        </table>
                            // 	        </td>
                            //            </tr>';
                            //
                            //
                            //
                            //
                            // 	  echo '<tr>';
                            //        echo '<td>';
                            //
                            //        echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
                            //        echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';
                            //        echo '<table style="width:50%;"  class="myformtable1" id="tree_content2" data-module="הצג החלטות בחלון"><tr>';
                            //        echo '<td>';
                            //        echo '<div id="tree_content_ajx2" class="tree_content" >';
                            //
                            //
                            //    echo '<table style="width:50%;">';
                            //	echo '</table>';
                            //
                            //
                            //
                            //
                            //
                            //echo   '   </div>
                            //            </td></tr>
                            // 	        </table>
                            // 	        </td>
                            //            </tr>';
                            //   echo '</table>';
                            //
                            //echo    '</div>';
                            //
                            //
                            //}else{//for ie
                            //
                            // $sql = "SELECT decName,decID,parentDecID
                            //				FROM decisions
                            //				WHERE decID = '1962'
                            //				ORDER BY decName ";
                            //
                            //
                            // 	$rows = $db->queryObjectArray($sql);
                            //
                            //
                            //
                            //
                            //		echo '<div id="tree_content_target">'; //for pushing the data
                            //
                            //		echo '<tr>';
                            //        echo '<td>';
                            //         echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
                            //         echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';
                            //     if($level){
                            //        echo '<table class="myformtable1"   style="width:50%;"   id="tree_content1" data-module="ערוך החלטות"><tr>';
                            //     }elseif(!($level)){
                            //    	echo '<table class="myformtable1"   style="width:50%;" id="tree_content1" data-module="הצג החלטו	ת בדף"><tr>';
                            //     }
                            //        echo '<td>';
                            //        echo '<div id="tree_content_ajx" class="tree_content" >';
                            //
                            //
                            //
                            // treedisplayDown($rows,$formdata);
                            //    $rootAttributes = array("decID"=>"11" );
                            //    $treeID = "treev1";
                            //     $tv = DBTreeView::createTreeView(
                            //		$rootAttributes,
                            //		TREEVIEW_LIB_PATH,
                            //		$treeID);
                            //       $str="ערוך החלטות"	;
                            //       $tv->setRootHTMLText($str);
                            //  $tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
                            //   $tv->printTreeViewScript();
                            //
                            //
                            //
                            // 	  echo '</div>
                            //            </td></tr>
                            // 	        </table>
                            // 	        </td>
                            //            </tr>';
                            //
                            //
                            //
                            // 	  echo '<tr>';
                            //        echo '<td>';
                            //
                            //        echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
                            //        echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';
                            //        echo '<table style="width:50%;"  class="myformtable1" id="tree_content2" data-module="הצג החלטות בחלון"><tr>';
                            //        echo '<td>';
                            //        echo '<div id="tree_content_ajx2" class="tree_content" >';
                            //
                            //
                            //
                            // treedisplayDown($rows,$formdata);
                            //   $rootAttributes = array("decID"=>"11","flag_print"=>"1");
                            //    $treeID = "treev2";
                            //     $tv1 = DBTreeView::createTreeView(
                            //		$rootAttributes,
                            //		TREEVIEW_LIB_PATH,
                            //		$treeID);
                            //      $str="צפייה בהחלטות"	;
                            //     $tv1->setRootHTMLText($str);
                            //    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
                            //    $tv1->printTreeViewScript();
                            //
                            //
                            //
                            //
                            //echo   '   </div>
                            //            </td></tr>
                            // 	        </table>
                            // 	        </td>
                            //            </tr>';
                            //
                            //
                            //echo    '</div>';
                            //
                            //}
                            //
                            /***************************************************************************************************************************/


                            /*********************************BUTTON***********************************************************/
                            if ($level) {
                                echo '<tr><td class="myformtd">';


//$name, $txt, $type="button", $free_text=""
                                form_button_no_td2("submitbutton", "שמור", "Submit", "OnClick=\"
prepSelObject(document.getElementById('dest_forumsType'));
prepSelObject(document.getElementById('dest_managersType'));
prepSelObject(document.getElementById('dest_users'));
\";");


                                if (array_item($formdata, 'dynamic_6')) {
                                    $x = $formdata['index'];
                                    $formdata["forum_decID"] = $formdata["forum_decID"][$x];
                                    $tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
                                    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
                                    form_hidden("forum_decID", $formdata["forum_decID"]);
                                    form_hidden("insertID", $formdata["insertID"]);
                                } else
                                    $tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
                                $formdata["forum_decID"] = isset($formdata["forum_decID"]) ? $formdata["forum_decID"] : '';
                                $formdata["insertID"] = isset($formdata["insertID"]) ? $formdata["insertID"] : '';
                                form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
                                form_hidden("forum_decID", $formdata["forum_decID"]);
                                form_hidden("insertID", $formdata["insertID"]);


                                if (array_item($formdata, "forum_decID") && !$formdata['fail']) {


                                    form_button_no_td2("btnLink1", "קשר לפורום");
                                    form_hidden("forum_decID", $formdata["forum_decID"]);


// form_button1("btnDelete", "מחק פורום", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["forum_decID"]."').value='delete'\";");
                                    form_empty_cell_no_td(20);
                                    form_button_no_td2("btnDelete", "מחק פורום", "Submit", "OnClick='return shalom(\"" . $formdata[forum_decID] . "\")'");
                                    ?>


                                    <?php


                                } else {

                                    form_empty_cell_no_td(10);
                                    $formdata["btnClear"] = isset($formdata["btnClear"]) ? $formdata["btnClear"] : '';

                                    form_button_no_td("btnClear", "הכנס נתונים לפורום/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\" ");


                                }
                                $formdata["fail"] = isset($formdata["fail"]) ? $formdata["fail"] : '';
                                if ($formdata['fail'])
                                    unset($formdata['fail']);


                                echo '</td></tr>';

                            }
                            /************************************************************************************************/
                            ?>
                </table>

                </fielset>
        </form>
        <!-- ============================================================================================================ -->
        <?PHP $formdata['forum_decision'] = isset($formdata['forum_decision']) ? $formdata['forum_decision'] : ''; ?>

        <div id="page_useredit" class="page_useredit" style="display:none">

            <h3 class="my_title" style=" height:15px"></h3>
            <h3><?php __('edit_user'); ?></h3>

            <div class="content">


                <form onSubmit="return saveUser3(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>);" name="edituser"
                      id="edituser">
                    <input type="hidden" name="Request_Tracking_Number_1" id="Request_Tracking_Number_1" value=""/>
                    <input type="hidden" name="Request_Tracking_Number1" id="Request_Tracking_Number1" value=""/>
                    <input type="hidden" name="Request_Tracking_Number2" id="Request_Tracking_Number2" value=""/>
                    <input type="hidden" name="id" value=""/>
                    <input type="hidden" name="forum_decID" id="forum_decID"
                           value="<?php echo $formdata['forum_decision']; ?>"/>


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
                            <option value="0">0</option>
                            <option value="1" selected>1</option>
                        </SELECT>
                        &nbsp;


                        <span class="h"><?php __('due'); ?> </span>
                        <input name="duedate3" id="duedate3" value="" class="in100"
                               title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off"/>
                    </div>


                    <div class="form-row">
                        <span class="h"><?php __('level'); ?></span>
                        <SELECT name="level" id="level" class="mycontrol">
                            <option value="1"><?php __(forum_user) ?></option>
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

                    <div class="form-row"><span class="h"><?php __('user'); ?></span><br> <input type="text" name="user"
                                                                                                 id="user" value=""
                                                                                                 class="in200"
                                                                                                 maxlength="50"/></div>

                    <div class="form-row"><span class="h"><?php __('upass'); ?></span><br> <input type="text"
                                                                                                  name="upass"
                                                                                                  id="upass" value=""
                                                                                                  class="in200"
                                                                                                  maxlength="50"/></div>
                    <div class="form-row"><span class="h"><?php __('email'); ?></span><br> <input type="text"
                                                                                                  name="email"
                                                                                                  id="email" value=""
                                                                                                  class="in200"
                                                                                                  maxlength="50"/></div>
                    <div class="form-row"><span class="h"><?php __('phone'); ?></span><br> <input type="text"
                                                                                                  name="phone"
                                                                                                  id="phone" value=""
                                                                                                  class="in200"
                                                                                                  maxlength="50"/></div>
                    <div class="form-row"><span class="h"><?php __('note'); ?></span><br> <textarea name="note"
                                                                                                    id="note"
                                                                                                    class="in500"></textarea>
                    </div>
                    <div class="form-row"><span class="h"><?php __('tags'); ?></span><br> <input type="text" name="tags"
                                                                                                 id="edittags1" value=""
                                                                                                 class="in500"
                                                                                                 maxlength="250"/></div>
                    <div class="form-row">

                        <input type="submit" id="edit_usr" value="<?php __('save'); ?>" onClick="this.blur()"/>
                        <input type="button" value="<?php __('cancel'); ?>"
                               onClick="canceluserEdit3();this.blur();return false"/>


                    </div>
                </form>

            </div> <!--  end div content -->

        </div> <!--  end of page_user_edit -->
    </div><!-- end div main -->
    <?php
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
/****************************************************************************************************/
$formdata['manager_forum'] = isset ($formdata['manager_forum']) ? $formdata['manager_forum'] : '';
$formdata['managerName'] = isset ($formdata['managerName']) ? $formdata['managerName'] : '';
$url_mgr = "../admin/find3.php?managerID=" . $formdata['manager_forum'];
$link_frm_mgr = "<span><a onClick=openmypage3('" . $url_mgr . "');   class=href_modal1  href='javascript:void(0)' ><b style='color:brown;font-size:1.4em;'>'" . $formdata['managerName'] . "'<b></a></span>";


echo '<table style="width:300px;height:25px;overflow:hidden;">
<tr><td><p  data-module="מנהל פורום:' . $link_frm_mgr . '"  id="my_manager_td">			      
</p></td></tr>
</table>';

/****************************************************************************************************/
?>


<div id="loading">
<img src="../images/loading4.gif" border="0"/>
</div>


<?php
if (isset($formdata['save_new']) && !($formdata['save_new'] == 1)){
?>

<script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/edit_forumdec.js" charset="utf-8"
type="text/javascript"></script>
‬
<script language="javascript" src="<?php print JS_ADMIN_WWW ?>/treeview_forum.js" charset="utf-8"
type="text/javascript"></script>


<h4 class="my_main_fieldset<?php echo $formdata['forum_decision'] ?>" style="height:15px;cursor:pointer;"></h4>
<form name="forum" id="forum" method="post" action="../admin/dynamic_10.php">

<?php
}else{
?>
<script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/edit_forumdec.js"
type="text/javascript"></script>
‬
<script language="javascript" src="<?php print JS_ADMIN_WWW ?>/treeview_forum_dem_9.js"
type="text/javascript"></script>
<form style="width:95%;" name="forum" id="forum" method="post" action="../admin/dynamic_12.php">
<?php
}
?>
<fieldset id="main_fieldset<?php echo $formdata['forum_decision'] ?>"
style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden"
;>
<legend style="color:brown;overflow:hidden;">פורומים עין השופט</legend>
<input type=hidden name="forum_decID" id="forum_decID"
value="<?php echo $formdata['forum_decision'] ?>"/>

<div id="my_error_message" name="my_error_message"></div>


<div id="forum_decision_tree" name="forum_decision_tree"></div>

<?php if (ae_detect_ie()){ ?>
<table style="margin-right:25px;overflow:hidden;width:95%;">
<?php }else{ ?>
<table style="margin-right:25px;overflow:hidden; width:95%;">
<?php
}


if (array_item($formdata, 'forum_decID')) {
$frm = new forum_dec();
$frm->print_forum_entry_form_b($formdata['forum_decID']);
}
global $db;


$dates = getdate();


$sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
$rows = $db->queryObjectArray($sql);

foreach ($rows as $row) {
$subcats_a[$row->parentForumID][] = $row->forum_decID;
$catNames_a[$row->forum_decID] = $row->forum_decName;


}

$rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);

$arr = array();
$arr[0][0] = "לא פעיל";
$arr[0][1] = "1";
$arr[1][0] = "פעיל";
$arr[1][1] = "2";
$selected = array_item($formdata, 'forum_status') ? array_item($formdata, 'forum_status') : $arr[1][1];


$arr_show = array();
$arr_show[0][0] = "ציבורי";
$arr_show[0][1] = "1";
$arr_show[1][0] = "פרטי";
$arr_show[1][1] = "2";
$arr_show[2][0] = "סודי";
$arr_show[2][1] = "3";


$selected_show = array_item($formdata, 'forum_allowed') ? array_item($formdata, 'forum_allowed') : $arr_show[0][1];

if ($selected_show == 'public') $selected_show = 1;
elseif ($selected_show == 'private') $selected_show = 2;
elseif ($selected_show == 'top_secret') $selected_show = 3;
echo '<tr>
<td> 
<div style="overflow:hidden;" data-module="שם הפורום:">
<table class="myformtable1" style="height:100px;width:98%;overflow:hidden;">';

echo '<tr><td colspan="4" style="overflow:hidden;">';

form_label_red1("שם הפורום:", TRUE);
form_list_find_notd("forum_decision", "forum_decision_link", $rows, array_item($formdata, "forum_decision"));
form_empty_cell_no_td(5);


form_label_red1("שם פורום חדש:", TRUE);
form_text_a("newforum:", array_item($formdata, "newforum"), 20, 50, 1, "newforum");
form_empty_cell_no_td(5);


form_label_red1("קשר לפורום:", TRUE);
form_list_find_notd("insert_forum", "insert_forum", $rows, array_item($formdata, "insert_forum"));
//form_empty_cell_no_td(10);

echo '</td>';

if ($level) {
form_url_noformtd("categories1.php", "ערוך פורומים", 1);
}
ECHO '</tr>';


echo '<tr><td>';

form_label_red1("תאריך הקמה:", true);
form_text_a("forum_date", array_item($formdata, "forum_date"), 10, 10, 1, 'forum_date');
form_empty_cell_no_td(10);
form_label_red1("סטטוס פורום:", TRUE);
form_list_find_notd_no_choose2('forum_status', $arr, $selected, $str = "");

form_empty_cell_no_td(10);
form_label_red1("סיווג פורום:", TRUE);

form_list_find_notd_no_choose2('forum_allowed', $arr_show, $selected_show, "id=forum_allowed");
echo '</td></tr>';


echo '</table></div></td></tr>';
/****************************************************************************************************/


$sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
$rows = $db->queryObjectArray($sql);

foreach ($rows as $row) {
$subcats22[$row->parentAppointID][] = $row->appointID;
$catNames22[$row->appointID] = $row->appointName;
}


$rows = build_category_array($subcats22[NULL], $subcats22, $catNames22);
$rows1 = build_category_array($subcats22[NULL], $subcats22, $catNames22);

$sql = "SELECT u.* FROM users u
LEFT JOIN appoint_forum a   ON u.userID=a.userID
WHERE u.userID NOT IN(SELECT userID FROM appoint_forum)
ORDER BY u.full_name ";
if ($rows2 = $db->queryObjectArray($sql)) {
foreach ($rows2 as $row) {
$array[$row->userID] = $row->full_name;
}
}


echo '<tr><td>
<div style="overflow:hidden;" data-module="ממנה פורום:">
<table class="myformtable1" style="height:100px;width:98%;">';

echo '<tr><td>';

form_label1("ממנה פורום:", TRUE);
form_list_b("appoint_forum", $rows, array_item($formdata, "appoint_forum"), "id=my_appoint");
form_empty_cell_no_td(5);

form_label1("גוף ממנה חדש:", TRUE);
// form_list_b ("new_appoint",$rows2, array_item($formdata, "new_appoint"),"id=my_newAppoint");
form_list_idx_one("new_appoint", $array, array_item($formdata, "new_appoint"), "id=my_newAppoint");
form_empty_cell_no_td(5);

form_label1("קשר לממנה:", TRUE);
form_list_b("insert_appoint", $rows1, array_item($formdata, "insert_appoint"), "id=insert_appoint");
form_empty_cell_no_td(8);

echo '</td>';
if ($level) {
form_url_noformtd("appoint_edit.php", "ערוך ממני פורום", 1);
}
echo '</tr>';

if (isset($formdata['appoint_date']) && $formdata['appoint_date'])
$formdata['appoint_date1'] = $formdata['appoint_date'];
//form_empty_cell_noformtd(5);


echo '<tr><td>';
form_label_red1("תאריך ממנה:", TRUE);
form_text3("appoint_date1", array_item($formdata, "appoint_date1"), 20, 50, 1, 'appoint_date1');
form_empty_cell_no_td(10);


echo '</td></tr>';


echo '</table></div></td></tr>';

/**********************************************************************************************/


$sql = "SELECT managerName,managerID,parentManagerID FROM managers ORDER BY managerName";
$rows = $db->queryObjectArray($sql);


foreach ($rows as $row) {
$subcats6[$row->parentManagerID][] = $row->managerID;
$catNames6[$row->managerID] = $row->managerName;
}

$rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
$rows1 = build_category_array($subcats6[NULL], $subcats6, $catNames6);


$sql = "SELECT u.* FROM users u
LEFT JOIN managers m ON u.userID=m.userID
WHERE u.userID NOT IN(SELECT userID FROM managers)
ORDER BY u.full_name ";
if ($rows2 = $db->queryObjectArray($sql)) {

foreach ($rows2 as $row) {
$array[$row->userID] = $row->full_name;
}
}


/**********************************************************************************************************/
$managerName = $formdata['managerName'] ? $formdata['managerName'] : '';
$manager_forum = $formdata['manager_forum'] ? $formdata['manager_forum'] : '';
$url = "../admin/find3.php?managerID=$manager_forum";
$str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';


$link_frm = "<a onClick=openmypage3('" . $url . "');   class=href_modal1  href='javascript:void(0)' >
<b style='color:brown;font-size:1.4em;'>$managerName<b></a>";

// echo '<fieldset data-module="חברי הפורום:'.$link_frm.'"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  id="users_fieldset" >';

/****************************************************************************************************/


echo '<tr><td id="my_manager_td">
<div style="overflow:hidden;"  data-module="מנהל פורום:' . $link_frm . '">
<table class="myformtable1" style="height:100px;width:98%;"><tr><td>';


form_label_red1("מנהל פורום:", TRUE);
form_list_b("manager_forum", $rows, array_item($formdata, "manager_forum"), "id=my_manager");
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


/*************************************FORUMF_TYPE*****************************************************************/


$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
$rows = $db->queryObjectArray($sql);

foreach ($rows as $row) {
$subcatsftype[$row->parentCatID][] = $row->catID;
$catNamesftype[$row->catID] = $row->catName;
}

$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
$rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);


echo '<tr>
<td>
<div  style="overflow:hidden;"  data-module="הזנת  סוגי הפורום:">
<table class="myformtable1" style="overflow:hidden;width:98%;"><tr>';


echo '<td style="width:40px;">';
form_list111("src_forumsType", $rows, array_item($formdata, "src_forumsType"), "multiple size=6 id='src_forumsType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");
echo '</td>';


if (isset($formdata['dest_forumsType']) && $formdata['dest_forumsType'] && $formdata['dest_forumsType'] != 'none') {


$dest_forumsType = $formdata['dest_forumsType'];

foreach ($dest_forumsType as $key => $val) {
if (!is_numeric($val)) {
$val = $db->sql_string($val);
$staff_test[] = $val;
} elseif (is_numeric($val)) {
$staff_testb[] = $val;
}
}
if (is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
$staff = implode(',', $staff_test);

$sql2 = "select catID, catName from categories1 where catName in ($staff)";
if ($rows = $db->queryObjectArray($sql2))
foreach ($rows as $row) {

$name_frmType[$row->catID] = $row->catName;


}

} elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
$staff = implode(',', $staff_test);

$sql2 = "select catID, catName from categories1 where catName in ($staff)";
if ($rows = $db->queryObjectArray($sql2))
foreach ($rows as $row) {

$name_frmType[$row->catID] = $row->catName;


}
$staffb = implode(',', $staff_testb);

$sql2 = "select catID, catName from categories1 where catID in ($staffb)";
if ($rows = $db->queryObjectArray($sql2))
foreach ($rows as $row) {

$name_b[$row->catID] = $row->catName;
}
$name_frmType = array_merge($name, $name_b);
unset($staff_testb);
} else {
$staff = implode(',', $formdata['dest_forumsType']);

$sql2 = "select catID, catName from categories1 where catID in ($staff)";
if ($rows = $db->queryObjectArray($sql2))
foreach ($rows as $row) {

$name_frmType[$row->catID] = $row->catName;
//$name[]=$row->catName;

}
}

?>

<td style="width:40px;">

<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>

<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>


</td>


<?php


form_list_no_formtd("dest_forumsType", $name_frmType, array_item($formdata, "dest_forumsType"), "multiple size=6 id='dest_forumsType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forumsType'));\"");


} elseif (isset($formdata['src_forumsType']) && $formdata['src_forumsType'] && $formdata['src_forumsType'][0] != 0 && !$formdata['dest_forumsType']) {

$dest_types = $formdata['src_forumsType'];

for ($i = 0; $i < count($dest_types); $i++) {
if ($i == 0) {
$userNames = $dest_types[$i];
} else {
$userNames .= "," . $dest_types[$i];

}

}


$name_frmType = explode(",", $userNames);

$sql2 = "select catID,catName from categories1 where catID in ($userNames)";
if ($rows = $db->queryObjectArray($sql2))
foreach ($rows as $row) {

$name_frmType[$row->catID] = $row->catName;

}


?>

<td style="width:40px;">
<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>

<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>
</td>


<?php
form_list_no_formtd("src_forumsType", $name_frmType, array_item($formdata, "src_forumsType"), "multiple size=6 id='src_forumsType' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");
} else {
?>

<td style="width:40px;">
<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>
<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>
</td>


<td>
<select class="mycontrol" name='arr_dest_forumsType[]' dir=rtl id='dest_forumsType'
ondblclick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"
MULTIPLE SIZE=6 style='width:180px;'></select>
</td>

<?php
}
/*********************************************************************************/

//            form_label_short("סוג פורום חדש",TRUE);
//		          form_textarea("new_forumType", array_item($formdata, "new_forumType"),14, 5, 1,"textarea_$formdata[forum_decID]");
//                  form_label_short("קשר לסוג פורום",TRUE);
//              form_list1idx ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"), 'id=insert_forumType  multiple size=6 ');

//  form_empty_cell_noformtd(5);
//   form_label_short2("סוג פורום חדש",TRUE);
//   form_textarea_noformtd("new_forumType", array_item($formdata, "new_forumType"),14, 5, 1,"textarea_frmType$formdata[forum_decID]");
//                  form_label_short2("קשר לסוג פורום",TRUE);
//  echo '<td>';
//        form_list111 ("insert_forumType" , $rows2, array_item($formdata, "insert_forumType"), 'id=insert_forumType  multiple size=6 ');
//
//  echo '</td>';
//  if($level){
//  form_url_noformtd("categories1.php","ערוך סוגי פורומים",1 );
$formdata["forum_decID"] = isset($formdata["forum_decID"]) ? $formdata["forum_decID"] : '';
form_label("סוג פורום חדש", TRUE);
form_textarea("new_forumType", array_item($formdata, "new_forumType"), 14, 5, 1, "textarea_$formdata[forum_decID]");
form_label("קשר לסוג פורום", TRUE);
form_list1idx("insert_forumType", $rows2, array_item($formdata, "insert_forumType"), 'id=insert_forumType  multiple size=6 ');


echo '</tr>';

if ($level) {
echo '<tr><td >';
form_url2("categories1.php", "ערוך סוגי פורומים", 1);
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

echo '<tr><td   align="right"><div style="overflow:hidden;"  data-module="הזנת  סוגי המנהלים:">
<table class="myformtable1" style="overflow:hidden;width:98%;" >
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
//		          form_textarea1("new_managerType", array_item($formdata, "new_managerType"),14, 5, 1,"textarea_mgrType_$formdata[forum_decID]");
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
form_textarea("new_managerType", array_item($formdata, "new_managerType"), 14, 5, 1, "textarea_mgrType_$formdata[forum_decID]");
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


/**********************************************USERS********************************************************************************/


$sql = "SELECT full_name,userID FROM users ORDER BY full_name";
$rows = $db->queryArray($sql);


echo '<tr>
<td   class="myformtd">
<div style="overflow:hidden;" data-module="הזנת  חברי פורום:">
<table class="myformtable1" style="width:60%;">
<tr>';


//   form_label("הזנת  חברי פורום:", TRUE);
echo '<td style="width:20px;">';
form_list111("src_users", $rows, array_item($formdata, "src_users"), "multiple size=6 id='src_users' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));\"");
echo '</td>';


/****************************************************************************************************/
if (isset($formdata['dest_users']) && $formdata['dest_users'] && $formdata['dest_users'] != 'none' && count($formdata['dest_users']) > 0) {
$dest_users = $formdata['dest_users'];


foreach ($dest_users as $key => $val) {

if (!$result["dest_users"])
$result["dest_users"] = $key;
else
$result["dest_users"] .= "," . $key;

}


$staff = $result["dest_users"];
$formdata['dest_users1'] = explode(',', $staff);
$sql2 = "select userID, full_name from users where userID in ($staff)";
if ($rows = $db->queryObjectArray($sql2))
foreach ($rows as $row) {

$name[$row->userID] = $row->full_name;

}

$i = 0;
?>

<td style="width:40px;">

<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));"/>

<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
OnClick="remove_item_from_select_box(document.getElementById('dest_users'));"/>


</td>


<?php
form_list_noformtd("dest_users", $name, array_item($formdata, "dest_users1"), "multiple size=6 id='dest_users' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_users'));\"");

/**********************************************************************************************/
} elseif (isset($formdata['src_users']) && $formdata['src_users'] && $formdata['src_users'][0] != 0 && !$formdata['dest_users']) {

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

<td style="width:40px;">
<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));"/>

<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
OnClick="remove_item_from_select_box(document.getElementById('dest_users'));"/>
</td>


<?php
form_list_noformtd("src_users", $name, array_item($formdata, "src_users"), "multiple size=6 id='src_users' ondblclick=\"add_item_to_select_box(document.getElementById('src_users'), document.getElementById('src_users'));\"");


} else {


?>

<td style="width:40px;">
<input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
OnClick="add_item_to_select_box(document.getElementById('src_users'), document.getElementById('dest_users'));"/>
<BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
OnClick="remove_item_from_select_box(document.getElementById('dest_users'));"/>
</td>


<td>
<select class="mycontrol" name='arr_dest_users[]' dir=rtl id='dest_users' MULTIPLE
SIZE=6 style='width:180px;'
ondblclick="remove_item_from_select_box(document.getElementById('dest_users'));"></select>

</td>

<?php


}
if ($level) {

form_url_noformtd("print_users.php", "ערוך משתמשים", 1);

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
|| ($formdata && !(array_item($formdata, 'dest_users')))
) {


echo '<tr>
<td><div style="overflow:hidden;"   data-module="הזנת תאריכים לכמה משתמשים:">
<table class="myformtable1" id="my_date_table" style="width:40%">
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
if ($formdata && (array_item($formdata, 'dest_users'))) {
echo '<tr>
<td>
<div style="overflow:hidden;"   data-module="הזנת תאריכים למשתמשים חדשים:">
<table class="myformtable1" id="my_date_table" style="width:40%">
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
if (array_item($formdata, 'dest_users') && $formdata['dest_users'] != 'none'){
$forum_decName = $formdata['forum_decName'] ? $formdata['forum_decName'] : '';
$forum_decID = $formdata['forum_decID'] ? $formdata['forum_decID'] : '';
$i = 0;
echo '<tr>';
echo '<td   class="myformtd" id="my_Frm_users_td">';
/////////////////////////////////////////////////////////////////////
$link = "../admin/find3.php?forum_decID=$forum_decID";
$url = "../admin/find3.php?forum_decID=$forum_decID";
$str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';


$link_frm = "<a onClick=openmypage3('" . $url . "');   class=href_modal1  href='javascript:void(0)' >
<b style='color:brown;font-size:1.4em;'>$forum_decName<b></a>";


////////////////////////////////////////////////////////////////////////////
// echo '<fieldset data-module="חברי הפורום:'.$forum_decName.'"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  id="users_fieldset" >';
echo '<fieldset data-module="חברי הפורום:' . $link_frm . '"  class="myformtable1"  style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  id="users_fieldset" >';

echo '<div  id="content_users" class="content_users" style="overflow:hidden;">';
echo '<h4 class="my_title_users" style=" height:15px"></h4>';
echo '<div   id="my_div_table" style="overflow:auto;">';
echo '<table  id="my_table" >';

/***************************************************/
foreach ($formdata['dest_users'] as $key => $val){
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
echo $formdata['forum_decision']; ?>">
<a href="javascript:void(0)"
onclick="edit_active(<?php echo $key; ?>,<?php echo $formdata['forum_decision']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo $formdata["active"][$key]; ?>); return false;">
<img src="<?php echo IMAGES_DIR ?>/icon_status_<?php echo $gif_num; //print $formdata["active"][$key]
?>.gif" width="16" height="10" alt="" border="0"/>
</a>
</td>


<td>

<?php

form_label1("חבר פורום:");
form_text_a("member", $val, 20, 50, 1);


if ($level) {


?>


<input type="button" class="mybutton" id="my_button_<?php echo $key; ?>"
value="ערוך משתמש"
onClick="return editUser3(<?php echo $key; ?>,<?php echo $formdata['forum_decision']; ?>,
<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>); return false;"/>


<!--<input type="button"  class="mybutton"  id="my_button_<?php echo $key; ?>"  value="ערוך משתמש" onClick="return editUser_frmID(<?php echo $key; ?>,<?php echo $formdata['forum_decision']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>);" ; return false; />-->

<?php
} elseif (!($level)) {

?>
<input type="button" class="mybutton" id="my_button_<?php echo $key; ?>"
value="צפה בפרטי המשתמש"
onClick="return editUser3(<?php echo $key; ?>,<?php echo $formdata['forum_decision']; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo "' $i '"; ?>);"
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

form_label1("תאריך צרוף לפורום:");
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
echo '<td   class="myformtd" id="my_Frm_users_td">';

echo '<fieldset data-module="חברי הפורום:' . $link_frm . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  id="users_fieldset" >';
echo '<div  id="content_users" class="content_users" style="overflow:hidden;">';
echo '<h4 class="my_title_users" style=" height:15px"></h4>';
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

if (array_item($formdata, "forum_decID")) {


$sql = "SELECT d.decName,d.decID,d.parentDecID,f.forum_decName 
FROM decisions d,forum_dec f, rel_forum_dec r
WHERE d.decID = r.decID
AND r.forum_decID =f.forum_decID
AND r.forum_decID = " . $db->sql_string($formdata['forum_decision']) .
" ORDER BY  d.decName ";


if ($rows = $db->queryObjectArray($sql)) {

$forum_decName = $rows[0]->forum_decName;


echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

echo '<tr>';
echo '<td id="my_tree_td">';
echo '<fieldset data-module="ערוך החלטות של פורום:' . $link_frm . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form">';
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
echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:' . $link_frm . '"  id="my_form2">';
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

$forum_decName = $formdata['forum_decName'];

echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

echo '<tr>';
echo '<td id="my_tree_td">';
echo '<fieldset data-module="ערוך החלטות של פורום:' . $link_frm . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form">';
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
echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:' . $link_frm . '"  id="my_form2">';
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

$forum_decName = $rows[0]->forum_decName;


echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

echo '<tr>';
echo '<td id="my_tree_td">';
echo '<fieldset data-module="ערוך החלטות של פורום:' . $link_frm . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form">';
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
echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:' . $link_frm . '"  id="my_form2">';
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
}//end if forum_decID */
/*********************/
//-----------------------------------------------FORM_DEM_9.PHP dynamic-select---------------------------------------------------------------
elseif (!(array_item($formdata, 'forum_decID'))) {


if (!(ae_detect_ie())) {//FOR $ROWS=FALSE

$forum_decName = isset($formdata['forum_decName']) ? $formdata['forum_decName'] : '';

echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

echo '<tr>';
echo '<td id="my_tree_td">';
echo '<fieldset data-module="ערוך החלטות של פורום:' . $link_frm . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form">';
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
echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:' . $link_frm . '"  id="my_form2">';
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

$forum_decName = $rows[0]->forum_decName;


echo '<div id="tree_content_target" >'; //for pushing the data   id='".$idTT1."'

echo '<tr>';
echo '<td id="my_tree_td">';
echo '<fieldset data-module="ערוך החלטות של פורום:' . $link_frm . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form">';
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
echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:' . $link_frm . '"  id="my_form2">';
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


/***************************************************************************************************************************/


// buttons


echo '<tr>
<td><table class="myformtable1"><tr><td>';

$button_id = $formdata['forum_decision'];
$forumID = $formdata['forum_decision'];


if ($level) {
/**************************************************************************************************************************/

form_button_no_td2("submitbutton", "שמור", "Submit", "OnClick=\"
prepSelObject(document.getElementById('dest_forumsType'));
prepSelObject(document.getElementById('dest_managersType'));
prepSelObject(document.getElementById('dest_users'));
\";");

// onclick="return  document.getElementById('mode_').value='take_data';"  >העלה מידע</button>
?>
<button class="green90x24" type="submit"
name="submitbutton3_<?php echo $formdata['forum_decision']; ?>"
id="submitbutton3_<?php echo $formdata['forum_decision']; ?>"
onclick="return  prepSelObject(document.getElementById('dest_forumsType'))
, prepSelObject(document.getElementById('dest_managersType'))
,prepSelObject(document.getElementById('dest_users'));">העלה מידע
</button>

<?php
/****************************************************************************************************************************************/
if (array_item($formdata, 'dynamic_6')) {
$x = $formdata['index'];
$formdata["forum_decID"] = $formdata["forum_decID"][$x];
$tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
form_hidden("forum_decID", $formdata["forum_decID"]);
form_hidden("insertID", $formdata["insertID"]);
} else
$tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
$formdata["forum_decID"] = isset($formdata["forum_decID"]) ? $formdata["forum_decID"] : '';
$formdata["insertID"] = isset($formdata["insertID"]) ? $formdata["insertID"] : '';
form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
form_hidden("forum_decID", $formdata["forum_decID"]);
form_hidden("insertID", $formdata["insertID"]);


if (array_item($formdata, "forum_decID") && !$formdata['fail']) {


//     form_button_no_td2("btnLink1", "קשר לפורום","Submit");
//     form_hidden("forum_decID", $formdata["forum_decID"]);


// form_button1("btnDelete", "מחק פורום", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["forum_decID"]."').value='delete'\";");
form_empty_cell_no_td(20);
form_button_no_td2("btnDelete", "מחק פורום", "Submit", "OnClick='return shalom(\"" . $formdata[forum_decID] . "\")'");


} else {

form_empty_cell_no_td(10);

// form_button_no_td("btnClear","הכנס נתונים לפורום/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["btnClear"]."').value='clear'\"; id='reset'");
form_button_no_td("btnClear", "הכנס נתונים לפורום/נקה טופס", "Submit", "id=reset");


}
//////////////////////////
} elseif (!($level)) {   ///
/////////////////////////
form_hidden("forum_decID", $formdata["forum_decID"]);
form_hidden("insertID", $formdata["insertID"]);
$tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
form_hidden("forum_decID", $formdata["forum_decID"]);
form_hidden("insertID", $formdata["insertID"]);
?>
<button class="green90x24" type="submit"
name="submitbutton3_<?php echo $formdata['forum_decision']; ?>"
id="submitbutton3_<?php echo $formdata['forum_decision']; ?>"
onclick="return  prepSelObject(document.getElementById('dest_forumsType'))
, prepSelObject(document.getElementById('dest_managersType'))
,prepSelObject(document.getElementById('dest_users'));">העלה מידע
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
<!--      <h4 class="my_menu_items_forum_title" style="height:15px;cursor:pointer;display:none;"></h4>-->
<?php
}
?>

<h4 class="my_menu_items_forum_title" style="height:15px;cursor:pointer;display:none;"></h4>

<ul id="menu_items_forum_8" name="menu_items_forum_8" class="ui-sortable"
style="overflow: auto;direction:right;" dir="rtl">
<input type=hidden name="menu_items_forum" id="menu_items_forum"
value="<?php echo $formdata['forum_decision'] ?>"/>

<div id="forum_decision" name="forum_decision" class="my_div"></div>
<div id="forum_decision_a" name="forum_decision_a"></div>
<div id="forum_decision_b" name="forum_decision_b"></div>
<div id="forum_decision_c" name="forum_decision_c"></div>
<div id="forum_decision_d" name="forum_decision_d"></div>
<div id="forum_decision_e" name="forum_decision_e"></div>
<div id="forum_decision3" name="forum_decision3"></div>
<div id="forum_decision4" name="forum_decision4"></div>
<div id="forum_decision5" name="forum_decision5"></div>
<div id="forum_decision6" name="forum_decision6"></div>
<div id="forum-message" name="forum-message"></div>

</ul>


</fieldset>

</form>
<!-- ============================================================================================================ -->

<?php
//$forum_decID=(isset($forum_decID) )?(int)$forum_decID:1;
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
<option value="1"><?php __(forum_user) ?></option>
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
$forum_decID = (isset($forum_decID)) ? (int)$forum_decID : 1;
?>
<div id="page_useredit<?php echo $forum_decID; ?>" style="display:none">

<h3><?php __('edit_user'); ?></h3>


<form onSubmit="return saveUser4forum(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo $forum_decID; ?>);"
name="edituser<?php echo $forum_decID; ?>" id="edituser<?php echo $forum_decID; ?>" dir="rtl">


<input type="hidden" name="id<?php echo $forum_decID; ?>" value=""/>
<input type="hidden" name="Request_Tracking_Number_1" id="Request_Tracking_Number_1" value=""/>
<input type="hidden" name="Request_Tracking_Number1" id="Request_Tracking_Number1" value=""/>
<input type="hidden" name="Request_Tracking_Number2" id="Request_Tracking_Number2" value=""/>


<div class="form-row">
<span class="h"><?php __('priority'); ?></span>
<SELECT name="prio" id="prio<?php echo $forum_decID; ?>" class="mycontrol">
<option value="3">+3</option>
<option value="2">+2</option>
<option value="1">+1</option>
<option value="0" selected>&plusmn;0</option>
<option value="-1">&minus;1</option>
</SELECT>
</div>


<div class="form-row">
<span class="h"><?php __('active'); ?></span>
<SELECT name="active<?php echo $forum_decID; ?>" id="active<?php echo $forum_decID; ?>"
class="mycontrol">
<option value="2" selected>פעיל</option>
<option value="1">לא פעיל</option>

</SELECT>
</div>
&nbsp;


<div class="form-row">
<span class="h"><?php __('due'); ?> </span>
<input name="duedate3<?php echo $forum_decID; ?>" id="duedate3<?php echo $forum_decID; ?>"
value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off"/>

</div>


<div class="form-row">
<span class="h"><?php __('level'); ?></span>
<SELECT name="level" id="level<?php echo $forum_decID; ?>" class="mycontrol">
<option value="1"><?php __(forum_user) ?></option>
<option value="2"><?php __(admin) ?></option>
<option value="3"><?php __(suppervizer) ?></option>
<option value="none" selected>(בחר אופציה)</option>
</SELECT>

</div>


<div class="form-row"><span class="h"><?php __('full_name'); ?></span><br> <input type="text"
name="full_name"
id="full_name<?php echo $forum_decID; ?>"
value=""
class="in200"
maxlength="50"/>
</div>

<div class="form-row"><span class="h"><?php __('user'); ?></span><br> <input type="text" name="user"
id="user<?php echo $forum_decID; ?>"
value="" class="in200"
maxlength="50"/></div>

<div class="form-row"><span class="h"><?php __('upass'); ?></span><br> <input type="text"
name="upass"
id="upass<?php echo $forum_decID; ?>"
value="" class="in200"
maxlength="50"/></div>
<div class="form-row"><span class="h"><?php __('email'); ?></span><br> <input type="text"
name="email"
id="email<?php echo $forum_decID; ?>"
value="" class="in200"
maxlength="50"/></div>
<div class="form-row"><span class="h"><?php __('phone'); ?></span><br> <input type="text"
name="phone"
id="phone<?php echo $forum_decID; ?>"
value="" class="in200"
maxlength="50"/></div>
<div class="form-row"><span class="h"><?php __('note'); ?></span><br> <textarea
name="note<?php echo $forum_decID; ?>" id="note<?php echo $forum_decID; ?>"
class="in500"></textarea></div>
<div class="form-row"><span class="h"><?php __('tags'); ?></span><br> <input type="text"
name="tags<?php echo $forum_decID; ?>"
id="edittags1<?php echo $forum_decID; ?>"
value="" class="in500"
maxlength="250"/></div>


<div class="form-row">
<?php if ($level) { ?>
<input type="submit" value="<?php __('save'); ?>" onClick="this.blur()"/>
<?php } ?>
<input type="button" id="my_button_win1<?php echo $forum_decID; ?>"
value="<?php __('forum_details'); ?>" class="href_modal1"/>
<input type="button" value="<?php __('cancel'); ?>"
onClick="canceluserEdit6(<?php echo $forum_decID; ?>);this.blur();return false"/>
</div>
</form>


</div>  <!-- end of page_user_edit+forum_decID -->


<!-- ============================================================================================================ -->
</div>   <!--  end div main  -->


<?php
/**************************************************************************************************/
}//end build_ajxform7
/**************************************************************************************************/
