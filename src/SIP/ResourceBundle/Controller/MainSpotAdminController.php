<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MainSpotAdminController extends CRUDController
{
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        if ($this->admin->getObject(1)) {
            return $this->forward('SonataAdminBundle:CRUD:edit', array('id' => 1, '_sonata_admin' => $this->container->get('request')->get('_sonata_admin')));
        } else {
            return $this->forward('SonataAdminBundle:CRUD:create', array('_sonata_admin' => $this->container->get('request')->get('_sonata_admin')));
        }
    }

    protected function redirectTo($object)
    {
        $url = $this->admin->generateUrl('list');
        return new RedirectResponse($url);
    }
}