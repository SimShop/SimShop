<?php
/**
 * Created by PhpStorm.
 * User: Milutin Djukanovic
 * E-mail: milutin.djukanovic@gmail.com
 * Date: 3/7/2016
 * Time: 16:57
 */

namespace SymshopBundle\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $authorizationChecker;

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     * @param Router $router
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(Router $router, AuthorizationChecker $authorizationChecker) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        $response = null;
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN') || $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('symshop_admin'));
        } else if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('symshop_homepage'));
        }

        return $response;
    }
}