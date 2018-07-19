<?php
require_once("config.php");
class RegData{
 	public  $userId=null;
 	public  $collegeId=null;
	private $eventStatuses=array("SET","UNSET","DONE");
	public $dataTable=DATA_DB_TABLE;
	public $eventTable=DATA_DB_EVENT_TABLE;
	public $collegeTable=DATA_DB_COLLEGE_TABLE;
	public $resultTable=DATA_DB_RESULT_TABLE;
  private $tables=array(
                          DATA_DB_TABLE => "userId",
                          DATA_DB_EVENT_TABLE => "eventId",
                          DATA_DB_COLLEGE_TABLE => "collegeId",
                          DATA_DB_RESULT_TABLE => "eventId"
                        );
  private $altKeys=array(
                          DATA_DB_TABLE => "userEmail",
                          DATA_DB_EVENT_TABLE => "eventName",
                          DATA_DB_COLLEGE_TABLE => "collegeName",
                          DATA_DB_RESULT_TABLE => "eventId"
                        );
	private $dataTableFields=array(
                                "userId",
                                "firstName",
                                "lastName" ,
                                "userEmail" ,
                                "collegeId",
                                "phoneNumber",
                                "spotVerified",
                                "EVNT01",
                                "groupIdEVNT01",
                                "EVNT02",
                                "groupIdEVNT02",
                                "EVNT03",
                                "groupIdEVNT03",
                                "EVNT04",
                                "groupIdEVNT04",
                                "EVNT05",
                                "groupIdEVNT05",
                                "EVNT06",
                                "groupIdEVNT06",
                                "EVNT07",
                                "groupIdEVNT07",
                                "EVNT08",
                                "groupIdEVNT08",
                                "extra"
                              );
	private $dataTablePersonalInfo=array(
                                        "userId",
                                        "firstName",
                                        "lastName",
                                        "userEmail",
                                        "collegeId",
                                        "phoneNumber",
                                        "spotVerified"
                                      );
	private $eventTableFields=array(
                                  "eventId",
                                  "groupEvent",
                                  "hasStarted",
                                  "hasCompleted",
                                  "eventName",
                                  "eventDesc"
                                );
	private $collegeTableFields=array(
                                      "collegeId",
                                      "collegeName",
                                      "verified",
                                      "address",
                                      "phone",
                                      "Email"
                                    );
	private $resultTableFields=array(
                                    "eventId",
                                    "winner",
                                    "runnerUp",
                                    "runnerUp2"
                                  );
	private $tableCols=null;
	private $userEvents=array("EVNT01","EVNT02","EVNT03","EVNT04","EVNT05","EVNT06","EVNT07","EVNT08");

	public  $lastError=null;
	private $dbConn;
	public function __construct() {
		$this->tableCols=array(DATA_DB_TABLE=>$this->dataTableFields,DATA_DB_EVENT_TABLE=>$this->eventTableFields,DATA_DB_COLLEGE_TABLE=>$this->collegeTableFields,DATA_DB_RESULT_TABLE=>$this->resultTableFields);
		try{
			$db=new DB(DATA_DB_NAME);
			$this->dbConn=$db->dbConnection();
		}
		catch(PDOException $exception)
		{
            $e=new ErrorMsg("ECONN");
            $this->lastError=$e->toString($exception->getMessage());
            return false;
      }
	}
	//ok
	public function selectUserByMail($email) {
			$stmt=$this->dbConn->prepare("SELECT * FROM $this->dataTable WHERE userEmail = :mail LIMIT 1");
			try{
				$stmt->execute(array(":mail" => $email));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt->rowCount() > 0) {
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
					$this->userId=$userRow['userId'];
					$this->collegeId=$userRow['collegeId'];
					return true;
			}
			else{
				$e=new ErrorMsg("EID");
				$this->lastError=$e->toString();
			}
			return false;
	}
	public function selectUserById($userId) {
			$stmt=$this->dbConn->prepare("SELECT * FROM $this->dataTable WHERE userId = :id LIMIT 1");
			try{
				$stmt->execute(array(":id" => $userId));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt->rowCount() > 0) {
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
					$this->userId=$userRow['userId'];
					$this->collegeId=$userRow['collegeId'];
					return true;
			}
			else{
				$e=new ErrorMsg("EEMAIL");
				$this->lastError=$e->toString();
			}
			return false;
	}
	//for a naive user
	//ok
	public function addUserForEvent($evnt,$userId=null){
		if($this->setEventStatus($evnt,'SET')){
			return true;
		}
		return false;
	}
	//ok
	public function removeUserFromEvent($evnt,$userId=null){
		if($this->setEventStatus($evnt,'UNSET',$userId)){
				return true;
		}
		return false;

	}
	//ok
	public function getEventStatus($evnt,$userId=null){
		if($userId==null && $this->userId!=null) {
			$userId=$this->userId;
		}
		$userRow=$this->getUserData($userId);
		if($userRow!=null) {
			if($this->isValidCol($evnt)) {
				return $userRow[$evnt];
			}
		}
		else{
			$e=new ErrorMsg("EEVENT");
			$this->lastError=$e->toString();
		}
		return false;
	}
	//ok
	public function getUserId(){
		if($this->userId!=null) {
			return $this->userId;
		}
		return false;
	}
	//ok
	public function getNofEvents() {
		$userRow=$this->getUserData();
		if($userRow!=null) {
			$nofEvents=0;
			foreach($userRow as $col=>$value){
				if(preg_match("/EVNT[0-9]{2}/",$col) && $value=="SET") {
					$nofEvents++;
				}
			}
			return $nofEvents;
		}
		else{
			$e=new ErrorMsg("EID");
			$this->lastError=$e->toString();

		}
		return false;
	}


	//ok
	public function getRegEvents() {
		$userRow=$this->getUserData();
		if($userRow!=null) {
			$regEvents=array();
			foreach($userRow as $col=>$value){
				if(preg_match("/^EVNT[0-9]{2}$/",$col) && ($value=="SET" || $value=="DONE")) {
					array_push($regEvents,$col);
				}
			}
			return $regEvents;
		}
		else{
			$e=new ErrorMsg("EID");
			$this->lastError=$e->toString();
		}
		return false;
	}
	//ok
	public function getNotRegEvents() {
		$userRow=$this->getUserData();
		if($userRow!=null) {
			$regEvents=array();
			foreach($userRow as $col=>$value){
				if(preg_match("/^EVNT[0-9]{2}$/",$col) && $value=="UNSET") {
					array_push($regEvents,$col);
				}
			}
			return $regEvents;
		}
		else{
			$e=new ErrorMsg("EID");
			$this->lastError=$e->toString();
		}
		return false;
	}
	//ok
	public function getEntryDetails() {
		return $this->getUserData();
	}
	public function getPersonalInfo($all=false,$constr=array()) {
      $filter=($all)?$constr : array("userId"=>$this->userId);
			$userRow=$this->getTableData($this->dataTable,$this->dataTablePersonalInfo,$filter);
			if($userRow) {
        foreach ($userRow as $key => $value) {
          $collegeId=$userRow[$key]['collegeId'];
  				$collegeDetails=$this->getUserData($collegeId,DATA_DB_COLLEGE_TABLE);
  				$res[$key]=array_merge($userRow[$key],$collegeDetails);
        }

        return (count($res)==1)?$res[0] : $res;
			}

			return false;
	}
	public function getPersonalInfoN($all=false,$constr=array()) {
      $filter=($all)?$constr : array("userId"=>$this->userId);
			$userRow=$this->getTableDataI($this->dataTable,$this->dataTablePersonalInfo,$filter);
			if($userRow) {
        foreach ($userRow as $key => $value) {
          $collegeId=$userRow[$key]['collegeId'];
  				$collegeDetails=$this->getUserData($collegeId,DATA_DB_COLLEGE_TABLE);
  				$res[$key]=array_merge($userRow[$key],$collegeDetails);
        }

        return (count($res)==1)?$res[0] : $res;
			}

			return false;
	}
	public function setEntryDetails($userEmail,$firstName,$lastName,$collegeId,$phoneNumber,$evntArray=array(),$isSpotEntry=false,$userId=null,$extra=null) {
		if($this->parseUserId($userId) || $isSpotEntry) {
			if($userId==null) {
				$userId=$this->newUserId();
			}
			if($this->parseEmail($userEmail)) {
					if($this->parsePhoneNumber($phoneNumber)) {
						if($this->isValidCollegeId($collegeId)) {
							if($this->addNewEntry($userId,$userEmail,$firstName,$lastName,$collegeId,$phoneNumber,$evntArray,$extra)){
								return true;
							}
						}
						else{
							$e=new ErrorMsg("ECOLLEGE");
							$this->lastError=$e->toString();
						}
					}
					else{
						$e=new ErrorMsg("EPHONE");
						$this->lastError=$e->toString();
					}
			}
			else{
				$e=new ErrorMsg("EEMAIL");
				$this->lastError=$e->toString();
			}
		}
		else{
			$e=new ErrorMsg("EID");
			$this->lastError=$e->toString();
		}
		return false;
	}
	private function newUserId() {
		return uniqid("spotUser");
	}
	//ALL PARAMS ARE MUST
	private function addNewEntry($userId,$userEmail,$firstName,$lastName,$collegeId,$phoneNumber,$evntArray,$extra=null) {
			if(!is_array($evntArray)) {
				return false;
			}
			$evntEntryCols="";
			$evntEntryBinder="";
			$bindParams=array();
			$evntCount=0;
			$evntStatus='SET';
			foreach ($evntArray as $evnt){
				if(in_array($evnt,$this->userEvents)) {
						$evntEntryCols.=" , $evnt ";
						$evntEntryBinder.=" , :BIND_$evnt ";
						$bindParams[$evntCount]=":BIND_$evnt";
						$evntCount++;
				}
			}
			if($this->isRedundantData('userEmail',$userEmail)) {
					$e=new ErrorMsg("ERUEMAIL");
					$this->lastError=$e->toString(" Please try with another e-mail Id");
					return false;
			}
			if($this->isRedundantData('userId',$userId)) {
					$e=new ErrorMsg("ERUNAME");
					$this->lastError=$e->toString("exiting");
					return false;
			}
			$query="INSERT INTO $this->dataTable (userId , firstName , lastName , userEmail , collegeId ,  phoneNumber  $evntEntryCols , extra) VALUES ( :id , :ufirstname , :ulastname , :uemail , :collegeId , :phoneNo $evntEntryBinder , :extras )";
			$stmt=$this->dbConn->prepare($query);
			$stmt->bindparam(":id",$userId);
			$stmt->bindparam(":ufirstname",$firstName);
			$stmt->bindparam(":ulastname",$lastName);
			$stmt->bindparam(":uemail",$userEmail);
			$stmt->bindparam(":collegeId",$collegeId);
			$stmt->bindparam(":phoneNo",$phoneNumber);
      $stmt->bindparam(":extras",$extra);
			foreach($bindParams as $data){
					$stmt->bindparam($data,$evntStatus);
			}
			try{
				$stmt->execute();
			}
			catch(\Exception $e){
				return false;
			}
			return true;
	}
	//private members
	private function parseEmail($email) {
			if(preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email)){
				return true;
			}
			return false;
	}
	private function parsePhoneNumber($ph) {
			if(preg_match('~^[0-9]{10}$~i', $ph)){
				return true;
			}
			return false;
	}
	private function parseUserId($uId) {
		//buggy
		$db=new DB(USER_DB_NAME);
		$dbHandle=$db->dbConnection();
		$stmt=$dbHandle->prepare("SELECT userId FROM ".USER_DB_TABLE." WHERE userId=:id LIMIT 1");
		try{
			$stmt->execute(array(':id'=>$uId));
		}
		catch(\Exception $e){
				return false;
		}
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($userRow['userId']==$uId) {
			return true;
		}
		return false;
	}
	//----------DENY ALL LESS THAN PLVL03------------------
	public function setGroupId($evnt,$userGroup=array()) {
		if(!is_array($userGroup)) {
			return false;
		}
		if(!in_array($evnt,$this->userEvents)) {
			return false;
		}
		$groupId=uniqid();
		$eventRow=$this->getUserData($evnt,DATA_DB_EVENT_TABLE);
		$max_users=$eventRow['groupEvent'];
		$setUsers=0;
		foreach($userGroup as $user){
			if($this->isValidUserId($user) && $this->isRegisteredForEvent($evnt,$user) && $setUsers < $max_users) {
				//$userId=$this->getDataIdFromUser($user);
				$res=$this->setUserData("groupId".$evnt , $groupId,$user);
				if(!$res) {
					return false;
				}
				$setUsers++;
			}
			else{
				return false;
			}
		}
		if($setUsers<=$max_users) {
			return true;
		}
		return false;
	}
	//ok
	public function getCompanionsForEvent($evnt,$user=null) {
		if($user==null) {
			$user=$this->userId;
		}

		$groupId=$this->getGroupId($user,$evnt);
		if(!$groupId) {
			return false;
		}
		$row=$this->getTableData($this->dataTable,array('userId'),array("groupId".$evnt=>$groupId),array($evnt));
		return $row;
	}
  public function getCompanionsForEventFromGroupId($evnt,$groupId=null)
  {
    if($groupId==null) {
			return falses;
		}
		$row=$this->getTableData($this->dataTable,"*",array("groupId".$evnt=>$groupId),array($evnt));
    foreach ($row as $key => $value) {
      $collegeId=$row[$key]['collegeId'];
      $collegeDetails=$this->getUserData($collegeId,DATA_DB_COLLEGE_TABLE);
      $res[$key]=array_merge($row[$key],$collegeDetails);
    }

		return $res;
  }
	//ok
	public function getGroupId($user=null,$evnt=null) {
		if($evnt==null) {
			return false;
		}
		$row=$this->getUserData($user);
		if($row) {
				foreach($row as $col=>$val){
							if($col=="groupId".$evnt && $val!=null){
							    return $val;
							}
				}
		}
		return false;

	}
	public function isRegisteredForEvent($evnt,$user) {
      $this->selectUserById($user);
			$evnts=$this->getRegEvents();
			if(in_array($evnt,$evnts)) {
				return true;
			}
			return false;
	}
	public function getUsersListByEvents($evnts=array(),$status='SET') {
		$regEvnts=array();
		if(!$this->isValidEventStatus($status)) {
			$status="SET";
		}

		foreach($evnts as $evnt){
				$regEvnts[$evnt]=$status;
				if(!in_array($evnt,$this->userEvents)){
						return false;
				}
		}
		return $this->getTableData($this->dataTable,"*",$regEvnts,"100");
	}
	public function getUserListByCollege($collegeId) {
		if(!$this->isValidCollegeId($collegeId)) {
			return false;
		}
		return $this->getTableData($this->dataTable,"*",array("collegeId"=>$collegeId),"100");
	}
	public function getStaticData($tab,$cols="*",$constraints=array(),$limit="100") {
				$constraints['verified']="1";
			return $this->getTableData($tab,$cols,$constraints,$limit);

	}

  public function addTableData($tab=DATA_DB_TABLE,$data=array()) {
		if(!in_array($tab,array_keys($this->tables))) {
			return false;
		}
		if(!is_array($data)) {

			return false;
		}
		$keyCol=$this->getKeyCol($tab);
			if($keyCol==null) {
				return false;
			}

		if($this->isRedundantData($keyCol,$data[$keyCol],$tab)) {
				return false;
		}
		$colsString="";
		$colBind=array();
		$constraintsBinder="";
		$outStart=true;
		$out="";
		foreach(array_keys($data) as $col){
				if($this->isValidCol($col,$tab)) {
					if($outStart){
						$out=" , ";
						$colsString.="$col";
						$constraintsBinder=":$col";
						$outStart=false;
					}
					else{
						$colsString.="$out $col ";
						$constraintsBinder.=" $out :$col ";
					}
					$colBind[":".$col]=$data[$col];
				}
		}
		$query="INSERT INTO $tab ($colsString) VALUES ( $constraintsBinder ) ";
		$stmt=$this->dbConn->prepare($query);
		try{
			$res=$stmt->execute($colBind);
		}
		catch(\Exception $e){
				return false;
		}
		$userRows=null;
		if($res) {
			return true;
		}
		return false;


	}

  public function getTableData($tab=DATA_DB_TABLE,$cols="*",$constraints=array(),$limit="100",$groupBy=null) {
		if(!in_array($tab,array_keys($this->tables))) {
			return false;
		}
		if(!is_array($constraints)) {
			return false;
		}
		$colsString="";
		$constraintsBinder="";
		$constraintsBindParams=array();
		$outStart=true;
		$out="";
		if(!is_array($cols)) {
			$colsString='*';
		}
		else {
			foreach($cols as $col){
					if($this->isValidCol($col,$tab)) {
						if($outStart){
							$out=" , ";
							$colsString.="$col";
							$outStart=false;
						}
						else{
							$colsString.="$out $col ";
						}
					}
			}
		}
		foreach(array_keys($constraints) as $constraint){
				if($this->isValidCol($constraint,$tab)) {

					$constraintsBinder.=" AND $constraint = :BIND_$constraint ";
					$constraintsBindParams[":BIND_$constraint"]=$constraints[$constraint];
				}
		}
    if($groupBy===null){
       $altKey=$this->altKeys[$tab];
    }
    else{
      $altKey=$groupBy;
    }
		$query="SELECT $colsString FROM $tab WHERE 1=1  $constraintsBinder ORDER BY $altKey";
		$stmt=$this->dbConn->prepare($query);
		try{
			$res=$stmt->execute($constraintsBindParams);
		}
		catch(\Exception $e){
				return false;
		}
		$userRows=null;
		if($res) {
			$userRows=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $userRows;
		}
		return false;


	}
	 public function getTableDataI($tab=DATA_DB_TABLE,$cols="*",$constraints=array(),$limit="100",$groupBy=null) {
		if(!in_array($tab,array_keys($this->tables))) {
			return false;
		}
		if(!is_array($constraints)) {
			return false;
		}
		$colsString="";
		$constraintsBinder="";
		$constraintsBindParams=array();
		$outStart=true;
		$out="";
		if(!is_array($cols)) {
			$colsString='*';
		}
		else {
			foreach($cols as $col){
					if($this->isValidCol($col,$tab)) {
						if($outStart){
							$out=" , ";
							$colsString.="$col";
							$outStart=false;
						}
						else{
							$colsString.="$out $col ";
						}
					}
			}
		}
		foreach(array_keys($constraints) as $constraint){
				if($this->isValidCol($constraint,$tab)) {

					$constraintsBinder.=" AND $constraint IN $constraints[$constraint]";
					//$constraintsBindParams[":BIND_$constraint"]=$constraints[$constraint];
				}
		}
    if($groupBy===null){
       $altKey=$this->altKeys[$tab];
    }
    else{
      $altKey=$groupBy;
    }
		$query="SELECT $colsString FROM $tab WHERE 1=1  $constraintsBinder ORDER BY $altKey";
		//echo  $query;
		//var_dump($constraintsBindParams);
		$stmt=$this->dbConn->prepare($query);
		try{
			$res=$stmt->execute($constraintsBindParams);
		}
		catch(\Exception $e){
				return false;
		}
		$userRows=null;
		if($res) {
			$userRows=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $userRows;
		}
		return false;


	}
  public function searchTableData($tab=DATA_DB_TABLE,$cols="*",$constraints=array(),$limit="100") {
		if(!in_array($tab,array_keys($this->tables))) {
			return false;
		}
		if(!is_array($constraints)) {
			return false;
		}
		$colsString="";
		$constraintsBinder="";
		$constraintsBindParams=array();
		$outStart=true;
		$out="";
		if(!is_array($cols)) {
			$colsString='*';
		}
		else {
			foreach($cols as $col){
					if($this->isValidCol($col,$tab)) {
						if($outStart){
							$out=" , ";
							$colsString.="$col";
							$outStart=false;
						}
						else{
							$colsString.="$out $col ";
						}
					}
			}
		}
		foreach(array_keys($constraints) as $constraint){
				if($this->isValidCol($constraint,$tab)) {

					$constraintsBinder.=" AND $constraint LIKE :BIND_$constraint ";
					$constraintsBindParams[":BIND_$constraint"]=$constraints[$constraint];

				}
		}
    $altKey=$this->altKeys[$tab];
		$query="SELECT $colsString FROM $tab WHERE 1=1  $constraintsBinder ORDER BY $altKey";
		$stmt=$this->dbConn->prepare($query);
		try{
			$res=$stmt->execute($constraintsBindParams);
		}
		catch(\Exception $e){
				return false;
		}
		$userRows=null;
		if($res) {
			$userRows=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $userRows;
		}
		return false;


	}
  public function setTableData($tab=DATA_DB_TABLE,$cols=array(),$userId=null,$isGen=false,$constr=null) {
		if(!in_array($tab,array_keys($this->tables))) {
			return false;
		}
    if(!is_array($cols)) {
			return false;
		}
    if($userId==null) {
			$userId=$this->userId;
		}
    $res=true;
		foreach($cols as $key=>$value){
          if(!$this->setUserData($key,$value,$userId,$tab,$isGen,$constr)){
            $res=false;
          }
		}
    return $res;
	}
	//ok
	public function setEventStatus($evnt,$stat,$userId=null){
		if($userId==null && $this->userId!=null) {
			$userId=$this->userId;
		}
		if(!$this->isValidEventStatus($stat)) {
			return false;
		}
		if($this->setUserData($evnt,$stat,$userId)) {
			return true;
		}
		return false;
	}
	//gets the user row from data id
	public function getUserData($user=null,$tab=DATA_DB_TABLE) {
			if($user==null && $this->userId!=null) {
				$user=$this->userId;
			}
			$keyCol=$this->getKeyCol($tab);
			if($keyCol==null) {
				return false;
			}
			$stmt=$this->dbConn->prepare("SELECT * FROM $tab WHERE $keyCol = :dId LIMIT 1");
			try{
				$stmt->execute(array(":dId" => $user));
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
	public function setUserData($col,$val,$userId=null,$tab=DATA_DB_TABLE,$isGen=false,$constr=null) {

			if($isGen){
        $keyCol=$constr[0];
        $userId=$constr[1];
      }
      else {
        if($userId==null && $this->userId!=null) {
  				$userId=$this->userId;
  			}
  			if(!$this->isValidCol($col,$tab)){
  				return false;
  			}
        $keyCol=$this->getKeyCol($tab);
  			if($keyCol==null){
  				return false;
  			}

      }
			$stmt=$this->dbConn->prepare("UPDATE $tab SET $col = :val WHERE $keyCol =:dId");
			try{
				$stmt->execute(array(":dId" => $userId,":val"=>$val));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt->rowCount() == 1) {
				return true;
			}
      $this->lastError="UNEXPECTED ERROR ";
			return false;
	}
	private function getKeyCol($tab) {
		$res=null;
		if(in_array($tab,array_keys($this->tables))) {
			$res=$this->tables[$tab];
		}
		return $res;

	}
	//for error free database connection
	private function isValidCol($col,$tab=DATA_DB_TABLE) {
		$res=false;
		if(in_array($tab,array_keys($this->tables))) {
			$res=in_array($col,$this->tableCols[$tab]);
		}
		return $res;
	}
	private function isValidEventStatus($evnt) {
		return in_array($evnt,$this->eventStatuses);
	}
	private function isValidCollegeId($id) {
		$userRow=$this->getUserData($id,DATA_DB_COLLEGE_TABLE);
		if($userRow!=null) {
			return true;
		}
		return false;

	}
	private function getDataIdFromUser($user) {
			$stmt=$this->dbConn->prepare("SELECT userId FROM $this->dataTable WHERE userId =:uId");
			try{
				$stmt->execute(array(":uId" => $user));
			}
			catch(\Exception $e){
				return false;
			}
			if($stmt) {
				$res=$stmt->fetch(PDO::FETCH_ASSOC);
				return $res['userId'];
			}
			return false;

	}
	private function isValidUserId($id) {
		$userRow=$this->getDataIdFromUser($id);
		if($userRow) {
			return true;
		}
		return false;

	}
	//checks whether the given record is in the table
	private function isRedundantData($col,$val,$tab=DATA_DB_TABLE) {
			if(!$this->isValidCol($col,$tab)) {
				return false;
			}
			$stmt=$this->dbConn->prepare("SELECT $col FROM $tab  WHERE $col = :value");
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
  public function setExtra($key,$val)
  {
    $user=$this->getUserData();
    if($user!=null){
      try{
        $extras=$user['extra'];
        $extraJSON=json_decode($extras,true);
        $extraJSON[$key]=$val;
        $outJSON=json_encode($extraJSON);
        $this->setUserData('extra',$outJSON);
        return true;
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
        $extraJSON=json_decode($extras,true);
        return $extraJSON[$key];
      }
      catch(\Exception $e){
        return null;
      }
    }
  }
  public function getFormatedTableData($constr=array())
  {
    $whiteListCols=array(
      "userId","firstName","lastName","userEmail","extra","phoneNumber","collegeId"
    );
    array_merge($whiteListCols,$this->userEvents);
    $data=$this->getTableData(DATA_DB_TABLE,$whiteListCols,$constr);
    $replacements=array(
      "userId"=>"userID",
      "collegeId"=>"collegeID",
      "phoneNumber"=>"phone",
      "userEmail"=>"email",
    );
    $result=array();
    $pos=0;
    foreach ($data as $dataRow ) {
      foreach ($dataRow as $key => $value) {
        foreach ($replacements as $inital => $replaced) {
          if ($inital===$key) {
            $result[$pos][$replaced]=$value;
          }
        }
      }
      $this->selectUserById($dataRow['userId']);
      $result[$pos]['name']=array($dataRow['firstName'],$dataRow['lastName']);
      $result[$pos]['events']=$this->getRegEvents();
      $result[$pos]['extra']=json_decode($dataRow['extra']);
      $pos++;
    }
    return $result;

  }
  public function searchFormatedTableData($constr=array())
  {
    $whiteListCols=array(
      "userId","firstName","lastName","userEmail","extra","phoneNumber","collegeId"
    );
    array_merge($whiteListCols,$this->userEvents);
    $data=$this->searchTableData(DATA_DB_TABLE,$whiteListCols,$constr);
    $replacements=array(
      "userId"=>"userID",
      "collegeId"=>"collegeID",
      "phoneNumber"=>"phone",
      "userEmail"=>"email",
    );
    $result=array();
    $pos=0;
    foreach ($data as $dataRow ) {
      foreach ($dataRow as $key => $value) {
        foreach ($replacements as $inital => $replaced) {
          if ($inital===$key) {
            $result[$pos][$replaced]=$value;
          }
        }
      }
      $this->selectUserById($dataRow['userId']);
      $result[$pos]['name']=array($dataRow['firstName'],$dataRow['lastName']);
      $result[$pos]['events']=$this->getRegEvents();
      $result[$pos]['extra']=json_decode($dataRow['extra']);
      $pos++;
    }
    return $result;

  }
  public function setFormatedTableData($dataRow=array())
  {
    if (!is_array($dataRow)) {
      return false;
    }

    if($this->setEntryDetails($dataRow['email'],$dataRow['name'][0],$dataRow['name'][1],$dataRow['collegeID'],$dataRow['phone'],$dataRow['events'],true,null,json_encode($dataRow['extra']))){

      return true;
    }
    return false;

  }
  public function updateFormatedTableData($dataRow=array())
  {
    $replacements=array(
      "collegeID"=>"collegeId",
      "phone"=>"phoneNumber",
      "email"=>"userEmail",
    );
    $result=array();
    $pos=0;
    if (isset($dataRow['events'])) {
      foreach ($dataRow['events'] as $value) {
        $result[$value]="SET";
      }
    }
    if (isset($dataRow['extra'])) {
      $this->selectUserById($dataRow['userID']);
      foreach ($dataRow['extra'] as $key=>$value) {
        $this->setExtra($key,$value);
      }
    }
    if (isset($dataRow['name'])) {
      $result['firstName']=$dataRow['name'][0];
      $result['lastName']=$dataRow['name'][1];
    }
    foreach ($dataRow as $key => $value) {
      foreach ($replacements as $inital => $replaced) {
        if ($inital===$key) {
          $result[$replaced]=$value;
        }
      }
    }
    if ($this->setTableData(DATA_DB_TABLE,$result,$dataRow['userID'])) {
      return true;
    }
    return false;

  }
  public function setResult($evnt,$groupId,$pos)
  {
    $pos--;
    $resultCols=array("winner","runnerUp","runnerUp2");
    $current=$this->getTableData(DATA_DB_RESULT_TABLE,array('eventId'),array("eventId"=>$evnt));
    if (count($current)) {
      if($this->setTableData(DATA_DB_RESULT_TABLE,array($resultCols[$pos]=>$groupId),null,true,array('eventId',$evnt)))
        return 1;
    }
    else{
      if($this->addTableData(DATA_DB_RESULT_TABLE,array("eventId"=>$evnt,$resultCols[$pos]=>$groupId)))
        return 2;
    }
    return false;
  }

};
?>
