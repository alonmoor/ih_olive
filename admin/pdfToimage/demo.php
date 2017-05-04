<?php
//http://www.imagemagick.org/Usage/api/#php
//https://www.youtube.com/watch?v=XrF0nh1mB2Y&list=PLCYKSB2M1V__dOTFNxmYgyiKlqZn1-yzC&index=12
require_once(dirname(__FILE__).'/digiBook.php');//configuration file


//----------------------------------------------------------------------------
//http://snipplr.com/view/48513/pdf2jpg--convert-pdf-to-jpg-images-with-imagemagick/
$pdf_file   =  PDF_FILE;// './pdf/demo.pdf';
$save_to    =  IMAGE_LOCATION.'demo.jpg';//$dir.'demo.jpg';//   './jpg/demo.jpg';     //make sure that apache has permissions to write in this folder! (common problem)

//execute ImageMagick command 'convert' and convert PDF to JPG with applied settings
exec('convert "'.$pdf_file.'" -colorspace RGB -resize 800 "'.$save_to.'"', $output, $return_var);
exec("convert -density 100 -colorspace rgb test.pdf -scale 200x200 test.jpg");

if($return_var == 0) {              //if exec successfuly converted pdf to jpg
    print "Conversion OK";
}
else print "Conversion failed.<br />".$output;

//----------------------------------------------------------------------------





$im = new imagick($dir.'Reports_Presentationnnnnnnnnnn_22.pdf'); $im->setImageFormat('jpg'); header('Content-Type: image/jpeg'); echo $im;

$imagick = new Imagick();
$imagick->readImage(PDF_FILE);
$imagick->writeImage('output.jpg');

//----------------------------------------------------------------------------




$im = new imagick( 'Reports_Presentation_2.pdf[ 0]' );

$im->setImageColorspace(255);

$im->setResolution(300, 300);

$im->setCompressionQuality(95);

$im->setImageFormat('jpeg');

$im->writeImage('thumb.jpg');

$im->clear();

$im->destroy();

//-------------------------------------------------------------------------------------

// read page 1
$im = new imagick( 'Reports_Presentation_2.pdf[ 0]' );
// convert to jpg
$im->setImageColorspace(255);
$im->setCompression(Imagick::COMPRESSION_JPEG);
$im->setCompressionQuality(60);
$im->setImageFormat('jpeg');
//resize
$im->resizeImage(290, 375, imagick::FILTER_LANCZOS, 1);
//write image on server
$im->writeImage('thumb2.jpg');
$im->clear();
$im->destroy();


//------------------------------without saving.----------------------------------------------
//http://serversideguy.com/2012/10/04/imagemagick-php-converting-a-pdf-to-image-and-displaying-without-saving/

$image = new Imagick();
$pdf = 'Reports_Presentationnnnnnnnnnn_22.pdf[0]';
$image = new Imagick($pdf);
$image->resizeImage( 200, 200, imagick::FILTER_LANCZOS, 0);
$image->setImageFormat( "png" );
$image->writeImage('pdfAsImage.png');


$pdf = 'Reports_Presentation_2.pdf';
$image = new Imagick($pdf);
$image->resizeImage( 200, 200, imagick::FILTER_LANCZOS, 0);
$image->setImageFormat( "png" );
$thumbnail = $image->getImageBlob();
echo "<img src='image/png;base64,".base64_encode($thumbnail)."' /><br />";

//----------------------------------------------------------------------------



//----------------------------------------------------------------------------


//----------------------------------------------------------------------------


//----------------------------------------------------------------------------


//----------------------------------------------------------------------------



//----------------------------------------------------------------------------


//----------------------------------------------------------------------------



//----------------------------------------------------------------------------


//----------------------------------------------------------------------------



//----------------------------------------------------------------------------


//----------------------------------------------------------------------------







$pdf_file=PDF_FILE; //PDF FILE LOCATION
$jpgloc=IMAGE_LOCATION."page.jpg";// LOCATION TO PLACE EXTRACTED JPG FILES
$book=new digiBook();
echo "Initializing book...<br>";


//
//$book->convertPDF2JPG($pdf_file,$jpgloc);//CONVERT PDF TO JPG
//echo "Converting PDF to JPG files...<br>";
//
//$imgloc=IMAGE_LOCATION;// LOCATION TO PLACE EXTRACTED JPG FILES
//$xmlfile=XML_LOCATION."source.xml";//LOCATION OF XML FILE INSIIDE  FLIP BOOK
//digiBook::createXMLFile($xmlfile,$imgloc);
//echo "Configuring  Flip book...<br>";
//
//
//$ziploc=ZIP_LOCATION;// LOCATION TO PLACE ZIP FILE
//digiBook::createZIP($ziploc);
//echo "Creating zip...<br>";
//
//echo "Finish...<br><br><br>";
//
//echo "<a href='book/index.htm'  target='_blank'>Click here </a>to view the flip book ...".$file."<br>";

//$book->convertPDF2JPG($pdf_file,$jpgloc);//CONVERT PDF TO JPG
//echo "Converting PDF to JPG files...<br>";


$src = "/home/alon/Desktop/PROJECT/4.4.17";
$dst = IMAGE_LOCATION;//"/home/user/public_html/dir/subdir/destination_folder/";
$book-> recurse_copy($src,$dst);
$pattern = "/home/alon/Desktop/PROJECT/4.4.17/*.pdf";
$files = glob("/home/alon/Desktop/PROJECT/4.4.17/*.pdf");
$pdfFiles =  preg_grep('/\.pdf$/i', $files);

//foreach(glob(IMAGE_LOCATION."*.pdf") as $file){
//    $file_name = explode('.',$file);
//    $file_name = substr($file_name[0],-9);
//    $jpgloc2=IMAGE_LOCATION."$file_name.jpg";
//    $book->convertPDF2JPG($file,$jpgloc2);
//}

foreach(glob(IMAGE_LOCATION."*.pdf") as $file){
    $file_name = explode('.',$file);
    $file_name = substr($file_name[0],-9);
    $jpgloc2=IMAGE_FOLDER."$file_name.jpg";
    $book->convertPDF2JPG($file,$jpgloc2);
}