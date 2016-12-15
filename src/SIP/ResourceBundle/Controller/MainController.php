<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{

    /**
     * @Route("/", name="sip_resource_main")
     * @Template()
     * @return array
     */
    public function indexAction(Request $request)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('SIP\ResourceBundle\Entity\News')->findBy(array('onMain' => true), array('dateAdd' => 'DESC'), 8);

        $eqb = $em->createQueryBuilder('e')->from('SIP\ResourceBundle\Entity\Event', 'e')->select('e')
           ->andWhere('e.onMain =:onMain')->setParameter('onMain', true)
           ->andWhere('e.dateStart >= :date')->setParameter('date', new \DateTime(date('d.m.Y')))
            ->orderBy('e.dateStart', 'ASC')->setMaxResults(1)
        ;
        $event = $eqb->getQuery()->getOneOrNullResult();
        if (!$event)
            $event = $em->getRepository('SIP\ResourceBundle\Entity\Event')->findOneBy(array('onMain' => true), array('dateStart' => 'DESC'));

        return array(
            'mainspot' => $this->getDoctrine()->getRepository('SIP\ResourceBundle\Entity\MainSpot')->find(1),
            'news'     => $news,
            'event'    => $event
        );
    }
}