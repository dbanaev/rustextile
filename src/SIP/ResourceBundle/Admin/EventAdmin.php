<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Admin;

use SIP\ResourceBundle\Entity\Event;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use SIP\TagBundle\Admin\BaseTagAdmin;

class EventAdmin extends BaseTagAdmin
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName, $container)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->container = $container;
    }

    /**
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->remove('acl');
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
            ->tab('General')
                ->with('General', array('class' => 'col-md-6'))
                    ->add('showImage', 'show_sonata_image', array(
                            'label' => 'sip_event_image',
                            'class' => 'SIP\ResourceBundle\Entity\Media\Media'
                        )
                    )
                    ->add('image', 'sonata_type_model_list', array(
                            'label' => false,
                            'required' => false,
                            'attr' => array(
                                'class' => 'form-control'
                            )
                        ),
                        array(
                            'link_parameters' => array(
                                'context' => 'event',
                                'provider' => 'sonata.media.provider.image'
                            )
                        )
                    )
                    ->add('h1', null, array('label' => 'sip_event_h1'))
                    ->add('brief', 'ckeditor', array(
                            'label' => 'sip_event_brief',
                            'config' => array(
                                'allowedContent' => true,
                                'toolbar' => array(
                                    array(
                                        'name'  => 'document',
                                        'items' => array('Source', '-', 'Preview', 'Print', '-', 'Templates', '-', 'Link', 'Unlink'),
                                    ),
                                    array(
                                        'name'  => 'basicstyles',
                                        'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                                    ),
                                ),
                            ),
                        )
                    )
                    ->add('full', 'ckeditor', array(
                            'label' => 'sip_event_full',
                            'config' => array(
                                'allowedContent' => true,
                                'toolbar' => array(
                                    array(
                                        'name'  => 'document',
                                        'items' => array('Source', '-', 'Preview', 'Print', '-', 'Templates', '-', 'Link', 'Unlink'),
                                    ),
                                    array(
                                        'name'  => 'basicstyles',
                                        'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                                    ),
                                ),
                            ),
                        )
                    )
                ->end()
                ->with('Addition', array('class' => 'col-md-6'))
                    ->add('flickrGalleyId', null, array('label' => 'sip_flickrGalleyId'))
                    ->add('address', null, array('label' => 'sip_event_address'))
                    ->add('phone', null, array('label' => 'sip_event_phone'))
                    ->add('site', null, array('label' => 'sip_event_site'))
                    ->add('fotoFrom', null, array('label' => 'sip_event_fotoFrom'))
                    ->add('dateStart', 'genemu_jquerydate', array('widget' => 'single_text', 'label' => 'sip_event_dateStart'))
                    ->add('dateEnd', 'genemu_jquerydate', array('widget' => 'single_text', 'label' => 'sip_event_dateEnd'))
                ->end()
                ->with('Settings')
                    ->add('publish', null, array('label' => 'sip_event_publish'))
                    ->add('onMain', null, array('label' => 'sip_event_onMain'))
                    ->add('type', null, array('label' => 'sip_event_type'))
                    ->add('tags', 'genemu_jqueryselect2_entity', array('class' => 'SIP\ResourceBundle\Entity\Tag\Tag',
                        'label'    => 'sip_event_tags',
                        'property' => 'name',
                        'multiple' => true,
                        'required' => false))
                ->end()
            ->end()
            ->tab('Meta')
                ->add('metaTitle', null, array('label' => 'sip_metaTitle'))
                ->add('metaDescription', null, array('label' => 'sip_metaDescription'))
                ->add('metaKeywords', null, array('label' => 'sip_metaKeywords'))
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
            ->addIdentifier('image', null, array(
                'label' => 'sip_event_image',
                'template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'
            ))
            ->addIdentifier('h1', null, array('label' => 'sip_event_h1'))
            ->add('publish', null, array('label' => 'sip_event_publish', 'editable' => true))
            ->add('onMain', null, array('label' => 'sip_event_onMain', 'editable' => true))
            ->add('dateAdd', null, array('label' => 'sip_event_dateAdd'))
            ->add('dateStart', null, array('label' => 'sip_event_dateStart'))
            ->add('_action', 'actions', array('actions' => array(
                'edit' => array(),
                'delete' => array(),
                'url' => array('template' => 'SIPResourceBundle:Admin:list__action_toSite.html.twig')
            )))
        ;

        parent::configureListFields($listMapper);
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('h1', null, array('label' => 'sip_event_h1'))
            ->add('dateStart', null, array('label' => 'sip_event_dateStart'))
            ->add('dateEnd', null, array('label' => 'sip_event_dateEnd'))
        ;
    }

    /**
     * @param Event $object
     * @return mixed
     */
    public function generateSiteUrl(Event $object)
    {
        return $this->container->get('router')->generate('sip_resource_event', array('slug' => $object->getSlug()));
    }
}