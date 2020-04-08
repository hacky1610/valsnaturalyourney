<?php


function NewCustomerOrBuy($pays, $registerSite, $buySite) {
	
	$openSite = "";
	if($pays == "France" || $pays == "Guadeloupe" || $pays == "Guyane" || $pays == "Monaco" || $pays == "Martinique" || $pays == "La Réunion")
	{
		$openSite = "$registerSite?PAYS=$pays" ;
	}
	else
	{
		$openSite = $buySite;
	}
   
	echo "<script>document.location = '" . $openSite . "';</script>";
	#echo $openSite;
		
	
}


$pays = $_POST["PAYS"];

NewCustomerOrBuy($pays, "https://vals-natural-journey.de/forever-register","https://vals-natural-journey.de/forever-wellcome-international");