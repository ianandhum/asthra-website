<?php
	require_once("config/constantConfig.php");
	require_once("config/User.class.php");
	require_once("config/RegData.class.php");
	$user=new User(true);
	if(!$user->isLoggedIn()) {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Location:register.php");
			exit;
	}
	else if($user->isNaiveUser()) {
		$data=new RegData();
		$data->selectUserById($user->getUserId());
		$personalInfo=$data->getPersonalInfo();
        $eventBg=array("EVNT01"=>"mock-cid.jpg",
								"EVNT02"=>"secret-event.jpg",
								"EVNT03"=>"word-hunt.jpg",
								"EVNT04"=>"photography.jpg",
								"EVNT05"=>"it-quiz.jpg",
								"EVNT06"=>"network-gaming.jpg",
								"EVNT07"=>"coding.jpg",
								"EVNT08"=>"promo-video.jpg"
						);
		define("NAIVE_DASH",1);
		include("ref/no_access/naive_dash.php");
 }
 else if($user->isStdUser()){
		define("STD_DASH",1);
		include("ref/no_access/std_dash.php");
 }
 else if ($user->isAccountsAdmin()) {
  		define("ADV_DASH",1);
  		include("ref/no_access/adv_dash.php");
 }
 else{
	 echo "Who are you???";
 }
?>
