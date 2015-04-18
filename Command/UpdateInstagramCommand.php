<?php

namespace Stems\SocialBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Stems\SocialBundle\Entity\InstagramImage;

class UpdateInstagramCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('social:updateInstagram')
            ->setDescription('Pulls in any new instagrams for all active feeds.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	    // Get the specified feed
	    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
	    $feeds = $em->getRepository('StemsSocialBundle:InstagramFeed')->findAll();

	    foreach ($feeds as $feed) {

		    // Get the images we've already downloaded
		    $existing = array();
		    foreach ($feed->getImages() as $image) {
			    $existing[] = $image->getUrl();
		    }

		    // API variables
		    $client = '1083901020';
		    $token = '1083901020.9cbc254.e7ee623c03a84528821c521ea0b008b8';
		    $count = 128;
		    $url = 'https://api.instagram.com/v1/users/'.$client.'/media/recent/?access_token='.$token.'&count='.$count;

		    // Use curl the get the feed data
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		    $json = curl_exec($ch);
		    curl_close($ch);

		    // Store the json data as an array for the view
		    $json = json_decode($json);

		    // Sometime instagram won't send the response, so we need to catch it
//		    try
//		    {
			    foreach ($json->data as $post) {
				    // add the images we haven't already downloaded
				    if (!in_array($post->link, $existing)) {

					    $image = new InstagramImage($post, $feed);
					    // automatically moderate images if the feed isn't set to manual moderation
					    $feed->getModerated() or $image->setModerated(new \Datetime());
					    $em->persist($image);
				    }
			    }

			    // Update the feed too
			    $feed->setUpdated(new \DateTime());
			    $em->persist($feed);
			    $em->flush();

			    $output->writeln('The feed "'.$feed->getName().'" has been updated.');
//
//		    }
//		    catch (\Exception $e)
//		    {
//			    $output->writeln('The feed "'.$feed->getName().'" wasn\'t updated as Instagram didn\'t respond. Please try again.');
//		    }
	    }

    }
}