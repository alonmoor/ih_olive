<?php

require_once '../config/application.php';
global $db;
 
 
if(isset($_POST['category1']) && $_POST['category1'] != ''){
/****************/
$safeCat = (int)$_POST['category1'];


 $results = array();
$sql=  "select distinct(f.forum_decID),f.forum_decName,f.forum_date,f.managerID,f.appointID, 
	     c.catID as 'cat_forumID',c.catName as 'cat_forumName',c.parentCatID as 'parent_Cat_forumID' 
               FROM forum_dec f
              left join rel_cat_forum rc on f.forum_decID=rc.forum_decID
             left join categories1 c on c.catID = rc.catID
               WHERE c.catID = '$safeCat'" ;
               $rows = $db->queryObjectArray($sql);

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->forum_decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('forum_decName'=>$row->forum_decName,'forum_decID'=>$row->forum_decID);
       }
    echo json_encode($results);
    exit();
   }
/******************************************************************************************/ 
}elseif(isset($_POST['category1_dest']) && $_POST['category1_dest'] != ''){
/****************/
$safeCat = (int)$_POST['category1_dest'];


 $results = array();
$sql=  "select distinct(f.forum_decID),f.forum_decName,f.forum_date,f.managerID,f.appointID, 
	     c.catID as 'cat_forumID',c.catName as 'cat_forumName',c.parentCatID as 'parent_Cat_forumID' 
               FROM forum_dec f
              left join rel_cat_forum rc on f.forum_decID=rc.forum_decID
             left join categories1 c on c.catID = rc.catID
               WHERE c.catID = '$safeCat'" ;
               $rows = $db->queryObjectArray($sql);

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->forum_decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('forum_decName'=>$row->forum_decName,'forum_decID'=>$row->forum_decID);
       }
    echo json_encode($results);
    exit();
   }
/******************************************************************************************/ 
}elseif(isset($_POST['category_dec']) && $_POST['category_dec'] != ''){

$safeCat = (int)$_POST['category_dec'];


 $results = array();
$sql= "select d.*, c.* 
             FROM decisions d
             left join rel_cat_dec rc on d.decID=rc.decID
             left join categories c on c.catID = rc.catID
             WHERE c.catID = '$safeCat'";
               $rows = $db->queryObjectArray($sql);

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('decName'=>$row->decName,'decID'=>$row->decID);
       }
    echo json_encode($results);
    exit();
   }
/********************************************category_dec2*********************************************************/ 
}elseif(isset($_POST['category_dec_dest']) && $_POST['category_dec_dest'] != ''){

$safeCat = (int)$_POST['category_dec_dest'];


 $results = array();
$sql= "select d.*, c.* 
             FROM decisions d
             left join rel_cat_dec rc on d.decID=rc.decID
             left join categories c on c.catID = rc.catID
             WHERE c.catID = '$safeCat'";
               $rows = $db->queryObjectArray($sql);

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('decName'=>$row->decName,'decID'=>$row->decID);
       }
    echo json_encode($results);
    exit();
   }
/**************************************category_mgr1***************************************************************/ 
}elseif(isset($_POST['category_mgr']) && $_POST['category_mgr'] != ''){

$safeCat = (int)$_POST['category_mgr'];


 $results = array();
$sql= "SELECT  DISTINCT(m.managerID), m.*, mt.* 
             FROM managers m
             
             LEFT JOIN forum_dec f ON f.managerID=m.managerID
                         
             
             LEFT JOIN rel_managerType_forum rm ON f.forum_decID=rm.forum_decID
           
                      
           LEFT JOIN manager_type mt ON mt.managerTypeID=rm.managerTypeID
             
             WHERE mt.managerTypeID = '$safeCat'";
               $rows = $db->queryObjectArray($sql);

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו החלטות בקטגוריה '.$safeCat.'</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->managerName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('managerName'=>$row->managerName,'managerID'=>$row->managerID);
       }
    echo json_encode($results);
    exit();
   }
/******************************************category_mgr2***********************************************************/ 
}elseif(isset($_POST['category_mgr_dest']) && $_POST['category_mgr_dest'] != ''){

$safeCat = (int)$_POST['category_mgr_dest'];


 $results = array();
$sql= "SELECT  DISTINCT(m.managerID),m.*, mt.* 
             FROM managers m
             
             LEFT JOIN forum_dec f ON f.managerID=m.managerID
                         
             
             LEFT JOIN rel_managerType_forum rm ON f.forum_decID=rm.forum_decID
           
                      
           LEFT JOIN manager_type mt ON mt.managerTypeID=rm.managerTypeID
             
             WHERE mt.managerTypeID = '$safeCat'";
               $rows = $db->queryObjectArray($sql);

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו החלטות בקטגוריה '.$safeCat.'</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->managerName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('managerName'=>$row->managerName,'managerID'=>$row->managerID);
       }
    echo json_encode($results);
    exit();
   }
/***********************************VOTE_PRECENT1******************************************************************/ 
}elseif(isset($_POST['growth_dest']) && $_POST['growth_dest'] != ''){
 
 
$safeCat_dest = (int)$_POST['growth_dest'];
 
if(isset($_POST['growth']) && $_POST['growth'] != ''){
$safeCat = (int)$_POST['growth'];		
}else{
	$safeCat = (int)5;
}

$sql= "select d.* 
             FROM decisions d
             
             WHERE d.vote_level between   $safeCat   and  $safeCat_dest  ";
          $rows = $db->queryObjectArray($sql);
            

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('decName'=>$row->decName,'decID'=>$row->decID);
       }
    echo json_encode($results);
    exit();
   }
/***********************************VOTE_PRECENT2******************************************************************/ 
}elseif(isset($_POST['growth_precent_dest']) && $_POST['growth_precent_dest'] != ''){
 
 
$safeCat_dest = (int)$_POST['growth_precent_dest'];
 
if(isset($_POST['growth_precent']) && $_POST['growth_precent'] != ''){
$safeCat = (int)$_POST['growth_precent'];		
}else{
	$safeCat = (int)5;
}

$sql= "select d.* 
             FROM decisions d
             
             WHERE d.vote_level between   $safeCat   and  $safeCat_dest  ";
          $rows = $db->queryObjectArray($sql);
            

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('decName'=>$row->decName,'decID'=>$row->decID);
       }
    echo json_encode($results);
    exit();
   }   
/***************************************LEVEL1************************************************************/   
}elseif(isset($_POST['growth_level']) && $_POST['growth_level'] != ''){
 
 
$safeCat_level = (int)$_POST['growth_level'];
 

$sql= "select d.* 
             FROM decisions d
             
             WHERE d.dec_level= $safeCat_level  ";
          $rows = $db->queryObjectArray($sql);
            

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו החלטות בקטגוריה '.$safeCat_level.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('decName'=>$row->decName,'decID'=>$row->decID);
       }
    echo json_encode($results);
    exit();
   }
   
/************************************LEVEL2*****************************************************************/   
}elseif(isset($_POST['growth_level_dest']) && $_POST['growth_level_dest'] != ''){
 
 
$safeCat_level = (int)$_POST['growth_level_dest'];
 

$sql= "select d.* 
             FROM decisions d
             
             WHERE d.dec_level= $safeCat_level  ";
          $rows = $db->queryObjectArray($sql);
            

if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו החלטות בקטגוריה '.$safeCat_level.'%</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('decName'=>$row->decName,'decID'=>$row->decID);
       }
    echo json_encode($results);
    exit();
   }
   
/*******************************************FORUM_USER1**********************************************************/   
}elseif(isset($_POST['growth_frm_usr_dest']) && $_POST['growth_frm_usr_dest'] != ''){
 
 
$safeCat_frm_usr_dest = (int)$_POST['growth_frm_usr_dest'];
 
if(isset($_POST['growth_frm_usr']) && $_POST['growth_frm_usr'] != ''){
$safeCat_frm_usr = (int)$_POST['growth_frm_usr'];		
}else{
	$safeCat_frm_usr = (int)1;
}

$sql= "SELECT f.forum_decName,f.forum_decID , COUNT(u.full_name) AS nrOfusers
FROM forum_dec f 
LEFT JOIN rel_user_forum r ON r.forum_decID = f.forum_decID
LEFT JOIN users u ON r.userID = u.userID
GROUP BY forum_decName
HAVING nrOfusers between  $safeCat_frm_usr   and  $safeCat_frm_usr_dest 
ORDER BY nrOfusers DESC";
            
$rows = $db->queryObjectArray($sql);
if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat_frm_usr.'</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->forum_decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('forum_decName'=>$row->forum_decName,'forum_decID'=>$row->forum_decID,'total'=>$row->nrOfusers);
       }
    echo json_encode($results);
    exit();
   }
/*****************************************FORUM_USER2**********************************************************/   
}elseif(isset($_POST['growth_frm_usr_dest_num']) && $_POST['growth_frm_usr_dest_num'] != ''){
 
 
$safeCat_frm_usr_dest = (int)$_POST['growth_frm_usr_dest_num'];
 
if(isset($_POST['growth_frm_usr_src']) && $_POST['growth_frm_usr_src'] != ''){
$safeCat_frm_usr_src = (int)$_POST['growth_frm_usr_src'];		
}else{
	$safeCat_frm_usr_src = (int)1;
}

$sql= "SELECT f.forum_decName,f.forum_decID , COUNT(u.full_name) AS nrOfusers
FROM forum_dec f 
LEFT JOIN rel_user_forum r ON r.forum_decID = f.forum_decID
LEFT JOIN users u ON r.userID = u.userID
GROUP BY forum_decName
HAVING nrOfusers between  $safeCat_frm_usr_src   and  $safeCat_frm_usr_dest 
ORDER BY nrOfusers DESC";
            
$rows = $db->queryObjectArray($sql);
if(count($rows) == 0){
echo 'No information found. Please go back.';
}else 
  if(!isset($_POST['json']) || $_POST['json'] != '1') {
  echo '<h1>'.$rows.' נמצאו פורומים בקטגוריה '.$safeCat_frm_usr_src.'</h1>';

     foreach($rows as $row){
 
      echo '<p>'.$row->forum_decName.'</p>';
 
      }
  }else {
        foreach($rows as $row){
        $results[] = array('forum_decName'=>$row->forum_decName,'forum_decID'=>$row->forum_decID,'total'=>$row->nrOfusers);
       }
    echo json_encode($results);
    exit();
   }
   
}    
  
/***************************************************************************************************/

/*****************************************************************************************************/
/*****************************************************************************************************/ 

?>