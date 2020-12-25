<?php
require_once 'vendor/autoload.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPUnit\Framework\TestCase;



class MailerliteTest extends TestCase
{
    private $mailerliteAPi;
    public function setUp(): void {
        \WP_Mock::setUp();
        include_once dirname( __FILE__ ) . '/mocks/MailerliteMock.php' ;
        include_once dirname( __FILE__ ) . '/../inc/Mailerlite.php' ;
	}

    public function tearDown(): void {
        \WP_Mock::tearDown();
	}

    public function testRegisterNoCountry()
    {
        $retVal = (object) ['id' => '43'];
        $mocky =  $this->createMock(MailerliteMock::class);
        $mocky->method('addSubscriber')
            ->willReturn($retVal);
        $res = (new Mailerlite($mocky))->Register("danie.h","Daniel","MyGroup");
        $this->assertEquals("43", $res->id );
    }

    public function testRegisterWithCountry()
    {
        $retVal = (object) ['id' => '43'];
        $mocky =  $this->createMock(MailerliteMock::class);
        $mocky->method('addSubscriber')
            ->willReturn($retVal);
        $res = (new Mailerlite($mocky))->Register("danie.h","Daniel","MyGroup","Germany");
        $this->assertEquals("43", $res->id );
    }


    public function testAddGroup()
    {
        $mocky =  $this->createMock(MailerliteMock::class);
        $mocky->method('get')
            ->willReturn(array());

        $retVal = (object) ['id' => '43'];
        
        $mocky->method('create')
            ->willReturn($retVal);

        $id = (new Mailerlite($mocky))->AddGroup("MyGroup");
          $this->assertStringContainsString("43", $id );
    }


}