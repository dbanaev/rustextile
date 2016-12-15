<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Controller;

use Proxies\__CG__\SIP\ResourceBundle\Entity\Tag\Tagging;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DoctrineExtensions\Taggable\TagManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    /**
     * @Route("/newslist/{tag}", name="sip_resource_news")
     * @Template()
     * @return array
     */
    public function indexAction(Request $request, $tag = null)
    {
        $limit  = $request->get('limit', 10);
        $page   = $request->get('page', 1);
        $rubric = $request->get('rubric');
        $start  = $request->get('start');
        $end    = $request->get('end');
        $search = $request->get('search');

        $em = $this->getDoctrine()->getManager();
        /** @var \Doctrine\ORM\EntityRepository $newsRep */
        $newsRep = $em->getRepository('SIP\ResourceBundle\Entity\News');

        $qb = $newsRep->createQueryBuilder('n');

        if($search)
            $qb
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->like('n.h1', ":search"),
                        $qb->expr()->like('n.brief', ":search"))
                )
                ->setParameter('search', "%{$search}%");
        ;

        if($rubric) {
            $qb->select('n, r');

            $qb->innerjoin('n.rubric', 'r');
            $qb->andWhere('r.slug = :slug')->setParameter('slug', $rubric);

            $data['rubric'] = $em->getRepository('SIP\ResourceBundle\Entity\NewsRubric')->findOneBy(array('slug' => $rubric));
        } else {
            $qb->select('n');
        }

        $qb->orderBy('n.dateAdd', 'DESC');
        $qb->andWhere('n.publish = :publish')->setParameter('publish', true);

        if($tag) {

            $tag = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tag')->findOneBy(array('slug' => $tag));
            $news = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('tag' => $tag->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\News'));

            $data['tag'] = $news[0]->getTag();

            $ids = array();
            foreach($news as $item){
                $ids[] = $item->getResourceId();
            }

            $qb->andWhere($qb->expr()->in('n.id', $ids));
        }

        if ($start and $end) {
            $qb->andWhere($qb->expr()->between('n.dateAdd', ':start', ':end'));
            $qb->setParameter('start', new \DateTime($start));
            $qb->setParameter('end', new \DateTime($end));
        }

        $query = $qb->getQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query->getResult(), $page, $limit);

        $data['news'] = $pagination;

        $data['countAllNews'] = $newsRep->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.publish = :publish')->setParameter('publish', true)
            ->getQuery()->getSingleScalarResult()
        ;

        $qb = $newsRep->createQueryBuilder('n')
            ->select('r.name, r.slug, COUNT(n.id) AS c')
            ->innerjoin('n.rubric', 'r')
            ->groupBy('r.name')
            ->orderBy('r.name', 'ASC')
            ->andWhere('n.publish = :publish')->setParameter('publish', true)
        ;

        $query = $qb->getQuery();
        $data['rubrics'] = $query->getResult();

        return $data;
    }

    /**
     * @Route("/news/{slug}", name="sip_resource_news_item")
     * @Template()
     * @return array
     */
    public function newsAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \Doctrine\ORM\EntityRepository $newsRep */
        $newsRep = $em->getRepository('SIP\ResourceBundle\Entity\News');

        /** @var \SIP\ResourceBundle\Entity\News $new */
        $new = $newsRep->findOneBy(array('slug' => $slug));

        if (!$new) throw new NotFoundHttpException();

        $lastNews = $newsRep
            ->createQueryBuilder('n')
            ->andWhere('n.publish = :publish')->setParameter('publish', true)
            ->andWhere('n.id <> :id')->setParameter('id', $new->getId())
            ->orderBy('n.dateAdd', 'DESC')->setMaxResults(3)
            ->getQuery()->getResult()
        ;

        $tags = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('resourceId' => $new->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\News'));

        return array(
            'news'     => $new,
            'lastNews' => $lastNews,
            'tags'     => $tags
        );
    }
}