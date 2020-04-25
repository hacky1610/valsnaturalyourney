<?php
require_once(__DIR__.'/MailerLiteFunctions.php');

if(array_key_exists('email', $_POST))
{
    $mail = $_POST['email'];
    $fName = $_POST['firstName'];
    $groupName = $_POST['groupName'];
    
    $api = GetGroupApi();
    $id = AddGroup($api,$groupName);
    RegisterNoCountry($api,$mail,$fName,$id);
}



		 
		 
?>