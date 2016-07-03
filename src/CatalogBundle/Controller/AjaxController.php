<?php
namespace CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends Controller {
    /**
     * @Route("/ajax/", name="ajax_homepage")
     */
    public function homepageAction()
    {
        $content = $this->getHomepage();

        return $this->render("CatalogBundle:Ajax:homepage.html.twig", [
            'home_content' => $content['text'],
            'title' => 'Главная'
        ]);
    }

    /**
     * @Route("/", name="ajax_require_homepage")
     */
    public function homepageRequireJSAction()
    {
        $content = $this->getHomepage();

        return $this->render("CatalogBundle:Ajax:homepage.require.twig", [
            'home_content' => $content['text'],
            'title' => 'Главная'
        ]);
    }

    /**
     * @Route("/ajax/page", name="ajax_page")
     */
    public function getAjaxNavAction() {
        $repository = $this->container->get('doctrine')->getRepository('CatalogBundle:Page');
        $query = $repository->createQueryBuilder('p')
            ->where('p.isMainPage != 1')
            ->orderBy('p.weight', 'ASC')
            ->getQuery();

        $pages = $query->getResult();

        $menu = array();
        $i = 0;
        foreach ($pages as $page) {
            if($page->getName() === "Цены") {
                $menu[$i]['url'] = "/price";
            }
            $menu[$i]['name'] = $page->getName();
            $menu[$i]['id'] = $page->getId();
            $i++;
        }

        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($menu, 'json');

        return new Response($reports);
    }

    private function getPage($id){
        $repository = $this->getDoctrine()->getRepository('CatalogBundle:Page');

        $page = $repository->find($id);

        if(!$page) {
            throw $this->createNotFoundException(
                'No page found for id ' . $id
            );
        }

        $content['id'] = $page->getId();
        $content['source'] = 'page';
        $content['name'] = $page->getName();
        $content['text'] = $page->getPageText();

        return $content;
    }

    private function getCategory($id) {
        $repository = $this->getDoctrine()->getRepository('CatalogBundle:Category');

        $category = $repository->find($id);
        $content['id'] = $category->getId();
        $content['source'] = 'category';
        $content['name'] = $category->getName();
//         = $category->getDescription();

        $content['text'] = $this->get('twig')->render(
            "CatalogBundle:Ajax:single_category.ajax.twig", [
                'category' => $category,
            ]
        );

        return $content;
    }

    private function getProduct($id){
        $repository = $this->getDoctrine()->getRepository('CatalogBundle:Product');

        $product = $repository->find($id);

        if(!$product) {
            throw $this->createNotFoundException(
                'No page found for id ' . $id
            );
        }

        $content['id'] = $product->getId();
        $content['source'] = 'product';
        $content['name'] = $product->getName();
        $content['text'] = $this->get('twig')->render(
            "CatalogBundle:Ajax:single_product.ajax.twig", [
                'product' => $product,
            ]
        );

        return $content;
    }

    private function getHomepage(){
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

        $content['text'] = $this->get('twig')->render("CatalogBundle:Ajax:homepage.ajax.twig", [
            'products' => $products,
            'mainPage' => $mainPageDescription,
        ]);
        $content['source'] = 'homepage';
        $content['name'] = 'Главная';

        return $content;
    }

    /**
     * @Route("/ajax/content/{id}", name="ajax_content")
     */
    public function getAjaxContentAction($id, Request $request) {
        $source = $request->query->get("source");

        $content = "";
        switch ($source) {
            case 'page':
                $content = $this->getPage($id);
                break;
            case 'category':
                $content = $this->getCategory($id);
                break;
            case 'product':
                $content = $this->getProduct($id);
                break;
            case 'homepage':
                $content = $this->getHomepage();
                break;
        }

//        $serializer = $this->container->get('serializer');
//        $reports = $serializer->serialize($content, 'json');

        $json = json_encode($content);
        return new Response($json);
    }

    /**
     * @Route("/ajax/sidebar", name="ajax_sidebar")
     */
    public function getAjaxSidebarAction() {
        $rep = $this->getDoctrine()->getRepository('CatalogBundle:Category');
        $categories = $rep->findAll();

        $sidebar = array();
        $i = 0;
        foreach ($categories as $category) {
            $sidebar[$i]['name'] = $category->getName();
            $sidebar[$i]['id'] = $category->getId();
            $sidebar[$i]['products'] = array();
            if(!empty($products = $category->getProducts())) {
                $j = 0;
                foreach ($products as $product) {
                    $sidebar[$i]['products'][$j]['id'] = $product->getId();
                    $sidebar[$i]['products'][$j]['name'] = $product->getName();
                    $j++;
                }
            }
            $i++;
        }

        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($sidebar, 'json');

        return new Response($reports);
    }


}