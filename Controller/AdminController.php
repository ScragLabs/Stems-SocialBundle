<?php

namespace Stems\SocialBundle\Controller;

use Stems\CoreBundle\Controller\BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Stems\SocialBundle\Entity\InstagramImage;

/**
 * @Route("/admin/social")
 */
class AdminController extends BaseAdminController
{
	protected $home = 'stems_admin_social_overview';

	/**
	 * Render the dialogue for the module's dashboard entry in the admin panel
	 *
 	 * @Template()
	 */
	public function dashboardAction()
	{
		return $this->render('StemsSocialBundle:Admin:dashboard.html.twig', array());
	}

	/**
	 * Social media overview
	 *
	 * @Route("/")
	 * @Template()
	 */
	public function indexAction()
	{		
		return $this->render('StemsSocialBundle:Admin:index.html.twig', array());
	}

	/**
	 * Instagram feeds overview
	 * 
	 * @Route("/instagram")
	 * @Template()
	 */
	public function instagramIndexAction()
	{		
		// get all available feeds 
		$em = $this->getDoctrine()->getEntityManager();
		$feeds = $em->getRepository('StemsSocialBundle:InstagramFeed')->findBy(array('deleted' => false));

		return $this->render('StemsSocialBundle:Admin:instagramIndex.html.twig', array(
			'feeds' 	=> $feeds,
		));
	}

	/**
	 * Update the selected feed
	 *
	 * @Route("/instagram/feed/{id}/update")
	 */
	public function updateInstagramFeedAction($id, Request $request)
	{
		// Get the specified feed
		$em = $this->getDoctrine()->getEntityManager();
		$feed = $em->getRepository('StemsSocialBundle:InstagramFeed')->find($id);

		// Get the images we've already downloaded
		$existing = array();
		foreach ($feed->getImages() as $image) {
			$existing[] = $image->getUrl();
		}

		// API variables
		$client = '1525057261';
		$token = '1083901020.9cbc254.e7ee623c03a84528821c521ea0b008b8';
		$count = 64;
		$url = 'https://api.instagram.com/v1/users/'.$client.'/media/recent/?access_token='.$token.'&count='.$count;

		// use curl the get the feed data
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$json = curl_exec($ch);
		curl_close($ch); 

		// store the json data as an array for the view
		$json = json_decode($json);
   
		// sometime instagram won't send the response, so we need to catch it
		try
		{
			foreach ($json->data as $post) {
				// add the images we haven't already downloaded
				if (!in_array($post->link, $existing)) {

					$image = new InstagramImage($post, $feed);
					// automatically moderate images if the feed isn't set to manual moderation
					$feed->getModerated() or $image->setModerated(new \Datetime());
					$em->persist($image);	
				}
			}

			// update the feed too
			$feed->setUpdated(new \DateTime());
			$em->persist($feed);
			$em->flush();

			$request->getSession()->getFlashBag()->set('success', 'The feed "'.$feed->getName().'" has been updated.');
			return $this->redirect($this->generateUrl('stems_admin_social_instagram_overview'));
		}
		catch (\Exception $e) 
		{
			$request->getSession()->getFlashBag()->set('error', 'The feed "'.$feed->getName().'" wasn\'t updated as Instagram didn\'t respond. Please try again.');
			return $this->redirect($this->generateUrl('stems_admin_social_instagram_overview'));
		}
	}
}
