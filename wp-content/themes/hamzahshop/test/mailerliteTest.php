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


    public function testAddGroup_GroupDontExist()
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

    public function testAddGroup_GroupExist()
    {
        $mocky =  $this->createMock(MailerliteMock::class);
        $mocky->method('get')
            ->willReturn(array((object) ['id' => '43','name' => "MyGroup"]));

        $id = (new Mailerlite($mocky))->AddGroup("MyGroup");
          $this->assertStringContainsString("43", $id );
    }

    public function testNewMembership()
    {
        \WP_Mock::userFunction( 'get_userdata', array(
            'return' => (object) ['user_email' => 'danie.h','display_name' => 'daniel']
        ) );

        $mocky =  $this->createMock(MailerliteMock::class);
        $mocky->method('get')
            ->willReturn(array((object) ['id' => '43','name' => "MyGroup"]));
        $retValUser = (object) ['id' => '43'];
        $retValGroup = (object) ['id' => '42'];
        $mocky->method('addSubscriber')
            ->willReturn($retValUser);

          $mocky->method('create')
            ->willReturn($retValGroup);

        $plan = (object) ['name' => "MyPlan"];
        $args = Array('user_id'=>"1");

        $res = (new Mailerlite($mocky))->NewMembership($plan,$args);
        $this->assertEquals("43", $res->id );
    }

    function testMoveToAllGroup_addOneSubscriber()
    {

        $mocky = $this->getMockBuilder(stdClass::class)
                     ->setMethods(['limit','get','getSubscribers','addSubscriber'])
                     ->getMock();
        $mocky->method('limit');
        $mocky->method('get')->willReturn(array((object) ['id' => '1','name' => "All"],(object) ['id' => '2','name' => "MyGroup"]));
        $mocky->expects($this->at(2))
            ->method('getSubscribers')
            ->with($this->equalTo('1'),$this->equalTo('active'))
            ->willReturn(array((object) ['id' => '11','name' => "Daniel", 'email'=>'daniel.h']));
         $mocky
            ->expects($this->at(3))
            ->method('getSubscribers')
            ->with($this->equalTo('2'),$this->equalTo('active'))
            ->willReturn(array((object) ['id' => '22','name' => "Valerie",'email'=>'valerie.h']));
        $mocky
            ->expects($this->once()) 
            ->method('addSubscriber')
            ->with($this->equalTo('1'));
        (new Mailerlite($mocky))->MoveToAllGroup();
    }

     function testMoveToAllGroup_addTwoSubscriber()
    {

        $mocky = $this->getMockBuilder(stdClass::class)
                     ->setMethods(['limit','get','getSubscribers','addSubscriber'])
                     ->getMock();
        $mocky->method('limit');
        $mocky->method('get')->willReturn(array((object) ['id' => '1','name' => "All"],(object) ['id' => '2','name' => "MyGroup"]));
        $mocky->expects($this->at(2))
            ->method('getSubscribers')
            ->with($this->equalTo('1'),$this->equalTo('active'))
            ->willReturn(array((object) ['id' => '11','name' => "Daniel", 'email'=>'daniel.h']));
         $mocky
            ->expects($this->at(3))
            ->method('getSubscribers')
            ->with($this->equalTo('2'),$this->equalTo('active'))
            ->willReturn(array((object) ['id' => '22','name' => "Valerie",'email'=>'valerie.h'],(object) ['id' => '33','name' => "Sandrine",'email'=>'valerie.h']));
        $mocky
            ->expects($this->exactly(2)) 
            ->method('addSubscriber');
        (new Mailerlite($mocky))->MoveToAllGroup();
    }

    function testMoveToAllGroup_subscriberExist()
    {

        $mocky = $this->getMockBuilder(stdClass::class)
                     ->setMethods(['limit','get','getSubscribers','addSubscriber'])
                     ->getMock();
        $mocky->method('limit');
        $mocky->method('get')->willReturn(array((object) ['id' => '1','name' => "All"],(object) ['id' => '2','name' => "MyGroup"]));
        $mocky->expects($this->at(2))
            ->method('getSubscribers')
            ->with($this->equalTo('1'),$this->equalTo('active'))
            ->willReturn(array((object) ['id' => '11','name' => "Daniel", 'email'=>'daniel.h']));
         $mocky
            ->expects($this->at(3))
            ->method('getSubscribers')
            ->with($this->equalTo('2'),$this->equalTo('active'))
            ->willReturn(array((object) ['id' => '11','name' => "Daniel",'email'=>'daniel.h']));
        $mocky
            ->expects($this->never()) 
            ->method('addSubscriber');
        (new Mailerlite($mocky))->MoveToAllGroup();
    }





}