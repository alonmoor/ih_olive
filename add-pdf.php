<?php
/**
 * Created by PhpStorm.
 * User: alon
 * Date: 30/04/17
 * Time: 01:39
 */
function add_pdf(){

    global $dbc;


// Include the header file:
    $page_title = ' PDF -הוסף קבצי';
// For storing errors:
    $add_pdf_errors = array();
    /*** maximum filesize allowed in bytes ***/
    $max_file_size  = 512000;

    /*** the maximum filesize from php.ini ***/
    $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
    $upload_max = $ini_max * 1024;




// Check for a form submission:
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Check for a title:
        if (!empty($_POST['title'])) {
            $t = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
        } else {
            $add_pdf_errors['title'] = 'אנא הזן כותרת!';
        }

        // Check for a description:
        if (!empty($_POST['description'])) {
            $d = mysqli_real_escape_string($dbc, strip_tags($_POST['description']));
        } else {
            $add_pdf_errors['description'] = 'אנא הזן תאור!';
        }

//-----------------------------------------------------------------------------
////            //Loop through each file
//            for ($i = 0; $i < count($_FILES['pdf']['tmp_name']); $i++) {
//                // Check for a PDF:
//                if (is_uploaded_file ($_FILES['pdf']['tmp_name'][$i]) && ($_FILES['pdf']['error'][$i] == UPLOAD_ERR_OK)) {
//                    $file = $_FILES['pdf'];
//                    $size = ROUND($file['size'][$i]/1024);
//                    // Validate the file size:
//                    if ($size > 1024) {
//                        $add_pdf_errors['pdf'] = 'הקובץ היה גדול מידיי!';
//                    }
//                    // Validate the file type:
//                    if ( ($file['type'][$i] != 'application/pdf') && (substr($file['name'][$i], -4) != '.pdf') ) {
//                        $add_pdf_errors['pdf'] = 'הקובץ הוא לא מסוג-PDF';
//                    }
//                    // Move the file over, if no problems:
//                    if (!array_key_exists('pdf', $add_pdf_errors)) {
//                        // Create a tmp_name for the file:
//                        $tmp_name = sha1($file['name'][$i] . uniqid('',true));
//                        // Move the file to its proper folder but add _tmp, just in case:
//                        $dest =  PDFS_DIR . $tmp_name . '_tmp';
//                        if (move_uploaded_file($file['tmp_name'][$i], $dest)) {
//                            // Store the data in the session for later use:
//                            $_SESSION['pdf']['tmp_name'][$i] = $tmp_name;
//                            $_SESSION['pdf']['size'][$i] = $size;
//                            $_SESSION['pdf']['file_name'] [$i]= $file['name'][$i];
//                            // Print a message:
//                            echo '<h4>הקובץ הועלה!</h4>';
//                        } else {
//                            trigger_error('אי אפשר להזיז את הקובץ.');
//                            unlink ($file['tmp_name']);
//                        }
//                    } // End of array_key_exists() IF.
//                }
//            }





//                //Get the temp file path
//                $tmpFilePath = $_FILES['pdf']['tmp_name'][$i];
//
//                //Make sure we have a filepath
//                if ($tmpFilePath != "") {
//
//                    //save the filename
//                    $shortname = $_FILES['pdf']['tmp_name'][$i];
//
//                    //save the url and the file
//                    $filePath = "uploaded/" . date('d-m-Y-H-i-s') . '-' . $_FILES['upload']['name'][$i];
//
//                    //Upload the file into the temp dir
//                    if (move_uploaded_file($tmpFilePath, $filePath)) {
//
//                        $files[] = $shortname;
//                        //insert into db
//                        //use $shortname for the filename
//                        //use $filePath for the relative url to the file
//
//                    }
//                }








//-----------------------------------------------------------------------------
        // Check for a PDF:
        if (is_uploaded_file ($_FILES['pdf']['tmp_name']) && ($_FILES['pdf']['error'] == UPLOAD_ERR_OK)) {
            $file = $_FILES['pdf'];
            $size = ROUND($file['size']/1024);
            // Validate the file size:
            if ($size > 2048) {
                $add_pdf_errors['pdf'] = 'הקובץ היה גדול מידיי!';
            }
            // Validate the file type:
            if ( ($file['type'] != 'application/pdf') && (substr($file['name'], -4) != '.pdf') ) {
                $add_pdf_errors['pdf'] = 'הקובץ הוא לא מסוג-PDF';
            }
            // Move the file over, if no problems:
            if (!array_key_exists('pdf', $add_pdf_errors)) {
                // Create a tmp_name for the file:
                $tmp_name = sha1($file['name'] . uniqid('',true));
                // Move the file to its proper folder but add _tmp, just in case:
                $dest =  PDFS_DIR . $tmp_name . '_tmp';
                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    // Store the data in the session for later use:
                    $_SESSION['pdf']['tmp_name'] = $tmp_name;
                    $_SESSION['pdf']['size'] = $size;
                    $_SESSION['pdf']['file_name'] = $file['name'];
                    // Print a message:
                    echo '<h4>הקובץ הועלה!</h4>';
                } else {
                    trigger_error('אי אפשר להזיז את הקובץ.');
                    unlink ($file['tmp_name']);
                }
            } // End of array_key_exists() IF.
        } elseif (!isset($_SESSION['pdf'])) { // No current or previous uploaded file.
            switch ($_FILES['pdf']['error']) {
                case 1:
                case 2:
                    $add_pdf_errors['pdf'] = '.הקובץ גדול מידיי';
                    break;
                case 3:
                    $add_pdf_errors['pdf'] = '.הקובץ עלה באופן חלקי';
                    break;
                case 6:
                case 7:
                case 8:
                    $add_pdf_errors['pdf'] = '.הקובץ לא עלה בגלל בעיות במערכת';
                    break;
                case 4:
                default:
                    $add_pdf_errors['pdf'] = '.לא נימצא קובץ';
                    break;
            } // End of SWITCH.

        } // End of $_FILES IF-ELSEIF-ELSE.

        if (empty($add_pdf_errors)) { // If everything's OK.
            //if($_SESSION['pdf']['file_name'])
            // Add the PDF to the database:
            $fn = mysqli_real_escape_string($dbc, $_SESSION['pdf']['file_name']);
            $tmp_name = mysqli_real_escape_string($dbc, $_SESSION['pdf']['tmp_name']);
            $size = (int) $_SESSION['pdf']['size'];
            $q = "INSERT INTO pdfs (tmp_name, title, description, file_name, size) VALUES ('$tmp_name', '$t', '$d', '$fn', $size)";
            $r = mysqli_query ($dbc, $q);
            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
                // Rename the temporary file:
                $original =  PDFS_DIR . $tmp_name . '_tmp';
                $dest =  PDFS_DIR . $tmp_name;
                rename($original, $dest);

                // Print a message:
                echo '<h4>היתווסף PDF!</h4>';

                // Clear $_POST:
                $_POST = array();

                // Clear $_FILES:
                $_FILES = array();

                // Clear $file and $_SESSION['pdf']:
                unset($file, $_SESSION['pdf']);

            } else { // If it did not run OK.
                trigger_error('The PDF could not be added due to a system error. We apologize for any inconvenience.');
                unlink ($dest);
            }

        } // End of $errors IF.

    } else { // Clear out the session on a GET request:
        unset($_SESSION['pdf']);
    } // End of the submission IF.
