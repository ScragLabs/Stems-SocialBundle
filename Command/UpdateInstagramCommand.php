<?php

namespace Stems\SocialBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
        // load the necessary services
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        // get the products that have been out of stock for over a month and are not marked as expired
        $expiring = $em->getRepository('StemsSaleSirenBundle:Product')->getExpiringProducts();

        // mark as expired
        foreach ($expiring as $product) {
            $product->setExpired(new \DateTime());
            $em->persist($product);
        }

        // flush any remaining updated products and notify complete
        $em->flush();
        $output->writeln(count($expiring).' products marked as expired.');
    }
}