<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;
use SIP\TagBundle\Admin\TagAdmin as BaseTagAdmin;

class TagAdmin extends BaseTagAdmin
{
    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('General')
                ->with('General')
                    ->add('name', null, array('label' => 'sip_tag_name'))
                    ->add('slug', null, array('label' => 'sip_tag_slug'))
                ->end()
            ->end()
            ->tab('Meta')
                ->add('metaTitle', null, array('label' => 'sip_metaTitle'))
                ->add('metaDescription', null, array('label' => 'sip_metaDescription'))
                ->add('metaKeywords', null, array('label' => 'sip_metaKeywords'))
            ->end()
        ;
    }
}