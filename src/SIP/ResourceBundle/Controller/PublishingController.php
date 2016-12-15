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

class PublishingController extends Controller
{
    /**
     * @Route("/publishing/list/{tag}", name="sip_resource_publishing")
     * @Template()
     * @return array
     */
    public function indexAction(Request $request, $tag = null)
    {
        $limit  = $request->get('limit', 10);
        $page   = $request->get('page' ,1);
        $rubric = $request->get('rubric');
        $start  = $request->get('start');
        $end    = $request->get('end');
        $search = $request->get('search');

        $em = $this->getDoctrine()->getManager();
        /** @var \Doctrine\ORM\EntityRepository $pubRep */
        $pubRep = $em->getRepository('SIP\ResourceBundle\Entity\Publishing');

        $qb = $pubRep->createQueryBuilder('p');

        if($search)
            $qb
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->like('p.h1', ":search"),
                        $qb->expr()->like('p.brief', ":search"))
                )
                ->setParameter('search', "%{$search}%");
        ;

        if($rubric) {
            $qb->select('p, r');

            $qb->innerjoin('p.rubric', 'r');
            $qb->andWhere('r.slug = :slug')->setParameter('slug', $rubric);

            $data['rubric'] = $em->getRepository('SIP\ResourceBundle\Entity\PublishingRubric')->findOneBy(array('slug' => $rubric));
        } else {
            $qb->select('p');
        }

        $qb->orderBy('p.dateAdd', 'DESC')->select('p');
        $qb->andWhere('p.publish = :publish')->setParameter('publish', true);

        if($tag) {

            $tag = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tag')->findOneBy(array('slug' => $tag));
            $pubs = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('tag' => $tag->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\Publishing'));

            $data['tagName'] = $pubs[0]->getTag()->getName();

            $ids = array();
            foreach($pubs as $item){
                $ids[] = $item->getResourceId();
            }

            $qb->andWhere($qb->expr()->in('p.id', $ids));
        }

        if ($start and $end) {
            $qb->andWhere($qb->expr()->between('p.dateAdd', ':start', ':end'));
            $qb->setParameter('start', new \DateTime($start));
            $qb->setParameter('end', new \DateTime($end));
        }

        $query = $qb->getQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query->getResult(), $page, $limit);

        $data['publishing'] = $pagination;

        $data['countAllPubs'] = $pubRep->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.publish = :publish')->setParameter('publish', true)
            ->getQuery()->getSingleScalarResult()
        ;

        $qb = $pubRep->createQueryBuilder('p')
            ->select('r.name, r.slug, COUNT(p.id) AS c')
            ->innerjoin('p.rubric', 'r')
            ->groupBy('r.name')
            ->orderBy('r.name', 'ASC')
            ->andWhere('p.publish = :publish')->setParameter('publish', true)
        ;

        $query = $qb->getQuery();
        $data['rubrics'] = $query->getResult();

        return $data;
    }

    /**
     * @Route("/publishing/{slug}", name="sip_resource_publishing_item")
     * @Template()
     * @return array
     */
    public function publishingAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $pub = $em->getRepository('SIP\ResourceBundle\Entity\Publishing')->findOneBy(array('slug' => $slug));

        if (!$pub) throw new NotFoundHttpException();

        $lastPub = $em->getRepository('SIP\ResourceBundle\Entity\Publishing')
            ->createQueryBuilder('p')
            ->andWhere('p.publish = :publish')->setParameter('publish', true)
            ->andWhere('p.id <> :id')->setParameter('id', $pub->getId())
            ->orderBy('p.dateAdd', 'DESC')->setMaxResults(3)
            ->getQuery()->getResult()
        ;

        $tags = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('resourceId' => $pub->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\Publishing'));

        return array(
            'publishing' => $pub,
            'lastPub' => $lastPub,
            'tags' => $tags
        );
    }
}