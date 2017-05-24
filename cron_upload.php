<?php
/**
 * Created by PhpStorm.
 * User: alon
 * Date: 18/05/17
 * Time: 08:58
 */

$foo = "105";
$num = number_format((float)$foo, -2, ' ', '');
$padded = sprintf('%02f', $unpadded);
$padded = sprintf('%0.2f', $padded);


//function numR($nums) {
//    $numRf = substr($nums, 0, 2); // take the first 2 strings
//    $numRto = substr($nums, 4, 2); // check the 2 final numbers
//    $numRl = substr($nums, 3, 1); // check the third number
//    $numRt = substr($nums, 2, 1); // check the second number
//    if($numRto > 50) {
//        $numF = $numRl + 1;
//    } else {
//        $numF = $numRl - 1;
//    }
//    if($numF == 0 && $numRto > 50) {
//        $numRt = $numRt + 1;
//    }
//    if($numF == 0 && $numRto < 50) {
//        $numRt = $numRt - 1;
//    }
//    echo $numRf.$numRt.$numF;
//}
//
//numR(2.38925445575);
//
//
//
//$ch = curl_init();
//
//$localfile = "path/to/file.zip";
//$filename = "file.zip";
//
//$fp = fopen($localfile, "r");
//
//curl_setopt($ch, CURLOPT_URL, "ftp://username:password@ftp.remoteserver.com/path/to/".$filenamerl_setopt($ch, CURLOPT_UPLOAD, 1) );
//curl_setopt($ch, CURLOPT_INFILE, $fp);
//curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localfile));
//
//curl_exec($ch);
//$error_no = curl_errno($ch);
//curl_close($ch);
//
//
//
//$server        = "YOUR_SERVER";
//$ftp_user_name = "YOUR_USERNAME";
//$ftp_user_pass = "YOUR_PASSWD";
//$dest          = "destination/image.jpg";
//$source        = "source/image.jpg";
//$mode          = "FTP_BINARY";
//
//$connection = ftp_connect($server);
//$login = ftp_login($connection, $ftp_user_name, $ftp_user_pass);
//if (!$connection || !$login) { die('Connection attempt failed!'); }
//$upload = ftp_put($connection, $dest, $source, $mode);
//if (!$upload) { echo 'FTP upload failed!'; }
//ftp_close($connection);