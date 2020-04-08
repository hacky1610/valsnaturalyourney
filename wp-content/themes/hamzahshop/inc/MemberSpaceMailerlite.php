<?php
require_once(__DIR__.'/MailerLiteFunctions.php');

$mail = $_POST['email'];
$fName = $_POST['firstName'];
$groupName = $_POST['groupName'];

if(empty($mail))
    return;

$api = GetGroupApi();
$id = AddGroup($api,$groupName);
RegisterNoCountry($api,$mail,$fName,$id);
	
		 
		 
?>