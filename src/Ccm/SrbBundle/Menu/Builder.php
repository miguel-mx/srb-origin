<?php // src/Ccm/SrbBundle/Menu/Builder.php

namespace Ccm\SrbBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory)
    {

	$menu = $factory->createItem('root');

        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('Inicio', array('route' => 'refs'));
        $menu->addChild('ArXiv', array('route' => 'arxiv'));
        $menu->addChild('Upload', array('route' => 'upload'));
//         $menu->addChild('Login', array('route' => 'login'));


	$menu->setAttribute('class','sf-menu');

	return $menu;

    }
}

