<?php
require './../vendor/autoload.php';



function Register($mail,$fname,$pays,$sendMail,$group,$thankyou) {
     $groupsApi = (new \MailerLiteApi\MailerLite('4200099f0fae17e911bfeae9886a6a70'))->groups();

    $subscriber = [
      'email' => $mail,
      'name' => $fname,
      'fields' => [
        'country' => $pays
      ]
    ];
    
    $addedSubscriber = $groupsApi->addSubscriber($group, $subscriber); // returns added subscriber
	//print_r($addedSubscriber);	
	echo "<script>document.location = '" . $thankyou . "';</script>";
}


	
$mail = $_POST["EMAIL"];
$fname = $_POST["FNAME"];
$pays = $_POST["PAYS"];
$sendMail = $_POST["SENDMAIL"];
$group = $_POST["GROUP"];
$thankyou = $_POST["THANKYOU"];

Register($mail,$fname,$pays,$sendMail,$group,$thankyou);
	
	
	
		 
		 
?>
