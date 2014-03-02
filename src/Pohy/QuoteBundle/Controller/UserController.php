<?php

namespace Pohy\QuoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pohy\QuoteBundle\Form\UserType;
use Pohy\QuoteBundle\Entity\User;

class UserController extends Controller
{
	/**
	 * @Route("/register", name="quote_user_new")
	 * @Template()
	 */
	public function newAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = new User();

		$form = $this->createForm(new UserType(), $entity);

		$form->handleRequest($request);

		if($form->isValid())
		{
			$entity->setCreateTime(new \DateTime());
			$entity->setEmail('');
			$entity->setRole('');

			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('quote_index'));
		}

		return array('form' => $form->createView());
	}

	/**
	 * @Route("/login", name="quote_user_login")
	 * @Template()
	 */
	public function loginAction(Request $request)
	{
		return arrau();
	}
}