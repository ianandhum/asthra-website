<?php
require_once("../../config/User.class.php");
require_once("../../config/RegData.class.php");
$user=new User(true);
$regData=new RegData();
$result=array();
$action="";
if (isset($_POST['action'])&& !empty($_POST['action'])) {
  $action=$_POST['action'];
}
$eventId="";
if (isset($_POST['eventId'])&& !empty($_POST['eventId'])) {
  $eventId=$_POST['eventId'];
}

if($user->isLoggedIn() && $user->isDataUser()){
  switch ($action) {
    case 'FETCH':
      $userID="";
      if (isset($_POST['stud_id'])&& !empty($_POST['stud_id'])) {
        $userID=$_POST['stud_id'];
      }
      else {

          $result['status']=false;
          $result['data']="STUDENT ID NOT SUPPLIED";
          break;
      }
      $studRow=$regData->getFormatedTableData(array('userId'=>$userID));

      if($studRow){
        $studRow=$studRow[0];
        $result['status']=true;
        $result['stud_id']=$userID;
        $result['stud_name']=$studRow['name'][0]." ".$studRow['name'][1];
        $result['stud_college']=$regData->getTableData(DATA_DB_COLLEGE_TABLE,array('collegeName'),array("collegeId"=>$studRow['collegeID']))[0]['collegeName'];

        $result['stud_phone']=$studRow['phone'];
        if (!in_array($eventId,$studRow['events'])) {
          $result['event_stat']=false;
        }
        else{
          $result['event_stat']=true;
        }
        //$result['data']=json_encode($res);
      }
      else {
        $result['status']=false;
        $result['data']="DATA NOT FOUND";
        break;
      }
      break;
    case 'SET_EVENT':
      $userID="";
      if (isset($_POST['stud_id'])&& !empty($_POST['stud_id'])) {
        $userID=$_POST['stud_id'];
      }
      else {

          $result['status']=false;
          $result['data']="STUDENT ID NOT SUPPLIED";
          break;
      }
      if($eventId!=""){
        if($regData->getEventStatus($eventId,$userID)=='SET'){
          if($regData->setEventStatus($eventId,"DONE",$userID)){
            $result['data']=0;
            $result['comp']=$regData->getCompanionsForEvent($eventId,$userID);
          }
          else{
            //unexpected error
            $result['data']=1;
          }
        }
        else if($regData->getEventStatus($eventId,$userID)=='DONE'){
          //already set
          $result['data']=2;
        }
        else{
          //not registered for event
            $result['data']=3;
        }
        $result['status']=true;
      }
      else {
        $result['status']=false;
        $result['data']="EVENT ID NOT SUPPLIED";
        break;
      }

      break;
    case 'SET_RESULT':
      $userID="";
      if (isset($_POST['stud_id'])&& !empty($_POST['stud_id'])) {
        $userID=$_POST['stud_id'];
      }
      else {
          $result['status']=false;
          $result['data']="STUDENT ID NOT SUPPLIED";
          break;
      }
      $position="";
      if (isset($_POST['pos'])&& !empty($_POST['pos'])) {
        $position=$_POST['pos'];
      }
      else {
        $position=1;
      }
      $groupId=$regData->getGroupId($userID,$eventId);
      if($groupId){
        if($regData->setResult($eventId,$groupId,$position))
        {
            $result['status']=true;
            $result['data']="SUCCESS";
        }
        else{
          $result["status"]=false;
          $result['data']="UNEXPECTED ERROR";
        }
      }
      else{
        $result["status"]=false;
        $result['data']="PARTICIPANT DOES'T BELONG TO ANY GROUP";
      }
      break;
    default:
      $result['status']=false;
      $result['data']="EXCEPTION :: ILLEGAL ACTION";
      break;
  }
}
else{
  $result['status']=false;
  $result['data']="AUTHENTICATION FAILED";
}
//ob_end_clean();
header("Content-Type:text/json");
echo json_encode($result);
 ?>
