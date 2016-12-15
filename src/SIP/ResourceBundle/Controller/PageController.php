<?php

namespace SIP\ResourceBundle\Controller;

use SIP\ResourceBundle\Entity\Page;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    /**
     * @Route("/{slug}", name="sip_staic_pages")
     * @Template()
     * @return array
     */
    public function indexAction($slug)
    {
        $page = $this->getDoctrine()
            ->getRepository('SIP\ResourceBundle\Entity\Page')
            ->findOneBySlug($slug);

        if($page) {
            return array(
                'page' => $page
            );
        } else {

            throw $this->createNotFoundException();
        }
    }

}