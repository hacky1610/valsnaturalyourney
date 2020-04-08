


<?php



require_once('MailChimp.php');
use \DrewM\MailChimp\MailChimp;
	$MailChimp = new MailChimp('20908b3fa54b62ed523a94cb430eab8f-us13');
	$mail = $_POST["EMAIL"];
	$fname = $_POST["FNAME"];
	$pays = $_POST["PAYS"];
	$sendMail = $_POST["SENDMAIL"];
	
	
	$result = $MailChimp->post("lists/522912bcf1/members", [
				'email_address' => $mail,
				'merge_fields' => 
				[
					'FNAME' => $fname,
					'PAYS' => $pays
				],
				'status'        => 'subscribed',
			]);

	
			echo "You are registered";
		
		 
		 

		
?>
