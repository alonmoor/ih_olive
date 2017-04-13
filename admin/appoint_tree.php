<?php 
 
require_once ("../config/application3.php"); 



class MyHandler implements RequestHandler{
	


	public function handleChildrenRequest(ChildrenRequest $req){
		
		$attributes = $req->getAttributes();
		
		if(!isset($attributes['appointID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['appointID'];
	
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    		   or die("Unable to connect to database.");
		mysql_select_db(DB_DATABASE) or die("Could not select database");

		if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}
		

		 $query = sprintf("SELECT * FROM appoint_forum WHERE parentAppointID='%s' order by appointName", 
		 					mysql_escape_string($parentCode));
					
					
		$result = mysql_query($query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["appointID"];

			$text ="<b> $line[appointName]</b>" ;
			 
			
		 $node = DBTreeView::createTreeNode(
				$text, array("appointID"=>$code));
	      $node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_forum&appointID=%s", $code));
		
		//has children
          $query2 = sprintf("SELECT * FROM appoint_forum WHERE parentAppointID='%s' order by appointName LIMIT 1", 
        					mysql_escape_string($code));
					
		$result2 = mysql_query($query2) or die("Query failed");
		if(!mysql_fetch_assoc($result2)){
			//no children
			$node->setHasChildren(false);
			$node->setClosedIcon(TAMPLATE_IMAGES_DIR ."/doc.gif");
		}
		$nodes[] = $node;
		}

		// Lib?ration des r?sultats 
		 mysql_free_result($result);

		// Fermeture de la connexion 
		mysql_close($link);
		
		$response = DBTreeView::createChildrenResponse($nodes);
		return $response;
	}
} //class TestListener


try{
	DBTreeView::processRequest(new MyHandler());
}catch(Exception $e){
	echo("Error:". $e->getMessage());
}
 
html_header();
 echo '<form class="paginated" style="width:80%;">';
 
  echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
$url="../admin/forum_demo12_2.php";
$str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";
	        
		        
      echo "<td><p><b> ",build_href2("../admin/database5.php", "","", "עץ הפורומים","class=my_decLink_root title='עץ הפורומים'") . " </b></p></td></tr></table>\n";
       	
 
 ?>

<table>
<tr>
<td>     
    <?php form_label1('חתכי סוגי החלטות:',TRUE); ?>
     <a href='#' title='חתכי סוגי החלטות'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_DEC/Default.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>  
</td>

<td> 
<?php form_label1('חתכי סוגי פורומים:',TRUE); ?>
         <a href='#' title='חתכי סוגי פורומים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJX_CAT_FORUM/default_ajx2.php'"; ?> ,'סוגי פורומים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>
</td>     
  
  
  
<td> 
 <?php form_label1('חתכי סוגי מנהלים:',TRUE); ?>    
     <a href='#' title='חתכי סוגי מנהלים'  class="tTip"  OnClick= "return  opengoog2(<?php echo " '".ROOT_WWW."/admin/PHP/AJAX/default.php'"; ?> ,'סוגי המנהלים');this.blur();return false;";  > 
            <img src='<?php echo ROOT_WWW;?>/images/pie-chart-icon.png'     onMouseOver="this.src=img.edit[1]" onMouseOut="src='<?php echo ROOT_WWW; ?>/images/pie-chart-icon.png'"    title='הצג נתונים' />

     </a>                                                               
                                                      
</td></tr></table>                
 <?php  	            
 
 
 echo'<fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">'; 	 


 global $lang;
/*
  if ($_SESSION["auth_level"]=='admin')  
 	    echo "היתחברת כ- מנהל אם שם משתמש " .$_SESSION["auth_username"];   
	  
 	  elseif($_SESSION["auth_level"]=='user') 	 
      echo "היתחברת כ- משתמש רגיל אם שם משתמש "   .$_SESSION["auth_username"];  
  
	  elseif(($_SESSION["auth_level"])=='suppervizer')  
      echo " היתחברת כ- מפקח אם שם משתמש " .$_SESSION["auth_username"];  
 	 
	
     elseif(($_SESSION["auth_level"])=='user_admin')  
      echo "היתחברת כ-מנהל+משתמש אם שם משתמש " .$_SESSION["auth_username"];
      else
 		echo "User: Not logged in<br>";  

*/
$rootAttributes = array("appointID"=>"11");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
$str="ממני פורומים בעין השופט"	;
$tv->setRootHTMLText($str);
$tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
$tv->printTreeViewScript();
echo'</fieldset></form>';
html_footer();
 
?>