<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root')->setChildrenAttribute('class', 'main_menu');

        $menu->addChild('sip_resource_events',
            array(
                'route' => 'sip_resource_events'
            )
        )->setLinkAttribute('class', 'menu_link')->setAttribute('class', 'menu_item');

        $menu->addChild('sip_resource_designers',
            array(
                'route' => 'sip_resource_designers'
            )
        )->setLinkAttribute('class', 'menu_link')->setAttribute('class', 'menu_item');

        $menu->addChild('sip_resource_manufacturers',
            array(
                'route' => 'sip_resource_manufacturers'
            )
        )->setLinkAttribute('class', 'menu_link')->setAttribute('class', 'menu_item');

        $menu->addChild('sip_resource_news',
            array(
                'route' => 'sip_resource_news'
            )
        )->setLinkAttribute('class', 'menu_link')->setAttribute('class', 'menu_item');

        $menu->addChild('sip_resource_publishing',
            array(
                'route' => 'sip_resource_publishing'
            )
        )->setLinkAttribute('class', 'menu_link')->setAttribute('class', 'menu_item');

        $menu->addChild('sip_resource_support_measures',
            array(
                'route'           => 'sip_staic_pages',
                'routeParameters' => array('slug' => 'support-measures'),
            )
        )->setLinkAttribute('class', 'menu_link')->setAttribute('class', 'menu_item');

        $forum = $menu->addChild('sip_nashaforma')
        ->setLinkAttribute('class', 'menu_link')->setAttribute('class', 'menu_item');
        $forum->setUri('http://www.nashaforma.ru');

        return $menu;
    }

    /**
     * @param \Knp\Menu\ItemInterface $item
     * @return bool|null
     */
    public function isCurrent(\Knp\Menu\ItemInterface $item)
    {
        /** @var \Symfony\Component\HttpFoundation\Request $request*/
        $request = $this->container->get('request');

        $regexp = str_replace('/', '\/', $item->getUri());
        if (preg_match("/^{$regexp}/", "{$request->getBaseUrl()}{$request->getPathInfo()}")) {
            return true;
        }

        return null;
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->container->get('security.context');
    }
}