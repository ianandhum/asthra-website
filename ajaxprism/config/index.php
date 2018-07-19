<?php
session_start();
echo "Note Up";
require_once("config/User.class.php");
$user=new User();
if($user->isLoggedIn() && $user->isNaiveUser()) {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Location:dash_board.php");
			exit;
}
else{

			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Location:register.php");
			exit;
}
?>
