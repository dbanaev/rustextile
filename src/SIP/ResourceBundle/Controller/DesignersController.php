<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Controller;

use Proxies\__CG__\SIP\ResourceBundle\Entity\Tag\Tag;
use Proxies\__CG__\SIP\ResourceBundle\Entity\Tag\Tagging;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DesignersController extends Controller
{

    /**
     * @Route("/designers/{tag}", name="sip_resource_designers")
     * @Template()
     * @return array
     */
    public function indexAction(Request $request, $tag = null){
        $em = $this->getDoctrine()->getManager();
        /** @var \Doctrine\ORM\EntityRepository $desRep */
        $desRep = $em->getRepository('SIP\ResourceBundle\Entity\Designer');
        $search = $request->get('search');

        $qb = $desRep->createQueryBuilder('d');
        if($search) {
            $qb
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->like('d.h1', ":search"),
                        $qb->expr()->like('d.brief', ":search"))
                )
                ->setParameter('search', "%{$search}%");
            ;
        }
        $qb->orderBy('d.h1', 'ASC')->select('d');
        $qb->andWhere('d.publish = :publish')->setParameter('publish', true);

        if($tag) {

            $tag = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tag')->findOneBy(array('slug' => $tag));
            $dess = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('tag' => $tag->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\Designer'));

            $data['tag'] = $dess[0]->getTag();

            $ids = array();
            foreach($dess as $item){
                $ids[] = $item->getResourceId();
            }

            $qb->andWhere($qb->expr()->in('d.id', $ids));
        }

        $qb->setMaxResults(10);

        $query = $qb->getQuery();
        $data['designers'] = $query->getResult();

        return $data;
    }

    /**
     * @Route("/designer/{slug}", name="sip_resource_designer")
     * @Template()
     * @return array
     */
    public function designerAction($slug = null) {
        $em = $this->getDoctrine()->getManager();
        $designer = $em->getRepository('SIP\ResourceBundle\Entity\Designer')->findOneBy(array('slug' => $slug));

        if (!$designer)
            throw new NotFoundHttpException();

        $tags = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('resourceId' => $designer->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\Designer'));
        $gallery = $em->getRepository('SIP\ResourceBundle\Entity\Media\DisignerHasMedia')->findBy(array('designer' => $designer->getId()));

        $brands = $designer->getBrands();

        return array(
            'designer' => $designer,
            'tags' => $tags,
            'gallery' => $gallery,
            'brands' => $brands
        );
    }

    /**
     * @Route("/_ajax/designers", name="sip_resource_ajax_designers")
     */
    public function ajaxDesignerAction(Request $request) {

        $startFrom = $request->get('startFrom');
        $tag = $request->get('tag');
        $search = $request->get('search');

        $em = $this->getDoctrine()->getManager();
        /** @var \Doctrine\ORM\EntityRepository $desRep */
        $desRep = $em->getRepository('SIP\ResourceBundle\Entity\Designer');

        $qb = $desRep->createQueryBuilder('d');
        if($search) {
            $qb
                ->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->like('d.h1', ":search"),
                        $qb->expr()->like('d.brief', ":search"))
                )
                ->setParameter('search', "%{$search}%");
            ;
        }
        $qb->orderBy('d.h1', 'ASC')->select('d');
        $qb->andWhere('d.publish = :publish')->setParameter('publish', true);

//        $designers = $em->getRepository('SIP\ResourceBundle\Entity\Designer')->findBy(array('publish' => true), array('h1' => 'ASC'), 10, $startFrom);

        if($tag) {
            $tag = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tag')->findOneBy(array('slug' => $tag));
            $dess = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('tag' => $tag->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\Designer'));

            $ids = array();
            foreach($dess as $item){
                $ids[] = $item->getResourceId();
            }

            $qb->andWhere($qb->expr()->in('d.id', $ids));
        }

        $qb->setFirstResult($startFrom);
        $qb->setMaxResults(10);

        $query = $qb->getQuery();
        /** @var \SIP\ResourceBundle\Entity\Designer[] $designers*/
        $designers = $query->getResult();

        $designersArr = array();
        foreach($designers as $designer) {
            $arr = array();

            $arr['h1'] = $designer->getH1();
            $arr['brief'] = $designer->getBrief();
            $arr['url'] = $this->get('router')->generate('sip_resource_designer', array('slug' => $designer->getSlug()), true);
            $arr['site'] = $designer->getSite();
            $arr['instagram'] = $designer->getInstagram();
            $arr['pinterest'] = $designer->getPinterest();

            $image = $designer->getImage();
            if ($image) {

                $imageProvider = $this->get($image->getProviderName());
                $img = $imageProvider->generatePublicUrl($image, "{$image->getContext()}_big");
            } else {
                $img = '/uploads/media/designer/0001/02/thumb_1775_designer_big.jpeg';
            }

            $arr['img'] =  $img;

            $designersArr[] = $arr;
        }

        return new JsonResponse($designersArr);
    }
}