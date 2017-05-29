    <?php
    
    function build_form(&$formdata) {
    global $db;
    global $lang;
    
    if (!empty($formdata['count'])) {
    $count = $formdata['count'];
    if ($count)
    if ($count == 1)
    echo "<p>  החלטה חדשה נוספה.</p>\n";
    else {
    echo "<p>$count החלטות חדשות נוספו.</p>\n";
    
    }
    
    }
    
    ?>
    <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/decision.js" type="text/javascript"></script>
    
    <?php
    //------------------------------------------------
    if (array_item($formdata, 'decID')) {
    $decID = array_item($formdata, 'decID');
    ?>
    <input type="hidden" id="decID" name="decID" value="<?php echo $decID; ?>"/>
    <?php
    }
    //------------------------------------------------
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
    //------------------------------------------------
    if (array_item($_SESSION, 'userID') && !(array_item($_SESSION, 'userID') == '') && !(array_item($_SESSION, 'userID') == 'none')) {
    $flag_userID = array_item($_SESSION, 'userID');
    
    ?>
    <input type="hidden" id="flag_userID" name="flag_userID" value="<?php echo $flag_userID; ?>"/>
    <?php
    }
    /*********************************************/
    
    if ($_SERVER['SCRIPT_NAME'] == ROOT_WWW . "/admin/mult_dec_ajx.php" || (isset($formdata['mult_dec_ajx']) && $formdata['mult_dec_ajx'] == 1)){
    
    ?>
    
    <form style="width:95%;" action="dynamic_5b.php" method="post" onsubmit="prepSelObject(document.getElementById('dest_forums'))
    ,prepSelObject(document.getElementById('dest_decisionsType'));" name="dec_form" id="dec_form">
    <fieldset
    style="margin-left:20px;margin-right:40px;background: #94C5EB url(../images/background-grad.png) repeat-x">
    <legend>החלטות עין השופט</legend>
    
    
    <?php
    }else{
    ?>
    <form style="width:95%;" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>"
    method="post" onsubmit="prepSelObject(document.getElementById('dest_forums'))
    ,prepSelObject(document.getElementById('dest_decisionsType'));" name="dec_form" id="dec_form">
    
    <fieldset style="margin-right:70px;background: #94C5EB url(../images/background-grad.png) repeat-x">
    <legend>החלטות עין השופט</legend>
    <?php }
    
    
    if (ae_detect_ie()) {
    echo '<table   align="center" style="align:center;border:0;">';
    } else {
    echo '<table    align="center" style="overflow:hidden; align:center;margin-right:30px;border:0;">';
    
    }
    
    ?>
    <!--
    <label for="chart"><strong style="font-weight:bold;color:brown;">גרף סוגי ההחלטות:</strong></label>
    <a href='#' title='גרף סוגי ההחלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />
    </a>
    
    <tr><td class="myformtd" colspan=4 >
    <label for="chart"><strong style="font-weight:bold;color:white;">חתך סוגי ההחלטות:</strong></label>
    <a href='#' title='חתך סוגי ההחלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />
    
    </a>
    
    <label for="chart"><strong style="font-weight:bold;color:white;">חתך סוגי הפורומים:</strong></label>
    <a href='#' title='חתך סוגי הפורומים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />
    
    </a>
    
    
    <label for="chart"><strong style="font-weight:bold;color:white;">חתך סוגי המנהלים:</strong></label>
    <a href='#' title='חתך סוגי המנהלים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJAX/default.php'"; ?> ,'סוגי המנהלים');this.blur();return false;";  >
    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />
    
    </a>
    
    </td></tr>
    -->
    <?php
    
    
    //echo '<table class="myformtable1"  align="center" style="width:95%;align:center;border:0;">';
    
    if (array_item($formdata, 'decID')) {
    
    $dec = new decisions();
    $dec->print_decision_entry_form1($formdata['decID']);
    }
    
    
    //=======================================================================================
    // decision
    
    echo '<tr>
    <td   class="myformtd" >
    <div  data-module="שם כותרת החלטה:">
    <table class="myformtable1" >
    <tr>';
    
    //form_label_red("שם כותרת החלטה:", TRUE);
    form_textarea("subcategories", array_item($formdata, "subcategories"), 30, 4, 3);
    
    
    // echo '<td class="myformtd">';
    
    form_label("תאריך החלטה:", true);
    
    form_text("dec_date", array_item($formdata, "dec_date"), 10, 10, 1, 'dec_date');
    
    //echo '</td >';
    //////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //   form_label("הזנת תאריכים לכמה החלטות:",true);
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
    
    
    form_label("הזנת תאריכים לכמה החלטות:", true);
    echo '<td colspan="3">';
    
    list11("multi_year", $years, array_item($formdata, "multi_year"), " multiple size=6 id='mult_yearID' ");
    
    list11("multi_month", $months, array_item($formdata, "multi_month"), " multiple size=6 id='mult_monthID' ");
    
    list11("multi_day", $days, array_item($formdata, "multi_day"), " multiple size=6 id='mult_dayID' ");
    echo '</td>';
    /////////////////////////////////////////////////////////////////////////////////////////////
    
    
    echo '</tr>
    </table>
    </div>
    </td>
    </tr>';
    
    //DECISIONS_TYPE
    echo '<tr>
    <td   class="myformtd" >
    <div  style="overflow:hidden;"  data-module="הזנת  סוגי ההחלטה:">
    <table class="myformtable1" style="">
    <tr>';
    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    $rows = $db->queryObjectArray($sql);
    
    foreach ($rows as $row) {
    $subcatsftype[$row->parentCatID][] = $row->catID;
    $catNamesftype[$row->catID] = $row->catName;
    }
    
    $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
    $rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
    
    
    //form_label_red("הזנת  סוגי ההחלטה:", TRUE);
    
    
    ?>
    <td class="myformtd">';
    <?PHP
    form_list111("src_decisionsType", $rows, array_item($formdata, "src_decisionsType"), "multiple size=6 id='src_decisionsType' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));\"");
    ?>
    </td>
    <?PHP
    
    
    if (isset($formdata['dest_decisionsType']) && $formdata['dest_decisionsType'] != 'none') {
    
    
    $dest_decisionsType = $formdata['dest_decisionsType'];
    unset($staff_test);
    unset($staff_testb);
    foreach ($dest_decisionsType as $key => $val) {
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
    
    $name[$row->catID] = $row->catName;
    
    
    }
    
    } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select catID, catName from categories where catName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->catID] = $row->catName;
    
    
    }
    $staffb = implode(',', $staff_testb);
    
    $sql2 = "select catID, catName from categories where catID in ($staffb)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name_b[$row->catID] = $row->catName;
    }
    $name = array_merge($name, $name_b);
    unset($staff_testb);
    } else {
    
    foreach ($formdata['dest_decisionsType'] as $catID) {
    $sql2 = "select catID, catName from categories where catID in ($catID)";
    if ($rows = $db->queryObjectArray($sql2))
    
    $name_1[$rows[0]->catID] = $rows[0]->catName;
    }
    }
    ?>
    
    <td class="myformtd">
    
    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));"/>
    
    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));"/>
    
    
    </td>
    
    
    <?PHP
    
    
    form_list11("dest_decisionsType", $name_1, array_item($formdata, "dest_decisionsType"), "multiple size=6 id='dest_decisionsType' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_decisionsType'));\"");
    
    
    } elseif (isset($formdata['src_decisionsType']) && isset($formdata['src_decisionsType'[0]]) && $formdata['src_decisionsType'][0] != 0 && !$formdata['dest_decisionsType']) {
    
    $dest_types = $formdata['src_decisionsType'];
    $userNames = '';
    for ($i = 0; $i < count($dest_types); $i++) {
    if ($i == 0) {
    $userNames = $dest_types[$i];
    } else {
    $userNames .= "," . $dest_types[$i];
    
    }
    
    }
    
    
    $name = explode(",", $userNames);
    
    $sql2 = "select catID,catName from categories where catID in ($userNames)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->catID] = $row->catName;
    
    }
    
    
    ?>
    
    <td class="myformtd">
    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));"/>
    
    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));"/>
    </td>
    
    
    <?PHP
    form_list11("src_decisionsType", $name, array_item($formdata, "src_decisionsType"), "multiple size=6 id='src_decisionsType' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));\"");
    
    } else {
    
    
    ?>
    
    <td class="myformtd">
    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType'), document.getElementById('dest_decisionsType'));"/>
    <BR><BR><input type=button name='remove_from_list();' value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));"/>
    </td>
    
    
    <td class="myformtd">
    <select class="mycontrol" name='arr_dest_decisionsType[]' dir=rtl id='dest_decisionsType'
    ondblclick="remove_item_from_select_box(document.getElementById('dest_decisionsType'));"
    MULTIPLE SIZE=6 style='width:180px;'></select>
    </td>
    
    <?PHP
    }
    form_label_short("סוג החלטה חדש", TRUE);
    form_textarea("new_decisionType", array_item($formdata, "new_decisionType"), 14, 5, 1);
    form_label_short("קשר לסוג החלטה", TRUE);
    
    form_list1idx("insert_decisionType", $rows2, array_item($formdata, "insert_decisionType"), "multiple size=6 style='width:160px;'");
    
    
    //echo '</tr>';
    if (!empty($level) && $level)
    
    //echo '<tr>';
    form_url_noformtd("categories.php", "ערוך סוגי החלטות", 1);
    ?>
    </tr>
    </table></div>
    </td>
    </tr>
    <tr>
    <td class="myformtd">
    <div style="overflow:hidden;" data-module="הזנת  הפורומים:">
    <table class="myformtable1">
    <tr>
    <?PHP
    if (!empty($formdata['decID']))
    $decID = $formdata['decID'];
    // echo '<button type="button" id="descButton_'.$decID.'" class="green90x24">תבניות תאור</button>';
    $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    if(!empty($rows)){
    foreach ($rows as $row) {
    $forumType[$row->parentForumID][] = $row->forum_decID;
    $forumNames[$row->forum_decID] = $row->forum_decName;
    }
    
    $rows = build_category_array($forumType[NULL], $forumType, $forumNames);
    $rows2 = build_category_array($forumType[NULL], $forumType, $forumNames);
    }
    
    //form_label_red("הזנת  הפורומים:", TRUE);
    echo '<td class="myformtd" style="width:10px;overflow:hidden;">';
    
    
    form_list111("src_forums", $rows, array_item($formdata, "src_forums"), "multiple size=6 id='src_forums' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));\"");
    
    echo '</td>';
    
    
    if (!empty($formdata['dest_forums']) && isset($formdata['dest_forums']) && $formdata['dest_forums'] != 'none') {
    
    
    $dest_forums = $formdata['dest_forums'];
    unset($staff_test);
    unset($staff_testb);
    foreach ($dest_forums as $key => $val) {
    if (!is_numeric($val)) {
    $val = $db->sql_string($val);
    $staff_test[] = $val;
    } elseif (is_numeric($val)) {
    $staff_testb[] = $val;
    }
    }
    if (!empty($staff_test) && is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    
    }
    
    } elseif (!empty($staff_test) && is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    
    }
    $staffb = implode(',', $staff_testb);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staffb)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name_b[$row->forum_decID] = $row->forum_decName;
    }
    $name = array_merge($name, $name_b);
    unset($staff_testb);
    } else {
    foreach ($formdata['dest_forums'] as $frmID) {
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($frmID)";
    if ($rows = $db->queryObjectArray($sql2))
    $name[$rows[0]->forum_decID] = $rows[0]->forum_decName;
    }
    }
    
    ?>
    
    <td class="myformtd" style='width:10px;overflow:hidden;'>
    
    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));"/>
    
    <BR><BR><input type=button name='remove_from_list();'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums'));"/>
    
    
    </td>
    
    
    <?PHP
    
    
    form_list11("dest_forums", $name, array_item($formdata, "dest_forums"), "multiple size=6 id='dest_forums' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forums'));\"");
    
    
    } elseif (isset($formdata['src_forums']) &&  isset($formdata['src_forums'][0]) && $formdata['src_forums'][0] != 0 ) {
    
    $dest_forum_dec = $formdata['src_forums'];
    
    for ($i = 0; $i < count($dest_forum_dec); $i++) {
    if ($i == 0) {
    $userNames = $dest_forum_dec[$i];
    } else {
    $userNames .= "," . $dest_forum_dec[$i];
    
    }
    
    }
    
    
    $name = explode(",", $userNames);
    
    $sql2 = "select forum_decID,forum_decName from forum_dec where forum_decID in ($userNames)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    }
    
    
    ?>
    
    <td class="myformtd" style='width:10px;overflow:hidden;'>
    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));"/>
    
    <BR><BR><input type=button name='remove_from_list();'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums'));"/>
    </td>
    
    
    <?PHP
    form_list11("src_forums", $name, array_item($formdata, "src_forums"), "multiple size=6 id='src_forums' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));\"");
    
    
    } else {
    
    
    ?>
    
    <td class="myformtd" style='width:10px;overflow:hidden;'>
    <input type=button name='add_to_list' value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums'), document.getElementById('dest_forums'));"/>
    <BR><BR><input type=button name='remove_from_list();'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums'));"/>
    </td>
    
    
    <td class="myformtd" style="width:10px;overflow:hidden;">
    <select class="mycontrol" name='arr_dest_forums[]' dir=rtl
    id='dest_forums'
    ondblclick="remove_item_from_select_box(document.getElementById('dest_forums'));"
    MULTIPLE SIZE=6 style='width:180px;'></select>
    </td>
    
    <?PHP
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
    
    form_label_short("שם פורום חדש:", TRUE);
    form_textarea("new_forum", array_item($formdata, "new_forum"), 14, 5, 1);
    form_label_short("קשר לפורום:", TRUE);
    form_list1idx("insert_forum", $rows2, array_item($formdata, "insert_forum"), "multiple size=6 style='width:200px;'");
    
    
    if (!empty($formdata['forum_decision']) && array_item($formdata, 'forum_decision'))
    $forum_decID = $formdata['forum_decision'];
    else {
    if (!empty($formdata['forum_decision']) || !empty($forum_decID))
    $forum_decID = $forum_decID ? $forum_decID : $formdata['forum_decision'];
    }
    
    if ($level) {
    
    if (isset($forum_decID) && (is_numeric($forum_decID))) {
    
    if (!((count($formdata['dest_forums'])) > 1)) {
    $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID=$forum_decID";
    if ($rows = $db->queryObjectArray($sql)) {
    $forum_name = $rows[0]->forum_decName;
    form_url1("pdf_brand.php?mode=read_data&editID=$forum_decID", "ערוך פורום-$forum_name", 4);
    }
    } else {
    $i = 0;
    foreach ($formdata['dest_forums'] as $forum) {
    if ($i < 3) {
    $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID=$forum";
    if ($rows = $db->queryObjectArray($sql)) {
    $forum_name = $rows[0]->forum_decName;
    
    echo '<tr><td class="myformtd" colspan="7">';
    form_url2("pdf_brand.php?mode=read_data&editID=$forum", "ערוך פורום-$forum_name", 4);
    echo "</td></tr>";
    }
    } else {
    
    continue;
    }
    $i++;
    }
    
    }
    } else {
    echo '</tr>';
    echo '<tr>';
    //form_url("pdf_brand.php","ערוך פורומים",1 );
    form_url_noformtd("pdf_brand.php", "ערוך פורומים", 1);
    echo '</tr>';
    }
    
    }//end if $level
    
    // echo '</tr>
    echo '
    </table></div>';
    // 	   $decID=$formdata['decID'];
    // echo '<button type="button" id="descButton_'.$decID.'" class="green90x24">תבניות תאור</button>';
    echo '</td>
    </tr>';
    
    /********************************************ההחלטה עצמה**********************************************************/
    
    if (!empty($formdata['dest_forums']) && array_item($formdata, 'dest_forums') && $formdata['dest_forums'] != 'none' &&
    (isset($formdata['fail']) && $formdata['fail'])
    ) {
    
    echo '<tr>
    <td>
    <div  id="desc_table"    style="overflow:hidden;"   data-module="ההחלטה עצמה(תאור ההחלטה)">';
    
    
    if ($formdata['dest_forums']) {
    foreach ($formdata['dest_forums'] as $forum_decID) {
    echo '<div id="notelist' . $decID . '' . $forum_decID . '" ></div>';
    }
    }
    echo '
    </div>
    </td>
    </tr>';
    }
    //USERS ACCEPT DECISION
    if (array_item($formdata, 'dest_forums') && !empty($formdata['dest_forums']) && $formdata['dest_forums'] != 'none' && (isset($formdata['fail'])
    && $formdata['fail'])) {
    echo '<tr>
    <td>
    <div     style="overflow:hidden;"   data-module=" חברי פורום">
    </div>
    </td>
    </tr><tr><td>  <h3 class="my_title_users_dec" style="height:15px"></h3> 
    <div id="content_users_dec" class="content_users">  
    <table class="myformtable1" id="my_table" style="width:80%" >';
    
    $j = 0;
    $decID = $formdata['decID'];
    
    foreach ($formdata['dest_forums'] as $frm_id) {
    
    $sql = "SELECT forum_decName from forum_dec WHERE forum_decID=$frm_id ";
    if ($getForum_name = $db->queryObjectArray($sql)) {
    $forum_name = $getForum_name[0]->forum_decName;
    }
    
    
    ?>
    <tr>
    <td></td>
    </tr>
    
    
    <div class="form-row">
    <span class="h">חברי פורום בעת קבלת ההחלטה:<input id="forum_decName"
    name="forum_decName" type="text"
    value="<?php echo $forum_name; ?>"
    class="mycontrol"/></span>
    <br/>
    </div>
    
    <?php
    
    
    $i = 0;
    $sql = "select userID,HireDate from rel_user_Decforum where decID=$decID AND forum_decID=$frm_id ";
    if ($rows = $db->queryObjectArray($sql)) {
    foreach ($rows as $row) {
    echo '<tr>';
    echo '<td>';
    
    echo '<input type="hidden" class="userID" id="' . $row->userID . '' . $frm_id . '"  value="' . $row->userID . '" />';
    echo '<input type="hidden" class="forum_decID" id="' . $frm_id . '' . $row->userID . '"  value="' . $frm_id . '" />';
    $sql = "SELECT full_name from users WHERE userID=$row->userID";
    if ($getName = $db->queryObjectArray($sql)) {
    $member_name = $getName[0]->full_name;
    }
    
    
    $member_date = "member_date$frm_id$row->userID";
    
    
    form_label1("חבר פורום:");
    
    form_text_a("member", $member_name, 20, 50, 1, "member$frm_id$row->userID");
    
    
    if ($level)    {
    ?>
    
    <input type="button" class="mybutton" id="my_button_<?php echo $frm_id;
    echo $row->userID; ?>" value="ערוך משתמש"
    onClick="return editReg_user(<?php echo $row->userID; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?> );"
    ; return false;/>
    <?php }elseif (!($level)){
    ?>
    
    <input type="button" class="mybutton" id="my_button_<?php echo $frm_id;
    echo $row->userID; ?>" value="צפה בפרטי משתמש"
    onClick="return editReg_user(<?php echo $row->userID; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?> );"
    ; return false;/>
    <?php } ?>
    
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
    
    
    list($year_date, $month_date, $day_date) = explode('-', $row->HireDate);
    if (strlen($day_date) == 4) {
    $row->HireDate = "$year_date-$month_date-$day_date";
    } elseif (strlen($year_date) == 4) {
    $row->HireDate = "$day_date-$month_date-$year_date";
    }
    
    form_label1("תאריך צרוף לפורום:");
    form_text3("$member_date", $row->HireDate, 10, 50, 1, $member_date);
    
    if (!empty($level) && $level) {
    $sql_a = "SELECT  userID,HireDate  FROM  rel_user_forum WHERE forum_decID=$frm_id
    UNION	   
    SELECT  userID,start_date  FROM rel_user_forum_history  WHERE forum_decID=$frm_id";
    if ($rows_a = $db->queryObjectArray($sql_a)) {
    
    
    $rows_1 = 0;
    
    for ($i = 0; $i < count($rows_a); $i++) {
    if ($i == 0) {
    $rows_1 = $rows_a[$i]->userID;
    } else {
    $rows_1 .= "," . $rows_a[$i]->userID;
    }
    }
    
    
    $sql_b = "SELECT  userID ,full_name FROM users  WHERE userID in ($rows_1)	  ";
    $rows_b = $db->queryObjectArray($sql_b);
    $array = Array();
    foreach ($rows_b as $row1) {
    $array[$row1->userID] = $row1->full_name;
    }
    
    form_list_idx("change_usr$frm_id$row->userID", $array, array_item($formdata, "change_usr$frm_id$row->userID"), "class=change_user    id=change_usr$frm_id$row->userID");
    
    
    }
    }
    
    
    $i++;
    
    }//end second each
    //---------------------------------------------
    }
    
    echo '</td>';
    
    echo '</tr>';
    
    $j++;
    }//end first each
    
    
    echo '</table>';
    echo '</div>';
    
    echo '</td>';
    echo '</tr>';
    
    
    } else {
    
    echo '<tr>';
    echo '<td   class="myformtd">';
    echo '<div id="content_users" class="content_users">';
    echo '<table class="myformtable" id="my_table" style="width:80%" >';
    
    echo '</table>';
    echo '</div>';
    echo '</td> ';
    echo '</tr> ';
    
    }
    /******************************************CATEGORIES_LEVEL*************************************************************/
    
    
    echo '<tr>
    <td   class="myformtd" >
    <div style="overflow:hidden;" data-module="קביעת רמות:">
    <table class="myformtable1" style="width:60%;">';
    
    
    echo '<tr>';
    form_label("רמת תוצאות הצבעה(%)", TRUE);
    form_text("vote_level", array_item($formdata, "vote_level"), 36, 50, 3);
    echo '</tr>';
    
    
    echo '<tr>';
    form_label("רמת חשיבות החלטה: (1 עד 10)", TRUE);
    form_text("dec_level", array_item($formdata, "dec_level"), 36, 50, 3);
    echo '</tr>';
    
    
    echo '<tr> 
    <td class="myformtd" colspan="3" >
    <div class="form-row" style="text-color:white;">';
    
    
    $arr = array();
    $arr[0][0] = "סגורה";
    $arr[0][1] = "1";
    $arr[1][0] = "פתוחה";
    $arr[1][1] = "2";
    
    
    $selected = array_item($formdata, 'dec_status') ? array_item($formdata, 'dec_status') : $arr[1][1];
    
    ?>
    
    <span class="h">סטטוס החלטה:&nbsp; &nbsp; </span>
    </div>
    </td>
    
    <?php
    echo '<td class="myformtd"> ';
    form_list_find_notd_no_choose('dec_status', 'dec_status', $arr, $selected);
    
    
    echo '</td>';
    
    echo '</tr>', "\n";
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    
    echo '<tr> 
    <td class="myformtd" colspan="3" >
    <div class="form-row" style="text-color:white;">';
    
    
    $arr = array();
    $arr[0][0] = "ציבורי";
    $arr[0][1] = "1";
    $arr[1][0] = "פרטי";
    $arr[1][1] = "2";
    $arr[2][0] = "סודי";
    $arr[2][1] = "3";
    
    $selected = array_item($formdata, 'dec_Allowed') ? array_item($formdata, 'dec_Allowed') : $arr[0][1];
    
    ?>
    
    <span class="h"><?php __('allowed'); ?>&nbsp; &nbsp; </span>
    </div></td>
    
    <?php
    echo '<td class="myformtd"> ';
    form_list_find_notd_no_choose('dec_allowed', 'dec_allowed', $arr, $selected);
    
    
    echo '</td>';
    
    echo '</tr>', "\n";
    
    
    echo ' </table></div>
    </td>
    </tr>';
    
    /********************************************************BUTTON*************************************************************************/
    if ($level) {
    echo '<tr>
    <td>
    <div     style="overflow:hidden;"   data-module="בצע פעולות">';
    
    
    echo '</div>
    </td>
    </tr>';
    
    echo '<tr>
    <td   class="myformtd" >
    <table class="myformtable1"  style="border:1;">
    <tr>';
    
    if (array_item($formdata, "decID")) {
    
    
    echo '<td  class="myformtd">';
    form_button2("btnLink1", "קשר להחלטה נוספת");
    form_hidden("decID", $formdata["decID"]);
    
    form_button2("btnLink3", "קשר להחלטה נוספת לפי חיפוש");
    form_hidden("decID", $formdata["decID"]);
    
    
    $sql = "select parentDecID1 from decisions where decID= " . $db->sql_string($formdata['decID']);
    if ($rows = $db->queryObjectArray($sql)) {
    if ($rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)) {
    form_button2("btnLink4", "בטל קישור שני");
    form_hidden("decID", $formdata["decID"]);
    }
    }
    
    
    form_button4("btnDelete", "מחק החלטה", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["decID"] . "').value='delete'\";");
    form_empty_cell_no_td(5);
    
    form_button2("submitbutton", "שמור", "Submit", "OnClick=\"prepSelObject(document.getElementById('dest_forums'));
    prepSelObject(document.getElementById('dest_decisionsType'));
    \";");
    
    
    $tmp = (array_item($formdata, "decID")) ? "update" : "save";
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["decID"]);
    
    
    echo '</td>';
    
    
    } else {
    
    echo '<td  class="myformtd">';
    if (!array_item($formdata, "insertID") && !array_item($formdata, "btnLink1")) {
    
    form_button2("btnLink2", "קשר לתת החלטה לפי חיפוש");
    if (!empty($formdata["decID"]))
    form_hidden("decID", $formdata["decID"]);
    }
    if (!empty($formdata["decID"])) {
    ?>
    <button class="green90x24" type="submit"
    name="submitbutton_save<?php echo $formdata['decID']; ?>"
    id="submitbutton_save<?php echo $formdata['decID']; ?>">שמור
    </button>
    <?php
    
    $tmp = (array_item($formdata, "decID")) ? "update" : "save";
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["decID"]);
    form_hidden("decID", $formdata["decID"]);
    form_hidden("insertID", $formdata["insertID"]);
    
    form_empty_cell_no_td(3);
    }
    if (!empty($formdata["btnClear"])) {
    form_button4("btnClear", "הוסף החלטה/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\";");
    } else {
    
    form_button4("btnClear", "הוסף החלטה/נקה טופס", "Submit", '');
    }
    echo '</td>';
    }
    echo '</tr>
    </table>
    </td>
    </tr>';
    }
    
    
    echo '</table></fieldset>';
    
    if (array_item($formdata, "decID")){
    
    $decID = $formdata['decID'];
    
    if (array_item($formdata, 'dest_forums')) {
    foreach ($formdata['dest_forums'] as $key => $val) {
    $formdata['forum_decID'] = $val;
    
    }
    
    }
    
    if (!empty($formdata['dest_forums']) && is_numeric($formdata['dest_forums'])) {
    $forum_decID = $formdata['dest_forums'];
    } else {
    $forum_decID = isset($formdata['forum_decID']) ? $formdata['forum_decID'] : '';
    }
    
    if (isset($formdata['dest_forums'])){
    foreach ($formdata['dest_forums'] as $forum_decID){
    if (is_numeric($forum_decID)){
    $getUser_sql = "SELECT u.* FROM users u 
    inner join rel_user_forum r  
    on u.userID = r.userID              
    WHERE r.forum_decID = $forum_decID
    ORDER BY u.full_name ASC";
    
    if ($getUser = $db->queryObjectArray($getUser_sql)){
    
    
    $get_mgrID = "SELECT managerID from forum_dec WHERE forum_decID=$forum_decID";
    if ($rows = $db->queryObjectArray($get_mgrID)) {
    $mgrID = $rows[0]->managerID;
    }
    
    $get_mgr = "SELECT userID from managers WHERE managerID=$mgrID";
    if ($rows = $db->queryObjectArray($get_mgr)) {
    $mgr = $rows[0]->userID;
    }
    
    
    ?>
    <table id="my_general_table_<?php echo $forum_decID; ?>">
    <tr>
    <td>
    <input type=hidden name="decID" id="decID" value="<?php echo $decID ?>"/>
    <input type=hidden name="forum_decID" id="forum_decID"
    value="<?php echo $forum_decID ?>"/>
    <input type=hidden name="mgr" id="mgr" value="<?php echo $mgr ?>"/>
    <?php
    $lang->build_task_form2($decID, $forum_decID, $mgrID);
    
    echo '</td></tr></table>';
    
    }
    }
    }//end each
    }
    }
    
    
    echo '</form>';
    
    ?>
    
    
    <div id="page_useredit" class="page_useredit" style="display:none">
    
    <h3 class="my_title" style=" height:15px"></h3>
    <h3><?php __('edit_user'); ?></h3>
    
    <div class="content">
    
    
    <form onSubmit="return saveUser3(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>);"
    name="edituser" id="edituser">
    <input type="hidden" name="Request_Tracking_Number_1"
    id="Request_Tracking_Number_1" value=""/>
    <input type="hidden" name="Request_Tracking_Number1"
    id="Request_Tracking_Number1" value=""/>
    <input type="hidden" name="Request_Tracking_Number2"
    id="Request_Tracking_Number2" value=""/>
    <input type="hidden" name="id" value=""/>
    <?php
    if (isset($formdata['forum_decision'])) {
    
    ?>
    <input type="hidden" name="forum_decID" id="forum_decID"
    value="<?php echo $formdata['forum_decision']; ?>"/>
    <?php
    }
    
    ?>
    
    
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
    <option value="1"><?php __('forum_user') ?></option>
    <option value="2"><?php __('admin') ?></option>
    <option value="3"><?php __('suppervizer') ?></option>
    <option value="none" selected>(בחר אופציה)</option>
    </SELECT>
    
    </div>
    
    
    <div class="form-row"><span
    class="h"><?php __('full_name'); ?></span><br>
    <input type="text" name="full_name" id="full_name" value=""
    class="in200" maxlength="50"/></div>
    
    <div class="form-row"><span class="h"><?php __('user'); ?></span><br>
    <input
    type="text" name="user" id="user" value="" class="in200"
    maxlength="50"/></div>
    
    <div class="form-row"><span class="h"><?php __('upass'); ?></span><br>
    <input type="text" name="upass" id="upass" value="" class="in200"
    maxlength="50"/></div>
    <div class="form-row"><span class="h"><?php __('email'); ?></span><br>
    <input type="text" name="email" id="email" value="" class="in200"
    maxlength="50"/></div>
    <div class="form-row"><span class="h"><?php __('phone'); ?></span><br>
    <input type="text" name="phone" id="phone" value="" class="in200"
    maxlength="50"/></div>
    <div class="form-row"><span class="h"><?php __('note'); ?></span><br>
    <textarea name="note" id="note" class="in500"></textarea></div>
    <div class="form-row"><span class="h"><?php __('tags'); ?></span><br>
    <input
    type="text" name="tags" id="edittags1" value=""
    class="in500"
    maxlength="250"/></div>
    <div class="form-row">
    <?php if ($level) { ?>
    <input type="submit" id="edit_usr" value="<?php __('save'); ?>"
    onClick="this.blur()"/>
    <?php } ?>
    <input type="button" value="<?php __('cancel'); ?>"
    onClick="canceluserEdit3();this.blur();return false"/>
    
    
    </div>
    </form>
    
    </div> <!--  end div content -->
    
    </div> <!--  end of page_user_edit -->
    
    
    <?php
    
    }//end build form
    
    // build form for title input/change
    // the form is formated using a table with 4 columns
    
    
    // build form to ask, if d should be deleted
    function build_delete_form($formdata)
    {
    global $db;
    if ($decID = array_item($formdata, "decID")) {
    $sql = "SELECT decName FROM decisions WHERE decID=$decID";
    if ($rows = $db->queryObjectArray($sql)) {
    form_start2($_SERVER['SCRIPT_NAME'], $name = "");
    echo '<fieldset style="margin-left:40px;margin-right:20px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend>החלטות עין השופט</legend>';
    echo ' <table class="myformtable1" style="width:50%;"><tr>';
    
    form_caption("בטוח שרוצה לימחוק החלטה " . $rows[0]->decName . "?", 2);
    echo '</tr>';
    
    echo '<tr>';
    
    ECHO '<td class="myformtd">';
    form_button2("btnReallyDelete", "כן, מחק החלטה");
    form_hidden3("mode", "realy_delete", 0, "id=mode");
    form_hidden("btnReallyDelete", $formdata["btnReallyDelete"]);
    
    form_button_no_td("btnClear", "לא, בטל", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\";");
    form_hidden("decID", $decID);
    //      form_hidden3("mode","clear",0,"id=mode");
    //      form_hidden("decID", $formdata["decID"]);
    
    echo '</td></tr></table></fieldset></form>';
    
    
    return TRUE;
    }
    }
    return FALSE;
    }
    
    
    function build_delete_form1($deleteID)
    {
    global $db;
    
    $sql = "SELECT decName FROM decisions WHERE decID=$deleteID";
    if ($rows = $db->queryObjectArray($sql)) {
    form_start3($_SERVER['SCRIPT_NAME'], $name = "");
    echo '<fieldset style="margin-left:40px;margin-right:20px;background: #94C5EB url(../images/background-grad.png) repeat-x"><legend>החלטות עין השופט</legend>';
    
    echo ' <table class="myformtable1" style="width:50%;"><tr>';
    form_caption("בטוח שרוצה לימחוק החלטה " . $rows[0]->decName . "?", 2);
    echo '</tr>';
    
    echo '<tr>';
    ECHO '<td class="myformtd">';
    form_button2("btnReallyDelete", "כן, מחק החלטה");
    form_hidden3("mode", "realy_delete", 0, "id=mode");
    form_hidden("btnReallyDelete", $formdata["btnReallyDelete"]);
    // form_hidden3("mode","update",0, "id=mode");
    //form_button("btnClear", "לא, בטל");
    form_button_no_td("btnClear", "לא, בטל", "Submit", "OnClick=\"return document.getElementById('mode').value='clear'\";");
    form_hidden("decID", $deleteID);
    echo '</td>';
    echo '</tr></table></fieldset></form>';
    
    
    return TRUE;
    }
    
    return FALSE;
    }
    
    
    function build_form_dec_ajx(&$formdata) {
    global $db;
    global $lang;
    $decID = $formdata['decID'];
    $dest_forums = isset ($formdata['dest_forums']) ? $formdata['dest_forums'] : '';
    
    
    if (array_item($_SESSION, 'level') == 'user') {
    $flag_level = 0;
    $level = false;
    ?>
    <input type="hidden" id="flag_level" name="flag_level"
    value="<?php echo $flag_level; ?>"/>
    <?php
    } else {
    $level = true;
    $flag_level = 1;
    
    ?>
    <input type="hidden" id="flag_level" name="flag_level"
    value="<?php echo $flag_level; ?>"/>
    <?php
    
    }
    
    
    if (array_item($_SESSION, 'userID') && !(array_item($_SESSION, 'userID') == '') && !(array_item($_SESSION, 'userID') == 'none')) {
    $flag_userID = array_item($_SESSION, 'userID');
    
    ?>
    <input type="hidden" id="flag_userID" name="flag_userID"
    value="<?php echo $flag_userID; ?>"/>
    <?php
    }
    ?>
    
    
    <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/decision.js"
    type="text/javascript"></script>
    
    <input type="hidden" id="decID" name="decID" value="<?php echo $decID; ?>"/>
    <div id="main">
    
    
    <h4 class="my_main_fieldset<?php echo $formdata['decID'] ?>"
    style="height:15px;cursor:pointer;"></h4>
    
    
    <form style="width:98%;" method="post"
    name="decision_<?php echo $formdata['decID'] ?>"
    id="decision_<?php echo $formdata['decID'] ?>"
    action="../admin/dynamic_5c.php"
    onSubmit="prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID'] ?>')) ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID'] ?>'));">
    
    <fieldset id="main_fieldset<?php echo $formdata['decID'] ?>"
    style="background: #94C5EB url(../images/background-grad.png) repeat-x;">
    <legend style="color:brown; ">החלטות עין השופט</legend>
    
    
    <div id="decision_b_<?php echo $formdata['decID'] ?>"
    name="decision_b_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision_a_<?php echo $formdata['decID'] ?>"
    name="decision_a_<?php echo $formdata['decID'] ?>"></div>
    
    
    <h4 class="my_menu_items_dec_title"
    style="height:15px;cursor:pointer;"></h4>
    
    
    <div id="my_error_message<?php echo $decID; ?>"
    name="my_error_message<?php echo $decID; ?>"></div>
    
    
    <ul id="menu_items_dec<?php echo $decID; ?>"
    name="menu_items_dec<?php echo $decID; ?>"
    class="menu_items_dec<?php echo $formdata['decID']; ?>"
    style="overflow:hidden">
    <input type=hidden
    name="menu_items_dec_hidden<?php echo $formdata['decID'] ?>"
    id="menu_items_dec_hidden<?php echo $formdata['decID'] ?>"
    value="<?php echo $formdata['decID'] ?>"/>
    <div id="decision0_<?php echo $formdata['decID'] ?>"
    name="decision0_<?php echo $formdata['decID'] ?>"
    style="overflow:auto;hieght:400px;"></div>
    
    <div id="decision1_<?php echo $formdata['decID'] ?>"
    name="decision1_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision2_<?php echo $formdata['decID'] ?>"
    name="decision2_<?php echo $formdata['decID'] ?>"></div>
    
    
    <div id="decision4_<?php echo $formdata['decID'] ?>"
    name="decision4_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision5_<?php echo $formdata['decID'] ?>"
    name="decision5_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision6_<?php echo $formdata['decID'] ?>"
    name="decision6_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision7_<?php echo $formdata['decID'] ?>"
    name="decision7_<?php echo $formdata['decID'] ?>"></div>
    
    
    <div id="decision3a_<?php echo $formdata['decID'] ?>"
    name="decision3a_<?php echo $formdata['decID'] ?>"></div>
    
    
    <div id="decision8_<?php echo $formdata['decID'] ?>"
    name="decision8_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision9_<?php echo $formdata['decID'] ?>"
    name="decision9_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision10_<?php echo $formdata['decID'] ?>"
    name="decision10_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision11_<?php echo $formdata['decID'] ?>"
    name="decision11_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision12_<?php echo $formdata['decID'] ?>"
    name="decision12_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision13_<?php echo $formdata['decID'] ?>"
    name="decision13_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision14_<?php echo $formdata['decID'] ?>"
    name="decision14_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision15_<?php echo $formdata['decID'] ?>"
    name="decision15_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision16_<?php echo $formdata['decID'] ?>"
    name="decision16_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision17_<?php echo $formdata['decID'] ?>"
    name="decision17_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision18_<?php echo $formdata['decID'] ?>"
    name="decision18_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision19_<?php echo $formdata['decID'] ?>"
    name="decision19_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision20_<?php echo $formdata['decID'] ?>"
    name="decision20_<?php echo $formdata['decID'] ?>"></div>
    
    <div id="decision_<?php echo $formdata['decID'] ?>-message"
    name="decision_<?php echo $formdata['decID'] ?>-message"></div>
    <div id="decision-message<?php echo $formdata['decID'] ?>"
    name="decision-message<?php echo $formdata['decID'] ?>"></div>
    <div id="decision6" name="decision6"></div>
    </ul>
    
    
    <?php
    if (ae_detect_ie()) {
    echo '<table style="align:center;margin-right:30px;border:0;"  id="main_table"><tr><td>';
    } else {
    echo '<table    style="align:center;margin-right:30px;border:0;" id="main_table"><tr><td>';
    
    }
    
    
    ?>
    
    <!--
    <label for="chart"><strong style="font-weight:bold;color:brown;">גרף סוגי ההחלטות:</strong></label>
    <a href='#' title='גרף סוגי ההחלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />
    </a>
    -->
    
    <?php
    
    $decID = $formdata['decID'];
    if (array_item($formdata, 'decID')) {
    $dec = new decisions();
    $dec->print_decision_entry_form1_c($formdata['decID']);
    }
    
    
    echo '</td></tr>';
    //=======================================================================================
    
    
    echo '<tr>
    <td> <div  style="overflow:hidden;" data-module="שם כותרת החלטה:">
    <table class="myformtable1" style="height:100px;width:98%;"><tr>';
    
    
    form_textarea_noformtd("subcategories", array_item($formdata, "subcategories"), 30, 5, 3, "my_text_erea$decID");
    
    
    ?>
    <td id="my_date<?php echo $decID; ?>"><?php
    form_label1("תאריך החלטה:", true);
    
    
    form_text_noformtd("dec_date", array_item($formdata, "dec_date"), 10, 10, 1, "dec_date");
    
    
    echo '</td>';
    //////////////////////////////////////////////////////////////////////////////////////////////
    
    
    form_label_noformtd("הזנת תאריכים לכמה החלטות:", true);
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
    
    
    echo '<td colspan="3">';
    list11("multi_year", $years, array_item($formdata, "multi_year"), " multiple size=6 id='mult_yearID' ");
    
    list11("multi_month", $months, array_item($formdata, "multi_month"), " multiple size=6 id='mult_monthID' ");
    
    list11("multi_day", $days, array_item($formdata, "multi_day"), " multiple size=6 id='mult_dayID' ");
    echo '</td>';
    /////////////////////////////////////////////////////////////////////////////////////////////
    
    
    /*************************************DECISIONS_TYPE*****************************************************************/
    $decID = $formdata['decID'];
    $formdata["dest_decisionsType$decID"] = (isset($formdata["dest_decisionsType"]) && $formdata["dest_decisionsType"]) ? $formdata["dest_decisionsType"] : '';
    
    ?>
    </tr>
    </table>
    
    </div>
    </td>
    </tr>
    <tr>
    <td>
    <div style="overflow:hidden;" data-module="הזנת  סוגי ההחלטה:">
    <table class="myformtable1" class="myformtable1" style="height:100px;width:98%;">
    <tr>
    
    <?PHP
    
    
    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    $rows = $db->queryObjectArray($sql);
    
    foreach ($rows as $row) {
    $subcatsftype[$row->parentCatID][] = $row->catID;
    $catNamesftype[$row->catID] = $row->catName;
    }
    
    $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
    $rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
    
    
    echo '<td style="width:10px;overflow:hidden;">';
    
    form_list111("src_decisionsType$decID", $rows, array_item($formdata, "src_decisionsType$decID"), "multiple size=6 id='src_decisionsType$decID' style='width:180px;overflow:hidden;' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType$decID'), document.getElementById('dest_decisionsType$decID'));\"");
    
    echo '</td>';
    
    
    if ($formdata["dest_decisionsType$decID"] && $formdata["dest_decisionsType$decID"] != 'none') {
    
    
    $dest_decisionsType = $formdata["dest_decisionsType$decID"];
    unset($staff_test);
    unset($staff_testb);
    foreach ($dest_decisionsType as $key => $val) {
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
    
    $name[$row->catID] = $row->catName;
    
    
    }
    
    } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select catID, catName from categories where catName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->catID] = $row->catName;
    
    
    }
    $staffb = implode(',', $staff_testb);
    
    $sql2 = "select catID, catName from categories where catID in ($staffb)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name_b[$row->catID] = $row->catName;
    }
    $name = array_merge($name, $name_b);
    unset($staff_testb);
    } else {
    
    foreach ($formdata["dest_decisionsType$decID"] as $catID) {
    $sql2 = "select catID, catName from categories where catID in ($catID)";
    if ($rows = $db->queryObjectArray($sql2))
    
    $name_1[$rows[0]->catID] = $rows[0]->catName;
    }
    
    }
    
    ?>
    
    <td style='width:10px;overflow:hidden;'>
    
    <input type=button name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID; ?>'), document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    
    
    </td>
    
    
    <?PHP
    
    
    form_list_no_formtd("dest_decisionsType$decID", $name_1, array_item($formdata, "dest_decisionsType$decID"), "multiple size=6 id='dest_decisionsType$decID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_decisionsType$decID'));\"");
    
    
    } elseif (isset($formdata["src_decisionsType$decID"]) && $formdata["src_decisionsType$decID"] && $formdata["src_decisionsType$decID"][0] != 0 && !$formdata["dest_decisionsType$decID"]) {
    
    $dest_types = $formdata["src_decisionsType$decID"];
    $userNames = '';
    for ($i = 0; $i < count($dest_types); $i++) {
    if ($i == 0) {
    $userNames = $dest_types[$i];
    } else {
    $userNames .= "," . $dest_types[$i];
    
    }
    
    }
    
    
    $name = explode(",", $userNames);
    
    $sql2 = "select catID,catName from categories where catID in ($userNames)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->catID] = $row->catName;
    
    }
    
    
    ?>
    
    <td>
    <input type=button name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID; ?>'), document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    </td>
    
    
    <?PHP
    form_list_no_formtd("src_decisionsType$decID", $name, array_item($formdata, "src_decisionsType$decID"), "multiple size=6 id='src_decisionsType$decID' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType$decID'), document.getElementById('dest_decisionsType$decID'));\"");
    
    
    } else {
    
    
    ?>
    
    <td style='width:10px;overflow:hidden;'>
    <input type=button name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID; ?>'), document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    </td>
    
    
    <td>
    <select class="mycontrol"
    name='arr_dest_decisionsType<?php echo $decID; ?>[]' dir=rtl
    id='dest_decisionsType<?php echo $decID; ?>'
    ondblclick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"
    MULTIPLE SIZE=6 style='width:180px;'></select>
    </td>
    
    <?PHP
    
    }
    
    
    form_label_short("סוג החלטה חדש:", true);
    
    
    form_textarea1("new_decisionType$decID", array_item($formdata, "new_decisionType"), 10, 5, 1, "new_decisionType$decID");
    
    
    form_label_short("קשר לסוג החלטה:", TRUE);
    
    echo '<td style="width:10px;overflow:hidden;" colspan="2">';
    form_list111("insert_decisionType$decID", $rows2, array_item($formdata, "insert_decisionType"), " id=insert_decisionType$decID   multiple size=6    style='width:180px;' ");
    echo '</td>';
    
    if (!empty($level) && $level)
    form_url_noformtd("categories.php", "ערוך סוגי החלטות", 1);
    
    
    echo '</tr>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td>
    <div  style="overflow:hidden;" data-module="הזנת  הפורומים:">
    <table class="myformtable1"   style="height:100px;width:98%;">
    <tr>';
    
    
    //forums
    
    $decID = isset($formdata['decID']) ? $formdata['decID'] : '';
    
    $formdata["dest_forums$decID"] = isset($formdata["dest_forums"]) ? $formdata["dest_forums"] : '';
    $formdata["dest_managers$decID"] = isset($formdata["dest_managers"]) ? $formdata["dest_managers"] : '';
    $formdata["dest_userIDs$decID"] = isset($formdata["dest_userIDs"]) ? $formdata["dest_userIDs"] : '';
    
    
    $encoded = json_encode($formdata["dest_managers$decID"]);
    $encoded = htmlspecialchars($encoded);
    
    $encoded2 = json_encode($formdata["dest_userIDs$decID"]);
    $encoded2 = htmlspecialchars($encoded2);
    
    if(isset($formdata['decID']) ) {
    echo '<input type="hidden" id="dest_managers' . $formdata['decID'] . '"    value=' . $encoded . '>';
    echo '<input type="hidden" id="dest_userIDs' . $formdata['decID'] . '"    value=' . $encoded2 . '>';
    }
    
    $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    
    foreach ($rows as $row) {
    $forumType[$row->parentForumID][] = $row->forum_decID;
    $forumNames[$row->forum_decID] = $row->forum_decName;
    }
    
    $rows = build_category_array($forumType[NULL], $forumType, $forumNames);
    $rows2 = build_category_array($forumType[NULL], $forumType, $forumNames);
    
    
    echo '<td style="width:10px;overflow:hidden;">';
    form_list111("src_forums$decID", $rows, array_item($formdata, "src_forums$decID"), "multiple size=6 id='src_forums$decID' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums$decID'), document.getElementById('dest_forums$decID'));\"");
    echo '</td>';
    
    
    if (isset($formdata["dest_forums$decID"][0]) && $formdata["dest_forums$decID"][0] && $formdata["dest_forums$decID"][0] != 'none') {
    
    
    $dest_forums = $formdata["dest_forums$decID"];
    unset($staff_test);
    unset($staff_testb);
    if (isset($val) && $val) {
    foreach ($dest_forums as $key => $val) {
    if (!is_numeric($val)) {
    $val = $db->sql_string($val);
    $staff_test[] = $val;
    } elseif (is_numeric($val)) {
    $staff_testb[] = $val;
    }
    }
    }
    if (isset($staff_test) && is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    
    }
    
    } elseif (isset($staff_test) && is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    
    }
    $staffb = implode(',', $staff_testb);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staffb)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name_b[$row->forum_decID] = $row->forum_decName;
    }
    $name = array_merge($name, $name_b);
    unset($staff_testb);
    } else {
    
    
    foreach ($formdata["dest_forums$decID"] as $frmID) {
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($frmID)";
    if ($rows = $db->queryObjectArray($sql2))
    $name[$rows[0]->forum_decID] = $rows[0]->forum_decName;
    }
    
    
    }
    
    ?>
    
    <td style="width:10px;overflow:hidden;">
    
    <input type=button name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID; ?>'), document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list<?php echo $decID; ?>();'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    
    
    </td>
    
    
    <?PHP
    
    
    if (isset($name))
    form_list_no_formtd("dest_forums$decID", $name, array_item($formdata, "dest_forums$decID"), "multiple size=6 id='dest_forums$decID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forums$decID'));\"");
    
    
    }
    if (isset($formdata["src_forums$decID"]) && $formdata["src_forums$decID"] && $formdata["src_forums$decID"][0] != 0 && !$formdata["dest_forums$decID"]) {
    
    $dest_forum_dec = $formdata["src_forums$decID"];
    
    for ($i = 0; $i < count($dest_forum_dec); $i++) {
    if ($i == 0) {
    $userNames = $dest_forum_dec[$i];
    } else {
    $userNames .= "," . $dest_forum_dec[$i];
    
    }
    
    }
    
    
    $name = explode(",", $userNames);
    
    $sql2 = "select forum_decID,forum_decName from forum_dec where forum_decID in ($userNames)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    }
    
    
    ?>
    
    <td style="width:10px;overflow:hidden;">
    <input type=button name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID; ?>'), document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    </td>
    
    
    <?PHP
    form_list_no_formtd("src_forums$decID", $name, array_item($formdata, "src_forums$decID"), "multiple size=6 id='src_forums$decID' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums$decID'), document.getElementById('dest_forums$decID'));\"");
    
    
    } else {
    
    
    ?>
    
    <td style="width:10px;overflow:hidden;">
    <input type=button name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID; ?>'), document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    </td>
    
    
    <td style="width:10px;overflow:hidden;">
    <select class="mycontrol" name='arr_dest_forums<?php echo $decID; ?>[]'
    dir=rtl id='dest_forums<?php echo $decID; ?>'
    ondblclick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"
    MULTIPLE SIZE=6 style='width:180px;'></select>
    </td>
    
    
    <?PHP
    }
    
    
    $sql = "SELECT forum_decName,forum_decID,parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    
    foreach ($rows as $row) {
    $subcats_a[$row->parentForumID][] = $row->forum_decID;
    $catNames_a[$row->forum_decID] = $row->forum_decName;
    }
    
    $rows2 = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
    
    
    form_empty_cell_noformtd(4);
    form_label_noformtd("שם פורום חדש:", TRUE);
    form_textarea_noformtd("new_forum$decID", array_item($formdata, "new_forum"), 14, 5, 1, "new_forum$decID");
    
    form_empty_cell_noformtd(4);
    form_label_noformtd("קשר לפורום:", TRUE);
    echo '<td style="width:10px;overflow:hidden;">';
    form_list111("insert_forum$decID", $rows2, array_item($formdata, "insert_forum"), "id=insert_forum$decID  multiple size=6 style='width:180px;'");
    echo '</td>';
    
    
    if (isset($formdata['forum_decision']) && $formdata['forum_decision'] && array_item($formdata, 'forum_decision'))
    $forum_decID = $formdata['forum_decision'];
    else if(isset($formdata['forum_decision']))
    $forum_decID = isset($forum_decID) ? $forum_decID : $formdata['forum_decision'];
    
    
    if (isset($level) && $level) {
    if (isset($forum_decID) && $forum_decID && (is_numeric($forum_decID))) {
    
    if (!((count($formdata['dest_forums'])) > 1)) {
    $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID=$forum_decID";
    if ($rows = $db->queryObjectArray($sql)) {
    $forum_name = $rows[0]->forum_decName;
    echo '<tr><td  >';
    form_url2("pdf_brand.php?mode=read_data&editID=$forum_decID", "ערוך פורום-$forum_name", 4);
    echo "</td></tr>";
    }
    } else {
    $i = 0;
    foreach ($formdata['dest_forums'] as $forum) {
    if ($i < 3) {
    $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID=$forum";
    if ($rows = $db->queryObjectArray($sql)) {
    $forum_name = $rows[0]->forum_decName;
    echo '<tr><td >';
    form_url2("pdf_brand.php?mode=read_data&editID=$forum", "ערוך פורום-$forum_name", 4);
    echo "</td></tr>";
    
    }
    } else {
    
    continue;
    }
    $i++;
    }
    
    }
    }
    }
    
    
    echo '</tr>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td>
    <div  id="desc_table"    style="overflow:hidden;"   data-module="ההחלטה עצמה(תאור ההחלטה)">';
    
    
    if (isset ($formdata['dest_forums']) && $formdata['dest_forums']) {
    foreach ($formdata['dest_forums'] as $forum_decID) {
    echo '<div id="notelist' . $decID . '' . $forum_decID . '" ></div>';
    }
    }
    
    echo '
    </div>
    </td>
    </tr>';
    
    /*********************************************************************************************************/
    $decID = isset($formdata['decID']) ? $formdata['decID'] : '';
    echo '<tr>
    <td> 
    <div style="overflow:hidden;" data-module="קביעת רמות">  
    
    <table class="myformtable1" style="width:40%;">';
    
    
    echo '</tr>';
    
    form_label_noformtd("רמת תוצאות הצבעה(%)", TRUE);
    form_text_noformtd("vote_level", array_item($formdata, "vote_level"), 36, 50, 3, "my_vote_level$decID");
    echo '</tr>';
    
    
    echo '<tr>';
    form_label_noformtd("רמת חשיבות החלטה: (1 עד 10)", TRUE);
    form_text_noformtd("dec_level", array_item($formdata, "dec_level"), 36, 50, 3, "my_dec_level$decID");
    echo '</tr>';
    
    /////////////////////////////////////////////////////////////////////////////////////////
    //style="width:20px;overflow:hidden;"
    
    $arr = array();
    $arr[0][0] = "סגורה";
    $arr[0][1] = "1";
    $arr[1][0] = "פתוחה";
    $arr[1][1] = "2";
    
    
    $selected = array_item($formdata, 'dec_status') ? array_item($formdata, 'dec_status') : $arr[1][1];
    
    echo '<tr> 
    <td colspan="3" >
    <div class="form-row" style="text-color:white;"><span class="h">סטטוס החלטה:&nbsp; &nbsp; </span></div></td>';
    
    echo '<td> ';
    form_list_find_notd_no_choose('dec_status', 'dec_status', $arr, $selected);
    echo '</td>';
    
    echo '</tr>', "\n";
    
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $arr = array();
    $arr[0][0] = "ציבורי";
    $arr[0][1] = "1";
    $arr[1][0] = "פרטי";
    $arr[1][1] = "2";
    $arr[2][0] = "סודי";
    $arr[2][1] = "3";
    
    $selected = array_item($formdata, 'dec_Allowed') ? array_item($formdata, 'dec_Allowed') : $arr[0][1];
    
    
    echo ' <td colspan="3" ><div class="form-row" style="float:right;text-color:white"><span class="h">סיווג החלטה:&nbsp; &nbsp; </span></div></td>';
    echo ' <td>';
    form_list_find_notd_no_choose('dec_allowed', 'dec_allowed', $arr, $selected);
    
    echo '</td>', "\n";
    
    ////////////////////////////////////////////////////////////////
    
    echo '</tr>
    </table></div>
    </td>
    </tr>';
    
    /*******************************************************************************************/
    //USERS
    /*****************************************************************************************/
    
    if (isset($formdata['dest_forums']) && array_item($formdata, 'dest_forums') && $formdata['dest_forums'] != 'none' && isset($formdata['fail']) && ($formdata['fail'] == false)){
    echo '<tr>
    <td>
    <div     style="overflow:hidden;"   data-module=" חברי פורום">';
    
    
    echo '</div>
    </td>
    </tr>';
    
    //-----------------------------------------------------------------------------------------------------------
    echo '<tr>';
    echo '<td>';
    
    //   echo '<div id="my_users_panel" class="my_users_panel">';
    echo '<h3 class="my_title_users_dec" style="height:15px"></h3>';
    
    echo '<div id="content_users_dec" class="content_users">';
    echo '<table class="myformtable1" id="my_table" style="width:80%" >';
    
    $j = 0;
    $decID = $formdata['decID'];
    
    foreach ($formdata['dest_forums'] as $frm_id){
    
    $sql = "SELECT forum_decName from forum_dec WHERE forum_decID=$frm_id ";
    if ($getForum_name = $db->queryObjectArray($sql)) {
    $forum_name = $getForum_name[0]->forum_decName;
    }
    
    
    ?>
    <tr>
    <td></td>
    </tr>
    
    
    <div class="form-row">
    <span class="h">חברי פורום בעת קבלת ההחלטה:<input id="forum_decName"
    name="forum_decName"
    type="text"
    value="<?php echo $forum_name; ?>"
    class="mycontrol"/></span>
    <br/>
    </div>
    
    <?php
    
    
    $i = 0;
    $sql = "select userID,HireDate from rel_user_Decforum where decID=$decID AND forum_decID=$frm_id ";
    if ($rows = $db->queryObjectArray($sql)) {
    foreach ($rows as $row) {
    echo '<tr>';
    echo '<td>';
    
    echo '<input type="hidden" class="userID" id="' . $row->userID . '' . $frm_id . '"  value="' . $row->userID . '" />';
    echo '<input type="hidden" class="forum_decID" id="' . $frm_id . '' . $row->userID . '"  value="' . $frm_id . '" />';
    $sql = "SELECT full_name from users WHERE userID=$row->userID";
    if ($getName = $db->queryObjectArray($sql)) {
    $member_name = $getName[0]->full_name;
    }
    
    
    $member_date = "member_date$frm_id$row->userID";
    
    
    form_label1("חבר פורום:");
    
    form_text_a("member", $member_name, 20, 50, 1, "member$frm_id$row->userID");
    
    
    if ($level)    {
    ?>
    
    <input type="button" class="mybutton" id="my_button_<?php echo $frm_id;
    echo $row->userID; ?>" value="ערוך משתמש"
    onClick="return editReg_user(<?php echo $row->userID; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?> );"
    ; return false;/>
    <?php }elseif (!($level)){
    ?>
    
    <input type="button" class="mybutton" id="my_button_<?php echo $frm_id;
    echo $row->userID; ?>" value="צפה בפרטי משתמש"
    onClick="return editReg_user(<?php echo $row->userID; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?> );"
    ; return false;/>
    <?php } ?>
    
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
    
    list($year_date, $month_date, $day_date) = explode('-', $row->HireDate);
    if (strlen($day_date) == 4) {
    $row->HireDate = "$year_date-$month_date-$day_date";
    } elseif (strlen($year_date) == 4) {
    $row->HireDate = "$day_date-$month_date-$year_date";
    }
    
    form_label1("תאריך צרוף לפורום:");
    form_text3("$member_date", $row->HireDate, 10, 50, 1, $member_date);
    /*************************************************************************/
    if ($level) {
    $sql_a = "SELECT  userID,HireDate  FROM  rel_user_forum WHERE forum_decID=$frm_id
    UNION	   
    SELECT  userID,start_date  FROM rel_user_forum_history  WHERE forum_decID=$frm_id";
    if ($rows_a = $db->queryObjectArray($sql_a)) {
    
    
    $rows_1 = 0;
    
    for ($i = 0; $i < count($rows_a); $i++) {
    if ($i == 0) {
    $rows_1 = $rows_a[$i]->userID;
    } else {
    $rows_1 .= "," . $rows_a[$i]->userID;
    }
    }
    
    
    $sql_b = "SELECT  userID ,full_name FROM users  WHERE userID in ($rows_1)	  ";
    $rows_b = $db->queryObjectArray($sql_b);
    $array = Array();
    foreach ($rows_b as $row1) {
    $array[$row1->userID] = $row1->full_name;
    }
    
    form_list_idx("change_usr$frm_id$row->userID", $array, array_item($formdata, "change_usr$frm_id$row->userID"), "class=change_user    id=change_usr$frm_id$row->userID");
    
    
    }
    }
    
    
    $i++;
    
    }//end second each
    //---------------------------------------------
    }
    
    echo '</td>';
    
    echo '</tr>';
    
    $j++;
    }//end first each
    
    
    echo '</table>';
    echo '</div>';
    
    echo '</td>';
    echo '</tr>';
    
    
    } else {
    
    echo '<tr>';
    echo '<td   class="myformtd">';
    echo '<div id="content_users" class="content_users">';
    echo '<table class="myformtable" id="my_table" style="width:80%" >';
    
    echo '</table>';
    echo '</div>';
    echo '</td> ';
    echo '</tr> ';
    
    }
    /******************************BUTTONS************************************************************************/
    echo '<tr>
    <td>
    <div     style="overflow:hidden;"   data-module="בצע פעולות">';
    
    
    echo '</div>
    </td>
    </tr>';
    
    if ($level){
    
    
    ?>
    <tr>
    <td>
    <table class="myformtable1" style="height:100px;width:98%;"
    id="conn_table<?php echo $decID; ?>">
    <tr>
    <?php
    
    /*************************************************************/
    if (array_item($formdata, "decID")){
    /*************************************************************/
    $decID = $formdata["decID"];
    
    
    ?>
    <td id="my_td<?PHP echo $decID; ?>">
    
    <?php
    
    form_button5("btnLink6_$decID", "שנה קישור ריאשון לפי חיפוש בטופס", "button", "btnLink6_$decID");
    form_button5("btnLinkWinFirst$decID", "שנה קישור ריאשון בחלון", "button", "btnLinkWinFirst$decID");
    form_button5("btnLink3_$decID", "קישור שני לפי חיפוש בטופס", "button", "btnLink3_$decID");//, "OnClick=\"return document.getElementById('mode_".$formdata["decID"]."').value='link_second'\";");
    form_button5("btnLinkWin_$decID", " שנה קישור שני בחלון", "button", "btnLinkWin_$decID");
    form_button5("btnLink0_$decID", "קשר לשורש(כול ההחלטות)", "button", "btnLink0_$decID");
    
    form_hidden("decID", $formdata["decID"]);
    $sql = "select parentDecID1 from decisions where decID= " . $db->sql_string($formdata['decID']);
    if ($rows = $db->queryObjectArray($sql)) {
    if ($rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)) {
    form_button5("btnLink4_$decID", "בטל קישור שני", "button", "btnLink4_$decID");
    
    }
    }
    
    
    //form_empty_cell_no_td(15);
    
    ?>
    
    </td>
    </tr>
    
    
    <tr>
    <td id="my_td2<?PHP echo $decID; ?>">
    
    &nbsp;&nbsp;
    <button class="green90x24" type="submit"
    name="submitbutton_<?php echo $formdata['decID']; ?>"
    id="submitbutton_<?php echo $formdata['decID']; ?>"
    onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID']; ?>'))
    ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID']; ?>'));">
    שמור
    </button>
    
    
    &nbsp;&nbsp;
    <button class="green90x24" type="button"
    name="submitbutton1_<?php echo $formdata['decID']; ?>"
    id="submitbutton1_<?php echo $formdata['decID']; ?>">
    →משימות
    </button>
    
    
    &nbsp;&nbsp;
    <button class="green90x24" type="button"
    name="submitbutton2_<?php echo $formdata['decID']; ?>"
    id="submitbutton2_<?php echo $formdata['decID']; ?>">
    משימות←
    </button>
    
    
    &nbsp;&nbsp;
    <button class="green90x24" type="submit"
    name="submitbutton3_<?php echo $formdata['decID']; ?>"
    id="submitbutton3_<?php echo $formdata['decID']; ?>"
    onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID']; ?>'))
    ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID']; ?>'));">
    העלה מידע
    </button>
    
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button class="green90x24" type="submit"
    name="btnDelete_<?php echo $formdata['decID']; ?>"
    id="btnDelete_<?php echo $formdata['decID']; ?>">מחק
    החלטה
    </button>
    
    
    <div id="loading">
    <img src="../images/loading4.gif" border="0"/>
    </div>
    
    
    <?php
    
    
    $tmp = (array_item($formdata, "decID")) ? "update" : "save";
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["decID"]);
    
    
    echo '</td>';
    
    
    /*************************************************************/
    } else {
    /*************************************************************/
    echo '<td  class="myformtd">';
    
    if (!array_item($formdata, "insertID") && !array_item($formdata, "btnLink1")) {
    //  form_button5("btnLink6_$decID",  "שנה קישור ריאשון לפי חיפוש","button","btnLink6_$decID");
    form_button2("btnLink2", "קשר לתת החלטה לפי חיפוש");
    if(isset($formdata["decID"]))
    form_hidden("decID", $formdata["decID"]);
    }
    
    
    $tmp = (array_item($formdata, "decID")) ? "update" : "save";
    if(isset($formdata["decID"])) {
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["decID"]);
    form_hidden("decID", $formdata["decID"]);
    form_hidden("insertID", $formdata["insertID"]);
    
    ?>
    <button class="green90x24" type="submit" value="שמור/עדכן"
    ,name="submitbutton_<?php echo $formdata['decID']; ?>"
    id="submitbutton_<?php echo $formdata['decID']; ?>"
    onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID']; ?>')),
    prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID']; ?>'));">
    שמור/עדכן
    </button>
    
    
    <?php
    }
    form_empty_cell_no_td(3);
    if(isset($formdata["btnClear"]))
    form_button4("btnClear", "הוסף החלטה/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\";");
    
    
    echo '</td>';
    
    
    }
    
    echo '</tr>
    </table>
    </td>
    </tr>';
    
    } elseif (!($level)) {
    
    if (array_item($formdata, "decID")) {
    $decID = $formdata["decID"];
    
    echo '<tr>
    <td>
    <table class="myformtable1" style="border:0;" id="conn_table"' . $decID . '" ">
    
    <tr><td>';
    form_hidden("decID", $formdata["decID"]);
    ?>
    
    
    &nbsp;&nbsp;
    <button class="green90x24" type="button"
    name="submitbutton1_<?php echo $formdata['decID']; ?>"
    id="submitbutton1_<?php echo $formdata['decID']; ?>">
    →משימות
    </button>
    
    
    &nbsp;&nbsp;
    <button class="green90x24" type="button"
    name="submitbutton2_<?php echo $formdata['decID']; ?>"
    id="submitbutton2_<?php echo $formdata['decID']; ?>">
    משימות←
    </button>
    
    &nbsp;&nbsp;
    
    
    <button class="green90x24" type="submit"
    name="submitbutton3_<?php echo $formdata['decID']; ?>"
    id="submitbutton3_<?php echo $formdata['decID']; ?>"
    onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID']; ?>'))
    ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID']; ?>'));">
    העלה מידע
    </button>
    
    
    <?php
    echo '</td></tr>
    </table>
    </td>
    </tr>';
    
    
    }
    }
    /******************************************************************************************************/
    
    
    echo '</table></fieldset></form>';//end main form
    
    ?>
    <!-- ============================================================================================================ -->
    
    
    <div id="page_useredit" class="page_useredit"
    style="display:none">
    
    <h3 class="my_title" style=" height:15px"></h3>
    <h3><?php __('edit_user'); ?></h3>
    
    <div class="content">
    
    
    <form onSubmit="return saveUser3(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>);"
    name="edituser" id="edituser">
    <input type="hidden"
    name="Request_Tracking_Number_1"
    id="Request_Tracking_Number_1" value=""/>
    <input type="hidden"
    name="Request_Tracking_Number_1"
    id="Request_Tracking_Number_2" value=""/>
    <input type="hidden" name="Request_Tracking_Number1"
    id="Request_Tracking_Number1" value=""/>
    <input type="hidden" name="Request_Tracking_Number2"
    id="Request_Tracking_Number2" value=""/>
    <input type="hidden" name="id" value=""/>
    <input type="hidden" name="forum_decID"
    id="forum_decID"
    value="<?php  if(isset($formdata['forum_decision']))     echo $formdata['forum_decision']; ?>"/>
    
    
    <div class="form-row">
    <span class="h"><?php __('priority'); ?></span>
    <SELECT name="prio" id="prio" class="mycontrol">
    <option value="3">+3</option>
    <option value="2">+2</option>
    <option value="1">+1</option>
    <option value="0" selected>&plusmn;0
    </option>
    <option value="-1">&minus;1</option>
    </SELECT>
    &nbsp;
    
    
    <span class="h"><?php __('active'); ?></span>
    <SELECT name="active" id="active"
    class="mycontrol">
    <option value="0">0</option>
    <option value="1" selected>1</option>
    </SELECT>
    &nbsp;
    
    
    <span class="h"><?php __('due'); ?> </span>
    <input name="duedate3" id="duedate3" value=""
    class="in100"
    title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M"
    autocomplete="off"/>
    </div>
    
    
    <div class="form-row">
    <span class="h"><?php __('level'); ?></span>
    <SELECT name="level" id="level"
    class="mycontrol">
    <option value="1"><?php __('forum_user') ?></option>
    <option value="2"><?php __('admin') ?></option>
    <option value="3"><?php __('suppervizer') ?></option>
    <option value="none" selected>(בחר אופציה)
    </option>
    </SELECT>
    
    </div>
    
    
    <div class="form-row"><span
    class="h"><?php __('full_name'); ?></span><br>
    <input type="text" name="full_name"
    id="full_name" value="" class="in200"
    maxlength="50"/></div>
    
    <div class="form-row"><span
    class="h"><?php __('user'); ?></span><br>
    <input type="text" name="user" id="user"
    value="" class="in200" maxlength="50"/>
    </div>
    
    <div class="form-row"><span
    class="h"><?php __('upass'); ?></span><br>
    <input type="text" name="upass" id="upass"
    value="" class="in200" maxlength="50"/>
    </div>
    <div class="form-row"><span
    class="h"><?php __('email'); ?></span><br>
    <input type="text" name="email" id="email"
    value="" class="in200" maxlength="50"/>
    </div>
    <div class="form-row"><span
    class="h"><?php __('phone'); ?></span><br>
    <input type="text" name="phone" id="phone"
    value="" class="in200" maxlength="50"/>
    </div>
    <div class="form-row"><span
    class="h"><?php __('note'); ?></span><br>
    <textarea name="note" id="note"
    class="in500"></textarea></div>
    <div class="form-row"><span
    class="h"><?php __('tags'); ?></span><br>
    <input type="text" name="tags" id="edittags1"
    value="" class="in500" maxlength="250"/>
    </div>
    <div class="form-row">
    <?php if ($level) { ?>
    <input type="submit" id="edit_usr"
    value="<?php __('save'); ?>"
    onClick="this.blur()"/>
    <?php } ?>
    <input type="button"
    value="<?php __('cancel'); ?>"
    onClick="canceluserEdit3();this.blur();return false"/>
    
    
    </div>
    </form>
    
    </div> <!--  end div content -->
    
    </div> <!--  end of page_user_edit -->
    
    
    <!-- ============================================================================================================ -->
    
    <?php
    
    /************************************************************************************************************/
    if (array_item($formdata, "decID") && (is_numeric($formdata['decID']))){
    
    
    $decID = $formdata['decID'];
    ?>
    
    <div id="content_my_dec<?php echo $decID ?>">
    
    
    <table id="my_dec<?php echo $decID; ?>">
    <tr>
    <td>
    <?php
    
    
    /*************************************************************************/
    if (isset($formdata['single_frm']) && !($formdata['single_frm'] == 1)) {
    
    if (array_item($formdata, "dest_forums$decID")) {
    $i = 0;
    foreach ($formdata["dest_forums$decID"] as $key => $val) {
    $formdata['forum_decID'][$i] = $val;
    $i++;
    }
    
    }
    if (is_array($formdata['forum_decID']))
    foreach ($formdata['forum_decID'] as $forum_decID) {
    if (is_numeric($forum_decID)) {
    $getUser_sql = "SELECT u.* FROM users u 
    inner join rel_user_forum r  
    on u.userID = r.userID              
    WHERE r.forum_decID = $forum_decID
    ORDER BY u.full_name ASC";
    
    if ($rows = $db->queryObjectArray($getUser_sql)) {
    
    
    ?>
    
    <input type=hidden
    name="decID"
    id="decID"
    value="<?php echo $decID ?>"/>
    <input type=hidden
    name="forum_decID"
    id="forum_decID"
    value="<?php echo $forum_decID ?>"/>
    
    <?php
    
    
    //  require_once(TASK_DIR.'/index_test2.php');
    
    //$lang->build_task_form2($decID,$forum_decID);
    
    // echo '</td></tr>';
    
    
    }
    }
    }
    
    /********************************************************/
    }//end if
    /*********************************************************/
    else {
    
    $forum_decID = $formdata['forum_decision'];
    if (is_numeric($forum_decID)) {
    $getUser_sql = "SELECT u.* FROM users u 
    inner join rel_user_forum r  
    on u.userID = r.userID              
    WHERE r.forum_decID = $forum_decID
    ORDER BY u.full_name ASC";
    
    if ($rows = $db->queryObjectArray($getUser_sql)) {
    
    
    ?>
    
    <input type=hidden name="decID"
    id="decID"
    value="<?php echo $decID ?>"/>
    <input type=hidden
    name="forum_decID"
    id="forum_decID"
    value="<?php echo $forum_decID ?>"/>
    
    <?php
    
    
    // require_once(TASK_DIR.'/index.php');
    //require_once(TASK_DIR.'/index_test2.php');
    // $lang->build_task_form2($decID,$forum_decID);
    
    }
    /**********************************************************/
    }
    
    /**********************************************************/
    }//end else
    /**********************************************************/
    
    echo '</td></tr></table>';//end of my_dec+id
    echo '</div>';//end div slide the table (content_my_dec)
    }//end if array_item
    /***********************************************************************************************************/
    
    ?>
    
    <div id="loading">
    <img src="../images/loading4.gif"
    border="0"/>
    </div>
    
    <div id="target_task"></div>
    <?php
    /***********************************************************************************************************/
    
    
    echo '</div>'; //end div main
    
    /*************************************************************************************************/
    }//end build ajx_form
    /*************************************************************************************************/
    
    function build_form_dec_ajxMult(&$formdata) {
    global $db;
    global $lang;
    $decID = $formdata['decID'];
    $dest_forums = $formdata['dest_forums'];
    ?>
    
    
    <input type="hidden" id="decID" name="decID"
    value="<?php echo $decID; ?>"/>
    
    <h4 class="my_Dectitle_<?php echo $formdata['decID']; ?>"
    style="height:15px"></h4>
    <div id="main_content<?php echo $formdata['decID']; ?>">
    
    
    <h4 class="my_main_fieldset<?php echo $formdata['decID'] ?>"
    style="height:15px;cursor:pointer;"></h4>
    
    <form method="post"
    name="decision_<?php echo $formdata['decID'] ?>"
    id="decision_<?php echo $formdata['decID'] ?>"
    action="../admin/dynamic_5c.php"
    onSubmit="prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID'] ?>')) ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID'] ?>'));">
    
    <fieldset
    id="main_fieldset<?php echo $formdata['decID'] ?>"
    style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">
    <legend>
    <h1 style="color:brown;width:80%;">
    החלטות עין השופט</h1>
    </legend>
    
    <div id="decision_b_<?php echo $formdata['decID'] ?>"
    name="decision_b_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision_a_<?php echo $formdata['decID'] ?>"
    name="decision_a_<?php echo $formdata['decID'] ?>"></div>
    
    
    <h4 id="my_menu_items_dec_title<?php echo $formdata['decID']; ?>"
    class="my_menu_items_dec_title<?php echo $formdata['decID']; ?>"
    style="height:15px;cursor:pointer;"></h4>
    <div id="my_error_message<?php echo $formdata['decID']; ?>"
    name="my_error_message<?php $formdata['decID']; ?>"></div>
    <ul id="menu_items_dec<?php echo $formdata['decID']; ?>"
    name="menu_items_dec<?php echo $formdata['decID']; ?>"
    class="menu_items_dec<?php echo $formdata['decID']; ?>">
    <input type=hidden
    name="menu_items_dec_hidden<?php echo $formdata['decID'] ?>"
    id="menu_items_dec_hidden<?php echo $formdata['decID'] ?>"
    value="<?php echo $formdata['decID'] ?>"/>
    
    <!--   <div id="decision0_<?php echo $formdata['decID'] ?>"  name="decision0_<?php echo $formdata['decID'] ?>" style="overflow:auto;hieght:400px;"></div>  -->
    <div id="decision0_<?php echo $formdata['decID'] ?>"
    name="decision0_<?php echo $formdata['decID'] ?>"
    style="overflow:auto;hieght:1000px;"></div>
    <div id="decision1_<?php echo $formdata['decID'] ?>"
    name="decision1_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision2_<?php echo $formdata['decID'] ?>"
    name="decision2_<?php echo $formdata['decID'] ?>"></div>
    
    
    <div id="decision4_<?php echo $formdata['decID'] ?>"
    name="decision4_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision5_<?php echo $formdata['decID'] ?>"
    name="decision5_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision6_<?php echo $formdata['decID'] ?>"
    name="decision6_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision7_<?php echo $formdata['decID'] ?>"
    name="decision7_<?php echo $formdata['decID'] ?>"></div>
    
    
    <div id="decision3a_<?php echo $formdata['decID'] ?>"
    name="decision3a_<?php echo $formdata['decID'] ?>"></div>
    
    
    <div id="decision8_<?php echo $formdata['decID'] ?>"
    name="decision8_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision9_<?php echo $formdata['decID'] ?>"
    name="decision9_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision10_<?php echo $formdata['decID'] ?>"
    name="decision10_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision11_<?php echo $formdata['decID'] ?>"
    name="decision11_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision12_<?php echo $formdata['decID'] ?>"
    name="decision12_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision13_<?php echo $formdata['decID'] ?>"
    name="decision13_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision14_<?php echo $formdata['decID'] ?>"
    name="decision14_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision15_<?php echo $formdata['decID'] ?>"
    name="decision15_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision16_<?php echo $formdata['decID'] ?>"
    name="decision16_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision17_<?php echo $formdata['decID'] ?>"
    name="decision17_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision18_<?php echo $formdata['decID'] ?>"
    name="decision18_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision19_<?php echo $formdata['decID'] ?>"
    name="decision19_<?php echo $formdata['decID'] ?>"></div>
    <div id="decision20_<?php echo $formdata['decID'] ?>"
    name="decision20_<?php echo $formdata['decID'] ?>"></div>
    
    
    <div id="decision_<?php echo $formdata['decID'] ?>-message"
    name="decision_<?php echo $formdata['decID'] ?>-message"></div>
    <div id="decision-message<?php echo $formdata['decID'] ?>"
    name="decision-message<?php echo $formdata['decID'] ?>"></div>
    <div id="decision6"
    name="decision6"></div>
    
    
    </ul>
    
    
    <table id="" myformtable1<?php echo $formdata['decID'] >
    
    
    $decID = isset($formdata['decID']) ? $formdata['decID'] : '';
    if (array_item($formdata, 'decID')) {
    $dec = new decisions();
    $dec->print_decision_entry_form1_c($formdata['decID']);
    }
    //=======================================================================================
    // decision
    
    echo '<tr>
    <td   class="myformtd" > 
    <div  style="overflow:hidden;" data-module="שם כותרת החלטה:">
    <table class="myformtable1"   style="height:100px;width:98%;">
    <tr>';
    
    
    form_textarea("subcategories", array_item($formdata, "subcategories"), 30, 5, 3, "my_text_erea$decID");
    
    //$dec_date="dec_date$decID";
    
    
    ?>
    <td class="myformtd"
    id="my_date<?php echo $decID; ?>"><?php
    form_label1("תאריך החלטה:", true);
    form_text3("dec_date$decID", array_item($formdata, "dec_date$decID"), 10, 10, 1, "dec_date$decID");
    
    /**************************************************************************************/
    ?>
    
    <script language="JavaScript" type="text/javascript">
    $(document).ready(function () {
    var decID =<?php echo $decID; ?>;
    $("#dec_date" + decID).datepicker($.extend({}, {
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


        var pdfID =<?php echo $pdfID; ?>;
        $("#pdf_date" + decID).datepicker($.extend({}, {
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
    
    echo '</td class="myformtd">';
    //////////////////////////////////////////////////////////////////////////////////////////////
    
    
    form_label("הזנת תאריכים לכמה החלטות:", true);
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
    
    echo '<td colspan="3">';
    list11("multi_year", $years, array_item($formdata, "multi_year"), " multiple size=6 id='mult_yearID$decID'   ");
    
    list11("multi_month", $months, array_item($formdata, "multi_month"), " multiple size=6 id='mult_monthID$decID'   ");
    
    list11("multi_day", $days, array_item($formdata, "multi_day"), " multiple size=6 id='mult_dayID$decID'   ");
    echo '</td>';
    /////////////////////////////////////////////////////////////////////////////////////////////
    
    echo '</tr>
    </table>
    </div>
    </td>
    </tr>';
    
    
    /************************************FORUMS*****************************************************/
    // forum_dec
    
    echo '<tr>
    <td   class="myformtd" > 
    <div  style="overflow:hidden;" data-module="הזנת  הפורומים:">
    <table class="myformtable1" style="overflow:auto;border:1;width:98%;">
    <tr>';
    
    $decID = $formdata['decID'];
    $formdata["dest_forums$decID"] = $formdata["dest_forums"];
    
    
    $sql = "SELECT forum_decName, forum_decID, parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    
    foreach ($rows as $row) {
    $forumType[$row->parentForumID][] = $row->forum_decID;
    $forumNames[$row->forum_decID] = $row->forum_decName;
    }
    
    $rows = build_category_array($forumType[NULL], $forumType, $forumNames);
    $rows2 = build_category_array($forumType[NULL], $forumType, $forumNames);
    
    
    echo '<td class="myformtd">';
    
    form_list111("src_forums$decID", $rows, array_item($formdata, "src_forums$decID"), "multiple size=6 id='src_forums$decID' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums$decID'), document.getElementById('dest_forums$decID'));\"");
    
    echo '</td>';
    
    
    if ($formdata["dest_forums$decID"] && $formdata["dest_forums$decID"] != 'none'){
    
    
    $dest_forums = $formdata["dest_forums$decID"];
    unset($staff_test);
    unset($staff_testb);
    foreach ($dest_forums as $key => $val) {
    if (!is_numeric($val)) {
    $val = $db->sql_string($val);
    $staff_test[] = $val;
    } elseif (is_numeric($val)) {
    $staff_testb[] = $val;
    }
    }
    if (is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    
    }
    
    } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    
    }
    $staffb = implode(',', $staff_testb);
    
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staffb)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name_b[$row->forum_decID] = $row->forum_decName;
    }
    $name = array_merge($name, $name_b);
    unset($staff_testb);
    } /************************************************************************/
    else {
    
    
    foreach ($formdata["dest_forums$decID"] as $frmID) {
    $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($frmID)";
    if ($rows = $db->queryObjectArray($sql2))
    $name[$rows[0]->forum_decID] = $rows[0]->forum_decName;
    }
    
    
    }
    /*************************************************************************/
    ?>
    
    <td class="myformtd">
    
    <input type=button
    name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID; ?>'), document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list<?php echo $decID; ?>();'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    
    
    </td>
    
    
    <?PHP
    
    
    form_list11("dest_forums$decID", $name, array_item($formdata, "dest_forums$decID"), "multiple size=6 id='dest_forums$decID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_forums$decID'));\"");
    
    
    } elseif ($formdata["src_forums$decID"] && $formdata["src_forums$decID"][0] != 0 && !$formdata["dest_forums$decID"]) {
    
    $dest_forum_dec = $formdata["src_forums$decID"];
    
    for ($i = 0; $i < count($dest_forum_dec); $i++) {
    if ($i == 0) {
    $userNames = $dest_forum_dec[$i];
    } else {
    $userNames .= "," . $dest_forum_dec[$i];
    
    }
    
    }
    
    
    $name = explode(",", $userNames);
    
    $sql2 = "select forum_decID,forum_decName from forum_dec where forum_decID in ($userNames)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->forum_decID] = $row->forum_decName;
    
    }
    
    
    ?>
    <td class="myformtd">
    <input type=button
    name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID; ?>'), document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    </td>
    <?PHP
    form_list11("src_forums$decID", $name, array_item($formdata, "src_forums$decID"), "multiple size=6 id='src_forums$decID' ondblclick=\"add_item_to_select_box(document.getElementById('src_forums$decID'), document.getElementById('dest_forums$decID'));\"");
    
    
    } else {
    
    
    ?>
    
    <td class="myformtd">
    <input type=button
    name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_forums<?php echo $decID; ?>'), document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"/>
    </td>
    
    
    <td class="myformtd">
    <select class="mycontrol"
    name='arr_dest_forums<?php echo $decID; ?>[]'
    dir=rtl
    id='dest_forums<?php echo $decID; ?>'
    ondblclick="remove_item_from_select_box(document.getElementById('dest_forums<?php echo $decID; ?>'));"
    MULTIPLE SIZE=6
    style='width:180px;'></select>
    </td>
    
    
    <?
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
    
    
    form_label("שם פורום חדש", TRUE);
    form_textarea("new_forum$decID", array_item($formdata, "new_forum"), 14, 5, 1, "new_forum$decID");
    
    form_label("קשר לפורום:", TRUE);
    form_list1idx("insert_forum$decID", $rows2, array_item($formdata, "insert_forum"), " multiple size=6 width=1", "id=insert_forum$decID");
    
    
    //	if($formdata['forum_decision'] && array_item($formdata,'forum_decision') )
    //  $forum_decID=$formdata['forum_decision']?$formdata['forum_decision']:$formdata['forum_decID'];
    
    $forum_decID = $formdata['dest_forums'][0];//$forum_decID?$forum_decID:$formdata['forum_decision'];
    if ($forum_decID && (is_numeric($forum_decID))) {
    $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID=$forum_decID";
    if ($rows = $db->queryObjectArray($sql)) {
    $forum_name = $rows[0]->forum_decName;
    }
    }
    
    echo '<tr><td class="myformtd" colspan="8">';
    form_url2("pdf_brand.php?mode=read_data&editID=$forum_decID", "ערוך פורום-$forum_name", 4);
    echo '</td></tr>';
    
    
    echo '</tr>
    </table>
    </div>
    </td>
    </tr>';
    
    /**************************************DESC_DEC***************************************************/
    //  <button type="button" id="descButton_'.$decID.'" class="green90x24">תבנית תאור</button>
    echo '<tr>
    <td   class="myformtd" >
    <div  id="desc_table' . $decID . '"   style="overflow:hidden;"   data-module="ההחלטה עצמה(תאור ההחלטה)">';
    
    
    if ($formdata["dest_forums$decID"]) {
    foreach ($formdata["dest_forums$decID"] as $forum_decID) {
    echo '<div id="notelist' . $decID . '' . $forum_decID . '" ></div>';
    }
    }
    
    
    echo '
    </div>
    </td>
    </tr>';
    /*************************************DECISIONS_TYPE*****************************************************************/
    
    
    $decID = $formdata['decID'];
    $formdata["dest_decisionsType$decID"] = $formdata["dest_decisionsType"];
    echo '<tr>
    <td   class="myformtd" > 
    <div  style="overflow:hidden;" data-module="הזנת  סוגי ההחלטה:">
    <table class="myformtable1" style="overflow:auto;border:1;width:98%;">
    <tr>';
    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    $rows = $db->queryObjectArray($sql);
    
    foreach ($rows as $row) {
    $subcatsftype[$row->parentCatID][] = $row->catID;
    $catNamesftype[$row->catID] = $row->catName;
    }
    
    $rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
    $rows2 = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
    
    
    echo '<td class="myformtd">';
    
    form_list111("src_decisionsType$decID", $rows, array_item($formdata, "src_decisionsType$decID"), "multiple size=6 id='src_decisionsType$decID' style='width:180px;' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType$decID'), document.getElementById('dest_decisionsType$decID'));\"");
    
    echo '</td>';
    
    
    if ($formdata["dest_decisionsType$decID"] && $formdata["dest_decisionsType$decID"] != 'none') {
    
    
    $dest_decisionsType = $formdata["dest_decisionsType$decID"];
    unset($staff_test);
    unset($staff_testb);
    foreach ($dest_decisionsType as $key => $val) {
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
    
    $name[$row->catID] = $row->catName;
    
    
    }
    
    } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
    $staff = implode(',', $staff_test);
    
    $sql2 = "select catID, catName from categories where catName in ($staff)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->catID] = $row->catName;
    
    
    }
    $staffb = implode(',', $staff_testb);
    
    $sql2 = "select catID, catName from categories where catID in ($staffb)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name_b[$row->catID] = $row->catName;
    }
    $name = array_merge($name, $name_b);
    unset($staff_testb);
    } /***************************************************************************/
    else {
    
    
    foreach ($formdata["dest_decisionsType$decID"] as $catID) {
    $sql2 = "select catID, catName from categories where catID in ($catID)";
    if ($rows = $db->queryObjectArray($sql2))
    
    $name_1[$rows[0]->catID] = $rows[0]->catName;
    }
    
    
    }
    /**********************************************************************/
    ?>
    
    <td class="myformtd">
    
    <input type=button
    name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID; ?>'), document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    
    
    </td>
    
    
    <?PHP
    
    
    form_list11("dest_decisionsType$decID", $name_1, array_item($formdata, "dest_decisionsType$decID"), "multiple size=6 id='dest_decisionsType$decID' style='width:180px;' ondblclick=\"remove_item_from_select_box(document.getElementById('dest_decisionsType$decID'));\"");
    
    
    }
    if ($formdata["src_decisionsType$decID"] && $formdata["src_decisionsType$decID"][0] != 0 && !$formdata["dest_decisionsType$decID"]) {
    
    $dest_types = $formdata["src_decisionsType$decID"];
    
    for ($i = 0; $i < count($dest_types); $i++) {
    if ($i == 0) {
    $userNames = $dest_types[$i];
    } else {
    $userNames .= "," . $dest_types[$i];
    
    }
    
    }
    
    
    $name = explode(",", $userNames);
    
    $sql2 = "select catID,catName from categories where catID in ($userNames)";
    if ($rows = $db->queryObjectArray($sql2))
    foreach ($rows as $row) {
    
    $name[$row->catID] = $row->catName;
    
    }
    
    
    ?>
    
    <td class="myformtd">
    <input type=button
    name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID; ?>'), document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    </td>
    
    
    <?PHP
    form_list11("src_decisionsType$decID", $name, array_item($formdata, "src_decisionsType$decID"), "multiple size=6 id='src_decisionsType$decID' ondblclick=\"add_item_to_select_box(document.getElementById('src_decisionsType$decID'), document.getElementById('dest_decisionsType$decID'));\"");
    
    
    } else {
    
    
    ?>
    
    <td class="myformtd">
    <input type=button
    name='add_to_list<?php echo $decID; ?>'
    value='הוסף לרשימה &gt;&gt;'
    OnClick="add_item_to_select_box(document.getElementById('src_decisionsType<?php echo $decID; ?>'), document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    <BR><BR><input type=button
    name='remove_from_list()<?php echo $decID; ?>;'
    value='<< הוצא מרשימה'
    OnClick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"/>
    </td>
    
    
    <td class="myformtd">
    <select class="mycontrol"
    name='arr_dest_decisionsType<?php echo $decID; ?>[]'
    dir=rtl
    id='dest_decisionsType<?php echo $decID; ?>'
    ondblclick="remove_item_from_select_box(document.getElementById('dest_decisionsType<?php echo $decID; ?>'));"
    MULTIPLE SIZE=6
    style='width:180px;'></select>
    </td>
    
    <?PHP
    
    
    }
    form_label("סוג החלטה חדש", TRUE);
    form_textarea("new_decisionType$decID", array_item($formdata, "new_decisionType$decID"), 14, 5, 1, "new_decisionType$decID");
    form_label("קשר לסוג החלטה", TRUE);
    
    if (array_item($formdata, "insert_decisionType$decID")) {
    form_list1idx("insert_decisionType$decID", $rows2, array_item($formdata, "insert_decisionType$decID"), "multiple size=6 id=insert_decisionType$decID");
    } else
    form_list1("insert_decisionType$decID", $rows2, array_item($formdata, "insert_decisionType$decID"), "multiple size=6 id=insert_decisionType$decID");
    
    echo '<tr><td class="myformtd" colspan="11">';
    form_url2("categories.php", "ערוך סוגי החלטות", 1);
    echo '</td></tr>';
    
    echo '</tr>
    </table>
    </div>
    </td>
    </tr>';
    /**************************************USERS************************************************************/
    
    if (array_item($formdata, "dest_forums$decID") && $formdata["dest_forums$decID"] != 'none' && (!$formdata['fail'])){
    
    
    echo '<tr>
    <td>
    <div   data-module="חברי פורום">';
    
    
    echo '
    </div>
    </td>
    </tr>';
    
    
    echo '<tr>';
    echo '<td   class="myformtd">';
    
    echo '<h5  id="my_title_users' . $decID . '" style=" height:15px"></h5>';
    
    
    echo '<table class="myformtable1" id="my_Dectable' . $decID . '" style="width:60%" align="right">';
    echo '<div id="content_users' . $decID . '" >';
    $j = 0;
    $decID = $formdata['decID'];
    /***************************************************/
    foreach ($formdata["dest_forums$decID"] as $frm_id){
    
    $sql = "SELECT forum_decName from forum_dec WHERE forum_decID=$frm_id ";
    if ($getForum_name = $db->queryObjectArray($sql)) {
    $forum_name = $getForum_name[0]->forum_decName;
    }
    
    
    ?>
    <tr>
    <td class="myformtd" id="myformtd">
    <ul>
    
    
    <div class="form-row">
    <span class="h">חברי פורום בעת קבלת ההחלטה:<input
    id="forum_decName<?php echo $decID; ?>"
    name="forum_decName<?php echo $decID; ?>"
    type="text"
    value="<?php echo $forum_name; ?>"
    class="mycontrol"/></span>
    <br/>
    </div>
    
    <?php
    $i = 0;
    $sql = "select userID,HireDate from rel_user_Decforum where decID=$decID AND forum_decID=$frm_id ";
    if ($rows = $db->queryObjectArray($sql)) {
    foreach ($rows as $row) {
    /**************************************************/
    echo '<li>';
    $sql = "SELECT full_name from users WHERE userID=$row->userID";
    if ($getName = $db->queryObjectArray($sql)) {
    $member_name = $getName[0]->full_name;
    }
    
    
    $member_date = "member_date$i$j$frm_id";
    
    
    form_label1("חבר פורום:");
    form_text_a("member", $member_name, 20, 50, 1);
    
    
    ?>
    
    <input type="button"
    class="mybutton"
    id="my_button_<?php echo $row->userID; ?>"
    value="ערוך משתמש"
    onClick="return editReg_user(<?php echo $row->userID; ?>,<?php echo " '" . ROOT_WWW . "/admin/' "; ?> );"
    ; return false;/ >
    
    <script language="JavaScript"
    type="text/javascript">
    
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
    
    list($year_date, $month_date, $day_date) = explode('-', $row->HireDate);
    if (strlen($day_date) == 4) {
    $row->HireDate = "$year_date-$month_date-$day_date";
    } elseif (strlen($year_date) == 4) {
    $row->HireDate = "$day_date-$month_date-$year_date";
    }
    
    form_label1("תאריך צרוף לפורום:");
    form_text3("$member_date", $row->HireDate, 10, 50, 1, $member_date);
    
    echo '</li>';
    $i++;
    
    }//end second each
    }
    echo '</ul>';
    
    echo '</td>';
    
    echo '</tr>';
    
    $j++;
    }//end first each
    
    echo '</div>';
    echo '</table>';
    
    echo '</td>';
    echo '</tr>';
    
    
    } else {
    echo '
    <tr>
    <td   class="myformtd"> 
    <table class="myformtable1" id="my_table' . $decID . '" style="width:50%" > 
    <div id="content_users' . $decID . '" class="content_users">';
    
    
    echo '</div>
    </table> 
    </td> 
    </tr> ';
    
    }
    
    
    echo '<tr>
    <td   class="myformtd" > 
    <div   data-module="קביעת רמות:">
    <table class="myformtable1"  style="width:60%;">
    <tr>';
    
    $decID = $formdata['decID'];
    /////////////////////////////////////////////////////////////////
    form_label("רמת תוצאות הצבעה(%)", TRUE);
    form_text("vote_level", array_item($formdata, "vote_level"), 36, 50, 1, "my_vote_level$decID");
    
    
    echo '<tr>';
    form_label("רמת חשיבות החלטה: (1 עד 10)", TRUE);
    form_text("dec_level", array_item($formdata, "dec_level"), 36, 50, 1, "my_dec_level$decID");
    echo '</tr>';
    
    
    //echo '<tr>';
    // form_label("סטטוס החלטה: (1=פתוחה/0=סגורה)", TRUE);
    //
    // form_text("dec_status", array_item($formdata, "dec_status"),  36 , 50 , 1,"my_status$decID");
    //echo '</tr>';
    
    /////////////////////////////////////////////////////////////////////////////////////////
    
    echo '<tr> 
    <td class="myformtd"  >
    <div class="form-row" style="text-color:white;">';
    
    
    $arr = array();
    $arr[0][0] = "סגורה";
    $arr[0][1] = "1";
    $arr[1][0] = "פתוחה";
    $arr[1][1] = "2";
    
    
    $selected = array_item($formdata, 'dec_status') ? array_item($formdata, 'dec_status') : $arr[1][1];
    
    ?>
    
    <span class="h">סטטוס החלטה:&nbsp; &nbsp; </span>
    </div>
    </td>
    
    <?php
    echo '<td class="myformtd"> ';
    form_list_find_notd_no_choose('dec_status', 'dec_status', $arr, $selected);
    //form_list_find_notd_no_choose2('dec_status', $arr, $selected, $str="");
    
    echo '</td>';
    
    echo '</tr>', "\n";
    
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    echo ' <td class="myformtd"   ><div class="form-row" style="float:right;text-color:white">';
    
    
    $arr = array();
    $arr[0][0] = "ציבורי";
    $arr[0][1] = "1";
    $arr[1][0] = "פרטי";
    $arr[1][1] = "2";
    $arr[2][0] = "סודי";
    $arr[2][1] = "3";
    
    $selected = array_item($formdata, 'dec_Allowed') ? array_item($formdata, 'dec_Allowed') : $arr[0][1];
    ?>
    
    <span class="h"><?php __('allowed'); ?>&nbsp; &nbsp; </span>
    <td class="myformtd">
    <?php
    form_list_find_notd_no_choose('dec_allowed', 'dec_allowed', $arr, $selected);
    
    echo '</td></div></td>', "\n";
    
    
    echo '</tr>
    </table>
    </div>
    </td>
    </tr>';
    /****************************************************************************************************/
    echo '<tr>
    <td>
    <div   data-module="פעולות לביצוע">';
    
    
    echo '
    </div>
    </td>
    </tr>';
    
    ?>
    <tr>
    <td class="myformtd">
    <table class="myformtable1" style="border:0;"
    id="conn_table<?php echo $decID; ?>">
    <tr id="conn_tr<? echo $decID; ?>"><?php
    
    
    if (array_item($formdata, "decID")){
    $decID = $formdata["decID"];
    
    
    ?>
    <td class="myformtd"
    id="my_td<?PHP echo $decID; ?>"><?php
    
    
    form_button5("btnLink6_$decID", "שנה קישור ריאשון לפי חיפוש בטופס", "button", "btnLink6_$decID");
    form_button5("btnLinkWinFirst$decID", "שנה קישור ריאשון בחלון", "button", "btnLinkWinFirst$decID");
    form_button5("btnLink3_$decID", "קישור שני לפי חיפוש בטופס", "button", "btnLink3_$decID");//, "OnClick=\"return document.getElementById('mode_".$formdata["decID"]."').value='link_second'\";");
    form_button5("btnLinkWin_$decID", " שנה קישור שני בחלון", "button", "btnLinkWin_$decID");
    form_button5("btnLink0_$decID", "קשר לשורש(כול ההחלטות)", "button", "btnLink0_$decID");
    
    form_hidden("decID", $formdata["decID"]);
    $sql = "select parentDecID1 from decisions where decID= " . $db->sql_string($formdata['decID']);
    if ($rows = $db->queryObjectArray($sql)) {
    if ($rows[0]->parentDecID1 && is_numeric($rows[0]->parentDecID1)) {
    form_button5("btnLink4_$decID", "בטל קישור שני", "button", "btnLink4_$decID");
    
    }
    }
    
    
    //form_empty_cell_no_td(15);
    
    ?>
    
    </td>
    </tr>
    
    
    <tr>
    <td class="myformtd" id="my_td2<?PHP echo $decID; ?>">
    
    
    <button class="green90x24" type="submit"
    name="submitbutton_<?php echo $formdata['decID']; ?>"
    id="submitbutton_<?php echo $formdata['decID']; ?>"
    onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID']; ?>'))
    ,prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID']; ?>'));">
    שמור
    </button>
    
    
    &nbsp;&nbsp;
    <button class="green90x24" type="button"
    name="submitbutton1_<?php echo $formdata['decID']; ?>"
    id="submitbutton1_<?php echo $formdata['decID']; ?>">
    →משימות
    </button>
    &nbsp;&nbsp;
    <button class="green90x24" type="button"
    name="submitbutton2_<?php echo $formdata['decID']; ?>"
    id="submitbutton2_<?php echo $formdata['decID']; ?>">
    משימות←
    </button>
    
    
    <!--
    
    <button class="green90x24" type="submit" name="submitbutton3_<?php echo $formdata['decID']; ?>"  id="submitbutton3_<?php echo $formdata['decID']; ?>"
    onclick="return  document.getElementById('mode_').value='take_data';"  >העלה מידע</button>
    
    -->
    <button class="green90x24" type="submit"
    name="submitbutton3_<?php echo $formdata['decID']; ?>"
    id="submitbutton3_<?php echo $formdata['decID']; ?>">
    העלה מידע
    </button>
    
    
    &nbsp;&nbsp;
    
    
    <button class="green90x24" type="submit"
    name="btnDelete__<?php echo $formdata['decID']; ?>"
    id="btnDelete_<?php echo $formdata['decID']; ?>">
    מחק החלטה
    </button>
    <?php
    
    $tmp = (array_item($formdata, "decID")) ? "update" : "save";
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["decID"]);
    
    
    echo '</td>';
    
    
    } else {
    
    echo '<td  class="myformtd">';
    
    if (!array_item($formdata, "insertID") && !array_item($formdata, "btnLink1")) {
    
    form_button2("btnLink2", "קשר לתת החלטה לפי חיפוש");
    form_hidden("decID", $formdata["decID"]);
    }
    
    
    $tmp = (array_item($formdata, "decID")) ? "update" : "save";
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["decID"]);
    form_hidden("decID", $formdata["decID"]);
    form_hidden("insertID", $formdata["insertID"]);
    ?>
    <button class="green90x24" type="submit"
    value="שמור/עדכן"
    ,name="submitbutton_<?php echo $formdata['decID']; ?>"
    id="submitbutton_<?php echo $formdata['decID']; ?>"
    onclick="return  prepSelObject(document.getElementById('dest_forums<?php echo $formdata['decID']; ?>')),
    prepSelObject(document.getElementById('dest_decisionsType<?php echo $formdata['decID']; ?>'));">
    שמור/עדכן
    </button>
    
    
    <?php
    form_empty_cell_no_td(3);
    form_button4("btnClear", "הוסף החלטה/נקה טופס", "Submit", "OnClick=\"return document.getElementById('mode_" . $formdata["btnClear"] . "').value='clear'\";");
    
    echo '</td>';
    
    
    }
    
    echo '</tr>
    </table>
    </td>
    </tr>';
    /******************************END BUTTONS******************/
    echo '</table></fieldset></form>';
    
    /********************************************************/
    ?>
    
    <div id="page_useredit" class="page_useredit"
    style="display:none">
    
    <h3 class="my_title" style=" height:15px"></h3>
    <h3><?php __('edit_user'); ?></h3>
    
    <div class="content">
    
    
    <!--<form  name="edituser" id="edituser">-->
    
    <form onSubmit="return saveUser3(this,<?php echo " '" . ROOT_WWW . "/admin/' "; ?>);"
    name="edituser" id="edituser">
    <input type="hidden"
    name="Request_Tracking_Number_1"
    id="Request_Tracking_Number_1"
    value=""/>
    <input type="hidden"
    name="Request_Tracking_Number1"
    id="Request_Tracking_Number1"
    value=""/>
    <input type="hidden"
    name="Request_Tracking_Number2"
    id="Request_Tracking_Number2"
    value=""/>
    <input type="hidden" name="id"
    value=""/>
    <input type="hidden" name="forum_decID"
    id="forum_decID"
    value="<?php echo $formdata['forum_decision']; ?>"/>
    
    
    <div class="form-row">
    <span class="h"><?php __('priority'); ?></span>
    <SELECT name="prio" id="prio"
    class="mycontrol">
    <option value="3">+3</option>
    <option value="2">+2</option>
    <option value="1">+1</option>
    <option value="0" selected>
    &plusmn;0
    </option>
    <option value="-1">&minus;1
    </option>
    </SELECT>
    &nbsp;
    
    
    <span class="h"><?php __('active'); ?></span>
    <SELECT name="active" id="active"
    class="mycontrol">
    <option value="0">0</option>
    <option value="1" selected>1
    </option>
    </SELECT>
    &nbsp;
    
    
    <span class="h"><?php __('due'); ?> </span>
    <input name="duedate3" id="duedate3"
    value="" class="in100"
    title="Y-M-D, M/D/Y, D.M.Y, M/D, D.M"
    autocomplete="off"/>
    </div>
    
    
    <div class="form-row">
    <span class="h"><?php __('level'); ?></span>
    <SELECT name="level" id="level"
    class="mycontrol">
    <option value="1"><?php __(forum_user) ?></option>
    <option value="2"><?php __(admin) ?></option>
    <option value="3"><?php __(suppervizer) ?></option>
    <option value="none" selected>
    (בחר אופציה)
    </option>
    </SELECT>
    
    </div>
    
    
    <div class="form-row"><span
    class="h"><?php __('full_name'); ?></span><br>
    <input type="text" name="full_name"
    id="full_name" value=""
    class="in200"
    maxlength="50"/></div>
    
    <div class="form-row"><span
    class="h"><?php __('user'); ?></span><br>
    <input type="text" name="user"
    id="user" value=""
    class="in200"
    maxlength="50"/></div>
    
    <div class="form-row"><span
    class="h"><?php __('upass'); ?></span><br>
    <input type="text" name="upass"
    id="upass" value=""
    class="in200"
    maxlength="50"/></div>
    <div class="form-row"><span
    class="h"><?php __('email'); ?></span><br>
    <input type="text" name="email"
    id="email" value=""
    class="in200"
    maxlength="50"/></div>
    <div class="form-row"><span
    class="h"><?php __('phone'); ?></span><br>
    <input type="text" name="phone"
    id="phone" value=""
    class="in200"
    maxlength="50"/></div>
    <div class="form-row"><span
    class="h"><?php __('note'); ?></span><br>
    <textarea name="note" id="note"
    class="in500"></textarea>
    </div>
    <div class="form-row"><span
    class="h"><?php __('tags'); ?></span><br>
    <input type="text" name="tags"
    id="edittags1" value=""
    class="in500"
    maxlength="250"/></div>
    <div class="form-row">
    
    <input type="submit" id="edit_usr"
    value="<?php __('save'); ?>"
    onClick="this.blur()"/>
    <input type="button"
    value="<?php __('cancel'); ?>"
    onClick="canceluserEdit3();this.blur();return false"/>
    
    
    </div>
    </form>
    
    </div> <!--  end div content -->
    
    </div> <!--  end of page_user_edit -->
    
    
    <!-- ============================================================================================================ -->
    
    <?php
    
    /************************************************************************************************************/
    if (array_item($formdata, "decID") && (is_numeric($formdata['decID']))){
    
    
    $decID = $formdata['decID'];
    
    
    /*************************************************************************/
    if (!($formdata['single_frm'] == 1)){
    ?>
    
    <!-- for slid all the task+users form   -->
    
    <div id="content_my_dec">
    
    
    <table id="my_dec<?php echo $decID; ?>"
    style="width:100%;cursor:pointer" ;>
    <?php
    if (array_item($formdata, "dest_forums$decID")) {
    $i = 0;
    foreach ($formdata["dest_forums$decID"] as $key => $val) {
    $formdata['forum_decID'][$i] = $val;
    $i++;
    }
    
    }
    if (is_array($formdata['forum_decID']))
    foreach ($formdata['forum_decID'] as $forum_decID) {
    if (is_numeric($forum_decID)) {
    $getUser_sql = "SELECT u.* FROM users u 
    inner join rel_user_forum r  
    on u.userID = r.userID              
    WHERE r.forum_decID = $forum_decID
    ORDER BY u.full_name ASC";
    
    if ($rows = $db->queryObjectArray($getUser_sql)) {
    
    
    // echo '<tr id="tr_$decID+$forum_decID;" >';
    // echo '<td  colspan="3" norwap class="myformtd"> ';
    
    
    ?>
    
    <input type=hidden
    name="decID"
    id="decID"
    value="<?php echo $decID ?>"/>
    <input type=hidden
    name="forum_decID"
    id="forum_decID"
    value="<?php echo $forum_decID ?>"/>
    
    <?php
    
    
    //  require_once(TASK_DIR.'/index_test2.php');
    
    //$lang->build_task_form2($decID,$forum_decID);
    
    //echo '</td></tr>';
    
    
    }
    }
    }
    
    /********************************************************/
    }//end if
    /*********************************************************/
    else{
    
    ?>
    
    <div id="content_my_dec">
    <table id="my_dec<?php echo $decID; ?>"
    style="width:100%;cursor:pointer"
    ;>
    <?php
    $forum_decID = $formdata['forum_decision'];
    if (is_numeric($forum_decID)) {
    $getUser_sql = "SELECT u.* FROM users u 
    inner join rel_user_forum r  
    on u.userID = r.userID              
    WHERE r.forum_decID = $forum_decID
    ORDER BY u.full_name ASC";
    
    if ($rows = $db->queryObjectArray($getUser_sql)) {
    
    
    ?>
    <!--  <tr id="tr_<?php echo $decID; ?>">  -->
    <!--   <td  colspan="3" norwap class="myformtd">-->
    <input type=hidden
    name="decID"
    id="decID"
    value="<?php echo $decID ?>"/>
    <input type=hidden
    name="forum_decID"
    id="forum_decID"
    value="<?php echo $forum_decID ?>"/>
    
    <!--   </td> -->
    <!-- </tr>   -->
    <?php
    
    
    // require_once(TASK_DIR.'/index.php');
    //require_once(TASK_DIR.'/index_test2.php');
    // $lang->build_task_form2($decID,$forum_decID);
    
    }
    /**********************************************************/
    }
    
    /**********************************************************/
    }//end else
    /**********************************************************/
    
    echo '</table>';
    echo '</div>';//end div slide the table (content_my_dec)
    }//end if array_item
    /***********************************************************************************************************/
    ?>
    
    <div id="loading">
    <img src="../images/loading4.gif"
    border="0"/>
    </div>
    
    <div id="target_task"></div>
    <?php
    /***********************************************************************************************************/
    
    echo '</div>';//end div slide the table (content_my_dec)
    echo '</div>'; //end div main
    /*****************************************************************************************************/
    ?>
    <script>
    
    var decID =<?php echo $formdata['decID']; ?>;
    //alert(decID);
    var countJson;
    
    <?php
    $decID = $formdata['decID'];
    
    $func_nameDec = "setupAjaxForm$decID";
    
    
    ?>
    
    
    function <?php echo $func_nameDec; ?>(dec_id, decID, form_validations) {
    
    
    var form = '#' + dec_id;
    var form_message = form + '-message';
    
    
    $(form).ajaxSend(function () {
    $("#form-message" + decID).removeClass().addClass('loading').html('Loading...').fadeIn();
    });
    
    
    var options = {
    
    beforeSubmit: showRequest,
    
    // pre-submit callback
    
    success: processJson,
    
    dataType: 'json'
    };
    
    
    $('#decision_' + decID).ajaxForm(options);
    
    
    function showRequest(formData, jqForm) {
    
    var extra = [{
    name: 'json',
    value: '1'
    }];
    $.merge(formData, extra);
    
    return true;
    }
    
    /**********************************************************************************************/
    
    //post-submit callback
    function processJson(data) {
    
    
    theme = {
    
    newUserFlashColor: '#ffffaa',
    editUserFlashColor: '#bbffaa',
    errorFlashColor: '#ffffff'
    };
    countJson = data;
    countJson1 = data;
    
    
    countJson = data;
    
    var countList = '';
    var decisionList = '';
    
    var managerList = '';
    var appointList = '';
    var countList1 = '';
    var countList2 = '';
    var countList3 = '';
    var countList4 = '';
    var infoList = '';
    var userList = '';
    var categoryList = '';
    var decision_typeList = '';
    
    
    forum_progBar = [];
    usrList = [];
    list_div = [];
    dest_forums_conv = [];
    
    
    
    if (data.type == 'success') { 
    var decID = data.decID;
    
    
    $('#my_find_ol').css('list-style', 'none');
    $('#first_li').css('list-style', 'none');
    
    $('#menu_items_dec' + decID).show();
    $('#my_error_message' + decID).hide();
    $('#desc_table').html(' ');
    loadDecFrm_note(url, decID);
    
    var url = '../admin/';
    
    $('#desc_table' + decID).html(' ');
    
    
    loadDecFrm_note_mult(url, decID);
    
    
    /*********************************RESET_DEC_DATE*************************************************************/
    
    $('#mult_yearID' + decID).val('none').attr('selected', 'selected');
    $('#mult_monthID' + decID).val('none').attr('selected', 'selected');
    $('#mult_dayID' + decID).val('none').attr('selected', 'selected');
    
    /*******************************TOGGLE_MAIN_FIELDSET*******************************************/
    
    $(".my_main_fieldset").addClass('link');
    $(".my_main_fieldset").toggle(
    function () {
    
    
    $(this).addClass('hover');
    $("#main_fieldset").slideToggle('slow');
    },
    function () {
    $(this).removeClass('hover');
    $("#main_fieldset").slideToggle('slow');
    }
    );
    /*******************************TOGGLE_MENU_ITEM*******************************************/
    
    $(".my_menu_items_dec_title").addClass('link');
    $(".my_menu_items_dec_title").toggle(
    function () {
    
    
    $(this).addClass('hover');
    $("#menu_items_dec" + decID).slideToggle('slow');
    },
    function () {
    $(this).removeClass('hover');
    $("#menu_items_dec" + decID).slideToggle('slow');
    }
    );
    
    /******************************TOGGLE_TASK_TABLE*******************************************/
    
    
    
    $(".my_dec_title_table_" + decID).addClass('link');
    $(".my_dec_title_table_" + decID).toggle(
    function () {
    
    
    $(this).addClass('hover');
    $("#content_my_dec").slideToggle('slow');
    
    },
    function () {
    $(this).removeClass('hover');
    $("#content_my_dec").slideToggle('slow');
    }
    );
    /************************************************************************************************************/
    $(form_message).empty();
    $("#decision-message" + decID).removeClass().addClass(data.type).html(data.message).fadeIn('slow').css({'background': '#ffdddd'}).css({'margin-right': '90px'});
    
    /***********************************************DECISION*********************************************************/
    
    if (data.dateIDs) {
    countList += '<li><a href="../admin/find3.php?decID=' + data.decID + '"  class="declink" >' + data.subcategories + '>>' + data.dec_date + '</a></li>';
    } else {
    if (data.dec_date)
    countList += '<li><a href="../admin/find3.php?decID=' + data.decID + '"  class="declink" >' + data.subcategories + '>>' + data.dec_date + '</a></li>';
    }
    
    $('#decision1_' + decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow');
    
    $('#decision1_' + decID).html('<ul id="countList"><b style="color:brown;">שם החלטה' + countList + '</b></ul>').find('a.declink').each(function (i) {
    
    var index = $('a.declink').index(this);
    var v = countJson.subcategories;
    var id = countJson.decID;
    /*****************************************CLICK*****************************************************************/
    $(this).click(function () {
    
    $.get('../admin/find3.php?decID=' + id + '', $(this).serialize(), function (data) {
    
    
    $('#decision0_' + decID)
    .addClass('decision0_' + decID)
    .css({'width': '90%'})
    .css({'height': '500px'})
    .css({'margin-right': '50px'})
    .css({'padding': '5px'})
    .css({'overflow': 'auto'})
    .css({'background': '#2AAFDC'})
    .css({'border': '3px solid #666'});
    
    
    $('#decision0_' + decID).html(data);
    
    
    });
    
    
    return false;
    });
    
    });//end decision
    
    /************************************************NEW_DECISION_TYPE********************************************/
    if ($('#new_decisionType' + decID).val() && !($('#new_decisionType' + decID).val() == 'none')) {
    var newItem = $('#new_decisionType' + decID).val();
    $('#src_decisionsType' + decID).append('<option value=' + data.dest_decisionsType[0].catID + '>' + newItem + '</option>').attr("selected", true);
    
    $('#dest_decisionsType' + decID).html(' ');
    $('#dest_decisionsType' + decID).append('<option value=' + data.dest_decisionsType[0].catID + '>' + newItem + '</option>').attr("selected", true);
    
    $('#new_decisionType' + decID).val('');
    
    
    $('#src_decisionsType' + decID).empty().append('<select name="src_decisionsType' + decID + '" id="src_decisionsType' + decID + '" >\n');
    
    
    ////////////////////////////////////////////////////////////////////////////
    $.each(data.decType, function (i, item) {
    ////////////////////////////////////////////////////////////////////////////
    
    var listentry = listentry ? listentry : item[0];
    listentry = listentry.replace(/^[ \t]+/gm, function (x) {
    return new Array(x.length + 1).join('&nbsp;')
    });
    
    $('#src_decisionsType' + decID).append("<OPTION   value=" + item[1] + " " + (item[0] == newItem ? "Selected" : "") + ">" + listentry + "</option>\n");
    
    });
    $('#src_decisionsType' + decID).append($('</select>'));
    
    
    if ($('#insert_decisionType' + decID).val() && !($('#insert_decisionType' + decID).val() == 'none')) {
    var val_insert = $('#insert_decisionType' + decID).val();
    $('#insert_decisionType' + decID).append('<option value=' + data.dest_decisionsType[0].catID + '>' + newItem + '</option>').attr("selected", true);
    }
    
    }
    /************************************NEW_FORUM*********************************************************/
    
    
    if ($('#new_forum' + decID).val() && !($('#new_forum' + decID).val() == 'none')) {
    
    
    var newItem = $('#new_forum' + decID).val();
    $('#src_forums' + decID).append('<option value=' + data.dest_forums[0].forum_decID + '>' + newItem + '</option>').attr("selected", true);
    
    $('#dest_forums' + decID).html(' ');
    $('#dest_forums' + decID).append('<option value=' + data.dest_forums[0].forum_decID + '>' + newItem + '</option>').attr("selected", true);
    
    $('#new_forum' + decID).val('');
    
    
    $('#src_forums' + decID).empty().append('<select name="src_forums' + decID + '" id="src_forums' + decID + '" >\n');
    
    
    ////////////////////////////////////////////////////////////////////////////
    $.each(data.dec_frm, function (i, item) {
    ////////////////////////////////////////////////////////////////////////////
    
    var listentry = listentry ? listentry : item[0];
    listentry = listentry.replace(/^[ \t]+/gm, function (x) {
    return new Array(x.length + 1).join('&nbsp;')
    });
    
    $('#src_forums' + decID).append("<OPTION   value=" + item[1] + " " + (item[0] == newItem ? "Selected" : "") + ">" + listentry + "</option>\n");
    
    });
    $('#src_forums' + decID).append($('</select>'));
    
    
    if ($('#insert_forumType' + decID).val() && !($('#insert_forumType' + decID).val() == 'none')) {
    var val_insert = $('#insert_forumType' + decID).val();
    $('#insert_forumType' + decID).append('<option value=' + data.dest_forums[0].forum_decID + '>' + newItem + '</option>').attr("selected", true);
    }
    
    }
    
    
    /***********************************************FORUM_DEC*********************************************************/
    
    if (!($.browser.mozilla == true ))
    $("#my_dec" + decID).css("float", "left");
    /**************************************************************************************************************************/
    // if(!(forum_obj))
    
    ///////////////////////////////////////////////////////////////////////////////
    $.each(data.dest_forums, function (i) {                                        //
    ///////////////////////////////////////////////////////////////////////////////
    dest_forums_conv[i] = data.dest_forums[i].forum_decID;
    
    var forum_decName = this.forum_decName;
    var forum_id = countJson.dest_forums[i].forum_decID;
    var forum_decID = countJson.dest_forums[i].forum_decID;
    var mgr = data.dest_managers[i].managerID;
    var url = '../admin/';
    var idx = i;
    
    
    countList1 += '<li><a href="../admin/find3.php?forum_decID=' + forum_id + '"  class="forumlink" >' + this.forum_decName + '</a></li>';
    });// end var arv = dest_forums_conv.toString();
    /**************************************************************************************************************/
    $('#decision2_' + decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow');
    
    
    $('#decision2_' + decID).html('<ol id="countList1"><b style="color:brown;">שם הפורום/ים' + countList1 + '</b></ol>').find('a.forumlink').each(function (i) {
    
    var index = $('a.forumlink').index(this);
    var v = countJson.forum_decName;
    var forum_id = countJson.dest_forums[i].forum_decID;
    
    /*****************************************CLICK************************************************************/
    $(this).click(function () {
    $('#targetDecdiv').show();
    $.get('../admin/find3.php?forum_decID=' + forum_id + '', $(this).serialize(), function (data) {
    
    
    $('#decision0_' + decID)
    .addClass('decision0_' + decID).css({'width': '81%'})
    .css({'height': '300px'})
    .css({'margin-right': '90px'})
    .css({'padding': '5px'})
    .css({'overflow': 'auto'})
    .css({'background': '#C6EFF0'})
    .css({'border': '3px solid #666'});
    
    
    $('#decision0_' + decID).html(data);
    
    
    });
    
    
    return false;
    });
    
    });//end forum_dec
    
    
    /************************************************************DECISION_TYPE**********************************************************************/
    $.each(data.dest_decisionsType, function (i) {
    
    
    var catName = this.catName;
    var catID = countJson.dest_decisionsType[i].catID;
    var url = '../admin/';
    var idx = i;
    
    countList4 += '<li><a href="../admin/find3.php?catID=' + catID + '"  class="typelink" >' + this.catName + '</a></li>';
    
    
    });
    
    /**************************************************************************************************************/
    
    
    $('#decision3a_' + decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});//fadeIn('slow');
    
    $('#decision3a_' + decID).html('<ol id="countList4"><b style="color:brown;">סוג החלטה/ות' + countList4 + '</b></ol>').find('a.typelink').each(function (i) {
    
    var index = $('a.typelink').index(this);
    var v = countJson.catName;
    var id = countJson.dest_decisionsType[i].catID;
    /*****************************************CLICK***************************************************/
    $(this).append('<div id="targetDiv_dec"></div>').click(function () {
    
    
    $.get('../admin/find3.php?catID=' + id + '', $(this).serialize(), function (data) {
    
    
    $('#decision0_' + decID)
    .addClass('decision0_' + decID).css({'width': '81%'})
    .css({'height': '700px'})
    .css({'margin-right': '90px'})
    .css({'padding': '5px'})
    .css({'overflow': 'auto'})
    .css({'list-style': 'none'})
    .css({'background': '#8EF6F8'})
    .css({'border': '3px solid #666'});
    
    
    $('#decision0_' + decID).html(data);
    
    
    /************************************************************************/
    $('#first_li').hide();
    $('#decision0_' + decID).css({'display': 'inline'}).pager('li', {
    navId: 'nav2',
    height: '15em'
    });
    
    
    $('#nav2').draggable();
    
    
    $('#first_li').hide();
    
    $('a.my_paging').not($('#my_paging1')).bind('click', function () {
    
    $('#my_resulttable_0').hide();
    
    });
    
    
    $('a#my_paging1').bind('click', function () {
    
    $('#my_resulttable_0').show();
    $('#first_li').hide();
    });
    });
    return false;
    });
    
    
    });//end decision/type
    
    
    /***************************************MANAGER**********************************************/
    
    if (data.dest_managers[0][0].managerID) {
    //////////////////////////////////////////////////////////////////////////////////////////////
    $.each(data.dest_managers, function (i, item) {
    //////////////////////////////////////////////////////////////////////////////////////////////
    
    $.each(item, function (i) {
    var managerName = this.managerName;
    var mng_id = item[i].managerID;
    
    managerList += '<li><a href="../admin/find3.php?managerID=' + mng_id + '"  class="mgr" >' + managerName + '</a></li>';
    
    });//end each2
    
    });//end each2
    
    
    /*********************************************************************************************************************************/
    $('#decision7_' + decID).removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});
    
    
    $('#decision7_' + decID).html('<ol id="managerList1"><b style="color:brown;">מרכז ועדה' + managerList + '</b></ol>').find('a.mgr').each(function (i) {
    ///////////////////////////////////////////////////////////////////////////////////////////////
    var index = $('a.mgr').index(this);
    
    
    var mgr_id = data.dest_managers[i][0].managerID;
    
    /*****************************************CLICK****************************/
    $(this).click(function () {
    $('#targetDecdiv').show();
    $.get('../admin/find3.php?managerID=' + mgr_id + '', $(this).serialize(), function (data) {
    
    $('#decision0_' + decID)
    .addClass('decision0_' + decID).css({'width': '81%'})
    .css({'height': '500px'})
    .css({'margin-right': '90px'})
    .css({'padding': '5px'})
    .css({'overflow': 'hidden'})
    .css({'overflow': 'auto'})
    .css({'background': '#B4D9D7'})
    .css({'border': '3px solid #666'});
    
    
    $('#decision0_' + decID).html(data);
    
    
    });
    
    
    return false;
    });
    $('#decision0_' + decID).html(' ');
    
    });//end manager  end each3
    
    }
    /***************************************USERS_FORUM**********************************************/
    if (data.dest_users && data.dest_users != 'undefined') {
    var i = 0;
    var j = 0;
    ///////////////////////////////////////////////////////////////////////////
    $.each(data.dest_users, function (j, item) {
    ///////////////////////////////////////////////////////////////////////////
    
    
    $.each(item, function (i) {
    var full_name = this.full_name;
    var usr_id = item[i].userID;
    
    userList += '<li class="my_user_li"><a href="../admin/find3.php?userID=' + usr_id + '"  class="usr' + j + '" >' + full_name + '</a></li>';
    
    });//end each2
    usrList[j] = userList;
    userList = '';
    
    });//end each2
    /*********************************************************************************************************************************/
    
    count = [];
    
    for (var j = 0,
    mylen = countJson.dest_forums.length; j <= mylen; j++) {
    
    var num = 10 + j;
    list_div[j] = num;
    $('#decision' + num + '_' + decID).removeClass().addClass(data.type).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});
    
    
    if (usrList[j]) {
    if (countJson.src_forums.length != null) {
    if (countJson.dest_forums.length < countJson.src_forums.length) {
    
    for (var k = 0,
    mylen = (countJson.src_forums.length - countJson.dest_forums.length); k < mylen; k++) {
    
    
    var num_del = (num + mylen) - k;
    
    $('#decision' + num_del + '_' + decID).empty();
    }
    }
    }
    var count_user = 0;
    $('#decision' + num + '_' + decID).html('<ol id="userList' + j + '"><b style="color:brown;">' + countJson.dest_forums[j].forum_decName + '- חברי ועדה' + usrList[j] + '</b></ol>').find('a.usr' + j + '').each(function (i) {
    
    
    var index = $('a.usr' + j + '').index(this);
    
    
    var usr_id = data.dest_users[j][count_user].userID;
    
    
    /*****************************************CLICK*************************************************************/
    $(this).click(function () {
    $('#targetDecdiv').show();
    $.get('../admin/find3.php?userID=' + usr_id + '', $(this).serialize(), function (data) {
    
    $('#decision0_' + decID)
    .addClass('decision0_' + decID).css({'width': '81%'})
    .css({'height': '500px'})
    .css({'margin-right': '90px'})
    .css({'padding': '5px'})
    .css({'overflow': 'auto'})
    .css({'background': '#B4D9D7'})
    .css({'border': '3px solid #666'});
    
    
    $('#decision0_' + decID).html(data);
    
    
    });
    
    
    return false;
    });
    
    $('#decision0_' + decID).html(' ');
    count_user++;
    });//end each3
    
    }//end if usrList
    
    //               else {
    //             	  if( (!usrList[j]) && (countJson.dest_forums[j].forum_decName) && (countJson.dest_forums[j].forum_decName==="undefined") ) {
    //             	  $('#decision'+num+'_'+decID).html('<ol id="userList'+j+'">'+countJson.dest_forums[j].forum_decName +'</ol>');
    //                  }
    //                }
    
    }//end for
    }
    
    /********************************GENERAL_INFORMATION*******************************************/
    $('#decision9_' + decID).removeClass().addClass(data.type).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '90px'});
    infoList += '<li><a href="../admin/forum_demo12.php"  class="my_msg" > <b style="color:brown;">מידע כללי</b></a></li>';
    
    $('#decision9_' + decID).html('<ul id="infoList1">' + infoList + '</ul>').find('a.my_msg').each(function (i) {
    var index = $('a.my_msg').index(this);
    /*****************************************CLICK****************************/
    $(this).click(function () {
    $('#targetDecdiv').show();
    $.get('../admin/forum_demo12.php', $(this).serialize(), function (data) {
    
    //////////////////////////////////////////////
    $('#decision0_' + decID)
    .addClass('decision0_' + decID).css({'width': '85%'})
    .css({'height': '400px'})
    .css({'margin-right': '90px'})
    .css({'padding': '5px'})
    .css({'overflow': 'auto'})
    .css({'background': '#AE77BE'})
    .css({'border': '3px solid #666'});
    $('#decision0_' + decID).html(data);
    /////////////////////////////////////////////
    
    });
    
    
    return false;
    });//end click
    $('#decision0_' + decID).html(' ');
    
    });//end general info
    }//end success
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    else {
    
    var decID = data.decID;
    $.each(data, function (i, item) {
    var messageError = i;
    
    $("#decision-message" + decID).html(' ').fadeIn();
    if (messageError != 'decID')
    countList2 += '<li class="error">' + item + '</li>';
    
    });
    
    $('#my_error_message' + decID).html('<ul id="countList_check' + decID + '">' + countList2 + '</ul>').css({'margin-right': '90px'});
    $('#my_error_message' + decID).append($('<p ID="bgchange' + decID + '"   ><b style="color:blue;">הודעת שגיאה!!!!!</b></p>\n'));
    $('.error').draggable();
    if ($('#menu_items_dec_hidden' + decID).val())
    $('#menu_items_dec' + decID).hide();
    $('#my_error_message' + decID).show();
    turn_red2(decID);
    //  blinkFont()
    }
    
    /*******************/
    }//end proccess
    /******************/
    /************************TOGGLE_DEC_USERS**********************************************/
    
    $("#my_title_users" + decID).css('cursor', 'pointer').addClass('link');
    $("#my_title_users" + decID).toggle(
    function () {
    
    
    $(this).addClass('hover');
    
    $("#my_Dectable" + decID).slideToggle('slow');
    },
    function () {
    $(this).removeClass('hover');
    $("#my_Dectable" + decID).slideToggle('slow');
    
    }
    );
    
    
    /***************************************************************/
    ////////////////////////////////////////////CHANGE_CONN_FIRST_BY_SEARCH////////////////////////////////////////////////////////
    $('#btnLink6_' + decID).click(function () {
    
    
    $('#conn_txt_first' + decID).remove();
    $('#conn_submit_first' + decID).remove();
    $('#conn_table' + decID).append($("<tr><td class='myformtd'>\n" +
    "<input type='text' name='conn_txt_first" + decID + "' id='conn_txt_first" + decID + "'  class='mycontrol'  colspan='1'  />\n" +
    "<input type='button' name='conn_submit_first" + decID + "' id='conn_submit_first" + decID + "'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור ריאשון בטופס'  />\n" +
    "<h4 class='my_title_button' id='my_title_button" + decID + "' style='height:15px;cursor:pointer;'></h4>" +
    "</td></tr>\n" +
    "<div id='targetDiv_change" + decID + "'></div>\n"
    )).css({'border': 'solid #dddddd 5px'});
    $('#first_li').hide();
    toggle_me(decID);
    $('input#conn_submit_first' + decID).click(function () {
    var txt = $('#conn_txt_first' + decID).attr('value');
    
    data_change = [];
    data_change[0] = ($('#conn_txt_first' + decID).val()   );
    data_change[1] = decID;
    var data_b = decID;
    
    $.ajax({
    type: "POST",
    url: "../admin/find3.php",
    
    data: "change_conn_first=" + data_change,
    success: function (msg) {
    
    $('div#targetDiv_change' + decID).html(' ').append('<p>' + msg + '</p>');
    
    /****************************************************************************/
    $('div#targetDiv_change' + decID).css({'display': 'inline'}).pager('li', {
    navId: 'nav2',
    height: '15em'
    });
    
    
    $('#nav2').draggable();
    $('div#targetDiv_change' + decID).find('div#nav2').draggable();
    
    $('#first_li').hide();
    $('div#targetDiv_change' + decID).find('table#resulttable').find('li#first_li').hide();
    $('a.my_paging').not($('#my_paging1')).bind('click', function () {
    
    $('#my_resulttable_0').hide();
    $('div#targetDiv_change' + decID).find('table#my_resulttable_0').hide();
    });
    
    
    $('a#my_paging1').bind('click', function () {
    
    $('#my_resulttable_0').show();
    $('div#targetDiv_change' + decID).find('table#my_resulttable_0').show();
    $('#first_li').hide();
    $('div#targetDiv_change' + decID).find('table#resulttable').find('li#first_li').hide();
    });
    /****************************************************************************/
    
    $('td.td3head').find('a.change_conn' + decID).css('background-color', 'yellow').click(function () {
    
    var link = $(this).attr('href');
    var decID = $(this).attr('decID');
    var insertID = $(this).attr('insertID');
    var parentDecID1 = $(this).attr('parentDecID1');
    
    var str_a = "chack_insert";
    $.ajax({
    dataType: 'json',
    type: "GET",
    url: "../admin/dynamic_5b.php",
    
    data: "insertID=" + insertID + "&decID=" + decID + "&vlidInsert=" + str_a,
    
    
    success: function (json) {
    
    if (json.list[0] == 'fail') {
    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
    return;
    
    } else {
    var insertID = json.list.insertID;
    }
    /**************************************/
    var str = "change_insert_b";
    $.ajax({
    type: "GET",
    url: "../admin/dynamic_5b.php",
    
    data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str,
    
    
    success: function (msg) {
    
    
    $('div#my_entry_top' + decID).empty().append('<p>' + msg + '</p>');
    
    
    }
    
    });
    
    
    /*************************************/
    }
    
    });
    
    
    return false;
    
    });//end click
    
    }//end success ajx
    
    });//end ajax1
    
    return false;
    });	//end conn_submit_first click
    
    
    /*************************/
    $('div#targetDiv_change' + decID).empty();
    return false;
    });//end btnLink6
    
    $('#btnLink6_' + decID).bind("click", (function () {
    $('#btnLink6_' + decID).unbind("click");
    }));
    
    
    function toggle_me(decID) {
    $("#my_title_button" + decID).addClass('link');
    $("#my_title_button" + decID).toggle(
    function () {
    
    $(this).addClass('hover');
    $("#targetDiv_change" + decID).slideToggle();
    },
    function () {
    $(this).removeClass('hover');
    $("#targetDiv_change" + decID).slideToggle();
    });
    }
    
    /***************************CONN_SECOND_BY_SEARCH*************************************************************/
    $('#btnLink3_' + decID).click(function () {
    $('#conn_txt' + decID).remove();
    $('#conn_submit' + decID).remove();
    $('#conn_table' + decID).append($("  <tr id='conn_tr" + decID + "'><td class='myformtd'>\n" +
    "<input type='text' name='conn_txt" + decID + "' id='conn_txt" + decID + "'  class='mycontrol'  colspan='1' />\n" +
    "<input type='button' name='conn_submit" + decID + "' id='conn_submit" + decID + "'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור שני בטופס'  />\n" +
    "<h3  class='my_title_button2' id='my_title_button2" + decID + "' style='height:15px;cursor:pointer;'></h3>" +
    "</td></tr>\n" +
    "<div id='targetDiv_search2" + decID + "' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n"
    )).css({'border': 'solid #dddddd 5px'});
    
    toggle_me_secound(decID);
    $('input#conn_submit' + decID).bind('click', function () {
    
    data = [];
    data[0] = ($('#conn_txt' + decID).val()   );
    data[1] = decID;
    
    
    $.ajax({
    type: "POST",
    url: "../admin/find3.php",
    data: "conn_second=" + data,
    success: function (msg) {
    
    $('div#targetDiv_search2' + decID).html(' ').append(msg);
    
    /******************************NAV**********************************************/
    $('div#targetDiv_search2' + decID).css({'display': 'block'}).pager('li', {
    navId: 'nav2',
    height: '15em'
    
    });
    
    
    $('#nav2').draggable();
    $('div#targetDiv_search2' + decID).find('div#nav2').draggable();
    
    $('#first_li').hide();
    $('div#targetDiv_search2' + decID).find('table#resulttable').find('li#first_li').hide();
    
    $('a.my_paging').not($('#my_paging1')).bind('click', function () {
    
    $('#my_resulttable_0').hide();
    $('div#targetDiv_search2' + decID).find('table#my_resulttable_0').hide();
    
    });
    
    
    $('a#my_paging1').bind('click', function () {
    
    $('#my_resulttable_0').show();
    $('div#targetDiv_search2' + decID).find('table#my_resulttable_0').show();
    $('#first_li').hide();
    $('div#targetDiv_search2' + decID).find('table#resulttable').find('li#first_li').hide();
    });
    
    /****************************************************************************/
    
    $('td.td3head').find('a.change_conn').css('background-color', 'yellow').click(function () {
    
    var link = $(this).attr('href');
    var decID = $(this).attr('decID');
    var parentDecID1_src = $(this).attr('parentDecID1');
    var insertID = $(this).attr('insertID');
    var str_a = "chack_insert";
    $(this).append('<div id="div#decision_a_' + decID + '"></div>');
    /**************************************************************************************/
    
    $.ajax({
    dataType: 'json',
    type: "GET",
    url: "../admin/dynamic_5b.php",
    
    data: "insertID=" + insertID + "&decID=" + decID + "&vlidInsert=" + str_a,
    
    
    success: function (json) {
    
    if (json.list[0] == 'fail') {
    alert("אי אפשר לקשר החלטה לעצמה או לבנים!");
    return;
    
    } else {
    var parentDecID1_dest = json.list.insertID;
    }
    
    var str = "link_second";
    $.ajax({
    type: "GET",
    url: "../admin/dynamic_5b.php",
    
    data: "insertID=" + insertID + "&decID=" + decID + "&mode=" + str,
    success: function (msg) {
    if (($('#hidden_entry' + parentDecID1_src).val()) === undefined) {
    $('div#decision_a_' + decID).empty().append('<p>' + msg + '</p>');
    } else {
    $('div#my_entry' + parentDecID1_src).remove();
    $('div#decision_a_' + decID).empty().append('<p>' + msg + '</p>');
    }
    
    if (!($('#btnLink7_' + decID)).val()) {
    $('#conn_table' + decID).append($("<tr><td class='myformtd'>\n" +
    
    "<input type='button' name='btnLink7_" + decID + "' id='btnLink7_" + decID + "'  class='mybutton'  colspan='1' value='בטל קישור שני' />\n" +
    "</td></tr>\n" +
    "<div id='targetDiv_cancel" + decID + "'></div>\n")).css({'border': 'solid #dddddd 5px'});
    }
    ////////////////////////////////////////////CANCEL_CONN_SECOND2////////////////////////////////////////////////////////
    $('input#btnLink7_' + decID).click(function () {
    
    
    $.getJSON('../admin/dynamic_5b.php?cancle&decID=' + decID, function (json) {
    
    
    $.each(json, function (i, item) {
    
    parentDecID1 = json.parentDecID1;
    $('div#decision_a_' + decID).remove();
    
    
    });
    
    
    });
    $('input#btnLink7_' + decID).remove();
    return false;
    
    });//end btnLink7
    
    
    }
    });
    
    }
    
    });
    /**************************************************************************************/
    
    
    return false;
    });//end click Link
    
    }//end success ajx
    
    });//end ajax
    
    return false;
    });//end click conn_submit
    
    
    $('div#targetDiv_cancel').html(' ');
    $('div#targetDiv_search2').html(' ');
    return false;
    });//end click btn3
    
    $('#btnLink3_' + decID).bind("click", (function () {
    $('#btnLink3_' + decID).unbind("click");
    }));
    /*********************************************************************************************************************/
    function toggle_me_secound(decID) {
    $("#my_title_button2" + decID).addClass('link');
    $("#my_title_button2" + decID).toggle(
    function () {
    
    $(this).addClass('hover');
    $("#targetDiv_search2" + decID).slideToggle();
    },
    function () {
    $(this).removeClass('hover');
    $("#targetDiv_search2" + decID).slideToggle();
    });
    
    }
    
    ////////////////////////////////////////////CANCEL_CONN_SECOND////////////////////////////////////////////////////////
    $('#btnLink4_' + decID).click(function () {
    
    $.getJSON('../admin/dynamic_5b.php?cancle&decID=' + decID, function (json) {
    
    
    $.each(json, function (i, item) {
    
    parentDecID1 = json.parentDecID1;
    
    $('div#my_entry' + parentDecID1).remove();
    
    
    });
    
    
    });
    $('input#btnLink4_' + decID).remove();
    return false;
    /************************************************************************************/
    });//end btnLink4
    /*****************************************CONN_ROOT**************************************/
    //btnLink0_$decID
    $('#btnLink0_' + decID).click(function () {
    
    
    var data = decID;
    
    $.ajax({
    type: "POST",
    url: "../admin/dynamic_5b.php",
    data: "conn_root=" + data,
    success: function (msg) {
    $('div#my_entry_top' + decID).empty().append('<p>' + msg + '</p>');
    
    
    }
    
    
    });
    
    return false;
    });
    
    
    //////////////////////////////////////////////TESTING/////////////////////////////////////////////////////////////////////
    /***************************CONN_SECOND_BY_SEARCH*************************************************************/
    $('#btnLinkWin_' + decID).click(function () {
    
    $('#conn_txt' + decID).remove();
    $('#conn_submit' + decID).remove();
    
    
    if (!($.browser.mozilla == true )) {
    $('#conn_table' + decID).append($("  <tr id='conn_tr" + decID + "'><td class='myformtd'>\n" +
    "<input type='text' name='conn_txt2" + decID + "' id='conn_txt2" + decID + "'  class='mycontrol'  colspan='1' />\n" +
    "<input type='button' name='conn_submit22" + decID + "' id='conn_submit22" + decID + "'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור שני בחלון'  />\n" +
    "</td></tr>\n" +
    "<div id='targetDiv_search22" + decID + "' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n"
    )).css({'border': 'solid #dddddd 5px'});
    
    
    } else {
    
    $('#conn_table' + decID).append($("<fieldset id='details_fieldset" + decID + "'><legend>חפש קישורים</legend>\n" +
    "<form id='details" + decID + "'><input type='text' name='conn_txt2" + decID + "' id='conn_txt2" + decID + "'  class='mycontrol'  colspan='1' />\n" +
    "<input type='button' name='conn_submit22" + decID + "' id='conn_submit22" + decID + "'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור שני בחלון'  />\n" +
    "</form></fieldset>\n" +
    "<div id='targetDiv_search22" + decID + "' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n")).css({'border': 'solid #dddddd 5px'});
    }
    
    $('input#conn_submit22' + decID).css({'background': '#B4D9D7'}).bind('click', function () {
    
    if (!($.browser.mozilla == true )) {
    
    
    var txt = $('#conn_txt2' + decID).serialize();
    } else {
    
    
    var txt = $('#conn_txt2' + decID).attr('value');
    
    }
    var queryString = '?conn_secound_test=' + txt + '&decID=' + decID;
    
    
    var link = '../admin/find3.php' + queryString;
    
    openmypage3(link);
    
    return false;
    
    });
    
    });
    
    
    $('#btnLinkWin_' + decID).bind("click", (function () {
    $('#btnLinkWin_' + decID).unbind("click");
    }));
    ///////////////////////////////////////////////TESTING/////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////CHANGE_CONN_FIRST_BY_POPUP////////////////////////////////////////////////////////
    $('#btnLinkWinFirst' + decID).click(function () {
    
    if (!($.browser.mozilla == true )) {
    $('#conn_txtFirst' + decID).remove();
    $('#conn_submitFirst' + decID).remove();
    $('#conn_table' + decID).append($("<tr><td class='myformtd'>\n" +
    "<input type='text' name='conn_txtFirst" + decID + "' id='conn_txtFirst" + decID + "'  class='mycontrol'  colspan='1'  />\n" +
    "<input type='button' name='conn_submitFirst" + decID + "' id='conn_submitFirst" + decID + "'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור ריאשון בחלון'  />\n" +
    "</td></tr>\n" +
    "<div id='targetDiv_changeFirst" + decID + "'></div>\n"
    )).css({'border': 'solid #dddddd 5px'});
    } else {
    
    $('#conn_table' + decID).append($("<fieldset id='detailsFirst_fieldset" + decID + "'><legend>חפש קישורים</legend>\n" +
    "<form id='detailsFirst" + decID + "'>" +
    "<input type='text' name='conn_txtFirst" + decID + "' id='conn_txtFirst" + decID + "'  class='mycontrol'  colspan='1'  />\n" +
    "<input type='button' name='conn_submitFirst" + decID + "' id='conn_submitFirst" + decID + "'  class='mybutton'  colspan='1' value='שלח טקסט לחיפוש קישור ריאשון בחלון'  />\n" +
    "</form></fieldset>\n" +
    "<div id='targetDiv_searchFirst" + decID + "' style='float:right;overflow:hidden;right:50px;' class='paginated' ></div>\n")).css({'border': 'solid #dddddd 5px'});
    }
    
    
    $('input#conn_submitFirst' + decID).bind('click', function () {
    
    
    var txt = $('#conn_txtFirst' + decID).attr('value');
    
    if (!($.browser.mozilla == true )) {
    var txt = $('#conn_txtFirst' + decID).serialize();
    } else {
    var txt = $('#conn_txtFirst' + decID).attr('value');
    }
    
    var queryString = '?conn_first_test=' + txt + '&decID=' + decID;
    
    
    var link = '../admin/find3.php' + queryString;
    
    openmypage3(link);
    
    return false;
    
    });//end conn_submit
    
    });
    
    
    $('#btnLinkWinFirst' + decID).bind("click", (function () {
    $('#btnLinkWinFirst' + decID).unbind("click");
    }));
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    ////////////////////////////////////////////DELETE_DECISION////////////////////////////////////////////////////////
    $('#btnDelete_' + decID).click(function () {
    
    
    data = [];
    data[0] = 'realy_delete';
    data[1] = decID;
    if (!confirm("האים בטוח שרוצה למחוק?")) {
    return false;
    }
    
    $('#btnDelete_' + decID).unbind();
    $('#btnLink1_' + decID).unbind();
    $('#btnLink3_' + decID).unbind();
    
    $('#conn_table' + decID).append($("  <tr id='conn_tr" + decID + "'>\n" +
    "<div id='targetDiv2' ></div>\n"
    )).css({'border': 'solid #dddddd 5px'});
    
    $.getJSON('../admin/dynamic_5b.php?cancle&decID=' + decID, function (json) {
    $.each(json, function (i, item) {
    
    parentDecID1 = json.parentDecID1;
    alert(parentDecID1);
    alert(item);
    $('div#my_entry' + parentDecID1).remove();
    });
    });
    
    
    $.ajax({
    type: "POST",
    url: "../admin/dynamic_5b.php",
    data: "delete=" + data,
    success: function (msg) {
    
    $('#my_entry_top').empty();
    $('#my_text_erea' + decID).html(' ');
    $('#my_date' + decID).find('input').val(' ');
    $('#dest_forums' + decID).html(' ');
    $('#dest_decisionsType' + decID).html(' ');
    $('#my_vote_level' + decID).val(' ');
    $('#my_dec_level' + decID).val(' ');
    $('#my_status' + decID).val(' ');
    
    
    $('#conn_table' + decID).html(' ');
    $('#conn_table' + decID).prepend("רשומה נימחקה!").css({'background': '#8EF6F8'});
    $('.menu_items_dec' + decID).html(' ');
    $('#my_fieldset' + decID).prepend("רשומה נימחקה!").css({'background': '#C6EFF0'});
    
    
    $('#li' + decID).fadeOut('slow', function () {
    $(this).remove();
    });
    
    $('div#my_entry_top' + decID).remove();
    $('div#my_entry' + decID).remove();
    $('div#decision_a_' + decID).remove();
    $('div#decision_b_' + decID).remove();
    
    
    }
    
    });
    
    
    /****************************************************************************************/
    
    return false;
    });//end btnDelete
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    $('#submitbutton1_' + decID).click(function () {
    
    var arv = dest_forums_conv.toString();
    
    
    $.ajax({
    type: "POST",
    url: "../admin/make_task.php",
    
    data: "rebuild=" + arv + "&decID=" + decID,
    
    
    success: function (msg) {
    
    
    $('#my_dec' + decID).html(' ').append('<p>' + msg + '</p>');
    
    }
    
    }); //end ajax
    
    return false;
    
    });//end buttonsubmit1
    /****************************************************************************************************************/
    
    
    /************************************************************************************************/
    }//end function
    /************************************************************************************************/
    
    $(document).ready(function () {
    
    var decID =<?php echo $formdata['decID']; ?>;
    
    var url = '../admin/';
    
    loadDecFrm_note_mult(url, decID);
    
    
    //	  $('#descButton_'+decID).click(function(){
    //		var  arr=$('#dest_forums'+decID).val();
    //		  	var url='/alon-web/olive_prj/admin/';
    //
    //	 		loadDecFrm_note_mult(url,decID);
    //
    //	  });
    
    
    <?php
    $func_nameDec = "setupAjaxForm$decID";
    ?>
    new <?php echo $func_nameDec;?>('decision_' + decID, decID);
    
    
    $(".my_Dectitle_" + decID).css({'cursor': 'pointer'}).addClass('link');
    $(".my_Dectitle_" + decID).toggle(
    function () {
    
    
    $(this).addClass('hover');
    $("#main_content" + decID).slideToggle();
    },
    function () {
    $(this).removeClass('hover');
    $("#main_content" + decID).slideToggle();
    }
    );
    
    /***************************************************************/
    $('#modal').draggable({
    axis: 'y',
    containment: 'parent'
    });
    if ($.browser.msie) {
    $('#my_dec' + decID).css({'margin-right': '43px'});
    }
    
    /********************************************UN_DRAG DIV WHEN SCROLL****************************/
    
    if ($.browser.mozilla == true) {
    $(function () {
    $("#menu_items_dec" + decID).sortable();
    $('#decision0_' + decID).bind("mousedown", function () {
    return false;
    });
    });
    } else {
    $("#menu_items_dec" + decID).sortable();
    
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////
    $('#submitbutton2_' + decID).click(function () {
    
    var dest_forums_conv = $('#dest_forums' + decID).val();
    var arv = dest_forums_conv.toString();
    
    $.ajax({
    type: "POST",
    url: "../admin/make_task.php",
    
    data: "rebuild=" + arv + "&decID=" + decID,
    
    success: function (msg) {
    
    $('#my_dec' + decID).html(' ').append('<p>' + msg + '</p>');
    
    }
    
    }); //end ajax
    
    return false;
    
    });//end buttonsubmit1
    /****************************************************************************************************************/
    
    
    $("#loading img").ajaxStart(function () {
    $(this).show();
    }).ajaxStop(function () {
    $(this).hide();
    });
    });
    
    
    </script>
    
    <?php
    }//end build ajx_formMult
    
    ?>