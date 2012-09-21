<?php // src/Ccm/SrbBundle/Menu/Builder.php

namespace Ccm\SrbBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory)
    {

        $menu = $factory->createItem('root');

//         $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('Inicio', array('route' => 'index'));
        $menu->addChild('Autores', array('route' => 'author'));
        $menu->addChild('Usuario', array('route' => 'fos_user_profile_show'));
//         $menu->addChild('Login', array('route' => 'login'));


    $menu->setAttribute('class','sf-menu');

    return $menu;

    }
}

