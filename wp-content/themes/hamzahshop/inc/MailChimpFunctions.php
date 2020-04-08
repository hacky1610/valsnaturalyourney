<?php
require_once(__DIR__.'/MailChimp.php');
use \DrewM\MailChimp\MailChimp;

function AddToList($mail, $fname, $pays, $listId)
{
		$MailChimp = new MailChimp('20908b3fa54b62ed523a94cb430eab8f-us13');
	
		$result = $MailChimp->post("lists/". $listId ."/members", [
					'email_address' => $mail,
					'merge_fields' => 
					[
						'FNAME' => $fname,
						'PAYS' => $pays
					],
					'status'        => 'subscribed',
				]);  
		return $result;
	
}

function SendMail($mail, $queue)
{
		$MailChimp = new MailChimp('20908b3fa54b62ed523a94cb430eab8f-us13');
	
		$result = $MailChimp->post($queue, [
					'email_address' => $mail
				]);
		return $result;
	
}