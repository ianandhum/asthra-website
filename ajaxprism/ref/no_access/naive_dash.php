<?php
if(!defined('NAIVE_DASH')){
	exit;
}
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
<title>Dash Board - Asthra 2k18</title>
	<meta  name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"/>
	<meta name="description" content="Add or Remove your events for Asthra 2k18"/>
	<meta name="application-name" content="Dash Board- Asthra 2k18"/>
	<link rel="shortcut icon" href="icon.ico"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<script type="text/javascript" src="assets/script/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/style/dash_board.css"/>
  <link rel="preload" href="assets/img/throbber-full.gif" type="image/gif" as="fetch" />
  <link rel="preload" href="assets/img/checklist.png" type="image/png"  as="fetch" />
  <link rel="preload" href="assets/img/checkerror.png" type="image/png" as="fetch" />
</head>
<body>
<div id="side-panel">
	<div id="home-ico" class="panel-elem"></div>
	<div class="panel-elem" id="panel-events"><div class="panel-ico"></div>Events</div>
	<div class="panel-elem" id="panel-user-events"><div class="panel-ico"></div>Your events</div>
	<div class="panel-elem" id="panel-user-info"><div class="panel-ico"></div>Info</div>
	<div class="panel-elem" id="panel-user-logout"><div class="panel-ico"></div>exit</div>
	<div id="logo"></div>
</div>
<div id="content">
	<div id="home" class="page" style="display: block;">
        <div class="page-slide bt-blue" style="background-color:#0cf" >
					<div class="title-main" >Asthra 2K18 registration

						<div class="title-sub">Hello <i><b><?php echo $user->getUserFullName() ?></b></i></div>
					</div>
        </div>
        <div class="page-slide">
            <div class="left full screen" id="nav-instructions" style="width:100%;margin:0;">
                <div class="head">Instructions</div>
                <div class="cont">
									<div style="font-weight:bold;">Please read these instructions carefully</div>
									<ul type="circle">
										<li>There are team events and solo events</li>
										<li>If you are registering for a team event,  other members of your team should register</li>
										<li>In the venue, College ID card and Permission letter is mandatory</li>
										<li>You cannot edit your personal details</li>
										<li>Once you have understood the terms, click &quot;GOT IT&quot; to select your events</li>
									</ul>
									<div style="font-weight:bold;">Note:This is a one time entry.You cannot enter this page ever again!!!</div>
									</div>
								<div class="left space"><div class="button" id="challenge-bt">GOT IT</div></div>
            </div>
						<h3 class="outline" style="padding:15px;position:relative;height:50px;">OUR SPONSORS</h3>
						<div class="col-3" style="background-image:url('assets/img/sponsor/fp.png');height:100px;"></div>
						<div class="col-3" style="background-image:url('assets/img/sponsor/reji-1.png');height:100px;"></div>
						<div class="col-3" style="background-image:url('assets/img/sponsor/angel.png');height:100px;"></div>
						<div class="col-3" style="background-image:url('assets/img/sponsor/phoebe.png');height:100px;"></div>
						<div class="col-3" style="background-image:url('assets/img/sponsor/spiceinn.png');height:100px;"></div>
						<div class="col-3" style="background-image:url('assets/img/sponsor/cochin.png');height:100px;"></div>
					</div>
		</div>
	<div id="events" class="page" commit="0">

		<h1 class="title">ADD EVENTS</h1>
		<div class="empty-sym"></div>
		<?php
			$notRegEvents=$data->getNotRegEvents();
			if(is_array($notRegEvents)) {
				foreach($notRegEvents as $evnt){
					$dataRow=$data->getUserData($evnt,DATA_DB_EVENT_TABLE);
					if(is_array($dataRow)) {
						echo "<div class=\"event event-short event-perm\" state=\"UNSET\">
									<div class=\"event-img event-perm\" style=\"background-image:url('assets/img/".$eventBg[$dataRow['eventId']]."');\">
										<div class=\"title-small event-perm\">".$dataRow['eventName']."</div>
									</div>
									<div class=\"event-desc event-perm\">".$dataRow['eventDesc']."</div>
									<div class=\"bt bt-green add_event_bt event-perm\" data=\"".$dataRow['eventId']."\">register</div>
								</div>\n";
					}
				}
			}
		?>

	</div>
	<div class="page" id="user-events" commit="0">
		<h1 class="title">YOUR PARTICIPATION</h1>
        <div class="empty-sym"></div>
		<?php
			$regEvents=$data->getRegEvents();
			if(is_array($regEvents)) {
				foreach($regEvents as $evnt){
					$dataRow=$data->getUserData($evnt,DATA_DB_EVENT_TABLE);
					if(is_array($dataRow)) {
						echo "<div class=\"event event-short event-perm\" state=\"SET\">
									<div class=\"event-img event-perm\"  style=\"background-image:url('assets/img/".$eventBg[$dataRow['eventId']]."');\">
										<div class=\"title-small event-perm\">".$dataRow['eventName']."</div>
									</div>
									<div class=\"event-desc event-perm\">".$dataRow['eventDesc']."</div>
									<div class=\"bt bt-red rm_event_bt event-perm\" data=\"".$dataRow['eventId']."\">remove</div>
								</div>\n";
					}
				}
			}
		?>
	</div>
	<div class="page" id="user-info">

		<div class="screen center center-all left">
					<div class="head">Your Details</div>
					<div class="cont">
						<div class="form-text">Note: You cannot edit your details</div>
						<div class="form-entry">
							<div class="form-entry-field">Name</div>
							<div class="form-entry-input"><?php echo $personalInfo['firstName'] ." ". $personalInfo['lastName']  ?></div>
						</div>
						<div class="form-entry">
							<div class="form-entry-field">College</div>
							<div class="form-entry-input"><?php echo $personalInfo['collegeName'] ?></div>
						</div>
						<div class="form-entry">
							<div class="form-entry-field">Phone No</div>
							<div class="form-entry-input"><?php echo $personalInfo['phoneNumber'] ?></div>
						</div>
						<div class="form-entry">
							<div class="form-entry-field">Email</div>
							<div class="form-entry-input"><?php echo $personalInfo['userEmail'] ?></div>
						</div>
						<div class="form-entry">
							<div class="form-entry-field">Accomodation</div>
							<div class="form-entry-input"><?php
							 	if($data->getExtra('acco')=="1"){
									echo "YES";
							 	}
								else{
									echo "NO";
								}
							 ?>
						 </div>
						</div>

					</div>
		</div>

	</div>
</div>
<div id="cover"></div>
<script type="text/javascript" src="assets/script/dash_controller.js"></script>
</body>
</html>
