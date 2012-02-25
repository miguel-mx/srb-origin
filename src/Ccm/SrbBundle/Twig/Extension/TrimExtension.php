<?php
namespace Ccm\SrbBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

class TrimExtension extends \Twig_Extension
{   
    public function getFilters()
    {
        return array(
            'trim' => new \Twig_Filter_Method($this, 'trim', array('is_safe' => array('out'))),       
        );   
    }

    public function trim($text) {       
	$out = trim($text);
        

	    

            return $out;   
    }

    public function getName()   
    {       
        return 'trim_extension';   
    }

 

}
