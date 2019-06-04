<?php


namespace Tests\AppBundle\Controller;

use AppBundle\Entity\One;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use JMS\Serializer\SerializerBuilder;

class OneControllerTest extends WebTestCase
{
    const RUTA_API1 = 'api/v1/one';
   public function testCreateOne(){
       $data = array(
           'CONTENT_TYPE' => 'application/json'
       );
       $client = static::createClient();
       $one=new One();
       $one->setName("example");
       $serializer = SerializerBuilder::create()->build();
       $content=$serializer->serialize($one,"json");
       $client->request('POST', self::RUTA_API1,array(),array(), $data,$content);
       $response = $client->getResponse();
       $this->assertEquals(201, $client->getResponse()->getStatusCode());
   }

    public function testListOneById(){
        $client= static::createClient();
        $crawler = $client->request('GET', self::RUTA_API1."/5");
        $respose = $client->getResponse();
        $this->assertEquals('{"name":"example","id":5}', $client->getResponse()->getContent());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());
    }
    public function testListAllOne(){
        $client= static::createClient();
        $crawler = $client->request('GET', self::RUTA_API1);
        $respose = $client->getResponse();
        $this->assertEquals('[{"name":"test","id":1},{"name":"test","id":2},{"name":"test","id":3},{"name":"test","id":4}]', $client->getResponse()->getContent());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());
    }


}