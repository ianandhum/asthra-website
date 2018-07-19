<?php
require_once("../../config/Register.class.php");
require_once("../../config/User.class.php");
require_once("../../config/RegData.class.php");
$reg=new Register();
$user=new User(false);
$garbage=rand();
$id=$garbage;//for security
$code=$garbage;
if(isset($_GET['id']) && !empty($_GET['id'])) {
	$id=$_GET['id'];
}
if(isset($_GET['code']) && !empty($_GET['code'])) {
	$code=$_GET['code'];
}
if($reg->verify($id,$code)) {

	$userData=$reg->getUserData();
	if($reg->activate()){
		$dataClass=new RegData();
		if(!$dataClass->setEntryDetails($userData['userEmail'],$userData['userFirstName'],$userData['userLastName'],$userData['collegeId'],$userData['phoneNumber'],array(),false,$userData['userId'],$userData['extra'])){
			$status="error";
			$msgMain="This is an odd error, report it to the server admin";
			include("../gen/end_tail.php");
			exit;
		}
		else{
			if($user->login($userData["userEmail"],"",true)) {//auto-login a user without password
				header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
				header("Location:".SERVER_HOST."dash_board.php");
				exit;
			}
			else {
				$status="error";
				$msgMain="This is an odd error, report it to the server admin";
				include("../gen/end_tail.php");
				exit;
			}
		}
	}
	else {
		$status="error";
		$msgMain="$reg->lastError";
		include("../gen/end_tail.php");
		exit;
	}
}
else{
	$status="error";
	$msgMain=$reg->lastError;
	include("../gen/end_tail.php");
	exit;
}

?>
