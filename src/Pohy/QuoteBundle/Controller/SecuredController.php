<?php

namespace Pohy\QuoteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pohy\QuoteBundle\Entity\User;
use Pohy\QuoteBundle\Entity\Role;
use Pohy\QuoteBundle\Form\UserType;

class SecuredController extends Controller
{
    /**
     * @Route("/register", name="quote_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();

        $form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $user->setCreateTime(new \DateTime());
            $user->setEmail('');

            $role = $em->getRepository('PohyQuoteBundle:Role')->findOneBy(array('role' => 'ROLE_USER'));
            // die(\Doctrine\Common\Util\Debug::dump($role[0]));
            $user->addRole($role);

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($form['password']->getData(), $user->getSalt());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();


            return $this->redirect($this->generateUrl('quote_login'));
        }
        $this->get('session')->getFlashBag()->add('notice', 'You have been successfuly signed up');
        return array('form' => $form->createView());
    }

    /**
     * @Route("/login", name="quote_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        // if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
        //     $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        // } else {
        //     $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        // }

        // return array(
        //     'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
        //     'error'         => $error
        // );
        $session = $request->getSession();

        if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        );
    }

    /**
     * @Route("/login/check", name="quote_login_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="quote_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
}
