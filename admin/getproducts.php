<?php
require_once ("../config/application.php");
global $db,$dbc;
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
	
	if(isset($action)) {
        if ($action == "showAll") {
// Get the PDFs:
            $q = 'SELECT * FROM pdfs ORDER BY date_created DESC';
            $r = mysqli_query($dbc, $q);
//-------------------------------------------------------------------
                if (mysqli_num_rows($r) > 0) { // If there are some...
                    // Fetch every one:
                    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                        // Display each record:
                        echo '<div class="col-xs-3">';
                        echo "<div style=\"border-radius:3px; border:#cdcdcd solid 1px; padding:22px;\"> <div id='my_pdfs'><h4><a class='my_href_li' href=\"dynamic_5_demo.php?mode=view_pdfs&id={$row['tmpName']}\">{$row['title']}</a> ({$row['size']}kb)</h4><p  style='font-weight:bold;color:brown;'>{$row['pdfName']}</p></div></div>\n";
                        echo '<br/></div>';
                    } // End of WHILE loop.
                } else { // No PDFs!
                    echo '<p>אנא חזור מאוחר יותר pdf -כרגע אין חומר עדכני של קבצי </p>';
                }
//------------------------------------------------------------------
           echo '</div>';
        }
    }else{
	    return false;
    }