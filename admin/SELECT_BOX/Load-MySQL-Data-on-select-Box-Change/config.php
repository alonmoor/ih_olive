<?Php

	$dbhost = '127.0.0.1';
	$dbname = 'pdf';
	$dbuser = 'alon';
	$dbpass = 'qwerty';
	
	try{
		
		$dbcon = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
		$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	}catch(PDOException $ex){
		
		die($ex->getMessage());
	}
