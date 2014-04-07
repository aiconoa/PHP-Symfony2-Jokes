<?php

namespace Aiconoa\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="aiconoa_app_home")
     */
    public function indexAction()
    {
        return $this->render('AiconoaAppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/page/{page}", name="aiconoa_app_page")
     */
    public function pageAction($page)
    {
        // here we do some very basic verification.
        // it might be interesting to maintain a dictionnary of authorized pages
        if($page == null) {
            throw new HttpException(404, "Cette page n'existe pas");
        }
        $templateName = $page.'.html.twig';

        try {
            $this->get('kernel')->locateResource('@AiconoaAppBundle/Resources/views/default/'.$templateName);
        } catch( \Exception $ex ) {
            throw new HttpException(404, "Cette page n'existe pas");
        }

        return $this->render('AiconoaAppBundle:Default:'.$templateName);
    }

}
