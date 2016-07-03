<?php

namespace AdminBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends BaseController
{
    public function renderLogin(array $data)
    {
        $requestAttributes = $this->get('request_stack')->getCurrentRequest()->attributes;

        if ('admin_login' === $requestAttributes->get('_route')) {
            $template = sprintf('AdminBundle:Login:login.html.twig');
        } else {
            $template = sprintf('FOSUserBundle:Security:login.html.twig');
        }

        return $this->get('templating')->renderResponse($template, $data);
    }
}
