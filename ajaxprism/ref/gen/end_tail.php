<!DOCTYPE html>
<html>
<head>
<title>Asthra 2k18</title>
	<meta  name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"/>
	<link rel="shortcut icon" href="/ajaxprism/icon.ico"/>
	<style type="text/css">
		*{
			font-family: Helvetica, sans-serif;
		}
		body{
			margin: 0;
			background-color:#eee;
		}
		.msg-box{
			min-height: 100px;
			width: 50%;
			margin:auto;
			margin-top:20%;
			background:#fff;
			box-shadow: 0px 0px 25px rgba(0,0,0,0.2);
			-webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.2);
			-moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.2);
			-ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.2);
		}
		.error{
			background-color:#d32;
			color: #fff;
		}
		.success{
			background-color:#4caf50;
			color: #fff;
		}
		.title{
			font-size: 26px;
			font-weight: bold;
			padding:0px 10px;
			color: #fff;
		}
		.msg{
			width:100%;
			height:100%;
			margin:0;
			text-align: center;
			font-variant:small-caps;
			font-weight: bold;
			padding:5% 0px;
			font-size: 17px;
		}
		.msg > .sub{
			color:#333;
			padding:5px;
		}
		a{
		    color:#00a;
		    text-decoration:none;
		    font-size:15px;

		}
		a:hover{
		    color:#fff;

		}
		@media only screen and (max-width:800px){
		    .msg-box{
		          width:95%;
		          margin-top:40%;

		    }

		}

	</style>
</head>
<body>
<div class="msg-box
	<?php
		if(isset($status)) {
			echo  strtolower($status);
		}

	?>

	">
	<div class="msg">
 	 	<?php
 	 	echo strtolower($msgMain);
 	 	if(isset($msgSub)){
 	 			echo "<div class=\"sub\">".strtolower($msgSub)."</div>";
		}
 	 ?>
	</div>

</div>
<!--	var time;
	window.onload=function(){
		time=setInterval(timer(),5000);
	}
	function timer(){
		window.close();
		clearInterval(time);
	}
</script>
-->
</body>
</html>
