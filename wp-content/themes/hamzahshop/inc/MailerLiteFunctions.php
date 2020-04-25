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

function RegisterNoCountry($api,$mail,$fname,$group) {

    $subscriber = [
      'email' => $mail,
      'name' => $fname
    ];
    
   $api->addSubscriber($group, $subscriber); 

}
	
	
	
		 
		 
?>