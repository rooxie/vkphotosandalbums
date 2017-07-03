<?php

namespace VkPhotosAndAlbums\Commands;

use Propel\Runtime\Exception\PropelException;
use Symfony\Component\Console\Helper\ProgressBar;
use VkPhotosAndAlbums\Models\Users;

class FetchUsersCommand extends BaseCommand
{
    protected $args = ['user-id' => []];

    protected function perform(): void
    {
        $users      = $this->vk()->getUsers($this->args['user-id']);
        $count      = count($users);

        $progress   = new ProgressBar($this->output, $count);

        foreach ($users as $user) {
            try {
                Users::create($user);
            } catch (PropelException $e) {}

            $progress->advance();
        }

        $progress->finish();
    }
}