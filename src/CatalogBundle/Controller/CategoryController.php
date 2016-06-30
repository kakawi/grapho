<?php


namespace CatalogBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{id}", name="single_category")
     */
    public function getCategoryAction($id)
    {
        $rep = $this->getDoctrine()->getRepository('CatalogBundle:Category');
        /** @var \CatalogBundle\Entity\Category $category */
        $category = $rep->find($id);

        if(!$category) {
            throw $this->createNotFoundException(
                'Нет такой катерогрии '
            );
        }

//        if($category->getParent() === null) {
//            $categories = $rep->childrenHierarchy($category, true);
//            return $this->render("CatalogBundle:Category:show_subcategories.html.twig", [
//                'categories' => $categories
//            ]);
//        } else {
            return $this->render('CatalogBundle:Category:single_category.html.twig', [
                'category' => $category,
                'title' => $category->getName()
            ]);
//        }
    }

    public function getSidebarAction()
    {
        $rep = $this->getDoctrine()->getRepository('CatalogBundle:Category');
        $categories = $rep->findAll();

        return $this->render('CatalogBundle:Category:list_categories_with_product.html.twig', [
            'categories' => $categories
        ]);
    }
}