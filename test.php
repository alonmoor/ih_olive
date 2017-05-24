<?php

//phpinfo();

echo "<h1>testttttttttttttttttttttttttttttttttttttttttttttttttttttttttt</h1>";


//
//function save_appoint(&$formdata) {
//
//
//    global $db;
//
//    if ($formdata['appoint_forum']=='none' && !array_item ($formdata,"new_appoint")) {
//        unset ($formdata['appoint_forum']);
//        $tmp="";
//        /************************************************************************************************************/
//
//    }elseif ( ($formdata['appoint_forum']!='none'
//            ||( array_item ($formdata,"appoint_forum") &&  is_numeric(array_item ($formdata,"appoint_forum"))   ) )
//        && !array_item ($formdata,"new_appoint")
//        && !is_numeric(array_item ($formdata,"new_appoint"))  )   {
//
//        $tmp= $formdata["appoint_forum"]  ? $formdata["appoint_forum"] :  $formdata["new_appoint"]  ;
//        $sql = "SELECT appointName,appointID FROM appoint_forum WHERE appointID = " .
//            $db->sql_string($tmp);
//        if($rows = $db->queryObjectArray($sql))
//            $appointsIDs = $rows[0]->appointID;
//
//        /*************************************************************************************************************/
//
//    }elseif ($formdata['appoint_forum']!='none' && $formdata['new_appoint']!='none'
//        && array_item ($formdata,"new_appoint")
//        && is_numeric(array_item ($formdata,"new_appoint"))
//        && array_item ($formdata,"appoint_forum")
//        && is_numeric(array_item ($formdata,"appoint_forum"))    )   {
//
//        $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["appoint_forum"]  ;
//        $usrID=$tmp;
//
//        $sql="SELECT full_name from users WHERE userID =$usrID";
//        if($rows=$db->queryObjectArray($sql))
//            $name=$rows[0]->full_name;
//        // new manager
//        if(!array_item($formdata ,'insert_appoint') && !is_numeric ($formdata ['insert_appoint']) ){
//            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
//        }else{
//            $parent=$formdata['insert_appoint'];
//            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
//        }
//        if(!$db->execute($sql))
//            return FALSE;
//        $appointsIDs = $db->insertId();
//
//        $formdata['appoint_forum']=$formdata['new_appoint'];
//        unset($formdata['new_appoint']);
//
//        /*************************************************************************************************************/
//    }elseif( ($formdata['appoint_forum']=='none'||( !array_item ($formdata,"appoint_forum") &&  !is_numeric(array_item ($formdata,"appoint_forum"))   )  )
//        && $formdata['new_appoint']!='none'
//        && array_item ($formdata,"new_appoint")
//        && is_numeric(array_item ($formdata,"new_appoint")))   {
//
//        $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["appoint_forum"]  ;
//        $usrID=$tmp;
//
//        $sql="SELECT full_name from users WHERE userID =$usrID";
//        if($rows=$db->queryObjectArray($sql))
//            $name=$rows[0]->full_name;
//        // new appoint
//        if(!array_item($formdata ,'insert_appoint') && !is_numeric ($formdata ['insert_appoint']) ){
//            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
//        }else{
//            $parent=$formdata['insert_appoint'];
//            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
//        }
//
//        if(!$db->execute($sql))
//            return FALSE;
//        $appointsIDs = $db->insertId();
//
//        $formdata['appoint_forum']=$formdata['new_appoint'];
//        unset($formdata['new_appoint']);
//    }
//    return $appointsIDs;
//}
//
//
///*******************************************************************************************************/
///*************************************************SAVE_MANAGER1*********************************************************************************/
//function save_manager1(&$formdata) {
//
//
//    global $db;
//
//    if ($formdata['dest_managers']=='none' && !array_item ($formdata,"new_manager")) {
//        unset ($formdata['dest_managers']);
//        $tmp="";
//        /************************************************************************************************************/
//
//    }elseif ( ($formdata['dest_managers']!='none' &&  $formdata['dest_managers']!=null
//            && ( array_item ($formdata,"dest_managers") &&  is_array(array_item ($formdata,"dest_managers"))   ) )
//        && !array_item ($formdata,"new_manager")
//        && !count($formdata['new_manager'])>0  )   {
//
//        $tmp= $formdata["dest_managers"]  ? $formdata["dest_managers"] :  $formdata["new_manager"]  ;
//
//        $dest_managers= $formdata['dest_managers'];
//
//        foreach ($dest_managers as $key=>$val){
//
//            if(!is_numeric($val)){
//                $val=$db->sql_string($val);
//                $staff_test[]=$val;
//
//            }elseif(is_numeric($val)){
//                $staff_testb[]=$val;
//
//            }
//
//        }
//
//        if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
//            $staff=implode(',',$staff_test);
//            $sql="select managerID, managerName from managers where managerName in ($staff)";
//            if($rows=$db->queryObjectArray($sql))
//                foreach($rows as $row){
//
//                    $name_managers[$row->managerID]=$row->managerName;
//
//
//                }
//        }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
//            $staff=implode(',',$staff_test);
//            $sql="select managerID, managerName from managers where managerName in ($staff)";
//            if($rows=$db->queryObjectArray($sql))
//                foreach($rows as $row){
//
//                    $name_managers[$row->managerID]=$row->managerName;
//                }
//
//
//            $staff_b=implode(',',$staff_testb);
//
//            $sql="select managerID, managerName from managers where managerID in ($staff_b)";
//            if($rows=$db->queryObjectArray($sql))
//                foreach($rows as $row){
//
//                    $name_managers_b[$row->managerID]=$row->managerName;
//
//
//                }
//
//            $name_managers=array_merge($name_managers,$name_managers_b);
//            unset($staff_testb);
//
//        }else{
//            $staff=implode(',',$formdata['dest_managers']);
//
//            $sql2="select managerID, managerName from managers where managerID in ($staff)";
//            if($rows=$db->queryObjectArray($sql2))
//                foreach($rows as $row){
//
//                    $name_managers[$row->managerID]=$row->managerName;
//
//
//                }
//
//        }
//// $staff=implode(',',$formdata["dest_managers"]);
////  $sql = "SELECT managerName,managerID FROM managers WHERE managerID in ($staff) " ;
//
//
//        foreach($name_managers as $key=>$val)
//            $managersIDs[] = $key;
//
//        /*************************************************************************************************************/
//
//    }elseif ($formdata['dest_managers']!='none' && $formdata['new_manager']!='none'
//        && array_item ($formdata,"new_manager")
//        && count($formdata['new_manager'])>0
//        && array_item ($formdata,"dest_managers")
//        && is_array(array_item ($formdata,"dest_managers"))    )   {
//
//        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["dest_managers"]  ;
//        // $usrID=$tmp;
//        $i=0;
//        foreach($tmp as $usrID){
//
//            $sql="SELECT full_name from users WHERE userID =$usrID";
//            if($rows=$db->queryObjectArray($sql))
//                $name=$rows[0]->full_name;
//            // new manager
//            if(!array_item($formdata ,'insert_manager') && !is_array ($formdata ['insert_managers'])
//                && !is_numeric ($formdata ['insert_manager'][0]) ){
//
//                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                    "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
//            }else{
//                $parent=$formdata['insert_manager'][$i];
//                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                    "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
//            }
//            if(!$db->execute($sql))
//                return FALSE;
//            $managersIDs[] = $db->insertId();
//
//            $formdata['dest_managers']=$formdata['new_manager'];
//            unset($formdata['new_manager']);
//
//            $i++;
//
//        }
//        /*************************************************************************************************************/
//    }elseif( ($formdata['dest_managers']=='none'
//            ||( !array_item ($formdata,"dest_managers") &&  !is_array(array_item ($formdata,"dest_managers"))   ))
//        && $formdata['new_manager']!='none'
//        && array_item ($formdata,"new_manager")
//        && count($formdata['new_manager'])>0 )   {
//
//        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["dest_managers"]  ;
//        $i=0;
//        foreach($tmp as $usrID){
//
//            $sql="SELECT full_name from users WHERE userID =$usrID";
//            if($rows=$db->queryObjectArray($sql))
//                $name=$rows[0]->full_name;
//            // new manager
//            if(!array_item($formdata ,'insert_manager') && !is_array ($formdata ['insert_manager'])
//                && !is_numeric ($formdata ['insert_manager'][0]) ){
//
//                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                    "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
//            }else{
//                $parent=$formdata['insert_manager'][$i];
//                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                    "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
//            }
//            if(!$db->execute($sql))
//                return FALSE;
//            $managersIDs[] = $db->insertId();
//
//            $formdata['dest_managers']=$formdata['new_manager'];
//            unset($formdata['new_manager']);
//
//            $i++;
//        }
//    }
//    return $managersIDs;
//}
//
///**************************************SAVE MANAGER*****************************************************************/
//
//function save_manager(&$formdata) {
//
//
//    global $db;
//
//
//    if ($formdata['manager_forum']=='none' && !array_item ($formdata,"new_manager")
//        && !is_numeric(array_item ($formdata,"new_manager"))    )   {
//        unset ($formdata['manager_forum']);
//
//        $tmp="";//$formdata["manager_forum"]  ? $formdata["manager_forum"] :  $formdata["new_manager"]  ;
//        /*************************************************************************************************************/
//
//
//    }elseif ( ($formdata['manager_forum']!='none'
//            ||( array_item ($formdata,"manager_forum") &&  is_numeric(array_item ($formdata,"manager_forum"))   ) )
//        && !array_item ($formdata,"new_manager")
//        && !is_numeric(array_item ($formdata,"new_manager"))  )   {
//
//        $tmp= $formdata["manager_forum"]  ?$formdata["manager_forum"]: $formdata["new_manager"] ;
//        $sql = "SELECT managerName,managerID FROM managers WHERE managerID = " .
//            $db->sql_string($tmp);
//        if($rows = $db->queryObjectArray($sql))
//            $managersIDs = $rows[0]->managerID;
//
//        /*************************************************************************************************************/
//    }elseif ($formdata['manager_forum']!='none' && $formdata['new_manager']!='none'
//        && array_item ($formdata,"new_manager")
//        && is_numeric(array_item ($formdata,"new_manager"))
//        && array_item ($formdata,"manager_forum")
//        && is_numeric(array_item ($formdata,"manager_forum"))    )   {
//
//        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["manager_forum"]  ;
//        $usrID=$tmp;
//
//        $sql="SELECT full_name from users WHERE userID =$usrID";
//        if($rows=$db->queryObjectArray($sql))
//            $name=$rows[0]->full_name;
//        // new manager
//        if(!array_item($formdata ,'insert_manager') && !is_numeric ($formdata ['insert_manager']) ){
//            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
//        }else{
//
//            $parent=$formdata['insert_manager'];
//
//
//            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " , $parent ,$usrID )";
//
//        }
//        if(!$db->execute($sql))
//            return FALSE;
//
//        $managersIDs = $db->insertId();
//
//        $formdata['manager_forum']=$formdata['new_manager'];
//        unset($formdata['new_manager']);
//        /*************************************************************************************************************/
//    }elseif( ($formdata['manager_forum']=='none'||( !array_item ($formdata,"manager_forum") &&  !is_numeric(array_item ($formdata,"manager_forum"))   )  )
//        && $formdata['new_manager']!='none'
//        && array_item ($formdata,"new_manager")
//        && is_numeric(array_item ($formdata,"new_manager")))   {
//
//        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["manager_forum"]  ;
//        $usrID=$tmp;
//
//        $sql="SELECT full_name from users WHERE userID =$usrID";
//        if($rows=$db->queryObjectArray($sql))
//            $name=$rows[0]->full_name;
//        // new manager
//        if(!array_item($formdata ,'insert_manager') && !is_numeric ($formdata ['insert_manager']) ){
//            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
//        }else{
//
//            $parent=$formdata['insert_manager'];
//
//
//            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .
//
//                "VALUES (" . $db->sql_string($name) .   " , $parent ,$usrID )";
//
//        }
//
//        if(!$db->execute($sql))
//            return FALSE;
//
//        $managersIDs = $db->insertId();
//
//
//        $formdata['manager_forum']=$formdata['new_manager'];
//        unset($formdata['new_manager']);
//    }
//
//    return $managersIDs;
//}
//
///***************************SAVE CATEGORY1****************************************************************************/
///*******************************************************************************************************/
//
//function save_category1(&$formdata) {
//
//
//    global $db;
//
//
//    if ($formdata['dest_forumsType']=='none' && !array_item ($formdata,"dest_forumsType") ){
//        unset ($formdata['dest_forumsType']);
//        $tmp= "";
//
//        /******************************************************************************************************/
//
//    }elseif ( ($formdata['dest_forumsType']!='none' &&  $formdata['dest_forumsType']!=null
//            && ( array_item ($formdata,"dest_forumsType") &&  is_array(array_item ($formdata,"dest_forumsType"))   ) )
//        && (!array_item ($formdata,"new_category")
//            ||  ($formdata["new_category"]=='none' )
//            ||  $formdata["new_category"]==null )  )   {
//
//
//        $tmp= $formdata["dest_forumsType"]  ? $formdata["dest_forumsType"] :  $formdata["new_category"]  ;
//
//
//        $dest_forumsType= $formdata['dest_forumsType'];
//
//        foreach ($dest_forumsType as $key=>$val){
//            if(!is_numeric($val)){
//                $val=$db->sql_string($val);
//                $staff_test[]=$val;
//            }elseif(is_numeric($val) ){
//                $staff_testb[]=$val;
//            }
//        }
//        if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
//            $staff=implode(',',$staff_test);
//
//            $sql2="select catID, catName from categories1 where catName in ($staff)";
//            if($rows=$db->queryObjectArray($sql2))
//                foreach($rows as $row){
//
//                    $name[$row->catID]=$row->catName;
//
//
//                }
//
//        }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
//            $staff=implode(',',$staff_test);
//
//            $sql2="select catID, catName from categories1 where catName in ($staff)";
//            if($rows=$db->queryObjectArray($sql2))
//                foreach($rows as $row){
//
//                    $name[$row->catID]=$row->catName;
//
//
//                }
//            $staffb=implode(',',$staff_testb);
//
//            $sql2="select catID, catName from categories1 where catID in ($staffb)";
//            if($rows=$db->queryObjectArray($sql2))
//                foreach($rows as $row){
//
//                    $name_b[$row->catID]=$row->catName;
//                }
//            $name=array_merge($name,$name_b);
//            unset($staff_testb);
//        }else{
//            $staff=implode(',',$formdata['dest_forumsType'])	;
//
//            $sql2="select catID, catName from categories1 where catID in ($staff)";
//            if($rows=$db->queryObjectArray($sql2))
//                foreach($rows as $row){
//
//                    $name[$row->catID]=$row->catName;
//                    //$name[]=$row->catName;
//
//                }
//        }
//
//
//// $staff=implode(',',$tmp);
////			  $sql = "SELECT  catName,catID,parentCatID FROM categories1 WHERE catID in ($staff)  " ;
//
//
//        foreach($name as $key=>$val)
//            $catsIDs []= $key;
//
//        /*************************************************************************************************************/
//    }elseif ($formdata['dest_forumsType']!='none'  &&  $formdata['dest_forumsType']!=null && trim($formdata['new_category']!='none')
//        && array_item ($formdata,"new_category")
//        && count($formdata['new_category'])>0
//        && array_item ($formdata,"dest_forumsType"))   {
//
//        $tmp= $formdata["new_category"]  ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
//        $catNames=explode(';',$tmp);
//
//
//
//        $i=0;
//        foreach($catNames as $catName){
//            if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category'][0]) ){
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , '11')";
//
//            }else{
//                $parent=$formdata['insert_category'][$i];
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
//            }
//
//
//            if(!$db->execute($sql))
//                return FALSE;
//            $catsIDs[] = $db->insertId();
//
//
//
//            $i++;
//        }
//        $formdata['dest_forumsType']=$catsIDs;
//        unset($formdata['new_category']);
//        /*************************************************************************************************************/
//    }elseif( ($formdata['dest_forumsType']=='none' || $formdata['dest_forumsType']==null
//            ||( !array_item ($formdata,"dest_forumsType") &&  !is_numeric(array_item ($formdata,"dest_forumsType"))   )  )
//        && $formdata['new_category']!='none'
//        && $formdata['new_category']!=null
//        && count($formdata['new_category'])>0
//        && array_item ($formdata,"new_category"))   {
//
//
//
//        $tmp= $formdata["new_category"]  ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
//        $catNames=explode(';',$tmp);
//
//
//
//        $i=0;
//        foreach($catNames as $catName){
//            if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category'][0]) ){
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , '11')";
//
//            }else{
//                $parent=$formdata['insert_category'][$i];
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
//            }
//
//
//            if(!$db->execute($sql))
//                return FALSE;
//            $catsIDs[] = $db->insertId();
//
//            $formdata['dest_forumsType']=$formdata['new_category'];
//            unset($formdata['new_category']);
//
//            $i++;
//        }
//
//        $formdata['dest_forumsType']=$catsIDs;
//        unset($formdata['new_category']);
//
//
//    }
//    return $catsIDs;
//}
//
//
///**************************************************save_category_ajx**********************************************************/
//function save_category_ajx(&$formdata) {
//
//
//    global $db;
//
//
//    if ( ($formdata['dest_forumsType']!='none'
//            ||( array_item ($formdata,"dest_forumsType") &&  is_array($formdata['dest_forumsType'] )   ) )
//        && !array_item ($formdata,"new_forumType")
//        && !is_numeric(array_item ($formdata,"new_forumType"))  )   {
//
//
//        $tmp= $formdata["dest_forumsType"]  ;
//        foreach($tmp as $key=>$val){
//
//            $catsIDs[]=$val;
//        }
//
//
//
//        if(is_array($formdata['insert_forumType']) && is_numeric($formdata['insert_forumType'][0]) && $formdata['insert_forumType']!='none' ){
//            $i=0;
//            $count_insert=count($formdata['insert_forumType']);
//            foreach($catsIDs as $id){
//                $parent=$formdata['insert_forumType'][$i];
//                $sql = "update categories1 set  parentCatID=$parent WHERE catID=$id"  ;
//
//                if(!$db->execute($sql))
//                    return FALSE;
//                $i++;
//
//                if($i==$count_insert){
//                    $i=$count_insert-1;
//                }
//            }
//
//        }
//
//
//
//
//
//        $formdata['dest_forumsType']=$catsIDs;
//        /*************************************************************************************************************/
//    }elseif (is_array($formdata['dest_forumsType'])  && trim($formdata['new_forumType']!='none')
//        && array_item ($formdata,"new_forumType")
//        && !is_numeric(array_item ($formdata,"new_forumType"))
//        && array_item ($formdata,"dest_forumsType")    )   {
//
//        $tmp= $formdata["new_forumType"] ;// ? $formdata["new_forumType"]:$formdata["dest_forumsType"]  ;
//
//
//        $catForumNames=explode(';',$tmp);
//
//
//
//        $i=0;
//        foreach($catForumNames as $catName){
//
//            if(!array_item($formdata ,'insert_forumType') && !is_numeric ($formdata ['insert_forumType']) ){
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($tmp) . " , '11')";
//
//            }else{
//                $count_insert=count($formdata['insert_forumType']);
//                $parent=$formdata['insert_forumType'][$i];
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
//            }
//            if(!$db->execute($sql))
//                return FALSE;
//            $catsIDs []= $db->insertId();
//
//            if($formdata['dest_forumsType'])
//                unset($formdata['dest_forumsType']);
//
//            $formdata['dest_forumsType'][0]=$catsIDs;
//
//            $i++;
//
//            if($count_insert && $i==$count_insert){
//                $i=$count_insert-1;
//            }
//        }
//
//
//        $formdata['dest_forumsType']=$catsIDs;
//        unset($formdata['new_forumType']);
//        /*************************************************************************************************************/
//    }elseif( ( !is_array($formdata['dest_forumsType']) || ( !array_item ($formdata,"dest_forumsType")    )  )
//        && $formdata['new_forumType']!='none'
//        && array_item ($formdata,"new_forumType")
//        && !is_numeric(array_item ($formdata,"new_forumType")))   {
//
//
//
//        $tmp= $formdata["new_forumType"] ;// ? $formdata["new_forumType"]:$formdata["dest_forumsType"]  ;
//
//
//        $catForumNames=explode(';',$tmp);
//
//
//
//        $i=0;
//        foreach($catForumNames as $catName){
//
//            if(!array_item($formdata ,'insert_forumType') && !is_numeric ($formdata ['insert_forumType']) ){
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($tmp) . " , '11')";
//
//            }else{
//                $count_insert=count($formdata['insert_forumType']);
//                $parent=$formdata['insert_forumType'][$i];
//                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
//            }
//            if(!$db->execute($sql))
//                return FALSE;
//            $catsIDs[] = $db->insertId();
//
//            if($formdata['dest_forumsType'])
//                unset($formdata['dest_forumsType']);
//
//            $formdata['dest_forumsType'][0]=$catsIDs;
//
//            $i++;
//
//            if($count_insert && $i==$count_insert){
//                $i=$count_insert-1;
//            }
//
//        }
//
//
//        $formdata['dest_forumsType']=$catsIDs;
//        unset($formdata['new_forumType']);
//
//    }
//
//
//
//
//    return $catsIDs;
//}
//
//
///***************************SAVE MANAGERTYPE_ajx****************************************************************************/
//
//
//function save_managerType_ajx(&$formdata) {
//
//
//    global $db;
//
//
//
//    if ( ($formdata['dest_managersType']!='none'
//            ||( array_item ($formdata,"dest_managersType") &&  is_array($formdata['dest_managersType'] )   ) )
//        && !array_item ($formdata,"new_managerType")
//        && !is_numeric(array_item ($formdata,"new_managerType"))  )   {
//
//
//        $tmp= $formdata["dest_managersType"]  ;
//        foreach($tmp as $key=>$val){
//
//
//            $catTypeIDs[]=$val;
//        }
//
//
//
//        if(is_array($formdata['insert_managerType']) && is_numeric($formdata['insert_managerType'][0]) &&  $formdata['insert_managerType']!='none' ){
//            $i=0;
//            $count_insertMgr=count($formdata['insert_managerType']);
//            foreach($catTypeIDs as $id){
//                $parent=$formdata['insert_managerType'][$i];
//
//                $sql = "update manager_type set  parentManagerTypeID=$parent  WHERE managerTypeID=$id"  ;
//
//                if(!$db->execute($sql))
//                    return FALSE;
//
//                $i++;
//
//                if($i==$count_insertMgr){
//                    $i=$count_insertMgr-1;
//                }
//
//            }
//
//        }
//
//
//
//        $formdata['dest_managersType']=$catTypeIDs;
//
//    }elseif ($formdata['dest_managersType']!='none' && trim($formdata['new_managerType']!='none')
//        && array_item ($formdata,"new_managerType")
//        && count($formdata['new_managerType'])>0
//        && !is_numeric($formdata["new_managerType"])
//        && array_item ($formdata,"dest_managersType") ){
//
//        $tmp= $formdata["new_managerType"]  ? $formdata["new_managerType"]:$formdata["dest_managersType"]  ;
//        $catNames=explode(';',$tmp);
//
//
//
//        $i=0;
//        foreach($catNames as $catName){
//            if(!array_item($formdata ,'insert_managerType') && !is_numeric ($formdata ['insert_managerType'][0]) ){
//                $sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , '11')";
//
//            }else{
//                $count_insertMgr=count($formdata['insert_managerType']);
//                $parent=$formdata['insert_managerType'][$i];
//                $sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
//            }
//
//
//
//
//            if(!$db->execute($sql))
//                return FALSE;
//            $catTypeIDs[] = $db->insertId();
//
//
//            $i++;
//
//            if($count_insertMgr &&  $i==$count_insertMgr){
//                $i=$count_insertMgr-1;
//            }
//
//        }
//
//
//        $formdata['dest_managersType']=$catTypeIDs;
//        unset($formdata['new_managerType']);
//        /*************************************************************************************************************/
//    }elseif( ($formdata['dest_managersType']=='none'||( !array_item ($formdata,"dest_managersType") &&  !is_numeric(array_item ($formdata,"dest_managersType"))   )  )
//        && $formdata['new_managerType']!='none'
//        && count($formdata['new_managerType'])>0
//        && array_item ($formdata,"new_managerType"))   {
//
//
//
//        $tmp= $formdata["new_managerType"]  ? $formdata["new_managerType"]:$formdata["dest_managersType"]  ;
//        $catNames=explode(';',$tmp);
//
//
//
//        $i=0;
//        foreach($catNames as $catName){
//            if(!array_item($formdata ,'insert_managerType') && !is_numeric ($formdata ['insert_managerType'][0]) ){
//                $sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , '11')";
//
//            }else{
//                $count_insertMgr=count($formdata['insert_managerType']);
//                $parent=$formdata['insert_managerType'][$i];
//                $sql = "INSERT INTO manager_type (managerTypeName,parentManagerTypeID) " .
//                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
//            }
//
//
//            if(!$db->execute($sql))
//                return FALSE;
//            $catTypeIDs[] = $db->insertId();
//
//
//            $i++;
//
//            if($count_insertMgr &&  $i==$count_insertMgr){
//                $i=$count_insertMgr-1;
//            }
//
//        }
//
//        $formdata['dest_managersType']=$catTypeIDs;
//        unset($formdata['new_managerType']);
//
//
//    }
//    return $catTypeIDs;
//}
//
//
//
///************************************************************************************************************/
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//case "update":
//if($_GET['updateID']) {
//update_forum1($_GET['updateID']);
//
//}else{
////------------------------------------------------------------------------------------
//if($_POST['form']){
//foreach($_POST['form']  as $key=>$val){
//if ($val=='none' || $val== "" )
//unset ($_POST['form'][$key]);
//
//}
//
//}
////------------------------------------------------------------------------------------
//global $db;
//$brandID= $_POST['form']['brand_pdf']?$_POST['form']['brand_pdf']:$_POST['form'] ;
//
//
//if(isset($_POST['form']['dest_publisher'][0]) &&  $_POST['form']['dest_publisher'][0]== 'none')
//unset($_POST['form']['dest_publisher'][0] );
//
//if(isset($_POST['form']['dest_publisher']) &&  count($_POST['form']['dest_publisher'])==0  )
//unset($_POST['form']['dest_publisher'] );
//
//if(isset($_POST['form']['dest_publisher'][0]) &&  $_POST['form']['dest_publisher'][0]== 'none')
//unset($_POST['form']['dest_publisher'][0] );
//
//if(isset($_POST['form']['dest_publisher']) &&  count($_POST['form']['dest_publisher'])==0  )
//unset($_POST['form']['dest_publisher'] );
//
//
//if(isset($_POST['dest_publisher'][0]) && $_POST['dest_publisher'][0]== 'none')
//unset($_POST['dest_publisher'][0] );
//
//if(isset($_POST['dest_publisher']) &&  count($_POST['dest_publisher'])==0  )
//unset($_POST['dest_publisher'] );
////-----------------------------------------------------------------------
//global $db;
//if(isset($_POST['form']['dest_dfps']) && $_POST['form']['dest_dfps'][0]== 'none')
//unset($_POST['form']['dest_dfps'][0] );
//
//if(!empty($_POST['form']['dest_dfps']) && count($_POST['form']['dest_dfps'])== 0  )
//unset($_POST['form']['dest_dfps'] );
//
//if(!empty($_POST['form']['src_dfps'][0]) &&  $_POST['form']['src_dfps'][0]== 'none')
//unset($_POST['form']['src_dfps'][0] );
//
//if(!empty($_POST['form']['src_dfps']) && count($_POST['form']['src_dfps'])==0  )
//unset($_POST['form']['src_dfps'] );
//
//if(!empty($_POST['arr_dest_dfps'][0]) && $_POST['arr_dest_dfps'][0]== 'none')
//unset($_POST['arr_dest_dfps'][0] );
//
//if(!empty($_POST['arr_dest_dfps']) && count($_POST['arr_dest_dfps'])==0  )
//unset($_POST['arr_dest_dfps'] );
///*********************************************************************************/
//if(isset($_POST['form']['dest_dfps']) && !$_POST['form']['dest_dfps'] && $_POST['arr_dest_dfps']){
//$formdata= isset($_POST['form']) ? $_POST['form'] : '';
//$formdata['dest_dfps']= isset($_POST['arr_dest_dfps']) ? $_POST['arr_dest_dfps'] : '';
//}elseif(isset($_POST['form']['dest_dfps']) &&  isset($_POST['form']['dest_dfps'][0]) && $_POST['form']['dest_dfps'] && is_numeric($_POST['form']['dest_dfps'][0])){
//
//$formdata=$_POST['form'];
///**********************************************************************************/
//}elseif(isset($_POST['form']['dest_dfps']) && !is_numeric($_POST['form']['dest_dfps'][0]
//&& ($_POST['form']['dest_dfps'][0]=='none'))
//&& ($_POST['form']['dest_dfps'])
//&&  ($_POST['form']['dest_dfps'][1])) {
//
//
//$dest_dfps = isset($_POST['form']['dest_dfps']) ? $_POST['form']['dest_dfps'] : '';
//$i = 0;
//foreach ($dest_dfps as $key => $val) {
//if (is_numeric($val)) {
//$array_num[] = $val;
//} elseif (!is_numeric($val) && $val == 'none') {
//unset($dest_dfps[$i]);
//} else
//$vals[$key] = "'$val'";
//$i++;
//}
//}
//$formdata = isset($_POST['form']) ? $_POST['form'] : false;
//if (array_item($_POST, 'arr_dest_pdfs'))
//$formdata['dest_pdfs'] = isset($_POST['arr_dest_pdfs']) ? $_POST['arr_dest_pdfs'] : '';
//
//
//if(array_item ($_POST,'arr_dest_publishers') )
//$formdata['dest_publishers'] = isset($_POST['arr_dest_publishers']) ? $_POST['arr_dest_publishers'] : '';
//
//list($year_date,$month_date, $day_date) = explode('-',$formdata['brand_date']);
//if(strlen($year_date)>3 ){
//$formdata['brand_date']="$day_date-$month_date-$year_date";
//}
//}
//$db->execute("START TRANSACTION");
//
//
//if(!$formdata=update_forum($formdata)){
//
//
//$db->execute("ROLLBACK");
//$formdata=$_POST['form'];
///**********************************************************************************************************/
//if($formdata['src_managersType'] &&  is_array($formdata['src_managersType']) && (is_numeric ($formdata['src_managersType'][0])) ){
//unset($formdata['src_managersType']);
//}
//
//if($formdata['src_brandsType'] &&  is_array($formdata['src_brandsType']) && (is_numeric($formdata['src_brandsType'][0])) ){
//unset($formdata['src_brandsType']);
//}
//
//if($formdata['src_dfps'] &&  is_array($formdata['src_dfps']) && (is_numeric($formdata['src_dfps'][0])) ){
//unset($formdata['src_dfps']);
//}
///**********************************************************************************************************/
//
//
//$formdata['brand_pdf']=$_POST['form']['brand_pdf'];
//$formdata['category']=$_POST['form']['category'];
//$formdata['appoint_forum']=$_POST['form']['appoint_forum'];
//$formdata['manager_forum']=$_POST['form']['manager_forum'];
//$formdata['managerType']=$_POST['form']['managerType'];
////$formdata['appoint_date1']=$_POST['form']['appoint_date1'];
////$formdata['manager_date']=$_POST['form']['manager_date'];
//
//
//
//if($_POST['form']['appoint_date1'] ){
//$formdata['appoint_date1']= $_POST['form']['appoint_date1']  ;
//list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['appoint_date1']);
//if(strlen($year_date)>3 ){
//$formdata['appoint_date1']="$day_date-$month_date-$year_date";
//}
//}
//
//if($_POST['form']['manager_date']){
//$formdata['manager_date']= $_POST['form']['manager_date'] ;
//list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['manager_date']);
//if(strlen($year_date)>3){
//$formdata['manager_date']="$day_date-$month_date-$year_date";
//}
//}
//
//
//if($_POST['form']['forum_date']){
//$formdata['forum_date']=$_POST['form']['forum_date'];
//list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
//if(strlen($year_date)>3 ){
//$formdata['forum_date']="$day_date-$month_date-$year_date";
//}
//}
//
//
//
//if($_POST['arr_dest_brands']){
//$formdata['dest_brands']=$_POST['arr_dest_brandsType'];
//}
//
//if($_POST['arr_dest_managersType']){
//$formdata['dest_managersType']=$_POST['arr_dest_managersType'];
//}
//
//
//
////				$formdata['forum_date']=substr($_POST['form']['forum_date'],1,10);
////				list($year_date,$month_date, $day_date) = explode('-',$_POST['form']['forum_date']);
////				if(strlen($year_date>3) )
////				$formdata['forum_date']="$day_date-$month_date-$year_date";
//
//
//
//if($formdata['dest_dfps']){
//$i=0;
//foreach($formdata['dest_dfps'] as $row){
//$member_date="member_date$i";
//$rows['full_date'][$i] =$formdata[$member_date];
//
//$i++;
//}
//
//
//
//$i=0;
//foreach($rows['full_date'] as $row){
//
//$member_date="member_date$i";
//list($year_date,$month_date, $day_date) = explode('-',$row);
//if(strlen($year_date)>3 ){
//$formdata[$member_date]="$day_date-$month_date-$year_date";
//}
//
//$i++;
//}
//
//$formdata['fail']=true;
//}
//
//
//if(!$_POST['form']['dest_dfps'] && $_POST['arr_dest_dfps']){
//$formdata['dest_dfps']=$_POST['arr_dest_dfps'];
//}
//
//if($formdata['src_dfps'] && $_POST['arr_dest_dfps'] ){
//
//$i=0;
//foreach ($_POST['arr_dest_dfps'] as $dst){
//if($dst=='none')
//unset ($_POST['arr_dest_dfps'][$i]);
//$i++;
//
//}
//
//$arr=implode(',',$_POST['arr_dest_dfps'] );
//
//$sql="select userID,full_name from users where userID in($arr)";
//$rows=$db->queryObjectArray($sql);
//foreach ($rows as $row){
//$dest[$row->userID]=$row->full_name;
//}
//
//$formdata['dest_dfps']=$dest;//$_POST['arr_dest_dfps'];
//
//
//}elseif($formdata['dest_dfps']){// && $formdata['dest_dfps'][0]!='none' && is_numeric($formdata['dest_dfps'][0]) ){
//
//
//
//$dest_dfps = $dest_dfps ? $dest_dfps:$formdata['dest_dfps'];
//$i=0;
//foreach ($dest_dfps as $dst){
//if($dst=='none')
//unset ($dest_dfps[$i]);
//$i++;
//
//}
//
//
//$arr=implode(',',$dest_dfps  );
//
//$sql="select userID,full_name from users where userID in($arr)";
//$rows=$db->queryObjectArray($sql);
//foreach ($rows as $row){
//$dest[$row->userID]=$row->full_name;
//}
//$formdata['dest_dfps']=$dest;
//
//}
//if($formdata['brand_pdf']&& $formdata['newbrand '])
//unset( $formdata['brand_pdf']);
//
////if(!$formdata['fail'])
//$formdata['fail']=true;
//$formdata['dynamic_10']=1;
//show_list($formdata);
//
//
//return;
//
//}else{
//
///*************************************TO_AJAX**********************************************/
//
///**********************************GET_DECISION************************************************/
//$brandID=$formdata['brandID'];
//$sql="SELECT d.decID,d.decName
//FROM decisions d
//left join rel_brand rf on d.decID=rf.decID
//WHERE rf.brandID=$brandID";
//// left join brand f on f.brandID
//
//
//if($rows  = $db->queryObjectArray($sql) ){
//
//$formdata["decision"]=$rows;
//}
///******************************************************************************************/
//$i=0;
//if($formdata['dest_dfps'] && is_array($formdata['dest_dfps']) && is_array($dest_dfps)){
//
//foreach($dest_dfps as $key=>$val){
//if(is_numeric($val)){
//$sql="select userID,full_name  from users where userID=$val";
//if($rows=$db->queryObjectArray($sql)){
//
//$results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
//
//
//$i++;
//
//}
//}
//
//
//}
//
//
//
//$formdata["dest_user"]=$results;
//
//
///********************************************************************************************************/
//$i=0;
//foreach($formdata['dest_dfps'] as $key=>$val){
//$sql="select active  from rel_user_forum where userID=$key and brandID=$brandID ";
//if($rows=$db->queryObjectArray($sql)){
//
//$formdata['active'][$key]=$rows[0]->active;
//$i++;
//}
//}
//
///**********************************************************************************************************************/
//
//
//
//}elseif($formdata['dest_dfps'] && is_array($formdata['dest_dfps'])   ){
//
//foreach($formdata['dest_dfps'] as $key=>$val){
//if(is_numeric($key)){
//$sql="select userID,full_name  from users where userID=$key";
//if($rows=$db->queryObjectArray($sql)){
//
//$results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
//
//
//$i++;
//
//}
//}
//
//
//}
//
//$formdata["dest_user"]=$results;
///********************************************************************************************************/
//$i=0;
//foreach($formdata['dest_dfps'] as $key=>$val){
//$sql="select active  from rel_user_forum where userID=$key and brandID=$brandID ";
//if($rows=$db->queryObjectArray($sql)){
//
//$formdata['active'][$key]=$rows[0]->active;
//$i++;
//}
//}
//
///**********************************************************************************************************/
//
//
//}
//
///**********************************************************************************************************************/
////for check the length
//$i=0;
//if($formdata['src_dfpsID'] && is_array($formdata['src_dfpsID'])   ){
//
//foreach($formdata['src_dfpsID'] as $key=>$val){
//
//$sql="select userID,full_name  from users where userID=$val";
//if($rows=$db->queryObjectArray($sql)){
//
//$results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);
//
//
//$i++;
//
//}
//
//
//}
//$formdata["src_user"]=$results1;
//}else{
//$formdata["src_user"]=$formdata["dest_user"];
//}
///***********************************************************************/
///***********************brandsTYPE**********************************************/
//$i=0;
//if($formdata['dest_brandsType'] && is_array($formdata['dest_brandsType'])  ){
//
//foreach($formdata['dest_brandsType'] as $key=>$val){
//if(is_numeric($val)){
//$sql="select catID,catName  from categories1 where catID=$val";
//if($rows=$db->queryObjectArray($sql)){
//
//$results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);
//
//
//$i++;
//
//}
//}
//
//
//}
//$formdata['dest_brandsType']=$results_cat_frm;
//}
///*************************************MANAGER_TYPE*****************************************************************/
//
//$i=0;
//if($formdata['dest_managersType'] && is_array($formdata['dest_managersType'])  ){
//
//foreach($formdata['dest_managersType'] as $key=>$val){
//if(is_numeric($val)){
//$sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
//if($rows=$db->queryObjectArray($sql)){
//
//$results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);
//
//
//$i++;
//
//}
//}
//
//
//}
//$formdata['dest_managersType']=$results_cat_mgr;
//}
///******************************************************************************************************/
//
//
//$manageID=$formdata['manager_forum'];
//$sql="select managerName from managers where managerID=$manageID";
//if($rows=$db->queryObjectArray($sql)){
//$formdata['managerName']=$rows[0]->managerName;
//}
///**********************************************************************/
//$appID=$formdata['appoint_forum'];
//$sql="select appointName from appoint_forum where appointID=$appID";
//if($rows=$db->queryObjectArray($sql)){
//$formdata['appointName']=$rows[0]->appointName;
//}
///**********************************************************************/
//unset($_POST['form']['multi_year']);
//unset($_POST['form']['multi_month']);
//unset($_POST['form']['multi_day']);
//unset($formdata['multi_year']);
//unset($formdata['multi_month']);
//unset($formdata['multi_day']);
//$formdata['multi_year'][0]='none';
//$formdata['multi_month'][0]='none';
//$formdata['multi_day'][0]='none';
//
///******************************************************/
//$sql = "SELECT catName, catID, parentCatID FROM categories1 ORDER BY catName";
//if( 	$rows = $db->queryObjectArray($sql)){
//
//foreach($rows as $row) {
//$subcatsftype[$row->parentCatID][] = $row->catID;
//$catNamesftype[$row->catID] = $row->catName; }
//
//$rows = build_category_array($subcatsftype[NULL], $subcatsftype, $catNamesftype);
//if($rows && is_array($rows))
//$formdata['frmType']=$rows;
//}
//
//
///*****************************************************/
//$db->execute("COMMIT");
//
//
//$formdata['type'] = 'success';
//$formdata['message'] = 'עודכן בהצלחה!';
//echo json_encode($formdata);
//exit;
//
//
//}
//
//break;