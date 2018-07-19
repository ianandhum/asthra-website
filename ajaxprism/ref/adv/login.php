<?php

	session_start();
	require_once("../../config/User.class.php");
	$user=new User(true);
	$attempt=0;
	$mail="";
	if(isset($_POST['uEmail']) && !empty($_POST['uEmail'])) {
		$mail=$_POST['uEmail'];
		$attempt++;
	}
	$pass="";
	if(isset($_POST['uPass']) && !empty($_POST['uPass'])) {
		$pass=$_POST['uPass'];
		$attempt++;
	}

	if($user->isLoggedIn() && !$user->isNaiveUser()) {

					echo "Taking to Dash Board...";
					header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header("Location:".SERVER_HOST."dash_board.php");
					exit;
	}
	if($user->isLoggedIn() && $user->isNaiveUser()) {
		//miracle, security breach
	}
	$msg="";
	$err=false;
	$ref="";
	if(isset($_GET['ref_msg']) && !empty($_GET['ref_msg'])) {
		$ref=$_GET['ref_msg'];
		if($ref=="out") {
			$msg="<span style=\"color:#353\">Logged Out</span>";
			$err=true;
		}

	}
	if(!$user->isLoggedIn() && $attempt==2) {
		if($user->login($mail,$pass,false,"DEV_DATA_FETCH")){

					echo "Taking to Dash Board...";
					header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header("Location:".SERVER_HOST."dash_board.php");
					exit;

		}
		else{
			$msg=$user->lastError;
			$err=true;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>login</title>
	<meta  name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="../../assets/script/jquery-3.2.1.min.js"></script>
<style type="text/css">
*{
	box-sizing:border-box;
	margin:0;
}
body{
	width:100%;
	min-height: 100%;
	height: auto;
	font-family: Helvetica , sans-serif;
	background:#fff;
}
#login-left{
	position:fixed;
	float: left;
	left:0px;
	top:0px;
	height:100%;
	width:100%;
	background:#000;
	background-image:url("<?php  $_SERVER['HTTP_HOST'] ?>/assets/img/home-bg.jpg");
	background-repeat: repeat-y;
	background-position: center center;
	background-size: cover;
}
#form-login{
	position: fixed;
	float: right;
	right: 0px;
	top: 0px;
	height: 90%;
	width:30%;
	margin:3% 2%;
	background:#f9f9f9;
	z-index: 2;
	box-shadow: 5px 5px  5px #111 ;
	-webkit-box-shadow: 5px 5px  5px #111 ;
	-moz-box-shadow: 5px 5px  5px #111 ;
	-ms-box-shadow: 5px 5px  5px #111 ;
	border-radius: 4px;
	-webkit-border-radius: 4px;
	-ms-border-radius: 4px;
	-moz-border-radius: 4px;
}
#back-pattern{
	height: 100%;
	width: 100%;
	top: 0px;
	left: 0px;
	position: fixed;
	background-color:rgba(0,0,0,0.6);
	//background-image:url("<?php  $_SERVER['HTTP_HOST'] ?>/assets/img/texture.png");
	background-repeat: repeat;
	z-index: 0;
}
#form-content{
	height: 100%;
	margin:12% 0;
}
#div-logo{
	height:100px;
	width:100%;
	background-image:url("<?php  $_SERVER['HTTP_HOST'] ?>/assets/img/logo.png");
	background-repeat: no-repeat;
	background-position: center center;
}
.content{
	height: 100%;
	width: 100%;
	position: absolute;
	background:transparent;
	z-index: 1;
}
.form-entry{
	width:94%;
	height:40px;
	margin:40px 3%;
}
.form-entry-field{
	float: left;
	height:100%;
	width: 30%;
	padding:15px;
	font-size:16px;
	color:#07f;
	text-align: left;
	background:transparent;
}
.form-entry-input{
	height:100%;
	width:70%;
	background:transparent;
	border:0px;
	font-size: 16px;
	color:#036;
	text-align: left;
	border-bottom:2px solid #07f;
}
.form-entry-text{
	height:100%;
	width:100%;
	background:transparent;
	border:0px;
	font-size: 19px;
	color:#333;
	text-align: center;
	margin:20px 0;
}
.form-entry-link{
	height:30px;
	width:100%;
	border:0px;
	font-size: 15px;
	text-align: right;
	padding-right: 30px;
	margin:0;
}
.login-bt{
	width:92%;
	height:50px;
	background:#07f;
	margin:10px;
	border:0px;
	float: right;
	color:#fff;
	font-weight: bold;
	font-size: 16px;
	border-radius: 15px;
	-webkit-border-radius: 15px;
	-ms-border-radius: 15px;
	-moz-border-radius: 15px;
	box-shadow: 1px 1px 4px  #777;
	-webkit-box-shadow: 1px 1px 4px  #777;
	-moz-box-shadow: 1px 1px 4px  #777;
	-ms-box-shadow: 1px 1px 4px  #777;
	transition: all 100ms linear 0s;
	-webkit-transition: all 100ms linear 0s;
	-moz-transition: all 100ms linear 0s;
	-ms-transition: all 100ms linear 0s;
}
.login-bt:hover{
	background:#05a;
}
.login-bt:active{
	background:#09f;
}
@media only screen and (max-width:920px){
	#form-login{
		width: 100%;
		position: relative;
		clear: both;
		border-radius:0px;
		-webkit-border-radius:0px;
		-ms-border-radius:0px;
		-moz-border-radius:0px;
	}
	#login-left{

		width: 100%;
		position: relative;
		clear: both;
	}
}
</style>
</head>
<body>
	<form id="form-login" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
		<div id="div-logo"></div>
		<div id="form-content">
			<div class="form-entry">
				<div class="form-entry-text">
				<?php
				if($err==true && $ref!="out") {
					echo "<div style=\"background:rgba(200,50,50,0.7);padding:10px;color:#fff;border:1px solid #fff;width:100%\">$msg</div>";
				}
				else if($err) {
					echo "$msg";
				}
				else{
					echo "<b>Super-user</b> Login";
				}
				?>
				</div>
			</div>

			<div class="form-entry">
				<div class="form-entry-field">User name</div>
				<input type="text" name="uEmail" id="uEmail"  class="form-entry-input" placeholder="Enter user name" value="<?php echo $mail;?>"/>
			</div>
			<div class="form-entry">
				<div class="form-entry-field">Password</div>
				<input type="password" name="uPass" id="uPass"  class="form-entry-input" placeholder="Enter Your password"/>
			</div>
			<div class="form-entry-link" <?php if($err && $ref!='out'){echo "style=\"display:block;\"";} else {echo "style=\"display:none;\"";} ?> >
				<a href="#">forgot password?</a>
			</div>

			<input type="button" value="LOGIN" class="login-bt" id="login-bt"/>
		</div>
	</form>
	<div id="login-left">
	<div class="content">
		
	</div>
	<div id="back-pattern"></div>
	</div>
</body>

	<script type="text/javascript">
		$(document).ready(function () {
			adjust();
			$(window).resize(function () {
				adjust();
			});
			$("#login-bt").click(function () {
				var error=false;
				if (getId("uEmail").value=="") {

					$("#uEmail").css({color:"#f00"});
					$("#uEmail").css({"border-bottom-color":"#f00"});
					error=true;
				}
				if (getId("uPass").value=="") {

					$("#uPass").css({color:"#f00"});
					$("#uPass").css({"border-bottom-color":"#f00"});
					error=true;
				}
				if (!error) {
					$("#form-login").submit();
				}
				else {
					$(".form-entry-input").focus(function () {
						$(this).css({"border-bottom-color":"#07f",color:"#036"});
					});
				}
			});
		});
		function adjust() {
			var wH=$(window).height(),wW=$(window).width();
			if (wW < 920) {
				$("#form-login").css({"min-height":(wH),margin:"0"});
				$("#login-left").css({width:(wW),height:(wH)});
			}
			else {

				$("#form-login").css({"min-height":(wH*0.9),margin:"3% 2%"});
				$("#login-left").css({width:"100%",height:"100%"});
			}
		}
		function getId(id) {
		return document.getElementById(id);
	}
	</script>
</html>
