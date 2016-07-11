<?php

namespace SymshopBundle\Controller\Admin;

use FOS\UserBundle\Controller\ResettingController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Csrf\CsrfToken;

class ResettingController extends BaseController
{
    public function requestAction()
    {
        return $this->render('SymshopBundle:Security/admin/reset:request.html.twig');
    }

    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username');

        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            return $this->render('SymshopBundle:Security/admin/reset:request.html.twig', array(
                'invalid_username' => $username
            ));
        }

        if ($user->isPasswordRequestNonExpired($this->getParameter('fos_user.resetting.token_ttl'))) {
            return $this->render('SymshopBundle:Security/admin/reset:passwordAlreadyRequested.html.twig');
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        return new RedirectResponse($this->generateUrl('admin_check_email',
            array('email' => $this->getObfuscatedEmail($user))
        ));
    }

    /**
     * Reset user password
     */
    public function resetAction(Request $request, $token)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"',
                $token));
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

//        if (null !== $event->getResponse()) {
//            return $event->getResponse();
//        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('admin_confirm_password_change');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_COMPLETED,
                new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('SymshopBundle:Security/admin/reset:reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }

    public function checkEmailAction(Request $request)
    {
        $email = $request->query->get('email');

        if (empty($email)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('admin_request'));
        }

        return $this->render('SymshopBundle:Security/admin/reset:checkEmail.html.twig', array(
            'email' => $email,
        ));
    }

    public function confirmPasswordChangeAction(Request $request)
    {
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('SymshopBundle:Security/admin/reset:confirm.html.twig');
        } else {
            return new RedirectResponse($this->generateUrl('admin_login'));
        }
    }
}
