<?php

function build_form(&$formdata)
{
    global $db;
       if (array_item($formdata, 'brandID')) {
            $brandID = array_item($formdata, 'brandID');
            ?>
            <input type="hidden" id="brandID" name="brandID" value="<?php echo $brandID; ?>"/>
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
    ?>
  <div id="main">


<!--  <div id="wait" style="display:none;">-->
<!--    <img src="loading4.gif" border="0"  />-->
<!--  </div>-->

 <div id="loading" style="display:none;">
    <img src="loading4.gif" border="0"  />
  </div>

<!--  <div id="wait" width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">-->
<!--    <img src='loading4.gif' width="64" height="64" /><br>Loading..-->
<!--  </div>-->





<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <section class="col-xs-12">-->
      <?PHP if($level) { ?>
        <form style="width:95%;" name="brand_org"  id="brand_org" method="post" action="../admin/pdf_brand.php"
              onsubmit="prepSelObject(document.getElementById('dest_pdfs'));
                        prepSelObject(document.getElementById('dest_publishers'));
                        prepSelObject(document.getElementById('dest_brandsType'));
                        prepSelObject(document.getElementById('dest_managersType'));" >
        <?PHP }else{ ?>
               <form style="width:95%;" name="brand_org" id="brand_org" method="post"  action="../admin/sent_to_ftp.php"
              onsubmit="prepSelObject(document.getElementById('dest_pdfs'));
                        prepSelObject(document.getElementById('dest_publishers'));
                        prepSelObject(document.getElementById('dest_brandsType'));
                        prepSelObject(document.getElementById('dest_managersType'));" >
        <?PHP } ?>

<fieldset class="container">
 <div class="row">
                   <?php if($level){ ?>
                    <legend> מלא את הטופס להוספת  BRAND :</legend>
                    <?php }else{ ?>
                    <legend> טפסי  BRANDS:</legend>
                    <?php } ?>


                    <div class="wrapper_brand" style="width:100%">
                     <div id="brand_error" name="brand_error"></div>
                    <?PHP
                    $page_input = isset($formdata['pages']) ? $formdata['pages'] : '';
                    ?>
                    <input type="hidden" name="pdf_page_num"  id="pdf_page_num" value="<?PHP echo $page_input; ?>">
                    <?php

                    $dates = getdate();
//-----------------------------------------------------------
    $sql = "SELECT brandName, brandID FROM brands ORDER BY brandName";
    $rows1 = $db->queryArray($sql);


    $sql = "SELECT * FROM categories ORDER BY catName";
    $rows2 = $db->queryObjectArray($sql);
    foreach ($rows2 as $row) {

    if($row->catID == $row->parentCatID ){
         $my_catID =$row->catID;
            $sql = "UPDATE categories SET  parentCatID = '11'   WHERE catID = $my_catID";
                if (!$db->execute($sql))
                    return FALSE;
            }


    $subcatsftype2[$row->parentCatID][] = $row->catID;
    $catNamesftype2[$row->catID] = $row->catName;
    }
    $rows2 = build_category_array($subcatsftype2[NULL], $subcatsftype2, $catNamesftype2);

//--------------------------------------------------------
                    for ($i = 1; $i <= 150; $i++) {
                            $pages[] = $i;
                        }

//---------------------------------UPDATE------------------------------------------
                    if (array_item($formdata, 'brandID')) {

                        $brand_sql = "SELECT b.*,c.* FROM brands b
                        inner join categories c  
                        on b.catID = c.catID              
                        WHERE b.brandID = $brandID
                        ORDER BY b.brandName ASC";
                        $rows3 = $db->queryObjectArray($brand_sql);



                      $brand_sql2 = "SELECT  * FROM brands          
                                        WHERE brandID = $brandID
                                        ORDER BY b.branName ASC";
                      $rows4 = $db->queryObjectArray($brand_sql);

                      $rows4 = array_shift($rows4);

                      $brand_sql3 = "SELECT  * FROM brands          
                                        WHERE brandID = $brandID
                                        ORDER BY brandName ASC";
                      $rows5 = $db->queryArray($brand_sql3);



   if($level) {

//------------------------------------------------------------
$selected = array_item($formdata, "brandID");
?>


            <div class="form-group">
                <label for="brand_pdf">שם תכנית הברנד:</label>
                <select class="form-control" id="brand_pdf" name="form[brand_pdf]" style="width: 160px;"
                <option value="none">(choose)</option>
                <?PHP
                 foreach($rows1 as $row) {
                 echo '<option ', html_attribute("value", $row[1]);
                 if($selected==$row[1]){
                  echo 'selected="selected" ';
                }
                $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                echo ">$listentry</option>\n";
              }
            echo '</select>', "\n";
?>
        </div>
<?php

//-------------------------------------------------------------------------
?>

                          <div class="form-group">
                              <label for="num_page">מספר עמודים:</label>
                              <?PHP
                                   $selected =array_item($formdata, "pages");
                                    echo '<select class="form-control" id="pdf_page_num"  name="form[pdf_page_num]"  ',
                                    html_attribute("name", "form['pages']"), ' style="width:160px;">', "\n";
                                    echo '<option value="none">(choose)</option>';
                                    foreach($pages as $row) {
                                        echo '<option ', html_attribute("value", $row);
                                        if($selected==$row)
                                            echo 'selected="selected" ';
                                        $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row));
                                        echo ">$listentry</option>\n";
                                    }
                                    echo '</select>', "\n";
                              ?>
                          </div>



<?php
$date_value =  array_item($formdata, "brand_date2");
//-----------------------------------------------------------------------

$url = htmlspecial_utf8('create_brand.php');
?>
<!--                          <div class="form-group" >-->
<!--                              <label for="brand_date2" > תאריך הפצה: </label>-->
<!--                              <input class="form-control input-group  datepicker"  value="--><?php //echo $date_value; ?><!--"  name=form[brand_date2]   type="text" id="brand_date2" placeholder="תאריך הפצה" style="width:160px;" >-->
<!--                          </div>-->


                         <div class="form-group" style="width: 160px;">
                         <label for="brand_date2" > תאריך הפצה: </label>
                             <div class='input-group date datepicker' name="datepicker"  >
                                  <input type='text' class="form-control placementT" id="brand_date2" name="brand_date2"  value="<?php echo $date_value; ?>" >
                                     <span class="input-group-addon">
                                           <span class="glyphicon glyphicon-calendar">
                                           </span>
                                    </span>
                              </div>
                        </div>



                        <div class="form-group">
                           <a href=<?PHP echo $url; ?>  class='form_href'> ערוך ברנדים: </a>
                         </div>
<?php
                        $date_val = array_item($formdata, "brand_date2");
                        echo '<input type="hidden" id="brand_date3" value='.$date_val.'" >';


                        $page_val = array_item($formdata, "paegs");
                        echo '<input type="hidden" id="brandPage" value='.$page_val.'" >';


                      }
                      else{



//                             echo '<div class="myformtd 1" style="width:60%;">';
//                                    form_label_red1("שם הברנד:", true);
//                                //    form_list_b("brand_pdf", $rows, array_item($formdata, "brandID"),"id = brand_pdf");
//                                     form_list111("brand_pdf", $rows1, array_item($formdata, "brandID"),"id = brand_pdf");
//                                    form_empty_cell_no_td(10);
//                             echo '</div>';
$selected = array_item($formdata, "brandID");
?>


            <div class="form-group">
                <label for="brand_pdf">שם תכנית הברנד:</label>
                <select class="form-control" id="brand_pdf" name="form[brand_pdf]" style="width: 160px;"
                <option value="none">(choose)</option>
                <?PHP
                 foreach($rows1 as $row) {
                 echo '<option ', html_attribute("value", $row[1]);
                 if($selected==$row[1]){
                  echo 'selected="selected" ';
                }
                $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                echo ">$listentry</option>\n";
              }
            echo '</select>', "\n";
?>
        </div>
<?php

//-------------------------------------------------------------------------

                             $date_val = array_item($formdata, "brand_date2");
                              echo '<input type="hidden" id="brand_date3" value='.$date_val.'" >';


                              $prefix_val = array_item($formdata, "brandPrefix");
                              echo '<input type="hidden" id="brandPrefix" value='.$prefix_val.'" >';
                              $pdf_page_num = array_item($formdata, "pages");
                              echo '<input type="hidden" id="pdf_page_num" value='.$pdf_page_num.'" >';
                      }
                    }
//-----------------------SAVE--------------------------------------------
                  else{
                    if($level) {
                     ?>
                         <div class="form-group">
                          <label for="brand_pdf">סוג תוכנית הברנד:</label>
<!--                          <select class="form-control" id ="brand_pdf_type" name="form[brand_pdf]" style="width:160px;"-->

                          <?PHP
                           $selected =  array_item($formdata, "brandID");
                           echo ' <select class="form-control" id ="brand_pdf_type" name="form[brand_pdf]" ',
                           html_attribute("name", "form[brand_pdf]"), ' style="width:160px;">', "\n";
                           echo '<option value="none">(choose)</option>';
                           foreach($rows2 as $row) {
                             echo '<option ', html_attribute("value", $row[1]);
                            if( !($row[1] == '11')) {
                             if($selected==$row[1])
                               echo 'selected="selected" ';
                             $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                             echo ">$listentry</option>\n";
                           }
                           }
                            ?>
                           </select>
                         </div>





                         <div class="form-group">
                              <label for="num_page">מספר עמודים:</label>
                              <?PHP
                                   $selected =array_item($formdata, "pages");
                                    echo '<select class="form-control" id="pdf_page_num"  name="form[pdf_page_num]"  ',
                                    html_attribute("name", "form['pages']"), ' style="width:160px;">', "\n";
                                    echo '<option value="none">(choose)</option>';
                                    foreach($pages as $row) {
                                        echo '<option ', html_attribute("value", $row);
                                        if($selected==$row)
                                            echo 'selected="selected" ';
                                        $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row));
                                        echo ">$listentry</option>\n";
                                    }
                                    echo '</select>', "\n";
                              ?>
                          </div>
<?php
$date_value =  array_item($formdata, "brand_date2");
?>
                        <div class="form-group" style="width: 160px;">
                         <label for="brand_date2" > תאריך הפצה: </label>
                             <div class='input-group date datepicker' name="datepicker"  >
                                  <input type='text' class="form-control placementT" id="brand_date2" name="brand_date2"  value="<?php echo $date_value; ?>" >
                                     <span class="input-group-addon">
                                           <span class="glyphicon glyphicon-calendar">
                                           </span>
                                    </span>
                              </div>
                        </div>



<!--                        <div class="form-group" >-->
<!--                              <label for="brand_date2" > תאריך הפצה: </label>-->
<!--                              <input class="form-control input-group  datepicker"  value="--><?PHP // echo $date_value; ?><!--"  name=form[brand_date2]   type="text" id="brand_date2" placeholder="תאריך הפצה" style="width:160px;" >-->
<!--                          </div>-->



<?PHP
                     }else{
 //------------------------------------------------------------------------------------------

  $selected =  array_item($formdata, "brandID");

                     ?>
                        <div class="form-group">
                          <label for="brand_pdf">תוכנית הברנד:</label>

                          <select class="form-control" id ="brand_pdf" name="form[brand_pdf]" style="width: 160px;"
                             <option value="none">(choose)</option>
                          <?PHP
                           $selected =  array_item($formdata, "brandID");
                           foreach($rows1 as $row) {
                             echo '<option ', html_attribute("value", $row[1]);
                             if($selected==$row[1])
                               echo 'selected="selected" ';
                             $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
                             echo ">$listentry</option>\n";
                           }
                            ?>
                           </select>
                        </div>

                  <?PHP
//------------------------------------------------------------------------------------------
                       $date_val = array_item($formdata, "brand_date2");
                      echo '<input type="hidden" id="brand_date3" value='.$date_val.'" >';


                      $prefix_val = array_item($formdata, "brandPrefix");
                      echo '<input type="hidden" id="brandPrefix" value='.$prefix_val.'" >';
                      }
                    }

//---------------------------BUTTON-------------------------------------------
           if ($level) {
?>
<button class="btn btn-primary"  type="submit" OnClick="
                                            prepSelObject(document.getElementById('dest_brandsType'));
                                            prepSelObject(document.getElementById('dest_managersType'));
                                            prepSelObject(document.getElementById('dest_pdfs'));
                                            " >שמור</button>
<?php
           }


                $tmp = (array_item($formdata, "brandID")) ? "update" : "save";
                $formdata["brandID"] = isset($formdata["brandID"]) ? $formdata["brandID"] : '';
                $formdata["insertID"] = isset($formdata["insertID"]) ? $formdata["insertID"] : '';
                echo '<div>';
                form_hidden3("mode", $tmp, 0, "id=mode_" . $formdata["brandID"]);
                form_hidden("brandID", $formdata["brandID"]);
                form_hidden("insertID", $formdata["insertID"]);
                echo '</div>';

//------------------------------------------------------------------------------
 if (array_item($formdata, 'brandID')) {
global $dbc,$db;

  $sql = "SELECT * FROM brands WHERE brandID=$brandID";
    if( $rows1 = $db->queryObjectArray($sql)) {
        $brandPrefix = $rows1[0]-> brandPrefix;

     }

$sql = "SELECT * FROM pdfs ORDER BY date_created DESC";
    if( $rows = $db->queryObjectArray($sql)) {
        $pdf_names = array();
        foreach($rows as $row){
             $pdf_names[] = $row-> pdfName;
        }
     }
//---------------------------------------------------------------------------------
if( isset($formdata['brand_date2']) ){
    $dayOfWeek = date("l", strtotime($formdata['brand_date2']));
    switch ($dayOfWeek ) {
        case "Sunday":
            $dayOfWeek = "7";
            break;
        case "Monday":
            $dayOfWeek = "1";
            break;

        case "Tuesday":
            $dayOfWeek = "2";
            break;
        case "Wednesday":
            $dayOfWeek = "3";
            break;
        case "Thursday":
            $dayOfWeek = "4";
            break;
        case "Friday":
            $dayOfWeek = "5";
            break;
        case "Saturday":
            $dayOfWeek = "6";
            break;
        default:
        case "":
            break;
    }
 if(!empty($dayOfWeek) && isset($formdata['brandPrefix']) ) {
           $page_num =      isset($formdata['pages']) ? $formdata['pages'] : '';
           $brandPrefix =   $formdata['brandPrefix'];

           if($rows3[0]->catName == "חדשות"){
               $brandPrefix =   str_replace("{{date}}", $dayOfWeek , $brandPrefix);
           }
           $brandPrefixArr = array();
           $html = '';
           $html .= '<div class="image_block row" id="display_div" >';

        for($k = 0,$i = 0; $i<$page_num ; $i++){
            $m = $i +1;

               if($m<10){
               $brandPrefixArr[$i] = $brandPrefix."p00".$m.".pdf";
               }elseif ($m<100 && $m>=10 ){
                $brandPrefixArr[$i] = $brandPrefix."p0".$m.".pdf";
               }elseif ($m>=100){
                $brandPrefixArr[$i] = $brandPrefix."p".$m.".pdf";
               }
//template for new
                $new_name = explode('.pdf',$brandPrefixArr[$i]);
                $new_name =  $new_name[0];
                $new_name = $new_name.'_new.pdf';

                if($formdata['brandPrefix'] == "ayom{{date}}"){
//------------------------------------------------------------------------------
               if(empty($pdf_names) || ( !(in_array($brandPrefixArr[$i],$pdf_names)) &&  !(in_array($new_name,$pdf_names)) ) ){
                            $html .= '<div class="col-xs-3" id=""  style="margin-top: 50px;" >';
                                    $html .=  "<div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;background: grey;\">
                                                    <div id='my_pdfs_$i'>
                                                        <h4>
                                                             <a class='my_href_li' href=\"#\">
                                                             </a>
                                                         </h4>
                                                      </div>
                                                      
                                                      </div>\n";
                                    $html .=  '<br/></div>';
               }
//------------------------------------------------------------------------------
               else{
                 foreach($rows as $row){
                    if($brandPrefixArr[$i] == $row->pdfName  || $new_name == $row->pdfName     ){
                    $file_name = explode('.',$row->pdfName);
                        $file_name =  $file_name[0];
                        $tmp_name  =  $file_name;
                        $file_name = $file_name.'.jpg';
                         $html .=   '<div class="col-xs-3">';
                         $html .=   "({$row->size}kb) <p  style='font-weight:bold;color:brown;'>{$row->pdfName}</p><div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;\">";

                                      if($level) {
                                                 if($row->isChange == 'unchange') {
                                                    $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled checked >
                                                          </div>";
                                                    $k++;
                                                   }else{
                                                      $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled  >
                                                          </div>";
                                                   }
                                                }else{
                                                    if($row->isChange == 'unchange') {
                                                      $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' checked >
                                                        </div>";
                                                      $k++;
                                                      }else{
                                                            $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;'  >
                                                        </div>";
                                                      }
                                                }
                                             $pdf_name= explode('.pdf',$row->pdfName)  ;
                                             $pdf_name = $pdf_name[0];
                                     $html .=  "<div >
                                                <div  id='my_pdfs{$pdf_name}'>
                                                <a class='my_href_li' href= '".PDF_WWW_DIR."{$row->pdfName}' >
                                                    <img src ='".CONVERT_PDF_TO_IMG_WWW_DIR."/{$file_name}' style='box-sizing: border-box;widht:100%; height: 297px;margin-top:-28px;' >
                                                </a>
                                           </div>
                                      </div>
                                    </div>\n";
                         $html .=   '<br/>
                                   </div>';
                         //change status will be highlighting
                              if( ($new_name == $row->pdfName  && !($row->isChange == 'unchange')) ||  ($brandPrefixArr[$i] == $row->pdfName  && !($row->isChange == 'unchange'))   )   {
                             ?>
                             <input type="hidden" name="modify_elem" class="modify_elem" value="modify">
                               <script type="text/javascript">
                                 $(document).ready(function() {
                                var brand_name = '<?php echo $pdf_name; ?>';
                                $('#my_pdfs'+brand_name).addClass('my_task change_elem');
                                    turn_red_task();
                                  });
                                </script>
                                <?PHP
                          }
                     break;
                  }
                }//end foreach
             }
         }
//------------------------------------------------------------------------------
          elseif ($brandPrefix == "ispo1" ||  $brandPrefix == "issh1") {
           if(empty($pdf_names) || ( !(in_array($brandPrefixArr[$i],$pdf_names)) &&  !(in_array($new_name,$pdf_names)) ) ){
                            $html .= '<div class="col-xs-3" id=""  style="margin-top: 50px;" >';
                                    $html .=  "<div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;background: grey;\">
                                                    <div id='my_pdfs_$i'>
                                                        <h4>
                                                             <a class='my_href_li' href=\"#\">
                                                             </a>
                                                         </h4>
                                                      </div>
                                                      
                                                      </div>\n";
                                    $html .=  '<br/></div>';
               }
//------------------------------------------------------------------------------ 0
               else{
               foreach($rows as $row){
                    if($brandPrefixArr[$i] == $row->pdfName  || $new_name == $row->pdfName   ){
                    $file_name = explode('.',$row->pdfName);
                        $file_name =  $file_name[0];
                        $tmp_name  =  $file_name;
                        $file_name = $file_name.'.jpg';
                         $html .=   '<div class="col-xs-3">';
                         $html .=   "({$row->size}kb) <p  style='font-weight:bold;color:brown;'>{$row->pdfName}</p><div style=\"border-radius:3px;width:250px;height:300px; border:#cdcdcd solid 1px;\">";
                                       if($level) {
                                                 if($row->isChange == 'unchange') {
                                                    $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled checked >
                                                          </div>";
                                                    $k++;
                                                   }else{
                                                      $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' disabled  >
                                                          </div>";
                                                   }
                                                }else{
                                                    if($row->isChange == 'unchange') {
                                                      $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;' checked >
                                                        </div>";
                                                      $k++;
                                                      }else{
                                                            $html .=  "<div  style='margin-right: 224px;'>
                                                            <input type='checkbox' name = 'checkbox[]' class='olive_cbx' id=$tmp_name style='zoom: 1.7;'  >
                                                        </div>";
                                                      }
                                                }
                                     $pdf_name= explode('.pdf',$row->pdfName)  ;
                                     $pdf_name = $pdf_name[0];
                                     $html .=  "<div >
                                                <div   id='my_pdfs{$pdf_name}'>
                                                <a class='my_href_li' href= '".PDF_WWW_DIR."{$row->pdfName}' >
                                                    <img src ='".CONVERT_PDF_TO_IMG_WWW_DIR."/{$file_name}' style='box-sizing: border-box;widht:100%; height: 297px;margin-top:-28px;' >
                                                </a>
                                           </div>
                                      </div>
                                    </div>\n";
                         $html .=   '<br/>
                                   </div>';
                         $pdf_name= explode('.pdf',$row->pdfName)  ;
                         $pdf_name = $pdf_name[0];
                          if(  $new_name == $row->pdfName && $row->isChange == 'change' ||  ($brandPrefixArr[$i] == $row->pdfName  && !($row->isChange == 'unchange') )  )  {
                             ?>
                             <input type="hidden" name="modify_elem" class="modify_elem" value="modify">
                               <script type="text/javascript">
                                 $(document).ready(function() {
                                var brand_name = '<?php echo $pdf_name; ?>';
                                $('#my_pdfs'+brand_name).addClass('my_task change_elem');
                                    turn_red_task();
                                  });
                                </script>
                                <?PHP
                     }
                     break;
                  }
                }//end foreach
         }//end else
        }//end ifelse
//-------------------------------------------------------------------------------
       }//end for
       if($k==$page_num){

                    $html .=  "<div>
                                  <button type='submit' class='btn btn-primary'  id='send_pdf'  name=form['submitpdf']  style='margin: 10px 30px 20px 0;height: 38px;' >  SEND PDF TO FTP  </button>     
                                  <br/>     
                               </div>\n";
                    }
                    echo $html;
    }//end day of the week
//------------------------------------------------------------------------------
  }//end brand_date2
}//end array_item
//---------------------------------------------------------------------------------

             echo '</div></fieldset></form></div><!-- row -->';

}//end build_form























































