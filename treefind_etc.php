<?php 
 
require_once ("config/application2.php"); 
define("TREEVIEW_LIB_PATH","treeview1/dbtreeview-distrib-1.0/lib/dbtreeview");
require_once(TREEVIEW_LIB_PATH . '/dbtreeview.php');
 
  
 
require_once("treeview1/dbtreeview-distrib-1.0/credentials.php"); 
 
  

class MyHandler implements RequestHandler{
	
	//using 2 attribute : id=0, 1, 2, 3   root=1

	public function handleChildrenRequest(ChildrenRequest $req){
		
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
		

		//$query = sprintf("SELECT * FROM decisions WHERE parentDecID='%s'", 
		$query = sprintf("select distinct decID,decName,parentDecID from tmp_dec1 WHERE parentDecID='%s'", 
					mysql_escape_string($parentCode));
					
					
		$result = mysql_query($query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["decID"];
			//$text = "<b>$code</b> : ".$line["decN	ame"];
			$text = "<b> $line[decName]</b>";
			
		 $node = DBTreeView::createTreeNode(
				$text, array("decID"=>$code));
				//$text, array($code=>'decName'));
	     $node->setURL(sprintf("javascript:alert(\"צפה בהחלטה %s\");", $code));
		
		//has children
//		$query2 = sprintf("SELECT * FROM decisions WHERE parentdecID='%s' LIMIT 1", 
        $query2 = sprintf("select distinct decID,decName,parentDecID from tmp_dec1 WHERE parentdecID='%s' LIMIT 1", 
					mysql_escape_string($code));
					
		$result2 = mysql_query($query2) or die("Query failed");
		if(!mysql_fetch_assoc($result2)){
			//no children
			$node->setHasChildren(false);
			$node->setClosedIcon("doc.gif");
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
//head
print("<html>\n<head>\n");
printf("<script src=\"%s/treeview.js\" type=\"text/javascript\"></script>\n",
			TREEVIEW_LIB_PATH);
print('<link href="screen.css" rel="stylesheet" type="text/css" media="screen"/>');
printf('<link href="%s/treeview.css" rel="stylesheet" type="text/css" media="screen"/>'."\n",
			TREEVIEW_LIB_PATH);
print("</head>\n");
 
$rootAttributes = array("decID"=>"11");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
$str="כול ההחלטות"	;
$tv->setRootHTMLText($str);
$tv->setRootIcon("star.gif");
$tv->printTreeViewScript();
html_footer();
?>
</body>
</html>