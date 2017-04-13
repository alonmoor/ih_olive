<?php 
 
require_once ("../config/application3.php"); 

//define("TREEVIEW_LIB_PATH","treeview1/dbtreeview-distrib-1.0/lib/dbtreeview");
//require_once(TREEVIEW_LIB_PATH . '/dbtreeview.php');
//require_once("treeview1/dbtreeview-distrib-1.0/credentials.php"); 
 
  

class MyHandler implements RequestHandler{
	
	//using 2 attribute : id=0, 1, 2, 3   root=1

	public function handleChildrenRequest(ChildrenRequest $req){
		
		$attributes = $req->getAttributes();
		
		if(!isset($attributes['catID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['catID'];
	
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    		   or die("Unable to connect to database.");
		mysql_select_db(DB_DATABASE) or die("Could not select database");

		if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}
		

		 $query = sprintf("SELECT * FROM categories_subject WHERE parentCatID='%s' ORDER BY catName", 
		 					mysql_escape_string($parentCode));
					
					
		$result = mysql_query($query) or die("Query failed");

		$nodes=array();
		

		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["catID"];
			//$text = "<b>$code</b> : ".$line["catName"];
			$text ="<b> $line[catName]</b>" ;
			 
			
		 $node = DBTreeView::createTreeNode(
				$text, array("catID"=>$code));
				//$text, array($code=>'catName'));
	    // $node->setURL(sprintf("javascript:alert(\"צפה בהחלטה %s\");", $code));
	      $node->setURL(sprintf(ROOT_WWW."/admin/subject.php?type=$code&catID=%s", $code));
		
		//has children
          $query2 = sprintf("SELECT * FROM categories_subject WHERE parentCatID='%s'  LIMIT 1", 
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
 echo '<form class="paginated">';
 echo'<fieldset   style="margin-left:80px;background: #94C5EB url(../images/background-grad.png) repeat-x">'; 
 ?>
<script type="text/javascript" src="ajax.lang.php"></script> 
<?php  
  if ($_SESSION["auth_level"]=='admin')  
 	    echo " היתחברת כ- מנהל אם שם משתמש " .$_SESSION["auth_username"];   
	  
 	  elseif($_SESSION["auth_level"]=='user') 	 
      echo "היתחברת כ- משתמש רגיל אם שם משתמש"   .$_SESSION["auth_username"];  
  
	  elseif(($_SESSION["auth_level"])=='suppervizer')  
      echo " היתחברת כ- מפקח אם שם משתמש" .$_SESSION["auth_username"];  
 	 
	
     elseif(($_SESSION["auth_level"])=='user_admin')  
      echo "היתחברת כ-מנהל+משתמש אם שם משתמש" .$_SESSION["auth_username"];
      else
 		echo "User: Not logged in<br>";  

//head
//print("<html>\n<head>\n");
//printf("<script src=\"%s/treeview.js\" type=\"text/javascript\"></script>\n",
//			TREEVIEW_LIB_PATH);
//print('<link href="screen.css" rel="stylesheet" type="text/css" media="screen"/>');
//printf('<link href="%s/treeview.css" rel="stylesheet" type="text/css" media="screen"/>'."\n",
//			TREEVIEW_LIB_PATH);
//print("</head>\n");
 
$rootAttributes = array("catID"=>"11");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		TREEVIEW_LIB_PATH, 
		$treeID);
$str="<b>כול הנושאים</b>"	;
$tv->setRootHTMLText($str);
$tv->setRootIcon(TAMPLATE_IMAGES_DIR ."/star.gif");
$tv->printTreeViewScript();
echo'</fieldset>'; 	
echo '</form>'; 
html_footer();
 
?>
 