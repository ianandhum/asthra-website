<?php
  header("Content-Type:text/json");
  $status=array("status"=>"success","post"=>$_POST,"get"=>$_GET,"cookie"=>$_COOKIE);
  echo json_encode($status);

 ?>
