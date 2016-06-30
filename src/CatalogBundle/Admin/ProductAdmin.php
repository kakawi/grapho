<?php


namespace CatalogBundle\Admin;


use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
//        $form->add('shortDescription', 'sonata_formatter_type', array(
//            'source_field'         => 'rawDescription',
//            'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 20)),
//            'format_field'         => 'descriptionFormatter',
//            'target_field'         => 'description',
//            'ckeditor_context'     => 'default',
//            'event_dispatcher'     => $form->getFormBuilder()->getEventDispatcher()
//        ));
        $form
//            ->tab('Product')
                ->with('Content', array('class' => 'col-md-9'))
                    ->add('name', 'text')
                    ->add('price', 'number')
                    ->add('inFrontPage')
                    ->add('description', 'sonata_formatter_type', array(
                        'format_field'         => 'descriptionFormatter', // store the selected formatter;
                        'target_field'         => 'description', // store the transformed content display to the visitor
                        'source_field'         => 'rawDescription', // store the original content from the user
                        'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 20)),
                        'ckeditor_context'     => 'default',
                        'event_dispatcher'     => $form->getFormBuilder()->getEventDispatcher(),
                    ))
                    ->add('image', 'sonata_type_model_list', array('required' => false))
//            ->add('image', 'sonata_media_type', array(
//                'provider' => 'sonata.media.provider.image',
//                'context'  => 'default'
//            ))
                ->end()
//            ->end()
//            ->tab('Publish Options')
                ->with('Category', array('class' => 'col-md-3'))
                ->add('category', 'sonata_type_model', array(
                    'class' => 'CatalogBundle\Entity\Category',
                    'property' => 'name',
                ))
                ->end()
//            ->end()
            ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('price')
            ->add('category.name')
            ->add('inFrontPage')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('category.name')
        ;
    }
}