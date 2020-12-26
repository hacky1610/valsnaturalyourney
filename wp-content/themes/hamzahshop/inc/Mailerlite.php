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
		print_r($this->mApi);
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
}