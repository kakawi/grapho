<?php


namespace CatalogBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/hlebon", name="hlebon-homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('Fuch yeah');
    }
    
    /**
     * @Route("/product/{id}", name="single_product")
     */
    public function getProductAction($id)
    {
        /** @var \CatalogBundle\Entity\Product $product */
        $product = $this->getDoctrine()
            ->getRepository('CatalogBundle:Product')
            ->find($id);

        if(!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return $this->render('CatalogBundle:Product:single_product.html.twig', [
            'product' => $product,
            'title' => $product->getName()
        ]);
    }
}