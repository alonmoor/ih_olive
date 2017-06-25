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
    <head id="my_header clearfix" >
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='-1'>
        <meta http-equiv='pragma' content='no-cache'>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>מערכת ניהול PDF</title>





        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-ui-1.8.16.custom.min.js"           type="text/javascript"> </script>
        <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.autocomplete.min.js"  charset="utf-8"   type="text/javascript"></script>
               <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.form.js"        charset="utf-8"        type="text/javascript"></script>


        <script  language=javascript" src="<?php print  JQ_ADMIN_WWW ?>/date_picker.js"           charset="utf-8"        type="text/javascript"></script>
        <script language="JavaScript"  src="<?php print JS_ADMIN_WWW ?>/SelectObjectMethods.js"   charset="utf-8"     type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi.js"             charset="utf-8"          type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi_user.js"         charset="utf-8"              type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/find_pagination.js"      charset="utf-8"       type="text/javascript"></script>
        <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/dhtmlwindow.js"  charset="utf-8"   type="text/javascript"></script>

        <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/user_edit.js" type="text/javascript"></script>






        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/themes/start/jquery-ui-1.8.16.custom.css" />
        <link rel="stylesheet" type="text/css" media="all"    href="<?php echo CSS_DIR ?>/paginated.css" />
        <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/dhtmlwindow.css"  />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/treeview.css" />






<!-- Include Date Range Picker -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/he.js"></script>


    <script language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/info_brand.js" type="text/javascript"></script>




<!-- ------------------------------------------------------------------------------------------- -->



<?PHP
    if($_SERVER['SCRIPT_NAME'] == "/admin/create_brand.php"){
    echo '<div id="create_brand">';
}elseif($_SERVER['SCRIPT_NAME'] == "/admin/brand_plan.php"){
    echo '<div id="brand_plan">';
}
?>





<nav class="navbar navbar-default navbar-inverse" role="navigation"  >
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#featured">מערכת <span class="subhead">PDF</span></a>
      </div><!-- navbar-header -->
      <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav navbar-right">
          <?php if($level) { ?>
           <li><a href="brand_plan.php">בניית תוכנית עבודה</a></li>
           <li><a href="create_brand.php">הקמה של ברנד</a></li>
            <?php }else{ ?>
            <li class="active"><a href="brand_plan.php">צפייה ואישור תוכנית עבודה</a></li>
            <?php } ?>
          <a href=<?php echo ROOT_WWW ?>'/logout/index.php' style='float:right;height:50px;' class='my_logout'>[יציאה]</a>
        </ul>
      </div><!-- collapse navbar-collapse -->
    </div><!-- container -->
  </nav>
</div>





    </head>

    <body id="my_body" style="direction: rtl;">




<div id=my_header2>
        <div  id="template_page">
            <fieldset  id="template_fieldset"  >






<div>

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
                            context.fillText('olive', 140, 0);

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

    <table border="0" cellpadding="0" cellspacing="0"  id="alon" dir="rtl" align="center" style="width:95%;">




    <tr>
        <td class="grey_welcome" id="grey_welcome" colspan="35"  height="40" style="width:100%;float:right;overflow:hidden;">


            &nbsp;&nbsp;
            <?PHP
            if(!empty($_SESSION['uname']) && $_SESSION['uname']!=null  ){
             //   echo '<h4 style="font-weight:bold;color:blue;">  מה קורה ?&nbsp;&nbsp;&nbsp;'.$_SESSION['uname'].'</h4>' ;
            }
            //echo " <a href='".ROOT_WWW."/logout/index.php' style='float:right;height:50px;' class='my_logout'>[יציאה]</a> ";
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




