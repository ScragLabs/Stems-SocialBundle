<?php

namespace Stems\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use	Symfony\Component\Security\Core\SecurityContext;
use	Symfony\Component\HttpFoundation\RedirectResponse;
use	Symfony\Component\HttpFoundation\Response;
use	Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WidgetController extends Controller
{
	/**
	 * Renders the latest instagrams in a grid box, defaulting to the first feed
	 */
	public function instagramGridAction($id)
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
	public function instagramSliderAction($id)
	{
		// get the specified feed
		$em = $this->getDoctrine()->getEntityManager();
		$feed = $em->getRepository('StemsSocialBundle:InstagramFeed')->find($id);

	    return $this->render('StemsSocialBundle:Widget:instagramSlider.html.twig', array(
			'feed'			=> $feed,
		));
	}

	/**
	 * Holding page
	 *
	 * @Template()
	 */
	public function homepageFeatureAction()
	{
		$em   = $this->getDoctrine()->getManager();
		$feed = $em->getRepository('StemsSocialBundle:InstagramFeed')->find(1);

		$images = $feed->getImages()->toArray();
		$images = array_splice($images, 0, 16);

		return array(
			'images' => $images
		);
	}
}
