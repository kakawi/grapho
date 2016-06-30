<?php


namespace CatalogBundle\Controller;

use CatalogBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends Controller
{
    /**
     * @Route("/admin/document/upload", name="document_upload")
     */
    public function uploadDocument(Request $request)
    {
        $document = new Document();
        $form = $this->createFormBuilder($document)
            ->add('file')
            ->add('save', SubmitType::class, ['label' => 'Сохранить прайс'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $document->upload();

            return $this->redirectToRoute('homepage');
        }

        return $this->render("CatalogBundle:Document:upload.html.twig", [
            'form' => $form->createView()
        ]);
    }
    
    
    /**
     * @Route("/price", name="get_price")
     */
    public function getPrice()
    {
        $file = new Document();

        $filename = $file->getAbsolutePath();
        // Generate response
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));

        return $response;
    }
}