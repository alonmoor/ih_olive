<?PHP
	class Auth
	{
		public $user_id;
		public $username;
		public $password;
		public $level;           // Admin, User, etc.
		public $domain;
		public $salt;            // Used to compute password hash
		public $user;            // DBObject User class if available
		public $useHash;
		private $loggedIn = false;

		// Call with no arguments to attempt to restore a previous logged in session
		// which then falls back to a guest user (which can then be logged in using
		// $this->login($un, $pw). Or pass a user_id to simply login that user. The
		// $seriously is just a safeguard to be certain you really do want to blindly
		// login a user. Set it to true.
		public function __construct($user_id = null, $seriously = false)
		{
			global $db;

			$this->user_id  = 0;
			$this->username = 'Guest';
			$this->salt     = Config::$auth_salt;
			$this->domain   = isset(Config::$auth_domain) ? Config::$auth_domain : '';
			$this->useHash  = isset(Config::$auth_hash) ? Config::$auth_hash : false;

			// Load a User DBObject if possible
			if(class_exists('User') && (get_parent_class('User') == 'DBObject3'))
				$this->user = new User();

			// Allow login via user_id passed into constructor
			if(ctype_digit($user_id) && ($seriously === true))
				return $this->impersonate($user_id);
			elseif($this->checkSession()) // But normally we login via a session...
				return true;
			elseif($this->checkCookie()) //  or cookie variable
 			return true;
			else
				return false;
		}

		// Verify a login from PHP's session store
		private function checkSession()
		{
			if(!empty($_SESSION['auth_username']) && !empty($_SESSION['auth_password']))
				return $this->check($_SESSION['auth_username'], $_SESSION['auth_password']);
		}

		
    
		
		
		
		// Verify a login from a cookie
		private function checkCookie()
		{
			if(!empty($_COOKIE['auth_username']) && !empty($_COOKIE['auth_password']))
				return $this->check($_COOKIE['auth_username'], $_COOKIE['auth_password']);
		}

		// Verify a username and password from a previously authenticated session.
		// Basically, it accepts the hashed password rather than the plain text that a user would submit during
		// an active login process.
		private function check($username, $password)
		{
			global $db;
			$db->query("SELECT * FROM users WHERE uname = ?", $username);
			//if(mysql_num_rows($db->result) == 1)
            $num_rows = mysqli_num_rows($db->result);
            if($num_rows == 1)
			{
				//$row = mysql_fetch_array($db->result, MYSQL_ASSOC);
                $row = mysqli_fetch_array($db->result,MYSQLI_ASSOC);
				$db_password = $row['upass'];

				// This looks backwards, but it really is correct!
				if($this->useHash == false)
					$db_password = sha1($db_password . $this->salt);

				// If password is ok
				if($db_password == $password)
				{
					$this->doLogin($row);
					$this->storeSessionData($row['uname'], $row['upass'],$row['level']);
					return true;
				}
			}else if($num_rows == 0){
                //echo "invalid username";
               return;
            }else{
             echo "username allready exist ";
			$this->loggedIn = false;
			return false;
          }
		}

		// Actively login a user
		public function login($username, $password)
		{
			global $db;

			$db_password = $this->makePassword($password);
             $db->query("SELECT * FROM users WHERE uname = " . $db->quote($username) . " AND upass  = " . $db->quote($db_password));
//			$result = $db->query("SELECT * FROM users WHERE uname = " . $db->quote($username) . " AND upass  = " . $db->quote($db_password));
//			if(mysql_num_rows($db->result) == 1)
            $num_rows = mysqli_num_rows($db->result);
            if($num_rows == 1)
			{
				//$row = mysql_fetch_array($db->result, MYSQL_ASSOC);
                $row = mysqli_fetch_array($db->result,MYSQLI_ASSOC);
				$this->doLogin($row);
				$this->storeSessionData($row['uname'], $row['upass'],$row['level']);
				return true;
			}
			else
			{
				$this->loggedIn = false;
				return false;
			}
		}

		// Once the login is authenticated, setup the $auth object.
		private function doLogin($row)
		{
			// Load the most basic user info
			$this->user_id  = $row['userID'];
			$this->username = $row['uname'];
			$this->level    = $row['level'];

			// Load any additional user info if DBObject and User are available
			if(class_exists('User') && (get_parent_class('User') == 'DBObject3'))
			{
				$this->user = new User();
				$this->user->id = $this->user_id;
				$this->user->load($row);
			}

			$this->loggedIn = true;
		}
		
		public function impersonate($user)
		{
			global $db;

			if(ctype_digit($user))
				$result = $db->query("SELECT * FROM users WHERE userID = " . $db->quote($user));
			else
				$result = $db->query("SELECT * FROM users WHERE uname = " . $db->quote($user));

			if(mysql_num_rows($result) == 1)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
				$this->doLogin($row);
				$this->storeSessionData($row['uname'], $row['upass']);
				return true;
			}
			else
			{
				$this->loggedIn = false;
				return false;
			}
		}

		// Save login in a session and cookie
		private function storeSessionData($username, $password,$level)
		{
		   $_SESSION['auth_username'] = $username;
			$_SESSION['auth_password'] = $this->useHash ? $password : sha1($password . $this->salt);
			$_SESSION['auth_level'] = $level;
			setcookie('auth_username', $_SESSION['auth_username'], time()+60*60*24*30, '/', $this->domain);
			setcookie('auth_password', $_SESSION['auth_password'], time()+60*60*24*30, '/', $this->domain);
		}

 
		 function authenticate_user() {
            header('WWW-Authenticate: Basic realm="Secret Stash"');
            header("HTTP/1.0 401 Unauthorized");
          exit;//redirect(WEB_ROOT);  // exit;
         }
		
		
		
//	    public	 function authenticate_user() {
//        header('WWW-Authenticate:"מערכת החלטות עין השופט"');
//        header("HTTP/1.0 401 Unauthorized");
//       exit;
//      }
		
		// Logout the user
		public function logout()
		{
		
			$this->userID = 0;
			$this->uname = 'Guest';
			$this->user = new User();
			
			

			$_SESSION['auth_username'] = '';
			$_SESSION['auth_password'] = '';
			$_SESSION['auth_level'] = '';
			
			$_SESSION['admin'] = '';
			$_SESSION['uname'] = '';
			$_SESSION['user'] = '';
			$_SESSION['user_admin'] = '';
			$_SESSION['suppervizer'] = '';
			unset($_SESSION['level']);
			unset($_SESSION['admin']);
			unset($_SESSION['uname']);
			unset($_SESSION['user']);
			unset($_SESSION['user_admin']);
			unset($_SESSION['suppervizer']);
			unset($_SESSION['upass']);
			unset($_SESSION['userID']);
	 
			setcookie('auth_username', '', time() - 3600, '/', $this->domain);
			setcookie('auth_password', '', time() - 3600, '/', $this->domain);
           
           
			$this->loggedIn = false;
		
			
		}

		// Is the user (of any level) logged in?
		public function ok()
		{
			return $this->loggedIn;
		}

		// Helper function that redirects away from 'admin only' pages
		public function admin($url = null)
		{
			if(is_null($url)) $url = WEB_ROOT . 'login/';
			if($this->level != 'admin')
				redirect($url);
		}

		// Helper function that redirects away from 'member only' pages
		public function user($url = null)
		{
			if(is_null($url)) $url = WEB_ROOT . 'login/';
			if($this->ok() === false)
				redirect($url);
		}

		// Returns the hashed version of a password if $this->md5 is turned on
		public function makePassword($pw)
		{
			return $this->useHash ? sha1($pw . $this->salt) : $pw;
		}
	}
