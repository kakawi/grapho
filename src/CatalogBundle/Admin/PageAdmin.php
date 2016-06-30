<?php


namespace CatalogBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('weight', 'number')
            ->add('isMainPage')
            ->add('pageText', 'sonata_formatter_type', array(
                'format_field'         => 'pageFormatter', // store the selected formatter;
                'target_field'         => 'pageText', // store the transformed content display to the visitor
                'source_field'         => 'rawPageText', // store the original content from the user
                'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 20)),
                'ckeditor_context'     => 'default',
                'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('weight')
            ->add('isMainPage')
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('name')

        ;
    }

}