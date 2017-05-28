<?PHP
//session_start();
function html_header($arr_sublinks=""){


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



    ?>

    <!DOCTYPE html>
    <html style="direction: rtl;">
    <?PHP
    $GLOBALS['TEMPLATE']['content'] = ob_get_contents();
    ob_end_clean();
    ob_start();




    ?>
    <!--  -->
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='-1'>
    <meta http-equiv='pragma' content='no-cache'>
    <head id="my_header" >
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>מערכת ניהול PDF</title>
        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/themes/start/jquery-ui-1.8.16.custom.css" />
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-1.3.2.min.js"           type="text/javascript"> </script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-ui-1.8.16.custom.min.js"           type="text/javascript"> </script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.autocomplete.min.js"  charset="utf-8"   type="text/javascript"></script>

        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.validate.min.js"    charset="utf-8"            type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.validate.js"        charset="utf-8"        type="text/javascript"></script>

        <script  language=javascript" src="<?php print  JQ_ADMIN_WWW ?>/jqia2.support.js"  charset="utf-8"  type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.form.js"        charset="utf-8"        type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/jquery.fancybox-1.2.6.js"   charset="utf-8"                type="text/javascript"></script>

        <!--  jquery   -->
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/modal-window.min.js"       charset="utf-8"         type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/my_dialog.js"              charset="utf-8"  type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/modal2.js"               charset="utf-8" type="text/javascript"></script>

        <script  language=javascript" src="<?php print  JQ_ADMIN_WWW ?>/date_picker.js"           charset="utf-8"        type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/fullcalendar.js" charset="utf-8" type="text/javascript"></script>
        <!--    <script  language="JavaScript" src="--><?php //print JQ_ADMIN_WWW ?><!--/jquery-1.11.2.min.js" charset="utf-8" type="text/javascript"></script>-->




        <!--     -->
        <script language="JavaScript"  src="<?php print JS_ADMIN_WWW ?>/SelectObjectMethods.js"   charset="utf-8"     type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/DropDownMenu.js"         charset="utf-8"           type="text/javascript"></script>

        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi.js"             charset="utf-8"          type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi_user.js"         charset="utf-8"              type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/sorting-lists.js"         charset="utf-8"     type="text/javascript"></script>




        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/find_pagination.js"      charset="utf-8"       type="text/javascript"></script>






        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/answere.js"          charset="utf-8"          type="text/javascript"></script>
        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/clock.js"         charset="utf-8"           type="text/javascript"></script>
        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/confirmy.js"      charset="utf-8"            type="text/javascript"></script>
        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/treeview.js"        charset="utf-8"           type="text/javascript"></script>





        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/enhance.js"     charset="utf-8"       type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/user_edit.js"         charset="utf-8"           type="text/javascript"></script>

        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/dhtmlwindow.js"  charset="utf-8"   type="text/javascript"></script>



        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/scriptAr_frm.js"      charset="utf-8"    type="text/javascript"></script>
        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/scriptAr_dec.js"      charset="utf-8"    type="text/javascript"></script>
        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/scriptAr.js"      charset="utf-8"    type="text/javascript"></script>
        <script language="javascript"  src="<?php print JS_ADMIN_WWW ?>/my_load.js"      charset="utf-8"    type="text/javascript"></script>
        <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_brand.js" type="text/javascript"></script>







        <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/input.css"  />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/form.css" />



        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/themes/start/ui.progressbar.css">
        ‬
        <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/DropDownMenu.css"  />

        <link rel="stylesheet" type="text/css" media="all"    href="<?php echo CSS_DIR ?>/paginated.css" />
        <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/dhtmlwindow.css"  />
        <link rel="stylesheet" type="text/css" media="all"    href="<?php echo CSS_DIR ?>/formstyle.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/resulttable.css" />

        <link rel="stylesheet" type="text/css" media="screen"    href="<?php echo CSS_DIR ?>/style_test.css" />
        <link rel="stylesheet" type="text/css" media="screen"    href="<?php echo CSS_DIR ?>/core.css" />
        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/tooltip.css" />

        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/treeview.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/bootstrap.min.css" />

        <?php if(!(ae_detect_ie())) {?>
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/my_menu.css" />
        <?php }else{?>
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/my_menu2.css" />
        <?php }?>



    </head>

    <body id="my_body" style="direction: rtl;">
    <div id=my_header2>
        <div class="page" id="template_page">

            <fieldset  id="template_fieldset"  style="width:96%;margin-left:10px;margin-right:10px;margin-top:15px;background: #94C5EB url(../images/background-grad.png) repeat-x;">
                <span id=tick2 style="float:right;"></span>



                <div id="start_menu">

                    <ul class="mainNav" id="menuBar">



                        <div id="sidebar_dec_template"  style="float:right;">
                            <label for="search_dec_template" class="ac_input"  style="color:red; font-weight :bold; font-size :15px;text-align:right;">חפש PUBLISHER</label>
                            <input type="text" name="search_dec_template" id="search_dec_template"  class="text ui-widget-content ui-corner-all"  style="direction:rtl;margin-bottom:10px;"/>
                        </div>




                        <div id="sidebar_edit_template"  style="float:left;">
                            <label for="search_edit_template" class="ac_input"  style="color:red; font-weight :bold; font-size :15px;text-align:right;">חפש משתמש</label>
                            <input type="text" name="search_editUser_template" id="search_editUser_template"  class="text ui-widget-content ui-corner-all"  style="direction:rtl;margin-bottom:10px;"/>
                        </div>




                        <div id="sidebar_frm_template"  style="float:left;">
                            <label for="search_frm_template" class="ac_input"  style="color:red; font-weight :bold; font-size :15px;text-align:right;">חפש BRANDS</label>
                            <input type="text" name="search_frm_template" id="search_frm_template"  class="text ui-widget-content ui-corner-all"  style="direction:rtl;margin-bottom:10px;"/>
                        </div>


                        <li id="navMenu1" class="menuHeader"  style="margin-top:90px;"><a  href="#">ראשי</a></li>

                        <li id="navMenu2" class="menuHeader" style="margin-top:90px;"><a href="#">ניהול קבצים</a></li>
                        <li id="navMenu3" class="menuHeader" style="margin-top:90px;"><a href="#">ניהול ברנדים</a></li>
                        <li id="navMenu4" class="menuHeader" style="margin-top:90px;"><a href="#">ניהול משתמשים</a></li>
<!--                        <li id="navMenu5" class="menuHeader" style="margin-top:90px;"><a href="#">חיפושים</a></li>-->
<!--                        <li id="navMenu6" class="menuHeader" style="margin-top:90px;"><a href="#">ניהול ובקרה</a></li>-->

                    </ul>



                    <div id="dropMenu1" class="menuDrop">

                        <a href="subject_tree.php" onfocus="if (this.blur) this.blur();">עץ הנושאים</a>
                        <?php
                        if( !empty($_SESSION['level']) && isset($_SESSION['level']) &&  !($_SESSION['level']=='user'))
                        {
                            ?>
                            <a href="multiple-levels.php" onfocus="if (this.blur) this.blur();">עץ קבציי עריכה בחלון</a>

                            <?php
                        }
                        ?>
                    </div>






                    <div id="dropMenu2" class="menuDrop">
<!--                        <a href="database.php" onfocus="if (this.blur) this.blur();">עץ ההחלטות</a>-->
<!--                        <a href="database7.php" onfocus="if (this.blur) this.blur();">עץ פתוח של החלטות</a>-->
<!--                        <a href="category_tree.php" onfocus="if (this.blur) this.blur();">צפייה בעץ סוגי החלטות</a>-->
<!---->
<!--                        --><?php //if(!empty($_SESSION['level']) && !($_SESSION['level']=='user')){?>
<!--                            <a href="categories.php" onfocus="if (this.blur) this.blur();">ערוך סוגי החלטות</a>-->


                            <a href="dynamic_5_demo.php" onfocus="if (this.blur) this.blur();">ניהול של  PDF</a>
<!--                            <a href="mult_dec_ajx.php" onfocus="if (this.blur) this.blur();">ניהול מורכב של החלטות (online)</a>-->
<!--                        --><?php //}else{?>
<!--                            <a href="dynamic_5_demo.php" onfocus="if (this.blur) this.blur();">ניהול של  PDF</a>-->
<!--                            <a href="mult_dec_ajx.php" onfocus="if (this.blur) this.blur();">מבנה מורכב של החלטה</a>-->
<!---->
<!--                        --><?php //}?>

                    </div>




                    <div id="dropMenu3" class="menuDrop">
                       <?php if($level) { ?>
<!--                           <a href="categories.php" onfocus="if (this.blur) this.blur();">הקמה של ברנד</a>-->
                        <a href="create_brand.php" onfocus="if (this.blur) this.blur();">הקמה של ברנד</a>

                        <a href="brand_plan.php" onfocus="if (this.blur) this.blur();">בניית תוכנית עבודה </a>

                      <?php }else{ ?>
                           <a href="brand_plan.php" onfocus="if (this.blur) this.blur();">צפייה ואישור תוכנית עבודה </a>
                          <?php } ?>
                    </div>



                    <div id="dropMenu4" class="menuDrop">
<!--                        <a href="manager_tree.php" onfocus="if (this.blur) this.blur();"> עץ המנהלים</a>-->
<!--                        <a href="database6.php" onfocus="if (this.blur) this.blur();"> עץ סוגי המנהלים</a>-->
<!--                        <a href="appoint_tree.php" onfocus="if (this.blur) this.blur();">עץ ממני פורומים</a>-->
<!---->
<!--                        --><?php //if(!empty($_SESSION['level']) && !($_SESSION['level']=='user')){?>
<!--                            <a href="manager.php" onfocus="if (this.blur) this.blur();"> ערוך מנהלים</a>-->
<!---->
<!--                            <a href="manager_category.php" onfocus="if (this.blur) this.blur();"> ערוך סוגי מנהלים</a>-->
<!---->
<!--                            <a href="appoint_edit.php" onfocus="if (this.blur) this.blur();">ערוך ממני פורומים</a>-->
<!--                        --><?php //}?>
                    </div>



                    <div id="dropMenu5" class="menuDrop">
<!--                        <a href="find3.php" onfocus="if (this.blur) this.blur();">חיפוש מורכב</a>-->
<!--                        <a href="forum_demo12.php" onfocus="if (this.blur) this.blur();">חיפוש לפי קטגוריות</a>-->
<!--                        <a href="bottle_neck.php" onfocus="if (this.blur) this.blur();">צוואר בקבוק</a>-->
                    </div>



                    <div id="dropMenu6" class="menuDrop">
<!--                        --><?php //if(!empty($_SESSION['level']) && !($_SESSION['level']=='user')){?>
<!--                            <a href="print_users.php" onfocus="if (this.blur) this.blur();">מיון+ ניהול טבלת המישתמשים</a>-->
<!--                        --><?php //}else{?>
<!--                            <a href="print_users.php" onfocus="if (this.blur) this.blur();">מידע כללי על משתמשים</a>-->
<!--                        --><?php //}?>
<!--                        <a href="print_history_users.php" onfocus="if (this.blur) this.blur();">ניהול טבלת היסטורית משתמשים</a>-->
<!--                        <!--<a href="print_Decuser_frm.php" onfocus="if (this.blur) this.blur();">ניהול משתמשים בעת קבלת ההחלטה</a>-->-->
<!--                        <a href="print_Decuser_frm_check.php" onfocus="if (this.blur) this.blur();">ניהול משתמשים בעת קבלת ההחלטה</a>-->
<!--                        <a href="bottle_neck.php" onfocus="if (this.blur) this.blur();">ניהול טבלת היסטורית מנהלים</a>-->
<!--                        <a href="bottle_neck.php" onfocus="if (this.blur) this.blur();">ניהול טבלת היסטורית ממנים</a>-->
                    </div>
                    <canvas id="logo" width="350" height="60" style="float: left">

                    </canvas>

                    <script>


                        var drawLogo = function(){
                            var canvas = document.getElementById('logo');
                            var context = canvas.getContext('2d');

                            context.fillStyle = "#f00";
                            context.strokeStyle = "#f00";
                            var gradient = context.createLinearGradient(0, 0, 0, 40);
                            gradient.addColorStop(0,   'blue'); // red
                            gradient.addColorStop(1,   'red'); // red
                            //gradient.addColorStop(0,   'pink'); // red
                            context.fillStyle = gradient;
                            context.strokeStyle = gradient;

                            context.font = 'italic 30px "sans-serif"';
                            context.textBaseline = 'top';
                            //context.fillText('החלטות', 60, 0);
                            context.fillText('pdf', 120, 0);

                            context.lineWidth = 3;
                            context.beginPath();
                            context.moveTo(0, 42);
                            context.lineTo(30, 0);
                            context.lineTo(60, 35 );
                            context.lineTo(170, 35 );
                            context.stroke();
                            context.closePath();

                            context.save();
                            context.translate(20,20);
                            context.fillRect(0,0,20,20);


                            context.fillStyle    = '#fff';
                            context.strokeStyle = '#fff';


                            context.lineWidth = 3;
                            context.beginPath();
                            context.moveTo(0, 20);
                            context.lineTo(10, 0);
                            context.lineTo(20, 20 );
                            context.lineTo(0, 20 );



                            context.fill();
                            context.closePath();
                            context.restore();
                        };
                        //END setup

                        $(function(){
                            var canvas = document.getElementById('logo');
                            if (canvas.getContext){
                                drawLogo();
                            }
                        });
                    </script>
                </div>

            </fieldset>


        </div>


    </div> <!-- end my_header -->



           <!--  <body>  -->

    <table border="0" cellpadding="0" cellspacing="0"  id="alon" dir="rtl" align="center" style="width:95%;">




    <tr>
        <td class="grey_welcome" id="grey_welcome" colspan="35"  height="40" style="width:100%;float:right;overflow:hidden;">


            &nbsp;&nbsp;
            <?PHP
            if(!empty($_SESSION['uname']) && $_SESSION['uname']!=null  ){
                echo '<h4 style="font-weight:bold;color:blue;">  מה קורה ?&nbsp;&nbsp;&nbsp;'.$_SESSION['uname'].'</h4>' ;
            }


            echo " <a href='".ROOT_WWW."/logout/index.php' style='float:right;height:50px;' class='my_logout'>[יציאה]</a> ";
            ?>


        </td>

    </tr>

    <tr>
    <td id="my_template_td" border="0">
    <br clear="all" >


    <?
    $GLOBALS['TEMPLATE']['content'] = ob_get_contents();
    ob_end_clean();
    ob_end_flush();
}//end header



function html_footer(){
    ?>
    </td>

    </tr>

    </table>


    </body>
    </html>

    <?php
}




