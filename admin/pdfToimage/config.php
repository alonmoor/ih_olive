<?php
//Configuration file
//Description: Specify common variable
// Created By : Satish Kumar(satish.prg@gmail.com)
//Date: Jan 6, 2009
#Create following folder and  give write permission
#CHMOD 777 
# 1. zip folder
# 2. book folder

$dir=dirname(__FILE__)."/";

define('PDF_FILE',$dir.'Reports_Presentation_2.pdf');
define('IMAGE_LOCATION',$dir.'book/pages/');
define('IMAGE_FOLDER',$dir.'book/pages/images/');
define('XML_LOCATION',$dir.'book/');
define('ZIP_LOCATION',$dir.'zip/book.zip');
?>
