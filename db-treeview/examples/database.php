<?php

//to test this file
// 1. create a MySQL database and import the nace.sql.gz SQL file
// 2. create a credentials.php file that define DB_HOST, DB_USER, DB_PASSWORD, and DB_DATABASE

/**
 * Example.
 * @package    DBTreeView
 * @author     Rodolphe Cardon de Lichtbuer <rodolphe@wol.be>
 * @copyright  2007 Rodolphe Cardon de Lichtbuer
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 */

define("TREEVIEW_LIB_PATH","../lib/dbtreeview");

//require_once(TREEVIEW_LIB_PATH . '/dbtreeview.php');
//require_once("../credentials.php");

require_once ("../../config/application5.php");

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

  html_header();


//head
//print("<html>\n<head>\n");
//printf("<script src=\"%s/treeview.js\" type=\"text/javascript\"></script>\n",
//			TREEVIEW_LIB_PATH);
//print('<link href="screen.css" rel="stylesheet" type="text/css" media="screen"/>');
//printf('<link href="%s/treeview.css" rel="stylesheet" type="text/css" media="screen"/>'."\n",
//			TREEVIEW_LIB_PATH);
//print("</head>\n");

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
?>
</body>
</html>