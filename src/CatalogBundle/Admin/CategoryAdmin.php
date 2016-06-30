<?php
namespace CatalogBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name');
        $formMapper->add('parent', 'sonata_type_model', array(
            'class' => 'CatalogBundle:Category',
            'property' => 'name',
            'required' => false
        ));
        $formMapper->add('description', 'sonata_formatter_type', array(
            'format_field'         => 'descriptionFormatter', // store the selected formatter;
            'target_field'         => 'description', // store the transformed content display to the visitor
            'source_field'         => 'rawDescription', // store the original content from the user
            'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 20)),
            'ckeditor_context'     => 'default',
            'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
        ));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id');
        $listMapper->addIdentifier('name');
        $listMapper->add('parent', null, array('associated_property' => 'name'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }
}