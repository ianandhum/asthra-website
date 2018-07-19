<?php
require_once("../../config/User.class.php");
$user=new User();
if($user->isLoggedIn()) {
	if($user->logout()){
          header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	  header("Cache-Control: post-check=0, pre-check=0", false);
	  header("Pragma: no-cache");
	  header("Location:http://www.mesasthra.com/home/");   
        }
	exit;
}
else{
	$msgMain="Your session Expired";
	$status="error";
	include("../gen/end_tail.php");
	exit;
}
?>
