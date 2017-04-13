<?php 

require_once ("../config/application5.php"); 
//define("TREEVIEW_LIB_PATH","treeview1/dbtreeview-distrib-1.0/lib/dbtreeview");
//require_once(TREEVIEW_LIB_PATH . '/dbtreeview.php');
//require_once("treeview1/dbtreeview-distrib-1.0/credentials.php"); 
 
  
class myHandler implements RequestHandler{
	
	//using 2 attribute : id=0, 1, 2, 3   root=1

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

		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    		   or die("Unable to connect to database.");
		mysql_select_db(DB_DATABASE) or die("Could not select database");

		if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}
		
		$nodes = $this->getChildrenDepth($depth, 1, $parentCode);
		

		$response = DBTreeView::createChildrenResponse($nodes);
		return $response;


		// Fermeture de la connexion 
		mysql_close($link);
	}

	/**return an array of children with subchidren...*/
	private function getChildrenDepth($depth, $currentDepth, $parentCode){

		$nodes =  $this->getChildren($parentCode);

		if($currentDepth < $depth){
			foreach($nodes as $node){
				$childAttrs =$node->getAttributes();
				$childCode = $childAttrs["decID"];
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
		
		$query = sprintf("SELECT * FROM decisions WHERE parentDecID='%s' ORDER BY decName", 
					mysql_escape_string($parentCode));
			
		$result = mysql_query($query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["decID"];
			//$text = "<b>$code</b> : ".$line["description"];
			$text ="<b> $line[decName]</b>";
			
			$node = DBTreeView::createTreeNode(
				$text, array("decID"=>$code));
			
			 $node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=%s", $code));
		
			//has children
			$query2 = sprintf("SELECT * FROM decisions WHERE parentDecID='%s' LIMIT 1", 
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
  echo '<form class="paginated" style="width:80%;">';	
  
  
   echo "<table><tr class='menu4'><td><p><b> ",build_href2("find3.php", "","", "חזרה לטופס החיפוש","class=my_decLink_root title= 'חיפוש כללי'") . " </b></p></td>\n";	

		
		echo "<td><p><b> ",build_href2("forum_demo12.php", "","", "חיפוש קטגוריות בדף","class=my_decLink_root title='חיפוש כללי לפי קטגורייה בדף'") . " </b></p></td>\n";	

		
		$url="../admin/forum_demo12_2.php";
	        $str='onclick=\'openmypage2("'.$url.'"); return false;\' title=\'חיפוש כללי לפי קטגורייה בחלון\'  class=my_decLink_root id=popup_frm ';
	        echo "<td><p><b> ", build_href5("", "", "חיפוש קטגוריות בחלון",$str) . " </b></p></td>\n";
	        
echo "<td><p><b> ",build_href2("../admin/database.php", "","", "עץ סגור של החלטות","class=my_decLink_root title='כול ההחלטות במיבנה עץ סגור'") . " </b></p></td></tr></table>\n";	
?>

<table>
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
  
  
 echo'<fieldset  style="margin-bottom:40px;margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">'; 	

 
$rootAttributes = array("code"=>"11", "depth"=>"10");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
$str="<b>כול ההחלטות</b>"	;
$tv->setRootHTMLText($str);
$tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
$tv->printTreeViewScript();
echo'</fieldset></form>';
html_footer();
?>
 
