<?php


namespace CatalogBundle\Controller;


use Knp\Menu\FactoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * @Route("/page/{id}", name="page")
     */
    public function getPageAction($id)
    {
        $rep = $this->getDoctrine()->getRepository('CatalogBundle:Page');
        $page = $rep->find($id);

        if(!$page) {
            throw $this->createNotFoundException(
                'No page found for id ' . $id
            );
        }

        return $this->render('CatalogBundle:Page:single_page.html.twig', [
            'page' => $page,
            'title' => $page->getName()
        ]);
    }
}