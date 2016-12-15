<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use Sonata\AdminBundle\Admin\Admin;

class BannerAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name', null, array('label' => 'sip.banner.name'))
            ->add('key', null, array('label' => 'sip.banner.key'))
            ->add('url', null, array('label' => 'sip.banner.url'))
            ->add('showImage', 'show_sonata_image', array(
                    'label' => 'sip_image',
                    'class' => 'SIP\ResourceBundle\Entity\Media\Media'
                )
            )
            ->add('image', 'sonata_type_model_list',
                array(
                    'required' => false,
                    'label' => false
                ),
                array(
                    'link_parameters'=>array('context'=>'banner')
                )
            )
            ->add('code', null, array('label' => 'sip.banner.code'))
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'sip.banner.name'))
            ->add('key', null, array('label' => 'sip.banner.key'))
            ->add('url', null, array(
                    'template' => 'SIPResourceBundle:Admin:list_link.html.twig',
                    'url' => 'sip.banner.url'
                )
            )
            ->add('image', 'sonata_type_model', array(
                    'template'=>'SIPResourceBundle:Admin:list_image.html.twig',
                    'url' => 'sip.banner.image'
                )
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit'   => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('key', null, array('label' => 'sip.banner.key'))
            ->add('name', null, array('label' => 'sip.banner.name'))
        ;
    }
}