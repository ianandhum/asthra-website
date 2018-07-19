<?php
  require_once("../../config/User.class.php");
  require_once("../../config/RegData.class.php");
  $user=new User();
  $data=new RegData();
  $action="";
  if (isset($_POST['action'])&& !empty($_POST['action'])) {
    $action=$_POST['action'];
  }
  $key="";
  if (isset($_POST['key'])&& !empty($_POST['key'])) {
    $key=$_POST['key'];
  }
  $filter="";
  if (isset($_POST['filter'])&& !empty($_POST['filter'])) {
    $filter=$_POST['filter'];
  }
  else{
    exit;
  }
  $result=array();
  header("Content-Type:text/json");
  if ($user->isLoggedIn() && $user->isStdUser()) {
    switch ($action) {
      case 'SEARCH':
          switch ($filter) {
            case 'FILNAME':
                  $res=$data->searchFormatedTableData(array("firstName"=>"%".$key."%"));
                  array_merge($res,$data->searchFormatedTableData(array("lastName"=>"%".$key."%")));
                  if($res!=null){
                    $result["status"]=true;
                    $result["result"]=$res;
                  }
                  else{
                    $result['status']=false;
                  }
              break;
            case 'FILMAIL':
                    $res=$data->searchFormatedTableData(array("userEmail"=>"%".$key."%"));
                    if($res!=null){
                      $result["status"]=true;
                      $result["result"]=$res;
                    }
                    else{
                      $result['status']=false;
                    }
                break;
              case 'FILPHNO':
                      $res=$data->searchFormatedTableData(array("phoneNumber"=>"%".$key."%"));
                      if($res!=null){
                        $result["status"]=true;
                        $result["result"]=$res;
                      }
                      else{
                        $result['status']=false;
                      }
                break;
            default:

              break;
          }
        break;
        case 'LISTS':
          if (is_array($filter)) {
            switch ($filter['primary']) {
              case 'BYCOL':
                    $res=$data->getPersonalInfo(true,array('collegeId'=>$filter['secondary']));
                    //create table for the command

                    //var_dump($res);
                    $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                    if (is_array($res)) {
                      foreach ($res as $key => $value) {

                        try {
                          $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                        } catch (\Exception $e) {

                        }

                      }
                    }
                    $resultTable.="</tbody></table>";
                    //var_dump($resultTable);
                    $result['status']=true;
                    $result['data']=$resultTable;
                break;
                case 'BYEVENT':
                      $res=$data->getPersonalInfoN(true,array($filter['secondary']=>'( \'SET\' , \'DONE\')'));
                //create table for the command

                  //var_dump($res);
                      $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                      if (is_array($res)) {
                        foreach ($res as $key => $value) {
                          $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                        }
                      }
                      $resultTable.="</tbody></table>";
                      //var_dump($resultTable);
                      $result['status']=true;
                      $result['data']=$resultTable;
                  break;
                  case 'BYDONE':
                      $res=$data->getPersonalInfo(true,array($filter['secondary']=>'DONE'));
                //create table for the command

                  //var_dump($res);
                      $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                      if (is_array($res)) {
                        foreach ($res as $key => $value) {
                          $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                        }
                      }
                      $resultTable.="</tbody></table>";
                      //var_dump($resultTable);
                      $result['status']=true;
                      $result['data']=$resultTable;
                  break;
                  
                  case 'BYkALL':
                      $res=$data->getPersonalInfo(true,array(""=>""));
                //create table for the command

                  //var_dump($res);
                      $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                      if (is_array($res)) {
                        foreach ($res as $key => $value) {
                          $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                        }
                      }
                      $resultTable.="</tbody></table>";
                      //var_dump($resultTable);
                      $result['status']=true;
                      $result['data']=$resultTable;
                  break;
                  case 'BYALL':
                      $res=$data->getTableData(DATA_DB_TABLE);
                //create table for the command

                  //var_dump($res);
                      $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th><th>Events</th></tr></thead><tbody>";
                      if (is_array($res)) {
                        foreach ($res as $key => $value) {
                        	
                            $collegeId=$res[$key]['collegeId'];
                            $collegeDetails=$data->getTableData(DATA_DB_COLLEGE_TABLE,array('collegeName'),array("collegeId"=>$collegeId),"100");
                            $res[$key]=array_merge($res[$key],$collegeDetails[0]);
                            $data->selectUserById($res[$key]['userId']);
                            $evId=$data->getRegEvents();
                            $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td><td>";
                           foreach($evId as $i => $ev){ 
                           	$evDetails=$data->getTableData(DATA_DB_EVENT_TABLE,"*",array("eventId"=>$ev),"100");
                           	//var_dump($evDetails);
                           	$resultTable.=" ";
                           	$resultTable.=$evDetails[0]['eventName'];
                  		$resultTable.=($i)?",":"";
                            	
                            }
                            $resultTable.="</td></tr>";
                            
                           
                          
                        }
                      }
                      $resultTable.="</tbody></table>";
                      //var_dump($resultTable);
                      $result['status']=true;
                      $result['data']=$resultTable;
                  break;
                  
                  case 'BYACCO':
                        $resIm=$data->searchTableData(DATA_DB_TABLE,array('userId','firstName','lastName','collegeId','phoneNumber'),array("extra"=>"%_acco_:true%"));
                        $res=array();
                        if($resIm){
                          foreach ($resIm as $key => $value) {
                            $collegeId=$resIm[$key]['collegeId'];
                            $collegeDetails=$data->getTableData(DATA_DB_COLLEGE_TABLE,array('collegeName'),array("collegeId"=>$collegeId),"100");
                            $res[$key]=array_merge($resIm[$key],$collegeDetails[0]);
                          }
                        }
                  //create table for the command

                    //var_dump($res);
                        $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                        if (is_array($res)) {
                          foreach ($res as $key => $value) {
                            $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                          }
                        }
                        $resultTable.="</tbody></table>";
                        //var_dump($resultTable);
                        $result['status']=true;
                        $result['data']=$resultTable;
                    break;
                    case 'BYFOOD':
                          $resIm=$data->searchTableData(DATA_DB_TABLE,array('userId','firstName','lastName','collegeId','phoneNumber'),array("extra"=>"%_food_:true%"));
                          $res=array();
                          if($resIm){
                            foreach ($resIm as $key => $value) {
                              $collegeId=$resIm[$key]['collegeId'];
                              $collegeDetails=$data->getTableData(DATA_DB_COLLEGE_TABLE,array('collegeName'),array("collegeId"=>$collegeId),"100");
                              $res[$key]=array_merge($resIm[$key],$collegeDetails[0]);
                            }
                          }
                    //create table for the command

                      //var_dump($res);
                          $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                          if (is_array($res)) {
                            foreach ($res as $key => $value) {
                              $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                            }
                          }
                          $resultTable.="</tbody></table>";
                          //var_dump($resultTable);
                          $result['status']=true;
                          $result['data']=$resultTable;
                      break;
                      case 'BYGENDER':
                            $resIm=$data->searchTableData(DATA_DB_TABLE,array('userId','firstName','lastName','collegeId','phoneNumber'),array("extra"=>"%_gender_:_".$filter['secondary']."_%"));
                            $res=array();
                            if($resIm){
                              foreach ($resIm as $key => $value) {
                                $collegeId=$resIm[$key]['collegeId'];
                                $collegeDetails=$data->getTableData(DATA_DB_COLLEGE_TABLE,array('collegeName'),array("collegeId"=>$collegeId),"100");
                                $res[$key]=array_merge($resIm[$key],$collegeDetails[0]);
                              }
                            }
                      //create table for the command

                        //var_dump($res);
                            $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                            if (is_array($res)) {
                              foreach ($res as $key => $value) {
                                $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                              }
                            }
                            $resultTable.="</tbody></table>";
                            //var_dump($resultTable);
                            $result['status']=true;
                            $result['data']=$resultTable;
                        break;
                  case 'BYEVENTPROMOTED':
                        $res=$data->getPersonalInfo(true,array($filter['secondary']=>'PROMOTED'));
                    //create table for the command

                      //var_dump($res);
                        $resultTable="<table id='tab-lists-table-tab' class='table table-striped table-bordered'><thead><tr><th>#</th><th>Name</th><th>College</th><th>Phone Number</th></tr></thead><tbody>";
                        if (is_array($res)) {
                          foreach ($res as $key => $value) {
                            $resultTable.="<tr><td>". ($key+1) ."</td><td>".$res[$key]['firstName']." ".$res[$key]['lastName']."</td><td>".$res[$key]['collegeName']."</td><td>".$res[$key]['phoneNumber']."</td></tr>";
                          }
                        }
                        $resultTable.="</tbody></table>";
                        //var_dump($resultTable);
                        $result['status']=true;
                        $result['data']=$resultTable;
                    break;
                  case 'BYRESULTS':
                        $res=$data->getTableData(DATA_DB_RESULT_TABLE,"*",array('eventId'=>$filter['secondary']));
                        //var_dump($res);

                        $comp=array();
                        $resultTable="<div id=\"tab-lists-table-tab\">";
                        if (is_array($res)) {
                          $res=$res[0];
                          if ($res['winner']) {

                              $resultTable.="<div style=\"color:#000;font-size:20px;border-bottom:2px solid #000\">Winner</div>";
                              $comp['winner']=$data->getCompanionsForEventFromGroupId($filter['secondary'],$res['winner']);
                              $resultTable.="<ul class=\"list-group\" style=\"margin:10px 0;\">";
                              for ($i=0; $i < count($comp['winner']); $i++) {
                                $resultTable.="<li class=\"list-group-item\"><b> NAME : ".$comp['winner'][$i]['firstName']." ".$comp['winner'][$i]['firstName']."</b> ,  ".$comp['winner'][$i]['collegeName']." , ".$comp['winner'][$i]['phoneNumber']." </li>";
                              }
                              $resultTable.="</ul>\n";
                          }
                          if ($res['runnerUp']) {
                              $resultTable.="<div style=\"color:#000;font-size:20px;border-bottom:2px solid #000\">Second Place</div>";
                              $comp['runnerUp']=$data->getCompanionsForEventFromGroupId($filter['secondary'],$res['runnerUp']);
                              $resultTable.="<ul class=\"list-group\" style=\"margin:10px 0;\">";
                              for ($i=0; $i < count($comp['runnerUp']); $i++) {
                                $resultTable.="<li class=\"list-group-item\"><b>NAME : ".$comp['runnerUp'][$i]['firstName']." ".$comp['runnerUp'][$i]['firstName']."</b> , ".$comp['runnerUp'][$i]['collegeName']." , ".$comp['runnerUp'][$i]['phoneNumber']."</li>";
                              }
                              $resultTable.="</ul>";

                          }
                          if ($res['runnerUp2']) {
                              $comp['runnerUp2']=$data->getCompanionsForEventFromGroupId($filter['secondary'],$res['runnerUp2']);
                          }
                        }

                        $resultTable.="</div>";

                        $result['status']=true;
                        $result['data']=$resultTable;
                  break;
                  case 'BYTEAMS':
                        $res=$data->getTableDataI(DATA_DB_TABLE,"*",array(),"200","groupId".$filter['secondary']);
                        //var_dump($res)
                        $started=false;
                        $resultTable="<div id=\"tab-lists-table-tab\">";
                        if (is_array($res)) {
                          $prevGId="";
                          foreach ($res as $key => $value) {

                            if ($value['groupId'.$filter['secondary']]!="") {
                              if($value['groupId'.$filter['secondary']] !=$prevGId){
                                if ($started===true) {
                                  $resultTable.="</ul>";
                                }
				$clgRow=$data->getUserData($value['collegeId'],DATA_DB_COLLEGE_TABLE);
                                $resultTable.="<div style=\"color:#000;font-size:20px;border-bottom:2px solid #000\">".$clgRow['collegeName']."</div><ul class=\"list-group\" style=\"margin:10px 0;\">";
                              }
				
                                $resultTable.="<li class=\"list-group-item\">{$value['firstName']} {$value['lastName']} , {$value['userEmail']} ,{$value['phoneNumber']} </li>";
                                $prevGId=$value['groupId'.$filter['secondary']];
                                $started=true;
                            }

                          }
                        }
                        //var_dump($res);



                        $resultTable.="</div>";

                        $result['status']=true;
                        $result['data']=$resultTable;
                  break;



              default:
                # code...
                break;
            }
          }
          else {
                $result["status"]=false;
                $result["result"]="Error";
          }
          break;
      default:
          $result["status"]=false;
          $result["result"]="Error";
        break;
    }
    echo json_encode($result);
  }
  else{
    echo "{\"status\":false,\"result\":\"AUTHENTICATION FAILED\"}";
  }

 ?>
