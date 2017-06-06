<?php
require_once("../config/application.php");
//require_once(LIB_DIR . '/model/DBobject3.php');
require_once(LIB_DIR . '/model/class.handler.php');






require_once(ADMIN_DIR . '/ajax2.php');

require_once HTML_DIR . '/edit_dec.php';

class Decisions extends DBObject3
{
    public $id = 0;
    public $insertID;
    public $deleteID;
    public $updateID;
    public $submitbutton;
    public $subcategories;
    public $pagesize = 10;
    public $subcats;
    protected $decID;
    protected $decName;
    protected $forum_decID;
    protected $newforumName;
    protected $catID;
    protected $dec_level;
    protected $vote_level;
    protected $status;
    protected $editID;
    protected $parentDecID;
    protected $parentDecID1;
    protected $dec_date;
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
        parent::__construct('decisions', 'decID', array('decName', 'parentDecID', 'parentDecID1', 'status', 'comment', 'dec_date', 'vote_level', 'dec_level', 'dec_allowed'), $id);
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
        if (!empty($formdata['dec_status']))
            $this->status = $formdata['dec_status'];
        if (!empty($formdata['subcategories']))
            $this->decName = $formdata['subcategories'];
        if (!empty($formdata['decID']))
            $this->decID = $formdata['decID'];
        if (!empty($formdata['dec_level']))
            $this->dec_level = $formdata['dec_level'];
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
            $this->catID = $formdata['category'];
        if (!empty($formdata['forum_decision']))
            $this->forum_decID = $formdata['forum_decision'];
        if (!empty($formdata['newforum']))
            $this->newforumName = $formdata['newforum'];
    }

    function __isset($name)
    {
        return isset($this->formdata [$name]);
    }

    function getDeclaredVariable()
    {
        return $this->declaredvar;
    }

    /**********************************************************************************************/
    function link_div()
    {

        echo "<table><tr class='menu4'><td><p><b> ", build_href2("find3.php", "", "", "חזרה לטופס החיפוש", "class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";


        echo "<td><p><b> ", build_href2("forum_demo12.php", "", "", "חיפוש קטגוריות בדף", "class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";


        $url = "../admin/forum_demo12_2.php";
        $str = 'onclick=\'openmypage2("' . $url . '"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון", $str) . " </b></p></td>\n";

        echo "<td><p><b> ", build_href2("../admin/database7.php", "", "", "עץ פתוח של החלטות", "class=my_decLink_root title='כול ההחלטות במיבנה עץ פתוח'") . " </b></p></td></tr></table>\n";
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

    function html_footer(){
        ?>
        </td>

        </tr>

        </table>


        </body>
        </html>

        <?php
    }


    /**************************************************************/

    function array_item($ar, $key)
    {

        if (is_array($ar) && array_key_exists($key, $ar))
            return ($ar[$key]);
        else
            return FALSE;
    }

    /**********************************************************************************************/

    function setName($decname)
    {
        $this->decname = $decname;
    }

    function setSub($sub)
    {
        $this->sub = $sub;
    }

    function getName()
    {
        return $this->decname;
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

    function setParent($parentcatid)
    {
        $this->parentcatid = $parentcatid;
    }

    function getdeleteID()
    {
        return $this->deleteID;
    }


    /**********************************************************************************************/

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
        return $this->parentcatid;
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

    /**********************************************************************************/

    function load($id)
    {
        global $db;
        $db->getMysqli();
        $res = $db->query(
            "SELECT * FROM " . $this->table . " WHERE " .
            $this->table . "_id=?",
            array($id)
        );
        $res->fetchInto($row, DB_FETCHMODE_ASSOC);
        $this->id = $id;
        foreach (array_keys($row) as $key)
            $this->fields[$key] = $row[$key];
    }

    function show_page_links($page, $pagesize, $results, $query)
    {

        if (($page == 1 && $results <= $pagesize) || $results == 0)
            // nothing to do
            return;
        echo "<p>Goto page: ";
        if ($page > 1) {
            for ($i = 1; $i < $page; $i++)
                echo build_href("dynamic_5.php", $query . "&page=$i", $i), " ";
            echo "$page ";
        }
        if ($results > $pagesize) {
            $nextpage = $page + 1;
            echo build_href("dynamic_5.php", $query . "&page=$nextpage", $nextpage);
        }
        echo "</p>\n";
    }

    /**********************************************************************************************/

    function build_usr_frm_date(&$formdata)
    {
        global $db;
        $decID = isset($formdata['decID']) ? $formdata['decID'] : '';
        if (array_item($formdata, 'member_date00')
            && array_item($formdata, 'dest_forums')
            && count($formdata['dest_forums']) > 0
            && !is_numeric($formdata['member'])
        ) {
            $j = 0;
            foreach ($formdata['dest_forums'] as $frmID) {
                $sql = "SELECT userID ,HireDate from rel_user_Decforum WHERE forum_decID=$frmID AND decID=$decID ";
                if ($rows1 = $db->queryObjectArray($sql)) {
                    $i = 0;
                    foreach ($rows1 as $row) {

                        $member_date = "member_date$i$j";
                        list($day_date_the_date, $month_date_the_date, $year_date_the_date) = explode('-', $formdata[$member_date]);
                        if (strlen($year_date_the_date) < 3) {
                            $formdata[$member_date] = "$year_date_the_date-$month_date_the_date-$day_date_the_date";
                        } else {
                            $formdata[$member_date] = "$day_date_the_date-$month_date_the_date-$year_date_the_date";
                        }
                        $rows['full_date'][$j][$i] = $formdata[$member_date];

                        $i++;
                    }
                }
                $j++;
            }

        }//end if
        $rows = isset($rows['full_date']) ? $rows['full_date'] : '';
        return $rows;
    }

    /**********************************************************************************************/

    function build_usr_frm_date2(&$formdata)
    {
        global $db;
        $decID = $formdata['decID'];
        if (array_item($formdata, "dest_forums$decID") && count($formdata["dest_forums$decID"]) > 0) {

            $j = 0;
            $i = 0;
            foreach ($formdata["dest_forums$decID"] as $frmID) {
                $sql = "SELECT userID ,HireDate from rel_user_Decforum WHERE forum_decID=$frmID AND decID=$decID ";
                if ($rows1 = $db->queryObjectArray($sql)) {
                    foreach ($rows1 as $row) {
                        $userID = $row->userID;
                        $member_date = "member_date$frmID$userID";
                        $HireDate = $row->HireDate;
                        if(isset( $formdata[$member_date]))
                        list($day_date_the_date, $month_date_the_date, $year_date_the_date) = explode('-', $formdata[$member_date]);
                        if (isset($year_date_the_date) && isset($month_date_the_date) && isset($day_date_the_date) && strlen($year_date_the_date) > 3) {
                            $formdata[$member_date] = "$year_date_the_date-$month_date_the_date-$day_date_the_date";
                        } else {
                            if (isset($year_date_the_date) && isset($month_date_the_date) && isset($day_date_the_date))
                            $formdata[$member_date] = "$day_date_the_date-$month_date_the_date-$year_date_the_date";
                        }
                        if(isset($formdata[$member_date]) ) {
                            $HireDate2 = $formdata[$member_date];
                            $rows['full_date'][$i] = $formdata[$member_date];
                            if ($formdata[$member_date] != $row->HireDate) {
                                $HireDate2 = $db->sql_string($HireDate2);
                                $sql = "UPDATE rel_user_Decforum set HireDate=$HireDate2 WHERE userID=$userID AND decID=$decID AND forum_decID=$frmID ";
                                if (!$db->execute($sql)) {
                                    return FALSE;
                                }
                            }
                        }
                        $i++;
                    }//end first
                }
                $j++;
            }

        }//end if
        $rows = !empty($rows['full_date']) ? $rows['full_date'] : '';
        return $rows;
    }
    /*******************************************************************************/
    //show_page_links($page, $pagesize, sizeof($rows), $query);
    // show links to previos/next page
    //===============================================
    // $page     .. current page no.
    // $pagesize .. max. no. of items per page

    function config_date(&$formdata)
    {
        //if($formdata['multi_year'] && $formdata['multi_month'] &&  $formdata['multi_day'] )  {
        if (array_item($formdata, 'multi_year') && is_numeric($formdata['multi_year'][0])
            && (array_item($formdata, 'multi_month') && is_numeric($formdata['multi_year'][0]))
            && (array_item($formdata, 'multi_day') && is_numeric($formdata['multi_day'][0]))
        ) {
            unset ($_SESSION['multi_year']);
            unset ($_SESSION['multi_month']);
            unset ($_SESSION['multi_day']);

            $i = 0;
            foreach ($formdata['multi_month'] as $dt) {
                $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
                $formdata['multi_month'][$i] = $dt;
                $i++;
            }
            $i = 0;
            foreach ($formdata['multi_day'] as $dt) {
                $dt = str_pad($dt, 2, "0", STR_PAD_LEFT);
                $formdata['multi_day'][$i] = $dt;
                $i++;
            }
//store date in a session
            $_SESSION['multi_year'] = $formdata['multi_year'];
            $_SESSION['multi_month'] = $formdata['multi_month'];
            $_SESSION['multi_day'] = $formdata['multi_day'];
        }
    }                        // $results  .. no. of search results

    /************************************************************************************************/

    function print_form()
    {
        global $db;
        echo "<h2>בחר החלטה</h2>\n";
        echo "<p>לחץ להוסיף/למחוק/לעדכן  או לראות נתוני ההחלטה.</p>\n";

        // query for all categories
        $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName";
        $rows = $db->queryObjectArray($sql);
        // build two arrays:
        //   subcats[catID] contains an array with all sub-catIDs
        //   catNames[catID] contains the catName for catID
        foreach ($rows as $row) {
            $subcats[$row->parentDecID][] = $row->decID;
            $catNames[$row->decID] = $row->decName;
        }
        // build hierarchical list
        $this->print_categories($subcats[NULL], $subcats, $catNames);

        // link to input and search forms
        printf("<p><br />%s<br />%s<br /></p>\n",
            build_href("../admin/dynamic_5.php", "", "הוסף החלטה חדשה"),
            build_href("../admin/find3.php", "", "חפש החלטות"));
    }

    /************************************************************************************************/

    function print_categories($catIDs, $subcats, $catNames)
    {
        echo "<ul>";
        foreach ($catIDs as $catID) {
            if ($catID == 11) {
                printf("<li><b>%s (%s, %s)</b></li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href1("../admin/dynamic_5.php", "mode=insert", "&insertID=$catID", "הוסף"),
                    build_href1("dec_edit.php", "mode=update", "&updateID=$catID", "עדכן"));
            } else {
                printf("<li><b>%s (%s, %s, %s, %s)</b></li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href1("dynamic_5.php", "mode=insert", "&insertID=$catID", "הוסף"),
                    build_href1("dynamic_5.php", "mode=delete", "&deleteID=$catID", "מחק"),
                    build_href1("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן"),
                    build_href("find3.php", "decID=$catID", "הראה נתונים"));
            }
            if (array_key_exists($catID, $subcats))
                $this->print_categories($subcats[$catID], $subcats, $catNames);
        }
        echo "</ul>\n";
    }

    /**********************************************************************************************/

    function print_form_0($page, $decID, $i = 0)
    {
        global $db;
        $page = $_GET['page'];
        $sql = "SELECT decName, decID, parentDecID,parentDecID1 FROM decisions ORDER BY decName";
        $rows = $db->queryObjectArray($sql);
        // build two arrays:
        //   subcats[catID] contains an array with all sub-catIDs
        //   catNames[catID] contains the catName for catID
        foreach ($rows as $row) {
            $subcats[$row->parentDecID][] = $row->decID;
            $decNames[$row->decID] = $row->decName;
        }
        // build hierarchical list
        //$pagedResults = new Paginated($subcats, 10, $page);
        $this->print_decisions_0($subcats[NULL], $subcats, $decNames, $decID, $i);

        //$pagedResults = new Paginated($subcats, 10, $page);
//		$pagedResults->setLayout(new DoubleBarLayout());
//		 echo $pagedResults->fetchPagedNavigation();
    }

    /***********************************************************************************************/

    function print_decisions_0($decIDs, $subcats, $decNames, $decID, $i)
    {

        echo "<ul>";
        foreach ($decIDs as $decID) {
            if ($decID == 11) {
                printf("<li><b>%s (%s, %s)</b></li>\n",
                    htmlspecial_utf8($decNames[$decID]),
                    build_href1("dynamic_5.php", "mode=insert", "&insertID=$decID", "הוסף"),
                    build_href1("dynamic_5.php", "mode=update", "&updateID=$decID", "עדכן"));

            } else {
                $pagedResults = new Paginated($subcats, 10, $page);
                //  $row=$pagedResults->fetchPagedRow($decID);
                //while($row = $pagedResults->fetchPagedRow($decID)) {	//when $row is false loop terminates


                printf("<li> %s (%s,%s, %s,%s )</li>\n",

                    htmlspecial_utf8($decNames[$decID]),

                    build_href1("dynamic_5.php", "mode=insert", "&insertID=$decID", "הוסף"),
                    build_href1("dynamic_5.php", "mode=delete", "&deleteID=$decID", "מחק"),
                    build_href1("dynamic_5.php", "mode=update", "&updateID=$decID", "עדכן"),
                    build_href1("dynamic_5.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"));


                // build_href("find3.php", "decID=$decID", "הראה החלטות"));
                if (array_key_exists($decID, $subcats)) {


                    $this->print_decisions_0($subcats[$decID], $subcats, $decNames, $decID, $i);
                    $pagedResults->setLayout(new DoubleBarLayout());
                    echo $pagedResults->fetchPagedNavigation();
                    //$this->print_decisions_0($row);
                    //$this->print_decisions($subcats[$decID], $subcats, $decNames);

                }

            }
            echo "</ul>\n";

        }
    }

    /**********************************************************************************************/
//if(!insertID&&!deleteID)
// otherwise show hierarchical list of all categories

    function print_form2($decID1)
    {
        global $db;


        // query for all categories
        $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName";
        $rows = $db->queryObjectArray($sql);
        // build two arrays:
        //   subcats[catID] contains an array with all sub-catIDs
        //   catNames[catID] contains the catName for catID
        foreach ($rows as $row) {
            $subcats[$row->parentDecID][] = $row->decID;
            $decNames[$row->decID] = $row->decName;
        }
        // build hierarchical list
        $this->print_decisions1($subcats[NULL], $subcats, $decNames, $decID1);

        // link to input and search forms
        printf("<p><br />%s</p>\n",
            //  printf("<p><br />%s<br />%s</p>\n",
            //build_href1("dynamic_5.php", "", "הוסף החלטה חדשה"),
            build_href("find3.php", "", "חפש החלטות"));
//			$insertID=$_GET['insertID'];
//			return $insertID;

    }



    /*******************************************************************************/
    // searches for $rows[n]->parentCatID=$parentCatID
// and prints $rows[n]->catName; then calls itself
// recursively

    function print_decisions1($decIDs, $subcats, $decNames, $decID1)
    {
        echo "<ul>";


        foreach ($decIDs as $decID) {
            printf("<li><b>%s (%s, %s,%s,%s,%s,%s )</b></li>\n",
                htmlspecial_utf8($decNames[$decID]),
                build_href1("dynamic_5.php", "mode=insert", "&insertID=$decID", "הוסף"),
                build_href1("dynamic_5.php", "mode=delete", "&deleteID=$decID", "מחק"),
                build_href1("dynamic_5.php", "mode=update", "&updateID=$decID", "עדכן"),
                build_href1("dynamic_5.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"),
                build_href1("find3.php", "mode=search_dec", "&decID=$decID", "צפה בנתונים"),
                build_href1("dynamic_5.php", "mode=link_second", "&insertID=$decID&decID=$decID1", "קשר אליי"));


            if (array_key_exists($decID, $subcats))
                $this->print_decisions1($subcats[$decID], $subcats, $decNames, $decID1);
        }
        echo "</ul>\n";
    }


//********************************************************************************************************

    function print_form_paging($decID = "")
    {
        global $db;


        $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName";
        if ($rows = $db->queryObjectArray($sql)) {


            $parent = array();
            foreach ($rows as $row) {
                $subcats[$row->parentDecID][] = $row->decID;
                $catNames[$row->decID] = $row->decName;
                $parent[$row->decID][] = $row->parentDecID;
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

            if (!is_numeric($decID)) {
                $this->print_categories_paging($subcats[NULL], $subcats, $catNames, $parent);
            } else {
                $this->print_categories_paging_link2($subcats[NULL], $subcats, $catNames, $parent, $decID);
            }
            echo '</fieldset></ul class="paginated">';

        }
    }

    /***********************************************************************************/

    function print_categories_paging($catIDs, $subcats, $catNames, $parent)
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
        /*********************************************/

        if ($level) {


            echo '<ul>';
            foreach ($catIDs as $catID) {
                $url = "../admin/find3.php?decID=$catID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($catID == 11) {
                    printf("<li id=li$catID style='color:#23081E;font-weight:bold;color:red;font-size:17px;cursor:pointer;'  onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '20px')\"><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s)</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/dynamic_5.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"));

                } elseif ($parent[$catID][0] == '11' && !(array_item($subcats, $catID))) {

                    printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/dynamic_5.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } elseif ($parent[$catID][0] == '11' && array_item($subcats, $catID)) {
                    printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/dynamic_5.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } else {
                    printf("<li id=li$catID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/dynamic_5.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                }

                if (array_key_exists($catID, $subcats))
                    $this->print_categories_paging($subcats[$catID], $subcats, $catNames, $parent);
            }
            echo "</li></ul>\n";

/////////////////////////////
        } elseif (!($level)) {////////
///////////////////////////


            echo '<ul>';
            foreach ($catIDs as $catID) {
                $url = "../admin/find3.php?decID=$catID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($catID == 11) {
                    printf("<li id=li$catID style='color:#23081E;font-weight:bold;color:red;font-size:20px;cursor:pointer;'  onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '20px')\"><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]));

                } elseif ($parent[$catID][0] == '11' && !(array_item($subcats, $catID))) {

                    printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "מידע מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } elseif ($parent[$catID][0] == '11' && array_item($subcats, $catID)) {
                    printf("<li id=li$catID class='li_page' style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "מידע מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } else {
                    printf("<li id=li$catID  style='color:#23081E;font-weight:bold;cursor:pointer;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '20px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "מידע מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                }

                if (array_key_exists($catID, $subcats))
                    $this->print_categories_paging($subcats[$catID], $subcats, $catNames, $parent);
            }
            echo "</li></ul>\n";


        }


//////////////////////
    }


    /**************************************************************************/

    function print_categories_paging_link2($catIDs, $subcats, $catNames, $parent, $decID)
    {
        echo '<ul>';
        foreach ($catIDs as $catID) {
            $url = "../admin/find3.php?decID=$catID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
            if ($catID == 11) {
                printf("<li style='font-weight :bold;'><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s)</b></li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("dynamic_5.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1", "class=href_modal1"));

            } elseif ($parent[$catID][0] == '11' && !(array_item($subcats, $catID))) {

                printf("<li class='li_page' style='font-weight :bold;'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("dynamic_5.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("../admin/dynamic_5.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                    build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                    build_href5("", "", "הראה נתונים", $str));

            } elseif ($parent[$catID][0] == '11' && array_item($subcats, $catID)) {
                printf("<li class='li_page' style='font-weight :bold;'><b>%s (%s, %s, %s,%s,%s)</b>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("dynamic_5.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("../admin/dynamic_5.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                    build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                    build_href5("", "", "הראה נתונים", $str));
            } else {
                printf("<li style='font-weight :bold;'><b>%s (%s, %s, %s,%s,%s)</b>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("dynamic_5.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("../admin/dynamic_5.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                    build_href2("dynamic_5.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                    build_href5("", "", "הראה נתונים", $str));
            }


            if (array_key_exists($catID, $subcats))
                $this->print_categories_paging_link2($subcats[$catID], $subcats, $catNames, $parent, $decID);
        }
        echo "</li></ul>\n";
    }



    /*******************************************************************************/
//===================================================================================

    function print_form_dec($decID)
    {
        global $db;
        echo "<h2>בחר החלטה</h2>\n";
        echo "<p>לחץ להוסיף/למחוק/לעדכן  או לראות החלטה.</p>\n";

        // query for all categories
        $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName";
        $rows = $db->queryObjectArray($sql);

        foreach ($rows as $row) {
            $subcats[$row->parentDecID][] = $row->decID;
            $catNames[$row->decID] = $row->decName;
        }
        // build hierarchical list
        $this->print_decisions($subcats[NULL], $subcats, $catNames);

        // link to input and search forms
        printf("<p><br />%s<br />%s</p>\n",
            build_href("dynamic_5.php", "", "הוסף החלטה חדשה"),
            build_href("find3.php", "", "חפש החלטות"));
    }

    /******************************************************************************/
    /*******************************************************************************/
    // searches for $rows[n]->parentCatID=$parentCatID
// and prints $rows[n]->catName; then calls itself
// recursively

    function print_decisions($decIDs, $subcats, $decNames)
    {
        echo "<ul>";
        foreach ($decIDs as $decID) {
            if ($decID == 11) {
                printf("<li><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s)</b></li>\n",
                    htmlspecial_utf8($decNames[$decID]),
                    build_href1("dynamic_5.php", "mode=insert", "&insertID=$decID", "הוסף"),
                    build_href1("dynamic_5.php", "mode=update", "&updateID=$decID", "עדכן"));
            } else {
                printf("<li><b> %s (%s,%s,%s,%s,%s )</b></li>\n",

                    htmlspecial_utf8($decNames[$decID]),

                    build_href1("dynamic_5.php", "mode=insert", "&insertID=$decID", "הוסף"),
                    build_href1("dynamic_5.php", "mode=delete", "&deleteID=$decID", "מחק"),
                    build_href1("dynamic_5.php", "mode=update", "&updateID=$decID", "עדכן"),
                    build_href1("dynamic_5.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"),
                    build_href1("find3.php", "mode=search_dec", "&decID=$decID", "צפה בנתונים"));


                // build_href("find3.php", "decID=$decID", "הראה החלטות"));
                if (array_key_exists($decID, $subcats)) {

                    $this->print_decisions($subcats[$decID], $subcats, $decNames);


                }
            }
        }
        echo "</ul>\n";
    }// function end ///
/////////////////////

    /**************************************************************************/

    function print_decision_entry_form1($updateID, $mode = '')
    {
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
        echo '<fieldset class="my_pageCount" >';

        ?>
        <!--
    <label for="chart"><strong style="font-weight:bold;color:brown;">גרף סוגי ההחלטות:</strong></label>
     <a href='#' title='גרף סוגי ההחלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '" . ROOT_WWW . "/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  >
            <img src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />
     </a>
   -->
        <?php

        if ($level) {

            // query for all categories
            $sql = "SELECT decName, decID, parentDecID " .
                "FROM decisions ORDER BY decName";
            $rows = $db->queryObjectArray($sql);

            // build assoc. arrays for name, parent and subcats
            foreach ($rows as $row) {
                $decNames[$row->decID] = $row->decName;
                $parents[$row->decID] = $row->parentDecID;
                $subcats[$row->parentDecID][] = $row->decID;
            }


            // build list of all parents for $updateID
            $decID = $updateID;
            while (isset($parents[$decID]) && $parents[$decID] != NULL) {
                $decID = $parents[$decID];
                $parentList[] = $decID;
            }


////////////////////////////////////////////////////////////////////////////////////////

            if (isset($parentList)) {
                for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                    $url = "../admin/find3.php?decID=$parentList[$i]";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    if ($parentList[$i] == '11') {
                        printf("<ul><li style='font-weight :bold;'><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b> </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("dynamic_5.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"));
                    } else {

                        printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("dynamic_5.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("dynamic_5.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"),
                            build_href2("dynamic_5.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));


                    }

                }
            }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // display choosen forum  * BOLD *
            if ($insertID == '11') {

                printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"));

            } else {
                $url = "../admin/find3.php?decID=$updateID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                    htmlspecial_utf8(isset($decNames[$updateID]) ? $decNames[$updateID] : null ),
                    build_href2("dynamic_5.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5.php", "mode=update", "&updateID=$updateID", "עדכן"),
                    build_href2("dynamic_5.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


            echo "<ul>";


            $i = 0;
            if (array_key_exists($updateID, $subcats)) {
                while (isset($subcats["$updateID"])  && $subcats[$updateID]) {
                    foreach ($subcats[$updateID] as $decID) {
                        $url = "find3.php?decID=$decID";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$decID]),
                            build_href2("dynamic_5.php", "mode=insert", "&insertID=$decID", "הוסף"),
                            build_href2("dynamic_5.php", "mode=delete", "&deleteID=$decID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("dynamic_5.php", "mode=update", "&updateID=$decID", "עדכן"),
                            build_href2("dynamic_5.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));

                    }
                    echo "<ul>";

                    $updateID = $decID;
                    $i++;
                }
                // close hierarchical category list
                echo str_repeat("</ul>", $i + 1), "\n";
            } else {

                echo "(עדיין אין תת-החלטות.)";
            }


            echo "</ul>\n";

            if (isset($parentList))
                echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";


////////////////////////
        } elseif (!($level)) {////
//////////////////////

            // query for all categories
            $sql = "SELECT decName, decID, parentDecID " .
                "FROM decisions ORDER BY decName";
            $rows = $db->queryObjectArray($sql);

            // build assoc. arrays for name, parent and subcats
            foreach ($rows as $row) {
                $decNames[$row->decID] = $row->decName;
                $parents[$row->decID] = $row->parentDecID;
                $subcats[$row->parentDecID][] = $row->decID;
            }


            // build list of all parents for $updateID
            $decID = $updateID;
            while ($parents[$decID] != NULL) {
                $decID = $parents[$decID];
                $parentList[] = $decID;
            }


////////////////////////////////////////////////////////////////////////////////////////

            if (isset($parentList)) {
                for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                    $url = "../admin/find3.php?decID=$parentList[$i]";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    if ($parentList[$i] == '11') {
                        printf("<ul><li style='font-weight :bold;'><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s </b> </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]));
                    } else {

                        printf("<ul><li style='font-weight :bold;'> %s (%s, %s) </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5.php", "mode=read_data", "&editID=$parentList[$i]", "מידע  מורחב"),
                            build_href5("", "", "הראה נתונים", $str));

                    }

                }
            }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // display choosen forum  * BOLD *
            if ($insertID == '11') {

                printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"));

            } else {
                $url = "../admin/find3.php?decID=$updateID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5.php", "mode=read_data", "&editID=$updateID", "מידע  מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


            echo "<ul>";


            $i = 0;
            if (array_key_exists($updateID, $subcats)) {
                while ($subcats[$updateID]) {
                    foreach ($subcats[$updateID] as $decID) {
                        $url = "find3.php?decID=$decID";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<li style='font-weight :bold;'> %s (%s, %s) </li>\n",
                            htmlspecial_utf8($decNames[$decID]),
                            build_href2("dynamic_5.php", "mode=read_data", "&editID=$decID", "מידע  מורחב"),
                            build_href5("", "", "הראה נתונים", $str));

                    }
                    echo "<ul>";

                    $updateID = $decID;
                    $i++;
                }
                // close hierarchical category list
                echo str_repeat("</ul>", $i + 1), "\n";
            } else {

                echo "(עדיין אין תת-החלטות.)";
            }


            echo "</ul>\n";

            if (isset($parentList))
                echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";


        }//end else
        /*****************************************************************************************************/
        echo '</fieldset>';
    }
    /*******************************************************************************/


    /**************************************************************************/
//for mult_dec_ajx.php
    /*******************************************************************************/

    function print_decision_entry_form1_a($updateID, $mode = '')
    {
        $insertID = $updateID;
        global $db;
        //echo '<div id="my_entry">';
        ?><div id="my_entry_2<?PHP echo $updateID; ?>"><?php
        // query for all categories
        $sql = "SELECT decName, decID, parentDecID " .
            "FROM decisions ORDER BY decName";
        $rows = $db->queryObjectArray($sql);

        // build assoc. arrays for name, parent and subcats
        foreach ($rows as $row) {
            $decNames[$row->decID] = $row->decName;
            $parents[$row->decID] = $row->parentDecID;
            $subcats[$row->parentDecID][] = $row->decID;
        }


        // build list of all parents for $updateID
        $decID = $updateID;
        while ($parents[$decID] != NULL) {
            $decID = $parents[$decID];
            $parentList[] = $decID;
        }


////////////////////////////////////////////////////////////////////////////////////////

        if (isset($parentList)) {
            for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                $url = "../admin/find3.php?decID=$parentList[$i]";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($parentList[$i] == '11') {
                    printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s )</b> </li>\n",
                        htmlspecial_utf8($decNames[$parentList[$i]]),
                        build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"));
                } else {

                    printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                        htmlspecial_utf8($decNames[$parentList[$i]]),
                        build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                        build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                        build_href5("", "", "הראה נתונים", $str));


                }

            }
        }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // display choosen forum  * BOLD *
        if ($insertID == '11') {

            printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
                htmlspecial_utf8($decNames[$updateID]),
                build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"));

        } else {

            $url = "../admin/find3.php?decID=$updateID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
            printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                htmlspecial_utf8($decNames[$updateID]),
                build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"),
                build_href2("dynamic_5b.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים", $str));
        }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


        echo "<ul>";


        $i = 0;
        if (array_key_exists($updateID, $subcats)) {
            while ($subcats[$updateID]) {
                foreach ($subcats[$updateID] as $decID) {
                    $url = "find3.php?decID=$decID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                        htmlspecial_utf8($decNames[$decID]),
                        build_href2("dynamic_5b.php", "mode=insert", "&insertID=$decID", "הוסף"),
                        build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$decID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$decID", "עדכן"),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"),
                        build_href5("", "", "הראה נתונים", $str));

                }
                echo "<ul>";

                $updateID = $decID;
                $i++;
            }
            // close hierarchical category list
            echo str_repeat("</ul>", $i + 1), "\n";
        } else {

            echo "(עדיין אין תת-החלטות.)";
        }


        echo "</ul>\n";

        if (isset($parentList))
            echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";

        /*****************************************************************************************************/
        echo '</div>';
        /*****************************************************************************************************/
    }

    /******************************************************************************/
    /*******************************************************************************/
    // searches for $rows[n]->parentCatID=$parentCatID
// and prints $rows[n]->catName; then calls itself
// recursively
// <P ID="boldpara1" onmouseover="javascript:document.all.boldpara1.style.fontWeight= 'bold'" onmouseout="javascript:document.all.boldpara1.style.fontWeight='normal'" >
//This text will turn bold when the mouse cursor is placed on it.
//</P>

function print_decision_entry_form1_cX($updateID, $mode = '')
{
    /******************************************************************************************************/
    global $db;
    $insertID = $updateID;

    ?>
    <div id="my_entry_top<?PHP echo $updateID; ?>"><?php


    $sql = "SELECT decName, decID, parentDecID " .
        "FROM decisions ORDER BY decName";
    if ($rows = $db->queryObjectArray($sql)) {

        // build assoc. arrays for name, parent and subcats
        foreach ($rows as $row) {
            $decNames[$row->decID] = $row->decName;
            $parents[$row->decID] = $row->parentDecID;
            $subcats[$row->parentDecID][] = $row->decID;
        }


        // build list of all parents for $updateID
        $decID = $updateID;
        while ($parents[$decID] != NULL) {
            $decID = $parents[$decID];
            $parentList[] = $decID;
        }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////


        if (isset($parentList)) {
            for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                $url = "../admin/find3.php?decID=$parentList[$i]";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                if ($parentList[$i] == '11') {
                    printf("<ul><li style='font-weight :bold;'><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b> </li>\n",
                        htmlspecial_utf8($decNames[$parentList[$i]]),
                        build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"));

                } else {

                    $url = "../admin/find3.php?decID=$updateID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                        htmlspecial_utf8($decNames[$parentList[$i]]),
                        build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                        build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                        build_href5("", "", "הראה נתונים", $str));


                }

            }
        }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // display choosen forum  * BOLD *
        //display the last on
        if ($insertID == '11') {
            printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
                htmlspecial_utf8($decNames[$updateID]),
                build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"));

        } else {
            $url = "../admin/find3.php?decID=$updateID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
            printf("<ul><li ID='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                htmlspecial_utf8($decNames[$updateID]),
                build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"),
                build_href2("dynamic_5b.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                build_href5("", "", "הראה נתונים", $str));
        }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

        echo "<ul>";


        $i = 0;
        if (array_key_exists($updateID, $subcats)) {
            while ($subcats[$updateID]) {
                foreach ($subcats[$updateID] as $decID) {
                    $url = "find3.php?decID=$decID";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                        htmlspecial_utf8($decNames[$decID]),
                        build_href2("dynamic_5b.php", "mode=insert", "&insertID=$decID", "הוסף"),
                        build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$decID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$decID", "עדכן"),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"),
                        build_href5("", "", "הראה נתונים", $str));
                }

                echo "<ul>";
                $updateID = $decID;
                $i++;
            }
            // close hierarchical category list
            echo str_repeat("</ul>", $i + 1), "\n";
        } else {

            echo "(עדיין אין תת-החלטות.)";
        }


        echo "</ul>\n";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // close hierarchical category list
        if (isset($parentList))
            echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
        /****************************************************************************************/


        echo '</div>';


    }

}//end func//
////////////
    /**************************************************************************/


    /**************************************************************************/

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
    /*******************************************************************************/


    /*******************************************************************************/

    function read_decision_data($decID)
    {

        global $db;


        $sql = "SELECT *  FROM   decisions WHERE decID=$decID";
        $rows = $db->queryObjectArray($sql);


        if (isset($rows[0]->dec_date) && $rows[0]->dec_date) {

            $rows[0]->dec_date = substr($rows[0]->dec_date, 0, 10);


            list($year_date, $month_date, $day_date) = explode('-', $rows[0]->dec_date);
            if (strlen($year_date > 3))
                $rows[0]->dec_date = "$day_date-$month_date-$year_date";
            else
                $rows[0]->dec_date = "$year_date-$month_date-$day_date";
        }


        if (isset($rows[0]->dec_allowed) && $rows[0]->dec_allowed == 'public')
            $rows[0]->dec_allowed = '1';
        elseif (isset($rows[0]->dec_allowed) && $rows[0]->dec_allowed == 'private')
            $rows[0]->dec_allowed = '2';
        elseif (isset($rows[0]->dec_allowed) && $rows[0]->dec_allowed == 'top_secret')
            $rows[0]->dec_allowed = '3';


        $day_date = isset($day_date) && !is_null($day_date) ? "'$day_date'" : 'NULL';
        $month_date = isset($month_date) && !is_null($month_date) ? "'$month_date'" : 'NULL';

        $day_date = substr($day_date, 0, 4);
        $day_date = substr($day_date, 1, 2);
        if (isset($month_date['1']) && $month_date['1'] == '1')
            $month_date = substr($month_date, 1, 2);
        else {
            $month_date = substr($month_date, 1, 2);
            $month_date = substr($month_date, 1, 1);
        }
        if (isset($rows) && is_array($rows) && sizeof($rows) == 1) {
            $row = $rows[0];
            $result["decID"] = $row->decID;
            $result["subcategories"] = $row->decName;
            $result["parentDecID"] = $row->parentDecID;
            $result["parentDecID1"] = $row->parentDecID1;
            $result["dec_status"] = $row->status;
            $result["subtitle"] = isset($row->note) ? $row->note : '';
            $result["dec_date"] = $rows[0]->dec_date;
            $result["vote_level"] = $row->vote_level;
            $result["dec_level"] = $row->dec_level;
            $result["dec_Allowed"] = $row->dec_allowed;
            $result['day_date'] = $day_date;
            $result['month_date'] = $month_date;
            $result['year_date'] = $year_date;
            $result["forum_decision"] = "";
            $result["forum_decID"] = "";
            $result["category"] = "";

            //if ($result["decision_forum"])

//			$sql = "SELECT f.forum_decID,f.forum_decName,f.managerID  FROM forum_dec f, rel_forum_dec r " .
//                       "WHERE f.forum_decID = r.forum_decID " .
//                          "AND r.decID = $decID " .
//                         "ORDER BY f.forum_decName";


            $sql = "SELECT f.forum_decID,f.forum_decName,f.managerID,m.userID  FROM forum_dec f
						LEFT JOIN rel_forum_dec  r  ON(f.forum_decID = r.forum_decID)
						LEFT JOIN managers  m  ON(f.managerID = m.managerID)
                         WHERE r.decID = $decID " .
                "ORDER BY f.forum_decName";


            if ($rows = $db->queryObjectArray($sql)) {
                $i = 0;
                foreach ($rows as $row) {

                    $result["dest_forums"][$i] = $row->forum_decID;
                    $result["dest_managers"][$i] = $row->managerID;
                    $result["dest_userIDs"][$i] = $row->userID;
                    $i++;
                }
            }
            /***************************************************************************************/

            $sql = "SELECT c.catID  FROM categories c, rel_cat_dec r
			WHERE c.catID = r.catID
			AND r.decID =$decID ORDER BY c.catName";
            if ($rows = $db->queryObjectArray($sql)) {
                $i = 0;
                foreach ($rows as $row) {
                    if (!empty($result["dest_decisionsType"]) && !$result["dest_decisionsType"][$i]) {
                        $result["dest_decisionsType"][$i] = $row->catID;
                    } else if (!empty($result["dest_decisionsType"])) {
                        $result["dest_decisionsType"][$i] .= ";" . $row->catID;
                    }
                    $i++;
                }

            }
            return $result;
        }
    }




    /****************************************************************************************/
    // searches for $rows[n]->parentCatID=$parentCatID
    // and prints $rows[n]->catName; then calls itself
    // recursively

    function read_decision_data2($decID)
    {

        global $db;
        $sql = "SELECT * FROM   decisions WHERE decID=$decID";
        $rows = $db->queryObjectArray($sql);
        list($year_date, $month_date, $day_date) = explode('-', $rows[0]->dec_date);
        $day_date = is_null($day_date) ? 'NULL' : "'$day_date'";
        $month_date = is_null($day_date) ? 'NULL' : "'$month_date'";

        $day_date = substr($day_date, 0, 4);
        $day_date = substr($day_date, 1, 2);
        if ($month_date[1] == '1')
            $month_date = substr($month_date, 1, 2);
        else {
            $month_date = substr($month_date, 1, 2);
            $month_date = substr($month_date, 1, 1);
        }
        if (is_array($rows) && sizeof($rows) == 1) {
            $row = $rows[0];
            $result["decID"] = $row->decID;
            $result["subcategories"] = $row->decName;
            $result["parentDecID"] = $row->parentDecID;
            $result["parentDecID1"] = $row->parentDecID1;
            $result["dec_status"] = $row->status;

            $result["dec_date"] = substr(($row->dec_date), 10, 6);
            $result["vote_level"] = $row->vote_level;
            $result["dec_level"] = $row->dec_level;
            $result['day_date'] = $day_date;
            $result['month_date'] = $month_date;
            $result['year_date'] = $year_date;

            $result["src_forums"] = "";
            $result["src_forums$decID"] = "";
            $result["src_decisionsType"] = "";
            $result["src_decisionsType$decID"] = "";


//		    $result["dest_forums"]="";
//			$result["dest_forums$decID"]="";
//			$result["dest_decisionsType"]="";
//			$result["dest_decisionsType$decID"]="";

            /*******************************************DEST_FORUM$****************************************************************/
            if ($_SERVER['SCRIPT_NAME'] == ROOT_WWW . "/admin/dynamic_5cdemo.php" ||
                $_SERVER['SCRIPT_NAME'] == ROOT_WWW . "/admin/dynamic_5b.php"
            ) {
                $sql = "SELECT f.forum_decName,f.forum_decID FROM forum_dec f, rel_forum_dec  r " .
                    "WHERE f.forum_decID = r.forum_decID " .
                    "AND r.decID = $decID " .
                    "ORDER BY f.forum_decName";
                if ($rows = $db->queryObjectArray($sql)) {

                    foreach ($rows as $row) {
                        if (!$result["src_forums$decID"])
                            $result["src_forums$decID"] = $row->forum_decID;
                        else
                            $result["src_forums$decID"] .= ";" . $row->forum_decID;

                    }


                }


                /********************************************DEST_DECISION_TYPE$*************************************************************************/


                $sql = "SELECT c.catID  FROM categories c, rel_cat_dec r
			WHERE c.catID = r.catID
			AND r.decID =$decID ORDER BY c.catName";
                if ($rows = $db->queryObjectArray($sql)) {
                    foreach ($rows as $row) {
                        if (!$result["src_decisionsType$decID"]) {
                            $result["src_decisionsType$decID"] = $row->catID;
                        } else {
                            $result["src_decisionsType$decID"] .= ";" . $row->catID;
                        }
                    }

                }
            }//end if script
            /*******************************************DEST_FORUM****************************************************************/

            if ($_SERVER['SCRIPT_NAME'] == ROOT_WWW . "/admin/dynamic_5.php") {
                $ssql1 = "SELECT f.forum_decName,f.forum_decID FROM forum_dec f  
INNER JOIN rel_forum_dec r
 ON f.forum_decID = r.forum_decID 

INNER JOIN decisions d
 ON d.decID = r.decID 

 AND d.decID = $decID
 ORDER BY f.forum_decName";

                $sql = "SELECT f.forum_decName,f.forum_decID FROM forum_dec f, rel_forum_dec  r " .
                    "WHERE f.forum_decID = r.forum_decID " .
                    "AND r.decID = $decID " .
                    "ORDER BY f.forum_decName";
                if ($rows = $db->queryObjectArray($sql)) {

                    foreach ($rows as $row) {
                        if (!$result["src_forums"])
                            $result["src_forums"] = $row->forum_decID;
                        else
                            $result["src_forums"] .= ";" . $row->forum_decID;

                    }
                }


                /********************************************DEST_DECISION_TYPE*************************************************************************/


                $sql = "SELECT c.catID  FROM categories c, rel_cat_dec r
			WHERE c.catID = r.catID
			AND r.decID =$decID ORDER BY c.catName";
                if ($rows = $db->queryObjectArray($sql)) {
                    foreach ($rows as $row) {
                        if (!$result["src_decisionsType"])
                            $result["src_decisionsType"] = $row->catID;
                        else
                            $result["src_decisionsType"] .= ";" . $row->catID;
                    }
                }
            }//end if script
            /*****************************************************************************************************/
            return $result;
        }
        /************************************************************************/
    }


    /****************************************************************************************/
    /****************************************************************************************/

    function read_decision_data3($decID, $insertID)
    {

        global $db;
        $sql = "SELECT decID, decName, parentDecID, parentDecID1,  " .
            "status, dec_date,vote_level,dec_level " .
            "FROM   decisions WHERE decID=$decID";
        $rows = $db->queryObjectArray($sql);
        if (is_array($rows) && sizeof($rows) == 1) {
            $row = $rows[0];
            $result["decID"] = $row->decID;
            $result["subcategories"] = $row->decName;
            $result["parentDecID"] = $row->parentDecID;
            $result["parentDecID1"] = $row->parentDecID1;
            $result["dec_status"] = $row->status;
            $result["dec_date"] = $row->dec_date;
            $result["vote_level"] = $row->vote_level;
            $result["dec_level"] = $row->dec_level;
            $result["forum_decision"] = "";
            $result["dest_decisionsType"] = "";
            $result["dest_forums"] = "";

            if ($result["parentDecID1"] == null)
                $result["parentDecID1"] = $insertID;

            $sql = "SELECT forum_decName FROM forum_dec, rel_forum_dec " .
                "WHERE forum_dec.forum_decID = rel_forum_dec.forum_decID " .
                "AND rel_forum_dec.decID = $decID " .
                "ORDER BY forum_decName";
            if ($rows = $db->queryObjectArray($sql)) {
                foreach ($rows as $row) {
                    if (!$result["dest_forums"])
                        $result["dest_forums"] = $row->forum_decName;
                    else
                        $result["dest_forums"] .= ";" . $row->forum_decName;

                }
            }
            //        $sql = "SELECT forum_decID FROM forum_dec  " .
            //           "WHERE forum_decName= " ;
            //        $sql.=$db->sql_string($result['forum_decision']);

            $sql = "SELECT c.catID  FROM categories c, rel_cat_dec r
			WHERE c.catID = r.catID
			AND r.decID =$decID ORDER BY c.catName";
            if ($rows = $db->queryObjectArray($sql)) {
                foreach ($rows as $row) {
                    if (!$result["dest_decisionsType"])
                        $result["dest_decisionsType"] = $row->catID;
                    else
                        $result["dest_decisionsType"] .= ";" . $row->catID;
                }
            }
            return $result;
        }
    }


    /******************************************************************************************************/

    function validate_data($formdata, $dateIDs = "")
    {
        global $db;
        $result = TRUE;
        $dec = new decisions();
        /*******************************FORUMS***********************************************/


        if (isset($formdata['dest_forums']) && !is_array($formdata['dest_forums']) && trim($formdata["new_forum"]) == ""
            && !$formdata['dest_forums']
        ) {
            $formdata['dest_forums'] = "";

        } elseif (isset($formdata['dest_forums']) && !is_array($formdata['dest_forums'])
            &&  (!isset($formdata['dest_forums']) && !$formdata["dest_forums"] )
            || !array_item($formdata, 'dest_forums')
            && isset($formdata["new_forum"]) &&  !trim($formdata["new_forum"]) == ""
        ) {

            $new_forum = explode(';', $formdata["new_forum"]);
            foreach ($new_forum as $forum) {

                $sql = "SELECT COUNT(*) FROM forum_dec " .
                    " WHERE forum_decName=" . $db->sql_string($forum) . "  ";
                if ($db->querySingleItem($sql) > 0) {
                    show_error_msg("כבר קיימ סוג פורומים בשם $forum");

                    $result = FALSE;
                }
            }


        } elseif ( isset($formdata["dest_forums"])    &&  $formdata["dest_forums"] && is_array($formdata["dest_forums"])
            && count($formdata["dest_forums"]) > 0 && array_item($formdata, 'dest_forums')
            && (isset($formdata["new_forum"]) && trim($formdata["new_forum"] != null))
        ) {
            $new_category = explode(';', $formdata["new_forum"]);
            foreach ($new_category as $cat) {

                $sql = "SELECT COUNT(*) FROM forum_dec " .
                    " WHERE forum_decName=" . $db->sql_string($forum) . "  ";
                if ($db->querySingleItem($sql) > 0) {
                    show_error_msg("כבר קיים פורום בשם $forum");

                    $result = FALSE;
                }
            }

            /************************************************************************************************************/
        } elseif (isset($formdata["dest_forums"]) && ($formdata["dest_forums"] && is_array($formdata["dest_forums"]) && count($formdata["dest_forums"]) > 0)
            && isset($formdata["new_forum"]) && trim($formdata["new_forum"] == null || trim($formdata["new_forum"] == ""))
        ) {


            $dest_forums = $formdata['dest_forums'];

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
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->forum_decID] = $row->forum_decName;


                    }

            } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                $staff = implode(',', $staff_test);

                $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->forum_decID] = $row->forum_decName;


                    }
                $staffb = implode(',', $staff_testb);

                $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staffb)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name_b[$row->forum_decID] = $row->forum_decName;
                    }
                $name = array_merge($name, $name_b);
                unset($staff_testb);

            } else {
                $staff = implode(',', $formdata['dest_forums']);

                $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staff)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->forum_decID] = $row->forum_decName;


                    }
            }
            if (array_item($name, '11')) {
                show_error_msg("קטגוריות הפורומים רשומת אב אין לבחור בה");
                $result = FALSE;
            }
        }
        /************************************************************************************************************/


        if (isset($formdata['dest_forums']) && ($formdata['dest_forums'] == "" ||  $formdata['dest_forums'] == 'none')
            && isset($formdata["new_forum"]) && $formdata["new_forum"] == ""
        ) {
            show_error_msg("חייב לשייך לפורום");
            $result = FALSE;
        }


        /************************************************DECISION_TYPE**********************************/

        if (isset($formdata['dest_decisionsType']) && !is_array($formdata['dest_decisionsType']) && trim($formdata["new_decisionType"]) == ""
            && !$formdata['dest_decisionsType']
        ) {
            $formdata['dest_decisionsType'] = "";

        } elseif (isset($formdata['dest_decisionsType']) && !is_array($formdata['dest_decisionsType'])
            && !isset($formdata['dest_decisionsType']) || !array_item($formdata, 'dest_decisionsType')
            && isset($formdata["new_decisionType"]) && !trim($formdata["new_decisionType"]) == ""
        ) {

            $new_category = explode(';', $formdata["new_decisionType"]);
            foreach ($new_category as $cat) {

                $sql = "SELECT COUNT(*) FROM categories " .
                    " WHERE catName=" . $db->sql_string($cat) . "  ";
                if ($db->querySingleItem($sql) > 0) {
                    show_error_msg("כבר קיימ סוג החלטות בשם $cat");

                    $result = FALSE;
                }
            }


        } elseif (isset($formdata["dest_decisionsType"]) && $formdata["dest_decisionsType"] && is_array($formdata["dest_decisionsType"])
            && count($formdata["dest_decisionsType"]) > 0 && array_item($formdata, 'dest_decisionsType')
            && isset($formdata["new_decisionType"]) && (trim($formdata["new_decisionType"] != null))
        ) {
            $new_category = explode(';', $formdata["new_decisionType"]);
            foreach ($new_category as $cat) {

                $sql = "SELECT COUNT(*) FROM categories " .
                    " WHERE catName=" . $db->sql_string($cat) . "  ";
                if ($db->querySingleItem($sql) > 0) {
                    show_error_msg("כבר קיימ סוג החלטות בשם $cat");

                    $result = FALSE;
                }
            }

            /************************************************************************************************************/
        } elseif (isset($formdata["dest_decisionsType"]) && ($formdata["dest_decisionsType"] && is_array($formdata["dest_decisionsType"]) && count($formdata["dest_decisionsType"]) > 0)
            && isset($formdata["new_decisionType"]) && trim($formdata["new_decisionType"] == null || trim($formdata["new_decisionType"] == ""))
        ) {


            $dest_decisionsType = $formdata['dest_decisionsType'];

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
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_decisionsType'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->catID] = $row->catName;


                    }

            } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                $staff = implode(',', $staff_test);

                $sql2 = "select catID, catName from categories where catName in ($staff)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_decisionsType'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->catID] = $row->catName;


                    }
                $staffb = implode(',', $staff_testb);

                $sql2 = "select catID, catName from categories where catID in ($staffb)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_decisionsType'] = "";
                else
                    foreach ($rows as $row) {

                        $name_b[$row->catID] = $row->catName;
                    }
                $name = array_merge($name, $name_b);
                unset($staff_testb);

            } else {
                $staff = implode(',', $formdata['dest_decisionsType']);

                $sql2 = "select catID, catName from categories where catID in ($staff)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_decisionsType'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->catID] = $row->catName;


                    }
            }
            if (array_item($name, '11')) {
                show_error_msg("קטגוריות ההחלטות רשומת אב אין לבחור בה");
                $result = FALSE;
            }
        }
        /************************************************************************************************************/


        if (
                (isset($formdata['dest_decisionsType']) && $formdata['dest_decisionsType'] == "" || trim($formdata['dest_decisionsType'] == 'none'))
            && (isset($formdata["new_decisionType"]) && $formdata["new_decisionType"] == "") ) {
            show_error_msg("חייב לשייך לקטגוריה");
            $result = FALSE;
        }

        /*******************************************************************************************/
        if (isset($formdata["subcategories"]) && trim($formdata["subcategories"]) == "") {
            show_error_msg("!חייב לציין שם כותרת החלטה");
            $result = FALSE;
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($formdata['vote_level']) && !(is_array($formdata['vote_level'])) ) {
            if (!empty($formdata['vote_level']) && ((!is_numeric($formdata['vote_level'])) || $formdata['vote_level'] < 1 || $formdata['vote_level'] > 100)) {
                show_error_msg("אחוז הצבע חייב להיות בין 1<= 100 .");
                $result = FALSE;
            } elseif (empty($formdata['vote_level'])) {
                show_error_msg("אחוז הצבע חייב להיות בין 1<= 100 .");
                $result = FALSE;
            }
        } else {

            if (!empty($formdata['vote_level'])) {
                $i = 0;
                foreach ($formdata['vote_level'] as $vote) {

                    if (!empty($vote) && ((!is_numeric($vote)) || $vote < 1 || $vote > 100)) {
                        show_error_msg("אחוז הצבע חייב להיות בין 1<= 100 .");
                        $result = FALSE;
                        $i++;
                    }
                }
            } else {
                show_error_msg("אחוז הצבע חייב להיות בין 1<= 100 .");
                $result = FALSE;
            }
        }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($formdata['dec_level']) && !(is_array($formdata['dec_level']))) {
            if (!empty($formdata['dec_level']) && ((!is_numeric($formdata['dec_level'])) || $formdata['dec_level'] < 1 || $formdata['dec_level'] > 10)) {
                show_error_msg("רמת חשיבות החלטה חייבת חוקית .");
                $result = FALSE;

            } elseif (empty($formdata['dec_level'])) {

                show_error_msg("רמת חשיבות החלטה חייבת חוקית .");
                $result = FALSE;
            }

        } else {

            if (!empty($formdata['dec_level'])) {
                $i = 0;
                foreach ($formdata['dec_level'] as $level) {

                    if (!empty($level) && ((!is_numeric($level)) || $level < 1 || $level > 10)) {
                        show_error_msg("רמת חשיבות החלטה חייבת חוקית .");
                        $result = FALSE;
                        $i++;
                    }
                }
            } else {
                show_error_msg("רמת חשיבות החלטה חייבת חוקית .");
                $result = FALSE;
            }

        }
        /*******************************DATES***********************************************/

        if (array_item($formdata, 'dec_date') && !$dec->check_date($formdata['dec_date']) && !is_array($dateIDs)) {


            show_error_msg("חייב להזין תאריך החלטה חוקי !");
            $result = FALSE;
        }


//-------------------------------------------------------------
        if (is_array($dateIDs)) {
            foreach ($dateIDs as $date) {

                if (!$dec->check_date($date)) {


                    show_error_msg("חייב להזין תאריך החלטה חוקי !");
                    $result = FALSE;
                }


            }
        }

//----------------------------------------------------------------------------------------------------------------------------------

        if (isset($formdata['dec_date']) && (!array_item($formdata, 'dec_date') && $formdata['dec_date'] == null) && !is_array($dateIDs)) {

            show_error_msg("חייב להזין תאריך החלטה חוקי !");
            $result = FALSE;
        }


        return $result;
    }//end_function

    /******************************************************************************************************/

    function validate_data_ajx($formdata, $dateIDs = "")
    {
        global $db;
        $result = TRUE;
        $decID = $formdata['decID'];
        $dec = new decisions();

        if (array_item($formdata, 'dec_date') && !$dec->check_date($formdata['dec_date']) && is_array($dateIDs)) {

        }
        /*******************************DATES***********************************************/
        $decID = $formdata['decID'];
        try {
            if (array_item($formdata, "dec_date$decID") && !$dec->check_date($formdata["dec_date$decID"]) && !is_array($dateIDs)) {

                $result = FALSE;
                throw new Exception("חייב להזין תאריך החלטה חוקי !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }

//-------------------------------------------------------------
        try {
            if (array_item($formdata, 'dec_date') && !$dec->check_date($formdata['dec_date']) && !is_array($dateIDs)) {

                $result = FALSE;
                throw new Exception("חייב להזין תאריך החלטה חוקי !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }

//-------------------------------------------------------------
        if (is_array($dateIDs)) {
            foreach ($dateIDs as $date) {
                try {
                    if (!$dec->check_date($date)) {

                        $result = FALSE;
                        throw new Exception("חייב להזין תאריך החלטה חוקי !");
                    }

                } catch (Exception $e) {
                    $message[] = $e->getMessage();
                }

            }
        }

//-------------------------------------------------------------
// && array_item($formdata,"dec_date$decID") && !$dec->check_date($formdata["dec_date$decID"])
//try {
//if( (!array_item($formdata,'dec_date') && ($formdata['dec_date']==null || $formdata['dec_date']==0)  && !is_array($dateIDs) )){
//
//    			$result = FALSE;
//			  throw new Exception("חייב להזין תאריך החלטה חוקי !");
//       }
//
//		}catch(Exception $e){
// 	         $message[]=$e->getMessage();
//	  }
//-------------------------------------------------------------
        IF (array_item($formdata, 'dec_date')) {

            try {
                if (($formdata['dec_date'] == 0) && !is_array($dateIDs) && !$dec->check_date($formdata["dec_date"])) {

                    $result = FALSE;
                    throw new Exception("חייב להזין תאריך החלטה חוקי !");
                }

            } catch (Exception $e) {
                $message[] = $e->getMessage();
            }
        } elseif (array_item($formdata, "dec_date$decID")) {
            try {
                if ($formdata["dec_date$decID"] == 0 && !is_array($dateIDs) && !$dec->check_date($formdata["dec_date$decID"])) {

                    $result = FALSE;
                    throw new Exception("חייב להזין תאריך החלטה חוקי !");
                }

            } catch (Exception $e) {
                $message[] = $e->getMessage();
            }
        }


//-------------------------------------------------------------
        try {
            if (!array_item($formdata, 'dec_date') && !array_item($formdata, "dec_date$decID") && !is_array($dateIDs)) {

                $result = FALSE;
                throw new Exception("חייב להזין תאריך החלטה חוקי !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }

//-------------------------------------------------------------
        /*******************************FORUMS***********************************************/


        if (isset($formdata['dest_forums']) && !is_array($formdata['dest_forums']) && trim($formdata["new_forum"]) == ""
            && !$formdata['dest_forums']
        ) {
            $formdata['dest_forums'] = "";

        } elseif (!empty($formdata['dest_forums']) && !is_array($formdata['dest_forums']) && ($formdata['dest_forums'] == null) || (!empty($formdata['dest_forums']) && !$formdata["dest_forums"] || !array_item($formdata, 'dest_forums')
                &&  isset($formdata["new_forum"]) &&  !trim($formdata["new_forum"]) == "" )

        ) {

            $new_forum = explode(';', $formdata["new_forum"]);
            foreach ($new_forum as $forum) {

                $sql = "SELECT COUNT(*) FROM forum_dec " .
                    " WHERE forum_decName=" . $db->sql_string($forum) . "  ";
                try {

                    if ($db->querySingleItem($sql) > 0) {
                        $result = FALSE;
                        throw new Exception("כבר קיים פורום אם שם כזה!$forum");
                    }

                } catch (Exception $e) {
                    $message[] = $e->getMessage();
                }
            }

            /********************************************************************************************/

        } elseif (!empty($formdata["dest_forums"]) &&  $formdata["dest_forums"] && is_array($formdata["dest_forums"])
            && count($formdata["dest_forums"]) > 0 && array_item($formdata, 'dest_forums')
            && (trim($formdata["new_forum"] != null))
        ) {
            $new_category = explode(';', $formdata["new_forum"]);
            foreach ($new_category as $cat) {

                $sql = "SELECT COUNT(*) FROM forum_dec " .
                    " WHERE forum_decName=" . $db->sql_string($forum) . "  ";
                try {

                    if ($db->querySingleItem($sql) > 0) {
                        $result = FALSE;
                        throw new Exception("כבר קיים פורום אם שם כזה!$forum");
                    }

                } catch (Exception $e) {
                    $message[] = $e->getMessage();
                }
            }

            /************************************************************************************************************/
        } elseif (!empty($formdata["dest_forums"]) &&  ($formdata["dest_forums"] && is_array($formdata["dest_forums"]) && count($formdata["dest_forums"]) > 0)
            && trim($formdata["new_forum"] == null || trim($formdata["new_forum"] == ""))
        ) {


            $dest_forums = $formdata['dest_forums'];

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
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->forum_decID] = $row->forum_decName;


                    }

            } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                $staff = implode(',', $staff_test);

                $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decName in ($staff)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->forum_decID] = $row->forum_decName;


                    }
                $staffb = implode(',', $staff_testb);

                $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staffb)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name_b[$row->forum_decID] = $row->forum_decName;
                    }
                $name = array_merge($name, $name_b);
                unset($staff_testb);

            } else {
                $staff = implode(',', $formdata['dest_forums']);

                $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staff)";
                if (!$rows = $db->queryObjectArray($sql2))
                    $formdata['dest_forums'] = "";
                else
                    foreach ($rows as $row) {

                        $name[$row->forum_decID] = $row->forum_decName;


                    }
            }
            try {

                if (array_item($name, '11')) {
                    $result = FALSE;
                    throw new Exception("קטגוריות הפורומים רשומת אב אין לבחור בה!");
                }

            } catch (Exception $e) {
                $message[] = $e->getMessage();
            }
        }
        /************************************************************************************************************/

        try {

            if ((trim($formdata["dest_forums$decID"]) == "" || trim($formdata["dest_forums$decID"] == 'none'))
                && trim($formdata["new_forum"]) == ""
            ) {
                $result = FALSE;
                throw new Exception("חייב לשייך לפורום!");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }


        /************************************************DECISION_TYPE**********************************/
        if (!empty($formdata['dest_decisionsType']) &&  $formdata['dest_decisionsType'] && (is_array($formdata['dest_decisionsType']))) {


            try {
                if ((trim($formdata["dest_decisionsType"]) == "" || trim($formdata["dest_decisionsType"] == 'none'))
                    && trim($formdata["new_decisionType"]) == ""
                ) {
                    $result = FALSE;
                    throw new Exception("חייב לשייך לקטגוריה!");
                }

            } catch (Exception $e) {
                $message[] = $e->getMessage();
            }


            if (!is_array($formdata['dest_decisionsType']) && trim($formdata["new_decisionType"]) == ""
                && !$formdata['dest_decisionsType']
            ) {
                $formdata['dest_decisionsType'] = "";

            } elseif (!is_array($formdata['dest_decisionsType'])
                && ($formdata['dest_decisionsType'] == null) || !$formdata["dest_decisionsType"] || !array_item($formdata, 'dest_decisionsType')
                && !trim($formdata["new_decisionType"]) == ""
            ) {

                $new_category = explode(';', $formdata["new_decisionType"]);
                foreach ($new_category as $cat) {

                    $sql = "SELECT COUNT(*) FROM categories " .
                        " WHERE catName=" . $db->sql_string($cat) . "  ";

                    try {
                        if ($db->querySingleItem($sql) > 0) {
                            $result = FALSE;
                            throw new Exception("כבר קיימ סוג החלטות בשם!$cat");
                        }

                    } catch (Exception $e) {
                        $message[] = $e->getMessage();
                    }


                }

                /***************************************************************************************************/

            } elseif ($formdata["dest_decisionsType"] && is_array($formdata["dest_decisionsType"])
                && count($formdata["dest_decisionsType"]) > 0 && array_item($formdata, 'dest_decisionsType')
                && (trim($formdata["new_decisionType"] != null))
            ) {
                $new_category = explode(';', $formdata["new_decisionType"]);
                foreach ($new_category as $cat) {

                    $sql = "SELECT COUNT(*) FROM categories " .
                        " WHERE catName=" . $db->sql_string($cat) . "  ";
                    try {
                        if ($db->querySingleItem($sql) > 0) {
                            $result = FALSE;
                            throw new Exception("כבר קיימ סוג החלטות בשם!$cat");
                        }

                    } catch (Exception $e) {
                        $message[] = $e->getMessage();
                    }
                }

                /************************************************************************************************************/
            } elseif (($formdata["dest_decisionsType"] && is_array($formdata["dest_decisionsType"]) && count($formdata["dest_decisionsType"]) > 0)
                && trim($formdata["new_decisionType"] == null || trim($formdata["new_decisionType"] == ""))
            ) {


                $dest_decisionsType = $formdata['dest_decisionsType'];

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
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata['dest_decisionsType'] = "";
                    else
                        foreach ($rows as $row) {

                            $name[$row->catID] = $row->catName;


                        }

                } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                    $staff = implode(',', $staff_test);

                    $sql2 = "select catID, catName from categories where catName in ($staff)";
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata['dest_decisionsType'] = "";
                    else
                        foreach ($rows as $row) {

                            $name[$row->catID] = $row->catName;


                        }
                    $staffb = implode(',', $staff_testb);

                    $sql2 = "select catID, catName from categories where catID in ($staffb)";
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata['dest_decisionsType'] = "";
                    else
                        foreach ($rows as $row) {

                            $name_b[$row->catID] = $row->catName;
                        }
                    $name = array_merge($name, $name_b);
                    unset($staff_testb);

                } else {
                    $staff = implode(',', $formdata['dest_decisionsType']);

                    $sql2 = "select catID, catName from categories where catID in ($staff)";
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata['dest_decisionsType'] = "";
                    else
                        foreach ($rows as $row) {

                            $name[$row->catID] = $row->catName;


                        }
                }

                try {
                    if (array_item($name, '11')) {
                        $result = FALSE;
                        throw new Exception("קטגוריות ההחלטות רשומת אב אין לבחור בה!");
                    }

                } catch (Exception $e) {
                    $message[] = $e->getMessage();
                }
            }
            /************************************************************************************************************/
        } else {
            try {
                if ((trim($formdata["dest_decisionsType$decID"]) == "" || trim($formdata["dest_decisionsType$decID"] == 'none'))
                    && trim($formdata["new_decisionType"]) == ""
                ) {
                    $result = FALSE;
                    throw new Exception("חייב לשייך לקטגוריה!");
                }

            } catch (Exception $e) {
                $message[] = $e->getMessage();
            }


///////////////////////////////////////////////////

            if (!empty($formdata["dest_decisionsType$decID"]) &&  !is_array($formdata["dest_decisionsType$decID"]) && trim($formdata["new_decisionType"]) == ""
                && !$formdata["dest_decisionsType$decID"]
            ) {
                $formdata["dest_decisionsType$decID"] = "";

            } elseif (!empty($formdata["dest_decisionsType$decID"]) &&  !is_array($formdata["dest_decisionsType$decID"])
                && (!empty($formdata["dest_decisionsType$decID"]) &&  $formdata["dest_decisionsType$decID"] == null) || (!empty($formdata["dest_decisionsType$decID"]) &&  !$formdata["dest_decisionsType$decID"] || !array_item($formdata, "dest_decisionsType$decID")
                    && !empty($formdata["new_decisionType"]) && !trim($formdata["new_decisionType"]) == "")
            ) {

                $new_category = explode(';', $formdata["new_decisionType"]);
                foreach ($new_category as $cat) {

                    $sql = "SELECT COUNT(*) FROM categories " .
                        " WHERE catName=" . $db->sql_string($cat) . "  ";

                    try {
                        if ($db->querySingleItem($sql) > 0) {
                            $result = FALSE;
                            throw new Exception("כבר קיימ סוג החלטות בשם!$cat");
                        }

                    } catch (Exception $e) {
                        $message[] = $e->getMessage();
                    }


                }

                /***************************************************************************************************/

            } elseif (!empty($formdata["dest_decisionsType$decID"]) && $formdata["dest_decisionsType$decID"] && is_array($formdata["dest_decisionsType$decID"])
                && count($formdata["dest_decisionsType$decID"]) > 0 && array_item($formdata, 'dest_decisionsType')
                && (!empty($formdata["new_decisionType"]) && trim($formdata["new_decisionType"] != null))
            ) {
                $new_category = explode(';', $formdata["new_decisionType"]);
                foreach ($new_category as $cat) {

                    $sql = "SELECT COUNT(*) FROM categories " .
                        " WHERE catName=" . $db->sql_string($cat) . "  ";
                    try {
                        if ($db->querySingleItem($sql) > 0) {
                            $result = FALSE;
                            throw new Exception("כבר קיימ סוג החלטות בשם!$cat");
                        }

                    } catch (Exception $e) {
                        $message[] = $e->getMessage();
                    }
                }

                /************************************************************************************************************/
            } elseif (!empty($formdata["dest_decisionsType$decID"]) && ($formdata["dest_decisionsType$decID"] && is_array($formdata["dest_decisionsType$decID"]) && count($formdata["dest_decisionsType$decID"]) > 0)
                && trim($formdata["new_decisionType"] == null ||(!empty($formdata["new_decisionType"]) &&  trim($formdata["new_decisionType"] == "") ) )
            ) {


                $dest_decisionsType = $formdata["dest_decisionsType$decID"];

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
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata["dest_decisionsType$decID"] = "";
                    else
                        foreach ($rows as $row) {

                            $name[$row->catID] = $row->catName;


                        }

                } elseif (is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
                    $staff = implode(',', $staff_test);

                    $sql2 = "select catID, catName from categories where catName in ($staff)";
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata["dest_decisionsType$decID"] = "";
                    else
                        foreach ($rows as $row) {

                            $name[$row->catID] = $row->catName;


                        }
                    $staffb = implode(',', $staff_testb);

                    $sql2 = "select catID, catName from categories where catID in ($staffb)";
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata["dest_decisionsType$decID"] = "";
                    else
                        foreach ($rows as $row) {

                            $name_b[$row->catID] = $row->catName;
                        }
                    $name = array_merge($name, $name_b);
                    unset($staff_testb);

                } else {
                    $staff = implode(',', $formdata["dest_decisionsType$decID"]);

                    $sql2 = "select catID, catName from categories where catID in ($staff)";
                    if (!$rows = $db->queryObjectArray($sql2))
                        $formdata['dest_decisionsType'] = "";
                    else
                        foreach ($rows as $row) {

                            $name[$row->catID] = $row->catName;


                        }
                }

                try {
                    if (array_item($name, '11')) {
                        $result = FALSE;
                        throw new Exception("קטגוריות ההחלטות רשומת אב אין לבחור בה!");
                    }

                } catch (Exception $e) {
                    $message[] = $e->getMessage();
                }
            }

//////////////////////////////////////////////////
        }

        /************************************************************************************************/
        /*******************************************************************************************/
        try {
            if (trim($formdata["subcategories"]) == "") {
                $result = FALSE;
                throw new Exception("חייב לציין שם כותרת החלטה!");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }
        /******************************************************************************************************/
        try {
            if (!empty($formdata['vote_level']) && ((!is_numeric($formdata['vote_level'])) || $formdata['vote_level'] < 1 || $formdata['vote_level'] > 100)) {
                $result = FALSE;
                throw new Exception("אחוז הצבע חייב להיות בין 1<= 100  !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }


        try {
            if (empty($formdata['vote_level'])) {
                $result = FALSE;
                throw new Exception("אחוז הצבע חייב להיות בין 1<= 100  !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }


        $formdata['dec_level'] = (int)$formdata['dec_level'];
        try {
            if (!empty($formdata['dec_level']) && ((!is_numeric($formdata['dec_level'])))) {
                $result = FALSE;
                throw new Exception("רמת חשיבות החלטה חייבת להיות בין 1 <= 10 !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }


        try {
            if (empty($formdata['dec_level'])) {
                $result = FALSE;
                throw new Exception("רמת חשיבות החלטה חייבת להיות בין 1 <= 10 !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }


        try {
            if ($formdata['dec_level'] < 1 || $formdata['dec_level'] > 10) {
                $result = FALSE;
                throw new Exception("רמת חשיבות החלטה חייבת להיות בין 1 <= 10 !");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }
//try {
//	if( empty($formdata['vote_level']) ||  (!is_numeric($formdata['vote_level']))  ) {
//    	$result = FALSE;
//            throw new Exception("חייב להזין רמת חשיבות החלטה חוקי.");
//	          }
//
//	   	} catch(Exception $e){
// 			    $message[]=$e->getMessage();
//	    }


        try {
            if (empty($formdata['dec_level']) || ((!is_numeric($formdata['dec_level'])))) {
                $result = FALSE;
                throw new Exception("רמת חשיבות החלטה חייבת חוקית.");
            }

        } catch (Exception $e) {
            $message[] = $e->getMessage();
        }


//try {
//    if(!empty($formdata['dec_status']) && ((!is_numeric($formdata['dec_status'])) || $formdata['dec_status']>1 || $formdata['dec_status']<0)) {
//    	$result = FALSE;
//            throw new Exception("סטטוס החלטה חייבת להיות   1 או 0  (או ריקה)!");
//	          }
//
//	   	} catch(Exception $e){
// 			    $message[]=$e->getMessage();
//	    }


//if(!$result){
//
//	$i=0;
//	$j=0;
//	foreach($message as $row)
//	{
//	  $key="messageError_$i";
//	 $message_name[$key]=$row ;
//
//
//	  $response[$j]['type'] = 'error';
//
//	  $i++;
//	  $j++;
//	}
//	 $response['message'][] = $message_name;
//
// 	print json_encode($response);
//		exit;
//}


        if (!$result) {
            unset($response);
            $i = 0;
            $j = 0;
            foreach ($message as $row) {
                $key = "messageError_$i";
                $message_name[$key] = $row;

                if (!($j == (count($message) - 1) && !$j == '0'))
                    $response[$j]['type'] = 'error';
                else {
                    $response[$j - 1]['type'] = 'error';
                }


                $i++;
                $j++;
            }
            $response['message'][0] = $message_name;
            $message_name['decID'] = $decID;
            print json_encode($message_name);
            exit;
        }


        return $result;
        /************************************************************************************************************/
    }

    /*****************************************************************************************************/

    function update()
    {
        global $db;
        $db->getMysqli();
        $sets = array();
        $values = array();
        foreach (array_keys($this->fields) as $field) {
            $sets [] = $field . '=?';
            $values [] = $this->fields[$field];
        }
        $set = join(", ", $sets);
        $values [] = $this->id;

        $sql = 'UPDATE ' . $this->table . ' SET ' . $set .
            ' WHERE ' . $this->table . '_id=?';

        $sth = $db->prepare($sql);
        $db->execute($sth, $values);
    }//end func
    /*****************************************************************************************************/


    /*****************************************************************************************************/

    function update_dec1(&$formdata)
    {
        global $db;
        $dec_date = $this->build_date($formdata);
        $dec_date = $dec_date['full_date'];

        if ((is_array($dec_date))) {
            $dec_date = $dec_date[0];

            $formdata['dec_date'] = $dec_date;
        } else {
            $dec_date = $formdata['dec_date'];
        }


        list($year_date, $month_date, $day_date) = explode('-', $dec_date);
        if (strlen($year_date) > 3) {
            $dec_date = "$year_date-$month_date-$day_date";
        } else {
            $dec_date = "$day_date-$month_date-$year_date";
        }

        if ($formdata['dec_Allowed'] == 1)
            $decAllowed = 'public';
        elseif ($formdata['dec_Allowed'] == 2)
            $decAllowed = 'private';
        elseif ($formdata['dec_Allowed'] == 3)
            $decAllowed = 'top_secret';


        if ($decID = array_item($formdata, "decID")) {
            $sql = "UPDATE decisions SET " .
                "decName=" . $db->sql_string($formdata["subcategories"]) . ", " .
                "parentDecID=" . $this->num_or_NULL($formdata["parentDecID"]) . ", " .
                "parentDecID1=" . $this->num_or_NULL($formdata["parentDecID1"]) . ", " .
                "status=" . $db->sql_string($formdata["dec_status"]) . "," .
                "dec_level=" . $this->num_or_NULL($formdata["dec_level"]) . "," .
                "vote_level=" . $this->num_or_NULL($formdata["vote_level"]) . "," .
                "dec_allowed=" . $db->sql_string($decAllowed) . " , " .
                "dec_date=" . $db->sql_string($dec_date) . "  " .
                "WHERE decID=$decID";
            if (!$db->execute($sql))
                return FALSE;
            // remove existing forum-cat-dec connections
            //=======================================

            $decID = $formdata['decID'];


            /*****************************FORUMS_DECISION*****************************************************/
//
// if($formdata["src_forums"]){
//	 	$cat=$formdata["src_forums"];
//	 	if(is_array($cat) ){
//	 		foreach($cat as $key=>$val){
//		$sql = "DELETE FROM rel_forum_dec WHERE decID=$decID and forum_decID=$val ";
//		if(!$db->execute($sql))
//		return FALSE;
//	 	}
//	 }
//}
            /*****************************FORUMS_DECISION$*****************************************************/
// if($formdata["src_forums$decID"]){
//	 	$cat=$formdata["src_forums$decID"];
//	 	if(is_array($cat) ){
//	 		foreach($cat as $key=>$val){
//		$sql = "DELETE FROM rel_forum_dec WHERE decID=$decID and forum_decID=$val ";
//		if(!$db->execute($sql))
//		return FALSE;
//	 	}
//	 }
//}


            /*****************************DECISIONS_TYPE*****************************************************/

            if ($formdata["src_decisionsType"]) {
                $cat = $formdata["src_decisionsType"];
                if (is_array($cat)) {
                    foreach ($cat as $key => $val) {
                        $sql = "DELETE FROM rel_cat_dec WHERE decID=$decID and catID=$val ";
                        if (!$db->execute($sql))
                            return FALSE;
                    }
                }
            }
            /*****************************DECISIONS_TYPE$*****************************************************/

            if ($formdata["src_decisionsType$decID"]) {
                $cat = $formdata["src_decisionsType$decID"];
                if (is_array($cat)) {
                    foreach ($cat as $key => $val) {
                        $sql = "DELETE FROM rel_cat_dec WHERE decID=$decID and catID=$val ";
                        if (!$db->execute($sql))
                            return FALSE;
                    }
                }
            }


            /**************************************************************************************************************/

        }

        return $formdata['decID'];
    }//end func
    /*****************************************************************************************************/


////////////////////////////////////////////////////////////////////////////////////////////////////


    /******************************************************************************************************/

    function build_date(&$formdata)
    {


        $fields = array('year_date' => 'integer', 'month_date' => 'integer', 'day_date' => 'intger', 'full_date' => 'string');


        if (array_item($formdata, 'year_date') && is_numeric($formdata['year_date']) && !(is_numeric($formdata['multi_year'][0]))) {
            foreach ($fields as $key => $type) {
                $rows[$key] = $this->safify($formdata[$key], $type);
            }
            $rows['full_date'] = "$rows[year_date]-$rows[month_date]-$rows[day_date]";
            $rows['full_date'] = $this->safify($rows['full_date'], $type);


        } elseif (array_item($formdata, 'multi_year') && is_numeric($formdata['multi_year'][0])
            && (array_item($formdata, 'multi_month') && is_numeric($formdata['multi_year'][0]))
            && (array_item($formdata, 'multi_day') && is_numeric($formdata['multi_day'][0]))
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
                //$rows['full_date'][$i] =$this-> safify($rows['full_date'][$i] , $type);

            }

        } elseif (array_item($formdata, 'dec_date')) {
            $rows['full_date'] = $formdata['dec_date'];
        }
        $rows = isset($rows) ? $rows : '';
        return $rows;
    }
    /******************************************************************************************************/


//////////////////////////////////////////////////////////////////////////////////////////////////

    function safify($value, $type = '')
    {
        // we're handling our own quoting, so we don't need magic quotes
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        // settype($value, $type);
        switch ($type) {
            case 'int':
            case 'float':
            case 'double':
                // the settype() above is all we need to do for numbers
                break;
            case 'boolean': /* processing of booleans depends on where $value is coming
     * from.  This section will probably need to be customized on a
     * per-form basis.
     */
                $vals[$key] = is_null($vals) ? 'NULL' : "'$vals'";
                return $vals;
                break;
            case 'string':
                if (is_array($value)) {
                    $value = (trim($value));
                    $value[$key] = is_null($value) ? 'NULL' : "'$value'";
                } else {
                    $value = is_null($value) ? 'NULL' : "'$value'";
                }
                return $value;
                break;
            default:
                if (is_array($value)) {
                    $value[$key] = is_null($value) ? 'NULL' : "'$value'";
                } else {
                    $value = (trim($value));// mysql_real_escape_string(trim($value));
                    //$value = is_null($value) ? 'NULL' : "'$value'" ;
                }
                return $value;
                break;
        }
        return $value;
    }


    /*******************************************************************************************/

    // read all data for a certain decision from database
    // and save it in an array; return this array

    function num_or_NULL($n)
    {
        if (is_numeric($n))
            return $n;
        else
            return 'NULL';
    }
    /***************************************************************************/
    // read all data for a certain decision from database
    // and save it in an array; return this array

    function update_decision_general()
    {
        $mode = 'update';
        $updateID = $this->updateID;
        $submitbutton = $this->submitbutton;
        $subcategories = $this->subcategories;
        global $db;

        $sql = "SELECT COUNT(*) FROM decisions WHERE decID='$updateID'";
        $n = $db->querySingleItem($sql);

        // if url had valid updateID, show this category and
        // an input form for new subcategories
        if ($updateID && $n == 1) {
            echo '<fieldset class="my_pageCount" >';


            // if there is form data to process, update new
            // subcategories into database
            if ($subcategories) {
                $db->execute("START TRANSACTION");
                if ($this->update_decisions($updateID, $subcategories, $mode))
                    $db->execute("COMMIT");
                else
                    $db->execute("ROLLBACK");
            }

            if (array_item($_POST, 'submitbutton'))
                $str = array_item($_POST, 'submitbutton');
            else
                $str = 'שמור';
            if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_POST, 'submitbutton') == $str)) {
                echo "<h1>עדכן החלטה</h1>\n";
                $this->print_decision_entry_form1_c($updateID, $mode);
            }
            echo '</fieldset>';
            $formdata = FAlSE;
            build_form($formdata);
            $this->print_form_paging_b();

        }


    }//end read data

    /***************************************************************************/
// read all data for a certain decision from database
    // and save it in an array; return this array

    function update_decisions($updateID, $subcategories, $mode)
    {
        global $db;
        $subcatarray = explode(";", $subcategories);
        //$subcat=$subcategories;
        $count = 0;
        foreach ($subcatarray as $newdecname) {
            $result = $this->update_new_decision($updateID, trim($newdecname));
            if ($result == -1) {
                echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
                return FALSE;
            } elseif ($result)
                $count++;
        }
        if ($count)
            if ($count == 1)
                // echo "<p class='msg'>החלטה עודכנה.</p>\n";
                echo "<p class='error'>כותרת החלטה עודכנה.</p>\n";

        return TRUE;
    }

    /***************************************************************************/

    function update_new_decision($updateID, $newdecName)
    {
        global $db;
        // test if newcatName is empty
        if (!$newdecName) return 0;
        $newdecName = $db->sql_string($newdecName);


        // update category
        $sql = "update  decisions set decName=$newdecName where decID=$updateID ";
        // "VALUES ($newcatName, $insertID)";
        if ($db->execute($sql))
            return 1;
        else
            return -1;
    }

    /************************************************************************************************************/
    /***************************************************************************/

function print_decision_entry_form1_c($updateID, $mode = '')
{
    /******************************************************************************************************/
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


    $insertID = $updateID;

    ?>
    <div id="my_entry_top<?PHP echo $updateID; ?>"><?php


    $sql = "SELECT decName, decID, parentDecID " .
        "FROM decisions ORDER BY decName";
    if ($rows = $db->queryObjectArray($sql)) {

        // build assoc. arrays for name, parent and subcats
        foreach ($rows as $row) {
            $decNames[$row->decID] = $row->decName;
            $parents[$row->decID] = $row->parentDecID;
            $subcats[$row->parentDecID][] = $row->decID;
        }


        // build list of all parents for $updateID
        $decID = $updateID;
        while ($parents[$decID] != NULL) {
            $decID = $parents[$decID];
            $parentList[] = $decID;
        }

//echo '<fieldset class="my_pageCount" >';

        if ($level) {
////////////////////////////////////////////////////////////////////////////////////////

            if (isset($parentList)) {
                for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                    $url = "../admin/find3.php?decID=$parentList[$i]";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    if ($parentList[$i] == '11') {
                        printf("<ul><li style='font-weight :bold;'><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s (%s, %s )</b> </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),


                            build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"));
                    } else {
                        $url = "../admin/find3.php?decID=$parentList[$i]";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"),
                            build_href2("dynamic_5b.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));


                    }

                }
            }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // display choosen forum  * BOLD *
            if ($insertID == '11') {

                printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"));

            } else {
                $url = "../admin/find3.php?decID=$updateID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<ul ><li><b class='bgchange_tree' style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"),
                    build_href2("dynamic_5b.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////


            $i = 0;
            if (array_key_exists($updateID, $subcats)) {
                echo "<ul>";
                while (!empty($subcats[$updateID]) && $subcats[$updateID]) {
                    foreach ($subcats[$updateID] as $decID) {
                        $url = "find3.php?decID=$decID";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$decID]),
                            build_href2("dynamic_5b.php", "mode=insert", "&insertID=$decID", "הוסף"),
                            build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$decID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("dynamic_5b.php", "mode=update", "&updateID=$decID", "עדכן"),
                            build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));

                    }
                    echo "<ul>";

                    $updateID = $decID;
                    $i++;
                }
                // close hierarchical category list
                echo str_repeat("</ul>", $i + 1), "\n";
            } else {

                echo "(עדיין אין תת-החלטות.)";
            }


// echo "</ul>\n";

            if (isset($parentList)) {
                echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
            }
            /****************************************************************************************/
            if (($mode == 'update')) {
                echo '<form method="post" action="dynamic_5.php?mode=update&updateID=',
                $insertID, '">', "\n",
                "<p>עדכן תת החלטה/החלטה ",
                "<b>$decNames[$insertID]</b>. <br /> ",
                '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
                '<input type="submit" value="שמור" name="submitbutton" /></p>', "\n",
                "</form>\n";
            }
            /***************************************************************************************/
            echo '</div>';


//////////////////////////
        } elseif (!($level)) {//
////////////////////////


            if (isset($parentList)) {
                for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                    $url = "../admin/find3.php?decID=$parentList[$i]";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    if ($parentList[$i] == '11') {
                        printf("<ul><li style='font-weight :bold;'><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b> %s </b> </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]));
                    } else {
                        $url = "../admin/find3.php?decID=$parentList[$i]";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<ul><li style='font-weight :bold;'> %s (%s, %s) </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5b.php", "mode=read_data", "&editID=$parentList[$i]", "מידע  מורחב"),
                            build_href5("", "", "הראה נתונים", $str));


                    }

                }
            }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // display choosen forum  * BOLD *
            if ($insertID == '11') {

                printf("<ul><li><b style='color:red;'> %s</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]));

            } else {
                $url = "../admin/find3.php?decID=$updateID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=read_data", "&editID=$updateID", "מידע  מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////


            echo "<ul>";


            $i = 0;
            if (array_key_exists($updateID, $subcats)) {

                while ($subcats[$updateID]) {
                    foreach ($subcats[$updateID] as $decID) {
                        $url = "find3.php?decID=$decID";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<li style='font-weight :bold;'> %s (%s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$decID]),
                            build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", "מידע  מורחב"),
                            build_href5("", "", "הראה נתונים", $str));

                    }
                    echo "<ul>";

                    $updateID = $decID;
                    $i++;
                }
                // close hierarchical category list
                echo str_repeat("</ul>", $i + 1), "\n";
            } else {

                echo "(עדיין אין תת-החלטות.)";
            }


            echo "</ul>\n";

            if (isset($parentList))
                echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";
            /****************************************************************************************/
            if (($mode == 'update')) {
                echo '<form method="post" action="dynamic_5.php?mode=update&updateID=',
                $insertID, '">', "\n",
                "<p>עדכן תת החלטה/החלטה ",
                "<b>$decNames[$insertID]</b>. <br /> ",
                '<p><input name="subcategories" size="60" maxlength="80" />', "\n",
                '<input type="submit" value="שמור" name="submitbutton" /></p>', "\n",
                "</form>\n";
            }
            /***************************************************************************************/
            echo '</div>';


        }//end else

    }//end if
//echo '</fieldset class="my_pageCount" >';
}//end validate_ajx
    /************************************************************************************************************/
    // save input data

    function print_form_paging_b($decID = "")
    {
        global $db;


        echo '<div id="my_paging_b">';
        $sql = "SELECT decName, decID, parentDecID FROM decisions ORDER BY decName";
        if ($rows = $db->queryObjectArray($sql)) {

            $parent = array();
            foreach ($rows as $row) {
                $subcats[$row->parentDecID][] = $row->decID;
                $catNames[$row->decID] = $row->decName;
                $parent[$row->decID][] = $row->parentDecID;
            }

            // build hierarchical list
            echo '<ul class="paginated">';
            echo '<fieldset class="my_pageCount" style="margin-right:-30px;">';

            if (!is_numeric($decID)) {
                $this->print_categories_paging_b($subcats[NULL], $subcats, $catNames, $parent);
            } else {
                $this->print_categories_paging_link2_b($subcats[NULL], $subcats, $catNames, $parent, $decID);
            }
            echo '</fielset></ul class="paginated">';


// printf("<p><br/>%s<br/>%s<br/></p>\n",
//    build_href2("../admin/mult_dec_ajx.php","", "", "הוסף החלטה חדשה","class=href_modal1"),
//    build_href2("../admin/find3.php", "","", "חפש החלטות","class=href_modal1"));
        }
    }

    /**********************************************************************************************/

    function print_categories_paging_b($catIDs, $subcats, $catNames, $parent)
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
        /*********************************************/

        if ($level) {


            echo '<ul>';
            foreach ($catIDs as $catID) {
                $url = "../admin/find3.php?decID=$catID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1  id="' . $catID . '" ';
                if ($catID == 11) {
                    printf("<li  id=li$catID style='font-weight:bold;color:red;font-size:20px;cursor:pointer;'  onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '17px')\"><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s)</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/mult_dec_ajx.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"));

                } elseif ($parent[$catID][0] == '11' && !(array_item($subcats, $catID))) {

                    printf("<li id=li$catID class='li_page' style='font-weight:bold;cursor:pointer;color:black;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/mult_dec_ajx.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5b.php", "mode=delete", "&deleteID=$catID", "מחק", "class=href_modal1"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } elseif ($parent[$catID][0] == '11' && array_item($subcats, $catID)) {
                    printf("<li id=li$catID class='li_page' style='font-weight:bold;cursor:pointer;color:black;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/mult_dec_ajx.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5b.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } else {
                    printf("<li id=li$catID  style='font-weight:bold;cursor:pointer;color:black;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s, %s,%s,%s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("../admin/mult_dec_ajx.php", "mode=insert", "&insertID=$catID", "הוסף", "class=href_modal1"),
                        build_href2("../admin/dynamic_5b.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                        build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                }


                if (array_key_exists($catID, $subcats))
                    $this->print_categories_paging_b($subcats[$catID], $subcats, $catNames, $parent);
            }
            echo "</li></ul>\n";


////////////////////////
        } elseif (!($level)) {///
//////////////////////


            echo '<ul>';
            foreach ($catIDs as $catID) {
                $url = "../admin/find3.php?decID=$catID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1  id="' . $catID . '" ';
                if ($catID == 11) {

                    //printf("<li  id=li$catID    onMouseOver=\"document.all.li$catID.style.color='brown'\"  onMouseOut=\"document.all.li$catID.style.color='black'\"  ><img src='".TAMPLATE_IMAGES_DIR."/star.gif'><b>%s (%s, %s)</b></li>\n",
                    printf("<li  id=li$catID style='font-weight:bold;color:red;font-size:17px;cursor:pointer;'  onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','red').css('font-size', '17px')\"><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]));


                } elseif ($parent[$catID][0] == '11' && !(array_item($subcats, $catID))) {

                    printf("<li id=li$catID class='li_page' style='font-weight:bold;cursor:pointer;color:black;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b></li>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "מידע  מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));


                } elseif ($parent[$catID][0] == '11' && array_item($subcats, $catID)) {
                    printf("<li  id=li$catID class='li_page' style='font-weight:bold;cursor:pointer;color:black;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"\"><b>%s (%s, %s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "מידע  מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                } else {
                    printf("<li id=li$catID  style='font-weight:bold;cursor:pointer;color:black;' onMouseOver=\"$('#li'+$catID).css('color','brown').css('font-size', '17px')\"  onMouseOut=\"$('#li'+$catID).css('color','black').css('font-size', '15px')\"><b>%s (%s, %s)</b>\n",
                        htmlspecial_utf8($catNames[$catID]),
                        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "מידע  מורחב", "class=href_modal1"),
                        build_href5("", "", "הראה נתונים", $str));
                }


                if (array_key_exists($catID, $subcats))
                    $this->print_categories_paging_b($subcats[$catID], $subcats, $catNames, $parent);
            }
            echo "</li></ul>\n";


        }


//////////////
    }


    /***************************************************************************************************/
    //update a new category in the categories table
    //======================================================
    // returns -1, if error
    //         1,  if category could be saved
    //         0,  if category could not be saved

    function print_categories_paging_link2_b($catIDs, $subcats, $catNames, $parent, $decID)
    {
        echo '<ul>';
        foreach ($catIDs as $catID) {
            $url = "../admin/find3.php?decID=$catID";
            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 id="' . $catID . '" ';
            if ($catID == 11) {
                printf("<li style='font-weight :bold;'><img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s)</b></li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("mult_dec_ajx.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"));

            } elseif ($parent[$catID][0] == '11' && !(array_item($subcats, $catID))) {

                printf("<li class='li_page' style='font-weight :bold;'><b>%s (%s, %s, %s,%s,%s)</b></li>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("dynamic_5b.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("../admin/dynamic_5b.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                    build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                    build_href5("", "", "הראה נתונים", $str));

            } elseif ($parent[$catID][0] == '11' && array_item($subcats, $catID)) {
                printf("<li class='li_page' style='font-weight :bold;'><b>%s (%s, %s, %s,%s,%s)</b>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("dynamic_5b.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("../admin/dynamic_5b.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                    build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                    build_href5("", "", "הראה נתונים
      
      
      
      
      
      
      ", $str));
            } else {
                printf("<li style='font-weight :bold;'><b>%s (%s, %s, %s,%s,%s)</b>\n",
                    htmlspecial_utf8($catNames[$catID]),
                    build_href2("dynamic_5b.php", "mode=link_second", "&insertID=$catID&decID=$decID", "קשר אליי", "class=href_modal1"),
                    build_href2("../admin/dynamic_5b.php", "mode=delete", "&deleteID=$catID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$catID", "עדכן", "class=href_modal1"),
                    build_href2("dynamic_5b.php", "mode=read_data", "&editID=$catID", "עידכון מורחב", "class=href_modal1"),
                    build_href5("", "", "הראה נתונים", $str));
            }


            if (array_key_exists($catID, $subcats))
                $this->print_categories_paging_link2_b($subcats[$catID], $subcats, $catNames, $parent, $decID);
        }
        echo "</li></ul>\n";
    }
    /*************************************************************************************************/


    // update new subcategories to given category

    function insert4()
    {
        global $db;

        $fields = $this->table . "_id, ";
        $fields .= join(", ", array_keys($this->fields));

        $inspoints = array("0");
        foreach (array_keys($this->fields) as $field)
            $inspoints [] = "?";
        $inspt = join(", ", $inspoints);

        $sql = "INSERT INTO " . $this->table .
            " ( $fields ) VALUES ( $inspt )";

        $values = array();
        foreach (array_keys($this->fields) as $field)
            $values [] = $this->fields[$field];

        $sth = $db->prepare($sql);
        $db->execute($sth, $values);

        $res = $db->query("SELECT last_insert_id()");
        $res->fetchInto($row);
        $this->id = $row[0];
        return $row[0];
    }

//===================================================================================

//    function insert()
//    {
//        global $db;
//        //$db->getMysqli();
//        $fields = $this->table . "_id, ";
//        $fields .= join(", ", array_keys($this->fields));
//        //$this->fields=$fields;
//        $inspoints = array("0");
//        foreach (array_keys($this->fields) as $field)
//            $inspoints [] = $this->fields[$field];// "?";
//        $this->fields = $inspoints;
//        //$inspt=$fields;
//        $inspt = join(", ", $inspoints);
//        $inspt = join(",", $this->quoteColumnVals());
//        $sql = "INSERT INTO " . $this->table .
//            " ( $fields ) VALUES ( $inspt)";
//
//        $db->queryArray($sql);
//        // return $row[0];
//        return $db->insertId();
//
//    }


//===================================================================================

    public function quoteColumnVals()
    {
        global $db;

        $vals = array();
        if (is_array($vals)) {
            if (get_magic_quotes_gpc())
                while ($i = each($formdata))
                    $vals[$i[0]] = stripslashes($i[1]);
        }
        foreach ($this->fields as $key => $val)
            $vals[$key] = is_null($val) ? 'NULL' : "'$val'";
        return $vals;
    }

    /**********************************************************************************************/

//    function insert2()
//    {
//        global $db;
//
//        $fields = $this->table . "_id, ";
//        $fields .= join(", ", array_keys($this->fields));
//
//        $inspoints = array("0");
//        foreach (array_keys($this->fields) as $field)
//            $inspoints [] = "?";
//        $inspt = join(", ", $inspoints);
//
//        $sql = "INSERT INTO " . $this->table .
//            " ( $fields ) VALUES ( $inspt )";
//
//        $values = array();
//        foreach (array_keys($this->fields) as $field) {
//            $values [] = $this->fields[$field];
//            $val .= $this->fields[$field] . ",";
//
//        }
//        //    $sth = $db->getMysqli()->prepare( $sql );
//        //    $db->execute( $sth, $values );
//        $stmt = $db->getMysqli()->stmt_init();
//        //var_dump($stmt);
//        $row = $stmt->prepare($sql);
//        //$row=$stmt->bind_param("s",$values);
//        $x = $stmt->bind_param('sss', $values[sizeof]);//, $values[1], $values[2]);
//        printf("%d Row inserted.\n", $stmt->affected_rows);
//        $stmt->execute();
//        //$stmt->bind_result($values);
//        //$stmt->fetch();
//        // $res = $db->getMysqli()->insert_id;//query( "SELECT last_insert_id()" );
//        //$res->fetchInto( $row );
//        //$res=$db->getMysqli()->fetch_row();
//        //    $this->id = $row[0];
//        //    return $row[0];
//        //printf ("New Record has id %d.\n", mysqli_insert_id($link));
//
//        return $stmt->insert_id;
//    }

    /**********************************************************************************************/

    function insert_dec($formdata)
    {
        $dec = explode(";", $formdata["newforum"]);
        global $db;
        // insert new decision
        //==============================================================
        $sql = "INSERT INTO decisions ( decName,parentDecID,parentDecID1 " .
            "status,dec_date) VALUES (" .
            $db->sql_string($formdata["decName"]) . ", " .
            $db->ID_or_NULL($formdata["parentDecID"]) . ", " .
            $db->ID_or_NULL($formdata["parentDecID1"]) . ", " .
            $this->num_or_NULL($formdata["status"]) . "," .

            $this->num_or_NULL($formdata["time"]) . " ) ";

        if (!$db->execute($sql))

            return FALSE;

        return $db->insertId();
        // return $formdata;
    }

    /**********************************************************************************************/

    function add_decision(&$formdata = "", &$forumsIDs = "", &$catsIDs = "", &$dateIDs = "")
    {

        if (isset($formdata['insertID']) && $formdata['insertID'])
            $insertID = $formdata['insertID'];
        elseif (isset($_GET['insertID']) && $_GET['insertID'])
            $insertID = $this->insertID;
        else {
            $insertID = '11';
            $formdata['insertID'] = '11';
        }
        if (isset($formdata['submitbutton']) && $formdata['submitbutton'])
            $submitbutton = $formdata['submitbutton'];
        else
            $submitbutton = $this->submitbutton;
        if (isset($formdata['subcategories']) && $formdata['subcategories'])
            $subcategories = $formdata['subcategories'];
        else
            $subcategories = $this->subcategories;
        global $db;


        $sql = "SELECT COUNT(*) FROM decisions WHERE decID='$insertID'";
        $n = $db->querySingleItem($sql);


        if (!($insertID && $n == 1)) {
            return false;
        } else {
            echo "<h1>הוסף החלטה חדשה</h1>\n";


            if (isset($subcategories) && $subcategories) {
                $db->execute("START TRANSACTION");
                if ($this->insert_new_decisions($insertID, $subcategories, $formdata, $forumsIDs, $catsIDs, $dateIDs)) {


                    //$db->execute("COMMIT");
                } else {
                    $db->execute("ROLLBACK");
                    return FALSE;
                }

            }


        }

        return true;

    }
    /**********************************************************************/
    // test if variable insertID was set to a valid value

    function insert_new_decisions($insertID, $subcategories, &$formdata, &$forumsIDs = "", &$catIDs = "", &$dateIDs = "")
    {
        global $db;


        $subcatarray = explode(";", $subcategories);
        $vote_level = $formdata['vote_level'];
        $dec_level = $formdata['dec_level'];


        $decAllowed = $formdata['dec_Allowed'];
        if ($formdata['dec_Allowed'] == 1)
            $decAllowed = 'public';
        elseif ($formdata['dec_Allowed'] == 2)
            $decAllowed = 'private';
        elseif ($formdata['dec_Allowed'] == 3)
            $decAllowed = 'top_secret';
        $decAllowed = $db->sql_string($decAllowed);


        $status = $formdata['dec_status'];


//		$status1      = explode(";" , $formdata['dec_status']);

        $forum_decUser = array();
        $count = 0;
        $nameArray = 0;


        $size_of_decision = count($subcatarray);
        $size_of_dec = count($subcatarray);

        $size_of_forum = count($forumsIDs);
        $size_of_array = count($forumsIDs);

        $size_of_array_cat = count($catIDs);
        $size_of_array_date = count($dateIDs);

        $size_of_vote_level = count($vote_level);
        $size_of_dec_level = count($dec_level);

        $i = 0;
        $i_frm = 0;
        $j_catIdx = 0;

        $k = 0;
        $m_catIdx = 0;
        $n = 0;

        $x_vote = 0;
        $y_level = 0;
        $z = 0;

        /****************************************************/
        foreach ($subcatarray as $newdecname) {
            /****************************************************/


            if ($x_vote == $size_of_vote_level) {
                $x_vote = $size_of_vote_level - 1;
            }
            $vote_level1 = $vote_level[$x_vote];
            /**********************************************************************************/
            if ($y_level == $size_of_dec_level) {
                $y_level = $size_of_dec_level - 1;
            }
            $dec_level1 = $dec_level [$y_level];
            /**********************************************************************************/
            $vote_level_sql = is_null($dec_level) ? 'NULL' : "'$vote_level1'";
            $dec_level_sql = is_null($dec_level) ? 'NULL' : "'$dec_level1'";

//			$vote_level_sql= $dec_level1 ;
//		    $dec_level_sql =$dec_level1 ;

            /**********************************************************************************/
            if ($n == $size_of_array_date) $n = $size_of_array_date - 1;
            /**********************************************************************************/
            if (array_item($formdata, 'multi_year') && is_numeric($formdata['multi_year'][$n])) {


                $dec_date = $dateIDs[$n];
                $this->dec_Date = $dec_date;
                $dec_date = $db->sql_string($dec_date);


                $formdata['year_date'] = $formdata['multi_year'][$n];
                $formdata['month_date'] = $formdata['multi_month'][$n];
                $formdata['day_date'] = $formdata['multi_day'][$n++];
            } elseif (array_item($formdata, 'dec_date')) {
                /***********************************************************************************/
                list($year_date_dec, $month_date_dec, $day_date_dec) = explode('-', $formdata['dec_date']);
                if (strlen($year_date_dec) < 3) {
                    $formdata['dec_date'] = "$day_date_dec-$month_date_dec-$year_date_dec";
                } elseif (strlen($day_date_dec) == 4) {
                    $formdata['dec_date'] = "$day_date_dec-$month_date_dec-$year_date_dec";
                }
                $dec_date = $db->sql_string($formdata['dec_date']);
                /**********************************************************************************/

            } else {
                $dateIDs['full_date'] = $dateIDs['full_date'] ? $dateIDs['full_date'] : $formdata['dec_date'];
                $dec_date = $dateIDs['full_date'];
                $this->dec_Date = $dec_date;
            }

            /**********************************************************************************/
            $result = $this->insert_new_decision($insertID, trim($newdecname), $status, $dec_date, $vote_level_sql, $dec_level_sql, $decAllowed);
            if ($result == -1) {
                echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
                return FALSE;
            } elseif ($result) {

                $count++;
                $formdata['decID'] = $db->insertId();
                $decID = $formdata['decID'];
                /************************************************************************************/

                /***************************CONN MANY_FORUM+MANY CATEGORIES TO ONE DECISION*******************************************************/
                if ((($size_of_dec == 1) && ($size_of_dec < $size_of_forum))
                    || (($size_of_dec == 1) && ($size_of_dec < $size_of_array_cat))
                ) {
                    /************************************************************************************/
                    if ($size_of_forum > $size_of_array_cat) {

                        for ($forum = 0; $forum < $size_of_forum; $forum++) {//CATEGORIES DEPAND ON FORUM NUMBER
                            $forum_decUser[$forum] = $this->conn_forum_dec1($decID, $forumsIDs[$forum]);

                            if ($forum <= $size_of_array_cat - 1) {
                                $this->conn_cat_dec1($decID, $catIDs[$forum], $formdata);
                            }
                        }
                        /************************************************************************************/

                    } elseif ($size_of_forum < $size_of_array_cat) {
                        for ($cat = 0; $cat < $size_of_array_cat; $cat++) {
                            $this->conn_cat_dec1($decID, $catIDs[$cat], $formdata);
                            if ($cat <= $size_of_forum - 1) {
                                if(isset($forum))
                                $forum_decUser["$forum"] = $this->conn_forum_dec1($decID, $forumsIDs[$cat]);
                            }
                        }
                        /************************************************************************************/
                    } elseif ($size_of_forum == $size_of_array_cat) {
                        for ($forum = 0; $forum < $size_of_forum; $forum++) {
                            $forum_decUser[$forum] = $this->conn_forum_dec1($decID, $forumsIDs[$forum]);
                            $this->conn_cat_dec1($decID, $catIDs[$forum], $formdata);
                        }
                    }


                } else {
                    if ($size_of_forum == 1) {
                        $forum_decUser[0] = $this->conn_forum_dec($decID, $forumsIDs);
                    } else {
                        $forum_decUser[0] = $this->conn_forum_dec1($decID, $forumsIDs[$i++]);//return array of user+HD+FRM


                        if ($i == $size_of_forum) {
                            $i = $size_of_forum - 1;
                        }
                    }

                    /**********************************************************************************/
                    if ($size_of_array_cat == 1) {
                        $this->conn_cat_dec($decID, $catIDs, $formdata);
                    } else {
                        $this->conn_cat_dec1($decID, $catIDs[$j_catIdx++], $formdata);
                        if ($j_catIdx == $size_of_array_cat) {
                            $j_catIdx = $size_of_array_cat - 1;
                        }
                    }

                }
                /**********************************************************************************/
                if (!isset($formdata['dynamic_5b'])) {
                    $this->message_save($subcatarray[$nameArray], $decID);
                }


                if (($size_of_decision > 1 && $size_of_forum > 1) && ($size_of_decision <= $size_of_forum || $size_of_decision >= $size_of_forum)) {

                    $formdata['single_frm'] = 1; //send couple of form each form with a single forum
                }
                /**********************************************************************************/
                $formdata['subcategories'] = $newdecname;
                $form = $formdata;
                $form['count'] = $count;
                /********************************************************************************/
                if ($k == $size_of_forum) {
                    $k = $size_of_forum - 1;
                }


////////////////////////////////////TEST////////////////////////////////////////////////////
                if (isset($formdata['single_frm']) && $formdata['single_frm']) {

                    $frm_id = $forumsIDs[$k++];


                    unset($form["dest_forums"]);
                    $form['dest_forums'][0] = $frm_id;//saperated array of forums
                    $form['forum_decision'] = $frm_id;//$rows[0]->forum_decID;

///******************************************************************************************/
                    if ($m_catIdx == $size_of_array_cat) {
                        $m_catIdx = $size_of_array_cat - 1;
                    }

                    $cat_id = $catIDs[$m_catIdx++];
                    unset($form["dest_decisionsType"]);
                    $form['dest_decisionsType'][0] = $cat_id;//$catNames;
                }
/////////////////////////////////////////////////////////////////////////////////////////


                /********************************************************************************************/

                $form['vote_level'] = $vote_level1;
                $x_vote++;

                /********************************************************************************************/

                $form['dec_level'] = $dec_level1;
                $y_level++;

                /********************************************************************************************/

                //$form['dec_status']=$status1[$z++] ;
                $form['dec_status'] = $status;
                /********************************************************************************************/
                $form['dest_users'] = $forum_decUser;
                /********************************************************************************************/
                if (empty($formdata['dynamic_5b']) ) {
                    //	$this->print_decision_entry_form1($form['decID']);
                }

                if (!empty($formdata['dynamic_5b']) && (count($subcatarray) < 2)) {

                    /****************************************************************************/
                    if (!($form["dec_date"]))
                        $form["dec_date"] = substr($dec_date, 0, 10);

                    $db->execute("COMMIT");
                    //	$this->print_decision_entry_form1_b($form['decID']);
                    $this->message_save_b($subcatarray[$nameArray], $decID);
                    build_form_dec_ajx($form);
                    /***********************************************************************************/
                } elseif (!empty($formdata['dynamic_5b']) && (count($subcatarray) >= 2)) {//multiple decisions
                    if (!($form["dec_date$decID"])
                        && $form['multi_year'][0] && $form['multi_year'][0] != 'none'
                        && $form['multi_month'][0] && $form['multi_month'][0] != 'none'
                        && $form['multi_day'][0] && $form['multi_day'][0] != 'none'
                    ) {
                        $form["dec_date$decID"] = substr($dec_date, 1, 10);
                    } else {
                        $form["dec_date$decID"] = substr($dec_date, 1, 10);
                    }
                    $form["dest_user$decID"] = $form['dest_users'];
                    unset($form['dest_users']);
                    $db->execute("COMMIT");
                    //$this->print_decision_entry_form1_b($form['decID']);
                    $this->message_save_b($subcatarray[$nameArray], $decID);
                    build_form_dec_ajxMult($form);
                }
                else {
                    if (!($form['dec_date']))
                        $form['dec_date'] = substr($dec_date, 0, 10);
                    $db->execute("COMMIT");
                    build_form($form);
                }
                $nameArray++;
            }
        }
        return TRUE;
    }
    /******************************************************************************************************/

    // insert new subcategories to given category

    function insert_new_decision($insertID, $newdecName, $status, $dec_date, $vote_level, $dec_level, $decAllowed)
    {
        global $db;
        // test if newcatName is empty
        if (!$newdecName) return 0;
        $newdecName = $db->sql_string($newdecName);

        // test if newcatName already exists
        $sql = "SELECT COUNT(*) FROM decisions " .
            "WHERE parentDecID=$insertID " .
            "  AND decName=$newdecName";
        //  if($db->querySingleItem($sql)>0) {
        //  	echo " כבר קיימת החלטה בשם הזה";
        //    return 0;
        //  }
         $this->conn_forum_dec($newdecName, $insertID);
          $this->conn_cat_dec($newdecName, $insertID);

        $sql = "INSERT INTO decisions ( parentDecID, decName,status,dec_date, vote_level, dec_level,dec_allowed) " .
            "VALUES ($insertID,$newdecName,$status,$dec_date,$vote_level, $dec_level,$decAllowed)";
        if ($db->execute($sql))
            return 1;
        else
            return -1;


    }
    /*******************************************************************************************************/

    //($insertID, $newdecname,$status,$dec_date,$vote_level, $dec_level);

    function conn_forum_dec1($decID, $forumIDs)
    {
        global $db;


        $sql = "SELECT managerID FROM forum_dec WHERE forum_decID=$forumIDs ";
        if ($getMgr = $db->queryObjectArray($sql)) {

            $managerID = $getMgr[0]->managerID;

        }


        $user_forum = '';
        // connect forum and decision
        $sql = "INSERT INTO rel_forum_dec (decID,forum_decID,dec_managerID) " .
            "VALUES ($decID, $forumIDs,$managerID)";


        if (!$db->execute($sql))
            return FALSE;


        $sql = "select userID,HireDate,forum_decID from rel_user_forum WHERE forum_decID=$forumIDs AND active=2";

        if ($rows = $db->queryObjectArray($sql)) {//if this forum has users
            $user_forum = $rows;
            foreach ($rows as $row) {
                if ($row->HireDate) {
                    $hire_date = $row->HireDate;
                    $hire_date = $db->sql_string($hire_date);
                    $sql = "INSERT INTO rel_user_Decforum (decID,forum_decID,userID,HireDate) " .
                        "VALUES ($decID, $forumIDs,$row->userID,$hire_date)";
                } else {
                    $sql = "INSERT INTO rel_user_Decforum (decID,forum_decID,userID) " .
                        "VALUES ($decID, $forumIDs,$row->userID)";
                }
                if (!$db->execute($sql))
                    return FALSE;

            }//end foreach

        }//end if


        if ($user_forum && $user_forum != '') {
            return $user_forum;
        }
        return true;
    }

    /**********************************************************************************************/

    function conn_cat_dec1($decID, $catIDs, $formdata = "")
    {
        global $db;


        $sql = "SELECT  catName,catID,parentCatID FROM categories WHERE catID =$catIDs ";

        //$db->sql_string($formdata['category']);

        $rows = $db->queryObjectArray($sql);

        if ($rows) {
            // existing category
            //===================
            $parnetCatID = $rows[0]->parentCatID;

            // var_dump($sql);die;
        }

        // connect category and decision
        //foreach($catIDs as $catID) {

        $sql = "INSERT INTO rel_cat_dec (decID,catID,parentCatID) " .
            "VALUES ($decID,$catIDs,$parnetCatID)";

        //echo $sql; die;
        if (!$db->execute($sql))
            return FALSE;

        //}
        return true;
    }

    /**********************************************************************************/

    /* createSetStatement: convert an array into a string of the form col_name='value'", sutable for an "INSERT INTO tbl_name SET" query */

    function conn_forum_dec($decID, $forumIDs, $mode = "", $DecFrm_note = "", &$formdata = "")
    {
        global $db;
        if ($mode == 'update') {//case update

            $frmNames_dest = Array();
            $frmNames_src = Array();

//------------------------------------------------------------------------------------------
            //$formdata["dest_forums"]
//------------------------------------------------------------------------------------------
            $i = 0;

            if ($formdata["dest_forums$decID"] && $formdata["dest_forums$decID"] != 'none' && is_array($formdata["dest_forums$decID"])) {
                foreach ($formdata["dest_forums$decID"] as $forum) {
                    if ($i == 0)
                        $frm_dest = $forum;
                    else
                        $frm_dest .= "," . $forum;
                    $i++;
                }
            }

            if ($formdata["src_forums$decID"] && $formdata["src_forums$decID"] != 'none' && is_array($formdata["src_forums$decID"])) {
                $i = 0;
                foreach ($formdata["src_forums$decID"] as $forum) {
                    if ($i == 0)
                        $frm_src = $forum;
                    else
                        $frm_src .= "," . $forum;
                    $i++;
                }
            }


            if ($formdata["dest_forums"] && $formdata["dest_forums"] != 'none' && is_array($formdata["dest_forums"])) {
                $i = 0;
                foreach ($formdata["dest_forums"] as $forum) {
                    if ($i == 0)
                        $frm_dest = $forum;
                    else
                        $frm_dest .= "," . $forum;
                    $i++;
                }
            }

            if ($formdata["src_forums"] && $formdata["src_forums"] != 'none' && is_array($formdata["src_forums"])) {
                $i = 0;
                foreach ($formdata["src_forums"] as $forum) {
                    if ($i == 0)
                        $frm_src = $forum;
                    else
                        $frm_src .= "," . $forum;
                    $i++;
                }
            }

//------------------------------------------------------------------------------------------
            //make assosc
//-------------------------------------ASSOC-----------------------------------------------------
            if ($frm_dest) {
                $sql1 = "select forum_decID,forum_decName from forum_dec WHERE forum_decID in($frm_dest)";
                if ($rows = $db->queryObjectArray($sql1)) {
                    foreach ($rows as $row) {

                        $frmNames_dest[$row->forum_decID] = $row->forum_decName;
                    }
                }
            }
//--------------------------------------ASSOC----------------------------------------------------
            if ($frm_src) {
                $sql2 = "select forum_decID,forum_decName from forum_dec WHERE forum_decID in($frm_src)";
                if ($rows = $db->queryObjectArray($sql2)) {
                    foreach ($rows as $row) {

                        $frmNames_src[$row->forum_decID] = $row->forum_decName;
                    }
                }
            }
//------------------------------------------------------------------------------------------
            //UNSET
//------------------------------------------------------------------------------------------

            $i = 0;
            if ($frmNames_src
                && $frmNames_src != 'none'
                && is_array($frmNames_src)
                && (count($frmNames_src) > 0)
                && $frmNames_dest
                && $frmNames_dest != 'none'
                && is_array($frmNames_dest)
                && (count($frmNames_dest) > 0)
                && (count($frmNames_dest)) >= (count($frmNames_src))
            ) {

                foreach ($frmNames_dest as $key => $val) {

                    if (in_array($val, $frmNames_src)) {

                        unset($frmNames_dest[$key]);
                        unset($frmNames_src[$key]);//delete only users_forums  added or take out from rel_user_Decforum
                    }

                    $i++;
                }
            } elseif ($frmNames_src
                && $frmNames_src != 'none'
                && is_array($frmNames_src)
                && count($frmNames_src) > 0
                && $frmNames_dest
                && $frmNames_dest != 'none'
                && is_array($frmNames_dest)
                && (count($frmNames_dest) > 0)
                && (count($frmNames_dest)) < (count($frmNames_src))
            ) {

                foreach ($frmNames_src as $key => $val) {

                    if (in_array($val, $frmNames_dest)) {

                        unset($frmNames_src[$key]);
                        unset($frmNames_dest[$key]);//delete only users_forums  added or take out from rel_user_Decforum
                    }

                    $i++;
                }


            }

//------------------------------------------------------------------------------------------
            //delete all the chain
//TRUNCATE TABLE  tag2task
//TRUNCATE TABLE  tags
//TRUNCATE TABLE rel_user_task
//TRUNCATE TABLE todolist
//------------------------------------------------------------------------------------------
            if (is_array($frmNames_src) && (count($frmNames_src) > 0)) {

                foreach ($frmNames_src as $key => $val) {
                    $sql = "DELETE FROM rel_forum_dec WHERE decID=$decID and forum_decID=$key ";
                    if (!($db->execute($sql)))
                        return FALSE;


                    $sql = "UPDATE forum_dec SET duedate=NULL WHERE forum_decID=$key ";

                    if (!($db->execute($sql)))
                        return false;

///////////////////////////////////////////////DELETE FROM TODOLIST////////////////////////////////////////////
                    $task_sql = "select taskID from todolist where decID=$decID AND  forum_decID=$key ";
                    if ($rows_task = $db->queryObjectArray($task_sql)) {


                        for ($i = 0; $i < count($rows_task); $i++) {
                            if ($i == 0) {
                                $taskIDs = $rows_task[$i]->taskID;
                            } else {
                                $taskIDs .= "," . $rows_task[$i]->taskID;

                            }

                        }


/////////////////////////////////////////////DELETE/UPADATE TAG////////////////////////////////////////////


                        $tag_sql = "select * from tag2task where taskID in($taskIDs)";
                        if ($rows = $db->queryObjectArray($tag_sql)) {

                            for ($i = 0; $i < count($rows); $i++) {
                                if ($i == 0) {
                                    $tag_taskIDs = $rows[$i]->tagID;
                                } else {
                                    $tag_taskIDs .= "," . $rows[$i]->tagID;

                                }

                            }
                            $tag_taskIDs = explode(',', $tag_taskIDs);
                            $tag_taskIDs = array_unique($tag_taskIDs);
                            $tag_taskIDs = implode(',', $tag_taskIDs);
                            $db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($tag_taskIDs)");
                            //	$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags


                        }


                        ////////////////////////////////////////////////DELETE TASK FROM tag2task//////////////////////////////////////////

                        $tag_task_sql = "select taskID  from tag2task where taskID in ($taskIDs) ";
                        if ($rows_tag2task = $db->queryObjectArray($tag_task_sql)) {


                            for ($i = 0; $i < count($rows_tag2task); $i++) {
                                if ($i == 0) {
                                    $tag2taskIDs = $rows_tag2task[$i]->taskID;
                                } else {
                                    $tag2taskIDs .= "," . $rows_tag2task[$i]->taskID;

                                }

                            }


                            $sql5 = "DELETE FROM tag2task WHERE taskID in($tag2taskIDs)";

                            if (!$db->execute($sql5))
                                return FALSE;
                            $db->execute("DELETE FROM tags WHERE tags_count < 1");    # slow on large amount of tags
                        }

////////////////////////////////////////////////DELETE  FROM rel_user_task//////////////////////////////////////////
                        $user_task_sql = "SELECT taskID  FROM rel_user_task WHERE decID=$decID AND forum_decID=$key ";
                        if ($rows_user_task = $db->queryObjectArray($user_task_sql)) {


                            $user_task_sql_del = "DELETE FROM rel_user_task WHERE decID=$decID AND forum_decID=$key ";

                            if (!$db->execute($user_task_sql_del))
                                return FALSE;

                        }

                        $sql4 = "DELETE FROM todolist WHERE   decID=$decID AND forum_decID=$key  ";
                        if (!$db->execute($sql4))
                            return FALSE;

                    }//end if rows in todolist
                }//end foreach


//-----------------------------------------------------------------------------------------------

////////////////////////////////////////////DELETE EVENT FROM EVENT////////////////////////////////////////////
                $event_sql = "SELECT id FROM rel_user_event WHERE decID=$decID AND  forum_decID=$key ";

                if ($rows = $db->queryObjectArray($sql)) {

                    for ($i = 0; $i < count($rows); $i++) {
                        if ($i == 0) {
                            $eventIDs = $rows[$i]->id;
                        } else {
                            $eventIDs .= "," . $rows[$i]->id;

                        }

                    }
                    $sql = "DELETE FROM rel_user_event WHERE decID=$decID AND  forum_decID=$key ";
                    if (!$db->execute($sql))
                        return FALSE;


                    $event_sqlDel = "DELETE FROM event WHERE id in($eventIDs)  ";
                    if (!$db->execute($event_sqlDel))
                        return FALSE;
                }


//------------------------------------------------------------------------------------------
            }//end src                        //conn the forums
//------------------------------------------------------------------------------------------

            if ($frmNames_dest && $frmNames_dest != 'none' && (is_array($frmNames_dest)) && (count($frmNames_dest) > 0)) {


                foreach ($frmNames_dest as $key => $val) {

                    $sql = "SELECT managerID FROM forum_dec WHERE forum_decID=$key ";
                    if ($getMgr = $db->queryObjectArray($sql)) {

                        $managerID = $getMgr[0]->managerID;

                    }
                    $note = $DecFrm_note[$forum_decID];

                    if (!($note)) {
                        $sql = "INSERT INTO rel_forum_dec (decID,forum_decID,dec_managerID  ) " .
                            "VALUES ($decID, $key,$managerID )";

                    } else {
                        $note = $db->sql_string($note);
                        $sql = "INSERT INTO rel_forum_dec (decID,forum_decID,note,dec_managerID    ) " .
                            "VALUES ($decID, $key ,$note,$managerID )";
                    }
                    //echo $sql; die;
                    if (!$db->execute($sql))
                        return FALSE;
                    /***************************/
                }//end foreach
                /**************************/
            }
//////////////////////////
        } else {//case save////////
////////////////////////
            foreach ($forumIDs as $forum_decID) {

                $sql = "SELECT managerID FROM forum_dec WHERE forum_decID=$forum_decID ";
                if ($getMgr = $db->queryObjectArray($sql)) {

                    $managerID = $getMgr[0]->managerID;

                }

                $sql = "INSERT INTO rel_forum_dec (decID,forum_decID,dec_managerID   ) " .
                    "VALUES ($decID, $forum_decID,$managerID )";
                if (!$db->execute($sql))
                    return FALSE;

            }//end foreach


            $user_forum = '';
            foreach ($forumIDs as $forum_decID) {
                $sql = "select userID,HireDate,forum_decID from rel_user_forum WHERE forum_decID=$forum_decID AND active=2 ";

                if ($rows = $db->queryObjectArray($sql)) {
                    $user_forum = $rows;
                    foreach ($rows as $row) {
                        if ($row->HireDate) {
                            $hire_date = $row->HireDate;
                            $hire_date = $db->sql_string($hire_date);
                            $sql = "INSERT INTO rel_user_Decforum (decID,forum_decID,userID,HireDate) " .
                                "VALUES ($decID, $forum_decID,$row->userID,$hire_date)";
                        } else {
                            $sql = "INSERT INTO rel_user_Decforum (decID,forum_decID,userID) " .
                                "VALUES ($decID, $forum_decID,$row->userID)";
                        }
                        if (!$db->execute($sql))
                            return FALSE;

                    }//end foreach scond

                }//end if

            }//end foreach first


            /**************************************/
            if ($user_forum && $user_forum != '')
                return $user_forum;
            return true;


        }//end else case save
        return true;
    }


    /******************************************************************************************************/

    function conn_cat_dec($decID, $catIDs)
    {
        global $db;


        // connect category and decision
        foreach ($catIDs as $catID) {

            $sql = "INSERT INTO rel_cat_dec (decID,catID ) " .
                "VALUES ($decID,$catID )";

            //echo $sql; die;
            if (!$db->execute($sql))
                return FALSE;

        }
        return true;
    }

    /**********************************************************************************************/

    function message_save(&$subcatarray, $decID)
    {


        // message
        echo "<p>.נישמרה ההחלטה  ",
        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", $subcatarray),
        " </p>\n";
        return TRUE;
    }

    /**********************************************************************************************/

    function message_save_b(&$subcatarray, $decID)
    {


        // message
        echo "<p>.נישמרה ההחלטה  ",
        build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", $subcatarray),
        " </p>\n";
        return TRUE;
    }

    function createSetStatement($row)
    {
        // Oh! for efficient anonymous function support in PHP.

        foreach ($row as $col => $val) {
            $tmp[] = "$col='$val'";
        }
        return implode(', ', $tmp);
    }

    /********************************************************************************/
    // delete one decision
    //=======================================

    function delete()
    {
        global $db;
        $db->getMysqli();
        $sth = $db->prepare(
            'DELETE FROM ' . $this->table . ' WHERE ' .
            $this->table . '_id=?'
        );
        $db->execute($sth,
            array($this->id));
    }

    /**********************************************************************************/

    /****************************************************************************************/

    function delete_all()
    {
        global $db;
        $db->getMysqli();
        $query = ('DELETE FROM ' . $this->table);
        //$sth = $db->getMysqli()->prepare( 'DELETE FROM '.$this->table );
        //$db->execute( $sth );
        $db->execute($query);
    }

    /***************************************************************************************************/
    // delete a category
    // return  1, if category and its subcategories could be deleted
    // returns 0, if the category could not be deleted
    // return -1 if an error happens

    function delete1()
    {


        global $db;
        $query = "set foreign_key_checks=0";
        if ($db->execute($query))
            if ($db->execute("delete from  decisions where decID=" . $this->getId()))
                $db->execute("set foreign_key_checks=1");
            else
                $db->execute("set foreign_key_checks=1");
    }


    /*******************************************************************************************************/

    function getId()
    {
        return $this->decid;
    }


//$tmp=($formdata["forum_decision"][$i]) ? $formdata["forum_decision"][$i++] : $forums=explode(";", $formdata["newforum"] );


    /*******************************************************************************************************/

    public function setId($decid)
    {
        $this->decid = $decid;
    }

    /*******************************************************************************************************/

    function check(&$err_msg)
    {
        return 1;
        $err_msg = "";
        if (strlen($this->decName) < 1)
            $err_msg = "String too short";


        return $err_msg == "";
    }

    /***************************************************************************************************/
    /*******************************************************************************************************/

    function delete_decision($formdata)
    {
        global $db;

        if ((!$decID = array_item($formdata, "decID")) || !is_numeric($decID))
            return FALSE;

        $sql = "set foreign_key_checks=0";
        if ($db->execute($sql)) {
            $sql = "DELETE FROM decisions WHERE decID=$decID ";
            if (!$db->execute($sql)) {
                $db->execute("set foreign_key_checks=1");
                return FALSE;
            } else {
                $db->execute("set foreign_key_checks=1");

            }
        }
        /**************************************************************************/
        $sql = "set foreign_key_checks=0";
        if ($db->execute($sql)) {

            $sql = "DELETE FROM rel_forum_dec  WHERE  decID = $decID ";
            if (!$db->execute($sql)) {
                $db->execute("set foreign_key_checks=1");
                return FALSE;
            } else {
                $db->execute("set foreign_key_checks=1");

            }
        }
        /****************************************************************************/
        $sql = "set foreign_key_checks=0";
        if ($db->execute($sql)) {

            $sql = "DELETE FROM rel_cat_dec  WHERE  decID = $decID ";
            if (!$db->execute($sql)) {
                $db->execute("set foreign_key_checks=1");
                return FALSE;
            } else {
                $db->execute("set foreign_key_checks=1");

            }
        }
        /****************************************************************************/


        echo "<p>.החלטה אחת נימחקה</p>\n";
        echo "<p>חזרה אל ",
            build_href("dec_edit.php", "", "רשימת החלטות") . ".\n";
        $formdata = false;
        //  build_form($formdata);
        return true;
    }


    /***************************************************************************************************/

    /***************************************************************************************************/

    function del_decision($deleteID)
    {
        global $db;
        $sql = "SELECT COUNT(*) FROM decisions WHERE decID=$deleteID";
        if ($db->querySingleItem($sql) == 1) {
            $db->execute("START TRANSACTION");
            $query = "set foreign_key_checks=0";
            $db->execute($query);
            if ($this->delete_decision_sub($deleteID) == -1) {
                $db->execute("ROLLBACK");
                $db->execute("set foreign_key_checks=1");
            } else {
                $db->execute("COMMIT");
                $db->execute("set foreign_key_checks=1");
                echo "<p class='error'>נמחקה  החלטה.</p>\n";
                return true;
            }
        }

    }
    /***************************************************************************************************/


    /*******************************************************************************************************/

    function delete_decision_sub($decID)
    {
        // find subcategories to catID and delete them
        // by calling delete_category recursively
        global $db;
        $sql = "SELECT decID FROM decisions " .
            "WHERE parentdecID='$decID'";
        if ($rows = $db->queryObjectArray($sql)) {//if have a child
            $deletedRows = 0;
            foreach ($rows as $row) {
                $result = $this->delete_decision_sub($row->decID);
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
        if ($decID == 11) {
            echo "<br />אי אפשר למחוק שורש ההחלטות   .\n";
            return 0;
        }
////////////////////////////////////////////DELETE TASK FROM rel_userDecforum/////////////////////////////////////////////////////////////////////////////////////
//	   $sql8 = "DELETE FROM  rel_user_Decforum WHERE decID='$decID'  ";
//     	if(!$db->execute($sql8))
//   	    return -1;


        //TO_FIX  AFTER CHEKING


/////////////////////////////////////////////////DELETE FROM TODOLIST////////////////////////////////////////////
//$task_sql="select taskID from todolist where decID=$decID AND  forum_decID=$key ";
//		if($rows_task=$db->queryObjectArray($task_sql) ){
//
//
//
//		for($i=0; $i<count($rows_task); $i++){
//				if($i==0){
//					$taskIDs = $rows_task[$i]->taskID;
//				}
//				else{
//					$taskIDs .= "," . $rows_task[$i]->taskID;
//
//				}
//
//			}
//
//
//
//
//
///////////////////////////////////////////////DELETE/UPADATE TAG////////////////////////////////////////////
//
//
//        $tag_sql="select * from tag2task where taskID in($taskIDs)";
//   	    if($rows=$db->queryObjectArray  ($tag_sql)) {
//
//   	    for($i=0; $i<count($rows); $i++){
//				if($i==0){
//					$tag_taskIDs = $rows[$i]->tagID;
//				}
//				else{
//					$tag_taskIDs .= "," . $rows[$i]->tagID;
//
//				}
//
//			}
//		$tag_taskIDs=explode(',',$tag_taskIDs);
//   	    $tag_taskIDs=array_unique($tag_taskIDs);
//   	    $tag_taskIDs=implode(',',$tag_taskIDs);
//        $db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($tag_taskIDs)");
//	//	$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags
//
//
//
//
//  }
//
//
// ////////////////////////////////////////////////DELETE TASK FROM tag2task//////////////////////////////////////////
//
//  $tag_task_sql="select taskID  from tag2task where taskID in ($taskIDs) ";
//   	    if($rows_tag2task=$db->queryObjectArray($tag_task_sql) ){
//
//
//
//   	    for($i=0; $i<count($rows_tag2task); $i++){
//				if($i==0){
//					$tag2taskIDs = $rows_tag2task[$i]->taskID;
//				}
//				else{
//					$tag2taskIDs .= "," . $rows_tag2task[$i]->taskID;
//
//				}
//
//			}
//
//
//
//
//		$sql5="DELETE FROM tag2task WHERE taskID in($tag2taskIDs)";
//
//		if(!$db->execute($sql5))
//   	    return FALSE;
//		$db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags
//		}
//
//////////////////////////////////////////////////DELETE  FROM rel_user_task//////////////////////////////////////////
//$user_task_sql="SELECT taskID  FROM rel_user_task WHERE decID=$decID AND forum_decID=$key ";
//   	    if($rows_user_task=$db->queryObjectArray($user_task_sql) ){
//
//
//		$user_task_sql_del="DELETE FROM rel_user_task WHERE decID=$decID AND forum_decID=$key ";
//
//		if(!$db->execute($user_task_sql_del))
//   	    return FALSE;
//
//		}
//
// $sql4 = "DELETE FROM todolist WHERE   decID=$decID AND forum_decID=$key  ";
//     	if(!$db->execute($sql4))
//   	    return FALSE;
//
// }//end if rows in todolist


////////////////////////////////////////////DELETE TASK FROM TODOLIST/////////////////////////////////////////////////////////////////////////////////////
        $task_sql = "select taskID from todolist where decID='$decID' ";
        if ($rows_task = $db->queryObjectArray($task_sql)) {


            for ($i = 0; $i < count($rows_task); $i++) {
                if ($i == 0) {
                    $taskIDs = $rows_task[$i]->taskID;
                } else {
                    $taskIDs .= "," . $rows_task[$i]->taskID;

                }

            }


            $sql4 = "DELETE FROM todolist WHERE decID='$decID'  ";
            if (!$db->execute($sql4))
                return -1;


/////////////////////////////////////////////DELETE/UPADATE TAG/////////////////////////////////////////////////////////////////////////////

//   	    $tag_sql="select * from tag2task where taskID = any (SELECT taskID from todolist where taskID in($taskIDs))";
            $tag_sql = "select * from tag2task where taskID in($taskIDs)";
            if ($rows = $db->queryObjectArray($tag_sql)) {

                for ($i = 0; $i < count($rows); $i++) {
                    if ($i == 0) {
                        $tag_taskIDs = $rows[$i]->tagID;
                    } else {
                        $tag_taskIDs .= "," . $rows[$i]->tagID;

                    }

                }
                $tag_taskIDs = array_unique(explode(',', $tag_taskIDs));
                $tag_taskIDs = implode(',', $tag_taskIDs);
                $db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($tag_taskIDs)");
                $db->execute("DELETE FROM tags WHERE tags_count < 1");    # slow on large amount of tags


            }


////////////////////////////////////////////////DELETE TASK FROM tag2task//////////////////////////////////////////////////////////////////////////////////
// $tag_task_sql="select taskID from tag2task where taskID = any (SELECT taskID from todolist where taskID in ($taskIDs))";
            $tag_task_sql = "select taskID  from tag2task where taskID in ($taskIDs) ";
            if ($rows_tag2task = $db->queryObjectArray($tag_task_sql)) {


                for ($i = 0; $i < count($rows_tag2task); $i++) {
                    if ($i == 0) {
                        $tag2taskIDs = $rows_tag2task[$i]->taskID;
                    } else {
                        $tag2taskIDs .= "," . $rows_tag2task[$i]->taskID;

                    }

                }


                $sql5 = "DELETE FROM tag2task WHERE taskID IN($tag2taskIDs)";

                if (!$db->execute($sql5))
                    return -1;

            }


////////////////////////////////////////////////DELETE  FROM rel_user_task//////////////////////////////////////
            $user_task_sql = "select taskID  FROM rel_user_task WHERE decID=$decID ";
            if ($rows_user_task = $db->queryObjectArray($user_task_sql)) {


                $user_task_sql_del = "DELETE from rel_user_task WHERE decID=$decID  ";

                if (!$db->execute($user_task_sql_del))
                    return -1;

            }
/////////////////////////////////////////////////////////////////////////////////////////////////////////
        }//end select from todolist
///////////////////////////////////////////////////UPDATE PARENT_DECID_1=NULL//////////////////////////////
        $parent1_sql = "select decID from decisions where parentDecID1='$decID' AND parentDecID1 IS NOT NULL ";
        if ($rows_parent = $db->queryObjectArray($parent1_sql)) {

            for ($i = 0; $i < count($rows_parent); $i++) {
                if ($i == 0) {
                    $parentIDs = $rows_parent[$i]->decID;
                } else {
                    $parentIDs .= "," . $rows_parent[$i]->decID;

                }

            }
            $sql7 = "update decisions set parentDecID1=null  where decID in($parentIDs)";

            if (!$db->execute($sql7))
                return -1;
        }
////////////////////////////////////////////DELETE EVENT FROM EVENT/////////////////////////////////////////////////////////////////////////////////////
        $event_sql = "select id from event where decID='$decID' ";
        if ($rows_event = $db->queryObjectArray($event_sql)) {
            $event_sqlDel = "DELETE FROM event WHERE decID='$decID'  ";
            if (!$db->execute($event_sqlDel))
                return -1;
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        // delete category
        $sql = "DELETE FROM decisions WHERE decID='$decID' LIMIT 1";
        $sql1 = "DELETE FROM rel_cat_dec WHERE decID='$decID'  ";
        $sql2 = "DELETE FROM rel_forum_dec WHERE decID='$decID'  ";
        $sql3 = "DELETE FROM rel_user_Decforum WHERE decID='$decID'  ";
        $sql4 = "DELETE FROM rel_user_event WHERE decID='$decID'  ";

        if ($db->execute($sql) && $db->execute($sql1) && $db->execute($sql2) && $db->execute($sql3) && $db->execute($sql4))
            return 1;
        else
            return -1;

    }

    /**********************************************************************************************************/

    function save_forum(&$formdata)
    {


        global $db;


        if ($formdata['dest_forums'] == 'none' && !array_item($formdata, "dest_forums")) {
            unset ($formdata['dest_forums']);
            $tmp = "";

            /******************************************************************************************************/

        } elseif (($formdata['dest_forums'] != 'none' && $formdata['dest_forums'] != null
                && (array_item($formdata, "dest_forums") && is_array(array_item($formdata, "dest_forums"))))
            && (!array_item($formdata, "new_forum")
                || ($formdata["new_forum"] == 'none')
                || $formdata["new_forum"] == null)
        ) {


            $tmp = $formdata["dest_forums"] ? $formdata["dest_forums"] : $formdata["new_forum"];


            $dest_forums = $formdata['dest_forums'];

            foreach ($dest_forums as $key => $val) {
                if (!is_numeric($val)) {
                    $val = $db->sql_string($val);
                    $staff_test[] = $val;
                } elseif (is_numeric($val)) {
                    $staff_testb[] = $val;
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

                /************************************************************/
//$staff=implode(',',$formdata['dest_forums'])	;
//$sql2="select forum_decID, forum_decName from forum_dec where forum_decID in ($staff)";
//		if($rows=$db->queryObjectArray($sql2))
//		foreach($rows as $row){
//
//			$name[$row->forum_decID]=$row->forum_decName;
//	  }
                /***************************************************************************************/
            }
            foreach ($formdata['dest_forums'] as $row) {
                $forumsIDs [] = $row;
            }
            /*************************************************************************************************************/
        } elseif ($formdata['dest_forums'] != 'none' && $formdata['dest_forums'] != null && trim($formdata['new_forum'] != 'none')
            && array_item($formdata, "new_forum")
            && count($formdata['new_forum']) > 0
            && array_item($formdata, "dest_forums")
        ) {

            $tmp = $formdata["new_forum"] ? $formdata["new_forum"] : $formdata["dest_forums"];
            $forumNames = explode(';', $tmp);


            $i = 0;
            foreach ($forumNames as $forumName) {
                if (!array_item($formdata, 'insert_forum') && !is_numeric($formdata ['insert_forum'][0])) {
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forumName) . " , '11')";

                } else {
                    $parent = $formdata['insert_forum'][$i];
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forumName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $forumsIDs[] = $db->insertId();


                $i++;
            }
            $formdata['dest_forums'] = $forumsIDs;
            unset($formdata['new_forum']);
            /*************************************************************************************************************/
        } elseif (($formdata['dest_forums'] == 'none' || $formdata['dest_forums'] == null
                || (!array_item($formdata, "dest_forums") && !is_numeric(array_item($formdata, "dest_forums"))))
            && $formdata['new_forum'] != 'none'
            && $formdata['new_forum'] != null
            && count($formdata['new_forum']) > 0
            && array_item($formdata, "new_forum")
        ) {


            $tmp = $formdata["new_forum"] ? $formdata["new_forum"] : $formdata["dest_forums"];
            $forumNames = explode(';', $tmp);


            $i = 0;
            foreach ($forumNames as $forumName) {
                if (!array_item($formdata, 'insert_forum') && !is_numeric($formdata ['insert_forum'][0])) {
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forum_decName) . " , '11')";

                } else {
                    $parent = $formdata['insert_forum'][$i];
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forumName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $forumsIDs[] = $db->insertId();

                $formdata['dest_forums'] = $formdata['new_forum'];
                unset($formdata['new_forum']);

                $i++;
            }

            $formdata['dest_forums'] = $forumsIDs;
            unset($formdata['new_forum']);


        }
        return $forumsIDs;
    }
    /**********************************************************************/
    /**********************************************************************/

    function save_forum_ajx(&$formdata)
    {


        global $db;

        $decID = $formdata['decID'];
        if (isset($formdata["dest_forums$decID"]) && $formdata["dest_forums$decID"] == 'none' && !array_item($formdata, "dest_forums$decID")) {
            unset ($formdata["dest_forums$decID"]);
            $tmp = "";

            /******************************************************************************************************/

        } elseif ( isset($formdata["dest_forums$decID"]) && ($formdata["dest_forums$decID"] != 'none' && $formdata["dest_forums$decID"] != null)
                && ((array_item($formdata, "dest_forums$decID") && is_array(array_item($formdata, "dest_forums$decID"))))
                && (isset($formdata["new_forum$decID"]) && !array_item($formdata, "new_forum$decID") )
                || (isset($formdata["new_forum$decID"]) && $formdata["new_forum$decID"] == 'none')
                ||(isset($formdata["new_forum$decID"]) &&  $formdata["new_forum$decID"] == null ) ) {


            $tmp = isset($formdata["dest_forums$decID"]) ? $formdata["dest_forums$decID"] : $formdata["new_forum$decID"];


            $dest_forums = isset($formdata["dest_forums$decID"]) ? $formdata["dest_forums$decID"] : '';
if(isset($dest_forums) && is_array($dest_forums)){
            foreach ($dest_forums as $key => $val) {
                if (!is_numeric($val)) {
                    $val = $db->sql_string($val);
                    $staff_test[] = $val;
                } elseif (is_numeric($val)) {
                    $staff_testb[] = $val;
                }
            }
        }
            if (!empty($staff_test) &&is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
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
            } else if(isset($formdata["dest_forums$decID"]))
                {
                $staff = implode(',', $formdata["dest_forums$decID"]);

                $sql2 = "select forum_decID, forum_decName from forum_dec where forum_decID in ($staff)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {

                        $name[$row->forum_decID] = $row->forum_decName;
                    }
            }
           if(isset($name) && is_array($name)) {
            foreach ($name as $key => $val) {
                $forumsIDs [] = $key;
            }
           }
            /*************************************************************************************************************/
        } elseif (isset($formdata["dest_forums$decID"]) && $formdata["dest_forums$decID"] != 'none' && $formdata["dest_forums$decID"] != null && trim($formdata["new_forum$decID"] != 'none')
            && array_item($formdata, "new_forum$decID")
            && isset($formdata["new_forum$decID"]) && count($formdata["new_forum$decID"]) > 0
            && array_item($formdata, "dest_forums$decID")
        ) {

            $tmp = isset($formdata["new_forum$decID"] ) ? $formdata["new_forum$decID"] : $formdata["dest_forums$decID"];
            $forumNames = explode(';', $tmp);


            $i = 0;
            foreach ($forumNames as $forumName) {
                if (!array_item($formdata, "insert_forum") && !is_numeric($formdata ["insert_forum"][0])) {
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forumName) . " , '11')";

                } else {
                    $parent = $formdata["insert_forum"][$i];
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forumName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $forumsIDs[] = $db->insertId();

                $i++;
            }
            $formdata["dest_forums$decID"] = $forumsIDs;
            unset($formdata["new_forum$decID"]);
            /*************************************************************************************************************/
        } elseif (isset($formdata["dest_forums$decID"]) && ($formdata["dest_forums$decID"] == 'none' || $formdata["dest_forums$decID"] == null
                || (!array_item($formdata, "dest_forums$decID") && !is_numeric(array_item($formdata, "dest_forums$decID"))))
            && isset($formdata["new_forum$decID"]) && $formdata["new_forum$decID"] != 'none'
            && $formdata["new_forum$decID"] != null
            && count($formdata["new_forum$decID"]) > 0
            && array_item($formdata, "new_forum$decID")
        ) {


            $tmp = $formdata["new_forum$decID"] ? $formdata["new_forum$decID"] : $formdata["dest_forums$decID"];
            $forumNames = explode(';', $tmp);


            $i = 0;
            foreach ($forumNames as $forumName) {
                if (!array_item($formdata, "insert_forum") && !is_numeric($formdata ["insert_forum"][0])) {
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forum_decName) . " , '11')";

                } else {
                    $parent = $formdata["insert_forum"][$i];
                    $sql = "INSERT INTO forum_dec (forum_decName,parentForumID) " .
                        "VALUES (" . $db->sql_string($forumName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $forumsIDs[] = $db->insertId();

                $formdata["dest_forums$decID"] = $formdata["new_forum$decID"];
                unset($formdata["new_forum$decID"]);

                $i++;
            }

            $formdata["dest_forums$decID"] = $forumsIDs;
            unset($formdata["new_forum$decID"]);


        }
        $forumsIDs = isset( $forumsIDs) ?  $forumsIDs : false;
        return $forumsIDs;
    }

    /**********************************************************************/
    /**********************************************************************/

    function save_category(&$formdata)
    {
        global $db;


        if ($formdata['dest_decisionsType'] == 'none' && !array_item($formdata, "dest_decisionsType")) {
            unset ($formdata['dest_decisionsType']);
            $tmp = "";

            /******************************************************************************************************/

        } elseif (($formdata['dest_decisionsType'] != 'none' && $formdata['dest_decisionsType'] != null
                && (array_item($formdata, "dest_decisionsType") && is_array(array_item($formdata, "dest_decisionsType"))))
            && (!array_item($formdata, "new_decisionType")
                || ($formdata["new_decisionType"] == 'none')
                || $formdata["new_decisionType"] == null)
        ) {


            $tmp = $formdata["dest_decisionsType"] ? $formdata["dest_decisionsType"] : $formdata["new_decisionType"];


            $dest_decisionsType = $formdata['dest_decisionsType'];

            foreach ($dest_decisionsType as $key => $val) {
                if (!is_numeric($val)) {
                    $val = $db->sql_string($val);
                    $staff_test[] = $val;
                } elseif (is_numeric($val)) {
                    $staff_testb[] = $val;
                }
            }
            if (isset($staff_test) && is_array($staff_test) && !is_array($staff_testb) && !$staff_testb) {
                $staff = implode(',', $staff_test);

                $sql2 = "select catID, catName from categories where catName in ($staff)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {

                        $name[$row->catID] = $row->catName;


                    }

            } elseif (isset($staff_test) && is_array($staff_test) && is_array($staff_testb) && $staff_testb) {
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
                /*****************************************************************/
                $staff = implode(',', $formdata['dest_decisionsType']);

                $sql2 = "select catID, catName from categories where catID in ($staff)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {

                        $name[$row->catID] = $row->catName;
                    }
            }
            /********************************************************************/


            foreach ($formdata['dest_decisionsType'] as $row) {
                $catsIDs [] = $row;
            }
            /*************************************************************************************************************/
        } elseif ($formdata['dest_decisionsType'] != 'none' && $formdata['dest_decisionsType'] != null && trim($formdata['new_decisionType'] != 'none')
            && array_item($formdata, "new_decisionType")
            && count($formdata['new_decisionType']) > 0
            && array_item($formdata, "dest_decisionsType")
        ) {

            $tmp = $formdata["new_decisionType"] ? $formdata["new_decisionType"] : $formdata["dest_decisionsType"];
            $catNames = explode(';', $tmp);


            $i = 0;
            foreach ($catNames as $catName) {
                if (!array_item($formdata, 'insert_decisionType') && !is_numeric($formdata ['insert_decisionType'][0])) {
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , '11')";

                } else {
                    $parent = $formdata['insert_decisionType'][$i];
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $catsIDs[] = $db->insertId();


                $i++;
            }
            $formdata['dest_decisionsType'] = $catsIDs;
            unset($formdata['new_decisionType']);
            /*************************************************************************************************************/
        } elseif (($formdata['dest_decisionsType'] == 'none' || $formdata['dest_decisionsType'] == null
                || (!array_item($formdata, "dest_decisionsType") && !is_numeric(array_item($formdata, "dest_decisionsType"))))
            && $formdata['new_decisionType'] != 'none'
            && $formdata['new_decisionType'] != null
            && count($formdata['new_decisionType']) > 0
            && array_item($formdata, "new_decisionType")
        ) {


            $tmp = $formdata["new_decisionType"] ? $formdata["new_decisionType"] : $formdata["dest_decisionsType"];
            $catNames = explode(';', $tmp);


            $i = 0;
            foreach ($catNames as $catName) {
                if (!array_item($formdata, 'insert_decisionType') && !is_numeric($formdata ['insert_decisionType'][0])) {
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , '11')";

                } else {
                    $parent = $formdata['insert_decisionType'][$i];
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $catsIDs[] = $db->insertId();

                $formdata['dest_decisionsType'] = $formdata['new_decisionType'];
                unset($formdata['new_decisionType']);

                $i++;
            }

            $formdata['dest_decisionsType'] = $catsIDs;
            unset($formdata['new_decisionType']);


        }
        return $catsIDs;
    }


    /**********************************************************************/

    function save_category_ajx(&$formdata)
    {
        global $db;

        $decID =  isset($formdata['decID']) ? $formdata['decID']: '';
        if (!empty($formdata["dest_decisionsType$decID"]) && $formdata["dest_decisionsType$decID"] == 'none' && !array_item($formdata, "dest_decisionsType$decID")) {
            unset ($formdata["dest_decisionsType$decID"]);
            $tmp = "";

            /******************************************************************************************************/

        } elseif (!empty($formdata["dest_decisionsType$decID"]) && ($formdata["dest_decisionsType$decID"] != 'none' && $formdata["dest_decisionsType$decID"] != null
                && (array_item($formdata, "dest_decisionsType$decID") && is_array(array_item($formdata, "dest_decisionsType$decID"))))
            && (!array_item($formdata, "new_decisionType$decID")
                || ($formdata["new_decisionType$decID"] == 'none')
                || $formdata["new_decisionType$decID"] == null)
        ) {


            $tmp = $formdata["dest_decisionsType$decID"] ? $formdata["dest_decisionsType$decID"] : $formdata["new_decisionType$decID"];


            $dest_decisionsType = $formdata["dest_decisionsType$decID"];

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
                $staff = implode(',', $formdata["dest_decisionsType$decID"]);

                $sql2 = "select catID, catName from categories where catID in ($staff)";
                if ($rows = $db->queryObjectArray($sql2))
                    foreach ($rows as $row) {

                        $name[$row->catID] = $row->catName;
                        //$name[]=$row->catName;

                    }
            }


// $staff=implode(',',$tmp);
//			  $sql = "SELECT  catName,catID,parentCatID FROM categories WHERE catID in ($staff)  " ;


            foreach ($name as $key => $val) {
                $catsIDs [] = $key;
            }
            /*************************************************************************************************************/
        } elseif (!empty($formdata["dest_decisionsType$decID"]) && $formdata["dest_decisionsType$decID"] != 'none' && $formdata["dest_decisionsType$decID"] != null && trim($formdata["new_decisionType$decID"] != 'none')
            && array_item($formdata, "new_decisionType$decID")
            && count($formdata["new_decisionType$decID"]) > 0
            && array_item($formdata, "dest_decisionsType$decID")
        ) {

            $tmp = isset( $formdata["new_decisionType$decID"]) ? $formdata["new_decisionType$decID"] : $formdata["dest_decisionsType$decID"];
            $catNames = explode(';', $tmp);


            $i = 0;
            foreach ($catNames as $catName) {
                if (!array_item($formdata, "insert_decisionType$decID") && !is_numeric($formdata ["insert_decisionType$decID"][0])) {
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , '11')";

                } else {
                    $parent = $formdata["insert_decisionType$decID"][$i];
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $catsIDs[] = $db->insertId();


                $i++;
            }
            $formdata["dest_decisionsType$decID"] = $catsIDs;
            unset($formdata["new_decisionType$decID"]);
            /*************************************************************************************************************/
        } elseif (!empty($formdata["dest_decisionsType$decID"]) &&($formdata["dest_decisionsType$decID"] == 'none' || $formdata["dest_decisionsType$decID"] == null
                || (!array_item($formdata, "dest_decisionsType$decID") && !is_numeric(array_item($formdata, "dest_decisionsType$decID"))))
            && !empty($formdata["new_decisionType$decID"]) &&  $formdata["new_decisionType$decID"] != 'none'
            && $formdata["new_decisionType$decID"] != null
            && count($formdata["new_decisionType$decID"]) > 0
            && array_item($formdata, "new_decisionType$decID")
        ) {


            $tmp = $formdata["new_decisionType$decID"] ? $formdata["new_decisionType$decID"] : $formdata["dest_decisionsType$decID"];
            $catNames = explode(';', $tmp);


            $i = 0;
            foreach ($catNames as $catName) {
                if (!array_item($formdata, "insert_decisionType$decID") && !is_numeric($formdata ["insert_decisionType$decID"][0])) {
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , '11')";

                } else {
                    $parent = $formdata["insert_decisionType$decID"][$i];
                    $sql = "INSERT INTO categories (catName,parentCatID) " .
                        "VALUES (" . $db->sql_string($catName) . " , $parent)";
                }


                if (!$db->execute($sql))
                    return FALSE;
                $catsIDs[] = $db->insertId();

                $formdata["dest_decisionsType$decID"] = $formdata["new_decisionType$decID"];
                unset($formdata["new_decisionType$decID"]);

                $i++;
            }

            $formdata["dest_decisionsType$decID"] = $catsIDs;
            unset($formdata["new_decisionType$decID"]);


        }
        return isset($catsIDs) ? $catsIDs : '' ;
    }

    /**********************************************************************/

    function save_category1(&$formdata)
    {
        // var_dump($formdata);die;

        global $db;


        // save category / get catID
        //=================================


        $sql = "SELECT  catName,catID,parentCatID FROM categories WHERE catID = " .

            $db->sql_string($formdata['category']);

        $rows = $db->queryObjectArray($sql);

        if ($rows) {
            // existing category
            //===================
            $catIDs[] = $rows[0]->catID;
            // var_dump($sql);die;
        }

        return $catIDs;
    }

    /**********************************************************************/

    function save_date($formdata)
    {


        global $db;
        $i = 0;
        $tmp = array();
        $tmp = ($formdata["forum_decision"]) ? $formdata["forum_decision"] : $forums = explode(";", $formdata["newforum"]);

        foreach ($tmp as $forum) {

            $forum = trim($forum);
            if ($formdata['newforum']) {
                $sql = "SELECT forum_decName,forum_decID FROM forum_dec WHERE forum_decName = " .
                    $db->sql_string($forum);
            } else {
                $sql = "SELECT forum_decName,forum_decID FROM forum_dec WHERE forum_decID = " .
                    $db->sql_string($forum);
            }

            $rows = $db->queryObjectArray($sql);
            if ($rows)
                // existing forum
                $forumIDs[] = $rows[0]->forum_decID;
            else {
                // new forum
                $sql = "INSERT INTO forum_dec (forum_decName) " .
                    "VALUES (" . $db->sql_string($forum) . ")";
                if (!$db->execute($sql))
                    return FALSE;
                $forumIDs[] = $db->insertId();

                $tmp = ($formdata["forum_decision"][$i]) ? $formdata["forum_decision"][$i++] : $forums = explode(";", $formdata["newforum"]);
            }
        }
        return $forumIDs;
    }

    /**********************************************************************/

    function conn_parent_second($formdata)
    {
        global $db;
        $parnetDecID1 = $formdata['parentDecID1'];
        $sql = "SELECT parentDecID1 FROM decisions WHERE decID = " .
            $db->sql_string($formdata['decID']);
        $rows = $db->queryObjectArray($sql);

        if (!$rows[0]->parentDecID1 == null) {
            // existing category
            //===================
            $parnetDecID1 = $rows[0]->parentDecID1;
            $sql = "INSERT INTO decisions (parentDecID1) " .
                "VALUES ($parnetDecID1) where decID= " .
                $db->sql_string($formdata['decID']);
            if (!$db->execute($sql))
                return FALSE;

        } else {

            $decID = $formdata['decID'];
            $sql = "update decisions set parentDecID1=$parnetDecID1 where decID=  " .
                $db->sql_string($decID);

            if (!$db->execute($sql))
                return FALSE;

        }
        return true;
    }

    /**********************************************************************/

    function message_update($formdata, $decID)
    {
        // message
        echo "<p>.עודכנה ההחלטה  ",
        build_href1("dynamic_5.php", "mode=read_data", "&editID=$decID", $formdata['subcategories']),
        "  </p>\n";

        //echo"<p> לחץ לעידכון נוסף או מחיקה </p>";
        //echo"<p>או להוספת החלטה חדשה בכפתור הכנס שם החלטה   </p>";
        return TRUE;
    }

    /**********************************************************************/
    function message_update_b($formdata, $decID)
    {
        // message
        echo "<p>.עודכנה ההחלטה  ",
        build_href1("dynamic_5b.php", "mode=read_data", "&editID=$decID", $formdata['subcategories']),
        "  </p>\n";

        //echo"<p> לחץ לעידכון נוסף או מחיקה </p>";
        //echo"<p>או להוספת החלטה חדשה בכפתור הכנס שם החלטה   </p>";
        return TRUE;
    }

    /**********************************************************************/

    function ID_or_NULL($id)
    {
        if ($id == "none")
            return 'NULL';
        else
            return $id;
    }

    function redirect($url = null)
    {
        //if(is_null($url)) $url = $_SERVER['PHP_SELF'];
        header("Location: $url");
        //exit();
    }

    /**************************************************************/

    function update_dec_parent($insertID, $decID)
    {
        global $db;
        $sql = "UPDATE decisions set parentDecID=$insertID WHERE decID=$decID ";
        if (!$db->execute($sql))
            return FALSE;

        $this->print_decision_entry_form1_b($decID);
        exit;

    }

    /************************************************************************************************/

    function print_decision_entry_form1_b($updateID, $mode = '')
    {
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


        $insertID = $updateID;

        ?>
        <input type="hidden" name="hidden_entry<?php echo $updateID; ?>" id="hidden_entry<?php echo $updateID; ?>"
               value="<?php echo $updateID; ?>"/>
    <div id="my_entry<?PHP echo $updateID; ?>" name="my_entry<?PHP echo $updateID; ?>">

        <?php

        $sql = "SELECT decName, decID, parentDecID " .
            "FROM decisions ORDER BY decName";
        $rows = $db->queryObjectArray($sql);

        // build assoc. arrays for name, parent and subcats
        foreach ($rows as $row) {
            $decNames[$row->decID] = $row->decName;
            $parents[$row->decID] = $row->parentDecID;
            $subcats[$row->parentDecID][] = $row->decID;
        }


        // build list of all parents for $updateID
        $decID = $updateID;
        while ($parents[$decID] != NULL) {
            $decID = $parents[$decID];
            $parentList[] = $decID;
        }


        //echo '<fieldset class="my_pageCount" >';
        if ($level) {
////////////////////////////////////////////////////////////////////////////////////////

            if (isset($parentList)) {
                for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                    $url = "../admin/find3.php?decID=$parentList[$i]";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    if ($parentList[$i] == '11') {
                        printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s (%s, %s )</b> </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"));
                    } else {

                        printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5b.php", "mode=insert", "&insertID=$parentList[$i]", "הוסף"),
                            build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$parentList[$i]", "מחק", "OnClick='return verify();' class='href_modal1'"),
                            build_href2("dynamic_5b.php", "mode=update", "&updateID=$parentList[$i]", "עדכן"),
                            build_href2("dynamic_5b.php", "mode=read_data", "&editID=$parentList[$i]", "עידכון מורחב"),
                            build_href5("", "", "הראה נתונים", $str));


                    }

                }
            }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // display choosen forum  * BOLD *
            if ($insertID == '11') {

                printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"));

            } else {
                $url = "../admin/find3.php?decID=$updateID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s, %s, %s, %s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$updateID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"),
                    build_href2("dynamic_5b.php", "mode=read_data", "&editID=$updateID", "עידכון מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


            echo "<ul>";


            $i = 0;
            if (array_key_exists($updateID, $subcats)) {




                    while (isset($subcats["$updateID"]) && $subcats["$updateID"]) {

                        foreach ($subcats[$updateID] as $decID) {
                            $url = "find3.php?decID=$decID";
                            $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                            printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                                htmlspecial_utf8($decNames[$decID]),
                                build_href2("dynamic_5b.php", "mode=insert", "&insertID=$decID", "הוסף"),
                                build_href2("dynamic_5b.php", "mode=delete", "&deleteID=$decID", "מחק", "OnClick='return verify();' class='href_modal1'"),
                                build_href2("dynamic_5b.php", "mode=update", "&updateID=$decID", "עדכן"),
                                build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", "עידכון מורחב"),
                                build_href5("", "", "הראה נתונים", $str));

                        }

                        echo "<ul>";

                        $updateID = $decID;
                        $i++;
                    }

                // close hierarchical category list
                echo str_repeat("</ul>", $i + 1), "\n";
            } else {

                echo "(עדיין אין תת-החלטות.)";
            }


            echo "</ul>\n";

            if (isset($parentList))
                echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";

            /*****************************************************************************************************/
            echo '</div>';

///////////////////////////
        } elseif (!($level)) {///
/////////////////////////


            if (isset($parentList)) {
                for ($i = sizeof($parentList) - 1; $i >= 0; $i--) {
                    $url = "../admin/find3.php?decID=$parentList[$i]";
                    $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                    if ($parentList[$i] == '11') {
                        printf("<ul><li style='font-weight :bold;'> <img src='" . TAMPLATE_IMAGES_DIR . "/star.gif'><b>%s </b> </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]));
                    } else {

                        printf("<ul><li style='font-weight :bold;'> %s (%s, %s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$parentList[$i]]),
                            build_href2("dynamic_5b.php", "mode=read_data", "&editID=$parentList[$i]", "מידע מורחב"),
                            build_href5("", "", "הראה נתונים", $str));


                    }

                }
            }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // display choosen forum  * BOLD *
            if ($insertID == '11') {

                printf("<ul><li><b style='color:red;'> %s ( %s,%s )</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=insert", "&insertID=$updateID", "הוסף"),
                    build_href2("dynamic_5b.php", "mode=update", "&updateID=$updateID", "עדכן"));

            } else {
                $url = "../admin/find3.php?decID=$updateID";
                $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                printf("<ul><li class='bgchange_tree'><b style='color:red;'> %s (%s, %s)</b> </li>\n",
                    htmlspecial_utf8($decNames[$updateID]),
                    build_href2("dynamic_5b.php", "mode=read_data", "&editID=$updateID", "מידע מורחב"),
                    build_href5("", "", "הראה נתונים", $str));
            }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


            echo "<ul>";


            $i = 0;
            if (array_key_exists($updateID, $subcats)) {
                while ($subcats[$updateID]) {
                    foreach ($subcats[$updateID] as $decID) {
                        $url = "find3.php?decID=$decID";
                        $str = 'onclick=\'openmypage3("' . $url . '"); return false;\'   class=href_modal1 ';
                        printf("<li style='font-weight :bold;'> %s (%s, %s, %s, %s, %s ) </li>\n",
                            htmlspecial_utf8($decNames[$decID]),
                            build_href2("dynamic_5b.php", "mode=read_data", "&editID=$decID", "מידע מורחב"),
                            build_href5("", "", "הראה נתונים", $str));

                    }
                    echo "<ul>";

                    $updateID = $decID;
                    $i++;
                }
                // close hierarchical category list
                echo str_repeat("</ul>", $i + 1), "\n";
            } else {

                echo "(עדיין אין תת-החלטות.)";
            }


            echo "</ul>\n";

            if (isset($parentList))
                echo str_repeat("</ul>", sizeof($parentList) + 1), "\n";

            /*****************************************************************************************************/
            echo '</div>';


        }//end else
        /*****************************************************************************************************/
        // echo '</fieldset>';
    }

    /************************************************************************************************/

    function conn_user_Decforum($decID, $date_UsrfrmIDs, &$formdata)
    {

        global $db;
        $mode = '';
        $frmNames_dest = Array();
        $frmNames_src = Array();
        /******************************************************************************************/
//$i=0;
//
//if( $formdata["dest_forums$decID"] && $formdata["dest_forums$decID"]!='none'  && is_array($formdata["dest_forums$decID"])){
//foreach ($formdata["dest_forums$decID"] as $forum){
//		if($i==0)
//		$frm_dest = $forum;
//		else
//		$frm_dest .= "," . $forum;
//		$i++;
// }
//}
//$i=0;
//if( $formdata["src_forums$decID"] && $formdata["src_forums$decID"]!='none'  && is_array($formdata["src_forums$decID"])){
//foreach ($formdata["src_forums$decID"] as $forum){
//		if($i==0)
//		$frm_src = $forum;
//		else
//		$frm_src .= "," . $forum;
//		$i++;
//    }
//  }

        if ($formdata["dest_forums"] && $formdata["dest_forums"] != 'none' && is_array($formdata["dest_forums"])) {
            $i = 0;
            foreach ($formdata["dest_forums"] as $forum) {
                if ($i == 0)
                    $frm_dest = $forum;
                else
                    $frm_dest .= "," . $forum;
                $i++;
            }
        }

        if ($formdata["src_forums"] && $formdata["src_forums"] != 'none' && is_array($formdata["src_forums"])) {
            $i = 0;
            foreach ($formdata["src_forums"] as $forum) {
                if ($i == 0)
                    $frm_src = $forum;
                else
                    $frm_src .= "," . $forum;
                $i++;
            }
        }

//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
        if ($formdata["dest_forums$decID"] && $formdata["dest_forums$decID"] != 'none' && is_array($formdata["dest_forums$decID"])) {
            $i = 0;
            foreach ($formdata["dest_forums$decID"] as $forum) {
                if ($i == 0)
                    $frm_dest = $forum;
                else
                    $frm_dest .= "," . $forum;
                $i++;
            }
        }
//------------------------------------------------------------------------------------------
        if ($formdata["src_forums$decID"] && $formdata["src_forums$decID"] != 'none' && is_array($formdata["src_forums$decID"])) {
            $i = 0;
            foreach ($formdata["src_forums$decID"] as $forum) {
                if ($i == 0)
                    $frm_src = $forum;
                else
                    $frm_src .= "," . $forum;
                $i++;
            }
        }
//-------------------------------------ASSOC-----------------------------------------------------
        if ($frm_dest) {
            $sql1 = "select forum_decID,forum_decName from forum_dec WHERE forum_decID in($frm_dest)";
            if ($rows = $db->queryObjectArray($sql1)) {
                foreach ($rows as $row) {

                    $frmNames_dest[$row->forum_decID] = $row->forum_decName;
                }
            }
        }
//--------------------------------------ASSOC----------------------------------------------------
        if ($frm_src) {
            $sql2 = "select forum_decID,forum_decName from forum_dec WHERE forum_decID in($frm_src)";
            if ($rows = $db->queryObjectArray($sql2)) {
                foreach ($rows as $row) {

                    $frmNames_src[$row->forum_decID] = $row->forum_decName;
                }
            }
        }
//------------------------------------------------------------------------------------------

        $i = 0;
        if ($frmNames_src
            && $frmNames_src != 'none'
            && is_array($frmNames_src)
            && (count($frmNames_src) > 0)
            && $frmNames_dest
            && $frmNames_dest != 'none'
            && is_array($frmNames_dest)
            && (count($frmNames_dest) > 0)
            && (count($frmNames_dest)) >= (count($frmNames_src))
        ) {

            foreach ($frmNames_dest as $key => $val) {

                if (in_array($val, $frmNames_src)) {

                    unset($frmNames_dest[$key]);
                    unset($frmNames_src[$key]);//delete only users_forums  added or take out from rel_user_Decforum
                }

                $i++;
            }
        } elseif ($frmNames_src
            && $frmNames_src != 'none'
            && is_array($frmNames_src)
            && count($frmNames_src) > 0
            && $frmNames_dest
            && $frmNames_dest != 'none'
            && is_array($frmNames_dest)
            && (count($frmNames_dest) > 0)
            && (count($frmNames_dest)) < (count($frmNames_src))
        ) {

            foreach ($frmNames_src as $key => $val) {

                if (in_array($val, $frmNames_dest)) {

                    unset($frmNames_src[$key]);
                    unset($frmNames_dest[$key]);//delete only users_forums  added or take out from rel_user_Decforum
                }

                $i++;
            }


        }
//------------------------------------------------------------------------------------------

        if (is_array($frmNames_src) && (count($frmNames_src) > 0)) {
            foreach ($frmNames_src as $key => $val) {
                $sql = "DELETE FROM rel_user_Decforum WHERE decID=$decID AND forum_decID=$key ";
                if (!($db->execute($sql)))
                    return FALSE;
            }
        }
//------------------------------------------------------------------------------------------

        if ($frmNames_dest && $frmNames_dest != 'none' && (is_array($frmNames_dest)) && (count($frmNames_dest) > 0)) {


            foreach ($frmNames_dest as $key => $val) {

                $sql = "select userID,HireDate,forum_decID from rel_user_forum WHERE forum_decID=$key";

                if ($rows = $db->queryObjectArray($sql)) {
                    $user_forum = $rows;
                    foreach ($rows as $row) {
                        if ($row->HireDate) {
                            $hire_date = $row->HireDate;
                            $hire_date = $db->sql_string($hire_date);
                            $sql = "INSERT INTO rel_user_Decforum (decID,forum_decID,userID,HireDate) " .
                                "VALUES ($decID, $key,$row->userID,$hire_date)";
                        } else {
                            $sql = "INSERT INTO rel_user_Decforum (decID,forum_decID,userID) " .
                                "VALUES ($decID, $key,$row->userID)";
                        }
                        if (!$db->execute($sql))
                            return FALSE;

                    }//end foreach  2

                }//end if	$rows
            }//end foreach  1
        }
//------------------------------------------------------------------------------------------


        return TRUE;
    }

    /***********************************************************************************/
    function save_note($decID)
    {
        global $db;
        $sql = "SELECT d.decName,d.decID, 
	       rf.forum_decID,rf.note
	       FROM decisions d 
	       LEFT JOIN rel_forum_dec rf ON d.decID=rf.decID
	       WHERE d.decID=$decID";

        if ($rows_note = $db->queryObjectArray($sql)) {
            foreach ($rows_note as $row) {

                if (!($row->note))
                    $row->note = '';
                $rows_DecFrmnote[$row->forum_decID] = $row->note;

            }
            return $rows_DecFrmnote;
        }
    }


    /***************************************************************/
}//end class decisions

/************************************************************************/


?>