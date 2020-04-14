<?php
require_once 'vendor/autoload.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPUnit\Framework\TestCase;



class WoocommerceTemplateTest extends TestCase
{
    public function setUp(): void {
        \WP_Mock::setUp();
	}


    public function tearDown(): void {
        \WP_Mock::tearDown();
	}

    public function testSingleProduct()
    {
        \WP_Mock::userFunction( 'get_header', array(
			'return' => ''
        ) );
        \WP_Mock::userFunction( 'the_title', array(
			'return' => ''
        ) );

        \WP_Mock::userFunction( 'hamzahshop_key_action_breadcrumb', array(
			'return' => ''
        ) );

        \WP_Mock::userFunction( 'get_theme_mod', array(
			'return' => ''
        ) );

        \WP_Mock::userFunction( 'have_posts', array(
			'return' => false
        ) );
      
        \WP_Mock::userFunction( 'get_footer', array(
			'return' => ''
        ) );
        include_once dirname( __FILE__ ) . '/../woocommerce/single-product.php' ;

        $out = ob_get_contents();

        $this->assertStringContainsString("woocommerce-products-header__title", $out );
        $this->assertStringContainsString("section-page-header", $out );
        
    }


}