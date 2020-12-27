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
    
   		return $this->mApi->addSubscriber($group, $subscriber); 
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

	private static function GetGroup($groups,$groupname)
	{
	    $foundGroup = null;
	    foreach($groups as $group)
		{
			if($group->name == $groupname)
			{
				$foundGroup = $group;
			}
	    }

	    if($foundGroup == null)
	    {
	        throw new UnexpectedValueException("Group $groupname was found");
	    }
	    
	    return $foundGroup;
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

	function MoveToAllGroup()
	{
		$this->mApi->limit(5000);

		$groups = $this->mApi->get();
	    $allGroup = Mailerlite::GetGroup($groups,"All");
		$allSubscribers = $this->mApi->getSubscribers($allGroup->id,"active");
		foreach($groups as $group)
		{
			if($group->name != "All")
			{
				$subscribers = $this->mApi->getSubscribers($group->id,"active");

				foreach($subscribers as $subscriber)
				{
					if(Mailerlite::HasSubscriber($allSubscribers,$subscriber->id) == false)
					{
						$subscriberBody = [
							'email' => $subscriber->email
						  ];
	                     $this->mApi->addSubscriber($allGroup->id, $subscriberBody); 
						echo $subscriber->email . "moved <br/>";
					}
				}
			}

		}
	}

	private static function HasSubscriber($subscribers,$id)
	{
	    foreach($subscribers as $s)
	    {
	        if($s->id == $id)
	        {
	            return true;
	        }
	    }
	    return false;
	}
}