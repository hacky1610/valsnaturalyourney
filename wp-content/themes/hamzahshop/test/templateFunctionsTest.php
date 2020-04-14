<?php
require_once 'vendor/autoload.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPUnit\Framework\TestCase;



class TemplateFunctionsTest extends TestCase
{
    public function tearDown(): void {
		
	}

    public function testSharonneAcountButton_UserLoggedIn()
    {
        \WP_Mock::setUp();
        \WP_Mock::userFunction( 'wp_logout_url', array(
			'return' => 'http://example.com/foo'
        ) );
        \WP_Mock::userFunction( 'get_permalink', array(
			'return' => 'http://example.com/'
        ) );

        \WP_Mock::userFunction( 'is_user_logged_in', array(
			'times' => 1,
			'return' => true
        ) );

        \WP_Mock::userFunction( 'wc_get_account_endpoint_url', array(
			'times' => 1,
			'return' => ""
        ) );
        include_once dirname( __FILE__ ) . '/../inc/template-functions.php' ;
        sharonne_account_button();
        $out = ob_get_contents();

        $this->assertStringContainsString("Mon compte", $out );
        $this->assertStringContainsString("Mon adhésion", $out );
    }

    public function testSharonneAcountButton_UserLoggedOff()
    {
        \WP_Mock::setUp();
        \WP_Mock::userFunction( 'wp_logout_url', array(
			'return' => 'http://example.com/foo'
        ) );
        \WP_Mock::userFunction( 'get_permalink', array(
			'return' => 'http://example.com/'
        ) );

        \WP_Mock::userFunction( 'is_user_logged_in', array(
			'times' => 1,
			'return' => false
        ) );

        \WP_Mock::userFunction( 'wc_get_account_endpoint_url', array(
			'times' => 1,
			'return' => ""
        ) );
        include_once dirname( __FILE__ ) . '/../inc/template-functions.php' ;
        sharonne_account_button();
        $out = ob_get_contents();

        $this->assertStringContainsString("Se connecter", $out );

    }

}