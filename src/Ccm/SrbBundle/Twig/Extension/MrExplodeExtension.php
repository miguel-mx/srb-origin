<?php
namespace Ccm\SrbBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

class MrExplodeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'mr' => new \Twig_Filter_Method($this, 'mr', array('is_safe' => array('out'))),
        );
    }

    public function mr($text) {
    $out = explode(" ", $text);

            return $out[0];
    }

    public function getName()
    {
        return 'mr_extension';
    }

}
