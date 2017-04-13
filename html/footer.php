	
			
			<p><br clear="all" /></p>
		</div>
		<!-- END CONTENT -->
		
  
		<div class="sidebar" >	
			
			<!-- SIDEBAR -->

			
<?php // Show the user info or the login form:
 global $dbc;
  global $db;
 $_SESSION['level']=isset($_SESSION['level'])?(string)$_SESSION['level']:'';

 if (isset($_SESSION['userID']) ||  ($_SESSION['level'] =='user') ||  ($_SESSION['level'] =='admin') ) {
$_SESSION['userID']=isset($_SESSION['userID'])?(int)$_SESSION['userID']:0;
 	$id=$_SESSION['userID'];
if  (isset($_SESSION['userID']) &&  ($_SESSION['level'] =='user')){
 	
	echo '<div class="title">
				<h4>ניהול חשבון אישי</h4>
			</div>
			<ul>
			 <li><a href="'.ROOT_WWW.'/admin/get_intoSystem.php?userID='.$id.'" >כניסה לאתר</a></li>
			 <li><a href="index.php?mode=renew" title="Renew Your Account">חדש חשבון</a></li>
			<li><a href="index.php?mode=change_password" title="Change Your Password">שנה סיסמה</a></li>
			<li><a href="index.php?mode=favorites" title="צפה בדפים המועדפים">מועדפים</a></li>
			<li><a href="index.php?mode=history" title="View Your History">היסטוריה</a></li>
			<li><a href="javascript:void(0)" title="View Your Recommendations">המלצות</a></li>
			<li><a href="index.php?mode=logout" title="Logout">התנתק</a></li>
			</ul>';
}elseif(isset($_SESSION['userID']) &&  ($_SESSION['level'] =='admin')){
	
$sql="select managerID from managers where userID=$id";
	if($rows=$db->queryObjectArray($sql)){
		$managerID=$rows[0]->managerID;
	
	echo '<div class="title">
				<h4>ניהול חשבון אישי</h4>
			</div>
			<ul>
			 <li><a href="'.ROOT_WWW.'/admin/get_intoSystem.php?managerID='.$managerID.'" >כניסה לאתר</a></li>
			 <li><a href="index.php?mode=renew" title="Renew Your Account">חדש חשבון</a></li>
			<li><a href="index.php?mode=change_password" title="Change Your Password">שנה סיסמה</a></li>
			<li><a href="index.php?mode=favorites" title="צפה בדפים המועדפים">מועדפים</a></li>
			<li><a href="index.php?mode=history" title="View Your History">היסטוריה</a></li>
			<li><a href="javascript:void(0)" title="View Your Recommendations">המלצות</a></li>
			<li><a href="index.php?mode=logout" title="Logout">התנתק</a></li>
			</ul>';
	
  }else{
  	 echo '<div class="title">
				<h4>ניהול חשבון אישי</h4>
			</div>
			<ul>
			 <li><a href="'.ROOT_WWW.'/admin/get_intoSystem.php" >כניסה לאתר</a></li>
			 <li><a href="index.php?mode=renew" title="Renew Your Account">חדש חשבון</a></li>
			<li><a href="index.php?mode=change_password" title="Change Your Password">שנה סיסמה</a></li>
			<li><a href="index.php?mode=favorites" title="צפה בדפים המועדפים">מועדפים</a></li>
			<li><a href="index.php?mode=history" title="View Your History">היסטוריה</a></li>
			<li><a href="javascript:void(0)" title=" ">   המלצות</a></li>
			<li><a href="index.php?mode=logout" title="Logout">התנתק</a></li>
			</ul>';
  	
  	 //title="צפה בהמלצות" 
  }
}	
if (isset($_SESSION['user_admin']) ||   ($_SESSION['level'] =='admin') ||  ($_SESSION['level'] =='suppervizer') ) {
		echo '<div class="title">
					<h4>אדמינסטרצייה</h4>
				</div>
				<ul id="my_admin_ul">
				<li><a  class="my_href_li"  href="index.php?mode=add_blog" title="Add a Page">הוסף/ערוך דף-בלוג</a></li>
				<li><a  class="my_href_li" href="index.php?mode=add_page" title="Add a Page">הוסף דף</a></li>
				<li><a  class="my_href_li" href="index.php?mode=add_pdf" title="Add a PDF">PDF הסף קבצי-</a></li>
				<li><a  class="my_href_li"  href="index.php?mode=edit_forums" title="Add a Page">הוסף/ערוך פורומים</a></li>
			    <li><a  class="my_href_li" href="index.php?mode=add_polls" title="Add a polls">ערוך סקר שאלות-</a></li>
			     <li><a  class="my_href_li" href="index.php?mode=edit_web" title="Add a polls">ערוך דפים באתר-</a></li>
			     <li><a  class="my_href_li" href="index.php?mode=edit_web_win" title="Add a polls">ערוך דפים בחלון לאתר-</a></li>
			    </ul>';		
		//<li><a  class="my_href_li"  href="index.php?mode=add_msgForum" title="Add a Page">הוסף/ערוך פורומים</a></li>
	}
					
} else { // Show the login form:
	
	//require ('includes/login_form.inc.php');
	require_once  (LIB_DIR.'/login_form.inc.php'); 
	
}
?>


			<div class="title" id="foter_title">
				<h4>תוכן העיניינים</h4>
			</div>
			
<h5 class="my_h5_content"  style=" height:15px"></h5>
<div id="div_content">	
<ul>
<li ><a class="my_href_li" href="index.php?mode=view_blogs" title="BLOG Guides"> השתתף בבלוג </a></li>
<li ><a class="my_href_li" href="index.php?mode=view_forums" title="FORUM Guides"> שלח הודעות/השתתף בפורומים </a></li>
<li ><a class="my_href_li" href="index.php?mode=pdfs" title="PDF Guides"> PDF - צפה בקבציי </a></li>
<li ><a class="my_href_li" href="index.php?mode=view_polls" title="VOTE Guides"> צפה/הצבע לסקר </a></li>

<?php 
//	include(MYSQL);
$q = 'SELECT * FROM categories_page ORDER BY category';
if($dbc){
$r = mysqli_query($dbc, $q);

while (list($id, $category) = mysqli_fetch_array($r, MYSQLI_NUM)) {
//echo '<li><a href="category.php?id=' . $id . '" title="' . $category . '"  class="my_href_li2"  >' . $category . '</a></li>';
echo '<li><a href="index.php?mode=category&id=' . $id . '" title="' . $category . '"  class="my_href_li2"  >' . $category . '</a></li>';

 }
}
?>
			
</ul></div>



<?php 
 if (!(isset($_SESSION['userID'])) &&  !(($_SESSION['level'] =='user')) &&  !(($_SESSION['level'] =='admin'))  ) {
?>
    <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/dhtmlwindow.css"  />
<!--      <link rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_DIR ?>/form.css"  /> -->
      <link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_DIR ?>/resulttable.css" /> 
   <link rel="stylesheet" type="text/css" media="all"    href="<?php echo CSS_DIR ?>/paginated.css" />
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/find_pagination.js"      charset="utf-8"       type="text/javascript"></script>
   <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery.pager.js"           charset="utf-8"     type="text/javascript"></script> 
    <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/dhtmlwindow2.js"  charset="utf-8"   type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/401.js"    type="text/javascript"></script>


           <div class="title" id="foter_title2">
				<h4>צפייה בקטגוריות</h4>
			</div>
<h5 class="my_h5_content2"  style=" height:15px"></h5>
<div id="div_content2">	
<ul>

<?php 


$sql = 'SELECT * FROM categories ORDER BY catName';
if($rows=$db->queryObjectArray($sql)){
foreach ($rows as $row){
   echo '<li class="my_li_cat"><a  class="my_href_li"  href="javascript:void(0)"   OnClick= "return  openmypage3(\''.ROOT_WWW.'/admin/find3.php?catID=' . $row->catID . '\');this.blur();return false;">' . $row->catName . '</a></li>';

    }
  }

?>
			
</ul></div>

<?php }?>







	
		</div>
		
		<div class="footer" id="my_footer">

			<p><a href="javascript:void(0)" title="">קיבוץ עין השופט</a> | <a href="javascript:void(0)" title="">כללים</a> &nbsp; - &nbsp; &copy;  &nbsp; - &nbsp; עוצב ע"י <a href="javascript:void(0)">אלון מור</a></p> 
		</div>	
	</div>
</div>
</body>
</html>

<?php ?>