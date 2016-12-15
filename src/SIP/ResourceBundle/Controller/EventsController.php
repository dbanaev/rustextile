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

class EventsController extends Controller
{

    protected $months = array(
        1 => array('short' => 'ЯНВ', 'long' => 'Январь'),
        2 => array('short' => 'ФЕВ', 'long' => 'Февраль'),
        3 => array('short' => 'МАРТ', 'long' => 'Март'),
        4 => array('short' => 'АПР', 'long' => 'Апрель'),
        5 => array('short' => 'МАЙ', 'long' => 'Май'),
        6 => array('short' => 'ИЮНЬ', 'long' => 'Июнь'),
        7 => array('short' => 'ИЮЛЬ', 'long' => 'Июль'),
        8 => array('short' => 'АВГ', 'long' => 'Август'),
        9 => array('short' => 'СЕНТ', 'long' => 'Сентябрь'),
        10 => array('short' => 'ОКТ', 'long' => 'Октябрь'),
        11 => array('short' => 'НОЯБ', 'long' => 'Ноябрь'),
        12 => array('short' => 'ДЕК', 'long' => 'Декабрь')
    );

    /**
     * @Route("/events/{tag}", name="sip_resource_events")
     * @Template()
     * @return array
     */
    public function indexAction(Request $request, $tag = null)
    {
        $month = $request->get('month', date('m', time()));
        $year  = $request->get('year', date('Y', time()));

        if(!$month && !$year) throw new NotFoundHttpException();

        $date = new \DateTime($year . '-' . $month . '-01');

        $datePrev = $date->modify('-1 month');
        $prev['month'] = $datePrev->format('m');
        $prev['year'] = $datePrev->format('Y');

        $dateNext = $date->modify('+2 month');
        $next['month'] = $dateNext->format('m');
        $next['year'] = $dateNext->format('Y');


        $countDays = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);

        $em = $this->getDoctrine()->getManager();
        $eventRep = $this->getDoctrine()->getRepository('SIP\ResourceBundle\Entity\Event');

        $qb = $eventRep->createQueryBuilder('e');

        $qb->select('e')
            ->where('YEAR(e.dateStart) = :year')
            ->andWhere('MONTH(e.dateStart) = :month')
        ;

        $qb->setParameter('year', (int)$year)
            ->setParameter('month', (int)$month);

        if($tag) {

            $tag = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tag')->findOneBy(array('slug' => $tag));
            $events = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('tag' => $tag->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\Event'));
            $data['tag'] = $events[0]->getTag();

            $ids = array();
            foreach($events as $event){
                $ids[] = $event->getResourceId();
            }

            $qb->andWhere($qb->expr()->in('e.id', $ids));

        }

        $query = $qb->getQuery();
        $events = $query->getResult();

        if(!$events)
            throw new NotFoundHttpException();

        $eventsArr = array();

        for ($day = 1; $day <= $countDays; $day++) {
            $arr = array();

            foreach ($events as $event) {
                if($day == (int)$event->getDateStart()->format('d')) {
                    $arr[] = $event;
                }
            }

            $d = new \DateTime($year . '-' . $month . '-' . $day);
            $weekday = (int)$d->format('w');

            $eventsArr[$day] = array(
                'events' => $arr,
                'weekday' => $weekday
            );
        }

        $data['eventsArr'] = $eventsArr;
        $data['countDays'] = $countDays;
        $data['monthInfo'] = $this->months[(int)$month];
        $data['month'] = (int)$month;
        $data['year'] = (int)$year;
        $data['prev'] = $prev;
        $data['next'] = $next;

        return $data;
    }

    /**
     * @Route("/event/{slug}", name="sip_resource_event")
     * @Template()
     * @return array
     */
    public function eventAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('SIP\ResourceBundle\Entity\Event')->findOneBy(array('slug' => $slug));

        if (!$event) throw new NotFoundHttpException();

        $lastEvents = $em->getRepository('SIP\ResourceBundle\Entity\Event')->findBy(array('publish' => true), array('dateAdd' => 'DESC'), 3);

        $tags = $em->getRepository('SIP\ResourceBundle\Entity\Tag\Tagging')->findBy(array('resourceId' => $event->getId(), 'resourceType' => 'SIP\ResourceBundle\Entity\Event'));

        return array(
            'event' => $event,
            'lastEvents' => $lastEvents,
            'tags' => $tags
        );
    }
}