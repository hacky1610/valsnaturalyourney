<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mailerlite {

	private $mApi;
    function __construct($api){
        $this->mApi = $api;
    }

    function Register($mail,$fname,$group,$country = NULL) {

    	if($country == NULL)
    	{
	    	$subscriber = [
	      	'email' => $mail,
	      	'name' => $fname
	    	];
	    }
	    else
	    {
	    	  $subscriber = [
		      'email' => $mail,
		      'name' => $fname,
		      'fields' => [
		        'country' => $country
		      ]
		    ];
	    }
    
   		$ret =  $this->mApi->addSubscriber($group, $subscriber); 
   		 error_log(print_r($ret, true));
	}

	function AddGroup($name)
	{ 
	    $groups = $this->mApi->get();
	    if(Mailerlite::GroupExist($groups,$name))
	    {
	        return Mailerlite::GetGroupId($groups, $name);
	    }
	    else
	    {
	       $res = $this->mApi->create(['name' => $name]); 
	       return $res->id;
	    }  
	}

	public static function GroupExist($groups, $name)
	{ 
	    $id = Mailerlite::GetGroupId($groups,$name);
	    if($id ==  -1)
	    {
	        return false;
	    }    
	    return true;
	}

	public static function GetGroupId($groups, $name)
	{ 
	    foreach ($groups as $group)
	    {
	        if($group->name ===  $name)
	        {
	            return $group->id;
	        }
	    }
	    return -1;
	}

	function NewMembership($plan, $args)
	{
		#Create group in Mailerlite and add user 
		$user = get_userdata($args["user_id"]);
		$membershipName = $plan->name;

		$groupName = "Membership: $membershipName";
		$id = $this->AddGroup($groupName);

		return $this->Register($user->user_email, $user->display_name, $id);
	}

	function OrderCompleted($id)
	{
		$order = wc_get_order($id);
		if ($order) {
			$user = $order->get_user();
			$fname = $order->get_billing_first_name();
			$country = $order->get_billing_country();
			$items = $order->get_items();
			foreach ($items as $item) {
				$prodName =  $item->get_name();
				preg_match('/(.+) \(\d+\)/', $prodName, $matches, PREG_OFFSET_CAPTURE);
				if (count($matches) > 0) {
					$prodName = $matches[1][0];
				}

				$groupName = "Customer: $prodName";
				$id = $this->AddGroup($groupName);
				$this->Register($order->get_billing_email(), $fname, $id,$country);
			}
		}
	}
}