<?php

namespace SymshopBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    public function renderLogin(array $data)
    {
        $requestAttributes = $this->get('request_stack')->getCurrentRequest()->attributes;

        if ('admin_login' === $requestAttributes->get('_route')) {
            $template = sprintf('SymshopBundle:Security:admin/login/login.html.twig');
        } else {
            $template = sprintf('FOSUserBundle:Security:login.html.twig');
        }

        return $this->get('templating')->renderResponse($template, $data);
    }
}
