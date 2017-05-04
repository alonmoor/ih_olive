<?php
require_once ("../config/application.php");
global $db,$dbc;
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
    $action2 = isset($_REQUEST['action2']) ? $_REQUEST['action2'] : null;
	if(isset($action)) {
        if ($action == "showAll") {
// Get the PDFs:

$page_number = isset($_GET['num']) ? $_GET['num'] : 0 ;


            $q = 'SELECT * FROM pdfs ORDER BY date_created DESC';
            $r = mysqli_query($dbc, $q);
//-------------------------------------------------------------------
                if (mysqli_num_rows($r) > 0) { // If there are some...
                    // Fetch every one:
                   // $node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_forum&appointID=%s", $code));
                    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                        // Display each record:
                        $file_name = explode('.',$row['pdfName']);
                        $file_name =  $file_name[0];
                        $tmp_name  =  $file_name;
                        $file_name = $file_name.'.jpg';
                        echo '<div class="col-xs-3">';
                        echo "<div style=\"border-radius:3px; border:#cdcdcd solid 1px; padding:22px;\"> <div id='my_pdfs{$row['pdfName']}'><h4>
                                <a class='my_href_li' href=\"dynamic_5_demo.php?mode=view_pdfs&id={$row['tmpName']}\">
                                <img src ='".CONVERT_PDF_TO_IMG_WWW_DIR."/{$file_name}' >
                                </a> ({$row['size']}kb)</h4><p  style='font-weight:bold;color:brown;'>{$row['pdfName']}</p></div>
                                <input type='checkbox' id=$tmp_name >
                              </div>\n";
                        echo '<br/></div>';
                    } // End of WHILE loop.
                } else { // No PDFs!
                    echo '<p>אנא חזור מאוחר יותר pdf -כרגע אין חומר עדכני של קבצי </p>';
                }
//------------------------------------------------------------------
           echo '</div>';
        }
    }
    elseif (isset($action2) &&  isset($_GET['page_num']) && is_numeric($_GET['page_num'])){


        for ($i = 0; $i < $num_page ; $i++) {
            // Display each record:
            $file_name = explode('.',$row['pdfName']);
            $file_name =  $file_name[0];
            $tmp_name  =  $file_name;
            $file_name = $file_name.'.jpg';
            echo '<div class="col-xs-3">';
            echo "<div style=\"border-radius:3px; border:#cdcdcd solid 1px; padding:22px;\"> 
                            <div id='my_pdfs_$i'>
                                <h4>
                                     <a class='my_href_li' href=\"#\">
                                     </a> 
                                 </h4>
                              </div>
                                <input type='checkbox' id= improve_$i>
                              </div>\n";
            echo '<br/></div>';
        } // End of WHILE loop.
    }
    else{
	    return false;
    }