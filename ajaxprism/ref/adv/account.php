<?php

require_once("../../config/User.class.php");
require_once("../../config/Register.class.php");
$user=new User(true);
$reg=new Register();
$result=array();
$pass=uniqid();
$stat=true;
$action="";
if (isset($_POST['action'])&& !empty($_POST['action'])) {
  $action=$_POST['action'];
}
$email="";
if (isset($_POST['user_EMAIL'])&& !empty($_POST['user_EMAIL'])) {
  $email=$_POST['user_EMAIL'];
}
else{

    $stat=false;
    $result['status']=false;
    $result['data']="InvalidArgumentException";
}

if ($user->isLoggedIn() && $user->isAccountsAdmin()) {
  if ($stat) {
    switch ($action) {

      case 'NEW_APP':
      $name="";
      if (isset($_POST['user_NAME'])&& !empty($_POST['user_NAME'])) {
        $name=$_POST['user_NAME'];
      }
      else {

          $stat=false;
          $result['status']=false;
          $result['data']="InvalidArgumentException";
      }
      $event="";
      if (isset($_POST['eventId'])&& !empty($_POST['eventId'])) {
        $event=$_POST['eventId'];
      }
      else {

          $stat=false;
          $result['status']=false;
          $result['data']="InvalidArgumentException";
      }
      if ($stat) {

          if ($reg->processStart($email,$name,$pass,$pass,DATA_USER,"DEV_ANDROID_APP") ) {
            if ($user->login($email,"",true)) {
              $logJson=json_decode($user->getresponseData(),true);
              $result['status']=true;
              $dt['user_EMAIL']=$email;
              $dt['user_NAME']=$reg->getUserId();
              $dt['user_ID']=$logJson['user_id'];
              $dt['eventId']=$event;
              $result['data']=json_encode($dt);
            }

          }
          else{

            $result['status']=false;
            $result['data']=$reg->lastError;
          }
      }
        break;
      case 'GET_TOKEN':
      $event="";
      if (isset($_POST['eventId'])&& !empty($_POST['eventId'])) {
        $event=$_POST['eventId'];
      }
      else {

          $stat=false;
          $result['status']=false;
          $result['data']="InvalidArgumentException";
      }
      if ($stat) {
        if ($reg->getUserData($reg->getUidFromEmail($email),USER_DB_TABLE) ) {
          if ($user->login($email,"",true)) {
            $logJson=json_decode($user->getresponseData(),true);
            $result['status']=true;
            $dt['user_EMAIL']=$email;
            $dt['user_NAME']=$reg->getUidFromEmail($email);
            $dt['user_ID']=$logJson['user_id'];
            $dt['eventId']=$event;
            $result['data']=json_encode($dt);
          }
        }
        else{

                      $result['status']=false;
                      $result['data']="USER NOT FOUND";
        }
      }
        break;

      default:
        $result['status']=false;
        $result['data']="InvalidActiontException";
        break;
    }
  }
}
else {

    $result['status']=false;
    $result['data']="PERMISSION DENIED";
}
ob_end_clean();
header("Content-Type:text/json");
echo json_encode($result);
?>
