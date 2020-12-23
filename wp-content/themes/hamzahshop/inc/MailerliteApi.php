<?php
require_once(__DIR__.'./../vendor/autoload.php');
//https://github.com/mailerlite/mailerlite-api-v2-php-sdk

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MailerliteApi {

    function __construct(){
    }

    static function GetApi() {
    	 $apiKey = "4200099f0fae17e911bfeae9886a6a70";
    	return (new \MailerLiteApi\MailerLite($apiKey))->groups(); 
	}
}