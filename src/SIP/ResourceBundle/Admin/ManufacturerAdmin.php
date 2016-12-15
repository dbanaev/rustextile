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

use SIP\ResourceBundle\Entity\Manufacturer;
use SIP\ResourceBundle\Entity\Media\Media;
use SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia;
use Genemu\Bundle\FormBundle\Gd\File\Image;

class ManufacturerAdmin extends Admin
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

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
                    ->add('h1', null, array('label' => 'sip_designer_h1'))
                    ->add('slug', null, array('label' => 'sip_designer_slug', 'disabled' => true))
                    ->add('showImage', 'show_sonata_image', array(
                            'label' => 'sip_image',
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
                                'context' => 'manufacturer',
                                'provider' => 'sonata.media.provider.image'
                            )
                        )
                    )
                    ->add('brief', 'ckeditor', array(
                            'label' => 'sip_designer_brief',
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
                            'label' => 'sip_designer_full',
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
                    ->add('address', null, array('label' => 'sip_designer_address'))
                    ->add('coords', 'location_picker', array('label' => 'sip_designer_coords'))
                    //->add('person', null, array('label' => 'sip_designer_person'))
                    ->add('phone', null, array('label' => 'sip_designer_phone'))
                    ->add('fax', null, array('label' => 'sip_designer_fax'))
                    ->add('email', null, array('label' => 'sip_designer_email'))
                    ->add('site', null, array('label' => 'sip_designer_site'))
                ->end()
                ->with('Settings')
                    ->add('publish', null, array('label' => 'sip_designer_publish'))
                    ->add('rubric', null, array('label' => 'sip_manufacturer_rubric'))
                    ->add('region', 'genemu_jqueryselect2_entity', array('class' => 'SIP\ResourceBundle\Entity\Region',
                        'label'    => 'sip_designer_region',
                        'property' => 'name',
                        'required' => false))
                    ->add('city', 'genemu_jqueryselect2_entity', array('class' => 'SIP\ResourceBundle\Entity\City',
                        'label'    => 'sip_designer_city',
                        'property' => 'name',
                        'required' => false))
                    ->add('user', 'genemu_jqueryselect2_entity', array('class' => 'SIP\ResourceBundle\Entity\User\User',
                        'label'    => 'sip_designer_user',
                        'property' => 'username',
                        'required' => false))
                ->end()
                ->with('Gallery')
                    ->add('galleryMultiple', 'multiple_upload_file', array(
                            'label'            => 'sip_desingner_galleryMultiple',
                            'maxNumberOfFiles' => 20,
                            'loadHistory'      => false,
                            'multiple'         => true
                        )
                    )
                    ->add('gallery', 'sonata_type_collection', array(
                            'label'              => 'sip_desingn_gallery',
                            'cascade_validation' => true,
                            'by_reference'       => false,
                            'required'           => false,
                            'attr'               => array(
                                'class' => 'form-control'
                            )
                        ), array(
                            'edit'         => 'inline',
                            'inline'       => 'table',
                            'sortable'     => 'position',
                            'admin_code'   => 'sip.resource.manufacturerhasmedia.admin',
                        )
                    )
                ->end()
            ->end()
            ->tab('Meta')
                ->add('title', null, array('label' => 'sip_designer_title', 'required' => false))
                ->add('description', null, array('label' => 'sip_designer_description', 'required' => false))
                ->add('keywords', null, array('label' => 'sip_designer_keywords', 'required' => false))
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
                'label' => 'sip_designer_image',
                'template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'
            ))
            ->addIdentifier('h1', null, array('label' => 'sip_designer_h1'))
            ->add('publish', null, array('label' => 'sip_designer_publish', 'editable' => true))
            ->add('dateAdd', null, array('label' => 'sip_designer_dateAdd'))
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
            ->add('h1', null, array('label' => 'sip_designer_h1'))
            ->add('publish', null, array('label' => 'sip_designer_publish'))
            ->add('dateAdd', null, array('label' => 'sip_designer_dateAdd'))
        ;
    }

    /**
     * @param \SIP\ResourceBundle\Entity\Object $object
     * @return mixed
     */
    public function preUpdate($object)
    {
        $this->createMedias($object);
    }

    /**
     * @param \SIP\ResourceBundle\Entity\Object $object
     * @return mixed
     */
    public function postPersist($object)
    {
        $this->createMedias($object);
    }

    public function createMedias(Manufacturer $object)
    {
        foreach ($object->getGalleryMultiple() as $mediaItem) {
            $objectHasMedia = new ManufacturerHasMedia();
            $media = $this->getMediaByImage($mediaItem);
            $objectHasMedia->setImage($media);
            $objectHasMedia->setManufacturer($object);
            $this->getEntityManager()->persist($objectHasMedia);
        }
    }

    public function getMediaByImage(Image $image)
    {
        $media = new Media;
        $media->setName($image->getFilename());
        $media->setBinaryContent($image);
        $media->setProviderName('sonata.media.provider.image');
        $media->setContext('advert');
        $this->container->get('sonata.media.manager.media')->save($media);

        $thumbnailPath = str_replace($image->getFilename(),
            'thumbnails/' . $image->getFilename(),
            $image->getRealPath());

        @unlink($image->getRealPath());
        @unlink($thumbnailPath);

        return $media;
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    public function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (!$this->em) {
            $this->em = $this->getDoctrine()->getManager();
        }

        return $this->em;
    }

    /**
     * @param Manufacturer $object
     * @return mixed
     */
    public function generateSiteUrl(Manufacturer $object)
    {
        return $this->container->get('router')->generate('sip_resource_manufacturer', array('slug' => $object->getSlug()));
    }
}