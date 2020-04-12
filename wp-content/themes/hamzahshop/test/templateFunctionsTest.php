<?php
require_once 'vendor/autoload.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPUnit\Framework\TestCase;



class LayoutTest extends TestCase
{
    public function testInitLayout()
    {
        \WP_Mock::setUp();
        \WP_Mock::userFunction( 'add_filter', array(
			'args' => array( 'wp_nav_menu_items', 'custom_menu_links', 10, 2 ),
			'times' => 1,
			'return' => 'http://example.com/foo'
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
        $this->assertNotNull("");
    }

}