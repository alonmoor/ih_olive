<?php 
//define("TREEVIEW_LIB_PATH","../lib/model"); 
 
require_once 'dbtreeview.php';
//require_once(TREEVIEW_LIB_PATH . '/dbtreeview.php');
//require_once ("../config/application5.php"); 
 
 define('DB_HOST', '127.0.0.1');
define('DB_USER', 'alon');
 define('DB_PASSWORD','qwerty');
 define('DB_TBL_PREFIX', '');

 
 
//define('DB_DATABASE','dec_tests');
//define('DB_SCHEMA', 'dec_tests');


define('DB_DATABASE','dec');
define('DB_SCHEMA', 'dec');
//require_once("../credentials.php"); 
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    		   or die("Unable to connect to database.");
		mysql_select_db(DB_DATABASE) or die("Could not select database");

		if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}

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
		

		 $query = sprintf("SELECT * FROM decisions WHERE parentDecID='%s' ORDER BY decName", 
		
					mysql_escape_string($parentCode));
					
					
		$result = mysql_query($query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["decID"];
			 
			$text ="<b> $line[decName]</b>";
			
		 $node = DBTreeView::createTreeNode(
				$text, array("decID"=>$code));
			
	     $node->setURL(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=$code", ''  );
	     
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

 // html_header();
 
 ?>
 
 <html><head>
   <script language="javascript" src="js/treeview_test1.js" charset="utf-8" type="text/javascript"></script>
 <?php  
  print("</head>\n");
  
 
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


 
  
echo'</body>'; 	
echo '</html>'; 
 // html_footer();
?>
  