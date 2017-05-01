<?php

/**
 * Created by PhpStorm.
 * User: alon
 * Date: 01/05/17
 * Time: 19:16
 */
require_once("../config/application.php");
require_once(LIB_DIR . '/model/class.handler.php');
require_once(ADMIN_DIR . '/ajax2.php');
//require_once HTML_DIR . '/edit_pdf.php';
class digiBook
{
    public $convert_status = 0;

    function __construct()
    {
        $convert_status = 0;
        if (is_dir("book") == false) {
            echo "Please create folder 'book'<br>";
            exit;
        }
        if (is_dir("book/pages/") == false) {
            echo "Please create folder 'book\pages'<br>";
            exit;
        }
        if (is_dir("zip") == false) {
            echo "Please create folder 'zip'<br>";
            exit;
        }
    }

    function mkdir_r($dirName, $rights = 0777)
    {
        $dirs = explode('/', $dirName);
        $dir = '';
        foreach ($dirs as $part) {
            $dir .= $part . '/';
            if (!is_dir($dir) && strlen($dir) > 0)
                mkdir($dir, $rights);
        }
    }
//Function to convert  pdf files to jpg
//Requires : IMAGEMAGICK
    function convertPDF2JPG($pdf_file, $jpgloc)
    {
        $cmd = "convert " . $pdf_file . " " . $jpgloc;
        $status = exec($cmd);
        $convert_status = $status;
        return $convert_status;
    }

    //Function to read directory
    function readFolderDirectory($dir)
    {

        $listDir = array();
        if ($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if (is_file($dir . "/" . $sub)) {
                        $listDir[] = $sub;
                    } elseif (is_dir($dir . "/" . $sub)) {
                        $listDir[$sub] = digiBook::ReadFolderDirectory($dir . "/" . $sub);
                    }
                }
            }
            closedir($handler);
        }
        return $listDir;

    }

    //Creating and populating xml file for digibook
    //function name :CreateXMLFile
    //arguments : xmlfile  and image location
    function createXMLFile($xmlfile, $imgloc)
    {
        $stringDataBody = '';
        $dir = digiBook::readFolderDirectory($imgloc);//Open location  of  image sliced
        $fh = fopen($xmlfile, 'w') or die("can't open file");
        $stringDataTop = '<?xml version="1.0" encoding="iso-8859-1"?>
<datas>';
        for ($i = 0; $i < sizeof($dir); $i++) {
            $file = "page-" . $i . ".jpg";
            $stringDataBody .= '<data><image>' . "pages/" . $file . ' </image>  <url>' . "pages/" . $file . '</url>
  <text>Page: ' . $i . '</text></data>';
            echo "Extracting..." . $file . "<br>";
        }
        $stringDataBottom = ' 
</datas>';
        fwrite($fh, $stringDataTop . $stringDataBody . $stringDataBottom);//Write file name to xml file
        fclose($fh);
    }

}