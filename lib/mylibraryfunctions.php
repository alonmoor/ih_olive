<?php  // functions for mylibrary sample files
       // used by categories.php, titleform.php, search.php

// htmlspecialchars for utf8
function htmlspecial_utf8($txt) {
  return htmlspecialchars($txt, ENT_COMPAT, "UTF-8"); }

// test, if array item exists, and return it
function array_item($ar, $key) {
  if(is_array($ar) && array_key_exists($key, $ar)){
    return($ar[$key]);
  }else{
    return FALSE;
  }
}

// build <a href=$url?$query>$txt</a>
function build_href($url, $query, $txt) {
  if($query)
    return "<a href=\"$url?" . $query . "\">" . htmlspecial_utf8($txt) . "</a>";
  else
    return "<a href=\"$url\">" . htmlspecial_utf8($txt) . "</a>";
}



function build_href1($url,$mode, $query, $txt) {
  if($query)
    return "<a href=\"$url?" .$mode	. $query .   "\">" . htmlspecial_utf8($txt) . "</a>";
  else
    return "<a href=\"$url\">" . htmlspecial_utf8($txt) . "</a>";
}
/********************************************************************************************/
 /*<a href="<?php echo ROOT_WWW; ?>/admin/users.php?mode=delete&id=<?php echo $formdata['usr_details'][$i]->userID?>" OnClick='return verify();' >[מחק מישתמש]</a>*/

function build_href2($url,$mode, $query, $txt, $str="class=href_modal1") {
  if($query)
    return "<a href=\"$url?" .$mode	. $query .  "\" $str>" . htmlspecial_utf8($txt) . "</a>";
    //return "<a href=\"$url?" .$mode	. $query .  "\"  class='href_modal1'>" . htmlspecial_utf8($txt) . "</a>";
  else
    return "<a href=\"$url\" $str>" . htmlspecial_utf8($txt) . "</a>";
}


/**********************************************************************************************************/
function build_href4($url,$mode, $query, $txt, $str="") {
  if($query)
    return "<a href=\"$url?" .$mode	. $query .  " \"  $str  >" . htmlspecial_utf8($txt) . "</a>";
  else
    return "<a href=\"$url\" $str>" . htmlspecial_utf8($txt) . "</a>";
}
/**********************************************************/
function build_href5($url, $query, $txt, $str="") {
  if($query)
    return "<a href=\"$url?"  . $query .  "\" $str>" . htmlspecial_utf8($txt) . "</a>";
  else
    return "<a href=\"$url\" $str>" . htmlspecial_utf8($txt) . "</a>";
}

/**********************************************************/
function build_href6($url, $query, $txt, $str="") {
  if($query)
    return "<a href=\"$url?"  . $query .  "\" $str>" . htmlspecial_utf8($txt) . "</a>";
  else
    return "<a href=\"$url\" $str>" . htmlspecial_utf8($txt) . "</a>";
}

/**********************************************************/
function build_href3($url,$mode, $query, $txt) {
  if($query)
return '<a href=/admin/forum_category.php?mode=delete   $query   onclick="return verify();"><b>מחק</b> </a>' ;
 
} 	








// show content of PHP array, i.e. show_array($_POST)
// this is handy to quickly test what data is in an array
function show_array($x)
{
  if(!is_array($x)) return;
  reset($x);
  echo "<p><font color=\"#00ff00\">content of array\n";
  if($x)
    while($i=each($x))
      echo "<br />", htmlspecial_utf8($i[0]), " = ", htmlspecial_utf8($i[1]), "\n";
  echo "</font></p>\n";
}



// returns twodimensional array of all categories in logical order
// result[n][0] --> catName (indented according to level)
// result[n][1] --> catID
function build_category_array($catIDs, $subcats, $catNames, $indent=0) {
  static $tmp;
  if($indent==0)
    $tmp = FALSE;  // unset does not work for static variables!
  foreach($catIDs as $catID) {
    $pair[0] = str_repeat(" ", $indent*3) . $catNames[$catID];
    $pair[1] = $catID;
    $tmp[] = $pair;
    if(array_key_exists($catID, $subcats)){
      build_category_array($subcats[$catID], $subcats, $catNames, $indent+1);
    }
  }
  if($indent==0)
    return $tmp;
}

?>