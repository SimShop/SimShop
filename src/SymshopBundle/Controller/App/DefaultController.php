<?php

namespace SymshopBundle\Controller\App;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SymshopBundle:App/Default:index.html.twig');
    }
}
