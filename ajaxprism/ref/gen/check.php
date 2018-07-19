<?php
require_once("../../config/User.class.php");
$action="";
if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action=htmlspecialchars($_POST['action']);
}
$id="";
if(isset($_POST['id']) && !empty($_POST['id'])) {
	$id=htmlspecialchars($_POST['id']);
}
$result="";
$userClass=new User();
switch($action) {
	case "red_mail":
				if($userClass->getUserFromMail($id)!=null) {
					$result="{ \"status\":\"0\" , \"msg\": \"You cannot use this e-mail address as it is already registered\" ,\"ID\" : \"$id\"}";
				}
				else{
					$result="{ \"status\":\"1\" , \"msg\": \" OK \" }";
				}
		break;
	default:
				$result="{ \"status\":\"2\" , \"msg\": \" INVALID PARAM \" }";
	}
header("Content-Type:text/json");
echo $result;
?>
