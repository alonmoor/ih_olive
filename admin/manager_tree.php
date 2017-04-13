<?php 
 
require_once ("../config/application3.php"); 

 
  

class MyHandler implements RequestHandler{
	
	//using 2 attribute : id=0, 1, 2, 3   root=1

	public function handleChildrenRequest(ChildrenRequest $req){
		
		$attributes = $req->getAttributes();
		
		if(!isset($attributes['managerID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['managerID'];

        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
        mysqli_set_charset($link, 'utf8');
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
		

		 $query = sprintf("SELECT * FROM managers WHERE parentManagerID='%s' order by managerName",
             mysqli_real_escape_string($link,$parentCode));
					
					
		$result = mysqli_query($link,$query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysqli_fetch_assoc($result)) {
			$code = $line["managerID"];
			 
			$text ="<b> $line[managerName]</b>" ;
			 
			
		 $node = DBTreeView::createTreeNode($text, array("managerID"=>$code));
		 
	      $node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_forum&managerID=%s", $code));
		
		//has children
          $query2 = sprintf("SELECT * FROM managers WHERE parentManagerID='%s'order by managerName LIMIT 1",  mysqli_real_escape_string($link,$code));
					
		$result2 = mysqli_query($link,$query2) or die("Query failed");
		if(!mysqli_fetch_assoc($result2)){
			//no children
			$node->setHasChildren(false);
			$node->setClosedIcon(TAMPLATE_IMAGES_DIR ."/doc.gif");
		}
		$nodes[] = $node;
		}

		// Lib?ration des r?sultats 
		 mysqli_free_result($result);

		// Fermeture de la connexion 
		mysqli_close($link);
		
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
 
 echo '<div>';		
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
	        
echo '</div>';	
 
 echo'<fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">'; 	 
 global $lang;
 

$rootAttributes = array("managerID"=>"11");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
$str="מנהלי עין השופט"	;
$tv->setRootHTMLText($str);
$tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
$tv->printTreeViewScript();
echo'</fieldset></form>';
  
html_footer();
 
?>