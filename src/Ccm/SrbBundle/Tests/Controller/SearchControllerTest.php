<?php
// src/Ccm/SrbBundle/Tests/Util/SimplePieTest.php
namespace Ccm\SrbBundle\Tests\Controller;

class SearchTest extends \PHPUnit_Framework_TestCase
{
    public function testSearch()
    {

      $finder = $this->get('foq_elastica.finder.srb.Referencia');
      $referencias = $finder->find('title:derived', 10);
           
      //$this->assertEquals('', $addarray['title']);
      $this->assertCount(1, $referencias);
      $this->assertArrayHasKey('author', $referencias[1]);
    }

}