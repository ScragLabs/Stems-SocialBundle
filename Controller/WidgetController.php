<?php

namespace ThreadAndMirror\SocialBundle\Controller;

// Symfony Components
use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\Security\Core\SecurityContext,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

class WidgetController extends Controller
{
	/**
	 * Renders the latest instagrams in a grid box, defaulting to the first feed
	 */
	public function instagramGridAction($id=1)
	{
		// get the specified feed
		$em = $this->getDoctrine()->getEntityManager();
		$feed = $em->getRepository('StemsSocialBundle:InstagramFeed')->find($id);

	    return $this->render('StemsSocialBundle:Widget:instagramGrid.html.twig', array(
			'feed'			=> $feed,
		));
	}

	/**
	 * Renders the latest instagrams in a slider, defaulting to the first feed
	 */
	public function instagramSliderAction($id=1)
	{
		// get the specified feed
		$em = $this->getDoctrine()->getEntityManager();
		$feed = $em->getRepository('StemsSocialBundle:InstagramFeed')->find($id);

	    return $this->render('StemsSocialBundle:Widget:instagramSlider.html.twig', array(
			'feed'			=> $feed,
		));
	}
}
