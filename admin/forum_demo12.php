<?php
require_once '../config/application.php';
if(!isAjax())
    html_header();
$yearList = '';
$forumList = '';
$formdata=array();
//--------------------------------------------------------------------------------------------
?>
    <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_dec.js"  type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var accOpts = {
                fillSpace: true,
                autoHeight: true,
                autoWidth: true,
                clearStyle: true,
                active: false,
                collapsible: true
            };
            $( '#main_accordion > div' ).hide();
            $('#main_accordion h4').click(function() {
                $(this).next().animate(
                    {'height':'toggle'}, 'slow', 'easeOutBounce'
                );
            });
        });
    </script>
    <div id="main_accordion" class="ui-widget ui-helper-reset" style="margin-right:10px; ">
        <!-- ----------------------------------------DEC_CATEGORY1------------------------------------------------- -->
        <h4 class="ui-widget-header ui-corner-all" style="width:82%;" >קטגוריות ישראל היום</h4>
        <div class="ui-widget-content" style="width:82%;">
            <form class="myformcategory" name="find_cat_dec" id="find_cat_dec" method="post" action="results_forum9.php" >
                <fieldset class="my_fieldset_src"><h1>קטגוריות(סיווגים)</h1></legend>
                    <script  language="JavaScript" type="text/javascript">
                        $(document).ready(function(){
                            $("#<?php echo $member_date; ?>").datepicker( $.extend({}, {showOn: 'button',
                                buttonImage: '<?php echo IMAGES_DIR ;?>/calendar.gif', buttonImageOnly: true,
                                changeMonth: true,
                                changeYear: true,
                                showButtonPanel: true,
                                buttonText: "Open date picker",
                                dateFormat: 'yy-mm-dd',
                                altField: '#actualDate'}, $.datepicker.regional['he']));
                        });
                    </script>
                    <div id="num_page">
                        <?PHP
                        form_label("הזן מספר עמודים:", true);
                        for ($i = 1; $i <= 50; $i++) {
                            $pages[$i] = $i;
                        }
                        form_list2("pages",$pages);
                        ?>
                    </div>
                    <table id="cat_dec_dest1" class="myformtable" style="width:60%" >
                        <?php
                        global $db;
                        form_new_line();
                     //   form_label("קטגוריות של קבצים:",TRUE);
                        // get all categories
                        $sql = "SELECT  brandName, brandID FROM brands ORDER BY brandName";
                        $rows = $db->queryArray($sql);
//                        foreach($rows as $row) {
//                            $subcats_a[$row->parentBrandID][] = $row->brandID;
//                            $catNames_a[$row->brandID] = $row->brandName; }
//                        $rows = build_category_array($subcats_a[NULL], $subcats_a, $catNames_a);
                        //form_list_find("category_dec","category_dec", $rows , array_item($formdata, "category_dec"));
                      //  form_list111("brand_pdf", $rows, array_item($formdata, "brandID"),"id = brand_pdf");


                        echo '<div class="myformtd 1" style="width:60%;">';
                        form_label_red1("שם תכנית הברנד:", true);
                        form_list111("brand_pdf", $rows, array_item($formdata, "brandID"),"id = brand_pdf");
                        form_empty_cell_no_td(10);
                        echo '</div>';



                        form_button ("btnTitle", "הראה נתונים");
                        form_end_line();
                        ?>
                    </table>
                    <div id="loading">
                        <img src="loading4.gif" border="0" />
                    </div>
                </fieldset>
            </form>
        </div>
        <!--  ------------------------------------------------------------------------- -->
    </div><!-- end div main -->
<?php
html_footer();
?>