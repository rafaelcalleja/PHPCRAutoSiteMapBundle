<?php

namespace RC\PHPCRAutoSiteMapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RCPHPCRAutoSiteMapBundle:Default:index.html.twig', array('name' => $name));
    }
}
