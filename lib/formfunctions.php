<?php

// require_once ("../config/application.php");

// read function htmlspecial_utf8

require_once 'mylibraryfunctions.php';


// start form; use table to align form entries
function form_start($action,$name="") {
  echo '<table class="myformtable" align="center">', "\n";
  echo '<form method="post" onsubmit="prepSelObject(document.getElementById(\'dest_users\'));prepSelObject(document.getElementById(\'dest_forumsType\'));prepSelObject(document.getElementById(\'dest_managersType\'));" '.
    html_attribute("action", $action),
    html_attribute("name", $name),
    ">\n";

}
/***************************************************************************************/
function form_start2($action,$name="") {
   echo '<table class="myformtable" align="center" border=0>', "\n";
  echo '<form method="post" ',
    html_attribute("action", $action),
    html_attribute("name", $name),
    ">\n";
}

/*****************************************************************************************************/
function form_start3($action,$name="") {

  echo '<form method="post" ',
    html_attribute("action", $action),
    html_attribute("name", $name),
    ">\n";
}

/*****************************************************************************************************/


function form_hidden($name, $value) {
  echo '<input type="hidden" ',
    html_attribute("name", "form[$name]"),
    html_attribute("value", $value),
    " />\n";
}

/***********************************************************************/


function form_hidden2($name,$value,$mode,$value1) {
  echo '<input type="hidden" '.
         html_attribute("name", "form[$name]"),
         html_attribute("value", $value),
          html_attribute("mode", "$value1"),

    " />\n";
}


/**********************************************************************/

function form_hidden3($name, $value,$with_form_as_name=1, $free_text) {


	echo '<input type="hidden" ',

    html_attribute("name", ($with_form_as_name)?"form[$name]":"$name"),
    html_attribute("value", $value),
    $free_text,
    " />\n";
}
/********************************************************************/

function form_button($name, $txt, $type="submit", $free_text="") {
  echo '<td class="myformtd"><input ',

    html_attribute("class", "mybutton"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", "form[$name]"),
    $free_text,
    ' /></td>', "\n";
}
/******************************************************************************/

//form_button1(submitbutton", "שמור","Submit", "OnClick=\"return document.getElementById('mode').value='delete'\";");
function form_button1($name, $txt, $type="button",$id="", $free_text="") {
  echo '<td class="myformtd"><input ',

    html_attribute("class", "mybutton"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("id", $id),
    html_attribute("name", "form[$name]"),
    $free_text,
    ' /></td>', "\n";
}
/******************************************************************************/
function form_button_img_nt($name, $txt, $type="button",$id="", $free_text="") {
  echo '<button ',

   html_attribute("class",  "green90x24"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("id", $id),
    html_attribute("name", "form[$name]"),
    $free_text,
    ' />', htmlspecial_utf8($txt),'</button>', "\n";
}
/******************************************************************************/

//form_button1("btnDelete", "מחק החלטה", "Submit", "OnClick=\"return document.getElementById('mode').value='delete'\";");
function form_button_no_td($name, $txt, $type="button", $free_text="") {
  echo  '<input ',

    html_attribute("class", "mybutton"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", "form[$name]"),
    $free_text,
    ' />', "\n";
}
/******************************************************************************/
function form_button_no_td2($name, $txt, $type="button",$free_text="") {
  echo  '<button ',

    html_attribute("class",  "green90x24"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", "form[$name]"),
    $free_text,
    ' >', htmlspecial_utf8($txt),'</button>', "\n";

}
/******************************************************************************/
function form_button_no_td3($name, $txt, $type="button",$id,$free_text="") {
  echo  '<button ',

    html_attribute("class",  "green90x24"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", "form[$name]"),
     html_attribute("id", $id),
    $free_text,
    ' >', htmlspecial_utf8($txt),'</button>', "\n";

}
/******************************************************************************/
function form_button2($name, $txt, $type="submit") {
  echo '<input ',
    html_attribute("class", "mybutton"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", "form[$name]"),
    ' />', "\n";
}
/******************************************************************************/
function form_button3($name, $txt, $type="submit", $with_form_as_name=1) {

  echo '<td class="myformtd"><input ',
    html_attribute("class", "mybutton"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", ($with_form_as_name)?"form[$name]":"$name"),

    ' /></td>', "\n";

}

/******************************************************************************/
function form_button4($name, $txt, $type="submit", $free_text="") {
  echo '<input ',

    html_attribute("class", "mybutton"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", "form[$name]"),
    $free_text,
    ' />', "\n";
}
/******************************************************************************/
function form_button5($name, $txt, $type="submit",$id="", $free_text="") {
  echo '<input ',

    html_attribute("class", "mybutton"),
    html_attribute("type", $type),
    html_attribute("value", $txt),
    html_attribute("name", "form[$name]"),
    html_attribute("id", $id),
    $free_text,
    ' />', "\n";
}
/******************************************************************************/

// close form
function form_end() {
  echo "</form></table>\n\n"; }


/*****************************************************************************************************/

// new line (row) in table
function form_new_line() {
  echo "<tr>"; }
/**********************************************************************************/
// end line (row)
function form_end_line() {
  echo "</tr>\n\n"; }
/**********************************************************************************/
 function form_label_span($caption, $necessary=FALSE) {
  echo '<td align="right" class="myformtd">';
  echo ' <div class="form-row"> ';
  if($necessary)
    echo '<span class="h">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);
  echo '<div></td>', "\n";
}
/**********************************************************************************/
// show right-aligned text in form cell
function form_label($caption, $necessary=FALSE) {

  echo '<td align="right" class="myformtd">';
//   form_empty_cell_no_td(4);
  if($necessary)

    echo '<span class="red1" style="color:yellow;">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);

  echo '</td>', "\n";
}
/**********************************************************************************/
function form_label_noformtd($caption, $necessary=FALSE) {

  echo '<td align="right">';
//    form_empty_cell_no_td(5);
  if($necessary)

    echo '<span class="red1" style="color:yellow">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);

  echo '</td>', "\n";
}
/**********************************************************************************/

function form_label1($caption, $necessary=FALSE) {

  if($necessary)
    echo '<span class="red1" style="color:yellow;">' . htmlspecial_utf8($caption) . '</span>';
  else
    echo htmlspecial_utf8($caption);

}
/**********************************************************************************/
/**********************************************************************************/

function form_label_short($caption, $necessary=FALSE) {
  echo '<td align="right" class="myformtd" style="width:40px;">';
  if($necessary)
    echo '<span class="red1" style="color:yellow;">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);
  echo '</td>', "\n";
}
/**********************************************************************************/

function form_label_short2($caption, $necessary=FALSE) {
  echo '<td align="right"  style="width:14px;overflow:hidden;">';
  if($necessary)
    echo '<span class="red1" style="color:yellow;">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);
  echo '</td>', "\n";
}
/**********************************************************************************/
function form_label_short3($caption, $necessary=FALSE) {
  echo '<td align="right"  style="width:30px; ">';
  if($necessary)
    echo '<span class="red1" style="color:yellow;">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);
  echo '</td>', "\n";
}
/**********************************************************************************/

function form_label_red($caption, $necessary=FALSE) {
  echo '<td align="right" class="myformtd">';
  if($necessary)
    echo '<span class="red1" style="color:yellow;">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);
  echo '</td>', "\n";
}
/**********************************************************************************/

function form_label_red1($caption, $necessary=FALSE) {

  if($necessary)
    echo '<span class="red1" style="color:yellow;">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);

}
/**********************************************************************************/


function form_label2($caption, $necessary=FALSE) {
 echo '<td align="right">';
  if($necessary)
    echo '<span class="red1" style="color:yellow;">', htmlspecial_utf8($caption), '</span>';
  else
    echo htmlspecial_utf8($caption);

}
/**********************************************************************************/
// show text in form cell
function form_caption($caption, $colspan=1) {
  if($colspan>1)
    echo '<td class="myformtd" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td class="myformtd">';
  echo htmlspecial_utf8($caption), '</td>', "\n";
}
/**********************************************************************************/
// show text as is in form cell
function form_asis($txt, $colspan=1) {
  if($colspan>1)
    echo '<td class="myformtd" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td class="myformtd">';
  echo $txt, '</td>', "\n";
}
/**********************************************************************************/
// show URL in form cell
function form_url($url, $txt, $colspan=1) {
  if($colspan>1)
    echo '<td class="myformtd" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td class="myformtd">';
  echo "<a href=\"$url\" class='form_href'>" . htmlspecial_utf8($txt) . " </a></td>\n";
}

/**********************************************************************************/
function form_url_noformtd($url, $txt, $colspan=1) {
  if($colspan>1){
    echo '<td',
      html_attribute("colspan", $colspan), '>';
     }else{
    echo '<td>';
  }
    //form_empty_cell_no_td(4);
  echo "<a href=\"$url\" class='form_href'>" . htmlspecial_utf8($txt) . " </a></td>\n";
}

/**********************************************************************************/
// show URL in form cell
function form_url1($url, $txt, $colspan=1) {
  if($colspan>1)
    echo '<td class="myformtd" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td class="myformtd">';
  echo "<a href=\"$url\" class='form_href'>" . htmlspecial_utf8($txt) . "</a></td>\n";
}

/**********************************************************************************/
function form_url2($url, $txt, $colspan=1) {


  echo "<a href=\"$url\" class='form_href'>" . htmlspecial_utf8($txt) . "</a> \n";
}

/**********************************************************************************/
function form_url3($url, $txt, $colspan=1) {


  echo "<a href=\"$url\" class='form_href_forum'>" . htmlspecial_utf8($txt) . "</a> \n";
}

/**********************************************************************************/
// create $n empty cells
function form_empty_cell($n=1) {
  echo str_repeat('<td class="myformtd">&nbsp;</td>', $n) . "\n";
}
/**********************************************************************************/
function form_empty_cell_noformtd($n=1) {
  echo str_repeat('<td>&nbsp;</td>', $n) . "\n";
}
/**********************************************************************************/
function form_empty_cell_no_td($n=1) {
  echo str_repeat('&nbsp;', $n) . "\n";
}
/**********************************************************************************/

function form_text($name, $value="", $size=40, $maxlength=40, $colspan=1,$id="") {
  if($colspan>1)
    echo '<td class="myformtd" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td class="myformtd" align="right"> ';
  echo '<input class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("value", $value),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength),
     html_attribute("id", $id) ;
  echo ' /></td>', "\n";
}


/**********************************************************************************/
function form_text_a($name, $value, $size=40, $maxlength=40, $colspan=1,$id="") {
  if($colspan>1)

      html_attribute("colspan", $colspan) ;
  else

  echo '<input class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("value", $value),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength),
    html_attribute("id", $id),
    ' />', "\n";
}

/**********************************************************************************/
function form_text_b($name, $value, $size=40, $maxlength=40, $colspan=1,$id="entry") {
  if($colspan>1)

      html_attribute("colspan", $colspan) ;
  else

  echo '<input class="mycontrol" ',
    html_attribute("name","$name" ),
    html_attribute("value", $value),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength),
    ' />', "\n";
}


/**********************************************************************************/
/**********************************************************************************/
// create text input field for form
function form_text1($name, $value, $size=40, $maxlength=40, $colspan=1) {

  echo '<input class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength);
  if($value)
    echo html_attribute("value", $value);
     echo ' /> ', "\n";
}
/**********************************************************************************/


function form_text2($name, $value, $size=40, $maxlength=40, $colspan=1) {

  echo '<input class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength);
   ?> <tr>
		<td>שם פורום</td>
		<td><input type="text" name="forum_decName" size=20
			value="<?php echo $frm->forum_decName ?>" /></td>
	</tr>
   <?php
  if($value)
    echo html_attribute("value", $value);

}
/*************************************************************************************************/
function form_text3($name, $value, $size=40, $maxlength=40, $colspan=1,$id="") {

  if($colspan>1)

      html_attribute("colspan", $colspan) ;
  else

  echo '<input class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("value", $value),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength),
    html_attribute("id", $id) ;
  echo ' />', "\n";
}
/*************************************************************************************************/
function form_text_noformtd($name, $value, $size=40, $maxlength=40, $colspan=1,$id="") {

if($colspan>1)
    echo '<td align="right" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td align="right"> ';
  echo '<input class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("value", $value),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength),
     html_attribute("id", $id) ;
  echo ' /></td>', "\n";
}
/**********************************************************************************/
// create text input field for form
function form_password($name, $value, $size=40, $maxlength=40, $colspan=1) {
  if($colspan>1)
    echo '<td class="myformtd" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td class="myformtd"> ';
  echo '<input class="mycontrol" ',
    html_attribute("type", "password"),
    html_attribute("name", "form[$name]"),
    html_attribute("size", $size),
    html_attribute("maxlength", $maxlength);
  if($value)
    echo html_attribute("value", $value);
  echo ' /></td>', "\n";
}
/**********************************************************************************/
// create text input field for form
function form_textarea($name, $value, $cols=70, $rows=6, $colspan=2,$id="") {
  if($colspan>1)
    echo '<td class="myformtd" ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td class="myformtd"> ';
  echo '<textarea class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("rows", $rows),
    html_attribute("cols", $cols),
    html_attribute("id", $id), '>';
  if($value)
    echo htmlspecial_utf8($value);
  echo '</textarea></td>', "\n";
}
/**********************************************************************************/
// create text input field for form
function form_textarea_noformtd($name, $value, $cols=70, $rows=6, $colspan=2,$id="") {
  if($colspan>1)
    echo '<td " ',
      html_attribute("colspan", $colspan), '>';
  else
    echo '<td> ';
  echo '<textarea class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("rows", $rows),
    html_attribute("cols", $cols),
    html_attribute("id", $id), '>';
  if($value)
    echo htmlspecial_utf8($value);
  echo '</textarea></td>', "\n";
}
/**********************************************************************************/

function form_textarea1($name, $value, $cols=70, $rows=6, $colspan=1,$id="") {


  echo '<textarea class="mycontrol" ',
    html_attribute("name", "form[$name]"),
    html_attribute("rows", $rows),
    html_attribute("cols", $cols),
    html_attribute("id", $id), '>';
  if($value)
    echo htmlspecial_utf8($value);
  echo '</textarea>', "\n";
}
/**********************************************************************************/

function mkSelectBox1($name, $arr_name, $arr_id, $selected, $str="") {
        if( !is_array($selected) )
                $selected = array($selected);

        $data = "\n<select name='$name' dir=rtl $str >\n";

		if( is_array($arr_id) && count($arr_id) ) {
				foreach ($arr_id as $i=>$id)    {
					if( in_array($id, $selected) )
						$data.=  "<option value='$id' selected>$arr_name[$i]</option>";
					else
						$data.=  "<option value='$id'>htmlspecial_utf8($arr_name[$i])</option>";
				$data.=  "\n";
			}
		}
		$data.=  "</select>\n";
		return $data;
}

/**********************************************************************************/
function create_dropdown($identifier,$pairs,$firstentry,$multiple="")
   {

      $dropdown = "<select name=\"$identifier\" multiple=\"$multiple\">";
      $dropdown .= "<option name=\"\">$firstentry</option>";

      // Create the dropdown elements
      foreach($pairs AS $value => $name)
      {
         $dropdown .= "<option name=\"$value\">$name</option>";
      }
      // Conclude the dropdown and return it
      echo "</select>";
      return $dropdown;
   }
/**********************************************************************************/
function create_dropdown1($identifier, $pairs, $firstentry,$multiple="", $key="")
{
   $dropdown = "<select name=\"$identifier\" multiple=\"$multiple\">";
   $dropdown .= "<option name=\"\">$firstentry</option>";

   foreach($pairs AS $value => $name)
   {
      $dropdown .= ($value == $key) ?
                 "<option name=\"$value\" selected=\"selected\">$name</option>" :
                 "<option name=\"$value\">$name</option>";
   }
   echo "</select>";
   return $dropdown;
}

/******************************************************************************/
// create select list
/**********************************************************************************/
/**********************************************************************************/

function form_list13($name,$rows,$selected=-1) {
  echo '<select class="mycontrol" ',
    html_attribute("name", "form[$name]"),'>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1]){
      echo 'selected="selected" ';
    }
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}

/*******************************************************************************************/
function form_list5($name, $rows,$this_date=NULL, $selected=-1, $str="") {
  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';
  foreach($rows as $key => $value) {
    echo '<option ', html_attribute("value", $key);
    if($value==$this_date){
      echo 'selected="selected" ';
    }
      echo ">$value</option>\n";

  }
    echo '</select>', "\n";
}


/***************************************************/
// create select list form_list3($name ,$date_array, array_item($formdata, $name) );
/***************************************************/


function form_list3($name, $rows,$this_date=NULL, $selected=-1) {

  echo '<select class="mycontrol" ',
  html_attribute("name", "form[$name]"),'>', "\n";
  foreach($rows as $key => $value) {
    echo '<option ', html_attribute("value", $key);
    if($value==$this_date){
      echo 'selected="selected" ';
    }
      echo ">$value</option>\n";

  }
  echo '</select>';
}

/*******************************************************************************/
function form_list33($name, $rows, $selected=-1) {

  echo '<select class="mycontrol" ',
    html_attribute("name", "form[$name]"),'>', "\n";
  echo '<option value="none"></option>';
  foreach($rows as $key => $value) {
    echo '<option ', html_attribute("value", $key);
    if($value==$this_date){
      echo 'selected="selected" ';
    }

     $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($value));
    echo ">$listentry</option>\n";
  }
  echo '</select>';
}

/******************************************************************************/

function form_list2($name, $rows, $selected=-1, $str="") {
    echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name]"), '>', "\n";
  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row);
    if($selected==$row)
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}
/**********************************************************************************/


function form_list1($name, $rows, $selected=-1, $str="") {

  echo '<td class="myformtd">';
  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1]){
      echo 'selected="selected" ';
    }
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select></td>', "\n";
}
/**********************************************************************************/
function form_list1idx($name, $rows, $selected=-1, $str="") {

  echo '<td class="myformtd">';
  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
if(is_array($selected)){
    if(in_array ($row[1],  $selected )  ){
      echo 'selected="selected" ';
    }
}
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select></td>', "\n";
}


/********************************************************************************/




// create select list
function form_list01($name, $rows, $selected=-1, $str="") {

  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"),'>', "\n";
  echo '<option value="none">(choose)</option>';
  foreach($rows as $key => $value) {
    echo '<option ', html_attribute("value", $key);
    if($selected==$value){
      echo 'selected="selected" ';
    }
      echo ">$value</option>\n";

  }
  echo '</select>';
}
/******************************************************************************/
function list11($name, $rows, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);


  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
  	$sel = ( in_array($index, $selected)) ? "selected":"";
    echo "<option value='$index' $sel>$value</option>\n";

  }
   echo '</select>' ;
}
////////////////////////////////////////////////////////////////////////////
function form_list111($name, $rows, $selected=-1, $str="") {


  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";

  //echo '<option value="none">(בחר אופציה)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1]){
      echo 'selected="selected" ';
    }
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}


/*******************************************************************************************/

function list11_td($name, $rows, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);

    echo '<td class="myformtd">';
  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
  	$sel = ( in_array($index, $selected)) ? "selected":"";
    echo "<option value='$index' $sel>$value</option>\n";

  }
   echo '</select></td>', "\n";
}
////////////////////////////////////////////////////////////////////////////

function list11_ctrl2($name, $rows, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);


  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
  	$sel = ( in_array($index, $selected)) ? "selected":"";
    echo "<option value='$index' $sel>$value</option>\n";

  }
   echo '</select>' ;
}

/******************************************************************************/

function form_list11($name, $rows=null, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);

  echo '<td class="myformtd"  style="width:9px;">';
  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
 	$sel = ( in_array($index, $selected)) ? "selected":"";

   echo "<option  value='$index' $sel>$value</option>\n";
  }
  echo '</select></td>', "\n";
}

/******************************************************************************/

function form_list_no_formtd($name, $rows=null, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);

  echo '<td  style="width:9px;">';
  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
 	$sel = ( in_array($index, $selected)) ? "selected":"";

   echo "<option  value='$index' $sel>$value</option>\n";
  }
  echo '</select></td>', "\n";
}

/****************************************************************/
/****************************************************************/

function form_list_noformtd($name, $rows=null, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);

  echo '<td  style="width:9px;">';
  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
 	$sel = ( in_array($index, $selected)) ? "selected":"";

   echo "<option  value='$index' $sel>$value</option>\n";
  }
  echo '</select></td>', "\n";
}

/****************************************************************/

function form_list_idx($name, $rows, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);


  echo '<select class="change_user" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
  	$sel = ( in_array($index, $selected)) ? "selected":"";
    echo "<option  value='$index' $sel>$value</option>\n";

  }
  echo '</select>';
}




/*******************************************************************************************/
function form_list_idx_one($name, $rows, $selected=-1, $str="") {
	if( !is_array($selected))
		$selected=array($selected);


  echo '<select class="change_user" '.$str.' ',
    html_attribute("name", "form[$name]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';

  foreach($rows as $index=>$value) {
  	$sel = ( in_array($index, $selected)) ? "selected":"";
    echo "<option  value='$index' $sel>$value</option>\n";

  }
  echo '</select>';
}




/*******************************************************************************************/

// create select list
function form_list001($name, $rows, $selected=-1) {

  echo '<select class="mycontrol" ',
    html_attribute("name", "form[$name]"), '>', "\n";
  echo '<option value="none">(choose)</option>';
  foreach($rows as $key=>$value) {
    echo '<option ', html_attribute("value", $key);
    if($selected==$value){
      echo 'selected="selected" ';
    }
      echo ">$value</option>\n";

  }
  echo '</select>', "\n";
}
 /**********************************************************************************/

function form_list0($name, $rows, $selected=-1, $str="") {


  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name][]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row);
    if($selected==$row)
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}


/******************************************************************************/
function form_list_find($name ,$id, $rows, $selected=-1) {



	echo '<td class="myformtd">';
  echo '<select class="mycontrol"  ' ,
    html_attribute("name", "$name"),
   html_attribute("id", "$id"),  '>', "\n";

  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select></td>', "\n";
}
/******************************************************************************/
function form_list_find_no_form_td($name ,$id, $rows, $selected=-1) {



	echo '<td>';
  echo '<select class="mycontrol"  ' ,
    html_attribute("name", "$name"),
   html_attribute("id", "$id"),  '>', "\n";

  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select></td>', "\n";
}
///////////////////////////////////////////////
function form_list_find_notd($name ,$id, $rows, $selected=-1) {



  echo '<select class="mycontrol"  ' ,
    html_attribute("name", "$name"),
   html_attribute("id", "$id"),  '  style="width:160px">', "\n";

  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}
/******************************************************************************/
function form_list_find_notd_no_choose($name ,$id, $rows, $selected=-1) {


  echo '<select class="mycontrol" style="margin-top:4px;"  ' ,
    html_attribute("name", "$name"),

   html_attribute("id", "$id"),  '>', "\n";


  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1]){
      echo 'selected="selected" ';
    }
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}
/******************************************************************************/
 function form_list_find_notd_no_choose2($name, $rows, $selected=-1, $str="") {
  echo '<select class="mycontrol" '.$str.' ',
  //echo '<select class="mycontrol" ',
  html_attribute("name", "form[$name]"), '>', "\n";

  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1]){
      echo 'selected="selected" ';
    }
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}
/******************************************************************************/
function form_list_jtd($name, $rows, $selected=-1) {
 echo '<td>';
  echo '<select class="mycontrol" ',
    html_attribute("name", "form[$name]"), '>', "\n";
  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select></td>', "\n";
}
/******************************************************************************/
// create select list
function form_list_a($name, $rows, $selected=-1) {

  echo '<select class="mycontrol" ',
    html_attribute("name", "form[$name]"), '>', "\n";
  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value",$row[$name]);
    if($selected==$row[0])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";

  }
  echo '</select>', "\n";

  }
/******************************************************************************/
  function form_list_b($name, $rows, $selected=-1, $str="") {
  echo '<select class="mycontrol" '.$str.' ',

  html_attribute("name", "form[$name]"), ' style="width:160px;">', "\n";
  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select>', "\n";
}
/******************************************************************************/
function form_list_demo($name, $rows, $selected=-1, $str="") {
    echo '<select class="mycontrol" '.$str.' ',

    html_attribute("name", "$name"), ' style="width:160px;">', "\n";
    echo '<option value="none">(choose)</option>';
    foreach($rows as $row) {
        echo '<option ', html_attribute("value", $row);
        if($selected==$row)
            echo 'selected="selected" ';
        $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row));
        echo ">$listentry</option>\n";
    }
    echo '</select>', "\n";
}
/******************************************************************************/

function form_list($name, $rows, $selected=-1) {
  echo '<td class="myformtd" colspan="2">';
  echo '<select class="mycontrol"  ' ,
    html_attribute("name", "form[$name]"), '>', "\n";
  echo '<option value="none">(choose)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }
  echo '</select></td>', "\n";
}
/******************************************************************************/

function form_list_11($name, $rows, $selected=-1, $str="") {

  echo '<select class="mycontrol" '.$str.' ',
    html_attribute("name", "form[$name]"), '>', "\n";
  echo '<option value="none">(בחר אופציה)</option>';
  foreach($rows as $row) {
    echo '<option ', html_attribute("value", $row[1]);
    if($selected==$row[1])
      echo 'selected="selected" ';
    $listentry = str_replace(" ", "&nbsp;", htmlspecial_utf8($row[0]));
    echo ">$listentry</option>\n";
  }

  echo '</select>', "\n";
}
/******************************************************************************/

// build name="value"
function html_attribute($name, $value) {
  return $name . '="' . htmlspecial_utf8($value) . '" ';
}
/**********************************************************************************/
// show red error message
function show_error_msg($txt) {
  echo '<p><span class="red1">', htmlspecial_utf8($txt), '</span></p>', "\n";
}

//========================================================================================================

function print_list($rs) {
	require_once 'html/list.php';
}
/**********************************************************************************/
function print_user_list($rs) {
	require_once HTML_DIR.'/user_list.php';
}
/**********************************************************************************/
function print_forum_list($rs) {
	require_once HTML_DIR.'/forum_list.php';
}
/**********************************************************************************/
function print_decision_list($rs) {
	require_once  HTML_DIR.'/decision_list.php';
}
/**********************************************************************************/
function generate_footer() {
    echo "<p>Copyright &copy;2008 by alon mor</p>";
}


function show_edit_form($id="", $mode="") {
	require_once  HTML_DIR.'/edit.php';

}
function show_edit1_form($id="",$mode="") {
	require_once 'html/edit1.php';

}

function show_edit2_form($id="",$mode="") {
	require_once HTML_DIR.'/edit2.php';

}
function show_edit3_form($id="",$mode="") {
	require_once HTML_DIR.'/edit3.php';

}

function show_edit_user($id="",$mode=""){
	require_once HTML_DIR.'/edit_user.php';
}


function show_edit_user1($id="",$mode=""){
	require_once HTML_DIR.'/edit_user1.php';
}
function show_edit_user2($id="",$mode=""){
	require_once HTML_DIR.'/edit_user2.php';
}

function show_edit_user3($id="",$mode=""){
	require_once HTML_DIR.'/edit_user3.php';

}

function show_edit_decision($id="", $mode="") {

	require_once HTML_DIR.'/edit_decision.php';


}
function show_edit1_decision($id="",$mode="") {
	require_once HTML_DIR.'/edit_decision1.php';


}

function show_edit2_decision($id="",$mode="") {
	require_once HTML_DIR.'/edit_decision2.php';

}
function show_edit3_decision($id="",$mode="") {
	require_once HTML_DIR.'/edit_decision3.php';

}

function show_edit_forum($id="", $mode="") {

	require_once HTML_DIR.'/edit_forum.php';


}
function show_edit_forum_a($id="", $mode="") {

	require_once HTML_DIR.'/edit_forum_a.php';


}
function show_edit1_forum($id="",$mode="") {
	require_once HTML_DIR.'/edit_forum1.php';


}

function show_edit2_forum($id="",$mode="") {
	require_once HTML_DIR.'/edit_forum2.php';

}
function show_edit3_forum($id="",$mode="") {
	require_once HTML_DIR.'/edit_forum3.php';

}

function show_edit4_forum($id="",$mode="") {
	require_once HTML_DIR.'/add_user.php';

}

function show_edit_dec($id="",$mode="") {
	require_once HTML_DIR.'/dec_edit.php';

}

function show_todo_list($id="",$mode="",$formdata="") {
	require_once HTML_DIR.'/todo_list.php';

}
function show_edit_task($id="",$action="",$formdata="") {
	require_once HTML_DIR.'/edit_task.php';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$needAuth = (isset($config['password']) && $config['password'] != '') ? 1 : 0;
if($needAuth)
{
	if(isset($config['session']) && $config['session'] == 'files')
	{
		session_save_path(realpath('./tmp/sessions/'));
		ini_set('session.gc_maxlifetime', '1209600'); # 14 days session file minimum lifetime
		ini_set('session.gc_probability', 1);
		ini_set('session.gc_divisor', 10);
	}

	ini_set('session.use_cookies', true);
	ini_set('session.use_only_cookies', true);
	session_set_cookie_params(1209600, substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1)); #14 days session cookie lifetime
	session_start();
}


function canAllRead()
{
	global $config;
	if(!isset($config['password']) || $config['password'] == '') return true;
	if(isset($config['allow']) && $config['allow'] == "read") return true;
	return false;
}

function is_logged_init()
{
	if(!isset($_SESSION['logged']) || !$_SESSION['logged']) return false;
	return true;
}

/****************************************************************************************************************/
function is_logged() {


    if (!empty($_SESSION["auth_level"]) && $_SESSION["auth_level"]=='admin')
 	    echo "היתחברת כ- מנהל אם שם משתמש " .$_SESSION["auth_username"];

 	  elseif(!empty($_SESSION["auth_level"]) && $_SESSION["auth_level"]=='user')
      echo "היתחברת כ- משתמש רגיל אם שם משתמש "   .$_SESSION["auth_username"];

	  elseif(!empty($_SESSION["auth_level"]) && ($_SESSION["auth_level"])=='suppervizer')
      echo " היתחברת כ- מפקח אם שם משתמש " .$_SESSION["auth_username"];


     elseif(!empty($_SESSION["auth_level"]) && ($_SESSION["auth_level"])=='user_admin')
      echo "היתחברת כ-מנהל+משתמש אם שם משתמש " .$_SESSION["auth_username"];

//     elseif(!isset($_SESSION['logged']) || !$_SESSION['logged']) return false;
//     echo "User: Not logged in<br>";
	return true;



 }

/*************************************************************************************************/
// catch system exception
function catchExc($sMsg) {

    global $EXCEPTS;
    array_push($EXCEPTS, $sMsg);
}

// catch page error
function catchErr($sMsg) {

    global $ERRORS;
    array_push($ERRORS, $sMsg);
}

// cleans a string
function clean($sStr) {

    $return = stripslashes($sStr);
    $return = htmlspecial_utf8($return);
    return $return;
}

// add links to a string
function addLinks($sStr) {

    $return = preg_replace("/((http(s?):\/\/)|(www\.))([\w\.]+)([\w|\/]+)/i", "<a href=\"http$3://$4$5$6\" target=\"_blank\">$4$5$6</a>", $sStr);
    $return = preg_replace("/([\w|\.|\-|_]+)(@)([\w\.]+)([\w]+)/i", "<a href=\"mailto:$0\">$0</a>", $return);
    return $return;
}

// formats a string
function format($sStr) {

    $return = clean($sStr);
    $return = nl2br($return);
    $return = addLinks($return);
    return $return;
}

// get image properties
function getImage($sFile) {

    $aParts = getimagesize($sFile);
    $return["x"] = $aParts[0];
    $return["y"] = $aParts[1];
    $return["type"] = $aParts[2];
    $return["properties"] = $aParts[3];
    return $return;
}


/***************************************************************************************************/

// renders a paginated list for the site admin
function renderList($iCnt=0, $aData='') {

    global $iCursor, $iPerm;
?>
<br />
<?php   if (is_array($aData)) { ?>
<form   dir="rtl" action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="348" colspan="2"><div class="listrow"><strong>שאלות</strong></div></td>
        <td width="170"><div class="listrow"><strong>תאריך</strong></div></td>
        <td width="90"><div class="listrow"><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
    </tr>


    <tr>
        <td class="dotrule" colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>

    </tr>


   	<tr></tr>
    <?php
    // loop through data and conditionally display functionality and content
    $i = 0;
    $bg='';
    while ($i < count($aData)) {
        !strcmp("FFFFFF", $bg) ? $bg = "F6F6F6" : $bg = "FFFFFF";
        $aState = array("act", "deact");
    ?>
    <tr>
        <td width="16" bgcolor="#<?php print $bg ?>">
        	<div class="listrow<?php print $aData[$i]["Status"] ?>">
        		<a href="index.php?op=<?php print $aState[$aData[$i]["Status"]] ?>&id=<?php print $aData[$i]["Id"] ?>" onclick="return verify();">

        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]["Status"] ?>.gif" width="16" height="10" alt="" border="0" /><?php /*if ($iPerm > 2)*/ {
        ?></a><?php } ?></div></td>
        <td width="332" bgcolor="#<?php print $bg ?>"><div class="listrow<?php print $aData[$i]["Status"] ?>"><?php print format($aData[$i]["Name"])
        ?></div></td>
        <td width="170" bgcolor="#<?php print $bg ?>"><div class="listrow<?php print $aData[$i]["Status"] ?>">
        <?php print date("Y-m-d H:i:s" , $aData[$i]["Created"]) ?></div></td>
        <td width="90" bgcolor="#<?php print $bg ?>"><?php if ($iPerm !=1) { ?><a href="form.php?op=edit&id=
        <?php print $aData[$i]["Id"] ?>"><b>ערוך</b></a>&nbsp;|&nbsp;
        <a href="form.php?op=del&id=<?php print $aData[$i]["Id"] ?>" onclick="return verify();"><b>מחק</b> </a><?php } ?></td>
    </tr>



    <tr>
        <td class="dotrule" colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
    ?>

</table>
</form>
<?php renderPaging($iCursor, $iCnt) ?>
<?php } else { ?>
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>אין נתונים כרגע.</td>
    </tr>
</table>

<?php } // end condition ?>
<?php } // end function ?>
<?php
/***********************************************************************************************************/
/**************************************************************************************************************/
function renderList3($iCnt=0, $aData='') {

    global $iCursor, $iPerm;
?>
<br />
<?php   if (is_array($aData)) { ?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">

<table width="608" border="0" cellpadding="0" cellspacing="0">
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
    <tr>
        <td width="348" colspan="2"><div><strong>משימות</strong></div></td>

        <td width="90"><div><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
        <td width="170"><div><strong>תאריך</strong></div></td>
    </tr>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
    <tr>
        <td  colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>

    </tr>


   	<tr>

   	</tr>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
    <?php
    // loop through data and conditionally display functionality and content
    $i = 0;

    while ($i < count($aData)) {

        $aState = array("act", "deact");
    ?>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<tr id="tr_<?php echo  $aData[$i]->id ?>">
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
  <!--  <td width="16" >
     <div<?php print $aData[$i]->status  ?>">
      <a href="dynamic_5.php?action=<?php print $aState[$aData[$i]->status] ?>&id=<?php print $aData[$i]->id ?>" onclick="return verify();">

        <a  href="void" onclick="return verify() && activation_task(<?php echo $aData[$i]->id;?>,'<?php echo $aState[$aData[$i]->status] ;?>') && 0 ;return false; ">
        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]->status?>.gif" width="16" height="10" alt="" border="0" /> </a>

      </div>
    </td> -->
 <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
        <td width="332" >

          <div>

          <input type="text" class="mycontrol" size=20 name="task_description"
             value="<?php print format($aData[$i]->task_description )?>">
          </div>
        </td>



<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
 <td width="90">
<!--    <a href="drag-and-drop.php?m=updateTask&id=<?php print $aData[$i]->id?>" >
        <b>ערוך</b>
        </a>&nbsp;|&nbsp;
        <a href="void" onclick="sendRequest(<?php echo $aData[$i]->id?>)" >
        <a href="drag-and-drop.php?action=updateTask&id=<?php print $aData[$i]->id?>" >
        <b>ערוך</b>
        </a>&nbsp;|&nbsp;   -->


      <a href="drag-and-drop.php?action=updateTask&id=<?php print $aData[$i]->id?>" onclick="sendRequest(<?php echo $aData[$i]->id?>)" >
        <b>ערוך</b>
      </a>&nbsp;|&nbsp;

 <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->

        <a  href="void" onclick="return verify() && delete_task(<?php echo $aData[$i]->id?>) && 0 ;return false; ">
        <b>מחק</b>
        </a>

     </td>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
        <td width="170" >
          <div  <?php print $aData[$i]->status ?>"><?php print date("d-m-Y H:i:s" , strtotime($aData[$i]->created_dt) ) ?>
          </div>
        </td>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
</tr>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->

    <tr>
        <td  colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php
        ++$i;
    } // end loop
    ?>

</table>
<!--------------------------------------------------------------------------------------------------------  -->
<script type="text/javascript">
function deactivation_task(task_id) {
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id: task_id ,action: 'eact'},
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	    },

	    onFailure: function(){ alert('Something went wrong...') }
	  });


	return false;
}

</script>
<!-- ------------------------------------------------------------------------------------------------------ -->
<script type="text/javascript">
function activation_task(task_id,aState) {
	//alert(aState);
	var decID = document.getElementById("decID").value;
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {

	    method:'get',
	    parameters: {id: task_id ,decID:decID,action:  aState },
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	    },

	    onFailure: function(){ alert('Something went wrong...') }
	  });


	return false;
}

</script>
<!-- --------------------------------------------------------------------------------------------------- -->
<script type="text/javascript">

        function requestCustomerInfo() {
            var sId = document.getElementById("txtCustomerId").value;
            var oOptions = {
                method: "get",
                parameters: "id=" + sId,
                onFailure: function (oXHR, oJson) {
                    alert("An error occurred: " + oXHR.status);
                }
            };
            var oRequest = new Ajax.Updater({
                success: "divCustomerInfo"
            }, "GetCustomerData.php", oOptions);
        }

    </script>

<!-- --------------------------------------------------------------------------------------------------- -->
<script type="text/javascript">

        function sendRequest(task_id) {
        	var decID = document.getElementById("decID").value;
            var oOptions = {
                method: "get",
                parameters:{ id: task_id ,decID:decID,action:'updateTask'},
                onSuccess: function (oXHR, oJson) {
                    saveResult(oXHR.responseText);
                },
                onFailure: function (oXHR, oJson) {
                    saveResult("An error occurred: " + oXHR.statusText);
                }
            };

            var oRequest = new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php', oOptions);
        }

        function saveResult(sMessage) {
            var divStatus = document.getElementById("divStatus");
            divStatus.innerHTML = "Request completed: " + sMessage;
        }
    </script>
<!-- --------------------------------------------------------------------------------------------------- -->



<script type="text/javascript">
function delete_task(task_id) {
	//alert(task_id);
     var decID = document.getElementById("decID").value;

    var li = document.getElementById('li_'+task_id).value ;
    // alert(li);
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id: task_id ,decID:decID,action: 'delTask'},
	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	       // alert("Success! \n\n" + response);
	       $('tr_'+task_id).remove();

	       $('li_'+task_id).remove();
	       alert(liItem);
	    },

	    onFailure: function(){ alert('Something went wrong...') }
	  });


	return false;
}
</script>

<!-- --------------------------------------------------------------------------------------------------- -->
</form>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->


<?php } else { ?>
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
       <?php show_error_msg("אין משימות כרגע."); ?>
    </tr>
</table>

<?php } // end condition ?>
<?php } // end function ?>
<?php
/************************************************************************************/
/************************************************************************************/
// sets a generic pagination element
function renderPaging($iCursor=0, $iCnt=0, $sVar='') {

?>
    <?php if ($iCnt > ROWCOUNT) { ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="right"><div class="paging">
        <!--| paging |-->


        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="15"><?php if ($iCursor > 0) { ?><a href="<?php print SELF ?>?cursor=<?php print $iCursor - ROWCOUNT ?><?php print $sVar ?>"><img src="<? echo IMAGES_DIR ?>/buttons/btn_prev.gif" width="15" height="15" alt="" border="0" /><?php } else { ?><img src="<? echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="15" height="15" alt="" border="0" /><?php } ?></a></td>
                <td width="5"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="5" height="1" alt="" border="0" /></td>
                <td width="15"><?php if ($iCursor + ROWCOUNT < $iCnt) { ?><a href="<?php print SELF ?>?cursor=<?php print $iCursor + ROWCOUNT ?><?php print $sVar ?>">
                <img src="<?php echo IMAGES_DIR?>/buttons/btn_next.gif" width="15" height="15" alt="" border="0" /><?php } else { ?><img src="<? echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="15" height="15" alt="" border="0" /><?php } ?></a></td>
            </tr>
        </table>

        <!--| paging |-->
        </div></td>
    </tr>
</table>
<br />
    <?php } // end condition ?>
<?php

} // end function
/*********************************************************************************************************/
function add_item(){

?>

<table width="608" border="0" cellpadding="0" cellspacing="0">

    <tr>
        <td><div class="error111"><?php writeErrors() ?></div></td>
        <td align="right" valign="top"><a href="form.php?op=add">
        <img src="<?php echo IMAGES_DIR ?>/buttons/btn_additem.gif" width="58" height="15" alt="" border="0" /></a>
        </td>
    </tr>
</table>

<?php


}

/******************************************************************************************************/
function user_answere($aPoll,$iCnt){

?>
<table border="0" cellpadding="0" cellspacing="0" dir="rtl">
    <tr>
        <td><div class="header"><?php print ENTITY ?>  </div></td>
    </tr>
    <tr>
        <td><div class="copy"> </div></td>
    </tr>
</table>

<form action="<?php print SELF ?>?cursor=<?php print $iCursor ?>" method="post" name="wroxform">
<input type="hidden" name="pollid" value="<?php print $aPoll["Poll Id"] ?>">
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <?php if ($iCnt) { // check poll count value ?>
    <tr>
        <td><div class="section"><?php print format($aPoll["Question"]) ?></div></td>
    </tr>
    <tr>
        <td class="dotrule"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <tr>
        <td>

        <table width="608" border="0" cellpadding="0" cellspacing="0">
        <?php
        $i = 0;
        $sChecked = "checked";
        strcmp($_COOKIE["cPOLL"], $aPoll["Poll Id"]) ? $iVoted = false : $iVoted = true;

        while ($i < count($aPoll["Answers"])) { // loop poll answers
        ?>
        <?php if (!$iVoted && $iCursor <1) { // poll vote check ?>
        <tr>
            <td width="25"><div class="copy"><input type="radio" name="vote" value="<?php print $aPoll["Answers"][$i]["Answer Id"] ?>"<?php print $sChecked ?>></div></td>
            <td width="583"><div class="copy"><?php print format($aPoll["Answers"][$i]["Answer"]) ?></div></td>
        </tr>
        <tr>
            <td colspan="2" class="dotrule"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
        </tr>
        <?php

        } else { // display results

            // assign calculation defaults
            $iPerc = 0;
            $iWidth = 0;

            // if the poll total vote count is greater than 0
            if ($aPoll["Vote Count"]) {

                // find the percentage
                $iPerc = round($aPoll["Answers"][$i]["Answer Count"] / $aPoll["Vote Count"] * 100, 0);
            }

            // multiply the percentage by 5.9 to get a scaled image length
            $iWidth = round(($iPerc * 5.9) - 1, 0);

        ?>
        <tr>
            <td><div class="copy"><?php print format($aPoll["Answers"][$i]["Answer"])." ".$iPerc ?>%</div></td>
        </tr>
        <tr>
            <td>
                <img src="<?php echo IMAGES_DIR ?>/meter_right.gif" width="5" height="10" alt="" border="0"><img src="<?php echo IMAGES_DIR ?>/meter.gif" width="<?php print $iWidth ?>" height="10" alt="" border="0"><img src="<?php echo IMAGES_DIR ?>/meter_left.gif" width="5" height="10" alt="" border="0">
            </td>
        </tr>
        <tr>
            <td class="dotrule"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
        </tr>
        <?php } // end answers  display check ?>
        <?php
            // check default state for radio buttons
            if (!strcmp("checked", $sChecked)) {

                $sChecked = "";
            }

            ++$i;
        } // end poll answers loop
        ?>
        </table>

        </td>
    </tr>
    <?php if (!$iVoted && $iCursor < 1) { // poll vote check ?>
    <tr>
        <td align="right"><input type="image" src="<?php echo IMAGES_DIR ?>/buttons/btn_submit.gif" width="58" height="15" alt="" border="0" onfocus="this.blur();" /></td>
    </tr>
    <tr>
        <td><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <? } else { // poll vote has been recorded, render totals ?>
    <tr>
        <td><div class="section">Total Votes: <?php print $aPoll["Vote Count"] ?></div></td>
    </tr>
    <tr>
        <td><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <?php  } // end poll vote check ?>
    <tr>
        <td>
        <?php if ($iCnt > 1 && ($iVoted || $iCursor > 0)) { // verify pagination display ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="right"><div class="paging">
                <!--| paging |-->


                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                       <td width="15"><?php if ($iCursor + 1 < $iCnt) { ?><a href="<?php print SELF ?>?cursor=<?php print $iCursor + 1 ?><?php print $sVar ?>"><img src="<?php echo IMAGES_DIR ?>/buttons/btn_next.gif" width="15" height="15" alt="" border="0" /><?php } else { ?><img src="<?php echo IMAGES_DIR ?>/buttons/btn_next_null.gif" width="15" height="15" alt="" border="0" /><?php } ?></a></td>

                        <td width="5"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="5" height="1" alt="" border="0" /></td>

                        <td width="15"><?php if ($iCursor > 0) { ?><a href="<?php print SELF ?>?cursor=<?php print $iCursor - 1 ?><?php print $sVar ?>"><img src="<?php echo IMAGES_DIR ?>/buttons/btn_prev.gif" width="15" height="15" alt="" border="0" /><?php } else { ?><img src="<?php echo IMAGES_DIR ?>/buttons/btn_prev_null.gif" width="15" height="15" alt="" border="0" /><?php } ?></a></td>
                    </tr>
                </table>

                <!--| paging |-->
                </div></td>
            </tr>
        </table>
        <br />
        <?php } // end pagination display verification ?>
        </td>
    </tr>
    <?php } else { // there are no polls ?>
    <tr>
        <td><div class="copy">מצטערים אין כרגע שאלות.</div></td>
    </tr>
    <?php } // end poll count value check ?>
</table>
</form>
<?php
}
/***********************************************************************************************************/
// write user errors (usage: must be called inside html body)
function writeErrors() {

    global $ERRORS;

    if (count($ERRORS)) {
        print "<strong>Error_</strong><br />";
        while(list($key, $value) = each($ERRORS)) {
            print($value)."<br />";
        }
    }
}
/////////////////////////////////////////////////////////////
// write system errors (usage: must be called in javascript tags inside html head)
function writeExceptions() {

    global $EXCEPTS;

    $sReturn .= "// exception reporting
    function trace() {
        var msg = \"\";";

        if (count($EXCEPTS)) {
            $sMsg = "";
            while(list($key, $value) = each($EXCEPTS)) {
                $sMsg .= "msg = msg + \"".str_replace("\n", "", addslashes($value))."\\n\";\n";
            }
            $sReturn .= $sMsg;
        }

    $sReturn .= "\t
        if (msg != \"\") {
            alert(msg);
        }
    }
    document.onload = trace();\n";

	 return $sReturn;
}
////////////////////////////////////////////////////////////
// write a pre-formatted array contents
function dump($aArgs) {
    print "<pre>";
    print_r($aArgs);
    print "</pre>";
}





/*********************************************************************************************************/
function build_ui($decID=""){
?>

 <ul id="tasksList" class="sortableList"
        onmouseup="process('tasksList', 'updateList')">

  <?php
  require_once('model/taskslist.class.php');
        $myTasksList = new TasksList($decID);
        echo $myTasksList->BuildTasksList($decID);
   ?>
 </ul>
  <?php
}
/**********************************************************************************************************/

/***********************************************************************************************************/
/**************************************************************************************************************/
function renderList4($iCnt=0, $aData='') {

    global $iCursor, $iPerm;
//form_new_line();
 ?>
<br />
<?php   if (is_array($aData)) { ?>


<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">

<table width="608" border="0" cellpadding="0" cellspacing="0">

    <tr>
        <td width="348" colspan="2"><div><strong>משימות</strong></div></td>

        <td width="90"><div><?php { ?><strong>פעולות לביצוע</strong><?php } ?></div></td>
        <td width="170"><div><strong>תאריך</strong></div></td>
    </tr>


    <tr>
        <td  colspan="4"><img src="<? echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>




    <?php
    // loop through data and conditionally display functionality and content
    $i = 0;

    while ($i < count($aData)) {

        $aState = array("act", "deact");
    ?>




         <tr id="tr_<?php echo  $aData[$i]->id_task_pk ?>">




  <td width="16" >
     <div<?php print $aData[$i]->status  ?>">

      <a href="dynamic_5.php?action=<?php print $aState[$aData[$i]->status] ?>&id_task_pk=<?php print $aData[$i]->id_task_pk ?>" onclick="return verify();">

        <img src="<?php echo IMAGES_DIR ?>/icon_status_<?php print $aData[$i]->status?>.gif" width="16" height="10" alt="" border="0" /> </a>

     </div>
  </td>



        <td width="332" >

          <div>

          <?php print format($aData[$i]->task_description )?>
          </div>
        </td>




 <td width="90">



       <a href="drag-and-drop.php?action=updateTask&id_task_pk=<?php print $aData[$i]->id_task_pk?>" >
         <b>ערוך</b>
       </a>&nbsp;|&nbsp;



       <a  href="void" onclick="return verify() && delete_task(<?php echo $aData[$i]->id_task_pk?>) && 0 ;return false; ">
         <b>מחק</b>
       </a>




 </td>


     <td width="170" >
        <div
         <?php print $aData[$i]->status ?>"><?php print date("d-m-Y H:i:s" , strtotime($aData[$i]->created_dt) ) ?>
        </div>
     </td>



    <!--
    <tr>
        <td  colspan="4"><img src="../../images/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
     -->
</tr>

<?php

        ++$i;
    } // end loop

?>

</table>

<script type="text/javascript">
function delete_task(task_id) {
	//alert(task_id);
     var decID = document.getElementById("decID").value;

    var li = document.getElementById('li_'+task_id).value ;
    // alert(li);
	new Ajax.Request('<?php echo ADMIN_WWW_DIR ?>/drag-and-drop.php',
	  {
	    method:'get',
	    parameters: {id_task_pk: task_id ,decID:decID,action: 'delTask'},

	    onSuccess: function(transport){
	        var response = transport.responseText || "no response text";
	       // alert("Success! \n\n" + response);

	       $('tr_'+task_id).remove();

	       $('li_'+task_id).remove();
	      // alert(liItem);
	    },

	    onFailure: function(){ alert('Something went wrong...') }
	  });


	return false;
}
</script>






</form>



<?php } else { ?>
<table width="608" border="0" cellpadding="0" cellspacing="0">
    <tr>
       <?php show_error_msg("אין משימות כרגע."); ?>
    </tr>
</table>

<?php } // end condition ?>
<?php }//form_end_line(); // end function  ?>
<?php

/************************************************************************************/
/***************************************************************************************************/

// renders a paginated list for the site admin
function renderList5($iCnt=0, $aData='') {

    global $iCursor, $iPerm;

 ?>
<br />
<?php   if (is_array($aData)) { ?>

<!--  action='delete.php' -->
<form method='post' action='<?php echo ADMIN_WWW_DIR;?>/delete_multiple_records/delete.php' method="post">

<table width="608" border="1" cellpadding="1" cellspacing="1" float="right">

    <tr>
        <th width="348" colspan="2"><div><strong>תאור משימה</strong></div></th>
        <th width="348" colspan="1"><div><strong>מי שלח</strong></div></th>
         <th width="50" colspan="1"><div><strong>אל מי נישלחה</strong></div></th>
         <th width="348" colspan="1"><div><strong>איזו החלטה</strong></div></th>
         <th width="348" colspan="1"><div><strong>תאריך</strong></div></th>
<!--         <td width="170"><div><strong>תאריך</strong></div></td>-->
        <th width="90"><div><?php { ?><strong>סמן למחיקה</strong><?php } ?></div></th>

    </tr>




    <?php
    // loop through data and conditionally display functionality and content
    $i = 0;

    while ($i < count($aData)) {

        $aState = array( "deact","act");

        $id=$aData[$i]->taskID;
    ?>




 <tr id="tr_<?php echo  $aData[$i]->taskID ?>">




  <td width="16" >
     <div<?php print $aData[$i]->compl  ?>">

      <a href="dynamic_5.php?action=<?php print $aState[$aData[$i]->compl] ?>&taskID=<?php print $aData[$i]->taskID ?>" onclick="return verify();">

        <img src="<?php echo IMAGES_DIR ?>/icon_status1_<?php print $aData[$i]->compl?>.gif" width="16" height="10" alt="" border="0" /> </a>

     </div>
  </td>



        <td class="even" width="100" >

          <div width="100">

          <?php print format($aData[$i]->title )?>
          </div>

         </td>


          <td width="332" >
          <div>
                   <?php print format($aData[$i]->full_name )?>
          </div>

          </td>


           <td width="332" >
            <div>
                   <?php print format($aData[$i]->dest_userID)?>
          </div>

           </td>


          <td width="332" >
           <div>
                   <?php print format($aData[$i]->decName )?>
          </div>

           </td>




<!-- <td width="200">        -->
<!-- -->
<!--          -->
<!--      <a href="drag-and-drop.php?action=updateTask&taskID=<?php print $aData[$i]->taskID?>" >-->
<!--         <b>ערוך</b>-->
<!--       </a>&nbsp;|&nbsp; -->
<!--  </td>        -->
<!--   -->
<!--   <td width="200">         -->
<!--       <a  href="void" onclick="return verify() && delete_task(<?php echo $aData[$i]->taskID?>) && 0 ;return false; ">-->
<!--         <b>מחק</b> -->
<!--       </a>-->
<!--           -->
<!--     </td>       -->


     <td width="200" >
        <div
         <?php print $aData[$i]->compl ?>"><?php print date("d-m-Y H:i:s" , strtotime($aData[$i]->task_date) ) ?>
        </div>
     </td>

   <td><input type='checkbox' name='checkbox[]' id='checkbox[]'  value="<?php echo $id; ?>" /></td>


</tr>

<?php

        ++$i;
    } // end loop
echo "</table><p><input id='delete' type='submit' class='button' name='delete' value='מחק משימות'/></p></form> ";

  } else { ?>
<table width="608" border="0" cellpadding="0" cellspacing="0">

    <tr>
       <?php show_error_msg("אין משימות כרגע."); ?>
    </tr>
</table>

<?php } // end condition ?>
<?php }//form_end_line(); // end function  ?>
<?php

/************************************************************************************/



function htmlarray($a, $exclude=null)
{
	htmlarray_ref($a, $exclude);
	return $a;
}

function htmlarray_ref(&$a, $exclude=null)
{
	if(!$a) return;
	if(!is_array($a)) {
		$a = htmlspecialchars($a);
		return;
	}
	reset($a);
	if($exclude && !is_array($exclude)) $exclude = array($exclude);
	foreach($a as $k=>$v)
	{
		if(is_array($v)) $a[$k] = htmlarray($v, $exclude);
		elseif(!$exclude) $a[$k] = htmlspecialchars($v);
		elseif(!in_array($k, $exclude)) $a[$k] = htmlspecialchars($v);
	}
	return;
}

function stop_gpc(&$arr)
{
	if (!is_array($arr)) return 1;

	if (!get_magic_quotes_gpc()) return 1;
	reset($arr);
	foreach($arr as $k=>$v)
	{
		if(is_array($arr[$k])) stop_gpc($arr[$k]);
		elseif(is_string($arr[$k])) $arr[$k] = stripslashes($v);
	}

	return 1;
}
function _post($param,$defvalue = '')
{
	if(!isset($_POST[$param])) 	{
		return $defvalue;
	}
	else {
		return $_POST[$param];
	}
}

function _get($param,$defvalue = '')
{
	if(!isset($_GET[$param])) {
		return $defvalue;
	}
	else {
		return $_GET[$param];
	}
}

/************************************************************************************/
//code by acmol
function array2ul($array) {
    $out = "<ul>";
    foreach($array as $key => $elem){
        if(!is_array($elem)){
            $out .= "<li><span>$key:[$elem]</span></li>";
        }
        else $out .= "<li><span>$key</span>".array2ul($elem)."</li>";
    }
    $out .= "</ul>";
    return $out;
}

/************************************************************************************/
/************************************************************************************/
   
