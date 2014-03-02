<?php

namespace Pohy\QuoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="quote_login")
	 * @Template()
	 */
	public function loginAction()
	{
		$request = $this->getRequest();
		$session = $request->getSession();

		if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
		{
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		}
		else
		{
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

		return array(
			'last_username' => $session->get(SecurityContext::LAST_USERNAME),
			'error' => $error
		);
	}

	/**
	 * @Route(name="quote_restricted")
	 */
	public function restrictedAction()
	{
		$this->get('session')->getFlashbag()->add('notice', 'You need to login to do that');
		return $this->redirect($this->generateUrl('quote_login'));
	}
}