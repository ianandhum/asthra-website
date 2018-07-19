<?php
require_once("../../config/Register.class.php");
require_once("../../config/RegData.class.php");
exit;
$uFirstName="";
if(isset($_POST['uFirstName']) && !empty($_POST['uFirstName'])) {
	$uFirstName=htmlspecialchars($_POST['uFirstName']);
}
$uLastName="";
if(isset($_POST['uLastName']) && !empty($_POST['uLastName'])) {
	$uLastName=htmlspecialchars($_POST['uLastName']);
}
$uEmail="";
if(isset($_POST['uEmail'])  && !empty($_POST['uEmail'])) {
	$uEmail=htmlspecialchars($_POST['uEmail']);
}
$uAcco=0;
if(isset($_POST['acco'])  && !empty($_POST['acco'])) {
	$uAcco=($_POST['acco']=="1")?1:0;
}
//removed due to unnecessary user data
/*
$uPass="";
if(isset($_POST['uPass'])  && !empty($_POST['uPass'])) {
	$uPass=htmlspecialchars($_POST['uPass']);
}
$uRePass="";
if(isset($_POST['uRePass'])  && !empty($_POST['uRePass'])) {
	$uRePass=htmlspecialchars($_POST['uRePass']);
}
*/
//but $uPass & $uRepass must be passed to the function, generate it with uniqid
$uniqid=uniqid("pass");
$uPass=$uniqid;
$uRePass=$uniqid;
if(!isset($_POST['name_id']) || $_POST['name_id']!='new_user_entry_1234' ){
	$msgMain="<span style=\"font-size:26px;padding:0px 20px\">403</span>&nbsp;&nbsp;&nbsp;This request cannot be processed";
	$status="error";
	include '../gen/end_tail.php';
	exit;
}
$phoneNumber="";
if(isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber'])) {
	$phoneNumber=htmlspecialchars($_POST['phoneNumber']);
}
$collegeId="";
if(isset($_POST['collegeId']) && !empty($_POST['collegeId'])) {
	$collegeId=htmlspecialchars($_POST['collegeId']);
}

//custom college handler
//TODO:done
$collegeName=null;
if(isset($_POST['collegeName']) && $collegeId=="customId") {
	$collegeName=htmlspecialchars($_POST['collegeName']);
	$collegeId=uniqid();
	$data=new RegData();
	$college=$data->getTableData(DATA_DB_COLLEGE_TABLE,"*",array("collegeName"=>$collegeName));
	if($college[0]['collegeName']==$collegeName) {
		$collegeId=$college[0]['collegeId'];
	}
	else{

		if($data->addTableData(DATA_DB_COLLEGE_TABLE,array("collegeId" => "$collegeId","collegeName"=>"$collegeName"))){

		}
		else{
			$msgMain="Unknown error occured";
			$msgSub="Contact System admin";
			$status="error";
			include("../gen/end_tail.php");exit;
		}
	}
}
$r=new Register();

if($r->processStart($uEmail,$uFirstName." ".$uLastName,$uPass,$uRePass,NAIVE_USER,'DEV_WEB_STD',$uFirstName,$uLastName,$phoneNumber,$collegeId)){

	$r->setExtra('acco',"$uAcco");
	$msgMain="Verification Link is sent to <b style='color:#eee;font-variant:normal'>&lt;$uEmail&gt;</b>";
	$msgSub="<small>you will recieve the mail in a minute or two . kindly wait and check your inbox</small>";
	$status="success";
	include("../gen/end_tail.php");
	exit;
}
else{
		$status="error";
		$msgMain="$r->lastError <br/><a href=\"".SERVER_HOST."\">Go Back</a> ";
		include("../gen/end_tail.php");

		exit;
}

?>
