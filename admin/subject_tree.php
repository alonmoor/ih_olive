<?php 

require_once ("../config/application3.php");

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
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
        mysqli_set_charset($link, 'utf8');
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

		$query = sprintf("SELECT * FROM categories WHERE parentCatID='%s'  ",
            mysqli_real_escape_string($link,$parentCode));
			
		$result = mysqli_query($link ,$query) or die("Query failed");

		$nodes=array();


        while ($line = mysqli_fetch_assoc($result)) {
			$code = $line["catID"];
			$text ="<b> $line[catName]</b>";
			$node = DBTreeView::createTreeNode(
			$text, array("catID"=>$code));
            $node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_dec&catID=%s", $code));
//----------------------------------------------------------

            //has children
			$query2 = sprintf("SELECT * FROM categories WHERE parentCatID='%s' LIMIT 1",
                mysqli_real_escape_string($link,$code));

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
		return $nodes;
	}
} //class TestListener



try{
	DBTreeView::processRequest(new MyHandler());
}catch(Exception $e){
	echo("Erreur:". $e->getMessage());
}
  html_header();
 echo '<form class="paginated"><fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">';
 
 
$rootAttributes = array("code"=>"11", "depth"=>"10");
$treeID = "treev_open_cat";
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
 