<?php

namespace Pohy\QuoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pohy\QuoteBundle\Entity\Quote;

class DefaultController extends Controller
{
	// function __construct() {
 //    	$em = $this->getDoctrine()->getManager();

 //    	$quoteRepository = $em->getRepository('PohyQuoteBundle:Quote');
	// }

    /**
     * @Route("/", name="quote_index")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$quotes = $em->getRepository('PohyQuoteBundle:Quote')->findBy(
    		array('visible' => '1'),
    		array('creation' => 'DESC'));

        return array('quotes' => $quotes);
    }

    /**
     * @Route("/view/{id}", name="quote_view")
     * @Template()
     */
    public function viewAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$quote = $em->getRepository('PohyQuoteBundle:Quote')->find($id);

    	return array('quote' => $quote);
    }


    /**
     * @Route("/new", name="quote_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
    	$quote = new Quote();

    	$form = $this->createFormBuilder($quote)
    		->add('text', 'textarea')
    		->add('submit', 'submit')
    		->getForm();

    	$form->handleRequest($request);

    	if($form->isValid())
    	{
    		$em = $this->getDoctrine()->getEntityManager();

    		$quote = new Quote();
    		$quote->setText($form['text']->getData());
    		$quote->setCreation(new \DateTime());
    		$quote->setVisible('1');
    		//TODO user
    		$quote->setUserId('5');

    		$em->persist($quote);
    		$em->flush();

    		$this->get('session')->getFlashBag()->add('notice', 'New quote created');
    		return $this->redirect($this->generateUrl('quote_index'));
    	}

    	return array('form' => $form->createView());
    }
}
