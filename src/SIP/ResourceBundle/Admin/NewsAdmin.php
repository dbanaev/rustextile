<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Admin;

use SIP\ResourceBundle\Entity\News;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use SIP\TagBundle\Admin\BaseTagAdmin;

class NewsAdmin extends BaseTagAdmin
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
                    ->add('h1', null, array('label' => 'sip_news_h1'))
                    ->add('showImage', 'show_sonata_image', array(
                            'label' => 'sip_news_image',
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
                                'context' => 'news',
                                'provider' => 'sonata.media.provider.image'
                            )
                        )
                    )
                    ->add('brief', 'ckeditor', array(
                            'label' => 'sip_news_brief',
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
                            'label' => 'sip_news_full',
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
                    ->add('fotoFrom', null, array('label' => 'sip_news_fotoFrom'))
                ->end()
                ->with('Settings')
                    ->add('publish', null, array('label' => 'sip_news_publish'))
                    ->add('onMain', null, array('label' => 'sip_news_onMain'))
                    ->add('rubric', null, array('label' => 'sip_news_rubric'))
                    ->add('tags', 'genemu_jqueryselect2_entity', array('class' => 'SIP\ResourceBundle\Entity\Tag\Tag',
                        'label'    => 'sip_event_tags',
                        'property' => 'name',
                        'multiple' => true,
                        'required' => false)
                    )
                ->end()
            ->end()
            ->tab('Meta')
                ->add('title', null, array('label' => 'sip_news_title', 'required' => false))
                ->add('description', null, array('label' => 'sip_news_description', 'required' => false))
                ->add('keywords', null, array('label' => 'sip_news_keywords', 'required' => false))
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
                'label' => 'sip_news_image',
                'template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'
            ))
            ->addIdentifier('h1', null, array('label' => 'sip_news_h1'))
            ->add('publish', null, array('label' => 'sip_news_publish', 'editable' => true))
            ->add('onMain', null, array('label' => 'sip_news_onMain', 'editable' => true))
            ->add('dateAdd', null, array('label' => 'sip_news_dateAdd'))
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
            ->add('publish', null, array('label' => 'sip_news_publish'))
            ->add('dateAdd', null, array('label' => 'sip_news_dateAdd'))
        ;
    }

    /**
     * @param News $object
     * @return mixed
     */
    public function generateSiteUrl(News $object)
    {
        return $this->container->get('router')->generate('sip_resource_news_item', array('slug' => $object->getSlug()));
    }
}