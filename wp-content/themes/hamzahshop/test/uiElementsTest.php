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
    public function setUp(): void
    {
        \WP_Mock::setUp();
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    public function testSharonneAcountButton_UserLoggedIn()
    {
        \WP_Mock::userFunction('wp_logout_url', array(
            'return' => 'http://example.com/foo',
        ));
        \WP_Mock::userFunction('get_permalink', array(
            'return' => 'http://example.com/',
        ));

        \WP_Mock::userFunction('is_user_logged_in', array(
            'times'  => 1,
            'return' => true,
        ));

        \WP_Mock::userFunction('get_site_url', array(
            'times'  => 1,
            'return' => "http:\\www.vals-natural-journey.de",
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';
        (new UiElements())->ShowAccountButton();
        $out = ob_get_contents();

        $this->assertStringContainsString("Mon compte", $out);
    }

    public function testSharonneAcountButton_UserLoggedOff()
    {
        \WP_Mock::userFunction('wp_logout_url', array(
            'return' => 'http://example.com/foo',
        ));
        \WP_Mock::userFunction('get_permalink', array(
            'return' => 'http://example.com/',
        ));

        \WP_Mock::userFunction('is_user_logged_in', array(
            'times'  => 1,
            'return' => false,
        ));
        \WP_Mock::userFunction('get_site_url', array(
            'times'  => 1,
            'return' => "http:\\www.vals-natural-journey.de",
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';
        (new UiElements())->ShowAccountButton();
        $out = ob_get_contents();

        $this->assertStringContainsString("Se connecter", $out);
    }

    public function testGetCourseOverview()
    {
        \WP_Mock::userFunction('get_site_url', array(
            'return' => 'http://example.com',
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';
        $uri = (new UiElements())->getCourseOverViewUri();

        $this->assertStringContainsString("http://example.com/mon-compte/members-area", $uri);
    }

    public function testGetCart()
    {
        \WP_Mock::userFunction('wc_get_cart_url', array(
            'return' => 'http://example.com/cart',
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';
        include_once dirname(__FILE__) . '/mocks/WoocommerceCartMock.php';

        $mock = new WoocommerceCartMock();
        (new UiElements())->getCart($mock);
        $out = ob_get_contents();

        $this->assertStringContainsString("1", $out);
    }

    public function testGetShakeComment_CategorieShake()
    {
        \WP_Mock::userFunction('wc_get_cart_url', array(
            'return' => 'http://example.com/cart',
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';

        $item = [
            'data' => (object) ['category_ids' => array(170, 23)],
        ];
        $cartArray = array($item);

        (new UiElements())->ShowShakeComment($cartArray);
        $out = ob_get_contents();
        print_r($out);

        $this->assertStringContainsString("Vous voulez une dédicace pour votre enfant", $out);
    }

    public function testGetShakeComment_CategorieNotShake()
    {

        \WP_Mock::userFunction('wc_get_cart_url', array(
            'return' => 'http://example.com/cart',
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';

        $item = [
            'data' => (object) ['category_ids' => array(171, 23)],
        ];
        $cartArray = array($item);

        (new UiElements())->ShowShakeComment($cartArray);
        $out = ob_get_contents();

        $this->assertStringNotContainsString("Vous voulez une dédicace pour votre enfant", $out);
    }

    public function testCreateCourseOverview_ButtonEnabled()
    {

        \WP_Mock::userFunction('get_site_url', array(
            'return' => 'http://example.com',
        ));

        \WP_Mock::userFunction('get_page_uri', array(
            'return' => 'helloWorld',
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';

        $start = new DateTime('2020-07-05T08:00:00.012345Z');
        $current = new DateTime('2020-07-25T08:00:00.012345Z');

        $out =(new UiElements())->CreateCourseButton($start,"1","Foo",10,$current);

        $this->assertStringContainsString("http://example.com/helloWorld", $out);
        $this->assertStringNotContainsString("disabled course-button-disabled", $out);
    }

    public function testCreateCourseOverview_ButtonDisabled_6Days2Go()
    {

        \WP_Mock::userFunction('get_site_url', array(
            'return' => 'http://example.com',
        ));

        \WP_Mock::userFunction('get_page_uri', array(
            'return' => 'helloWorld',
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';

        $start = new DateTime('2020-07-05T08:00:00.012345Z');
        $current = new DateTime('2020-07-06T08:00:00.012345Z');

        $out =(new UiElements())->CreateCourseButton($start,"1","Foo",7,$current);

        $this->assertStringContainsString("http://example.com/helloWorld", $out);
        $this->assertStringContainsString("disabled course-button-disabled", $out);
        $this->assertStringContainsString("Disponible en 6 jours", $out);
    }

    public function testCreateCourseOverview_ButtonDisabled_1Day2Go()
    {

        \WP_Mock::userFunction('get_site_url', array(
            'return' => 'http://example.com',
        ));

        \WP_Mock::userFunction('get_page_uri', array(
            'return' => 'helloWorld',
        ));

        include_once dirname(__FILE__) . '/../inc/UiElements.php';

        $start = new DateTime('2020-07-05T08:00:00.012345Z');
        $current = new DateTime('2020-07-11T08:00:00.012345Z');

        $out =(new UiElements())->CreateCourseButton($start,"1","Foo",7,$current);

        $this->assertStringContainsString("http://example.com/helloWorld", $out);
        $this->assertStringContainsString("disabled course-button-disabled", $out);
        $this->assertStringContainsString("Disponible en 1 jours", $out);
    }

}
