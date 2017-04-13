<?php

	//autocomp.php
     require_once ("config/application1.php");
     require_once (LIB_DIR . "/formfunctions.php");
	 
	html_header();
	$foundarr = array ();
	
	//Setup the dynamic query string.
	$sql = "SELECT * FROM decisions WHERE decName LIKE LOWER('%" .$db->escape ($_GET['sstring']) . "%') ORDER BY decName desc";
	if( !isset($_REQUEST['sstring']) ) {
		?>
		       <form method="GET">
              Name: <input type="text"  name="sstring">
             <input type="submit" value="GET">
           </form>
        <? 
        return;
	}
	if ($rows =$db->queryObjectArray ($sql)){
	foreach ($rows as $row){
			if (!get_magic_quotes_gpc()){
				$foundarr[] = stripslashes ($row-> decName  );
			} else {
				$foundarr[] = $row->decName;
			}
		}
	} else {
		echo "cant make it";//mysql_error();
	}
	
	//If we have any matches, then we can go through and display them.
	if (count ($foundarr) > 0){
		?>
		<div style="background: #CCCCCC; border-style: solid; border-width: 1px; border-color: #000000;">
			<?php
				for ($i = 0; $i < count ($foundarr); $i++){
					?><div style="padding: 4px; height: 14px;" onmouseover="this.style.background = '#EEEEEE'" onmouseout="this.style.background = '#CCCCCC'" onclick="setvalue ('<?php echo $foundarr[$i]; ?>')"><?php echo $foundarr[$i]; ?></div><?php
				}
			?>
		</div>
		<?php
	}
html_footer();	
?>
<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="get">
   טקסט ההחלטה: <input type="text"  name="sstring">
    <input type="submit" value="GET">
</form>