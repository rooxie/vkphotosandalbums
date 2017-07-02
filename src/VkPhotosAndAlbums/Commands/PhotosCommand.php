<?php

namespace VkPhotosAndAlbums\Commands;

class PhotosCommand extends BaseCommand
{
    protected $args = ['user-id' => []];
    protected $usersInDb = [];

    protected function perform(): void
    {
        $photos = $this->vk()->getPhotos(array_pop($this->args['user-id']));
    }

    protected function outputPhoto(array $photo): void
    {
        $this->output->writeln(PHP_EOL);
        $this->output->writeln('<info>Id: </info>' . $photo);
        $this->output->writeln('<info>First Name: </info>' . $user->getFirstName());
        $this->output->writeln('<info>Last Name: </info>' . $user->getLastName());
        $this->output->writeln('<info>Source: </info>' . $source);
    }
}