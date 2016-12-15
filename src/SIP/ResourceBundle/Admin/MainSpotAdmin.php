<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\Admin;

class MainSpotAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->remove('acl');
        $collection->remove('list');
        $collection->add('list', 'edit');
    }

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'dateAdd',
    );

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Blok1')
                ->add('title1', null, array('label' => 'sip_main_spot_title1'))
                ->add('linkItem1', null, array('label' => 'sip_main_spot_linkItem1'))
                ->add('showImage1', 'show_sonata_image', array(
                        'label' => 'sip_main_spot_image1',
                        'class' => 'SIP\ResourceBundle\Entity\Media\Media'
                    )
                )
                ->add('image1', 'sonata_type_model_list', array(
                        'label' => false,
                        'required' => false,
                        'attr' => array(
                            'class' => 'form-control'
                        )
                    ),
                    array(
                        'link_parameters' => array(
                            'context' => 'mainspot',
                            'provider' => 'sonata.media.provider.image'
                        )
                    )
                )
            ->end()
            ->with('Blok2')
                ->add('title2', null, array('label' => 'sip_main_spot_title2'))
                ->add('linkItem2', null, array('label' => 'sip_main_spot_linkItem2'))
                ->add('showImage2', 'show_sonata_image', array(
                        'label' => 'sip_main_spot_image2',
                        'class' => 'SIP\ResourceBundle\Entity\Media\Media'
                    )
                )
                ->add('image2', 'sonata_type_model_list', array(
                        'label' => false,
                        'required' => false,
                        'attr' => array(
                            'class' => 'form-control'
                        )
                    ),
                    array(
                        'link_parameters' => array(
                            'context' => 'mainspot',
                            'provider' => 'sonata.media.provider.image'
                        )
                    )
                )
            ->end()
            ->with('Blok3')
                ->add('title3', null, array('label' => 'sip_main_spot_title3'))
                ->add('linkItem3', null, array('label' => 'sip_main_spot_linkItem3'))
                ->add('showImage3', 'show_sonata_image', array(
                        'label' => 'sip_main_spot_image3',
                        'class' => 'SIP\ResourceBundle\Entity\Media\Media'
                    )
                )
                ->add('image3', 'sonata_type_model_list', array(
                        'label' => false,
                        'required' => false,
                        'attr' => array(
                            'class' => 'form-control'
                        )
                    ),
                    array(
                        'link_parameters' => array(
                            'context' => 'mainspot',
                            'provider' => 'sonata.media.provider.image'
                        )
                    )
                )
            ->end()
        ;
    }
}