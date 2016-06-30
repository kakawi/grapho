<?php


namespace CatalogBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getTopMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
//        $menu->addChild('Home', array('route' => 'homepage'));
        $repository = $this->container->get('doctrine')->getRepository('CatalogBundle:Page');
        $query = $repository->createQueryBuilder('p')
            ->where('p.isMainPage != 1')
            ->orderBy('p.weight', 'ASC')
            ->getQuery();

        $pages = $query->getResult();

        foreach ($pages as $page) {
            if($page->getName() === 'Цены') {
                $menu->addChild($page->getName(), array(
                    'route' => 'get_price',
                ));
            } else {
                $menu->addChild($page->getName(), array(
                    'route' => 'page',
                    'routeParameters' => ['id' => $page->getId()]
                ));
            }
        }

        return $menu;
    }
}