<?php

namespace VkPhotosAndAlbums\Commands;


use Propel\Runtime\Exception\PropelException;
use Symfony\Component\Console\Helper\ProgressBar;
use VkPhotosAndAlbums\Models\User;

class FetchUsersCommand extends BaseCommand
{
    protected $args = ['user-id' => []];
    protected $usersInDb = [];

    protected function perform(): void
    {
        $users      = $this->vk()->getUsers($this->args['user-id']);
        $count      = count($users);

        $progress   = new ProgressBar($this->output, $count);

        foreach ($users as $user) {
            try {
                User::create($user);
            } catch (PropelException $e) {}

            $progress->advance();
        }

        $progress->finish();
    }
}