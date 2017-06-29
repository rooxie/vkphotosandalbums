<?php

namespace VkPhotosAndAlbums\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VkPhotosAndAlbums\Models\UserQuery;

class PhotosCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getArgument('User Id');

        $user = UserQuery::create()->findById($userId);

        if ($user) {

        }
    }
}