<?php
require_once 'vendor/autoload.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPUnit\Framework\TestCase;

class wooTemplateTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    public function testSingleProductTemplate()
    {
        \WP_Mock::userFunction('get_header', array(
            'return' => 'foo',
        ));

        \WP_Mock::userFunction('get_theme_mod', array(
            'return' => 'normal',
        ));

        \WP_Mock::userFunction('have_posts', array(
            'return' => false,
        ));

        \WP_Mock::userFunction('the_post', array(
            'return' => 'normal',
        ));

        \WP_Mock::userFunction('wc_get_template_part', array(
            'return' => 'normal',
        ));

        \WP_Mock::userFunction('do_action', array(
            'return' => 'normal',
        ));

        \WP_Mock::userFunction('get_footer', array(
            'return' => 'normal',
        ));
        include_once dirname(__FILE__) . '/../woocommerce/single-product.php';
        $out = ob_get_contents();

        $this->assertStringContainsString("content-area blog-page-area details-page", $out);
    }

}
