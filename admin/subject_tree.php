<?php 

require_once ("../config/application5.php"); 


class myHandler implements RequestHandler{
	
	 

	public function handleChildrenRequest(ChildrenRequest $req){
		$attributes = $req->getAttributes();	
		if(!isset($attributes['code'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['code'];

		$depth = 1;
		if(isset($attributes['depth'])){
			$depth = $attributes['depth'];
		}
		if($depth<1){
			die("depth error : must be > 0");
		}

        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
        mysqli_set_charset($link, 'utf8');
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }


        $nodes = $this->getChildrenDepth($depth, 1, $parentCode);
		

		$response = DBTreeView::createChildrenResponse($nodes);
		return $response;


		// Fermeture de la connexion 
		mysqli_close($link);
	}

	/**return an array of children with subchidren...*/
	private function getChildrenDepth($depth, $currentDepth, $parentCode){

		$nodes =  $this->getChildren($parentCode);

		if($currentDepth < $depth){
			foreach($nodes as $node){
				$childAttrs =$node->getAttributes();
				$childCode = $childAttrs["catID"];
				if($childCode==NULL){
					die("child code is null");
				}
				$children =  $this->getChildrenDepth($depth, $currentDepth+1, $childCode);
				if($children==NULL){
					//die("null");
				}
				$node->setChildren($children);
				$node->setIsOpenByDefault(true);
			}
		}
		return $nodes;
	}

	/**
	 * Returns the children (array)
	 */
	private function getChildren($parentCode){
		
		$query = sprintf("SELECT * FROM categories WHERE parentCatID='%s' AND status=1 ",
            mysqli_real_escape_string($link,$parentCode));
			
		$result = mysql_query($query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["catID"];
			//$text = "<b>$code</b> : ".$line["description"];
			$text ="<b> $line[catName]</b>";
			$desc =$line[catName];
			$file_name =$line[fileName];
			$parentCatID =$line['parentCatID'];

			
			
			$node = DBTreeView::createTreeNode(
				$text, array("catID"=>$code));
			 
//			$node->setURL(sprintf(ROOT_WWW."/admin/subject_file.php?file_name=$file_name&parentCatID=$parentCatID&desc=$desc&catID=%s", $code));
if(!($parentCatID=='11'))
	$node->setURL(sprintf(ROOT_WWW."/admin/$file_name"));
else	
  $node->setURL(sprintf("javascript:void(0)"));
	//$node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_forum&managerTypeID=%s", $code));
		
			//has children
			$query2 = sprintf("SELECT * FROM categories_file WHERE parentCatID='%s' AND status=1 LIMIT 1", 
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

		return $nodes;

	}
} //class TestListener



try{
	DBTreeView::processRequest(new MyHandler());
}catch(Exception $e){
	echo("Erreur:". $e->getMessage());
}
  html_header();
 echo '<form class="paginated">';	
 echo '<div>';		
echo "<table ><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
		echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
		$url="../admin/forum_demo12_2.php";
	        $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";
	        
	        
	  echo "<td><p><b> ",build_href2("manager.php", "","", "עריכת מנהלים","class=my_decLink_root title='עריכת מנהלים'") . " </b></p></td>\n";      
	        
       echo "<td><p><b> ",build_href2("../admin/manager_tree.php", "","", "עץ המנהלים","class=my_decLink_root title='עץ המנהלים'") . " </b></p></td></tr></table> \n";
 ?>
<table style="width:50%;">
 <tr>
 <td >     
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
 
 
$rootAttributes = array("code"=>"11", "depth"=>"10");
$treeID = "treev_subject";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
$str="<b>כול הנושאים</b>"	;
$tv->setRootHTMLText($str);
$tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
$tv->printTreeViewScript();

echo'</fieldset></form>';
html_footer();
?>
 