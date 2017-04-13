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
                style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x">
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
                    if ($formdata['appoint_date'])
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
                    if ($formdata['dest_forumsType'] && $formdata['dest_forumsType'] != 'none') {
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
                    } elseif ($formdata['src_forumsType'] && $formdata['src_forumsType'][0] != 0 && !$formdata['dest_forumsType']) {
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


                    if ($formdata['dest_managersType'] && $formdata['dest_managersType'] != 'none') {
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


                    } elseif ($formdata['src_managersType'] && $formdata['src_managersType'][0] != 0 && !$formdata['dest_managersType']) {

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
                    if ($formdata['dest_users'] && $formdata['dest_users'] != 'none' && count($formdata['dest_users']) > 0) {
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
                    } elseif ($formdata['src_users'] && $formdata['src_users'][0] != 0 && !$formdata['dest_users']) {

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

                                    form_button_no_td("btnClear", "הכנס נתונים לפורום/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\" ");


                                }

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


        <!-- ============================================================================================================ -->


    </div><!-- end div main -->


    <?php

    /**********************************************************************************************/
}//end build_form
/**********************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function build_form_ajx7(&$formdata)
{

    $level = '';
    /*********************************************/
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

        $url_mgr = "../admin/find3.php?managerID=$formdata[manager_forum]";
        $link_frm_mgr = "<span><a onClick=openmypage3('" . $url_mgr . "');   class=href_modal1  href='javascript:void(0)' >
                  <b style='color:brown;font-size:1.4em;'>$formdata[managerName]<b>
                 </a></span>";


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
        if (!($formdata['save_new'] == 1)){
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

                            if ($formdata['appoint_date'])
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


                            if ($formdata['dest_forumsType'] && $formdata['dest_forumsType'] != 'none') {


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


                            } elseif ($formdata['src_forumsType'] && $formdata['src_forumsType'][0] != 0 && !$formdata['dest_forumsType']) {

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


                            if ($formdata['dest_managersType'] && $formdata['dest_managersType'] != 'none') {
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


                            } elseif ($formdata['src_managersType'] && $formdata['src_managersType'][0] != 0 && !$formdata['dest_managersType']) {

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
                            if ($formdata['dest_users'] && $formdata['dest_users'] != 'none' && count($formdata['dest_users']) > 0) {
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
                            } elseif ($formdata['src_users'] && $formdata['src_users'][0] != 0 && !$formdata['dest_users']) {

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

                                            $forum_decName = $formdata['forum_decName'] ? $formdata['forum_decName'] : '';

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
                        if (!($formdata["save_new"])) {
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

function build_form_ajx3(&$formdata)
{

    ?>
    <div id="main">


        <form name="forum1" id="forum1" method="post" action="../admin/dynamic_6b.php">

            <fieldset
                    style="margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x">
                <legend style="color:brown;">פורומים עין השופט</legend>


                <table>
                    <?php


                    global $db;

                    $dates = getdate();


                    /****************************************************************************************/

                    echo '<tr><td   class="myformtd" > 
		<div style="overflow:hidden;" data-module="שם הפורום:">
		<table class="myformtable1" style="height:100px;width:98%; overflow:hidden;">
		<tr>';
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

                    $sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcats_a[$row->parentForumID][] = $row->forum_decID;
                        $catNames_a[$row->forum_decID] = $row->forum_decName;
                    }
                    // build hierarchical list
                    $rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
                    $rows2 = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);


                    form_textarea("newforum", array_item($formdata, "newforum"), 22, 5, 1);

                    form_label_short("קשר לפורום:", TRUE);
                    form_list1idx("insert_forum", $rows2, array_item($formdata, "insert_forum"), " multiple size=6 width=1");


                    form_label_short("הזנת תאריכים לכמה לפורומים:", true);

                    //		         list11_td("multi_year" ,$years , array_item($formdata, "multi_year"), " multiple size=6"  );
                    //
                    //				 list11_td("multi_month" ,$months , array_item($formdata, "multi_month"), " multiple size=6"  );
                    //
                    //				 list11_td("multi_day" ,$days, array_item($formdata, "multi_day"), " multiple size=6"  );


                    echo '<td  colspan="4" class="myformtd" >';
                    list11_ctrl2("multi_year", $years, array_item($formdata, "multi_year"), "multiple size=6");

                    list11_ctrl2("multi_month", $months, array_item($formdata, "multi_month"), "multiple size=6");

                    list11_ctrl2("multi_day", $days, array_item($formdata, "multi_day"), "multiple size=6");
                    echo '</td>';


                    form_url("categories1.php", "ערוך פורומים", 1);


                    echo '</tr>
	 	</table></div>
	 	</td></tr>';

                    /*****************************************************************************************/
                    /*************************************FORUM_TYPE*****************************************************************/

                    echo '<tr><td   class="myformtd" > 
		<div style="overflow:hidden;" data-module="הזנת  סוגי הפורום:">
		<table class="myformtable1" style="height:100px;width:98%;overflow:hidden;">
		<tr>';

                    $sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcatsftype[$row->parentCatID][] = $row->catID;
                        $catNamesftype[$row->catID] = $row->catName;
                    }

                    $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
                    $rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);


                    echo '<td class="myformtd" style="width:20px;">';
                    form_list111("src_forumsType", $rows, array_item($formdata, "src_forumsType"), "multiple size=6 id='src_forumsType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");
                    echo '</td>';


                    if ($formdata['dest_forumsType'] && $formdata['dest_forumsType'] != 'none') {


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

                                    $name[$row->catID] = $row->catName;


                                }

                        } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                            $staff = implode(',', $staff_test);

                            $sql2 = "select catID, catName from categories1 where catName in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name[$row->catID] = $row->catName;


                                }
                            $staffb = implode(',', $staff_testb);

                            $sql2 = "select catID, catName from categories1 where catID in ($staffb)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name_b[$row->catID] = $row->catName;
                                }
                            $name = array_merge($name, $name_b);
                            unset($staff_testb);
                        } else {
                            $staff = implode(',', $formdata['dest_forumsType']);

                            $sql2 = "select catID, catName from categories1 where catID in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name[$row->catID] = $row->catName;
                                    //$name[]=$row->catName;

                                }
                        }

                        ?>

                        <td class="myformtd" style="width:20px;">

                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>


                        </td>


                        <?php


                        form_list11("dest_forumsType", $name, array_item($formdata, "dest_forumsType"), "multiple size=6 id='dest_forumsType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forumsType'));\"");


                    } elseif ($formdata['src_forumsType'] && $formdata['src_forumsType'][0] != 0 && !$formdata['dest_forumsType']) {

                        $dest_types = $formdata['src_forumsType'];

                        for ($i = 0; $i < count($dest_types); $i++) {
                            if ($i == 0) {
                                $userNames = $dest_types[$i];
                            } else {
                                $userNames .= "," . $dest_types[$i];

                            }

                        }


                        $name = explode(",", $userNames);

                        $sql2 = "select catID,catName from categories1 where catID in ($userNames)";
                        if ($rows = $db->queryObjectArray($sql2))
                            foreach ($rows as $row) {

                                $name[$row->catID] = $row->catName;

                            }


                        ?>

                        <td class="myformtd" style="width:20px;">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"/>
                        </td>


                        <?php
                        form_list11("src_forumsType", $name, array_item($formdata, "src_forumsType"), "multiple size=6 id='src_forumsType' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));\"");


                    } else {


                        ?>

                        <td class="myformtd" style="width:20px;">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType'), document.getElementById('dest_forumsType'));">
                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType'));">
                        </td>


                        <td class="myformtd" style="width:20px;">
                            <select class="mycontrol" name='arr_dest_forumsType[]' dir=rtl id='dest_forumsType'
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_forumsType'));"
                                    MULTIPLE SIZE=6 style='width:180px;'></select>
                        </td>

                        <?php

                    }

                    form_label_short("סוג פורום חדש:", TRUE);
                    form_textarea("new_forumType", array_item($formdata, "new_forumType"), 14, 5, 1);

                    form_label_short("קשר לסוג פורום:", TRUE);

                    form_list1("insert_forumType", $rows2, array_item($formdata, "insert_forumType"), "multiple size=6");
                    form_url("categories1.php", "ערוך סוגי פורומים:", 3);


                    echo '</tr>
	 	</table>
	 	</div>
	 	</td>
	 	</tr>';

                    /************************************************APPOINT******************************************************************************/
                    echo '<tr><td   class="myformtd" > 
		<div style="overflow:hidden;" data-module="הזנת  ממני פורום:">
		<table class="myformtable1" style="height:100px;width:98%;overflow:hidden;">
		<tr>';

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

                    $sql3 = "SELECT full_name,userID FROM users ORDER BY full_name";


                    $sql1 = "SELECT userID, full_name FROM users ORDER BY full_name";
                    if ($rows3 = $db->queryObjectArray($sql1)) {
                        foreach ($rows3 as $row) {
                            $usrName[$row->userID] = $row->full_name;
                        }
                    }


                    $sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcats22[$row->parentAppointID][] = $row->appointID;
                        $catNames22[$row->appointID] = $row->appointName;
                    }


                    $rows = build_category_array($subcats22[NULL], $subcats22, $catNames22);
                    $rows2 = build_category_array($subcats22[NULL], $subcats22, $catNames22);


                    echo '<td class="myformtd" style="width:20px;">';

                    form_list111("src_appoints", $rows, array_item($formdata, "src_appoints"), "multiple size=6 id='src_appoints' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_appoints'), document.getElementById('dest_appoints'));\"");

                    echo '</td>';


                    if ($formdata['dest_appoints'] && $formdata['dest_appoints'] != 'none') {
                        $dest_appoints = $formdata['dest_appoints'];

                        foreach ($dest_appoints as $key => $val) {

                            if (!is_numeric($val)) {
                                $val = $db->sql_string($val);
                                $staff_test[] = $val;

                            } elseif (is_numeric($val)) {
                                $staff_testb[] = $val;

                            }

                        }


                        if (is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                            $staff = implode(',', $staff_test);

                            $sql2 = "select appointID, appointName from appoint_forum where appointName in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name_appoint[$row->appointID] = $row->appointName;


                                }

                        } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {

                            $staff = implode(',', $staff_test);

                            $sql2 = "select appointID, appointName from appoint_forum where appointName in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name_appoint[$row->appointID] = $row->appointName;


                                }


                            $staff_b = implode(',', $staff_testb);

                            $sql2 = "select appointID, appointName from appoint_forum where appointID in ($staff_b)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name_appoint_b[$row->appointID] = $row->appointName;


                                }

                            $name_appoint = array_merge($name_appoint, $name_appoint_b);
                            unset($staff_testb);
                        } else {


                            $staff = implode(',', $formdata['dest_appoints']);

                            $sql2 = "select appointID, appointName from appoint_forum where appointID in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    //$name_appoint[$row->appointID]=$row->appointName;
                                    $name_appoint[$row->appointID] = $row->appointName;

                                }

                        }
                        ?>

                        <td class="myformtd" style="width:20px;">

                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_appoints'), document.getElementById('dest_appoints'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_appoints'));"/>


                        </td>


                        <?php


                        form_list11("dest_appoints", $name_appoint, array_item($formdata, "dest_appoints"), "multiple size=6 id='dest_appoints' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_appoints'));\"");


                    } elseif ($formdata['src_appoints'] && $formdata['src_appoints'][0] != 0 && !$formdata['dest_appoints']) {

                        $dest_users = $formdata['src_appoints'];

                        for ($i = 0; $i < count($dest_appoints); $i++) {
                            if ($i == 0) {
                                $userNames = $dest_appoints[$i];
                            } else {
                                $userNames .= "," . $dest_appoints[$i];

                            }

                        }


                        $name_appoint = explode(",", $userNames);


                        ?>

                        <td class="myformtd" style="width:20px;">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_appoints'), document.getElementById('dest_appoints'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_appoints'));"/>
                        </td>


                        <?php
                        form_list11("src_appoints", $name_appoint, array_item($formdata, "src_appoints"), "multiple size=6 id='src_appoints' ondblclick=\"add_item_to_select_box(document.getElementById('src_appoints'), document.getElementById('dest_appoints'));\"");


                    } else {


                        ?>

                        <td class="myformtd" style="width:20px;">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_appoints'), document.getElementById('dest_appoints'));"/>
                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_appoints'));"/>
                        </td>


                        <td class="myformtd" style="width:20px;">
                            <select class="mycontrol" name='arr_dest_appoints[]' dir=rtl id='dest_appoints' MULTIPLE
                                    SIZE=6
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_appoints'));"
                                    style='width:180px;'></select>
                        </td>

                        <?php


                    }

                    $sql = "SELECT u.* FROM users u
			LEFT JOIN appoint_forum a   ON u.userID=a.userID
			WHERE u.userID NOT IN(SELECT userID FROM appoint_forum)
			ORDER BY u.full_name ";
                    if ($rows4 = $db->queryObjectArray($sql)) {
                        foreach ($rows4 as $row) {
                            $array[$row->userID] = $row->full_name;
                        }
                    }


                    form_label(" שם ממנה חדש:", TRUE);

                    form_list1idx("new_appoint", $db->queryArray($sql3), array_item($formdata, "new_appoint"), "multiple size=6");
                    //   form_list11("new_appoint",$array, array_item($formdata, "new_appoint"),"multiple size=6");

                    form_label("קשר לממנה", TRUE);
                    if (array_item($formdata, "insert_appoint"))
                        form_list1idx("insert_appoint", $rows2, array_item($formdata, "insert_appoint"), "multiple size=6");

                    else
                        form_list1("insert_appoint", $rows2, array_item($formdata, "insert_appoint"), "multiple size=6");
                    form_url("appoint_edit.php", "ערוך ממנים", 1);
                    echo '<tr>';
                    echo '<td class="myformtd" colspan="8" style="width:5px;" >';
                    form_label_red1("הזנת תאריכים לכמה ממנים:", true);

                    echo '</td >';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="myformtd" colspan="8" >';

                    list11_ctrl2("multi_year_appoint", $years, array_item($formdata, "multi_year_appoint"), " multiple size=6");

                    list11_ctrl2("multi_month_appoint", $months, array_item($formdata, "multi_month_appoint"), " multiple size=6");

                    list11_ctrl2("multi_day_appoint", $days, array_item($formdata, "multi_day_appoint"), " multiple size=6");
                    form_empty_cell_no_td(10);


                    echo '</td>';


                    echo '</tr>';


                    echo '</tr>
	 	</table>
	 	</div>
	 	</td>
	 	</tr>';
                    /******************************************************************************************************/
                    /*********************************************MANAGERS*********************************************************************************/
                    echo '<tr>
      <td   class="myformtd" > 
    	<div style="overflow:hidden;" data-module="הזנת  מנהלי פורום:">
		<table class="myformtable1" style="height:100px;width:98%;overflow:hidden;">
		<tr>';


                    $sql1 = "SELECT full_name,userID FROM users ORDER BY full_name";


                    $sql = "SELECT managerName,managerID,parentManagerID FROM managers ORDER BY managerName";
                    $rows = $db->queryObjectArray($sql);


                    foreach ($rows as $row) {
                        $subcats6[$row->parentManagerID][] = $row->managerID;
                        $catNames6[$row->managerID] = $row->managerName;
                    }
                    // build hierarchical list
                    $rows = build_category_array($subcats6[NULL], $subcats6, $catNames6);
                    $rows2 = build_category_array($subcats6[NULL], $subcats6, $catNames6);


                    echo '<td class="myformtd" style="width:20px;">';

                    form_list111("src_managers", $rows, array_item($formdata, "src_managers"), "multiple size=6 id='src_managers' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_managers'), document.getElementById('dest_managers'));\"");

                    echo '</td>';


                    if ($formdata['dest_managers'] && $formdata['dest_managers'] != 'none') {
                        $dest_managers = $formdata['dest_managers'];

                        foreach ($dest_managers as $key => $val) {

                            if (!is_numeric($val)) {
                                $val = $db->sql_string($val);
                                $staff_test[] = $val;

                            } elseif (is_numeric($val)) {
                                $staff_testb[] = $val;

                            }

                        }

                        if (is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                            $staff = implode(',', $staff_test);
                            $sql = "select managerID, managerName from managers where managerName in ($staff)";
                            if ($rows = $db->queryObjectArray($sql))
                                foreach ($rows as $row) {

                                    $name_managers[$row->managerID] = $row->managerName;


                                }
                        } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                            $staff = implode(',', $staff_test);
                            $sql = "select managerID, managerName from managers where managerName in ($staff)";
                            if ($rows = $db->queryObjectArray($sql))
                                foreach ($rows as $row) {

                                    $name_managers[$row->managerID] = $row->managerName;
                                }


                            $staff_b = implode(',', $staff_testb);

                            $sql = "select managerID, managerName from managers where managerID in ($staff_b)";
                            if ($rows = $db->queryObjectArray($sql))
                                foreach ($rows as $row) {

                                    $name_managers_b[$row->managerID] = $row->managerName;


                                }

                            $name_managers = array_merge($name_managers, $name_managers_b);
                            unset($staff_testb);

                        } else {
                            $staff = implode(',', $formdata['dest_managers']);

                            $sql2 = "select managerID, managerName from managers where managerID in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name_managers[$row->managerID] = $row->managerName;


                                }

                        }
                        ?>

                        <td class="myformtd">

                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managers'), document.getElementById('dest_managers'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managers'));"/>


                        </td>


                        <?php


                        form_list11("dest_managers", $name_managers, array_item($formdata, "dest_managers"), "multiple size=6 id='dest_managers' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_managers'));\"");


                    } elseif ($formdata['src_managers'] && $formdata['src_managers'][0] != 0 && !$formdata['dest_managers']) {

                        $dest_users = $formdata['src_managers'];

                        for ($i = 0; $i < count($dest_managers); $i++) {
                            if ($i == 0) {
                                $userNames = $dest_managers[$i];
                            } else {
                                $userNames .= "," . $dest_managers[$i];

                            }

                        }


                        $name_managers = explode(",", $userNames);


                        ?>

                        <td class="myformtd">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managers'), document.getElementById('dest_managers'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managers'));"/>
                        </td>


                        <?php
                        form_list11("src_managers", $name_managers, array_item($formdata, "src_managers"), "multiple size=6 id='src_managers' ondblclick=\"add_item_to_select_box(document.getElementById('src_managers'), document.getElementById('dest_managers'));\"");
// form_list11("dest_managers" , $name_managers, array_item($formdata, "dest_managers"),"multiple size=6 id='dest_managers' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_managers'));\"");


                    } else {


                        ?>

                        <td class="myformtd">
                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managers'), document.getElementById('dest_managers'));"/>
                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managers'));"/>
                        </td>


                        <td class="myformtd">
                            <select class="mycontrol" name='arr_dest_managers[]' dir=rtl id='dest_managers' MULTIPLE
                                    SIZE=6
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_managers'));"
                                    style='width:180px;'></select>
                        </td>

                        <?php


                    }

                    $sql = "SELECT u.* FROM users u
						LEFT JOIN managers m ON u.userID=m.userID
						WHERE u.userID NOT IN(SELECT userID FROM managers)
						ORDER BY u.full_name ";
                    if ($rows4 = $db->queryObjectArray($sql)) {

                        foreach ($rows4 as $row) {
                            $array[$row->userID] = $row->full_name;
                        }
                    }


                    // form_list_idx("new_manager",$array, array_item($formdata, "new_manager"));


                    form_label_short("שם מנהל חדש", TRUE);
                    // form_list1idx("new_manager" , $db->queryArray($sql1), array_item($formdata, "new_manager"),"multiple size=6");
                    form_list11("new_manager", $array, array_item($formdata, "new_manager"), "multiple size=6");


                    form_label("קשר למנהל", TRUE);
                    if (array_item($formdata, "insert_manager"))
                        form_list1idx("insert_manager", $rows2, array_item($formdata, "insert_manager"), "multiple size=6");
                    else
                        form_list1("insert_manager", $rows2, array_item($formdata, "insert_manager"), "multiple size=6");
                    form_url("manager.php", "ערוך מנהלים", 1);

                    echo '<tr>';
                    echo '<td class="myformtd" colspan="8"  >';
                    form_label_red1("הזנת תאריכים לכמה מנהלים:", true);
                    echo '</td >';
                    echo '</tr>';

                    echo '<tr>';

                    echo '<td class="myformtd" colspan="8">';
                    list11_ctrl2("multi_year_manager", $years, array_item($formdata, "multi_year_manager"), "multiple size=6");

                    list11_ctrl2("multi_month_manager", $months, array_item($formdata, "multi_month_manager"), "multiple size=6");

                    list11_ctrl2("multi_day_manager", $days, array_item($formdata, "multi_day_manager"), "multiple size=6");

                    form_empty_cell_no_td(10);

                    echo '</td>';
                    echo '</tr>';


                    echo '</tr>
	 	</table>
	 	</div>
	 	</td>
	 	</tr>';
                    /*********************************************MANAGE_TYPE*********************************************************/

                    echo '<tr><td   class="myformtd" > 
		<div style="overflow:hidden;" data-module="הזנת  סוגי המנהלים:">
		<table class="myformtable1" style="height:100px;width:98%;overflow:hidden;">
		<tr>';

                    $sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcatsmtype[$row->parentManagerTypeID][] = $row->managerTypeID;
                        $catNamesmtype[$row->managerTypeID] = $row->managerTypeName;
                    }

                    $rows = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);
                    $rows2 = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);


                    echo '<td class="myformtd">';

                    form_list111("src_managersType", $rows, array_item($formdata, "src_managersType"), "multiple size=6 id='src_managersType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));\"");

                    echo '</td>';


                    if ($formdata['dest_managersType'] && $formdata['dest_managersType'] != 'none') {
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

                        <td class="myformtd">

                            <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managersType'), document.getElementById('dest_managersType'));"/>

                            <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managersType'));"/>


                        </td>


                        <?php


                        form_list11("dest_managersType", $name_managerType, array_item($formdata, "dest_managersType"), "multiple size=6 id='dest_managersType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_managersType'));\"");


                    } elseif ($formdata['src_managersType'] && $formdata['src_managersType'][0] != 0 && !$formdata['dest_managersType']) {

                        $dest_users = $formdata['src_managersType'];

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
                    form_label_short("סוג מנהל חדש", TRUE);
                    form_textarea("new_managerType", array_item($formdata, "new_managerType"), 14, 5, 1);
                    form_label_short("קשר לסוג למנהל", TRUE);
                    if (array_item($formdata, "insert_managerType"))
                        form_list1idx("insert_managerType", $rows2, array_item($formdata, "insert_managerType"), "multiple size=6");
                    else
                        form_list1("insert_managerType", $rows2, array_item($formdata, "insert_managerType"), "multiple size=6");


                    form_url("manager_category.php", "ערוך סוגי מנהלים", 1);
                    echo '</tr>
	 	</table>
	 	</div>
	 	</td>
	 	</tr>';
                    /*********************************************************************************************************/

                    echo '<tr>
      <td   class="myformtd" > 
      <div style="overflow:hidden;" data-module="סטטוס פורום">  
 
      <table class="myformtable1" style="width:30%;overflow:hidden;">';


                    $forum_decID = $formdata['decID'];


                    /////////////////////////////////////////////////////////////////////////////////////////


                    $arr = array();
                    $arr[0][0] = "לא פעיל";
                    $arr[0][1] = "1";
                    $arr[1][0] = "פעיל";
                    $arr[1][1] = "2";


                    $selected = array_item($formdata, 'forum_status') ? array_item($formdata, 'forum_status') : $arr[1][1];


                    echo '<tr><td class="myformtd">
     <div class="form-row" style="float:right;text-color:white;">';

                    ?>

                    <span class="h">סטטוס פורום:&nbsp; &nbsp; </span>&nbsp; &nbsp;
    </div>

    <?php
//echo '<td class="myformtd"> ';
    form_list_find_notd_no_choose('forum_status', 'forum_status', $arr, $selected);

    echo '</td></tr>', "\n";


/////////////////////////////////////////////////////////////////////////////////////////////////////

    $arr = array();
    $arr[0][0] = "ציבורי";
    $arr[0][1] = "1";
    $arr[1][0] = "פרטי";
    $arr[1][1] = "2";
    $arr[2][0] = "סודי";
    $arr[2][1] = "3";


    $selected = array_item($formdata, 'forum_Allowed') ? array_item($formdata, 'forum_Allowed') : $arr[0][1];
    echo '<tr> <td class="myformtd"  ><div class="form-row" style="float:right;text-color:white;">';

    ?>

    <span class="h">סיווג פורום:&nbsp; &nbsp; </span>&nbsp; &nbsp; &nbsp;
    </div>
    <?php
    form_list_find_notd_no_choose('forum_allowed', 'forum_allowed', $arr, $selected);

    echo '</td></tr>', "\n";

////////////////////////////////////////////////////////////////

    echo ' </table></div>
 	   </td>
 	   </tr>';

    /*******************************************************************************************/
    /************************************************************************************************/
    // buttons

    echo '<tr><td   class="myformtd" colspan="3" >
    		<table class="myformtable"  style=" border:0;" align="right">
    		<tr>';

    $button_id = $formdata['forum_decision'];
    echo '<td class="myformtd">';
    form_button_img_nt("submitbutton_$button_id", "שמור", "Submit", '$button_id', "OnClick=\"prepSelObject(document.getElementById('dest_forumsType'));
prepSelObject(document.getElementById('dest_appoints'));
prepSelObject(document.getElementById('dest_managers'));
prepSelObject(document.getElementById('dest_managersType'));   
\";");
    echo '</td>';

    $tmp = (array_item($formdata, "forum_forum_decID")) ? "update" : "save";
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
    form_hidden("forum_decID", $formdata["forum_decID"]);
    form_hidden("insertID", $formdata["insertID"]);

    if (array_item($formdata, "forum_decID")) {
        //form_button1("btnDelete", "מחק פורום", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["forum_decID"]."').value='delete'\";");
        form_button1("btnDelete", "מחק פורום", "Submit", "OnClick='return shalom(\"" . $formdata[forum_decID] . "\")'");

        form_button("btnLink1", "קשר לתת פורום");
        form_hidden("forum_decID", $formdata["forum_decID"]);


    } else {
        echo '<td   class="myformtd" colspan="3" >';
        form_empty_cell_no_td(10);

        form_button_no_td("btnClear", "הכנס נתונים לפורום/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\" ");
        echo '</td>';
    }
    form_label("");
    echo ' 
  	</tr>
 	</table>
 	</td></tr>';


    ?>
    </table>
    </fieldset>
    </form>

    </div>


    <?php
//===============================================================================================
}//end build_ajx3
/**********************************************************************************************/


///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function build_form_ajx4(&$formdata)
{


    ?>

    <script language="javascript" src="<?php print JS_ADMIN_WWW ?>/treeview_forum_multi.js"
            type="text/javascript"></script>
    <!--<script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/treeview_forum.js"    type="text/javascript"></script> -->

    <h4 class="my_Frmtitles_<?php echo $formdata['forum_decision']; ?>" style="height:15px"></h4>
    <div id="main_content<?php echo $formdata['forum_decision']; ?>">
        <form name="forum_<?php echo $formdata['forum_decision']; ?>"
              id="forum_<?php echo $formdata['forum_decision']; ?>" method="post" action="../admin/dynamic_9.php"
              onSubmit="return prepSelObject(document.getElementById('dest_users<?php echo $formdata['forum_decision']; ?>'));">
            <fieldset id="my_forumFieldset<?php echo $formdata['forum_decision']; ?>"
                      style="margin-left:20px;margin-right:40;background: #94C5EB url(../images/background-grad.png) repeat-x;">
                <legend>פורומים עין השופט</legend>


                <div id="loading">
                    <img src="../images/loading4.gif" border="0"/>
                </div>

                <input type="hidden" name="count_<?php echo $formdata['forum_decision']; ?>"
                       id="count_<?php echo $formdata['forum_decision']; ?>"
                       value="<?php echo $formdata['form_index']; ?>"/>
                <div id="forum_decision_tree<?php echo $formdata['forum_decision']; ?>"
                     name="forum_decision_tree<?php echo $formdata['forum_decision']; ?>"></div>
                <table id="myformtable<?php echo $formdata['forum_decision']; ?>" class="myformtable1"
                       style="width:90%;align:center;border:0;">


                    <?php
                    $frm = new forum_dec();
                    $frm->message_save($formdata['forum_decName'], $formdata['forum_decision']);
                    $frm->print_forum_entry_form_b($formdata['forum_decision']);
                    global $db;
                    $frmID = $formdata['forum_decision'];

                    $dates = getdate();

                    // $form["dec_date$decID"]= substr($dec_date ,1,10);
                    /****************************************************************************************/


                    $sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcats_a[$row->parentForumID][] = $row->forum_decID;
                        $catNames_a[$row->forum_decID] = $row->forum_decName;


                    }

                    $rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);

                    echo '<tr>
	     <td   class="myformtd" > 
		<div style="overflow:hidden;" data-module="שם הפורום:">
		<table class="myformtable1" style="height:100px;width:98%; overflow:hidden;">
		<tr>';

                    echo '<td   class="myformtd"  norwap >';

                    form_list_b("forum_decision$frmID", $rows, array_item($formdata, "forum_decision"), "id=forum_decision_link$frmID");


                    form_label1("שם פורום חדש", TRUE);
                    form_text_a("new_forum$frmID", array_item($formdata, "new_forum"), 20, 50, 1, "new_forum$frmID");

                    form_label1("קשר לפורום", TRUE);
                    form_list_b("insert_forum$frmID", $rows, array_item($formdata, "insert_forum"), "id=insert_forum$frmID");
                    form_empty_cell_no_td(4);

                    form_label_red1("תאריך הקמה:", true);
                    form_text3("forum_date$frmID", array_item($formdata, "forum_date"), 10, 10, 1, "forum_date$frmID");

                    form_url2("categories1.php", "ערוך פורומים", 2);
                    echo '</td>';

                    echo '</tr>
	 	</table>
	 	</div>
	 	</td>
	 	</tr>';

                    /*************************************FORUMF_TYPE*****************************************************************/


                    $formdata["dest_forumsType$frmID"] = $formdata["dest_forumsType"];
                    $sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcatsftype[$row->parentCatID][] = $row->catID;
                        $catNamesftype[$row->catID] = $row->catName;
                    }

                    $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
                    $rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);


                    echo '<tr><td  class="myformtd" >
            <div  style="overflow:hidden;"  data-module="הזנת  סוגי הפורום:">
                <table class="myformtable1" style="height:100px;width:98%; overflow:hidden;"><tr>';

                    // form_label_red("הזנת  סוגי הפורום:", TRUE);
                    echo '<td class="myformtd">';


                    form_list111("src_forumsType$frmID", $rows, array_item($formdata, "src_forumsType$frmID"), "multiple size=6   id='src_forumsType$frmID' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType$frmID'), document.getElementById('dest_forumsType$frmID'));\"");

                    echo '</td>';


                    if ($formdata["dest_forumsType$frmID"] && $formdata["dest_forumsType$frmID"] != 'none') {


                        $dest_forumsType = $formdata["dest_forumsType$frmID"];

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


                                }
                        }

                        ?>

                        <td class="myformtd">

                            <input type=button name='add_to_list<?php echo $frmID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType<?php echo $frmID; ?>'), document.getElementById('dest_forumsType<?php echo $frmID; ?>'));"/>

                            <BR><BR><input type=button name='remove_from_list<?php echo $frmID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType<?php echo $frmID; ?>'));"/>


                        </td>


                        <?php


                        form_list11("dest_forumsType$frmID", $name_frmType, array_item($formdata, "dest_forumsType$frmID"), "multiple size=6 id='dest_forumsType$frmID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forumsType$frmID'));\"");


                    } elseif ($formdata["src_forumsType$frmID"] && $formdata["src_forumsType$frmID"][0] != 0 && !$formdata["dest_forumsType$frmID"]) {

                        $dest_types = $formdata["src_forumsType$frmID"];

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
                            <input type=button name='add_to_list<?php echo $frmID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType<?php echo $frmID; ?>'), document.getElementById('dest_forumsType<?php echo $frmID; ?>'));"/>

                            <BR><BR><input type=button name='remove_from_list<?php echo $frmID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType<?php echo $frmID; ?>'));"/>
                        </td>


                        <?php
                        form_list11("src_forumsType$frmID", $name_frmType, array_item($formdata, "src_forumsType$frmID"), "multiple size=6 id='src_forumsType$frmID' ondblclick=\"add_item_to_select_box(document.getElementById('src_forumsType$frmID'), document.getElementById('dest_forumsType$frmID'));\"");


                    } else {


                        ?>

                        <td class="myformtd">
                            <input type=button name='add_to_list<?php echo $frmID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_forumsType<?php echo $frmID; ?>'), document.getElementById('dest_forumsType<?php echo $frmID; ?>'));"/>
                            <BR><BR><input type=button name='remove_from_list()<?php echo $frmID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_forumsType<?php echo $frmID; ?>'));"/>
                        </td>


                        <td class="myformtd">
                            <select class="mycontrol" name='arr_dest_forumsType<?php echo $frmID; ?>' dir=rtl
                                    id='dest_forumsType<?php echo $frmID; ?>'
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_forumsType<?php echo $frmID; ?>'));"
                                    MULTIPLE SIZE=6 style='width:180px;'></select>
                        </td>

                        <?php


                    }
                    form_label_short("סוג פורום חדש", TRUE);
                    form_textarea("new_forumType$frmID", array_item($formdata, "new_forumType"), 14, 5, 1, "new_forumType$frmID");
                    form_label_short("קשר לסוג פורום", TRUE);
                    form_list1idx("insert_forumType$frmID", $rows2, array_item($formdata, "insert_forumType"), 'id=insert_forumType' . $frmID . ' multiple size=6 ');


                    form_url("categories1.php", "ערוך סוגי פורומים", 1);
                    echo ' 
  	</tr>
 	</table></div>
 	</td></tr>';

                    /***************************************************************************************************/
                    //APPOINT
                    /*****************************************************************************************/

                    echo '<tr><td   class="myformtd" > 
		<div style="overflow:hidden;" data-module="ממנה פורום:">
		<table class="myformtable1"  style="height:100px;width:98%;">';

                    $sql = "SELECT appointName,appointID,parentAppointID FROM appoint_forum ORDER BY appointName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcats22[$row->parentAppointID][] = $row->appointID;
                        $catNames22[$row->appointID] = $row->appointName;
                    }

                    // build hierarchical list
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


                    echo '<tr><td  norwap class="myformtd">';

                    form_list_b("appoint_forum$frmID", $rows, array_item($formdata, "appoint_forum"), "id=appoint_forum$frmID");


                    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
                    $rows = $db->queryArray($sql);
                    form_empty_cell_no_td(10);
                    form_label1("גוף ממנה חדש", TRUE);
                    //form_list_b ("new_appoint",$rows, array_item($formdata, "new_appoint"));
                    form_list_idx_one("new_appoint$frmID", $array, array_item($formdata, "new_appoint"), "id=new_appoint$frmID");

                    form_empty_cell_no_td(10);
                    form_label1("קשר לממנה:", TRUE);
                    form_list_b("insert_appoint$frmID", $rows1, array_item($formdata, "insert_appoint"), "id=insert_appoint$frmID");

                    if ($formdata['appoint_date'])
                        $formdata['appoint_date1'] = $formdata['appoint_date'];

                    form_empty_cell_no_td(10);
                    form_url2("appoint_edit.php", "ערוך ממני פורום", 1);
                    echo '</td></tr>';
                    /******************************************************/
                    echo '<tr>';
                    echo '<td class="myformtd"  >';
                    form_label_red1("תאריך ממנה:", true);
                    //		echo '</td ></tr>';


                    //echo  '<tr><td class="myformtd">';
                    $formdata["appoint_date1$frmID"] = $formdata["appoint_date"];
                    form_text3("appoint_date1$frmID", array_item($formdata, "appoint_date1$frmID"), 20, 50, 1, "appoint_date1$frmID");

                    echo '</td></tr>';


                    echo '</table>
	 	</div>
	 	</td>
	 	</tr>';
                    /***************************************************************************************************/
                    //MANAGER
                    /*********************************************************************************************/
                    /**********************************************************************************************************/
                    $managerName = $formdata['managerName'] ? $formdata['managerName'] : '';
                    $manager_forum = $formdata['manager_forum'] ? $formdata['manager_forum'] : '';
                    $url = "../admin/find3.php?managerID=$manager_forum";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';


                    $link_frm = "<a onClick=openmypage3('" . $url . "');   class=href_modal1  href='javascript:void(0)' >
<b style='color:red;font-size:1.4em;'>$managerName<b></a>";

                    /****************************************************************************************************/

                    echo '<tr><td   class="myformtd" id="my_manager_td' . $frmID . '"> 
		<div style="overflow:hidden;" data-module="מנהל פורום:' . $link_frm . '">
		<table class="myformtable1" style="height:100px;width:98%; overflow:hidden;">';

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


                    echo '<tr><td    class="myformtd" >';

                    form_list_b("manager_forum$frmID", $rows, array_item($formdata, "manager_forum"), "id=manager_forum$frmID");


                    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
                    $rows = $db->queryArray($sql);

                    form_empty_cell_no_td(10);

                    form_label1("שם מנהל חדש", TRUE);
                    //form_list_b ("new_manager",$rows, array_item($formdata, "new_manager"));
                    form_list_idx_one("new_manager$frmID", $array, array_item($formdata, "new_manager"), "id=new_manager$frmID");
                    form_empty_cell_no_td(10);

                    form_label1("קשר למנהל:", TRUE);
                    form_list_b("insert_manager$frmID", $rows1, array_item($formdata, "insert_manager"), "id=insert_manager$frmID");
                    form_empty_cell_no_td(10);
                    form_url2("manager.php", "ערוך מנהלים", 1);

                    echo '</td >';

                    echo '</tr>';
                    /******************************************************/
                    echo '<tr>';
                    echo '<td class="myformtd" >';
                    form_label_red1("תאריך מינוי מנהל:", true);
                    //		echo '</td ></tr>';


                    // echo  '<tr><td class="myformtd" >';
                    $formdata["manager_date$frmID"] = $formdata["manager_date"];
                    form_text3("manager_date$frmID", array_item($formdata, "manager_date$frmID"), 20, 50, 1, "manager_date$frmID");

                    echo '</td></tr>';

                    /***************************************************************************************************/


                    echo '
	 	</table>
	 	</div>
	 	</td>
	 	</tr>';
                    /**********************************************************************************************/
                    /*************************************MANAGER_TYPE*****************************************************************/

                    $formdata["dest_managersType$frmID"] = $formdata["dest_managersType"];

                    $sql = "SELECT managerTypeName, managerTypeID, parentManagerTypeID FROM manager_type ORDER BY managerTypeName";
                    $rows = $db->queryObjectArray($sql);

                    foreach ($rows as $row) {
                        $subcatsmtype[$row->parentManagerTypeID][] = $row->managerTypeID;
                        $catNamesmtype[$row->managerTypeID] = $row->managerTypeName;
                    }

                    $rows = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);
                    $rows2 = build_category_array($subcatsmtype[NULL], $subcatsmtype, $catNamesmtype);

                    echo '<tr><td   class="myformtd"    align="right"><div style="overflow:hidden;"  data-module="הזנת  סוגי המנהלים:">
    		<table class="myformtable1" style="height:100px;width:98%; overflow:hidden;">
    		<tr>';

                    echo '<td class="myformtd">';


                    form_list111("src_managersType$frmID", $rows, array_item($formdata, "src_managersType$frmID"), "multiple size=6 id='src_managersType$frmID' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType$frmID'), document.getElementById('dest_managersType$frmID'));\"");

                    echo '</td>';


                    if ($formdata["dest_managersType$frmID"] && $formdata["dest_managersType$frmID"] != 'none') {
                        $dest_managersType = $formdata["dest_managersType$frmID"];

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

                            $staff = implode(',', $formdata['dest_managersType']);

                            $sql2 = "select  managerTypeID, managerTypeName from manager_type where managerTypeID in ($staff)";
                            if ($rows = $db->queryObjectArray($sql2))
                                foreach ($rows as $row) {

                                    $name_managerType[$row->managerTypeID] = $row->managerTypeName;


                                }

                        }
                        ?>

                        <td class="myformtd">

                            <input type=button name='add_to_list<?php echo $frmID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managersType<?php echo $frmID; ?>'), document.getElementById('dest_managersType<?php echo $frmID; ?>'));"/>

                            <BR><BR><input type=button name='remove_from_list<?php echo $frmID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managersType<?php echo $frmID; ?>'));"/>


                        </td>


                        <?php


                        form_list11("dest_managersType$frmID", $name_managerType, array_item($formdata, "dest_managersType$frmID"), "multiple size=6 id='dest_managersType$frmID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_managersType$frmID'));\"");


                    } elseif ($formdata["src_managersType$frmID"] && $formdata["src_managersType$frmID"][0] != 0 && !$formdata["dest_managersType$frmID"]) {

                        $dest_managersType = $formdata["src_managersType$frmID"];

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
                            <input type=button name='add_to_list<?php echo $frmID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managersType<?php echo $frmID; ?>'), document.getElementById('dest_managersType<?php echo $frmID; ?>'));"/>

                            <BR><BR><input type=button name='remove_from_list<?php echo $frmID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managersType<?php echo $frmID; ?>'));"/>
                        </td>


                        <?php
                        form_list11("src_managersType$frmID", $name_managerType, array_item($formdata, "src_managersType$frmID"), "multiple size=6 id='src_managersType$frmID' ondblclick=\"add_item_to_select_box(document.getElementById('src_managersType$frmID'), document.getElementById('dest_managersType$frmID'));\"");

                    } else {
                        ?>

                        <td class="myformtd">
                            <input type=button name='add_to_list<?php echo $frmID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_managersType<?php echo $frmID; ?>'), document.getElementById('dest_managersType<?php echo $frmID; ?>'));"/>
                            <BR><BR><input type=button name='remove_from_list<?php echo $frmID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_managersType<?php echo $frmID; ?>'));"/>
                        </td>


                        <td class="myformtd">
                            <select class="mycontrol" name='arr_dest_managersType<?php echo $frmID; ?>' dir=rtl
                                    id='dest_managersType<?php echo $frmID; ?>' MULTIPLE SIZE=6
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_managersType<?php echo $frmID; ?>'));"
                                    style='width:180px;'></select>
                        </td>

                        <?php

                    }
                    form_label_short("סוג מנהל חדש", TRUE);
                    form_textarea("new_managerType$frmID", array_item($formdata, "new_managerType"), 14, 5, 1, "new_managerType$frmID");
                    form_label_short("קשר לסוג למנהל", TRUE);
                    //                  if(array_item($formdata, "insert_managerType$frmID") )
                    //                  form_list1idx ("insert_managerType$frmID" , $rows2, array_item($formdata, "insert_managerType"), "id=insert_managerType$frmID  multiple size=6");
                    //                  else
                    form_list1("insert_managerType$frmID", $rows2, array_item($formdata, "insert_managerType"), "id=insert_managerType$frmID  multiple size=6");

                    form_url("manager_category.php", "ערוך סוגי מנהלים", 1);
                    echo ' 
  	</tr>
 	</table></div>
 	</td></tr>';


                    /***********************************************DEST_USERS*******************************************************************************/
                    //$formdata["dest_managersType$frmID"]=$formdata["dest_managersType"];
                    echo '<tr><td   class="myformtd" > 
		<div data-module="הזנת  חברי פורום:">
		<table class="myformtable1" style="width:100%; overflow:hidden;">
		<tr>';
                    $forumID = $formdata['forum_decision'];
                    $formdata["src_users$frmID"] = $formdata["src_users"];
                    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
                    $rows = $db->queryArray($sql);


                    echo '<td class="myformtd" style="width:20px;">';

                    form_list111("src_users$forumID", $rows, array_item($formdata, "src_users$forumID"), "multiple size=6 id='src_users$forumID' style='width:160px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_users$forumID'), document.getElementById('dest_users$forumID'));\"");
                    echo '</td>';


                    if ($formdata["dest_users$forumID"] && $formdata["dest_users$forumID"] != 'none' && count($formdata["dest_users$forumID"]) > 0) {
                        $dest_users = $formdata["dest_users$forumID"];

                        foreach ($dest_users as $row) {

                            if (!$result["dest_users"])
                                $result["dest_users"] = $row[userID];
                            else
                                $result["dest_users"] .= "," . $row[userID];

                        }

                        $staff = $result["dest_users"];

                        $sql2 = "select userID, full_name from users where userID in ($staff)";
                        if ($rows = $db->queryObjectArray($sql2))
                            foreach ($rows as $row) {

                                $name[$row->userID] = $row->full_name;

                            }


                        ?>

                        <td class="myformtd" style="width:20px;">

                            <input type=button name='add_to_list<?php echo $forumID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_users<?php echo $forumID; ?>'), document.getElementById('dest_users<?php echo $forumID; ?>'));"/>

                            <BR><BR><input type=button name='remove_from_list();<?php echo $forumID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_users<?php echo $forumID; ?>'));"/>


                        </td>


                        <?php


                        form_list11("dest_users$forumID", $name, array_item($formdata, "dest_users$forumID"), "multiple size=6 id='dest_users$forumID' style='width:160px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_users$forumID'));\"");


                    } elseif ($formdata["src_users$forumID"] && $formdata["src_users$forumID"][0] != 0 && !$formdata["dest_users$forumID"]) {

                        $dest_users = $formdata["src_users$forumID"];

                        for ($i = 0; $i < count($dest_users); $i++) {
                            if ($i == 0) {
                                $userNames = $dest_users[$i];
                            } else {
                                $userNames .= "," . $dest_users[$i];

                            }

                        }


                        $name = explode(",", $userNames);


                        ?>

                        <td class="myformtd" style="width:20px;">
                            <input type=button name='add_to_list<?php echo $forumID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_users<?php echo $forumID; ?>'), document.getElementById('dest_users<?php echo $forumID; ?>'));"/>

                            <BR><BR><input type=button name='remove_fromlist();<?php echo $forumID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_users<?php echo $forumID; ?>'));"/>
                        </td>


                        <?php
                        form_list11("src_users$forumID", $name, array_item($formdata, "src_users$forumID"), "multiple size=6 id='src_users$forumID' ondblclick=\"add_item_to_select_box(document.getElementById('src_users$forumID'), document.getElementById('src_users$forumID'));\"");


                    } else {


                        ?>

                        <td class="myformtd" style="width:20px;">
                            <input type=button name='add_to_list<?php echo $forumID; ?>' value='הוסף לרשימה &gt;&gt;'
                                   OnClick="add_item_to_select_box(document.getElementById('src_users<?php echo $forumID; ?>'), document.getElementById('dest_users<?php echo $forumID; ?>'));"/>
                            <BR><BR><input type=button name='remove_from_list();<?php echo $forumID; ?>'
                                           value='<< הוצא מרשימה'
                                           OnClick="remove_item_from_select_box(document.getElementById('dest_users<?php echo $forumID; ?>'));"/>
                        </td>


                        <td class="myformtd" style="width:20px;">
                            <select class="mycontrol" name="arr_dest_users[]<?php echo $forumID; ?>" dir=rtl
                                    id='dest_users<?php echo $forumID; ?>' MULTIPLE SIZE=6 style='width:160px;'
                                    ondblclick="remove_item_from_select_box(document.getElementById('dest_users<?php echo $forumID; ?>'));"></select>
                        </td>

                        <?php


                    }
                    //echo '</tr>';


                    /*******************************************************************************************************************************/

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


                    echo '<td class="myformtd" >';
                    form_label1("הזנת תאריכים למשתמשים:", true);
                    echo '</td >';


                    echo '<td class="myformtd" colspan="3">';

                    list11("multi_year", $years, array_item($formdata, "multi_year"), " multiple size=6    id='multi_year' ");

                    list11("multi_month", $months, array_item($formdata, "multi_month"), " multiple size=6 id='multi_month' ");

                    list11("multi_day", $days, array_item($formdata, "multi_day"), " multiple size=6        id='multi_day' ");

                    echo '</td>';


                    form_url("print_users", "ערוך משתמשים", 1);


                    echo '</tr>
	 	</table>
	 	</div>
	 	</td>
	 	</tr>';


                    /****************************************************MY_TABLE*****************************************************************************/
                    $frmID = $formdata['forum_decision'];
                    $forum_decName = $formdata['forum_decName'];


                    echo '<tr>';
                    echo '<td   class="myformtd" id="my_Frm_users_td' . $frmID . '">';

                    echo '<fieldset data-module="חברי הפורום:' . $forum_decName . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  id="users_fieldset' . $frmID . '" >';
                    echo '<div  id="content_users' . $frmID . '" class="content_users" style="overflow:hidden;">';
                    echo '<h4 class="my_title_users" style=" height:15px"></h4>';
                    echo '<div   id="my_div_table' . $frmID . '" style="overflow:auto;width:80%;">';


                    //echo   '<div id="user_menue'.$frmID.'" style="display:none;">';
                    //   echo '<tr>';
                    //   echo '<td   class="myformtd">';


                    ?>
                    <table id="my_table_<?php echo $frmID; ?>" style="width:80%;overflow:auto;display:none;">
                        <?php


                        echo '</table>';

                        echo '</div>';
                        echo '</div>';
                        echo '</fieldset>';
                        echo '</td>';
                        echo '</tr>';
                        /********************************************STATUS**************************************************/

                        echo '<tr>
      <td   class="myformtd" > 
      <div style="overflow:hidden;" data-module="סטטוס פורום">  
 
      <table class="myformtable1" style="width:30%;overflow:hidden;">';

                        /////////////////////////////////////////////////////////////////////////////////////////
                        $arr = array();
                        $arr[0][0] = "לא פעיל";
                        $arr[0][1] = "1";
                        $arr[1][0] = "פעיל";
                        $arr[1][1] = "2";

                        $selected = array_item($formdata, 'forum_status') ? array_item($formdata, 'forum_status') : $arr[1][1];
                        echo '<tr><td class="myformtd">
     <div class="form-row" style="float:right;text-color:white;">';

                        ?>

                        <span class="h">סטטוס פורום:&nbsp; &nbsp; </span>&nbsp; &nbsp;
    </div>

    <?php
//echo '<td class="myformtd"> ';
    form_list_find_notd_no_choose("forum_status$frmID", "forum_status$frmID", $arr, $selected);

    echo '</td></tr>', "\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////

    $arr = array();
    $arr[0][0] = "ציבורי";
    $arr[0][1] = "1";
    $arr[1][0] = "פרטי";
    $arr[1][1] = "2";
    $arr[2][0] = "סודי";
    $arr[2][1] = "3";


    $selected = array_item($formdata, 'forum_allowed') ? array_item($formdata, 'forum_allowed') : $arr[0][1];
    echo '<tr> <td class="myformtd"  ><div class="form-row" style="float:right;text-color:white;">';

    ?>

    <span class="h">סיווג פורום:&nbsp; &nbsp; </span>&nbsp; &nbsp; &nbsp;
    </div>
    <?php
    form_list_find_notd_no_choose("forum_allowed$frmID", "forum_allowed$frmID", $arr, $selected);

    echo '</td></tr>', "\n";

////////////////////////////////////////////////////////////////

    echo ' </table></div>
 	   </td>
 	   </tr>';

    /*******************************************************************************************/
    /*********************************************************************************************************************************/
    //TREEVIEW
    /**************************************************************************************************************************************/
    /**************************************************************************************************************************************/
    if (!(ae_detect_ie())) {//FOR $ROWS=FALSE

        $forum_decName = $formdata['forum_decName'];

        echo '<div id="tree_content_target' . $frmID . '" >';

        echo '<tr>';
        echo '<td id="my_tree_td' . $frmID . '">';
        echo '<fieldset data-module="ערוך החלטות של פורום:' . $forum_decName . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form' . $frmID . '">';
        echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
        echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';


        echo '<table   id="tree_content1' . $frmID . '" >';
        echo '<tr>';
        echo '<td>';
        echo '<div id="tree_content_ajx' . $frmID . '"   >';//for toggle


        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';


        echo '</fieldset>';
        echo '</td>';
        echo '</tr>';


        echo '</div>';


//--------------------------------------------------------------------------------

        echo '<div id="tree_content_target2' . $frmID . '" >';

        echo '<tr>';
        echo '<td id="my_tree_td2' . $frmID . '">';
        echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:' . $forum_decName . '"  id="my_form2' . $frmID . '">';
        echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
        echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';


        echo '<table  id="tree_content2' . $frmID . '" >';
        echo '<tr>';
        echo '<td>';
        echo '<div id="tree_content_ajx2' . $frmID . '" class="tree_content" >';


        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';


        echo '</fieldset>';


        echo '</td>';
        echo '</tr>';

        echo '</div>';
    } //-------------------------------------------EXPLORER-------------------------------------------------------------
    else {

        $forum_decName = $formdata['forum_decName'];

        echo '<div id="tree_content_target' . $frmID . '" >';

        echo '<tr>';
        echo '<td id="my_tree_td' . $frmID . '">';
        echo '<fieldset data-module="ערוך החלטות של פורום:' . $forum_decName . '"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form' . $frmID . '">';
        echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
        echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';


        echo '<table   id="tree_content1' . $frmID . '" >';
        echo '<tr>';
        echo '<td>';
        echo '<div id="tree_content_ajx' . $frmID . '"   >';//for toggle


        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';


        echo '</fieldset>';
        echo '</td>';
        echo '</tr>';


        echo '</div>';


//--------------------------------------------------------------------------------

        echo '<div id="tree_content_target2' . $frmID . '" >';

        echo '<tr>';
        echo '<td id="my_tree_td2' . $frmID . '">';
        echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:' . $forum_decName . '"  id="my_form2' . $frmID . '">';
        echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
        echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';


        echo '<table  id="tree_content2' . $frmID . '" >';
        echo '<tr>';
        echo '<td>';
        echo '<div id="tree_content_ajx2' . $frmID . '" class="tree_content" >';


        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';


        echo '</fieldset>';


        echo '</td>';
        echo '</tr>';

        echo '</div>';


    }


//======================================================================================================================
//$sql = "SELECT decName,decID,parentDecID
// 				FROM decisions
// 				WHERE decID = '1962' ";
//
//
//	if($rows = $db->queryObjectArray($sql)){
//
//    $forum_decName=$rows[0]->forum_decName;
//
//
//	  echo '<div id="tree_content_target'.$frmID.'" >'; //for pushing the data   id='".$idTT1."'
//
//		echo '<tr>';
//        echo '<td id="my_tree_td'.$frmID.'">';
//         echo '<fieldset data-module="ערוך החלטות של פורום:'.$forum_decName.'"  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"   id="my_form'.$frmID.'">';
//         echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
//         echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';
//
//
//
//   if($level){
//        echo '<table   id="tree_content1'.$frmID.'" ><tr>';
//
//     }elseif(!($level)){
//    	echo '<table  id="tree_content1'.$frmID.'" ><tr>';
//     }
//  echo '<td>';
//  	echo '<div id="tree_content_ajx'.$frmID.'" class="tree_content"  >';
// treedisplayDown($rows,$formdata);
//    $rootAttributes = array("decID"=>"11" );
//
//    $treeID = "treev1";
//     $tv = DBTreeView::createTreeView(
//		$rootAttributes,
//		TREEVIEW_LIB_PATH,
//		$treeID);
//       $str="ערוך החלטות"	;
//         $tv->setRootHTMLText($str);
//
//  $tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
//    $tv->printTreeViewScript();
// echo '</div>';
// echo '</td>';
// echo '</tr>';
//
// echo '</table>';
//
//
//  echo    '</fieldset>';
// 	   echo '</td>';
//       echo '</tr>';
//
//
//echo '</div>';
//
//
//
////---------------------------------------------------------------------------------------------------------
//
//
// echo '<div id="tree_content_target2'.$frmID.'" >';
//
//  echo '<tr>';
//  echo '<td id="my_tree_td2'.$frmID.'">';
//  echo '<fieldset  class="myformtable1" style="overflow:hidden;margin-left:40px;margin-right:25px;background: #94C5EB url(../images/background-grad.png) repeat-x;overflow:hidden;"  data-module="הצג החלטות בחלון של פורום:'.$forum_decName.'"  id="my_form2'.$frmID.'">';
//  echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
//  echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';
//
//
//
// echo '<table  id="tree_content2" ><tr>';
// echo '<td>';
// echo '<div id="tree_content_ajx2'.$frmID.'" class="tree_content" >';
// treedisplayDown($rows,$formdata);
//   $rootAttributes = array("decID"=>"11","flag_print"=>"1");
//    $treeID = "treev2";
//     $tv1 = DBTreeView::createTreeView(
//		$rootAttributes,
//		TREEVIEW_LIB_PATH,
//		$treeID);
//      $str="צפייה בהחלטות"	;
//
//     $tv1->setRootHTMLText($str);
//    $tv1->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
//
//    $tv1->printTreeViewScript();
//
//echo '</div>';
//echo '</td>';
// echo '</tr>';
// echo '</table>';
//
//
//echo    '</fieldset>';
//
//
//
//  	   echo '</td>';
//        echo '</tr>';
//
//  echo    '</div>';
//
//
//}
//}
//-------------------------------------------END  EXPLORER---------------------------------------------------------

//if(!(ae_detect_ie())){//FOR form_dem_9.php
//
//
//		echo '<div id="tree_content_target'.$frmID.'">'; //for pushing the data
//	 	 //echo '<table style="width:80%;">';
//		echo '<tr>';
//        echo '<td>';
//         echo '<h5 class="my_title_trees_ajx" style=" height:15px"></h5>';
//         echo '<h6 class="my_title_trees_ajx_tab" style=" height:15px"></h6>';
//     if($level){
//        echo '<table class="myformtable1"   style="width:50%;"   id="tree_content1'.$frmID.'" data-module="ערוך החלטות"><tr>';
//     }elseif(!($level)){
//    	echo '<table class="myformtable1"   style="width:50%;" id="tree_content1'.$frmID.'" data-module="הצג החלטות בדף"><tr>';
//     }
//        echo '<td>';
//        echo '<div id="tree_content_ajx'.$frmID.'" class="tree_content" >';
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
///*********************************************************************************************/
//
//
// 	  echo '<tr>';
//        echo '<td>';
//
//        echo '<h5 class="my_title_trees2_ajx" style=" height:15px"></h5>';
//        echo '<h6 class="my_title_trees_ajx_tab2" style=" height:15px"></h6>';
//        echo '<table style="width:50%;"  class="myformtable1" id="tree_content2'.$frmID.'" data-module="הצג החלטות בחלון"><tr>';
//        echo '<td>';
//        echo '<div id="tree_content_ajx2'.$frmID.'" class="tree_content" >';
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
//   //echo '</table>';
//
//
//echo    '</div>';
///*********************************************************************************************/
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
///*********************************************************************************************/
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


// echo '<div id="tree_content_target'.$frmID .'"></div>';

    /***********************************BUTTONS*************************************************************/

    echo '<tr><td class="myformtd">';


    $button_id = $formdata['forum_decision'];
    $forumID = $formdata['forum_decision'];
    $forum_decID = $formdata['forum_decision'];


    ?>
    <div style="overflow:hidden;" data-module="פעולות לביצוע">
        <button class="green90x24" type="submit" value="שמור" ,name="submitbutton_<?php echo $button_id; ?>"
                id="submitbutton_<?php echo $button_id; ?>"
                onclick="return  prepSelObject(document.getElementById('dest_users<?php echo $forumID; ?>')),
                        prepSelObject(document.getElementById('dest_forumsType<?php echo $formdata['forum_decision']; ?>')),
                        prepSelObject(document.getElementById('dest_managersType<?php echo $formdata['forum_decision']; ?>'));">
            שמור/עדכן
        </button>


        <button class="green90x24" type="submit" name="submitbutton3_<?php echo $formdata['forum_decision']; ?>"
                id="submitbutton3_<?php echo $formdata['forum_decision']; ?>"
                onclick="return  prepSelObject(document.getElementById('dest_forumsType<?php echo $formdata['forum_decision']; ?>'))
                        ,prepSelObject(document.getElementById('dest_managersType<?php echo $formdata['forum_decision']; ?>'))
                        ,prepSelObject(document.getElementById('dest_users<?php echo $formdata['forum_decision']; ?>'));">
            העלה מידע
        </button>


        <?php


        if (array_item($formdata, 'dynamic_6')) {
            $x = $formdata['index'];
            $formdata["forum_decID"] = $formdata["forum_decID"][$x];
            $tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
            form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
            form_hidden("forum_decID", $formdata["forum_decID"]);
            form_hidden("insertID", $formdata["insertID"]);
        } else
            $tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
        form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
        form_hidden("forum_decID", $formdata["forum_decID"]);
        form_hidden("insertID", $formdata["insertID"]);


        if (array_item($formdata, "forum_decID") && !$formdata['fail']) {


            form_button2("btnLink1", "קשר לתת פורום");
            form_hidden("forum_decID", $formdata["forum_decID"]);


// form_button1("btnDelete", "מחק פורום", "Submit", "OnClick=\"return document.getElementById('mode_".$formdata["forum_decID"]."').value='delete'\";");
            form_empty_cell_no_td(20);
            form_button_no_td("btnDelete", "מחק פורום", "Submit", "OnClick='return shalom(\"" . $formdata[forum_decID] . "\")'");


        } else {

            form_empty_cell_no_td(10);

            form_button_no_td("btnClear", "הכנס נתונים לפורום/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\";");
        }
        unset($formdata['fail']);
        ?>
        <div id="loading">
            <img src="../images/loading4.gif" border="0"/>
        </div>
        <?php
        echo '</td></tr>';


        ?>

        <div id="loading">
            <img src="../images/loading4.gif" border="0"/>
        </div>


        </table>


        <h4 id="my_menu_items_forum_title<?php echo $formdata['forum_decision']; ?>"
            class="my_menu_items_forum_title<?php echo $formdata['forum_decision']; ?>"
            style="height:15px;cursor:pointer;"></h4>
        <div id="my_error_message<?php echo $formdata['forum_decision']; ?>"
             name="my_error_message<?php $formdata['forum_decision']; ?>"></div>
        <ul id="menu_items_forum<?php echo $formdata['forum_decision']; ?>"
            name="menu_items_forum<?php echo $formdata['forum_decision']; ?>"
            class="menu_items_forum<?php echo $formdata['forum_decision']; ?>">

            <input type=hidden name="menu_items_forum_hidden<?php echo $formdata['forum_decision']; ?>"
                   id="menu_items_forum_hidden<?php echo $formdata['forum_decision'] ?>"
                   value="<?php echo $formdata['forum_decision']; ?>"/>

            <input type=hidden name="forum_decID" id="forum_decID" value="<?php echo $formdata['forum_decision']; ?>"/>
            <input type=hidden name="setupAjaxForm<?php echo $formdata['forum_decision']; ?>"
                   id="setupAjaxForm<?php echo $formdata['forum_decision']; ?>"
                   value="setupAjaxForm<?php echo $formdata['forum_decision']; ?>"/>


            <div id="forum_decision_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision1_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision1_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision2_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision2_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision3_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision3_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision4_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision4_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision5_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision5_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision6_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision6_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision7_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision7_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision8_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision8_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_decision9_<?php echo $formdata['forum_decision']; ?>"
                 name="forum_decision9_<?php echo $formdata['forum_decision']; ?>"></div>
            <div id="forum_<?php echo $formdata['forum_decision']; ?>-message"
                 name="forum_<?php echo $formdata['forum_decision']; ?>-message"></div>
            <div id="forum-message<?php echo $formdata['forum_decision']; ?>"
                 name="forum-message<?php echo $formdata['forum_decision']; ?>"></div>

        </ul>


    </div>


    </fieldset></form>


    <!-- ============================================================================================================ -->

    <div id="page_useredit<?php echo $forum_decID; ?>" style="display:none">

        <h3><?php __('edit_user'); ?></h3>


        <form onSubmit="return saveUser4forum(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>,<?php echo $formdata['forum_decision']; ?>);"
              name="edituser<?php echo $forum_decID; ?>" id="edituser<?php echo $forum_decID; ?>">
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
                <input name="duedate3<?php echo $forum_decID; ?>" id="duedate3<?php echo $forum_decID; ?>" value=""
                       class="duedate3" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off"/>

                <!--<span class="h"><?php __('dueForum'); ?> </span>
     <input name="duedate_1<?php echo $forum_decID; ?>" id="duedate_1<?php echo $forum_decID; ?>" value="" class="in100" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M" autocomplete="off" />
      -->

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
                                                                                              value="" class="in200"
                                                                                              maxlength="50"/></div>

            <div class="form-row"><span class="h"><?php __('user'); ?></span><br> <input type="text" name="user"
                                                                                         id="user<?php echo $forum_decID; ?>"
                                                                                         value="" class="in200"
                                                                                         maxlength="50"/></div>

            <div class="form-row"><span class="h"><?php __('upass'); ?></span><br> <input type="text" name="upass"
                                                                                          id="upass<?php echo $forum_decID; ?>"
                                                                                          value="" class="in200"
                                                                                          maxlength="50"/></div>
            <div class="form-row"><span class="h"><?php __('email'); ?></span><br> <input type="text" name="email"
                                                                                          id="email<?php echo $forum_decID; ?>"
                                                                                          value="" class="in200"
                                                                                          maxlength="50"/></div>
            <div class="form-row"><span class="h"><?php __('phone'); ?></span><br> <input type="text" name="phone"
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
                <input type="submit" value="<?php __('save'); ?>" onClick="this.blur()"/>
                <input type="button" id="my_button_win1<?php echo $forum_decID; ?>"
                       value="<?php __('forum_details'); ?>" class="href_modal1"/>
                <input type="button" id="my_button_usrDetails<?php echo $forum_decID; ?>"
                       value="<?php __('usr_details'); ?>" class="href_modal1"/>
                <input type="button" value="<?php __('cancel'); ?>"
                       onClick="canceluserEdit6(<?php echo $forum_decID; ?>);this.blur();return false"/>
            </div>
        </form>


    </div>  <!-- end of page_user_edit+forum_decID -->


    <!-- ============================================================================================================ -->
    <!-- ===============================================SINGLE_USER_EDIT============================================================= -->
    <!-- ============================================================================================================ -->
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
                    <input name="duedate3" id="duedate3" value="" class="duedate3" title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M"
                           autocomplete="off"/>
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
                                                                                                  value="" class="in200"
                                                                                                  maxlength="50"/></div>

                <div class="form-row"><span class="h"><?php __('user'); ?></span><br> <input type="text" name="user"
                                                                                             id="user" value=""
                                                                                             class="in200"
                                                                                             maxlength="50"/></div>

                <div class="form-row"><span class="h"><?php __('upass'); ?></span><br> <input type="text" name="upass"
                                                                                              id="upass" value=""
                                                                                              class="in200"
                                                                                              maxlength="50"/></div>
                <div class="form-row"><span class="h"><?php __('email'); ?></span><br> <input type="text" name="email"
                                                                                              id="email" value=""
                                                                                              class="in200"
                                                                                              maxlength="50"/></div>
                <div class="form-row"><span class="h"><?php __('phone'); ?></span><br> <input type="text" name="phone"
                                                                                              id="phone" value=""
                                                                                              class="in200"
                                                                                              maxlength="50"/></div>
                <div class="form-row"><span class="h"><?php __('note'); ?></span><br> <textarea name="note" id="note"
                                                                                                class="in500"></textarea>
                </div>
                <div class="form-row"><span class="h"><?php __('tags'); ?></span><br> <input type="text" name="tags"
                                                                                             id="edittags1" value=""
                                                                                             class="in500"
                                                                                             maxlength="250"/></div>
                <div class="form-row">

                    <input type="submit" id="edit_usr" value="<?php __('save'); ?>" onClick="this.blur()"/>
                    <input type="button" id="my_button_usrDetails" value="<?php __('usr_details'); ?>"
                           class="href_modal1"/>


                    <input type="button" value="<?php __('cancel'); ?>"
                           onClick="canceluserEdit3();this.blur();return false"/>
                </div>
            </form>

        </div> <!--  end div content -->

    </div> <!--  end of page_user_edit -->


    <!-- ============================================================================================================ -->

    </div>

    <script>

        var forum_decID =<?php echo $formdata['forum_decision']; ?>

        var countJson;

        <?php
        $forum_decID = $formdata['forum_decision'];

        $func_name = "setupAjaxForm$forum_decID";


        ?>


        function <?php echo $func_name; ?>(form_id, form_validations) {
            // alert(form_id);
            var form = '#' + form_id;
            var form_message = form + '-message';
            var forum_decID =<?php echo $formdata['forum_decision']; ?>;  //document.getElementById('forum_decID').value;


            // setup loading message
            $(form).ajaxSend(function () {
                //$(form_message).removeClass().addClass('loading').html('Loading...').fadeIn();
                $("#form-message" + forum_decID).removeClass().addClass('loading').html('Loading...').fadeIn();

            });


            var options = {

                beforeSubmit: showRequest,

                // pre-submit callback

                success: processJson,

                dataType: 'json'
            };


            // bind form using 'ajaxForm'
            $('#forum_' + forum_decID).ajaxForm(options);


            function showRequest(formData, jqForm) {

                var extra = [{name: 'json', value: '1'}];
                $.merge(formData, extra)

                return true;
            }

            /**********************************************************************************************/

// post-submit callback
            function processJson(data) {
                theme = {

                    newUserFlashColor: '#ffffaa',
                    editUserFlashColor: '#bbffaa',
                    errorFlashColor: '#ffffff'
                };
                countJson = data;
                countJson1 = data;

                var forum_decID =<?php echo $formdata['forum_decision']; ?>;  //document.getElementById('forum_decID').value;
                countJson = data;

                var countList = '';
                var forumList = '';
                var forumList = '';
                var managerList = '';
                var appointList = '';
                var countList1 = '';
                var countList2 = '';
                var countList3 = '';
                var infoList = '';
                var categoryList = '';
                var manager_typeList = '';
                var frm = {};
                var decList = '';


//////////////////////////////////////////////////////////
                if (data.type == 'success') {//////////////////////////
////////////////////////////////////////////////////////

                    var forum_decID =<?php echo $formdata['forum_decision']; ?>;

                    frm.forum_decID = forum_decID;
                    $('#menu_items_forum' + forum_decID).show();
                    $('#my_error_message' + forum_decID).hide();

                    $('#my_table_' + forum_decID).show();

                    $('#manager_date' + forum_decID).val(data.manager_date);


                    $("#page_useredit" + forum_decID).draggable({
                        stop: function (e, ui) {
                            flag.windowTaskEditMoved = true;
                            tmp.editformpos = [$(this).css('left'), $(this).css('top')];
                        }
                    });
                    $("#edittags1" + forum_decID).autocomplete('../admin/ajax2.php?suggestuserTags', {
                        scroll: false,
                        multiple: true,
                        selectFirst: false,
                        max: 8
                    });
                    $("#tags" + forum_decID).autocomplete('../admin/ajax2.php?suggestuserTags', {
                        scroll: false,
                        multiple: true,
                        selectFirst: false,
                        max: 8
                    });


                    /***************************************************************************************************/
                    $('#my_button_win1' + forum_decID).css({'background': '#B4D9D7'}).bind('click', function () {

                        var link = '../admin/find3.php?&forum_decID=' + forum_decID;
                        openmypage3(link);

                        return false;
                    });

                    /***************************************************************************************************/

                    $("#forum-message" + forum_decID).removeClass().addClass(data.type).html(data.message).fadeIn('slow').css({'background': '#ffdddd'}).css({'margin-right': '90px'});


                    /**********************************NEW_APPOINT************************************************************/

                    if ($('#new_appoint' + forum_decID).val() && !($('#new_appoint' + forum_decID).val() == 'none')) {
                        var new_appointItem = $("#new_appoint" + forum_decID + " :selected").text();

                        $('#appoint_forum' + forum_decID).append('<option value=' + data.appoint_forum + '>' + new_appointItem + '</option>').attr("selected", 'selected');
                        $('#appoint_forum' + forum_decID).val(data.appoint_forum).attr('selected', 'selected');
                        $('#new_appoint' + forum_decID).val('');

                        var insert_appoint = ( $('#insert_appoint' + forum_decID).val());
                        if (insert_appoint) {
                            $('#insert_appoint' + forum_decID).val('');
                        }

                    }

                    /**********************************NEW_MANAGER************************************************************/

                    if ($('#new_manager' + forum_decID).val() && !($('#new_manager' + forum_decID).val() == 'none')) {
                        var new_managerItem = $("#new_manager" + forum_decID + " :selected").text();
                        var new_managerItem2 = $('#new_manager' + forum_decID).val();
                        $('#manager_forum' + forum_decID).append('<option value=' + data.manager_forum + '>' + new_managerItem + '</option>').attr("selected", 'selected');
                        $('#manager_forum' + forum_decID).val(data.manager_forum).attr('selected', 'selected');
                        $('#new_manager' + forum_decID).val('');

                        var insert_manager = ( $('#insert_manager' + forum_decID).val());
                        if (insert_manager) {
                            $('#insert_manager' + forum_decID).val('');
                        }

                    }


                    /************************************NEW_FORUMS_TYPE*********************************************************/


                    if ($('#new_forumType' + forum_decID).val() && !($('#new_forumType' + forum_decID).val() == 'none')) {
                        var newItem = $('#new_forumType' + forum_decID).val();
                        $('#src_forumsType' + forum_decID).append('<option value=' + data.dest_forumsType[0].catID + '>' + newItem + '</option>').attr("selected", true);

                        $('#dest_forumsType' + forum_decID).html(' ');
                        $('#dest_forumsType' + forum_decID).append('<option value=' + data.dest_forumsType[0].catID + '>' + newItem + '</option>').attr("selected", true);

                        $('#new_forumType' + forum_decID).val('');


                        /***********************************************************************************/
                        $('#src_forumsType' + forum_decID).empty().append('<select name="src_forumsType' + forum_decID + '" id="src_forumsType' + forum_decID + '" >\n');


////////////////////////////////////////////////////////////////////////////
                        $.each(data.frmType, function (i, item) {
////////////////////////////////////////////////////////////////////////////

                            var listentry = listentry ? listentry : item[0];
                            listentry = listentry.replace(/^[ \t]+/gm, function (x) {
                                return new Array(x.length + 1).join('&nbsp;')
                            });

                            $('#src_forumsType' + forum_decID).append("<OPTION   value=" + item[1] + " " + (item[0] == newItem ? "Selected" : "") + ">" + listentry + "</option>\n");

                        });
                        $('#src_forumsType' + forum_decID).append($('</select>'));


                        if ($('#insert_forumType' + forum_decID).val() && !($('#insert_forumType' + forum_decID).val() == 'none')) {
                            var val_insert = $('#insert_forumType' + forum_decID).val();
                            $('#insert_forumType' + forum_decID).append('<option value=' + data.dest_forumsType[0].catID + '>' + newItem + '</option>').attr("selected", true);
                        }

                    }

                    /****************************************************************************************************************/
                    /*******************************************NEW_MGR_TYPE*********************************************************/


                    if ($('#new_managerType' + forum_decID).val() && !($('#new_managerType' + forum_decID).val() == 'none')) {
                        var newItem = $('#new_managerType' + forum_decID).val();
                        $('#src_managersType' + forum_decID).append('<option value=' + data.dest_managersType[0].catID + '>' + newItem + '</option>').attr("selected", true);

                        $('#dest_managersType' + forum_decID).html(' ');
                        $('#dest_managersType' + forum_decID).append('<option value=' + data.dest_managersType[0].catID + '>' + newItem + '</option>').attr("selected", true);

                        $('#new_managerType' + forum_decID).val('');


                        /***********************************************************************************/
                        $('#src_managersType' + forum_decID).empty().append('<select name="src_managersType' + forum_decID + '" id="src_managersType' + forum_decID + '" >\n');


////////////////////////////////////////////////////////////////////////////
                        $.each(data.mgrType, function (i, item) {
////////////////////////////////////////////////////////////////////////////

                            var listentry = listentry ? listentry : item[0];
                            listentry = listentry.replace(/^[ \t]+/gm, function (x) {
                                return new Array(x.length + 1).join('&nbsp;')
                            });

                            $('#src_managersType' + forum_decID).append("<OPTION   value=" + item[1] + " " + (item[0] == newItem ? "Selected" : "") + ">" + listentry + "</option>\n");

                        });
                        $('#src_managersType' + forum_decID).append($('</select>'));


                        if ($('#insert_managerType' + forum_decID).val() && !($('#insert_managerType' + forum_decID).val() == 'none')) {
                            var val_insert = $('#insert_managerType' + forum_decID).val();
                            $('#insert_managerType' + forum_decID).append('<option value=' + data.dest_managersType[0].catID + '>' + newItem + '</option>').attr("selected", true);
                        }

                    }


                    /**********************************NEW_FORUM************************************************************/

                    if ($('#new_forum' + forum_decID).val()) {
                        var newItem = $('#new_forum' + forum_decID).val();
                        $('#forum_decision_link' + forum_decID).append('<option value=' + data.forum_decID + '>' + newItem + '</option>').attr("selected", 'selected');
                        $('#forum_decision_link' + forum_decID).val(data.forum_decID).attr('selected', 'selected');

                        $('#new_forum' + forum_decID).val('');


                        var insertID = ( $('#insert_forum' + forum_decID).val());
                        var frmID = ( $('#forum_decision_link' + forum_decID).val());

                        data_a = new Array();
                        data_a[0] = insertID;
                        data_a[1] = frmID;


                        $.ajax({
                            type: "POST",
                            url: "dynamic_9.php",
                            data: "entry=" + data_a,
                            success: function (msg) {
                                $('#my_forum_entry_first' + forum_decID).remove();


                                $('div#forum_decision_tree' + forum_decID).html(' ').append('<p>' + msg + '</p>');

                            }
                        });

                        $(form_message).removeClass().addClass('loading').html(' ').fadeOut();

                    }

                    /***********************************************FORUM_DEC*********************************************************/
                    countList += '<li><a href="../admin/find3.php?forum_decID=' + data.forum_decision + '"  class="maplink" >' + data.forum_decName + '</a></li>';

                    $('#forum_decision1_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow');

                    $('#forum_decision1_' + forum_decID).html('<ul id="countList1"><b style="color:#800137;">שם הפורום' + countList + '</b></ul>').find('a.maplink').each(function (i) {

                        var index = $('a.maplink').index(this);
                        var v = countJson.forum_decName;
                        var id = countJson.forum_decID;
                        /*****************************************CLICK****************************/
                        $(this).click(function () {
                            $.get('../admin/find3.php?forum_decID=' + id + '', $(this).serialize(), function (data) {


                                $('#forum_decision_' + forum_decID)
                                    .addClass('forum_decision_' + forum_decID).css({'width': '82%'})
                                    .css({'height': '300px'})
                                    .css({'margin-right': '90px'})
                                    .css({'padding': '5px'})
                                    .css({'overflow': 'scroll'})
                                    .css({'background': '#2AAFDC'})
                                    .css({'border': '3px solid #666'});


                                $('#forum_decision_' + forum_decID).html(data);


                            });


                            return false;
                        });

                    });//end forum_dec
                    /***************************************MANAGER**********************************************/
                    $('#forum_decision3_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow');
                    managerList += '<li><a href="../admin/find3.php?managerID=' + data.manager_forum + '"  class="mng" >' + data.managerName + '>>' + data.manager_date + '</a></li>';

                    $('#forum_decision3_' + forum_decID).html('<ul id="managerList1"><b style="color:#800137;"> מרכז ועדה' + managerList + '</b></ul>').find('a.mng').each(function (i) {
                        var index = $('a.mng').index(this);
                        var v = countJson.managerName;
                        var mng_id = countJson.manager_forum;
                        /*****************************************CLICK****************************/
                        $(this).click(function () {
                            $.get('../admin/find3.php?managerID=' + mng_id + '', $(this).serialize(), function (data) {

                                $('#forum_decision_' + forum_decID)
                                    .addClass('forum_decision_' + forum_decID).css({'width': '82%'})
                                    .css({'height': '400px'})
                                    .css({'margin-right': '90px'})
                                    .css({'padding': '5px'})
                                    .css({'overflow': 'scroll'})
                                    .css({'background': '#B4D9D7'})
                                    .css({'border': '3px solid #666'})

                                    .css({'scrollbar-face-color': 'white'})
                                    .css({'scrollbar-highlight-color': 'yellow'})
                                    .css({'scrollbar-3dlight-color': '#000000'})
                                    .css({'scrollbar-shadow-color': '#000000'})
                                    .css({'scrollbar-darkshadow-color': '#000000'})
                                    .css({'scrollbar-track-color': 'blue'})
                                    .css({'scrollbar-arrow-color': 'red'});


                                $('#forum_decision_' + forum_decID).html(data);


                            });


                            return false;
                        });

                    });//end manager

                    /***************************************APPOINT*********************************************/
                    $('#forum_decision4_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow');
                    appointList += '<li><a href="../admin/find3.php?appointID=' + data.appoint_forum + '"  class="app" >' + data.appointName + '>>' + data.appoint_date1 + '</a></li>';

                    $('#forum_decision4_' + forum_decID).html('<ul id="appointList1"><b style="color:#800137;">ממנה ועדה' + appointList + '</b></ul>').find('a.app').each(function (i) {
                        var index = $('a.app').index(this);
                        var appointName = countJson.appointName;
                        var app_id = countJson.appoint_forum;
                        /*****************************************CLICK*********************************************/
                        $(this).click(function () {
                            $.get('../admin/find3.php?appointID=' + app_id + '', $(this).serialize(), function (data) {

                                $('#forum_decision_' + forum_decID)
                                    .addClass('forum_decision_' + forum_decID).css({'width': '82%'})
                                    .css({'height': '400px'})
                                    .css({'margin-right': '90px'})
                                    .css({'padding': '5px'})
                                    .css({'overflow': 'scroll'})
                                    .css({'background': '#2CE921'})
                                    .css({'border': '3px solid #666'});


                                $('#forum_decision_' + forum_decID).html(data);


                            });


                            return false;
                        });

                    });//end appoint


                    /************************************************************MANAGER_TYPE**********************************************************************/
                    $.each(data.dest_managersType, function (i) {


                        var managerTypeName = this.managerTypeName;

                        var managerTypeID = countJson.dest_managersType[i].managerTypeID;

                        var url = '../admin/';
                        var idx = i;


                        manager_typeList += '<li><a href="../admin/find3.php?managerTypeID=' + managerTypeID + '"  class="type_manager" >' + this.managerTypeName + '</a></li>';


                    });

                    /**************************************************************************************************************/


                    $('#forum_decision5_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'}).fadeIn('slow');
                    $('#forum_decision5_' + forum_decID).html('<ol id="manager_typeList1"><b style="color:#800137;">סוג מנהל/ים' + manager_typeList + '</b></ol>').find('a.type_manager').each(function (i) {

                        var index = $('a.type_manager').index(this);
                        var v = countJson.managerTypeName;
                        var id = countJson.dest_managersType[i].managerTypeID;
                        /*****************************************CLICK***************************************************/
                        $(this).click(function () {
                            $.get('../admin/find3.php?managerTypeID=' + id + '', $(this).serialize(), function (data) {


                                $('#forum_decision_' + forum_decID)
                                    .addClass('forum_decision' + forum_decID).css({'width': '82%'})
                                    .css({'height': '400px'})
                                    .css({'margin-right': '100px'})
                                    .css({'padding': '5px'})
                                    .css({'overflow': 'scroll'})
                                    .css({'background': '#C6EFF0'})
                                    .css({'border': '3px solid #666'});
//.css({'scrollbar-face-color' : 'white'})
//.css({'scrollbar-highlight-color' : 'yellow'})
//.css({'scrollbar-3dlight-color' : '#000000'})
//.css({'scrollbar-shadow-color' : '#000000'})
//.css({'scrollbar-darkshadow-color' : '#000000'})
//	.css({'scrollbar-track-color' : 'blue'})
//		.css({'scrollbar-arrow-color' : 'red'});


                                $('#forum_decision_' + forum_decID).html(data);


                            });


                            return false;
                        });
                        $('#forum_decision_' + forum_decID).html(' ');
                    });//end manager/type


                    /***************************************DEST_FORUMS_TYPE******************************************************************/
                    $.each(data.dest_forumsType, function (i) {


                        var catName = this.catName;
                        var catID = countJson.dest_forumsType[i].catID;

                        var url = '../admin/';
                        var idx = i;


                        categoryList += '<li><a href="../admin/find3.php?cat_forumID=' + catID + '"  class="cat" >' + this.catName + '</a></li>';


                    });

                    /**************************************************************************************************************/

                    $('#forum_decision6_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'}).fadeIn('slow');
                    $('#forum_decision6_' + forum_decID).html('<ol id="categoryList1"><b style="color:#800137;">סוג הפורום/ים' + categoryList + '</b></ol>').find('a.cat').each(function (i) {

                        var index = $('a.cat').index(this);
                        var v = countJson.catName;
                        var id = countJson.dest_forumsType[i].catID;
                        /*****************************************CLICK***************************************************/
                        $(this).click(function () {
                            $.get('../admin/find3.php?cat_forumID=' + id + '', $(this).serialize(), function (data) {


                                $('#forum_decision_' + forum_decID)
                                    .addClass('forum_decision' + forum_decID).css({'width': '82%'})
                                    .css({'height': '400px'})
                                    .css({'margin-right': '90px'})
                                    .css({'padding': '5px'})
                                    .css({'overflow': 'scroll'})
                                    .css({'background': '#8EF6F8'})
                                    .css({'border': '3px solid #666'});


                                $('#forum_decision_' + forum_decID).html(data);


                            });


                            return false;
                        });
                        $('#forum_decision_' + forum_decID).html(' ');
                    });//end decision/type


                    /********************************GENERAL_INFORMATION*******************************************/
                    $('#forum_decision7_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).fadeIn('slow').css({'margin-right': '90px'});
                    infoList += '<li><a href="../admin/forum_demo12.php"  class="my_msg" ><b style="color:#800137;">מידע כללי</b> </a></li>';

                    $('#forum_decision7_' + forum_decID).html('<ul id="infoList1">' + infoList + '</ul>').find('a.my_msg').each(function (i) {
                        var index = $('a.my_msg').index(this);

                        /*****************************************CLICK****************************/
                        $(this).click(function () {
                            $.get('../admin/forum_demo12.php', $(this).serialize(), function (data) {

                                $('#forum_decision_' + forum_decID)
                                    .addClass('forum_decision_' + forum_decID).css({'width': '82%'})
                                    .css({'height': '400px'})
                                    .css({'margin-right': '90px'})
                                    .css({'padding': '5px'})
                                    .css({'overflow': 'scroll'})
                                    .css({'background': '#AE77BE'})
                                    .css({'border': '3px solid #666'});


                                $('#forum_decision_' + forum_decID).html(data);


                            });


                            return false;
                        });

                    });//end general info
                    /**********************************************************USERS***********************************/


                    if (data.dest_users) {

                        var name = '';
                        var url = '../admin/';

                        $.each(data.dest_users, function (i) {


                            var name = this.full_name;
                            var user_id = countJson.dest_users[i].userID;
                            var url = '../admin/';
                            var idx = i;


                            countList3 += '<li class="my_user_li"><a href="../admin/find3.php?userID=' + this.userID + '"  class="usr" >' + this.full_name + '>>' + data.member_date[i] + '</a></li>';


                        });

                        /****************************************************************************************************/


                        $('#my_table_' + forum_decID).empty();
                        if (!forum_decID) {
                            var forum_decID = document.getElementById('forum_decID').value;

                            if (!(forum_decID) || forum_decID == 'undefine')
                                forum_decID = data.forum_decID;
                        }
                        /*****************************************************************/
                        if (data.add_frmID) {
                            var forum_decID2 = parseInt(forum_decID);
                            forum_decID2 += 1;
                        }
                        /************************************************************/
                        tz = -1 * (new Date()).getTimezoneOffset();
                        nocache = '&rnd=' + Math.random();
                        data.insertID = data.insertID ? data.insertID : data.insert_forum;
                        $.getJSON(url + 'ajax2.php?find_frmID=&forum_decName=' + data.forum_decName + '&insertID=' + data.insertID + '&tz=' + tz + nocache, function (json) {
                            var forum_id = '';

                            forum_id = json.list[0].forum_decID;


                            /****************************************************************/
                            $.each(data.dest_users, function (i) {
                                var name = data.dest_users[i].full_name;
                                var url = '../admin/';

                                var usr_id = data.dest_users[i].userID ? data.dest_users[i].userID : data.dest_users[i];
                                var idx = i;

                                if (data.dest_users[i].userID != undefined) {

                                    var usr_id = data.dest_users[i].userID ? data.dest_users[i].userID : data.dest_users[i];
                                    var idx = i;

                                    var status = '';


                                    var active = data.active[usr_id];

                                    if (active == 2)
                                        status = 1;
                                    else
                                        status = 0;


//to check about forum_decID
                                    $('#my_table_' + forum_decID).append($("<tr>\n" +

                                        '<td id="my_active' + usr_id + forum_id + '">' +
                                        '<a href="javascript:void(0)" onclick="edit_active(' + usr_id + ',' + forum_id + ',\'' + url + '\',' + active + '); return false;">' +
                                        '<img src="../images/icon_status_' + status + '.gif" width="16" height="10" alt="" border="0" />' +
                                        '</a>' +
                                        '</td>' +

                                        "<td class='myformtd'>\n" +

                                        "חבר פורום: <input type='text' name='member'  class='mycontrol'  value=\'" + data.dest_users[idx].full_name + "\'  />\n" +
                                        '<input type="button"  class="mybutton"  id="my_button_' + usr_id + forum_id + '"   value="ערוך מישתמש"  onClick="return editUser_frmID(' + usr_id + ',' + forum_id + ',\'' + url + '\',' + idx + ');" />\n' +
                                        " תאריך צרוף לפורום:<input type='text' name='form[member_date" + idx + "]'  id='member_date" + idx + "'  class='mycontrol dp'   size=10  value=" + data.member_date[idx] + "  />\n" +

                                        "</td>\n" +
                                        "</tr>\n"
                                    ));

                                }

                                $(function () {
                                    $('.dp').datepicker($.extend({}, {
                                        showOn: 'button',
                                        buttonImage: '../images/calendar.gif', buttonImageOnly: true,
                                        changeMonth: true,
                                        changeYear: true,
                                        showButtonPanel: true,
                                        buttonText: "Open date picker",
                                        dateFormat: 'dd-mm-yy',
                                        altField: '#actualDate'
                                    }, $.datepicker.regional['he']));
                                });

                            });

                            /********************************************************************************************************/
                            $('#forum_decision2_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow');

                            $('#forum_decision2_' + forum_decID).html('<ol id="countList3"><b style="color:#800137;">חברי הפורום' + countList3 + '</b></ol>').find('a.usr').each(function (i) {
                                var index = $('a.usr').index(this);
                                var v = countJson.full_name;
                                var userid = countJson.dest_users[i].userID;


                                /*****************************************CLICK*************************************************************/
                                $(this).click(function () {
                                    $.get('../admin/find3.php?userID=' + userid + '', $(this).serialize(), function (data) {

                                        $('#forum_decision_' + forum_decID)
                                            .addClass('forum_decision_' + forum_decID).css({'width': '82%'})
                                            .css({'height': '400px'})
                                            .css({'margin-right': '90px'})
                                            .css({'padding': '5px'})
                                            .css({'overflow': 'scroll'})
                                            .css({'background': '#ffdddd'})
                                            .css({'border': '3px solid #666'}
                                            );


                                        $('#forum_decision_' + forum_decID).html(data);

                                    });


                                    return false;
                                });//end click

                                //$('#forum_decision'+forum_decID).html(' ');
                            });//end  $('#forum_decision2')

                        });//end getJson
                    }//end dst_user

                    /************************************************************DECISIONS**********************************************************************/
                    if (data.decision) {

                        $.each(data.decision, function (i) {


                            var decName = this.decName;
                            var decID = countJson.decision[i].decID;

                            var url = '../admin/';
                            var idx = i;


                            decList += '<li><a href="../admin/find3.php?decID=' + decID + '"  class="dec_find" >' + this.decName + '</a></li>';


                        });

                        /**************************************************************************************************************/

                        $('#forum_decision9_' + forum_decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'}).fadeIn('slow');
                        $('#forum_decision9_' + forum_decID).html('<ol id="decList1"><b style="color:#800137;">החלטה/ות' + decList + '</b></ol>').find('a.dec_find').each(function (i) {

                            var index = $('a.dec_find').index(this);
                            var v = countJson.decName;
                            var id = countJson.decision[i].decID;
                            /*****************************************CLICK***************************************************/
                            $(this).click(function () {
                                $.get('../admin/find3.php?decID=' + id + '', $(this).serialize(), function (data) {


                                    $('#forum_decision_' + forum_decID)
                                        .addClass('forum_decision_' + forum_decID).css({'width': '79%'})
                                        .css({'height': '400px'})
                                        .css({'margin-right': '60px'})
                                        .css({'padding': '5px'})
                                        .css({'overflow': 'hidden'})
                                        .css({'overflow': 'scroll'})
                                        .css({'background': '#8EF6F8'})
                                        .css({'border': '3px solid #666'});


                                    $('#forum_decision_' + forum_decID).html(data);


                                });


                                return false;
                            });
                            $('#forum_decision_' + forum_decID).html(' ');
                        });//end decision
                    }
                    /**************************************************************************/


                }//end success
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                else {
                    var forum_decID = data.forum_decID;

                    $.each(data, function (i, item) {
                        var messageError = i;

                        $("#forum-message" + forum_decID).html(' ').fadeIn();
                        if (messageError != 'forum_decID')
                            countList2 += '<li class="error">' + item + '</li>';
                    });

                    $('#my_error_message' + forum_decID).html('<ul id="countList_check' + forum_decID + '">' + countList2 + '</ul>').css({'margin-right': '90px'});
                    $('#my_error_message' + forum_decID).append($('<p ID="bgchange' + forum_decID + '"   ><b style="color:blue;">הודעת שגיאה!!!!!</b></p>\n'));
                    $('.error').draggable();
                    if ($('#menu_items_forum_hidden' + forum_decID).val()) {
                        $('#menu_items_forum' + forum_decID).hide();
                    }
                    $('#my_error_message' + forum_decID).show();
                    turn_red3(forum_decID);

                }
                /***********************************************************************/


                /************************************************************************************************/
            }//end proccess
            /************************************************************************************************/
        }//end function
        /************************************************************************************************/
        $(document).ready(function () {
            var forum_decID =<?php echo $formdata['forum_decision']; ?> ;

            <?php
            $func_name = "setupAjaxForm$forum_decID";
            ?>
            new <?php echo $func_name;?>('forum_' + forum_decID);

            var count_form =<?php echo $formdata['form_index'];?>;

            turn_red_error();
            /*******************************TOGGLE_MENU_ITEM*******************************************/

            $(".my_menu_items_forum_title" + forum_decID).addClass('link');
            $(".my_menu_items_forum_title" + forum_decID).toggle(
                function () {


                    $(this).addClass('hover');
                    $("ul#menu_items_forum" + forum_decID + "").slideToggle('slow');
                },
                function () {
                    $(this).removeClass('hover');
                    $("ul#menu_items_forum" + forum_decID + "").slideToggle('slow');
                }
            );


            /*******************************************************/
            //TOGGLE DIV IE
            /******************************************************/
            if (($.browser.msie == true)) {
                $(".my_title_trees_ajx_tab").hide();
                $(".my_title_trees_ajx_tab2").hide();
                $(".my_title_trees_ajx").show();
                $(".my_title_trees2_ajx").show();
                $(".my_title_trees_ajx").css({'cursor': 'pointer'}).addClass('link');
                $(".my_title_trees_ajx").toggle(
                    function () {


                        $(this).addClass('hover');
                        $("#tree_content_ajx" + forum_decID).slideToggle('slow');
                    },
                    function () {
                        $(this).removeClass('hover');
                        $("#tree_content_ajx" + forum_decID).slideToggle('slow');
                    }
                );


                $(".my_title_trees2_ajx").css({'cursor': 'pointer'}).addClass('link');
                $(".my_title_trees2_ajx").toggle(
                    function () {


                        $(this).addClass('hover');
                        $("#tree_content_ajx2" + forum_decID).slideToggle('slow');
                    },
                    function () {
                        $(this).removeClass('hover');
                        $("#tree_content_ajx2" + forum_decID).slideToggle('slow');
                    }
                );
            } else {
                /*******************************************************/
                //TOGGLE TABLE  FF
                /*******************************************************/

                $(".my_title_trees_ajx").hide();
                $(".my_title_trees2_ajx").hide();
                $(".my_title_trees_ajx_tab").show();
                $(".my_title_trees_ajx_tab2").show();

                $(".my_title_trees_ajx_tab").css({'cursor': 'pointer'}).addClass('link');
                $(".my_title_trees_ajx_tab").toggle(
                    function () {


                        $(this).addClass('hover');
                        $("#tree_content1" + forum_decID).slideToggle('slow');
                    },
                    function () {
                        $(this).removeClass('hover');
                        $("#tree_content1" + forum_decID).slideToggle('slow');
                    }
                );


                $(".my_title_trees_ajx_tab2").css({'cursor': 'pointer'}).addClass('link');
                $(".my_title_trees_ajx_tab2").toggle(
                    function () {


                        $(this).addClass('hover');
                        $("#tree_content2" + forum_decID).slideToggle('slow');
                    },
                    function () {
                        $(this).removeClass('hover');
                        $("#tree_content2" + forum_decID).slideToggle('slow');
                    }
                );

            }//end else


            /*******************TOGGLE_USERS_FRM***********************************/
            $(".my_title_users").css({'cursor': 'pointer'}).addClass('link');
            $(".my_title_users").toggle(
                function () {


                    $(this).addClass('hover');
                    $(this).parent().find('#my_div_table' + forum_decID).slideToggle();
                },
                function () {
                    $(this).removeClass('hover');
                    $(this).parent().find('#my_div_table' + forum_decID).slideToggle();
                }
            );

            /*************************************************************************/

            $('#forum_date' + forum_decID).datepicker($.extend({}, {
                showOn: 'button',
                buttonImage: '../images/calendar.gif', buttonImageOnly: true,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                buttonText: "Open date picker",
                dateFormat: 'yy-mm-dd',
                altField: '#actualDate'


            }, $.datepicker.regional['he']));

            /*************************************************************************/
            $('#appoint_date1' + forum_decID).datepicker($.extend({}, {
                showOn: 'button',
                buttonImage: '../images/calendar.gif', buttonImageOnly: true,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                buttonText: "Open date picker",
                dateFormat: 'yy-mm-dd',
                altField: '#actualDate'
            }, $.datepicker.regional['he']));
            /**************************************************************************/

            $('#manager_date' + forum_decID).datepicker($.extend({}, {
                showOn: 'button',
                buttonImage: '../images/calendar.gif', buttonImageOnly: true,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                buttonText: "Open date picker",
                dateFormat: 'yy-mm-dd',
                altField: '#actualDate'
            }, $.datepicker.regional['he']));
            /**************************************************************************/

            $('.duedate3').datepicker($.extend({}, {
                showOn: 'button',
                buttonImage: '../images/calendar.gif', buttonImageOnly: true,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                buttonText: "Open date picker",
                dateFormat: 'yy-mm-dd',
                altField: '#actualDate'
            }, $.datepicker.regional['he']));
            /**************************************************************************/


            $(".my_Frmtitles_" + forum_decID).css({'cursor': 'pointer'}).addClass('link');
            $(".my_Frmtitles_" + forum_decID).toggle(
                function () {


                    $(this).addClass('hover');
                    $("#main_content" + forum_decID).slideToggle();
                },
                function () {
                    $(this).removeClass('hover');
                    $("#main_content" + forum_decID).slideToggle();
                }
            );


            /*****************************************************************************************************/


            if ($.browser.mozilla == true) {
                $(function () {
                    $('#menu_items_forum' + forum_decID).sortable();
                    $("#forum_decision").bind("mousedown", function () {
                        return false;
                    });
                });
            } else {
                $('#menu_items_forum' + forum_decID).sortable();

            }


            /***********************************CHANGE_CONN_ENTRY1************************************************************/
            /***********************************CHANGE_CONN_ENTRY1************************************************************/
            /***********************************CHANGE_CONN_ENTRY1************************************************************/
            $('#my_forumFieldset' + forum_decID).prepend('<div id="my_forum_entry_b' + forum_decID + '"></div>').find('select#insert_forum' + forum_decID).change(function () {
                if ($('#forum_decision_link' + forum_decID).val() && $('#newforum' + forum_decID).val()) {
                    return;
                }
                var frmID = ( $('#forum_decision_link' + forum_decID).val());
                data_a = new Array();
                data_a[0] = this.value;
                data_a[1] = frmID;

                $.ajax({
                    type: "POST",
                    url: "dynamic_9.php",
                    data: "entry=" + data_a,
                    success: function (msg) {

                        $('#my_forum_entry_first' + forum_decID).remove();


                        $('div#forum_decision_tree' + forum_decID).html(' ').append('<p>' + msg + '</p>');

                    }
                });


                $(form_message).removeClass().addClass('loading').html(' ').fadeOut();
            });


            /***********************************READ_DATA_CHANGE_SELECT***************************************************************/
            $('#my_forumFieldset' + forum_decID).find('select#forum_decision_link' + forum_decID).change(function () {
                var forum_decName = $("#forum_decision_link" + forum_decID + " :selected").text();

                $('#menu_items_forum_8').hide();
                tz = -1 * (new Date()).getTimezoneOffset();
                nocache = '&rnd=' + Math.random();
                var insertID = '';
                var frmID = ( $('#forum_decision_link' + forum_decID).val());
                var option_str = 'none';
                /*************************************************GET_JSON**********************************************************************/


                $.getJSON('dynamic_10.php?read_data2&editID=' + frmID + '&tz=' + tz + nocache, function (json) {


//////////////////////////////////////////////////////////////////////////////////////////////
                    $.each(json.formdata, function (i, item) {
//////////////////////////////////////////////////////////////////////////////////////////////

                        $('#treev1').empty();
                        $('#treev2').empty();


                        insertID = item.insert_forum;
                        data_a = new Array();
                        data_a[0] = insertID;
                        data_a[1] = frmID;
                        /*****************************INIT***************************************/
                        document.getElementById('forum_decision_link' + forum_decID).value = item.forum_decision;
                        document.getElementById('forum_date' + forum_decID).value = (item.forum_date);
                        document.getElementById('appoint_date1' + forum_decID).value = (item.appoint_date);
                        document.getElementById('manager_date' + forum_decID).value = (item.manager_date);
                        document.getElementById('appoint_forum' + forum_decID).value = (item.appoint_forum);
                        document.getElementById('insert_forum' + forum_decID).value = (item.insert_forum);
                        document.getElementById('manager_forum' + forum_decID).value = (item.manager_forum);
                        /***********************************************************************************************/
                        var link_frm = '../admin/find3.php?managerID=' + item.manager_forum + '';
                        var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm + '\' );this.blur();return false;" >' +
                            '<b style="color:red;font-size:1.4em;text-decoration: underline;">' + item.managerName + '</b>' +
                            '</a>';


                        $('#my_manager_td' + forum_decID).find('.module').find('h2').html(' ').html('מנהל הפורום:' + my_href + '');

                        /***************************************FORUMS_TYPE**********************************************/
                        if (item.dest_forumsType) {
                            $('#dest_forumsType' + forum_decID).empty();
                            $.each(item.dest_forumsType, function (i) {


                                var catForumName = this.catName;
                                var catForumID = item.dest_forumsType[i].catID;
                                $('#dest_forumsType' + forum_decID).append('<option value=' + catForumID + '>' + catForumName + '</option>').attr('selected', 'selected');
                            });
                        }
                        /***************************************MANAGERS_TYPE**********************************************/
                        if (item.dest_managersType) {
                            $('#dest_managersType' + forum_decID).empty();
                            $.each(item.dest_managersType, function (i) {


                                var catName = this.managerTypeName;
                                var catID = item.dest_managersType[i].managerTypeID;
                                $('#dest_managersType' + forum_decID).append('<option value=' + catID + '>' + catName + '</option>').attr('selected', 'selected');
                            });
                        }


                        /***************************************LINK_TREE***********************************************************************/

                        $.ajax({
                            type: "POST",
                            url: "dynamic_9.php",
                            data: "entry=" + data_a,
                            success: function (msg) {

                                $('#my_forum_entry_first' + forum_decID).remove();

                                $('div#forum_decision_tree' + forum_decID).html(' ').append('<p>' + msg + '</p>');

                            }
                        });


                        /************************************users***********************************************/

                        if (item.dest_user) {
                            $('#my_new_usr' + forum_decID).empty();
                            $('#dest_users' + forum_decID).empty();
                            $('#my_table_' + forum_decID).empty();
                            /*****************************ADD_TO_SELECT_BOX********************************************/

                            $.each(item.dest_user, function (i) {
                                var userName = this.full_name;
                                var usrID = item.dest_user[i].userID;
                                $('#dest_users' + forum_decID).append('<option value=' + usrID + '>' + userName + '</option>').attr('selected', 'selected');
                            });

                            /***************************************READ_USERS**********************************/
                            $.ajax({
                                type: "GET",
                                url: "../admin/dynamic_10.php",
                                data: "read_users=" + frmID,
                                success: function (msg) {

                                    var link_frm = '../admin/find3.php?forum_decID=' + frmID + '';
                                    var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm + '\' );this.blur();return false;" >' +
                                        '<b style="color:red;font-size:1.4em;">' + forum_decName + '</b>' +
                                        '</a>';

                                    $('div#my_div_table' + forum_decID).html(' ').append('<p>' + msg + '</p>');

                                    $('#my_Frm_users_td' + forum_decID).find('.module').find('h2').html(' ').html('חברי הפורום:' + my_href + '');

////////////
                                }       ///
                            });	   ///
/////////

                        }//end dest_user
                        /***************************************RESTORE_DECISIONS_TREE***********************************/
                        if (item.decision && item.decision[0].decID) {


////////////////////////////////////////////////////////////////////////////////////
                            nocache = '&rnd=' + Math.random();
                            $.ajax({
                                type: "GET",
                                url: "../admin/dynamic_10.php",
                                data: "read_decisions_multi=" + frmID + "&count_form=" + count_form + nocache,
                                success: function (msg) {
                                    var link_frm = '../admin/find3.php?forum_decID=' + frmID + '';
                                    var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm + '\' );this.blur();return false;" >' +
                                        '<b style="color:red;font-size:1.4em;">' + forum_decName + '</b>' +
                                        '</a>';

//$('#tree_content_target'+forum_decID).html(' ').append('<p>'+msg+'</p>');
                                    $('#tree_content_ajx' + forum_decID).html(' ').append('<p>' + msg + '</p>');

                                    $('#my_tree_td' + forum_decID).find('.module').find('h2').html('ערוך החלטות של הפורום:' + my_href + '');
                                }
                            });
//document.getElementById('tree_content_ajx'+forum_decID).innerHTML = msg;
////////////////////////////////////////////////////////////////////////////////////
                            nocache = '&rnd=' + Math.random();
                            $.ajax({
                                type: "GET",
                                url: "../admin/dynamic_10.php",
                                data: "read_decisions_multi2=" + frmID + "&count_form=" + count_form + nocache,
                                success: function (msg) {
                                    var link_frm2 = '../admin/find3.php?forum_decID=' + frmID + '';


                                    $('#tree_content_target2' + forum_decID).html(' ').append('<p>' + msg + '</p>');


                                    var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm2 + '\' );this.blur();return false;" >' +
                                        '<b style="color:red;font-size:1.4em">' + forum_decName + '</b>' +
                                        '</a>';

                                    $('#my_tree_td2' + forum_decID).find('.module').find('h2').html(' ').html('צפה בחלון בהחלטות של הפורום:' + my_href + '');


                                }
                            });


///////////////////////////////////////////////////////////////////////////////////
                            // return false;

                        }


                    }); //end each

//	 return false;

                });//end get_json

            });//end read_data
            /***********************************CHANGE_CONN_ENTRY1************************************************************/
            /***********************************CHANGE_CONN_ENTRY1************************************************************/
            /***********************************CHANGE_CONN_ENTRY1************************************************************/


            /******************************************************************************/
//$('#page_useredit').attr("id",'page_useredit'+forum_decID);
            /************************************************************************************************/
            $('.bgchange_tree').css('width', '50%');
            turn_red_tree();
            /**********************************************************************************************/


            $("#loading img").ajaxStart(function () {
                $(this).show();
            }).ajaxStop(function () {
                $(this).hide();
            });
            /************************************************************************************************/
        });//end DCREADY
        /************************************************************************************************/

    </script>

    <?php
    /*************************************************************************************************/
}

/**********************************************************************************************/

function build_form1(&$formdata)
{
    global $db;


    form_start($_SERVER['SCRIPT_NAME']);

    $dates = getdate();


    /****************************************************************************************/
    // forums_dec
    form_new_line();
    form_label("גוף מחליט חדש", TRUE);
    form_text("newforum", array_item($formdata, "newforum"), 20, 50, 3);
    form_url("forum_category.php", "ערוך פורומים", 2);

    form_end_line();
    /*****************************************************************************************/


    // category
    form_new_line();
    form_label("קטגוריה:", TRUE);

    $sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
    $rows = $db->queryObjectArray($sql);

    foreach ($rows as $row) {
        $subcats1[$row->parentCatID][] = $row->catID;
        $catNames1[$row->catID] = $row->catName;
    }

    $rows = build_category_array($subcats1[NULL], $subcats1, $catNames1);
    form_list1("category", $rows, array_item($formdata, "category"), " multiple size=6");
    form_label("קטגוריה חדשה", TRUE);
    form_text("new_category", array_item($formdata, "new_category"), 20, 50, 3);
    form_url("categories1.php", "ערוך קטגוריות", 2);
//				form_label("");
//				form_label("");
    form_end_line();

    /*****************************************************************************************/
    // forums_dec
    form_new_line();
    form_label("ממנה פורום:", TRUE);
    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
    form_list1("appoint_forum", $db->queryArray($sql), array_item($formdata, "appoint_forum"), "multiple size=6");
    form_label("גוף ממנה חדש", TRUE);
    form_text("newappoint", array_item($formdata, "newappoint"), 30, 50, 3);
    form_url("appoints.php", "ערוך ממני פורום", 2);
    form_end_line();


    /**********************************************************************************************/
    // forums_dec
    form_new_line();
    form_label("מרכז פורום:", TRUE);
    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
    // form_list("category", $rows , array_item($formdata, "category"), " multiple size=6");
    form_list1("manager_forum", $db->queryArray($sql), array_item($formdata, "manager_forum"), "multiple size=6");
    form_label("מנהל חדש", TRUE);
    form_text("new_manager", array_item($formdata, "new_manager"), 20, 50, 3);
    form_url("managers.php", "ערוך מנהלים", 2);
    form_end_line();


    /**********************************************************************************************/
    // users
    form_new_line();
    form_label("משתמשים:", TRUE);
    $sql = "SELECT full_name,userID FROM users ORDER BY full_name";
    form_list1("user_forum", $db->queryArray($sql), array_item($formdata, "user_forum"), "multiple size=6");
    form_label("משתמש חדש", TRUE);
    form_text("new_user", array_item($formdata, "new_user"), 20, 50, 3);
    form_url("users.php", "ערוך משתמשים", 2);
    form_end_line();
    /*****************************************************************************************/
    // publishing date

    form_new_line();

    form_label("תאריך הקמת הפורום:", true);


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

    if ((!is_numeric($formdata ["year_date"])) && (!is_numeric($formdata ['month_date'])) && (!is_numeric($formdata["multi_month"])) && (!is_numeric($formdata ["multi_year"]))) {

        echo '<td class="myformtd">';


        form_list3("year_date", $years, $dates['year'], array_item($formdata, "year_date"));

        form_list3("month_date", $months, $dates['month'], array_item($formdata, "month_date"));

        form_list3("day_date", $days, $dates['mday'], array_item($formdata, "day_date"));
        echo '</td>', "\n";


        form_end_line();

        /******************************************************************************************************/
        form_new_line();

        form_label("הזנת תאריכים לכמה פורומים:", true);

        echo '<td class="myformtd">';

        form_list01("multi_year", $years, array_item($formdata, "multi_year"), " multiple size=6");

        form_list01("multi_month", $months, array_item($formdata, "multi_month"), " multiple size=6");

        form_list01("multi_day", $days, array_item($formdata, "multi_day"), " multiple size=6");
        echo '</td>', "\n";

    } else {

        echo '<td class="myformtd">';

        form_list3("year_date", $years, $formdata['year_date'], array_item($formdata, "year_date"));

        form_list3("month_date", $months, $months[$formdata['month_date']], array_item($formdata, "month_date"));

        form_list3("day_date", $days, $formdata['day_date'], array_item($formdata, "day_date"));

        echo '</td>', "\n";

        //form_end_line();
    }
    form_label("");
    form_label("");
    form_label("");
    form_label("");
    form_label("");
    form_label("");
    form_end_line();
    /********************************************************************************************/
    if (is_numeric($formdata ["year_date"]) && is_numeric($formdata ['month_date'])) {
        form_new_line();


        form_label("הזנת תאריך ידני ");
        form_text("forum_date", array_item($formdata, "forum_date"), 20, 15, 3);
        form_label("");
        form_end_line();

    }
    /**********************************************************************************************/
    /************************************************************************************************/
    form_new_line();

    form_label("סטטוס פורום: (1=פתוח /0=סגור )", TRUE);
    form_text("forum_status", array_item($formdata, "forum_status"), 36, 50, 3);
    form_label("");
    form_label("");
    form_label("");

    form_end_line();

    /************************************************************************************************/
    //	form_new_line();
    //  form_label("");
    //  form_button("btnSave", "Save");
    //  // delete button for existing titles
    //  if(array_item($formdata, "titleID")) {
    //    form_button("btnDelete", "Delete title");
    //    form_hidden("titleID", $formdata["titleID"]); }
    //  else
    //    form_empty_cell(1);
    //  form_button("btnClear", "Input new title (clear form)");
    //  form_end_line();
    //
    //  // end form
    //  form_end();
    //}

    // buttons
    form_new_line();
    form_label("");


    form_button("submitbutton", "שמור");
    //form_button ("btnSave", "שמור");


    $tmp = (array_item($formdata, "forum_decID")) ? "update" : "save";
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["forum_decID"]);
    form_hidden("forum_decID", $formdata["forum_decID"]);
    form_hidden("insertID", $formdata["insertID"]);
    //phpinfo(32);
    if (array_item($formdata, "forum_decID")) {
        form_button1("btnDelete", "מחק פורום", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["forum_decID"] . "').value='delete'\";");


        //form_button("btnLink1", "קשר לתת פורום");
        form_button1("btnLink1", "קשר לתת פורום", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["forum_decID"] . "').value='קשר לפורום'\";");
        // form_hidden("forum_decID", $formdata["forum_decID"]);

    } else {

        form_empty_cell(1);
        form_button1("btnClear", "הוסף פורום/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\";");
    }
//				if(!array_item($formdata, "insertID")&& !array_item($formdata, "btnLink1")){
// 			        form_button("btnLink", "קשר לתת פורום");
// 			        form_hidden("forum_decID", $formdata["forum_decID"]);
//				}


    form_label("");
    form_label("");
    form_label("");
    form_end_line();

    // end form
    form_end();
}


//===============================================================================================

//===============================================================================================


// build form to ask, if d should be deleted
function build_delete_form($formdata)
{
    global $db;
    if ($forum_decID = array_item($formdata, "forum_decID")) {
        $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID=$forum_decID";
        if ($rows = $db->queryObjectArray($sql)) {
            form_start($_SERVER['SCRIPT_NAME']);
            form_new_line();
            form_caption("בטוח שרוצה לימחוק פורום " . $rows[0]->forum_decName . "?", 2);
            form_end_line();

            form_new_line();
            form_button("btnReallyDelete", "כן, מחק פורום");
            form_hidden3("mode", "realy_delete", 0, "id=mode");
            form_hidden("btnReallyDelete", $formdata["btnReallyDelete"]);

            form_button1("btnClear", "לא, בטל", "Submit", "OnClick=\"return document.getElementById('mode').value='clear'\";");


            form_end_line();
            form_hidden("forum_decID", $forum_decID);
            form_end();
            return TRUE;
        }
    }
    return FALSE;
}

/**************************************************************************************************************************/


function treedisplayUp($rows, $formdata)
{
    global $db;

    $mysqli = $db->getMysqli();
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit ();
    } else {
        printf("Connect succeeded\n");
    }
    /********************************************************/
    $sql = "set @@max_sp_recursion_depth=55";
    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }

    /********************************************************/
    $sql = "truncate table tmp_dec";
    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }
    /*************************************************************************************/
    for ($i = 0; $i <= count($rows); $i++) {
        $decid = $rows[$i]->decID;

        $query = $mysqli->multi_query("CALL get_parent_dec($decid)"); // automatically buffers resultsets and assigns true or false on fail to $query
        // OR $mysqli->real_query() - remember the main point of this is NOT to execute multple queries, but to acquire buffered results.

        //check if the query was successful
        if ($query) {

            //asign the first result set for use
            $result = $mysqli->use_result();

            //use the data in the resultset
            $data = $result->fetch_array(MYSQLI_ASSOC);//fetch_assoc();

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
        $sql5 = "select * from __parent_decs";
        $result5 = $mysqli->query($sql5);
        if ($mysqli->errno) {
            die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
        }
        $sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName)(select * from __parent_decs)"; //" .
        $result3 = $mysqli->query($sql3);
        if ($mysqli->errno) {
            die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
        }

    }

    ?>
    <meta HTTP-EQUIV="REFRESH" content="0; url=treefind_desc.php">
    <?php
    die;

}


/*********************************************************************************************************/
//==================================================================================================

function treedisplayDown($rows, $formdata)
{
    global $db;
    //if(($formdata['btnTitleRoot'])&& array_item($formdata,'btnTitleRoot')){
    $mysqli = $db->getMysqli();
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit ();
    }
    /********************************************************/
    $sql = "set @@max_sp_recursion_depth=55";

    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }
    $sql = "truncate table tmp_dec1";
    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }
    if ($rows) {
        for ($i = 0; $i < sizeof($rows); $i++) {
            $decid = $rows[$i]->decID;
            $sql1 = "call get_subdec($decid,@res)";
            $results = $mysqli->query($sql1);//"exec call get_subdec(5,@res)"
            if ($mysqli->errno) {
                die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
            }
            $sql2 = "insert into tmp_dec1 (rank, level, decID, decName, parentDecID)(select * from __subdecs)";
            $result1 = $mysqli->query($sql2);
            if ($mysqli->errno) {
                die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
            }
        }
    }


}

/************************************************************************************/
//	for($i=0;$i<=count($rows);$i++){
//				$decid=$rows[$i]->decID;
//
//				$query = $mysqli->multi_query("CALL get_parent_dec($decid)"); // automatically buffers resultsets and assigns true or false on fail to $query
//				// OR $mysqli->real_query() - remember the main point of this is NOT to execute multple queries, but to acquire buffered results.
//
//				//check if the query was successful
//				if ($query) {
//
//					//asign the first result set for use
//					$result = $mysqli->use_result();
//
//					//use the data in the resultset
//					$data = $result->fetch_array(MYSQLI_ASSOC) ;//fetch_assoc();
//
//					//free the resultset
//					$result->free();
//
//
//					while ($mysqli->next_result()) {
//						//free each result.
//						$result = $mysqli->store_result();//use_result();
//						if ($result instanceof mysqli_result) {
//							$result->free();
//						}
//					}
//				}
//				$sql5="select * from __parent_decs";
//				$result5=$mysqli->query($sql5);
//				if ($mysqli->errno) {
//					die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
//				}
//				$sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName)(select * from __parent_decs)"; //" .
//				$result3=$mysqli->query($sql3);
//				if ($mysqli->errno) {
//					die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
//				}
//
//			}


/****************************************************************************************************/
function display_tree($rows, $formdata)
{

    global $db;

    $mysqli = $db->getMysqli();
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit ();
    } else {
        //printf("Connect succeeded\n");
    }
    /********************************************************/
    $sql = "set @@max_sp_recursion_depth=55";
    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }

    /********************************************************/
    $sql = "truncate table tmp_dec";
    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }
    /************************************************************/
    for ($i = 0; $i <= count($rows); $i++) {
        $decid = $rows[$i]->decID;

        $query = $mysqli->multi_query("CALL get_parent_dec($decid)"); // automatically buffers resultsets and assigns true or false on fail to $query
        // OR $mysqli->real_query() - remember the main point of this is NOT to execute multple queries, but to acquire buffered results.

        //check if the query was successful
        if ($query) {

            //asign the first result set for use
            $result = $mysqli->use_result();

            //use the data in the resultset
            $data = $result->fetch_array(MYSQLI_ASSOC);//fetch_assoc();

            //free the resultset
            $result->free();


            while ($mysqli->next_result()) {
                //free each result.
                $result = $mysqli->store_result();//use_result();
                if ($result instanceof mysqli_result) {
                    $result->free();
                }
            }
        }
        $sql5 = "select * from __parent_decs";
        $result5 = $mysqli->query($sql5);
        if ($mysqli->errno) {
            die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
        }
        $sql3 = "INSERT INTO tmp_dec (level,decID, parentDecID, decName)(select * from __parent_decs)"; //" .
        $result3 = $mysqli->query($sql3);
        if ($mysqli->errno) {
            die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
        }

    }


}


/*************************************************************************************************************/
function display_tree1($rows, $formdata)
{
    global $db;

    $mysqli = $db->getMysqli();
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit ();
    } else {

    }
    /********************************************************/
    $sql = "set @@max_sp_recursion_depth=55";

    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }
    $sql = "truncate table tmp_dec1";
    $result = $mysqli->query($sql);
    if ($mysqli->errno) {
        die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
    }
    if ($rows) {
        for ($i = 0; $i < sizeof($rows); $i++) {
            $decid = $rows[$i]->decID;
            $sql1 = "call get_subdec($decid,@res)";
            $results = $mysqli->query($sql1);//"exec call get_subdec(5,@res)"
            if ($mysqli->errno) {
                die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
            }
            $sql2 = "insert into tmp_dec1 (rank, level, decID, decName, parentDecID)(select * from __subdecs)";
            $result1 = $mysqli->query($sql2);
            if ($mysqli->errno) {
                die("Execution failed: " . $mysqli->errno . ": " . $mysqli->error);
            }
        }
    }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

