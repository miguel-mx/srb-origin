<?php 
namespace Ccm\SrbBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

class ExplodeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'explode' => new \Twig_Filter_Method($this, 'explode', array('is_safe' => array('out'))),
        );
    }

    public function explode($text) {
            $out = explode(';', $text);

            return $out;
    }

    public function getName()
    {
        return 'explode_extension';
    }

}
