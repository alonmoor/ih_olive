<?php
class User
{
	
	  // Permission levels
    const CREATE_FORUM = 2;
    const MOVE_MESSAGE = 4;
    const DELETE_MESSAGE = 8; 
    const DELETE_FORUM = 16;
	
	
    private $userID;     // user id
    private $fields;  // other record fields

    // initialize a User object
    public function __construct()
    {
        $this->userID = null;
        $this->fields = array('full_name' => '',
                              'lname' => '',
                              'fname' => '',
                              'uname' => '', 
                              'upass' => '',
                              'upass2' => '', 
                              'email' => '',
                              'user_date' => '',
                              'phone_num'=>'',
                              'active' => false,
                              'permission' => 0 ,
                               'row_num' => '',
                              'row' => ''  );
    }

    // override magic method to retrieve properties
    public function __get($field)
    {
        if ($field == 'userID')
        {
            return $this->userID;
        }
        else 
        {
            return $this->fields[$field];
        }
    }

    // override magic method to set properties
    public function __set($field, $value)
    {
        if (array_key_exists($field, $this->fields))
        {
            $this->fields[$field] = $value;
        }
    }

    // return if username is valid format
    public static function validateUsername($username)
    {
        return preg_match('/^[A-Z0-9]{2,20}$/i', $username);
    }
    
    // return if email address is valid format
    public static function validateEmailAddr($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    // return an object populated based on the record's user id
    public static function getById($userID)
    {
        $u = new User();

        $query = sprintf('SELECT fname,lname,active,upass,permission ,uname, user_date,email, full_name,phone_num ' .
            'FROM %susers WHERE userID = %d',
            DB_TBL_PREFIX,
            $userID);
        $result = mysql_query($query, $GLOBALS['DB']);

        if (mysql_num_rows($result))
        {
            $row = mysql_fetch_assoc($result);
            $u->fname = $row['fname'];
            $u->lname = $row['lname'];
            $u->active = $row['active'];
            $u->upass = $row['upass'];
            $u->permission = $row['permission'];
            $u->uname = $row['uname'];
            $u->user_date = $row['user_date'];
            $u->email = $row['email'];
            $u->full_name = $row['full_name'];
            $u->phone_num = $row['phone_num'];
           
            
             $u->userID = $userID;
            
        }
        mysql_free_result($result);

        return $u;
    }

    // return an object populated based on the record's username
    public static function getByUsername($username)
    {
        $u = new User();

        $query = sprintf('SELECT userID,uname,fname,lname,active,upass,upass2,permission ,user_date,email, full_name,phone_num ' .
            ' FROM  %susers WHERE uname = "%s" ',
            DB_TBL_PREFIX,
            mysql_real_escape_string($username, $GLOBALS['DB']));
        $result = mysql_query($query, $GLOBALS['DB']);

        
        
        
        if ($rows=mysql_num_rows($result))
        {
            $row = mysql_fetch_assoc($result);
            $u->uname = $username;
            $u->fname = $row['fname'];
            $u->lname = $row['lname'];
            $u->active = $row['active'];
            $u->upass = $row['upass'];
            $u->upass2 = $row['upass2'];
            $u->permission = $row['permission'];
          
            $u->user_date = $row['user_date'];
            $u->email = $row['email'];
            $u->full_name = $row['full_name'];
            $u->phone_num = $row['phone_num'];
            $u->userID = $row['userID'];
            $u->row_num=$rows;
            $u->row=$row;
        }
       
        mysql_free_result($result);
        return $u;
    }

    // save the record to the database
    public function save()
    {
        if ($this->userID)
        {
            $query = sprintf('UPDATE %users SET uname = "%s", ' .
                'upass = "%s",upass2 = "%s", email = "%s", active = %d ,' .
                'permission = %d  WHERE userID = %d',
                DB_TBL_PREFIX,
                mysql_real_escape_string($this->uname, $GLOBALS['DB']),
                mysql_real_escape_string($this->upass, $GLOBALS['DB']),
                mysql_real_escape_string($this->email, $GLOBALS['DB']),

                $this->active,
                $this->permission,
                $this->userID);
            mysql_query($query, $GLOBALS['DB']);
        }
        else
        { 

        
        $query = sprintf('INSERT INTO  users (uname,upass,upass2,fname,lname ,   user_date, full_name,phone_num ,email, ' .
                ' active,permission) VALUES ("%s","%s","%s","%s","%s",   "%s","%s", "%s","%s",   %d,%d)',
                
                mysql_real_escape_string($this->uname, $GLOBALS['DB']),
                 mysql_real_escape_string($this->upass, $GLOBALS['DB']),
                 mysql_real_escape_string($this->upass2, $GLOBALS['DB']),
                mysql_real_escape_string($this->fname, $GLOBALS['DB']),
                mysql_real_escape_string($this->lname, $GLOBALS['DB']),
               
                mysql_real_escape_string($this->user_date, $GLOBALS['DB']),
                mysql_real_escape_string($this->full_name, $GLOBALS['DB']),
                mysql_real_escape_string($this->phone_num, $GLOBALS['DB']),
                mysql_real_escape_string($this->email, $GLOBALS['DB']),
                
                
                $this->active,
                $this->permission);

                
                mysql_query($query, $GLOBALS['DB']);

            $this->userID = mysql_insert_id($GLOBALS['DB']);
             
        }
    }

    // set the record as inactive and return an activation token
    public function setInactive()
    {
        $this->active = false;
        $this->save(); // make sure the record is saved

        $token = random_text(5);
        $query = sprintf('INSERT INTO %sPENDING (userID, TOKEN) ' . 
            'VALUES (%d, "%s")',
            DB_TBL_PREFIX,
            $this->userID,
            $token);
        mysql_query($query, $GLOBALS['DB']);

        return $token;
    }

    // clear the user's pending status and set the record as active
    public function setActive($token)
    {
        $query = sprintf('SELECT TOKEN FROM %sPENDING WHERE userID = %d ' . 
            'AND TOKEN = "%s"',
            DB_TBL_PREFIX,
            $this->userID,
            mysql_real_escape_string($token, $GLOBALS['DB']));
        $result = mysql_query($query, $GLOBALS['DB']);

        if (!mysql_num_rows($result))
        {
            mysql_free_result($result);
            return false;
        }
        else
        {
            mysql_free_result($result);
            $query = sprintf('DELETE FROM %sPENDING WHERE userID = %d ' .
                'AND TOKEN = "%s"', DB_TBL_PREFIX,
                $this->userID,
                mysql_real_escape_string($token, $GLOBALS['DB']));
            mysql_query($query, $GLOBALS['DB']);

            $this->active = true;
            $this->save();
            return true;
        }
    }
    
/**************************************************************************************/
public function conn(){
	global $dbc;
    global $db;

?>

<fieldset dir="rtl"  style="overflow:auto; background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים הבאים</legend>
 <table>
	
<?PHP 
if(is_array($_SESSION) && $_SESSION!='undefined')	  
if(array_key_exists('level',$_SESSION)){	
  if (($_SESSION['level']=='admin')){?>
 	<tr><td><strong class="bgchange_login" >  היתחברת כ- מנהל אם שם משתמש   <?  echo $_SESSION['uname'];  ?> 
 	
	
	<? }elseif(($_SESSION['level'])=='user'){ ?>	
</strong></td></tr>		 
<tr>
  <td><strong class="bgchange_login" > 
     היתחברת כ- משתמש אם שם משתמש     <?  echo  $_SESSION['uname'];  ?>  
     </strong>	
  </td>
</tr>
 <input type="hidden" id="flag_level_usr" name="flag_level_usr" value="<?php echo $_SESSION['level'];?>" />    
	<? }elseif(($_SESSION['level'])=='suppervizer'){ ?>  
<tr>
   <td><strong class="bgchange_login" > 
    היתחברת כ- מפקח אם שם משתמש  . <?  echo   $_SESSION['uname'];   ?> 
   </strong></td>
</tr>
     
	
	
	<? }elseif(($_SESSION['level'])=='user_admin'){ ?>  
<tr>
  <td> <strong class="bgchange_login" >
    היתחברת כ-מנהל+משתמש אם שם משתמש   <?  echo $_SESSION['uname'];   ?>      
  </strong></td>
</tr>
     
<?PHP
    }else{
    	
    ?>
   	<input type="hidden" id="flag_level_usr" name="flag_level_usr" value="not_login" /> 
   	<?php 
    	
    }

}





echo '<tr><td>';
echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">דפים הכי פופולרים!!!</h4>';	
$q = "SELECT COUNT(history.id) AS num, pages.id, pages.title FROM pages, history WHERE pages.id=history.page_id AND history.type='page' GROUP BY (history.page_id) ORDER BY num DESC LIMIT 10";
$r = mysqli_query($dbc, $q);
$n = 1; // Counter

while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
	

	echo "<h4>$n. <a href=\"index.php?mode=page&id=$row[1]\"  class='my_href_li' >$row[2]</a></h4>\n";
	

	$n++;

} // End of WHILE loop.
echo '</td></tr>';





/*********************************************************************************************/
/*********************************************************************************************/
echo  '<tr><td>';

if (isset($_SESSION['user_not_expired'])) {
$userID=$_SESSION['userID'];
	$sql1 = "SELECT user_id FROM favorite_pages WHERE user_id= $userID " ;
$sql = "SELECT  pages.id, pages.title FROM pages, favorite_pages WHERE pages.id=favorite_pages.page_id
      AND favorite_pages.user_id=$userID
      GROUP BY (favorite_pages.page_id) ORDER BY favorite_pages.page_id DESC LIMIT 10";
	
		if($rows=$db->queryObjectArray($sql)) {
		//echo '<h3 class="bgchange_login" style="font-weight:bold;color:green;">המועדפים שלך!!!</h3>';	
		echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">המועדפים שלך!!!</h4>';	
		$n = 1;	
		foreach($rows as $row){	
			
		echo "<h4> $n.<img src='".ROOT_WWW."/images/in_out/heart_48.png' border='0' width='48' height='48' align='middle' />
		       <a href=\"index.php?mode=page&id=' . $row->id . '\"  class='my_href_li' >
		      $row->title
		      </a>
		     
		     להסרה! 
			<a href='index.php?mode=remove_from_favorite&id=" . $row->id . "'  >
			<img src='".ROOT_WWW."/images/in_out/cross_48.png' border='0' width='48' height='48' align='middle' style='overflow:hidden;' />
		    </a></h4>\n";	
			
			
		$n ++;
		}	
			
		} else {
			echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">אין לך דפים מועדפים!!!</h4>';	
		}
}

echo  '</td></tr>';
/*********************************************************************************************/
/*********************************************************************************************/
echo '<tr><td>';
if (isset($_SESSION['user_not_expired'])) {

echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">עידכונים אחרונים!!!</h4><p>';

$q = "SELECT ROUND(AVG(rating),1) AS average, pages.id, pages.title FROM pages, page_ratings WHERE pages.id=page_ratings.page_id GROUP BY (page_ratings.page_id) ORDER BY average DESC LIMIT 10";
$r = mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {


	echo "<h4>$row[0]. <a href=\"index.php?mode=page&id=$row[1]\">$row[2]</a></h4>\n";

} 


//echo '</p></td></tr>';
}else{
	
   echo '<h4 style="background:white;font-weight:bold;font-size:1.5em;color:green;">הירשם/היתחבר כדי לראות עידכונים אחרונים!!!</h4>';
}
echo '</td></tr></table></fieldset>'; 
 
 
}
/**************************************************************************************/
public function call2us(){
   	
global $db; 
global $dbc;   
 $page_title = 'Talk2us';
 
$reg_errors = array();


 
  
 require_once (LIB_DIR ."/form_functions.inc.php");
?><h3>פינה לתגובה</h3>

<form action="talk2us.php" method="post" accept-charset="utf-8"   dir="rtl" >

		<div>	 
			
			<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
				<legend>שלח תגובה</legend>
<!--				<form action="#" method="get">-->
					<p><label for="name" style="font-weight:bold;color:brown;">שם:</label><br />

					<input type="text" name="name" id="name" value="" /><br /></p>
	
					<p><label for="email" style="font-weight:bold;color:brown;">דואר אלקטרוני:</label><br />
	
					<input type="text" name="email" id="email" value="" /><br /></p>
					<p><label for="message" style="font-weight:bold;color:brown;">הודעה:</label><br />
	
					<textarea cols="60" rows="11" name="message" id="message" style="width:350px;"></textarea><br /></p>
					<p><input type="submit" name="send"   value="שלח" style="font-weight:bold;color:brown;" /></p>
<!--				</form>-->

			</fieldset>
			
			
		</div>
		
		
			
	
</form>

<?php  

	
}	
/**************************************************************************************/
/*******************************************************************************/

function home_page(){
global $dbc;	
global $db;
?>

<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים הבאים</legend>
 <table>
	 <table class="table">

<?PHP  
if(is_array($_SESSION) && $_SESSION!='undefined')	  
if(array_key_exists('level',$_SESSION)){	
  if (($_SESSION['level']=='admin')){?>
 	<tr><td><strong class="bgchange_login" >  היתחברת כ- מנהל אם שם משתמש   <?  echo $_SESSION['uname'];  ?> 
 	
	
	<? }elseif(($_SESSION['level'])=='user'){ ?>	
</strong></td></tr>		 
<tr>
  <td><strong class="bgchange_login" > 
     היתחברת כ- משתמש אם שם משתמש     <?  echo  $_SESSION['uname'];  ?>  
     </strong>	
  </td>
</tr>
    
	<? }elseif(($_SESSION['level'])=='suppervizer'){ ?>  
<tr>
   <td><strong class="bgchange_login" > 
    היתחברת כ- מפקח אם שם משתמש  . <?  echo   $_SESSION['uname'];   ?> 
   </strong></td>
</tr>
     
	
	
	<? }elseif(($_SESSION['level'])=='user_admin'){ ?>  
<tr>
  <td> <strong class="bgchange_login" >
    היתחברת כ-מנהל+משתמש אם שם משתמש   <?  echo $_SESSION['uname'];   ?>      
  </strong></td>
</tr>
     
<?PHP
   } 

}


echo '<tr><td>';
echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">דפים הכי פופולרים!!!</h4>';	
$q = "SELECT COUNT(history.id) AS num, pages.id, pages.title FROM pages, history WHERE pages.id=history.page_id AND history.type='page' GROUP BY (history.page_id) ORDER BY num DESC LIMIT 10";
$r = mysqli_query($dbc, $q);
$n = 1; // Counter

while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
	

	echo "<div id='my_favorites_div'><h4>$n. <a href=\"index.php?mode=page&id=$row[1]\"  class='my_href_li' >$row[2]</a></h4></div>\n";
	

	$n++;

} // End of WHILE loop.
echo '</td></tr>';




/*********************************************************************************************/
echo  '<tr><td>';

if (isset($_SESSION['user_not_expired'])) {
$userID=$_SESSION['userID'];
	$sql1 = "SELECT user_id FROM favorite_pages WHERE user_id= $userID " ;
$sql = "SELECT  pages.id, pages.title FROM pages, favorite_pages WHERE pages.id=favorite_pages.page_id
      AND favorite_pages.user_id=$userID
      GROUP BY (favorite_pages.page_id) ORDER BY favorite_pages.page_id DESC LIMIT 10";
	
		if($rows=$db->queryObjectArray($sql)) {
		//echo '<h3 class="bgchange_login" style="font-weight:bold;color:green;">המועדפים שלך!!!</h3>';	
		echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">המועדפים שלך!!!</h4>';	
		$n = 1;	
		foreach($rows as $row){	
			$id=$row->id;
		echo "<h4> $n.<img src='".ROOT_WWW."/images/in_out/heart_48.png' border='0' width='48' height='48' align='middle' />
		       <a href=\"index.php?mode=page&id=$id\"  class='my_href_li' >
		      $row->title
		      </a>
		     
		     להסרה! 
			<a href='index.php?mode=remove_from_favorite&id=$id'  >
			<img src='".ROOT_WWW."/images/in_out/cross_48.png' border='0' width='48' height='48' align='middle' style='overflow:hidden;' />
		    </a></h4>\n";	
			
			
		$n ++;
		}	
			
		} else {
			echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">אין לך דפים מועדפים!!!</h4>';	
		}
}else{
	
   echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">הירשם כדי לראות דפים מועדפים!!!</h4>';
}

echo  '</td></tr>';
/*********************************************************************************************/
echo '<tr><td>';
if (isset($_SESSION['user_not_expired'])) {

echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">עידכונים אחרונים!!!</h4><p>';

$q = "SELECT ROUND(AVG(rating),1) AS average, pages.id, pages.title FROM pages, page_ratings WHERE pages.id=page_ratings.page_id GROUP BY (page_ratings.page_id) ORDER BY average DESC LIMIT 10";
$r = mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {


	echo "<h4>$row[0]. <a href=\"index.php?mode=page&id=$row[1]\">$row[2]</a></h4>\n";

} 


//echo '</p></td></tr>';
}else{
	
   echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">הירשם כדי לראות עידכונים אחרונים!!!</h4>';
}
echo '</td></tr></table></fieldset>';
}//end function

/**********************************************************************************************************************************/
function category(){
global $dbc;	
echo '<fieldset dir="rtl"  style="color:white; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >';	
if (filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

 
	$q = 'SELECT category FROM categories_page WHERE id=' . $_GET['id'];
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) != 1) { // Problem!
		$page_title = 'Error!';
		 
		echo '<p class="error">.בדף זה נוצרו בעיות</p>';
		
		 
		exit();
	}
	
	// Fetch the category title and use it as the page title:
	list ($page_title) = mysqli_fetch_array($r, MYSQLI_NUM);
	 
	echo "<h3 style='font-weight:bold;color:yellow;'>$page_title</h3>";
	
	// Print a message if they're not an active user:
	// Change the message based upon the user's status:
	if (isset($_SESSION['userID']) && !isset($_SESSION['user_not_expired'])) {
		echo '<p class="error">!תודה שאתה מיתעניין על חומר באתר אך כדי לצפות בתוכן עליך להירשם <a href="index.php?mode=sighn_in"   class="my_href_li">צור חשבון</a> במטרה להיכנס לאתר</p>';
	} elseif (!isset($_SESSION['userID'])) {
		echo '<p class="error">!תודה שאתה מיתעניין על חומר באתר אך כדי לצפות בתוכן עליך להירשם</p>';
	}

	// Get the pages associated with this category:
	$q = 'SELECT id, title, description FROM pages WHERE category_id=' . $_GET['id'] . ' ORDER BY date_created DESC';
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) > 0) { // Pages available!
		
		// Fetch each record:
		while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

			// Display each record:
			//echo "<div><h4><a href=\"page.php?id={$row['id']}\">{$row['title']}</a></h4><p>{$row['description']}</p></div>\n";
			echo "<div><h4><a href=\"index.php?mode=page&id={$row['id']}\" class='my_href_li'>{$row['title']}</a></h4><p style='font-weight:bold;color:brown;'>{$row['description']}</p></div>\n";

		} // End of WHILE loop.
		
	} else { // No pages available.
		echo '<p>כרגע אין דפיי תוכן שמשויכים לקטגורייה הזואת!</p>';
	}

} else { // No valid ID.
	$page_title = 'Error!';
	//include ('./includes/header.php');
	echo '<p class="error">נוצרה טעות בדף הזה!</p>';
} // End of primary IF.
	
echo '</fieldset>';	
}

/*****************************************************************************************************/
/*****************************************************************************************************/
function my_page(){
global $dbc;

echo '<fieldset dir="rtl"  style="text-color:white; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >';
// Validate the category ID:
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

	// Get the page info:
	$q = 'SELECT title, description, content FROM pages WHERE id=' . $_GET['id'];
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) != 1) { // Problem!
		$page_title = 'Error!';
		
		echo '<p class="error">.בדף זה נוצרו בעיות</p>';
		
		
		exit();
	}
	
	// Fetch the page info:
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$page_title = $row['title'];

	echo "<h3 style='color:yellow;'>$page_title</h3>";
	
	// Display the content if the user's account is current:
	if (isset($_SESSION['user_not_expired'])) {
		
		// Bonus material! Referenced in Chapter 5.
		// Create add to favorites and remove from favorites links:
		// See if this is favorite:
		$q = 'SELECT user_id FROM favorite_pages WHERE user_id=' . $_SESSION['userID'] . ' AND page_id=' . $_GET['id'];
		$r = mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 1) {
			echo '<p style="font-weight:bold;color:white;"><img src="'.ROOT_WWW.'/images/in_out/heart_48.png" border="0" width="48" height="48" align="middle" /> זה דף מועדף! <a href="index.php?mode=remove_from_favorite&id=' . $_GET['id'] . '"  ><img src="'.ROOT_WWW.'/images/in_out/cross_48.png" border="0" width="48" height="48" align="middle" /></a></p>';
		} else {
			echo '<p style="color:yellow;">הפוך אותו למועדף! <a href="index.php?mode=add_to_favorites&id=' . $_GET['id'] . '"><img src=" '.ROOT_WWW.'/images/in_out/heart_48.png" border="0" width="48" height="48" align="middle" /></a>';
		}


		// Show the page content:
		echo "<div style='font-weight:bold;'>{$row['content']}</div>";
		
		// Bonus material! Referenced in Chapter 5.
		// Record this visit to the history table:
		$q = "INSERT INTO history (user_id, type, page_id) VALUES ({$_SESSION['userID']}, 'page', {$_GET['id']})";
		$r = mysqli_query($dbc, $q);
		
	} elseif (isset($_SESSION['userID'])) { // Logged in but not current.
		echo '<p class="error" style="color:blue;">תודה שאתה מיתעניין על חומר באתר אך כדי לצפות בתוכן עליך להירשם! <a href="index.php?mode=renew">צור חשבון</a> במטרה להיכנס לדף!</p>';
		echo "<div>{$row['description']}</div>";
	} else { // Not logged in.
		echo '<p class="error" style="color:blue;">תודה שאתה מיתעניין על חומר באתר אך כדי לצפות בתוכן עליך להירשם!</p>';
		echo "<div>{$row['description']}</div>";
	}

} else { // No valid ID.
	$page_title = 'Error!';
	
	echo '<p class="error">.בדף זה נוצרו בעיות</p>';
} // End of primary IF.
	
echo '</fieldset>';	
}
/*****************************************************************************************************/













/**************************************************************************************/
//AUOTHENTICATION
/*****************************************************************************************************/
function sighn_in(){
global $dbc;
global $db;
$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);	
mysql_select_db(DB_SCHEMA, $GLOBALS['DB']);
$reg_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
   

	// Check for a first name:
	if (preg_match ('/^[א-ת \'.-]{2,20}$/i', $_POST['first_name']) ||    preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['first_name'])        ) {
		$fn = mysqli_real_escape_string ($dbc, $_POST['first_name']);
	} else {
		$reg_errors['first_name'] = 'בבקשה להזין שם פרטי!';
	}
	
	// Check for a last name:

	if (preg_match ('/^[א-ת \'.-]{2,20}$/i', $_POST['first_name']) || preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['last_name'])    ) {
		$ln = mysqli_real_escape_string ($dbc, $_POST['last_name']);
	} else {
		$reg_errors['last_name'] = 'בבקשה להזין שם מישפחה!';
	}
	
	// Check for a username:
	if (preg_match ('/^[A-Z0-9]{2,30}$/i', $_POST['username'])) {
		$un = mysqli_real_escape_string ($dbc, $_POST['username']);
	} else {
		$reg_errors['username'] = 'בבקשה להזין שם משתמש!';
	}
	
	// Check for an email address:
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		$reg_errors['email'] = 'בבקשה להזין כתובת דואר אלקטרוני חוקית!';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['pass1']);
		} else {
			$reg_errors['pass2'] = 'הסיסמה לא תואמת את הסיסמה המאושרת!';
		}
	} else {
		$reg_errors['pass1'] = 'בבקשה להזין סיסמה חוקית!';
	}
	
/****************************************************************************************/	
	
 
    // validate password
    $password1 = (isset($_POST['pass1'])) ? $_POST['pass1'] : '';
    $password2 = (isset($_POST['pass2'])) ? $_POST['pass2'] : '';
    $password = ($password1 && $password1 == $password2) ?
        sha1($password1) : '';

    // validate CAPTCHA
    $captcha = (isset($_POST['captcha']) && strtoupper($_POST['captcha']) == $_SESSION['captcha']);
 // if ($password && $captcha ){
  if ($password){
    	if (empty($reg_errors)) { 	
       	
        // make sure the user doesn't already exist
        $user = User::getByUsername($_POST['username']);

 /******************************************************************************/       
        if ($user->userID)
        {
//            $GLOBALS['TEMPLATE']['content'] = '<p><strong>Sorry, that ' .
//                'account already exists.</strong></p> <p>Please try a ' .
//                'different username.</p>';
//            $GLOBALS['TEMPLATE']['content'] .= $form;
            
            
            if ($user->row_num == 2) { // Both are taken.
				
				$reg_errors['email'] = 'האימייל הזה כבר רשום במערכת!!.';			
				$reg_errors['username'] = 'המשתמש הזה כבר רשום במערכת.';			

			} else { // One or both may be taken.

				// Get row:
//				$row = mysqli_fetch_array($r, MYSQLI_NUM);
									
				if( ($user->row['email'] == $_POST['email']) && ($user->row['uname'] == $_POST['username'])) { // Both match.
					$reg_errors['email'] = 'האימייל הזה כבר רשום במערכת!!!';	
					$reg_errors['username'] = 'המשתמש הזה כבר רשום במערכת!!!';
				} elseif ($user->row['email'] == $_POST['email']) { // Email match.
					$reg_errors['email'] ='האימייל הזה כבר רשום במערכת!!!';						
				} elseif ($user->row['uname'] == $_POST['username']) { // Username match.
					$reg_errors['username'] =  'המשתמש הזה כבר רשום במערכת!!!';		
				}
					
			} // End of $rows == 2 ELSE.
            
            
            
        }
/*******************************************************************************/        
else{
            // create an inactive user record
            $u = new User();
             $u->full_name = $_POST['full_name'];
             $u->lname = $_POST['last_name'];
             $u->fname = $_POST['first_name'];
            $u->uname = $_POST['username'];
            $u->phone_num = $_POST['phone_num'];
            $u->upass = $password1;
            $u->upass2 = $password;
            $u->email = $_POST['email'];
            $u->user_date = $_POST['user_date'];
            $token = $u->setInactive();

            
            
            
            $GLOBALS['TEMPLATE']['content'] = '<p><strong>Thank you for ' .
                'registering.</strong></p> <p>Be sure to verify your ' .
                'account by visiting <a href="verify.php?userID=' . 
                $u->userID . '&token=' . $token . '">verify.php?userID=' .
                $u->userID . '&token=' . $token . '</a></p>';
              ob_get_clean();   
                
                
          echo "<h3>!תודה רבה</h3><p>.תודה שנירשמת</p>";
               
			
				echo '<form action="'.ROOT_WWW.'/get_in_out2/html/" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="custom" value="' . $user->userID . '">
				<input type="hidden" name="email" value="' . $e . '">
				<input type="hidden" name="hosted_button_id" value="8YW8FZDELF296">
				<input type="image" src="'.ROOT_WWW.'/images/yes.gif"  border="0" name="submit" alt="" style="float:right;">
				<img alt="" border="0" src="'.ROOT_WWW.'/images/yes.gif" width="1" height="1">
				</form>
				';
						
				// Send a separate email?
				$body = "תודה שהיתחברת <למעקב אחרי קבלת החלטות>. Blah. Blah. Blah.\n\n";
				mail($_POST['email'], 'Registration Confirmation', $body, 'From: alonmor2@gmail.com');
				
				// Finish the page:
				$this->make_connect();
				 
				require_once (HTML_DIR ."/footer.php");
				exit(); // Stop the page.      
                
                
         }
         
    }
    
}  
/*******************************************************************************/    
    
    // there was invalid data
    else{
    	
   $form = ob_get_clean(); 

// show the form if this is the first time the page is viewed
if (!isset($_POST['submitted']))
{
    $GLOBALS['TEMPLATE']['content'] = $form;
}	
    	
    	
        $GLOBALS['TEMPLATE']['content'] .= '<p><strong>הזנת נתונים ' .
            'לא נכונים.</strong></p> <p>אנא מלא את כול השדות ' .
            'שנוכל לרשום את החשבון שלך.</p>';
        $GLOBALS['TEMPLATE']['content'] .= $form;
    }
 
	
	
	

	
/*****************************************************************************************/	

/***********************************/    
 } // End of the main form submission conditional.
/**********************************/
// Need the form functions script, which defines create_form_input():
 
require_once (LIB_DIR ."/form_functions.inc.php");
//ob_start();


?><h3>הירשם בבקשה</h3>
<p>להיכנס לאתר עליך להירשם! <strong>כול השדות נחוצים!</strong> <a href="http://www.google.com">מערכת מעקב</a>.</p>
<form action="index.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
		
		<p><label for="שם מלא"><strong>שם מלא</strong></label><br /><?php create_form_input('full_name', 'text', $reg_errors); ?></p>
		<p><label for="שם פרטי"><strong>שם פרטי</strong></label><br /><?php create_form_input('first_name', 'text', $reg_errors); ?></p>
		
		<p><label for="שם משפחה"><strong>שם משפחה</strong></label><br /><?php create_form_input('last_name', 'text', $reg_errors); ?></p>
		
		<p><label for="שם משתמש"><strong>שם משתמש</strong></label><br /><?php create_form_input('username', 'text', $reg_errors); ?> <small>רק אותיות ומיספרים מותרים</small></p>
		
		<p><label for="דואר אלקטרוני"><strong>דואר אלקטרוני</strong></label><br /><?php create_form_input('email', 'text', $reg_errors); ?></p>
		
		<p><label for="טלפון"><strong>טלפון</strong></label><br /><?php create_form_input('phone_num', 'text', $reg_errors); ?></p>
		<p><label for="טלפון"><strong>תאריך לידה</strong></label><br /><?php create_form_input('user_date', 'text', $reg_errors); ?></p>
		
		<p><label for="captcha"><strong>שחזר אותיות</strong></label></p><be /><img src="<?php echo ROOT_WWW;?>/images/in_out/captcha.php?nocache=<?php echo time(); ?>" alt=""/><br />
		
		<p><label for="Verify"><strong> </strong></label><br /><?php create_form_input('captcha', 'text', $reg_errors); ?></p>
	
  
		
		
		<p><label for="סיסמה"><strong>סיסמה</strong></label><br /><?php create_form_input('pass1', 'password', $reg_errors); ?> <small>בין 6-20 לפחות אות קטנה ,לפחות אות גדולה,לפחות מיספר אחד</small></p>
		<p><label for="סיסמה 2"><strong>אמת סיסמה</strong></label><br /><?php create_form_input('pass2', 'password', $reg_errors); ?></p>

		<input style="float:right;" type="submit" name="submit_next"  id="submit_next" mode="next_register" value="הבא&larr;" id="submit_button" class="formbutton" />
	
</fieldset></form>

 
	<?php 	
	
// $form = ob_get_clean(); 
// $GLOBALS['TEMPLATE']['content'] .= $form;
//include '../template-page.php';	
	
	
}


/******************************************************************************************/
function change_password(){
	
global $dbc;	
$page_title = 'Change Your Password';



$pass_errors = array();

// If it's a POST request, handle the form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
	// Check for the existing password:
	if (!empty($_POST['current'])) {
		$current = mysqli_real_escape_string ($dbc, $_POST['current']);
	} else {
		$pass_errors['current'] = 'הקש את הסיסמה הנוחכית!';
	}
	
	// Check for a password and match against the confirmed password:
	if (preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['pass1']);
		} else {
			$pass_errors['pass2'] = 'הסיסמה לא מתאימה לסיסמה המאושרת.!';
		}
	} else {
		$pass_errors['pass1'] = 'אנא הקש סיסמה חוקית!';
	}
	
	if (empty($pass_errors)) { // If everything's OK.
	
		// Check the current password:
//		$q = "SELECT userID FROM users WHERE upass='"  .  get_password_hash($current) .  "' AND userID={$_SESSION['userID']}";	

$q = "SELECT userID FROM users WHERE upass='$current' AND userID={$_SESSION['userID']}";		
		$r = mysqli_query ($dbc, $q);
		if (mysqli_num_rows($r) == 1) { // Correct
			
			// Define the query:
//			$q = "UPDATE users SET upass='"  .  get_password_hash($p) .  "' WHERE userID={$_SESSION['userID']} LIMIT 1";
$q = "UPDATE users SET upass='$p' WHERE userID={$_SESSION['userID']} LIMIT 1";	
			if ($r = mysqli_query ($dbc, $q)) { // If it ran OK.

				// Send an email, if desired.

				// Let the user know the password has been changed:
				echo '<h3 class="bgchange_login" style="font-weight:bold;color:brown;">הסיסמה שלך שונתה!</h3>';
				//include ('./includes/footer.php'); // Include the HTML footer.
				require_once (HTML_DIR ."/footer.php");
				exit();

			} else { // If it did not run OK.

				trigger_error('הסיסמה שלך לא יכלה להישתנות בגלל בעייה במערכת-אנחנו מתנצלים.'); 

			}

		} else {
			
			$pass_errors['current'] = 'הסיסמה הנוחכית שלך לא נכונה!';
			
		} // End of current password ELSE.

	} // End of $p IF.
	
} // End of the form submission conditional.

// Need the form functions script, which defines create_form_input():
 
require_once (LIB_DIR ."/form_functions.inc.php");
?>
<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים המשנים סיסמה</legend>
<h3 style="font-weight:bold;color:brown;">שנה סיסמה</h3>

<form action="index.php?mode=change_password" method="post" accept-charset="utf-8" dir="rtl">
	<p><label for="pass1"><strong style="font-weight:bold;color:yellow;">סיסמה נוכחית</strong></label><br /><?php create_form_input('current', 'password', $pass_errors); ?></p>
	<p><label for="pass1"><strong style="font-weight:bold;color:yellow;">סיסמה חדשה</strong></label><br /><?php create_form_input('pass1', 'password', $pass_errors); ?> <small>בין 6-20 לפחות אות קטנה ,לפחות אות גדולה,לפחות מיספר אחד</small></p>
	<p><label for="pass2"><strong style="font-weight:bold;color:yellow;">אמת סיסמה חדשה</strong></label><br /><?php create_form_input('pass2', 'password', $pass_errors); ?></p>
	<input type="submit" name="submit_chang_pass"  id="submit_chang_pass"  value="שנה &larr;"   class="formbutton" style="font-weight:bold;color:yellow;"/>
</form></fieldset>
<?php 
	
	
	
	
}

/*****************************************************************************************************/
function forgot(){
global $dbc;

global $db;
// Include the header file:
$page_title = 'שכחת את הסיסמה?';
 

$pass_errors = array();

// If it's a POST request, handle the form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Validate the email address:
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	
		// Check for the existence of that email address...
		$q = 'SELECT userID FROM users WHERE email="'.  mysqli_real_escape_string ($dbc, $_POST['email']) . '"';
		$r = mysqli_query ($dbc, $q);
		
		if (mysqli_num_rows($r) == 1) { // Retrieve the user ID:
			list($uid) = mysqli_fetch_array ($r, MYSQLI_NUM); 
		} else { // No database match made.
			$pass_errors['email'] = 'כתובת דואר האלקטרוני לא מתאימה במסד הנתונים!';
		}
		
	} else { // No valid address submitted.
		$pass_errors['email'] = 'אנא הכנס כתובת דואר האלקטרוני חוקית ';
	} // End of $_POST['email'] IF.
	
	if (empty($pass_errors)) { // If everything's OK.

		// Create a new, random password:
		$p = substr(md5(uniqid(rand(), true)), 15, 15);

		// Update the database:
		$q = "UPDATE users SET upass='" .  get_password_hash($p) . "' WHERE userID=$uid LIMIT 1";
		$r = mysqli_query ($dbc, $q);
		
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Send an email:
			$body = "הסיסמה החדשה להיתחברות <whatever site> שונה באופן זמני ל- '$p'. היכנס אם נתונים אלו אחר כך שנה למשהו יותר מוכר.";
			mail ($_POST['email'], 'סיסמה זמנית', $body, 'מ-: alonmor2@gmail.com');
			
			// Print a message and wrap up:
			echo '<h3>הסיסמה שלך שונתה ל...</h3><p>קבלת סיסמה חדשה בדואר האלקטרוני.כשתתחבר אם סיסמה זו אתה יכול לשנותה ע"י לחיצה על -שנה סיסמה.</p>';
			//include ('./includes/footer.php');
			require_once (HTML_DIR ."/footer.php");
			exit(); // Stop the script.
			
		} else { // If it did not run OK.
	
			trigger_error('הסיסמה שלך לא יכלה להישתנות בגלל בעייה במערכת-אנחנו מתנצלים.'); 

		}

	} // End of $uid IF.

} // End of the main Submit conditional.

// Need the form functions script, which defines create_form_input():
require_once (LIB_DIR ."/form_functions.inc.php");
?>
<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים המאפסים</legend>
<h3 style="font-weight:bold;color:yellow;">אפס את הסיסמה</h3>
<p style="font-weight:bold;color:yellow;">.הקש דואר אלקטרוני כדי לאפס סיסמה מתחת</p> 
<form action="index.php?mode=forgot" method="post" accept-charset="utf-8" dir="rtl">
	<p><label for="email"><strong style="font-weight:bold;color:brown;">דואר אלקטרוני</strong></label><br /><?php create_form_input('email', 'text', $pass_errors); ?></p>
	<input type="submit" name="submit_button" value="אפס &larr;" id="submit_button" class="formbutton" />
</form></fieldset>	
	
<?php  	
}
/******************************************************************************************/


















/***************************************FAVORITES***************************************************/
function favorites(){	
global $dbc;
	
$page_title = 'Your Favorite Pages';

echo '<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים המאפסים</legend>';
echo '<h3 style="font-weight:bold;color:yellow;">הדפים המועדפים שלך</h3>';

// Get only the favorites:
$q = 'SELECT id, title, description FROM pages LEFT JOIN favorite_pages ON (pages.id=favorite_pages.page_id) WHERE favorite_pages.user_id=' . $_SESSION['userID'] . ' ORDER BY title';
$r = mysqli_query($dbc, $q);

if (mysqli_num_rows($r) > 0) {

	while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {

		echo "<div><h4><a  class='my_href_li'  href=\"index.php?mode=page&id=$row[0]\">$row[1]</a></h4><p style='font-weight:bold;color:brown;'>$row[2]</p></div>\n";
	}

} else { 
	echo '<p style="font-weight:bold;color:brown;">אנא חזור מאוחר יותר -כרגע אין חומר עדכני של דפים מועדפים </p>';
 }
 echo '</fiedset>';
}
 
/*****************************************************************************************************/
function add_to_favorites(){
	
global $dbc;

echo '<fieldset dir="rtl"  style="color:white; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >';
// Validate the category ID:
if (filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

	// Get the page info:
	$q = 'SELECT title, description, content FROM pages WHERE id=' . $_GET['id'];
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) != 1) { // Problem!
		$page_title = 'Error!';

		echo '<p class="error">.בדף זה נוצרו בעיות</p>';

		exit();
	}
	
	// Fetch the page info:
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$page_title = $row['title'];

	echo "<h3>$page_title</h3>";
	
	// Add this favorite to the database:
	$q = 'REPLACE INTO favorite_pages (user_id, page_id) VALUES (' . $_SESSION['userID'] . ', ' . $_GET['id'] . ')';
	$r = mysqli_query($dbc, $q);
	if (mysqli_affected_rows($dbc) == 1) {
			echo '<p style="font-weight:bold;color:white;"><img src="'.ROOT_WWW.'/images/in_out/heart_48.png" border="0" width="48" height="48" align="middle" />!דף זה הוסף למועדפים שלך<a href="index.php?mode=remove_from_favorite&id=' . $_GET['id'] . '"  class="my_href_li" ><img src="'.ROOT_WWW.'/images/in_out/cross_48.png" border="0" width="48" height="48" align="middle" /></a></p>';
	} else {
		trigger_error('.אינך יכול להמשיך בגלל בעייה במערכת-אנחנו מתנצלים');
	}

	// Show the page content:
	echo "<div style='font-weight:bold;color:pink;'>{$row['content']}</div>";
		
} else { // No valid ID.
	$page_title = 'Error!';
	 
	echo '<p class="error">.בדף זה נוצרו בעיות</p>';
} // End of primary IF.
	
echo '</fieldset>';		
}
/*****************************************************************************************************/
function remove_from_favorite(){
	
 

global $dbc;
echo '<fieldset dir="rtl"  style="color:white; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >';
// Validate the category ID:
if (filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

	// Get the page info:
	$q = 'SELECT title, description, content FROM pages WHERE id=' . $_GET['id'];
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) != 1) { // Problem!
		$page_title = 'Error!';
		
		echo '<p class="error">This page has been accessed in error.</p>';
		
		exit();
	}
	
	// Fetch the page info:
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$page_title = $row['title'];
	
	echo "<h3 style='font-weight:bold;color:yellow;'>$page_title</h3>";
	
	// Add this favorite to the database:
	$q = 'DELETE FROM favorite_pages WHERE user_id=' . $_SESSION['userID'] . ' AND page_id=' . $_GET['id'] . ' LIMIT 1';
	$r = mysqli_query($dbc, $q);
	if (mysqli_affected_rows($dbc) == 1) {
		echo '<p style="font-weight:bold;color:white;">!דף זה הוסר מהמועדפים שלך <img src="'.ROOT_WWW.'/images/in_out/cross_48.png" border="0" width="48" height="48" align="middle" /></p>';
	} else {
		trigger_error('.תקלה בגלל בעייה במערכת-אנחנו מתנצלים');
	}

	// Show the page content:
	echo "<div style='font-weight:bold;color:brown;'>{$row['content']}</div>";
		
} else { // No valid ID.
	$page_title = 'Error!';
	
	echo '<p class="error">.בדף זה נוצרו בעיות</p>';
} // End of primary IF.	
	
echo '</fieldset>';	
}
/*****************************************************************************************************/









/********************************************PDFS*********************************************************/
function add_pdf(){
	
global $dbc;


// Include the header file:
$page_title = ' PDF -הוסף קבצי';
// For storing errors:
$add_pdf_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {	

	// Check for a title:
	if (!empty($_POST['title'])) {
		$t = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
	} else {
		$add_pdf_errors['title'] = 'אנא הזן כותרת!';
	}
	
	// Check for a description:
	if (!empty($_POST['description'])) {
		$d = mysqli_real_escape_string($dbc, strip_tags($_POST['description']));
	} else {
		$add_pdf_errors['description'] = 'אנא הזן תאור!';
	}

	// Check for a PDF:
	if (is_uploaded_file ($_FILES['pdf']['tmp_name']) && ($_FILES['pdf']['error'] == UPLOAD_ERR_OK)) {
		
		$file = $_FILES['pdf'];
		
		$size = ROUND($file['size']/1024);

		// Validate the file size:
		if ($size > 1024) {
			$add_pdf_errors['pdf'] = 'הקובץ היה גדול מידיי!';
		} 

		// Validate the file type:
		if ( ($file['type'] != 'application/pdf') && (substr($file['name'], -4) != '.pdf') ) {
			$add_pdf_errors['pdf'] = 'הקובץ הוא לא מסוג-PDF';
		} 
		
		// Move the file over, if no problems:
		if (!array_key_exists('pdf', $add_pdf_errors)) {

			// Create a tmp_name for the file:
			$tmp_name = sha1($file['name'] . uniqid('',true));
			
			// Move the file to its proper folder but add _tmp, just in case:
			$dest =  PDFS_DIR . $tmp_name . '_tmp';

			if (move_uploaded_file($file['tmp_name'], $dest)) {
				
				// Store the data in the session for later use:
				$_SESSION['pdf']['tmp_name'] = $tmp_name;
				$_SESSION['pdf']['size'] = $size;
				$_SESSION['pdf']['file_name'] = $file['name'];
				
				// Print a message:
				echo '<h4>הקובץ הועלה!</h4>';
				
			} else {
				trigger_error('אי אפשר להזיז את הקובץ.');
				unlink ($file['tmp_name']);				
			}

		} // End of array_key_exists() IF.
		
	} elseif (!isset($_SESSION['pdf'])) { // No current or previous uploaded file.
		switch ($_FILES['pdf']['error']) {
			case 1:
			case 2:
				$add_pdf_errors['pdf'] = '.הקובץ גדול מידיי';
				break;
			case 3:
				$add_pdf_errors['pdf'] = '.הקובץ עלה באופן חלקי';
				break;
			case 6:
			case 7:
			case 8:
				$add_pdf_errors['pdf'] = '.הקובץ לא עלה בגלל בעיות במערכת';
				break;
			case 4:
			default: 
				$add_pdf_errors['pdf'] = '.לא נימצא קובץ';
				break;
		} // End of SWITCH.

	} // End of $_FILES IF-ELSEIF-ELSE.
	
	if (empty($add_pdf_errors)) { // If everything's OK.
		//if($_SESSION['pdf']['file_name'])
		// Add the PDF to the database:
		$fn = mysqli_real_escape_string($dbc, $_SESSION['pdf']['file_name']);
		$tmp_name = mysqli_real_escape_string($dbc, $_SESSION['pdf']['tmp_name']);
		$size = (int) $_SESSION['pdf']['size'];
		$q = "INSERT INTO pdfs (tmp_name, title, description, file_name, size) VALUES ('$tmp_name', '$t', '$d', '$fn', $size)";
		$r = mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
			// Rename the temporary file:
			$original =  PDFS_DIR . $tmp_name . '_tmp';
			$dest =  PDFS_DIR . $tmp_name;
			rename($original, $dest);

			// Print a message:
			echo '<h4>היתווסף PDF!</h4>';
		
			// Clear $_POST:
			$_POST = array();
			
			// Clear $_FILES:
			$_FILES = array();
			
			// Clear $file and $_SESSION['pdf']:
			unset($file, $_SESSION['pdf']);
					
		} else { // If it did not run OK.
			trigger_error('The PDF could not be added due to a system error. We apologize for any inconvenience.');
			unlink ($dest);
		}
				
	} // End of $errors IF.
	
} else { // Clear out the session on a GET request:
	unset($_SESSION['pdf']);	
} // End of the submission IF.

// Need the form functions script, which defines create_form_input():
require_once (LIB_DIR ."/form_functions.inc.php");
?><h3> PDF -הוסף </h3>
<form enctype="multipart/form-data" action="index.php?mode=add_pdf" method="post" accept-charset="utf-8" dir="rtl">

	<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
	
	<fieldset  style="color:white; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
	    
	    <legend>  מלא את הטופס להוספת קובץ PDF :</legend>
	
		<p><label for="title"><strong>כותרת</strong></label><br /><?php create_form_input('title', 'text', $add_pdf_errors); ?></p>
	
		<p><label for="description"><strong>תאור</strong></label><br /><?php create_form_input('description', 'textarea', $add_pdf_errors); ?></p>

		<p><label for="pdf"><strong>PDF</strong></label><br /><?php echo '<input type="file" name="pdf" id="pdf"';
		
			// Check for an error:
			if (array_key_exists('pdf', $add_pdf_errors)) {
				
				echo ' class="error" /> <span class="error">' . $add_pdf_errors['pdf'] . '</span>';
				
			} else { // No error.

				echo ' />';

				// If the file exists (from a previous form submission but there were other errors),
				// store the file info in a session and note its existence:		
				if (isset($_SESSION['pdf'])) {
					echo " Currently '{$_SESSION['pdf']['file_name']}'";
				}

			} // end of errors IF-ELSE.
		 ?> <small>גבול מותר 1MB</small></p>

	<p><input type="submit" name="submit_add_pdf" value=" הוסף את ה-PDF" id="submit_add_pdf" class="formbutton" /></p>
	
	
	</fieldset>

</form> 
<?php  	
}

/*****************************************************************************************************/
/*****************************************************************************************************/

/******************************************************************************************/
function  pdfs(){
global $dbc;
// Include the header file:
$page_title = 'PDFs';


echo '<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים הצופים</legend>';
// Print a page header:
echo '<h3 style="color:yellow;"> מדריך PDF</h3>';

// Print a message if they're not an active user:
if (isset($_SESSION['userID']) && !isset($_SESSION['user_not_expired'])) {
	 echo '<p class="error">תודה שאתה מתעניין בתכנים אך עליך להירשם תחילה! <a href="renew.php">הירשם לחשבון</a>כדי להגיע לתכנים ב-קבצי pdf</p>';
} elseif (!isset($_SESSION['userID'])) {
//	echo '<p class="error">תודה שאתה מתעניין בתכנים עליך להיתחבר או להירשם קודם</p>';
echo '<h4   style=" background:white;font-weight:bold;font-size:1.5em;color:green;">תודה שאתה מתעניין !!!</h4>';
	
}

// Get the PDFs:
$q = 'SELECT id,tmp_name, title, description, size FROM pdfs ORDER BY date_created DESC';
$r = mysqli_query($dbc, $q);
if (mysqli_num_rows($r) > 0) { // If there are some...
	
	// Fetch every one:
 	while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

		// Display each record:
		echo "<div id='my_pdfs'><h4><a class='my_href_li' href=\"index.php?mode=view_pdfs&id={$row['tmp_name']}\">{$row['title']}</a> ({$row['size']}kb)</h4><p  style='font-weight:bold;color:brown;'>{$row['description']}</p></div>\n";

	} // End of WHILE loop.
	
} else { // No PDFs!
	echo '<p>אנא חזור מאוחר יותר pdf -כרגע אין חומר עדכני של קבצי </p>';
}



echo '</fieldset>';
}
/******************************************************************************************/
function view_pdfs(){
global $dbc;
$valid = false;

// Validate the PDF ID:
if (isset($_GET['id']) && (strlen($_GET['id']) == 40) && (substr($_GET['id'], 0, 1) != '.') ) {

	// Identify the file:
	$file = PDFS_DIR . $_GET['id'];

	// Check that the PDF exists and is a file:
	if (file_exists ($file) && (is_file($file)) ) {

		// Get the info:
		$q = 'SELECT id, title, description, file_name FROM pdfs WHERE tmp_name="' . mysqli_real_escape_string($dbc, $_GET['id']) . '"';
		$r = mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 1) { // Ok!
			
			// Fetch the info:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			
			// Indicate that the file reference is fine:
			$valid = true;
			
			// Only display the PDF to a user whose account is active:
			if (isset($_SESSION['user_not_expired'])) {

				// Bonus material! Referenced in Chapter 5.
				// Record this visit to the history table:
				$q = "INSERT INTO history (user_id, type, pdf_id) VALUES ({$_SESSION['userID']}, 'pdf', {$row['id']})";
				$r = mysqli_query($dbc, $q);

				
				// Send the content information:
				header('Content-type:application/pdf'); 
				header('Content-Disposition:inline;filename="' . $row['file_name'] . '"'); 
				$fs = filesize($file);
				header ("Content-Length:$fs\n");

				// Send the file:
				readfile ($file);
				exit();
				
			} else { // Inactive account!
				//include ('./includes/header.php');
				require_once (HTML_DIR ."/header.php");
			echo '<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים הצופים</legend>';	
				// Display an HTML page instead:
				$page_title = $row['title'];
				//include ('./includes/header.php');
				echo "<h3>$page_title</h3>";
				
				// Change the message based upon the user's status:
				if (isset($_SESSION['userID'])) {
			   echo '<p class="error">תודה שאתה מתעניין בתכנים אך עליך להירשם תחילה! <a href="renew.php">הירשם לחשבון</a>כדי להגיע לתכנים</p>';
					
				} else {
					echo '<p class="error">תודה שאתה מתעניין בתכנים עליך להיתחבר או להירשם קודם</p>';
				}
				
				// Complete the page:
				echo "<div style='font-weight:bold;color:brown;'>{$row['description']}</div></fieldset>";
					
				echo '</fieldset>';
			} // End of user IF-ELSE.
					
		} // End of mysqli_num_rows() IF.

	} // End of file_exists() IF.
	
} // End of $_GET['id'] IF.

// If something didn't work...
if (!$valid) {
	$page_title = 'Error!';
	
	echo '<p class="error">נוצרה טעות בכניסה לדף זה!</p>';
  }	
		
}
/**************************************************************************************************/
function history(){

	global $dbc;
	
	$page_title = 'Your Viewing History';
   
echo '<fieldset dir="rtl"  style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>ברוכים הצופים</legend>';
echo '<h3 style="font-weight:bold;color:yellow;">דפיי ההיסטורייה הניצפים שלך</h3>';

$q = 'SELECT pages.id, title, description, DATE_FORMAT(history.date_created, "%M %d, %Y") FROM pages 
      LEFT JOIN history ON (pages.id=history.page_id) WHERE history.user_id=' . $_SESSION['userID'] . '
      GROUP BY (history.page_id) ORDER BY history.date_created DESC';
$r = mysqli_query($dbc, $q);



if (mysqli_num_rows($r) > 0) {
	echo '<h4 style="font-weight:bold;color:white;">דפים שצפית בהם</h4>';
	while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
		// Display each record:
		echo "<div><h4><a class='my_href_li' href=\"index.php?mode=page&id=$row[0]\">$row[1]</a></h4><p style='font-weight:bold;color:brown;'>$row[2]<br />ניצפה לאחרונה: $row[3]</p></div>\n";
	}

} else { // No pages available.
	echo '<p style="font-weight:bold;color:yellow;">עדיין לא צפית באף דף של היסטורייה</p>';
}

// Get the pages they've viewed
$q = 'SELECT pdfs.tmp_name, title, description, DATE_FORMAT(history.date_created, "%M %d, %Y") FROM pdfs LEFT JOIN history ON (pdfs.id=history.pdf_id) WHERE history.user_id=' . $_SESSION['userID'] . ' GROUP BY (history.pdf_id) ORDER BY history.date_created DESC';
$r = mysqli_query($dbc, $q);



if (mysqli_num_rows($r) > 0) {
	echo '<h4 style="font-weight:bold;color:white;">PDFs אשר צפית בהם-</h4>';
	while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
		// Display each record:
		echo "<div><h4><a class='my_href_li' href=\"index.php?mode=view_pdfs&id=$row[0]\">$row[1]</a></h4><p style='font-weight:bold;color:brown;'>$row[2]<br />ניצפה לאחרונה: $row[3]</p></div>\n";
	}

} else { // No pages available.
	echo '<p style="font-weight:bold;color:yellow;">עדיין לא צפית בקבציי ה-PDFs שלך</p><fieldset>';
}
}


/******************************************************************************************/
/******************************************************************************************/

function add_page(){
	
global $dbc;
$page_title = 'הוסף דף תוכן לאתר'; 
//include ('./includes/header.php');

// For storing errors:
$add_page_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
	
	// Check for a title:
	if (!empty($_POST['title'])) {
		$t = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
	} else {
		$add_page_errors['title'] = 'אנא כתוב כותרת!';
	}
	
	// Check for a category:
	if (filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$cat = $_POST['category'];
	} else { // No category selected.
		$add_page_errors['category'] = 'אנא בחר קטגורייה!';
	}

	// Check for a description:
	if (!empty($_POST['description'])) {
		$d = mysqli_real_escape_string($dbc, strip_tags($_POST['description']));
	} else {
		$add_page_errors['description'] = 'אנא כתוב תאור!';
	}
		
	// Check for the content:
	if (!empty($_POST['content'])) {
		$allowed = '<div><p><span><br><a><img><h1><h2><h3><h4><ul><ol><li><blockquote>';
		$c = mysqli_real_escape_string($dbc, strip_tags($_POST['content'], $allowed));
	} else {
		$add_page_errors['content'] = 'בבקשה לכתוב תוכן!';
	}
		
	if (empty($add_page_errors)) { // If everything's OK.
	
		// Add the page to the database:
		$q = "INSERT INTO pages (category_id, title, description, content) VALUES ($cat, '$t', '$d', '$c')";
		$r = mysqli_query ($dbc, $q);

		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Print a message:
			echo '<h4>הדף נוסף!</h4>';
			
			// Clear $_POST:
			$_POST = array();
			//return true;
			// Send an email to the administrator to let them know new content was added?
			
		} else { // If it did not run OK.
			trigger_error('אינך יכול להמשיך בגלל בעייה במערכת-אנחנו מתנצלים.');
			
		}
		
	} // End of $add_page_errors IF.
	
} // End of the main form submission conditional.

// Need the form functions script, which defines create_form_input():
require_once (LIB_DIR ."/form_functions.inc.php");
?>
 
<form action="index.php" method="post" accept-charset="utf-8" dir="rtl">
 <fieldset dir="rtl"  style="width:80%;overflow:auto; background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>הוסף דף</legend> 	

	 
	
<p><label for="title"><strong>כותרת</strong></label><br /><?php create_form_input('title', 'text', $add_page_errors); ?></p>
	
	<p><label for="category"><strong>קטגורייה</strong></label><br />
	<select name="category"<?php if (array_key_exists('category', $add_page_errors)) echo ' class="error"'; ?>>
	<option>Select One</option>
	<?php // Retrieve all the categories and add to the pull-down menu:
	//$q = "SELECT catID, catName FROM categories ORDER BY catName ASC";
	$q = "SELECT id, category FROM categories_page ORDER BY category ASC";		
	$r = mysqli_query ($dbc, $q);
		while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\"";
			// Check for stickyness:
			if (isset($_POST['category']) && ($_POST['category'] == $row[0]) ) echo ' selected="selected"';
			echo ">$row[1]</option>\n";
		}
	?>
	</select><?php if (array_key_exists('category', $add_page_errors)) echo ' <span class="error">' . $add_page_errors['category'] . '</span>'; ?></p>
	
	<p><label for="description"><strong>תאור</strong></label><br /><?php create_form_input('description', 'textarea', $add_page_errors); ?></p>
	
	<p><label for="content"><strong>תוכן</strong></label><br /><?php create_form_input('content', 'textarea', $add_page_errors); ?></p>
	
	<p><input type="submit" name="submit_addPage"   value="הוסף את הדף הזה" id="submit_addPage" class="formbutton" /></p>
	<p><input type="submit" name="submit_back"   value="חזור לדף הביית" id="submit_back" class="formbutton" /></p>
	
	</fieldset>

</form> 
<script type="text/javascript">
	tinyMCE.init({

	//	mode : "textareas", theme : "simple", width : "450" 

		
		// General options
		mode : "exact",
		elements : "content",
		theme : "advanced",
		width :600,
		height : 400,//autoresize,->this plugin makes problem
		 plugins : "advlink,advlist,autosave,contextmenu,fullscreen,iespell,inlinepopups,media,paste,preview,safari,searchreplace,visualchars,wordcount,xhtmlxtras",
		// Theme options
		theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,removeformat,|,search,replace,|,cleanup,help,code,preview,visualaid,fullscreen",
		theme_advanced_buttons2 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,|,bullist,numlist,|,outdent,indent,blockquote,|,sub,sup,cite,abbr",
		theme_advanced_buttons3 : "hr,|,link,unlink,anchor,image,|,charmap,emotions,iespell,media",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "right",
		//theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		//content_css : "<?php echo ROOT_WWW; ?>/html/css/in_out_style.css"
		content_css : "/css/in_out_style.css"

	});
</script>
<!-- /TinyMCE -->

<?php /* PAGE CONTENT ENDS HERE! */

	
	
	
	
}
/*****************************************************************************************************/



















/***********************************************FORUM******************************************************/
function add_msgForum()
{
// include '401.php';
 $_SESSION['error_page']=FALSE;
 $frm_errors=array();
// user must have appropriate permissions to use this page
$user = User::getById($_SESSION['userID']);
if (~$user->permission & User::CREATE_FORUM)
{
    die('<p>Sorry, you do not have sufficient privileges to create new ' .
        'forums.</p>');
}

// validate incoming values
$forum_name = (isset($_POST['forum_name'])) ? trim($_POST['forum_name']) : '';
$forum_desc = (isset($_POST['forum_desc'])) ? trim($_POST['forum_desc']) : '';
$now	=	date('Y-m-d');
// add entry to the database if the form was submitted and the necessary
// values were supplied in the form
if (isset($_POST['submitted']) && $forum_name && $forum_desc)
{
	
	
    $query = sprintf('INSERT INTO %sFORUM (FORUM_NAME, DESCRIPTION,created_dt,modified_dt) ' .
        'VALUES ("%s", "%s","%s","%s")', DB_TBL_PREFIX,
        mysql_real_escape_string($forum_name, $GLOBALS['DB']),
        mysql_real_escape_string($forum_desc, $GLOBALS['DB']),
         mysql_real_escape_string($now, $GLOBALS['DB']),
         mysql_real_escape_string($now, $GLOBALS['DB']));
    mysql_query($query, $GLOBALS['DB']);


//$this-> view_forums();
require_once (HTML_DIR ."/edit_msgForum.php");
require_once (HTML_DIR ."/footer.php");
exit();
}

// form was submitted but not all the information was correctly filled in
else if (isset($_POST['submitted']))
{
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i',$_POST['forum_name'])) {
		$forum_name= mysqli_real_escape_string ($dbc, $_POST['forum_name']);
	} else {
		$frm_errors['first_name'] = 'בבקשה להזין שם פורום!';
	}
	
    $message = '<p class="error" style="float:right;font-weight:bold;font-size:1em;">אנא הזן נתונים   </p><br /><br /><br />';
}

// generate the form
ob_start();
if (isset($message))
{
    echo $message;
}



 
require_once (LIB_DIR ."/form_functions.inc.php");

?>
<fieldset dir="rtl"  style	="overflow:;background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>הוסף פורום</legend>
<h3 style="font-weight:bold;color:brown;">צור פורום</h3>

<form action="index.php?mode=add_msgForum" method="post" accept-charset="utf-8" dir="rtl">
	<p><label for="forum_name"><strong style="font-weight:bold;color:yellow;">שם הפורום</strong></label><br /><?php create_form_input('forum_name', 'text', $frm_errors); ?></p>
	<p><label for="forum_desc"><strong style="font-weight:bold;color:yellow;">תאור</strong></label><br /><?php create_form_input('forum_desc', 'text', $frm_errors); ?> <small></small></p>
	

	
	<input type="hidden" name="submitted" value="true"/>
	<input type="submit" name="add_forum"  id="add_forum"  value="צור פורום &larr;"   class="formbutton" style="font-weight:bold;color:yellow;"/>
	

	
</form>
</fieldset>
<?php 


 
$GLOBALS['TEMPLATE']['content'] = ob_get_clean();


 require_once (LIB_DIR ."/template-page.php");
}
/******************************************************************************/
function add_post(){
	
//include '401.php';
if($_SESSION['userID'])
// retrive user information
$user = User::getById($_SESSION['userID']);

// validate incoming values
$forum_id = (isset($_GET['fid'])) ? (int)$_GET['fid'] : 0;
$query = sprintf('SELECT FORUM_ID FROM %sFORUM WHERE FORUM_ID = %d',
    DB_TBL_PREFIX, $forum_id);
$result = mysql_query($query, $GLOBALS['DB']);
if (!mysql_num_rows($result))
{
    mysql_free_result($result);
    mysql_close($GLOBALS['DB']);
    die('<p>קוד זיהוי פורום שגוי.</p>');
}
mysql_free_result($result);

$msg_id = (isset($_GET['mid'])) ? (int)$_GET['mid'] : 0;
$query = sprintf('SELECT MESSAGE_ID FROM %sFORUM_MESSAGE WHERE ' . 
    'MESSAGE_ID = %d', DB_TBL_PREFIX, $msg_id);
$result = mysql_query($query, $GLOBALS['DB']);
if ($msg_id && !mysql_num_rows($result))
{
    mysql_free_result($result);
    mysql_close($GLOBALS['DB']);
    die('<p>Invalid forum id.</p>');
}
mysql_free_result($result);

$msg_subject = (isset($_POST['msg_subject'])) ?
    trim($_POST['msg_subject']) : '';
$msg_text = (isset($_POST['msg_text'])) ? trim($_POST['msg_text']) : '';

// add entry to the database if the form was submitted and the necessary
// values were supplied in the form
if (isset($_POST['submitted']) && $msg_subject && $msg_text)
{
    $query = sprintf('INSERT INTO %sFORUM_MESSAGE (SUBJECT, ' .
        'MESSAGE_TEXT, PARENT_MESSAGE_ID, FORUM_ID, userID) VALUES ' .
        '("%s", "%s", %d, %d, %d)', DB_TBL_PREFIX,
        mysql_real_escape_string($msg_subject, $GLOBALS['DB']),
        mysql_real_escape_string($msg_text, $GLOBALS['DB']),
        $msg_id, $forum_id, $user->userID);
    mysql_query($query, $GLOBALS['DB']);
    echo mysql_error();

    // redirect
$this->view_forums($forum_id,$msg_id);
  // header('Location: view.php?fid=' . $forum_id . (($msg_id) ?  '&mid=' . $msg_id : '')); 
}

// form was submitted but not all the information was correctly filled in
else if (isset($_POST['submitted']))
{
    $message = '<p class="error" style="float:right;">לא סופקו מספיק נתונים . תקן והיכנס.</p>';
}

// generate the form
ob_start();
if (isset($message)) echo $message;
?>

<form dir="rtl" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?mode=add_post&fid=' .$forum_id . '&mid=' . $msg_id; ?>" >
<fieldset   style=" background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>פורומים</legend>
                    <h3 style="font-weight:bold;color:brown;">שלח הודעה</h3>
 <div>
  <label for="msg_subject" style="color:yellow;font-weight:bold;">נושא:</label>
  <input type="input" id="msg_subject" name="msg_subject" value="<?php echo htmlspecialchars($msg_subject); ?>"/><br/>
  <label for="msg_text" style="color:yellow;font-weight:bold;">תאור:</label>
  <textarea id="msg_text" name="msg_text" style="width:40%;"><?php echo htmlspecialchars($msg_text); ?></textarea>
  <br/>
  <input type="hidden" name="submitted" value="1"/>
  <input type="submit" value="שלח"/>
 </div></fieldset>
</form>
<?php
$GLOBALS['TEMPLATE']['content'] = ob_get_contents();
ob_end_clean();

 
require_once (LIB_DIR ."/template-page.php"); 	
	
}
/******************************************************************************/
/******************************************************************************/
function view_forums($forum_id_test="",$msg_id_test=""){
if (isset($_SESSION['user_not_expired'])){  	
		
	$_SESSION['error_page']=FALSE;
	
 global $dbc;
 global $db;

 
 // validate incoming values
if($forum_id_test)
 $forum_id =$forum_id_test;
 else
$forum_id = (isset($_GET['fid'])) ? (int)$_GET['fid'] : 0;



if($msg_id_test)
$msg_id =$msg_id_test;
else
$msg_id = (isset($_GET['mid'])) ? (int)$_GET['mid'] : 0;




ob_start();
if ($forum_id)
{
echo '<fieldset dir="rtl"  style="list-style:none;  background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>פורומים</legend>
                    <h3 style="font-weight:bold;color:brown;">צפה בפורומים</h3>';		
    // display forum name as header
    $query = sprintf('SELECT FORUM_NAME FROM %sFORUM WHERE FORUM_ID = %d ',
        DB_TBL_PREFIX, $forum_id);
    $result = mysql_query($query, $GLOBALS['DB']);
    
    if (!mysql_num_rows($result))
    {
        die('<p>קוד זיהוי לא נכון.</p>');
    }
    $row = mysql_fetch_array($result);
    echo '<h4 style="align:right;">' . htmlspecialchars($row['FORUM_NAME']) . '</h4>';

    if ($msg_id)
    {    
        // link back to thread view
        echo '<p><a href="'.$_SERVER['PHP_SELF'].'?mode=view_forums&fid=' . $forum_id . '">	.חזרה לרשימת הפורומים</a></p>';
    }
    else
    {    
        // link back to forum list
        echo '<p><a href="'.$_SERVER['PHP_SELF'].'?mode=view_forums">	.חזרה לרשימת הפורומים</a></p>';

        // display option to add new post if user is logged in
        if (isset($_SESSION['access']))
        {
            echo '<p><a href="'.$_SERVER['PHP_SELF'].'?mode=add_post&fid=' . $forum_id . '">.שלח הודעה חדשה</a></p>';
            
        }
    }
    mysql_free_result($result);
    echo '</fieldset>';
}
else
{
echo '<fieldset dir="rtl"  style=" overflow:hidden;background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>פורומים</legend>
                    <h3 style="font-weight:bold;color:brown;">צפה בפורומים</h3>';	
    
    if (isset($_SESSION['userID']))
    {
        // display link to create new forum if user has permissions to do so
        $user = User::getById($_SESSION['userID']);
        if ($user->permission & User::CREATE_FORUM)
        {
            echo '<p><a href="'.$_SERVER['PHP_SELF'].'?mode=add_forum">צור פורום חדש</a></p>';
        }
    }
}

// generate message view
if ($forum_id && $msg_id)
{
    $query = <<<ENDSQL
SELECT
    uname, FORUM_ID, MESSAGE_ID, PARENT_MESSAGE_ID,
    SUBJECT, MESSAGE_TEXT, UNIX_TIMESTAMP(MESSAGE_DATE) AS MESSAGE_DATE
FROM
    %sFORUM_MESSAGE M JOIN %susers U
        ON M.userID = U.userID
WHERE
    MESSAGE_ID = %d OR
    PARENT_MESSAGE_ID = %d
ORDER BY
    MESSAGE_DATE ASC
ENDSQL;

    $query = sprintf($query, DB_TBL_PREFIX, DB_TBL_PREFIX, $msg_id, $msg_id);

    $result = mysql_query($query, $GLOBALS['DB']);

echo '<table border=1 >';
    while ($row = mysql_fetch_array($result))
    {
 echo '<tr>';
        
    echo '<td style="text-align:center; vertical-align:top; width:150px;">';
        if (file_exists(ROOT_WWW.'/get_in_out2/html/avatars/' . $row['uname'] . '.jpg'))
        {
            echo '<img src="'.ROOT_WWW.'/get_in_out2/html/avatars/' . $row['uname'] . '.jpg" />';
        }
        else
        {
            echo '<img src="'.ROOT_WWW.'/get_in_out2/html/avatars/default_avatar.jpg" />';
        }
        echo '<br/><strong>' . $row['uname'] . '</strong><br/>';
     echo date('m/d/Y<\b\r/>H:i:s', $row['MESSAGE_DATE']) . '</td>';
        
  echo '<td style="vertical-align:top;">';
        echo '<div><strong>' . htmlspecialchars($row['SUBJECT']) . '</strong></div>';
        echo '<div>' . htmlspecialchars($row['MESSAGE_TEXT']) . '</div>';
        
        echo '<div style="text-align: right;">';
        echo '<a href="'.$_SERVER['PHP_SELF'].'?mode=add_post&fid=' . $row['FORUM_ID'] . '&mid=' .(($row['PARENT_MESSAGE_ID'] != 0) ? $row['PARENT_MESSAGE_ID'] :  $row['MESSAGE_ID']) . '">השב</a>';
        echo '</div>';
        
  echo '</td>';
        
        
 echo '</tr>';
    }
echo '</table>';
    mysql_free_result($result);
}
// generate thread view
else if ($forum_id)
{
    $query = sprintf('SELECT MESSAGE_ID, SUBJECT, ' .
        'UNIX_TIMESTAMP(MESSAGE_DATE) AS MESSAGE_DATE FROM %sFORUM_MESSAGE ' .
        'WHERE PARENT_MESSAGE_ID = 0 AND FORUM_ID = %d ORDER BY ' . 
        'MESSAGE_DATE DESC', DB_TBL_PREFIX, $forum_id);
    $result = mysql_query($query, $GLOBALS['DB']);
    
    if ($total = mysql_num_rows($result))
    {
        // accept the display offset
        $start = (isset($_GET['start']) && ctype_digit($_GET['start']) && $_GET['start'] <= $total) ? $_GET['start'] : 0;

        // move the data pointer to the appropriate starting record
        mysql_data_seek($result, $start);

        // display 25 entries
         echo '<table border=1 id="my_paging_table">';
        $count = 0;
        while ($count++ < 5 && $row = mysql_fetch_array($result))
        {
             echo '<tr><td><h4><a href="'.$_SERVER['PHP_SELF'].'?mode=view_forums&fid=' . $forum_id . '&mid=' . 
                $row['MESSAGE_ID'] . '">';
            echo date('m/d/Y', $row['MESSAGE_DATE']) . ': ';
            echo htmlspecialchars($row['SUBJECT']) . '</td></h4></tr><br/>';
        }
        echo '</table>';
        
/*****************************************************************************************************************************/
        
        
        // Generate the paginiation menu.
        echo '<div style="float:right;text-align:right;">';
        if ($start > 0)
        {
         echo '<a class="my_href_li2" href="'.$_SERVER['PHP_SELF'].'?mode=view_forums&fid=' . $forum_id . '&start=' .($start - 5) . '" style="width:35px;"> הקודם→</a>';
        }
        if ($total > $start + 5)
        {
         echo '<a class="my_href_li2" href="'.$_SERVER['PHP_SELF'].'?mode=view_forums&fid=' . $forum_id . '&start=' . ($start + 5) . '"> ←הבא &nbsp;&nbsp;&nbsp</a>';
        }
        echo '</div>';
    }
    else
    {
        echo '<p>אין הודעות לפורום הזה</p>';
    }
    mysql_free_result($result);
}
// generate forums view
else
{
	 $query = "SELECT FORUM_ID, FORUM_NAME, DESCRIPTION FROM FORUM
	            WHERE status='1' 
	          ORDER BY FORUM_NAME ASC, FORUM_ID ASC  ";
    if($rows =$db-> queryObjectArray($query)  ){
/********************************************************************************/
  
 $mysqli=$db->getMysqli();
 $result = $mysqli->query($query);
 
 if ($total =mysqli_num_rows($result))
    {
    $start = (isset($_GET['cursor']) && ctype_digit($_GET['cursor']) && $_GET['cursor'] <= $total) ? $_GET['cursor'] : 0;
     mysqli_data_seek($result, $start);
    }
/**********************************************************************************/   	
    
     echo '<table style="overflow:hidden;float:left">';

     $i = 0;
    
    while ($i < 5 && $row= mysqli_fetch_assoc($result) ) {  
  	  echo '<tr><td><h4><a class="my_href_select" href="' . $_SERVER['PHP_SELF'].'?mode=view_forums&fid=' . $row['FORUM_ID'] . '">';
        echo htmlspecialchars($row['FORUM_NAME']) . ': ';
        echo '</a> ';
        echo htmlspecialchars($row['DESCRIPTION']) . '</td></h4></tr><br/>';
     $i++;
    }
     
     renderPaging_Msgforum($start,$total);
    echo '</table></fieldset>';
    
   } 
	
}

$GLOBALS['TEMPLATE']['content'] = ob_get_contents();
ob_end_clean();

require_once (LIB_DIR ."/template-page.php");	
}else{
	ob_start();
	echo '<fieldset dir="rtl"  style="list-style:none;  background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>פורומים</legend>
                    <h3 style="font-weight:bold;color:brown;">צפה בפורומים</h3>';		
	 echo '<h4  class="error"  style=" background:white;font-weight:bold;font-size:1.5em;color:green;">הירשם כדי לראות הודעות בפורומים!!!</h4>';
	echo '</fieldset>'; 
	$GLOBALS['TEMPLATE']['content'] = ob_get_contents();
ob_end_clean();
	require_once (LIB_DIR ."/template-page.php");
   }
	
}

/****************************************************************************************************************/
/*****************************************************************************************************/
function edit_forums(){
global $db;

$FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
$op = (isset($_GET['mode'])) ? (string)$_GET['mode'] : 0;


if (($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_GET, 'mode')=='del_forums')  ){
	$FORUM_NAME=(isset($_POST['FORUM_NAME']))?(string)$_POST['FORUM_NAME']:'stam';
	$DESCRIPTION=(isset($_POST['DESCRIPTION']))?(string)$_POST['DESCRIPTION']:'stam';
    $created_dt=(isset($_POST['created_dt']))?(string)$_POST['created_dt']:'stam';
	
	
 
	
 $sql = "UPDATE FORUM SET " .
       " FORUM_NAME="     .  $db->sql_string($FORUM_NAME) . ", " .
       " DESCRIPTION="      .  $db->sql_string($DESCRIPTION) . " , " .	
	   " created_dt="     .  $db->sql_string($created_dt) . "  " .
	   " WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
}




if (array_item($_GET, 'mode')=='del_forums') {
	
if ($FORUM_ID ){	
    $FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
    // assign News id
  $sql="DELETE FROM FORUM WHERE FORUM_ID= $FORUM_ID";
    if(!$db->execute($sql))
	return false;
   }
}


elseif (array_item($_REQUEST,'mode')=='act_forum'){
	
$FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
if($FORUM_ID){	
	$sql="update FORUM SET status=1 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
 

}elseif (array_item($_REQUEST,'mode')=='deact_forum'){
	 
	if($FORUM_ID){   	
	$sql="update FORUM SET status=0 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
}   
    
    elseif (!strcmp($op, "act_forum")) {
   if($FORUM_ID){	
	$sql="update FORUM SET status=1 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
        
    } elseif (!strcmp($op, "deact_forum")) {
     if($FORUM_ID){   	
	$sql="update FORUM SET status=0 WHERE FORUM_ID=$FORUM_ID";
	if(!$db->execute($sql))
	return false;
	} 
	
    }

    require_once (HTML_DIR ."/edit_msgForum.php");

}
/************************************************************************************************************/
function editForum(){
global $db;
 	
$FORUM_ID=(isset($_GET['FORUM_ID']))?(int)$_GET['FORUM_ID']:'0';
$op = (isset($_GET['mode'])) ? (string)$_GET['mode'] : 0;
 
$iCursor = (isset($_GET['cursor'])) ? (int)$_GET['cursor'] : 0;

$sql="SELECT * FROM FORUM WHERE FORUM_ID=$FORUM_ID ";
if($rows=$db->queryObjectArray($sql)){
$row=$rows[0];

if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !(array_item($_GET, 'mode')=='delFORUM')  ){


 if ($FORUM_ID   && !(array_item($_GET, 'mode')=='delFORUM') ){
 	 
 	 require_once (HTML_DIR ."/header.php");
?>
<form action="<?php print SELF ?>?mode=edit_forums&FORUM_ID=<?php print $FORUM_ID ?>" method="post"    dir="rtl">
 
<fieldset dir="rtl"  style="margin-top:50px; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<table border="0" cellpadding="0" cellspacing="0" id="theList">
   
   
    <tr>
        <td colspan="2" style="width:55px;" > שם הפורום:<input size="70"  type="text" name="FORUM_NAME" value="<?php print clean($row->FORUM_NAME) ?>" class="textfield" /></td>
    </tr>
  
    
    <tr>
         <td colspan="2" style="width:55px;" > תאור:<input size="70"  type="text" name="DESCRIPTION" value="<?php print clean($row->DESCRIPTION) ?>" class="textfield" /></td>
    </tr>
    
 
    <tr>
         <td colspan="2" style="width:55px;" > תאריך:<input size="15"  type="text"  id="FORUM_DT"   name="created_dt" value="<?php print substr($row->created_dt,0,10) ?>" class="textfield" /></td>
    </tr>
 
 
    <tr>
        <td class="dotrule" colspan="2"><img src="<?php echo IMAGES_DIR ?>/spc.gif" width="1" height="15" alt="" border="0" /></td>
    </tr>
    <tr>
        <td align="right" colspan="2">
           <button class="green90x24" type="submit" name="submitbutton"  id="submitbutton" >שלח</button>  
       </td>
    </tr>
</table>
</fieldset>
</form>
	
<?php	
  }else return;	
}else return;	
}else return;	
}
/************************************************************************************************************/








////////////////////////////////////////////////////////////////////////////////////
                                           //BLOGS                                //            
////////////////////////////////////////////////////////////////////////////////////
function add_blog($element=""){
	
global $db;	
	
 

$POST_ID=(isset($_GET['POST_ID']))?(int)$_GET['POST_ID']:'0';
$POST_COMMENT=(isset($_GET['POST_COMMENT']))?(string)$_GET['POST_COMMENT']:'';
if($POST_COMMENT && $POST_COMMENT!=''){
$POST_COMMENT=$db->getMysqli()->real_escape_string($POST_COMMENT);	
 $POST_COMMENT=$db->sql_string($POST_COMMENT);
}

$op = (isset($_GET['mode'])) ? (string)$_GET['mode'] : 0;




if (array_item($_GET, 'mode')=='del_Msgblog') {
	
if ($POST_ID){	
    
  $sql="DELETE FROM BLOG_COMMENT WHERE POST_ID= $POST_ID AND POST_COMMENT=$POST_COMMENT ";
    if(!$db->execute($sql))
	return false;
   }
}


elseif (array_item($_REQUEST,'mode')=='act_blog'){
	
 
if($POST_ID){	
	$sql="update BLOG_COMMENT SET status=1 WHERE POST_ID=$POST_ID AND POST_COMMENT=$POST_COMMENT ";
	if(!$db->execute($sql))
	return false;
	} 
 

}elseif (array_item($_REQUEST,'mode')=='deact_blog'){
	 
	if($POST_ID){   	
	$sql="update BLOG_COMMENT SET status=0 WHERE  POST_ID=$POST_ID AND POST_COMMENT=$POST_COMMENT ";
	if(!$db->execute($sql))
	return false;
	} 
}   
    
    elseif (!strcmp($op, "act_blog")) {
   if($POST_ID){	
	$sql="update BLOG_COMMENT SET status=1 WHERE POST_ID=$POST_ID AND POST_COMMENT=$POST_COMMENT ";
	if(!$db->execute($sql))
	return false;
	} 
        
    } elseif (!strcmp($op, "deact_blog")) {
     if($POST_ID){   	
	$sql="update BLOG_COMMENT SET status=0 WHERE  POST_ID=$POST_ID  AND POST_COMMENT=$POST_COMMENT ";
	if(!$db->execute($sql))
	return false;
	} 
	
    }
 
   require_once   (HTML_DIR.'/edit_blog.php');
 
}//end func 
/******************************************************************************************/



/******************************************************************************************/

function post_admin(){

 //	include '402.php';
		
global $dbc;


if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD))
{
    die('Error: Unable to connect to database server.');
}
if (!mysql_select_db(DB_SCHEMA, $GLOBALS['DB']))
{
    mysql_close($GLOBALS['DB']);
    die('Error: Unable to select database schema.');
}

if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}

		

		
		
$_POST['post_id']=(isset($_POST['post_id']))?(string)$_POST['post_id']:'stam';
		
		
		
		
// insert a new blog entry
if ($_POST['post_id'] == 'new')
{
	
	if (!empty($_POST['post_title'])) {
		$t = mysqli_real_escape_string($dbc, strip_tags($_POST['post_title']));
	} else {
		
	$element= '<p class="error">אנא כתוב כותרת</p>';
		add_blog($element);
		exit(); 		
	}		
	
	
    $query = sprintf('INSERT INTO %sBLOG_POST SET POST_TITLE = "%s", ' .
        'POST_DATE = "%s", POST_TEXT = "%s"',
        DB_TBL_PREFIX,
        mysql_real_escape_string($_POST['post_title'], $GLOBALS['DB']),
         mysql_real_escape_string($_POST['post_date'], $GLOBALS['DB']),
         mysql_real_escape_string($_POST['post_text'], $GLOBALS['DB']));
    
    mysql_query($query, $GLOBALS['DB']);
}
else
{
    // delete entry
    if (isset($_POST['delete']))
    {
        $query = sprintf('DELETE FROM %sBLOG_POST WHERE POST_ID = %d',
            DB_TBL_PREFIX, $_POST['post_id']);

        mysql_query($query, $GLOBALS['DB']);
    }
    // update entry
    else
    {
    	
    	 $query = sprintf('UPDATE %sBLOG_POST SET POST_TITLE = "%s", ' .
            'POST_DATE = "%s", POST_TEXT = "%s" WHERE POST_ID = %d',
            DB_TBL_PREFIX,
            mysql_real_escape_string($_POST['post_title'], $GLOBALS['DB']),
            mysql_real_escape_string($_POST['post_date'], $GLOBALS['DB']),
           // mysql_format_date($_POST['post_date']),
            mysql_real_escape_string($_POST['post_text'], $GLOBALS['DB']),
            $_POST['post_id']);
    	
    	
    	
    	
//        $query = sprintf('UPDATE %sBLOG_POST SET POST_TITLE = "%s", ' .
//            'POST_DATE = "%s", POST_TEXT = "%s" WHERE POST_ID = %d',
//            DB_TBL_PREFIX,
//            mysql_real_escape_string($_POST['post_title'], $GLOBALS['DB']),
//            mysql_format_date($_POST['post_date']),
//            mysql_real_escape_string($_POST['post_text'], $GLOBALS['DB']),
//            $_POST['post_id']);
        
        mysql_query($query, $GLOBALS['DB']);
    }
}
mysql_close($GLOBALS['DB']);

add_blog();
	
} 
/******************************************************************************************/
function view_blogs(){

if (isset($_SESSION['user_not_expired'])){  	
global $dbc;


if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD))
{
    die('Error: Unable to connect to database server.');
}
if (!mysql_select_db(DB_SCHEMA, $GLOBALS['DB']))
{
    mysql_close($GLOBALS['DB']);
    die('Error: Unable to select database schema.');
}

if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}

		

		
		
$_POST['post_id']=(isset($_POST['post_id']))?(string)$_POST['post_id']:'stam';
			
	
	
	
	
	
// determine current viewed month and year
$timestamp = (isset($_GET['t'])) ? $_GET['t'] : time();
list($month, $year) = explode('/', date('m/Y', $timestamp));

// Javascript references
$GLOBALS['TEMPLATE']['extra_head'] = <<<ENDHTML
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/log_inout.js"         charset="utf-8"              type="text/javascript"></script>
<script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/blog_admin.js"         charset="utf-8"              type="text/javascript"></script>
ENDHTML;

// retrieve entries for currently viewed month
$query = sprintf('
    SELECT
        POST_ID, POST_TITLE, POST_TEXT,
        UNIX_TIMESTAMP(POST_DATE) AS POST_DATE
    FROM
        %sBLOG_POST
    WHERE
        DATE(POST_DATE) BETWEEN
            "%d-%02d-01" AND 
            DATE("%d-%02d-01") + INTERVAL 1 MONTH - INTERVAL 1 DAY
    ORDER BY
        POST_DATE DESC',
    DB_TBL_PREFIX,
    $year,  $month,
    $year, $month);
$result = mysql_query($query, $GLOBALS['DB']);

ob_start();
echo '<fieldset  dir="rtl"  style="overflow:auto; background: #94C5EB url(../../images/background-grad.png) repeat-x;" >
<legend>תגובות/הערות</legend>';
while ($record = mysql_fetch_assoc($result))
{
    echo '<h2 style="text-align:right;color:yellow;">' . $record['POST_TITLE'] . '</h2>';
    echo '<div  style="text-align:right;color:white; ">' . date('m/d/Y', $record['POST_DATE']) . '</div>';
    echo '<div style="text-align:right;color:red;align-right; ">' . $record['POST_TEXT'] .'</div>';
//    echo $record['POST_TEXT'];
//    echo '</p>';
    echo '<div style="display:none;" id="comments_' . $record['POST_ID'] . '" ></div>';
    echo '<p><a href="#" onclick="toggleComments(' . $record['POST_ID'] . ', this);return false;">צפה בהערות</a></p>';
    echo '<hr/>';
}
mysql_free_result($result);

// generate link to view previous month if appropriate
$query = sprintf('SELECT UNIX_TIMESTAMP(POST_DATE) AS POST_DATE ' .
    'FROM %sBLOG_POST ORDER BY POST_DATE DESC',
     DB_TBL_PREFIX);
$result = mysql_query($query, $GLOBALS['DB']);
if (mysql_num_rows($result))
{

    // determine date of newest post
    $row = mysql_fetch_assoc($result);
    $newest = $row['POST_DATE'];

    // determine date of oldest post
    mysql_data_seek($result, mysql_num_rows($result) - 1);
    $row = mysql_fetch_assoc($result);
    $oldest = $row['POST_DATE'];

    if ($timestamp > $oldest)
    { // echo '<tr> a href="'.$_SERVER['PHP_SELF'].'?mode=view_forums&fid=' . $forum_id . '&mid=' .
        echo '<a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?mode=view_blogs&t=' . strtotime('-1 month', $timestamp) . '">→הקודם</a> ';
    }

    if ($timestamp < $newest)
    {
        echo ' <a href="' . htmlspecialchars($_SERVER['PHP_SELF']) .'?mode=view_blogs&t=' . strtotime('+1 month', $timestamp) . '">&nbsp;&nbsp;הבא←</a>';
    }

}
mysql_free_result($result);

// link to RSS feed
$GLOBALS['TEMPLATE']['head_extra'] = '<link rel="alternate" ' . 
    'type="application/rss+xml"  href="rss.php" title="My Blog">';

echo '<p><a href="rss.php">RSS Feed</a></p></fieldset>';
$GLOBALS['TEMPLATE']['content'] = ob_get_clean();


require_once (LIB_DIR ."/template-page.php");
mysql_close($GLOBALS['DB']);
	
  }else{
	ob_start();
	echo '<fieldset dir="rtl"  style="list-style:none;  background: #94C5EB url(../../images/background-grad.png) repeat-x;" ><legend>בלוג</legend>
                    <h3 style="font-weight:bold;color:brown;">כנס לבלוג</h3>';		
	 echo '<h4  class="error"  style=" background:white;font-weight:bold;font-size:1.5em;color:green;">הירשם כדי להשתתף בבלוג!!!</h4>';
	echo '</fieldset>'; 
	$GLOBALS['TEMPLATE']['content'] = ob_get_contents();
ob_end_clean();
	require_once (LIB_DIR ."/template-page.php");
   }
  
} 

/*****************************************************************************************************/















/**************************************************************************************/
/**************************************************************************************/            
/**************************************************************************************/
/**************************************************************************************/            
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/                                        
////////////    
}         //end class User
///////////
?>
