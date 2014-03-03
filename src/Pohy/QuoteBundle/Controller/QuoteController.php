<?php

namespace Pohy\QuoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pohy\QuoteBundle\Entity\Quote;
use Pohy\QuoteBundle\Form\QuoteType;

class QuoteController extends Controller
{
	/**
     * @Route("/quote/view/{id}", name="quote_view_id")
     * @Template()
     */
    public function viewIdAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$quote = $em->getRepository('PohyQuoteBundle:Quote')->find($id);

    	return array('quote' => $quote);
    }

    /**
     * @Route("/quote/user/{username}", name="quote_view_user")
     * @Template()
     */
    public function viewUserAction($username)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PohyQuoteBundle:User')->findOneBy(array('username' => $username));
        $quotes = $em->getRepository('PohyQuoteBundle:Quote')->findBy(array('userId' => $user->getId()));

        return array('quotes' => $quotes);
    }


    /**
     * @Route("/quote/new", name="quote_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
    	$quote = new Quote();

        $form = $this->createForm(new QuoteType(), $quote);

    	$form->handleRequest($request);

    	if($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();

    		$quote = new Quote();
    		$quote->setCreation(new \DateTime());
    		$quote->setVisible('1');
            $quote->setText($form['text']->getData());
    		//TODO user
    		$quote->setUserId($this->getUser());

    		$em->persist($quote);
    		$em->flush();

    		$this->get('session')->getFlashBag()->add('notice', 'New quote created');
    		return $this->redirect($this->generateUrl('quote_index'));
    	}

    	return array('form' => $form->createView());
    }

    /**
     * @Route("/quote/edit/{id}", name="quote_edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
    	$em = $this->getDoctrine()->getManager();

    	$quote = $em->getRepository('PohyQuoteBundle:Quote')->find($id);

        $form = $this->createForm(new QuoteType(), $quote);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em->persist($quote);
            $em->flush();

            return $this->redirect($this->generateUrl('quote_view', array('id' => $quote->getId())));
        }

    	return array(
    		'quote' => $quote,
            'form' => $form->createView()
    	);
    }

    /**
     * @Route("/quote/delete/{id}", name="quote_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quote = $em->getRepository('PohyQuoteBundle:Quote')->find($id);

        $quote->setVisible(false);

        $em->persist($quote);
        $em->flush();

        return $this->redirect($this->generateUrl('quote_index'));
    }
}