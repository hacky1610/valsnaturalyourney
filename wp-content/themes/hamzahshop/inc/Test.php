

<?php	
require_once(__DIR__.'/MailerLiteFunctions.php');
    
	$api = GetGroupApi();
	$api->limit(5000);
	
	MoveToAllGroup($api);


?>



