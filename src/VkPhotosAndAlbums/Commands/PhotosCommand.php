<?php

namespace VkPhotosAndAlbums\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VkPhotosAndAlbums\Models\PhotosQuery;
use VkPhotosAndAlbums\Models\UserQuery;

class PhotosCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getArgument('user-id');

        if (!$input->getOption('remote')) {
            $photos = PhotosQuery::create()->findByOwnerId($userId)->toArray();

            if ($photos) {
                $this->output($photos);
                return;
            }
        }
    }

    protected function output(array $data): void
    {

    }
}