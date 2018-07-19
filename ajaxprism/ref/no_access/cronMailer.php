<?php
require_once("../../config/Register.class.php");
  $collegeName="";
  $counter=fopen("cronCounter.txt","r");
  $mailer=new Register();
  $ptr=(int)fgets($counter);
  fclose($counter);
  if($ptr!=-1){
    $document=new DOMDocument();
    $document->load("mailer.xml");
    $colleges=$document->getElementsByTagName('col');
    $cols=$document->getElementsByTagName('name');
    $mails=$document->getElementsByTagName('mail');
    if($ptr<$cols->length){
      $item=$colleges->item($ptr);
      $collegeName=$cols->item($ptr)->textContent;
      $mail=$mails->item($ptr)->textContent;
      include("mailContent.php");
      if($mailer->sendMail(trim($mail),$InvitationMail,"Invitation | Technical Fest Asthra 2K18 | MES College Nedumkandam")){
      	    echo "Mail was sent to &lt;".$mail."&gt;";
            
      }
      else{
	echo "error sending mail....";
	echo $mailer->lastError;
      }
      $counter=fopen("cronCounter.txt","w");
      fwrite($counter,$ptr+1);
      fclose($counter);

    }
    else{
      echo "Out of entry";
      $ptr=-1;
    }
  }

?>
