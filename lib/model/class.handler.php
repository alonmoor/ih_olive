<?php
 require_once 'dbtreeview.php'; 
  
    
class MyHandler implements RequestHandler{
	
	//using 2 attribute : id=0, 1, 2, 3   root=1

	public function handleChildrenRequest(ChildrenRequest $req){
		
		global $db; 
		$attributes = $req->getAttributes();
		$class='class=href_modal1';
		if(!isset($attributes['decID'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['decID'];
	
		 
           require_once ( "../lib/formfunctions.php");
           require_once( '../lib/mydb4.php');
           $db = new MyDb4(); // Running on Windows or Linux/Unix?
           $db->execute_query("SET NAMES 'utf8'");
		
  
		 $parentCode= $db->escape($parentCode);
		 
		
		//if display_tree ($rows,$formdata);
		//$query = sprintf("select distinct decID,decName,parentDecID from tmp_dec WHERE parentDecID='%s'",$parentCode); 
		$query = sprintf("select distinct decID,decName,parentDecID from tmp_dec1 WHERE parentDecID='%s'",$parentCode); 
	 
					
					
		$rows=$db->queryObjectArray($query);			
        if(!rows)
         return;
		$nodes=array();
        foreach($rows as $row){
			$code = $row->decID; 
		 	 $text = $row-> decName; 
		 	$text ="<b style='cursor:pointer;'> $text</b>";
		 	if($attributes['flag_print'])
		    $node = DBTreeView::createTreeNode($text, array("decID"=>$code,"flag_print"=>"1"));
		    else
		    $node = DBTreeView::createTreeNode($text, array("decID"=>$code) );

		    
	    if($attributes['flag_print'] && $attributes['flag_print']==1){
            
	    	 
	    	//$node->setURL(sprintf(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=%s", $code));
	       //  $node->setURL(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=$code","_blank");
	       
	    	  
         //  $node->setURL(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=$code",$class);
	      $node->setURL(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=$code", ''  );
          }else{
	      $node->setURL(sprintf(ROOT_WWW."/admin/dynamic_5b.php?mode=read_data&editID=%s", $code));
	     //  $node->setURL(ROOT_WWW."/admin/find3.php?mode=search_dec&decID=$code",$class);
	      
	     }
	     
	     
		//has children
 	    $code= $db->escape($code);
 	    //if display_tree ($rows,$formdata);
 	    //$query2 = sprintf("select distinct decID,decName,parentDecID from tmp_dec WHERE parentdecID='%s' LIMIT 1", $code);
        $query2 = sprintf("select distinct decID,decName,parentDecID from tmp_dec1 WHERE parentdecID='%s' LIMIT 1", $code);
				 
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