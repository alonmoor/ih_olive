<?php 
 
require_once ("../config/application8.php"); 

//define("TREEVIEW_LIB_PATH","treeview1/dbtreeview-distrib-1.0/lib/dbtreeview");
//require_once(TREEVIEW_LIB_PATH . '/dbtreeview.php');
 //global $db;





 



class MyHandler  implements RequestHandler{
	
	//using 2 attribute : id=0, 1, 2, 3   root=1
     
	public function handleChildrenRequest(ChildrenRequest $req){
		  
		
		global $db; 

		  
		  $attributes = $req->getAttributes();
		
		if(!isset($attributes['decID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['decID'];
	    
		
 
       
		
      
		 $parentCode= $db->escape($parentCode);
		$query = sprintf("SELECT * FROM decisions WHERE parentDecID='%s'",$parentCode);
		//$query = sprintf("select distinct decID,decname,parentDecID from test1 WHERE parentDecID='%s'",$parentCode); 
			
					
		$rows=$db->queryObjectArray($query);			
        if(!rows)
         return;
		$nodes=array();
        foreach($rows as $row){
			$code = $row->decID; 
		 	$text = $row->decName; 
		    $node = DBTreeView::createTreeNode($text, array("decID"=>$code));
 
	        $node->setURL(sprintf("javascript:alert(\"Open page for NACECODE %s\");", $code));
		
		//has children
	 
		$code= $db->escape($code);
		//$query2 = sprintf("select distinct decID,decname,parentDecID from test1 WHERE parentDecID='%s' LIMIT 1",$code);
		 $query2 = sprintf("select distinct decID,decName,parentDecID from tmp_dec WHERE parentDecID='%s' LIMIT 1",$code);
		 	if( !($row2=$db->queryObjectArray($query2) ) ) {	
	        
		  	$node->setHasChildren(false);
			$node->setClosedIcon("doc.gif");
				
		}
 		$nodes[] = $node;
		}
          
	    $db-> close();
		
		$response = DBTreeView::createChildrenResponse($nodes);
		return $response;
	}
}  

try{
	DBTreeView::processRequest(new MyHandler());
}catch(Exception $e){
	echo("Error:". $e->getMessage());
}
//html_header();

$rootAttributes = array("decID"=>"11");
$treeID = "treev1";
$tv = DBTreeView::createTreeView($rootAttributes,TREEVIEW_LIB_PATH, $treeID);
$tv->setRootHTMLText("כול ההחלטות");
$tv->setRootIcon("star.gif");
$tv->printTreeViewScript();
 html_footer();
?>
 