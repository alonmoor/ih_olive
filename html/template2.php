<?
/*######################3
# tempalte file
#
# 
# added:
#	 create_html_table which get an array and show its as a tables. (yahel);
#######################*/

function get_page_section() {
	$arr =  split("/",$_SERVER['PHP_SELF']);
	$this_page = $arr[count($arr)-1];	
	echo $this_page;
		
	switch($this_page){
		case 'database.php': return 1;
		case 'categories.php': return 2;
		//case 'decisions.php': return 3;
		//case 'dynamic_5.php': return 4;
		case 'findtree.php':	return 5;
		case 'findtree1.php':	return 6;
		case 'find3.php': return 7;
		//case 'users.php': return 8;
		case 'charge_issued.php':return 9;
		case 'testdb.php':
		default:
			return 0;
	}

		
}


function drawTab($title,$url, $is_current_tab){
?>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<? if( $is_current_tab ) { ?>
			<td><img src="<?=TAMPLATE_IMAGES_DIR ?>/currentTab_left.png"></td>	
			<td nowrap background="<?=TAMPLATE_IMAGES_DIR ?>/currentTab_middle.png">
				<a class="current_tab" href="<?=$url?>">&nbsp;<?=$title?>&nbsp;</a></td>
			<td><img src="<?=TAMPLATE_IMAGES_DIR?>/currentTab_right.png"></td>
		<? } else { ?>
			<td><img src="<?=TAMPLATE_IMAGES_DIR?>/otherTab_left.gif"></td>	
			<td nowrap background="<?=TAMPLATE_IMAGES_DIR ?>/otherTab_middle.gif">
				<a class="other_tab" href="<?=$url?>">&nbsp;<?=$title?>&nbsp;</a></td>
			<td><img src="<?=TAMPLATE_IMAGES_DIR ?>/otherTab_right.gif"></td>
		<? } ?>
		</tr>
	</table>

<?	
}

function html_header($arr_sublinks=""){
	$section = get_page_section();

?>
<html>
<head>
    <meta http-equiv="Content-Type"
      content="text/html; charset=utf-8" />
    <title>מערכת ניהול החלטות</title>
	<meta http-equiv="expires" content="Tue, 20 Jun 1995 04:13:09 GMT">
	<meta http-equiv="pragma" content="no-cache">
	 
	
	<!-- <script language="JavaScript1.2" src="../lib/event_worker.js" type="text/javascript"></script>-->
	
	<!-- <link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />-->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/form.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/resulttable.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/screen.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/treeview.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/table.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/table1.css" />
	<style>
	body { 
		margin: 0px 0px 0px 0px;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		color: #444444;
		font-size: 12px;
		 
		background-color: #b0b0ff ;		
	}
	.other_tab{color:#666666;font-size:11px;font-weight:bold;text-decoration:none} 	
	.current_tab{color:#000000;font-size:11px;font-weight:bold;text-decoration:none}
	.grey_welcome{color:#ffffff;font-size:12px;font-weight:bold;}
	.sub_menu{color:#666666;font-size:11px;font-weight:bold;text-decoration:none}
	.cls_input{border:1px inset #deded0;font-size:14px;font-family:Arial}
	.logout{color:#ffffd0;font-size:11px;font-weight:bold;text-decoration:none}
	table{font-size:14px;font-family:Arial}
	th{background:#e7e7e0;color:#000000;font-size:18px;font-family:Arial,Tahoma;font-weight:bold;font-style:italic}	
	.page_title{background:#e7e7e0;color:#000000;font-size:18px;font-family:Arial,Tahoma;font-weight:bold;font-style:italic}
	.btn_close{background:#e7e7e0;border:1px outset #ffffff; color:#000000;font-size:11px;font-family:Arial,Tahoma;}
	.btn_submit{background:#DEDEBA;border:1px outset #ffffff; color:#000000;font-size:11px;font-family:Arial,Tahoma;}
</style>

	</head>	
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="" dir="rtl">
<tr>
	
	<td align=right><img src="<?=IMAGES_DIR?>/chiuvit_logo.png"></td>
	<td bgcolor="#ffffff" height="62" colspan="40">&nbsp;</td>
</tr>
<tr>
	<td colspan="40">
		<table border="0" cellpadding="0" cellspacing="0" align="" dir="rtl">
			<tr>
				<td nowrap align="center" background="<?=TAMPLATE_IMAGES_DIR ?>/emptyTabSpace.png" width="20">&nbsp;</td>
				<td align="center"><? drawTab("דף ראשי","database.php", ($section==1) ) ?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
				<td align="center"><? drawTab("קטגוריות","categories.php", ($section==2) );?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
		<!--    <td align="center"><? drawTab("ניהול החלטה","decisions.php", ($section==3) );?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
				<td align="center"><? drawTab(" עריכת החלטות וקישור","dynamic_5.php", ($section==4) );?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td> -->	
				<td align="center"><? drawTab("תצוגת עץ חיפוש עולה","findtree.php", ($section==5) );?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
				<td align="center"><? drawTab("תצוגת עץ חיפוש יורד","findtree1.php", ($section==6));?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
				<td align="center"><? drawTab("חיפוש מורכב","find3.php", ($section==7));?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
		<!--  	<td align="center"><? drawTab("ניהול משתמשים","users.php", ($section==8));?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>-->
				<td align="center"><? drawTab("תגובות והצעות","charge_issued.php", ($section==9));?></td>
				<td align="center"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
				<td align="center" background="<?=TAMPLATE_IMAGES_DIR ?>/emptyTabSpace.png" width="90%">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="grey_welcome" colspan="40" bgcolor="#ACACAC" height="20">
	
	//&nbsp;&nbsp;&nbsp;&nbsp;���� ��� <?=$_SESSION['id']?>&nbsp;&nbsp;[<a class="logout" href="logout.php">יציאה</a>]</td>
</tr>

<tr>
	<td colspan="40" bgcolor="#777777" height="1"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td>
</tr>

<tr>
	<td colspan="40" bgcolor="#DEDEDE" height="26">
		<table cellpadding="0" cellspacing="0" border="0" class="sub_menu">
		<tr>
		<?
		switch ($section){
			case 1: // general.
			draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/general.php?mode=general_settings","����");
			draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/general.php?mode=import_settings","������ �����");
			break;
			case 2: // drives.
				draw_in_tab_link(ROOT_WWW."/category_tree.php?mode=add","תצוגת עץ קטגוריות");
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/drives.php?mode=drives","שלו");
			break;
			case 3:  
				draw_in_tab_link (ROOT_WWW ."/decisions.php?mode=add","הוסף החלטה");
				draw_in_tab_link (ROOT_WWW ."/decisions.php?mode=search","חפש החלטה");
				draw_in_tab_link (ROOT_WWW ."/find3.php?mode=search","חיפוש מתקדם של החלטות");
				draw_in_tab_link (ROOT_WWW ."/autocomp.php","חיפוש לפי מופעי אותיות");
				
				break;
			case 4: // users. 
				 draw_in_tab_link (ROOT_WWW ."/php_paging.php","<b>תצוגה אנכית</b>");
				break;
			case 5: // charge centers.				
				draw_in_tab_link(ROOT_WWW."/dec.php?mode=add","ערוך החלטה");
				break;			
				
			case 6: //  logs
				break;
			case 7: // rates.
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/rates.php?mode=show_rates","��� �������");
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/rates.php?mode=create_rates","��� �����");
				break;
			case 8: // rebates.
				draw_in_tab_link (ROOT_WWW ."/users.php?mode=add","הוסף משתמש");
				draw_in_tab_link (ROOT_WWW ."/users.php?mode=search","חפש משתמש");
				draw_in_tab_link (ROOT_WWW ."/find3.php?mode=search","חיפוש מתקדם של משתמשים");
				draw_in_tab_link (ROOT_WWW ."/autocomp.php","חיפוש לפי מופעי אותיות");
				break;
			case 9: // charge issued.
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/charge_issued.php?mode=show_charge_issued","����� �������");
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/charge_issued.php?mode=add_charge_issued","����� ����� ����");
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/charge_issued.php?mode=add_drives_to_charge_issued","����� ������ �������");
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/charge_issued.php?mode=remove_drive_from_charge","����� ����� ������");
				break;
			case 10:
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/reports.php?mode=users_chrg_report","��� ���� ��������");				
				draw_in_tab_link(DRIVE_CHARGE_ROOT_WWW."/reports.php?mode=users_chrg_report_sum","��� �����");
				break;			
		}
		?>
		
		</tr>
		</table>
	</td>
</tr>

<tr><td colspan="40" bgcolor="#777777" height="1"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td></tr>
<tr><td colspan="40" bgcolor="#ffffff" height="1"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif"></td></tr>

<tr>
<td colspan="40" bgcolor="#ffffff" style="padding:2px">
<?
}
function html_footer(){
?>
</td>
</tr>
</table>
</body>
</html>
<?
}
function draw_in_tab_link($link,$name) {
	?>		<td>&nbsp;&nbsp;&nbsp;<a class="other_tab" href="<?=$link?>"><?=$name?></a>&nbsp;&nbsp;&nbsp;</td>
			<td bgcolor="#ffffff"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif" height="10" width="1"></td>
			<td bgcolor="#777777"><img src="<?=TAMPLATE_IMAGES_DIR ?>/blank.gif" height="10" width="1"></td>
	<?
}
// $arr_data[][], note: 
function create_html_table($arr_data, $title="") {	
	if(!is_array($arr_data))
		return;
	
	?><table cellspacing="3" cellpadding="3"><?
	?><tr><td colspan="10"><font size=+1><b><?=$title?></b></font></td></tr><?	
	if( is_array($arr_data) && count($arr_data) ) {
		foreach($arr_data as $i=>$row) {
			
			if( strncmp($row[0], "tr_data:", 8) == 0 ){ // insert data to the table row.
				printf("<tr %s>", substr($row[0], 8));
			} else {
				?><tr><?						
			}
				
			if( !$i ) {
				// first row as a header.			
				foreach($row as $cell) {
					?><th><?=$cell?></th><?		
				}			
			} else {
				// data.
				foreach($row as $j=>$cell ) {
					if( $j==0 && strncmp($row[0], "tr_data:", 8) == 0 )
						continue;
						
					?><td><?=$cell?></td><?			
				}			
			}
			echo "</tr>\n";
		}	
	}
	?></table><?
}
function add_html_page_title($title) {	
	?>
	<table class=page_title>
		<tr>
			<td><?=$title?></td>
		</tr>
	</table><?
}
function add_html_info($info) {
	?>
	<table>
		<tr>
			<td><?=$info?></td>
		</tr>
	</table><?
}

