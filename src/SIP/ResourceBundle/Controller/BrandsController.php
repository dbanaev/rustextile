<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BrandsController extends Controller
{
    /**
     * @Route("/brand/{slug}/{designer}", name="sip_resource_brand")
     * @Template()
     * @return array
     */
    public function brandAction($slug = null, $designer = null) {
        $em = $this->getDoctrine()->getManager();

        if($designer)
            $designer = $em->getRepository('SIP\ResourceBundle\Entity\Designer')->findOneBy(array('slug' => $designer));

        $brand = $em->getRepository('SIP\ResourceBundle\Entity\Brand')->findOneBy(array('slug' => $slug));
        $gallery = $em->getRepository('SIP\ResourceBundle\Entity\Media\BrandHasMedia')->findBy(array('brand' => $brand->getId()));

        return array(
            'designer' => $designer,
            'brand'    => $brand,
            'gallery'  => $gallery
        );
    }
}