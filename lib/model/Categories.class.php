<?php
require_once("../config/application.php");
require_once(LIB_DIR . '/model/DBobject3.php');
require_once(LIB_DIR . '/model/class.handler.php');
require_once(LIB_DIR . '/model/dbtreeview.php');
require_once HTML_DIR . '/edit_category.php';
require_once(ADMIN_DIR . '/ajax.php');


class Category extends DBObject3{

public $insertID;
public $deleteID;
public $updateID;
public $submitbutton;
public $subcategories;
public $pagesize = 10;


protected $catID;
protected $catName;
protected $catPrefix;
private $table;
private $fields = array();
public  $convert_status=0;
function __construct($id = "", $formdata = "")
{

    parent::__construct('categoties', 'catID', array('catName', 'catID', 'catPrefix'), $id, $formdata);
}

function load_from_db($formdata)
{
    global $db;

    //$sql = "SELECT * FROM users where userID = ".$this->getId();
    $sql = "SELECT * FROM categories where catID =$this->id";

    if ($result = $db->execute_query($sql))
        if ($row = $result->fetch_object()) {
            if (!empty($row->catID))
                $this->catID = $row->catID;


            if (!empty($row->cat_date))
                $this->cat_date = $row->cat_date;

            if (!empty($row->active))
                $this->active = $row->active;

            if (!empty($row->parentForumID))
                $this->parentForumID = $row->parentForumID;
        }

}

/************************************s**************************************************************/
function setFormdata(&$formdata)
{
    global $db;
    if (!empty($_REQUEST['id']))
        $formdata['catID'] = $_REQUEST['id'];

    if (!empty($_POST['forum_decName']))
        $formdata['forum_decName'] = $_POST['forum_decName'];

    if (!empty($_POST['form']['appointID']))
        $formdata['appointID'] = $_POST['form']['appointID'];

    if (!empty($_POST['form']['appoint_date']))
        $formdata['appoint_date'] = $_POST['form']['appoint_date'];

    if (!empty($_POST['form']['managerID']))
        $formdata['managerID'] = $_POST['form']['managerID'];

    if (!empty($_POST['form']['manager_date']))
        $formdata['manager_date'] = $_POST['form']['manager_date'];

    if (!empty($_POST['parentForumID']))
        $formdata['parentForumID'] = $_POST['parentForumID'];

    if (!empty($_POST['active']))
        $formdata['active'] = $_POST['active'];

    if (!empty($_POST['category']))
        $formdata['category'] = $_POST['category'];

    if (!empty($_POST['type']))
        $formdata['type'] = $_POST['type'];

    if (!empty($_POST['cat_date']))
        $formdata['cat_date'] = $_POST['cat_date'];

    if (!empty($_POST['form']['year_date_forum']))
        $formdata['year_date_forum'] = $_POST['form']['year_date_forum'];

    if (!empty($_POST['form']['month_date_forum']))
        $formdata['month_date_forum'] = $_POST['form']['month_date_forum'];

    if (!empty($_POST['form']['day_date_forum']))
        $formdata['day_date_forum'] = $_POST['form']['day_date_forum'];

    if (!empty($formdata['catID']))
        $id = $formdata['catID'];

    if (isset($id)) {
        $sql = "select parentForumID from forum_dec where catID=$id";
        if ($rows = $db->queryObjectArray($sql))
            $formdata['parentForumID'] = $rows[0]->parentForumID;
    }

}


/****************************************************************************************/
function setParent_forum(&$formdata)
{
    global $db;
    if ($formdata['id']) {
        $id = $formdata['id'];
        $sql = "select parentCatID from categories where catID=$id";
        if ($rows = $db->queryObjectArray($sql) && $rows[0]->parentCatID != null)
            $formdata['parentCatID'] = $rows[0]->parentCatID;
        else
            $formdata['parentCatID'] = '11';
    }
}
/*******************************************************************************************************/

function set($insertID = "", $submitbutton = "", $subcategories = "", $deleteID = "", $updateID = "")
{
    $this->setdeleteID($deleteID);
    $this->setinsertID($insertID);
    $this->setsubmitbutton($submitbutton);
    $this->setsubcategories($subcategories);
    $this->setupdateID($updateID);
}
/**********************************************************************************************/
//
//	function setFormdata($formdata){
//		$this->active=$formdata['active'];
//
//
//		if($formdata['newcatName']){
//		$this->forum_decName=$formdata['newcatName'];
//		$subcategories=$formdata['newcatName'];
//		}elseif($formdata['forum_decName']){
//		$catID=$formdata["forum_decision"];
//			$sql = "SELECT forum_decName  FROM forum_dec WHERE catID = " .
//				$db->sql_string($$catID);
//				$rows = $db->queryObjectArray($sql);
//			if($rows)
//			// existing cat
//			$this->forum_decName=$rows[0]->forum_decName;
//			$subcategories=$rows[0]->forum_decName;
//		}
//
//
//
//
//		$this->catID=$formdata['catID'];
//		$this->managerID=$formdata['managerID'];
//		$this->appointID=$formdata['appointID'];
//		$this->parentForumID=$formdata['insertID'];
//		$this->year_date=$formdata['year_date'];
//		$this->month_date=$formdata['month_date'];
//		$this->day_date=$formdata['day_date'];
//		if(is_numeric ($formdata['multi_year'])&& is_numeric ($formdata['multi_month'])&& is_numeric ($formdata['multi_day'])){
//			$this->year_date=$formdata['multi_year'];
//			$this->month_date=$formdata['multi_month'];
//			$this->day_date=$formdata['multi_day'];
//		}
//		$this->catID=$formdata['category'];
//		//$this->catID=$formdata['catID'];
//		//$this->newforumName=$formdata['newcatName'];
//	}
/************************************************************************************************/
function array_item($ar, $key)
{

    if (is_array($ar) && array_key_exists($key, $ar))
        return ($ar[$key]);
    else
        return FALSE;
}

/**********************************************************************************************/
public function setId($catID)
{
    $this->catID = $catID;
}

function setName($decname)
{
    $this->forum_decName = $decname;
}

function setSubcategories($subcategories)
{
    $this->subcategories = $subcategories;
}
//======================================================================================

function getName()
{
    return $this->forum_decName;
}

function setParent($parentcatid)
{
    $this->parentCatID = $parentcatid;
}


/**********************************************************************************************/

function getdeleteID()
{
    return $this->deleteID;
}

function setdeleteID($deleteID)
{
    $this->deleteID = $deleteID;
}

function getinsertID()
{
    return $this->insertID;
}

function setinsertID($insertID)
{
    $this->insertID = $insertID;
}

function getsubmitbutton()
{
    return $this->submitbutton;
}

function setsubmitbutton($submitbutton)
{
    $this->submitbutton = $submitbutton;
}
/*****************************************************************************************/

function getsubcategories()
{
    return $this->subcategories;
}

function getupdateID()
{
    return $this->updateID;
}

function setupdateID($updateID)
{
    $this->updateID = $updateID;
}

function getParent()
{
    return $this->parentCatID;
}

function __construct1($catID = false)
{
    if (!$catID) {
        return;
    }
    global $db;
    $formdata = array();
    $query = "SELECT *
                FROM categories
                WHERE  catID = $catID";
    $result = $db->getMysqli()->query($query);
    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        $this->$catID = $formdata['catID'];
        $this->forum_decName = $formdata['catName'];
        $this->forum_time = $formdata['cat_date'];

    }
}

function print_cat_entry_form_c($updateID, $mode = '')
{
    $insertID = $updateID;
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
    if ($level) {
        $sql = "SELECT catName, catID, parentcatID " .
            " FROM categories ORDER BY catName";
        $rows = $db->queryObjectArray($sql);
        // build assoc. arrays for name, parent and subcategories
        foreach ($rows as $row) {
            $forumNames[$row->catID] = $row->catName;
            $parents[$row->catID] = $row->parentcatID;
            $subcategories[$row->parentcatID][] = $row->catID;
        }
        // build list of all parents for $insertID
        $forum_decID = $updateID;
        while ($parents[$forum_decID] != NULL) {
            $forum_decID = $parents[$forum_decID];
            $parentList[] = $forum_decID;
        }
        echo '<div id="my_forum_entry_c">';
        //display all exept the choozen
        if (isset($parentList)) {
            for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                $url = "../admin/find3.php?forum_decID=$parentList[$i]";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($parentList[$i] == '11') {
                    printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b> </li>\n",
                        htmlspecial_utf8($forumNames[$parentList[$i]]),
                        build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                        build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם")
                    );
                } else {
                    printf("<ul><li style='font-weight:bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                        htmlspecial_utf8($forumNames[$parentList[$i]]),
                        build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                        build_href2("category_brand.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם"),
                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }
            }
        }
        // display choosen forum  * BOLD *
        //display the last on
        if ($insertID == '11') {
            printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                htmlspecial_utf8($forumNames[$updateID]),
                build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"));
        } else {
            $url = "../admin/find3.php?forum_decID=$updateID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
            printf("<ul><li class='bgchange_tree' style='font-weight:bold;'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                htmlspecial_utf8($forumNames[$updateID]),
                build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                build_href2("category_brand.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"),
                build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים", $str));
        }
        echo "<ul>";
        $i = 0;
        if (array_key_exists($updateID, $subcategories)) {
            while ($subcategories[$updateID]) {
                foreach ($subcategories[$updateID] as $forum_decID) {
                    $url = "../admin/find3.php?forum_decID=$forum_decID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<li style='font-weight:bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",

                        htmlspecial_utf8($forumNames[$forum_decID]),
                        build_href2("category_brand.php", "mode=insert", "&insertID=$forum_decID", "הוסף"),
                        build_href2("category_brand.php", "mode=delete", "&deleteID=$forum_decID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("category_brand.php", "mode=update", "&updateID=$forum_decID", "עדכן"),
                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }
                echo "<ul>";
                $updateID = $forum_decID;
                $i++;
            }
            // close hierarchical category list
            echo str_repeat("</ul>", $i + 1), "\n";
        } else {
            echo "(עדיין אין תת-ברנדים.)";
        }
        echo "</ul>\n";
        // close hierarchical category list
        if (isset($parentList))
            echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
        echo '</div>';
    } elseif (!($level)) {
        $sql = "SELECT catName, catID, parentcatID " .
            " FROM categories ORDER BY catName";
        $rows = $db->queryObjectArray($sql);
        // build assoc. arrays for name, parent and subcategories
        foreach ($rows as $row) {
            $forumNames[$row->catID] = $row->catName;
            $parents[$row->catID] = $row->parentcatID;
            $subcategories[$row->parentcatID][] = $row->catID;
        }
        // build list of all parents for $insertID
        $catID = $updateID;
        while ($parents[$catID] != NULL) {
            $catID = $parents[$catID];
            $parentList[] = $catID;
        }
        echo '<div id="my_forum_entry_c">';
        //display all exept the choozen
        if (isset($parentList)) {
            for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                $url = "../admin/find3.php?forum_decID=$parentList[$i]";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($parentList[$i] == '11') {
                    printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s </b> </li>\n",
                        htmlspecial_utf8($forumNames[$parentList[$i]]));
                } else {
                    printf("<ul><li style='font-weight:bold;'> %s (%s, %s ) </li>\n",
                        htmlspecial_utf8($forumNames[$parentList[$i]]),
                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }
            }
        }
        // display choosen forum  * BOLD *
        //display the last on
        if ($insertID == '11') {
            printf("<ul><li><b style='color:red;'> %s </b> </li>\n",
                htmlspecial_utf8($forumNames[$updateID]));


        } else {
            $url = "../admin/find3.php?forum_decID=$updateID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
            printf("<ul><li class='bgchange_tree' style='font-weight:bold;'><b style='color:red;'> %s (%s, %s )</b> </li>\n",
                htmlspecial_utf8($forumNames[$updateID]),
                build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                build_href5("", "", "הראה נתונים", $str));
        }
        echo "<ul>";
        $i = 0;
        if (array_key_exists($updateID, $subcategories)) {
            while ($subcategories[$updateID]) {
                foreach ($subcategories[$updateID] as $forum_decID) {
                    $url = "../admin/find3.php?forum_decID=$forum_decID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<li style='font-weight:bold;'> %s (%s, %s) </li>\n",
                        htmlspecial_utf8($forumNames[$forum_decID]),
                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }
                echo "<ul>";
                $updateID = $forum_decID;
                $i++;
            }
            // close hierarchical category list
            echo str_repeat("</ul>", $i + 1), "\n";
        } else {
            echo "(עדיין אין תת-ברנדים.)";
        }
        echo "</ul>\n";
        // close hierarchical category list
        if (isset($parentList))
            echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
        echo '</div>';
    }
///////////////
}
//-----------------------------------------------------------------------------------

function update_cat_general()
{
    $mode = 'update';
    $updateID = $this->updateID;
    $submitbutton = $this->submitbutton;
    $subcategories = $this->subcategories;
    global $db;

    $sql = "SELECT COUNT(*) FROM categories WHERE catID='$updateID'";
    $n = $db->querySingleItem($sql);

    // if url had valid updateID, show this category and
    // an input form for new subcategories
    if ($updateID && $n == 1) {
       // $this->link_div();
        // if there is form data to process, update new
        // subcategories into database
        echo '<fieldset class="my_pageCount" >';
        if ($subcategories) {
            $db->execute("START TRANSACTION");
            if ($this->update_cat($updateID, $subcategories, $mode))
                $db->execute("COMMIT");
            else
                $db->execute("ROLLBACK");
        }
        if (array_item($_POST, 'submitbutton'))
            $str = array_item($_POST, 'submitbutton');
        else
            $str = 'שמור';
        if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST, 'submitbutton') == $str)) {
            echo "<h1>עדכן שם ברנד</h1>\n";
            $this->print_cat_entry_form_d($updateID, $mode);
        }
        echo '</fieldset>';
//		  $formdata=FAlSE;
//           build_form($formdata);
//	       $this->print_form_paging_b();
    }
}//end func///
/////////////
//------------------------------------------------------------------------------------

function link_div()
{

    echo "<table><tr class='menu4'><td><p><b> ", build_href2("find3.php", "", "", "חזרה לטופס החיפוש", "class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";


    echo "<td><p><b> ", build_href2("forum_demo12.php", "", "", "חיפוש קטגוריות בדף", "class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";


    $url = "../admin/forum_demo12_2.php";
    $str = 'onclick=\'openmypage2("' . $url . '"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
    echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . " </b></p></td>\n";

    echo "<td><p><b> ", build_href2("../admin/database5.php", "", "", "עץ הפורומים", "class=my_decLink_root title='כול הפורומים במיבנה עץ'") . " </b></p></td></tr></table>\n";

    ?>

    <table style="width:50%;">
        <tr>
            <td>
                <?php form_label1('חתכי סוגי החלטות:', TRUE); ?>
                <a href='#' title='חתכי סוגי החלטות' class="tTip"
                   OnClick="return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;"
                   ;>
                    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png' onMouseOver="this.src=img.edit[1]"
                         onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'" title='הצג נתונים'/>

                </a>
            </td>


            <td>
                <?php form_label1('חתכי סוגי פורומים:', TRUE); ?>
                <a href='#' title='חתכי סוגי פורומים' class="tTip"
                   OnClick="return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;"
                   ;>
                    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png' onMouseOver="this.src=img.edit[1]"
                         onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'" title='הצג נתונים'/>

                </a>
            </td>


            <td>
                <?php form_label1('חתכי סוגי מנהלים:', TRUE); ?>

                <a href='#' title='חתכי סוגי מנהלים' class="tTip"
                   OnClick="return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJAX/default.php'"; ?> ,'סוגי המנהלים');this.blur();return false;"
                   ;>
                    <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png' onMouseOver="this.src=img.edit[1]"
                         onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'" title='הצג נתונים'/>

                </a>

            </td>
        </tr>
    </table>


    <?php

    echo '</div>';


}
//update a new category in the categories table
//======================================================
// returns -1, if error
//         1,  if category could be saved
//         0,  if category could not be saved

function update_cat($updateID, $subcategories, $mode = '')
{
//===================================================================================
    global $db;
    $subcatarray = explode(";", $subcategories);
    //$subcat=$subcategories;
    $count = 0;
    foreach ($subcatarray as $newcatNameName) {
        $result = $this->update_new_cat($updateID, trim($newcatNameName));
        if ($result == -1) {
            echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
            return FALSE;
        } elseif ($result)
            $count++;
    }
    if ($count)
        if ($count == 1)
            echo "<p class='error'>ברנד עודכן.</p>\n";
    ?>
    <script type="text/javascript">
        turn_red_error();
    </script>
    <?php
    return TRUE;
}
//===================================================================================

function update_new_cat($updateID, $newcatNameName)
{
//===================================================================================
    global $db;
    // test if newcatName is empty
    if (!$newcatNameName) return 0;
    $newcatNameName = $db->sql_string($newcatNameName);

    // test if newcatName already exists
    $sql = "SELECT COUNT(*) FROM categories " .
        "WHERE catID=$updateID " .
        "  AND catName=$newcatNameName";
    if ($db->querySingleItem($sql) > 0) {
        echo " כבר קיימם ברנד בשם הזה";
        return 0;
    }

    // update category
    $sql = "update categories set catName=$newcatNameName where catID=$updateID";
    if ($db->execute($sql))
        return 1;
    else
        return -1;
}
//===================================================================================

function print_cat_entry_form_d($updateID, $mode = '')
{
    $insertID = $updateID;
    global $db;
    $sql = "SELECT catName, catID, parentcatID " .
        " FROM categories ORDER BY catName";
    $rows = $db->queryObjectArray($sql);
    // build assoc. arrays for name, parent and subcategories
    foreach ($rows as $row) {
        $forumNames[$row->catID] = $row->catName;
        $parents[$row->catID] = $row->parentcatID;
        $subcategories[$row->parentcatID][] = $row->catID;
    }
    // build list of all parents for $insertID
    $catID = $updateID;
    while ($parents[$catID] != NULL) {
        $catID = $parents[$catID];
        $parentList[] = $catID;
    }
    echo '<div id="my_forum_entry_b">';
    //display all exept the choozen
    if (isset($parentList)) {
        for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
            $url = "../admin/find3.php?forum_decID=$parentList[$i]";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
            if ($parentList[$i] == '11') {
                printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b></li>\n",
                    htmlspecial_utf8($forumNames[$parentList[$i]]),
                    build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                    build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם")
                );
            } else {
                printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                    htmlspecial_utf8($forumNames[$parentList[$i]]),
                    build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                    build_href2("category_brand.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם"),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
        }
    }
    // display choosen forum  * BOLD *
    //display the last on
    if ($insertID == '11') {
        printf("<ul><li style='font-weight :bold;'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
            htmlspecial_utf8($forumNames[$updateID]),
            build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
            build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"));
    } else {
        $url = "../admin/find3.php?forum_decID=$updateID";
        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
        printf("<ul><li class='bgchange_tree' style='font-weight :bold;'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
            htmlspecial_utf8($forumNames[$updateID]),
            build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
            build_href2("category_brand.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
            build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"),
            build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
            build_href5("", "", "הראה נתונים", $str));
    }
    echo "<ul>";
    $i = 0;
    if (array_key_exists($updateID, $subcategories)) {
        while (!empty($subcategories[$updateID]) && $subcategories[$updateID]) {
            foreach ($subcategories[$updateID] as $forum_decID) {
                $url = "../admin/find3.php?forum_decID=$forum_decID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                    htmlspecial_utf8($forumNames[$forum_decID]),
                    build_href2("category_brand.php", "mode=insert", "&insertID=$forum_decID", "הוסף"),
                    build_href2("category_brand.php", "mode=delete", "&deleteID=$forum_decID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("category_brand.php", "mode=update", "&updateID=$forum_decID", "עדכן"),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$forum_decID", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
            echo "<ul>";
            $updateID = $forum_decID;
            $i++;
        }
        // close hierarchical category list
        echo str_repeat("</ul>", $i + 1), "\n";
    } else {
        echo "(עדיין אין תת-ברנדים.)";
    }
    echo "</ul>\n";
    // close hierarchical category list
    if (isset($parentList))
        echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
    if (($mode == 'update')) {

        echo '<form method="post" action="category_brand.php?mode=update&updateID=',
        $insertID, '">', "\n",
        "<p>עדכן שם הברנד של ",
        "<b>$forumNames[$insertID]</b>. <br /> ",
        '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
        '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
        "</form>\n";
    }
    echo '</div>';
}
//===================================================================================	

function update_parent($insertID, $forum_decID)
{
//===================================================================================		
    global $db;
    $sql = "UPDATE categories set parentcatID=$insertID WHERE catID=$catID ";
    if (!$db->execute($sql))
        return FALSE;
    return TRUE;
}
//===================================================================================
function insert_forum($formdata)
//===================================================================================	
{
    $dec = explode(";", $formdata["newcatName"]);
    global $db;
    // insert new cat
    //==============================================================
    $sql = "INSERT INTO categories ( catName,parentcatID " .
        "status,cat_date) VALUES (" .
        $db->sql_string($formdata["catName"]) . ", " .
        $db->ID_or_NULL($formdata["parentcatID"]) . ", " .
        $this->num_or_NULL($formdata["status"]) . "," .
        $this->num_or_NULL($formdata["cat_date"]) . " ) ";
    if (!$db->execute($sql))
        return FALSE;
    return $db->insertId();
}
//------------------------------------------------------------------------------------
function add_category(&$formdata = "")
{
    global $db;

    //take care of connect to
     if (!empty($_GET['insertID']) && !$formdata['insert_cat'] && !is_numeric($formdata['insert_cat']) && !is_array($formdata['insert_cat']))
        $insertID = $this->insertID;
    elseif (!empty($formdata['insert_cat']) && (is_numeric($formdata['insert_cat'][0])) && is_array($formdata['insert_cat'])) {
        $insertID = $formdata['insert_cat'];
    } elseif (!empty($formdata['insert_cat']) && !empty($formdata['insertID']) && array_item($formdata, 'insert_cat') && (is_numeric($formdata['insert_cat']))
        && !is_array($formdata['insert_cat']) && array_item($formdata, 'insertID') && (is_numeric($formdata['insertID']))
    ) {
        $insertID = $formdata['insert_cat'];
        unset($formdata['insertID']);
    }  elseif (!empty($formdata['insert_cat']) && !is_array($formdata['insert_cat'])) {
        $insertID = '11';
        $formdata['insertID'] = '11';
    }elseif ( array_item($formdata, 'insertID') && is_numeric($formdata['insertID'])  ) {
         $insertID = $formdata['insertID'];
     }else{
        $formdata['insertID'] = '11';
    }
    if (!empty($formdata['submitbutton']) && $formdata['submitbutton'])
        $submitbutton = $formdata['submitbutton'];
    else
        $submitbutton = $this->submitbutton;
    echo "<h1>הוסף/עדכן ברנד חדש</h1>\n";

    // if there is form data to process, insert new
    // subcategories into database
    $subcategories = isset($formdata['newcatName']) ? $formdata['newcatName'] : '' ;
    if (!empty($subcategories)) {
        if ($this->insert_new_cat($formdata)) {
        } else {
            return FALSE;
        }
    }
    return true;
}
//--------------------------------------------------------------------------------------------------------
// insert new subcategories to given category
//function insert_new_cat(&$formdata,&$publishersIDs="",&$pdfIDS="" ,&$imgNams="")
function insert_new_cat(&$formdata)
{
    global $db;
    if (isset($formdata['insert_cat']) && array_item($formdata, 'insert_cat') && is_array($formdata['insert_cat']) && is_numeric($formdata['insert_cat'][0])) {
        $insertID = $formdata['insert_cat'];
    } elseif (isset($formdata['insertID']) && is_numeric($formdata['insertID']) && array_item($formdata, 'insertID')) {
        $insertID = $formdata['insertID'];
    } else {
        $insertID = 11;
    }

    $catPrefix = isset($formdata['catPrefix']) ? $formdata['catPrefix'] : '';





        $newcatNamename = $formdata['newcatName'];

    if (isset($catPrefix) && isset($newcatNamename) ) {

        $result = $this->insert_cat($insertID, $newcatNamename,$catPrefix, $formdata);
        if ($result == -1) {
            echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
            return FALSE;
        } elseif ($result) {
            $catID = $db->insertId();
            $formdata['catID'] = isset($catID) ? $catID : '';

            $db->execute("COMMIT");

            $formdata['newcatName'] = '';
            $formdata['catPrefix'] = '';
//            $formdata['subcategories'] = isset($formdata['newcatName']) ? $formdata['newcatName'] : "no name found";
//            $formdata['catName'] = isset($formdata['newcatName']) ? $formdata['newcatName'] : "no name found";
//
//
//
//            $formdata['new_name'] = isset($formdata['newcatName']) ? $formdata['newcatName'] : "no name found";
//            $form['catName'] = isset($formdata['newcatName']) ? $formdata['newcatName'] : "no name found";
//            //check it out
//            $form['insert_category'] = isset($formdata['insert_category'][0]) ? $formdata['insert_category'][0] : '';
//            $submit = "submitbutton_$catID";
//            $_SESSION['catID'] = $catID;
            show_list($formdata);
            echo "<p class='error'>ברנד עודכן/נוסף.</p>\n";
        }
        return TRUE;
    }
    return FALSE;
}
//---------------------------------------------------------------------------------------------------------------------------
function insert_cat($insertID, $newcatNamename, $catPrefix, $formdata)
{
    global $db;

    if (empty($catPrefix) && !$catPrefix) return 0;
    $catPrefix = $db->sql_string($catPrefix);
    if (empty($newcatNamename) && !$newcatNamename) return 0;
    $newcatNamename = $db->sql_string($newcatNamename);
    if ((isset($formdata['newcatName']) && $formdata['newcatName'] && $formdata['newcatName'] != 'none')) {
        $sql = "SELECT COUNT(*) FROM categories " .
            " WHERE parentcatID = $insertID " .
            "  AND catName = $newcatNamename" .
            "  AND catPrefix = $catPrefix";


        if ($db->querySingleItem($sql) > 0) {
            show_error_msg('כבר קיים ברנד אם שם כזה');
            return -1;
        } else  {

             $insertID = $db->sql_string($insertID);
            $db->execute("set foreign_key_checks=0");
            $sql = "INSERT INTO categories (`catName`, `parentcatID`, `catPrefix`) " .
                                "VALUES ( $newcatNamename, $insertID,  $catPrefix)";
            if ($db->execute($sql)) {
                $db->execute("set foreign_key_checks=1");
                return 1;
            }
            else {
                $db->execute("set foreign_key_checks=1");
                return -1;
            }
        }
    }
}
//-------------------------------------------------------------------------------------
function fetch_publisher(&$formdata)
{
    global $db;
    if (!array_item($formdata, "dest_publishers")) {
        unset ($formdata['dest_publishers']);
        $tmp = "";
    } elseif (($formdata['dest_publishers'] != 'none' && $formdata['dest_publishers'] != null
        && (array_item($formdata, "dest_publishers") && is_array(array_item($formdata, "dest_publishers"))))
    ) {
        $tmp = $formdata["dest_publishers"] ? $formdata["dest_publishers"] : '';
        $dest_publishers = $formdata['dest_publishers'];
        foreach ($formdata['dest_publishers'] as $row) {
            $publishersIDs [] = $row;
        }
    }
    return isset($publishersIDs) ? $publishersIDs : false;
}
//-------------------------------------------------------------------------------------
function fetch_pdf(&$formdata)
{
    global $db;
    if (!array_item($formdata, "dest_pdfs")) {
        unset ($formdata['dest_pdfs']);
        $tmp = "";
    } elseif (($formdata['dest_pdfs'] != 'none' && $formdata['dest_pdfs'] != null && (array_item($formdata, "dest_pdfs") && is_array(array_item($formdata, "dest_pdfs"))))) {

        foreach ($formdata['dest_pdfs'] as $row) {
            $pdfsIDs [] = $row;
        }
    }
    return isset($pdfsIDs) ? $pdfsIDs : false;
}
//----------------------------------------------------categories-------------------------------------------------------------------------
function conn_cat(&$formdata)
{
    global $db;
    if (isset($formdata['cat_select'][0]) && $formdata['cat_select'][0]) {
        $id = $formdata['cat_select'][0];
        $sql = "select catID, catName from categories where catID in ($id)";
        if ($rows = $db->queryObjectArray($sql))
            foreach ($rows as $row) {
                $catIDS[$row->catID] = $row->catName;
            }
        return $catIDS;
    } else {
        return false;
    }
}
//----------------------------------------------------------------------------------------------------------------------------

function message_update_b($formdata, $catID)
{

    $url = "../admin/find3.php?catID=$catID";
    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';

    $url2 = "../admin/find3.php?catID=$catID";
    $catName = isset($formdata['catName']) ? $formdata['catName'] : '';
    $str2 = "<span><a onClick=openmypage3('" . $url2 . "');   class=href_modal1  href='javascript:void(0)' >
                  <b style='color:brown;font-size:1.4em;'>'" . $catName . "'<b>
                 </a></span>";

    echo '<table style="width:300px;height:30px;overflow:hidden;line-height: 16px;">
         <tr><td><p style="overflow:hidden;line-height: 16px;"  data-module="הברנד:' . $str2 . '" >			      
          </p></td></tr>
         </table>';

    return TRUE;
}
//-----------------------------------------------------------------------

function link()
{

    printf("<p><b><br />%s</b></p>\n",
        build_href2("../admin/find3.php", "", "", "חפש פורומים", "class=href_modal1"));


    printf("<p><b>%s</b></p>\n",
        //	build_href("category_brand.php", "", " הוסף/ערוך פורום " ));
        build_href2("../admin/category_brand.php", "", "", "הוסף/ערוך פורום", "class=href_modal1"));
    return true;
}


/**********************************************************************************************/

function link_b()
{

    printf("<p><b><br />%s</b></p>\n",
        //build_href("find3.php", "", "חפש פורומים"));
        build_href2("../admin/find3.php", "", "", "חפש פורומים", "class=href_modal1"));

    printf("<p><b>%s</b></p>\n",
        build_href2("../admin/category_brand.php", "", "", "הוסף/ערוך פורום", "class=href_modal1"));
    return true;
}
/**************************************************************/

/***************************************************************************/

function show_page_links($page, $pagesize, $results, $query)
{

    if (($page == 1 && $results <= $pagesize) || $results == 0)
        // nothing to do
        return;
    echo "<p>Goto page: ";
    if ($page > 1) {
        for ($i = 1; $i < $page; $i++)
            echo build_href("dynamic_8.php", $query . "&page=$i", $i), " ";
        echo "$page ";
    }
    if ($results > $pagesize) {
        $nextpage = $page + 1;
        echo build_href("dynamic_8.php", $query . "&page=$nextpage", $nextpage);
    }
    echo "</p>\n";
}
/**************************************************************/

function build_date(&$formdata)
{


    if (isset($formdata['dynamic_9']) && $formdata['dynamic_9'] == 1) {
        if (array_item($formdata, 'catID') || is_numeric($catID)) {
            $catID = array_item($formdata, 'catID') ? array_item($formdata, 'catID') : $catID;
            $formdata["dest_users"] = $formdata["dest_users$catID"];
        }
    }

    if (  // array_item($formdata,'member')
        array_item($formdata, 'member_date0')
        && array_item($formdata, 'dest_users')
        && count($formdata['dest_users']) > 0
        && !is_numeric($formdata['member'])
        && (!array_item($formdata, 'multi_month') || ($formdata['multi_month'][0] == 'none'))
        && (!array_item($formdata, 'multi_year') || ($formdata['multi_year'][0] == 'none'))
        && !is_numeric($formdata['multi_year'][0])
        && !is_numeric($formdata['multi_month'][0])
        && !is_numeric($formdata['multi_day'][0])
        && !array_item($formdata, 'year_date')
        && !is_numeric($formdata['month_date'])
        && !is_numeric($formdata['day_date'])
    ) {

        $i = 0;

        foreach ($formdata['dest_users'] as $row) {
            $member_date = "member_date$i";
            list($day_date_the_date, $month_date_the_date, $year_date_the_date) = explode('-', $formdata[$member_date]);
            if (strlen($year_date_the_date) < 3) {
                $formdata[$member_date] = "$year_date_the_date-$month_date_the_date-$day_date_the_date";
            } else {
                $formdata[$member_date] = "$day_date_the_date-$month_date_the_date-$year_date_the_date";
            }
            $rows['full_date'][$i] = $formdata[$member_date];

            $i++;
        }


        $fields = array('year_date' => 'integer', 'month_date' => 'integer', 'day_date' => 'intger', 'full_date' => 'string');


    } elseif (array_item($formdata, 'year_date')
        && is_numeric($formdata['month_date'])
        && is_numeric($formdata['day_date'])
        && !array_item($formdata, 'multi_year')
        && !is_numeric($formdata['multi_month'][0])
        && !is_numeric($formdata['multi_day'][0])
    ) {


        foreach ($fields as $key => $type) {
            $rows[$key] = $this->safify($formdata[$key], $type);
        }
        $rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
        $rows['full_date'] = $this->safify($rows['full_date'], $type);


    } elseif (array_item($formdata, 'multi_day')
        && array_item($formdata, 'multi_month')
        && array_item($formdata, 'multi_year')
        && is_numeric($formdata['multi_year'][0])
        && is_numeric($formdata['multi_month'][0])
        && is_numeric($formdata['multi_day'][0])
    ) {
        $fields = array('multi_year' => 'integer', 'multi_month' => 'integer', 'multi_day' => 'intger', 'full_date' => 'string');
        foreach ($fields as $key => $type) {
            for ($i = 0; $i < count($formdata['multi_day']); $i++) {

                if (!$formdata[$key][$i])
                    $formdata[$key][$i] = $formdata[$key][$i - 1];
                $rows[$key][$i] = $this->safify($formdata[$key][$i], $type);

            }
        }


        for ($i = 0; $i < count($formdata['multi_day']); $i++) {
            $multi_tmp_year = $rows[multi_year][$i];

            $multi_tmp_month = $rows[multi_month][$i];
            $multi_tmp_day = $rows[multi_day][$i];
            $rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";

            //unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
            //	 $rows['full_date'][$i] =$this-> safify($rows['full_date'][$i] , $type);

        }


    } else {
        $now = date('Y-m-d H:i:s');
        $dates = getdate();
        $dates['mon'] = str_pad($dates['mon'], 2, "0", STR_PAD_LEFT);
        $dates['mday'] = str_pad($dates['mday'], 2, "0", STR_PAD_LEFT);

        $today = $this->build_date5($dates);
        $rows['today'] = $today['full_date'];

    }

//    	 var_dump($rows['full_date']);die;
    //return $rows['full_date'];
    return $rows;

}                        // $results  .. no. of search results
/************************************************************************************************/

function build_date5(&$formdata)
{

//    $fields = array( 'year' => 'integer', 'mon' => 'integer','mday' => 'intger','full_date'=>'string');
//
//
//
//    foreach ($fields as $key => $type) {
//        $rows[$key] = $this-> safify($formdata[$key], $type);
//    }
//    $rows['full_date'] = "$rows[year]-$rows[mon]-$rows[mday]";
//    // $rows['full_date'] =$this-> safify($rows['full_date'] , $type);
//
//
//
//
//    return $rows;
}
/**********************************************************************************************/

function build_date_appoint(&$formdata)
{


    $fields = array('year_date' => 'integer', 'month_date' => 'integer', 'day_date' => 'intger', 'full_date' => 'string');


    if (array_item($formdata, 'year_date')
        && is_numeric($formdata['month_date'])
        && is_numeric($formdata['day_date'])
        && !array_item($formdata, 'multi_year_appoint')
        && !is_numeric($formdata['multi_month_appoint'][0])
        && !is_numeric($formdata['multi_day_appoint'][0])
    ) {


        foreach ($fields as $key => $type) {
            $rows[$key] = $this->safify($formdata[$key], $type);
        }
        $rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
        $rows['full_date'] = $this->safify($rows['full_date'], $type);


    } elseif (array_item($formdata, 'multi_day_appoint')
        && array_item($formdata, 'multi_month_appoint')
        && array_item($formdata, 'multi_year_appoint')
        && is_numeric($formdata['multi_year_appoint'][0])
        && is_numeric($formdata['multi_month_appoint'][0])
        && is_numeric($formdata['multi_day_appoint'][0])
    ) {
        $fields = array('multi_year_appoint' => 'integer', 'multi_month_appoint' => 'integer', 'multi_day_appoint' => 'intger', 'full_date' => 'string');
        foreach ($fields as $key => $type) {
            for ($i = 0; $i < count($formdata['multi_day_appoint']); $i++) {

                if (!$formdata[$key][$i])
                    $formdata[$key][$i] = $formdata[$key][$i - 1];
                $rows[$key][$i] = $this->safify($formdata[$key][$i], $type);
            }
        }


        for ($i = 0; $i < count($formdata['multi_day_appoint']); $i++) {
            $multi_tmp_year = $rows[multi_year_appoint][$i];

            $multi_tmp_month = $rows[multi_month_appoint][$i];
            $multi_tmp_day = $rows[multi_day_appoint][$i];
            $rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";
            //unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
            //$rows['full_date'][$i] =$this-> safify($rows['full_date'][$i] , $type);

        }


    }
    //return $rows['full_date'];
    return $rows;

}
/**********************************************************************************************/
function build_date_manager(&$formdata)
{


    $fields = array('year_date' => 'integer', 'month_date' => 'integer', 'day_date' => 'intger', 'full_date' => 'string');


    if (array_item($formdata, 'year_date')
        && is_numeric($formdata['month_date'])
        && is_numeric($formdata['day_date'])
        && !array_item($formdata, 'multi_year_manager')
        && !is_numeric($formdata['multi_month_manager'][0])
        && !is_numeric($formdata['multi_day_manager'][0])
    ) {


        foreach ($fields as $key => $type) {
            $rows[$key] = $this->safify($formdata[$key], $type);
        }
        $rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
        $rows['full_date'] = $this->safify($rows['full_date'], $type);


    } elseif (array_item($formdata, 'multi_day_manager')
        && array_item($formdata, 'multi_month_manager')
        && array_item($formdata, 'multi_year_manager')
        && is_numeric($formdata['multi_year_manager'][0])
        && is_numeric($formdata['multi_month_manager'][0])
        && is_numeric($formdata['multi_day_manager'][0])
    ) {
        $fields = array('multi_year_manager' => 'integer', 'multi_month_manager' => 'integer', 'multi_day_manager' => 'intger', 'full_date' => 'string');
        foreach ($fields as $key => $type) {
            for ($i = 0; $i < count($formdata['multi_day_manager']); $i++) {

                if (!$formdata[$key][$i])
                    $formdata[$key][$i] = $formdata[$key][$i - 1];
                $rows[$key][$i] = $this->safify($formdata[$key][$i], $type);
            }
        }


        for ($i = 0; $i < count($formdata['multi_day_manager']); $i++) {
            $multi_tmp_year = $rows[multi_year_manager][$i];

            $multi_tmp_month = $rows[multi_month_manager][$i];
            $multi_tmp_day = $rows[multi_day_manager][$i];
            $rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";
            //unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
            //$rows['full_date'][$i] =$this-> safify($rows['full_date'][$i] , $type);

        }


    }

    return $rows;

}
/**********************************************************************************************/


function build_date3(&$formdata)
{
    if (array_item($formdata, 'multi_day')
        && array_item($formdata, 'multi_month_2')
        && array_item($formdata, 'multi_year_2')
        && is_numeric($formdata['multi_year_2'][0])
        && is_numeric($formdata['multi_month_2'][0])
        && is_numeric($formdata['multi_day_2'][0])
    ) {
        $fields = array('multi_year_2' => 'integer', 'multi_month_2' => 'integer', 'multi_day_2' => 'intger', 'full_date_2' => 'string');
        foreach ($fields as $key => $type) {
            for ($i = 0; $i < count($formdata['multi_day_2']); $i++) {

                if (!$formdata[$key][$i])
                    $formdata[$key][$i] = $formdata[$key][$i - 1];
                $rows[$key][$i] = $this->safify($formdata[$key][$i], $type);
            }
        }


        for ($i = 0; $i < count($formdata['multi_day_2']); $i++) {
            $multi_tmp_year = $rows[multi_year_2][$i];

            $multi_tmp_month = $rows[multi_month_2][$i];
            $multi_tmp_day = $rows[multi_day_2][$i];
            $rows['full_date'][$i] = "$multi_tmp_year-$multi_tmp_month-$multi_tmp_day";
            //unset($row['multi_year']); unset($row['multi_month']);   unset($row['multi_day']);
            $rows['full_date_2'][$i] = $this->safify($rows['full_date_2'][$i], $type);

        }


    }
    return $rows;

}
/****************************************************************************************************************************************/

function build_date1(&$formdata)
{

    $fields = array('year_date' => 'integer', 'month_date' => 'integer', 'day_date' => 'intger', 'full_date' => 'string');


    foreach ($fields as $key => $type) {
        $rows[$key] = $this->safify($formdata[$key], $type);
    }
    $rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
    $rows['full_date'] = $this->safify($rows['full_date'], $type);

    return $rows;

}

/**********************************************************************************************/
function build_date2(&$formdata)
{

    $fields = array('year_date_forum' => 'integer', 'month_date_forum' => 'integer', 'day_date_forum' => 'intger', 'full_date' => 'string');


    foreach ($fields as $key => $type) {
        $rows[$key] = $this->safify($formdata[$key], $type);
    }
    $rows['full_date'] = "$rows[year_date_forum]-$rows[month_date_forum]-$rows[day_date_forum]";
    // $rows['full_date'] =$this-> safify($rows['full_date'] , $type);


    return $rows;
}
/****************************************************************************************************/
function build_date_single_usr(&$formdata)
{

    $fields = array('year_date_usr' => 'integer', 'month_date_usr' => 'integer', 'day_date_usr' => 'intger', 'full_date_usr' => 'string');


    foreach ($fields as $key => $type) {
        $rows[$key] = $this->safify($formdata[$key], $type);
    }
    $rows['full_date_usr'] = "$rows[year_date_usr]-$rows[month_date_usr]-$rows[day_date_usr]";
    //$rows1['full_date_usr'] = "$formdata[year_date_usr]-$formdata[month_date_usr]-$formdata[day_date_usr]";
    $rows['full_date_usr'] = $this->safify($rows['full_date_usr'], $type);

    return $rows;

}
/***************************************************************************************************/
function build_date33(&$formdata)
{

    $fields = array('year_date_addusr' => 'integer', 'month_date_addusr' => 'integer', 'day_date_addusr' => 'intger', 'full_date_addusr' => 'string');


    foreach ($fields as $key => $type) {
        $rows[$key] = $this->safify($formdata[$key], $type);
    }
    $rows['full_date_addusr'] = "$rows[year_date_addusr]-$rows[month_date_addusr]-$rows[day_date_addusr]";
    $rows['full_date_addusr'] = $this->safify($rows['full_date_addusr'], $type);

    return $rows['full_date_addusr'];

}
/*****************************************************************************************************/
function build_date4(&$formdata)
{

    $fields = array('year_date_forum' => 'integer', 'month_date_forum' => 'integer', 'day_date_forum' => 'intger', 'full_date' => 'string');


    foreach ($fields as $key => $type) {
        $rows[$key] = $this->safify($formdata[$key], $type);
    }
    $rows['full_date'] = "$rows[year_date_forum]-$rows[month_date_forum]-$rows[day_date_forum]";
    // $rows['full_date'] =$this-> safify($rows['full_date'] , $type);


    return $rows;
}
/**************************************************************************************************/

function redirect($url = null)
{

    if (is_null($url)) $url = $_SERVER['SCRIPT_NAME'];
    header("Location: $url");
    exit();
}
/**************************************************************************************************/

function print_forum_paging($catID = "")
{
    global $db;
    echo "<h1>בחר פורום</h1>\n";
    echo "<p><b style='color:blue;'>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים נוספים בברנד.</b></p>\n";

    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    if ($rows = $db->queryObjectArray($sql)) {
        $parent = array();
        foreach ($rows as $row) {
            $subcategories[$row->parentCatID][] = $row->catID;
            $catNames[$row->catID] = $row->catName;
            $parent[$row->catID][] = $row->parentCatID;
        }


//  echo '<tr><td class="myformtable">';
//  echo '<table>';
        echo '<fieldset class="my_pageCount">';
        echo '<ul class="paginated" style=left:100px;  >';
        if (!is_numeric($catID))
            $this->print_categories_forum_paging($subcategories[NULL], $subcategories, $catNames, $parent);
        else
            $this->print_categories_forum_paging_link($subcategories[NULL], $subcategories, $catNames, $parent, $catID);

        echo '</ul class="paginated"></fieldset>';
//  echo '</table>';
//  echo '</td></tr>';
        echo '<BR><BR>';
    }
}

//********************************************************************************************************

function print_categories_forum_paging($catIDs, $subcategories, $catNames, $parent)
{
    echo '<ul>';
    foreach ($catIDs as $catID) {
        $url = "../admin/find3.php?catID=$catID";
        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
        if ($catID == 11) {
            printf("<li><b>%s (%s, %s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("../admin/dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"));

        } elseif ($parent[$catID][0] == '11' && !(array_item($subcategories, $catID))) {

            printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("../admin/dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("../admin/dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "catID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים", $str));

        } elseif ($parent[$catID][0] == '11' && array_item($subcategories, $catID)) {
            printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("../admin/dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("../admin/dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                //  build_href("../admin/find3.php", "catID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים", $str));

            //  echo "</li>\n";

        } else {
            printf("<li><b>%s (%s, %s, %s,%s,%s)</b>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("../admin/dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("../admin/dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "catID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים", $str));
            //  echo "</li>\n";

        }


        if (array_key_exists($catID, $subcategories))
            $this->print_categories_forum_paging($subcategories[$catID], $subcategories, $catNames, $parent);
    }
    echo "</li></ul>\n";
}

/*******************************************************************************/

function print_categories_forum_paging_link($catIDs, $subcategories, $catNames, $parent, $catID)
{
    echo '<ul>';
    foreach ($catIDs as $catID) {
        $url = "../admin/find3.php?catID=$catID";
        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
        if ($catID == 11) {
            printf("<li><b>%s (%s, %s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"));

        } elseif ($parent[$catID][0] == '11' && !(array_item($subcategories, $catID))) {

            printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("../admin/dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים", $str));

        } elseif ($parent[$catID][0] == '11' && array_item($subcategories, $catID)) {
            printf("<li class='li_page'><b>%s (%s, %s, %s,%s,%s)</b>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("../admin/dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים", $str));
        } else {
            printf("<li><b>%s (%s, %s, %s,%s,%s)</b>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("../admin/dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים", $str));
        }


        if (array_key_exists($catID, $subcategories))
            $this->print_categories_forum_paging_link($subcategories[$catID], $subcategories, $catNames, $parent, $catID);

    }
    echo "</li></ul>\n";
}


/*******************************************************************************/

function print_forum_paging_b($catID = "")
{
    /*************************************************************************************************************/

    global $db;
//  echo "<h1>בחר פורום</h1>\n";
//  echo "<p> <b style='color:blue;'>לחץ להוסיף/למחוק/לעדכן  או לראות נתונים נוספים בפורום.</B></p>\n";

    $sql = "SELECT catName, catID, parentCatID FROM categories ORDER BY catName";
    if ($rows = $db->queryObjectArray($sql)) {
        $parent = array();
        foreach ($rows as $row) {
            $subcategories[$row->parentCatID][] = $row->catID;
            $catNames[$row->catID] = $row->catName;
            $parent[$row->catID][] = $row->parentCatID;
        }
        echo '<fieldset class="my_pageCount"  style="margin-right:250px;">';


        echo '<ul class="paginated" style=left:100px;  >';
        if (!is_numeric($catID))
            $this->print_categories_forum_paging_b($subcategories[NULL], $subcategories, $catNames, $parent);
        else
            $this->print_categories_forum_paging_link_b($subcategories[NULL], $subcategories, $catNames, $parent, $catID);

        echo '</ul class="paginated"></fieldset>';
        echo '<BR><BR>';
    }
}
/***********************************************************************************************************/

function print_categories_forum_paging_b($catIDs, $subcategories, $catNames, $parent)
{
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
    if ($level) {
        echo '<ul>';
        foreach ($catIDs as $catID) {
            $url = "../admin/find3.php?catID=$catID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 id="' . $catID . '"   ';
            if ($catID == 11) {
                printf("<li style='font-weight:bold;color:red;font-size:20px;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '15px')\">%s (%s, %s)</li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("../admin/category_brand.php", "mode=insert", "&insertID=$catID", "הוסף"),
                    build_href2("category_brand.php", "mode=update", "&updateID=$catID", "עדכן שם"));
            } elseif ($parent[$catID][0] == '11' && !(array_item($subcategories, $catID))) {
                printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s, %s,%s)</li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("../admin/category_brand.php", "mode=insert", "&insertID=$catID", "הוסף"),
                    build_href2("../admin/category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                    build_href2("../admin/category_brand.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"));
                    //build_href5("", "", "הראה נתונים", $str));
            } elseif ($parent[$catID][0] == '11' && array_item($subcategories, $catID)) {
                printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s, %s,%s)\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("../admin/category_brand.php", "mode=insert", "&insertID=$catID", "הוסף"),
                    build_href2("../admin/category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                    build_href2("../admin/category_brand.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"));
                   // build_href5("", "", "הראה נתונים", $str));
            } else {
                printf("<li style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s, %s, %s,%s)\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("../admin/category_brand.php", "mode=insert", "&insertID=$catID", "הוסף"),
                    build_href2("../admin/category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                    build_href2("../admin/category_brand.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"));
                   // build_href5("", "", "הראה נתונים", $str));
            }
            if (array_key_exists($catID, $subcategories))
                $this->print_categories_forum_paging_b($subcategories[$catID], $subcategories, $catNames, $parent);
        }
        echo "</li></ul>\n";
    } elseif (!($level)) {
        echo '<ul>';
        foreach ($catIDs as $catID) {
            $url = "../admin/find3.php?catID=$catID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 id="' . $catID . '"   ';
            if ($catID == 11) {
                printf("<li style='font-weight:bold;color:red;font-size:30px;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '15px')\">%s </li>\n",
                    htmlspecial_utf8($catNames[$catID]));
            } elseif ($parent[$catID][0] == '11' && !(array_item($subcategories, $catID))) {
                printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s)</li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "מידע מורחב"));
                   // build_href5("", "", "הראה נתונים", $str));
            } elseif ($parent[$catID][0] == '11' && array_item($subcategories, $catID)) {
                printf("<li class='li_page' style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s)\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "מידע מורחב"));
                    //build_href5("", "", "הראה נתונים", $str));
            } else {
                printf("<li style='font-weight:bold;color:black;cursor:pointer;' id=li$catID onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\">%s (%s)\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "מידע מורחב"));
                    //build_href5("", "", "הראה נתונים", $str));
            }
            if (array_key_exists($catID, $subcategories))
                $this->print_categories_forum_paging_b($subcategories[$catID], $subcategories, $catNames, $parent);
        }
        echo "</li></ul>\n";
    }
}
//---------------------------------------------------------------------------------------------------------------------------
function print_categories_forum_paging_link_b($catIDs, $subcategories, $catNames, $parent, $catID)
{
    echo '<ul>';
    foreach ($catIDs as $catID) {
        $url = "../admin/find3.php?catID=$catID";
        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 id="' . $catID . '" ';
        if ($catID == 11) {
            printf("<li style='font-weight :bold;'>%s (%s, %s)</li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("category_brand.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן שם"));

        } elseif ($parent[$catID][0] == '11' && !(array_item($subcategories, $catID))) {


            printf("<li class='li_page'  style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)</li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("category_brand.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("../admin/category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                build_href2("../admin/category_brand.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "catID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים", $str));
        } elseif ($parent[$catID][0] == '11' && array_item($subcategories, $catID)) {
            printf("<li class='li_page' style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("category_brand.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("../admin/category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                build_href2("../admin/category_brand.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "catID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים", $str));
        } else {
            printf("<li  style='font-weight :bold;'>%s (%s, %s, %s,%s,%s)\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("category_brand.php", "mode=insert", "&insertID=$catID&catID=$catID", "קשר אליי"),
                build_href2("../admin/category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                build_href2("../admin/category_brand.php", "mode=update", "&updateID=$catID", "עדכן שם"),
                build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                // build_href("../admin/find3.php", "catID=$catID", "הראה נתונים"));
                build_href5("", "", "הראה נתונים", $str));
        }


        if (array_key_exists($catID, $subcategories))
            $this->print_categories_forum_paging_link_b($subcategories[$catID], $subcategories, $catNames, $parent, $catID);

    }
    echo "</li></ul>\n";
}//end func///
//////////////

/*******************************************************************************/

function print_forum($catIDs, $subcategories, $forumNames)
{
    /**************************************************************************/

    global $db;
    echo "<ul>";
    foreach ($catIDs as $catID) {
        if ($catID == 11) {
            printf("<li><b>%s(%s,%s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן"));
        } else {
            printf("<li><b>%s (%s, %s,  %s, %s, %s )</b></li>\n",

                htmlspecial_utf8($decNames[$catID]),

                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן"),
                build_href("find3.php", "&catID=$catID", "נתונים כלליים"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"));
        }

        if (array_key_exists($catID, $subcategories))
            $this->print_forum($subcategories[$catID], $subcategories, $forumNames);
    }
    echo "</ul>\n";
}

/*******************************************************************************/

function print_form1($catID1)
{
    global $db;


    $sql = "SELECT forum_decName, catID, parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    foreach ($rows as $row) {
        $subcategories[$row->parentForum_decID][] = $row->catID;
        $forumNames[$row->catID] = $row->forum_decName;
    }
    // build hierarchical list
    $this->print_forums1($subcategories[NULL], $subcategories, $forumNames, $catID1);

    // link to input and search forms
    printf("<p><b><br />%s</b></p>\n",
        build_href("find3.php", "", "חפש פורומים/החלטות"));
    $insertID = $_GET['insertID'];
    return $insertID;
}
//********************************************************************************************************

function print_forums1($catIDs, $subcategories, $forumNames, $catID1)
{
    /*******************************************************************************/
    echo "<ul>";
    foreach ($catIDs as $catID) {
        printf("<li>%s (%s)</li>\n",
            htmlspecial_utf8($decNames[$catID]),
            //build_href("dynamic_8.php","&insertID=$catID", "קשר אליי"));
            build_href2("dynamic_8.php", "mode=link", "&insertID=$catID&catID=$catID1", "קשר אליי"));
        if (array_key_exists($catID, $subcategories))
            $this->print_forums1($subcategories[$catID], $subcategories, $forumNames, $catID1);
    }
    echo "</ul>\n";
}

/*******************************************************************************/

function print_forum_dec($catIDs, $subcategories, $forumNames)
{
    echo "<ul>";
    foreach ($catIDs as $catID) {
        if ($catID == 11) {
            printf("<li><b>%s (%s, %s)</b></li>\n",
                htmlspecial_utf8($catNames[$catID]),
                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן"));
        } else {
            printf("<li><b>%s (%s, %s, %s, %s, %s )</b></li>\n",

                htmlspecial_utf8($decNames[$catID]),

                build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                build_href2("dynamic_8.php", "mode=delete", "&deleteID=$catID", "OnClick= 'return verify();' class='href_modal1'"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן"),
                build_href("find3.php", "&catID=$catID", "נתונים כלליים"),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"));

        }

        if (array_key_exists($catID, $subcategories)) {

            $this->print_forums($subcategories[$catID], $subcategories, $forumNames);

        }
    }
    echo "</ul>\n";
}
/*******************************************************************************/
function print_form2($catID1)
{
    /*******************************************************************************/
    global $db;


    // query for all categories1
    $sql = "SELECT forum_decName, catID, parentForumID FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    foreach ($rows as $row) {
        $subcategories[$row->parentforum_decID][] = $row->catID;
        $forumNames[$row->catID] = $row->forum_decName;
    }
    // build hierarchical list
    $this->print_forums1($subcategories[NULL], $subcategories, $forumNames, $catID1);
    printf("<p><b><br />%s<b></p>\n",
        build_href("find3.php", "", "חפש פורומים/החלטות"));
}
/*******************************************************************************/

function print_forum_entry_form1($updateID, $mode = '') {
/******************************************************************************************************/
$insertID = $updateID;
global $db;
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
if ($level){
$sql = "SELECT catName, catID, parentcatID " .
    " FROM categories ORDER BY catName";
$rows = $db->queryObjectArray($sql);

// build assoc. arrays for name, parent and subcategories
foreach ($rows as $row) {
    $forumNames[$row->catID] = $row->catName;
    $parents[$row->catID] = $row->parentcatID;
    $subcategories[$row->parentcatID][] = $row->catID;
}

// build list of all parents for $insertID
$catID = $updateID;
while ($parents[$catID] != NULL) {
    $catID = $parents[$catID];
    $parentList[] = $catID;
}
//display all exept the choozen
if (isset($parentList)){
for ($i = sizeof($parentList) - 1;
$i >= 0;
$i--){
?>
<div id="my_forum_entry_first<?PHP echo $updateID; ?>"><?php
    $url = "../admin/find3.php?catID=$parentList[$i]";
    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';

    if ($parentList[$i] == '11') {
        printf("<ul id='my_ul_first'><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b> </li>\n",
            htmlspecial_utf8($forumNames[$parentList[$i]]),
            build_href2("dynamic_8.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
            build_href2("dynamic_8.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם")
        );
    } else {
        printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
            htmlspecial_utf8($forumNames[$parentList[$i]]),
            build_href2("dynamic_8.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
            build_href2("dynamic_8.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
            build_href2("dynamic_8.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם"),
            build_href2("dynamic_8.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
            build_href5("", "", "הראה נתונים", $str));
       }
     }
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // display choosen cat  * BOLD *
    if ($insertID == '11') {
        printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
            htmlspecial_utf8($forumNames[$updateID]),
            build_href2("dynamic_8.php", "mode=insert", "&insertID=$updateID", "הוסף"),
            build_href2("dynamic_8.php", "mode=update", "&updateID=$updateID", "עדכן שם"));
    } else {
        $url = "../admin/find3.php?catID=$updateID";
        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
        printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
            htmlspecial_utf8($forumNames[$updateID]),
            build_href2("dynamic_8.php", "mode=insert", "&insertID=$updateID", "הוסף"),
            build_href2("dynamic_8.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
            build_href2("dynamic_8.php", "mode=update", "&updateID=$updateID", "עדכן שם"),
            build_href2("dynamic_8.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
            build_href5("", "", "הראה נתונים", $str));
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    echo "<ul>";
    $i = 0;
    if (array_key_exists($updateID, $subcategories)) {
        while (!empty($subcategories[$updateID]) && $subcategories[$updateID]) {
            foreach ($subcategories[$updateID] as $catID) {
                $url = "../admin/find3.php?catID=$catID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                    htmlspecial_utf8($forumNames[$catID]),
                    build_href2("dynamic_8.php", "mode=insert", "&insertID=$catID", "הוסף"),
                    build_href2("dynamic_8.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_8.php", "mode=update", "&updateID=$catID", "עדכן"),
                    build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
            echo "<ul>";
            $updateID = $catID;
            $i++;
        }
        // close hierarchical category list
        echo str_repeat("</ul>", $i + 1), "\n";
    } else {
        echo "(עדיין אין תת-ברנדים.)";
    }
    echo "</ul>\n";
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // close hierarchical category list
    if (isset($parentList))
        echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
    echo '</div>';
    /////////////////////////////
    }elseif (!($level)){///
    ///////////////////////////
    $sql = "SELECT forum_decName, catID, parentForumID " .
        " FROM forum_dec ORDER BY forum_decName";
    $rows = $db->queryObjectArray($sql);
    // build assoc. arrays for name, parent and subcategories
    foreach ($rows as $row) {
        $forumNames[$row->catID] = $row->forum_decName;
        $parents[$row->catID] = $row->parentForumID;
        $subcategories[$row->parentForumID][] = $row->catID;
    }
    // build list of all parents for $insertID
    $catID = $updateID;
    while ($parents[$catID] != NULL) {
        $catID = $parents[$catID];
        $parentList[] = $catID;
    }
    //display all exept the choozen
    if (isset($parentList)){
    for ($i = sizeof($parentList) - 1;
    $i >= 0;
    $i--){
    ?>
    <div id="my_forum_entry_first<?PHP echo $updateID; ?> ">
        <?php
        $url = "../admin/find3.php?catID=$parentList[$i]";
        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
        if ($parentList[$i] == '11') {
            printf("<ul id='my_ul_first'><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s </b> </li>\n",
                htmlspecial_utf8($forumNames[$parentList[$i]]));
        } else {
            printf("<ul><li style='font-weight :bold;'> %s (%s, %s ) </li>\n",
                htmlspecial_utf8($forumNames[$parentList[$i]]),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$parentList[$i]", "מידע מורחב"),
                build_href5("", "", "הראה נתונים", $str));
           }
         }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // display choosen cat  * BOLD *
        if ($insertID == '11') {
            printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                htmlspecial_utf8($forumNames[$updateID]),
                build_href2("dynamic_8.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                build_href2("dynamic_8.php", "mode=update", "&updateID=$updateID", "עדכן שם"));
        } else {
            $url = "../admin/find3.php?catID=$updateID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
            printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                htmlspecial_utf8($forumNames[$updateID]),
                build_href2("dynamic_8.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                build_href5("", "", "הראה נתונים", $str));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        echo "<ul>";
        $i = 0;
        if (array_key_exists($updateID, $subcategories)) {
            while ($subcategories[$updateID]) {
                foreach ($subcategories[$updateID] as $catID) {
                    $url = "../admin/find3.php?catID=$catID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",
                        htmlspecial_utf8($forumNames[$catID]),
                        build_href2("dynamic_8.php", "mode=read_data", "&editID=$catID", "מידע מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }
                echo "<ul>";
                $updateID = $catID;
                $i++;
            }
            // close hierarchical category list
            echo str_repeat("</ul>", $i + 1), "\n";
        } else {
            echo "(עדיין אין תת-ברנדים.)";
        }
        echo "</ul>\n";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // close hierarchical category list
        if (isset($parentList))
            echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
        echo '</div>';
        }//end else
        }
        function print_cat_entry_form_b($updateID, $mode = '')
        {
            $insertID = $updateID;
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
            if ($level) {
                $sql = "SELECT catName, catID, parentcatID " .
                    " FROM categories ORDER BY catName";
                $rows = $db->queryObjectArray($sql);
                foreach ($rows as $row) {
                    $forumNames[$row->catID] = $row->catName;
                    $parents[$row->catID] = $row->parentcatID;
                    $subcategories[$row->parentcatID][] = $row->catID;
                }
                // build list of all parents for $insertID
                $catID = $updateID;
                while ($parents[$catID] != NULL) {
                    $catID = $parents[$catID];
                    $parentList[] = $catID;
                }
                echo '<div id="my_forum_entry_b">';
                //display all exept the choozen
                if (isset($parentList)) {
                    for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                        $url = "../admin/find3.php?catID=$parentList[$i]";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        if ($parentList[$i] == '11') {
                            printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b> </li>\n",
                                htmlspecial_utf8($forumNames[$parentList[$i]]),
                                build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                                build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם")
                            );
                        } else {
                            printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                                htmlspecial_utf8($forumNames[$parentList[$i]]),
                                build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                                build_href2("category_brand.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();'class=href_modal1"),
                                build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם"),
                                build_href2("category_brand.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                                build_href5("", "", "הראה נתונים", $str));
                        }
                    }
                }
                // display choosen cat  * BOLD *
                //display the last on
                if ($insertID == '11') {
                    printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                        htmlspecial_utf8($forumNames[$updateID]),
                        build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                        build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"));
                } else {
                    $url = "../admin/find3.php?catID=$updateID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                        htmlspecial_utf8($forumNames[$updateID]),
                        build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                        build_href2("category_brand.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();'class=href_modal1"),
                        build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"),
                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }
                echo "<ul>";
                $i = 0;
                if (array_key_exists($updateID, $subcategories)) {
                    while (!empty($subcategories[$updateID]) && $subcategories[$updateID]) {
                        foreach ($subcategories[$updateID] as $catID) {
                            $url = "../admin/find3.php?catID=$catID";
                            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                            printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                                htmlspecial_utf8($forumNames[$catID]),
                                build_href2("category_brand.php", "mode=insert", "&insertID=$catID", "הוסף"),
                                build_href2("category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();'class=href_modal1"),
                                build_href2("category_brand.php", "mode=update", "&updateID=$catID", "עדכן"),
                                build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                                build_href5("", "", "הראה נתונים", $str));
                        }
                        echo "<ul>";
                        $updateID = $catID;
                        $i++;
                    }
                    // close hierarchical category list
                    echo str_repeat("</ul>", $i + 1), "\n";
                } else {
                    echo "(עדיין אין תת-ברנדים.)";
                }
                echo "</ul>\n";
                // close hierarchical category list
                if (isset($parentList))
                    echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
                echo '</div>';
            } elseif (!($level)) {
                $sql = "SELECT forum_decName, catID, parentForumID " .
                    " FROM forum_dec ORDER BY forum_decName";
                $rows = $db->queryObjectArray($sql);
                // build assoc. arrays for name, parent and subcategories
                foreach ($rows as $row) {
                    $forumNames[$row->catID] = $row->forum_decName;
                    $parents[$row->catID] = $row->parentForumID;
                    $subcategories[$row->parentForumID][] = $row->catID;
                }
                // build list of all parents for $insertID
                $catID = $updateID;
                while ($parents[$catID] != NULL) {
                    $catID = $parents[$catID];
                    $parentList[] = $catID;
                }
                echo '<div id="my_forum_entry_b">';
                //display all exept the choozen
                if (isset($parentList)) {
                    for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                        $url = "../admin/find3.php?catID=$parentList[$i]";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        if ($parentList[$i] == '11') {
                            printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s </b> </li>\n",
                                htmlspecial_utf8($forumNames[$parentList[$i]]));
                        } else {
                            printf("<ul><li style='font-weight :bold;'> %s (%s, %s) </li>\n",
                                htmlspecial_utf8($forumNames[$parentList[$i]]),
                                build_href2("category_brand.php", "mode=read_data", "&editID=$parentList[$i]", "מידע מורחב"),
                                build_href5("", "", "הראה נתונים", $str));
                        }

                    }
                }
                // display choosen cat  * BOLD *
                //display the last on
                if ($insertID == '11') {
                    printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                        htmlspecial_utf8($forumNames[$updateID]),
                        build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                        build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"));
                } else {
                    $url = "../admin/find3.php?catID=$updateID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                        htmlspecial_utf8($forumNames[$updateID]),
                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }
                echo "<ul>";
                $i = 0;
                if (array_key_exists($updateID, $subcategories)) {
                    while ($subcategories[$updateID]) {
                        foreach ($subcategories[$updateID] as $catID) {
                            $url = "../admin/find3.php?catID=$catID";
                            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                            printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",
                                htmlspecial_utf8($forumNames[$catID]),
                                build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "מידע מורחב"),
                                build_href5("", "", "הראה נתונים", $str));
                        }
                        echo "<ul>";
                        $updateID = $catID;
                        $i++;
                    }
                    // close hierarchical category list
                    echo str_repeat("</ul>", $i + 1), "\n";
                } else {
                    echo "(עדיין אין תת-ברנדים.)";
                }
                echo "</ul>\n";
                // close hierarchical category list
                if (isset($parentList))
                    echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
                echo '</div>';
            }
        } //end func //

        function print_forum_entry_form_c($updateID, $mode = '')
        {
            $insertID = $updateID;
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
            if ($level) {
                $sql = "SELECT catName, catID, parentcatID " .
                    " FROM categories ORDER BY catName";
                if ($rows = $db->queryObjectArray($sql)) {
                    // build assoc. arrays for name, parent and subcategories
                    foreach ($rows as $row) {
                        $forumNames[$row->catID] = $row->catName;
                        $parents[$row->catID] = $row->parentcatID;
                        $subcategories[$row->parentcatID][] = $row->catID;
                    }
                    // build list of all parents for $insertID
                    $catID = $updateID;
                    while ($parents[$catID] != NULL) {
                        $catID = $parents[$catID];
                        $parentList[] = $catID;
                    }
                    echo '<div id="my_forum_entry_c">';
                    //display all exept the choozen
                    if (isset($parentList)) {
                        for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                            $url = "../admin/find3.php?catID=$parentList[$i]";
                            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                            if ($parentList[$i] == '11') {
                                printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b> </li>\n",
                                    htmlspecial_utf8($forumNames[$parentList[$i]]),
                                    build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                                    build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם")
                                );
                            } else {
                                printf("<ul><li style='font-weight:bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                                    htmlspecial_utf8($forumNames[$parentList[$i]]),
                                    build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                                    build_href2("category_brand.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                                    build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם"),
                                    build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                                    build_href5("", "", "הראה נתונים", $str));
                            }

                        }
                    }
                    // display choosen cat  * BOLD *
                    //display the last on
                    if ($insertID == '11') {
                        printf("<ul><li><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                            htmlspecial_utf8($forumNames[$updateID]),
                            build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                            build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"));

                    } else {
                        $url = "../admin/find3.php?catID=$updateID";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<ul><li class='bgchange_tree' style='font-weight:bold;'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                            htmlspecial_utf8($forumNames[$updateID]),
                            build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                            build_href2("category_brand.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"),
                            build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));
                    }
                    echo "<ul>";
                    $i = 0;
                    if (array_key_exists($updateID, $subcategories)) {
                        while (!empty($subcategories[$updateID]) && $subcategories[$updateID]) {
                            foreach ($subcategories[$updateID] as $catID) {
                                $url = "../admin/find3.php?catID=$catID";
                                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                                printf("<li style='font-weight:bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                                    htmlspecial_utf8($forumNames[$catID]),
                                    build_href2("category_brand.php", "mode=insert", "&insertID=$catID", "הוסף"),
                                    build_href2("category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                                    build_href2("category_brand.php", "mode=update", "&updateID=$catID", "עדכן"),
                                    build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                                    build_href5("", "", "הראה נתונים", $str));
                            }
                            echo "<ul>";
                            $updateID = $catID;
                            $i++;
                        }
                        // close hierarchical category list
                        echo str_repeat("</ul>", $i + 1), "\n";
                    } else {
                        echo "(עדיין אין תת-ברנדים.)";
                    }
                    echo "</ul>\n";
                    // close hierarchical category list
                    if (isset($parentList))
                        echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
                    echo '</div>';
                } elseif (!($level)) {/////
                    $sql = "SELECT catName, catID, parentcatID " .
                        " FROM categories ORDER BY catName";
                    if ($rows = $db->queryObjectArray($sql)) {
                        // build assoc. arrays for name, parent and subcategories
                        foreach ($rows as $row) {
                            $forumNames[$row->catID] = $row->catName;
                            $parents[$row->catID] = $row->parentcatID;
                            $subcategories[$row->parentcatID][] = $row->catID;
                        }
                        // build list of all parents for $insertID
                        $catID = $updateID;
                        while ($parents[$catID] != NULL) {
                            $catID = $parents[$catID];
                            $parentList[] = $catID;
                        }
                        echo '<div id="my_forum_entry_c">';
                        //display all exept the choozen
                        if (isset($parentList)) {
                            for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                                $url = "../admin/find3.php?catID=$parentList[$i]";
                                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                                if ($parentList[$i] == '11') {
                                    printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s </b> </li>\n",
                                        htmlspecial_utf8($forumNames[$parentList[$i]]));
                                } else {
                                    printf("<ul><li style='font-weight:bold;'> %s (%s, %s ) </li>\n",
                                        htmlspecial_utf8($forumNames[$parentList[$i]]),
                                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                                        build_href5("", "", "הראה נתונים", $str));
                                }
                            }
                        }
                        // display choosen cat  * BOLD *
                        //display the last on
                        if ($insertID == '11') {
                            printf("<ul><li><b style='color:red;'> %s </b> </li>\n",
                                htmlspecial_utf8($forumNames[$updateID]));
                        } else {
                            $url = "../admin/find3.php?catID=$updateID";
                            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                            printf("<ul><li class='bgchange_tree' style='font-weight:bold;'><b style='color:red;'> %s (%s, %s )</b> </li>\n",
                                htmlspecial_utf8($forumNames[$updateID]),
                                build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                                build_href5("", "", "הראה נתונים", $str));
                        }
                        echo "<ul>";
                        $i = 0;
                        if (array_key_exists($updateID, $subcategories)) {
                            while (!empty($subcategories[$updateID]) && $subcategories[$updateID]) {
                                foreach ($subcategories[$updateID] as $catID) {
                                    $url = "../admin/find3.php?catID=$catID";
                                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                                    printf("<li style='font-weight:bold;'> %s (%s, %s) </li>\n",
                                        htmlspecial_utf8($forumNames[$catID]),
                                        build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                                        build_href5("", "", "הראה נתונים", $str));
                                }
                                echo "<ul>";
                                $updateID = $catID;
                                $i++;
                            }
                            // close hierarchical category list
                            echo str_repeat("</ul>", $i + 1), "\n";
                        } else {
                            echo "(עדיין אין תת-ברנדים.)";
                        }
                        echo "</ul>\n";
                        // close hierarchical category list
                        if (isset($parentList))
                            echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
                        echo '</div>';
                    }
                }
            }
        }//end func///

        function print_forum_entry_form_d($updateID, $mode = '')
        {
            $insertID = $updateID;
            global $db;
            $sql = "SELECT catName, catID, parentcatID " .
                " FROM categories ORDER BY catName";
            $rows = $db->queryObjectArray($sql);
            // build assoc. arrays for name, parent and subcategories
            foreach ($rows as $row) {
                $forumNames[$row->catID] = $row->catName;
                $parents[$row->catID] = $row->parentcatID;
                $subcategories[$row->parentcatID][] = $row->catID;
            }
            // build list of all parents for $insertID
            $catID = $updateID;
            while ($parents[$catID] != NULL) {
                $catID = $parents[$catID];
                $parentList[] = $catID;
            }
            echo '<div id="my_forum_entry_b">';
            //display all exept the choozen
            if (isset($parentList)) {
                for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                    $url = "../admin/find3.php?catID=$parentList[$i]";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    if ($parentList[$i] == '11') {
                        printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b></li>\n",
                            htmlspecial_utf8($forumNames[$parentList[$i]]),
                            build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם")
                        );
                    } else {
                        printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($forumNames[$parentList[$i]]),
                            build_href2("category_brand.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("category_brand.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("category_brand.php", "mode=update", "&updateID=$parentList[$i]", "עדכן שם"),
                            build_href2("category_brand.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));
                    }
                }
            }
            // display choosen cat  * BOLD *
            //display the last on
            if ($insertID == '11') {
                printf("<ul><li style='font-weight :bold;'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                    htmlspecial_utf8($forumNames[$updateID]),
                    build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"));
            } else {
                $url = "../admin/find3.php?catID=$updateID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<ul><li class='bgchange_tree' style='font-weight :bold;'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                    htmlspecial_utf8($forumNames[$updateID]),
                    build_href2("category_brand.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("category_brand.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("category_brand.php", "mode=update", "&updateID=$updateID", "עדכן שם"),
                    build_href2("category_brand.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
            echo "<ul>";
            $i = 0;
            if (array_key_exists($updateID, $subcategories)) {
                while ($subcategories[$updateID]) {
                    foreach ($subcategories[$updateID] as $catID) {
                        $url = "../admin/find3.php?catID=$catID";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($forumNames[$catID]),
                            build_href2("category_brand.php", "mode=insert", "&insertID=$catID", "הוסף"),
                            build_href2("category_brand.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("category_brand.php", "mode=update", "&updateID=$catID", "עדכן"),
                            build_href2("category_brand.php", "mode=read_data", "&editID=$catID", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));
                    }
                    echo "<ul>";
                    $updateID = $catID;
                    $i++;
                }
                // close hierarchical category list
                echo str_repeat("</ul>", $i + 1), "\n";
            } else {
                echo "(עדיין אין תת-ברנדים.)";
            }
            echo "</ul>\n";
            // close hierarchical category list
            if (isset($parentList))
                echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
            if (($mode == 'update')) {
                echo '<form method="post" action="category_brand.php?mode=update&updateID=',
                $insertID, '">', "\n",
                "<p>עדכן שם הפורום של ",
                "<b>$forumNames[$insertID]</b>. <br /> ",
                '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
                '<input type="submit" value="OK" name="submitbutton" /></p>', "\n",
                "</form>\n";
            }
            echo '</div>';
        }//end func///

        function read_form()
        {
            $insertID = array_item($_REQUEST, 'insertID');
            $deleteID = array_item($_REQUEST, 'deleteID');
            $updateID = array_item($_REQUEST, 'updateID');
            $submitbutton = array_item($_POST, 'submitbutton');
            $subcategories = array_item($_POST, 'subcategories');
            // remove magic quotes
            if (get_magic_quotes_gpc())
                $subcategories = stripslashes($subcategories);
        }

//-----------------------------------------------------------------------------------------------

        function read_cat_data($catID)
        {
            global $db;
            $sql = "select * from categories WHERE catID = $catID";
            if ($rows = $db->queryObjectArray($sql)) {
                if (is_array($rows) && sizeof($rows) == 1) {
                    $row1 = $rows[0];
                    $result["catID"] = $row1->catID;
                    $result["parentcatID"] = $row1->parentCatID;
                    $result["insertID"] = $row1->parentCatID;
                    $result["catName"] = $row1->catName;
                    $result["catPrefix"] = $row1->catPrefix;
                }
                return $result;
            }
        }
//-----------------------------------------------------------------------------------------------
        // read all data for a certain cat from database
        // and save it in an array; return this array
        function read_cat_data1($catID)
        {
            global $db;
            $sql = "select b.* ,p.pdfName from categories b ,pdfs p 
                        WHERE b.pdfID=p.pdfID
                        AND catID=$catID";
            if ($rows = $db->queryObjectArray($sql)) {
                $rows[0]->cat_date = substr($rows[0]->cat_date, 0, 10);
                list($year_date, $month_date, $day_date) = explode('-', $rows[0]->cat_date);
                if (strlen($year_date > 3))
                    $rows[0]->cat_date = "$day_date-$month_date-$year_date";

                if (is_array($rows) && sizeof($rows) == 1) {
                    $row1 = $rows[0];
                    $result["forum_decision"] = $row1->catID;
                    $result["catID"] = $row1->catID;
                    $result["parentForumID"] = $row1->parentForumID;
                    $result["insert_forum"] = $row1->parentForumID;
                    $result["insertID"] = $row1->parentForumID;
                    $result["forum_decName"] = $row1->forum_decName;
                    $result["forum_status"] = $row1->active;
                    $result["cat_allowed"] = $row1->cat_allowed;


                    $result["cat_date"] = $row1->cat_date;
                    $result['day_date'] = $day_date;
                    $result['month_date'] = $month_date;
                    $result['year_date'] = $year_date;


                    $result["appoint_forum"] = $row1->appointID;
                    $result["manager_forum"] = $row1->managerID;
                    $result["managerName"] = $row1->managerName;

                    $result["appoint_date"] = $row1->appoint_date;
                    list($year_date, $month_date, $day_date) = explode('-', $result["appoint_date"]);
                    if (strlen($year_date) > 3) {
                        $result["appoint_date"] = "$day_date-$month_date-$year_date";
                    }


                    $result["manager_date"] = $row1->manager_date;
                    list($year_date, $month_date, $day_date) = explode('-', $result["manager_date"]);
                    if (strlen($year_date) > 3) {
                        $result["manager_date"] = "$day_date-$month_date-$year_date";
                    }


                    $result["src_users"] = "";
                    $result["src_usersID"] = "";
                    $result["date_users"] = "";

                    $result["src_managersType"] = "";
                    $result["src_forumsType"] = "";
                }
                /********************************USER_FORUM_NAME*******************************************/

                $sql = "SELECT u.userID, u.full_name,r.HireDate FROM users u, rel_user_forum r " .
                    " WHERE u.userID = r.userID " .
                    " AND r.catID = $catID " .
                    " ORDER BY u.full_name ";
                if ($rows = $db->queryObjectArray($sql))
                    foreach ($rows as $row) {
                        if (!$result["src_users"]) {
                            $name1 = $row->full_name;
                            $name = is_null($name1) ? 'NULL' : "$name1";
                            $result["src_users"] = $name;

                            $date1 = $row->HireDate;
                            $date1 = substr($row->HireDate, 0, 10);
                            $date = is_null($date1) ? 'NULL' : "'$date1'";
                            $result["date_users"] = $date;
                        } else {
                            $name1 = $row->full_name;
                            $name = is_null($name1) ? 'NULL' : "$name1";
                            $result["src_users"] .= "," . $name;

                            $date1 = $row->HireDate;
                            $date1 = substr($row->HireDate, 0, 10);
                            $date = is_null($date1) ? 'NULL' : "'$date1'";
                            $result["date_users"] .= "," . $date;
                        }
                    }
                /********************************USER_FORUM_ID*******************************************/

                $sql = "SELECT u.userID  FROM users u, rel_user_forum r " .
                    " WHERE u.userID = r.userID " .
                    " AND r.catID = $catID " .
                    " ORDER BY u.full_name ";
                if ($rows = $db->queryObjectArray($sql))
                    foreach ($rows as $row) {
                        if (!$result["src_usersID"]) {
                            $userID = $row->userID;
                            $userID = is_null($userID) ? 'NULL' : $userID;
                            $result["src_usersID"] = $userID;

                        } else {
                            $userID = $row->userID;
                            $userID = is_null($userID) ? 'NULL' : $userID;
                            $result["src_usersID"] .= "," . $userID;

                        }
                    }


                /*******************************CATEGORY_FORUM********************************************/

                $sql = "SELECT c.catID  FROM categories1 c, rel_cat_forum r
WHERE c.catID = r.catID
AND r.catID =$catID ORDER BY c.catName";
                if ($rows = $db->queryObjectArray($sql)) {
                    $i = 0;
                    foreach ($rows as $row) {

                        $result["dest_forumsType"][$i] = $row->catID;


                        $i++;
                    }

                }
                /*******************************TYPE_MANAGER***********************************************************/

                $sql = "SELECT m.managerTypeID  FROM manager_type m, rel_managerType_forum r
WHERE m.managerTypeID = r.managerTypeID
AND r.catID =$catID ORDER BY m.managerTypeName";
                if ($rows = $db->queryObjectArray($sql)) {
                    $i = 0;
                    foreach ($rows as $row) {

                        $result["dest_managersType"][$i] = $row->managerTypeID;
                        $i++;
                    }

                }

                /******************************************************************************************/


            }
            $result = isset($result) ? $result : false;
            return $result;
        }
        //--------------------------------------------------------------------------------------------------------------------------------

        function read_forum_data2($catID)
        {

            global $db;

            $sql = "select * from forum_dec WHERE catID=$catID  ";
            $rows = $db->queryObjectArray($sql);
            $rows[0]->cat_date = substr($rows[0]->cat_date, 0, 10);
            list($year_date, $month_date, $day_date) = explode('-', $rows[0]->cat_date);
            if (strlen($year_date > 3))
                $rows[0]->cat_date = "$day_date-$month_date-$year_date";

            if (is_array($rows) && sizeof($rows) == 1) {
                $row1 = $rows[0];
                $result["forum_decision"] = $row1->catID;
                $result["catID"] = $row1->catID;
                $result["parentForumID"] = $row1->parentForumID;
                $result["forum_decName"] = $row1->forum_decName;
                $result["forum_status"] = $row1->active;
                $result["managerType"] = $row1->managerTypeID;
//$result["cat_date"]  =substr(($row->cat_date) ,10,6);
                $result["cat_date"] = $row1->cat_date;
                $result['day_date'] = $day_date;
                $result['month_date'] = $month_date;
                $result['year_date'] = $year_date;


                $result["appointID"] = $row1->appointID;
                $result["managerID"] = $row1->managerID;

                $result["appoint_date"] = $row1->appoint_date;
                list($year_date, $month_date, $day_date) = explode('-', $result["appoint_date"]);
                if (strlen($year_date) > 3) {
                    $result["appoint_date"] = "$day_date-$month_date-$year_date";
                }


                $result["manager_date"] = $row1->manager_date;
                list($year_date, $month_date, $day_date) = explode('-', $result["manager_date"]);
                if (strlen($year_date) > 3) {
                    $result["manager_date"] = "$day_date-$month_date-$year_date";
                }

                $result['multi_year'] = $_SESSION['multi_year'];
                $result['multi_month'] = $_SESSION['multi_month'];
                $result['multi_day'] = $_SESSION['multi_day'];


//$result["user_forum"]   = "";
                $result["usr_details"] = "";
                $result["date_users"] = "";
                $result["category"] = "";
//$result["managerType"]="";
                $result["add_user"] = "";
                $result["del_user"] = "";

                /********************************USER_FORUM*******************************************/
                $sql = "SELECT u.full_name,u.userID,r.HireDate FROM users u, rel_user_forum r  
WHERE u.userID = r.userID    
AND r.catID = $catID 
ORDER BY u.full_name";
                $rows = $db->queryObjectArray($sql);
                if ($rows) {
                    $result["usr_details"] = $rows;
                    foreach ($rows as $row) {
                        if (!$result["usr_frm"])
                            $result["usr_frm"] = $row->full_name;
                        else
                            $result["usr_frm"] .= ";" . $row->full_name;

                    }
                }


                /*******************************CATEGORY_FORUM********************************************/

                $sql = "SELECT c.catID  FROM categories1 c, rel_cat_forum r
WHERE c.catID = r.catID
AND r.catID =$catID ORDER BY c.catName";
                if ($rows = $db->queryObjectArray($sql))
                    foreach ($rows as $row) {
                        if (!$result["category"])
                            $result["category"] = $row->catID;
                        else
                            $result["category"] .= ";" . $row->catID;
                    }
                /*******************************CATEGORY_MANAGER***********************************************************/


                return $result;
            }
        }
        /*******************************************************************************************/

        // read all data for a certain cat from database
        // and save it in an array; return this array

        function read_forum_data3($catID)
        {

            global $db;


            $sql = "SELECT u.userID FROM users u, rel_user_forum r " .
                " WHERE u.userID = r.userID " .
                " AND r.catID = $catID " .
                " ORDER BY u.full_name ";
            if ($rows = $db->queryObjectArray($sql))
                foreach ($rows as $row) {
                    if (!$result["dest_users"])
                        $result["dest_users"] = $row->userID;
                    else
                        $result["dest_users"] .= ";" . $row->userID;
                }
            return $result;
        }
        /*******************************************************************************************/

        // read all data for a certain cat from database
        // read all data for a certain cat from database
        // and save it in an array; return this array

        function validate_data_ajx(&$formdata = "", &$pdfIDS = "", $cat_date = "", $insertID = "", $formselect = "")
        {

            global $db;
            $result = TRUE;
            $catID = $formdata['catID'];
            $message = array();
            $response['message'] = array();
            $cat = new category();

            $j = 0;
            $i = 0;

            $newcatNameName = isset($formdata['newcatNameName']) ? $formdata['newcatNameName'] : '';
            if (!empty($newcatNameName) && !($newcatNameName == NULL)) {
                $newcatNameName = $db->sql_string($newcatNameName);
                $sql = "SELECT COUNT(*) FROM categories " .
                    " WHERE parentcatID = $insertID " .
                    "  AND catName = $newcatNameName";

                try {
                    if ($db->querySingleItem($sql) > 0) {
                        $result = FALSE;
                        throw new Exception("כבר קיים ברנד בשם זה!");
                    }
                } catch (Exception $e) {
                    $response['type'] = 'error';
                    $message[] = $e->getMessage();
                    $response[]['message'] = $message;
                }
            }
            $formdata['cat_date2'] = isset($formdata['cat_date2']) ? $formdata['cat_date2'] : '';
            if (empty($formdata['cat_date2']) &&  array_item($formdata, 'cat_date2') || (!$cat->check_date($formdata['cat_date2']))) {
                $formdata['cat_date'] = "";
            }
            try {

                if ((trim($formdata["cat_date"]) == "" || trim($formdata["cat_date"]) == 'none')) {
                    $result = FALSE;
                    throw new Exception("חייב לציין מתיי הוקם הברנד ");
                }
            } catch (Exception $e) {
                $response['type'] = 'error';
                $message[] = $e->getMessage();
                $response[]['message'] = $message;
            }
//-----------------------------------------------------------------------------------------------------------------------------
            try {
                if (isset($formdata['dest_cat']) && isset($formdata['insert_cat']) && isset($formdata["new_cat"]) && $formdata['dest_cat'] && is_array($formdata['dest_cat'])
                    && $formdata['insert_cat'] && is_array($formdata['insert_cat'])
                    && $formdata['insert_cat'] != 'none' && !(in_array(11, $formdata['insert_cat']))
                    && !($formdata["new_cat"])
                ) {
                    foreach ($formdata['dest_cat'] as $chk_parent) {
                        if (in_array($chk_parent, $formdata['insert_forumType'])) {
                            $result = FALSE;
                            throw new Exception("אין לקשר לאותו סוג ברנד!");
                        }
                    }
                }
            } catch (Exception $e) {
                $response['type'] = 'error';
                $message[] = $e->getMessage();
                $response[]['message'] = $message;
            }

            try {
                if (isset($formdata["catID"]) && isset($formdata["newcatName"]) && (trim($formdata["catID"]) == "" || trim($formdata["catID"]) == 'none')
                    && trim($formdata["newcatName"]) == ""
                ) {
                    $result = FALSE;
                    throw new Exception("חייב לקשר ללברנד ");
                }
            } catch (Exception $e) {
                $response['type'] = 'error';
                $message[] = $e->getMessage();
                $response[]['message'] = $message;
            }

            try {
                if (isset($formdata["catID"]) && isset($formdata["newcatName"]) && trim($formdata["catID"]) == "11" && trim($formdata["newcatName"]) == "") {
                    $result = FALSE;
                    throw new Exception("ברנד רשומת אב אין לשייך אותה ");
                }
            } catch (Exception $e) {
                $response['type'] = 'error';
                $message[] = $e->getMessage();
                $response[]['message'] = $message;
            }


            if (isset($formdata["catID"]) && isset($formdata["newcatName"]) && trim($formdata["newcatName"] != "none") && trim($formdata["newcatName"] != null)
                && $formdata["catID"] && is_numeric($formdata["catID"])
            ) {
                $name = $db->sql_string($formdata["newcatName"]);
                $sql = "SELECT COUNT(*) FROM categories " .
                    " WHERE catName=$name";
                if ($db->querySingleItem($sql) > 0) {


                    try {
                        if (isset($formdata["catID"]) && isset($formdata["newcatName"]) && trim($formdata["catID"]) == "11" && trim($formdata["newcatName"]) == "") {
                            $result = FALSE;
                            throw new Exception("כבר קיימ ברנד בשם הזה ");

                        }

                    } catch (Exception $e) {
                        $response['type'] = 'error';
                        $message[] = $e->getMessage();
                        $response[]['message'] = $message;
                    }

                } elseif (isset($formdata["catID"]) && array_item($formdata, 'catID') && $formdata['catID']) {
                    unset($formdata['catID']);
                }
            }


            if (isset($formdata["catID"]) && isset($formdata["newcatName"]) && trim($formdata["newcatName"] != "none")
                && trim($formdata["newcatName"] != null) && (!$formdata["catID"] || $formdata["catID"] == null)
            ) {

                $name = $db->sql_string($formdata["newcatName"]);
                $sql = "SELECT COUNT(*) FROM categories " .
                    " WHERE catName=$name";
                try {
                    if ($db->querySingleItem($sql) > 0) {
                        $result = FALSE;
                        throw new Exception("כבר קיימ ברנד בשם הזה");

                    }

                } catch (Exception $e) {
                    $response['type'] = 'error';
                    $message[] = $e->getMessage();
                    $response[]['message'] = $message;
                }

            }
            if (!isset($formdata["catName"]) && isset($formdata["catID"]) && isset($formdata["newcatName"]) && $formdata['newcatName'] && $formdata['newcatName'] != null
                && array_item($formdata, 'catID') && $formdata['catID']
            ) {
                unset($formdata['catID']);
            }
            if (!$result) {

                $i = 0;
                // unset($response);
                foreach ($message as $row) {
                    $results[] = array('message' => $row, 'type' => 'error');
                    $key = "messageError_$i";
                    $message_name[$key] = $row;
                    $i++;
                }
                $response['message'][] = $message_name;
                print json_encode($response);
                exit;

                unset($response);
                $i = 0;
                $j = 0;
                foreach ($message as $row) {
                    $results[] = array('message' => $row, 'type' => 'error');
                    $key = "messageError_$i";
                    $message_name[$key] = $row;
                    $error_name[$i] = 'error';
                    //if($j==(count($message)-1)){
                    if ($j == (count($message))) {
                        $j -= 1;
                    }
                    $response[$j]['type'] = 'error';
                    $i++;

                    $j++;
                }
                $response['message'][] = $message_name;
                print json_encode($response);
                exit;
            } else {
                return true;
            }
        }
        //--------------------------------------------------------------------------

        function html_footer()
        {
            ?>
            </td>

            </tr>

            </table>


            </body>
            </html>

            <?php
        }
        //--------------------------------------------------------------------

        function conn_cat_pub($publishersIDs, $catID)
        {
            global $db;
            // connect category and pdfision
            foreach ($publishersIDs as $pubID) {
                $sql = "INSERT INTO rel_cat_pub(catID,pubID ) " .
                    "VALUES ($catID,$pubID )";
                //echo $sql; die;
                if (!$db->execute($sql))
                    return FALSE;
            }
            return true;
        }
        //------------------------------------------------------------------------------------------

        function conn_cat_pdf($pdfIDS, $catID)
        {
            global $db;
            // connect category and pdfision
            foreach ($pdfIDS as $pdf) {
                //$sql = "update pdf set dfpID = $dfpID where catID = $catID";
                $sql = "UPDATE pdfs SET  catID = $catID   WHERE pdfID = $pdf";
                //$db->sql_string($pdf);
                //echo $sql; die;
                if (!$db->execute($sql))
                    return FALSE;
            }
            return true;
        }
        //------------------------------------------------------------------------------------------

        function view_pdfs($file)
        {
            global $dbc;
            $valid = false;
            // Get the info:
            $q = 'SELECT * FROM pdfs WHERE tmpName="' . mysqli_real_escape_string($dbc, $_GET['id']) . '"';
            $r = mysqli_query($dbc, $q);
            if (mysqli_num_rows($r) == 1) { // Ok!
                // Fetch the info:
                $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
                // Indicate that the file reference is fine:
                $valid = true;
                // Only display the PDF to a user whose account is active:


                // Send the content information:
                header('Content-type:application/pdf');
                header('Content-Disposition:inline;filename="' . $row['file_name'] . '"');
                $fs = filesize($file);
                header("Content-Length:$fs\n");
                // Send the file:
                readfile($file);
                exit();// End of $_GET['id'] IF.
            }//end num rows

// If something didn't work...
            if (!$valid) {
                $page_title = 'Error!';
                echo '<p class="error">נוצרה טעות בכניסה לדף זה!</p>';
            }
        }
        //-----------------------------------------------------------------

        function config_date(&$formdata)
        {

//            list( $day_date_today,$month_date_today,$year_date_today) = explode('-',$formdata['today']);
//            if (strlen($year_date_today) > 3){
//                $month_date_today = str_pad($month_date_today, 2, "0", STR_PAD_LEFT);
//                $day_date_today= str_pad($day_date_today, 2, "0", STR_PAD_LEFT);
//                $formdata['today']="$day_date_today-$month_date_today-$year_date_today";
//            }else{
//                $month_date_today = str_pad($month_date_today, 2, "0", STR_PAD_LEFT);
//                $day_date_today= str_pad($day_date_today, 2, "0", STR_PAD_LEFT);
//                //to check
//                $formdata['today']="$year_date_today-$month_date_today-$day_date_today";
//            }

            /********************************************************************************************************/
            if (isset($formdata['cat_date'])) {

//                list( $day_date_forum,$month_date_forum,$year_date_forum) = explode('-',$formdata['cat_date']);
//                if (strlen($year_date_forum) > 3){
//                    $forum_date="$day_date_forum-$month_date_forum-$year_date_forum";
//                    $formdata['cat_date']="$day_date_forum-$month_date_forum-$year_date_forum";
//                }else{
//                    $forum_date="$year_date_forum-$month_date_forum-$day_date_forum";
//                    //to check
//                    $formdata['cat_date']="$year_date_forum-$month_date_forum-$day_date_forum";
//                }
//            }
//            if($formdata['multi_year'] && $formdata['multi_month'] &&  $formdata['multi_day'] )  {
//                unset ($_SESSION['multi_year']) ;
//                unset ($_SESSION['multi_month']) ;
//                unset ($_SESSION['multi_day'])  ;
//
//                $i=0;
//                foreach($formdata['multi_month'] as $dt){
//                    $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                    $formdata['multi_month'][$i]=$dt;
//                    $i++;
//                }
//                $i=0;
//                foreach($formdata['multi_day'] as $dt){
//                    $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                    $formdata['multi_day'][$i]=$dt;
//                    $i++;
//                }
////store date in a session
//                $_SESSION['multi_year']=$formdata['multi_year'];
//                $_SESSION['multi_month']=$formdata['multi_month'];
//                $_SESSION['multi_day'] =$formdata['multi_day'];
//            }
//            /***********************************************************************************************/
//            /******************************************************************************************************/
//            if(array_item($formdata,'dynamic_6') || array_item($formdata,'dynamic_6b')  ){
//                if($formdata['multi_year'] && $formdata['multi_month'] &&  $formdata['multi_day'] )  {
//                    unset ($_SESSION['multi_year']) ;
//                    unset ($_SESSION['multi_month']) ;
//                    unset ($_SESSION['multi_day'])  ;
//
//                    $i=0;
//                    foreach($formdata['multi_month'] as $dt){
//                        $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                        $formdata['multi_month'][$i]=$dt;
//                        $i++;
//                    }
//                    $i=0;
//                    foreach($formdata['multi_day'] as $dt){
//                        $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                        $formdata['multi_day'][$i]=$dt;
//                        $i++;
//                    }
////store date in a session
//                    $_SESSION['multi_year']=$formdata['multi_year'];
//                    $_SESSION['multi_month']=$formdata['multi_month'];
//                    $_SESSION['multi_day'] =$formdata['multi_day'];
//                }
//
//                /*************************************************************************************************************/
//                if($formdata['multi_year_appoint'] && $formdata['multi_month_appoint'] &&  $formdata['multi_day_appoint'] )  {
//                    unset ($_SESSION['multi_year_appoint']) ;
//                    unset ($_SESSION['multi_month_appoint']) ;
//                    unset ($_SESSION['multi_day_appoint'])  ;
//
//                    $i=0;
//                    foreach($formdata['multi_month_appoint'] as $dt){
//                        $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                        $formdata['multi_month_appoint'][$i]=$dt;
//                        $i++;
//                    }
//                    $i=0;
//                    foreach($formdata['multi_day_appoint'] as $dt){
//                        $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                        $formdata['multi_day_appoint'][$i]=$dt;
//                        $i++;
//                    }
////store date in a session
//                    $_SESSION['multi_year_appoint']=$formdata['multi_year_appoint'];
//                    $_SESSION['multi_month_appoint']=$formdata['multi_month_appoint'];
//                    $_SESSION['multi_day_appoint'] =$formdata['multi_day_appoint'];
//                }
//                /******************************************************************************************************/
//                if($formdata['multi_year_manager'] && $formdata['multi_month_manager'] &&  $formdata['multi_day_manager'] )  {
//                    unset ($_SESSION['multi_year_manager']) ;
//                    unset ($_SESSION['multi_month_manager']) ;
//                    unset ($_SESSION['multi_day_manager'])  ;
//
//                    $i=0;
//                    foreach($formdata['multi_month_manager'] as $dt){
//                        $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                        $formdata['multi_month_manager'][$i]=$dt;
//                        $i++;
//                    }
//                    $i=0;
//                    foreach($formdata['multi_day_manager'] as $dt){
//                        $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
//                        $formdata['multi_day_manager'][$i]=$dt;
//                        $i++;
//                    }
////store date in a session
//                    $_SESSION['multi_year_manager']=$formdata['multi_year_manager'];
//                    $_SESSION['multi_month_manager']=$formdata['multi_month_manager'];
//                    $_SESSION['multi_day_manager'] =$formdata['multi_day_manager'];
                //               }
            }
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------

        function update_cat1(&$formdata, $formselect)
        {
            global $db;
           ;
            //to check
            if (array_item($formdata, 'catID') && is_numeric($formdata['catID'])) {
                $db->execute("set foreign_key_checks=0");
                $catID = isset($formdata['catID']) ? $formdata['catID'] : '';
                $catName = isset($formdata['catName']) ? $formdata['catName'] : 'no name';
                $catPrefix = isset($formdata['catPrefix']) ? $formdata['catPrefix'] : '';
                $insertID = isset($formdata['insertID']) ? $formdata['insertID'] : '11';

                if (!empty($catID) && is_numeric($catID)) {
                    $sql =  "UPDATE categories SET " .
                            " catName = " . $db->sql_string($catName) . ", " .
                            " parentcatID = " . $db->sql_string($insertID) . " , " .
                            " catPrefix = " . $db->sql_string($catPrefix) . "  " .
                            "WHERE catID =  " . $db->sql_string($catID) . " ";

                    if (!$db->execute($sql)) {
                        $db->execute("set foreign_key_checks=1");
                        return -1;
                    } else {
                        $db->execute("set foreign_key_checks=1");
                        return 1;
                    }
                }
                return $formdata;
            }
            return false;
        }
        //--------------------------------------------------------------------------
        function delete_cat($deleteID, $formdata = '')
        {
            $cat = new category();
            $cat->del_cat($deleteID);
//	$frm->print_forum_paging();
            show_list($formdata);
        }

        function del_cat($deleteID)
        {
            global $db;
            $sql = "SELECT COUNT(*) FROM categories WHERE catID=$deleteID";
            if ($db->querySingleItem($sql) == 1) {
                $db->execute("START TRANSACTION");
                $query = "set foreign_key_checks=0";
                $db->execute($query);
                if ($this->delete_cat_sub($deleteID) == -1) {
                    $db->execute("ROLLBACK");
                    $db->execute("set foreign_key_checks=1");
                } else {
                    $db->execute("COMMIT");
                    $db->execute("set foreign_key_checks=1");
                }
            }
        }
        //------------------------------------------------------

        function delete_cat_sub($catID)
        {
            // find subcategories to catID and delete them
            // by calling delete_category recursively
            global $db;
            $sql = "SELECT catID FROM categories " .
                "WHERE parentCatID='$catID'";
            if ($rows = $db->queryObjectArray($sql)) {
                $deletedRows = 0;
                foreach ($rows as $row) {
                    $result = $this->delete_cat_sub($row->catID);
                    if ($result == -1)
                        return -1;
                    else
                        $deletedRows++;
                }
                // if any subcategories could not be deleted,
                // don't delete this category as well
                if ($deletedRows != count($rows))
                    return 0;
            }
            if ($catID == 11) {
                //echo "<br />אי אפשר למחוק שורש הפורומים   .\n";
                show_error_msg("<br />אי אפשר למחוק שורש הפורומים   .\n");
                return 0;
            }
            // delete category
            $sql = "DELETE FROM categories WHERE catID='$catID' LIMIT 1";
            if (($db->execute($sql)))
                return 1;
            else
                return -1;
        }

        function delete1()
        {
            global $db;
            $query = "set foreign_key_checks=0";
            if ($db->execute($query))
                if ($db->execute("delete from  categories where catID=" . $this->getId()))
                    $db->execute("set foreign_key_checks=1");
                else
                    $db->execute("set foreign_key_checks=1");
        }
        //--------------------------------------------------------------------------------------------------

        function getId()
        {
            return $this->catID;
        }
        //--------------------------------------------------------------------------------------------------
        //        // delete a category
        //        // return  1, if category and its subcategories could be deleted
        //        // returns 0, if the category could not be deleted
        //        // return -1 if an error happens
        //        function delete_cat_sub($catID) {
        //            // find subcategories to catID and delete them
        //            // by calling delete_category recursively
        //            global $db;
        //            $sql = "SELECT catID FROM categories " .
        //                "WHERE parentcatID='$catID'";
        //            if($rows = $db->queryObjectArray($sql)) {
        //                $deletedRows = 0;
        //                foreach($rows as $row) {
        //                    $result =$this->delete_cat_sub($row->catID);
        //                    if($result==-1)
        //                        return -1;
        //                    else
        //                        $deletedRows++;
        //                }
        //                // if any subcategories could not be deleted,
        //                // don't delete this category as well
        //                if($deletedRows != count($rows))
        //                    return 0;
        //            }
        //            if($catID==11) {
        //                //echo "<br />אי אפשר למחוק שורש הפורומים   .\n";
        //                show_error_msg("<br />אי אפשר למחוק שורש הברנדים   .\n");
        //                return 0;
        //            }
        ////--------------------------------------------------------------------------------------------------
        //
        //            $sql1 = "SELECT decID  FROM rel_forum_dec WHERE forum_decID=$forum_decID";
        //            if($rows1=$db->queryObjectArray($sql1)  ){
        //                foreach($rows1 as $row){
        //                    $dec_arr[$row->decID]=$row->decID;
        //                }
        //
        //                if($dec_arr && $dec_arr!=null){
        //                    $this->del_decision($dec_arr);
        //                }
        //            }
        //
        //            // delete category
        //            $sql =  "DELETE FROM forum_dec WHERE forum_decID='$forum_decID' LIMIT 1";
        //            $sql1 = "DELETE FROM rel_cat_forum WHERE forum_decID='$forum_decID' LIMIT 1 ";
        //            $sql2 = "DELETE FROM rel_forum_dec WHERE forum_decID='$forum_decID' LIMIT 1 ";
        //            $sql3 = "DELETE FROM rel_user_forum WHERE forum_decID='$forum_decID' ";
        //
        //
        //            //if( ($db->execute($sql) && $db->execute($sql1) && $db->execute($sql2) ) ||
        //            if(   ($db->execute($sql) && $db->execute($sql1) && $db->execute($sql2)&& $db->execute($sql3) ) )
        //                return 1;
        //            else
        //                return -1;
        //
        //        }
        //-----------------------------------------------------------------------------------------------------------------
        // delete a category
        // return  1, if category and its subcategories could be deleted
        // returns 0, if the category could not be deleted
        // return -1 if an error happens

        function check(&$err_msg)
        {
            return 1;
            $err_msg = "";
            if (strlen($this->catName) < 1)
                //$err_msg = "String too short";
                $err_msg = show_error_msg("String too short");


            return $err_msg == "";
        }
        //--------------------------------------------------------------------------------------------------

        function delete_cat_sub_waiting($decID, &$arr_deleted_cat)
        {
            // find subcategories to catID and delete them
            // by calling delete_category recursively
            global $db;
            $sql = "SELECT catID FROM categories " .
                "WHERE parentcatID='$catID'";
            if ($rows = $db->queryObjectArray($sql)) {
                $deletedRows = 0;
                foreach ($rows as $row) {
                    $result = $this->delete_cat_sub($row->decID, $arr_deleted_dec);
                    if ($result == -1)
                        return -1;
                    else
                        $deletedRows++;
                }
                // if any subcategories could not be deleted,
                // don't delete this category as well
                if ($deletedRows != count($rows))
                    return 0;
            }
            // delete catID
            // don't delete catIDs<=11
            if ($catID == 11) {
                echo "<br />אי אפשר למחוק שורש ההחלטות   .\n";
                return 0;
            }
            // delete category
            //$query="SELECT d.decID ,c."
            $sql = "DELETE FROM categories WHERE catID='$catID' LIMIT 1";
            // $sql1 = "DELETE FROM rel_cat_dec WHERE decID='$decID' LIMIT 1 ";
            //$sql2 = "DELETE FROM rel_forum_dec WHERE decID='$decID' LIMIT 1 ";

            // if($db->execute($sql) && $db->execute($sql1) ) {
            if ($db->execute($sql)) {
                $arr_deleted_dec[$catID] = 1;
                return 1;
            } else
                return -1;
        }
//---------------------------------------------------------------------------------------
        function mkdir_r($dirName, $rights=0777){
            $dirs = explode('/', $dirName);
            $dir='';
            foreach ($dirs as $part) {
                $dir.=$part.'/';
                if (!is_dir($dir) && strlen($dir)>0)
                    mkdir($dir, $rights);
            }
        }
        //Function to convert  pdf files to jpg
        //Requires : IMAGEMAGICK
        function convertPDF2JPG($pdf_file,$jpgloc)
        {


         //   $status=exec('convert "'.$pdf_file.'" -colorspace RGB -resize 800 "'.$jpgloc.'"');
          //  $status=exec('convert "'.$pdf_file.'" -colorspace RGB -resize 800 "'.$jpgloc.'"', $output, $return_var);
          //  $status=exec('convert "'.$pdf_file.'" -scale 300x300 "'.$jpgloc.'"');

            $cmd="convert ".$pdf_file." ".$jpgloc;
            $status=exec($cmd);
            $convert_status=$status;
            return $convert_status;
        }
        //Function to read directory
        function readFolderDirectory($dir)
        {

            $listDir = array();
            if($handler = opendir($dir)) {
                while (($sub = readdir($handler)) !== FALSE) {
                    if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                        if(is_file($dir."/".$sub)) {
                            $listDir[] = $sub;
                        }elseif(is_dir($dir."/".$sub)){
                            $listDir[$sub] = cat::ReadFolderDirectory($dir."/".$sub);
                        }
                    }
                }
                closedir($handler);
            }
            return $listDir;

        }

 //------------------------------------------------------------------

        function recurse_copy($src,$dst) {
            global  $dbc;
            $dir = opendir($src);
            @mkdir($dst);
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' ) &&  !(file_exists(PDF_DIR.$file))  ){
                    if ( is_dir($src . '/' . $file) ) {
                        recurse_copy($src . '/' . $file,$dst . '/' . $file);
                    }
                    else {
                        copy($src . '/' . $file,$dst . '/' . $file);
 //--------------------------------------------------------------------


//------------------------------------------------------------------
                    }
                }
            }
            closedir($dir);
        }
 //------------------------------------------------------
//        function recurse_copy($src,$dst) {
//            $dir = opendir($src);
//            @mkdir($dst);
//            while(false !== ( $file = readdir($dir)) ) {
//                if (( $file != '.' ) && ( $file != '..' ) &&  !(file_exists(PDF_DIR.$file))  ){
//                    if ( is_dir($src . '/' . $file) ) {
//                        recurse_copy($src . '/' . $file,$dst . '/' . $file);
//                    }
//                    else {
//                        copy($src . '/' . $file,$dst . '/' . $file);
//                    }
//                }
//            }
//            closedir($dir);
//
//        }
//
//        //------------------------------------------------------
        function loadContent( $url, $timeout = 5 )
        {
            $ctx = stream_context_create( array( 'http' => array( 'timeout' => $timeout ) ) );
            return file_get_contents( $url, 0, $ctx );
        }
//-------------------------------------------------------------------------------------------

        }//end class cat
        ?>
