<?php
//BUG:client:image %F cannot be displayed because it contains errors:
//STATUS:not-resolved
exit;
	require("../../config/Media.class.php");
	$media=new Media();
	$data=$media->getResourceData("id124");
	if ($data!=FALSE) {
		// open the file in a binary mode
		$name =$data['path'];
		$fp = fopen($name, 'rb');

		// send the right headers
		header("Content-Type: image/png");
		// dump the picture and stop the script
		fpassthru($fp);
		exit;
	}
?>