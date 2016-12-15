<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Twig\Extension;

use Twig_Extension;
use Twig_Function_Method;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BannerTwigExtension extends Twig_Extension
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected $doctrine;

    /**
     * @var string
     */
    protected $template = 'SIPResourceBundle:Banner:item.html.twig';

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container) {
        $this->container = $container;
    }

    public function getFunctions() {
        return array(
            'get_banner_by_id'  => new Twig_Function_Method($this, 'getBannerById'),
            'get_banner_by_key' => new Twig_Function_Method($this, 'getBannerByKey')
        );
    }

    /**
     * @param array $page
     * @param string $paramName
     * @return \SIP\ResourceBundle\Entity\Banner
     */
    public function getBannerById($id)
    {
        $repository = $this->getDoctrine()->getRepository('SIPResourceBundle:Banner');

        $entity = $repository->find((int)$id);

        $engine = $this->container->get('templating');
        return $engine->render($this->getTemplate(), array(
            'entity' => $entity
        ));
    }

    /**
     * @param $key
     * @return \SIP\ResourceBundle\Entity\Banner
     */
    public function getBannerByKey($key)
    {
        /** @var \Doctrine\ORM\EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('SIPResourceBundle:Banner');

        $entities = $repository->createQueryBuilder('b')
            ->addSelect('RAND() as HIDDEN rand')
            ->where('b.key = :key')->setParameter('key', $key)
            ->addOrderBy('rand')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();


        $engine = $this->container->get('templating');
        return $engine->render($this->getTemplate(), array(
            'entity' => isset($entities[0])? $entities[0]: null
        ));
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    public function getDoctrine()
    {
        if (!$this->doctrine) {
            $this->doctrine = $this->container->get('doctrine');
        }

        return $this->doctrine;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sip_banner_twig_extension';
    }
}