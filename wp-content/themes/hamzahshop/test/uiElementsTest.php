<?php
require_once 'vendor/autoload.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPUnit\Framework\TestCase;



class UiElementsTest extends TestCase
{
    public function setUp(): void {
        \WP_Mock::setUp();
	}

    public function tearDown(): void {
        \WP_Mock::tearDown();
	}

    public function testSharonneAcountButton_UserLoggedIn()
    {
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

        \WP_Mock::userFunction( 'get_site_url', array(
			'times' => 1,
			'return' => "http:\\www.vals-natural-journey.de"
        ) );
        
    
         \WP_Mock::userFunction( 'getCourseOverViewUri', array(
            'times' => 1,
            'return' => ""
        ) );

        
        include_once dirname( __FILE__ ) . '/../inc/UiElements.php' ;
        (new UiElements())->ShowAccountButton();
        $out = ob_get_contents();

        $this->assertStringContainsString("Mon compte", $out );
    }

    public function testSharonneAcountButton_UserLoggedOff()
    {
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
        \WP_Mock::userFunction( 'get_site_url', array(
			'times' => 1,
			'return' => "http:\\www.vals-natural-journey.de"
        ) );
        

 
         include_once dirname( __FILE__ ) . '/../inc/UiElements.php' ;
        (new UiElements())->ShowAccountButton();
        $out = ob_get_contents();

        $this->assertStringContainsString("Se connecter", $out );

    }

}