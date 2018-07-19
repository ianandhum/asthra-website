<?php
  require_once("../../config/RegData.class.php");
  header("Content-Type:text/javascript");
  $data=new RegData();
  $COLLEGE=$data->getStaticData(DATA_DB_COLLEGE_TABLE,"*",array(),"300");
  $EVENT=$data->getStaticData(DATA_DB_EVENT_TABLE,"*",array(),"300");
?>
//static data::to be loaded at startup or from the server
Static={
events:{
  head:['Event name','Event Description','Max Quota'],
  content:{
    <?php
      foreach ($EVENT as $key => $value) {
        echo $value['eventId'].":[\"".$value['eventName']."\",\"".$value['eventDesc']."\",".$value['groupEvent']."],\n";
      }
    ?>
  }
},
colleges:{
  head:['College name'],
  content:{
    COL:['--Select College--'],
    COL5a3e19eb7ddbe:['MES College Nedumkandam'],
    <?php
      foreach ($COLLEGE as $key => $value){
        echo $value['collegeId'].":[\"".$value['collegeName']."\"],\n";
      }

    ?>

  }

},
targets:[
  "REGIN",
  "NEW_GROUP",
  "EDIT_GROUP",
]
};
