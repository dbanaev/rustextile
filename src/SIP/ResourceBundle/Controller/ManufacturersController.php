<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ManufacturersController extends Controller
{
    /**
     * @Route("/manufacturers", name="sip_resource_manufacturers")
     * @Template()
     * @return array
     */
    public function indexAction(Request $request)
    {
        $limit  = $request->get('limit', 10);
        $page   = $request->get('page', 1);
        $search = $request->get('search');
        $rubric = $request->get('rubric');

        $em = $this->getDoctrine()->getManager();
        /** @var \Doctrine\ORM\EntityRepository $manRep */
        $manRep = $em->getRepository('SIP\ResourceBundle\Entity\Manufacturer');

        $qb = $manRep->createQueryBuilder('m');
        if($search) {
            $qb
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->like('m.h1', ":search"),
                        $qb->expr()->like('m.brief', ":search"))
                )
                ->setParameter('search', "%{$search}%");
            ;
        }

        $qb->orderBy('m.dateAdd', 'DESC')->select('m');
        if($rubric) {
            $qb->select('m, r');
            $qb->innerjoin('m.rubric', 'r');
            $qb->andWhere('r.slug = :slug')->setParameter('slug', $rubric);

            $data['rubric'] = $em->getRepository('SIP\ResourceBundle\Entity\ManufacturerRubric')->findOneBy(array('slug' => $rubric));
        }

        $qb->andWhere('m.publish = :publish')->setParameter('publish', true);

        $query = $qb->getQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query->getResult(), $page, $limit);

        $countAllManufQb = $manRep->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->where('m.publish = :publish')->setParameter('publish', true)
        ;

        $rubQb = $manRep->createQueryBuilder('m')
            ->select('r.name, r.slug, COUNT(m.id) AS c')
            ->innerjoin('m.rubric', 'r')
            ->groupBy('r.name')
            ->orderBy('r.name', 'ASC')
            ->andWhere('m.publish = :publish')->setParameter('publish', true)
        ;

        return array(
            'manufacturers' => $pagination,
            'rubrics'       => $rubQb->getQuery()->getResult(),
            'countAllManuf' => $countAllManufQb->getQuery()->getSingleScalarResult()
        );
    }

    /**
     * @Route("/manufacturer/{slug}", name="sip_resource_manufacturer")
     * @Template()
     * @return array
     */
    public function manufacturerAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $manufacturer = $em->getRepository('SIP\ResourceBundle\Entity\Manufacturer')->findOneBy(array('slug' => $slug));
        $gallery = $em->getRepository('SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia')->findBy(array('manufacturer' => $manufacturer->getId()));

        if (!$manufacturer) throw new NotFoundHttpException();

        return array(
            'manufacturer' => $manufacturer,
            'gallery'      => $gallery
        );
    }
}