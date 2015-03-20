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

    }
}