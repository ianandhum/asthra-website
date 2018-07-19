<?php
  require_once("../../config/User.class.php");
  require_once("../../config/RegData.class.php");
  $user=new User();
  $data=new RegData();
  $action="";
  if (isset($_POST['action'])&& !empty($_POST['action'])) {
    $action=$_POST['action'];
  }
  $params="";
  if (isset($_POST['data'])&& !empty($_POST['data'])) {
    $params=json_decode($_POST['data'],true);
  }
  $result=array();
  header("Content-Type:text/json");
  if ($user->isLoggedIn() && $user->isStdUser()) {
    switch ($action) {
      case 'NEW_ENTRY':
          if($data->setFormatedTableData($params)){
            $result["status"]=true;
            $result["data"]=$params;
            $data->selectUserByMail($params['email']);
            $result["data"]["userID"]=$data->getUserId();
          }
          else{

              $result["status"]=false;
              $result["data"]=$data->lastError;
          }
        break;
      case 'CHECK_ENTRY':
            $res=$data->selectUserByMail($params['email']);
            if($res!=null){
              $result['flag']['fresh']=false;
              $result["data"]=$data->getFormatedTableData(array('userId'=>$data->getUserId()))[0];
            }
            else{

                $result['flag']['fresh']=true;
            }
        break;
      case 'UPDATE_ENTRY':
          if($data->updateFormatedTableData($params)){
            $result["status"]=true;
            $result['data']=$data->getFormatedTableData(array("userId"=>$params["userID"]))[0];
          }
          else{
            $result["status"]=false;
            $result["data"]="UNEXPECTED ERROR : ALL ROWS ARE NOT UPDATED : OR USER NOT FOUND";
          }
        break;
      case "NEW_GROUP":
          if($data->setGroupId($params["eventID"],$params['selection'])){
            $result["status"]=true;
            $result["data"]=$data->getCompanionsForEvent($params["eventID"],$params['selection'][0]);
          }
          else {
            $result["status"]=false;
            $result["data"]="GROUP NOT CREATED";
          }
        break;
      default:

        break;
    }
    echo json_encode($result);
  }
  else{
    echo "{\"status\":false,\"data\":\"AUTHENTICATION FAILED\"}";
  }

 ?>
