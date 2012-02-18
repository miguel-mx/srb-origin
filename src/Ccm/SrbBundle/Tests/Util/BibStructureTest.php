<?php
// src/Ccm/SrbBundle/Tests/Util/SimplePieTest.php

namespace Ccm\SrbBundle\Tests\Util;

use Ccm\SrbBundle\Util\Structures_BibTex;
use Ccm\SrbBundle\Util\PEAR;


class BibStructureTest extends \PHPUnit_Framework_TestCase
{
    public function testBibStruct()
    {
	$bibtexstruct = new Structures_BibTex();
	
	
	$bibtexstruct->loadFile('/home/lugetego/Downloads/science.bib');
	$bibtexstruct->parse();
	$bibTex = $bibtexstruct->data;


     for($i=0; $i<count($bibTex); $i++) {
        for($j=0;$j<count($bibTex[$i]['author']);$j++){

            $tmpFirst=$bibTex[$i]['author'][$j]['first'];

	    $this->assertEmpty($bibTex[$i]['author'][$j]['first']);
	    $this->assertEmpty($bibTex[$i]['author'][$j]['von']);
	    $this->assertEquals('Gerardo Tejero', $bibTex[$i]['author'][$j]['last']);
	    

            if(array_key_exists('von',$bibTex[$i]['author'][$j])) {
            $authorVon=$bibTex[$i]['author'][$j]['von'];
            }

            $tmpLast=$bibTex[$i]['author'][$j]['last'];

            if(array_key_exists('jr',$bibTex[$i]['author'][$j])) {
              $authorJr=$bibTex[$i]['author'][$j]['jr'];
            }

            if(count($bibTex[$i]['author'])>1){
                if($j==0)
                    $authorLast=$tmpLast." ".$authorVon." ".$tmpFirst;
                if($j>0)
                    $authorLast=$authorLast."; ".$authorVon." ".$tmpLast." ".$tmpFirst;
            }
            else {
                $authorLast=$tmpLast." ".$tmpFirst;
            }
        }
    }

    $numrefs=count($bibTex);
    $this->assertEquals(1, $numrefs);



    }

}