<?PHP
	// Creates a friendly URL slug from a string
	function slugify($str)
	{
		$str = preg_replace('/[^a-zA-Z0-9 -]/', '', $str);
		$str = strtolower(str_replace(' ', '-', trim($str)));
		$str = preg_replace('/-+/', '-', $str);
		return $str;
	}

	// Computes the *full* URL of the current page (protocol, server, path, query parameters, etc)
	function full_url()
	{
		$s = empty($_SERVER['HTTPS']) ? '' : ($_SERVER['HTTPS'] == 'on') ? 's' : '';
		$protocol = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos(strtolower($_SERVER['SERVER_PROTOCOL']), '/')) . $s;
		$port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (":".$_SERVER['SERVER_PORT']);
		return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	}

	// Returns an English representation of a past date within the last month
	// Graciously stolen from http://ejohn.org/files/pretty.js
	function time2str($ts)
	{
		if(!ctype_digit($ts))
			$ts = strtotime($ts);

		$diff = time() - $ts;
		if($diff == 0)
			return 'now';
		elseif($diff > 0)
		{
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 60) return 'just now';
				if($diff < 120) return '1 minute ago';
				if($diff < 3600) return floor($diff / 60) . ' minutes ago';
				if($diff < 7200) return '1 hour ago';
				if($diff < 86400) return floor($diff / 3600) . ' hours ago';
			}
			if($day_diff == 1) return 'Yesterday';
			if($day_diff < 7) return $day_diff . ' days ago';
			if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
			if($day_diff < 60) return 'last month';
			return date('F Y', $ts);
		}
		else
		{
			$diff = abs($diff);
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 120) return 'in a minute';
				if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
				if($diff < 7200) return 'in an hour';
				if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
			}
			if($day_diff == 1) return 'Tomorrow';
			if($day_diff < 4) return date('l', $ts);
			if($day_diff < 7 + (7 - date('w'))) return 'next week';
			if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
			if(date('n', $ts) == date('n') + 1) return 'next month';
			return date('F Y', $ts);
		}
	}

	// Returns an array representation of the given calendar month.
	// The array values are timestamps which allow you to easily format
	// and manipulate the dates as needed.
	function calendar($month = null, $year = null)
	{
		if(is_null($month)) $month = date('n');
		if(is_null($year)) $year = date('Y');

		$first = mktime(0, 0, 0, $month, 1, $year);
		$last = mktime(23, 59, 59, $month, date('t', $first), $year);

		$start = $first - (86400 * date('w', $first));
		$stop = $last + (86400 * (7 - date('w', $first)));

		$out = array();
		while($start < $stop)
		{
			$week = array();
			if($start > $last) break;
			for($i = 0; $i < 7; $i++)
			{
				$week[$i] = $start;
				$start += 86400;
			}
			$out[] = $week;
		}

		return $out;
	}

	// Processes mod_rewrite URLs into key => value pairs
	// See .htacess for more info.
	function pick_off($grab_first = false, $sep = '/')
	{
		$ret = array();
		$arr = explode($sep, trim($_SERVER['REQUEST_URI'], $sep));
		if($grab_first) $ret[0] = array_shift($arr);
		while(count($arr) > 0)
			$ret[array_shift($arr)] = array_shift($arr);
		return (count($ret) > 0) ? $ret : false;
	}

	// Creates a list of <option>s from the given database table.
	// table name, column to use as value, column(s) to use as text, default value(s) to select (can accept an array of values), extra sql to limit results
	function get_options($table, $val, $text, $default = null, $sql = '')
	{
		global $db;
		$out = '';

		$db->query("SELECT * FROM `$table` $sql");
		while($row = mysql_fetch_array($db->result, MYSQL_ASSOC))
		{
			$the_text = '';
			if(!is_array($text)) $text = array($text); // Allows you to concat multiple fields for display
			foreach($text as $t)
				$the_text .= $row[$t] . ' ';
			$the_text = htmlspecialchars(trim($the_text));

			if(!is_null($default) && $row[$val] == $default)
				$out .= '<option value="' . htmlspecialchars($row[$val], ENT_QUOTES) . '" selected="selected">' . $the_text . '</option>';
			elseif(is_array($default) && in_array($row[$val],$default))
				$out .= '<option value="' . htmlspecialchars($row[$val], ENT_QUOTES) . '" selected="selected">' . $the_text . '</option>';
			else
				$out .= '<option value="' . htmlspecialchars($row[$val], ENT_QUOTES) . '">' . $the_text . '</option>';
		}
		return $out;
	}

	// Converts a date/timestamp into the specified format
	function dater($format = null, $date = null)
	{
		if(is_null($format))
			$format = "Y-m-d H:i:s";

		if(is_null($date))
			$date = time();

		// if $date contains only numbers, treat it as a timestamp
		if(ctype_digit($date) === true)
			return date($format, $date);
		else
			return date($format, strtotime($date));
	}

	// Formats a phone number as (xxx) xxx-xxxx or xxx-xxxx depending on the length.
	function format_phone($phone)
	{
		$phone = preg_replace("/[^0-9]/", '', $phone);

		if(strlen($phone) == 7)
			return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		elseif(strlen($phone) == 10)
			return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		else
			return $phone;
	}

	// Outputs hour, minute, am/pm dropdown boxes
	function hourmin($hid = 'hour', $mid = 'minute', $pid = 'ampm', $hval = null, $mval = null, $pval = null)
	{
		if(is_null($hval)) $hval = date('h');
		if(is_null($mval)) $mval = date('i');
		if(is_null($pval)) $pval = date('a');

		$hours = array(12, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11);
		$out = "<select name='$hid' id='$hid'>";
		foreach($hours as $hour)
			if(intval($hval) == intval($hour)) $out .= "<option value='$hour' selected>$hour</option>";
			else $out .= "<option value='$hour'>$hour</option>";
		$out .= "</select>";

		$minutes = array('00', 15, 30, 45);
		$out .= "<select name='$mid' id='$mid'>";
		foreach($minutes as $minute)
			if(intval($mval) == intval($minute)) $out .= "<option value='$minute' selected>$minute</option>";
			else $out .= "<option value='$minute'>$minute</option>";
		$out .= "</select>";
		
		$out .= "<select name='$pid' id='$pid'>";
		$out .= "<option value='am'>am</option>";
		if($pval == 'pm') $out .= "<option value='pm' selected>pm</option>";
		else $out .= "<option value='pm'>pm</option>";
		$out .= "</select>";
		
		return $out;
	}

	// Outputs month, day, and year dropdown boxes with default values and custom id/names
	function mdy($mid = 'month', $did = 'day', $yid = 'year', $mval = null, $dval = null, $yval = null)
	{
		// Dumb hack to let you just pass in a timestamp instead
		if(func_num_args() == 1)
		{
			list($yval, $mval, $dval) = explode(' ', date('Y m d', $mid));
			$mid = 'month';
			$did = 'day';
			$yid = 'year';
		}
		else
		{
			if(is_null($mval)) $mval = date('m');
			if(is_null($dval)) $dval = date('d');
			if(is_null($yval)) $yval = date('Y');
		}
		
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$out = "<select name='$mid' id='$mid'>";
		foreach($months as $val => $text)
			if($val == $mval) $out .= "<option value='$val' selected>$text</option>";
			else $out .= "<option value='$val'>$text</option>";
		$out .= "</select> ";

		$out .= "<select name='$did' id='$did'>";
		for($i = 1; $i <= 31; $i++)
			if($i == $dval) $out .= "<option value='$i' selected>$i</option>";
			else $out .= "<option value='$i'>$i</option>";
		$out .= "</select> ";

		$out .= "<select name='$yid' id='$yid'>";
		for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
			if($i == $yval) $out.= "<option value='$i' selected>$i</option>";
			else $out.= "<option value='$i'>$i</option>";
		$out .= "</select>";
		
		return $out;
	}

	// Redirects user to $url
	function redirect($url = null)
	{
 
	 	if(is_null($url)) $url =$_SERVER['SCRIPT_NAME'];
       	header("Location: $url");
       		unset($_SESSION);
session_destroy();
 		exit();
	}

	// Ensures $str ends with a /
	function slash($str)
	{
		return rtrim($str, '/') . '/';
	}

	// Ensures $str DOES NOT end with a /
	function antislash($str)
	{
		return rtrim($str, '/');
	}

	function gimme($arr, $key = null)
	{
		$first_key = array_shift(array_keys($arr));
		if(count($arr) == 0) return array();
		if(is_null($key)) $key = array_shift(array_keys($arr[$first_key]));
		if(!isset($arr[$first_key][$key])) return array();
		foreach($arr as $a) $ret[] = $a[$key];
		return $ret;
	}

	// Fixes MAGIC_QUOTES
	function fix_slashes($arr = '')
	{
		if(is_null($arr) || $arr == '') return null;
		if(!get_magic_quotes_gpc()) return $arr;
		return is_array($arr) ? array_map('fix_slashes', $arr) : stripslashes($arr);
	}

	// Returns the first $num words of $str
	function max_words($str, $num)
	{
		$words = explode(' ', $str);
		if(count($words) < $num)
			return $str;
		else
			return implode(' ', array_slice($words, 0, $num));
	}

	// Serves an external document for download as an HTTP attachment.
	function download_document($filename, $mimetype = 'application/octet-stream')
	{
		if(!file_exists($filename) || !is_readable($filename)) return false;
		$base = basename($filename);
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Disposition: attachment; filename=$base");
		header("Content-Length: " . filesize($filename));
		header("Content-Type: $mimetype");
		readfile($filename);
		exit();
	}
	
	// Retrieves the filesize of a remote file.
	function remote_filesize($url, $user = null, $pw = null)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if(!is_null($user) && !is_null($pw))
		{
			$headers = array('Authorization: Basic ' .  base64_encode("$user:$pw"));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		$head = curl_exec($ch);
		curl_close($ch);

		$regex = '/Content-Length:\s([0-9].+?)\s/';
		preg_match($regex, $head, $matches);

		return isset($matches[1]) ? $matches[1] : 'unknown';
	}	

	// Outputs a filesize in human readable format.
	function bytes2str($val, $round = 0)
	{
		$unit = array('','K','M','G','T','P','E','Z','Y');
		while($val >= 1000)
		{
			$val /= 1024;
			array_shift($unit);
		}
		return round($val, $round) . array_shift($unit) . 'B';
	}
	
	// Tests for a valid email address and optionally tests for valid MX records, too.
	function valid_email($email, $test_mx = false)
	{
		if(eregi("^([_a-z0-9+-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
		{
			if($test_mx)
			{
				list( , $domain) = split("@", $email);
				return getmxrr($domain, $mxrecords);
			}
			else
				return true;
		}
		else
			return false;
	}

	// Grabs the contents of a remote URL. Can perform basic authentication if un/pw are provided.
	function geturl($url, $username = null, $password = null)
	{
		if(function_exists('curl_init'))
		{
			$ch = curl_init();
			if(!is_null($username) && !is_null($password))
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' .  base64_encode("$username:$password")));
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			$html = curl_exec($ch);
			curl_close($ch);
			return $html;
		}
		elseif(ini_get('allow_url_fopen') == true)
		{
			if(!is_null($username) && !is_null($password))
				$url = str_replace("://", "://$username:$password@", $url);
			$html = file_get_contents($url);
			return $html;
		}
		else
		{
			// Cannot open url. Either install curl-php or set allow_url_fopen = true in php.ini
			return false;
		}
	}

	// Returns the user's browser info.
	// browscap.ini must be available for this to work.
	// See the PHP manual for more details.
	function browser_info()
	{
		$info    = get_browser(null, true);
		$browser = $info['browser'] . ' ' . $info['version'];
		$os      = $info['platform'];	
		$ip      = $_SERVER['REMOTE_ADDR'];		
		return array('ip' => $ip, 'browser' => $browser, 'os' => $os);
	}

	// Quick wrapper for preg_match
	function match($regex, $str, $i = 0)
	{
		if(preg_match($regex, $str, $match) == 1)
			return $match[$i];
		else
			return false;
	}

	// Sends an HTML formatted email
	function send_html_mail($to, $subject, $msg, $from, $plaintext = '')
	{
		if(!is_array($to)) $to = array($to);
		
		foreach($to as $address)
		{
			$boundary = uniqid(rand(), true);

			$headers  = "From: $from\n";
			$headers .= "MIME-Version: 1.0\n"; 
			$headers .= "Content-Type: multipart/alternative; boundary = $boundary\n";
			$headers .= "This is a MIME encoded message.\n\n"; 
			$headers .= "--$boundary\n" . 
			   			"Content-Type: text/plain; charset=utf-8\n" .
			   			"Content-Transfer-Encoding: base64\n\n"; 
			$headers .= chunk_split(base64_encode($plaintext)); 
			$headers .= "--$boundary\n" . 
			   			"Content-Type: text/html; charset=utf-8\n" . 
			   			"Content-Transfer-Encoding: base64\n\n";
			$headers .= chunk_split(base64_encode($msg));
			$headers .= "--$boundary--\n" . 

			mail($address, $subject, '', $headers);
		}		
	}

	// Returns the lat, long of an address via Google
	function geocode($address, $key, $output = 'csv')
	{
		$address = urlencode($address);
		$key     = urlencode($key);
		$data    = geturl("http://maps.google.com/maps/geo?q=$address&key=$key&output=$output");

		if($output == 'csv')
			return explode(',', $data); // HTTP status code, accuracy bit, latitude, longitude
		elseif ($output == 'xml')
		{
			$xml = simplexml_load_string($data);
			if($xml === FALSE) return FALSE;
			if($xml->Response->Status->code != '200') return FALSE;
			return explode(',', (string) $xml->Response->Placemark->Point->coordinates); // latitude, longitude, ???
		}
		else
			return $data;
	}

	// Quick and dirty wrapper for curl
	function curl($url, $referer = null, $post = null)
	{
		global $last_url;
		static $tmpfile;
		
		if(!isset($tmpfile) || ($tmpfile == '')) $tmpfile = tempnam('/tmp', 'FOO');
	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfile);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfile);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.1) Gecko/20061024 BonEcho/2.0");
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_VERBOSE, 1);

		if($referer) curl_setopt($ch, CURLOPT_REFERER, $referer);
		if(!is_null($post))
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		$html = curl_exec($ch);
	
		$last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		return $html;
	}

	// Accepts any number of arguments and returns the first non-empty one
	function pick()
	{
		foreach(func_get_args() as $arg)
			if(!empty($arg))
				return $arg;
		return '';
	}

	// Secure a PHP script using basic HTTP authentication
	function http_auth($un, $pw, $realm = "Secured Area")
	{
		if(!(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_USER'] == $un && $_SERVER['PHP_AUTH_PW'] == $pw))
		{
			header('WWW-Authenticate: Basic realm="$realm"');
			header('Status: 401 Unauthorized');
			exit(); //???
		}
	}

	// This is easier than typing 'echo WEB_ROOT'
	function WEBROOT()
	{
		echo WEB_ROOT;
	}

	// Class Autloader
	function __autoload($class_name)
	{
		require DOC_ROOT . '/includes/class.' . strtolower($class_name) . '.php';
	}

	// Returns a file's mimetype based on its extension
	function mime_type($filename)
	{
		$mime_types = array('323'     => 'text/h323',
							'acx'     => 'application/internet-property-stream',
							'ai'      => 'application/postscript',
							'aif'     => 'audio/x-aiff',
							'aifc'    => 'audio/x-aiff',
							'aiff'    => 'audio/x-aiff',
							'asf'     => 'video/x-ms-asf',
							'asr'     => 'video/x-ms-asf',
							'asx'     => 'video/x-ms-asf',
							'au'      => 'audio/basic',
							'avi'     => 'video/x-msvideo',
							'axs'     => 'application/olescript',
							'bas'     => 'text/plain',
							'bcpio'   => 'application/x-bcpio',
							'bin'     => 'application/octet-stream',
							'bmp'     => 'image/bmp',
							'c'       => 'text/plain',
							'cat'     => 'application/vnd.ms-pkiseccat',
							'cdf'     => 'application/x-cdf',
							'cer'     => 'application/x-x509-ca-cert',
							'class'   => 'application/octet-stream',
							'clp'     => 'application/x-msclip',
							'cmx'     => 'image/x-cmx',
							'cod'     => 'image/cis-cod',
							'cpio'    => 'application/x-cpio',
							'crd'     => 'application/x-mscardfile',
							'crl'     => 'application/pkix-crl',
							'crt'     => 'application/x-x509-ca-cert',
							'csh'     => 'application/x-csh',
							'css'     => 'text/css',
							'dcr'     => 'application/x-director',
							'der'     => 'application/x-x509-ca-cert',
							'dir'     => 'application/x-director',
							'dll'     => 'application/x-msdownload',
							'dms'     => 'application/octet-stream',
							'doc'     => 'application/msword',
							'dot'     => 'application/msword',
							'dvi'     => 'application/x-dvi',
							'dxr'     => 'application/x-director',
							'eps'     => 'application/postscript',
							'etx'     => 'text/x-setext',
							'evy'     => 'application/envoy',
							'exe'     => 'application/octet-stream',
							'fif'     => 'application/fractals',
							'flr'     => 'x-world/x-vrml',
							'gif'     => 'image/gif',
							'gtar'    => 'application/x-gtar',
							'gz'      => 'application/x-gzip',
							'h'       => 'text/plain',
							'hdf'     => 'application/x-hdf',
							'hlp'     => 'application/winhlp',
							'hqx'     => 'application/mac-binhex40',
							'hta'     => 'application/hta',
							'htc'     => 'text/x-component',
							'htm'     => 'text/html',
							'html'    => 'text/html',
							'htt'     => 'text/webviewhtml',
							'ico'     => 'image/x-icon',
							'ief'     => 'image/ief',
							'iii'     => 'application/x-iphone',
							'ins'     => 'application/x-internet-signup',
							'isp'     => 'application/x-internet-signup',
							'jfif'    => 'image/pipeg',
							'jpe'     => 'image/jpeg',
							'jpeg'    => 'image/jpeg',
							'jpg'     => 'image/jpeg',
							'js'      => 'application/x-javascript',
							'latex'   => 'application/x-latex',
							'lha'     => 'application/octet-stream',
							'lsf'     => 'video/x-la-asf',
							'lsx'     => 'video/x-la-asf',
							'lzh'     => 'application/octet-stream',
							'm13'     => 'application/x-msmediaview',
							'm14'     => 'application/x-msmediaview',
							'm3u'     => 'audio/x-mpegurl',
							'man'     => 'application/x-troff-man',
							'mdb'     => 'application/x-msaccess',
							'me'      => 'application/x-troff-me',
							'mht'     => 'message/rfc822',
							'mhtml'   => 'message/rfc822',
							'mid'     => 'audio/mid',
							'mny'     => 'application/x-msmoney',
							'mov'     => 'video/quicktime',
							'movie'   => 'video/x-sgi-movie',
							'mp2'     => 'video/mpeg',
							'mp3'     => 'audio/mpeg',
							'mpa'     => 'video/mpeg',
							'mpe'     => 'video/mpeg',
							'mpeg'    => 'video/mpeg',
							'mpg'     => 'video/mpeg',
							'mpp'     => 'application/vnd.ms-project',
							'mpv2'    => 'video/mpeg',
							'ms'      => 'application/x-troff-ms',
							'mvb'     => 'application/x-msmediaview',
							'nws'     => 'message/rfc822',
							'oda'     => 'application/oda',
							'p10'     => 'application/pkcs10',
							'p12'     => 'application/x-pkcs12',
							'p7b'     => 'application/x-pkcs7-certificates',
							'p7c'     => 'application/x-pkcs7-mime',
							'p7m'     => 'application/x-pkcs7-mime',
							'p7r'     => 'application/x-pkcs7-certreqresp',
							'p7s'     => 'application/x-pkcs7-signature',
							'pbm'     => 'image/x-portable-bitmap',
							'pdf'     => 'application/pdf',
							'pfx'     => 'application/x-pkcs12',
							'pgm'     => 'image/x-portable-graymap',
							'pko'     => 'application/ynd.ms-pkipko',
							'pma'     => 'application/x-perfmon',
							'pmc'     => 'application/x-perfmon',
							'pml'     => 'application/x-perfmon',
							'pmr'     => 'application/x-perfmon',
							'pmw'     => 'application/x-perfmon',
							'pnm'     => 'image/x-portable-anymap',
							'pot'     => 'application/vnd.ms-powerpoint',
							'ppm'     => 'image/x-portable-pixmap',
							'pps'     => 'application/vnd.ms-powerpoint',
							'ppt'     => 'application/vnd.ms-powerpoint',
							'prf'     => 'application/pics-rules',
							'ps'      => 'application/postscript',
							'pub'     => 'application/x-mspublisher',
							'qt'      => 'video/quicktime',
							'ra'      => 'audio/x-pn-realaudio',
							'ram'     => 'audio/x-pn-realaudio',
							'ras'     => 'image/x-cmu-raster',
							'rgb'     => 'image/x-rgb',
							'rmi'     => 'audio/mid',
							'roff'    => 'application/x-troff',
							'rtf'     => 'application/rtf',
							'rtx'     => 'text/richtext',
							'scd'     => 'application/x-msschedule',
							'sct'     => 'text/scriptlet',
							'setpay'  => 'application/set-payment-initiation',
							'setreg'  => 'application/set-registration-initiation',
							'sh'      => 'application/x-sh',
							'shar'    => 'application/x-shar',
							'sit'     => 'application/x-stuffit',
							'snd'     => 'audio/basic',
							'spc'     => 'application/x-pkcs7-certificates',
							'spl'     => 'application/futuresplash',
							'src'     => 'application/x-wais-source',
							'sst'     => 'application/vnd.ms-pkicertstore',
							'stl'     => 'application/vnd.ms-pkistl',
							'stm'     => 'text/html',
							'svg'     => "image/svg+xml",
							'sv4cpio' => 'application/x-sv4cpio',
							'sv4crc'  => 'application/x-sv4crc',
							't'       => 'application/x-troff',
							'tar'     => 'application/x-tar',
							'tcl'     => 'application/x-tcl',
							'tex'     => 'application/x-tex',
							'texi'    => 'application/x-texinfo',
							'texinfo' => 'application/x-texinfo',
							'tgz'     => 'application/x-compressed',
							'tif'     => 'image/tiff',
							'tiff'    => 'image/tiff',
							'tr'      => 'application/x-troff',
							'trm'     => 'application/x-msterminal',
							'tsv'     => 'text/tab-separated-values',
							'txt'     => 'text/plain',
							'uls'     => 'text/iuls',
							'ustar'   => 'application/x-ustar',
							'vcf'     => 'text/x-vcard',
							'vrml'    => 'x-world/x-vrml',
							'wav'     => 'audio/x-wav',
							'wcm'     => 'application/vnd.ms-works',
							'wdb'     => 'application/vnd.ms-works',
							'wks'     => 'application/vnd.ms-works',
							'wmf'     => 'application/x-msmetafile',
							'wps'     => 'application/vnd.ms-works',
							'wri'     => 'application/x-mswrite',
							'wrl'     => 'x-world/x-vrml',
							'wrz'     => 'x-world/x-vrml',
							'xaf'     => 'x-world/x-vrml',
							'xbm'     => 'image/x-xbitmap',
							'xla'     => 'application/vnd.ms-excel',
							'xlc'     => 'application/vnd.ms-excel',
							'xlm'     => 'application/vnd.ms-excel',
							'xls'     => 'application/vnd.ms-excel',
							'xlt'     => 'application/vnd.ms-excel',
							'xlw'     => 'application/vnd.ms-excel',
							'xof'     => 'x-world/x-vrml',
							'xpm'     => 'image/x-xpixmap',
							'xwd'     => 'image/x-xwindowdump',
							'z'       => 'application/x-compress',
							'zip'     => 'application/zip');

		list($dir, $base, $ext, $file) = pathinfo($filename);
		return isset($mime_types[$ext]) ? $mime_types[$ext] : 'application/octet-stream';
	}