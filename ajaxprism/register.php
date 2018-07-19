<?php
	session_start();
	require_once("config/User.class.php");
	require_once("config/RegData.class.php");
	$user=new User(true);
	if($user->isLoggedIn()) {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Location:dash_board.php");
			exit;
	}
	else{
		$data=new RegData(false);
		$pass=uniqid("pass");
		//$msgMain="Online Registration is Closed";
		//$status="success";
		//include_once("ref/gen/end_tail.php");
		//exit;
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111741145-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111741145-1');
 </script>

 <title>Registration - Asthra 2k18</title>
	<meta  name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"/>
	<meta name="description" content="Registration portal for Asthra 2k18 at  MES College Nedumkandam on JAN 16,17 2018"/>
	<meta name="keywords" content="asthra 2k18,asthra registration,mesasthra registration,JAN 16 17"/>
	<link rel="stylesheet" type="text/css" href="assets/style/form.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Changa&text=asthra%202k18%20registration" rel="stylesheet">
	<link rel="shortcut icon" href="icon.ico"/>
	<script type="text/javascript" src="assets/script/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="assets/script/dw_tooltip_c.js"></script>
</head>
<body>
<div id="reg-left">
	
	<div id="back-pattern" style="display:block;"></div>
</div>
<form id="form-container" method="POST" action="ref/std/register-new.php">
	<h1 id="form-head">
		Asthra 2k18 registration
	</h1>
	<div class="form-desc">All fields are required</div>
	<div class="form">
		<div class="form-entry-short">
			<div class="form-entry-field">First Name</div>
			<input type="text" name="uFirstName" id="uFirstName" class="form-entry-input" placeholder="Enter first name"/>
		</div>
		<div class="form-entry-short">
			<div class="form-entry-field">Last Name</div>
			<input type="text" name="uLastName" id="uLastName"   class="form-entry-input" placeholder="Enter last name"/>
		</div>
		<div class="form-entry" >
			<div class="form-entry-field">College</div>
			<select  class="form-entry-input" name="collegeId" id="collegeId"  style="font-size: 15px;">
				<option value="" selected="selected" style="color:#aaa">--select college--</option>
				<?php
					$dataRows=$data->getStaticData(DATA_DB_COLLEGE_TABLE);
					if(is_array($dataRows)) {
						foreach($dataRows as $row){
								echo "<option value=\"".$row['collegeId']."\" >".$row['collegeName']."</option>\n";
						}
					}

				?>
				<option value="customId">Other</option>
				<!-- auto load collegeList -->
			</select>
		</div>
		<div class="form-entry" id="collegeAltEntry" style="display: none;">
			<div class="form-entry-field">College Name</div>
			<input type="text" name="collegeName" id="uCollegeName"  class="form-entry-input" placeholder="Enter Your College's name"/>
		</div>
		<div class="form-entry">
			<div class="form-entry-field">E-mail</div>
			<input type="email" name="uEmail" id="uEmail"  class="form-entry-input" placeholder="Enter e-mail address"/>
		</div>
		<div class="form-entry-text" id="mail-entry-text">
			You will receive a verification link to your e-mail address
		</div>
		<div class="form-entry">
			<div class="form-entry-field">Phone</div>
			<input type="text" name="phoneNumber" id="phoneNumber" class="form-entry-input" placeholder="Enter your phone number"/>
		</div>
		<div class="form-entry-text" >
			Your phone number will be stored as your contact info
		</div>

		<div class="form-entry-short">
			<div class="form-entry-field big" style="width:80%">Require accomodation *</div>
			<input type="hidden"  name="acco" id="acco" value="0"/>
			<input type="button" class="form-entry-input-t toggle" data-state="off" style="width:20%" value="NO">
		</div>

		<input type="button" value="Register" id="submit-bt"  class="submit-bt"/>
		<div class="form-entry-text" id="add-chrg-notfiy" style="display:none;">
			* Additional charges apply
		</div>
		<input type="hidden" name="name_id" value="new_user_entry_1234" />
		</div>
</form>
<div id="cover"></div>
<script type="text/javascript" >
	$(document).ready(function () {
		adjust();
		$(window).resize(function () {
				adjust();
		});
		$(".toggle").click(function (e) {
			e.preventDefault();
			if($(this).attr('data-state')=='off'){
				$(this).attr({'data-state':"on"});
				$("#add-chrg-notfiy").show();
				$(this).addClass('toggle-active').val("YES");
				$('#acco').val("1");
			}
			else{
				$(this).attr({'data-state':"off"});
				$("#add-chrg-notfiy").hide();
				$(this).removeClass('toggle-active').val("NO");
				$('#acco').val("0");

			}

		});
		var form=getId("form-container"),
				fName=getId("uFirstName"),
				lName=getId("uLastName"),
				eMail=getId("uEmail"),
				collegeId=getId("collegeId"),
				phNo=getId("phoneNumber"),
				submit_bt=getId("submit-bt"),
				collegeAlt=getId("uCollegeName");
		fName.focus(true);
		$(collegeId).click(function () {
			if (collegeId.value=="customId") {
				$('#collegeAltEntry').show();
			}
			else {
				$('#collegeAltEntry').hide();
			}
		});


		var error=false;
		var lastEntry=eMail.value;
		$(eMail).blur(function () {
			if (lastEntry!=eMail.value && formValidator.isValidEmail(eMail.value)) {
				lastEntry=eMail.value;
				jQuery.post("ref/gen/check.php",{action:"red_mail",id:lastEntry},function (data) {
						if (data.status==0) {
							$("#mail-entry-text").text(data.msg).css({color:"#d22"});
							error=true;
						}
						else {
							$("#mail-entry-text").text("You will receive a verification link to your e-mail address").css({color:"#050"});
							error=false;
						}
				});

			}
		});
		$(submit_bt).click(function () {
			if (!formValidator.isValidEmail(eMail.value)) {
				$(eMail).removeClass("EEMAIL");
				$(eMail).addClass("showTip EEMAIL");
				eMail.style.color="#f00";
				eMail.style.border="1px solid #f00";
				error=true;
			}
			if (collegeId.value=="") {
				$(collegeId).removeClass("ECOLLEGE");
				$(collegeId).addClass("showTip ECOLLEGE");
				collegeId.style.color="#f00";
				collegeId.style.border="1px solid #f00";
				error=true;
			}
			if (collegeId.value=="customId" && collegeAlt.value=="") {
				$(collegeAlt).removeClass("ECOLLEGENAME");
				$(collegeAlt).addClass("showTip ECOLLEGENAME");
				collegeAlt.style.color="#f00";
				collegeAlt.style.border="1px solid #f00";
				error=true;
			}

			if (!formValidator.isValidName(fName.value)) {

				$(fName).removeClass("ENAME");
				$(fName).addClass("showTip ENAME");
				fName.style.color="#f00";
				fName.style.border="1px solid #f00";
				error=true;
			}
			if(!formValidator.isValidName(lName.value)){
				$(lName).removeClass("ENAME");
				$(lName).addClass("showTip ENAME");
				lName.style.color="#f00";
				lName.style.border="1px solid #f00";
				error=true;
			}
			if (!formValidator.isValidPhone(phNo.value)) {

				$(phNo).removeClass("EPHONE");
				$(phNo).addClass("showTip EPHONE");
				phNo.style.color="#f00";
				phNo.style.border="1px solid #f00";
				error=true;
			}
			if (!error) {
				$("#cover").append($("<div>Checking data and sending mail to <b>"+ eMail.value+"</b></div>").css({color:"#fff",margin:"100px 0","font-variant":"small-caps","font-size":"20px"})).show();
				form.submit();
			}
			else {
				$(".form-entry-input").focus(function () {
					$(this).css({border:"0px",color:"#000"});
				});
				$(".form-entry-input").click(function () {
					$(this).removeClass("showTip");
				});
				error=false;
			}
		});
	});
	dw_Tooltip.content_vars={
		EEMAIL:"Invalid Email address",
		ENAME:"Please type your Name",
		ECOLLEGE:"Select Your College",
		EPASS:"Password must have 6-20 characters",
		EREPASS:"Passwords does not match ",
		EPHONE:"Invalid Phone Number",
		ECOLLEGENAME:"You must enter college name"
	};
	var formValidator={
		regMail:"^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\\.([a-zA-Z]{2,4})$",
		regName:"^[a-zA-Z]{2,40}$",
		regPhone:"^[0-9]{10}$",
		regPass:"^[A-Za-z0-9!@#$%^&*()_]{6,20}$",
		regExp:function(ptn,str){
			Exp=new RegExp(ptn);
			if (Exp.test(str)) {
				return true;
			}
			return false;
		},
		isValidEmail:function (email) {
			if (this.regExp(this.regMail,email)) {
				return true;

			}
			return false;
		},
		isValidName:function (uName) {
			if (this.regExp(this.regName,uName)) {
				return true;

			}
			return false;
		},
		isValidPhone:function (uPhone) {
			if (this.regExp(this.regPhone,uPhone)) {
				return true;

			}
			return false;
		}
	};
	function adjust() {
			var wH=$(window).height(),wW=$(window).width();
			if (wW < 800) {
				$("#form-container").css({"min-height":(wH)});
				$("#reg-left").css({"min-width":(wW),height:(wH)});
			}
			else {

				$("#form-container").css({"min-height":(wH)});
				$("#reg-left").css({width:"45%",height:"100%",float:"left"});
			}
	}
	function getId(id) {
		return document.getElementById(id);
	}
</script>
</body>
</html>
<?php

	}
?>
