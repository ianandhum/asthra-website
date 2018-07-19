<?php
	require_once("config/constantConfig.php");
	require_once("config/User.class.php");
	require_once("config/RegData.class.php");
	$user=new User(true);
			if($user->login('anandhu@asthra.com','',true)){
					echo "ok";
				}
				else{
					echo $user->lastError;
				}
			exit;
	
	
