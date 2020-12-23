<?php
  include_once dirname( __FILE__ ) . '/../inc/Mailerlite.php';
  include_once dirname( __FILE__ ) . '/../inc/MailerliteApi.php';

  $api = MailerliteApi::GetApi();
  $id = (new Mailerlite($api))->AddGroup("MyGroup");
  (new Mailerlite($api))->RegisterNoCountry("daniel.hackbarth@siemens.com","Daniel",$id);
