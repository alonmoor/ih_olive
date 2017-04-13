<?php
//
require_once ("../config/application3.php");


//define("TREEVIEW_LIB_PATH","treeview1/dbtreeview-distrib-1.0/lib/dbtreeview");
//require_once(TREEVIEW_LIB_PATH . '/dbtreeview.php');


class MyHandler implements RequestHandler{

	//using 2 attribute : id=0, 1, 2, 3   root=1

	public function handleChildrenRequest(ChildrenRequest $req){
		global $db;
		$attributes = $req->getAttributes();

		if(!isset($attributes['decID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['decID'];

		$mysqli = new mysqli("localhost", "alon", "qwerty", "dec");

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}


		$sql=("SET NAMES 'utf8'");
		$mysqli->query($sql);
		$parentCode= $mysqli->real_escape_string($parentCode);
		//$query = sprintf("SELECT * FROM decisions WHERE parentDecID='%s'",$parentCode);
		$query = sprintf("select distinct decID,decName,parentDecID from tmp_dec WHERE parentDecID='%s'",$parentCode);


		$result = $mysqli->query($query);
		if(!$result)
		return;
		$nodes=array();


		//		while ($line = mysql_fetch_assoc($result))
		while ($row = $result->fetch_object())
		{
			$code = $row->decID;//["decID"];
			$text = $row->decName;//["decName"];

		 $node = DBTreeView::createTreeNode(
		 $text, array("decID"=>$code));
		 // $text, array($code=>'decName'));
//-----------------------------------------------------------------------------------------------
		// $node->setURL(sprintf("javascript:alert(\"Open page for NACECODE %s\");", $code));


            // $text, array($code=>'decName'));
            //$node->setURL(sprintf("javascript:alert(\"Open page for NACECODE %s\");", $code));
            // $node->setURL(ROOT_WWW."/admin/find3.php?decID=$code", ''  );



            $url="../admin/find3.php?decID=$code";
            $str='onclick=\'openmypage2("'.$url.'");return false;\'class="href_modal1" ';
            $stam = "";
            $node->setURL(ROOT_WWW."/admin/find3.php?decID=$code", ''  );

          //  $node->setAttributes("class", "democlass");


            // $node->setURL(ROOT_WWW."/admin/find3.php?decID=$code", ''  );
            // $node->setURL(ROOT_WWW."/admin/find3.php?decID=$code", ''  );
            // $node->setURL(ROOT_WWW."/admin/find3.php?decID=$code", ''  );
            //$node->setURL('onclick=openmypage2("../admin/find3.php?decID=1963"); return false;' );
            //$node->setURL('onclick=openmypage2("../admin/find3.php?decID=1963"); return false;' );




          //  $node->setURL(ROOT_WWW."/admin/find3.php?decID=$code $str"  );
           // $node->setURL($stam, $str );
            //$node->getAttributes($str);

            //onclick='openmypage2("../admin/find3.php?decID=1963"); return false;'
            //$node->setURL($str) ;

            //<a href="" onclick="openmypage3(&quot;../admin/find3.php?decID=1968&quot;); return false;" class="href_modal1">הראה נתונים</a>
            //<a href="" onclick='openmypage2("../admin/find3.php?decID=1963"); return false;'   class=href_modal1

          //  <a href="" onclick="openmypage3(&quot;../admin/find3.php?decID=1968&quot;); return false;" class="href_modal1">הראה נתונים</a>


            //onclick="openmypage(&quot;find3.php?forum_decID=3&quot;); return false;" class="href_modal1"






//-----------------------------------------------------------------------------------------------

		 //has children
		 $code= $mysqli->real_escape_string($code);
		 $query2 = sprintf("select distinct decID,decName,parentDecID from tmp_dec WHERE parentDecID='%s' LIMIT 1",$code);
			$result2 = $mysqli->query($query2);
			if( !( $row2 = $result2->fetch_array(MYSQLI_ASSOC) ) ) {
				$node->setHasChildren(false);
				$node->setClosedIcon("doc.gif");

			}
			$nodes[] = $node;
		}
		$mysqli->close();



		$response = DBTreeView::createChildrenResponse($nodes);
		return $response;
	}
}







try{
	DBTreeView::processRequest(new MyHandler());
}catch(Exception $e){
	echo("Error:". $e->getMessage());
}
html_header();
echo '<form class="paginated">';
 echo'<fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">';
 ?>
<script type="text/javascript" src="ajax.lang.php"></script>
<?php

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
//$tv->setRootHTMLText("כול ההחלטות");
$tv->setRootIcon("star.gif");
$tv->printTreeViewScript();
echo'</fieldset>';
echo '</form>';
 html_footer();
?>

