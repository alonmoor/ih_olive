<?php 
 
require_once ("../config/application3.php"); 


 
  

class MyHandler implements RequestHandler{
	
	//using 2 attribute : id=0, 1, 2, 3   root=1

	public function handleChildrenRequest(ChildrenRequest $req){
		
		$attributes = $req->getAttributes();
		
		if(!isset($attributes['decID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['decID'];

        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
        mysqli_set_charset($link, 'utf8');
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }





        $query = sprintf("select distinct decID,decName,parentDecID from tmp_dec1 WHERE parentDecID='%s'",
            mysqli_real_escape_string($link,$parentCode));
					
					
		$result = mysqli_query($link, $query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysqli_fetch_assoc($result)) {
			$code = $line["decID"];
			 
			$text = "<b> $line[decName]</b>";
			
		 $node = DBTreeView::createTreeNode(
				$text, array("decID"=>$code));
				//$text, array($code=>'decName'));
	      $node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=%s", $code));
	      //$node->setURL(sprintf("http://dec.eh/admin/dynamic_5.php?mode=read_data&editID=%s", $code));
		
		//has children
 	 
        $query2 = sprintf("select distinct decID,decName,parentDecID from tmp_dec1 WHERE parentdecID='%s' LIMIT 1", 
					mysqli_real_escape_string($code));
					
		$result2 = mysqli_query($link, $query2) or die("Query failed");
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
  echo '<form class="paginated">';	  
 echo'<fieldset  style="background: #94C5EB url(../images/background-grad.png) repeat-x;margin-left:80px;margin-bottom:80px;">'; 
  
 ?>
<!--<script type="text/javascript" src="ajax.lang.php"></script> -->
<?php  
 
 global $lang;
 
 
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
echo '</form>'; 
 html_footer();
?>
