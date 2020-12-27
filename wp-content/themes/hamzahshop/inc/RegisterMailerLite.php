<?php
include_once dirname( __FILE__ ) . '/Mailerlite.php' ;
include_once dirname( __FILE__ ) . '/MailerliteApi.php' ;

	
$mail = $_POST["EMAIL"];
$fname = $_POST["FNAME"];
$pays = $_POST["PAYS"];
$sendMail = $_POST["SENDMAIL"];
$group = $_POST["GROUP"];
$thankyou = $_POST["THANKYOU"];

(new Mailerlite(MailerliteApi::GetApi()))->Register($mail,$fname,$group,$pays);
echo "<script>document.location = '" . $thankyou . "';</script>";
		  
?>
