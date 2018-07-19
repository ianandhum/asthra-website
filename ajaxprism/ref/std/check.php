<?php
require_once("../../config/User.class.php");
require_once("../../config/RegData.class.php");
$action="";
if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action=htmlspecialchars($_POST['action']);
}
$id="";
if(isset($_POST['id']) && !empty($_POST['id'])) {
	$id=htmlspecialchars($_POST['id']);
}
$response="";
if(isset($_POST['response'])  && !empty($_POST['response'])) {
	$response=htmlspecialchars($_POST['response']);
}
$result="";
$user=new User();
if($user->isLoggedIn()) {
	$dataClass=new RegData();
	$dataClass->selectUserById($user->getUserId());
	switch($action) {
		case "add_event":	if($dataClass->addUserForEvent($id)) {
				$result="{ \"status\":\"1\" , \"msg\": \"EVENT ADDED\" ,\"ID\" : \"$id\",\"user\":\"".$user->getUserId()."\"}";
			}
			else{
				$result="{ \"status\":\"0\" , \"msg\": \" $dataClass->lastError \" }";
			}
			break;
		case "rm_event":if($dataClass->removeUserFromEvent($id)) {
				$result="{ \"status\":\"1\" , \"msg\": \"EVENT REMOVED\" ,\"ID\" : \"$id\",\"user\":\"".$user->getUserId()."\"}";
			}
			else{
				$result="{ \"status\":\"0\" , \"msg\": \" $dataClass->lastError \" }";
			}
			break;
		default:$result="{ \"status\":\"0\" , \"msg\": \" INVALID PARAM \" }";
	}
}
else{
	$result="{ \"status\":\"0\" , \"msg\": \"PERMISSION DENIED\" }";
}
header("Content-Type:text/json");
echo $result;
?>
