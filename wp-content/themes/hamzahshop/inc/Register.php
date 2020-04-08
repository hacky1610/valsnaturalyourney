


<?php

require_once('MailChimp.php');
use \DrewM\MailChimp\MailChimp;


/*Queue: automations/4ab952b6e0/emails/4a1e7deda7/queue*/
function Register($mail,$fname,$pays,$sendMail,$list,$queues,$thankyou) {
   $MailChimp = new MailChimp('20908b3fa54b62ed523a94cb430eab8f-us13');
   
   $result = $MailChimp->post("lists/" . $list . "/members", [
				'email_address' => $mail,
				'merge_fields' => 
				[
					'FNAME' => $fname,
					'PAYS' => $pays
				],
				'status'        => 'subscribed',
			]);
			
		if($result["status"] == 400)
		{
			//echo "User is already a member";
		}

		if($sendMail == "true")
		{
			$queueArr = explode(';',$queues);
		
			foreach ($queueArr as &$queue) {
				$result = $MailChimp->post($queue, [
					'email_address' => $mail
				]);
				
				if($result["status"] == 400)
				{
					//print_r($result);
				}	
			 }

		
		}
		
		echo "<script>document.location = '" . $thankyou . "';</script>";
}


	
$mail = $_POST["EMAIL"];
$fname = $_POST["FNAME"];
$pays = $_POST["PAYS"];
$sendMail = $_POST["SENDMAIL"];
$queue = $_POST["QUEUE"];
$list = $_POST["LIST"];
$thankyou = $_POST["THANKYOU"];

Register($mail,$fname,$pays,$sendMail,$list,$queue,$thankyou);
	
	
	
		 
		 
?>
