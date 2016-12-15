<?php
namespace SIP\ResourceBundle\Admin;

use SIP\ResourceBundle\Entity\Page;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\Admin;

class PageAdmin extends Admin
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

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', ['label' => 'Заголовок'])
            ->add('slug', 'text', ['label' => 'Адрес', 'required' => false])
            ->add('body', 'ckeditor', array(
                    'label' => 'Контент',
                    'required' => false,
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
            ->add('metaTitle', 'text', ['label' => 'SEO title', 'required' => false])
            ->add('metaKeywords', 'text', ['label' => 'SEO keywords', 'required' => false])
            ->add('metaDescription', 'text', ['label' => 'SEO description', 'required' => false])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', 'text', ['label' => 'Заголовок'])
            ->add('_action', 'actions', [
                'label' => 'Действия',
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                    'url' => array('template' => 'SIPResourceBundle:Admin:list__action_toSite.html.twig')
                ]
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {}

    /**
     * @param Page $object
     * @return mixed
     */
    public function generateSiteUrl(Page $object)
    {
        return $this->container->get('router')->generate('sip_staic_pages', array('slug' => $object->getSlug()));
    }
}