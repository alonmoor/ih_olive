<?php 
 
require_once ("../config/application3.php"); 



class MyHandler implements RequestHandler{
	


	public function handleChildrenRequest(ChildrenRequest $req){
		$class='class="href_modal1"';
		$attributes = $req->getAttributes();
		
		if(!isset($attributes['decID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['decID'];
	
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    		   or die("Unable to connect to database.");
		mysql_select_db(DB_DATABASE) or die("Could not select database");

		if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}
		

 
		$query = sprintf("select distinct decID,decName,parentDecID from tmp_dec WHERE parentDecID='%s'", 
					mysql_escape_string($parentCode));
					
					
		$result = mysql_query($query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["decID"];
			
			$text = "<b> $line[decName]</b>";
			
		 	
			
			
			
		 $node = DBTreeView::createTreeNode(
				$text, array("decID"=>$code));
		 $node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=%s", $code));
		 
        $query2 = sprintf("select distinct decID,decName,parentDecID from tmp_dec WHERE parentdecID='%s' LIMIT 1", 
					mysql_escape_string($code));
					
		$result2 = mysql_query($query2) or die("Query failed");
		if(!mysql_fetch_assoc($result2)){
			//no children
			$node->setHasChildren(false);
			$node->setClosedIcon(TAMPLATE_IMAGES_DIR ."/doc.gif");
		}
		$nodes[] = $node;
		}

		 
		 mysql_free_result($result);

		 
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
 echo '<form class="paginated">';	  
 echo'<fieldset  style="background: #94C5EB url(../images/background-grad.png) repeat-x;margin-left:80px;margin-bottom:80px;">'; 
  
 ?>
<!--<script type="text/javascript" src="ajax.lang.php"></script> -->
<?php  
$rootAttributes = array("decID"=>"11");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
$str="כול ההחלטות"	;
$tv->setRootHTMLText($str);
$tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
$tv->printTreeViewScript();
echo'</fieldset>';
 echo "<p>חזרה אל ",
    build_href("find3.php", "", "חיפוש מורכב") . ".\n";
    
echo'</fieldset>'; 	
echo '</form>';     
html_footer();
?>
