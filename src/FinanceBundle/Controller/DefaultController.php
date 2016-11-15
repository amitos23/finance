<?php

namespace FinanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
//        $securityContext = $this->container->get('security.authorization_checker');
//        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('FinanceBundle:Default:homepage.html.twig');
//        }else
//            return $this->render('FinanceBundle:Default:index.html.twig');
    }

}
