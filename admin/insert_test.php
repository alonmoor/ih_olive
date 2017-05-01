<?php
/**
 * Created by PhpStorm.
 * User: alon
 * Date: 27/04/17
 * Time: 10:32
 *//************************************************************************************************/
function add_forum(&$formdata="",&$appointsIDs="",&$managersIDs="",&$catIDs="",&$catTypeIDs="",
                   &$dateIDs="",&$appointdateIDs="",&$managerdateIDs=""){
    /************************************************************************************************/
    global $db;

    if ($formdata['insertID'] && !$formdata['insert_forum'] && !is_numeric($formdata['insert_forum']) && !is_array($formdata['insert_forum']) )
        $insertID=$formdata['insertID'];

    elseif($_GET['insertID'] && !$formdata['insert_forum'] && !is_numeric($formdata['insert_forum']) && !is_array($formdata['insert_forum']))
        $insertID=$this->insertID;

    elseif($formdata['insert_forum'] && (is_numeric($formdata['insert_forum'][0])) &&  is_array($formdata['insert_forum'])  ){
        $insertID=$formdata['insert_forum'];

    }elseif(array_item ($formdata,'insert_forum') && (is_numeric($formdata['insert_forum']))
        &&  !is_array($formdata['insert_forum']) && array_item ($formdata,'insertID') && (is_numeric($formdata['insertID'])) ){
        $insertID=$formdata['insert_forum'];
        unset($formdata['insertID']);
    }elseif(array_item ($formdata,'insert_forum') && (is_numeric($formdata['insert_forum'])) &&  !is_array($formdata['insert_forum'])  ){
        $insertID=$formdata['insert_forum'];

    }elseif(!is_array($formdata['insert_forum'])){
        $insertID='11';
        $formdata['insertID']='11';
    }


    if($formdata['forum_decision']!='11' && !($formdata['newforum']) ){
        $this->forum_decID=$formdata['forum_decision'];
        $formdata['forum_decID']=$formdata['forum_decision'];
    }
    if($formdata['submitbutton'])
        $submitbutton=$formdata['submitbutton'];
    else
        $submitbutton=$this->submitbutton;



    if($formdata['newforum']  && $formdata['newforum']!='none'){
        $subcategories=$formdata['newforum'];
    }elseif($formdata['forum_decision'] && is_array($formdata['forum_decision']) ){
        foreach($formdata['forum_decision'] as $forum)	{
            $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID = " .
                $db->sql_string($forum);
            if($rows = $db->queryObjectArray($sql) )
                $subcategories[]=$rows[0]->forum_decName;
        }
    }elseif($formdata['forum_decision'] && !is_array($formdata['forum_decision']) ){
        $forum=$formdata['forum_decision'];
        $sql = "SELECT forum_decName FROM forum_dec WHERE forum_decID =$forum " ;

        if($rows = $db->queryObjectArray($sql))
            $subcategories[]=$rows[0]->forum_decName;

    }
    //if(!($formdata['dynamic_12']) &&  !($formdata['dynamic_ajx']) ){
    if(!($formdata['dynamic_ajx']) ){
        echo "<h1>הוסף/עדכן פורום חדש</h1>\n";
    }
    // if there is form data to process, insert new
    // subcategories into database
    if($subcategories) {
        $db->execute("START TRANSACTION");
        if($formdata['dynamic_6']==1){

            //for dynamic_6
            if($this->insert_new_forums1($formdata ,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,$dateIDs,$appointdateIDs,$managerdateIDs)){

                $db->execute("COMMIT");
            }else{
                $db->execute("ROLLBACK");
                return FALSE;
            }

        }elseif($formdata['dynamic_8']==1  || ($formdata['dynamic_9']==1
                || $formdata['dynamic_10']==1 || $formdata['dynamic_12']==1

                && array_item($formdata,'dest_users') && is_array($formdata['dest_users']))){
            if($this->insert_new_forums($insertID, $subcategories,$formdata ,$appointsIDs,$managersIDs,
                $catIDs,$catTypeIDs,$dateIDs)){

                $db->execute("COMMIT");
            }else{
                $db->execute("ROLLBACK");
                return FALSE;
            }

        }elseif($formdata['dynamic_8']==1  || ($formdata['dynamic_9']==1
                || $formdata['dynamic_10']==1 || $formdata['dynamic_12']==1  )){
            if($this->insert_new_forums($insertID, $subcategories,$formdata ,$appointsIDs,$managersIDs,
                $catIDs,$catTypeIDs,$dateIDs)){

                $db->execute("COMMIT");
            }else{
                $db->execute("ROLLBACK");
                return FALSE;
            }

        }else{//for dynamic_6b
            if($this->insert_new_forums2($formdata ,$appointsIDs,$managersIDs,$catIDs,$catTypeIDs,$dateIDs,$appointdateIDs,$managerdateIDs,$form)){
                $this->print_forum_paging_b();
                $db->execute("COMMIT");
            }else{
                $db->execute("ROLLBACK");
                return FALSE;
            }
        }
    }

    return  true;

}
/*************************************UPDATE AREA**********************************************/


// insert new subcategories to given category

function insert_new_forums($insertID, $subcategories,&$formdata,&$appointsIDs="",&$managersIDs="",&$catIDs="",&$catTypeIDs="",$dateIDs=""){
    global $db;
    $frm=new forum_dec();
    $size_of_array_date = count($dateIDs['full_date']);
    $size_of_array_users = count($usersIDs);
    $size_of_dest_users = count($formdata['dest_users']);


    $dates = getdate();
    $dates['mon']  = str_pad($dates['mon'] , 2, "0", STR_PAD_LEFT);
    $dates['mday']  = str_pad($dates['mday'] , 2, "0", STR_PAD_LEFT);

    $today= $this->build_date5($dates);

    /**********************************************************************************/
    $status      =  $formdata['forum_status'];
    /**********************************************************************************/
    $forum_allowed = $formdata['forum_allowed'];

    if($formdata['forum_allowed']==1)
        $forum_allowed= 'public';
    elseif($formdata['forum_allowed']==2 )
        $forum_allowed= 'private';
    elseif($formdata['forum_allowed']==3 )
        $forum_allowed= 'top_secret';

    $forum_allowed=$db->sql_string($forum_allowed);
    /**********************************************************************************/

    $forumType=$catIDs;
    /*********************************************************************************/
    $appoint=$appointsIDs;
    /************************************************************************************/
    $manager=$managersIDs;
    /***********************************************************************************/
    $managerType=$catTypeIDs;
    /**********************************************************************************/

    $formdata['insert_forum']=$insertID;

    if(!$this->check_date($formdata['forum_date']))
        $formdata['forum_date']=$tooday;

    list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$formdata['forum_date']);

    if (strlen($year_date_forum) < 3){
        $formdata['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
    }elseif(strlen($day_date_manager)==4){
        $formdata['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
    }
    $forum_date=$db->sql_string($formdata['forum_date']);




    /************************************************************************************/


    if(!$this->check_date($formdata['appoint_date1']))
        $formdata['appoint_date1']=$tooday;

    list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$formdata['appoint_date1']);

    if (strlen($year_date_appoint) < 3){
        $formdata['appoint_date1']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
    }elseif(strlen($day_date_manager)==4){
        $formdata['appoint_date1']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
    }
    $appoint_date=$db->sql_string($formdata['appoint_date1']);



    /**********************************************************************************/

    if(!$this->check_date($formdata['manager_date']))
        $formdata['manager_date']=$tooday;
    list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$formdata['manager_date']);

    if (strlen($year_date_manager) < 3){
        $formdata['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
    }elseif(strlen($day_date_manager)==4){
        $formdata['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
    }
    $manager_date=$db->sql_string($formdata['manager_date']);
    /**********************************************************************************/

    if($formdata['forum_decID'])
        $forum_decID=$formdata['forum_decID'];


    $result =$this->insert_new_forum($insertID,trim($subcategories),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$managerType,$status,$forum_allowed,$formdata);

    if($result == -1) {
        echo "<p>טעות - שים לב כלום לא נישמר!.</p>\n";
        return FALSE;
    }elseif ($result){
        /********************************************************************************************/
        if(!$forum_decID){
            $forum_decID=$db->insertId();
        }


        /*******************************CONN AREA***************************************************/

        $this->conn_cat_forum($forum_decID,$catIDs,$formdata);
        /**********************************************************************************/


        $this->conn_type_manager($forum_decID,$catTypeIDs);
        //if($type_manager_idx==$size_of_array_cat_manager) $type_manager_idx=$size_of_array_cat_manager-1;
        // $managerType=$catTypeIDs [$type_manager_idx];

        /**********************************************************************************/


        if(array_item($formdata,'dest_users') && count($formdata['dest_users'])>0 ){

            $usersIDs=$formdata['dest_users'];

            $this->conn_user_forum_test($forum_decID,$usersIDs,$dateIDs,$formdata['today'],$formdata);
        }
        /***********************************************************************************/
        //if(!($formdata['dynamic_12']) &&  !($formdata['dynamic_ajx']) ){
        if(!($formdata['dynamic_ajx']) ){
            $this->message_save_c(trim($subcategories),$forum_decID);
        }
        $formdata['subcategories']=trim($subcategories);
        $form=$formdata;

        if(  ($formdata['newforum'] && $formdata['newforum']!='none')
            || ($formdata['new_name'] &&  $formdata['forum_decID']  )  ) {
//                $frm_name=$db->sql_string($formdata['newforum']) ;
//				$sql="UPDATE forum_dec set forum_decName=$frm_name  where forum_decIDID=$forum_decID ";
//				if(!$db->execute($sql) ){return False; }
            $form['forum_decision']=$forum_decID;//$formdata['forum_decID'];
            $form['forum_decID']=$forum_decID;
            $formdata['forum_decID']=$forum_decID;
        }
        else{
            $form['forum_decision']=$formdata['forum_decision'];
            $formdata['forum_decID']=$forum_decID;
        }
        /******************************************************************************************/
        $form['manager_forum']=$manager;

        /******************************************************************************************/
        $form['appoint_forum']=$appoint;

        /******************************************************************************************/
        $form['dest_managersType']=$managerType ;

        /********************************************************************************************/

        $form['dest_forumsType']=$forumType ;

        /********************************************************************************************/
        $form['forum_status']=$status  ;
        /********************************************************************************************/
        $formdata['new_name']=$formdata['newforum'];
        /********************************************************************************************/
        list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$form['forum_date']);

        if (strlen($year_date_forum) > 3){
            $form['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
        }elseif(strlen($day_date_appoint)==4){
            $form['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";
        }
        /***********************************************************************************/
        list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$form['appoint_date1']);

        if (strlen($year_date_appoint) > 3){
            $form['appoint_date1']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
        }elseif(strlen($day_date_appoint)==4){
            $form['appoint_date1']="$year_date_appoint-$month_date_appoint-$day_date_appoint";
        }
        /***********************************************************************************/
        list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$form['manager_date']);

        if (strlen($year_date_manager) > 3){
            $form['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
        }elseif(strlen($day_date_manager)==4){
            $form['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";
        }
        /************************************************************************************************/

        unset($form['newforum']);
        unset($form['new_forumType']);
        unset($form['new_appoint']);
        unset($form['new_manager']);
        unset($form['new_managerType']);
        /***********************************************************************************************/
        if($form['multi_day']  ){
            unset($form['multi_day']);
        }
        if($form['multi_month']  ){
            unset($form['multi_month']);
        }
        if($form['multi_year']  ){
            unset($form['multi_year']);
        }


        /***********************************************************************************************/

        unset($_SESSION['forum_decID']);
        $_SESSION['forum_decID']=$form['forum_decID'];

//				if(!($formdata['dynamic_ajx']) ){
//				$this->print_forum_entry_form1($forum_decID);
//				}
        if($formdata[dynamic_8])
            build_form($form);


        if($formdata[dynamic_9]){



            //   $form['forum_decName'] = $form['subcategories'];
//                 $form['type'] = 'success';
// 	             $form['message'] = 'עודכן בהצלחה!';

            if(!($form['dynamic_ajx']==1)){
                build_form_ajx7($form);
                $frm->print_forum_paging_b();
            }else{
                /***************************DYNAMIC_9_TO_AJAX*****************************************************/
                /******************************************************************************************/
                $i=0;
                if($form['dest_users'] && is_array($form['dest_users']) && is_array($dest_users)){

                    foreach($dest_users as $key=>$val){
                        if(is_numeric($val)){
                            $sql="select userID,full_name  from users where userID=$val";
                            if($rows=$db->queryObjectArray($sql)){

                                $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                                $i++;

                            }
                        }


                    }



                    $form["dest_user"]=$results;
                }elseif($form['dest_users'] && is_array($form['dest_users']) && !(is_array($form['dest_users'][0]))  ){

                    foreach($form['dest_users'] as $key=>$val){
                        if(is_numeric($key)){
                            $sql="select userID,full_name  from users where userID=$key";
                            if($rows=$db->queryObjectArray($sql)){

                                $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                                $i++;

                            }
                        }


                    }

                    $form["dest_user"]=$results;
                } elseif($form['dest_users'] && is_array($form['dest_users'][0])  ){
                    $form["dest_user"]=$form["dest_users"];
                    $form['add_frmID']=1;
                }

                /**********************************************************************************************************************/
//for check the length
                $i=0;
                if($form['src_usersID'] && is_array($form['src_usersID'])   ){

                    foreach($form['src_usersID'] as $key=>$val){

                        $sql="select userID,full_name  from users where userID=$val";
                        if($rows=$db->queryObjectArray($sql)){

                            $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                            $i++;

                        }


                    }
                    $form["src_user"]=$results1;
                }else{
                    $form["src_user"]=$form["dest_user"];
                }
                /***********************************************************************/
                /***********************FORUMSTYPE**********************************************/
                if(!(is_array($form['dest_forumsType'])))
                    $form['dest_forumsType']=explode(',', $form['dest_forumsType']);

                $i=0;
                if($form['dest_forumsType'] && is_array($form['dest_forumsType'])  ){

                    foreach($form['dest_forumsType'] as $key=>$val){
                        if(is_numeric($val)){
                            $sql="select catID,catName  from categories1 where catID=$val";
                            if($rows=$db->queryObjectArray($sql)){

                                $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);


                                $i++;

                            }
                        }


                    }
                    $form['dest_forumsType']=$results_cat_frm;
                }
                /*************************************MANAGER_TYPE*****************************************************************/
                if(!(is_array($form['dest_managersType'])))
                    $form['dest_managersType']=explode(',', $form['dest_managersType']);
                $i=0;
                if($form['dest_managersType'] && is_array($form['dest_managersType'])  ){

                    foreach($form['dest_managersType'] as $key=>$val){
                        if(is_numeric($val)){
                            $sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
                            if($rows=$db->queryObjectArray($sql)){

                                $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);


                                $i++;

                            }
                        }


                    }
                    $form['dest_managersType']=$results_cat_mgr;
                }
                /******************************************************************************************************/


                $manageID=$form['manager_forum'];
                $sql="select managerName from managers where managerID=$manageID";
                if($rows=$db->queryObjectArray($sql)){
                    $form['managerName']=$rows[0]->managerName;
                }
                /**********************************************************************/
                $appID=$form['appoint_forum'];
                $sql="select appointName from appoint_forum where appointID=$appID";
                if($rows=$db->queryObjectArray($sql)){
                    $form['appointName']=$rows[0]->appointName;
                }
                /**********************************************************************/
                $sql="select forum_decName  from forum_dec where forum_decID=$forum_decID  ";
                if($rows=$db->queryObjectArray($sql)){
                    $form['forum_decName']=$rows[0]->forum_decName;
                }
                $db->execute("COMMIT");


                $form['type'] = 'success';
                $form['message'] = 'עודכן בהצלחה!';
                echo json_encode($form);
                exit;


                /**********************************************************************************/
            }//end else
        }//end if dynamic_9
        /***************************************************************************/
        if($formdata[dynamic_10]){



            $i=0;
            if($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
                foreach($formdata['dest_users'] as $key=>$val){
                    if(is_numeric($key)){
                        $sql="select userID,full_name  from users where userID=$key  ";
                        if($rows=$db->queryObjectArray($sql)){

                            $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                            $i++;

                        }

                    }
                }
                $form["dest_user"]=$results;


                $i=0;
                foreach($formdata['dest_users'] as $key=>$val){
                    $sql="select active  from rel_user_forum where userID=$key and forum_decID=$forum_decID ";
                    if($rows=$db->queryObjectArray($sql)){

                        $form['active'][$key]=$rows[0]->active;
                        $i++;
                    }
                }


            }




            $form['type'] = 'success';
            $form['message'] = 'עודכן בהצלחה!';

            if(!($form['dynamic_ajx']==1)){
                build_form_ajx7($form);
                $frm->print_forum_paging_b();
            }else{

                /***************************DYNAMIC_9_TO_AJAX*****************************************************/
                /******************************************************************************************/
                $i=0;
                if($form['dest_users'] && is_array($form['dest_users']) && is_array($dest_users)){

                    foreach($dest_users as $key=>$val){
                        if(is_numeric($val)){
                            $sql="select userID,full_name  from users where userID=$val";
                            if($rows=$db->queryObjectArray($sql)){

                                $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                                $i++;

                            }
                        }


                    }



                    $form["dest_user"]=$results;
                }elseif($form['dest_users'] && is_array($form['dest_users']) && !(is_array($form['dest_users'][0]))  ){

                    foreach($form['dest_users'] as $key=>$val){
                        if(is_numeric($key)){
                            $sql="select userID,full_name  from users where userID=$key";
                            if($rows=$db->queryObjectArray($sql)){

                                $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                                $i++;

                            }
                        }


                    }

                    $form["dest_user"]=$results;
                } elseif($form['dest_users'] && is_array($form['dest_users'][0])  ){
                    $form["dest_user"]=$form["dest_users"];
                    $form['add_frmID']=1;
                }

                /**********************************************************************************************************************/
//for check the length
                $i=0;
                if($form['src_usersID'] && is_array($form['src_usersID'])   ){

                    foreach($form['src_usersID'] as $key=>$val){

                        $sql="select userID,full_name  from users where userID=$val";
                        if($rows=$db->queryObjectArray($sql)){

                            $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                            $i++;

                        }


                    }
                    $form["src_user"]=$results1;
                }else{
                    $form["src_user"]=$form["dest_user"];
                }
                /***********************************************************************/
                /***********************FORUMSTYPE**********************************************/
                if(!(is_array($form['dest_forumsType'])))
                    $form['dest_forumsType']=explode(',', $form['dest_forumsType']);

                $i=0;
                if($form['dest_forumsType'] && is_array($form['dest_forumsType'])  ){

                    foreach($form['dest_forumsType'] as $key=>$val){
                        if(is_numeric($val)){
                            $sql="select catID,catName  from categories1 where catID=$val";
                            if($rows=$db->queryObjectArray($sql)){

                                $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);


                                $i++;

                            }
                        }


                    }
                    $form['dest_forumsType']=$results_cat_frm;
                }
                /*************************************MANAGER_TYPE*****************************************************************/
                if(!(is_array($form['dest_managersType'])))
                    $form['dest_managersType']=explode(',', $form['dest_managersType']);
                $i=0;
                if($form['dest_managersType'] && is_array($form['dest_managersType'])  ){

                    foreach($form['dest_managersType'] as $key=>$val){
                        if(is_numeric($val)){
                            $sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
                            if($rows=$db->queryObjectArray($sql)){

                                $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);


                                $i++;

                            }
                        }


                    }
                    $form['dest_managersType']=$results_cat_mgr;
                }
                /******************************************************************************************************/


                $manageID=$form['manager_forum'];
                $sql="select managerName from managers where managerID=$manageID";
                if($rows=$db->queryObjectArray($sql)){
                    $form['managerName']=$rows[0]->managerName;
                }
                /**********************************************************************/
                $appID=$form['appoint_forum'];
                $sql="select appointName from appoint_forum where appointID=$appID";
                if($rows=$db->queryObjectArray($sql)){
                    $form['appointName']=$rows[0]->appointName;
                }
                /**********************************************************************/
                $sql="select forum_decName  from forum_dec where forum_decID=$forum_decID  ";
                if($rows=$db->queryObjectArray($sql)){
                    $form['forum_decName']=$rows[0]->forum_decName;
                }

                echo json_encode($form);
                $db->execute("COMMIT");
                exit;
            }

            /********************************************************************************************/
        }//end if($formdata[dynamic_10]){
        /********************************************************************************************/
        /********************************************************************************************/
        if($formdata[dynamic_12] || $formdata['dynamic_ajx'] ){


            $i=0;
            if($formdata['dest_users'] && is_array($formdata['dest_users'])   ){
                foreach($formdata['dest_users'] as $key=>$val){
                    if(is_numeric($key)){
                        $sql="select userID,full_name  from users where userID=$key  ";
                        if($rows=$db->queryObjectArray($sql)){

                            $results[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                            $i++;

                        }


                    }

                }
                $form["dest_user"]=$results;

            }
            /**************************************************************************************/
//for check the length

            $i=0;
            if($form['src_usersID'] && is_array($form['src_usersID'])   ){

                foreach($form['src_usersID'] as $key=>$val){

                    $sql="select userID,full_name  from users where userID=$val";
                    if($rows=$db->queryObjectArray($sql)){

                        $results1[$i] = array('full_name'=>$rows[0]->full_name,'userID'=>$rows[0]->userID);


                        $i++;

                    }


                }
                $form["src_user"]=$results1;
            }else{
                $form["src_user"]=$form["dest_user"];
            }
            /***********************************************************************/
            $sql="select forum_decName  from forum_dec where forum_decID=$forum_decID  ";
            if($rows=$db->queryObjectArray($sql)){
                $form['forum_decName']=$rows[0]->forum_decName;
            }
            /*********************************************************************************************/
//	$sql="select forum_decID, forum_decName  from forum_dec";
//		if($rows=$db->queryArray($sql)){
//		$form['forum_dec']=$rows;
//		}
            /***********************************************************************/
            $manageID=$form['manager_forum'];
            $sql="select managerName from managers where managerID=$manageID";
            if($rows=$db->queryObjectArray($sql)){
                $form['managerName']=$rows[0]->managerName;
            }
            /**********************************************************************/
            $appID=$form['appoint_forum'];
            $sql="select appointName from appoint_forum where appointID=$appID";
            if($rows=$db->queryObjectArray($sql)){
                $form['appointName']=$rows[0]->appointName;
            }


            /***********************FORUMSTYPE**********************************************/
            $i=0;
            if($form['dest_forumsType'] && is_array($form['dest_forumsType'])  ){

                foreach($form['dest_forumsType'] as $key=>$val){
                    if(is_numeric($val)){
                        $sql="select catID,catName  from categories1 where catID=$val";
                        if($rows=$db->queryObjectArray($sql)){

                            $results_cat_frm[$i] = array('catName'=>$rows[0]->catName,'catID'=>$rows[0]->catID);


                            $i++;

                        }
                    }


                }
                $form['dest_forumsType']=$results_cat_frm;
            }
            /*************************************MANAGER_TYPE*****************************************************************/

            $i=0;
            if($form['dest_managersType'] && is_array($form['dest_managersType'])  ){

                foreach($form['dest_managersType'] as $key=>$val){
                    if(is_numeric($val)){
                        $sql="select managerTypeID,managerTypeName  from manager_type where managerTypeID=$val";
                        if($rows=$db->queryObjectArray($sql)){

                            $results_cat_mgr[$i] = array('managerTypeName'=>$rows[0]->managerTypeName,'managerTypeID'=>$rows[0]->managerTypeID);


                            $i++;

                        }
                    }


                }
                $form['dest_managersType']=$results_cat_mgr;
            }
            /******************************************************************************************************/

            unset($_POST['form']['multi_year']);
            unset($_POST['form']['multi_month']);
            unset($_POST['form']['multi_day']);
            unset($form['multi_year']);
            unset($form['multi_month']);
            unset($form['multi_day']);
            $form['multi_year'][0]='none';
            $form['multi_month'][0]='none';
            $form['multi_day'][0]='none';

            /**********************************************************************************************/
            $form['type'] = 'success';
            $form['message'] = 'נישמר בהצלחה!';
            /*******************************************************************************************/


            /*******************************************************************************************/
            echo json_encode($form);
            // echo json_encode($results);
            $db->execute("COMMIT");
            // $this->message_save($newforumname,$forum_decID);
            //$this->print_forum_entry_form1($forum_decID);
            exit;
        }
        /********************************************************************************************/



        //echo "<p>פורום עודכן/ נוסף.</p>\n";
        $this->link();
        return TRUE;
    }
}
/*******************************************************************************************************/
/*******************************************************************************************************/

function insert_new_forum($insertID,$newforumName,$appointID,$managerID,$forum_date,$appoint_date="",$manager_date="" ,$managerType,$status,$forum_allowed,$formdata,$forum_decID="") {
//($insertID,($newforumname),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$managerType,$status,$formdata);
//  ($insertID,$subcategories,$appoint,$manager,$forum_date,$appoint_date,$manager_date,$status,$formdata);
    global $db;
    // test if newcatName is empty

    if(!$newforumName) return 0;
    $newforumName = $db->sql_string($newforumName);

    // test if newcatName already exists

    $now	=	date('Y-m-d');
    if(!$manager_date)
        $manager_date=$now;


    if(!$appoint_date)
        $appoint_date=$now;
    if(!$forum_date)
        $forum_date=$now;
    if( (  $formdata['forum_decision']!=null  && $formdata['forum_decision']!='none'
            && count($formdata['forum_decision'])>0)

        && array_item ($formdata,'forum_decID')
        && is_numeric($formdata['forum_decID'])


        && array_item ($formdata,'forum') &&  $formdata['forum']!='none'
        && !is_numeric($formdata['forum'])

    ){



        $db->execute("set foreign_key_checks=0");
        $sql = "UPDATE forum_dec SET  
           appointID=$appointID,
           managerID=$managerID, 
           active=   $status ,
           forum_allowed=$forum_allowed,
	       forum_date=  $forum_date ,
	        appoint_date=  $appoint_date ,
	         manager_date=  $manager_date ,
	       parentForumID=$insertID ,
	     
            WHERE forum_decID=$forum_decID";
        if(!$db->execute($sql)){
            $db->execute("set foreign_key_checks=1");
            return -1;

        }else
            $db->execute("set foreign_key_checks=1");
        return 1;
    }elseif( ($formdata['newforum'] && $formdata['newforum']!='none')){


        $sql = "SELECT COUNT(*) FROM forum_dec " .
            " WHERE parentForumID=$insertID " .
            "  AND forum_decName=$newforumName";

        if($db->querySingleItem($sql)>0) {
            show_error_msg('כבר קיים פורום אם שם כזה');
            return -1;
        }else

            $sql = "INSERT INTO forum_dec ( forum_decName, managerID, appointID, forum_date, active, parentForumID, manager_date, appoint_date,forum_allowed) " .
                "VALUES ( $newforumName,$managerID,$appointID,$forum_date, $status, $insertID,   $manager_date,$appoint_date,$forum_allowed)";

        if($db->execute($sql))


            return 1;
        else
            return -1;
    }


}

/**********************************************************************************************/


// insert new subcategories to given category

function insert_new_forums1(&$formdata,&$appointsIDs="",&$managersIDs="" ,&$catIDs="",&$catTypeIDs="",&$dateIDs="",&$date_appointIDs="",&$date_managerIDs=""){
    global $db;

    if ($formdata['newforum'] && $formdata['newforum']!='none'
        && $formdata['forum_decision'][0] && $formdata['forum_decision'][0]!='none' ){
        unset($formdata['forum_decision']);
        $subcategories =explode(";",$subcategories);
    }elseif($formdata['newforum'] && $formdata['newforum']!='none'){
        $subcategories =explode(";",$formdata['newforum']);
    }
    //$status1      = explode(";" , $formdata['forum_status']);
    $count = 0;
    $nameArray=0;
    $size_of_array = count($subcategories);

    $size_of_array_date = count($dateIDs);
    $size_of_array_date_appoint = count($date_appointIDs);
    $size_of_array_date_manager = count($date_managerIDs);

    $size_of_array_manager = count($managersIDs);
    $size_of_array_appoint = count($appointsIDs);
    $size_of_array_cat_forum = count($catIDs);
    $size_of_array_cat_manager = count($catTypeIDs);

    $size_of_status	 =count($status1);

    $size_of_array_insert_forum	 =count($formdata['insert_forum']);
//		$size_of_array_insert_forumType	 =count($formdata['insert_forumType']);
//		$size_of_array_insert_appoint	 =count($formdata['insert_appoint']);
//		$size_of_array_insert_manager	 =count($formdata['insert_manager']);
//		$size_of_arrayinsert_managerType	 =count($formdata['insert_managerType']);



    $i=0;
    $j=0;
    $k=0;
    $l=0;
    $m=0;
    $n=0;
    $x=0;
    $y=0;
    $z=0;


    $manager_idx=0;
    $appoint_idx=0;

    $forum_dt_idx=0;
    $appoint_dt_idx=0;
    $manager_dt_idx=0;

    $appoint_date=0;
    $manager_date=0;


    $type_manager_idx=0;
    $type_forum_idx=0;




    $insert_forum_idx=0;






//		$insert_forumType_idx=0;
//		$insert_appoint_idx=0;
//		$insert_manager_idx=0;
//		$insert_managerType_idx=0;

    foreach($subcategories as $newforumname) {


        $status=2;
        /**********************************************************************************/
        $forum_allowed = $formdata['forum_allowed'];

        if($formdata['forum_allowed']==1)
            $forum_allowed= 'public';
        elseif($formdata['forum_allowed']==2 )
            $forum_allowed= 'private';
        elseif($formdata['forum_allowed']==3 )
            $forum_allowed= 'top_secret';

        $forum_allowed=$db->sql_string($forum_allowed);
        /**************************************************************************************/

        if($appoint_idx==$size_of_array_appoint) $appoint_idx=$size_of_array_appoint-1;
        $appoint=$appointsIDs[$appoint_idx];

        /**********************************************************************************/

        if($manager_idx==$size_of_array_manager) $manager_idx=$size_of_array_manager-1;
        $manager=$managersIDs[$manager_idx];
        /**********************************************************************************/

        if($type_forum_idx==$size_of_array_cat_forum) $type_forum_idx=$size_of_array_cat_forum-1;
        $forumType=$catIDs [$type_forum_idx];




        /****************************FORUM_DATE******************************************************/
        if($forum_dt_idx==$size_of_array_date) $forum_dt_idx=$size_of_array_date-1;


        $forum_date=$dateIDs[$forum_dt_idx++];
        $forum_date=$db->sql_string($forum_date);



        /*********************************APPOINT_DATE*************************************************/
        if($appoint_dt_idx==$size_of_array_date_appoint) $appoint_dt_idx=$size_of_array_date_appoint-1;

        $appoint_date=$date_appointIDs[$appoint_dt_idx++];
        $appoint_date=$db->sql_string($appoint_date);



        /*************************************MANAGER_DATE*********************************************/
        if($manager_dt_idx==$size_of_array_date_manager) $manager_dt_idx=$size_of_array_date_manager-1;


        $manager_date=$date_managerIDs[$manager_dt_idx++];
        $manager_date=$db->sql_string($manager_date);


        /*********************************************INSERT_FORUMID******************************************************************/
        if($insert_forum_idx==$size_of_array_insert_forum) $insert_forum_idx=$size_of_array_insert_forum-1;

        if(array_item($formdata,'insert_forum') && is_array($formdata['insert_forum']) && is_numeric($formdata['insert_forum'][0]) ){
            if($insert_forum_idx==$size_of_array_insert_forum) {$insert_forum_idx=$size_of_array_insert_forum-1;}
            $insertID=$formdata['insert_forum'][$insert_forum_idx++];
        }else{
            $insertID=11;
        }
        /************************************************************************************************************************/


        $result =$this->insert_new_forum($insertID,trim($newforumname),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$status,$forum_allowed,$formdata);


        if($result == -1) {
            echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
            return FALSE;
        }elseif ($result){
            /********************************************************************************************/


            $count++;

            $forum_decID=$db->insertId();

            /*********************************************************************************/
            $this->conn_cat_forum1($forum_decID,$catIDs[$type_forum_idx]);

            if($type_forum_idx==$size_of_array_cat_forum){
                $type_forum_idx=$size_of_array_cat_forum-1;
            }
            /**********************************************************************************/


            $this->conn_manager_forum1($forum_decID,$catTypeIDs[$type_manager_idx]);
            if($type_manager_idx==$size_of_array_cat_manager) $type_manager_idx=$size_of_array_cat_manager-1;
            // $managerType=$catTypeIDs [$type_manager_idx];

            /**********************************************************************************/

            $this->message_save($newforumname,$forum_decID);

            $formdata['subcategories']=$newforumname;
            $form=$formdata;

            $form['forum_decision']=$forum_decID;

            /******************************************************************************************/
            $form['manager_forum']=$manager;
            $manager_idx++ ;
            /******************************************************************************************/
            $form['appoint_forum']=$appoint;
            $appoint_idx++ ;
            /******************************************************************************************/

//				if($type_manager_idx==$size_of_array_cat_manager){
//					$type_manager_idx=$size_of_array_cat_manager-1;
//				}
            $form['managerType']=$catTypeIDs[$type_manager_idx++];

            /********************************************************************************************/
//				if($type_forum_idx==$size_of_array_cat_forum){
//					$type_forum_idx=$size_of_array_cat_forum-1;
//				}
            $form['category']=$catIDs[$type_forum_idx++];

            /********************************************************************************************/
            $form['forum_status']=$status ;
            /****************************************************************************************/

            $form['index']=$nameArray;
            // $form['submitbutton']=$formdata['']
            /****************************************************************************************/

            $form['appoint_date']=substr($appoint_date,1,10);
            list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$form['appoint_date']);

            if (strlen($year_date_appoint) > 3){
                $form['appoint_date']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
            }elseif(strlen($day_date_appoint)==4){
                $form['appoint_date']="$year_date_appoint-$month_date_appoint-$day_date_appoint";
            }
            /***********************************************************************************/
            $form['manager_date']=substr($manager_date,1,10);
            list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$form['manager_date']);

            if (strlen($year_date_manager) > 3){
                $form['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
            }elseif(strlen($day_date_manager)==4){
                $form['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";
            }
            /********************************************************************************************/
            $form['forum_date']=substr($forum_date,1,10);
            list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$form['forum_date']);

            if (strlen($year_date_forum) > 3){
                $form['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
            }elseif(strlen($day_date_forum)==4){
                $form['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";
            }
            /********************************************************************************************/
            $formdata['new_name']=$formdata['newforum'];
            //unset($formdata['newforum']);
            unset($form['newforum']);
            unset($form['new_category']);
            unset($form['new_appoint']);
            unset($form['new_manager']);
            unset($form['new_type']);
            $_SESSION['forum_decID']=$form['forum_decision'];
            $this->print_forum_entry_form1($form['forum_decision']);
            build_form($form);

//				$form['type'] = 'success';
//				$form['message'] = 'עודכן בהצלחה!';
//			     echo json_encode($form);
//			 	exit;
            $nameArray++;

            /********************************************************************************************/

        }
    }


    if($count)
        if($count==1)
            echo "<p>פורום  עודכן/נוסף.</p>\n";
        else{
            echo "<p>$count פורומים חדשים נוספו.</p>\n";

        }
    return TRUE;
}
/*******************************************************************************************************/
/*********************************************************************************************************/


// insert new subcategories to given category

function insert_new_forums2(&$formdata,&$appointsIDs="",&$managersIDs="" ,&$catIDs="",&$catTypeIDs="",&$dateIDs="",&$date_appointIDs="",&$date_managerIDs="",$form1=""){
    global $db;

    if ($formdata['newforum'] && $formdata['newforum']!='none'
        && $formdata['forum_decision'][0] && $formdata['forum_decision'][0]!='none' ){
        unset($formdata['forum_decision']);
        $subcategories =explode(";",$subcategories);
    }elseif($formdata['newforum'] && $formdata['newforum']!='none'){
        $subcategories =explode(";",$formdata['newforum']);
    }

    $count = 0;
    $nameArray=0;
    $size_of_array = count($subcategories);

    $size_of_array_date = count($dateIDs);
    $size_of_array_date_appoint = count($date_appointIDs);
    $size_of_array_date_manager = count($date_managerIDs);

    $size_of_array_manager = count($managersIDs);
    $size_of_array_appoint = count($appointsIDs);
    $size_of_array_cat_forum = count($catIDs);
    $size_of_array_cat_manager = count($catTypeIDs);

    $size_of_status	 =count($status1);

    $size_of_array_insert_forum	 =count($formdata['insert_forum']);




    $i=0;
    $j=0;
    $k=0;
    $l=0;
    $m=0;
    $n=0;
    $x=0;
    $y=0;
    $z=0;


    $manager_idx=0;
    $appoint_idx=0;

    $forum_dt_idx=0;
    $appoint_dt_idx=0;
    $manager_dt_idx=0;

    $appoint_date=0;
    $manager_date=0;


    $type_manager_idx=0;
    $type_forum_idx=0;




    $insert_forum_idx=0;



    foreach($subcategories as $newforumname) {

        /************************************************************************/
        $status=$formdata['forum_status'];
        $forum_allowed = $formdata['forum_allowed'];

        if($formdata['forum_allowed']==1)
            $forum_allowed= 'public';
        elseif($formdata['forum_allowed']==2 )
            $forum_allowed= 'private';
        elseif($formdata['forum_allowed']==3 )
            $forum_allowed= 'top_secret';

        $forum_allowed=$db->sql_string($forum_allowed);
        /**************************************************************************/
        if($appoint_idx==$size_of_array_appoint) $appoint_idx=$size_of_array_appoint-1;
        $appoint=$appointsIDs[$appoint_idx];

        /**********************************************************************************/

        if($manager_idx==$size_of_array_manager) $manager_idx=$size_of_array_manager-1;
        $manager=$managersIDs[$manager_idx];
        /**********************************************************************************/

        if($type_forum_idx==$size_of_array_cat_forum) $type_forum_idx=$size_of_array_cat_forum-1;
        $forumType=$catIDs [$type_forum_idx];


        /**********************************************************************************/
        if($type_manager_idx==$size_of_array_cat_manager) $type_manager_idx=$size_of_array_cat_manager-1;
        $managerType=$catTypeIDs [$type_manager_idx];


        /****************************FORUM_DATE******************************************************/
        if($forum_dt_idx==$size_of_array_date) $forum_dt_idx=$size_of_array_date-1;


        $forum_date=$dateIDs[$forum_dt_idx++];
        $forum_date=$db->sql_string($forum_date);



        /*********************************APPOINT_DATE*************************************************/
        if($appoint_dt_idx==$size_of_array_date_appoint) $appoint_dt_idx=$size_of_array_date_appoint-1;

        $appoint_date=$date_appointIDs[$appoint_dt_idx++];
        $appoint_date=$db->sql_string($appoint_date);



        /*************************************MANAGER_DATE*********************************************/
        if($manager_dt_idx==$size_of_array_date_manager) $manager_dt_idx=$size_of_array_date_manager-1;


        $manager_date=$date_managerIDs[$manager_dt_idx++];
        $manager_date=$db->sql_string($manager_date);


        /*********************************************INSERT_FORUMID******************************************************************/
        if($insert_forum_idx==$size_of_array_insert_forum) $insert_forum_idx=$size_of_array_insert_forum-1;

        if(array_item($formdata,'insert_forum') && is_array($formdata['insert_forum']) && is_numeric($formdata['insert_forum'][0]) ){
            if($insert_forum_idx==$size_of_array_insert_forum) {$insert_forum_idx=$size_of_array_insert_forum-1;}
            $insertID=$formdata['insert_forum'][$insert_forum_idx++];
        }else{
            $insertID=11;
        }
        /************************************************************************************************************************/


        $result =$this->insert_new_forum($insertID,trim($newforumname),$appoint,$manager,$forum_date,$appoint_date,$manager_date,$managerType,$status,$forum_allowed,$formdata);


        if($result == -1) {
            echo "<p>Sorry, an error happened. Nothing was saved.</p>\n";
            return FALSE;
        }elseif ($result){
            /********************************************************************************************/


            $count++;

            $forum_decID=$db->insertId();



            $now	=	date('Y-m-d');
            if(!$usr_date)
                $usr_date=$now;$usr_date=$db->sql_string($usr_date);
            $frmID=$forum_decID;

            /*********************************************************************************/
            $this->conn_cat_forum1($forum_decID,$catIDs[$type_forum_idx],$formdata);
            $this->conn_manager_forum1($forum_decID,$catTypeIDs [$type_manager_idx] );



            /**********************************************************************************/



            $formdata['subcategories']=$newforumname;







            $form['forum_decision']=$forum_decID;
            $form['forum_decID']=$forum_decID;
            /******************************************************************************************/
            $form['manager_forum']=$manager;
            $manager_idx++ ;
            /******************************************************************************************/
            $form['appoint_forum']=$appoint;
            $appoint_idx++ ;
            /******************************************************************************************/


            if($formdata['dynamic_6b']){
                $form['dest_managersType']=$catTypeIDs[$type_manager_idx++];
            }else{
                $form['managerType']=$catTypeIDs[$type_manager_idx++];
            }

            /********************************************************************************************/


            if($formdata['dynamic_6b']){
                $form['dest_forumsType']=$catIDs[$type_forum_idx++];
            }else{
                $form['category']=$catIDs[$type_forum_idx++];
            }

            /********************************************************************************************/
            $form['forum_status']=$status ;
            /****************************************************************************************/
            $form['forum_allowed']=$formdata['forum_allowed'] ;
            /****************************************************************************************/

            $form['index']=$nameArray;
            $form['form_index']=$count;
            /****************************************************************************************/

            $form['appoint_date']=substr($appoint_date,1,10);
            list($year_date_appoint,$month_date_appoint, $day_date_appoint) = explode('-',$form['appoint_date']);

            if (strlen($year_date_appoint) > 3){
                $form['appoint_date']="$day_date_appoint-$month_date_appoint-$year_date_appoint";
            }elseif(strlen($day_date_appoint)==4){
                $form['appoint_date1']="$year_date_appoint-$month_date_appoint-$day_date_appoint";
            }
            /***********************************************************************************/
            $form['manager_date']=substr($manager_date,1,10);
            list($year_date_manager,$month_date_manager, $day_date_manager) = explode('-',$form['manager_date']);

            if (strlen($year_date_manager) > 3){
                $form['manager_date']="$day_date_manager-$month_date_manager-$year_date_manager";
            }elseif(strlen($day_date_manager)==4){
                $form['manager_date']="$year_date_manager-$month_date_manager-$day_date_manager";
            }
            /********************************************************************************************/
            $form['forum_date']=substr($forum_date,1,10);
            list($year_date_forum,$month_date_forum, $day_date_forum) = explode('-',$form['forum_date']);

            if (strlen($year_date_forum) > 3){
                $form['forum_date']="$day_date_forum-$month_date_forum-$year_date_forum";
            }elseif(strlen($day_date_forum)==4){
                $form['forum_date']="$year_date_forum-$month_date_forum-$day_date_forum";
            }

            /********************************************************************************************/

            $formdata['new_name']=$formdata['newforum'];

            $form['forum_decName']=$newforumname;
            $form['insert_forum']=$formdata['insert_forum'][0];



            $submit="submitbutton_$forum_decID";


            unset($form['newforum']);
            unset($form['new_category']);
            unset($form['new_managerType']);
            unset($form['new_forumType']);
            unset($form['new_appoint']);
            unset($form['new_manager']);
            unset($form['new_type']);
            $_SESSION['forum_decID']=$form['forum_decision'];


            if($formdata['dynamic_6b']){
                $form['dest_forumsType']=explode(',',$form['dest_forumsType']);
                $form['dest_managersType']=explode(',',$form['dest_managersType']);
                build_form_ajx4($form);
            }else{
                build_form($form);
            }
            $nameArray++;

            /********************************************************************************************/

        }
    }


    if($count)
        if($count==1)
            echo "<p class='error'>פורום  עודכן/נוסף.</p>\n";
        else{
            echo "<p class='error'>$count פורומים חדשים נוספו.</p>\n";

        }
    return TRUE;
}
/*******************************************************************************************************/

/************************************************************************************************************/
/*********************************************************************************************************/

function safify($value, $type='') {
    // we're handling our own quoting, so we don't need magic quotes
    if(get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    // settype($value, $type);
    switch ($type) {
        case 'int': case 'float': case 'double':
        // the settype() above is all we need to do for numbers
        break;
        case 'boolean': /* processing of booleans depends on where $value is coming
				* from.  This section will probably need to be customized on a
				* per-form basis.
				*/
            $vals[$key] = is_null($vals) ? 'NULL' : "'$vals'" ;
            return $vals;
            break;
        case 'string':
            if(is_array($value)){
                $value =(trim($value));
                $value[$key] = is_null($value) ? 'NULL' : "'$value'" ;
            }else{
                $value= is_null($value) ? 'NULL' : "'$value'" ;
            }
            return $value;
            break;
        default:
            if(is_array($value)){
                $value[$key] = is_null($value) ? 'NULL' : "'$value'" ;
            }
            else{
                $value =(trim($value));// mysql_real_escape_string(trim($value));
                //$value = is_null($value) ? 'NULL' : "'$value'" ;
            }
            return $value;
            break;
    }
    return $value;
}

/**********************************************************************************/

/* createSetStatement: convert an array into a string of the form col_name='value'", sutable for an "INSERT INTO tbl_name SET" query */
function createSetStatement($row) {
    // Oh! for efficient anonymous function support in PHP.

    foreach ($row as $col => $val) {
        $tmp[] = "$col='$val'";
    }
    return implode(', ', $tmp);
}


/**********************************************************************************************/
function delete1(){



    global $db;
    $query = "set foreign_key_checks=0";
    if( $db->execute($query) )
        if( $db->execute("delete from  forum_dec where forum_decID=".$this->getId()))
            $db->execute("set foreign_key_checks=1");
        else
            $db->execute("set foreign_key_checks=1");
}

function check(&$err_msg) {
    return 1;
    $err_msg = "";
    if( strlen($this->decName) < 1)
        //$err_msg = "String too short";
        $err_msg =show_error_msg("String too short");


    return $err_msg=="";
}
/****************************************************************************************/
/********************************************************************************************/
function del_forum($deleteID){
    global $db;
    $sql = "SELECT COUNT(*) FROM forum_dec WHERE forum_decID=$deleteID";
    if($db->querySingleItem($sql)==1) {



        $db->execute("START TRANSACTION");
        $query = "set foreign_key_checks=0";
        $db->execute($query);
        if($this->delete_forum_sub($deleteID)==-1){
            $db->execute("ROLLBACK");
            $db->execute("set foreign_key_checks=1");
        }else{
            $db->execute("COMMIT");
            $db->execute("set foreign_key_checks=1");

        }
    }

}
/****************************************************************************************/

// delete a category
// return  1, if category and its subcategories could be deleted
// returns 0, if the category could not be deleted
// return -1 if an error happens

function delete_forum_sub($forum_decID) {
    // find subcategories to catID and delete them
    // by calling delete_category recursively
    global $db;
    $sql = "SELECT forum_decID FROM forum_dec " .
        "WHERE parentForumID='$forum_decID'";
    if($rows = $db->queryObjectArray($sql)) {
        $deletedRows = 0;
        foreach($rows as $row) {

            $result =$this->delete_forum_sub($row->forum_decID);

            if($result==-1)
                return -1;
            else
                $deletedRows++;
        }
        // if any subcategories could not be deleted,
        // don't delete this category as well
        if($deletedRows != count($rows))
            return 0;
    }


    if($forum_decID==11) {
        //echo "<br />אי אפשר למחוק שורש הפורומים   .\n";
        show_error_msg("<br />אי אפשר למחוק שורש הפורומים   .\n");
        return 0;
    }

    /***********************************************************************************************/

    $sql1 = "SELECT decID  FROM rel_forum_dec WHERE forum_decID=$forum_decID";
    if($rows1=$db->queryObjectArray($sql1)  ){
        foreach($rows1 as $row){
            $dec_arr[$row->decID]=$row->decID;
        }

        if($dec_arr && $dec_arr!=null){
            $this->del_decision($dec_arr);
        }
    }
    /***************************************************************************************************/
    // delete category
    $sql =  "DELETE FROM forum_dec WHERE forum_decID='$forum_decID' LIMIT 1";
    $sql1 = "DELETE FROM rel_cat_forum WHERE forum_decID='$forum_decID' LIMIT 1 ";
    $sql2 = "DELETE FROM rel_forum_dec WHERE forum_decID='$forum_decID' LIMIT 1 ";
    $sql3 = "DELETE FROM rel_user_forum WHERE forum_decID='$forum_decID' ";

    /**************************************************************************************************/


    //if( ($db->execute($sql) && $db->execute($sql1) && $db->execute($sql2) ) ||
    if(   ($db->execute($sql) && $db->execute($sql1) && $db->execute($sql2)&& $db->execute($sql3) ) )
        return 1;
    else
        return -1;

}




/****************************************************************************************/
function del_decision_copy_from_dec($deleteID){
    global $db;
    $sql = "SELECT COUNT(*) FROM decisions WHERE decID=$deleteID";
    if($db->querySingleItem($sql)==1) {
        $db->execute("START TRANSACTION");
        $query = "set foreign_key_checks=0";
        $db->execute($query);
        if($this->delete_decision_sub($deleteID)==-1){
            $db->execute("ROLLBACK");
            $db->execute("set foreign_key_checks=1");
        }else{
            $db->execute("COMMIT");
            $db->execute("set foreign_key_checks=1");
            return true;
        }
    }

}

/***************************************************************************************************/
// delete a category
// return  1, if category and its subcategories could be deleted
// returns 0, if the category could not be deleted
// return -1 if an error happens

function delete_decision_sub($decID) {
    // find subcategories to catID and delete them
    // by calling delete_category recursively
    global $db;
    $sql = "SELECT decID FROM decisions " .
        "WHERE parentdecID='$decID'";
    if($rows = $db->queryObjectArray($sql)) {
        $deletedRows = 0;
        foreach($rows as $row) {
            $result =$this->delete_decision_sub($row->decID);
            if($result==-1)
                return -1;
            else
                $deletedRows++;
        }
        // if any subcategories could not be deleted,
        // don't delete this category as well
        if($deletedRows != count($rows))
            return 0;
    }

    // delete catID
    // don't delete catIDs<=11
    if($decID==11) {
        echo "<br />אי אפשר למחוק שורש ההחלטות   .\n";
        return 0;
    }

    $task_sql="select taskID from todolist where decID='$decID' ";
    if($rows_task=$db->queryObjectArray($task_sql) ){



        for($i=0; $i<count($rows_task); $i++){
            if($i==0){
                $taskIDs = $rows_task[$i]->taskID;
            }
            else{
                $taskIDs .= "," . $rows_task[$i]->taskID;

            }

        }


        $sql4 = "DELETE FROM todolist WHERE decID='$decID'  ";
        if(!$db->execute($sql4))
            return -1;




//   	    $tag_sql="select * from tag2task where taskID = any (SELECT taskID from todolist where taskID in($taskIDs))";
        $tag_sql="select * from tag2task where taskID in($taskIDs)";
        if($rows=$db->queryObjectArray  ($tag_sql)) {

            for($i=0; $i<count($rows); $i++){
                if($i==0){
                    $tag_taskIDs = $rows[$i]->tagID;
                }
                else{
                    $tag_taskIDs .= "," . $rows[$i]->tagID;

                }

            }
            $tag_taskIDs=array_unique($tag_taskIDs);
            $db->execute("UPDATE tags SET tags_count=tags_count-1 WHERE tagID IN ($tag_taskIDs)");
            $db->execute("DELETE FROM tags WHERE tags_count < 1");	# slow on large amount of tags




        }



/////////////////////////////////////////////////////////////////////////////////////////
// $tag_task_sql="select taskID from tag2task where taskID = any (SELECT taskID from todolist where taskID in ($taskIDs))";
        $tag_task_sql="select taskID  from tag2task where taskID in ($taskIDs) ";
        if($rows_tag2task=$db->queryObjectArray($tag_task_sql) ){



            for($i=0; $i<count($rows_tag2task); $i++){
                if($i==0){
                    $ta2taskIDs = $rows_tag2task[$i]->taskID;
                }
                else{
                    $tag2taskIDs .= "," . $rows_tag2task[$i]->taskID;

                }

            }




            $sql6="delete from tag2task where where taskID in($tag2taskIDs)";

            if(!$db->execute($sql5))
                return -1;

        }

    }


    // delete category
    $sql = "DELETE FROM decisions WHERE decID='$decID' LIMIT 1";
    $sql1 = "DELETE FROM rel_cat_dec WHERE decID='$decID'  ";
    //$sql2 = "DELETE FROM rel_forum_dec WHERE decID='$decID'  ";


    if($db->execute($sql) && $db->execute($sql1) /*&& $db->execute($sql2)*/ )
        return 1;
    else
        return -1;

}


/*******************************************************************************************************/

/***************************************************************************************************/
function del_decision(&$arr_del){
    global $db;
    //$arr_del = array();
    foreach ($arr_del as $key=>$val){
        $sql = "SELECT COUNT(*) FROM decisions WHERE decID=$key";
        if($db->querySingleItem($sql)==1) {
            if($arr_del[$val]!=1){
                $db->execute("START TRANSACTION");
                $query = "set foreign_key_checks=0";
                $db->execute($query);

                if($this->delete_decision_sub($key, $arr_del)==-1 ){
                    $db->execute("ROLLBACK");
                    $db->execute("set foreign_key_checks=1");
                }else{
                    $db->execute("COMMIT");
                    $db->execute("set foreign_key_checks=1");

                }
            }

        }
    }
    return true;
}

/***************************************************************************************************/

function delete_decision_sub_waiting($decID, &$arr_deleted_dec) {
    // find subcategories to catID and delete them
    // by calling delete_category recursively
    global $db;
    $sql = "SELECT decID FROM decisions " .
        "WHERE parentdecID='$decID'";
    if($rows = $db->queryObjectArray($sql)) {
        $deletedRows = 0;
        foreach($rows as $row) {
            $result =$this->delete_decision_sub($row->decID, $arr_deleted_dec);
            if($result==-1)
                return -1;
            else
                $deletedRows++;
        }
        // if any subcategories could not be deleted,
        // don't delete this category as well
        if($deletedRows != count($rows))
            return 0;
    }

    // delete catID
    // don't delete catIDs<=11
    if($decID==11) {
        echo "<br />אי אפשר למחוק שורש ההחלטות   .\n";
        return 0;
    }

    // delete category
    //$query="SELECT d.decID ,c."
    $sql = "DELETE FROM decisions WHERE decID='$decID' LIMIT 1";
    $sql1 = "DELETE FROM rel_cat_dec WHERE decID='$decID' LIMIT 1 ";
    //$sql2 = "DELETE FROM rel_forum_dec WHERE decID='$decID' LIMIT 1 ";

    if($db->execute($sql) && $db->execute($sql1) ) {
        $arr_deleted_dec[$decID] = 1;
        return 1;
    } else
        return -1;

}


/*******************************************************************************************************/
// delete one forum
//=======================================
function delete_forum($formdata) {
    global $db;

    if((!$forum_decID = array_item($formdata, "forum_decID")) || !is_numeric($forum_decID))
        return FALSE;

    $sql = "set foreign_key_checks=0";
    if( $db->execute($sql) )  {
        $sql = "DELETE FROM forum_dec WHERE forum_decID=$forum_decID LIMIT 1";
        if(!$db->execute($sql)){
            $db->execute("set foreign_key_checks=1");
            return FALSE;
        }else{
            $db->execute("set foreign_key_checks=1");

        }
    }
    /**************************************************************************/
    $sql = "set foreign_key_checks=0";
    if( $db->execute($sql) )  {

        $sql = "DELETE FROM rel_forum_dec  WHERE  forum_decID = $forum_decID  LIMIT 1";
        if(!$db->execute($sql)){
            $db->execute("set foreign_key_checks=1");
            return FALSE;
        }else{
            $db->execute("set foreign_key_checks=1");

        }
    }
    /****************************************************************************/
    echo "<p>.פורום אחד נימחק</p>\n";
    echo "<p><b>   חזרה אל",
        build_href("dynamic_8.php", "", "רשימת החלטות") . " </b> </p>.\n";
    $formdata=false;
    //  build_form($formdata);
    return true;
}
/*******************************************************************************************************/

function save_user($formdata) {


    global $db;
    $i=0;

    $tmp =($formdata["dest_users"]) ? $formdata["dest_users"] : $forums=explode(";", $formdata["new_user"] );
    if((is_array($tmp)) && $tmp[0]!='none'){
        foreach( $tmp as $user) {

            $user=trim($user);

            $sql = "SELECT full_name,userID FROM users WHERE userID = " .
                $db->sql_string($user);


            $rows = $db->queryObjectArray($sql);
            if($rows)
                // existing forum
                $usersIDs[] = $rows[0]->userID;

        }
    }else{
        if($tmp!='none'){
            $sql = "SELECT full_name,userID FROM users WHERE userID = " .
                $db->sql_string($tmp);
            $rows = $db->queryObjectArray($sql);
            if($rows)
                // existing forum
                $usersIDs[] = $rows[0]->userID;
        }
    }
    return $usersIDs;
}

/*******************************************************************************************************************/
/*************************************************SAVE_APPOINT1*********************************************************************************/
function save_appoint1(&$formdata) {


    global $db;

    if ($formdata['dest_appoints']=='none' && !array_item ($formdata,"new_appoint")) {
        unset ($formdata['dest_appoints']);
        $tmp="";
        /************************************************************************************************************/

    }elseif ( ($formdata['dest_appoints']!='none' &&  $formdata['dest_appoints']!=null
            &&( array_item ($formdata,"dest_appoints") &&  is_array(array_item ($formdata,"dest_appoints"))   ) )
        && !array_item ($formdata,"new_appoint")
        && !count($formdata['new_appoint'])>0 )    {

        $tmp= $formdata["dest_appoints"]  ? $formdata["dest_appoints"] :  $formdata["new_appoint"]  ;

        $dest_appoints= $formdata['dest_appoints'];

        foreach ($dest_appoints as $key=>$val){

            if(!is_numeric($val)){
                $val=$db->sql_string($val);
                $staff_test[]=$val;

            }elseif(is_numeric($val)){
                $staff_testb[]=$val;

            }

        }



        if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
            $staff=implode(',',$staff_test);

            $sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name_appoint[$row->appointID]=$row->appointName;


                }

        }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){

            $staff=implode(',',$staff_test);

            $sql2="select appointID, appointName from appoint_forum where appointName in ($staff)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name_appoint[$row->appointID]=$row->appointName;


                }


            $staff_b=implode(',',$staff_testb);

            $sql2="select appointID, appointName from appoint_forum where appointID in ($staff_b)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name_appoint_b[$row->appointID]=$row->appointName;


                }

            $name_appoint=array_merge($name_appoint,$name_appoint_b);
            unset($staff_testb);
        }else{


            $staff=implode(',',$formdata['dest_appoints']);

            $sql2="select appointID, appointName from appoint_forum where appointID in ($staff)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    //$name_appoint[$row->appointID]=$row->appointName;
                    $name_appoint[$row->appointID]=$row->appointName;

                }

        }


// $staff=implode(',',$formdata["dest_appoints"]);
//  $sql = "SELECT appointName,appointID FROM appoint_forum WHERE appointID in ($staff) " ;

        //if($rows = $db->queryObjectArray($sql))
        foreach($name_appoint as $key=>$val)
            $appointsIDs[] = $key;

        /*************************************************************************************************************/

    }elseif ($formdata['dest_appoints']!='none' && $formdata['new_appoint']!='none'
        && array_item ($formdata,"new_appoint")
        && count($formdata['new_appoint'])>0
        && array_item ($formdata,"dest_appoints")
        && is_array(array_item ($formdata,"dest_appoints"))    )   {

        $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["dest_appoints"]  ;
        // $usrID=$tmp;
        $i=0;
        foreach($tmp as $usrID){

            $sql="SELECT full_name from users WHERE userID =$usrID";
            if($rows=$db->queryObjectArray($sql))
                $name=$rows[0]->full_name;
            // new manager
            if(!array_item($formdata ,'insert_appoint') && !is_array ($formdata ['insert_appoint'])
                && !is_numeric ($formdata ['insert_appoint'][0]) ){

                $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
            }else{
                $parent=$formdata['insert_appoint'][$i];
                $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
            }
            if(!$db->execute($sql))
                return FALSE;
            $appointsIDs[] = $db->insertId();


            $formdata['dest_appoints']=$formdata['new_appoint'];
            unset($formdata['new_appoint']);
            $i++;
        }
        /*************************************************************************************************************/
    }elseif( ($formdata['dest_appoints']=='none'
            ||( !array_item ($formdata,"dest_appoints") &&  !is_array(array_item ($formdata,"dest_appoints"))   ) )
        && $formdata['new_appoint']!='none'
        && array_item ($formdata,"new_appoint")
        && count($formdata['new_appoint'])>0 )   {

        $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["dest_appoints"]  ;
        $i=0;
        foreach($tmp as $usrID){

            $sql="SELECT full_name from users WHERE userID =$usrID";
            if($rows=$db->queryObjectArray($sql))
                $name=$rows[0]->full_name;
            // new manager
            if(!array_item($formdata ,'insert_appoint') && !is_array ($formdata ['insert_appoint'])
                && !is_numeric ($formdata ['insert_appoint'][0]) ){

                $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
            }else{
                $parent=$formdata['insert_appoint'][$i];
                $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
            }
            if(!$db->execute($sql))
                return FALSE;
            $appointsIDs[] = $db->insertId();

            $formdata['dest_appoints']=$formdata['new_appoint'];
            unset($formdata['new_appoint']);

            $i++;
        }
    }
    return $appointsIDs;
}

/*********************************************SAVE_APPOINT**********************************************************/
function save_appoint(&$formdata) {


    global $db;

    if ($formdata['appoint_forum']=='none' && !array_item ($formdata,"new_appoint")) {
        unset ($formdata['appoint_forum']);
        $tmp="";
        /************************************************************************************************************/

    }elseif ( ($formdata['appoint_forum']!='none'
            ||( array_item ($formdata,"appoint_forum") &&  is_numeric(array_item ($formdata,"appoint_forum"))   ) )
        && !array_item ($formdata,"new_appoint")
        && !is_numeric(array_item ($formdata,"new_appoint"))  )   {

        $tmp= $formdata["appoint_forum"]  ? $formdata["appoint_forum"] :  $formdata["new_appoint"]  ;
        $sql = "SELECT appointName,appointID FROM appoint_forum WHERE appointID = " .
            $db->sql_string($tmp);
        if($rows = $db->queryObjectArray($sql))
            $appointsIDs = $rows[0]->appointID;

        /*************************************************************************************************************/

    }elseif ($formdata['appoint_forum']!='none' && $formdata['new_appoint']!='none'
        && array_item ($formdata,"new_appoint")
        && is_numeric(array_item ($formdata,"new_appoint"))
        && array_item ($formdata,"appoint_forum")
        && is_numeric(array_item ($formdata,"appoint_forum"))    )   {

        $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["appoint_forum"]  ;
        $usrID=$tmp;

        $sql="SELECT full_name from users WHERE userID =$usrID";
        if($rows=$db->queryObjectArray($sql))
            $name=$rows[0]->full_name;
        // new manager
        if(!array_item($formdata ,'insert_appoint') && !is_numeric ($formdata ['insert_appoint']) ){
            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
        }else{
            $parent=$formdata['insert_appoint'];
            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
        }
        if(!$db->execute($sql))
            return FALSE;
        $appointsIDs = $db->insertId();

        $formdata['appoint_forum']=$formdata['new_appoint'];
        unset($formdata['new_appoint']);

        /*************************************************************************************************************/
    }elseif( ($formdata['appoint_forum']=='none'||( !array_item ($formdata,"appoint_forum") &&  !is_numeric(array_item ($formdata,"appoint_forum"))   )  )
        && $formdata['new_appoint']!='none'
        && array_item ($formdata,"new_appoint")
        && is_numeric(array_item ($formdata,"new_appoint")))   {

        $tmp= $formdata["new_appoint"]  ? $formdata["new_appoint"]:$formdata["appoint_forum"]  ;
        $usrID=$tmp;

        $sql="SELECT full_name from users WHERE userID =$usrID";
        if($rows=$db->queryObjectArray($sql))
            $name=$rows[0]->full_name;
        // new appoint
        if(!array_item($formdata ,'insert_appoint') && !is_numeric ($formdata ['insert_appoint']) ){
            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
        }else{
            $parent=$formdata['insert_appoint'];
            $sql = "INSERT INTO appoint_forum (appointName,parentAppointID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
        }

        if(!$db->execute($sql))
            return FALSE;
        $appointsIDs = $db->insertId();

        $formdata['appoint_forum']=$formdata['new_appoint'];
        unset($formdata['new_appoint']);
    }
    return $appointsIDs;
}


/*******************************************************************************************************/
/*************************************************SAVE_MANAGER1*********************************************************************************/
function save_manager1(&$formdata) {


    global $db;

    if ($formdata['dest_managers']=='none' && !array_item ($formdata,"new_manager")) {
        unset ($formdata['dest_managers']);
        $tmp="";
        /************************************************************************************************************/

    }elseif ( ($formdata['dest_managers']!='none' &&  $formdata['dest_managers']!=null
            && ( array_item ($formdata,"dest_managers") &&  is_array(array_item ($formdata,"dest_managers"))   ) )
        && !array_item ($formdata,"new_manager")
        && !count($formdata['new_manager'])>0  )   {

        $tmp= $formdata["dest_managers"]  ? $formdata["dest_managers"] :  $formdata["new_manager"]  ;

        $dest_managers= $formdata['dest_managers'];

        foreach ($dest_managers as $key=>$val){

            if(!is_numeric($val)){
                $val=$db->sql_string($val);
                $staff_test[]=$val;

            }elseif(is_numeric($val)){
                $staff_testb[]=$val;

            }

        }

        if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb ){
            $staff=implode(',',$staff_test);
            $sql="select managerID, managerName from managers where managerName in ($staff)";
            if($rows=$db->queryObjectArray($sql))
                foreach($rows as $row){

                    $name_managers[$row->managerID]=$row->managerName;


                }
        }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
            $staff=implode(',',$staff_test);
            $sql="select managerID, managerName from managers where managerName in ($staff)";
            if($rows=$db->queryObjectArray($sql))
                foreach($rows as $row){

                    $name_managers[$row->managerID]=$row->managerName;
                }


            $staff_b=implode(',',$staff_testb);

            $sql="select managerID, managerName from managers where managerID in ($staff_b)";
            if($rows=$db->queryObjectArray($sql))
                foreach($rows as $row){

                    $name_managers_b[$row->managerID]=$row->managerName;


                }

            $name_managers=array_merge($name_managers,$name_managers_b);
            unset($staff_testb);

        }else{
            $staff=implode(',',$formdata['dest_managers']);

            $sql2="select managerID, managerName from managers where managerID in ($staff)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name_managers[$row->managerID]=$row->managerName;


                }

        }
// $staff=implode(',',$formdata["dest_managers"]);
//  $sql = "SELECT managerName,managerID FROM managers WHERE managerID in ($staff) " ;


        foreach($name_managers as $key=>$val)
            $managersIDs[] = $key;

        /*************************************************************************************************************/

    }elseif ($formdata['dest_managers']!='none' && $formdata['new_manager']!='none'
        && array_item ($formdata,"new_manager")
        && count($formdata['new_manager'])>0
        && array_item ($formdata,"dest_managers")
        && is_array(array_item ($formdata,"dest_managers"))    )   {

        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["dest_managers"]  ;
        // $usrID=$tmp;
        $i=0;
        foreach($tmp as $usrID){

            $sql="SELECT full_name from users WHERE userID =$usrID";
            if($rows=$db->queryObjectArray($sql))
                $name=$rows[0]->full_name;
            // new manager
            if(!array_item($formdata ,'insert_manager') && !is_array ($formdata ['insert_managers'])
                && !is_numeric ($formdata ['insert_manager'][0]) ){

                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
            }else{
                $parent=$formdata['insert_manager'][$i];
                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
            }
            if(!$db->execute($sql))
                return FALSE;
            $managersIDs[] = $db->insertId();

            $formdata['dest_managers']=$formdata['new_manager'];
            unset($formdata['new_manager']);

            $i++;

        }
        /*************************************************************************************************************/
    }elseif( ($formdata['dest_managers']=='none'
            ||( !array_item ($formdata,"dest_managers") &&  !is_array(array_item ($formdata,"dest_managers"))   ))
        && $formdata['new_manager']!='none'
        && array_item ($formdata,"new_manager")
        && count($formdata['new_manager'])>0 )   {

        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["dest_managers"]  ;
        $i=0;
        foreach($tmp as $usrID){

            $sql="SELECT full_name from users WHERE userID =$usrID";
            if($rows=$db->queryObjectArray($sql))
                $name=$rows[0]->full_name;
            // new manager
            if(!array_item($formdata ,'insert_manager') && !is_array ($formdata ['insert_manager'])
                && !is_numeric ($formdata ['insert_manager'][0]) ){

                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID)";
            }else{
                $parent=$formdata['insert_manager'][$i];
                $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                    "VALUES (" . $db->sql_string($name) .   " ,$parent,$usrID )";
            }
            if(!$db->execute($sql))
                return FALSE;
            $managersIDs[] = $db->insertId();

            $formdata['dest_managers']=$formdata['new_manager'];
            unset($formdata['new_manager']);

            $i++;
        }
    }
    return $managersIDs;
}

/**************************************SAVE MANAGER*****************************************************************/

function save_manager(&$formdata) {


    global $db;


    if ($formdata['manager_forum']=='none' && !array_item ($formdata,"new_manager")
        && !is_numeric(array_item ($formdata,"new_manager"))    )   {
        unset ($formdata['manager_forum']);

        $tmp="";//$formdata["manager_forum"]  ? $formdata["manager_forum"] :  $formdata["new_manager"]  ;
        /*************************************************************************************************************/


    }elseif ( ($formdata['manager_forum']!='none'
            ||( array_item ($formdata,"manager_forum") &&  is_numeric(array_item ($formdata,"manager_forum"))   ) )
        && !array_item ($formdata,"new_manager")
        && !is_numeric(array_item ($formdata,"new_manager"))  )   {

        $tmp= $formdata["manager_forum"]  ?$formdata["manager_forum"]: $formdata["new_manager"] ;
        $sql = "SELECT managerName,managerID FROM managers WHERE managerID = " .
            $db->sql_string($tmp);
        if($rows = $db->queryObjectArray($sql))
            $managersIDs = $rows[0]->managerID;

        /*************************************************************************************************************/
    }elseif ($formdata['manager_forum']!='none' && $formdata['new_manager']!='none'
        && array_item ($formdata,"new_manager")
        && is_numeric(array_item ($formdata,"new_manager"))
        && array_item ($formdata,"manager_forum")
        && is_numeric(array_item ($formdata,"manager_forum"))    )   {

        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["manager_forum"]  ;
        $usrID=$tmp;

        $sql="SELECT full_name from users WHERE userID =$usrID";
        if($rows=$db->queryObjectArray($sql))
            $name=$rows[0]->full_name;
        // new manager
        if(!array_item($formdata ,'insert_manager') && !is_numeric ($formdata ['insert_manager']) ){
            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
        }else{

            $parent=$formdata['insert_manager'];


            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " , $parent ,$usrID )";

        }
        if(!$db->execute($sql))
            return FALSE;

        $managersIDs = $db->insertId();

        $formdata['manager_forum']=$formdata['new_manager'];
        unset($formdata['new_manager']);
        /*************************************************************************************************************/
    }elseif( ($formdata['manager_forum']=='none'||( !array_item ($formdata,"manager_forum") &&  !is_numeric(array_item ($formdata,"manager_forum"))   )  )
        && $formdata['new_manager']!='none'
        && array_item ($formdata,"new_manager")
        && is_numeric(array_item ($formdata,"new_manager")))   {

        $tmp= $formdata["new_manager"]  ? $formdata["new_manager"]:$formdata["manager_forum"]  ;
        $usrID=$tmp;

        $sql="SELECT full_name from users WHERE userID =$usrID";
        if($rows=$db->queryObjectArray($sql))
            $name=$rows[0]->full_name;
        // new manager
        if(!array_item($formdata ,'insert_manager') && !is_numeric ($formdata ['insert_manager']) ){
            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " ,'11',$usrID )";
        }else{

            $parent=$formdata['insert_manager'];


            $sql = "INSERT INTO managers (managerName,parentManagerID,userID ) " .

                "VALUES (" . $db->sql_string($name) .   " , $parent ,$usrID )";

        }

        if(!$db->execute($sql))
            return FALSE;

        $managersIDs = $db->insertId();


        $formdata['manager_forum']=$formdata['new_manager'];
        unset($formdata['new_manager']);
    }

    return $managersIDs;
}

/***************************SAVE CATEGORY1****************************************************************************/
/*******************************************************************************************************/

function save_category1(&$formdata) {


    global $db;


    if ($formdata['dest_forumsType']=='none' && !array_item ($formdata,"dest_forumsType") ){
        unset ($formdata['dest_forumsType']);
        $tmp= "";

        /******************************************************************************************************/

    }elseif ( ($formdata['dest_forumsType']!='none' &&  $formdata['dest_forumsType']!=null
            && ( array_item ($formdata,"dest_forumsType") &&  is_array(array_item ($formdata,"dest_forumsType"))   ) )
        && (!array_item ($formdata,"new_category")
            ||  ($formdata["new_category"]=='none' )
            ||  $formdata["new_category"]==null )  )   {


        $tmp= $formdata["dest_forumsType"]  ? $formdata["dest_forumsType"] :  $formdata["new_category"]  ;


        $dest_forumsType= $formdata['dest_forumsType'];

        foreach ($dest_forumsType as $key=>$val){
            if(!is_numeric($val)){
                $val=$db->sql_string($val);
                $staff_test[]=$val;
            }elseif(is_numeric($val) ){
                $staff_testb[]=$val;
            }
        }
        if(is_array($staff_test) && !is_array($staff_testb) && !$staff_testb  ){
            $staff=implode(',',$staff_test);

            $sql2="select catID, catName from categories1 where catName in ($staff)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name[$row->catID]=$row->catName;


                }

        }elseif(is_array($staff_test) && is_array($staff_testb) && $staff_testb ){
            $staff=implode(',',$staff_test);

            $sql2="select catID, catName from categories1 where catName in ($staff)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name[$row->catID]=$row->catName;


                }
            $staffb=implode(',',$staff_testb);

            $sql2="select catID, catName from categories1 where catID in ($staffb)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name_b[$row->catID]=$row->catName;
                }
            $name=array_merge($name,$name_b);
            unset($staff_testb);
        }else{
            $staff=implode(',',$formdata['dest_forumsType'])	;

            $sql2="select catID, catName from categories1 where catID in ($staff)";
            if($rows=$db->queryObjectArray($sql2))
                foreach($rows as $row){

                    $name[$row->catID]=$row->catName;
                    //$name[]=$row->catName;

                }
        }


// $staff=implode(',',$tmp);
//			  $sql = "SELECT  catName,catID,parentCatID FROM categories1 WHERE catID in ($staff)  " ;


        foreach($name as $key=>$val)
            $catsIDs []= $key;

        /*************************************************************************************************************/
    }elseif ($formdata['dest_forumsType']!='none'  &&  $formdata['dest_forumsType']!=null && trim($formdata['new_category']!='none')
        && array_item ($formdata,"new_category")
        && count($formdata['new_category'])>0
        && array_item ($formdata,"dest_forumsType"))   {

        $tmp= $formdata["new_category"]  ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
        $catNames=explode(';',$tmp);



        $i=0;
        foreach($catNames as $catName){
            if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category'][0]) ){
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($catName) . " , '11')";

            }else{
                $parent=$formdata['insert_category'][$i];
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
            }


            if(!$db->execute($sql))
                return FALSE;
            $catsIDs[] = $db->insertId();



            $i++;
        }
        $formdata['dest_forumsType']=$catsIDs;
        unset($formdata['new_category']);
        /*************************************************************************************************************/
    }elseif( ($formdata['dest_forumsType']=='none' || $formdata['dest_forumsType']==null
            ||( !array_item ($formdata,"dest_forumsType") &&  !is_numeric(array_item ($formdata,"dest_forumsType"))   )  )
        && $formdata['new_category']!='none'
        && $formdata['new_category']!=null
        && count($formdata['new_category'])>0
        && array_item ($formdata,"new_category"))   {



        $tmp= $formdata["new_category"]  ? $formdata["new_category"]:$formdata["dest_forumsType"]  ;
        $catNames=explode(';',$tmp);



        $i=0;
        foreach($catNames as $catName){
            if(!array_item($formdata ,'insert_category') && !is_numeric ($formdata ['insert_category'][0]) ){
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($catName) . " , '11')";

            }else{
                $parent=$formdata['insert_category'][$i];
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
            }


            if(!$db->execute($sql))
                return FALSE;
            $catsIDs[] = $db->insertId();

            $formdata['dest_forumsType']=$formdata['new_category'];
            unset($formdata['new_category']);

            $i++;
        }

        $formdata['dest_forumsType']=$catsIDs;
        unset($formdata['new_category']);


    }
    return $catsIDs;
}


/**************************************************save_category_ajx**********************************************************/
function save_category_ajx(&$formdata) {


    global $db;


    if ( ($formdata['dest_forumsType']!='none'
            ||( array_item ($formdata,"dest_forumsType") &&  is_array($formdata['dest_forumsType'] )   ) )
        && !array_item ($formdata,"new_forumType")
        && !is_numeric(array_item ($formdata,"new_forumType"))  )   {


        $tmp= $formdata["dest_forumsType"]  ;
        foreach($tmp as $key=>$val){

            $catsIDs[]=$val;
        }



        if(is_array($formdata['insert_forumType']) && is_numeric($formdata['insert_forumType'][0]) && $formdata['insert_forumType']!='none' ){
            $i=0;
            $count_insert=count($formdata['insert_forumType']);
            foreach($catsIDs as $id){
                $parent=$formdata['insert_forumType'][$i];
                $sql = "update categories1 set  parentCatID=$parent WHERE catID=$id"  ;

                if(!$db->execute($sql))
                    return FALSE;
                $i++;

                if($i==$count_insert){
                    $i=$count_insert-1;
                }
            }

        }





        $formdata['dest_forumsType']=$catsIDs;
        /*************************************************************************************************************/
    }elseif (is_array($formdata['dest_forumsType'])  && trim($formdata['new_forumType']!='none')
        && array_item ($formdata,"new_forumType")
        && !is_numeric(array_item ($formdata,"new_forumType"))
        && array_item ($formdata,"dest_forumsType")    )   {

        $tmp= $formdata["new_forumType"] ;// ? $formdata["new_forumType"]:$formdata["dest_forumsType"]  ;


        $catForumNames=explode(';',$tmp);



        $i=0;
        foreach($catForumNames as $catName){

            if(!array_item($formdata ,'insert_forumType') && !is_numeric ($formdata ['insert_forumType']) ){
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($tmp) . " , '11')";

            }else{
                $count_insert=count($formdata['insert_forumType']);
                $parent=$formdata['insert_forumType'][$i];
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
            }
            if(!$db->execute($sql))
                return FALSE;
            $catsIDs []= $db->insertId();

            if($formdata['dest_forumsType'])
                unset($formdata['dest_forumsType']);

            $formdata['dest_forumsType'][0]=$catsIDs;

            $i++;

            if($count_insert && $i==$count_insert){
                $i=$count_insert-1;
            }
        }


        $formdata['dest_forumsType']=$catsIDs;
        unset($formdata['new_forumType']);
        /*************************************************************************************************************/
    }elseif( ( !is_array($formdata['dest_forumsType']) || ( !array_item ($formdata,"dest_forumsType")    )  )
        && $formdata['new_forumType']!='none'
        && array_item ($formdata,"new_forumType")
        && !is_numeric(array_item ($formdata,"new_forumType")))   {



        $tmp= $formdata["new_forumType"] ;// ? $formdata["new_forumType"]:$formdata["dest_forumsType"]  ;


        $catForumNames=explode(';',$tmp);



        $i=0;
        foreach($catForumNames as $catName){

            if(!array_item($formdata ,'insert_forumType') && !is_numeric ($formdata ['insert_forumType']) ){
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($tmp) . " , '11')";

            }else{
                $count_insert=count($formdata['insert_forumType']);
                $parent=$formdata['insert_forumType'][$i];
                $sql = "INSERT INTO categories1 (catName,parentCatID) " .
                    "VALUES (" . $db->sql_string($catName) . " , $parent)";
            }
            if(!$db->execute($sql))
                return FALSE;
            $catsIDs[] = $db->insertId();

            if($formdata['dest_forumsType'])
                unset($formdata['dest_forumsType']);

            $formdata['dest_forumsType'][0]=$catsIDs;

            $i++;

            if($count_insert && $i==$count_insert){
                $i=$count_insert-1;
            }

        }


        $formdata['dest_forumsType']=$catsIDs;
        unset($formdata['new_forumType']);

    }




    return $catsIDs;
}


/***************************SAVE MANAGERTYPE_ajx****************************************************************************/


function save_managerType_ajx(&$formdata) {


    global $db;



    if ( ($formdata['dest_managersType']!='none'
            ||( array_item ($formdata,"dest_managersType") &&  is_array($formdata['dest_managersType'] )   ) )
        && !array_item ($formdata,"new_managerType")
        && !is_numeric(array_item ($formdata,"new_managerType"))  )   {


        $tmp= $formdata["dest_managersType"]  ;
        foreach($tmp as $key=>$val){


            $catTypeIDs[]=$val;
        }



        if(is_array($formdata['insert_managerType']) && is_numeric($formdata['insert_managerType'][0]) &&  $formdata['insert_managerType']!='none' ){
            $i=0;
            $count_insertMgr=count($formdata['insert_managerType']);
            foreach($catTypeIDs as $id){
                $parent=$formdata['insert_managerType'][$i];

                $sql = "update manager_type set  parentManagerTypeID=$parent  WHERE managerTypeID=$id"  ;

                if(!$db->execute($sql))
                    return FALSE;

                $i++;

                if($i==$count_insertMgr){
                    $i=$count_insertMgr-1;
                }

            }

        }



        $formdata['dest_managersType']=$catTypeIDs;
