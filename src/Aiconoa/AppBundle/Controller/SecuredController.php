<?php

namespace Aiconoa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecuredController extends Controller {

    /**
     * @Template()
     */
    public function loginAction(Request $request)
    {

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );

//        $session = $request->getSession();
//
//        if ($request->attributes->has(SC::AUTHENTICATION_ERROR)) {
//            $error = $request->attributes->get(
//                SC::AUTHENTICATION_ERROR
//            );
//        } else {
//            $error = $session->get(SC::AUTHENTICATION_ERROR);
//            $session->remove(SC::AUTHENTICATION_ERROR);
//        }
//
//        return array(
//            ’dernier_pseudo’ => $session->get(SC::LAST_USERNAME),
//            ’erreur’         => $error,
//        );
    }
} 