<?php
  if(!defined('ADV_DASH')){
    exit;
  }
 ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <title>Asthra 2k18-App Auth</title>
      <link href="assets/vendor/bootstrap/css/bootstrap.flatly.min.css" rel="stylesheet" />
    </head>
    <body style="background-color:#000;color:#fff;height:100%">
      <div class="container-fluid">
        <div class="rowr">
          <div class="col-lg-8" style="margin:10px 16.6666%">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <h4>Android App Authentication
                <div class="pull-right" style="color:#fff;font-size:17px;cursor:pointer;" id="home">Home</div></h4>
              </div>
              <div class="panel-body" style="height:auto;color:#000;display:block" id="panel-main">
                <form class="form-horizontal" id="spot-tab-form-elem">
                   <div class=" well well-sm " style="padding-bottom:3px;">
                      <div class="form-group">
                         <label class="control-label col-sm-3" for="email">NEW USER</label>
                         <div class="col-sm-4">
                            <input type="text" class="form-control" id="email" placeholder="Enter new user name..." >
                         </div>
                         <div class="col-sm-4">
                           <input type="text" class="form-control" id="name" placeholder="Enter name">
                         </div>
                         <div class="col-sm-1">
                           <button type="button" class="btn btn-md btn-success pull-right" id="new-btn">OK</button>
                         </div>
                      </div>
                      <div class="form-group">
                         <label class="control-label col-sm-3" for="event">EVENT</label>
                         <div class="col-sm-9">
                            <select class="form-control" id="event">
                               <option value="" selected="selected">--select event--</option>
                                <option value="EVNT01" >BAKER STREET</option>
                                <option value="EVNT02" >ILLUMINATI</option>
                                <option value="EVNT03">SANS-LEXICO</option>
                                <option value="EVNT04" >KALOSPIA</option>
                                <option value="EVNT05" >TECHNOCRATI</option>
                                <option value="EVNT06" >VEO_C_DAD</option>
                                <option value="EVNT07">CRYP_TRICKS</option>
                                <option value="EVNT08">DIGISTHRA</option>
                            </select>
                          
                         </div>
                         
                         
                      </div>
                      <div class="form-group">
                      	 <div class="col-sm-9 text-right"><label for="admin" class="control-label" class="col-sm-2">is Admin</label></div>
                         <div class="col-sm-3">
                            <input type="checkbox" id="admin" class="form-control"/>
                         </div>
                      </div>
                   </div>
                   <hr width="100%"/>
                   
                   <div class=" well well-sm " style="padding-bottom:3px;">
                      <div class="form-group">
                         <label class="control-label col-sm-3" for="find-email">FIND USER</label>
                         <div class="col-sm-8">
                            <input type="text" class="form-control" id="find-email" placeholder="Enter existing user name..." >
                         </div>
                         <div class="col-sm-1">
                           <button type="button" class="btn btn-md btn-success pull-right" id="find-btn">OK</button>
                         </div>
                      </div>
                      <div class="form-group">
                         <label class="control-label col-sm-3" for="event">EVENT</label>
                         <div class="col-sm-9">
                            <select class="form-control" id="find-event">
                               <option value="" selected="selected">--select event--</option>
                                <option value="EVNT01" >BAKER STREET</option>
                                <option value="EVNT02" >ILLUMINATI</option>
                                <option value="EVNT03">SANS-LEXICO</option>
                                <option value="EVNT04" >KALOSPIA</option>
                                <option value="EVNT05" >TECHNOCRATI</option>
                                <option value="EVNT06" >VEO_C_DAD</option>
                                <option value="EVNT07">CRYP_TRICKS</option>
                                <option value="EVNT08">DIGISTHRA</option>
                            </select>
                         </div>
                      </div>
                      <div class="form-group">
                      	 <div class="col-sm-9 text-right"><label for="find-admin" class="control-label" class="col-sm-2">is Admin</label></div>
                         <div class="col-sm-3">
                            <input type="checkbox" id="find-admin" class="form-control"/>
                         </div>
                      </div>
                   </div>
                </form>
              </div>
              <div class="panel-body" id="panel-res" style="text-align:center;height:500px;display:none">
                  <img id="img-token" src="https://qrcode.online/img/?type=text&size=15&data=none" height="400" width="400" style="margin:10px;"/>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script src="assets/vendor/jquery/jquery.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
      <script>
        $(document).ready(function () {

          var email="",name="",eventID="",admin=false;
          $("#new-btn").click(function () {
            email="";name="";eventID="";
            email=$('#email').val();
            name=$('#name').val();
            eventID=$('#event').val();
            admin=$('#admin').is(":checked");
            if(email!="" && name!="" && eventID!=""){
              $.post("http://register.mesasthra.com/ref/adv/account.php",{action:"NEW_APP",user_EMAIL:email,user_NAME:name,eventId:eventID},function(result){
                if (typeof result === 'object') {
                  if(result.status==true){
                    responseData=JSON.parse(result.data);
                    qrToken={
                      userID:responseData['user_NAME'],
                      userToken:responseData['user_ID'],
                      eventID:responseData['eventId'],
                      isAdmin:admin
                    };
                    qrData=JSON.stringify(qrToken);
                    console.log(qrToken);
                    $("#img-token").attr({"src":"https://qrcode.online/img/?type=text&size=8&data="+qrData+"&nod="+(Math.random()*1000)})
                                    .on("load",function () {

                                      $("#panel-main").hide();
                                      $("#panel-res").fadeIn();
                                    }).
                                    on("error",function () {
                                      alert("Cound not load Qr code");
                                  });
                  }
                  else{
                    alert("ERROR:"+result.data);
                  }
                }
              });
            }
            else{
              alert("Enter valid fields");
            }
          });
          $("#find-btn").click(function () {

            email="";name="";eventID="";
            email=$('#find-email').val();
            eventID=$('#find-event').val();
            admin=$('#find-admin').is(":checked");
            if(email!=""  && eventID!=""){
              $.post("http://register.mesasthra.com/ref/adv/account.php",{action:"GET_TOKEN",user_EMAIL:email,eventId:eventID},function(result){
                if (typeof result === 'object') {
                  if(result.status==true){
                    responseData=JSON.parse(result.data);
                    qrToken={
                      userID:responseData['user_NAME'],
                      userToken:responseData['user_ID'],
                      eventID:responseData['eventId'],
                      isAdmin:admin
                    };
                    qrData=JSON.stringify(qrToken);
                    console.log(qrToken);
                    $("#img-token").attr({"src":"https://qrcode.online/img/?type=text&size=8&data="+qrData+"&nod="+(Math.random()*1000)})
                                    .on("load",function () {

                                      $("#panel-main").hide();
                                      $("#panel-res").fadeIn();
                                    }).
                                    on("error",function () {
                                      alert("Cound not load Qr code");
                                  });
                  }
                  else{
                    alert("ERROR:"+result.data);
                  }
                }
              });
            }
            else{
              alert("Enter valid fields");
            }
          });
          $("#home").click(function () {
              $("#panel-res").hide();
              $("#panel-main").fadeIn();
          });
        });
      </script>
    </body>
    </html>
