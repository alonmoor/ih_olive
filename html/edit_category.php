<?php

/**
 * @param $formdata
 */
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
    <div id="main">
    <div class="container">
    <div class="row">
    <section class="col-xs-12">
    <form style="width:95%;" name="cat_org" id="cat_org" method="post" action="../admin/category_brand.php"
          onsubmit="prepSelObject(document.getElementById('dest_pdfs'));
                        prepSelObject(document.getElementById('dest_publishers'));
                        prepSelObject(document.getElementById('dest_categoriesType'));
                        prepSelObject(document.getElementById('dest_managersType'));">
    <fieldset>
    <legend> מלא את הטופס להוספת סוג ברנד:</legend>
    <div class="wrapper_cat" style="width:100%">
    <?PHP
    $page_input = isset($formdata['pages']) ? $formdata['pages'] : '';
    ?>
    <input type="hidden" name="pdf_page_num" id="pdf_page_num" value="<?PHP echo $page_input; ?>">
    <?php
    if (array_item($formdata, 'catID')) {
        $cat = new category();
        $cat->print_forum_entry_form_c($formdata['catID']);
    }
    $dates = getdate();
//-----------------------------------------------------------
    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    if ($rows = $db->queryObjectArray($sql)) {
        foreach ($rows as $row) {
            $subcategoriesftype[$row->parentCatID][] = $row->catID;
            $catNamesftype[$row->catID] = $row->catName;
        }
        $rows = build_category_array($subcategoriesftype[NULL], $subcategoriesftype, $catNamesftype);
    }
//---------------------------------UPDATE------------------------------------------
    if (array_item($formdata, 'catID')) {
        if ($level) {
            ?>
            <div class="form-group">
                <label for="cat_brand">שם סוג הברנד:</label>

                <select class="form-control" id="cat_brand" name="form[$name]" style="width:160px;"
                <option value="none">(choose)</option>
                <?PHP
                $selected = array_item($formdata, "catID");
                foreach ($rows as $row) {
                    echo '<option ', html_attribute("value", $row[1]);
                    if ($selected == $row[1])
                        echo 'selected="selected" ';
                    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                    echo ">$listentry</option>\n";
                }
                ?>
                </select>
            </div>
            <!-- --------------------------------------------------------- -->
            <div class="form-group">
                <label for="brand_connect">קשר לברנד:</label>
                <select class="form-control" id="brand_connect" name="form[insert_forum]" style="width:160px;"
                <option value="none">(choose)</option>
                <?php
                foreach ($rows as $row) {
                    echo '<option ', html_attribute("value", $row[1]);
                    if ($selected == $row[1])
                        echo 'selected="selected" ';
                    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                    echo ">$listentry</option>\n";
                }
                ?>
                </select>
            </div>

            <?php

            $value = array_item($formdata, "catPrefix");
            $url = htmlspecial_utf8('create_brandType.php');
            ?>


            <div class="form-group">
                <label for="catPrefix"> קידומת: </label>
                <input class="form-control input-group" style="width: 160px;" type="text" id="catPrefix" value=<?PHP echo $value; ?> >
                <a href=<?PHP echo $url; ?>  class='form_href'> ערוך ברנדים: </a>
            </div>
            <?php
        } else {
            ?>
            <div class="form-group">
                <label for="cat_brand">שם הברנד:</label>
                <select class="form-control" id="cat_brand" name="form[cat_brand]"
                <option value="none">(choose)</option>
                <?PHP
                $selected = array_item($formdata, "catID");
                foreach ($rows as $row) {
                    echo '<option ', html_attribute("value", $row[1]);
                    if ($selected == $row[1])
                        echo 'selected="selected" ';
                    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                    echo ">$listentry</option>\n";
                }
                ?>
                </select>
            </div>

            <?php
            $date_val = array_item($formdata, "cat_date2");
            echo '<input type="hidden" id="cat_date3" value=' . $date_val . '" >';


            $prefix_val = array_item($formdata, "catPrefix");
            echo '<input type="hidden" id="catPrefix" value=' . $prefix_val . '" >';
        }
    } //-----------------------SAVE--------------------------------------------
    else {
        if ($level) {
            $name_value = array_item($formdata, "tmpName");
            $prefix_value = array_item($formdata, "catPrefix");

            ?>
            <div class="form-group">
                <label for="newcatName"> שם הברנד: </label>
                <input class="form-control input-group" style="width: 160px;" type="text"   name="form[newcatName]"  id="catPrefix" value=<?PHP echo $name_value; ?> >
            </div>




            <div class="form-group">
                <label for="catPrefix"> קידומת: </label>
                <input class="form-control input-group" style="width: 160px;" type="text"  name="form[catPrefix]"  id="catPrefix" value=<?PHP echo $prefix_value; ?>  >
            </div>

<?php
        } else {
?>
            <div class="form-group">
                <label for="cat_brand">שם הברנד:</label>
                <select class="form-control" id="cat_brand" name="form[cat_brand]"
                <option value="none">(choose)</option>
                <?PHP
                $selected = array_item($formdata, "catID");
                foreach ($rows as $row) {
                    echo '<option ', html_attribute("value", $row[1]);
                    if ($selected == $row[1])
                        echo 'selected="selected" ';
                    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                    echo ">$listentry</option>\n";
                }
                ?>
                </select>
            </div>
            <?php
            $date_val = array_item($formdata, "cat_date2");
            echo '<input type="hidden" id="cat_date3" value=' . $date_val . '" >';

            $prefix_val = array_item($formdata, "catPrefix");
            echo '<input type="hidden" id="catPrefix" value=' . $prefix_val . '" >';
        }
    }
    echo '</div>';
//---------------------------BUTTON-------------------------------------------
    ?>
    <button class="btn btn-primary" type="submit" OnClick="
                                            prepSelObject(document.getElementById('dest_brandsType'));
                                            prepSelObject(document.getElementById('dest_managersType'));
                                            prepSelObject(document.getElementById('dest_pdfs'));
                                            ">שמור
    </button>
    <?php
    $tmp = (array_item($formdata, "catID")) ? "update" : "save";
    $formdata["catID"] = isset($formdata["catID"]) ? $formdata["catID"] : '';
    $formdata["insertID"] = isset($formdata["insertID"]) ? $formdata["insertID"] : '';
    echo '<div class="myformtd" style="width:60%;">';
    form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["catID"]);
    form_hidden("catID", $formdata["catID"]);
    form_hidden("insertID", $formdata["insertID"]);
    echo '</div>';
    ?>
    <div id="loading" style="display:none;">
        <img src="loading4.gif" border="0"/>
    </div>
    <div id="display_div" class="image_block"></div>
    <?php
    echo '</div></fielset></form></section></div><!-- row --></div></div>';
}//end build_form


