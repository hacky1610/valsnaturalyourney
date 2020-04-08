	


<?php



require_once('MailChimp.php');
use \DrewM\MailChimp\MailChimp;


/*Queue: automations/4ab952b6e0/emails/4a1e7deda7/queue*/
function AddCustomer($mail,$fname,$lname,$adresse,$codePostal,$ville,$pays,$sendMail,$list,$queue,$thankyou) {
   $MailChimp = new MailChimp('20908b3fa54b62ed523a94cb430eab8f-us13');
   
   
   
   
   $result = $MailChimp->post("lists/" . $list . "/members", [
				'email_address' => $mail,
				'merge_fields' => 
				[
					'FNAME' => $fname,
					'LNAME' => $lname,
					'ADRESSE' => $adresse,
					'CODEPOSTAL' => $codePostal,
					'VILLE' => $ville,
					'PAYS' => $pays
				],
				'status'        => 'subscribed',
			]);
			

		if($sendMail == "true")
		{
			$result = $MailChimp->post($queue, [
					'email_address' => $mail
				]);
				
			if($result["status"] == 400)
			{
				//print_r($result);
			}	
		}
		
		echo "<script>document.location = '" . $thankyou . "';</script>";
}


	
$mail = $_POST["EMAIL"];
$fname = $_POST["FNAME"];
$pays = $_POST["PAYS"];
$lname = $_POST["LNAME"];
$adresse = $_POST["ADRESSE"];
$codePostal = $_POST["CODEPOSTAL"];
$ville = $_POST["VILLE"];

$sendMail = $_POST["SENDMAIL"];
$queue = $_POST["QUEUE"];
$list = $_POST["LIST"];
$thankyou = $_POST["THANKYOU"];

if($pays == "France" || $pays == "Guadeloupe" || $pays == "Guyane" || $pays == "Monaco" || $pays == "Martinique" || $pays == "La Réunion")
{
	AddCustomer($mail,$fname,$lname,$adresse,$codePostal,$ville,$pays,$sendMail,$list,$queue,$thankyou);
}
else
{
	AddCustomer($mail,$fname,$lname,$adresse,$codePostal,$ville,$pays,$sendMail,"3f2a083aef",$queue,$thankyou);
}


	
	
	
		 
		 
?>
