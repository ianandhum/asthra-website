<?php
require_once("User.class.php");

require("mailer/PHPMailer.php");

require("mailer/SMTP.php");

require("mailer/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

//class register::TEST_LEVEL:primary::MAX:THROUGH
//TEST_LEVEL:intermediate
//data-model is not well formed
//getters and setters are to be set up
//bug-fixes
class Register{
	private $userTypes=array(NAIVE_USER,DATA_USER,STD_USER,ADVANCED_USER);
	//userStatuses array
	//ACTIVE not included
	private $newUserStatuses=array("DEFAULT","MAIL_SENT","VERIFIED");
	private $newUserType=NAIVE_USER;
	public  $lastError=null;
	private $currUser;
	private $dbConn;
	public  $userId;
	private $sandboxUserTable=USER_DB_SANDBOX_TABLE;
	private $userTable=USER_DB_TABLE;
	private $userTableFields=array("userId","userFullName","userEmail","sessionKey","userPass","accessLevel","userType","loggedIn","deviceType","state","editCode");
	private $sandboxUserTableFields=array("userId","userFullName","userEmail","userFirstName","userLastName","collegeId","phoneNumber","userPass","activationCode","status","extra");
	private $lastActionUser;
	public function __construct() {
		$this->currUser=new User();
		$this->dbConn=$this->currUser->dbConn;
	}
	//DEPRECIATED::will be removed
	public function setType($uType) {
			if(!in_array($uType,$this->userTypes)) {
				$uType=NAIVE_USER;
			}
			$user=$this->currUser;
			if($user->isLoggedIn() || $uType==NAIVE_USER){
				if($user->getAccessLevel()==ADVANCED_USER){
						$this->newUserType=$uType;
						return true;

				}
				else{
						$e=new ErrorMsg("EPERMISSION");
						$this->lastError=$e->toString();
				}
			}
			return false;
	}
	//ALL PARAMS ARE MUST
	public function addNewEntry($ufullname,$pass,$email,$stat,$ufirstname,$ulastname,$phoneNumber,$collegeId) {
			$id=uniqid("userID");
			$authCode=md5(uniqid(rand()));
			$pass=md5($pass);
			if(!in_array($stat,$this->newUserStatuses)) {
				$stat="DEFAULT";
			}
			if($this->isRedundantData('userEmail',$email)) {
					$e=new ErrorMsg("ERUEMAIL");
					$this->lastError=$e->toString(" Please try with another e-mail Id");
					return false;
			}
			$query="INSERT INTO $this->sandboxUserTable (userId , userFullName , userPass,  userEmail  , activationCode , status, userFirstName ,userLastName,phoneNumber,collegeId) VALUES ( :id , :ufullname , :upass , :umail , :acode, :status, :uFname, :uLname,:phone,:collegeId )";
			$stmt=$this->dbConn->prepare($query);
			$stmt->bindparam(":id",$id);
			$stmt->bindparam(":ufullname",$ufullname);
			$stmt->bindparam(":upass",$pass);
			$stmt->bindparam(":umail",$email);
			$stmt->bindparam(":acode",$authCode);
			$stmt->bindparam(":status",$stat);
			$stmt->bindparam(":uFname",$ufirstname);
			$stmt->bindparam(":uLname",$ulastname);
			$stmt->bindparam(":phone",$phoneNumber);
			$stmt->bindparam(":collegeId",$collegeId);
			try{
				$stmt->execute();
			}
			catch(\Exception $e){

			}
			$this->userId=$id;
			return true;

	}
	public function getUserId() {
		return $this->userId;
	}
	//WRITES data to user-table directly
	public function addNewDirectEntry($ufullname,$pass,$email,$access,$device,$passHash=true,$isDirect=true,$uId=null) {
			if($isDirect) {
				$id=uniqid("userID");
			}
			else{
				$id=$uId;
			}
			if($passHash) {
				$pass=md5($pass);
			}
			$usertype="std";
			if($this->isRedundantData('userEmail',$email,false)) {
					$e=new ErrorMsg("ERUEMAIL");
					$this->lastError=$e->toString(" Please try with another e-mail Id");
					return false;
			}
			$query="INSERT INTO $this->userTable ( userId , userEmail  , userPass , userFullName  ,accessLevel , userType , deviceType) VALUES ( :uid , :umail , :upass , :ufullname , :access , :usertype , :device)";
			$stmt=$this->dbConn->prepare($query);
			$stmt->bindparam(":uid",$id);
			$stmt->bindparam(":ufullname",$ufullname);
			$stmt->bindparam(":upass",$pass);
			$stmt->bindparam(":umail",$email);
			$stmt->bindparam(":access",$access);
			$stmt->bindparam(":device",$device);
			$stmt->bindparam(":usertype",$usertype);
			try{
				$stmt->execute();
			}
			catch(\Exception $e){

			}
			$this->userId=$id;
			return true;

	}
	//checks whether the given record is in the table
	public function isRedundantData($col,$val,$tab=true) {
			$table=($tab)?$this->sandboxUserTable:$this->userTable;
			if(!$this->isValidCol($col,$table)) {
				throw new \Exception("Invalid column name");
			}
			$stmt=$this->dbConn->prepare("SELECT $col FROM $table  WHERE $col = :value");
			try{
				$stmt->execute(array(":value" => $val));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt->rowCount() > 0) {
				return true;

			}
			return false;

	}
	//for error free database connection
	private function isValidCol($col,$tab=USER_DB_TABLE) {
		$res=false;
		if($tab==$this->userTable) {
			$res=in_array($col,$this->userTableFields);
		}
		else{
			$res=in_array($col,$this->sandboxUserTableFields);

		}
		return $res;
	}
	//gets the user row from user id
	public function getUserData($user=null ,$tab=USER_DB_SANDBOX_TABLE) {
			if($user==null) {
				$user=$this->userId;
			}
			$stmt=$this->dbConn->prepare("SELECT * FROM $tab WHERE userId = :uid LIMIT 1");
			try{
				$stmt->execute(array(":uid" => $user));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt->rowCount() > 0) {
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				return $userRow;
			}
			return null;
	}
	//cross checks the email address of a user and returns user-id on success
	public function getUidFromEmail($mail){
			$stmt=$this->dbConn->prepare("SELECT userId FROM $this->userTable WHERE userEmail=:email LIMIT 1");
			try{
				$stmt->execute(array(":email" => $mail));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt->rowCount() > 0) {
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				return $userRow['userId'];
			}
			return false;

	}
	//remove the record from the user table(s)
	public function undoUser($user=null,$tab=USER_DB_SANDBOX_TABLE) {
			if($user==null) {
				$user=$this->userId;
			}
			$stmt=$this->dbConn->prepare("DELETE  FROM $tab WHERE userId=:uid");
			try{
				$res=$stmt->execute(array(":uid" => $user));
			}
			catch(\Exception $e){
				return false;
			}
			if($res) {
				return true;
			}
			return false;
	}
	//sets the value of a given column in a table
	public function setUserData($col,$val,$user=null,$tab=USER_DB_SANDBOX_TABLE) {
			if($user==null) {
				$user=$this->userId;
			}
			if(!$this->isValidCol($col,$tab)) {
				throw new \Exception("Invalid column name");
			}
			$stmt=$this->dbConn->prepare("UPDATE $tab SET $col = :val WHERE userId =:uid");
			try{
				$stmt->execute(array(":uid" => $user,":val"=>$val));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt) {
				return true;
			}
			return false;
	}
	//data encryption function with key
	function encrypt($pure_string, $encryption_key) {
  	  $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
  	  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  	  $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
  	  return base64_encode($encrypted_string);
	}

	//data decryption function with key
	function decrypt($encrypted_string, $encryption_key) {
	  $encrypted_string=base64_decode($encrypted_string);
  	  $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
  	  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  	  $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
  	  return $decrypted_string;
	}
	//send mail to the selected email
	public function sendMail($email,$message,$subject)
	{
		$res=false;
		if(!$this->parseEmail($email)) {
			return false;
		}
		$mail = new PHPMailer(true);
		try{
			$mail->IsSMTP();
			$mail->SMTPDebug  = 0;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host       = "sg2plcpnl0182.prod.sin2.secureserver.net";
			$mail->Port       = 465;
			$mail->AddAddress($email);
			$mail->Username=HOST_MAILER_MAIL_ID;
			$mail->Password=$this->decrypt(HOST_MAILER_MAIL_PASSWORD,SALT_PASSKEY);
			$mail->SetFrom(HOST_MAILER_MAIL_ID,HOST_APP_NAME);
			$mail->AddReplyTo(HOST_MAILER_MAIL_ID,HOST_APP_NAME);
			$mail->Subject= $subject;
			$mail->Body=$message;
			$mail->IsHTML(true);
			$mail->Send();
			return true;
		}
		catch(Exception $ex){
				$er=new ErrorMsg('EMAILER');
				$this->lastError=$er->toString($ex->getMessage());
		}
	}
	public function isNaiveUser() {
		if(!$this->currUser->isLoggedIn() || $this->currUser->getAccessLevel()==NAIVE_USER) {
				return true;
		}
		return false;
	}
	//true if there exist a user in the given name
	public function isUserExist($userId) {
			return $this->isRedundantData("userId",$userId,false);
	}
	//function for resetting the password of a user
	public function resetUser($email,$isDirect=false,$pass=null,$repass=null){
		$userId=$this->getUidFromEmail($email);
		if($userId!=false && $this->parseEmail($email)){
			$userRow=$this->getUserData($userId,$this->userTable);
			$uType=$userRow['accessLevel'];
			if($isDirect){
				if($this->adminLogged()) {
					if($this->parsePassword($pass,$repass)){
						$pass=md5($pass);
						$this->setUserData("userPass",$pass,$userId,$this->userTable);
						$this->lastActionUser=ADVANCED_USER;
						return true;
					}
					else {
						$e=new ErrorMsg("EBPASS");
						$this->lastError=$e->toString();
					}
				}
				else{
						$e=new ErrorMsg("EPERMISSION");
						$this->lastError=$e->toString();
				}

			}
			elseif($uType == NAIVE_USER && !$this->adminLogged()) {
								$editCode=md5(uniqid());
								$this->setUserData("editCode",$editCode,$userId,$this->userTable);
								$msgBody="<div style='text-align:center;line-height:30px;width:80%;margin:10%;background:#eee;'><h3 style='float:left;font-size:22px;'>Hello ".$userRow['userFullName']."</h3>
								<h3>Reset your password for Asthra 2k18!</h3>
								You have requested for password change, click the following link to reset your password<br/>
								<br />
								<a href='".SERVER_HOST."pass_reset.php?id=".$userId ."&code=".$editCode."' style='background:#07a;font-size:16px;color:#fff;text-decoration:none;padding:3px 10px;border-radius:3px;width:25%;'>Reset Password </a>
								<div>";
								if($this->sendMail($email,$msgBody,EMAIL_HEADER_RESET_PASSWD)){
									$this->setUserData('state','RESET_REQUESTED',$userId,$this->userTable);
									$this->lastActionUser=NAIVE_USER;
									return true;
								}
			}
			else{
				$e=new ErrorMsg("EPERMISSION");
				$this->lastError=$e->toString();
			}
		}
		else{
			$e=new ErrorMsg("EEMAIL");
			$this->lastError=$e->toString();
		}
		return false;
	}
	//function for step 1 entry of a new user
	public function processStart($email,$ufullname,$pass,$repass,$uType=NAIVE_USER,$device='DEV_WEB_STD',$ufirstname=null,$ulastname=null,$phoneNumber=null,$collegeId=null){
			if(!$this->parseUserAccessLevel($uType)){
					$e=new ErrorMsg("EUTYPE");
					$this->lastError=$e->toString();
					return false;
			}
			if($this->isRedundantData("userEmail",$email,false)){
					$e=new ErrorMsg("ERUEMAIL");
					$this->lastError=$e->toString();
					return false;
			}
			if($this->isNaiveUser()){
						if($uType!=NAIVE_USER) {
							$e=new ErrorMsg("EPERMISSION");
							$this->lastError=$e->toString("you are not authenticated");
							return false;
						}
						if($this->newNaiveUser($email,$pass,$repass,$ufullname,$ufirstname,$ulastname,$phoneNumber,$collegeId)){
							$userRow=$this->getUserData();
							if($userRow!=null) {
								$msgBody="
								<head>
								<style>
								*{
									box-sizing:border-box;
								}
								</style>
								</head>
								<body><div style='text-align:center;font-size:15px;line-height:30px;width:80%;margin:10%;background:#eee;box-sizing:border-box;'>
								<h3 style='background:#123456;color:#fff;padding:10px;font-size:22px;color:#fff;'>Welcome to Asthra 2k18!</h3>
								<div style='width:100%;padding:20px 0px;box-sizing:border-box;'>
								<h3 style='font-size:20px;color:#000;'>Hello ".$userRow['userFullName']." </h3>

								<div style='padding:15px;'>You are seeing this message because your mail address was used in the registration portal for Asthra 2k18 <div style=font-weight:bold;'>To complete your registration, please , just click following link</div></div><br />

								<a href='".SERVER_HOST."ref/std/verify.php?id=".$userRow['userId'] ."&code=".$userRow['activationCode']."' style='background:#07a;font-size:16px;color:#fff;margin:10px;text-decoration:none;padding:6px 10px;border-radius:3px;width:25%;'>Register Now </a>
								</div>
								</div>
								</body>";
								if($this->sendMail($email,$msgBody,EMAIL_HEADER_VERIFY)){
									$this->setUserData("status","MAIL_SENT");
									return true;
								}
								else{
										$this->undoUser($userRow['userId']);
								}
								//$this->undoUser($userRow['userId']);
								return false;
							}
							else {
								$this->lastError="Uncaught Error";
								return false;
							}
						}
						else{
							return false;
						}
			}
			else{
				if($this->adminLogged() && $uType!=ADMIN_USER) {
				if($this->parseEmail($email)) {
						if($this->parsePassword($pass,$repass)){
										if($this->addNewDirectEntry($ufullname,$pass,$email,$uType,$device)){
											if($this->activate($uType,false)) {
												return true;
											}
											else {
												return false;
											}
										}
										else{
											return false;
										}
						}
						else{
							$e=new ErrorMsg("EBPASS");
							$this->lastError=$e->toString();
						}
				}
				else{
							$e=new ErrorMsg("EBEMAIL");
							$this->lastError=$e->toString();
				}
				}
				else {
							$e=new ErrorMsg("EPERMISSION");
							$this->lastError=$e->toString();
				}
			}
			return false;
	}
	//helper function for proccessStart
	public function newNaiveUser($email,$pass,$repass,$ufullname,$ufirstname,$ulastname,$phoneNumber,$collegeId) {
			if($this->parseEmail($email)) {
					if($this->parsePassword($pass,$repass)){
									if($this->addNewEntry($ufullname,$pass,$email,"DEFAULT",$ufirstname,$ulastname,$phoneNumber,$collegeId)){
										return true;
									}
									else{
										return false;
									}
					}
					else{
						$e=new ErrorMsg("EBPASS");
						$this->lastError=$e->toString();
						return false;
					}
			}
			else{
						$e=new ErrorMsg("EBEMAIL");
						$this->lastError=$e->toString();
						return false;
			}
	}
	//checks whether the mail address is in preferred format
	private function parseEmail($email) {
			if(preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email)){
				return true;
			}
			return false;
	}
	//checks wheter username is in preferred format
	private function parseUName($uname) {

			if(preg_match('~^[A-Za-z0-9_ ]{1,20}$~i', $uname)){
				return true;
			}
			return false;

	}
	//checks wheter user access level is in preferred format
	private function parseUserAccessLevel($ulvl) {

			if(in_array($ulvl,$this->userTypes)){
				return true;
			}
			return false;

	}
	//checks whether the pass & repass are same and meets certain conditions 6-20 characters
	private function parsePassword($pass,$repass) {
			$param1=preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $pass);
			if( ($param1)&& ($pass===$repass)) {
				return true;
			}
			return false;
	}
	//step 2 verification of a new user
	public function verify($id=null,$code=null,$isResetPass=false,$pass=null,$repass=null) {
		if($id==null || $code==null) {
			$e=new ErrorMsg("not Enough arguments to the call");
			$this->lastError=$e->toString();
			return false;
		}
		if(!$isResetPass) {
			$userRow=$this->getUserData($id);
			if($userRow && $userRow['status']=='MAIL_SENT') {
				if($userRow['activationCode']==$code) {
						$this->setUserData('status','VERIFIED',$id);
						$this->userId=$id;
						return true;
				}
				else {
					$e=new ErrorMsg("ETOKEN");
					$this->lastError=$e->toString('verification failed');
				}
			}
			else {
					$e=new ErrorMsg("EID");
					$this->lastError=$e->toString('verification failed');
			}
		}
		else{
			$userRow=$this->getUserData($id,$this->userTable);
			if($userRow!=false && $userRow['state']='RESET_REQUESTED') {
				if($userRow['editCode']==$code) {
						$this->setUserData('state',"READY",$id,$this->userTable);
						$this->setUserData('editCode',"",$id,$this->userTable);
						if($this->parsePassword($pass,$repass)) {
							$this->setUserData('userPass',md5($pass),$id,$this->userTable);
							return true;
						}
						else{
							$e=new ErrorMsg("EBPASS");
							$this->lastError=$e->toString('password reset failed');
						}
				}
				else{
					$e=new ErrorMsg("ETOKEN");
					$this->lastError=$e->toString('password reset failed');
				}
			}
			else {
				$e=new ErrorMsg("EID");
				$this->lastError=$e->toString('password reset failed');
			}
		}
		return false;
	}
	//alternative for setType() , checks whether the logged user has administrative privileges
	public function adminLogged() {
			$user=new User();
			if($user->isLoggedIn() && $user->getAccessLevel() == ADVANCED_USER) {
						return true;
			}
			return false;
	}
	//junk
	public function getLastActionUser(){
			if($this->lastActionUser) {
				return $this->lastActionUser;
			}
	}
	//final verification and integrity commands for a new user
	public function activate($uType=NAIVE_USER,$stdEntry=true) {
		if($uType==NAIVE_USER && ($stdEntry==true )) {
		$userRow=$this->getUserData();
		if($userRow && ($userRow['status']=='VERIFIED' )) {
				if($this->addNewDirectEntry($userRow['userFullName'],$userRow['userPass'],$userRow['userEmail'],NAIVE_USER,"DEV_WEB_STD",false,false,$userRow['userId'])) {
						$id=$userRow['userId'];
						$this->userId=$id;
						$this->undoUser($id);
						return true;
				}
				else {
					$e=new ErrorMsg("Unknown error");
					$this->lastError=$e->toString('activation failed');
				}
			}
			else {
					$e=new ErrorMsg("EID");
					$this->lastError=$e->toString('activation failed');
			}
		}
		else {
			if($this->currUser->userExistForId($this->userId)){
				return true;
			}
			else {
				$e=new ErrorMsg("Unknown error");
				$this->lastError=$e->toString('activation failed');
			}
		}
		return false;
	}
	public function setExtra($key,$val)
	{
		$user=$this->getUserData();
		if($user!=null){
			try{
				$extras=$user['extra'];
				$extraJSONArray=json_decode($extras,true);
				$extraJSONArray[$key]=$val;
				$outJSON=json_encode($extraJSONArray);
				return $this->setUserData('extra',$outJSON);
			}
			catch(\Exception $e){
				return false;
			}
		}
	}
	public function getExtra($key)
	{
		$user=$this->getUserData();
		if($user!=null){
			try{
				$extras=$user['extra'];
				$extraJSONArray=json_decode($extras,true);
				return (array_key_exists($extraJSONArray,$key))?$extraJSON[$key]:null;
			}
			catch(\Exception $e){
				return null;
			}
		}
	}
};
?>
