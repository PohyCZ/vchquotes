<?php

namespace Pohy\QuoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pohy\QuoteBundle\Entity\Quote;

class DefaultController extends Controller
{
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
}
