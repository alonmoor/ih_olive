<?php
require_once("../config/application.php");
require_once(LIB_DIR . '/model/class.handler.php');
require_once(ADMIN_DIR . '/ajax2.php');
require_once HTML_DIR . '/edit_pdf.php';

class Pdfs extends DBObject3
{
    public $id = 0;
    public $insertID;
    public $deleteID;
    public $updateID;
    public $submitbutton;
    public $subcategories;
    public $pagesize = 10;
    public $subcats;
    protected $pdfID;
    protected $file_name;
    protected $brandID;
    protected $newbrandName;

    protected $pdf_level;
    protected $vote_level;
    protected $status;
    protected $editID;
    protected $parentDecID;
    protected $parentDecID1;
    protected $date_created;
    protected $todo_arr;
    protected $done_arr;
    protected $year_date = array();
    protected $month_date = array();
    protected $day_date = array();
    protected $multi_year = array();
    protected $multi_month = array();
    protected $multi_day = array();
    private $table;
    private $fields = array();

    function __construct($id = "")
    {
        parent::__construct('pdfs', 'pdfID', array('pdfName', 'tmpName', 'title', 'description', 'size', 'date_created', 'pdf_date', 'status'), $id);
    }

    function set($insertID = "", $submitbutton = "", $subcategories = "", $deleteID = "", $updateID = "")
    {
        $this->setdeleteID($deleteID);
        $this->setinsertID($insertID);
        $this->setsubmitbutton($submitbutton);
        $this->setsubcategories($subcategories);
        $this->setupdateID($updateID);
    }

    function setFormdata($formdata)
    {
        if (!empty($formdata['pdf_status']))
            $this->status = $formdata['pdf_status'];
        if (!empty($formdata['subcategories']))
            $this->pdfName = $formdata['subcategories'];
        if (!empty($formdata['pdfID']))
            $this->pdfID = $formdata['pdfID'];
        if (!empty($formdata['pdf_level']))
            $this->pdf_level = $formdata['pdf_level'];
        if (!empty($formdata['vote_level']))
            $this->vote_level = $formdata['vote_level'];
        if (!empty($formdata['insertID']))
            $this->parentDecID = $formdata['insertID'];
        if (!empty($formdata['year_date']))
            $this->year_date = $formdata['year_date'];
        if (!empty($formdata['month_date']))
            $this->month_date = $formdata['month_date'];
        if (!empty($formdata['day_date']))
            $this->day_date = $formdata['day_date'];
        if (!empty($formdata['multi_year']) && !empty($formdata['multi_month']) && !empty($formdata['multi_day']))
            if (is_numeric($formdata['multi_year']) && is_numeric($formdata['multi_month']) && is_numeric($formdata['multi_day'])) {
                if (!empty($formdata['multi_year']))
                    $this->year_date = $formdata['multi_year'];
                if (!empty($formdata['multi_month']))
                    $this->month_date = $formdata['multi_month'];
                if (!empty($formdata['multi_day']))
                    $this->day_date = $formdata['multi_day'];
            }
        if (!empty($formdata['category']))
            $this->pdfID = $formdata['category'];
        if (!empty($formdata['forum_pdf']))
            $this->brandID = $formdata['forum_pdf'];
        if (!empty($formdata['newbrand']))
            $this->newbrandName = $formdata['newbrand'];
    }

    function __isset($name)
    {
        return isset($this->formdata [$name]);
    }

    function getDeclaredVariable()
    {
        return $this->pdflaredvar;
    }

    /**********************************************************************************************/
    function link_div()
    {

        echo "<table><tr class='menu4'><td><p><b> ", build_href2("find3.php", "", "", "חזרה לטופס החיפוש", "class=my_pdfLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";


        echo "<td><p><b> ", build_href2("forum_demo12.php", "", "", "חיפוש קטגוריות בדף", "class=my_pdfLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";


        $url = "../admin/forum_demo12_2.php";
        $str = 'onclick=\'openmypage2("' . $url . '"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_pdfLink_root id=popup_frm ';
        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . " </b></p></td>\n";

        echo "<td><p><b> ", build_href2("../admin/database7.php", "", "", "עץ פתוח של החלטות", "class=my_pdfLink_root title='כול ההחלטות במיבנה עץ פתוח'") . " </b></p></td></tr></table>\n";
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


    /**********************************************************************************************/
    function link()
    {
        printf("<p><b><br />%s</b></p>\n",
            build_href2("../admin/find3.php", "", "", "חפש החלטות", "class=href_modal1"));

        $url = "../admin/forum_demo12_2.php";
        $str = 'onclick=\'openmypage2("' . $url . '"); return false;\'   class=href_modal1 id=popup_frm ';
        echo "<p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . ".</b></p>\n";

//		printf("<p><b>%s</b></p>\n",
//		build_href2("../admin/dynamic_5b.php" ,"","", "הוסף/ערוך החלטה", "class=href_modal1"));

        printf("<p><b>%s</b></p>\n",
            build_href2("../admin/database7.php", "", "", "חזרה לצפייה ברשימת החלטות", "class=href_modal1"));


        return true;
    }

    /**************************************************************/
    function link_b()
    {
        printf("<p><b><br />%s</b></p>\n",
            build_href2("../admin/find3.php", "", "", "חפש החלטות", "class=href_modal1"));


        $url = "../admin/forum_demo12_2.php";
        $str = 'onclick=\'openmypage2("' . $url . '"); return false;\'   class=href_modal1 id=popup_frm ';
        echo "<p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . ".</b></p>\n";
//		printf("<p><b>%s</b></p>\n",
//		build_href2("../admin/dynamic_5b.php" ,"","", "הוסף/ערוך החלטה", "class=href_modal1"));

        printf("<p><b>%s</b></p>\n",
            build_href2("../admin/database7.php", "", "", "חזרה אל רשימת החלטות", "class=href_modal1"));


        return true;
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

    function array_item($ar, $key)
    {
        if (is_array($ar) && array_key_exists($key, $ar))
            return ($ar[$key]);
        else
            return FALSE;
    }

    function setName($pdfname)
    {
        $this->pdfname = $pdfname;
    }

    function setSub($sub)
    {
        $this->sub = $sub;
    }

    function getName()
    {
        return $this->pdfname;
    }

    function getSub()
    {
        return $this->sub;
    }

//======================================================================================
    function getSubcats()
    {
        return $this->subcats;
    }

    function setSubcats($subcats)
    {
        $this->subcats = $subcats;
    }

    function setParent($parentpdfID)
    {
        $this->parentpdfID = $parentpdfID;
    }

    function getdeleteID()
    {
        return $this->deleteID;
    }

//-----------------------------------------------------------------
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

    function getsubcategories()
    {
        return $this->subcategories;
    }

    /*****************************************************************************************/

    function setsubcategories($subcategories)
    {
        $this->subcategories = $subcategories;
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
        return $this->parentpdfID;
    }

    function __get($key)
    {
        return $this->fields[$key];
    }

    function __set($key, $value)
    {
        if (array_key_exists($key, $this->fields)) {
            $this->fields[$key] = $value;
            return true;
        }
        return false;
    }

//----------------------------------------------------PUBLISHERS-------------------------------------------------------------------------
    function save_publisher(&$formdata)
    {
        global $db;
//        if ($formdata['dest_publishers'] == 'none' && !array_item($formdata, "dest_publishers")) {
        if (!array_item($formdata, "dest_publishers")) {
            unset ($formdata['dest_publishers']);
            $tmp = "";
        } elseif (($formdata['dest_publishers'] != 'none' && $formdata['dest_publishers'] != null
                && (array_item($formdata, "dest_publishers") && is_array(array_item($formdata, "dest_publishers"))))
            && (!array_item($formdata, "new_forum")
                || ($formdata["new_forum"] == 'none')
                || $formdata["new_forum"] == null)
        ) {
            $tmp = $formdata["dest_publishers"] ? $formdata["dest_publishers"] : $formdata["new_forum"];
            $dest_publishers = $formdata['dest_publishers'];
            foreach ($dest_publishers as $key => $val) {
                if (!is_numeric($val)) {
                    $val = $db->sql_string($val);
                    $staff_test[] = $val;
                } elseif (is_numeric($val)) {
                    $staff_testb[] = $val;
                }
            }
            if (isset($staff_test) && is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                $staff = implode(',', $staff_test);
                $sql2 = "select brandID, brandName from brand where brandName in ($staff)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {
                        $name[$row->brandID] = $row->brandName;
                    }
            } elseif (isset($staff_test) && is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                $staff = implode(',', $staff_test);
                $sql2 = "select brandID, brandName from brand where brandName in ($staff)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {
                        $name[$row->brandID] = $row->brandName;
                    }
                $staffb = implode(',', $staff_testb);
                $sql2 = "select brandID, brandName from brand where brandID in ($staffb)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {
                        $name_b[$row->brandID] = $row->brandName;
                    }
                $name = array_merge($name, $name_b);
                unset($staff_testb);
            }
            foreach ($formdata['dest_publishers'] as $row) {
                $publishersIDs [] = $row;
            }
        }
        return isset($publishersIDs) ? $publishersIDs : false;
    }

//----------------------------------------------------BRANDS-------------------------------------------------------------------------
    function save_brand(&$formdata)
    {
        global $db;
        if (isset($formdata['brand_select'][0]) && $formdata['brand_select'][0]) {
            $id = $formdata['brand_select'][0];
            $sql = "select brandID, brandName from brands where brandID in ($id)";
            if ($rows = $db->queryObjectArray($sql))
                foreach ($rows as $row) {
                    $brandIDS[$row->brandID] = $row->brandName;
                }
            return $brandIDS;
        } else {
            return false;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------

    function print_form_paging($pdfID = "")
    {
        global $db;


//        $sql = "SELECT pdfName, pdfID, parentpdfID FROM categories ORDER BY pdfName";
//        if ($rows = $db->queryObjectArray($sql)) {

        $sql = "SELECT pdfName, pdfID FROM pdfs ORDER BY pdfName";
       // if ($rows = $db->queryArray($sql)) {
            if ($rows = $db->queryObjectArray($sql)) {
            $parent = array();
            foreach ($rows as $row) {

                $subcats[$row->pdfID][] = $row->pdfID;
                $pdfNames[$row->pdfID] = $row->pdfName;
                $parent[$row->pdfID][] = 11;//$row->parentpdfID;
            }
            // build hierarchical list
            echo '<ul class="paginated">';
            echo '<fieldset class="my_pageCount" style="margin-right:-32px;">';

            ?>

            <label for="chart"><strong style="font-weight:bold;color:brown;">גרף סוגי ההחלטות:</strong></label>
            <a href='#' title='גרף סוגי ההחלטות' class="tTip"
               OnClick="return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;"
               ;>
                <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png' onMouseOver="this.src=img.edit[1]"
                     onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'" title='הצג נתונים'/>
            </a>

            <?php

            if (isset($pdfID) && !is_numeric($pdfID)) {
                $this->print_categories_paging($subcats[NULL], $subcats, $pdfNames, $parent);
            } else {
                $this->print_categories_paging_link2($subcats[NULL], $subcats, $pdfNames, $parent, $pdfID);
            }
            echo '</fieldset></ul class="paginated">';

        }
    }

//-----------------------------------------------------------------------------------------


    function print_categories_paging($pdfIDs, $subcats, $pdfNames, $parent)
    {

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
//---------------------------------------------------------
        if ($level) {
            echo '<ul>';
            foreach ($pdfIDs as $pdfID) {
                $url = "../admin/find3.php?pdfID=$pdfID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($pdfID == 11) {
                    printf("<li id=li$pdfID style='color:#23081E;font-weight:bold;color:red;font-size:17px;cursor:pointer;'  onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','red').css('font-size', '20px')\"><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s)</b></li>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]),
                        build_href2("../admin/dynamic_5_demo.php", "mode=insert", "&insertID=$pdfID", "הוסף", "class=href_modal1"),
                        build_href2("dynamic_5_demo.php", "mode=update", "&updateID=$pdfID", "עדכן", "class=href_modal1"));

                } elseif ($parent[$pdfID][0] == '11' && !(array_item($subcats, $pdfID))) {

                    printf("<li id=li$pdfID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]),
                        build_href2("../admin/dynamic_5_demo.php", "mode=insert", "&insertID=$pdfID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5_demo.php", "mode=delete", "&deleteID=$pdfID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5_demo.php", "mode=update", "&updateID=$pdfID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5_demo.php", "mode=read_data", "&editID=$pdfID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } elseif ($parent[$pdfID][0] == '11' && array_item($subcats, $pdfID)) {
                    printf("<li id=li$pdfID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]),
                        build_href2("../admin/dynamic_5_demo.php", "mode=insert", "&insertID=$pdfID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5_demo.php", "mode=delete", "&deleteID=$pdfID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5_demo.php", "mode=update", "&updateID=$pdfID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5_demo.php", "mode=read_data", "&editID=$pdfID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } else {
                    printf("<li id=li$pdfID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]),
                        build_href2("../admin/dynamic_5_demo.php", "mode=insert", "&insertID=$pdfID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5_demo.php", "mode=delete", "&deleteID=$pdfID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5_demo.php", "mode=update", "&updateID=$pdfID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5_demo.php", "mode=read_data", "&editID=$pdfID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                }
                if (array_key_exists($pdfID, $subcats))
                    $this->print_categories_paging($subcats[$pdfID], $subcats, $pdfNames, $parent);
            }
            echo "</li></ul>\n";
//-------------------------------------------------------
        } elseif (!($level)) {
            echo '<ul>';
            foreach ($pdfIDs as $pdfID) {
                $url = "../admin/find3.php?pdfID=$pdfID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($pdfID == 11) {
                    printf("<li id=li$pdfID style='color:#23081E;font-weight:bold;color:red;font-size:20px;cursor:pointer;'  onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','red').css('font-size', '20px')\"><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s</b></li>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]));
                } elseif ($parent[$pdfID][0] == '11' && !(array_item($subcats, $pdfID))) {
                    printf("<li id=li$pdfID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b></li>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]),
                        build_href2("dynamic_5_demo.php", "mode=read_data", "&editID=$pdfID", "מידע מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } elseif ($parent[$pdfID][0] == '11' && array_item($subcats, $pdfID)) {
                    printf("<li id=li$pdfID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]),
                        build_href2("dynamic_5_demo.php", "mode=read_data", "&editID=$pdfID", "מידע מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } else {
                    printf("<li id=li$pdfID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$pdfID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$pdfID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b>\n",
                        htmlspecial_utf8($pdfNames[$pdfID]),
                        build_href2("dynamic_5_demo.php", "mode=read_data", "&editID=$pdfID", "מידע מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                }
                if (array_key_exists($pdfID, $subcats))
                    $this->print_categories_paging($subcats[$pdfID], $subcats, $pdfNames, $parent);
            }
            echo "</li></ul>\n";
        }
    }

//------------------------------------------------------------------------------------------------
//    function insert_pdf(&$formdata = "", &$publishersIDs = "", &$brandIDs = "")
    function insert_pdf(&$formdata = "")
    {
        if(isset($formdata['files']['name'])){
            global $db, $dbc;
// Include the header file:
            $page_title = ' PDF -הוסף קבצי';
// For storing errors:
            $add_pdf_errors = array();
            $formdata['error'] = '';
            /*** maximum filesize allowed in bytes ***/
            $max_file_size = 512000;
            /*** the maximum filesize from php.ini ***/
            $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
//        $upload_max = $ini_max * 1024;
            $upload_max = $ini_max * 2048;
            $file_list = sizeof($formdata['files']['name']);
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (count($file_list) > 0 && !empty($formdata['files']['tmp_name'])) {

                    for ($i = 0; $i < $file_list; $i++) {
                        // Check for a title:
                        if (empty($_POST['title'][$i]) && ($formdata['files']['name'][$i])) {
                            $_POST['title'][$i] = $formdata['files']['name'][$i];
                            $t = mysqli_real_escape_string($dbc, strip_tags($_POST['title'][$i]));
                        } else {
                            $t = mysqli_real_escape_string($dbc, strip_tags($_POST['title'][$i]));
                        }
                        // Check for a description:
                        if (empty($_POST['description'][$i]) && ($formdata['files']['name'][$i])) {
                            $_POST['description'][$i] = $formdata['files']['name'][$i];
                            $d = mysqli_real_escape_string($dbc, strip_tags($_POST['description'][$i]));
                        } else {
                            $d = mysqli_real_escape_string($dbc, strip_tags($_POST['description'][$i]));
                        }
//-----------------------------------------------------------------------------
                        // Check for a PDF:
                        if (is_uploaded_file($formdata['files']['tmp_name'][$i]) && ($formdata['files']['error'][$i] == UPLOAD_ERR_OK)) {
                            //if (is_uploaded_file($_FILES['pdf']['tmp_name'][$i]) && ($_FILES['pdf']['error'][$i] == UPLOAD_ERR_OK)) {
                            $add_pdf_errors = array();
                            $file = $formdata['files'];//$_FILES['pdf'];
                            //$size = ROUND($file['size'][$i] / 1024);
                            $size = ROUND($file['size'][$i] / 2048);
                            // Validate the file size:
                            if ($size > 2048) {
                                $add_pdf_errors['pdf'][$i] = 'הקובץ היה גדול מידיי!';
                            }
                            // Validate the file type:
                            if (($file['type'][$i] != 'application/pdf') && (substr($file['name'][$i], -4) != '.pdf')) {
                                $add_pdf_errors['pdf'][$i] = 'הקובץ הוא לא מסוג-PDF';
                            }
                            // Move the file over, if no problems:
                            if (!array_key_exists('pdf', $add_pdf_errors)) {
                                // Create a tmp_name for the file:
                                $tmp_name = sha1($file['name'][$i] . uniqid('', true));
                                // Move the file to its proper folder but add _tmp, just in case:
                                $dest = PDF_DIR . $tmp_name . '_tmp';
                                if (move_uploaded_file($file['tmp_name'][$i], $dest)) {
                                    // Store the data in the session for later use:
                                    $_SESSION['pdf']['tmp_name'][$i] = $tmp_name;
                                    $_SESSION['pdf']['size'][$i] = $size;
                                    $_SESSION['pdf']['file_name'] [$i] = $file['name'][$i];
                                    // Print a message:
                                    echo '<h4>הקובץ הועלה!</h4>';
                                } else {
                                    trigger_error('אי אפשר להזיז את הקובץ.');
                                    unlink($file['tmp_name']);
                                }
                            } // End of array_key_exists() IF.
                        }else {
                            $add_pdf_errors = $formdata['files']['error'][$i];
                            throw new UploadException($formdata['files']['error'][$i]);
                        }


                        //-----------------------------------------------------------------------------
//                        elseif (!isset($_SESSION['pdf'])) { // No current or previous uploaded file.
////                            switch ($_FILES['pdf']['error'][$i]) {
//                            switch ($formdata['files']['error'][$i]) {
//                                case 1:
//                                case 2:
//                                    $add_pdf_errors['pdf'] = '.הקובץ גדול מידיי';
//                                    break;
//                                case 3:
//                                    $add_pdf_errors['pdf'] = '.הקובץ עלה באופן חלקי';
//                                    break;
//                                case 6:
//                                case 7:
//                                case 8:
//                                    $add_pdf_errors['pdf'] = '.הקובץ לא עלה בגלל בעיות במערכת';
//                                    break;
//                                case 4:
//                                default:
//                                    $add_pdf_errors['pdf'] = '.לא נימצא קובץ';
//                                    break;
//                            } // End of SWITCH.
//                        } // End of $_FILES IF-ELSEIF-ELSE.
                        if (empty($add_pdf_errors)) { // If everything's OK.
                            $newName = isset($formdata['files']['name'][$i]) ? $formdata['files']['name'][$i] : 'stam';
                            $sql = "SELECT COUNT(*) FROM pdfs WHERE pdfName = '$newName'";// . $_FILES['pdf']['name'][$i];
                            $n = $db->querySingleItem($sql);
                            if ($n == 1) {
                                return false;
                            } else {
                                echo "<h1>הוסף PDF חדש</h1>\n";
                                if (isset($_SESSION['pdf']) && $_SESSION['pdf']) {
                                    $fn = mysqli_real_escape_string($dbc, array_shift($_SESSION['pdf']['file_name']));
                                    $tmp_name = mysqli_real_escape_string($dbc, array_shift($_SESSION['pdf']['tmp_name']));
                                    $size = (int)array_shift($_SESSION['pdf']['size']);
                                    $db->execute("START TRANSACTION");
//                                    if ($this->insert_new_pdfs($formdata, $publishersIDs, $brandIDs, $fn, $tmp_name, $size, $newName, $d)) {
                                    if ($this->insert_new_pdfs($formdata, $fn, $tmp_name, $size, $newName, $d)) {
                                        //NSERT INTO pdfs (tmp_name, title, description, file_name, size) VALUES ('$tmp_name', '$t', '$d', '$fn', $size)";
                                    } else {
                                        $db->execute("ROLLBACK");
                                        // trigger_error('The PDF could not be added due to a system error. We apologize for any inconvenience or the file allready upload.');
                                        if (isset($dest)) {
                                            unlink($dest);
                                        }
                                        return FALSE;
                                    }
                                }
                            }
                        } // End of $errors IF.
                        else { // Clear out the session on a GET request:
                            unset($_SESSION['pdf'][$i]);
                        } // End of the submission IF.
                    }//end loop
                    $formdata['count'] = $i;
                }
            }//end if(count)

            else {
                if ((count($_FILES['pdf']['tmp_name']) > 0)) {
                    $add_pdf_errors['pdf'] = '.אנא הזן קובץ';
                }
                if ($_FILES['pdf']['tmp_name'][0] == '') {
                    $add_pdf_errors['pdf'] = 'קובץ לא תקין';
                }
            }
            return true;
        }//end $_SERVER['REQUEST_METHOD'] == 'POST'
        else {
            echo('must upload files!!!');
            return false;
        }
    }//end function

//---------------------------------------------------------------------------------------------------
//---------------------------------iINSERT NEW PDF----------------------------------------------------
    function insert_new_pdfs(&$formdata, &$fn = "", &$tmp_name = "", &$size = "", &$newPdfName = "", &$d = "")
    {
        global $db, $dbc;

//        $dfpAllowed = $formdata['dfp_Allowed'];
//        if ($formdata['dfp_Allowed'] == 1)
//            $dfpAllowed = 'public';
//        elseif ($formdata['dfp_Allowed'] == 2)
//            $dfpAllowed = 'private';
//        elseif ($formdata['dfp_Allowed'] == 3)
//            $dfpAllowed = 'top_secret';
        //$dfpAllowed = $db->sql_string($dfpAllowed);


        //      $status = $formdata['dfp_status'];


        if (!$newPdfName) return 0;
        // test if newpdfName already exists
        $sql = "SELECT COUNT(*) FROM pdfs " .
            "WHERE pdfName='$newPdfName'";
        if ($db->querySingleItem($sql) > 0) {
            echo "כבר קיים PDF בשם הזה";
            return 0;
        }

//        $result = $this->insert_new_pdf($formdata, $publishersIDs, $brandIDs, $fn, $tmp_name, $size, $newPdfName, $d);
        $result = $this->insert_new_pdf($formdata, $fn, $tmp_name, $size, $newPdfName, $d);
        if ($result == -1) {
            echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
            return FALSE;
        } elseif ($result) {
            //$formdata['pdfID'] = $dbc->insert_id;
            $formdata['pdfID'] = $db->insertId();
            $pdfID = $formdata['pdfID'];
//            if (isset($publishersIDs) && count($publishersIDs) > 0) {
//                $this->conn_pub_pdf($publishersIDs, $pdfID);
//                $this->conn_brand_pdf($brandIDs, $pdfID);
//            }
            $db->execute("COMMIT");
            // build_form_pdf_ajx($form);



//            $file = '/home/alon/Desktop/PROJECT/4.4.17/'.$newPdfName;
//            $file_name = explode('.',$newPdfName);
//            $file_name = substr($file_name[0],-9);
//            $newfile = CONVERT_PDF_TO_IMG_DIR.'/'.$file_name;
//            $im = new imagick( '/home/alon/Desktop/PROJECT/4.4.17/'.$newPdfName );
//
//// convert to jpg
//            $im->setImageColorspace(255);
//            $im->setCompression(Imagick::COMPRESSION_JPEG);
//            $im->setCompressionQuality(60);
//            $im->setResolution(300, 300);
//            $im->setImageFormat('jpeg');
////resize
//            $im->resizeImage(290, 375, imagick::FILTER_LANCZOS, 1);
////write image on server
//            $im->writeImage($newfile.'.jpg');
//            $im->clear();
//            $im->destroy();
        }
        return TRUE;
    }
//------------------------------------------------------------------------------------------

//    function insert_new_pdf($formdata, $publishersIDs, $brandIDs, $fn, $tmp_name, $size, $newPdfName, $d)
    function insert_new_pdf($formdata,  $fn, $tmp_name, $size, $newPdfName, $d)
    {
        global $db, $dbc;
        $dest = PDF_DIR . $tmp_name;
        $sql = "INSERT INTO pdfs (tmpName, title,  pdfName, size) VALUES ('$tmp_name', '$newPdfName', '$fn', $size)";
        if ($db->execute($sql)) {
            $original = PDF_DIR . $tmp_name . '_tmp';
            $dest = PDF_DIR . $tmp_name;
            rename($original, $dest);
            // Print a message:
            echo '<h4>היתווסף PDF!</h4>';
            // Clear $_POST:
            $_POST = array();
            // Clear $_FILES:
            $_FILES = array();
            // Clear $file and $_SESSION['pdf']:
            unset($file, $_SESSION['pdf']);
            return 1;
        }
        return -1;
    }
//-------------------------------------------------------------------------------------------------
    function conn_pub_pdf($pubIDs, $pdfID)
    {
        global $db;
        // connect category and pdfision
        foreach ($pubIDs as $pubID) {
            $sql = "INSERT INTO rel_pub_pdf (pdfID,pubID ) " .
                "VALUES ($pdfID,$pubID )";
            //echo $sql; die;
            if (!$db->execute($sql))
                return FALSE;
        }
        return true;
    }

    function conn_brand_pdf($brandIDs, $pdfID)
    {
        global $db;
        // connect category and pdfision
        foreach ($brandIDs as $brandID) {
            //$sql = "update brand set dfpID = $dfpID where brandID = $brandID";
            $sql = "update brands set pdfID=$pdfID where brandID =  " .
                $db->sql_string($brandID);
            //echo $sql; die;
            if (!$db->execute($sql))
                return FALSE;
        }
        return true;
        }
//-----------------------------------------------------------------
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



//---------------------------------------------------------------------------------------
    } //end class
//---------------------------------------------------------------------------------------