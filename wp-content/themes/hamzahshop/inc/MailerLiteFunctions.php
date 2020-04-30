<?php
require_once(__DIR__.'./../vendor/autoload.php');
//https://github.com/mailerlite/mailerlite-api-v2-php-sdk

function GetGroupApi()
{
    $apiKey = "4200099f0fae17e911bfeae9886a6a70";
    return (new \MailerLiteApi\MailerLite($apiKey))->groups();
}

function MyLog($value)
{
    print_r($value);
}

function AddGroup($api,$name)
{ 
    $groups = $api->get();
    if(GroupExist($groups,$name))
    {
        return GetGroupId($groups, $name);
    }
    else
    {
       $res = $api->create(['name' => $name]); 
       return $res->id;
    }

  
}
   

function GroupExist($groups, $name)
{ 
    $id = GetGroupId($groups,$name);
    if($id ==  -1)
    {
        return false;
    }    
    return true;
}

function GetGroupId($groups, $name)
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




function Register($api,$mail,$fname,$pays,$group) {

    $subscriber = [
      'email' => $mail,
      'name' => $fname,
      'fields' => [
        'country' => $pays
      ]
    ];
    
   $api->addSubscriber($group, $subscriber); 
}

function GetGroup($groups,$groupname)
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

function MoveToAllGroup($api)
{
	$groups = $api->get();
    $allGroup = GetGroup($groups,"All");
	$allSubscribers = $api->getSubscribers($allGroup->id,"active");
	
	foreach($groups as $group)
	{
		if($group->name != "All")
		{
			$subscribers = $api->getSubscribers($group->id,"active");
			foreach($subscribers as $subscriber)
			{
				if(HasSubscriber($allSubscribers,$subscriber->id) == false)
				{
					$subscriberBody = [
						'email' => $subscriber->email
					  ];
                     $api->addSubscriber($allGroup->id, $subscriberBody); 
					echo $subscriber->email . "moved <br/>";
				}
			}
		}

	}
}

function RegisterNoCountry($api,$mail,$fname,$group) {

    $subscriber = [
      'email' => $mail,
      'name' => $fname
    ];
    
   return $api->addSubscriber($group, $subscriber); 
}

function HasSubscriber($subscribers,$id)
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

function AddToAll() {

    $subscriber = [
      'email' => $mail,
      'name' => $fname,
      'fields' => [
        'country' => $pays
      ]
    ];
    
   $api->addSubscriber($group, $subscriber); 
}
	
	
	
		 
		 
?>