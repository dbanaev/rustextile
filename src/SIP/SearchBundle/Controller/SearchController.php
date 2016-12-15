<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\SearchBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController as Controller;
use SIP\ResourceBundle\Entity\Event;
use SIP\ResourceBundle\Entity\News;
use SIP\ResourceBundle\Entity\Publishing;
use SIP\ResourceBundle\Entity\Designer;
use SIP\ResourceBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SearchController extends Controller
{
    /**
     * @var \SIP\SearchBundle\Services\Search\SphinxSearch
     */
    protected $search;

    /**
     * @var \Knp\Component\Pager\Paginator
     */
    protected $paginator;

    /**
     * @Route("/result", name="sip_search_result")
     * @Template()
     * @return array
     */
    public function searchResultsAction(Request $request)
    {
        $words   = $request->get('search');
        $page    = $request->get('page', 1);
        $perPage = $this->container->getParameter('search_per_page', 10);

        $part = $request->get('part');

        switch($part) {
            case 'news':
                $indexes = array('rustextNewsIndex');
                break;
            case 'event':
                $indexes = array('rustextEventsIndex');
                break;
            case 'publishing':
                $indexes = array('rustextPublishingIndex');
                break;
            case 'designer':
                $indexes = array('rustextDesignersIndex');
                break;
            case 'manufacturer':
                $indexes = array('rustextManufacturersIndex');
                break;
            default:
                $indexes = array(
                    'rustextNewsIndex',
                    'rustextPublishingIndex',
                    'rustextDesignersIndex',
                    'rustextManufacturersIndex',
                    'rustextEventsIndex'
                );
        }

        $renderParams  = array( 'searchResults' => array(),
            'searchCount'   => 0,
            'searchQuery'   => $words);

        $this->setLimits($request->get('page', 1), $perPage);

        $this->getSphinxSearch()->getSphinx()->SetMatchMode(SPH_MATCH_EXTENDED);
        $res = $this->getSphinxSearch()->combinedSearch($words, $indexes, false);

        if (!empty($res['matches'])) {
            $renderParams['searchResults'] = $this->buildObjects($res);
            $renderParams['searchCount'] = $res['total'];
            $renderParams['current_page_number'] = $request->get('page', 1);
            $renderParams['num_items_per_page'] = $perPage;
            $renderParams['countRows'] = $this->countRows($words);
        }

        $renderParams['countRows'] = (isset($renderParams['countRows'])) ? $renderParams['countRows'] : array('news' => 0, 'publishing' => 0, 'designer' => 0, 'manufacturer' => 0, 'event' => 0);

        $renderParams['pagination'] = $this->getPaginator()->paginate($renderParams['searchResults'], $page, $perPage);
        $renderParams['pagination']->setTotalItemCount($renderParams['searchCount']);

        return $renderParams;
    }

    public function countRows($words) {
        $indexes = array(
            'news'         => array('rustextNewsIndex'),
            'publishing'   => array('rustextPublishingIndex'),
            'designer'     => array('rustextDesignersIndex'),
            'manufacturer' => array('rustextManufacturersIndex'),
            'event'        => array('rustextEventsIndex'),
            'total'        => array(
                'rustextNewsIndex',
                'rustextPublishingIndex',
                'rustextDesignersIndex',
                'rustextManufacturersIndex',
                'rustextEventsIndex'
            )
        );

        $arr = array();
        foreach ($indexes as $k => $v) {

            $this->getSphinxSearch()->getSphinx()->SetMatchMode(SPH_MATCH_EXTENDED);
            $res = $this->getSphinxSearch()->combinedSearch($words, $v, false);

            $arr[$k] = (!empty($res['matches'])) ? $res['total'] : 0;
        }

        return $arr;
    }

    /**
     * @param int $page
     * @param int $perPage
     */
    public function setLimits($page, $perPage)
    {
        $offset = (int)$page;
        if ($offset) {
            $offset = ($offset - 1) * $perPage;
        }

        $this->getSphinxSearch()->getSphinx()->setLimits($offset, $perPage, $this->getParameter('sphinxsearch_total_limit'));
    }

    /**
     * @param array $res
     * @param array $indexes
     * @param string $words
     */
    public function buildExcerpts(&$res, $indexes, $words)
    {
        $passageArray = array();
        foreach ($res['matches'] as $match) {
            $passageArray[] = $match['passage'];
        }
        $passage = $this->getSphinxSearch()->BuildExcerpts($passageArray, $indexes[0], $words);
        $i = 0;
        foreach ($res['matches'] as $objectId => $match) {
            $res['matches'][$objectId]['passage'] = $passage[$i++];
        }
    }

    /**
     * @param array $res
     */
    public function buildObjects($res)
    {
        $result = array();

        foreach ($res['matches'] as $match) {
            if (isset($match['attrs']['entity'])) {
                $object = $this->getObject($match['attrs']['entity'], $match['attrs']['object_id']);


                /** @var \SIP\ResourceBundle\Entity\Event $object */
                if ($object instanceof Event) {
                    $result[] = array(
                        'type'   => 'event',
                        'object' => $object
                    );
                }

                /** @var \SIP\ResourceBundle\Entity\News $object */
                if ($object instanceof News) {
                    $result[] = array(
                        'type'   => 'news',
                        'object' => $object
                    );
                }

                /** @var \SIP\ResourceBundle\Entity\Publishing $object */
                if ($object instanceof Publishing) {
                    $result[] = array(
                        'type'   => 'publishing',
                        'object' => $object
                    );
                }

                /** @var \SIP\ResourceBundle\Entity\Designer $object */
                if ($object instanceof Designer) {
                    $result[] = array(
                        'type'   => 'designer',
                        'object' => $object
                    );
                }

                /** @var \SIP\ResourceBundle\Entity\Manufacturer $object */
                if ($object instanceof Manufacturer) {
                    $result[] = array(
                        'type'   => 'manufacturer',
                        'object' => $object
                    );
                }
            }
        }

        return $result;
    }

    /**
     * @param string $entity
     * @param string $objectId
     * @return \SIP\SearchBundle\Model\SearchInterface
     */
    public function getObject($entity, $objectId)
    {
        $this->getDoctrine()->getRepository($entity);
        /** @var \Doctrine\ORM\EntityRepository $rep */
        $rep = $this->getDoctrine()->getRepository($entity);
        return $rep->findOneById($objectId);
    }

    /**
     * @return \SIP\SearchBundle\Services\Search\SphinxSearch
     */
    public function getSphinxSearch()
    {
        if (!$this->search) {
            $this->search = $this->container->get('search.sphinxsearch.search');
        }

        return $this->search;
    }

    /**
     * @return \Knp\Component\Pager\Paginator
     */
    public function getPaginator()
    {
        if (!$this->paginator) {
            $this->paginator = $this->container->get('knp_paginator');
        }

        return $this->paginator;
    }
}
