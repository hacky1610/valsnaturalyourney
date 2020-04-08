<?php

function HttpGet($url)
{
$curl = curl_init( $url);
$response = curl_exec( $curl );
curl_close( $curl );
return $response;
}

function GetProduct($id)
{	
	$website = "https://vals-natural-journey.de";	
	$consumerkey = "ck_e3b74a274632a79a51f2e92809c392a30b7e8266";
	$consumerSecret = "cs_fa92ad1ba2a3742e8ee3fa72161e650e871ee069";

	$request = "$website/wp-json/wc/v2/products/$id?consumer_key=$consumerkey&consumer_secret=$consumerSecret";
	$response = HttpGet($request);
	
	return  json_decode($response);	
}


function IsDebug()
{
	 /*$user = wp_get_current_user();
	 if ($user->user_login == "daniel")
	 {
		 return true;
	 }*/
	 return false;
}
function WriteDebug($text)
{
	//return;
	
	$now = new DateTime();
	$currTime = $now->format('Y-m-d H:i:s');
	$myfile = fopen("vnj_log.txt", "a+") or die("Unable to open file!");
	$txt = "$currTime - $text\n";
	fwrite($myfile, $txt);
	fclose($myfile);
}


function getLastOrder()
{
	
	$response = HttpGet( 'https://vals-natural-journey.de/wp-json/wc/v1/orders?consumer_key=ck_e3b74a274632a79a51f2e92809c392a30b7e8266&consumer_secret=cs_fa92ad1ba2a3742e8ee3fa72161e650e871ee069' );
	if ( is_array( $response ) ) 
	{
		$allOrders = (array) json_decode($response);
		return $allOrders[rand(0, 1)];
	}
	return null;
}

function getAllReviews($id)
{
	$response = HttpGet( 'https://vals-natural-journey.de/wp-json/wc/v2/products/' . $id . '/reviews?consumer_key=ck_e3b74a274632a79a51f2e92809c392a30b7e8266&consumer_secret=cs_fa92ad1ba2a3742e8ee3fa72161e650e871ee069' );
	if ( is_array( $response ) ) 
	{
		return (array) json_decode($response);
	}
	return array();
}

function getLastReview($id)
{
	$allReviews = getAllReviews($id);
		
	if(count($allReviews) > 0)
	{
		for ($i = count($allReviews) -1; $i > 0; $i--) 
		{
			$newestReview =  $allReviews[$i];
			#if($newestReview->verified) # Geht leider nicht
			#{
				return $newestReview;
			#}
		
		}
	}
	return null;
}


function ShowReview()
{
	StartSession();
	
	if(!IsDebug())
	{
		
		$key = "vnj_shown_review";
		$shownReview = $_SESSION[$key];
		#Wenn das Notify schon mal angezeigt wurde, wird es nicht wieder dargestellt
		if(!empty($shownReview)) 
		{
			return;
		}
		$_SESSION[$key] = "Shown";
	}
	
	$product = GetProduct(512);
	
    $lastReview = getLastReview($product->id);
	if($lastReview != null)
	{
	
		$name =  $lastReview->name;  
		$rating = $lastReview->rating;
		$name[0] = strtoupper($name[0]);
		$message = "Note de $rating étoiles par $name, ";
		
		WriteDebug("Show Review from $name");

		$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if (strcasecmp($actual_link, $product->permalink) == 0) {
			echo "<script>
			ShowReviewPopupSameSite('" . $product->name .  "','" . $message . "','" . $product->images[0]->src . "');
			</script>";
		}
		else
		{
			echo "<script>
			ShowReviewPopup('" . $product->name .  "','" . $message . "','" . $product->images[0]->src . "','" . $product->permalink . "');
			</script>";
		}	
	}
}

function GetOrderMessage($name, $country, $diff_formated)
{
	$pattern = '/^[AEIOU]/';
	if(preg_match($pattern, $country))
	{
		return "$name d\'$country a acheté ce produit il y a $diff_formated";
	}
	else
	{
		return "$name de $country a acheté ce produit il y a $diff_formated";
	}	
}

function GetCountryList()
{
	echo "Foo";
	$c = WC()->countries;
	echo "Bla";
}

function StartSession()
{
	session_start();
	$now = new DateTime();
	if(!empty($_SESSION["vnj_started"]))
	{
		WriteDebug("Session was started");
	
		$started = $_SESSION["vnj_started"];
		WriteDebug("Started: $started");
		$startedDate = new DateTime($started);
		$diff = $startedDate->diff($now);
		$diffMinutes = $diff->h * 60 + $diff->i;
		WriteDebug("Minutes: $diffMinutes");
		if($diffMinutes > 15)
		{
			WriteDebug("Destroy Session");
			session_destroy();
			session_start();
			$_SESSION["vnj_started"] = $now->format('Y-m-d H:i:s');	
		}
	}
	else
	{
		WriteDebug("New Session");
		$_SESSION["vnj_started"] = $now->format('Y-m-d H:i:s');
	}
}

function ShowOrders()
{
	WriteDebug("ShowOrders start");
	StartSession();
	echo "W1";
	return "Foo";
		
	if(!IsDebug())
	{
		$key = "vnj_shown_orders";
		
		$shownOrder = $_SESSION[$key];
		#Wenn das Notify schon mal angezeigt wurde, wird es nicht wieder dargestellt
		
		if(!empty($shownOrder)) 
		{
			WriteDebug("Orders were shown");
			return;
		}
		$_SESSION[$key] = "Shown";
	}
	
	$newestOrder = getLastOrder();
	WriteDebug("Last order recieved");
	$newestDate = new DateTime($newestOrder->date_created);
	$product = GetProduct($newestOrder->line_items[0]->product_id);
	$image  = $product->images[0]->src;
	$now = new DateTime();
	$country =  WC()->countries->countries[$newestOrder->billing->country];
	$name =  $newestOrder->billing->first_name;  
	$name[0] = strtoupper($name[0]);
	$diff = $newestDate->diff($now);
	
	
	$diffHours = $diff->d * 24 + $diff->h;
	if($diffHours <= 24) #weniger als 24 stunden
	{
		if($diffHours <= 1) #weniger als eine Stunde
			$diff_formated = $diff->i . " minutes";
		else #zwischen einer und 24 Stunden
			$diff_formated = "$diffHours heures";
	}
	elseif($diffHours <= 48)
		$diff_formated = $diff->d . " jour";
	else
		$diff_formated = $diff->d . " jours";
	
	$message = GetOrderMessage($name,$country,$diff_formated );
	
	//Bei mehr als 4 Tagen -> Wolfgang aus Deutschland hat das Produkt kürzlich gekauft
	if($diffHours > 96)
	{
		$message = "$name de $country a récemment acheté ce produit";
	}

	echo "<script>
	ShowOrderPopup('" . $product->name . "','" . $message . "','" . $image  . "','" . $product->permalink . "');
	</script>";
	return;
}

$func = $_REQUEST["func"];
if ($func !== "") {
	ShowOrders();
}


