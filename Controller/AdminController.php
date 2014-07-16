<?php

namespace ThreadAndMirror\SocialBundle\Controller;

// Dependencies
use Stems\CoreBundle\Controller\BaseAdminController,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

// Entities
use ThreadAndMirror\SocialBundle\Entity\FeedOwner;

class AdminController extends BaseAdminController
{
	protected $home = 'thread_admin_social_overview';

	/**
	 * Render the dialogue for the module's dashboard entry in the admin panel
	 */
	public function dashboardAction()
	{
		return $this->render('StemsSocialBundle:Admin:dashboard.html.twig', array());
	}

	/**
	 * Social media overview
	 */
	public function indexAction()
	{		
		return $this->render('StemsSocialBundle:Admin:index.html.twig', array());
	}

	/**
	 * Instagram feeds overview
	 */
	public function indexInstagramAction()
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
	 */
	public function updateInstagramFeedAction($id, Request $request)
	{
		// get the specified feed
		$em = $this->getDoctrine()->getEntityManager();
		$feed = $em->getRepository('StemsSocialBundle:InstagramFeed')->find($id);

		// get the images we've already downloaded
		$existing = array();
		foreach ($feed->getImages() as $image) {
			$existing[] = $image->getUrl();
		}

		// API variables
		$client = '1083901020';
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

			$request->getSession()->setFlash('success', 'The feed "'.$feed->getName().'" has been updated.');
			return $this->redirect($this->generateUrl('stems_admin_social_instagram_overview'));
		}
		catch (\Exception $e) 
		{
			$request->getSession()->setFlash('error', 'The feed "'.$feed->getName().'" wasn\'t updated as Instagram didn\'t respond. Please try again.');
			return $this->redirect($this->generateUrl('stems_admin_social_instagram_overview'));
		}
	}
}
