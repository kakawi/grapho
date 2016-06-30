<?php


namespace CatalogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        $rep = $this->getDoctrine()->getRepository('CatalogBundle:Product');
        /** @var \CatalogBundle\Entity\Product $products */
        $query = $rep->createQueryBuilder('p')
            ->where('p.inFrontPage = 1')
            ->getQuery();

        $products = $query->getResult();

        $rep = $this->getDoctrine()->getRepository('CatalogBundle:Page');
        $query = $rep->createQueryBuilder('p')
            ->where('p.isMainPage = 1')
            ->getQuery();

        $mainPageDescription = $query->getSingleResult();

        return $this->render("CatalogBundle:Main:homepage.html.twig", [
                'products' => $products,
                'mainPage' => $mainPageDescription,
                'title' => 'Главная'
            ]);
    }
}