
<?php


require_once '../config/application.php';

 if(!isAjax()) 
html_header(); 

 

global $db;

//(productCode, productName, productLine, productScale, productVendor, productDescription, quantityInStock, buyPrice, MSRP)
$getTask_sql="SELECT t.* ,d.decName ,u.full_name,rt.dest_userID FROM todolist t       
                       left JOIN decisions  d 
                          ON d.decID=t.decID                         
     
                      left JOIN rel_user_task  rt 
                         ON rt.taskID=t.taskID            
   
                        left JOIN users u 
                        ON u.userID=rt.userID 

                       
 

                      where t.compl in(0,1)            
                      AND t.decID= 1                       
                    ORDER BY u.full_name DESC	
        
";
                        
$getTask		= $db->queryObjectArray($getTask_sql);
$iCnt=count($getTask);
 renderList5($iCnt, $getTask);
// run the query and store the results in the $result variable.
//$mysqli=$db->getMysqli();
//$result = $mysqli->query($getTask_sql) or die(mysqli_error($mysqli));
//
//if ($result) {
//  
//  // create a new form and then put the results
//  // indto a table.
//  echo "<form method='post' action='delete.php'>"; 
//  echo "<table border=1 width='600' cellspacing='0' cellpadding='5'>
//  	 
//  		<th width='15%'>taskName</th>
//  		<th width='15%'>decName</th>
//  		<th width='55%'>full_name</th>
//		    <th width='15%'>Delete</th>
//		";
//	
//	
//  while ($row = $result->fetch_object()) {
//	
//		$title = $row-> title ;
//		$decName = $row-> decName ;
//		$forum_decName = $row-> full_name;
//		$id = $row->taskID;
//
//		//put each record into a new table row with a checkbox
//	echo "<tr>
//			 
//			<td></td>
//			<td>$title</td>
//			<td>$decName </td>
//			<td>$full_name </td>
//			<td><input type='checkbox' name='checkbox[]' id='checkbox[]'  value=$id />
//		 </tr>"; 
//	
//    }
//	
//	// when the loop is complete, close off the list.
//	echo "</table><p><input id='delete' type='submit' class='button' name='delete' value='Delete Selected Items'/></p></form>";
//}
//


 

?>
